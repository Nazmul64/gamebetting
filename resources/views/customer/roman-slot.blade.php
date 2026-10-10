<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Roman Slots - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
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
    html, body { background: #060303; color: #f8fafc; min-height: 100vh; overflow-x: hidden; }

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
    .breadcrumbs a { color: #eab308; text-decoration: none; }

    .audio-controls {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .audio-btn {
      background: rgba(30, 20, 15, 0.85);
      border: 1px solid #ca8a04;
      color: #facc15;
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
    .audio-btn:hover { background: #ca8a04; color: #000; }

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
      aspect-ratio: 1170 / 658;
      background: url('/roman-slot/assets/background.jpg') center / 100% 100% no-repeat;
      user-select: none;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 15px 50px rgba(0,0,0,0.9), 0 0 30px rgba(202, 138, 4, 0.2);
    }

    /* Transparent Reel Cells */
    .cell {
      position: absolute;
      background: transparent;
      overflow: hidden;
      transition: filter 0.2s ease, transform 0.2s ease;
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
      filter: drop-shadow(0 0 12px #facc15) brightness(1.2);
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
      color: #fff4c6;
      background: #170d06;
      border: 1.5px solid #854d0e;
      border-radius: 5px;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.9), 0 0 6px rgba(133, 77, 14, 0.4);
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
      border-radius: 6px;
      transition: background 0.15s;
    }
    .hit:hover {
      background: rgba(250, 204, 21, 0.15);
    }
    .hit:active {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(0.96);
    }

    #spin {
      border-radius: 50%;
    }
    #spin.busy {
      pointer-events: none;
      opacity: 0.85;
      filter: grayscale(0.3);
    }

    #msg {
      position: absolute;
      left: 17.436%;
      top: 81.2%;
      width: 65.214%;
      height: 4.5%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffe9a8;
      font-family: 'Cinzel', 'Georgia', serif;
      font-weight: 800;
      font-size: clamp(10px, 1.6vw, 18px);
      text-shadow: 0 2px 6px #000, 0 0 10px rgba(250, 204, 21, 0.6);
      pointer-events: none;
      letter-spacing: 1px;
    }

    .auto-active {
      outline: 3px solid #facc15;
      background: rgba(250, 204, 21, 0.25) !important;
      border-radius: 8px;
    }

    /* Bottom Quick Action Bar for Extra Convenience */
    .extra-controls-bar {
      width: 100%;
      max-width: 1100px;
      background: #120b08;
      border: 1px solid #78350f;
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
      background: #271912;
      border: 1px solid #78350f;
      color: #fde047;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .chip-btn:hover { background: #451a03; }
    .chip-btn.active {
      background: #eab308;
      color: #000;
      border-color: #fde047;
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
        <span style="color:#f8fafc;">ROMAN SLOTS</span>
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
        <div class="val" id="tb" style="left:27.179%; top:92.553%; width:6.154%; height:4.103%;">20</div>
        <div class="val" id="bal" style="left:65.470%; top:92.553%; width:11.453%; height:4.103%;">{{ number_format(Auth::check() ? (float)Auth::user()->balance : 1000, 2) }}</div>
        <div class="val" id="win" style="left:81.026%; top:92.553%; width:5.983%; height:4.103%;">0.00</div>

        <!-- Clickable Native Buttons on Background Artwork -->
        <div class="hit" id="minus" style="left:24.274%; top:92.705%; width:1.709%; height:3.647%;" title="Decrease Bet"></div>
        <div class="hit" id="plus" style="left:34.188%; top:92.705%; width:1.709%; height:3.647%;" title="Increase Bet"></div>
        <div class="hit" id="max" style="left:39.231%; top:91.793%; width:5.641%; height:5.623%;" title="Max Bet"></div>
        <div class="hit" id="spin" style="left:44.701%; top:84.802%; width:10.598%; height:15.198%;" title="Spin Reels"></div>
        <div class="hit" id="autob" style="left:55.299%; top:91.793%; width:5.641%; height:5.623%;" title="Auto Spin"></div>
      </div>
    </div>

    <!-- Quick Stake Bar & Mode Toggle -->
    <div class="extra-controls-bar">
      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <span style="font-size:12px; font-weight:700; color:#ca8a04;">QUICK STAKE:</span>
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
      S: "/roman-slot/assets/scatter.jpg",
      A: "/roman-slot/assets/coin-arch.jpg",
      V: "/roman-slot/assets/vase.jpg",
      W: "/roman-slot/assets/wild.jpg",
      F: "/roman-slot/assets/coin-altar.jpg",
      K: "/roman-slot/assets/coin-column.jpg",
      H: "/roman-slot/assets/helmet.jpg",
      L: "/roman-slot/assets/wreath.jpg",
      N: "/roman-slot/assets/coin-lion.jpg",
      D: "/roman-slot/assets/dagger.jpg"
    };

    const SYMBOL_ALIAS = {
      'H1': 'H', 'H2': 'D', 'H3': 'V', 'H4': 'L',
      'L1': 'N', 'L2': 'F', 'L3': 'K', 'L4': 'A',
      'W': 'W', 'S': 'S',
      'wild': 'W', 'scatter': 'S', 'helmet': 'H', 'dagger': 'D', 'vase': 'V',
      'wreath': 'L', 'coin-lion': 'N', 'coin-altar': 'F', 'coin-column': 'K', 'coin-arch': 'A'
    };

    const W0 = 1170, H0 = 658;
    const x0 = 204, y0 = 147, cw = 152.6, ch = 130.0;
    const BAG = 'KKKAAAFFFNNNHHLLVVDDWSS'.split('');

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
        d.style.cssText = `left:${(x0 + c * cw + 1) / W0 * 100}%; top:${(y0 + r * ch + 1) / H0 * 100}%; width:${(cw - 2) / W0 * 100}%; height:${(ch - 2) / H0 * 100}%;`;
        d.innerHTML = '<img>';
        st.appendChild(d);
        cells.push(d);
        grid[r].push(rnd());
      }
    }

    const draw = (r, c) => {
      const sym = grid[r][c];
      const mapped = SYMBOL_ALIAS[sym] || sym;
      cells[r * 5 + c].firstChild.src = IMG[mapped] || IMG['H'];
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
      bet = Math.max(1, Math.min(50000, v));
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
      $('msg').textContent = 'SPINNING ROMAN REELS...';
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
        const res = await fetch("{{ route('romanslots.spin') }}", {
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

        // Apply final grid from server
        if (data.grid) {
          for (let r = 0; r < 3; r++) {
            for (let c = 0; c < 5; c++) {
              grid[r][c] = data.grid[r][c];
              draw(r, c);
            }
          }
        }

        if (data.new_balance !== undefined && !isDemo) {
          bal = parseFloat(data.new_balance);
        } else if (isDemo) {
          bal = Math.max(0, bal - bet + (parseFloat(data.win_amount) || 0));
        }

        const winAmount = parseFloat(data.win_amount || 0);
        $('win').textContent = winAmount.toFixed(2);
        ui();

        if (winAmount > 0) {
          $('msg').textContent = `🎉 TRIUMPH! WIN: +৳${winAmount.toFixed(2)}`;
          if (typeof confetti === 'function') {
            confetti({ particleCount: 70, spread: 60, origin: { y: 0.65 } });
          }
          if (typeof window.triggerWinCelebration === 'function') {
            window.triggerWinCelebration({
              amount: winAmount,
              multiplier: bet > 0 ? (winAmount / bet) : 0,
              title: 'GLORY OF ROME WIN!'
            });
          }
          if (data.hit_cells && data.hit_cells.length > 0) {
            cells.forEach((d, i) => {
              if (data.hit_cells.includes(i)) {
                d.classList.add(data.scatter_win ? 'sc' : 'win');
              } else {
                d.classList.add('dim');
              }
            });
          }
        } else {
          $('msg').textContent = 'TRY AGAIN FOR THE GLORY OF ROME!';
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
    $('minus').onclick = () => setBet(Math.max(1, bet - 10));
    $('max').onclick = () => { setBet(5000); spin(); };
    $('autob').onclick = () => {
      auto = !auto;
      $('autob').classList.toggle('auto-active', auto);
      if (auto && !busy) spin();
    };
  </script>
</body>
</html>
