const fs = require('fs');

function getPngSize(file) {
  const buf = fs.readFileSync(file);
  const w = buf.readUInt32BE(16);
  const h = buf.readUInt32BE(20);
  console.log(`${file}: ${w}x${h}`);
}

for (const f of [
  'play-btn.717cefcbbef9.png',
  'autogame-btn.a847e514aa65.png',
  'autogame-ico.9a49e93efeb9.png',
  'bet-btn.1a12209d9578.png',
  'btn.220a3dabdb4a.png',
  'input-bg.848f7b7be0a7.png',
  'input-cross.120e84c357a0.png',
  'ui_stone@1x.03c691d70a3d.png',
  'text_field@1x.e6042bee27b6.png',
  'stepper-panel.525405bb2845.png'
]) {
  if (fs.existsSync(f)) getPngSize(f);
}
