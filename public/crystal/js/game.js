// Crystal Slot Engine - 1xBet Official Cascading Engine
// Authentic Top-Down Royal Treasury, Animated Spine King, Real Wall Torch Flames, Sliced Symbols, & Cascading Avalanches

// Register GSAP PixiPlugin if available
if (typeof gsap !== 'undefined' && typeof PixiPlugin !== 'undefined') {
  gsap.registerPlugin(PixiPlugin);
  if (typeof PIXI !== 'undefined') {
    PixiPlugin.registerPIXI(PIXI);
  }
}

const ASSET_BASE = (typeof window !== 'undefined' && window.BURNING_HOT_BASE ? window.BURNING_HOT_BASE : (typeof window !== 'undefined' && window.location.pathname.includes('crystal') ? '/crystal/' : './')).replace(/\/+$/, '') + '/';

function getAssetPath(p) {
  if (!p) return p;
  if (p.startsWith('http://') || p.startsWith('https://') || p.startsWith('/')) return p;
  return ASSET_BASE + p;
}

const GEMS = [
  { id: 'red', name: 'Ruby', file: 'assets/images/symbols/red.png', glowFile: 'assets/images/symbols/red_b.png', mult: 2.0, color: 0xef4444, hexStr: '#ef4444' },
  { id: 'violet', name: 'Amethyst', file: 'assets/images/symbols/violet.png', glowFile: 'assets/images/symbols/violet_b.png', mult: 1.9, color: 0xa855f7, hexStr: '#a855f7' },
  { id: 'blue', name: 'Sapphire', file: 'assets/images/symbols/blue.png', glowFile: 'assets/images/symbols/blue_b.png', mult: 1.5, color: 0x3b82f6, hexStr: '#3b82f6' },
  { id: 'yellow', name: 'Topaz', file: 'assets/images/symbols/yellow.png', glowFile: 'assets/images/symbols/yellow_b.png', mult: 0.9, color: 0xeab308, hexStr: '#eab308' },
  { id: 'azure', name: 'Diamond', file: 'assets/images/symbols/azure.png', glowFile: 'assets/images/symbols/azure_b.png', mult: 0.8, color: 0x06b6d4, hexStr: '#06b6d4' },
  { id: 'green', name: 'Emerald', file: 'assets/images/symbols/green.png', glowFile: 'assets/images/symbols/green_b.png', mult: 0.5, color: 0x22c55e, hexStr: '#22c55e' },
  { id: 'wild', name: 'Wild Crown', file: 'assets/images/symbols/wild.png', glowFile: 'assets/images/symbols/wild_b.png', isWild: true, color: 0xffd700, hexStr: '#ffd700' }
];

const COLS = 7;
const ROWS = 7;
const CELL_SIZE = 70;
const GRID_X = 530;
const GRID_Y = 210;

let balance = 10000;
let totalWinnings = 0;
let betAmount = 20;
let isSpinning = false;
let isTurbo = false;
let isAutoPlay = false;
let autoSpinsLeft = 0;

let app;
let grid = []; // 7x7 2D array of sprite objects
let gridContainer, particlesContainer, paytableContainer, messageText;
let kingSpine = null, bubbleSpine = null;
let torchSpines = [], coinSparkles = [];
let betButtons = [], betInputLabel, turboBtnC, autoBtnC, playBtnC;
let multiplierRows = {};

window.setGameBalance = function (val) {
  balance = val;
  totalWinnings = 0;
  updateUILabel();
};

function updateUILabel() {
  const cardBal = document.getElementById('demo-card-balance');
  if (cardBal) cardBal.innerText = `${balance.toFixed(2)} BDT`;
  const cardWin = document.getElementById('demo-card-winnings');
  if (cardWin) cardWin.innerText = `${totalWinnings.toFixed(2)} BDT`;
}

function getRandomGem(includeWild = true) {
  const r = Math.random();
  if (includeWild && r < 0.05) return GEMS[6]; // Wild Crown (5%)
  if (r < 0.20) return GEMS[0]; // Red (2.0x)
  if (r < 0.35) return GEMS[1]; // Violet (1.9x)
  if (r < 0.50) return GEMS[2]; // Blue (1.5x)
  if (r < 0.65) return GEMS[3]; // Yellow (0.9x)
  if (r < 0.80) return GEMS[4]; // Azure (0.8x)
  return GEMS[5]; // Green (0.5x)
}

function setBet(amount) {
  betAmount = amount;
  betButtons.forEach(b => highlightBetBtn(b.btn, b.val === amount));
  if (betInputLabel) betInputLabel.text = amount.toString();
  updatePaytableDisplay(amount);
}

function highlightBetBtn(btnContainer, active) {
  const bg = btnContainer.getChildByName('bg');
  const label = btnContainer.getChildByName('label');
  if (active) {
    if (bg) bg.tint = 0xffe066;
    if (label) label.style.fill = 0x11021f;
  } else {
    if (bg) bg.tint = 0xd9a74a;
    if (label) label.style.fill = 0xffffff;
  }
}

function updatePaytableDisplay(currentBet) {
  GEMS.filter(g => !g.isWild).forEach(gem => {
    const row = multiplierRows[gem.id];
    if (row && row.payoutLabel) {
      const winVal = (currentBet * gem.mult).toFixed(1);
      row.payoutLabel.text = `${winVal} BDT`;
    }
  });
}

function resetPaytableHighlights() {
  Object.values(multiplierRows).forEach(row => {
    if (row.container) {
      if (row.bg) row.bg.alpha = 0.25;
      gsap.to(row.container.scale, { x: 1.0, y: 1.0, duration: 0.2 });
    }
  });
}

