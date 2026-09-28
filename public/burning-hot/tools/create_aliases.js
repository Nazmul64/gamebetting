const fs = require('fs');

const mappings = [
  { prefix: 'dragon', skel: 'dragon.9aab165f0a84.skel', atlas: 'dragon@1x.png.75dfba314d48.atlas' },
  { prefix: 'knight', skel: 'knight.519368501ce4.skel', atlas: 'knight@1x.png.90ce49598d1c.atlas' },
  { prefix: 'fire', skel: 'fire.5afdf2ff8e29.skel', atlas: 'fire@1x.png.00d9163a1cc1.atlas' },
  { prefix: 'teeth', skel: 'teeth.9220a7329110.skel', atlas: 'teeth@1x.png.6ecfa535c52a.atlas' },
  { prefix: 'background_1', skel: 'background_1.1ebc46e336c3.skel', atlas: 'background_1@1x.png.6808766e5f2c.atlas' },
  { prefix: 'logo', skel: 'logo.ad6a402318be.skel', atlas: 'logo@1x.png.2a9cbe3e555f.atlas' },
  { prefix: 'bonus_glow', skel: 'bonus_glow.0eec250d9e60.skel', atlas: 'bonus_glow@1x.png.6df5d0f727d7.atlas' },
  { prefix: 'fallingstone', skel: 'fallingstone.a73136c14bdd.skel', atlas: 'fallingstone@1x.png.29c4da0316b9.atlas' },
  { prefix: 'apple', skel: 'apple.e396951cf3b5.skel', atlas: 'apple@1x.png.09957af714b0.atlas' },
  { prefix: 'banana', skel: 'banana.b2d39a662663.skel', atlas: 'banana@1x.png.c1128d6a2e05.atlas' },
  { prefix: 'cherry', skel: 'cherry.c23710fc79ea.skel', atlas: 'cherry@1x.png.6279cec58db6.atlas' },
  { prefix: 'dollar', skel: 'dollar.c607b92fe11e.skel', atlas: 'dollar@1x.png.1793249ec19a.atlas' },
  { prefix: 'grape', skel: 'grape.b4e6659fb802.skel', atlas: 'grape@1x.png.5acb7bf826ed.atlas' },
  { prefix: 'pear', skel: 'pear.e2eef8265809.skel', atlas: 'pear@1x.png.8a98a08bc598.atlas' },
  { prefix: 'pineapple', skel: 'pineapple.7126fe970f4e.skel', atlas: 'pineapple@1x.png.4dfa19f37a1e.atlas' },
  { prefix: 'seven', skel: 'seven.ee3fd3b03dd7.skel', atlas: 'seven@1x.png.dc2303cd40f1.atlas' },
  { prefix: 'star', skel: 'star.ff5df135fff8.skel', atlas: 'star@1x.png.ef5fc127e2fe.atlas' },
  { prefix: 'strawberry', skel: 'strawberry.6d958d050c1e.skel', atlas: 'strawberry@1x.png.a9027bc203df.atlas' },
  { prefix: 'wild', skel: 'wild.2b318a60de42.skel', atlas: 'wild@1x.png.1ee30da7672b.atlas' },
];

for (const m of mappings) {
  if (fs.existsSync(m.skel)) {
    fs.copyFileSync(m.skel, `${m.prefix}.skel`);
  }
  if (fs.existsSync(m.atlas)) {
    fs.copyFileSync(m.atlas, `${m.prefix}.atlas`);
  }
}
console.log('Created clean alias files for all skeletons and atlases!');
