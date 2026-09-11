<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Abyss of Glory (Temple of Fortune) — 1xBet Casino Slot Game</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Outfit:wght@300;400;600;700;800;900&family=Roboto+Mono:wght@400;700&family=Russo+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   TEMPLE OF FORTUNE / ABYSS OF GLORY — 1xBet Standard CSS
   ============================================================ */
:root{
  --black-deep:#060301;
  --black:#0e0702;
  --brown:#3a2510;
  --brown-dk:#1c1305;
  --gold:#d9a443;
  --gold-br:#ffd76a;
  --gold-lt:#fff3cf;
  --gold-dk:#8a5e1f;
  --green:#1d9d55;
  --green-lt:#5be88a;
  --ember:#e2572b;
  --blue:#00d4ff;
  --purple:#a87dff;
  --shadow:rgba(0,0,0,.75);
}
*{ box-sizing:border-box; margin:0; padding:0; }
html,body{
  margin:0; padding:0; min-height:100vh;
  background:var(--black-deep);
  font-family:'Outfit','Trebuchet MS',sans-serif;
  color:#fff7df;
  overflow-x:hidden;
  user-select:none;
  -webkit-user-select:none;
}

/* Framework Layout */
#outerWrapper {
  display: flex;
  min-height: 100vh;
  background: #050d09;
  width: 100%;
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
  z-index: 20;
  flex-shrink: 0;
}
.game-sidenav .side-link {
  color: #4a7a5d;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.2s;
  width: 34px; height: 34px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 6px;
}
.game-sidenav .side-link:hover, .game-sidenav .side-link.active {
  background: rgba(217,164,67,0.15);
  color: var(--gold);
}
.game-sidenav .side-link.fav-active {
  color: #ff4757 !important;
  text-shadow: 0 0 10px rgba(255, 71, 87, 0.8);
}
.game-sidenav .side-link.turbo-active {
  background: rgba(255, 215, 0, 0.2) !important;
  color: #ffd700 !important;
  text-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
}

.workspace-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: calc(100% - 50px);
  position: relative;
}