function highlightPaytableRow(gemId) {
  const row = multiplierRows[gemId];
  if (row) {
    if (row.bg) row.bg.alpha = 0.95;
    gsap.fromTo(row.container.scale, { x: 1.0, y: 1.0 }, { x: 1.08, y: 1.08, duration: 0.25, yoyo: true, repeat: 1 });
  }
}

// --- HELPER: PLAY SPINE ANIMATIONS SAFELY ---
function playSpine(spineObj, animNames, loop = false, trackIndex = 0) {
  if (!spineObj || !spineObj.state || !spineObj.spineData) return;
  const availableAnims = spineObj.spineData.animations.map(a => a.name);
  const found = animNames.find(name => availableAnims.includes(name));
  if (found) {
    try {
      spineObj.state.setAnimation(trackIndex, found, loop);
    } catch (e) {
      console.warn('Spine animation error:', e);
    }
  }
}

function startKingSleepAnimation() {
  if (kingSpine) {
    playSpine(kingSpine, ['idle', 'sleep', 'loop'], true);
  }
  if (bubbleSpine) {
    playSpine(bubbleSpine, ['idle', 'loop', 'win'], true);
    bubbleSpine.visible = true;
  }
}

function playKingWinCelebration() {
  if (kingSpine) {
    playSpine(kingSpine, ['win', 'action', 'idle'], false);
  }
  if (bubbleSpine) {
    bubbleSpine.visible = false;
  }
  spawnKingAuraSparkles();
  gsap.delayedCall(2.8, () => {
    if (!isSpinning) {
      startKingSleepAnimation();
    }
  });
}

function spawnKingAuraSparkles() {
  if (!particlesContainer) return;
  for (let i = 0; i < 22; i++) {
    const star = new PIXI.Graphics();
    star.beginFill(0xffd700, 0.95);
    star.drawCircle(0, 0, 3 + Math.random() * 5);
    star.endFill();
    star.x = 260 + (Math.random() - 0.5) * 220;
    star.y = 740 + (Math.random() - 0.5) * 180;
    particlesContainer.addChild(star);

    const destX = star.x + (Math.random() - 0.5) * 240;
    const destY = star.y - 50 - Math.random() * 120;
    const dur = 0.7 + Math.random() * 0.6;

    gsap.to(star, {
      x: destX,
      y: destY,
      alpha: 0,
      duration: dur,
      ease: 'power1.out',
      onComplete: () => particlesContainer.removeChild(star)
    });
    gsap.to(star.scale, {
      x: 0.1,
      y: 0.1,
      duration: dur,
      ease: 'power1.out'
    });
  }
}

function spawnGoldCoinShower() {
  if (!particlesContainer) return;
  for (let i = 0; i < 35; i++) {
    const coin = new PIXI.Graphics();
    coin.beginFill(0xffd700, 0.95);
    coin.lineStyle(1.5, 0xffa500, 0.9);
    coin.drawEllipse(0, 0, 8 + Math.random() * 4, 6 + Math.random() * 3);
    coin.endFill();
    coin.x = 775 + (Math.random() - 0.5) * 400;
    coin.y = 150 + Math.random() * 50;
    particlesContainer.addChild(coin);

    const destY = 700 + Math.random() * 250;
    const destX = coin.x + (Math.random() - 0.5) * 300;
    const dur = 1.0 + Math.random() * 0.8;

    gsap.to(coin, {
      x: destX,
      y: destY,
      rotation: (Math.random() - 0.5) * 15,
      alpha: 0,
      duration: dur,
      ease: 'power2.in',
      onComplete: () => particlesContainer.removeChild(coin)
    });
  }
}

// --- CLUSTER WIN EVALUATION ALGORITHM (MIN 5 CONNECTED SAME COLOR) ---
function findClusters() {
  const visited = Array.from({ length: ROWS }, () => Array(COLS).fill(false));
  const clusters = [];

  for (let r = 0; r < ROWS; r++) {
    for (let c = 0; c < COLS; c++) {
      if (!visited[r][c] && grid[r][c]) {
        const targetGem = grid[r][c].gemData;
        const currentCluster = [];
        const queue = [{ r, c }];
        visited[r][c] = true;

        while (queue.length > 0) {
          const curr = queue.shift();
          currentCluster.push(curr);

          const neighbors = [
            { r: curr.r - 1, c: curr.c },
            { r: curr.r + 1, c: curr.c },
            { r: curr.r, c: curr.c - 1 },
            { r: curr.r, c: curr.c + 1 }
          ];

          for (const nb of neighbors) {
            if (nb.r >= 0 && nb.r < ROWS && nb.c >= 0 && nb.c < COLS) {
              if (!visited[nb.r][nb.c] && grid[nb.r][nb.c]) {
                const nbGem = grid[nb.r][nb.c].gemData;
                if (targetGem.isWild) {
                  if (nbGem.id === targetGem.id || !nbGem.isWild) {
                    visited[nb.r][nb.c] = true;
                    queue.push(nb);
                  }
                } else {
                  if (nbGem.id === targetGem.id || nbGem.isWild) {
                    visited[nb.r][nb.c] = true;
                    queue.push(nb);
                  }
                }
              }
            }
          }
        }

        const effectiveGem = targetGem.isWild ? GEMS[0] : targetGem;
        if (currentCluster.length >= 5) {
          clusters.push({
            gem: effectiveGem,
            count: currentCluster.length,
            cells: currentCluster
          });
        }
      }
    }
  }

  return clusters;
}

