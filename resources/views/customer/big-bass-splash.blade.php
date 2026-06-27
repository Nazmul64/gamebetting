<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>BIG BASS SPLASH</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Teko:wght@600;700&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: #0a1628;
    font-family: 'Teko', sans-serif;
    overflow: hidden;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  /* ── TOP NAV ── */
  .topnav {
    width: 100%;
    background: #0d1f3c;
    display: flex;
    align-items: center;
    padding: 6px 16px;
    gap: 8px;
    border-bottom: 2px solid #1a3a6e;
    position: fixed;
    top: 70px;
    left: 0;
    z-index: 100;
  }
  .topnav .breadcrumb { color: #7a9cc5; font-size: 13px; }
  .topnav .breadcrumb a { color: #4a9eff; text-decoration: none; }
  .topnav .breadcrumb a:hover { text-decoration: underline; }
  .topnav .gametitle {
    margin: 0 auto;
    color: #fff;
    font-family: 'Orbitron', sans-serif;
    font-size: 14px;
    letter-spacing: 3px;
  }
  .topnav .search-box {
    background: #1a3060;
    border: 1px solid #2a5090;
    color: #aaa;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    width: 140px;
  }

  /* ── SIDE NAV ── */
  .sidenav {
    position: fixed;
    left: 0;
    top: 110px;
    bottom: 40px;
    width: 48px;
    background: #0d1f3c;
    border-right: 2px solid #1a3a6e;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 0;
    gap: 18px;
    z-index: 100;
  }
  .sidenav .icon {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    color: #4a7ab5; font-size: 18px; cursor: pointer; border-radius: 6px;
    transition: background .2s;
  }
  .sidenav .icon:hover, .sidenav .icon.active { background: #1a3a6e; color: #4a9eff; }

  /* ── BOTTOM BAR ── */
  .bottombar {
    width: 100%;
    background: #0d1f3c;
    border-top: 2px solid #1a3a6e;
    display: flex;
    align-items: center;
    padding: 6px 16px;
    gap: 16px;
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 100;
  }
  .bottombar .tab {
    display: flex; align-items: center; gap: 6px;
    color: #7a9cc5; font-size: 13px; cursor: pointer;
  }
  .bottombar .tab:hover { color: #fff; }
  .bottombar .search-box {
    background: #1a3060;
    border: 1px solid #2a5090;
    color: #aaa;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    width: 160px;
    margin-left: auto;
  }
  .bottombar .grid-icons { display: flex; gap: 6px; }
  .bottombar .grid-icon {
    width: 26px; height: 22px;
    background: #1a3060; border: 1px solid #2a5090;
    border-radius: 3px; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
  }
  .bottombar .grid-icon.active { background: #4a9eff; border-color: #4a9eff; }

  /* ── GAME AREA ── */
  .game-container {
    margin: 40px 48px 40px 48px;
    position: relative;
    width: calc(100vw - 96px);
    height: calc(100vh - 80px);
    overflow: hidden;
    border-radius: 4px;
  }

  /* ── UNDERWATER SCENE ── */
  .underwater-bg {
    position: absolute; inset: 0;
    background: linear-gradient(
      180deg,
      #c4a96a 0%, #b8944a 8%,
      #5b9fc4 12%, #2a6fa8 30%,
      #1a4f8a 55%, #0f2f60 75%, #071a40 100%
    );
  }

  /* shore/sand line */
  .shore {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 10%;
    background: linear-gradient(180deg, #d4aa55 0%, #c49040 50%, transparent 100%);
  }

  /* water surface shimmer */
  .water-surface {
    position: absolute;
    top: 9%; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.5), transparent);
    animation: shimmer 2s ease-in-out infinite;
  }
  @keyframes shimmer {
    0%,100% { opacity:.4; transform:scaleX(1); }
    50% { opacity:1; transform:scaleX(1.03); }
  }

  /* ── BUBBLES ── */
  .bubbles-container { position:absolute; inset:0; pointer-events:none; }
  .bubble {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 35%, rgba(255,255,255,.7), rgba(150,210,255,.2));
    border: 1px solid rgba(255,255,255,.5);
    animation: rise linear infinite;
  }
  @keyframes rise {
    0%   { transform:translateY(0) scale(1); opacity:.8; }
    80%  { opacity:.6; }
    100% { transform:translateY(-120vh) scale(1.1); opacity:0; }
  }

  /* ── UNDERWATER PLANTS ── */
  .plant-layer { position:absolute; bottom:0; left:0; right:0; height:35%; pointer-events:none; }
  .plant {
    position: absolute;
    bottom: 0;
    transform-origin: bottom center;
    animation: sway ease-in-out infinite;
  }
  @keyframes sway {
    0%,100% { transform:rotate(-6deg); }
    50%      { transform:rotate(6deg); }
  }

  /* SVG plant */
  .plant svg { display:block; }

  /* ── SWIMMING FISH ── */
  .bg-fish {
    position: absolute;
    pointer-events: none;
    animation: swimAcross linear infinite;
  }
  @keyframes swimAcross {
    0%   { transform:translateX(-120px) scaleX(1); }
    49%  { transform:translateX(calc(100vw + 120px)) scaleX(1); }
    50%  { transform:translateX(calc(100vw + 120px)) scaleX(-1); opacity:0; }
    51%  { transform:translateX(calc(100vw + 120px)) scaleX(-1); opacity:1; }
    100% { transform:translateX(-120px) scaleX(-1); }
  }

  /* ── FISHING LINE ANIMATION ── */
  .fishing-scene {
    position: absolute;
    top: 0; right: 80px;
    width: 60px;
    height: 100%;
    pointer-events: none;
  }
  .fishing-rod {
    position: absolute;
    top: 0; right: 0;
    width: 6px; height: 120px;
    background: linear-gradient(180deg, #8B4513, #5D2E0C);
    border-radius: 3px;
    transform: rotate(20deg);
    transform-origin: top right;
  }
  .fishing-line {
    position: absolute;
    top: 90px;
    right: 10px;
    width: 2px;
    background: rgba(255,255,255,.7);
    transform-origin: top center;
    animation: lineBob 3s ease-in-out infinite;
  }
  @keyframes lineBob {
    0%,100% { height:180px; }
    50%      { height:220px; }
  }
  .hook {
    position: absolute;
    right: 4px;
    width: 12px; height: 12px;
    border: 2px solid #ccc;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    animation: hookBob 3s ease-in-out infinite;
  }
  @keyframes hookBob {
    0%,100% { top: 272px; }
    50%      { top: 312px; }
  }

  /* ── REEL KINGDOM LOGO ── */
  .reel-logo {
    position: absolute; bottom: 6px; left: 8px;
    color: rgba(255,255,255,.5); font-size: 10px; letter-spacing:2px;
  }

  /* ── GAME HEADER LOGO ── */
  .game-logo {
    position: absolute;
    top: 6px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 30;
    pointer-events: none;
    filter: drop-shadow(0 0 12px rgba(255,180,0,.6));
  }
  .game-logo .big-bass {
    font-family: 'Orbitron', sans-serif;
    font-size: 28px;
    font-weight: 900;
    background: linear-gradient(180deg, #ffe066, #ff9900, #cc5500);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1;
    text-shadow: none;
    display: block;
  }
  .game-logo .splash {
    font-family: 'Orbitron', sans-serif;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(180deg, #ff4444, #cc0000);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: block;
    margin-top: -4px;
  }
  .logo-fish-l, .logo-fish-r {
    position: absolute;
    top: 0; font-size: 22px;
    animation: logoFishBob 2s ease-in-out infinite;
  }
  .logo-fish-l { left: -30px; }
  .logo-fish-r { right: -30px; transform: scaleX(-1); }
  @keyframes logoFishBob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }

  /* ── BUY FREE SPINS BUTTON ── */
  .buy-btn {
    position: absolute;
    top: 8px; left: 8px;
    background: radial-gradient(ellipse, #3a2a00, #1a1000);
    border: 2px solid #ffcc00;
    border-radius: 12px;
    padding: 6px 14px;
    color: #ffcc00;
    font-family: 'Teko', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    line-height: 1.3;
    z-index: 30;
    animation: pulse 1.5s ease-in-out infinite;
    box-shadow: 0 0 12px rgba(255,200,0,.5);
  }
  .buy-btn .big { font-size: 16px; }
  @keyframes pulse { 0%,100%{box-shadow:0 0 10px rgba(255,200,0,.5)} 50%{box-shadow:0 0 22px rgba(255,200,0,.9)} }

  /* ── REEL CONTAINER ── */
  .reel-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -48%);
    z-index: 20;
    background: rgba(0,20,60,.55);
    border: 3px solid rgba(100,160,255,.35);
    border-radius: 6px;
    padding: 6px;
    backdrop-filter: blur(2px);
  }
  .reel-grid {
    display: grid;
    grid-template-columns: repeat(5, 110px);
    grid-template-rows: repeat(3, 110px);
    gap: 4px;
  }
  .cell {
    width: 110px; height: 110px;
    border: 2px solid rgba(80,140,220,.4);
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    transition: border-color .1s;
    background: rgba(10,20,60,.3);
  }
  .cell.lit {
    background: radial-gradient(ellipse at 50% 50%, rgba(255,220,80,.25), rgba(200,120,0,.12));
    border-color: rgba(255,200,50,.7);
    animation: cellGlow .8s ease-in-out infinite alternate;
  }
  @keyframes cellGlow {
    from { box-shadow:inset 0 0 10px rgba(255,200,50,.2); }
    to   { box-shadow:inset 0 0 24px rgba(255,200,50,.55), 0 0 10px rgba(255,200,50,.35); }
  }
  .cell-value {
    position: absolute;
    bottom: 4px; left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,.75);
    color: #ffcc00;
    font-size: 13px;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 3px;
    white-space: nowrap;
  }
  /* symbol canvas */
  .sym { width:80px; height:80px; object-fit:contain; }
  .sym-letter {
    font-family: 'Orbitron', sans-serif;
    font-size: 52px;
    font-weight: 900;
    text-shadow: 3px 3px 6px rgba(0,0,0,.7);
    user-select: none;
  }
  .sym-K { color:#6699ff; -webkit-text-stroke:2px #2244bb; }
  .sym-10 { color:#ffdd66; -webkit-text-stroke:2px #aa8800; }
  .sym-J  { color:#44dd44; -webkit-text-stroke:2px #116611; }
  .sym-Q  { color:#ff6666; -webkit-text-stroke:2px #992222; }

  /* ── WIN LINE ── */
  .win-line {
    position: absolute;
    top: 50%; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, #ffcc00, #ff8800, #ffcc00, transparent);
    transform: translateY(-50%);
    pointer-events: none;
    opacity: 0;
    z-index: 25;
  }
  .win-line.show { animation: winFlash 1s ease-in-out infinite; }
  @keyframes winFlash { 0%,100%{opacity:0} 50%{opacity:1} }

  /* ── BOTTOM HUD ── */
  .hud {
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 18px;
    z-index: 30;
  }
  .hud-info { text-align:center; line-height:1.2; }
  .hud-label { color: #4a9eff; font-size: 12px; letter-spacing:1px; text-transform:uppercase; }
  .hud-value { color: #00ff88; font-size: 18px; font-weight: 700; }
  .hud-value.bet { color: #ffcc00; }

  /* spin button */
  .spin-btn {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: radial-gradient(circle, #2a2a2a, #111);
    border: 3px solid #444;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    position: relative;
    transition: transform .1s;
  }
  .spin-btn:hover { transform: scale(1.08); }
  .spin-btn:active { transform: scale(.95); }
  .spin-btn .crown { font-size: 28px; }
  .spin-btn .ring {
    position: absolute; inset: -5px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #ffcc00;
    border-right-color: #ff8800;
    animation: spinRing 2s linear infinite;
  }
  @keyframes spinRing { to { transform:rotate(360deg); } }

  /* +/- buttons */
  .adj-btn {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: radial-gradient(circle, #1a2a50, #0a1428);
    border: 2px solid #2a4a80;
    color: #fff; font-size: 22px;
    cursor: pointer; display: flex; align-items:center; justify-content:center;
    transition: background .15s;
  }
  .adj-btn:hover { background: radial-gradient(circle, #2a4a80, #1a2a50); }

  /* autoplay */
  .autoplay-btn {
    background: radial-gradient(circle, #1a2a50, #0a1428);
    border: 2px solid #2a4a80;
    border-radius: 20px;
    color: #fff; font-size: 11px; letter-spacing:1px;
    padding: 6px 12px; cursor:pointer;
    display: flex; align-items:center; gap:5px;
  }
  .autoplay-btn:hover { background: radial-gradient(circle, #2a4a80, #1a2a50); }

  /* place bets message */
  .place-bets {
    position: absolute;
    bottom: 90px; left: 50%;
    transform: translateX(-50%);
    color: #fff;
    font-family: 'Orbitron', sans-serif;
    font-size: 16px;
    letter-spacing: 3px;
    text-shadow: 0 0 14px rgba(255,255,255,.7);
    z-index: 30;
    pointer-events: none;
    white-space: nowrap;
  }

  /* ── SPINNING OVERLAY ── */
  .spin-overlay { display:none; position:absolute; inset:0; z-index:40; pointer-events:none; }
  .spin-overlay.active { display:block; }
  .spin-col {
    position: absolute;
    top: 0; width: 110px; overflow: hidden;
    animation: spinCol .4s cubic-bezier(.4,0,.2,1) forwards;
  }
  @keyframes spinCol { 0%{transform:translateY(-40px)} 100%{transform:translateY(0)} }

  /* ── WIN POPUP ── */
  .win-popup {
    display:none;
    position: absolute;
    top:50%; left:50%;
    transform: translate(-50%,-50%);
    background: radial-gradient(ellipse, #1a3060, #0a1828);
    border: 3px solid #ffcc00;
    border-radius: 16px;
    padding: 24px 40px;
    text-align:center;
    z-index: 50;
    box-shadow: 0 0 40px rgba(255,200,0,.6);
    animation: popIn .3s ease;
  }
  @keyframes popIn { 0%{transform:translate(-50%,-50%) scale(.5)} 100%{transform:translate(-50%,-50%) scale(1)} }
  .win-popup.show { display:block; }
  .win-popup .win-amount {
    font-family:'Orbitron',sans-serif;
    font-size: 48px;
    background: linear-gradient(180deg, #ffe066, #ff9900);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    font-weight:900;
  }
  .win-popup .win-label { color:#aad4ff; font-size:16px; letter-spacing:2px; }

  /* Top bar game info */
  .topgame-bar {
    position:absolute;
    top:0; left:0; right:0;
    height:38px;
    background: linear-gradient(180deg,rgba(0,0,0,.7),transparent);
    display:flex; align-items:center; padding: 0 10px; gap:10px; z-index:25;
  }
  .tgb-icon { font-size:20px; }
  .tgb-name { color:#fff; font-size:15px; font-weight:700; letter-spacing:1px; }
  .tgb-toggle {
    display:flex; align-items:center; gap:6px; margin-left: 10px;
  }
  .toggle-track {
    width:36px; height:18px;
    background:#333; border-radius:9px; position:relative; cursor:pointer;
    border:1px solid #555;
  }
  .toggle-knob {
    position:absolute; top:2px; left:2px;
    width:14px; height:14px;
    background:#888; border-radius:50%;
    transition: left .2s;
  }
  .tgb-play { color:#4a9eff; font-size:12px; letter-spacing:2px; text-transform:uppercase; }
  .tgb-actions { margin-left:auto; display:flex; gap:10px; align-items:center; }
  .tgb-action-btn { color:#aaa; font-size:18px; cursor:pointer; background:none; border:none; }
  .tgb-action-btn:hover { color:#fff; }

  /* ── INFO PANEL ── */
  .info-btn {
    width:28px; height:28px; border-radius:50%;
    background:rgba(0,0,0,.5); border:2px solid #4a9eff;
    color:#4a9eff; font-size:14px; font-weight:bold;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
  }
  .volume-btn {
    width:28px; height:28px; border-radius:50%;
    background:rgba(0,0,0,.5); border:2px solid #4a6a90;
    color:#4a6a90; font-size:13px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
  }
</style>
</head>
<body>

@include('customer.header')

<!-- TOP NAV -->
<div class="topnav">
  <span class="breadcrumb"><a href="{{ route('dashboard') }}">🏠 Dashboard</a> / Slots / Popular / <span>Big Bass Splash</span></span>
  <span class="gametitle">BIG BASS SPLASH</span>
  <input class="search-box" placeholder="Search" />
</div>

<!-- SIDE NAV -->
<div class="sidenav">
  <div class="icon active">♥</div>
  <div class="icon">⊞</div>
  <div class="icon">★</div>
  <div class="icon">🏆</div>
  <div class="icon">😊</div>
</div>

<!-- GAME CONTAINER -->
<div class="game-container" id="gameContainer">

  <!-- BG -->
  <div class="underwater-bg"></div>
  <div class="shore"></div>
  <div class="water-surface"></div>

  <!-- BUBBLES -->
  <div class="bubbles-container" id="bubblesContainer"></div>

  <!-- PLANTS -->
  <div class="plant-layer" id="plantLayer"></div>

  <!-- BG FISH -->
  <div id="bgFishLayer"></div>

  <!-- FISHING SCENE -->
  <div class="fishing-scene">
    <div class="fishing-rod"></div>
    <div class="fishing-line" id="fishingLine"></div>
    <div class="hook" id="hook"></div>
    <canvas id="caughtFishCanvas" width="50" height="40" style="position:absolute;right:-10px;animation:hookBob 3s ease-in-out infinite;opacity:0;transition:opacity .5s;" id="caughtFish"></canvas>
  </div>

  <!-- REEL KINGDOM -->
  <div class="reel-logo">REEL KINGDOM</div>

  <!-- TOP GAME BAR -->
  <div class="topgame-bar">
    <span class="tgb-icon">🎣</span>
    <span class="tgb-name">Big Bass Splash</span>
    <div class="tgb-toggle" id="modeToggle" style="cursor: pointer; display: flex; align-items: center; gap: 6px; margin-left: 10px;">
      <div class="toggle-track" id="modeTrack" style="width:36px; height:18px; background:#2ebd59; border-radius:9px; position:relative; cursor:pointer; border:1px solid #2ebd59;">
        <div class="toggle-knob" id="modeKnob" style="position:absolute; top:2px; left:18px; width:14px; height:14px; background:#fff; border-radius:50%; transition: left 0.2s;"></div>
      </div>
      <span class="tgb-play" id="modeText" style="color:#2ebd59; font-size:12px; letter-spacing:2px; text-transform:uppercase;">PLAY FOR REAL MONEY</span>
    </div>
    <div class="tgb-actions">
      <button class="tgb-action-btn">⊡</button>
      <button class="tgb-action-btn">⤡</button>
      <button class="tgb-action-btn" onclick="window.location.reload();">↺</button>
      <button class="tgb-action-btn">☆</button>
      <button class="tgb-action-btn" onclick="window.location.href='{{ route('dashboard') }}'">✕</button>
    </div>
  </div>

  <!-- BUY FREE SPINS -->
  <div class="buy-btn" id="buyFreeSpinsBtn">
    BUY FREE SPINS<br><span class="big" id="buySpinsPrice">$200.00</span>
  </div>

  <!-- GAME LOGO -->
  <div class="game-logo">
    <span class="big-bass">BIG BASS</span>
    <span class="splash">SPLASH.</span>
    <span class="logo-fish-l">🐟</span>
    <span class="logo-fish-r">🐟</span>
  </div>

  <!-- WIN LINE -->
  <div class="win-line" id="winLine"></div>

  <!-- REEL GRID -->
  <div class="reel-wrapper">
    <div class="reel-grid" id="reelGrid"></div>
  </div>

  <!-- PLACE BETS -->
  <div class="place-bets" id="placeBets">PLACE YOUR BETS!</div>

  <!-- HUD -->
  <div class="hud">
    <div class="volume-btn">🔈</div>
    <div class="info-btn">i</div>
    <div class="hud-info">
      <div class="hud-label">CREDIT</div>
      <div class="hud-value" id="creditDisplay">$99,998.00</div>
    </div>
    <div class="hud-info">
      <div class="hud-label">BET</div>
      <div class="hud-value bet" id="betDisplay">$2.00</div>
    </div>
    <div class="adj-btn" id="minusBtn">−</div>
    <div class="spin-btn" id="spinBtn">
      <div class="ring"></div>
      <span class="crown">👑</span>
    </div>
    <div class="adj-btn" id="plusBtn">+</div>
    <div class="autoplay-btn" id="autoplayBtn">⏺ AUTOPLAY</div>
  </div>

  <!-- WIN POPUP -->
  <div class="win-popup" id="winPopup">
    <div class="win-label">YOU WIN!</div>
    <div class="win-amount" id="winAmount">$0.00</div>
  </div>

</div>

<!-- BOTTOM BAR -->
<div class="bottombar">
  <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'">🕐 RECENT GAMES</div>
  <div class="tab">⭐ FAVORITES</div>
  <input class="search-box" placeholder="Search" />
  <div class="grid-icons">
    <div class="grid-icon active">▣</div>
    <div class="grid-icon">⊞</div>
    <div class="grid-icon">▤</div>
  </div>
</div>

<canvas id="symbolCanvas" style="display:none"></canvas>

<script>
// ══════════════════════════════════════════
//  DYNAMIC CURRENCY & BALANCE STATE
// ══════════════════════════════════════════
const userCurrency = "{{ auth()->user()->currency }}";
const currencySymbol = userCurrency === 'BDT' ? '৳' : (userCurrency === 'INR' ? '₹' : '$');

const urlParams = new URLSearchParams(window.location.search);
let realBalance = parseFloat("{{ auth()->user()->balance }}");
let isDemoMode = urlParams.get('demo') === '1' || (realBalance < 2);

let demoBalance = 10000.00;
let credit = isDemoMode ? demoBalance : realBalance;

let bet = 2;
let spinning = false;
let autoplay = false;
let autoplayInterval = null;

function fmt(n){
  return currencySymbol + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,',');
}

// Update Buy free spins display
const buyCost = 200;
document.getElementById('buySpinsPrice').textContent = fmt(buyCost);

// ══════════════════════════════════════════
//  SOUND EFFECTS (Web Audio API Synthesizer)
// ══════════════════════════════════════════
let audioCtx = null;
let soundMuted = false;

function initAudio() {
  if (!audioCtx) {
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  }
}

function playSound(type) {
  if (soundMuted) return;
  initAudio();
  if (!audioCtx) return;
  
  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();
  osc.connect(gain);
  gain.connect(audioCtx.destination);
  
  const now = audioCtx.currentTime;
  
  if (type === 'click') {
    osc.type = 'sine';
    osc.frequency.setValueAtTime(500, now);
    osc.frequency.exponentialRampToValueAtTime(100, now + 0.08);
    gain.gain.setValueAtTime(0.08, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
    osc.start(now);
    osc.stop(now + 0.08);
  } else if (type === 'spin') {
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(120, now);
    osc.frequency.linearRampToValueAtTime(450, now + 0.15);
    gain.gain.setValueAtTime(0.12, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.15);
    osc.start(now);
    osc.stop(now + 0.15);
  } else if (type === 'win') {
    const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
    notes.forEach((freq, idx) => {
      const o = audioCtx.createOscillator();
      const g = audioCtx.createGain();
      o.connect(g);
      g.connect(audioCtx.destination);
      o.type = 'sine';
      o.frequency.setValueAtTime(freq, now + idx * 0.08);
      g.gain.setValueAtTime(0.12, now + idx * 0.08);
      g.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.25);
      o.start(now + idx * 0.08);
      o.stop(now + idx * 0.08 + 0.28);
    });
  } else if (type === 'free_spins') {
    // guaranteed win fanfare
    const melody = [523.25, 587.33, 659.25, 698.46, 783.99, 880.00, 987.77, 1046.50];
    melody.forEach((freq, idx) => {
      const o = audioCtx.createOscillator();
      const g = audioCtx.createGain();
      o.connect(g);
      g.connect(audioCtx.destination);
      o.type = 'triangle';
      o.frequency.setValueAtTime(freq, now + idx * 0.12);
      g.gain.setValueAtTime(0.1, now + idx * 0.12);
      g.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.12 + 0.18);
      o.start(now + idx * 0.12);
      o.stop(now + idx * 0.12 + 0.2);
    });
  } else if (type === 'coin') {
    osc.type = 'sine';
    osc.frequency.setValueAtTime(880, now);
    osc.frequency.setValueAtTime(1200, now + 0.05);
    gain.gain.setValueAtTime(0.1, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.18);
    osc.start(now);
    osc.stop(now + 0.18);
  }
}

// ══════════════════════════════════════════
//  BUBBLES
// ══════════════════════════════════════════
const bubblesContainer = document.getElementById('bubblesContainer');
function makeBubble() {
  const b = document.createElement('div');
  b.className = 'bubble';
  const size = 4 + Math.random() * 14;
  b.style.cssText = `
    width:${size}px; height:${size}px;
    left:${Math.random()*100}%;
    bottom:-20px;
    animation-duration:${4 + Math.random()*6}s;
    animation-delay:${Math.random()*4}s;
  `;
  bubblesContainer.appendChild(b);
  setTimeout(() => b.remove(), 12000);
}
setInterval(makeBubble, 300);
for(let i=0;i<18;i++) makeBubble();

// ══════════════════════════════════════════
//  PLANTS (SVG seaweed)
// ══════════════════════════════════════════
const plantLayer = document.getElementById('plantLayer');
const plantColors = ['#1a7a3a','#2a9a4a','#0a5a2a','#3aaa5a','#8B4513','#c86c20','#9a2222'];
function makePlant(x, colorIdx, height, swayDur, swayDelay) {
  const p = document.createElement('div');
  p.className = 'plant';
  p.style.cssText = `left:${x}%; animation-duration:${swayDur}s; animation-delay:${swayDelay}s;`;
  const c = plantColors[colorIdx % plantColors.length];
  const segs = 5 + Math.floor(Math.random()*4);
  const w = 14 + Math.random()*10;
  let svg = `<svg width="${w*2}" height="${height}" viewBox="0 0 ${w*2} ${height}" xmlns="http://www.w3.org/2000/svg">`;
  for(let i=0;i<segs;i++){
    const y0=height - i*(height/segs);
    const y1=height - (i+1)*(height/segs);
    const side = i%2===0 ? 1 : -1;
    const cx = w + side*w*0.6;
    svg += `<path d="M${w},${y0} Q${cx},${(y0+y1)/2} ${w},${y1}" stroke="${c}" stroke-width="${w*0.5}" fill="none" stroke-linecap="round" opacity="${0.7+i*0.04}"/>`;
    // leaf
    if(i%2===0){
      const lx = w + side*w*1.1;
      const ly = (y0+y1)/2;
      svg += `<ellipse cx="${lx}" cy="${ly}" rx="${w*0.7}" ry="${w*0.3}" fill="${c}" opacity="0.8" transform="rotate(${side*30} ${lx} ${ly})"/>`;
    }
  }
  svg += `</svg>`;
  p.innerHTML = svg;
  plantLayer.appendChild(p);
}

// left cluster
const leftPlants = [
  [1,0,180,2.5,0],[3,1,220,3,0.3],[5,2,160,2.8,0.1],[7,0,200,3.2,0.5],
  [9,3,140,2.3,0.2],[11,1,190,2.9,0.4],[13,2,170,3.1,0.1],
  [2,6,130,2.1,0.3],[4,5,110,2.4,0.6]
];
leftPlants.forEach(([x,c,h,d,dl])=>makePlant(x,c,h,d,dl));

// right cluster
const rightPlants = [
  [82,0,200,2.7,0.2],[85,1,160,3,0.1],[88,2,230,2.5,0.4],[91,3,180,2.8,0],
  [94,0,150,3.2,0.3],[97,1,210,2.6,0.5],
  [84,5,120,2.2,0.1],[87,6,140,2.4,0.3],[92,5,100,2.0,0.5]
];
rightPlants.forEach(([x,c,h,d,dl])=>makePlant(x,c,h,d,dl));

// scattered middle-lower
for(let i=0;i<6;i++){
  makePlant(15+i*10, i%3, 80+Math.random()*60, 2+Math.random(), Math.random()*.5);
  makePlant(70-i*5, (i+2)%4, 70+Math.random()*50, 2.2+Math.random(), Math.random()*.5);
}

// ══════════════════════════════════════════
//  BACKGROUND FISH
// ══════════════════════════════════════════
const bgFishLayer = document.getElementById('bgFishLayer');
const fishEmojis = ['🐟','🐠','🐡','🦈'];
function makeBgFish(){
  const f = document.createElement('div');
  f.className = 'bg-fish';
  const size = 20 + Math.random()*24;
  const top = 20 + Math.random()*60;
  const dur = 8 + Math.random()*12;
  const delay = Math.random()*10;
  const emoji = fishEmojis[Math.floor(Math.random()*fishEmojis.length)];
  f.style.cssText = `
    top:${top}%; font-size:${size}px;
    animation-duration:${dur}s;
    animation-delay:-${delay}s;
    opacity:${0.4+Math.random()*.4};
  `;
  f.textContent = emoji;
  bgFishLayer.appendChild(f);
}
for(let i=0;i<10;i++) makeBgFish();

// ══════════════════════════════════════════
//  FISHING LINE CATCH ANIMATION
// ══════════════════════════════════════════
const caughtFish = document.getElementById('caughtFishCanvas');
const caughtCtx = caughtFish.getContext('2d');
function drawCaughtFish(ctx){
  ctx.clearRect(0,0,50,40);
  ctx.save();
  ctx.font='28px serif';
  ctx.fillText('🐟',2,32);
  ctx.restore();
}
drawCaughtFish(caughtCtx);

let catchPhase = 0;
setInterval(()=>{
  catchPhase++;
  if(catchPhase % 8 === 0) {
    caughtFish.style.opacity = '1';
    setTimeout(()=>{ caughtFish.style.opacity='0'; }, 1200);
  }
},1000);

// ══════════════════════════════════════════
//  SYMBOL DRAWING (canvas-based)
// ══════════════════════════════════════════
function drawFish(ctx, w, h, variant) {
  ctx.clearRect(0,0,w,h);
  const cx=w/2, cy=h/2;
  // glow bg
  const grd = ctx.createRadialGradient(cx,cy,0,cx,cy,w*.45);
  grd.addColorStop(0,'rgba(255,200,80,.35)');
  grd.addColorStop(1,'rgba(255,150,0,0)');
  ctx.fillStyle=grd;
  ctx.fillRect(0,0,w,h);
  // fish body
  ctx.save();
  ctx.translate(cx,cy);
  const colors = [
    {body:'#d63030',fin:'#8b1010',belly:'#ff8080',eye:'#fff'},
    {body:'#2080d0',fin:'#104080',belly:'#80c0ff',eye:'#fff'},
    {body:'#30a030',fin:'#105010',belly:'#80e080',eye:'#fff'},
  ];
  const col = colors[variant%colors.length];
  const bw=w*.38, bh=h*.26;
  // tail
  ctx.beginPath();
  ctx.moveTo(-bw*.6,0);
  ctx.lineTo(-bw,bh*.8);
  ctx.lineTo(-bw,-bh*.8);
  ctx.closePath();
  ctx.fillStyle=col.fin; ctx.fill();
  // body
  ctx.beginPath();
  ctx.ellipse(0,0,bw,bh,0,0,Math.PI*2);
  ctx.fillStyle=col.body; ctx.fill();
  // belly stripe
  ctx.beginPath();
  ctx.ellipse(0,bh*.15,bw*.75,bh*.4,0,0,Math.PI*2);
  ctx.fillStyle=col.belly; ctx.globalAlpha=.5; ctx.fill(); ctx.globalAlpha=1;
  // dorsal fin
  ctx.beginPath();
  ctx.moveTo(-bw*.1,-bh);
  ctx.quadraticCurveTo(0,-bh*1.6,bw*.4,-bh);
  ctx.lineTo(bw*.1,-bh*.9);
  ctx.fillStyle=col.fin; ctx.fill();
  // eye
  ctx.beginPath();
  ctx.arc(bw*.45,-bh*.1,bh*.25,0,Math.PI*2);
  ctx.fillStyle=col.eye; ctx.fill();
  ctx.beginPath();
  ctx.arc(bw*.48,-bh*.12,bh*.13,0,Math.PI*2);
  ctx.fillStyle='#111'; ctx.fill();
  // scale detail
  for(let i=0;i<3;i++){
    ctx.beginPath();
    ctx.arc(-bw*.1+i*bw*.22, bh*.05, bh*.15, Math.PI, 0);
    ctx.strokeStyle='rgba(0,0,0,.25)'; ctx.lineWidth=1.5; ctx.stroke();
  }
  // value tag glow
  ctx.restore();
  // border glow
  const br = ctx.createRadialGradient(cx,cy,w*.3,cx,cy,w*.5);
  br.addColorStop(0,'rgba(255,180,0,0)');
  br.addColorStop(1,'rgba(255,180,0,.25)');
  ctx.fillStyle=br; ctx.fillRect(0,0,w,h);
}

function drawTackleBox(ctx,w,h){
  ctx.clearRect(0,0,w,h);
  const cx=w/2,cy=h/2;
  // outer box
  ctx.fillStyle='#c0282a';
  ctx.beginPath();
  ctx.roundRect(cx-w*.38,cy-h*.28,w*.76,h*.56,4);
  ctx.fill();
  // lid highlight
  ctx.fillStyle='#e03030';
  ctx.beginPath();
  ctx.roundRect(cx-w*.36,cy-h*.26,w*.72,h*.18,3);
  ctx.fill();
  // handle
  ctx.strokeStyle='#888'; ctx.lineWidth=3;
  ctx.beginPath();
  ctx.arc(cx,cy-h*.2,w*.1,Math.PI,0);
  ctx.stroke();
  // latch
  ctx.fillStyle='#aaa';
  ctx.fillRect(cx-w*.04,cy-h*.02,w*.08,h*.08);
  // brand text
  ctx.fillStyle='#fff'; ctx.font=`bold ${w*.1}px Arial`;
  ctx.textAlign='center'; ctx.fillText('TACKLE',cx,cy+h*.08);
  ctx.fillStyle='#ffcc00'; ctx.font=`bold ${w*.08}px Arial`;
  ctx.fillText('BOX',cx,cy+h*.2);
  // small items
  for(let i=0;i<3;i++){
    ctx.beginPath(); ctx.arc(cx-w*.18+i*w*.18,cy+h*.06,3,0,Math.PI*2);
    ctx.fillStyle=['#f00','#0af','#ff0'][i]; ctx.fill();
  }
}

function createSymbolCanvas(type, size=80){
  const c = document.createElement('canvas');
  c.width=c.height=size;
  const ctx=c.getContext('2d');
  if(type==='fish1')   drawFish(ctx,size,size,0);
  else if(type==='fish2') drawFish(ctx,size,size,1);
  else if(type==='fish3') drawFish(ctx,size,size,2);
  else if(type==='tackle') drawTackleBox(ctx,size,size);
  return c.toDataURL();
}

// ══════════════════════════════════════════
//  REEL LOGIC
// ══════════════════════════════════════════
const SYMBOLS = [
  {id:'fish1',  label:'🐟', isCanvas:true, value:'$4.00'},
  {id:'fish2',  label:'🐟', isCanvas:true, value:'$30.00'},
  {id:'fish3',  label:'🐟', isCanvas:true, value:'$20.00'},
  {id:'tackle', label:'📦', isCanvas:true, value:null},
  {id:'K',  label:'K',  isCanvas:false, cls:'sym-K'},
  {id:'10', label:'10', isCanvas:false, cls:'sym-10'},
  {id:'J',  label:'J',  isCanvas:false, cls:'sym-J'},
  {id:'Q',  label:'Q',  isCanvas:false, cls:'sym-Q'},
];

// Initial grid matching screenshot
const initialGrid = [
  // row0
  ['K',     'fish1', '10',    'tackle','K'],
  // row1
  ['10',    'fish2', 'fish3', 'K',     'J'],
  // row2
  ['tackle','tackle','fish3', 'Q',     'fish1'],
];

const litCells = [
  [0,1],[1,1],[2,1],[1,2],[2,2],[2,3]
];

const reelGrid = document.getElementById('reelGrid');
let currentGrid = initialGrid.map(r=>[...r]);

// cache canvas images
const canvasImages = {};
['fish1','fish2','fish3','tackle'].forEach(id=>{
  canvasImages[id] = createSymbolCanvas(id,80);
});

function litKey(r,c){ return litCells.some(([lr,lc])=>lr===r&&lc===c); }

function renderGrid(grid){
  reelGrid.innerHTML='';
  for(let r=0;r<3;r++){
    for(let c=0;c<5;c++){
      const sym = grid[r][c];
      const cell = document.createElement('div');
      cell.className='cell'+(litKey(r,c)?' lit':'');
      const symDef = SYMBOLS.find(s=>s.id===sym);
      if(symDef.isCanvas){
        const img=document.createElement('img');
        img.src=canvasImages[sym];
        img.className='sym';
        cell.appendChild(img);
        if(symDef.value){
          const v=document.createElement('div');
          v.className='cell-value';
          v.textContent=symDef.value;
          cell.appendChild(v);
        }
      } else {
        const sp=document.createElement('span');
        sp.className='sym-letter '+symDef.cls;
        sp.textContent=sym;
        cell.appendChild(sp);
      }
      reelGrid.appendChild(cell);
    }
  }
}
renderGrid(currentGrid);

// ══════════════════════════════════════════
//  SPIN LOGIC
// ══════════════════════════════════════════
const creditDisplay = document.getElementById('creditDisplay');
const betDisplay = document.getElementById('betDisplay');
const placeBets = document.getElementById('placeBets');
const winLine = document.getElementById('winLine');
const winPopup = document.getElementById('winPopup');
const winAmount = document.getElementById('winAmount');

function updateHUD(){
  creditDisplay.textContent=fmt(credit);
  betDisplay.textContent=fmt(bet);
}

function syncBalance(newBalance) {
  if (isDemoMode) {
    demoBalance = newBalance;
    return;
  }
  realBalance = newBalance;
  
  fetch('{{ route("dashboard.update-balance") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ balance: newBalance.toFixed(2) })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      console.log('Balance successfully synced to DB:', newBalance);
    }
  })
  .catch(err => console.error('Error syncing balance:', err));
}

function randomSym(){
  const weights=[3,2,2,3,5,5,4,4]; // distribution
  const total=weights.reduce((a,b)=>a+b,0);
  let r=Math.random()*total;
  for(let i=0;i<SYMBOLS.length;i++){ r-=weights[i]; if(r<=0) return SYMBOLS[i].id; }
  return SYMBOLS[0].id;
}

function calcWin(grid){
  // check middle row for 3+ same
  const mid = grid[1];
  const counts={};
  mid.forEach(s=>{ counts[s]=(counts[s]||0)+1; });
  const fishIds=['fish1','fish2','fish3'];
  let win=0;
  for(const [sym,cnt] of Object.entries(counts)){
    if(cnt>=3){
      const isFish=fishIds.includes(sym);
      if(isFish) win += cnt===3?30:cnt===4?60:120;
      else win += cnt===3?5:cnt===4?10:20;
    }
  }
  return win;
}

function doSpin(){
  if(spinning) return;
  if(credit<bet){
    playSound('lose');
    placeBets.textContent='INSUFFICIENT FUNDS!';
    return;
  }
  spinning=true;
  credit-=bet;
  updateHUD();
  syncBalance(credit);
  playSound('spin');

  placeBets.style.opacity='0';
  winLine.classList.remove('show');
  winPopup.classList.remove('show');

  // animate grid flash
  let flashCount=0;
  const flashInterval=setInterval(()=>{
    playSound('click');
    flashCount++;
    const tempGrid=[];
    for(let r=0;r<3;r++){
      tempGrid.push([]);
      for(let c=0;c<5;c++) tempGrid[r].push(randomSym());
    }
    renderGrid(tempGrid);
    if(flashCount>=8){
      clearInterval(flashInterval);
      // final grid
      const newGrid=[];
      for(let r=0;r<3;r++){
        newGrid.push([]);
        for(let c=0;c<5;c++) newGrid[r].push(randomSym());
      }
      currentGrid=newGrid;
      renderGrid(newGrid);
      const won=calcWin(newGrid)*bet;
      credit+=won;
      updateHUD();
      if(won>0){
        playSound('win');
        winLine.classList.add('show');
        winAmount.textContent=fmt(won);
        winPopup.classList.add('show');
        syncBalance(credit);
        setTimeout(()=>{winPopup.classList.remove('show');winLine.classList.remove('show');},2500);
      }
      placeBets.style.opacity='1';
      placeBets.textContent='PLACE YOUR BETS!';
      spinning=false;
    }
  },80);
}

document.getElementById('spinBtn').addEventListener('click', () => {
  initAudio();
  doSpin();
});

document.addEventListener('keydown', e=>{
  if(e.code==='Space') {
    e.preventDefault();
    initAudio();
    doSpin();
  }
});

document.getElementById('plusBtn').addEventListener('click',()=>{
  playSound('click');
  const steps=[0.5,1,2,5,10,25,50,100];
  const idx=steps.indexOf(bet);
  if(idx<steps.length-1){ bet=steps[idx+1]; updateHUD(); }
});
document.getElementById('minusBtn').addEventListener('click',()=>{
  playSound('click');
  const steps=[0.5,1,2,5,10,25,50,100];
  const idx=steps.indexOf(bet);
  if(idx>0){ bet=steps[idx-1]; updateHUD(); }
});

// Autoplay features
document.getElementById('autoplayBtn').addEventListener('click', () => {
  playSound('click');
  if (autoplay) {
    clearInterval(autoplayInterval);
    autoplay = false;
    document.getElementById('autoplayBtn').textContent = '⏺ AUTOPLAY';
    document.getElementById('autoplayBtn').style.background = 'radial-gradient(circle, #1a2a50, #0a1428)';
  } else {
    autoplay = true;
    document.getElementById('autoplayBtn').textContent = '⏹ STOP AUTO';
    document.getElementById('autoplayBtn').style.background = 'radial-gradient(circle, #ff2222, #990000)';
    doSpin();
    autoplayInterval = setInterval(() => {
      if (!spinning) {
        if (credit < bet) {
          clearInterval(autoplayInterval);
          autoplay = false;
          document.getElementById('autoplayBtn').textContent = '⏺ AUTOPLAY';
          document.getElementById('autoplayBtn').style.background = 'radial-gradient(circle, #1a2a50, #0a1428)';
        } else {
          doSpin();
        }
      }
    }, 3200);
  }
});

// Buy Free spins guarantees win
document.getElementById('buyFreeSpinsBtn').addEventListener('click', () => {
  if (spinning) return;
  initAudio();
  const buyCost = 200;
  if (credit < buyCost) {
    playSound('lose');
    placeBets.textContent = 'INSUFFICIENT FUNDS!';
    return;
  }
  
  if (confirm("Buy Free Spins for " + fmt(buyCost) + "?")) {
    credit -= buyCost;
    updateHUD();
    syncBalance(credit);
    playSound('free_spins');
    
    spinning = true;
    placeBets.style.opacity = '0';
    winLine.classList.remove('show');
    winPopup.classList.remove('show');
    
    let flashCount = 0;
    const flashInterval = setInterval(() => {
      playSound('click');
      flashCount++;
      const tempGrid = [];
      for(let r=0; r<3; r++){
        tempGrid.push([]);
        for(let c=0; c<5; c++) tempGrid[r].push(randomSym());
      }
      renderGrid(tempGrid);
      
      if (flashCount >= 12) {
        clearInterval(flashInterval);
        
        // Force a big win: generate 4 of 'fish2' in the middle row, and some other matching symbols
        const newGrid = [
          [randomSym(), randomSym(), randomSym(), randomSym(), randomSym()],
          ['fish2', 'fish2', 'fish3', 'fish2', 'fish2'],
          [randomSym(), randomSym(), randomSym(), randomSym(), randomSym()]
        ];
        currentGrid = newGrid;
        renderGrid(newGrid);
        
        const won = calcWin(newGrid) * bet * 5;
        credit += won;
        updateHUD();
        syncBalance(credit);
        
        playSound('win');
        winLine.classList.add('show');
        winAmount.textContent = fmt(won);
        winPopup.classList.add('show');
        
        setTimeout(() => {
          winPopup.classList.remove('show');
          winLine.classList.remove('show');
        }, 3500);
        
        placeBets.style.opacity = '1';
        placeBets.textContent = 'FREE SPINS WIN!';
        spinning = false;
      }
    }, 80);
  }
});

// volume toggler
const volBtn = document.querySelector('.volume-btn');
volBtn.addEventListener('click', () => {
  soundMuted = !soundMuted;
  volBtn.textContent = soundMuted ? '🔇' : '🔈';
  if (!soundMuted) {
    initAudio();
    playSound('coin');
  }
});

function updateModeUI() {
  const track = document.getElementById('modeTrack');
  const knob = document.getElementById('modeKnob');
  const text = document.getElementById('modeText');
  
  if (isDemoMode) {
    track.style.background = '#555';
    track.style.borderColor = '#555';
    knob.style.left = '2px';
    text.textContent = 'DEMO PLAY';
    text.style.color = '#8ca3c7';
    placeBets.textContent = 'DEMO PLAY MODE';
  } else {
    track.style.background = '#2ebd59';
    track.style.borderColor = '#2ebd59';
    knob.style.left = '18px';
    text.textContent = 'PLAY FOR REAL MONEY';
    text.style.color = '#2ebd59';
    placeBets.textContent = 'PLACE YOUR BETS!';
  }
  updateHUD();
}

document.getElementById('modeToggle').addEventListener('click', () => {
  if (spinning) return;
  playSound('click');
  isDemoMode = !isDemoMode;
  
  if (isDemoMode) {
    credit = demoBalance;
  } else {
    credit = realBalance;
  }
  updateModeUI();
});

updateModeUI();

// ══════════════════════════════════════════
//  WATER RIPPLE on click
// ══════════════════════════════════════════
const gameContainer = document.getElementById('gameContainer');
gameContainer.addEventListener('click', e=>{
  const ripple = document.createElement('div');
  const rect = gameContainer.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  ripple.style.cssText = `
    position:absolute;
    left:${x}px; top:${y}px;
    width:4px; height:4px;
    border-radius:50%;
    border:2px solid rgba(100,180,255,.8);
    transform:translate(-50%,-50%);
    animation:rippleOut .7s ease-out forwards;
    pointer-events:none;
    z-index:60;
  `;
  gameContainer.appendChild(ripple);
  setTimeout(()=>ripple.remove(), 800);
});
const rStyle=document.createElement('style');
rStyle.textContent=`@keyframes rippleOut{0%{width:4px;height:4px;opacity:1}100%{width:80px;height:80px;opacity:0}}`;
document.head.appendChild(rStyle);
</script>
</body>
</html>
