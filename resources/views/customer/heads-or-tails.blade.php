<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Heads or Tails — Pirate Coin Flip</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Cinzel:wght@500;600;700;900&family=EB+Garamond:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg-deep:#050b14;
    --gold:#f3c45a;
    --gold-light:#ffe9b0;
    --gold-dark:#c8902f;
    --parchment-1:#f1e2bb;
    --parchment-2:#dcc190;
    --ink:#3a2a16;
    --wood-1:#d9692f;
    --wood-2:#9c3a17;
    --ember:#ff5a2b;
    --green-1:#6fd45a;
    --green-2:#268a22;
    --panel-bg:#0e2138;
  }
  *{box-sizing:border-box;}
  html,body{margin:0;height:100%;background:var(--bg-deep);overflow-x:hidden;}
  body{
    font-family:'Inter',sans-serif;
    color:#fff;
    min-height:100vh;
    position:relative;
  }
  video#bgVideo{
    position:fixed; inset:0; width:100%; height:100%; z-index:0; display:block;
    object-fit:cover; pointer-events:none;
  }
  .vignette{
    position:fixed; inset:0; z-index:1; pointer-events:none;
    background:radial-gradient(ellipse at 50% 30%, rgba(0,0,0,0) 40%, rgba(0,0,0,.55) 100%);
  }

  .stage{
    position:relative; z-index:2;
    min-height:100vh;
    display:flex; flex-direction:column; align-items:center;
    padding:22px 24px 160px;
  }

  /* ---------- Top bar ---------- */
  .topbar{
    width:100%; max-width:1700px;
    display:flex; justify-content:space-between; align-items:flex-start;
    margin-bottom:18px; flex-wrap:wrap; gap:14px;
  }
  .breadcrumb{
    font-size:12.5px; letter-spacing:.1em; text-transform:uppercase;
    color:rgba(255,255,255,.7); display:flex; gap:6px; align-items:center;
  }
  .breadcrumb .crumb.active{ color:#fff; font-weight:700; text-decoration:underline; text-underline-offset:3px; }
  .breadcrumb .sep{ opacity:.5; }

  .jackpot-badge{
    font-family:'Cinzel',serif; font-weight:900; letter-spacing:.25em; font-size:14px;
    color:#ffffff; text-shadow:0 0 8px rgba(255,215,0,0.6), 0 2px 4px rgba(0,0,0,0.8);
    text-transform:uppercase;
    padding:8px 35px; border-radius:6px;
    border:3px solid #ffbe1a;
    background:linear-gradient(180deg, #1c1303 0%, #0a0701 100%);
    box-shadow:0 0 20px rgba(255,190,26,0.5), inset 0 0 10px rgba(255,190,26,0.3);
    position:relative;
  }

  /* ---------- Title ---------- */
  .title-block{ position:relative; text-align:center; margin:14px 0 34px; }
  .game-title{
    margin:0; font-family:'Cinzel',serif; font-weight:900;
    font-size:clamp(46px,6vw,84px); line-height:.9; letter-spacing:.02em;
    background:linear-gradient(180deg,#fff5df 0%, #f3c45a 45%, #a26b1f 100%);
    -webkit-background-clip:text; background-clip:text; color:transparent;
    filter:drop-shadow(0 4px 6px rgba(0,0,0,.9)) drop-shadow(0 0 10px rgba(243,196,90,.3));
    text-transform: uppercase;
  }
  .game-title .sub{ display:block; font-size:.95em; }
  .bolt-icon{ position:absolute; top:-14px; right:calc(50% - 8px); filter:drop-shadow(0 0 10px #5ec8ff) drop-shadow(0 0 4px #bfe8ff); }

  /* ---------- Cards ---------- */
  .cards-row{
    display:flex; gap:64px; flex-wrap:wrap; justify-content:center;
    width:100%; max-width:1400px;
  }
  .card{
    width:380px; display:flex; flex-direction:column; align-items:center;
    position:relative; animation:floatIn .7s ease both;
    margin-top: 50px;
  }
  .card:nth-child(2){ animation-delay:.1s; }
  @keyframes floatIn{ from{ opacity:0; transform:translateY(18px);} to{opacity:1; transform:translateY(0);} }

  /* ---------- Card Decorations ---------- */
  .card-decorations{
    position:absolute; width:100%; height:100px; top:-50px; left:0;
    pointer-events:none; z-index:1;
  }
  .helm-decor{
    position:absolute; width:95px; height:95px; left:65px; top:-5px;
    opacity:0.85; filter:drop-shadow(0 4px 6px rgba(0,0,0,0.6));
  }
  .map-decor{
    position:absolute; width:90px; height:70px; right:60px; top:-5px;
    opacity:0.9; transform:rotate(10deg);
    filter:drop-shadow(0 4px 6px rgba(0,0,0,0.6));
  }
  .anchor-decor{
    position:absolute; width:95px; height:95px; left:50%; transform:translateX(-50%) rotate(-10deg); top:-5px;
    opacity:0.85; filter:drop-shadow(0 4px 6px rgba(0,0,0,0.6));
  }

  /* ---------- Wood Plank Banner ---------- */
  .banner{
    position:relative; z-index:2; width:100%;
    clip-path:polygon(0% 15%, 4% 0%, 96% 0%, 100% 15%, 98% 50%, 100% 85%, 96% 100%, 4% 100%, 0% 85%, 2% 50%);
    background:linear-gradient(180deg, #e67035 0%, #c14d1c 45%, #92300b 80%, #6e1c02 100%);
    padding:16px 16px 14px; text-align:center;
    font-family:'Cinzel',serif; font-weight:900; letter-spacing:.08em; font-size:18px;
    color:#2a0f02; text-shadow:0 1.5px 0.5px rgba(255,255,255,.3);
    filter:drop-shadow(0 6px 8px rgba(0,0,0,.65));
    border-top: 2.5px solid rgba(255,255,255,0.15);
    border-bottom: 2.5px solid rgba(0,0,0,0.3);
  }
  .banner.fire{ overflow:visible; }
  .fire-blast{
    position:absolute; right:15px; top:12px; width:90px; height:50px;
    background:radial-gradient(circle at left, rgba(255,220,100,1) 0%, rgba(255,100,20,0.95) 30%, rgba(200,30,0,0.8) 60%, rgba(120,10,0,0) 85%);
    mix-blend-mode:screen; filter:blur(1.5px);
    animation:flameBurn 0.8s ease-in-out infinite alternate;
    pointer-events:none; z-index:4;
    clip-path:polygon(0% 25%, 35% 5%, 65% 20%, 100% 35%, 85% 55%, 100% 70%, 70% 85%, 40% 95%, 0% 75%);
  }
  @keyframes flameBurn{
    0%{ transform:scale(0.95) rotate(-2deg); opacity:.85; }
    100%{ transform:scale(1.05) rotate(3deg); opacity:1; }
  }

  /* ---------- Banner Emblems ---------- */
  .banner-emblem{
    position:absolute; top:-25px; left:50%; transform:translateX(-50%);
    width:54px; height:54px; z-index:3;
    filter:drop-shadow(0 3px 5px rgba(0,0,0,0.55));
  }
  .banner-emblem svg{
    display:block; width:100%; height:100%;
  }
  .banner-emblem.doubled{
    width:90px; height:54px;
    display:flex; justify-content:center; align-items:center;
  }
  .banner-emblem.doubled .coin-1{
    position:absolute; width:46px; height:46px; left:6px; z-index:2;
  }
  .banner-emblem.doubled .coin-2{
    position:absolute; width:46px; height:46px; right:6px; z-index:1;
  }

  /* ---------- Parchment Scroll ---------- */
  .parchment{
    width:100%; margin-top:-14px; position:relative; z-index:1;
    background:linear-gradient(160deg, #f4e6c9 0%, #dbbe91 100%);
    clip-path:polygon(0% 0%, 100% 0%, 99% 6%, 98% 12%, 99% 18%, 97% 24%, 99% 30%, 98% 36%, 99% 42%, 97% 48%, 99% 54%, 98% 60%, 99% 66%, 97% 72%, 99% 78%, 98% 84%, 99% 90%, 95% 93%, 88% 91%, 81% 94%, 74% 92%, 67% 95%, 60% 92%, 53% 94%, 46% 92%, 39% 95%, 32% 92%, 25% 94%, 18% 92%, 11% 94%, 4% 91%, 0% 93%, 1% 90%, 2% 84%, 1% 78%, 3% 72%, 1% 66%, 2% 60%, 1% 54%, 3% 48%, 1% 42%, 2% 36%, 1% 30%, 3% 24%, 1% 18%, 2% 12%, 1% 6%);
    padding:45px 30px 45px; min-height:220px;
    display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px;
    box-shadow:inset 0 0 30px rgba(120,80,30,.2);
  }
  .parchment p{
    margin:0; font-family:'EB Garamond',serif; font-size:17px; line-height:1.42;
    color:var(--ink); text-align:center; font-weight: 500;
  }

  /* ---------- Green Pill Play Button ---------- */
  .play-btn{
    position:absolute; bottom:-22px; left:50%; transform:translateX(-50%);
    z-index:10; cursor:pointer;
    width:160px; height:44px; border-radius:22px; border:2px solid #14500d;
    background:linear-gradient(180deg,#65eb26,#1d9e03);
    font-family:'Cinzel',serif; font-weight:900; letter-spacing:.15em; font-size:15px;
    color:#ffffff; text-shadow:0 2px 3px rgba(0,0,0,.65);
    box-shadow:0 6px 12px rgba(0,0,0,.5), inset 0 2px 2px rgba(255,255,255,0.5), inset 0 -2px 2px rgba(0,0,0,0.3);
    transition:transform .15s ease, box-shadow .15s ease;
    display:flex; align-items:center; justify-content:center;
  }
  .play-btn::before{
    content:''; position:absolute; top:2px; left:6%; width:88%; height:38%;
    background:linear-gradient(180deg, rgba(255,255,255,.6), rgba(255,255,255,0));
    border-radius:20px; pointer-events:none;
  }
  .play-btn:hover{ transform:translateX(-50%) translateY(-2px); box-shadow:0 10px 18px rgba(0,0,0,.6), inset 0 2px 2px rgba(255,255,255,0.5); }
  .play-btn:active{ transform:translateX(-50%) translateY(0); }

  /* ---------- Side rail ---------- */
  .side-rail{
    position:fixed; right:0; top:50%; transform:translateY(-50%);
    display:flex; flex-direction:column; z-index:6;
    background:rgba(9,19,30,.75); border-radius:8px 0 0 8px; overflow:hidden;
    border:1px solid rgba(255,255,255,.08);
    box-shadow:-4px 0 16px rgba(0,0,0,.5);
  }
  .side-rail button{
    width:42px; height:42px; border:none; background:transparent; cursor:pointer;
    color:#b9cbdc; font-size:18px; display:flex; align-items:center; justify-content:center;
    border-bottom:1px solid rgba(255,255,255,.05); transition:background .15s, color .15s;
  }
  .side-rail button:last-child{ border-bottom:none; }
  .side-rail button:hover{ background:rgba(243,196,90,.15); color:#ffe28a; }

  /* ---------- Bottom hub ---------- */
  .bottom-hub{
    position:fixed; bottom:0; left:50%; transform:translateX(-50%);
    width:220px; height:70px; z-index:5;
    background:linear-gradient(180deg, #b05c2a, #632408);
    box-shadow:0 -6px 20px rgba(0,0,0,.7), inset 0 2px 1px rgba(255,255,255,0.25);
    display:flex; align-items:center; justify-content:center; gap:20px;
    padding-bottom:12px;
    border-radius:110px 110px 0 0;
    border-top:3px solid #e2854e;
  }
  .hub-btn{
    width:42px; height:42px; border-radius:50%; cursor:pointer;
    background:radial-gradient(circle at 35% 28%, #ffe9a8 0%, #caa033 65%, #8a651c 100%);
    border:2.5px solid #4a2f07; box-shadow:0 3px 6px rgba(0,0,0,.5);
    font-weight:900; color:#321e06; font-size:18px;
    display:flex; align-items:center; justify-content:center;
    transition:transform .15s;
  }
  .hub-btn:hover{ transform:scale(1.08); }

  /* ---------- Demo badge + bell ---------- */
  .demo-badge{
    display: none !important;
    position:fixed; bottom:24px; right:90px; z-index:6;
    background:rgba(9,18,29,.72); border:1px solid rgba(255,255,255,.16);
    border-radius:20px; padding:9px 16px; font-size:12.5px; letter-spacing:.05em;
    display:flex; align-items:center; gap:9px; color:#dfe7ef; cursor:pointer;
  }
  .demo-badge .dot{ width:8px; height:8px; border-radius:50%; background:#3fd15d; box-shadow:0 0 8px #3fd15d; }
  .bell-btn{
    position:fixed; bottom:22px; right:22px; z-index:6;
    width:44px; height:44px; border-radius:50%; border:none; cursor:pointer;
    background:linear-gradient(160deg,#2c8fd6,#103a63);
    color:#eaf6ff; font-size:17px; box-shadow:0 4px 12px rgba(0,0,0,.5);
  }

  /* ---------- Overlays ---------- */
  .overlay{
    position:fixed; inset:0; z-index:30; display:flex; align-items:center; justify-content:center;
    background:rgba(4,9,15,.82); backdrop-filter:blur(4px);
    opacity:0; pointer-events:none; transition:opacity .22s ease;
  }
  .overlay.open{ opacity:1; pointer-events:auto; }
  .panel{
    position:relative; width:min(440px,92vw); max-height:88vh; overflow:auto;
    background:linear-gradient(165deg,#143150,#0a1828);
    border:1px solid rgba(243,196,90,.35); border-radius:18px;
    padding:34px 32px 28px; text-align:center;
    box-shadow:0 24px 60px rgba(0,0,0,.6);
  }
  .panel h2{
    margin:0 0 4px; font-family:'Cinzel',serif; letter-spacing:.08em; font-size:21px;
    color:var(--gold-light);
  }
  .close-x{
    position:absolute; top:12px; right:14px; width:32px; height:32px; border-radius:50%;
    border:1px solid rgba(255,255,255,.2); background:rgba(255,255,255,.05); color:#fff;
    cursor:pointer; font-size:15px;
  }
  .close-x:hover{ background:rgba(255,255,255,.15); }

  .balance-row{
    margin:14px 0 18px; font-size:14px; color:#cfe0ef;
    display:flex; align-items:center; justify-content:center; gap:8px; flex-wrap:wrap;
  }
  .balance-val{ font-weight:700; color:var(--gold-light); font-size:16px; }
  .demo-tag{
    font-size:10.5px; letter-spacing:.1em; padding:2px 8px; border-radius:10px;
    background:rgba(63,209,93,.18); color:#7be592; border:1px solid rgba(63,209,93,.4);
  }
  .reset-link{ background:none; border:none; color:#7fb8e6; font-size:12px; cursor:pointer; text-decoration:underline; margin-left:4px; }

  #coinCanvas{ display:block; margin:6px auto 14px; }

  .controls label{ font-size:12.5px; letter-spacing:.08em; color:#aebfd1; text-transform:uppercase; }
  .bet-input-row{ display:flex; align-items:center; justify-content:center; gap:8px; margin:8px 0 18px; }
  .bet-input-row button{
    width:36px; height:36px; border-radius:8px; border:1px solid rgba(255,255,255,.18);
    background:rgba(255,255,255,.06); color:#fff; font-size:18px; cursor:pointer;
  }
  .bet-input-row input{
    width:90px; text-align:center; font-size:16px; padding:8px 6px; border-radius:8px;
    border:1px solid rgba(255,255,255,.2); background:rgba(255,255,255,.08); color:#fff;
  }

  .side-choice{ display:flex; gap:10px; justify-content:center; margin-bottom:18px; }
  .choice-btn{
    flex:1; max-width:140px; padding:11px 0; border-radius:24px; cursor:pointer;
    border:2px solid rgba(255,255,255,.18); background:rgba(255,255,255,.05);
    color:#dce6ef; font-family:'Cinzel',serif; font-weight:600; letter-spacing:.1em; font-size:13px;
    transition:all .15s;
  }
  .choice-btn.active{
    border-color:var(--gold); background:linear-gradient(180deg, rgba(243,196,90,.28), rgba(243,196,90,.08));
    color:var(--gold-light); box-shadow:0 0 12px rgba(243,196,90,.35);
  }

  .flip-btn, .cashout-btn, .start-btn{
    width:100%; padding:13px 0; border-radius:30px; cursor:pointer; font-family:'Cinzel',serif;
    font-weight:700; letter-spacing:.14em; font-size:14px; border:2px solid #b5872c;
    box-shadow:0 6px 14px rgba(0,0,0,.4); margin-top:4px; transition:transform .15s;
  }
  .flip-btn, .start-btn{ background:linear-gradient(180deg,var(--green-1),var(--green-2)); color:#103a0e; }
  .cashout-btn{ background:linear-gradient(180deg,#ffd877,#c8902f); color:#3a2308; margin-top:10px; }
  .flip-btn:hover, .cashout-btn:hover, .start-btn:hover{ transform:translateY(-2px); }
  .flip-btn:disabled, .cashout-btn:disabled, .start-btn:disabled{ opacity:.45; cursor:not-allowed; transform:none; }

  .double-info{ font-size:14px; color:#dce6ef; margin-bottom:14px; }
  .double-info b{ color:var(--gold-light); font-size:17px; }

  .result-msg{ min-height:22px; margin-top:16px; font-size:14.5px; font-weight:600; }
  .result-msg.win{ color:#7be592; }
  .result-msg.lose{ color:#ff8a72; }
  .result-msg.info{ color:#9fc3e6; }

  .rules-list{ text-align:left; font-size:14px; line-height:1.6; color:#d6e2ee; padding-left:18px; margin:14px 0 4px; }

  @media (max-width:760px){
    .side-rail, .bottom-hub{ display:none; }
    .cards-row{ gap:36px; }
    .demo-badge{ right:16px; bottom:74px; }
    .bell-btn{ bottom:16px; right:16px; }
  }

  /* ── NEW GAME OVERLAY ── */
  #gameOverlay {
    position: fixed; inset: 0; z-index: 100;
    display: none;
    background: #1a3a5c;
    font-family: 'Cinzel', serif;
    user-select: none;
    overflow: hidden;
  }
  #gameOverlay.open {
    display: flex;
    flex-direction: column;
  }
  
  #gameOverlay #overlayBgVideo {
    position: absolute; inset: 0; z-index: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    pointer-events: none;
  }


  #gameOverlay #app {
    position: relative; z-index: 1;
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  #gameOverlay #topBar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px 0;
    position: relative;
    z-index: 10;
  }

  #gameOverlay #breadcrumb {
    font-family: 'Cinzel', serif;
    font-size: 12px;
    color: #ffffff;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    letter-spacing: 1.5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  #gameOverlay #breadcrumb span { color: #f5c842; }

  #gameOverlay #jackpotBtn {
    background: linear-gradient(180deg, #2a1a0a 0%, #1a0d04 100%);
    border: 2px solid #c8912a;
    border-radius: 6px;
    padding: 8px 28px;
    font-family: 'Cinzel Decorative', cursive;
    font-size: 16px;
    font-weight: 900;
    color: #f5c842;
    letter-spacing: 3px;
    text-shadow: 0 0 10px #f5c84280;
    cursor: pointer;
    box-shadow: 0 0 20px rgba(200,145,42,0.3), inset 0 1px 0 rgba(255,255,255,0.1);
    transition: box-shadow 0.3s;
  }
  #gameOverlay #jackpotBtn:hover { box-shadow: 0 0 30px rgba(245,200,66,0.5), inset 0 1px 0 rgba(255,255,255,0.1); }

  #gameOverlay #mainArea {
    flex: 1;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  #gameOverlay #mermaidCanvas {
    position: absolute;
    bottom: 0; left: -10px;
    width: 380px; height: 540px;
    z-index: 2;
  }

  #gameOverlay #centerContent {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-bottom: 0px;
    margin-top: -60px;
    position: relative;
    z-index: 5;
    margin-left: 320px;
    margin-right: 260px;
  }



  #gameOverlay #banner {
    position: relative;
    margin-bottom: 12px;
    animation: bannerFloat 3s ease-in-out infinite;
  }
  @keyframes bannerFloat {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }

  #gameOverlay #bannerCanvas { display: block; }

  #gameOverlay #bannerText {
    position: absolute;
    top: 52%; left: 50%;
    transform: translate(-50%,-50%);
    font-family: 'Cinzel', serif;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
    letter-spacing: 1.5px;
    text-align: center;
    width: 260px;
    line-height: 1.35;
    pointer-events: none;
  }

  #gameOverlay #coinContainer {
    margin-bottom: 22px;
    perspective: 600px;
  }

  #gameOverlay #coinCanvas {
    display: block;
    filter: drop-shadow(0 8px 20px rgba(0,0,0,0.5));
  }

  #gameOverlay #choiceRow {
    display: flex;
    gap: 12px;
    margin-bottom: 14px;
    align-items: center;
  }

  #gameOverlay .choiceBtn {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 30px;
    border-radius: 30px;
    border: none;
    cursor: pointer;
    font-family: 'Cinzel', serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 2px;
    transition: all 0.2s;
    min-width: 145px;
    justify-content: center;
  }

  #gameOverlay #headsBtn {
    background: linear-gradient(180deg, #48c6e8 0%, #1a8ab0 100%);
    color: #fff;
    box-shadow: 0 4px 12px rgba(72,198,232,0.4), inset 0 1px 0 rgba(255,255,255,0.3);
  }
  #gameOverlay #headsBtn.active {
    background: linear-gradient(180deg, #60d8f8 0%, #1a9acc 100%);
    box-shadow: 0 0 20px rgba(72,198,232,0.7), inset 0 1px 0 rgba(255,255,255,0.3);
    transform: scale(1.05);
  }

  #gameOverlay #tailsBtn {
    background: linear-gradient(180deg, #f5c842 0%, #c8912a 100%);
    color: #5a3200;
    box-shadow: 0 4px 12px rgba(245,200,66,0.4), inset 0 1px 0 rgba(255,255,255,0.3);
  }
  #gameOverlay #tailsBtn.active {
    background: linear-gradient(180deg, #ffe066 0%, #d4a030 100%);
    box-shadow: 0 0 20px rgba(245,200,66,0.8), inset 0 1px 0 rgba(255,255,255,0.3);
    transform: scale(1.05);
  }

  #gameOverlay .choiceBtn:hover { transform: scale(1.04); }
  #gameOverlay .choiceBtn.active:hover { transform: scale(1.06); }

  #gameOverlay .choiceIcon {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5c842, #c8912a);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    flex-shrink: 0;
  }

  #gameOverlay .choiceMult {
    background: url('/assets/image/headsortals/2.png') no-repeat center center;
    background-size: cover;
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    font-weight: 900;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
  }


  #gameOverlay #stakePanel {
    background: linear-gradient(180deg, #8b3a1a 0%, #5a2010 100%);
    border: 2px solid #c8912a;
    border-radius: 14px;
    padding: 12px 18px 16px;
    width: 100%;
    max-width: 560px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,220,120,0.2);
  }

  #gameOverlay #stakeLabel {
    text-align: center;
    font-family: 'Cinzel', serif;
    font-size: 11px;
    color: #f5c842;
    letter-spacing: 2px;
    margin-bottom: 8px;
  }

  #gameOverlay #stakeRow {
    display: flex;
    gap: 6px;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
    justify-content: center;
  }

  #gameOverlay .stakeIconBtn {
    width: 40px; height: 40px;
    border-radius: 50%;
    border: 2px solid #c8912a;
    background: linear-gradient(180deg, #f5c842 0%, #c8912a 100%);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.15s;
    box-shadow: 0 3px 8px rgba(0,0,0,0.4);
    flex-shrink: 0;
  }
  #gameOverlay .stakeIconBtn:hover { transform: scale(1.1); }

  #gameOverlay .stakeChip {
    flex: 1;
    padding: 8px 4px;
    border-radius: 20px;
    border: 2px solid #a06020;
    background: linear-gradient(180deg, #3a1808 0%, #2a1005 100%);
    color: #f0d080;
    font-family: 'Cinzel', serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    text-align: center;
    min-width: 46px;
  }
  #gameOverlay .stakeChip:hover, #gameOverlay .stakeChip.sel {
    background: linear-gradient(180deg, #f5c842 0%, #c8912a 100%);
    color: #3a1808;
    border-color: #f5c842;
    box-shadow: 0 0 10px rgba(245,200,66,0.4);
  }

  #gameOverlay #playRow {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 4px;
  }

  #gameOverlay #playBtn {
    width: 58px; height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, #48c6e8 0%, #1a8ab0 100%);
    border: 3px solid rgba(255,255,255,0.5);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    box-shadow: 0 0 20px rgba(72,198,232,0.6), 0 4px 12px rgba(0,0,0,0.5);
    transition: all 0.2s;
    flex-shrink: 0;
  }
  #gameOverlay #playBtn:hover { transform: scale(1.08); box-shadow: 0 0 30px rgba(72,198,232,0.9), 0 4px 12px rgba(0,0,0,0.5); }
  #gameOverlay #playBtn:active { transform: scale(0.95); }
  #gameOverlay #playBtn svg { width: 24px; height: 24px; }

  #gameOverlay #stakeInput {
    flex: 1;
    background: linear-gradient(180deg, #1a0a04 0%, #0d0502 100%);
    border: 2px solid #5a3010;
    border-radius: 8px;
    padding: 12px 16px;
    color: #f0d080;
    font-family: 'Cinzel', serif;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 52px;
  }

  #gameOverlay #clearStake {
    background: none;
    border: none;
    color: #c87040;
    font-size: 20px;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
    transition: color 0.15s;
  }
  #gameOverlay #clearStake:hover { color: #f09060; }

  #gameOverlay #rightPanel {
    width: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 0;
    position: absolute;
    top: 80px;
    bottom: 24px;
    right: 20px;
    z-index: 5;
  }

  #gameOverlay #fixedStakeBtn {
    background: linear-gradient(180deg, #3a1a08 0%, #2a1005 100%);
    border: 2px solid #c8912a;
    border-radius: 30px 30px 8px 8px;
    padding: 10px 18px 8px;
    display: flex; align-items: center; gap: 8px;
    cursor: pointer;
    margin-bottom: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.4);
    width: 100%;
    justify-content: center;
  }

  #gameOverlay .wheelIcon {
    width: 48px; height: 48px;
    position: relative;
    flex-shrink: 0;
  }

  #gameOverlay #fixedStakeLabel {
    font-family: 'Cinzel', serif;
    font-size: 11px;
    color: #f5c842;
    letter-spacing: 1.5px;
    font-weight: 700;
  }

  #gameOverlay #historyBoard {
    background: linear-gradient(180deg, #3a1a08 0%, #2a1005 100%);
    border: 2px solid #7a4818;
    border-radius: 8px;
    width: 100%;
    flex: 1;
    overflow-y: auto;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    box-shadow: inset 0 2px 8px rgba(0,0,0,0.5);
  }

  #gameOverlay #historyBoard::-webkit-scrollbar { width: 4px; }
  #gameOverlay #historyBoard::-webkit-scrollbar-track { background: #1a0a04; }
  #gameOverlay #historyBoard::-webkit-scrollbar-thumb { background: #7a4818; border-radius: 2px; }

  #gameOverlay .histItem {
    border-radius: 6px;
    padding: 6px 10px;
    font-family: 'Cinzel', serif;
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 6px;
    animation: slideIn 0.3s ease;
  }

  #gameOverlay .histItem.loss {
    background: linear-gradient(90deg, #5a1010 0%, #3a0808 100%);
    color: #ff8080;
    border: 1px solid #8a2020;
  }
  #gameOverlay .histItem.win {
    background: linear-gradient(90deg, #1a5a28 0%, #0a3818 100%);
    color: #80ff80;
    border: 1px solid #208a30;
  }
  #gameOverlay .histItem .coin-sm {
    width: 22px; height: 22px; flex-shrink: 0;
  }

  #gameOverlay #demoBadge {
    display: none !important;
    position: fixed;
    bottom: 16px; right: 58px;
    background: rgba(0,0,0,0.6);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 4px;
    padding: 4px 10px;
    color: #aaa;
    font-size: 11px;
    letter-spacing: 1px;
    display: flex; align-items: center; gap: 6px;
    z-index: 20;
  }
  #gameOverlay #demoBadge::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #4cf;
    display: inline-block;
    animation: pulse 1.5s infinite;
  }

  #gameOverlay #sideIcons {
    position: fixed;
    right: 0; top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 0;
    z-index: 20;
  }
  #gameOverlay .sideIcon {
    width: 40px;
    background: rgba(20,10,4,0.85);
    border: 1px solid #4a2a10;
    border-right: none;
    color: #c8912a;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 10px 0;
    cursor: pointer;
    font-size: 18px;
    transition: background 0.2s;
  }
  #gameOverlay .sideIcon:first-child { border-radius: 8px 0 0 0; }
  #gameOverlay .sideIcon:last-child { border-radius: 0 0 0 8px; }
  #gameOverlay .sideIcon:hover { background: rgba(40,20,8,0.95); }
  #gameOverlay .sideIcon.num { font-family: 'Cinzel', serif; font-size: 14px; font-weight: 700; color: #f5c842; }

  #gameOverlay .winPopup {
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    background: linear-gradient(135deg, #f5c842, #c8912a);
    color: #3a1808;
    font-family: 'Cinzel Decorative', cursive;
    font-size: 28px;
    font-weight: 900;
    padding: 20px 40px;
    border-radius: 16px;
    border: 3px solid #fff;
    box-shadow: 0 0 50px rgba(245,200,66,0.8);
    z-index: 100;
    animation: popIn 0.4s cubic-bezier(0.34,1.56,0.64,1);
    pointer-events: none;
    text-align: center;
  }

  /* Game balance in top bar */
  #gameOverlay #gameBalance {
    font-family: 'Cinzel', serif;
    font-size: 14px;
    color: #fff;
    font-weight: 700;
    background: rgba(0,0,0,0.5);
    padding: 8px 18px;
    border-radius: 20px;
    border: 1.5px solid rgba(255,190,26,0.3);
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
  }
  #gameOverlay #gameBalance span {
    color: #f5c842;
    font-weight: 900;
  }

  #gameOverlay #closeGame {
    position: relative;
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,0.25);
    background: rgba(0,0,0,0.4);
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }
  #gameOverlay #closeGame:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.5); }

  #gameOverlay #cashOutBtn {
    flex: 1;
    background: linear-gradient(180deg, #f5c842 0%, #c8912a 100%);
    border: 2px solid #ffbe1a;
    border-radius: 8px;
    padding: 12px 16px;
    color: #3a1808;
    font-family: 'Cinzel', serif;
    font-size: 14px;
    font-weight: 900;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
    letter-spacing: 1px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #gameOverlay #cashOutBtn:hover { transform: scale(1.02); box-shadow: 0 0 15px rgba(245,200,66,0.6); }
</style>
</head>
<body>

<video id="bgVideo" autoplay muted loop playsinline>
  <source src="{{ asset('assets/image/headsortals/ইমেজটা_যেরকম_আছে_সেম_টু_সেম_এক.mp4') }}" type="video/mp4">
</video>

<svg style="width:0; height:0; position:absolute;">
  <defs>
    <radialGradient id="goldGrad" cx="35%" cy="30%" r="70%">
      <stop offset="0%" stop-color="#ffe9b0"/>
      <stop offset="55%" stop-color="#f3c45a"/>
      <stop offset="100%" stop-color="#c8902f"/>
    </radialGradient>
  </defs>
</svg>
<div class="vignette"></div>

<div class="stage">

  <header class="topbar">
    <nav class="breadcrumb">
      <span class="crumb active">ARCADE</span><span class="sep">/</span>
      <span class="crumb">OTHER GAMES</span><span class="sep">/</span>
      <span class="crumb active">HEADS OR TAILS</span>
    </nav>
    <div class="jackpot-badge">Jackpot</div>
  </header>

  <div class="title-block">
    <svg class="bolt-icon" width="34" height="68" viewBox="0 0 40 80"><path d="M22 0 L4 42 L18 42 L10 80 L36 34 L20 34 Z" fill="#5ec8ff"/></svg>
    <h1 class="game-title">HEADS<span class="sub">OR TAILS</span></h1>
  </div>

  <main class="cards-row">

    <!-- Fixed stake card -->
    <section class="card">
      <div class="card-decorations">
        <!-- Ship Helm (steering wheel) -->
        <svg class="helm-decor" viewBox="0 0 200 200">
          <circle cx="100" cy="100" r="12" fill="#5c2e0b" stroke="#331700" stroke-width="3"/>
          <circle cx="100" cy="100" r="40" fill="none" stroke="#5c2e0b" stroke-width="6"/>
          <circle cx="100" cy="100" r="65" fill="none" stroke="#4a2305" stroke-width="8"/>
          <!-- Spokes -->
          <g stroke="#4a2305" stroke-width="6" stroke-linecap="round">
            <line x1="100" y1="15" x2="100" y2="185"/>
            <line x1="15" y1="100" x2="185" y2="100"/>
            <line x1="40" y1="40" x2="160" y2="160"/>
            <line x1="40" y1="160" x2="160" y2="40"/>
          </g>
          <!-- Knobs -->
          <g fill="#4a2305">
            <circle cx="100" cy="12" r="5"/>
            <circle cx="100" cy="188" r="5"/>
            <circle cx="12" cy="100" r="5"/>
            <circle cx="188" cy="100" r="5"/>
            <circle cx="38" cy="38" r="5"/>
            <circle cx="162" cy="162" r="5"/>
            <circle cx="38" cy="162" r="5"/>
            <circle cx="162" cy="38" r="5"/>
          </g>
        </svg>
        <!-- Treasure Map -->
        <svg class="map-decor" viewBox="0 0 150 120">
          <path d="M 20 15 C 35 5, 115 25, 130 15 L 120 100 C 105 110, 25 90, 10 100 Z" fill="#ebcf96" stroke="#bda26a" stroke-width="2"/>
          <path d="M 35 35 Q 60 55 80 40 T 110 70" fill="none" stroke="#8c4711" stroke-width="3" stroke-dasharray="2,4"/>
          <path d="M 102 62 L 118 78 M 118 62 L 102 78" fill="none" stroke="#b81d13" stroke-width="4" stroke-linecap="round"/>
        </svg>
      </div>

      <!-- Emblem placed outside the banner to avoid clip-path clipping -->
      <div class="banner-emblem">
        <svg viewBox="0 0 64 64">
          <circle cx="32" cy="32" r="30" fill="url(#goldGrad)" stroke="#7a4d12" stroke-width="3"/>
          <circle cx="32" cy="32" r="18" fill="none" stroke="#7a4d12" stroke-dasharray="2 2" stroke-width="1.5"/>
          <path d="M32 20 C27 20, 26 27, 32 27 C38 27, 37 20, 32 20 Z" fill="#5a3a10"/>
          <path d="M32 27 C30 27, 26 31, 24 35 M32 27 C34 27, 38 31, 40 35 M30 27 C27 28, 24 39, 28 42 M34 27 C37 28, 40 39, 36 42" fill="none" stroke="#5a3a10" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </div>

      <div class="banner">
        <span>FIXED STAKE</span>
      </div>

      <div class="parchment">
        <p>Choose your stake and flip the coin.<br>Guessed right? Congratulations!<br>Your stake is doubled! Take your<br>winnings!</p>
      </div>
      <!-- Play button outside parchment to prevent clip-path cutting it off -->
      <button class="play-btn" data-mode="fixed">PLAY</button>
    </section>

    <!-- Doubling stake card -->
    <section class="card">
      <div class="card-decorations">
        <!-- Anchor -->
        <svg class="anchor-decor" viewBox="0 0 160 160">
          <path d="M 80 20 Q 95 40 80 60 T 95 110 T 60 130" fill="none" stroke="#8d6439" stroke-width="5" stroke-linecap="round" opacity="0.85"/>
          <g stroke="#39424d" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none">
            <circle cx="80" cy="22" r="10" stroke-width="6"/>
            <line x1="80" y1="32" x2="80" y2="120"/>
            <line x1="50" y1="45" x2="110" y2="45" stroke-width="6"/>
            <path d="M 40 90 C 40 130, 120 130, 120 90" stroke-width="10"/>
            <path d="M 33 93 L 42 85 L 47 97 Z" fill="#39424d" stroke-width="2"/>
            <path d="M 127 93 L 118 85 L 113 97 Z" fill="#39424d" stroke-width="2"/>
          </g>
        </svg>
      </div>

      <!-- Fire blast outside the banner so it does not get clipped by banner polygon -->
      <div class="fire-blast"></div>

      <!-- Overlapping Gold Medallions (Octopus + 10) outside the banner -->
      <div class="banner-emblem doubled">
        <svg class="coin-1" viewBox="0 0 64 64">
          <circle cx="32" cy="32" r="30" fill="url(#goldGrad)" stroke="#7a4d12" stroke-width="3"/>
          <circle cx="32" cy="32" r="18" fill="none" stroke="#7a4d12" stroke-dasharray="2 2" stroke-width="1.5"/>
          <path d="M32 20 C27 20, 26 27, 32 27 C38 27, 37 20, 32 20 Z" fill="#5a3a10"/>
          <path d="M32 27 C30 27, 26 31, 24 35 M32 27 C34 27, 38 31, 40 35 M30 27 C27 28, 24 39, 28 42 M34 27 C37 28, 40 39, 36 42" fill="none" stroke="#5a3a10" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <svg class="coin-2" viewBox="0 0 64 64">
          <circle cx="32" cy="32" r="30" fill="url(#goldGrad)" stroke="#7a4d12" stroke-width="3"/>
          <text x="32" y="38" font-size="18" text-anchor="middle" fill="#5a3a10" font-family="'Cinzel', Georgia, serif" font-weight="900">10</text>
        </svg>
      </div>

      <div class="banner fire">
        <span>DOUBLING YOUR STAKE</span>
      </div>

      <div class="parchment">
        <p>Start with a bet of 5 EUR and flip the<br>coin.<br>Guessed right? You can take your<br>winnings of 10 EUR<br>or flip the coin again...</p>
      </div>
      <!-- Play button outside parchment to prevent clip-path cutting it off -->
      <button class="play-btn" data-mode="double">PLAY</button>
    </section>

  </main>

  <aside class="side-rail">
    <button title="Settings"><i class="fas fa-cog"></i></button>
    <button title="Bonuses"><i class="fas fa-gift"></i></button>
    <button title="Other games"><i class="fas fa-dharmachakra"></i></button>
    <button title="Lucky 7" style="font-weight:900; font-family:'Cinzel',serif;">7</button>
    <button title="Cashier"><i class="fas fa-dollar-sign"></i></button>
  </aside>

  <div class="bottom-hub">
    <button class="hub-btn" id="helpBtn" title="How to play">?</button>
    <button class="hub-btn" id="soundBtn" title="Sound">🔊</button>
  </div>

  <button class="demo-badge" id="demoBadge"><span class="dot"></span> DEMO MODE <span style="opacity:.6">⌃</span></button>
  <button class="bell-btn" title="Notifications"><i class="fas fa-bell"></i></button>

</div>

<!-- Game overlay -->
<div class="overlay" id="gameOverlay">
  <video id="overlayBgVideo" autoplay muted loop playsinline>
    <source src="{{ asset('assets/image/headsortals/video1.mp4') }}" type="video/mp4">
  </video>


  <div id="app">
    <!-- TOP BAR -->
    <div id="topBar">
      <div id="breadcrumb">XGAMES / <span>OTHER GAMES</span> / <span>HEADS OR TAILS</span></div>
      <div id="gameBalance">BALANCE: <span id="overlayBalanceDisplay">1000.00</span> EUR</div>
      <button id="jackpotBtn">JACKPOT</button>
    </div>

    <!-- MAIN -->
    <div id="mainArea">


      <!-- Center -->
      <div id="centerContent">
        <!-- Banner -->
        <div id="banner">
          <canvas id="bannerCanvas" width="380" height="80"></canvas>
          <div id="bannerText">MAKE YOUR CHOICE! HEADS OR TAILS?</div>
        </div>

        <!-- Coin -->
        <div id="coinContainer">
          <canvas id="coinCanvas" width="100" height="100"></canvas>
        </div>

        <!-- Choice buttons -->
        <div id="choiceRow">
          <button class="choiceBtn active" id="headsBtn" onclick="selectChoice('heads')">
            <img src="{{ asset('assets/image/headsortals/9.png') }}" class="choiceIcon" alt="🐙" style="border-radius: 50%;">
            HEADS
          </button>
          <button class="choiceBtn" id="tailsBtn" onclick="selectChoice('tails')">
            TAILS
            <div class="choiceMult" id="tailsMult">2</div>
          </button>
        </div>


        <!-- Stake panel -->
        <div id="stakePanel">
          <div id="stakeLabel">YOUR STAKE</div>
          <div id="stakeRow">
            <!-- Rendered dynamically depending on the mode -->
          </div>
          <div id="playRow">
            <button id="playBtn" onclick="flip()">
              <svg viewBox="0 0 24 24" fill="white"><polygon points="5,3 19,12 5,21"/></svg>
            </button>
            <div id="stakeInput">
              <span id="stakeDisplay">1</span>
              <button id="clearStake" onclick="clearStakeVal()">✕</button>
            </div>
            <button id="cashOutBtn" style="display: none;" onclick="cashOut()">CASH OUT</button>
          </div>
        </div>

      </div>

      <!-- Right panel -->
      <div id="rightPanel">
        <div id="fixedStakeBtn">
          <canvas class="wheelIcon" id="wheelCanvas" width="48" height="48"></canvas>
          <div id="fixedStakeLabel">FIXED STAKE</div>
        </div>
        <div id="historyBoard"></div>
      </div>
    </div>
  </div>

  <!-- Side icons -->
  <div id="sideIcons">
    <div class="sideIcon" id="sideInfoBtn">ℹ</div>
    <div class="sideIcon" onclick="showPopupMessage('Gift rewards coming soon!')">🎁</div>
    <div class="sideIcon num" onclick="showPopupMessage('Lucky 7 game mode coming soon!')">7</div>
    <div class="sideIcon" onclick="showPopupMessage('Special visual effects coming soon!')">✦</div>
    <div class="sideIcon" onclick="showPopupMessage('Cashier: credits are virtual!')">💲</div>
  </div>

  <!-- Demo badge -->
  <div id="demoBadge">DEMO MODE ▲</div>
</div>

<!-- Help overlay -->
<div class="overlay" id="helpOverlay">
  <div class="panel">
    <button class="close-x" id="closeHelp">✕</button>
    <h2>How To Play</h2>
    <ul class="rules-list">
      <li><b>Fixed Stake</b> — pick heads or tails and choose your bet. Guess right and your stake is doubled. Guess wrong and you lose the bet.</li>
      <li><b>Doubling Your Stake</b> — start a round for 5 EUR. Every correct guess doubles your prize. After any win you may cash out, or risk it all on the next flip. One wrong guess loses the whole prize.</li>
      <li>Balances are virtual play credits, not real money.</li>
    </ul>
  </div>
</div>

<script>
// ═══════════════════════════════════════════
// ═══════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════
const headsImg = new Image();
headsImg.src = "{{ asset('assets/image/headsortals/9.png') }}";
const tailsImg = new Image();
tailsImg.src = "{{ asset('assets/image/headsortals/2.png') }}";

let balance = parseFloat(localStorage.getItem('heads_tails_balance')) || 1000.00;
let stake = 1;
let choice = 'heads';
let activeMode = 'fixed'; // 'fixed' or 'double'
let gameActive = false;


// Doubling Mode round states
let doubleRoundActive = false;
let claimablePrize = 0;
let currentDoublePrize = 10;

// Autoplay
let autoplayActive = false;

// ═══════════════════════════════════════════
// AUDIO SYNTHESIZER
// ═══════════════════════════════════════════
let audioCtx = null;
let soundEnabled = true;

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

    if (type === 'coin') {
      osc.type = 'sine';
      osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
      osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.08); // A5
      gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.22);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.22);
    } else if (type === 'win') {
      const now = audioCtx.currentTime;
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(523.25, now); // C5
      osc.frequency.setValueAtTime(659.25, now + 0.08); // E5
      osc.frequency.setValueAtTime(783.99, now + 0.16); // G5
      osc.frequency.setValueAtTime(1046.50, now + 0.24); // C6
      gain.gain.setValueAtTime(0.12, now);
      gain.gain.exponentialRampToValueAtTime(0.01, now + 0.45);
      osc.start();
      osc.stop(now + 0.45);
    } else if (type === 'loss') {
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(220, audioCtx.currentTime); // A3
      osc.frequency.exponentialRampToValueAtTime(110, audioCtx.currentTime + 0.35); // A2
      gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.35);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.35);
    } else if (type === 'click') {
      osc.type = 'sine';
      osc.frequency.setValueAtTime(450, audioCtx.currentTime);
      gain.gain.setValueAtTime(0.03, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.04);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.04);
    }
  } catch (e) {
    console.warn("Audio Context init/playback failed:", e);
  }
}