// --- SHATTER CRYSTAL PARTICLE EXPLOSION ---
function createShatterParticles(cx, cy, color) {
  for (let i = 0; i < 20; i++) {
    const p = new PIXI.Graphics();
    p.beginFill(color, 0.95);
    const size = 4 + Math.random() * 6;
    p.drawPolygon([
      -size, 0,
      0, -size * 1.3,
      size, 0,
      0, size * 1.3
    ]);
    p.endFill();
    p.x = cx;
    p.y = cy;
    particlesContainer.addChild(p);

    const angle = Math.random() * Math.PI * 2;
    const speed = 50 + Math.random() * 110;
    const destX = cx + Math.cos(angle) * speed;
    const destY = cy + Math.sin(angle) * speed + 25;
    const pDur = isTurbo ? 0.25 : 0.45;

    gsap.to(p, {
      x: destX,
      y: destY,
      rotation: (Math.random() - 0.5) * 10,
      alpha: 0,
      duration: pDur,
      ease: 'power2.out',
      onComplete: () => particlesContainer.removeChild(p)
    });
    gsap.to(p.scale, {
      x: 0.1,
      y: 0.1,
      duration: pDur,
      ease: 'power2.out'
    });
  }
}

// --- POPULATE INITIAL BOARD ---
function populateInitialGrid() {
  for (let r = 0; r < ROWS; r++) {
    grid[r] = [];
    for (let c = 0; c < COLS; c++) {
      const gem = getRandomGem(true);
      const sprite = createGemSprite(gem, r, c);
      grid[r][c] = sprite;
      gridContainer.addChild(sprite);
    }
  }
}

function createGemSprite(gemData, r, c) {
  const sprite = new PIXI.Sprite(PIXI.Assets.get(gemData.file));
  sprite.anchor.set(0.5);
  sprite.width = CELL_SIZE - 6;
  sprite.height = CELL_SIZE - 6;
  sprite.x = GRID_X + c * CELL_SIZE + CELL_SIZE / 2;
  sprite.y = GRID_Y + r * CELL_SIZE + CELL_SIZE / 2;
  sprite.gemData = gemData;
  return sprite;
}

// --- SPIN ACTION & CASCADING STEPPER ---
async function startSpin() {
  if (isSpinning) return;

  if (balance < betAmount) {
    if (messageText) messageText.text = '⚠️ Insufficient Balance!';
    return;
  }

  isSpinning = true;
  balance -= betAmount;
  updateUILabel();
  resetPaytableHighlights();

  if (window.audio) {
    window.audio.init();
    window.audio.startMusic();
    window.audio.playSpin();
  }

  if (messageText) messageText.text = '✨ Crystals Shuffling...';

  const dropPromises = [];
  for (let r = ROWS - 1; r >= 0; r--) {
    for (let c = 0; c < COLS; c++) {
      const sprite = grid[r][c];
      if (sprite) {
        dropPromises.push(
          new Promise(res => {
            const dur = isTurbo ? 0.14 : 0.22;
            gsap.to(sprite, {
              y: GRID_Y + ROWS * CELL_SIZE + 60,
              alpha: 0,
              duration: dur,
              delay: (c + (ROWS - 1 - r)) * 0.012,
              ease: 'power2.in',
              onComplete: () => {
                gridContainer.removeChild(sprite);
                res();
              }
            });
          })
        );
      }
    }
  }

  await Promise.all(dropPromises);
  grid = [];

  for (let r = 0; r < ROWS; r++) {
    grid[r] = [];
    for (let c = 0; c < COLS; c++) {
      const gem = getRandomGem(true);
      const sprite = createGemSprite(gem, r, c);
      sprite.y = GRID_Y - (ROWS - r) * CELL_SIZE;
      sprite.alpha = 1;
      grid[r][c] = sprite;
      gridContainer.addChild(sprite);

      gsap.to(sprite, {
        y: GRID_Y + r * CELL_SIZE + CELL_SIZE / 2,
        duration: isTurbo ? 0.20 : 0.38,
        delay: c * 0.035 + r * 0.025,
        ease: 'bounce.out'
      });
    }
  }

  await new Promise(res => setTimeout(res, isTurbo ? 300 : 650));

  let spinWinnings = 0;
  let cascadeStep = 0;

  while (true) {
    const clusters = findClusters();
    if (clusters.length === 0) break;

    cascadeStep++;
    let stepWin = 0;

    clusters.forEach(cl => {
      const winForCluster = betAmount * cl.gem.mult * (1 + (cl.count - 5) * 0.2);
      stepWin += winForCluster;
      highlightPaytableRow(cl.gem.id);
    });

    spinWinnings += stepWin;
    balance += stepWin;
    totalWinnings += stepWin;
    updateUILabel();

    if (messageText) {
      messageText.text = `🎉 COMBO x${cascadeStep}! WON ${spinWinnings.toFixed(1)} BDT! 🎉`;
    }

    if (window.audio) {
      window.audio.playGlassShatter();
      window.audio.playWinChord(cascadeStep);
    }

    playKingWinCelebration();

    const shatterPromises = [];
    const removedCells = new Set();

    clusters.forEach(cl => {
      cl.cells.forEach(pos => {
        const key = `${pos.r},${pos.c}`;
        if (!removedCells.has(key) && grid[pos.r][pos.c]) {
          removedCells.add(key);
          const sprite = grid[pos.r][pos.c];

          shatterPromises.push(
            new Promise(res => {
              createShatterParticles(sprite.x, sprite.y, cl.gem.color);
              gsap.to(sprite.scale, {
                x: 0,
                y: 0,
                duration: isTurbo ? 0.12 : 0.22,
                ease: 'back.in(2)',
                onComplete: () => {
                  gridContainer.removeChild(sprite);
                  grid[pos.r][pos.c] = null;
                  res();
                }
              });
            })
          );
        }
      });
    });

    await Promise.all(shatterPromises);

    const dropMovePromises = [];
    for (let c = 0; c < COLS; c++) {
      let emptyRow = ROWS - 1;
      for (let r = ROWS - 1; r >= 0; r--) {
        if (grid[r][c] !== null) {
          if (r !== emptyRow) {
            const sprite = grid[r][c];
            grid[emptyRow][c] = sprite;
            grid[r][c] = null;

            dropMovePromises.push(
              new Promise(res => {
                gsap.to(sprite, {
                  y: GRID_Y + emptyRow * CELL_SIZE + CELL_SIZE / 2,
                  duration: isTurbo ? 0.18 : 0.32,
                  ease: 'bounce.out',
                  onComplete: res
                });
              })
            );
          }
          emptyRow--;
        }
      }

      for (let r = emptyRow; r >= 0; r--) {
        const gem = getRandomGem(true);
        const sprite = createGemSprite(gem, r, c);
        sprite.y = GRID_Y - (emptyRow - r + 1) * CELL_SIZE;
        grid[r][c] = sprite;
        gridContainer.addChild(sprite);

        dropMovePromises.push(
          new Promise(res => {
            gsap.to(sprite, {
              y: GRID_Y + r * CELL_SIZE + CELL_SIZE / 2,
              duration: isTurbo ? 0.22 : 0.40,
              delay: (emptyRow - r) * 0.04,
              ease: 'bounce.out',
              onComplete: res
            });
          })
        );
      }
    }

    await Promise.all(dropMovePromises);
    await new Promise(res => setTimeout(res, isTurbo ? 180 : 350));
  }

  if (spinWinnings > 0) {
    if (window.audio) window.audio.playCoinShower();
    spawnGoldCoinShower();
    if (messageText) messageText.text = `🏆 TOTAL WIN: ${spinWinnings.toFixed(1)} BDT!`;
  } else {
    if (messageText) messageText.text = 'Press the Play button';
  }

  isSpinning = false;

  if (isAutoPlay && autoSpinsLeft > 0) {
    autoSpinsLeft--;
    if (autoSpinsLeft > 0) {
      setTimeout(startSpin, isTurbo ? 350 : 800);
    } else {
      isAutoPlay = false;
      if (autoBtnC) autoBtnC.tint = 0xffffff;
    }
  }
}

