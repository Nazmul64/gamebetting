<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Heads or Tails — 1xBet Official Kraken Ocean Casino</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&family=Montserrat:wght@400;600;700;800;900&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.4/dist/confetti.browser.min.js"></script>

  <style>
    /* ==========================================================================
       1xBet OFFICIAL "HEADS OR TAILS" (AUTHENTIC ASSETS & EXACT SCREENSHOT FIT)
       ========================================================================== */
    :root {
      --bg-dark: #030a16;
      --gold-primary: #f5c842;
      --cyan-btn: #00c0f0;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; user-select: none; -webkit-user-select: none; }
    html, body {
      width: 100%;
      height: 100%;
      min-height: 100vh;
      background: var(--bg-dark);
      font-family: 'Outfit', sans-serif;
      color: #ffffff;
      overflow: hidden;
    }

    /* Top 1xBet Navigation Bar */
    .top-navbar {
      width: 100%;
      height: 48px;
      background: #091a30;
      border-bottom: 1px solid #142e50;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      position: relative;
      z-index: 100;
    }
    .nav-brand {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 20px;
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 3px;
    }
    .nav-brand span { color: #00aaff; }
    .nav-user-stats {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .balance-box {
      background: #061527;
      border: 1px solid #1e3a8a;
      border-radius: 8px;
      padding: 5px 12px;
      display: flex;
      align-items: center;
      gap: 6px;
      font-family: 'Roboto Mono', monospace;
      font-weight: 700;
      font-size: 13px;
      color: #fbbf24;
    }
    .balance-box .currency { color: #94a3b8; font-size: 11px; }
    .btn-dep {
      background: linear-gradient(180deg, #22c55e 0%, #15803d 100%);
      color: #fff;
      font-weight: 800;
      font-size: 11px;
      padding: 6px 14px;
      border-radius: 6px;
      text-decoration: none;
      text-transform: uppercase;
      box-shadow: 0 2px 8px rgba(34,197,94,0.4);
      display: inline-flex;
      align-items: center;
      gap: 4px;
      border: none;
      cursor: pointer;
    }

    /* Main Stage Container */
    .game-main-wrapper {
      position: relative;
      width: 100%;
      height: calc(100vh - 48px);
      display: flex;
      flex-direction: column;
      background: #020712;
      overflow: hidden;
    }

    /* Background Artworks */
    .bg-stage-layer {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center bottom;
      transition: background-image 0.5s ease;
      z-index: 1;
    }
    .bg-stage-layer.lobby-bg {
      background-image: url('/heads-or-tails/start-background.f43dc2bae9fa.jpg');
    }
    .bg-stage-layer.fixed-bg {
      background-image: url('/heads-or-tails/fix-background.06e37cff9f16.jpg');
    }
    .bg-stage-layer.doubling-bg {
      background-image: url('/heads-or-tails/raise-background.1fd52c82dfb4.jpg');
    }

    /* Rain Canvas */
    #vfx-canvas {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: 2;
      pointer-events: none;
    }
    .lightning-overlay {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 60% 20%, rgba(200, 230, 255, 0.45), transparent 70%);
      opacity: 0;
      z-index: 3;
      pointer-events: none;
      transition: opacity 0.1s ease-out;
    }
    .lightning-overlay.flash { opacity: 1; }

    /* Top Bar inside Game */
    .game-top-bar {
      position: relative;
      z-index: 20;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 24px;
      width: 100%;
    }
    .breadcrumbs {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-weight: 700;
      color: #94a3b8;
      letter-spacing: 0.5px;
    }
    .breadcrumbs a { color: #60a5fa; text-decoration: none; }
    .breadcrumbs a:hover { text-decoration: underline; }
    .breadcrumbs span.current { color: #f5c842; font-weight: 800; }

    .jackpot-badge-btn {
      width: 170px;
      height: 34px;
      background: url('/heads-or-tails/jackpot-header-bg.1b89dcf9335b.png') no-repeat center center;
      background-size: contain;
      cursor: pointer;
      transition: transform 0.2s;
      filter: drop-shadow(0 0 10px rgba(234, 179, 8, 0.6));
    }
    .jackpot-badge-btn:hover { transform: scale(1.05); }

    /* Right Sidebar Icons Menu */
    .right-sidebar-menu {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 25;
    }
    .side-icon-btn {
      width: 36px;
      height: 36px;
      background: rgba(15, 23, 42, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 8px;
      color: #cbd5e1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s;
      backdrop-filter: blur(8px);
    }
    .side-icon-btn:hover {
      background: rgba(30, 58, 138, 0.9);
      color: #facc15;
      border-color: #facc15;
      transform: scale(1.1);
    }

    /* ==========================================================================
       VIEW 1: LOBBY
       ========================================================================== */
    .lobby-view-container {
      position: relative;
      z-index: 10;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px 20px 20px;
    }
    .lobby-logo-wrapper {
      margin-top: 5px;
      margin-bottom: 16px;
      text-align: center;
    }
    .lobby-logo-img {
      max-width: 260px;
      height: auto;
      filter: drop-shadow(0 0 20px rgba(245, 200, 66, 0.6));
    }

    .cards-row {
      display: flex;
      justify-content: center;
      align-items: stretch;
      gap: 32px;
      max-width: 900px;
      width: 100%;
      margin: 0 auto;
    }
    @media (max-width: 768px) {
      .cards-row { flex-direction: column; align-items: center; gap: 24px; }
    }

    .mode-card {
      flex: 1;
      max-width: 400px;
      width: 100%;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.3s ease;
    }
    .mode-card:hover { transform: translateY(-5px); }

    .card-wood-banner {
      width: 100%;
      height: 64px;
      background: linear-gradient(180deg, #c2410c 0%, #7c2d12 40%, #431407 100%);
      border: 3px solid #b45309;
      border-radius: 12px 12px 0 0;
      box-shadow: 0 6px 14px rgba(0,0,0,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 5;
    }
    .card-banner-title {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 15px;
      color: #fff;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      text-shadow: 0 2px 4px rgba(0,0,0,0.8);
    }
    .card-seal-badge {
      position: absolute;
      top: -24px;
      left: 50%;
      transform: translateX(-50%);
      width: 54px;
      height: 54px;
      z-index: 6;
    }
    .card-seal-badge img { width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.8)); }

    .card-parchment-body {
      width: 100%;
      min-height: 270px;
      background: url('/heads-or-tails/assets/parchment_scroll.png') no-repeat center center;
      background-size: 100% 100%;
      box-shadow: 0 15px 35px rgba(0,0,0,0.85);
      padding: 38px 24px 24px 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      position: relative;
      margin-top: -12px;
      overflow: hidden;
    }
    .parchment-text {
      font-size: 13.5px;
      line-height: 1.6;
      color: #3b200b;
      font-weight: 700;
      text-align: center;
      margin: 8px 0;
      text-shadow: 0 1px 0 rgba(255,255,255,0.4);
    }

    .btn-play-authentic {
      width: 160px;
      height: 48px;
      background: url('/heads-or-tails/btnBliks.36ba16bbd08c.png') no-repeat center center;
      background-size: contain;
      border: none;
      outline: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 15px;
      letter-spacing: 2px;
      color: #064e3b;
      filter: drop-shadow(0 4px 10px rgba(34, 197, 94, 0.6));
      transition: transform 0.2s;
    }
    .btn-play-authentic:hover { transform: scale(1.08); }

    .lobby-bottom-dock {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      margin-top: 10px;
      z-index: 10;
    }
    .bottom-wooden-plank {
      width: 280px;
      height: 92px;
      background: url('/heads-or-tails/assets/lobby_bottom_dock.png') no-repeat center bottom;
      background-size: 100% 100%;
      padding-bottom: 12px;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 16px;
      filter: drop-shadow(0 -4px 16px rgba(0,0,0,0.8));
    }
    .round-control-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: radial-gradient(circle at 35% 30%, #fef08a 0%, #eab308 60%, #854d0e 100%);
      border: 2px solid #78350f;
      color: #451a03;
      font-weight: 900;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.5), inset 0 2px 4px rgba(255,255,255,0.6);
      transition: all 0.2s;
    }
    .round-control-btn:hover { transform: scale(1.1); box-shadow: 0 0 16px rgba(234, 179, 8, 0.8); }

    .demo-mode-pill {
      position: absolute;
      right: 20px;
      bottom: 12px;
      background: #0284c7;
      border: 1px solid #38bdf8;
      color: #fff;
      font-size: 11px;
      font-weight: 800;
      padding: 6px 14px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      text-transform: uppercase;
      box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
      z-index: 10;
    }
    .demo-mode-pill.real { background: #16a34a; border-color: #4ade80; }

    /* ==========================================================================
       VIEW 2: IN-GAME KRAKEN OCEAN VIEW (EXACT SCREENSHOT FIT)
       ========================================================================== */
    .game-play-view {
      position: relative;
      z-index: 10;
      flex: 1;
      display: none;
      flex-direction: row;
      align-items: stretch;
      justify-content: space-between;
      width: 100%;
      height: 100%;
      padding: 0 20px 0 20px;
    }
    .game-play-view.active { display: flex; }

    .game-center-stage {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      position: relative;
      height: 100%;
      padding-bottom: 0;
    }

    /* Top Wooden Banner with Burning Fire */
    .authentic-top-banner {
      width: 580px;
      max-width: 95%;
      height: 100px;
      background: url('/heads-or-tails/assets/top_banner.png') no-repeat center center;
      background-size: 100% 100%;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: -6px;
      filter: drop-shadow(0 6px 16px rgba(0,0,0,0.8));
      z-index: 15;
    }
    .top-banner-label {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 14.5px;
      color: #2b1103;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      text-shadow: 0 1px 0 rgba(255,255,255,0.4);
      text-align: center;
      margin-top: 18px;
      padding: 0 60px;
    }
    .banner-fire-container {
      position: absolute;
      right: 2px;
      top: 12px;
      width: 90px;
      height: 90px;
      pointer-events: none;
      z-index: 16;
    }
    .banner-fire-container canvas { width: 100%; height: 100%; }

    /* 3D Realistic Coin Floating (NO BOX BEHIND IT!) */
    .coin-3d-stage {
      position: relative;
      width: 170px;
      height: 170px;
      margin: auto 0;
      display: flex;
      align-items: center;
      justify-content: center;
      perspective: 1200px;
      z-index: 12;
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
    }

    .coin-3d-flipper {
      width: 150px;
      height: 150px;
      position: relative;
      transform-style: preserve-3d;
      background: transparent !important;
    }

    /* Continuous 3D Idle Rotation */
    .coin-3d-flipper.idling {
      animation: coinIdleSpin 4s linear infinite;
    }
    @keyframes coinIdleSpin {
      0% { transform: rotateY(0deg); }
      100% { transform: rotateY(360deg); }
    }

    /* High Speed Toss Animation */
    .coin-3d-flipper.flipping {
      animation: coin3DFlip 1.2s cubic-bezier(0.2, 0.8, 0.2, 1) forwards !important;
    }
    @keyframes coin3DFlip {
      0% { transform: translateY(0) scale(1) rotateY(0deg) rotateX(0deg); }
      30% { transform: translateY(-130px) scale(1.25) rotateY(900deg) rotateX(25deg); }
      70% { transform: translateY(-60px) scale(1.15) rotateY(1800deg) rotateX(12deg); }
      100% { transform: translateY(0) scale(1) rotateY(2520deg) rotateX(0deg); }
    }

    .coin-face-sprite {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      filter: drop-shadow(0 12px 25px rgba(0,0,0,0.9)) drop-shadow(0 0 25px rgba(245, 200, 66, 0.6));
    }
    .coin-face-sprite.heads-face {
      background: url('/heads-or-tails/assets/coin_heads.png') no-repeat center center;
      background-size: contain;
    }
    .coin-face-sprite.tails-face {
      background: url('/heads-or-tails/assets/coin_tails.png') no-repeat center center;
      background-size: contain;
      transform: rotateY(180deg);
    }

    /* Bottom Control Group (Sitting at the Bottom of Screen) */
    .bottom-controls-group {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      max-width: 580px;
      margin-bottom: 0;
      position: relative;
      z-index: 15;
    }

    /* Choice Buttons: HEADS (Cyan) & TAILS (Yellow) sitting above the wooden base plank */
    .choice-pills-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      width: 100%;
      max-width: 440px;
      margin-bottom: -18px;
      position: relative;
      z-index: 18;
    }
    .btn-choice-pill {
      flex: 1;
      height: 44px;
      border-radius: 22px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 13.5px;
      letter-spacing: 1px;
      cursor: pointer;
      border: 2px solid transparent;
      box-shadow: 0 6px 14px rgba(0,0,0,0.6);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-choice-pill.heads-pill {
      background: linear-gradient(180deg, #38bdf8 0%, #0284c7 60%, #0369a1 100%);
      color: #fff;
      border-color: #7dd3fc;
    }
    .btn-choice-pill.tails-pill {
      background: linear-gradient(180deg, #facc15 0%, #eab308 60%, #ca8a04 100%);
      color: #451a03;
      border-color: #fef08a;
    }
    .btn-choice-pill:hover { transform: scale(1.04); }
    .btn-choice-pill.selected {
      transform: scale(1.06);
      box-shadow: 0 0 20px rgba(245, 200, 66, 0.9), inset 0 0 8px rgba(255,255,255,0.8);
      border-color: #ffffff;
    }
    .btn-choice-pill .choice-coin-img {
      width: 30px;
      height: 30px;
      object-fit: contain;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.6));
    }

    /* Banner Seals */
    .banner-seal-center {
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 20;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Fixed Stake Wide Dock */
    .fixed-stake-base-dock {
      width: 580px;
      max-width: 100%;
      height: 140px;
      background: url('/heads-or-tails/assets/fixed_bottom_dock.png') no-repeat center bottom;
      background-size: 100% 100%;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 12px 28px 12px 28px;
      filter: drop-shadow(0 -6px 20px rgba(0,0,0,0.85));
      z-index: 15;
    }
    .fixed-dock-chips-row {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      margin-top: 4px;
    }
    .fixed-chips-title {
      font-size: 9.5px;
      font-weight: 800;
      color: #3b1805;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-shadow: 0 1px 0 rgba(255,255,255,0.4);
    }
    .fixed-chips-list {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .btn-fixed-chip {
      padding: 3px 12px;
      border-radius: 12px;
      background: #1c0b02;
      border: 1px solid #78350f;
      color: #fef08a;
      font-family: 'Roboto Mono', monospace;
      font-size: 11.5px;
      font-weight: 800;
      cursor: pointer;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.8);
      transition: all 0.2s;
    }
    .btn-fixed-chip:hover, .btn-fixed-chip.active {
      background: linear-gradient(180deg, #facc15 0%, #ca8a04 100%);
      color: #451a03;
      border-color: #fef08a;
      transform: scale(1.08);
    }
    .fixed-dock-bottom-bar {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .fixed-stake-input-pill {
      background: #1c0b02;
      border: 1.5px solid #78350f;
      border-radius: 16px;
      padding: 5px 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #fff;
      font-family: 'Roboto Mono', monospace;
      font-size: 13.5px;
      font-weight: 800;
      cursor: pointer;
      transition: all 0.2s;
    }
    .fixed-stake-input-pill:hover { border-color: #facc15; background: #2b1103; }

    /* Authentic Wooden Base Board Plank */
    .authentic-base-dock {
      width: 580px;
      max-width: 100%;
      height: 140px;
      background: url('/heads-or-tails/assets/wooden_bottom_plank.png') no-repeat center bottom;
      background-size: 100% 100%;
      position: relative;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      padding: 0 32px 16px 32px;
      filter: drop-shadow(0 -6px 20px rgba(0,0,0,0.8));
      z-index: 15;
    }

    .base-dock-left {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }

    /* Big Glowing Circular Toss Button */
    .btn-toss-center {
      width: 58px;
      height: 58px;
      border-radius: 50%;
      background: linear-gradient(180deg, #38bdf8 0%, #00b4d8 50%, #0077b6 100%);
      border: 3px solid #e0f2fe;
      box-shadow: 0 6px 18px rgba(0,0,0,0.6), inset 0 2px 4px rgba(255,255,255,0.8), 0 0 24px rgba(0, 180, 216, 0.9);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 22px;
      cursor: pointer;
      margin-bottom: 12px;
      transition: all 0.2s;
    }
    .btn-toss-center:hover { transform: scale(1.12); box-shadow: 0 8px 30px rgba(0, 180, 216, 1); }
    .btn-toss-center:active { transform: scale(0.95); }
    .btn-toss-center.spinning { opacity: 0.6; pointer-events: none; }

    /* Current Stake Capsule */
    .current-stake-box {
      background: #1c0b02;
      border: 1.5px solid #78350f;
      border-radius: 18px;
      padding: 5px 14px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      cursor: pointer;
      margin-bottom: 8px;
      transition: all 0.2s;
    }
    .current-stake-box:hover { border-color: #facc15; background: #2b1103; }
    .stake-title { font-size: 9.5px; color: #fdba74; text-transform: uppercase; font-weight: 700; }
    .stake-val { font-family: 'Roboto Mono', monospace; font-weight: 800; font-size: 13.5px; color: #fff; }

    /* ==========================================================================
       RIGHT DOUBLING LADDER (USING AUTHENTIC LADDER WOOD PANEL)
       ========================================================================== */
    .doubling-ladder-wrapper {
      width: 290px;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      z-index: 15;
      margin-left: 10px;
      margin-top: 6px;
    }
    @media (max-width: 900px) {
      .doubling-ladder-wrapper { display: none; }
    }

    .steering-wheel-header {
      width: 68px;
      height: 68px;
      position: relative;
      margin-bottom: -18px;
      z-index: 16;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .wheel-bg-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.8));
    }
    .btn-wheel-home {
      position: relative;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: radial-gradient(circle at 35% 30%, #fef08a 0%, #eab308 60%, #854d0e 100%);
      border: 2px solid #78350f;
      color: #451a03;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.6);
      transition: all 0.2s;
      z-index: 2;
    }
    .btn-wheel-home:hover { transform: scale(1.15); box-shadow: 0 0 16px rgba(234, 179, 8, 0.9); }

    /* Authentic Wooden Ladder Panel using the exact uploaded image */
    .authentic-ladder-cabinet {
      width: 100%;
      height: 520px;
      background: url('/heads-or-tails/assets/ladder_wood_panel.png') no-repeat center center;
      background-size: 100% 100%;
      padding: 30px 18px 18px 18px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 7px;
      filter: drop-shadow(0 12px 30px rgba(0,0,0,0.9));
    }
    .ladder-cabinet-title {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 11px;
      color: #3b1805;
      text-align: center;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 6px;
      text-shadow: 0 1px 0 rgba(255,255,255,0.4);
    }
    .ladder-steps-list {
      display: flex;
      flex-direction: column;
      gap: 6px;
      width: 100%;
    }
    .ladder-step-bar {
      width: 100%;
      height: 38px;
      background: rgba(43, 17, 3, 0.85);
      border: 1.5px solid #5a2306;
      border-radius: 19px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      font-family: 'Roboto Mono', monospace;
      font-size: 13px;
      font-weight: 700;
      color: #fdba74;
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.6);
      transition: all 0.3s;
    }
    .ladder-step-bar .multiplier-tag { font-size: 11px; color: #9a3412; font-weight: 800; }
    .ladder-step-bar.active {
      background: linear-gradient(90deg, #ca8a04 0%, #eab308 50%, #facc15 100%);
      border-color: #fff;
      color: #451a03;
      font-weight: 900;
      transform: scale(1.04);
      box-shadow: 0 0 18px rgba(234, 179, 8, 0.9), inset 0 1px 2px rgba(255,255,255,0.8);
    }
    .ladder-step-bar.active .multiplier-tag { color: #713f12; }
    .ladder-step-bar.won-past {
      background: #14532d;
      border-color: #22c55e;
      color: #4ade80;
    }

    .doubling-action-box {
      width: 100%;
      margin-top: 8px;
      display: none;
      flex-direction: column;
      gap: 8px;
    }
    .doubling-action-box.show { display: flex; }
    .btn-take-winnings {
      width: 100%;
      height: 40px;
      background: linear-gradient(180deg, #22c55e 0%, #15803d 100%);
      border: 2px solid #86efac;
      border-radius: 20px;
      color: #fff;
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 12.5px;
      letter-spacing: 1px;
      text-transform: uppercase;
      box-shadow: 0 4px 12px rgba(34, 197, 94, 0.6);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }
    .btn-take-winnings:hover { transform: scale(1.05); }

    /* Modals */
    .modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.82);
      z-index: 1000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 16px;
      backdrop-filter: blur(6px);
    }
    .modal-backdrop.open { display: flex; }
    .modal-card {
      max-width: 480px;
      width: 100%;
      background: linear-gradient(180deg, #9a3412 0%, #7c2d12 40%, #431407 100%);
      border: 3px solid #b45309;
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.9);
      position: relative;
    }
    .modal-close-btn {
      position: absolute;
      top: 14px;
      right: 14px;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #2b1103;
      border: 1px solid #78350f;
      color: #fdba74;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
    }
    .modal-title {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      font-size: 18px;
      color: #fef08a;
      text-align: center;
      margin-bottom: 16px;
      text-transform: uppercase;
    }

    .preset-chips-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
      margin: 16px 0;
    }
    .btn-chip {
      background: #2b1103;
      border: 1.5px solid #78350f;
      border-radius: 12px;
      padding: 10px;
      font-family: 'Roboto Mono', monospace;
      font-weight: 700;
      font-size: 14px;
      color: #fff;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-chip:hover, .btn-chip.active { background: #eab308; color: #451a03; border-color: #fef08a; transform: scale(1.05); }

    .stake-input-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 16px;
    }
    .stake-input-field {
      flex: 1;
      height: 44px;
      background: #1c0b02;
      border: 2px solid #78350f;
      border-radius: 12px;
      padding: 0 16px;
      font-family: 'Roboto Mono', monospace;
      font-size: 16px;
      font-weight: 800;
      color: #fbbf24;
      outline: none;
    }
    .stake-math-btn {
      width: 44px;
      height: 44px;
      background: #2b1103;
      border: 1.5px solid #78350f;
      border-radius: 12px;
      color: #fdba74;
      font-weight: 900;
      cursor: pointer;
    }

    .rules-body-scroll {
      max-height: 380px;
      overflow-y: auto;
      color: #fde68a;
      font-size: 13.5px;
      line-height: 1.6;
      padding-right: 8px;
    }
    .rules-body-scroll h4 { color: #fff; font-family: 'Cinzel', serif; margin: 12px 0 4px 0; }

    .toast-status-pill {
      position: absolute;
      top: 64px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(15, 23, 42, 0.95);
      border: 1.5px solid #f59e0b;
      color: #fef08a;
      font-weight: 700;
      font-size: 13px;
      padding: 6px 20px;
      border-radius: 20px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.6);
      z-index: 30;
      display: none;
      animation: fadeIn 0.3s ease;
    }
    .toast-status-pill.show { display: block; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translate(-50%, -10px); }
      to { opacity: 1; transform: translate(-50%, 0); }
    }
  </style>
</head>
<body>

  <!-- Top 1xBet Navigation -->
  <nav class="top-navbar">
    <a href="{{ route('home') }}" class="nav-brand">
      1X<span>GAMES</span>
    </a>
    <div class="nav-user-stats">
      <div class="balance-box">
        <i class="fa-solid fa-wallet text-amber-400"></i>
        <span id="nav-balance-val">{{ number_format(Auth::check() ? Auth::user()->balance : 1000.00, 2) }}</span>
        <span class="currency">৳</span>
      </div>
      @auth
        <a href="{{ route('customer.deposit') }}" class="btn-dep">
          <i class="fa-solid fa-plus"></i> Deposit
        </a>
        <a href="{{ route('dashboard') }}" class="btn-nav-icon" title="Dashboard">
          <i class="fa-solid fa-user"></i>
        </a>
      @else
        <a href="{{ route('login') }}" class="btn-dep">
          <i class="fa-solid fa-right-to-bracket"></i> Login
        </a>
      @endauth
    </div>
  </nav>

  <!-- Main Game Stage -->
  <main class="game-main-wrapper">
    
    <!-- Background Canvas and Artwork Layers -->
    <div id="bg-layer" class="bg-stage-layer lobby-bg"></div>
    <div id="lightning-fx" class="lightning-overlay"></div>
    <canvas id="vfx-canvas"></canvas>

    <!-- Sub-header: Breadcrumbs & Jackpot Button -->
    <header class="game-top-bar">
      <div class="breadcrumbs">
        <a href="{{ route('home') }}">1XGAMES</a>
        <span>/</span>
        <a href="{{ route('dashboard') }}">OTHER GAMES</a>
        <span>/</span>
        <span class="current">HEADS OR TAILS</span>
      </div>

      <div class="jackpot-badge-btn" onclick="openRulesModal('jackpot')"></div>
    </header>

    <!-- Right Sidebar Menu -->
    <aside class="right-sidebar-menu">
      <button class="side-icon-btn" onclick="openRulesModal('rules')" title="Rules"><i class="fa-solid fa-gear"></i></button>
      <button class="side-icon-btn" onclick="openRulesModal('jackpot')" title="Jackpot"><i class="fa-solid fa-gift"></i></button>
      <button class="side-icon-btn" onclick="triggerLuckyEffect()" title="Lucky"><i class="fa-solid fa-dice-five"></i></button>
      <button class="side-icon-btn" onclick="toggleSound()" id="sidebar-sound-btn" title="Sound"><i class="fa-solid fa-volume-high"></i></button>
      <button class="side-icon-btn" onclick="openStakeModal()" title="Bet"><i class="fa-solid fa-coins"></i></button>
    </aside>

    <!-- Status Toast -->
    <div id="status-toast" class="toast-status-pill"></div>

    <!-- ==========================================================================
         VIEW 1: MODE SELECTION LOBBY
         ========================================================================== -->
    <section id="lobby-section" class="lobby-view-container">
      
      <div class="lobby-logo-wrapper">
        <img src="/heads-or-tails/logo-start.8deede2e669d.png" alt="Heads or Tails Logo" class="lobby-logo-img">
      </div>

      <div class="cards-row">
        
        <!-- CARD 1: FIXED STAKE -->
        <article class="mode-card">
          <div class="card-wood-banner">
            <div class="card-seal-badge">
              <img src="/heads-or-tails/wheel.5b83100ce091.png" alt="Steering Wheel Seal">
            </div>
            <h2 class="card-banner-title">FIXED STAKE</h2>
          </div>
          <div class="card-parchment-body">
            <p class="parchment-text">
              Choose your stake and flip the coin.<br>
              Guessed right? Congratulations!<br>
              Your stake is doubled! Take your winnings!
            </p>
            <button class="btn-play-authentic" onclick="enterGameMode('fixed')">PLAY</button>
          </div>
        </article>

        <!-- CARD 2: DOUBLING YOUR STAKE -->
        <article class="mode-card">
          <div class="card-wood-banner">
            <div class="card-seal-badge" style="width: 70px; display: flex; align-items: center; gap: 2px;">
              <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10 Coin" style="width: 32px; height: 32px;">
              <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" style="width: 32px; height: 32px;">
            </div>
            <h2 class="card-banner-title">DOUBLING YOUR STAKE</h2>
            <div class="banner-fire-wrapper">
              <canvas id="fire-canvas-lobby"></canvas>
            </div>
          </div>
          <div class="card-parchment-body">
            <p class="parchment-text">
              Start with a bet of 5 EUR and flip the coin.<br>
              Guessed right? You can take your winnings of 10 EUR<br>
              or flip the coin again...
            </p>
            <button class="btn-play-authentic" onclick="enterGameMode('doubling')">PLAY</button>
          </div>
        </article>

      </div>

      <footer class="lobby-bottom-dock">
        <div class="bottom-wooden-plank">
          <button class="round-control-btn" onclick="openRulesModal('rules')" title="Rules">?</button>
          <button class="round-control-btn" onclick="toggleSound()" id="lobby-sound-btn" title="Sound">
            <i class="fa-solid fa-music"></i>
          </button>
        </div>

        <div class="demo-mode-pill" id="demo-mode-toggle" onclick="toggleDemoMode()">
          <i class="fa-solid fa-circle-dot"></i> <span id="demo-mode-text">DEMO MODE</span> <i class="fa-solid fa-chevron-up"></i>
        </div>
      </footer>

    </section>

    <!-- ==========================================================================
         VIEW 2: IN-GAME KRAKEN OCEAN VIEW (EXACT FIT)
         ========================================================================== -->
    <section id="game-section" class="game-play-view">
      
      <!-- Center Ocean Stage -->
      <div class="game-center-stage">
        
        <!-- Top Wooden Banner with Mode Seals & Fire -->
        <div class="authentic-top-banner">
          <!-- Fixed Mode Seal (Ship Wheel + Kraken Coin) -->
          <div class="banner-seal-center" id="seal-fixed" style="display: none;">
            <img src="/heads-or-tails/wheel.5b83100ce091.png" alt="Wheel" style="width: 52px; height: 52px; position: absolute; top: -14px;">
            <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" style="width: 32px; height: 32px; position: absolute; top: -4px;">
          </div>
          <!-- Doubling Mode Seal (Anchor + Kraken + 10 Coins) -->
          <div class="banner-seal-center" id="seal-doubling" style="display: flex;">
            <div style="position: absolute; top: -18px; display: flex; align-items: center; gap: 2px;">
              <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" style="width: 32px; height: 32px;">
              <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10" style="width: 32px; height: 32px;">
            </div>
          </div>

          <span class="top-banner-label" id="game-prompt-title">MAKE YOUR CHOICE! HEADS OR TAILS?</span>
          
          <div class="banner-fire-container" id="banner-fire-container">
            <canvas id="fire-canvas-game"></canvas>
          </div>
        </div>

        <!-- 3D Realistic Coin (Free floating, continuously spinning idle & toss!) -->
        <div class="coin-3d-stage">
          <div class="coin-3d-flipper idling" id="coin-flipper">
            <div class="coin-face-sprite heads-face"></div>
            <div class="coin-face-sprite tails-face"></div>
          </div>
        </div>

        <!-- Bottom Controls Group -->
        <div class="bottom-controls-group">
          
          <!-- Choice Pills: Cyan HEADS & Yellow TAILS -->
          <div class="choice-pills-row">
            <button class="btn-choice-pill heads-pill selected" id="btn-choice-heads" onclick="selectChoice('heads')">
              <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" class="choice-coin-img">
              <span>HEADS</span>
              <div style="width: 20px;"></div>
            </button>
            <button class="btn-choice-pill tails-pill" id="btn-choice-tails" onclick="selectChoice('tails')">
              <div style="width: 20px;"></div>
              <span>TAILS</span>
              <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10 Coin" class="choice-coin-img">
            </button>
          </div>

          <!-- DOCK 1: FIXED STAKE DOCK (Wide plank with Chips & Direct Input) -->
          <div class="fixed-stake-base-dock" id="fixed-stake-dock" style="display: none;">
            <div class="fixed-dock-chips-row">
              <span class="fixed-chips-title">YOUR STAKE</span>
              <div class="fixed-chips-list">
                <button class="btn-fixed-chip" onclick="setChipStake(10)">10</button>
                <button class="btn-fixed-chip" onclick="setChipStake(20)">20</button>
                <button class="btn-fixed-chip" onclick="setChipStake(50)">50</button>
                <button class="btn-fixed-chip" onclick="setChipStake(100)">100</button>
                <button class="btn-fixed-chip" onclick="setChipStake(250)">250</button>
                <button class="btn-fixed-chip" onclick="setChipStake(500)">500</button>
              </div>
            </div>

            <div class="fixed-dock-bottom-bar">
              <div class="base-dock-left">
                <button class="round-control-btn" onclick="openRulesModal('rules')" title="Rules">?</button>
                <button class="round-control-btn" onclick="toggleSound()" title="Sound"><i class="fa-solid fa-music"></i></button>
              </div>

              <button class="btn-toss-center" id="btn-fixed-toss" onclick="handleCoinToss()" title="Flip Coin">
                <i class="fa-solid fa-play"></i>
              </button>

              <div class="fixed-stake-input-pill" onclick="openStakeModal()">
                <span id="fixed-stake-val">50</span> <span>✕</span>
              </div>
            </div>
          </div>

          <!-- DOCK 2: DOUBLING STAKE DOCK (Arched dock with Current Stake capsule) -->
          <div class="authentic-base-dock" id="doubling-stake-dock" style="display: flex;">
            <div class="base-dock-left">
              <button class="round-control-btn" onclick="openRulesModal('rules')" title="Rules">?</button>
              <button class="round-control-btn" onclick="toggleSound()" title="Sound"><i class="fa-solid fa-music"></i></button>
            </div>

            <!-- Big Glowing Circular Play / Flip Button -->
            <button class="btn-toss-center" id="btn-doubling-toss" onclick="handleCoinToss()" title="Flip Coin">
              <i class="fa-solid fa-play"></i>
            </button>

            <!-- Current Stake Capsule -->
            <div class="current-stake-box" onclick="openStakeModal()">
              <span class="stake-title">Current stake:</span>
              <span class="stake-val" id="current-stake-display">50 ৳</span>
            </div>
          </div>

        </div>

      </div>

      <!-- Right Sidebar Panel (Supports both FIXED STAKE and DOUBLING STAKE) -->
      <aside class="doubling-ladder-wrapper" id="doubling-ladder-aside" style="display: flex;">
        
        <!-- Ship Wheel Home Button -->
        <div class="steering-wheel-header">
          <img src="/heads-or-tails/wheel.5b83100ce091.png" alt="Steering Wheel" class="wheel-bg-img">
          <button class="btn-wheel-home" onclick="returnToLobby()" title="Return to Modes">
            <i class="fa-solid fa-house"></i>
          </button>
        </div>

        <!-- Authentic Wooden Cabinet -->
        <div class="authentic-ladder-cabinet">
          <h3 class="ladder-cabinet-title" id="ladder-title-text">DOUBLING YOUR STAKE</h3>
          
          <div class="ladder-steps-list" id="ladder-steps-list">
            <div class="ladder-step-bar" id="step-7">
              <span class="step-amt">6400 ৳</span>
              <span class="multiplier-tag">128X</span>
            </div>
            <div class="ladder-step-bar" id="step-6">
              <span class="step-amt">3200 ৳</span>
              <span class="multiplier-tag">64X</span>
            </div>
            <div class="ladder-step-bar" id="step-5">
              <span class="step-amt">1600 ৳</span>
              <span class="multiplier-tag">32X</span>
            </div>
            <div class="ladder-step-bar" id="step-4">
              <span class="step-amt">800 ৳</span>
              <span class="multiplier-tag">16X</span>
            </div>
            <div class="ladder-step-bar" id="step-3">
              <span class="step-amt">400 ৳</span>
              <span class="multiplier-tag">8X</span>
            </div>
            <div class="ladder-step-bar" id="step-2">
              <span class="step-amt">200 ৳</span>
              <span class="multiplier-tag">4X</span>
            </div>
            <div class="ladder-step-bar" id="step-1">
              <span class="step-amt">100 ৳</span>
              <span class="multiplier-tag">2X</span>
            </div>
          </div>

          <!-- Doubling Cashout Box -->
          <div class="doubling-action-box" id="doubling-action-box">
            <button class="btn-take-winnings" id="btn-take-winnings" onclick="handleCashout()">
              <i class="fa-solid fa-sack-dollar"></i> TAKE WINNINGS
            </button>
          </div>
        </div>

      </aside>

      <!-- Fixed Mode Home Button -->
      <div id="fixed-mode-home-btn" style="display: none; position: absolute; right: 24px; top: 20px; z-index: 25;">
        <button class="round-control-btn" onclick="returnToLobby()" title="Return to lobby">
          <i class="fa-solid fa-house"></i>
        </button>
      </div>

    </section>

  </main>

  <!-- Stake Modal -->
  <div class="modal-backdrop" id="stake-modal">
    <div class="modal-card">
      <button class="modal-close-btn" onclick="closeStakeModal()"><i class="fa-solid fa-xmark"></i></button>
      <h3 class="modal-title"><i class="fa-solid fa-coins text-amber-400"></i> SELECT STAKE</h3>
      
      <div class="stake-input-row">
        <button class="stake-math-btn" onclick="mathStake(0.5)">/2</button>
        <input type="number" id="stake-num-input" class="stake-input-field" value="50" min="1" max="10000">
        <button class="stake-math-btn" onclick="mathStake(2)">2X</button>
      </div>

      <div class="preset-chips-grid">
        <button class="btn-chip" onclick="setPresetStake(10)">10 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(50)">50 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(100)">100 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(250)">250 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(500)">500 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(1000)">1000 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(2500)">2500 ৳</button>
        <button class="btn-chip" onclick="setPresetStake(5000)">5000 ৳</button>
      </div>

      <button class="btn-play-authentic" style="width: 100%;" onclick="confirmStakeModal()">CONFIRM STAKE</button>
    </div>
  </div>

  <!-- Rules Modal -->
  <div class="modal-backdrop" id="rules-modal">
    <div class="modal-card">
      <button class="modal-close-btn" onclick="closeRulesModal()"><i class="fa-solid fa-xmark"></i></button>
      <h3 class="modal-title" id="rules-modal-title">GAME RULES</h3>
      
      <div class="rules-body-scroll" id="rules-modal-content">
        <h4>1. GENERAL INFORMATION</h4>
        <p>Heads or Tails is an ocean-themed pirate betting game. Pick either Heads (Kraken) or Tails (Gold 10) and flip the gold coin.</p>
        
        <h4>2. FIXED STAKE MODE</h4>
        <p>Select your stake and flip the coin. Guessed right? Congratulations! Your stake is doubled (2.0x / 1.96x payout)! You immediately receive your winnings into your balance.</p>

        <h4>3. DOUBLING YOUR STAKE MODE</h4>
        <p>Start with a base bet and flip the coin. If you guess right, your win amount doubles at each consecutive step:</p>
        <ul style="margin-left: 20px; margin-top: 6px;">
          <li>Step 1: 2.0X Multiplier</li>
          <li>Step 2: 4.0X Multiplier</li>
          <li>Step 3: 8.0X Multiplier</li>
          <li>Step 4: 16.0X Multiplier</li>
          <li>Step 5: 32.0X Multiplier</li>
          <li>Step 6: 64.0X Multiplier</li>
          <li>Step 7: 128.0X Maximum Multiplier</li>
        </ul>
        <p style="margin-top: 8px;">After each winning toss, you can either collect your accumulated winnings by clicking <b>TAKE WINNINGS</b> or continue flipping for the next doubled prize!</p>
      </div>
    </div>
  </div>

  <!-- JavaScript Engine -->
  <script>
    let currentMode = 'lobby';
    let currentChoice = 'heads';
    let currentStake = 50;
    let isDemoMode = false;
    let isFlipping = false;
    let doublingStep = 1;
    let currentDoublingWin = 0;
    let userBalance = {{ Auth::check() ? (float)Auth::user()->balance : 1000.00 }};
    let soundEnabled = true;
    let audioCtx = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function getAudioCtx() {
      if (!audioCtx) {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (AudioContext) audioCtx = new AudioContext();
      }
      if (audioCtx && audioCtx.state === 'suspended') {
        audioCtx.resume();
      }
      return audioCtx;
    }

    function playSound(type) {
      if (!soundEnabled) return;
      try {
        const ctx = getAudioCtx();
        if (!ctx) return;
        const now = ctx.currentTime;

        if (type === 'click') {
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();
          osc.type = 'sine';
          osc.frequency.setValueAtTime(600, now);
          osc.frequency.exponentialRampToValueAtTime(300, now + 0.05);
          gain.gain.setValueAtTime(0.3, now);
          gain.gain.linearRampToValueAtTime(0.01, now + 0.05);
          osc.connect(gain);
          gain.connect(ctx.destination);
          osc.start(now);
          osc.stop(now + 0.05);
        } else if (type === 'flip') {
          for (let i = 0; i < 6; i++) {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(400 + i * 150, now + i * 0.15);
            gain.gain.setValueAtTime(0.2, now + i * 0.15);
            gain.gain.linearRampToValueAtTime(0.01, now + i * 0.15 + 0.08);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(now + i * 0.15);
            osc.stop(now + i * 0.15 + 0.08);
          }
        } else if (type === 'land') {
          const osc = ctx.createOscillator();
          const osc2 = ctx.createOscillator();
          const gain = ctx.createGain();
          osc.type = 'sine';
          osc2.type = 'triangle';
          osc.frequency.setValueAtTime(1400, now);
          osc.frequency.exponentialRampToValueAtTime(800, now + 0.2);
          osc2.frequency.setValueAtTime(2200, now);
          osc2.frequency.exponentialRampToValueAtTime(1100, now + 0.25);
          gain.gain.setValueAtTime(0.4, now);
          gain.gain.linearRampToValueAtTime(0.01, now + 0.3);
          osc.connect(gain);
          osc2.connect(gain);
          gain.connect(ctx.destination);
          osc.start(now);
          osc2.start(now);
          osc.stop(now + 0.3);
          osc2.stop(now + 0.3);
        } else if (type === 'win') {
          [523.25, 659.25, 783.99, 1046.50, 1318.51].forEach((freq, idx) => {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(freq, now + idx * 0.09);
            gain.gain.setValueAtTime(0.35, now + idx * 0.09);
            gain.gain.linearRampToValueAtTime(0.01, now + idx * 0.09 + 0.25);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(now + idx * 0.09);
            osc.stop(now + idx * 0.09 + 0.25);
          });
        } else if (type === 'lose') {
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();
          osc.type = 'sawtooth';
          osc.frequency.setValueAtTime(180, now);
          osc.frequency.exponentialRampToValueAtTime(40, now + 0.4);
          gain.gain.setValueAtTime(0.4, now);
          gain.gain.linearRampToValueAtTime(0.01, now + 0.4);
          osc.connect(gain);
          gain.connect(ctx.destination);
          osc.start(now);
          osc.stop(now + 0.4);
        }
      } catch (e) {
        console.warn('Audio note:', e);
      }
    }

    function toggleSound() {
      soundEnabled = !soundEnabled;
      playSound('click');
      const icons = document.querySelectorAll('#lobby-sound-btn i, #game-sound-btn i, #sidebar-sound-btn i');
      icons.forEach(ic => {
        ic.className = soundEnabled ? 'fa-solid fa-music' : 'fa-solid fa-volume-xmark';
      });
      showToast(soundEnabled ? '🔊 Sound Enabled' : '🔇 Sound Muted');
    }

    function toggleDemoMode() {
      playSound('click');
      isDemoMode = !isDemoMode;
      const pill = document.getElementById('demo-mode-toggle');
      const text = document.getElementById('demo-mode-text');
      if (isDemoMode) {
        pill.classList.remove('real');
        text.innerText = 'DEMO MODE';
        showToast('🎮 Switched to Demo Mode');
      } else {
        pill.classList.add('real');
        text.innerText = 'REAL MONEY';
        showToast('💰 Switched to Real Money');
      }
    }

    function enterGameMode(mode) {
      playSound('click');
      currentMode = mode;
      doublingStep = 1;
      currentDoublingWin = 0;

      const bg = document.getElementById('bg-layer');
      const sealFixed = document.getElementById('seal-fixed');
      const sealDoubling = document.getElementById('seal-doubling');
      const fireContainer = document.getElementById('banner-fire-container');
      const fixedDock = document.getElementById('fixed-stake-dock');
      const doublingDock = document.getElementById('doubling-stake-dock');
      const ladderAside = document.getElementById('doubling-ladder-aside');
      const ladderTitle = document.getElementById('ladder-title-text');
      const ladderSteps = document.getElementById('ladder-steps-list');
      const doublingBox = document.getElementById('doubling-action-box');
      const promptTitle = document.getElementById('game-prompt-title');

      document.getElementById('lobby-section').style.display = 'none';
      document.getElementById('game-section').classList.add('active');

      const flipper = document.getElementById('coin-flipper');
      flipper.classList.add('idling');
      flipper.classList.remove('flipping');

      if (mode === 'fixed') {
        bg.className = 'bg-stage-layer fixed-bg';
        sealFixed.style.display = 'flex';
        sealDoubling.style.display = 'none';
        fireContainer.style.display = 'none';
        fixedDock.style.display = 'flex';
        doublingDock.style.display = 'none';
        
        ladderAside.style.display = 'flex';
        ladderTitle.innerText = 'FIXED STAKE';
        ladderSteps.style.display = 'none';
        doublingBox.classList.remove('show');
        promptTitle.innerText = 'MAKE YOUR CHOICE! HEADS OR TAILS?';
      } else {
        bg.className = 'bg-stage-layer doubling-bg';
        sealFixed.style.display = 'none';
        sealDoubling.style.display = 'flex';
        fireContainer.style.display = 'block';
        fixedDock.style.display = 'none';
        doublingDock.style.display = 'flex';
        
        ladderAside.style.display = 'flex';
        ladderTitle.innerText = 'DOUBLING YOUR STAKE';
        ladderSteps.style.display = 'flex';
        doublingBox.classList.remove('show');
        promptTitle.innerText = 'MAKE YOUR CHOICE! HEADS OR TAILS?';
        updateLadderUI();
      }

      updateStakeDisplay();
    }

    function setChipStake(val) {
      playSound('click');
      currentStake = val;
      updateStakeDisplay();
      showToast(`Stake: ${val} ৳`);
    }

    function returnToLobby() {
      playSound('click');
      if (currentDoublingWin > 0) {
        if (!confirm('You have active winnings on the ladder. Returning to lobby will claim them. Proceed?')) {
          return;
        }
        handleCashout();
      }
      currentMode = 'lobby';
      const bg = document.getElementById('bg-layer');
      bg.className = 'bg-stage-layer lobby-bg';

      document.getElementById('game-section').classList.remove('active');
      document.getElementById('lobby-section').style.display = 'flex';
    }

    function selectChoice(choice) {
      playSound('click');
      currentChoice = choice;
      document.getElementById('btn-choice-heads').classList.toggle('selected', choice === 'heads');
      document.getElementById('btn-choice-tails').classList.toggle('selected', choice === 'tails');
    }

    function updateLadderUI() {
      const base = currentStake;
      const multipliers = [2, 4, 8, 16, 32, 64, 128];

      multipliers.forEach((mult, idx) => {
        const stepNum = idx + 1;
        const el = document.getElementById(`step-${stepNum}`);
        if (el) {
          el.querySelector('.step-amt').innerText = (base * mult).toLocaleString() + ' ৳';
          el.className = 'ladder-step-bar';
          if (stepNum === doublingStep) {
            el.classList.add('active');
          } else if (stepNum < doublingStep) {
            el.classList.add('won-past');
          }
        }
      });
    }

    function updateStakeDisplay() {
      const display = document.getElementById('current-stake-display');
      if (display) display.innerText = currentStake.toLocaleString() + ' ৳';
      const fixedVal = document.getElementById('fixed-stake-val');
      if (fixedVal) fixedVal.innerText = currentStake.toLocaleString();
      
      const chips = document.querySelectorAll('.btn-fixed-chip');
      chips.forEach(c => {
        c.classList.toggle('active', Number(c.innerText) === currentStake);
      });

      if (currentMode === 'doubling') {
        updateLadderUI();
      }
    }

    function openStakeModal() {
      playSound('click');
      document.getElementById('stake-num-input').value = currentStake;
      document.getElementById('stake-modal').classList.add('open');
    }
    function closeStakeModal() {
      playSound('click');
      document.getElementById('stake-modal').classList.remove('open');
    }
    function setPresetStake(val) {
      playSound('click');
      document.getElementById('stake-num-input').value = val;
    }
    function mathStake(mult) {
      playSound('click');
      const input = document.getElementById('stake-num-input');
      let val = Math.max(1, Math.round(Number(input.value) * mult));
      input.value = val;
    }
    function confirmStakeModal() {
      playSound('click');
      const val = Number(document.getElementById('stake-num-input').value);
      if (val >= 1 && val <= 50000) {
        currentStake = val;
        updateStakeDisplay();
        closeStakeModal();
        showToast(`Stake set to ${currentStake} ৳`);
      }
    }

    function openRulesModal(type) {
      playSound('click');
      const modal = document.getElementById('rules-modal');
      const title = document.getElementById('rules-modal-title');
      if (type === 'jackpot') {
        title.innerText = '1XGAMES JACKPOT';
      } else {
        title.innerText = 'GAME RULES';
      }
      modal.classList.add('open');
    }
    function closeRulesModal() {
      playSound('click');
      document.getElementById('rules-modal').classList.remove('open');
    }

    function showToast(msg) {
      const toast = document.getElementById('status-toast');
      toast.innerText = msg;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function triggerLuckyEffect() {
      playSound('click');
      showToast('🍀 Fortune Favors the Bold!');
      confetti({ particleCount: 40, spread: 60, origin: { y: 0.7 } });
    }

    // ==========================================================================
    // COIN TOSS LOGIC
    // ==========================================================================
    async function handleCoinToss() {
      if (isFlipping) return;

      if (!isDemoMode && currentDoublingWin === 0 && currentStake > userBalance) {
        playSound('lose');
        showToast('⚠️ Insufficient balance! Please deposit.');
        return;
      }

      isFlipping = true;
      playSound('flip');

      const flipper = document.getElementById('coin-flipper');
      const tossBtn = document.getElementById('btn-main-toss');
      
      // Stop idle spin, start high speed flip
      flipper.classList.remove('idling');
      flipper.classList.add('flipping');
      tossBtn.classList.add('spinning');

      triggerLightning();

      const isContinuingDoubling = (currentMode === 'doubling' && doublingStep > 1 && currentDoublingWin > 0);

      try {
        const res = await fetch('/games/heads-or-tails/toss', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            amount: currentStake,
            side: currentChoice,
            mode: currentMode,
            step: doublingStep,
            is_continuing: isContinuingDoubling,
            is_demo: isDemoMode
          })
        });

        const data = await res.json();

        setTimeout(() => {
          flipper.classList.remove('flipping');
          tossBtn.classList.remove('spinning');
          isFlipping = false;

          if (data.error) {
            playSound('lose');
            showToast('❌ ' + data.error);
            flipper.classList.add('idling');
            return;
          }

          const winningSide = data.winning_side || 'heads';
          playSound('land');

          // Snap to winning face
          flipper.style.transform = winningSide === 'heads' ? 'rotateY(0deg)' : 'rotateY(180deg)';

          if (data.is_win) {
            playSound('win');
            confetti({ particleCount: 90, spread: 70, origin: { y: 0.55 } });

            if (currentMode === 'doubling') {
              currentDoublingWin = Number(data.win_amount);
              document.getElementById('game-prompt-title').innerText = `LUCKY YOU! CONTINUE?`;
              showToast(`🎉 STEP ${doublingStep} WON! ${currentDoublingWin.toLocaleString()} ৳`);
              
              if (doublingStep < 7) {
                doublingStep++;
                updateLadderUI();
                document.getElementById('doubling-action-box').classList.add('show');
                document.getElementById('btn-take-winnings').innerText = `TAKE WINNINGS (${currentDoublingWin.toLocaleString()} ৳)`;
              } else {
                showToast(`🏆 MAXIMUM MULTIPLIER 128X WON: ${currentDoublingWin.toLocaleString()} ৳!`);
                handleCashout();
              }
            } else {
              document.getElementById('game-prompt-title').innerText = `YOU WON ${Number(data.win_amount).toLocaleString()} ৳!`;
              showToast(`🎉 YOU WON ${Number(data.win_amount).toLocaleString()} ৳!`);
              if (typeof window.triggerWinCelebration === 'function') {
                window.triggerWinCelebration({
                  amount: data.win_amount,
                  multiplier: currentStake > 0 ? (data.win_amount / currentStake) : 2.0,
                  title: 'COIN TOSS WIN!'
                });
              }
              if (data.new_balance !== null && !isDemoMode) {
                userBalance = data.new_balance;
                document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
              } else if (isDemoMode) {
                userBalance += data.win_amount;
                document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
              }
            }

          } else {
            playSound('lose');
            document.getElementById('game-prompt-title').innerText = `BETTER LUCK NEXT TIME`;
            showToast(`💀 Coin landed on ${winningSide.toUpperCase()}. Game Over!`);
            
            if (currentMode === 'doubling') {
              doublingStep = 1;
              currentDoublingWin = 0;
              updateLadderUI();
              document.getElementById('doubling-action-box').classList.remove('show');
            }

            if (data.new_balance !== null && !isDemoMode) {
              userBalance = data.new_balance;
              document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
            } else if (isDemoMode && !isContinuingDoubling) {
              userBalance = Math.max(0, userBalance - currentStake);
              document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
            }
          }

          // Resume idle 3D spin after 2.5 seconds
          setTimeout(() => {
            if (!isFlipping) {
              flipper.style.transform = '';
              flipper.classList.add('idling');
            }
          }, 2500);

        }, 1200);

      } catch (err) {
        flipper.classList.remove('flipping');
        tossBtn.classList.remove('spinning');
        isFlipping = false;
        playSound('lose');
        showToast('❌ Network connection error');
        flipper.classList.add('idling');
      }
    }

    async function handleCashout() {
      if (currentDoublingWin <= 0) return;
      playSound('win');
      confetti({ particleCount: 120, spread: 80, origin: { y: 0.5 } });

      try {
        const res = await fetch('/games/heads-or-tails/cashout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            win_amount: currentDoublingWin,
            is_demo: isDemoMode
          })
        });

        const data = await res.json();
        if (data.success) {
          showToast(`💰 CASHED OUT ${currentDoublingWin.toLocaleString()} ৳!`);
          if (typeof window.triggerWinCelebration === 'function') {
            window.triggerWinCelebration({
              amount: currentDoublingWin,
              multiplier: Math.pow(2, doublingStep - 1),
              title: 'LADDER CASHOUT WIN!'
            });
          }
          if (data.new_balance !== null && !isDemoMode) {
            userBalance = data.new_balance;
            document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
          } else if (isDemoMode) {
            userBalance += currentDoublingWin;
            document.getElementById('nav-balance-val').innerText = userBalance.toLocaleString(undefined, {minimumFractionDigits: 2});
          }
        }
      } catch (e) {
        console.error(e);
      }

      doublingStep = 1;
      currentDoublingWin = 0;
      updateLadderUI();
      document.getElementById('doubling-action-box').classList.remove('show');
      document.getElementById('game-prompt-title').innerText = 'MAKE YOUR CHOICE! HEADS OR TAILS?';
    }

    // ==========================================================================
    // CANVAS VFX: RAIN & STORM LIGHTNING
    // ==========================================================================
    const vfxCanvas = document.getElementById('vfx-canvas');
    const vfxCtx = vfxCanvas.getContext('2d');

    let drops = [];

    function resizeCanvas() {
      vfxCanvas.width = window.innerWidth;
      vfxCanvas.height = window.innerHeight;
      initRain();
    }
    window.addEventListener('resize', resizeCanvas);

    function initRain() {
      drops = [];
      const count = Math.floor(vfxCanvas.width / 18);
      for (let i = 0; i < count; i++) {
        drops.push({
          x: Math.random() * vfxCanvas.width,
          y: Math.random() * vfxCanvas.height,
          length: 12 + Math.random() * 18,
          speed: 8 + Math.random() * 8,
          opacity: 0.15 + Math.random() * 0.35
        });
      }
    }

    function triggerLightning() {
      const flash = document.getElementById('lightning-fx');
      flash.classList.add('flash');
      setTimeout(() => flash.classList.remove('flash'), 120);
      setTimeout(() => {
        flash.classList.add('flash');
        setTimeout(() => flash.classList.remove('flash'), 80);
      }, 200);
    }

    setInterval(() => {
      if (Math.random() < 0.25) {
        triggerLightning();
      }
    }, 8000);

    let waveTick = 0;

    function renderWaves(ctx, width, height) {
      waveTick += 0.03;
      const baseY = height * 0.68;

      // Layer 1: Back Storm Swell
      ctx.fillStyle = 'rgba(4, 25, 52, 0.35)';
      ctx.beginPath();
      ctx.moveTo(0, height);
      for (let x = 0; x <= width; x += 16) {
        const y = baseY + Math.sin(x * 0.004 + waveTick * 0.7) * 20 + Math.cos(x * 0.008 + waveTick * 0.4) * 12;
        ctx.lineTo(x, y);
      }
      ctx.lineTo(width, height);
      ctx.closePath();
      ctx.fill();

      // Layer 2: Mid Ocean Surge
      ctx.fillStyle = 'rgba(8, 48, 88, 0.45)';
      ctx.beginPath();
      ctx.moveTo(0, height);
      for (let x = 0; x <= width; x += 12) {
        const y = (baseY + 35) + Math.sin(x * 0.006 - waveTick * 0.9) * 24 + Math.cos(x * 0.011 + waveTick * 0.6) * 14;
        ctx.lineTo(x, y);
      }
      ctx.lineTo(width, height);
      ctx.closePath();
      ctx.fill();

      // Layer 3: White Foaming Crests & Breakers
      ctx.fillStyle = 'rgba(2, 20, 42, 0.55)';
      ctx.strokeStyle = 'rgba(224, 242, 254, 0.7)';
      ctx.lineWidth = 3.5;
      ctx.beginPath();
      ctx.moveTo(0, height);
      for (let x = 0; x <= width; x += 10) {
        const y = (baseY + 70) + Math.sin(x * 0.008 + waveTick * 1.1) * 25 + Math.sin(x * 0.018 + waveTick * 1.4) * 8;
        ctx.lineTo(x, y);
      }
      ctx.lineTo(width, height);
      ctx.closePath();
      ctx.fill();
      ctx.stroke();

      // Foaming Crest Sea Spray
      ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
      for (let i = 0; i < 20; i++) {
        const px = ((Math.sin(i * 97 + waveTick * 0.5) * 0.5 + 0.5) * width);
        const py = (baseY + 68) + Math.sin(px * 0.008 + waveTick * 1.1) * 25 - (i % 5) * 2;
        ctx.beginPath();
        ctx.arc(px, py, 1.8 + (i % 3), 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function renderVFX() {
      vfxCtx.clearRect(0, 0, vfxCanvas.width, vfxCanvas.height);

      // Render Undulating Ocean Storm Waves
      renderWaves(vfxCtx, vfxCanvas.width, vfxCanvas.height);

      // Render Rain
      vfxCtx.lineWidth = 1.2;
      for (let drop of drops) {
        vfxCtx.strokeStyle = `rgba(186, 230, 253, ${drop.opacity})`;
        vfxCtx.beginPath();
        vfxCtx.moveTo(drop.x, drop.y);
        vfxCtx.lineTo(drop.x + drop.length * 0.2, drop.y + drop.length);
        vfxCtx.stroke();

        drop.y += drop.speed;
        drop.x += drop.speed * 0.2;
        if (drop.y > vfxCanvas.height) {
          drop.y = -20;
          drop.x = Math.random() * vfxCanvas.width;
        }
      }

      requestAnimationFrame(renderVFX);
    }

    function initFire(canvasId) {
      const c = document.getElementById(canvasId);
      if (!c) return;
      const ctx = c.getContext('2d');
      c.width = 120;
      c.height = 120;

      let particles = [];
      for (let i = 0; i < 25; i++) {
        particles.push({
          x: c.width * 0.5 + (Math.random() - 0.5) * 20,
          y: c.height * 0.7 + Math.random() * 20,
          size: 6 + Math.random() * 10,
          speedY: 1.5 + Math.random() * 2.5,
          speedX: (Math.random() - 0.5) * 1.2,
          life: 0,
          maxLife: 20 + Math.random() * 25
        });
      }

      function animate() {
        ctx.clearRect(0, 0, c.width, c.height);

        for (let p of particles) {
          p.life++;
          p.y -= p.speedY;
          p.x += p.speedX;
          p.size *= 0.96;

          const ratio = p.life / p.maxLife;
          const r = 255;
          const g = Math.floor(200 * (1 - ratio));
          const b = 0;
          const a = 1 - ratio;

          ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${a})`;
          ctx.beginPath();
          ctx.arc(p.x, p.y, Math.max(0.1, p.size), 0, Math.PI * 2);
          ctx.fill();

          if (p.life >= p.maxLife || p.size <= 0.5) {
            p.x = c.width * 0.5 + (Math.random() - 0.5) * 20;
            p.y = c.height * 0.7 + Math.random() * 15;
            p.size = 6 + Math.random() * 10;
            p.life = 0;
          }
        }
        requestAnimationFrame(animate);
      }
      animate();
    }

    document.addEventListener('DOMContentLoaded', () => {
      resizeCanvas();
      renderVFX();
      initFire('fire-canvas-lobby');
      initFire('fire-canvas-game');

      const urlParams = new URLSearchParams(window.location.search);
      const modeParam = urlParams.get('mode');
      if (modeParam === 'fixed' || modeParam === 'doubling') {
        enterGameMode(modeParam);
      }
    });
  </script>
</body>
</html>
