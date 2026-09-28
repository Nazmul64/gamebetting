const fs = require('fs');
const https = require('https');
const path = require('path');

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

async function run() {
  console.log('Fetching manifests...');
  const commonManifestUrl = baseUrl + 'common.manifest.30e5bc705ae1.json';
  const desktopManifestUrl = baseUrl + 'desktop.manifest.59fb3dcf7de4.json';
  const sceneUrl = baseUrl + 'desktop.scene.d084d6dc42a9.json';

  await download(commonManifestUrl, 'common.manifest.json');
  await download(desktopManifestUrl, 'desktop.manifest.json');
  try { await download(sceneUrl, 'desktop.scene.json'); } catch(e){}

  const common = JSON.parse(fs.readFileSync('common.manifest.json'));
  const desktop = JSON.parse(fs.readFileSync('desktop.manifest.json'));

  const allFiles = new Set();
  function collect(obj) {
    if (obj.bundles) {
      for (const b of obj.bundles) {
        for (const a of b.assets) {
          if (typeof a.src === 'string') allFiles.add(a.src);
          else if (Array.isArray(a.src)) a.src.forEach(s => allFiles.add(s));
        }
      }
    }
  }
  collect(common);
  collect(desktop);

  console.log('Found assets in manifest:', allFiles.size);
  for (const f of allFiles) {
    try {
      console.log('Downloading:', f);
      await download(baseUrl + f, f);
    } catch(err) {
      console.error('Failed:', f, err.message);
    }
  }

  // Now inspect all .atlas files to find referenced textures
  const atlasFiles = fs.readdirSync('.').filter(x => x.endsWith('.atlas'));
  for (const af of atlasFiles) {
    const content = fs.readFileSync(af, 'utf8');
    const lines = content.split('\n');
    for (const line of lines) {
      const trimmed = line.trim();
      if (trimmed.endsWith('.png') || trimmed.endsWith('.jpg') || trimmed.endsWith('.webp')) {
        if (!fs.existsSync(trimmed)) {
          console.log('Downloading atlas texture:', trimmed);
          try {
            await download(baseUrl + trimmed, trimmed);
          } catch(e) {
            console.error('Failed texture:', trimmed, e.message);
          }
        }
      }
    }
  }
  console.log('All downloads completed!');
}

run().catch(console.error);