// --- INIT MAIN PIXI APPLICATION ---
window.addEventListener('DOMContentLoaded', async () => {
  const loadingScreen = document.getElementById('loading-overlay') || document.getElementById('loading-screen');
  const progressBar = document.getElementById('loader-fill') || document.getElementById('loading-bar-fill');
  const progressText = document.getElementById('loader-text') || document.getElementById('loading-text');

  function updateProgress(percent, msg) {
    if (progressBar) progressBar.style.width = `${percent}%`;
    if (progressText) progressText.innerText = msg || `Loading Assets (${percent}%)...`;
  }

  try {
    updateProgress(20, 'Loading Official Game Graphics (20%)...');

    const imageAssets = [
      'assets/images/background_desktop@1x.d1292429645c.jpg',
      'assets/images/background.png',
      'assets/images/king_sleep.png',
      'assets/images/king_awake.png',
      'assets/images/torch.png',
      'assets/images/logo_crystal.png',
      'assets/images/logo.png',
      'assets/images/play@1x.ffd608e9eae2.png',
      'assets/images/bets@1x.2f4964eaac63.png',
      'assets/images/autoplay-btn@1x.af129d5e8165.png',
      'assets/images/skip-btn@1x.481de9ef8ead.png',
      // Official Sliced Symbols
      'assets/images/symbols/red.png',
      'assets/images/symbols/red_b.png',
      'assets/images/symbols/violet.png',
      'assets/images/symbols/violet_b.png',
      'assets/images/symbols/green.png',
      'assets/images/symbols/green_b.png',
      'assets/images/symbols/azure.png',
      'assets/images/symbols/azure_b.png',
      'assets/images/symbols/blue.png',
      'assets/images/symbols/blue_b.png',
      'assets/images/symbols/yellow.png',
      'assets/images/symbols/yellow_b.png',
      'assets/images/symbols/wild.png',
      'assets/images/symbols/wild_b.png',
      // Official UI
      'assets/images/ui/reels_desktop_background.png',
      'assets/images/ui/ribbon_background.png',
      'assets/images/ui/flag_frame.png',
      'assets/images/ui/flag_background.png',
      'assets/images/ui/payout_background_color.png',
      'assets/images/ui/logo.png'
    ];

    for (let i = 0; i < imageAssets.length; i++) {
      const fullSrc = getAssetPath(imageAssets[i]);
      PIXI.Assets.add({ alias: imageAssets[i], src: fullSrc });
    }

    await PIXI.Assets.load(imageAssets);

    updateProgress(50, 'Loading Animated Spine Characters...');

    // Load Spine models
    let kingRes = null, bgFxRes = null, bubbleRes = null;
    try {
      PIXI.Assets.add({ alias: 'kingSkel', src: getAssetPath('assets/spines/king.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/king@1x.atlas') } });
      PIXI.Assets.add({ alias: 'bgFxSkel', src: getAssetPath('assets/spines/bg_fx.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/bg_fx@1x.atlas') } });
      PIXI.Assets.add({ alias: 'bubbleSkel', src: getAssetPath('assets/spines/bubble.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/bubble@1x.atlas') } });

      [kingRes, bgFxRes, bubbleRes] = await Promise.all([
        PIXI.Assets.load('kingSkel').catch(e => null),
        PIXI.Assets.load('bgFxSkel').catch(e => null),
        PIXI.Assets.load('bubbleSkel').catch(e => null)
      ]);
    } catch (spineErr) {
      console.warn('Spine loading fallback:', spineErr);
    }

    updateProgress(85, 'Assembling Royal Throne Room...');

    app = new PIXI.Application({
      view: document.getElementById('game-canvas'),
      width: 1920,
      height: 1080,
      backgroundColor: 0x07010e,
      antialias: true,
      resolution: Math.min(window.devicePixelRatio || 1, 2),
      autoDensity: true
    });

    // --- LAYER 0: TOP-DOWN ROYAL TREASURY BACKGROUND ---
    const bgLayer = new PIXI.Container();
    app.stage.addChild(bgLayer);

    const bgTex = PIXI.Assets.get('assets/images/background_desktop@1x.d1292429645c.jpg') || PIXI.Assets.get('assets/images/background.png');
    const bgSprite = new PIXI.Sprite(bgTex);
    bgSprite.x = 0;
    bgSprite.y = 0;
    bgSprite.width = 1920;
    bgSprite.height = 1080;
    bgLayer.addChild(bgSprite);

    // Wall Torch Spines (Left Pillar & Right Door)
    if (bgFxRes && bgFxRes.spineData) {
      const torchL = new PIXI.spine.Spine(bgFxRes.spineData);
      torchL.x = 320;
      torchL.y = 360;
      torchL.scale.set(0.85);
      playSpine(torchL, ['idle', 'loop'], true);
      bgLayer.addChild(torchL);

      const torchR1 = new PIXI.spine.Spine(bgFxRes.spineData);
      torchR1.x = 1585;
      torchR1.y = 295;
      torchR1.scale.set(0.85);
      playSpine(torchR1, ['idle', 'loop'], true);
      bgLayer.addChild(torchR1);

      const torchR2 = new PIXI.spine.Spine(bgFxRes.spineData);
      torchR2.x = 1585;
      torchR2.y = 610;
      torchR2.scale.set(0.85);
      playSpine(torchR2, ['idle', 'loop'], true);
      bgLayer.addChild(torchR2);
    }

    // --- LAYER 1: ANIMATED KING CHARACTER (LOWER LEFT) ---
    const kingLayer = new PIXI.Container();
    app.stage.addChild(kingLayer);

    if (kingRes && kingRes.spineData) {
      kingSpine = new PIXI.spine.Spine(kingRes.spineData);
      kingSpine.x = 290;
      kingSpine.y = 760;
      kingSpine.scale.set(0.78);
      playSpine(kingSpine, ['idle', 'sleep', 'loop'], true);
      kingLayer.addChild(kingSpine);

      if (bubbleRes && bubbleRes.spineData) {
        bubbleSpine = new PIXI.spine.Spine(bubbleRes.spineData);
        bubbleSpine.x = 320;
        bubbleSpine.y = 640;
        bubbleSpine.scale.set(0.75);
        playSpine(bubbleSpine, ['idle', 'loop', 'win'], true);
        kingLayer.addChild(bubbleSpine);
      }
    } else {
      // Fallback Sprite
      const kingSprite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/king_sleep.png') || PIXI.Assets.get('assets/images/king.png'));
      kingSprite.anchor.set(0.5);
      kingSprite.x = 290;
      kingSprite.y = 680;
      kingSprite.scale.set(0.55);
      kingLayer.addChild(kingSprite);
    }

    // --- LAYER 2: 3D CRYSTAL LOGO EMBLEM (TOP RIGHT ABOVE CARPET) ---
    const logoLayer = new PIXI.Container();
    app.stage.addChild(logoLayer);

    const logoTex = PIXI.Assets.get('assets/images/ui/logo.png') || PIXI.Assets.get('assets/images/logo_crystal.png');
    if (logoTex) {
      const logoEmblem = new PIXI.Sprite(logoTex);
      logoEmblem.anchor.set(0.5);
      logoEmblem.x = 1275;
      logoEmblem.y = 155;
      logoEmblem.scale.set(0.76);
      logoLayer.addChild(logoEmblem);

      gsap.to(logoEmblem.scale, {
        x: 0.79,
        y: 0.79,
        duration: 2.0,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });
    }

    // --- LAYER 3: 7x7 CASCADING BOARD & OUTER GOLD FRAME ---
    const boardLayer = new PIXI.Container();
    app.stage.addChild(boardLayer);

    // Dark semi-transparent grid background
    const gridBg = new PIXI.Graphics();
    gridBg.beginFill(0x130724, 0.88);
    gridBg.lineStyle(4, 0xd4af37, 1);
    gridBg.drawRoundedRect(GRID_X - 14, GRID_Y - 14, COLS * CELL_SIZE + 28, ROWS * CELL_SIZE + 28, 14);
    gridBg.endFill();
    boardLayer.addChild(gridBg);

    // Individual cell background tiles
    for (let r = 0; r < ROWS; r++) {
      for (let c = 0; c < COLS; c++) {
        const tile = new PIXI.Graphics();
        tile.beginFill(0x220e3d, 0.45);
        tile.lineStyle(1, 0x5a2d8a, 0.3);
        tile.drawRoundedRect(GRID_X + c * CELL_SIZE + 3, GRID_Y + r * CELL_SIZE + 3, CELL_SIZE - 6, CELL_SIZE - 6, 6);
        tile.endFill();
        boardLayer.addChild(tile);
      }
    }

    gridContainer = new PIXI.Container();
    boardLayer.addChild(gridContainer);

    particlesContainer = new PIXI.Container();
    boardLayer.addChild(particlesContainer);

    // Top Header Status Banner
    const topBannerC = new PIXI.Container();
    topBannerC.x = 775;
    topBannerC.y = 150;
    boardLayer.addChild(topBannerC);

    const msgPlate = new PIXI.Graphics();
    msgPlate.beginFill(0xffffff, 0.96);
    msgPlate.lineStyle(3, 0xd4af37, 1);
    msgPlate.drawRoundedRect(-220, -20, 440, 40, 20);
    msgPlate.endFill();
    topBannerC.addChild(msgPlate);

    messageText = new PIXI.Text('Press the Play button', {
      fontFamily: 'Montserrat',
      fontSize: 18,
      fontWeight: '900',
      fill: 0x1f0b3b
    });
    messageText.anchor.set(0.5);
    topBannerC.addChild(messageText);

    // --- LAYER 4: MULTIPLIER PAYTABLE (RIGHT SIDE) ---
    paytableContainer = new PIXI.Container();
    paytableContainer.x = 1060;
    paytableContainer.y = 440;
    app.stage.addChild(paytableContainer);

    const tableBg = new PIXI.Graphics();
    tableBg.beginFill(0x15072b, 0.90);
    tableBg.lineStyle(2.5, 0xd4af37, 0.85);
    tableBg.drawRoundedRect(0, 0, 280, 260, 12);
    tableBg.endFill();
    paytableContainer.addChild(tableBg);

    const regularGems = GEMS.filter(g => !g.isWild);
    regularGems.forEach((gem, idx) => {
      const rowC = new PIXI.Container();
      rowC.x = 10;
      rowC.y = 10 + idx * 40;

      const rowBg = new PIXI.Graphics();
      rowBg.beginFill(gem.color, 0.25);
      rowBg.lineStyle(1.2, gem.color, 0.65);
      rowBg.drawRoundedRect(0, 0, 260, 34, 6);
      rowBg.endFill();
      rowC.addChild(rowBg);

      const gemIcon = new PIXI.Sprite(PIXI.Assets.get(gem.file));
      gemIcon.anchor.set(0.5);
      gemIcon.x = 22;
      gemIcon.y = 17;
      gemIcon.width = 24;
      gemIcon.height = 24;
      rowC.addChild(gemIcon);

      const multLabel = new PIXI.Text(`x${gem.mult}`, {
        fontFamily: 'Montserrat',
        fontSize: 14,
        fontWeight: '900',
        fill: 0xffffff
      });
      multLabel.anchor.set(0, 0.5);
      multLabel.x = 44;
      multLabel.y = 17;
      rowC.addChild(multLabel);

      const payoutLabel = new PIXI.Text(`${(betAmount * gem.mult).toFixed(1)} BDT`, {
        fontFamily: 'Montserrat',
        fontSize: 13,
        fontWeight: '800',
        fill: 0xffe277
      });
      payoutLabel.anchor.set(1, 0.5);
      payoutLabel.x = 250;
      payoutLabel.y = 17;
      rowC.addChild(payoutLabel);

      paytableContainer.addChild(rowC);
      multiplierRows[gem.id] = { container: rowC, bg: rowBg, payoutLabel };
    });

    // --- LAYER 5: AUTHENTIC 1XBET BOTTOM CONTROL BAR ---
    const uiLayer = new PIXI.Container();
    app.stage.addChild(uiLayer);

    const controlPanel = new PIXI.Container();
    controlPanel.x = 960;
    controlPanel.y = 890;
    uiLayer.addChild(controlPanel);

    // Royal Purple & Gold Trim Banner Frame
    const barBg = new PIXI.Graphics();
    barBg.beginFill(0x310f5c, 0.94);
    barBg.lineStyle(4, 0xdaa520, 1);
    barBg.drawRoundedRect(-570, -55, 1140, 110, 24);
    barBg.endFill();
    controlPanel.addChild(barBg);

    // Inner subtle gold divider lines
    const barInner = new PIXI.Graphics();
    barInner.lineStyle(1.5, 0xffd700, 0.4);
    barInner.drawRoundedRect(-564, -49, 1128, 98, 20);
    controlPanel.addChild(barInner);

    // 1. 6 Gold Bet Quick Buttons (Left Side: 2 Rows x 3 Cols)
    const betPresets = [
      { val: 20, col: 0, row: 0 },
      { val: 100, col: 1, row: 0 },
      { val: 300, col: 2, row: 0 },
      { val: 800, col: 0, row: 1 },
      { val: 3000, col: 1, row: 1 },
      { val: 10000, col: 2, row: 1 }
    ];

    betPresets.forEach(p => {
      const btnC = new PIXI.Container();
      btnC.x = -530 + p.col * 98 + 44;
      btnC.y = -22 + p.row * 44;
      btnC.eventMode = 'static';
      btnC.cursor = 'pointer';

      const bg = new PIXI.Graphics();
      bg.name = 'bg';
      bg.beginFill(0xd9a74a, 1);
      bg.lineStyle(2, 0xfff099, 1);
      bg.drawRoundedRect(-42, -18, 84, 36, 10);
      bg.endFill();
      btnC.addChild(bg);

      const label = new PIXI.Text(p.val >= 1000 ? `${p.val / 1000}k` : p.val.toString(), {
        fontFamily: 'Montserrat',
        fontSize: 15,
        fontWeight: '900',
        fill: 0xffffff
      });
      label.name = 'label';
      label.anchor.set(0.5);
      btnC.addChild(label);

      btnC.on('pointerdown', () => {
        if (window.audio) {
          window.audio.init();
          window.audio.playClick();
        }
        setBet(p.val);
      });
      btnC.on('pointerover', () => gsap.to(btnC.scale, { x: 1.06, y: 1.06, duration: 0.12 }));
      btnC.on('pointerout', () => gsap.to(btnC.scale, { x: 1.0, y: 1.0, duration: 0.12 }));

      controlPanel.addChild(btnC);
      betButtons.push({ btn: btnC, val: p.val });
    });

    // 2. Turbo Fast-Forward Button (Skip `>>`)
    turboBtnC = new PIXI.Container();
    turboBtnC.x = -175;
    turboBtnC.y = 0;
    turboBtnC.eventMode = 'static';
    turboBtnC.cursor = 'pointer';

    const turboBg = new PIXI.Graphics();
    turboBg.name = 'bg';
    turboBg.beginFill(0xb8860b, 1);
    turboBg.lineStyle(3, 0xffd700, 1);
    turboBg.drawCircle(0, 0, 32);
    turboBg.endFill();
    turboBtnC.addChild(turboBg);

    const turboIcon = new PIXI.Text('⏩', { fontSize: 20 });
    turboIcon.anchor.set(0.5);
    turboBtnC.addChild(turboIcon);

    turboBtnC.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      isTurbo = !isTurbo;
      turboBg.tint = isTurbo ? 0x00ff88 : 0xffffff;
      if (messageText) messageText.text = isTurbo ? '⚡ Turbo Mode: ON' : 'Turbo Mode: OFF';
    });
    turboBtnC.on('pointerover', () => gsap.to(turboBtnC.scale, { x: 1.08, y: 1.08, duration: 0.12 }));
    turboBtnC.on('pointerout', () => gsap.to(turboBtnC.scale, { x: 1.0, y: 1.0, duration: 0.12 }));
    controlPanel.addChild(turboBtnC);

    // 3. Center Main Spin Play Button (Big Emerald Green Gem)
    playBtnC = new PIXI.Container();
    playBtnC.x = -80;
    playBtnC.y = 0;
    playBtnC.eventMode = 'static';
    playBtnC.cursor = 'pointer';

    const playOuterRing = new PIXI.Graphics();
    playOuterRing.beginFill(0xdaa520, 1);
    playOuterRing.lineStyle(3, 0xffe680, 1);
    playOuterRing.drawCircle(0, 0, 46);
    playOuterRing.endFill();
    playBtnC.addChild(playOuterRing);

    const playInnerGem = new PIXI.Graphics();
    playInnerGem.beginFill(0x10b981, 1);
    playInnerGem.lineStyle(2, 0x6ee7b7, 1);
    playInnerGem.drawCircle(0, 0, 38);
    playInnerGem.endFill();
    playBtnC.addChild(playInnerGem);

    const playArrow = new PIXI.Text('▶', {
      fontFamily: 'Montserrat',
      fontSize: 32,
      fontWeight: '900',
      fill: 0xffffff
    });
    playArrow.anchor.set(0.5);
    playArrow.x = 3;
    playBtnC.addChild(playArrow);

    playBtnC.on('pointerdown', () => {
      if (!isSpinning) {
        startSpin();
        gsap.fromTo(playBtnC.scale, { x: 0.92, y: 0.92 }, { x: 1.0, y: 1.0, duration: 0.2, ease: 'back.out(2)' });
      }
    });
    playBtnC.on('pointerover', () => gsap.to(playBtnC.scale, { x: 1.08, y: 1.08, duration: 0.14 }));
    playBtnC.on('pointerout', () => gsap.to(playBtnC.scale, { x: 1.0, y: 1.0, duration: 0.14 }));
    controlPanel.addChild(playBtnC);

    // 4. Circular Auto-Spin Button (`🔄`)
    autoBtnC = new PIXI.Container();
    autoBtnC.x = 15;
    autoBtnC.y = 0;
    autoBtnC.eventMode = 'static';
    autoBtnC.cursor = 'pointer';

    const autoBg = new PIXI.Graphics();
    autoBg.name = 'bg';
    autoBg.beginFill(0xb8860b, 1);
    autoBg.lineStyle(3, 0xffd700, 1);
    autoBg.drawCircle(0, 0, 32);
    autoBg.endFill();
    autoBtnC.addChild(autoBg);

    const autoIcon = new PIXI.Text('🔄', { fontSize: 20 });
    autoIcon.anchor.set(0.5);
    autoBtnC.addChild(autoIcon);

    autoBtnC.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      if (!isAutoPlay) {
        isAutoPlay = true;
        autoSpinsLeft = 20;
        autoBg.tint = 0x00ff88;
        if (messageText) messageText.text = '🔄 Auto-Spin: 20 Rounds Started';
        if (!isSpinning) startSpin();
      } else {
        isAutoPlay = false;
        autoSpinsLeft = 0;
        autoBg.tint = 0xffffff;
        if (messageText) messageText.text = 'Auto-Spin Cancelled';
      }
    });
    autoBtnC.on('pointerover', () => gsap.to(autoBtnC.scale, { x: 1.08, y: 1.08, duration: 0.12 }));
    autoBtnC.on('pointerout', () => gsap.to(autoBtnC.scale, { x: 1.0, y: 1.0, duration: 0.12 }));
    controlPanel.addChild(autoBtnC);

    // 5. Stake Stepper `[-  20  +]`
    const stepperBox = new PIXI.Graphics();
    stepperBox.beginFill(0x1e0738, 0.95);
    stepperBox.lineStyle(2, 0xcaa048, 1);
    stepperBox.drawRoundedRect(95, -22, 230, 44, 22);
    stepperBox.endFill();
    controlPanel.addChild(stepperBox);

    const minusBtn = new PIXI.Text('−', {
      fontFamily: 'Montserrat',
      fontSize: 26,
      fontWeight: 'bold',
      fill: 0xffd700
    });
    minusBtn.anchor.set(0.5);
    minusBtn.x = 125;
    minusBtn.y = 0;
    minusBtn.eventMode = 'static';
    minusBtn.cursor = 'pointer';
    minusBtn.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      const next = Math.max(10, betAmount - 10);
      setBet(next);
    });
    controlPanel.addChild(minusBtn);

    betInputLabel = new PIXI.Text(betAmount.toString(), {
      fontFamily: 'Montserrat',
      fontSize: 18,
      fontWeight: '900',
      fill: 0xffffff
    });
    betInputLabel.anchor.set(0.5);
    betInputLabel.x = 210;
    betInputLabel.y = 0;
    controlPanel.addChild(betInputLabel);

    const plusBtn = new PIXI.Text('+', {
      fontFamily: 'Montserrat',
      fontSize: 26,
      fontWeight: 'bold',
      fill: 0xffd700
    });
    plusBtn.anchor.set(0.5);
    plusBtn.x = 295;
    plusBtn.y = 0;
    plusBtn.eventMode = 'static';
    plusBtn.cursor = 'pointer';
    plusBtn.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      const next = Math.min(10000, betAmount + 10);
      setBet(next);
    });
    controlPanel.addChild(plusBtn);

    // 6. Sound Toggle & Help Buttons
    const soundBtn = new PIXI.Container();
    soundBtn.x = 410;
    soundBtn.y = 0;
    soundBtn.eventMode = 'static';
    soundBtn.cursor = 'pointer';

    const soundBg = new PIXI.Graphics();
    soundBg.beginFill(0x270b47, 0.9);
    soundBg.lineStyle(2, 0xd4af37, 0.8);
    soundBg.drawCircle(0, 0, 20);
    soundBg.endFill();
    soundBtn.addChild(soundBg);

    const soundIco = new PIXI.Text('🔊', { fontSize: 16 });
    soundIco.anchor.set(0.5);
    soundBtn.addChild(soundIco);

    soundBtn.on('pointerdown', () => {
      if (window.audio) {
        const muted = window.audio.toggleMute();
        soundIco.text = muted ? '🔇' : '🔊';
      }
    });
    controlPanel.addChild(soundBtn);

    const helpBtn = new PIXI.Container();
    helpBtn.x = 470;
    helpBtn.y = 0;
    helpBtn.eventMode = 'static';
    helpBtn.cursor = 'pointer';

    const helpBg = new PIXI.Graphics();
    helpBg.beginFill(0x270b47, 0.9);
    helpBg.lineStyle(2, 0xd4af37, 0.8);
    helpBg.drawCircle(0, 0, 20);
    helpBg.endFill();
    helpBtn.addChild(helpBg);

    const helpIco = new PIXI.Text('❓', { fontSize: 16 });
    helpIco.anchor.set(0.5);
    helpBtn.addChild(helpIco);

    helpBtn.on('pointerdown', () => {
      if (window.rulesModal) window.rulesModal.open();
    });
    controlPanel.addChild(helpBtn);

    // Initialize Grid Board & UI
    populateInitialGrid();
    updateUILabel();
    setBet(20);

    updateProgress(100, 'Game Ready!');
    setTimeout(() => {
      const loader = document.getElementById('loading-overlay') || document.getElementById('loading-screen');
      if (loader) {
        loader.style.opacity = '0';
        loader.style.transition = 'opacity 0.4s ease';
        setTimeout(() => { loader.style.display = 'none'; }, 400);
      }
    }, 200);

    resizeGame();

  } catch (err) {
    console.error('Error initializing Crystal Slot Game:', err);
    if (loadingScreen) loadingScreen.innerHTML = `<div style="color:red;padding:20px;">Failed to load game: ${err.message}</div>`;
  }
});

