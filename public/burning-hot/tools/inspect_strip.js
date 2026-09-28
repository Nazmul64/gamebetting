const fs = require('fs');

// Read PNG header for width and height
const buf = fs.readFileSync('coeff-sprite.1a64fe8ed11d.png');
const width = buf.readUInt32BE(16);
const height = buf.readUInt32BE(20);
console.log(`coeff-sprite: ${width}x${height}`);

// Check if we can make a copy called reel_strip.png
fs.copyFileSync('coeff-sprite.1a64fe8ed11d.png', 'reel_strip.png');
console.log('Copied to reel_strip.png!');
