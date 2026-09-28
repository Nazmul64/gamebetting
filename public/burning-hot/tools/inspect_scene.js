const fs = require('fs');
const scene = JSON.parse(fs.readFileSync('desktop.scene.json'));

console.log('Scene Keys:', Object.keys(scene));
console.log('Scene elements summary:');
function summarize(obj, depth = 0) {
  const indent = '  '.repeat(depth);
  if (Array.isArray(obj)) {
    obj.forEach((item, i) => summarize(item, depth));
  } else if (typeof obj === 'object' && obj !== null) {
    const name = obj.name || obj.id || obj.type || obj.alias || '';
    const pos = (obj.x !== undefined || obj.position) ? `pos: (${obj.x || obj.position?.x}, ${obj.y || obj.position?.y})` : '';
    const anim = obj.animation || obj.defaultAnimation || '';
    console.log(`${indent}- [${obj.type || 'obj'}] ${name} ${pos} ${anim ? 'anim:' + anim : ''}`);
    for (const k of ['children', 'layers', 'items', 'elements', 'spine', 'sprites']) {
      if (obj[k]) summarize(obj[k], depth + 1);
    }
  }
}
summarize(scene);
fs.writeFileSync('scene_summary.json', JSON.stringify(scene, null, 2));
