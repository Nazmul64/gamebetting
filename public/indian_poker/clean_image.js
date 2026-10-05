const fs = require('fs');
const { PNG } = require('pngjs');

// Load original screenshot
const data = fs.readFileSync('assets/images/original_bg.png');
const png = PNG.sync.read(data);
const { width, height } = png;

function getPixel(x, y) {
  x = Math.max(0, Math.min(width - 1, Math.round(x)));
  y = Math.max(0, Math.min(height - 1, Math.round(y)));
  const idx = (width * y + x) << 2;
  return [png.data[idx], png.data[idx + 1], png.data[idx + 2], png.data[idx + 3]];
}

function setPixel(x, y, rgba) {
  if (x < 0 || x >= width || y < 0 || y >= height) return;
  const idx = (width * y + x) << 2;
  png.data[idx] = rgba[0];
  png.data[idx + 1] = rgba[1];
  png.data[idx + 2] = rgba[2];
  png.data[idx + 3] = rgba[3] !== undefined ? rgba[3] : 255;
}

// 1. Clean Top Left Breadcrumbs (x: 4-280, y: 4-28)
for (let y = 4; y <= 28; y++) {
  for (let x = 4; x <= 280; x++) {
    const sample = getPixel(x, 30);
    setPixel(x, y, [sample[0] * 0.85, sample[1] * 0.85, sample[2] * 0.85, 255]);
  }
}

// 2. Clean "Try again!" and "Place a bet!" text in center (x: 420-600, y: 95-138)
for (let y = 95; y <= 138; y++) {
  for (let x = 420; x <= 600; x++) {
    const pL = getPixel(410, y);
    const pR = getPixel(610, y);
    const u = (x - 420) / (600 - 420);
    const r = pL[0] * (1 - u) + pR[0] * u;
    const g = pL[1] * (1 - u) + pR[1] * u;
    const b = pL[2] * (1 - u) + pR[2] * u;
    setPixel(x, y, [r, g, b, 255]);
  }
}

// 3. Clean Cards Area (x: 365-645, y: 135-248)
for (let y = 135; y <= 248; y++) {
  for (let x = 365; x <= 645; x++) {
    const pL = getPixel(355, y);
    const pR = getPixel(655, y);
    const u = (x - 365) / (645 - 365);
    const r = pL[0] * (1 - u) + pR[0] * u;
    const g = pL[1] * (1 - u) + pR[1] * u;
    const b = pL[2] * (1 - u) + pR[2] * u;
    setPixel(x, y, [r, g, b, 255]);
  }
}

// Clean marble pedestal top surface (y: 249-274, x: 310-670)
for (let y = 249; y <= 274; y++) {
  for (let x = 310; x <= 670; x++) {
    const pL = getPixel(330, y);
    const pR = getPixel(650, y);
    const u = (x - 310) / (670 - 310);
    const r = pL[0] * (1 - u) + pR[0] * u;
    const g = pL[1] * (1 - u) + pR[1] * u;
    const b = pL[2] * (1 - u) + pR[2] * u;
    setPixel(x, y, [r, g, b, 255]);
  }
}

// 4. Clean Multiplier Badges Area (x: 340-670, y: 275-355)
for (let y = 275; y <= 355; y++) {
  for (let x = 340; x <= 670; x++) {
    const pL = getPixel(330, y);
    const pR = getPixel(680, y);
    const u = (x - 340) / (670 - 340);
    const r = pL[0] * (1 - u) + pR[0] * u;
    const g = pL[1] * (1 - u) + pR[1] * u;
    const b = pL[2] * (1 - u) + pR[2] * u;
    setPixel(x, y, [r, g, b, 255]);
  }
}

// 5. Completely Inpaint and Clean ALL DEMO MODE areas (x: 840-975, y: 270-340)
for (let y = 270; y <= 340; y++) {
  for (let x = 840; x <= 975; x++) {
    // Inpaint using water background on left (x=830) and floor/curtain on right (x=980)
    const pL = getPixel(830, y);
    const pR = getPixel(980, y);
    const u = (x - 840) / (975 - 840);
    const r = pL[0] * (1 - u) + pR[0] * u;
    const g = pL[1] * (1 - u) + pR[1] * u;
    const b = pL[2] * (1 - u) + pR[2] * u;
    setPixel(x, y, [r, g, b, 255]);
  }
}

// 6. Clean Bottom Control Bar inner boxes (x: 135-880, y: 375-430)
for (let y = 375; y <= 430; y++) {
  for (let x = 135; x <= 880; x++) {
    // smooth rich dark maroon velvet tone of the bar
    setPixel(x, y, [58, 14, 32, 255]);
  }
}

// 7. Clean Jackpot Box Text (x: 785-955, y: 20-52)
for (let y = 20; y <= 52; y++) {
  for (let x = 785; x <= 955; x++) {
    setPixel(x, y, [10, 10, 14, 255]);
  }
}

// Save clean background
const outBuf = PNG.sync.write(png);
fs.writeFileSync('assets/images/clean_bg.png', outBuf);
console.log('Successfully updated assets/images/clean_bg.png with all areas thoroughly cleaned!');
