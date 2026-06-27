<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Olympus Gold™ — Slot Game UI</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
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
    height:100vh;
    overflow:hidden;
    background:#070b18;
    color:var(--text-light);
    font-family:'Inter',sans-serif;
    display:flex;
    flex-direction:column;
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
    height:0;
    display:flex;
    flex-direction:column;
  }

  /* ---------- top navbar ---------- */
  .top-navbar{
    background:var(--navy-1);
    font-size:.8rem;
    color:#9fb0d8;
    border-bottom:1px solid #1d2950;
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
  }
  .title-bar .game-icon{
    width:34px;height:34px;border-radius:6px;
    background:linear-gradient(145deg,var(--gold),var(--gold-deep));
    display:flex;align-items:center;justify-content:center;
    font-size:1.1rem;
  }
  .form-switch .form-check-input{
    background-color:#243056;border-color:#3a4a82;
  }
  .form-switch .form-check-input:checked{
    background-color:var(--gold-deep);border-color:var(--gold-deep);
  }
  .real-money-label{font-size:.72rem;letter-spacing:.04em;color:#9fb0d8;}

  .icon-btn{
    width:32px;height:32px;border-radius:6px;
    background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);
    display:flex;align-items:center;justify-content:center;
    font-size:.85rem;
    transition:.15s;
  }
  .icon-btn:hover{background:#2a3a6e;}

  /* ---------- sidebar ---------- */
  .sidebar{
    background:var(--navy-1);
    width:56px;
    border-right:1px solid #1d2950;
  }
  .sidebar-icon{
    width:38px;height:38px;border-radius:8px;
    background:transparent;border:none;
    color:#7e8fc0;
    font-size:1.05rem;
    display:flex;align-items:center;justify-content:center;
    transition:.15s;
  }
  .sidebar-icon:hover{background:#1c2c5a;color:var(--text-light);}
  .sidebar-icon.active{
    background:linear-gradient(145deg,var(--purple-light),var(--purple));
    color:#fff;
  }

  /* ---------- stage ---------- */
  .game-stage{
    position:relative;
    background:url("{{ asset('assets/image/gates_bg.png') }}") center center / cover no-repeat;
    height:100%;
    min-height:0;
    overflow:hidden;
    padding:8px 16px 70px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }
  .stage-clouds{display:none;}
  .column-deco{
    position:absolute;
    bottom:0;
    width:46px;
    background:linear-gradient(180deg,#f3e8d8,#cdbfa0);
    box-shadow:inset -6px 0 10px rgba(0,0,0,.15);
  }
  .column-deco.left{left:4%; height:78%;}
  .column-deco.right{right:4%; height:64%;}
  .floor-glow{
    position:absolute;bottom:0;left:0;right:0;height:90px;
    background:linear-gradient(180deg,rgba(245,197,66,0) 0%, rgba(190,140,40,.35) 100%);
    pointer-events:none;
  }

  .logo-banner{
    position:relative;z-index:2;
    font-size:1.4rem;
    letter-spacing:.06em;
    text-align:center;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 45%, var(--gold-deep) 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    text-shadow:none;
    filter:drop-shadow(0 4px 8px rgba(0,0,0,.8));
    margin-bottom:4px;
  }
  .logo-banner span{display:block;font-size:.9rem;letter-spacing:.18em;}

  /* ---------- slot frame ---------- */
  .slot-frame{
    position:relative;z-index:2;
    width:min(560px,90%);
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
      box-shadow: 0 0 0 2px #1c0f2c inset, 
                  0 14px 30px rgba(0,0,0,.45), 
                  0 0 15px #ff3d00, 
                  0 0 30px #ff9100, 
                  0 0 45px #ffea00;
    }
    50% {
      border-color: #ff9100;
      box-shadow: 0 0 0 2px #1c0f2c inset, 
                  0 14px 30px rgba(0,0,0,.45), 
                  0 0 25px #ff3d00, 
                  0 0 50px #ff9100, 
                  0 0 75px #ffea00;
    }
    100% {
      border-color: #ffea00;
      box-shadow: 0 0 0 2px #1c0f2c inset, 
                  0 14px 30px rgba(0,0,0,.45), 
                  0 0 20px #ff3d00, 
                  0 0 40px #ffea00, 
                  0 0 60px #ff9100;
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
  .symbol-fire-win {
    animation: fireBurn 0.8s ease-in-out infinite alternate;
    z-index: 10;
  }
  @keyframes fireBurn {
    0% {
      filter: drop-shadow(0 0 4px #ff3d00) drop-shadow(0 0 8px #ff9100) drop-shadow(0 0 12px #ffea00);
      transform: scale(0.95);
    }
    100% {
      filter: drop-shadow(0 0 15px #ff3d00) drop-shadow(0 0 25px #ff9100) drop-shadow(0 0 35px #ffea00);
      transform: scale(1.12);
    }
  }

  .cell-win-fire {
    position: relative;
    border: 2px dashed #ffea00 !important;
    animation: sparkler 0.3s steps(4) infinite;
    border-radius: 8px;
    z-index: 5;
  }
  .cell-win-fire::before {
    content: '';
    position: absolute;
    inset: -6px;
    border: 3px dotted #ffea00;
    border-radius: 10px;
    animation: rotateSparks 1s linear infinite;
    pointer-events: none;
    filter: drop-shadow(0 0 8px #ff3d00);
  }
  @keyframes rotateSparks {
    0% { transform: rotate(0deg); opacity: 0.9; }
    50% { opacity: 0.4; }
    100% { transform: rotate(360deg); opacity: 0.9; }
  }
  @keyframes sparkler {
    0% {
      box-shadow: 0 0 12px #ff3d00, 
                  0 0 25px #ff9100, 
                  inset 0 0 12px #ffea00;
      border-color: #ff3d00;
    }
    25% {
      box-shadow: 0 0 18px #ffea00, 
                  0 0 40px #ff3d00, 
                  inset 0 0 18px #ff9100;
      border-color: #ffea00;
    }
    50% {
      box-shadow: 0 0 10px #ff9100, 
                  0 0 30px #ffea00, 
                  inset 0 0 10px #ff3d00;
      border-color: #ff9100;
    }
    75% {
      box-shadow: 0 0 24px #ff3d00, 
                  0 0 50px #ff9100, 
                  inset 0 0 20px #ffea00;
      border-color: #ff3d00;
    }
    100% {
      box-shadow: 0 0 15px #ffea00, 
                  0 0 35px #ff3d00, 
                  inset 0 0 15px #ff9100;
      border-color: #ffea00;
    }
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
  .scatter-label{
    position:absolute;bottom:2px;
    background:rgba(0,0,0,0.7);
    color:var(--gold);font-size:.55rem;font-weight:900;
    padding:1px 6px;border-radius:4px;border:1px solid var(--gold);
    letter-spacing:.05em;
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

  /* ---------- deity figure ---------- */
  .deity-wrap{
    position:absolute;
    right:1%;
    bottom:6%;
    z-index:1;
    width:170px;
    opacity:.96;
  }
  .deity-svg{width:100%;display:block;}

  /* ---------- tagline / badges ---------- */
  .bottom-tagline{
    position:relative;z-index:2;
    margin-top:6px;
    font-family:'Cinzel',serif;
    letter-spacing:.05em;
    font-size:.72rem;
    color:var(--gold);
    text-shadow:0 2px 0 rgba(0,0,0,.4);
  }
  .volatility-badge{
    position:absolute;left:50%;bottom:62px;transform:translateX(-50%);
    z-index:3;
    background:#0c1530;border:1px solid var(--gold-deep);
    border-radius:20px;padding:3px 12px;font-size:.65rem;letter-spacing:.05em;
    display:flex;align-items:center;gap:5px;
  }
  .volatility-badge .bolts{color:var(--gold);}

  /* ---------- spin control (reusing the circular control as the real spin button) ---------- */
  .spin-btn{
    position:absolute;
    right:26%;
    bottom:18%;
    z-index:5;
    width:78px;height:78px;border-radius:50%;
    background:radial-gradient(circle at 35% 30%, #2a3550, #0c1530 75%);
    border:3px solid var(--gold);
    color:var(--gold);
    font-size:1.6rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 0 0 6px rgba(0,0,0,.25), 0 0 18px rgba(245,197,66,.4);
    transition:.2s;
  }
  .spin-btn:hover{transform:scale(1.06);}
  .spin-btn:disabled{opacity:.5;cursor:not-allowed;}
  .spin-btn .spin-icon{display:inline-block;transition:transform .6s ease;}
  .spin-btn.spinning .spin-icon{animation:spinRound .7s linear infinite;}
  @keyframes spinRound{to{transform:rotate(360deg);}}

  /* ---------- main game layout container ---------- */
  .main-game-layout {
    display: flex;
    align-items: center;
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
  
  /* Decorative Golden Corners for Cards */
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
    font-size: .85rem;
    letter-spacing: .06em;
    color: #16b7e6;
    font-weight: 900;
    text-shadow: 0 0 6px rgba(22,183,230,.5);
    text-transform: uppercase;
  }
  .buy-spins-panel .feat-label {
    font-size: .85rem;
    font-weight: 900;
    color: #16b7e6;
    text-shadow: 0 0 6px rgba(22,183,230,.5);
    line-height: 1.2;
    margin-bottom: 4px;
    text-transform: uppercase;
  }
  .buy-spins-panel .feat-price {
    font-size: 1.5rem;
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
    padding: 12px 6px;
    border-radius: 10px;
    border: 1px solid #3d2a07;
    box-shadow: inset 0 0 12px rgba(93, 66, 12, 0.4), 0 6px 20px rgba(0,0,0,.65);
  }
  .double-chance-panel .feat-label {
    font-size: .85rem;
    font-weight: 900;
    color: #071f3a;
    line-height: 1.1;
  }
  .double-chance-panel .feat-label span {
    font-size: 1.1rem;
    display: block;
    color: #c08000;
    text-shadow: 0 1px 1px rgba(255,255,255,0.7);
    margin-top: 2px;
  }
  .double-chance-panel .feat-sub {
    font-size: .65rem;
    color: #0d2f5a;
    font-weight: 800;
    line-height: 1.15;
    margin: 6px 0;
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
  }

  .double-chance-toggle{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    margin-top:4px;
    background: rgba(0,0,0,0.15);
    padding: 4px 6px;
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
    height: 110px;
    border-radius: 10px;
    border: 1px solid #111;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.95);
  }

  /* ---------- new bottom controls bar ---------- */
  .bottom-controls{
    position:absolute;
    bottom:0;left:0;right:0;
    z-index:10;
    background:rgba(10,15,30,.92);
    border-top:1px solid #1d2950;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:6px 16px;
    height:62px;
  }
  /* left section */
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
  .bc-icon-btn:hover{background:#2a3a6e;}
  .bc-info{
    display:flex;
    flex-direction:column;
    gap:1px;
  }
  .bc-info-row{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:.72rem;
  }
  .bc-info-key{
    color:#7e8fc0;
    font-weight:700;
    letter-spacing:.05em;
    text-transform:uppercase;
    min-width:42px;
  }
  .bc-info-val{
    color:var(--gold);
    font-weight:800;
  }
  /* center section */
  .bc-center{
    font-size:.9rem;
    font-weight:700;
    color:#fff;
    letter-spacing:.06em;
    text-align:center;
    flex:1;
  }
  /* right section */
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
  .bc-bet-btn:hover{background:#2a3a6e;border-color:var(--gold);}
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
    z-index:6;
    background:linear-gradient(160deg,#fff3c8,var(--gold));
    color:#3a2a06;font-weight:800;
    padding:8px 18px;border-radius:24px;
    font-size:1rem;letter-spacing:.03em;
    opacity:0;
    transition:opacity .25s, transform .25s;
    box-shadow:0 6px 18px rgba(0,0,0,.35);
    pointer-events:none;
  }
  .win-toast.show{opacity:1;transform:translate(-50%,0);}

  /* ---------- bottom bar ---------- */
  .bottom-bar{
    background:var(--navy-1);
    font-size:.78rem;
    color:#9fb0d8;
  }
  .bottom-bar input[type="search"]{
    background:#0c1530;border:1px solid #2a3a6e;color:var(--text-light);
  }

  @media (max-width:768px){
    .deity-wrap{width:110px;right:0;}
    .spin-btn{right:10%;width:62px;height:62px;font-size:1.3rem;}
    .logo-banner{font-size:1.6rem;}
    .logo-banner span{font-size:1.05rem;}
    .game-stage{min-height:480px;}
  }

  /* ==========================================
     FIRE & FLAME CSS EFFECT FOR WINNING TILES
     ========================================== */
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
  .reel-cell.cell-win {
    animation: fireBackground 0.75s ease-in-out infinite;
    border: 2.5px solid #ff4500 !important;
    z-index: 10;
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
  .flame:nth-child(2) {
    animation-delay: 0.15s;
    animation-duration: 0.85s;
    background: #ff8c00;
    width: 18px;
    height: 18px;
  }
  .flame:nth-child(3) {
    animation-delay: 0.3s;
    animation-duration: 0.55s;
    background: #ffd700;
    width: 10px;
    height: 10px;
  }
  @keyframes floatFlame {
    0% {
      transform: translateY(12px) scale(0.65) rotate(-45deg);
      opacity: 0.95;
    }
    50% {
      opacity: 0.85;
    }
    100% {
      transform: translateY(-85px) scale(0) rotate(-45deg);
      opacity: 0;
    }
  }

  /* Tumble / Falling Animation for symbols */
  @keyframes symbolFallDown {
    0% {
      transform: translateY(-200%) scaleY(1.3);
      opacity: 0;
    }
    60% {
      transform: translateY(15%) scaleY(0.9);
      opacity: 1;
    }
    85% {
      transform: translateY(-8%) scaleY(1.05);
    }
    100% {
      transform: translateY(0) scaleY(1);
      opacity: 1;
    }
  }
  .symbol-falling {
    animation: symbolFallDown 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
  }
</style>
</head>
<body>

@include('customer.header')

<div class="game-shell" style="width:100%;max-width:100%;margin:0;border-radius:0;">

  <!-- top navbar -->
  <div class="top-navbar d-flex align-items-center justify-content-between px-3 py-2">
    <div>🏠 / Slots / Top Picks / <strong>Olympus Gold™</strong></div>
    <input type="search" class="form-control form-control-sm" placeholder="Search games">
  </div>

  <!-- title bar -->
  <div class="title-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-2">
      <div class="game-icon display-font">Ω</div>
      <strong class="display-font">Olympus Gold™</strong>
      <div class="form-check form-switch ms-3 d-flex align-items-center gap-2">
        <input class="form-check-input" type="checkbox" role="switch" id="realMoneyToggle">
        <label class="form-check-label real-money-label" for="realMoneyToggle">PLAY FOR REAL MONEY (demo toggle only)</label>
      </div>
    </div>
    <div class="d-flex gap-2">
      <button class="icon-btn" id="layoutBtn" title="Layout">▦</button>
      <button class="icon-btn" id="fullscreenBtn" title="Fullscreen">⛶</button>
      <button class="icon-btn" id="reloadBtn" title="Reload game">↺</button>
      <button class="icon-btn" id="favBtn" title="Add to favorites">★</button>
      <button class="icon-btn" id="closeBtn" title="Close" onclick="window.location.href='/dashboard'">✕</button>
    </div>
  </div>

  <div class="d-flex flex-grow-1" style="overflow: hidden; height: 0;">

    <!-- sidebar -->
    <div class="sidebar d-flex flex-column align-items-center py-3 gap-2">
      <button class="sidebar-icon" title="Favorites">♥</button>
      <button class="sidebar-icon" title="Categories">▦</button>
      <button class="sidebar-icon" title="New releases">⚡</button>
      <button class="sidebar-icon" title="Top games">🏆</button>
      <button class="sidebar-icon active" title="All games">🎮</button>
    </div>

    <!-- main game stage -->
    <div class="game-stage flex-grow-1">
      <div class="stage-clouds"></div>
      <div class="floor-glow"></div>

      <div class="logo-banner display-font">OLYMPUS <span>GOLD</span></div>

      <div class="main-game-layout">
        <!-- Left Feature Panel -->
        <div class="feature-panel">
          <!-- Buy Free Spins -->
          <div class="feat-card buy-spins-panel" id="buyFreeSpinsCard">
            <div class="feat-title">BUY</div>
            <div class="feat-label">FREE SPINS</div>
            <div class="feat-price" id="freeSpinsPrice">$240</div>
          </div>
          <!-- Double Chance -->
          <div class="feat-card double-chance-panel">
            <div class="feat-label">BET <span id="dcBetVal">$3.00</span></div>
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
      <div class="bottom-tagline fs-5" style="margin-top:2px;">RANDOM MULTIPLIERS UP TO 500X</div>

      <div class="win-toast" id="winToast">+0.00 WIN</div>

      <!-- New Bottom Controls Bar -->
      <div class="bottom-controls">
        <!-- Left: menu + info + credit/bet -->
        <div class="bc-left">
          <button class="bc-icon-btn" title="Menu" id="menuBtn">≡</button>
          <button class="bc-icon-btn" title="Info" id="infoBtn">ⓘ</button>
          <div class="bc-info">
            <div class="bc-info-row">
              <span class="bc-info-key">CREDIT</span>
              <span class="bc-info-val" id="bcCredit">0.00</span>
            </div>
            <div class="bc-info-row">
              <span class="bc-info-key">BET</span>
              <span class="bc-info-val" id="bcBet">2.00</span>
            </div>
          </div>
        </div>
        <!-- Center: place your bets -->
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
      <span>🕐 RECENT GAMES</span>
      <span>★ FAVORITES</span>
    </div>
    <input type="search" class="form-control form-control-sm" style="max-width:200px" placeholder="Search">
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const COLS = 6, ROWS = 5;
  const grid = document.getElementById('reelsGrid');
  const spinBtn = document.getElementById('bcSpinBtn') || document.getElementById('spinBtn');
  const winToast = document.getElementById('winToast');
  const balanceEl = document.getElementById('bcCredit') || document.getElementById('balanceValue');
  const betEl = document.getElementById('bcBet') || document.getElementById('betValue');
  const realMoneyToggle = document.getElementById('realMoneyToggle');

  // Dummy or real placeholders
  const lastWinEl = document.getElementById('lastWinValue') || { set textContent(v) {} };
  const balanceLabelEl = document.getElementById('balanceLabel') || { set textContent(v) {} };

  // ==========================================
  // LARAVEL DATABASE & STATE INTEGRATION
  // ==========================================
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

  let bet = 2.00;
  let spinning = false;

  function updateModeUI() {
    if (isDemoMode) {
      if (realMoneyToggle) realMoneyToggle.checked = false;
      balanceLabelEl.textContent = 'demo balance';
      balance = demoBalance;
    } else {
      if (realBalance < 1.0) {
        alert("Your real balance is too low! Switching to Demo Mode.");
        isDemoMode = true;
        if (realMoneyToggle) realMoneyToggle.checked = false;
        balanceLabelEl.textContent = 'demo balance';
        balance = demoBalance;
      } else {
        if (realMoneyToggle) realMoneyToggle.checked = true;
        balanceLabelEl.textContent = 'real balance';
        balance = realBalance;
      }
    }
    if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
    syncHeaderBalance();
  }

  function syncHeaderBalance() {
    const headerBalance = document.querySelector('.header-balance-value');
    if (headerBalance) {
      headerBalance.textContent = formatMoney(realBalance);
    }
  }

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
        syncHeaderBalance();
      }
    })
    .catch(err => console.error('Error syncing balance:', err));
  }

  if (realMoneyToggle) {
    realMoneyToggle.addEventListener('change', function() {
      if (spinning) {
        realMoneyToggle.checked = !realMoneyToggle.checked;
        return;
      }
      isDemoMode = !realMoneyToggle.checked;
      updateModeUI();
    });
  }

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

  function playEpicIntroSound() {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;

      // Deep rumble (sawtooth synth)
      const osc1 = spinAudioCtx.createOscillator();
      const gain1 = spinAudioCtx.createGain();
      osc1.type = 'sawtooth';
      osc1.frequency.setValueAtTime(55, now); // Low A
      osc1.frequency.linearRampToValueAtTime(35, now + 2.5);
      gain1.gain.setValueAtTime(0.20, now);
      gain1.gain.exponentialRampToValueAtTime(0.0001, now + 2.5);

      // Scary thunder crackles
      const osc2 = spinAudioCtx.createOscillator();
      const gain2 = spinAudioCtx.createGain();
      osc2.type = 'triangle';
      osc2.frequency.setValueAtTime(90, now);
      osc2.frequency.setValueAtTime(900, now + 0.25);
      osc2.frequency.setValueAtTime(140, now + 0.5);
      gain2.gain.setValueAtTime(0.15, now);
      gain2.gain.exponentialRampToValueAtTime(0.0001, now + 1.8);

      osc1.connect(gain1).connect(spinAudioCtx.destination);
      osc2.connect(gain2).connect(spinAudioCtx.destination);

      osc1.start(now);
      osc1.stop(now + 2.5);
      osc2.start(now);
      osc2.stop(now + 2.5);
    } catch(e) {}
  }

  function playSpinSound() {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;
      spinOsc = spinAudioCtx.createOscillator();
      spinGain = spinAudioCtx.createGain();

      spinOsc.type = 'sine';
      spinOsc.frequency.setValueAtTime(150, now);
      // Sweeping frequency
      spinOsc.frequency.linearRampToValueAtTime(450, now + 0.5);
      spinOsc.frequency.linearRampToValueAtTime(150, now + 1.0);
      spinOsc.frequency.linearRampToValueAtTime(450, now + 1.5);
      spinOsc.frequency.linearRampToValueAtTime(150, now + 2.0);

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
      gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.15);

      osc.connect(gain).connect(spinAudioCtx.destination);
      osc.start(now);
      osc.stop(now + 0.15);
    } catch(e) {}
  }

  function playWinSound() {
    try {
      initAudio();
      const now = spinAudioCtx.currentTime;
      const chord = [261.63, 329.63, 392.00, 523.25]; // C major chord notes
      chord.forEach((f, i) => {
        const osc = spinAudioCtx.createOscillator();
        const gain = spinAudioCtx.createGain();
        osc.type = 'sawtooth'; // Sawtooth sounds more dramatic for win
        osc.frequency.setValueAtTime(f, now + i * 0.08);
        gain.gain.setValueAtTime(0.05, now + i * 0.08);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + i * 0.08 + 0.5);
        osc.connect(gain).connect(spinAudioCtx.destination);
        osc.start(now + i * 0.08);
        osc.stop(now + i * 0.08 + 0.5);
      });
    } catch(e) {}
  }

  // Trigger scary epic load sound on first click anywhere on screen
  window.addEventListener('click', () => {
    if (!window.introSoundPlayed) {
      playEpicIntroSound();
      window.introSoundPlayed = true;
    }
  }, { once: true });

  const SHAPES = [1, 2, 3, 4, 5, 6, 7, 8, 9];
  const MULTIS = [
    {label:'2X', value:2, tone:'tone-orange'},
    {label:'5X', value:5, tone:'tone-purple'},
    {label:'5X', value:5, tone:'tone-pink'},
    {label:'25X', value:25, tone:'tone-blue'},
    {label:'100X', value:100, tone:'tone-red'}
  ];



  // ---- symbol generation ----
  let doubleChanceActive = false;
  let guaranteeScatters = false;

  function randomSymbol(){
    const r = Math.random();
    const scatterChance = doubleChanceActive ? 0.16 : 0.08;
    if (r < scatterChance) return {type:'scatter'};
    if (r < scatterChance + 0.15) return {type:'multi', data: MULTIS[Math.floor(Math.random()*MULTIS.length)]};
    return {type:'shape', data: SHAPES[Math.floor(Math.random()*SHAPES.length)]};
  }

  function symbolMarkup(sym, isFalling = false){
    const animClass = isFalling ? 'symbol-falling' : 'symbol-pop';
    if (sym.type === 'scatter'){
      return `<div class="symbol ${animClass}"><div class="scatter-badge"><img src="{{ asset('assets/image/GatesofOlympus/10.png') }}"></div></div>`;
    }
    if (sym.type === 'multi'){
      let imgNum = 11;
      if (sym.data.tone === 'tone-purple' || sym.data.tone === 'tone-pink') imgNum = 12;
      else if (sym.data.tone === 'tone-blue') imgNum = 13;
      else if (sym.data.tone === 'tone-red') imgNum = 14;

      return `<div class="symbol ${animClass}">
                <div class="multi-badge-wrap">
                  <img src="{{ asset('assets/image/GatesofOlympus') }}/${imgNum}.png" class="multi-img">
                  <span class="multi-val-text">${sym.data.label}</span>
                </div>
              </div>`;
    }
    return `<div class="symbol ${animClass}"><img src="{{ asset('assets/image/GatesofOlympus') }}/${sym.data}.png" class="shape-img"></div>`;
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

  function formatMoney(n){ return n.toFixed(2); }

  // Check and Sync user balance on start
  try {
     fetch('{{ route("game.active-settings") }}')
     .then(res => res.json())
     .then(data => {
         if (data && data.balance !== undefined) {
             balance = parseFloat(data.balance);
             if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
         }
     });
  } catch(e) {}

  function showWinToast(amount){
    winToast.textContent = `+${currencySymbol}${formatMoney(amount)} WIN`;
    winToast.classList.add('show');
    setTimeout(()=> winToast.classList.remove('show'), 1400);
  }

  function highlightMultis(){
    document.querySelectorAll('.multi-badge').forEach(el => el.classList.add('symbol-win'));
  }

  // ---- spin / tumble mechanic ----
  function spin(){
    if (spinning) return;
    const activeBet = doubleChanceActive ? (bet * 1.25) : bet;
    if (balance < activeBet){
      showWinToast(0);
      alert("Insufficient balance to place bet!");
      autoplayActive = false;
      const apBtn = document.getElementById('bcAutoplay');
      if (apBtn) {
        apBtn.style.background = '';
        apBtn.style.borderColor = '';
      }
      return;
    }

    playSpinSound();

    spinning = true;
    
    // Update message
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
        if (symbolEl) {
          symbolEl.classList.remove('symbol-win');
        }
      }
    }

    balance -= activeBet;
    if (isDemoMode) {
      demoBalance = balance;
    } else {
      realBalance = balance;
      syncBalance(realBalance);
    }
    if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
    if (spinBtn) {
      spinBtn.classList.add('spinning');
      spinBtn.disabled = true;
    }

    let finished = 0;
    const finalSymbolsByCol = [];

    for (let c = 0; c < COLS; c++){
      const colEl = cellsColumnWrapper(c);
      colEl.classList.add('reel-col-tumbling');

      const flickerInterval = setInterval(() => {
        for (let r = 0; r < ROWS; r++){
          cells[c][r].innerHTML = symbolMarkup(randomSymbol(), false);
        }
      }, 70);

      const stopDelay = 500 + c * 220;
      setTimeout(() => {
        clearInterval(flickerInterval);
        colEl.classList.remove('reel-col-tumbling');
        const finalSymbols = [];
        for (let r = 0; r < ROWS; r++) {
          if (guaranteeScatters && c < 4 && r === 2) {
            finalSymbols.push({type:'scatter'});
          } else {
            finalSymbols.push(randomSymbol());
          }
        }
        setColumnSymbols(c, finalSymbols, true);
        finalSymbolsByCol[c] = finalSymbols;
        
        playReelStopSound(c); // Sound on column stop

        finished++;
        if (finished === COLS){
          stopSpinSound(); // Stop spin loop audio
          settleRound(finalSymbolsByCol);
        }
      }, stopDelay);
    }
  }

  function cellsColumnWrapper(c){
    // group of cells sharing a column index, treated as one unit for the tumble overlay
    return {
      classList: {
        add: () => cells[c].forEach(cell => cell.classList.add('reel-col-tumbling')),
        remove: () => cells[c].forEach(cell => cell.classList.remove('reel-col-tumbling'))
      }
    };
  }

  function settleRound(finalSymbolsByCol){
    guaranteeScatters = false; // Reset scatter guarantee

    // Flatten the grid symbols to easily analyze
    const flatSymbols = [];
    for (let c = 0; c < COLS; c++) {
      for (let r = 0; r < ROWS; r++) {
        flatSymbols.push({
          col: c,
          row: r,
          sym: finalSymbolsByCol[c][r]
        });
      }
    }

    // Count occurrences of shapes and scatters
    const counts = {};
    flatSymbols.forEach(item => {
      if (item.sym.type === 'shape') {
        const shapeId = item.sym.data;
        if (!counts[shapeId]) counts[shapeId] = [];
        counts[shapeId].push(item);
      } else if (item.sym.type === 'scatter') {
        if (!counts['scatter']) counts['scatter'] = [];
        counts['scatter'].push(item);
      }
    });

    let totalWinMultiplier = 0;
    const winningItems = [];

    // Check for regular shape wins (8 or more matching)
    for (const shapeId in counts) {
      if (shapeId !== 'scatter') {
        const matches = counts[shapeId];
        if (matches.length >= 8) {
          // It's a win! Calculate multiplier based on match count and symbol tier
          let shapeMultiplier = 0.2; 
          const idNum = parseInt(shapeId);
          if (idNum <= 3) {
            // Low tier
            if (matches.length >= 12) shapeMultiplier = 2.0;
            else if (matches.length >= 10) shapeMultiplier = 1.0;
            else shapeMultiplier = 0.50;
          } else if (idNum <= 6) {
            // Mid tier
            if (matches.length >= 12) shapeMultiplier = 5.0;
            else if (matches.length >= 10) shapeMultiplier = 2.0;
            else shapeMultiplier = 1.0;
          } else {
            // High tier
            if (matches.length >= 12) shapeMultiplier = 15.0;
            else if (matches.length >= 10) shapeMultiplier = 8.0;
            else shapeMultiplier = 3.0;
          }

          totalWinMultiplier += shapeMultiplier;
          matches.forEach(m => winningItems.push(m));
        }
      }
    }

    // Check for scatter wins (4 or more scatters)
    if (counts['scatter'] && counts['scatter'].length >= 4) {
      const scatters = counts['scatter'];
      let scatterMultiplier = 3.0;
      if (scatters.length === 5) scatterMultiplier = 15.0;
      else if (scatters.length >= 6) scatterMultiplier = 100.0;

      totalWinMultiplier += scatterMultiplier;
      scatters.forEach(m => winningItems.push(m));
    }

    // Count multipliers on the grid
    let gridMultiplier = 0;
    let multiplierSymbols = [];
    for (let c = 0; c < COLS; c++) {
      for (let r = 0; r < ROWS; r++) {
        const sym = finalSymbolsByCol[c][r];
        if (sym.type === 'multi') {
          gridMultiplier += sym.data.value;
          multiplierSymbols.push({ col: c, row: r });
        }
      }
    }

    let finalWinAmount = 0;
    const msg = document.getElementById('bcMessage');

    if (winningItems.length > 0) {
      let winBase = bet * totalWinMultiplier;
      if (gridMultiplier > 0) {
        finalWinAmount = winBase * gridMultiplier;
        // Highlight multiplier balls
        multiplierSymbols.forEach(m => {
          const cellEl = cells[m.col][m.row];
          const symbolEl = cellEl.querySelector('.symbol');
          if (symbolEl) symbolEl.classList.add('symbol-win');
        });
      } else {
        finalWinAmount = winBase;
      }

      balance += finalWinAmount;
      if (isDemoMode) {
        demoBalance = balance;
      } else {
        realBalance = balance;
        syncBalance(realBalance);
      }
      if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
      lastWinEl.textContent = currencySymbol + formatMoney(finalWinAmount);
      if (msg) msg.textContent = `WIN: ${currencySymbol}${formatMoney(finalWinAmount)}`;
      
      // Highlight the winning items with fire burn animation and border flames
      winningItems.forEach(item => {
        const cellEl = cells[item.col][item.row];
        cellEl.classList.add('cell-win');
        if (!cellEl.querySelector('.flames-container')) {
          const flames = document.createElement('div');
          flames.className = 'flames-container';
          flames.innerHTML = '<div class="flame"></div><div class="flame"></div><div class="flame"></div>';
          cellEl.appendChild(flames);
        }
      });

      playWinSound();
      showWinToast(finalWinAmount);
    } else {
      lastWinEl.textContent = currencySymbol + '0.00';
      if (msg) msg.textContent = 'PLACE YOUR BETS!';
    }

    spinning = false;
    if (spinBtn) {
      spinBtn.classList.remove('spinning');
      spinBtn.disabled = false;
    }

    // Auto-spin again if autoplay is active
    if (autoplayActive) {
      setTimeout(() => {
        if (autoplayActive && !spinning) {
          spin();
        }
      }, 1500);
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
    const displayedBet = doubleChanceActive ? (bet * 1.25) : bet;
    const bcBet = document.getElementById('bcBet');
    if (bcBet) {
      bcBet.textContent = formatMoney(displayedBet);
    }
    if (dcBetVal) {
      dcBetVal.textContent = currencySymbol + formatMoney(bet * 1.25);
    }
    const fsPrice = document.getElementById('freeSpinsPrice');
    if (fsPrice) {
      fsPrice.textContent = currencySymbol + formatMoney(bet * 100);
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

  const betPlusBtn = document.getElementById('bcBetPlus') || document.getElementById('betPlus');
  const betMinusBtn = document.getElementById('bcBetMinus') || document.getElementById('betMinus');

  if (betPlusBtn) {
    betPlusBtn.addEventListener('click', () => {
      if (spinning) return;
      bet = Math.min(100, bet + 0.5);
      updateDCUI();
    });
  }
  if (betMinusBtn) {
    betMinusBtn.addEventListener('click', () => {
      if (spinning) return;
      bet = Math.max(0.5, bet - 0.5);
      updateDCUI();
    });
  }

  // ---- Buy Free Spins Card ----
  const buyFreeSpinsCard = document.getElementById('buyFreeSpinsCard');
  if (buyFreeSpinsCard) {
    buyFreeSpinsCard.addEventListener('click', () => {
      if (spinning) return;
      const fsCost = bet * 100;
      if (balance < fsCost) {
        alert("Insufficient balance to buy Free Spins!");
        return;
      }
      if (confirm(`Buy Free Spins for ${currencySymbol}${formatMoney(fsCost)}?`)) {
        balance -= fsCost;
        if (isDemoMode) {
          demoBalance = balance;
        } else {
          realBalance = balance;
          syncBalance(realBalance);
        }
        if (balanceEl) balanceEl.textContent = currencySymbol + formatMoney(balance);
        
        guaranteeScatters = true;
        spin();
      }
    });
  }

  // ---- Autoplay Button ----
  const autoplayBtn = document.getElementById('bcAutoplay');
  let autoplayActive = false;

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

  // Initialize DC UI values on load
  updateDCUI();

  // ---- chrome buttons (cosmetic, like the lobby preview controls) ----
  document.getElementById('reloadBtn').addEventListener('click', () => location.reload());
  document.getElementById('fullscreenBtn').addEventListener('click', () => {
    const shell = document.querySelector('.game-shell');
    if (!document.fullscreenElement) shell.requestFullscreen?.();
    else document.exitFullscreen?.();
  });
  document.getElementById('favBtn').addEventListener('click', (e) => {
    e.target.classList.toggle('text-warning');
    e.target.style.color = e.target.classList.contains('text-warning') ? '#f5c542' : '';
  });
  // Prevent developer tools / contextmenu
  document.addEventListener('contextmenu', e => e.preventDefault());
  document.addEventListener('keydown', e => {
    if (
      e.key === 'F12' ||
      (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
      (e.ctrlKey && e.key === 'U')
    ) {
      e.preventDefault();
    }
  });
})();
</script>
</body>
</html>