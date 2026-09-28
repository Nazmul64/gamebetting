const fs = require('fs');

const d = JSON.parse(fs.readFileSync('desktop.scene.json', 'utf8'));
function findTex(node) {
  if (!node) return;
  if (node.texture && (node.texture.includes('play') || node.texture.includes('btn'))) {
    console.log(node.name, node.texture, node.x, node.y, node.width, node.height);
  }
  if (node.items) node.items.forEach(findTex);
  if (node.scene) node.scene.forEach(findTex);
}
findTex(d);
