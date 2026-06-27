<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Ring Champion™ — Slot Game UI</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
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
    background:linear-gradient(145deg,var(--gold),var(--gold-deep));
    display:flex;align-items:center;justify-content:center;font-size:1.05rem;color:#2a1a00;font-weight:800;
  }
  .form-switch .form-check-input{background-color:#243056;border-color:#3a4a82;}
  .form-switch .form-check-input:checked{background-color:var(--gold-deep);border-color:var(--gold-deep);}
  .real-money-label{font-size:.72rem;letter-spacing:.04em;color:#9fb0d8;}
  .icon-btn{
    width:32px;height:32px;border-radius:6px;background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);display:flex;align-items:center;justify-content:center;font-size:.85rem;transition:.15s;
  }
  .icon-btn:hover{background:#2a3a6e;}

  /* ---------- sidebar ---------- */
  .sidebar{background:var(--navy-1);width:56px;border-right:1px solid #1d2950;}
  .sidebar-icon{
    width:38px;height:38px;border-radius:8px;background:transparent;border:none;color:#7e8fc0;
    font-size:1.05rem;display:flex;align-items:center;justify-content:center;transition:.15s;
  }
  .sidebar-icon:hover{background:#1c2c5a;color:var(--text-light);}
  .sidebar-icon.active{background:linear-gradient(145deg,var(--ring-red),var(--ring-red-deep));color:#fff;}

  /* ---------- stage (boxing ring) ---------- */
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
  .spotlight{
    display: none;
  }
  .spotlight.left{left:-40px;}
  .spotlight.right{right:-40px;transform:scaleX(-1);}
  .ring-ropes{
    display: none;
  }
  .ring-ropes.left{left:0;background-image:repeating-linear-gradient(180deg, var(--ring-red) 0 6px, transparent 6px 54px), linear-gradient(90deg, rgba(0,0,0,.5), transparent);}
  .ring-ropes.right{right:0;background-image:repeating-linear-gradient(180deg, var(--ring-red) 0 6px, transparent 6px 54px), linear-gradient(270deg, rgba(0,0,0,.5), transparent);}
  .ring-post{
    display: none;
  }
  .ring-post.left{left:54px;top:6%;bottom:6%;}
  .ring-post.right{right:54px;top:6%;bottom:6%;}

  .mini-logo{
    position:absolute;top:8%;left:6%;z-index:4;
    transform:rotate(-6deg);
    font-size:1.05rem;letter-spacing:.03em;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 45%, var(--ring-red-deep) 100%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    text-shadow:0 2px 0 rgba(0,0,0,.4);
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
      box-shadow: 0 0 15px rgba(255, 69, 0, 0.6), inset 0 0 12px rgba(255, 69, 0, 0.4);
      filter: drop-shadow(0 0 2px rgba(255, 69, 0, 0.8));
    }
    50% {
      border-color: #ffd700;
      box-shadow: 0 0 35px rgba(255, 215, 0, 0.95), inset 0 0 25px rgba(255, 215, 0, 0.7);
      filter: drop-shadow(0 0 10px rgba(255, 215, 0, 1));
    }
  }
  .reels-row{display:flex;gap:2px;}
  .reel-col{
    flex:1;
    height: var(--reel-col-height);
    overflow:hidden;
    position:relative;
    border-radius:6px;
    background:rgba(255,255,255,.03);
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
  }
  .symbol-cell.cell-scatter-win .symbol{animation:winGlow 1s ease infinite;}
  @keyframes winGlow{0%,100%{filter:drop-shadow(0 0 3px rgba(245,197,66,.2));}50%{filter:drop-shadow(0 0 16px rgba(245,197,66,.9));}}

  .symbol{width:100%;height:100%;display:flex;align-items:center;justify-content:center;animation:popIn .3s ease;}
  @keyframes popIn{0%{transform:scale(.95);opacity:0;}70%{transform:scale(1.02);}100%{transform:scale(1);opacity:1;}}

  /* card symbols */
  .card-sym{
    width:100%;height:100%;border-radius:8px;display:flex;align-items:center;justify-content:center;
    font-family:'Russo One',sans-serif;font-size:1.6rem;border:2px solid rgba(255,255,255,.25);
  }
  .card-red{background:linear-gradient(160deg,#2a0d12,#1a0508);color:var(--card-red);}
  .card-purple{background:linear-gradient(160deg,#1d1530,#100a1c);color:var(--card-purple);}
  .card-blue{background:linear-gradient(160deg,#0d1f30,#08121c);color:var(--card-blue);}
  .card-green{background:linear-gradient(160deg,#0d2a18,#08160d);color:var(--card-green);}

  /* glove / shorts icons */
  .glove{width:78%;height:78%;border-radius:50% 50% 50% 14%;position:relative;}
  .glove::after{
    content:'';position:absolute;left:14%;right:14%;bottom:-12%;height:24%;
    background:inherit;border-radius:6px;
  }
  .glove-blue{background:linear-gradient(160deg,#7fc4ff,#0d4f8a);}
  .glove-red{background:linear-gradient(160deg,#ff8a8a,#8a1020);}

  .shorts{width:78%;height:70%;position:relative;border-radius:6px 6px 0 0;}
  .shorts::before{
    content:'';position:absolute;top:0;left:0;right:0;height:22%;
    background:var(--gold);border-radius:6px 6px 0 0;
  }
  .shorts::after{
    content:'';position:absolute;bottom:0;left:38%;width:24%;height:50%;background:inherit;
  }
  .shorts-blue{background:linear-gradient(160deg,#2a6fd8,#0d2f5a);}
  .shorts-red{background:linear-gradient(160deg,#d8302a,#5a0d0d);}

  /* champion avatars */
  .champ{
    width:80%;height:80%;border-radius:50%;position:relative;display:flex;align-items:center;justify-content:center;
    border:3px solid rgba(255,255,255,.4);
  }
  .champ-blue{background:radial-gradient(circle at 40% 35%, #cfe9ff, #1d4f8a 75%);}
  .champ-red{background:radial-gradient(circle at 40% 35%, #ffd6c2, #8a1f10 75%);}
  .champ .hair{
    position:absolute;top:-14%;left:0;right:0;height:46%;
    clip-path:polygon(0% 100%, 10% 20%, 20% 80%, 32% 10%, 45% 75%, 55% 5%, 68% 75%, 80% 10%, 90% 80%, 100% 100%);
  }
  .champ-blue .hair{background:linear-gradient(160deg,#eaf6ff,#9fc9f5);}
  .champ-red .hair{background:linear-gradient(160deg,#ffd27a,#ff5b2e);}
  .champ .eyes{position:absolute;top:48%;left:30%;right:30%;height:8%;display:flex;justify-content:space-between;}
  .champ .eyes span{width:14%;height:100%;background:#1a1a1a;border-radius:50%;}
  .champ .mouth{position:absolute;bottom:24%;left:38%;right:38%;height:6%;background:#7a1414;border-radius:3px;}

  /* scatter */
  .scatter-sym{
    width:84%;height:84%;border-radius:50%;
    background:linear-gradient(160deg,#3a1530,#1c0a14);
    border:3px solid var(--gold);
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    color:var(--gold);font-size:.5rem;font-weight:800;letter-spacing:.04em;
    box-shadow:0 0 14px rgba(245,197,66,.7);
  }
  .scatter-sym .glyph{font-size:1.2rem;margin-bottom:2px;}

  /* ---------- big win + bonus celebration ---------- */
  .celebration-overlay{
    position:absolute;inset:0;z-index:20;display:flex;align-items:center;justify-content:center;
    pointer-events:none;opacity:0;transition:opacity .25s;
  }
  .celebration-overlay.show{opacity:1;}
  .celebration-text{
    font-family:'Russo One',sans-serif;
    font-size:3rem;letter-spacing:.04em;
    background:linear-gradient(180deg,#fff3c8,var(--gold) 50%, var(--ring-red) 100%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    text-shadow:0 4px 0 rgba(0,0,0,.4);
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
    padding:8px 18px;border-radius:24px;font-size:1rem;letter-spacing:.03em;
    opacity:0;transition:opacity .25s, transform .25s;box-shadow:0 6px 18px rgba(0,0,0,.35);
    pointer-events:none;
  }
  .win-toast.show{opacity:1;transform:translate(-50%,0);}

  /* ---------- controls bar ---------- */
  .controls-bar{
    background:var(--navy-2);border-top:1px solid #1d2950;border-bottom:1px solid #1d2950;
    font-size:.85rem;
  }
  .stat-label{font-size:.62rem;color:#7e8fc0;letter-spacing:.05em;text-transform:uppercase;}
  .stat-value{font-weight:700;color:var(--gold);}
  .round-btn{
    width:42px;height:42px;border-radius:50%;background:#1c2c5a;border:1px solid #2a3a6e;
    color:var(--text-light);display:flex;align-items:center;justify-content:center;font-size:1rem;transition:.15s;
  }
  .round-btn:hover{background:#2a3a6e;}
  .round-btn.active{background:linear-gradient(145deg,var(--gold),var(--gold-deep));color:#2a1a00;}
  .bet-display{cursor:pointer;min-width:64px;text-align:center;}

  .spin-btn{
    width:74px;height:74px;border-radius:50%;position:relative;
    background:radial-gradient(circle at 35% 30%, #ffe9a8, var(--gold-deep) 75%);
    border:3px solid #7a4a08;color:#3a2406;font-size:1.6rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 0 0 5px rgba(0,0,0,.25), 0 0 18px rgba(245,197,66,.45);
    transition:.15s;
  }
  .spin-btn::before{
    content:'';position:absolute;top:-7px;left:50%;transform:translateX(-50%);
    width:18px;height:10px;border-radius:6px 6px 0 0;background:#7a4a08;
  }
  .spin-btn:hover{transform:scale(1.05);}
  .spin-btn:disabled{opacity:.55;cursor:not-allowed;}
  .spin-btn .spin-icon{display:inline-block;}
  .spin-btn.spinning .spin-icon{animation:spinRound .6s linear infinite;}
  @keyframes spinRound{to{transform:rotate(360deg);}}

  .meta-row{font-size:.62rem;color:#5e6e9c;}

  /* ---------- bottom bar ---------- */
  .bottom-bar{background:var(--navy-1);font-size:.78rem;color:#9fb0d8;}
  .bottom-bar input[type="search"]{background:#0c1530;border:1px solid #2a3a6e;color:var(--text-light);}

  @media (max-width:768px){
    .reel-frame{margin-top:80px;}
    .symbol-cell{height:74px;}
    .reel-col{height:222px;}
    .celebration-text{font-size:2rem;}
    .buy-bonus-btn{width:60px;height:60px;font-size:.55rem;}
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

  .bet-display {
    cursor: pointer;
    user-select: none;
    transition: transform 0.15s;
  }
  .bet-display:hover {
    transform: scale(1.05);
  }

  /* Bet Popup Panel styles to match the Jili / Pragmatic Play look */
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

  /* Buy Bonus Modal Overlay */
  .modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1100;
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
    border-radius: 10px;
    width: min(420px, 95%);
    box-shadow: 0 15px 35px rgba(0,0,0,0.9);
    overflow: hidden;
    position: relative;
    font-family: 'Russo One', sans-serif;
    transform: scale(0.9);
    transition: transform 0.15s ease-out;
  }
  .modal-overlay.show .buy-bonus-modal {
    transform: scale(1);
  }
  .modal-header {
    background: #12120e;
    padding: 10px 16px;
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
    font-size: 0.72rem;
    padding: 8px 16px;
    text-align: center;
    border-bottom: 1px solid #5a4b2c;
    line-height: 1.4;
  }
  .modal-body {
    padding: 16px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }
  .coin-icon-container {
    background: radial-gradient(circle, rgba(255,215,0,0.2) 0%, transparent 70%);
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5px;
  }
  .modal-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }
  .modal-label {
    color: #d8c89b;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  .modal-control {
    display: flex;
    align-items: center;
    gap: 0px;
    background: #14120e;
    border: 1px solid #4a3e25;
    border-radius: 6px;
    overflow: hidden;
  }
  .modal-control-btn {
    background: #362f22;
    border: none;
    color: #ffd700;
    width: 36px;
    height: 32px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
  }
  .modal-control-btn:hover {
    background: #5a4b2c;
    color: #ffffff;
  }
  .modal-value {
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: bold;
    width: 60px;
    text-align: center;
  }
  .modal-display-val {
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: bold;
    text-align: right;
  }
  .buy-play-btn {
    background: linear-gradient(180deg, #4cb81d, #25700e);
    border: 2px solid #a6e48c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 800;
    padding: 8px 30px;
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
  .buy-play-btn:active {
    transform: translateY(0);
  }
  /* settings sidebar inside left-panel layout */
  .left-panel {
    display: flex;
    flex-direction: var(--left-panel-direction);
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    z-index: 5;
  }
  .settings-sidebar {
    background: rgba(13, 17, 30, 0.85);
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
</style>
</head>
<body>

@include('customer.header')

<div class="game-shell" style="width:100%;max-width:100%;margin:0;border-radius:0;">

  <!-- top navbar -->
  <div class="top-navbar d-flex align-items-center justify-content-between px-3 py-2">
    <div>🏠 / Slots / Top Picks / <strong>Ring Champion™</strong></div>
    <input type="search" class="form-control form-control-sm" placeholder="Search games" disabled>
  </div>

  <!-- title bar -->
  <div class="title-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-2">
      <div class="game-icon display-font" style="background: linear-gradient(135deg, #b81f2e, #f5c542); color: #fff;">R</div>
      <strong class="display-font">Ring Champion™</strong>
      <div class="form-check form-switch ms-3 d-flex align-items-center gap-2">
        <input class="form-check-input" type="checkbox" role="switch" id="realMoneyToggle">
        <label class="form-check-label real-money-label" for="realMoneyToggle">PLAY FOR REAL MONEY</label>
      </div>
    </div>
    <div class="d-flex gap-2">
      <button class="icon-btn" id="layoutBtn" title="Layout" onclick="window.location.href='{{ route('dashboard') }}'">▦</button>
      <button class="icon-btn" id="fullscreenBtn" title="Fullscreen" onclick="toggleFullScreen()">⛶</button>
      <button class="icon-btn" id="reloadBtn" title="Reload game" onclick="window.location.reload()">↺</button>
      <button class="icon-btn" id="favBtn" title="Add to favorites">★</button>
      <button class="icon-btn" id="closeBtn" title="Close" onclick="window.location.href='{{ route('dashboard') }}'">✕</button>
    </div>
  </div>

  <div class="d-flex flex-grow-1" style="overflow: hidden; height: 0; min-height: 0;">

    <!-- sidebar -->
    <div class="sidebar d-flex flex-column align-items-center py-3 gap-2">
      <button class="sidebar-icon" title="Favorites">♥</button>
      <button class="sidebar-icon" title="Categories">▦</button>
      <button class="sidebar-icon" title="New releases">⚡</button>
      <button class="sidebar-icon" title="Top games">🏆</button>
      <button class="sidebar-icon active" title="All games">🎮</button>
    </div>

    <!-- main stage -->
    <div class="game-stage flex-grow-1">
      <div class="spotlight left"></div>
      <div class="spotlight right"></div>
      <div class="ring-ropes left"></div>
      <div class="ring-ropes right"></div>
      <div class="ring-post left"></div>
      <div class="ring-post right"></div>

      <div class="mini-logo display-font">RING KING</div>

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
            <button class="popover-item" id="popoverInfoBtn" title="Info">ℹ</button>
            <button class="popover-item" id="popoverSoundBtn" title="Mute/Unmute">🔊</button>
          </div>
        </div>

        <!-- reel-frame -->
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
        <div class="bet-grid-title">Select Bet</div>
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
            <h5 class="modal-title">Buy Bonus</h5>
            <button class="modal-close-btn" id="closeBuyBonusModalBtn">&times;</button>
          </div>
          <div class="modal-info-banner">
            Click 'Buy & Play' to purchase and activate the featured game automatically.
          </div>
          <div class="modal-body">
            <div class="coin-icon-container">
              <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="24" cy="20" r="16" fill="#ffd700" stroke="#bda060" stroke-width="2"/>
                <path d="M24 10V30M16 20H32" stroke="#b69512" stroke-width="3" stroke-linecap="round"/>
                <circle cx="20" cy="28" r="16" fill="#ffea00" stroke="#bda060" stroke-width="2"/>
                <path d="M20 18V38M12 28H28" stroke="#a08008" stroke-width="3" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="modal-row mt-2">
              <span class="modal-label">Bet</span>
              <div class="modal-control">
                <button class="modal-control-btn" id="modalBetMinus">-</button>
                <div class="modal-value" id="modalBetValue">3</div>
                <button class="modal-control-btn" id="modalBetPlus">+</button>
              </div>
            </div>
            <div class="modal-row mt-2">
              <span class="modal-label">Quantity</span>
              <div class="modal-control">
                <button class="modal-control-btn" id="modalQtyMinus">-</button>
                <div class="modal-value" id="modalQtyValue">1</div>
                <button class="modal-control-btn" id="modalQtyPlus">+</button>
              </div>
            </div>
            <div class="modal-row mt-3 pt-2 border-top border-secondary">
              <span class="modal-label">Price</span>
              <span class="modal-display-val" id="modalPrice">94.50</span>
            </div>
            <div class="modal-row mt-2">
              <span class="modal-label">Total Price</span>
              <span class="modal-display-val" id="modalTotalPrice" style="color: #ffd700; font-size: 1.3rem;">94.50</span>
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
        <span class="modal-title display-font" style="font-size: 1.3rem;">AutoSpin Setting</span>
        <button class="modal-close-btn" id="closeAutoSpinModalBtn">&times;</button>
      </div>
      <div class="modal-body" style="font-size: 0.9rem; text-align: left;">
        
        <!-- Total Spins Row -->
        <div class="modal-row mt-3">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
            <input type="checkbox" id="chkTotalSpins" checked style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Total Spins</span>
          </label>
          <div class="modal-control">
            <button class="modal-control-btn" id="autoSpinsMinus">-</button>
            <div class="modal-value" id="autoSpinsValue" style="width: 50px;">50</div>
            <button class="modal-control-btn" id="autoSpinsPlus">+</button>
          </div>
        </div>
        <!-- Quick buttons for Total Spins -->
        <div class="d-flex gap-2 justify-content-end mt-2">
          <button class="quick-qty-btn" id="quickSpin10">10</button>
          <button class="quick-qty-btn" id="quickSpin20">20</button>
          <button class="quick-qty-btn" id="quickSpin30">30</button>
          <button class="quick-qty-btn" id="quickSpin40">40</button>
          <button class="quick-qty-btn" id="quickSpin50">50</button>
        </div>

        <!-- Single Win Row -->
        <div class="modal-row mt-3">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
            <input type="checkbox" id="chkSingleWin" style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Single win ratio exceeds</span>
          </label>
          <div class="modal-control">
            <button class="modal-control-btn" id="singleWinMinus">-</button>
            <div class="modal-value" id="singleWinValue" style="width: 80px;">100X</div>
            <button class="modal-control-btn" id="singleWinPlus">+</button>
          </div>
        </div>

        <!-- Stop if balance < Row -->
        <div class="modal-row mt-3">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
            <input type="checkbox" id="chkBalanceLess" style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Stop if balance &lt;</span>
          </label>
          <div class="modal-control">
            <button class="modal-control-btn" id="balLessMinus">-</button>
            <div class="modal-value" id="balLessValue" style="width: 80px;">100</div>
            <button class="modal-control-btn" id="balLessPlus">+</button>
          </div>
        </div>

        <!-- Stop if balance > Row -->
        <div class="modal-row mt-3">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
            <input type="checkbox" id="chkBalanceMore" style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Stop if balance &gt;</span>
          </label>
          <div class="modal-control">
            <button class="modal-control-btn" id="balMoreMinus">-</button>
            <div class="modal-value" id="balMoreValue" style="width: 80px;">5000</div>
            <button class="modal-control-btn" id="balMorePlus">+</button>
          </div>
        </div>

        <!-- Stop if Free Game Activated Row -->
        <div class="modal-row mt-3 mb-2">
          <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
            <input type="checkbox" id="chkFreeGame" style="accent-color: #ffd700; width: 18px; height: 18px;">
            <span>Stop if "Free Game" is activated</span>
          </label>
        </div>

        <!-- Cancel / Start Action buttons -->
        <div class="d-flex gap-3 mt-4">
          <button class="buy-play-btn" id="modalAutoCancelBtn" style="background: linear-gradient(180deg, #b81f2e, #85101a); border-color: #f59e9e; box-shadow: 0 4px 15px rgba(133,16,26,0.4);">Cancel</button>
          <button class="buy-play-btn" id="modalAutoStartBtn">Start</button>
        </div>
      </div>
    </div>
  </div>

  <!-- controls bar -->
  <div class="controls-bar d-flex align-items-center justify-content-center gap-4 px-3 py-2 flex-wrap" style="position: relative;">
    <button class="round-btn" id="settingsBtn" title="Settings">⚙</button>

    <div class="text-center">
      <div class="stat-label" id="balanceLabel">demo balance</div>
      <div class="stat-value" id="balanceValue">1000.00</div>
    </div>

    <div class="text-center bet-display" id="betDisplay" title="Click to change bet">
      <div class="stat-label">Bet</div>
      <div class="stat-value" id="betValue">3</div>
    </div>

    <div class="text-center">
      <div class="stat-label">Win</div>
      <div class="stat-value" id="winValue">0.00</div>
    </div>

    <button class="round-btn" id="turboBtn" title="Turbo spin">⚡</button>
    <div class="text-center">
      <button class="round-btn" id="autoplayBtn" title="Tap to autoplay">↻</button>
      <div class="meta-row mt-1">Tap to autoplay</div>
    </div>

    <button class="spin-btn" id="spinBtn" title="Spin"><span class="spin-icon">⟳</span></button>

    <button class="round-btn" id="wifiBtn" title="Connection">📶</button>
  </div>

  <div class="d-flex justify-content-between px-3 py-1 meta-row" style="background:#070b18;">
    <span id="versionText">v_1.0_demo</span>
    <span id="txnText">Transaction —</span>
  </div>

  <!-- bottom bar -->
  <div class="bottom-bar d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex gap-3">
      <span style="cursor: pointer;" onclick="window.location.href='{{ route('dashboard') }}'">🕐 RECENT GAMES</span>
      <span style="cursor: pointer;" onclick="window.location.href='{{ route('dashboard') }}'">★ FAVORITES</span>
    </div>
    <input type="search" class="form-control form-control-sm" style="max-width:200px" placeholder="Search" disabled>
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
  
  const chkBalanceLess = document.getElementById('chkBalanceLess');
  const balLessMinus = document.getElementById('balLessMinus');
  const balLessValue = document.getElementById('balLessValue');
  const balLessPlus = document.getElementById('balLessPlus');
  
  const chkBalanceMore = document.getElementById('chkBalanceMore');
  const balMoreMinus = document.getElementById('balMoreMinus');
  const balMoreValue = document.getElementById('balMoreValue');
  const balMorePlus = document.getElementById('balMorePlus');
  
  const chkFreeGame = document.getElementById('chkFreeGame');
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
        osc.frequency.setValueAtTime(150, now);
        osc.frequency.exponentialRampToValueAtTime(800, now + 0.45);
        gain.gain.setValueAtTime(0.12, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.45);
        osc.start(now);
        osc.stop(now + 0.45);
      } else if (type === 'stop') {
        const now = audioCtx.currentTime;
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(110, now);
        osc.frequency.exponentialRampToValueAtTime(30, now + 0.08);
        gain.gain.setValueAtTime(0.15, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.08);
        osc.start(now);
        osc.stop(now + 0.08);
      } else if (type === 'win') {
        const now = audioCtx.currentTime;
        osc.type = 'sine';
        osc.frequency.setValueAtTime(587.33, now); // D5
        gain.gain.setValueAtTime(0.18, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.25);
        
        const osc2 = audioCtx.createOscillator();
        const gain2 = audioCtx.createGain();
        osc2.connect(gain2);
        gain2.connect(audioCtx.destination);
        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(880, now + 0.1); // A5
        gain2.gain.setValueAtTime(0.18, now + 0.1);
        gain2.gain.exponentialRampToValueAtTime(0.005, now + 0.4);
        
        osc.start(now);
        osc.stop(now + 0.25);
        osc2.start(now + 0.1);
        osc2.stop(now + 0.4);
      } else if (type === 'scatter' || type === 'bigwin') {
        const now = audioCtx.currentTime;
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(440, now);
        osc.frequency.linearRampToValueAtTime(880, now + 0.2);
        osc.frequency.linearRampToValueAtTime(440, now + 0.4);
        osc.frequency.linearRampToValueAtTime(880, now + 0.6);
        gain.gain.setValueAtTime(0.12, now);
        gain.gain.exponentialRampToValueAtTime(0.005, now + 0.7);
        osc.start(now);
        osc.stop(now + 0.7);
      }
    } catch (e) {
      console.warn("Audio Context failed to play sound:", e);
    }
  }

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

  const betLevels = [1, 2, 3, 5, 8, 10, 20, 50, 100, 200, 300, 400, 500, 700, 1000];
  let betIndex = 2;
  let bet = betLevels[betIndex];
  let spinning = false;
  let turbo = false;
  let autoplay = false;
  let autoplayTimer = null;
  let forceScatterMode = false;
  let bonusSpinsQueue = 0;
  let autoplaySpinsRemaining = 0;

  const PAY = { card:0.5, icon:1.2, champ:3 };

  // Mapping symbol IDs to physical images loaded from BoxingKing directory
  const SYM_IMAGES = {
    'card:A': '1.png',
    'card:K': '2.png',
    'card:Q': '3.png',
    'card:J': '4.png',
    'icon:glove-blue': '5.png',
    'icon:glove-red': '6.png',
    'icon:shorts-blue': '7.png',
    'icon:shorts-red': '8.png',
    'champ:blue': '9.png',
    'champ:red': '10.png',
    'scatter': '11.png'
  };

  function updateModeUI() {
    if (isDemoMode) {
      realMoneyToggle.checked = false;
      balanceLabelEl.textContent = 'demo balance';
      balance = demoBalance;
    } else {
      if (realBalance < 1.0) {
        alert("Your real balance is too low! Switching to Demo Mode.");
        isDemoMode = true;
        realMoneyToggle.checked = false;
        balanceLabelEl.textContent = 'demo balance';
        balance = demoBalance;
      } else {
        realMoneyToggle.checked = true;
        balanceLabelEl.textContent = 'real balance';
        balance = realBalance;
      }
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

  realMoneyToggle.addEventListener('change', function() {
    if (spinning) {
      realMoneyToggle.checked = !realMoneyToggle.checked;
      return;
    }
    isDemoMode = !realMoneyToggle.checked;
    updateModeUI();
  });

  // ==========================================
  // SYMBOLS & RENDERING
  // ==========================================
  function randSymbol(forceScatter){
    if (forceScatter && Math.random() < 0.55) return {type:'scatter'};
    const r = Math.random();
    if (r < 0.05) return {type:'scatter'};
    if (r < 0.50) {
      const cards = [
        {rank:'A', cls:'card-red'}, {rank:'K', cls:'card-purple'},
        {rank:'Q', cls:'card-blue'}, {rank:'J', cls:'card-green'}
      ];
      return Object.assign({type:'card'}, cards[Math.floor(Math.random()*cards.length)]);
    }
    if (r < 0.85) {
      const icons = ['glove-blue','glove-red','shorts-blue','shorts-red'];
      return {type:'icon', icon: icons[Math.floor(Math.random()*icons.length)]};
    }
    return {type:'champ', side: Math.random() < 0.5 ? 'blue' : 'red'};
  }

  function symbolMarkup(sym){
    let imgName = '1.png';
    if (sym.type === 'scatter') {
      imgName = SYM_IMAGES['scatter'];
    } else if (sym.type === 'card') {
      imgName = SYM_IMAGES['card:' + sym.rank] || '1.png';
    } else if (sym.type === 'icon') {
      imgName = SYM_IMAGES['icon:' + sym.icon] || '5.png';
    } else if (sym.type === 'champ') {
      imgName = SYM_IMAGES['champ:' + sym.side] || '9.png';
    }
    
    const src = `{{ asset('assets/image/BoxingKing') }}/${imgName}`;
    return `<div class="symbol" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
              <img src="${src}" style="width:100%; height:100%; object-fit:cover;" draggable="false">
            </div>`;
  }

  // Build reel columns
  const colEls = [];
  const cellEls = [];
  for (let c = 0; c < COLS; c++){
    const col = document.createElement('div');
    col.className = 'reel-col';
    for (let r = 0; r < ROWS; r++){
      const cell = document.createElement('div');
      cell.className = 'symbol-cell';
      cell.innerHTML = symbolMarkup(randSymbol(false));
      col.appendChild(cell);
      cellEls.push(cell);
    }
    reelsRow.appendChild(col);
    colEls.push(col);
  }
  function cellsOfCol(c){
    return cellEls.slice(c*ROWS, c*ROWS+ROWS);
  }

  function formatMoney(n){ return n.toFixed(2); }
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

  function spin(){
    if (spinning) return;

    let isPaidSpin = true;
    if (bonusSpinsQueue > 0) {
      bonusSpinsQueue--;
      forceScatterMode = true;
      isPaidSpin = false;
    }

    if (isPaidSpin) {
      if (balance < bet){
        alert("Insufficient balance! Please select a lower bet or switch modes.");
        stopAutoplay();
        return;
      }
      balance -= bet;
    }

    // Clear previous win effects and flames
    cellEls.forEach(cell => {
      cell.classList.remove('cell-win', 'cell-scatter-win');
      const flames = cell.querySelector('.flames-container');
      if (flames) flames.remove();
    });

    setBusy(true);
    playSound('spin');

    if (isPaidSpin) {
      if (isDemoMode) {
        demoBalance = balance;
      } else {
        realBalance = balance;
        syncBalance(realBalance);
      }
    }

    balanceEl.textContent = currencySymbol + formatMoney(balance);
    winEl.textContent = currencySymbol + '0.00';

    const useForce = forceScatterMode;
    forceScatterMode = false;

    let stoppedCount = 0;
    const flickerSpeed = turbo ? 45 : 75;
    const baseDelay = turbo ? 260 : 600;
    const stagger = turbo ? 90 : 180;
    const finalGrid = [];

    for (let c = 0; c < COLS; c++){
      const col = colEls[c];
      const cells = cellsOfCol(c);
      col.classList.add('spinning');

      const flicker = setInterval(() => {
        cells.forEach(cell => cell.innerHTML = symbolMarkup(randSymbol(useForce)));
      }, flickerSpeed);

      setTimeout(() => {
        clearInterval(flicker);
        col.classList.remove('spinning');
        col.classList.add('settle');
        setTimeout(()=> col.classList.remove('settle'), 420);

        const colSymbols = [];
        for (let r = 0; r < ROWS; r++){
          const sym = randSymbol(useForce);
          colSymbols.push(sym);
          cells[r].innerHTML = symbolMarkup(sym);
        }
        
        playSound('stop');
        finalGrid[c] = colSymbols;

        stoppedCount++;
        if (stoppedCount === COLS){
          setTimeout(()=> settleRound(finalGrid), 80);
        }
      }, baseDelay + c*stagger);
    }
  }

  function settleRound(finalGrid){
    const counts = {};
    let scatterCount = 0;
    const allCells = [];

    for (let c = 0; c < COLS; c++){
      const cells = cellsOfCol(c);
      for (let r = 0; r < ROWS; r++){
        const sym = finalGrid[c][r];
        allCells.push({sym, cell: cells[r]});
        if (sym.type === 'scatter'){
          scatterCount++;
        } else {
          const key = sym.type === 'card' ? 'card:' + sym.rank
                    : sym.type === 'icon' ? 'icon:' + sym.icon
                    : 'champ:' + sym.side;
          counts[key] = (counts[key] || 0) + 1;
        }
      }
    }

    let totalWin = 0;
    Object.keys(counts).forEach(key => {
      const n = counts[key];
      if (n >= 3){
        const base = key.startsWith('card:') ? PAY.card
                    : key.startsWith('icon:') ? PAY.icon
                    : PAY.champ;
        totalWin += base * (n - 2) * bet;

        // Highlight cells and append CSS flames for fiery wins
        allCells.forEach(({sym, cell}) => {
          const symKey = sym.type === 'card' ? 'card:' + sym.rank
                       : sym.type === 'icon' ? 'icon:' + sym.icon
                       : 'champ:' + sym.side;
          if (symKey === key) {
            cell.classList.add('cell-win');
            if (!cell.querySelector('.flames-container')) {
              const flames = document.createElement('div');
              flames.className = 'flames-container';
              flames.innerHTML = '<div class="flame"></div><div class="flame"></div><div class="flame"></div>';
              cell.appendChild(flames);
            }
          }
        });
      }
    });

    if (scatterCount >= 3){
      const bonusWin = bet * 25;
      totalWin += bonusWin;
      playSound('scatter');
      allCells.forEach(({sym, cell}) => {
        if (sym.type === 'scatter') {
          cell.classList.add('cell-scatter-win');
          if (!cell.querySelector('.flames-container')) {
            const flames = document.createElement('div');
            flames.className = 'flames-container';
            flames.innerHTML = '<div class="flame" style="background:#ffd700;"></div><div class="flame" style="background:#ff8c00;"></div><div class="flame" style="background:#ff4500;"></div>';
            cell.appendChild(flames);
          }
        }
      });
      setTimeout(()=>{
        showCelebration('🥊 BONUS TRIGGERED!', 2000);
      }, 100);
    } else if (totalWin >= bet * 20){
      playSound('bigwin');
      setTimeout(()=> showCelebration('BIG WIN!', 1700), 50);
    } else if (totalWin > 0) {
      playSound('win');
    }

    if (totalWin > 0){
      balance += totalWin;
      if (isDemoMode) {
        demoBalance = balance;
      } else {
        realBalance = balance;
        syncBalance(realBalance);
      }
      balanceEl.textContent = currencySymbol + formatMoney(balance);
      winEl.textContent = currencySymbol + formatMoney(totalWin);
      showWinToast(totalWin);
    }

    txnText.textContent = 'Transaction ' + randomTxnId();
    setBusy(false);

    if (bonusSpinsQueue > 0) {
      autoplayTimer = setTimeout(() => {
        spin();
      }, turbo ? 250 : 550);
    } else if (autoplay){
      let shouldStopAutoplay = false;

      // Check conditions if Autoplay is active
      if (chkTotalSpins.checked) {
        autoplaySpinsRemaining--;
        if (autoplaySpinsRemaining <= 0) {
          shouldStopAutoplay = true;
        }
      }
      if (chkSingleWin.checked) {
        const ratioLimit = parseInt(singleWinValue.textContent) || 100;
        if (totalWin >= bet * ratioLimit) {
          shouldStopAutoplay = true;
        }
      }
      if (chkBalanceLess.checked) {
        const limit = parseFloat(balLessValue.textContent) || 0;
        if (balance < limit) {
          shouldStopAutoplay = true;
        }
      }
      if (chkBalanceMore.checked) {
        const limit = parseFloat(balMoreValue.textContent) || 0;
        if (balance > limit) {
          shouldStopAutoplay = true;
        }
      }
      if (chkFreeGame.checked && scatterCount >= 3) {
        shouldStopAutoplay = true;
      }

      if (shouldStopAutoplay) {
        stopAutoplay();
      } else {
        autoplayTimer = setTimeout(() => {
          if (autoplay && balance >= bet) spin();
          else stopAutoplay();
        }, turbo ? 250 : 550);
      }
    }
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
    betPopup.offsetHeight; // force reflow
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
  turboBtn.addEventListener('click', () => {
    turbo = !turbo;
    turboBtn.classList.toggle('active', turbo);
  });

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
    buyBonusModalOverlay.offsetHeight; // force reflow
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
      alert("Insufficient balance for Buy Bonus!");
      return;
    }
    
    // Deduct total cost
    balance -= cost;
    if (isDemoMode) {
      demoBalance = balance;
    } else {
      realBalance = balance;
      syncBalance(realBalance);
    }
    balanceEl.textContent = currencySymbol + formatMoney(balance);
    
    // Update active game bet
    updateBet(modalBet);
    
    // Close modal
    closeBuyBonusModal();
    
    // Queue up the bonus spins and start the round
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
  });

  popoverInfoBtn.addEventListener('click', () => {
    alert("🥊 Ring Champion™ Rules:\n- Match 3 or more symbols on adjacent columns from left to right to win.\n- 3 or more Scatter symbols trigger Free Spins!\n- Use Buy Bonus to purchase Scatter guaranteed rounds directly.");
  });

  // Open / Close AutoSpin modal
  popoverAutoSpinBtn.addEventListener('click', () => {
    if (spinning) return;
    
    chkTotalSpins.checked = true;
    autoSpinsValue.textContent = '50';
    
    autoSpinModalOverlay.style.display = 'flex';
    autoSpinModalOverlay.offsetHeight; // force reflow
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

  // Adjusters for options
  singleWinMinus.addEventListener('click', () => {
    let val = parseInt(singleWinValue.textContent) || 10;
    if (val > 10) singleWinValue.textContent = (val - 10) + 'X';
  });
  singleWinPlus.addEventListener('click', () => {
    let val = parseInt(singleWinValue.textContent) || 10;
    singleWinValue.textContent = (val + 10) + 'X';
  });

  balLessMinus.addEventListener('click', () => {
    let val = parseInt(balLessValue.textContent) || 10;
    if (val > 10) balLessValue.textContent = val - 10;
  });
  balLessPlus.addEventListener('click', () => {
    let val = parseInt(balLessValue.textContent) || 10;
    balLessValue.textContent = val + 10;
  });

  balMoreMinus.addEventListener('click', () => {
    let val = parseInt(balMoreValue.textContent) || 100;
    if (val > 100) balMoreValue.textContent = val - 100;
  });
  balMorePlus.addEventListener('click', () => {
    let val = parseInt(balMoreValue.textContent) || 100;
    balMoreValue.textContent = val + 100;
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

  document.querySelectorAll('.sidebar-icon').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.sidebar-icon').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    });
  });

  // Initial load
  txnText.textContent = 'Transaction ' + randomTxnId();
  updateBet(bet);
  updateModeUI();

})();
</script>
</body>
</html>
