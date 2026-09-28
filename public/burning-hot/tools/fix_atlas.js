const fs = require('fs');
const https = require('https');

const baseUrl = 'https://gamscdn.com/web-v3/mfs/game-burning-hot/';

function download(url, dest) {
  return new Promise((resolve, reject) => {
    const file = fs.createWriteStream(dest);
    https.get(url, (response) => {
      if (response.statusCode >= 300 && response.statusCode < 400 && response.headers.location) {
        return download(response.headers.location, dest).then(resolve).catch(reject);
      }
      if (response.statusCode !== 200) {
        fs.unlink(dest, () => {});
        return reject(new Error('Status: ' + response.statusCode + ' for ' + url));
      }
      response.pipe(file);
      file.on('finish', () => {
        file.close(() => resolve(dest));
      });
    }).on('error', (err) => {
      fs.unlink(dest, () => {});
      reject(err);
    });
  });
}

async function fixAtlas() {
  const atlasFiles = fs.readdirSync('.').filter(x => x.endsWith('.atlas'));
  for (const af of atlasFiles) {
    let content = fs.readFileSync(af, 'utf8');
    const lines = content.split('\n');
    let changed = false;
    for (let i = 0; i < lines.length; i++) {
      let line = lines[i].trim();
      if (line.includes('.png') || line.includes('.jpg') || line.includes('.webp')) {
        let cleanName = line.split('?')[0];
        console.log(`Checking texture from ${af}: "${line}" -> "${cleanName}"`);
        if (!fs.existsSync(cleanName)) {
          console.log(`Downloading ${cleanName}...`);
          try {
            await download(baseUrl + cleanName, cleanName);
          } catch(e) {
            console.error('Failed to download', cleanName, e.message);
          }
        }
        // If line had query param like ?compress=false, strip it from atlas so Pixi spine can find it easily
        if (line !== cleanName) {
          lines[i] = cleanName;
          changed = true;
        }
      }
    }
    if (changed) {
      fs.writeFileSync(af, lines.join('\n'));
      console.log(`Updated atlas without query params: ${af}`);
    }
  }
}

fixAtlas().catch(console.error);
