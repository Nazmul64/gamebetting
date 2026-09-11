<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Western Vault™ — 1xBet Casino</title>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Exo+2:wght@400;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700;800&display=swap" rel="stylesheet">
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ============================================================
   WESTERN VAULT — AUTHENTIC 1XBET CASINO THEME & DESIGN SYSTEM
   ============================================================ */
:root {
  --bg-deep: #030805;
  --bg-cabinet: rgba(12, 22, 16, 0.94);
  --bg-cell: linear-gradient(165deg, rgba(38, 26, 12, 0.88), rgba(15, 9, 3, 0.95));
  --gold: #d9a443;
  --gold-bright: #ffd76a;
  --gold-glow: rgba(255, 215, 106, 0.45);
  --gold-dark: #8a5e1f;
  --green: #10b981;
  --green-glow: rgba(16, 185, 129, 0.4);
  --red: #ef4444;
  --blue: #3b82f6;
  --border-gold: rgba(217, 164, 67, 0.4);
  --border-glow: 0 0 16px rgba(217, 164, 67, 0.35);
  --radius-sm: 6px;
  --radius-md: 10px;
  --radius-lg: 16px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
  width: 100%;
  height: 100vh;
  margin: 0;
  padding: 0;
  background: var(--bg-deep);
  font-family: 'Outfit', -apple-system, sans-serif;
  color: #fff7df;
  overflow: hidden;
  -webkit-font-smoothing: antialiased;
}

/* HD Image Optimization */
img {
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
}

/* ==================== ROOT LAYOUT ==================== */
#outerWrapper {
  display: flex;
  width: 100vw;
  height: 100vh;
  background: #040906;
  position: relative;
  overflow: hidden;
}

/* ==================== LEFT SIDENAV ==================== */
.game-sidenav {
  width: 54px;
  background: #070f0a;
  border-right: 1px solid #14281b;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 14px 0;
  gap: 14px;
  z-index: 20;
  flex-shrink: 0;
}

.game-sidenav .side-brand {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #f97316, #d9a443);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 17px;
  font-weight: 900;
  box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
  margin-bottom: 8px;
  text-decoration: none;
}

.game-sidenav .side-link {
  color: #4a7a5d;
  font-size: 17px;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
  position: relative;
}

.game-sidenav .side-link:hover, .game-sidenav .side-link.active {
  background: rgba(217, 164, 67, 0.15);
  color: var(--gold-bright);
  transform: scale(1.08);
}

.game-sidenav .side-link::after {
  content: attr(data-tooltip);
  position: absolute;
  left: 56px;
  background: #0a160f;
  color: #fff;
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s;
  border: 1px solid #1a3222;
  box-shadow: 0 4px 12px rgba(0,0,0,0.6);
  z-index: 99;
}
.game-sidenav .side-link:hover::after { opacity: 1; }

.side-divider {
  width: 26px;
  height: 1px;
  background: #14281b;
  margin: 4px 0;
}

/* ==================== WORKSPACE & STAGE ==================== */
.workspace-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 100vh;
  position: relative;
  overflow: hidden;
  min-width: 0;
}

/* Top Header */
.game-header {
  height: 38px;
  background: #08120d;
  border-bottom: 1px solid #14281b;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  z-index: 15;
  flex-shrink: 0;
}

