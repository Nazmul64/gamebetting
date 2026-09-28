const fs = require('fs');

const skelFiles = fs.readdirSync('.').filter(x => x.endsWith('.skel'));
for (const sf of skelFiles) {
  const buf = fs.readFileSync(sf);
  // In Spine binary skel format, string representation often has spine version at early bytes or hash
  let ascii = '';
  for (let i = 0; i < Math.min(buf.length, 100); i++) {
    const c = buf[i];
    if (c >= 32 && c <= 126) ascii += String.fromCharCode(c);
    else ascii += '.';
  }
  console.log(`${sf} (${buf.length} bytes): ${ascii}`);
}