// Bind sound toggle in lobby
document.getElementById('soundBtn').addEventListener('click', function(e) {
  soundEnabled = !soundEnabled;
  e.currentTarget.textContent = soundEnabled ? '🔊' : '🔇';
});

// ═══════════════════════════════════════════
// BG VIDEO - video1.mp4 handles the background
// ═══════════════════════════════════════════
function resizeBg() {}
function drawBg() {}


function drawCloud(ctx, x, y, w, h) {
  ctx.save();
  ctx.fillStyle = 'rgba(255,255,255,0.88)';
  ctx.shadowColor = 'rgba(200,220,255,0.4)';
  ctx.shadowBlur = 10;
  const r = h/2;
  ctx.beginPath();
  ctx.ellipse(x, y, w*0.5, r, 0, 0, Math.PI*2);
  ctx.fill();
  ctx.beginPath();
  ctx.ellipse(x-w*0.22, y+r*0.3, w*0.28, r*0.7, 0, 0, Math.PI*2);
  ctx.fill();
  ctx.beginPath();
  ctx.ellipse(x+w*0.22, y+r*0.2, w*0.32, r*0.75, 0, 0, Math.PI*2);
  ctx.fill();
  ctx.restore();
}

// ═══════════════════════════════════════════
// LOGO CANVAS (Overlay Logo)
// ═══════════════════════════════════════════
function drawLogo() {
  const c = document.getElementById('logoCanvas');
  if (!c) return;
  const x = c.getContext('2d');
  x.clearRect(0,0,120,60);

  x.font = 'bold 22px "Cinzel Decorative", serif';
  x.fillStyle = '#f5c842';
  x.strokeStyle = '#8a5010';
  x.lineWidth = 3;
  x.strokeText('HEADS', 5, 25);
  x.fillText('HEADS', 5, 25);

  x.font = 'bold 14px "Cinzel", serif';
  x.fillStyle = '#ffffff';
  x.fillText('OR', 10, 42);

  x.font = 'bold 20px "Cinzel Decorative", serif';
  x.fillStyle = '#f5c842';
  x.strokeStyle = '#8a5010';
  x.lineWidth = 2;
  x.strokeText('TAILS', 30, 55);
  x.fillText('TAILS', 30, 55);
}

