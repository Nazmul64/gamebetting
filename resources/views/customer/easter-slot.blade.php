<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Easter Slots - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <style>
    * { 
      margin:0; 
      padding:0; 
      box-sizing:border-box; 
      font-family:'Montserrat', sans-serif; 
      user-select:none; 
      -webkit-user-select:none; 
      -webkit-user-drag:none; 
    }
    img { pointer-events: none; -webkit-user-drag: none; }
    html, body { background: #07140b; color: #f8fafc; min-height: 100vh; overflow-x: hidden; }

    .game-page-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 12px 16px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }

    .top-nav-bar {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
    }
    .breadcrumbs {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 700;
      color: #94a3b8;
    }
    .breadcrumbs a { color: #4ade80; text-decoration: none; }

    .audio-controls {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .audio-btn {
      background: rgba(10, 35, 20, 0.85);
      border: 1px solid #22c55e;
      color: #4ade80;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .audio-btn:hover { background: #22c55e; color: #000; }

    /* Native Game Stage (Seamless Background) */
    .stage-wrapper {
      width: 100%;
      max-width: 1100px;
      display: flex;
      justify-content: center;
    }

    #stage {
      position: relative;
      width: 100%;
      aspect-ratio: 1892 / 849;
      background: url('/easter-slot/assets/background.jpg') center / 100% 100% no-repeat;
      user-select: none;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 15px 50px rgba(0,0,0,0.9), 0 0 30px rgba(34, 197, 94, 0.2);
    }

    /* Transparent Reel Cells */
    .cell {
      position: absolute;
      background: transparent;
      overflow: hidden;
      transition: opacity 0.2s ease, transform 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .cell img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .cell.spinning img {
      filter: blur(2px);
      transform: translateY(-4px);
    }
    .cell.win {
      z-index: 5;
      filter: drop-shadow(0 0 12px #ffe14d) brightness(1.2);
      animation: pulseWin 0.5s infinite alternate ease-in-out;
    }
    .cell.dim {
      opacity: 0.35;
      filter: grayscale(0.5);
    }
    .cell.sc {
      z-index: 6;
      filter: drop-shadow(0 0 16px #ffffff) brightness(1.3);
      animation: pulseScatter 0.45s infinite alternate ease-in-out;
    }

    @keyframes pulseWin {
      from { transform: scale(1); }
      to { transform: scale(1.08); }
    }
    @keyframes pulseScatter {
      from { transform: scale(1) rotate(-2deg); }
      to { transform: scale(1.12) rotate(2deg); }
    }

    /* Native UI Readout Texts with Opaque Backplates covering background image art */
    .val {
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      background: #082814;
      border: 1.5px solid #16a34a;
      border-radius: 6px;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.9), 0 0 6px rgba(22, 163, 74, 0.4);
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: clamp(10px, 1.4vw, 17px);
      text-shadow: 0 1px 2px #000;
      pointer-events: none;
      z-index: 4;
      white-space: nowrap;
      overflow: hidden;
      padding: 0 4px;
    }

    /* Clickable Hotspots overlaying native background buttons */
    .hit {
      position: absolute;
      cursor: pointer;
      border-radius: 50%;
      transition: background 0.15s;
    }
    .hit:hover {
      background: rgba(74, 222, 128, 0.2);
    }
    .hit:active {
      background: rgba(255, 255, 255, 0.35);
      transform: scale(0.96);
    }

    #spin.busy {
      pointer-events: none;
      opacity: 0.85;
      filter: grayscale(0.3);
    }

    #msg {
      position: absolute;
      left: 26%;
      top: 5.2%;
      width: 48%;
      height: 4.5%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      font-size: clamp(10px, 1.5vw, 18px);
      text-shadow: 0 2px 6px #000, 0 0 10px rgba(74, 222, 128, 0.8);
      pointer-events: none;
      letter-spacing: 1px;
    }

    .auto-active {
      outline: 3px solid #4ade80;
      background: rgba(74, 222, 128, 0.3) !important;
      border-radius: 50%;
    }

    /* Bottom Quick Action Bar for Extra Convenience */
    .extra-controls-bar {
      width: 100%;
      max-width: 1100px;
      background: #081d10;
      border: 1px solid #15803d;
      border-radius: 16px;
      padding: 12px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    }
    .chip-btn {
      padding: 6px 12px;
      border-radius: 8px;
      background: #14532d;
      border: 1px solid #16a34a;
      color: #86efac;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .chip-btn:hover { background: #166534; }
    .chip-btn.active {
      background: #22c55e;
      color: #000;
      border-color: #86efac;
    }
  </style>
</head>
<body oncontextmenu="return false;">

  @include('customer.header')

  <!-- Background Music Audio Element -->
  <audio id="bgm-player" src="/assets/audio/games/slot_bg.mp3" loop preload="auto"></audio>

  <div class="game-page-container">
    <div class="top-nav-bar">
      <div class="breadcrumbs">
        <a href="{{ route('home') }}">1XGAMES</a>
        <span>/</span>
        <a href="{{ route('dashboard') }}">SLOTS</a>
        <span>/</span>
        <span style="color:#f8fafc;">EASTER SLOTS</span>
      </div>

      <div class="audio-controls">
        <button class="audio-btn" id="sound-toggle" onclick="toggleAudio()">
          <i class="fa-solid fa-volume-high" id="sound-icon"></i>
          <span id="sound-label">Sound: ON</span>
        </button>
      </div>
    </div>

    <!-- Authentic Stage directly over Background Art -->
    <div class="stage-wrapper">
      <div id="stage">
        <div id="msg">PRESS SPIN TO PLAY</div>

        <!-- Dynamic Output Displays on Background Graphics -->
        <div class="val" id="tb" style="left:31.2%; top:90.6%; width:5.6%; height:5.6%;">20</div>
        <div class="val" id="bal" style="left:60.9%; top:90.7%; width:9.6%; height:5.6%;">{{ number_format(Auth::check() ? (float)Auth::user()->balance : 1000, 2) }}</div>
        <div class="val" id="win" style="left:74.8%; top:90.7%; width:7%; height:5.6%;">0.00</div>

        <!-- Clickable Native Buttons on Background Artwork -->
        <div class="hit" id="minus" style="left:28.9%; top:91.3%; width:2.1%; height:4.4%;" title="Decrease Bet"></div>
        <div class="hit" id="plus" style="left:36.7%; top:91.3%; width:2.1%; height:4.4%;" title="Increase Bet"></div>
        <div class="hit" id="max" style="left:41.2%; top:90.5%; width:5.4%; height:6.5%; border-radius:12px;" title="Max Bet"></div>
        <div class="hit" id="spin" style="left:46.4%; top:87.5%; width:7.2%; height:12.5%;" title="Spin Reels"></div>
        <div class="hit" id="autob" style="left:53.6%; top:90.5%; width:5.4%; height:6.5%; border-radius:12px;" title="Auto Spin"></div>
      </div>
    </div>

    <!-- Quick Stake Bar & Mode Toggle -->
    <div class="extra-controls-bar">
      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <span style="font-size:12px; font-weight:700; color:#4ade80;">QUICK STAKE:</span>
        <button class="chip-btn" onclick="setBet(10)">10</button>
        <button class="chip-btn active" onclick="setBet(20)">20</button>
        <button class="chip-btn" onclick="setBet(50)">50</button>
        <button class="chip-btn" onclick="setBet(100)">100</button>
        <button class="chip-btn" onclick="setBet(500)">500</button>
      </div>

      <div style="display:flex; align-items:center; gap:8px;">
        <button id="mode-real" class="chip-btn active" onclick="setDemo(false)">💰 Real</button>
        <button id="mode-demo" class="chip-btn" onclick="setDemo(true)">🎮 Demo</button>
      </div>
    </div>
  </div>

  <script>
    const IMG = {
      Q: "/easter-slot/assets/queen.jpg",
      J: "/easter-slot/assets/jack.jpg",
      U: "/easter-slot/assets/egg-blue.jpg",
      R: "/easter-slot/assets/egg-red.jpg",
      P: "/easter-slot/assets/egg-purple.jpg",
      G: "/easter-slot/assets/egg-gold.jpg",
      B: "/easter-slot/assets/bonus.jpg",
      W: "/easter-slot/assets/wild.jpg",
      C: "/easter-slot/assets/scatter.jpg"
    };

    const SYMBOL_ALIAS = {
      'wild': 'W', 'scatter': 'C', 'bonus': 'B',
      'egg-gold': 'G', 'egg-red': 'R', 'egg-blue': 'U',
      'egg-purple': 'P', 'queen': 'Q', 'jack': 'J'
    };

    const W0 = 1892, H0 = 849;
    const xs = [491, 677, 863, 1049, 1236], ys = [218, 383, 548], cw = 170, ch = 148;
    const BAG = 'QQQJJJRRRUUUPPGGWBBC'.split('');

    const $ = id => document.getElementById(id);
    const st = $('stage');

    let bet = 20;
    let bal = parseFloat("{{ Auth::check() ? (float)Auth::user()->balance : 1000 }}");
    let isDemo = false;
    let busy = false;
    let auto = false;
    let isMuted = false;
    let grid = [], cells = [];
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Audio Engine
    const bgm = $('bgm-player');
    function startBGM() {
      if (!isMuted) {
        bgm.volume = 0.5;
        bgm.play().catch(() => {});
      }
    }
    window.addEventListener('click', startBGM, { once: true });
    window.addEventListener('keydown', startBGM, { once: true });

    function toggleAudio() {
      isMuted = !isMuted;
      if (isMuted) {
        bgm.pause();
        $('sound-icon').className = 'fa-solid fa-volume-xmark';
        $('sound-label').innerText = 'Sound: OFF';
      } else {
        bgm.play().catch(() => {});
        $('sound-icon').className = 'fa-solid fa-volume-high';
        $('sound-label').innerText = 'Sound: ON';
      }
    }

    const rnd = () => BAG[Math.random() * BAG.length | 0];

    // Build 15 cells directly on the stage
    for (let r = 0; r < 3; r++) {
      grid.push([]);
      for (let c = 0; c < 5; c++) {
        const d = document.createElement('div');
        d.className = 'cell';
        d.style.cssText = `left:${(xs[c] + 3) / W0 * 100}%; top:${(ys[r] + 3) / H0 * 100}%; width:${(cw - 6) / W0 * 100}%; height:${(ch - 6) / H0 * 100}%;`;
        d.innerHTML = '<img>';
        st.appendChild(d);
        cells.push(d);
        grid[r].push(rnd());
      }
    }

    const draw = (r, c) => {
      const sym = grid[r][c];
      const mapped = SYMBOL_ALIAS[sym] || sym;
      cells[r * 5 + c].firstChild.src = IMG[mapped] || IMG['G'];
    };

    const all = () => {
      for (let r = 0; r < 3; r++) {
        for (let c = 0; c < 5; c++) draw(r, c);
      }
    };

    const ui = () => {
      $('tb').textContent = bet;
      $('bal').textContent = bal.toFixed(2);
      document.querySelectorAll('.extra-controls-bar .chip-btn').forEach(b => {
        if (!b.id) b.classList.toggle('active', parseInt(b.innerText) === bet);
      });
    };

    all();
    ui();
    $('win').textContent = '0.00';

    const clr = () => cells.forEach(d => {
      d.className = 'cell';
    });

    function setBet(v) {
      bet = Math.max(10, Math.min(50000, v));
      ui();
    }

    function setDemo(val) {
      isDemo = val;
      $('mode-real').classList.toggle('active', !val);
      $('mode-demo').classList.toggle('active', val);
      if (isDemo) {
        $('msg').textContent = 'DEMO MODE - PLAY FOR FUN';
      } else {
        $('msg').textContent = 'REAL MODE - PRESS SPIN';
      }
    }

    async function spin() {
      if (busy) return;
      if (!isDemo && bal < bet) {
        $('msg').textContent = 'INSUFFICIENT WALLET BALANCE';
        auto = false;
        $('autob').classList.remove('auto-active');
        return;
      }

      startBGM();
      busy = true;
      $('spin').classList.add('busy');
      if (!isDemo) {
        bal -= bet;
      }
      ui();
      $('win').textContent = '0.00';
      $('msg').textContent = 'SPINNING EASTER REELS...';
      clr();

      cells.forEach(d => d.classList.add('spinning'));

      const animInterval = setInterval(() => {
        for (let c = 0; c < 5; c++) {
          for (let r = 0; r < 3; r++) {
            grid[r][c] = rnd();
            draw(r, c);
          }
        }
      }, 75);

      try {
        const res = await fetch("{{ route('easterslots.spin') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
          },
          body: JSON.stringify({
            bet: bet,
            is_demo: isDemo
          })
        });

        const data = await res.json();
        clearInterval(animInterval);
        cells.forEach(d => d.classList.remove('spinning'));

        if (!data.success) {
          $('msg').textContent = data.error || 'SPIN ERROR';
          busy = false;
          $('spin').classList.remove('busy');
          auto = false;
          $('autob').classList.remove('auto-active');
          return;
        }

        // Apply final grid from server (server returns grid[col][row])
        if (data.grid) {
          for (let c = 0; c < 5; c++) {
            for (let r = 0; r < 3; r++) {
              grid[r][c] = (data.grid[c] && data.grid[c][r]) ? data.grid[c][r] : (data.grid[r] && data.grid[r][c] ? data.grid[r][c] : 'G');
              draw(r, c);
            }
          }
        }

        if (data.balance !== undefined) {
          bal = parseFloat(data.balance);
        } else if (isDemo) {
          bal = Math.max(0, bal - bet + (parseFloat(data.win_amount) || 0));
        }

        const winAmount = parseFloat(data.win_amount || 0);
        $('win').textContent = winAmount.toFixed(2);
        ui();

        if (winAmount > 0) {
          $('msg').textContent = `🎉 EASTER WIN! +৳${winAmount.toFixed(2)}`;
          if (typeof confetti === 'function') {
            confetti({ particleCount: 70, spread: 60, origin: { y: 0.65 } });
          }
          if (typeof window.triggerWinCelebration === 'function') {
            window.triggerWinCelebration({
              amount: winAmount,
              multiplier: bet > 0 ? (winAmount / bet) : 0,
              title: 'EASTER SURPRISE WIN!'
            });
          }
          if (data.winning_lines && data.winning_lines.length > 0) {
            data.winning_lines.forEach(line => {
              if (line.coords) {
                line.coords.forEach(([col, row]) => {
                  const idx = row * 5 + col;
                  if (cells[idx]) cells[idx].classList.add(line.symbol === 'C' ? 'sc' : 'win');
                });
              }
            });
          }
        } else {
          $('msg').textContent = 'TRY AGAIN FOR EASTER SURPRISES!';
        }

        busy = false;
        $('spin').classList.remove('busy');

        if (auto) {
          setTimeout(spin, winAmount > 0 ? 2000 : 1000);
        }

      } catch (err) {
        clearInterval(animInterval);
        cells.forEach(d => d.classList.remove('spinning'));
        busy = false;
        $('spin').classList.remove('busy');
        $('msg').textContent = 'NETWORK CONNECTION ERROR';
        auto = false;
        $('autob').classList.remove('auto-active');
      }
    }

    $('spin').onclick = spin;
    $('plus').onclick = () => setBet(bet + 10);
    $('minus').onclick = () => setBet(Math.max(10, bet - 10));
    $('max').onclick = () => { setBet(2000); spin(); };
    $('autob').onclick = () => {
      auto = !auto;
      $('autob').classList.toggle('auto-active', auto);
      if (auto && !busy) spin();
    };
  </script>
</body>
</html>
