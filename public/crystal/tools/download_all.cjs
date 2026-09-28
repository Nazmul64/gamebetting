const fs = require('fs');
const https = require('https');
const path = require('path');

const baseUrl = 'https://gamscdn.com/web-v3/mfs/game-crystal/';
const destDir = path.resolve(__dirname, '../assets/origin');
const docDir = 'C:/Users/nazmu/OneDrive/Documents/Crystal';

if (!fs.existsSync(destDir)) fs.mkdirSync(destDir, { recursive: true });

function download(url, dest) {
  return new Promise((resolve, reject) => {
    const dir = path.dirname(dest);
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    
    const file = fs.createWriteStream(dest);
    https.get(url, { headers: { 'User-Agent': 'Mozilla/5.0' } }, (response) => {
      if (response.statusCode >= 300 && response.statusCode < 400 && response.headers.location) {
        return download(response.headers.location, dest).then(resolve).catch(reject);
      }
      if (response.statusCode !== 200) {
        fs.unlink(dest, () => {});
        return reject(new Error(`Status: ${response.statusCode} for ${url}`));
      }
      response.pipe(file);
      file.on('finish', () => {
        file.close(() => {
          console.log(`Downloaded: ${path.basename(dest)} (${fs.statSync(dest).size} bytes)`);
          resolve(dest);
        });
      });
    }).on('error', (err) => {
      fs.unlink(dest, () => {});
      reject(err);
    });
  });
}

const allManifestFiles = [
  // Common bundle
  "bubble.58e8e2d9bdea.skel",
  "bubble@1x.png.efc895583f09.atlas",
  "crystal.b5f9e717493c.skel",
  "crystal@1x.png.83baf7073419.atlas",
  "popup_win.4973c29cc5d1.skel",
  "popup_win@1x.png.8d925eeb2300.atlas",
  "symbols-0@1x.png.4835f86a5a3a.json",
  "symbols-0@1x.131de0d872a2.png",
  "win_list_common-0@1x.png.fe3879a7a7a0.json",
  "win_list_common-0@1x.ae486a8005ff.png",
  "yellow_elements-0@1x.png.8623622b9e38.json",
  "yellow_elements-0@1x.543721e1a5f6.png",
  "payout_vfx-0@1x.png.dc67d5a010d3.json",
  "payout_vfx-0@1x.c759476fb2ea.png",
  "crystals-0@1x.png.aae919ff2ef2.json",
  "crystals-0@1x.5b3769abed65.png",
  "no_compression_elements-0@1x.png.09ee475fe1fb.json",
  "no_compression_elements-0@1x.0d6033c9bf10.png",
  "clear-icon@1x.8b135280c729.png",
  "crystal-icon@1x.d782a97dfac1.png",
  "crystal-sprite@1x.260a0d81f6bf.svg",
  "music.6d01eb3eca54.json",
  "music.8c81a77ce58f.webm",
  "music.1e595ddaf4fb.mp3",
  "sounds.d11493d8d40e.json",
  "sounds.a73d7db4ca99.webm",
  "sounds.60e5c2da1b24.mp3",
  
  // Desktop bundle
  "reels-0@1x.png.e07a6f7ca1b8.json",
  "reels-0@1x.7da97e7a50b8.png",
  "colorless-0@1x.png.58ede7286342.json",
  "colorless-0@1x.1b0f4808823c.png",
  "win_list-0@1x.png.9aa72eabf9f5.json",
  "win_list-0@1x.dd36e452d8ef.png",
  "background_desktop@1x.d1292429645c.jpg",
  "bg_fx.c68069fd74e7.skel",
  "bg_fx@1x.png.ec88a64f113d.atlas",
  "king.dc852095b3ac.skel",
  "king@1x.png.74ec8bd5a823.atlas",
  "autobg@1x.537c72f37357.png",
  "autoplay-btn@1x.af129d5e8165.png",
  "autoplay-counter-decor@1x.f8d01326f92a.png",
  "autoplay-counter-disabled@1x.63f68fec05ad.png",
  "autoplay-counter-hover@1x.c469ff8c7059.png",
  "autoplay-counter@1x.7364593dc563.png",
  "autoplay-icon@1x.8f34ed40dd52.png",
  "bets@1x.2f4964eaac63.png",
  "btn-stop@1x.715d1b5fcae7.png",
  "crystal-flag@1x.194f56629fbb.png",
  "info@1x.ddc841b2db2b.png",
  "input-option@1x.c32873942969.png",
  "input@1x.535b905b7a30.png",
  "play@1x.ffd608e9eae2.png",
  "popup-close@1x.ddc841b2db2b.png",
  "popup-rules@1x.21c53dbfa014.png",
  "select-icon@1x.b85821434444.png",
  "skip-btn@1x.481de9ef8ead.png",
  "skip-icon@1x.dd287760047f.png",
  "symbols-counter-btn@1x.a3dc8b3126b8.png",
  "wild@1x.4bb42a526e16.png"
];

async function run() {
  console.log('Downloading all 1xBet Crystal files...');
  for (const f of allManifestFiles) {
    try {
      const destPath = path.join(destDir, f);
      await download(baseUrl + f, destPath);
      // Also copy to Documents/Crystal
      if (fs.existsSync(docDir)) {
        try {
          fs.copyFileSync(destPath, path.join(docDir, f));
        } catch(e) {}
      }
    } catch(err) {
      console.error(`Failed to download ${f}:`, err.message);
    }
  }

  // Parse all atlas files to find any additional referenced textures
  const atlasFiles = fs.readdirSync(destDir).filter(x => x.endsWith('.atlas'));
  for (const af of atlasFiles) {
    const content = fs.readFileSync(path.join(destDir, af), 'utf8');
    const lines = content.split('\n');
    for (const line of lines) {
      const trimmed = line.trim();
      if (trimmed.endsWith('.png') || trimmed.endsWith('.jpg') || trimmed.endsWith('.webp')) {
        const target = path.join(destDir, trimmed);
        if (!fs.existsSync(target)) {
          console.log('Downloading extra atlas texture:', trimmed);
          try {
            await download(baseUrl + trimmed, target);
            if (fs.existsSync(docDir)) {
              try { fs.copyFileSync(target, path.join(docDir, trimmed)); } catch(e) {}
            }
          } catch(e) {
            console.error('Failed texture:', trimmed, e.message);
          }
        }
      }
    }
  }

  console.log('All files downloaded successfully!');
}

run().catch(console.error);
