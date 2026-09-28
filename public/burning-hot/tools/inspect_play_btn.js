const fs = require('fs');

const buf = fs.readFileSync('play-btn.717cefcbbef9.png');
const width = buf.readUInt32BE(16);
const height = buf.readUInt32BE(20);
console.log(`play-btn: ${width}x${height}`);
