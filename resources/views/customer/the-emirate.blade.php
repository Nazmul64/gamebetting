<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>The Emirate - Slot Game</title>
<!-- Google Fonts for premium typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Outfit','Georgia',serif;}
body{background:#0c1626;overflow-x:hidden;}

/* ===== LAYOUT ===== */
#gameWrapper{
  width:100%;min-height:100vh;
  background:#0c1626;
  display:flex;flex-direction:column;
  position:relative;
}

/* ===== STAR BG CANVAS ===== */
#bgCanvas{
  position:fixed;top:0;left:0;
  width:100%;height:100%;
  pointer-events:none;z-index:0;
}

/* ===== 1XBET LAYOUT PANELS ===== */
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
  font-family: 'Outfit', sans-serif;
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
.topnav .navIcon:hover { color: #f5c842; }

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

.main-layout-container {
  display: flex;
  flex: 1;
  margin-left: 54px;
  margin-top: 50px;
  margin-bottom: 40px;
  background: #0c1626;
  min-height: calc(100vh - 90px);
}
.left-toggle-panel {
  width: 240px;
  background: #0e1e35;
  border-right: 1px solid #1d3354;
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
  background: linear-gradient(135deg, #e85d04, #f5a623);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: bold;
}
.left-toggle-panel .logoName {
  font-size: 15px;
  font-weight: bold;
}
.left-toggle-panel .rmToggle {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  color: #5a8abf;
  margin-top: 10px;
}
.left-toggle-panel .togSwitch {
  width: 34px;
  height: 17px;
  background: #1a3050;
  border-radius: 9px;
  position: relative;
  border: 1px solid #2a5070;
  cursor: pointer;
}
.left-toggle-panel .togDot {
  width: 13px;
  height: 13px;
  background: #3a6090;
  border-radius: 50%;
  position: absolute;
  top: 1px;
  left: 1px;
  transition: left .2s, background .2s;
}
.left-toggle-panel .togSwitch.on .togDot {
  left: 18px;
  background: #f5c842;
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
}

/* ===== TITLE ===== */
#titleArea{text-align:center;position:relative;}
#gameTitle3D{
  font-size:28px;font-weight:bold;
  letter-spacing:3px;
  font-family:'Palatino Linotype','Book Antiqua',serif;
  color:#f5c842;
  text-shadow:
    0 1px 0 #c9a227,
    0 2px 0 #a07800,
    0 3px 0 #806000,
    0 4px 12px rgba(0,0,0,0.7);
  animation:titleFloat 3s ease-in-out infinite;
  display:inline-block;
}
@keyframes titleFloat{
  0%,100%{transform:translateY(0);}
  50%{transform:translateY(-4px);}
}
.jewel{
  display:inline-block;width:8px;height:8px;
  background:radial-gradient(circle at 35% 30%,#a0eaff,#0095cc);
  border-radius:50%;vertical-align:middle;margin:0 8px;
  animation:jewPulse 2s ease-in-out infinite;
}
@keyframes jewPulse{
  0%,100%{opacity:1;transform:scale(1);}
  50%{opacity:0.5;transform:scale(0.6);}
}

/* ===== BALANCE ===== */
#balanceRow{
  display:flex;justify-content:center;align-items:center;
  gap:8px;font-size:12px;color:#5a8abf;
  letter-spacing:1px;text-transform:uppercase;
}
#balDisplay{color:#f5c842;font-size:16px;font-weight:bold;}

/* ===== GAME FRAME ===== */
#gameFrame{
  margin:0 auto;
  width:100%;
  max-width: 800px;
  aspect-ratio: 5 / 3;
  background: url("{{ asset('assets/image/theemirate/bg.jpg') }}") no-repeat center center;
  background-size: 100% 100%;
  border: 3px solid #1a3a6a;
  border-radius: 12px;
  padding: 14px 60px 10px;
  position:relative;
  box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}
