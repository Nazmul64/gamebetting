<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>1xBet — Under and Over 7</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800;900&family=Montserrat:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700;1,800;1,900&family=Roboto+Mono:wght@500;700;800&family=Roboto:ital,wght@0,500;0,700;0,900;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ============================================================
   1xBet OFFICIAL "UNDER AND OVER 7" PIXEL-PERFECT THEME
   ============================================================ */
:root {
  --bg-primary: #121929;
  --bg-darker: #0b111e;
  --gold-outer: #d4a04d;
  --gold-inner: #946827;
  --gold-accent: #f8be52;
  --green-active: #78c627;
  --green-btn-top: #88d728;
  --green-btn-bottom: #529c12;
  --text-white: #ffffff;
  --gold-text: #f0be52;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
  width: 100%;
  height: 100%;
  min-height: 100vh;
  background-color: var(--bg-darker);
  background: radial-gradient(circle at center, #1b263b 0%, #101828 55%, #080d16 100%);
  font-family: 'Montserrat', sans-serif;
  color: var(--text-white);
  overflow: hidden;
  user-select: none;
  -webkit-user-select: none;
  position: relative;
}

/* ================= FULLSCREEN GAME CONTAINER ================= */
.game-viewport {
  position: relative;
  width: 100vw;
  height: 100vh;
  max-width: 1920px;
  margin: 0 auto;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px 14px;
}

/* ================= BACKGROUND DECORATIONS ================= */
.bg-layer {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 1;
}

/* Rotating Animations for Gold Crosses (Floating & Rotating at Checked Positions) */
@keyframes spinRotateLeft {
  0% {
    transform: rotate(-10deg) translate(0px, 0px) scale(1);
  }
  50% {
    transform: rotate(8deg) translate(8px, -12px) scale(1.04);
  }
  100% {
    transform: rotate(-10deg) translate(0px, 0px) scale(1);
  }
}

@keyframes spinRotateRight {
  0% {
    transform: rotate(18deg) translate(0px, 0px) scale(1);
  }
  50% {
    transform: rotate(38deg) translate(-10px, -15px) scale(1.04);
  }
  100% {
    transform: rotate(18deg) translate(0px, 0px) scale(1);
  }
}

/* Big Gold Cross Upper Left - Moved Closer to Center as Checked */
.bg-cross-gold-left {
  position: absolute;
  top: 75px;
  left: 140px;
  width: 370px;
  height: 370px;
  background-image: url('{{ asset("under-and-over-7/dark-cross.24d1b55fa6a0.webp") }}');
  background-size: contain;
  background-repeat: no-repeat;
  opacity: 0.95;
  filter: drop-shadow(0 18px 35px rgba(0,0,0,0.75));
  animation: spinRotateLeft 16s ease-in-out infinite;
  transform-origin: center center;
}

/* Big Dark Cross In Middle Directly Behind Dice */
.bg-cross-dark-center {
  position: absolute;
  top: 46%;
  left: 50%;
  width: 700px;
  height: 700px;
  transform: translate(-50%, -50%) rotate(18deg);
  background-image: url('{{ asset("under-and-over-7/big-cross.034a6b6fc439.webp") }}');
  background-size: contain;
  background-repeat: no-repeat;
  opacity: 0.65;
  filter: blur(0.5px);
}

/* Big Gold Cross Lower Right - Moved Closer to Center as Checked */
.bg-cross-gold-right {
  position: absolute;
  bottom: 25px;
  right: 190px;
  width: 380px;
  height: 380px;
  background-image: url('{{ asset("under-and-over-7/dark-cross.24d1b55fa6a0.webp") }}');
  background-size: contain;
  background-repeat: no-repeat;
  opacity: 0.95;
  filter: drop-shadow(0 20px 40px rgba(0,0,0,0.85));
  animation: spinRotateRight 18s ease-in-out infinite;
  transform-origin: center center;
}

/* Floating 3D Dice */
.bg-float-dice-1 {
  position: absolute;
  top: 35px;
  left: 23%;
  width: 105px;
  opacity: 0.32;
  filter: blur(1.5px);
}
.bg-float-dice-2 {
  position: absolute;
  top: 25px;
  right: 30%;
  width: 125px;
  opacity: 0.32;
  filter: blur(1.8px);
}
.bg-float-dice-3 {
  position: absolute;
  bottom: 90px;
  left: 7%;
  width: 150px;
  opacity: 0.28;
  filter: blur(2px);
}
.bg-float-dice-4 {
  position: absolute;
  top: 44%;
  right: 11%;
  width: 120px;
  opacity: 0.32;
  filter: blur(1.2px);
}

/* ================= TOP ROW: BREADCRUMB & JACKPOT ================= */
.top-header-row {
  position: relative;
  z-index: 10;
  width: 100%;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 0 10px;
}

.breadcrumb-nav {
  font-size: 11px;
  font-weight: 700;
  color: #8fa5bf;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.breadcrumb-nav a {
  color: #8fa5bf;
  text-decoration: underline;
  cursor: pointer;
}
.breadcrumb-nav a:hover {
  color: #ffffff;
}
.breadcrumb-nav span {
  color: #c4d7ec;
}

/* Jackpot Badge */
.jackpot-box {
  background: radial-gradient(ellipse at center, #261b09 0%, #110c04 100%);
  border: 2px solid #ffcc00;
  border-radius: 6px;
  padding: 6px 36px;
  box-shadow: 0 0 18px rgba(255, 204, 0, 0.45), inset 0 0 8px rgba(255, 204, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  margin-right: 50px;
}
.jackpot-title {
  font-family: 'Cinzel', serif;
  font-size: 17px;
  font-weight: 900;
  color: #ffde59;
  letter-spacing: 2.5px;
  text-shadow: 0 0 10px rgba(255, 222, 89, 0.8), 0 0 20px rgba(234, 179, 8, 0.5);
}

/* ================= CENTER LOGO ================= */
.logo-center-wrap {
  position: relative;
  z-index: 10;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: -10px;
  margin-bottom: 2px;
}

.brand-logo-img {
  height: 84px;
  max-width: 180px;
  object-fit: contain;
  filter: drop-shadow(0 8px 20px rgba(0,0,0,0.8));
  cursor: pointer;
  transition: transform 0.2s;
}
.brand-logo-img:hover {
  transform: scale(1.03);
}

.how-to-play-text {
  font-size: 11px;
  font-weight: 700;
  font-style: italic;
  color: #9ab2cc;
  text-decoration: underline;
  cursor: pointer;
  letter-spacing: 0.5px;
  margin-top: -2px;
  transition: color 0.2s;
}
.how-to-play-text:hover {
  color: #ffd276;
}

/* ================= DICE CIRCLES STAGE (BIG & THICK FRAMES) ================= */
.dice-stage-row {
  position: relative;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 32px;
  margin-bottom: 6px;
}

/* Big, Thick & Rich 3D Gold Rings */
.dice-gold-circle {
  width: 280px;
  height: 280px;
  border-radius: 50%;
  background: radial-gradient(circle, #24190b 0%, #120c04 65%, #050401 100%) padding-box,
              linear-gradient(135deg, rgb(255, 235, 175) 0%, rgb(195, 145, 58) 28%, rgb(100, 68, 22) 50%, rgb(240, 195, 105) 75%, rgb(140, 95, 35) 100%) border-box;
  border: 24px solid transparent;
  box-shadow: 
    0 0 0 4px #2b1b08,
    0 28px 55px rgba(0, 0, 0, 0.95),
    inset 0 0 35px rgba(0,0,0,0.95),
    inset 0 6px 18px rgba(255, 235, 175, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  transition: box-shadow 0.2s;
}

.dice-gold-circle.rolling {
  box-shadow: 
    0 0 0 4px #7c541c,
    0 0 55px rgba(216, 160, 75, 0.85),
    inset 0 0 35px rgba(0,0,0,0.95);
}

.dice-canvas {
  width: 195px;
  height: 195px;
  display: block;
}

/* ================= RESULT BANNER (LOSS / WIN OVERLAY) ================= */
.outcome-banner-wrap {
  position: absolute;
  top: 52%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0.85);
  z-index: 35;
  pointer-events: none;
  opacity: 0;
  transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.outcome-banner-wrap.visible {
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
}

.loss-popup-box {
  background: rgba(18, 25, 38, 0.96);
  border: 1px solid #33445e;
  border-radius: 8px;
  padding: 10px 42px;
  text-align: center;
  min-width: 380px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.9);
}
.loss-popup-box .loss-head {
  color: #ff9d00;
  font-size: 13.5px;
  font-weight: 800;
  font-style: italic;
  letter-spacing: 1px;
  text-transform: uppercase;
}
.loss-popup-box .loss-sub {
  color: #ffffff;
  font-size: 18px;
  font-weight: 900;
  font-style: italic;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin-top: 2px;
}

.win-popup-box {
  background: radial-gradient(ellipse at center, rgba(30, 48, 12, 0.97) 0%, rgba(12, 22, 5, 0.98) 100%);
  border: 2px solid #84cc16;
  border-radius: 8px;
  padding: 12px 48px;
  text-align: center;
  min-width: 380px;
  box-shadow: 0 0 35px rgba(132, 204, 22, 0.6), 0 15px 40px rgba(0, 0, 0, 0.9);
}
.win-popup-box .win-head {
  color: #bef264;
  font-size: 14px;
  font-weight: 900;
  letter-spacing: 1.5px;
  text-transform: uppercase;
}
.win-popup-box .win-val {
  color: #ffffff;
  font-size: 26px;
  font-weight: 900;
  font-family: 'Roboto Mono', monospace;
  margin-top: 3px;
  text-shadow: 0 0 12px #a3e635;
}

/* ================= 3 MULTIPLIER BUTTONS (OVER, EQUAL, UNDER) ================= */
.multipliers-panel {
  position: relative;
  z-index: 10;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  width: 100%;
  max-width: 560px;
  background: rgba(18, 25, 38, 0.88);
  border: 1px solid #233550;
  border-radius: 10px;
  padding: 8px 10px 10px;
  margin-bottom: 8px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

.mult-tab {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  padding: 2px;
  border-radius: 8px;
  transition: all 0.15s;
}

.mult-pill {
  width: 100%;
  background: #111a2a;
  border: 1.5px solid #263852;
  border-radius: 6px;
  padding: 6px 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.15s;
}

.mult-tab.selected .mult-pill {
  border: 1.5px solid #84cc16;
  box-shadow: 0 0 12px rgba(132, 204, 22, 0.5), inset 0 0 8px rgba(132, 204, 22, 0.2);
  background: #13273e;
}

/* Exact 1xBet Gold Coin Circle */
.coin-dot {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: rgb(0, 0, 0);
  background-image: linear-gradient(rgb(134, 100, 50) 0%, rgb(255, 228, 158) 51%, rgb(135, 100, 49) 100%);
  border: 3px solid rgb(20, 20, 20);
  box-shadow: rgba(255, 247, 214, 0.6) 0px 2px 0px 0px inset;
  display: inline-block;
  box-sizing: border-box;
  flex-shrink: 0;
}

.mult-tab.selected .coin-dot {
  background-image: linear-gradient(rgb(74, 120, 20) 0%, rgb(217, 249, 157) 51%, rgb(82, 156, 18) 100%);
  border-color: rgb(15, 30, 8);
  box-shadow: rgba(217, 249, 157, 0.8) 0px 2px 0px 0px inset, 0 0 8px #84cc16;
}

.mult-rate-text {
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  font-weight: 900;
  font-style: italic;
  color: #ffffff;
  letter-spacing: 0.3px;
}

.mult-label-text {
  margin-top: 6px;
  font-size: 11px;
  font-weight: 900;
  font-style: italic;
  display: flex;
  align-items: center;
  gap: 5px;
  letter-spacing: 0.4px;
}

.label-title {
  color: #f5b73d;
}
.label-arrow {
  color: #f5b73d;
  font-size: 11px;
}
.label-nums {
  color: #ffffff;
  font-style: normal;
  font-weight: 800;
}

/* ================= EXACT 1xBet QUICK STAKE CAPSULE (20, 100, 300, 800, 3000, 10000) ================= */
.quick-stake-capsule {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 440px;
  height: 42px;
  background-color: rgb(33, 40, 49);
  background-image: linear-gradient(rgb(134, 100, 50) 0%, rgb(255, 228, 158) 51%, rgb(135, 100, 49) 100%);
  border: 2px solid rgb(4, 6, 6);
  border-radius: 40px;
  box-shadow: rgba(255, 247, 214, 0.6) 0px 2px 0px 0px inset, 0 6px 18px rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 2px;
  margin-bottom: 8px;
}

.quick-stake-inner {
  width: 100%;
  height: 100%;
  background: #101826;
  border-radius: 38px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 10px;
}

.stake-chip {
  flex: 1;
  background: transparent;
  border: none;
  color: #ffffff;
  font-family: 'Montserrat', sans-serif;
  font-size: 13.5px;
  font-weight: 900;
  font-style: italic;
  cursor: pointer;
  padding: 4px 0;
  text-align: center;
  transition: color 0.15s, transform 0.1s;
}
.stake-chip:hover {
  color: #ffd573;
}
.stake-chip.active {
  color: #ffd573;
  text-shadow: 0 0 6px rgba(255, 213, 115, 0.6);
}

.chip-sep {
  width: 1px;
  height: 16px;
  background: #3e2d14;
}

/* ================= BOTTOM ACTION CONTROLS ================= */
.bottom-controls-row {
  position: relative;
  z-index: 10;
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  max-width: 440px;
}

/* Stake Input Pill with Exact Gold Gradient Border */
.stake-input-pill {
  flex: 1;
  height: 48px;
  background-color: rgb(33, 40, 49);
  background-image: linear-gradient(rgb(134, 100, 50) 0%, rgb(255, 228, 158) 51%, rgb(135, 100, 49) 100%);
  border: 2px solid rgb(4, 6, 6);
  border-radius: 40px;
  box-shadow: rgba(255, 247, 214, 0.6) 0px 2px 0px 0px inset, 0 6px 18px rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  padding: 2px;
}

.stake-input-inner {
  width: 100%;
  height: 100%;
  background: #101826;
  border-radius: 38px;
  display: flex;
  align-items: center;
  padding: 0 6px 0 16px;
}

.stake-text-field {
  width: 100%;
  background: transparent;
  border: none;
  outline: none;
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  font-weight: 800;
  font-style: italic;
  color: #ffffff;
}

.btn-clear-stake {
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 15px;
  width: 32px;
  height: 32px;
  color: #94a3b8;
  font-size: 12px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.15s;
}
.btn-clear-stake:hover {
  background: #334155;
  color: #fff;
}

/* Exact 1xBet PLACE A BET Button */
.btn-place-bet {
  flex: 1.35;
  height: 48px;
  background-image: url('{{ asset("under-and-over-7/ba7-btn-bg@1x.f6642255444a.png") }}');
  background-size: 100% 100%;
  background-repeat: no-repeat;
  background-color: transparent;
  border: none;
  border-radius: 25px;
  color: #ffffff;
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  font-weight: 900;
  font-style: italic;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  cursor: pointer;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
  transition: all 0.15s ease-in-out;
  display: flex;
  align-items: center;
  justify-content: center;
  text-shadow: 0 1px 3px rgba(0,0,0,0.6);
}

.btn-place-bet:hover:not(:disabled) {
  transform: translateY(-2px) scale(1.02);
  filter: brightness(1.1);
  box-shadow: 0 8px 25px rgba(120, 198, 39, 0.5);
}

.btn-place-bet:active:not(:disabled) {
  transform: translateY(1px) scale(0.98);
  filter: brightness(0.95);
}

.btn-place-bet:disabled {
  filter: grayscale(0.8) brightness(0.6);
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* ================= RIGHT TOOLBAR ================= */
.sidebar-right-menu {
  position: fixed;
  right: 0;
  top: 48%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  background: #09121f;
  border: 1px solid #142033;
  border-right: none;
  border-radius: 6px 0 0 6px;
  padding: 4px 2px;
  z-index: 40;
}

.side-btn {
  background: transparent;
  border: none;
  color: #7b93ae;
  width: 34px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 14px;
  transition: color 0.15s, background 0.15s;
  border-radius: 4px;
}
.side-btn:hover {
  color: #38bdf8;
  background: #0f1c30;
}
.side-btn.num-seven {
  font-weight: 900;
  font-family: 'Cinzel', serif;
  font-size: 15px;
  color: #cbd5e1;
}

/* Support Headphones Icon Bottom Right */
.btn-support-headphone {
  position: fixed;
  bottom: 12px;
  right: 12px;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #0088cc;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  cursor: pointer;
  z-index: 40;
  box-shadow: 0 2px 8px rgba(0, 136, 204, 0.4);
}

/* ================= FLOATING DEMO MODE PILL & POPUP ================= */
.demo-bottom-pill {
  position: fixed;
  bottom: 24px;
  right: 60px;
  z-index: 40;
  background: #092a48;
  border: 1px solid #134673;
  border-radius: 6px;
  padding: 5px 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-weight: 800;
  color: #ffffff;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(0,0,0,0.6);
  transition: all 0.2s;
}
.demo-bottom-pill .yellow-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #84cc16;
}

.demo-drawer-card {
  position: fixed;
  bottom: 24px;
  right: 60px;
  z-index: 45;
  background: rgba(9, 26, 46, 0.97);
  border: 1px solid #1c4470;
  border-radius: 8px;
  padding: 14px 16px;
  width: 230px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.8);
  display: none;
  backdrop-filter: blur(8px);
}

.demo-drawer-card.open {
  display: block;
}

.demo-drawer-header {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  font-weight: 800;
  color: #ffffff;
}

.demo-info-row {
  margin-top: 8px;
  font-size: 11.5px;
  display: flex;
  justify-content: space-between;
}
.demo-info-label { color: #8da4be; }
.demo-info-num { font-family: 'Roboto Mono', monospace; font-weight: 800; color: #fff; }
.demo-info-num.green { color: #4ade80; }

.demo-note-text {
  font-size: 9.5px;
  color: #5c7594;
  margin-top: 8px;
  line-height: 1.3;
}

.btn-exit-demo {
  width: 100%;
  margin-top: 10px;
  background: #0284c7;
  border: none;
  border-radius: 5px;
  color: #fff;
  font-size: 11px;
  font-weight: 800;
  padding: 6px;
  cursor: pointer;
  text-transform: uppercase;
}
.btn-exit-demo:hover { background: #0369a1; }

.demo-collapse-link {
  display: block;
  text-align: center;
  font-size: 10px;
  color: #0284c7;
  margin-top: 6px;
  cursor: pointer;
}

/* ================= RULES MODAL ================= */
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.75);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s ease;
}
.modal-backdrop.open {
  opacity: 1;
  pointer-events: auto;
}

.rules-card {
  background: #0d1b2e;
  border: 1px solid #204068;
  border-radius: 12px;
  width: 90%;
  max-width: 500px;
  padding: 24px;
  position: relative;
  box-shadow: 0 20px 50px rgba(0,0,0,0.9);
}

.close-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: #162a45;
  border: 1px solid #2d4c75;
  color: #8da4be;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.close-btn:hover { color: #fff; }

/* Responsive adjustments */
@media (max-height: 720px) {
  .brand-logo-img { height: 70px; }
  .dice-gold-circle { width: 210px; height: 210px; border-width: 12px; }
  .dice-canvas { width: 150px; height: 150px; }
  .bg-cross-gold-left, .bg-cross-gold-right { width: 240px; height: 240px; }
}

@media (max-width: 768px) {
  .dice-stage-row { gap: 16px; }
  .dice-gold-circle { width: 160px; height: 160px; border-width: 10px; }
  .dice-canvas { width: 110px; height: 110px; }
  .jackpot-box { display: none; }
  .multipliers-panel { max-width: 95%; }
  .bottom-controls-row { max-width: 95%; }
  .quick-stake-capsule { max-width: 95%; }
}
</style>
</head>

<body>

<div class="game-viewport">

  <!-- Background Layer -->
  <div class="bg-layer">
    <div class="bg-cross-gold-left"></div>
    <div class="bg-cross-dark-center"></div>
    <div class="bg-cross-gold-right"></div>
    <img src="{{ asset('under-and-over-7/dice1.541744f91072.webp') }}" class="bg-float-dice-1" alt="Dice">
    <img src="{{ asset('under-and-over-7/dice4.623aac03544f.webp') }}" class="bg-float-dice-2" alt="Dice">
    <img src="{{ asset('under-and-over-7/dice3.af179fc55d1d.webp') }}" class="bg-float-dice-3" alt="Dice">
    <img src="{{ asset('under-and-over-7/dice2.ce851e5a59ee.webp') }}" class="bg-float-dice-4" alt="Dice">
  </div>

  <!-- Top Header Row (Breadcrumbs & Jackpot) -->
  <div class="top-header-row">
    <div class="breadcrumb-nav">
      <a href="{{ route('dashboard') }}">1XGAMES</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">DICE</a>
      <span>/</span>
      <span>UNDER AND OVER 7</span>
    </div>

    <div class="jackpot-box" onclick="openRules()">
      <span class="jackpot-title">JACKPOT</span>
    </div>
  </div>

  <!-- Center Logo -->
  <div class="logo-center-wrap">
    <img src="{{ asset('under-and-over-7/logo.png') }}" class="brand-logo-img" alt="Under and Over 7" onclick="openRules()">
    <span class="how-to-play-text" onclick="openRules()">HOW TO PLAY</span>
  </div>

  <!-- Dice Stage -->
  <div class="dice-stage-row">
    <!-- Die 1 -->
    <div class="dice-gold-circle" id="die-box-1">
      <canvas id="canvas-die-1" class="dice-canvas" width="300" height="300"></canvas>
    </div>

    <!-- Die 2 -->
    <div class="dice-gold-circle" id="die-box-2">
      <canvas id="canvas-die-2" class="dice-canvas" width="300" height="300"></canvas>
    </div>

    <!-- Outcome Alert Banner -->
    <div class="outcome-banner-wrap" id="outcome-banner">
      <!-- Injected via JS -->
    </div>
  </div>

  <!-- Multipliers Selectors Panel -->
  <div class="multipliers-panel">
    <!-- OVER -->
    <div class="mult-tab selected" id="tab-over" onclick="pickChoice('over')">
      <div class="mult-pill">
        <span class="coin-dot"></span>
        <span class="mult-rate-text">x {{ number_format($settings->over_multiplier ?? 2.3, 1) }}</span>
      </div>
      <div class="mult-label-text">
        <span class="label-title">OVER</span>
        <span class="label-arrow">➔</span>
        <span class="label-nums">8 9 10 11 12</span>
      </div>
    </div>

    <!-- EQUAL -->
    <div class="mult-tab" id="tab-equal" onclick="pickChoice('equal')">
      <div class="mult-pill">
        <span class="coin-dot"></span>
        <span class="mult-rate-text">x {{ number_format($settings->equal_multiplier ?? 5.8, 1) }}</span>
      </div>
      <div class="mult-label-text">
        <span class="label-title">EQUAL</span>
        <span class="label-arrow">➔</span>
        <span class="label-nums">7</span>
      </div>
    </div>

    <!-- UNDER -->
    <div class="mult-tab" id="tab-under" onclick="pickChoice('under')">
      <div class="mult-pill">
        <span class="coin-dot"></span>
        <span class="mult-rate-text">x {{ number_format($settings->under_multiplier ?? 2.3, 1) }}</span>
      </div>
      <div class="mult-label-text">
        <span class="label-title">UNDER</span>
        <span class="label-arrow">➔</span>
        <span class="label-nums">2 3 4 5 6</span>
      </div>
    </div>
  </div>

  <!-- Quick Stake Capsule (20, 100, 300, 800, 3000, 10000) -->
  <div class="quick-stake-capsule">
    <div class="quick-stake-inner">
      <button class="stake-chip active" onclick="setQuickStake(20, this)">20</button>
      <div class="chip-sep"></div>
      <button class="stake-chip" onclick="setQuickStake(100, this)">100</button>
      <div class="chip-sep"></div>
      <button class="stake-chip" onclick="setQuickStake(300, this)">300</button>
      <div class="chip-sep"></div>
      <button class="stake-chip" onclick="setQuickStake(800, this)">800</button>
      <div class="chip-sep"></div>
      <button class="stake-chip" onclick="setQuickStake(3000, this)">3000</button>
      <div class="chip-sep"></div>
      <button class="stake-chip" onclick="setQuickStake(10000, this)">10000</button>
    </div>
  </div>

  <!-- Bottom Action Row -->
  <div class="bottom-controls-row">
    <div class="stake-input-pill">
      <div class="stake-input-inner">
        <input type="number" id="stake-field" class="stake-text-field" value="20" min="0.1" max="50000" step="1" oninput="onStakeInput()">
        <button class="btn-clear-stake" onclick="clearStakeVal()" title="Clear">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>

    <button class="btn-place-bet" id="btn-place-bet" onclick="executeBet()">
      PLACE A BET
    </button>
  </div>

</div>

<!-- Right Sidebar Menu -->
<aside class="sidebar-right-menu">
  <button class="side-btn" onclick="openRules()" title="Settings"><i class="fas fa-cog"></i></button>
  <button class="side-btn" onclick="openRules()" title="Bonuses"><i class="fas fa-gift"></i></button>
  <button class="side-btn num-seven" onclick="openRules()" title="7 Rules">7</button>
  <button class="side-btn" onclick="openRules()" title="Jackpot"><i class="fas fa-dharmachakra"></i></button>
  <button class="side-btn" onclick="openRules()" title="Deposit"><i class="fas fa-dollar-sign"></i></button>
</aside>

<!-- Support Headphone Button -->
<div class="btn-support-headphone" onclick="openRules()" title="Support">
  <i class="fas fa-headset"></i>
</div>

<!-- Floating Demo Mode Pill -->
<div class="demo-bottom-pill" id="demo-pill" onclick="openDemoDrawer()">
  <span class="yellow-dot"></span>
  <span>DEMO MODE &raquo;</span>
</div>

<!-- Demo Mode Drawer Popup -->
<div class="demo-drawer-card" id="demo-drawer">
  <div class="demo-drawer-header">
    <span class="yellow-dot"></span>
    <span id="demo-drawer-title">Demo mode</span>
  </div>
  <div class="demo-info-row">
    <span class="demo-info-label">Balance (EUR) *</span>
    <span class="demo-info-num" id="demo-bal-text">100.00</span>
  </div>
  <div class="demo-info-row">
    <span class="demo-info-label">Total winnings</span>
    <span class="demo-info-num green" id="demo-win-text">0.00</span>
  </div>
  <div class="demo-note-text">
    * This is a demo account; to win real money you'll need to exit demo mode. Demo balance refreshes regularly.
  </div>
  <button class="btn-exit-demo" id="btn-demo-mode-toggle" onclick="toggleDemoModeAction()">
    {{ auth()->check() ? 'EXIT DEMO MODE' : 'DEMO ACTIVE' }}
  </button>
  <span class="demo-collapse-link" onclick="closeDemoDrawer()">Collapse &laquo;</span>
</div>

<!-- How To Play Modal -->
<div class="modal-backdrop" id="rules-popup" onclick="if(event.target===this) closeRules()">
  <div class="rules-card">
    <button class="close-btn" onclick="closeRules()"><i class="fas fa-times"></i></button>
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
      <i class="fas fa-dice" style="color:#eab308; font-size:22px;"></i>
      <h3 style="font-size:18px; font-weight:800; color:#fff;">HOW TO PLAY — UNDER AND OVER 7</h3>
    </div>
    <div style="font-size:13px; color:#cbd5e1; line-height:1.6; display:flex; flex-direction:column; gap:10px;">
      <p>1. Choose your bet before throwing the two dice:</p>
      <div style="background:#09121f; padding:12px; border-radius:8px; border:1px solid #1a2a44; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; justify-content:space-between;">
          <span style="color:#ffd573; font-weight:700;">OVER (8 to 12):</span>
          <span style="color:#4ade80; font-weight:800;">x {{ number_format($settings->over_multiplier ?? 2.3, 1) }}</span>
        </div>
        <div style="display:flex; justify-content:space-between;">
          <span style="color:#ffd573; font-weight:700;">EQUAL (Exact 7):</span>
          <span style="color:#4ade80; font-weight:800;">x {{ number_format($settings->equal_multiplier ?? 5.8, 1) }}</span>
        </div>
        <div style="display:flex; justify-content:space-between;">
          <span style="color:#ffd573; font-weight:700;">UNDER (2 to 6):</span>
          <span style="color:#4ade80; font-weight:800;">x {{ number_format($settings->under_multiplier ?? 2.3, 1) }}</span>
        </div>
      </div>
      <p>2. Select your stake amount and press <strong>"PLACE A BET"</strong>.</p>
      <p>3. If the sum of both dice matches your prediction, your stake is multiplied by the corresponding coefficient and added to your balance!</p>
    </div>
  </div>
</div>

<!-- ================= GAME SCRIPT ENGINE ================= -->
<script>
const IS_AUTH = {{ auth()->check() ? 'true' : 'false' }};
let isDemo = !IS_AUTH;
let realBalance = {{ auth()->check() ? (float)auth()->user()->balance : 0.00 }};
let demoBalance = parseFloat(localStorage.getItem('uo7_demo_balance') || '100.00');
let demoWinnings = parseFloat(localStorage.getItem('uo7_demo_winnings') || '0.00');

let chosenBet = 'over'; // 'under', 'equal', 'over'
let currentStake = 20.00;
let isBusyRolling = false;

// Sprites Base
const BASE_PATH = "{{ asset('under-and-over-7') }}";
const SPRITES = {
  hold1: `${BASE_PATH}/hold_1@1x.3e7c7fdce7cf.png`,
  hold2: `${BASE_PATH}/hold_2@1x.4bfd7e1924e1.png`,
  start1: `${BASE_PATH}/start_1@1x.f678f21030d6.png`,
  start2: `${BASE_PATH}/start_2@1x.c6a5059cefe1.png`,
  start3: `${BASE_PATH}/start_3@1x.2084f5d3edf3.png`,
  start4: `${BASE_PATH}/start_4@1x.1b2b15b7d3f2.png`,
  start5: `${BASE_PATH}/start_5@1x.7dadbf95ed84.png`,
  start6: `${BASE_PATH}/start_6@1x.e53d249d28cc.png`,
};

const c1 = document.getElementById('canvas-die-1');
const ctx1 = c1.getContext('2d');
const c2 = document.getElementById('canvas-die-2');
const ctx2 = c2.getContext('2d');

const imgCache = {};
let loadedCount = 0;
const totalAssets = Object.keys(SPRITES).length;

// Idle Loop State
let idleAnimFrame = null;
let idleF1 = 0;
let idleF2 = 14; // offset for natural asynchronous floating rotation
let lastIdleTick = 0;
const IDLE_FRAME_INTERVAL = 38; // ~26 fps smooth idle spin
let resultResumeTimeout = null;

function initAssets() {
  Object.keys(SPRITES).forEach(k => {
    const im = new Image();
    im.src = SPRITES[k];
    im.onload = () => {
      imgCache[k] = im;
      loadedCount++;
      if (k === 'hold1' || k === 'hold2' || loadedCount === totalAssets) {
        startIdleLoop();
      }
    };
  });
}
initAssets();

function startIdleLoop() {
  if (idleAnimFrame) return;
  lastIdleTick = performance.now();
  runIdleAnimation(lastIdleTick);
}

function stopIdleLoop() {
  if (idleAnimFrame) {
    cancelAnimationFrame(idleAnimFrame);
    idleAnimFrame = null;
  }
}

function runIdleAnimation(time) {
  if (isBusyRolling) return;

  if (time - lastIdleTick >= IDLE_FRAME_INTERVAL) {
    lastIdleTick = time;
    const h1 = imgCache['hold1'];
    const h2 = imgCache['hold2'];

    if (h1 && h1.complete) {
      drawSprite(ctx1, h1, idleF1, 50);
      idleF1 = (idleF1 + 1) % 50;
    }
    if (h2 && h2.complete) {
      drawSprite(ctx2, h2, idleF2, 50);
      idleF2 = (idleF2 + 1) % 50;
    }
  }

  idleAnimFrame = requestAnimationFrame(runIdleAnimation);
}

/* ================= WEB AUDIO ENGINE ================= */
let webAudio = null;
function getAudio() {
  if (!webAudio) {
    webAudio = new (window.AudioContext || window.webkitAudioContext)();
  }
  if (webAudio.state === 'suspended') webAudio.resume();
  return webAudio;
}

function triggerSfx(name) {
  try {
    const actx = getAudio();
    const t = actx.currentTime;

    if (name === 'tap') {
      const osc = actx.createOscillator();
      const g = actx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(700, t);
      osc.frequency.exponentialRampToValueAtTime(350, t + 0.04);
      g.gain.setValueAtTime(0.2, t);
      g.gain.exponentialRampToValueAtTime(0.01, t + 0.04);
      osc.connect(g);
      g.connect(actx.destination);
      osc.start(t);
      osc.stop(t + 0.04);
    } else if (name === 'rattle') {
      const bSize = actx.sampleRate * 0.12;
      const buf = actx.createBuffer(1, bSize, actx.sampleRate);
      const out = buf.getChannelData(0);
      for (let i = 0; i < bSize; i++) out[i] = (Math.random() * 2 - 1) * 0.25;
      const src = actx.createBufferSource();
      src.buffer = buf;
      const f = actx.createBiquadFilter();
      f.type = 'bandpass';
      f.frequency.setValueAtTime(1400, t);
      const g = actx.createGain();
      g.gain.setValueAtTime(0.3, t);
      g.gain.exponentialRampToValueAtTime(0.01, t + 0.12);
      src.connect(f);
      f.connect(g);
      g.connect(actx.destination);
      src.start(t);
    } else if (name === 'impact') {
      const osc = actx.createOscillator();
      const g = actx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(160, t);
      osc.frequency.exponentialRampToValueAtTime(45, t + 0.1);
      g.gain.setValueAtTime(0.35, t);
      g.gain.exponentialRampToValueAtTime(0.01, t + 0.1);
      osc.connect(g);
      g.connect(actx.destination);
      osc.start(t);
      osc.stop(t + 0.1);
    } else if (name === 'win') {
      [523.25, 659.25, 783.99, 1046.50].forEach((freq, idx) => {
        const osc = actx.createOscillator();
        const g = actx.createGain();
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, t + idx * 0.07);
        g.gain.setValueAtTime(0.2, t + idx * 0.07);
        g.gain.exponentialRampToValueAtTime(0.01, t + idx * 0.07 + 0.45);
        osc.connect(g);
        g.connect(actx.destination);
        osc.start(t + idx * 0.07);
        osc.stop(t + idx * 0.07 + 0.45);
      });
    } else if (name === 'loss') {
      const osc = actx.createOscillator();
      const g = actx.createGain();
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(240, t);
      osc.frequency.exponentialRampToValueAtTime(120, t + 0.2);
      g.gain.setValueAtTime(0.15, t);
      g.gain.exponentialRampToValueAtTime(0.01, t + 0.2);
      osc.connect(g);
      g.connect(actx.destination);
      osc.start(t);
      osc.stop(t + 0.2);
    }
  } catch (e) {}
}

/* ================= DIE RENDERING (SPRITE & CANVAS) ================= */
function drawSprite(ctx, img, frameIdx, maxFrames) {
  if (!img || !img.complete) return;
  const fw = 300, fh = 300;
  const safeIdx = Math.min(Math.max(0, frameIdx), maxFrames - 1);
  ctx.clearRect(0, 0, 300, 300);
  ctx.drawImage(img, 0, safeIdx * fh, fw, fh, 0, 0, 300, 300);
}

function drawDieFace(ctx, val) {
  const spr = imgCache[`start${val}`];
  if (spr && spr.complete) {
    drawSprite(ctx, spr, 25, 26);
    return;
  }

  // Pure vector fallback
  ctx.clearRect(0, 0, 300, 300);
  ctx.save();
  const rad = 42;
  const x = 32, y = 32, w = 236, h = 236;

  const grad = ctx.createRadialGradient(150, 140, 20, 150, 150, 140);
  grad.addColorStop(0, '#ffffff');
  grad.addColorStop(0.85, '#edf1f5');
  grad.addColorStop(1, '#c5ccd6');

  ctx.fillStyle = grad;
  ctx.shadowColor = 'rgba(0,0,0,0.55)';
  ctx.shadowBlur = 16;
  ctx.shadowOffsetY = 8;

  ctx.beginPath();
  ctx.moveTo(x + rad, y);
  ctx.lineTo(x + w - rad, y);
  ctx.quadraticCurveTo(x + w, y, x + w, y + rad);
  ctx.lineTo(x + w, y + h - rad);
  ctx.quadraticCurveTo(x + w, y + h, x + w - rad, y + h);
  ctx.lineTo(x + rad, y + h);
  ctx.quadraticCurveTo(x, y + h, x, y + h - rad);
  ctx.lineTo(x, y + rad);
  ctx.quadraticCurveTo(x, y, x + rad, y);
  ctx.closePath();
  ctx.fill();

  ctx.shadowBlur = 0;
  ctx.shadowOffsetY = 0;
  ctx.strokeStyle = '#a6b1bd';
  ctx.lineWidth = 3;
  ctx.stroke();

  const dot = '#1d232c';
  const r = 16;
  const P = {
    tl: [85, 85], tr: [215, 85],
    ml: [85, 150], mc: [150, 150], mr: [215, 150],
    bl: [85, 215], br: [215, 215]
  };

  const p = (xy) => {
    ctx.beginPath();
    ctx.fillStyle = dot;
    ctx.arc(xy[0], xy[1], r, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.fillStyle = 'rgba(255,255,255,0.3)';
    ctx.arc(xy[0] - 3, xy[1] - 3, r * 0.35, 0, Math.PI * 2);
    ctx.fill();
  };

  if (val === 1) p(P.mc);
  else if (val === 2) { p(P.tl); p(P.br); }
  else if (val === 3) { p(P.tl); p(P.mc); p(P.br); }
  else if (val === 4) { p(P.tl); p(P.tr); p(P.bl); p(P.br); }
  else if (val === 5) { p(P.tl); p(P.tr); p(P.mc); p(P.bl); p(P.br); }
  else if (val === 6) { p(P.tl); p(P.tr); p(P.ml); p(P.mr); p(P.bl); p(P.br); }

  ctx.restore();
}

function runRollAnimation(d1, d2, callback) {
  if (resultResumeTimeout) {
    clearTimeout(resultResumeTimeout);
    resultResumeTimeout = null;
  }

  isBusyRolling = true;
  stopIdleLoop();

  document.getElementById('die-box-1').classList.add('rolling');
  document.getElementById('die-box-2').classList.add('rolling');
  hideBanner();

  const dur = 1400;
  const start = performance.now();
  const rattleTimer = setInterval(() => triggerSfx('rattle'), 160);

  let h1 = imgCache['hold1'];
  let h2 = imgCache['hold2'];
  let f1 = Math.floor(Math.random() * 50);
  let f2 = Math.floor(Math.random() * 50);

  function loop(now) {
    const elapsed = now - start;
    if (elapsed < dur) {
      f1 = (f1 + 2) % 50;
      f2 = (f2 + 2) % 50;

      if (h1 && h1.complete) drawSprite(ctx1, h1, f1, 50);
      else drawDieFace(ctx1, Math.floor(Math.random() * 6) + 1);

      if (h2 && h2.complete) drawSprite(ctx2, h2, f2, 50);
      else drawDieFace(ctx2, Math.floor(Math.random() * 6) + 1);

      requestAnimationFrame(loop);
    } else {
      clearInterval(rattleTimer);
      triggerSfx('impact');
      runLanding(d1, d2, callback);
    }
  }
  requestAnimationFrame(loop);
}

function runLanding(d1, d2, callback) {
  let step = 0;
  const s1 = imgCache[`start${d1}`];
  const s2 = imgCache[`start${d2}`];

  const timer = setInterval(() => {
    step++;
    if (step < 26) {
      if (s1 && s1.complete) drawSprite(ctx1, s1, step, 26);
      if (s2 && s2.complete) drawSprite(ctx2, s2, step, 26);
    } else {
      clearInterval(timer);
      document.getElementById('die-box-1').classList.remove('rolling');
      document.getElementById('die-box-2').classList.remove('rolling');
      drawDieFace(ctx1, d1);
      drawDieFace(ctx2, d2);
      isBusyRolling = false;
      if (callback) callback();

      // Resume idle spinning animation after 3.2s of displaying result
      resultResumeTimeout = setTimeout(() => {
        if (!isBusyRolling) {
          startIdleLoop();
        }
      }, 3200);
    }
  }, 28);
}

/* ================= UI INTERACTIONS ================= */
function pickChoice(c) {
  if (isBusyRolling) return;
  triggerSfx('tap');
  chosenBet = c;

  document.querySelectorAll('.mult-tab').forEach(t => t.classList.remove('selected'));
  const el = document.getElementById(`tab-${c}`);
  if (el) el.classList.add('selected');
}

function setQuickStake(val, btn) {
  if (isBusyRolling) return;
  triggerSfx('tap');
  currentStake = parseFloat(val);
  document.getElementById('stake-field').value = currentStake;

  document.querySelectorAll('.stake-chip').forEach(c => c.classList.remove('active'));
  if (btn) btn.classList.add('active');
}

function onStakeInput() {
  const v = parseFloat(document.getElementById('stake-field').value);
  if (!isNaN(v) && v > 0) currentStake = v;
  document.querySelectorAll('.stake-chip').forEach(c => {
    if (parseFloat(c.innerText) === currentStake) {
      c.classList.add('active');
    } else {
      c.classList.remove('active');
    }
  });
}

function clearStakeVal() {
  triggerSfx('tap');
  document.getElementById('stake-field').value = '';
  document.getElementById('stake-field').focus();
}

function refreshBalances() {
  if (isDemo || !IS_AUTH) {
    document.getElementById('demo-bal-text').innerText = demoBalance.toFixed(2);
    document.getElementById('demo-win-text').innerText = demoWinnings.toFixed(2);
    localStorage.setItem('uo7_demo_balance', demoBalance.toFixed(2));
    localStorage.setItem('uo7_demo_winnings', demoWinnings.toFixed(2));
  }
}
refreshBalances();

function openDemoDrawer() {
  triggerSfx('tap');
  document.getElementById('demo-drawer').classList.add('open');
}

function closeDemoDrawer() {
  triggerSfx('tap');
  document.getElementById('demo-drawer').classList.remove('open');
}

function toggleDemoModeAction() {
  if (!IS_AUTH) {
    alert('Please register or log in to switch to real money mode.');
    return;
  }
  isDemo = !isDemo;
  triggerSfx('tap');
  const btn = document.getElementById('btn-demo-mode-toggle');
  const pill = document.getElementById('demo-pill');
  if (isDemo) {
    btn.innerText = 'EXIT DEMO MODE';
    pill.style.display = 'flex';
  } else {
    btn.innerText = 'ENTER DEMO MODE';
    pill.style.display = 'none';
  }
  refreshBalances();
}

function showBanner(isWin, winAmt) {
  const banner = document.getElementById('outcome-banner');
  if (isWin) {
    triggerSfx('win');
    banner.innerHTML = `
      <div class="win-popup-box">
        <div class="win-head">CONGRATULATIONS!</div>
        <div class="win-val">+ €${parseFloat(winAmt).toFixed(2)}</div>
      </div>
    `;
  } else {
    triggerSfx('loss');
    banner.innerHTML = `
      <div class="loss-popup-box">
        <div class="loss-head">BETTER LUCK NEXT TIME</div>
        <div class="loss-sub">TRY AGAIN!</div>
      </div>
    `;
  }
  banner.classList.add('visible');
}

function hideBanner() {
  document.getElementById('outcome-banner').classList.remove('visible');
}

/* ================= PLACE BET SERVER REQUEST ================= */
async function executeBet() {
  if (isBusyRolling) return;

  const stake = parseFloat(document.getElementById('stake-field').value);
  if (isNaN(stake) || stake <= 0) {
    alert('Please enter a valid stake amount.');
    return;
  }

  if (!isDemo && IS_AUTH) {
    if (realBalance < stake) {
      alert('Insufficient wallet balance. Please deposit to continue.');
      return;
    }
  } else {
    if (demoBalance < stake) {
      demoBalance = 100.00;
      refreshBalances();
    }
  }

  const btn = document.getElementById('btn-place-bet');
  btn.disabled = true;

  try {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const res = await fetch("{{ route('underover.bet') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        choice: chosenBet,
        amount: stake,
        is_demo: isDemo
      })
    });

    const data = await res.json();
    if (!data.success) {
      alert(data.error || 'Bet placement failed.');
      btn.disabled = false;
      return;
    }

    if (isDemo) {
      demoBalance -= stake;
      refreshBalances();
    }

    runRollAnimation(data.die1, data.die2, () => {
      if (data.is_win) {
        if (isDemo) {
          demoBalance += data.win_amount;
          demoWinnings += data.win_amount;
        } else if (data.new_balance !== undefined) {
          realBalance = data.new_balance;
        }
      } else {
        if (!isDemo && data.new_balance !== undefined) {
          realBalance = data.new_balance;
        }
      }

      refreshBalances();
      showBanner(data.is_win, data.win_amount);
      btn.disabled = false;
    });

  } catch (e) {
    console.error(e);
    alert('Network error.');
    btn.disabled = false;
  }
}

function openRules() {
  triggerSfx('tap');
  document.getElementById('rules-popup').classList.add('open');
}

function closeRules() {
  triggerSfx('tap');
  document.getElementById('rules-popup').classList.remove('open');
}
</script>

</body>
</html>
