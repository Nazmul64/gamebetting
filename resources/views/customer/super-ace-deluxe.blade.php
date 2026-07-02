<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<title>Super Ace Deluxe</title>
<style>
  :root{
    --gold:#e8c468;
    --gold-bright:#ffe9a8;
    --wood-dark:#3a2417;
    --wood-mid:#5a3a22;
    --wood-light:#7a5230;
    --felt:#103b2e;
    --felt-light:#185a45;
    --navy:#16233b;
    --navy-light:#1f3050;
    --cream:#fbeacb;
  }
  *{box-sizing:border-box;}
  html,body{
    margin:0;padding:0;height:100%;
    font-family:'Trebuchet MS',Arial,sans-serif;
    background:#0c1424;
    overflow:hidden;
    -webkit-tap-highlight-color:transparent;
    user-select:none;
  }
  .app{
    position:relative;
    width:100%;height:100vh;
    display:flex;flex-direction:column;
    background: url("{{ asset('assets/image/super_ace_bg.png') }}") no-repeat center center / cover;
  }

  /* ---------- top chrome ---------- */
  .topbar{
    display:flex;align-items:center;gap:10px;
    background:linear-gradient(180deg,var(--navy-light),var(--navy));
    color:var(--cream);
    padding:8px 14px;
    border-bottom:2px solid #0a1322;
    position:relative;z-index:5;
  }
  .topbar .brand-mark{
    width:26px;height:26px;border-radius:7px;
    background:linear-gradient(160deg,var(--gold-bright),#b9842f);
    display:flex;align-items:center;justify-content:center;
    font-weight:800;color:#3a2407;font-size:14px;
    box-shadow:0 0 0 1px #00000033 inset;
  }
  .topbar .title{font-weight:700;font-size:15px;letter-spacing:.3px;}
  .demo-toggle{
    display:flex;align-items:center;gap:6px;margin-left:6px;
    font-size:10.5px;color:#9fb0cc;letter-spacing:.4px;
    cursor:pointer;
  }
  .switch{
    width:30px;height:16px;border-radius:9px;background:#324365;
    position:relative;flex:none;
    transition: background .2s;
  }
  .switch::after{
    content:'';position:absolute;top:2px;left:2px;width:12px;height:12px;
    border-radius:50%;background:#7d8db0;transition:.2s;
  }
  .switch.active{background:#103b2e;}
  .switch.active::after{left:16px;background:var(--gold);}
  
  .topbar .spacer{flex:1;}
  .icon-btn{
    width:30px;height:30px;border-radius:7px;border:none;background:transparent;
    color:#bcccea;display:flex;align-items:center;justify-content:center;
    font-size:15px;cursor:pointer;transition:background .15s;
  }
  .icon-btn:hover{background:#ffffff14;color:#fff;}

  /* ---------- left rail ---------- */
  .rail{
    position:absolute;left:0;top:46px;bottom:0;width:46px;
    background:linear-gradient(180deg,var(--navy-light),var(--navy));
    display:flex;flex-direction:column;align-items:center;
    padding-top:10px;gap:4px;z-index:4;
    border-right:2px solid #0a1322;
  }
  .rail button{
    width:34px;height:34px;border-radius:8px;border:none;background:transparent;
    color:#9fb0cc;font-size:15px;cursor:pointer;
  }
  .rail button:hover{background:#ffffff14;color:var(--gold-bright);}
  .rail button.active{color:#ff7a90;}

  /* ---------- stage ---------- */
  .stage{
    flex:1;display:flex;align-items:center;justify-content:center;
    padding:14px 14px 10px 60px;
    position:relative;
  }

  .machine{
    width:380px;max-width:94vw;
    background:
      linear-gradient(180deg,var(--wood-light),var(--wood-mid) 12%,var(--wood-dark) 100%);
    border:3px solid #2a1a0e;
    border-radius:14px;
    padding:10px;
    box-shadow:0 18px 40px -10px #00000066, 0 0 0 6px #00000022 inset;
  }

  .marquee{
    display:flex;align-items:flex-start;justify-content:space-between;gap:8px;
    padding:6px 4px 8px;
  }
  .marquee h1{
    margin:0;
    font-size:25px;letter-spacing:1px;
    color:var(--gold-bright);
    font-family:Georgia,'Times New Roman',serif;
    font-style:italic;font-weight:900;
    text-shadow:0 2px 0 #5a2c0a, 0 0 14px #ffb84a55;
    line-height:1;
  }
  .marquee .sub{
    display:block;font-size:9.5px;color:#e9c68a;font-style:normal;
    letter-spacing:3px;font-family:Arial,sans-serif;margin-top:2px;
  }
  .buy-bonus{
    flex:none;
    background:linear-gradient(180deg,#ffe9a8,#d99a2b);
    border:1px solid #7a4d10;
    border-radius:10px;
    color:#4a2a05;font-weight:800;font-size:10px;line-height:1.15;
    text-align:center;padding:6px 9px;
    box-shadow:0 3px 0 #6b3f0a;cursor:pointer;
  }
  .buy-bonus:active{transform:translateY(2px);box-shadow:0 1px 0 #6b3f0a;}
  .buy-bonus:disabled{filter:grayscale(.6);opacity:.6;cursor:not-allowed;}

  .ladder{
    display:flex;align-items:center;justify-content:center;gap:6px;
    background:linear-gradient(180deg,#7a4a1c,#4a2a0c);
    border:1px solid #2a1606;border-radius:30px;
    padding:5px 8px;margin:0 2px 8px;
  }
  .pip{
    width:30px;height:24px;border-radius:6px;
    background:#2c1a0a;color:#caa872;
    display:flex;align-items:center;justify-content:center;
    font-size:11px;font-weight:800;
    border:1px solid #1a0e04;
    transition:all .25s;
  }
  .pip.lit{
    background:linear-gradient(180deg,#fff3cf,#f0a93a);
    color:#4a2406;box-shadow:0 0 10px #ffcf5c;
    border-color:#a9700c;
  }
  .pip.star{
    background:linear-gradient(180deg,#2c1a0a,#2c1a0a);
    font-size:14px;
  }
  .pip.star.lit{background:linear-gradient(180deg,#fff3cf,#f0a93a);}

  .reel-frame{
    background:linear-gradient(180deg,#0b2e23,var(--felt));
    border:3px solid #d8b25e;
    border-radius:8px;
    padding:4px;
    box-shadow:0 0 0 2px #00000055 inset;
    position:relative;
  }
  #reelCanvas{display:block;width:100%;border-radius:5px;background:#0c2a20;}

  .win-row{
    display:flex;align-items:center;justify-content:center;gap:8px;
    padding:7px 0 3px;color:var(--gold-bright);font-weight:700;font-size:13px;
    letter-spacing:1px;
  }
  .win-row .amt{color:#fff;font-variant-numeric:tabular-nums;}

  .bonus-banner{
    display:none;align-items:center;justify-content:center;gap:8px;
    background:#7a1a2a;color:#ffe0c8;font-size:11px;font-weight:700;
    border-radius:7px;padding:5px;margin:0 2px 6px;letter-spacing:.5px;
  }
  .bonus-banner.show{display:flex;}

  .controls{
    display:flex;align-items:center;justify-content:space-between;
    gap:8px;padding:4px 2px 0;
  }
  .ctrl-btn{
    width:38px;height:38px;border-radius:50%;border:none;cursor:pointer;
    background:linear-gradient(180deg,#3a2414,#1d1208);
    color:#d9b97a;display:flex;align-items:center;justify-content:center;
    font-size:16px;border:1px solid #1a0e04;flex:none;
    box-shadow:0 2px 0 #00000055;
  }
  .ctrl-btn.active{color:#fff;box-shadow:0 0 8px #ffcf5c,0 2px 0 #00000055;background:linear-gradient(180deg,#6a4a1c,#3a2414);}
  .ctrl-btn:disabled{opacity:.45;cursor:not-allowed;}

  .bet-pill{
    background:#1d1208;border:1px solid #3a2414;border-radius:18px;
    color:#e9c68a;font-size:11px;text-align:center;padding:5px 12px;
    cursor:pointer;flex:none;min-width:62px;
  }
  .bet-pill b{display:block;font-size:13px;color:#fff;}

  .spin-btn{
    width:62px;height:62px;border-radius:50%;flex:none;cursor:pointer;border:none;
    background:radial-gradient(circle at 35% 30%,#fff3cf,#f0a93a 55%,#9a5d10 100%);
    border:3px solid #5a3408;
    box-shadow:0 5px 0 #4a2a06, 0 8px 14px #00000055;
    color:#4a2406;font-size:22px;display:flex;align-items:center;justify-content:center;
    transition:transform .08s;
  }
  .spin-btn:active{transform:translateY(3px);box-shadow:0 2px 0 #4a2a06;}
  .spin-btn:disabled{filter:grayscale(.5);opacity:.7;cursor:not-allowed;}
  .spin-btn .spinner{display:none;width:24px;height:24px;border-radius:50%;border:3px solid #4a2406;border-top-color:transparent;animation:spin .6s linear infinite;}
  .spin-btn.busy .tri{display:none;}
  .spin-btn.busy .spinner{display:block;}
  @keyframes spin{to{transform:rotate(360deg);}}

  .balance-row{
    text-align:center;padding:8px 0 2px;color:var(--gold-bright);
    font-size:12px;letter-spacing:.5px;
  }
  .balance-row b{color:#fff;font-variant-numeric:tabular-nums;}

  .foot-note{
    text-align:center;font-size:10px;color:#5a4a78;padding:4px 0 8px;
  }

  /* ---------- popovers / modals ---------- */
  .overlay{
    position:absolute;inset:0;background:#0008;
    display:none;align-items:center;justify-content:center;z-index:30;
  }
  .overlay.show{display:flex;}
  .panel{
    background:linear-gradient(180deg,#2a1a0e,#1a0f06);
    border:2px solid var(--gold);border-radius:12px;
    padding:18px;width:260px;color:var(--cream);text-align:center;
    box-shadow:0 20px 40px #000a;
  }
  .panel h3{margin:0 0 8px;color:var(--gold-bright);font-size:16px;}
  .panel p{font-size:12.5px;line-height:1.5;color:#e6d6b8;margin:0 0 14px;}
  .panel .row{display:flex;gap:8px;justify-content:center;}
  .panel button{
    flex:1;padding:9px 0;border-radius:8px;border:none;cursor:pointer;
    font-weight:700;font-size:12.5px;
  }
  .panel .confirm{background:linear-gradient(180deg,#ffe9a8,#d99a2b);color:#3a2206;}
  .panel .cancel{background:#3a2a18;color:#e6d6b8;}

  /* ---------- Custom Jili Buy Bonus Panel ---------- */
  .buy-bonus-panel {
    background: linear-gradient(180deg, #2b261f 0%, #15120e 100%);
    border: 2.5px solid #dcb059;
    border-radius: 12px;
    width: 320px;
    max-width: 90vw;
    color: #fff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.8), inset 0 0 10px rgba(220,176,89,0.3);
    overflow: hidden;
    font-family: Arial, sans-serif;
  }
  .buy-bonus-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(180deg, #3d352b, #221b14);
    padding: 8px 12px;
    border-bottom: 1.5px solid #dcb059;
  }
  .buy-bonus-header span {
    font-size: 15px;
    font-weight: bold;
    color: #f7dfa4;
    text-shadow: 0 1px 2px #000;
    flex-grow: 1;
    text-align: center;
  }
  .buy-bonus-close {
    background: transparent;
    border: none;
    color: #dcb059;
    font-size: 20px;
    cursor: pointer;
    font-weight: bold;
    line-height: 1;
    padding: 0;
    margin: 0;
    transition: color 0.15s;
  }
  .buy-bonus-close:hover {
    color: #fff;
  }
  .buy-bonus-body {
    padding: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }
  .buy-bonus-tip {
    background: rgba(0,0,0,0.4);
    border: 1px solid rgba(220,176,89,0.25);
    border-radius: 6px;
    padding: 8px;
    font-size: 9.5px;
    color: #ffd88a;
    text-align: center;
    line-height: 1.35;
  }
  .buy-bonus-icon-wrapper {
    display: flex;
    justify-content: center;
    margin: 4px 0;
  }
  .buy-bonus-icon {
    width: 68px;
    height: 68px;
    border-radius: 12px;
    background: radial-gradient(circle, #ffe9a8 0%, #d99a2b 100%);
    border: 2.5px solid #ffbe1a;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5), inset 0 0 8px rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url("{{ asset('assets/image/SuperAceDeluxe/8.png') }}");
    background-size: cover;
    background-position: center;
  }
  .buy-bonus-icon::before {
    content: '';
  }
  .buy-bonus-grid {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .grid-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    height: 30px;
  }
  .grid-label {
    color: #dfd0be;
    font-weight: 500;
  }
  .grid-control {
    display: flex;
    align-items: center;
    border: 1px solid #4a3f31;
    background: #0f0d0a;
    border-radius: 6px;
    overflow: hidden;
    height: 28px;
    width: 130px;
    justify-content: space-between;
  }
  .grid-btn {
    background: linear-gradient(180deg, #443b2f, #28221a);
    border: none;
    color: #f7dfa4;
    font-size: 16px;
    font-weight: bold;
    width: 30px;
    height: 100%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
  }
  .grid-btn:hover {
    background: #5c5040;
  }
  .grid-btn:active {
    background: #1c1813;
  }
  .grid-value {
    color: #fff;
    font-weight: bold;
    font-size: 13px;
    flex-grow: 1;
    text-align: center;
    font-family: monospace;
  }
  .grid-value-static {
    background: #0f0d0a;
    border: 1px solid #4a3f31;
    border-radius: 6px;
    width: 130px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #fff;
    font-family: monospace;
    font-size: 13px;
  }
  .buy-play-btn {
    width: 150px;
    padding: 8px 0;
    border-radius: 20px;
    border: 1.5px solid #276107;
    background: linear-gradient(180deg, #74cc29 0%, #359c07 100%);
    color: #fff;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.4);
    text-shadow: 0 1px 2px #153802;
    transition: filter 0.15s;
    text-align: center;
  }
  .buy-play-btn:hover {
    filter: brightness(1.1);
  }
  }
  .buy-play-btn:active {
    transform: translateY(1.5px);
    box-shadow: 0 1px 4px rgba(0,0,0,0.4);
  }

  /* ---------- Vertical Settings Menu ---------- */
  .settings-menu {
    position: absolute;
    bottom: 110px;
    left: 70px; /* position it vertically right above the gear button area */
    background: linear-gradient(180deg, #2b261f 0%, #15120e 100%);
    border: 2px solid #caa030;
    border-radius: 8px;
    display: none;
    flex-direction: column;
    gap: 8px;
    padding: 8px;
    z-index: 28;
    box-shadow: 0 10px 30px rgba(0,0,0,0.8);
    width: 48px;
    align-items: center;
  }
  .settings-menu.show {
    display: flex;
  }
  .settings-menu button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #caa030;
    background: #141311;
    color: #dfd0be;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.15s;
    padding: 0;
  }
  .settings-menu button:hover {
    background: #caa030;
    color: #121a2e;
  }
  .settings-menu button.active {
    background: #276107;
    color: #fff;
    border-color: #74cc29;
  }

  /* ---------- AutoSpin Setting Panel ---------- */
  .auto-spin-panel {
    background: linear-gradient(180deg, #2b261f 0%, #15120e 100%);
    border: 2.5px solid #dcb059;
    border-radius: 12px;
    width: 330px;
    max-width: 92vw;
    color: #fff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.8), inset 0 0 10px rgba(220,176,89,0.3);
    overflow: hidden;
    font-family: Arial, sans-serif;
  }
  .auto-spin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(180deg, #3d352b, #221b14);
    padding: 10px 12px;
    border-bottom: 1.5px solid #dcb059;
  }
  .auto-spin-header span {
    font-size: 16px;
    font-weight: bold;
    color: #f7dfa4;
    text-shadow: 0 1px 2px #000;
    flex-grow: 1;
    text-align: center;
    letter-spacing: 0.5px;
  }
  .auto-spin-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .auto-spin-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    height: 32px;
    gap: 10px;
  }
  .auto-spin-option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    flex-grow: 1;
    color: #dfd0be;
    font-weight: bold;
  }
  .auto-spin-option input[type="checkbox"] {
    display: none; /* Hide standard checkbox */
  }
  .custom-checkbox {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 1.5px solid #caa030;
    background: #100e0b;
    position: relative;
    display: inline-block;
    flex-shrink: 0;
  }
  .auto-spin-option input[type="checkbox"]:checked + .custom-checkbox {
    background: #3c2a15;
  }
  .auto-spin-option input[type="checkbox"]:checked + .custom-checkbox::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #ffcf5c;
    box-shadow: 0 0 6px #ffbe1a;
  }
  .auto-spin-control {
    display: flex;
    align-items: center;
    border: 1px solid #4a3f31;
    background: #0f0d0a;
    border-radius: 6px;
    overflow: hidden;
    height: 28px;
    width: 120px;
    justify-content: space-between;
  }
  .auto-presets-row {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: -6px;
    margin-bottom: 2px;
    padding-left: 26px; /* Align with text after checkbox */
  }
  .preset-spin-btn {
    background: #251e15;
    border: 1px solid #4a3f31;
    color: #dfd0be;
    font-size: 11px;
    padding: 5px 8px;
    border-radius: 4px;
    cursor: pointer;
    flex: 1;
    margin: 0 2px;
    text-align: center;
    font-weight: bold;
  }
  .preset-spin-btn:hover {
    background: #3c2f1e;
    color: #fff;
  }
  .preset-spin-btn.active {
    background: #caa030;
    color: #000;
    border-color: #caa030;
  }
  .auto-action-row {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    margin-top: 10px;
  }
  .auto-cancel-btn {
    flex: 1;
    padding: 8px 0;
    border-radius: 6px;
    border: 1.5px solid #6b101a;
    background: linear-gradient(180deg, #d32f2f 0%, #b71c1c 100%);
    color: #fff;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    text-shadow: 0 1px 2px #42060c;
    text-align: center;
  }
  .auto-cancel-btn:hover {
    filter: brightness(1.1);
  }
  .auto-start-btn {
    flex: 1;
    padding: 8px 0;
    border-radius: 6px;
    border: 1.5px solid #276107;
    background: linear-gradient(180deg, #74cc29 0%, #359c07 100%);
    color: #fff;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.4);
    text-shadow: 0 1px 2px #153802;
    text-align: center;
  }
  .auto-start-btn:hover {
    filter: brightness(1.1);
  }

  .bet-popover {
    position: absolute;
    bottom: 104px;
    left: 50%;
    transform: translateX(-50%);
    background: #111111;
    border: 2px solid #caa030;
    border-radius: 8px;
    display: none;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 1px;
    background-color: #2b2114; /* Border color between grid items */
    padding: 2px;
    z-index: 25;
    box-shadow: 0 10px 30px rgba(0,0,0,0.8);
    width: 200px;
  }
  .bet-popover.show {
    display: grid;
  }
  .bet-popover button {
    background: #141311;
    border: none;
    color: #dfd0be;
    font-size: 13px;
    font-weight: bold;
    padding: 10px 0;
    cursor: pointer;
    text-align: center;
    transition: background 0.15s, color 0.15s;
    font-family: Arial, sans-serif;
  }
  .bet-popover button:hover {
    background: #25221d;
    color: #fff;
  }
  .bet-popover button.sel {
    background: #3c2a15;
    color: #fff;
    box-shadow: inset 0 0 0 1.5px #ffcf5c; /* highlighted golden border inside cell */
  }

  .paytable-list{text-align:left;font-size:11.5px;margin:0 0 12px;color:#e6d6b8;}
  .paytable-list div{display:flex;justify-content:space-between;padding:3px 0;border-bottom:1px solid #ffffff14;}

  .toast{
    position:absolute;top:54px;left:50%;transform:translateX(-50%);
    background:#1a0f06ee;border:1px solid var(--gold);color:var(--cream);
    padding:8px 16px;border-radius:8px;font-size:12px;z-index:40;
    opacity:0;transition:opacity .25s,transform .25s;pointer-events:none;
  }
  .toast.show{opacity:1;transform:translateX(-50%) translateY(4px);}
</style>
</head>
<body>
<div class="app" id="app">

  <div class="topbar">
    <div class="brand-mark">♠</div>
    <div class="title">Super Ace Deluxe</div>
    <div class="demo-toggle" id="demoToggleBtn">
      <span class="switch active" id="demoSwitch"></span>
      <span id="demoLabel">DEMO PLAY (virtual credits)</span>
    </div>
    <div class="spacer"></div>
    <button class="icon-btn" id="btnFullscreen" title="Fullscreen">⛶</button>
    <button class="icon-btn" id="btnReset" title="Reset demo balance">↻</button>
    <button class="icon-btn" id="btnClose" title="Close">✕</button>
  </div>

  <div class="rail">
    <button id="railFav" title="Favorite">♥</button>
    <button title="Game menu">▦</button>
    <button title="Promotions">⚡</button>
    <button title="Leaderboard">🏆</button>
    <button title="Rewards">🎁</button>
  </div>

  <div class="stage">
    <div class="machine">
      <div class="marquee">
        <h1>Super Ace<span class="sub">D E L U X E</span></h1>
        <button class="buy-bonus" id="btnBuyBonus">BUY<br>BONUS</button>
      </div>

      <div class="ladder" id="ladder">
        <div class="pip" data-i="0">×1</div>
        <div class="pip" data-i="1">×2</div>
        <div class="pip" data-i="2">×3</div>
        <div class="pip" data-i="3">×5</div>
        <div class="pip star" data-i="4">★</div>
      </div>

      <div class="bonus-banner" id="bonusBanner">FREE SPINS BONUS — <span id="bonusSpinsLeft">10</span> LEFT · TOTAL WIN <span id="bonusTotal">0.000</span></div>

      <div class="reel-frame">
        <canvas id="reelCanvas" width="372" height="320"></canvas>
      </div>

      <div class="win-row">WIN&nbsp;&nbsp;<span class="amt" id="winAmt">0.000</span></div>

      <div class="controls">
        <button class="ctrl-btn" id="btnSettings" title="Settings">⚙</button>
        <div class="bet-pill" id="betPill">BET<b id="betVal">2</b></div>
        <button class="spin-btn" id="btnSpin" title="Spin"><span class="tri">▶</span><span class="spinner"></span></button>
        <button class="ctrl-btn" id="btnTurbo" title="Turbo spin">⚡</button>
        <button class="ctrl-btn" id="btnAuto" title="Autoplay">↻</button>
      </div>

      <div class="balance-row">Balance&nbsp; <b id="balanceVal">2,000.000</b></div>
    </div>
  </div>

  <div class="foot-note">Portfolio demo · virtual credits only · no real-money wagering</div>

  <div class="bet-popover" id="betPopover"></div>

  <!-- Vertical Settings Menu -->
  <div class="settings-menu" id="settingsMenu">
    <button id="menuAutoSpin" title="AutoSpin Setting"><i class="fa-solid fa-rotate"></i></button>
    <button id="menuInfo" title="Paytable Information"><i class="fa-solid fa-info"></i></button>
    <button id="menuSound" title="Toggle Sound" class="active"><i class="fa-solid fa-volume-high"></i></button>
  </div>

  <div class="overlay" id="confirmOverlay">
    <div class="buy-bonus-panel">
      <div class="buy-bonus-header">
        <span>Buy Bonus</span>
        <button class="buy-bonus-close" id="confirmCancel">&times;</button>
      </div>
      <div class="buy-bonus-body">
        <div class="buy-bonus-tip">
          Click 'Buy & Play' to purchase and activate the featured game automatically.
        </div>
        
        <!-- Central Icon -->
        <div class="buy-bonus-icon-wrapper">
          <div class="buy-bonus-icon"></div>
        </div>
        
        <!-- Grid fields -->
        <div class="buy-bonus-grid">
          <div class="grid-row">
            <span class="grid-label">Bet</span>
            <div class="grid-control">
              <button class="grid-btn" id="buyBetMinus">-</button>
              <span class="grid-value" id="buyBetVal">0.5</span>
              <button class="grid-btn" id="buyBetPlus">+</button>
            </div>
          </div>
          
          <div class="grid-row">
            <span class="grid-label">Quantity</span>
            <div class="grid-control">
              <button class="grid-btn" id="buyQtyMinus">-</button>
              <span class="grid-value" id="buyQtyVal">1</span>
              <button class="grid-btn" id="buyQtyPlus">+</button>
            </div>
          </div>
          
          <div class="grid-row">
            <span class="grid-label">Price</span>
            <span class="grid-value-static" id="buyPriceVal">21</span>
          </div>
          
          <div class="grid-row">
            <span class="grid-label">Total Price</span>
            <span class="grid-value-static" id="buyTotalPriceVal">21</span>
          </div>
        </div>
        
        <!-- Action Button -->
        <button class="buy-play-btn" id="confirmOk">Buy & Play</button>
      </div>
    </div>
  </div>

  <!-- AutoSpin settings modal overlay -->
  <div class="overlay" id="autoSpinOverlay">
    <div class="auto-spin-panel">
      <div class="auto-spin-header">
        <span>AutoSpin Setting</span>
      </div>
      <div class="auto-spin-body">
        
        <!-- Total Spins Option -->
        <div class="auto-spin-row">
          <label class="auto-spin-option">
            <input type="checkbox" id="chkTotalSpins" checked>
            <span class="custom-checkbox"></span>
            <span>Total Spins</span>
          </label>
          <div class="auto-spin-control">
            <button class="grid-btn" id="autoSpinsMinus">-</button>
            <span class="grid-value" id="autoSpinsVal">50</span>
            <button class="grid-btn" id="autoSpinsPlus">+</button>
          </div>
        </div>
        
        <!-- Preset buttons for spins -->
        <div class="auto-presets-row">
          <button class="preset-spin-btn" data-val="10">10</button>
          <button class="preset-spin-btn" data-val="20">20</button>
          <button class="preset-spin-btn" data-val="30">30</button>
          <button class="preset-spin-btn" data-val="40">40</button>
          <button class="preset-spin-btn active" data-val="50">50</button>
        </div>
        
        <!-- Single win exceeds -->
        <div class="auto-spin-row">
          <label class="auto-spin-option">
            <input type="checkbox" id="chkWinExceeds">
            <span class="custom-checkbox"></span>
            <span>Single win ratio exceeds</span>
          </label>
          <div class="auto-spin-control">
            <button class="grid-btn" id="autoWinMinus">-</button>
            <span class="grid-value" id="autoWinVal">100X</span>
            <button class="grid-btn" id="autoWinPlus">+</button>
          </div>
        </div>
        
        <!-- Stop if balance < -->
        <div class="auto-spin-row">
          <label class="auto-spin-option">
            <input type="checkbox" id="chkBalanceLess">
            <span class="custom-checkbox"></span>
            <span>Stop if balance&lt;</span>
          </label>
          <div class="auto-spin-control">
            <button class="grid-btn" id="autoBalLessMinus">-</button>
            <span class="grid-value" id="autoBalLessVal">0</span>
            <button class="grid-btn" id="autoBalLessPlus">+</button>
          </div>
        </div>
        
        <!-- Stop if balance > -->
        <div class="auto-spin-row">
          <label class="auto-spin-option">
            <input type="checkbox" id="chkBalanceMore">
            <span class="custom-checkbox"></span>
            <span>Stop if balance&gt;</span>
          </label>
          <div class="auto-spin-control">
            <button class="grid-btn" id="autoBalMoreMinus">-</button>
            <span class="grid-value" id="autoBalMoreVal">0</span>
            <button class="grid-btn" id="autoBalMorePlus">+</button>
          </div>
        </div>
        
        <!-- Stop if Free Game is activated -->
        <div class="auto-spin-row">
          <label class="auto-spin-option">
            <input type="checkbox" id="chkFreeGameStop">
            <span class="custom-checkbox"></span>
            <span>Stop if "Free Game" is activated</span>
          </label>
        </div>
        
        <!-- Confirm Buttons -->
        <div class="auto-action-row">
          <button class="auto-cancel-btn" id="autoCancelBtn">Cancel</button>
          <button class="auto-start-btn" id="autoStartBtn">Start</button>
        </div>
      </div>
    </div>
  </div>

  <div class="overlay" id="settingsOverlay">
    <div class="panel">
      <h3>Paytable</h3>
      <div class="paytable-list" id="paytableList"></div>
      <div class="row"><button class="confirm" id="settingsClose">Close</button></div>
    </div>
  </div>

  <div class="overlay" id="bonusEndOverlay">
    <div class="panel">
      <h3>Bonus Complete!</h3>
      <p>Your 10 free spins are over.</p>
      <p style="font-size:18px;color:#fff;font-weight:800;margin-top:-6px;" id="bonusEndAmt">+0.000</p>
      <div class="row"><button class="confirm" id="bonusEndOk">Collect</button></div>
    </div>
  </div>

  <div class="overlay" id="closeOverlay">
    <div class="panel">
      <h3>Thanks for playing!</h3>
      <p>This demo session has ended.</p>
      <div class="row"><button class="confirm" id="reopenBtn">Play again</button></div>
    </div>
  </div>

  <div class="toast" id="toast"></div>
</div>

<script>
(function(){

/* ===================== CONFIG & SYMBOLS PRELOADING ===================== */
const COLS = 5, ROWS = 4;
const SCROLL_COUNT = 16;          // how many random symbols scroll past before landing
const CELL_W = 372 / COLS, CELL_H = 320 / ROWS;
const LADDER = [1,2,3,5,10];
const PRESET_BETS = [0.5, 1, 2, 3, 5, 10, 20, 30, 40, 50, 80, 100, 200, 500, 1000];

const SYMBOLS = [
  { id: 'SYM1',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/1.png') }}",  weight: 12, pay: {3:5, 4:10, 5:25} }, // Ace
  { id: 'SYM2',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/2.png') }}",  weight: 14, pay: {3:4, 4:8, 5:15} },  // King
  { id: 'SYM3',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/3.png') }}",  weight: 16, pay: {3:3, 4:6, 5:12} },  // Queen
  { id: 'SYM4',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/4.png') }}",  weight: 18, pay: {3:2, 4:4, 5:8} },   // Jack
  { id: 'SYM5',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/5.png') }}",  weight: 20, pay: {3:1.5, 4:3, 5:6} }, // Spade
  { id: 'SYM6',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/6.png') }}",  weight: 22, pay: {3:1, 4:2, 5:5} },   // Heart
  { id: 'SYM7',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/7.png') }}",  weight: 24, pay: {3:0.8, 4:1.6, 5:4} },// Diamond
  { id: 'SYM8',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/10.png') }}", weight: 26, pay: {3:0.6, 4:1.2, 5:3} },// Club
  { id: 'SYM9',  imgSrc: "{{ asset('assets/image/SuperAceDeluxe/9.png') }}",  weight: 10, pay: {3:2, 4:4, 5:10} },  // Golden Heart
  { id: 'SYM10', imgSrc: "{{ asset('assets/image/SuperAceDeluxe/11.png') }}", weight: 10, pay: {3:2, 4:4, 5:10} },  // Golden Club
  { id: 'SYM11', imgSrc: "{{ asset('assets/image/SuperAceDeluxe/12.png') }}", weight: 10, pay: {3:2, 4:4, 5:10} },  // Golden Spade
  { id: 'WILD',  imgSrc: "", weight: 8, pay: null, isWild: true },
  { id: 'SCATTER', imgSrc: "{{ asset('assets/image/SuperAceDeluxe/8.png') }}", weight: 6, pay: null, isScatter: true },
];

const SYMBOLS_BY_ID = Object.fromEntries(SYMBOLS.map(s=>[s.id,s]));
const TOTAL_WEIGHT = SYMBOLS.reduce((a,s)=>a+s.weight,0);

function pickSymbol(){
  let r = Math.random()*TOTAL_WEIGHT;
  for(const s of SYMBOLS){ if(r<s.weight) return s; r-=s.weight; }
  return SYMBOLS[SYMBOLS.length-1];
}

// Preload Images asynchronously
const images = {};
let imagesLoaded = 0;
const totalImages = SYMBOLS.length;

SYMBOLS.forEach(sym => {
  if (sym.imgSrc) {
    const img = new Image();
    img.src = sym.imgSrc;
    img.onload = () => {
      imagesLoaded++;
    };
    img.onerror = () => {
      console.error("Failed to load game symbol image: " + sym.imgSrc);
    };
    images[sym.id] = img;
  }
});

/* ===================== LARAVEL INTEGRATION STATE ===================== */
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
let demoBalance = 2000.00;

const state = {
  balance: isDemoMode ? demoBalance : realBalance,
  bet: 2,
  spinning: false,
  turbo: false,
  autoplay: false,
  ladderIndex: 0,
  bonusMode: false,
  bonusLadder: 0,
  bonusTotalWin: 0,
  freeSpinsLeft: 0,
  winThisSpin: 0,
};

const autoSpinConfig = {
  active: false,
  totalSpins: 50,
  useTotalSpins: true,
  winExceeds: null,
  balLess: null,
  balMore: null,
  stopOnFree: false
};

let currentGrid = [];     // currentGrid[col][row] = symbol
let highlightCells = [];  // currentGrid-shaped boolean mask
let highlightTimer = 0;
const columnAnim = new Array(COLS).fill(null);

function freshGrid(){
  const g = [];
  for(let c=0;c<COLS;c++){ const col=[]; for(let r=0;r<ROWS;r++) col.push(pickSymbol()); g.push(col); }
  return g;
}
function initialGrid(){
  const g = [];
  const normalSymbols = SYMBOLS.filter(s => !s.isWild && !s.isScatter);
  for(let c=0;c<COLS;c++){
    const col=[];
    for(let r=0;r<ROWS;r++) {
      const idx = Math.floor(Math.random() * normalSymbols.length);
      col.push(normalSymbols[idx]);
    }
    g.push(col);
  }
  return g;
}
function freshMask(){
  return Array.from({length:COLS},()=>Array.from({length:ROWS},()=>false));
}
currentGrid = initialGrid();
highlightCells = freshMask();

/* ===================== CANVAS DRAWING & PARTICLE SYSTEM ===================== */
const canvas = document.getElementById('reelCanvas');
const ctx = canvas.getContext('2d');

const particles = [];

function spawnFireParticle(cellX, cellY, w, h) {
  // Spawn particles randomly on the winning cell borders or inside
  const px = cellX + Math.random() * w;
  const py = cellY + Math.random() * h;
  
  // Vibrant star/fire colors: white, gold, orange, red, yellow
  const colors = ['#ffffff', '#fff5d6', '#ffbe1a', '#ff5c1a', '#ff221a', '#ffd700'];
  const color = colors[Math.floor(Math.random() * colors.length)];
  
  particles.push({
    x: px,
    y: py,
    vx: (Math.random() - 0.5) * 2,    // horizontal dispersion
    vy: -Math.random() * 2.5 - 0.8,   // float upwards
    life: 1.0,
    decay: 0.015 + Math.random() * 0.02,
    size: 2.5 + Math.random() * 4.5,
    color: color,
    isStar: Math.random() > 0.4       // 60% are stars, 40% are glowing circles
  });
}

function drawStar(c, cx, cy, spikes, outerRadius, innerRadius, color) {
  let rot = Math.PI / 2 * 3;
  let x = cx;
  let y = cy;
  let step = Math.PI / spikes;

  c.save();
  c.beginPath();
  c.moveTo(cx, cy - outerRadius);
  for (let i = 0; i < spikes; i++) {
    x = cx + Math.cos(rot) * outerRadius;
    y = cy + Math.sin(rot) * outerRadius;
    c.lineTo(x, y);
    rot += step;

    x = cx + Math.cos(rot) * innerRadius;
    y = cy + Math.sin(rot) * innerRadius;
    c.lineTo(x, y);
    rot += step;
  }
  c.lineTo(cx, cy - outerRadius);
  c.closePath();
  c.fillStyle = color;
  c.shadowColor = color;
  c.shadowBlur = 8;
  c.fill();
  c.restore();
}

function updateAndDrawParticles() {
  for (let i = particles.length - 1; i >= 0; i--) {
    const p = particles[i];
    p.x += p.vx;
    p.y += p.vy;
    p.life -= p.decay;
    
    if (p.life > 0) {
      ctx.save();
      ctx.globalAlpha = p.life;
      if (p.isStar) {
        drawStar(ctx, p.x, p.y, 4, p.size * 1.4, p.size * 0.45, p.color);
      } else {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fillStyle = p.color;
        ctx.shadowColor = p.color;
        ctx.shadowBlur = 6;
        ctx.fill();
      }
      ctx.restore();
    } else {
      particles.splice(i, 1);
    }
  }
}

function roundRect(c,x,y,w,h,r){
  c.beginPath();
  c.moveTo(x+r,y);
  c.arcTo(x+w,y+h,x+w,y+h,r);
  c.arcTo(x+w,y+h,x,y+h,r);
  c.arcTo(x,y+h,x,y,r);
  c.arcTo(x,y,x+w,y,r);
  c.closePath();
}

function drawSpade(c, cx, cy, size, color) {
  c.save();
  c.translate(cx, cy);
  c.scale(size/40, size/40);
  c.fillStyle = color;
  c.beginPath();
  c.moveTo(0, -18);
  c.bezierCurveTo(14, -4, 16, 8, 4, 12);
  c.bezierCurveTo(2, 13, 1, 12, 0, 9);
  c.bezierCurveTo(-1, 12, -2, 13, -4, 12);
  c.bezierCurveTo(-16, 8, -14, -4, 0, -18);
  c.closePath();
  c.fill();
  c.beginPath();
  c.moveTo(0, 9); c.lineTo(-4, 20); c.lineTo(4, 20); c.closePath();
  c.fill();
  c.restore();
}

function drawHeart(c, cx, cy, size, color) {
  c.save();
  c.translate(cx, cy);
  c.scale(size/40, size/40);
  c.fillStyle = color;
  c.beginPath();
  c.moveTo(0, -12);
  c.bezierCurveTo(5, -22, 20, -18, 20, -5);
  c.bezierCurveTo(20, 8, 8, 16, 0, 22);
  c.bezierCurveTo(-8, 16, -20, 8, -20, -5);
  c.bezierCurveTo(-20, -18, -5, -22, 0, -12);
  c.closePath();
  c.fill();
  c.restore();
}

function drawDiamond(c, cx, cy, size, color) {
  c.save();
  c.translate(cx, cy);
  c.scale(size/40, size/40);
  c.fillStyle = color;
  c.beginPath();
  c.moveTo(0, -20);
  c.lineTo(16, 0);
  c.lineTo(0, 20);
  c.lineTo(-16, 0);
  c.closePath();
  c.fill();
  c.restore();
}

function drawClub(c, cx, cy, size, color) {
  c.save();
  c.translate(cx, cy);
  c.scale(size/40, size/40);
  c.fillStyle = color;
  c.beginPath();
  c.arc(0, -8, 8, 0, Math.PI*2);
  c.arc(-8, 4, 8, 0, Math.PI*2);
  c.arc(8, 4, 8, 0, Math.PI*2);
  c.closePath();
  c.fill();
  c.beginPath();
  c.moveTo(0, 4); c.lineTo(-4, 18); c.lineTo(4, 18); c.closePath();
  c.fill();
  c.restore();
}

function drawCrown(c, cx, cy, w, color) {
  c.save();
  c.translate(cx-w/2, cy);
  c.fillStyle = color;
  c.beginPath();
  c.moveTo(0, 8); c.lineTo(0, -2); c.lineTo(w*0.25, 4); c.lineTo(w*0.5, -8);
  c.lineTo(w*0.75, 4); c.lineTo(w, -2); c.lineTo(w, 8); c.closePath();
  c.fill();
  c.restore();
}

function drawTiara(c, cx, cy, w, color) {
  c.save();
  c.translate(cx-w/2, cy);
  c.fillStyle = color;
  c.beginPath();
  c.moveTo(0, 8); c.quadraticCurveTo(w*0.5, -10, w, 8); c.lineTo(w, 8);
  c.quadraticCurveTo(w*0.5, 2, 0, 8); c.closePath();
  c.fill();
  c.beginPath(); c.arc(w*0.5, -8, 2.6, 0, Math.PI*2); c.fill();
  c.restore();
}

function drawTiaraAndCrownSpadeCap(c, cx, cy, w, color) {
  c.save();
  c.translate(cx-w/2, cy);
  c.fillStyle = color;
  c.beginPath();
  c.rect(0, -4, w, 8);
  c.fill();
  c.beginPath(); c.moveTo(w*0.18, -4); c.lineTo(w*0.5, -12); c.lineTo(w*0.82, -4); c.closePath(); c.fill();
  c.restore();
}

function drawSymbol(c, sym, x, y, w, h, isWinning = false){
  const pad = Math.min(w,h)*0.06;
  let scale = 1.0;
  let rotateY = 1.0;
  
  if (isWinning) {
    // Pulse scale calculation based on highlightTimer
    scale = 1.0 + 0.05 * Math.sin(highlightTimer / 90);
    // Rotate Y-axis (flip effect) to simulate 3D rotation!
    rotateY = Math.cos(highlightTimer / 120);
  }

  const cx = x+w/2, cy = y+h/2;
  const nw = w * scale;
  const nh = h * scale;
  const nx = -nw/2;
  const ny = -nh/2;
  const npad = Math.min(nw, nh)*0.06;

  c.save();
  c.translate(cx, cy);
  c.scale(rotateY, 1);

  // Background card styling
  c.beginPath();
  c.moveTo(nx+npad+10, ny+npad);
  c.arcTo(nx+nw-npad, ny+npad, nx+nw-npad, ny+nh-npad, 10);
  c.arcTo(nx+nw-npad, ny+nh-npad, nx+npad, ny+nh-npad, 10);
  c.arcTo(nx+npad, ny+nh-npad, nx+npad, ny+npad, 10);
  c.arcTo(nx+npad, ny+npad, nx+nw-npad, ny+npad, 10);
  c.closePath();
  
  c.fillStyle = sym.isWild ? '#1c1308' : '#eef1fb'; // Wild gets dark, others get clean white/cream cards
  c.fill();
  c.lineWidth = isWinning ? 3 : 1.5;
  c.strokeStyle = isWinning ? `rgba(255, ${200 + Math.round(55 * Math.sin(highlightTimer / 100))}, 90, 1)` : (sym.isWild ? '#ffcf5c' : '#bdc6d4');
  if (isWinning) {
    c.shadowColor = '#ffce5c';
    c.shadowBlur = 15;
  }
  c.stroke();

  // Reset shadow for inner drawing
  c.shadowColor = 'transparent';
  c.shadowBlur = 0;

  const img = images[sym.id];

  // Decide whether to show the premium screenshot image
  let showImage = false;
  if (sym.isScatter) {
    // Scatter only shows the premium image (8.png) when winning/triggering
    showImage = isWinning;
  } else if (sym.isWild) {
    // Wild is drawn dynamically or shown on win
    showImage = false;
  } else {
    // All other normal symbols (A, K, Q, J, suits, etc.) ALWAYS show their screenshot images!
    showImage = true;
  }

  if (showImage && img && img.complete) {
    c.save();
    c.beginPath();
    const rx = nx+npad+2;
    const ry = ny+npad+2;
    const rw = nw-npad*2-4;
    const rh = nh-npad*2-4;
    c.moveTo(rx+8, ry);
    c.arcTo(rx+rw, ry, rx+rw, ry+rh, 8);
    c.arcTo(rx+rw, ry+rh, rx, ry+rh, 8);
    c.arcTo(rx, ry+rh, rx, ry, 8);
    c.arcTo(rx, ry, rx+rw, ry, 8);
    c.closePath();
    c.clip();
    c.drawImage(img, rx, ry, rw, rh);
    c.restore();
  } else {
    // DRAW THE CLEAN VECTOR/TEXT CARD (FALLBACK STATE)!
    const ink = (sym.id === 'SYM2' || sym.id === 'SYM3' || sym.id === 'SYM6' || sym.id === 'SYM8') ? '#a32338' : '#22305a';
    
    // Draw corner pips (for A, K, Q, J, 10, 9)
    if (['SYM1', 'SYM2', 'SYM3', 'SYM4', 'SYM5', 'SYM6'].includes(sym.id)) {
      const labelMap = { 'SYM1':'A', 'SYM2':'K', 'SYM3':'Q', 'SYM4':'J', 'SYM5':'10', 'SYM6':'9' };
      const label = labelMap[sym.id];
      
      c.save();
      c.fillStyle = ink;
      c.font = `bold ${Math.round(nh * 0.15)}px Georgia, serif`;
      c.textAlign = 'left';
      c.textBaseline = 'top';
      c.fillText(label, nx + npad * 1.5, ny + npad * 1.2);
      
      c.translate(nx + nw - npad * 1.5, ny + nh - npad * 1.2);
      c.rotate(Math.PI);
      c.textAlign = 'left';
      c.textBaseline = 'top';
      c.fillText(label, 0, 0);
      c.restore();
    }

    // Center graphics drawing
    if (sym.id === 'SYM1') { // Ace of Spades
      drawSpade(c, 0, 0, nh * 0.42, ink);
    } else if (sym.id === 'SYM2') { // King of Hearts
      drawCrown(c, 0, -nh * 0.08, nh * 0.26, '#caa030');
      drawHeart(c, 0, nh * 0.12, nh * 0.22, ink);
    } else if (sym.id === 'SYM3') { // Queen of Hearts
      drawTiara(c, 0, -nh * 0.08, nh * 0.26, '#caa030');
      drawHeart(c, 0, nh * 0.12, nh * 0.22, ink);
    } else if (sym.id === 'SYM4') { // Jack of Spades
      drawTiaraAndCrownSpadeCap(c, 0, -nh * 0.08, nh * 0.22, '#caa030');
      drawSpade(c, 0, nh * 0.12, nh * 0.20, ink);
    } else if (sym.id === 'SYM5') { // 10 (Spades)
      drawSpade(c, 0, 0, nh * 0.32, ink);
    } else if (sym.id === 'SYM6') { // 9 (Hearts)
      drawHeart(c, 0, 0, nh * 0.32, ink);
    } else if (sym.id === 'SYM7') { // Spade Suit card
      drawSpade(c, 0, 0, nh * 0.45, '#22305a');
    } else if (sym.id === 'SYM8') { // Heart Suit card
      drawHeart(c, 0, 0, nh * 0.45, '#a32338');
    } else if (sym.id === 'SYM9') { // Club Suit card
      drawClub(c, 0, 0, nh * 0.45, '#22305a');
    } else if (sym.id === 'SYM10') { // Diamond Suit card
      drawDiamond(c, 0, 0, nh * 0.45, '#e08a00');
    } else if (sym.isWild) { // WILD card
      drawSpade(c, 0, -nh*0.06, nh * 0.52, '#e8c468');
      c.fillStyle = '#e8c468';
      c.font = `bold ${Math.round(nh * 0.11)}px Arial`;
      c.textAlign = 'center';
      c.textBaseline = 'middle';
      c.fillText('WILD', 0, nh * 0.28);
    } else if (sym.isScatter) { // SCATTER card
      // Draw golden circular coin
      c.beginPath();
      c.arc(0, -nh*0.06, nh * 0.25, 0, Math.PI * 2);
      c.fillStyle = '#caa030';
      c.fill();
      c.lineWidth = 1.5;
      c.strokeStyle = '#ffe9a8';
      c.stroke();
      
      c.fillStyle = '#fff';
      c.font = `bold ${Math.round(nh * 0.18)}px Arial`;
      c.textAlign = 'center';
      c.textBaseline = 'middle';
      c.fillText('$', 0, -nh*0.06);
      
      c.fillStyle = '#d99a2b';
      c.font = `bold ${Math.round(nh * 0.09)}px Arial`;
      c.fillText('SCATTER', 0, nh * 0.28);
    }
  }
  c.restore();
}

function drawColumnStatic(c, col, symbols, maskCol){
  const x = col*CELL_W;
  for(let r=0;r<ROWS;r++){
    const y = r*CELL_H;
    const isWinning = maskCol[r];
    drawSymbol(c, symbols[r], x, y, CELL_W, CELL_H, isWinning);
  }
}

function easeOutQuart(t){ return 1-Math.pow(1-t,4); }

function drawColumnSpinning(c, col, strip, offset){
  const x = col*CELL_W;
  c.save();
  c.beginPath(); c.rect(x,0,CELL_W,ROWS*CELL_H); c.clip();
  const baseIndex = Math.floor(offset/CELL_H);
  const frac = offset - baseIndex*CELL_H;
  for(let i=0;i<=ROWS;i++){
    const idx = baseIndex+i;
    const sym = strip[idx] || strip[strip.length-1];
    const y = i*CELL_H - frac;
    drawSymbol(c, sym, x, y, CELL_W, CELL_H, false);
  }
  c.restore();
}

/* ===================== WIN EVALUATION ===================== */
function evaluateRow(symsLeftToRight){
  let determined = null;
  for(const s of symsLeftToRight){ 
    if(!s.isWild && !s.isScatter){ 
      determined = s; 
      break; 
    } 
  }
  // If the entire row is WILD, it acts as SYM1 (highest payout)
  if(!determined) {
    const allWild = symsLeftToRight.every(s => s.isWild);
    if (allWild) {
      determined = SYMBOLS.find(s => s.id === 'SYM1');
    } else {
      return null;
    }
  }
  
  let run = 0;
  for(const s of symsLeftToRight){
    if(s.id === determined.id || s.isWild) {
      run++; 
    } else {
      break;
    }
  }
  
  if(run >= 3) {
    return { symbol: determined, count: Math.min(run, 5) };
  }
  return null;
}

function evaluateGrid(grid){
  const wins = [];
  for(let r=0;r<ROWS;r++){
    const rowSyms = [];
    for(let c=0;c<COLS;c++) rowSyms.push(grid[c][r]);
    const w = evaluateRow(rowSyms);
    if(w) wins.push({row:r, ...w});
  }
  return wins;
}

/* ===================== UI HELPERS ===================== */
const el = id=>document.getElementById(id);
const fmt = n => n.toFixed(3);

function updateBalanceUI(){
  if (isDemoMode) {
    el('balanceVal').textContent = fmt(state.balance);
  } else {
    el('balanceVal').textContent = currencySymbol + fmt(state.balance);
  }
}
function updateWinUI(){ el('winAmt').textContent = fmt(state.winThisSpin); }
function updateBetUI(){ el('betVal').textContent = state.bet; }
function updateLadderUI(){
  const idx = state.bonusMode ? state.bonusLadder : state.ladderIndex;
  document.querySelectorAll('.pip').forEach(p=>{
    p.classList.toggle('lit', Number(p.dataset.i) <= idx);
    const i = Number(p.dataset.i);
    if (i < 4) {
      if (state.bonusMode) {
        const labels = ['×2', '×4', '×6', '×10'];
        p.textContent = labels[i];
      } else {
        const labels = ['×1', '×2', '×3', '×5'];
        p.textContent = labels[i];
      }
    }
  });
}
function updateBonusUI(){
  el('bonusBanner').classList.toggle('show', state.bonusMode);
  el('bonusSpinsLeft').textContent = state.freeSpinsLeft;
  el('bonusTotal').textContent = fmt(state.bonusTotalWin);
}
function updateSpinAvailability(){
  const cost = state.bonusMode ? 0 : state.bet;
  const canAfford = state.balance >= cost;
  el('btnBuyBonus').disabled = state.spinning || (!state.bonusMode && state.balance < state.bet*100) || state.bonusMode;
  el('btnSpin').disabled = state.spinning || (!state.bonusMode && !canAfford);
  el('betPill').style.opacity = state.spinning || state.bonusMode ? .5 : 1;
}

let toastTimer=null;
function flash(msg){
  const t = el('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(()=>t.classList.remove('show'), 1800);
}

/* ---- tiny synthesized sound effects (no external audio files) ---- */
let audioCtx = null;
let soundEnabled = true;
function beep(freq,dur,type='sine',vol=0.05){
  if(!soundEnabled) return;
  try{
    if(!audioCtx) audioCtx = new (window.AudioContext||window.webkitAudioContext)();
    const o = audioCtx.createOscillator();
    const g = audioCtx.createGain();
    o.type=type; o.frequency.value=freq;
    g.gain.value=vol;
    o.connect(g); g.connect(audioCtx.destination);
    o.start();
    g.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime+dur);
    o.stop(audioCtx.currentTime+dur);
  }catch(e){/* audio not available, ignore */}
}
function sfxSpin(){ beep(220,0.08,'square',0.03); }
function sfxStop(){ beep(140,0.07,'triangle',0.04); }
function sfxWin(){ beep(660,0.12,'sine',0.05); setTimeout(()=>beep(880,0.15,'sine',0.05),90); }

/* ===================== SYNC BALANCE TO DATABASE ===================== */
function syncBalance(newBalance) {
  if (isDemoMode) return;
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
      realBalance = newBalance;
    }
  })
  .catch(err => console.error('Error syncing balance:', err));
}

/* ===================== SPIN LOGIC ===================== */
function startSpin(){
  if(state.spinning) return;
  
  const cost = state.bonusMode ? 0 : state.bet;
  if(state.balance < cost){ 
    flash('Insufficient balance.'); 
    state.autoplay=false; 
    renderAutoBtn(); 
    return; 
  }

  state.spinning = true;
  highlightCells = freshMask();
  
  state.balance -= cost;
  if (!state.bonusMode && !isDemoMode) {
    syncBalance(state.balance);
  }
  updateBalanceUI();
  
  state.winThisSpin = 0; updateWinUI();
  el('btnSpin').classList.add('busy');
  updateSpinAvailability();
  sfxSpin();

  const finalGrid = freshGrid();
  const baseDur = state.turbo ? 220 : 760;
  const step    = state.turbo ? 55  : 150;
  let finished = 0;

  for(let c=0;c<COLS;c++){
    const strip = [];
    for(let k=0;k<SCROLL_COUNT;k++) strip.push(pickSymbol());
    for(let r=0;r<ROWS;r++) strip.push(finalGrid[c][r]);
    columnAnim[c] = { strip, start: performance.now(), duration: baseDur + c*step, done:false };
  }

  function onAllDone(){
    // Count Scatters in finalGrid
    let scatterCount = 0;
    for(let c=0;c<COLS;c++) {
      for(let r=0;r<ROWS;r++) {
        if(finalGrid[c][r].isScatter) scatterCount++;
      }
    }
    
    // If we have less than 3 Scatters, replace them with a random normal symbol!
    if (scatterCount > 0 && scatterCount < 3) {
      const normalSymbols = SYMBOLS.filter(s => !s.isWild && !s.isScatter);
      for(let c=0;c<COLS;c++) {
        for(let r=0;r<ROWS;r++) {
          if(finalGrid[c][r].isScatter) {
            const idx = Math.floor(Math.random() * normalSymbols.length);
            finalGrid[c][r] = normalSymbols[idx];
          }
        }
      }
    }

    currentGrid = finalGrid;
    state.spinning = false;
    el('btnSpin').classList.remove('busy');
    resolveSpin(finalGrid);
  }

  function tick(timeNow){
    let allDone = true;
    for(let c=0;c<COLS;c++){
      const a = columnAnim[c];
      if(a && !a.done) allDone = false;
    }
    if(!allDone) requestAnimationFrame(tick);
    else onAllDone();
  }
  requestAnimationFrame(tick);
}

function resolveSpin(grid){
  const wins = evaluateGrid(grid);
  let totalWin = 0;
  const mask = freshMask();
  
  let wildCount = 0;
  let scatterCount = 0;
  
  for(let c=0;c<COLS;c++) {
    for(let r=0;r<ROWS;r++) {
      if(grid[c][r].isWild) wildCount++;
      if(grid[c][r].isScatter) scatterCount++;
    }
  }

  wins.forEach(w=>{
    totalWin += state.bet * w.symbol.pay[w.count];
    for(let c=0;c<w.count;c++) mask[c][w.row]=true;
  });

  // If 3 or more Scatters land, highlight them as winning cells to trigger fire/star animation!
  if (scatterCount >= 3) {
    for (let c = 0; c < COLS; c++) {
      for (let r = 0; r < ROWS; r++) {
        if (grid[c][r].isScatter) {
          mask[c][r] = true;
        }
      }
    }
  }

  highlightCells = mask;
  highlightTimer = 0;

  if(state.bonusMode){
    state.bonusLadder = Math.min(state.bonusLadder + wildCount, LADDER.length-1);
  } else {
    state.ladderIndex = Math.min(state.ladderIndex + wildCount, LADDER.length-1);
  }
  const baseMult = state.bonusMode ? [2, 4, 6, 10, 20] : [1, 2, 3, 5, 10];
  const ladderIdx = state.bonusMode ? state.bonusLadder : state.ladderIndex;
  const mult = baseMult[ladderIdx];
  const applied = totalWin * mult;

  if(totalWin>0){
    if(state.bonusMode){ 
      state.bonusTotalWin += applied; 
    }
    else { 
      state.balance += applied; 
      if (!isDemoMode) {
        syncBalance(state.balance);
      }
      state.ladderIndex = 0; 
    }
    state.winThisSpin = applied;
    sfxWin();
  } else {
    state.winThisSpin = 0;
  }

  updateBalanceUI(); updateWinUI(); updateLadderUI();

  // If scatterCount >= 3 and we are not in bonusMode, trigger Free Spins!
  if (scatterCount >= 3 && !state.bonusMode) {
    flash("🎰 3 SCATTERS! 10 FREE SPINS TRIGGERED! 🎰");
    if (autoSpinConfig.active && autoSpinConfig.stopOnFree) {
      autoSpinConfig.active = false;
    }
    state.autoplay = false;
    renderAutoBtn();
    setTimeout(() => {
      state.bonusMode = true;
      state.freeSpinsLeft = 10;
      state.bonusLadder = 0;
      state.bonusTotalWin = 0;
      updateBonusUI();
      updateLadderUI();
      updateSpinAvailability();
      startSpin();
    }, 1500);
    return;
  }

  if(state.bonusMode){
    state.freeSpinsLeft -= 1;
    updateBonusUI();
    if(state.freeSpinsLeft<=0){
      setTimeout(endBonus, 500);
    } else {
      updateSpinAvailability();
      setTimeout(startSpin, 850);
    }
  } else {
    updateSpinAvailability();
    if(state.autoplay){
      let shouldStop = false;
      let stopReason = '';
      
      if(autoSpinConfig.active){
        if(autoSpinConfig.useTotalSpins){
          autoSpinConfig.totalSpins--;
          el('autoSpinsVal').textContent = autoSpinConfig.totalSpins;
          if(autoSpinConfig.totalSpins <= 0){
            shouldStop = true;
            stopReason = 'Total spins completed.';
          }
        }
        
        if(!shouldStop && autoSpinConfig.winExceeds !== null){
          if(state.winThisSpin / state.bet >= autoSpinConfig.winExceeds){
            shouldStop = true;
            stopReason = 'Single win ratio exceeded.';
          }
        }
        
        if(!shouldStop && autoSpinConfig.balLess !== null){
          if(state.balance < autoSpinConfig.balLess){
            shouldStop = true;
            stopReason = 'Balance dropped below limit.';
          }
        }
        
        if(!shouldStop && autoSpinConfig.balMore !== null){
          if(state.balance > autoSpinConfig.balMore){
            shouldStop = true;
            stopReason = 'Balance exceeded limit.';
          }
        }
      }
      
      if(shouldStop){
        state.autoplay = false;
        autoSpinConfig.active = false;
        renderAutoBtn();
        flash(`Autoplay stopped: ${stopReason}`);
      } else {
        if(state.balance>=state.bet) setTimeout(startSpin, 550);
        else { state.autoplay=false; renderAutoBtn(); flash('Autoplay stopped — insufficient balance.'); }
      }
    }
  }
}

function endBonus(){
  state.bonusMode = false;
  state.balance += state.bonusTotalWin;
  if (!isDemoMode) {
    syncBalance(state.balance);
  }
  el('bonusEndAmt').textContent = '+'+fmt(state.bonusTotalWin);
  el('bonusEndOverlay').classList.add('show');
  updateBalanceUI();
  state.bonusLadder = 0; state.bonusTotalWin = 0; state.freeSpinsLeft = 0;
  updateBonusUI(); updateLadderUI(); updateSpinAvailability();
}

/* per-column animation driver, separate RAF loop tied to rendering */
function animateColumns(now){
  for(let c=0;c<COLS;c++){
    const a = columnAnim[c];
    if(a && !a.done){
      const elapsed = now - a.start;
      const progress = Math.min(elapsed / a.duration, 1);
      const eased = easeOutQuart(progress);
      const offset = SCROLL_COUNT*CELL_H*eased;
      drawColumnSpinning(ctx, c, a.strip, offset);
      if(progress>=1){
        a.done = true;
        sfxStop();
      }
    } else {
      const colSymbols = currentGrid[c];
      const colMask = highlightCells[c];
      drawColumnStatic(ctx, c, colSymbols, colMask);
      
      // Spawn fire/star particles on winning cards
      for (let r = 0; r < ROWS; r++) {
        if (colMask[r]) {
          // Spawn 1-2 particles per cell per frame
          if (Math.random() < 0.45) {
            spawnFireParticle(c * CELL_W, r * CELL_H, CELL_W, CELL_H);
          }
        }
      }
    }
  }
}

/* ===================== MAIN RENDER LOOP ===================== */
function loop(now){
  ctx.clearRect(0,0,canvas.width,canvas.height);
  highlightTimer = now;
  animateColumns(now);
  updateAndDrawParticles(); // Update and draw fire/star animations
  requestAnimationFrame(loop);
}
requestAnimationFrame(loop);

/* ===================== BUY BONUS CONTROLS ===================== */
let buyBet = 0.5;
let buyQty = 1;

function updateBuyModalValues() {
  const price = buyBet * 42;
  const totalPrice = price * buyQty;
  
  el('buyBetVal').textContent = buyBet;
  el('buyQtyVal').textContent = buyQty;
  el('buyPriceVal').textContent = fmt(price);
  el('buyTotalPriceVal').textContent = fmt(totalPrice);
}

el('buyBetMinus').onclick = () => {
  let idx = PRESET_BETS.indexOf(buyBet);
  if (idx > 0) {
    buyBet = PRESET_BETS[idx - 1];
    updateBuyModalValues();
  }
};

el('buyBetPlus').onclick = () => {
  let idx = PRESET_BETS.indexOf(buyBet);
  if (idx < PRESET_BETS.length - 1) {
    buyBet = PRESET_BETS[idx + 1];
    updateBuyModalValues();
  }
};

el('buyQtyMinus').onclick = () => {
  if (buyQty > 1) {
    buyQty--;
    updateBuyModalValues();
  }
};

el('buyQtyPlus').onclick = () => {
  if (buyQty < 10) {
    buyQty++;
    updateBuyModalValues();
  }
};

function buyBonus(){
  if(state.spinning || state.bonusMode) return;
  buyBet = state.bet; // Default the modal bet size to current spin bet
  buyQty = 1;
  updateBuyModalValues();
  el('confirmOverlay').classList.add('show');
}

el('confirmOk').onclick = ()=>{
  const cost = buyBet * 42 * buyQty;
  if(state.balance < cost){ 
    flash('Insufficient balance.'); 
    return; 
  }
  
  el('confirmOverlay').classList.remove('show');
  state.balance -= cost;
  state.bet = buyBet; // Lock in the bet used for the free spins bonus
  updateBetUI();
  
  if (!isDemoMode) {
    syncBalance(state.balance);
  }
  updateBalanceUI();
  
  state.bonusMode = true;
  state.freeSpinsLeft = 10 * buyQty; // Set the total free spins purchased
  state.bonusLadder = 0;
  state.bonusTotalWin = 0;
  
  updateBonusUI(); 
  updateLadderUI(); 
  updateSpinAvailability();
  startSpin();
};

el('confirmCancel').onclick = ()=> el('confirmOverlay').classList.remove('show');
el('btnBuyBonus').onclick = buyBonus;

el('bonusEndOk').onclick = ()=> el('bonusEndOverlay').classList.remove('show');

/* ===================== SPIN / TURBO / AUTOPLAY BUTTONS ===================== */
el('btnSpin').onclick = startSpin;

el('btnTurbo').onclick = ()=>{
  state.turbo = !state.turbo;
  el('btnTurbo').classList.toggle('active', state.turbo);
  flash(state.turbo ? 'Turbo spin on' : 'Turbo spin off');
};

function renderAutoBtn(){
  el('btnAuto').classList.toggle('active', state.autoplay);
}
el('btnAuto').onclick = ()=>{
  state.autoplay = !state.autoplay;
  renderAutoBtn();
  if(state.autoplay && !state.spinning && !state.bonusMode) startSpin();
  flash(state.autoplay ? 'Autoplay started' : 'Autoplay stopped');
};

/* ===================== BET SELECTOR ===================== */
const betPopover = el('betPopover');
const GRID_BETS = [
  1000, 50, 5,
  500,  40, 3,
  200,  30, 2,
  100,  20, 1,
  80,   10, 0.5
];

GRID_BETS.forEach(v=>{
  const b = document.createElement('button');
  b.textContent = v >= 80 ? v.toLocaleString() : v;
  b.onclick = ()=>{
    state.bet = v; 
    updateBetUI();
    betPopover.classList.remove('show');
    [...betPopover.children].forEach(c=>{
      const val = parseFloat(c.textContent.replace(/,/g, ''));
      c.classList.toggle('sel', val === v);
    });
    updateSpinAvailability();
  };
  if(v === state.bet) b.classList.add('sel');
  betPopover.appendChild(b);
});
el('betPill').onclick = ()=>{
  if(state.spinning || state.bonusMode) return;
  betPopover.classList.toggle('show');
};
document.addEventListener('click', e=>{
  if(!betPopover.contains(e.target) && !e.target.closest('#betPill')) betPopover.classList.remove('show');
});

/* ===================== SETTINGS / PAYTABLE ===================== */
const paytableList = el('paytableList');
SYMBOLS.filter(s=>s.pay).forEach(s=>{
  const row = document.createElement('div');
  row.innerHTML = `<span><img src="${s.imgSrc}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;border-radius:3px;"> ${s.id}</span><span>3: ${s.pay[3]}x &nbsp; 4: ${s.pay[4]}x &nbsp; 5: ${s.pay[5]}x</span>`;
  paytableList.appendChild(row);
});
{
  const row = document.createElement('div');
  row.innerHTML = `<span><img src="${SYMBOLS.find(s=>s.isWild).imgSrc}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;border-radius:3px;"> WILD</span><span>substitutes all · +1 multiplier step</span>`;
  paytableList.appendChild(row);
}
{
  const row = document.createElement('div');
  row.innerHTML = `<span><img src="${SYMBOLS.find(s=>s.isScatter).imgSrc}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;border-radius:3px;"> SCATTER</span><span>3+ Scatters anywhere triggers 10 Free Spins!</span>`;
  paytableList.appendChild(row);
}
/* ===================== SETTINGS & MENU ACTIONS ===================== */
const settingsMenu = el('settingsMenu');

el('btnSettings').onclick = (e)=>{
  e.stopPropagation();
  if(state.spinning || state.bonusMode) return;
  settingsMenu.classList.toggle('show');
};

document.addEventListener('click', (e)=>{
  if(!settingsMenu.contains(e.target) && !e.target.closest('#btnSettings')){
    settingsMenu.classList.remove('show');
  }
});

// Sound Toggle
el('menuSound').onclick = ()=>{
  soundEnabled = !soundEnabled;
  el('menuSound').classList.toggle('active', soundEnabled);
  const icon = el('menuSound').querySelector('i');
  if(soundEnabled) {
    icon.className = 'fa-solid fa-volume-high';
    flash('Sound Enabled');
  } else {
    icon.className = 'fa-solid fa-volume-xmark';
    flash('Sound Muted');
  }
};

// Information modal trigger
el('menuInfo').onclick = ()=>{
  settingsMenu.classList.remove('show');
  el('settingsOverlay').classList.add('show');
};
el('settingsClose').onclick = ()=> el('settingsOverlay').classList.remove('show');

// AutoSpin modal trigger
el('menuAutoSpin').onclick = ()=>{
  settingsMenu.classList.remove('show');
  
  // Set dynamic balance limits based on current balance
  const currentBal = Math.round(state.balance);
  el('autoBalLessVal').textContent = Math.round(currentBal * 0.5);
  el('autoBalMoreVal').textContent = Math.round(currentBal * 1.5);
  
  el('autoSpinOverlay').classList.add('show');
};

/* ===================== AUTOSPIN CONFIG MODAL LOGIC ===================== */
function ensureChecked(id) {
  el(id).checked = true;
}

// Total Spins decrement/increment
el('autoSpinsMinus').onclick = () => {
  ensureChecked('chkTotalSpins');
  let val = parseInt(el('autoSpinsVal').textContent);
  if(val > 10) {
    val -= 10;
    el('autoSpinsVal').textContent = val;
    updatePresetActive(val);
  }
};
el('autoSpinsPlus').onclick = () => {
  ensureChecked('chkTotalSpins');
  let val = parseInt(el('autoSpinsVal').textContent);
  if(val < 1000) {
    val += 10;
    el('autoSpinsVal').textContent = val;
    updatePresetActive(val);
  }
};

// Spin Preset buttons
const presetBtns = document.querySelectorAll('.preset-spin-btn');
presetBtns.forEach(btn => {
  btn.onclick = () => {
    ensureChecked('chkTotalSpins');
    const val = parseInt(btn.dataset.val);
    el('autoSpinsVal').textContent = val;
    presetBtns.forEach(b => b.classList.toggle('active', b === btn));
  };
});
function updatePresetActive(val) {
  presetBtns.forEach(b => b.classList.toggle('active', parseInt(b.dataset.val) === val));
}

// Win Exceeds decrement/increment
el('autoWinMinus').onclick = () => {
  ensureChecked('chkWinExceeds');
  let val = parseInt(el('autoWinVal').textContent);
  if(val > 10) {
    val -= 10;
    el('autoWinVal').textContent = val + 'X';
  }
};
el('autoWinPlus').onclick = () => {
  ensureChecked('chkWinExceeds');
  let val = parseInt(el('autoWinVal').textContent);
  if(val < 1000) {
    val += 10;
    el('autoWinVal').textContent = val + 'X';
  }
};

// Balance Less decrement/increment
el('autoBalLessMinus').onclick = () => {
  ensureChecked('chkBalanceLess');
  let val = parseInt(el('autoBalLessVal').textContent);
  if(val > 0) {
    val = Math.max(0, val - 100);
    el('autoBalLessVal').textContent = val;
  }
};
el('autoBalLessPlus').onclick = () => {
  ensureChecked('chkBalanceLess');
  let val = parseInt(el('autoBalLessVal').textContent);
  val += 100;
  el('autoBalLessVal').textContent = val;
};

// Balance More decrement/increment
el('autoBalMoreMinus').onclick = () => {
  ensureChecked('chkBalanceMore');
  let val = parseInt(el('autoBalMoreVal').textContent);
  if(val > 0) {
    val = Math.max(0, val - 100);
    el('autoBalMoreVal').textContent = val;
  }
};
el('autoBalMorePlus').onclick = () => {
  ensureChecked('chkBalanceMore');
  let val = parseInt(el('autoBalMoreVal').textContent);
  val += 100;
  el('autoBalMoreVal').textContent = val;
};

// Cancel & Start Action clicks
el('autoCancelBtn').onclick = () => {
  el('autoSpinOverlay').classList.remove('show');
};

el('autoStartBtn').onclick = () => {
  el('autoSpinOverlay').classList.remove('show');
  
  autoSpinConfig.active = true;
  autoSpinConfig.useTotalSpins = el('chkTotalSpins').checked;
  autoSpinConfig.totalSpins = parseInt(el('autoSpinsVal').textContent);
  autoSpinConfig.winExceeds = el('chkWinExceeds').checked ? parseInt(el('autoWinVal').textContent) : null;
  autoSpinConfig.balLess = el('chkBalanceLess').checked ? parseFloat(el('autoBalLessVal').textContent) : null;
  autoSpinConfig.balMore = el('chkBalanceMore').checked ? parseFloat(el('autoBalMoreVal').textContent) : null;
  autoSpinConfig.stopOnFree = el('chkFreeGameStop').checked;
  
  state.autoplay = true;
  renderAutoBtn();
  flash('Autoplay Configured & Started');
  
  if(!state.spinning && !state.bonusMode) {
    startSpin();
  }
};

/* ===================== TOP CHROME ACTIONS ===================== */
el('btnFullscreen').onclick = ()=>{
  const app = el('app');
  if(!document.fullscreenElement) app.requestFullscreen?.();
  else document.exitFullscreen?.();
};

el('btnReset').onclick = ()=>{
  if (isDemoMode) {
    state.balance = 2000; state.ladderIndex=0; state.bonusMode=false;
    state.bonusLadder=0; state.bonusTotalWin=0; state.freeSpinsLeft=0;
    state.autoplay=false; renderAutoBtn();
    updateBalanceUI(); updateLadderUI(); updateBonusUI(); updateSpinAvailability();
    flash('Demo balance reset.');
  } else {
    flash('Cannot reset real balance.');
  }
};

el('btnClose').onclick = () => {
  window.location.href = "{{ route('dashboard') }}";
};
el('reopenBtn').onclick = () => {
  el('closeOverlay').classList.remove('show');
};

let favOn = false;
el('railFav').onclick = ()=>{
  favOn = !favOn;
  el('railFav').classList.toggle('active', favOn);
};
document.querySelectorAll('.rail button:not(#railFav)').forEach(b=>{
  b.onclick = ()=> flash('Coming soon');
});

/* ===================== DEMO SWITCH TOGGLE ===================== */
const demoToggleBtn = el('demoToggleBtn');
const demoSwitch = el('demoSwitch');
const demoLabel = el('demoLabel');

function setMode(demo) {
  if (state.spinning || state.bonusMode) return;
  isDemoMode = demo;
  if (isDemoMode) {
    demoSwitch.classList.add('active');
    demoLabel.textContent = "DEMO PLAY (virtual credits)";
    state.balance = demoBalance;
  } else {
    if (realBalance < state.bet) {
      flash("Real balance too low! Deposit to play.");
      isDemoMode = true;
      demoSwitch.classList.add('active');
      demoLabel.textContent = "DEMO PLAY (virtual credits)";
      state.balance = demoBalance;
      return;
    }
    demoSwitch.classList.remove('active');
    demoLabel.textContent = "REAL PLAY (real money)";
    state.balance = realBalance;
  }
  updateBalanceUI();
  updateSpinAvailability();
}

demoToggleBtn.onclick = () => {
  setMode(!isDemoMode);
};

/* ===================== INITIALIZE ===================== */
setMode(isDemoMode);
updateBetUI(); updateWinUI(); updateLadderUI(); updateBonusUI();

// Prevent drag-to-download on canvas
canvas.addEventListener('dragstart', e => e.preventDefault());

})();
</script>
</body>
</html>
