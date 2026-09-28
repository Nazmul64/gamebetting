const fs = require('fs');

// Inspect teeth.skel animation names
const buf = fs.readFileSync('teeth.skel');
let ascii = '';
for (let i = 0; i < buf.length; i++) {
  const c = buf[i];
  if (c >= 32 && c <= 126) ascii += String.fromCharCode(c);
  else ascii += ' ';
}
console.log('Teeth words:', ascii.match(/[a-zA-Z0-9_-]{3,}/g).filter(x => /idle|win|action|anim|teeth|down|up|open|close/i.test(x)));
