// Register GSAP PixiPlugin if available
if (typeof gsap !== 'undefined' && typeof PixiPlugin !== 'undefined') {
  gsap.registerPlugin(PixiPlugin);
  if (typeof PIXI !== 'undefined') {
    PixiPlugin.registerPIXI(PIXI);
  }
}

const ASSET_BASE = (typeof window !== 'undefined' && window.BURNING_HOT_BASE ? window.BURNING_HOT_BASE : (typeof window !== 'undefined' && window.location.pathname.includes('burning-hot') ? '/burning-hot/' : './')).replace(/\/+$/, '') + '/';

function getAssetPath(p) {
  if (!p) return p;
  if (p.startsWith('http://') || p.startsWith('https://') || p.startsWith('/')) return p;
  return ASSET_BASE + p;
}

const STRIP_SYMBOLS = [
  { id: 'seven', name: 'Seven', index: 0, file: 'seven@1x.47c93c5fff34.png', payout: [0, 0, 20, 200, 1000] },
  { id: 'wild', name: 'Wild', index: 1, file: 'wild@1x.ce9e11eee8a3.png', isWild: true },
  { id: 'pineapple', name: 'Pineapple', index: 2, file: 'pineapple@1x.04c72313c609.png', payout: [0, 0, 15, 50, 200] },
  { id: 'banana', name: 'Banana', index: 3, file: 'banana@1x.a53d4bebf89f.png', payout: [0, 0, 15, 50, 200] },
  { id: 'dollar', name: 'Dollar', index: 4, file: 'dollar@1x.dec7b2a8aa68.png', isScatter: true, payout: [0, 0, 15, 100, 500] },
  { id: 'grape', name: 'Grape', index: 5, file: 'grape@1x.cda5aaac27f6.png', payout: [0, 0, 15, 50, 200] },
  { id: 'apple', name: 'Apple', index: 6, file: 'apple@1x.39cb85a3a931.png', payout: [0, 0, 10, 30, 100] },
  { id: 'cherry', name: 'Cherry', index: 7, file: 'cherry@1x.e8d1c9ede2b2.png', payout: [0, 0, 10, 30, 100] },
  { id: 'star', name: 'Star', index: 8, file: 'star@1x.5cbf98edaae9.png', isScatter: true, payout: [0, 0, 100, 100, 100] },
  { id: 'pear', name: 'Pear', index: 9, file: 'pear@1x.b94afb436fdc.png', payout: [0, 0, 10, 30, 100] },
  { id: 'strawberry', name: 'Strawberry', index: 10, file: 'strawberry@1x.d4f6a8e41134.png', payout: [0, 0, 10, 30, 100] }
];

const PAYLINES = [
  [1, 1, 1, 1, 1], // Center line (Row 1)
  [0, 0, 0, 0, 0], // Top line (Row 0)
  [2, 2, 2, 2, 2], // Bottom line (Row 2)
  [0, 1, 2, 1, 0], // V-shape
  [2, 1, 0, 1, 2]  // Inverted V
];

const COLS = 5;
const ROWS = 3;
const REEL_W = 188;
const REEL_H = 170;
const GRID_X = 490;
const GRID_Y = 175;

let balance = (typeof window !== 'undefined' && typeof window.USER_BALANCE === 'number') ? window.USER_BALANCE : 10000;
let totalWinnings = 0;
let betAmount = 20;
let isSpinning = false;
let isAutoPlay = false;
let autoSpinsLeft = 0;

