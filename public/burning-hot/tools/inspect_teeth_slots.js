const fs = require('fs');

const buf = fs.readFileSync('teeth.skel');
let ascii = '';
for (let i = 0; i < buf.length; i++) {
  const c = buf[i];
  if (c >= 32 && c <= 126) ascii += String.fromCharCode(c);
  else ascii += ' ';
}
const words = ascii.match(/[a-zA-Z0-9_\/.-]{3,}/g) || [];
console.log('Teeth words/slots:', [...new Set(words)]);
