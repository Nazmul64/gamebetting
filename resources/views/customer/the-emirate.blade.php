<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>The Emirate™ - Endorphina | 1xBet Casino</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800;900&family=Outfit:wght@400;600;700;800&family=Poppins:wght@400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<!-- FontAwesome & Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0c1626; font-family: 'Outfit', sans-serif; overflow-x: hidden; color: #fff; min-height: 100vh; }

/* ===== STAR BG CANVAS ===== */
#bgCanvas {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none; z-index: 0;
}

/* ===== MAIN WRAPPER ===== */
#gameWrapper {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  min-height: calc(100vh - 65px);
  padding: 0;
}

/* ===== SHELL SUB-HEADER / IN-GAME HEADER ===== */
.ingame-header {
  background: #0f223f;
  border-bottom: 2px solid #1d3354;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  z-index: 10;
}
.ingame-header .breadcrumb-area {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  font-weight: 600;
  color: #8ca3c7;
}
.ingame-header .breadcrumb-area a { color: #8ca3c7; text-decoration: none; }
.ingame-header .breadcrumb-area a:hover { color: #fff; }
.ingame-header .game-title-badge {
  font-family: 'Cinzel', serif;
  font-size: 15px;
  font-weight: 800;
  color: #f5c842;
  letter-spacing: 1.5px;
  text-transform: uppercase;
}

/* -- 1XBET DUAL MODE PILL SELECTOR -- */
.mode-toggle-pill {
  display: flex;
  align-items: center;
  background: rgba(10, 20, 38, 0.9);
  border: 1.5px solid rgba(245, 200, 66, 0.4);
  border-radius: 24px;
  padding: 3px;
  gap: 4px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.5);
}
.mode-pill-btn {
  border: none;
  outline: none;
  background: transparent;
  color: #94a3b8;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 11.5px;
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  white-space: nowrap;
}
.mode-pill-btn:hover {
  color: #fff;
}
.mode-pill-btn.active-real {
  background: linear-gradient(135deg, #10b981, #059669);
  color: #ffffff;
  box-shadow: 0 0 12px rgba(16, 185, 129, 0.5);
}
.mode-pill-btn.active-demo {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: #000000;
  box-shadow: 0 0 12px rgba(245, 158, 11, 0.5);
}

.ingame-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}
.ingame-icon-btn {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: #8ca3c7;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 13px;
  transition: all 0.15s;
}
.ingame-icon-btn:hover {
  background: rgba(255, 255, 255, 0.18);
  color: #f5c842;
}

/* ===== MAIN GAME STAGE ===== */
.game-stage-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 16px;
  position: relative;
}

#gameTitle3D {
  font-size: 24px;
  font-weight: bold;
  letter-spacing: 3px;
  font-family: 'Cinzel', serif;
  color: #f5c842;
  text-shadow: 0 2px 0 #a07800, 0 4px 12px rgba(0,0,0,0.7);
  margin-bottom: 6px;
}
.jewel {
  display: inline-block; width: 8px; height: 8px;
  background: radial-gradient(circle at 35% 30%, #a0eaff, #0095cc);
  border-radius: 50%; vertical-align: middle; margin: 0 8px;
}

/* Balance Display */
#balanceRow {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(14, 30, 56, 0.85);
  border: 1px solid rgba(245, 200, 66, 0.35);
  padding: 4px 18px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 700;
  margin-bottom: 12px;
}
#balanceRow span:first-child { color: #8ca3c7; text-transform: uppercase; font-size: 10px; }
#balDisplay { color: #f5c842; font-family: 'Roboto Mono', monospace; font-size: 15px; }

/* ===== THE GAME REELS FRAME ===== */
#gameFrame {
  position: relative;
  width: 100%;
  max-width: 800px;
  background: #091322 url('{{ asset("assets/image/theemirate/bg.jpg") }}') center center / cover no-repeat;
  border: 2px solid #2a4870;
  border-radius: 14px;
  padding: 12px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8), inset 0 0 25px rgba(0, 0, 0, 0.9);
}