// --- Responsive Canvas Scaler & Mobile Orientation Handling ---
let rotateNoticeDismissed = false;

function checkOrientation() {
  const overlay = document.getElementById('rotate-device-overlay');
  if (!overlay) return;
  const isMobile = window.innerWidth <= 900;
  const isPortrait = window.innerHeight > window.innerWidth;

  if (isMobile && isPortrait && !rotateNoticeDismissed) {
    overlay.classList.add('show');
  } else {
    overlay.classList.remove('show');
  }
}

window.dismissRotateNotice = function() {
  rotateNoticeDismissed = true;
  const overlay = document.getElementById('rotate-device-overlay');
  if (overlay) overlay.classList.remove('show');
};

function resizeGame() {
  const container = document.getElementById('game-canvas-container');
  if (!container) return;
  const targetW = 1920;
  const targetH = 1080;
  const availW = window.visualViewport ? window.visualViewport.width : window.innerWidth;
  const availH = window.visualViewport ? window.visualViewport.height : window.innerHeight;

  const scaleX = availW / targetW;
  const scaleY = availH / targetH;
  const scale = Math.min(scaleX, scaleY);
  container.style.transform = `scale(${scale})`;

  checkOrientation();
}

window.addEventListener('resize', resizeGame);
window.addEventListener('orientationchange', () => {
  rotateNoticeDismissed = false;
  setTimeout(resizeGame, 50);
  setTimeout(resizeGame, 250);
});
if (window.visualViewport) {
  window.visualViewport.addEventListener('resize', resizeGame);
  window.visualViewport.addEventListener('scroll', resizeGame);
}
window.addEventListener('DOMContentLoaded', () => {
  resizeGame();
});
