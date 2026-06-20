<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Royal Emirates Hold and Spin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  :root{
    --bg-night:#091a33;
    --bg-panel:#0e2a52;
    --bg-panel-light:#173b6e;
    --gold:#e8b94a;
    --gold-light:#ffe9a8;
    --gold-dark:#9c6f1e;
    --teal:#22b8a8;
    --red:#e0265f;
    --blue-glow:#4fc3f7;
    --text-light:#eef3fb;
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  html,body{
    margin:0;padding:0;min-height:100vh;
    background:#040d1c;
    font-family:'Outfit','Trebuchet MS',Verdana,sans-serif;
    color:var(--text-light);
    overflow-x:hidden;
  }
  .display-font{
    font-family:'Brush Script MT','Segoe Script','Comic Sans MS',cursive;
  }
  #bgCanvas{
    position:fixed;inset:0;width:100vw;height:100vh;z-index:0;display:block;
  }

  /* ---------- 1XBET FULL PAGE SHELL ---------- */
  #gameWrapper{
    width:100%;
    min-height:100vh;
    background:#040d1c;
    display:flex;
    flex-direction:column;
    position:relative;
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
    font-size: 11px;
    color: #8ca3c7;
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
    margin: 0 auto;
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

  .main-layout-container {
    display: flex;
    flex: 1;
    margin-left: 54px;
    margin-top: 50px;
    margin-bottom: 40px;
    background: #040d1c;
    min-height: calc(100vh - 90px);
    justify-content: center;
    align-items: center;
    padding: 14px 20px;
    position: relative;
    z-index: 5;
  }

  /* Centered game slot frame */
  .slot-game-container {
    width: 100%;
    max-width: 860px;
    background: linear-gradient(180deg, var(--bg-panel) 0%, var(--bg-night) 100%);
    border: 2px solid var(--gold-dark);
    border-radius: 14px;
    box-shadow: 0 25px 60px rgba(0,0,0,.55), inset 0 0 40px rgba(0,0,0,.4);
    overflow: hidden;
  }


  /* ---------- sub header ---------- */
  .subheader{
    background:linear-gradient(90deg,#1a3f73,#214a86,#1a3f73);
    padding:8px 14px;
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
    border-bottom:1px solid rgba(232,185,74,.4);
  }
  .subheader .game-name{font-weight:700;font-size:.95rem;}
  .subheader .game-name i{color:var(--gold);margin-right:8px;}
  
  /* Play Mode Toggle switch styling */
  .rmToggle {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    color: #8ca3c7;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
  }
  .togSwitch {
    width: 34px;
    height: 17px;
    background: #0a1c3a;
    border-radius: 9px;
    position: relative;
    border: 1.5px solid var(--teal);
    cursor: pointer;
    transition: background .2s, border-color .2s;
  }
  .togDot {
    width: 13px;
    height: 13px;
    background: var(--teal);
    border-radius: 50%;
    position: absolute;
    top: 1px;
    left: 1px;
    transition: left .2s, background .2s;
  }
  .togSwitch.on .togDot {
    left: 18px;
    background: var(--gold);
  }
  .togSwitch.on {
    border-color: var(--gold);
  }

  .header-icons button{
    background:transparent;border:1px solid rgba(255,255,255,.25);color:#dce6f7;
    width:30px;height:30px;border-radius:7px;margin-left:5px;font-size:.78rem;
    transition:.2s;
  }
  .header-icons button:hover{background:rgba(255,255,255,.12);color:var(--gold);}
  .header-icons button.fav-active{color:var(--gold);border-color:var(--gold);}

  /* ---------- viewport ---------- */
  .viewport{
    position:relative;
    padding:14px 14px 6px;
    background:
      radial-gradient(ellipse at 50% -10%, rgba(79,195,247,.2), transparent 70%),
      url("{{ asset('assets/image/Royal Emirates Hold and Spin/bg.png') }}") no-repeat center center;
    background-size: cover;
  }

  .jackpot-bar{
    display:flex;align-items:center;justify-content:space-between;
    background:linear-gradient(180deg, rgba(12, 35, 73, 0.85), rgba(10, 28, 58, 0.9));
    border:1px solid var(--gold-dark);
    border-radius:10px;
    padding:8px 10px 4px;
    margin-bottom:10px;
    flex-wrap:wrap;
  }
  .jp{text-align:center;min-width:90px;}
  .jp-label{
    font-weight:800;font-size:.78rem;letter-spacing:1px;
    -webkit-text-stroke:.5px rgba(0,0,0,.3);
  }
  .jp.grand .jp-label{color:#ff5d8f;}
  .jp.mega .jp-label{color:#c9a6ff;}
  .jp.minor .jp-label{color:#7ec8ff;}
  .jp.mini .jp-label{color:#7df0c2;}
  .jp-amt{
    display:block;color:var(--gold-light);font-weight:700;font-size:.95rem;
    text-shadow:0 0 8px rgba(232,185,74,.6);
    font-variant-numeric:tabular-nums;
  }
  .logo-area{flex:1;text-align:center;min-width:220px;perspective:500px;}
  .game-logo{
    font-size:2.3rem;margin:0;line-height:1;
    background:linear-gradient(180deg,#fff6da,var(--gold) 55%,var(--gold-dark));
    -webkit-background-clip:text;background-clip:text;color:transparent;
    text-shadow:0 1px 0 rgba(255,255,255,.4), 0 6px 14px rgba(0,0,0,.55);
    animation:float3d 4s ease-in-out infinite;
    transform-style:preserve-3d;
  }
  .game-logo span{color:#7ec8ff;background:none;-webkit-text-fill-color:#bfe9ff;text-shadow:0 0 14px rgba(79,195,247,.8);}
  @keyframes float3d{
    0%,100%{transform:translateY(0) rotateX(0deg);}
    50%{transform:translateY(-4px) rotateX(4deg);}
  }
  .game-subtitle{
    margin:-4px 0 0;color:var(--gold-light);font-weight:700;letter-spacing:3px;font-size:.78rem;
    text-transform:uppercase;
  }

  .reel-frame{
    position:relative;
    border:3px solid var(--gold);
    border-radius:10px;
    background:rgba(6, 20, 43, 0.45);
    padding:10px;
    box-shadow:inset 0 0 40px rgba(0,0,0,.75), 0 0 0 6px rgba(232,185,74,.08);
    backdrop-filter: blur(1.5px);
  }
  #fxCanvas{position:absolute;inset:10px;pointer-events:none;z-index:5;}
  .reel-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    grid-template-rows:repeat(3,1fr);
    gap:8px;
    position:relative;z-index:2;
  }
  .reel-cell{
    position:relative;
    aspect-ratio:1/1;
    background:linear-gradient(160deg, rgba(20, 52, 96, 0.65), rgba(10, 33, 71, 0.75));
    border:1px solid rgba(42, 74, 122, 0.7);
    border-radius:8px;
    perspective:600px;
    overflow:hidden;
    user-select:none;
  }
  .reel-cell.locked{
    border-color:var(--gold);
    box-shadow:0 0 0 2px var(--gold), 0 0 16px 2px rgba(232,185,74,.7);
    animation:pulseGold 1.4s ease-in-out infinite;
  }
  @keyframes pulseGold{
    0%,100%{box-shadow:0 0 0 2px var(--gold), 0 0 10px 1px rgba(232,185,74,.5);}
    50%{box-shadow:0 0 0 2px var(--gold-light), 0 0 22px 4px rgba(232,185,74,.9);}
  }
  .symbol-canvas{
    width:100%;height:100%;
    display:block;
    transform-style:preserve-3d;
    pointer-events:none;
    -webkit-user-drag:none;
    user-select:none;
  }
  .symbol-canvas.spinning{filter:blur(2.5px) brightness(1.15);}
  .symbol-canvas.landing{animation:flip3d .45s ease;}
  @keyframes flip3d{
    0%{transform:rotateY(95deg) scale(.85);opacity:.3;}
    55%{transform:rotateY(-12deg) scale(1.06);opacity:1;}
    100%{transform:rotateY(0) scale(1);opacity:1;}
  }
  .lock-badge{
    position:absolute;left:0;right:0;bottom:3px;text-align:center;
    font-size:.68rem;font-weight:800;color:#1a1306;
    background:linear-gradient(180deg,var(--gold-light),var(--gold));
    border-radius:6px;margin:0 6px;padding:1px 0;
    box-shadow:0 2px 6px rgba(0,0,0,.5);
    display:none;
  }
  .reel-cell.locked .lock-badge{display:block;}

  .bonus-banner{
    position:absolute;top:14px;left:50%;transform:translateX(-50%);
    background:linear-gradient(180deg,#3a0d1f,#1a0510);
    border:2px solid var(--gold);border-radius:10px;
    padding:8px 22px;text-align:center;z-index:10;
    box-shadow:0 10px 30px rgba(0,0,0,.6);
    display:none;
  }
  .bonus-banner.show{display:block;animation:popIn .35s ease;}
  @keyframes popIn{0%{transform:translateX(-50%) scale(.6);opacity:0;}100%{transform:translateX(-50%) scale(1);opacity:1;}}
  .bonus-banner h5{color:var(--gold-light);margin:0;font-weight:800;letter-spacing:1px;}
  .bonus-banner small{color:#dce6f7;}

  /* ---------- bottom bar ---------- */
  .bottombar{
    display:flex;align-items:center;justify-content:space-between;gap:10px;
    background:#0a1c3a;
    padding:10px 14px;flex-wrap:wrap;
  }
  .pill-box{
    background:linear-gradient(180deg,#173b6e,#0e2a52);
    border:1px solid var(--teal);
    border-radius:20px;
    padding:5px 16px;text-align:center;min-width:120px;
  }
  .pill-box .lbl{font-size:.6rem;letter-spacing:1px;color:#8fd9cd;display:block;}
  .pill-box .val{font-weight:700;font-size:.95rem;color:#fff;}
  .bet-controls{display:flex;align-items:center;gap:6px;}
  .round-btn{
    width:34px;height:34px;border-radius:50%;border:1px solid var(--teal);
    background:#0e2a52;color:#cfe;font-size:1rem;font-weight:700;
  }
  .round-btn:active{transform:scale(.92);}
  .icon-btn-sq{
    width:38px;height:38px;border-radius:10px;border:1px solid #2a4a7a;
    background:#0e2a52;color:#dce6f7;
  }
  .spin-btn{
    width:74px;height:74px;border-radius:50%;border:none;
    background:radial-gradient(circle at 35% 30%, #ffe9a8, var(--gold) 55%, var(--gold-dark) 100%);
    box-shadow:0 0 0 5px #0a1c3a, 0 0 0 8px var(--gold-dark), 0 12px 26px rgba(0,0,0,.55);
    font-size:1.7rem;color:#3a2a06;
    display:flex;align-items:center;justify-content:center;
  }
  .spin-btn i{transition:transform .2s;}
  .spin-btn.spinning i{animation:spinRot .7s linear infinite;}
  @keyframes spinRot{to{transform:rotate(360deg);}}
  .spin-btn:active{transform:scale(.95);}
  .spin-btn:disabled{opacity:.55;}


  .disclaimer{
    text-align:center;font-size:.68rem;color:#5f7aac;padding:6px 14px 10px;
  }

  .toast-msg{
    position:fixed;bottom:52px;left:50%;transform:translateX(-50%);
    background:var(--gold);color:#2a1f06;padding:8px 18px;border-radius:8px;
    font-weight:700;box-shadow:0 8px 22px rgba(0,0,0,.4);z-index:150;
    opacity:0;transition:opacity .3s;
  }
  .toast-msg.show{opacity:1;}

  @media (max-width:560px){
    .game-logo{font-size:1.55rem;}
    .pill-box{min-width:96px;padding:4px 10px;}
    .spin-btn{width:60px;height:60px;font-size:1.3rem;}
    .jp-label{font-size:.62rem;}
    .jp-amt{font-size:.78rem;}
  }

  /* Fixed Footer bar styling matching 1xbet dashboard theme */
  .footerbar {
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
  .footerbar .tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: color 0.2s;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 11px;
    color: #8ca3c7;
    text-decoration: none;
  }
  .footerbar .tab:hover, .footerbar .tab.active {
    color: #fff;
  }
  .footerbar input {
    background: rgba(26, 48, 96, 0.6);
    border: 1px solid #2a5090;
    color: #fff;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 11px;
    width: 180px;
    outline: none;
  }
  .footerbar .layout-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: 6px;
    cursor: pointer;
  }
  .slot-game-container.expanded {
    max-width: 100%;
    border-radius: 0;
    border: none;
    box-shadow: none;
  }
</style>
</head>
<body>

<canvas id="bgCanvas"></canvas>

<div id="gameWrapper">
  <!-- TOP NAV (1XBET STYLE) -->
  <div class="topnav">
    <div class="breadcrumb">
      <a href="{{ route('dashboard') }}"><i class="fa-solid fa-house"></i> Home</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Slots</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Popular</a>
      <span>/</span>
      <span style="color:#fff; font-weight:bold;">Royal Emirates</span>
    </div>
    <div class="gametitle">ROYAL EMIRATES</div>
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

  <div class="main-layout-container">
    <div class="slot-game-container" id="frame">

      <div class="subheader">
        <div class="game-name"><i class="fa-solid fa-dice"></i>Royal Emirates Hold and Spin</div>
        
        <!-- Interactive Real Money vs Demo toggle -->
        <div class="rmToggle">
          <div class="togSwitch" id="rmToggle">
            <div class="togDot"></div>
          </div>
          <span id="rmToggleLabel">PLAY FOR REAL MONEY</span>
        </div>

        <div class="header-icons">
          <button id="btnPaytable" title="Paytable / Rules"><i class="fa-solid fa-table-list"></i></button>
          <button id="btnExpand" title="Expand"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          <button id="btnReload" title="Reset game"><i class="fa-solid fa-arrow-rotate-right"></i></button>
          <button id="btnMute" title="Mute/Unmute" style="color: var(--gold-light);" onclick="toggleMute()"><i id="muteIcon" class="fa-solid fa-volume-high"></i></button>
          <button id="btnFav" title="Favorite"><i class="fa-regular fa-star"></i></button>
          <button id="btnClose" title="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
      </div>

      <div class="viewport" id="viewport">

        <div class="jackpot-bar">
          <div class="jp grand"><span class="jp-label">GRAND</span><span class="jp-amt" id="jpGrand">5,000.00</span></div>
          <div class="jp mega"><span class="jp-label">MEGA</span><span class="jp-amt" id="jpMega">50.00</span></div>
          <div class="logo-area">
            <h1 class="game-logo display-font">Royal <span>Emirates</span></h1>
            <p class="game-subtitle">Hold and Spin</p>
          </div>
          <div class="jp minor"><span class="jp-label">MINOR</span><span class="jp-amt" id="jpMinor">25.00</span></div>
          <div class="jp mini"><span class="jp-label">MINI</span><span class="jp-amt" id="jpMini">10.00</span></div>
        </div>

        <div class="reel-frame" id="reelFrame">
          <div class="bonus-banner" id="bonusBanner">
            <h5>HOLD &amp; SPIN!</h5>
            <small id="bonusSub">3 respins remaining</small>
          </div>
          <canvas id="fxCanvas"></canvas>
          <div class="reel-grid" id="reelGrid"></div>
        </div>

      </div>

      <div class="bottombar">
        <button class="icon-btn-sq" id="btnMenu"><i class="fa-solid fa-bars"></i></button>
        <div class="pill-box">
          <span class="lbl">BALANCE</span>
          <span class="val" id="balanceDisplay">US$ 1,000.00</span>
        </div>
        <div class="bet-controls">
          <button class="round-btn" id="betMinus">-</button>
          <div class="pill-box">
            <span class="lbl">BET</span>
            <span class="val" id="betDisplay">US$ 1.00</span>
          </div>
          <button class="round-btn" id="betPlus">+</button>
        </div>
        <button class="icon-btn-sq" id="btnFast" title="Turbo spin"><i class="fa-solid fa-forward"></i></button>
        <button class="spin-btn" id="spinBtn" title="Spin"><i class="fa-solid fa-rotate"></i></button>
      </div>

    </div>
  </div>

  <!-- FIXED BOTTOM FOOTER BAR -->
  <div class="footerbar">
    <div>
      <span class="tab active" id="tabRecent" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-regular fa-clock"></i> RECENT GAMES</span>
      <span class="tab" id="tabFav" style="margin-left:14px;" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-regular fa-star"></i> FAVORITES</span>
    </div>
    <input type="text" placeholder="Search" class="d-none d-md-inline-block" disabled>
    <div>
      <span class="layout-dot" style="background:#fff" data-c="1"></span>
      <span class="layout-dot" style="background:#3a6bb0" data-c="2"></span>
      <span class="layout-dot" style="background:#214a86" data-c="3"></span>
      <span class="layout-dot" style="background:#173b6e" data-c="4"></span>
    </div>
  </div>

  <div class="disclaimer">Fan-made coding demo inspired by Arabian-themed jackpot slots &middot; original artwork &amp; branding &middot; play-money only, for entertainment &amp; learning purposes.</div>
</div>

<div class="toast-msg" id="toast"></div>

<!-- Paytable Modal -->
<div class="modal fade" id="paytableModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0e2a52;color:#eef3fb;border:1px solid var(--gold-dark);">
      <div class="modal-header" style="border-color:rgba(232,185,74,.3)">
        <h5 class="modal-title"><i class="fa-solid fa-gem" style="color:var(--gold)"></i> Paytable &amp; Rules</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="paytableBody">
        <p class="small">Lines pay left-to-right, 3+ matching symbols starting from reel 1, on any of the 3 rows.</p>
        <table class="table table-sm table-borderless" style="color:inherit" id="payRows"></table>
        <hr style="border-color:rgba(232,185,74,.25)">
        <p class="small mb-1"><strong>Tower symbol</strong> doesn't pay on lines — land <strong>6 or more</strong> anywhere on the grid to trigger <strong>HOLD &amp; SPIN</strong>. Locked towers carry cash or a jackpot tier (Mini/Minor/Mega/Grand). Every new tower resets your respins to 3. Fill all 15 positions to win the full <strong>GRAND</strong> jackpot!</p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
"use strict";

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
  
  playSpin() {
    this.ensureAudio();
    if (this.musicSynth) this.musicSynth.duck();
    if (this.spinInterval) clearInterval(this.spinInterval);
    
    let tickCount = 0;
    this.spinInterval = setInterval(() => {
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
    this.beep(160 + reelIndex * 15, 0.12, 'triangle', 0.22);
    this.beep(60, 0.15, 'sine', 0.35); 
  }
  
  playWin() {
    this.stopSpin();
    const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50];
    notes.forEach((freq, idx) => {
      this.beep(freq, 0.3, 'square', 0.08, idx * 80);
    });
  }
  
  playCoinRollup() {
    this.beep(987.77 + Math.random() * 200, 0.05, 'sine', 0.08);
  }
  
  toggleMute() {
    this.muted = !this.muted;
    const icon = document.getElementById('muteIcon');
    if (this.muted) {
      icon.className = 'fa-solid fa-volume-xmark';
      if (this.musicSynth) this.musicSynth.stop();
    } else {
      icon.className = 'fa-solid fa-volume-high';
      this.ensureAudio();
      if (this.musicSynth) this.musicSynth.start();
    }
  }
}

const soundEngine = new SlotSoundEngine();

function toggleMute() {
  soundEngine.toggleMute();
}

// Ensure audio context is unlocked upon first interaction
document.addEventListener('click', () => {
  soundEngine.ensureAudio();
}, { once: true });


/* ===================== SYMBOL DEFINITIONS ===================== */
const SYMS = ['hookah','lady','dagger','tower','jug','car','sheikh','gem'];
const WEIGHTS = { hookah:18, lady:18, dagger:17, jug:16, car:11, sheikh:14, gem:6, tower:9 };
const PAYTABLE = { hookah:4, lady:6, dagger:5, jug:6, car:14, sheikh:9, gem:22 };
const PAY_NAMES = { hookah:'Desert Hookah', lady:'Desert Princess', dagger:'Curved Dagger', jug:'Golden Pitcher', car:'Royal Carriage', sheikh:'Golden Sultan', gem:'Wild Gem (Wild)' };

const symbolImageMap = {
  hookah: '1.png',
  lady: '2.png',
  dagger: '3.png',
  jug: '4.png',
  car: '5.png',
  sheikh: '6.png',
  gem: '7.png',
  tower: '8.png'
};

const imgCache = {};
Object.keys(symbolImageMap).forEach(key => {
  const img = new Image();
  img.onload = () => {
    // Redraw any cells displaying this symbol once loaded
    if (typeof cells !== 'undefined' && cells.length > 0) {
      cells.forEach(c => {
        if (c.key === key && !c.canvas.classList.contains('spinning')) {
          drawSymbol(c.ctx, key, RES, RES, key === 'tower' || key === 'gem');
        }
      });
    }
    // Redraw paytable elements
    document.querySelectorAll('.pt-ic').forEach(cv => {
      if (cv.dataset.k === key) {
        drawSymbol(cv.getContext('2d'), key, 36, 36, false);
      }
    });
  };
  img.src = `{{ asset('assets/image/Royal Emirates Hold and Spin') }}/${symbolImageMap[key]}`;
  imgCache[key] = img;
});

function weightedRandom(excludeTower){
  let pool = SYMS;
  let w = {...WEIGHTS};
  if(excludeTower) w.tower = 0;
  let total = pool.reduce((s,k)=>s+w[k],0);
  let r = Math.random()*total;
  for(const k of pool){ r -= w[k]; if(r<=0) return k; }
  return pool[pool.length-1];
}

/* ===================== CANVAS ICON DRAWING ===================== */
function drawSymbol(ctx,key,w,h,glow){
  ctx.clearRect(0,0,w,h);
  const img = imgCache[key];
  if (img && img.complete) {
    ctx.save();
    if (glow) {
      if (key === 'tower') {
        ctx.shadowColor = '#4fc3f7';
        ctx.shadowBlur = 16;
      } else if (key === 'gem') {
        ctx.shadowColor = '#ffe9a8';
        ctx.shadowBlur = 18;
      }
    }
    // Draw the image onto the cell canvas
    ctx.drawImage(img, 2, 2, w - 4, h - 4);
    ctx.restore();
  } else {
    // Fallback loading block
    ctx.fillStyle = 'rgba(14, 42, 80, 0.4)';
    ctx.fillRect(0, 0, w, h);
    ctx.strokeStyle = '#1a3a6a';
    ctx.strokeRect(0, 0, w, h);
  }
}

/* ===================== GRID / STATE ===================== */
const ROWS=3, COLS=5, RES=130;
let cells = [];
let lockedValues = new Array(ROWS*COLS).fill(null);
let spinning=false, inBonus=false, spinsRemaining=0;

const DENOMS=[0.20,0.50,1,2,5,10,25,50,100];
let betIndex=2;

// ---- GAME STATE & BALANCE DATABASE INTEGRATION ----
let realBalance = parseFloat("{{ auth()->user()->balance }}");
let isDemoMode = new URLSearchParams(window.location.search).get('demo') === '1' || (realBalance < 0.20);
let demoBalance = 1000.00;
let balance = isDemoMode ? demoBalance : realBalance;

const currency = "{{ auth()->user()->currency }}";
const currencySymbolMap = {
  'EUR': '€',
  'USD': '$',
  'BDT': '৳',
  'GBP': '£',
  'INR': '₹'
};
const currencySymbol = currencySymbolMap[currency] || (currency + ' ');

let jackpots = { mini:10.00, minor:25.00, mega:50.00, grand:5000.00 };

const reelGridEl = document.getElementById('reelGrid');
const balanceDisplay = document.getElementById('balanceDisplay');
const betDisplay = document.getElementById('betDisplay');
const spinBtn = document.getElementById('spinBtn');
const bonusBanner = document.getElementById('bonusBanner');
const bonusSub = document.getElementById('bonusSub');

function money(v){ return v.toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function currentBet(){ return DENOMS[betIndex]; }

function buildGrid(){
  reelGridEl.innerHTML='';
  cells=[];
  for(let r=0;r<ROWS;r++){
    for(let c=0;c<COLS;c++){
      const idx=r*COLS+c;
      const cell=document.createElement('div');
      cell.className='reel-cell';
      const canvas=document.createElement('canvas');
      canvas.className='symbol-canvas';
      canvas.width=RES; canvas.height=RES;
      const badge=document.createElement('div');
      badge.className='lock-badge';
      cell.appendChild(canvas);
      cell.appendChild(badge);
      reelGridEl.appendChild(cell);
      const key = weightedRandom(false);
      const obj={el:cell,canvas:canvas,ctx:canvas.getContext('2d'),badge:badge,row:r,col:c,idx:idx,key:key};
      cells.push(obj);
      drawSymbol(obj.ctx,key,RES,RES,key==='tower');
    }
  }
}
buildGrid();

/* ===================== NORMAL SPIN ===================== */
function setSpinUiBusy(busy){
  spinBtn.disabled=busy;
  spinBtn.classList.toggle('spinning',busy);
}

function animateColumn(colCells, finalKeys, delay, onDone){
  const ivs = colCells.map(c=>{
    c.canvas.classList.add('spinning');
    return setInterval(()=>{
      drawSymbol(c.ctx, weightedRandom(true), RES, RES, false);
    }, 45);
  });
  setTimeout(()=>{
    ivs.forEach(iv=>clearInterval(iv));
    colCells.forEach((c,i)=>{
      c.key = finalKeys[i];
      c.canvas.classList.remove('spinning');
      drawSymbol(c.ctx, c.key, RES, RES, c.key==='tower');
      c.canvas.classList.add('landing');
      setTimeout(()=>c.canvas.classList.remove('landing'),460);
    });
    onDone();
  }, delay);
}

function doNormalSpin(){
  if(spinning || inBonus) return;
  const bet = currentBet();
  
  if(balance < bet){
    if (isDemoMode) {
      showToast('Demo balance insufficient! Refilling...');
      balance = 1000.00;
      updateBalanceUi();
    } else {
      showToast('Not enough real balance — lower your bet or deposit.');
      return;
    }
  }
  
  spinning=true; setSpinUiBusy(true);
  balance -= bet; updateBalanceUi();
  
  // Increase jackpots on bet placement (not auto-mined)
  jackpots.mini += bet * 0.002;
  jackpots.minor += bet * 0.004;
  jackpots.mega += bet * 0.010;
  jackpots.grand += bet * 0.025;
  updateJackpotUi();
  
  if(!isDemoMode){
    realBalance = balance;
    syncBalance(balance);
  }

  soundEngine.playSpin();

  let doneCols=0;
  for(let c=0;c<COLS;c++){
    const colCells=[0,1,2].map(r=>cells[r*COLS+c]);
    const finalKeys=colCells.map(()=>weightedRandom(false));
    const delay = 650 + c*260;
    animateColumn(colCells, finalKeys, delay, ()=>{
      doneCols++;
      soundEngine.playReelStop(c);
      if(doneCols===COLS){
        spinning=false; setSpinUiBusy(false);
        evaluateBoard(bet);
      }
    });
  }
}

/* ===================== WIN EVALUATION ===================== */
function evaluateBoard(bet){
  const towerCount = cells.filter(c=>c.key==='tower').length;
  if(towerCount>=6){
    startHoldAndSpin();
    return;
  }
  let totalWin=0;
  let winSymbols=[];
  for(let r=0;r<ROWS;r++){
    const rowKeys=[0,1,2,3,4].map(c=>cells[r*COLS+c].key);
    const first=rowKeys[0];
    if(first==='tower') continue;
    let count=1;
    while(count<5 && rowKeys[count]===first) count++;
    if(count>=3){
      const mult = count===3?1:(count===4?3:10);
      totalWin += bet*PAYTABLE[first]*mult;
      winSymbols.push(first);
    }
  }
  
  if (soundEngine.musicSynth) soundEngine.musicSynth.unduck();
  
  if(totalWin>0){
    balance += totalWin; updateBalanceUi();
    if(!isDemoMode){
      realBalance = balance;
      syncBalance(balance);
    }
    soundEngine.playWin();
    showToast('You won ' + currencySymbol + money(totalWin)+'!');
    triggerCoinBurst(false);
  }
}

/* ===================== HOLD & SPIN BONUS ===================== */
function randomCreditAward(bet){
  const r=Math.random();
  if(r<0.55){
    const v = bet*(1+Math.floor(Math.random()*8));
    return {label:currencySymbol+money(v), value:v};
  }
  if(r<0.75) return {label:'MINI', value:jackpots.mini};
  if(r<0.90) return {label:'MINOR', value:jackpots.minor};
  if(r<0.97) return {label:'MEGA', value:jackpots.mega};
  return {label:'GRAND', value:jackpots.grand};
}

function lockCell(c, bet){
  const award = randomCreditAward(bet);
  lockedValues[c.idx]=award;
  c.el.classList.add('locked');
  c.badge.textContent = award.label;
}

function startHoldAndSpin(){
  inBonus=true; spinsRemaining=3;
  const bet=currentBet();
  cells.forEach(c=>{ if(c.key==='tower') lockCell(c,bet); });
  bonusBanner.classList.add('show');
  bonusSub.textContent = spinsRemaining+' respins remaining';
  spinBtn.innerHTML='<i class="fa-solid fa-rotate-right"></i>';
  showToast('HOLD & SPIN triggered!');
}

function doBonusSpin(){
  if(spinning) return;
  spinning=true; setSpinUiBusy(true);
  const unlocked = cells.filter(c=>!c.el.classList.contains('locked'));
  let doneCols=0;
  const byCol={};
  unlocked.forEach(c=>{ (byCol[c.col]=byCol[c.col]||[]).push(c); });
  const colKeys=Object.keys(byCol);
  if(colKeys.length===0){ spinning=false; setSpinUiBusy(false); endHoldAndSpin(); return; }

  soundEngine.playSpin();

  colKeys.forEach((colStr,ci)=>{
    const colCells=byCol[colStr];
    const finalKeys=colCells.map(()=>weightedRandom(false));
    const delay=550+ci*220;
    animateColumn(colCells, finalKeys, delay, ()=>{
      doneCols++;
      soundEngine.playReelStop(parseInt(colStr));
      if(doneCols===colKeys.length){
        let newLock=false;
        const bet=currentBet();
        colCells.forEach((c,i)=>{
          if(c.key==='tower'){ lockCell(c,bet); newLock=true; }
        });
        if(newLock){
          spinsRemaining=3;
        } else {
          spinsRemaining--;
        }
        const lockedCount = cells.filter(c=>c.el.classList.contains('locked')).length;
        spinning=false; setSpinUiBusy(false);
        if(lockedCount>=ROWS*COLS || spinsRemaining<=0){
          endHoldAndSpin();
        } else {
          bonusSub.textContent = spinsRemaining+' respins remaining';
        }
      }
    });
  });
}

function endHoldAndSpin(){
  const lockedCount = cells.filter(c=>c.el.classList.contains('locked')).length;
  let sum=0;
  let miniWon = false, minorWon = false, megaWon = false, grandWon = false;

  if(lockedCount>=ROWS*COLS){
    sum = jackpots.grand;
    grandWon = true;
  } else {
    lockedValues.forEach(v=>{
      if(v) {
        sum+=v.value;
        if (v.label === 'MINI') miniWon = true;
        if (v.label === 'MINOR') minorWon = true;
        if (v.label === 'MEGA') megaWon = true;
        if (v.label === 'GRAND') grandWon = true;
      }
    });
  }
  balance += sum; updateBalanceUi();
  if(!isDemoMode){
    realBalance = balance;
    syncBalance(balance);
  }
  soundEngine.playWin();
  showToast('Bonus complete! +' + currencySymbol + money(sum));
  triggerCoinBurst(true);
  
  // Reset won jackpots to their base values
  if (grandWon) jackpots.grand = 5000.00;
  if (megaWon) jackpots.mega = 50.00;
  if (minorWon) jackpots.minor = 25.00;
  if (miniWon) jackpots.mini = 10.00;
  updateJackpotUi();

  if (soundEngine.musicSynth) soundEngine.musicSynth.unduck();

  setTimeout(()=>{
    cells.forEach(c=>{
      c.el.classList.remove('locked');
      c.badge.textContent='';
    });
    lockedValues = new Array(ROWS*COLS).fill(null);
    inBonus=false;
    bonusBanner.classList.remove('show');
    spinBtn.innerHTML='<i class="fa-solid fa-rotate"></i>';
  }, 1600);
}

/* ===================== SPIN BUTTON ===================== */
spinBtn.addEventListener('click', ()=>{
  if(inBonus) doBonusSpin(); else doNormalSpin();
});

/* ===================== JACKPOT TICKER ===================== */
function updateJackpotUi(){
  document.getElementById('jpGrand').textContent = money(jackpots.grand);
  document.getElementById('jpMega').textContent = money(jackpots.mega);
  document.getElementById('jpMinor').textContent = money(jackpots.minor);
  document.getElementById('jpMini').textContent = money(jackpots.mini);
}
// Auto-mining jackpot ticker is disabled. Jackpots now increase only when betting.
updateJackpotUi();

/* ===================== BALANCE / BET UI ===================== */
function updateBalanceUi(){
  balanceDisplay.textContent = currencySymbol + ' ' + money(balance);
}
function updateBetUi(){
  betDisplay.textContent = currencySymbol + ' ' + money(currentBet());
}
document.getElementById('betMinus').addEventListener('click',()=>{
  if(inBonus||spinning) return;
  betIndex = Math.max(0, betIndex-1); updateBetUi();
});
document.getElementById('betPlus').addEventListener('click',()=>{
  if(inBonus||spinning) return;
  betIndex = Math.min(DENOMS.length-1, betIndex+1); updateBetUi();
});

/* ===================== PLAY MODE TOGGLE MECHANICS ===================== */
const rmToggle = document.getElementById('rmToggle');
const rmToggleLabel = document.getElementById('rmToggleLabel');

function updateModeUI() {
  if (isDemoMode) {
    rmToggle.classList.remove('on');
    rmToggleLabel.textContent = 'PLAY FOR REAL MONEY';
    balance = demoBalance;
  } else {
    if (realBalance < currentBet()) {
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
  updateBalanceUi();
  updateBetUi();
}

rmToggle.addEventListener('click', function() {
  if (spinning) return;
  isDemoMode = !isDemoMode;
  updateModeUI();
});

/* ===================== DATABASE BALANCE SYNC ===================== */
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

/* ===================== TOAST ===================== */
let toastTimer=null;
function showToast(msg){
  const t=document.getElementById('toast');
  t.textContent=msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer=setTimeout(()=>t.classList.remove('show'), 2400);
}

/* ===================== HEADER BUTTONS ===================== */
document.getElementById('btnFav').addEventListener('click',(e)=>{
  const btn=e.currentTarget;
  btn.classList.toggle('fav-active');
  const icon=btn.querySelector('i');
  icon.className = btn.classList.contains('fav-active') ? 'fa-solid fa-star' : 'fa-regular fa-star';
});
document.getElementById('btnExpand').addEventListener('click',()=>{
  document.getElementById('frame').classList.toggle('expanded');
});
document.getElementById('btnReload').addEventListener('click',()=>{
  balance=1000; betIndex=2; jackpots={mini:10,minor:25,mega:50,grand:5000};
  inBonus=false; spinsRemaining=0; spinning=false;
  lockedValues=new Array(ROWS*COLS).fill(null);
  bonusBanner.classList.remove('show');
  spinBtn.innerHTML='<i class="fa-solid fa-rotate"></i>';
  buildGrid(); updateBalanceUi(); updateBetUi(); updateJackpotUi();
  showToast('Game reset.');
});
document.getElementById('btnClose').addEventListener('click',()=>{
  window.location.href = "{{ route('dashboard') }}";
});
document.getElementById('btnPaytable').addEventListener('click',()=>{
  new bootstrap.Modal(document.getElementById('paytableModal')).show();
});
document.getElementById('btnMenu').addEventListener('click',()=>{
  showToast('Menu — demo only.');
});
document.getElementById('btnFast').addEventListener('click',(e)=>{
  e.currentTarget.classList.toggle('fav-active');
  showToast('Turbo spin '+(e.currentTarget.classList.contains('fav-active')?'enabled':'disabled')+' (demo).');
});

/* ===================== PAYTABLE BODY ===================== */
(function buildPaytable(){
  const tbody=document.getElementById('payRows');
  Object.keys(PAYTABLE).forEach(k=>{
    const tr=document.createElement('tr');
    tr.innerHTML = '<td style="width:40px"><canvas width="36" height="36" class="pt-ic" data-k="'+k+'"></canvas></td>'+
                   '<td>'+PAY_NAMES[k]+'</td><td class="text-end">x'+PAYTABLE[k]+' bet</td>';
    tbody.appendChild(tr);
  });
  document.querySelectorAll('.pt-ic').forEach(cv=>{
    drawSymbol(cv.getContext('2d'), cv.dataset.k, 36, 36, false);
  });
})();

/* ===================== COIN BURST FX ===================== */
const fxCanvas=document.getElementById('fxCanvas');
const fxCtx=fxCanvas.getContext('2d');
let particles=[];
function resizeFx(){
  const rect=document.getElementById('reelFrame').getBoundingClientRect();
  fxCanvas.width = rect.width-20;
  fxCanvas.height = rect.height-20;
}
resizeFx();
window.addEventListener('resize', resizeFx);

function triggerCoinBurst(big){
  const n = big?70:28;
  for(let i=0;i<n;i++){
    particles.push({
      x: fxCanvas.width*0.5 + (Math.random()-0.5)*fxCanvas.width*0.6,
      y: fxCanvas.height*0.2 + Math.random()*20,
      vx:(Math.random()-0.5)*4,
      vy:-(Math.random()*6+3),
      rot:Math.random()*Math.PI,
      vr:(Math.random()-0.5)*0.3,
      size:8+Math.random()*8,
      life:1
    });
  }
}
function fxLoop(){
  fxCtx.clearRect(0,0,fxCanvas.width,fxCanvas.height);
  particles.forEach(p=>{
    p.vy += 0.28; p.x+=p.vx; p.y+=p.vy; p.rot+=p.vr; p.life-=0.012;
    fxCtx.save();
    fxCtx.globalAlpha=Math.max(p.life,0);
    fxCtx.translate(p.x,p.y);
    fxCtx.rotate(p.rot);
    const g=fxCtx.createLinearGradient(-p.size,-p.size,p.size,p.size);
    g.addColorStop(0,'#fff6da'); g.addColorStop(1,'#caa01f');
    fxCtx.fillStyle=g;
    fxCtx.beginPath();
    fxCtx.ellipse(0,0,p.size*0.5,p.size*0.5,0,0,Math.PI*2);
    fxCtx.fill();
    fxCtx.restore();
  });
  particles = particles.filter(p=>p.life>0 && p.y<fxCanvas.height+40);
  requestAnimationFrame(fxLoop);
}
fxLoop();

/* ===================== AMBIENT STARFIELD BG ===================== */
const bg=document.getElementById('bgCanvas');
const bgCtx=bg.getContext('2d');
let stars=[];
function resizeBg(){
  bg.width=window.innerWidth; bg.height=window.innerHeight;
  stars=[];
  const n=Math.floor((bg.width*bg.height)/9000);
  for(let i=0;i<n;i++){
    stars.push({x:Math.random()*bg.width,y:Math.random()*bg.height*0.75,r:Math.random()*1.6+0.3,phase:Math.random()*Math.PI*2,speed:0.02+Math.random()*0.03});
  }
}
resizeBg();
window.addEventListener('resize', resizeBg);

let t=0;
function bgLoop(){
  t+=1;
  const sky=bgCtx.createLinearGradient(0,0,0,bg.height);
  sky.addColorStop(0,'#020815');
  sky.addColorStop(0.55,'#071b3a');
  sky.addColorStop(1,'#0c2a55');
  bgCtx.fillStyle=sky;
  bgCtx.fillRect(0,0,bg.width,bg.height);

  const moonG=bgCtx.createRadialGradient(bg.width*0.82,bg.height*0.12,5,bg.width*0.82,bg.height*0.12,140);
  moonG.addColorStop(0,'rgba(255,243,200,.25)');
  moonG.addColorStop(1,'rgba(255,243,200,0)');
  bgCtx.fillStyle=moonG;
  bgCtx.fillRect(0,0,bg.width,bg.height);

  stars.forEach(s=>{
    const tw = 0.5+0.5*Math.sin(t*s.speed+s.phase);
    bgCtx.globalAlpha = 0.25+tw*0.75;
    bgCtx.fillStyle='#eaf3ff';
    bgCtx.beginPath();
    bgCtx.arc(s.x,s.y,s.r,0,Math.PI*2);
    bgCtx.fill();
  });
  bgCtx.globalAlpha=1;

  bgCtx.fillStyle='rgba(3,10,22,.9)';
  const baseY=bg.height*0.86;
  bgCtx.fillRect(0,baseY,bg.width,bg.height-baseY);
  for(let x=0;x<bg.width;x+=70){
    const hgt=30+ (Math.sin(x*0.05)+1)*18;
    bgCtx.beginPath();
    bgCtx.moveTo(x,baseY);
    bgCtx.lineTo(x+12,baseY-hgt);
    bgCtx.lineTo(x+24,baseY-hgt*0.4);
    bgCtx.lineTo(x+35,baseY-hgt);
    bgCtx.lineTo(x+47,baseY);
    bgCtx.closePath();
    bgCtx.fill();
  }
  requestAnimationFrame(bgLoop);
}
bgLoop();

// Initialize toggle
updateModeUI();

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

// Disable context menu (right click) on the game container to prevent symbol image inspection
document.getElementById('frame').addEventListener('contextmenu', e => e.preventDefault());

})();
</script>
</body>
</html>
