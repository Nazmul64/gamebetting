<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>Crystal™ - 1xBet Realistic Cascading Slot</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('crystal/css/styles.css') }}">
  <style>
    body {
      overflow-y: auto !important;
      overflow-x: hidden !important;
    }
    #game-wrapper {
      height: calc(100vh - 70px) !important;
      min-height: 600px;
    }
  </style>
  <script>
    window.BURNING_HOT_BASE = "{{ asset('crystal') }}/";
    window.IS_AUTH = {{ Auth::check() ? 'true' : 'false' }};
    window.USER_BALANCE = {{ Auth::check() ? (float)(Auth::user()->balance ?? 10000.00) : 10000.00 }};
    window.CSRF_TOKEN = "{{ csrf_token() }}";
  </script>
  <script src="{{ asset('crystal/js/lib/pixi.min.js') }}"></script>
  <script>
    window.require = function(mod) {
      if (typeof PIXI !== 'undefined') return PIXI;
      return window[mod] || {};
    };
  </script>
  <script src="{{ asset('crystal/js/lib/pixi-spine.js') }}"></script>
  <script src="{{ asset('crystal/js/lib/gsap.min.js') }}"></script>
  <script src="{{ asset('crystal/js/lib/PixiPlugin.min.js') }}"></script>
  <script src="{{ asset('crystal/js/lib/howler.min.js') }}"></script>
