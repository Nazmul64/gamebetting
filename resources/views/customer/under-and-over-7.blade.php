<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Under and Over 7 - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
      background: #060913;
      color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* Main Container */
    .game-wrapper {
      position: relative;
      width: 100%;
      flex: 1;
      min-height: calc(100vh - 70px);
      background: #080d1a radial-gradient(circle at 50% 35%, #18233c 0%, #0d1527 50%, #050811 100%);
      background-repeat: no-repeat;
      background-size: cover;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px 24px;
      overflow: hidden;
    }

    /* Watermark background dice */
    .bg-dice-watermark {
      position: absolute;
      inset: 0;
      pointer-events: none;
      opacity: 0.08;
      background-image: 
        radial-gradient(circle at 15% 25%, rgba(255,255,255,0.4) 0, transparent 40%),
        radial-gradient(circle at 85% 65%, rgba(255,255,255,0.3) 0, transparent 35%);
      z-index: 1;
    }
    .bg-dice-watermark::before {
      content: "⚅";
      position: absolute;
      left: 6%;
      top: 18%;
      font-size: 140px;
      color: #ffffff;
      transform: rotate(-25deg);
      filter: blur(4px);
    }
    .bg-dice-watermark::after {
      content: "⚄";
      position: absolute;
      right: 8%;
      bottom: 25%;
      font-size: 160px;
      color: #ffffff;
      transform: rotate(35deg);
      filter: blur(5px);
    }

    .game-content {
      position: relative;
      z-index: 5;
      width: 100%;
      max-width: 1080px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      flex: 1;
      gap: 14px;
    }

    /* Top Bar */
    .top-bar {
      width: 100%;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      position: relative;
    }

    .breadcrumb-trail {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.6px;
      color: #7dd3fc;
      text-transform: uppercase;
    }
    .breadcrumb-trail a {
      color: #7dd3fc;
      text-decoration: none;
      transition: color 0.2s;
    }
    .breadcrumb-trail a:hover {
      color: #38bdf8;
      text-decoration: underline;
    }
    .breadcrumb-trail span.sep {
      color: #475569;
    }
    .breadcrumb-trail span.curr {
      color: #cbd5e1;
    }

    /* Logo and Header Center */
    .header-center {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      margin-top: -6px;
    }
    .game-logo-img {
      height: 64px;
      width: auto;
      max-width: 220px;
      object-fit: contain;
      filter: drop-shadow(0 4px 15px rgba(0,0,0,0.8));
    }
    .how-to-play-link {
      font-size: 11px;
      font-weight: 800;
      color: #94a3b8;
      text-decoration: underline;
      text-underline-offset: 3px;
      cursor: pointer;
      font-style: italic;
      letter-spacing: 0.5px;
      transition: color 0.2s;
    }
    .how-to-play-link:hover {
      color: #facc15;
    }

    /* Top Right Jackpot Box */
    .jackpot-badge {
      background: linear-gradient(180deg, #1e2029 0%, #0e1017 100%);
      border: 2px solid #eab308;
      border-radius: 6px;
      padding: 6px 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 15px rgba(234, 179, 8, 0.4), inset 0 0 8px rgba(234, 179, 8, 0.2);
    }
    .jackpot-badge span {
      font-size: 15px;
      font-weight: 900;
      letter-spacing: 1.5px;
      background: linear-gradient(180deg, #fff7c2 0%, #facc15 50%, #ca8a04 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-transform: uppercase;
    }

    /* Center Stage: Two Golden Dice Frames */
    .dice-stage-area {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: clamp(16px, 4vw, 44px);
      margin: 8px 0;
      perspective: 1000px;
    }

    .die-outer-frame {
      width: clamp(130px, 20vw, 190px);
      height: clamp(130px, 20vw, 190px);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      filter: drop-shadow(0 15px 30px rgba(0,0,0,0.9));
      transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .die-outer-frame img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
      transition: filter 0.2s ease;
    }

    .die-outer-frame.rolling {
      animation: diceShake 0.12s infinite alternate ease-in-out;
    }
    @keyframes diceShake {
      0% { transform: translateY(-8px) rotate(-4deg) scale(1.04); }
      100% { transform: translateY(8px) rotate(4deg) scale(0.98); }
    }

    /* Result Sum Banner */
    .round-result-pill {
      min-height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 800;
      letter-spacing: 0.5px;
      color: #94a3b8;
      text-transform: uppercase;
      transition: all 0.3s;
    }
    .round-result-pill.win {
      color: #4ade80;
      font-size: 16px;
      font-weight: 900;
      text-shadow: 0 0 12px rgba(74, 222, 128, 0.6);
    }
    .round-result-pill.loss {
      color: #f87171;
    }

    /* 3 Betting Choice Boxes */
    .bet-choices-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      width: 100%;
      max-width: 660px;
      background: rgba(14, 22, 39, 0.9);
      border: 1px solid rgba(56, 189, 248, 0.15);
      border-radius: 12px;
      padding: 6px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    }

    .choice-card {
      flex: 1;
      min-width: 0;
      background: #111a2e;
      border: 2px solid transparent;
      border-radius: 8px;
      padding: 8px 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }
    .choice-card:hover {
      background: #192744;
      border-color: rgba(234, 179, 8, 0.4);
      transform: translateY(-2px);
    }
    .choice-card.active {
      background: linear-gradient(180deg, #1a2846 0%, #0f192c 100%);
      border-color: #eab308;
      box-shadow: 0 0 20px rgba(234, 179, 8, 0.4), inset 0 0 12px rgba(234, 179, 8, 0.15);
    }

    .card-mult-header {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .card-coin-icon {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: radial-gradient(circle, #fde047 30%, #ca8a04 100%);
      border: 1.5px solid #fef08a;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 6px rgba(250, 204, 21, 0.6);
      color: #451a03;
      font-size: 10px;
      font-weight: 900;
    }
    .card-mult-text {
      font-size: 16px;
      font-weight: 900;
      color: #f8fafc;
      letter-spacing: 0.5px;
    }
    .choice-card.active .card-mult-text {
      color: #fde047;
      text-shadow: 0 0 10px rgba(253, 224, 71, 0.5);
    }

    .card-subtext {
      font-size: 11px;
      font-weight: 800;
      color: #94a3b8;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      white-space: nowrap;
    }
    .choice-card.active .card-subtext {
      color: #cbd5e1;
    }

    /* Golden Rounded Chips Bar */
    .chips-pill-bar {
      width: 100%;
      max-width: 480px;
      background: linear-gradient(180deg, #261f14 0%, #15110a 100%);
      border: 2px solid #ca8a04;
      border-radius: 30px;
      padding: 4px 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 4px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.7), inset 0 1px 2px rgba(254, 240, 138, 0.3);
    }

    .chip-item-btn {
      flex: 1;
      padding: 7px 0;
      background: transparent;
      border: none;
      color: #fde047;
      font-size: 13px;
      font-weight: 800;
      cursor: pointer;
      border-radius: 20px;
      transition: all 0.15s ease;
      text-align: center;
    }
    .chip-item-btn:hover {
      background: rgba(250, 204, 21, 0.2);
      color: #fff;
    }
    .chip-item-btn.selected {
      background: linear-gradient(180deg, #facc15 0%, #ca8a04 100%);
      color: #0b0702;
      font-weight: 900;
      box-shadow: 0 0 10px rgba(250, 204, 21, 0.6);
    }

    /* Bet Input + Place Bet Row */
    .action-controls-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      width: 100%;
      max-width: 480px;
    }

    .stake-input-box {
      flex: 1;
      background: #171724;
      border: 2px solid #334155;
      border-radius: 24px;
      padding: 6px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      box-shadow: inset 0 2px 6px rgba(0,0,0,0.6);
      transition: border-color 0.2s;
    }
    .stake-input-box:focus-within {
      border-color: #facc15;
    }
    .stake-input-box input {
      background: transparent;
      border: none;
      outline: none;
      color: #f8fafc;
      font-size: 16px;
      font-weight: 800;
      width: 100%;
    }
    .stake-clear-btn {
      color: #64748b;
      cursor: pointer;
      font-size: 14px;
      font-weight: 700;
      padding: 2px 4px;
      transition: color 0.15s;
    }
    .stake-clear-btn:hover {
      color: #f87171;
    }

    .place-bet-green-btn {
      flex: 1.2;
      background: linear-gradient(180deg, #84cc16 0%, #4d7c0f 100%);
      border: 1.5px solid #a3e635;
      border-radius: 24px;
      padding: 13px 20px;
      color: #ffffff;
      font-size: 15px;
      font-weight: 900;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(77, 124, 15, 0.6), inset 0 2px 4px rgba(255,255,255,0.4);
      transition: all 0.15s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      text-shadow: 0 1px 3px rgba(0,0,0,0.6);
    }
    .place-bet-green-btn:hover:not(:disabled) {
      filter: brightness(1.1);
      transform: translateY(-1px);
      box-shadow: 0 8px 25px rgba(77, 124, 15, 0.8);
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
    }

    /* Floating Mode Toggle (Bottom Right) */
    .mode-toggle-chip {
      position: fixed;
      right: 18px;
      bottom: 18px;
      z-index: 30;
      background: rgba(15, 23, 42, 0.85);
      border: 1px solid #1e3a5f;
      border-radius: 6px;
      padding: 5px 12px;
      font-size: 11px;
      font-weight: 800;
      color: #7dd3fc;
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.6);
      transition: all 0.2s;
    }
    .mode-toggle-chip:hover {
      background: #1e293b;
      border-color: #38bdf8;
      color: #fff;
    }
    .mode-toggle-chip .dot-indicator {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #38bdf8;
    }
    .mode-toggle-chip.real-active {
      border-color: #eab308;
      color: #fde047;
    }
    .mode-toggle-chip.real-active .dot-indicator {
      background: #eab308;
      box-shadow: 0 0 6px #eab308;
    }

    /* Right Floating Side Strip */
    .right-side-tools {
      position: fixed;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 25;
    }
    .tool-icon-btn {
      width: 34px;
      height: 34px;
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid rgba(148, 163, 184, 0.15);
      border-radius: 8px;
      color: #94a3b8;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      backdrop-filter: blur(6px);
      transition: all 0.2s;
    }
    .tool-icon-btn:hover {
      background: #1e293b;
      border-color: #facc15;
      color: #facc15;
      transform: scale(1.08);
    }

    /* Celebration Motion Graphics Modal */
    .win-overlay-modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(6px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .win-overlay-modal.show {
      display: flex;
      animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }
    @keyframes modalPop {
      0% { opacity: 0; transform: scale(0.7); }
      100% { opacity: 1; transform: scale(1); }
    }
    .win-card-content {
      background: radial-gradient(circle, #251e12 0%, #0c0803 100%);
      border: 3px solid #eab308;
      border-radius: 20px;
      padding: 30px 40px;
      text-align: center;
      box-shadow: 0 0 50px rgba(234, 179, 8, 0.6), inset 0 0 20px rgba(234, 179, 8, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }
    .win-title {
      font-size: 26px;
      font-weight: 900;
      background: linear-gradient(180deg, #fff7c2 0%, #facc15 60%, #ca8a04 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 2px;
      text-transform: uppercase;
    }
    .win-amount-badge {
      font-size: 38px;
      font-weight: 900;
      color: #4ade80;
      text-shadow: 0 0 20px rgba(74, 222, 128, 0.8);
    }
    .win-close-btn {
      margin-top: 10px;
      background: #eab308;
      border: none;
      color: #000;
      font-weight: 800;
      padding: 8px 24px;
      border-radius: 20px;
      cursor: pointer;
      font-size: 13px;
    }

    /* Rules Modal */
    .rules-modal {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.8);
      backdrop-filter: blur(5px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .rules-modal.show { display: flex; }
    .rules-body {
      background: #0f172a;
      border: 2px solid #38bdf8;
      border-radius: 16px;
      padding: 24px;
      max-width: 440px;
      width: 90%;
      color: #cbd5e1;
      font-size: 13px;
      line-height: 1.6;
    }

    @media (max-width: 640px) {
      .game-wrapper {
        padding: 8px 10px 16px;
      }
      .bet-choices-row {
        gap: 6px;
        padding: 4px;
      }
      .card-mult-text { font-size: 13px; }
      .card-subtext { font-size: 9px; }
      .right-side-tools { display: none; }
    }
  </style>
</head>
<body oncontextmenu="return false;">

  @include('customer.header')

  <!-- Audio elements -->
  <audio id="dice-roll-sound" src="/assets/audio/games/under_and_over_7_bg.mp3" preload="auto"></audio>

  <div class="game-wrapper">
    <div class="bg-dice-watermark"></div>

    <div class="game-content">
      <!-- Top Header Bar -->
      <div class="top-bar">
        <div class="breadcrumb-trail">
          <a href="{{ route('home') }}">1XGAMES</a>
          <span class="sep">/</span>
          <a href="{{ route('dashboard') }}">DICE</a>
          <span class="sep">/</span>
          <span class="curr">UNDER AND OVER 7</span>
        </div>

        <div class="header-center">
          <img src="/under-and-over-7/logo.png" alt="Under and Over 7" class="game-logo-img">
          <span class="how-to-play-link" onclick="openRules()">HOW TO PLAY</span>
        </div>

        <div class="jackpot-badge">
          <span>JACKPOT</span>
        </div>
      </div>

      <!-- Center Stage: 2 Golden Dice -->
      <div class="dice-stage-area">
        <div class="die-outer-frame" id="die-frame-1">
          <img id="die-img-1" src="/under-and-over-7/start_3@1x.2084f5d3edf3.png" alt="Die 1">
        </div>
        <div class="die-outer-frame" id="die-frame-2">
          <img id="die-img-2" src="/under-and-over-7/start_4@1x.1b2b15b7d3f2.png" alt="Die 2">
        </div>
      </div>

      <!-- Result Banner -->
      <div class="round-result-pill" id="result-status">
        CHOOSE YOUR BET &amp; ROLL
      </div>

      <!-- 3 Betting Choice Cards -->
      <div class="bet-choices-row">
        <!-- OVER -->
        <div class="choice-card" id="choice-over" onclick="selectBet('over')">
          <div class="card-mult-header">
            <span class="card-coin-icon">৳</span>
            <span class="card-mult-text">x 2.3</span>
          </div>
          <div class="card-subtext">OVER &rArr; 8 9 10 11 12</div>
        </div>

        <!-- EQUAL -->
        <div class="choice-card" id="choice-equal" onclick="selectBet('equal')">
          <div class="card-mult-header">
            <span class="card-coin-icon">৳</span>
            <span class="card-mult-text">x 5.8</span>
          </div>
          <div class="card-subtext">EQUAL &rArr; 7</div>
        </div>

        <!-- UNDER (Default active) -->
        <div class="choice-card active" id="choice-under" onclick="selectBet('under')">
          <div class="card-mult-header">
            <span class="card-coin-icon">৳</span>
            <span class="card-mult-text">x 2.3</span>
          </div>
          <div class="card-subtext">UNDER &rArr; 2 3 4 5 6</div>
        </div>
      </div>

      <!-- Golden Chips Bar -->
      <div class="chips-pill-bar">
        <button class="chip-item-btn selected" onclick="setBetStake(20, this)">20</button>
        <button class="chip-item-btn" onclick="setBetStake(100, this)">100</button>
        <button class="chip-item-btn" onclick="setBetStake(300, this)">300</button>
        <button class="chip-item-btn" onclick="setBetStake(800, this)">800</button>
        <button class="chip-item-btn" onclick="setBetStake(3000, this)">3000</button>
        <button class="chip-item-btn" onclick="setBetStake(10000, this)">10000</button>
      </div>

      <!-- Action Row: Input + Green Place Bet -->
      <div class="action-controls-row">
        <div class="stake-input-box">
          <input type="number" id="stake-input" value="20" min="1" max="50000">
          <span class="stake-clear-btn" onclick="clearStake()">✕</span>
        </div>

        <button class="place-bet-green-btn" id="btn-place-bet" onclick="rollDiceAndBet()">
          PLACE A BET
        </button>
      </div>
    </div>
  </div>

  <!-- Right Floating Tool Bar -->
  <div class="right-side-tools">
    <div class="tool-icon-btn" title="Settings" onclick="openRules()"><i class="fa-solid fa-gear"></i></div>
    <div class="tool-icon-btn" title="Bonus" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-gift"></i></div>
    <div class="tool-icon-btn" title="Lucky 7" style="font-weight:900; color:#facc15;">7</div>
    <div class="tool-icon-btn" title="Sound" id="sound-btn" onclick="toggleSound()"><i class="fa-solid fa-volume-high" id="sound-icon"></i></div>
  </div>

  <!-- Bottom Right Mode Toggle -->
  <div class="mode-toggle-chip" id="mode-chip" onclick="toggleDemoMode()">
    <span class="dot-indicator"></span>
    <span id="mode-text">DEMO MODE</span>
    <span style="font-size:10px;">▲</span>
  </div>

  <!-- Celebratory Win Modal -->
  <div class="win-overlay-modal" id="win-modal" onclick="closeWinModal()">
    <div class="win-card-content" onclick="event.stopPropagation()">
      <div class="win-title">✨ BIG WIN! ✨</div>
      <div style="font-size:14px; color:#cbd5e1; font-weight:700;">CONGRATULATIONS!</div>
      <div class="win-amount-badge" id="win-amount-text">+৳ 46.00</div>
      <button class="win-close-btn" onclick="closeWinModal()">CONTINUE</button>
    </div>
  </div>

  <!-- How to Play Modal -->
  <div class="rules-modal" id="rules-modal" onclick="closeRules()">
    <div class="rules-body" onclick="event.stopPropagation()">
      <h3 style="color:#facc15; font-size:18px; margin-bottom:12px;">Under and Over 7 Rules</h3>
      <p style="margin-bottom:8px;">Predict the sum of two 6-sided dice:</p>
      <ul style="padding-left:18px; margin-bottom:12px;">
        <li><strong>UNDER 7 (2, 3, 4, 5, 6):</strong> Payout 2.30×</li>
        <li><strong>EQUAL 7 (7):</strong> Payout 5.80×</li>
        <li><strong>OVER 7 (8, 9, 10, 11, 12):</strong> Payout 2.30×</li>
      </ul>
      <p style="margin-bottom:14px; font-size:12px; color:#94a3b8;">Choose your prediction, select your stake, and press <strong>PLACE A BET</strong> to roll.</p>
      <button class="win-close-btn" style="width:100%;" onclick="closeRules()">CLOSE</button>
    </div>
  </div>

  <script>
    const DICE_IMAGES = {
      1: "/under-and-over-7/start_1@1x.f678f21030d6.png",
      2: "/under-and-over-7/start_2@1x.c6a5059cefe1.png",
      3: "/under-and-over-7/start_3@1x.2084f5d3edf3.png",
      4: "/under-and-over-7/start_4@1x.1b2b15b7d3f2.png",
      5: "/under-and-over-7/start_5@1x.7dadbf95ed84.png",
      6: "/under-and-over-7/start_6@1x.e53d249d28cc.png"
    };

    let selectedChoice = 'under';
    let isRolling = false;
    let isDemo = true;
    let soundEnabled = true;
    let rollInterval = null;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function selectBet(choice) {
      if (isRolling) return;
      selectedChoice = choice;
      document.querySelectorAll('.choice-card').forEach(c => c.classList.remove('active'));
      const activeEl = document.getElementById('choice-' + choice);
      if (activeEl) activeEl.classList.add('active');
    }

    function setBetStake(amt, btn) {
      document.getElementById('stake-input').value = amt;
      document.querySelectorAll('.chip-item-btn').forEach(b => b.classList.remove('selected'));
      if (btn) btn.classList.add('selected');
    }

    function clearStake() {
      document.getElementById('stake-input').value = '20';
      document.querySelectorAll('.chip-item-btn').forEach(b => b.classList.remove('selected'));
      document.querySelector('.chip-item-btn')?.classList.add('selected');
    }

    function toggleDemoMode() {
      isDemo = !isDemo;
      const chip = document.getElementById('mode-chip');
      const text = document.getElementById('mode-text');
      if (isDemo) {
        chip.classList.remove('real-active');
        text.innerText = 'DEMO MODE';
      } else {
        chip.classList.add('real-active');
        text.innerText = 'REAL MONEY';
      }
    }

    function toggleSound() {
      soundEnabled = !soundEnabled;
      const icon = document.getElementById('sound-icon');
      if (soundEnabled) {
        icon.className = 'fa-solid fa-volume-high';
      } else {
        icon.className = 'fa-solid fa-volume-xmark';
      }
    }

    function openRules() {
      document.getElementById('rules-modal').classList.add('show');
    }
    function closeRules() {
      document.getElementById('rules-modal').classList.remove('show');
    }

    function closeWinModal() {
      document.getElementById('win-modal').classList.remove('show');
    }

    function triggerWinMotionGraphics(winAmount) {
      // Confetti burst
      if (typeof confetti === 'function') {
        confetti({
          particleCount: 80,
          spread: 70,
          origin: { y: 0.6 },
          colors: ['#facc15', '#4ade80', '#38bdf8', '#ffffff']
        });
      }

      // Trigger fire motion graphics celebration
      if (typeof window.triggerWinCelebration === 'function') {
        window.triggerWinCelebration({
          amount: winAmount,
          multiplier: 2.3,
          title: 'DICE LUCKY WIN!'
        });
      }

      // Show win modal
      document.getElementById('win-amount-text').innerText = `+৳ ${parseFloat(winAmount).toFixed(2)}`;
      document.getElementById('win-modal').classList.add('show');
    }

    async function rollDiceAndBet() {
      if (isRolling) return;
      const amount = parseFloat(document.getElementById('stake-input').value);
      if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid stake.");
        return;
      }

      isRolling = true;
      const btn = document.getElementById('btn-place-bet');
      btn.disabled = true;

      const frame1 = document.getElementById('die-frame-1');
      const frame2 = document.getElementById('die-frame-2');
      const img1 = document.getElementById('die-img-1');
      const img2 = document.getElementById('die-img-2');
      const status = document.getElementById('result-status');

      frame1.classList.add('rolling');
      frame2.classList.add('rolling');
      status.className = 'round-result-pill';
      status.innerText = 'ROLLING DICE...';

      // Rapidly cycle random faces while network request executes
      rollInterval = setInterval(() => {
        const r1 = Math.floor(Math.random() * 6) + 1;
        const r2 = Math.floor(Math.random() * 6) + 1;
        img1.src = DICE_IMAGES[r1];
        img2.src = DICE_IMAGES[r2];
      }, 70);

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

        const data = await res.json();

        setTimeout(() => {
          clearInterval(rollInterval);
          frame1.classList.remove('rolling');
          frame2.classList.remove('rolling');

          if (!data.success) {
            alert(data.error || "Bet failed");
            isRolling = false;
            btn.disabled = false;
            status.innerText = "CHOOSE YOUR BET & ROLL";
            return;
          }

          img1.src = DICE_IMAGES[data.die1] || DICE_IMAGES[1];
          img2.src = DICE_IMAGES[data.die2] || DICE_IMAGES[1];

          const isWin = data.is_win;
          const sum = data.sum;
          const choiceOutcome = sum < 7 ? 'UNDER 7' : (sum > 7 ? 'OVER 7' : 'EQUAL 7');

          if (isWin) {
            status.className = 'round-result-pill win';
            status.innerText = `🎉 WON! DICE SUM: ${sum} (${choiceOutcome}) +৳${parseFloat(data.win_amount).toFixed(2)}`;
            triggerWinMotionGraphics(data.win_amount);
          } else {
            status.className = 'round-result-pill loss';
            status.innerText = `LOSS! DICE SUM: ${sum} (${choiceOutcome})`;
          }

          // Update header balance if real mode
          if (!isDemo && typeof updateCustomerBalance === 'function' && data.balance !== undefined) {
            updateCustomerBalance(data.balance);
          }

          isRolling = false;
          btn.disabled = false;
        }, 800);

      } catch (err) {
        clearInterval(rollInterval);
        frame1.classList.remove('rolling');
        frame2.classList.remove('rolling');
        isRolling = false;
        btn.disabled = false;
        status.innerText = "CONNECTION ERROR";
      }
    }
  </script>
</body>
</html>