async function syncBackendSpin(bet) {
  try {
    const isDemo = !window.IS_AUTH;
    const csrfToken = window.CSRF_TOKEN || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const res = await fetch('/games/burning-hot/spin', {
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
let dragonSpine, knightSpine, fireSpineMain, fireSpineLeft, fireSpineRight, teethSpine, logoSpine, bg1Spine;
let symbolTextures = [];
let reels = [];
let winTextLabel, bannerContainer;
let paylineGraphics, fireBreathGraphics;
let betButtons = [];
let betInputLabel;
let stepperPanel;
let autoIco;

let texPlayBtn, texAutoBtn, texAutoIco, texBtnNormal, texBtnActive, texInputCross;

window.setGameBalance = function(val) {
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

// Helper to safely play Spine animations with fallback
function playSpine(spineObj, preferredList, loop = false, fallbackToIdle = true) {
  if (!spineObj || !spineObj.spineData || !spineObj.spineData.animations) return;
  const anims = spineObj.spineData.animations.map(a => a.name);
  if (anims.length === 0) return;

  for (const p of preferredList) {
    if (anims.includes(p)) {
      try {
        spineObj.state.setAnimation(0, p, loop);
        if (!loop && fallbackToIdle) {
          const idleName = anims.find(a => a.toLowerCase().includes('idle')) || anims[0];
          if (idleName && idleName !== p) {
            spineObj.state.addAnimation(0, idleName, true, 0);
          }
        }
        return;
      } catch (e) {}
    }
  }
  const fallback = anims.find(a => a.toLowerCase().includes('idle')) || anims[0];
  if (fallback) {
    try { spineObj.state.setAnimation(0, fallback, loop); } catch (e) {}
  }
}

function getRandomSymbol() {
  const r = Math.random();
  if (r < 0.18) return STRIP_SYMBOLS[0]; // 7
  if (r < 0.28) return STRIP_SYMBOLS[1]; // Wild
  if (r < 0.39) return STRIP_SYMBOLS[2]; // Pineapple
  if (r < 0.50) return STRIP_SYMBOLS[3]; // Banana
  if (r < 0.60) return STRIP_SYMBOLS[4]; // Dollar
  if (r < 0.70) return STRIP_SYMBOLS[5]; // Grape
  if (r < 0.80) return STRIP_SYMBOLS[6]; // Apple
  if (r < 0.88) return STRIP_SYMBOLS[7]; // Cherry
  if (r < 0.93) return STRIP_SYMBOLS[8]; // Star
  if (r < 0.97) return STRIP_SYMBOLS[9]; // Pear
  return STRIP_SYMBOLS[10]; // Strawberry
}

function createGlassBtn(text, x, y, w, h, onClick) {
  const c = new PIXI.Container();
  c.x = x; c.y = y;
  c.eventMode = 'static';
  c.cursor = 'pointer';

  const g = new PIXI.Graphics();
  g.beginFill(0x1a122e, 0.92);
  g.lineStyle(1.5, 0x5a3e82, 1);
  g.drawRoundedRect(-w/2, -h/2, w, h, 6);
  g.endFill();
  c.addChild(g);

  const t = new PIXI.Text(text, {
    fontFamily: 'Montserrat',
    fontSize: 16,
    fontWeight: 'bold',
    fill: 0xffd700
  });
  t.anchor.set(0.5);
  c.addChild(t);

  c.on('pointerdown', onClick);
  c.on('pointerover', () => gsap.to(c.scale, { x: 1.08, y: 1.08, duration: 0.12 }));
  c.on('pointerout', () => gsap.to(c.scale, { x: 1.0, y: 1.0, duration: 0.12 }));
  return c;
}

function createStoneBetBtn(val, x, y, w, h, onClick) {
  const c = new PIXI.Container();
  c.x = x; c.y = y;
  c.eventMode = 'static';
  c.cursor = 'pointer';

  const s = new PIXI.Sprite(texBtnNormal);
  s.anchor.set(0.5);
  s.width = w;
  s.height = h;
  s.name = 'sprite';
  c.addChild(s);

  const t = new PIXI.Text(val.toString(), {
    fontFamily: 'Montserrat',
    fontSize: 15,
    fontWeight: '900',
    fill: 0xffffff
  });
  t.name = 'label';
  t.anchor.set(0.5);
  c.addChild(t);

  c.on('pointerdown', onClick);
  c.on('pointerover', () => gsap.to(c.scale, { x: 1.06, y: 1.06, duration: 0.12 }));
  c.on('pointerout', () => gsap.to(c.scale, { x: 1.0, y: 1.0, duration: 0.12 }));
  return c;
}

function highlightStoneBetBtn(btnContainer, active) {
  const s = btnContainer.getChildByName('sprite');
  const t = btnContainer.getChildByName('label');
  if (active) {
    s.texture = texBtnActive;
    t.style.fill = 0xffd700;
  } else {
    s.texture = texBtnNormal;
    t.style.fill = 0xffffff;
  }
}

function setBet(amount) {
  betAmount = amount;
  betButtons.forEach(b => highlightStoneBetBtn(b.btn, b.val === amount));
  if (betInputLabel) betInputLabel.text = amount.toString();
}

function toggleStepper() {
  if (isAutoPlay) {
    isAutoPlay = false;
    autoSpinsLeft = 0;
    gsap.killTweensOf(autoIco);
    gsap.to(autoIco, { rotation: 0, duration: 0.3 });
    winTextLabel.text = 'Auto-spin stopped';
    return;
  }
  stepperPanel.visible = !stepperPanel.visible;
  if (stepperPanel.visible) {
    gsap.fromTo(stepperPanel.scale, { y: 0 }, { y: 1, duration: 0.25, ease: 'back.out(1.5)' });
  }
}

// --- Dynamic Dragon Fire Breath VFX Stream Towards Winning Symbols ---
function animateDragonFireBreath(winningLines) {
  if (!winningLines || winningLines.length === 0) return;
  
  const primaryLine = winningLines[0];
  const targetRow = primaryLine.line[0];
  const dragonMouthX = 350;
  const dragonMouthY = 515;
  const targetX = GRID_X + primaryLine.matchCount * REEL_W - REEL_W / 2;
  const targetY = GRID_Y + targetRow * REEL_H + REEL_H / 2;

  let progress = { p: 0 };
  gsap.to(progress, {
    p: 1,
    duration: 1.0,
    ease: 'power2.out',
    onUpdate: () => {
      fireBreathGraphics.clear();
      const currentLength = progress.p;
      const endX = dragonMouthX + (targetX - dragonMouthX) * currentLength;
      const endY = dragonMouthY + (targetY - dragonMouthY) * currentLength;

      // Outer blazing flame cone
      fireBreathGraphics.lineStyle(34 * (1 - progress.p * 0.4), 0xff2200, 0.45);
      fireBreathGraphics.moveTo(dragonMouthX, dragonMouthY);
      fireBreathGraphics.lineTo(endX, endY);

      // Inner glowing orange stream
      fireBreathGraphics.lineStyle(18 * (1 - progress.p * 0.3), 0xff7700, 0.75);
      fireBreathGraphics.moveTo(dragonMouthX, dragonMouthY);
      fireBreathGraphics.lineTo(endX, endY);

      // Hot golden core beam
      fireBreathGraphics.lineStyle(8, 0xffea00, 0.95);
      fireBreathGraphics.moveTo(dragonMouthX, dragonMouthY);
      fireBreathGraphics.lineTo(endX, endY);

      // Fiery blast impact burst over winning symbols
      if (progress.p > 0.3) {
        const burstRadius = 55 * Math.sin(progress.p * Math.PI);
        fireBreathGraphics.beginFill(0xffaa00, 0.5);
        fireBreathGraphics.drawCircle(endX, endY, burstRadius);
        fireBreathGraphics.beginFill(0xff3300, 0.35);
        fireBreathGraphics.drawCircle(endX, endY, burstRadius * 1.6);
        fireBreathGraphics.endFill();
      }
    },
    onComplete: () => {
      gsap.to(fireBreathGraphics, {
        alpha: 0,
        duration: 0.4,
        onComplete: () => {
          fireBreathGraphics.clear();
          fireBreathGraphics.alpha = 1;
        }
      });
    }
  });
}

function drawWinningLines(winningLines) {
  paylineGraphics.clear();
  winningLines.forEach((wl) => {
    // Laser connecting line
    paylineGraphics.lineStyle(8, 0xff2a00, 0.55);
    const startX = GRID_X + REEL_W / 2;
    const startY = GRID_Y + wl.line[0] * REEL_H + REEL_H / 2;
    paylineGraphics.moveTo(startX, startY);

    for (let c = 1; c < wl.matchCount; c++) {
      const px = GRID_X + c * REEL_W + REEL_W / 2;
      const py = GRID_Y + wl.line[c] * REEL_H + REEL_H / 2;
      paylineGraphics.lineTo(px, py);
    }

    paylineGraphics.lineStyle(3.5, 0xffe033, 0.95);
    paylineGraphics.moveTo(startX, startY);
    for (let c = 1; c < wl.matchCount; c++) {
      const px = GRID_X + c * REEL_W + REEL_W / 2;
      const py = GRID_Y + wl.line[c] * REEL_H + REEL_H / 2;
      paylineGraphics.lineTo(px, py);
    }

    // Glowing frame around winning symbols
    for (let c = 0; c < wl.matchCount; c++) {
      const row = wl.line[c];
      const cx = GRID_X + c * REEL_W + REEL_W / 2;
      const cy = GRID_Y + row * REEL_H + REEL_H / 2;

      paylineGraphics.lineStyle(4, 0xff2a00, 0.9);
      paylineGraphics.drawRoundedRect(cx - 88, cy - 80, 176, 160, 14);

      paylineGraphics.lineStyle(2, 0xffd700, 0.95);
      paylineGraphics.drawRoundedRect(cx - 86, cy - 78, 172, 156, 12);

      const sprite = reels[c].symbols[row + 1];
      gsap.fromTo(sprite.scale, 
        { x: 1.15, y: 1.15 }, 
        { x: 1, y: 1, duration: 0.45, yoyo: true, repeat: 3 }
      );
    }
  });
}

function stopReel(colIdx) {
  const reel = reels[colIdx];
  reel.isSpinning = false;
  reel.speed = 0;
  if (window.audio) window.audio.playReelStop();

  gsap.to(reel, {
    offsetY: 0,
    duration: 0.15,
    ease: 'power2.out',
    onUpdate: () => {
      reel.symbols.forEach((s, idx) => {
        s.y = (idx - 1) * REEL_H + REEL_H / 2 + reel.offsetY;
      });
    },
    onComplete: () => {
      reel.offsetY = 0;
      reel.symbols.forEach((s, idx) => {
        s.y = (idx - 1) * REEL_H + REEL_H / 2;
      });
    }
  });

  gsap.fromTo(reel.container, 
    { y: GRID_Y - 18 }, 
    { y: GRID_Y, duration: 0.28, ease: 'bounce.out' }
  );
}

function evaluateLines() {
  const grid = [];
  for (let r = 0; r < ROWS; r++) {
    const row = [];
    for (let c = 0; c < COLS; c++) {
      row.push(reels[c].symbols[r + 1].symData);
    }
    grid.push(row);
  }

  let totalWin = 0;
  const winningLines = [];

  PAYLINES.forEach((line, lineIdx) => {
    const firstSym = grid[line[0]][0];
    let matchCount = 1;
    let mainSym = firstSym;

    for (let c = 1; c < COLS; c++) {
      const sym = grid[line[c]][c];
      if (sym.isScatter) break;

      if (mainSym.isWild && !sym.isScatter) {
        mainSym = sym;
        matchCount++;
      } else if (sym.id === mainSym.id || sym.isWild) {
        matchCount++;
      } else {
        break;
      }
    }

    if (matchCount >= 3 && mainSym.payout && mainSym.payout[matchCount - 1]) {
      const linePayout = (mainSym.payout[matchCount - 1] / 10) * betAmount;
      totalWin += linePayout;
      winningLines.push({ lineIdx, line, matchCount, win: linePayout });
    }
  });

  if (totalWin > 0) {
    balance += totalWin;
    totalWinnings += totalWin;
    updateUILabel();
    winTextLabel.text = `You have won ${totalWin.toFixed(0)} BDT`;

    const isBig = totalWin >= betAmount * 10;
    if (typeof window.triggerWinCelebration === 'function') {
      window.triggerWinCelebration({
        amount: totalWin,
        multiplier: betAmount > 0 ? (totalWin / betAmount) : 0,
        title: isBig ? 'BURNING MEGA JACKPOT!' : 'BURNING HOT WIN!'
      });
    }
    if (window.audio) {
      window.audio.playWin(isBig);
      window.audio.playRoar();
      window.audio.playFireWoosh();
    }

    // Dragon roars & breathes fire
    if (dragonSpine) {
      playSpine(dragonSpine, isBig ? ['firedragon', 'megawinS', 'winL'] : ['firedragon', 'winL'], false);
    }
    if (knightSpine) {
      playSpine(knightSpine, isBig ? ['winP', 'swordfire_3', 'idleC'] : ['winP', 'idleC'], false);
    }
    if (teethSpine) {
      playSpine(teethSpine, ['megawin', 'idle'], false);
    }
    if (fireSpineMain) {
      playSpine(fireSpineMain, ['megawin', 'idle'], false);
    }

    // Targeted fire blast directly onto winning lines
    animateDragonFireBreath(winningLines);
    drawWinningLines(winningLines);

    gsap.fromTo(bannerContainer.scale, 
      { x: 1.25, y: 1.25 }, 
      { x: 1, y: 1, duration: 0.6, ease: 'elastic.out(1, 0.4)' }
    );

  } else {
    winTextLabel.text = 'Place a bet';
    if (dragonSpine && Math.random() < 0.25) {
      playSpine(dragonSpine, ['lose6', 'idle'], false);
    }
  }
}

async function startSpin() {
  if (isSpinning) return;
  if (balance < betAmount) {
    winTextLabel.text = 'NOT ENOUGH BALANCE!';
    isAutoPlay = false;
    return;
  }

  const backendPromise = syncBackendSpin(betAmount);
  isSpinning = true;
  balance -= betAmount;
  updateUILabel();
  paylineGraphics.clear();
  fireBreathGraphics.clear();
  winTextLabel.text = 'Place a bet';

  if (teethSpine) playSpine(teethSpine, ['idle'], true);

  reels.forEach((r, i) => {
    r.isSpinning = true;
    r.speed = 34 + i * 2;
  });

  for (let i = 0; i < COLS; i++) {
    await new Promise(res => setTimeout(res, 350 + i * 220));
    stopReel(i);
  }

  await new Promise(res => setTimeout(res, 200));

  evaluateLines();

  try {
    const backendData = await backendPromise;
    if (backendData && backendData.new_balance !== undefined) {
      balance = backendData.new_balance;
      updateUILabel();
    }
  } catch(e) {}

  isSpinning = false;

  if (isAutoPlay) {
    if (autoSpinsLeft > 0) autoSpinsLeft--;
    if (autoSpinsLeft <= 0) {
      isAutoPlay = false;
      gsap.killTweensOf(autoIco);
      gsap.to(autoIco, { rotation: 0, duration: 0.3 });
    } else {
      setTimeout(() => {
        if (isAutoPlay) startSpin();
      }, 1400);
    }
  }
}

// --- Main Init Game Function ---
async function initGame() {
  const fillBar = document.getElementById('loader-fill');
  const loadText = document.getElementById('loader-text');

  const updateProgress = (pct, text) => {
    if (fillBar) fillBar.style.width = pct + '%';
    if (loadText) loadText.innerText = `${text} (${pct}%)...`;
  };

  try {
    updateProgress(15, 'Loading Reel Strip & UI Assets');
    const imageAssets = [
      'assets/images/seven@1x.47c93c5fff34.png',
      'assets/images/wild@1x.ce9e11eee8a3.png',
      'assets/images/pineapple@1x.04c72313c609.png',
      'assets/images/banana@1x.a53d4bebf89f.png',
      'assets/images/dollar@1x.dec7b2a8aa68.png',
      'assets/images/grape@1x.cda5aaac27f6.png',
      'assets/images/apple@1x.39cb85a3a931.png',
      'assets/images/cherry@1x.e8d1c9ede2b2.png',
      'assets/images/star@1x.5cbf98edaae9.png',
      'assets/images/pear@1x.b94afb436fdc.png',
      'assets/images/strawberry@1x.d4f6a8e41134.png',
      'assets/images/background@1x.1a582058ade0.jpg',
      'assets/images/background_center@1x.d546ace946f7.png',
      'assets/images/columns_left@1x.269af679de6a.png',
      'assets/images/columns_right@1x.85e4e2ed4a1b.png',
      'assets/images/frame@1x.200ab98c6d00.png',
      'assets/images/lava_left@1x.8e0c6c8f7786.png',
      'assets/images/lava_right@1x.43a579026b8d.png',
      'assets/images/stalagmites@1x.b0353f668672.png',
      'assets/images/stones_left@1x.ba277d235194.png',
      'assets/images/stones_right@1x.200495049859.png',
      'assets/images/stones_down@1x.f149b7983717.png',
      'assets/images/stones@1x.b0d4efaf85c8.png',
      'assets/images/stone_left@1x.635d3414dedd.png',
      'assets/images/stone_right@1x.17ba26f79263.png',
      'assets/images/field@1x.210b678b776f.png',
      'assets/images/ui_stone@1x.03c691d70a3d.png',
      'assets/images/text_field@1x.e6042bee27b6.png',
      'assets/images/popup-chains.d70228420934.png',
      'assets/images/play-btn.717cefcbbef9.png',
      'assets/images/autogame-btn.a847e514aa65.png',
      'assets/images/autogame-ico.9a49e93efeb9.png',
      'assets/images/bet-btn.1a12209d9578.png',
      'assets/images/btn.220a3dabdb4a.png',
      'assets/images/input-bg.848f7b7be0a7.png',
      'assets/images/input-cross.120e84c357a0.png',
      'assets/images/stepper-panel.525405bb2845.png',
      'assets/images/desktop-sheet-l.21849046d044.png',
      'assets/images/win_frame@1x.e74a3e9b3763.png',
      'assets/images/win_line@1x.a0b4992ea8b9.png'
    ];

    for (let i = 0; i < imageAssets.length; i++) {
      const fullSrc = getAssetPath(imageAssets[i]);
      PIXI.Assets.add({ alias: imageAssets[i], src: fullSrc });
    }
    await PIXI.Assets.load(imageAssets);

    // High-Resolution Card Symbols
    symbolTextures = STRIP_SYMBOLS.map(sym => PIXI.Assets.get(`assets/images/${sym.file}`));

    // UI Textures
    const playBase = PIXI.Assets.get('assets/images/play-btn.717cefcbbef9.png');
    texPlayBtn = new PIXI.Texture(playBase.baseTexture, new PIXI.Rectangle(0, 0, 380, 340));

    const autoBtnBase = PIXI.Assets.get('assets/images/autogame-btn.a847e514aa65.png');
    texAutoBtn = new PIXI.Texture(autoBtnBase.baseTexture, new PIXI.Rectangle(2, 2, 202, 202));

    const autoIcoBase = PIXI.Assets.get('assets/images/autogame-ico.9a49e93efeb9.png');
    texAutoIco = new PIXI.Texture(autoIcoBase.baseTexture, new PIXI.Rectangle(0, 0, 98, 97));

    const btnBase = PIXI.Assets.get('assets/images/btn.220a3dabdb4a.png');
    texBtnNormal = new PIXI.Texture(btnBase.baseTexture, new PIXI.Rectangle(2, 2, 184, 124));

    const betBtnBase = PIXI.Assets.get('assets/images/bet-btn.1a12209d9578.png');
    texBtnActive = new PIXI.Texture(betBtnBase.baseTexture, new PIXI.Rectangle(2, 2, 286, 144));

    const crossBase = PIXI.Assets.get('assets/images/input-cross.120e84c357a0.png');
    texInputCross = new PIXI.Texture(crossBase.baseTexture, new PIXI.Rectangle(2, 2, 41, 43));

    updateProgress(45, 'Loading Dragon Spine Model');
    PIXI.Assets.add({ alias: 'dragonSkel', src: getAssetPath('assets/spines/dragon.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/dragon.atlas') } });
    const dragonRes = await PIXI.Assets.load('dragonSkel');

    updateProgress(60, 'Loading Warrior Knight Spine Model');
    PIXI.Assets.add({ alias: 'knightSkel', src: getAssetPath('assets/spines/knight.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/knight.atlas') } });
    const knightRes = await PIXI.Assets.load('knightSkel');

    updateProgress(75, 'Loading Fire, Teeth & Logo Spines');
    PIXI.Assets.add({ alias: 'fireSkel', src: getAssetPath('assets/spines/fire.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/fire.atlas') } });
    PIXI.Assets.add({ alias: 'teethSkel', src: getAssetPath('assets/spines/teeth.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/teeth.atlas') } });
    PIXI.Assets.add({ alias: 'logoSkel', src: getAssetPath('assets/spines/logo.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/logo.atlas') } });
    PIXI.Assets.add({ alias: 'bg1Skel', src: getAssetPath('assets/spines/background_1.skel'), data: { spineAtlasFile: getAssetPath('assets/spines/background_1.atlas') } });

    const [fireRes, teethRes, logoRes, bg1Res] = await Promise.all([
      PIXI.Assets.load('fireSkel'),
      PIXI.Assets.load('teethSkel'),
      PIXI.Assets.load('logoSkel'),
      PIXI.Assets.load('bg1Skel')
    ]);

    updateProgress(95, 'Building Authentic 1xBet Scene');

    app = new PIXI.Application({
      view: document.getElementById('game-canvas'),
      width: 1920,
      height: 1080,
      backgroundColor: 0x08020a,
      antialias: true,
      resolution: Math.min(window.devicePixelRatio || 1, 2),
      autoDensity: true
    });

    // --- LAYER 1: Background & Cave Environment ---
    const bgLayer = new PIXI.Container();
    app.stage.addChild(bgLayer);

    const bgSprite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/background@1x.1a582058ade0.jpg'));
    bgSprite.anchor.set(0.5);
    bgSprite.x = 960;
    bgSprite.y = 540;
    bgSprite.width = 1920;
    bgSprite.height = 1080;
    bgLayer.addChild(bgSprite);

    const bgCenter = PIXI.Sprite.from(PIXI.Assets.get('assets/images/background_center@1x.d546ace946f7.png'));
    bgCenter.x = 240;
    bgCenter.y = 150;
    bgLayer.addChild(bgCenter);

    const lavaL = PIXI.Sprite.from(PIXI.Assets.get('assets/images/lava_left@1x.8e0c6c8f7786.png'));
    lavaL.x = 0;
    lavaL.y = 500;
    bgLayer.addChild(lavaL);

    const lavaR = PIXI.Sprite.from(PIXI.Assets.get('assets/images/lava_right@1x.43a579026b8d.png'));
    lavaR.x = 1350;
    lavaR.y = 500;
    bgLayer.addChild(lavaR);

    if (bg1Res && bg1Res.spineData) {
      bg1Spine = new PIXI.spine.Spine(bg1Res.spineData);
      bg1Spine.x = 960;
      bg1Spine.y = 700;
      playSpine(bg1Spine, ['idle', 'loop'], true);
      bgLayer.addChild(bg1Spine);
    }

    // Cave Columns & Stalagmites
    const colL = PIXI.Sprite.from(PIXI.Assets.get('assets/images/columns_left@1x.269af679de6a.png'));
    colL.x = 0;
    colL.y = 0;
    bgLayer.addChild(colL);

    const colR = PIXI.Sprite.from(PIXI.Assets.get('assets/images/columns_right@1x.85e4e2ed4a1b.png'));
    colR.x = 1380;
    colR.y = 0;
    bgLayer.addChild(colR);

    const stalagmite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/stalagmites@1x.b0353f668672.png'));
    stalagmite.x = 640;
    stalagmite.y = 0;
    bgLayer.addChild(stalagmite);

    const outerFrame = PIXI.Sprite.from(PIXI.Assets.get('assets/images/frame@1x.200ab98c6d00.png'));
    outerFrame.x = -290;
    outerFrame.y = -120;
    outerFrame.width = 2500;
    outerFrame.height = 1320;
    bgLayer.addChild(outerFrame);

    // --- LAYER 2: Slot Grid & Authentic Large Symbols ---
    const reelLayer = new PIXI.Container();
    app.stage.addChild(reelLayer);

    const fieldBg = PIXI.Sprite.from(PIXI.Assets.get('assets/images/field@1x.210b678b776f.png'));
    fieldBg.x = 460;
    fieldBg.y = 150;
    fieldBg.width = 1000;
    fieldBg.height = 560;
    reelLayer.addChild(fieldBg);

    // 5x3 Compact Cell Backing Plates (matching 1xBet proportions)
    const tilesContainer = new PIXI.Container();
    for (let c = 0; c < COLS; c++) {
      for (let r = 0; r < ROWS; r++) {
        const tileBg = new PIXI.Graphics();
        tileBg.beginFill(0x0e081c, 0.75);
        tileBg.lineStyle(1.5, 0x2e1b48, 0.85);
        tileBg.drawRoundedRect(
          GRID_X + c * REEL_W + 4,
          GRID_Y + r * REEL_H + 4,
          REEL_W - 8,
          REEL_H - 8,
          10
        );
        tileBg.endFill();
        tilesContainer.addChild(tileBg);
      }
    }
    reelLayer.addChild(tilesContainer);

    const reelMask = new PIXI.Graphics();
    reelMask.beginFill(0xffffff);
    reelMask.drawRoundedRect(GRID_X, GRID_Y, REEL_W * COLS, REEL_H * ROWS, 12);
    reelMask.endFill();
    reelLayer.addChild(reelMask);

    const reelsContainer = new PIXI.Container();
    reelsContainer.mask = reelMask;
    reelLayer.addChild(reelsContainer);

    // 5 Reel Columns with prominent, large symbol scaling (176px)
    for (let c = 0; c < COLS; c++) {
      const colContainer = new PIXI.Container();
      colContainer.x = GRID_X + c * REEL_W + REEL_W / 2;
      colContainer.y = GRID_Y;

      const reelSymbols = [];
      for (let r = 0; r < ROWS + 2; r++) {
        const symData = getRandomSymbol();
        
        const symSprite = new PIXI.Sprite(symbolTextures[symData.index]);
        symSprite.anchor.set(0.5);
        symSprite.y = (r - 1) * REEL_H + REEL_H / 2;
        symSprite.width = 176;
        symSprite.height = 176;
        symSprite.symData = symData;

        colContainer.addChild(symSprite);
        reelSymbols.push(symSprite);
      }

      reelsContainer.addChild(colContainer);
      reels.push({
        container: colContainer,
        symbols: reelSymbols,
        offsetY: 0,
        speed: 0,
        isSpinning: false
      });
    }

    // Side Stone Pillars
    const stoneLeft = PIXI.Sprite.from(PIXI.Assets.get('assets/images/stone_left@1x.635d3414dedd.png'));
    stoneLeft.x = 380;
    stoneLeft.y = 145;
    reelLayer.addChild(stoneLeft);

    const stoneRight = PIXI.Sprite.from(PIXI.Assets.get('assets/images/stone_right@1x.17ba26f79263.png'));
    stoneRight.x = 1400;
    stoneRight.y = 155;
    reelLayer.addChild(stoneRight);

    // Animated Monster Teeth
    if (teethRes && teethRes.spineData) {
      teethSpine = new PIXI.spine.Spine(teethRes.spineData);
      teethSpine.x = 960;
      teethSpine.y = 445;
      playSpine(teethSpine, ['idle'], true);
      reelLayer.addChild(teethSpine);
    }

    paylineGraphics = new PIXI.Graphics();
    reelLayer.addChild(paylineGraphics);

    fireBreathGraphics = new PIXI.Graphics();
    reelLayer.addChild(fireBreathGraphics);

    // --- LAYER 3: Characters (Dragon & Knight Elevated for Full Visibility) ---
    const charLayer = new PIXI.Container();
    app.stage.addChild(charLayer);

    // DRAGON (Left side)
    if (dragonRes && dragonRes.spineData) {
      dragonSpine = new PIXI.spine.Spine(dragonRes.spineData);
      dragonSpine.x = 310;
      dragonSpine.y = 690;
      dragonSpine.scale.set(0.96);
      playSpine(dragonSpine, ['idle', 'loop'], true);
      charLayer.addChild(dragonSpine);
    }

    // WARRIOR KNIGHT (Right side - elevated so sword and tip are completely visible)
    if (knightRes && knightRes.spineData) {
      knightSpine = new PIXI.spine.Spine(knightRes.spineData);
      knightSpine.x = 1590;
      knightSpine.y = 690;
      knightSpine.scale.set(0.95);
      playSpine(knightSpine, ['idle', 'idleC', 'loop'], true);
      charLayer.addChild(knightSpine);
    }

    // LOGO (Top right)
    if (logoRes && logoRes.spineData) {
      logoSpine = new PIXI.spine.Spine(logoRes.spineData);
      logoSpine.x = 1620;
      logoSpine.y = 135;
      logoSpine.scale.set(0.85);
      playSpine(logoSpine, ['idle', 'idle_random', 'loop'], true);
      charLayer.addChild(logoSpine);
    }

    // --- LAYER 4: Bottom Lava Ground & Blazing Fire Effects ---
    const lavaGroundLayer = new PIXI.Container();
    app.stage.addChild(lavaGroundLayer);

    const stonesDown = PIXI.Sprite.from(PIXI.Assets.get('assets/images/stones_down@1x.f149b7983717.png'));
    stonesDown.anchor.set(0.5);
    stonesDown.x = 960;
    stonesDown.y = 975;
    stonesDown.width = 1920;
    stonesDown.height = 300;
    lavaGroundLayer.addChild(stonesDown);

    // Blazing Fire Spine under Footer rock crevices and Bet buttons
    if (fireRes && fireRes.spineData) {
      fireSpineMain = new PIXI.spine.Spine(fireRes.spineData);
      fireSpineMain.x = 940;
      fireSpineMain.y = 990;
      fireSpineMain.scale.set(1.15);
      playSpine(fireSpineMain, ['idle'], true);
      lavaGroundLayer.addChild(fireSpineMain);

      fireSpineLeft = new PIXI.spine.Spine(fireRes.spineData);
      fireSpineLeft.x = 640;
      fireSpineLeft.y = 1000;
      fireSpineLeft.scale.set(0.85);
      playSpine(fireSpineLeft, ['idle'], true);
      lavaGroundLayer.addChild(fireSpineLeft);

      fireSpineRight = new PIXI.spine.Spine(fireRes.spineData);
      fireSpineRight.x = 1260;
      fireSpineRight.y = 1000;
      fireSpineRight.scale.set(0.85);
      playSpine(fireSpineRight, ['idle'], true);
      lavaGroundLayer.addChild(fireSpineRight);
    }

    // --- LAYER 5: UI & Control Panel ---
    const uiLayer = new PIXI.Container();
    app.stage.addChild(uiLayer);

    // TOP STONE TABLET (Place a bet / Win message banner)
    bannerContainer = new PIXI.Container();
    bannerContainer.x = 960;
    bannerContainer.y = 80;
    bannerContainer.pivot.set(0.5);

    const chainsSprite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/popup-chains.d70228420934.png'));
    chainsSprite.anchor.set(0.5);
    chainsSprite.y = -30;
    chainsSprite.width = 460;
    chainsSprite.height = 95;
    bannerContainer.addChild(chainsSprite);

    const textFieldSprite = PIXI.Sprite.from(PIXI.Assets.get('assets/images/text_field@1x.e6042bee27b6.png'));
    textFieldSprite.anchor.set(0.5);
    textFieldSprite.width = 480;
    textFieldSprite.height = 105;
    bannerContainer.addChild(textFieldSprite);

    winTextLabel = new PIXI.Text('Place a bet', {
      fontFamily: 'Montserrat, sans-serif',
      fontSize: 22,
      fontWeight: '700',
      fill: 0xffffff,
      align: 'center',
      dropShadow: true,
      dropShadowColor: '#000000',
      dropShadowBlur: 6
    });
    winTextLabel.anchor.set(0.5);
    winTextLabel.y = 0;
    bannerContainer.addChild(winTextLabel);
    uiLayer.addChild(bannerContainer);

    // STONE SLAB BOTTOM CONTROL PANEL (Moved completely down flush with bottom edge)
    const controlPanel = new PIXI.Container();
    controlPanel.x = 960;
    controlPanel.y = 995;
    controlPanel.pivot.set(0.5);

    const uiStone = PIXI.Sprite.from(PIXI.Assets.get('assets/images/ui_stone@1x.03c691d70a3d.png'));
    uiStone.anchor.set(0.5);
    uiStone.width = 1160;
    uiStone.height = 180;
    controlPanel.addChild(uiStone);

    // Left Bet Input Display with 'x' cross
    const inputContainer = new PIXI.Container();
    inputContainer.x = -365;
    inputContainer.y = -30;

    const inputBg = PIXI.Sprite.from(PIXI.Assets.get('assets/images/input-bg.848f7b7be0a7.png'));
    inputBg.anchor.set(0.5);
    inputBg.width = 140;
    inputBg.height = 42;
    inputContainer.addChild(inputBg);

    betInputLabel = new PIXI.Text(betAmount.toString(), {
      fontFamily: 'Montserrat',
      fontSize: 18,
      fontWeight: 'bold',
      fill: 0xffffff
    });
    betInputLabel.anchor.set(0.5);
    betInputLabel.x = -20;
    inputContainer.addChild(betInputLabel);

    const crossBtn = new PIXI.Sprite(texInputCross);
    crossBtn.anchor.set(0.5);
    crossBtn.x = 42;
    crossBtn.width = 18;
    crossBtn.height = 18;
    crossBtn.eventMode = 'static';
    crossBtn.cursor = 'pointer';
    crossBtn.on('pointerdown', () => {
      if (window.audio) {
        window.audio.init();
        window.audio.playClick();
      }
      setBet(20);
    });
    inputContainer.addChild(crossBtn);
    controlPanel.addChild(inputContainer);

    // Info Button (i) -> Opens the Authentic 1xBet Rules Modal
    const infoBtn = createGlassBtn('i', -365, 18, 42, 38, () => {
      openModal();
    });
    controlPanel.addChild(infoBtn);

    // 6 Bet Presets: Top row [20, 100, 300] and Bottom row [800, 3000, 10000]
    const betValues = [20, 100, 300, 800, 3000, 10000];
    betValues.forEach((val, i) => {
      const isTopRow = i < 3;
      const col = i % 3;
      const bx = -205 + col * 98;
      const by = isTopRow ? -30 : 18;
      const btn = createStoneBetBtn(val, bx, by, 92, 38, () => {
        if (window.audio) {
          window.audio.init();
          window.audio.playClick();
        }
        setBet(val);
      });
      if (val === betAmount) highlightStoneBetBtn(btn, true);
      controlPanel.addChild(btn);
      betButtons.push({ val, btn });
    });

    // Spin Button
    const spinBtnContainer = new PIXI.Container();
    spinBtnContainer.x = 175;
    spinBtnContainer.y = -6;
    spinBtnContainer.eventMode = 'static';
    spinBtnContainer.cursor = 'pointer';

    const playBtnImg = new PIXI.Sprite(texPlayBtn);
    playBtnImg.anchor.set(0.5);
    playBtnImg.width = 96;
    playBtnImg.height = 96;
    spinBtnContainer.addChild(playBtnImg);

    spinBtnContainer.on('pointerdown', () => {
      if (window.audio) {
        window.audio.init();
        window.audio.playClick();
      }
      gsap.fromTo(spinBtnContainer.scale, { x: 0.94, y: 0.94 }, { x: 1.0, y: 1.0, duration: 0.15 });
      startSpin();
    });
    controlPanel.addChild(spinBtnContainer);

    // Auto-spin Button
    const autoBtn = new PIXI.Container();
    autoBtn.x = 265;
    autoBtn.y = -4;
    autoBtn.eventMode = 'static';
    autoBtn.cursor = 'pointer';

    const autoBtnBg = new PIXI.Sprite(texAutoBtn);
    autoBtnBg.anchor.set(0.5);
    autoBtnBg.width = 54;
    autoBtnBg.height = 54;
    autoBtn.addChild(autoBtnBg);

    autoIco = new PIXI.Sprite(texAutoIco);
    autoIco.anchor.set(0.5);
    autoIco.width = 32;
    autoIco.height = 32;
    autoBtn.addChild(autoIco);

    autoBtn.on('pointerdown', () => {
      if (window.audio) {
        window.audio.init();
        window.audio.playClick();
      }
      toggleStepper();
    });
    controlPanel.addChild(autoBtn);

    // Stepper Popup Panel
    stepperPanel = new PIXI.Container();
    stepperPanel.x = 265;
    stepperPanel.y = -190;
    stepperPanel.visible = false;
    stepperPanel.pivot.set(0.5);

    const stepperBg = PIXI.Sprite.from(PIXI.Assets.get('assets/images/stepper-panel.525405bb2845.png'));
    stepperBg.anchor.set(0.5);
    stepperBg.width = 80;
    stepperBg.height = 260;
    stepperPanel.addChild(stepperBg);

    const autoOptions = [
      { count: 5, label: '5' },
      { count: 10, label: '10' },
      { count: 20, label: '20' },
      { count: 50, label: '50' },
      { count: 9999, label: '∞' }
    ];

    autoOptions.forEach((opt, idx) => {
      const optY = -95 + idx * 46;
      const optBtn = new PIXI.Container();
      optBtn.y = optY;
      optBtn.eventMode = 'static';
      optBtn.cursor = 'pointer';

      const optText = new PIXI.Text(opt.label, {
        fontFamily: 'Montserrat',
        fontSize: 18,
        fontWeight: 'bold',
        fill: 0xffd700
      });
      optText.anchor.set(0.5);
      optBtn.addChild(optText);

      optBtn.on('pointerdown', () => {
        if (window.audio) {
          window.audio.init();
          window.audio.playClick();
        }
        autoSpinsLeft = opt.count;
        isAutoPlay = true;
        stepperPanel.visible = false;
        gsap.to(autoIco, { rotation: Math.PI * 8, duration: 2, repeat: -1, ease: 'linear' });
        if (!isSpinning) startSpin();
      });
      stepperPanel.addChild(optBtn);
    });
    controlPanel.addChild(stepperPanel);

    // Right side tools rail
    const rightRail = new PIXI.Container();
    rightRail.x = 1880;
    rightRail.y = 540;
    const railIcons = ['⚙', '🎁', '7', '🎲', '$'];
    railIcons.forEach((ico, i) => {
      const rb = new PIXI.Container();
      rb.y = -120 + i * 60;
      const rbg = new PIXI.Graphics();
      rbg.beginFill(0x130a1e, 0.85);
      rbg.lineStyle(1, 0x3f2260, 1);
      rbg.drawRoundedRect(-20, -20, 40, 40, 6);
      rbg.endFill();
      rb.addChild(rbg);
      const rt = new PIXI.Text(ico, { fontFamily: 'Montserrat', fontSize: 16, fill: 0xb59bc8 });
      rt.anchor.set(0.5);
      rb.addChild(rt);
      rightRail.addChild(rb);
    });
    uiLayer.addChild(rightRail);

    uiLayer.addChild(controlPanel);

    // Finish Loading
    updateProgress(100, 'Game Ready!');
    setTimeout(() => {
      const loader = document.getElementById('loading-overlay');
      if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 500);
      }
    }, 300);

    // --- PIXI Ticker Animation Loop ---
    app.ticker.add((delta) => {
      reels.forEach((reel) => {
        if (reel.isSpinning) {
          reel.offsetY += reel.speed * delta;
          if (window.audio) window.audio.playSpinLoop();
          if (reel.offsetY >= REEL_H) {
            reel.offsetY -= REEL_H;
            const last = reel.symbols.pop();
            const newSym = getRandomSymbol();
            last.texture = symbolTextures[newSym.index];
            last.symData = newSym;
            reel.symbols.unshift(last);
          }
          reel.symbols.forEach((s, idx) => {
            s.y = (idx - 1) * REEL_H + REEL_H / 2 + reel.offsetY;
          });
        }
      });
    });

  } catch (err) {
    console.error('Initialization Error:', err);
    if (loadText) loadText.innerText = 'Error: ' + err.message;
  }
}

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
  initGame();
});