// ═══════════════════════════════════════════
// BANNER CANVAS (Ribbon Ribbon Details)
// ═══════════════════════════════════════════
function drawBanner() {
  const c = document.getElementById('bannerCanvas');
  if (!c) return;
  const x = c.getContext('2d');
  const W = 380, H = 80;
  x.clearRect(0,0,W,H);

  // Banner ribbon shape
  const grad = x.createLinearGradient(0,0,0,H);
  grad.addColorStop(0,'#e8723a');
  grad.addColorStop(0.5,'#c85828');
  grad.addColorStop(1,'#a04010');
  x.fillStyle = grad;
  x.beginPath();
  x.moveTo(20,8);
  x.lineTo(W-20,8);
  x.lineTo(W-5,H-5);
  x.lineTo(W*0.75,H-18);
  x.lineTo(W*0.5,H-8);
  x.lineTo(W*0.25,H-18);
  x.lineTo(5,H-5);
  x.closePath();
  x.fill();

  // Border
  x.strokeStyle = '#f0a060';
  x.lineWidth = 2;
  x.stroke();

  // Octopus coin at top center
  x.save();
  x.translate(W/2, 4);
  if (headsImg.complete && headsImg.naturalWidth !== 0) {
    x.drawImage(headsImg, -18, -18, 36, 36);
  } else {
    drawCoinSmall(x, 18, '#f5c842', '#c8912a', '🐙', true);
  }
  x.restore();


  // Pirate papers on right
  drawPaperScroll(x, W*0.72, -5, 60, 50);
}

