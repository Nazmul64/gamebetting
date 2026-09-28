const fs = require('fs');

const atlasFiles = fs.readdirSync('.').filter(x => x.endsWith('.atlas'));
for (const af of atlasFiles) {
  const content = fs.readFileSync(af, 'utf8');
  const lines = content.split('\n');
  for (const line of lines) {
    const trimmed = line.trim();
    if (trimmed.endsWith('.png') || trimmed.endsWith('.jpg') || trimmed.endsWith('.webp')) {
      console.log(af, '->', trimmed, fs.existsSync(trimmed) ? 'EXISTS' : 'MISSING');
    }
  }
}
