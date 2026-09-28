const fs = require('fs');
const path = require('path');

function inspectSkel(file) {
  const buf = fs.readFileSync(file);
  const str = buf.toString('latin1');
  console.log(`=== Inspecting ${path.basename(file)} ===`);
  // Look for animation names
  const matches = str.match(/[\x20-\x7E]{3,30}/g) || [];
  const words = matches.filter(w => /^[a-zA-Z0-9_\-\.]+$/.test(w));
  console.log('Sample strings:', words.slice(0, 40));
}

inspectSkel(path.resolve(__dirname, '../assets/spines/king.skel'));
inspectSkel(path.resolve(__dirname, '../assets/spines/bg_fx.skel'));
