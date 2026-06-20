<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>BonBon Bonanza — Candy Cascade</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{
    --sky-top:#87CEEB;
    --sky-bot:#C8EAFF;
    --grass:#4CBB47;
    --grass-dark:#3A9A35;
    --path:#E8C97A;
    --river:#5BAEF0;
    --accent-pink:#FF4FA3;
    --accent-gold:#FFD66B;
    --accent-lime:#B6FF6E;
    --accent-blue:#5FD8FF;
    --panel-bg:rgba(120,60,180,0.92);
    --panel-border:#C070FF;
    --btn-spin:linear-gradient(160deg,#FFD66B,#FF4FA3);
    --text-cream:#FFF3E6;
    --text-muted:#C9B8E8;
    --win-glow:rgba(255,214,107,0.9);
    --radius-lg:22px;
    --radius-md:14px;
    --radius-sm:9px;
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  html,body{width:100%;height:100%;overflow:hidden;}
  body{
    font-family:'Nunito',sans-serif;
    color:var(--text-cream);
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    background:#87CEEB;
  }
  @media(prefers-reduced-motion:reduce){*{animation-duration:0.01ms!important;transition-duration:0.01ms!important;}}

  /* ---- Canvas BG ---- */
  #bgCanvas{
    position:fixed;
    inset:0;
    width:100%;
    height:100%;
    z-index:0;
    display:block;
  }

  /* ---- Main layout ---- */
  .game-wrap{
    position:relative;
    z-index:2;
    width:100%;
    max-width:680px;
    padding:12px;
    display:flex;
    flex-direction:column;
    gap:10px;
  }

  /* ---- Title ---- */
  .brand-bar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:10px 16px;
    background:rgba(80,20,140,0.82);
    border-radius:var(--radius-lg) var(--radius-lg) 0 0;
    border:2px solid var(--panel-border);
    border-bottom:none;
    backdrop-filter:blur(6px);
  }
  .brand{
    font-family:'Fredoka',sans-serif;
    font-weight:700;
    font-size:clamp(20px,5vw,30px);
    letter-spacing:1px;
    background:linear-gradient(95deg,#FFD66B,#FF4FA3 55%,#5FD8FF);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    text-shadow:none;
    filter:drop-shadow(0 2px 8px rgba(255,214,107,0.5));
  }
  .brand-sub{
    font-family:'Nunito',sans-serif;
    font-size:10px;
    color:var(--text-muted);
    margin-left:4px;
    vertical-align:super;
  }
  .topbar-btns{display:flex;gap:6px;}
  .icon-btn{
    width:36px;height:36px;
    border-radius:50%;
    border:1.5px solid rgba(255,255,255,0.3);
    background:rgba(255,255,255,0.1);
    color:var(--text-cream);
    font-size:16px;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    transition:transform .15s,background .2s;
    backdrop-filter:blur(4px);
  }
  .icon-btn:hover{background:rgba(255,255,255,0.22);}
  .icon-btn:active{transform:scale(0.9);}

  /* ---- Game panel ---- */
  .game-panel{
    background:rgba(90,30,160,0.88);
    border:2px solid var(--panel-border);
    border-top:none;
    border-bottom:none;
    padding:10px 14px;
    backdrop-filter:blur(8px);
    position:relative;
  }

  /* ---- Grid frame decorative border (candy cane frame) ---- */
  .grid-outer{
    position:relative;
    background:linear-gradient(180deg,#6A1DB5 0%,#3A0878 100%);
    border-radius:var(--radius-md);
    padding:12px;
    border:4px solid #C8923A;
    box-shadow:0 0 0 2px #FFD66B,0 8px 24px -8px rgba(0,0,0,0.6);
  }
  .bonus-banner{
    position:absolute;
    top:-18px;left:50%;
    transform:translateX(-50%);
    background:linear-gradient(95deg,#FFD66B,#FF4FA3);
    color:#2A0060;
    font-family:'Fredoka',sans-serif;
    font-weight:700;
    font-size:13px;
    padding:6px 18px;
    border-radius:999px;
    box-shadow:0 6px 18px -4px rgba(255,214,107,0.7);
    z-index:5;
    white-space:nowrap;
    transition:opacity .25s,transform .25s;
  }
  .bonus-banner.hidden{opacity:0;transform:translateX(-50%) translateY(-8px);pointer-events:none;}

  /* ---- Grid ---- */
  .grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    grid-template-rows:repeat(5,1fr);
    gap:6px;
    aspect-ratio:6/5;
  }
  .cell{
    border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    font-size:clamp(16px,4vw,28px);
    position:relative;
    box-shadow:0 3px 0 rgba(0,0,0,0.25) inset,0 -2px 0 rgba(255,255,255,0.15) inset;
    transition:transform .25s cubic-bezier(.34,1.56,.64,1),opacity .2s;
    cursor:default;
    user-select:none;
  }
  .sym-candy{  background:linear-gradient(155deg,#FF8FCB,#FF4FA3);}
  .sym-lolli{  background:linear-gradient(155deg,#6FE8FF,#2BB6E0);}
  .sym-cookie{ background:linear-gradient(155deg,#E8B07A,#C8854A);}
  .sym-donut{  background:linear-gradient(155deg,#FFB6C7,#FF7FA0);}
  .sym-cupcake{background:linear-gradient(155deg,#D9B8FF,#A972F2);}
  .sym-cake{   background:linear-gradient(155deg,#FFE08A,#FFC447);}
  .sym-choco{  background:linear-gradient(155deg,#A9754A,#6B4423);}
  .sym-gem{    background:linear-gradient(155deg,#9CFFE0,#3BD6B0);}

  .cell.falling{transform:translateY(-140%);opacity:0;transition:transform .42s cubic-bezier(.22,.9,.32,1.18),opacity .25s;}
  .cell.settle{animation:settle .32s ease;}
  @keyframes settle{0%{transform:scale(1.2);}60%{transform:scale(0.93);}100%{transform:scale(1);}}
  .cell.win{
    box-shadow:0 0 0 3px var(--win-glow),0 0 20px 5px var(--win-glow);
    animation:winpulse .55s ease-in-out infinite;
    z-index:2;
  }
  @keyframes winpulse{0%,100%{transform:scale(1);}50%{transform:scale(1.12);}}
  .cell.pop{transform:scale(0);opacity:0;transition:transform .25s ease-in,opacity .22s ease-in;}

  /* ---- Boost row ---- */
  .boost-row{
    display:flex;align-items:center;justify-content:space-between;
    margin-top:8px;
    padding:8px 10px;
    background:rgba(255,255,255,0.06);
    border-radius:var(--radius-sm);
    border:1px solid rgba(255,255,255,0.08);
  }
  .boost-label{font-size:12.5px;font-weight:700;}
  .boost-sub{display:block;font-size:10.5px;color:var(--text-muted);font-weight:600;margin-top:2px;}
  .switch{position:relative;width:44px;height:24px;flex-shrink:0;}
  .switch input{opacity:0;width:0;height:0;position:absolute;}
  .switch label{
    position:absolute;inset:0;
    background:rgba(255,255,255,0.18);
    border-radius:999px;
    cursor:pointer;
    transition:background .2s;
  }
  .switch label::after{
    content:'';position:absolute;top:3px;left:3px;
    width:18px;height:18px;border-radius:50%;
    background:#fff;transition:transform .2s;
  }
  .switch input:checked+label{background:linear-gradient(95deg,var(--accent-pink),var(--accent-gold));}
  .switch input:checked+label::after{transform:translateX(20px);}
  .switch input:disabled+label{opacity:0.4;cursor:not-allowed;}

  .out-msg{margin-top:6px;font-size:12px;color:var(--accent-gold);text-align:center;font-weight:700;}
  .out-msg button{margin-left:6px;background:none;border:none;color:var(--accent-lime);text-decoration:underline;font-weight:800;cursor:pointer;font-size:12px;}
  .out-msg.hidden{display:none;}

  /* ---- Control bar ---- */
  .ctrl-bar{
    background:rgba(60,10,120,0.92);
    border:2px solid var(--panel-border);
    border-top:none;
    border-bottom:none;
    padding:14px 16px;
    display:flex;align-items:center;justify-content:space-between;
    gap:10px;flex-wrap:wrap;
    backdrop-filter:blur(8px);
  }
  .stat{display:flex;flex-direction:column;min-width:68px;}
  .stat .lbl{font-size:10px;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);font-weight:700;}
  .stat .val{font-size:17px;font-weight:800;font-variant-numeric:tabular-nums;}
  .stat.win-stat .val{color:var(--accent-lime);}

  .bet-ctrl{display:flex;align-items:center;gap:6px;}
  .round-btn{
    width:30px;height:30px;border-radius:50%;border:none;
    background:rgba(255,255,255,0.12);color:var(--text-cream);
    font-size:18px;font-weight:800;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:background .15s,transform .1s;
  }
  .round-btn:hover:not(:disabled){background:rgba(255,255,255,0.22);}
  .round-btn:active:not(:disabled){transform:scale(0.88);}
  .round-btn:disabled{opacity:0.3;cursor:not-allowed;}

  /* ---- SPIN button ---- */
  .spin-outer{
    flex:1 1 auto;
    min-width:110px;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
  }
  .spin-ring{
    position:absolute;
    width:100%;height:100%;
    border-radius:999px;
    background:conic-gradient(#FFD66B,#FF4FA3,#5FD8FF,#FFD66B);
    animation:spinRing 3s linear infinite;
    filter:blur(2px);
    opacity:0.7;
  }
  @keyframes spinRing{0%{transform:rotate(0);}100%{transform:rotate(360deg);}}
  .spin-btn{
    position:relative;
    z-index:1;
    font-family:'Fredoka',sans-serif;
    font-weight:700;
    font-size:17px;
    letter-spacing:0.5px;
    color:#2A0060;
    background:linear-gradient(160deg,#FFD66B,#FF8FCB);
    border:none;
    border-radius:999px;
    padding:13px 28px;
    cursor:pointer;
    box-shadow:0 6px 0 rgba(0,0,0,0.22),0 10px 22px -8px rgba(255,79,163,0.6);
    transition:transform .12s,box-shadow .12s,opacity .2s;
    width:100%;
  }
  .spin-btn:hover:not(:disabled){transform:translateY(-2px);}
  .spin-btn:active:not(:disabled){transform:translateY(3px);box-shadow:0 2px 0 rgba(0,0,0,0.22);}
  .spin-btn:disabled{opacity:0.5;cursor:not-allowed;}

  .toggles{display:flex;gap:6px;}
  .toggle-btn{
    font-family:'Nunito',sans-serif;
    font-weight:800;font-size:11px;letter-spacing:0.5px;
    color:var(--text-cream);
    background:rgba(255,255,255,0.09);
    border:1px solid rgba(255,255,255,0.12);
    border-radius:var(--radius-sm);
    padding:9px 11px;cursor:pointer;
    transition:background .15s,color .15s;
  }
  .toggle-btn.active{background:linear-gradient(95deg,var(--accent-lime),var(--accent-blue));color:#082018;border-color:transparent;}
  .toggle-btn:disabled{opacity:0.38;cursor:not-allowed;}

  /* ---- Footer ---- */
  .footer-bar{
    background:rgba(60,10,120,0.88);
    border:2px solid var(--panel-border);
    border-top:none;
    border-radius:0 0 var(--radius-lg) var(--radius-lg);
    padding:8px 16px;
    text-align:center;
    font-size:10.5px;color:var(--text-muted);font-weight:600;
    backdrop-filter:blur(6px);
  }

  /* ---- Modal ---- */
  .modal-overlay{
    position:fixed;inset:0;
    background:rgba(8,4,18,0.75);
    display:flex;align-items:center;justify-content:center;
    padding:20px;z-index:100;
  }
  .modal-overlay.hidden{display:none;}
  .modal-card{
    width:100%;max-width:420px;max-height:82vh;overflow-y:auto;
    background:linear-gradient(165deg,#3D1878,#1E0A40);
    border:1.5px solid var(--panel-border);
    border-radius:var(--radius-lg);padding:22px;
    box-shadow:0 30px 60px -20px rgba(0,0,0,0.75);
  }
  .modal-card h2{font-family:'Fredoka',sans-serif;margin:0 0 4px;font-size:21px;}
  .modal-card p.sub{margin:0 0 14px;font-size:12.5px;color:var(--text-muted);}
  .pay-row{display:flex;align-items:center;gap:10px;padding:7px 0;border-bottom:1px solid rgba(255,255,255,0.07);font-size:12.5px;}
  .pay-icon{width:30px;height:30px;flex-shrink:0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;}
  .pay-name{flex:1;font-weight:700;}
  .pay-tiers{color:var(--text-muted);font-size:11px;text-align:right;}
  .modal-section-title{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:var(--accent-gold);font-weight:800;margin:16px 0 6px;}
  .modal-close{margin-top:16px;width:100%;padding:10px;border-radius:var(--radius-sm);border:none;background:rgba(255,255,255,0.1);color:var(--text-cream);font-weight:800;cursor:pointer;font-family:'Nunito',sans-serif;}
  .modal-close:hover{background:rgba(255,255,255,0.2);}

  @media(max-width:420px){
    .ctrl-bar{justify-content:center;}
    .stat{align-items:center;}
    .spin-outer{order:5;width:100%;}
  }

  /* ==========================================
     DAILY CHECK-IN SCREEN OVERLAY
     ========================================== */
  #checkin-screen {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at center, #1b0a3a 0%, #05020c 100%);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    transition: opacity 0.5s ease, transform 0.5s ease;
  }
  
  .checkin-card {
    max-width: 440px;
    width: 100%;
    background: rgba(45, 15, 80, 0.45);
    backdrop-filter: blur(20px);
    border-radius: 28px;
    border: 2px solid rgba(192, 112, 255, 0.25);
    padding: 35px 30px;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(192, 112, 255, 0.15);
  }

  .checkin-title {
    font-family: 'Fredoka', sans-serif;
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 8px;
    background: linear-gradient(95deg, #FFD66B, #FF4FA3 60%, #5FD8FF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    filter: drop-shadow(0 2px 5px rgba(255,79,163,0.3));
  }

  .checkin-desc {
    font-size: 13.5px;
    color: #c9b8e8;
    margin-bottom: 24px;
    line-height: 1.6;
  }

  .checkin-btn-wrapper {
    position: relative;
    width: 160px;
    height: 160px;
    margin: 0 auto 24px;
    cursor: pointer;
  }

  .checkin-btn-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.2s, filter 0.3s;
    filter: drop-shadow(0 0 10px rgba(255, 79, 163, 0.3));
  }

  .checkin-btn-img:hover {
    transform: scale(1.06);
    filter: brightness(1.12) drop-shadow(0 0 20px rgba(255, 79, 163, 0.6));
  }

  .checkin-btn-img:active {
    transform: scale(0.94);
  }

  /* Progress Bar */
  .checkin-progress {
    width: 100%;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 14px 16px;
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.4s ease, transform 0.4s ease;
    display: none;
  }

  .checkin-progress.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
  }

  .progress-header {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #c9b8e8;
  }

  .progress-status {
    color: #ffd66b;
  }

  .progress-bar-bg {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 4px;
    overflow: hidden;
  }

  .progress-bar-fill {
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, #FF4FA3, #FFD66B);
    box-shadow: 0 0 10px rgba(255, 79, 163, 0.6);
    border-radius: 4px;
  }
</style>
</head>
<body>

<!-- CHECK-IN SCREEN OVERLAY -->
<div id="checkin-screen">
  <div class="checkin-card">
    <h2 class="checkin-title">BonBon Check-In</h2>
    <p class="checkin-desc">Click the CHECK-IN button below to perform verification and unlock the candy cascade!</p>
    
    <div class="checkin-btn-wrapper" onclick="startCheckIn()">
      <img src="{{ asset('assets/image/checkin-btn.png') }}" class="checkin-btn-img" alt="Check-In Button">
    </div>

    <div class="checkin-progress" id="checkin-progress-container">
      <div class="progress-header">
        <span class="progress-status" id="progress-status-text">Verifying security keys...</span>
        <span id="progress-percent">0%</span>
      </div>
      <div class="progress-bar-bg">
        <div class="progress-bar-fill" id="progress-bar-fill"></div>
      </div>
    </div>
  </div>
</div>

<!-- Animated Canvas Background -->
<canvas id="bgCanvas"></canvas>

<!-- Floating candy particles overlay -->
<canvas id="fxCanvas" style="position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none;"></canvas>

<div class="game-wrap">
  <!-- Brand bar -->
  <div class="brand-bar">
    <div class="brand">BonBon Bonanza<span class="brand-sub">DEMO</span></div>
    <div class="topbar-btns">
      <button class="icon-btn" id="soundBtn" title="Sound" aria-label="Toggle sound">🔊</button>
      <button class="icon-btn" id="infoBtn" title="Paytable" aria-label="Paytable">ℹ️</button>
    </div>
  </div>

  <!-- Grid panel -->
  <div class="game-panel">
    <div class="grid-outer">
      <div class="bonus-banner hidden" id="bonusBanner">FREE SPINS</div>
      <div class="grid" id="grid" role="img" aria-label="Slot grid"></div>
    </div>

    <div class="boost-row">
      <div>
        <span class="boost-label">Scatter Boost</span>
        <span class="boost-sub">+25% cost · ~2× Sugar Gem chance</span>
      </div>
      <div class="switch">
        <input type="checkbox" id="boostToggle">
        <label for="boostToggle"></label>
      </div>
    </div>

    <div class="out-msg hidden" id="outMsg">
      Out of demo credits. <button id="resetBalanceBtn">Refill balance</button>
    </div>
  </div>

  <!-- Controls -->
  <div class="ctrl-bar">
    <div class="stat">
      <span class="lbl">Balance</span>
      <span class="val" id="balanceVal">1,000.00</span>
    </div>

    <div class="bet-ctrl">
      <button class="round-btn" id="betMinus" aria-label="Decrease bet">−</button>
      <div class="stat">
        <span class="lbl">Bet</span>
        <span class="val" id="betVal">1.00</span>
      </div>
      <button class="round-btn" id="betPlus" aria-label="Increase bet">+</button>
    </div>

    <div class="spin-outer">
      <div class="spin-ring" id="spinRing" style="display:none;"></div>
      <button class="spin-btn" id="spinBtn">SPIN</button>
    </div>

    <div class="toggles">
      <button class="toggle-btn" id="autoBtn">AUTO</button>
      <button class="toggle-btn" id="turboBtn">TURBO</button>
    </div>

    <div class="stat win-stat">
      <span class="lbl">Win</span>
      <span class="val" id="winVal">0.00</span>
    </div>
  </div>

  <div class="footer-bar">Demo only — virtual credits, no real money. For fun &amp; practice.</div>
</div>

<!-- Paytable Modal -->
<div class="modal-overlay hidden" id="modalOverlay">
  <div class="modal-card">
    <h2>🍬 How BonBon Bonanza Pays</h2>
    <p class="sub">Land 8+ of the same treat anywhere on the 6×5 grid to win. Matched treats pop, new ones cascade — chaining multiple wins per spin!</p>
    <div class="modal-section-title">Treats</div>
    <div id="paytableBody"></div>
    <div class="modal-section-title">💎 Sugar Gem (Scatter)</div>
    <div id="scatterBody"></div>
    <div class="modal-section-title">🌟 Free Spins</div>
    <p class="sub" style="margin:0 0 6px;">3+ Sugar Gems trigger Free Spins. Every win multiplies, increasing +1× per winning spin (max 10×). Landing 3+ Gems again adds 5 extra spins.</p>
    <button class="modal-close" id="modalCloseBtn">Close</button>
  </div>
</div>

<script>
// ============================================================
//  CHECK-IN LOADER ANIMATION WITH STANDALONE AUDIO
// ============================================================
let isCheckingIn = false;
let checkInAudioCtx = null;

function playCheckInBeep(freq, dur, type, vol) {
  try {
    if (!checkInAudioCtx) {
      checkInAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    const osc = checkInAudioCtx.createOscillator();
    const gain = checkInAudioCtx.createGain();
    osc.type = type || 'sine';
    osc.frequency.value = freq;
    gain.gain.value = vol || 0.05;
    osc.connect(gain).connect(checkInAudioCtx.destination);
    const now = checkInAudioCtx.currentTime;
    gain.gain.setValueAtTime(vol || 0.05, now);
    gain.gain.exponentialRampToValueAtTime(0.0001, now + dur);
    osc.start(now);
    osc.stop(now + dur);
  } catch(e) {}
}

function startCheckIn() {
  if (isCheckingIn) return;
  isCheckingIn = true;

  // Hide the check-in button and description to keep layout clean
  const btnWrapper = document.querySelector('.checkin-btn-wrapper');
  if (btnWrapper) btnWrapper.style.display = 'none';
  const descText = document.querySelector('.checkin-desc');
  if (descText) descText.style.display = 'none';

  // Initial click sound
  playCheckInBeep(600, 0.1, 'sine', 0.05);

  const container = document.getElementById('checkin-progress-container');
  const fill = document.getElementById('progress-bar-fill');
  const percentText = document.getElementById('progress-percent');
  const statusText = document.getElementById('progress-status-text');

  container.classList.add('show');

  let pct = 0;
  statusText.innerText = 'Initializing cascade server...';

  const timer = setInterval(() => {
    // Increased step to finish faster (around 600-800ms)
    pct += Math.floor(Math.random() * 6) + 4;
    if (pct >= 100) {
      pct = 100;
      clearInterval(timer);

      statusText.innerText = 'Check-In Successful!';
      percentText.innerText = '100%';
      fill.style.width = '100%';
      fill.style.background = 'linear-gradient(90deg, #2ebd59, #38ef7d)';
      fill.style.boxShadow = '0 0 10px rgba(56, 239, 125, 0.8)';

      // Success fanfare sound
      [520, 660, 780, 990].forEach((f, i) => {
        setTimeout(() => playCheckInBeep(f, 0.12, 'triangle', 0.06), i * 70);
      });

      setTimeout(() => {
        // Fade out overlay
        const overlay = document.getElementById('checkin-screen');
        overlay.style.opacity = '0';
        overlay.style.transform = 'scale(0.95)';
        setTimeout(() => {
          overlay.style.display = 'none';
        }, 300);
      }, 400);
    } else {
      fill.style.width = pct + '%';
      percentText.innerText = pct + '%';
      
      // Gentle tick sounds while loading
      if (pct % 15 === 0) {
        playCheckInBeep(400 + pct * 2, 0.05, 'sine', 0.02);
      }

      if (pct > 30 && pct < 65) {
        statusText.innerText = 'Loading candy assets...';
      } else if (pct >= 65) {
        statusText.innerText = 'Securing random numbers generator...';
      }
    }
  }, 40);
}

// Auto-start check-in on DOM content loaded
window.addEventListener('DOMContentLoaded', () => {
  setTimeout(startCheckIn, 300);
});

// ============================================================
//  CANVAS BACKGROUND — BonBon Bonanza World
// ============================================================
(function(){
  const bg = document.getElementById('bgCanvas');
  const fx = document.getElementById('fxCanvas');
  const bctx = bg.getContext('2d');
  const fctx = fx.getContext('2d');

  function resize(){
    bg.width = fx.width = window.innerWidth;
    bg.height = fx.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  // ---- Tree class ----
  class Tree {
    constructor(x, groundY, scale, side){
      this.x = x;
      this.groundY = groundY;
      this.scale = scale;
      this.side = side; // -1 left, 1 right
      this.wobble = Math.random() * Math.PI * 2;
      this.wobbleSpeed = 0.4 + Math.random() * 0.3;
      this.leaves = [];
      // Generate leaf clusters
      const numClusters = 5 + Math.floor(Math.random()*4);
      for(let i=0;i<numClusters;i++){
        this.leaves.push({
          ox: (Math.random()-0.5)*55*scale,
          oy: -(80 + Math.random()*60)*scale,
          r: (30 + Math.random()*28)*scale,
          hue: 330 + Math.random()*30, // pink trees
          lightness: 72 + Math.random()*14,
          phase: Math.random()*Math.PI*2,
        });
      }
    }
    draw(t){
      const ctx = bctx;
      const sway = Math.sin(t*this.wobbleSpeed + this.wobble) * 2 * this.scale;
      ctx.save();
      ctx.translate(this.x, this.groundY);

      // Trunk
      const trunkH = 110 * this.scale;
      const trunkW = 14 * this.scale;
      const grad = ctx.createLinearGradient(-trunkW,0,trunkW,0);
      grad.addColorStop(0,'#7B4A1A');
      grad.addColorStop(0.5,'#A0622A');
      grad.addColorStop(1,'#7B4A1A');
      ctx.beginPath();
      ctx.moveTo(-trunkW*0.5,0);
      ctx.bezierCurveTo(-trunkW*0.8+sway,-trunkH*0.4, -trunkW*0.3+sway,-trunkH*0.7, sway,-trunkH);
      ctx.lineTo(trunkW*0.6+sway,-trunkH);
      ctx.bezierCurveTo(trunkW*0.8+sway,-trunkH*0.7, trunkW*0.5+sway,-trunkH*0.4, trunkW*0.5,0);
      ctx.closePath();
      ctx.fillStyle = grad;
      ctx.fill();

      // Roots
      ctx.beginPath();
      ctx.ellipse(0, 0, trunkW*1.6, 6*this.scale, 0, 0, Math.PI);
      ctx.fillStyle='#6B3A14';
      ctx.fill();

      // Leaf clusters with gentle sway
      for(const lf of this.leaves){
        const lsway = Math.sin(t*this.wobbleSpeed + lf.phase + this.wobble)*3*this.scale;
        const lg = ctx.createRadialGradient(
          lf.ox+sway+lsway, lf.oy, lf.r*0.1,
          lf.ox+sway+lsway, lf.oy, lf.r
        );
        lg.addColorStop(0,`hsl(${lf.hue},80%,${lf.lightness+12}%)`);
        lg.addColorStop(0.6,`hsl(${lf.hue},75%,${lf.lightness}%)`);
        lg.addColorStop(1,`hsl(${lf.hue},70%,${lf.lightness-15}%)`);
        ctx.beginPath();
        ctx.arc(lf.ox+sway+lsway, lf.oy, lf.r, 0, Math.PI*2);
        ctx.fillStyle=lg;
        ctx.fill();
      }
      ctx.restore();
    }
  }

  // ---- Cloud class ----
  class Cloud {
    constructor(){
      this.reset(true);
    }
    reset(init){
      this.x = init ? Math.random()*window.innerWidth : -260;
      this.y = 30 + Math.random()*120;
      this.speed = 0.18 + Math.random()*0.22;
      this.scale = 0.7 + Math.random()*0.9;
      this.alpha = 0.82 + Math.random()*0.18;
    }
    update(){
      this.x += this.speed;
      if(this.x > window.innerWidth + 300) this.reset(false);
    }
    draw(){
      const ctx = bctx;
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.translate(this.x, this.y);
      ctx.scale(this.scale, this.scale);
      const puffs=[
        [0,0,45],[45,-15,38],[90,5,40],[-40,5,32],[130,0,30]
      ];
      for(const[px,py,pr] of puffs){
        const cg = ctx.createRadialGradient(px,py-pr*0.3,pr*0.1,px,py,pr);
        cg.addColorStop(0,'rgba(255,255,255,1)');
        cg.addColorStop(1,'rgba(220,230,255,0.7)');
        ctx.beginPath();
        ctx.arc(px,py,pr,0,Math.PI*2);
        ctx.fillStyle=cg;
        ctx.fill();
      }
      ctx.restore();
    }
  }

  // ---- Flower class ----
  class Flower {
    constructor(x, y){
      this.x = x; this.y = y;
      this.r = 5 + Math.random()*5;
      this.hue = Math.random()<0.5? 330+Math.random()*30 : 50+Math.random()*30;
      this.phase = Math.random()*Math.PI*2;
      this.speed = 0.8+Math.random()*0.6;
    }
    draw(t){
      const ctx = bctx;
      const bob = Math.sin(t*this.speed+this.phase)*2;
      ctx.save();
      ctx.translate(this.x, this.y+bob);
      // stem
      ctx.beginPath();
      ctx.moveTo(0,0);ctx.lineTo(0,this.r*2.5);
      ctx.strokeStyle='#3A8A2A';ctx.lineWidth=1.5;ctx.stroke();
      // petals
      for(let p=0;p<5;p++){
        const a=p*Math.PI*2/5;
        ctx.beginPath();
        ctx.ellipse(Math.cos(a)*this.r*1.1,Math.sin(a)*this.r*1.1,this.r*0.8,this.r*0.5,a,0,Math.PI*2);
        ctx.fillStyle=`hsl(${this.hue},80%,72%)`;
        ctx.fill();
      }
      ctx.beginPath();
      ctx.arc(0,0,this.r*0.55,0,Math.PI*2);
      ctx.fillStyle='#FFE060';
      ctx.fill();
      ctx.restore();
    }
  }

  // ---- Candy particle for FX canvas ----
  class CandyParticle {
    constructor(){this.reset();}
    reset(){
      this.x = Math.random()*window.innerWidth;
      this.y = Math.random()*window.innerHeight;
      this.vx = (Math.random()-0.5)*0.5;
      this.vy = -0.3 - Math.random()*0.5;
      this.r = 3+Math.random()*5;
      this.alpha = 0.6+Math.random()*0.4;
      this.hue = Math.random()*360;
      this.rot = Math.random()*Math.PI*2;
      this.rotSpeed = (Math.random()-0.5)*0.06;
      this.life = 0;
      this.maxLife = 120+Math.random()*180;
      this.shape = Math.floor(Math.random()*3); // 0=circle,1=star,2=diamond
    }
    update(){
      this.x+=this.vx; this.y+=this.vy;
      this.rot+=this.rotSpeed;
      this.life++;
      if(this.life>this.maxLife || this.y<-20) this.reset();
    }
    draw(){
      const ctx = fctx;
      const a = this.alpha*(1-this.life/this.maxLife);
      ctx.save();
      ctx.globalAlpha=a;
      ctx.translate(this.x,this.y);
      ctx.rotate(this.rot);
      ctx.fillStyle=`hsl(${this.hue},90%,70%)`;
      if(this.shape===0){
        ctx.beginPath();ctx.arc(0,0,this.r,0,Math.PI*2);ctx.fill();
      } else if(this.shape===1){
        drawStar(ctx,0,0,this.r,this.r*0.4,5);ctx.fill();
      } else {
        ctx.beginPath();
        ctx.moveTo(0,-this.r);ctx.lineTo(this.r*0.6,0);
        ctx.lineTo(0,this.r);ctx.lineTo(-this.r*0.6,0);
        ctx.closePath();ctx.fill();
      }
      ctx.restore();
    }
  }

  function drawStar(ctx,cx,cy,outerR,innerR,pts){
    ctx.beginPath();
    for(let i=0;i<pts*2;i++){
      const angle=i*Math.PI/pts - Math.PI/2;
      const r = i%2===0?outerR:innerR;
      ctx.lineTo(cx+Math.cos(angle)*r, cy+Math.sin(angle)*r);
    }
    ctx.closePath();
  }

  // ---- Build scene ----
  const W=()=>bg.width, H=()=>bg.height;

  function groundY(){ return H()*0.68; }

  // Trees — left side small, right side bigger
  let trees=[], clouds=[], flowers=[], particles=[];
  function buildScene(){
    trees=[];
    flowers=[];
    const gY = groundY();

    // Left trees (background, smaller)
    trees.push(new Tree(W()*0.04, gY, 0.55, -1));
    trees.push(new Tree(W()*0.12, gY, 0.75, -1));
    trees.push(new Tree(W()*0.21, gY, 0.62, -1));

    // Right trees (foreground, bigger)
    trees.push(new Tree(W()*0.79, gY, 0.90, 1));
    trees.push(new Tree(W()*0.88, gY, 0.70, 1));
    trees.push(new Tree(W()*0.96, gY, 0.55, 1));

    // Flowers along ground
    for(let i=0;i<20;i++){
      const fx = Math.random()<0.5
        ? 10+Math.random()*(W()*0.27)
        : W()*0.73+Math.random()*(W()*0.27);
      flowers.push(new Flower(fx, gY - 4 - Math.random()*10));
    }

    if(clouds.length===0){
      for(let i=0;i<5;i++) clouds.push(new Cloud());
    }
    if(particles.length===0){
      for(let i=0;i<35;i++) particles.push(new CandyParticle());
    }
  }
  buildScene();
  window.addEventListener('resize',()=>{buildScene();});

  // ---- Draw background layers ----
  function drawBG(t){
    const ctx = bctx;
    const w=W(), h=H(), gY=groundY();

    // Sky gradient
    const sky = ctx.createLinearGradient(0,0,0,gY);
    sky.addColorStop(0,'#5BB8F5');
    sky.addColorStop(0.5,'#87CEEB');
    sky.addColorStop(1,'#C8EAFF');
    ctx.fillStyle=sky;
    ctx.fillRect(0,0,w,gY+2);

    // Sun
    const sunX=w*0.85, sunY=h*0.10;
    const sunGrad=ctx.createRadialGradient(sunX,sunY,0,sunX,sunY,55);
    sunGrad.addColorStop(0,'rgba(255,240,130,1)');
    sunGrad.addColorStop(0.5,'rgba(255,220,80,0.8)');
    sunGrad.addColorStop(1,'rgba(255,200,40,0)');
    ctx.fillStyle=sunGrad;
    ctx.beginPath();ctx.arc(sunX,sunY,55,0,Math.PI*2);ctx.fill();
    // rays
    ctx.save();ctx.translate(sunX,sunY);
    for(let r=0;r<8;r++){
      ctx.rotate(Math.PI/4);
      ctx.beginPath();
      ctx.moveTo(0,20);ctx.lineTo(0,65);
      ctx.strokeStyle='rgba(255,230,80,0.35)';
      ctx.lineWidth=4;ctx.lineCap='round';ctx.stroke();
    }
    ctx.restore();

    // Distant hills (soft lavender)
    ctx.beginPath();
    ctx.moveTo(0,gY);
    ctx.bezierCurveTo(w*0.15,gY-90, w*0.30,gY-70, w*0.5,gY-50);
    ctx.bezierCurveTo(w*0.65,gY-30, w*0.80,gY-90, w,gY-60);
    ctx.lineTo(w,gY);ctx.closePath();
    ctx.fillStyle='rgba(200,180,230,0.35)';ctx.fill();

    ctx.beginPath();
    ctx.moveTo(0,gY-20);
    ctx.bezierCurveTo(w*0.1,gY-60, w*0.25,gY-40, w*0.45,gY-30);
    ctx.bezierCurveTo(w*0.6,gY-20, w*0.75,gY-55, w,gY-35);
    ctx.lineTo(w,gY);ctx.lineTo(0,gY);ctx.closePath();
    ctx.fillStyle='rgba(180,210,160,0.40)';ctx.fill();

    // Main grass
    const grassG=ctx.createLinearGradient(0,gY,0,h);
    grassG.addColorStop(0,'#5CC655');
    grassG.addColorStop(0.15,'#4CBB47');
    grassG.addColorStop(0.4,'#3EA83A');
    grassG.addColorStop(1,'#2A7A25');
    ctx.fillStyle=grassG;
    ctx.fillRect(0,gY,w,h-gY);

    // Grass bumps / edge
    ctx.beginPath();
    ctx.moveTo(0,gY);
    const steps=24;
    for(let i=0;i<=steps;i++){
      const px=i/steps*w;
      const bump=Math.sin(i*1.1+t*0.3)*5+Math.sin(i*2.3+t*0.2)*3;
      ctx[i===0?'moveTo':'lineTo'](px, gY+bump);
    }
    ctx.lineTo(w,gY);ctx.lineTo(0,gY);ctx.closePath();
    ctx.fillStyle='#6BDD64';ctx.fill();

    // River / path in middle
    const pathW=w*0.18;
    const pathX=w*0.5-pathW*0.5;
    // path/road dirt
    ctx.beginPath();
    ctx.moveTo(pathX,gY);
    ctx.bezierCurveTo(pathX+5,gY+h*0.15,pathX-5,gY+h*0.25,pathX-10,h);
    ctx.lineTo(pathX+pathW+10,h);
    ctx.bezierCurveTo(pathX+pathW+5,gY+h*0.25,pathX+pathW-5,gY+h*0.15,pathX+pathW,gY);
    ctx.closePath();
    const pathGrad=ctx.createLinearGradient(pathX,gY,pathX+pathW,gY);
    pathGrad.addColorStop(0,'#C8A060');
    pathGrad.addColorStop(0.5,'#DFBE80');
    pathGrad.addColorStop(1,'#C8A060');
    ctx.fillStyle=pathGrad;ctx.fill();

    // River (left of path)
    const riverW=w*0.08;
    const riverX=pathX-riverW-w*0.04;
    ctx.beginPath();
    ctx.moveTo(riverX,gY);
    ctx.bezierCurveTo(riverX+8,gY+h*0.15,riverX-4,gY+h*0.25,riverX-8,h);
    ctx.lineTo(riverX+riverW+8,h);
    ctx.bezierCurveTo(riverX+riverW+4,gY+h*0.25,riverX+riverW-8,gY+h*0.15,riverX+riverW,gY);
    ctx.closePath();
    const riverGrad=ctx.createLinearGradient(riverX,gY,riverX+riverW,gY);
    riverGrad.addColorStop(0,'#3890D8');
    riverGrad.addColorStop(0.4,'#5BAEF0');
    riverGrad.addColorStop(1,'#3890D8');
    ctx.fillStyle=riverGrad;ctx.fill();

    // River shimmer
    for(let i=0;i<6;i++){
      const ry=gY+20+i*(h-gY-20)/6;
      const rx=riverX+riverW*0.15+i%2*riverW*0.2;
      const shimmer=Math.sin(t*2+i*0.8)*0.4+0.3;
      ctx.save();
      ctx.globalAlpha=shimmer;
      ctx.strokeStyle='rgba(255,255,255,0.8)';
      ctx.lineWidth=1.5;ctx.lineCap='round';
      ctx.beginPath();
      ctx.moveTo(rx,ry);ctx.lineTo(rx+riverW*0.3,ry);ctx.stroke();
      ctx.restore();
    }

    // Grass tufts
    for(let i=0;i<40;i++){
      const tx2=i/40*w;
      const skip=tx2>pathX-20&&tx2<pathX+pathW+20;
      if(skip) continue;
      const ty=gY+2+Math.sin(i*3.7)*4;
      const th=8+Math.sin(i*2.1)*4;
      const sway=Math.sin(t*0.6+i*0.5)*2;
      ctx.beginPath();
      ctx.moveTo(tx2,ty+th);
      ctx.quadraticCurveTo(tx2+sway-2,ty+th*0.4,tx2+sway-4,ty);
      ctx.quadraticCurveTo(tx2+sway,ty+th*0.4,tx2,ty+th);
      ctx.fillStyle=i%3===0?'#5CC655':'#4CBB47';
      ctx.fill();
    }
  }

  let animT=0;
  function frame(){
    animT+=0.016;
    const w=W(),h=H();

    bctx.clearRect(0,0,w,h);
    drawBG(animT);
    clouds.forEach(c=>{c.update();c.draw();});
    flowers.forEach(f=>f.draw(animT));
    trees.forEach(tr=>tr.draw(animT));

    fctx.clearRect(0,0,w,h);
    particles.forEach(p=>{p.update();p.draw();});

    requestAnimationFrame(frame);
  }
  frame();
})();

// ============================================================
//  SLOT GAME LOGIC
// ============================================================
(function(){
  "use strict";
  const ROWS=5,COLS=6,TOTAL=ROWS*COLS;
  const SYMBOL_META={
    candy:{emoji:'🍬',label:'Twist Candy',tier:'low',weight:24},
    lolli:{emoji:'🍭',label:'Lollipop',tier:'low',weight:22},
    cookie:{emoji:'🍪',label:'Cookie',tier:'low',weight:20},
    donut:{emoji:'🍩',label:'Donut',tier:'low',weight:18},
    cupcake:{emoji:'🧁',label:'Cupcake',tier:'high',weight:10},
    cake:{emoji:'🍰',label:'Cake Slice',tier:'high',weight:8},
    choco:{emoji:'🍫',label:'Chocolate',tier:'high',weight:6},
  };
  const SCATTER_ID='gem';
  const SCATTER_META={emoji:'💎',label:'Sugar Gem',weight:4};
  const PAYTABLE={
    low:[[8,9,0.3],[10,11,0.8],[12,14,2],[15,30,5]],
    high:[[8,9,1],[10,11,2.5],[12,14,6],[15,30,15]],
  };
  const SCATTER_TRIGGER=[[3,3,8],[4,4,10],[5,30,12]];
  const RETRIGGER_SPINS=5;
  const MAX_BONUS_MULT=10;
  const BET_STEPS=[0.2,0.4,0.6,0.8,1,1.5,2,3,4,5,7.5,10,15,20,30,40,50];

  function round2(n){return Math.round((n+Number.EPSILON)*100)/100;}

  function tierMultiplier(brackets,count){
    if(count<brackets[0][0])return 0;
    for(const[min,max,mult]of brackets)if(count>=min&&count<=max)return mult;
    return brackets[brackets.length-1][2];
  }
  function buildWeights(boost){
    const list=Object.entries(SYMBOL_META).map(([id,s])=>({id,weight:s.weight}));
    list.push({id:SCATTER_ID,weight:boost?SCATTER_META.weight*2.2:SCATTER_META.weight});
    return list;
  }
  function weightedPick(weights){
    const total=weights.reduce((a,w)=>a+w.weight,0);
    let r=Math.random()*total;
    for(const w of weights){if(r<w.weight)return w.id;r-=w.weight;}
    return weights[weights.length-1].id;
  }
  function newGrid(boost){
    const weights=buildWeights(boost);
    const grid=new Array(TOTAL);
    for(let i=0;i<TOTAL;i++)grid[i]=weightedPick(weights);
    return grid;
  }
  function colIndices(c){const arr=[];for(let r=0;r<ROWS;r++)arr.push(r*COLS+c);return arr;}
  function evaluateWin(grid,bet){
    const counts={};
    for(const id of grid){if(id===SCATTER_ID)continue;counts[id]=(counts[id]||0)+1;}
    const winningIds=new Set();let totalWin=0;
    for(const[id,count]of Object.entries(counts)){
      const tier=SYMBOL_META[id].tier;
      const mult=tierMultiplier(PAYTABLE[tier],count);
      if(mult>0){winningIds.add(id);totalWin+=round2(bet*mult);}
    }
    const winningIndices=new Set();
    grid.forEach((id,i)=>{if(winningIds.has(id))winningIndices.add(i);});
    return{winningIndices,totalWin:round2(totalWin)};
  }
  function scatterTrigger(grid){
    const count=grid.filter(id=>id===SCATTER_ID).length;
    for(const[min,max,spins]of SCATTER_TRIGGER)if(count>=min&&count<=max)return{count,spins};
    return{count,spins:0};
  }
  function getNewlyFilledIndices(winningIndices){
    const result=new Set();
    for(let c=0;c<COLS;c++){
      const idxs=colIndices(c);
      const removedCount=idxs.filter(i=>winningIndices.has(i)).length;
      for(let k=0;k<removedCount;k++)result.add(idxs[k]);
    }
    return result;
  }
  function cascadeStep(grid,winningIndices,boost){
    const weights=buildWeights(boost);
    const newG=grid.slice();
    for(let c=0;c<COLS;c++){
      const idxs=colIndices(c);
      const survivors=idxs.filter(i=>!winningIndices.has(i)).map(i=>grid[i]);
      const need=idxs.length-survivors.length;
      const filled=[];
      for(let k=0;k<need;k++)filled.push(weightedPick(weights));
      const finalCol=filled.concat(survivors);
      idxs.forEach((idx,k)=>{newG[idx]=finalCol[k];});
    }
    return newG;
  }

  // Hook balance to user account balance
  const userCurrency = "{{ auth()->user()->currency }}";
  const currencySymbol = userCurrency === 'BDT' ? '৳' : (userCurrency === 'INR' ? '₹' : '$');
  const realBalance = parseFloat("{{ auth()->user()->balance }}");

  const state={
    balance: realBalance,
    betIndex:4,isSpinning:false,
    autoplay:false,turbo:false,boost:false,soundOn:true,
    mode:'base',freeSpinsRemaining:0,bonusMultiplier:1,
    bonusTotalWin:0,grid:newGrid(false),lastWin:0,
  };
  function currentBet(){return BET_STEPS[state.betIndex];}
  function effectiveBet(){return(state.boost&&state.mode==='base')?round2(currentBet()*1.25):currentBet();}

  const gridEl=document.getElementById('grid');
  const balanceVal=document.getElementById('balanceVal');
  const betVal=document.getElementById('betVal');
  const winVal=document.getElementById('winVal');
  const spinBtn=document.getElementById('spinBtn');
  const spinRing=document.getElementById('spinRing');
  const betMinus=document.getElementById('betMinus');
  const betPlus=document.getElementById('betPlus');
  const autoBtn=document.getElementById('autoBtn');
  const turboBtn=document.getElementById('turboBtn');
  const boostToggle=document.getElementById('boostToggle');
  const soundBtn=document.getElementById('soundBtn');
  const infoBtn=document.getElementById('infoBtn');
  const modalOverlay=document.getElementById('modalOverlay');
  const modalCloseBtn=document.getElementById('modalCloseBtn');
  const bonusBanner=document.getElementById('bonusBanner');
  const outMsg=document.getElementById('outMsg');
  const resetBalanceBtn=document.getElementById('resetBalanceBtn');

  function fmt(n){return currencySymbol + ' ' + n.toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2});}
  function delay(ms){return new Promise(res=>setTimeout(res,ms));}

  // ---- Audio ----
  let audioCtx=null;
  function ensureAudio(){
    if(!audioCtx)try{audioCtx=new(window.AudioContext||window.webkitAudioContext)();}catch(e){audioCtx=null;}
  }
  window.audioCtx = audioCtx; // share globally
  window.state = state; // share globally

  window.beep = function(freq,dur,type,vol){
    if(!state.soundOn||!audioCtx)return;
    const osc=audioCtx.createOscillator();
    const gain=audioCtx.createGain();
    osc.type=type||'sine';osc.frequency.value=freq;
    gain.gain.value=vol||0.05;
    osc.connect(gain).connect(audioCtx.destination);
    const now=audioCtx.currentTime;
    gain.gain.setValueAtTime(vol||0.05,now);
    gain.gain.exponentialRampToValueAtTime(0.0001,now+dur);
    osc.start(now);osc.stop(now+dur);
  }
  function sfxSpin(){beep(220,0.08,'square',0.03);}
  function sfxLand(){beep(330,0.07,'sine',0.04);}
  function sfxWin(){beep(660,0.12,'triangle',0.05);setTimeout(()=>beep(880,0.12,'triangle',0.05),90);}
  window.sfxTrigger = function(){[520,660,780,990].forEach((f,i)=>setTimeout(()=>beep(f,0.16,'triangle',0.06),i*90));}

  // ---- Rendering ----
  function renderGrid(fallingSet){
    gridEl.innerHTML='';
    state.grid.forEach((id,i)=>{
      const cell=document.createElement('div');
      cell.className='cell sym-'+id;
      cell.dataset.idx=i;
      cell.textContent=SYMBOL_META[id]?SYMBOL_META[id].emoji:SCATTER_META.emoji;
      if(fallingSet&&fallingSet.has(i)){
        cell.classList.add('falling');
        const row=Math.floor(i/COLS);
        cell.style.transitionDelay=(row*35)+'ms';
      }
      gridEl.appendChild(cell);
    });
    if(fallingSet){
      requestAnimationFrame(()=>{
        requestAnimationFrame(()=>{
          gridEl.querySelectorAll('.cell.falling').forEach(c=>c.classList.remove('falling'));
        });
      });
    }
  }
  function settleBounce(){
    gridEl.querySelectorAll('.cell').forEach((c,i)=>{
      setTimeout(()=>c.classList.add('settle'),i*4);
    });
  }
  function highlightWinning(wi){
    wi.forEach(i=>{
      const c=gridEl.querySelector('.cell[data-idx="'+i+'"]');
      if(c)c.classList.add('win');
    });
  }
  function popWinning(wi){
    wi.forEach(i=>{
      const c=gridEl.querySelector('.cell[data-idx="'+i+'"]');
      if(c){c.classList.remove('win');c.classList.add('pop');}
    });
  }
  function updateStatsUI(){
    balanceVal.textContent=fmt(state.balance);
    betVal.textContent=fmt(currentBet());
    winVal.textContent=fmt(state.lastWin||0);
    betMinus.disabled=state.isSpinning||state.betIndex===0||state.mode==='bonus';
    betPlus.disabled=state.isSpinning||state.betIndex===BET_STEPS.length-1||state.mode==='bonus';
    boostToggle.disabled=state.isSpinning||state.mode==='bonus';
    outMsg.classList.toggle('hidden',state.balance>=effectiveBet());
  }
  function setSpinning(is){
    state.isSpinning=is;
    spinBtn.disabled=is||state.mode==='bonus'||state.balance<effectiveBet();
    spinRing.style.display=is?'block':'none';
    betMinus.disabled=is||state.betIndex===0||state.mode==='bonus';
    betPlus.disabled=is||state.betIndex===BET_STEPS.length-1||state.mode==='bonus';
    boostToggle.disabled=is||state.mode==='bonus';
  }
  function showBonusBanner(){bonusBanner.classList.remove('hidden');updateBonusBannerText();}
  function hideBonusBanner(){bonusBanner.classList.add('hidden');}
  function updateBonusBannerText(){bonusBanner.textContent=`🌟 FREE SPINS · ${state.freeSpinsRemaining} left · ${state.bonusMultiplier}× mult`;}
  function flashOutMsg(){outMsg.classList.toggle('hidden',state.balance>=effectiveBet());}

  // ---- Cascade animation ----
  async function animateCascades(initialGrid,bet,boost){
    let working=initialGrid.slice();let totalWin=0;
    while(true){
      const{winningIndices,totalWin:roundWin}=evaluateWin(working,bet);
      if(winningIndices.size===0)break;
      totalWin+=roundWin;
      highlightWinning(winningIndices);sfxWin();
      await delay(state.turbo?170:460);
      popWinning(winningIndices);
      await delay(state.turbo?110:240);
      const fallingSet=getNewlyFilledIndices(winningIndices);
      working=cascadeStep(working,winningIndices,boost);
      state.grid=working;renderGrid(fallingSet);
      await delay(state.turbo?90:260);
    }
    await delay(state.turbo?60:140);
    return{finalGrid:working,totalWin:round2(totalWin)};
  }

  async function spinShuffle(){
    const ticks=state.turbo?3:7;
    const stepDelay=state.turbo?35:65;
    for(let t=0;t<ticks;t++){
      const ids=Object.keys(SYMBOL_META);
      gridEl.querySelectorAll('.cell').forEach(c=>{
        const rid=ids[Math.floor(Math.random()*ids.length)];
        c.className='cell sym-'+rid;
        c.textContent=SYMBOL_META[rid].emoji;
      });
      await delay(stepDelay);
    }
  }

  // ── SYNC BALANCE WITH Laravel Database ──
  function syncBalance(newBalance) {
    fetch('{{ route("dashboard.update-balance") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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

  // ---- Main spin ----
  async function spin(){
    if(state.isSpinning)return;
    const modeBefore=state.mode;
    if(modeBefore==='base'&&state.balance<effectiveBet()){flashOutMsg();return;}
    setSpinning(true);ensureAudio();sfxSpin();
    let basisBet;
    if(modeBefore==='base'){
      basisBet=effectiveBet();
      state.balance=round2(state.balance-basisBet);
      
      // Deduct bet amount from backend database
      syncBalance(state.balance);
    }
    else{basisBet=currentBet();}
    updateStatsUI();
    if(gridEl.children.length===0)renderGrid();
    await spinShuffle();
    const boostActive=state.boost&&modeBefore==='base';
    const drawn=newGrid(boostActive);
    state.grid=drawn;renderGrid();settleBounce();sfxLand();
    await delay(state.turbo?110:260);
    const trig=scatterTrigger(drawn);
    if(trig.spins>0){
      if(modeBefore==='base'){
        state.mode='bonus';state.freeSpinsRemaining=trig.spins;
        state.bonusMultiplier=1;state.bonusTotalWin=0;
        showBonusBanner();sfxTrigger();
        await delay(state.turbo?350:850);
      } else {
        state.freeSpinsRemaining+=RETRIGGER_SPINS;
        updateBonusBannerText();sfxTrigger();
        await delay(state.turbo?250:550);
      }
    }
    const cascadeResult=await animateCascades(state.grid,basisBet,boostActive);
    state.grid=cascadeResult.finalGrid;
    let totalWin=cascadeResult.totalWin;
    if(state.mode==='bonus'){
      totalWin=round2(totalWin*state.bonusMultiplier);
      if(cascadeResult.totalWin>0)state.bonusMultiplier=Math.min(MAX_BONUS_MULT,state.bonusMultiplier+1);
      state.bonusTotalWin=round2(state.bonusTotalWin+totalWin);
    }
    state.balance=round2(state.balance+totalWin);
    state.lastWin=totalWin;updateStatsUI();

    // Add win amount to backend database
    if (totalWin > 0) {
      syncBalance(state.balance);
    }

    if(modeBefore==='bonus'){state.freeSpinsRemaining-=1;updateBonusBannerText();}
    if(state.mode==='bonus'&&state.freeSpinsRemaining<=0){
      await delay(state.turbo?300:700);
      hideBonusBanner();state.mode='base';
      state.lastWin=state.bonusTotalWin;
      winVal.textContent=fmt(state.bonusTotalWin);
    }
    setSpinning(false);updateStatsUI();
    if(state.mode==='bonus'&&state.freeSpinsRemaining>0){
      await delay(state.turbo?250:600);spin();return;
    }
    if(state.autoplay){
      if(state.balance<effectiveBet()){
        state.autoplay=false;autoBtn.classList.remove('active');flashOutMsg();return;
      }
      await delay(state.turbo?200:550);spin();
    }
  }

  // ---- Paytable ----
  function buildPaytableHTML(){
    const body=document.getElementById('paytableBody');
    body.innerHTML='';
    Object.entries(SYMBOL_META).forEach(([id,meta])=>{
      const brackets=PAYTABLE[meta.tier];
      const tierText=brackets.map(([min,max,mult])=>`${min}${max>=30?'+':'–'+max}: ${mult}×`).join(' · ');
      const row=document.createElement('div');
      row.className='pay-row';
      row.innerHTML=`<div class="pay-icon sym-${id}">${meta.emoji}</div><div class="pay-name">${meta.label}</div><div class="pay-tiers">${tierText}</div>`;
      body.appendChild(row);
    });
    const sb=document.getElementById('scatterBody');
    const st=SCATTER_TRIGGER.map(([min,max,spins])=>`${min}${max>=30?'+':''}: ${spins} spins`).join(' · ');
    sb.innerHTML=`<div class="pay-row"><div class="pay-icon sym-gem">${SCATTER_META.emoji}</div><div class="pay-name">${SCATTER_META.label}</div><div class="pay-tiers">${st}</div></div>`;
  }

  // ---- Events ----
  spinBtn.addEventListener('click',()=>{ensureAudio();spin();});
  betMinus.addEventListener('click',()=>{if(state.betIndex>0){state.betIndex--;updateStatsUI();}});
  betPlus.addEventListener('click',()=>{if(state.betIndex<BET_STEPS.length-1){state.betIndex++;updateStatsUI();}});
  autoBtn.addEventListener('click',()=>{
    state.autoplay=!state.autoplay;autoBtn.classList.toggle('active',state.autoplay);
    if(state.autoplay&&!state.isSpinning&&state.mode==='base'){ensureAudio();spin();}
  });
  turboBtn.addEventListener('click',()=>{state.turbo=!state.turbo;turboBtn.classList.toggle('active',state.turbo);});
  boostToggle.addEventListener('change',()=>{state.boost=boostToggle.checked;updateStatsUI();});
  soundBtn.addEventListener('click',()=>{state.soundOn=!state.soundOn;soundBtn.textContent=state.soundOn?'🔊':'🔈';});
  infoBtn.addEventListener('click',()=>modalOverlay.classList.remove('hidden'));
  modalCloseBtn.addEventListener('click',()=>modalOverlay.classList.add('hidden'));
  modalOverlay.addEventListener('click',e=>{if(e.target===modalOverlay)modalOverlay.classList.add('hidden');});
  resetBalanceBtn.addEventListener('click',()=>{state.balance=1000;updateStatsUI();setSpinning(state.isSpinning);});

  // ---- Init ----
  buildPaytableHTML();renderGrid();updateStatsUI();setSpinning(false);
})();
</script>
</body>
</html>
