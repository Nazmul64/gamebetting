<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>1xBet — Heads or Tails (Mermaid & Octopus Gold Coin)</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Roboto+Mono:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ============================================================
   1xBet OFFICIAL HEADS OR TAILS (MERMAID & GOLD COIN) THEME
   ============================================================ */
:root {
  --bg-deep: #030b18;
  --bg-dark: #071529;
  --topbar-bg: #09182d;
  --topbar-active: #0c436b;
  --accent-gold: #f5c842;
  --gold-glow: #ffe066;
  --gold-dark: #b8860b;
  --wood-panel: #542810;
  --wood-dark: #321609;
  --wood-border: #7c401d;
  --wood-light: #8e441d;
  --btn-blue: #0088cc;
  --btn-green: #2ecc71;
  --btn-red: #e74c3c;
  --text-main: #ffffff;
  --text-muted: #8aa0b8;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
  width: 100%;
  min-height: 100vh;
  background: var(--bg-deep);
  font-family: 'Outfit', sans-serif;
  color: var(--text-main);
  overflow-x: hidden;
  user-select: none;
  -webkit-user-select: none;
}

/* ================= 1xBet TOP NAVIGATION BAR ================= */
.xbet-navbar {
  width: 100%;
  background: #091a30;
  border-bottom: 1px solid #142e50;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  height: 48px;
  position: relative;
  z-index: 50;
  font-size: 12.5px;
}

.xbet-nav-left {
  display: flex;
  align-items: center;
  gap: 12px;
  overflow-x: auto;
  scrollbar-width: none;
}
.xbet-nav-left::-webkit-scrollbar { display: none; }

