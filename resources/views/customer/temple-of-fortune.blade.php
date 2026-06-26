<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Temple of Fortune — Golden Ways</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   TEMPLE OF FORTUNE — original 5x3 "ways to win" slot.
   ============================================================ */
:root{
  --black-deep:#0d0701;
  --black:#140b03;
  --brown:#3a2510;
  --brown-dk:#1c1305;
  --gold:#d9a443;
  --gold-br:#ffd76a;
  --gold-lt:#fff3cf;
  --gold-dk:#8a5e1f;
  --green:#1d9d55;
  --green-lt:#5be88a;
  --ember:#e2572b;
  --blue:#4fd6ff;
  --purple:#a87dff;
  --shadow:rgba(0,0,0,.6);
}
*{ box-sizing:border-box; }
html,body{
  margin:0; min-height:100vh;
  background:var(--black-deep);
  font-family:'Outfit','Trebuchet MS',sans-serif;
  color:#fff7df;
  overflow:hidden;
}

/* ============================================================
   SLOT CABINET FRAMEWORK LAYOUT (same as western.blade.php)
   ============================================================ */
#outerWrapper {
  display: flex;
  min-height: 100vh;
  background: #050d09;
}

/* Sidenav */
.game-sidenav {
  width: 50px;
  background: #08120d;
  border-right: 1px solid #1a3222;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 12px 0;
  gap: 16px;
  position: relative;
  z-index: 10;
}
.game-sidenav .side-link {
  color: #4a7a5d;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.2s;
  width: 32px; height: 32px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 6px;
}
.game-sidenav .side-link:hover, .game-sidenav .side-link.active {
  background: rgba(217,164,67,0.1);
  color: var(--gold);
}

