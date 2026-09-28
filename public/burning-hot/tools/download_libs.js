const fs = require('fs');
const https = require('https');

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

async function getLibs() {
  console.log('Downloading libraries...');
  await download('https://cdn.jsdelivr.net/npm/pixi.js@7.4.2/dist/pixi.min.js', 'pixi.min.js');
  console.log('Downloaded pixi.min.js');
  await download('https://cdn.jsdelivr.net/npm/pixi-spine@4.0.6/dist/pixi-spine.js', 'pixi-spine.js');
  console.log('Downloaded pixi-spine.js');
  await download('https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', 'gsap.min.js');
  console.log('Downloaded gsap.min.js');
  await download('https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js', 'howler.min.js');
  console.log('Downloaded howler.min.js');
  console.log('Done downloading libs!');
}

getLibs().catch(console.error);
