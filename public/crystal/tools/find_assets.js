const https = require('https');
const fs = require('fs');

async function testDomains() {
  const cdnPrefixes = [
    'https://gamscdn.com/web-v3/mfs/game-crystal/',
    'https://gamscdn.com/web-v3/mfs/crystal/',
    'https://gamscdn.com/v3/games/crystal/',
    'https://v3.1xbet.com/games/crystal/',
    'https://1xlite-23113.pro/games/crystal/'
  ];
  
  for (const prefix of cdnPrefixes) {
    try {
      await new Promise((resolve) => {
        https.get(prefix + 'desktop.manifest.json', { timeout: 3000 }, (res) => {
          console.log(prefix, '->', res.statusCode);
          resolve();
        }).on('error', (e) => {
          console.log(prefix, '-> err:', e.message);
          resolve();
        });
      });
    } catch(e) {}
  }
}

testDomains();