function drawPaperScroll(ctx, x, y, w, h) {
  ctx.save();
  ctx.translate(x,y);
  ctx.rotate(0.15);
  ctx.fillStyle = '#f0e0c0';
  ctx.strokeStyle = '#c0a060';
  ctx.lineWidth = 1;
  ctx.beginPath();
  ctx.roundRect(0,0,w,h,4);
  ctx.fill(); ctx.stroke();
  // X mark
  ctx.strokeStyle = '#c03020';
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.moveTo(w*0.55,h*0.4); ctx.lineTo(w*0.8,h*0.7);
  ctx.moveTo(w*0.8,h*0.4); ctx.lineTo(w*0.55,h*0.7);
  ctx.stroke();
  ctx.restore();

  // Second paper
  ctx.save();
  ctx.translate(x+8,y-6);
  ctx.rotate(-0.1);
  ctx.fillStyle = '#efe0b0';
  ctx.strokeStyle = '#c0a060';
  ctx.lineWidth = 1;
  ctx.beginPath();
  ctx.roundRect(0,0,w*0.8,h*0.9,4);
  ctx.fill(); ctx.stroke();
  ctx.restore();
}

function drawCoinSmall(ctx, r, c1, c2, sym, top) {
  const grad = ctx.createRadialGradient(-r*0.3,-r*0.3,0,0,0,r);
  grad.addColorStop(0,'#ffe880');
  grad.addColorStop(0.6,c1);
  grad.addColorStop(1,c2);
  ctx.fillStyle = grad;
  ctx.strokeStyle = c2;
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.arc(0,0,r,0,Math.PI*2);
  ctx.fill(); ctx.stroke();
  if (sym) {
    ctx.font = `${r}px serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(sym, 0, 1);
  }
}

// ═══════════════════════════════════════════
// COIN CANVAS (Flipping Eased Rotation)
// ═══════════════════════════════════════════
let coinPhase = 0;
let coinSpinning = false;
let coinSpinSpeed = 0;
let coinSpinResult = null;
let coinSpinDone = false;

function drawCoin() {
  const c = document.getElementById('coinCanvas');
  if (!c) return;
  const x = c.getContext('2d');
  const W = 100, H = 100;
  x.clearRect(0,0,W,H);

  const cx = W/2, cy = H/2, r = 42;

  // Shadow
  x.save();
  x.fillStyle = 'rgba(0,0,0,0.25)';
  x.beginPath();
  x.ellipse(cx+4, cy+6, r, r*0.2, 0, 0, Math.PI*2);
  x.fill();
  x.restore();

  // Coin body
  x.save();
  x.translate(cx,cy);

  let scaleX = 1;
  if (coinSpinning) {
    coinPhase += coinSpinSpeed;
    scaleX = Math.cos(coinPhase);
    coinSpinSpeed *= 0.985;
    if (coinSpinSpeed < 0.02) {
      coinSpinning = false;
      coinSpinDone = true;
      scaleX = 1;
      onCoinLanded();
    }
  }

  x.scale(Math.abs(scaleX) < 0.05 ? 0.05 : scaleX, 1);

  const showHeads = (coinSpinResult === null) ? true :
    (coinSpinDone ? coinSpinResult === 'heads' : (Math.floor(coinPhase/0.5)%2===0));

  const imgToDraw = showHeads ? headsImg : tailsImg;
  if (imgToDraw.complete && imgToDraw.naturalWidth !== 0) {
    x.drawImage(imgToDraw, -r, -r, r*2, r*2);
  } else {
    // Edge highlight
    x.strokeStyle = '#8a6010';
    x.lineWidth = 5;
    x.beginPath();
    x.arc(0,0,r,0,Math.PI*2);
    x.stroke();

    // Face
    const grad = x.createRadialGradient(-r*0.3,-r*0.3,0,0,0,r);
    grad.addColorStop(0,'#ffe880');
    grad.addColorStop(0.5,'#f5c842');
    grad.addColorStop(1,'#c8912a');
    x.fillStyle = grad;
    x.beginPath();
    x.arc(0,0,r,0,Math.PI*2);
    x.fill();

    // Inner circle
    x.strokeStyle = 'rgba(200,145,42,0.5)';
    x.lineWidth = 2;
    x.beginPath();
    x.arc(0,0,r*0.8,0,Math.PI*2);
    x.stroke();

    x.fillStyle = '#a06010';
    x.font = 'bold 32px "Cinzel", serif';
    x.textAlign = 'center';
    x.textBaseline = 'middle';
    x.fillText(showHeads ? '10' : '⚓', 0, 2);
  }

  x.restore();

}

// ═══════════════════════════════════════════
// MERMAID CANVAS (Shimmering & Flowing animations)
// ═══════════════════════════════════════════
function drawMermaid() {}


// ═══════════════════════════════════════════
// WHEEL CANVAS (Home / Lobby Exit Button)
// ═══════════════════════════════════════════
let wheelAngle = 0;
function drawWheel() {
  const c = document.getElementById('wheelCanvas');
  if (!c) return;
  const x = c.getContext('2d');
  const W = 48, H = 48, cx = W/2, cy = H/2, r = 22;
  x.clearRect(0,0,W,H);

  x.save();
  x.translate(cx,cy);
  x.rotate(wheelAngle);
  wheelAngle += 0.005;

  // Rim
  x.strokeStyle = '#8a5010';
  x.lineWidth = 4;
  x.beginPath();
  x.arc(0,0,r,0,Math.PI*2);
  x.stroke();

  // Spokes
  x.strokeStyle = '#8a5010';
  x.lineWidth = 2.5;
  for (let i = 0; i < 8; i++) {
    const a = (i/8)*Math.PI*2;
    x.beginPath();
    x.moveTo(0,0);
    x.lineTo(Math.cos(a)*r, Math.sin(a)*r);
    x.stroke();
  }

  // Hub
  const hubGrad = x.createRadialGradient(0,0,0,0,0,8);
  hubGrad.addColorStop(0,'#f5c842');
  hubGrad.addColorStop(1,'#c8912a');
  x.fillStyle = hubGrad;
  x.beginPath();
  x.arc(0,0,8,0,Math.PI*2);
  x.fill();

  // House icon
  x.fillStyle = '#3a1808';
  x.font = '10px serif';
  x.textAlign = 'center';
  x.textBaseline = 'middle';
  x.fillText('🏠', 0, 1);

  x.restore();
}

// Wire exit to fixedStakeBtn wheel
document.getElementById('fixedStakeBtn').addEventListener('click', function() {
  playSound('click');
  closeGame();
});

// ═══════════════════════════════════════════
// HISTORY BOARD
// ═══════════════════════════════════════════
let history = [];

function addHistory(won, amount) {
  const board = document.getElementById('historyBoard');
  if (!board) return;
  const coinSrc = "{{ asset('assets/image/headsortals/2.png') }}";
  if (won) {
    const win = document.createElement('div');
    win.className = 'histItem win';
    win.innerHTML = `<img class="coin-sm" src="${coinSrc}"><span>Winnings:<br>${amount.toFixed(2)} EUR</span>`;
    board.prepend(win);
  } else {
    const loss = document.createElement('div');
    loss.className = 'histItem loss';
    loss.innerHTML = `<img class="coin-sm" src="${coinSrc}"><span>Loss.</span>`;
    board.prepend(loss);
  }
  // Max 20 items
  while (board.children.length > 20) board.removeChild(board.lastChild);
}




// ═══════════════════════════════════════════
// GAME SELECTION AND CORE LOGIC
// ═══════════════════════════════════════════
window.selectChoice = function(c) {
  if (coinSpinning) return;
  playSound('click');
  choice = c;
  document.getElementById('headsBtn').classList.toggle('active', c === 'heads');
  document.getElementById('tailsBtn').classList.toggle('active', c === 'tails');
};

window.setStake = function(v) {
  if (coinSpinning || activeMode === 'double') return;
  playSound('click');
  stake = v;
  document.getElementById('stakeDisplay').textContent = v;
  document.querySelectorAll('.stakeChip').forEach(btn => {
    btn.classList.toggle('sel', parseInt(btn.textContent) === v);
  });
};

window.clearStakeVal = function() {
  if (coinSpinning || activeMode === 'double') return;
  playSound('click');
  stake = 0;
  document.getElementById('stakeDisplay').textContent = '0';
  document.querySelectorAll('.stakeChip').forEach(b => b.classList.remove('sel'));
};

function saveBalance() {
  localStorage.setItem('heads_tails_balance', balance);
}

function updateBalanceDisplay() {
  const displays = [
    document.getElementById('overlayBalanceDisplay'),
    ...document.querySelectorAll('.balance-val')
  ];
  displays.forEach(d => {
    if (d) d.textContent = balance.toFixed(2);
  });
}

// Custom error/info banner alerts
function showPopupMessage(text) {
  const alertEl = document.createElement('div');
  alertEl.style.position = 'fixed';
  alertEl.style.top = '20px';
  alertEl.style.left = '50%';
  alertEl.style.transform = 'translateX(-50%)';
  alertEl.style.background = 'rgba(20, 10, 4, 0.95)';
  alertEl.style.color = '#f5c842';
  alertEl.style.border = '2px solid #c8912a';
  alertEl.style.borderRadius = '8px';
  alertEl.style.padding = '12px 24px';
  alertEl.style.fontFamily = 'Cinzel, serif';
  alertEl.style.fontSize = '14px';
  alertEl.style.zIndex = '1000';
  alertEl.style.boxShadow = '0 4px 15px rgba(0,0,0,0.5)';
  alertEl.style.letterSpacing = '1px';
  alertEl.textContent = text;
  document.body.appendChild(alertEl);
  setTimeout(() => {
    alertEl.style.transition = 'opacity 0.4s';
    alertEl.style.opacity = '0';
    setTimeout(() => alertEl.remove(), 400);
  }, 2000);
}

function renderStakeChips() {
  const row = document.getElementById('stakeRow');
  if (!row) return;
  if (activeMode === 'fixed') {
    row.innerHTML = `
      <div class="stakeIconBtn" id="gameHelpBtn" title="Info">❓</div>
      <div class="stakeIconBtn" id="gameAutoBtn" title="Auto">🎯</div>
      <div class="stakeChip ${stake===1?'sel':''}" onclick="setStake(1)">1</div>
      <div class="stakeChip ${stake===2?'sel':''}" onclick="setStake(2)">2</div>
      <div class="stakeChip ${stake===3?'sel':''}" onclick="setStake(3)">3</div>
      <div class="stakeChip ${stake===5?'sel':''}" onclick="setStake(5)">5</div>
      <div class="stakeChip ${stake===10?'sel':''}" onclick="setStake(10)">10</div>
      <div class="stakeChip ${stake===25?'sel':''}" onclick="setStake(25)">25</div>
    `;
  } else {
    row.innerHTML = `
      <div class="stakeIconBtn" id="gameHelpBtn" title="Info">❓</div>
      <div class="stakeChip sel">5</div>
      <div style="font-family:'Cinzel',serif;font-size:11px;color:#ffbe1a;margin-left:10px;letter-spacing:1px;">PROGRESSIVE DOUBLE MODE</div>
    `;
  }
  attachHelpAutoListeners();
}


function attachHelpAutoListeners() {
  const helpBtn = document.getElementById('gameHelpBtn');
  if (helpBtn) {
    helpBtn.onclick = function() {
      playSound('click');
      document.getElementById('helpOverlay').classList.add('open');
    };
  }
  const autoBtn = document.getElementById('gameAutoBtn');
  if (autoBtn) {
    autoBtn.onclick = function() {
      playSound('click');
      toggleAutoplay();
    };
  }
}

// Autoplay trigger
window.toggleAutoplay = function() {
  autoplayActive = !autoplayActive;
  const btn = document.getElementById('gameAutoBtn');
  if (btn) btn.classList.toggle('sel', autoplayActive);
  if (autoplayActive && !coinSpinning && activeMode === 'fixed' && stake > 0) {
    flip();
  }
};

window.flip = function() {
  if (coinSpinning) return;
  playSound('click');

  if (activeMode === 'fixed') {
    if (stake <= 0) {
      showPopupMessage("Choose a stake amount first!");
      return;
    }
    if (stake > balance) {
      showPopupMessage("Insufficient balance for this stake!");
      autoplayActive = false;
      const autoBtn = document.getElementById('gameAutoBtn');
      if (autoBtn) autoBtn.classList.remove('sel');
      return;
    }

    balance -= stake;
    saveBalance();
    updateBalanceDisplay();

    coinSpinResult = Math.random() < 0.5 ? 'heads' : 'tails';
    coinSpinDone = false;
    coinPhase = 0;
    coinSpinSpeed = 0.25 + Math.random()*0.1;
    coinSpinning = true;
    playSound('coin');

    document.getElementById('bannerText').textContent = '🪙 FLIPPING...';
  } else {
    // Doubling Stake mode round triggers
    if (!doubleRoundActive) {
      if (balance < 5) {
        showPopupMessage("Requires at least 5.00 EUR to start a doubling round!");
        return;
      }
      balance -= 5;
      saveBalance();
      updateBalanceDisplay();

      doubleRoundActive = true;
      claimablePrize = 0;
      currentDoublePrize = 10; // First round prize

      document.getElementById('stakeInput').style.display = 'none';
      const cBtn = document.getElementById('cashOutBtn');
      cBtn.style.display = 'flex';
      cBtn.disabled = true;
      cBtn.textContent = 'CASH OUT';

      document.getElementById('tailsMult').textContent = 'x2';
      setStake(5);

      // Trigger first round flip
      coinSpinResult = Math.random() < 0.5 ? 'heads' : 'tails';
      coinSpinDone = false;
      coinPhase = 0;
      coinSpinSpeed = 0.25 + Math.random()*0.1;
      coinSpinning = true;
      playSound('coin');
      document.getElementById('bannerText').textContent = '🪙 FLIPPING...';
    } else {
      // Active round progressive flip
      coinSpinResult = Math.random() < 0.5 ? 'heads' : 'tails';
      coinSpinDone = false;
      coinPhase = 0;
      coinSpinSpeed = 0.25 + Math.random()*0.1;
      coinSpinning = true;
      playSound('coin');
      document.getElementById('bannerText').textContent = '🪙 FLIPPING...';
    }
  }
};

function onCoinLanded() {
  if (activeMode === 'fixed') {
    const won = coinSpinResult === choice;
    const winAmount = won ? stake * 2 : 0;

    if (won) {
      balance += winAmount;
      saveBalance();
      updateBalanceDisplay();
      document.getElementById('bannerText').textContent = '🎉 YOU WIN! +' + winAmount + ' EUR';
      showWinPopup(winAmount);
      playSound('win');
    } else {
      document.getElementById('bannerText').textContent = 'BETTER LUCK NEXT TIME';
      playSound('loss');
    }

    addHistory(won, winAmount);

    if (autoplayActive) {
      setTimeout(() => {
        if (autoplayActive && !coinSpinning && balance >= stake && stake > 0) {
          flip();
        } else if (balance < stake) {
          autoplayActive = false;
          const autoBtn = document.getElementById('gameAutoBtn');
          if (autoBtn) autoBtn.classList.remove('sel');
          showPopupMessage("Autoplay stopped: Insufficient balance!");
        }
      }, 2000);
    } else {
      setTimeout(() => {
        if (!coinSpinning && !autoplayActive) {
          document.getElementById('bannerText').textContent = 'MAKE YOUR CHOICE! HEADS OR TAILS?';
        }
      }, 2500);
    }
  } else {
    // Doubling Mode Landed
    const won = coinSpinResult === choice;
    if (won) {
      playSound('win');
      showWinPopup(currentDoublePrize);
      document.getElementById('bannerText').textContent = '🎉 CORRECT! PRIZE: ' + currentDoublePrize + ' EUR';

      claimablePrize = currentDoublePrize;
      const cBtn = document.getElementById('cashOutBtn');
      cBtn.disabled = false;
      cBtn.textContent = `CASH OUT: ${claimablePrize} EUR`;

      // Next level target setup
      currentDoublePrize *= 2;
      document.getElementById('tailsMult').textContent = 'x' + (currentDoublePrize / 5);

      addHistory(true, claimablePrize);
    } else {
      playSound('loss');
      document.getElementById('bannerText').textContent = '⚓ LOST ROUND!';
      addHistory(false, 0);
      resetDoubleRoundState();
    }
  }
}

window.cashOut = function() {
  if (!doubleRoundActive || claimablePrize <= 0) return;
  playSound('win');
  balance += claimablePrize;
  saveBalance();
  updateBalanceDisplay();
  showWinPopup(claimablePrize);
  document.getElementById('bannerText').textContent = `🎉 CASHED OUT: +${claimablePrize} EUR`;
  resetDoubleRoundState();
};

function resetDoubleRoundState() {
  doubleRoundActive = false;
  claimablePrize = 0;
  currentDoublePrize = 10;
  document.getElementById('stakeInput').style.display = 'flex';
  document.getElementById('cashOutBtn').style.display = 'none';
  document.getElementById('tailsMult').textContent = '10';
  setTimeout(() => {
    if (!coinSpinning && activeMode === 'double') {
      document.getElementById('bannerText').textContent = 'START ROUND (5 EUR)';
    }
  }, 2500);
}

function showWinPopup(amount) {
  const el = document.createElement('div');
  el.className = 'winPopup';
  el.innerHTML = `🏆 YOU WIN!<br><span style="font-size:20px">${amount} EUR</span>`;
  document.body.appendChild(el);
  setTimeout(() => {
    el.style.transition = 'opacity 0.5s';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 500);
  }, 1800);
}

// ═══════════════════════════════════════════
// WINDOW OVERLAY TOGGLES
// ═══════════════════════════════════════════
function openGame(mode) {
  activeMode = mode;
  gameActive = true;

  // Initialize AudioContext under user gestures
  if (!audioCtx) {
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  }

  // Adjust display sizes
  resizeBg();
  drawLogo();
  drawBanner();

  document.getElementById('gameOverlay').classList.add('open');
  updateBalanceDisplay();

  const wheelLabel = document.getElementById('fixedStakeLabel');
  if (mode === 'fixed') {
    if (wheelLabel) wheelLabel.textContent = 'FIXED STAKE';
    setStake(1);
    document.getElementById('bannerText').textContent = 'MAKE YOUR CHOICE! HEADS OR TAILS?';
    document.getElementById('tailsMult').textContent = '2';
    document.getElementById('stakeInput').style.display = 'flex';
    document.getElementById('cashOutBtn').style.display = 'none';
  } else {
    if (wheelLabel) wheelLabel.textContent = 'DOUBLING STAKE';
    doubleRoundActive = false;
    claimablePrize = 0;
    currentDoublePrize = 10;
    document.getElementById('bannerText').textContent = 'START ROUND (5 EUR)';
    document.getElementById('tailsMult').textContent = '10';
    document.getElementById('stakeInput').style.display = 'flex';
    document.getElementById('cashOutBtn').style.display = 'none';
    setStake(5);
  }

  renderStakeChips();
  loop();
}

function closeGame() {
  gameActive = false;
  autoplayActive = false;
  doubleRoundActive = false;
  document.getElementById('gameOverlay').classList.remove('open');
}

// Hook play buttons from lobby cards
document.querySelectorAll('.play-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    openGame(btn.dataset.mode);
  });
});

// Sound button & help instructions from lobby header
document.getElementById('helpBtn').addEventListener('click', () => {
  playSound('click');
  document.getElementById('helpOverlay').classList.add('open');
});
document.getElementById('closeHelp').onclick = function() {
  playSound('click');
  document.getElementById('helpOverlay').classList.remove('open');
};
document.getElementById('helpOverlay').onclick = function(e) {
  if (e.target === this) this.classList.remove('open');
};

// Side info icon within overlay
document.getElementById('sideInfoBtn').onclick = function() {
  playSound('click');
  document.getElementById('helpOverlay').classList.add('open');
};

// ═══════════════════════════════════════════
// ANIMATION TICKER LOOP
// ═══════════════════════════════════════════
function loop() {
  if (!gameActive) return;
  drawBg();
  drawCoin();
  drawWheel();
  drawMermaid();
  requestAnimationFrame(loop);
}

// Screen resize binds
window.addEventListener('resize', () => {
  if (gameActive) resizeBg();
});
</script>
</body>
</html>

