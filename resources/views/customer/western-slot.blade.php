<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/western-slot/">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Western Slot - Wild West Casino</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Rye&family=Sancreek&family=Bebas+Neue&family=Montserrat:wght@600;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      overflow-y: auto !important;
      overflow-x: hidden !important;
    }
    .game-viewport {
      height: calc(100vh - 70px) !important;
      min-height: 760px;
    }
  </style>
</head>

<body>
  @include('customer.header')

  <!-- Ambient Audio & Sound Effects Canvas/WebAudio is in game.js -->

  <div class="game-viewport">
    <!-- Background Scene -->
    <div class="background-container">
      <img src="bg@1x.93f1283b5bd2.jpg" alt="Western Town" class="main-bg">

      <!-- Flying Eagle Sprite Animation (Flies from right to left) -->
      <div id="eagle-container" class="eagle-wrapper">
        <div id="eagle-sprite" class="eagle-sprite"></div>
      </div>
    </div>

    <!-- Unified Game Stage Scaler (Scales perfectly across desktop, tablet, and mobile) -->
    <div class="game-stage" id="game-stage">
      <!-- Top Left Fixed Jackpot Glow Banner -->
      <div class="top-jackpot-sign">
        <img src="jackpot-header-bg.1b89dcf9335b.png" alt="Jackpot Sign" class="jackpot-header-img">
        <span class="jackpot-sign-text">JACKPOT</span>
      </div>

      <!-- Left Cowboy Character -->
      <div class="character-cowboy">
        <img src="cowboy@1x.58cf8b4110d1.png" alt="Cowboy" class="cowboy-img">
        <div class="cigar-smoke" id="cigar-smoke"></div>
      </div>

      <!-- Main Slot Machine Centerpiece -->
      <div class="slot-machine-container">
        <div class="wood-cabinet">
        <img src="c-bg@1x.22d969ec69ba.jpg" alt="Cabinet Wood" class="cabinet-bg">

        <!-- Top Header Area -->
        <div class="cabinet-header">
          <!-- Jackpot Display with Stars -->
          <div class="jackpot-counter-box">
            <div class="jp-title">
              <img src="jp-star@1x.70dd0eda94af.png" alt="star" class="jp-star left">
              <span>JACKPOT</span>
              <img src="jp-star@1x.70dd0eda94af.png" alt="star" class="jp-star right">
            </div>
            <div class="jp-value" id="jackpot-amount">17,688.37</div>
          </div>

          <!-- Western Slot Parchment Sign -->
          <div class="logo-sign-box">
            <img src="logo-bg@1x.32129dd2924a.png" alt="Logo Scroll" class="logo-bg">
            <img src="logo@1x.b46570348f37.png" alt="Western Slot" class="logo-text">
          </div>

          <!-- Top Action Buttons (Info & Paytable) -->
          <div class="top-buttons">
            <button class="top-btn" id="btn-info" title="Game Rules & Info">
              <img src="info-icon@1x.beed954d6461.png" alt="Info">
            </button>
            <button class="top-btn" id="btn-comb" title="Paylines & Combinations">
              <img src="comb-icon@1x.6b0e90e4336a.png" alt="Combinations">
            </button>
          </div>
        </div>

        <!-- Center Reel Area with Copper Sideboards and Lever -->
        <div class="cabinet-center">
          <!-- Left Copper Plate (Payline Selectors 1-9 Vertical) -->
          <div class="side-panel left-panel">
            <img src="sb-bg@1x.53bc218467eb.png" alt="Side Panel" class="sb-bg">
            <div class="payline-pins-vertical" id="payline-pins-vertical">
              <div class="pin-btn active" data-line="1" id="pin-1">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">1</span>
              </div>
              <div class="pin-btn" data-line="2" id="pin-2">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">2</span>
              </div>
              <div class="pin-btn" data-line="3" id="pin-3">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">3</span>
              </div>
              <div class="pin-btn" data-line="4" id="pin-4">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">4</span>
              </div>
              <div class="pin-btn" data-line="5" id="pin-5">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">5</span>
              </div>
              <div class="pin-btn" data-line="6" id="pin-6">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">6</span>
              </div>
              <div class="pin-btn" data-line="7" id="pin-7">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">7</span>
              </div>
              <div class="pin-btn" data-line="8" id="pin-8">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">8</span>
              </div>
              <div class="pin-btn" data-line="9" id="pin-9">
                <img src="sb-num-bg@1x.2e7f98c07c04.png" class="pin-bg" alt="pin">
                <span class="pin-num">9</span>
              </div>
            </div>
          </div>

          <!-- Main Slot Reels Window (5x3) -->
          <div class="reels-stage" id="reels-stage">
            <img src="center-bg@1x.9e716d851370.png" alt="Frame" class="reels-frame">
            <img src="drum-bg@1x.db183fc2a722.jpg" alt="Drums Texture" class="drum-texture">

            <!-- The 5 Reels -->
            <div class="reels-container" id="reels-container">
              <div class="reel-column" id="reel-0">
                <div class="reel-strip" id="strip-0"></div>
              </div>
              <div class="reel-column" id="reel-1">
                <div class="reel-strip" id="strip-1"></div>
              </div>
              <div class="reel-column" id="reel-2">
                <div class="reel-strip" id="strip-2"></div>
              </div>
              <div class="reel-column" id="reel-3">
                <div class="reel-strip" id="strip-3"></div>
              </div>
              <div class="reel-column" id="reel-4">
                <div class="reel-strip" id="strip-4"></div>
              </div>
            </div>

            <!-- Payline Visual Overlays (Lines 1 to 9) -->
            <div class="paylines-overlay" id="paylines-overlay">
              <img src="line-one@1x.06e51cf10535.png" class="line-overlay" id="line-img-1" alt="Line 1">
              <img src="line-two@1x.409a6129777d.png" class="line-overlay" id="line-img-2" alt="Line 2">
              <img src="line-three@1x.d8e9236e4305.png" class="line-overlay" id="line-img-3" alt="Line 3">
              <img src="line-four@1x.f1a405895561.png" class="line-overlay" id="line-img-4" alt="Line 4">
              <svg class="line-overlay svg-line" id="line-img-5" viewBox="0 0 770 195">
                <path d="M 0 170 L 385 20 L 770 170" stroke="#f1c40f" stroke-width="8" fill="none"
                  filter="drop-shadow(0 0 8px #f39c12)" />
              </svg>
              <img src="line-six@1x.5e1a040f8676.png" class="line-overlay" id="line-img-6" alt="Line 6">
              <img src="line-seven@1x.62ef69d4a4d9.png" class="line-overlay" id="line-img-7" alt="Line 7">
              <img src="line-eight@1x.fbf6c0a0bbcd.png" class="line-overlay" id="line-img-8" alt="Line 8">
              <img src="line-nine@1x.443e14c2e5b1.png" class="line-overlay" id="line-img-9" alt="Line 9">
            </div>

            <!-- Win Box Animation Layer -->
            <div class="win-animation-layer" id="win-layer"></div>
          </div>

          <!-- Right Copper Plate with Interactive Mechanical Lever -->
          <div class="side-panel right-panel">
            <img src="sb-bg@1x.53bc218467eb.png" alt="Side Panel" class="sb-bg">
            <div class="lever-track">
              <div class="track-slot"></div>
              <div class="track-dots">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
                <img src="sb-dot@1x.44938845ac05.png" class="sb-dot" alt="dot">
              </div>
              <div class="lever-handle" id="lever-handle" title="Click or Pull Lever to Spin!">
                <img src="lever@1x.b84366df1158.png" alt="Slot Lever">
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom Control Dashboard -->
        <div class="cabinet-footer">
          <!-- Status Message Box -->
          <div class="msg-box" id="msg-box">
            <div class="ornate-border"></div>
            <span id="status-text">CLICK 'SPIN' TO START THE GAME</span>
          </div>

          <!-- Sound Mute/Unmute Button -->
          <button class="sound-btn" id="btn-sound" title="Toggle Sound">
            <img src="sound-icon@1x.45fbf8e509ad.png" alt="Sound">
            <div class="sound-slash" id="sound-slash"></div>
          </button>

          <!-- Your Stake Box -->
          <div class="control-card stake-card">
            <div class="card-label">YOUR STAKE:</div>
            <div class="stake-input-wrap">
              <button class="stake-step-btn" id="btn-stake-minus">-</button>
              <input type="number" id="stake-input" value="20" min="1" max="1000" step="5">
              <button class="stake-step-btn" id="btn-stake-plus">+</button>
              <button class="stake-clear-btn" id="btn-stake-clear" title="Reset Stake">×</button>
            </div>
          </div>

          <!-- Paylines Selector -->
          <div class="control-card paylines-card">
            <div class="card-label">PAYLINES:</div>
            <div class="lines-counter-wrap">
              <div class="lines-number" id="lines-count-display">1</div>
              <div class="lines-controls">
                <button class="arrow-btn left-arr" id="btn-line-minus">
                  <img src="opts-arr@1x.aaadf2c23abf.png" alt="Minus">
                </button>
                <div class="pip-bar" id="pip-bar">
                  <span class="pip active"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                  <span class="pip"></span>
                </div>
                <button class="arrow-btn right-arr" id="btn-line-plus">
                  <img src="opts-arr@1x.aaadf2c23abf.png" alt="Plus">
                </button>
              </div>
            </div>
          </div>

          <!-- Total Stake Display -->
          <div class="control-card total-stake-card">
            <div class="card-label">TOTAL STAKE:</div>
            <div class="total-stake-value" id="total-stake-display">20.00</div>
          </div>

          <!-- Turbo Mode Toggle Button -->
          <button class="turbo-btn" id="btn-turbo" title="Toggle Turbo Spins">
            <span class="turbo-icon">⚡</span>
            <span>TURBO</span>
          </button>

          <!-- Auto Play Toggle Button -->
          <button class="autoplay-btn" id="btn-autoplay" title="Toggle Autoplay">
            <span id="autoplay-text">AUTO PLAY</span>
          </button>

          <!-- Main Green Glowing Spin Button -->
          <button class="spin-btn" id="btn-spin" title="Spin the Reels!">
            <span class="spin-text">SPIN</span>
          </button>
        </div>

        <!-- Balance / Credit Footer Bar -->
        <div class="balance-bar">
          <div class="balance-item">
            <span class="lbl">BALANCE:</span>
            <span class="val" id="user-balance">5,000.00</span>
          </div>
          <div class="balance-item">
            <span class="lbl">LAST WIN:</span>
            <span class="val win-highlight" id="last-win-display">0.00</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Cowgirl Character with Animated Gun Arm -->
    <div class="character-cowgirl">
      <img src="girl@1x.04a7327386ca.png" alt="Cowgirl" class="cowgirl-body">
      <div class="cowgirl-arm-wrapper" id="cowgirl-arm">
        <img src="girl-hand@1x.e121a611a7cf.png" alt="Gun Hand" class="cowgirl-hand">
        <div class="gun-smoke" id="gun-smoke"></div>
      </div>
    </div>
  </div>

  <!-- Demo Mode Interactive Floating Panel (Clickable & Collapsible) -->
  <div class="demo-mode-panel" id="demo-mode-panel">
    <div class="demo-panel-header">
      <span class="demo-status-dot"></span>
      <span class="demo-panel-title">Demo mode</span>
    </div>
    <div class="demo-panel-stats">
      <div class="demo-stat-row">
        <span class="demo-stat-label">Balance (EUR)*</span>
        <span class="demo-stat-val" id="demo-balance-val">5000</span>
      </div>
      <div class="demo-stat-row">
        <span class="demo-stat-label">Total winnings</span>
        <span class="demo-stat-val val-green" id="demo-win-val">0</span>
      </div>
    </div>
    <p class="demo-disclaimer">* This is a demo account. To win real money you'll need to exit demo mode. Demo account balance is updated every 24 hours.</p>
    <button class="btn-exit-demo" id="btn-exit-demo" onclick="toggleDemoMode()">EXIT DEMO MODE</button>
    <button class="btn-collapse-demo" id="btn-collapse-demo" onclick="toggleDemoPanel(false)">Collapse ∨</button>
  </div>

  <!-- Collapsed Demo Mode Trigger Pill -->
  <div class="demo-trigger-pill" id="demo-trigger-pill" style="display: none;" onclick="toggleDemoPanel(true)">
    <span class="demo-status-dot"></span>
    <span>DEMO MODE ∧</span>
  </div>

  <!-- Rules / Paytable Modal -->
  <div class="modal-backdrop" id="rules-modal">
    <div class="modal-box rules-box">
      <button class="modal-close-btn" id="btn-close-rules">
        <img src="modal-close@1x.37d7face8172.png" alt="Close">
      </button>
      <div class="modal-header-title">WESTERN SLOT - PAYTABLE & RULES</div>
      <div class="modal-content-scroll">
        <div class="paytable-grid">
          <!-- Symbol 8: WILD -->
          <div class="paytable-card wild-card">
            <img src="icon-eight-active.a872da2b9449.png" alt="Wild" class="pt-sym">
            <div class="pt-info">
              <h4>GOLDEN STALLION (WILD)</h4>
              <p>Substitutes for all symbols except Jackpot.</p>
              <div class="pt-payouts">
                <span>5x: 5000x</span>
                <span>4x: 1000x</span>
                <span>3x: 200x</span>
                <span>2x: 20x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 9: JACKPOT -->
          <div class="paytable-card jackpot-card">
            <img src="icon-nine.108c5d8b1f0b.png" alt="Jackpot" class="pt-sym">
            <div class="pt-info">
              <h4>JACKPOT CARDS & COINS</h4>
              <p>5 on active payline awards Progressive Grand Jackpot!</p>
              <div class="pt-payouts">
                <span>5x: GRAND JACKPOT</span>
                <span>4x: 500x</span>
                <span>3x: 100x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 7: Bandit Hat -->
          <div class="paytable-card">
            <img src="icon-seven.ce2db4f391cd.png" alt="Bandit" class="pt-sym">
            <div class="pt-info">
              <h4>BANDIT HAT</h4>
              <div class="pt-payouts">
                <span>5x: 1500x</span>
                <span>4x: 400x</span>
                <span>3x: 75x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 3: Sheriff Star -->
          <div class="paytable-card">
            <img src="icon-three.af38e95cacd2.png" alt="Sheriff" class="pt-sym">
            <div class="pt-info">
              <h4>SHERIFF STAR</h4>
              <div class="pt-payouts">
                <span>5x: 1000x</span>
                <span>4x: 250x</span>
                <span>3x: 50x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 6: Money Bag -->
          <div class="paytable-card">
            <img src="icon-six.694a7c422b25.png" alt="Money Bag" class="pt-sym">
            <div class="pt-info">
              <h4>MONEY BAG</h4>
              <div class="pt-payouts">
                <span>5x: 750x</span>
                <span>4x: 150x</span>
                <span>3x: 35x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 2: Dynamite -->
          <div class="paytable-card">
            <img src="icon-two.8078b2bd4712.png" alt="Dynamite" class="pt-sym">
            <div class="pt-info">
              <h4>DYNAMITE</h4>
              <div class="pt-payouts">
                <span>5x: 500x</span>
                <span>4x: 100x</span>
                <span>3x: 25x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 5: Longhorn Skull -->
          <div class="paytable-card">
            <img src="icon-five.407eaf70ce0e.png" alt="Skull" class="pt-sym">
            <div class="pt-info">
              <h4>LONGHORN SKULL</h4>
              <div class="pt-payouts">
                <span>5x: 300x</span>
                <span>4x: 75x</span>
                <span>3x: 20x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 4: Horseshoe -->
          <div class="paytable-card">
            <img src="icon-four.682eece0964c.png" alt="Horseshoe" class="pt-sym">
            <div class="pt-info">
              <h4>SILVER HORSESHOE</h4>
              <div class="pt-payouts">
                <span>5x: 250x</span>
                <span>4x: 50x</span>
                <span>3x: 15x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 1: Wagon -->
          <div class="paytable-card">
            <img src="icon-one.5928412251a7.png" alt="Wagon" class="pt-sym">
            <div class="pt-info">
              <h4>STAGECOACH WAGON</h4>
              <div class="pt-payouts">
                <span>5x: 200x</span>
                <span>4x: 40x</span>
                <span>3x: 10x</span>
              </div>
            </div>
          </div>

          <!-- Symbol 0: Whiskey -->
          <div class="paytable-card">
            <img src="icon-zero.4885140b0230.png" alt="Whiskey" class="pt-sym">
            <div class="pt-info">
              <h4>BOURBON WHISKEY</h4>
              <div class="pt-payouts">
                <span>5x: 150x</span>
                <span>4x: 30x</span>
                <span>3x: 8x</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Combinations / Paylines Modal -->
  <div class="modal-backdrop" id="comb-modal">
    <div class="modal-box comb-box">
      <button class="modal-close-btn" id="btn-close-comb">
        <img src="modal-close@1x.37d7face8172.png" alt="Close">
      </button>
      <div class="modal-header-title">WESTERN SLOT - 9 PAYLINES</div>
      <div class="modal-content-scroll">
        <div class="lines-diagram-grid">
          <div class="line-demo-card" data-line="1">
            <div class="line-title">Line 1 (Center Straight)</div>
            <div class="mini-grid">
              <span></span><span></span><span></span><span></span><span></span>
              <span class="hit"></span><span class="hit"></span><span class="hit"></span><span class="hit"></span><span
                class="hit"></span>
              <span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="2">
            <div class="line-title">Line 2 (Top Straight)</div>
            <div class="mini-grid">
              <span class="hit"></span><span class="hit"></span><span class="hit"></span><span class="hit"></span><span
                class="hit"></span>
              <span></span><span></span><span></span><span></span><span></span>
              <span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="3">
            <div class="line-title">Line 3 (Bottom Straight)</div>
            <div class="mini-grid">
              <span></span><span></span><span></span><span></span><span></span>
              <span></span><span></span><span></span><span></span><span></span>
              <span class="hit"></span><span class="hit"></span><span class="hit"></span><span class="hit"></span><span
                class="hit"></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="4">
            <div class="line-title">Line 4 (V Shape)</div>
            <div class="mini-grid">
              <span class="hit"></span><span></span><span></span><span></span><span class="hit"></span>
              <span></span><span class="hit"></span><span></span><span class="hit"></span><span></span>
              <span></span><span></span><span class="hit"></span><span></span><span></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="5">
            <div class="line-title">Line 5 (Inverted V)</div>
            <div class="mini-grid">
              <span></span><span></span><span class="hit"></span><span></span><span></span>
              <span></span><span class="hit"></span><span></span><span class="hit"></span><span></span>
              <span class="hit"></span><span></span><span></span><span></span><span class="hit"></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="6">
            <div class="line-title">Line 6 (Top Ridge)</div>
            <div class="mini-grid">
              <span class="hit"></span><span class="hit"></span><span></span><span></span><span></span>
              <span></span><span></span><span class="hit"></span><span></span><span></span>
              <span></span><span></span><span></span><span class="hit"></span><span class="hit"></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="7">
            <div class="line-title">Line 7 (Bottom Ridge)</div>
            <div class="mini-grid">
              <span></span><span></span><span></span><span class="hit"></span><span class="hit"></span>
              <span></span><span></span><span class="hit"></span><span></span><span></span>
              <span class="hit"></span><span class="hit"></span><span></span><span></span><span></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="8">
            <div class="line-title">Line 8 (Zigzag Top)</div>
            <div class="mini-grid">
              <span></span><span class="hit"></span><span></span><span class="hit"></span><span></span>
              <span class="hit"></span><span></span><span class="hit"></span><span></span><span class="hit"></span>
              <span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
          <div class="line-demo-card" data-line="9">
            <div class="line-title">Line 9 (Zigzag Bottom)</div>
            <div class="mini-grid">
              <span></span><span></span><span></span><span></span><span></span>
              <span class="hit"></span><span></span><span class="hit"></span><span></span><span class="hit"></span>
              <span></span><span class="hit"></span><span></span><span class="hit"></span><span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="game.js"></script>
</body>

</html>