/* 5x3 Reels Grid */
#reelsGrid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 6px;
  position: relative;
  z-index: 10;
}

.reelCol {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.cell {
  aspect-ratio: 1 / 1;
  background: rgba(10, 24, 46, 0.7);
  border: 1px solid rgba(42, 72, 112, 0.6);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  box-shadow: inset 0 0 12px rgba(0,0,0,0.6);
}

.cell canvas {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}

.cell.win {
  border-color: #f5c842 !important;
  box-shadow: 0 0 18px #f5c842, inset 0 0 10px rgba(245, 200, 66, 0.4) !important;
  animation: cellWinPulse 0.6s infinite alternate;
  z-index: 15;
}
@keyframes cellWinPulse {
  0% { transform: scale(1); }
  100% { transform: scale(1.04); }
}

/* Win Lines Overlay Canvas */
#winLinesCanvas {
  position: absolute;
  top: 12px;
  left: 12px;
  right: 12px;
  bottom: 12px;
  width: calc(100% - 24px);
  height: calc(100% - 24px);
  pointer-events: none;
  z-index: 20;
}

/* Win Banner Overlay */
#winBanner {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0.5);
  background: linear-gradient(135deg, rgba(14, 30, 56, 0.96), rgba(6, 17, 34, 0.98));
  border: 2px solid #f5c842;
  border-radius: 14px;
  padding: 14px 28px;
  text-align: center;
  box-shadow: 0 0 40px rgba(245, 200, 66, 0.6);
  z-index: 100;
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
#winBanner.show {
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
  pointer-events: auto;
}
#winBanner small {
  display: block;
  font-family: 'Cinzel', serif;
  font-size: 14px;
  color: #f5c842;
  letter-spacing: 2px;
  margin-bottom: 2px;
}
#winBanner .winAmtText {
  font-family: 'Roboto Mono', monospace;
  font-size: 28px;
  font-weight: 800;
  color: #fff;
  text-shadow: 0 0 15px #f5c842;
}

