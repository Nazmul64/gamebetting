<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Elves' Kingdom — Slot Game</title>
<!-- Google Fonts for premium typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   1XBET LAYOUT PANELS
   ============================================================ */
*{ box-sizing:border-box; margin:0; padding:0; font-family:'Outfit','Trebuchet MS',sans-serif; }

body {
  background: #0a1812;
  overflow: hidden;
  height: 100vh;
}

/* ambient felt backdrop */
.table-felt {
  position: fixed;
  inset: 0;
  z-index: 0;
  background:
    radial-gradient(ellipse at 50% -10%, rgba(217,164,67,.10), transparent 55%),
    radial-gradient(ellipse at 50% 110%, rgba(0,0,0,.6), transparent 60%),
    repeating-linear-gradient(115deg, rgba(255,255,255,.015) 0 2px, transparent 2px 6px),
    linear-gradient(160deg, #0d2a1c, #081610 70%);
}

.topnav {
  width: 100%;
  background: #0f223f;
  border-bottom: 2px solid #1d3354;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  position: fixed;
  top: 0;
  left: 0;
  height: 50px;
  z-index: 100;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}
.topnav .breadcrumb { color: #8ca3c7; font-size: 11px; display: flex; align-items: center; gap: 4px; font-weight: 600; }
.topnav .breadcrumb a { color: #8ca3c7; text-decoration: none; transition: color 0.2s; }
.topnav .breadcrumb a:hover { color: #fff; }
.topnav .breadcrumb span { color: #4a7aaa; }
.topnav .gametitle {
  color: #fff;
  font-size: 16px;
  font-weight: 800;
  letter-spacing: 2px;
  text-transform: uppercase;
}
.topnav .topNavRight { display: flex; align-items: center; gap: 16px; }
.topnav .search-box {
  background: rgba(26, 48, 96, 0.6);
  border: 1px solid #2a5090;
  color: #fff;
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 11px;
  width: 150px;
  outline: none;
}
.topnav .navIcons { display: flex; gap: 12px; }
.topnav .navIcon { color: #8ca3c7; font-size: 14px; cursor: pointer; transition: color 0.2s; user-select: none; }
.topnav .navIcon:hover { color: #d9a443; }

.sidenav {
  position: fixed;
  left: 0;
  top: 50px;
  bottom: 40px;
  width: 54px;
  background: #0f223f;
  border-right: 2px solid #1d3354;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px 0;
  gap: 24px;
  z-index: 100;
}
.sidenav .icon-btn {
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #8ca3c7;
  font-size: 16px;
  cursor: pointer;
  border-radius: 8px;
  transition: all 0.3s;
  background: transparent;
  border: none;
  outline: none;
}
.sidenav .icon-btn:hover, .sidenav .icon-btn.active {
  background: rgba(26, 118, 210, 0.2);
  color: #fff;
}

.bottombar {
  width: 100%;
  background: #0f223f;
  border-top: 2px solid #1d3354;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  position: fixed;
  bottom: 0;
  left: 0;
  height: 40px;
  z-index: 100;
  box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.4);
  font-size: 11px;
  color: #8ca3c7;
}
.bottombar .left-tabs { display: flex; gap: 20px; text-transform: uppercase; font-weight: bold; }
.bottombar .tab { display: flex; align-items: center; gap: 6px; cursor: pointer; transition: color 0.2s; }
.bottombar .tab:hover { color: #fff; }
.bottombar .search-box {
  background: rgba(26, 48, 96, 0.6);
  border: 1px solid #2a5090;
  color: #fff;
  padding: 4px 12px;
  border-radius: 4px;
  font-size: 11px;
  width: 180px;
  outline: none;
}

#gameWrapper {
  width: 100%;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  position: relative;
  z-index: 1;
}

.main-layout-container {
  display: flex;
  flex: 1;
  margin-left: 54px;
  margin-top: 50px;
  margin-bottom: 40px;
  min-height: calc(100vh - 90px);
}

.left-toggle-panel {
  width: 240px;
  background: #0e2a1d;
  border-right: 1px solid rgba(217, 164, 67, 0.2);
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  color: #fff;
  position: relative;
  z-index: 5;
}
.left-toggle-panel .game-header-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.left-toggle-panel .logoOrb {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1d5c43, #d9a443);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: bold;
}
.left-toggle-panel .logoName {
  font-size: 15px;
  font-weight: bold;
  color: #f3e6c8;
}
.left-toggle-panel .rmToggle {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  color: #ffe9b0;
  margin-top: 10px;
  cursor: pointer;
}
.left-toggle-panel .togSwitch {
  width: 34px;
  height: 17px;
  background: #0a1812;
  border-radius: 9px;
  position: relative;
  border: 1px solid rgba(217, 164, 67, 0.4);
  cursor: pointer;
}
.left-toggle-panel .togDot {
  width: 13px;
  height: 13px;
  background: #8a5e1f;
  border-radius: 50%;
  position: absolute;
  top: 1px;
  left: 1px;
  transition: left .2s, background .2s;
}
.left-toggle-panel .togSwitch.on .togDot {
  left: 18px;
  background: #d9a443;
}

.game-content-panel {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 14px 20px;
  position: relative;
  z-index: 5;
  overflow-y: auto;
}

/* ============================================================
   MYSTIC KINGDOM — slot cabinet styling
   ============================================================ */
:root{
  --bg-deep:    #0a1812;
  --bg-felt:    #0e2a1d;
  --emerald:    #1d5c43;
  --emerald-lt: #2f8462;
  --gold:       #d9a443;
  --gold-lt:    #ffe9b0;
  --gold-dk:    #8a5e1f;
  --ember:      #e2572b;
  --amethyst:   #9a6fd1;
  --ink:        #0a1812;
  --parchment:  #f3e6c8;
  --shadow:     rgba(0,0,0,.55);
}

.cabinet{
  position:relative; z-index:1;
  width: 100%;
  max-width:980px;
  margin:0 auto;
  padding:10px 16px;
  display:flex;
  flex-direction:column;
  align-items:center;
  perspective:1400px;
}

/* ---------------- Marquee ---------------- */
.marquee{
  text-align:center;
  margin-bottom:6px;
}
.marquee-glow{
  width:min(560px, 92vw);
  height:auto;
  filter: drop-shadow(0 0 10px rgba(217,164,67,.55)) drop-shadow(0 2px 0 #5a3a10);
}
.marquee-text{
  font-family: Georgia, 'Times New Roman', serif;
  font-size:46px;
  font-weight:700;
  letter-spacing:4px;
  font-style:italic;
  stroke:#5a3410;
  stroke-width:1.5px;
  paint-order:stroke fill;
}
.marquee-sub{
  font-size:12px;
  letter-spacing:3px;
  color:var(--gold-lt);
  opacity:.75;
  text-transform:uppercase;
  margin-top:-6px;
}

/* ---------------- Ornate frame ---------------- */
.frame{
  position:relative;
  width:min(820px, 94vw);
  border-radius:18px;
  padding:14px;
  background:
    linear-gradient(155deg, #3a2510, #1c1305 60%, #3a2510);
  box-shadow:
    0 18px 40px var(--shadow),
    inset 0 0 0 2px rgba(255,233,176,.25),
    inset 0 0 22px rgba(0,0,0,.6);
  transform: rotateX(2deg);
  transform-style: preserve-3d;
}
.frame::before{
  content:"";
  position:absolute; inset:6px;
  border-radius:12px;
  background: repeating-linear-gradient(45deg, rgba(217,164,67,.12) 0 4px, transparent 4px 10px);
  opacity:.5;
  pointer-events:none;
}
.frame-corner{
  position:absolute;
  width:34px; height:34px;
  border:3px solid var(--gold-lt);
  opacity:.85;
  border-radius:6px;
  filter:drop-shadow(0 0 4px rgba(255,233,176,.5));
}
.frame-corner.tl{ top:6px; left:6px; border-right:none; border-bottom:none; }
.frame-corner.tr{ top:6px; right:6px; border-left:none; border-bottom:none; }
.frame-corner.bl{ bottom:6px; left:6px; border-right:none; border-top:none; }
.frame-corner.br{ bottom:6px; right:6px; border-left:none; border-top:none; }

/* payline number pips along the sides */
.payline-pips{
  position:absolute;
  top:14px; bottom:14px;
  width:26px;
  display:flex;
  flex-direction:column;
  justify-content:space-evenly;
  align-items:center;
  z-index:5;
}
.payline-pips.left{ left:-4px; }
.payline-pips.right{ right:-4px; }
.payline-pips span{
  width:22px; height:22px;
  border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:11px; font-weight:700;
  background: radial-gradient(circle at 35% 30%, #fff2cf, var(--gold) 60%, var(--gold-dk));
  color:#3a2509;
  box-shadow:0 2px 4px rgba(0,0,0,.5), inset 0 1px 1px rgba(255,255,255,.6);
  border:1px solid rgba(90,52,16,.6);
  transition: transform .15s, box-shadow .15s, background .15s;
}
.payline-pips span.lit{
  background: radial-gradient(circle at 35% 30%, #fff9e0, #ffd76a 55%, #e2572b);
  transform:scale(1.18);
  box-shadow:0 0 10px 3px rgba(255,200,90,.85), inset 0 1px 1px rgba(255,255,255,.8);
  color:#3a1505;
}

/* ---------------- Reel window ---------------- */
.reel-window{
  position:relative;
  width:100%;
  aspect-ratio: 5 / 3.1;
  border-radius:10px;
  overflow:hidden;
  background: linear-gradient(180deg, #061008, #0c2014 12%, #0c2014 88%, #061008);
  box-shadow:
    inset 0 0 0 3px #1c1305,
    inset 0 10px 24px rgba(0,0,0,.7),
    inset 0 -10px 24px rgba(0,0,0,.7);
}
#reelCanvas, #fxCanvas{
  position:absolute; inset:0;
  width:100%; height:100%;
  display:block;
}
#fxCanvas{ pointer-events:none; }

.win-banner{
  position:absolute;
  top:8%;
  left:50%;
  transform:translate(-50%, -12px);
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:2px;
  padding:8px 26px;
  border-radius:10px;
  background:linear-gradient(160deg, rgba(28,77,58,.92), rgba(8,22,16,.92));
  border:1px solid rgba(255,233,176,.5);
  box-shadow:0 6px 18px rgba(0,0,0,.6), 0 0 18px rgba(255,200,90,.35);
  opacity:0;
  pointer-events:none;
  transition: opacity .25s ease, transform .25s ease;
  z-index:8;
  text-align:center;
}
.win-banner.show{
  opacity:1;
  transform:translate(-50%, 0);
}
.win-line-label{
  font-size:13px;
  letter-spacing:2px;
  color:var(--gold-lt);
  text-transform:uppercase;
}
.win-amount-label{
  font-size:28px;
  font-weight:800;
  color:#fff7df;
  text-shadow:0 0 10px rgba(255,200,90,.8);
  font-family: Georgia, serif;
}

/* ---------------- Control deck ---------------- */
.control-deck{
  display:flex;
  align-items:stretch;
  gap:8px;
  width:min(900px, 96vw);
  margin-top:14px;
  padding:10px 12px;
  border-radius:14px;
  background:linear-gradient(160deg, #173d2c, #0b1f15);
  box-shadow:
    0 10px 24px var(--shadow),
    inset 0 0 0 1px rgba(255,233,176,.2),
    inset 0 2px 8px rgba(0,0,0,.4);
  flex-wrap:wrap;
  justify-content:center;
}

.readout{ display:flex; align-items:stretch; }
.readout-box{
  min-width:78px;
  padding:6px 10px;
  border-radius:8px;
  background:linear-gradient(180deg, #0a1f15, #0d2a1c);
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.4), inset 0 2px 6px rgba(0,0,0,.5);
  display:flex; flex-direction:column; align-items:center;
  justify-content:center;
}
.readout-box label{
  font-size:9px;
  letter-spacing:1.5px;
  text-transform:uppercase;
  color:var(--gold-lt);
  opacity:.7;
}
.readout-box span{
  font-size:18px;
  font-weight:700;
  color:#fff7df;
  font-family: Georgia, serif;
}
.win-readout .readout-box span{ color:#9bffb0; }
.win-readout .readout-box{ box-shadow:inset 0 0 0 1px rgba(120,255,150,.45), inset 0 2px 6px rgba(0,0,0,.5); }

.readout.small{ gap:4px; align-items:center; }
.stepper{
  width:26px; height:26px;
  border-radius:50%;
  border:1px solid rgba(217,164,67,.6);
  background:radial-gradient(circle at 35% 30%, #2f8462, #133525);
  color:var(--gold-lt);
  font-size:16px;
  font-weight:700;
  cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  transition: transform .1s, background .15s;
}
.stepper:hover{ background:radial-gradient(circle at 35% 30%, #3a9d76, #15412e); }
.stepper:active{ transform:scale(.88); }

.spin-btn{
  width:78px; height:78px;
  border-radius:50%;
  border:3px solid var(--gold-lt);
  background: radial-gradient(circle at 35% 28%, #ffdf8f, var(--gold) 55%, #a86a16);
  color:#3a1505;
  font-weight:800;
  font-size:13px;
  letter-spacing:1px;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:2px;
  cursor:pointer;
  box-shadow:0 4px 0 #5a3410, 0 8px 14px rgba(0,0,0,.5), inset 0 2px 3px rgba(255,255,255,.6);
  transition: transform .08s, box-shadow .08s;
}
.spin-btn .spin-icon{ width:22px; height:22px; }
.spin-btn:active{
  transform:translateY(3px);
  box-shadow:0 1px 0 #5a3410, 0 3px 8px rgba(0,0,0,.5), inset 0 2px 3px rgba(255,255,255,.6);
}
.spin-btn:disabled{ opacity:.55; cursor:default; }
.spin-btn.spinning .spin-icon{ animation: spin-rotate 0.7s linear infinite; }
@keyframes spin-rotate{ to{ transform:rotate(360deg); } }

.max-bet-btn, .auto-btn{
  align-self:center;
  padding:10px 14px;
  border-radius:8px;
  border:1px solid rgba(217,164,67,.6);
  background:linear-gradient(180deg, #2f8462, #133525);
  color:var(--gold-lt);
  font-size:11px;
  font-weight:700;
  letter-spacing:1px;
  cursor:pointer;
  transition: transform .1s, filter .15s;
}
.max-bet-btn:hover, .auto-btn:hover{ filter:brightness(1.15); }
.max-bet-btn:active, .auto-btn:active{ transform:scale(.95); }
.auto-btn.active{
  background:linear-gradient(180deg, var(--ember), #8a2e15);
  color:#fff0e6;
}

.cabinet-footer{
  margin-top:10px;
  font-size:11px;
  color:rgba(243,230,200,.45);
  letter-spacing:.5px;
  text-align:center;
}

/* ---------------- Responsive ---------------- */
@media (max-width: 640px){
  .marquee-text{ font-size:34px; }
  .payline-pips{ width:18px; }
  .payline-pips span{ width:16px; height:16px; font-size:9px; }
  .readout-box{ min-width:62px; padding:5px 6px; }
  .readout-box span{ font-size:14px; }
  .spin-btn{ width:64px; height:64px; font-size:11px; }
}

/* reduced motion */
@media (prefers-reduced-motion: reduce){
  .spin-btn.spinning .spin-icon{ animation:none; }
  .win-banner{ transition:none; }
}
</style>
</head>
<body>

  <div class="table-felt"></div>

  <!-- TOP NAV (1XBET STYLE) -->
  <div class="topnav">
    <div class="breadcrumb">
      <a href="{{ route('dashboard') }}">Home</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Slots</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Popular</a>
      <span>/</span>
      <span style="color:#fff; font-weight:bold;">Elves' Kingdom</span>
    </div>
    <div class="gametitle">ELVES' KINGDOM</div>
    <div class="topNavRight">
      <input type="text" class="search-box" placeholder="Search..." disabled>
      <div class="navIcons">
        <span class="navIcon" title="Windowed" onclick="window.location.href='{{ route('dashboard') }}'">&#9645;</span>
        <span class="navIcon" title="Fullscreen" onclick="toggleFullScreen()">&#10697;</span>
        <span class="navIcon" title="Reload" onclick="window.location.reload()">&#8635;</span>
        <span class="navIcon" title="Favourite">&#9825;</span>
        <span class="navIcon" title="Close" onclick="window.location.href='{{ route('dashboard') }}'">&#10005;</span>
      </div>
    </div>
  </div>

  <!-- SIDE NAV (1XBET STYLE) -->
  <div class="sidenav">
    <button class="icon-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="Slots Lobby">
      <i class="fas fa-gamepad"></i>
    </button>
    <button class="icon-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="History">
      <i class="fas fa-history"></i>
    </button>
    <button class="icon-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="Transfer">
      <i class="fas fa-paper-plane"></i>
    </button>
    <button class="icon-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="VIP Levels">
      <i class="fas fa-trophy"></i>
    </button>
    <button class="icon-btn active" title="Active Game">
      <i class="fas fa-play-circle"></i>
    </button>
  </div>

  <div id="gameWrapper">
    <div class="main-layout-container">
      
      <!-- LEFT PANEL: LOGO & MODE TOGGLE -->
      <div class="left-toggle-panel">
        <div class="game-header-info">
          <div class="logoOrb">E</div>
          <span class="logoName">Elves' Kingdom</span>
        </div>
        <div class="rmToggle" id="rmToggle">
          <div class="togSwitch" id="modeSwitch">
            <div class="togDot"></div>
          </div>
          <span>PLAY FOR REAL MONEY</span>
        </div>
      </div>

      <!-- CENTER PANEL: THE SLOT MACHINE CABINET -->
      <div class="game-content-panel">
        <main class="cabinet">

          <header class="marquee">
            <svg class="marquee-glow" viewBox="0 0 600 90" preserveAspectRatio="none">
              <defs>
                <linearGradient id="titleGrad" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stop-color="#ffd76a"/>
                  <stop offset="50%" stop-color="#fff3cf"/>
                  <stop offset="100%" stop-color="#ffd76a"/>
                </linearGradient>
              </defs>
              <text x="300" y="58" text-anchor="middle" class="marquee-text" fill="url(#titleGrad)">MYSTIC KINGDOM</text>
            </svg>
            <div class="marquee-sub">Realm of Runes &amp; Gems</div>
          </header>

          <div class="frame">
            <div class="frame-corner tl"></div>
            <div class="frame-corner tr"></div>
            <div class="frame-corner bl"></div>
            <div class="frame-corner br"></div>

            <div class="payline-pips left">
              <span data-line="4">4</span>
              <span data-line="2">2</span>
              <span data-line="8">8</span>
              <span data-line="6">6</span>
              <span data-line="1">1</span>
              <span data-line="7">7</span>
              <span data-line="9">9</span>
              <span data-line="3">3</span>
              <span data-line="5">5</span>
              <span data-line="10">10</span>
            </div>
            <div class="payline-pips right">
              <span data-line="4">4</span>
              <span data-line="2">2</span>
              <span data-line="8">8</span>
              <span data-line="6">6</span>
              <span data-line="1">1</span>
              <span data-line="7">7</span>
              <span data-line="9">9</span>
              <span data-line="3">3</span>
              <span data-line="5">5</span>
              <span data-line="10">10</span>
            </div>

            <div class="reel-window" id="reelWindow">
              <canvas id="reelCanvas"></canvas>
              <canvas id="fxCanvas"></canvas>
              <div class="win-banner" id="winBanner">
                <span class="win-line-label" id="winLineLabel"></span>
                <span class="win-amount-label" id="winAmountLabel"></span>
              </div>
            </div>
          </div>

          <section class="control-deck">
            <div class="readout">
              <div class="readout-box">
                <label id="creditLabel">fun credit</label>
                <span id="creditDisplay">1000</span>
              </div>
            </div>

            <div class="readout small">
              <button class="stepper" id="linesMinus">–</button>
              <div class="readout-box">
                <label>lines</label>
                <span id="linesDisplay">10</span>
              </div>
              <button class="stepper" id="linesPlus">+</button>
            </div>

            <div class="readout small">
              <button class="stepper" id="betMinus">–</button>
              <div class="readout-box">
                <label>line bet</label>
                <span id="betDisplay">1</span>
              </div>
              <button class="stepper" id="betPlus">+</button>
            </div>

            <div class="readout win-readout">
              <div class="readout-box">
                <label>win</label>
                <span id="winDisplay">0</span>
              </div>
            </div>

            <div class="readout">
              <div class="readout-box">
                <label>total bet</label>
                <span id="totalBetDisplay">10</span>
              </div>
            </div>

            <button class="spin-btn" id="spinBtn">
              <svg viewBox="0 0 64 64" class="spin-icon">
                <path d="M32 6 A26 26 0 1 1 8 20" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
                <path d="M8 8 L8 22 L22 22 Z" fill="currentColor"/>
              </svg>
              <span>SPIN</span>
            </button>

            <button class="max-bet-btn" id="maxBtn">MAX BET</button>
            <button class="auto-btn" id="autoBtn">AUTO</button>
          </section>

          <footer class="cabinet-footer">
            <span id="demoFooterLabel">1 credit = 1 fun coin · Demo play only, no real money</span>
          </footer>

        </main>
      </div>

    </div>
  </div>

  <!-- BOTTOM BAR (1XBET STYLE) -->
  <div class="bottombar">
    <div class="left-tabs">
      <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-history" style="margin-right:4px;"></i> Recent Games</div>
      <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-heart" style="margin-right:4px;"></i> Favorites</div>
    </div>
    <input type="text" class="search-box" placeholder="Search..." disabled>
  </div>

<script>
/* ===== DATABASE BALANCE INTEGRATION ===== */
const userCurrency = "{{ auth()->user()->currency }}";
const currencySymbolMap = {
  'EUR': '€',
  'USD': '$',
  'BDT': '৳',
  'GBP': '£',
  'INR': '₹'
};
const currencySymbol = currencySymbolMap[userCurrency] || (userCurrency + ' ');

let realBalance = parseFloat("{{ auth()->user()->balance }}");
let isDemoMode = new URLSearchParams(window.location.search).get('demo') === '1' || (realBalance < 1.0);
let demoBalance = 1000.00;
let balance = isDemoMode ? demoBalance : realBalance;

function syncBalance(newBalance) {
  fetch('{{ route("dashboard.update-balance") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    },
    body: JSON.stringify({ balance: newBalance.toFixed(2) })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      console.log('Balance synced to DB successfully:', newBalance);
    }
  })
  .catch(err => console.error('Error syncing balance:', err));
}

function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(err => {});
  } else {
    document.exitFullscreen();
  }
}

/* ===== ELVEN WEB AUDIO SYNTHESIZER ===== */
class ElvenMusicSynth {
  constructor(ctx) {
    this.ctx = ctx;
    this.isPlaying = false;
    this.noiseBuffer = this.createNoiseBuffer();
    this.nextNoteTime = 0.0;
    this.currentStep = 0;
    this.timerId = null;
    this.tempo = 90; // Slow magical tempo
    
    this.masterGain = this.ctx.createGain();
    this.masterGain.gain.value = 0.4; // default volume
    this.masterGain.connect(this.ctx.destination);
    
    this.droneOsc = null;
    this.droneFilter = null;
    this.droneGain = null;
  }
  
  createNoiseBuffer() {
    const sampleRate = this.ctx.sampleRate;
    const bufferSize = sampleRate * 0.15;
    const buffer = this.ctx.createBuffer(1, bufferSize, sampleRate);
    const data = buffer.getChannelData(0);
    for (let i = 0; i < bufferSize; i++) {
      data[i] = Math.random() * 2 - 1;
    }
    return buffer;
  }
  
  start() {
    if (this.isPlaying) return;
    this.isPlaying = true;
    this.nextNoteTime = this.ctx.currentTime + 0.05;
    this.currentStep = 0;
    this.startDrone();
    this.scheduler();
  }
  
  stop() {
    this.isPlaying = false;
    if (this.timerId) {
      clearTimeout(this.timerId);
      this.timerId = null;
    }
    this.stopDrone();
  }
  
  duck() {
    this.masterGain.gain.linearRampToValueAtTime(0.12, this.ctx.currentTime + 0.15);
  }
  
  unduck() {
    this.masterGain.gain.linearRampToValueAtTime(0.4, this.ctx.currentTime + 0.6);
  }
  
  startDrone() {
    this.stopDrone();
    try {
      this.droneOsc = this.ctx.createOscillator();
      this.droneFilter = this.ctx.createBiquadFilter();
      this.droneGain = this.ctx.createGain();
      
      this.droneOsc.type = 'sine';
      this.droneOsc.frequency.setValueAtTime(196.00, this.ctx.currentTime); // G3 drone
      
      this.droneFilter.type = 'lowpass';
      this.droneFilter.frequency.setValueAtTime(400, this.ctx.currentTime);
      
      this.droneGain.gain.setValueAtTime(0.04, this.ctx.currentTime);
      
      this.droneOsc.connect(this.droneFilter);
      this.droneFilter.connect(this.droneGain);
      this.droneGain.connect(this.masterGain);
      
      this.droneOsc.start(0);
      
      const lfo = this.ctx.createOscillator();
      const lfoGain = this.ctx.createGain();
      lfo.frequency.value = 0.15;
      lfoGain.gain.value = 60;
      lfo.connect(lfoGain);
      lfoGain.connect(this.droneFilter.frequency);
      lfo.start(0);
      
      this.droneLfo = lfo;
    } catch(e) {}
  }
  
  stopDrone() {
    try {
      if (this.droneOsc) {
        this.droneOsc.stop();
        this.droneOsc = null;
      }
      if (this.droneLfo) {
        this.droneLfo.stop();
        this.droneLfo = null;
      }
    } catch(e) {}
  }
  
  scheduler() {
    if (!this.isPlaying) return;
    
    const lookahead = 0.1;
    while (this.nextNoteTime < this.ctx.currentTime + lookahead) {
      this.scheduleNote(this.currentStep, this.nextNoteTime);
      this.advanceNote();
    }
    this.timerId = setTimeout(() => this.scheduler(), 30);
  }
  
  advanceNote() {
    const secondsPerBeat = 60.0 / this.tempo;
    const sixteenthNoteDuration = 0.25 * secondsPerBeat;
    this.nextNoteTime += sixteenthNoteDuration;
    this.currentStep = (this.currentStep + 1) % 32;
  }
  
  scheduleNote(step, time) {
    if (step % 8 === 0) {
      this.playForestChime(2000, time, 0.015);
    } else if (step % 8 === 4) {
      this.playForestChime(1600, time, 0.008);
    }
    
    const melodyMap = {
      0: 261.63,   // C4
      2: 293.66,   // D4
      4: 329.63,   // E4
      6: 392.00,   // G4
      8: 440.00,   // A4
      10: 523.25,  // C5
      12: 587.33,  // D5
      14: 659.25,  // E5
      16: 783.99,  // G5
      18: 659.25,  // E5
      20: 587.33,  // D5
      22: 523.25,  // C5
      24: 440.00,  // A4
      26: 392.00,  // G4
      28: 329.63,  // E4
      30: 293.66   // D4
    };
    
    const freq = melodyMap[step];
    if (freq && (step % 2 === 0)) {
      this.playHarp(freq, time);
    }
  }
  
  playForestChime(freq, time, vol) {
    try {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, time);
      gain.gain.setValueAtTime(vol, time);
      gain.gain.exponentialRampToValueAtTime(0.0001, time + 0.08);
      osc.connect(gain).connect(this.masterGain);
      osc.start(time);
      osc.stop(time + 0.09);
    } catch(e) {}
  }
  
  playHarp(freq, time) {
    try {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, time);
      
      gain.gain.setValueAtTime(0.06, time);
      gain.gain.exponentialRampToValueAtTime(0.0001, time + 0.4);
      
      osc.connect(gain).connect(this.masterGain);
      osc.start(time);
      osc.stop(time + 0.42);
    } catch(e) {}
  }
}

class SlotSoundEngine {
  constructor() {
    this.ctx = null;
    this.muted = false;
    this.spinInterval = null;
    this.musicSynth = null;
  }
  
  ensureAudio() {
    if (!this.ctx) {
      try {
        this.ctx = new (window.AudioContext || window.webkitAudioContext)();
        this.musicSynth = new ElvenMusicSynth(this.ctx);
        if (!this.muted) {
          this.musicSynth.start();
        }
      } catch (e) {
        console.error("Web Audio API not supported", e);
      }
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
      if (!this.muted && this.musicSynth) {
        this.musicSynth.start();
      }
    }
  }
  
  beep(freq, dur, type, vol, delay = 0) {
    this.ensureAudio();
    if (this.muted || !this.ctx) return;
    
    setTimeout(() => {
      try {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
        gain.gain.setValueAtTime(vol, this.ctx.currentTime);
        
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        
        osc.start();
        gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + dur);
        osc.stop(this.ctx.currentTime + dur);
      } catch (e) {}
    }, delay);
  }
  
  playSpin() {
    this.ensureAudio();
    if (this.musicSynth) this.musicSynth.duck();
    if (this.spinInterval) clearInterval(this.spinInterval);
    
    let tickCount = 0;
    this.spinInterval = setInterval(() => {
      const freq = tickCount % 3 === 0 ? 140 : 100;
      this.beep(freq, 0.08, 'triangle', 0.12);
      tickCount++;
    }, 75);
  }
  
  stopSpin() {
    if (this.spinInterval) {
      clearInterval(this.spinInterval);
      this.spinInterval = null;
    }
  }
  
  playReelStop(reelIndex) {
    this.beep(300 + reelIndex * 50, 0.15, 'sine', 0.15);
    this.beep(90, 0.12, 'triangle', 0.25);
  }
  
  playWin() {
    this.stopSpin();
    const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51, 1567.98];
    notes.forEach((freq, idx) => {
      this.beep(freq, 0.4, 'sine', 0.1, idx * 80);
    });
  }
  
  playCoinRollup() {
    this.beep(1200 + Math.random() * 300, 0.05, 'sine', 0.05);
  }
}

const soundEngine = new SlotSoundEngine();

function toggleMute() {
  soundEngine.muted = !soundEngine.muted;
  const toggle = document.getElementById('soundToggle');
  if (soundEngine.muted) {
    toggle.innerHTML = '&#128263;';
    if (soundEngine.musicSynth) {
      soundEngine.musicSynth.stop();
    }
  } else {
    toggle.innerHTML = '&#128266;';
    soundEngine.ensureAudio();
    if (soundEngine.musicSynth) {
      soundEngine.musicSynth.start();
    }
  }
}

// Ensure audio context starts on first page interaction
document.addEventListener('click', () => {
  soundEngine.ensureAudio();
}, { once: true });

/* ===== DYNAMIC IMAGE CACHE ===== */
const symbolImageMap = {
  ten: '1.png',
  jack: '6.png',
  queen: '3.png',
  king: '4.png',
  ace: '9.png',
  rune: '5.png',
  ring: '8.png',
  crown: '7.png',
  egg: '2.png',
  staff: '10.png',
  tower: '10.png'
};

const imgCache = {};
Object.keys(symbolImageMap).forEach(key => {
  const img = new Image();
  img.src = `{{ asset('assets/image/ElvesKingdom') }}/${symbolImageMap[key]}`;
  imgCache[key] = img;
});

/* ===== symbols.js ===== */
const SYMBOLS = (() => {
  function roundRect(ctx, x, y, w, h, r){
    ctx.beginPath();
    ctx.moveTo(x+r, y);
    ctx.arcTo(x+w, y,   x+w, y+h, r);
    ctx.arcTo(x+w, y+h, x,   y+h, r);
    ctx.arcTo(x,   y+h, x,   y,   r);
    ctx.arcTo(x,   y,   x+w, y,   r);
    ctx.closePath();
  }

  function cardFrame(ctx, s, grad){
    const pad = s*0.08;
    roundRect(ctx, pad, pad, s-pad*2, s-pad*2, s*0.08);
    ctx.fillStyle = grad;
    ctx.fill();
    ctx.lineWidth = s*0.035;
    ctx.strokeStyle = 'rgba(255,233,176,0.55)';
    ctx.stroke();
  }

  function glowText(ctx, text, x, y, size, fillStyle, glow){
    ctx.save();
    ctx.font = `bold ${size}px Georgia, serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    if (glow){
      ctx.shadowColor = glow;
      ctx.shadowBlur = size*0.35;
    }
    ctx.fillStyle = fillStyle;
    ctx.fillText(text, x, y);
    ctx.restore();
  }

  function diamondPip(ctx, cx, cy, r, color){
    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(Math.PI/4);
    ctx.fillStyle = color;
    ctx.fillRect(-r/2, -r/2, r, r);
    ctx.restore();
  }

  function makeCardSymbol(letter, mainColor, pipColor, grad1, grad2){
    return (ctx, s) => {
      const grad = ctx.createLinearGradient(0,0,0,s);
      grad.addColorStop(0, grad1);
      grad.addColorStop(1, grad2);
      cardFrame(ctx, s, grad);
      glowText(ctx, letter, s*0.5, s*0.46, s*0.46, mainColor, mainColor);
      diamondPip(ctx, s*0.5, s*0.78, s*0.09, pipColor);
    };
  }

  const TEN_FALLBACK  = makeCardSymbol('10', '#7fd4ff', '#ffd76a', '#0d2a3d', '#06141d');
  const JACK_FALLBACK = makeCardSymbol('J',  '#ffcf6e', '#7fd4ff', '#3d2a0d', '#1d1406');
  const QUEEN_FALLBACK= makeCardSymbol('Q',  '#7fffb0', '#ffd76a', '#0d3d22', '#061d10');
  const KING_FALLBACK = makeCardSymbol('K',  '#9ad1ff', '#ffd76a', '#0d2540', '#061320');
  const ACE_FALLBACK  = makeCardSymbol('A',  '#ff8f7f', '#ffe9b0', '#3d0d10', '#1d0606');

  function runeStone(ctx, s){
    const grad = ctx.createRadialGradient(s*0.5,s*0.4,s*0.05, s*0.5,s*0.5,s*0.55);
    grad.addColorStop(0, '#2fffb0');
    grad.addColorStop(0.5, '#0f5c3f');
    grad.addColorStop(1, '#06140d');
    cardFrame(ctx, s, grad);
    ctx.save();
    ctx.translate(s*0.5, s*0.52);
    ctx.shadowColor = '#7fffc8';
    ctx.shadowBlur = s*0.25;
    ctx.strokeStyle = '#eafff2';
    ctx.lineWidth = s*0.045;
    ctx.beginPath();
    ctx.moveTo(0,-s*0.26); ctx.lineTo(0,s*0.26);
    ctx.moveTo(-s*0.18,-s*0.16); ctx.lineTo(s*0.18,s*0.16);
    ctx.moveTo(-s*0.18,s*0.0); ctx.lineTo(0,-s*0.16);
    ctx.stroke();
    ctx.restore();
  }

  function amethystRing(ctx, s){
    const grad = ctx.createLinearGradient(0,0,0,s);
    grad.addColorStop(0,'#2a1740'); grad.addColorStop(1,'#0c0616');
    cardFrame(ctx, s, grad);
    const cx=s*0.5, cy=s*0.55, rOuter=s*0.22, rInner=s*0.13;
    const ring = ctx.createRadialGradient(cx,cy,rInner*0.4, cx,cy,rOuter);
    ring.addColorStop(0,'#e8c45a'); ring.addColorStop(1,'#8a5e1f');
    ctx.save();
    ctx.shadowColor='#ffd76a'; ctx.shadowBlur=s*0.12;
    ctx.beginPath();
    ctx.arc(cx,cy,rOuter,0,Math.PI*2);
    ctx.arc(cx,cy,rInner,0,Math.PI*2,true);
    ctx.fillStyle=ring; ctx.fill('evenodd');
    ctx.restore();
    ctx.save();
    ctx.translate(cx, cy-rOuter*0.95);
    ctx.shadowColor='#c08bff'; ctx.shadowBlur=s*0.22;
    const gemGrad = ctx.createLinearGradient(0,-s*0.1,0,s*0.1);
    gemGrad.addColorStop(0,'#e3c8ff'); gemGrad.addColorStop(1,'#8b5fbf');
    ctx.fillStyle=gemGrad;
    ctx.beginPath();
    ctx.moveTo(0,-s*0.12);
    ctx.lineTo(s*0.1,0);
    ctx.lineTo(0,s*0.12);
    ctx.lineTo(-s*0.1,0);
    ctx.closePath(); ctx.fill();
    ctx.restore();
  }

  function phoenixCrown(ctx, s){
    const grad = ctx.createRadialGradient(s*0.5,s*0.45,s*0.05, s*0.5,s*0.5,s*0.6);
    grad.addColorStop(0,'#ffb066'); grad.addColorStop(0.55,'#7a2a10'); grad.addColorStop(1,'#1d0a06');
    cardFrame(ctx, s, grad);
    ctx.save();
    ctx.translate(s*0.5, s*0.56);
    ctx.shadowColor = '#ff7a3d';
    ctx.shadowBlur = s*0.22;
    const cGrad = ctx.createLinearGradient(0,-s*0.22,0,s*0.16);
    cGrad.addColorStop(0,'#ffe9b0'); cGrad.addColorStop(1,'#d9a443');
    ctx.fillStyle = cGrad;
    ctx.beginPath();
    ctx.moveTo(-s*0.26, s*0.16);
    ctx.lineTo(-s*0.26, s*0.02);
    ctx.lineTo(-s*0.14,-s*0.18);
    ctx.lineTo(0, -s*0.02);
    ctx.lineTo(s*0.14,-s*0.18);
    ctx.lineTo(s*0.26, s*0.02);
    ctx.lineTo(s*0.26, s*0.16);
    ctx.closePath();
    ctx.fill();
    ctx.strokeStyle='rgba(255,255,255,.5)';
    ctx.lineWidth=s*0.02;
    ctx.stroke();
    ctx.fillStyle='#ff5a3d';
    ctx.beginPath(); ctx.arc(0,-s*0.02, s*0.045,0,Math.PI*2); ctx.fill();
    ctx.restore();
  }

  function dragonEgg(ctx, s){
    const grad = ctx.createLinearGradient(0,0,0,s);
    grad.addColorStop(0,'#143d1f'); grad.addColorStop(1,'#061309');
    cardFrame(ctx, s, grad);
    ctx.save();
    ctx.translate(s*0.5, s*0.55);
    ctx.shadowColor = '#7fffb0';
    ctx.shadowBlur = s*0.3;
    const eggGrad = ctx.createRadialGradient(-s*0.05,-s*0.12,s*0.02, 0,0,s*0.3);
    eggGrad.addColorStop(0,'#dfffe9');
    eggGrad.addColorStop(0.45,'#5be88a');
    eggGrad.addColorStop(1,'#0b3d22');
    ctx.fillStyle = eggGrad;
    ctx.beginPath();
    ctx.ellipse(0,0, s*0.22, s*0.28, 0, 0, Math.PI*2);
    ctx.fill();
    ctx.strokeStyle='rgba(10,40,20,.55)';
    ctx.lineWidth=s*0.012;
    ctx.beginPath();
    ctx.moveTo(-s*0.06,-s*0.2); ctx.lineTo(s*0.04,-s*0.04); ctx.lineTo(-s*0.02,s*0.1); ctx.lineTo(s*0.08,s*0.22);
    ctx.stroke();
    ctx.restore();
  }

  function wizardStaff(ctx, s){
    const grad = ctx.createRadialGradient(s*0.5,s*0.5,s*0.04, s*0.5,s*0.5,s*0.6);
    grad.addColorStop(0,'#dfffd0'); grad.addColorStop(0.4,'#3fae5e'); grad.addColorStop(1,'#06140a');
    cardFrame(ctx, s, grad);
    ctx.save();
    ctx.translate(s*0.5, s*0.5);
    ctx.shadowColor='#bfffcf';
    ctx.shadowBlur = s*0.35;
    ctx.strokeStyle='#fff7df';
    ctx.lineWidth = s*0.05;
    ctx.lineCap='round';
    ctx.beginPath();
    ctx.moveTo(0, s*0.28);
    ctx.lineTo(0, -s*0.2);
    ctx.stroke();
    ctx.fillStyle='#fff7df';
    const spikes=5, outerR=s*0.13, innerR=s*0.055;
    ctx.beginPath();
    for(let i=0;i<spikes*2;i++){
      const r = i%2===0 ? outerR : innerR;
      const a = (Math.PI/spikes)*i - Math.PI/2;
      const px = Math.cos(a)*r, py = -s*0.24 + Math.sin(a)*r;
      i===0 ? ctx.moveTo(px,py) : ctx.lineTo(px,py);
    }
    ctx.closePath();
    ctx.fill();
    ctx.restore();
  }

  function crystalTower(ctx, s){
    const grad = ctx.createLinearGradient(0,0,0,s);
    grad.addColorStop(0,'#241043'); grad.addColorStop(1,'#0a0414');
    cardFrame(ctx, s, grad);
    ctx.save();
    ctx.translate(s*0.5, s*0.55);
    ctx.shadowColor='#c08bff';
    ctx.shadowBlur=s*0.3;
    const tGrad = ctx.createLinearGradient(0,-s*0.32,0,s*0.2);
    tGrad.addColorStop(0,'#f0e0ff'); tGrad.addColorStop(1,'#8b5fbf');
    ctx.fillStyle=tGrad;
    ctx.beginPath();
    ctx.moveTo(0,-s*0.32);
    ctx.lineTo(s*0.16,-s*0.02);
    ctx.lineTo(s*0.1,s*0.2);
    ctx.lineTo(-s*0.1,s*0.2);
    ctx.lineTo(-s*0.16,-s*0.02);
    ctx.closePath();
    ctx.fill();
    ctx.strokeStyle='rgba(255,255,255,.5)';
    ctx.lineWidth=s*0.015;
    ctx.stroke();
    ctx.restore();
  }

  function drawSymbolImage(ctx, id, s, fallbackDraw) {
    const img = imgCache[id];
    if (img && img.complete && img.naturalWidth > 0) {
      ctx.save();
      const pad = s * 0.08;
      const r = s * 0.08;

      // Card frame backdrop
      const grad = ctx.createLinearGradient(0, 0, 0, s);
      grad.addColorStop(0, '#1c1305');
      grad.addColorStop(1, '#0a0414');

      ctx.beginPath();
      ctx.moveTo(pad + r, pad);
      ctx.arcTo(s - pad, pad, s - pad, s - pad, r);
      ctx.arcTo(s - pad, s - pad, pad, s - pad, r);
      ctx.arcTo(pad, s - pad, pad, pad, r);
      ctx.arcTo(pad, pad, s - pad, pad, r);
      ctx.closePath();
      ctx.fillStyle = grad;
      ctx.fill();
      ctx.lineWidth = s * 0.035;
      ctx.strokeStyle = 'rgba(255,233,176,0.55)';
      ctx.stroke();

      // Clip image inside card frame
      ctx.beginPath();
      ctx.moveTo(pad + r, pad);
      ctx.arcTo(s - pad, pad, s - pad, s - pad, r);
      ctx.arcTo(s - pad, s - pad, pad, s - pad, r);
      ctx.arcTo(pad, s - pad, pad, pad, r);
      ctx.arcTo(pad, pad, s - pad, pad, r);
      ctx.closePath();
      ctx.clip();

      ctx.drawImage(img, pad, pad, s - pad * 2, s - pad * 2);
      ctx.restore();
    } else {
      fallbackDraw(ctx, s);
    }
  }

  const TEN   = (ctx, s) => drawSymbolImage(ctx, 'ten', s, TEN_FALLBACK);
  const JACK  = (ctx, s) => drawSymbolImage(ctx, 'jack', s, JACK_FALLBACK);
  const QUEEN = (ctx, s) => drawSymbolImage(ctx, 'queen', s, QUEEN_FALLBACK);
  const KING  = (ctx, s) => drawSymbolImage(ctx, 'king', s, KING_FALLBACK);
  const ACE   = (ctx, s) => drawSymbolImage(ctx, 'ace', s, ACE_FALLBACK);
  const RUNE  = (ctx, s) => drawSymbolImage(ctx, 'rune', s, runeStone);
  const RING  = (ctx, s) => drawSymbolImage(ctx, 'ring', s, amethystRing);
  const CROWN = (ctx, s) => drawSymbolImage(ctx, 'crown', s, phoenixCrown);
  const EGG   = (ctx, s) => drawSymbolImage(ctx, 'egg', s, dragonEgg);
  const STAFF = (ctx, s) => drawSymbolImage(ctx, 'staff', s, wizardStaff);
  const TOWER = (ctx, s) => drawSymbolImage(ctx, 'tower', s, crystalTower);

  return [
    { id:'ten',     draw:TEN,           value:1,  weight:22 },
    { id:'jack',    draw:JACK,          value:1,  weight:20 },
    { id:'queen',   draw:QUEEN,         value:2,  weight:18 },
    { id:'king',    draw:KING,          value:3,  weight:16 },
    { id:'ace',     draw:ACE,           value:4,  weight:14 },
    { id:'rune',    draw:RUNE,          value:6,  weight:9  },
    { id:'ring',    draw:RING,          value:8,  weight:7  },
    { id:'crown',   draw:CROWN,         value:12, weight:5  },
    { id:'egg',     draw:EGG,           value:20, weight:3,  premium:true },
    { id:'staff',   draw:STAFF,         value:0,  weight:3,  wild:true },
    { id:'tower',   draw:TOWER,         value:0,  weight:2,  scatter:true },
  ];
})();

/* ===== engine.js ===== */
const ROWS = 3;
const REELS = 5;

const PAYLINES = [
  [1,1,1,1,1],                // 1
  [0,0,0,0,0],                // 2
  [2,2,2,2,2],                // 3
  [0,1,2,1,0],                // 4
  [2,1,0,1,2],                // 5
  [0,0,1,0,0],                // 6
  [2,2,1,2,2],                // 7
  [1,0,0,0,1],                // 8
  [1,2,2,2,1],                // 9
  [0,1,1,1,0],                // 10
];

const SYMBOL_POOL = (() => {
  const pool = [];
  SYMBOLS.forEach(sym => {
    for (let i=0;i<sym.weight;i++) pool.push(sym);
  });
  return pool;
})();

function randomSymbol(){
  return SYMBOL_POOL[Math.floor(Math.random()*SYMBOL_POOL.length)];
}

function spinGrid(){
  const grid = [];
  for (let r=0;r<REELS;r++){
    const col = [];
    for (let row=0;row<ROWS;row++){
      col.push(randomSymbol());
    }
    grid.push(col);
  }
  return grid;
}

function evaluateWins(grid, activeLines, betPerLine){
  const wins = [];
  let totalWin = 0;

  for (let li=0; li<activeLines; li++){
    const line = PAYLINES[li];
    const firstSym = grid[0][line[0]];
    if (firstSym.scatter) continue;

    let matchSym = firstSym.wild ? null : firstSym;
    let count = 1;

    for (let reel=1; reel<REELS; reel++){
      const sym = grid[reel][line[reel]];
      if (sym.scatter) break;

      if (matchSym === null && !sym.wild){
        matchSym = sym;
      }
      const isMatch = sym.wild || (matchSym && sym.id === matchSym.id);
      if (isMatch){
        count++;
      } else {
        break;
      }
    }

    if (matchSym && count >= 3){
      const amount = matchSym.value * betPerLine * payoutMultiplier(count);
      if (amount > 0){
        const cells = [];
        for (let reel=0; reel<count; reel++) cells.push([reel, line[reel]]);
        wins.push({ lineIndex: li, symbolId: matchSym.id, count, amount, cells });
        totalWin += amount;
      }
    }
  }

  let scatterCount = 0;
  const scatterCells = [];
  for (let reel=0; reel<REELS; reel++){
    for (let row=0; row<ROWS; row++){
      if (grid[reel][row].scatter){
        scatterCount++;
        scatterCells.push([reel,row]);
      }
    }
  }
  if (scatterCount >= 3){
    const amount = scatterCount * betPerLine * 5;
    wins.push({ lineIndex:-1, symbolId:'tower', count:scatterCount, amount, cells:scatterCells, isScatter:true });
    totalWin += amount;
  }

  return { totalWin, wins };
}

function payoutMultiplier(count){
  switch(count){
    case 3: return 1;
    case 4: return 3;
    case 5: return 10;
    default: return 0;
  }
}

/* ===== render.js ===== */
class ReelRenderer{
  constructor(canvas, fxCanvas){
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.fxCanvas = fxCanvas;
    this.fxCtx = fxCanvas.getContext('2d');

    this.reels = [];
    this.grid = spinGrid();
    this.particles = [];
    this.activeLineHighlight = null;
    this.dpr = Math.min(window.devicePixelRatio || 1, 2);

    this._resize();
    window.addEventListener('resize', () => this._resize());

    for (let i=0;i<REELS;i++){
      this.reels.push({
        offset: 0,
        velocity: 0,
        spinning: false,
        symbols: [randomSymbol(), this.grid[i][0], this.grid[i][1], this.grid[i][2], randomSymbol()],
        stopTime: 0,
        targetReached: false,
      });
    }

    this._lastT = performance.now();
    requestAnimationFrame(this._loop.bind(this));
  }

  _resize(){
    const rect = this.canvas.parentElement.getBoundingClientRect();
    [this.canvas, this.fxCanvas].forEach(c => {
      c.width = rect.width * this.dpr;
      c.height = rect.height * this.dpr;
    });
    this.w = rect.width;
    this.h = rect.height;
    this.cellW = this.w / REELS;
    this.cellH = this.h / ROWS;
  }

  startSpin(finalGrid){
    this.grid = finalGrid;
    this.activeLineHighlight = null;
    this.particles = [];

    this.reels.forEach((reel, i) => {
      reel.spinning = true;
      reel.targetReached = false;
      reel.offset = 0;
      reel.velocity = 0;
      reel.spinDuration = 900 + i*220 + Math.random()*120;
      reel.elapsed = 0;
      reel.finalSymbols = [finalGrid[i][0], finalGrid[i][1], finalGrid[i][2]];
      const stripLen = 18;
      reel.strip = [];
      for (let s=0;s<stripLen;s++) reel.strip.push(randomSymbol());
      reel.strip.push(...reel.finalSymbols);
    });

    return new Promise(resolve => { this._onAllStopped = resolve; });
  }

  _loop(now){
    const dt = Math.min(now - this._lastT, 48);
    this._lastT = now;

    let allStopped = true;
    this.reels.forEach((reel, i) => {
      if (reel.spinning){
        allStopped = false;
        reel.elapsed += dt;
        const t = Math.min(reel.elapsed / reel.spinDuration, 1);
        const eased = easeOutBack(t);
        const totalScroll = (reel.strip.length - ROWS) * this.cellH;
        reel.offset = eased * totalScroll;
        if (t >= 1){
          reel.spinning = false;
          reel.offset = totalScroll;
          reel.bounceT = 0;
          reel.bouncing = true;
          if (typeof soundEngine !== 'undefined') {
            soundEngine.playReelStop(i);
            if (i === REELS - 1) {
              soundEngine.stopSpin();
            }
          }
        }
      } else if (reel.bouncing){
        reel.bounceT += dt;
        const bt = Math.min(reel.bounceT/220, 1);
        reel.bounceOffset = Math.sin(bt*Math.PI) * 10 * (1-bt);
        if (bt>=1){ reel.bouncing=false; reel.bounceOffset=0; }
      }
    });

    this._drawReels();
    this._drawFx(dt);

    if (allStopped && this._onAllStopped){
      const cb = this._onAllStopped;
      this._onAllStopped = null;
      cb();
    }

    requestAnimationFrame(this._loop.bind(this));
  }

  _drawReels(){
    const ctx = this.ctx;
    ctx.save();
    ctx.scale(this.dpr, this.dpr);
    ctx.clearRect(0,0,this.w,this.h);

    for (let i=0;i<REELS;i++){
      const x = i*this.cellW;
      const grad = ctx.createLinearGradient(0,0,0,this.h);
      grad.addColorStop(0, i%2===0 ? 'rgba(15,40,28,0.0)' : 'rgba(0,0,0,0.10)');
      grad.addColorStop(1, 'rgba(0,0,0,0.0)');
      ctx.fillStyle = grad;
      ctx.fillRect(x,0,this.cellW,this.h);
    }

    this.reels.forEach((reel, i) => {
      const x = i*this.cellW;
      ctx.save();
      ctx.beginPath();
      ctx.rect(x, 0, this.cellW, this.h);
      ctx.clip();

      const bounce = reel.bounceOffset || 0;

      if (reel.spinning || reel.bouncing){
        const strip = reel.strip;
        const offset = reel.offset - bounce;
        const startIdx = Math.floor(offset / this.cellH);
        const subPixel = offset % this.cellH;

        for (let row=-1; row<=ROWS; row++){
          const idx = startIdx + row;
          if (idx < 0 || idx >= strip.length) continue;
          const sym = strip[idx];
          const y = row*this.cellH - subPixel;
          this._drawTile(ctx, sym, x, y, this.cellW, this.cellH, true);
        }
      } else {
        for (let row=0; row<ROWS; row++){
          const sym = this.grid[i][row];
          const y = row*this.cellH;
          this._drawTile(ctx, sym, x, y, this.cellW, this.cellH, false);
        }
      }
      ctx.restore();
    });

    ctx.strokeStyle = 'rgba(255,255,255,0.04)';
    ctx.lineWidth = 1;
    for (let i=1;i<REELS;i++){
      ctx.beginPath();
      ctx.moveTo(i*this.cellW,0); ctx.lineTo(i*this.cellW,this.h);
      ctx.stroke();
    }

    ctx.restore();
  }

  _drawTile(ctx, sym, x, y, w, h, isMoving){
    const pad = Math.min(w,h)*0.06;
    ctx.save();
    ctx.translate(x+pad/2, y+pad/2);
    const size = Math.min(w,h) - pad;
    const offX = (w-pad-size)/2;
    ctx.translate(offX, 0);

    if (isMoving){
      ctx.save();
      ctx.translate(size/2, size/2);
      ctx.scale(1, 0.97);
      ctx.translate(-size/2, -size/2);
      sym.draw(ctx, size);
      ctx.restore();
      const sheen = ctx.createLinearGradient(0,0,0,size);
      sheen.addColorStop(0,'rgba(255,255,255,0.0)');
      sheen.addColorStop(0.45,'rgba(255,255,255,0.05)');
      sheen.addColorStop(0.55,'rgba(255,255,255,0.05)');
      sheen.addColorStop(1,'rgba(255,255,255,0.0)');
      ctx.fillStyle = sheen;
      ctx.fillRect(0,0,size,size);
    } else {
      sym.draw(ctx, size);
      const topGloss = ctx.createLinearGradient(0,0,0,size*0.4);
      topGloss.addColorStop(0,'rgba(255,255,255,0.12)');
      topGloss.addColorStop(1,'rgba(255,255,255,0)');
      ctx.fillStyle = topGloss;
      ctx.fillRect(0,0,size,size*0.4);

      const botShadow = ctx.createLinearGradient(0,size*0.65,0,size);
      botShadow.addColorStop(0,'rgba(0,0,0,0)');
      botShadow.addColorStop(1,'rgba(0,0,0,0.18)');
      ctx.fillStyle = botShadow;
      ctx.fillRect(0,size*0.65,size,size*0.35);
    }

    ctx.restore();
  }

  highlightLine(lineIndex, cells){
    this.activeLineHighlight = { cells, pulse: 0 };
    cells.forEach(([reel,row]) => {
      const cx = reel*this.cellW + this.cellW/2;
      const cy = row*this.cellH + this.cellH/2;
      for (let p=0;p<6;p++){
        this.particles.push(makeParticle(cx,cy));
      }
    });
  }

  clearHighlight(){
    this.activeLineHighlight = null;
  }

  _drawFx(dt){
    const ctx = this.fxCtx;
    ctx.save();
    ctx.scale(this.dpr, this.dpr);
    ctx.clearRect(0,0,this.w,this.h);

    if (this.activeLineHighlight){
      this.activeLineHighlight.pulse += dt;
      const pulse = (Math.sin(this.activeLineHighlight.pulse/180)+1)/2;
      const cells = this.activeLineHighlight.cells;

      ctx.save();
      ctx.strokeStyle = `rgba(255,${210+pulse*30|0},120,${0.55+pulse*0.35})`;
      ctx.lineWidth = 4 + pulse*2;
      ctx.shadowColor = 'rgba(255,200,90,0.9)';
      ctx.shadowBlur = 14 + pulse*10;
      ctx.beginPath();
      cells.forEach(([reel,row], idx) => {
        const cx = reel*this.cellW + this.cellW/2;
        const cy = row*this.cellH + this.cellH/2;
        idx===0 ? ctx.moveTo(cx,cy) : ctx.lineTo(cx,cy);
      });
      ctx.stroke();
      ctx.restore();

      cells.forEach(([reel,row]) => {
        const x = reel*this.cellW, y = row*this.cellH;
        ctx.save();
        ctx.strokeStyle = `rgba(255,233,176,${0.7+pulse*0.3})`;
        ctx.lineWidth = 3;
        ctx.shadowColor = 'rgba(255,200,90,0.8)';
        ctx.shadowBlur = 10;
        const inset = 4;
        ctx.strokeRect(x+inset, y+inset, this.cellW-inset*2, this.cellH-inset*2);
        ctx.restore();
      });
    }

    this.particles.forEach(p => p.update(dt));
    this.particles = this.particles.filter(p => p.life > 0);
    this.particles.forEach(p => p.draw(ctx));

    ctx.restore();
  }
}

function easeOutBack(t){
  const c1 = 1.4, c3 = c1+1;
  return 1 + c3*Math.pow(t-1,3) + c1*Math.pow(t-1,2);
}

function makeParticle(x,y){
  const angle = Math.random()*Math.PI*2;
  const speed = 0.06 + Math.random()*0.12;
  return {
    x, y,
    vx: Math.cos(angle)*speed,
    vy: Math.sin(angle)*speed - 0.05,
    life: 700 + Math.random()*400,
    maxLife: 700,
    size: 2 + Math.random()*3,
    hue: 40 + Math.random()*20,
    update(dt){
      this.x += this.vx*dt;
      this.y += this.vy*dt;
      this.vy += 0.0002*dt;
      this.life -= dt;
    },
    draw(ctx){
      const a = Math.max(this.life/this.maxLife, 0);
      ctx.save();
      ctx.globalAlpha = a;
      ctx.fillStyle = `hsl(${this.hue},90%,70%)`;
      ctx.shadowColor = `hsl(${this.hue},90%,70%)`;
      ctx.shadowBlur = 6;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI*2);
      ctx.fill();
      ctx.restore();
    }
  };
}

/* ===== main.js ===== */
(() => {
  const $ = sel => document.querySelector(sel);

  const els = {
    reelCanvas: $('#reelCanvas'),
    fxCanvas: $('#fxCanvas'),
    credit: $('#creditDisplay'),
    creditLabel: $('#creditLabel'),
    lines: $('#linesDisplay'),
    bet: $('#betDisplay'),
    totalBet: $('#totalBetDisplay'),
    win: $('#winDisplay'),
    spinBtn: $('#spinBtn'),
    maxBtn: $('#maxBtn'),
    autoBtn: $('#autoBtn'),
    linesMinus: $('#linesMinus'),
    linesPlus: $('#linesPlus'),
    betMinus: $('#betMinus'),
    betPlus: $('#betPlus'),
    winBanner: $('#winBanner'),
    winLineLabel: $('#winLineLabel'),
    winAmountLabel: $('#winAmountLabel'),
    pips: document.querySelectorAll('.payline-pips span'),
    demoFooterLabel: $('#demoFooterLabel'),
  };

  const state = {
    credit: balance,
    lines: 10,
    bet: 1,
    spinning: false,
    auto: false,
  };

  const BET_STEPS = [1,2,5,10,25,50];
  const MAX_LINES = 10;

  const renderer = new ReelRenderer(els.reelCanvas, els.fxCanvas);

  function totalBet(){ return state.lines * state.bet; }

  function syncUI(){
    els.credit.textContent = currencySymbol + state.credit.toFixed(2);
    els.lines.textContent = state.lines;
    els.bet.textContent = currencySymbol + state.bet.toFixed(2);
    els.totalBet.textContent = currencySymbol + totalBet().toFixed(2);

    // Dynamic mode header/footer label
    if (isDemoMode) {
      els.creditLabel.textContent = "demo credit";
      els.demoFooterLabel.textContent = "1 credit = 1 fun coin · Demo play only, no real money";
    } else {
      els.creditLabel.textContent = "real balance";
      els.demoFooterLabel.textContent = `Real play active · Currency: ${userCurrency}`;
    }
  }

  function setWinDisplay(amount){
    els.win.textContent = currencySymbol + amount.toFixed(2);
  }

  function lightPip(lineIndex){
    els.pips.forEach(p => {
      p.classList.toggle('lit', Number(p.dataset.line) === lineIndex+1);
    });
  }

  function clearPips(){
    els.pips.forEach(p => p.classList.remove('lit'));
  }

  function showWinBanner(text, amount){
    els.winLineLabel.textContent = text;
    els.winAmountLabel.textContent = currencySymbol + amount.toFixed(2);
    els.winBanner.classList.add('show');
  }

  function hideWinBanner(){
    els.winBanner.classList.remove('show');
  }

  // ---- controls -----------------------------------------------------
  els.linesMinus.addEventListener('click', () => {
    if (state.spinning) return;
    state.lines = Math.max(1, state.lines-1);
    syncUI();
  });
  els.linesPlus.addEventListener('click', () => {
    if (state.spinning) return;
    state.lines = Math.min(MAX_LINES, state.lines+1);
    syncUI();
  });
  els.betMinus.addEventListener('click', () => {
    if (state.spinning) return;
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.max(0, idx-1)];
    syncUI();
  });
  els.betPlus.addEventListener('click', () => {
    if (state.spinning) return;
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.min(BET_STEPS.length-1, idx+1)];
    syncUI();
  });
  els.maxBtn.addEventListener('click', () => {
    if (state.spinning) return;
    state.lines = MAX_LINES;
    state.bet = BET_STEPS[BET_STEPS.length-1];
    syncUI();
    doSpin();
  });
  els.autoBtn.addEventListener('click', () => {
    state.auto = !state.auto;
    els.autoBtn.classList.toggle('active', state.auto);
    if (state.auto && !state.spinning) doSpin();
  });
  els.spinBtn.addEventListener('click', doSpin);

  document.addEventListener('keydown', e => {
    if (e.code === 'Space'){ e.preventDefault(); doSpin(); }
  });

  // ---- spin flow ------------------------------------------------------
  async function doSpin(){
    if (state.spinning) return;
    const cost = totalBet();
    if (state.credit < cost){
      if (isDemoMode) {
        alert("Demo balance insufficient! Refilling demo credits...");
        state.credit = 1000.00;
        demoBalance = 1000.00;
        syncUI();
      } else {
        alert("Insufficient real balance! Please deposit money.");
        state.auto = false;
        els.autoBtn.classList.remove('active');
        return;
      }
    }

    state.spinning = true;
    state.credit -= cost;
    if (!isDemoMode) {
      realBalance = state.credit;
      syncBalance(state.credit);
    } else {
      demoBalance = state.credit;
    }
    if (typeof soundEngine !== 'undefined') {
      soundEngine.playSpin();
    }
    syncUI();
    setWinDisplay(0);
    hideWinBanner();
    clearPips();
    renderer.clearHighlight();
    els.spinBtn.disabled = true;
    els.spinBtn.classList.add('spinning');

    const grid = spinGrid();
    await renderer.startSpin(grid);

    els.spinBtn.classList.remove('spinning');
    els.spinBtn.disabled = false;

    const result = evaluateWins(grid, state.lines, state.bet);
    if (result.totalWin > 0){
      state.credit += result.totalWin;
      if (!isDemoMode) {
        realBalance = state.credit;
        syncBalance(state.credit);
      } else {
        demoBalance = state.credit;
      }
      await playWinSequence(result);
    }

    syncUI();
    state.spinning = false;

    if (state.auto){
      if (state.credit >= totalBet()){
        setTimeout(doSpin, 600);
      } else {
        state.auto = false;
        els.autoBtn.classList.remove('active');
      }
    }
  }

  async function playWinSequence(result){
    setWinDisplay(result.totalWin);
    if (typeof soundEngine !== 'undefined') {
      soundEngine.playWin();
    }
    for (const win of result.wins){
      if (win.isScatter){
        lightPip(-1);
        renderer.highlightLine(-1, win.cells);
        showWinBanner('SCATTER · TOWERS', win.amount);
      } else {
        lightPip(win.lineIndex);
        renderer.highlightLine(win.lineIndex, win.cells);
        showWinBanner(`LINE ${win.lineIndex+1} WINS`, win.amount);
      }
      if (typeof soundEngine !== 'undefined') {
        for (let c = 0; c < 8; c++) {
          soundEngine.playCoinRollup();
          await sleep(100);
        }
      } else {
        await sleep(900);
      }
    }
    await sleep(300);
    hideWinBanner();
    clearPips();
    renderer.clearHighlight();
    if (typeof soundEngine !== 'undefined' && soundEngine.musicSynth) {
      soundEngine.musicSynth.unduck();
    }
  }

  function sleep(ms){ return new Promise(res => setTimeout(res, ms)); }

  /* ===== MODE TOGGLE GLUE ===== */
  const rmToggle = document.getElementById('rmToggle');
  const modeSwitch = document.getElementById('modeSwitch');
  const rmToggleLabel = document.querySelector('.rmToggle span');

  function updateModeUI() {
    if (isDemoMode) {
      modeSwitch.classList.remove('on');
      rmToggleLabel.textContent = 'PLAY FOR REAL MONEY';
      balance = demoBalance;
    } else {
      if (realBalance < 1.0) {
        alert("Your real balance is too low! Switching to Demo Mode.");
        isDemoMode = true;
        modeSwitch.classList.remove('on');
        rmToggleLabel.textContent = 'PLAY FOR REAL MONEY';
        balance = demoBalance;
      } else {
        modeSwitch.classList.add('on');
        rmToggleLabel.textContent = 'REAL PLAY ACTIVE';
        balance = realBalance;
      }
    }
    state.credit = balance;
    syncUI();
  }

  rmToggle.addEventListener('click', function() {
    if (state.spinning) return;
    isDemoMode = !isDemoMode;
    updateModeUI();
  });

  updateModeUI();
})();
</script>
</body>
</html>
