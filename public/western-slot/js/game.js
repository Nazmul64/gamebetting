/**
 * WESTERN SLOT - Authentic Wild West Slot Game Engine
 * Built with HTML5, CSS3, and Web Audio API
 */

(function () {
  'use strict';

  const BASE_PATH = (typeof window !== 'undefined' && window.WESTERN_SLOT_BASE) ? window.WESTERN_SLOT_BASE : '';

  // --- SYMBOLS CONFIGURATION ---
  const SYMBOLS = [
    { id: 0, name: 'Whiskey', src: BASE_PATH + 'icon-zero.4885140b0230.png', activeSrc: BASE_PATH + 'icon-zero-active.62b4df73620e.png', payouts: { 5: 150, 4: 30, 3: 8 } },
    { id: 1, name: 'Wagon', src: BASE_PATH + 'icon-one.5928412251a7.png', activeSrc: BASE_PATH + 'icon-one-active.98b4264febde.png', payouts: { 5: 200, 4: 40, 3: 10 } },
    { id: 2, name: 'Dynamite', src: BASE_PATH + 'icon-two.8078b2bd4712.png', activeSrc: BASE_PATH + 'icon-two-active.b53d32c089e2.png', payouts: { 5: 500, 4: 100, 3: 25 } },
    { id: 3, name: 'Sheriff', src: BASE_PATH + 'icon-three.af38e95cacd2.png', activeSrc: BASE_PATH + 'icon-three-active.7d8fd7f9efdf.png', payouts: { 5: 1000, 4: 250, 3: 50 } },
    { id: 4, name: 'Horseshoe', src: BASE_PATH + 'icon-four.682eece0964c.png', activeSrc: BASE_PATH + 'icon-four-active.babe37deb6d5.png', payouts: { 5: 250, 4: 50, 3: 15 } },
    { id: 5, name: 'Skull', src: BASE_PATH + 'icon-five.407eaf70ce0e.png', activeSrc: BASE_PATH + 'icon-five-active.fdb03399d8cd.png', payouts: { 5: 300, 4: 75, 3: 20 } },
    { id: 6, name: 'MoneyBag', src: BASE_PATH + 'icon-six.694a7c422b25.png', activeSrc: BASE_PATH + 'icon-six-active.d5d7dd71debb.png', payouts: { 5: 750, 4: 150, 3: 35 } },
    { id: 7, name: 'BanditHat', src: BASE_PATH + 'icon-seven.ce2db4f391cd.png', activeSrc: BASE_PATH + 'icon-seven-active.23ca88e96901.png', payouts: { 5: 1500, 4: 400, 3: 75 } },
    { id: 8, name: 'WildHorse', src: BASE_PATH + 'icon-eight-active.a872da2b9449.png', activeSrc: BASE_PATH + 'icon-eight-active.a872da2b9449.png', payouts: { 5: 5000, 4: 1000, 3: 200, 2: 20 }, isWild: true },
    { id: 9, name: 'Jackpot', src: BASE_PATH + 'icon-nine.108c5d8b1f0b.png', activeSrc: BASE_PATH + 'icon-nine-active.7f95f6b4eb27.png', payouts: { 5: 'JACKPOT', 4: 500, 3: 100 }, isJackpot: true }
  ];

  // --- 9 PAYLINES COORDINATES [Reel 0..4, Row 0..2] ---
  const PAYLINES = [
    { id: 1, name: 'Middle Line', coords: [1, 1, 1, 1, 1] },
    { id: 2, name: 'Top Line', coords: [0, 0, 0, 0, 0] },
    { id: 3, name: 'Bottom Line', coords: [2, 2, 2, 2, 2] },
    { id: 4, name: 'V-Shape', coords: [0, 1, 2, 1, 0] },
    { id: 5, name: 'Inverted-V', coords: [2, 1, 0, 1, 2] },
    { id: 6, name: 'Top Ridge', coords: [0, 0, 1, 2, 2] },
    { id: 7, name: 'Bottom Ridge', coords: [2, 2, 1, 0, 0] },
    { id: 8, name: 'Top Zigzag', coords: [1, 0, 1, 0, 1] },
    { id: 9, name: 'Bottom Zigzag', coords: [1, 2, 1, 2, 1] }
  ];

  // --- GAME STATE ---
  let state = {
    balance: (typeof window !== 'undefined' && window.USER_BALANCE !== undefined) ? Number(window.USER_BALANCE) : 5000.00,
    stakePerLine: 20,
    activeLines: 1,
    totalStake: 20.00,
    lastWin: 0.00,
    jackpot: 14937.52,
    isSpinning: false,
    isTurbo: false,
    isAutoPlay: false,
    autoPlayCount: 0,
    soundEnabled: true,
    reelsState: [
      [5, 2, 7],
      [6, 1, 3],
      [1, 1, 6],
      [3, 6, 7],
      [5, 7, 7]
    ]
  };

  // --- AUDIO SYNTHESIZER (Web Audio API) ---
  let audioCtx = null;

  function initAudio() {
    if (!audioCtx) {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      if (AudioContext) {
        audioCtx = new AudioContext();
      }
    }
    if (audioCtx && audioCtx.state === 'suspended') {
      audioCtx.resume();
    }
  }

  function playSound(type) {
    if (!state.soundEnabled) return;
    initAudio();
    if (!audioCtx) return;

    const now = audioCtx.currentTime;

    switch (type) {
      case 'click': {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(450, now);
        osc.frequency.exponentialRampToValueAtTime(150, now + 0.04);
        gain.gain.setValueAtTime(0.2, now);
        gain.gain.exponentialRampToValueAtTime(0.01, now + 0.04);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start(now);
        osc.stop(now + 0.04);
        break;
      }
      case 'lever': {
        // Heavy metallic mechanical clunk
        const bufferSize = audioCtx.sampleRate * 0.15;
        const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
          data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (audioCtx.sampleRate * 0.03));
        }
        const noise = audioCtx.createBufferSource();
        noise.buffer = buffer;
        const filter = audioCtx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(350, now);
        const gain = audioCtx.createGain();
        gain.gain.setValueAtTime(0.4, now);
        gain.gain.exponentialRampToValueAtTime(0.01, now + 0.15);
        noise.connect(filter);
        filter.connect(gain);
        gain.connect(audioCtx.destination);
        noise.start(now);
        break;
      }
      case 'reel-spin': {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(90, now);
        osc.frequency.linearRampToValueAtTime(120, now + 0.06);
        gain.gain.setValueAtTime(0.06, now);
        gain.gain.linearRampToValueAtTime(0.01, now + 0.06);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start(now);
        osc.stop(now + 0.06);
        break;
      }
      case 'reel-stop': {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(180, now);
        osc.frequency.exponentialRampToValueAtTime(45, now + 0.09);
        gain.gain.setValueAtTime(0.35, now);
        gain.gain.exponentialRampToValueAtTime(0.01, now + 0.09);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start(now);
        osc.stop(now + 0.09);
        break;
      }
      case 'win': {
        // Wild west saloon victory arpeggio
        const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
        notes.forEach((freq, idx) => {
          const osc = audioCtx.createOscillator();
          const gain = audioCtx.createGain();
          osc.type = 'triangle';
          osc.frequency.setValueAtTime(freq, now + idx * 0.08);
          gain.gain.setValueAtTime(0.3, now + idx * 0.08);
          gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.08 + 0.35);
          osc.connect(gain);
          gain.connect(audioCtx.destination);
          osc.start(now + idx * 0.08);
          osc.stop(now + idx * 0.08 + 0.35);
        });
        break;
      }
      case 'big-win': {
        // High energy fanfare
        const notes = [440, 554.37, 659.25, 880, 1108.73, 1318.51];
        notes.forEach((freq, idx) => {
          const osc = audioCtx.createOscillator();
          const gain = audioCtx.createGain();
          osc.type = 'square';
          osc.frequency.setValueAtTime(freq, now + idx * 0.1);
          gain.gain.setValueAtTime(0.18, now + idx * 0.1);
          gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.1 + 0.4);
          osc.connect(gain);
          gain.connect(audioCtx.destination);
          osc.start(now + idx * 0.1);
          osc.stop(now + idx * 0.1 + 0.4);
        });
        break;
      }
      case 'gunshot': {
        // Western revolver shot & echo
        const bufferSize = audioCtx.sampleRate * 0.4;
        const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
          data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (audioCtx.sampleRate * 0.05));
        }
        const noise = audioCtx.createBufferSource();
        noise.buffer = buffer;
        const gain = audioCtx.createGain();
        gain.gain.setValueAtTime(0.6, now);
        gain.gain.exponentialRampToValueAtTime(0.01, now + 0.4);
        noise.connect(gain);
        gain.connect(audioCtx.destination);
        noise.start(now);
        break;
      }
    }
  }

  // --- INITIALIZE DOM ELEMENTS ---
  const els = {
    balance: document.getElementById('user-balance'),
    lastWin: document.getElementById('last-win-display'),
    jackpot: document.getElementById('jackpot-amount'),
    statusText: document.getElementById('status-text'),
    stakeInput: document.getElementById('stake-input'),
    stakeMinus: document.getElementById('btn-stake-minus'),
    stakePlus: document.getElementById('btn-stake-plus'),
    stakeClear: document.getElementById('btn-stake-clear'),
    linesCount: document.getElementById('lines-count-display'),
    lineMinus: document.getElementById('btn-line-minus'),
    linePlus: document.getElementById('btn-line-plus'),
    pipBar: document.getElementById('pip-bar'),
    totalStake: document.getElementById('total-stake-display'),
    turboBtn: document.getElementById('btn-turbo'),
    autoplayBtn: document.getElementById('btn-autoplay'),
    autoplayText: document.getElementById('autoplay-text'),
    spinBtn: document.getElementById('btn-spin'),
    soundBtn: document.getElementById('btn-sound'),
    leverHandle: document.getElementById('lever-handle'),
    cowgirlArm: document.getElementById('cowgirl-arm'),
    gunSmoke: document.getElementById('gun-smoke'),
    eagleContainer: document.getElementById('eagle-container'),
    winLayer: document.getElementById('win-layer'),
    paylinesOverlay: document.getElementById('paylines-overlay'),
    demoPanel: document.getElementById('demo-mode-panel'),
    demoPill: document.getElementById('demo-trigger-pill'),
    demoBalance: document.getElementById('demo-balance-val'),
    demoWin: document.getElementById('demo-win-val'),
    btnExitDemo: document.getElementById('btn-exit-demo'),
    btnCollapseDemo: document.getElementById('btn-collapse-demo'),
    infoBtn: document.getElementById('btn-info'),
    combBtn: document.getElementById('btn-comb'),
    rulesModal: document.getElementById('rules-modal'),
    combModal: document.getElementById('comb-modal'),
    closeRules: document.getElementById('btn-close-rules'),
    closeComb: document.getElementById('btn-close-comb'),
    strips: [
      document.getElementById('strip-0'),
      document.getElementById('strip-1'),
      document.getElementById('strip-2'),
      document.getElementById('strip-3'),
      document.getElementById('strip-4')
    ],
    columns: [
      document.getElementById('reel-0'),
      document.getElementById('reel-1'),
      document.getElementById('reel-2'),
      document.getElementById('reel-3'),
      document.getElementById('reel-4')
    ]
  };

  // --- RENDER REEL SYMBOLS ---
  function createSymbolElement(symId, isWinning = false) {
    const sym = SYMBOLS.find(s => s.id === symId) || SYMBOLS[0];
    const cell = document.createElement('div');
    cell.className = `symbol-cell ${isWinning ? 'winning' : ''}`;
    cell.dataset.symbolId = sym.id;

    const bg = document.createElement('img');
    bg.className = 'symbol-bg';
    bg.src = isWinning ? (BASE_PATH + 'icon-back-active.b46d4046361b.png') : (BASE_PATH + 'icon-back.9b97ecb985b4.png');
    bg.alt = 'cell';

    const icon = document.createElement('img');
    icon.className = 'symbol-icon';
    icon.src = isWinning ? sym.activeSrc : sym.src;
    icon.alt = sym.name;

    cell.appendChild(bg);
    cell.appendChild(icon);
    return cell;
  }

  function renderInitialReels() {
    for (let c = 0; c < 5; c++) {
      els.strips[c].innerHTML = '';
      for (let r = 0; r < 3; r++) {
        const symId = state.reelsState[c][r];
        const cell = createSymbolElement(symId);
        els.strips[c].appendChild(cell);
      }
    }
  }

  // --- UPDATE UI VALUES ---
  function updateUI() {
    state.totalStake = state.stakePerLine * state.activeLines;
    els.stakeInput.value = state.stakePerLine;
    els.linesCount.textContent = state.activeLines;
    els.totalStake.textContent = state.totalStake.toFixed(2);
    els.balance.textContent = state.balance.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    els.lastWin.textContent = state.lastWin.toFixed(2);
    els.jackpot.textContent = state.jackpot.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    // Update Demo Mode card stats if elements exist
    if (els.demoBalance) {
      els.demoBalance.textContent = Math.round(state.balance);
    }
    if (els.demoWin) {
      els.demoWin.textContent = Math.round(state.lastWin);
    }

    // Update 5-segment pip bar for active lines
    const pips = els.pipBar.querySelectorAll('.pip');
    pips.forEach((pip, idx) => {
      if (idx < state.activeLines) {
        pip.classList.add('active');
      } else {
        pip.classList.remove('active');
      }
    });

    // Update side board payline pins
    document.querySelectorAll('.pin-btn').forEach(pin => {
      const lineNum = parseInt(pin.dataset.line, 10);
      if (lineNum <= state.activeLines) {
        pin.classList.add('active');
      } else {
        pin.classList.remove('active');
      }
    });
  }

  // --- EAGLE FLAP & SOAR ANIMATION SCHEDULER ---
  function launchEagle() {
    els.eagleContainer.classList.remove('eagle-flying');
    void els.eagleContainer.offsetWidth; // Trigger reflow
    els.eagleContainer.classList.add('eagle-flying');

    // Schedule next flight in 18-30 seconds
    const nextFlightTime = Math.random() * 12000 + 18000;
    setTimeout(launchEagle, nextFlightTime);
  }

  // --- COWGIRL ARM REACTION ---
  function animateCowgirlCock() {
    els.cowgirlArm.classList.add('cocking');
    setTimeout(() => {
      els.cowgirlArm.classList.remove('cocking');
    }, 500);
  }

  function animateCowgirlShoot() {
    els.cowgirlArm.classList.add('shooting');
    playSound('gunshot');
    els.gunSmoke.classList.add('active');
    setTimeout(() => {
      els.cowgirlArm.classList.remove('shooting');
      els.gunSmoke.classList.remove('active');
    }, 600);
  }

  // --- PROGRESSIVE JACKPOT TICKER ---
  setInterval(() => {
    state.jackpot += (Math.random() * 0.05 + 0.02);
    els.jackpot.textContent = state.jackpot.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }, 2500);

  // --- PAYLINE OVERLAYS ---
  function showPaylineOverlay(lineId) {
    hideAllPaylines();
    const lineEl = document.getElementById(`line-img-${lineId}`);
    if (lineEl) {
      lineEl.classList.add('active');
    }
  }

  function hideAllPaylines() {
    document.querySelectorAll('.line-overlay').forEach(el => el.classList.remove('active'));
  }

  // --- EVALUATE WINS ---
  function evaluateSpin(grid) {
    const wins = [];
    let totalWinAmount = 0;
    const lineBet = state.stakePerLine;

    // Check each active payline
    for (let l = 0; l < state.activeLines; l++) {
      const line = PAYLINES[l];
      const coords = line.coords; // [row0, row1, row2, row3, row4]

      const symbolsOnLine = [
        grid[0][coords[0]],
        grid[1][coords[1]],
        grid[2][coords[2]],
        grid[3][coords[3]],
        grid[4][coords[4]]
      ];

      // Identify base symbol (first non-wild, or wild if all wild)
      let baseSymId = symbolsOnLine[0];
      let firstNonWild = symbolsOnLine.find(s => s !== 8);
      let matchTarget = firstNonWild !== undefined ? firstNonWild : 8;

      let matchCount = 0;
      let matchedIndices = [];

      for (let i = 0; i < 5; i++) {
        const sym = symbolsOnLine[i];
        if (sym === matchTarget || sym === 8) { // 8 is Wild
          matchCount++;
          matchedIndices.push(i);
        } else {
          break; // Must be consecutive from left to right
        }
      }

      const symObj = SYMBOLS.find(s => s.id === matchTarget);
      if (symObj && symObj.payouts && symObj.payouts[matchCount]) {
        let payoutMult = symObj.payouts[matchCount];
        let winAmount = 0;

        if (payoutMult === 'JACKPOT') {
          winAmount = state.jackpot;
          state.jackpot = 10000.00;
        } else {
          winAmount = lineBet * payoutMult;
        }

        wins.push({
          lineId: line.id,
          lineName: line.name,
          symbol: symObj,
          count: matchCount,
          amount: winAmount,
          matchedCoords: matchedIndices.map(reelIdx => ({
            reel: reelIdx,
            row: coords[reelIdx]
          }))
        });

        totalWinAmount += winAmount;
      }
    }

    return { wins, totalWinAmount };
  }

  // --- HIGHLIGHT WINNING CELLS & LINES ---
  function displayWinningSequence(wins, totalWin) {
    if (wins.length === 0) return;

    // Trigger Cowgirl celebratory shot
    animateCowgirlShoot();

    // Show big banner if win >= 5x stake
    if (totalWin >= state.totalStake * 5) {
      playSound('big-win');
      const banner = document.createElement('div');
      banner.className = 'win-banner-text';
      banner.textContent = `BIG WIN! +${totalWin.toFixed(2)}`;
      els.winLayer.appendChild(banner);
      setTimeout(() => {
        banner.remove();
      }, 2500);
    } else {
      playSound('win');
    }

    // Highlight winning cells on the reels
    wins.forEach(w => {
      showPaylineOverlay(w.lineId);
      w.matchedCoords.forEach(pos => {
        const cell = els.strips[pos.reel].children[pos.row];
        if (cell) {
          const symObj = SYMBOLS.find(s => s.id === parseInt(cell.dataset.symbolId, 10));
          cell.classList.add('winning');
          const bg = cell.querySelector('.symbol-bg');
          const icon = cell.querySelector('.symbol-icon');
          if (bg) bg.src = BASE_PATH + 'icon-back-active.b46d4046361b.png';
          if (icon && symObj) icon.src = symObj.activeSrc;
        }
      });
    });

    // Cycle through multiple winning lines if present
    if (wins.length > 1) {
      let winIdx = 0;
      const cycleInterval = setInterval(() => {
        if (state.isSpinning) {
          clearInterval(cycleInterval);
          return;
        }
        hideAllPaylines();
        const curWin = wins[winIdx % wins.length];
        showPaylineOverlay(curWin.lineId);
        els.statusText.textContent = `LINE ${curWin.lineId} WINS ${curWin.amount.toFixed(2)}!`;
        winIdx++;
      }, 1500);
    }
  }

  // --- REEL SPINNING ENGINE ---
  function spin() {
    if (state.isSpinning) return;

    if (state.balance < state.totalStake) {
      els.statusText.textContent = 'INSUFFICIENT BALANCE!';
      state.isAutoPlay = false;
      els.autoplayBtn.classList.remove('active');
      return;
    }

    initAudio();
    state.isSpinning = true;
    els.spinBtn.disabled = true;
    hideAllPaylines();
    els.winLayer.innerHTML = '';

    // Deduct Stake
    state.balance -= state.totalStake;
    state.lastWin = 0.00;
    updateUI();

    els.statusText.textContent = 'GOOD LUCK!';
    playSound('lever');
    animateCowgirlCock();

    // Pull Lever Handle visual animation
    els.leverHandle.classList.add('pulled');
    setTimeout(() => {
      els.leverHandle.classList.remove('pulled');
    }, 450);

    // Determine target symbols for 5 reels x 3 rows
    const targetGrid = [];
    for (let c = 0; c < 5; c++) {
      const col = [];
      for (let r = 0; r < 3; r++) {
        // Weighted random symbol generation
        const rand = Math.random() * 100;
        let symId;
        if (rand < 3) symId = 9;      // Jackpot (3%)
        else if (rand < 9) symId = 8;  // Wild (6%)
        else if (rand < 18) symId = 7; // Bandit Hat (9%)
        else if (rand < 28) symId = 3; // Sheriff (10%)
        else if (rand < 40) symId = 6; // Money Bag (12%)
        else if (rand < 55) symId = 2; // Dynamite (15%)
        else if (rand < 70) symId = 5; // Skull (15%)
        else if (rand < 82) symId = 4; // Horseshoe (12%)
        else if (rand < 92) symId = 1; // Wagon (10%)
        else symId = 0;               // Whiskey (8%)
        col.push(symId);
      }
      targetGrid.push(col);
    }

    // Set up continuous spinning strips with dummy symbols
    const cellHeight = 112;
    const spinDuration = state.isTurbo ? 500 : 1200;
    const reelDelay = state.isTurbo ? 100 : 220;

    for (let c = 0; c < 5; c++) {
      els.columns[c].classList.add('spinning');
      const strip = els.strips[c];

      // Build strip: top dummy symbols + target 3 symbols at end
      const numDummy = 15 + c * 4;
      strip.innerHTML = '';

      for (let i = 0; i < numDummy; i++) {
        const randSym = Math.floor(Math.random() * SYMBOLS.length);
        strip.appendChild(createSymbolElement(randSym));
      }

      // Append the 3 final target symbols
      for (let r = 0; r < 3; r++) {
        strip.appendChild(createSymbolElement(targetGrid[c][r]));
      }

      // Initial top position
      strip.style.transition = 'none';
      strip.style.transform = 'translateY(0px)';

      // Trigger animation to slide down
      setTimeout(() => {
        const totalHeightToScroll = (numDummy) * cellHeight;
        strip.style.transition = `transform ${spinDuration + c * reelDelay}ms cubic-bezier(0.25, 1, 0.5, 1)`;
        strip.style.transform = `translateY(-${totalHeightToScroll}px)`;
        playSound('reel-spin');

        // Stop reel when done
        setTimeout(() => {
          els.columns[c].classList.remove('spinning');
          playSound('reel-stop');

          // Clean up strip to only keep the 3 target symbols
          strip.style.transition = 'none';
          strip.style.transform = 'translateY(0px)';
          strip.innerHTML = '';
          for (let r = 0; r < 3; r++) {
            strip.appendChild(createSymbolElement(targetGrid[c][r]));
          }

          // When the last reel stops
          if (c === 4) {
            state.reelsState = targetGrid;
            state.isSpinning = false;
            els.spinBtn.disabled = false;

            // Evaluate Win
            const { wins, totalWinAmount } = evaluateSpin(targetGrid);

            if (totalWinAmount > 0) {
              state.balance += totalWinAmount;
              state.lastWin = totalWinAmount;
              els.statusText.textContent = `WIN: ${totalWinAmount.toFixed(2)}!`;
              displayWinningSequence(wins, totalWinAmount);
            } else {
              els.statusText.textContent = 'TRY AGAIN!';
            }

            updateUI();

            // Autoplay loop
            if (state.isAutoPlay) {
              setTimeout(() => {
                if (state.isAutoPlay && !state.isSpinning) {
                  spin();
                }
              }, state.isTurbo ? 500 : 1200);
            }
          }
        }, spinDuration + c * reelDelay);
      }, 20);
    }
  }

  // --- EVENT LISTENERS ---

  // Spin Button
  els.spinBtn.addEventListener('click', () => {
    playSound('click');
    spin();
  });

  // Lever Drag & Click
  els.leverHandle.addEventListener('click', () => {
    playSound('click');
    spin();
  });

  // Stake Buttons
  els.stakeMinus.addEventListener('click', () => {
    playSound('click');
    if (state.stakePerLine > 5) {
      state.stakePerLine -= 5;
      updateUI();
    }
  });

  els.stakePlus.addEventListener('click', () => {
    playSound('click');
    if (state.stakePerLine < 500) {
      state.stakePerLine += 5;
      updateUI();
    }
  });

  els.stakeClear.addEventListener('click', () => {
    playSound('click');
    state.stakePerLine = 1;
    updateUI();
  });

  els.stakeInput.addEventListener('change', (e) => {
    let val = parseInt(e.target.value, 10);
    if (isNaN(val) || val < 1) val = 1;
    if (val > 1000) val = 1000;
    state.stakePerLine = val;
    updateUI();
  });

  // Paylines Buttons (< > and Direct Number Pins)
  els.lineMinus.addEventListener('click', () => {
    playSound('click');
    if (state.activeLines > 1) {
      state.activeLines--;
      updateUI();
    }
  });

  els.linePlus.addEventListener('click', () => {
    playSound('click');
    if (state.activeLines < 9) {
      state.activeLines++;
      updateUI();
    }
  });

  // Payline Pin Clicks (Left Sideboard 1-9) - Update active lines without static full-screen blocking overlay
  document.querySelectorAll('.pin-btn').forEach(pin => {
    const lineNum = parseInt(pin.dataset.line, 10);

    pin.addEventListener('click', () => {
      playSound('click');
      state.activeLines = lineNum;
      updateUI();
    });
  });

  // Demo Mode Panel Collapse / Expand Handlers
  if (els.btnCollapseDemo && els.demoPanel && els.demoPill) {
    els.btnCollapseDemo.addEventListener('click', () => {
      playSound('click');
      els.demoPanel.style.display = 'none';
      els.demoPill.style.display = 'flex';
    });

    els.demoPill.addEventListener('click', () => {
      playSound('click');
      els.demoPill.style.display = 'none';
      els.demoPanel.style.display = 'block';
    });
  }

  if (els.btnExitDemo) {
    els.btnExitDemo.addEventListener('click', () => {
      playSound('click');
      if (state.isDemo !== false) {
        state.isDemo = false;
        els.btnExitDemo.textContent = 'ENTER DEMO MODE';
        els.statusText.textContent = 'REAL PLAY MODE ACTIVATED';
      } else {
        state.isDemo = true;
        els.btnExitDemo.textContent = 'EXIT DEMO MODE';
        els.statusText.textContent = 'DEMO ACCOUNT ACTIVE';
      }
    });
  }

  // Turbo Mode Button
  els.turboBtn.addEventListener('click', () => {
    playSound('click');
    state.isTurbo = !state.isTurbo;
    els.turboBtn.classList.toggle('active', state.isTurbo);
    els.statusText.textContent = state.isTurbo ? 'TURBO MODE ON' : 'TURBO MODE OFF';
  });

  // Autoplay Button
  els.autoplayBtn.addEventListener('click', () => {
    playSound('click');
    state.isAutoPlay = !state.isAutoPlay;
    els.autoplayBtn.classList.toggle('active', state.isAutoPlay);
    els.autoplayText.textContent = state.isAutoPlay ? 'STOP AUTO' : 'AUTO PLAY';

    if (state.isAutoPlay && !state.isSpinning) {
      spin();
    }
  });

  // Sound Toggle Button
  els.soundBtn.addEventListener('click', () => {
    state.soundEnabled = !state.soundEnabled;
    els.soundBtn.classList.toggle('muted', !state.soundEnabled);
    if (state.soundEnabled) playSound('click');
  });

  // Modals (Info / Paytable & Combinations)
  els.infoBtn.addEventListener('click', () => {
    playSound('click');
    els.rulesModal.classList.add('open');
  });

  els.closeRules.addEventListener('click', () => {
    playSound('click');
    els.rulesModal.classList.remove('open');
  });

  els.combBtn.addEventListener('click', () => {
    playSound('click');
    els.combModal.classList.add('open');
  });

  els.closeComb.addEventListener('click', () => {
    playSound('click');
    els.combModal.classList.remove('open');
  });

  // Close modals on backdrop click
  window.addEventListener('click', (e) => {
    if (e.target === els.rulesModal) els.rulesModal.classList.remove('open');
    if (e.target === els.combModal) els.combModal.classList.remove('open');
  });

  // --- RESPONSIVE STAGE SCALER (100% Mobile & Desktop Compatibility) ---
  function scaleGameStage() {
    const stage = document.getElementById('game-stage');
    if (!stage) return;
    const baseW = 1600;
    const baseH = 760;
    const winW = window.innerWidth;
    const winH = window.innerHeight;
    const scale = Math.min(winW / baseW, winH / baseH, 1.0);
    stage.style.transform = `scale(${scale})`;
  }

  window.addEventListener('resize', scaleGameStage);
  window.addEventListener('orientationchange', scaleGameStage);

  // Global Demo Mode Handlers
  window.toggleDemoPanel = function (show) {
    const panel = document.getElementById('demo-mode-panel');
    const pill = document.getElementById('demo-trigger-pill');
    if (!panel || !pill) return;
    playSound('click');
    if (show) {
      panel.style.display = 'block';
      pill.style.display = 'none';
    } else {
      panel.style.display = 'none';
      pill.style.display = 'flex';
    }
  };

  window.toggleDemoMode = function () {
    playSound('click');
    const btn = document.getElementById('btn-exit-demo');
    if (state.isDemo !== false) {
      state.isDemo = false;
      if (btn) btn.textContent = 'ENTER DEMO MODE';
      els.statusText.textContent = 'REAL PLAY MODE ACTIVATED';
    } else {
      state.isDemo = true;
      if (btn) btn.textContent = 'EXIT DEMO MODE';
      els.statusText.textContent = 'DEMO ACCOUNT ACTIVE';
    }
  };

  // Keyboard shortcut: Spacebar to spin
  window.addEventListener('keydown', (e) => {
    if (e.code === 'Space' && !e.repeat && document.activeElement !== els.stakeInput) {
      e.preventDefault();
      playSound('click');
      spin();
    }
  });

  // Click on background scene anywhere to initialize audio context
  window.addEventListener('pointerdown', initAudio, { once: true });

  // Start eagle flight scheduler after 3s
  setTimeout(launchEagle, 3000);

  // Initial render & scale
  renderInitialReels();
  updateUI();
  scaleGameStage();

})();
