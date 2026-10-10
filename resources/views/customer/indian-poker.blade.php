<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
  <meta charset="utf-8">
  <title>Indian Poker - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="description" content="Indian Poker card game with multipliers, 3-card poker hands, progressive jackpot and authentic Indian palace theme.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;900&family=Montserrat:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('indian-poker/assets/css/style.css') }}">
  
  <style>
    * {
      user-select: none;
      -webkit-user-select: none;
      -webkit-user-drag: none;
    }
    img { pointer-events: none; -webkit-user-drag: none; }
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      background: #06040a;
      overflow: hidden !important;
      font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      display: block !important;
    }
    #wrap {
      width: 100vw;
      height: calc(100vh - 70px);
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at center, #15091e 0%, #050208 100%);
    }
    @media (max-width: 768px) {
      #wrap {
        height: calc(100vh - 52px);
      }
    }
  </style>

  <script>
    window.INDIAN_POKER_BASE = "{{ asset('indian-poker') }}/";
    window.IS_AUTH = {{ Auth::check() ? 'true' : 'false' }};
    window.USER_BALANCE = {{ Auth::check() ? (float)(Auth::user()->balance ?? 1000.00) : 1000.00 }};
    window.CSRF_TOKEN = "{{ csrf_token() }}";
  </script>