/* Header */
.game-header {
  height: 36px;
  background: #08120d;
  border-bottom: 1px solid #1a3222;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 12px;
  position: relative; z-index: 10;
  flex-shrink: 0;
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
  padding: 2px 8px 2px 20px; font-size: 10px; color: #fff; width: 130px; outline: none;
}
.game-header .search-wrap i { position: absolute; left: 6px; top: 50%; transform: translateY(-50%); font-size: 9px; color: #4a7a5d; }
.game-header .win-btn {
  color: #4a7a5d; font-size: 12px; background: none; border: none; cursor: pointer; padding: 2px; transition: color 0.15s;
}
.game-header .win-btn:hover { color: var(--gold); }

/* Sub-Header */
.game-sub-header {
  height: 34px; background: #050d09; border-bottom: 1px solid #1a3222;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 12px; z-index: 10;
  flex-shrink: 0;
  gap: 8px;
}
.game-sub-header .game-badge { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.game-sub-header .game-title { font-size: 11px; font-weight: 800; color: #ffffff; white-space: nowrap; }

.game-sub-header .real-money-toggle { display: flex; align-items: center; gap: 6px; cursor: pointer; flex-shrink: 0; }
.game-sub-header .real-money-toggle span { font-size: 9px; font-weight: 800; color: #4a7a5d; text-transform: uppercase; white-space: nowrap; }
.game-sub-header .toggle-switch {
  width: 28px; height: 14px; background: #020604;
  border: 1px solid var(--gold); border-radius: 7px;
  position: relative; cursor: pointer; transition: all 0.2s; flex-shrink: 0;
}
.game-sub-header .toggle-switch.on { background: #10b981; border-color: #10b981; }
.game-sub-header .toggle-dot {
  width: 10px; height: 10px; background: var(--gold); border-radius: 50%;
  position: absolute; top: 1px; left: 1px; transition: all 0.2s;
}
.game-sub-header .toggle-switch.on .toggle-dot { left: 15px; background: #fff; }

/* Cabinet Stage */
.cabinet-stage {
  flex: 1; position: relative; overflow: hidden;
  display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 8px;
  min-height: calc(100vh - 102px);
  width: 100%;
  box-sizing: border-box;
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
  position:relative; z-index:5;
  max-width:860px; width:100%;
  margin:0 auto;
  display:flex; flex-direction:column; align-items:center;
  justify-content:center;
}

/* God Fire Glow Animation */
.god-fire-burst {
  filter: drop-shadow(0 0 35px #00d4ff) brightness(1.4);
  animation: godBurstGlow 0.4s infinite alternate;
}
@keyframes godBurstGlow {
  0% { transform: scale(1); filter: drop-shadow(0 0 20px #ffd700); }
  100% { transform: scale(1.04); filter: drop-shadow(0 0 45px #ff4500) brightness(1.6); }
}
.spin-blur {
  filter: blur(4px);
  transition: all 0.1s ease-in-out;
}

/* Game Frame */
.game-frame{
  position:relative;
  width:min(860px, 95vw);
  border-radius:18px;
  padding:8px 12px;
  background:linear-gradient(155deg,#4a2f12,#1c1305 55%,#4a2f12);
  box-shadow:0 12px 30px var(--shadow), inset 0 0 0 2px rgba(255,243,207,.28), inset 0 0 20px rgba(0,0,0,.9);
  z-index: 3;
  margin: 0 auto;
}

.table{ position:relative; width:100%; }

.reel-area-wrap{
  position:relative; width:100%; padding-right:75px;
}

.reel-area{
  position:relative; border-radius:12px; overflow:hidden;
  background:#0d0701;
  box-shadow:inset 0 0 0 3px rgba(202,162,79,.65), inset 0 10px 24px rgba(0,0,0,.9), inset 0 -10px 24px rgba(0,0,0,.9);
  aspect-ratio:5/3.1;
  max-height:clamp(240px, 54vh, 460px);
  width:100%;
}

.temple-bg-art{ position:absolute; inset:0; z-index:0; }
.temple-bg-art svg { width:100%; height:100%; }

/* Multiplier pips */
.mult-row{
  position:absolute; z-index:4;
  top:2%; left:10%; right:10%;
  display:flex; justify-content:space-between;
}
.mult-pill{
  width:16%; text-align:center; padding:2px 0;
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

/* God Clash Battle Header (Top Pool Display) */
.god-clash-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  width: 100%;
  margin-top: 22px;
  margin-bottom: 8px;
  position: relative;
  z-index: 10;
}
.god-pool-card {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 6px 10px;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
  user-select: none;
}
.god-pool-card.poseidon {
  background: linear-gradient(135deg, rgba(8, 36, 60, 0.9) 0%, rgba(3, 14, 25, 0.95) 100%);
  border: 1.5px solid rgba(0, 212, 255, 0.4);
  box-shadow: 0 4px 12px rgba(0,0,0,0.5), inset 0 0 10px rgba(0, 212, 255, 0.1);
}
.god-pool-card.poseidon.active {
  border-color: #00d4ff;
  box-shadow: 0 0 16px rgba(0, 212, 255, 0.5), inset 0 0 14px rgba(0, 212, 255, 0.25);
  background: linear-gradient(135deg, rgba(12, 50, 85, 0.95) 0%, rgba(5, 20, 36, 0.98) 100%);
}
.god-pool-card.anubis {
  background: linear-gradient(135deg, rgba(58, 25, 5, 0.9) 0%, rgba(22, 10, 2, 0.95) 100%);
  border: 1.5px solid rgba(245, 158, 11, 0.4);
  box-shadow: 0 4px 12px rgba(0,0,0,0.5), inset 0 0 10px rgba(245, 158, 11, 0.1);
}
.god-pool-card.anubis.active {
  border-color: #fbbf24;
  box-shadow: 0 0 16px rgba(245, 158, 11, 0.5), inset 0 0 14px rgba(245, 158, 11, 0.25);
  background: linear-gradient(135deg, rgba(78, 35, 8, 0.95) 0%, rgba(30, 14, 3, 0.98) 100%);
}
.god-pool-avatar {
  font-size: 18px;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.6));
}
.god-pool-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-left: 6px;
  flex: 1;
}
.god-pool-title {
  font-size: 10px;
  font-weight: 900;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}
.god-pool-card.poseidon .god-pool-title { color: #38bdf8; }
.god-pool-card.anubis .god-pool-title { color: #fbbf24; }
.god-pool-amount {
  font-size: 12px;
  font-weight: 800;
  color: #fff;
  font-family: 'Roboto Mono', monospace;
  white-space: nowrap;
}
.god-pool-badge {
  font-size: 8px;
  font-weight: 800;
  padding: 2px 6px;
  border-radius: 4px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.god-pool-card.poseidon .god-pool-badge {
  background: rgba(0, 212, 255, 0.15);
  color: #7dd3fc;
  border: 1px solid rgba(0, 212, 255, 0.3);
}
.god-pool-card.poseidon.active .god-pool-badge {
  background: #0284c7;
  color: #fff;
  border-color: #38bdf8;
}
.god-pool-card.anubis .god-pool-badge {
  background: rgba(245, 158, 11, 0.15);
  color: #fde68a;
  border: 1px solid rgba(245, 158, 11, 0.3);
}
.god-pool-card.anubis.active .god-pool-badge {
  background: #d97706;
  color: #fff;
  border-color: #fbbf24;
}

.god-clash-timer-badge {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #08120d;
  border: 1.5px solid var(--gold);
  border-radius: 8px;
  padding: 2px 8px;
  min-width: 44px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.8);
}
.clash-vs {
  font-size: 9px;
  font-weight: 900;
  color: #ffd76a;
  letter-spacing: 1px;
}
.clash-sec {
  font-size: 11px;
  font-weight: 800;
  color: #fff;
  font-family: 'Roboto Mono', monospace;
}

/* Right control panel layout */
.right-controls {
  position: absolute;
  right: 6px;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  z-index: 100;
}

/* Control buttons */
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
  width: 74px;
  height: 74px;
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

/* Buy feature button */
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
  background: rgba(0,0,0,0.85);
  z-index: 150;
  display: none;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
}
.buy-feature-overlay.show { display: flex; }
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
.menu-overlay.show { display: flex; }
.menu-header { display: flex; align-items: center; }
.menu-title {
  font-size: 16px; font-weight: 900; letter-spacing: 1px;
  text-transform: uppercase; color: #ffd76a; flex: 1; text-align: center;
}
.menu-close-btn {
  cursor: pointer; font-size: 18px; color: rgba(255,255,255,0.6);
  background: none; border: none; padding: 4px;
}
.menu-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 10px; margin: 16px 0;
}
.menu-card {
  background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 10px; padding: 12px 6px; text-align: center; cursor: pointer;
  transition: all 0.15s; display: flex; flex-direction: column; align-items: center; gap: 6px;
}
.menu-card:hover { background: rgba(255,255,255,0.12); border-color: #ffd76a; }
.menu-card i { font-size: 20px; color: #ffd76a; }
.menu-card span { font-size: 10px; font-weight: 700; text-transform: uppercase; }
.menu-switches {
  display: flex; justify-content: space-between; background: rgba(0,0,0,0.3);
  padding: 10px; border-radius: 8px;
}
.switch-item {
  display: flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 700;
  color: rgba(255,255,255,0.8); text-transform: uppercase;
}
.switch { position: relative; display: inline-block; width: 32px; height: 18px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider {
  position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
  background-color: #444; transition: .15s; border-radius: 18px;
}
.slider:before {
  position: absolute; content: ""; height: 12px; width: 12px; left: 3px; bottom: 3px;
  background-color: #fff; transition: .15s; border-radius: 50%;
}
input:checked + .slider { background-color: #10b981; }
input:checked + .slider:before { transform: translateX(14px); }

/* Reel Grid */
.reel-grid{
  position:relative; z-index:2;
  display:grid;
  grid-template-columns:repeat(5,1fr);
  grid-template-rows:repeat(3,1fr);
  gap:3px; width:78%; height:80%;
  margin:0 auto; top:10%; padding:4px;
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
.cell img{
  width:100%; height:100%; object-fit:cover;
  border-radius:4px;
  pointer-events: none;
}
.cell.dim{ filter:grayscale(.7) brightness(.35); opacity:.55; }
.cell.win{
  position: relative; z-index: 5;
  border-color: #ffd76a !important;
  animation: win-fire-powerful 0.5s ease-in-out infinite;
}
.cell.win img {
  animation: win-symbol-shake 0.5s ease-in-out infinite;
}
.cell.spinning img{
  filter: blur(2px) scaleY(1.15);
}

@keyframes border-fire-normal {
  0%, 100% {
    box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.15), 0 0 3px #ffd76a, 0 -2px 6px rgba(255, 140, 0, 0.65);
    border-color: #ffd76a;
  }
  50% {
    box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.35), 0 0 5px #fff3cf, 0 -4px 12px rgba(255, 215, 0, 0.85);
    border-color: #fff3cf;
  }
}

@keyframes win-fire-powerful {
  0%, 100% {
    box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.9), 0 0 10px #fff, 0 -6px 25px #ffd76a, 0 -12px 45px #ff8c00;
    border-color: #ffffff;
    transform: scale(1.0);
  }
  50% {
    box-shadow: inset 0 0 25px rgba(255, 255, 255, 1), 0 0 20px #fff, 0 -10px 35px #fff3cf, 0 -20px 60px #ffd76a;
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
  background:linear-gradient(180deg,#10b981,#059669);
  color:#fff; box-shadow:0 3px 8px rgba(0,0,0,.4);
}
.mode-pill.demo {
  background:linear-gradient(180deg,#ff5d7a,#c81d4a);
}

/* Bet row */
.bet-row{
  display:flex; align-items:center; gap:6px; justify-content:center; margin-top:6px;
}
.bet-label {
  font-size: 11px;
  font-weight: 800;
  color: var(--gold-lt);
  text-transform: uppercase;
}
.bet-capsule {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(0,0,0,0.5);
  border: 1px solid rgba(217, 164, 67, 0.4);
  border-radius: 20px;
  padding: 2px 8px;
}
.bet-val {
  font-size: 14px;
  font-weight: 800;
  color: #fff;
  font-family: 'Roboto Mono', monospace;
  min-width: 50px;
  text-align: center;
}
.stepper{
  width:24px; height:24px; border-radius:50%;
  border:1px solid rgba(217,164,67,.5);
  background:radial-gradient(circle at 35% 30%,#caa24f,#7a4e12);
  color:#3a1505; font-size:13px; font-weight:800;
  cursor:pointer; display:flex; align-items:center; justify-content:center;
  transition:transform .1s, background .15s;
}
.stepper:hover{ background:radial-gradient(circle at 35% 30%,#e2bb66,#946018); }
.stepper:active{ transform:scale(.88); }

.balance-bar{
  display:flex; justify-content:space-between; align-items:center;
  margin-top:6px; padding:6px 12px; border-radius:8px;
  background:linear-gradient(180deg,rgba(28,19,5,.85),rgba(13,7,1,.92));
  box-shadow:inset 0 0 0 1px rgba(217,164,67,.3);
  font-size:12px; font-weight:700; color:var(--gold-lt);
}
.balance-bar .chip{ display:flex; align-items:center; gap:6px; font-family:'Roboto Mono', monospace; }

.footer-note{ margin-top:4px; font-size:9px; color:rgba(255,247,223,.45); text-align:center; letter-spacing:.5px; }

/* Toast */
.toast-msg{
  position:fixed; top:85px; left:50%; transform:translateX(-50%);
  background:#08120d; border:2px solid var(--gold);
  border-radius:10px; padding:10px 24px;
  font-family:'Exo 2',sans-serif; font-size:13px; font-weight:700;
  color:#fff; letter-spacing:1px; z-index:99999;
  animation:toastIn 0.3s ease; white-space:nowrap;
  box-shadow:0 4px 20px rgba(0,0,0,.8);
}
.toast-msg.win{ border-color:var(--green); color:var(--green-lt); background:#06160d; }
.toast-msg.lose{ border-color:var(--ember); color:#ffa080; background:#200a05; }
@keyframes toastIn{ from{opacity:0;transform:translateX(-50%) translateY(-10px);}to{opacity:1;transform:translateX(-50%) translateY(0);} }

/* Generic Modal Overlay */
.game-modal-overlay {
  position: fixed; inset: 0;
  background: rgba(0, 0, 0, 0.82);
  backdrop-filter: blur(6px);
  display: none; align-items: center; justify-content: center;
  z-index: 99999; opacity: 0; transition: opacity 0.2s ease-out;
}
.game-modal-overlay.show { display: flex; opacity: 1; }
.game-modal-card {
  background: linear-gradient(180deg, #1c1305 0%, #0d0701 100%);
  border: 2px solid #caa24f;
  border-radius: 14px;
  width: min(480px, 94vw);
  box-shadow: 0 15px 40px rgba(0,0,0,0.95);
  overflow: hidden;
  position: relative;
  font-family: 'Outfit', sans-serif;
  transform: scale(0.94);
  transition: transform 0.2s ease-out;
}
.game-modal-overlay.show .game-modal-card { transform: scale(1); }
.game-modal-header {
  background: #08120d;
  padding: 12px 16px;
  display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid #1a3222;
}
.game-modal-title {
  color: #ffd76a; font-size: 1.1rem; font-weight: 900;
  text-transform: uppercase; letter-spacing: 0.5px;
}
.game-modal-close {
  background: none; border: none; color: #a0957c; font-size: 1.4rem;
  cursor: pointer; line-height: 1; transition: color 0.15s;
}
.game-modal-close:hover { color: #fff; }
.game-modal-body { padding: 16px 20px; display: flex; flex-direction: column; gap: 12px; }

/* 1xBet Deposit Modal Specifics */
.deposit-gateway-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
}
.deposit-gateway-item {
  background: rgba(255,255,255,0.04);
  border: 1.5px solid rgba(217, 164, 67, 0.3);
  border-radius: 8px; padding: 10px 6px;
  text-align: center; cursor: pointer; transition: all 0.15s;
}
.deposit-gateway-item:hover, .deposit-gateway-item.active {
  border-color: #10b981; background: rgba(16, 185, 129, 0.1); transform: scale(1.02);
}
.deposit-gateway-name { font-size: 11px; font-weight: 800; color: #fff; margin-top: 4px; }
.deposit-quick-amounts {
  display: flex; gap: 6px; justify-content: space-between;
}
.quick-amt-btn {
  flex: 1; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
  border-radius: 6px; padding: 6px 0; color: #fff; font-size: 11px; font-weight: 800;
  cursor: pointer; transition: all 0.15s; text-align: center;
}
.quick-amt-btn:hover { background: rgba(217, 164, 67, 0.2); border-color: var(--gold); }
.deposit-submit-btn {
  background: linear-gradient(180deg, #10b981, #059669);
  border: 1px solid #34d399; border-radius: 8px;
  color: #fff; font-size: 14px; font-weight: 900;
  padding: 10px; cursor: pointer; text-align: center; text-transform: uppercase;
  letter-spacing: 1px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

/* Casino Switcher Grid */
.switcher-game-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
}
.switcher-game-card {
  background: rgba(0,0,0,0.4); border: 1px solid rgba(217, 164, 67, 0.3);
  border-radius: 8px; padding: 10px; display: flex; align-items: center; gap: 10px;
  cursor: pointer; transition: all 0.15s; text-decoration: none; color: #fff;
}
.switcher-game-card:hover {
  background: rgba(217, 164, 67, 0.15); border-color: var(--gold-br); transform: translateY(-2px);
}
.switcher-game-icon {
  width: 40px; height: 40px; border-radius: 6px;
  background: #1c1305; border: 1px solid var(--gold);
  display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--gold-br);
}
.switcher-game-info strong { display: block; font-size: 12px; }
.switcher-game-info span { font-size: 10px; color: #4a7a5d; }

/* Paytable Table */
.paytable-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; max-height: 320px; overflow-y: auto;
}
.paytable-row-item {
  display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.3);
  border: 1px solid rgba(255,255,255,0.06); border-radius: 6px; padding: 6px 8px;
}
.paytable-row-item img { width: 34px; height: 34px; border-radius: 4px; object-fit: cover; }
.paytable-row-item span { font-size: 11px; font-weight: 700; color: #ffd76a; }

/* Splash Screen */
#gameSplashScreen {
  position: fixed; inset: 0; background: #090300; z-index: 999999;
  display: flex; align-items: center; justify-content: center; opacity: 1; transition: opacity 0.4s ease-out;
}
.splash-content { display: flex; flex-direction: column; align-items: center; gap: 20px; width: min(500px, 90vw); }
#splashLogo { width: 100%; height: auto; object-fit: contain; }
.progress-container {
  width: 80%; height: 5px; background: rgba(255, 243, 207, 0.08);
  border-radius: 4px; overflow: hidden; border: 1px solid rgba(217, 164, 67, 0.15);
}
.progress-bar {
  width: 0%; height: 100%; background: linear-gradient(90deg, #d9a443, #ffd76a, #d9a443);
  box-shadow: 0 0 10px #ffd76a; border-radius: 4px; transition: width 0.9s cubic-bezier(0.1, 0.8, 0.25, 1);
}

/* ============================================================
   RESPONSIVE DESIGN (Mobile & Tablet)
   ============================================================ */
@media (max-width: 768px) {
  #outerWrapper { flex-direction: column; }
  .game-sidenav {
    width: 100%; height: 38px; flex-direction: row; justify-content: space-around;
    padding: 0; border-right: none; border-bottom: 1px solid #1a3222; order: 2;
  }
  .workspace-container { width: 100%; order: 1; min-height: calc(100vh - 38px); }
  .game-header { padding: 0 8px; height: 32px; }
  .game-header .header-title { display: none; }
  .game-header .search-wrap { display: none; }

  .game-sub-header { height: 32px; padding: 0 8px; gap: 4px; }
  .game-sub-header .game-title { font-size: 10px; }
  .game-sub-header .real-money-toggle span { font-size: 8.5px; }

  .god-clash-header { margin-top: 18px; margin-bottom: 6px; gap: 4px; }
  .god-pool-card { padding: 4px 6px; border-radius: 8px; }
  .god-pool-avatar { font-size: 14px; }
  .god-pool-title { font-size: 8.5px; }
  .god-pool-amount { font-size: 10.5px; }
  .god-pool-badge { font-size: 7px; padding: 1px 4px; }
  .god-clash-timer-badge { min-width: 36px; padding: 1px 4px; border-radius: 6px; }
  .clash-vs { font-size: 8px; }
  .clash-sec { font-size: 9.5px; }

  .cabinet-stage { padding: 4px; min-height: calc(100vh - 104px); }
  .stage { max-width: 100%; width: 100%; }
  .game-frame { width: 100%; max-width: 100%; padding: 4px 6px; border-radius: 12px; }
  .reel-area-wrap { padding-right: 52px; width: 100%; }
  .reel-area { max-height: clamp(190px, 44vh, 360px); aspect-ratio: 5/3.1; }
  .reel-grid { width: 84%; height: 84%; top: 8%; gap: 2px; }
  .right-controls { right: 2px; gap: 4px; }
  .control-btn { width: 32px; height: 32px; border-radius: 8px; }
  .control-btn svg, .control-btn i { font-size: 13px; }
  .control-btn.spin { width: 48px; height: 48px; }
  .control-btn.spin svg { width: 18px; height: 18px; }
  .bet-row { margin-top: 3px; }
  .balance-bar { padding: 4px 8px; font-size: 11px; margin-top: 3px; }
  .bet-selector-pop { right: 44px; width: 100px; }
}

@media (max-width: 480px) {
  .game-sub-header .game-badge { gap: 4px; }
  .god-clash-header { margin-top: 14px; margin-bottom: 4px; gap: 3px; }
  .god-pool-card { padding: 3px 4px; }
  .god-pool-avatar { font-size: 12px; }
  .god-pool-title { font-size: 8px; }
  .god-pool-amount { font-size: 9.5px; }
  .god-pool-badge { display: none; }
  .reel-area-wrap { padding-right: 44px; }
  .right-controls { right: 1px; gap: 3px; }
  .control-btn { width: 28px; height: 28px; border-radius: 6px; }
  .control-btn.spin { width: 42px; height: 42px; }
  .control-btn.spin svg { width: 16px; height: 16px; }
  .stepper { width: 20px; height: 20px; font-size: 11px; }
  .bet-val { font-size: 12px; min-width: 40px; }
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
    <div class="side-link" id="favSideBtn" title="Favorites"><i class="fas fa-heart"></i></div>
    <div class="side-link active" onclick="window.location.href='{{ route('dashboard') }}'" title="Lobby"><i class="fas fa-th-large"></i></div>
    <div class="side-link" id="turboSideBtn" title="Turbo Spin"><i class="fas fa-bolt"></i></div>
    <div class="side-link" id="paytableSideBtn" title="Paytable"><i class="fas fa-trophy"></i></div>
    <div class="side-link" id="switcherSideBtn" title="Casino Games"><i class="fas fa-gamepad"></i></div>
  </aside>

  <div class="workspace-container">
    <!-- Top Header Bar -->
    <header class="game-header">
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Search results</a>
        <i class="fas fa-chevron-right" style="font-size:8px; margin:0 4px;"></i>
        <span>Abyss of Glory</span>
      </div>
      <div class="header-title">TEMPLE OF FORTUNE · ABYSS OF GLORY</div>
      <div class="header-actions">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" class="search-input" value="Temple of Fortune" readonly>
        </div>
        <button class="win-btn" title="Cashier Deposit" onclick="openDepositModal()"><i class="fas fa-wallet" style="color:var(--green-lt);"></i></button>
        <button class="win-btn" onclick="toggleFullScreen()" title="Fullscreen"><i class="fas fa-expand"></i></button>
        <button class="win-btn" onclick="window.location.reload()" title="Reload"><i class="fas fa-rotate"></i></button>
        <button class="win-btn" id="favHeaderBtn" title="Favorite"><i class="far fa-star"></i></button>
        <button class="win-btn" onclick="window.location.href='{{ route('dashboard') }}'" title="Close"><i class="fas fa-xmark"></i></button>
      </div>
    </header>

    <!-- Sub-Header -->
    <div class="game-sub-header">
      <div class="game-badge">
        <span style="font-size:14px; color:#ffd76a;">🏛️</span>
        <span class="game-title">Temple of Fortune</span>
      </div>
      <div class="real-money-toggle" id="realMoneyToggleContainer" title="Toggle Real Money / Demo Mode">
        <span id="modeStatusText">PLAY FOR REAL MONEY</span>
        <div class="toggle-switch on" id="realMoneyToggle">
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
        <div class="game-frame">
          <div class="mode-pill" id="modePill">REAL MONEY MODE</div>

          <!-- God Clash Battle Header (Top Pool Display in Marked Area) -->
          <div class="god-clash-header">
            <div class="god-pool-card poseidon active" id="godCardPoseidon" onclick="selectGodSide('poseidon')">
              <div class="god-pool-avatar">🌊</div>
              <div class="god-pool-info">
                <div class="god-pool-title">POSEIDON</div>
                <div class="god-pool-amount" id="poseidonPoolText">৳ 2,669.00</div>
              </div>
              <div class="god-pool-badge">SELECTED</div>
            </div>

            <div class="god-clash-timer-badge" id="godTimerBadge">
              <span class="clash-vs">VS</span>
              <span class="clash-sec" id="roundTimerSec">15s</span>
            </div>

            <div class="god-pool-card anubis" id="godCardAnubis" onclick="selectGodSide('anubis')">
              <div class="god-pool-avatar">🔥</div>
              <div class="god-pool-info">
                <div class="god-pool-title">ANUBIS</div>
                <div class="god-pool-amount" id="anubisPoolText">৳ 4,871.00</div>
              </div>
              <div class="god-pool-badge">SELECT</div>
            </div>
          </div>

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
                    <svg viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: #ffd76a;">
                      <polygon points="12,3 21,8 3,8"/><rect x="4" y="9" width="2" height="9"/><rect x="8" y="9" width="2" height="9"/><rect x="14" y="9" width="2" height="9"/><rect x="18" y="9" width="2" height="9"/><rect x="3" y="19" width="18" height="2"/>
                    </svg>
                  </div>
                  <div class="buy-card-cost" id="buyCostFreeSpins">40.00</div>
                  <div class="buy-card-currency" id="buyCurrencyFreeSpins">{{ auth()->user()->currency ?? 'BDT' }}</div>
                </div>
                <div class="buy-card god-mode" id="buyCardGodMode">
                  <div class="buy-card-title">God Mode Spins</div>
                  <div style="margin: 8px 0;">
                    <svg viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: #ffd76a;">
                      <circle cx="12" cy="12" r="10" stroke="#fff3cf" stroke-width="1.2" fill="none"/>
                      <path d="M12 6v12M6 12h12" stroke="#ffeb3b" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                  </div>
                  <div class="buy-card-cost" id="buyCostGodMode">120.00</div>
                  <div class="buy-card-currency" id="buyCurrencyGodMode">{{ auth()->user()->currency ?? 'BDT' }}</div>
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
              <div class="menu-card" id="menuCardCashier" onclick="openDepositModal()">
                <i class="fas fa-wallet"></i>
                <span>Deposit</span>
              </div>
              <div class="menu-card" id="menuCardGames" onclick="openSwitcherModal()">
                <i class="fas fa-gamepad"></i>
                <span>Games</span>
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
                    <g opacity="0.45" stroke="#caa24f" stroke-width="1.2" fill="none">
                      <line x1="6" y1="2" x2="6" y2="60"/>
                      <line x1="94" y1="2" x2="94" y2="60"/>
                      <line x1="2" y1="6" x2="98" y2="6"/>
                    </g>
                    <polygon points="50,2 90,10 10,10" fill="#3a2510" opacity="0.55" stroke="#caa24f" stroke-width="0.8"/>
                    <circle cx="50" cy="31" r="28" fill="none" stroke="rgba(202,162,79,0.12)" stroke-width="2"/>
                  </svg>
                </div>

                <!-- Multiplier row -->
                <div class="mult-row" id="multRow"></div>

                <div class="reel-grid" id="reelGrid"></div>
                <div class="win-banner" id="winBanner">0.00</div>
              </div>

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
            </div>
          </div>

          <div class="bet-row">
            <div class="bet-label" id="betLabelContainer">Bet (<span id="userCurrencyLabel">{{ auth()->user()->currency ?? 'BDT' }}</span>)</div>
            <div class="bet-capsule">
              <button class="stepper" id="betMinus">–</button>
              <span class="bet-val" id="betDisplay">0.40</span>
              <button class="stepper" id="betPlus">+</button>
            </div>
          </div>

          <div class="balance-bar">
            <div class="chip" style="pointer-events: auto; cursor: pointer;" id="betDisplayTrigger">
              <i class="fas fa-coins" style="color:var(--gold-br);"></i>
              <span id="betEcho">0.40 {{ auth()->user()->currency ?? 'BDT' }}</span>
            </div>
            <div class="chip">
              <i class="fas fa-wallet" style="color:var(--green-lt);"></i>
              <span id="balanceDisplay">৳ {{ number_format(auth()->user()->balance ?? 0, 2) }}</span>
            </div>
          </div>
        </div>

        <p class="footer-note">1xBet Certified Provably Fair RNG · Multi-Tenant House Engine · 243 Ways to Win</p>
      </main>
    </div>

    <!-- Footer bar -->
    <footer class="game-footer">
      <div style="display:flex; gap:20px; align-items:center;">
        <div class="footer-tab" onclick="openSwitcherModal()"><i class="fas fa-clock" style="margin-right:4px;"></i> Recent Games</div>
        <div class="footer-tab" onclick="openPaytableModal()"><i class="fas fa-star" style="margin-right:4px;"></i> Paytable</div>
      </div>
      <div>
        <i class="fas fa-headset" style="color:#4a7a5d; cursor:pointer; font-size:14px;" title="Customer Support" onclick="window.location.href='{{ route('dashboard') }}'"></i>
      </div>
    </footer>
  </div>
</div>

<!-- 1xBet CASHIER DEPOSIT MODAL (Demo Limit Lock & Quick Deposit) -->
<div class="game-modal-overlay" id="depositModal">
  <div class="game-modal-card">
    <div class="game-modal-header">
      <div class="game-modal-title"><i class="fas fa-shield-alt" style="color:var(--gold); margin-right:6px;"></i> 1xBet Fast Cashier</div>
      <button class="game-modal-close" onclick="closeDepositModal()">&times;</button>
    </div>
    <div class="game-modal-body">
      <div style="background: rgba(217,164,67,0.1); border:1px solid rgba(217,164,67,0.3); border-radius:8px; padding:10px; font-size:12px; color:#ffd76a; text-align:center;">
        <i class="fas fa-coins"></i> <strong>3 Demo Limit Reached!</strong> Deposit real funds to win real cash in your wallet instantly!
      </div>
      
      <div style="font-size:11px; font-weight:800; color:#4a7a5d; text-transform:uppercase;">Select Payment Gateway</div>
      <div class="deposit-gateway-grid">
        <div class="deposit-gateway-item active">
          <i class="fas fa-mobile-alt" style="color:#e2136e; font-size:20px;"></i>
          <div class="deposit-gateway-name">bKash</div>
        </div>
        <div class="deposit-gateway-item">
          <i class="fas fa-bolt" style="color:#f7941d; font-size:20px;"></i>
          <div class="deposit-gateway-name">Nagad</div>
        </div>
        <div class="deposit-gateway-item">
          <i class="fas fa-rocket" style="color:#8c3494; font-size:20px;"></i>
          <div class="deposit-gateway-name">Rocket</div>
        </div>
      </div>

      <div style="font-size:11px; font-weight:800; color:#4a7a5d; text-transform:uppercase;">Quick Amount (BDT)</div>
      <div class="deposit-quick-amounts">
        <button class="quick-amt-btn" onclick="selectQuickDeposit(300)">৳300</button>
        <button class="quick-amt-btn" onclick="selectQuickDeposit(500)">৳500</button>
        <button class="quick-amt-btn" onclick="selectQuickDeposit(1000)">৳1,000</button>
        <button class="quick-amt-btn" onclick="selectQuickDeposit(2500)">৳2,500</button>
      </div>

      <button class="deposit-submit-btn" onclick="window.location.href='{{ route('dashboard') }}'">
        <i class="fas fa-arrow-right"></i> Proceed to Deposit
      </button>
    </div>
  </div>
</div>

<!-- CASINO GAMES SWITCHER MODAL -->
<div class="game-modal-overlay" id="switcherModal">
  <div class="game-modal-card">
    <div class="game-modal-header">
      <div class="game-modal-title"><i class="fas fa-gamepad" style="color:var(--gold); margin-right:6px;"></i> 1xBet Casino Lobby</div>
      <button class="game-modal-close" onclick="closeSwitcherModal()">&times;</button>
    </div>
    <div class="game-modal-body">
      <div class="switcher-game-grid">
        <a href="{{ route('boxing-king') }}" class="switcher-game-card">
          <div class="switcher-game-icon"><i class="fas fa-trophy"></i></div>
          <div class="switcher-game-info">
            <strong>Boxing King™</strong>
            <span>JILI Games · 888x</span>
          </div>
        </a>
        <a href="{{ route('gates-of-olympus') }}" class="switcher-game-card">
          <div class="switcher-game-icon"><i class="fas fa-bolt"></i></div>
          <div class="switcher-game-info">
            <strong>Gates of Olympus</strong>
            <span>Pragmatic · 5000x</span>
          </div>
        </a>
        <a href="{{ route('western') }}" class="switcher-game-card">
          <div class="switcher-game-icon"><i class="fas fa-hat-cowboy"></i></div>
          <div class="switcher-game-info">
            <strong>Western Vault</strong>
            <span>1xGames · Multiplier</span>
          </div>
        </a>
        <a href="{{ route('fortune-gems-2') }}" class="switcher-game-card">
          <div class="switcher-game-icon"><i class="fas fa-gem"></i></div>
          <div class="switcher-game-info">
            <strong>Fortune Gems 2</strong>
            <span>JILI Games · Hot Pick</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- PAYTABLE MODAL -->
<div class="game-modal-overlay" id="paytableModal">
  <div class="game-modal-card">
    <div class="game-modal-header">
      <div class="game-modal-title"><i class="fas fa-trophy" style="color:var(--gold); margin-right:6px;"></i> Symbol Multipliers</div>
      <button class="game-modal-close" onclick="closePaytableModal()">&times;</button>
    </div>
    <div class="game-modal-body">
      <div class="paytable-grid" id="modalPaytableGrid"></div>
    </div>
  </div>
</div>

<script>
// --- AUDIO OBJECTS (Server audio + Web Audio Synthesizer Fallback) ---
const audioBg = new Audio();
const audioSpin = new Audio();
const audioWin = new Audio();

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
    osc.connect(gain); gain.connect(ctx.destination);
    osc.start(); osc.stop(ctx.currentTime + 0.05);
  } catch(e) {}
}

function playSpinSound() {
  if (audioSpin.src) {
    audioSpin.currentTime = 0;
    audioSpin.play().catch(()=>{});
    return;
  }
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
    osc.connect(gain); gain.connect(ctx.destination);
    osc.start(); osc.stop(ctx.currentTime + 0.3);
  } catch(e) {}
}

function playWinSound() {
  if (audioWin.src) {
    audioWin.currentTime = 0;
    audioWin.play().catch(()=>{});
    return;
  }
  const sw = document.getElementById('soundSwitch');
  if (sw && !sw.checked) return;
  try {
    const ctx = getAudioContext();
    const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50];
    const now = ctx.currentTime;
    notes.forEach((freq, idx) => {
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.type = 'sine'; osc.frequency.value = freq;
      const time = now + idx * 0.11;
      gain.gain.setValueAtTime(0, now);
      gain.gain.setValueAtTime(0.15, time);
      gain.gain.exponentialRampToValueAtTime(0.005, time + 0.22);
      osc.connect(gain); gain.connect(ctx.destination);
      osc.start(time); osc.stop(time + 0.22);
    });
  } catch(e) {}
}

// --- CURRENCY & USER STATE ---
const userCurrency = "{{ auth()->user()->currency ?? 'BDT' }}";
const currencySymbolMap = { 'BDT':'৳', 'EUR':'€', 'USD':'$', 'GBP':'£', 'INR':'₹' };
const currencySymbol = currencySymbolMap[userCurrency] || (userCurrency + ' ');

let realBalance = parseFloat("{{ auth()->user()->balance ?? 0 }}");
let isDemoMode = false;
let demoSpinsDone = 0;
let demoBalance = 10000.00;

function showToast(message, type=''){
  const old = document.querySelector('.toast-msg');
  if(old) old.remove();
  const t = document.createElement('div');
  t.className = `toast-msg ${type}`;
  t.textContent = message;
  document.body.appendChild(t);
  setTimeout(()=>{ t.style.opacity='0'; t.style.transition='opacity .4s'; setTimeout(()=>t.remove(),400); }, 2400);
}

function toggleFullScreen(){
  if(!document.fullscreenElement) document.documentElement.requestFullscreen().catch(()=>{});
  else document.exitFullscreen();
}

// Modal Helpers
function openDepositModal() { document.getElementById('depositModal').classList.add('show'); }
function closeDepositModal() { document.getElementById('depositModal').classList.remove('show'); }
function openSwitcherModal() { document.getElementById('switcherModal').classList.add('show'); }
function closeSwitcherModal() { document.getElementById('switcherModal').classList.remove('show'); }
function openPaytableModal() { document.getElementById('paytableModal').classList.add('show'); }
function closePaytableModal() { document.getElementById('paytableModal').classList.remove('show'); }
function selectQuickDeposit(amt) { showToast(`Selected ৳${amt}. Redirecting to Cashier...`, 'win'); window.location.href = "{{ route('dashboard') }}"; }

window.openDepositModal = openDepositModal;
window.closeDepositModal = closeDepositModal;
window.openSwitcherModal = openSwitcherModal;
window.closeSwitcherModal = closeSwitcherModal;
window.openPaytableModal = openPaytableModal;
window.closePaytableModal = closePaytableModal;
window.selectQuickDeposit = selectQuickDeposit;

// --- SYMBOLS DEFINITIONS ---
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

/* ---- BACKGROUND CANVAS FX ---- */
class MoneyBackdrop{
  constructor(canvas){
    this.canvas=canvas; this.ctx=canvas.getContext('2d');
    this.dpr=Math.min(window.devicePixelRatio||1,2);
    this.items=[]; this._resize();
    window.addEventListener('resize',()=>this._resize());
    const count=window.innerWidth<640?14:24;
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
    } else {
      ctx.font=`bold ${p.size}px Georgia,serif`; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillStyle='#ffd76a'; ctx.fillText('৳',0,0);
    }
    ctx.restore();
  }
  _roundRect(ctx,x,y,w,h,r){
    ctx.beginPath();
    ctx.moveTo(x+r,y); ctx.arcTo(x+w,y,x+w,y+h,r); ctx.arcTo(x+w,y+h,x,y+h,r);
    ctx.arcTo(x,y+h,x,y,r); ctx.arcTo(x,y,x+w,y,r); ctx.closePath();
  }
}

// --- MAIN CONTROLLER ENGINE ---
const BET_STEPS=[0.40,1.00,2.00,5.00,10.00,25.00,50.00,100.00,500.00];
const state={ bet:0.40, turbo:false, auto:false, spinning:false, freeSpinsLeft:0, freeSpinMult:1, isGodMode:false };
window.state = state;

(()=>{
  const $=sel=>document.querySelector(sel);
  const els={
    bgFxCanvas: $('#bgFxCanvas'), reelGrid:$('#reelGrid'),
    winBanner:$('#winBanner'), spinBtn:$('#spinBtn'),
    betMinus:$('#betMinus'), betPlus:$('#betPlus'),
    betDisplay:$('#betDisplay'), betEcho:$('#betEcho'),
    balanceDisplay:$('#balanceDisplay'),
    autoBtn:$('#autoBtn'), bonusBtn:$('#bonusBtn'),
    menuBtn:$('#menuBtn'), multRow:$('#multRow'),
    modePill:$('#modePill'),
  };

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

  function paintCell(div,symId){ div.innerHTML=SYM_BY_ID[symId]?SYM_BY_ID[symId].render():SYMS[0].render(); }

  // Populate Paytable Modal
  const modalGrid = document.getElementById('modalPaytableGrid');
  if (modalGrid) {
    modalGrid.innerHTML = SYMS.map(s=>`
      <div class="paytable-row-item">
        ${s.render()}
        <div>
          <div style="font-size:11px; font-weight:800; color:#fff;">${s.id}</div>
          <span>${s.isScatter?'Scatter (Free Spins)':s.isWild?'Wild (Replaces Any)':(s.pay[3].toFixed(1)+' / '+s.pay[4].toFixed(1)+' / '+s.pay[5].toFixed(1)+'x')}</span>
        </div>
      </div>`).join('');
  }

  let currentGrid=spinGrid();
  for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) paintCell(cells[r][c],currentGrid[c][r]);

  function updateMoney(){
    if (isDemoMode) {
      els.balanceDisplay.textContent = 'DEMO ' + currencySymbol + demoBalance.toFixed(2);
      els.betEcho.textContent = 'DEMO ' + state.bet.toFixed(2) + ' ' + userCurrency;
      els.modePill.textContent = 'DEMO MODE (' + (3 - demoSpinsDone) + ' SPINS LEFT)';
      els.modePill.classList.add('demo');
    } else {
      els.balanceDisplay.textContent = currencySymbol + realBalance.toFixed(2);
      els.betEcho.textContent = state.bet.toFixed(2) + ' ' + userCurrency;
      els.modePill.textContent = 'REAL MONEY MODE';
      els.modePill.classList.remove('demo');
    }
  }
  window.updateMoney = updateMoney;
  updateMoney();

  // Mode Toggle Switch
  document.getElementById('realMoneyToggleContainer').addEventListener('click', () => {
    isDemoMode = !isDemoMode;
    const toggle = document.getElementById('realMoneyToggle');
    const label = document.getElementById('modeStatusText');
    if (isDemoMode) {
      toggle.classList.remove('on');
      label.textContent = 'PLAY IN DEMO MODE';
      showToast('Switched to Demo Mode (3 Spins Limit)', 'lose');
    } else {
      toggle.classList.add('on');
      label.textContent = 'PLAY FOR REAL MONEY';
      showToast('Switched to Real Money Mode', 'win');
    }
    updateMoney();
  });

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
    const dur=(state.turbo?200:450)+c*(state.turbo?40:100);
    const flickerMs=state.turbo?25:40;
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
  }

  function clearCellStates(){ for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) cells[r][c].classList.remove('dim','win'); }
  function showWinBanner(text){ els.winBanner.textContent=text; els.winBanner.classList.add('show'); }
  function hideWinBanner(){ els.winBanner.classList.remove('show'); }

  // Selected God Battle Side
  let selectedSide = 'poseidon';
  window.selectGodSide = function(side) {
    if (state.spinning) return;
    playButtonSound();
    selectedSide = side;
    const pCard = document.getElementById('godCardPoseidon');
    const aCard = document.getElementById('godCardAnubis');
    if (pCard && aCard) {
      if (side === 'poseidon') {
        pCard.classList.add('active');
        aCard.classList.remove('active');
        pCard.querySelector('.god-pool-badge').textContent = 'SELECTED';
        aCard.querySelector('.god-pool-badge').textContent = 'SELECT';
      } else {
        aCard.classList.add('active');
        pCard.classList.remove('active');
        aCard.querySelector('.god-pool-badge').textContent = 'SELECTED';
        pCard.querySelector('.god-pool-badge').textContent = 'SELECT';
      }
    }
  };

  // Live Sync Game State for Pools & Timer
  async function syncGameState() {
    try {
      const response = await fetch("{{ route('abyss.state') }}");
      if (!response.ok) return;
      const data = await response.json();
      if (data) {
        if (data.total_poseidon !== undefined) {
          const pEl = document.getElementById('poseidonPoolText');
          if (pEl) pEl.textContent = currencySymbol + ' ' + parseFloat(data.total_poseidon).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        if (data.total_anubis !== undefined) {
          const aEl = document.getElementById('anubisPoolText');
          if (aEl) aEl.textContent = currencySymbol + ' ' + parseFloat(data.total_anubis).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        if (data.time_left !== undefined) {
          const tEl = document.getElementById('roundTimerSec');
          if (tEl) tEl.textContent = Math.max(0, Math.floor(data.time_left)) + 's';
        }
        if (!isDemoMode && data.user_balance !== null && data.user_balance !== undefined && !state.spinning) {
          realBalance = parseFloat(data.user_balance);
          updateMoney();
        }
      }
    } catch(err) {}
  }

  setInterval(syncGameState, 3000);
  syncGameState();

  // Place bet AJAX and spin execution
  async function doSpin(){
    if(state.spinning) return;

    if (isDemoMode) {
      if (demoSpinsDone >= 3) {
        openDepositModal();
        return;
      }
    } else {
      if (realBalance < state.bet) {
        showToast('Insufficient Balance! Deposit to play.', 'lose');
        openDepositModal();
        return;
      }
    }

    state.spinning=true; els.spinBtn.disabled=true;
    hideWinBanner(); clearCellStates();
    playSpinSound();

    try {
      const response = await fetch("{{ route('abyss.bet') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          "Accept": "application/json"
        },
        body: JSON.stringify({
          side: selectedSide,
          amount: state.bet,
          is_demo: isDemoMode,
          demo_spins_done: demoSpinsDone
        })
      });

      const resData = await response.json();

      if (resData.deposit_required) {
        openDepositModal();
        state.spinning=false; els.spinBtn.disabled=false;
        return;
      }

      if (resData.error) {
        showToast(resData.error, 'lose');
        state.spinning=false; els.spinBtn.disabled=false;
        return;
      }

      if (isDemoMode) {
        demoSpinsDone++;
        demoBalance -= state.bet;
      } else if (resData.new_balance !== null && resData.new_balance !== undefined) {
        realBalance = parseFloat(resData.new_balance);
      }
      updateMoney();

      // Trigger pool refresh
      syncGameState();

      // Spin Reels Animation
      const grid = spinGrid();
      await Promise.all([0,1,2,3,4].map(c=>spinReel(c,grid[c])));

      const wins = evaluateWays(grid);
      if(wins.length){
        const totalMult = wins.reduce((s,w)=>s+w.mult*w.ways,0);
        const winAmount = totalMult * state.bet;
        if(isDemoMode) demoBalance += winAmount; else realBalance += winAmount;
        updateMoney();

        for(let r=0;r<ROWS;r++) for(let c=0;c<REELS;c++) cells[r][c].classList.add('dim');
        wins.forEach(w=>w.cells.forEach(([c,r])=>{ cells[r][c].classList.remove('dim'); cells[r][c].classList.add('win'); }));
        showWinBanner('Win ' + currencySymbol + winAmount.toFixed(2));
        playWinSound();

        await sleep(state.turbo?500:1100);
        clearCellStates();
      }

      // Check if demo spins exhausted after spin
      if (isDemoMode && demoSpinsDone >= 3) {
        await sleep(600);
        openDepositModal();
      }

    } catch(err) {
      console.error(err);
    } finally {
      state.spinning=false; els.spinBtn.disabled=false;
      if(state.auto) doSpin();
    }
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
      showToast('Insufficient balance for Feature Buy!', 'lose');
      openDepositModal();
      return;
    }
    playButtonSound();
    if (isDemoMode) demoBalance -= cost; else realBalance -= cost;
    state.freeSpinsLeft = 8;
    state.freeSpinMult = 1;
    state.isGodMode = false;
    updateMoney();
    toggleBuyFeature(true);
    setPips(1, true);
    showWinBanner('🏛️ FREE SPINS PURCHASED!');
    await sleep(1000);
    hideWinBanner();
    doSpin();
  });

  document.getElementById('buyCardGodMode').addEventListener('click', async () => {
    if (state.spinning || state.freeSpinsLeft > 0) return;
    const cost = state.bet * 300;
    const bal = isDemoMode ? demoBalance : realBalance;
    if (bal < cost) {
      showToast('Insufficient balance for God Mode!', 'lose');
      openDepositModal();
      return;
    }
    playButtonSound();
    if (isDemoMode) demoBalance -= cost; else realBalance -= cost;
    state.freeSpinsLeft = 8;
    state.freeSpinMult = 5;
    state.isGodMode = true;
    updateMoney();
    toggleBuyFeature(true);
    setPips(5, true);
    showWinBanner('⚡ GOD MODE ACTIVATED!');
    await sleep(1000);
    hideWinBanner();
    doSpin();
  });

  // --- MENU OVERLAY ---
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

  document.getElementById('menuCardPaytable').addEventListener('click', () => {
    playButtonSound();
    menuOverlay.classList.remove('show');
    openPaytableModal();
  });

  // Sidenav Buttons wiring
  const favSideBtn = document.getElementById('favSideBtn');
  const favHeaderBtn = document.getElementById('favHeaderBtn');
  let isFav = localStorage.getItem('fav_abyss') === '1';
  function updateFavUI() {
    if (favSideBtn) favSideBtn.classList.toggle('fav-active', isFav);
    if (favHeaderBtn) {
      favHeaderBtn.innerHTML = isFav ? '<i class="fas fa-star" style="color:var(--gold);"></i>' : '<i class="far fa-star"></i>';
    }
  }
  updateFavUI();

  function toggleFav() {
    isFav = !isFav;
    localStorage.setItem('fav_abyss', isFav ? '1' : '0');
    updateFavUI();
    showToast(isFav ? 'Added to Favorites ★' : 'Removed from Favorites', 'win');
  }
  if (favSideBtn) favSideBtn.addEventListener('click', toggleFav);
  if (favHeaderBtn) favHeaderBtn.addEventListener('click', toggleFav);

  const turboSideBtn = document.getElementById('turboSideBtn');
  if (turboSideBtn) {
    turboSideBtn.addEventListener('click', () => {
      state.turbo = !state.turbo;
      turboSideBtn.classList.toggle('turbo-active', state.turbo);
      document.getElementById('fastPlaySwitch').checked = state.turbo;
      showToast(state.turbo ? '⚡ Turbo Spin Enabled' : 'Turbo Spin Disabled', 'win');
    });
  }

  const paytableSideBtn = document.getElementById('paytableSideBtn');
  if (paytableSideBtn) paytableSideBtn.addEventListener('click', openPaytableModal);

  const switcherSideBtn = document.getElementById('switcherSideBtn');
  if (switcherSideBtn) switcherSideBtn.addEventListener('click', openSwitcherModal);

  // Settings switches
  document.getElementById('fastPlaySwitch').addEventListener('change', function() {
    state.turbo = this.checked;
    if (turboSideBtn) turboSideBtn.classList.toggle('turbo-active', state.turbo);
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

  // Background Video Setup
  const bgVid = document.getElementById('bgVideo');
  if (bgVid) {
    bgVid.muted = true;
    bgVid.play().catch(() => {});
    bgVid.addEventListener('pause', () => bgVid.play().catch(() => {}));
    bgVid.addEventListener('ended', () => bgVid.play().catch(() => {}));
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
      setTimeout(() => { splash.style.display = 'none'; }, 400);
    }
  }, 950);
})();
</script>
</body>
</html>
