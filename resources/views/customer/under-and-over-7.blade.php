<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
  <meta charset="utf-8">
  <title>Under and Over 7 - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700;1,800&family=Cinzel:wght@700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
      user-select: none;
      -webkit-user-select: none;
      -webkit-user-drag: none;
      -webkit-tap-highlight-color: transparent;
    }
    img {
      pointer-events: none;
      -webkit-user-drag: none;
    }

    body {
      background: #050811;
      color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
      overflow-y: auto;
    }

    /* Main Viewport Container */
    .game-viewport {
      position: relative;
      width: 100%;
      flex: 1;
      min-height: calc(100vh - 70px);
      background: radial-gradient(circle at 50% 38%, #162238 0%, #0d1629 45%, #050812 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px 24px;
      overflow: hidden;
    }

    /* Ambient Background Lights overlay */
    .bg-lights-glow {
      position: absolute;
      inset: 0;
      background-image: url('/under-and-over-7/lights@1x.9f21e7fb9d8b.png');
      background-size: cover;
      background-position: center top;
      background-repeat: no-repeat;
      opacity: 0.45;
      mix-blend-mode: screen;
      pointer-events: none;
      z-index: 1;
    }

    /* =========================================================
       CONTINUOUSLY ROTATING CROSSES (Audio: সবগুলো ক্রস বাটন ঘুরে)
       ========================================================= */
    .bg-cross-top-left {
      position: absolute;
      top: -70px;
      left: -70px;
      width: clamp(280px, 32vw, 450px);
      height: clamp(280px, 32vw, 450px);
      object-fit: contain;
      pointer-events: none;
      opacity: 0.95;
      filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.9));
      z-index: 1;
      transform-origin: center center;
      will-change: transform;
      animation: spinCrossLeft 16s linear infinite;
    }
    @keyframes spinCrossLeft {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .bg-cross-bottom-right {
      position: absolute;
      bottom: -100px;
      right: -80px;
      width: clamp(260px, 28vw, 410px);
      height: clamp(260px, 28vw, 410px);
      object-fit: contain;
      pointer-events: none;
      opacity: 0.92;
      filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.9));
      z-index: 1;
      transform-origin: center center;
      will-change: transform;
      animation: spinCrossRight 16s linear infinite;
    }
    @keyframes spinCrossRight {
      from { transform: rotate(0deg); }
      to { transform: rotate(-360deg); }
    }

    .bg-cross-center-dark {
      position: absolute;
      top: 42%;
      left: 50%;
      width: clamp(340px, 40vw, 530px);
      height: clamp(340px, 40vw, 530px);
      object-fit: contain;
      pointer-events: none;
      opacity: 0.88;
      filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.95));
      z-index: 1;
      transform-origin: center center;
      will-change: transform;
      animation: spinCrossCenter 24s linear infinite;
    }
    @keyframes spinCrossCenter {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* =========================================================
       ROTATING BACKGROUND DICE (Audio: পিছনের ছক্কা গুলা ব্যাকগ্রাউন্ডে ঘুরে)
       ========================================================= */
    .bg-decor-dice {
      position: absolute;
      pointer-events: none;
      z-index: 1;
      opacity: 0.38;
      filter: drop-shadow(0 15px 25px rgba(0,0,0,0.85));
      transform-origin: center center;
    }
    .bg-dice-1 {
      top: 22%;
      right: 17%;
      width: 135px;
      filter: blur(2px);
      animation: spinBgDie1 22s linear infinite;
    }
    @keyframes spinBgDie1 {
      0% { transform: rotate(0deg) translateY(0); }
      50% { transform: rotate(180deg) translateY(-14px); }
      100% { transform: rotate(360deg) translateY(0); }
    }

    .bg-dice-2 {
      bottom: 20%;
      left: 5%;
      width: 155px;
      filter: blur(2.5px);
      animation: spinBgDie2 26s linear infinite;
    }
    @keyframes spinBgDie2 {
      0% { transform: rotate(360deg) translateY(0); }
      50% { transform: rotate(180deg) translateY(14px); }
      100% { transform: rotate(0deg) translateY(0); }
    }

    .bg-dice-3 {
      bottom: 28%;
      right: 6%;
      width: 115px;
      filter: blur(3px);
      animation: spinBgDie3 18s linear infinite;
    }
    @keyframes spinBgDie3 {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .bg-dice-4 {
      top: 14%;
      left: 13%;
      width: 120px;
      filter: blur(2.5px);
      animation: spinBgDie4 28s linear infinite;
    }
    @keyframes spinBgDie4 {
      0% { transform: rotate(360deg); }
      100% { transform: rotate(0deg); }
    }

    /* Main Foreground Content */
    .game-content-wrap {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 1120px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      flex: 1;
      gap: 12px;
    }

    /* Top Bar Header */
    .top-header-bar {
      width: 100%;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      position: relative;
    }

    .breadcrumb-title {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.8px;
      color: #94a3b8;
      text-transform: uppercase;
      padding-top: 4px;
    }
    .breadcrumb-title a {
      color: #7dd3fc;
      text-decoration: underline;
      transition: color 0.2s;
    }
    .breadcrumb-title a:hover {
      color: #38bdf8;
    }
    .breadcrumb-title .sep {
      color: #475569;
      font-size: 13px;
    }
    .breadcrumb-title .game-name {
      color: #e2e8f0;
      font-weight: 900;
    }

    /* Center Logo and How to play */
    .logo-center-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      margin-top: -6px;
    }
    .main-logo-image {
      height: 68px;
      width: auto;
      max-width: 220px;
      object-fit: contain;
      filter: drop-shadow(0 6px 18px rgba(0,0,0,0.9));
      transition: transform 0.2s;
    }
    .main-logo-image:hover {
      transform: scale(1.03);
    }
    .how-to-play-btn {
      font-size: 11px;
      font-weight: 800;
      color: #94a3b8;
      text-decoration: underline;
      text-underline-offset: 3px;
      cursor: pointer;
      font-style: italic;
      letter-spacing: 0.6px;
      transition: color 0.2s;
    }
    .how-to-play-btn:hover {
      color: #facc15;
    }

    /* Jackpot Badge matching 1xBet Screenshot with lightbulbs glow */
    .jackpot-pill-badge {
      position: relative;
      background: linear-gradient(180deg, #1b1812 0%, #0b0906 100%);
      border: 2px solid #ca8a04;
      border-radius: 6px;
      padding: 7px 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 16px rgba(202, 138, 4, 0.45), inset 0 0 10px rgba(250, 204, 21, 0.2);
      cursor: pointer;
      overflow: visible;
      margin-top: 4px;
    }
    .jackpot-arch-lights {
      position: absolute;
      top: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 90%;
      height: 12px;
      border-top: 2.5px dotted #facc15;
      border-radius: 50% 50% 0 0;
      filter: drop-shadow(0 0 5px #facc15);
      pointer-events: none;
      animation: archBulbsGlow 1.2s ease-in-out infinite alternate;
    }
    @keyframes archBulbsGlow {
      0% { opacity: 0.5; filter: drop-shadow(0 0 2px #facc15); }
      100% { opacity: 1; filter: drop-shadow(0 0 8px #facc15); }
    }
    .jackpot-pill-badge span {
      font-family: 'Cinzel', serif;
      font-size: 15px;
      font-weight: 900;
      letter-spacing: 2.2px;
      background: linear-gradient(180deg, #fff7c2 0%, #facc15 50%, #ca8a04 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-transform: uppercase;
      text-shadow: 0 0 8px rgba(250, 204, 21, 0.5);
    }

    /* =========================================
       CENTER STAGE: 2 GOLDEN CIRCULAR FRAMES
       ========================================= */
    .dice-stage-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: clamp(18px, 4.5vw, 48px);
      margin: 4px 0 2px;
      perspective: 1200px;
      position: relative;
    }

    /* Gold Circular Rim Frame matching screenshot */
    .golden-circle-frame {
      width: clamp(140px, 19vw, 215px);
      height: clamp(140px, 19vw, 215px);
      border-radius: 50%;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle, #24221b 56%, #cca645 82%, #856218 96%, #523b0a 100%);
      box-shadow: 
        0 0 0 5px #d4af37,
        0 0 0 9px #7a5813,
        0 18px 45px rgba(0, 0, 0, 0.9),
        inset 0 4px 14px rgba(0, 0, 0, 0.9);
      transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s;
    }

    .golden-circle-frame.shaking {
      animation: diceStageShake 0.1s infinite alternate ease-in-out;
      box-shadow: 
        0 0 0 5px #fde047,
        0 0 0 9px #ca8a04,
        0 0 30px rgba(250, 204, 21, 0.6),
        0 18px 45px rgba(0, 0, 0, 0.9),
        inset 0 4px 14px rgba(0, 0, 0, 0.9);
    }
    @keyframes diceStageShake {
      0% { transform: translateY(-5px) rotate(-3deg) scale(1.03); }
      100% { transform: translateY(5px) rotate(3deg) scale(0.98); }
    }

    .inner-basin {
      width: 82%;
      height: 82%;
      border-radius: 50%;
      background: radial-gradient(circle, #1a1e27 40%, #0d121c 100%);
      box-shadow: inset 0 6px 14px rgba(0,0,0,0.9), 0 1px 2px rgba(255,255,255,0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    .dice-canvas {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      display: block;
      transform: scale(1.24);
    }

    /* Status Pill / Round Result Banner */
    .status-pill-banner {
      min-height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.8px;
      color: #94a3b8;
      text-transform: uppercase;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      text-shadow: 0 2px 6px rgba(0,0,0,0.8);
    }
    .status-pill-banner.win {
      color: #4ade80;
      font-size: 16px;
      font-weight: 900;
      letter-spacing: 1px;
      text-shadow: 0 0 16px rgba(74, 222, 128, 0.7);
      transform: scale(1.05);
    }
    .status-pill-banner.loss {
      color: #f87171;
      font-size: 14px;
      font-weight: 900;
    }

    /* ============================================================
       3 BETTING CHOICE CARDS (OVER, EQUAL, UNDER) matching 1xBet
       ============================================================ */
    .bet-choices-group {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      width: 100%;
      max-width: 680px;
      background: rgba(14, 22, 38, 0.88);
      border: 1px solid rgba(56, 189, 248, 0.12);
      border-radius: 10px;
      padding: 6px 8px;
      box-shadow: 0 12px 35px rgba(0,0,0,0.7), inset 0 1px 1px rgba(255,255,255,0.06);
      backdrop-filter: blur(12px);
    }

    .choice-card-item {
      flex: 1;
      min-width: 0;
      background: #111a2c;
      border: 2px solid transparent;
      border-radius: 8px;
      padding: 10px 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      cursor: pointer;
      transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
    }
    .choice-card-item:hover {
      background: #182744;
      border-color: rgba(132, 204, 22, 0.5);
      transform: translateY(-2px);
    }
    /* Active selection gets the vibrant neon green outline from the screenshot! */
    .choice-card-item.active {
      background: linear-gradient(180deg, #18283a 0%, #0d1726 100%);
      border: 2px solid #84cc16 !important;
      box-shadow: 0 0 18px rgba(132, 204, 22, 0.45), inset 0 0 10px rgba(132, 204, 22, 0.15);
      transform: translateY(-1px);
    }

    .choice-mult-header {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .choice-coin-symbol {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: linear-gradient(135deg, #fef08a 0%, #ca8a04 50%, #854d0e 100%);
      padding: 3px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.6);
      transition: all 0.2s;
    }
    .choice-coin-symbol .choice-coin-inner {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: #0f172a;
      transition: all 0.2s;
    }
    .choice-card-item.active .choice-coin-symbol {
      box-shadow: 0 0 12px rgba(132, 204, 22, 0.85);
      background: linear-gradient(135deg, #bef264 0%, #84cc16 50%, #4d7c0f 100%);
    }
    .choice-card-item.active .choice-coin-symbol .choice-coin-inner {
      background: #84cc16;
      box-shadow: 0 0 8px #84cc16, inset 0 0 3px #d9f99d;
    }
    .choice-mult-number {
      font-size: 17px;
      font-weight: 900;
      color: #ffffff;
      letter-spacing: 0.5px;
    }
    .choice-card-item.active .choice-mult-number {
      color: #a3e635;
      text-shadow: 0 0 10px rgba(163, 230, 53, 0.6);
    }

    .choice-sub-label {
      font-size: 11.5px;
      font-weight: 800;
      color: #94a3b8;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .choice-sub-label .keyword {
      color: #eab308;
      font-weight: 900;
    }
    .choice-card-item.active .choice-sub-label .keyword {
      color: #a3e635;
    }
    .choice-sub-label .arrow {
      color: #eab308;
      font-size: 12px;
    }
    .choice-card-item.active .choice-sub-label .arrow {
      color: #a3e635;
    }
    .choice-sub-label .numbers {
      color: #f1f5f9;
      font-weight: 800;
      letter-spacing: 1px;
    }

    /* =========================================
       GOLDEN CHIPS BAR (1, 2, 3, 5, 10, 25 matching Screenshot!)
       ========================================= */
    .gold-chips-bar {
      width: 100%;
      max-width: 490px;
      background: #111827;
      border: 2.5px solid #ca8a04;
      border-radius: 28px;
      padding: 3px 6px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0px;
      box-shadow: 0 10px 28px rgba(0,0,0,0.75), inset 0 1px 2px rgba(254, 240, 138, 0.4);
    }

    .chip-item-btn {
      flex: 1;
      padding: 8px 0;
      background: transparent;
      border: none;
      color: #fef08a;
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      border-radius: 20px;
      transition: all 0.15s ease;
      text-align: center;
      position: relative;
    }
    .chip-item-btn:not(:last-child)::after {
      content: '';
      position: absolute;
      right: 0;
      top: 18%;
      height: 64%;
      width: 1.5px;
      background: rgba(202, 138, 4, 0.55);
    }
    .chip-item-btn:hover {
      background: rgba(250, 204, 21, 0.2);
      color: #ffffff;
    }
    .chip-item-btn.selected {
      background: linear-gradient(180deg, #facc15 0%, #ca8a04 100%);
      color: #0b0702;
      font-weight: 900;
      box-shadow: 0 0 12px rgba(250, 204, 21, 0.7);
    }

    /* =========================================
       STAKE INPUT + GREEN PLACE BET BUTTON
       ========================================= */
    .controls-action-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      width: 100%;
      max-width: 490px;
    }

    .stake-box-pill {
      flex: 1;
      background: #111827;
      border: 2.5px solid #ca8a04;
      border-radius: 28px;
      padding: 6px 14px 6px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      box-shadow: inset 0 2px 8px rgba(0,0,0,0.8), 0 4px 12px rgba(0,0,0,0.5);
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stake-box-pill:focus-within {
      border-color: #facc15;
      box-shadow: inset 0 2px 8px rgba(0,0,0,0.7), 0 0 15px rgba(250, 204, 21, 0.4);
    }
    .stake-box-pill input {
      background: transparent;
      border: none;
      outline: none;
      color: #ffffff;
      font-size: 16px;
      font-weight: 900;
      width: 100%;
      letter-spacing: 0.5px;
    }
    .stake-clear-circle {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      background: #1e293b;
      border: 1px solid rgba(148, 163, 184, 0.25);
      color: #94a3b8;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 900;
      cursor: pointer;
      transition: all 0.15s;
    }
    .stake-clear-circle:hover {
      background: #dc2626;
      border-color: #ef4444;
      color: #ffffff;
      transform: scale(1.08);
    }

    /* Glossy Green PLACE A BET Button */
    .place-bet-green-btn {
      flex: 1.25;
      background: linear-gradient(180deg, #78b82a 0%, #4e8213 100%);
      border: 1.5px solid #a3e635;
      border-radius: 26px;
      padding: 13px 22px;
      color: #ffffff;
      font-size: 15.5px;
      font-weight: 900;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 8px 24px rgba(78, 130, 19, 0.7), inset 0 2px 4px rgba(255,255,255,0.45);
      transition: all 0.15s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      text-shadow: 0 1px 3px rgba(0,0,0,0.7);
    }
    .place-bet-green-btn:hover:not(:disabled) {
      filter: brightness(1.1);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(78, 130, 19, 0.85);
    }
    .place-bet-green-btn:active:not(:disabled) {
      transform: translateY(1px);
    }
    .place-bet-green-btn:disabled {
      background: #334155;
      border-color: #475569;
      color: #64748b;
      cursor: not-allowed;
      box-shadow: none;
      text-shadow: none;
      transform: none;
    }

    /* =========================================
       FLOATING DEMO MODE CHIP (BOTTOM RIGHT)
       ========================================= */
    .floating-mode-chip {
      position: fixed;
      right: 20px;
      bottom: 20px;
      z-index: 40;
      background: rgba(14, 23, 42, 0.88);
      border: 1px solid #1e3a5f;
      border-radius: 6px;
      padding: 6px 14px;
      font-size: 11px;
      font-weight: 800;
      color: #7dd3fc;
      display: flex;
      align-items: center;
      gap: 7px;
      cursor: pointer;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 18px rgba(0,0,0,0.65);
      transition: all 0.2s;
    }
    .floating-mode-chip:hover {
      background: #1e293b;
      border-color: #38bdf8;
      color: #ffffff;
      transform: translateY(-1px);
    }
    .floating-mode-chip .dot-bulb {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #38bdf8;
      box-shadow: 0 0 6px #38bdf8;
    }
    .floating-mode-chip.real-active {
      border-color: #eab308;
      color: #fde047;
    }
    .floating-mode-chip.real-active .dot-bulb {
      background: #eab308;
      box-shadow: 0 0 8px #eab308;
    }

    /* Right Floating Side Strip from 1xBet Screenshot */
    .right-side-tools-panel {
      position: fixed;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 8px;
      z-index: 30;
      background: rgba(8, 12, 22, 0.7);
      padding: 6px 4px;
      border-radius: 8px;
      border: 1px solid rgba(255,255,255,0.06);
      backdrop-filter: blur(8px);
    }
    .side-tool-btn {
      width: 32px;
      height: 32px;
      background: rgba(15, 23, 42, 0.85);
      border: 1px solid rgba(148, 163, 184, 0.15);
      border-radius: 6px;
      color: #cbd5e1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .side-tool-btn:hover {
      background: #1e293b;
      border-color: #facc15;
      color: #facc15;
      transform: scale(1.1);
    }

    /* Sound Control Button in bottom left */
    .floating-sound-chip {
      position: fixed;
      left: 20px;
      bottom: 20px;
      z-index: 40;
      background: rgba(14, 23, 42, 0.88);
      border: 1px solid #1e3a5f;
      border-radius: 6px;
      padding: 6px 12px;
      font-size: 12px;
      font-weight: 800;
      color: #94a3b8;
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 18px rgba(0,0,0,0.65);
      transition: all 0.2s;
    }
    .floating-sound-chip:hover {
      background: #1e293b;
      color: #facc15;
      border-color: #facc15;
    }

    /* Celebratory Win Overlay Modal */
    .win-overlay-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100vw;
      width: 100dvw;
      height: 100vh;
      height: 100dvh;
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 999999;
      padding: 16px;
      box-sizing: border-box;
      margin: 0;
    }
    .win-overlay-modal.show {
      display: flex !important;
      opacity: 1;
    }
    .win-card-panel {
      background: radial-gradient(circle, #2c2214 0%, #0d0a05 100%);
      border: 3px solid #eab308;
      border-radius: 24px;
      padding: 28px 32px;
      text-align: center;
      box-shadow: 0 0 60px rgba(234, 179, 8, 0.7), inset 0 0 25px rgba(234, 179, 8, 0.35);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      max-width: 400px;
      width: min(92vw, 400px);
      box-sizing: border-box;
      margin: auto;
      transform-origin: center center;
    }
    .win-overlay-modal.show .win-card-panel {
      animation: winCardPop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }
    @keyframes winCardPop {
      0% { opacity: 0; transform: scale(0.6); }
      100% { opacity: 1; transform: scale(1); }
    }
    .win-panel-title {
      font-size: 28px;
      font-weight: 900;
      background: linear-gradient(180deg, #fff7c2 0%, #facc15 60%, #ca8a04 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 2px;
      text-transform: uppercase;
      line-height: 1.2;
    }
    .win-panel-amount {
      font-size: 38px;
      font-weight: 900;
      color: #4ade80;
      text-shadow: 0 0 25px rgba(74, 222, 128, 0.85);
      line-height: 1.2;
      word-break: break-all;
    }
    .win-panel-close-btn {
      margin-top: 6px;
      background: linear-gradient(180deg, #facc15 0%, #ca8a04 100%);
      border: none;
      color: #000;
      font-weight: 900;
      padding: 10px 32px;
      border-radius: 24px;
      cursor: pointer;
      font-size: 14px;
      letter-spacing: 0.8px;
      box-shadow: 0 4px 15px rgba(250, 204, 21, 0.5);
      transition: transform 0.15s;
    }
    .win-panel-close-btn:hover {
      transform: scale(1.05);
    }

    /* Rules Modal */
    .rules-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100vw;
      width: 100dvw;
      height: 100vh;
      height: 100dvh;
      background: rgba(0,0,0,0.85);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 999999;
      padding: 16px;
      box-sizing: border-box;
    }
    .rules-modal.show { display: flex !important; }
    .rules-dialog {
      background: #0f172a;
      border: 2px solid #38bdf8;
      border-radius: 18px;
      padding: 24px;
      max-width: 460px;
      width: min(92vw, 460px);
      color: #cbd5e1;
      font-size: 13.5px;
      line-height: 1.6;
      box-shadow: 0 0 35px rgba(56, 189, 248, 0.3);
      box-sizing: border-box;
      margin: auto;
    }

    @media (max-width: 640px) {
      .game-viewport {
        padding: 8px 10px 18px;
        max-width: 100vw;
        overflow-x: hidden;
      }
      .bet-choices-group {
        gap: 6px;
        padding: 4px;
        max-width: 100%;
      }
      .choice-mult-number { font-size: 14px; }
      .choice-sub-label { font-size: 9.5px; }
      .floating-sound-chip { display: none; }
      .right-side-tools-panel { display: none; }
      .gold-chips-bar { max-width: 100%; }
      .controls-action-row { max-width: 100%; gap: 10px; }
      .place-bet-green-btn { padding: 12px 14px; font-size: 13.5px; }
      .win-card-panel {
        padding: 22px 18px;
        width: min(92vw, 340px);
        gap: 8px;
      }
      .win-panel-title { font-size: 24px; }
      .win-panel-amount { font-size: 32px; }
      .win-panel-close-btn { padding: 8px 24px; font-size: 13px; }
    }
  </style>
</head>
<body oncontextmenu="return false;">

  @include('customer.header')

  <!-- Ambient Sound -->
  <audio id="dice-ambient-sound" src="/assets/audio/games/under_and_over_7_bg.mp3" preload="auto" loop></audio>

  <div class="game-viewport">
    <!-- Ambient Lights overlay -->
    <div class="bg-lights-glow"></div>

    <!-- Authentic Giant Golden Crosses & Dark Cross from 1xBet Screenshot -->
    <!-- Top-left & Bottom-right: GOLDEN crosses (dark-cross.webp) ROTATING continuously! -->
    <img src="/under-and-over-7/dark-cross.24d1b55fa6a0.webp" class="bg-cross-top-left" alt="decor">
    <img src="/under-and-over-7/dark-cross.24d1b55fa6a0.webp" class="bg-cross-bottom-right" alt="decor">
    <!-- Center cross: DARK PURPLE cross (big-cross.webp) ROTATING continuously behind the dice! -->
    <img src="/under-and-over-7/big-cross.034a6b6fc439.webp" class="bg-cross-center-dark" alt="decor">

    <!-- Floating ROTATING dice in background (Audio: পিছনের ছক্কা গুলা ব্যাকগ্রাউন্ডে ঘুরে) -->
    <img src="/under-and-over-7/dice1.541744f91072.webp" class="bg-decor-dice bg-dice-1" alt="decor">
    <img src="/under-and-over-7/dice4.623aac03544f.webp" class="bg-decor-dice bg-dice-2" alt="decor">
    <img src="/under-and-over-7/dice2.ce851e5a59ee.webp" class="bg-decor-dice bg-dice-3" alt="decor">
    <img src="/under-and-over-7/dice3.af179fc55d1d.webp" class="bg-decor-dice bg-dice-4" alt="decor">

    <div class="game-content-wrap">
      <!-- Top Header Bar matching Screenshot -->
      <div class="top-header-bar">
        <div class="breadcrumb-title">
          <a href="{{ route('home') }}">1XGAMES</a>
          <span class="sep">/</span>
          <a href="{{ route('dashboard') }}">DICE</a>
          <span class="sep">/</span>
          <span class="game-name">UNDER AND OVER 7</span>
        </div>

        <div class="logo-center-box">
          <img src="/under-and-over-7/logo.png" alt="Under and Over 7" class="main-logo-image">
          <span class="how-to-play-btn" onclick="openRules()">HOW TO PLAY</span>
        </div>

        <div class="jackpot-pill-badge" onclick="openRules()">
          <div class="jackpot-arch-lights"></div>
          <span>JACKPOT</span>
        </div>
      </div>

      <!-- CENTER STAGE: 2 GOLDEN CIRCULAR FRAMES WITH CANVAS SPRITESHEET ANIMATION -->
      <div class="dice-stage-container" id="stage-container">
        <!-- DIE 1 (LEFT, SHOWING 6) -->
        <div class="golden-circle-frame" id="frame-die-1">
          <div class="inner-basin">
            <canvas id="canvas-die-1" class="dice-canvas" width="300" height="300"></canvas>
          </div>
        </div>

        <!-- DIE 2 (RIGHT, SHOWING 5) -->
        <div class="golden-circle-frame" id="frame-die-2">
          <div class="inner-basin">
            <canvas id="canvas-die-2" class="dice-canvas" width="300" height="300"></canvas>
          </div>
        </div>
      </div>

      <!-- Result Banner -->
      <div class="status-pill-banner" id="status-banner">
        CHOOSE YOUR BET &amp; ROLL
      </div>

      <!-- 3 BETTING CHOICE CARDS (OVER, EQUAL, UNDER) matching Screenshot exactly -->
      <div class="bet-choices-group">
        <!-- OVER (8-12, x2.3, ACTIVE WITH GREEN BORDER IN SCREENSHOT) -->
        <div class="choice-card-item active" id="choice-over" onclick="selectPrediction('over')">
          <div class="choice-mult-header">
            <span class="choice-coin-symbol"><span class="choice-coin-inner"></span></span>
            <span class="choice-mult-number">x 2.3</span>
          </div>
          <div class="choice-sub-label">
            <span class="keyword">OVER</span>
            <span class="arrow">&rArr;</span>
            <span class="numbers">8 9 10 11 12</span>
          </div>
        </div>

        <!-- EQUAL (7, x5.8) -->
        <div class="choice-card-item" id="choice-equal" onclick="selectPrediction('equal')">
          <div class="choice-mult-header">
            <span class="choice-coin-symbol"><span class="choice-coin-inner"></span></span>
            <span class="choice-mult-number">x 5.8</span>
          </div>
          <div class="choice-sub-label">
            <span class="keyword">EQUAL</span>
            <span class="arrow">&rArr;</span>
            <span class="numbers">7</span>
          </div>
        </div>

        <!-- UNDER (2-6, x2.3) -->
        <div class="choice-card-item" id="choice-under" onclick="selectPrediction('under')">
          <div class="choice-mult-header">
            <span class="choice-coin-symbol"><span class="choice-coin-inner"></span></span>
            <span class="choice-mult-number">x 2.3</span>
          </div>
          <div class="choice-sub-label">
            <span class="keyword">UNDER</span>
            <span class="arrow">&rArr;</span>
            <span class="numbers">2 3 4 5 6</span>
          </div>
        </div>
      </div>

      <!-- GOLDEN CHIPS PRESET BAR (1, 2, 3, 5, 10, 25 matching Screenshot!) -->
      <div class="gold-chips-bar">
        <button class="chip-item-btn" onclick="pickChip(1, this)">1</button>
        <button class="chip-item-btn" onclick="pickChip(2, this)">2</button>
        <button class="chip-item-btn" onclick="pickChip(3, this)">3</button>
        <button class="chip-item-btn" onclick="pickChip(5, this)">5</button>
        <button class="chip-item-btn" onclick="pickChip(10, this)">10</button>
        <button class="chip-item-btn" onclick="pickChip(25, this)">25</button>
      </div>

      <!-- STAKE INPUT + PLACE A BET BUTTON (Default stake 4 matching Screenshot!) -->
      <div class="controls-action-row">
        <div class="stake-box-pill">
          <input type="number" id="stake-input-field" value="4" min="1" max="50000" oninput="onStakeType()">
          <div class="stake-clear-circle" onclick="resetStake()" title="Reset">✕</div>
        </div>

        <button class="place-bet-green-btn" id="btn-submit-bet" onclick="executeRollAndBet()">
          PLACE A BET
        </button>
      </div>
    </div>
  </div>

  <!-- RIGHT SIDE TOOLBAR STRIP MATCHING SCREENSHOT EXACTLY -->
  <div class="right-side-tools-panel">
    <div class="side-tool-btn" title="Settings" onclick="openRules()"><i class="fa-solid fa-gear"></i></div>
    <div class="side-tool-btn" title="Bonuses" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-gift"></i></div>
    <div class="side-tool-btn" title="Lucky 7" style="font-weight:900; color:#facc15;">7</div>
    <div class="side-tool-btn" title="Games" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-dharmachakra"></i></div>
    <div class="side-tool-btn" title="Cashier" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-dollar-sign"></i></div>
  </div>

  <!-- FLOATING BOTTOM CONTROLS: DEMO MODE & SOUND TOGGLE -->
  <div class="floating-sound-chip" id="sound-chip" onclick="toggleAudioMute()">
    <i class="fa-solid fa-volume-high" id="sound-speaker-icon"></i>
    <span id="sound-speaker-text">SOUND ON</span>
  </div>

  <div class="floating-mode-chip" id="mode-toggle-btn" onclick="togglePlayMode()">
    <span class="dot-bulb"></span>
    <span id="mode-label-text">DEMO MODE</span>
    <span style="font-size:10px; opacity:0.8;">▲</span>
  </div>

  <!-- BIG WIN CELEBRATION MODAL -->
  <div class="win-overlay-modal" id="win-celebrate-modal" onclick="dismissWinModal()">
    <div class="win-card-panel" onclick="event.stopPropagation()">
      <div style="font-size:38px;">🏆</div>
      <div class="win-panel-title">BIG WIN!</div>
      <div style="font-size:14px; color:#cbd5e1; font-weight:700;">CONGRATULATIONS!</div>
      <div class="win-panel-amount" id="win-amount-display">+৳ 46.00</div>
      <button class="win-panel-close-btn" onclick="dismissWinModal()">CONTINUE</button>
    </div>
  </div>

  <!-- RULES MODAL -->
  <div class="rules-modal" id="rules-info-modal" onclick="dismissRules()">
    <div class="rules-dialog" onclick="event.stopPropagation()">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <h3 style="color:#facc15; font-size:19px; font-weight:900;">Under and Over 7 Rules</h3>
        <span onclick="dismissRules()" style="color:#94a3b8; font-size:18px; cursor:pointer; font-weight:800;">✕</span>
      </div>
      <p style="margin-bottom:10px;">Predict the combined sum of two 6-sided dice:</p>
      <ul style="padding-left:20px; margin-bottom:14px;">
        <li style="margin-bottom:6px;"><strong style="color:#facc15;">UNDER 7 (2, 3, 4, 5, 6):</strong> Pays <strong>2.30×</strong></li>
        <li style="margin-bottom:6px;"><strong style="color:#facc15;">EQUAL 7 (7):</strong> Pays <strong>5.80×</strong></li>
        <li style="margin-bottom:6px;"><strong style="color:#facc15;">OVER 7 (8, 9, 10, 11, 12):</strong> Pays <strong>2.30×</strong></li>
      </ul>
      <p style="font-size:12px; color:#94a3b8; margin-bottom:16px;">
        Select your prediction (Over, Equal, or Under), choose your stake using the chips or input, and press <strong>PLACE A BET</strong> to roll the dice.
      </p>
      <button class="win-panel-close-btn" style="width:100%; border-radius:12px;" onclick="dismissRules()">GOT IT</button>
    </div>
  </div>

  <script>
    /* =======================================================================
       1. WEB AUDIO API SYNTHESIZER & SOUND SYSTEM (Audio: আলাদা সাউন্ড হবে)
       ======================================================================= */
    let audioCtx = null;
    let soundEnabled = true;

    function getAudioContext() {
      if (!audioCtx) {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (AudioContextClass) {
          audioCtx = new AudioContextClass();
        }
      }
      if (audioCtx && audioCtx.state === 'suspended') {
        audioCtx.resume();
      }
      return audioCtx;
    }

    // Play crisp chip/button click
    function playChipSound() {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioContext();
        if (!ctx) return;
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(1400, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.04);
        gain.gain.setValueAtTime(0.2, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.04);
      } catch (e) {}
    }

    // Play tumbling/rolling rattling noise loop
    let rollingSoundTimer = null;
    function startDiceRollSound() {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioContext();
        if (!ctx) return;
        stopDiceRollSound();

        rollingSoundTimer = setInterval(() => {
          if (!soundEnabled || !isRolling) {
            stopDiceRollSound();
            return;
          }
          const bufferSize = ctx.sampleRate * 0.035;
          const noiseBuffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
          const output = noiseBuffer.getChannelData(0);
          for (let i = 0; i < bufferSize; i++) {
            output[i] = (Math.random() * 2 - 1) * Math.exp(-i / (bufferSize * 0.3));
          }
          const whiteNoise = ctx.createBufferSource();
          whiteNoise.buffer = noiseBuffer;
          const filter = ctx.createBiquadFilter();
          filter.type = 'bandpass';
          filter.frequency.value = 1800 + Math.random() * 800;
          filter.Q.value = 3.0;

          const gain = ctx.createGain();
          gain.gain.setValueAtTime(0.18, ctx.currentTime);

          whiteNoise.connect(filter);
          filter.connect(gain);
          gain.connect(ctx.destination);
          whiteNoise.start();
        }, 55);
      } catch (e) {}
    }

    function stopDiceRollSound() {
      if (rollingSoundTimer) {
        clearInterval(rollingSoundTimer);
        rollingSoundTimer = null;
      }
    }

    // Play solid dice landing / clatter impact sound
    function playDiceLandSound() {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioContext();
        if (!ctx) return;

        // Thump
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(220, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(45, ctx.currentTime + 0.12);
        gain.gain.setValueAtTime(0.35, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.12);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.12);

        // Clatter click
        setTimeout(() => {
          try {
            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(950, ctx.currentTime);
            osc2.frequency.exponentialRampToValueAtTime(300, ctx.currentTime + 0.06);
            gain2.gain.setValueAtTime(0.25, ctx.currentTime);
            gain2.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.06);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start();
            osc2.stop(ctx.currentTime + 0.06);
          } catch(e) {}
        }, 30);
      } catch (e) {}
    }

    // Play Win Fanfare
    function playWinFanfare() {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioContext();
        if (!ctx) return;
        const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
        notes.forEach((freq, idx) => {
          setTimeout(() => {
            try {
              const osc = ctx.createOscillator();
              const gain = ctx.createGain();
              osc.type = 'triangle';
              osc.frequency.setValueAtTime(freq, ctx.currentTime);
              gain.gain.setValueAtTime(0.28, ctx.currentTime);
              gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
              osc.connect(gain);
              gain.connect(ctx.destination);
              osc.start();
              osc.stop(ctx.currentTime + 0.35);
            } catch (e) {}
          }, idx * 90);
        });
      } catch (e) {}
    }

    // Play Lose Thud
    function playLoseSound() {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioContext();
        if (!ctx) return;
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(180, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(70, ctx.currentTime + 0.25);
        gain.gain.setValueAtTime(0.18, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.25);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.25);
      } catch (e) {}
    }

    function toggleAudioMute() {
      soundEnabled = !soundEnabled;
      const icon = document.getElementById('sound-speaker-icon');
      const text = document.getElementById('sound-speaker-text');
      if (soundEnabled) {
        icon.className = 'fa-solid fa-volume-high';
        text.innerText = 'SOUND ON';
        playChipSound();
      } else {
        icon.className = 'fa-solid fa-volume-xmark';
        text.innerText = 'SOUND OFF';
        stopDiceRollSound();
      }
    }

    /* =======================================================================
       2. SPRITESHEET ENGINE FOR 60FPS 3D DICE ROTATION (Audio: এনিমেশন হয়ে ঘুরে)
       ======================================================================= */
    const FRAME_SIZE = 300;
    const HOLD_FRAMES = 50;

    const SPRITES = {
      hold1: new Image(),
      hold2: new Image(),
      start: {}
    };

    SPRITES.hold1.src = '/under-and-over-7/hold_1@1x.3e7c7fdce7cf.png';
    SPRITES.hold2.src = '/under-and-over-7/hold_2@1x.4bfd7e1924e1.png';

    const START_PATHS = {
      1: '/under-and-over-7/start_1@1x.f678f21030d6.png',
      2: '/under-and-over-7/start_2@1x.c6a5059cefe1.png',
      3: '/under-and-over-7/start_3@1x.2084f5d3edf3.png',
      4: '/under-and-over-7/start_4@1x.1b2b15b7d3f2.png',
      5: '/under-and-over-7/start_5@1x.7dadbf95ed84.png',
      6: '/under-and-over-7/start_6@1x.e53d249d28cc.png'
    };

    for (let face = 1; face <= 6; face++) {
      SPRITES.start[face] = new Image();
      SPRITES.start[face].src = START_PATHS[face];
    }

    const cv1 = document.getElementById('canvas-die-1');
    const ctx1 = cv1.getContext('2d');
    const cv2 = document.getElementById('canvas-die-2');
    const ctx2 = cv2.getContext('2d');

    function drawFrame(ctx, img, frameIndex) {
      ctx.clearRect(0, 0, FRAME_SIZE, FRAME_SIZE);
      if (img && img.complete && img.naturalHeight > 0) {
        ctx.drawImage(img, 0, frameIndex * FRAME_SIZE, FRAME_SIZE, FRAME_SIZE, 0, 0, FRAME_SIZE, FRAME_SIZE);
      }
    }

    // Default matching Screenshot exactly: Left die is 6, Right die is 5!
    let currentDie1Face = 6;
    let currentDie2Face = 5;

    function renderInitialDiceFaces() {
      if (SPRITES.start[currentDie1Face].complete) {
        drawFrame(ctx1, SPRITES.start[currentDie1Face], 0);
      } else {
        SPRITES.start[currentDie1Face].onload = () => drawFrame(ctx1, SPRITES.start[currentDie1Face], 0);
      }

      if (SPRITES.start[currentDie2Face].complete) {
        drawFrame(ctx2, SPRITES.start[currentDie2Face], 0);
      } else {
        SPRITES.start[currentDie2Face].onload = () => drawFrame(ctx2, SPRITES.start[currentDie2Face], 0);
      }
    }
    window.addEventListener('load', renderInitialDiceFaces);
    renderInitialDiceFaces();

    /* =======================================================================
       3. GAMEPLAY STATE & BETTING CONTROLS
       ======================================================================= */
    // Default active: OVER (matches green border in screenshot)
    let selectedChoice = 'over';
    let isRolling = false;
    let isDemo = true;
    let rollLoopTimer1 = null;
    let rollLoopTimer2 = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function selectPrediction(choice) {
      if (isRolling) return;
      playChipSound();
      selectedChoice = choice;
      document.querySelectorAll('.choice-card-item').forEach(c => c.classList.remove('active'));
      const activeEl = document.getElementById('choice-' + choice);
      if (activeEl) activeEl.classList.add('active');
    }

    function pickChip(amount, btn) {
      playChipSound();
      document.getElementById('stake-input-field').value = amount;
      document.querySelectorAll('.chip-item-btn').forEach(b => b.classList.remove('selected'));
      if (btn) btn.classList.add('selected');
    }

    function onStakeType() {
      const val = parseFloat(document.getElementById('stake-input-field').value);
      document.querySelectorAll('.chip-item-btn').forEach(b => {
        if (parseFloat(b.innerText) === val) {
          b.classList.add('selected');
        } else {
          b.classList.remove('selected');
        }
      });
    }

    function resetStake() {
      playChipSound();
      document.getElementById('stake-input-field').value = '1';
      document.querySelectorAll('.chip-item-btn').forEach(b => b.classList.remove('selected'));
    }

    function togglePlayMode() {
      playChipSound();
      isDemo = !isDemo;
      const chip = document.getElementById('mode-toggle-btn');
      const text = document.getElementById('mode-label-text');
      if (isDemo) {
        chip.classList.remove('real-active');
        text.innerText = 'DEMO MODE';
      } else {
        chip.classList.add('real-active');
        text.innerText = 'REAL MONEY';
      }
    }

    function openRules() {
      playChipSound();
      document.getElementById('rules-info-modal').classList.add('show');
    }
    function dismissRules() {
      playChipSound();
      document.getElementById('rules-info-modal').classList.remove('show');
    }
    function dismissWinModal() {
      playChipSound();
      document.getElementById('win-celebrate-modal').classList.remove('show');
    }

    /* =======================================================================
       4. MOTION GRAPHICS ROLL ANIMATION & BET SUBMISSION
       ======================================================================= */
    async function executeRollAndBet() {
      if (isRolling) return;
      getAudioContext();

      const amount = parseFloat(document.getElementById('stake-input-field').value);
      if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid stake amount.");
        return;
      }

      isRolling = true;
      const btn = document.getElementById('btn-submit-bet');
      btn.disabled = true;
      btn.innerText = "ROLLING...";

      const frame1 = document.getElementById('frame-die-1');
      const frame2 = document.getElementById('frame-die-2');
      const statusBanner = document.getElementById('status-banner');

      // Shaking motion graphics
      frame1.classList.add('shaking');
      frame2.classList.add('shaking');
      statusBanner.className = 'status-pill-banner';
      statusBanner.innerText = 'ROLLING DICE...';

      // Sound
      startDiceRollSound();

      // Fast spritesheet rotation using hold_1 and hold_2
      let f1 = 0;
      let f2 = 0;
      rollLoopTimer1 = setInterval(() => {
        f1 = (f1 + 1) % HOLD_FRAMES;
        drawFrame(ctx1, SPRITES.hold1, f1);
      }, 35);

      rollLoopTimer2 = setInterval(() => {
        f2 = (f2 + 1) % HOLD_FRAMES;
        drawFrame(ctx2, SPRITES.hold2, f2);
      }, 35);

      let responseData = null;
      try {
        const res = await fetch("{{ route('underover.bet') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
          },
          body: JSON.stringify({
            choice: selectedChoice,
            amount: amount,
            is_demo: isDemo
          })
        });

        responseData = await res.json();
      } catch (err) {
        console.error("Bet request error:", err);
      }

      setTimeout(() => {
        clearInterval(rollLoopTimer1);
        clearInterval(rollLoopTimer2);
        stopDiceRollSound();
        frame1.classList.remove('shaking');
        frame2.classList.remove('shaking');

        if (!responseData || !responseData.success) {
          const errMsg = responseData ? (responseData.error || "Bet failed") : "Connection failed";
          alert(errMsg);
          isRolling = false;
          btn.disabled = false;
          btn.innerText = "PLACE A BET";
          statusBanner.innerText = "CHOOSE YOUR BET & ROLL";
          renderInitialDiceFaces();
          return;
        }

        const die1Result = responseData.die1 || 1;
        const die2Result = responseData.die2 || 1;
        currentDie1Face = die1Result;
        currentDie2Face = die2Result;

        playLandingAnimation(die1Result, die2Result, () => {
          playDiceLandSound();

          const isWin = responseData.is_win;
          const sum = responseData.sum;
          const choiceOutcome = sum < 7 ? 'UNDER 7' : (sum > 7 ? 'OVER 7' : 'EQUAL 7');

          if (isWin) {
            statusBanner.className = 'status-pill-banner win';
            statusBanner.innerText = `🎉 WON! DICE SUM: ${sum} (${choiceOutcome}) +৳${parseFloat(responseData.win_amount).toFixed(2)}`;
            playWinFanfare();

            if (typeof confetti === 'function') {
              confetti({
                particleCount: 100,
                spread: 75,
                origin: { y: 0.58 },
                colors: ['#84cc16', '#facc15', '#38bdf8', '#ffffff']
              });
            }

            document.getElementById('win-amount-display').innerText = `+৳ ${parseFloat(responseData.win_amount).toFixed(2)}`;
            setTimeout(() => {
              document.getElementById('win-celebrate-modal').classList.add('show');
            }, 300);

          } else {
            statusBanner.className = 'status-pill-banner loss';
            statusBanner.innerText = `LOSS! DICE SUM: ${sum} (${choiceOutcome})`;
            playLoseSound();
          }

          if (!isDemo && typeof updateCustomerBalance === 'function' && responseData.balance !== undefined) {
            updateCustomerBalance(responseData.balance);
          }

          isRolling = false;
          btn.disabled = false;
          btn.innerText = "PLACE A BET";
        });

      }, 850);
    }

    function playLandingAnimation(die1, die2, onComplete) {
      const landingFramesSeq = [24, 22, 20, 18, 15, 12, 9, 6, 4, 2, 1, 0];
      let step = 0;
      const img1 = SPRITES.start[die1];
      const img2 = SPRITES.start[die2];

      const landTimer = setInterval(() => {
        const frameIdx = landingFramesSeq[step];
        drawFrame(ctx1, img1, frameIdx);
        drawFrame(ctx2, img2, frameIdx);
        step++;

        if (step >= landingFramesSeq.length) {
          clearInterval(landTimer);
          drawFrame(ctx1, img1, 0);
          drawFrame(ctx2, img2, 0);
          if (typeof onComplete === 'function') {
            onComplete();
          }
        }
      }, 35);
    }

    // Play dedicated background ambient music
    (function() {
      const ambient = document.getElementById('dice-ambient-sound');
      if (ambient) {
        ambient.volume = 0.35;
        const startAmbient = function() {
          if (ambient.paused) {
            ambient.play().catch(function() {});
          }
        };
        document.addEventListener('click', startAmbient, { once: true });
        document.addEventListener('touchstart', startAmbient, { once: true });
      }
    })();
  </script>
</body>
</html>
