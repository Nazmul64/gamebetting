<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>BonBon Bonanza™ — Candy Cascade Slot</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700;800&family=Nunito:wght@400;600;700;800;900&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  :root {
    --sky-1: #60c5ff;
    --sky-2: #bfe8ff;
    --candy-pink: #ff2d87;
    --candy-pink-light: #ff7ebb;
    --candy-gold: #ffc820;
    --candy-purple: #9d2bff;
    --candy-blue: #00d2ff;
    --candy-green: #2be879;
    --panel-dark: rgba(38, 11, 70, 0.94);
    --panel-border: #d46bff;
    --win-glow: rgba(255, 200, 32, 0.95);
    --text-cream: #fff5ea;
    --text-muted: #d0b8f0;
    --radius-xl: 24px;
    --radius-lg: 18px;
    --radius-md: 12px;
    --radius-sm: 8px;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; user-select: none; -webkit-tap-highlight-color: transparent; }
  html, body { width: 100%; height: 100%; min-height: 100vh; overflow-x: hidden; background: #50b8ff; font-family: 'Nunito', sans-serif; color: var(--text-cream); }

  /* Canvas Scene */
  #bgCanvas { position: fixed; inset: 0; width: 100%; height: 100%; z-index: 0; display: block; }
  #fxCanvas { position: fixed; inset: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none; }

  /* App Wrapper */
  .game-wrapper {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 820px;
    min-height: 100vh;
    margin: 0 auto;
    padding: 10px 12px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 10px;
  }

  /* ---- Header Bar ---- */
  .header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, rgba(62, 14, 110, 0.92), rgba(35, 7, 65, 0.95));
    border: 2px solid var(--panel-border);
    border-radius: var(--radius-lg);
    padding: 10px 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.35), 0 0 15px rgba(212, 107, 255, 0.25);
    backdrop-filter: blur(10px);
    gap: 10px;
  }

  .brand-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .home-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.2s;
  }
  .home-btn:hover { background: rgba(255,255,255,0.25); transform: scale(1.05); }

  .brand-logo {
    font-family: 'Fredoka', sans-serif;
    font-size: clamp(18px, 4.5vw, 26px);
    font-weight: 800;
    letter-spacing: 0.5px;
    background: linear-gradient(95deg, #ffd66b, #ff4fa3 50%, #5fd8ff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    filter: drop-shadow(0 2px 8px rgba(255, 79, 163, 0.5));
    line-height: 1.1;
  }

  /* 1xBet Dual Mode Switcher */
  .mode-switch-pill {
    display: flex;
    align-items: center;
    background: rgba(18, 4, 34, 0.7);
    border: 1.5px solid rgba(255, 255, 255, 0.15);
    border-radius: 999px;
    padding: 3px;
    gap: 2px;
  }
  .mode-opt {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    border: none;
    background: transparent;
    color: var(--text-muted);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .mode-opt.active-real {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 0 12px rgba(16, 185, 129, 0.6);
  }
  .mode-opt.active-demo {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    box-shadow: 0 0 12px rgba(245, 158, 11, 0.6);
  }

  .header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .icon-tool-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: var(--text-cream);
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .icon-tool-btn:hover { background: rgba(255,255,255,0.22); transform: scale(1.06); }

  /* ---- Main Arena Panel ---- */
  .arena-card {
    background: linear-gradient(180deg, rgba(62, 14, 110, 0.93), rgba(30, 6, 58, 0.96));
    border: 2px solid var(--panel-border);
    border-radius: var(--radius-xl);
    padding: 14px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5), inset 0 0 30px rgba(157, 43, 255, 0.2);
    backdrop-filter: blur(12px);
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  /* Grid Frame & Multipliers Banner */
  .grid-container {
    position: relative;
    background: linear-gradient(180deg, #4d1085 0%, #200440 100%);
    border-radius: var(--radius-lg);
    padding: 10px;
    border: 4px solid #f6ad55;
    box-shadow: 0 0 0 2px #ffd66b, 0 12px 30px rgba(0,0,0,0.6);
  }

  .win-banner-toast {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(95deg, #ffd66b, #ff4fa3);
    color: #26004d;
    font-family: 'Fredoka', sans-serif;
    font-weight: 800;
    font-size: 13.5px;
    padding: 6px 20px;
    border-radius: 999px;
    box-shadow: 0 8px 20px rgba(255, 214, 107, 0.6);
    z-index: 10;
    white-space: nowrap;
    letter-spacing: 0.5px;
    display: none;
    animation: bounceToast 0.5s ease;
  }
  @keyframes bounceToast {
    0% { transform: translateX(-50%) scale(0.6); opacity: 0; }
    70% { transform: translateX(-50%) scale(1.1); }
    100% { transform: translateX(-50%) scale(1); opacity: 1; }
  }

  /* 6 Columns x 5 Rows Grid */
  .slot-grid-6x5 {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-template-rows: repeat(5, 1fr);
    gap: 6px;
    aspect-ratio: 6 / 5;
    width: 100%;
  }

  .candy-cell {
    background: rgba(255, 255, 255, 0.06);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: inset 0 3px 0 rgba(255,255,255,0.15), 0 3px 6px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s, filter 0.2s;
  }

  .candy-cell svg, .candy-cell .sym-img {
    width: 78%;
    height: 78%;
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.35));
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  /* Animation classes */
  .candy-cell.tumble-blur {
    filter: blur(5px) brightness(1.2);
    transform: scale(0.92);
  }
  .candy-cell.candy-win-pulse {
    animation: candyWinGlow 0.5s ease-in-out infinite alternate;
    z-index: 5;
    border-color: #ffd66b;
  }
  @keyframes candyWinGlow {
    0% { transform: scale(1); box-shadow: 0 0 15px #ffd66b, inset 0 0 10px #ffd66b; filter: brightness(1.1); }
    100% { transform: scale(1.14); box-shadow: 0 0 25px #ff4fa3, inset 0 0 15px #ff4fa3; filter: brightness(1.4); }
  }

  .candy-cell.candy-pop-blast {
    animation: candyPopBlast 0.35s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  @keyframes candyPopBlast {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.35) rotate(15deg); opacity: 0.9; }
    100% { transform: scale(0); opacity: 0; }
  }

  .candy-cell.cascade-drop-in {
    animation: cascadeDropIn 0.35s cubic-bezier(0.22, 0.9, 0.32, 1.2);
  }
  @keyframes cascadeDropIn {
    0% { transform: translateY(-100%); opacity: 0; }
    70% { transform: translateY(8%); opacity: 1; }
    100% { transform: translateY(0); opacity: 1; }
  }

  /* ---- Feature Bars: Scatter Boost & Demo Counter ---- */
  .feature-bar-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(20, 4, 38, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);
    padding: 10px 14px;
    gap: 10px;
    flex-wrap: wrap;
  }

  .scatter-boost-control {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
  }
  .boost-info-text {
    display: flex;
    flex-direction: column;
  }
  .boost-main {
    font-size: 13.5px;
    font-weight: 800;
    color: #ffd66b;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .boost-sub {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 600;
  }

  /* Toggle Switch */
  .toggle-checkbox {
    position: relative;
    width: 48px;
    height: 26px;
    background: rgba(255,255,255,0.18);
    border-radius: 999px;
    transition: all 0.25s;
    cursor: pointer;
    flex-shrink: 0;
    border: 1.5px solid rgba(255,255,255,0.25);
  }
  .toggle-checkbox::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #fff;
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }
  .toggle-checkbox.active-boost {
    background: linear-gradient(95deg, #ff2d87, #ffc820);
    border-color: #ffd66b;
    box-shadow: 0 0 12px rgba(255, 45, 135, 0.6);
  }
  .toggle-checkbox.active-boost::after {
    transform: translateX(22px);
  }

  /* Demo Trial Badge */
  .demo-badge-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.35);
    border-radius: 999px;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 800;
    color: #fbbf24;
  }

  /* ---- Bottom Controls Deck ---- */
  .control-deck {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, rgba(62, 14, 110, 0.95), rgba(35, 7, 65, 0.98));
    border: 2px solid var(--panel-border);
    border-radius: var(--radius-xl);
    padding: 12px 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.45);
    backdrop-filter: blur(10px);
  }

  .stat-box {
    display: flex;
    flex-direction: column;
  }
  .stat-box .stat-label {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
  }
  .stat-box .stat-num {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(16px, 3.5vw, 20px);
    font-weight: 800;
    color: #fff;
    font-variant-numeric: tabular-nums;
  }
  .stat-box.win-box .stat-num {
    color: #34d399;
    text-shadow: 0 0 10px rgba(52, 211, 153, 0.5);
  }

  /* Bet adjuster */
  .bet-adjust-group {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .btn-stepper {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #fff;
    font-size: 17px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
  }
  .btn-stepper:hover:not(:disabled) { background: rgba(255,255,255,0.25); transform: scale(1.08); }
  .btn-stepper:disabled { opacity: 0.35; cursor: not-allowed; }

  /* Giant Spin Button */
  .spin-hub {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .spin-aura-ring {
    position: absolute;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: conic-gradient(#ffd66b, #ff4fa3, #5fd8ff, #ffd66b);
    animation: rotateAura 3s linear infinite;
    filter: blur(4px);
    opacity: 0.75;
  }
  @keyframes rotateAura {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .btn-giant-spin {
    position: relative;
    z-index: 2;
    width: 76px;
    height: 76px;
    border-radius: 50%;
    border: 3px solid #fff;
    background: linear-gradient(135deg, #ffd66b 0%, #ff2d87 100%);
    color: #fff;
    font-family: 'Fredoka', sans-serif;
    font-size: 19px;
    font-weight: 800;
    letter-spacing: 0.5px;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(255, 45, 135, 0.6), inset 0 3px 0 rgba(255,255,255,0.4);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: transform 0.12s, box-shadow 0.12s;
  }
  .btn-giant-spin:hover:not(:disabled) { transform: scale(1.06); }
  .btn-giant-spin:active:not(:disabled) { transform: scale(0.94); }
  .btn-giant-spin:disabled { opacity: 0.6; cursor: not-allowed; filter: grayscale(0.4); }

  .toggle-action-chips {
    display: flex;
    gap: 6px;
  }
  .btn-chip-mode {
    font-family: 'Nunito', sans-serif;
    font-weight: 800;
    font-size: 11px;
    padding: 8px 12px;
    border-radius: var(--radius-sm);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #fff;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-chip-mode.chip-active {
    background: linear-gradient(95deg, #2be879, #00d2ff);
    color: #0d2b18;
    border-color: transparent;
    box-shadow: 0 0 10px rgba(43, 232, 121, 0.5);
  }

  /* ---- Responsive Adjustments ---- */
  @media (max-width: 600px) {
    .control-deck {
      grid-template-columns: 1fr 1fr;
      row-gap: 12px;
      padding: 10px 14px;
    }
    .spin-hub {
      grid-column: span 2;
      order: -1;
      margin-bottom: 2px;
    }
    .btn-giant-spin {
      width: 68px;
      height: 68px;
      font-size: 17px;
    }
    .spin-aura-ring {
      width: 80px;
      height: 80px;
    }
    .stat-box .stat-num {
      font-size: 15px;
    }
    .slot-grid-6x5 {
      gap: 4px;
    }
    .candy-cell {
      border-radius: 8px;
    }
  }

  /* ---- Modals: Deposit Required Lock & Paytable ---- */
  .modal-backdrop-wrap {
    position: fixed;
    inset: 0;
    background: rgba(10, 2, 20, 0.85);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
  }
  .modal-backdrop-wrap.modal-visible {
    opacity: 1;
    pointer-events: auto;
  }

  .modal-box-card {
    width: 100%;
    max-width: 440px;
    max-height: 85vh;
    overflow-y: auto;
    background: linear-gradient(165deg, #3d1474, #1b0738);
    border: 2px solid var(--panel-border);
    border-radius: var(--radius-xl);
    padding: 24px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 30px rgba(212, 107, 255, 0.3);
    text-align: center;
    position: relative;
    animation: scaleModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  @keyframes scaleModal {
    0% { transform: scale(0.85); }
    100% { transform: scale(1); }
  }

  .deposit-lock-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ffd66b, #f59e0b);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #451a03;
    box-shadow: 0 0 25px rgba(245, 158, 11, 0.6);
  }
  .modal-title {
    font-family: 'Fredoka', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: #ffd66b;
    margin-bottom: 8px;
  }
  .modal-desc {
    font-size: 13.5px;
    color: #d8b4fe;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .btn-deposit-gold {
    width: 100%;
    padding: 14px 20px;
    border-radius: 999px;
    background: linear-gradient(135deg, #10b981, #059669);
    border: 2px solid #34d399;
    color: #fff;
    font-family: 'Fredoka', sans-serif;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
    transition: all 0.2s;
  }
  .btn-deposit-gold:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.7);
  }

  /* Paytable List */
  .paytable-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-sm);
    margin-bottom: 6px;
    font-size: 12.5px;
  }
  .paytable-item .sym-info {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
  }
  .paytable-item .sym-payouts {
    color: #ffd66b;
    font-weight: 800;
    font-size: 12px;
  }

  .btn-modal-dismiss {
    margin-top: 14px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--text-cream);
    padding: 10px 18px;
    border-radius: 999px;
    cursor: pointer;
    font-weight: 700;
    width: 100%;
    transition: all 0.2s;
  }
  .btn-modal-dismiss:hover { background: rgba(255, 255, 255, 0.2); }
</style>
</head>
<body>

<!-- Canvas Background & Particles -->
<canvas id="bgCanvas"></canvas>
<canvas id="fxCanvas"></canvas>

<div class="game-wrapper">
  <!-- Top Header Navigation -->
  <header class="header-bar">
    <div class="brand-group">
      <a href="{{ route('dashboard') }}" class="home-btn" title="Back to Casino"><i class="fas fa-arrow-left"></i></a>
      <div class="brand-logo">BonBon Bonanza™</div>
    </div>

    <!-- 1xBet Dual Mode Switcher -->
    <div class="mode-switch-pill">
      <button class="mode-opt active-real" id="btnModeReal" onclick="switchMode(false)">
        <i class="fas fa-coins"></i> REAL
      </button>
      <button class="mode-opt" id="btnModeDemo" onclick="switchMode(true)">
        <i class="fas fa-gamepad"></i> DEMO
      </button>
    </div>

    <div class="header-actions">
      <button class="icon-tool-btn" id="btnSound" onclick="toggleSound()" title="Sound FX"><i class="fas fa-volume-high"></i></button>
      <button class="icon-tool-btn" onclick="openPaytableModal()" title="Paytable Rules"><i class="fas fa-info"></i></button>
    </div>
  </header>

  <!-- Main Game Arena -->
  <main class="arena-card">
    <!-- Grid Frame -->
    <div class="grid-container">
      <div class="win-banner-toast" id="winBannerToast">🍬 TUMBLE COMBO!</div>
      <div class="slot-grid-6x5" id="slotGrid">
        <!-- 30 cells generated by JS -->
      </div>
    </div>

    <!-- Feature Row: Scatter Boost Toggle + Demo Badge -->
    <div class="feature-bar-row">
      <div class="scatter-boost-control" onclick="toggleScatterBoost()">
        <div class="toggle-checkbox" id="boostSwitch"></div>
        <div class="boost-info-text">
          <span class="boost-main"><i class="fas fa-bolt"></i> Scatter Boost (+25% Bet)</span>
          <span class="boost-sub">Double chance of landing Lollipop Scatters</span>
        </div>
      </div>

      <div class="demo-badge-pill" id="demoBadge" style="display:none;">
        <i class="fas fa-clock-rotate-left"></i> Free Trial: <span id="demoCountDisplay">0 / 3</span>
      </div>
    </div>
  </main>

  <!-- Bottom Control Deck -->
  <footer class="control-deck">
    <!-- Balance & Bet -->
    <div style="display:flex; flex-direction:column; gap:8px;">
      <div class="stat-box">
        <span class="stat-label">Balance</span>
        <span class="stat-num" id="balanceDisplay">৳ {{ number_format(auth()->check() ? auth()->user()->balance : 0, 2) }}</span>
      </div>

      <div class="bet-adjust-group">
        <button class="btn-stepper" onclick="adjustBet(-1)">−</button>
        <div class="stat-box">
          <span class="stat-label">Total Bet</span>
          <span class="stat-num" id="betDisplay">৳ 1.00</span>
        </div>
        <button class="btn-stepper" onclick="adjustBet(1)">+</button>
      </div>
    </div>

    <!-- Giant Spin Button Hub -->
    <div class="spin-hub">
      <div class="spin-aura-ring" id="spinAuraRing" style="display:none;"></div>
      <button class="btn-giant-spin" id="btnSpin" onclick="triggerBonbonSpin()">
        <span>SPIN</span>
      </button>
    </div>

    <!-- Win & Auto/Turbo Toggles -->
    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
      <div class="stat-box win-box" style="align-items:flex-end;">
        <span class="stat-label">Total Win</span>
        <span class="stat-num" id="winDisplay">৳ 0.00</span>
      </div>

      <div class="toggle-action-chips">
        <button class="btn-chip-mode" id="btnTurbo" onclick="toggleTurbo()">TURBO</button>
        <button class="btn-chip-mode" id="btnAuto" onclick="toggleAuto()">AUTO</button>
      </div>
    </div>
  </footer>
</div>

<!-- ==========================================
     DEPOSIT REQUIRED LOCKED MODAL
     ========================================== -->
<div class="modal-backdrop-wrap" id="depositModal">
  <div class="modal-box-card">
    <div class="deposit-lock-icon"><i class="fas fa-lock"></i></div>
    <h3 class="modal-title">আপনার ডেমো লিমিট শেষ!</h3>
    <p class="modal-desc">
      আপনি ডেমো মোডের ৩টি ফ্রি স্পিন শেষ করেছেন। আনলিমিটেড স্পিন এবং আসল ক্যাশ উইনিং পেতে এখনই আপনার একাউন্টে ডিপোজিট করুন!
    </p>
    <a href="{{ route('dashboard') }}#depositModal" class="btn-deposit-gold">
      <i class="fas fa-wallet"></i> এখনই ডিপোজিট করুন
    </a>
    <button class="btn-modal-dismiss" onclick="closeDepositModal()">বন্ধ করুন</button>
  </div>
</div>

<!-- ==========================================
     PAYTABLE & HOW TO PLAY MODAL
     ========================================== -->
<div class="modal-backdrop-wrap" id="paytableModal">
  <div class="modal-box-card" style="max-width:480px;">
    <h3 class="modal-title">🍬 Pay Anywhere মেকানিক্স</h3>
    <p class="modal-desc" style="margin-bottom:14px;">
      স্ক্রিনের যেকোনো জায়গায় একই জাতের ক্যান্ডি বা ফল ন্যূনতম ৮টি বা তার বেশি পড়লেই উইন পাওয়া যায়। টাম্বলিং ফিচারের মাধ্যমে এক স্পিনেই আনলিমিটেড কম্বো সম্ভব!
    </p>

    <div style="max-height:300px; overflow-y:auto; margin-bottom:14px;">
      <div class="paytable-item">
        <div class="sym-info">❤️ Red Heart Candy</div>
        <div class="sym-payouts">8-9: 10× · 10-11: 25× · 12+: 50×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">💜 Purple Square</div>
        <div class="sym-payouts">8-9: 2.5× · 10-11: 10× · 12+: 25×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">💚 Green Pentagon</div>
        <div class="sym-payouts">8-9: 2.0× · 10-11: 5.0× · 12+: 15×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">💙 Blue Oval</div>
        <div class="sym-payouts">8-9: 1.5× · 10-11: 2.0× · 12+: 12×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">🍎 Red Apple</div>
        <div class="sym-payouts">8-9: 1.0× · 10-11: 1.5× · 12+: 10×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">🍇 Purple Grapes</div>
        <div class="sym-payouts">8-9: 0.4× · 10-11: 0.9× · 12+: 4.0×</div>
      </div>
      <div class="paytable-item">
        <div class="sym-info">🍌 Banana</div>
        <div class="sym-payouts">8-9: 0.25× · 10-11: 0.75× · 12+: 2.0×</div>
      </div>
      <div class="paytable-item" style="border-color:#ffd66b;">
        <div class="sym-info">🍭 Lollipop Scatter</div>
        <div class="sym-payouts">4+ Scatters trigger Free Spins!</div>
      </div>
    </div>

    <button class="btn-modal-dismiss" onclick="closePaytableModal()">ঠিক আছে</button>
  </div>
</div>

<!-- ==========================================
     CANVAS BACKGROUND WORLD
     ========================================== -->
<script>
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

  class FloatingTreat {
    constructor(){ this.reset(); }
    reset(){
      this.x = Math.random() * window.innerWidth;
      this.y = Math.random() * window.innerHeight;
      this.vy = -0.4 - Math.random() * 0.6;
      this.vx = (Math.random() - 0.5) * 0.5;
      this.r = 3 + Math.random() * 5;
      this.alpha = 0.5 + Math.random() * 0.4;
      this.hue = Math.random() * 360;
      this.rot = Math.random() * Math.PI * 2;
      this.rotV = (Math.random() - 0.5) * 0.05;
      this.life = 0;
      this.maxLife = 150 + Math.random() * 150;
    }
    update(){
      this.x += this.vx; this.y += this.vy; this.rot += this.rotV; this.life++;
      if (this.life > this.maxLife || this.y < -20) this.reset();
    }
    draw(){
      fctx.save();
      fctx.globalAlpha = this.alpha * (1 - this.life / this.maxLife);
      fctx.translate(this.x, this.y);
      fctx.rotate(this.rot);
      fctx.fillStyle = `hsl(${this.hue}, 90%, 70%)`;
      fctx.beginPath();
      fctx.arc(0, 0, this.r, 0, Math.PI * 2);
      fctx.fill();
      fctx.restore();
    }
  }

  const treats = Array.from({length: 30}, () => new FloatingTreat());

  function drawWorld(t){
    const w = bg.width, h = bg.height;
    bctx.clearRect(0,0,w,h);

    // Sky gradient
    const sky = bctx.createLinearGradient(0,0,0,h*0.7);
    sky.addColorStop(0,'#4cb5f5');
    sky.addColorStop(0.6,'#9be2ff');
    sky.addColorStop(1,'#d8f4ff');
    bctx.fillStyle = sky;
    bctx.fillRect(0,0,w,h);

    // Candy hills
    bctx.beginPath();
    bctx.moveTo(0, h*0.75);
    bctx.bezierCurveTo(w*0.25, h*0.6, w*0.75, h*0.85, w, h*0.7);
    bctx.lineTo(w, h); bctx.lineTo(0, h); bctx.closePath();
    bctx.fillStyle = '#4ade80';
    bctx.fill();

    bctx.beginPath();
    bctx.moveTo(0, h*0.8);
    bctx.bezierCurveTo(w*0.35, h*0.72, w*0.65, h*0.88, w, h*0.78);
    bctx.lineTo(w, h); bctx.lineTo(0, h); bctx.closePath();
    bctx.fillStyle = '#22c55e';
    bctx.fill();

    // Particle Treats
    fctx.clearRect(0,0,w,h);
    treats.forEach(tr => { tr.update(); tr.draw(); });

    requestAnimationFrame(drawWorld);
  }
  drawWorld(0);
})();
</script>

<!-- ==========================================
     CORE CANDY SLOT JAVASCRIPT ENGINE
     ========================================== -->
<script>
// Candy SVG Glyphs
const CANDY_SVGS = {
  'HEART_RED': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gHeart" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ff4b72"/><stop offset="100%" stop-color="#d90429"/></linearGradient></defs><path d="M50 88 C20 65, 5 45, 5 28 C5 12, 18 3, 33 3 C41 3, 47 8, 50 14 C53 8, 59 3, 67 3 C82 3, 95 12, 95 28 C95 45, 80 65, 50 88 Z" fill="url(#gHeart)" stroke="#fff" stroke-width="3"/><ellipse cx="32" cy="20" rx="9" ry="5" fill="#fff" opacity="0.6" transform="rotate(-30 32 20)"/></svg>`,
  
  'SQUARE_PURPLE': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gPurp" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#c084fc"/><stop offset="100%" stop-color="#7e22ce"/></linearGradient></defs><rect x="12" y="12" width="76" height="76" rx="18" fill="url(#gPurp)" stroke="#fff" stroke-width="3"/><rect x="22" y="22" width="56" height="24" rx="8" fill="#fff" opacity="0.4"/></svg>`,
  
  'PENTAGON_GREEN': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gGreen" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#4ade80"/><stop offset="100%" stop-color="#15803d"/></linearGradient></defs><polygon points="50,8 92,38 76,88 24,88 8,38" fill="url(#gGreen)" stroke="#fff" stroke-width="3"/><ellipse cx="50" cy="30" rx="14" ry="7" fill="#fff" opacity="0.5"/></svg>`,
  
  'OVAL_BLUE': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gBlue" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#38bdf8"/><stop offset="100%" stop-color="#0369a1"/></linearGradient></defs><ellipse cx="50" cy="50" rx="42" ry="32" fill="url(#gBlue)" stroke="#fff" stroke-width="3"/><ellipse cx="40" cy="38" rx="16" ry="7" fill="#fff" opacity="0.6"/></svg>`,
  
  'APPLE': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gApple" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ef4444"/><stop offset="100%" stop-color="#b91c1c"/></linearGradient></defs><path d="M50 88 C30 88, 12 75, 12 50 C12 28, 28 22, 42 25 C47 26, 50 30, 50 30 C50 30, 53 26, 58 25 C72 22, 88 28, 88 50 C88 75, 70 88, 50 88 Z" fill="url(#gApple)" stroke="#fff" stroke-width="2"/><path d="M50 25 Q54 10 65 6" stroke="#854d0e" stroke-width="4" fill="none" stroke-linecap="round"/><path d="M54 14 Q68 12 72 20 Q62 25 54 14" fill="#22c55e"/></svg>`,
  
  'PLUM': `<svg viewBox="0 0 100 100"><defs><linearGradient id="gPlum" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#a855f7"/><stop offset="100%" stop-color="#581c87"/></linearGradient></defs><circle cx="50" cy="54" r="38" fill="url(#gPlum)" stroke="#fff" stroke-width="2"/><ellipse cx="38" cy="40" rx="12" ry="6" fill="#fff" opacity="0.5" transform="rotate(-20 38 40)"/></svg>`,
  
  'WATERMELON': `<svg viewBox="0 0 100 100"><path d="M12 35 C20 75, 80 75, 88 35 Z" fill="#22c55e" stroke="#fff" stroke-width="2"/><path d="M16 35 C23 70, 77 70, 84 35 Z" fill="#ef4444"/><circle cx="35" cy="48" r="3" fill="#000"/><circle cx="50" cy="54" r="3" fill="#000"/><circle cx="65" cy="48" r="3" fill="#000"/></svg>`,
  
  'GRAPES': `<svg viewBox="0 0 100 100"><circle cx="40" cy="35" r="14" fill="#9333ea"/><circle cx="60" cy="35" r="14" fill="#7e22ce"/><circle cx="30" cy="55" r="14" fill="#6b21a8"/><circle cx="50" cy="55" r="14" fill="#a855f7"/><circle cx="70" cy="55" r="14" fill="#9333ea"/><circle cx="40" cy="72" r="14" fill="#7e22ce"/><circle cx="60" cy="72" r="14" fill="#6b21a8"/><circle cx="50" cy="85" r="10" fill="#581c87"/></svg>`,
  
  'BANANA': `<svg viewBox="0 0 100 100"><path d="M20 75 Q40 85 75 60 Q85 50 88 35 Q65 60 30 65 Q22 65 20 75 Z" fill="#fbbf24" stroke="#fff" stroke-width="2"/><path d="M88 35 L92 30" stroke="#713f12" stroke-width="4" stroke-linecap="round"/></svg>`,
  
  'LOLLIPOP_SCATTER': `<svg viewBox="0 0 100 100"><rect x="46" y="55" width="8" height="40" rx="4" fill="#fff" stroke="#cbd5e1" stroke-width="1.5"/><circle cx="50" cy="38" r="30" fill="#ff2d87" stroke="#ffd66b" stroke-width="3"/><path d="M50 8 A30 30 0 0 1 80 38 A15 15 0 0 1 50 38 A7.5 7.5 0 0 1 50 30.5" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round"/><circle cx="50" cy="38" r="5" fill="#ffd66b"/></svg>`
};

const BET_STEPS = [1, 2, 5, 10, 20, 50, 100, 200, 500, 1000];

// Game State
let currentBetIndex = 0;
let isDemoMode = false;
let demoSpinsDone = 0;
let demoBalance = 1000.00;
let realBalance = parseFloat("{{ auth()->check() ? auth()->user()->balance : 0 }}") || 0.00;
let isSpinning = false;
let scatterBoostActive = false;
let isTurbo = false;
let isAuto = false;
let soundEnabled = true;

// Web Audio API Synthesizer
let audioCtx = null;
function getAudioCtx() {
  if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  return audioCtx;
}

function playTone(freq, duration, type = 'sine', volume = 0.06) {
  if (!soundEnabled) return;
  try {
    const ctx = getAudioCtx();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = type;
    osc.frequency.value = freq;
    gain.gain.setValueAtTime(volume, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + duration);
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.start();
    osc.stop(ctx.currentTime + duration);
  } catch(e) {}
}

function sfxSpin() {
  playTone(240, 0.08, 'triangle', 0.04);
}
function sfxTumblePop() {
  [450, 600, 800].forEach((f, i) => setTimeout(() => playTone(f, 0.1, 'sine', 0.05), i * 60));
}
function sfxWinFanfare() {
  [523, 659, 784, 1046].forEach((f, i) => setTimeout(() => playTone(f, 0.18, 'triangle', 0.08), i * 90));
}

// Initial 6x5 Grid Setup
function initGrid() {
  const gridEl = document.getElementById('slotGrid');
  gridEl.innerHTML = '';
  const symbols = Object.keys(CANDY_SVGS);
  
  for (let r = 0; r < 5; r++) {
    for (let c = 0; c < 6; c++) {
      const cell = document.createElement('div');
      cell.className = 'candy-cell';
      cell.dataset.row = r;
      cell.dataset.col = c;
      const sym = symbols[Math.floor(Math.random() * (symbols.length - 1))];
      cell.innerHTML = CANDY_SVGS[sym];
      gridEl.appendChild(cell);
    }
  }
}

function switchMode(demo) {
  if (isSpinning) return;
  isDemoMode = demo;
  const btnReal = document.getElementById('btnModeReal');
  const btnDemo = document.getElementById('btnModeDemo');
  const demoBadge = document.getElementById('demoBadge');
  const balDisplay = document.getElementById('balanceDisplay');

  if (isDemoMode) {
    btnReal.classList.remove('active-real');
    btnDemo.classList.add('active-demo');
    demoBadge.style.display = 'flex';
    balDisplay.innerText = '৳ ' + demoBalance.toFixed(2);
  } else {
    btnDemo.classList.remove('active-demo');
    btnReal.classList.add('active-real');
    demoBadge.style.display = 'none';
    balDisplay.innerText = '৳ ' + realBalance.toFixed(2);
  }
}

// Check if user has zero balance on load -> auto-suggest demo
window.addEventListener('DOMContentLoaded', () => {
  initGrid();
  updateControlsUI();

  if (realBalance <= 0) {
    switchMode(true);
  }
});

function toggleScatterBoost() {
  if (isSpinning) return;
  scatterBoostActive = !scatterBoostActive;
  document.getElementById('boostSwitch').classList.toggle('active-boost', scatterBoostActive);
  updateControlsUI();
  playTone(550, 0.08, 'sine', 0.04);
}

function adjustBet(direction) {
  if (isSpinning) return;
  const next = currentBetIndex + direction;
  if (next >= 0 && next < BET_STEPS.length) {
    currentBetIndex = next;
    updateControlsUI();
    playTone(400 + currentBetIndex * 30, 0.05, 'sine', 0.03);
  }
}

function updateControlsUI() {
  const baseBet = BET_STEPS[currentBetIndex];
  const effectiveBet = scatterBoostActive ? baseBet * 1.25 : baseBet;
  document.getElementById('betDisplay').innerText = '৳ ' + effectiveBet.toFixed(2);
  document.getElementById('demoCountDisplay').innerText = `${demoSpinsDone} / 3`;
}

function toggleTurbo() {
  isTurbo = !isTurbo;
  document.getElementById('btnTurbo').classList.toggle('chip-active', isTurbo);
}

function toggleAuto() {
  isAuto = !isAuto;
  document.getElementById('btnAuto').classList.toggle('chip-active', isAuto);
  if (isAuto && !isSpinning) {
    triggerBonbonSpin();
  }
}

function toggleSound() {
  soundEnabled = !soundEnabled;
  const btn = document.getElementById('btnSound');
  btn.innerHTML = soundEnabled ? '<i class="fas fa-volume-high"></i>' : '<i class="fas fa-volume-xmark"></i>';
}

function openPaytableModal() {
  document.getElementById('paytableModal').classList.add('modal-visible');
}
function closePaytableModal() {
  document.getElementById('paytableModal').classList.remove('modal-visible');
}
function closeDepositModal() {
  document.getElementById('depositModal').classList.remove('modal-visible');
}

// ---- MAIN SPIN ENGINE TRIGGER ----
async function triggerBonbonSpin() {
  if (isSpinning) return;

  const baseBet = BET_STEPS[currentBetIndex];
  const totalBet = scatterBoostActive ? baseBet * 1.25 : baseBet;

  // Demo Limit Guard (3 Spins max)
  if (isDemoMode && demoSpinsDone >= 3) {
    document.getElementById('depositModal').classList.add('modal-visible');
    isAuto = false;
    document.getElementById('btnAuto').classList.remove('chip-active');
    return;
  }

  // Real Money Balance Check
  if (!isDemoMode && realBalance < totalBet) {
    document.getElementById('depositModal').classList.add('modal-visible');
    isAuto = false;
    document.getElementById('btnAuto').classList.remove('chip-active');
    return;
  }

  isSpinning = true;
  document.getElementById('btnSpin').disabled = true;
  document.getElementById('spinAuraRing').style.display = 'block';
  document.getElementById('winBannerToast').style.display = 'none';

  // Sound and cell blur
  sfxSpin();
  const cells = document.querySelectorAll('.candy-cell');
  cells.forEach(c => {
    c.classList.remove('candy-win-pulse', 'candy-pop-blast');
    c.classList.add('tumble-blur');
  });

  try {
    const response = await fetch("{{ route('bonbon.spin') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        bet_amount: baseBet,
        is_demo: isDemoMode,
        demo_spins_count: demoSpinsDone,
        scatter_boost: scatterBoostActive
      })
    });

    const data = await response.json();

    if (data.status === 'deposit_required') {
      cells.forEach(c => c.classList.remove('tumble-blur'));
      document.getElementById('depositModal').classList.add('modal-visible');
      isSpinning = false;
      document.getElementById('btnSpin').disabled = false;
      document.getElementById('spinAuraRing').style.display = 'none';
      isAuto = false;
      return;
    }

    if (data.error) {
      alert(data.error);
      cells.forEach(c => c.classList.remove('tumble-blur'));
      isSpinning = false;
      document.getElementById('btnSpin').disabled = false;
      document.getElementById('spinAuraRing').style.display = 'none';
      isAuto = false;
      return;
    }

    // Spin delay
    const spinDelay = isTurbo ? 600 : 1200;
    setTimeout(() => {
      cells.forEach(c => c.classList.remove('tumble-blur'));

      // Render updated 6x5 matrix
      renderMatrix(data.grid);

      if (data.is_win) {
        handleWinCascades(data);
      } else {
        document.getElementById('winDisplay').innerText = '৳ 0.00';
      }

      // Balance & Demo update
      if (isDemoMode) {
        demoSpinsDone++;
        demoBalance = demoBalance - totalBet + data.win_amount;
        document.getElementById('balanceDisplay').innerText = '৳ ' + demoBalance.toFixed(2);
        updateControlsUI();
      } else if (data.new_balance !== null) {
        realBalance = parseFloat(data.new_balance);
        document.getElementById('balanceDisplay').innerText = '৳ ' + realBalance.toFixed(2);
      }

      setTimeout(() => {
        isSpinning = false;
        document.getElementById('btnSpin').disabled = false;
        document.getElementById('spinAuraRing').style.display = 'none';

        if (isAuto) {
          setTimeout(triggerBonbonSpin, isTurbo ? 400 : 800);
        }
      }, data.is_win ? 1000 : 200);

    }, spinDelay);

  } catch(err) {
    console.error("Spin error:", err);
    cells.forEach(c => c.classList.remove('tumble-blur'));
    isSpinning = false;
    document.getElementById('btnSpin').disabled = false;
    document.getElementById('spinAuraRing').style.display = 'none';
    isAuto = false;
  }
}

