<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Treasure Climb — Golden Risk Ladder</title>
<!-- Google Fonts for premium typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   TREASURE CLIMB — golden vault edition
   Palette: vault black #140b03, vault brown #3a2510,
            gold #d9a443, bright gold #ffd76a, pale gold #fff3cf,
            collect green #1d9d55, ember #e2572b
   ============================================================ */
:root{
  --black-deep:#030805;
  --black:rgba(8, 20, 12, 0.85);
  --brown:rgba(20, 42, 28, 0.75);
  --brown-dk:rgba(8, 18, 12, 0.9);
  --gold:#d9a443;
  --gold-br:#ffd76a;
  --gold-lt:#fff3cf;
  --gold-dk:#8a5e1f;
  --green:#1d9d55;
  --green-lt:#5be88a;
  --ember:#e2572b;
  --shadow:rgba(0,0,0,.6);
}
*{ box-sizing:border-box; }
html,body{
  margin:0; min-height:100vh;
  background:var(--black-deep);
  font-family:'Outfit','Trebuchet MS',sans-serif;
  color:#fff7df;
  overflow:hidden;
}

/* ============================================================
   SLOT CABINET FRAMEWORK LAYOUT (SAME-TO-SAME MOCKUP)
   ============================================================ */
#outerWrapper {
  display: flex;
  min-height: 100vh;
  background: #050d09;
}

/* Sidenav (Left Panel) */
.game-sidenav {
  width: 50px;
  background: #08120d;
  border-right: 1px solid #1a3222;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 12px 0;
  gap: 16px;
  position: relative;
  z-index: 10;
}
.game-sidenav .side-link {
  color: #4a7a5d;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.2s;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
}
.game-sidenav .side-link:hover, .game-sidenav .side-link.active {
  background: rgba(217, 164, 67, 0.1);
  color: var(--gold);
}

/* Main content workspace area */
.workspace-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Header */
.game-header {
  height: 36px;
  background: #08120d;
  border-bottom: 1px solid #1a3222;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 12px;
  position: relative;
  z-index: 10;
}
.game-header .breadcrumb {
  font-size: 10px;
  font-weight: 700;
  color: #4a7a5d;
  display: flex;
  align-items: center;
  gap: 4px;
  text-transform: uppercase;
}
.game-header .breadcrumb a {
  color: #4a7a5d;
  text-decoration: none;
}
.game-header .breadcrumb a:hover {
  color: #fff;
}
.game-header .breadcrumb span {
  color: var(--gold);
}
.game-header .header-title {
  font-family: 'Exo 2', sans-serif;
  font-weight: 900;
  font-size: 12px;
  letter-spacing: 1px;
  color: #ffffff;
  text-transform: uppercase;
}
.game-header .header-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}
.game-header .search-wrap {
  position: relative;
}
.game-header .search-input {
  background: #050d09;
  border: 1px solid #1a3222;
  border-radius: 4px;
  padding: 2px 8px 2px 20px;
  font-size: 10px;
  color: #fff;
  width: 120px;
  outline: none;
}
.game-header .search-wrap i {
  position: absolute;
  left: 6px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 9px;
  color: #4a7a5d;
}
.game-header .win-btn {
  color: #4a7a5d;
  font-size: 12px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 2px;
  transition: color 0.15s;
}
.game-header .win-btn:hover {
  color: var(--gold);
}

/* Sub-Header */
.game-sub-header {
  height: 32px;
  background: #050d09;
  border-bottom: 1px solid #1a3222;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 12px;
  z-index: 10;
}
.game-sub-header .game-badge {
  display: flex;
  align-items: center;
  gap: 6px;
}
.game-sub-header .game-badge img {
  width: 18px;
  height: 18px;
  object-fit: contain;
}
.game-sub-header .game-title {
  font-size: 10px;
  font-weight: 800;
  color: #ffffff;
}
.game-sub-header .real-money-toggle {
  display: flex;
  align-items: center;
  gap: 6px;
}
.game-sub-header .real-money-toggle span {
  font-size: 9px;
  font-weight: 800;
  color: #4a7a5d;
  text-transform: uppercase;
}
.game-sub-header .toggle-switch {
  width: 24px;
  height: 12px;
  background: #020604;
  border: 1px solid var(--gold);
  border-radius: 6px;
  position: relative;
  cursor: pointer;
  transition: all 0.2s;
}
.game-sub-header .toggle-dot {
  width: 8px;
  height: 8px;
  background: var(--gold);
  border-radius: 50%;
  position: absolute;
  top: 1px;
  left: 1px;
  transition: all 0.2s;
}
.game-sub-header .toggle-switch.on {
  background: var(--gold);
}
.game-sub-header .toggle-switch.on .toggle-dot {
  left: 13px;
  background: #020604;
}

/* Footer bar */
.game-footer {
  height: 32px;
  background: #08120d;
  border-top: 1px solid #1a3222;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 12px;
  position: relative;
  z-index: 10;
}
.game-footer .footer-tab {
  display: flex;
  align-items: center;
  gap: 4px;
  color: #4a7a5d;
  font-size: 10px;
  font-weight: 800;
  cursor: pointer;
  transition: color 0.15s;
  text-transform: uppercase;
}
.game-footer .footer-tab:hover {
  color: #fff;
}

/* Cabinet Stage Container */
.cabinet-stage {
  flex: 1;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
}

.backdrop{
  position:absolute; inset:0; z-index:0;
  background-image: url('/assets/image/cashmeifyoucan/bg.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  filter: brightness(0.4) contrast(1.1);
}
#bgFxCanvas{
  position:absolute; inset:0; z-index:0;
  width:100%; height:100%;
  pointer-events:none;
}
.stage{
  position:relative; z-index:1;
  max-width:1040px;
  width: 100%;
  margin:0 auto;
  display:flex;
  flex-direction:column;
  align-items:center;
}