.game-header .breadcrumb {
  font-size: 11px;
  font-weight: 700;
  color: #528566;
  display: flex;
  align-items: center;
  gap: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.game-header .breadcrumb a { color: #528566; text-decoration: none; transition: color 0.15s; }
.game-header .breadcrumb a:hover { color: #fff; }
.game-header .breadcrumb span { color: var(--gold-bright); font-weight: 800; }

.game-header .header-title {
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 14px;
  letter-spacing: 2px;
  background: linear-gradient(180deg, #fff3cf 0%, var(--gold-bright) 50%, #8a5e1f 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
}

.game-header .header-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.header-btn {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid #1a3222;
  color: #78a88c;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: all 0.15s;
}
.header-btn:hover { color: #fff; background: rgba(255,255,255,0.08); border-color: var(--gold); }

/* Sub-Header / Game Mode Switcher & Direct Cashier */
.game-sub-header {
  height: 40px;
  background: #050d09;
  border-bottom: 1px solid #14281b;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  z-index: 15;
  flex-shrink: 0;
}

.game-sub-header .game-badge {
  display: flex;
  align-items: center;
  gap: 8px;
}
.game-sub-header .game-badge i { color: var(--gold-bright); font-size: 15px; }
.game-sub-header .game-title {
  font-size: 12px;
  font-weight: 800;
  color: #fff;
  letter-spacing: 0.5px;
}
.provider-badge {
  font-size: 9.5px;
  font-weight: 800;
  background: rgba(217, 164, 67, 0.15);
  color: var(--gold-bright);
  padding: 2px 7px;
  border-radius: 4px;
  border: 1px solid rgba(217, 164, 67, 0.3);
  letter-spacing: 0.6px;
}

/* REAL / DEMO MODE TOGGLE */
.mode-toggle-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(8, 18, 12, 0.8);
  padding: 3px 10px;
  border-radius: 20px;
  border: 1px solid #1a3222;
}
.mode-label {
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  transition: color 0.2s;
}
.mode-label.active { color: var(--gold-bright); }
.mode-label.inactive { color: #4a7a5d; }

.toggle-pill {
  width: 36px;
  height: 18px;
  background: #0f2216;
  border: 1.5px solid var(--gold);
  border-radius: 20px;
  position: relative;
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.toggle-pill .pill-dot {
  width: 12px;
  height: 12px;
  background: var(--gold-bright);
  border-radius: 50%;
  position: absolute;
  top: 1.5px;
  left: 2px;
  transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), background 0.25s;
  box-shadow: 0 1px 4px rgba(0,0,0,0.6);
}
.toggle-pill.real-mode { background: #10b981; border-color: #34d399; }
.toggle-pill.real-mode .pill-dot { transform: translateX(18px); background: #fff; }

/* Glowing Header Deposit Button */
.btn-header-deposit {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: #fff;
  border: 1px solid #34d399;
  border-radius: 20px;
  padding: 4px 14px;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 0.6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 0 14px rgba(16, 185, 129, 0.4);
  transition: all 0.2s;
}
.btn-header-deposit:hover { filter: brightness(1.15); transform: scale(1.04); }

/* ==================== MAIN GAME STAGE ==================== */
.cabinet-stage {
  flex: 1;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 10px 16px;
  background: url('/assets/image/WesternHeist/bg.png') center center / cover no-repeat;
}

.cabinet-stage::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at center, rgba(3, 8, 5, 0.55) 0%, rgba(3, 8, 5, 0.88) 80%, #030805 100%);
  pointer-events: none;
  z-index: 1;
}

#bgFxCanvas {
  position: absolute;
  inset: 0;
  z-index: 1;
  pointer-events: none;
}

/* ==================== CASINO SLOT CABINET FRAME ==================== */
.slot-cabinet-wrap {
  position: relative;
  z-index: 5;
  width: 100%;
  max-width: 1020px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Cabinet Header Ribbon */
.cabinet-ribbon {
  text-align: center;
  margin-bottom: 8px;
  position: relative;
}
.cabinet-title {
  font-family: 'Cinzel', serif;
  font-size: clamp(20px, 3vw, 28px);
  font-weight: 900;
  letter-spacing: 3px;
  background: linear-gradient(180deg, #ffffff 0%, var(--gold-bright) 45%, #b47820 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.9));
  line-height: 1.1;
}
.cabinet-subtitle {
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 4px;
  color: var(--gold);
  text-transform: uppercase;
  margin-top: 2px;
}

/* Main Cabinet Box */
.cabinet-frame {
  position: relative;
  width: 100%;
  background: linear-gradient(155deg, rgba(22, 12, 5, 0.94), rgba(10, 5, 2, 0.98) 50%, rgba(22, 12, 5, 0.94));
  border: 3px solid #d9a443;
  border-radius: 18px;
  padding: 12px 14px;
  box-shadow: 
    0 16px 40px rgba(0, 0, 0, 0.85),
    0 0 0 2px rgba(80, 45, 10, 0.8) inset,
    0 0 30px rgba(217, 164, 67, 0.25);
  backdrop-filter: blur(12px);
}

/* 5x3 Reels Grid Area */
.reels-stage-wrap {
  position: relative;
  width: 100%;
  border-radius: 12px;
  overflow: hidden;
  background: #080401;
  border: 2px solid rgba(217, 164, 67, 0.5);
  box-shadow: 
    inset 0 0 25px rgba(0,0,0,0.95),
    inset 0 12px 20px rgba(0,0,0,0.8),
    inset 0 -12px 20px rgba(0,0,0,0.8);
  height: clamp(300px, 50vh, 460px);
}

.reels-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: repeat(3, 1fr);
  gap: 6px;
  width: 100%;
  height: 100%;
  padding: 8px;
  position: relative;
  z-index: 2;
}

/* Individual Symbol Cell */
.reel-cell {
  position: relative;
  border-radius: 8px;
  background: linear-gradient(165deg, rgba(38, 22, 8, 0.85), rgba(16, 8, 2, 0.95));
  border: 1.5px solid rgba(217, 164, 67, 0.35);
  box-shadow: inset 0 1px 4px rgba(255, 215, 106, 0.15), 0 3px 8px rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.reel-cell img {
  width: 80%;
  height: 80%;
  object-fit: contain;
  filter: drop-shadow(0 4px 8px rgba(0,0,0,0.7));
  transition: transform 0.2s ease, filter 0.2s ease;
  user-select: none;
  pointer-events: none;
}

/* Authentic Mechanical Reel Spin Animation */
.reel-cell.spinning {
  overflow: hidden;
}
.reel-cell.spinning img {
  filter: blur(4px) brightness(1.25);
  transform: translateY(-8px) scale(0.92);
  animation: reelTumble 0.12s infinite linear;
}

@keyframes reelTumble {
  0% { transform: translateY(-100%); opacity: 0.7; }
  50% { transform: translateY(0%); opacity: 1; }
  100% { transform: translateY(100%); opacity: 0.7; }
}

.reel-cell.dim img {
  filter: grayscale(0.85) brightness(0.25) opacity(0.35);
}

.reel-cell.win {
  background: linear-gradient(165deg, rgba(90, 55, 12, 0.9), rgba(40, 20, 3, 0.98));
  border: 2px solid var(--gold-bright);
  box-shadow: 
    0 0 24px rgba(255, 215, 106, 0.85),
    inset 0 0 14px rgba(255, 215, 106, 0.6);
  z-index: 5;
  animation: winCellPulse 0.8s infinite alternate;
}

.reel-cell.win img {
  filter: drop-shadow(0 0 12px rgba(255, 215, 106, 0.95)) brightness(1.25);
  transform: scale(1.14);
}

@keyframes winCellPulse {
  from { transform: scale(0.98); }
  to { transform: scale(1.04); }
}

/* Floating Corner Tool Buttons inside Reels Stage */
.stage-btn {
  position: absolute;
  z-index: 10;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  border: 1.5px solid var(--gold);
  background: radial-gradient(circle at 35% 30%, #4a2e0a, #1a0e03);
  color: var(--gold-bright);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.7);
  transition: all 0.15s;
}
.stage-btn:hover { filter: brightness(1.3); transform: scale(1.1); }
.stage-btn:active { transform: scale(0.92); }
.stage-btn.active { border-color: #34d399; color: #34d399; background: #062414; }
.stage-btn.top-left { top: 8px; left: 8px; }
.stage-btn.top-right { top: 8px; right: 8px; }
.stage-btn.bottom-left { bottom: 8px; left: 8px; }
.stage-btn.bottom-right { bottom: 8px; right: 8px; }

/* Win Announcement Banner */
.win-banner-toast {
  position: absolute;
  left: 50%;
  bottom: 15px;
  transform: translate(-50%, 20px);
  z-index: 25;
  background: linear-gradient(180deg, rgba(30, 16, 5, 0.98), rgba(12, 6, 2, 0.99));
  border: 2px solid var(--gold-bright);
  border-radius: 30px;
  padding: 8px 30px;
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 20px;
  color: #fff;
  box-shadow: 0 10px 30px rgba(0,0,0,0.9), 0 0 25px rgba(255, 215, 106, 0.6);
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  display: flex;
  align-items: center;
  gap: 10px;
}
.win-banner-toast.show {
  opacity: 1;
  transform: translate(-50%, 0);
}
.win-banner-toast i { color: var(--gold-bright); font-size: 18px; }

/* ==================== CABINET BOTTOM CONTROL BAR ==================== */
.cabinet-controls-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 10px;
  gap: 12px;
  flex-wrap: wrap;
}

/* Balance & Bet Chips Group */
.stats-chips-group {
  display: flex;
  align-items: center;
  gap: 8px;
}

.hud-chip {
  display: flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(180deg, rgba(18, 34, 24, 0.9), rgba(8, 16, 11, 0.95));
  border: 1px solid rgba(217, 164, 67, 0.35);
  border-radius: 20px;
  padding: 6px 14px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.6);
}
.hud-chip label {
  font-size: 9.5px;
  font-weight: 800;
  color: #78a88c;
  text-transform: uppercase;
  letter-spacing: 0.8px;
}
.hud-chip .chip-val {
  font-family: 'JetBrains Mono', monospace;
  font-size: 13.5px;
  font-weight: 800;
  color: var(--gold-bright);
}

/* Bet Adjuster Stepper */
.bet-stepper-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
  background: linear-gradient(180deg, rgba(25, 15, 5, 0.95), rgba(12, 6, 2, 0.98));
  border: 1.5px solid rgba(217, 164, 67, 0.4);
  border-radius: 24px;
  padding: 4px 8px;
}
.step-btn {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  border: 1px solid var(--gold);
  background: radial-gradient(circle at 35% 30%, #caa24f, #7a4e12);
  color: #fff;
  font-size: 14px;
  font-weight: 900;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.15s;
}
.step-btn:hover { filter: brightness(1.25); transform: scale(1.08); }
.step-btn:active { transform: scale(0.92); }

.bet-display-box {
  min-width: 65px;
  text-align: center;
  font-family: 'JetBrains Mono', monospace;
  font-size: 14px;
  font-weight: 800;
  color: #fff;
}

/* Quick Bet Preset Chips */
.quick-bets-bar {
  display: flex;
  align-items: center;
  gap: 5px;
}
.quick-chip {
  padding: 4px 9px;
  border-radius: 12px;
  background: rgba(217, 164, 67, 0.12);
  border: 1px solid rgba(217, 164, 67, 0.3);
  color: var(--gold-bright);
  font-size: 11px;
  font-weight: 800;
  font-family: 'JetBrains Mono', monospace;
  cursor: pointer;
  transition: all 0.15s;
}
.quick-chip:hover, .quick-chip.selected {
  background: var(--gold);
  color: #080401;
  border-color: #fff;
  transform: translateY(-1px);
}

/* Big Gold Spin Button */
.spin-action-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
}

.big-spin-btn {
  width: 76px;
  height: 76px;
  border-radius: 50%;
  border: 4px solid #fff3cf;
  background: radial-gradient(circle at 36% 28%, #ffea75 0%, #e6a836 40%, #996215 75%, #4a2c04 100%);
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 
    0 8px 24px rgba(0, 0, 0, 0.8),
    0 0 20px rgba(230, 168, 54, 0.5),
    inset 0 2px 6px rgba(255, 255, 255, 0.5);
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  outline: none;
  flex-shrink: 0;
}
.big-spin-btn i { font-size: 26px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); transition: transform 0.2s; }
.big-spin-btn span { font-size: 9px; font-weight: 900; letter-spacing: 0.8px; margin-top: 1px; font-family: 'Exo 2', sans-serif; }
.big-spin-btn:hover {
  filter: brightness(1.18);
  transform: scale(1.05);
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.9), 0 0 28px rgba(255, 215, 106, 0.7);
}
.big-spin-btn:active { transform: scale(0.95); filter: brightness(0.9); }
.big-spin-btn:disabled {
  opacity: 0.55;
  cursor: not-allowed;
  filter: grayscale(0.6);
  transform: none;
}
.big-spin-btn.spinning i {
  animation: spinWheel 0.6s linear infinite;
}
@keyframes spinWheel { 100% { transform: rotate(360deg); } }

/* Autospin & Turbo Buttons */
.aux-btn {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 1.5px solid var(--gold);
  background: radial-gradient(circle at 35% 30%, #3a2208, #160c02);
  color: var(--gold-bright);
  font-size: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.15s;
}
.aux-btn:hover { filter: brightness(1.25); transform: scale(1.08); }
.aux-btn.active {
  border-color: #34d399;
  color: #34d399;
  background: #062414;
  box-shadow: 0 0 12px rgba(52, 211, 153, 0.4);
}

/* ==================== FOOTER STATUS BAR ==================== */
.game-footer {
  height: 34px;
  background: #08120d;
  border-top: 1px solid #14281b;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  z-index: 15;
  flex-shrink: 0;
  font-size: 11px;
  font-weight: 700;
  color: #528566;
}
.footer-left { display: flex; align-items: center; gap: 16px; }
.footer-link { color: #528566; text-decoration: none; display: flex; align-items: center; gap: 5px; cursor: pointer; transition: color 0.15s; }
.footer-link:hover { color: #fff; }

/* ==================== MODALS (1XBET DEPOSIT & AUTH) ==================== */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(4, 8, 6, 0.88);
  backdrop-filter: blur(10px);
  z-index: 9999;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
  opacity: 0;
  transition: opacity 0.25s ease;
}
.modal-backdrop.active {
  display: flex;
  opacity: 1;
}

.auth-modal-card {
  width: 100%;
  max-width: 460px;
  background: linear-gradient(160deg, #101e14 0%, #08120c 100%);
  border: 2px solid var(--gold);
  border-radius: 20px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.9), 0 0 30px rgba(217, 164, 67, 0.3);
  overflow: hidden;
  position: relative;
  animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes modalPop {
  from { transform: scale(0.9) translateY(20px); opacity: 0; }
  to { transform: scale(1) translateY(0); opacity: 1; }
}

.auth-modal-header {
  padding: 18px 22px 14px;
  border-bottom: 1px solid #1a3222;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.auth-title-wrap h3 {
  font-family: 'Cinzel', serif;
  font-size: 17px;
  font-weight: 800;
  color: var(--gold-bright);
  letter-spacing: 1px;
}
.auth-title-wrap p {
  font-size: 11.5px;
  color: #78a88c;
  margin-top: 3px;
}
.modal-close-btn {
  background: rgba(255,255,255,0.06);
  border: 1px solid #1a3222;
  color: #94a3b8;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.15s;
}
.modal-close-btn:hover { color: #fff; background: rgba(239, 68, 68, 0.2); border-color: #ef4444; }

.auth-tabs {
  display: flex;
  border-bottom: 1px solid #1a3222;
  background: rgba(0, 0, 0, 0.25);
}
.auth-tab-btn {
  flex: 1;
  padding: 12px;
  text-align: center;
  font-size: 13px;
  font-weight: 800;
  color: #78a88c;
  background: none;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
  border-bottom: 2px solid transparent;
}
.auth-tab-btn.active {
  color: var(--gold-bright);
  border-bottom-color: var(--gold);
  background: rgba(217, 164, 67, 0.08);
}

.auth-body { padding: 22px; }
.form-input-group { margin-bottom: 14px; }
.form-input-group label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  color: #94a3b8;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.form-input-group input, .form-input-group select {
  width: 100%;
  padding: 11px 14px;
  background: rgba(0, 0, 0, 0.4);
  border: 1px solid #1a3222;
  border-radius: 8px;
  color: #fff;
  font-family: inherit;
  font-size: 13.5px;
  outline: none;
  transition: border-color 0.2s;
}
.form-input-group input:focus, .form-input-group select:focus { border-color: var(--gold); }

.btn-auth-submit {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: none;
  background: linear-gradient(135deg, #f97316 0%, #d9a443 100%);
  color: #fff;
  font-family: inherit;
  font-size: 14px;
  font-weight: 800;
  letter-spacing: 0.5px;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
  transition: all 0.2s;
  margin-top: 6px;
}
.btn-auth-submit:hover { filter: brightness(1.12); transform: translateY(-1px); }

.btn-deposit-submit {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

/* Gateway Selection Pills in Deposit Modal */
.gateway-pills-row {
  display: flex;
  gap: 8px;
  margin-bottom: 14px;
}
.gw-pill {
  flex: 1;
  padding: 8px 6px;
  background: rgba(0, 0, 0, 0.4);
  border: 1.5px solid #1a3222;
  border-radius: 8px;
  color: #cbd5e1;
  font-size: 11.5px;
  font-weight: 800;
  text-align: center;
  cursor: pointer;
  transition: all 0.15s;
}
.gw-pill:hover, .gw-pill.active {
  border-color: #34d399;
  color: #fff;
  background: rgba(16, 185, 129, 0.15);
}

/* Paytable Modal */
.paytable-modal-card {
  width: 100%;
  max-width: 520px;
  background: linear-gradient(160deg, #101e14 0%, #08120c 100%);
  border: 2px solid var(--gold);
  border-radius: 18px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.9);
  padding: 20px;
}
.paytable-grid-list {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  max-height: 380px;
  overflow-y: auto;
  padding-right: 4px;
  margin-top: 14px;
}
.paytable-card-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 10px;
  background: rgba(0,0,0,0.3);
  border: 1px solid #1a3222;
  border-radius: 8px;
}
.paytable-card-item img { width: 36px; height: 36px; object-fit: contain; }
.pay-stats { font-size: 11.5px; }
.pay-stats strong { color: var(--gold-bright); display: block; font-size: 12px; }

/* Toast Notifications */
.slot-toast {
  position: fixed;
  top: 90px;
  left: 50%;
  transform: translateX(-50%) translateY(-20px);
  background: #08140c;
  border: 2px solid var(--gold);
  border-radius: 30px;
  padding: 10px 24px;
  font-weight: 800;
  font-size: 13px;
  color: #fff;
  box-shadow: 0 10px 30px rgba(0,0,0,0.8);
  z-index: 9999;
  opacity: 0;
  pointer-events: none;
  transition: all 0.25s ease;
}
.slot-toast.active {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}
.slot-toast.win { border-color: #34d399; color: #34d399; }
.slot-toast.error { border-color: #ef4444; color: #fca5a5; }

/* ==================== RESPONSIVENESS ==================== */
@media (max-width: 768px) {
  .game-sidenav { display: none; }
  .game-header .header-title { font-size: 12px; }
  .reels-stage-wrap { height: clamp(230px, 40vh, 320px); }
  .quick-bets-bar { display: none; }
  .cabinet-ribbon { margin-bottom: 4px; }
  .cabinet-title { font-size: 18px; }
  .big-spin-btn { width: 64px; height: 64px; }
  .big-spin-btn i { font-size: 20px; }
  .stats-chips-group { width: 100%; justify-content: space-between; }
  .cabinet-controls-bar { flex-direction: column; align-items: stretch; gap: 8px; }
  .spin-action-wrap { justify-content: center; }
}
</style>
</head>
<body>

<div id="outerWrapper">

  <!-- ==================== LEFT SIDENAV ==================== -->
  <aside class="game-sidenav">
    <a href="{{ route('dashboard') }}" class="side-brand" title="1xBet Casino">
      <i class="fas fa-crown"></i>
    </a>
    <a href="{{ route('dashboard') }}" class="side-link active" data-tooltip="Casino Lobby">
      <i class="fas fa-house"></i>
    </a>
    <a href="{{ route('play') }}" class="side-link" data-tooltip="Crash Aviator">
      <i class="fas fa-plane-departure"></i>
    </a>
    <a href="{{ route('dashboard') }}" class="side-link" data-tooltip="Favorites">
      <i class="fas fa-heart"></i>
    </a>
    <div class="side-divider"></div>
    <div class="side-link" onclick="toggleMuteSound()" id="sidenav-sound-btn" data-tooltip="Sound FX">
      <i class="fas fa-volume-high"></i>
    </div>
    <div class="side-link" onclick="toggleFullScreen()" data-tooltip="Full Screen">
      <i class="fas fa-expand"></i>
    </div>
    <div class="side-link" onclick="openPaytableModal()" data-tooltip="Paytable Rules">
      <i class="fas fa-circle-info"></i>
    </div>
  </aside>

  <!-- ==================== MAIN WORKSPACE ==================== -->
  <div class="workspace-container">

    <!-- Top Header -->
    <header class="game-header">
      <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">1xBet</a>
        <i class="fas fa-chevron-right" style="font-size: 8px;"></i>
        <a href="{{ route('dashboard') }}">Slots</a>
        <i class="fas fa-chevron-right" style="font-size: 8px;"></i>
        <span>Western Vault™</span>
      </div>

      <div class="header-title">WESTERN VAULT</div>

      <div class="header-actions">
        <button class="btn-header-deposit" onclick="openDepositModal()">
          <i class="fas fa-plus-circle"></i> DEPOSIT
        </button>
        <button class="header-btn" onclick="openPaytableModal()">
          <i class="fas fa-table-cells"></i> Paytable
        </button>
        <button class="header-btn" onclick="toggleFullScreen()">
          <i class="fas fa-expand"></i>
        </button>
      </div>
    </header>

    <!-- Sub-Header / Mode Switcher -->
    <div class="game-sub-header">
      <div class="game-badge">
        <i class="fas fa-vault"></i>
        <span class="game-title">Western Vault</span>
        <span class="provider-badge">1XGAMES EXCLUSIVE</span>
      </div>

      <div class="mode-toggle-wrap">
        <span class="mode-label" id="label-demo">DEMO</span>
        <div class="toggle-pill" id="game-mode-toggle" onclick="toggleGameMode()">
          <div class="pill-dot"></div>
        </div>
        <span class="mode-label" id="label-real">REAL MONEY</span>
      </div>
    </div>

    <!-- Cabinet Stage Area -->
    <main class="cabinet-stage">
      <canvas id="bgFxCanvas"></canvas>

      <div class="slot-cabinet-wrap">
        
        <!-- Ribbon Header -->
        <div class="cabinet-ribbon">
          <h1 class="cabinet-title">WESTERN VAULT</h1>
          <div class="cabinet-subtitle">GOLDEN REELS • 5X3 MULTIPLIER VAULT</div>
        </div>

        <!-- Cabinet Frame -->
        <div class="cabinet-frame">

          <!-- Reels Stage Box -->
          <div class="reels-stage-wrap">
            
            <!-- Corner Quick Tools -->
            <button class="stage-btn top-left" onclick="openPaytableModal()" title="Paytable Rules">
              <i class="fas fa-bars"></i>
            </button>
            <button class="stage-btn top-right" id="btn-turbo-stage" onclick="toggleTurbo()" title="Turbo Fast Spin">
              <i class="fas fa-bolt"></i>
            </button>
            <button class="stage-btn bottom-left" id="btn-autospin-stage" onclick="toggleAutoSpin()" title="Auto Spin">
              <i class="fas fa-rotate"></i>
            </button>
            <button class="stage-btn bottom-right" onclick="openDepositModal()" title="Quick Deposit Recharge">
              <i class="fas fa-plus"></i>
            </button>

            <!-- 5x3 Grid of Reels -->
            <div class="reels-grid" id="reelsGrid">
              <!-- Dynamically populated 15 cells -->
            </div>

            <!-- Big Win Announcement Banner -->
            <div class="win-banner-toast" id="winBannerToast">
              <i class="fas fa-trophy"></i>
              <span id="winBannerText">BIG WIN ৳ 250.00</span>
            </div>

          </div>

          <!-- Bottom Control Bar -->
          <div class="cabinet-controls-bar">
            
            <!-- Left: Balance & Echo chips -->
            <div class="stats-chips-group">
              <div class="hud-chip">
                <i class="fas fa-wallet" style="color: var(--green);"></i>
                <div>
                  <label>Balance</label>
                  <div class="chip-val" id="hudBalanceDisplay">৳ 10,000.00</div>
                </div>
              </div>

              <div class="hud-chip">
                <i class="fas fa-coins" style="color: var(--gold-bright);"></i>
                <div>
                  <label>Current Bet</label>
                  <div class="chip-val" id="hudBetEcho">৳ 10.00</div>
                </div>
              </div>
            </div>

            <!-- Middle: Stepper & Quick Bet Presets -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
              <div class="bet-stepper-wrap">
                <button class="step-btn" onclick="adjustBet(-1)"><i class="fas fa-minus"></i></button>
                <div class="bet-display-box" id="betDisplayVal">৳ 10.00</div>
                <button class="step-btn" onclick="adjustBet(1)"><i class="fas fa-plus"></i></button>
              </div>

              <div class="quick-bets-bar">
                <button class="quick-chip" onclick="setQuickBet(10)">10</button>
                <button class="quick-chip" onclick="setQuickBet(50)">50</button>
                <button class="quick-chip" onclick="setQuickBet(100)">100</button>
                <button class="quick-chip" onclick="setQuickBet(500)">500</button>
                <button class="quick-chip" onclick="setQuickBet(1000)">1K</button>
                <button class="quick-chip" onclick="setQuickBet(5000)">MAX</button>
              </div>
            </div>

            <!-- Right: Big Spin + Turbo + Auto -->
            <div class="spin-action-wrap">
              <button class="aux-btn" id="btn-turbo-bar" onclick="toggleTurbo()" title="Turbo Spin">
                <i class="fas fa-bolt"></i>
              </button>

              <button class="big-spin-btn" id="mainSpinBtn" onclick="triggerSpin()">
                <i class="fas fa-play"></i>
                <span>SPIN</span>
              </button>

              <button class="aux-btn" id="btn-auto-bar" onclick="toggleAutoSpin()" title="Auto Spin">
                <i class="fas fa-rotate"></i>
              </button>
            </div>

          </div>

        </div>

      </div>
    </main>

    <!-- Footer Bar -->
    <footer class="game-footer">
      <div class="footer-left">
        <span class="footer-link"><i class="fas fa-shield-halved"></i> Provably Fair 100% RTP</span>
        <span class="footer-link"><i class="fas fa-bolt"></i> Instant Payouts</span>
      </div>
      <div>
        <span id="liveClock">11:35:00 AM</span> • Western Vault Engine v2.5
      </div>
    </footer>

  </div>
</div>

<!-- ==================== 1XBET DEPOSIT MODAL ==================== -->
<div class="modal-backdrop" id="depositModalBackdrop">
  <div class="auth-modal-card">
    <div class="auth-modal-header">
      <div class="auth-title-wrap">
        <h3><i class="fas fa-wallet" style="color: var(--green);"></i> 1xBet Deposit Cashier</h3>
        <p id="depositModalSubtitle">Instant recharge with automated payment verification</p>
      </div>
      <button class="modal-close-btn" onclick="closeDepositModal()"><i class="fas fa-times"></i></button>
    </div>

    <form class="auth-body" id="depositForm" onsubmit="submitQuickDeposit(event)">
      <!-- Payment Gateway Selector -->
      <div class="form-input-group">
        <label>Select Payment Gateway</label>
        <div class="gateway-pills-row">
          <div class="gw-pill active" onclick="selectGatewayPill('bKash', this)">bKash</div>
          <div class="gw-pill" onclick="selectGatewayPill('Nagad', this)">Nagad</div>
          <div class="gw-pill" onclick="selectGatewayPill('Rocket', this)">Rocket</div>
          <div class="gw-pill" onclick="selectGatewayPill('Binance USDT', this)">USDT</div>
        </div>
        <input type="hidden" name="gateway_name" id="selectedGatewayInput" value="bKash">
      </div>

      <!-- Quick Amount Preset Pills -->
      <div class="form-input-group">
        <label>Deposit Amount (৳)</label>
        <div style="display: flex; gap: 6px; margin-bottom: 8px;">
          <button type="button" class="quick-chip" onclick="setDepositAmount(500)">৳ 500</button>
          <button type="button" class="quick-chip" onclick="setDepositAmount(1000)">৳ 1,000</button>
          <button type="button" class="quick-chip" onclick="setDepositAmount(2000)">৳ 2,000</button>
          <button type="button" class="quick-chip" onclick="setDepositAmount(5000)">৳ 5,000</button>
        </div>
        <input type="number" name="amount" id="depositAmountInput" min="100" max="100000" step="50" value="500" required>
      </div>

      <div class="form-input-group">
        <label>Sender Mobile Number / Binance Pay ID</label>
        <input type="text" name="sender_number" id="depositSenderNumber" placeholder="e.g. 01700000000" required>
      </div>

      <div class="form-input-group">
        <label>Transaction ID (TrxID)</label>
        <input type="text" name="transaction_id" id="depositTrxId" placeholder="e.g. 9J8AK30L9P" required>
      </div>

      <button type="submit" class="btn-auth-submit btn-deposit-submit" id="btnDepositSubmit">
        <i class="fas fa-circle-check"></i> SUBMIT INSTANT DEPOSIT
      </button>
    </form>
  </div>
</div>

<!-- ==================== 1XBET AUTH MODAL (LOGIN / REGISTER) ==================== -->
<div class="modal-backdrop" id="authModalBackdrop">
  <div class="auth-modal-card">
    <div class="auth-modal-header">
      <div class="auth-title-wrap">
        <h3 id="authModalTitle">1xBet Membership</h3>
        <p id="authModalSubtitle">Demo limit reached. Login or register to win Real Cash!</p>
      </div>
      <button class="modal-close-btn" onclick="closeAuthModal()"><i class="fas fa-times"></i></button>
    </div>

    <div class="auth-tabs">
      <button class="auth-tab-btn active" id="tabBtnLogin" onclick="switchAuthTab('login')">Log In</button>
      <button class="auth-tab-btn" id="tabBtnRegister" onclick="switchAuthTab('register')">Registration</button>
    </div>

    <!-- Login Form -->
    <form class="auth-body" id="loginForm" onsubmit="submitAuthLogin(event)">
      <div class="form-input-group">
        <label>Email or Phone</label>
        <input type="text" name="email" id="loginEmail" placeholder="Enter your email or phone" required>
      </div>
      <div class="form-input-group">
        <label>Password</label>
        <input type="password" name="password" id="loginPassword" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-auth-submit" id="btnLoginSubmit">
        <i class="fas fa-right-to-bracket"></i> LOG IN TO PLAY FOR REAL MONEY
      </button>
    </form>

    <!-- Register Form -->
    <form class="auth-body" id="registerForm" onsubmit="submitAuthRegister(event)" style="display: none;">
      <div class="form-input-group">
        <label>Full Name</label>
        <input type="text" name="name" id="regName" placeholder="Your Name" required>
      </div>
      <div class="form-input-group">
        <label>Email Address</label>
        <input type="email" name="email" id="regEmail" placeholder="user@example.com" required>
      </div>
      <div class="form-input-group">
        <label>Password</label>
        <input type="password" name="password" id="regPassword" placeholder="Create a strong password" required>
      </div>
      <button type="submit" class="btn-auth-submit" id="btnRegSubmit">
        <i class="fas fa-user-plus"></i> INSTANT 1-CLICK REGISTRATION
      </button>
    </form>
  </div>
</div>

<!-- ==================== PAYTABLE RULES MODAL ==================== -->
<div class="modal-backdrop" id="paytableModalBackdrop">
  <div class="paytable-modal-card">
    <div class="auth-modal-header" style="padding: 0 0 12px; border-bottom: 1px solid #1a3222;">
      <div class="auth-title-wrap">
        <h3>Symbol Paytable & Multipliers</h3>
        <p>Match 3, 4 or 5 identical symbols along paying reels</p>
      </div>
      <button class="modal-close-btn" onclick="closePaytableModal()"><i class="fas fa-times"></i></button>
    </div>
    
    <div class="paytable-grid-list" id="paytableList">
      <!-- Injected via JS -->
    </div>
  </div>
</div>

<!-- Toast Message Overlay -->
<div class="slot-toast" id="slotToast">Message</div>

<!-- ==================== JAVASCRIPT GAME ENGINE ==================== -->
<script>
(() => {
  /* ---------------- CONFIG & AUTH STATE ---------------- */
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const IS_LOGGED_IN = {{ auth()->check() ? 'true' : 'false' }};
  const USER_CURRENCY = "{{ auth()->user() ? auth()->user()->currency : 'BDT' }}";
  const CURRENCY_SYMBOL = USER_CURRENCY === 'EUR' ? '€' : (USER_CURRENCY === 'USD' ? '$' : '৳');
  
  let realBalance = parseFloat("{{ auth()->user() ? auth()->user()->balance : '0.00' }}");
  let demoBalance = parseFloat("{{ $settings->demo_initial_balance ?? 10000.00 }}");
  
  // Game mode: Default to Real if logged in with balance > 0, else Demo
  let isDemoMode = IS_LOGGED_IN ? (realBalance <= 0) : true;
  
  // Demo trial limit (3 spins)
  const DEMO_LIMIT = 3;
  let demoSpinsDone = parseInt(sessionStorage.getItem('wv_demo_spins_count') || '0');

  const BET_STEPS = [10, 20, 50, 100, 200, 500, 1000, 2000, 5000];
  let currentBet = 10;
  let isSpinning = false;
  let isTurbo = false;
  let isAuto = false;
  let isMuted = false;

  /* ---------------- SOUND SYNTHESIZER & AUDIO ---------------- */
  class WesternAudioEngine {
    constructor() {
      this.ctx = null;
      // Default seeded audio files with fallback
      this.customBg = @json($settings->bg_music ? asset($settings->bg_music) : asset('assets/audio/western/western_bg.wav'));
      this.customSpin = @json($settings->spin_sound ? asset($settings->spin_sound) : asset('assets/audio/western/western_spin.wav'));
      this.customWin = @json($settings->win_sound ? asset($settings->win_sound) : asset('assets/audio/western/western_win.wav'));
      
      this.bgAudio = this.customBg ? new Audio(this.customBg) : null;
      this.spinAudio = this.customSpin ? new Audio(this.customSpin) : null;
      this.winAudio = this.customWin ? new Audio(this.customWin) : null;
      if (this.bgAudio) this.bgAudio.loop = true;
    }

    init() {
      if (!this.ctx) {
        this.ctx = new (window.AudioContext || window.webkitAudioContext)();
      }
      if (this.bgAudio && !isMuted) {
        this.bgAudio.play().catch(()=>{});
      }
    }

    playClick() {
      if (isMuted) return;
      this.init();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.connect(gain); gain.connect(this.ctx.destination);
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(580, now);
      osc.frequency.exponentialRampToValueAtTime(140, now + 0.06);
      gain.gain.setValueAtTime(0.04, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.06);
      osc.start(now); osc.stop(now + 0.06);
    }

    playReelSpin() {
      if (isMuted) return;
      if (this.spinAudio) {
        this.spinAudio.currentTime = 0;
        this.spinAudio.play().catch(()=>{});
        return;
      }
      this.init();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.connect(gain); gain.connect(this.ctx.destination);
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(160, now);
      osc.frequency.exponentialRampToValueAtTime(80, now + 0.08);
      gain.gain.setValueAtTime(0.03, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
      osc.start(now); osc.stop(now + 0.08);
    }

    playWinChime() {
      if (isMuted) return;
      if (this.winAudio) {
        this.winAudio.currentTime = 0;
        this.winAudio.play().catch(()=>{});
        return;
      }
      this.init();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51];
      notes.forEach((freq, idx) => {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.connect(gain); gain.connect(this.ctx.destination);
        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, now + idx * 0.08);
        gain.gain.setValueAtTime(0.08, now + idx * 0.08);
        gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.35);
        osc.start(now + idx * 0.08); osc.stop(now + idx * 0.08 + 0.38);
      });
    }
  }
  const audio = new WesternAudioEngine();

  /* ---------------- SYMBOL DEFINITIONS (CRISP HD) ---------------- */
  const IMG_BASE = '/assets/image/WesternHeist/';
  const SYMBOLS = [
    { id: 'wild',      name: 'Sheriff Outlaw', img: IMG_BASE + '8.png',  weight: 3,  pay: {3: 5.0, 4: 15.0, 5: 75.0} },
    { id: 'moneybag',  name: 'Gold Moneybag',  img: IMG_BASE + '9.png',  weight: 5,  pay: {3: 4.0, 4: 12.0, 5: 40.0} },
    { id: 'pistols',   name: 'Dual Pistols',   img: IMG_BASE + '10.png', weight: 8,  pay: {3: 2.5, 4: 8.0,  5: 25.0} },
    { id: 'gemPurple', name: 'Amethyst Spade', img: IMG_BASE + '7.png',  weight: 10, pay: {3: 1.5, 4: 4.0,  5: 10.0} },
    { id: 'gemBlue',   name: 'Sapphire Club',  img: IMG_BASE + '3.png',  weight: 12, pay: {3: 1.2, 4: 3.0,  5: 8.0} },
    { id: 'gemGreen',  name: 'Emerald Heart',  img: IMG_BASE + '5.png',  weight: 14, pay: {3: 1.0, 4: 2.5,  5: 6.0} },
    { id: 'A',         name: 'Ace Card',       img: IMG_BASE + '1.png',  weight: 18, pay: {3: 0.5, 4: 1.5,  5: 4.0} },
    { id: 'K',         name: 'King Card',      img: IMG_BASE + '4.png',  weight: 20, pay: {3: 0.4, 4: 1.2,  5: 3.5} },
    { id: 'Q',         name: 'Queen Card',     img: IMG_BASE + '2.png',  weight: 22, pay: {3: 0.3, 4: 1.0,  5: 3.0} },
    { id: 'J',         name: 'Jack Card',      img: IMG_BASE + '6.png',  weight: 24, pay: {3: 0.2, 4: 0.8,  5: 2.5} },
  ];
  const TOTAL_WEIGHT = SYMBOLS.reduce((sum, s) => sum + s.weight, 0);

  function pickRandomSymbol() {
    let r = Math.random() * TOTAL_WEIGHT;
    for (const s of SYMBOLS) {
      r -= s.weight;
      if (r <= 0) return s;
    }
    return SYMBOLS[0];
  }

  /* ---------------- INITIALIZE GRID ---------------- */
  const reelsGridEl = document.getElementById('reelsGrid');
  const cells = [];

  for (let r = 0; r < 3; r++) {
    cells[r] = [];
    for (let c = 0; c < 5; c++) {
      const cell = document.createElement('div');
      cell.className = 'reel-cell';
      cell.dataset.row = r;
      cell.dataset.col = c;
      const initSym = pickRandomSymbol();
      cell.innerHTML = `<img src="${initSym.img}" alt="${initSym.id}">`;
      reelsGridEl.appendChild(cell);
      cells[r][c] = cell;
    }
  }

  // Populate Paytable
  const paytableListEl = document.getElementById('paytableList');
  paytableListEl.innerHTML = SYMBOLS.map(s => `
    <div class="paytable-card-item">
      <img src="${s.img}" alt="${s.id}">
      <div class="pay-stats">
        <strong>${s.name}</strong>
        <span>3x: <b>${s.pay[3]}x</b> | 4x: <b>${s.pay[4]}x</b> | 5x: <b>${s.pay[5]}x</b></span>
      </div>
    </div>
  `).join('');

  /* ---------------- HUD & DISPLAY UPDATES ---------------- */
  function updateHUD() {
    const activeBalance = isDemoMode ? demoBalance : realBalance;
    document.getElementById('hudBalanceDisplay').textContent = (isDemoMode ? 'DEMO ' : '') + CURRENCY_SYMBOL + ' ' + activeBalance.toFixed(2);
    document.getElementById('hudBetEcho').textContent = (isDemoMode ? 'DEMO ' : '') + CURRENCY_SYMBOL + ' ' + currentBet.toFixed(2);
    document.getElementById('betDisplayVal').textContent = CURRENCY_SYMBOL + ' ' + currentBet.toFixed(2);

    const togglePill = document.getElementById('game-mode-toggle');
    const labelDemo = document.getElementById('label-demo');
    const labelReal = document.getElementById('label-real');

    if (isDemoMode) {
      togglePill.classList.remove('real-mode');
      labelDemo.className = 'mode-label active';
      labelReal.className = 'mode-label inactive';
    } else {
      togglePill.classList.add('real-mode');
      labelDemo.className = 'mode-label inactive';
      labelReal.className = 'mode-label active';
    }
  }
  updateHUD();

  /* ---------------- BET ADJUSTMENT ---------------- */
  window.adjustBet = function(direction) {
    audio.playClick();
    const idx = BET_STEPS.indexOf(currentBet);
    if (direction > 0 && idx < BET_STEPS.length - 1) {
      currentBet = BET_STEPS[idx + 1];
    } else if (direction < 0 && idx > 0) {
      currentBet = BET_STEPS[idx - 1];
    }
    updateHUD();
  };

  window.setQuickBet = function(amount) {
    audio.playClick();
    currentBet = amount;
    updateHUD();
  };

  /* ---------------- GAME MODE TOGGLE ---------------- */
  window.toggleGameMode = function() {
    audio.playClick();
    if (isDemoMode) {
      // Switching from Demo to Real
      if (!IS_LOGGED_IN) {
        showAuthModal('Please Log In', 'Login to play for Real Money and withdraw real cash winnings!');
        return;
      }
      if (realBalance < currentBet) {
        openDepositModal('Insufficient Real Balance! Please make a quick deposit to continue spinning.');
        return;
      }
      isDemoMode = false;
      showSlotToast('Switched to REAL MONEY mode', 'win');
    } else {
      isDemoMode = true;
      showSlotToast('Switched to DEMO mode');
    }
    updateHUD();
  };

  /* ---------------- SPIN EXECUTION & WHEEL LOGIC ---------------- */
  window.triggerSpin = async function() {
    if (isSpinning) return;
    audio.playClick();

    // Check demo limits (3 spins limit)
    if (isDemoMode) {
      if (demoSpinsDone >= DEMO_LIMIT) {
        if (!IS_LOGGED_IN) {
          showAuthModal('Demo Free Trial Limit Reached!', 'You have completed 3 free demo spins. Please login or register to play for REAL CASH!');
        } else {
          openDepositModal('Demo Trial Limit Reached! Deposit now to win real withdrawable cash!');
        }
        return;
      }
      if (demoBalance < currentBet) {
        showSlotToast('Demo balance exhausted!', 'error');
        return;
      }
      demoBalance -= currentBet;
      demoSpinsDone++;
      sessionStorage.setItem('wv_demo_spins_count', demoSpinsDone.toString());
    } else {
      // Real Money Spin
      if (!IS_LOGGED_IN) {
        showAuthModal('Authentication Required', 'Please login to place real money bets.');
        return;
      }
      if (realBalance < currentBet) {
        openDepositModal('Insufficient balance! Please deposit to continue spinning.');
        return;
      }
      realBalance -= currentBet;
    }

    updateHUD();
    isSpinning = true;
    const spinBtn = document.getElementById('mainSpinBtn');
    spinBtn.disabled = true;
    spinBtn.classList.add('spinning');
    hideWinToast();

    // Remove old win/dim states
    for (let r = 0; r < 3; r++) {
      for (let c = 0; c < 5; c++) {
        cells[r][c].classList.remove('win', 'dim');
        cells[r][c].classList.add('spinning');
      }
    }

    // Backend bet placement API
    let backendResult = null;
    try {
      const resp = await fetch('{{ route("western.bet") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
          side: Math.random() > 0.5 ? 'side_a' : 'side_b',
          amount: currentBet,
          is_demo: isDemoMode
        })
      });
      backendResult = await resp.json();
      if (backendResult.new_balance !== null && backendResult.new_balance !== undefined) {
        realBalance = parseFloat(backendResult.new_balance);
      }
    } catch (e) {
      console.warn('Backend spin ping failed, using client RNG:', e);
    }

    // Spin animation for each column
    const spinDuration = isTurbo ? 250 : 600;
    const newGrid = [];

    for (let c = 0; c < 5; c++) {
      const col = [];
      for (let r = 0; r < 3; r++) {
        col.push(pickRandomSymbol());
      }
      newGrid.push(col);
    }

    for (let c = 0; c < 5; c++) {
      const colDelay = c * (isTurbo ? 50 : 120);
      setTimeout(() => {
        audio.playReelSpin();
        for (let r = 0; r < 3; r++) {
          cells[r][c].innerHTML = `<img src="${newGrid[c][r].img}" alt="${newGrid[c][r].id}">`;
          cells[r][c].classList.remove('spinning');
        }
      }, spinDuration + colDelay);
    }

    const totalSpinTime = spinDuration + (4 * (isTurbo ? 50 : 120)) + 100;

    setTimeout(() => {
      // Evaluate line wins
      const winningCells = [];
      let totalMultiplier = 0;

      for (let r = 0; r < 3; r++) {
        const sym = newGrid[0][r];
        let matchCount = 1;
        for (let c = 1; c < 5; c++) {
          if (newGrid[c][r].id === sym.id || newGrid[c][r].id === 'wild') {
            matchCount++;
          } else {
            break;
          }
        }
        if (matchCount >= 3 && sym.pay[matchCount]) {
          const mult = sym.pay[matchCount];
          totalMultiplier += mult;
          for (let c = 0; c < matchCount; c++) {
            winningCells.push(cells[r][c]);
          }
        }
      }

      if (totalMultiplier > 0) {
        const winAmount = totalMultiplier * currentBet;
        if (isDemoMode) {
          demoBalance += winAmount;
        } else {
          realBalance += winAmount;
          // Sync real balance
          fetch('{{ route("dashboard.update-balance") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ balance: realBalance.toFixed(2) })
          }).catch(()=>{});
        }

        audio.playWinChime();

        // Highlight winning cells
        for (let r = 0; r < 3; r++) {
          for (let c = 0; c < 5; c++) {
            cells[r][c].classList.add('dim');
          }
        }
        winningCells.forEach(cell => {
          cell.classList.remove('dim');
          cell.classList.add('win');
        });

        showWinToast(`WIN ${CURRENCY_SYMBOL} ${winAmount.toFixed(2)} (${totalMultiplier.toFixed(1)}X)`);
      }

      isSpinning = false;
      spinBtn.disabled = false;
      spinBtn.classList.remove('spinning');
      updateHUD();

      // If user exhausted demo limit on this spin, pop deposit/auth modal
      if (isDemoMode && demoSpinsDone >= DEMO_LIMIT) {
        setTimeout(() => {
          if (!IS_LOGGED_IN) {
            showAuthModal('Demo Free Trial Limit Reached!', 'You have completed 3 free demo spins. Please login or register to play for REAL CASH!');
          } else {
            openDepositModal('Demo Trial Limit Reached! Deposit now to win real withdrawable cash!');
          }
        }, 1200);
      }

      if (isAuto && !isSpinning && (!isDemoMode || demoSpinsDone < DEMO_LIMIT)) {
        setTimeout(triggerSpin, isTurbo ? 400 : 1000);
      }
    }, totalSpinTime);
  };

  /* ---------------- AUX CONTROLS ---------------- */
  window.toggleTurbo = function() {
    audio.playClick();
    isTurbo = !isTurbo;
    document.getElementById('btn-turbo-stage').classList.toggle('active', isTurbo);
    document.getElementById('btn-turbo-bar').classList.toggle('active', isTurbo);
    showSlotToast(isTurbo ? 'Turbo Spin: ON ⚡' : 'Turbo Spin: OFF');
  };

  window.toggleAutoSpin = function() {
    audio.playClick();
    isAuto = !isAuto;
    document.getElementById('btn-autospin-stage').classList.toggle('active', isAuto);
    document.getElementById('btn-auto-bar').classList.toggle('active', isAuto);
    showSlotToast(isAuto ? 'Auto Spin: ACTIVE' : 'Auto Spin: STOPPED');
    if (isAuto && !isSpinning) triggerSpin();
  };

  window.toggleMuteSound = function() {
    isMuted = !isMuted;
    const btn = document.getElementById('sidenav-sound-btn');
    btn.innerHTML = isMuted ? '<i class="fas fa-volume-xmark" style="color:#ef4444;"></i>' : '<i class="fas fa-volume-high"></i>';
    showSlotToast(isMuted ? 'Muted' : 'Sound ON');
  };

  window.toggleFullScreen = function() {
    if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen().catch(()=>{});
    } else {
      document.exitFullscreen().catch(()=>{});
    }
  };

  /* ---------------- TOAST & MODAL HELPERS ---------------- */
  function showSlotToast(msg, type = '') {
    const toast = document.getElementById('slotToast');
    toast.textContent = msg;
    toast.className = `slot-toast active ${type}`;
    setTimeout(() => toast.classList.remove('active'), 2200);
  }

  function showWinToast(msg) {
    const banner = document.getElementById('winBannerToast');
    document.getElementById('winBannerText').textContent = msg;
    banner.classList.add('show');
  }

  function hideWinToast() {
    document.getElementById('winBannerToast').classList.remove('show');
  }

  /* ---------------- DEPOSIT MODAL LOGIC ---------------- */
  window.openDepositModal = function(subtitle) {
    audio.playClick();
    if (subtitle) {
      document.getElementById('depositModalSubtitle').textContent = subtitle;
    }
    document.getElementById('depositModalBackdrop').classList.add('active');
  };

  window.closeDepositModal = function() {
    document.getElementById('depositModalBackdrop').classList.remove('active');
  };

  window.selectGatewayPill = function(gwName, el) {
    document.querySelectorAll('.gw-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('selectedGatewayInput').value = gwName;
  };

  window.setDepositAmount = function(amount) {
    document.getElementById('depositAmountInput').value = amount;
  };

  window.submitQuickDeposit = async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnDepositSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting Request...';

    const formData = new FormData(e.target);
    try {
      const res = await fetch('{{ route("dashboard.deposit") }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: formData
      });
      const data = await res.json();
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT INSTANT DEPOSIT';

      if (data.success) {
        showSlotToast('✅ Deposit request submitted successfully! Admin will approve shortly.', 'win');
        closeDepositModal();
        e.target.reset();
      } else {
        alert(data.message || 'Deposit submission failed.');
      }
    } catch (err) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT INSTANT DEPOSIT';
      alert('Network error. Please try again or check cashier in dashboard.');
    }
  };

  window.openPaytableModal = function() {
    audio.playClick();
    document.getElementById('paytableModalBackdrop').classList.add('active');
  };
  window.closePaytableModal = function() {
    document.getElementById('paytableModalBackdrop').classList.remove('active');
  };

  window.showAuthModal = function(title, subtitle) {
    document.getElementById('authModalTitle').textContent = title || '1xBet Membership';
    document.getElementById('authModalSubtitle').textContent = subtitle || 'Login or register to play for real cash.';
    document.getElementById('authModalBackdrop').classList.add('active');
  };
  window.closeAuthModal = function() {
    document.getElementById('authModalBackdrop').classList.remove('active');
  };

  window.switchAuthTab = function(tab) {
    const btnLogin = document.getElementById('tabBtnLogin');
    const btnReg = document.getElementById('tabBtnRegister');
    const formLogin = document.getElementById('loginForm');
    const formReg = document.getElementById('registerForm');

    if (tab === 'login') {
      btnLogin.classList.add('active');
      btnReg.classList.remove('active');
      formLogin.style.display = 'block';
      formReg.style.display = 'none';
    } else {
      btnReg.classList.add('active');
      btnLogin.classList.remove('active');
      formReg.style.display = 'block';
      formLogin.style.display = 'none';
    }
  };

  window.submitAuthLogin = async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnLoginSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';

    const formData = new FormData(e.target);
    try {
      const res = await fetch('{{ route("login") }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: formData
      });
      const data = await res.json();
      if (data.success) {
        showSlotToast('Login successful! Reloading wallet...', 'win');
        setTimeout(() => window.location.reload(), 800);
      } else {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-right-to-bracket"></i> LOG IN TO PLAY';
        alert(data.message || 'Login failed. Please check credentials.');
      }
    } catch (err) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-right-to-bracket"></i> LOG IN TO PLAY';
      alert('Network error. Please try again.');
    }
  };

  window.submitAuthRegister = async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnRegSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';

    const formData = new FormData(e.target);
    try {
      const res = await fetch('{{ route("register") }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: formData
      });
      const data = await res.json();
      if (data.success) {
        showSlotToast('Registration successful! Welcome to 1xBet!', 'win');
        setTimeout(() => window.location.reload(), 800);
      } else {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-user-plus"></i> INSTANT REGISTRATION';
        alert(data.message || 'Registration failed. Please try again.');
      }
    } catch (err) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-user-plus"></i> INSTANT REGISTRATION';
      alert('Network error. Please try again.');
    }
  };

  // Live Clock Updater
  setInterval(() => {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString();
  }, 1000);

})();
</script>
</body>
</html>
