<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Gems & Mines</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Orbitron:wght@400;700;900&family=Exo+2:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --gem-blue: #00d4ff;
    --gem-blue2: #0099cc;
    --gold: #f5c842;
    --gold2: #c49a00;
    --dark-bg: #050d1a;
    --panel-bg: #071428;
    --panel-border: #1a3a6e;
    --cell-bg: #0a1a30;
    --cell-hover: #0d2244;
    --cell-border: #1e3d70;
    --btn-bg: linear-gradient(135deg, #e8a200 0%, #f5c842 50%, #c49a00 100%);
    --text-main: #d0e8ff;
    --text-muted: #6a9acf;
    --explosion-red: #ff3b2f;
    --gem-green: #00ff88;
  }

  body {
    background: var(--dark-bg);
    color: var(--text-main);
    font-family: 'Exo 2', sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
    background-image:
      radial-gradient(ellipse 80% 60% at 50% 0%, #0a1f4a 0%, transparent 70%),
      radial-gradient(ellipse 40% 40% at 80% 80%, #050d20 0%, transparent 60%);
  }

  /* 1xBet Style Header Nav */
  .dashboard-header-nav a {
    transition: color 0.2s;
  }
  .dashboard-header-nav a:hover {
    color: #fff !important;
  }

  /* TABS */
  .game-tabs { display: flex; gap: 0; margin-bottom: 0; }
  .game-tab {
    padding: 10px 28px;
    font-family: 'Orbitron', sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 8px 8px 0 0;
    background: #071428;
    color: var(--text-muted);
    transition: all 0.2s;
    position: relative;
  }
  .game-tab.active {
    background: linear-gradient(180deg, #1a5fa0 0%, #0d3060 100%);
    border-color: var(--gem-blue);
    color: #fff;
    box-shadow: 0 0 12px rgba(0,212,255,0.3);
  }
  .game-tab:hover:not(.active) { color: var(--gem-blue); border-color: #1a3a6e; }

  /* Centered Layout Wrapper */
  .game-container-wrapper {
    width: 100%;
    max-width: 1200px;
    margin: 40px auto 80px auto;
    padding: 0 20px;
  }
  
  .game-flex-container {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .left-column {
    flex: 0 0 320px;
    max-width: 320px;
  }
  
  .middle-column {
    flex: 1 1 500px;
    max-width: 580px;
  }
  
  .right-column {
    flex: 0 0 240px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  /* LEFT PANEL */
  .left-panel {
    background: linear-gradient(180deg, #0a1d3a 0%, #071428 100%);
    border: 2px solid var(--panel-border);
    border-radius: 14px;
    padding: 0;
    overflow: hidden;
  }

  .panel-header {
    background: linear-gradient(90deg, #000a1a 0%, #051230 100%);
    border-bottom: 2px solid var(--panel-border);
    padding: 12px 16px;
    font-family: 'Orbitron', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-align: center;
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  .panel-body { padding: 14px; }

  /* BET INPUT */
  .bet-input-wrap {
    background: #02080f;
    border: 2px solid var(--panel-border);
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
  }
  .bet-input-wrap input {
    background: transparent;
    border: none;
    color: #fff;
    font-family: 'Orbitron', sans-serif;
    font-size: 18px;
    font-weight: 700;
    width: 120px;
    outline: none;
  }
  .bet-input-wrap input::-webkit-inner-spin-button { -webkit-appearance: none; }
  .bet-x-btn {
    background: #1a3a6e;
    border: 1px solid #2a5a9e;
    border-radius: 6px;
    color: var(--text-muted);
    font-size: 16px;
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s;
  }
  .bet-x-btn:hover { background: #2a4a7e; color: #fff; }

  /* QUICK BET BUTTONS */
  .quick-bets { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 14px; }
  .qbet {
    background: linear-gradient(180deg, #0d2040 0%, #071428 100%);
    border: 2px solid var(--panel-border);
    border-radius: 8px;
    color: var(--gem-blue);
    font-family: 'Orbitron', sans-serif;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 0;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s;
    position: relative;
    overflow: hidden;
  }
  .qbet::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, transparent 40%, rgba(0,212,255,0.06) 100%);
    pointer-events: none;
  }
  .qbet:hover {
    border-color: var(--gem-blue);
    background: linear-gradient(180deg, #1a3a60 0%, #0d2040 100%);
    box-shadow: 0 0 8px rgba(0,212,255,0.2);
  }

  /* MINES SELECTOR */
  .mines-row {
    display: flex; align-items: center; gap: 6px;
    background: #02080f;
    border: 2px solid var(--panel-border);
    border-radius: 10px;
    padding: 8px 12px;
    margin-bottom: 14px;
  }
  .mine-count-btn {
    background: #0d2040; border: 1px solid var(--panel-border);
    border-radius: 6px; color: var(--gem-blue);
    font-family: 'Orbitron', sans-serif; font-size: 12px; font-weight: 700;
    padding: 6px 12px; cursor: pointer; transition: all 0.15s;
  }
  .mine-count-btn:hover { background: #1a3a60; border-color: var(--gem-blue); }
  .mine-count-btn.active {
    background: linear-gradient(135deg, #1a5fa0 0%, #0d3060 100%);
    border-color: var(--gem-blue);
    box-shadow: 0 0 6px rgba(0,212,255,0.3);
  }
  .mines-label {
    flex: 1; text-align: center;
    font-family: 'Orbitron', sans-serif; font-size: 11px; font-weight: 700;
    color: var(--text-muted); letter-spacing: 1px;
  }
  .mines-val {
    font-family: 'Orbitron', sans-serif; font-size: 16px; font-weight: 900;
    color: #fff;
  }
  .mine-adj {
    background: #0d2040; border: 1px solid var(--panel-border);
    border-radius: 6px; color: var(--gem-blue);
    font-size: 18px; width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s; flex-shrink: 0;
  }
  .mine-adj:hover { background: #1a3a60; border-color: var(--gem-blue); }

  /* BIG BUTTONS */
  .btn-take {
    width: 100%;
    background: var(--btn-bg);
    border: none;
    border-radius: 10px;
    color: #3a2000;
    font-family: 'Orbitron', sans-serif;
    font-size: 15px;
    font-weight: 900;
    letter-spacing: 2px;
    padding: 14px 0;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(245,200,66,0.3), inset 0 1px 0 rgba(255,255,255,0.3);
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
  }
  .btn-take::after {
    content: '';
    position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.4s;
  }
  .btn-take:hover::after { left: 140%; }
  .btn-take:hover { box-shadow: 0 6px 24px rgba(245,200,66,0.5); transform: translateY(-1px); }
  .btn-take:active { transform: translateY(0); }
  .btn-take:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

  .btn-place {
    width: 100%;
    background: linear-gradient(135deg, #1a5fa0 0%, #0d8060 100%);
    border: 2px solid var(--gem-blue);
    border-radius: 10px;
    color: #fff;
    font-family: 'Orbitron', sans-serif;
    font-size: 15px;
    font-weight: 900;
    letter-spacing: 2px;
    padding: 14px 0;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(0,212,255,0.2);
    margin-bottom: 10px;
  }
  .btn-place:hover { box-shadow: 0 6px 24px rgba(0,212,255,0.4); transform: translateY(-1px); }
  .btn-place:active { transform: translateY(0); }

  /* ACTION ROW */
  .action-row { display: flex; gap: 8px; align-items: center; }
  .btn-icon {
    background: #0d2040; border: 2px solid var(--panel-border);
    border-radius: 8px; width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; transition: all 0.15s; flex-shrink: 0;
    color: var(--text-muted);
  }
  .btn-icon:hover { border-color: var(--gem-blue); color: var(--gem-blue); }

  /* GAME INFO */
  .info-box {
    background: #02080f; border: 2px solid var(--panel-border);
    border-radius: 10px; overflow: hidden; margin-top: 14px;
  }
  .info-box-header {
    background: #051220; border-bottom: 1px solid var(--panel-border);
    padding: 8px 14px; font-family: 'Orbitron', sans-serif;
    font-size: 10px; font-weight: 700; color: var(--text-muted);
    letter-spacing: 2px; text-transform: uppercase;
  }
  .info-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; border-bottom: 1px solid #0a1d30;
    font-size: 13px;
  }
  .info-row:last-child { border-bottom: none; }
  .info-label { display: flex; align-items: center; gap: 8px; color: var(--text-muted); }
  .info-label span { font-size: 16px; }
  .info-val { font-family: 'Orbitron', sans-serif; font-size: 13px; font-weight: 700; color: #fff; }
  .info-val.danger { color: var(--explosion-red); }

  /* MIDDLE TITLE PANEL */
  .title-panel {
    background: linear-gradient(90deg, #000a1a 0%, #071428 50%, #000a1a 100%);
    border: 2px solid var(--panel-border);
    border-radius: 14px 14px 0 0;
    padding: 16px 24px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
  }
  .game-title {
    font-family: 'Cinzel', serif;
    font-size: 36px;
    font-weight: 900;
    background: linear-gradient(135deg, #00d4ff 0%, #ffffff 40%, #00aadd 80%, #f5c842 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 2px;
    text-shadow: none;
    filter: drop-shadow(0 0 12px rgba(0,212,255,0.4));
  }
  .jackpot-badge {
    background: linear-gradient(135deg, #000a1a 0%, #0a1a00 100%);
    border: 2px solid var(--gold);
    border-radius: 10px;
    padding: 10px 20px;
    font-family: 'Orbitron', sans-serif;
    font-size: 14px;
    font-weight: 900;
    color: var(--gold);
    letter-spacing: 3px;
    box-shadow: 0 0 16px rgba(245,200,66,0.4), inset 0 0 20px rgba(245,200,66,0.05);
  }

  /* MULTIPLIER ROW */
  .mult-row {
    background: #02080f; border: 2px solid var(--panel-border);
    border-top: none; padding: 12px 14px;
    display: flex; gap: 8px; overflow-x: auto;
  }
  .mult-badge {
    background: #071428; border: 1px solid var(--panel-border);
    border-radius: 8px; padding: 8px 18px;
    font-family: 'Orbitron', sans-serif; font-size: 12px; font-weight: 700;
    color: var(--text-muted); white-space: nowrap; transition: all 0.2s;
  }
  .mult-badge.active-mult {
    background: linear-gradient(135deg, #1a5fa0 0%, #0d3060 100%);
    border-color: var(--gem-blue); color: #fff;
    box-shadow: 0 0 8px rgba(0,212,255,0.3);
  }

  /* GRID */
  .grid-panel {
    background: linear-gradient(180deg, #071428 0%, #050d1a 100%);
    border: 2px solid var(--panel-border);
    border-top: none; border-radius: 0 0 14px 14px;
    padding: 16px;
  }
  .cell-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
  }
  
  /* 3D Cell Design styling */
  .cell {
    aspect-ratio: 1;
    background: linear-gradient(135deg, #0d2244 0%, #071428 100%);
    border: 1.5px solid rgba(255, 255, 255, 0.08);
    border-bottom: 4px solid rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
    position: relative;
    overflow: hidden;
    transition: all 0.15s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
  }
  .cell::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, transparent 60%);
    pointer-events: none;
  }
  .cell:hover:not(.revealed) {
    background: linear-gradient(135deg, #15325c 0%, #0d2244 100%);
    border-color: var(--gem-blue);
    box-shadow: 0 6px 12px rgba(0,212,255,0.3);
    transform: translateY(-2px);
    border-bottom: 6px solid rgba(0, 212, 255, 0.4);
  }
  .cell:active:not(.revealed) {
    transform: translateY(1px);
    border-bottom: 2px solid rgba(0, 212, 255, 0.4);
  }
  .cell.revealed {
    cursor: default;
    transform: none !important;
    border-bottom: 1.5px solid rgba(255, 255, 255, 0.08);
    box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.6);
  }
  .cell.gem {
    background: linear-gradient(135deg, #001f3f 0%, #001122 100%);
    border-color: var(--gem-blue);
    box-shadow: 0 0 16px rgba(0,212,255,0.35), inset 0 0 15px rgba(0,212,255,0.1);
    animation: gemReveal 0.3s ease;
  }
  .cell.mine {
    background: linear-gradient(135deg, #3a0000 0%, #1a0000 100%);
    border-color: var(--explosion-red);
    box-shadow: 0 0 16px rgba(255,59,47,0.45);
    animation: mineReveal 0.3s ease;
  }
  @keyframes gemReveal {
    0% { transform: scale(0.6); opacity: 0; }
    70% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
  }
  @keyframes mineReveal {
    0% { transform: scale(0.6) rotate(-10deg); opacity: 0; }
    50% { transform: scale(1.15) rotate(5deg); }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
  }

  .cell-inner { font-size: 28px; user-select: none; }

  /* DEMO PANEL (Replaced by Real Play panel) */
  .demo-panel {
    background: #071428; border: 2px solid var(--panel-border);
    border-radius: 12px; padding: 16px;
    font-size: 12px; color: var(--text-muted);
  }
  .demo-balance-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 6px;
  }
  .demo-label { font-family: 'Orbitron', sans-serif; font-size: 11px; letter-spacing: 1px; }
  .demo-val { font-family: 'Orbitron', sans-serif; font-size: 16px; font-weight: 700; color: #fff; }
  .demo-val.green { color: var(--gem-green); }
  .demo-note { font-size: 10px; line-height: 1.5; color: #4a7aaa; margin-top: 8px; }
  .btn-exit-demo {
    width: 100%; margin-top: 12px;
    background: #0a1a30; border: 2px solid var(--panel-border);
    border-radius: 8px; color: var(--text-muted);
    font-family: 'Orbitron', sans-serif; font-size: 10px; font-weight: 700;
    letter-spacing: 2px; padding: 10px 0; cursor: pointer; transition: all 0.2s;
  }
  .btn-exit-demo:hover { border-color: var(--gem-blue); color: #fff; }

  /* SIDEBAR */
  .sidebar-btns {
    display: flex; flex-direction: column; gap: 8px; align-items: center;
    padding: 8px 0;
  }
  .sb-btn {
    width: 40px; height: 40px; border-radius: 8px;
    background: #071428; border: 1px solid var(--panel-border);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; color: var(--text-muted);
    transition: all 0.15s;
  }
  .sb-btn:hover { border-color: var(--gem-blue); color: var(--gem-blue); }

  .points-badge {
    background: #1a2a00; border: 1px solid #4a7a10;
    border-radius: 8px; padding: 6px; text-align: center;
    font-size: 9px; color: #7ab820; letter-spacing: 1px;
  }
  .points-num { font-size: 16px; font-weight: 700; display: block; }

  /* TOAST */
  .toast-msg {
    position: fixed; top: 85px; left: 50%; transform: translateX(-50%);
    background: #0d2040; border: 2px solid var(--gem-blue);
    border-radius: 10px; padding: 12px 28px;
    font-family: 'Orbitron', sans-serif; font-size: 14px; font-weight: 700;
    color: #fff; letter-spacing: 1px; z-index: 9999;
    animation: toastIn 0.3s ease; white-space: nowrap;
  }
  .toast-msg.win { border-color: var(--gold); color: var(--gold); background: #1a1000; }
  .toast-msg.lose { border-color: var(--explosion-red); color: var(--explosion-red); background: #1a0000; }
  @keyframes toastIn { from { opacity:0; transform: translateX(-50%) translateY(-10px); } to { opacity:1; transform: translateX(-50%) translateY(0); } }

  /* CRYSTAL DECO */
  .crystal-deco {
    position: absolute; pointer-events: none; opacity: 0.12; font-size: 80px;
    filter: blur(1px);
  }

  /* SCROLLBAR */
  ::-webkit-scrollbar { width: 4px; height: 4px; }
  ::-webkit-scrollbar-track { background: #02080f; }
  ::-webkit-scrollbar-thumb { background: #1a3a6e; border-radius: 2px; }

  /* RESPONSIVE LAYOUT CONSTRAINTS */
  @media (max-width: 1100px) {
    .game-flex-container {
      flex-direction: column;
      align-items: center;
    }
    .left-column, .middle-column, .right-column {
      width: 100%;
      max-width: 580px;
      flex: 1 1 auto;
    }
    .right-column {
      flex-direction: row;
      justify-content: space-between;
      align-items: stretch;
    }
    .right-column .demo-panel {
      flex: 1;
    }
  }
</style>
</head>
<body>

<!-- 1xBet Style Header Nav Bar -->
<nav class="dashboard-header-nav" style="background: #0c1a30; border-bottom: 1.5px solid #1d3354; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; font-family: 'Exo 2', sans-serif; width:100%; z-index:99;">
    <div class="dashboard-nav-logo" style="display: flex; align-items: center; gap: 8px;">
        <span class="logo-text" style="font-style: italic; font-weight: 900; font-size: 24px; letter-spacing: -0.5px; color: #1a76d2; text-shadow: 0 0 10px rgba(26, 118, 210, 0.3);">
            <span style="color: #ffffff;">1X</span>BET
        </span>
    </div>
    
    <ul class="dashboard-nav-links" style="display: flex; list-style: none; gap: 20px; font-size: 13px; font-weight: 700; margin: 0; padding: 0;">
        <li><a href="{{ route('dashboard') }}" style="color: #8ca3c7; text-decoration: none;">🏠 DASHBOARD</a></li>
        <li><a href="{{ route('play') }}" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-plane-departure" style="font-size:12px; margin-right:4px;"></i> 1XGAMES</a></li>
        <li><a href="{{ route('big-bass-splash') }}" style="color: #38ef7d; text-decoration: none;"><i class="fas fa-fish" style="font-size:12px; margin-right:4px;"></i> Big Bass Splash</a></li>
        <li><span style="color: #ffffff; border-bottom: 3px solid #007bff; padding-bottom: 6px; cursor: default;"><i class="fas fa-gem" style="font-size:12px; margin-right:4px; color: #ffbe1a;"></i> Gems & Mines</span></li>
    </ul>
    
    <div class="dashboard-nav-actions" style="display: flex; align-items: center; gap: 12px;">
        <div class="balance-container" style="background: #112038; border: 1.5px solid #1d3354; border-radius: 6px; padding: 0 14px; height: 38px; display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
            <span class="balance-label" style="font-size: 10px; color: #8ca3c7; letter-spacing: 0.5px;">BALANCE:</span>
            <span class="balance-value header-balance-value" id="header-user-balance" style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-size: 15px;">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
            <span class="balance-currency" style="color: #ffffff; font-size: 11px;">{{ auth()->user()->currency }}</span>
        </div>
        <button onclick="window.location.href='{{ route('dashboard') }}'" style="background: #007bff; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);">
             ✕ EXIT
        </button>
    </div>
</nav>

<!-- MAIN GAME WORKSPACE (Centered layout) -->
<div class="game-container-wrapper">
  <div class="game-flex-container">

    <!-- LEFT COLUMN (Bet Controls) -->
    <div class="left-column">
      <div style="margin-bottom:8px;">
        <div class="game-tabs">
          <div class="game-tab active">Regular</div>
          <div class="game-tab">Autoplay</div>
        </div>
      </div>
      <div class="left-panel">
        <div class="panel-header">Choose a cell</div>
        <div class="panel-body">

          <!-- BET AMOUNT -->
          <div class="bet-input-wrap">
            <input type="number" id="betAmount" value="2" min="0.1" step="1">
            <div class="bet-x-btn" onclick="clearBet()" title="Clear">✕</div>
          </div>

          <!-- QUICK BETS -->
          <div class="quick-bets">
            <div class="qbet" onclick="setBet(2)">2</div>
            <div class="qbet" onclick="setBet(5)">5</div>
            <div class="qbet" onclick="setBet(10)">10</div>
            <div class="qbet" onclick="setBet(25)">25</div>
            <div class="qbet" onclick="setBet(50)">50</div>
            <div class="qbet" onclick="setBet(100)">100</div>
          </div>

          <!-- MINES SELECTOR -->
          <div class="mines-row">
            <div class="mine-count-btn active" onclick="setMinePreset(3)">3</div>
            <div class="mine-count-btn" onclick="setMinePreset(5)">5</div>
            <div class="mine-adj" onclick="adjMines(-1)">−</div>
            <div style="flex:1; text-align:center;">
              <div class="mines-label">Mines</div>
              <div class="mines-val" id="minesDisplay">3</div>
            </div>
            <div class="mine-adj" onclick="adjMines(1)">+</div>
            <div class="mine-count-btn" onclick="setMinePreset(10)">10</div>
            <div class="mine-count-btn" onclick="setMinePreset(20)">20</div>
          </div>

          <!-- BUTTONS -->
          <div class="action-row mb-2">
            <div class="btn-icon" onclick="toggleMute()" id="muteBtn" title="Mute">🔊</div>
            <button class="btn-take flex-grow-1" id="mainBtn" onclick="handleMainBtn()">PLACE BET</button>
            <div class="btn-icon" onclick="showInfo()" title="Info">ℹ</div>
          </div>

          <!-- GAME INFO -->
          <div class="info-box">
            <div class="info-box-header">Game Information</div>
            <div class="info-row">
              <div class="info-label"><span>🔷</span> Cells opened</div>
              <div class="info-val" id="cellsOpened">0 / 25</div>
            </div>
            <div class="info-row">
              <div class="info-label"><span>💎</span> Gems left</div>
              <div class="info-val" id="gemsLeft">22</div>
            </div>
            <div class="info-row">
              <div class="info-label"><span>💣</span> Risk of explosion</div>
              <div class="info-val danger" id="riskPct">12%</div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- MIDDLE COLUMN (Grid Panel) -->
    <div class="middle-column">
      <!-- TITLE PANEL -->
      <div class="title-panel">
        <div class="crystal-deco" style="left:-20px; top:-20px;">💎</div>
        <div class="crystal-deco" style="right:-10px; top:-10px;">💎</div>
        <div class="game-title">GEMS<span style="color:var(--gold);font-family:'Cinzel',serif;"> ✦ </span>MINES</div>
        <div class="jackpot-badge">✦ JACKPOT ✦</div>
      </div>

      <!-- MULTIPLIER ROW -->
      <div class="mult-row" id="multRow">
        <div class="mult-badge active-mult">x1.07</div>
        <div class="mult-badge">x1.17</div>
        <div class="mult-badge">x1.28</div>
        <div class="mult-badge">x1.41</div>
        <div class="mult-badge">x1.56</div>
        <div class="mult-badge">x1.72</div>
        <div class="mult-badge">x1.91</div>
        <div class="mult-badge">x2.12</div>
      </div>

      <!-- GRID -->
      <div class="grid-panel">
        <div class="cell-grid" id="cellGrid"></div>
      </div>
    </div>

    <!-- RIGHT COLUMN (Winnings + Sidebar Info) -->
    <div class="right-column">
      <!-- REAL MONEY PLAY PANEL -->
      <div class="demo-panel" style="min-width:200px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
          <span style="width:10px;height:10px;border-radius:50%;background:var(--gem-green);display:inline-block;box-shadow:0 0 6px var(--gem-green);" id="modeDot"></span>
          <span style="font-family:'Orbitron',sans-serif;font-size:11px;letter-spacing:1px;color:#fff;" id="modeStatusText">REAL PLAY</span>
        </div>
        <div class="demo-balance-row">
          <div class="demo-label" style="color:var(--text-muted);">Active Balance</div>
          <div class="demo-val" id="balance">0.00</div>
        </div>
        <div class="demo-balance-row" style="margin-top:4px;">
          <div class="demo-label" style="color:var(--text-muted);">Total Winnings</div>
          <div class="demo-val green" id="totalWin">0.00</div>
        </div>
        <div class="demo-note">Each gem you open yields a dynamic payout multiplier. Cash out at any point to claim your BDT.</div>
        <button class="btn-exit-demo" id="exitDemoBtn" onclick="togglePlayMode()">BACK TO LOBBY</button>
        <button class="btn-exit-demo" style="margin-top:6px;border-color:#0d4030;color:#3a9070;" onclick="resetGame()">↺ NEW GAME</button>
      </div>

      <!-- SIDEBAR ICONS -->
      <div class="sidebar-btns" style="flex-direction:row; justify-content:center; flex-wrap:wrap; gap:8px;">
        <div class="sb-btn" title="Profile" onclick="window.location.href='{{ route('dashboard') }}'">👤</div>
        <div class="sb-btn" title="Wallet" onclick="window.location.href='{{ route('dashboard') }}'">💰</div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ── DYNAMIC CURRENCY & REAL BALANCE STATE ──
  const userCurrency = "{{ auth()->user()->currency }}";
  const currencySymbol = userCurrency === 'BDT' ? '৳' : (userCurrency === 'INR' ? '₹' : '$');

  const urlParams = new URLSearchParams(window.location.search);
  let realBalance = parseFloat("{{ auth()->user()->balance }}");
  let isDemoMode = urlParams.get('demo') === '1' || (realBalance < 2);

  let demoBalance = 10000.00;
  let balance = isDemoMode ? demoBalance : realBalance;

  let totalWin = 0;
  let minesCount = 3;
  let betAmount = 2;
  let gameActive = false;
  let cellsRevealedCount = 0;
  let muted = false;
  let minePositions = new Set();
  let revealedPositions = new Set();

  const TOTAL_CELLS = 25;

  // ── SOUND SYNTHESIS (Web Audio API) ──
  let audioCtx = null;
  function initAudio() {
    if (!audioCtx) {
      audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
  }
  function playSound(type) {
    if (muted) return;
    initAudio();
    if (!audioCtx) return;
    
    const now = audioCtx.currentTime;
    
    if (type === 'click') {
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.connect(gain); gain.connect(audioCtx.destination);
      osc.type = 'sine';
      osc.frequency.setValueAtTime(600, now);
      osc.frequency.exponentialRampToValueAtTime(150, now + 0.08);
      gain.gain.setValueAtTime(0.05, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
      osc.start(now); osc.stop(now + 0.08);
    } else if (type === 'gem') {
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.connect(gain); gain.connect(audioCtx.destination);
      osc.type = 'sine';
      osc.frequency.setValueAtTime(880, now);
      osc.frequency.setValueAtTime(1318.51, now + 0.08);
      gain.gain.setValueAtTime(0.1, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.22);
      osc.start(now); osc.stop(now + 0.22);
    } else if (type === 'bomb') {
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.connect(gain); gain.connect(audioCtx.destination);
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(100, now);
      osc.frequency.linearRampToValueAtTime(30, now + 0.5);
      gain.gain.setValueAtTime(0.2, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.5);
      osc.start(now); osc.stop(now + 0.5);
    } else if (type === 'win') {
      const notes = [523.25, 659.25, 783.99, 1046.50];
      notes.forEach((freq, idx) => {
        const o = audioCtx.createOscillator();
        const g = audioCtx.createGain();
        o.connect(g); g.connect(audioCtx.destination);
        o.type = 'triangle';
        o.frequency.setValueAtTime(freq, now + idx * 0.08);
        g.gain.setValueAtTime(0.12, now + idx * 0.08);
        g.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.2);
        o.start(now + idx * 0.08); o.stop(now + idx * 0.08 + 0.22);
      });
    }
  }

  // ── SYNC BALANCE WITH Laravel Database ──
  function syncBalance(newBalance) {
    if (isDemoMode) {
      demoBalance = newBalance;
      return;
    }
    realBalance = newBalance;
    
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

  // ── MULTIPLIERS FORMULA (Standard Mines Math) ──
  // M_k = M_k-1 * (25 - k + 1) / (25 - mines - k + 1) * 0.98 (house edge)
  function getMultiplier(mines, revealed) {
    let mult = 1.0;
    for (let k = 1; k <= revealed; k++) {
      mult *= (25 - k + 1) / (25 - mines - k + 1);
    }
    mult *= 0.98; // House commission edge
    return Math.max(1.01, Math.round(mult * 100) / 100);
  }

  // ── INIT GRID ──
  function buildGrid() {
    const grid = document.getElementById('cellGrid');
    grid.innerHTML = '';
    for (let i = 0; i < TOTAL_CELLS; i++) {
      const cell = document.createElement('div');
      cell.className = 'cell';
      cell.dataset.index = i;
      cell.innerHTML = '<div class="cell-inner"></div>';
      cell.addEventListener('click', () => {
        initAudio();
        clickCell(i);
      });
      grid.appendChild(cell);
    }
  }

  // ── PLACE BET / START GAME ──
  function startGame() {
    initAudio();
    playSound('click');
    betAmount = parseFloat(document.getElementById('betAmount').value) || 2;
    if (betAmount > balance) { toast('Insufficient balance!', 'lose'); return; }
    if (betAmount <= 0) { toast('Enter a valid bet!', ''); return; }

    balance = Math.round((balance - betAmount) * 100) / 100;
    updateBalance();
    syncBalance(balance);

    minePositions.clear();
    revealedPositions.clear();
    cellsRevealedCount = 0;
    gameActive = true;

    // Place mines randomly
    while (minePositions.size < minesCount) {
      minePositions.add(Math.floor(Math.random() * TOTAL_CELLS));
    }

    // Reset all cells
    document.querySelectorAll('.cell').forEach(c => {
      c.className = 'cell';
      c.querySelector('.cell-inner').textContent = '';
    });

    updateInfo();
    setBtn('take');
    updateMultipliers();
    toast('Game started! Find the gems!', '');
  }

  // ── CLICK CELL ──
  function clickCell(index) {
    if (!gameActive) { toast('Place a bet first!', ''); return; }
    if (revealedPositions.has(index)) return;

    revealedPositions.add(index);
    cellsRevealedCount++;
    const cell = document.querySelector(`.cell[data-index="${index}"]`);

    if (minePositions.has(index)) {
      // BOMB
      playSound('bomb');
      cell.className = 'cell revealed mine';
      cell.querySelector('.cell-inner').textContent = '💣';
      revealAllMines();
      gameOver(false);
    } else {
      // GEM
      playSound('gem');
      cell.className = 'cell revealed gem';
      cell.querySelector('.cell-inner').textContent = '💎';
      updateInfo();
      updateMultipliers();

      // Check if all gems found
      const totalGems = TOTAL_CELLS - minesCount;
      if (cellsRevealedCount >= totalGems) {
        gameOver(true);
      } else {
        // Update main button with current cashout amount
        const mult = getMultiplier(minesCount, cellsRevealedCount);
        const cashAmt = betAmount * mult;
        document.getElementById('mainBtn').textContent = `CASH OUT: ${currencySymbol}${cashAmt.toFixed(2)}`;
      }
    }
  }

  // ── REVEAL ALL MINES ──
  function revealAllMines() {
    minePositions.forEach(idx => {
      if (!revealedPositions.has(idx)) {
        const cell = document.querySelector(`.cell[data-index="${idx}"]`);
        cell.className = 'cell revealed mine';
        cell.querySelector('.cell-inner').textContent = '💣';
      }
    });
  }

  // ── GAME OVER ──
  function gameOver(win) {
    gameActive = false;
    if (win) {
      const mult = getMultiplier(minesCount, cellsRevealedCount);
      const winAmt = Math.round(betAmount * mult * 100) / 100;
      balance = Math.round((balance + winAmt) * 100) / 100;
      totalWin = Math.round((totalWin + winAmt) * 100) / 100;
      updateBalance();
      syncBalance(balance);
      playSound('win');
      toast(`💎 YOU WIN ${currencySymbol}${winAmt.toFixed(2)} (x${mult.toFixed(2)})`, 'win');
    } else {
      toast('💣 BOOM! Better luck next time!', 'lose');
    }
    setBtn('new');
  }

  // ── TAKE WINNINGS ──
  function takeWinnings() {
    if (!gameActive || cellsRevealedCount === 0) return;
    const mult = getMultiplier(minesCount, cellsRevealedCount);
    const winAmt = Math.round(betAmount * mult * 100) / 100;
    balance = Math.round((balance + winAmt) * 100) / 100;
    totalWin = Math.round((totalWin + winAmt) * 100) / 100;
    updateBalance();
    syncBalance(balance);
    playSound('win');
    gameActive = false;
    revealAllMines();
    toast(`✅ Collected ${currencySymbol}${winAmt.toFixed(2)} (x${mult.toFixed(2)})`, 'win');
    setBtn('new');
  }

  // ── MAIN BTN HANDLER ──
  function handleMainBtn() {
    const btn = document.getElementById('mainBtn');
    const mode = btn.dataset.mode || 'place';
    if (mode === 'place') startGame();
    else if (mode === 'take') takeWinnings();
    else resetGame();
  }

  function setBtn(mode) {
    const btn = document.getElementById('mainBtn');
    btn.dataset.mode = mode;
    if (mode === 'place') {
      btn.textContent = 'PLACE BET';
      btn.style.background = 'var(--btn-bg)';
      btn.style.color = '#3a2000';
    } else if (mode === 'take') {
      const mult = getMultiplier(minesCount, cellsRevealedCount);
      const cashAmt = betAmount * mult;
      btn.textContent = `CASH OUT: ${currencySymbol}${cashAmt.toFixed(2)}`;
      btn.style.background = 'linear-gradient(135deg, #1a8a40 0%, #0d6030 100%)';
      btn.style.color = '#fff';
    } else {
      btn.textContent = 'NEW GAME';
      btn.style.background = 'linear-gradient(135deg, #1a5fa0 0%, #0d3060 100%)';
      btn.style.color = '#fff';
    }
  }

  // ── RESET ──
  function resetGame() {
    playSound('click');
    gameActive = false;
    cellsRevealedCount = 0;
    minePositions.clear();
    revealedPositions.clear();
    buildGrid();
    updateInfo();
    setBtn('place');
  }

  // ── UPDATE UI ──
  function updateBalance() {
    document.getElementById('balance').textContent = currencySymbol + balance.toFixed(2);
    document.getElementById('totalWin').textContent = currencySymbol + totalWin.toFixed(2);
    
    // Header balance
    const hBal = document.getElementById('header-user-balance');
    if (hBal) {
      hBal.textContent = (isDemoMode ? realBalance : balance).toFixed(2);
    }
  }

  function updateInfo() {
    const gemsTotal = TOTAL_CELLS - minesCount;
    const gemsLeft = gemsTotal - cellsRevealedCount;
    const remainingCells = TOTAL_CELLS - cellsRevealedCount;
    const risk = remainingCells > 0 ? Math.round((minesCount / remainingCells) * 100) : 0;

    document.getElementById('cellsOpened').textContent = `${cellsRevealedCount} / ${TOTAL_CELLS}`;
    document.getElementById('gemsLeft').textContent = Math.max(0, gemsLeft);
    document.getElementById('riskPct').textContent = `${risk}%`;
  }

  function updateMultipliers() {
    const row = document.getElementById('multRow');
    const badges = row.querySelectorAll('.mult-badge');
    badges.forEach((b, i) => {
      const mult = getMultiplier(minesCount, cellsRevealedCount + i + 1);
      b.textContent = `x${mult.toFixed(2)}`;
      b.className = 'mult-badge' + (i === 0 ? ' active-mult' : '');
    });
  }

  // ── BET CONTROLS ──
  function setBet(v) {
    playSound('click');
    document.getElementById('betAmount').value = v;
    betAmount = v;
  }
  function clearBet() {
    playSound('click');
    document.getElementById('betAmount').value = '';
    betAmount = 0;
  }

  // ── MINES CONTROLS ──
  function setMinesCount(n) {
    minesCount = Math.min(24, Math.max(1, n));
    document.getElementById('minesDisplay').textContent = minesCount;
    updateInfo();
    updateMultipliers();
  }
  function setMinePreset(n) {
    playSound('click');
    setMinesCount(n);
    document.querySelectorAll('.mine-count-btn').forEach(b => {
      b.classList.toggle('active', parseInt(b.textContent) === n);
    });
  }
  function adjMines(d) {
    playSound('click');
    setMinesCount(minesCount + d);
    document.querySelectorAll('.mine-count-btn').forEach(b => b.classList.remove('active'));
  }

  // ── MUTE ──
  function toggleMute() {
    muted = !muted;
    document.getElementById('muteBtn').textContent = muted ? '🔇' : '🔊';
  }

  // ── INFO ──
  function showInfo() {
    playSound('click');
    toast('💎 Open gems, avoid mines! Cash out to claim winnings.', '');
  }

  // ── TOAST ──
  let toastTimer;
  function toast(msg, type) {
    const existing = document.querySelector('.toast-msg');
    if (existing) existing.remove();
    const el = document.createElement('div');
    el.className = 'toast-msg ' + (type || '');
    el.textContent = msg;
    document.body.appendChild(el);
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.remove(), 3000);
  }

  // ── TABS ──
  document.querySelectorAll('.game-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      playSound('click');
      document.querySelectorAll('.game-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });

  function updateModeUI() {
    const dot = document.getElementById('modeDot');
    const text = document.getElementById('modeStatusText');
    const exitBtn = document.getElementById('exitDemoBtn');
    
    if (isDemoMode) {
      dot.style.background = '#ffc107';
      dot.style.boxShadow = '0 0 6px #ffc107';
      text.textContent = 'DEMO PLAY';
      if (exitBtn) exitBtn.textContent = 'SWITCH TO REAL PLAY';
    } else {
      dot.style.background = 'var(--gem-green)';
      dot.style.boxShadow = '0 0 6px var(--gem-green)';
      text.textContent = 'REAL PLAY';
      if (exitBtn) exitBtn.textContent = 'BACK TO LOBBY';
    }
    updateBalance();
  }

  function togglePlayMode() {
    if (gameActive) {
      toast('Finish your active game first!', 'lose');
      return;
    }
    playSound('click');
    if (isDemoMode) {
      isDemoMode = false;
      balance = realBalance;
      updateModeUI();
    } else {
      window.location.href = "{{ route('dashboard') }}";
    }
  }

  // ── INIT ──
  buildGrid();
  updateModeUI();
  updateInfo();
  updateMultipliers();
  setBtn('place');
</script>
</body>
</html>