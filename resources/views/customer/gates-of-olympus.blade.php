<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Olympus Gold™ — 1xBet Casino Slot Game</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --navy-1:#0c1530;
    --navy-2:#15224a;
    --navy-3:#1c2c5a;
    --gold:#f5c542;
    --gold-deep:#c8901a;
    --purple:#7a2bb0;
    --purple-light:#9b4fd8;
    --magenta:#c2298f;
    --cyan:#1aa9c9;
    --green:#1f8a44;
    --red:#b81f2e;
    --sky-top:#5b2a86;
    --sky-bottom:#e08aa8;
    --text-light:#eef1f8;
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  html,body{
    margin:0;
    padding:0;
    width:100%;
    height:100%;
    min-height:100vh;
    background:#070b18;
    color:var(--text-light);
    font-family:'Inter',sans-serif;
    display:flex;
    flex-direction:column;
    overflow-x:hidden;
  }
  .display-font{font-family:'Cinzel',serif;}

  /* ---------- shell ---------- */
  .game-shell{
    width:100%;
    max-width:100%;
    margin:0;
    border-radius:0;
    overflow:hidden;
    box-shadow:none;
    border:none;
    flex-grow:1;
    display:flex;
    flex-direction:column;
    position:relative;
  }

  /* ---------- top navbar ---------- */
  .top-navbar{
    background:var(--navy-1);
    font-size:.8rem;
    color:#9fb0d8;
    border-bottom:1px solid #1d2950;
    flex-shrink:0;
  }
  .top-navbar strong{color:var(--text-light);}
  .top-navbar input[type="search"]{
    background:#0c1530;
    border:1px solid #2a3a6e;
    color:var(--text-light);
    max-width:220px;
  }

  /* ---------- title bar ---------- */
  .title-bar{
    background:var(--navy-2);
    border-bottom:1px solid #1d2950;
    flex-shrink:0;
  }
  .title-bar .game-icon{
    width:34px;height:34px;border-radius:6px;
    background:linear-gradient(145deg,var(--gold),var(--gold-deep));
    display:flex;align-items:center;justify-content:center;
    font-size:1.1rem;
    color:#0c1530;
    font-weight:900;
  }

  .icon-btn{
    width:32px;height:32px;border-radius:6px;
    background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);
    display:flex;align-items:center;justify-content:center;
    font-size:.85rem;
    transition:.15s;
    cursor:pointer;
  }
  .icon-btn:hover{background:#2a3a6e; transform:scale(1.05);}

  /* ---------- sidebar ---------- */
  .sidebar{
    background:var(--navy-1);
    width:56px;
    border-right:1px solid #1d2950;
    flex-shrink:0;
    z-index:20;
  }
  .sidebar-icon{
    width:40px;height:40px;border-radius:8px;
    background:transparent;border:1px solid transparent;
    color:#7e8fc0;
    font-size:1.1rem;
    display:flex;align-items:center;justify-content:center;
    transition:.2s;
    cursor:pointer;
  }
  .sidebar-icon:hover{background:#1c2c5a;color:var(--text-light);border-color:#2a3a6e;transform:scale(1.08);}
  .sidebar-icon.active{
    background:linear-gradient(145deg,var(--purple-light),var(--purple));
    color:#fff;
    box-shadow:0 0 12px rgba(155,79,216,0.6);
  }
  .sidebar-icon.fav-active{
    color:#ef4444 !important;
    text-shadow:0 0 10px rgba(239,68,68,0.8);
  }
  .sidebar-icon.turbo-active{
    background:linear-gradient(135deg, #f59e0b, #d97706) !important;
    color:#000 !important;
    box-shadow:0 0 12px rgba(245,158,11,0.8) !important;
    border-color:#f59e0b !important;
  }

  /* ---------- stage ---------- */
  .game-stage{
    position:relative;
    background:url("{{ asset('assets/image/gates_bg.png') }}") center center / cover no-repeat;
    flex-grow:1;
    min-height:540px;
    overflow:hidden;
    padding:8px 16px 70px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }
  .floor-glow{
    position:absolute;bottom:0;left:0;right:0;height:90px;
    background:linear-gradient(180deg,rgba(245,197,66,0) 0%, rgba(190,140,40,.35) 100%);
    pointer-events:none;
  }

  .logo-banner{
    position:relative;z-index:2;
    font-size:1.35rem;
    letter-spacing:.06em;
    text-align:center;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 45%, var(--gold-deep) 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    text-shadow:none;
    filter:drop-shadow(0 4px 8px rgba(0,0,0,.8));
    margin-bottom:4px;
    font-weight:900;
  }
  .logo-banner span{display:inline-block;font-size:1.15rem;letter-spacing:.12em;margin-left:4px;}

  /* ---------- slot frame ---------- */
  .slot-frame{
    position:relative;z-index:2;
    width:min(560px, 92vw);
    background:linear-gradient(160deg,#241338,#150a22);
    border:4px solid #ff9100;
    border-radius:10px;
    box-shadow:0 0 0 2px #1c0f2c inset, 
               0 8px 20px rgba(0,0,0,.45), 
               0 0 14px #ff3d00, 
               0 0 28px #ff9100, 
               0 0 42px #ffea00;
    padding:8px;
    animation: frameFlame 2s ease-in-out infinite alternate;
  }
  @keyframes frameFlame {
    0% {
      border-color: #ff3d00;
      box-shadow: 0 0 0 2px #1c0f2c inset, 0 14px 30px rgba(0,0,0,.45), 0 0 15px #ff3d00, 0 0 30px #ff9100, 0 0 45px #ffea00;
    }
    50% {
      border-color: #ff9100;
      box-shadow: 0 0 0 2px #1c0f2c inset, 0 14px 30px rgba(0,0,0,.45), 0 0 25px #ff3d00, 0 0 50px #ff9100, 0 0 75px #ffea00;
    }
    100% {
      border-color: #ffea00;
      box-shadow: 0 0 0 2px #1c0f2c inset, 0 14px 30px rgba(0,0,0,.45), 0 0 20px #ff3d00, 0 0 40px #ffea00, 0 0 60px #ff9100;
    }
  }

  .reels-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    grid-template-rows:repeat(5,1fr);
    gap:3px;
    background: linear-gradient(135deg, #ff3d00, #ff9100, #ffea00, #ff3d00);
    background-size: 400% 400%;
    animation: gridFlame 3s linear infinite;
    padding: 4px;
    border-radius: 6px;
  }
  @keyframes gridFlame {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .reel-cell{
    aspect-ratio:1;
    background:#150a22;
    border-radius:6px;
    display:flex;align-items:center;justify-content:center;
    position:relative;
    overflow:hidden;
  }
  .reel-col-tumbling .reel-cell::after{
    content:'';
    position:absolute;inset:0;
    background:linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.65) 45%, rgba(255,255,255,0) 100%);
    animation:tumbleStreak .35s linear infinite;
  }
  @keyframes tumbleStreak{
    0%{transform:translateY(-100%);}
    100%{transform:translateY(100%);}
  }

  .symbol{width:100%;height:100%;display:flex;align-items:center;justify-content:center;filter:drop-shadow(0 3px 4px rgba(0,0,0,.6));}
  .symbol img{width:100%;height:100%;object-fit:fill;display:block;}

  .cell-win {
    animation: fireBackground 0.75s ease-in-out infinite;
    border: 2px solid #ff4500 !important;
    z-index: 10;
  }
  @keyframes fireBackground {
    0% {
      background: radial-gradient(circle at bottom, rgba(255, 69, 0, 0.65) 0%, rgba(255, 140, 0, 0.25) 50%, transparent 100%);
      box-shadow: 0 0 12px rgba(255, 69, 0, 0.6), inset 0 0 16px rgba(255, 140, 0, 0.45);
    }
    50% {
      background: radial-gradient(circle at bottom, rgba(255, 69, 0, 0.85) 10%, rgba(255, 215, 0, 0.45) 60%, transparent 100%);
      box-shadow: 0 0 24px rgba(255, 140, 0, 0.95), inset 0 0 28px rgba(255, 69, 0, 0.65);
    }
    100% {
      background: radial-gradient(circle at bottom, rgba(255, 69, 0, 0.65) 0%, rgba(255, 140, 0, 0.25) 50%, transparent 100%);
      box-shadow: 0 0 12px rgba(255, 69, 0, 0.6), inset 0 0 16px rgba(255, 140, 0, 0.45);
    }
  }

  .flames-container {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 999;
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
  }
  .flame {
    width: 14px;
    height: 14px;
    background: #ff4500;
    border-radius: 50% 50% 0 50%;
    transform: rotate(-45deg);
    filter: blur(1.2px);
    animation: floatFlame 0.65s infinite ease-in-out;
    box-shadow: 0 0 8px #ff8c00, 0 0 16px #ffd700;
  }
  @keyframes floatFlame {
    0% { transform: translateY(12px) scale(0.65) rotate(-45deg); opacity: 0.95; }
    50% { opacity: 0.85; }
    100% { transform: translateY(-85px) scale(0) rotate(-45deg); opacity: 0; }
  }

  .multi-badge-wrap{
    width:100%;height:100%;
    position:relative;
    display:flex;align-items:center;justify-content:center;
  }
  .multi-img{
    width:100%;height:100%;object-fit:fill;
    filter: drop-shadow(0 0 8px rgba(255,214,107,0.5));
  }
  .multi-val-text{
    position:absolute;
    color:#fff;
    font-weight:900;
    font-size:1.15rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.85), 0 0 5px #000;
    font-family:'Cinzel',serif;
    letter-spacing:0.5px;
  }

  .scatter-badge{
    width:100%;height:100%;
    position:relative;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
  }
  .scatter-badge img{
    width:100%;height:100%;object-fit:fill;
    filter: drop-shadow(0 0 6px rgba(245,197,66,.6));
  }

  .symbol-pop{animation:popIn .35s ease;}
  @keyframes popIn{
    0%{transform:scale(.4);opacity:0;}
    70%{transform:scale(1.12);}
    100%{transform:scale(1);opacity:1;}
  }
  .symbol-win{animation:winPulse 1s ease infinite;}
  @keyframes winPulse{
    0%,100%{filter:drop-shadow(0 0 2px rgba(245,197,66,.2));}
    50%{filter:drop-shadow(0 0 14px rgba(245,197,66,.9));}
  }

  /* Tumble / Falling Animation for symbols */
  @keyframes symbolFallDown {
    0% { transform: translateY(-200%) scaleY(1.3); opacity: 0; }
    60% { transform: translateY(15%) scaleY(0.9); opacity: 1; }
    85% { transform: translateY(-8%) scaleY(1.05); }
    100% { transform: translateY(0) scaleY(1); opacity: 1; }
  }
  .symbol-falling {
    animation: symbolFallDown 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
  }

  /* ---------- main game layout container ---------- */
  .main-game-layout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    position: relative;
    z-index: 2;
  }

  /* ---------- left feature panel ---------- */
  .feature-panel{
    display:flex;
    flex-direction:column;
    gap:10px;
    padding:8px 0;
  }
  .feat-card{
    position:relative;
    border-radius:12px;
    text-align:center;
    width:125px;
    cursor:pointer;
    transition:transform .2s, box-shadow .2s;
    box-shadow:0 6px 20px rgba(0,0,0,.65);
    box-sizing:border-box;
  }
  .feat-card:hover{transform:scale(1.04);box-shadow:0 8px 24px rgba(255,204,0,.25);}
  
  .feat-card::before {
    content: '';
    position: absolute;
    inset: -2px;
    border: 3px solid transparent;
    border-image: linear-gradient(135deg, #ffe893, #c59727 40%, #5d420c 70%, #ffe893 100%) 3;
    border-radius: 12px;
    pointer-events: none;
    z-index: 2;
  }

  /* Buy Free Spins Styling */
  .buy-spins-panel {
    background: linear-gradient(180deg, #16243b 0%, #070b13 100%);
    padding: 12px 8px;
    border-radius: 10px;
    border: 1px solid #111;
  }
  .buy-spins-panel .feat-title {
    font-size: .82rem;
    letter-spacing: .06em;
    color: #16b7e6;
    font-weight: 900;
    text-shadow: 0 0 6px rgba(22,183,230,.5);
    text-transform: uppercase;
  }
  .buy-spins-panel .feat-label {
    font-size: .82rem;
    font-weight: 900;
    color: #16b7e6;
    text-shadow: 0 0 6px rgba(22,183,230,.5);
    line-height: 1.2;
    margin-bottom: 4px;
    text-transform: uppercase;
  }
  .buy-spins-panel .feat-price {
    font-size: 1.25rem;
    font-weight: 900;
    font-family: 'Cinzel', serif;
    background: linear-gradient(180deg, #fff3c8, var(--gold) 45%, var(--gold-deep) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,.9));
  }

  /* Double Chance Parchment Styling */
  .double-chance-panel {
    background: linear-gradient(180deg, #fcedc5 0%, #d1b874 100%);
    padding: 10px 6px;
    border-radius: 10px;
    border: 1px solid #3d2a07;
    box-shadow: inset 0 0 12px rgba(93, 66, 12, 0.4), 0 6px 20px rgba(0,0,0,.65);
  }
  .double-chance-panel .feat-label {
    font-size: .82rem;
    font-weight: 900;
    color: #071f3a;
    line-height: 1.1;
  }
  .double-chance-panel .feat-label span {
    font-size: 1rem;
    display: block;
    color: #c08000;
    text-shadow: 0 1px 1px rgba(255,255,255,0.7);
    margin-top: 2px;
  }
  .double-chance-panel .feat-sub {
    font-size: .62rem;
    color: #0d2f5a;
    font-weight: 800;
    line-height: 1.15;
    margin: 4px 0;
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
  }

  .double-chance-toggle{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    margin-top:2px;
    background: rgba(0,0,0,0.15);
    padding: 3px 6px;
    border-radius: 6px;
  }
  .dc-switch{
    width:36px;height:18px;
    background:#7a1515;
    border-radius:4px;
    position:relative;
    cursor:pointer;
    transition:.3s;
    border:1px solid #000;
    outline:none;
    display: flex;
    align-items: center;
  }
  .dc-switch.on{background:#1f8a44;}
  .dc-switch::after{
    content:'➔';
    position:absolute;
    width:16px;height:16px;
    background:linear-gradient(180deg, #fff, #ccc);
    border-radius:3px;
    top:0;left:0;
    font-size: 10px;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    transition:.3s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.5);
  }
  .dc-switch.on::after{left:18px;}
  .dc-label{font-size:.65rem;font-weight:900;color:#0d2f5a;}

  /* Decorative Empty Gold Frame */
  .decorative-empty-panel {
    background: #050505;
    height: 100px;
    border-radius: 10px;
    border: 1px solid #111;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.95);
  }

  /* ---------- tagline / badges ---------- */
  .bottom-tagline{
    position:relative;z-index:2;
    margin-top:4px;
    font-family:'Cinzel',serif;
    letter-spacing:.05em;
    font-size:.78rem;
    color:var(--gold);
    text-shadow:0 2px 0 rgba(0,0,0,.4);
    font-weight:700;
  }
  .volatility-badge{
    position:relative;
    z-index:3;
    background:#0c1530;border:1px solid var(--gold-deep);
    border-radius:20px;padding:2px 10px;font-size:.62rem;letter-spacing:.05em;
    display:inline-flex;align-items:center;gap:4px;
    margin-top:4px;
  }
  .volatility-badge .bolts{color:var(--gold);}

  /* ---------- bottom controls bar ---------- */
  .bottom-controls{
    position:absolute;
    bottom:0;left:0;right:0;
    z-index:10;
    background:rgba(10,15,30,.95);
    border-top:1px solid #1d2950;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:6px 16px;
    height:62px;
  }
  .bc-left{
    display:flex;
    align-items:center;
    gap:10px;
  }
  .bc-icon-btn{
    width:34px;height:34px;border-radius:50%;
    background:#1c2c5a;
    border:1px solid #2a3a6e;
    color:#fff;
    font-size:.9rem;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    transition:.2s;
  }
  .bc-icon-btn:hover{background:#2a3a6e; transform:scale(1.05);}
  .bc-info{
    display:flex;
    flex-direction:column;
    gap:1px;
  }
  .bc-info-row{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:.75rem;
  }
  .bc-info-key{
    color:#7e8fc0;
    font-weight:700;
    letter-spacing:.05em;
    text-transform:uppercase;
    min-width:46px;
  }
  .bc-info-val{
    color:var(--gold);
    font-weight:800;
    font-family:'JetBrains Mono', monospace;
  }
  .bc-center{
    font-size:.92rem;
    font-weight:700;
    color:#fff;
    letter-spacing:.06em;
    text-align:center;
    flex:1;
    font-family:'Cinzel', serif;
  }
  .bc-right{
    display:flex;
    align-items:center;
    gap:8px;
  }
  .bc-bet-btn{
    width:38px;height:38px;border-radius:50%;
    background:#1c2c5a;
    border:2px solid #2a3a6e;
    color:#fff;
    font-size:1.1rem;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    font-weight:700;
    transition:.2s;
  }
  .bc-bet-btn:hover{background:#2a3a6e;border-color:var(--gold); transform:scale(1.05);}
  .bc-spin-btn{
    width:52px;height:52px;border-radius:50%;
    background:radial-gradient(circle at 35% 30%, #2a3550, #0c1530 75%);
    border:3px solid var(--gold);
    color:var(--gold);
    font-size:1.5rem;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    box-shadow:0 0 0 4px rgba(0,0,0,.25), 0 0 14px rgba(245,197,66,.4);
    transition:.2s;
  }
  .bc-spin-btn:hover{transform:scale(1.08);box-shadow:0 0 0 4px rgba(0,0,0,.25), 0 0 22px rgba(245,197,66,.7);}
  .bc-spin-btn:disabled{opacity:.5;cursor:not-allowed;}
  .bc-spin-btn .spin-icon{display:inline-block;transition:transform .6s ease;}
  .bc-spin-btn.spinning .spin-icon{animation:spinRound .7s linear infinite;}
  @keyframes spinRound{to{transform:rotate(360deg);}}

  .bc-autoplay-btn{
    background:#1c2c5a;
    border:1px solid #2a3a6e;
    border-radius:6px;
    color:#fff;
    font-size:.65rem;
    font-weight:700;
    letter-spacing:.06em;
    padding:4px 8px;
    cursor:pointer;
    display:flex;flex-direction:column;align-items:center;gap:1px;
    transition:.2s;
  }
  .bc-autoplay-btn:hover{background:#2a3a6e;border-color:var(--gold);}
  .bc-autoplay-btn .ap-icon{font-size:.9rem;}

  .win-toast{
    position:absolute;top:14%;left:50%;transform:translate(-50%,-10px);
    z-index:100;
    background:linear-gradient(160deg,#fff3c8,var(--gold));
    color:#3a2a06;font-weight:800;
    padding:8px 18px;border-radius:24px;
    font-size:1rem;letter-spacing:.03em;
    opacity:0;
    transition:opacity .25s, transform .25s;
    box-shadow:0 6px 18px rgba(0,0,0,.35);
    pointer-events:none;
    white-space:nowrap;
  }
  .win-toast.show{opacity:1;transform:translate(-50%,0);}

  /* ---------- bottom bar ---------- */
  .bottom-bar{
    background:var(--navy-1);
    font-size:.78rem;
    color:#9fb0d8;
    flex-shrink:0;
  }
  .bottom-bar input[type="search"]{
    background:#0c1530;border:1px solid #2a3a6e;color:var(--text-light);
  }

  /* ==========================================
     MODALS: Paytable, Switcher, Overlays
     ========================================== */
  .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(5, 8, 20, 0.85);
    backdrop-filter:blur(8px);
    z-index:9999;
    display:flex;
    align-items:center;
    justify-content:center;
    opacity:0;
    visibility:hidden;
    transition:opacity .25s ease, visibility .25s ease;
    padding:16px;
  }
  .modal-overlay.show{
    opacity:1;
    visibility:visible;
  }
  .custom-game-modal{
    width:min(580px, 96vw);
    max-height:90vh;
    overflow-y:auto;
    background:linear-gradient(160deg, #141022 0%, #0c0816 100%);
    border:2px solid #f5c542;
    border-radius:14px;
    box-shadow:0 15px 50px rgba(0,0,0,0.9), 0 0 30px rgba(245, 197, 66, 0.25);
    color:#fff;
    display:flex;
    flex-direction:column;
  }
  .custom-modal-header{
    padding:14px 18px;
    border-bottom:1px solid rgba(245,197,66,0.2);
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:rgba(245,197,66,0.05);
  }
  .custom-modal-title{
    font-size:1.15rem;
    font-weight:800;
    color:#f5c542;
    margin:0;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .custom-modal-close{
    background:transparent;
    border:none;
    color:#94a3b8;
    font-size:1.4rem;
    cursor:pointer;
    line-height:1;
    transition:.15s;
  }
  .custom-modal-close:hover{color:#fff; transform:scale(1.1);}
  .custom-modal-body{
    padding:16px 18px;
  }

  .paytable-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(150px, 1fr));
    gap:10px;
    margin-top:10px;
  }
  .paytable-card{
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:8px;
    padding:8px;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .paytable-card img{
    width:42px;
    height:42px;
    object-fit:contain;
  }
  .paytable-card-info{
    font-size:.7rem;
    line-height:1.25;
  }
  .paytable-card-info strong{
    color:#fff;
    display:block;
    font-size:.75rem;
    margin-bottom:2px;
  }

  /* ==========================================
     MOBILE RESPONSIVENESS (100% Mobile Friendly)
     ========================================== */
  @media (max-width: 992px){
    .game-stage{
      padding: 6px 10px 65px;
      min-height: auto;
    }
  }

  @media (max-width: 768px){
    html, body{
      overflow-y: auto;
      height: 100%;
    }
    .game-shell{
      height: 100vh;
      overflow-y: auto;
    }
    .top-navbar{
      font-size: .7rem;
      padding: 4px 8px !important;
    }
    .top-navbar input[type="search"]{
      display: none;
    }
    .title-bar{
      padding: 4px 8px !important;
    }
    .title-bar .display-font{
      font-size: .85rem;
    }
    
    /* Sleek compact vertical sidebar */
    .sidebar{
      width: 44px;
      padding: 6px 0 !important;
      gap: 6px !important;
    }
    .sidebar-icon{
      width: 32px;
      height: 32px;
      font-size: .95rem;
      border-radius: 6px;
    }

    .game-stage{
      padding: 4px 6px 65px;
      min-height: auto;
      justify-content: flex-start;
    }
    .logo-banner{
      font-size: 1.1rem;
      margin-bottom: 2px;
    }
    .logo-banner span{
      font-size: .9rem;
    }

    /* Stack Feature Cards Above Slot Reels */
    .main-game-layout {
      flex-direction: column;
      gap: 6px;
      width: 100%;
      align-items: center;
    }
    .feature-panel{
      flex-direction: row;
      justify-content: center;
      gap: 8px;
      width: 100%;
      max-width: 400px;
      padding: 0;
    }
    .feat-card{
      width: calc(50% - 4px);
      max-width: 170px;
      padding: 6px 8px;
    }
    .buy-spins-panel{
      padding: 6px 8px;
    }
    .buy-spins-panel .feat-title, .buy-spins-panel .feat-label{
      font-size: .65rem;
      margin-bottom: 1px;
    }
    .buy-spins-panel .feat-price{
      font-size: 1rem;
    }
    .double-chance-panel{
      padding: 6px 8px;
    }
    .double-chance-panel .feat-label{
      font-size: .68rem;
    }
    .double-chance-panel .feat-label span{
      font-size: .88rem;
    }
    .double-chance-panel .feat-sub{
      font-size: .52rem;
      margin: 2px 0;
      line-height: 1.1;
    }
    .double-chance-toggle{
      padding: 2px 4px;
      margin-top: 2px;
    }
    .dc-switch{
      width: 30px;
      height: 16px;
    }
    .dc-switch::after{
      width: 14px;
      height: 14px;
      font-size: 8px;
    }
    .dc-switch.on::after{
      left: 14px;
    }
    .dc-label{
      font-size: .55rem;
    }
    .decorative-empty-panel{
      display: none !important;
    }

    /* Slot Frame full fit */
    .slot-frame{
      width: 100%;
      max-width: min(100%, 420px);
      padding: 4px;
      border-width: 2.5px;
    }
    .reels-grid{
      gap: 2px;
      padding: 2px;
    }

    .volatility-badge{
      display: none;
    }
    .bottom-tagline{
      font-size: .62rem;
      margin-top: 2px;
      text-align: center;
    }

    /* Bottom Controls Compact */
    .bottom-controls{
      height: auto;
      min-height: 52px;
      padding: 4px 8px;
      gap: 4px;
    }
    .bc-icon-btn{
      width: 30px;
      height: 30px;
      font-size: .8rem;
    }
    .bc-info-row{
      font-size: .68rem;
      gap: 4px;
    }
    .bc-info-key{
      min-width: 38px;
      font-size: .62rem;
    }
    .bc-center{
      font-size: .75rem;
      padding: 0 4px;
    }
    .bc-bet-btn{
      width: 32px;
      height: 32px;
      font-size: .95rem;
    }
    .bc-spin-btn{
      width: 44px;
      height: 44px;
      font-size: 1.25rem;
    }
    .bc-autoplay-btn{
      padding: 3px 5px;
      font-size: .55rem;
    }
    .bc-autoplay-btn .ap-icon{
      font-size: .75rem;
    }

    .bottom-bar{
      display: none !important;
    }
  }

  @media (max-width: 420px){
    .sidebar{
      width: 38px;
      gap: 4px !important;
    }
    .sidebar-icon{
      width: 28px;
      height: 28px;
      font-size: .85rem;
    }
    .bc-left .bc-icon-btn{
      display: none;
    }
    .title-bar .d-flex.gap-2 .icon-btn:not(#closeBtn):not(#favBtn){
      display: none;
    }
  }
</style>
</head>
<body>

@include('customer.header')

<div class="game-shell">

  <!-- top navbar -->
  <div class="top-navbar d-flex align-items-center justify-content-between px-3 py-2">
    <div>🏠 / Slots / Pragmatic / <strong>Olympus Gold™</strong></div>
    <input type="search" class="form-control form-control-sm" placeholder="Search games" onkeyup="if(event.key==='Enter') window.location.href='/dashboard?q='+encodeURIComponent(this.value)">
  </div>

  <!-- title bar -->
  <div class="title-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-2">
      <div class="game-icon display-font">Ω</div>
      <strong class="display-font">Olympus Gold™</strong>
      <div class="d-flex align-items-center ms-2 ms-md-3 gap-1 gap-md-2" style="background: rgba(0,0,0,0.4); padding: 3px 6px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08);">
        <button type="button" id="modeBtnDemo" onclick="window.switchGameMode(true)" class="btn btn-sm" style="font-weight: 800; font-size: 11px; padding: 4px 10px; border-radius: 6px; border: none; background: transparent; color: #cbd5e1; transition: all 0.2s;">
          <i class="fas fa-gamepad"></i> DEMO
        </button>
        <button type="button" id="modeBtnReal" onclick="window.switchGameMode(false)" class="btn btn-sm" style="font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); background: #22c55e; color: #fff; transition: all 0.2s; box-shadow: 0 0 10px rgba(34,197,94,0.4);">
          <i class="fas fa-coins"></i> REAL MONEY
        </button>
      </div>
    </div>
    <div class="d-flex gap-2">
      <button class="icon-btn" id="layoutBtn" title="Paytable & Rules" onclick="openPaytableModal()">🏆</button>
      <button class="icon-btn" id="fullscreenBtn" title="Fullscreen">⛶</button>
      <button class="icon-btn" id="reloadBtn" title="Reload game">↺</button>
      <button class="icon-btn" id="favBtn" title="Add to favorites" onclick="toggleFavoriteState()">★</button>
      <button class="icon-btn" id="closeBtn" title="Close" onclick="window.location.href='/dashboard'">✕</button>
    </div>
  </div>

  <div class="d-flex flex-grow-1" style="overflow: hidden;">

    <!-- Left Sidebar (100% Dynamic & Interactive matching 1xBet) -->
    <div class="sidebar d-flex flex-column align-items-center py-3 gap-2">
      <button class="sidebar-icon" id="sidebarFavBtn" title="Favorites (Click to toggle)" onclick="toggleFavoriteState()">♥</button>
      <button class="sidebar-icon" id="sidebarLobbyBtn" title="Casino Lobby" onclick="window.location.href='/dashboard'">▦</button>
      <button class="sidebar-icon" id="sidebarTurboBtn" title="Turbo Mode (Instant Spin)" onclick="toggleTurboMode()">⚡</button>
      <button class="sidebar-icon" id="sidebarPaytableBtn" title="Paytable & Multiplier Rules" onclick="openPaytableModal()">🏆</button>
      <button class="sidebar-icon active" id="sidebarGamesBtn" title="1xBet Casino Game Switcher" onclick="openGamesSwitcherModal()">🎮</button>
    </div>

    <!-- main game stage -->
    <div class="game-stage flex-grow-1">
      <div class="floor-glow"></div>

      <div class="logo-banner display-font">OLYMPUS <span>GOLD</span></div>

      <div class="main-game-layout">
        <!-- Left Feature Panel -->
        <div class="feature-panel">
          <!-- Buy Free Spins -->
          <div class="feat-card buy-spins-panel" id="buyFreeSpinsCard">
            <div class="feat-title">BUY</div>
            <div class="feat-label">FREE SPINS</div>
            <div class="feat-price" id="freeSpinsPrice">৳ 200.00</div>
          </div>
          <!-- Double Chance -->
          <div class="feat-card double-chance-panel">
            <div class="feat-label">BET <span id="dcBetVal">৳ 2.50</span></div>
            <div class="feat-sub">DOUBLE CHANCE<br>TO WIN FEATURE</div>
            <div class="double-chance-toggle">
              <button class="dc-switch" id="dcSwitch"></button>
              <span class="dc-label" id="dcLabel">OFF</span>
            </div>
          </div>
          <!-- Decorative Empty Gold Frame -->
          <div class="feat-card decorative-empty-panel"></div>
        </div>

        <!-- Slot Frame -->
        <div class="slot-frame">
          <div class="reels-grid" id="reelsGrid"></div>
        </div>
      </div>

      <div class="volatility-badge">VOLATILITY <span class="bolts">⚡⚡⚡⚡⚡</span></div>
      <div class="bottom-tagline">RANDOM MULTIPLIERS UP TO 500X</div>

      <div class="win-toast" id="winToast">+৳ 0.00 WIN</div>

      <!-- Bottom Controls Bar -->
      <div class="bottom-controls">
        <!-- Left: menu + info + credit/bet -->
        <div class="bc-left">
          <button class="bc-icon-btn" title="Paytable & Rules" id="menuBtn" onclick="openPaytableModal()">≡</button>
          <button class="bc-icon-btn" title="Game Info" id="infoBtn" onclick="openPaytableModal()">ⓘ</button>
          <div class="bc-info">
            <div class="bc-info-row">
              <span class="bc-info-key">CREDIT</span>
              <span class="bc-info-val" id="bcCredit">৳ 0.00</span>
            </div>
            <div class="bc-info-row">
              <span class="bc-info-key">BET</span>
              <span class="bc-info-val" id="bcBet">2.00</span>
            </div>
          </div>
        </div>
        <!-- Center: message -->
        <div class="bc-center" id="bcMessage">PLACE YOUR BETS!</div>
        <!-- Right: - spin + autoplay -->
        <div class="bc-right">
          <button class="bc-bet-btn" id="bcBetMinus">−</button>
          <button class="bc-spin-btn" id="bcSpinBtn" title="Spin"><span class="spin-icon">↻</span></button>
          <button class="bc-bet-btn" id="bcBetPlus">+</button>
          <button class="bc-autoplay-btn" id="bcAutoplay">
            <span class="ap-icon">↻↻</span>
            AUTOPLAY
          </button>
        </div>
      </div>

    </div>
  </div>

  <!-- bottom bar -->
  <div class="bottom-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex gap-3">
      <span style="cursor: pointer; font-weight:700;" onclick="openGamesSwitcherModal()">🕐 RECENT GAMES</span>
      <span style="cursor: pointer; font-weight:700;" onclick="toggleFavoriteState()">★ FAVORITES</span>
    </div>
    <input type="search" class="form-control form-control-sm" style="max-width:200px" placeholder="Search other games" onkeyup="if(event.key==='Enter') window.location.href='/dashboard?q='+encodeURIComponent(this.value)">
  </div>

</div>

<!-- ==================== PAYTABLE & RULES MODAL (1xBet Style) ==================== -->
<div class="modal-overlay" id="olympusPaytableModal">
  <div class="custom-game-modal">
    <div class="custom-modal-header">
      <h5 class="custom-modal-title display-font"><i class="fas fa-trophy text-warning"></i> Olympus Gold™ Paytable</h5>
      <button class="custom-modal-close" onclick="closePaytableModal()">&times;</button>
    </div>
    <div class="custom-modal-body">
      <div style="background: rgba(245,197,66,0.08); border-left: 3px solid #f5c542; padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 14px;">
        Symbols pay anywhere on the 6x5 grid! 8 or more matching symbols trigger a win and ignite the <strong>Tumble Feature</strong>.
      </div>

      <div style="font-size: 12px; font-weight: 800; color: #f5c542; text-transform: uppercase; margin-bottom: 8px;">Special Features & Multipliers</div>
      <div class="row g-2 mb-3">
        <div class="col-6">
          <div class="paytable-card" style="border-color: rgba(245,197,66,0.4);">
            <img src="{{ asset('assets/image/GatesofOlympus/10.png') }}" alt="Zeus Scatter">
            <div class="paytable-card-info">
              <strong style="color: #f5c542;">ZEUS SCATTER</strong>
              4+: 15 Free Spins<br>
              6x: 100X | 5x: 5X | 4x: 3X
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="paytable-card" style="border-color: rgba(155,79,216,0.4);">
            <img src="{{ asset('assets/image/GatesofOlympus/13.png') }}" alt="Multiplier Orbs">
            <div class="paytable-card-info">
              <strong style="color: #c084fc;">MULTIPLIER ORBS</strong>
              Random 2X - 500X<br>
              Multiplies tumble total
            </div>
          </div>
        </div>
      </div>

      <div style="font-size: 12px; font-weight: 800; color: #cbd5e1; text-transform: uppercase; margin-bottom: 8px;">High & Regular Symbols (Clusters 12+ | 10-11 | 8-9)</div>
      <div class="paytable-grid">
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/1.png') }}" alt="Crown">
          <div class="paytable-card-info">
            <strong style="color: #fbbf24;">Crown</strong>
            12+: 50X<br>10-11: 25X<br>8-9: 10X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/2.png') }}" alt="Hourglass">
          <div class="paytable-card-info">
            <strong style="color: #60a5fa;">Hourglass</strong>
            12+: 25X<br>10-11: 10X<br>8-9: 2.5X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/3.png') }}" alt="Ruby Ring">
          <div class="paytable-card-info">
            <strong style="color: #f43f5e;">Ruby Ring</strong>
            12+: 15X<br>10-11: 5X<br>8-9: 2X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/4.png') }}" alt="Chalice">
          <div class="paytable-card-info">
            <strong style="color: #34d399;">Chalice</strong>
            12+: 12X<br>10-11: 2X<br>8-9: 1.5X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/5.png') }}" alt="Red Gem">
          <div class="paytable-card-info">
            <strong style="color: #ef4444;">Red Gem</strong>
            12+: 10X<br>10-11: 1.5X<br>8-9: 1X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/6.png') }}" alt="Purple Gem">
          <div class="paytable-card-info">
            <strong style="color: #a855f7;">Purple Gem</strong>
            12+: 8X<br>10-11: 1.2X<br>8-9: 0.8X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/7.png') }}" alt="Yellow Gem">
          <div class="paytable-card-info">
            <strong style="color: #eab308;">Yellow Gem</strong>
            12+: 5X<br>10-11: 1X<br>8-9: 0.5X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/8.png') }}" alt="Green Gem">
          <div class="paytable-card-info">
            <strong style="color: #22c55e;">Green Gem</strong>
            12+: 4X<br>10-11: 0.9X<br>8-9: 0.4X
          </div>
        </div>
        <div class="paytable-card">
          <img src="{{ asset('assets/image/GatesofOlympus/9.png') }}" alt="Blue Gem">
          <div class="paytable-card-info">
            <strong style="color: #0ea5e9;">Blue Gem</strong>
            12+: 2X<br>10-11: 0.75X<br>8-9: 0.25X
          </div>
        </div>
      </div>

      <button type="button" class="btn w-100 mt-4 display-font" onclick="closePaytableModal()" style="background: linear-gradient(135deg, #f5c542, #c8901a); color: #000; font-weight: 800; padding: 10px; border-radius: 8px;">
        UNDERSTOOD
      </button>
    </div>
  </div>
</div>

<!-- ==================== 1xBET CASINO GAME SWITCHER MODAL ==================== -->
<div class="modal-overlay" id="olympusGamesSwitcherModal">
  <div class="custom-game-modal" style="width: min(520px, 96vw); border-color: #38bdf8;">
    <div class="custom-modal-header" style="background: rgba(56,189,248,0.08);">
      <h5 class="custom-modal-title" style="color: #38bdf8;"><i class="fas fa-gamepad"></i> 1xBet Casino Switcher</h5>
      <button class="custom-modal-close" onclick="closeGamesSwitcherModal()">&times;</button>
    </div>
    <div class="custom-modal-body">
      <p style="font-size: 13px; color: #94a3b8; margin-bottom: 14px;">Select any live casino slot or crash game to switch instantly:</p>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
        <a href="{{ route('gates-of-olympus') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-warning" style="text-decoration:none; background: rgba(245,197,66,0.1);">
          <i class="fas fa-bolt text-warning fa-lg"></i>
          <div><strong class="d-block text-warning" style="font-size:12px;">Olympus Gold™</strong><small class="text-white-50" style="font-size:10px;">Active Game</small></div>
        </a>
        <a href="{{ route('boxing-king') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-danger" style="text-decoration:none;">
          <i class="fas fa-crown text-danger fa-lg"></i>
          <div><strong class="d-block text-white" style="font-size:12px;">Boxing King™</strong><small class="text-muted" style="font-size:10px;">Ring Champion</small></div>
        </a>
        <a href="{{ route('western-vault') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-warning" style="text-decoration:none;">
          <i class="fas fa-hat-cowboy text-warning fa-lg"></i>
          <div><strong class="d-block text-white" style="font-size:12px;">Western Vault™</strong><small class="text-muted" style="font-size:10px;">High Payout</small></div>
        </a>
        <a href="{{ route('play') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-info" style="text-decoration:none;">
          <i class="fas fa-plane-departure text-info fa-lg"></i>
          <div><strong class="d-block text-white" style="font-size:12px;">Aviator Crash</strong><small class="text-muted" style="font-size:10px;">Multiplier</small></div>
        </a>
        <a href="{{ route('gems-mines') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-success" style="text-decoration:none;">
          <i class="fas fa-gem text-success fa-lg"></i>
          <div><strong class="d-block text-white" style="font-size:12px;">Gems & Mines</strong><small class="text-muted" style="font-size:10px;">Classic</small></div>
        </a>
        <a href="{{ route('big-bass-splash') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-secondary" style="text-decoration:none;">
          <i class="fas fa-fish text-primary fa-lg"></i>
          <div><strong class="d-block text-white" style="font-size:12px;">Big Bass Splash</strong><small class="text-muted" style="font-size:10px;">Free Spins</small></div>
        </a>
      </div>
      <button type="button" class="btn btn-secondary w-100 mt-3" onclick="closeGamesSwitcherModal()" style="font-weight: 700; font-size: 13px;">
        Close Switcher
      </button>
    </div>
  </div>
</div>

<!-- ==================== DEMO PLAY LIMIT / AUTH MODAL ==================== -->
<div class="modal fade" id="olympusDemoLimitModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(8px); background: rgba(5, 8, 20, 0.75);">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
    <div class="modal-content" style="background: linear-gradient(145deg, #101935, #0a0f24); border: 2px solid #f5c542; border-radius: 16px; box-shadow: 0 15px 40px rgba(0,0,0,0.8), 0 0 25px rgba(245, 197, 66, 0.3); color: #fff; overflow: hidden;">
      <div class="modal-header border-0 pb-0 pt-4 px-4 text-center d-flex flex-column align-items-center position-relative">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <div style="width: 64px; height: 64px; border-radius: 50%; background: radial-gradient(circle, #f5c542, #c8901a); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #000; box-shadow: 0 0 20px rgba(245, 197, 66, 0.6); margin-bottom: 12px;">
          ⚡
        </div>
        <h4 class="display-font text-warning mb-1" style="font-weight: 800; letter-spacing: 0.5px; font-size: 20px;">DEMO LIMIT REACHED</h4>
        <p style="color: #94a3b8; font-size: 13px; margin-bottom: 0;">Unlock the full power of Olympus Gold™</p>
      </div>
      <div class="modal-body px-4 py-3 text-center">
        <p style="font-size: 13.5px; color: #cbd5e1; line-height: 1.6;">
          Your free demo play session has finished. Create an account or sign in to experience unlimited real-money spins and withdraw cash prizes!
        </p>
        <div style="background: rgba(255,255,255,0.04); border: 1px dashed rgba(245,197,66,0.3); border-radius: 10px; padding: 12px; margin: 16px 0;">
          <div style="font-size: 11px; text-transform: uppercase; color: #f5c542; font-weight: 700; letter-spacing: 0.5px;">Member Benefits</div>
          <div style="font-size: 12.5px; color: #e2e8f0; margin-top: 4px;">⚡ Instant Withdrawals &nbsp;|&nbsp; 🎁 Welcome Bonus &nbsp;|&nbsp; 🏆 Real Winnings</div>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex flex-column gap-2">
        <a href="{{ route('login') }}" class="btn w-100" style="background: linear-gradient(135deg, #f5c542, #c8901a); color: #000; font-weight: 800; font-family: 'Cinzel', serif; padding: 12px; border-radius: 10px; box-shadow: 0 4px 15px rgba(245,197,66,0.4); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
          LOGIN TO PLAY
        </a>
        <a href="{{ route('register') }}" class="btn w-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(245,197,66,0.4); color: #f5c542; font-weight: 700; font-family: 'Inter', sans-serif; padding: 10px; border-radius: 10px; text-decoration: none; display: flex; align-items: center; justify-content: center;">
          CREATE NEW ACCOUNT
        </a>
        <button type="button" class="btn btn-link text-muted btn-sm" data-bs-dismiss="modal" style="font-size: 11.5px; text-decoration: none; margin-top: 2px;">
          Continue browsing
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ==================== INSUFFICIENT BALANCE MODAL ==================== -->
<div class="modal fade" id="olympusInsufficientBalanceModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(8px); background: rgba(5, 8, 20, 0.75);">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
    <div class="modal-content" style="background: linear-gradient(145deg, #181028, #0d0818); border: 2px solid #ef4444; border-radius: 16px; box-shadow: 0 15px 40px rgba(0,0,0,0.8), 0 0 25px rgba(239, 68, 68, 0.3); color: #fff;">
      <div class="modal-header border-0 pb-0 pt-4 px-4 text-center d-flex flex-column align-items-center position-relative">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(239, 68, 68, 0.15); border: 2px solid #ef4444; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); margin-bottom: 12px;">
          ✕
        </div>
        <h4 class="display-font text-danger mb-1" style="font-weight: 800; font-size: 19px;">INSUFFICIENT BALANCE</h4>
        <p style="color: #94a3b8; font-size: 12.5px; margin-bottom: 0;">Top up your wallet to continue playing</p>
      </div>
      <div class="modal-body px-4 py-3 text-center">
        <p style="font-size: 13px; color: #cbd5e1; line-height: 1.5;">
          Your current wallet balance is lower than the active bet amount. Please make a deposit to spin for real money.
        </p>
        <div style="background: rgba(0,0,0,0.3); border-radius: 10px; padding: 12px; display: flex; justify-content: space-around; margin: 14px 0;">
          <div>
            <div style="font-size: 10.5px; color: #94a3b8; text-transform: uppercase;">Your Balance</div>
            <div id="insufficient-current-bal" style="font-size: 15px; font-weight: 800; color: #f87171; font-family: 'JetBrains Mono', monospace;">0.00</div>
          </div>
          <div style="border-right: 1px solid rgba(255,255,255,0.1);"></div>
          <div>
            <div style="font-size: 10.5px; color: #94a3b8; text-transform: uppercase;">Required Bet</div>
            <div id="insufficient-required-bet" style="font-size: 15px; font-weight: 800; color: #facc15; font-family: 'JetBrains Mono', monospace;">0.00</div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex flex-column gap-2">
        <button type="button" onclick="closeInsufficientAndOpenDeposit()" class="btn w-100" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; font-weight: 800; font-family: 'Cinzel', serif; padding: 11px; border-radius: 10px; box-shadow: 0 4px 15px rgba(34,197,94,0.4); border:none; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <i class="fas fa-plus-circle"></i> DEPOSIT NOW
        </button>
        <button type="button" onclick="switchToDemoModeFromModal()" class="btn w-100" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); color: #e2e8f0; font-weight: 600; font-size: 13px; padding: 9px; border-radius: 10px;">
          Switch to Free Demo Mode
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const COLS = 6, ROWS = 5;
  const grid = document.getElementById('reelsGrid');
  const spinBtn = document.getElementById('bcSpinBtn');
  const winToast = document.getElementById('winToast');
  const balanceEl = document.getElementById('bcCredit');
  const betEl = document.getElementById('bcBet');

  // ==========================================
  // DYNAMIC SERVER STATE & CONFIGURATION
  // ==========================================
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const SERVER_CONFIG = @json($config ?? null);
  const AUTH_USER = @json($user ?? null);

  const userCurrency = (AUTH_USER && AUTH_USER.currency) ? AUTH_USER.currency : 'BDT';
  const currencySymbolMap = {
    'EUR': '€',
    'USD': '$',
    'BDT': '৳ ',
    'GBP': '£',
    'INR': '₹'
  };
  const currencySymbol = currencySymbolMap[userCurrency] || (userCurrency + ' ');

  let realBalance = AUTH_USER ? parseFloat(AUTH_USER.balance) : 0.00;
  let demoBalance = parseFloat("{{ $demoBalance ?? 10000.00 }}");
  let demoSpinsCount = parseInt("{{ $demoSpinsCount ?? 0 }}");
  let demoPlayLimit = SERVER_CONFIG ? parseInt(SERVER_CONFIG.demo_play_limit) : 1;

  // BY DEFAULT: REAL MONEY MODE for logged-in users, DEMO only for guests or when explicitly clicked
  let isDemoMode = !AUTH_USER;
  let balance = isDemoMode ? demoBalance : realBalance;

  let bet = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.default_bet) : 2.00;
  let minBet = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.min_bet) : 1.00;
  let maxBet = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.max_bet) : 5000.00;
  let buySpinsMultiplier = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.buy_free_spins_multiplier) : 100.0;
  let doubleChancePct = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.double_chance_ante_pct) : 25.0;

  let spinning = false;
  let turboActive = false;
  let doubleChanceActive = false;
  let buyFeaturePending = false;
  let autoplayActive = false;

  // Modals & Navigation Helpers
  window.openPaytableModal = function() {
    document.getElementById('olympusPaytableModal').classList.add('show');
  };
  window.closePaytableModal = function() {
    document.getElementById('olympusPaytableModal').classList.remove('show');
  };
  window.openGamesSwitcherModal = function() {
    document.getElementById('olympusGamesSwitcherModal').classList.add('show');
  };
  window.closeGamesSwitcherModal = function() {
    document.getElementById('olympusGamesSwitcherModal').classList.remove('show');
  };

  // Turbo Mode Handler
  window.toggleTurboMode = function() {
    turboActive = !turboActive;
    const turboBtn = document.getElementById('sidebarTurboBtn');
    if (turboBtn) {
      turboBtn.classList.toggle('turbo-active', turboActive);
    }
    showToast(turboActive ? '⚡ Turbo Mode: ACTIVATED (Fast Spins)' : 'Turbo Mode: NORMAL');
  };

  // Favorite State Persistence
  window.toggleFavoriteState = function() {
    const isFav = localStorage.getItem('fav_olympus_gold') === '1';
    const newFav = !isFav;
    if (newFav) {
      localStorage.setItem('fav_olympus_gold', '1');
      showToast('⭐ Olympus Gold™ added to Favorites!');
    } else {
      localStorage.removeItem('fav_olympus_gold');
      showToast('Removed from Favorites');
    }
    updateFavUI(newFav);
  };

  function updateFavUI(isFav) {
    const sideFav = document.getElementById('sidebarFavBtn');
    const topFav = document.getElementById('favBtn');
    if (sideFav) sideFav.classList.toggle('fav-active', isFav);
    if (topFav) {
      topFav.style.color = isFav ? '#f5c542' : '';
    }
  }

  // Initial favorite state
  updateFavUI(localStorage.getItem('fav_olympus_gold') === '1');

  function showToast(msg) {
    winToast.textContent = msg;
    winToast.classList.add('show');
    setTimeout(() => winToast.classList.remove('show'), 1600);
  }

  window.switchGameMode = function(demo) {
    if (spinning) return;
    if (!demo && !AUTH_USER) {
      openDemoLimitModal();
      return;
    }
    isDemoMode = demo;
    updateModeUI();
    showToast(isDemoMode ? 'Switched to Demo Play' : 'Switched to Real Money');
  };

  function syncHeaderBalance() {
    const headerBalance = document.querySelector('.header-balance-value');
    if (headerBalance) {
      headerBalance.textContent = currencySymbol + formatMoney(realBalance);
    }
  }

  function updateModeUI() {
    const btnDemo = document.getElementById('modeBtnDemo');
    const btnReal = document.getElementById('modeBtnReal');

    if (isDemoMode) {
      if (btnDemo) {
        btnDemo.style.background = '#f59e0b';
        btnDemo.style.color = '#000';
        btnDemo.style.boxShadow = '0 0 10px rgba(245,158,11,0.5)';
      }
      if (btnReal) {
        btnReal.style.background = 'transparent';
        btnReal.style.color = '#cbd5e1';
        btnReal.style.boxShadow = 'none';
      }
      balance = demoBalance;
      if (balanceEl) balanceEl.textContent = 'DEMO ' + formatMoney(balance);
    } else {
      if (btnReal) {
        btnReal.style.background = '#22c55e';
        btnReal.style.color = '#fff';
        btnReal.style.boxShadow = '0 0 10px rgba(34,197,94,0.5)';
      }
      if (btnDemo) {
        btnDemo.style.background = 'transparent';
        btnDemo.style.color = '#cbd5e1';
        btnDemo.style.boxShadow = 'none';
      }
      balance = realBalance;
      if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
    }
    updateDCUI();
    syncHeaderBalance();
  }

  // ---- Modals Helper Functions ----
  function openDemoLimitModal() {
    const modalEl = document.getElementById('olympusDemoLimitModal');
    if (modalEl) {
      const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
    }
  }

  function openInsufficientBalanceModal(currentBal, requiredAmount) {
    const curEl = document.getElementById('insufficient-current-bal');
    const reqEl = document.getElementById('insufficient-required-bet');
    if (curEl) curEl.textContent = currencySymbol + formatMoney(currentBal);
    if (reqEl) reqEl.textContent = currencySymbol + formatMoney(requiredAmount);

    const modalEl = document.getElementById('olympusInsufficientBalanceModal');
    if (modalEl) {
      const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
    }
  }

  window.switchToDemoModeFromModal = function() {
    const modalEl = document.getElementById('olympusInsufficientBalanceModal');
    if (modalEl) {
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();
    }
    isDemoMode = true;
    updateModeUI();
  };

  window.closeInsufficientAndOpenDeposit = function() {
    const modalEl = document.getElementById('olympusInsufficientBalanceModal');
    if (modalEl) {
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();
    }
    if (typeof openGlobalModal === 'function') {
      openGlobalModal('deposit-modal');
    } else {
      window.location.href = '/dashboard?deposit=1';
    }
  };

  // ---- Audio Synthesizers using Web Audio API ----
  let spinAudioCtx = null;
  let spinOsc = null;
  let spinGain = null;

  function initAudio() {
    if (!spinAudioCtx) {
      spinAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    if (spinAudioCtx.state === 'suspended') {
      spinAudioCtx.resume();
    }
  }

  function playSpinSound() {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;
      spinOsc = spinAudioCtx.createOscillator();
      spinGain = spinAudioCtx.createGain();

      spinOsc.type = 'sine';
      spinOsc.frequency.setValueAtTime(150, now);
      spinOsc.frequency.linearRampToValueAtTime(450, now + 0.5);
      spinOsc.frequency.linearRampToValueAtTime(150, now + 1.0);

      spinGain.gain.setValueAtTime(0.04, now);
      spinOsc.connect(spinGain).connect(spinAudioCtx.destination);
      spinOsc.start(now);
    } catch(e) {}
  }

  function stopSpinSound() {
    try {
      if (spinOsc) {
        spinOsc.stop();
        spinOsc = null;
      }
    } catch(e) {}
  }

  function playReelStopSound(index) {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;
      const osc = spinAudioCtx.createOscillator();
      const gain = spinAudioCtx.createGain();

      osc.type = 'triangle';
      osc.frequency.setValueAtTime(180 - index * 18, now);
      gain.gain.setValueAtTime(0.12, now);
      gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.12);

      osc.connect(gain).connect(spinAudioCtx.destination);
      osc.start(now);
      osc.stop(now + 0.12);
    } catch(e) {}
  }

  function playWinSound() {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;
      const chord = [261.63, 329.63, 392.00, 523.25];
      chord.forEach((f, i) => {
        const osc = spinAudioCtx.createOscillator();
        const gain = spinAudioCtx.createGain();
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(f, now + i * 0.08);
        gain.gain.setValueAtTime(0.05, now + i * 0.08);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + i * 0.08 + 0.4);
        osc.connect(gain).connect(spinAudioCtx.destination);
        osc.start(now + i * 0.08);
        osc.stop(now + i * 0.08 + 0.4);
      });
    } catch(e) {}
  }

  const SHAPES = [1, 2, 3, 4, 5, 6, 7, 8, 9];
  const MULTIS = [
    {label:'2X', value:2, tone:'tone-orange'},
    {label:'5X', value:5, tone:'tone-purple'},
    {label:'10X', value:10, tone:'tone-pink'},
    {label:'25X', value:25, tone:'tone-blue'},
    {label:'100X', value:100, tone:'tone-red'}
  ];

  function randomSymbol(){
    const r = Math.random();
    if (r < 0.08) return {type:'scatter', data: 10};
    if (r < 0.20) return {type:'multi', data: MULTIS[Math.floor(Math.random()*MULTIS.length)]};
    return {type:'shape', data: SHAPES[Math.floor(Math.random()*SHAPES.length)]};
  }

  function symbolMarkup(sym, isFalling = false){
    const animClass = isFalling ? 'symbol-falling' : 'symbol-pop';
    if (sym.type === 'scatter'){
      return `<div class="symbol ${animClass}"><img src="{{ asset('assets/image/GatesofOlympus/10.png') }}" class="shape-img" alt="Scatter"></div>`;
    }
    if (sym.type === 'multi'){
      let imgNum = 11;
      const val = (sym.data && typeof sym.data === 'object') ? (sym.data.value || 2) : 2;
      const tone = (sym.data && typeof sym.data === 'object') ? (sym.data.tone || '') : '';
      if (val >= 100 || tone === 'tone-red') {
        imgNum = 14;
      } else if (val >= 25 || tone === 'tone-blue') {
        imgNum = 13;
      } else if (val >= 10 || tone === 'tone-pink' || tone === 'tone-purple') {
        imgNum = 12;
      } else {
        imgNum = 11;
      }
      return `<div class="symbol ${animClass}"><img src="{{ asset('assets/image/GatesofOlympus') }}/${imgNum}.png" class="shape-img" alt="Multiplier"></div>`;
    }
    const shapeNum = (sym.data && typeof sym.data === 'object') ? (sym.data.id || 1) : (sym.data || 1);
    return `<div class="symbol ${animClass}"><img src="{{ asset('assets/image/GatesofOlympus') }}/${shapeNum}.png" class="shape-img"></div>`;
  }

  // ---- build grid cells ----
  const cells = [];
  for (let c = 0; c < COLS; c++){
    cells[c] = [];
    for (let r = 0; r < ROWS; r++){
      const cell = document.createElement('div');
      cell.className = 'reel-cell';
      cell.dataset.col = c;
      cell.dataset.row = r;
      cell.innerHTML = symbolMarkup(randomSymbol(), false);
      grid.appendChild(cell);
      cells[c][r] = cell;
    }
  }

  function setColumnSymbols(c, symbols, isFalling = false){
    for (let r = 0; r < ROWS; r++){
      cells[c][r].innerHTML = symbolMarkup(symbols[r], isFalling);
    }
  }

  function formatMoney(n){ return (typeof n === 'number' ? n : parseFloat(n || 0)).toFixed(2); }

  function showWinToast(amount){
    winToast.textContent = `+${currencySymbol}${formatMoney(amount)} WIN`;
    winToast.classList.add('show');
    setTimeout(()=> winToast.classList.remove('show'), 1600);
  }

  // ==========================================
  // SERVER DYNAMIC SPIN & TUMBLE ENGINE
  // ==========================================
  function spin(){
    if (spinning) return;

    let activeBet = bet;
    if (buyFeaturePending) {
      activeBet = bet * buySpinsMultiplier;
    } else if (doubleChanceActive) {
      activeBet = bet * (1 + (doubleChancePct / 100));
    }

    if (balance < activeBet){
      autoplayActive = false;
      const apBtn = document.getElementById('bcAutoplay');
      if (apBtn) { apBtn.style.background = ''; apBtn.style.borderColor = ''; }

      if (!isDemoMode) {
        openInsufficientBalanceModal(balance, activeBet);
      } else {
        alert("Demo balance too low. Resetting demo balance.");
        demoBalance = SERVER_CONFIG ? parseFloat(SERVER_CONFIG.demo_starting_balance) : 10000.0;
        balance = demoBalance;
        updateModeUI();
      }
      buyFeaturePending = false;
      return;
    }

    playSpinSound();
    spinning = true;

    const msg = document.getElementById('bcMessage');
    if (msg) msg.textContent = 'SPINNING...';

    // Clear previous win highlights/flames
    for (let c = 0; c < COLS; c++) {
      for (let r = 0; r < ROWS; r++) {
        const cell = cells[c][r];
        cell.classList.remove('cell-win', 'cell-scatter-win');
        const flames = cell.querySelector('.flames-container');
        if (flames) flames.remove();
        const symbolEl = cell.querySelector('.symbol');
        if (symbolEl) symbolEl.classList.remove('symbol-win');
      }
    }

    // Anticipatory balance reduction in UI
    balance -= activeBet;
    if (balanceEl) balanceEl.textContent = (isDemoMode ? 'DEMO ' : currencySymbol) + formatMoney(balance);
    if (spinBtn) {
      spinBtn.classList.add('spinning');
      spinBtn.disabled = true;
    }

    // Start reel tumbling animations across all 6 columns
    const flickerIntervals = [];
    const tumbleSpeed = turboActive ? 40 : 70;
    for (let c = 0; c < COLS; c++) {
      cells[c].forEach(cell => cell.classList.add('reel-col-tumbling'));
      flickerIntervals[c] = setInterval(() => {
        for (let r = 0; r < ROWS; r++){
          cells[c][r].innerHTML = symbolMarkup(randomSymbol(), false);
        }
      }, tumbleSpeed);
    }

    // Send Spin Request to Server API
    const idempotencyKey = 'spin_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    const payload = {
      bet_amount: bet,
      mode: isDemoMode ? 'demo' : 'real',
      is_double_chance: doubleChanceActive,
      is_buy_feature: buyFeaturePending,
      idempotency_key: idempotencyKey
    };

    buyFeaturePending = false; // reset buy feature trigger

    fetch('{{ route("olympus.spin") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN
      },
      body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
      if (!data.success) {
        for (let c = 0; c < COLS; c++) {
          clearInterval(flickerIntervals[c]);
          cells[c].forEach(cell => cell.classList.remove('reel-col-tumbling'));
        }
        stopSpinSound();
        spinning = false;
        if (spinBtn) { spinBtn.classList.remove('spinning'); spinBtn.disabled = false; }

        if (data.auth_required || data.limit_reached_now) {
          openDemoLimitModal();
        } else if (data.insufficient_balance) {
          openInsufficientBalanceModal(data.current_balance || realBalance, data.required_amount || activeBet);
        } else {
          alert(data.message || "Unable to spin. Please try again.");
        }
        return;
      }

      // Process server result
      const serverGrid = data.grid; // 6 cols x 5 rows
      let finished = 0;
      const baseDelay = turboActive ? 200 : 450;
      const stepDelay = turboActive ? 100 : 200;

      for (let c = 0; c < COLS; c++) {
        const stopDelay = baseDelay + c * stepDelay;

        setTimeout(() => {
          clearInterval(flickerIntervals[c]);
          cells[c].forEach(cell => cell.classList.remove('reel-col-tumbling'));

          const colSymbols = serverGrid[c];
          setColumnSymbols(c, colSymbols, true);
          playReelStopSound(c);

          finished++;
          if (finished === COLS) {
            stopSpinSound();
            settleServerRound(data);
          }
        }, stopDelay);
      }
    })
    .catch(err => {
      console.error('Spin API Error:', err);
      for (let c = 0; c < COLS; c++) {
        clearInterval(flickerIntervals[c]);
        cells[c].forEach(cell => cell.classList.remove('reel-col-tumbling'));
      }
      stopSpinSound();
      spinning = false;
      if (spinBtn) { spinBtn.classList.remove('spinning'); spinBtn.disabled = false; }
    });
  }

  function settleServerRound(data) {
    const finalWin = parseFloat(data.final_win || 0);
    const balanceAfter = parseFloat(data.balance);
    const msg = document.getElementById('bcMessage');

    // Update state balance
    if (isDemoMode) {
      demoBalance = balanceAfter;
      balance = demoBalance;
    } else {
      realBalance = balanceAfter;
      balance = realBalance;
      syncHeaderBalance();
    }
    if (balanceEl) balanceEl.textContent = (isDemoMode ? 'DEMO ' : currencySymbol) + formatMoney(balance);

    if (finalWin > 0) {
      if (msg) msg.textContent = `WIN: ${currencySymbol}${formatMoney(finalWin)}`;

      // Highlight winning shape and scatter cells
      if (data.winning_cells && data.winning_cells.length > 0) {
        data.winning_cells.forEach(coord => {
          const cellEl = cells[coord.col][coord.row];
          cellEl.classList.add('cell-win');
          if (!cellEl.querySelector('.flames-container')) {
            const flames = document.createElement('div');
            flames.className = 'flames-container';
            flames.innerHTML = '<div class="flame"></div><div class="flame"></div><div class="flame"></div>';
            cellEl.appendChild(flames);
          }
        });
      }

      // Highlight Multiplier symbols
      if (data.multiplier_cells && data.multiplier_cells.length > 0) {
        data.multiplier_cells.forEach(m => {
          const cellEl = cells[m.col][m.row];
          const symbolEl = cellEl.querySelector('.symbol');
          if (symbolEl) symbolEl.classList.add('symbol-win');
        });
      }

      playWinSound();
      showWinToast(finalWin);
    } else {
      if (msg) msg.textContent = 'PLACE YOUR BETS!';
    }

    spinning = false;
    if (spinBtn) {
      spinBtn.classList.remove('spinning');
      spinBtn.disabled = false;
    }

    // Check if demo limit reached on this spin
    if (isDemoMode && data.limit_reached_now) {
      setTimeout(() => {
        openDemoLimitModal();
      }, 1200);
      autoplayActive = false;
      return;
    }

    // Autoplay continuation
    if (autoplayActive) {
      setTimeout(() => {
        if (autoplayActive && !spinning) {
          spin();
        }
      }, turboActive ? 800 : 1500);
    }
  }

  if (spinBtn) {
    spinBtn.addEventListener('click', spin);
  }

  // ---- Double Chance and Bet Adjustments ----
  const dcSwitch = document.getElementById('dcSwitch');
  const dcLabel = document.getElementById('dcLabel');
  const dcBetVal = document.getElementById('dcBetVal');

  function updateDCUI() {
    const displayedBet = doubleChanceActive ? (bet * (1 + (doubleChancePct / 100))) : bet;
    const bcBet = document.getElementById('bcBet');
    const prefix = isDemoMode ? 'DEMO ' : currencySymbol;
    if (bcBet) {
      bcBet.textContent = formatMoney(displayedBet);
    }
    if (dcBetVal) {
      dcBetVal.textContent = prefix + formatMoney(bet * (1 + (doubleChancePct / 100)));
    }
    const fsPrice = document.getElementById('freeSpinsPrice');
    if (fsPrice) {
      fsPrice.textContent = prefix + formatMoney(bet * buySpinsMultiplier);
    }
  }

  if (dcSwitch) {
    dcSwitch.addEventListener('click', () => {
      if (spinning) return;
      doubleChanceActive = !doubleChanceActive;
      if (doubleChanceActive) {
        dcSwitch.classList.add('on');
        if (dcLabel) {
          dcLabel.textContent = 'ON';
          dcLabel.style.color = '#1f8a44';
        }
      } else {
        dcSwitch.classList.remove('on');
        if (dcLabel) {
          dcLabel.textContent = 'OFF';
          dcLabel.style.color = '';
        }
      }
      updateDCUI();
    });
  }

  const betPlusBtn = document.getElementById('bcBetPlus');
  const betMinusBtn = document.getElementById('bcBetMinus');

  if (betPlusBtn) {
    betPlusBtn.addEventListener('click', () => {
      if (spinning) return;
      bet = Math.min(maxBet, bet + (bet < 10 ? 1.0 : (bet < 50 ? 5.0 : 20.0)));
      updateDCUI();
    });
  }
  if (betMinusBtn) {
    betMinusBtn.addEventListener('click', () => {
      if (spinning) return;
      bet = Math.max(minBet, bet - (bet <= 10 ? 1.0 : (bet <= 50 ? 5.0 : 20.0)));
      updateDCUI();
    });
  }

  // ---- Buy Free Spins Card ----
  const buyFreeSpinsCard = document.getElementById('buyFreeSpinsCard');
  if (buyFreeSpinsCard) {
    buyFreeSpinsCard.addEventListener('click', () => {
      if (spinning) return;
      const fsCost = bet * buySpinsMultiplier;
      const prefix = isDemoMode ? 'DEMO ' : currencySymbol;
      if (balance < fsCost) {
        if (!isDemoMode) {
          openInsufficientBalanceModal(balance, fsCost);
        } else {
          alert("Insufficient demo balance to buy Free Spins!");
        }
        return;
      }
      if (confirm(`Buy Free Spins feature for ${prefix}${formatMoney(fsCost)}?`)) {
        buyFeaturePending = true;
        spin();
      }
    });
  }

  // ---- Autoplay Button ----
  const autoplayBtn = document.getElementById('bcAutoplay');
  if (autoplayBtn) {
    autoplayBtn.addEventListener('click', () => {
      if (spinning) {
        autoplayActive = false;
        autoplayBtn.style.background = '';
        autoplayBtn.style.borderColor = '';
        return;
      }
      autoplayActive = !autoplayActive;
      if (autoplayActive) {
        autoplayBtn.style.background = '#1f8a44';
        autoplayBtn.style.borderColor = '#1f8a44';
        spin();
      } else {
        autoplayBtn.style.background = '';
        autoplayBtn.style.borderColor = '';
      }
    });
  }

  // Initialize UI values on load
  updateDCUI();
  updateModeUI();

  // ---- Chrome buttons ----
  const reloadBtn = document.getElementById('reloadBtn');
  if (reloadBtn) reloadBtn.addEventListener('click', () => location.reload());

  const fullscreenBtn = document.getElementById('fullscreenBtn');
  if (fullscreenBtn) fullscreenBtn.addEventListener('click', () => {
    const shell = document.querySelector('.game-shell');
    if (!document.fullscreenElement) shell.requestFullscreen?.();
    else document.exitFullscreen?.();
  });
})();
</script>
</body>
</html>