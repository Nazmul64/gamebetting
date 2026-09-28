const fs = require('fs');
const path = require('path');

const originDir = path.resolve(__dirname, '../assets/origin');
const destSpinesDir = path.resolve(__dirname, '../assets/spines');
const destImagesDir = path.resolve(__dirname, '../assets/images');
const destAudioDir = path.resolve(__dirname, '../assets/audio');

if (!fs.existsSync(destSpinesDir)) fs.mkdirSync(destSpinesDir, { recursive: true });
if (!fs.existsSync(destImagesDir)) fs.mkdirSync(destImagesDir, { recursive: true });
if (!fs.existsSync(destAudioDir)) fs.mkdirSync(destAudioDir, { recursive: true });

// Copy all files with clean aliases
const files = fs.readdirSync(originDir);

files.forEach(f => {
  const full = path.join(originDir, f);
  // Spines
  if (f.endsWith('.skel') || f.endsWith('.atlas')) {
    fs.copyFileSync(full, path.join(destSpinesDir, f));
    // Also create clean alias (e.g. king.skel, king.atlas)
    const baseName = f.split('.')[0];
    const ext = f.endsWith('.skel') ? '.skel' : '.atlas';
    fs.copyFileSync(full, path.join(destSpinesDir, `${baseName}${ext}`));
  }
  // Audio
  if (f.endsWith('.mp3') || f.endsWith('.webm') || (f.startsWith('sounds.') && f.endsWith('.json')) || (f.startsWith('music.') && f.endsWith('.json'))) {
    fs.copyFileSync(full, path.join(destAudioDir, f));
    const baseName = f.split('.')[0];
    const ext = path.extname(f);
    fs.copyFileSync(full, path.join(destAudioDir, `${baseName}${ext}`));
  }
  // Images and JSON Spritesheets
  if (f.endsWith('.png') || f.endsWith('.jpg') || f.endsWith('.svg') || f.endsWith('.json')) {
    fs.copyFileSync(full, path.join(destImagesDir, f));
    fs.copyFileSync(full, path.join(destSpinesDir, f));
  }
});

console.log('Organized all assets into public/crystal/assets/(spines, images, audio)!');