function renderMatrix(grid) {
  for (let r = 0; r < 5; r++) {
    for (let c = 0; c < 6; c++) {
      const sym = grid[r][c];
      const cell = document.querySelector(`.candy-cell[data-row="${r}"][data-col="${c}"]`);
      if (cell && CANDY_SVGS[sym]) {
        cell.innerHTML = CANDY_SVGS[sym];
        cell.dataset.symbol = sym;
        cell.classList.add('cascade-drop-in');
        setTimeout(() => cell.classList.remove('cascade-drop-in'), 350);
      }
    }
  }
}

function handleWinCascades(data) {
  sfxWinFanfare();
  sfxTumblePop();

  const toast = document.getElementById('winBannerToast');
  toast.innerText = `🍬 WIN ৳ ${parseFloat(data.win_amount).toFixed(2)} (${data.tumble_count} Tumbles!)`;
  toast.style.display = 'block';

  document.getElementById('winDisplay').innerText = '৳ ' + parseFloat(data.win_amount).toFixed(2);

  // Pulse matched winning candies
  if (data.matched_symbols && data.matched_symbols.length > 0) {
    const winningSym = data.matched_symbols[0].symbol;
    document.querySelectorAll(`.candy-cell[data-symbol="${winningSym}"]`).forEach(cell => {
      cell.classList.add('candy-win-pulse');
      setTimeout(() => {
        cell.classList.remove('candy-win-pulse');
        cell.classList.add('candy-pop-blast');
      }, 700);
    });
  }
}
</script>
</body>
</html>
