const fs = require('fs');
const scene = JSON.parse(fs.readFileSync('desktop.scene.json'));

function extractItems(items) {
  for (const item of items) {
    console.log(`Name: ${item.name || item.type}, Type: ${item.type}, Texture/Skel: ${item.texture || ''}, x: ${item.x}, y: ${item.y}, scale: ${JSON.stringify(item.scale || 1)}`);
    if (item.items) extractItems(item.items);
  }
}

if (scene.scene) extractItems(scene.scene);