.xbet-logo {
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 20px;
  color: #fff;
  letter-spacing: -0.5px;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 2px;
  margin-right: 8px;
}
.xbet-logo span { color: #00aaff; }

.country-pill {
  background: #005530;
  color: #4ade80;
  border: 1px solid #16a34a;
  border-radius: 4px;
  padding: 3px 8px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 4px;
  white-space: nowrap;
}

.nav-links-list {
  display: flex;
  align-items: center;
  gap: 4px;
  list-style: none;
}
.nav-link-item {
  color: #94a3b8;
  padding: 6px 10px;
  border-radius: 4px;
  text-decoration: none;
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  transition: all 0.2s;
  white-space: nowrap;
}
.nav-link-item:hover, .nav-link-item.active {
  color: #fff;
  background: #0f3460;
}
.nav-link-item.highlight {
  color: #fbbf24;
}

.xbet-nav-right {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-shrink: 0;
}

.balance-pill {
  background: #0a1f3a;
  border: 1px solid #1e3a8a;
  border-radius: 6px;
  padding: 4px 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  font-family: 'Roboto Mono', monospace;
  font-size: 13px;
  font-weight: 700;
  color: #fbbf24;
  white-space: nowrap;
}
.balance-pill .currency { color: #94a3b8; font-size: 11px; }

.btn-deposit-top {
  background: linear-gradient(180deg, #22c55e 0%, #15803d 100%);
  color: #fff;
  font-weight: 800;
  font-size: 11px;
  padding: 6px 14px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  text-transform: uppercase;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  box-shadow: 0 2px 6px rgba(34,197,94,0.4);
}
.btn-withdraw-top {
  background: linear-gradient(180deg, #0284c7 0%, #0369a1 100%);
  color: #fff;
  font-weight: 800;
  font-size: 11px;
  padding: 6px 12px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  text-transform: uppercase;
  text-decoration: none;
}
.btn-cabinet-top {
  background: #1e293b;
  border: 1px solid #334155;
  color: #cbd5e1;
  font-size: 11px;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 4px;
  text-decoration: none;
}

/* ================= GAME VIEW CONTAINER ================= */
.game-viewport {
  position: relative;
  width: 100%;
  min-height: calc(100vh - 48px);
  display: flex;
  flex-direction: column;
  background: #041021;
  overflow: hidden;
}

/* Background video or ambient art */
.game-bg-media {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
  pointer-events: none;
  opacity: 0.85;
}
.game-bg-fallback {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 50% 30%, #1e3a8a 0%, #081a36 60%, #020713 100%);
  z-index: 0;
}

/* ================= GAME SUB-HEADER ================= */
.game-sub-header {
  position: relative;
  z-index: 10;
  padding: 10px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.breadcrumbs-track {
  font-size: 11.5px;
  font-weight: 700;
  letter-spacing: 1px;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 6px;
  text-transform: uppercase;
}
.breadcrumbs-track span.active { color: #f5c842; }

.jackpot-tag {
  background: linear-gradient(180deg, #d97706 0%, #78350f 100%);
  border: 1.5px solid #fbbf24;
  color: #fff;
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 12px;
  letter-spacing: 2px;
  padding: 5px 18px;
  border-radius: 4px;
  box-shadow: 0 0 12px rgba(245,158,11,0.5);
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Mode / Sound Toggles on top */
.mode-switches {
  display: flex;
  align-items: center;
  gap: 8px;
}
.demo-toggle-btn {
  background: #1e293b;
  border: 1px solid #475569;
  color: #94a3b8;
  font-size: 11px;
  font-weight: 800;
  padding: 4px 12px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.demo-toggle-btn.active {
  background: #eab308;
  color: #000;
  border-color: #ca8a04;
  box-shadow: 0 0 10px rgba(234,179,8,0.5);
}
.sound-toggle-btn {
  background: rgba(0,0,0,0.5);
  border: 1px solid rgba(255,255,255,0.2);
  color: #fff;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  cursor: pointer;
}

/* ================= MAIN GAME WORKSPACE ================= */
.game-main-area {
  position: relative;
  z-index: 10;
  flex: 1;
  display: grid;
  grid-template-columns: 280px 1fr 220px;
  gap: 16px;
  padding: 0 20px 20px;
  max-width: 1440px;
  margin: 0 auto;
  width: 100%;
  align-items: center;
}

/* LEFT: Mermaid Character on Rocks */
.mermaid-side {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  height: 100%;
  min-height: 420px;
  pointer-events: none;
}
.mermaid-character-img {
  width: 100%;
  max-width: 320px;
  filter: drop-shadow(0 10px 25px rgba(0,0,0,0.8));
  animation: mermaidFloat 4s ease-in-out infinite;
  object-fit: contain;
}
@keyframes mermaidFloat {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

/* CENTER: Coin Toss Stage & Controls */
.stage-center {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  max-width: 580px;
  margin: 0 auto;
}

/* Start Round Ribbon Banner */
.ribbon-banner-wrap {
  position: relative;
  width: 100%;
  max-width: 380px;
  margin-bottom: 24px;
}
.ribbon-banner {
  background: linear-gradient(180deg, #d9531e 0%, #b83a0a 50%, #872503 100%);
  border: 2px solid #f59e0b;
  border-radius: 8px;
  padding: 10px 20px;
  text-align: center;
  box-shadow: 0 6px 20px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.4);
  position: relative;
}
.ribbon-coins-decor {
  position: absolute;
  top: -14px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 4px;
}
.mini-gold-coin {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 30%, #fff2a3, #f59e0b, #92400e);
  border: 1.5px solid #ffd700;
  box-shadow: 0 2px 6px rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
}
.banner-status-text {
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 14px;
  letter-spacing: 1.5px;
  color: #fff;
  text-shadow: 0 2px 4px rgba(0,0,0,0.8);
  margin-top: 4px;
}

/* ================= 3D COIN ARENA ================= */
.coin-arena {
  width: 140px;
  height: 140px;
  position: relative;
  perspective: 1000px;
  margin-bottom: 22px;
}
.coin-3d {
  width: 100%;
  height: 100%;
  position: absolute;
  transform-style: preserve-3d;
  transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}
.coin-face {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  box-shadow: 0 12px 30px rgba(0,0,0,0.7), 0 0 20px rgba(245,200,66,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  border: 4px solid #b8860b;
}

/* Heads: Mermaid/Star face */
.coin-face.heads {
  background: radial-gradient(circle at 35% 30%, #fff7b8 0%, #f5c842 50%, #9a6608 100%);
  transform: rotateY(0deg);
}
.coin-face.heads img {
  width: 75%;
  height: 75%;
  object-fit: contain;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
}
.coin-face.heads .fallback-symbol {
  font-family: 'Cinzel', serif;
  font-size: 42px;
  font-weight: 900;
  color: #5a3200;
  text-shadow: 0 1px 2px rgba(255,255,255,0.6);
}

/* Tails: Octopus Gold Coin */
.coin-face.tails {
  background: radial-gradient(circle at 35% 30%, #fff7b8 0%, #eab308 50%, #78350f 100%);
  transform: rotateY(180deg);
}
.coin-face.tails img {
  width: 80%;
  height: 80%;
  object-fit: contain;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.6));
}
.coin-face.tails .fallback-symbol {
  font-size: 48px;
}

/* 3D Spin Animation */
.coin-spinning-3d {
  animation: flip3D 1.8s infinite linear;
}
@keyframes flip3D {
  0% { transform: rotateY(0deg) scale(1); }
  50% { transform: rotateY(900deg) scale(1.18); }
  100% { transform: rotateY(1800deg) scale(1); }
}

/* ================= CHOICE BUTTONS ================= */
.choice-controls-row {
  display: flex;
  gap: 14px;
  width: 100%;
  max-width: 420px;
  justify-content: center;
  margin-bottom: 18px;
}
.choice-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px 20px;
  border-radius: 30px;
  border: 2px solid transparent;
  cursor: pointer;
  font-family: 'Cinzel', serif;
  font-weight: 800;
  font-size: 14px;
  letter-spacing: 1.5px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 15px rgba(0,0,0,0.4);
}
.choice-btn.heads-btn {
  background: linear-gradient(180deg, #38bdf8 0%, #0284c7 100%);
  color: #fff;
  border-color: #7dd3fc;
}
.choice-btn.heads-btn.selected {
  background: linear-gradient(180deg, #0284c7 0%, #0369a1 100%);
  border-color: #f5c842;
  box-shadow: 0 0 20px rgba(245,200,66,0.8), 0 4px 15px rgba(2,132,199,0.6);
  transform: scale(1.05);
}

.choice-btn.tails-btn {
  background: linear-gradient(180deg, #fbbf24 0%, #d97706 100%);
  color: #451a03;
  border-color: #fde68a;
}
.choice-btn.tails-btn.selected {
  background: linear-gradient(180deg, #f59e0b 0%, #b45309 100%);
  border-color: #ffffff;
  color: #fff;
  box-shadow: 0 0 20px rgba(255,255,255,0.8), 0 4px 15px rgba(217,119,6,0.6);
  transform: scale(1.05);
}
.choice-badge-icon {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0,0,0,0.25);
  font-size: 13px;
}

/* ================= STAKE PANEL & CONTROL BOX ================= */
.stake-panel-box {
  background: linear-gradient(180deg, #7c310f 0%, #4a1906 100%);
  border: 2px solid #ca8a04;
  border-radius: 12px;
  padding: 14px 18px;
  width: 100%;
  max-width: 480px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.2);
}
.stake-box-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.stake-title-label {
  font-family: 'Cinzel', serif;
  font-size: 11.5px;
  font-weight: 700;
  letter-spacing: 2px;
  color: #fde047;
}
.multiplier-tag {
  font-family: 'Roboto Mono', monospace;
  font-size: 12px;
  font-weight: 800;
  color: #4ade80;
  background: rgba(0,0,0,0.4);
  padding: 2px 8px;
  border-radius: 4px;
  border: 1px solid rgba(74,222,128,0.3);
}

/* Stake Amount & Chips */
.stake-chips-row {
  display: flex;
  gap: 6px;
  margin-bottom: 12px;
  justify-content: center;
  flex-wrap: wrap;
}
.stake-chip {
  background: linear-gradient(180deg, #b45309 0%, #78350f 100%);
  border: 1px solid #d97706;
  color: #fef08a;
  font-weight: 800;
  font-size: 12px;
  padding: 6px 12px;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.15s;
}
.stake-chip:hover { transform: translateY(-2px); border-color: #fde047; }
.stake-chip.active {
  background: linear-gradient(180deg, #eab308 0%, #ca8a04 100%);
  color: #000;
  border-color: #fff;
  box-shadow: 0 0 10px rgba(234,179,8,0.6);
}

/* Play & Input bar */
.play-control-bar {
  display: flex;
  align-items: center;
  gap: 10px;
}
.play-btn-primary {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
  border: 2px solid #7dd3fc;
  color: #fff;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(2,132,199,0.5);
  transition: all 0.2s;
  flex-shrink: 0;
}
.play-btn-primary:hover {
  transform: scale(1.08);
  box-shadow: 0 0 20px rgba(56,189,248,0.8);
}
.play-btn-primary:active { transform: scale(0.96); }

.stake-input-container {
  flex: 1;
  background: #110502;
  border: 1.5px solid #854d0e;
  border-radius: 8px;
  display: flex;
  align-items: center;
  padding: 0 12px;
  height: 48px;
}
.stake-input-field {
  width: 100%;
  background: transparent;
  border: none;
  outline: none;
  font-family: 'Roboto Mono', monospace;
  font-size: 17px;
  font-weight: 800;
  color: #fef08a;
  text-align: center;
}
.clear-stake-btn {
  background: transparent;
  border: none;
  color: #9ca3af;
  font-size: 16px;
  cursor: pointer;
  padding: 4px;
}
.clear-stake-btn:hover { color: #ef4444; }

.cashout-btn {
  background: linear-gradient(180deg, #22c55e 0%, #15803d 100%);
  color: #fff;
  font-family: 'Cinzel', serif;
  font-weight: 900;
  font-size: 13px;
  letter-spacing: 1px;
  padding: 0 16px;
  height: 48px;
  border-radius: 8px;
  border: 1.5px solid #86efac;
  cursor: pointer;
  box-shadow: 0 0 15px rgba(34,197,94,0.5);
  transition: all 0.2s;
  white-space: nowrap;
  display: none;
}
.cashout-btn:hover { transform: scale(1.04); }

/* ================= RIGHT DYNAMIC HISTORY SIDEBAR ================= */
.sidebar-right {
  position: relative;
  background: linear-gradient(180deg, #421b08 0%, #290f04 100%);
  border: 2px solid #854d0e;
  border-radius: 12px;
  padding: 12px;
  height: 100%;
  max-height: 520px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 8px 25px rgba(0,0,0,0.6);
}
.doubling-wheel-card {
  background: linear-gradient(180deg, #602509 0%, #3f1604 100%);
  border: 1.5px solid #ca8a04;
  border-radius: 8px;
  padding: 10px 8px;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  margin-bottom: 12px;
  transition: all 0.2s;
}
.doubling-wheel-card:hover {
  border-color: #fde047;
  transform: translateY(-2px);
}
.wheel-icon-wrap {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: radial-gradient(circle, #fde047 0%, #ca8a04 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  color: #451a03;
  box-shadow: 0 2px 8px rgba(0,0,0,0.5);
}
.doubling-text-title {
  font-family: 'Cinzel', serif;
  font-weight: 800;
  font-size: 11px;
  letter-spacing: 1px;
  color: #fef08a;
}
.doubling-text-sub {
  font-size: 9.5px;
  color: #d97706;
  font-weight: 600;
}

.history-title {
  font-family: 'Cinzel', serif;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.5px;
  color: #fde047;
  text-align: center;
  margin-bottom: 8px;
  text-transform: uppercase;
}
.history-toss-list {
  flex: 1;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 6px;
  scrollbar-width: thin;
  scrollbar-color: #854d0e transparent;
}
.history-toss-list::-webkit-scrollbar { width: 4px; }
.history-toss-list::-webkit-scrollbar-thumb { background: #854d0e; border-radius: 4px; }

.history-item {
  background: rgba(0,0,0,0.35);
  border: 1px solid rgba(133,77,14,0.5);
  border-radius: 6px;
  padding: 6px 8px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 11px;
  transition: all 0.2s;
}
.history-item.heads-win {
  border-color: rgba(56,189,248,0.5);
  background: rgba(2,132,199,0.15);
}
.history-item.tails-win {
  border-color: rgba(234,179,8,0.5);
  background: rgba(202,138,4,0.15);
}
.hist-side-tag {
  font-weight: 800;
  font-family: 'Cinzel', serif;
  display: flex;
  align-items: center;
  gap: 4px;
}
.hist-side-tag.heads { color: #38bdf8; }
.hist-side-tag.tails { color: #fbbf24; }
.hist-payout-val {
  font-family: 'Roboto Mono', monospace;
  font-weight: 700;
  color: #4ade80;
}

/* ================= WIN / LOSS GLOW & ALERTS ================= */
.win-glow {
  box-shadow: 0 0 40px #22c55e, inset 0 0 25px #15803d !important;
  transition: box-shadow 0.3s ease;
}
.loss-glow {
  box-shadow: 0 0 40px #ef4444, inset 0 0 25px #991b1b !important;
  transition: box-shadow 0.3s ease;
}

/* Deposit Modal Popup */
.deposit-modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.85);
  backdrop-filter: blur(6px);
  z-index: 100;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.deposit-modal-overlay.hidden { display: none; }

.deposit-modal-card {
  background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
  border: 2px solid #eab308;
  border-radius: 16px;
  max-width: 440px;
  width: 100%;
  padding: 28px 24px;
  text-align: center;
  box-shadow: 0 10px 40px rgba(0,0,0,0.8), 0 0 30px rgba(234,179,8,0.3);
  position: relative;
  animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes modalPop {
  from { transform: scale(0.85); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.deposit-modal-icon {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: radial-gradient(circle, #fde047, #ca8a04);
  margin: 0 auto 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
  color: #451a03;
  box-shadow: 0 0 20px rgba(234,179,8,0.5);
}
.deposit-modal-title {
  font-family: 'Cinzel', serif;
  font-size: 20px;
  font-weight: 800;
  color: #fef08a;
  margin-bottom: 8px;
}
.deposit-modal-desc {
  font-size: 13.5px;
  color: #cbd5e1;
  line-height: 1.6;
  margin-bottom: 20px;
}
.btn-deposit-action {
  background: linear-gradient(180deg, #22c55e 0%, #16a34a 100%);
  color: #fff;
  font-weight: 800;
  font-size: 14px;
  padding: 12px 24px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  text-transform: uppercase;
  width: 100%;
  box-shadow: 0 4px 15px rgba(34,197,94,0.5);
  margin-bottom: 10px;
}
.btn-close-modal {
  background: transparent;
  border: 1px solid #475569;
  color: #94a3b8;
  font-size: 12px;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
}

/* ================= MOBILE RESPONSIVENESS ================= */
@media (max-width: 1024px) {
  .game-main-area {
    grid-template-columns: 1fr 200px;
    gap: 12px;
  }
  .mermaid-side { display: none; }
}

@media (max-width: 768px) {
  .xbet-navbar { height: auto; padding: 8px 12px; flex-wrap: wrap; gap: 8px; }
  .game-main-area {
    grid-template-columns: 1fr;
    padding: 10px;
    gap: 16px;
  }
  .sidebar-right {
    max-height: 200px;
    order: 3;
  }
  .stage-center {
    width: 100%;
    order: 1;
  }
  .coin-arena { width: 110px; height: 110px; margin-bottom: 16px; }
  .choice-btn { padding: 10px 14px; font-size: 13px; }
  .stake-panel-box { padding: 10px 12px; }
  .play-btn-primary { width: 42px; height: 42px; font-size: 16px; }
}
</style>
</head>

<body>

<!-- ================= 1xBet TOP NAVIGATION ================= -->
<header class="xbet-navbar">
  <div class="xbet-nav-left">
    <a href="{{ route('home') }}" class="xbet-logo">1X<span>BET</span></a>
    <div class="country-pill">
      <span>🇧🇩</span> BANGLADESH
    </div>
    <ul class="nav-links-list">
      <li><a href="{{ route('home') }}" class="nav-link-item">TOP-EVENTS</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item">LEAGUE OF WINS</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item">T20 BLAST</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item">CRICKET</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item">SPORTS</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item">LIVE</a></li>
      <li><a href="{{ route('heads-or-tails') }}" class="nav-link-item active">1XGAMES</a></li>
      <li><a href="{{ route('home') }}" class="nav-link-item highlight">CASINO</a></li>
    </ul>
  </div>

  <div class="xbet-nav-right">
    <div class="balance-pill" id="balance-pill-box">
      <span style="font-size:11px; opacity:0.8;">BALANCE:</span>
      <span id="balance-display">৳ {{ number_format(auth()->user()->balance ?? 1000.00, 2) }}</span>
    </div>
    <a href="{{ route('dashboard') }}" class="btn-deposit-top"><i class="fas fa-plus-circle"></i> DEPOSIT</a>
    <a href="{{ route('dashboard') }}" class="btn-withdraw-top">WITHDRAW</a>
    <a href="{{ route('dashboard') }}" class="btn-cabinet-top">CABINET</a>
  </div>
</header>

<!-- ================= GAME WORKSPACE ================= -->
<main class="game-viewport" id="game-main-frame">
  <!-- Background Video / Artwork -->
  @if(file_exists(public_path('assets/image/headsortals/video1.mp4')))
    <video class="game-bg-media" autoplay muted loop playsinline>
      <source src="{{ asset('assets/image/headsortals/video1.mp4') }}" type="video/mp4">
    </video>
  @else
    <div class="game-bg-fallback"></div>
  @endif

  <!-- Sub Header: Breadcrumbs & Mode Controls -->
  <div class="game-sub-header">
    <div class="breadcrumbs-track">
      <span>1XGAMES</span> / <span>OTHER GAMES</span> / <span class="active">HEADS OR TAILS</span>
    </div>

    <div class="mode-switches">
      <button class="demo-toggle-btn" id="demo-mode-btn" onclick="toggleDemo()">
        <span class="dot" style="width:6px; height:6px; border-radius:50%; background:#22c55e;"></span>
        <span>REAL MONEY</span>
      </button>
      <button class="sound-toggle-btn" id="sound-btn" onclick="toggleSound()" title="Sound Toggle">
        <i class="fas fa-volume-high" id="sound-icon"></i>
      </button>
      <div class="jackpot-tag">
        <i class="fas fa-bolt"></i> JACKPOT
      </div>
    </div>
  </div>

  <!-- Main Game 3-Column Layout -->
  <div class="game-main-area">

    <!-- LEFT COLUMN: Mermaid Character -->
    <div class="mermaid-side">
      @if(file_exists(public_path('assets/image/headsortals/1.jpg')))
        <img src="{{ asset('assets/image/headsortals/1.jpg') }}" alt="Mermaid" class="mermaid-character-img" style="border-radius:12px; opacity:0.95;">
      @else
        <div style="font-size:100px; text-align:center; filter:drop-shadow(0 10px 20px rgba(0,0,0,0.8));">🧜‍♀️</div>
      @endif
    </div>

    <!-- CENTER COLUMN: Coin Toss Arena -->
    <div class="stage-center">

      <!-- Start Round Ribbon Banner -->
      <div class="ribbon-banner-wrap">
        <div class="ribbon-coins-decor">
          <div class="mini-gold-coin">🪙</div>
          <div class="mini-gold-coin">🪙</div>
        </div>
        <div class="ribbon-banner">
          <div class="banner-status-text" id="banner-status-text">
            MAKE YOUR CHOICE! HEADS OR TAILS?
          </div>
        </div>
      </div>

      <!-- 3D Gold Coin Arena -->
      <div class="coin-arena" onclick="placeTossBet()">
        <div class="coin-3d" id="coin-gold-octopus">
          <!-- Heads Face -->
          <div class="coin-face heads">
            @if(file_exists(public_path('assets/image/headsortals/9.png')))
              <img src="{{ asset('assets/image/headsortals/9.png') }}" alt="Heads">
            @else
              <div class="fallback-symbol">10</div>
            @endif
          </div>

          <!-- Tails Face -->
          <div class="coin-face tails">
            @if(file_exists(public_path('assets/image/headsortals/2.png')))
              <img src="{{ asset('assets/image/headsortals/2.png') }}" alt="Tails Octopus">
            @else
              <div class="fallback-symbol">🐙</div>
            @endif
          </div>
        </div>
      </div>

      <!-- Heads or Tails Choice Buttons -->
      <div class="choice-controls-row">
        <button class="choice-btn heads-btn selected" id="heads-btn" onclick="selectSide('heads')">
          <div class="choice-badge-icon">🪙</div>
          <span>HEADS</span>
        </button>
        <button class="choice-btn tails-btn" id="tails-btn" onclick="selectSide('tails')">
          <div class="choice-badge-icon">🐙</div>
          <span>TAILS</span>
        </button>
      </div>

      <!-- Stake & Controls Box -->
      <div class="stake-panel-box">
        <div class="stake-box-header">
          <span class="stake-title-label" id="stake-mode-label">YOUR STAKE</span>
          <span class="multiplier-tag" id="multiplier-display">1.96×</span>
        </div>

        <!-- Quick Stake Chips -->
        <div class="stake-chips-row" id="stake-chips-container">
          <button class="stake-chip active" onclick="setStake(10)">৳10</button>
          <button class="stake-chip" onclick="setStake(50)">৳50</button>
          <button class="stake-chip" onclick="setStake(100)">৳100</button>
          <button class="stake-chip" onclick="setStake(500)">৳500</button>
          <button class="stake-chip" onclick="setStake(1000)">৳1000</button>
        </div>

        <!-- Play bar -->
        <div class="play-control-bar">
          <button class="play-btn-primary" id="play-trigger-btn" onclick="placeTossBet()" title="Flip Coin">
            <i class="fas fa-play" id="play-btn-icon"></i>
          </button>

          <div class="stake-input-container">
            <input type="number" id="bet-amount-input" class="stake-input-field" value="10" min="1" step="1">
            <button class="clear-stake-btn" onclick="clearStake()" title="Clear">✕</button>
          </div>

          <button class="cashout-btn" id="cashout-btn" onclick="cashOutProgressive()">
            <i class="fas fa-sack-dollar"></i> CASHOUT: <span id="cashout-amount-display">৳19.60</span>
          </button>
        </div>
      </div>

    </div>

    <!-- RIGHT COLUMN: Dynamic History Sidebar -->
    <div class="sidebar-right">
      <div class="doubling-wheel-card" onclick="toggleProgressiveMode()">
        <div class="wheel-icon-wrap">
          <i class="fas fa-dharmachakra"></i>
        </div>
        <div>
          <div class="doubling-text-title" id="mode-text-title">DOUBLING STAKE</div>
          <div class="doubling-text-sub" id="mode-text-sub">Progressive 1.96× ~ 7.5×</div>
        </div>
      </div>

      <div class="history-title">
        <i class="fas fa-clock-rotate-left"></i> Toss History
      </div>

      <div class="history-toss-list" id="history-sidebar-list">
        @forelse($history as $item)
          <div class="history-item {{ $item->winning_side === 'heads' ? 'heads-win' : 'tails-win' }}">
            <span class="hist-side-tag {{ $item->winning_side }}">
              {{ $item->winning_side === 'heads' ? '🪙 HEADS' : '🐙 TAILS' }}
            </span>
            <span class="hist-payout-val">
              ৳{{ number_format($item->total_payout > 0 ? $item->total_payout : 0, 2) }}
            </span>
          </div>
        @empty
          <div style="text-align:center; color:#9ca3af; font-size:11px; padding:20px 0;">
            No tosses recorded yet.
          </div>
        @endforelse
      </div>
    </div>

  </div>
</main>

<!-- ================= DEPOSIT POPUP MODAL (Limit 3 Tosses in Demo) ================= -->
<div class="deposit-modal-overlay hidden" id="deposit-modal-popup">
  <div class="deposit-modal-card">
    <div class="deposit-modal-icon">
      <i class="fas fa-wallet"></i>
    </div>
    <h3 class="deposit-modal-title">ডেমো লিমিট শেষ!</h3>
    <p class="deposit-modal-desc">
      আপনার ৩ বার ফ্রি ডেমো টস লিমিট পূর্ণ হয়েছে। ১xBet এর আসল ক্যাশ পুরষ্কার জিততে এখনই ডিপোজিট করে রিয়েল মানিতে খেলুন!
    </p>
    <a href="{{ route('dashboard') }}" class="btn-deposit-action" style="display:block; text-decoration:none; text-align:center;">
      <i class="fas fa-bolt"></i> ডিপোজিট করুন
    </a>
    <button class="btn-close-modal" onclick="closeDepositModal()">বন্ধ করুন</button>
  </div>
</div>

<!-- ================= AUDIO ELEMENTS ================= -->
<audio id="audio-bg" loop preload="none"></audio>
<audio id="audio-flip" preload="none"></audio>
<audio id="audio-win" preload="none"></audio>
<audio id="audio-loss" preload="none"></audio>

<!-- ================= JAVASCRIPT GAME ENGINE ================= -->
<script>
// Game State
let isDemoMode = false;
let demoTossDone = 0;
let demoBalance = 1000.00;
let selectedSide = 'heads';
let isFlipping = false;
let soundEnabled = true;
let progressiveMode = false;
let progressiveStep = 1;
let currentCashoutPrize = 0;

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const audioBg = document.getElementById('audio-bg');
const audioFlip = document.getElementById('audio-flip');
const audioWin = document.getElementById('audio-win');
const audioLoss = document.getElementById('audio-loss');

// Choose Heads or Tails
function selectSide(side) {
  if (isFlipping) return;
  selectedSide = side;
  document.getElementById('heads-btn').classList.toggle('selected', side === 'heads');
  document.getElementById('tails-btn').classList.toggle('selected', side === 'tails');
  playClickSound();
}

// Toggle Real / Demo mode
function toggleDemo() {
  if (isFlipping) return;
  isDemoMode = !isDemoMode;
  const btn = document.getElementById('demo-mode-btn');
  const balDisplay = document.getElementById('balance-display');

  if (isDemoMode) {
    btn.innerHTML = '<span class="dot" style="width:6px; height:6px; border-radius:50%; background:#000;"></span> DEMO ACTIVE';
    btn.classList.add('active');
    balDisplay.innerText = "DEMO ৳ " + demoBalance.toFixed(2);
  } else {
    btn.innerHTML = '<span class="dot" style="width:6px; height:6px; border-radius:50%; background:#22c55e;"></span> REAL MONEY';
    btn.classList.remove('active');
    syncState();
  }
  playClickSound();
}

// Quick Stake Setter
function setStake(amount) {
  if (isFlipping) return;
  const input = document.getElementById('bet-amount-input');
  if (input) input.value = amount;
  document.querySelectorAll('.stake-chip').forEach(c => {
    c.classList.toggle('active', parseInt(c.innerText.replace('৳', '')) === amount);
  });
  playClickSound();
}

function clearStake() {
  if (isFlipping) return;
  const input = document.getElementById('bet-amount-input');
  if (input) input.value = 1;
  document.querySelectorAll('.stake-chip').forEach(c => c.classList.remove('active'));
}

// Toggle Progressive Multiplier Mode
function toggleProgressiveMode() {
  progressiveMode = !progressiveMode;
  const title = document.getElementById('mode-text-title');
  const sub = document.getElementById('mode-text-sub');
  const label = document.getElementById('stake-mode-label');

  if (progressiveMode) {
    title.innerText = "DOUBLING STAKE";
    sub.innerText = "Progressive 1.96× ~ 7.5×";
    label.innerText = "PROGRESSIVE STAKE";
  } else {
    title.innerText = "FIXED STAKE";
    sub.innerText = "Fixed 1.96× Multiplier";
    label.innerText = "YOUR STAKE";
    resetProgressiveState();
  }
  playClickSound();
}

function resetProgressiveState() {
  progressiveStep = 1;
  currentCashoutPrize = 0;
  document.getElementById('cashout-btn').style.display = 'none';
  document.getElementById('play-trigger-btn').style.display = 'flex';
  document.getElementById('multiplier-display').innerText = '1.96×';
}

// Close Deposit Modal
function closeDepositModal() {
  document.getElementById('deposit-modal-popup').classList.add('hidden');
}

// Sound Toggle
function toggleSound() {
  soundEnabled = !soundEnabled;
  const icon = document.getElementById('sound-icon');
  if (soundEnabled) {
    icon.className = 'fas fa-volume-high';
    if (audioBg.src) audioBg.play().catch(()=>{});
  } else {
    icon.className = 'fas fa-volume-xmark';
    audioBg.pause();
  }
}

function playClickSound() {
  if (!soundEnabled) return;
  try {
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.frequency.setValueAtTime(450, ctx.currentTime);
    gain.gain.setValueAtTime(0.04, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.05);
    osc.start();
    osc.stop(ctx.currentTime + 0.05);
  } catch(e) {}
}

// Sync State from Backend
function syncState() {
  fetch("{{ route('headstails.state') }}")
    .then(res => res.json())
    .then(data => {
      // Audio sync
      if (data.audio.bg && !audioBg.src) {
        audioBg.src = data.audio.bg;
        if (soundEnabled) audioBg.play().catch(()=>{});
      }
      if (data.audio.flip) audioFlip.src = data.audio.flip;
      if (data.audio.win) audioWin.src = data.audio.win;
      if (data.audio.loss) audioLoss.src = data.audio.loss;

      // Real balance sync
      if (!isDemoMode && data.user_balance !== null) {
        const balEl = document.getElementById('balance-display');
        if (balEl) balEl.innerText = "৳ " + parseFloat(data.user_balance).toFixed(2);
      }

      // Render Dynamic Sidebar History
      if (data.history) {
        renderSidebarHistory(data.history);
      }
    })
    .catch(err => console.error("Sync state failed:", err));
}

function renderSidebarHistory(historyList) {
  const container = document.getElementById('history-sidebar-list');
  if (!container || !historyList) return;

  container.innerHTML = '';
  historyList.forEach(item => {
    const div = document.createElement('div');
    const isHeads = item.winning_side === 'heads';
    div.className = `history-item ${isHeads ? 'heads-win' : 'tails-win'}`;
    div.innerHTML = `
      <span class="hist-side-tag ${item.winning_side}">
        ${isHeads ? '🪙 HEADS' : '🐙 TAILS'}
      </span>
      <span class="hist-payout-val">
        ৳${parseFloat(item.total_payout || 0).toFixed(2)}
      </span>
    `;
    container.appendChild(div);
  });
}

// 3D Coin Flip Trigger
function trigger3DCoinFlip(winner, onFinish) {
  if (soundEnabled && audioFlip.src) {
    audioFlip.currentTime = 0;
    audioFlip.play().catch(()=>{});
  }

  const coin = document.getElementById('coin-gold-octopus');
  const banner = document.getElementById('banner-status-text');
  if (banner) banner.innerText = "🪙 FLIPPING COIN...";

  if (coin) {
    coin.classList.add('coin-spinning-3d');
  }

  setTimeout(() => {
    if (coin) {
      coin.classList.remove('coin-spinning-3d');
      // Set winning side rotation
      coin.style.transform = (winner === 'heads') ? 'rotateY(0deg)' : 'rotateY(180deg)';
    }

    if (onFinish) onFinish();
  }, 1800);
}

// Show Screen Glow
function showResultGlow(isWin) {
  const frame = document.getElementById('game-main-frame');
  if (!frame) return;
  frame.classList.add(isWin ? 'win-glow' : 'loss-glow');
  setTimeout(() => frame.classList.remove('win-glow', 'loss-glow'), 2500);
}

// Main Place Bet & Toss Engine
function placeTossBet() {
  if (isFlipping) return;

  const betInput = document.getElementById('bet-amount-input');
  const amount = parseFloat(betInput ? betInput.value : 10.00);

  if (isNaN(amount) || amount <= 0) {
    alert("অনুগ্রহ করে সঠিক বেটের পরিমাণ লিখুন।");
    return;
  }

  if (isDemoMode && demoTossDone >= 3) {
    document.getElementById('deposit-modal-popup').classList.remove('hidden');
    return;
  }

  isFlipping = true;

  fetch("{{ route('headstails.toss') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify({
      side: selectedSide,
      amount: amount,
      is_demo: isDemoMode,
      step: progressiveStep,
      demo_toss_done: demoTossDone
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.deposit_required) {
      isFlipping = false;
      document.getElementById('deposit-modal-popup').classList.remove('hidden');
      return;
    }

    if (data.error) {
      isFlipping = false;
      alert(data.error);
      return;
    }

    // Trigger 3D Spin Animation with backend result
    trigger3DCoinFlip(data.winning_side, () => {
      isFlipping = false;
      const banner = document.getElementById('banner-status-text');

      if (data.is_win) {
        if (soundEnabled && audioWin.src) audioWin.play().catch(()=>{});
        showResultGlow(true);
        if (banner) banner.innerText = `🎉 WINNER! +৳${parseFloat(data.win_amount).toFixed(2)}`;

        if (progressiveMode) {
          progressiveStep++;
          currentCashoutPrize = data.win_amount;
          const cashBtn = document.getElementById('cashout-btn');
          const cashAmt = document.getElementById('cashout-amount-display');
          cashAmt.innerText = "৳" + parseFloat(currentCashoutPrize).toFixed(2);
          cashBtn.style.display = 'block';

          const nextMult = (progressiveStep === 2) ? '3.84×' : '7.50×';
          document.getElementById('multiplier-display').innerText = nextMult;
        }
      } else {
        if (soundEnabled && audioLoss.src) audioLoss.play().catch(()=>{});
        showResultGlow(false);
        if (banner) banner.innerText = `LOSS: ${data.winning_side.toUpperCase()} WON!`;
        if (progressiveMode) {
          resetProgressiveState();
        }
      }

      // Update balances
      if (isDemoMode) {
        demoTossDone++;
        if (data.is_win) demoBalance += (data.win_amount - amount);
        else demoBalance -= amount;
        document.getElementById('balance-display').innerText = "DEMO ৳ " + demoBalance.toFixed(2);
      } else if (data.new_balance !== undefined && data.new_balance !== null) {
        document.getElementById('balance-display').innerText = "৳ " + parseFloat(data.new_balance).toFixed(2);
      }

      // Refresh recent history
      syncState();

      setTimeout(() => {
        if (!isFlipping && banner) {
          banner.innerText = "MAKE YOUR CHOICE! HEADS OR TAILS?";
        }
      }, 3500);
    });
  })
  .catch(err => {
    isFlipping = false;
    console.error("Bet placement failed:", err);
  });
}

function cashOutProgressive() {
  if (currentCashoutPrize <= 0) return;
  alert(`অভিনন্দন! আপনি ৳${parseFloat(currentCashoutPrize).toFixed(2)} ক্যাশ আউট করেছেন।`);
  resetProgressiveState();
  syncState();
}

// Start State Poller
syncState();
setInterval(syncState, 3000);
</script>
</body>
</html>
