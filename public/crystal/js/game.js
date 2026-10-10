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
const CELL_SIZE = 79.5;
const GRID_X = 654;
const GRID_Y = 188;

let balance = (typeof window !== 'undefined' && typeof window.USER_BALANCE === 'number') ? window.USER_BALANCE : 10000;
let totalWinnings = 0;
let betAmount = 20;
let isSpinning = false;
let isTurbo = false;
let isAutoPlay = false;
let autoSpinsLeft = 0;

async function syncBackendSpin(bet) {
  try {
    const isDemo = !window.IS_AUTH;
    const csrfToken = window.CSRF_TOKEN || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const res = await fetch('/games/crystal/spin', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        bet: bet,
        is_demo: isDemo ? 1 : 0
      })
    });
    const data = await res.json();
    return data;
  } catch (e) {
    return null;
  }
}

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
  if (!spineObj || !spineObj.state) return;
  const anims = Array.isArray(animNames) ? animNames : [animNames];
  let availableAnims = [];
  if (spineObj.skeleton && spineObj.skeleton.data && spineObj.skeleton.data.animations) {
    availableAnims = spineObj.skeleton.data.animations.map(a => a.name);
  } else if (spineObj.spineData && spineObj.spineData.animations) {
    availableAnims = spineObj.spineData.animations.map(a => a.name);
  }
  const found = anims.find(name => availableAnims.includes(name));
  if (found) {
    try {
      return spineObj.state.setAnimation(trackIndex, found, loop);
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
    // Play win celebration immediately (legs down, eyes open, cheerful reaction)
    playSpine(kingSpine, ['win', 'action'], false);
    // Queue returning back to idle sleep pose
    try {
      kingSpine.state.addAnimation(0, 'idle', true, 2.5);
    } catch (e) {
      setTimeout(() => {
        if (!isSpinning) startKingSleepAnimation();
      }, 2600);
    }
  }
  if (bubbleSpine) {
    playSpine(bubbleSpine, ['win', 'win_total'], false);
    bubbleSpine.visible = true;
  }
  spawnKingAuraSparkles();
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
    coin.x = 932 + (Math.random() - 0.5) * 400;
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

function renderWinCards(clusters) {
  if (!window.crystalWinCards) return;
  window.crystalWinCards.removeChildren();

  clusters.forEach((cl, idx) => {
    const card = new PIXI.Container();
    card.x = 0;
    card.y = idx * 64;
    card.alpha = 0;

    // Background banner (Width: 308px, Height: 56px to perfectly fit the Right Chamber)
    const bgTex = PIXI.Assets.get('assets/images/ui/payout_background_color.png') || PIXI.Assets.get('assets/images/ui/flag_background.png');
    if (bgTex) {
      const bgSprite = new PIXI.Sprite(bgTex);
      bgSprite.width = 308;
      bgSprite.height = 56;
      bgSprite.anchor.set(0, 0.5);
      card.addChild(bgSprite);
    } else {
      const bgG = new PIXI.Graphics();
      bgG.beginFill(0x280b4d, 0.88);
      bgG.lineStyle(1.5, 0xd4af37, 0.8);
      bgG.drawRoundedRect(0, -28, 308, 56, 10);
      bgG.endFill();
      card.addChild(bgG);
    }

    // Flag Frame
    const frTex = PIXI.Assets.get('assets/images/ui/flag_frame.png');
    if (frTex) {
      const frSprite = new PIXI.Sprite(frTex);
      frSprite.x = 6;
      frSprite.y = 0;
      frSprite.anchor.set(0, 0.5);
      frSprite.scale.set(0.72);
      card.addChild(frSprite);
    }

    // Gem Icon
    const gemTex = PIXI.Assets.get(cl.gem.file);
    if (gemTex) {
      const gemSprite = new PIXI.Sprite(gemTex);
      gemSprite.anchor.set(0.5);
      gemSprite.x = 28;
      gemSprite.y = 0;
      gemSprite.width = 38;
      gemSprite.height = 38;
      card.addChild(gemSprite);
    }

    // Count text: "x5", "x7"
    const countTxt = new PIXI.Text(`x${cl.count}`, {
      fontFamily: 'Montserrat',
      fontSize: 18,
      fontWeight: '900',
      fill: 0xffd700
    });
    countTxt.anchor.set(0, 0.5);
    countTxt.x = 56;
    countTxt.y = 0;
    card.addChild(countTxt);

    // Payout amount: "+120.00 BDT"
    const winForCluster = betAmount * cl.gem.mult * (1 + (cl.count - 5) * 0.2);
    const payoutTxt = new PIXI.Text(`+${winForCluster.toFixed(1)} BDT`, {
      fontFamily: 'Montserrat',
      fontSize: 17,
      fontWeight: '900',
      fill: 0xffffff
    });
    payoutTxt.anchor.set(1, 0.5);
    payoutTxt.x = 296;
    payoutTxt.y = 0;
    card.addChild(payoutTxt);

    window.crystalWinCards.addChild(card);

    gsap.to(card, {
      alpha: 1,
      duration: 0.3,
      delay: idx * 0.08,
      ease: 'back.out(1.4)'
    });
  });
}

// --- SPIN ACTION & CASCADING STEPPER ---
async function startSpin() {
  if (isSpinning) return;

  if (balance < betAmount) {
    if (messageText) messageText.text = '⚠️ Insufficient Balance!';
    return;
  }

  if (window.crystalWinCards) {
    window.crystalWinCards.removeChildren();
  }

  const backendPromise = syncBackendSpin(betAmount);
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

    renderWinCards(clusters);

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

    if (typeof window.triggerWinCelebration === 'function') {
      window.triggerWinCelebration({
        amount: stepWin,
        multiplier: betAmount > 0 ? (stepWin / betAmount) : 0,
        title: `CRYSTAL CASCADE x${cascadeStep} WIN!`
      });
    }

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

  try {
    const backendData = await backendPromise;
    if (backendData && backendData.new_balance !== undefined) {
      balance = backendData.new_balance;
      updateUILabel();
    }
  } catch(e) {}

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
      // Official UI Assets
      'assets/images/ui/bet_btn_normal.png',
      'assets/images/ui/bet_btn_hover.png',
      'assets/images/ui/bet_btn_pressed.png',
      'assets/images/ui/btn_round_skip_normal.png',
      'assets/images/ui/btn_round_skip_hover.png',
      'assets/images/ui/skip_icon.png',
      'assets/images/ui/btn_play_normal.png',
      'assets/images/ui/btn_play_hover.png',
      'assets/images/ui/btn_auto_normal.png',
      'assets/images/ui/btn_auto_hover.png',
      'assets/images/ui/autoplay_icon.png',
      'assets/images/ui/reels_desktop_background.png',
      'assets/images/ui/ribbon_background.png',
      'assets/images/ui/flag_frame.png',
      'assets/images/ui/flag_background.png',
      'assets/images/ui/payout_background_color.png',
      'assets/images/ui/payout_background_glow.png',
      'assets/images/ui/logo.png'
    ];

    for (let i = 0; i < imageAssets.length; i++) {
      const fullSrc = getAssetPath(imageAssets[i]);
      PIXI.Assets.add({ alias: imageAssets[i], src: fullSrc });
    }

    await PIXI.Assets.load(imageAssets);

    updateProgress(50, 'Loading Animated Spine Characters...');

    // Load Spine 4.2 models
    async function loadSpine42(skelRelative, atlasRelative, scale = 1) {
      try {
        const SpineClass = (window.spine && window.spine.Spine) || (PIXI.spine && PIXI.spine.Spine);
        if (!SpineClass) return null;
        const atlasUrl = getAssetPath(atlasRelative);
        const skelUrl = getAssetPath(skelRelative);

        const [atlasRes, skelRes] = await Promise.all([
          fetch(atlasUrl).then(r => r.text()),
          fetch(skelUrl).then(r => r.arrayBuffer())
        ]);

        const atlas = new window.spine.TextureAtlas(atlasRes);
        const texPromises = atlas.pages.map(async (page) => {
          const pageTexPath = getAssetPath('assets/spines/' + page.name);
          let pTex = PIXI.Assets.get(pageTexPath);
          if (!pTex) {
            try {
              pTex = await PIXI.Assets.load(pageTexPath);
            } catch (e) {
              pTex = PIXI.Texture.from(pageTexPath);
            }
          }
          page.setTexture(window.spine.SpineTexture.from(pTex.baseTexture || pTex));
        });
        await Promise.all(texPromises);

        const attachmentLoader = new window.spine.AtlasAttachmentLoader(atlas);
        const parser = new window.spine.SkeletonBinary(attachmentLoader);
        if (scale && scale !== 1) parser.scale = scale;
        const skeletonData = parser.readSkeletonData(new Uint8Array(skelRes));
        return new SpineClass({ skeletonData, autoUpdate: true });
      } catch (err) {
        console.warn('Spine load warning for ' + skelRelative + ':', err);
        return null;
      }
    }

    let kingRes = null, bgFxRes = null, bubbleRes = null;
    try {
      [kingRes, bgFxRes, bubbleRes] = await Promise.all([
        loadSpine42('assets/spines/king.skel', 'assets/spines/king@1x.atlas'),
        loadSpine42('assets/spines/bg_fx.skel', 'assets/spines/bg_fx@1x.atlas'),
        loadSpine42('assets/spines/bubble.skel', 'assets/spines/bubble@1x.atlas')
      ]);
    } catch (spineErr) {
      console.warn('Spine models loading fallback:', spineErr);
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

    // Wall Torches & Sparkling Diamonds Spine (Full Screen Overlay at 960, 540)
    if (bgFxRes) {
      const bgFxSpine = bgFxRes;
      bgFxSpine.x = 960;
      bgFxSpine.y = 540;
      bgFxSpine.scale.set(1.0);
      playSpine(bgFxSpine, ['idle', 'loop'], true);
      bgLayer.addChild(bgFxSpine);
    }

    // --- LAYER 1: ANIMATED KING CHARACTER (SITTING ON THRONE CHAIR) ---
    const kingLayer = new PIXI.Container();
    app.stage.addChild(kingLayer);

    if (kingRes) {
      kingSpine = kingRes;
      kingSpine.x = 960;
      kingSpine.y = 540;
      kingSpine.scale.set(1.0);
      playSpine(kingSpine, ['idle', 'sleep', 'loop'], true);
      kingLayer.addChild(kingSpine);

      if (bubbleRes) {
        bubbleSpine = bubbleRes;
        bubbleSpine.x = 960;
        bubbleSpine.y = 540;
        bubbleSpine.scale.set(1.0);
        playSpine(bubbleSpine, ['idle', 'loop', 'win'], true);
        kingLayer.addChild(bubbleSpine);
      }
    } else {
      // Fallback Sprite
      const kingSprite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/king_sleep.png') || PIXI.Assets.get('assets/images/king.png'));
      kingSprite.anchor.set(0.5);
      kingSprite.x = 240;
      kingSprite.y = 740;
      kingSprite.scale.set(0.75);
      kingLayer.addChild(kingSprite);
    }

    // --- LAYER 2 & 3: AUTHENTIC REELS FRAME, 7x7 CASCADING BOARD & DYNAMIC WIN CHAMBER ---
    const boardLayer = new PIXI.Container();
    app.stage.addChild(boardLayer);

    // 1. Authentic 1xBet Golden Double Frame & Built-in Control Bar Panel
    const frameTex = PIXI.Assets.get('assets/images/ui/reels_desktop_background.png');
    if (frameTex) {
      const frameSprite = new PIXI.Sprite(frameTex);
      frameSprite.x = 480;
      frameSprite.y = 110;
      frameSprite.width = 1237;
      frameSprite.height = 817;
      boardLayer.addChild(frameSprite);
    }

    // 2. Left Chamber: Dark semi-transparent 7x7 grid backing
    const gridBg = new PIXI.Graphics();
    gridBg.beginFill(0x130724, 0.85);
    gridBg.drawRoundedRect(GRID_X - 4, GRID_Y - 4, COLS * CELL_SIZE + 8, ROWS * CELL_SIZE + 8, 8);
    gridBg.endFill();
    boardLayer.addChild(gridBg);

    // Individual cell background tiles
    for (let r = 0; r < ROWS; r++) {
      for (let c = 0; c < COLS; c++) {
        const tile = new PIXI.Graphics();
        tile.beginFill(0x220e3d, 0.55);
        tile.lineStyle(1, 0x5a2d8a, 0.35);
        tile.drawRoundedRect(GRID_X + c * CELL_SIZE + 2, GRID_Y + r * CELL_SIZE + 2, CELL_SIZE - 4, CELL_SIZE - 4, 6);
        tile.endFill();
        boardLayer.addChild(tile);
      }
    }

    gridContainer = new PIXI.Container();
    boardLayer.addChild(gridContainer);

    particlesContainer = new PIXI.Container();
    boardLayer.addChild(particlesContainer);

    // 3. Right Chamber: 100% Transparent by default (shows floor/carpet underneath), displays win cards on hit!
    const winCardsContainer = new PIXI.Container();
    winCardsContainer.x = 1230;
    winCardsContainer.y = 196;
    boardLayer.addChild(winCardsContainer);
    window.crystalWinCards = winCardsContainer;

    // 4. Top Arch Ribbon Banner ("Press the Play button" / "WIN ...")
    const topBannerC = new PIXI.Container();
    topBannerC.x = 932;
    topBannerC.y = 100;
    boardLayer.addChild(topBannerC);

    const ribbonTex = PIXI.Assets.get('assets/images/ui/ribbon_background.png');
    if (ribbonTex) {
      const ribbonSprite = new PIXI.Sprite(ribbonTex);
      ribbonSprite.anchor.set(0.5);
      ribbonSprite.scale.set(1.4, 1.15);
      topBannerC.addChild(ribbonSprite);
    } else {
      const msgPlate = new PIXI.Graphics();
      msgPlate.beginFill(0xffffff, 0.96);
      msgPlate.lineStyle(3, 0xd4af37, 1);
      msgPlate.drawRoundedRect(-200, -18, 400, 36, 18);
      msgPlate.endFill();
      topBannerC.addChild(msgPlate);
    }

    messageText = new PIXI.Text('Press the Play button', {
      fontFamily: 'Montserrat',
      fontSize: 16,
      fontWeight: '900',
      fill: 0x1f0b3b
    });
    messageText.anchor.set(0.5);
    topBannerC.addChild(messageText);

    // 5. 3D "CRYSTAL" Logo on central arch apex divider
    const logoTex = PIXI.Assets.get('assets/images/ui/logo.png') || PIXI.Assets.get('assets/images/logo_crystal.png');
    if (logoTex) {
      const logoEmblem = new PIXI.Sprite(logoTex);
      logoEmblem.anchor.set(0.5);
      logoEmblem.x = 1218;
      logoEmblem.y = 118;
      logoEmblem.scale.set(0.85);
      boardLayer.addChild(logoEmblem);

      gsap.to(logoEmblem.scale, {
        x: 0.88,
        y: 0.88,
        duration: 2.2,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });
    }

    // --- LAYER 5: AUTHENTIC 1XBET ROYAL BOTTOM CONTROLS ---
    const uiLayer = new PIXI.Container();
    app.stage.addChild(uiLayer);

    const controlPanel = new PIXI.Container();
    uiLayer.addChild(controlPanel);

    // 1. 6 Gold Bet Quick Buttons (Left Side: 2 Rows x 3 Cols with Real Button Image Backgrounds)
    const betPresets = [
      { val: 20, col: 0, row: 0 },
      { val: 100, col: 1, row: 0 },
      { val: 300, col: 2, row: 0 },
      { val: 800, col: 0, row: 1 },
      { val: 3000, col: 1, row: 1 },
      { val: 10000, col: 2, row: 1 }
    ];

    const betBtnNormalTex = PIXI.Assets.get('assets/images/ui/bet_btn_normal.png');
    const betBtnHoverTex = PIXI.Assets.get('assets/images/ui/bet_btn_hover.png');
    const betBtnPressedTex = PIXI.Assets.get('assets/images/ui/bet_btn_pressed.png');

    betPresets.forEach(p => {
      const btnC = new PIXI.Container();
      btnC.x = 610 + p.col * 110;
      btnC.y = 808 + p.row * 50;
      btnC.eventMode = 'static';
      btnC.cursor = 'pointer';

      let bg;
      if (betBtnNormalTex) {
        bg = new PIXI.Sprite(betBtnNormalTex);
        bg.name = 'bg';
        bg.anchor.set(0.5);
        bg.width = 100;
        bg.height = 44;
        btnC.addChild(bg);
      }

      const label = new PIXI.Text(p.val.toString(), {
        fontFamily: 'Montserrat',
        fontSize: 14,
        fontWeight: '900',
        fill: 0xffffff,
        dropShadow: true,
        dropShadowColor: 0x000000,
        dropShadowBlur: 2,
        dropShadowDistance: 1
      });
      label.name = 'label';
      label.anchor.set(0.5);
      btnC.addChild(label);

      btnC.on('pointerdown', () => {
        if (window.audio) {
          window.audio.init();
          window.audio.playClick();
        }
        if (betBtnPressedTex && bg) bg.texture = betBtnPressedTex;
        setBet(p.val);
      });
      btnC.on('pointerup', () => {
        if (betBtnNormalTex && bg) bg.texture = betBtnNormalTex;
      });
      btnC.on('pointerover', () => {
        if (betBtnHoverTex && bg) bg.texture = betBtnHoverTex;
        gsap.to(btnC.scale, { x: 1.05, y: 1.05, duration: 0.12 });
      });
      btnC.on('pointerout', () => {
        if (betBtnNormalTex && bg) bg.texture = betBtnNormalTex;
        gsap.to(btnC.scale, { x: 1.0, y: 1.0, duration: 0.12 });
      });

      controlPanel.addChild(btnC);
      betButtons.push({ btn: btnC, val: p.val });
    });

    // 2. Turbo Fast-Forward Button (Skip `>>`)
    turboBtnC = new PIXI.Container();
    turboBtnC.x = 940;
    turboBtnC.y = 834;
    turboBtnC.eventMode = 'static';
    turboBtnC.cursor = 'pointer';

    const skipTex = PIXI.Assets.get('assets/images/ui/btn_round_skip_normal.png');
    const skipHoverTex = PIXI.Assets.get('assets/images/ui/btn_round_skip_hover.png');
    let skipSprite;
    if (skipTex) {
      skipSprite = new PIXI.Sprite(skipTex);
      skipSprite.name = 'bg';
      skipSprite.anchor.set(0.5);
      skipSprite.scale.set(0.88);
      turboBtnC.addChild(skipSprite);
    }
    const skipIcoTex = PIXI.Assets.get('assets/images/ui/skip_icon.png');
    if (skipIcoTex) {
      const base = skipIcoTex.baseTexture || skipIcoTex;
      const singleSkipTex = new PIXI.Texture(base, new PIXI.Rectangle(0, 0, 141, 40));
      const skipIco = new PIXI.Sprite(singleSkipTex);
      skipIco.anchor.set(0.5);
      skipIco.scale.set(0.55);
      turboBtnC.addChild(skipIco);
    }

    turboBtnC.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      isTurbo = !isTurbo;
      if (skipSprite) skipSprite.tint = isTurbo ? 0x00ff88 : 0xffffff;
      if (messageText) messageText.text = isTurbo ? '⚡ Turbo Mode: ON' : 'Turbo Mode: OFF';
    });
    turboBtnC.on('pointerover', () => {
      if (skipHoverTex && skipSprite) skipSprite.texture = skipHoverTex;
      gsap.to(turboBtnC.scale, { x: 1.08, y: 1.08, duration: 0.12 });
    });
    turboBtnC.on('pointerout', () => {
      if (skipTex && skipSprite) skipSprite.texture = skipTex;
      gsap.to(turboBtnC.scale, { x: 1.0, y: 1.0, duration: 0.12 });
    });
    controlPanel.addChild(turboBtnC);

    // 3. Center Main Spin Play Button (Big Emerald Green Gem with Dragon Wings Frame)
    playBtnC = new PIXI.Container();
    playBtnC.x = 1055;
    playBtnC.y = 834;
    playBtnC.eventMode = 'static';
    playBtnC.cursor = 'pointer';

    const playTex = PIXI.Assets.get('assets/images/ui/btn_play_normal.png');
    const playHoverTex = PIXI.Assets.get('assets/images/ui/btn_play_hover.png');
    let playSprite;
    if (playTex) {
      playSprite = new PIXI.Sprite(playTex);
      playSprite.name = 'bg';
      playSprite.anchor.set(0.5);
      playSprite.scale.set(0.96);
      playBtnC.addChild(playSprite);
    }

    playBtnC.on('pointerdown', () => {
      if (!isSpinning) {
        startSpin();
        gsap.fromTo(playBtnC.scale, { x: 0.92, y: 0.92 }, { x: 1.0, y: 1.0, duration: 0.2, ease: 'back.out(2)' });
      }
    });
    playBtnC.on('pointerover', () => {
      if (playHoverTex && playSprite) playSprite.texture = playHoverTex;
      gsap.to(playBtnC.scale, { x: 1.08, y: 1.08, duration: 0.14 });
    });
    playBtnC.on('pointerout', () => {
      if (playTex && playSprite) playSprite.texture = playTex;
      gsap.to(playBtnC.scale, { x: 1.0, y: 1.0, duration: 0.14 });
    });
    controlPanel.addChild(playBtnC);

    // 4. Circular Auto-Spin Button (`🔄`)
    autoBtnC = new PIXI.Container();
    autoBtnC.x = 1170;
    autoBtnC.y = 834;
    autoBtnC.eventMode = 'static';
    autoBtnC.cursor = 'pointer';

    const autoTex = PIXI.Assets.get('assets/images/ui/btn_auto_normal.png');
    const autoHoverTex = PIXI.Assets.get('assets/images/ui/btn_auto_hover.png');
    let autoSprite;
    if (autoTex) {
      autoSprite = new PIXI.Sprite(autoTex);
      autoSprite.name = 'bg';
      autoSprite.anchor.set(0.5);
      autoSprite.scale.set(0.88);
      autoBtnC.addChild(autoSprite);
    }
    const autoIcoTex = PIXI.Assets.get('assets/images/ui/autoplay_icon.png');
    if (autoIcoTex) {
      const base = autoIcoTex.baseTexture || autoIcoTex;
      const singleAutoTex = new PIXI.Texture(base, new PIXI.Rectangle(0, 0, 98, 98));
      const autoIco = new PIXI.Sprite(singleAutoTex);
      autoIco.anchor.set(0.5);
      autoIco.scale.set(0.55);
      autoBtnC.addChild(autoIco);
    }

    autoBtnC.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      if (!isAutoPlay) {
        isAutoPlay = true;
        autoSpinsLeft = 20;
        if (autoSprite) autoSprite.tint = 0x00ff88;
        if (messageText) messageText.text = '🔄 Auto-Spin: 20 Rounds Started';
        if (!isSpinning) startSpin();
      } else {
        isAutoPlay = false;
        autoSpinsLeft = 0;
        if (autoSprite) autoSprite.tint = 0xffffff;
        if (messageText) messageText.text = 'Auto-Spin Cancelled';
      }
    });
    autoBtnC.on('pointerover', () => {
      if (autoHoverTex && autoSprite) autoSprite.texture = autoHoverTex;
      gsap.to(autoBtnC.scale, { x: 1.08, y: 1.08, duration: 0.12 });
    });
    autoBtnC.on('pointerout', () => {
      if (autoTex && autoSprite) autoSprite.texture = autoTex;
      gsap.to(autoBtnC.scale, { x: 1.0, y: 1.0, duration: 0.12 });
    });
    controlPanel.addChild(autoBtnC);

    // 5. Stake Stepper Box `[-  20  +]`
    const stepperBox = new PIXI.Graphics();
    stepperBox.beginFill(0x1c0733, 0.95);
    stepperBox.lineStyle(2, 0xcaa048, 1);
    stepperBox.drawRoundedRect(1225, 810, 190, 48, 24);
    stepperBox.endFill();
    controlPanel.addChild(stepperBox);

    const minusBtn = new PIXI.Text('−', {
      fontFamily: 'Montserrat',
      fontSize: 26,
      fontWeight: 'bold',
      fill: 0xffd700
    });
    minusBtn.anchor.set(0.5);
    minusBtn.x = 1255;
    minusBtn.y = 834;
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
    betInputLabel.x = 1320;
    betInputLabel.y = 834;
    controlPanel.addChild(betInputLabel);

    const plusBtn = new PIXI.Text('+', {
      fontFamily: 'Montserrat',
      fontSize: 26,
      fontWeight: 'bold',
      fill: 0xffd700
    });
    plusBtn.anchor.set(0.5);
    plusBtn.x = 1385;
    plusBtn.y = 834;
    plusBtn.eventMode = 'static';
    plusBtn.cursor = 'pointer';
    plusBtn.on('pointerdown', () => {
      if (window.audio) window.audio.playClick();
      const next = Math.min(10000, betAmount + 10);
      setBet(next);
    });
    controlPanel.addChild(plusBtn);

    // 6. Sound Toggle & Help Buttons (Stacked Vertically on the Right)
    const soundBtn = new PIXI.Container();
    soundBtn.x = 1455;
    soundBtn.y = 812;
    soundBtn.eventMode = 'static';
    soundBtn.cursor = 'pointer';

    const soundBg = new PIXI.Graphics();
    soundBg.beginFill(0x270b47, 0.95);
    soundBg.lineStyle(2, 0xd4af37, 0.9);
    soundBg.drawCircle(0, 0, 16);
    soundBg.endFill();
    soundBtn.addChild(soundBg);

    const soundIco = new PIXI.Text('🔊', { fontSize: 13 });
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
    helpBtn.x = 1455;
    helpBtn.y = 856;
    helpBtn.eventMode = 'static';
    helpBtn.cursor = 'pointer';

    const helpBg = new PIXI.Graphics();
    helpBg.beginFill(0x270b47, 0.95);
    helpBg.lineStyle(2, 0xd4af37, 0.9);
    helpBg.drawCircle(0, 0, 16);
    helpBg.endFill();
    helpBtn.addChild(helpBg);

    const helpIco = new PIXI.Text('❓', { fontSize: 13 });
    helpIco.anchor.set(0.5);
    helpBtn.addChild(helpIco);

    helpBtn.on('pointerdown', () => {
      const modal = document.getElementById('info-modal');
      if (modal) modal.style.display = 'flex';
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
