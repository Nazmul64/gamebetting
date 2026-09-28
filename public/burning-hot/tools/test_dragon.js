const fs = require('fs');

const d = JSON.parse(fs.readFileSync('desktop.scene.json', 'utf8'));
function scan(node) {
  if (!node) return;
  if (node.name && (node.name.includes('dragon') || node.name.includes('knight') || node.name.includes('fire'))) {
    console.log(node.name, node.type, { x: node.x, y: node.y, scale: node.scale, sizeMap: node.sizeMap });
  }
  if (node.items) node.items.forEach(scan);
  if (node.scene) node.scene.forEach(scan);
}
scan(d);
