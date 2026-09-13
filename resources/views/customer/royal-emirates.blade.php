<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Royal Emirates: Hold and Spin™</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Noto+Sans+Bengali:wght@400;600;700;800&family=JetBrains+Mono:wght@700;800&display=swap" rel="stylesheet">
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
    font-family:'Outfit','Noto Sans Bengali',sans-serif;
    color:var(--text-light);
    overflow-x:hidden;
  }
  .display-font{
    font-family:'Brush Script MT','Segoe Script','Comic Sans MS',cursive;
  }
  #bgCanvas{
    position:fixed;inset:0;width:100vw;height:100vh;z-index:0;display:block;
  }

  /* ---------- FULL PAGE SHELL ---------- */
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
    position: relative;
    height: 50px;
    z-index: 100;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    font-size: 11px;
    color: #8ca3c7;
  }
  .topnav .breadcrumb { color: #8ca3c7; font-size: 11px; display: flex; align-items: center; gap: 4px; font-weight: 600; margin: 0; }
  .topnav .breadcrumb a { color: #8ca3c7; text-decoration: none; transition: color 0.2s; }
  .topnav .breadcrumb a:hover { color: #fff; }
  .topnav .breadcrumb span { color: #4a7aaa; }
  .topnav .gametitle {
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .topnav .topNavRight { display: flex; align-items: center; gap: 16px; }
  .topnav .navIcons { display: flex; gap: 12px; }
  .topnav .navIcon { color: #8ca3c7; font-size: 14px; cursor: pointer; transition: color 0.2s; user-select: none; }
  .topnav .navIcon:hover { color: #f5c842; }

  .sidenav {
    position: fixed;
    left: 0;
    top: 70px;
    bottom: 40px;
    width: 54px;
    background: #0f223f;
    border-right: 2px solid #1d3354;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
    gap: 20px;
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
    text-decoration: none;
  }
  .sidenav .icon-btn:hover, .sidenav .icon-btn.active {
    background: rgba(26, 118, 210, 0.2);
    color: #fff;
  }

  .main-layout-container {
    display: flex;
    flex: 1;
    margin-left: 54px;
    margin-top: 0;
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
    max-width: 940px;
    background: linear-gradient(180deg, var(--bg-panel) 0%, var(--bg-night) 100%);
    border: 2px solid var(--gold-dark);
    border-radius: 16px;
    box-shadow: 0 25px 60px rgba(0,0,0,.65), inset 0 0 40px rgba(0,0,0,.4);
    overflow: hidden;
    position: relative;
  }

  /* ---------- sub header ---------- */
  .subheader{
    background:linear-gradient(90deg,#143460,#1b437c,#143460);
    padding:10px 16px;
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;
    border-bottom:1.5px solid rgba(232,185,74,.4);
  }
  .subheader .game-name{font-weight:800;font-size:1rem;color:#fff;display:flex;align-items:center;}
  .subheader .game-name i{color:var(--gold);margin-right:8px;}
  
  /* Dual Mode Selector Segmented Buttons */
  .mode-switch-group {
    display: flex;
    align-items: center;
    background: #06152b;
    border: 2px solid var(--gold);
    border-radius: 28px;
    padding: 4px;
    gap: 6px;
    box-shadow: 0 0 15px rgba(232, 185, 74, 0.35);
  }
  .mode-btn {
    border: none;
    font-size: 12px;
    font-weight: 800;
    padding: 7px 16px;
    border-radius: 22px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    color: #94a3b8;
    background: transparent;
    user-select: none;
  }
  .mode-btn:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.08);
  }
  .mode-btn.active-real {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    box-shadow: 0 0 16px rgba(16, 185, 129, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.4);
    transform: scale(1.02);
  }
  .mode-btn.active-demo {
    background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%);
    color: #ffffff;
    box-shadow: 0 0 16px rgba(6, 182, 212, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.4);
    transform: scale(1.02);
  }

  .header-icons button{
    background:transparent;border:1px solid rgba(255,255,255,.25);color:#dce6f7;
    width:32px;height:32px;border-radius:8px;margin-left:5px;font-size:.82rem;
    transition:.2s;
    cursor:pointer;
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
    background:linear-gradient(180deg, rgba(12, 35, 73, 0.92), rgba(10, 28, 58, 0.96));
    border:1.5px solid var(--gold-dark);
    border-radius:12px;
    padding:8px 14px 6px;
    margin-bottom:8px;
    flex-wrap:wrap;
    gap: 6px;
  }
  .jp{text-align:center;min-width:85px;}
  .jp-label{
    font-weight:800;font-size:.75rem;letter-spacing:1px;
    -webkit-text-stroke:.5px rgba(0,0,0,.3);
  }
  .jp.grand .jp-label{color:#ff5d8f;}
  .jp.mega .jp-label{color:#c9a6ff;}
  .jp.minor .jp-label{color:#7ec8ff;}
  .jp.mini .jp-label{color:#7df0c2;}
  .jp-amt{
    display:block;color:var(--gold-light);font-weight:800;font-size:.95rem;
    text-shadow:0 0 8px rgba(232,185,74,.6);
    font-family:'JetBrains Mono', monospace;
  }
  .logo-area{flex:1;text-align:center;min-width:200px;perspective:500px;}
  .game-logo{
    font-size:2.2rem;margin:0;line-height:1;
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
    margin:-4px 0 0;color:var(--gold-light);font-weight:800;letter-spacing:3px;font-size:.75rem;
    text-transform:uppercase;
  }

  /* Live Mode Status Bar */
  .mode-status-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(4, 13, 28, 0.75);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 4px 12px;
    margin-bottom: 8px;
    font-size: 11px;
  }

  .reel-frame{
    position:relative;
    border:3px solid var(--gold);
    border-radius:12px;
    background:rgba(6, 20, 43, 0.6);
    padding:10px;
    box-shadow:inset 0 0 40px rgba(0,0,0,.75), 0 0 0 6px rgba(232,185,74,.08);
    backdrop-filter: blur(2px);
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
    background:linear-gradient(160deg, rgba(20, 52, 96, 0.75), rgba(10, 33, 71, 0.85));
    border:1px solid rgba(42, 74, 122, 0.7);
    border-radius:8px;
    perspective:600px;
    overflow:hidden;
    user-select:none;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .reel-cell.locked{
    border-color:var(--gold) !important;
    box-shadow:0 0 0 2px var(--gold), 0 0 16px 3px rgba(232,185,74,.85) !important;
    animation:pulseGold 1.2s ease-in-out infinite;
  }
  @keyframes pulseGold{
    0%,100%{box-shadow:0 0 0 2px var(--gold), 0 0 10px 1px rgba(232,185,74,.6); transform: scale(1);}
    50%{box-shadow:0 0 0 2.5px var(--gold-light), 0 0 22px 5px rgba(232,185,74,.95); transform: scale(1.03);}
  }
  .symbol-canvas{
    width:100%;height:100%;
    display:block;
    transform-style:preserve-3d;
    pointer-events:none;
    user-select:none;
  }
  .symbol-canvas.spinning{filter:blur(3px) brightness(1.15);}
  .symbol-canvas.landing{animation:flip3d .4s ease;}
  @keyframes flip3d{
    0%{transform:rotateY(95deg) scale(.85);opacity:.3;}
    55%{transform:rotateY(-12deg) scale(1.06);opacity:1;}
    100%{transform:rotateY(0) scale(1);opacity:1;}
  }
  .lock-badge{
    position:absolute;left:0;right:0;bottom:3px;text-align:center;
    font-size:.72rem;font-weight:800;color:#1a1306;
    background:linear-gradient(180deg,var(--gold-light),var(--gold));
    border-radius:6px;margin:0 4px;padding:2px 0;
    box-shadow:0 2px 6px rgba(0,0,0,.6);
    display:none;
    font-family:'JetBrains Mono', monospace;
    z-index: 4;
  }
  .reel-cell.locked .lock-badge{display:block;}

  .bonus-banner{
    position:absolute;top:14px;left:50%;transform:translateX(-50%);
    background:linear-gradient(180deg,#3a0d1f,#1a0510);
    border:2px solid var(--gold);border-radius:10px;
    padding:8px 22px;text-align:center;z-index:10;
    box-shadow:0 10px 30px rgba(0,0,0,.7);
    display:none;
  }
  .bonus-banner.show{display:block;animation:popIn .35s ease;}
  @keyframes popIn{0%{transform:translateX(-50%) scale(.6);opacity:0;}100%{transform:translateX(-50%) scale(1);opacity:1;}}
  .bonus-banner h5{color:var(--gold-light);margin:0;font-weight:800;letter-spacing:1px;}
  .bonus-banner small{color:#dce6f7;font-weight:700;}

  /* ---------- bottom bar ---------- */
  .bottombar{
    display:flex;align-items:center;justify-content:space-between;gap:10px;
    background:#0a1c3a;
    padding:10px 16px;flex-wrap:wrap;
  }
  .pill-box{
    background:linear-gradient(180deg,#173b6e,#0e2a52);
    border:1px solid var(--teal);
    border-radius:20px;
    padding:6px 18px;text-align:center;min-width:130px;
  }
  .pill-box .lbl{font-size:.62rem;letter-spacing:1px;color:#8fd9cd;display:block;font-weight:700;}
  .pill-box .val{font-weight:800;font-size:.95rem;color:#fff;font-family:'JetBrains Mono', monospace;}
  .bet-controls{display:flex;align-items:center;gap:6px;}
  .round-btn{
    width:36px;height:36px;border-radius:50%;border:1px solid var(--teal);
    background:#0e2a52;color:#cfe;font-size:1.1rem;font-weight:700;
    cursor:pointer;
  }
  .round-btn:active{transform:scale(.92);}
  .icon-btn-sq{
    width:38px;height:38px;border-radius:10px;border:1px solid #2a4a7a;
    background:#0e2a52;color:#dce6f7;
    cursor:pointer;
  }
  .spin-btn{
    width:72px;height:72px;border-radius:50%;border:none;
    background:radial-gradient(circle at 35% 30%, #ffe9a8, var(--gold) 55%, var(--gold-dark) 100%);
    box-shadow:0 0 0 5px #0a1c3a, 0 0 0 8px var(--gold-dark), 0 12px 26px rgba(0,0,0,.55);
    font-size:1.7rem;color:#3a2a06;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    transition: transform 0.1s;
  }
  .spin-btn i{transition:transform .2s;}
  .spin-btn.spinning i{animation:spinRot .6s linear infinite;}
  @keyframes spinRot{to{transform:rotate(360deg);}}
  .spin-btn:active{transform:scale(.95);}
  .spin-btn:disabled{opacity:.55; cursor:not-allowed;}

  .toast-msg{
    position:fixed;bottom:52px;left:50%;transform:translateX(-50%);
    background:var(--gold);color:#2a1f06;padding:8px 18px;border-radius:8px;
    font-weight:700;box-shadow:0 8px 22px rgba(0,0,0,.4);z-index:150;
    opacity:0;transition:opacity .3s;
  }
  .toast-msg.show{opacity:1;}

  @media (max-width:560px){
    .game-logo{font-size:1.45rem;}
    .pill-box{min-width:96px;padding:4px 10px;}
    .spin-btn{width:58px;height:58px;font-size:1.2rem;}
    .jp-label{font-size:.6rem;}
    .jp-amt{font-size:.76rem;}
    .main-layout-container { margin-left: 0; padding: 6px; }
    .sidenav { display: none; }
  }

  /* Fixed Footer bar */
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
    font-weight: bold;
    text-transform: uppercase;
    font-size: 11px;
    color: #8ca3c7;
    text-decoration: none;
  }
  .footerbar .tab:hover, .footerbar .tab.active { color: #fff; }

  /* Deposit popup modal */
  .deposit-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(4, 13, 28, 0.88);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .deposit-modal-box {
    background: linear-gradient(180deg, #0e2a52, #07152b);
    border: 2px solid var(--gold);
    border-radius: 20px;
    max-width: 440px;
    width: 100%;
    padding: 32px 24px;
    text-align: center;
    box-shadow: 0 25px 70px rgba(0,0,0,0.85);
    position: relative;
    animation: popIn 0.3s ease;
  }
</style>
</head>
<body>

<!-- 1XBET OFFICIAL TOP HEADER -->
@include('customer.header')

<canvas id="bgCanvas"></canvas>

<div id="gameWrapper">
  <!-- TOPNAV -->
  <div class="topnav">
    <div class="breadcrumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Slots</a>
      <span>/</span>
      <span>Royal Emirates</span>
    </div>
    <div class="gametitle">
      <i class="fa-solid fa-coins" style="color:var(--gold);"></i>
      <span>ROYAL EMIRATES</span>
    </div>
    <div class="topNavRight">
      <a href="{{ route('dashboard') }}" class="navIcon" title="Dashboard"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
  </div>

  <!-- SIDENAV -->
  <div class="sidenav">
    <a href="{{ route('dashboard') }}" class="icon-btn active" title="Lobby"><i class="fa-solid fa-house"></i></a>
    <a href="{{ route('dashboard') }}" class="icon-btn" title="Slots"><i class="fa-solid fa-dice"></i></a>
    <a href="{{ route('play') }}" class="icon-btn" title="Crash Games"><i class="fa-solid fa-plane-departure"></i></a>
  </div>

  <div class="main-layout-container">
    <div class="slot-game-container" id="frame">

      <!-- SUBHEADER WITH HIGHLY VISIBLE DUAL MODE SELECTOR -->
      <div class="subheader">
        <div class="game-name"><i class="fa-solid fa-coins"></i>Royal Emirates Hold &amp; Spin</div>
        
        <!-- PROMINENT REAL VS DEMO MODE SELECTOR -->
        <div class="mode-switch-group">
          <button type="button" id="btnModeReal" class="mode-btn active-real" onclick="setPlayMode('real')">
            <i class="fa-solid fa-coins"></i> <span>REAL MONEY</span>
          </button>
          <button type="button" id="btnModeDemo" class="mode-btn" onclick="setPlayMode('demo')">
            <i class="fa-solid fa-gamepad"></i> <span>DEMO (3 FREE)</span>
          </button>
        </div>

        <div class="header-icons">
          <button id="btnPaytable" title="Paytable / Rules"><i class="fa-solid fa-table-list"></i></button>
          <button id="btnExpand" title="Expand"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          <button id="btnMute" title="Mute/Unmute" style="color: var(--gold-light);"><i id="muteIcon" class="fa-solid fa-volume-high"></i></button>
          <button id="btnFav" title="Favorite"><i class="fa-regular fa-star"></i></button>
          <button id="btnClose" title="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
      </div>

      <div class="viewport" id="viewport">

        <!-- JACKPOTS -->
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

        <!-- MODE STATUS INDICATOR -->
        <div class="mode-status-bar" id="modeStatusBar">
          <div id="modeStatusText" style="color:#34d399; font-weight:700;">
            <i class="fa-solid fa-circle-check"></i> REAL MONEY PLAY ACTIVE &bull; Wallet Connected
          </div>
          <button type="button" id="btnQuickModeSwitch" onclick="quickToggleMode()" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:6px; font-size:10px; font-weight:700; padding:2px 8px; cursor:pointer;">
            Switch to Demo Mode
          </button>
        </div>

        <!-- REELS -->
        <div class="reel-frame" id="reelFrame">
          <div class="bonus-banner" id="bonusBanner">
            <h5>HOLD &amp; SPIN!</h5>
            <small id="bonusSub">3 respins remaining</small>
          </div>
          <canvas id="fxCanvas"></canvas>
          <div class="reel-grid" id="reelGrid"></div>
        </div>

      </div>

      <!-- BOTTOM BAR CONTROLS -->
      <div class="bottombar">
        <button type="button" id="btnBottomModeToggle" onclick="quickToggleMode()" class="pill-box" style="cursor:pointer; border: 1.5px solid var(--gold); background: linear-gradient(180deg, #102e5c, #0a1c3a); min-width:115px; transition: all 0.2s;" title="Click to Toggle Demo/Real Money">
          <span class="lbl" id="bottomModeLbl">PLAY MODE</span>
          <span class="val" id="bottomModeVal" style="font-size:0.75rem; color:#10b981;"><i class="fa-solid fa-coins"></i> REAL PLAY</span>
        </button>
        <div class="pill-box">
          <span class="lbl" id="balanceLabel">REAL BALANCE</span>
          <span class="val" id="balanceDisplay">৳ 0.00</span>
        </div>
        <div class="bet-controls">
          <button class="round-btn" id="betMinus">-</button>
          <div class="pill-box">
            <span class="lbl">BET</span>
            <span class="val" id="betDisplay">৳ 1.00</span>
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
      <a href="{{ route('dashboard') }}" class="tab active"><i class="fa-regular fa-clock"></i> RECENT GAMES</a>
      <a href="{{ route('dashboard') }}" class="tab" style="margin-left:14px;"><i class="fa-regular fa-star"></i> FAVORITES</a>
    </div>
    <div style="font-size:10px; color:#64748b;">
      Royal Emirates Hold &amp; Spin &bull; Certified 25-Payline RTP
    </div>
  </div>
</div>

<!-- Deposit Required Popup Modal -->
<div class="deposit-modal-overlay" id="depositPopupModal">
  <div class="deposit-modal-box">
    <div style="width:68px; height:68px; border-radius:50%; background:rgba(232,185,74,0.15); border:2px solid var(--gold); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--gold); font-size:30px;">
      <i class="fa-solid fa-wallet"></i>
    </div>
    <h4 style="color:#fff; font-weight:800; margin-bottom:10px;">ডেমো লিমিট শেষ!</h4>
    <p style="color:#cbd5e1; font-size:13.5px; line-height:1.6; margin-bottom:24px;">
      আপনার <span id="modalDemoLimitText">{{ \App\Models\Setting::getVal('demo_spins_limit', 3) }}</span>টি ফ্রি ডেমো স্পিনের লিমিট শেষ হয়ে গেছে। আসল টাকা জিতে নিতে এবং আনলিমিটেড স্পিন ও ৫,০০০ গুণ Grand Jackpot উপভোগ করতে এখনই ডিপোজিট করুন!
    </p>
    <div style="display:flex; gap:12px; justify-content:center;">
      <a href="{{ route('dashboard') }}" style="flex:1; padding:12px; border-radius:10px; background:linear-gradient(135deg,#e8b94a,#caa01f); color:#000; font-weight:800; text-decoration:none; font-size:14px; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
        <i class="fa-solid fa-circle-dollar-to-slot"></i> ডিপোজিট করুন
      </a>
      <button onclick="closeDepositPopup()" style="padding:12px 18px; border-radius:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:#fff; font-weight:700; cursor:pointer;">
        বন্ধ করুন
      </button>
    </div>
  </div>
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
        <p class="small">Lines pay left-to-right, 3+ matching symbols on fixed 25 lines.</p>
        <table class="table table-sm table-borderless" style="color:inherit" id="payRows"></table>
        <hr style="border-color:rgba(232,185,74,.25)">
        <p class="small mb-1"><strong>Golden Horse Coin (GOLD_COIN):</strong> Land <strong>6 or more</strong> anywhere on the 5x3 grid to trigger <strong>HOLD &amp; SPIN</strong>. Locked coins carry cash prizes or Jackpots (MINI $10\times$, MINOR $25\times$, MEGA $50\times$). Every new coin resets respins to 3. Fill all 15 positions to win the massive <strong>GRAND ($5000\times$)</strong> jackpot!</p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
"use strict";

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/* ===================== SOUND ENGINE ===================== */
class SlotSoundEngine {
  constructor() {
    this.ctx = null;
    this.muted = false;
    this.customAudio = {
      spin: new Audio(),
      win: new Audio(),
      coin: new Audio(),
      bonus: new Audio()
    };
  }

  ensureAudio() {
    if (!this.ctx) {
      try {
        this.ctx = new (window.AudioContext || window.webkitAudioContext)();
      } catch(e){}
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
    }
  }

  beep(freq, dur, type = 'sine', vol = 0.15, delay = 0) {
    if (this.muted) return;
    this.ensureAudio();
    if (!this.ctx) return;
    setTimeout(() => {
      try {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
        gain.gain.setValueAtTime(vol, this.ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + dur);
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start();
        osc.stop(this.ctx.currentTime + dur);
      } catch(e){}
    }, delay);
  }

  playSpin(audioUrl) {
    if (this.muted) return;
    if (audioUrl) {
      this.customAudio.spin.src = audioUrl;
      this.customAudio.spin.play().catch(()=>{});
    } else {
      this.beep(180, 0.1, 'triangle', 0.2);
    }
  }

  playReelStop(c) {
    if (this.muted) return;
    this.beep(220 + c * 30, 0.12, 'triangle', 0.25);
  }

  playWin(audioUrl) {
    if (this.muted) return;
    if (audioUrl) {
      this.customAudio.win.src = audioUrl;
      this.customAudio.win.play().catch(()=>{});
    } else {
      [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50].forEach((f, i) => {
        this.beep(f, 0.25, 'square', 0.1, i * 70);
      });
    }
  }

  playBonus(audioUrl) {
    if (this.muted) return;
    if (audioUrl) {
      this.customAudio.bonus.src = audioUrl;
      this.customAudio.bonus.play().catch(()=>{});
    } else {
      [440, 554, 659, 880].forEach((f, i) => {
        this.beep(f, 0.4, 'sawtooth', 0.15, i * 90);
      });
    }
  }

  toggleMute() {
    this.muted = !this.muted;
    const icon = document.getElementById('muteIcon');
    if (icon) {
      icon.className = this.muted ? 'fa-solid fa-volume-xmark' : 'fa-solid fa-volume-high';
    }
  }
}

const soundEngine = new SlotSoundEngine();
document.getElementById('btnMute').addEventListener('click', () => soundEngine.toggleMute());
document.addEventListener('click', () => soundEngine.ensureAudio(), { once: true });

/* ===================== SYMBOL MAPPINGS & ASSETS ===================== */
const symbolKeys = ['SHEIKH', 'BURJ_AL_ARAB', 'RED_SUPERCAR', 'GOLD_DAGGER', 'GOLD_TEAPOT', 'A', 'K', 'Q', 'J', 'GOLD_COIN'];
const symbolImageFiles = {
  SHEIKH: '6.png',
  BURJ_AL_ARAB: '8.png',
  RED_SUPERCAR: '5.png',
  GOLD_DAGGER: '3.png',
  GOLD_TEAPOT: '4.png',
  A: '2.png',
  K: '1.png',
  Q: '4.png',
  J: '3.png',
  GOLD_COIN: '7.png'
};

const PAYTABLE = {
  SHEIKH: 25,
  BURJ_AL_ARAB: 20,
  RED_SUPERCAR: 15,
  GOLD_DAGGER: 12,
  GOLD_TEAPOT: 8,
  A: 6,
  K: 5,
  Q: 4,
  J: 3
};

const PAY_NAMES = {
  SHEIKH: 'Golden Sultan (SHEIKH)',
  BURJ_AL_ARAB: 'Burj Luxury Tower',
  RED_SUPERCAR: 'Emirates Supercar',
  GOLD_DAGGER: 'Royal Khanjar Dagger',
  GOLD_TEAPOT: 'Golden Arabian Dallah',
  A: 'Princess A',
  K: 'Royal Hookah K',
  Q: 'Palace Pitcher Q',
  J: 'Silver Dagger J',
  GOLD_COIN: 'Golden Horse Coin (Hold & Spin)'
};

const imgCache = {};
Object.keys(symbolImageFiles).forEach(key => {
  const img = new Image();
  img.src = `{{ asset('assets/image/Royal Emirates Hold and Spin') }}/${symbolImageFiles[key]}`;
  img.onload = () => {
    if (cells && cells.length > 0) {
      cells.forEach(c => {
        if (c.key === key && !c.canvas.classList.contains('spinning')) {
          drawSymbol(c.ctx, key, RES, RES, key === 'GOLD_COIN');
        }
      });
    }
  };
  imgCache[key] = img;
});

function drawSymbol(ctx, key, w, h, glow) {
  ctx.clearRect(0, 0, w, h);
  const img = imgCache[key];
  if (img && img.complete) {
    ctx.save();
    if (glow || key === 'GOLD_COIN') {
      ctx.shadowColor = '#ffd700';
      ctx.shadowBlur = 18;
    }
    ctx.drawImage(img, 4, 4, w - 8, h - 8);
    ctx.restore();
  } else {
    ctx.fillStyle = 'rgba(14, 42, 80, 0.5)';
    ctx.fillRect(0, 0, w, h);
    ctx.fillStyle = '#fbbf24';
    ctx.font = 'bold 16px Outfit, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(key, w / 2, h / 2 + 5);
  }
}

/* ===================== STATE & DATA ===================== */
const ROWS = 3, COLS = 5, RES = 130;
let cells = [];
let lockedValues = new Array(ROWS * COLS).fill(null);
let spinning = false;
let inBonus = false;
let spinsRemaining = 0;

const DENOMS = [1, 2, 5, 10, 20, 50, 100, 250, 500];
let betIndex = 0;

let realBalance = parseFloat("{{ auth()->user()->balance ?? 0 }}");
let isDemoMode = false;
let demoSpinsDone = 0;
let globalDemoSpinsLimit = parseInt("{{ \App\Models\Setting::getVal('demo_spins_limit', 3) }}") || 3;
let demoBalance = 1000.00;
let balance = realBalance;

let jackpots = {
  mini: parseFloat("{{ $settings->mini_multiplier ?? 10 }}"),
  minor: parseFloat("{{ $settings->minor_multiplier ?? 25 }}"),
  mega: parseFloat("{{ $settings->mega_multiplier ?? 50 }}"),
  grand: parseFloat("{{ $settings->grand_multiplier ?? 5000 }}")
};

const reelGridEl = document.getElementById('reelGrid');
const balanceDisplay = document.getElementById('balanceDisplay');
const balanceLabel = document.getElementById('balanceLabel');
const betDisplay = document.getElementById('betDisplay');
const spinBtn = document.getElementById('spinBtn');
const bonusBanner = document.getElementById('bonusBanner');
const bonusSub = document.getElementById('bonusSub');

function money(v) {
  return parseFloat(v || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
function currentBet() {
  return DENOMS[betIndex];
}

function updateJackpotUi() {
  const bet = currentBet();
  document.getElementById('jpGrand').textContent = money(bet * jackpots.grand);
  document.getElementById('jpMega').textContent = money(bet * jackpots.mega);
  document.getElementById('jpMinor').textContent = money(bet * jackpots.minor);
  document.getElementById('jpMini').textContent = money(bet * jackpots.mini);
}

function updateBalanceUi() {
  balanceDisplay.textContent = (isDemoMode ? 'DEMO ৳ ' : '৳ ') + money(balance);
  balanceLabel.textContent = isDemoMode ? 'DEMO BALANCE' : 'REAL BALANCE';
}
function updateBetUi() {
  betDisplay.textContent = '৳ ' + money(currentBet());
  updateJackpotUi();
}

/* ===================== MODE SWITCHER ===================== */
window.setPlayMode = function(mode) {
  if (spinning || inBonus) return;
  const btnReal = document.getElementById('btnModeReal');
  const btnDemo = document.getElementById('btnModeDemo');
  const statusText = document.getElementById('modeStatusText');
  const btnQuick = document.getElementById('btnQuickModeSwitch');
  const bottomModeVal = document.getElementById('bottomModeVal');

  if (mode === 'demo') {
    isDemoMode = true;
    balance = demoBalance;
    if (btnReal) btnReal.className = 'mode-btn';
    if (btnDemo) btnDemo.className = 'mode-btn active-demo';
    if (statusText) {
      statusText.style.color = '#22d3ee';
      statusText.innerHTML = `<i class="fa-solid fa-gamepad"></i> DEMO PLAY MODE ACTIVE &bull; <strong>${Math.max(0, globalDemoSpinsLimit - demoSpinsDone)}</strong> Free Spins Left (Limit: ${globalDemoSpinsLimit})`;
    }
    if (btnQuick) btnQuick.textContent = 'Switch to Real Money';
    if (bottomModeVal) {
      bottomModeVal.style.color = '#22d3ee';
      bottomModeVal.innerHTML = `<i class="fa-solid fa-gamepad"></i> DEMO PLAY (${globalDemoSpinsLimit})`;
    }
    showToast(`🎮 ডেমো মোড সক্রিয় হয়েছে (${globalDemoSpinsLimit} স্পিন লিমিট)`);
  } else {
    isDemoMode = false;
    balance = realBalance;
    if (btnDemo) btnDemo.className = 'mode-btn';
    if (btnReal) btnReal.className = 'mode-btn active-real';
    if (statusText) {
      statusText.style.color = '#34d399';
      statusText.innerHTML = `<i class="fa-solid fa-circle-check"></i> REAL MONEY PLAY ACTIVE &bull; Live Wallet Connected`;
    }
    if (btnQuick) btnQuick.textContent = 'Switch to Demo Mode';
    if (bottomModeVal) {
      bottomModeVal.style.color = '#10b981';
      bottomModeVal.innerHTML = '<i class="fa-solid fa-coins"></i> REAL PLAY';
    }
    showToast('💰 আসল টাকা মোড সক্রিয় হয়েছে');
  }
  updateBalanceUi();
};

window.quickToggleMode = function() {
  setPlayMode(isDemoMode ? 'real' : 'demo');
};

window.closeDepositPopup = function() {
  document.getElementById('depositPopupModal').style.display = 'none';
};

document.getElementById('betMinus').addEventListener('click', () => {
  if (spinning || inBonus) return;
  betIndex = Math.max(0, betIndex - 1);
  updateBetUi();
});
document.getElementById('betPlus').addEventListener('click', () => {
  if (spinning || inBonus) return;
  betIndex = Math.min(DENOMS.length - 1, betIndex + 1);
  updateBetUi();
});

/* ===================== GRID INITIALIZATION ===================== */
function buildGrid() {
  reelGridEl.innerHTML = '';
  cells = [];
  const initialPool = ['SHEIKH', 'BURJ_AL_ARAB', 'RED_SUPERCAR', 'GOLD_DAGGER', 'GOLD_TEAPOT', 'A', 'K', 'Q', 'J', 'GOLD_COIN'];
  for (let r = 0; r < ROWS; r++) {
    for (let c = 0; c < COLS; c++) {
      const idx = r * COLS + c;
      const cell = document.createElement('div');
      cell.className = 'reel-cell';
      cell.dataset.row = r;
      cell.dataset.col = c;
      const canvas = document.createElement('canvas');
      canvas.className = 'symbol-canvas';
      canvas.width = RES; canvas.height = RES;
      const badge = document.createElement('div');
      badge.className = 'lock-badge';
      cell.appendChild(canvas);
      cell.appendChild(badge);
      reelGridEl.appendChild(cell);
      const key = initialPool[Math.floor(Math.random() * initialPool.length)];
      const obj = { el: cell, canvas, ctx: canvas.getContext('2d'), badge, row: r, col: c, idx, key };
      cells.push(obj);
      drawSymbol(obj.ctx, key, RES, RES, key === 'GOLD_COIN');
    }
  }
}
buildGrid();
updateBalanceUi();
updateBetUi();

// Check URL param for demo mode
try {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('mode') === 'demo') {
    setPlayMode('demo');
  }
} catch(e){}

/* ===================== SPIN EXECUTION (BACKEND CONNECTED) ===================== */
function setSpinUiBusy(busy) {
  spinBtn.disabled = busy;
  spinBtn.classList.toggle('spinning', busy);
}

function animateReelColumn(colIndex, finalKeys, onDone) {
  const colCells = [0, 1, 2].map(r => cells[r * COLS + colIndex]);
  const pool = symbolKeys;
  const iv = setInterval(() => {
    colCells.forEach(c => {
      c.canvas.classList.add('spinning');
      drawSymbol(c.ctx, pool[Math.floor(Math.random() * pool.length)], RES, RES, false);
    });
  }, 50);

  setTimeout(() => {
    clearInterval(iv);
    colCells.forEach((c, r) => {
      c.key = finalKeys[r] || 'GOLD_COIN';
      c.canvas.classList.remove('spinning');
      drawSymbol(c.ctx, c.key, RES, RES, c.key === 'GOLD_COIN');
      c.canvas.classList.add('landing');
      setTimeout(() => c.canvas.classList.remove('landing'), 400);
    });
    soundEngine.playReelStop(colIndex);
    if (onDone) onDone();
  }, 600 + colIndex * 220);
}

function triggerRoyalSpin() {
  if (spinning || inBonus) return;

  const bet = currentBet();

  // Demo limit check
  if (isDemoMode && demoSpinsDone >= globalDemoSpinsLimit) {
    document.getElementById('depositPopupModal').style.display = 'flex';
    return;
  }

  if (!isDemoMode && balance < bet) {
    showToast('পর্যাপ্ত রিয়েল ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
    document.getElementById('depositPopupModal').style.display = 'flex';
    return;
  }

  spinning = true;
  setSpinUiBusy(true);

  // Optimistic balance deduction
  balance -= bet;
  updateBalanceUi();

  fetch("{{ route('royalemirates.spin') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": CSRF_TOKEN,
      "Accept": "application/json"
    },
    body: JSON.stringify({
      bet_amount: bet,
      is_demo: isDemoMode,
      demo_spins_count: demoSpinsDone
    })
  })
  .then(r => r.json())
  .then(data => {
    if (data.status === 'deposit_required') {
      spinning = false;
      setSpinUiBusy(false);
      balance += bet; // rollback
      updateBalanceUi();
      document.getElementById('depositPopupModal').style.display = 'flex';
      return;
    }

    if (data.error) {
      spinning = false;
      setSpinUiBusy(false);
      balance += bet;
      updateBalanceUi();
      showToast(data.error);
      return;
    }

    soundEngine.playSpin(data.audio?.spin);

    // Animate 5 columns sequentially
    let completedCols = 0;
    for (let c = 0; c < COLS; c++) {
      const colFinal = [data.grid[0][c], data.grid[1][c], data.grid[2][c]];
      animateReelColumn(c, colFinal, () => {
        completedCols++;
        if (completedCols === COLS) {
          handleSpinResult(data, bet);
        }
      });
    }
  })
  .catch(err => {
    spinning = false;
    setSpinUiBusy(false);
    balance += bet;
    updateBalanceUi();
    showToast('সংযোগ বিচ্ছিন্ন হয়েছে। পুনরায় চেষ্টা করুন।');
  });
}

function handleSpinResult(data, bet) {
  spinning = false;
  setSpinUiBusy(false);

  // Update balance
  if (isDemoMode) {
    demoSpinsDone++;
    demoBalance = balance + (data.win_amount || 0);
    balance = demoBalance;
    const statusText = document.getElementById('modeStatusText');
    if (statusText) {
      statusText.innerHTML = `<i class="fa-solid fa-gamepad"></i> DEMO PLAY MODE ACTIVE &bull; <strong>${Math.max(0, 3 - demoSpinsDone)}</strong> Free Spins Left (Limit: 3)`;
    }
  } else if (data.new_balance !== null && data.new_balance !== undefined) {
    realBalance = parseFloat(data.new_balance);
    balance = realBalance;
  }
  updateBalanceUi();

  // Check Hold & Spin trigger
  if (data.triggered_hold_spin) {
    startHoldAndSpin(data, bet);
    return;
  }

  // Normal Line Win
  if (data.is_win && data.win_amount > 0) {
    soundEngine.playWin(data.audio?.win);
    showToast('আপনি জিতেছেন ৳ ' + money(data.win_amount) + '!');
    triggerCoinBurst(false);
  }
}

/* ===================== HOLD AND SPIN BONUS ===================== */
function startHoldAndSpin(data, bet) {
  inBonus = true;
  spinsRemaining = 3;
  soundEngine.playBonus(data.audio?.bonus);
  bonusBanner.classList.add('show');
  bonusSub.textContent = '3 respins remaining';

  // Lock all Gold Coins in the grid
  cells.forEach(c => {
    if (c.key === 'GOLD_COIN') {
      const valKey = `${c.row}_${c.col}`;
      const val = data.coin_values ? data.coin_values[valKey] : bet * 2;
      c.el.classList.add('locked');
      c.badge.textContent = '৳ ' + money(val);
      drawSymbol(c.ctx, 'GOLD_COIN', RES, RES, true);
    }
  });

  showToast('🌟 HOLD & SPIN বোনাস ট্রিগার হয়েছে!');
  triggerCoinBurst(true);

  setTimeout(() => {
    endHoldAndSpin(data);
  }, 2200);
}

function endHoldAndSpin(data) {
  soundEngine.playWin(data.audio?.win);
  let winText = '🎉 বোনাস জয়! মোট ৳ ' + money(data.win_amount);
  if (data.jackpot_won) {
    winText = `🏆 ${data.jackpot_won} JACKPOT জয়! ৳ ${money(data.win_amount)}`;
  }
  showToast(winText);
  triggerCoinBurst(true);

  setTimeout(() => {
    cells.forEach(c => {
      c.el.classList.remove('locked');
      c.badge.textContent = '';
    });
    inBonus = false;
    bonusBanner.classList.remove('show');
  }, 2500);
}

spinBtn.addEventListener('click', () => {
  triggerRoyalSpin();
});

/* ===================== COIN BURST PARTICLES ===================== */
const fxCanvas = document.getElementById('fxCanvas');
const fxCtx = fxCanvas.getContext('2d');
let particles = [];
function resizeFx() {
  const rect = document.getElementById('reelFrame').getBoundingClientRect();
  fxCanvas.width = rect.width - 20;
  fxCanvas.height = rect.height - 20;
}
resizeFx();
window.addEventListener('resize', resizeFx);

function triggerCoinBurst(big) {
  const n = big ? 65 : 25;
  for (let i = 0; i < n; i++) {
    particles.push({
      x: fxCanvas.width * 0.5 + (Math.random() - 0.5) * fxCanvas.width * 0.7,
      y: fxCanvas.height * 0.25,
      vx: (Math.random() - 0.5) * 5,
      vy: -(Math.random() * 6 + 3),
      rot: Math.random() * Math.PI,
      vr: (Math.random() - 0.5) * 0.3,
      size: 8 + Math.random() * 8,
      life: 1
    });
  }
}

function fxLoop() {
  fxCtx.clearRect(0, 0, fxCanvas.width, fxCanvas.height);
  particles.forEach(p => {
    p.vy += 0.28; p.x += p.vx; p.y += p.vy; p.rot += p.vr; p.life -= 0.012;
    fxCtx.save();
    fxCtx.globalAlpha = Math.max(p.life, 0);
    fxCtx.translate(p.x, p.y);
    fxCtx.rotate(p.rot);
    const g = fxCtx.createLinearGradient(-p.size, -p.size, p.size, p.size);
    g.addColorStop(0, '#fff6da'); g.addColorStop(1, '#caa01f');
    fxCtx.fillStyle = g;
    fxCtx.beginPath();
    fxCtx.ellipse(0, 0, p.size * 0.5, p.size * 0.5, 0, 0, Math.PI * 2);
    fxCtx.fill();
    fxCtx.restore();
  });
  particles = particles.filter(p => p.life > 0 && p.y < fxCanvas.height + 40);
  requestAnimationFrame(fxLoop);
}
fxLoop();

/* ===================== AMBIENT STARFIELD CANVAS ===================== */
const bg = document.getElementById('bgCanvas');
const bgCtx = bg.getContext('2d');
let stars = [];
function resizeBg() {
  bg.width = window.innerWidth; bg.height = window.innerHeight;
  stars = [];
  const n = Math.floor((bg.width * bg.height) / 9000);
  for (let i = 0; i < n; i++) {
    stars.push({
      x: Math.random() * bg.width,
      y: Math.random() * bg.height * 0.75,
      r: Math.random() * 1.6 + 0.3,
      phase: Math.random() * Math.PI * 2,
      speed: 0.02 + Math.random() * 0.03
    });
  }
}
resizeBg();
window.addEventListener('resize', resizeBg);

let t = 0;
function bgLoop() {
  t += 1;
  const sky = bgCtx.createLinearGradient(0, 0, 0, bg.height);
  sky.addColorStop(0, '#020815');
  sky.addColorStop(0.55, '#071b3a');
  sky.addColorStop(1, '#0c2a55');
  bgCtx.fillStyle = sky;
  bgCtx.fillRect(0, 0, bg.width, bg.height);

  stars.forEach(s => {
    const tw = 0.5 + 0.5 * Math.sin(t * s.speed + s.phase);
    bgCtx.globalAlpha = 0.25 + tw * 0.75;
    bgCtx.fillStyle = '#eaf3ff';
    bgCtx.beginPath();
    bgCtx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
    bgCtx.fill();
  });
  bgCtx.globalAlpha = 1;
  requestAnimationFrame(bgLoop);
}
bgLoop();

/* ===================== TOAST ===================== */
let toastTimer = null;
function showToast(msg) {
  const toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 2400);
}

/* ===================== HEADER ACTIONS ===================== */
document.getElementById('btnFav').addEventListener('click', (e) => {
  e.currentTarget.classList.toggle('fav-active');
});
document.getElementById('btnExpand').addEventListener('click', () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(() => {});
  } else {
    document.exitFullscreen();
  }
});
document.getElementById('btnClose').addEventListener('click', () => {
  window.location.href = "{{ route('dashboard') }}";
});
document.getElementById('btnPaytable').addEventListener('click', () => {
  new bootstrap.Modal(document.getElementById('paytableModal')).show();
});

/* ===================== PAYTABLE POPULATOR ===================== */
(function buildPaytable() {
  const tbody = document.getElementById('payRows');
  Object.keys(PAYTABLE).forEach(k => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td style="width:40px"><img src="{{ asset('assets/image/Royal Emirates Hold and Spin') }}/${symbolImageFiles[k]}" width="32" height="32" style="border-radius:4px;"></td>
                    <td>${PAY_NAMES[k] || k}</td>
                    <td class="text-end" style="color:#fbbf24; font-weight:800;">${PAYTABLE[k]}x Bet</td>`;
    tbody.appendChild(tr);
  });
})();

})();
</script>
</body>
</html>