/* ===== CONTROLS PILL BAR ===== */
#controls {
  margin-top: 14px;
  background: #0e1e35;
  border: 1px solid #1d3354;
  border-radius: 30px;
  padding: 6px 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 6px 20px rgba(0,0,0,0.5);
  max-width: 800px;
  width: 100%;
}
.betLabel {
  font-size: 9px;
  color: #5a8abf;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-weight: bold;
  margin-bottom: 2px;
}
.ctrlRow {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  justify-content: space-between;
}
.ctrlGroup { display: flex; align-items: center; gap: 6px; }
.arrBtn {
  color: #5a8abf;
  cursor: pointer;
  font-size: 13px;
  user-select: none;
  transition: color 0.15s;
}
.arrBtn:hover { color: #f5c842; }
.ctrlBlock { display: flex; flex-direction: column; align-items: center; min-width: 45px; }
.ctrlLabel { font-size: 8.5px; color: #5a8abf; text-transform: uppercase; font-weight: bold; }
.ctrlValue { font-size: 13px; font-weight: bold; color: #fff; font-family: 'Roboto Mono', monospace; }
.divider { width: 1px; height: 24px; background: #1d3354; }

.modeBtns { display: flex; gap: 6px; }
.modeBtn {
  background: #142848;
  border: 1px solid #2a5070;
  border-radius: 12px;
  padding: 4px 8px;
  font-size: 10px;
  font-weight: bold;
  color: #8ca3c7;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
  transition: all 0.2s;
}
.modeBtn:hover, .modeBtn.on { background: #2a5070; color: #f5c842; border-color: #f5c842; }
.modeDot { width: 6px; height: 6px; border-radius: 50%; background: #2a5070; }
.modeBtn.on .modeDot { background: #f5c842; }

/* Spin Button */
.spinWrap { position: relative; display: flex; align-items: center; }
#spinBtn {
  width: 56px; height: 56px; border-radius: 50%;
  border: none; cursor: pointer;
  background: conic-gradient(
    #f5c842 0deg,#ffe066 45deg,#d4a017 90deg,
    #f5c842 135deg,#ffe066 180deg,#d4a017 225deg,
    #f5c842 270deg,#ffe066 315deg,#d4a017 360deg
  );
  box-shadow: 0 0 0 3px #2a1a00, 0 4px 14px rgba(245,200,66,0.4);
  font-size: 11px; font-weight: bold;
  color: #3a1a00; letter-spacing: 1.5px;
  text-transform: uppercase;
  font-family: 'Outfit', sans-serif;
  transition: transform .1s, box-shadow .1s;
}
#spinBtn:hover { transform: scale(1.06); box-shadow: 0 0 0 3px #2a1a00, 0 6px 20px rgba(245,200,66,0.7); }
#spinBtn:active { transform: scale(0.95); }
#spinBtn.go { animation: spinGo .7s linear infinite; pointer-events: none; }
@keyframes spinGo { from { transform: rotate(0); } to { transform: rotate(360deg); } }

/* ===== DEPOSIT POPUP LOCK MODAL ===== */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.85);
  backdrop-filter: blur(8px);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.modal-backdrop.show { opacity: 1; visibility: visible; }
.modal-deposit-card {
  max-width: 420px;
  width: 100%;
  background: linear-gradient(180deg, #0d223f 0%, #051020 100%);
  border: 2px solid #fbbf24;
  border-radius: 20px;
  padding: 26px 20px;
  text-align: center;
  box-shadow: 0 0 50px rgba(245, 158, 11, 0.5);
  transform: scale(0.85);
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.modal-backdrop.show .modal-deposit-card { transform: scale(1); }
.modal-gold-icon {
  width: 64px; height: 64px;
  background: rgba(245, 158, 11, 0.15);
  border: 2px solid #fbbf24;
  border-radius: 50%;
  margin: 0 auto 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px; color: #fbbf24;
}
.modal-title { font-family: 'Cinzel', serif; font-size: 20px; font-weight: 900; color: #fff; margin-bottom: 8px; }
.modal-desc { font-size: 13px; color: #cbd5e1; line-height: 1.5; margin-bottom: 20px; }
.modal-btn-deposit {
  background: linear-gradient(135deg, #fef08a 0%, #f59e0b 50%, #b45309 100%);
  color: #000; font-weight: 800; font-size: 13.5px;
  padding: 12px; border-radius: 10px; text-decoration: none; display: block;
}
.modal-btn-close {
  background: rgba(255, 255, 255, 0.1); color: #94a3b8;
  font-weight: 700; font-size: 12px; padding: 8px; border-radius: 8px; border: none; cursor: pointer; margin-top: 10px; width: 100%;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .ingame-header { padding: 0 8px; gap: 6px; }
  .ingame-header .breadcrumb-area { display: none; }
  .mode-pill-btn { font-size: 10px; padding: 4px 8px; }
  #reelsGrid { gap: 4px; }
  .ctrlRow { flex-wrap: wrap; justify-content: center; gap: 8px; }
  #controls { border-radius: 16px; padding: 8px; }
}
</style>
</head>
<body>

<!-- 1XBET OFFICIAL TOP HEADER -->
@include('customer.header')

<!-- STAR BG CANVAS -->
<canvas id="bgCanvas"></canvas>

<!-- MAIN LAYOUT WRAPPER -->
<div id="gameWrapper">

  <!-- IN-GAME SUBHEADER BAR (WITH DUAL MODE SELECTOR) -->
  <div class="ingame-header">
    <div class="breadcrumb-area">
      <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">Slots</a>
      <span>/</span>
      <span class="game-title-badge">The Emirate</span>
    </div>

    <!-- 1XBET DUAL MODE SWITCHER -->
    <div class="mode-toggle-pill">
      <button id="btnPlayDemo" class="mode-pill-btn" onclick="setGameMode('demo')">
        <i class="fas fa-gamepad" style="color:#60a5fa;"></i> <span>DEMO (3 FREE)</span>
      </button>
      <button id="btnPlayReal" class="mode-pill-btn active-real" onclick="setGameMode('real')">
        <i class="fas fa-coins" style="color:#fbbf24;"></i> <span>REAL MONEY</span>
      </button>
    </div>

    <!-- Action Icons -->
    <div class="ingame-actions">
      <button class="ingame-icon-btn" title="Sound Toggle" onclick="toggleMute()"><i class="fas fa-volume-up" id="soundIcon"></i></button>
      <button class="ingame-icon-btn" title="Fullscreen" onclick="toggleFullScreen()"><i class="fas fa-expand"></i></button>
      <button class="ingame-icon-btn" title="Reload" onclick="window.location.reload()"><i class="fas fa-rotate-right"></i></button>
    </div>
  </div>

  <!-- CENTER STAGE -->
  <div class="game-stage-wrapper">
    
    <!-- TITLE -->
    <div id="gameTitle3D">
      <span class="jewel"></span>The Emirate<span class="jewel"></span>
    </div>

    <!-- BALANCE DISPLAY -->
    <div id="balanceRow">
      <span>Active Balance:</span>
      <span id="balDisplay">৳ {{ number_format(auth()->user()->balance ?? 0.00, 2) }}</span>
    </div>

    <!-- THE GAME REELS FRAME -->
    <div id="gameFrame">
      <div id="reelsGrid"></div>
      <canvas id="winLinesCanvas"></canvas>
      
      <div id="winBanner">
        <small>EMIRATE WINNER!</small>
        <div class="winAmtText">+৳ <span id="winAmt">0.00</span></div>
      </div>
    </div>

    <!-- CONTROLS PILL BAR -->
    <div id="controls">
      <div class="betLabel" id="statusLabel">Place Your Bet</div>
      <div class="ctrlRow">

        <div class="ctrlGroup">
          <div class="arrBtn" onclick="chgLines(-1)"><i class="fas fa-caret-left"></i></div>
          <div class="ctrlBlock">
            <span class="ctrlLabel">Lines</span>
            <span class="ctrlValue" id="linesVal">5</span>
          </div>
          <div class="arrBtn" onclick="chgLines(1)"><i class="fas fa-caret-right"></i></div>
        </div>

        <div class="divider"></div>

        <div class="ctrlBlock">
          <span class="ctrlLabel">Currency</span>
          <span class="ctrlValue">BDT</span>
        </div>

        <div class="divider"></div>

        <div class="ctrlGroup">
          <div class="arrBtn" onclick="chgBet(-1)"><i class="fas fa-caret-left"></i></div>
          <div class="ctrlBlock">
            <span class="ctrlLabel">Bet</span>
            <span class="ctrlValue" id="betVal">5.00</span>
          </div>
          <div class="arrBtn" onclick="chgBet(1)"><i class="fas fa-caret-right"></i></div>
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
        </div>

      </div>
    </div>

  </div><!-- /game-stage-wrapper -->
</div><!-- /gameWrapper -->

<!-- DEPOSIT POPUP MODAL -->
<div class="modal-backdrop" id="deposit-popup-modal">
  <div class="modal-deposit-card">
    <div class="modal-gold-icon">
      <i class="fas fa-lock"></i>
    </div>
    <h2 class="modal-title">ডেমো লিমিট শেষ!</h2>
    <p class="modal-desc">
      আপনার ৩টি ফ্রি ডেমো স্পিন শেষ হয়েছে। আসল ক্যাশ জিতে শেখ ও পাম জুমিরাহ স্ক্যাটার উপভোগ করতে এখনই ডিপোজিট করুন!
    </p>
    <a href="{{ route('dashboard.deposit') }}" class="modal-btn-deposit">
      <i class="fas fa-wallet"></i> ডিপোজিট করে আসল টাকা খেলুন
    </a>
    <button class="modal-btn-close" onclick="closeDepositModal()">
      বন্ধ করুন
    </button>
  </div>
</div>

<script>
/* ============================================================
   THE EMIRATE SLOT GAME
   1xBet Endorphina Luxury Architecture
   ============================================================ */

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const SPIN_URL = "{{ route('emirate.spin') }}";

// Symbols matching real image files in public/assets/image/theemirate/
const SYMS = ['gari', 'gor', 'hadi', 'kolci', 'manus', 'manus2', 'n', 't'];

// Preload Images
const imgCache = {};
SYMS.forEach(name => {
  const img = new Image();
  img.src = `{{ asset('assets/image/theemirate') }}/${name}.png`;
  imgCache[name] = img;
});

// Dynamic face animation (blink & smile & hand wave for Sheikha & Sheikh)
function animateFace(ctx, img, type, t) {
  const isGirl = type === 'manus';
  
  if (isGirl) {
    ctx.fillStyle = '#181224';
    ctx.beginPath();
    ctx.ellipse(72, 70, 16, 20, 0, 0, Math.PI * 2);
    ctx.fill();
    
    ctx.save();
    ctx.translate(72, 82);
    const waveAngle = Math.sin(t * 8) * 0.08; 
    ctx.rotate(waveAngle);
    ctx.drawImage(img, 52, 52, 36, 36, -18, -30, 36, 36);
    ctx.restore();
    
    const eyeY = 43, leftEyeX = 27, rightEyeX = 41, mouthX = 34, mouthY = 57;
    const skinColor = '#dfb496', lipColor = '#e65c5c';
    
    ctx.fillStyle = skinColor;
    ctx.beginPath();
    ctx.ellipse(leftEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.ellipse(rightEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    ctx.beginPath();
    ctx.ellipse(mouthX, mouthY + 1, 7, 3.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    const cycle = t % 1.5;
    const isBlinking = cycle > 1.35;
    
    if (isBlinking) {
      ctx.strokeStyle = '#231510'; ctx.lineWidth = 1.5; ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.arc(rightEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.stroke();
    } else {
      ctx.fillStyle = '#ffffff'; ctx.beginPath();
      ctx.ellipse(leftEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.ellipse(rightEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.fillStyle = '#4e3115'; ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.2, 1.8, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.2, 1.8, 0, Math.PI * 2);
      ctx.fill();
    }
    
    ctx.strokeStyle = lipColor; ctx.lineWidth = 2.0; ctx.lineCap = 'round';
    ctx.beginPath(); ctx.arc(mouthX, mouthY - 1, 4.5, 0.1, Math.PI - 0.1, false); ctx.stroke();
  } else {
    const eyeY = 38, leftEyeX = 44, rightEyeX = 58, mouthX = 51, mouthY = 53;
    const skinColor = '#dfb598', lipColor = '#c47d7d';
    
    ctx.fillStyle = skinColor; ctx.beginPath();
    ctx.ellipse(leftEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.ellipse(rightEyeX, eyeY, 5, 2.5, 0, 0, Math.PI * 2);
    ctx.fill();
    
    ctx.beginPath(); ctx.ellipse(mouthX, mouthY + 1, 7, 3.5, 0, 0, Math.PI * 2); ctx.fill();
    
    const cycle = t % 1.5;
    const isBlinking = cycle > 1.35;
    
    if (isBlinking) {
      ctx.strokeStyle = '#231510'; ctx.lineWidth = 1.5; ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.arc(rightEyeX, eyeY - 0.5, 4.5, 0.1, Math.PI - 0.1, false);
      ctx.stroke();
    } else {
      ctx.fillStyle = '#ffffff'; ctx.beginPath();
      ctx.ellipse(leftEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.ellipse(rightEyeX, eyeY, 4.5, 2.5, 0, 0, Math.PI * 2);
      ctx.fill();
      
      ctx.fillStyle = '#4e3115'; ctx.beginPath();
      ctx.arc(leftEyeX, eyeY - 1.0, 1.8, 0, Math.PI * 2);
      ctx.arc(rightEyeX, eyeY - 1.0, 1.8, 0, Math.PI * 2);
      ctx.fill();
    }
    
    ctx.strokeStyle = lipColor; ctx.lineWidth = 1.8; ctx.lineCap = 'round';
    ctx.beginPath(); ctx.arc(mouthX, mouthY - 1.5, 4.5, 0.2, Math.PI - 0.2, false); ctx.stroke();
  }
}

function drawSymbol(canvas, type, t) {
  const ctx = canvas.getContext('2d');
  const w = canvas.width, h = canvas.height;
  ctx.clearRect(0,0,w,h);
  
  const img = imgCache[type];
  if (img && img.complete) {
    ctx.drawImage(img, 2, 2, w - 4, h - 4);
    if (canvas.parentNode && canvas.parentNode.classList.contains('win')) {
      if (type === 'manus' || type === 'manus2') {
        animateFace(ctx, img, type, t);
      }
    }
  } else {
    ctx.fillStyle = 'rgba(14, 42, 80, 0.4)';
    ctx.fillRect(0, 0, w, h);
  }
}

// Game State
let realBalance = {{ (float)(auth()->user()->balance ?? 0.00) }};
let isDemoMode = false;
let demoBalance = {{ (float)($settings->demo_default_balance ?? 1000.00) }};
let demoSpinsDone = 0;
const DEMO_LIMIT = {{ (int)($settings->demo_spin_limit ?? 3) }};

const betAmts = [5.00, 10.00, 20.00, 50.00, 100.00, 250.00, 500.00, 1000.00];
let betIdx = 0;
const linesArr = [5];
let linesIdx = 0;
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

class SlotSoundEngine {
  constructor() {
    this.ctx = null;
    this.muted = false;
    this.spinInterval = null;
  }
  ensureAudio() {
    if (!this.ctx) {
      try {
        this.ctx = new (window.AudioContext || window.webkitAudioContext)();
      } catch (e) {}
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
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
    if (this.spinInterval) clearInterval(this.spinInterval);
    let tick = 0;
    this.spinInterval = setInterval(() => {
      this.beep(tick % 2 === 0 ? 140 : 100, 0.06, 'triangle', 0.15);
      tick++;
    }, 80);
  }
  stopSpin() {
    if (this.spinInterval) { clearInterval(this.spinInterval); this.spinInterval = null; }
  }
  playWin() {
    this.stopSpin();
    [440, 554, 659, 880, 1108].forEach((f, i) => {
      this.beep(f, 0.25, 'sine', 0.2, i * 70);
    });
  }
}

const soundEngine = new SlotSoundEngine();

function toggleMute() {
  soundEngine.muted = !soundEngine.muted;
  const icon = document.getElementById('soundIcon');
  if (soundEngine.muted) {
    icon.className = 'fas fa-volume-mute';
  } else {
    icon.className = 'fas fa-volume-up';
    soundEngine.beep(440, 0.1, 'sine', 0.2);
  }
}

document.addEventListener('click', () => { soundEngine.ensureAudio(); }, { once: true });

// Win Line Canvas Drawing
function drawWinLine(winningLines) {
  const canvas = document.getElementById('winLinesCanvas');
  const ctx = canvas.getContext('2d');
  const grid = document.getElementById('reelsGrid');
  
  canvas.width = grid.clientWidth;
  canvas.height = grid.clientHeight;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  if (!winningLines || winningLines.length === 0) return;
  
  const colWidth = canvas.width / 5;
  const rowHeight = canvas.height / 3;
  
  winningLines.forEach(line => {
    const points = line.cells.map(pos => {
      const [r, c] = pos;
      return {
        x: colWidth * c + colWidth / 2,
        y: rowHeight * r + rowHeight / 2,
        elId: `cell_${r}_${c}`
      };
    });
    
    ctx.save();
    ctx.beginPath();
    ctx.moveTo(points[0].x, points[0].y);
    for (let i = 1; i < points.length; i++) {
      ctx.lineTo(points[i].x, points[i].y);
    }
    
    ctx.strokeStyle = 'rgba(255, 224, 102, 0.5)';
    ctx.lineWidth = 10;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.shadowColor = '#f5c842';
    ctx.shadowBlur = 15;
    ctx.stroke();
    
    ctx.strokeStyle = '#ffffff';
    ctx.lineWidth = 3.5;
    ctx.stroke();
    ctx.restore();
    
    points.forEach(pt => {
      const cell = document.getElementById(pt.elId);
      if (cell) cell.classList.add('win');
    });
  });
}

function clearWinLine() {
  const canvas = document.getElementById('winLinesCanvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  document.querySelectorAll('.cell.win').forEach(c => c.classList.remove('win'));
}

// Build Reels
function buildReels(grid) {
  const container = document.getElementById('reelsGrid');
  container.innerHTML = '';
  cellData = [];

  for(let col=0; col<5; col++){
    const reel = document.createElement('div');
    reel.className = 'reelCol';
    for(let row=0; row<3; row++){
      const cell = document.createElement('div');
      cell.className = 'cell';
      cell.id = `cell_${row}_${col}`;
      const cv = document.createElement('canvas');
      cv.width = 100; cv.height = 100;
      cell.appendChild(cv);
      reel.appendChild(cell);
      cellData.push({canvas: cv, sym: grid[row][col], row, col});
    }
    container.appendChild(reel);
  }
  startAnim();
}

function startAnim() {
  if(animRAF) cancelAnimationFrame(animRAF);
  function loop() {
    const t = Date.now()/1000;
    cellData.forEach(cd => {
      if(cd.canvas && !cd.spinning) drawSymbol(cd.canvas, cd.sym, t);
    });
    animRAF = requestAnimationFrame(loop);
  }
  animRAF = requestAnimationFrame(loop);
}

// Controls
function chgBet(d) {
  if (spinning) return;
  betIdx = Math.max(0, Math.min(betAmts.length - 1, betIdx + d));
  document.getElementById('betVal').innerText = betAmts[betIdx].toFixed(2);
}

function chgLines(d) {
  // Classic 5 fixed paylines
}

function togTurbo() {
  turboOn = !turboOn;
  document.getElementById('turboBtn').classList.toggle('on', turboOn);
}

function togAuto() {
  autoOn = !autoOn;
  document.getElementById('autoBtn').classList.toggle('on', autoOn);
  if (autoOn && !spinning) doSpin();
}

function updateBalUI() {
  const balEl = document.getElementById('balDisplay');
  if (isDemoMode) {
    balEl.innerText = "DEMO ৳ " + demoBalance.toFixed(2);
    balEl.style.color = "#f59e0b";
  } else {
    balEl.innerText = "৳ " + realBalance.toFixed(2);
    balEl.style.color = "#f5c842";
  }
}

// 1XBET DUAL MODE SWITCHER FUNCTION
function setGameMode(mode) {
  if (spinning) return;
  const btnDemo = document.getElementById('btnPlayDemo');
  const btnReal = document.getElementById('btnPlayReal');

  if (mode === 'demo') {
    isDemoMode = true;
    btnDemo.className = 'mode-pill-btn active-demo';
    btnReal.className = 'mode-pill-btn';
  } else {
    isDemoMode = false;
    btnReal.className = 'mode-pill-btn active-real';
    btnDemo.className = 'mode-pill-btn';
  }
  updateBalUI();
}

function closeDepositModal() {
  document.getElementById('deposit-popup-modal').classList.remove('show');
}

// Spin execution
function doSpin() {
  if (spinning) return;

  const currentBet = betAmts[betIdx];

  // Demo limit check
  if (isDemoMode && demoSpinsDone >= DEMO_LIMIT) {
    document.getElementById('deposit-popup-modal').classList.add('show');
    if (autoOn) togAuto();
    return;
  }

  // Real balance check
  if (!isDemoMode && realBalance < currentBet) {
    alert("পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।");
    if (autoOn) togAuto();
    return;
  }

  spinning = true;
  document.getElementById('spinBtn').classList.add('go');
  document.getElementById('statusLabel').textContent = "SPINNING...";
  clearWinLine();
  document.getElementById('winBanner').classList.remove('show');

  soundEngine.playSpin();

  // Shuffling animation on canvas
  cellData.forEach(cd => cd.spinning = true);
  const shuffleTimer = setInterval(() => {
    cellData.forEach(cd => {
      const rSym = SYMS[Math.floor(Math.random() * SYMS.length)];
      drawSymbol(cd.canvas, rSym, Date.now() / 1000);
    });
  }, 70);

  // Send request to Laravel backend
  fetch(SPIN_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": CSRF_TOKEN,
      "Accept": "application/json"
    },
    body: JSON.stringify({
      bet_amount: currentBet,
      is_demo: isDemoMode,
      demo_spins_count: demoSpinsDone
    })
  })
  .then(res => res.json())
  .then(data => {
    const spinDuration = turboOn ? 600 : 1200;
    setTimeout(() => {
      clearInterval(shuffleTimer);
      soundEngine.stopSpin();

      if (data.status === 'deposit_required') {
        cellData.forEach(cd => cd.spinning = false);
        document.getElementById('spinBtn').classList.remove('go');
        spinning = false;
        document.getElementById('deposit-popup-modal').classList.add('show');
        if (autoOn) togAuto();
        return;
      }

      if (data.error) {
        alert(data.error);
        cellData.forEach(cd => cd.spinning = false);
        document.getElementById('spinBtn').classList.remove('go');
        spinning = false;
        if (autoOn) togAuto();
        return;
      }

      // Update grid with backend matrix
      currentGrid = data.grid;
      cellData.forEach(cd => {
        cd.sym = data.grid[cd.row][cd.col];
        cd.spinning = false;
        drawSymbol(cd.canvas, cd.sym, Date.now() / 1000);
      });

      // Win Handling
      if (data.is_win && data.win_amount > 0) {
        soundEngine.playWin();
        drawWinLine(data.winning_lines);

        const banner = document.getElementById('winBanner');
        document.getElementById('winAmt').innerText = parseFloat(data.win_amount).toFixed(2);
        banner.classList.add('show');

        setTimeout(() => { banner.classList.remove('show'); }, 3000);
        document.getElementById('statusLabel').textContent = "WIN: ৳ " + parseFloat(data.win_amount).toFixed(2);
      } else {
        document.getElementById('statusLabel').textContent = "PLACE YOUR BET";
      }

      // Balance update
      if (isDemoMode) {
        demoSpinsDone++;
        demoBalance = demoBalance - currentBet + data.win_amount;
        updateBalUI();
      } else if (data.new_balance !== null && data.new_balance !== undefined) {
        realBalance = parseFloat(data.new_balance);
        updateBalUI();
      }

      document.getElementById('spinBtn').classList.remove('go');
      spinning = false;

      if (autoOn) {
        setTimeout(() => { if (autoOn && !spinning) doSpin(); }, 1200);
      }
    }, spinDuration);
  })
  .catch(err => {
    clearInterval(shuffleTimer);
    soundEngine.stopSpin();
    cellData.forEach(cd => cd.spinning = false);
    document.getElementById('spinBtn').classList.remove('go');
    spinning = false;
    console.error("Spin error:", err);
    if (autoOn) togAuto();
  });
}

// Background Starfield
function initBg() {
  const cv = document.getElementById('bgCanvas');
  const ctx = cv.getContext('2d');
  const stars = [];
  function resize() { cv.width = window.innerWidth; cv.height = window.innerHeight; }
  resize();
  window.addEventListener('resize', resize);
  for(let i=0; i<120; i++){
    stars.push({
      x: Math.random()*cv.width, y: Math.random()*cv.height,
      r: Math.random()*1.4+0.3,
      spd: Math.random()*0.5+0.2, phase: Math.random()*Math.PI*2
    });
  }
  function drawBg() {
    ctx.clearRect(0,0,cv.width,cv.height);
    const t = Date.now()/1000;
    stars.forEach(s => {
      const a = 0.2 + Math.sin(t*s.spd + s.phase)*0.5;
      ctx.fillStyle = `rgba(245, 200, 66, ${Math.max(0, a * 0.7)})`;
      ctx.beginPath(); ctx.arc(s.x, s.y, s.r, 0, Math.PI*2); ctx.fill();
    });
    requestAnimationFrame(drawBg);
  }
  drawBg();
}

function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(() => {});
  } else {
    document.exitFullscreen().catch(() => {});
  }
}

// Initialise
window.addEventListener('DOMContentLoaded', () => {
  buildReels(currentGrid);
  initBg();
  updateBalUI();
});
</script>
</body>
</html>