.frameGlow{
  position:absolute;inset:0;border-radius:10px;
  border:1px solid rgba(100,180,255,0.12);
  pointer-events:none;
}
/* Arch decorations */
.archLeft,.archRight{
  position:absolute;top:0;width:22px;height:100%;
  background:linear-gradient(90deg,rgba(100,160,220,0.08),transparent);
  pointer-events:none;
}
.archLeft{left:0;border-radius:10px 0 0 10px;}
.archRight{right:0;border-radius:0 10px 10px 0;background:linear-gradient(270deg,rgba(100,160,220,0.08),transparent);}
.frameInfo{
  position:absolute;top:8px;right:12px;
  display:flex;gap:10px;z-index:15;
}
.frameInfoIcon{color:#8ca3c7;font-size:14px;cursor:pointer;user-select:none;}
.frameInfoIcon:hover{color:#f5c842;}

/* ===== REELS ===== */
#reelsGrid{
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:6px;
  width: 100%;
  height: 100%;
  position: relative;
  z-index: 2;
}
.reelCol{display:flex;flex-direction:column;gap:6px;}
.cell{
  aspect-ratio:1;
  background:radial-gradient(ellipse at 30% 25%,rgba(14,42,80,0.6),rgba(4,15,32,0.75));
  border:1.5px solid #1a3a6a;
  border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  position:relative;overflow:visible;
  cursor:pointer;
  transition:border-color .3s,transform .15s;
  user-select:none;
}
.cell::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,0.05) 0%,transparent 50%,rgba(0,0,0,0.2) 100%);
  border-radius:8px;pointer-events:none;z-index:1;
}
.cell:hover{border-color:#f5c842;transform:scale(1.03);}
.cell.win{
  border-color:#ffd54f !important;
  box-shadow: 0 0 25px rgba(255, 213, 79, 0.9), inset 0 0 15px rgba(255, 213, 79, 0.6) !important;
  z-index: 10;
  transform: scale(1.05);
}
.cell.win::before {
  content: '';
  position: absolute;
  top: 0; left: -150%;
  width: 150%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 224, 102, 0.5), rgba(255, 255, 255, 0.8), rgba(255, 224, 102, 0.5), transparent);
  transform: skewX(-20deg);
  animation: shineSweep 1.6s ease-in-out infinite;
  z-index: 4;
  pointer-events: none;
}
.cell.win::after {
  content: '';
  position: absolute;
  inset: -3px;
  border-radius: 8px;
  border: 2.5px solid #ffd54f;
  animation: winBorderPulse 1.2s ease-in-out infinite alternate;
  pointer-events: none;
  z-index: 3;
}
.cell.win canvas {
  animation: symbolPulse 1.2s ease-in-out infinite alternate;
}
@keyframes shineSweep {
  0% { left: -150%; }
  50% { left: 150%; }
  100% { left: 150%; }
}
@keyframes winBorderPulse {
  0% { box-shadow: 0 0 8px #ffd54f, inset 0 0 4px #ffd54f; border-color: #ffd54f; }
  100% { box-shadow: 0 0 25px #ffe066, inset 0 0 12px #ffe066; border-color: #ffffff; }
}
@keyframes symbolPulse {
  0% { transform: scale(0.96); filter: brightness(1); }
  100% { transform: scale(1.12); filter: brightness(1.25) drop-shadow(0 0 8px #ffd54f); }
}
/* Sparkle particles styles */
.sparkle-particle {
  position: absolute;
  width: 10px;
  height: 10px;
  background: #fff;
  clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
  pointer-events: none;
  z-index: 6;
  animation: sparkleAnim 1.0s cubic-bezier(0.25, 1, 0.5, 1) forwards;
}
@keyframes sparkleAnim {
  0% { transform: translate(0, 0) scale(0) rotate(0deg); opacity: 0; }
  20% { opacity: 1; }
  100% { transform: translate(var(--dx), var(--dy)) scale(1.2) rotate(270deg); opacity: 0; }
}
.cell canvas{
  width:88%;height:88%;
  display:block;
  position:relative;
  z-index:2;
  pointer-events:none;
  -webkit-user-drag:none;
  user-select:none;
}
.cell.spinning canvas{
  animation:spinBlur .1s linear infinite;
}
@keyframes spinBlur{
  0%{transform:scaleY(1);opacity:1;}
  50%{transform:scaleY(0.2);opacity:0.2;}
  100%{transform:scaleY(1);opacity:1;}
}

/* ===== WIN LINES CANVAS OVERLAY ===== */
#winLinesCanvas {
  position: absolute;
  top: 14px;
  left: 60px;
  width: calc(100% - 120px);
  height: calc(100% - 24px);
  pointer-events: none;
  z-index: 10;
}

/* ===== WIN BANNER ===== */
#winBanner{
  display:none;
  position:absolute;top:50%;left:50%;
  transform:translate(-50%,-50%);
  z-index:30;text-align:center;pointer-events:none;
}
#winBanner.show{
  display:block;
  animation:winPop .45s cubic-bezier(.34,1.56,.64,1);
}
@keyframes winPop{
  from{transform:translate(-50%,-50%) scale(0.2) rotate(-15deg);opacity:0;}
  to{transform:translate(-50%,-50%) scale(1) rotate(0);opacity:1;}
}
.winInner{
  background:linear-gradient(135deg,#8a5500,#f5c842,#fff8a0,#f5c842,#8a5500);
  border-radius:14px;padding:14px 36px;
  font-size:22px;font-weight:bold;color:#3a1a00;
  box-shadow:0 0 40px rgba(245,200,66,0.7),0 6px 24px rgba(0,0,0,0.6);
  border:2px solid #ffe066;
}
.winInner small{display:block;font-size:12px;letter-spacing:2px;color:#6a3a00;margin-bottom:2px;}

/* ===== FLOATING WIN OVERLAYS ===== */
@keyframes floatUp {
  0% { transform: translateY(0); opacity: 1; }
  100% { transform: translateY(-34px); opacity: 0; }
}

/* ===== PARTICLES ===== */
#particles{
  position:fixed;top:0;left:0;
  width:100%;height:100%;
  pointer-events:none;z-index:50;
}

/* ===== CONTROLS ===== */
#controls{
  background:#0f223f;
  border: 2px solid #1a3a6a;
  border-radius: 30px;
  padding: 8px 24px;
  margin-top: 14px;
  width: 100%;
  max-width: 800px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.4);
}
.betLabel{
  text-align:center;font-size:10px;
  letter-spacing:3px;color:#5a8abf;
  margin-bottom:6px;text-transform:uppercase;
  font-weight:bold;
}
.ctrlRow{
  display:flex;align-items:center;
  justify-content:center;gap:12px;flex-wrap:wrap;
}
.ctrlGroup{display:flex;align-items:center;gap:4px;}
.ctrlBlock{
  display:flex;flex-direction:column;
  align-items:center;gap:2px;min-width:42px;
}
.ctrlLabel{font-size:8px;color:#5a8abf;text-transform:uppercase;letter-spacing:1px;font-weight:bold;}
.ctrlValue{font-size:13px;color:#fff;font-weight:bold;font-family:'Roboto Mono',monospace;}
.arrBtn{
  width:22px;height:22px;
  background:#1a3050;border:1px solid #2a5070;
  color:#8ca3c7;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;font-size:12px;
  transition:background .15s,color .15s,border-color .15s;
  user-select:none;
}
.arrBtn:hover{background:#2a5070;color:#f5c842;border-color:#f5c842;}
.arrBtn:active{transform:scale(0.9);}
.divider{width:1px;height:34px;background:#1d3354;margin:0 4px;}
.modeBtns{display:flex;gap:6px;}
.modeBtn{
  background:#1a3050;border:1px solid #2a5070;
  border-radius:18px;padding:5px 14px;
  font-size:11px;color:#8ca3c7;
  cursor:pointer;display:flex;align-items:center;gap:5px;
  transition:all .2s;font-family:inherit;
  letter-spacing:1px;
}
.modeBtn:hover{background:#2a5070;color:#f5c842;border-color:#f5c842;}
.modeBtn.on{background:#2a5070;color:#f5c842;border-color:#f5c842;}
.modeDot{
  width:7px;height:7px;border-radius:50%;
  background:#2a5070;transition:background .2s;
}
.modeBtn.on .modeDot{background:#f5c842;}

/* ===== SPIN BUTTON ===== */
.spinWrap{position:relative;display:flex;align-items:center;}
#spinBtn{
  width:64px;height:64px;border-radius:50%;
  border:none;cursor:pointer;
  background:conic-gradient(
    #f5c842 0deg,#ffe066 45deg,#d4a017 90deg,
    #f5c842 135deg,#ffe066 180deg,#d4a017 225deg,
    #f5c842 270deg,#ffe066 315deg,#d4a017 360deg
  );
  box-shadow:
    0 0 0 3px #2a1a00,
    0 4px 14px rgba(245,200,66,0.4),
    0 0 25px rgba(245,200,66,0.15);
  font-size:11px;font-weight:bold;
  color:#3a1a00;letter-spacing:1.5px;
  text-transform:uppercase;
  font-family:'Outfit',sans-serif;
  transition:transform .1s,box-shadow .1s;
  position:relative;
}
#spinBtn::after{
  content:'';position:absolute;inset:5px;
  border-radius:50%;
  background:radial-gradient(circle at 33% 28%,rgba(255,255,255,0.5),transparent 60%);
  pointer-events:none;
}
#spinBtn:hover{
  transform:scale(1.06);
  box-shadow:0 0 0 3px #2a1a00,0 6px 20px rgba(245,200,66,0.6),0 0 45px rgba(245,200,66,0.3);
}
#spinBtn:active{transform:scale(0.95);}
#spinBtn.go{animation:spinGo .7s linear infinite;pointer-events:none;}
@keyframes spinGo{from{transform:rotate(0);}to{transform:rotate(360deg);}}
.refreshBtn{
  position:absolute;right:-32px;top:50%;
  transform:translateY(-50%);
  width:24px;height:24px;border-radius:50%;
  background:#1a3050;border:1px solid #2a5070;
  color:#8ca3c7;display:flex;align-items:center;justify-content:center;
  cursor:pointer;font-size:14px;transition:color .2s;
}
.refreshBtn:hover{color:#f5c842;}
</style>
</head>
<body>

<!-- STAR BG -->
<canvas id="bgCanvas"></canvas>

<!-- PARTICLES -->
<div id="particles"></div>

<!-- TOP NAV (1XBET STYLE) -->
<div class="topnav">
  <div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Home</a>
    <span>/</span>
    <a href="{{ route('dashboard') }}">Slots</a>
    <span>/</span>
    <a href="{{ route('dashboard') }}">Popular</a>
    <span>/</span>
    <span style="color:#fff; font-weight:bold;">The Emirate</span>
  </div>
  <div class="gametitle">THE EMIRATE</div>
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

<!-- MAIN LAYOUT WRAPPER -->
<div id="gameWrapper">
  <div class="main-layout-container">
    
    <!-- LEFT PANEL: LOGO & MODE TOGGLE -->
    <div class="left-toggle-panel">
      <div class="game-header-info">
        <div class="logoOrb">E</div>
        <span class="logoName">The Emirate</span>
      </div>
      <div class="rmToggle">
        <div class="togSwitch" id="rmToggle">
          <div class="togDot"></div>
        </div>
        <span>PLAY FOR REAL MONEY</span>
      </div>
    </div>
    
    <!-- CENTER PANEL: THE SLOT MACHINE -->
    <div class="game-content-panel">
      
      <!-- TITLE (Subtle floating) -->
      <div id="titleArea" style="margin-bottom: 12px;">
        <div id="gameTitle3D">
          <span class="jewel"></span>The Emirate<span class="jewel"></span>
        </div>
      </div>

      <!-- BALANCE Display -->
      <div id="balanceRow" style="margin-bottom: 16px;">
        <span>Balance</span>
        <span id="balDisplay">0.00</span>
      </div>

      <!-- THE GAME REELS FRAME -->
      <div id="gameFrame">
        <div class="frameGlow"></div>
        <div class="archLeft"></div>
        <div class="archRight"></div>
        <div class="frameInfo">
          <span class="frameInfoIcon">&#8505;</span>
          <span class="frameInfoIcon" id="soundToggle" onclick="toggleMute()" title="Mute">&#128266;</span>
          <span class="frameInfoIcon">&#9645;</span>
        </div>
        <div id="reelsGrid"></div>
        <canvas id="winLinesCanvas"></canvas>
        <div id="winBanner">
          <div class="winInner">
            <small>WINNER!</small>
            +<span id="winCurrencySymbol">€</span><span id="winAmt">0.00</span>
          </div>
        </div>
      </div>

      <!-- CONTROLS PILL BAR -->
      <div id="controls">
        <div class="betLabel">Place Your Bet</div>
        <div class="ctrlRow">

          <div class="ctrlGroup">
            <div class="arrBtn" onclick="chgLines(-1)">&#9664;</div>
            <div class="ctrlBlock">
              <span class="ctrlLabel">Lines</span>
              <span class="ctrlValue" id="linesVal">5</span>
            </div>
            <div class="arrBtn" onclick="chgLines(1)">&#9654;</div>
          </div>

          <div class="divider"></div>

          <div class="ctrlBlock">
            <span class="ctrlLabel">Currency</span>
            <span class="ctrlValue">{{ auth()->user()->currency }}</span>
          </div>

          <div class="divider"></div>

          <div class="ctrlGroup">
            <div class="arrBtn" onclick="chgBet(-1)">&#9664;</div>
            <div class="ctrlBlock">
              <span class="ctrlLabel">Bet</span>
              <span class="ctrlValue" id="betVal">0.05</span>
            </div>
            <div class="arrBtn" onclick="chgBet(1)">&#9654;</div>
          </div>

          <div class="divider"></div>

          <div class="modeBtns">
            <div class="modeBtn" id="turboBtn" onclick="togTurbo()">
              <div class="modeDot"></div>TURBO
            </div>
            <div class="modeBtn" id="autoBtn" onclick="togAuto()">
              <div class="modeDot"></div>AUTO
            </div>
          </div>

          <div class="divider"></div>

          <div class="spinWrap">
            <button id="spinBtn" onclick="doSpin()">SPIN</button>
            <div class="refreshBtn" title="Reset" onclick="window.location.reload()">&#8635;</div>
          </div>

        </div>
      </div>

    </div><!-- /game-content-panel -->
  </div><!-- /main-layout-container -->
  
  <!-- BOTTOM BAR -->
  <div class="bottombar">
    <div class="left-tabs">
      <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-history" style="margin-right:4px;"></i> Recent Games</div>
      <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-heart" style="margin-right:4px;"></i> Favorites</div>
    </div>
    <input type="text" class="search-box" placeholder="Search slots..." disabled>
  </div>

</div><!-- /gameWrapper -->

<script>
/* ============================================================
   THE EMIRATE SLOT GAME
   Pure HTML + CSS + JavaScript Canvas DOM
   ============================================================ */

// ---- SYMBOLS ----
const SYMS = ['gari', 'gor', 'hadi', 'kolci', 'manus', 'manus2', 'n', 't'];

// ---- PRE-LOAD IMAGE ASSETS ----
const imgCache = {};
SYMS.forEach(name => {
  const img = new Image();
  img.src = `{{ asset('assets/image/theemirate') }}/${name}.png`;
  imgCache[name] = img;
});

// ---- ANIMATE WINNING FACES (BLINK & SMILE & HAND WAVE) ----
function animateFace(ctx, img, type, t) {
  const isGirl = type === 'manus';
  
  if (isGirl) {
    // 1. ANIMATE HAND WAVE FOR LADY
    // Cover the original static hand on her veil/abaya
    ctx.fillStyle = '#181224'; // Dark purple/black color of her abaya
    ctx.beginPath();
    ctx.ellipse(72, 70, 16, 20, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Draw moving hand (wrist pivot at 72, 82)
    ctx.save();
    const pivotX = 72;
    const pivotY = 82;
    ctx.translate(pivotX, pivotY);
    // Wave back and forth
    const waveAngle = Math.sin(t * 8) * 0.08; 
    ctx.rotate(waveAngle);
    // Draw cropped hand from original image (source: 52, 52, 36, 36)
    ctx.drawImage(img, 52, 52, 36, 36, -18, -30, 36, 36);
    ctx.restore();
    
    // 2. LADY FACE ANIMATIONS (Aligned to shifted face on the left)
    const eyeY = 43;
    const leftEyeX = 27;
    const rightEyeX = 41;
    const mouthX = 34;
    const mouthY = 57;
    const skinColor = '#dfb496';
    const lipColor = '#e65c5c';
    
    // Cover original eyes
    ctx.fillStyle = skinColor;
    ctx.beginPath();
    ctx.ellipse(leftEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.ellipse(rightEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Cover original mouth
    ctx.beginPath();
    ctx.ellipse(mouthX, mouthY + 1, 7, 3.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Blink cycle: blinks every 1.5 seconds, closed for 150ms
    const cycle = t % 1.5;
    const isBlinking = cycle > 1.35;
    
    // Draw EYES
    if (isBlinking) {
      // Eyelids closed: draw lashes
      ctx.strokeStyle = '#231510';
      ctx.lineWidth = 1.5;
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.arc(rightEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.stroke();
    } else {
      // Eyeballs (white)
      ctx.fillStyle = '#ffffff';
      ctx.beginPath();
      ctx.ellipse(leftEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.ellipse(rightEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.fill();
      
      // Irises looking upwards
      ctx.fillStyle = '#4e3115';
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.2, 1.8, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.2, 1.8, 0, Math.PI * 2);
      ctx.fill();
      
      // Pupils
      ctx.fillStyle = '#000000';
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.2, 0.9, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.2, 0.9, 0, Math.PI * 2);
      ctx.fill();
      
      // Eye highlights
      ctx.fillStyle = '#ffffff';
      ctx.beginPath();
      ctx.arc(leftEyeX + 0.6, eyeY - 1.8, 0.5, 0, Math.PI * 2);
      ctx.arc(rightEyeX + 0.6, eyeY - 1.8, 0.5, 0, Math.PI * 2);
      ctx.fill();
      
      // Upper eyeliner
      ctx.strokeStyle = '#1b120f';
      ctx.lineWidth = 1.2;
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY + 0.5, 4.5, Math.PI + 0.2, 2 * Math.PI - 0.2, false);
      ctx.arc(rightEyeX, eyeY + 0.5, 4.5, Math.PI + 0.2, 2 * Math.PI - 0.2, false);
      ctx.stroke();
    }
    
    // Draw MOUTH (Lady smile with lips)
    ctx.strokeStyle = lipColor;
    ctx.lineWidth = 2.0;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.arc(mouthX, mouthY - 1, 4.5, 0.1, Math.PI - 0.1, false);
    ctx.stroke();
    
    ctx.fillStyle = lipColor;
    ctx.beginPath();
    ctx.arc(mouthX, mouthY - 1, 4.5, 0.2, Math.PI - 0.2, false);
    ctx.quadraticCurveTo(mouthX, mouthY + 2, mouthX - 4.3, mouthY - 0.5);
    ctx.fill();
    
  } else {
    // SHEIKH FACE ANIMATIONS
    const eyeY = 38;
    const leftEyeX = 44;
    const rightEyeX = 58;
    const mouthX = 51;
    const mouthY = 53;
    const skinColor = '#dfb598';
    const lipColor = '#c47d7d';
    
    // Cover original eyes
    ctx.fillStyle = skinColor;
    ctx.beginPath();
    ctx.ellipse(leftEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.ellipse(rightEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Cover original mouth
    ctx.beginPath();
    ctx.ellipse(mouthX, mouthY + 1, 7, 3.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Blink cycle
    const cycle = t % 1.5;
    const isBlinking = cycle > 1.35;
    
    // Draw EYES
    if (isBlinking) {
      ctx.strokeStyle = '#231510';
      ctx.lineWidth = 1.5;
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.arc(rightEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.stroke();
    } else {
      ctx.fillStyle = '#ffffff';
      ctx.beginPath();
      ctx.ellipse(leftEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.ellipse(rightEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.fillStyle = '#4e3115'; // Brown iris looking up
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.0, 1.8, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.0, 1.8, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.fillStyle = '#000000';
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.0, 0.9, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.0, 0.9, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.fillStyle = '#ffffff';
      ctx.beginPath();
      ctx.arc(leftEyeX + 0.6, eyeY - 1.6, 0.5, 0, Math.PI * 2);
      ctx.arc(rightEyeX + 0.6, eyeY - 1.6, 0.5, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.strokeStyle = '#1b120f';
      ctx.lineWidth = 1.2;
      ctx.beginPath();
      ctx.arc(leftEyeX, eyeY + 0.5, 4.5, Math.PI + 0.2, 2 * Math.PI - 0.2, false);
      ctx.arc(rightEyeX, eyeY + 0.5, 4.5, Math.PI + 0.2, 2 * Math.PI - 0.2, false);
      ctx.stroke();
    }
    
    // Draw MOUTH (Sheikh subtle smile)
    ctx.strokeStyle = lipColor;
    ctx.lineWidth = 1.8;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.arc(mouthX, mouthY - 1.5, 4.5, 0.2, Math.PI - 0.2, false);
    ctx.stroke();
  }
}

// ---- SYMBOL DRAW DISPATCH ----
function drawSymbol(canvas, type, t) {
  const ctx = canvas.getContext('2d');
  const w = canvas.width, h = canvas.height;
  ctx.clearRect(0,0,w,h);
  
  const img = imgCache[type];
  if (img && img.complete) {
    ctx.drawImage(img, 2, 2, w - 4, h - 4);
    
    // Check if parent node is in win state to apply dynamic animations
    if (canvas.parentNode && canvas.parentNode.classList.contains('win')) {
      if (type === 'manus' || type === 'manus2') {
        animateFace(ctx, img, type, t);
      }
    }
  } else {
    // Elegant temporary loading block
    ctx.fillStyle = 'rgba(14, 42, 80, 0.4)';
    ctx.fillRect(0, 0, w, h);
    ctx.strokeStyle = '#1a3a6a';
    ctx.strokeRect(0, 0, w, h);
    ctx.fillStyle = '#f5c842';
    ctx.font = '10px Georgia';
    ctx.textBaseline = 'middle';
    ctx.fillText('LOADING...', w / 2, h / 2);
  }
}

// ---- GAME STATE & BALANCE INTEGRATION ----
let realBalance = parseFloat("{{ auth()->user()->balance }}");
let isDemoMode = new URLSearchParams(window.location.search).get('demo') === '1' || (realBalance < 0.05);
let demoBalance = 1000.00;
let balance = isDemoMode ? demoBalance : realBalance;

const currencySymbolMap = {
  'EUR': '€',
  'USD': '$',
  'BDT': '৳',
  'GBP': '£',
  'INR': '₹'
};
const currency = "{{ auth()->user()->currency }}";
const currencySymbol = currencySymbolMap[currency] || (currency + ' ');

const betAmts = [0.05,0.10,0.25,0.50,1.00,2.00,5.00];
let betIdx = 0;
const linesArr = [1,3,5,9,15,20,25];
let linesIdx = 2;
let turboOn = false, autoOn = false;
let spinning = false;
let autoTimer = null;

let currentGrid = [
  ['manus', 'kolci', 'gor', 'n', 'hadi'],
  ['kolci', 'gor', 'manus2', 't', 'gari'],
  ['gari', 't', 'n', 'manus', 'kolci']
];
let cellData = [];
let animRAF = null;

// ---- WEB AUDIO ARABIC MUSIC SYNTHESIZER ----
class ArabicMusicSynth {
  constructor(ctx) {
    this.ctx = ctx;
    this.isPlaying = false;
    this.noiseBuffer = this.createNoiseBuffer();
    this.nextNoteTime = 0.0;
    this.currentStep = 0;
    this.timerId = null;
    this.tempo = 112; // BPM
    
    // Master gain node for the synth
    this.masterGain = this.ctx.createGain();
    this.masterGain.gain.value = 0.7; // default volume
    this.masterGain.connect(this.ctx.destination);
    
    // Drone nodes
    this.droneOsc = null;
    this.droneFilter = null;
    this.droneGain = null;
  }
  
  createNoiseBuffer() {
    const sampleRate = this.ctx.sampleRate;
    const bufferSize = sampleRate * 0.15; // 0.15s duration
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
    this.masterGain.gain.linearRampToValueAtTime(0.22, this.ctx.currentTime + 0.15);
  }
  
  unduck() {
    this.masterGain.gain.linearRampToValueAtTime(0.7, this.ctx.currentTime + 0.6);
  }
  
  startDrone() {
    this.stopDrone(); // clean up if any
    try {
      this.droneOsc = this.ctx.createOscillator();
      this.droneFilter = this.ctx.createBiquadFilter();
      this.droneGain = this.ctx.createGain();
      
      this.droneOsc.type = 'triangle';
      this.droneOsc.frequency.setValueAtTime(146.83, this.ctx.currentTime); // D3
      
      this.droneFilter.type = 'lowpass';
      this.droneFilter.frequency.setValueAtTime(300, this.ctx.currentTime);
      
      this.droneGain.gain.setValueAtTime(0.04, this.ctx.currentTime);
      
      this.droneOsc.connect(this.droneFilter);
      this.droneFilter.connect(this.droneGain);
      this.droneGain.connect(this.masterGain);
      
      this.droneOsc.start(0);
      
      // Evolving filter sweep LFO
      const lfo = this.ctx.createOscillator();
      const lfoGain = this.ctx.createGain();
      lfo.frequency.value = 0.15; // Slow sweep (once every ~7 seconds)
      lfoGain.gain.value = 100; // Sweep range: 300Hz +/- 100Hz
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
    
    const lookahead = 0.1; // 100ms
    
    while (this.nextNoteTime < this.ctx.currentTime + lookahead) {
      this.scheduleNote(this.currentStep, this.nextNoteTime);
      this.advanceNote();
    }
    
    // Check back in 30ms
    this.timerId = setTimeout(() => this.scheduler(), 30);
  }
  
  advanceNote() {
    const secondsPerBeat = 60.0 / this.tempo;
    const sixteenthNoteDuration = 0.25 * secondsPerBeat;
    this.nextNoteTime += sixteenthNoteDuration;
    this.currentStep = (this.currentStep + 1) % 32; // 32-step sequence
  }
  
  scheduleNote(step, time) {
    // 1. Darbuka Rhythm (Maqsum style: Dum - Tek - Ka - Tek - Dum - Ka - Tek - Ka)
    // 16 steps per bar, 2 bars = 32 steps
    const stepInBar = step % 16;
    
    // Dum (bass beat) at step 0, 8
    if (stepInBar === 0 || stepInBar === 8) {
      this.playDum(time);
    }
    // Tek (sharp slap beat) at step 4, 12
    else if (stepInBar === 4 || stepInBar === 12) {
      this.playTek(time);
    }
    // Ka (softer snap beat) at step 2, 6, 10, 14
    else if (stepInBar === 2 || stepInBar === 6 || stepInBar === 10 || stepInBar === 14) {
      this.playKa(time);
    }
    
    // 2. Melody (Oud pluck) in Hijaz scale
    const melodyMap = {
      0: 293.66,   // D4
      2: 311.13,   // Eb4
      3: 311.13,   // Eb4
      4: 369.99,   // F#4
      6: 392.00,   // G4
      8: 440.00,   // A4
      10: 466.16,  // Bb4
      11: 466.16,  // Bb4
      12: 554.37,  // C#5
      14: 587.33,  // D5
      16: 587.33,  // D5
      18: 554.37,  // C#5
      19: 554.37,  // C#5
      20: 466.16,  // Bb4
      22: 440.00,  // A4
      24: 392.00,  // G4
      26: 369.99,  // F#4
      27: 369.99,  // F#4
      28: 311.13,  // Eb4
      30: 293.66   // D4
    };
    
    const freq = melodyMap[step];
    if (freq) {
      this.playOud(freq, time);
    }
  }
  
  playDum(time) {
    try {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(150, time);
      osc.frequency.exponentialRampToValueAtTime(45, time + 0.15);
      
      gain.gain.setValueAtTime(0.24, time);
      gain.gain.exponentialRampToValueAtTime(0.001, time + 0.16);
      
      osc.connect(gain);
      gain.connect(this.masterGain);
      osc.start(time);
      osc.stop(time + 0.17);
    } catch(e) {}
  }
  
  playTek(time) {
    try {
      const source = this.ctx.createBufferSource();
      source.buffer = this.noiseBuffer;
      
      const filter = this.ctx.createBiquadFilter();
      filter.type = 'bandpass';
      filter.frequency.setValueAtTime(2500, time);
      filter.Q.setValueAtTime(4, time);
      
      const gain = this.ctx.createGain();
      gain.gain.setValueAtTime(0.09, time);
      gain.gain.exponentialRampToValueAtTime(0.001, time + 0.05);
      
      source.connect(filter);
      filter.connect(gain);
      gain.connect(this.masterGain);
      
      source.start(time);
      source.stop(time + 0.06);
    } catch(e) {}
  }
  
  playKa(time) {
    try {
      const source = this.ctx.createBufferSource();
      source.buffer = this.noiseBuffer;
      
      const filter = this.ctx.createBiquadFilter();
      filter.type = 'bandpass';
      filter.frequency.setValueAtTime(2200, time);
      filter.Q.setValueAtTime(3, time);
      
      const gain = this.ctx.createGain();
      gain.gain.setValueAtTime(0.04, time);
      gain.gain.exponentialRampToValueAtTime(0.001, time + 0.03);
      
      source.connect(filter);
      filter.connect(gain);
      gain.connect(this.masterGain);
      
      source.start(time);
      source.stop(time + 0.04);
    } catch(e) {}
  }
  
  playOud(freq, time) {
    try {
      const osc1 = this.ctx.createOscillator();
      const osc2 = this.ctx.createOscillator();
      const filter = this.ctx.createBiquadFilter();
      const gain = this.ctx.createGain();
      
      osc1.type = 'sawtooth';
      osc1.frequency.setValueAtTime(freq, time);
      osc1.detune.setValueAtTime(-5, time);
      
      osc2.type = 'triangle';
      osc2.frequency.setValueAtTime(freq, time);
      osc2.detune.setValueAtTime(5, time);
      
      filter.type = 'lowpass';
      filter.frequency.setValueAtTime(1100, time);
      filter.frequency.exponentialRampToValueAtTime(180, time + 0.22);
      
      gain.gain.setValueAtTime(0.06, time);
      gain.gain.exponentialRampToValueAtTime(0.001, time + 0.28);
      
      osc1.connect(filter);
      osc2.connect(filter);
      filter.connect(gain);
      gain.connect(this.masterGain);
      
      osc1.start(time);
      osc2.start(time);
      
      osc1.stop(time + 0.3);
      osc2.stop(time + 0.3);
    } catch(e) {}
  }
}

// ---- WEB AUDIO SOUND ENGINE ----
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
        this.musicSynth = new ArabicMusicSynth(this.ctx);
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
  
  // Real mechanical spin sound (like a rhythmic slot reel motor)
  playSpin() {
    this.ensureAudio();
    if (this.musicSynth) this.musicSynth.duck();
    if (this.spinInterval) clearInterval(this.spinInterval);
    
    let tickCount = 0;
    // Rhythmic low clatters simulating spinning mechanical reels
    this.spinInterval = setInterval(() => {
      // Alternate frequencies to create a galloping rhythm (clack-clack-clack)
      const freq = tickCount % 3 === 0 ? 120 : 90;
      this.beep(freq, 0.08, 'triangle', 0.15);
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
    // Mechanical clunk sound for each stopped reel
    this.beep(160 + reelIndex * 15, 0.12, 'triangle', 0.22);
    this.beep(60, 0.15, 'sine', 0.35); // Low bass clunk thud
  }
  
  playWin() {
    this.stopSpin();
    // Celebrate arpeggio fanfare chord
    const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50];
    notes.forEach((freq, idx) => {
      this.beep(freq, 0.3, 'square', 0.08, idx * 80);
    });
  }
  
  playCoinRollup() {
    // Rapid coinrollup sound
    this.beep(987.77 + Math.random() * 200, 0.05, 'sine', 0.08);
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

// Ensure audio context is unlocked upon first interaction
document.addEventListener('click', () => {
  soundEngine.ensureAudio();
}, { once: true });

// ---- WIN LINES & CELL OVERLAYS ----
function drawWinLine(winCells) {
  const canvas = document.getElementById('winLinesCanvas');
  const ctx = canvas.getContext('2d');
  const grid = document.getElementById('reelsGrid');
  
  canvas.width = grid.clientWidth;
  canvas.height = grid.clientHeight;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  if (winCells.length < 3) return;
  
  const colWidth = canvas.width / 5;
  const rowHeight = canvas.height / 3;
  
  // Calculate centers of winning cells
  const points = winCells.map(id => {
    const [r, c] = id.split('_').map(Number);
    return {
      x: colWidth * c + colWidth / 2,
      y: rowHeight * r + rowHeight / 2,
      elId: `cell_${r}_${c}`
    };
  });
  
  // 1. Draw glowing connecting lines
  ctx.save();
  ctx.beginPath();
  ctx.moveTo(points[0].x, points[0].y);
  for (let i = 1; i < points.length; i++) {
    ctx.lineTo(points[i].x, points[i].y);
  }
  
  // Outer glow
  ctx.strokeStyle = 'rgba(255, 224, 102, 0.45)';
  ctx.lineWidth = 12;
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';
  ctx.shadowColor = '#f5c842';
  ctx.shadowBlur = 15;
  ctx.stroke();
  
  // Inner bright line
  ctx.strokeStyle = '#ffffff';
  ctx.lineWidth = 4;
  ctx.stroke();
  ctx.restore();
  
function spawnSparkles(cell) {
  let count = 0;
  const interval = setInterval(() => {
    if (!cell.classList.contains('win') || count >= 12) {
      clearInterval(interval);
      return;
    }
    const sp = document.createElement('div');
    sp.className = 'sparkle-particle';
    const x = Math.random() * 80 + 10;
    const y = Math.random() * 80 + 10;
    const dx = (Math.random() - 0.5) * 60 + 'px';
    const dy = (Math.random() - 0.5) * 60 - 20 + 'px';
    
    sp.style.left = x + '%';
    sp.style.top = y + '%';
    sp.style.setProperty('--dx', dx);
    sp.style.setProperty('--dy', dy);
    
    const colors = ['#ffffff', '#ffd54f', '#ffe066', '#fff59d', '#ffca28'];
    sp.style.background = colors[Math.floor(Math.random() * colors.length)];
    
    cell.appendChild(sp);
    count++;
    setTimeout(() => sp.remove(), 1000);
  }, 100);
}

// 2. Add flashing highlight to win cells
  points.forEach(pt => {
    const cell = document.getElementById(pt.elId);
    if (cell) {
      cell.classList.add('win');
      spawnSparkles(cell);
      
      // Floating payout amount on symbol cells
      const payoutVal = (betAmts[betIdx] * 3).toFixed(2);
      const floatText = document.createElement('div');
      floatText.className = 'winPayoutFloat';
      floatText.style.cssText = `
        position: absolute;
        z-index: 20;
        background: rgba(0,0,0,0.85);
        color: #fff;
        border: 1px solid #ffd54f;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        pointer-events: none;
        animation: floatUp 1.5s ease-out forwards;
      `;
      floatText.textContent = currencySymbol + payoutVal;
      cell.appendChild(floatText);
      setTimeout(() => floatText.remove(), 1500);
    }
  });
}

function clearWinLine() {
  const canvas = document.getElementById('winLinesCanvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  document.querySelectorAll('.cell.win').forEach(c => c.classList.remove('win'));
}

// ---- BUILD REELS ----
function buildReels(grid) {
  const container = document.getElementById('reelsGrid');
  container.innerHTML = '';
  cellData = [];

  for(let col=0;col<5;col++){
    const reel = document.createElement('div');
    reel.className = 'reelCol';
    for(let row=0;row<3;row++){
      const cell = document.createElement('div');
      cell.className = 'cell';
      cell.id = `cell_${row}_${col}`;
      const cv = document.createElement('canvas');
      cv.width = 90; cv.height = 90;
      cell.appendChild(cv);
      reel.appendChild(cell);
      cellData.push({canvas:cv, sym:grid[row][col], row, col});
    }
    container.appendChild(reel);
  }
  startAnim();
}

// ---- LIVE ANIMATION ----
function startAnim() {
  if(animRAF) cancelAnimationFrame(animRAF);
  function loop() {
    const t = Date.now()/1000;
    cellData.forEach(cd=>{
      if(cd.canvas && !cd.spinning) drawSymbol(cd.canvas, cd.sym, t);
    });
    animRAF = requestAnimationFrame(loop);
  }
  animRAF = requestAnimationFrame(loop);
}

// ---- SPIN ----
function randSym() { return SYMS[Math.floor(Math.random()*SYMS.length)]; }
function randGrid() {
  return [
    [randSym(),randSym(),randSym(),randSym(),randSym()],
    [randSym(),randSym(),randSym(),randSym(),randSym()],
    [randSym(),randSym(),randSym(),randSym(),randSym()]
  ];
}

function checkWins(g) {
  const winCells = [];
  const lines = linesArr[linesIdx];
  const pats = [
    [0,0,0,0,0],[1,1,1,1,1],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2]
  ];
  let wc = 0;
  for(let l=0;l<Math.min(lines,pats.length);l++){
    const p = pats[l];
    const s = p.map((r,c)=>g[r][c]);
    let m=1; for(let i=1;i<5;i++){if(s[i]===s[0])m++;else break;}
    if(m>=3){wc++;for(let i=0;i<m;i++)winCells.push(`${p[i]}_${i}`);}
  }
  return {wc, winCells};
}

function doSpin() {
  if(spinning) return;
  const bet = betAmts[betIdx];
  if(balance<bet){
    if (isDemoMode) {
      alert('Demo balance insufficient! Refilling demo credits...');
      balance = 1000.00;
      updateBal();
    } else {
      alert('Insufficient real balance! Please deposit money.');
      return;
    }
  }
  
  clearWinLine();
  spinning = true;
  balance -= bet;
  updateBal();
  if(!isDemoMode){
    realBalance = balance;
    syncBalance(balance);
  }

  soundEngine.playSpin();

  const btn = document.getElementById('spinBtn');
  btn.classList.add('go');
  document.querySelectorAll('.cell').forEach(c=>c.classList.add('spinning'));

  const spTime = turboOn ? 350 : 950;

  // cascade stop per reel
  for(let col=0;col<5;col++){
    setTimeout(()=>{
      const ng = randGrid();
      // update symbols for this column
      for(let row=0;row<3;row++){
        const idx = cellData.findIndex(cd=>cd.row===row&&cd.col===col);
        if(idx>=0){
          cellData[idx].sym = ng[row][col];
          currentGrid[row][col] = ng[row][col];
        }
        const cell = document.getElementById(`cell_${row}_${col}`);
        if(cell) cell.classList.remove('spinning');
      }
      
      soundEngine.playReelStop(col);
      
      if(col===4){
        soundEngine.stopSpin();
        btn.classList.remove('go');
        spinning = false;
        const {wc,winCells} = checkWins(currentGrid);
        if(wc>0){
          const wamt = +(bet*linesArr[linesIdx]*wc*3).toFixed(2);
          balance += wamt; 
          updateBal();
          if(!isDemoMode){
            realBalance = balance;
            syncBalance(balance);
          }
          
          drawWinLine(winCells);
          soundEngine.playWin();
          spawnCoins(wamt);
          showWin(wamt);
          setTimeout(() => {
            if (soundEngine.musicSynth) soundEngine.musicSynth.unduck();
          }, 2400);
        } else {
          if (soundEngine.musicSynth) soundEngine.musicSynth.unduck();
        }
      }
    }, col*(spTime/5)+80);
  }
}

// ---- UI ----
function updateBal() {
  document.getElementById('balDisplay').textContent = currencySymbol + balance.toFixed(2);
}
function chgBet(d) {
  betIdx = Math.max(0,Math.min(betAmts.length-1,betIdx+d));
  document.getElementById('betVal').textContent = currencySymbol + betAmts[betIdx].toFixed(2);
}
function chgLines(d) {
  linesIdx = Math.max(0,Math.min(linesArr.length-1,linesIdx+d));
  document.getElementById('linesVal').textContent = linesArr[linesIdx];
}
function togTurbo() {
  turboOn = !turboOn;
  document.getElementById('turboBtn').classList.toggle('on',turboOn);
}
function togAuto() {
  autoOn = !autoOn;
  document.getElementById('autoBtn').classList.toggle('on',autoOn);
  if(autoOn) autoTimer=setInterval(()=>{if(!spinning)doSpin();},turboOn?600:1700);
  else clearInterval(autoTimer);
}

function showWin(amt) {
  const b = document.getElementById('winBanner');
  document.getElementById('winAmt').textContent = amt.toFixed(2);
  b.classList.add('show');
  setTimeout(()=>{
    b.classList.remove('show');
    // Win border/glow color and animation is kept running until next spin starts!
    // clearWinLine(); 
  },2400);
}

// ---- COIN PARTICLES ----
function spawnCoins(amt) {
  const pc = document.getElementById('particles');
  const count = Math.min(24, Math.floor(amt*4)+7);
  for(let i=0;i<count;i++){
    setTimeout(()=>{
      const coin = document.createElement('div');
      const x = 15+Math.random()*70;
      const dy = 40+Math.random()*60;
      const rot = 200+Math.random()*400;
      coin.style.cssText=`
        position:absolute;left:${x}%;top:55%;
        width:15px;height:15px;border-radius:50%;
        background:radial-gradient(circle at 35% 28%,#ffe090,#d4a017,#8a6000);
        border:1.5px solid #c08000;
        display:flex;align-items:center;justify-content:center;
        font-size:8px;color:#7a3000;font-weight:bold;
        pointer-events:none;z-index:200;
        animation:coinUp 1.3s ease-out forwards;
        --dy:${dy}px;--rot:${rot}deg;
      `;
      coin.textContent = currencySymbol;
      pc.appendChild(coin);
      soundEngine.playCoinRollup();
      setTimeout(()=>coin.remove(),1350);
    },i*55);
  }
}

// ---- STARFIELD BG ----
function initBg() {
  const cv = document.getElementById('bgCanvas');
  const ctx = cv.getContext('2d');
  const stars = [];
  function resize() {
    cv.width = window.innerWidth;
    cv.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize',resize);
  for(let i=0;i<150;i++){
    stars.push({
      x:Math.random()*cv.width, y:Math.random()*cv.height,
      r:Math.random()*1.5+0.2,
      spd:Math.random()*0.6+0.2, phase:Math.random()*Math.PI*2
    });
  }
  function drawBg() {
    cv.width = window.innerWidth; cv.height = window.innerHeight;
    ctx.clearRect(0,0,cv.width,cv.height);
    const t=Date.now()/1000;
    stars.forEach(s=>{
      const a = 0.2+Math.sin(t*s.spd+s.phase)*0.5;
      ctx.fillStyle=`rgba(190,215,255,${Math.max(0,a)})`;
      ctx.beginPath(); ctx.arc(s.x,s.y,s.r,0,Math.PI*2); ctx.fill();
    });
    const grd=ctx.createRadialGradient(cv.width/2,cv.height,0,cv.width/2,cv.height,cv.height*0.8);
    grd.addColorStop(0,'rgba(14,50,110,0.22)'); grd.addColorStop(1,'rgba(0,0,0,0)');
    ctx.fillStyle=grd; ctx.fillRect(0,0,cv.width,cv.height);
    requestAnimationFrame(drawBg);
  }
  drawBg();
}

// ---- COIN KEYFRAME ----
const coinStyle = document.createElement('style');
coinStyle.textContent=`
@keyframes coinUp{
  0%{transform:translateY(0) scale(1) rotate(0deg);opacity:1;}
  60%{opacity:1;}
  100%{transform:translateY(calc(var(--dy)*-1)) scale(0.4) rotate(var(--rot));opacity:0;}
}
`;
document.head.appendChild(coinStyle);

// ---- DATABASE BALANCE SYNC ----
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

// ---- PLAY MODE TOGGLE ----
const rmToggle = document.getElementById('rmToggle');
const rmToggleLabel = document.querySelector('.rmToggle span');

function updateModeUI() {
  if (isDemoMode) {
    rmToggle.classList.remove('on');
    rmToggleLabel.textContent = 'PLAY FOR REAL MONEY';
    balance = demoBalance;
  } else {
    if (realBalance < 0.05) {
      alert("Your real balance is too low! Switching to Demo Mode.");
      isDemoMode = true;
      rmToggle.classList.remove('on');
      rmToggleLabel.textContent = 'PLAY FOR REAL MONEY';
      balance = demoBalance;
    } else {
      rmToggle.classList.add('on');
      rmToggleLabel.textContent = 'REAL PLAY ACTIVE';
      balance = realBalance;
    }
  }
  updateBal();
}

rmToggle.addEventListener('click', function() {
  if (spinning) return;
  isDemoMode = !isDemoMode;
  updateModeUI();
});

// ---- FULLSCREEN UTILITY ----
function toggleFullScreen() {
  if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen().catch(err => {
          console.error(`Error attempting to enable full-screen mode: ${err.message}`);
      });
  } else {
      document.exitFullscreen();
  }
}

// ---- INIT ----
buildReels(currentGrid);
initBg();
document.getElementById('winCurrencySymbol').textContent = currencySymbol;
chgBet(0);
updateModeUI();

// Disable right click on the game frame to prevent inspection of symbol images
document.getElementById('gameFrame').addEventListener('contextmenu', e => e.preventDefault());
</script>
</body>
</html>
