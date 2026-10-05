const fs = require('fs');
const path = require('path');

const indexHtml = fs.readFileSync('index.html', 'utf8');
const css = fs.readFileSync('assets/css/style.css', 'utf8');
const engineJs = fs.readFileSync('assets/js/engine.js', 'utf8');
const gameJs = fs.readFileSync('assets/js/game.js', 'utf8');

let bundleHtml = indexHtml
  .replace('<link rel="stylesheet" href="assets/css/style.css">', `<style>\n${css}\n</style>`)
  .replace('<script src="assets/js/engine.js"></script>', '')
  .replace('<script src="assets/js/game.js"></script>', `<script>\n${engineJs}\n${gameJs}\n</script>`);

fs.writeFileSync('preview.html', bundleHtml, 'utf8');
console.log('preview.html generated successfully.');
