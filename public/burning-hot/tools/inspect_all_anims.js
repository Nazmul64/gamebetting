const fs = require('fs');

function inspectSkel(file) {
  const buf = fs.readFileSync(file);
  let ascii = '';
  for (let i = 0; i < buf.length; i++) {
    const c = buf[i];
    if (c >= 32 && c <= 126) ascii += String.fromCharCode(c);
    else ascii += ' ';
  }
  const words = ascii.match(/[a-zA-Z0-9_-]{3,}/g) || [];
  const anims = words.filter(w => /idle|win|lose|action|anim|megawin|fire|attack|start|stop|intro|loop/i.test(w));
  console.log(file, 'Animations found:', [...new Set(anims)]);
}

inspectSkel('dragon.skel');
inspectSkel('knight.skel');
inspectSkel('fire.skel');
inspectSkel('teeth.skel');
inspectSkel('logo.skel');
