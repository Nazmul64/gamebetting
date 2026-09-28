const fs = require('fs');

// We can check the binary skeleton or spine runtime
console.log('Spine files present:');
const skelFiles = fs.readdirSync('.').filter(x => x.endsWith('.skel'));
console.log(skelFiles);

const atlasFiles = fs.readdirSync('.').filter(x => x.endsWith('.atlas'));
console.log('Atlas files present:', atlasFiles);
