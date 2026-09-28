const fs = require('fs');

const uiFiles = [
  'desktop-sheet-l.21849046d044.png',
  'stepper-panel.525405bb2845.png',
  'bet-btn.1a12209d9578.png',
  'btn.220a3dabdb4a.png',
  'input-bg.848f7b7be0a7.png',
  'input-cross.120e84c357a0.png',
  'autogame-btn.a847e514aa65.png',
  'popup-chains.d70228420934.png',
  'popup.4c0d0f00542c.png',
  'ui_stone@1x.03c691d70a3d.png',
  'text_field@1x.e6042bee27b6.png'
];

for (const f of uiFiles) {
  if (fs.existsSync(f)) {
    const stats = fs.statSync(f);
    console.log(`${f}: ${stats.size} bytes`);
  }
}