.game-frame{
  position:relative;
  width:min(900px,96vw);
  max-height: calc(100vh - 142px);
  border-radius:18px;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

/* ---------------- top multiplier ribbon ---------------- */
.ribbon{
  display:flex;
  gap:14px;
  overflow:hidden;
  padding:3px 8px;
  margin-bottom:4px;
  border-radius:8px;
  background: linear-gradient(180deg, rgba(10, 22, 14, 0.92), rgba(4, 10, 6, 0.96));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.18), inset 0 2px 4px rgba(0,0,0,.6);
  white-space:nowrap;
}
.ribbon-track{
  display:flex;
  gap:16px;
  animation:ribbon-scroll 22s linear infinite;
}
.ribbon span{
  font-size:12px;
  font-weight:700;
  letter-spacing:.5px;
  color:var(--gold-lt);
  opacity:.85;
}
.ribbon span.hot{ color:#ff7a52; }
@keyframes ribbon-scroll{
  from{ transform:translateX(0); }
  to{ transform:translateX(-50%); }
}

.table{
  position:relative;
  display:grid;
  grid-template-columns: 190px 1fr 70px;
  gap:14px;
  align-items:stretch;
}
@media (max-width:760px){
  .table{ grid-template-columns: 1fr; }
  .side-col.right{ flex-direction:row; justify-content:center; }
}

/* ---------------- left: risk track selector cards ---------------- */
.tracks{
  display:flex; flex-direction:column; gap:10px;
  justify-content:center;
}
.track-card{
  position:relative;
  border-radius:10px;
  padding:4px 6px 6px;
  cursor:pointer;
  border:1px solid rgba(255, 255, 255, 0.06);
  background: linear-gradient(160deg, rgba(16, 32, 22, 0.72), rgba(6, 12, 8, 0.82));
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(5px);
  box-shadow:0 4px 10px rgba(0,0,0,.4);
  transition:transform .15s, border-color .15s, box-shadow .15s;
  display:flex; align-items:center; gap:8px;
}
.track-card:hover{ transform:translateY(-1px); }
.track-card.selected{
  border-color:var(--gold-br);
  box-shadow:0 0 0 1px var(--gold), 0 0 14px rgba(255,215,106,.35), 0 4px 10px rgba(0,0,0,.4);
}
.track-card.disabled{ opacity:.45; cursor:default; pointer-events:none; }
.track-icon{
  width:36px; height:36px; flex:none;
  border-radius:8px;
  display:flex; align-items:center; justify-content:center;
  overflow: hidden;
  background: radial-gradient(circle at 35% 30%, rgba(20, 50, 32, 0.8), rgba(8, 20, 12, 0.95));
}
.track-info{ flex:1; min-width:0; }
.track-info .label{
  font-size:11px; font-weight:700; letter-spacing:0.5px;
  color:var(--gold-lt);
}
.track-info .sub{
  font-size:8px; letter-spacing:0.5px; opacity:.55; text-transform:uppercase;
  margin-top:0px;
}
.dots{ display:flex; gap:2px; margin-top:4px; }
.dot{
  flex:1; height:4px; border-radius:2px;
  background:rgba(255,255,255,.08);
  overflow:hidden;
}
.dot.filled::after{
  content:""; display:block; height:100%;
  background:linear-gradient(90deg,var(--gold),var(--gold-br));
}
.dot.filled.r1::after{ background:linear-gradient(90deg,#e2572b,#ffb066); }
.dot.filled.r3::after{ background:linear-gradient(90deg,#4fd6ff,#cfeeff); }

/* ---------------- center: ladder canvas ---------------- */
.ladder-col{ display:flex; flex-direction:column; gap:10px; }
.ladder-wrap{
  position:relative;
  width:100%;
  height: clamp(150px, 24vh, 260px);
  border-radius:12px;
  overflow:hidden;
  background:radial-gradient(ellipse at 50% 0%, rgba(217,164,67,.12), transparent 70%), linear-gradient(180deg, rgba(14, 28, 18, 0.85), rgba(4, 10, 6, 0.94) 92%);
  box-shadow:inset 0 0 0 2px rgba(28, 54, 38, 0.6), inset 0 8px 20px rgba(0,0,0,.65), inset 0 -8px 20px rgba(0,0,0,.65);
}
#ladderCanvas, #fxCanvas{
  position:absolute; inset:0; width:100%; height:100%; display:block;
}
#fxCanvas{ pointer-events:none; }

/* ---------------- Central Card Reel Box ---------------- */
.reel-container {
  width: 140px;
  height: 64px;
  margin: 4px auto;
  border-radius: 10px;
  background: linear-gradient(180deg, rgba(8, 18, 12, 0.9), rgba(3, 8, 5, 0.96));
  border: 2px solid var(--gold);
  box-shadow: 0 4px 10px rgba(0,0,0,0.5), inset 0 0 10px rgba(217, 164, 67, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}
.reel-card-img {
  height: 48px;
  width: auto;
  max-width: 90%;
  object-fit: contain;
  transition: transform 0.1s;
}
.reel-cross-overlay {
  position: absolute;
  inset: 0;
  background: rgba(226, 87, 43, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.15s;
}
.reel-cross-overlay svg {
  width: 36px;
  height: 36px;
  filter: drop-shadow(0 2px 6px rgba(0,0,0,0.8));
}
.reel-container.spinning .reel-card-img {
  animation: reel-spin-anim 0.08s linear infinite;
}
.reel-container.match-success {
  box-shadow: 0 0 20px #ffd76a, inset 0 0 12px rgba(255, 215, 106, 0.8);
  border-color: #fff3cf;
  transition: all 0.2s ease-in-out;
}
.reel-container.match-fail {
  box-shadow: 0 0 20px #e2572b, inset 0 0 12px rgba(226, 87, 43, 0.8);
  border-color: #ff7a52;
  transition: all 0.2s ease-in-out;
}
@keyframes reel-spin-anim {
  0% { transform: translateY(-10px) scaleY(0.8); opacity: 0.7; }
  50% { transform: translateY(10px) scaleY(0.8); opacity: 0.7; }
  100% { transform: translateY(-10px) scaleY(0.8); opacity: 0.7; }
}

.bet-row{
  display:flex; align-items:center; gap:6px;
  justify-content:center;
  margin-top: 3px;
}
.bet-box{
  flex:1;
  display:flex; align-items:center; justify-content:space-between;
  padding:5px 12px;
  border-radius:8px;
  background:linear-gradient(180deg, rgba(20, 42, 28, 0.85), rgba(8, 18, 12, 0.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.35), inset 0 2px 4px rgba(0,0,0,.55);
}
.bet-box .bet-label { font-size:9px; letter-spacing:1px; text-transform:uppercase; color:var(--gold-lt); opacity:.7; font-weight: 800; }
.bet-box span{ font-size:14px; font-weight:700; color:#fff7df; font-family:Georgia,serif; }
.stepper{
  width:26px; height:26px; border-radius:50%;
  border:1px solid rgba(217,164,67,.5);
  background:radial-gradient(circle at 35% 30%,#caa24f,#7a4e12);
  color:#3a1505; font-size:14px; font-weight:700;
  cursor:pointer; display:flex; align-items:center; justify-content:center;
  transition:transform .1s, background .15s;
}
.stepper:hover{ background:radial-gradient(circle at 35% 30%,#e2bb66,#946018); }
.stepper:active{ transform:scale(.88); }

.result-row{
  display:flex; flex-direction:column; gap:5px;
  align-items:center;
}
.result-box{
  width:100%;
  text-align:center;
  padding:5px 0;
  border-radius:8px;
  font-size:20px;
  font-weight:800;
  font-family:Georgia,serif;
  background:linear-gradient(180deg, rgba(20, 42, 28, 0.85), rgba(6, 12, 8, 0.94));
  box-shadow:inset 0 0 0 1px rgba(255,243,207,.35), inset 0 2px 8px rgba(0,0,0,.55);
  color:#fff7df;
}
.collect-btn{
  width:100%;
  padding:8px 0;
  border-radius:8px;
  border:none;
  font-size:13px;
  font-weight:800;
  letter-spacing:1px;
  cursor:pointer;
  color:#06160d;
  background:linear-gradient(180deg,#5be88a,#1d9d55);
  box-shadow:0 3px 0 #0c5a30, 0 6px 10px rgba(0,0,0,.4);
  transition:transform .08s, box-shadow .08s, filter .15s;
}
.collect-btn:hover{ filter:brightness(1.08); }
.collect-btn:active{ transform:translateY(2px); box-shadow:0 1px 0 #0c5a30, 0 3px 6px rgba(0,0,0,.4); }
.collect-btn:disabled{ opacity:.4; cursor:default; filter:none; }

/* ---------------- right side buttons inside slot cabinet ---------------- */
.side-col.right{
  display:flex; flex-direction:column; gap:8px; justify-content:center; align-items:center;
}
.icon-btn{
  width:36px; height:36px; border-radius:50%;
  border:2px solid var(--gold);
  background:radial-gradient(circle at 35% 30%,rgba(40, 128, 82, 0.85),rgba(8, 36, 22, 0.95));
  color:#eafff0;
  display:flex; align-items:center; justify-content:center;
  cursor:pointer;
  box-shadow:0 3px 6px rgba(0,0,0,.5);
  transition:transform .1s, filter .15s;
}
.icon-btn:hover{ filter:brightness(1.15); }
.icon-btn:active{ transform:scale(0.9); }
.icon-btn svg{ width:16px; height:16px; }
.icon-btn.active{ border-color:var(--ember); color:var(--ember); }

/* Custom Big Spin Button styling matching screenshots */
.spin-btn-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.spin-btn {
  width: 58px;
  height: 58px;
  border-radius: 50%;
  border: 3.5px solid var(--gold);
  background: radial-gradient(circle at 35% 30%, rgba(47, 157, 99, 0.95), rgba(12, 51, 31, 0.98));
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 0 12px rgba(47, 157, 99, 0.4), 0 5px 10px rgba(0,0,0,0.6);
  transition: all 0.15s ease-in-out;
  outline: none;
}
.spin-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 20px rgba(255, 215, 106, 0.55), 0 6px 14px rgba(0,0,0,0.6);
  border-color: #ffd76a;
}
.spin-btn:active {
  transform: scale(0.92);
}
.spin-btn svg {
  width: 26px;
  height: 26px;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
}
.spin-btn.disabled {
  opacity: 0.5;
  cursor: default;
  pointer-events: none;
  filter: grayscale(0.8);
}

/* ---------------- bottom balance bar ---------------- */
.balance-bar{
  display:flex; justify-content:space-between; align-items:center;
  margin-top:8px;
  padding:6px 12px;
  border-radius:8px;
  background:linear-gradient(180deg, rgba(16, 32, 22, 0.85), rgba(6, 12, 8, 0.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.3);
  font-size:12px;
  font-weight:700;
  color:var(--gold-lt);
}
.balance-bar .chip{
  display:flex; align-items:center; gap:6px;
}
.balance-bar svg{ width:14px; height:14px; }

.footer-note{
  margin-top:6px;
  font-size:10px;
  color:rgba(255,247,223,.45);
  text-align:center;
  letter-spacing:.5px;
}

@media (prefers-reduced-motion: reduce){
  .track-card{ transition:none; }
  .ribbon-track{ animation:none; }
}

/* Toast Message overlay styling */
.toast-msg {
  position: fixed; top: 85px; left: 50%; transform: translateX(-50%);
  background: #241704; border: 2px solid var(--gold);
  border-radius: 10px; padding: 12px 28px;
  font-family: 'Exo 2', sans-serif; font-size: 14px; font-weight: 700;
  color: #fff; letter-spacing: 1px; z-index: 9999;
  animation: toastIn 0.3s ease; white-space: nowrap;
  box-shadow: 0 4px 20px rgba(0,0,0,0.8);
}
.toast-msg.win { border-color: var(--green); color: var(--green-lt); background: #06160d; }
.toast-msg.lose { border-color: var(--ember); color: #ffa080; background: #200a05; }
@keyframes toastIn { from { opacity:0; transform: translateX(-50%) translateY(-10px); } to { opacity:1; transform: translateX(-50%) translateY(0); } }

</style>
</head>
<body>

<div id="outerWrapper">
  <!-- Left Vertical Sidenav -->
  <aside class="game-sidenav">
    <div class="logo-space">
      <span style="font-style: italic; font-weight: 900; font-size: 16px; color: var(--gold);">1X</span>
    </div>
    <div class="side-link" onclick="window.location.href='{{ route('dashboard') }}'" title="Home">
      <i class="fas fa-home"></i>
    </div>
    <div class="side-link" title="Favorites">
      <i class="fas fa-heart"></i>
    </div>
    <div class="side-link active" title="Lobby">
      <i class="fas fa-th-large"></i>
    </div>
    <div class="side-link" title="Popular">
      <i class="fas fa-bolt"></i>
    </div>
    <div class="side-link" title="Tournaments">
      <i class="fas fa-trophy"></i>
    </div>
    <div class="side-link" title="Games">
      <i class="fas fa-gamepad"></i>
    </div>
  </aside>

  <!-- Right Content Panels Wrapper -->
  <div class="workspace-container">
    <!-- Top Header Bar -->
    <header class="game-header">
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Search results</a>
        <i class="fas fa-chevron-right" style="font-size: 8px; margin: 0 4px;"></i>
        <span>Cash Me If You Can</span>
      </div>
      <div class="header-title">CASH ME IF YOU CAN</div>
      <div class="header-actions">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" class="search-input" value="Cash Me If You Can" readonly>
        </div>
        <button class="win-btn" title="Duplicate Window"><i class="fas fa-window-restore"></i></button>
        <button class="win-btn" onclick="toggleFullScreen()" title="Fullscreen"><i class="fas fa-expand"></i></button>
        <button class="win-btn" onclick="window.location.reload()" title="Reload"><i class="fas fa-rotate"></i></button>
        <button class="win-btn" title="Favorite"><i class="far fa-star"></i></button>
        <button class="win-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="Close"><i class="fas fa-xmark"></i></button>
      </div>
    </header>

    <!-- Sub-Header Real Money Play Bar -->
    <div class="game-sub-header">
      <div class="game-badge">
        <img src="/assets/image/cashme.webp" alt="Game Badge">
        <span class="game-title">Cash Me If You Can</span>
      </div>
      <div class="real-money-toggle">
        <span id="modeStatusText">PLAY FOR REAL MONEY</span>
        <div class="toggle-switch" id="realMoneyToggle">
          <div class="toggle-dot" id="realMoneyDot"></div>
        </div>
      </div>
    </div>

    <!-- Main Game Workspace Centered Stage -->
    <div class="cabinet-stage">
      <div class="backdrop"></div>
      <canvas id="bgFxCanvas"></canvas>

      <main class="stage">
        <div class="game-frame">

          <!-- top decorative multiplier ribbon -->
          <div class="ribbon">
            <div class="ribbon-track" id="ribbonTrack"></div>
          </div>

          <div class="table">

            <!-- left: risk track selector cards with mapped transparent PNGs -->
            <div class="side-col left tracks" id="trackList">
              <div class="track-card" data-risk="3">
                <div class="track-icon">
                  <img src="/assets/image/cashmeifyoucan/3.png" alt="Diamond" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="track-info">
                  <div class="label">STEPS: 3</div>
                  <div class="sub">Low risk</div>
                  <div class="dots" id="dots-3"></div>
                </div>
              </div>
              <div class="track-card" data-risk="2">
                <div class="track-icon">
                  <img src="/assets/image/cashmeifyoucan/2.png" alt="Cash" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="track-info">
                  <div class="label">STEPS: 2</div>
                  <div class="sub">Medium risk</div>
                  <div class="dots" id="dots-2"></div>
                </div>
              </div>
              <div class="track-card" data-risk="1">
                <div class="track-icon">
                  <img src="/assets/image/cashmeifyoucan/4.png" alt="Coin" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="track-info">
                  <div class="label">STEPS: 1</div>
                  <div class="sub">High risk</div>
                  <div class="dots" id="dots-1"></div>
                </div>
              </div>
            </div>

            <!-- center: ladder + main control displays -->
            <div class="ladder-col">
              <div class="ladder-wrap">
                <canvas id="ladderCanvas"></canvas>
                <canvas id="fxCanvas"></canvas>
              </div>

              <!-- Central Card Reel Box (Spins random numbers from cashmeifyoucan folder) -->
              <div class="reel-container" id="reelContainer">
                <img class="reel-card-img" id="reelCardImg" src="/assets/image/cashmeifyoucan/3.png" alt="Card">
                <div class="reel-cross-overlay" id="reelCrossOverlay">
                  <svg viewBox="0 0 24 24" fill="none" stroke="#e2572b" stroke-width="4.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </div>
              </div>

              <!-- Bet adjustment pill -->
              <div class="bet-row">
                <button class="stepper" id="betMinus">–</button>
                <div class="bet-box">
                  <span class="bet-label">bet</span>
                  <span id="betDisplay">1.00</span>
                </div>
                <button class="stepper" id="betPlus">+</button>
              </div>

              <!-- Result and Collect controls -->
              <div class="result-row">
                <div class="result-box" id="resultBox">0.00</div>
                <button class="collect-btn" id="collectBtn" disabled>COLLECT</button>
              </div>
            </div>

            <!-- right: side icons inside cabinet -->
            <div class="side-col right">
              <button class="icon-btn" id="turboBtn" title="Turbo (faster animations)">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8z"/></svg>
              </button>
              
              <button class="icon-btn" id="autoBtn" title="Autoplay">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                  <path d="M21.5 2v6h-6"></path>
                  <path d="M2.5 22v-6h6"></path>
                  <path d="M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3"></path>
                </svg>
              </button>

              <!-- Big Golden/Green Circular Spin Button -->
              <div class="spin-btn-container">
                <button class="spin-btn" id="spinBtn" title="SPIN / ADVANCE">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                    <path d="M21.5 2v6h-6"></path>
                    <path d="M2.5 22v-6h6"></path>
                    <path d="M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3"></path>
                  </svg>
                </button>
              </div>

              <button class="icon-btn" id="soundBtn" title="Sound">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 9v6h4l5 5V4L8 9H4z"/></svg>
              </button>
            </div>

          </div>

          <!-- Bottom cabinet balance details -->
          <div class="balance-bar">
            <div class="chip">
              <svg viewBox="0 0 24 24" fill="#ffd76a"><circle cx="12" cy="12" r="9"/></svg>
              <span id="balanceDisplay">DEMO 999,980.00</span>
            </div>
            <div class="chip">
              <span id="betEcho">DEMO 1.00</span>
              <svg viewBox="0 0 24 24" fill="#5be88a"><circle cx="12" cy="12" r="9"/></svg>
            </div>
          </div>

        </div>

        <p class="footer-note">Demo play only · No real money · Original artwork &amp; mechanics</p>
      </main>
    </div>

    <!-- Status bottom footer bar -->
    <footer class="game-footer">
      <div style="display: flex; gap: 20px;">
        <div class="footer-tab"><i class="fas fa-clock" style="margin-right:4px;"></i> Recent Games</div>
        <div class="footer-tab"><i class="fas fa-sparkles" style="margin-right:4px;"></i> New</div>
        <div class="footer-tab"><i class="fas fa-star" style="margin-right:4px;"></i> Favorites</div>
      </div>
      <div>
        <i class="fas fa-headset" style="color: #9ca3af; cursor: pointer; font-size:14px;" title="Customer Support"></i>
      </div>
    </footer>
  </div>
</div>

<script>
/* ============================================================
   TREASURE CLIMB — game engine + canvas renderer + DOM glue
   All visuals (ladder, token, money-burst FX, flying dollar
   background) are drawn with Canvas 2D paths/gradients —
   no external images are used anywhere.
   ============================================================ */

/* ---------------------------------------------------------------
   0. GAME INTEGRATION / DATABASE & MODES CONFIGURATION
   --------------------------------------------------------------- */
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
let demoBalance = 10000.00;
let balance = isDemoMode ? demoBalance : realBalance;

// Setup Real Money Toggle Switch in Sub-Header
const realMoneyToggle = document.getElementById('realMoneyToggle');
const realMoneyDot = document.getElementById('realMoneyDot');
const modeStatusText = document.getElementById('modeStatusText');

if (isDemoMode) {
  realMoneyToggle.classList.remove('on');
  modeStatusText.textContent = 'PLAY IN DEMO MODE';
} else {
  realMoneyToggle.classList.add('on');
  modeStatusText.textContent = 'PLAY FOR REAL MONEY';
}

realMoneyToggle.addEventListener('click', () => {
  const nextDemo = isDemoMode ? '0' : '1';
  window.location.href = window.location.pathname + '?demo=' + nextDemo;
});

// Toast notification helper
function showToast(message, type = '') {
  const oldToast = document.querySelector('.toast-msg');
  if (oldToast) oldToast.remove();

  const toast = document.createElement('div');
  toast.className = `toast-msg ${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.4s ease';
    setTimeout(() => toast.remove(), 400);
  }, 2200);
}

// Database Balance Sync
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

// Fullscreen toggle helper
function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(err => {});
  } else {
    document.exitFullscreen();
  }
}

/* ===== WEB AUDIO SYNTHESIZER ===== */
class SoundController {
  constructor() {
    this.ctx = null;
    this.muted = false;
  }
  init() {
    if (!this.ctx) {
      this.ctx = new (window.AudioContext || window.webkitAudioContext)();
    }
  }
  toggle(muted) {
    this.muted = muted;
  }
  playClick() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    const osc = this.ctx.createOscillator();
    const gain = this.ctx.createGain();
    osc.connect(gain);
    gain.connect(this.ctx.destination);
    osc.type = 'sine';
    osc.frequency.setValueAtTime(600, now);
    osc.frequency.exponentialRampToValueAtTime(150, now + 0.08);
    gain.gain.setValueAtTime(0.04, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
    osc.start(now);
    osc.stop(now + 0.08);
  }
  playTungTung() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    
    // Note 1 (sweet chime)
    const osc1 = this.ctx.createOscillator();
    const gain1 = this.ctx.createGain();
    osc1.connect(gain1);
    gain1.connect(this.ctx.destination);
    osc1.type = 'sine';
    osc1.frequency.setValueAtTime(880, now);
    gain1.gain.setValueAtTime(0.08, now);
    gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.12);
    osc1.start(now);
    osc1.stop(now + 0.12);
    
    // Note 2 (high harmony)
    const osc2 = this.ctx.createOscillator();
    const gain2 = this.ctx.createGain();
    osc2.connect(gain2);
    gain2.connect(this.ctx.destination);
    osc2.type = 'sine';
    osc2.frequency.setValueAtTime(1318.51, now + 0.08);
    gain2.gain.setValueAtTime(0.08, now + 0.08);
    gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.08 + 0.18);
    osc2.start(now + 0.08);
    osc2.stop(now + 0.08 + 0.18);
  }
  playBust() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    const osc = this.ctx.createOscillator();
    const gain = this.ctx.createGain();
    osc.connect(gain);
    gain.connect(this.ctx.destination);
    osc.type = 'sawtooth';
    osc.frequency.setValueAtTime(140, now);
    osc.frequency.linearRampToValueAtTime(40, now + 0.45);
    gain.gain.setValueAtTime(0.15, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.45);
    osc.start(now);
    osc.stop(now + 0.45);
    
    const osc2 = this.ctx.createOscillator();
    const gain2 = this.ctx.createGain();
    osc2.connect(gain2);
    gain2.connect(this.ctx.destination);
    osc2.type = 'triangle';
    osc2.frequency.setValueAtTime(80, now);
    osc2.frequency.linearRampToValueAtTime(20, now + 0.5);
    gain2.gain.setValueAtTime(0.2, now);
    gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.5);
    osc2.start(now);
    osc2.stop(now + 0.5);
  }
  playCollect() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    const notes = [523.25, 659.25, 783.99, 1046.50];
    notes.forEach((freq, idx) => {
      const o = this.ctx.createOscillator();
      const g = this.ctx.createGain();
      o.connect(g);
      g.connect(this.ctx.destination);
      o.type = 'sine';
      o.frequency.setValueAtTime(freq, now + idx * 0.08);
      g.gain.setValueAtTime(0.06, now + idx * 0.08);
      g.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.22);
      o.start(now + idx * 0.08);
      o.stop(now + idx * 0.08 + 0.25);
    });
  }
}
const soundCtrl = new SoundController();

/* ---------------------------------------------------------------
   1. ENGINE — risk tracks, multiplier tables, step outcome logic
   --------------------------------------------------------------- */

const TRACKS = {
  1: {
    steps: 8,
    surviveChance: 0.18,
    multipliers: [1, 2, 4, 8, 16, 32, 64, 128]
  },
  2: {
    steps: 10,
    surviveChance: 0.28,
    multipliers: [0.5,1,2,2.5,3,5,5.5,6,6.5,10]
  },
  3: {
    steps: 14,
    surviveChance: 0.40,
    multipliers: [0.5,1,2,2.5,3,5,5.5,6,6.5,10,11,12,13,750]
  }
};

class ClimbEngine{
  constructor(risk){ this.setRisk(risk); }
  setRisk(risk){ this.risk = risk; this.track = TRACKS[risk]; this.reset(); }
  reset(){ this.currentStep = 0; this.alive = true; this.busted = false; }
  currentMultiplier(){ return this.currentStep === 0 ? 0 : this.track.multipliers[this.currentStep-1]; }
  nextMultiplier(){ return this.track.multipliers[this.currentStep]; }
  atTop(){ return this.currentStep >= this.track.steps; }
  advance(){
    if (!this.alive || this.atTop()) return null;
    const roll = Math.random();
    const survived = roll < this.track.surviveChance;
    if (survived){
      this.currentStep++;
      return { survived:true, atTop: this.atTop() };
    } else {
      this.alive = false;
      this.busted = true;
      return { survived:false };
    }
  }
}

/* ---------------------------------------------------------------
   2. RENDERER — connected golden staircase drawn on canvas
   --------------------------------------------------------------- */

class LadderRenderer{
  constructor(canvas, fxCanvas){
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.fxCanvas = fxCanvas;
    this.fxCtx = fxCanvas.getContext('2d');
    this.dpr = Math.min(window.devicePixelRatio || 1, 2);
    this.particles = [];
    this.tokenY = 0;
    this.windowStartFloat = 0;
    this.flashAlpha = 0;
    this.flashColor = '255,80,60';
    this._resize();
    window.addEventListener('resize', () => this._resize());
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
  }

  setEngine(engine){
    this.engine = engine;
    this.visibleCount = 7;
    this._snapToken();
  }

  _snapToken(){
    this.tokenY = this.engine.currentStep;
    this.windowStartFloat = this._currentWindowStart();
  }

  _stepToY(step){
    const total = this.engine.track.steps;
    const windowStart = Math.max(0, Math.min(step - 2, total - this.visibleCount));
    return step - windowStart;
  }

  _currentWindowStart(){
    const total = this.engine.track.steps;
    const step = this.engine.currentStep;
    return Math.max(0, Math.min(step - 2, total - this.visibleCount));
  }

  animateClimbTo(step, onDone){
    const startW = this.windowStartFloat;
    const targetW = Math.max(0, Math.min(step - 2, this.engine.track.steps - this.visibleCount));
    const startY = this.tokenY;
    const targetY = step;
    
    const start = performance.now();
    const dur = window.__turbo ? 180 : 480;
    
    const animate = (now) => {
      const t = Math.min((now-start)/dur, 1);
      const eased = 1 - Math.pow(1-t, 3);
      
      this.windowStartFloat = startW + (targetW - startW) * eased;
      this.tokenY = startY + (targetY - startY) * eased;
      
      if (t < 1){
        requestAnimationFrame(animate);
      } else {
        this.windowStartFloat = targetW;
        this.tokenY = targetY;
        if (onDone) onDone();
      }
    };
    requestAnimationFrame(animate);
  }

  flashBust(){
    this.flashColor = '226,87,43';
    this.flashAlpha = 1;
    const cx = this.w/2, cy = this.h*0.62;
    for (let i=0;i<26;i++) this.particles.push(makeBurstParticle(cx,cy,'226,87,43'));
  }
  flashWin(){
    this.flashColor = '255,215,106';
    this.flashAlpha = 0.7;
    const cx = this.w/2, cy = this.h*0.3;
    for (let i=0;i<22;i++) this.particles.push(makeBurstParticle(cx,cy,'255,231,140'));
  }

  _loop(now){
    const dt = Math.min(now-this._lastT, 48);
    this._lastT = now;
    if (this.flashAlpha > 0) this.flashAlpha = Math.max(0, this.flashAlpha - dt*0.0022);
    this._draw();
    this._drawFx(dt);
    requestAnimationFrame(this._loop.bind(this));
  }

  _draw(){
    const ctx = this.ctx;
    ctx.save();
    ctx.scale(this.dpr, this.dpr);
    ctx.clearRect(0,0,this.w,this.h);
    if (!this.engine){ ctx.restore(); return; }

    const w = this.w, h = this.h;
    const total = this.engine.track.steps;
    
    const wStart = this.windowStartFloat;
    const wStartInt = Math.floor(wStart);
    const wStartFract = wStart - wStartInt;

    const topW = w*0.30, bottomW = w*0.66;
    const topY = h*0.04, bottomY = h*0.98;
    const cx = w/2;

    this._drawGoldGlow(ctx, w, h);

    // rails
    const railGrad = ctx.createLinearGradient(0,topY,0,bottomY);
    railGrad.addColorStop(0,'#fff3cf');
    railGrad.addColorStop(1,'#8a5e1f');
    ctx.strokeStyle = railGrad;
    ctx.lineWidth = 6;
    ctx.beginPath();
    ctx.moveTo(cx-topW/2, topY); ctx.lineTo(cx-bottomW/2, bottomY);
    ctx.moveTo(cx+topW/2, topY); ctx.lineTo(cx+bottomW/2, bottomY);
    ctx.stroke();

    const rungCount = this.visibleCount;
    const rungH = (bottomY-topY)/rungCount;

    // Draw rungs including extra rungs to cover the fractional slide
    for (let i = -1; i <= rungCount; i++){
      const stepIndex = wStartInt + (rungCount - 1 - i);
      if (stepIndex < 0 || stepIndex >= total) continue;

      const rowFromBottom = rungCount - 1 - i;
      const yTop = bottomY - (rowFromBottom + 1 + wStartFract)*rungH;
      const yBottom = bottomY - (rowFromBottom + wStartFract)*rungH;
      
      const tNormTop = Math.max(0, Math.min(1, (yTop-topY)/(bottomY-topY)));
      const tNormBottom = Math.max(0, Math.min(1, (yBottom-topY)/(bottomY-topY)));
      const wTop = topW + (bottomW-topW)*tNormTop;
      const wBottom = topW + (bottomW-topW)*tNormBottom;

      const climbed = stepIndex < this.engine.currentStep;
      const isNextTarget = stepIndex === this.engine.currentStep;

      this._drawStair(ctx, cx, yTop, yBottom, wTop, wBottom, this.engine.track.multipliers[stepIndex], climbed, isNextTarget);
    }

    this._drawToken(ctx, cx, topY, bottomY, bottomW, topW, rungCount);

    ctx.restore();
  }

  _drawGoldGlow(ctx, w, h){
    ctx.save();
    const grad = ctx.createRadialGradient(w*0.5,h*0.1,10, w*0.5,h*0.1,w*0.8);
    grad.addColorStop(0,'rgba(255,215,106,0.14)');
    grad.addColorStop(1,'rgba(0,0,0,0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0,0,w,h);
    ctx.restore();
  }

  // draws one connected "stair" block
  _drawStair(ctx, cx, yTop, yBottom, wTop, wBottom, multiplier, climbed, isNext){
    const xTopL = cx - wTop/2, xTopR = cx + wTop/2;
    const xBotL = cx - wBottom/2, xBotR = cx + wBottom/2;

    ctx.save();
    ctx.beginPath();
    ctx.moveTo(xTopL, yTop);
    ctx.lineTo(xTopR, yTop);
    ctx.lineTo(xBotR, yBottom);
    ctx.lineTo(xBotL, yBottom);
    ctx.closePath();

    let grad = ctx.createLinearGradient(0,yTop,0,yBottom);
    if (climbed){
      grad.addColorStop(0,'#fff3cf');
      grad.addColorStop(0.5,'#ffd76a');
      grad.addColorStop(1,'#c98a2d');
    } else if (isNext){
      grad.addColorStop(0,'#fffaf0');
      grad.addColorStop(0.5,'#ffe9b0');
      grad.addColorStop(1,'#e0a93f');
    } else {
      grad.addColorStop(0,'rgba(28, 64, 42, 0.7)');
      grad.addColorStop(0.55,'rgba(18, 40, 26, 0.8)');
      grad.addColorStop(1,'rgba(10, 24, 15, 0.9)');
    }
    ctx.fillStyle = grad;
    if (isNext){ ctx.shadowColor = 'rgba(255,231,140,0.9)'; ctx.shadowBlur = 20; }
    ctx.fill();
    ctx.shadowBlur = 0;

    // thin connecting seam between steps
    ctx.beginPath();
    ctx.moveTo(xBotL, yBottom);
    ctx.lineTo(xBotR, yBottom);
    ctx.lineWidth = 1.4;
    ctx.strokeStyle = climbed||isNext ? 'rgba(138,94,31,0.55)' : 'rgba(0,0,0,0.3)';
    ctx.stroke();

    // top highlight seam
    ctx.beginPath();
    ctx.moveTo(xTopL, yTop);
    ctx.lineTo(xTopR, yTop);
    ctx.lineWidth = 1;
    ctx.strokeStyle = 'rgba(255,255,255,0.12)';
    ctx.stroke();

    const yCenter = (yTop+yBottom)/2;
    const rungH = yBottom - yTop;
    const label = 'X' + multiplier;
    ctx.font = `bold ${Math.max(11, rungH*0.42)}px Georgia, serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillStyle = climbed ? '#3a1505' : (isNext ? '#3a1505' : 'rgba(255,255,255,0.7)');
    ctx.fillText(label, cx, yCenter+1);
    ctx.restore();
  }

  _drawToken(ctx, cx, topY, bottomY, bottomW, topW, rungCount){
    if (!this.engine) return;
    const rungH = (bottomY-topY)/rungCount;
    
    // Position tokenY relative to windowStartFloat
    const rowFromBottom = this.tokenY - this.windowStartFloat - 0.42;
    const yCenter = bottomY - rowFromBottom*rungH;
    const tNorm = Math.max(0, Math.min(1, (yCenter-topY)/(bottomY-topY)));
    const scale = 0.32 + 0.5*(1-tNorm);

    ctx.save();
    ctx.translate(cx, yCenter);
    ctx.scale(scale, scale);

    ctx.save();
    ctx.shadowColor = 'rgba(255,215,106,0.95)';
    ctx.shadowBlur = 26;
    const grad = ctx.createRadialGradient(-6,-8,2, 0,0,26);
    grad.addColorStop(0,'#fffaf0');
    grad.addColorStop(0.5,'#ffd76a');
    grad.addColorStop(1,'#a8721f');
    ctx.fillStyle = grad;
    ctx.beginPath();
    ctx.moveTo(0,-22); ctx.lineTo(16,0); ctx.lineTo(0,22); ctx.lineTo(-16,0);
    ctx.closePath();
    ctx.fill();
    ctx.restore();

    ctx.strokeStyle = 'rgba(255,255,255,0.7)';
    ctx.lineWidth = 1.5;
    ctx.beginPath();
    ctx.moveTo(0,-22); ctx.lineTo(16,0); ctx.lineTo(0,22); ctx.lineTo(-16,0);
    ctx.closePath();
    ctx.stroke();

    ctx.restore();
  }

  _drawFx(dt){
    const ctx = this.fxCtx;
    ctx.save();
    ctx.scale(this.dpr, this.dpr);
    ctx.clearRect(0,0,this.w,this.h);

    if (this.flashAlpha > 0){
      ctx.fillStyle = `rgba(${this.flashColor},${this.flashAlpha*0.35})`;
      ctx.fillRect(0,0,this.w,this.h);
    }

    this.particles.forEach(p => p.update(dt));
    this.particles = this.particles.filter(p => p.life > 0);
    this.particles.forEach(p => p.draw(ctx));

    ctx.restore();
  }
}

function makeBurstParticle(x,y,colorRgb){
  const angle = Math.random()*Math.PI*2;
  const speed = 0.08 + Math.random()*0.22;
  return {
    x,y,
    vx:Math.cos(angle)*speed, vy:Math.sin(angle)*speed - 0.05,
    life: 600+Math.random()*500, maxLife:600, size:2+Math.random()*3.5,
    color: colorRgb,
    update(dt){ this.x+=this.vx*dt; this.y+=this.vy*dt; this.vy+=0.00025*dt; this.life-=dt; },
    draw(ctx){
      const a = Math.max(this.life/this.maxLife,0);
      ctx.save();
      ctx.globalAlpha = a;
      ctx.fillStyle = `rgb(${this.color})`;
      ctx.shadowColor = `rgb(${this.color})`;
      ctx.shadowBlur = 6;
      ctx.beginPath();
      ctx.arc(this.x,this.y,this.size,0,Math.PI*2);
      ctx.fill();
      ctx.restore();
    }
  };
}

/* ---------------------------------------------------------------
   3. PAGE BACKGROUND FX — flying dollar bills + "$" glyphs
   --------------------------------------------------------------- */
class MoneyBackdrop{
  constructor(canvas){
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.dpr = Math.min(window.devicePixelRatio || 1, 2);
    this.items = [];
    this._resize();
    window.addEventListener('resize', () => this._resize());
    const count = window.innerWidth < 640 ? 14 : 26;
    for (let i=0;i<count;i++) this.items.push(this._spawn(true));
    this._lastT = performance.now();
    requestAnimationFrame(this._loop.bind(this));
  }
  _resize(){
    this.w = window.innerWidth;
    this.h = window.innerHeight;
    this.canvas.width = this.w * this.dpr;
    this.canvas.height = this.h * this.dpr;
  }
  _spawn(randomY){
    const kind = Math.random() < 0.55 ? 'bill' : 'sign';
    return {
      kind,
      x: Math.random()*this.w,
      y: randomY ? Math.random()*this.h : this.h + 40,
      vy: 10 + Math.random()*16,
      vx: (Math.random()-0.5)*6,
      rot: Math.random()*Math.PI*2,
      vr: (Math.random()-0.5)*0.4,
      size: 16 + Math.random()*20,
      alpha: 0.10 + Math.random()*0.16,
      sway: Math.random()*Math.PI*2
    };
  }
  _loop(now){
    const dt = Math.min((now-this._lastT)/1000, 0.05);
    this._lastT = now;
    const ctx = this.ctx;
    ctx.save();
    ctx.scale(this.dpr,this.dpr);
    ctx.clearRect(0,0,this.w,this.h);
    this.items.forEach(p => {
      p.sway += dt*0.6;
      p.y -= p.vy*dt;
      p.x += p.vx*dt + Math.sin(p.sway)*0.4;
      p.rot += p.vr*dt;
      if (p.y < -60 || p.x < -60 || p.x > this.w+60){
        Object.assign(p, this._spawn(false));
      }
      this._drawItem(ctx, p);
    });
    ctx.restore();
    requestAnimationFrame(this._loop.bind(this));
  }
  _drawItem(ctx, p){
    ctx.save();
    ctx.translate(p.x, p.y);
    ctx.rotate(p.rot);
    ctx.globalAlpha = p.alpha;
    if (p.kind === 'bill'){
      const w = p.size*1.7, h = p.size;
      const grad = ctx.createLinearGradient(-w/2,-h/2,w/2,h/2);
      grad.addColorStop(0,'#fff3cf');
      grad.addColorStop(0.5,'#d9a443');
      grad.addColorStop(1,'#8a5e1f');
      ctx.fillStyle = grad;
      ctx.strokeStyle = 'rgba(255,255,255,0.5)';
      ctx.lineWidth = 1;
      this._roundRect(ctx, -w/2,-h/2,w,h, h*0.18);
      ctx.fill(); ctx.stroke();
      ctx.fillStyle = 'rgba(58,21,5,0.6)';
      ctx.beginPath();
      ctx.arc(0,0,h*0.22,0,Math.PI*2);
      ctx.fill();
    } else {
      ctx.font = `bold ${p.size}px Georgia, serif`;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillStyle = '#ffd76a';
      ctx.fillText('$', 0, 0);
    }
    ctx.restore();
  }
  _roundRect(ctx,x,y,w,h,r){
    ctx.beginPath();
    ctx.moveTo(x+r,y);
    ctx.arcTo(x+w,y,x+w,y+h,r);
    ctx.arcTo(x+w,y+h,x,y+h,r);
    ctx.arcTo(x,y+h,x,y,r);
    ctx.arcTo(x,y,x+w,y,r);
    ctx.closePath();
  }
}

/* ---------------------------------------------------------------
   4. MAIN — DOM glue: track selection, bet stepper, advance/collect
   --------------------------------------------------------------- */
(() => {
  const $ = sel => document.querySelector(sel);

  const els = {
    ladderCanvas: $('#ladderCanvas'),
    fxCanvas: $('#fxCanvas'),
    bgFxCanvas: $('#bgFxCanvas'),
    trackList: $('#trackList'),
    betDisplay: $('#betDisplay'),
    betMinus: $('#betMinus'),
    betPlus: $('#betPlus'),
    resultBox: $('#resultBox'),
    spinBtn: $('#spinBtn'),
    collectBtn: $('#collectBtn'),
    resetBtn: $('#resetBtn'),
    autoBtn: $('#autoBtn'),
    soundBtn: $('#soundBtn'),
    turboBtn: $('#turboBtn'),
    ribbonTrack: $('#ribbonTrack'),
    betEcho: $('#betEcho'),
    balanceDisplay: $('#balanceDisplay'),
    reelContainer: $('#reelContainer'),
    reelCardImg: $('#reelCardImg'),
    reelCrossOverlay: $('#reelCrossOverlay'),
  };

  const BET_STEPS = [0.5,1,2,5,10,25,50,100];
  const state = {
    bet: 1,
    risk: 3,
    inRound: false,
    auto: false,
    sound: true,
    spinInterval: null,
  };
  window.__turbo = false;

  const riskToCard = {
    3: 3,
    2: 2,
    1: 4
  };

  const reelImages = [
    '/assets/image/cashmeifyoucan/1.png',
    '/assets/image/cashmeifyoucan/2.png',
    '/assets/image/cashmeifyoucan/3.png',
    '/assets/image/cashmeifyoucan/4.png',
    '/assets/image/cashmeifyoucan/5.png'
  ];

  new MoneyBackdrop(els.bgFxCanvas);

  const renderer = new LadderRenderer(els.ladderCanvas, els.fxCanvas);
  let engine = new ClimbEngine(state.risk);
  renderer.setEngine(engine);

  // Disable context menu on canvases to avoid inspector popups
  [els.ladderCanvas, els.fxCanvas].forEach(canvas => {
    canvas.addEventListener('contextmenu', e => e.preventDefault());
  });

  // Sound Toggle configuration
  soundCtrl.toggle(!state.sound);

  function buildDots(){
    Object.keys(TRACKS).forEach(riskKey => {
      const total = TRACKS[riskKey].steps;
      const dotsEl = document.getElementById('dots-'+riskKey);
      dotsEl.innerHTML = '';
      for (let i=0;i<Math.min(total,8);i++){
        const d = document.createElement('div');
        d.className = 'dot';
        dotsEl.appendChild(d);
      }
    });
  }
  buildDots();

  function buildRibbon(){
    const all = [];
    Object.values(TRACKS).forEach(t => all.push(...t.multipliers));
    const seq = all.concat(all);
    els.ribbonTrack.innerHTML = seq.map((m,i) =>
      `<span class="${Math.random()<0.18 ? 'hot' : ''}">x${m}</span>`
    ).join('');
  }
  buildRibbon();

  function updateDots(){
    Object.keys(TRACKS).forEach(riskKey => {
      const dotsEl = document.getElementById('dots-'+riskKey);
      const dots = dotsEl.querySelectorAll('.dot');
      const isActiveTrack = Number(riskKey) === state.risk;
      const filledCount = isActiveTrack
        ? Math.round((engine.currentStep/engine.track.steps)*dots.length)
        : 0;
      dots.forEach((d,i) => {
        d.classList.toggle('filled', i < filledCount);
        d.classList.toggle('r1', state.risk===1);
        d.classList.toggle('r3', state.risk===3);
      });
    });
  }

  function updateBalanceDisplay(){
    const balText = (isDemoMode ? 'DEMO ' : '') + currencySymbol + ' ' + balance.toFixed(2);
    els.balanceDisplay.textContent = balText;
    const headerBal = document.getElementById('header-user-balance');
    if (headerBal) {
      headerBal.textContent = balance.toFixed(2);
    }
  }

  function updateBetEcho(){
    els.betEcho.textContent = (isDemoMode ? 'DEMO ' : '') + currencySymbol + ' ' + state.bet.toFixed(2);
  }

  // Initial balance renders
  updateBalanceDisplay();
  updateBetEcho();

  function selectTrack(risk){
    if (state.inRound) return;
    state.risk = risk;
    engine.setRisk(risk);
    renderer.setEngine(engine);
    els.trackList.querySelectorAll('.track-card').forEach(card => {
      card.classList.toggle('selected', Number(card.dataset.risk) === risk);
    });
    updateDots();
    els.resultBox.textContent = '0.00';
    els.collectBtn.disabled = true;
    els.spinBtn.disabled = false;
    
    // Set matching default card image in reel box
    els.reelCardImg.src = `/assets/image/cashmeifyoucan/${riskToCard[risk]}.png`;
    els.reelCrossOverlay.style.opacity = '0';
    els.reelContainer.classList.remove('match-success', 'match-fail');
  }

  els.trackList.querySelectorAll('.track-card').forEach(card => {
    card.addEventListener('click', () => {
      soundCtrl.playClick();
      selectTrack(Number(card.dataset.risk));
    });
  });
  selectTrack(3);

  els.betMinus.addEventListener('click', () => {
    if (state.inRound) return;
    soundCtrl.playClick();
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.max(0, idx-1)];
    els.betDisplay.textContent = state.bet.toFixed(2);
    updateBetEcho();
  });
  els.betPlus.addEventListener('click', () => {
    if (state.inRound) return;
    soundCtrl.playClick();
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.min(BET_STEPS.length-1, idx+1)];
    els.betDisplay.textContent = state.bet.toFixed(2);
    updateBetEcho();
  });

  function currentWinAmount(){
    return (engine.currentMultiplier() * state.bet);
  }

  function lockTrackUI(locked){
    els.trackList.querySelectorAll('.track-card').forEach(card => {
      card.classList.toggle('disabled', locked);
    });
    els.betMinus.disabled = locked;
    els.betPlus.disabled = locked;
  }

  // Spinning Card animation triggers
  function startReelSpin() {
    els.reelContainer.classList.remove('match-success', 'match-fail');
    els.reelContainer.classList.add('spinning');
    els.reelCrossOverlay.style.opacity = '0';
    
    let spinIdx = 0;
    state.spinInterval = setInterval(() => {
      spinIdx = (spinIdx + 1) % reelImages.length;
      els.reelCardImg.src = reelImages[spinIdx];
    }, 60);
  }

  function stopReelSpin(targetCardNum, isWin) {
    clearInterval(state.spinInterval);
    els.reelContainer.classList.remove('spinning');
    
    els.reelCardImg.src = `/assets/image/cashmeifyoucan/${targetCardNum}.png`;
    
    if (isWin) {
      els.reelContainer.classList.add('match-success');
    } else {
      els.reelContainer.classList.add('match-fail');
      els.reelCrossOverlay.style.opacity = '1';
    }
  }

  async function doAdvance() {
    if (engine.atTop() || !engine.alive) return;
    soundCtrl.playClick();

    // Deduct bet at the beginning of the round
    if (engine.currentStep === 0) {
      if (balance < state.bet) {
        showToast("Insufficient balance to place bet!", "lose");
        if (state.auto) {
          state.auto = false;
          els.autoBtn.classList.remove('active');
        }
        return;
      }
      balance -= state.bet;
      syncBalance(balance);
      updateBalanceDisplay();
    }

    els.spinBtn.disabled = true;
    els.collectBtn.disabled = true;
    state.inRound = true;
    lockTrackUI(true);

    // Start card reel spin animation
    startReelSpin();

    // Pre-calculate engine outcome
    const outcome = engine.advance();

    // Let the reel spin for a moment (e.g. 650ms)
    await sleep(650);

    if (outcome.survived) {
      // STOP SPIN - Win: Stopped card MUST match track selected number
      stopReelSpin(riskToCard[state.risk], true);
      
      // Cheerful "tung tung" sound on match
      soundCtrl.playTungTung();

      // Stairs smooth downward scroll animation
      await new Promise(res => renderer.animateClimbTo(engine.currentStep, res));
      renderer.flashWin();
      els.resultBox.textContent = currentWinAmount().toFixed(2);
      updateDots();
      
      if (outcome.atTop) {
        await sleep(window.__turbo ? 120 : 400);
        
        // Auto Collect on top rung reached
        const win = currentWinAmount();
        balance += win;
        syncBalance(balance);
        updateBalanceDisplay();
        soundCtrl.playCollect();
        showToast(`Top rung reached! Won ${currencySymbol} ${win.toFixed(2)}`, "win");
        
        finishRound(true);
      } else {
        els.spinBtn.disabled = false;
        els.collectBtn.disabled = false;
        state.inRound = false;
      }
    } else {
      // STOP SPIN - Lose: Stopped card is a mismatch
      const mismatchPool = [1, 2, 3, 4, 5].filter(num => num !== riskToCard[state.risk]);
      const targetMismatch = mismatchPool[Math.floor(Math.random() * mismatchPool.length)];
      stopReelSpin(targetMismatch, false);

      soundCtrl.playBust();
      renderer.flashBust();
      els.resultBox.textContent = '0.00';
      await sleep(window.__turbo ? 200 : 550);
      finishRound(false);
    }
  }

  function finishRound(won){
    state.inRound = false;
    lockTrackUI(false);
    els.spinBtn.disabled = false;
    els.collectBtn.disabled = true;
    setTimeout(() => {
      engine.reset();
      renderer.setEngine(engine);
      els.resultBox.textContent = '0.00';
      updateDots();
      
      // Reset card visual to matching selected track
      els.reelCardImg.src = `/assets/image/cashmeifyoucan/${riskToCard[state.risk]}.png`;
      els.reelCrossOverlay.style.opacity = '0';
      els.reelContainer.classList.remove('match-success', 'match-fail');

      if (state.auto) doAdvance();
    }, window.__turbo ? 250 : 900);
  }

  function doCollect() {
    if (!engine.alive || engine.currentStep === 0) return;
    soundCtrl.playCollect();
    renderer.flashWin();
    
    const win = currentWinAmount();
    balance += win;
    syncBalance(balance);
    updateBalanceDisplay();
    
    showToast(`Collected ${currencySymbol} ${win.toFixed(2)}`, "win");
    finishRound(true);
  }

  els.spinBtn.addEventListener('click', doAdvance);
  els.collectBtn.addEventListener('click', doCollect);

  // Auto spin mapping
  els.autoBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    state.auto = !state.auto;
    els.autoBtn.classList.toggle('active', state.auto);
    if (state.auto && !state.inRound) {
      doAdvance();
    }
  });

  els.soundBtn.addEventListener('click', () => {
    state.sound = !state.sound;
    els.soundBtn.classList.toggle('active', !state.sound);
    soundCtrl.toggle(!state.sound);
    soundCtrl.init();
    soundCtrl.playClick();
  });

  els.turboBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    window.__turbo = !window.__turbo;
    els.turboBtn.classList.toggle('active', window.__turbo);
  });

  function sleep(ms){ return new Promise(res => setTimeout(res, ms)); }
})();
</script>
</body>
</html>
