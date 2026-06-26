<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Western Vault — Golden Reels</title>
<!-- Google Fonts for premium typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   WESTERN VAULT — green translucent theme
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
   SLOT CABINET FRAMEWORK LAYOUT
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

/* Background video replaces the static .backdrop */
.backdrop{
  position:absolute; inset:0; z-index:0;
  background:#0d0701; /* fallback color while video loads */
}
.bg-video{
  position:absolute; inset:0; z-index:0;
  width:100%; height:100%;
  object-fit:cover;
  opacity: 0.38;
  filter: brightness(0.55) saturate(0.85) contrast(1.1) sepia(0.25);
  pointer-events:none;
  will-change: transform;
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
  padding:8px 12px 8px;
  background: linear-gradient(155deg, rgba(18, 10, 4, 0.88), rgba(8, 4, 1, 0.95) 55%, rgba(18, 10, 4, 0.88));
  box-shadow:0 12px 30px var(--shadow), inset 0 0 0 2px rgba(180, 120, 40, 0.25), inset 0 0 20px rgba(0,0,0,0.9);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.table{
  position: relative;
  width: 100%;
}

/* ---------------- reel area wrapper (spin btn can overflow) ---------------- */
.reel-area-wrap{
  position: relative;
  width: 100%;
  padding-right: 48px; /* space for the spin button sticking out */
}

/* ---------------- reel area ---------------- */
.reel-area{
  position:relative;
  border-radius:12px;
  overflow:hidden;
  background:#0a0602;
  box-shadow:inset 0 0 0 3px rgba(202, 162, 79, 0.65), inset 0 10px 24px rgba(0,0,0,.9), inset 0 -10px 24px rgba(0,0,0,.9);
  aspect-ratio: 5/3.1;
  max-height: clamp(160px, 45vh, 300px);
  width: 100%;
}
.vault-art{ position:absolute; inset:0; z-index:0; display:none; }

.corner-btn{
  position:absolute; z-index:5;
  width:34px; height:34px; border-radius:50%;
  border:2px solid #ffd76a;
  background:radial-gradient(circle at 35% 30%, #5a3a10 0%, #2a1505 70%, #140b03 100%);
  color:#ffd76a;
  display:flex; align-items:center; justify-content:center;
  cursor:pointer;
  box-shadow:0 4px 8px rgba(0,0,0,0.65), inset 0 1px 3px rgba(255,215,100,0.25);
  transition:transform .1s, filter .15s;
  font-size: 13px;
}
.corner-btn:hover{ filter:brightness(1.25); }
.corner-btn:active{ transform:scale(.9); }
.corner-btn.active{ border-color:#5be88a; color:#5be88a; }
.corner-btn.menu{ top:8px; left:6px; }
.corner-btn.turbo{ top:8px; right:6px; }
.corner-btn.autospin{ top:48px; right:6px; }
.corner-btn.fav{ bottom:8px; left:6px; }
.corner-btn.paytable{ bottom:8px; right:6px; }

.reel-grid{
  position:relative; z-index:2;
  display:grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: repeat(3, 1fr);
  gap:3px;
  width:76%;
  height:78%;
  margin:0 auto;
  top:11%;
  padding:4px;
  border-radius:8px;
  background:rgba(5, 3, 1, 0.5);
  box-shadow:0 0 0 3px rgba(202, 162, 79, 0.65), 0 8px 24px rgba(0,0,0,0.7);
  backdrop-filter: blur(2px);
}
.cell{
  position:relative;
  border-radius:5px;
  display:flex; align-items:center; justify-content:center;
  overflow:hidden;
  background:linear-gradient(160deg, rgba(35, 22, 8, 0.8), rgba(15, 8, 2, 0.88));
  border: 1px solid rgba(202, 162, 79, 0.2);
  transition:filter .2s, opacity .2s, box-shadow .2s;
}
.cell img{
  width:88%;
  height:88%;
  object-fit:contain;
  transition:filter .2s ease, transform .2s ease;
}
.cell.dim img{ filter:grayscale(0.7) brightness(0.35) opacity(0.55); }
.cell.win{
  box-shadow:inset 0 0 0 2px #ffd76a, 0 0 14px rgba(255,215,106,.7);
  background:linear-gradient(160deg, rgba(60, 40, 5, 0.7), rgba(25, 14, 2, 0.85));
}
.cell.win img{ filter:drop-shadow(0 0 5px rgba(255,215,106,0.85)); transform:scale(1.07); }
.cell.spinning img{ filter: blur(2px); transform: scale(0.96); }

.win-banner{
  position:absolute; left:50%; bottom:6%;
  transform:translate(-50%,12px);
  z-index:6;
  padding:4px 18px;
  border-radius:8px;
  font-family:Georgia,serif;
  font-weight:800; font-size:18px;
  color:#fff7df;
  background:linear-gradient(180deg, rgba(40, 25, 10, 0.95), rgba(15, 8, 3, 0.98));
  box-shadow:0 0 0 1px var(--gold), 0 6px 16px rgba(0,0,0,.5);
  opacity:0;
  transition:opacity .25s, transform .25s;
  pointer-events:none;
}
.win-banner.show{ opacity:1; transform:translate(-50%,0); }

/* ---------------- spin button: absolutely positioned right of reel-area-wrap ---------------- */
.spin-btn {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  width: 72px;
  height: 72px;
  border-radius: 50%;
  border: 4px solid #fff3cf;
  background: radial-gradient(circle at 36% 28%, #f0e060 0%, #d9a443 40%, #8a5e1f 75%, #4a2e08 100%);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 6px 18px rgba(0,0,0,0.7), inset 0 2px 5px rgba(255,255,255,0.25), 0 0 14px rgba(217,164,67,0.5);
  transition: filter 0.15s ease;
  outline: none;
}
.spin-btn:hover { filter: brightness(1.15); }
.spin-btn:active { filter: brightness(0.88); }
.spin-btn svg{ width:26px; height:26px; fill:#fff; }
.spin-btn:disabled{ opacity:.5; cursor:not-allowed; filter:grayscale(.4); }

/* ---------------- bottom bet + balance bar ---------------- */
.bet-row{
  display:flex; align-items:center; gap:6px; justify-content:center;
  margin-top:6px;
}
.bet-box{
  flex:0 0 auto;
  display:flex; align-items:center; gap:8px;
  padding:5px 12px;
  border-radius:8px;
  background:linear-gradient(180deg, rgba(20, 42, 28, 0.85), rgba(8, 18, 12, 0.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.35), inset 0 2px 4px rgba(0,0,0,.55);
}
.bet-box label{ font-size:9px; letter-spacing:1px; text-transform:uppercase; color:var(--gold-lt); opacity:.7; }
.bet-box span{ font-size:14px; font-weight:700; color:#fff7df; font-family:Georgia,serif; min-width:46px; text-align:center; display:inline-block; }
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

.balance-bar{
  display:flex; justify-content:space-between; align-items:center;
  margin-top:8px;
  padding:6px 12px;
  border-radius:8px;
  background:linear-gradient(180deg, rgba(16, 32, 22, 0.85), rgba(6, 12, 8, 0.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.3);
  font-size:12px; font-weight:700; color:var(--gold-lt);
}
.balance-bar .chip{ display:flex; align-items:center; gap:6px; }
.balance-bar svg{ width:14px; height:14px; }

.paytable-pop{
  position:absolute; z-index:8;
  bottom:42px; right:6px;
  width:200px;
  padding:8px 10px;
  border-radius:10px;
  background:linear-gradient(160deg, rgba(20, 42, 28, 0.95), rgba(6, 12, 8, 0.98));
  box-shadow:0 0 0 1px var(--gold), 0 8px 20px rgba(0,0,0,.6);
  font-size:10px;
  opacity:0; transform:translateY(6px);
  pointer-events:none;
  transition:opacity .2s, transform .2s;
}
.paytable-pop.show{ opacity:1; transform:translateY(0); pointer-events:auto; }
.paytable-pop h4{ margin:0 0 4px; font-size:10px; letter-spacing:0.5px; color:var(--gold-br); text-transform:uppercase; }
.paytable-pop .row{ display:flex; align-items:center; justify-content:space-between; gap:4px; padding:2px 0; border-top:1px solid rgba(255,243,207,.08); }
.paytable-pop .row svg{ width:16px; height:16px; }
.paytable-pop .row span{ opacity:.8; }

.footer-note{
  margin-top:6px; font-size:10px; color:rgba(255,247,223,.45);
  text-align:center; letter-spacing:.5px;
}

/* Toast Message overlay styling */
.toast-msg {
  position: fixed; top: 85px; left: 50%; transform: translateX(-50%);
  background: #08120d; border: 2px solid var(--gold);
  border-radius: 10px; padding: 12px 28px;
  font-family: 'Exo 2', sans-serif; font-size: 14px; font-weight: 700;
  color: #fff; letter-spacing: 1px; z-index: 9999;
  animation: toastIn 0.3s ease; white-space: nowrap;
  box-shadow: 0 4px 20px rgba(0,0,0,0.8);
}
.toast-msg.win { border-color: var(--green); color: var(--green-lt); background: #06160d; }
.toast-msg.lose { border-color: var(--ember); color: #ffa080; background: #200a05; }
@keyframes toastIn { from { opacity:0; transform: translateX(-50%) translateY(-10px); } to { opacity:1; transform: translateX(-50%) translateY(0); } }

/* =============== BET DEMO MODAL =============== */
.bet-modal-overlay{
  position:fixed; inset:0; z-index:9000;
  background:rgba(0,0,0,0.55);
  display:flex; align-items:center; justify-content:center;
  opacity:0; pointer-events:none;
  transition:opacity .2s;
}
.bet-modal-overlay.show{ opacity:1; pointer-events:auto; }
.bet-modal{
  background:linear-gradient(160deg, #7a0c10 0%, #5a0a0d 50%, #3d0608 100%);
  border-radius:14px;
  min-width:320px; max-width:420px;
  width:90vw;
  padding:0;
  box-shadow:0 12px 40px rgba(0,0,0,0.8), inset 0 0 0 1px rgba(255,255,255,0.08);
  overflow:hidden;
  transform:scale(0.92);
  transition:transform .2s;
}
.bet-modal-overlay.show .bet-modal{ transform:scale(1); }
.bet-modal-header{
  display:flex; align-items:center; justify-content:space-between;
  padding:14px 18px 10px;
  border-bottom:1px solid rgba(255,255,255,0.08);
}
.bet-modal-header h3{
  margin:0;
  font-family:Georgia,serif;
  font-size:15px; font-weight:800;
  letter-spacing:1.5px;
  color:#fff;
  text-transform:uppercase;
}
.bet-modal-close{
  width:28px; height:28px; border-radius:50%;
  border:none; background:transparent;
  color:rgba(255,255,255,0.55); font-size:18px;
  cursor:pointer; display:flex; align-items:center; justify-content:center;
  transition:color .15s;
}
.bet-modal-close:hover{ color:#fff; }
.bet-modal-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:8px;
  padding:14px 14px 18px;
}
.bet-chip{
  padding:10px 6px;
  border-radius:50px;
  border:2px solid rgba(255,255,255,0.15);
  background:rgba(80,5,8,0.7);
  color:rgba(255,255,255,0.85);
  font-family:Georgia,serif;
  font-size:14px; font-weight:700;
  text-align:center;
  cursor:pointer;
  transition:all .15s;
  box-shadow:0 2px 8px rgba(0,0,0,0.35);
}
.bet-chip:hover{
  background:rgba(120,10,15,0.85);
  border-color:rgba(255,255,255,0.3);
  color:#fff;
  transform:translateY(-1px);
}
.bet-chip.selected{
  background:#fff;
  border-color:#fff;
  color:#3d0608;
  box-shadow:0 4px 14px rgba(255,255,255,0.25);
}

/* ---- Coin bet button inside reel area (bottom-right corner) ---- */
.coin-bet-btn{
  position:absolute;
  bottom:10px; right:10px;
  z-index:6;
  width:38px; height:38px; border-radius:50%;
  border:2px solid #ffd76a;
  background:radial-gradient(circle at 35% 30%, #f0d060 0%, #caa24f 50%, #7a4e12 100%);
  display:flex; align-items:center; justify-content:center;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(0,0,0,0.6), inset 0 1px 3px rgba(255,255,255,0.3);
  transition:filter .15s, transform .1s;
}
.coin-bet-btn:hover{ filter:brightness(1.2); }
.coin-bet-btn:active{ transform:scale(0.9); }
.coin-bet-btn svg{ width:20px; height:20px; }
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
        <span>Western Heist</span>
      </div>
      <div class="header-title">WESTERN HEIST</div>
      <div class="header-actions">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" class="search-input" value="Western Heist" readonly>
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
        <img src="/assets/image/western.webp" alt="Game Badge" style="border-radius: 4px;">
        <span class="game-title">Western Heist</span>
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
      <div class="backdrop">
        <!-- Background video loop — western desert atmosphere -->
        <video
          class="bg-video"
          id="bgVideo"
          autoplay
          muted
          loop
          playsinline
          preload="auto"
          poster="/assets/image/WesternHeist/bg.png"
        >
          <!-- Free western/desert looping videos from Pexels CDN -->
          <source src="https://videos.pexels.com/video-files/4763825/4763825-uhd_2560_1440_25fps.mp4" type="video/mp4">
          <source src="https://videos.pexels.com/video-files/3570659/3570659-hd_1920_1080_30fps.mp4" type="video/mp4">
          <!-- Fallback: browser will show poster if video can't load -->
        </video>
      </div>
      <canvas id="bgFxCanvas"></canvas>

      <main class="stage">
        <div class="title-bar" style="margin-bottom: 6px;">
          <h1 style="font-family: Georgia, serif; font-style: italic; font-size: 26px; letter-spacing: 2px; margin: 0; background: linear-gradient(180deg, #fff3cf, #d9a443); -webkit-background-clip: text; background-clip: text; color: transparent; filter: drop-shadow(0 0 10px rgba(217,164,67,.5));">WESTERN VAULT</h1>
          <p style="margin: 2px 0 0; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--gold-lt); opacity: .7;">GOLDEN REELS</p>
        </div>

        <div class="game-frame">
          <div class="table">

            <div class="reel-area-wrap">
              <div class="reel-area" id="reelArea">
                <svg class="vault-art" viewBox="0 0 100 62" preserveAspectRatio="xMidYMid slice">
                  <defs>
                    <radialGradient id="vaultGlow" cx="50%" cy="38%" r="55%">
                      <stop offset="0%" stop-color="#142c1b"/>
                      <stop offset="55%" stop-color="#081810"/>
                      <stop offset="100%" stop-color="#030805"/>
                    </radialGradient>
                    <radialGradient id="doorRing" cx="50%" cy="38%" r="30%">
                      <stop offset="0%" stop-color="#ffe9b0"/>
                      <stop offset="60%" stop-color="#caa24f"/>
                      <stop offset="100%" stop-color="#5a3a10"/>
                    </radialGradient>
                  </defs>
                  <rect width="100" height="62" fill="url(#vaultGlow)"/>
                  <circle cx="50" cy="22" r="17" fill="none" stroke="url(#doorRing)" stroke-width="2.4" opacity="0.55"/>
                  <circle cx="50" cy="22" r="11" fill="none" stroke="#caa24f" stroke-width="1.4" opacity="0.4"/>
                  <g opacity="0.35" stroke="#caa24f" stroke-width="1">
                    <line x1="50" y1="5" x2="50" y2="39"/>
                    <line x1="33" y1="22" x2="67" y2="22"/>
                    <line x1="38" y1="10" x2="62" y2="34"/>
                    <line x1="62" y1="10" x2="38" y2="34"/>
                  </g>
                  <g opacity="0.3" fill="#8a5e1f">
                    <ellipse cx="8" cy="58" rx="14" ry="5"/>
                    <ellipse cx="92" cy="58" rx="14" ry="5"/>
                    <ellipse cx="10" cy="52" rx="11" ry="4"/>
                    <ellipse cx="90" cy="52" rx="11" ry="4"/>
                  </g>
                </svg>

                <button class="corner-btn menu" id="menuBtn" title="Menu">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <button class="corner-btn turbo" id="turboBtn" title="Turbo spin">
                  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8z"/></svg>
                </button>
                <button class="corner-btn autospin" id="autoBtn" title="Autoplay">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M20 11A8 8 0 1 0 18 6"/><path d="M20 4v5h-5"/></svg>
                </button>
                <button class="corner-btn fav" id="favBtn" title="Favorite">
                  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 14.6 9 22 9 16 13.6 18 21 12 16.7 6 21 8 13.6 2 9 9.4 9z"/></svg>
                </button>
                <button class="corner-btn paytable" id="payBtn" title="Paytable">
                  <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="6" cy="17" r="3"/><circle cx="12" cy="13" r="3"/><circle cx="18" cy="9" r="3"/></svg>
                </button>

                <div class="reel-grid" id="reelGrid"></div>

                <div class="win-banner" id="winBanner">0.00</div>

                <!-- Coin bet button - opens BET modal -->
                <button class="coin-bet-btn" id="coinBetBtn" title="Change Bet">
                  <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9.5" fill="#caa24f" stroke="#fff3cf" stroke-width="1"/>
                    <circle cx="12" cy="12" r="6.5" fill="none" stroke="rgba(255,255,255,0.35)" stroke-width="0.8"/>
                    <text x="12" y="16" text-anchor="middle" font-family="Georgia,serif" font-weight="800" font-size="9" fill="#3a1505">$</text>
                  </svg>
                </button>

                <div class="paytable-pop" id="paytablePop">
                  <h4>Symbol Values ×3 / ×4 / ×5</h4>
                  <div id="paytableList"></div>
                </div>
              </div><!-- end reel-area -->

              <!-- Spin button sits OUTSIDE reel-area (so overflow:hidden doesn't clip it) -->
              <button class="spin-btn" id="spinBtn" title="Spin">
                <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="#fff"/></svg>
              </button>
            </div><!-- end reel-area-wrap -->

          </div><!-- end table -->


          <!-- BET DEMO MODAL -->
          <div class="bet-modal-overlay" id="betModalOverlay">
            <div class="bet-modal">
              <div class="bet-modal-header">
                <h3 id="betModalTitle">BET DEMO</h3>
                <button class="bet-modal-close" id="betModalClose">✕</button>
              </div>
              <div class="bet-modal-grid" id="betModalGrid"></div>
            </div>
          </div>


          <div class="bet-row">
            <button class="stepper" id="betMinus">–</button>
            <div class="bet-box">
              <label>bet</label>
              <span id="betDisplay">1.00</span>
            </div>
            <button class="stepper" id="betPlus">+</button>
          </div>

          <div class="balance-bar">
            <div class="chip">
              <svg viewBox="0 0 24 24" fill="#ffd76a"><circle cx="12" cy="12" r="9"/></svg>
              <span id="balanceDisplay">DEMO 999,995.00</span>
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
        <i class="fas fa-headset" style="color: #4a7a5d; cursor: pointer; font-size:14px;" title="Customer Support"></i>
      </div>
    </footer>
  </div>
</div>

<script>
/* ============================================================
   WESTERN VAULT — slot engine + DOM reel renderer + FX
   ============================================================ */

/* ----------------- WEB AUDIO SYNTHESIZER ----------------- */
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
  playReelTick() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    const osc = this.ctx.createOscillator();
    const gain = this.ctx.createGain();
    osc.connect(gain);
    gain.connect(this.ctx.destination);
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(220, now);
    osc.frequency.setValueAtTime(120, now + 0.03);
    gain.gain.setValueAtTime(0.05, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.04);
    osc.start(now);
    osc.stop(now + 0.04);
  }
  playWinChime() {
    if (this.muted) return;
    this.init();
    if (!this.ctx) return;
    const now = this.ctx.currentTime;
    const freqs = [523.25, 659.25, 783.99, 1046.50, 1318.51];
    freqs.forEach((freq, idx) => {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, now + idx * 0.08);
      gain.gain.setValueAtTime(0.06, now + idx * 0.08);
      gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.25);
      osc.start(now + idx * 0.08);
      osc.stop(now + idx * 0.08 + 0.28);
    });
  }
}
const soundCtrl = new SoundController();

/* ------------------ DATABASE INTEGRATION ------------------ */
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
      console.log('Balance synced successfully:', newBalance);
    }
  })
  .catch(err => console.error('Error syncing balance:', err));
}

// Fullscreen helper
function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(err => {});
  } else {
    document.exitFullscreen();
  }
}

/* -------- IMAGE PATHS for WesternHeist symbols -------- */
const IMG_BASE = '/assets/image/WesternHeist/';

// Maps symbol id -> image filename
const SYM_IMG = {
  'A':        IMG_BASE + '1.png',
  'Q':        IMG_BASE + '2.png',
  'gemBlue':  IMG_BASE + '3.png',
  'K':        IMG_BASE + '4.png',
  'gemGreen': IMG_BASE + '5.png',
  'J':        IMG_BASE + '6.png',
  'gemPurple':IMG_BASE + '7.png',
  'wild':     IMG_BASE + '8.png',
  'moneybag': IMG_BASE + '9.png',
  'pistols':  IMG_BASE + '10.png',
};

function symIMG(id){
  const src = SYM_IMG[id] || (IMG_BASE + '1.png');
  return `<img src="${src}" alt="${id}" draggable="false">`;
}

const SYMS = [
  { id:'A',         weight:18, pay:{3:0.4,4:1,5:3},     render:()=>symIMG('A') },
  { id:'K',         weight:18, pay:{3:0.4,4:1,5:3},     render:()=>symIMG('K') },
  { id:'Q',         weight:16, pay:{3:0.3,4:0.8,5:2.5}, render:()=>symIMG('Q') },
  { id:'J',         weight:16, pay:{3:0.3,4:0.8,5:2.5}, render:()=>symIMG('J') },
  { id:'gemBlue',   weight:10, pay:{3:0.8,4:2,5:6},     render:()=>symIMG('gemBlue') },
  { id:'gemGreen',  weight:10, pay:{3:0.8,4:2,5:6},     render:()=>symIMG('gemGreen') },
  { id:'gemPurple', weight:8,  pay:{3:1,4:3,5:8},       render:()=>symIMG('gemPurple') },
  { id:'pistols',   weight:6,  pay:{3:2,4:6,5:20},      render:()=>symIMG('pistols') },
  { id:'moneybag',  weight:4,  pay:{3:4,4:12,5:40},     render:()=>symIMG('moneybag') },
  { id:'wild',      weight:2,  pay:{3:5,4:15,5:75},     render:()=>symIMG('wild'), isWild:true },
];
const TOTAL_WEIGHT = SYMS.reduce((s,x)=>s+x.weight,0);
const SYM_BY_ID = Object.fromEntries(SYMS.map(s=>[s.id,s]));

function pickSymbol(){
  let r = Math.random()*TOTAL_WEIGHT;
  for (const s of SYMS){ r -= s.weight; if (r<=0) return s.id; }
  return SYMS[0].id;
}

/* -------------------- SLOT ENGINE -------------------- */
const REELS = 5, ROWS = 3;

function spinGrid(){
  const grid = [];
  for (let c=0;c<REELS;c++){
    const col = [];
    for (let r=0;r<ROWS;r++) col.push(pickSymbol());
    grid.push(col);
  }
  return grid;
}

function evaluateWins(grid){
  const wins = [];
  for (let r=0;r<ROWS;r++){
    const first = grid[0][r];
    let symId = first;
    if (SYM_BY_ID[first].isWild){
      for (let c=1;c<REELS;c++){
        if (!SYM_BY_ID[grid[c][r]].isWild){ symId = grid[c][r]; break; }
      }
    }
    let count = 0;
    const cells = [];
    for (let c=0;c<REELS;c++){
      const cur = grid[c][r];
      const matches = cur === symId || SYM_BY_ID[cur].isWild;
      if (matches){ count++; cells.push([c,r]); } else break;
    }
    if (count >= 3){
      const payTable = SYM_BY_ID[symId].pay;
      const mult = payTable[Math.min(count,5)] || 0;
      if (mult > 0) wins.push({ row:r, count, symId, cells, mult });
    }
  }
  return wins;
}

/* ---------------- MONEY BACKDROP EFFECT ---------------- */
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
    this.w = window.innerWidth; this.h = window.innerHeight;
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
    ctx.save(); ctx.scale(this.dpr,this.dpr); ctx.clearRect(0,0,this.w,this.h);
    this.items.forEach(p => {
      p.sway += dt*0.6;
      p.y -= p.vy*dt;
      p.x += p.vx*dt + Math.sin(p.sway)*0.4;
      p.rot += p.vr*dt;
      if (p.y < -60 || p.x < -60 || p.x > this.w+60) Object.assign(p, this._spawn(false));
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
      grad.addColorStop(0,'#fff3cf'); grad.addColorStop(0.5,'#d9a443'); grad.addColorStop(1,'#8a5e1f');
      ctx.fillStyle = grad; ctx.strokeStyle = 'rgba(255,255,255,0.5)'; ctx.lineWidth = 1;
      this._roundRect(ctx, -w/2,-h/2,w,h, h*0.18); ctx.fill(); ctx.stroke();
      ctx.fillStyle = 'rgba(58,21,5,0.6)';
      ctx.beginPath(); ctx.arc(0,0,h*0.22,0,Math.PI*2); ctx.fill();
    } else {
      ctx.font = `bold ${p.size}px Georgia, serif`;
      ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
      ctx.fillStyle = '#ffd76a';
      ctx.fillText('$', 0, 0);
    }
    ctx.restore();
  }
  _roundRect(ctx,x,y,w,h,r){
    ctx.beginPath();
    ctx.moveTo(x+r,y); ctx.arcTo(x+w,y,x+w,y+h,r); ctx.arcTo(x+w,y+h,x,y+h,r);
    ctx.arcTo(x,y+h,x,y,r); ctx.arcTo(x,y,x+w,y,r); ctx.closePath();
  }
}

/* ============================================================
   BET MODAL CONTROLLER
   ============================================================ */
function openBetModal(currentBet, isDemoMode, onSelect) {
  const BET_OPTIONS = [0.20, 0.40, 1, 2, 3, 4, 6, 10, 16, 20, 40, 100, 150, 200];
  const overlay = document.getElementById('betModalOverlay');
  const grid = document.getElementById('betModalGrid');
  const title = document.getElementById('betModalTitle');
  const closeBtn = document.getElementById('betModalClose');

  title.textContent = isDemoMode ? 'BET DEMO' : 'BET AMOUNT';

  // Build chips
  grid.innerHTML = '';
  BET_OPTIONS.forEach(val => {
    const chip = document.createElement('button');
    chip.className = 'bet-chip' + (val === currentBet ? ' selected' : '');
    chip.textContent = val % 1 === 0 ? val.toString() : val.toFixed(2);
    chip.addEventListener('click', () => {
      onSelect(val);
      closeBetModal();
    });
    grid.appendChild(chip);
  });

  overlay.classList.add('show');

  // Close on overlay background click
  overlay._overlayHandler = (e) => {
    if (e.target === overlay) closeBetModal();
  };
  overlay.addEventListener('click', overlay._overlayHandler);

  closeBtn._closeHandler = () => closeBetModal();
  closeBtn.addEventListener('click', closeBtn._closeHandler);
}

function closeBetModal() {
  const overlay = document.getElementById('betModalOverlay');
  const closeBtn = document.getElementById('betModalClose');
  overlay.classList.remove('show');
  if (overlay._overlayHandler) {
    overlay.removeEventListener('click', overlay._overlayHandler);
    overlay._overlayHandler = null;
  }
  if (closeBtn._closeHandler) {
    closeBtn.removeEventListener('click', closeBtn._closeHandler);
    closeBtn._closeHandler = null;
  }
}

/* ------------------ MAIN LOGIC GLUE ------------------ */
(() => {
  const $ = sel => document.querySelector(sel);
  const els = {
    bgFxCanvas: $('#bgFxCanvas'),
    reelGrid: $('#reelGrid'),
    winBanner: $('#winBanner'),
    spinBtn: $('#spinBtn'),
    betMinus: $('#betMinus'),
    betPlus: $('#betPlus'),
    betDisplay: $('#betDisplay'),
    betEcho: $('#betEcho'),
    balanceDisplay: $('#balanceDisplay'),
    turboBtn: $('#turboBtn'),
    autoBtn: $('#autoBtn'),
    favBtn: $('#favBtn'),
    payBtn: $('#payBtn'),
    paytablePop: $('#paytablePop'),
    paytableList: $('#paytableList'),
    menuBtn: $('#menuBtn'),
    coinBetBtn: $('#coinBetBtn'),
  };

  const BET_STEPS = [0.20, 0.40, 1, 2, 3, 4, 6, 10, 16, 20, 40, 100, 150, 200];
  const state = {
    bet: 1,
    turbo: false,
    auto: false,
    spinning: false,
  };

  new MoneyBackdrop(els.bgFxCanvas);

  // ---- Background video autoplay ----
  const bgVideo = document.getElementById('bgVideo');
  if (bgVideo) {
    // Attempt autoplay; on failure (browser policy), fallback to bg.png
    bgVideo.play().catch(() => {
      bgVideo.style.display = 'none';
      document.querySelector('.backdrop').style.cssText +=
        'background-image:url("/assets/image/WesternHeist/bg.png");background-size:cover;background-position:center;filter:brightness(0.5);';
    });
    // Error fallback if video source unavailable
    bgVideo.addEventListener('error', () => {
      bgVideo.style.display = 'none';
      document.querySelector('.backdrop').style.cssText +=
        'background-image:url("/assets/image/WesternHeist/bg.png");background-size:cover;background-position:center;filter:brightness(0.5);';
    });
    // Re-attempt play on first user interaction (mobile/strict browsers)
    const tryPlay = () => { bgVideo.play().catch(()=>{}); document.removeEventListener('click', tryPlay); };
    document.addEventListener('click', tryPlay, { once: true });
  }

  // sound toggle off initially (user interacts to start Web Audio)
  soundCtrl.toggle(false);


  // build static grid
  const cells = [];
  for (let r=0;r<ROWS;r++){
    cells.push([]);
    for (let c=0;c<REELS;c++){
      const div = document.createElement('div');
      div.className = 'cell';
      div.dataset.r = r; div.dataset.c = c;
      els.reelGrid.appendChild(div);
      cells[r].push(div);
    }
  }
  els.reelGrid.style.gridAutoFlow = 'row';

  function paintCell(div, symId){
    div.innerHTML = SYM_BY_ID[symId].render();
  }

  function buildPaytable(){
    els.paytableList.innerHTML = SYMS.map(s => `
      <div class="row">
        ${s.render()}
        <span>${(s.pay[3]).toFixed(1)} / ${(s.pay[4]).toFixed(1)} / ${(s.pay[5]).toFixed(1)}</span>
      </div>`).join('');
  }
  buildPaytable();

  // initial idle grid
  let currentGrid = spinGrid();
  for (let r=0;r<ROWS;r++) for (let c=0;c<REELS;c++) paintCell(cells[r][c], currentGrid[c][r]);

  function updateMoneyDisplay(){
    els.balanceDisplay.textContent = (isDemoMode ? 'DEMO ' : '') + currencySymbol + balance.toFixed(2);
    els.betEcho.textContent = (isDemoMode ? 'DEMO ' : '') + currencySymbol + state.bet.toFixed(2);
  }
  updateMoneyDisplay();

  els.betMinus.addEventListener('click', () => {
    if (state.spinning) return;
    soundCtrl.playClick();
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.max(0, idx-1)];
    els.betDisplay.textContent = state.bet.toFixed(2);
    updateMoneyDisplay();
  });
  els.betPlus.addEventListener('click', () => {
    if (state.spinning) return;
    soundCtrl.playClick();
    const idx = BET_STEPS.indexOf(state.bet);
    state.bet = BET_STEPS[Math.min(BET_STEPS.length-1, idx+1)];
    els.betDisplay.textContent = state.bet.toFixed(2);
    updateMoneyDisplay();
  });

  function sleep(ms){ return new Promise(res=>setTimeout(res,ms)); }

  async function spinReel(c, finalCol){
    const dur = (state.turbo ? 260 : 600) + c*(state.turbo ? 60 : 140);
    const flickerMs = state.turbo ? 35 : 55;
    const start = performance.now();
    for (let r=0;r<ROWS;r++) cells[r][c].classList.add('spinning');
    while (performance.now() - start < dur){
      for (let r=0;r<ROWS;r++) paintCell(cells[r][c], pickSymbol());
      await sleep(flickerMs);
    }
    soundCtrl.playReelTick();
    for (let r=0;r<ROWS;r++){
      paintCell(cells[r][c], finalCol[r]);
      cells[r][c].classList.remove('spinning');
    }
  }

  function clearCellStates(){
    for (let r=0;r<ROWS;r++) for (let c=0;c<REELS;c++){
      cells[r][c].classList.remove('dim','win');
    }
  }

  function showWinBanner(amount){
    els.winBanner.textContent = currencySymbol + ' ' + amount.toFixed(2);
    els.winBanner.classList.add('show');
  }
  function hideWinBanner(){
    els.winBanner.classList.remove('show');
  }

  async function doSpin(){
    if (state.spinning) return;
    soundCtrl.playClick();
    if (balance < state.bet){
      showToast("Insufficient balance to spin!", "lose");
      state.auto = false;
      els.autoBtn.classList.remove('active');
      return;
    }
    state.spinning = true;
    els.spinBtn.disabled = true;
    hideWinBanner();
    clearCellStates();

    balance -= state.bet;
    syncBalance(balance);
    updateMoneyDisplay();

    const grid = spinGrid();
    const spins = [];
    for (let c=0;c<REELS;c++) spins.push(spinReel(c, grid[c]));
    await Promise.all(spins);

    const wins = evaluateWins(grid);
    if (wins.length){
      const totalMult = wins.reduce((s,w)=>s+w.mult,0);
      const amount = totalMult * state.bet;
      balance += amount;
      syncBalance(balance);
      updateMoneyDisplay();

      // sound trigger
      soundCtrl.playWinChime();

      // dim everything, then highlight winning cells
      for (let r=0;r<ROWS;r++) for (let c=0;c<REELS;c++) cells[r][c].classList.add('dim');
      wins.forEach(w => w.cells.forEach(([c,r]) => {
        cells[r][c].classList.remove('dim');
        cells[r][c].classList.add('win');
      }));
      showWinBanner(amount);
      await sleep(state.turbo ? 500 : 1100);
      clearCellStates();
    }

    state.spinning = false;
    els.spinBtn.disabled = false;
    if (state.auto) doSpin();
  }

  els.spinBtn.addEventListener('click', doSpin);

  els.turboBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    state.turbo = !state.turbo;
    els.turboBtn.classList.toggle('active', state.turbo);
  });
  els.autoBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    state.auto = !state.auto;
    els.autoBtn.classList.toggle('active', state.auto);
    if (state.auto && !state.spinning) doSpin();
  });
  els.favBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    els.favBtn.classList.toggle('active');
  });
  els.payBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    els.paytablePop.classList.toggle('show');
  });

  // Coin bet button → open BET DEMO modal
  if (els.coinBetBtn) {
    els.coinBetBtn.addEventListener('click', () => {
      if (state.spinning) return;
      soundCtrl.playClick();
      openBetModal(state.bet, isDemoMode, (newBet) => {
        state.bet = newBet;
        els.betDisplay.textContent = state.bet % 1 === 0
          ? state.bet.toFixed(2)
          : state.bet.toFixed(2);
        updateMoneyDisplay();
        soundCtrl.playClick();
      });
    });
  }

  els.menuBtn.addEventListener('click', () => {
    soundCtrl.playClick();
    els.paytablePop.classList.remove('show');
  });
  document.addEventListener('click', (e) => {
    if (!els.paytablePop.contains(e.target) && e.target !== els.payBtn && !els.payBtn.contains(e.target)){
      els.paytablePop.classList.remove('show');
    }
  });
})();
</script>
</body>
</html>
