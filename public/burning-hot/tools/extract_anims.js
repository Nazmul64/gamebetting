const fs = require('fs');

const buf = fs.readFileSync('dragon.skel');
// In Spine binary skeleton format, let's find strings
const anims = [];
let i = 0;
// Scan for anim strings
const str = buf.toString('latin1');
const matches = str.match(/(idle|fire[a-zA-Z0-9_]*|win[a-zA-Z0-9_]*|lose[a-zA-Z0-9_]*|megawin[a-zA-Z0-9_]*)/g);
console.log('Spine animation names:', [...new Set(matches)]);