</head>
<body>

  @include('customer.header')

  <div id="game-wrapper">
    <div id="game-canvas-container">
      <canvas id="game-canvas" width="1920" height="1080"></canvas>

      <!-- Top Breadcrumb Navigation -->
      <div id="top-breadcrumbs">
        <a href="{{ route('home') }}" class="bc-link">1XGAMES</a>
        <span class="bc-sep">/</span>
        <a href="{{ route('dashboard') }}" class="bc-link">SLOTS</a>
        <span class="bc-sep">/</span>
        <span class="bc-current">CRYSTAL</span>
      </div>

      <!-- Top-Right Interactive Jackpot Dropdown Widget -->
      <div id="jackpot-widget">
        <div class="jackpot-header-btn" onclick="toggleJackpotDropdown()">
          <span class="jackpot-header-title">JACKPOT</span>
        </div>
        <div class="jackpot-dropdown-panel" id="jackpot-dropdown">
          <div class="jackpot-row">
            <span>HOURLY</span>
            <div class="jackpot-digits-wrap" id="digits-hourly">
              <span class="jackpot-digit">7</span>
              <span class="jackpot-digit">0</span>
              <span class="jackpot-digit">7</span>
            </div>
          </div>
          <div class="jackpot-row">
            <span>DAILY</span>
            <div class="jackpot-digits-wrap" id="digits-daily">
              <span class="jackpot-digit">1</span>
              <span class="jackpot-digit">6</span>
              <span class="jackpot-digit">5</span>
              <span class="jackpot-digit">5</span>
              <span class="jackpot-digit">4</span>
              <span class="jackpot-digit">4</span>
              <span class="jackpot-digit">2</span>
            </div>
          </div>
          <div class="jackpot-row">
            <span>WEEKLY</span>
            <div class="jackpot-digits-wrap" id="digits-weekly">
              <span class="jackpot-digit">1</span>
              <span class="jackpot-digit">9</span>
              <span class="jackpot-digit">9</span>
              <span class="jackpot-digit">8</span>
              <span class="jackpot-digit">0</span>
              <span class="jackpot-digit">7</span>
              <span class="jackpot-digit">3</span>
              <span class="jackpot-digit">1</span>
            </div>
          </div>
          <div class="jackpot-row">
            <span>MONTHLY</span>
            <div class="jackpot-digits-wrap" id="digits-monthly">
              <span class="jackpot-digit">5</span>
              <span class="jackpot-digit">9</span>
              <span class="jackpot-digit">6</span>
              <span class="jackpot-digit">9</span>
              <span class="jackpot-digit">4</span>
              <span class="jackpot-digit">6</span>
              <span class="jackpot-digit">4</span>
              <span class="jackpot-digit">3</span>
            </div>
          </div>
          <div class="jackpot-bottom-bar">
            <button class="jackpot-rules-btn" onclick="openModal()">RULES</button>
            <span class="jackpot-currency-tag">BDT</span>
          </div>
        </div>
      </div>

      <!-- Bottom-Right Demo Mode Drawer Widget -->
      <div id="demo-widget">
        <!-- Collapsed Pill Button -->
        <div class="demo-pill-btn" id="demo-pill" onclick="openDemoDrawer()">
          <span class="demo-pill-dot"></span>
          <span class="demo-pill-label">DEMO MODE</span>
          <span class="demo-pill-chevron">&#9650;</span>
        </div>

        <!-- Expanded Drawer Panel -->
        <div class="demo-drawer-panel" id="demo-drawer">
          <div class="demo-drawer-header">
            <div class="demo-drawer-title-wrap">
              <span class="demo-drawer-dot"></span>
              <span class="demo-drawer-title">DEMO MODE</span>
            </div>
            <div class="demo-drawer-close-btn" onclick="closeDemoDrawer()">&times;</div>
          </div>
          <div class="demo-drawer-card">
            <span class="demo-drawer-lbl">DEMO BALANCE</span>
            <span class="demo-drawer-val" id="demo-card-balance">10,000.00 BDT</span>
            <div class="demo-quick-amounts">
              <button class="demo-amt-btn" onclick="selectBalanceOption(1000)">1K</button>
              <button class="demo-amt-btn" onclick="selectBalanceOption(5000)">5K</button>
              <button class="demo-amt-btn active" onclick="selectBalanceOption(10000)">10K</button>
              <button class="demo-amt-btn" onclick="selectBalanceOption(50000)">50K</button>
            </div>
          </div>
          <div class="demo-drawer-card">
            <span class="demo-drawer-lbl">ROUND WINNINGS</span>
            <span class="demo-drawer-val" id="demo-card-winnings">0.00 BDT</span>
          </div>
          <p class="demo-drawer-desc">
            Demo mode lets you get to grips with a game using a demo account. Demo account balance is updated every 24 hours.
          </p>
          <button class="demo-btn-enable" onclick="selectBalanceOption(10000)">RESET DEMO BALANCE</button>
          <button class="demo-btn-collapse" onclick="closeDemoDrawer()">EXIT DEMO MODE &rarr;</button>
        </div>
      </div>

      <!-- Loader Screen -->
      <div id="loading-overlay">
        <div class="loader-title">CRYSTAL</div>
        <div class="loader-bar-bg">
          <div class="loader-bar-fill" id="loader-fill"></div>
        </div>
        <div class="loader-status" id="loader-text">Loading Royal Treasury & Crystals (0%)...</div>
      </div>
    </div>
  </div>

  <!-- Mobile Portrait Rotate Advisory Overlay -->
  <div id="rotate-device-overlay">
    <div class="rotate-phone-container">
      <div class="rotate-phone-glow"></div>
      <div class="rotate-phone-icon">&#128241;</div>
      <div class="rotate-arrow-anim">&#10530;</div>
    </div>
    <div class="rotate-text-title">ROTATE YOUR DEVICE</div>
    <div class="rotate-text-sub">For the best full-screen slot experience, please rotate your screen to Landscape.</div>
    <button class="rotate-dismiss-btn" onclick="dismissRotateNotice()">CONTINUE IN PORTRAIT</button>
  </div>

  <!-- Authentic 1xBet Crystal Rules Modal -->
  <div id="info-modal" onclick="if(event.target === this) closeModal()">
    <div class="rules-board-wrapper">
      <div class="rules-close-btn" onclick="closeModal()" title="Close Rules">&times;</div>
      <h2 class="rules-title">CRYSTAL RULES</h2>
      <div class="rules-content-scroll">
        <p class="rules-item"><b>1.</b> The game screen shows crystals of different colors on a 7x7 grid.</p>
        <p class="rules-item"><b>2.</b> To win the game, get 5 or more matching symbols of the same color adjacent to one another in any direction (horizontally and/or vertically).</p>
        <p class="rules-item"><b>3.</b> The <b>"Wild symbol" (Golden Crown)</b> acts as a missing crystal in a winning combination.</p>
        <p class="rules-item"><b>4.</b> When a winning combination forms, the winning crystals explode, payout is awarded according to the multiplier list, and new crystals tumble down into empty positions.</p>
        <p class="rules-item"><b>5.</b> Winnings from multiple combinations of crystals of the same color which are not adjacent to each other are not accumulated.</p>
        <p class="rules-item"><b>6.</b> Cascading avalanche continues as long as new winning clusters appear.</p>
      </div>
    </div>
  </div>

  <script src="{{ asset('crystal/js/audio.js') }}"></script>
  <script src="{{ asset('crystal/js/rules.js') }}"></script>
  <script src="{{ asset('crystal/js/game.js') }}"></script>
</body>
</html>
