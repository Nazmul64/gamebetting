const fs = require('fs');

const files = fs.readdirSync('.').filter(f => f.endsWith('.png') || f.endsWith('.webp') || f.endsWith('.jpg') || f.endsWith('.json'));
console.log('Total files:', files.length);
console.log('UI files:', files.filter(f => /btn|sheet|stepper|popup|control|input|coeff/i.test(f)));
