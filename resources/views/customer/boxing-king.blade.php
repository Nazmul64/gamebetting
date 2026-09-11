<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Boxing King™ — 1xBet Casino Slot Game</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Inter:wght@400;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --navy-1:#0c1530;
    --navy-2:#15224a;
    --navy-3:#1c2c5a;
    --gold:#f5c542;
    --gold-deep:#c8901a;
    --ring-red:#c0203a;
    --ring-red-deep:#7a0f22;
    --ring-blue:#2a6fd8;
    --accent-purple:#5b2a86;
    --text-light:#eef1f8;
    --card-red:#d3344f;
    --card-purple:#8e4fc7;
    --card-blue:#2a9fd8;
    --card-green:#3aa65a;

    /* Dynamic size variables for responsiveness */
    --reel-col-height: 510px;
    --symbol-cell-height: 170px;
    --left-panel-direction: column;
    --settings-sidebar-direction: column;
    --game-layout-direction: row;
    --buy-btn-size: 76px;
    --buy-btn-font: 0.7rem;
  }

  @media (max-height: 850px) {
    :root {
      --reel-col-height: 420px;
      --symbol-cell-height: 140px;
    }
  }

  @media (max-height: 720px) {
    :root {
      --reel-col-height: 330px;
      --symbol-cell-height: 110px;
    }
  }

  @media (max-height: 580px) {
    :root {
      --reel-col-height: 255px;
      --symbol-cell-height: 85px;
      --buy-btn-size: 62px;
      --buy-btn-font: 0.6rem;
    }
  }

  @media (max-width: 768px) {
    :root {
      --game-layout-direction: column;
      --left-panel-direction: row;
      --settings-sidebar-direction: row;
    }
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
  .display-font{font-family:'Russo One',sans-serif;}

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
    background:#0c1530;border:1px solid #2a3a6e;color:var(--text-light);max-width:220px;
  }

  /* ---------- title bar ---------- */
  .title-bar{background:var(--navy-2);border-bottom:1px solid #1d2950;}
  .title-bar .game-icon{
    width:34px;height:34px;border-radius:6px;
    background:linear-gradient(135deg,#ef4444,#f5c542);
    display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;font-weight:800;
    box-shadow:0 0 10px rgba(239, 68, 68, 0.4);
  }
  .form-switch .form-check-input{background-color:#243056;border-color:#3a4a82;cursor:pointer;}
  .form-switch .form-check-input:checked{background-color:#10b981;border-color:#10b981;}
  .real-money-label{font-size:.75rem;letter-spacing:.04em;color:#cbd5e1;font-weight:700;cursor:pointer;}
  .icon-btn{
    width:32px;height:32px;border-radius:6px;background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);display:flex;align-items:center;justify-content:center;font-size:.85rem;transition:.15s;
    cursor:pointer;
  }
  .icon-btn:hover{background:#2a3a6e; transform:scale(1.05);}

  /* ---------- sidebar ---------- */
  .sidebar{background:var(--navy-1);width:56px;border-right:1px solid #1d2950; z-index: 20;}
  .sidebar-icon{
    width:38px;height:38px;border-radius:8px;background:transparent;border:none;color:#7e8fc0;
    font-size:1.05rem;display:flex;align-items:center;justify-content:center;transition:.15s;
    cursor:pointer;
  }
  .sidebar-icon:hover{background:#1c2c5a;color:var(--text-light);transform:scale(1.08);}
  .sidebar-icon.active{background:linear-gradient(145deg,var(--ring-red),var(--ring-red-deep));color:#fff;box-shadow:0 0 10px rgba(192,32,58,0.5);}

  /* ---------- stage (boxing arena) ---------- */
  .game-stage{
    position:relative;
    background:url("{{ asset('assets/image/boxing_bg.png') }}") center center / cover no-repeat;
    height:100%;
    min-height:0;
    overflow:hidden;
    padding:15px 20px 20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }

  /* Arena Atmosphere & Cheering Audience Animations */
  .arena-atmosphere {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
    overflow: hidden;
  }
  .crowd-silhouette {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 140px;
    background: radial-gradient(ellipse at bottom, rgba(16, 8, 30, 0.75) 0%, rgba(5, 2, 10, 0.95) 75%, transparent 100%);
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
    opacity: 0.85;
    pointer-events: none;
  }
  .crowd-head {
    width: 22px;
    height: 38px;
    background: #08040d;
    border-radius: 50% 50% 0 0;
    animation: crowdCheer 1.8s infinite ease-in-out alternate;
    opacity: 0.65;
  }
  .crowd-head:nth-child(2n) { animation-delay: 0.3s; animation-duration: 1.4s; height: 44px; width: 26px; }
  .crowd-head:nth-child(3n) { animation-delay: 0.7s; animation-duration: 2.1s; height: 32px; width: 20px; }
  .crowd-head:nth-child(4n) { animation-delay: 1.1s; animation-duration: 1.6s; height: 48px; width: 28px; }
  @keyframes crowdCheer {
    0% { transform: translateY(0) scaleY(1); }
    50% { transform: translateY(-8px) scaleY(1.08); }
    100% { transform: translateY(-3px) scaleY(1.02); }
  }

  /* Sweeping Arena Spotlights */
  .spotlight-sweep {
    position: absolute;
    top: -50%;
    width: 380px;
    height: 180%;
    background: radial-gradient(ellipse at top, rgba(245, 197, 66, 0.25) 0%, rgba(239, 68, 68, 0.1) 45%, transparent 70%);
    filter: blur(28px);
    pointer-events: none;
    animation: sweepBeam 7s ease-in-out infinite alternate;
  }
  .spotlight-left { left: 2%; transform-origin: top left; }
  .spotlight-right { right: 2%; transform-origin: top right; animation-delay: -3.5s; }
  @keyframes sweepBeam {
    0% { transform: rotate(-18deg) scaleX(1); opacity: 0.55; }
    50% { transform: rotate(12deg) scaleX(1.35); opacity: 0.9; }
    100% { transform: rotate(-12deg) scaleX(1.1); opacity: 0.6; }
  }

  /* Flashing Photographer Camera Lights */
  .camera-flash {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 0 20px 10px rgba(255, 255, 255, 0.95);
    opacity: 0;
    pointer-events: none;
    animation: flashBurst 4.5s infinite ease-out;
  }
  @keyframes flashBurst {
    0%, 90%, 100% { opacity: 0; transform: scale(0.4); }
    92% { opacity: 1; transform: scale(2.4); }
    94% { opacity: 0.15; transform: scale(1.1); }
    96% { opacity: 0.95; transform: scale(2); }
  }

  .mini-logo{
    position:absolute;top:8%;left:6%;z-index:4;
    transform:rotate(-6deg);
    font-size:1.15rem;letter-spacing:.05em;
    font-weight:900;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 45%, #ef4444 100%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    text-shadow:0 2px 8px rgba(239, 68, 68, 0.6);
  }

  .buy-bonus-btn{
    position:relative;
    width: var(--buy-btn-size);
    height: var(--buy-btn-size);
    border-radius:50%;
    background:radial-gradient(circle at 35% 30%, #ff5b6e, var(--ring-red-deep) 75%);
    border:3px solid var(--gold);color:#fff;font-weight:800;font-size: var(--buy-btn-font);text-align:center;
    display:flex;align-items:center;justify-content:center;line-height:1.1;
    box-shadow:0 0 18px rgba(192,32,58,.6);
    animation:bonusPulse 1.8s ease-in-out infinite;
    cursor:pointer;
    flex-shrink:0;
    z-index:5;
  }
  @keyframes bonusPulse{0%,100%{transform:scale(1);}50%{transform:scale(1.06);}}

  /* ---------- main game layout container ---------- */
  .main-game-layout {
    display: flex;
    flex-direction: var(--game-layout-direction);
    align-items: center;
    justify-content: center;
    gap: 20px;
    width: 100%;
    max-width: 950px;
    margin: auto;
    position: relative;
    z-index: 2;
  }

  /* ---------- reel frame ---------- */
  .reel-frame{
    position:relative;z-index:2;
    margin:0;
    width:min(900px, 94%);
    background:linear-gradient(160deg,#1c152a,#0c0816);
    border: 4px solid #ff4500;
    border-radius:14px;
    padding:8px;
    animation: fireBorderGlow 3s ease-in-out infinite;
  }
  @keyframes fireBorderGlow {
    0%, 100% {
      border-color: #ff4500;
      box-shadow: 0 0 18px rgba(255, 69, 0, 0.7), inset 0 0 14px rgba(255, 69, 0, 0.45);
      filter: drop-shadow(0 0 4px rgba(255, 69, 0, 0.8));
    }
    50% {
      border-color: #ffd700;
      box-shadow: 0 0 35px rgba(255, 215, 0, 0.95), inset 0 0 25px rgba(255, 215, 0, 0.7);
      filter: drop-shadow(0 0 12px rgba(255, 215, 0, 1));
    }
  }
  .reels-row{display:flex;gap:3px;}
  .reel-col{
    flex:1;
    height: var(--reel-col-height);
    overflow:hidden;
    position:relative;
    border-radius:8px;
    background:rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,0.06);
  }
  .reel-col.spinning{animation:reelShake .12s linear infinite;}
  .reel-col.spinning .symbol-cell{filter:blur(3px) brightness(1.15);}
  @keyframes reelShake{0%,100%{transform:translateY(0);}50%{transform:translateY(5px);}}
  .reel-col.settle{animation:reelSettle .4s cubic-bezier(.34,1.56,.64,1);}
  @keyframes reelSettle{0%{transform:translateY(-12px);}60%{transform:translateY(4px);}100%{transform:translateY(0);}}

  .symbol-cell{
    height: var(--symbol-cell-height);
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    border: 1px solid rgba(255, 255, 255, 0.05);
    overflow: hidden;
    transition: all 0.2s;
  }
  .symbol-cell.cell-scatter-win .symbol{animation:winGlow 1s ease infinite;}
  @keyframes winGlow{0%,100%{filter:drop-shadow(0 0 3px rgba(245,197,66,.2));}50%{filter:drop-shadow(0 0 16px rgba(245,197,66,.9));}}

  .symbol{width:100%;height:100%;display:flex;align-items:center;justify-content:center;animation:popIn .3s ease;}
  @keyframes popIn{0%{transform:scale(.95);opacity:0;}70%{transform:scale(1.02);}100%{transform:scale(1);opacity:1;}}

  /* ==========================================
     FIRE & FLAME CSS EFFECT FOR WINNING TILES
     ========================================== */
  /* উইনিং সেলে আগুন জ্বলার অ্যানিমেশন */
  .cell-on-fire {
      position: relative;
      border: 3px solid #ff4500 !important;
      box-shadow: 0 0 25px #ff4500, inset 0 0 18px #ffa500 !important;
      animation: fireFlicker 0.4s infinite alternate;
      z-index: 10;
  }

  .cell-on-fire::before {
      content: "🔥";
      position: absolute;
      top: -12px;
      font-size: 24px;
      animation: fireRise 0.5s infinite alternate;
      z-index: 20;
  }

  @keyframes fireFlicker {
      0% { transform: scale(1); filter: brightness(1.2); }
      100% { transform: scale(1.06); filter: brightness(1.7); box-shadow: 0 0 35px #ff0000; }
  }

  @keyframes fireRise {
      0% { transform: translateY(0); opacity: 0.85; }
      100% { transform: translateY(-8px); opacity: 1; }
  }

  /* স্পিন ঘোরার ব্লার এনিমেশন */
  .reel-blur {
      filter: blur(5px);
      transition: all 0.1s linear;
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
  .symbol-cell.cell-win {
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

  /* celebration overlay */
  .celebration-overlay{
    position:absolute;inset:0;z-index:20;display:flex;align-items:center;justify-content:center;
    pointer-events:none;opacity:0;transition:opacity .25s;
  }
  .celebration-overlay.show{opacity:1;}
  .celebration-text{
    font-family:'Russo One',sans-serif;
    font-size:3.2rem;letter-spacing:.05em;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 45%, #ef4444 100%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    text-shadow:0 4px 15px rgba(239,68,68,.7);
    transform:scale(.6);
    transition:transform .35s cubic-bezier(.34,1.56,.64,1);
  }
  .celebration-overlay.show .celebration-text{transform:scale(1);}

  .confetti-layer{position:absolute;inset:0;z-index:19;overflow:hidden;pointer-events:none;}
  .confetti-piece{
    position:absolute;top:-20px;width:10px;height:16px;border-radius:2px;
    animation:confettiFall linear forwards;
  }
  @keyframes confettiFall{
    0%{transform:translateY(0) rotate(0deg);opacity:1;}
    100%{transform:translateY(420px) rotate(420deg);opacity:0;}
  }

  .win-toast{
    position:absolute;top:10%;left:50%;transform:translate(-50%,-10px);z-index:21;
    background:linear-gradient(160deg,#fff3c8,var(--gold));color:#3a2a06;font-weight:800;
    padding:8px 20px;border-radius:24px;font-size:1.05rem;letter-spacing:.03em;
    opacity:0;transition:opacity .25s, transform .25s;box-shadow:0 6px 20px rgba(0,0,0,.45);
    pointer-events:none;
  }
  .win-toast.show{opacity:1;transform:translate(-50%,0);}

  /* ---------- controls bar ---------- */
  .controls-bar{
    background:var(--navy-2);border-top:1px solid #1d2950;border-bottom:1px solid #1d2950;
    font-size:.85rem;
  }
  .stat-label{font-size:.65rem;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;font-weight:700;}
  .stat-value{font-weight:800;color:var(--gold);font-family:'JetBrains Mono',monospace;font-size:1.15rem;}
  .round-btn{
    width:42px;height:42px;border-radius:50%;background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);display:flex;align-items:center;justify-content:center;font-size:1rem;transition:.15s;
    cursor:pointer;
  }
  .round-btn:hover{background:#2a3a6e; transform:scale(1.05);}
  .round-btn.active{background:linear-gradient(145deg,var(--gold),var(--gold-deep));color:#2a1a00;}
  .bet-display{cursor:pointer;min-width:74px;text-align:center;padding:4px 8px;border-radius:6px;transition:all 0.15s;}
  .bet-display:hover{background:rgba(255,255,255,0.06);transform:scale(1.04);}

  .spin-btn{
    width:74px;height:74px;border-radius:50%;position:relative;
    background:radial-gradient(circle at 35% 30%, #ffe9a8, var(--gold-deep) 75%);
    border:3px solid #7a4a08;color:#3a2406;font-size:1.6rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 0 0 5px rgba(0,0,0,.25), 0 0 22px rgba(245,197,66,.6);
    transition:.15s;
    cursor:pointer;
  }
  .spin-btn::before{
    content:'';position:absolute;top:-7px;left:50%;transform:translateX(-50%);
    width:18px;height:10px;border-radius:6px 6px 0 0;background:#7a4a08;
  }
  .spin-btn:hover{transform:scale(1.06);box-shadow:0 0 0 6px rgba(0,0,0,.3), 0 0 28px rgba(245,197,66,.85);}
  .spin-btn:disabled{opacity:.55;cursor:not-allowed;}
  .spin-btn .spin-icon{display:inline-block;}
  .spin-btn.spinning .spin-icon{animation:spinRound .6s linear infinite;}
  @keyframes spinRound{to{transform:rotate(360deg);}}

  .meta-row{font-size:.65rem;color:#7e8fc0;}

  /* ---------- bottom bar ---------- */
  .bottom-bar{background:var(--navy-1);font-size:.78rem;color:#9fb0d8;}
  .bottom-bar input[type="search"]{background:#0c1530;border:1px solid #2a3a6e;color:var(--text-light);}

  @media (max-width:768px){
    .reel-frame{margin-top:40px;}
    .symbol-cell{height:74px;}
    .reel-col{height:222px;}
    .celebration-text{font-size:2rem;}
    .buy-bonus-btn{width:60px;height:60px;font-size:.55rem;}
  }

  /* Bet Popup Panel styles */
  .bet-popup-container {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translate(-50%, 15px) scale(0.95);
    background: linear-gradient(180deg, #26221c, #14120e);
    border: 2px solid #bda060;
    border-radius: 8px;
    padding: 12px;
    display: none;
    z-index: 1050;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.95);
    width: 290px;
    opacity: 0;
    transition: transform 0.15s ease-out, opacity 0.15s ease-out;
  }
  .bet-popup-container.show {
    display: block;
    transform: translate(-50%, 0) scale(1);
    opacity: 1;
  }
  .bet-grid-title {
    color: #ffd700;
    text-align: center;
    font-size: 0.95rem;
    font-weight: 800;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-family: 'Russo One', sans-serif;
  }
  .bet-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
  }
  .bet-grid-item {
    background: #1e1b15;
    color: #e4d5b2;
    text-align: center;
    padding: 12px 5px;
    font-size: 1.15rem;
    font-weight: 800;
    font-family: 'Russo One', sans-serif;
    cursor: pointer;
    border: 2px solid #4a3e25;
    border-radius: 6px;
    transition: all 0.15s;
    user-select: none;
  }
  .bet-grid-item:hover {
    background: #3e3524;
    color: #fff;
    border-color: #ffd700;
  }
  .bet-grid-item.active {
    background: #ffd700;
    color: #000;
    border-color: #ffffff;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
  }

  /* Modal Overlays */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.82);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    opacity: 0;
    transition: opacity 0.15s ease-out;
  }
  .modal-overlay.show {
    display: flex;
    opacity: 1;
  }
  .buy-bonus-modal {
    background: #1e1e17;
    border: 3px solid #bda060;
    border-radius: 12px;
    width: min(440px, 95%);
    box-shadow: 0 20px 50px rgba(0,0,0,0.95);
    overflow: hidden;
    position: relative;
    font-family: 'Russo One', sans-serif;
    transform: scale(0.92);
    transition: transform 0.15s ease-out;
  }
  .modal-overlay.show .buy-bonus-modal {
    transform: scale(1);
  }
  .modal-header {
    background: #12120e;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #5a4b2c;
  }
  .modal-title {
    color: #ffd700;
    font-size: 1.15rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .modal-close-btn {
    background: none;
    border: none;
    color: #a0957c;
    font-size: 1.4rem;
    cursor: pointer;
    line-height: 1;
    transition: color 0.15s;
  }
  .modal-close-btn:hover {
    color: #ffffff;
  }
  .modal-info-banner {
    background: #3c321e;
    color: #ebd18c;
    font-size: 0.75rem;
    padding: 8px 16px;
    text-align: center;
    border-bottom: 1px solid #5a4b2c;
    line-height: 1.4;
  }
  .modal-body {
    padding: 16px 22px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }
  .buy-play-btn {
    background: linear-gradient(180deg, #4cb81d, #25700e);
    border: 2px solid #a6e48c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 800;
    padding: 10px 30px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(37,112,14,0.4);
    transition: all 0.15s;
    text-transform: uppercase;
    margin-top: 10px;
    width: 100%;
    text-align: center;
  }
  .buy-play-btn:hover {
    background: linear-gradient(180deg, #59d522, #2d8611);
    box-shadow: 0 6px 20px rgba(37,112,14,0.6);
    transform: translateY(-1px);
  }

  /* left-panel layout */
  .left-panel {
    display: flex;
    flex-direction: var(--left-panel-direction);
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    z-index: 5;
  }
  .settings-sidebar {
    background: rgba(13, 17, 30, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    display: flex;
    flex-direction: var(--settings-sidebar-direction);
    gap: 8px;
    padding: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
    opacity: 1;
    transform: scale(1);
  }
  .settings-sidebar.hide {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
    height: 0;
    padding: 0;
    margin: 0;
    border: none;
  }
  .popover-item {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(180deg, #1c2c5a, #0d1a3a);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.15s;
  }
  .popover-item:hover {
    background: linear-gradient(180deg, #2c3e7a, #152554);
    border-color: #ffd700;
    transform: scale(1.05);
  }
  .quick-qty-btn {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    border-radius: 4px;
    padding: 4px 12px;
    font-size: 0.85rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.15s;
  }
  .quick-qty-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: #ffd700;
  }

  /* Paytable Table and Modal Items */
  .paytable-sym-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    width: 100%;
    max-height: 380px;
    overflow-y: auto;
  }
  .paytable-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(0,0,0,0.4);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 8px;
    padding: 8px 10px;
  }
  .paytable-item img {
    width: 44px;
    height: 44px;
    object-fit: cover;
    border-radius: 6px;
  }
</style>
</head>
<body>

@include('customer.header')

<div class="game-shell" style="width:100%;max-width:100%;margin:0;border-radius:0;">

  <!-- top navbar -->
  <div class="top-navbar d-flex align-items-center justify-content-between px-3 py-2">
    <div>🏠 / Slots / Top Picks / <strong>Boxing King™</strong></div>
    <input type="search" class="form-control form-control-sm" id="topSearchInput" placeholder="Search games (e.g. Aviator, Western)" onkeyup="filterGamesPrompt(event)">
  </div>

  <!-- title bar -->
  <div class="title-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-2">
      <div class="game-icon display-font"><i class="fas fa-crown"></i></div>
      <strong class="display-font" style="font-size: 1.1rem; color: #fff; letter-spacing: 0.5px;">Boxing King™</strong>
      <div class="form-check form-switch ms-3 d-flex align-items-center gap-2">
        <input class="form-check-input" type="checkbox" role="switch" id="realMoneyToggle" checked>
        <label class="form-check-label real-money-label" for="realMoneyToggle" id="modeSwitchLabel">REAL MONEY</label>
      </div>
    </div>
    <div class="d-flex gap-2">
      <button class="icon-btn" id="layoutBtn" title="Lobby" onclick="window.location.href='{{ route('dashboard') }}'">▦</button>
      <button class="icon-btn" id="fullscreenBtn" title="Fullscreen" onclick="toggleFullScreen()">⛶</button>
      <button class="icon-btn" id="reloadBtn" title="Reload game" onclick="window.location.reload()">↺</button>
      <button class="icon-btn" id="favBtn" title="Favorites" onclick="openFavoritesModal()">★</button>
      <button class="icon-btn" id="closeBtn" title="Close" onclick="window.location.href='{{ route('dashboard') }}'">✕</button>
    </div>
  </div>

  <div class="d-flex flex-grow-1" style="overflow: hidden; height: 0; min-height: 0;">

    <!-- Left sidebar with 100% functional interactive buttons -->
    <div class="sidebar d-flex flex-column align-items-center py-3 gap-2">
      <button class="sidebar-icon" id="sideFavBtn" title="Favorites" onclick="openFavoritesModal()"><i class="fas fa-heart"></i></button>
      <button class="sidebar-icon" id="sideLobbyBtn" title="Casino Lobby" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fas fa-grid-2"></i>▦</button>
      <button class="sidebar-icon" id="sideTurboBtn" title="Toggle Turbo Spin" onclick="toggleTurboMode()"><i class="fas fa-bolt"></i></button>
      <button class="sidebar-icon" id="sideTrophyBtn" title="Paytable & Leaderboard" onclick="openPaytableModal()"><i class="fas fa-trophy"></i></button>
      <button class="sidebar-icon active" id="sideGamesBtn" title="All 1xBet Games" onclick="openGamesSwitcherModal()"><i class="fas fa-gamepad"></i></button>
    </div>

    <!-- main stage (Boxing Arena with Cheering Audience, Spotlights & Flashing Lights) -->
    <div class="game-stage flex-grow-1">
      
      <!-- Atmosphere layer -->
      <div class="arena-atmosphere">
        <div class="spotlight-sweep spotlight-left"></div>
        <div class="spotlight-sweep spotlight-right"></div>
        
        <!-- Flashing photographer cameras in crowd -->
        <div class="camera-flash" style="top: 25%; left: 12%; animation-delay: 0.2s;"></div>
        <div class="camera-flash" style="top: 30%; right: 14%; animation-delay: 1.8s;"></div>
        <div class="camera-flash" style="top: 18%; left: 45%; animation-delay: 2.7s;"></div>
        <div class="camera-flash" style="top: 22%; right: 35%; animation-delay: 0.9s;"></div>
        <div class="camera-flash" style="top: 28%; left: 28%; animation-delay: 3.4s;"></div>

        <!-- Cheering crowd silhouette heads -->
        <div class="crowd-silhouette">
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
          <div class="crowd-head"></div><div class="crowd-head"></div><div class="crowd-head"></div>
        </div>
      </div>

      <div class="mini-logo display-font"><i class="fas fa-fire" style="color:#ef4444; margin-right:4px;"></i> BOXING KING</div>

      <div class="main-game-layout">
        <!-- Left Panel containing Buy Bonus & Settings Stack -->
        <div class="left-panel">
          <!-- buy-bonus-btn -->
          <button class="buy-bonus-btn" id="buyBonusBtn">BUY<br>BONUS</button>

          <!-- settings vertical sidebar panel -->
          <div class="settings-sidebar hide" id="settingsSidebar">
            <button class="popover-item" id="popoverAutoSpinBtn" title="AutoSpin Setting">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l.73-.73"/></svg>
            </button>
            <button class="popover-item" id="popoverInfoBtn" title="Paytable & Rules" onclick="openPaytableModal()">ℹ</button>
            <button class="popover-item" id="popoverSoundBtn" title="Mute/Unmute">🔊</button>
          </div>
        </div>

        <!-- 5x3 Reel Slot Cabinet Frame -->
        <div class="reel-frame">
          <div class="reels-row" id="reelsRow"></div>
        </div>
      </div>

      <div class="win-toast" id="winToast">+0.00 WIN</div>
      <div class="celebration-overlay" id="celebrationOverlay">
        <div class="celebration-text" id="celebrationText">BIG WIN!</div>
      </div>
      <div class="confetti-layer" id="confettiLayer"></div>

      <!-- Bet Selection Popup -->
      <div class="bet-popup-container" id="betPopup">
        <div class="bet-grid-title">Select Bet (৳)</div>
        <div class="bet-grid">
          <div class="bet-grid-item" data-value="1000">1,000</div>
          <div class="bet-grid-item" data-value="200">200</div>
          <div class="bet-grid-item" data-value="8">8</div>
          <div class="bet-grid-item" data-value="700">700</div>
          <div class="bet-grid-item" data-value="100">100</div>
          <div class="bet-grid-item" data-value="5">5</div>
          <div class="bet-grid-item" data-value="500">500</div>
          <div class="bet-grid-item" data-value="50">50</div>
          <div class="bet-grid-item" data-value="3">3</div>
          <div class="bet-grid-item" data-value="400">400</div>
          <div class="bet-grid-item" data-value="20">20</div>
          <div class="bet-grid-item" data-value="2">2</div>
          <div class="bet-grid-item" data-value="300">300</div>
          <div class="bet-grid-item" data-value="10">10</div>
          <div class="bet-grid-item" data-value="1">1</div>
        </div>
      </div>

      <!-- Buy Bonus Modal -->
      <div class="modal-overlay" id="buyBonusModalOverlay">
        <div class="buy-bonus-modal">
          <div class="modal-header">
            <h5 class="modal-title">Buy Bonus Feature</h5>
            <button class="modal-close-btn" id="closeBuyBonusModalBtn">&times;</button>
          </div>
          <div class="modal-info-banner">
            Click 'Buy & Play' to purchase and trigger Free Spin Combos instantly.
          </div>
          <div class="modal-body">
            <div class="coin-icon-container">
              <i class="fas fa-crown" style="font-size:2rem; color:#ffd700;"></i>
            </div>
            <div class="modal-row mt-2" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
              <span class="modal-label" style="color:#d8c89b; font-size:0.95rem;">Bet</span>
              <div class="modal-control" style="display:flex; align-items:center; background:#14120e; border:1px solid #4a3e25; border-radius:6px; overflow:hidden;">
                <button class="modal-control-btn" id="modalBetMinus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">-</button>
                <div class="modal-value" id="modalBetValue" style="color:#fff; width:60px; text-align:center; font-weight:bold;">3</div>
                <button class="modal-control-btn" id="modalBetPlus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">+</button>
              </div>
            </div>
            <div class="modal-row mt-2" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
              <span class="modal-label" style="color:#d8c89b; font-size:0.95rem;">Quantity</span>
              <div class="modal-control" style="display:flex; align-items:center; background:#14120e; border:1px solid #4a3e25; border-radius:6px; overflow:hidden;">
                <button class="modal-control-btn" id="modalQtyMinus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">-</button>
                <div class="modal-value" id="modalQtyValue" style="color:#fff; width:60px; text-align:center; font-weight:bold;">1</div>
                <button class="modal-control-btn" id="modalQtyPlus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">+</button>
              </div>
            </div>
            <div class="modal-row mt-3 pt-2 border-top border-secondary" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
              <span class="modal-label" style="color:#d8c89b;">Price</span>
              <span class="modal-display-val" id="modalPrice" style="color:#fff; font-weight:bold;">৳ 94.50</span>
            </div>
            <div class="modal-row mt-2" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
              <span class="modal-label" style="color:#d8c89b;">Total Price</span>
              <span class="modal-display-val" id="modalTotalPrice" style="color: #ffd700; font-size: 1.3rem; font-weight:bold;">৳ 94.50</span>
            </div>
            <button class="buy-play-btn" id="modalBuyPlayBtn">Buy & Play</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- AutoSpin Setting Modal -->
  <div class="modal-overlay" id="autoSpinModalOverlay">
    <div class="buy-bonus-modal" style="width: min(450px, 95%); max-height: 90vh; overflow-y: auto;">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <span class="modal-title display-font" style="font-size: 1.2rem;">AutoSpin Settings</span>
        <button class="modal-close-btn" id="closeAutoSpinModalBtn">&times;</button>
      </div>
      <div class="modal-body" style="font-size: 0.9rem; text-align: left;">
        
        <!-- Total Spins Row -->
        <div class="modal-row mt-3" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer; margin:0; color:#fff;">
            <input type="checkbox" id="chkTotalSpins" checked style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Total Auto Spins</span>
          </label>
          <div class="modal-control" style="display:flex; align-items:center; background:#14120e; border:1px solid #4a3e25; border-radius:6px; overflow:hidden;">
            <button class="modal-control-btn" id="autoSpinsMinus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">-</button>
            <div class="modal-value" id="autoSpinsValue" style="color:#fff; width: 50px; text-align:center; font-weight:bold;">50</div>
            <button class="modal-control-btn" id="autoSpinsPlus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">+</button>
          </div>
        </div>
        <!-- Quick buttons for Total Spins -->
        <div class="d-flex gap-2 justify-content-end mt-2 w-100">
          <button class="quick-qty-btn" id="quickSpin10">10</button>
          <button class="quick-qty-btn" id="quickSpin20">20</button>
          <button class="quick-qty-btn" id="quickSpin30">30</button>
          <button class="quick-qty-btn" id="quickSpin40">40</button>
          <button class="quick-qty-btn" id="quickSpin50">50</button>
        </div>

        <!-- Single Win Row -->
        <div class="modal-row mt-3" style="display:flex; justify-content:space-between; width:100%; align-items:center;">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer; margin:0; color:#fff;">
            <input type="checkbox" id="chkSingleWin" style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Stop on Single Win &gt;</span>
          </label>
          <div class="modal-control" style="display:flex; align-items:center; background:#14120e; border:1px solid #4a3e25; border-radius:6px; overflow:hidden;">
            <button class="modal-control-btn" id="singleWinMinus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">-</button>
            <div class="modal-value" id="singleWinValue" style="color:#fff; width: 80px; text-align:center; font-weight:bold;">100X</div>
            <button class="modal-control-btn" id="singleWinPlus" style="background:#362f22; border:none; color:#ffd700; width:36px; height:32px; font-weight:bold; cursor:pointer;">+</button>
          </div>
        </div>

        <!-- Cancel / Start Action buttons -->
        <div class="d-flex gap-3 mt-4 w-100">
          <button class="buy-play-btn" id="modalAutoCancelBtn" style="background: linear-gradient(180deg, #b81f2e, #85101a); border-color: #f59e9e; box-shadow: 0 4px 15px rgba(133,16,26,0.4);">Cancel</button>
          <button class="buy-play-btn" id="modalAutoStartBtn">Start AutoSpin</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Paytable & Multiplier Rules Modal -->
  <div class="modal-overlay" id="paytableModalOverlay">
    <div class="buy-bonus-modal" style="width:min(520px, 95%); background:#120e1e; border-color:#f5c542;">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#ffd700;"><i class="fas fa-trophy" style="color:#ffd700; margin-right:6px;"></i> Boxing King™ Paytable</h5>
        <button class="modal-close-btn" onclick="closePaytableModal()">&times;</button>
      </div>
      <div class="modal-info-banner" style="background:#221532; color:#e2d4f8;">
        Match 3 or more symbols on adjacent rows from left to right to trigger Fire-Burst combos!
      </div>
      <div class="modal-body" style="padding:16px;">
        <div class="paytable-sym-grid">
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/1.png') }}">
            <div><strong style="color:#ef4444;">Boxer Champion Red</strong><br><small style="color:#ffd700;">5x: 12x | 4x: 5x | 3x: 2.5x</small></div>
          </div>
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/2.png') }}">
            <div><strong style="color:#60a5fa;">Boxer Challenger Blue</strong><br><small style="color:#ffd700;">5x: 12x | 4x: 5x | 3x: 2.5x</small></div>
          </div>
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/3.png') }}">
            <div><strong style="color:#fbbf24;">Gold Championship Belt</strong><br><small style="color:#ffd700;">5x: 10x | 4x: 4x | 3x: 2x</small></div>
          </div>
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/4.png') }}">
            <div><strong style="color:#f87171;">Boxing Gloves</strong><br><small style="color:#ffd700;">5x: 8x | 4x: 3.5x | 3x: 1.8x</small></div>
          </div>
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/11.png') }}">
            <div><strong style="color:#34d399;">Scatter Ring Bell</strong><br><small style="color:#34d399;">3+ Hits Free Spins + 25x</small></div>
          </div>
          <div class="paytable-item">
            <img src="{{ asset('assets/image/BoxingKing/12.png') }}">
            <div><strong style="color:#e879f9;">Wild Knockout</strong><br><small style="color:#e879f9;">Substitutes all symbols</small></div>
          </div>
        </div>
        <button class="btn btn-warning w-100 mt-3 font-weight-bold" onclick="closePaytableModal()" style="font-weight:800;">Got It!</button>
      </div>
    </div>
  </div>

  <!-- 1xBet Quick Games Switcher Modal -->
  <div class="modal-overlay" id="gamesSwitcherModalOverlay">
    <div class="buy-bonus-modal" style="width:min(500px, 95%); background:#0f172a; border-color:#38bdf8;">
      <div class="modal-header" style="background:#0b1329;">
        <h5 class="modal-title" style="color:#38bdf8;"><i class="fas fa-gamepad" style="margin-right:6px;"></i> 1xBet Casino Games</h5>
        <button class="modal-close-btn" onclick="closeGamesSwitcherModal()">&times;</button>
      </div>
      <div class="modal-body" style="padding:16px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; width:100%;">
          <a href="{{ route('boxing-king') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-danger" style="text-decoration:none;">
            <i class="fas fa-crown text-danger"></i> <div><strong class="d-block text-white" style="font-size:12px;">Boxing King™</strong><small class="text-muted">Active Slot</small></div>
          </a>
          <a href="{{ route('western') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-warning" style="text-decoration:none;">
            <i class="fas fa-hat-cowboy text-warning"></i> <div><strong class="d-block text-white" style="font-size:12px;">Western Vault™</strong><small class="text-muted">High Payout</small></div>
          </a>
          <a href="{{ route('play') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-info" style="text-decoration:none;">
            <i class="fas fa-plane-departure text-info"></i> <div><strong class="d-block text-white" style="font-size:12px;">Aviator Crash</strong><small class="text-muted">Multiplier</small></div>
          </a>
          <a href="{{ route('gates-of-olympus') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-primary" style="text-decoration:none;">
            <i class="fas fa-bolt text-primary"></i> <div><strong class="d-block text-white" style="font-size:12px;">Olympus Gold™</strong><small class="text-muted">Cascading</small></div>
          </a>
          <a href="{{ route('gems-mines') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-success" style="text-decoration:none;">
            <i class="fas fa-gem text-success"></i> <div><strong class="d-block text-white" style="font-size:12px;">Gems & Mines</strong><small class="text-muted">Classic</small></div>
          </a>
          <a href="{{ route('big-bass-splash') }}" class="btn btn-dark text-start p-2 d-flex align-items-center gap-2 border-secondary" style="text-decoration:none;">
            <i class="fas fa-fish text-success"></i> <div><strong class="d-block text-white" style="font-size:12px;">Big Bass Splash</strong><small class="text-muted">Free Spins</small></div>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Deposit Popup Modal (1xBet Cashier Style) -->
  <div class="modal-overlay" id="deposit-popup-modal" style="display:none;">
    <div class="buy-bonus-modal" style="width:min(460px, 95%); background: #14101e; border: 2px solid #f5c542; box-shadow: 0 20px 60px rgba(0,0,0,0.95);">
      <div class="modal-header" style="background:#1f1630; border-bottom:1px solid #3c2a5e;">
        <div class="d-flex align-items-center gap-2">
          <span style="font-size:1.3rem;">💳</span>
          <h5 class="modal-title" style="font-size:1.15rem; color:#ffd700;">Deposit to Continue Playing</h5>
        </div>
        <button class="modal-close-btn" onclick="closeDepositModal()">&times;</button>
      </div>
      <div class="modal-info-banner" id="depositModalBanner" style="background:#301b2a; color:#fca5a5; font-size:0.8rem; border-bottom:1px solid #5a2838;">
        আপনার ডেমো খেলার লিমিট শেষ! আসল টাকা জিতে ওয়ালেটে নিতে এখনই ডিপোজিট করুন।
      </div>
      <div class="modal-body" style="padding:18px 22px;">
        <p style="font-size:0.85rem; color:#cbd5e1; margin-bottom:12px; text-align:center;">
          Choose your instant payment method to credit your real wallet:
        </p>

        <!-- Gateway Pills -->
        <div class="d-flex gap-2 w-100 mb-3 justify-content-center">
          <button type="button" class="btn btn-sm btn-outline-warning active px-3" onclick="selectDepositGateway('bKash', this)" style="font-weight:700;">bKash</button>
          <button type="button" class="btn btn-sm btn-outline-warning px-3" onclick="selectDepositGateway('Nagad', this)" style="font-weight:700;">Nagad</button>
          <button type="button" class="btn btn-sm btn-outline-warning px-3" onclick="selectDepositGateway('Rocket', this)" style="font-weight:700;">Rocket</button>
          <button type="button" class="btn btn-sm btn-outline-warning px-3" onclick="selectDepositGateway('Binance', this)" style="font-weight:700;">Binance</button>
        </div>

        <div style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:12px; width:100%; margin-bottom:14px; text-align:center;">
          <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">Admin Cashier Number (<span id="depGatewayName">bKash</span>)</div>
          <div style="font-size:1.15rem; font-weight:800; color:#ffd700; font-family:'JetBrains Mono',monospace; margin:4px 0;" id="depGatewayNumber">01700000000</div>
          <small style="font-size:0.7rem; color:#6ee7b7;">Send Money to this number & submit Transaction ID below.</small>
        </div>

        <form action="{{ route('dashboard.deposit') }}" method="POST" style="width:100%;">
          @csrf
          <input type="hidden" name="gateway" id="depGatewayInput" value="bKash">
          <div class="mb-2 text-start">
            <label style="font-size:0.75rem; color:#cbd5e1; font-weight:700; display:block; margin-bottom:4px;">Deposit Amount (৳):</label>
            <input type="number" name="amount" class="form-control form-control-sm bg-dark text-white border-secondary" min="100" max="50000" value="500" required style="font-family:'JetBrains Mono',monospace;">
          </div>
          <div class="mb-3 text-start">
            <label style="font-size:0.75rem; color:#cbd5e1; font-weight:700; display:block; margin-bottom:4px;">Transaction ID / TrxID:</label>
            <input type="text" name="transaction_id" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="e.g. 9J82XX71Q" required style="font-family:'JetBrains Mono',monospace;">
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary flex-grow-1" onclick="closeDepositModal()" style="font-weight:700; font-size:0.9rem;">Cancel</button>
            <button type="submit" class="btn btn-success flex-grow-1" style="font-weight:800; font-size:0.9rem; background:linear-gradient(135deg, #10b981, #059669); border:none;">Submit Deposit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- controls bar (100% interactive & responsive) -->
  <div class="controls-bar d-flex align-items-center justify-content-center gap-4 px-3 py-2 flex-wrap" style="position: relative;">
    <button class="round-btn" id="settingsBtn" title="Settings">⚙</button>

    <div class="text-center" style="min-width: 100px;">
      <div class="stat-label" id="balanceLabel">main balance</div>
      <div class="stat-value" id="balanceValue">৳ 0.00</div>
    </div>

    <div class="text-center bet-display" id="betDisplay" title="Click to change bet">
      <div class="stat-label">Bet</div>
      <div class="stat-value" id="betValue">3</div>
    </div>

    <div class="text-center" style="min-width: 80px;">
      <div class="stat-label">Win</div>
      <div class="stat-value" id="winValue">৳ 0.00</div>
    </div>

    <button class="round-btn" id="turboBtn" title="Turbo spin (Instant Reel Spin)">⚡</button>
    <div class="text-center">
      <button class="round-btn" id="autoplayBtn" title="Tap to autoplay">↻</button>
      <div class="meta-row mt-1">Autoplay</div>
    </div>

    <button class="spin-btn" id="spinBtn" title="Spin Reel"><span class="spin-icon">⟳</span></button>

    <button class="round-btn" id="wifiBtn" title="Live Connection: 99.9% Online" onclick="showLiveToast('Connected to 1xBet Game Engine: Latency 24ms')">📶</button>
  </div>

  <div class="d-flex justify-content-between px-3 py-1 meta-row" style="background:#070b18;">
    <span id="versionText">Boxing King™ v_2.5_official</span>
    <span id="txnText">Transaction —</span>
  </div>

  <!-- bottom bar with functional tabs -->
  <div class="bottom-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex gap-3">
      <span style="cursor: pointer; font-weight:700;" onclick="openGamesSwitcherModal()"><i class="fas fa-clock-rotate-left"></i> RECENT GAMES</span>
      <span style="cursor: pointer; font-weight:700;" onclick="openFavoritesModal()"><i class="fas fa-star text-warning"></i> FAVORITES</span>
    </div>
    <input type="search" class="form-control form-control-sm" style="max-width:220px" placeholder="Search other games" onkeyup="filterGamesPrompt(event)">
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const COLS = 5, ROWS = 3;
  const reelsRow = document.getElementById('reelsRow');
  const spinBtn = document.getElementById('spinBtn');
  const winToast = document.getElementById('winToast');
  const balanceEl = document.getElementById('balanceValue');
  const balanceLabelEl = document.getElementById('balanceLabel');
  const betEl = document.getElementById('betValue');
  const winEl = document.getElementById('winValue');
  const txnText = document.getElementById('txnText');
  const celebrationOverlay = document.getElementById('celebrationOverlay');
  const celebrationText = document.getElementById('celebrationText');
  const confettiLayer = document.getElementById('confettiLayer');
  const turboBtn = document.getElementById('turboBtn');
  const autoplayBtn = document.getElementById('autoplayBtn');
  const buyBonusBtn = document.getElementById('buyBonusBtn');
  const betDisplay = document.getElementById('betDisplay');
  const realMoneyToggle = document.getElementById('realMoneyToggle');
  const modeSwitchLabel = document.getElementById('modeSwitchLabel');

  const settingsBtn = document.getElementById('settingsBtn');
  const settingsSidebar = document.getElementById('settingsSidebar');
  const popoverAutoSpinBtn = document.getElementById('popoverAutoSpinBtn');
  const popoverInfoBtn = document.getElementById('popoverInfoBtn');
  const popoverSoundBtn = document.getElementById('popoverSoundBtn');
  
  const autoSpinModalOverlay = document.getElementById('autoSpinModalOverlay');
  const closeAutoSpinModalBtn = document.getElementById('closeAutoSpinModalBtn');
  const chkTotalSpins = document.getElementById('chkTotalSpins');
  const autoSpinsMinus = document.getElementById('autoSpinsMinus');
  const autoSpinsValue = document.getElementById('autoSpinsValue');
  const autoSpinsPlus = document.getElementById('autoSpinsPlus');
  
  const chkSingleWin = document.getElementById('chkSingleWin');
  const singleWinMinus = document.getElementById('singleWinMinus');
  const singleWinValue = document.getElementById('singleWinValue');
  const singleWinPlus = document.getElementById('singleWinPlus');
  
  const modalAutoCancelBtn = document.getElementById('modalAutoCancelBtn');
  const modalAutoStartBtn = document.getElementById('modalAutoStartBtn');

  // Synthesized Web Audio Sound Effects
  let soundEnabled = true;
  let audioCtx = null;

  function playSound(type) {
    if (!soundEnabled) return;
    try {
      if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      }
      if (audioCtx.state === 'suspended') {
        audioCtx.resume();
      }

      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.connect(gain);
      gain.connect(audioCtx.destination);

      if (type === 'spin') {
        const now = audioCtx.currentTime;
        osc.type = 'sine';
        osc.frequency.setValueAtTime(160, now);
        osc.frequency.exponentialRampToValueAtTime(750, now + 0.4);
        gain.gain.setValueAtTime(0.12, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.4);
        osc.start(now);
        osc.stop(now + 0.4);
      } else if (type === 'stop') {
        const now = audioCtx.currentTime;
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(120, now);
        osc.frequency.exponentialRampToValueAtTime(30, now + 0.08);
        gain.gain.setValueAtTime(0.15, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.08);
        osc.start(now);
        osc.stop(now + 0.08);
      } else if (type === 'win') {
        const now = audioCtx.currentTime;
        osc.type = 'sine';
        osc.frequency.setValueAtTime(587.33, now);
        gain.gain.setValueAtTime(0.18, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.25);
        osc.start(now);
        osc.stop(now + 0.25);
      }
    } catch (e) {
      console.warn("Audio Context failed:", e);
    }
  }

  // ==========================================
  // LARAVEL DATABASE & STATE INTEGRATION
  // ==========================================
  const userCurrency = "{{ auth()->user()->currency ?? 'BDT' }}";
  const currencySymbol = '৳ ';

  let realBalance = parseFloat("{{ auth()->user()->balance ?? '0' }}");
  let isDemoMode = new URLSearchParams(window.location.search).get('demo') === '1';
  let demoBalance = 1000.00;
  let demoSpinsDone = 0;
  let balance = isDemoMode ? demoBalance : realBalance;

  const betLevels = [1, 2, 3, 5, 8, 10, 20, 50, 100, 200, 300, 400, 500, 700, 1000];
  let betIndex = 2;
  let bet = betLevels[betIndex];
  let spinning = false;
  let turbo = false;
  let autoplay = false;
  let autoplayTimer = null;
  let bonusSpinsQueue = 0;
  let autoplaySpinsRemaining = 0;

  // Audio elements
  const audioSpin = new Audio();
  const audioWin = new Audio();
  const audioFire = new Audio();

  // Helper modals
  window.openFavoritesModal = function() {
    document.getElementById('gamesSwitcherModalOverlay').classList.add('show');
  };
  window.openGamesSwitcherModal = function() {
    document.getElementById('gamesSwitcherModalOverlay').classList.add('show');
  };
  window.closeGamesSwitcherModal = function() {
    document.getElementById('gamesSwitcherModalOverlay').classList.remove('show');
  };
  window.openPaytableModal = function() {
    document.getElementById('paytableModalOverlay').classList.add('show');
  };
  window.closePaytableModal = function() {
    document.getElementById('paytableModalOverlay').classList.remove('show');
  };
  window.toggleTurboMode = function() {
    turbo = !turbo;
    turboBtn.classList.toggle('active', turbo);
    showLiveToast(turbo ? '⚡ Turbo Spin Enabled' : 'Turbo Spin Disabled');
  };
  window.showLiveToast = function(msg) {
    winToast.textContent = msg;
    winToast.classList.add('show');
    setTimeout(() => winToast.classList.remove('show'), 1500);
  };
  window.filterGamesPrompt = function(e) {
    if (e.key === 'Enter') {
      window.location.href = "{{ route('dashboard') }}?q=" + encodeURIComponent(e.target.value);
    }
  };

  // Gateway switcher for deposit modal
  window.selectDepositGateway = function(gw, btn) {
    document.querySelectorAll('#deposit-popup-modal .btn-outline-warning').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    document.getElementById('depGatewayName').textContent = gw;
    document.getElementById('depGatewayInput').value = gw;

    const numbers = {
      'bKash': '01700000000',
      'Nagad': '01800000000',
      'Rocket': '01900000000',
      'Binance': 'pay@ringking'
    };
    document.getElementById('depGatewayNumber').textContent = numbers[gw] || '01700000000';
  };

  window.openDepositModal = function(msg) {
    const modal = document.getElementById('deposit-popup-modal');
    if (modal) {
      if (msg) document.getElementById('depositModalBanner').textContent = msg;
      modal.style.display = 'flex';
      modal.offsetHeight;
      modal.classList.add('show');
    }
  };

  window.closeDepositModal = function() {
    const modal = document.getElementById('deposit-popup-modal');
    if (modal) {
      modal.classList.remove('show');
      setTimeout(() => { modal.style.display = 'none'; }, 150);
    }
  };

  function updateModeUI() {
    if (isDemoMode) {
      realMoneyToggle.checked = false;
      modeSwitchLabel.textContent = 'DEMO MODE';
      balanceLabelEl.textContent = 'demo balance';
      balance = demoBalance;
    } else {
      realMoneyToggle.checked = true;
      modeSwitchLabel.textContent = 'REAL MONEY';
      balanceLabelEl.textContent = 'main balance';
      balance = realBalance;
    }
    balanceEl.textContent = currencySymbol + formatMoney(balance);
    syncHeaderBalance();
  }

  function syncHeaderBalance() {
    const headerBalance = document.querySelector('.header-balance-value');
    if (headerBalance) {
      headerBalance.textContent = formatMoney(realBalance);
    }
  }

  realMoneyToggle.addEventListener('change', function() {
    if (spinning) {
      realMoneyToggle.checked = !realMoneyToggle.checked;
      return;
    }
    isDemoMode = !realMoneyToggle.checked;
    updateModeUI();
    showLiveToast(isDemoMode ? 'Switched to Demo Trial Mode' : 'Switched to Real Money Wallet');
  });

  // Build reel columns
  const colEls = [];
  const cellEls = [];
  for (let c = 0; c < COLS; c++){
    const col = document.createElement('div');
    col.className = 'reel-col';
    for (let r = 0; r < ROWS; r++){
      const cell = document.createElement('div');
      cell.className = 'symbol-cell slot-cell';
      cell.setAttribute('data-col', c);
      cell.setAttribute('data-row', r);
      const defaultSym = ['1', '2', '3', '4', '7', '8', '9', '10', '11', '12'][Math.floor(Math.random()*10)];
      cell.innerHTML = `<div class="symbol"><img src="{{ asset('assets/image/BoxingKing') }}/${defaultSym}.png" style="width:100%;height:100%;object-fit:cover;"></div>`;
      col.appendChild(cell);
      cellEls.push(cell);
    }
    reelsRow.appendChild(col);
    colEls.push(col);
  }

  function formatMoney(n){ return parseFloat(n).toFixed(2); }
  function randomTxnId(){
    return 'TXN-' + Math.floor(10000+Math.random()*89999) + '-' + Math.floor(100000+Math.random()*899999);
  }

  function showWinToast(amount){
    winToast.textContent = `+${currencySymbol}${formatMoney(amount)} WIN`;
    winToast.classList.add('show');
    setTimeout(()=> winToast.classList.remove('show'), 1500);
  }

  // Celebration trigger
  function showCelebration(text, duration){
    celebrationText.textContent = text;
    celebrationOverlay.classList.add('show');
    spawnConfetti();
    setTimeout(()=> celebrationOverlay.classList.remove('show'), duration);
  }

  function spawnConfetti(){
    const colors = ['#f5c542','#c0203a','#2a6fd8','#3aa65a','#fff3c8'];
    for (let i = 0; i < 22; i++){
      const piece = document.createElement('div');
      piece.className = 'confetti-piece';
      piece.style.left = Math.random()*100 + '%';
      piece.style.background = colors[Math.floor(Math.random()*colors.length)];
      const dur = 0.9 + Math.random()*0.6;
      piece.style.animationDuration = dur + 's';
      piece.style.animationDelay = (Math.random()*0.2) + 's';
      confettiLayer.appendChild(piece);
      setTimeout(()=> piece.remove(), (dur+0.3)*1000);
    }
  }

  function setBusy(isBusy){
    spinning = isBusy;
    spinBtn.disabled = isBusy;
    spinBtn.classList.toggle('spinning', isBusy);
  }

  function renderGridImages(grid) {
    for (let r = 0; r < ROWS; r++) {
      for (let c = 0; c < COLS; c++) {
        const symVal = grid[r][c];
        const cell = document.querySelector(`.symbol-cell[data-row="${r}"][data-col="${c}"]`);
        if (cell) {
          const src = `{{ asset('assets/image/BoxingKing') }}/${symVal}.png`;
          cell.innerHTML = `<div class="symbol" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                              <img src="${src}" style="width:100%; height:100%; object-fit:cover;" draggable="false">
                            </div>`;
        }
      }
    }
  }

  function spin(){
    if (spinning) return;

    let isPaidSpin = true;
    if (bonusSpinsQueue > 0) {
      bonusSpinsQueue--;
      isPaidSpin = false;
    }

    if (isPaidSpin) {
      if (isDemoMode && demoBalance < bet) {
        openDepositModal("আপনার ডেমো ব্যালেন্স শেষ! ডিপোজিট করে আসল ব্যালেন্সে খেলুন।");
        stopAutoplay();
        return;
      }
      if (!isDemoMode && realBalance < bet) {
        openDepositModal("আপনার পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।");
        stopAutoplay();
        return;
      }
    }

    setBusy(true);

    // 1. Clear previous win effects and apply blur
    cellEls.forEach(cell => {
      cell.classList.remove('cell-win', 'cell-scatter-win', 'cell-on-fire', 'reel-blur');
      cell.classList.add('reel-blur');
      const flames = cell.querySelector('.flames-container');
      if (flames) flames.remove();
    });
    colEls.forEach(col => col.classList.add('spinning'));

    playSound('spin');

    // 2. Call backend atomic spin endpoint
    fetch("{{ route('boxing.spin') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        bet_amount: bet,
        is_demo: isDemoMode,
        demo_spins_count: demoSpinsDone
      })
    })
    .then(res => res.json())
    .then(data => {
      // Demo limit hit
      if (data.status === 'deposit_required') {
        cellEls.forEach(cell => cell.classList.remove('reel-blur'));
        colEls.forEach(col => col.classList.remove('spinning'));
        setBusy(false);
        stopAutoplay();
        openDepositModal(data.message);
        return;
      }

      if (data.error) {
        cellEls.forEach(cell => cell.classList.remove('reel-blur'));
        colEls.forEach(col => col.classList.remove('spinning'));
        setBusy(false);
        stopAutoplay();
        alert(data.error);
        return;
      }

      // Play custom spin sound from backend if available
      if (data.audio && data.audio.spin) {
        audioSpin.src = data.audio.spin;
        audioSpin.play().catch(()=>{});
      }

      const spinDuration = turbo ? 300 : 1200;

      setTimeout(() => {
        cellEls.forEach(cell => cell.classList.remove('reel-blur'));
        colEls.forEach(col => {
          col.classList.remove('spinning');
          col.classList.add('settle');
          setTimeout(() => col.classList.remove('settle'), 400);
        });

        audioSpin.pause();
        audioSpin.currentTime = 0;
        playSound('stop');

        // Render grid images
        if (data.grid) {
          renderGridImages(data.grid);
        }

        // Update Balance
        if (isDemoMode) {
          demoSpinsDone++;
          demoBalance = demoBalance - bet + (data.win_amount || 0);
          balance = demoBalance;
          balanceEl.textContent = currencySymbol + formatMoney(demoBalance);
        } else if (data.new_balance !== null && data.new_balance !== undefined) {
          realBalance = parseFloat(data.new_balance);
          balance = realBalance;
          balanceEl.textContent = currencySymbol + formatMoney(realBalance);
          syncHeaderBalance();
        }

        winEl.textContent = currencySymbol + formatMoney(data.win_amount || 0);

        // 3. Winning handling & Fire-Burst effects
        if (data.is_win) {
          if (data.audio && data.audio.fire) {
            audioFire.src = data.audio.fire;
            audioFire.play().catch(()=>{});
          } else if (data.audio && data.audio.win) {
            audioWin.src = data.audio.win;
            audioWin.play().catch(()=>{});
          } else {
            playSound('win');
          }

          // Trigger fire burst on winning cells
          if (data.winning_cells && Array.isArray(data.winning_cells)) {
            data.winning_cells.forEach(pos => {
              const r = pos[0];
              const c = pos[1];
              const cell = document.querySelector(`.symbol-cell[data-row="${r}"][data-col="${c}"]`);
              if (cell) {
                cell.classList.add('cell-on-fire');
                if (!cell.querySelector('.flames-container')) {
                  const flames = document.createElement('div');
                  flames.className = 'flames-container';
                  flames.innerHTML = '<div class="flame"></div><div class="flame"></div><div class="flame"></div>';
                  cell.appendChild(flames);
                }
              }
            });
          }

          showWinToast(data.win_amount);
          if (data.win_amount >= bet * 5) {
            showCelebration('🔥 KNOCKOUT WIN! 🔥', 2200);
          } else {
            showCelebration('WIN!', 1500);
          }
        }

        txnText.textContent = 'Transaction ' + randomTxnId();
        setBusy(false);

        // Autoplay queue handling
        if (bonusSpinsQueue > 0) {
          autoplayTimer = setTimeout(() => { spin(); }, turbo ? 250 : 550);
        } else if (autoplay) {
          let shouldStopAutoplay = false;
          if (chkTotalSpins.checked) {
            autoplaySpinsRemaining--;
            if (autoplaySpinsRemaining <= 0) shouldStopAutoplay = true;
          }
          if (chkSingleWin.checked) {
            const ratioLimit = parseInt(singleWinValue.textContent) || 100;
            if (data.win_amount >= bet * ratioLimit) shouldStopAutoplay = true;
          }

          if (shouldStopAutoplay) {
            stopAutoplay();
          } else {
            autoplayTimer = setTimeout(() => {
              if (autoplay) spin();
              else stopAutoplay();
            }, turbo ? 250 : 600);
          }
        }
      }, spinDuration);
    })
    .catch(err => {
      cellEls.forEach(cell => cell.classList.remove('reel-blur'));
      colEls.forEach(col => col.classList.remove('spinning'));
      setBusy(false);
      stopAutoplay();
      console.error('Spin fetch error:', err);
    });
  }

  spinBtn.addEventListener('click', spin);

  // ---- bet selection popup ----
  const betPopup = document.getElementById('betPopup');

  function updateBet(value) {
    bet = value;
    betIndex = betLevels.indexOf(value);
    betEl.textContent = bet;
    
    // Highlight the active item in the grid
    document.querySelectorAll('.bet-grid-item').forEach(item => {
      if (parseInt(item.getAttribute('data-value')) === bet) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  function openBetPopup() {
    betPopup.style.display = 'block';
    betPopup.offsetHeight;
    betPopup.classList.add('show');
  }

  function closeBetPopup() {
    betPopup.classList.remove('show');
    setTimeout(() => {
      if (!betPopup.classList.contains('show')) {
        betPopup.style.display = 'none';
      }
    }, 150);
  }

  betDisplay.addEventListener('click', (e) => {
    e.stopPropagation();
    if (spinning) return;
    const isOpen = betPopup.classList.contains('show');
    if (isOpen) {
      closeBetPopup();
    } else {
      openBetPopup();
    }
  });

  document.addEventListener('click', (e) => {
    if (betPopup.classList.contains('show') && !betPopup.contains(e.target) && !betDisplay.contains(e.target)) {
      closeBetPopup();
    }
  });

  document.querySelectorAll('.bet-grid-item').forEach(item => {
    item.addEventListener('click', (e) => {
      e.stopPropagation();
      const val = parseInt(item.getAttribute('data-value'));
      updateBet(val);
      closeBetPopup();
    });
  });

  // ---- turbo ----
  turboBtn.addEventListener('click', toggleTurboMode);

  // ---- autoplay ----
  function stopAutoplay(){
    autoplay = false;
    autoplayBtn.classList.remove('active');
    if (autoplayTimer) clearTimeout(autoplayTimer);
  }
  autoplayBtn.addEventListener('click', () => {
    autoplay = !autoplay;
    autoplayBtn.classList.toggle('active', autoplay);
    if (autoplay && !spinning) spin();
  });

  // ---- buy bonus modal controls ----
  const buyBonusModalOverlay = document.getElementById('buyBonusModalOverlay');
  const closeBuyBonusModalBtn = document.getElementById('closeBuyBonusModalBtn');
  const modalBetMinus = document.getElementById('modalBetMinus');
  const modalBetPlus = document.getElementById('modalBetPlus');
  const modalBetValue = document.getElementById('modalBetValue');
  const modalQtyMinus = document.getElementById('modalQtyMinus');
  const modalQtyPlus = document.getElementById('modalQtyPlus');
  const modalQtyValue = document.getElementById('modalQtyValue');
  const modalPrice = document.getElementById('modalPrice');
  const modalTotalPrice = document.getElementById('modalTotalPrice');
  const modalBuyPlayBtn = document.getElementById('modalBuyPlayBtn');

  let modalBet = bet;
  let modalQty = 1;

  function refreshBuyBonusModal() {
    modalBetValue.textContent = modalBet;
    modalQtyValue.textContent = modalQty;
    
    const priceVal = modalBet * 31.5;
    const totalVal = priceVal * modalQty;
    
    modalPrice.textContent = currencySymbol + formatMoney(priceVal);
    modalTotalPrice.textContent = currencySymbol + formatMoney(totalVal);
  }

  modalBetMinus.addEventListener('click', () => {
    let idx = betLevels.indexOf(modalBet);
    if (idx > 0) {
      modalBet = betLevels[idx - 1];
      refreshBuyBonusModal();
    }
  });

  modalBetPlus.addEventListener('click', () => {
    let idx = betLevels.indexOf(modalBet);
    if (idx < betLevels.length - 1) {
      modalBet = betLevels[idx + 1];
      refreshBuyBonusModal();
    }
  });

  modalQtyMinus.addEventListener('click', () => {
    if (modalQty > 1) {
      modalQty--;
      refreshBuyBonusModal();
    }
  });

  modalQtyPlus.addEventListener('click', () => {
    if (modalQty < 99) {
      modalQty++;
      refreshBuyBonusModal();
    }
  });

  buyBonusBtn.addEventListener('click', () => {
    if (spinning) return;
    modalBet = bet;
    modalQty = 1;
    refreshBuyBonusModal();
    buyBonusModalOverlay.style.display = 'flex';
    buyBonusModalOverlay.offsetHeight;
    buyBonusModalOverlay.classList.add('show');
  });

  closeBuyBonusModalBtn.addEventListener('click', () => {
    closeBuyBonusModal();
  });

  function closeBuyBonusModal() {
    buyBonusModalOverlay.classList.remove('show');
    setTimeout(() => {
      if (!buyBonusModalOverlay.classList.contains('show')) {
        buyBonusModalOverlay.style.display = 'none';
      }
    }, 150);
  }

  modalBuyPlayBtn.addEventListener('click', () => {
    const cost = modalBet * 31.5 * modalQty;
    if (balance < cost) {
      openDepositModal("Insufficient balance for Buy Bonus!");
      return;
    }
    
    // Deduct total cost
    balance -= cost;
    if (isDemoMode) {
      demoBalance = balance;
    } else {
      realBalance = balance;
      syncHeaderBalance();
    }
    balanceEl.textContent = currencySymbol + formatMoney(balance);
    
    updateBet(modalBet);
    closeBuyBonusModal();
    
    bonusSpinsQueue = modalQty;
    spin();
  });

  // ---- settings sidebar & autospin controls ----
  settingsBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    settingsSidebar.classList.toggle('hide');
  });

  popoverSoundBtn.addEventListener('click', () => {
    soundEnabled = !soundEnabled;
    popoverSoundBtn.textContent = soundEnabled ? '🔊' : '🔇';
    showLiveToast(soundEnabled ? '🔊 Audio Enabled' : '🔇 Audio Muted');
  });

  // Open / Close AutoSpin modal
  popoverAutoSpinBtn.addEventListener('click', () => {
    if (spinning) return;
    
    chkTotalSpins.checked = true;
    autoSpinsValue.textContent = '50';
    
    autoSpinModalOverlay.style.display = 'flex';
    autoSpinModalOverlay.offsetHeight;
    autoSpinModalOverlay.classList.add('show');
  });

  closeAutoSpinModalBtn.addEventListener('click', () => {
    closeAutoSpinModal();
  });
  
  modalAutoCancelBtn.addEventListener('click', () => {
    closeAutoSpinModal();
  });

  function closeAutoSpinModal() {
    autoSpinModalOverlay.classList.remove('show');
    setTimeout(() => {
      if (!autoSpinModalOverlay.classList.contains('show')) {
        autoSpinModalOverlay.style.display = 'none';
      }
    }, 150);
  }

  // Quick total spins buttons
  document.getElementById('quickSpin10').addEventListener('click', () => { autoSpinsValue.textContent = '10'; });
  document.getElementById('quickSpin20').addEventListener('click', () => { autoSpinsValue.textContent = '20'; });
  document.getElementById('quickSpin30').addEventListener('click', () => { autoSpinsValue.textContent = '30'; });
  document.getElementById('quickSpin40').addEventListener('click', () => { autoSpinsValue.textContent = '40'; });
  document.getElementById('quickSpin50').addEventListener('click', () => { autoSpinsValue.textContent = '50'; });

  autoSpinsMinus.addEventListener('click', () => {
    let val = parseInt(autoSpinsValue.textContent) || 10;
    if (val > 10) autoSpinsValue.textContent = val - 10;
  });

  autoSpinsPlus.addEventListener('click', () => {
    let val = parseInt(autoSpinsValue.textContent) || 10;
    if (val < 1000) autoSpinsValue.textContent = val + 10;
  });

  singleWinMinus.addEventListener('click', () => {
    let val = parseInt(singleWinValue.textContent) || 10;
    if (val > 10) singleWinValue.textContent = (val - 10) + 'X';
  });
  singleWinPlus.addEventListener('click', () => {
    let val = parseInt(singleWinValue.textContent) || 10;
    singleWinValue.textContent = (val + 10) + 'X';
  });

  modalAutoStartBtn.addEventListener('click', () => {
    closeAutoSpinModal();
    if (spinning) return;
    
    autoplay = true;
    autoplayBtn.classList.add('active');
    
    if (chkTotalSpins.checked) {
      autoplaySpinsRemaining = parseInt(autoSpinsValue.textContent) || 50;
    } else {
      autoplaySpinsRemaining = 99999;
    }
    
    spin();
  });

  // Fullscreen support
  window.toggleFullScreen = function() {
    const shell = document.querySelector('.game-shell');
    if (!document.fullscreenElement) {
      shell.requestFullscreen?.().catch(err => {});
    } else {
      document.exitFullscreen?.().catch(err => {});
    }
  };

  // Initial load
  txnText.textContent = 'Transaction ' + randomTxnId();
  updateBet(bet);
  updateModeUI();

})();
</script>
</body>
</html>