</head>
<body oncontextmenu="return false;" class="theme-Bettingsite-active {{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

  @include('customer.header')

  <div id="wrap">
    <div id="stage">
      <!-- Breadcrumbs -->
      <div class="a breadcrumb">
        <a href="{{ route('home') }}" class="item" style="color:inherit; text-decoration:underline;">1XGAMES</a> / 
        <a href="{{ route('dashboard') }}" class="item" style="color:inherit; text-decoration:underline;">CARD GAMES</a> / 
        <span class="current" style="color:#d4af37; font-weight:800;">INDIAN POKER</span>
      </div>

      <!-- Balance Box -->
      <div id="bal-box" class="a">
        BALANCE <span id="bal-val">{{ number_format(Auth::check() ? (float)(Auth::user()->balance ?? 1000.00) : 1000.00, 2) }}</span>
      </div>

      <!-- Jackpot Button -->
      <div id="btn-jackpot" class="a jp-btn" title="View Jackpot">
        <span>JACKPOT</span>
      </div>

      <!-- Info Button -->
      <div id="btn-info" class="a info-btn" title="Game Rules & Payouts">i</div>

      <!-- Center Status / Win Message -->
      <div id="msg-wrap" class="a">
        <div id="msg">Place a bet!</div>
      </div>

      <!-- 3-Card Playing Area on Marble Pedestal -->
      <div id="cards-container" class="a">
        <!-- Card Slot 1 -->
        <div class="card-slot" data-index="0">
          <div class="card-inner">
            <div class="card-face back">
              <img src="{{ asset('indian-poker/assets/images/cards/back.svg') }}" alt="Card Back">
            </div>
            <div class="card-face front">
              <img src="{{ asset('indian-poker/assets/images/cards/8D.svg') }}" alt="Card 1">
            </div>
          </div>
        </div>

        <!-- Card Slot 2 -->
        <div class="card-slot" data-index="1">
          <div class="card-inner">
            <div class="card-face back">
              <img src="{{ asset('indian-poker/assets/images/cards/back.svg') }}" alt="Card Back">
            </div>
            <div class="card-face front">
              <img src="{{ asset('indian-poker/assets/images/cards/7C.svg') }}" alt="Card 2">
            </div>
          </div>
        </div>

        <!-- Card Slot 3 -->
        <div class="card-slot" data-index="2">
          <div class="card-inner">
            <div class="card-face back">
              <img src="{{ asset('indian-poker/assets/images/cards/back.svg') }}" alt="Card Back">
            </div>
            <div class="card-face front">
              <img src="{{ asset('indian-poker/assets/images/cards/10C.svg') }}" alt="Card 3">
            </div>
          </div>
        </div>
      </div>

      <!-- Multiplier Badges -->
      <div id="badges-container" class="a">
        <div class="badge-item" data-id="pair">
          <div class="badge-top"><span>x1</span></div>
          <div class="badge-bottom"><span>Pair</span></div>
        </div>
        <div class="badge-item" data-id="flush">
          <div class="badge-top"><span>x5</span></div>
          <div class="badge-bottom"><span>Flush</span></div>
        </div>
        <div class="badge-item" data-id="straight">
          <div class="badge-top"><span>x10</span></div>
          <div class="badge-bottom"><span>Straight</span></div>
        </div>
        <div class="badge-item" data-id="three">
          <div class="badge-top"><span>x50</span></div>
          <div class="badge-bottom"><span>3 of a Kind</span></div>
        </div>
        <div class="badge-item" data-id="sf">
          <div class="badge-top"><span>x75</span></div>
          <div class="badge-bottom"><span>Straight Flush</span></div>
        </div>
      </div>

      <!-- Particle FX Canvas (Rose petals & glows) -->
      <canvas id="fx" class="a"></canvas>

      <!-- Bottom Betting Control Panel -->
      <div id="bottom-controls" class="a">
        <!-- Bet Input Pill -->
        <div id="bet-input-pill">
          <span id="bet-val">10</span>
          <span id="bet-clr" title="Reset Bet">✕</span>
        </div>

        <!-- Quick Bet Chips -->
        <button class="chip-btn" data-val="10">10</button>
        <button class="chip-btn selected" data-val="20">20</button>
        <button class="chip-btn" data-val="50">50</button>
        <button class="chip-btn" data-val="100">100</button>
        <button class="chip-btn" data-val="500">500</button>
        <button class="chip-btn" data-val="1000">1000</button>

        <!-- Action Button -->
        <button id="btn-place-bet">Place a bet</button>
      </div>

      <!-- Right Side Indicators -->
      <div id="demo-badge" class="a demo-badge" title="Demo mode indicator">
        <span class="dot"></span> DEMO MODE &#x2303;
      </div>

      <!-- Interactive Hotspots over Right Toolbar Icons -->
      <div id="right-toolbar" class="a">
        <div id="tool-settings" class="tool-hitbox" title="Settings">⚙</div>
        <div class="tool-hitbox" title="Bonus Gift" onclick="window.location.href='{{ route('dashboard') }}'">🎁</div>
        <div class="tool-hitbox" title="Lucky 7">7</div>
        <div class="tool-hitbox" title="Game Hub" onclick="window.location.href='{{ route('dashboard') }}'">🎲</div>
        <div id="tool-sound" class="tool-hitbox" title="Toggle Sound">🔊</div>
      </div>
      <div id="points-tab-hitbox" class="a" title="Loyalty Points"></div>

      <!-- Rules & Info Modal -->
      <div id="modal-info" class="modal-overlay">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Indian Poker Rules</h3>
            <span class="modal-close">&times;</span>
          </div>
          <div class="modal-body">
            <p>Place your bet and receive 3 cards dealt from a standard 52-card deck. Win payouts for winning hand combinations:</p>
            <table class="payout-table">
              <thead>
                <tr>
                  <th>Combination</th>
                  <th>Description</th>
                  <th style="text-align:right">Payout</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>Straight Flush</strong></td>
                  <td>3 sequential cards of the same suit</td>
                  <td class="mult">x75</td>
                </tr>
                <tr>
                  <td><strong>3 of a Kind</strong></td>
                  <td>3 cards of identical rank</td>
                  <td class="mult">x50</td>
                </tr>
                <tr>
                  <td><strong>Straight</strong></td>
                  <td>3 sequential cards of any suit</td>
                  <td class="mult">x10</td>
                </tr>
                <tr>
                  <td><strong>Flush</strong></td>
                  <td>3 cards of the same suit</td>
                  <td class="mult">x5</td>
                </tr>
                <tr>
                  <td><strong>Pair</strong></td>
                  <td>2 cards of the same rank</td>
                  <td class="mult">x1</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Jackpot Modal -->
      <div id="modal-jackpot" class="modal-overlay">
        <div class="modal-content" style="text-align:center">
          <div class="modal-header">
            <h3 class="modal-title">&#10024; Progressive Jackpot &#10024;</h3>
            <span class="modal-close">&times;</span>
          </div>
          <div class="modal-body">
            <p style="font-size:15px;margin-bottom:12px">Current Grand Jackpot:</p>
            <div style="font-size:32px;font-weight:900;color:#ffd700;font-family:'Cinzel',serif;text-shadow:0 0 15px rgba(255,215,0,0.8)">
              BDT 148,920.55
            </div>
            <p style="margin-top:14px;color:#bbb;font-size:12px">
              Hit a royal Straight Flush (A-K-Q of same suit) on max bet to trigger the Jackpot pool!
            </p>
          </div>
        </div>
      </div>

      <!-- Settings Modal -->
      <div id="modal-settings" class="modal-overlay">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Settings</h3>
            <span class="modal-close">&times;</span>
          </div>
          <div class="modal-body">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #333">
              <span>Sound Effects</span>
              <button id="btn-toggle-sound" style="padding:4px 12px;background:#1a7ec4;color:#fff;border:none;border-radius:4px;cursor:pointer">Enabled</button>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #333">
              <span>Fast Animation Mode</span>
              <button id="btn-toggle-speed" style="padding:4px 12px;background:#333;color:#fff;border:none;border-radius:4px;cursor:pointer">Disabled</button>
            </div>
            <div style="margin-top:14px;text-align:center">
              <button id="btn-reset-demo" style="padding:6px 16px;background:#8a2046;border:1px solid #d4af37;color:#fff;border-radius:4px;cursor:pointer;font-weight:bold">Reset Balance</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('indian-poker/assets/js/engine.js') }}"></script>
  <script src="{{ asset('indian-poker/assets/js/game.js') }}"></script>
  <script>
    // Initialize State balance from Laravel Authenticated User
    if (typeof State !== 'undefined') {
      State.balance = typeof window.USER_BALANCE === 'number' ? window.USER_BALANCE : 1000.00;
      State.bet = 20;
      updateUI();
    }

    // Settings modal interactions
    document.getElementById('btn-toggle-sound')?.addEventListener('click', function() {
      State.soundOn = !State.soundOn;
      AudioFX.enabled = State.soundOn;
      this.textContent = State.soundOn ? 'Enabled' : 'Disabled';
      this.style.background = State.soundOn ? '#1a7ec4' : '#333';
    });

    document.getElementById('btn-toggle-speed')?.addEventListener('click', function() {
      State.fastPlay = !State.fastPlay;
      this.textContent = State.fastPlay ? 'Enabled' : 'Disabled';
      this.style.background = State.fastPlay ? '#1a7ec4' : '#333';
    });

    document.getElementById('btn-reset-demo')?.addEventListener('click', function() {
      State.balance = typeof window.USER_BALANCE === 'number' ? window.USER_BALANCE : 1000.00;
      updateUI();
      document.getElementById('modal-settings').classList.remove('show');
      setMessage('Balance reset');
    });
  </script>
</body>
</html>