.workspace-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Header */
.game-header {
  height: 36px;
  background: #08120d;
  border-bottom: 1px solid #1a3222;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 12px;
  position: relative; z-index: 10;
}
.game-header .breadcrumb {
  font-size: 10px; font-weight: 700; color: #4a7a5d;
  display: flex; align-items: center; gap: 4px;
  text-transform: uppercase;
}
.game-header .breadcrumb a { color: #4a7a5d; text-decoration: none; }
.game-header .breadcrumb a:hover { color: #fff; }
.game-header .breadcrumb span { color: var(--gold); }
.game-header .header-title {
  font-family: 'Exo 2', sans-serif; font-weight: 900;
  font-size: 12px; letter-spacing: 1px; color: #ffffff;
  text-transform: uppercase;
}
.game-header .header-actions { display: flex; align-items: center; gap: 8px; }
.game-header .search-wrap { position: relative; }
.game-header .search-input {
  background: #050d09; border: 1px solid #1a3222; border-radius: 4px;
  padding: 2px 8px 2px 20px; font-size: 10px; color: #fff; width: 120px; outline: none;
}
.game-header .search-wrap i { position: absolute; left: 6px; top: 50%; transform: translateY(-50%); font-size: 9px; color: #4a7a5d; }
.game-header .win-btn {
  color: #4a7a5d; font-size: 12px; background: none; border: none; cursor: pointer; padding: 2px; transition: color 0.15s;
}
.game-header .win-btn:hover { color: var(--gold); }

/* Sub-Header */
.game-sub-header {
  height: 32px; background: #050d09; border-bottom: 1px solid #1a3222;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 12px; z-index: 10;
}
.game-sub-header .game-badge { display: flex; align-items: center; gap: 6px; }
.game-sub-header .game-title { font-size: 10px; font-weight: 800; color: #ffffff; }
.game-sub-header .real-money-toggle { display: flex; align-items: center; gap: 6px; }
.game-sub-header .real-money-toggle span { font-size: 9px; font-weight: 800; color: #4a7a5d; text-transform: uppercase; }
.game-sub-header .toggle-switch {
  width: 24px; height: 12px; background: #020604;
  border: 1px solid var(--gold); border-radius: 6px;
  position: relative; cursor: pointer; transition: all 0.2s;
}
.game-sub-header .toggle-dot {
  width: 8px; height: 8px; background: var(--gold); border-radius: 50%;
  position: absolute; top: 1px; left: 1px; transition: all 0.2s;
}

/* Footer bar */
.game-footer {
  height: 32px; background: #08120d; border-top: 1px solid #1a3222;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 12px; position: relative; z-index: 10;
}
.game-footer .footer-tab {
  display: flex; align-items: center; gap: 4px;
  color: #4a7a5d; font-size: 10px; font-weight: 800;
  cursor: pointer; transition: color 0.15s; text-transform: uppercase;
}
.game-footer .footer-tab:hover { color: #fff; }

/* Cabinet Stage */
.cabinet-stage {
  flex: 1; position: relative; overflow: hidden;
  display: flex; align-items: center; justify-content: center; padding: 4px;
}

.backdrop{ position:absolute; inset:0; z-index:0; background:#0d0701; overflow:hidden; }
.backdrop video {
  position:absolute;
  top:50%; left:50%;
  width:100%; height:100%;
  object-fit:cover;
  transform:translate(-50%,-50%);
  pointer-events:none;
}
#bgFxCanvas{ position:absolute; inset:0; z-index:0; width:100%; height:100%; pointer-events:none; }

.stage{
  position:relative; z-index:1;
  max-width:1040px; width:100%;
  margin:-45px auto 0;
  display:flex; flex-direction:column; align-items:center;
}

.game-frame{
  position:relative;
  width:min(900px,96vw);
  max-height: calc(100vh - 142px);
  border-radius:18px;
  padding:8px 12px 8px;
  background:linear-gradient(155deg,#4a2f12,#1c1305 55%,#4a2f12);
  box-shadow:0 12px 30px var(--shadow), inset 0 0 0 2px rgba(255,243,207,.28), inset 0 0 20px rgba(0,0,0,.9);
}

.table{ position:relative; width:100%; }

.reel-area-wrap{
  position:relative; width:100%; padding-right:80px;
}

.reel-area{
  position:relative; border-radius:12px; overflow:hidden;
  background:#0d0701;
  box-shadow:inset 0 0 0 3px rgba(202,162,79,.65), inset 0 10px 24px rgba(0,0,0,.9), inset 0 -10px 24px rgba(0,0,0,.9);
  aspect-ratio:5/3.1;
  max-height:clamp(280px,58vh,480px);
  width:100%;
}

.temple-bg-art{ position:absolute; inset:0; z-index:0; }
.temple-bg-art svg { width:100%; height:100%; }

/* Multiplier pips */
.mult-row{
  position:absolute; z-index:4;
  top:2%; left:12%; right:12%;
  display:flex; justify-content:space-between;
}
.mult-pill{
  width:15%; text-align:center; padding:2px 0;
  border-radius:10px; font-size:9px; font-weight:800;
  color:var(--gold-lt);
  background:linear-gradient(180deg,#243a5c,#101c30);
  box-shadow:0 0 0 1px rgba(255,243,207,.2), 0 3px 6px rgba(0,0,0,.4);
  transition:background .2s, color .2s, transform .2s;
}
.mult-pill.hot{
  background:linear-gradient(180deg,#ffe9b0,#d9a443);
  color:#3a1505; transform:scale(1.08);
}

/* Right control panel layout */
.right-controls {
  position: absolute;
  right: 12px;
  top: 52%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  z-index: 100;
}

/* Control buttons general styling */
.control-btn {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  border: 2px solid #caa24f;
  background: radial-gradient(circle at 35% 30%, #5a3a10 0%, #2a1505 70%);
  color: #ffd76a;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,.65), inset 0 1px 3px rgba(255,215,100,.25);
  transition: transform 0.1s, filter 0.15s;
  outline: none;
}
.control-btn:hover {
  filter: brightness(1.25);
  box-shadow: 0 0 10px rgba(217, 164, 67, 0.4);
}
.control-btn:active {
  transform: scale(0.9);
}
.control-btn svg, .control-btn i {
  font-size: 18px;
  fill: #ffd76a;
  color: #ffd76a;
}
.control-btn.active {
  border-color: #5be88a;
  color: #5be88a;
}

/* Spin button in the middle */
.control-btn.spin {
  width: 76px;
  height: 76px;
  border-radius: 50%;
  border: 4px solid #fff3cf;
  background: radial-gradient(circle at 36% 28%, #f0e060 0%, #d9a443 40%, #8a5e1f 75%);
  box-shadow: 0 6px 18px rgba(0,0,0,.7), inset 0 2px 5px rgba(255,255,255,.25), 0 0 14px rgba(217,164,67,.5);
}
.control-btn.spin svg {
  width: 30px;
  height: 30px;
  fill: #fff;
}
.control-btn.spin:disabled {
  opacity: .5;
  cursor: not-allowed;
  filter: grayscale(.4);
}

/* Buy feature purple button */
.control-btn.buy-feature {
  background: linear-gradient(135deg, #a87dff 0%, #7033ff 100%);
  border-color: #ffd76a;
  box-shadow: 0 4px 10px rgba(112, 51, 255, 0.4);
}
.control-btn.buy-feature svg, .control-btn.buy-feature i {
  color: #ffeb3b;
  fill: #ffeb3b;
}
.control-btn.buy-feature.close-state {
  background: linear-gradient(135deg, #ff5d7a 0%, #c81d4a 100%);
  border-color: #ffb8c6;
  box-shadow: 0 4px 10px rgba(200, 29, 74, 0.4);
}
.control-btn.buy-feature.close-state i, .control-btn.buy-feature.close-state svg {
  color: #fff;
  fill: #fff;
}

/* Bet Selector Pop List */
.bet-selector-pop {
  position: absolute;
  right: 64px;
  top: 15%;
  width: 130px;
  background: rgba(22, 16, 30, 0.95);
  border: 1.5px solid rgba(217, 164, 67, 0.5);
  border-radius: 12px;
  padding: 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.8);
  display: none;
  flex-direction: column;
  align-items: center;
  z-index: 200;
  max-height: 280px;
}
.bet-selector-pop.show {
  display: flex;
}
.bet-selector-title {
  font-size: 10px;
  font-weight: 800;
  color: #ffd76a;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
  text-transform: uppercase;
}
.bet-option-list {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 3px;
  overflow-y: auto;
  max-height: 220px;
  padding-right: 4px;
}
.bet-option-list::-webkit-scrollbar {
  width: 4px;
}
.bet-option-list::-webkit-scrollbar-thumb {
  background: rgba(217, 164, 67, 0.3);
  border-radius: 2px;
}
.bet-option {
  width: 100%;
  padding: 6px 8px;
  text-align: center;
  border-radius: 16px;
  font-size: 12px;
  font-weight: 700;
  color: rgba(255,255,255,0.6);
  cursor: pointer;
  transition: all 0.1s;
}
.bet-option:hover {
  color: #fff;
  background: rgba(255,255,255,0.06);
}
.bet-option.active {
  background: #fff;
  color: #16101e;
}

/* Buy Feature Overlay */
.buy-feature-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.7);
  z-index: 150;
  display: none;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
}
.buy-feature-overlay.show {
  display: flex;
}
.buy-feature-content {
  text-align: center;
  width: 90%;
  max-width: 400px;
  background: linear-gradient(180deg, #1c1305 0%, #0d0701 100%);
  border: 2px solid #caa24f;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 12px 36px rgba(0,0,0,0.9);
}
.buy-feature-title {
  font-size: 14px;
  font-weight: 900;
  color: #ffd76a;
  margin-bottom: 16px;
  letter-spacing: 1px;
  text-transform: uppercase;
}
.buy-feature-options {
  display: flex;
  gap: 16px;
  justify-content: center;
}
.buy-card {
  flex: 1;
  background: linear-gradient(180deg, #b08dff 0%, #6030cc 100%);
  border: 1.5px solid rgba(255,255,255,0.25);
  border-radius: 12px;
  padding: 14px 10px;
  cursor: pointer;
  box-shadow: 0 6px 16px rgba(0,0,0,0.6);
  transition: transform 0.15s ease, filter 0.15s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.buy-card.god-mode {
  background: linear-gradient(180deg, #d36eff 0%, #7d26b3 100%);
}
.buy-card:hover {
  transform: scale(1.04);
  filter: brightness(1.1);
}
.buy-card-title {
  font-size: 11px;
  font-weight: 900;
  color: #fff;
  text-transform: uppercase;
  margin-bottom: 6px;
  letter-spacing: 0.5px;
}
.buy-card-cost {
  font-size: 15px;
  font-weight: 800;
  color: #ffe066;
  font-family: Georgia, serif;
}
.buy-card-currency {
  font-size: 9px;
  font-weight: 700;
  color: #fff;
  opacity: 0.8;
}

/* Game Menu Overlay */
.menu-overlay {
  position: absolute;
  inset: 0;
  background: rgba(13, 8, 22, 0.95);
  z-index: 180;
  display: none;
  flex-direction: column;
  padding: 20px;
  color: #fff;
  border-radius: 12px;
  justify-content: space-between;
}
.menu-overlay.show {
  display: flex;
}
.menu-header {
  display: flex;
  align-items: center;
}
.menu-title {
  font-size: 16px;
  font-weight: 900;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #ffd76a;
  flex: 1;
  text-align: center;
}
.menu-close-btn {
  cursor: pointer;
  font-size: 18px;
  color: rgba(255,255,255,0.6);
  background: none;
  border: none;
  padding: 4px;
}
.menu-close-btn:hover {
  color: #fff;
}
.menu-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin: 16px 0;
}
.menu-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 10px;
  padding: 12px 6px;
  text-align: center;
  cursor: pointer;
  transition: all 0.15s;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}
.menu-card:hover {
  background: rgba(255,255,255,0.12);
  border-color: #ffd76a;
}
.menu-card i {
  font-size: 20px;
  color: #ffd76a;
}
.menu-card span {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
}
.menu-switches {
  display: flex;
  justify-content: space-between;
  background: rgba(0,0,0,0.3);
  padding: 10px;
  border-radius: 8px;
}
.switch-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  font-weight: 700;
  color: rgba(255,255,255,0.8);
  text-transform: uppercase;
}
.switch {
  position: relative;
  display: inline-block;
  width: 32px;
  height: 18px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #444;
  transition: .15s;
  border-radius: 18px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 12px;
  width: 12px;
  left: 3px;
  bottom: 3px;
  background-color: #fff;
  transition: .15s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #10b981;
}
input:checked + .slider:before {
  transform: translateX(14px);
}

.reel-grid{
  position:relative; z-index:2;
  display:grid;
  grid-template-columns:repeat(5,1fr);
  grid-template-rows:repeat(3,1fr);
  gap:3px; width:76%; height:78%;
  margin:0 auto; top:11%; padding:4px;
  border-radius:8px;
}
.cell{
  position:relative; border-radius:5px;
  display:flex; align-items:center; justify-content:center;
  overflow:hidden;
  background:linear-gradient(160deg,rgba(35,22,8,.8),rgba(15,8,2,.88));
  border:1.5px solid rgba(217, 164, 67, 0.35);
  animation: border-fire-normal 2.5s ease-in-out infinite;
  transition:filter .2s, opacity .2s, box-shadow .2s;
}
.cell svg{
  width:76%; height:76%; object-fit:contain;
  -webkit-user-drag: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  pointer-events: none;
}
.cell img{
  width:100%; height:100%; object-fit:cover;
  border-radius:4px;
  -webkit-user-drag: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  pointer-events: none;
}
.cell.dim{ filter:grayscale(.7) brightness(.35); opacity:.55; }
.cell.win{
  position: relative;
  z-index: 5;
  border-color: #ffd76a !important;
  animation: win-fire-powerful 0.5s ease-in-out infinite;
}
.cell.win img, .cell.win svg {
  animation: win-symbol-shake 0.5s ease-in-out infinite;
}
.cell.spinning svg, .cell.spinning img{
  filter: blur(2px) scaleY(1.15);
}

@keyframes border-fire-normal {
  0%, 100% {
    box-shadow: 
      inset 0 0 6px rgba(255, 255, 255, 0.15),
      0 0 3px #ffd76a,
      0 -2px 6px rgba(255, 140, 0, 0.65),
      0 -4px 12px rgba(255, 69, 0, 0.45);
    border-color: #ffd76a;
  }
  50% {
    box-shadow: 
      inset 0 0 10px rgba(255, 255, 255, 0.35),
      0 0 5px #fff3cf,
      0 -4px 12px rgba(255, 215, 0, 0.85),
      0 -8px 20px rgba(255, 60, 0, 0.65);
    border-color: #fff3cf;
  }
}

@keyframes win-fire-powerful {
  0%, 100% {
    box-shadow: 
      inset 0 0 15px rgba(255, 255, 255, 0.9), 
      0 0 10px #fff,
      0 -6px 25px #ffd76a, 
      0 -12px 45px #ff8c00, 
      0 -18px 65px #ff4500;
    border-color: #ffffff;
    transform: scale(1.0);
  }
  50% {
    box-shadow: 
      inset 0 0 25px rgba(255, 255, 255, 1), 
      0 0 20px #fff,
      0 -10px 35px #fff3cf, 
      0 -20px 60px #ffd76a, 
      0 -30px 90px #ff0000;
    border-color: #ffd76a;
    transform: scale(1.08);
  }
}

@keyframes win-symbol-shake {
  0%, 100% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.08) rotate(-3deg); }
  75% { transform: scale(1.08) rotate(3deg); }
}

.win-banner{
  position:absolute; left:50%; bottom:6%;
  transform:translate(-50%,12px);
  z-index:6; padding:4px 18px; border-radius:8px;
  font-family:Georgia,serif; font-weight:800; font-size:18px; color:#fff7df;
  background:linear-gradient(180deg,rgba(40,25,10,.95),rgba(15,8,3,.98));
  box-shadow:0 0 0 1px var(--gold), 0 6px 16px rgba(0,0,0,.5);
  opacity:0; transition:opacity .25s, transform .25s; pointer-events:none;
  white-space:nowrap;
}
.win-banner.show{ opacity:1; transform:translate(-50%,0); }

/* Free spin mode pill */
.mode-pill{
  position:absolute; top:4px; left:50%; transform:translateX(-50%);
  z-index:9; font-size:9px; font-weight:800; letter-spacing:1px;
  padding:2px 10px; border-radius:14px;
  background:linear-gradient(180deg,#ff5d7a,#c81d4a);
  color:#fff; box-shadow:0 3px 8px rgba(0,0,0,.4);
}

/* Spin button */
.spin-btn{
  position:absolute; right:0; top:50%; transform:translateY(-50%);
  z-index:10; width:72px; height:72px; border-radius:50%;
  border:4px solid #fff3cf;
  background:radial-gradient(circle at 36% 28%,#f0e060 0%,#d9a443 40%,#8a5e1f 75%,#4a2e08 100%);
  color:#fff; display:flex; align-items:center; justify-content:center;
  cursor:pointer;
  box-shadow:0 6px 18px rgba(0,0,0,.7), inset 0 2px 5px rgba(255,255,255,.25), 0 0 14px rgba(217,164,67,.5);
  transition:filter 0.15s ease; outline:none;
}
.spin-btn:hover{ filter:brightness(1.15); }
.spin-btn:active{ filter:brightness(0.88); }
.spin-btn svg{ width:26px; height:26px; fill:#fff; }
.spin-btn:disabled{ opacity:.5; cursor:not-allowed; filter:grayscale(.4); }

/* Bet row */
.bet-row{
  display:flex; align-items:center; gap:6px; justify-content:center; margin-top:6px;
}
.bet-box{
  flex:0 0 auto; display:flex; align-items:center; gap:8px;
  padding:5px 12px; border-radius:8px;
  background:linear-gradient(180deg,rgba(74,47,18,.85),rgba(28,19,5,.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.35), inset 0 2px 4px rgba(0,0,0,.55);
}
.bet-box label{ font-size:9px; letter-spacing:1px; text-transform:uppercase; color:var(--gold-lt); opacity:.7; }
.bet-box span{ font-size:14px; font-weight:700; color:#fff7df; font-family:Georgia,serif; min-width:46px; text-align:center; display:inline-block; }
.stepper{
  width:26px; height:26px; border-radius:50%;
  border:1px solid rgba(217,164,67,.5);
  background:radial-gradient(circle at 35% 30%,#caa24f,#7a4e12);
  color:#3a1505; font-size:14px; font-weight:700;
  cursor:pointer; display:flex; align-items:center; justify-content:center;
  transition:transform .1s, background .15s;
}
.stepper:hover{ background:radial-gradient(circle at 35% 30%,#e2bb66,#946018); }
.stepper:active{ transform:scale(.88); }

.balance-bar{
  display:flex; justify-content:space-between; align-items:center;
  margin-top:8px; padding:6px 12px; border-radius:8px;
  background:linear-gradient(180deg,rgba(28,19,5,.85),rgba(13,7,1,.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.3);
  font-size:12px; font-weight:700; color:var(--gold-lt);
}
.balance-bar .chip{ display:flex; align-items:center; gap:6px; }
.balance-bar svg{ width:14px; height:14px; }

.paytable-pop{
  position:absolute; z-index:8;
  bottom:42px; left:6px;
  width:200px; padding:8px 10px; border-radius:10px;
  background:linear-gradient(160deg,rgba(74,47,18,.95),rgba(13,7,1,.98));
  box-shadow:0 0 0 1px var(--gold), 0 8px 20px rgba(0,0,0,.6);
  font-size:10px; opacity:0; transform:translateY(6px);
  pointer-events:none; transition:opacity .2s, transform .2s;
}
.paytable-pop.show{ opacity:1; transform:translateY(0); pointer-events:auto; }
.paytable-pop h4{ margin:0 0 4px; font-size:10px; letter-spacing:.5px; color:var(--gold-br); text-transform:uppercase; }
.paytable-pop .row{ display:flex; align-items:center; justify-content:space-between; gap:4px; padding:2px 0; border-top:1px solid rgba(255,243,207,.08); }
.paytable-pop .row svg, .paytable-pop .row img{
  width:18px; height:18px; object-fit:contain;
  -webkit-user-drag: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  pointer-events: none;
}
.paytable-pop .row span{ opacity:.8; }

.footer-note{ margin-top:6px; font-size:10px; color:rgba(255,247,223,.45); text-align:center; letter-spacing:.5px; }

/* Toast */
.toast-msg{
  position:fixed; top:85px; left:50%; transform:translateX(-50%);
  background:#08120d; border:2px solid var(--gold);
  border-radius:10px; padding:12px 28px;
  font-family:'Exo 2',sans-serif; font-size:14px; font-weight:700;
  color:#fff; letter-spacing:1px; z-index:9999;
  animation:toastIn 0.3s ease; white-space:nowrap;
  box-shadow:0 4px 20px rgba(0,0,0,.8);
}
.toast-msg.win{ border-color:var(--green); color:var(--green-lt); background:#06160d; }
.toast-msg.lose{ border-color:var(--ember); color:#ffa080; background:#200a05; }
@keyframes toastIn{ from{opacity:0;transform:translateX(-50%) translateY(-10px);}to{opacity:1;transform:translateX(-50%) translateY(0);} }

@keyframes pulse-fs{
  0%,100%{ filter:drop-shadow(0 0 4px rgba(255,215,106,.6)); }
  50%{ filter:drop-shadow(0 0 14px rgba(255,215,106,1)); }
}

/* Splash Screen Styles */
#gameSplashScreen {
  position: fixed;
  inset: 0;
  background: #090300;
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 1;
  transition: opacity 0.4s ease-out;
}
.splash-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  width: min(500px, 90vw);
}
#splashLogo {
  width: 100%;
  height: auto;
  object-fit: contain;
  -webkit-user-drag: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  pointer-events: none;
  animation: logo-breathing 4.5s ease-in-out infinite;
}
.progress-container {
  width: 80%;
  height: 5px;
  background: rgba(255, 243, 207, 0.08);
  border-radius: 4px;
  overflow: hidden;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.6);
  border: 1px solid rgba(217, 164, 67, 0.15);
}
.progress-bar {
  width: 0%;
  height: 100%;
  background: linear-gradient(90deg, #d9a443, #ffd76a, #d9a443);
  box-shadow: 0 0 10px #ffd76a;
  border-radius: 4px;
  transition: width 1s cubic-bezier(0.1, 0.8, 0.25, 1);
}

@keyframes logo-breathing {
  0%, 100% {
    transform: scale(1) translateY(0) rotate(0deg);
    filter: drop-shadow(0 5px 15px rgba(217, 164, 67, 0.2));
  }
  30% {
    transform: scale(1.025) translateY(-3px) rotate(-0.5deg);
    filter: drop-shadow(0 10px 25px rgba(217, 164, 67, 0.35));
  }
  65% {
    transform: scale(1.01) translateY(-1px) rotate(0.5deg);
    filter: drop-shadow(0 7px 20px rgba(217, 164, 67, 0.25));
  }
}
</style>
</head>
<body>

<!-- Splash Loading Screen -->
<div id="gameSplashScreen">
  <div class="splash-content">
    <img src="{{ asset('assets/image/Abyss of Glory.webp') }}" id="splashLogo" alt="Abyss of Glory" ondragstart="return false;">
    <div class="progress-container">
      <div class="progress-bar" id="splashProgressBar"></div>
    </div>
  </div>
</div>

<div id="outerWrapper">
  <!-- Left Vertical Sidenav -->
  <aside class="game-sidenav">
    <div class="logo-space">
      <span style="font-style:italic; font-weight:900; font-size:16px; color:var(--gold);">1X</span>
    </div>
    <div class="side-link" onclick="window.location.href='{{ route('dashboard') }}'" title="Home">
      <i class="fas fa-home"></i>
    </div>
    <div class="side-link" title="Favorites"><i class="fas fa-heart"></i></div>
    <div class="side-link active" title="Lobby"><i class="fas fa-th-large"></i></div>
    <div class="side-link" title="Popular"><i class="fas fa-bolt"></i></div>
    <div class="side-link" title="Tournaments"><i class="fas fa-trophy"></i></div>
    <div class="side-link" title="Games"><i class="fas fa-gamepad"></i></div>
  </aside>

  <div class="workspace-container">
    <!-- Top Header Bar -->
    <header class="game-header">
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Search results</a>
        <i class="fas fa-chevron-right" style="font-size:8px; margin:0 4px;"></i>
        <span>Temple of Fortune</span>
      </div>
      <div class="header-title">TEMPLE OF FORTUNE</div>
      <div class="header-actions">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" class="search-input" value="Temple of Fortune" readonly>
        </div>
        <button class="win-btn" title="Duplicate Window"><i class="fas fa-window-restore"></i></button>
        <button class="win-btn" onclick="toggleFullScreen()" title="Fullscreen"><i class="fas fa-expand"></i></button>
        <button class="win-btn" onclick="window.location.reload()" title="Reload"><i class="fas fa-rotate"></i></button>
        <button class="win-btn" title="Favorite"><i class="far fa-star"></i></button>
        <button class="win-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="Close"><i class="fas fa-xmark"></i></button>
      </div>
    </header>

    <!-- Sub-Header -->
    <div class="game-sub-header">
      <div class="game-badge">
        <span style="font-size:14px; color:#ffd76a;">🏛️</span>
        <span class="game-title">Temple of Fortune</span>
      </div>
      <div class="real-money-toggle">
        <span id="modeStatusText">PLAY IN DEMO MODE</span>
        <div class="toggle-switch" id="realMoneyToggle">
          <div class="toggle-dot" id="realMoneyDot"></div>
        </div>
      </div>
    </div>

    <!-- Main Game Stage -->
    <div class="cabinet-stage">
      <div class="backdrop">
        <video autoplay muted loop playsinline id="bgVideo">
          <source src="{{ asset('assets/image/AbyssofGlory/bg-video.mp4') }}" type="video/mp4">
        </video>
      </div>
      <canvas id="bgFxCanvas"></canvas>
<main class="stage">
        <div class="title-bar" style="display: none;">
          <h1 id="titleH1" style="font-family:Georgia,serif; font-style:italic; font-size:26px; letter-spacing:2px; margin:0; background:linear-gradient(180deg,#fff3cf,#d9a443); -webkit-background-clip:text; background-clip:text; color:transparent; filter:drop-shadow(0 0 10px rgba(217,164,67,.5));">TEMPLE OF FORTUNE</h1>
          <p id="titleSub" style="margin:2px 0 0; font-size:10px; letter-spacing:2px; text-transform:uppercase; color:var(--gold-lt); opacity:.7;">243 GOLDEN WAYS · ORIGINAL DEMO GAME</p>
        </div>

        <div class="game-frame">
          <div class="mode-pill" id="modePill">DEMO MODE</div>

          <!-- Bet Selector Popup -->
          <div class="bet-selector-pop" id="betSelectorPop">
            <div class="bet-selector-title">Bets</div>
            <div class="bet-option-list" id="betOptionList"></div>
          </div>

          <!-- Buy Feature Overlay -->
          <div class="buy-feature-overlay" id="buyFeatureOverlay">
            <div class="buy-feature-content">
              <div class="buy-feature-title">Select Buy Feature</div>
              <div class="buy-feature-options">
                <div class="buy-card" id="buyCardFreeSpins">
                  <div class="buy-card-title">Free Spins</div>
                  <div style="margin: 8px 0;">
                    <svg viewBox="0 0 24 24" style="width: 42px; height: 42px; fill: #ffd76a;">
                      <polygon points="12,3 21,8 3,8"/><rect x="4" y="9" width="2" height="9"/><rect x="8" y="9" width="2" height="9"/><rect x="14" y="9" width="2" height="9"/><rect x="18" y="9" width="2" height="9"/><rect x="3" y="19" width="18" height="2"/>
                    </svg>
                  </div>
                  <div class="buy-card-cost" id="buyCostFreeSpins">3,000.00</div>
                  <div class="buy-card-currency" id="buyCurrencyFreeSpins">EUR</div>
                </div>
                <div class="buy-card god-mode" id="buyCardGodMode">
                  <div class="buy-card-title">God Mode Spins</div>
                  <div style="margin: 8px 0;">
                    <svg viewBox="0 0 24 24" style="width: 42px; height: 42px; fill: #ffd76a;">
                      <circle cx="12" cy="12" r="10" stroke="#fff3cf" stroke-width="1.2" fill="none"/>
                      <path d="M12 6v12M6 12h12" stroke="#ffeb3b" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                  </div>
                  <div class="buy-card-cost" id="buyCostGodMode">9,000.00</div>
                  <div class="buy-card-currency" id="buyCurrencyGodMode">EUR</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Game Menu Overlay -->
          <div class="menu-overlay" id="menuOverlay">
            <div class="menu-header">
              <div class="menu-title">Game Menu</div>
              <button class="menu-close-btn" id="menuCloseBtn"><i class="fas fa-times"></i></button>
            </div>
            <div class="menu-grid">
              <div class="menu-card" id="menuCardPaytable">
                <i class="fas fa-table-cells"></i>
                <span>Paytable</span>
              </div>
              <div class="menu-card" id="menuCardInfo">
                <i class="fas fa-info-circle"></i>
                <span>Game Info</span>
              </div>
              <div class="menu-card" id="menuCardSettings">
                <i class="fas fa-sliders"></i>
                <span>Settings</span>
              </div>
            </div>
            <div class="menu-switches">
              <div class="switch-item">
                <span>Sound</span>
                <label class="switch">
                  <input type="checkbox" id="soundSwitch" checked>
                  <span class="slider"></span>
                </label>
              </div>
              <div class="switch-item">
                <span>Fast play</span>
                <label class="switch">
                  <input type="checkbox" id="fastPlaySwitch">
                  <span class="slider"></span>
                </label>
              </div>
              <div class="switch-item">
                <span>Full screen</span>
                <label class="switch">
                  <input type="checkbox" id="fullScreenSwitch">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="table">
            <div class="reel-area-wrap">
              <div class="reel-area" id="reelArea">
                <!-- Temple background art -->
                <div class="temple-bg-art">
                  <svg viewBox="0 0 100 62" preserveAspectRatio="xMidYMid slice" width="100%" height="100%">
                    <defs>
                      <radialGradient id="templeGlow" cx="50%" cy="20%" r="65%">
                        <stop offset="0%" stop-color="#4a2f12"/>
                        <stop offset="55%" stop-color="#1c1305"/>
                        <stop offset="100%" stop-color="#0d0701"/>
                      </radialGradient>
                    </defs>
                    <rect width="100" height="62" fill="url(#templeGlow)"/>
                    <!-- Pillars -->
                    <g opacity="0.45" stroke="#caa24f" stroke-width="1.2" fill="none">
                      <line x1="6" y1="2" x2="6" y2="60"/>
                      <line x1="94" y1="2" x2="94" y2="60"/>
                      <line x1="2" y1="6" x2="98" y2="6"/>
                    </g>
                    <!-- Temple roof -->
                    <polygon points="50,2 90,10 10,10" fill="#3a2510" opacity="0.55" stroke="#caa24f" stroke-width="0.8"/>
                    <!-- Ambient glow circles -->
                    <circle cx="50" cy="31" r="28" fill="none" stroke="rgba(202,162,79,0.12)" stroke-width="2"/>
                  </svg>
                </div>

                <!-- Multiplier row -->
                <div class="mult-row" id="multRow"></div>

                <div class="reel-grid" id="reelGrid"></div>
                <div class="win-banner" id="winBanner">0.00</div>

                <div class="paytable-pop" id="paytablePop">
                  <h4>Symbol Values ×3 / ×4 / ×5</h4>
                  <div id="paytableList"></div>
                </div>
              </div><!-- end reel-area -->

              <!-- Right controls column -->
              <div class="right-controls">
                <button class="control-btn menu" id="menuBtn" title="Menu">
                  <i class="fas fa-bars"></i>
                </button>
                <button class="control-btn bet-toggle" id="betToggleBtn" title="Select Bet">
                  <i class="fas fa-toggle-on"></i>
                </button>
                <button class="control-btn spin" id="spinBtn" title="Spin">
                  <svg viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm-6.8 5.2L3.74 7.74C2.63 9.03 2 10.74 2 12.5c0 4.42 3.58 8 8 8v-3c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8z"/></svg>
                </button>
                <button class="control-btn autospin" id="autoBtn" title="Autoplay">
                  <i class="fas fa-redo"></i>
                </button>
                <button class="control-btn buy-feature" id="bonusBtn" title="Buy Feature">
                  <i class="fas fa-star"></i>
                </button>
              </div>
            </div><!-- end reel-area-wrap -->
          </div><!-- end table -->

          <div class="bet-row">
            <div class="bet-label" id="betLabelContainer">Bet (EUR)</div>
            <div class="bet-capsule">
              <button class="stepper" id="betMinus">–</button>
              <span class="bet-val" id="betDisplay">0.40</span>
              <button class="stepper" id="betPlus">+</button>
            </div>
          </div>

          <div class="balance-bar">
            <div class="chip" style="pointer-events: auto; cursor: pointer;" id="betDisplayTrigger">
              <i class="fas fa-coins"></i>
              <span id="betEcho">0.40 EUR</span>
            </div>
            <div class="chip">
              <i class="fas fa-wallet"></i>
              <span id="balanceDisplay">10,000.00 EUR</span>
            </div>
          </div>
        </div><!-- end game-frame -->

        <p class="footer-note">Demo play only · No real money · 243 Ways to Win</p>
      </main>
    </div>

    <!-- Footer bar -->
    <footer class="game-footer">
      <div style="display:flex; gap:20px;">
        <div class="footer-tab"><i class="fas fa-clock" style="margin-right:4px;"></i> Recent Games</div>
        <div class="footer-tab"><i class="fas fa-star" style="margin-right:4px;"></i> Favorites</div>
      </div>
      <div>
        <i class="fas fa-headset" style="color:#4a7a5d; cursor:pointer; font-size:14px;" title="Customer Support"></i>
      </div>
    </footer>
  </div>
</div>

<script>
// --- AUDIO SYNTHESIZER (Web Audio API) ---
let audioCtx = null;
function getAudioContext() {
  if (!audioCtx) {
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  }
  if (audioCtx.state === 'suspended') {
    audioCtx.resume();
  }
  return audioCtx;
}

function playButtonSound() {
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = 'sine';
    osc.frequency.setValueAtTime(600, ctx.currentTime);
    osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.05);
    gain.gain.setValueAtTime(0.08, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.005, ctx.currentTime + 0.05);
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.start();
    osc.stop(ctx.currentTime + 0.05);
  } catch(e) {}
}

function playSpinSound() {
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(150, ctx.currentTime);
    osc.frequency.exponentialRampToValueAtTime(300, ctx.currentTime + 0.18);
    gain.gain.setValueAtTime(0.12, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.start();
    osc.stop(ctx.currentTime + 0.3);
  } catch(e) {}
}

function playStopSound() {
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = 'sine';
    osc.frequency.setValueAtTime(130, ctx.currentTime);
    osc.frequency.exponentialRampToValueAtTime(45, ctx.currentTime + 0.08);
    gain.gain.setValueAtTime(0.2, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.08);
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.start();
    osc.stop(ctx.currentTime + 0.08);
  } catch(e) {}
}

function playWinSound() {
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50]; // C major
    const now = ctx.currentTime;
    notes.forEach((freq, idx) => {
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.type = 'sine';
      osc.frequency.value = freq;
      const time = now + idx * 0.11;
      gain.gain.setValueAtTime(0, now);
      gain.gain.setValueAtTime(0.15, time);
      gain.gain.exponentialRampToValueAtTime(0.005, time + 0.22);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start(time);
      osc.stop(time + 0.22);
    });
  } catch(e) {}
}

function playFreeSpinsSound() {
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const now = ctx.currentTime;
    for (let i = 0; i < 15; i++) {
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.type = 'sawtooth';
      osc.frequency.value = 200 + i * 80;
      const time = now + i * 0.05;
      gain.gain.setValueAtTime(0, now);
      gain.gain.setValueAtTime(0.1, time);
      gain.gain.exponentialRampToValueAtTime(0.01, time + 0.12);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start(time);
      osc.stop(time + 0.12);
    }
  } catch(e) {}
}

/* ============================================================
   TEMPLE OF FORTUNE — 243 Ways slot engine
   ============================================================ */

// --- CURRENCY ---
const userCurrency = "{{ auth()->user()->currency }}";
const currencySymbolMap = { 'EUR':'€','USD':'$','BDT':'৳','GBP':'£','INR':'₹' };
const currencySymbol = currencySymbolMap[userCurrency] || (userCurrency + ' ');
let realBalance = parseFloat("{{ auth()->user()->balance }}");
let isDemoMode = true;
let demoBalance = 10000.00;
let balance = demoBalance;

// --- TOGGLE ---
document.getElementById('realMoneyToggle').addEventListener('click', () => {
  isDemoMode = !isDemoMode;
  balance = isDemoMode ? demoBalance : realBalance;
  document.getElementById('realMoneyToggle').classList.toggle('on', !isDemoMode);
  document.getElementById('modeStatusText').textContent = isDemoMode ? 'PLAY IN DEMO MODE' : 'PLAY FOR REAL MONEY';
  updateMoney();
});

// --- TOAST ---
function showToast(message, type=''){
  const old = document.querySelector('.toast-msg');
  if(old) old.remove();
  const t = document.createElement('div');
  t.className = `toast-msg ${type}`;
  t.textContent = message;
  document.body.appendChild(t);
  setTimeout(()=>{ t.style.opacity='0'; t.style.transition='opacity .4s'; setTimeout(()=>t.remove(),400); }, 2400);
}

// --- FULLSCREEN ---
function toggleFullScreen(){
  if(!document.fullscreenElement) document.documentElement.requestFullscreen().catch(()=>{});
  else document.exitFullscreen();
}

// --- BALANCE SYNC ---
function syncBalance(newBalance){
  if(isDemoMode){ demoBalance = newBalance; return; }
  realBalance = newBalance;
  fetch('{{ route("dashboard.update-balance") }}', {
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},
    body:JSON.stringify({balance:newBalance.toFixed(2)})
  }).catch(()=>{});
}

/* ---- SYMBOLS (AbyssofGlory Images) ---- */
const SYMS = [
  { id:'statueRed',   weight:16, pay:{3:0.2,4:0.5,5:1.5},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/1.png') }}" alt="1">` },
  { id:'statueGreen', weight:16, pay:{3:0.2,4:0.5,5:1.5},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/2.png') }}" alt="2">` },
  { id:'statueBlue',  weight:14, pay:{3:0.25,4:0.6,5:1.8}, render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/3.png') }}" alt="3">` },
  { id:'horn',        weight:14, pay:{3:0.25,4:0.6,5:1.8}, render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/4.png') }}" alt="4">` },
  { id:'swords',      weight:12, pay:{3:0.4,4:1.0,5:3.0},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/5.png') }}" alt="5">` },
  { id:'sym6',        weight:12, pay:{3:0.4,4:1.0,5:3.0},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/6.png') }}" alt="6">` },
  { id:'sym7',        weight:10, pay:{3:0.6,4:1.6,5:5.0},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/7.png') }}" alt="7">` },
  { id:'sym8',        weight:8,  pay:{3:1.0,4:3.0,5:9.0},  render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/8.png') }}" alt="8">` },
  { id:'temple',      weight:4,  pay:{3:2.0,4:8.0,5:30.0}, isScatter:true, render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/9.png') }}" alt="9">` },
  { id:'wild',        weight:4,  pay:{3:4.0,4:12.0,5:50.0}, isWild:true,    render:()=>`<img src="{{ asset('assets/image/AbyssofGlory/10.png') }}" alt="10">` },
];
const TOTAL_WEIGHT = SYMS.reduce((s,x)=>s+x.weight,0);
const SYM_BY_ID = Object.fromEntries(SYMS.map(s=>[s.id,s]));
const PAYABLE_SYMS = SYMS.filter(s=>!s.isScatter&&!s.isWild);

function pickSymbol(){
  if (state.isGodMode && Math.random() < 0.25) {
    const premiums = ['wild', 'temple', 'sym8', 'sym7'];
    return premiums[Math.floor(Math.random() * premiums.length)];
  }
  let r = Math.random()*TOTAL_WEIGHT;
  for(const s of SYMS){ r-=s.weight; if(r<=0) return s.id; }
  return SYMS[0].id;
}

const REELS=5, ROWS=3;
function spinGrid(){
  const grid=[];
  for(let c=0;c<REELS;c++){
    const col=[];
    for(let r=0;r<ROWS;r++) col.push(pickSymbol());
    grid.push(col);
  }
  return grid;
}

function evaluateWays(grid){
  const wins=[];
  PAYABLE_SYMS.forEach(sym=>{
    let runLength=0, ways=1;
    const cells=[];
    for(let c=0;c<REELS;c++){
      const mp=[];
      for(let r=0;r<ROWS;r++){
        const cur=grid[c][r];
        if(cur===sym.id||SYM_BY_ID[cur].isWild) mp.push(r);
      }
      if(mp.length===0) break;
      runLength++; ways*=mp.length;
      mp.forEach(r=>cells.push([c,r]));
    }
    if(runLength>=3){
      const mult=sym.pay[Math.min(runLength,5)]||0;
      if(mult>0) wins.push({symId:sym.id,runLength,ways,cells,mult});
    }
  });
  return wins;
}

function countScatters(grid){
  let n=0;
  for(let c=0;c<REELS;c++) for(let r=0;r<ROWS;r++) if(grid[c][r]==='temple') n++;
  return n;
}

/* ---- BACKGROUND FX ---- */
class MoneyBackdrop{
  constructor(canvas){
    this.canvas=canvas; this.ctx=canvas.getContext('2d');
    this.dpr=Math.min(window.devicePixelRatio||1,2);
    this.items=[]; this._resize();
    window.addEventListener('resize',()=>this._resize());
    const count=window.innerWidth<640?14:26;
    for(let i=0;i<count;i++) this.items.push(this._spawn(true));
    this._lastT=performance.now();
    requestAnimationFrame(this._loop.bind(this));
  }
  _resize(){ this.w=window.innerWidth; this.h=window.innerHeight; this.canvas.width=this.w*this.dpr; this.canvas.height=this.h*this.dpr; }
  _spawn(randomY){
    const kind=Math.random()<0.55?'bill':'sign';
    return { kind, x:Math.random()*this.w, y:randomY?Math.random()*this.h:this.h+40,
      vy:10+Math.random()*16, vx:(Math.random()-0.5)*6, rot:Math.random()*Math.PI*2,
      vr:(Math.random()-0.5)*0.4, size:16+Math.random()*20, alpha:0.10+Math.random()*0.16, sway:Math.random()*Math.PI*2 };
  }
  _loop(now){
    const dt=Math.min((now-this._lastT)/1000,0.05); this._lastT=now;
    const ctx=this.ctx;
    ctx.save(); ctx.scale(this.dpr,this.dpr); ctx.clearRect(0,0,this.w,this.h);
    this.items.forEach(p=>{
      p.sway+=dt*0.6; p.y-=p.vy*dt; p.x+=p.vx*dt+Math.sin(p.sway)*0.4; p.rot+=p.vr*dt;
      if(p.y<-60||p.x<-60||p.x>this.w+60) Object.assign(p,this._spawn(false));
      this._drawItem(ctx,p);
    });
    ctx.restore();
    requestAnimationFrame(this._loop.bind(this));
  }
  _drawItem(ctx,p){
    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(p.rot); ctx.globalAlpha=p.alpha;
    if(p.kind==='bill'){
      const w=p.size*1.7,h=p.size;
      const grad=ctx.createLinearGradient(-w/2,-h/2,w/2,h/2);
      grad.addColorStop(0,'#fff3cf'); grad.addColorStop(0.5,'#d9a443'); grad.addColorStop(1,'#8a5e1f');
      ctx.fillStyle=grad; ctx.strokeStyle='rgba(255,255,255,0.5)'; ctx.lineWidth=1;
      this._roundRect(ctx,-w/2,-h/2,w,h,h*0.18); ctx.fill(); ctx.stroke();
      ctx.fillStyle='rgba(58,21,5,0.6)';
      ctx.beginPath(); ctx.arc(0,0,h*0.22,0,Math.PI*2); ctx.fill();
    } else {
      ctx.font=`bold ${p.size}px Georgia,serif`; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillStyle='#ffd76a'; ctx.fillText('$',0,0);
    }
    ctx.restore();
  }
  _roundRect(ctx,x,y,w,h,r){
    ctx.beginPath();
    ctx.moveTo(x+r,y); ctx.arcTo(x+w,y,x+w,y+h,r); ctx.arcTo(x+w,y+h,x,y+h,r);
    ctx.arcTo(x,y+h,x,y,r); ctx.arcTo(x,y,x+w,y,r); ctx.closePath();
  }
}

/* ---- MAIN LOGIC ---- */
(()=>{
  const $=sel=>document.querySelector(sel);
  const els={
    bgFxCanvas: $('#bgFxCanvas'), reelGrid:$('#reelGrid'),
    winBanner:$('#winBanner'), spinBtn:$('#spinBtn'),
    betMinus:$('#betMinus'), betPlus:$('#betPlus'),
    betDisplay:$('#betDisplay'), betEcho:$('#betEcho'),
    balanceDisplay:$('#balanceDisplay'),
    autoBtn:$('#autoBtn'), bonusBtn:$('#bonusBtn'),
    menuBtn:$('#menuBtn'), paytablePop:$('#paytablePop'),
    paytableList:$('#paytableList'), multRow:$('#multRow'),
    modePill:$('#modePill'), titleH1:$('#titleH1'), titleSub:$('#titleSub'),
  };

  const BET_STEPS=[0.20,0.40,1.00,2.00,5.00,10.00,25.00,50.00];
  const state={ bet:0.40, turbo:false, auto:false, spinning:false, freeSpinsLeft:0, freeSpinMult:1, isGodMode:false };
  window.state = state;

  new MoneyBackdrop(els.bgFxCanvas);

  // Build 5×3 grid
  const cells=[];
  for(let r=0;r<ROWS;r++){
    cells.push([]);
    for(let c=0;c<REELS;c++){
      const div=document.createElement('div');
      div.className='cell';
      els.reelGrid.appendChild(div);
      cells[r].push(div);
    }
  }

  // Multiplier pips
  const pips=[];
  for(let c=0;c<REELS;c++){
    const p=document.createElement('div');
    p.className='mult-pill'; p.textContent='×1';
    els.multRow.appendChild(p); pips.push(p);
  }
  function setPips(value,hot){ pips.forEach(p=>{ p.textContent='×'+value; p.classList.toggle('hot',!!hot); }); }

  function paintCell(div,symId){ div.innerHTML=SYM_BY_ID[symId].render(); }

  function buildPaytable(){
    els.paytableList.innerHTML=SYMS.map(s=>`
      <div class="row">
        ${s.render()}
        <span>${s.isScatter?'Scatter · FS':(s.pay[3].toFixed(1)+'/'+s.pay[4].toFixed(1)+'/'+s.pay[5].toFixed(1))}</span>
      </div>`).join('');
  }
  buildPaytable();

  let currentGrid=spinGrid();
  for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) paintCell(cells[r][c],currentGrid[c][r]);

  function updateMoney(){
    els.balanceDisplay.textContent=(isDemoMode?'DEMO ':'')+(isDemoMode?demoBalance:realBalance).toFixed(2);
    els.betEcho.textContent=(isDemoMode?'DEMO ':'')+state.bet.toFixed(2);
  }
  window.updateMoney = updateMoney;
  updateMoney();

  els.betMinus.addEventListener('click',()=>{
    if(state.spinning||state.freeSpinsLeft>0) return;
    playButtonSound();
    const idx=BET_STEPS.indexOf(state.bet);
    state.bet=BET_STEPS[Math.max(0,idx-1)];
    els.betDisplay.textContent=state.bet.toFixed(2); updateMoney();
  });
  els.betPlus.addEventListener('click',()=>{
    if(state.spinning||state.freeSpinsLeft>0) return;
    playButtonSound();
    const idx=BET_STEPS.indexOf(state.bet);
    state.bet=BET_STEPS[Math.min(BET_STEPS.length-1,idx+1)];
    els.betDisplay.textContent=state.bet.toFixed(2); updateMoney();
  });

  function sleep(ms){ return new Promise(res=>setTimeout(res,ms)); }

  async function spinReel(c,finalCol){
    const dur=(state.turbo?240:560)+c*(state.turbo?55:130);
    const flickerMs=state.turbo?32:50;
    const start=performance.now();
    for(let r=0;r<ROWS;r++) cells[r][c].classList.add('spinning');
    while(performance.now()-start<dur){
      for(let r=0;r<ROWS;r++) paintCell(cells[r][c],pickSymbol());
      await sleep(flickerMs);
    }
    for(let r=0;r<ROWS;r++){
      paintCell(cells[r][c],finalCol[r]);
      cells[r][c].classList.remove('spinning');
    }
    playStopSound();
  }

  function clearCellStates(){ for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) cells[r][c].classList.remove('dim','win'); }
  function showWinBanner(text){ els.winBanner.textContent=text; els.winBanner.classList.add('show'); }
  function hideWinBanner(){ els.winBanner.classList.remove('show'); }

  function setFreeSpinUI(active){
    els.modePill.textContent=active?`FREE SPINS · ${state.freeSpinsLeft} LEFT`:'DEMO MODE';
    els.modePill.style.background=active
      ?'linear-gradient(180deg,#ffe9b0,#d9a443)'
      :'linear-gradient(180deg,#ff5d7a,#c81d4a)';
    els.modePill.style.color=active?'#3a1505':'#fff';
    if(active) els.titleH1.style.animation='pulse-fs 1.1s ease-in-out infinite';
    else els.titleH1.style.animation='none';
    els.titleSub.textContent=active?`Multiplier ×${state.freeSpinMult} active`:'243 GOLDEN WAYS · ORIGINAL DEMO GAME';
  }

  async function runSpin(){
    state.spinning=true; els.spinBtn.disabled=true;
    hideWinBanner(); clearCellStates();

    playSpinSound();

    const grid=spinGrid();
    await Promise.all([0,1,2,3,4].map(c=>spinReel(c,grid[c])));

    const wins=evaluateWays(grid);
    const scatters=countScatters(grid);

    if(wins.length){
      const totalMult=wins.reduce((s,w)=>s+w.mult*w.ways,0);
      const amount=totalMult*state.bet*state.freeSpinMult;
      if(isDemoMode) demoBalance+=amount; else{ realBalance+=amount; syncBalance(realBalance); }
      balance=isDemoMode?demoBalance:realBalance;
      updateMoney();
      for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) cells[r][c].classList.add('dim');
      wins.forEach(w=>w.cells.forEach(([c,r])=>{ cells[r][c].classList.remove('dim'); cells[r][c].classList.add('win'); }));
      showWinBanner('Win  '+(totalMult*state.bet*state.freeSpinMult).toFixed(2));

      playWinSound();

      if(state.freeSpinsLeft>0){
        if (state.isGodMode) {
          state.freeSpinMult += 3;
        } else {
          state.freeSpinMult++;
        }
        setPips(state.freeSpinMult,true);
        setFreeSpinUI(true);
      }
      await sleep(state.turbo?450:1000);
      clearCellStates();
    }

    if(scatters>=3&&state.freeSpinsLeft===0){
      state.freeSpinsLeft=8; state.freeSpinMult=1;
      
      playFreeSpinsSound();

      showWinBanner('🏛️ FREE SPINS AWARDED!'); setFreeSpinUI(true);
      await sleep(900); hideWinBanner();
    }

    if(state.freeSpinsLeft>0){
      state.freeSpinsLeft--;
      setFreeSpinUI(true);
      if(state.freeSpinsLeft===0){
        await sleep(500);
        setFreeSpinUI(false);
        setPips(1,false);
        state.freeSpinMult=1;
        state.isGodMode=false;
      }
    }

    state.spinning=false; els.spinBtn.disabled=false;
    if(state.freeSpinsLeft>0||state.auto){ doSpin(); }
  }

  async function doSpin(){
    if(state.spinning) return;
    const bal=isDemoMode?demoBalance:realBalance;
    if(state.freeSpinsLeft===0){
      if(bal<state.bet){ showToast('Insufficient balance!','lose'); return; }
      if(isDemoMode) demoBalance-=state.bet; else{ realBalance-=state.bet; syncBalance(realBalance); }
      updateMoney();
    }
    await runSpin();
  }

  els.spinBtn.addEventListener('click',()=>{ playButtonSound(); doSpin(); });
  els.autoBtn.addEventListener('click',()=>{
    playButtonSound();
    state.auto=!state.auto;
    els.autoBtn.classList.toggle('active',state.auto);
    if(state.auto&&!state.spinning) doSpin();
  });

  // --- BET SELECTOR POPUP ---
  const betPop = document.getElementById('betSelectorPop');
  function populateBetSelector() {
    const list = document.getElementById('betOptionList');
    list.innerHTML = BET_STEPS.map(step => {
      const isActive = step === state.bet;
      return `<div class="bet-option ${isActive ? 'active' : ''}" data-val="${step}">${step.toFixed(2)} ${userCurrency}</div>`;
    }).join('');
    
    list.querySelectorAll('.bet-option').forEach(el => {
      el.addEventListener('click', () => {
        playButtonSound();
        const val = parseFloat(el.getAttribute('data-val'));
        state.bet = val;
        document.getElementById('betDisplay').textContent = val.toFixed(2);
        updateMoney();
        betPop.classList.remove('show');
      });
    });
  }

  const toggleBetPop = () => {
    playButtonSound();
    populateBetSelector();
    betPop.classList.toggle('show');
  };

  document.getElementById('betToggleBtn').addEventListener('click', (e) => {
    e.stopPropagation();
    if(state.spinning||state.freeSpinsLeft>0) return;
    toggleBetPop();
  });

  document.getElementById('betDisplayTrigger').addEventListener('click', (e) => {
    e.stopPropagation();
    if(state.spinning||state.freeSpinsLeft>0) return;
    toggleBetPop();
  });

  document.addEventListener('click', (e) => {
    if (betPop.classList.contains('show') && !betPop.contains(e.target)) {
      betPop.classList.remove('show');
    }
  });

  // --- BUY FEATURE POPUP ---
  const buyOverlay = document.getElementById('buyFeatureOverlay');
  function toggleBuyFeature(forceClose = false) {
    const isOpen = buyOverlay.classList.contains('show');
    if (isOpen || forceClose) {
      buyOverlay.classList.remove('show');
      els.bonusBtn.classList.remove('close-state');
      els.bonusBtn.innerHTML = '<i class="fas fa-star"></i>';
    } else {
      const freeSpinsCost = state.bet * 100;
      const godModeCost = state.bet * 300;
      document.getElementById('buyCostFreeSpins').textContent = freeSpinsCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      document.getElementById('buyCostGodMode').textContent = godModeCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      document.getElementById('buyCurrencyFreeSpins').textContent = userCurrency;
      document.getElementById('buyCurrencyGodMode').textContent = userCurrency;
      
      buyOverlay.classList.add('show');
      els.bonusBtn.classList.add('close-state');
      els.bonusBtn.innerHTML = '<i class="fas fa-times"></i>';
    }
  }

  els.bonusBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (state.spinning || state.freeSpinsLeft > 0) return;
    playButtonSound();
    toggleBuyFeature();
  });

  document.getElementById('buyCardFreeSpins').addEventListener('click', async () => {
    if (state.spinning || state.freeSpinsLeft > 0) return;
    const cost = state.bet * 100;
    const bal = isDemoMode ? demoBalance : realBalance;
    if (bal < cost) {
      showToast('Insufficient balance!', 'lose');
      return;
    }
    playButtonSound();
    if (isDemoMode) {
      demoBalance -= cost;
    } else {
      realBalance -= cost;
      syncBalance(realBalance);
    }
    state.freeSpinsLeft = 8;
    state.freeSpinMult = 1;
    state.isGodMode = false;
    updateMoney();
    toggleBuyFeature(true);
    
    setPips(1, true);
    showWinBanner('🏛️ FREE SPINS PURCHASED!');
    setFreeSpinUI(true);
    playFreeSpinsSound();
    
    await sleep(1200);
    hideWinBanner();
    doSpin();
  });

  document.getElementById('buyCardGodMode').addEventListener('click', async () => {
    if (state.spinning || state.freeSpinsLeft > 0) return;
    const cost = state.bet * 300;
    const bal = isDemoMode ? demoBalance : realBalance;
    if (bal < cost) {
      showToast('Insufficient balance!', 'lose');
      return;
    }
    playButtonSound();
    if (isDemoMode) {
      demoBalance -= cost;
    } else {
      realBalance -= cost;
      syncBalance(realBalance);
    }
    state.freeSpinsLeft = 8;
    state.freeSpinMult = 5;
    state.isGodMode = true;
    updateMoney();
    toggleBuyFeature(true);
    
    setPips(5, true);
    showWinBanner('⚡ GOD MODE ACTIVATED!');
    setFreeSpinUI(true);
    playFreeSpinsSound();
    
    await sleep(1200);
    hideWinBanner();
    doSpin();
  });

  // --- GAME MENU OVERLAY ---
  const menuOverlay = document.getElementById('menuOverlay');
  els.menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    playButtonSound();
    menuOverlay.classList.toggle('show');
  });

  document.getElementById('menuCloseBtn').addEventListener('click', (e) => {
    e.stopPropagation();
    playButtonSound();
    menuOverlay.classList.remove('show');
  });

  document.addEventListener('click', (e) => {
    if (menuOverlay.classList.contains('show') && !menuOverlay.contains(e.target) && e.target !== els.menuBtn) {
      menuOverlay.classList.remove('show');
    }
  });

  document.getElementById('menuCardPaytable').addEventListener('click', () => {
    playButtonSound();
    menuOverlay.classList.remove('show');
    els.paytablePop.classList.add('show');
  });

  document.getElementById('menuCardInfo').addEventListener('click', () => {
    playButtonSound();
    showToast('Temple of Fortune: 5 Reels, 243 Golden Ways to Win! Return to Player: 96.5%.', 'win');
  });

  document.getElementById('menuCardSettings').addEventListener('click', () => {
    playButtonSound();
    showToast('Graphics: High Quality. Engine: Web Audio Synthesizer.', 'win');
  });

  // Switches wiring
  document.getElementById('soundSwitch').addEventListener('change', function() {
    playButtonSound();
  });

  document.getElementById('fastPlaySwitch').addEventListener('change', function() {
    state.turbo = this.checked;
    playButtonSound();
  });

  document.getElementById('fullScreenSwitch').addEventListener('change', function() {
    playButtonSound();
    if (this.checked) {
      if(!document.documentElement.requestFullscreen) return;
      if(!document.fullscreenElement) document.documentElement.requestFullscreen().catch(()=>{});
    } else {
      if(document.exitFullscreen && document.fullscreenElement) document.exitFullscreen();
    }
  });

  document.addEventListener('fullscreenchange', () => {
    const isFS = !!document.fullscreenElement;
    document.getElementById('fullScreenSwitch').checked = isFS;
  });

  document.addEventListener('click',(e)=>{
    if(!els.paytablePop.contains(e.target)&&e.target!==document.getElementById('menuCardPaytable')){
      els.paytablePop.classList.remove('show');
    }
  });

  // Anti-inspect protection
  document.addEventListener('contextmenu', e => e.preventDefault());
  document.addEventListener('keydown', e => {
    // Disable F12
    if (e.keyCode === 123) {
      e.preventDefault();
      return false;
    }
    // Disable Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C
    if (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) {
      e.preventDefault();
      return false;
    }
    // Disable Ctrl+U
    if (e.ctrlKey && e.keyCode === 85) {
      e.preventDefault();
      return false;
    }
  });

  // Force play and unmute background video on user interaction
  const bgVid = document.getElementById('bgVideo');
  if (bgVid) {
    // Autoplay muted immediately to bypass browser blocks
    bgVid.muted = true;
    bgVid.play().catch(() => {});

    // Ensure it never stops or stays paused
    bgVid.addEventListener('pause', () => {
      bgVid.play().catch(() => {});
    });

    bgVid.addEventListener('ended', () => {
      bgVid.play().catch(() => {});
    });

    // Unmute with sound on the first user interaction on the page
    const unmuteOnGesture = () => {
      bgVid.muted = false;
      bgVid.play().catch((err) => {
        console.warn("Unmuted autoplay blocked, falling back to muted play:", err);
        bgVid.muted = true;
        bgVid.play().catch(() => {});
      });
      document.removeEventListener('click', unmuteOnGesture);
      document.removeEventListener('keydown', unmuteOnGesture);
      document.removeEventListener('touchstart', unmuteOnGesture);
    };
    document.addEventListener('click', unmuteOnGesture);
    document.addEventListener('keydown', unmuteOnGesture);
    document.addEventListener('touchstart', unmuteOnGesture);
  }

  // Splash Screen Loading Animation
  setTimeout(() => {
    const bar = document.getElementById('splashProgressBar');
    if (bar) bar.style.width = '100%';
  }, 50);

  setTimeout(() => {
    const splash = document.getElementById('gameSplashScreen');
    if (splash) {
      splash.style.opacity = '0';
      setTimeout(() => {
        splash.style.display = 'none';
      }, 400);
    }
  }, 1050);
})();
</script>
</body>
</html>
