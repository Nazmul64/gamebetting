<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
  <meta charset="utf-8">
  <title>Card Games 21 - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('card-games-21/style.css') }}">
  
  <style>
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      background: #02060b;
      overflow: hidden !important;
      font-family: 'Roboto', 'Outfit', sans-serif;
    }
    #wrap {
      width: 100vw;
      height: calc(100vh - 70px);
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at center, #070e1c 0%, #02060b 100%);
    }
    @media (max-width: 768px) {
      #wrap {
        height: calc(100vh - 52px);
      }
    }
  </style>

  <script>
    window.CARD_GAME_21_BASE = "{{ asset('card-games-21') }}/";
    window.IS_AUTH = {{ Auth::check() ? 'true' : 'false' }};
    window.USER_BALANCE = {{ Auth::check() ? (float)(Auth::user()->balance ?? 5000.00) : 5000.00 }};
    window.CSRF_TOKEN = "{{ csrf_token() }}";
  </script>
</head>
<body class="theme-Bettingsite-active {{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

  @include('customer.header')

  <div id="wrap">
    <div id="stage">
      <!-- Full-bleed background wallpaper -->
      <img id="casino-bg" class="abs" src="{{ asset('card-games-21/casino_bg.jpg') }}" alt="Casino Background">

      <!-- Dynamic Atmospheric Swaying Velvet Curtains Layer -->
      <div id="curtain-anim-layer" class="abs">
        <!-- Left Velvet Curtain -->
        <div class="velvet-curtain velvet-curtain-left">
          <svg class="curtain-svg" viewBox="0 0 240 675" preserveAspectRatio="none">
            <defs>
              <linearGradient id="velvetLeftGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#12041a"/>
                <stop offset="15%" stop-color="#4a1542"/>
                <stop offset="30%" stop-color="#240728"/>
                <stop offset="50%" stop-color="#5a184e"/>
                <stop offset="68%" stop-color="#2a082e"/>
                <stop offset="85%" stop-color="#4d1645"/>
                <stop offset="100%" stop-color="#1c0520"/>
              </linearGradient>
            </defs>
            <path d="M 0,0 L 240,0 C 215,130 165,270 185,385 C 210,490 235,580 220,675 L 0,675 Z" fill="url(#velvetLeftGrad)"/>
            <!-- Pleat shadow lines -->
            <path d="M 45,0 C 40,150 65,350 55,675" stroke="#0d0210" stroke-width="14" opacity="0.65"/>
            <path d="M 110,0 C 100,180 130,380 115,675" stroke="#0d0210" stroke-width="18" opacity="0.6"/>
            <path d="M 175,0 C 155,200 170,420 160,675" stroke="#0d0210" stroke-width="16" opacity="0.55"/>
            <!-- Pleat highlight sheen -->
            <path d="M 30,0 C 25,150 50,350 40,675" stroke="#872973" stroke-width="8" opacity="0.45"/>
            <path d="M 90,0 C 80,180 110,380 95,675" stroke="#872973" stroke-width="10" opacity="0.45"/>
            <path d="M 150,0 C 135,200 150,420 140,675" stroke="#872973" stroke-width="8" opacity="0.4"/>
            <!-- Golden Rope & Tassel -->
            <path d="M 0,380 Q 90,395 185,385" stroke="#ffd700" stroke-width="5" fill="none"/>
            <path d="M 0,384 Q 90,399 185,389" stroke="#b8860b" stroke-width="2" fill="none"/>
            <circle cx="165" cy="388" r="5" fill="#ffd700"/>
            <path d="M 161,393 L 157,430 L 173,430 L 169,393 Z" fill="#ebb434"/>
          </svg>
        </div>

        <!-- Right Velvet Curtain -->
        <div class="velvet-curtain velvet-curtain-right">
          <svg class="curtain-svg" viewBox="0 0 240 675" preserveAspectRatio="none">
            <defs>
              <linearGradient id="velvetRightGrad" x1="100%" y1="0%" x2="0%" y2="0%">
                <stop offset="0%" stop-color="#12041a"/>
                <stop offset="15%" stop-color="#4a1542"/>
                <stop offset="30%" stop-color="#240728"/>
                <stop offset="50%" stop-color="#5a184e"/>
                <stop offset="68%" stop-color="#2a082e"/>
                <stop offset="85%" stop-color="#4d1645"/>
                <stop offset="100%" stop-color="#1c0520"/>
              </linearGradient>
            </defs>
            <path d="M 240,0 L 0,0 C 25,130 75,270 55,385 C 30,490 5,580 20,675 L 240,675 Z" fill="url(#velvetRightGrad)"/>
            <!-- Pleat shadow lines -->
            <path d="M 195,0 C 200,150 175,350 185,675" stroke="#0d0210" stroke-width="14" opacity="0.65"/>
            <path d="M 130,0 C 140,180 110,380 125,675" stroke="#0d0210" stroke-width="18" opacity="0.6"/>
            <path d="M 65,0 C 85,200 70,420 80,675" stroke="#0d0210" stroke-width="16" opacity="0.55"/>
            <!-- Pleat highlight sheen -->
            <path d="M 210,0 C 215,150 190,350 200,675" stroke="#872973" stroke-width="8" opacity="0.45"/>
            <path d="M 150,0 C 160,180 130,380 145,675" stroke="#872973" stroke-width="10" opacity="0.45"/>
            <path d="M 90,0 C 105,200 90,420 100,675" stroke="#872973" stroke-width="8" opacity="0.4"/>
            <!-- Golden Rope & Tassel -->
            <path d="M 240,380 Q 150,395 55,385" stroke="#ffd700" stroke-width="5" fill="none"/>
            <path d="M 240,384 Q 150,399 55,389" stroke="#b8860b" stroke-width="2" fill="none"/>
            <circle cx="75" cy="388" r="5" fill="#ffd700"/>
            <path d="M 71,393 L 67,430 L 83,430 L 79,393 Z" fill="#ebb434"/>
          </svg>
        </div>
      </div>

      <!-- City Night Skyline Twinkle Layer -->
      <div id="city-lights-layer" class="abs">
        <span class="city-twinkle t1"></span>
        <span class="city-twinkle t2"></span>
        <span class="city-twinkle t3"></span>
        <span class="city-twinkle t4"></span>
        <span class="city-twinkle t5"></span>
        <span class="city-twinkle t6"></span>
      </div>

      <!-- Table Lighting / Spotlights -->
      <div id="table-spotlights" class="abs">
        <div class="spotlight spot-left"></div>
        <div class="spotlight spot-right"></div>
      </div>

      <!-- Left Side Interactive Animated Table Scene (Slides in on Load/Refresh) -->
      <div id="left-table-scene">
        <div class="scene-table-assembly">
          <!-- Money Stacks with Light Sweep -->
          <div class="money-bundle-group left-money-pos">
            <div class="money-sheen-sweep"></div>
          </div>

          <!-- Champagne Flute with Sparkling Liquid & Rising Fizz Bubbles -->
          <div class="flute-glass-item left-glass-pos">
            <svg class="flute-svg" viewBox="0 0 50 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="champagneGradLeft" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#fff8cc"/>
                  <stop offset="25%" stop-color="#f5cc4e"/>
                  <stop offset="70%" stop-color="#d49b1e"/>
                  <stop offset="100%" stop-color="#8a5a04"/>
                </linearGradient>
                <linearGradient id="glassGlossLeft" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stop-color="rgba(255,255,255,0.7)"/>
                  <stop offset="35%" stop-color="rgba(255,255,255,0.1)"/>
                  <stop offset="70%" stop-color="rgba(255,255,255,0.05)"/>
                  <stop offset="100%" stop-color="rgba(255,255,255,0.5)"/>
                </linearGradient>
              </defs>
              <!-- Champagne Liquid -->
              <path d="M13,44 C13,44 14,76 18,88 C21,94 25,97 25,97 C25,97 29,94 32,88 C36,76 37,44 37,44 Z" fill="url(#champagneGradLeft)"/>
              <ellipse cx="25" cy="44" rx="12" ry="2.2" fill="#fff7d6" stroke="#ffeaa1" stroke-width="0.8"/>
              <!-- Glass Outline -->
              <path d="M10,12 C10,12 11,76 17,90 C21,98 24,102 24,102 L24,126 L14,134 L14,136 L36,136 L36,134 L26,126 L26,102 C26,102 29,98 33,90 C39,76 40,12 40,12 Z" fill="url(#glassGlossLeft)" stroke="rgba(255,255,255,0.85)" stroke-width="1.2"/>
              <ellipse cx="25" cy="12" rx="15" ry="2.8" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.2"/>
              <path d="M12,18 C12,18 13,68 17,82" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" stroke-linecap="round"/>
              <ellipse cx="25" cy="135" rx="12" ry="3" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="1.2"/>
            </svg>
            <div class="champagne-flute-fx">
              <div class="flute-bubble fb1"></div>
              <div class="flute-bubble fb2"></div>
              <div class="flute-bubble fb3"></div>
              <div class="flute-bubble fb4"></div>
              <div class="flute-bubble fb5"></div>
            </div>
            <div class="scene-glint" style="left:4px; top:-2px;"></div>
          </div>

          <!-- Glass Bowl with Fresh Red Strawberries -->
          <div class="strawberry-bowl-item left-strawberry-pos">
            <svg class="strawberry-bowl-svg" viewBox="0 0 70 65" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="strawberryLeftGrad1" cx="35%" cy="30%" r="65%">
                  <stop offset="0%" stop-color="#ff4757"/>
                  <stop offset="45%" stop-color="#e81123"/>
                  <stop offset="85%" stop-color="#a80010"/>
                  <stop offset="100%" stop-color="#540008"/>
                </radialGradient>
                <radialGradient id="strawberryLeftGrad2" cx="40%" cy="35%" r="60%">
                  <stop offset="0%" stop-color="#ff6b7b"/>
                  <stop offset="50%" stop-color="#d60017"/>
                  <stop offset="100%" stop-color="#69000b"/>
                </radialGradient>
                <linearGradient id="bowlGlassLeft" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0%" stop-color="rgba(255,255,255,0.7)"/>
                  <stop offset="25%" stop-color="rgba(200,235,255,0.2)"/>
                  <stop offset="70%" stop-color="rgba(255,255,255,0.1)"/>
                  <stop offset="100%" stop-color="rgba(255,255,255,0.6)"/>
                </linearGradient>
              </defs>
              <!-- Berry 1 (Back Left) -->
              <path d="M18,24 C14,14 26,10 32,18 C36,24 28,34 22,34 C16,34 16,28 18,24 Z" fill="url(#strawberryLeftGrad2)"/>
              <!-- Berry 2 (Back Right) -->
              <path d="M48,22 C54,12 40,8 35,17 C31,23 38,33 44,33 C49,33 49,27 48,22 Z" fill="url(#strawberryLeftGrad2)"/>
              <!-- Berry 3 (Front Center) -->
              <path d="M35,16 C25,16 22,26 28,36 C32,42 38,42 42,36 C48,26 45,16 35,16 Z" fill="url(#strawberryLeftGrad1)"/>
              <path d="M35,16 L31,11 L34,15 L35,10 L37,15 L40,12 L36,16 Z" fill="#2ed573" stroke="#1b7a41" stroke-width="0.6"/>
              <!-- Seeds -->
              <circle cx="31" cy="24" r="0.8" fill="#ffd32a"/>
              <circle cx="37" cy="23" r="0.8" fill="#ffd32a"/>
              <circle cx="34" cy="29" r="0.8" fill="#ffd32a"/>
              <circle cx="29" cy="32" r="0.8" fill="#ffd32a"/>
              <circle cx="39" cy="31" r="0.8" fill="#ffd32a"/>
              <!-- Loose Berry on Table -->
              <path d="M52,48 C56,42 63,44 64,50 C65,55 58,58 54,56 C50,54 50,50 52,48 Z" fill="url(#strawberryLeftGrad1)"/>
              <path d="M52,48 L49,46 L52,49 L50,51 L53,49 Z" fill="#2ed573"/>
              <!-- Glass Coupe Bowl -->
              <path d="M12,20 C12,38 24,46 32,48 L32,56 L24,60 L24,62 L46,62 L46,60 L38,56 L38,48 C46,46 58,38 58,20 Z" fill="url(#bowlGlassLeft)" stroke="rgba(255,255,255,0.85)" stroke-width="1.3"/>
              <ellipse cx="35" cy="20" rx="23" ry="5.5" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.3"/>
              <path d="M16,24 C17,36 26,42 32,43" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <div class="scene-glint" style="left:12px; top:8px; animation-delay:1.2s;"></div>
            <div class="scene-glint" style="left:32px; top:18px; animation-delay:2.4s;"></div>
          </div>
        </div>
      </div>

      <!-- Right Side Interactive Animated Table Scene (Slides in on Load/Refresh) -->
      <div id="right-table-scene">
        <div class="scene-table-assembly">
          <!-- Glass Bowl with Fresh Red Strawberries -->
          <div class="strawberry-bowl-item right-strawberry-pos">
            <svg class="strawberry-bowl-svg" viewBox="0 0 70 65" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="strawberryRightGrad1" cx="35%" cy="30%" r="65%">
                  <stop offset="0%" stop-color="#ff4757"/>
                  <stop offset="45%" stop-color="#e81123"/>
                  <stop offset="85%" stop-color="#a80010"/>
                  <stop offset="100%" stop-color="#540008"/>
                </radialGradient>
                <radialGradient id="strawberryRightGrad2" cx="40%" cy="35%" r="60%">
                  <stop offset="0%" stop-color="#ff6b7b"/>
                  <stop offset="50%" stop-color="#d60017"/>
                  <stop offset="100%" stop-color="#69000b"/>
                </radialGradient>
                <linearGradient id="bowlGlassRight" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0%" stop-color="rgba(255,255,255,0.7)"/>
                  <stop offset="25%" stop-color="rgba(200,235,255,0.2)"/>
                  <stop offset="70%" stop-color="rgba(255,255,255,0.1)"/>
                  <stop offset="100%" stop-color="rgba(255,255,255,0.6)"/>
                </linearGradient>
              </defs>
              <path d="M18,24 C14,14 26,10 32,18 C36,24 28,34 22,34 C16,34 16,28 18,24 Z" fill="url(#strawberryRightGrad2)"/>
              <path d="M48,22 C54,12 40,8 35,17 C31,23 38,33 44,33 C49,33 49,27 48,22 Z" fill="url(#strawberryRightGrad2)"/>
              <path d="M35,16 C25,16 22,26 28,36 C32,42 38,42 42,36 C48,26 45,16 35,16 Z" fill="url(#strawberryRightGrad1)"/>
              <path d="M35,16 L31,11 L34,15 L35,10 L37,15 L40,12 L36,16 Z" fill="#2ed573" stroke="#1b7a41" stroke-width="0.6"/>
              <circle cx="31" cy="24" r="0.8" fill="#ffd32a"/>
              <circle cx="37" cy="23" r="0.8" fill="#ffd32a"/>
              <circle cx="34" cy="29" r="0.8" fill="#ffd32a"/>
              <circle cx="29" cy="32" r="0.8" fill="#ffd32a"/>
              <circle cx="39" cy="31" r="0.8" fill="#ffd32a"/>
              <path d="M52,48 C56,42 63,44 64,50 C65,55 58,58 54,56 C50,54 50,50 52,48 Z" fill="url(#strawberryRightGrad1)"/>
              <path d="M52,48 L49,46 L52,49 L50,51 L53,49 Z" fill="#2ed573"/>
              <path d="M12,20 C12,38 24,46 32,48 L32,56 L24,60 L24,62 L46,62 L46,60 L38,56 L38,48 C46,46 58,38 58,20 Z" fill="url(#bowlGlassRight)" stroke="rgba(255,255,255,0.85)" stroke-width="1.3"/>
              <ellipse cx="35" cy="20" rx="23" ry="5.5" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.3"/>
              <path d="M16,24 C17,36 26,42 32,43" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <div class="scene-glint" style="left:16px; top:10px; animation-delay:0.7s;"></div>
          </div>

          <!-- Champagne Flute with Sparkling Liquid & Rising Fizz Bubbles -->
          <div class="flute-glass-item right-glass-pos">
            <svg class="flute-svg" viewBox="0 0 50 140" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="champagneGradRight" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#fff8cc"/>
                  <stop offset="25%" stop-color="#f5cc4e"/>
                  <stop offset="70%" stop-color="#d49b1e"/>
                  <stop offset="100%" stop-color="#8a5a04"/>
                </linearGradient>
                <linearGradient id="glassGlossRight" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stop-color="rgba(255,255,255,0.7)"/>
                  <stop offset="35%" stop-color="rgba(255,255,255,0.1)"/>
                  <stop offset="70%" stop-color="rgba(255,255,255,0.05)"/>
                  <stop offset="100%" stop-color="rgba(255,255,255,0.5)"/>
                </linearGradient>
              </defs>
              <path d="M13,44 C13,44 14,76 18,88 C21,94 25,97 25,97 C25,97 29,94 32,88 C36,76 37,44 37,44 Z" fill="url(#champagneGradRight)"/>
              <ellipse cx="25" cy="44" rx="12" ry="2.2" fill="#fff7d6" stroke="#ffeaa1" stroke-width="0.8"/>
              <path d="M10,12 C10,12 11,76 17,90 C21,98 24,102 24,102 L24,126 L14,134 L14,136 L36,136 L36,134 L26,126 L26,102 C26,102 29,98 33,90 C39,76 40,12 40,12 Z" fill="url(#glassGlossRight)" stroke="rgba(255,255,255,0.85)" stroke-width="1.2"/>
              <ellipse cx="25" cy="12" rx="15" ry="2.8" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.2"/>
              <path d="M12,18 C12,18 13,68 17,82" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" stroke-linecap="round"/>
              <ellipse cx="25" cy="135" rx="12" ry="3" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="1.2"/>
            </svg>
            <div class="champagne-flute-fx">
              <div class="flute-bubble fb1"></div>
              <div class="flute-bubble fb2"></div>
              <div class="flute-bubble fb3"></div>
              <div class="flute-bubble fb4"></div>
              <div class="flute-bubble fb5"></div>
            </div>
            <div class="scene-glint" style="left:6px; top:-4px; animation-delay:1.5s;"></div>
          </div>

          <!-- Ice Bucket with Chilled Champagne & Billowing Cold Mist / Smoke -->
          <div class="ice-bucket-item">
            <!-- Multi-layer Cold Smoke / Ice Vapor Rising from Bucket -->
            <div class="ice-vapor-layer">
              <div class="vapor-cloud vc-1"></div>
              <div class="vapor-cloud vc-2"></div>
              <div class="vapor-cloud vc-3"></div>
              <div class="vapor-cloud vc-4"></div>
            </div>
            <div class="scene-glint" style="left:28px; top:12px; animation-delay:1.9s;"></div>
            <div class="scene-glint" style="left:60px; top:28px; animation-delay:0.4s;"></div>
          </div>

          <!-- Money Stacks with Light Sweep -->
          <div class="money-bundle-group right-money-pos">
            <div class="money-sheen-sweep"></div>
          </div>
        </div>
      </div>

      <!-- Top Header Navigation Bar -->
      <div id="top-header" class="abs">
        <div class="breadcrumb">
          <a href="{{ route('home') }}" class="bc-link" style="color:inherit; text-decoration:none;">1XGAMES</a> 
          <span>/</span> 
          <a href="{{ route('dashboard') }}" class="bc-link" style="color:inherit; text-decoration:none;">CARD GAMES</a> 
          <span>/</span> 
          <span style="color:#ffbe1a;">21</span>
        </div>
        <div id="top-banner-pill" class="top-banner-btn">PLACE A BET</div>
        <!-- Right side vertical toolbar -->
        <div class="right-toolbar">
          <div class="tool-btn" title="Settings" onclick="window.location.href='{{ route('dashboard') }}'">⚙</div>
          <div class="tool-btn" title="Gifts">🎁</div>
          <div class="tool-btn" title="Jackpot 7">7</div>
          <div class="tool-btn" title="Casino" onclick="window.location.href='{{ route('dashboard') }}'">🎲</div>
          <div class="tool-btn" title="Balance">$</div>
        </div>
      </div>

      <!-- Interactive Jackpot Header & Dropdown (Top Left) -->
      <div id="jackpot-wrapper" class="abs">
        <div id="jackpot-box" role="button" aria-label="Jackpot"></div>

        <!-- Jackpot Dropdown Popup -->
        <div id="jackpot-dropdown" class="jackpot-dropdown-menu">
          <div class="jp-drop-header"></div>

          <div class="jp-drop-body">
            <!-- Hourly -->
            <div class="jp-row">
              <span class="jp-row-label">HOURLY</span>
              <div class="jp-digits-row" id="jp-hourly-digits"></div>
            </div>

            <!-- Daily -->
            <div class="jp-row">
              <span class="jp-row-label">DAILY</span>
              <div class="jp-digits-row" id="jp-daily-digits"></div>
            </div>

            <!-- Weekly -->
            <div class="jp-row">
              <span class="jp-row-label">WEEKLY</span>
              <div class="jp-digits-row" id="jp-weekly-digits"></div>
            </div>

            <!-- Monthly -->
            <div class="jp-row">
              <span class="jp-row-label">MONTHLY</span>
              <div class="jp-digits-row" id="jp-monthly-digits"></div>
            </div>
          </div>

          <div class="jp-drop-footer">
            <button id="jp-rules-btn" class="jp-rules-btn">RULES</button>
            <div class="jp-currency-badge">BDT</div>
          </div>
        </div>
      </div>

      <!-- 21 Medallion Logo at Top of Table -->
      <div id="table-logo-21" class="abs">
        <div class="logo-cards-fan">
          <div class="mini-card-icon c1"><span class="c-rank">A</span><span class="c-suit">♦</span></div>
          <div class="mini-card-icon c2"><span class="c-rank">A</span><span class="c-suit">♥</span></div>
          <div class="mini-card-icon c3"><span class="c-rank">A</span><span class="c-suit">♣</span></div>
          <div class="mini-card-icon c4"><span class="c-rank">A</span><span class="c-suit">♠</span></div>
        </div>
        <div class="logo-badge-circle">
          <span class="spade-symbol">♠</span>
          <span class="logo-num">21</span>
        </div>
      </div>

      <!-- Emerald Green Blackjack Table Felt Shape Layer -->
      <div id="table-felt-container" class="abs">
        <svg class="table-felt-svg" viewBox="0 0 880 540" preserveAspectRatio="none">
          <defs>
            <radialGradient id="feltGrad" cx="50%" cy="32%" r="58%">
              <stop offset="0%" stop-color="#02a698"/>
              <stop offset="35%" stop-color="#008075"/>
              <stop offset="70%" stop-color="#005750"/>
              <stop offset="95%" stop-color="#002d29"/>
              <stop offset="100%" stop-color="#001a18"/>
            </radialGradient>
            <linearGradient id="feltBorderGrad" x1="0%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%" stop-color="#032624"/>
              <stop offset="50%" stop-color="#004d47"/>
              <stop offset="100%" stop-color="#001413"/>
            </linearGradient>
            <radialGradient id="spotLight1" cx="35%" cy="0%" r="65%">
              <stop offset="0%" stop-color="rgba(190, 255, 245, 0.45)"/>
              <stop offset="35%" stop-color="rgba(0, 220, 200, 0.18)"/>
              <stop offset="75%" stop-color="rgba(0, 0, 0, 0)"/>
            </radialGradient>
            <radialGradient id="spotLight2" cx="65%" cy="0%" r="65%">
              <stop offset="0%" stop-color="rgba(190, 255, 245, 0.45)"/>
              <stop offset="35%" stop-color="rgba(0, 220, 200, 0.18)"/>
              <stop offset="75%" stop-color="rgba(0, 0, 0, 0)"/>
            </radialGradient>
            <filter id="tableShadow" x="-10%" y="-10%" width="120%" height="120%">
              <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="#000" flood-opacity="0.9"/>
            </filter>
          </defs>

          <!-- Outer Rim / Bevel -->
          <path d="M 28,14 L 350,14 C 388,14 402,82 440,82 C 478,82 492,14 530,14 L 852,14 C 872,14 876,28 870,55 L 818,440 C 795,508 730,528 650,528 L 230,528 C 150,528 85,508 62,440 L 10,55 C 4,28 8,14 28,14 Z"
                fill="url(#feltBorderGrad)"
                stroke="#00f2e2"
                stroke-width="1.5"
                stroke-opacity="0.3"
                filter="url(#tableShadow)"/>

          <!-- Main Felt Surface -->
          <path d="M 32,20 L 350,20 C 390,20 404,86 440,86 C 476,86 490,20 530,20 L 848,20 C 864,20 868,32 862,56 L 812,436 C 790,502 728,520 648,520 L 232,520 C 152,520 90,502 68,436 L 18,56 C 12,32 16,20 32,20 Z"
                fill="url(#feltGrad)"/>

          <!-- Dual Spotlights Over Felt -->
          <path d="M 32,20 L 350,20 C 390,20 404,86 440,86 C 476,86 490,20 530,20 L 848,20 C 864,20 868,32 862,56 L 812,436 C 790,502 728,520 648,520 L 232,520 C 152,520 90,502 68,436 L 18,56 C 12,32 16,20 32,20 Z"
                fill="url(#spotLight1)"/>
          <path d="M 32,20 L 350,20 C 390,20 404,86 440,86 C 476,86 490,20 530,20 L 848,20 C 864,20 868,32 862,56 L 812,436 C 790,502 728,520 648,520 L 232,520 C 152,520 90,502 68,436 L 18,56 C 12,32 16,20 32,20 Z"
                fill="url(#spotLight2)"/>
        </svg>
      </div>

      <!-- Left Side Table Stats (Dealer & Player Scores) -->
      <div id="table-left-panel" class="abs">
        <div class="table-lbl">DEALER</div>
        <div id="dealer-score" class="score-box">0</div>

        <div class="stats-badges-group">
          <div class="stat-item">
            <span class="stat-title">WINS</span>
            <div id="stat-wins" class="stat-pill-badge">0</div>
          </div>
          <div class="stat-item">
            <span class="stat-title">LOSSES</span>
            <div id="stat-losses" class="stat-pill-badge">0</div>
          </div>
          <div class="stat-item">
            <span class="stat-title">DRAWS</span>
            <div id="stat-draws" class="stat-pill-badge">0</div>
          </div>
        </div>

        <div class="you-section">
          <div class="table-lbl">YOU</div>
          <div id="player-score" class="score-box">0</div>
        </div>
      </div>

      <!-- Table Center Dividing Line -->
      <div class="table-center-divider abs"></div>

      <!-- Cards Area -->
      <div id="dealer-cards" class="cards-row abs"></div>
      <div id="player-cards" class="cards-row abs"></div>

      <!-- Right Side Table Deck & Tools -->
      <div id="deck-section" class="abs">
        <div class="card-deck-box">
          <div class="deck-shadow-layer"></div>
          <div class="deck-card-top">
            <div class="deck-card-inner"></div>
          </div>
        </div>
        <div class="deck-tools-stack">
          <button id="btn-history" class="deck-tool-btn" title="History">↺</button>
          <button id="btn-help" class="deck-tool-btn" title="Help">?</button>
          <button id="btn-sound" class="deck-tool-btn" title="Sound">🔊</button>
        </div>
      </div>

      <!-- Result Banner Overlay -->
      <div id="result-banner-overlay" class="abs hidden">
        <div id="result-banner-bg" class="result-banner-bg lose">
          <div id="result-main-title" class="result-main-title">BETTER LUCK NEXT TIME</div>
          <div id="result-sub-title" class="result-sub-title">Dealer has more points</div>
        </div>
      </div>

      <!-- Bottom Controls Panel Frame & Buttons -->
      <div id="controls-frame-container" class="abs">
        <!-- Ornate Golden Frame Overlay -->
        <img class="controls-border-img" src="{{ asset('card-games-21/21-controls-border@1x.1508ae7c8d0a.png') }}" alt="Controls Frame">

        <!-- Main Action Button (PLACE A BET / HIT) -->
        <div class="main-btn-container">
          <div class="main-btn-shadow"></div>
          <button id="main-action-btn" class="main-action-btn bet-mode" aria-label="Main Action">
            <span class="main-btn-text">PLACE A BET</span>
          </button>
        </div>

        <!-- Secondary Controls Row (STAND / AUTOPLAY + Bet Box) -->
        <div class="sub-controls-row">
          <button id="sub-action-btn" class="sub-action-btn autoplay-mode" aria-label="Sub Action">
            <span class="sub-btn-text">AUTOPLAY</span>
          </button>

          <div id="bet-input-box" class="bet-input-box">
            <span id="bet-val-text" class="bet-val-text">20</span>
            <button id="bet-clear-btn" class="bet-clear-btn" title="Clear Bet">✕</button>
          </div>
        </div>

        <!-- Preset Chips Row (20, 100, 300, 800, 3000, 10000) -->
        <div class="preset-chips-row">
          <button class="preset-chip-btn" data-val="20">20</button>
          <button class="preset-chip-btn" data-val="100">100</button>
          <button class="preset-chip-btn" data-val="300">300</button>
          <button class="preset-chip-btn" data-val="800">800</button>
          <button class="preset-chip-btn" data-val="3000">3000</button>
          <button class="preset-chip-btn" data-val="10000">10000</button>
        </div>
      </div>

      <!-- Demo Mode Badge (Bottom Right) -->
      <div id="demo-mode-badge" class="abs" onclick="toggleCabinet(false)">
        <span class="yellow-dot">●</span> DEMO MODE <span class="arrow-up">︽</span>
      </div>

      <!-- Live Support Headphone Icon (Bottom Right Corner) -->
      <div id="live-support-btn" class="abs" title="Live Support" onclick="if(typeof openChatWithUser === 'function') openChatWithUser()">
        <svg viewBox="0 0 24 24" class="support-icon">
          <path fill="currentColor" d="M12 3a9 9 0 0 0-9 9v7c0 1.1.9 2 2 2h3a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5v-2a7 7 0 0 1 14 0v2h-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h3c1.1 0 2-.9 2-2v-7a9 9 0 0 0-9-9z"/>
        </svg>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('card-games-21/assets/js/engine.js') }}"></script>
  <script src="{{ asset('card-games-21/assets/js/game.js') }}"></script>
</body>
</html>
