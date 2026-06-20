<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Dashboard - Aviator</title>
    <!-- Google Fonts for premium typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body class="landing-body theme-1xbet-active {{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

    <!-- 1xBet Styled Header Navigation Bar -->
    <nav class="dashboard-header-nav" style="background: #0c1a30; border-bottom: 1.5px solid #1d3354; height: 70px;">
        <div class="dashboard-nav-logo" style="display: flex; align-items: center; gap: 8px;">
            <span class="logo-text" style="font-style: italic; font-weight: 900; font-size: 24px; letter-spacing: -0.5px; color: #1a76d2; text-shadow: 0 0 10px rgba(26, 118, 210, 0.3);">
                <span style="color: #ffffff;">1X</span>BET
            </span>
        </div>
        
        <ul class="dashboard-nav-links" style="display: flex; list-style: none; gap: 20px; font-size: 13px; font-weight: 700; margin: 0; padding: 0;">
            <li><a href="{{ route('home') }}" style="color: #8ca3c7; text-decoration: none;">TOP-EVENTS</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LEAGUE OF WINS</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">T20 BLAST</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">CRICKET</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">SPORTS</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LIVE</a></li>
            <li><a href="#" onclick="launchDroneGame(event)" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-plane-departure" style="font-size:12px; margin-right:4px;"></i> 1XGAMES</a></li>
            <li><a href="#" onclick="toggleCabinet(false); return false;" class="active" style="color: #ffffff; text-decoration: none; border-bottom: 3px solid #007bff; padding-bottom: 6px;">CASINO</a></li>
            <li><a href="{{ route('gems-mines') }}" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-gem" style="font-size:12px; margin-right:4px;"></i> Gems & Mines</a></li>
            <li><a href="{{ route('big-bass-splash') }}" style="color: #38ef7d; text-decoration: none;"><i class="fas fa-fish" style="font-size:12px; margin-right:4px;"></i> Big Bass Splash</a></li>
            <li><a href="#" style="color: #8ca3c7; text-decoration: none;">MORE <i class="fas fa-chevron-down" style="font-size: 9px; margin-left: 2px;"></i></a></li>
        </ul>
        
        <div class="dashboard-nav-actions" style="display: flex; align-items: center; gap: 12px;">
            <!-- Header Balance Display -->
            <div class="balance-container" style="background: #112038; border: 1.5px solid #1d3354; border-radius: 6px; padding: 0 14px; height: 38px; display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <span class="balance-label" style="font-size: 10px; color: #8ca3c7; letter-spacing: 0.5px;">BALANCE:</span>
                <span class="balance-value header-balance-value" style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-size: 15px;">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                <span class="balance-currency" style="color: #ffffff; font-size: 11px;">{{ auth()->user()->currency }}</span>
            </div>

            <!-- Header Action Buttons -->
            <button onclick="openModal('deposit-modal')" class="nav-btn-deposit" style="background: #2ebd59; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(46, 189, 89, 0.2);">
                <i class="fas fa-plus-circle"></i> DEPOSIT
            </button>
            <button onclick="openModal('withdraw-modal')" class="nav-btn-withdraw" style="background: #007bff; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);">
                <i class="fas fa-arrow-alt-circle-up"></i> WITHDRAW
            </button>

            <!-- Cabinet & Logout Actions -->
            <div style="position: relative; display: inline-block;">
                <button onclick="toggleCabinet(true)" class="nav-btn-cabinet" style="background: #15253e; color: #ffffff; border: 1.5px solid #1d3354; padding: 0 14px; height: 38px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;">
                    <i class="fas fa-user-circle" style="font-size:14px; color:#8ca3c7;"></i> CABINET
                </button>
            </div>

            <a href="#" onclick="handleLogout(event)" class="nav-btn-logout" style="width: 38px; height: 38px; border-radius: 6px; background: rgba(235, 64, 52, 0.1); border: 1px solid rgba(235, 64, 52, 0.3); color: #ff5447; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none; transition: all 0.2s;" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <!-- Main Workspace with 1xBet Style Layout -->
    <div class="lobby-wrapper">
        
        <!-- Left Sidebar Icons list -->
        <aside class="lobby-sidebar">
            <button class="sidebar-icon-btn active" onclick="toggleCabinet(false); return false;" title="Slots Lobby">
                <i class="fas fa-gamepad"></i>
            </button>
            <button class="sidebar-icon-btn" onclick="toggleCabinet(true); switchDashboardTab('tab-bets', document.querySelectorAll('.dashboard-tab-trigger')[1]); return false;" title="My Bets">
                <i class="fas fa-history"></i>
            </button>
            <button class="sidebar-icon-btn" onclick="toggleCabinet(true); switchDashboardTab('tab-transfer', document.querySelectorAll('.dashboard-tab-trigger')[4]); return false;" title="Transfer Balance">
                <i class="fas fa-paper-plane"></i>
            </button>
            <button class="sidebar-icon-btn" onclick="toggleCabinet(true); switchDashboardTab('tab-levels', document.querySelectorAll('.dashboard-tab-trigger')[3]); return false;" title="VIP Level Status">
                <i class="fas fa-trophy"></i>
            </button>
            <button class="sidebar-icon-btn" onclick="toggleCabinet(true); switchDashboardTab('tab-referral', document.querySelectorAll('.dashboard-tab-trigger')[5]); return false;" title="Referral Affiliate">
                <i class="fas fa-users"></i>
            </button>
            <button class="sidebar-icon-btn" onclick="toggleCabinet(true); switchDashboardTab('tab-profile', document.querySelectorAll('.dashboard-tab-trigger')[6]); return false;" title="Profile Settings">
                <i class="fas fa-user-cog"></i>
            </button>
        </aside>

        <!-- Main Lobby Content: Casino Slots (Visible by default) -->
        <main class="lobby-main" id="casino-lobby-section">
            
            <!-- Breadcrumbs and Search Row -->
            <div class="lobby-top-row">
                <div class="lobby-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="#" onclick="toggleCabinet(false); return false;">Slots</a>
                    <span>/</span>
                    <span class="active-crumb">Popular</span>
                </div>

                <!-- Live Search filtration field -->
                <div class="lobby-search-container">
                    <i class="fas fa-search lobby-search-icon"></i>
                    <input type="text" id="lobby-search-box" class="lobby-search-input" placeholder="Search slots or providers..." onkeyup="filterLobbyGames()">
                </div>
            </div>

            <!-- Promotion Slider Banner -->
            <div class="lobby-banner-slider">
                <!-- Slide 1: SpinoLeague -->
                <div class="banner-slide slide-active" id="slide-0">
                    <div class="banner-slide-bg" style="background-image: linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%), url('https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?q=80&w=1200&auto=format&fit=crop');"></div>
                    <div class="banner-content">
                        <span class="banner-date">05.03.2026 - 01.03.2027</span>
                        <h2 class="banner-title">SPINOLEAGUE TOURNAMENT</h2>
                        <p class="banner-prize">STAND BY THE CHAMPIONS | PRIZE POOL: <span>€12,000,000</span></p>
                        <button onclick="launchDroneGame(event)" class="banner-play-btn">PLAY NOW</button>
                    </div>
                </div>

                <!-- Slide 2: Playcognito -->
                <div class="banner-slide" id="slide-1">
                    <div class="banner-slide-bg" style="background-image: linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%), url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200&auto=format&fit=crop');"></div>
                    <div class="banner-content">
                        <span class="banner-date">Exclusive Release</span>
                        <h2 class="banner-title">NEW PROVIDER LAUNCH</h2>
                        <p class="banner-prize">EXPERIENCE THE THRILL OF <span>PLAYCOGNITO</span> SLOTS</p>
                        <button onclick="launchDroneGame(event)" class="banner-play-btn">PLAY NOW</button>
                    </div>
                </div>

                <!-- Slide 3: Golden Dragon -->
                <div class="banner-slide" id="slide-2">
                    <div class="banner-slide-bg" style="background-image: linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%), url('https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=1200&auto=format&fit=crop');"></div>
                    <div class="banner-content">
                        <span class="banner-date">Limited Time Only</span>
                        <h2 class="banner-title">GOLDEN DRAGON CHALLENGE</h2>
                        <p class="banner-prize">MULTIPLY YOUR WINNINGS UP TO <span>500,000 BDT</span></p>
                        <button onclick="launchDroneGame(event)" class="banner-play-btn">PLAY NOW</button>
                    </div>
                </div>

                <!-- Arrows -->
                <button class="slider-arrow arrow-left" onclick="moveSlide(-1)"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-arrow arrow-right" onclick="moveSlide(1)"><i class="fas fa-chevron-right"></i></button>

                <!-- Dots navigation -->
                <div class="slide-dots">
                    <span class="slide-dot active" onclick="setSlide(0)"></span>
                    <span class="slide-dot" onclick="setSlide(1)"></span>
                    <span class="slide-dot" onclick="setSlide(2)"></span>
                </div>
            </div>

            <!-- Categories Horizontal Filter Navbar -->
            <div class="lobby-categories-navbar">
                <button class="lobby-category-btn active" onclick="filterCategory('all', this)"><i class="fas fa-fire"></i> Popular</button>
                <button class="lobby-category-btn" onclick="filterCategory('quick', this)"><i class="fas fa-bolt"></i> Quick Play</button>
                <button class="lobby-category-btn" onclick="filterCategory('chicken', this)"><i class="fas fa-egg"></i> Chicken Profit</button>
                <button class="lobby-category-btn" onclick="filterCategory('new', this)"><i class="fas fa-star-of-david"></i> New</button>
                <button class="lobby-category-btn" onclick="filterCategory('bangladesh', this)"><i class="fas fa-flag"></i> Best Games In Bangladesh</button>
                <button class="lobby-category-btn" onclick="filterCategory('exclusive', this)"><i class="fas fa-crown"></i> Exclusive</button>
                <button class="lobby-category-btn" onclick="filterCategory('bonus', this)"><i class="fas fa-gift"></i> Bonus Wagering</button>
                <button class="lobby-category-btn" onclick="filterCategory('all', this)"><i class="fas fa-th"></i> All</button>
            </div>

            <!-- Slots Grid Section -->
            <div class="slots-grid" id="slots-grid-list">

                <!-- Game 1: 1xaero -->
                <div class="slot-card" data-category="exclusive quick bangladesh" data-name="1xaero 1xgames exclusive">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/1xaero.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane-departure" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">1xaero</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="launchDroneGame(event)"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="launchDroneGame(event); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">1xaero</div>
                    </div>
                </div>

                <!-- Game 2: 20 Extra Crown -->
                <div class="slot-card" data-category="quick new" data-name="20 extra crown amusnet interactive">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/20 Extra Crown.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-crown" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">20 Extra Crown</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('20 Extra Crown')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('20 Extra Crown'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">20 Extra Crown</div>
                    </div>
                </div>

                <!-- Game 3: 3superacc -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="3superacc egt">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/3superacc.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">3superacc</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('3superacc')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('3superacc'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">3superacc</div>
                    </div>
                </div>

                <!-- Game 4: 40 Shining Crown Bell Link -->
                <div class="slot-card" data-category="new exclusive" data-name="40 shining crown bell link jili">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/40 Shining Crown Bell Link.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-crown" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">40 Shining Crown Bell Link</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('40 Shining Crown Bell Link')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('40 Shining Crown Bell Link'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">40 Shining Crown Bell Link</div>
                    </div>
                </div>

                <!-- Game 5: 9 Masks of Voodoo -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="9 masks of voodoo netent">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/9 Masks of Voodoo.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-wand-magic-sparkles" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">9 Masks of Voodoo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('9 Masks of Voodoo')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('9 Masks of Voodoo'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">9 Masks of Voodoo</div>
                    </div>
                </div>

                <!-- Game 6: Abyss of Glory -->
                <div class="slot-card" data-category="exclusive popular" data-name="abyss of glory spinomenal">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Abyss of Glory.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-award" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Abyss of Glory</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Abyss of Glory')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Abyss of Glory'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">Abyss of Glory</div>
                    </div>
                </div>

                <!-- Game 7: Aero -->
                <div class="slot-card" data-category="exclusive quick bangladesh" data-name="aero 1xgames exclusive">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Aero.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane-departure" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Aero</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="launchDroneGame(event)"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="launchDroneGame(event); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">Aero</div>
                    </div>
                </div>

                <!-- Game 8: All Ways Hot Fruits -->
                <div class="slot-card" data-category="popular chicken" data-name="all ways hot fruits playson">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/All Ways Hot Fruits.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-leaf" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">All Ways Hot Fruits</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('All Ways Hot Fruits')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('All Ways Hot Fruits'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">All Ways Hot Fruits</div>
                    </div>
                </div>

                <!-- Game 9: Angry Birds -->
                <div class="slot-card" data-category="quick new" data-name="angry birds evoplay">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Angry Birds.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Angry Birds</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Angry Birds')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Angry Birds'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">Angry Birds</div>
                    </div>
                </div>

                <!-- Game 10: BaBayiagatales -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="babayiagatales betsoft">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/BaBayiagatales.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">BaBayiagatales</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('BaBayiagatales')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('BaBayiagatales'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">BaBayiagatales</div>
                    </div>
                </div>

                <!-- Game 11: Bazaarhold&wun -->
                <div class="slot-card" data-category="new exclusive" data-name="bazaarhold&wun smartsoft gaming">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Bazaarhold&wun.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Bazaarhold&wun</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Bazaarhold&wun')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Bazaarhold&wun'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">Bazaarhold&wun</div>
                    </div>
                </div>

                <!-- Game 12: Best Gold Miner -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="best gold miner fazi">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Best Gold Miner.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Best Gold Miner</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Best Gold Miner')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Best Gold Miner'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">Best Gold Miner</div>
                    </div>
                </div>

                <!-- Game 13: Bonsai Spins -->
                <div class="slot-card" data-category="exclusive popular" data-name="bonsai spins pg soft">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Bonsai Spins.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Bonsai Spins</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Bonsai Spins')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Bonsai Spins'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">Bonsai Spins</div>
                    </div>
                </div>

                <!-- Game 14: Book of Sheba -->
                <div class="slot-card" data-category="bonus quick" data-name="book of sheba pragmatic play">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Book of Sheba.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Book of Sheba</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Book of Sheba')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Book of Sheba'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Book of Sheba</div>
                    </div>
                </div>

                <!-- Game 15: Buffalo Goes Wild -->
                <div class="slot-card" data-category="popular chicken" data-name="buffalo goes wild amusnet interactive">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Buffalo Goes Wild.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Buffalo Goes Wild</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Buffalo Goes Wild')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Buffalo Goes Wild'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">Buffalo Goes Wild</div>
                    </div>
                </div>

                <!-- Game 16: Burning Eye -->
                <div class="slot-card" data-category="quick new" data-name="burning eye egt">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Burning Eye.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Burning Eye</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Burning Eye')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Burning Eye'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">Burning Eye</div>
                    </div>
                </div>

                <!-- Game 17: Burning Hot Clover Chance -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="burning hot clover chance jili">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Burning Hot Clover Chance.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-leaf" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Burning Hot Clover Chance</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Burning Hot Clover Chance')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Burning Hot Clover Chance'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">Burning Hot Clover Chance</div>
                    </div>
                </div>

                <!-- Game 18: Burning Slots 100 -->
                <div class="slot-card" data-category="new exclusive" data-name="burning slots 100 netent">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Burning Slots 100.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Burning Slots 100</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Burning Slots 100')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Burning Slots 100'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">Burning Slots 100</div>
                    </div>
                </div>

                <!-- Game 19: Cabaretroyialeholdandearyi -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="cabaretroyialeholdandearyi spinomenal">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Cabaretroyialeholdandearyi.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Cabaretroyialeholdandearyi</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Cabaretroyialeholdandearyi')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Cabaretroyialeholdandearyi'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">Cabaretroyialeholdandearyi</div>
                    </div>
                </div>

                <!-- Game 20: Catch 'n Cash -->
                <div class="slot-card" data-category="exclusive popular" data-name="catch 'n cash hacksaw gaming">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Catch 'n Cash.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Catch 'n Cash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Catch \'n Cash')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Catch \'n Cash'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">Catch 'n Cash</div>
                    </div>
                </div>

                <!-- Game 21: Chickenroad -->
                <div class="slot-card" data-category="bonus quick" data-name="chickenroad playson">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Chickenroad.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Chickenroad</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Chickenroad')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Chickenroad'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">Chickenroad</div>
                    </div>
                </div>

                <!-- Game 22: Clover Coin Combo -->
                <div class="slot-card" data-category="popular chicken" data-name="clover coin combo evoplay">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Clover Coin Combo.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Clover Coin Combo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Clover Coin Combo')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Clover Coin Combo'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">Clover Coin Combo</div>
                    </div>
                </div>

                <!-- Game 23: CoinSpin Fever -->
                <div class="slot-card" data-category="quick new" data-name="coinspin fever betsoft">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/CoinSpin Fever.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">CoinSpin Fever</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('CoinSpin Fever')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('CoinSpin Fever'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">CoinSpin Fever</div>
                    </div>
                </div>

                <!-- Game 24: CrashX -->
                <div class="slot-card" data-category="exclusive quick bangladesh" data-name="crashx 1xgames exclusive">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/CrashX.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane-departure" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">CrashX</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="launchDroneGame(event)"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="launchDroneGame(event); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">CrashX</div>
                    </div>
                </div>

                <!-- Game 25: Crazy 777 2 -->
                <div class="slot-card" data-category="new exclusive" data-name="crazy 777 2 fazi">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Crazy 777 2.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Crazy 777 2</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Crazy 777 2')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Crazy 777 2'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">Crazy 777 2</div>
                    </div>
                </div>

                <!-- Game 26: Deigodsv -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="deigodsv pg soft">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Deigodsv.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Deigodsv</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Deigodsv')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Deigodsv'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">Deigodsv</div>
                    </div>
                </div>

                <!-- Game 27: Demigods -->
                <div class="slot-card" data-category="exclusive popular" data-name="demigods pragmatic play">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Demigods.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Demigods</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Demigods')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Demigods'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Demigods</div>
                    </div>
                </div>

                <!-- Game 28: Dracosgold -->
                <div class="slot-card" data-category="bonus quick" data-name="dracosgold amusnet interactive">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Dracosgold.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Dracosgold</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Dracosgold')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Dracosgold'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">Dracosgold</div>
                    </div>
                </div>

                <!-- Game 29: Dragonmagic -->
                <div class="slot-card" data-category="popular chicken" data-name="dragonmagic egt">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Dragonmagic.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-wand-magic-sparkles" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Dragonmagic</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Dragonmagic')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Dragonmagic'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">Dragonmagic</div>
                    </div>
                </div>

                <!-- Game 30: Egg Hunter -->
                <div class="slot-card" data-category="quick new" data-name="egg hunter jili">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Egg Hunter.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Egg Hunter</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Egg Hunter')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Egg Hunter'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">Egg Hunter</div>
                    </div>
                </div>

                <!-- Game 31: Fairy Fortune Deluxe -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="fairy fortune deluxe netent">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Fairy Fortune Deluxe.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Fairy Fortune Deluxe</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Fairy Fortune Deluxe')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Fairy Fortune Deluxe'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">Fairy Fortune Deluxe</div>
                    </div>
                </div>

                <!-- Game 32: FalconCashHoldandWin -->
                <div class="slot-card" data-category="new exclusive" data-name="falconcashholdandwin spinomenal">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/FalconCashHoldandWin.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">FalconCashHoldandWin</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('FalconCashHoldandWin')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('FalconCashHoldandWin'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">FalconCashHoldandWin</div>
                    </div>
                </div>

                <!-- Game 33: Firestorm 7 -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="firestorm 7 hacksaw gaming">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Firestorm 7.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Firestorm 7</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Firestorm 7')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Firestorm 7'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">Firestorm 7</div>
                    </div>
                </div>

                <!-- Game 34: Football -->
                <div class="slot-card" data-category="exclusive popular" data-name="football playson">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Football.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-futbol" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Football</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Football')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Football'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">Football</div>
                    </div>
                </div>

                <!-- Game 35: Frog's Ball Lock 2 Spin -->
                <div class="slot-card" data-category="bonus quick" data-name="frog's ball lock 2 spin evoplay">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Frog's Ball Lock 2 Spin™.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-futbol" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Frog's Ball Lock 2 Spin</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Frog\'s Ball Lock 2 Spin')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Frog\'s Ball Lock 2 Spin'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">Frog's Ball Lock 2 Spin</div>
                    </div>
                </div>

                <!-- Game 36: Fruit Scapes Pull Tabs -->
                <div class="slot-card" data-category="popular chicken" data-name="fruit scapes pull tabs betsoft">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Fruit Scapes Pull Tabs.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-leaf" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Fruit Scapes Pull Tabs</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Fruit Scapes Pull Tabs')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Fruit Scapes Pull Tabs'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">Fruit Scapes Pull Tabs</div>
                    </div>
                </div>

                <!-- Game 37: GemBlitz Bonanza -->
                <div class="slot-card" data-category="quick new" data-name="gemblitz bonanza smartsoft gaming">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/GemBlitz Bonanza.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">GemBlitz Bonanza</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('GemBlitz Bonanza')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('GemBlitz Bonanza'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">GemBlitz Bonanza</div>
                    </div>
                </div>

                <!-- Game 38: Goldenmine -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="goldenmine fazi">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Goldenmine.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Goldenmine</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Goldenmine')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Goldenmine'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">Goldenmine</div>
                    </div>
                </div>

                <!-- Game 39: Gonzo's Quest -->
                <div class="slot-card" data-category="new exclusive" data-name="gonzo's quest pg soft">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Gonzo's Quest™.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Gonzo's Quest</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Gonzo\'s Quest')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Gonzo\'s Quest'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">Gonzo's Quest</div>
                    </div>
                </div>

                <!-- Game 40: HelicopterX -->
                <div class="slot-card" data-category="exclusive quick bangladesh" data-name="helicopterx 1xgames exclusive">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/HelicopterX.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane-departure" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">HelicopterX</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="launchDroneGame(event)"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="launchDroneGame(event); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">HelicopterX</div>
                    </div>
                </div>

                <!-- Game 41: Hot Slot 777 Hold the Jackpot -->
                <div class="slot-card" data-category="exclusive popular" data-name="hot slot 777 hold the jackpot amusnet interactive">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Hot Slot™ 777 Hold the Jackpot™.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Hot Slot 777 Hold the Jackpot</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Hot Slot 777 Hold the Jackpot')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Hot Slot 777 Hold the Jackpot'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">Hot Slot 777 Hold the Jackpot</div>
                    </div>
                </div>

                <!-- Game 42: Indian Gold -->
                <div class="slot-card" data-category="bonus quick" data-name="indian gold egt">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Indian Gold.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Indian Gold</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Indian Gold')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Indian Gold'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">Indian Gold</div>
                    </div>
                </div>

                <!-- Game 43: Joker Poker -->
                <div class="slot-card" data-category="popular chicken" data-name="joker poker jili">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Joker Poker.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-face-laugh-wink" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Joker Poker</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Joker Poker')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Joker Poker'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">Joker Poker</div>
                    </div>
                </div>

                <!-- Game 44: Joker's Jewels Cash -->
                <div class="slot-card" data-category="quick new" data-name="joker's jewels cash netent">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Joker's Jewels Cash.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-face-laugh-wink" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Joker's Jewels Cash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Joker\'s Jewels Cash')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Joker\'s Jewels Cash'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">Joker's Jewels Cash</div>
                    </div>
                </div>

                <!-- Game 45: Juicywinsx10000 -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="juicywinsx10000 spinomenal">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Juicywinsx10000.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Juicywinsx10000</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Juicywinsx10000')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Juicywinsx10000'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">Juicywinsx10000</div>
                    </div>
                </div>

                <!-- Game 46: King Of Vikingso -->
                <div class="slot-card" data-category="new exclusive" data-name="king of vikingso hacksaw gaming">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/King Of Vikingso.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-shield-halved" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">King Of Vikingso</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('King Of Vikingso')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('King Of Vikingso'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">King Of Vikingso</div>
                    </div>
                </div>

                <!-- Game 47: Lucky Joker 10 -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="lucky joker 10 playson">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Lucky Joker 10.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-face-laugh-wink" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Lucky Joker 10</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Lucky Joker 10')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Lucky Joker 10'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">Lucky Joker 10</div>
                    </div>
                </div>

                <!-- Game 48: Lucky Joker 100 -->
                <div class="slot-card" data-category="exclusive popular" data-name="lucky joker 100 evoplay">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Lucky Joker 100.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-face-laugh-wink" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Lucky Joker 100</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Lucky Joker 100')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Lucky Joker 100'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">Lucky Joker 100</div>
                    </div>
                </div>

                <!-- Game 49: Luxe 555 -->
                <div class="slot-card" data-category="bonus quick" data-name="luxe 555 betsoft">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Luxe 555.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Luxe 555</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Luxe 555')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Luxe 555'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">Luxe 555</div>
                    </div>
                </div>

                <!-- Game 50: Magic Of The Ring -->
                <div class="slot-card" data-category="popular chicken" data-name="magic of the ring smartsoft gaming">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Magic Of The Ring.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-wand-magic-sparkles" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Magic Of The Ring</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Magic Of The Ring')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Magic Of The Ring'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">Magic Of The Ring</div>
                    </div>
                </div>

                <!-- Game 51: Mio and Neko Rock -->
                <div class="slot-card" data-category="quick new" data-name="mio and neko rock fazi">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Mio and Neko Rock.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Mio and Neko Rock</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Mio and Neko Rock')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Mio and Neko Rock'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">Mio and Neko Rock</div>
                    </div>
                </div>

                <!-- Game 52: Mystic Spin -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="mystic spin pg soft">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Mystic Spin.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Mystic Spin</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Mystic Spin')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Mystic Spin'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">Mystic Spin</div>
                    </div>
                </div>

                <!-- Game 53: Ocean Legacy -->
                <div class="slot-card" data-category="new exclusive" data-name="ocean legacy pragmatic play">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Ocean Legacy.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Ocean Legacy</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Ocean Legacy')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Ocean Legacy'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Ocean Legacy</div>
                    </div>
                </div>

                <!-- Game 54: Oliver's Bar Deluxe -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="oliver's bar deluxe amusnet interactive">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Oliver's Bar Deluxe.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Oliver's Bar Deluxe</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Oliver\'s Bar Deluxe')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Oliver\'s Bar Deluxe'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">Oliver's Bar Deluxe</div>
                    </div>
                </div>

                <!-- Game 55: Olympus Rivals -->
                <div class="slot-card" data-category="exclusive popular" data-name="olympus rivals egt">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Olympus Rivals.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Olympus Rivals</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Olympus Rivals')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Olympus Rivals'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">Olympus Rivals</div>
                    </div>
                </div>

                <!-- Game 56: Primate King -->
                <div class="slot-card" data-category="bonus quick" data-name="primate king jili">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Primate King.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Primate King</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Primate King')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Primate King'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">Primate King</div>
                    </div>
                </div>

                <!-- Game 57: Pure Ecstasy -->
                <div class="slot-card" data-category="popular chicken" data-name="pure ecstasy netent">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Pure Ecstasy.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Pure Ecstasy</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Pure Ecstasy')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Pure Ecstasy'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">Pure Ecstasy</div>
                    </div>
                </div>

                <!-- Game 58: Roulette Royal -->
                <div class="slot-card" data-category="quick new" data-name="roulette royal spinomenal">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Roulette Royal.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-circle-dot" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Roulette Royal</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Roulette Royal')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Roulette Royal'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">Roulette Royal</div>
                    </div>
                </div>

                <!-- Game 59: Royaltyofolympus -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="royaltyofolympus hacksaw gaming">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Royaltyofolympus.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Royaltyofolympus</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Royaltyofolympus')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Royaltyofolympus'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">Royaltyofolympus</div>
                    </div>
                </div>

                <!-- Game 60: SBonanza2500 -->
                <div class="slot-card" data-category="new exclusive" data-name="sbonanza2500 playson">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/SBonanza2500.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">SBonanza2500</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('SBonanza2500')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('SBonanza2500'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">SBonanza2500</div>
                    </div>
                </div>

                <!-- Game 61: Simply the Best -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="simply the best evoplay">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Simply the Best.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Simply the Best</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Simply the Best')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Simply the Best'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">Simply the Best</div>
                    </div>
                </div>

                <!-- Game 62: Sugar Monster -->
                <div class="slot-card" data-category="exclusive popular" data-name="sugar monster betsoft">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Sugar Monster.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-ghost" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Sugar Monster</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Sugar Monster')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Sugar Monster'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">Sugar Monster</div>
                    </div>
                </div>

                <!-- Game 63: SugrRush1000 -->
                <div class="slot-card" data-category="bonus quick" data-name="sugrrush1000 smartsoft gaming">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/SugrRush1000.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">SugrRush1000</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('SugrRush1000')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('SugrRush1000'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">SugrRush1000</div>
                    </div>
                </div>

                <!-- Game 64: Sumo -->
                <div class="slot-card" data-category="popular chicken" data-name="sumo fazi">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Sumo.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-child-combatant" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Sumo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Sumo')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Sumo'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">Sumo</div>
                    </div>
                </div>

                <!-- Game 65: Tlesofcamelotmoonlitquest -->
                <div class="slot-card" data-category="quick new" data-name="tlesofcamelotmoonlitquest pg soft">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Tlesofcamelotmoonlitquest.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Tlesofcamelotmoonlitquest</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Tlesofcamelotmoonlitquest')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Tlesofcamelotmoonlitquest'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">Tlesofcamelotmoonlitquest</div>
                    </div>
                </div>

                <!-- Game 66: Wild West -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="wild west pragmatic play">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Wild West.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Wild West</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Wild West')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Wild West'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Wild West</div>
                    </div>
                </div>

                <!-- Game 67: Wood Luck -->
                <div class="slot-card" data-category="new exclusive" data-name="wood luck amusnet interactive">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Wood Luck.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Wood Luck</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Wood Luck')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Wood Luck'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">Wood Luck</div>
                    </div>
                </div>

                <!-- Game 68: Zeus Lightning Megaways -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="zeus lightning megaways egt">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/Zeus Lightning Megaways.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Zeus Lightning Megaways</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('Zeus Lightning Megaways')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('Zeus Lightning Megaways'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">Zeus Lightning Megaways</div>
                    </div>
                </div>

                <!-- Game 69: bigbass -->
                <div class="slot-card" data-category="exclusive popular" data-name="bigbass jili">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/bigbass.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">bigbass</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="window.location.href='{{ route('big-bass-splash') }}'"><i class="fas fa-play"></i></button>
                        <a href="{{ route('big-bass-splash') }}?demo=1" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">bigbass</div>
                    </div>
                </div>

                <!-- Game 70: bonusmainadelixe -->
                <div class="slot-card" data-category="bonus quick" data-name="bonusmainadelixe netent">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/bonusmainadelixe.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">bonusmainadelixe</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('bonusmainadelixe')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('bonusmainadelixe'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">bonusmainadelixe</div>
                    </div>
                </div>

                <!-- Game 71: brainrotmaina -->
                <div class="slot-card" data-category="popular chicken" data-name="brainrotmaina spinomenal">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/brainrotmaina.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">brainrotmaina</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('brainrotmaina')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('brainrotmaina'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">brainrotmaina</div>
                    </div>
                </div>

                <!-- Game 72: caishengold -->
                <div class="slot-card" data-category="quick new" data-name="caishengold hacksaw gaming">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/caishengold.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">caishengold</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('caishengold')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('caishengold'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">caishengold</div>
                    </div>
                </div>

                <!-- Game 73: cashme -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="cashme playson">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/cashme.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">cashme</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('cashme')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('cashme'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">cashme</div>
                    </div>
                </div>

                <!-- Game 74: coinodysseyi -->
                <div class="slot-card" data-category="new exclusive" data-name="coinodysseyi evoplay">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/coinodysseyi.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">coinodysseyi</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('coinodysseyi')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('coinodysseyi'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">coinodysseyi</div>
                    </div>
                </div>

                <!-- Game 75: crash -->
                <div class="slot-card" data-category="exclusive quick bangladesh" data-name="crash 1xgames exclusive">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/crash.png") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane-departure" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">crash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="launchDroneGame(event)"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="launchDroneGame(event); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">crash</div>
                    </div>
                </div>

                <!-- Game 76: elementalfusion -->
                <div class="slot-card" data-category="exclusive popular" data-name="elementalfusion smartsoft gaming">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/elementalfusion.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">elementalfusion</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('elementalfusion')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('elementalfusion'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">elementalfusion</div>
                    </div>
                </div>

                <!-- Game 77: elveskirgoodr -->
                <div class="slot-card" data-category="bonus quick" data-name="elveskirgoodr fazi">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/elveskirgoodr.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">elveskirgoodr</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('elveskirgoodr')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('elveskirgoodr'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">elveskirgoodr</div>
                    </div>
                </div>

                <!-- Game 78: fortunegems2 -->
                <div class="slot-card" data-category="popular chicken" data-name="fortunegems2 pg soft">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/fortunegems2.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">fortunegems2</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('fortunegems2')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('fortunegems2'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">fortunegems2</div>
                    </div>
                </div>

                <!-- Game 79: fortunenumbers -->
                <div class="slot-card" data-category="quick new" data-name="fortunenumbers pragmatic play">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/fortunenumbers.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">fortunenumbers</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('fortunenumbers')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('fortunenumbers'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">fortunenumbers</div>
                    </div>
                </div>

                <!-- Game 80: gatesofmerlyn -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="gatesofmerlyn amusnet interactive">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/gatesofmerlyn.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">gatesofmerlyn</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('gatesofmerlyn')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('gatesofmerlyn'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">gatesofmerlyn</div>
                    </div>
                </div>

                <!-- Game 81: godslovegoldhold&win -->
                <div class="slot-card" data-category="new exclusive" data-name="godslovegoldhold&win egt">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/godslovegoldhold&win.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">godslovegoldhold&win</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('godslovegoldhold&win')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('godslovegoldhold&win'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">godslovegoldhold&win</div>
                    </div>
                </div>

                <!-- Game 82: gueens&diamonds -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="gueens&diamonds jili">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/gueens&diamonds.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">gueens&diamonds</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('gueens&diamonds')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('gueens&diamonds'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">gueens&diamonds</div>
                    </div>
                </div>

                <!-- Game 83: holdandearn -->
                <div class="slot-card" data-category="exclusive popular" data-name="holdandearn netent">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/holdandearn.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">holdandearn</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('holdandearn')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('holdandearn'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">holdandearn</div>
                    </div>
                </div>

                <!-- Game 84: holdandspin -->
                <div class="slot-card" data-category="bonus quick" data-name="holdandspin spinomenal">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/holdandspin.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">holdandspin</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('holdandspin')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('holdandspin'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">holdandspin</div>
                    </div>
                </div>

                <!-- Game 85: hotfruitsonfire -->
                <div class="slot-card" data-category="popular chicken" data-name="hotfruitsonfire hacksaw gaming">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/hotfruitsonfire.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-leaf" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">hotfruitsonfire</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('hotfruitsonfire')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('hotfruitsonfire'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">hotfruitsonfire</div>
                    </div>
                </div>

                <!-- Game 86: lepharaoh -->
                <div class="slot-card" data-category="quick new" data-name="lepharaoh playson">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/lepharaoh.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">lepharaoh</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('lepharaoh')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('lepharaoh'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">lepharaoh</div>
                    </div>
                </div>

                <!-- Game 87: luckyace -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="luckyace evoplay">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/luckyace.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-dice" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">luckyace</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('luckyace')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('luckyace'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">luckyace</div>
                    </div>
                </div>

                <!-- Game 88: majesticclaws -->
                <div class="slot-card" data-category="new exclusive" data-name="majesticclaws betsoft">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/majesticclaws.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">majesticclaws</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('majesticclaws')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('majesticclaws'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">majesticclaws</div>
                    </div>
                </div>

                <!-- Game 89: majesticwildbuffalo -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="majesticwildbuffalo smartsoft gaming">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/majesticwildbuffalo.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">majesticwildbuffalo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('majesticwildbuffalo')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('majesticwildbuffalo'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">majesticwildbuffalo</div>
                    </div>
                </div>

                <!-- Game 90: megablock -->
                <div class="slot-card" data-category="exclusive popular" data-name="megablock fazi">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/megablock.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">megablock</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('megablock')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('megablock'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">megablock</div>
                    </div>
                </div>

                <!-- Game 91: moenycoming -->
                <div class="slot-card" data-category="bonus quick" data-name="moenycoming pg soft">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/moenycoming.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">moenycoming</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('moenycoming')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('moenycoming'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">moenycoming</div>
                    </div>
                </div>

                <!-- Game 92: multihot5 -->
                <div class="slot-card" data-category="popular chicken" data-name="multihot5 pragmatic play">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/multihot5.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">multihot5</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('multihot5')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('multihot5'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">multihot5</div>
                    </div>
                </div>

                <!-- Game 93: phoenik -->
                <div class="slot-card" data-category="quick new" data-name="phoenik amusnet interactive">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/phoenik.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">phoenik</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('phoenik')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('phoenik'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">phoenik</div>
                    </div>
                </div>

                <!-- Game 94: piggycash -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="piggycash egt">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/piggycash.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">piggycash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('piggycash')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('piggycash'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">EGT</span>
                        <div class="slot-card-title">piggycash</div>
                    </div>
                </div>

                <!-- Game 95: royal&emirates -->
                <div class="slot-card" data-category="new exclusive" data-name="royal&emirates jili">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/royal&emirates.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">royal&emirates</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('royal&emirates')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('royal&emirates'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili</span>
                        <div class="slot-card-title">royal&emirates</div>
                    </div>
                </div>

                <!-- Game 96: seetboonaza1000 -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="seetboonaza1000 netent">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/seetboonaza1000.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">seetboonaza1000</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('seetboonaza1000')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('seetboonaza1000'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">NetEnt</span>
                        <div class="slot-card-title">seetboonaza1000</div>
                    </div>
                </div>

                <!-- Game 97: shakib75cricketlegacy -->
                <div class="slot-card" data-category="exclusive popular" data-name="shakib75cricketlegacy spinomenal">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/shakib75cricketlegacy.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">shakib75cricketlegacy</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('shakib75cricketlegacy')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('shakib75cricketlegacy'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">shakib75cricketlegacy</div>
                    </div>
                </div>

                <!-- Game 98: starlightprincess1000 -->
                <div class="slot-card" data-category="bonus quick" data-name="starlightprincess1000 hacksaw gaming">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/starlightprincess1000.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-person-dress" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">starlightprincess1000</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('starlightprincess1000')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('starlightprincess1000'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hacksaw Gaming</span>
                        <div class="slot-card-title">starlightprincess1000</div>
                    </div>
                </div>

                <!-- Game 99: stormforged -->
                <div class="slot-card" data-category="popular chicken" data-name="stormforged playson">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/stormforged.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">stormforged</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('stormforged')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('stormforged'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Playson</span>
                        <div class="slot-card-title">stormforged</div>
                    </div>
                </div>

                <!-- Game 100: sunshinerichwebp -->
                <div class="slot-card" data-category="quick new" data-name="sunshinerichwebp evoplay">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/sunshinerichwebp.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">sunshinerichwebp</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('sunshinerichwebp')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('sunshinerichwebp'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Evoplay</span>
                        <div class="slot-card-title">sunshinerichwebp</div>
                    </div>
                </div>

                <!-- Game 101: sweetbonazaxmas -->
                <div class="slot-card" data-category="chicken bangladesh" data-name="sweetbonazaxmas betsoft">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/sweetbonazaxmas.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4a148c 0%, #9c27b0 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">sweetbonazaxmas</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('sweetbonazaxmas')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('sweetbonazaxmas'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Betsoft</span>
                        <div class="slot-card-title">sweetbonazaxmas</div>
                    </div>
                </div>

                <!-- Game 102: sweetdreambonaaz -->
                <div class="slot-card" data-category="new exclusive" data-name="sweetdreambonaaz smartsoft gaming">
                    <span class="slot-badge slot-badge-drops">Drops & Wins</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/sweetdreambonaaz.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">sweetdreambonaaz</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('sweetdreambonaaz')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('sweetdreambonaaz'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Smartsoft Gaming</span>
                        <div class="slot-card-title">sweetdreambonaaz</div>
                    </div>
                </div>

                <!-- Game 103: theemirate -->
                <div class="slot-card" data-category="bangladesh bonus" data-name="theemirate fazi">
                    <span class="slot-badge slot-badge-promo" style="background:#f44336;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/theemirate.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">theemirate</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('theemirate')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('theemirate'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Fazi</span>
                        <div class="slot-card-title">theemirate</div>
                    </div>
                </div>

                <!-- Game 104: veryhot5 -->
                <div class="slot-card" data-category="exclusive popular" data-name="veryhot5 pg soft">
                    <span class="slot-badge slot-badge-promo" style="background:#007bff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/veryhot5.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0d47a1 0%, #1e88e5 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gamepad" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">veryhot5</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('veryhot5')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('veryhot5'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PG Soft</span>
                        <div class="slot-card-title">veryhot5</div>
                    </div>
                </div>

                <!-- Game 105: western -->
                <div class="slot-card" data-category="bonus quick" data-name="western pragmatic play">
                    
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/western.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">western</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('western')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('western'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">western</div>
                    </div>
                </div>

                <!-- Game 106: wildtrailscasino -->
                <div class="slot-card" data-category="popular chicken" data-name="wildtrailscasino amusnet interactive">
                    <span class="slot-badge slot-badge-promo">PROMO</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset("assets/image/wildtrailscasino.webp") }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">wildtrailscasino</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <button class="slot-play-btn" onclick="demoGameRedirect('wildtrailscasino')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('wildtrailscasino'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amusnet Interactive</span>
                        <div class="slot-card-title">wildtrailscasino</div>
                    </div>
                </div>

                <!-- Game: BonBon Bonanza (New) -->
                <div class="slot-card" onclick="demoGameRedirect('bonbonbonanza')" data-category="new popular bonus" data-name="bonbon bonanza pragmatic play">
                    <span class="slot-badge slot-badge-drops" style="background: linear-gradient(135deg,#e91e8c,#f06292); color:#fff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/BonBon Bonanza.webp') }}" class="slot-card-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #880e4f 0%, #e91e8c 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-candy-cane" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">BonBon Bonanza</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay" onclick="event.stopPropagation();">
                        <button class="slot-play-btn" onclick="demoGameRedirect('bonbonbonanza')"><i class="fas fa-play"></i></button>
                        <a href="#" onclick="demoGameRedirect('bonbonbonanza'); return false;" class="slot-demo-link">Play Demo</a>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">BonBon Bonanza</div>
                    </div>
                </div>

            </div>

        </main>

        <!-- Main Dashboard Account Cabinet (Hidden by default, shown when user clicks Cabinet) -->
        <main class="lobby-main" id="user-cabinet-section" style="display: none;">
            
            <!-- Back to Lobby button -->
            <button class="cabinet-back-btn" onclick="toggleCabinet(false)">
                <i class="fas fa-chevron-left"></i> Back to Casino Slots Lobby
            </button>

            <!-- Original Laravel Dashboard Tabs Bar -->
            <div class="dashboard-container" style="max-width:100%; margin:0; padding:0;">
                
                <!-- Action Alerts Banner -->
                <div id="dashboard-global-alert" class="dashboard-alert-banner" style="display: none;"></div>

                <!-- 7 Tabs Navigation Menu -->
                <div class="dashboard-tabs-bar">
                    <button class="dashboard-tab-trigger active" onclick="switchDashboardTab('tab-overview', this)">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-bets', this)">
                        <i class="fas fa-history"></i> My Bets
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-transactions', this)">
                        <i class="fas fa-list-check"></i> Transactions
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-levels', this)">
                        <i class="fas fa-crown"></i> Levels Manage
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-transfer', this)">
                        <i class="fas fa-paper-plane"></i> Amount Transfer
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-referral', this)">
                        <i class="fas fa-users-viewfinder"></i> Referral
                    </button>
                    <button class="dashboard-tab-trigger" onclick="switchDashboardTab('tab-profile', this)">
                        <i class="fas fa-user-gear"></i> Profile
                    </button>
                </div>

                <!-- ============================================== -->
                <!-- TAB 1: OVERVIEW                                -->
                <!-- ============================================== -->
                <div id="tab-overview" class="dashboard-tab-content active">
                    <div class="dashboard-grid">
                        
                        <!-- Left Sidebar Cards Column -->
                        <aside class="dashboard-left-column">
                            <!-- Profile Card -->
                            <div class="dashboard-panel-card profile-widget">
                                <div class="profile-avatar-container">
                                    <div class="profile-avatar">
                                        <i class="fas fa-user-ninja"></i>
                                    </div>
                                    <span class="vip-badge">PILOT LEVEL 1</span>
                                </div>
                                <h2 class="profile-name" id="overview-profile-name">{{ auth()->user()->name }}</h2>
                                <span class="profile-uid">ID: {{ 50000 + auth()->user()->id }}</span>
                            </div>

                            <!-- Balance Card -->
                            <div class="dashboard-panel-card wallet-widget">
                                <div class="wallet-balance-row">
                                    <div class="wallet-balance-label">Available Wallet Balance</div>
                                    <div class="wallet-balance-value">
                                        <span class="balance-symbol">{{ auth()->user()->currency === 'BDT' ? '৳' : (auth()->user()->currency === 'INR' ? '₹' : '$') }}</span>
                                        <span class="widget-balance-val">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                                    </div>
                                </div>
                                <div class="wallet-actions">
                                    <button onclick="openModal('deposit-modal')" class="btn-wallet btn-wallet-deposit">
                                        <i class="fas fa-circle-down"></i> Deposit
                                    </button>
                                    <button onclick="openModal('withdraw-modal')" class="btn-wallet btn-wallet-withdraw">
                                        <i class="fas fa-circle-up"></i> Withdraw
                                    </button>
                                </div>
                            </div>
                        </aside>

                        <!-- Right Contents Column -->
                        <main class="dashboard-right-column">
                            <!-- Stats Grid -->
                            <div class="dashboard-stats-grid">
                                <div class="dashboard-stat-card">
                                    <div class="stat-card-icon stat-icon-blue">
                                        <i class="fas fa-fire"></i>
                                    </div>
                                    <div class="stat-card-info">
                                        <span class="stat-card-value" id="stats-total-matches">148</span>
                                        <span class="stat-card-label">Total Match</span>
                                    </div>
                                </div>
                                
                                <div class="dashboard-stat-card">
                                    <div class="stat-card-icon stat-icon-gold">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="stat-card-info">
                                        <span class="stat-card-value" id="stats-win-ratio">68.4%</span>
                                        <span class="stat-card-label">Win Ratio</span>
                                    </div>
                                </div>
                                
                                <div class="dashboard-stat-card">
                                    <div class="stat-card-icon stat-icon-green">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="stat-card-info">
                                        <span class="stat-card-value" id="stats-achievements">12</span>
                                        <span class="stat-card-label">Achievements</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Glowing Play Game CTA Banner -->
                            <div class="play-game-banner">
                                <div class="play-game-info">
                                    <h3 class="play-game-title"><i class="fas fa-plane-departure text-orange"></i> Aviator <span>Crash Flight</span></h3>
                                    <p class="play-game-desc">Experience our 100% Provably Fair multiplayer betting model. Play the multiplier curve, cash out before takeoff crashes, and double your winnings instantly!</p>
                                </div>
                                <div class="play-game-cta">
                                    <a href="{{ route('play') }}" class="btn-play-pulse">
                                        PLAY NOW <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Recent Transactions Table -->
                            <div class="dashboard-panel-card">
                                <h3 class="dashboard-panel-title"><i class="fas fa-list-check"></i> Recent Wallet Activities</h3>
                                <div class="dashboard-table-box">
                                    <div class="dashboard-table-wrapper">
                                        <table class="dashboard-table" id="table-recent-transactions">
                                            <thead>
                                                <tr>
                                                    <th>DATE & TIME</th>
                                                    <th>ACTIVITY TYPE</th>
                                                    <th>PAYMENT GATEWAY</th>
                                                    <th>TRANS AMOUNT</th>
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-recent-transactions">
                                                <!-- Will populate dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="recent-transactions-empty" class="empty-table-placeholder" style="display: none;">
                                        <i class="fas fa-file-circle-exclamation"></i>
                                        <p>No transaction history found.</p>
                                    </div>
                                </div>
                            </div>
                        </main>
                        
                    </div>
                </div>


        <!-- ============================================== -->
        <!-- TAB 2: MY BETS                                 -->
        <!-- ============================================== -->
        <div id="tab-bets" class="dashboard-tab-content">
            <div class="dashboard-panel-card">
                <h3 class="dashboard-panel-title"><i class="fas fa-history"></i> Personal Bets History</h3>
                <div class="dashboard-table-box">
                    <div class="dashboard-table-wrapper">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>TIME</th>
                                    <th>ROUND ID</th>
                                    <th>STAKE AMOUNT</th>
                                    <th>CASHOUT MULTIPLIER</th>
                                    <th>PAYOUT WINNINGS</th>
                                    <th>CRASH POINT</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-personal-bets">
                                <!-- Populated dynamically from local storage / simulated -->
                            </tbody>
                        </table>
                    </div>
                    <div id="personal-bets-empty" class="empty-table-placeholder" style="display: none;">
                        <i class="fas fa-dice"></i>
                        <p>You haven't placed any bets yet. Load the game to start flying!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 3: TRANSACTIONS                            -->
        <!-- ============================================== -->
        <div id="tab-transactions" class="dashboard-tab-content">
            <div class="dashboard-panel-card">
                <h3 class="dashboard-panel-title"><i class="fas fa-list-check"></i> All Transaction Logs</h3>
                <div class="dashboard-table-box">
                    <div class="dashboard-table-wrapper">
                        <table class="dashboard-table" id="table-all-transactions">
                            <thead>
                                <tr>
                                    <th>DATE & TIME</th>
                                    <th>ACTIVITY TYPE</th>
                                    <th>PAYMENT GATEWAY</th>
                                    <th>TRANS AMOUNT</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-all-transactions">
                                <!-- Populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div id="all-transactions-empty" class="empty-table-placeholder" style="display: none;">
                        <i class="fas fa-receipt"></i>
                        <p>No transactions registered for this account.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 4: LEVELS MANAGE                            -->
        <!-- ============================================== -->
        <div id="tab-levels" class="dashboard-tab-content">
            <div class="dashboard-panel-card">
                <h3 class="dashboard-panel-title"><i class="fas fa-crown"></i> VIP Level Status</h3>
                
                <!-- Progress display -->
                <div class="levels-progress-box">
                    <div class="levels-header-row">
                        <span class="levels-title">Current Level Progression: <strong>Bronze Pilot</strong></span>
                        <span class="levels-percent">48% Complete</span>
                    </div>
                    <div class="levels-progress-bar-bg">
                        <div class="levels-progress-bar-fill" style="width: 48%;"></div>
                    </div>
                    <span class="levels-footer-text">Bet 5,200.00 {{ auth()->user()->currency }} more to unlock Silver VIP status.</span>
                </div>

                <!-- Levels Grid -->
                <div class="levels-list-grid">
                    <div class="level-card-node current unlocked">
                        <div class="level-node-icon"><i class="fas fa-user-astronaut"></i></div>
                        <span class="level-node-name">Bronze Pilot</span>
                        <span class="level-node-req">Default Tier</span>
                    </div>
                    
                    <div class="level-card-node">
                        <div class="level-node-icon"><i class="fas fa-paper-plane"></i></div>
                        <span class="level-node-name">Silver VIP</span>
                        <span class="level-node-req">10,000 Volume</span>
                    </div>
                    
                    <div class="level-card-node">
                        <div class="level-node-icon"><i class="fas fa-plane"></i></div>
                        <span class="level-node-name">Gold Pilot</span>
                        <span class="level-node-req">50,000 Volume</span>
                    </div>
                    
                    <div class="level-card-node">
                        <div class="level-node-icon"><i class="fas fa-rocket"></i></div>
                        <span class="level-node-name">Platinum VIP</span>
                        <span class="level-node-req">250,000 Volume</span>
                    </div>
                    
                    <div class="level-card-node">
                        <div class="level-node-icon"><i class="fas fa-crown"></i></div>
                        <span class="level-node-name">Diamond Legend</span>
                        <span class="level-node-req">1,000,000 Volume</span>
                    </div>
                </div>

                <!-- Perks Section -->
                <div class="level-perks-box">
                    <h4 class="level-perks-title">Your Current Bronze Pilot Benefits:</h4>
                    <ul class="level-perks-list">
                        <li class="level-perk-item"><i class="fas fa-check-circle"></i> Standard withdrawal limits up to 50,000 {{ auth()->user()->currency }}/day</li>
                        <li class="level-perk-item"><i class="fas fa-check-circle"></i> Access to all P2P multi-currency sports modules</li>
                        <li class="level-perk-item"><i class="fas fa-check-circle"></i> 100% Provably Fair cryptographic verification</li>
                        <li class="level-perk-item"><i class="fas fa-check-circle"></i> 24/7 Live Agent chat support access</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 5: AMOUNT TRANSFER                         -->
        <!-- ============================================== -->
        <div id="tab-transfer" class="dashboard-tab-content">
            <div class="dashboard-panel-card dashboard-form-container">
                <h3 class="dashboard-panel-title"><i class="fas fa-paper-plane"></i> Peer-to-Peer Wallet Transfer</h3>
                
                <div class="gateway-instructions-box" style="margin-bottom: 24px;">
                    <i class="fas fa-info-circle text-orange"></i> Transfer wallet balances instantly to any registered user email or mobile. Transaction is completed securely inside the escrow wallet ledger. <strong>Zero Network Fees apply!</strong>
                </div>

                <form id="p2p-transfer-form" onsubmit="handleP2PTransfer(event)">
                    <div class="dashboard-form-group">
                        <label class="dashboard-form-label">Recipient Identifier (Email or Phone)</label>
                        <input type="text" id="transfer-recipient" class="dashboard-form-input" placeholder="e.g. user@example.com or 01700000000" required autocomplete="off">
                    </div>
                    
                    <div class="dashboard-form-group">
                        <label class="dashboard-form-label">Transfer Amount ({{ auth()->user()->currency }})</label>
                        <input type="number" id="transfer-amount" class="dashboard-form-input" min="10" step="any" placeholder="Enter amount to transfer" required>
                    </div>
                    
                    <div class="dashboard-form-group">
                        <label class="dashboard-form-label">Secure Transaction Password</label>
                        <input type="password" id="transfer-password" class="dashboard-form-input" placeholder="Confirm your account password" required>
                    </div>

                    <button type="submit" class="btn-submit-purple" id="btn-transfer-submit">
                        <i class="fas fa-circle-check"></i> CONFIRM ESCROW TRANSFER
                    </button>
                </form>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 6: REFERRAL                                -->
        <!-- ============================================== -->
        <div id="tab-referral" class="dashboard-tab-content">
            <div class="dashboard-panel-card">
                <h3 class="dashboard-panel-title"><i class="fas fa-users-viewfinder"></i> Affiliate Program</h3>
                
                <div class="referral-top-row">
                    <!-- Referral Link Card -->
                    <div class="referral-link-box">
                        <span class="referral-link-title">Your Affiliate Link</span>
                        <div class="referral-link-input-wrapper">
                            <input type="text" id="affiliate-link-val" class="referral-link-input" readonly value="{{ route('home') }}?ref={{ 50000 + auth()->user()->id }}">
                            <button onclick="copyAffiliateLink()" class="btn-referral-copy">
                                <i class="fas fa-copy"></i> COPY
                            </button>
                        </div>
                    </div>
                    
                     <!-- Stats widgets -->
                     <div class="referral-stats-mini-grid">
                         <div class="referral-stat-mini-card">
                             <span class="referral-stat-mini-val" id="affiliate-count-widget">0</span>
                             <span class="referral-stat-mini-label">Total Referrals</span>
                         </div>
                         <div class="referral-stat-mini-card">
                             <span class="referral-stat-mini-val" id="affiliate-earnings-widget">৳ 0.00</span>
                             <span class="referral-stat-mini-label">Referral Earnings</span>
                         </div>
                     </div>
                </div>

                <!-- Referrals Table -->
                <h4 class="levels-title" style="margin-bottom: 12px; font-size: 13px;"><i class="fas fa-people-group"></i> Referred User Accounts</h4>
                <div class="dashboard-table-box">
                    <div class="dashboard-table-wrapper">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>USERNAME</th>
                                    <th>JOIN DATE</th>
                                    <th>LEVEL STATUS</th>
                                    <th>AFFILIATE COMMISSION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anisur Rahman</td>
                                    <td>12 Jun 2026</td>
                                    <td><span class="status-badge status-completed">Silver VIP</span></td>
                                    <td>৳ 1,200.00</td>
                                </tr>
                                <tr>
                                    <td>Tanvir Ahmed</td>
                                    <td>10 Jun 2026</td>
                                    <td><span class="status-badge status-completed">Bronze Pilot</span></td>
                                    <td>৳ 850.00</td>
                                </tr>
                                <tr>
                                    <td>Jahid Hasan</td>
                                    <td>08 Jun 2026</td>
                                    <td><span class="status-badge status-completed">Bronze Pilot</span></td>
                                    <td>৳ 400.00</td>
                                </tr>
                                <tr>
                                    <td>Rakibul Islam</td>
                                    <td>05 Jun 2026</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>৳ 0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 7: PROFILE                                 -->
        <!-- ============================================== -->
        <div id="tab-profile" class="dashboard-tab-content">
            <div class="dashboard-grid">
                <!-- Profile Edit -->
                <div class="dashboard-panel-card">
                    <h3 class="dashboard-panel-title"><i class="fas fa-id-card"></i> Edit Profile Information</h3>
                    <form id="profile-edit-form" onsubmit="handleProfileEdit(event)">
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">Full Name</label>
                            <input type="text" id="profile-name" class="dashboard-form-input" value="{{ auth()->user()->name }}" required>
                        </div>
                        
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">Email Address (Locked)</label>
                            <input type="email" class="dashboard-form-input" value="{{ auth()->user()->email }}" disabled>
                        </div>
                        
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">Mobile Number (Locked)</label>
                            <input type="text" class="dashboard-form-input" value="{{ auth()->user()->mobile }}" disabled>
                        </div>
                        
                        <div class="dashboard-form-row">
                            <div class="dashboard-form-group">
                                <label class="dashboard-form-label">Gender</label>
                                <select id="profile-gender" class="dashboard-form-select">
                                    <option value="Male" {{ auth()->user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ auth()->user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ auth()->user()->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div class="dashboard-form-group">
                                <label class="dashboard-form-label">Country</label>
                                <input type="text" id="profile-country" class="dashboard-form-input" value="{{ auth()->user()->country }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-purple" id="btn-profile-submit">
                            <i class="fas fa-save"></i> SAVE PROFILE CHANGES
                        </button>
                    </form>
                </div>

                <!-- Password Change -->
                <div class="dashboard-panel-card">
                    <h3 class="dashboard-panel-title"><i class="fas fa-key"></i> Change Security Password</h3>
                    <form id="password-change-form" onsubmit="handlePasswordChange(event)">
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">Current Password</label>
                            <input type="password" id="pass-current" class="dashboard-form-input" placeholder="Enter current password" required>
                        </div>
                        
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">New Password</label>
                            <input type="password" id="pass-new" class="dashboard-form-input" placeholder="Enter new password (min 6 characters)" required>
                        </div>
                        
                        <div class="dashboard-form-group">
                            <label class="dashboard-form-label">Confirm New Password</label>
                            <input type="password" id="pass-confirm" class="dashboard-form-input" placeholder="Repeat new password" required>
                        </div>

                        <button type="submit" class="btn-submit-purple" id="btn-password-submit">
                            <i class="fas fa-lock"></i> UPDATE PASSWORD
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- MODAL: DEPOSIT GATEWAY                         -->
    <!-- ============================================== -->
    <div id="deposit-modal" class="dashboard-modal-overlay">
        <div class="dashboard-modal-box" style="max-width:600px; width:100%;">
            <button class="dashboard-modal-close" onclick="closeModal('deposit-modal')"><i class="fas fa-times"></i></button>
            <h3 class="dashboard-modal-title"><i class="fas fa-circle-down text-green"></i> Deposit Wallet Balance</h3>
            
            <form id="deposit-form" onsubmit="handleDepositSubmit(event)" enctype="multipart/form-data">
                <label class="dashboard-form-label">Select Deposit Payment Gateway</label>
                <div class="payment-gateways-grid" id="deposit-gateways-list" style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
                    <!-- Dynamically populated logos grid -->
                </div>

                <input type="hidden" id="deposit-gateway-id">

                <!-- Gateway instructions container -->
                <div id="deposit-gateway-instructions" style="margin-bottom:20px; display:none;">
                    <label class="dashboard-form-label"><i class="fas fa-circle-info text-orange"></i> Payment Instructions</label>
                    <div class="gateway-instructions-box" id="deposit-instructions-box" style="display:flex; flex-direction:column; gap:10px; background:rgba(255,255,255,0.03); padding:16px; border-radius:10px;">
                        <!-- Instructions with copy buttons -->
                    </div>
                </div>

                <div class="dashboard-form-group">
                    <label class="dashboard-form-label">Deposit Amount ({{ auth()->user()->currency }})</label>
                    <input type="number" id="deposit-amount" class="dashboard-form-input" placeholder="Enter deposit amount" min="10" step="any" required>
                </div>
                
                <div class="dashboard-form-group" style="margin-top:12px;">
                    <label class="dashboard-form-label">Sender Number / Account <span class="text-orange">*</span></label>
                    <input type="text" name="sender_number" id="deposit-sender-number" class="dashboard-form-input" placeholder="Enter your sender account number" required autocomplete="off">
                </div>

                <div class="dashboard-form-group" style="margin-top:12px;">
                    <label class="dashboard-form-label">Transaction ID <span class="text-orange">*</span></label>
                    <input type="text" name="transaction_id" id="deposit-transaction-id" class="dashboard-form-input" placeholder="Enter transaction ID" required autocomplete="off">
                </div>

                <div class="dashboard-form-group" style="margin-top:12px;">
                    <label class="dashboard-form-label">Payment Screenshot <span class="text-orange">*</span></label>
                    <input type="file" name="screenshot" id="deposit-screenshot" class="dashboard-form-input" accept="image/*" required>
                </div>

                <button type="submit" class="btn-submit-purple" id="btn-deposit-submit" style="background: var(--color-green); box-shadow: 0 4px 15px rgba(46, 189, 89, 0.4); margin-top:16px;">
                    <i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST
                </button>
            </form>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- MODAL: WITHDRAW GATEWAY                        -->
    <!-- ============================================== -->
    <div id="withdraw-modal" class="dashboard-modal-overlay">
        <div class="dashboard-modal-box" style="max-width:600px; width:100%;">
            <button class="dashboard-modal-close" onclick="closeModal('withdraw-modal')"><i class="fas fa-times"></i></button>
            <h3 class="dashboard-modal-title"><i class="fas fa-circle-up text-red"></i> Withdraw Wallet Balance</h3>
            
            <form id="withdraw-form" onsubmit="handleWithdrawSubmit(event)">
                <div class="dashboard-form-group" style="margin-bottom: 20px;">
                    <label class="dashboard-form-label">Select Withdrawal Payment Method</label>
                    <select id="withdraw-gateway-select" class="dashboard-form-select" onchange="selectClientWithdrawGateway(this.value)" style="width:100%; cursor:pointer;" required>
                        <option value="">Choose Method...</option>
                    </select>
                </div>

                <input type="hidden" id="withdraw-gateway-id">

                <!-- Gateway instructions container for withdrawal if any -->
                <div id="withdraw-gateway-instructions" style="margin-bottom:20px; display:none;">
                    <label class="dashboard-form-label"><i class="fas fa-circle-info text-orange"></i> Payment Instructions</label>
                    <div class="gateway-instructions-box" id="withdraw-instructions-box" style="display:flex; flex-direction:column; gap:10px; background:rgba(255,255,255,0.03); padding:16px; border-radius:10px;">
                        <!-- Instructions with copy buttons -->
                    </div>
                </div>

                <div class="dashboard-form-group">
                    <label class="dashboard-form-label">Withdrawal Amount ({{ auth()->user()->currency }})</label>
                    <input type="number" id="withdraw-amount" class="dashboard-form-input" placeholder="Enter withdrawal amount" min="50" step="any" required>
                </div>
                
                <div class="dashboard-form-group" style="margin-top: 12px;">
                    <label class="dashboard-form-label">Your Wallet Mobile/Account Number</label>
                    <input type="text" id="withdraw-account" class="dashboard-form-input" placeholder="e.g. 017xxxxxxxx or TBhd7ih..." required>
                </div>

                <div class="dashboard-form-group" style="margin-top: 12px;">
                    <label class="dashboard-form-label">Note/Description (Optional)</label>
                    <input type="text" id="withdraw-note" class="dashboard-form-input" placeholder="Enter note or payment description">
                </div>

                <button type="submit" class="btn-submit-purple" id="btn-withdraw-submit" style="background: var(--color-red); box-shadow: 0 4px 15px rgba(235, 64, 52, 0.4); margin-top:16px;">
                    <i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL
                </button>
            </form>
        </div>
    </div>

    <!-- Success Copy Toast Alert -->
    <div id="dashboard-toast-box" class="dashboard-toast">
        <i class="fas fa-circle-check"></i>
        <span id="toast-message-val">Success!</span>
    </div>

    <!-- Hidden Form for CSRF-safe Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Interactive JS controllers -->
    <script>
        // Global variables from PHP state
        const USER_CURRENCY = "{{ auth()->user()->currency }}";
        const USER_SYMBOL = USER_CURRENCY === 'BDT' ? '৳' : (USER_CURRENCY === 'INR' ? '₹' : '$');

        function escHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        let transactions = [];
        
        // ==========================================================================
        // 1XBET CASINO LOBBY JS CONTROLS
        // ==========================================================================
        let currentSlide = 0;
        const totalSlides = 3;
        let slideInterval;

        function showSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            
            // Update active slides
            document.querySelectorAll('.banner-slide').forEach((slide, idx) => {
                if (idx === currentSlide) {
                    slide.classList.add('slide-active');
                } else {
                    slide.classList.remove('slide-active');
                }
            });

            // Update active dots
            document.querySelectorAll('.slide-dot').forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        window.moveSlide = function(direction) {
            showSlide(currentSlide + direction);
            resetSlideInterval();
        }

        window.setSlide = function(index) {
            showSlide(index);
            resetSlideInterval();
        }

        function startSlideInterval() {
            slideInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 6000); // 6 seconds slide auto-rotate
        }

        function resetSlideInterval() {
            clearInterval(slideInterval);
            startSlideInterval();
        }

        // Search filtering for slot game cards
        window.filterLobbyGames = function() {
            const query = document.getElementById('lobby-search-box').value.toLowerCase();
            const cards = document.querySelectorAll('#slots-grid-list .slot-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Category filter buttons
        window.filterCategory = function(category, btn) {
            // Update active styling
            document.querySelectorAll('.lobby-category-btn').forEach(b => {
                b.classList.remove('active');
            });
            btn.classList.add('active');

            const cards = document.querySelectorAll('#slots-grid-list .slot-card');
            
            cards.forEach(card => {
                if (category === 'all') {
                    card.style.display = 'block';
                } else {
                    const cats = card.getAttribute('data-category').split(' ');
                    if (cats.includes(category)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
            
            showToast("Filtered category: " + btn.textContent.trim() + " 🎰");
        }

        // Drone / Aviator game redirect launcher
        window.launchDroneGame = function(e) {
            if (e) e.preventDefault();
            showToast("Launching 1xAERO (Crash Flight)... ✈️");
            setTimeout(() => {
                window.location.href = "{{ route('play') }}";
            }, 800);
        }

        // Demo redirect alert for slots
        window.demoGameRedirect = function(gameName) {
            showToast("Demo Mode for " + gameName + " is loading... 🎰");
            setTimeout(() => {
                if (gameName === 'bonbonbonanza') {
                    window.location.href = "{{ route('bonbon-bonanza') }}";
                } else {
                    window.location.href = "{{ route('play') }}";
                }
            }, 1000);
        }

        // User Cabinet toggle panel (Lobby vs Dashboard Cabinet)
        window.toggleCabinet = function(show) {
            const lobbySec = document.getElementById('casino-lobby-section');
            const cabinetSec = document.getElementById('user-cabinet-section');
            const navCasino = document.querySelector('.dashboard-header-nav .active');
            const navCabinet = document.querySelector('.nav-btn-cabinet');

            if (show) {
                lobbySec.style.display = 'none';
                cabinetSec.style.display = 'block';
                if (navCasino) navCasino.classList.remove('active');
                if (navCabinet) navCabinet.style.borderColor = '#007bff';
                
                // Fetch dynamic logs to keep cabinet fresh
                loadUserTransactions();
                loadUserReferrals();
            } else {
                lobbySec.style.display = 'block';
                cabinetSec.style.display = 'none';
                if (navCabinet) navCabinet.style.borderColor = '#1d3354';
                // Highlight Casino tab as active
                document.querySelectorAll('.dashboard-header-nav a').forEach(a => {
                    if (a.textContent.includes('CASINO')) {
                        a.classList.add('active');
                    } else {
                        a.classList.remove('active');
                    }
                });
            }
        }

        let betsHistory = JSON.parse(localStorage.getItem('crash_clone_history') || '[]');
        if (betsHistory.length === 0) {
            betsHistory = [
                { date: '14 Jun 2026', time: '11:45 AM', round: '839281', bet: '100.00', multiplier: '2.50x', win: '250.00', crash: '4.33x' },
                { date: '14 Jun 2026', time: '11:42 AM', round: '839280', bet: '200.00', multiplier: '1.20x', win: '240.00', crash: '1.25x' },
                { date: '14 Jun 2026', time: '11:39 AM', round: '839279', bet: '50.00', multiplier: '0.00x', win: '0.00', crash: '1.03x' }
            ];
            localStorage.setItem('crash_clone_history', JSON.stringify(betsHistory));
        }

        // Bind items on page load
        document.addEventListener("DOMContentLoaded", function() {
            loadUserTransactions();
            renderBetsHistory();
            startSlideInterval();
        });

        // CSRF Logouts
        function handleLogout(e) {
            if (e) e.preventDefault();
            document.getElementById('logout-form').submit();
        }

        // Tab Switcher Controller
        function switchDashboardTab(tabId, triggerBtn) {
            // Unactive all tabs
            document.querySelectorAll('.dashboard-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.querySelectorAll('.dashboard-tab-trigger').forEach(trigger => {
                trigger.classList.remove('active');
            });

            // Active selected tab
            document.getElementById(tabId).classList.add('active');
            triggerBtn.classList.add('active');
            
            // Re-render bets if tab-bets is loaded to capture recent play sessions
            if (tabId === 'tab-bets') {
                betsHistory = JSON.parse(localStorage.getItem('crash_clone_history') || '[]');
                renderBetsHistory();
            }
        }

        // Modals Controls
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('open');
            if (modalId === 'deposit-modal') {
                loadGatewaysForClient('deposit');
            } else if (modalId === 'withdraw-modal') {
                loadGatewaysForClient('withdraw');
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('open');
        }

        // Deposit gateway selection indicators
        function selectDepositGateway(btn) {
            document.querySelectorAll('#deposit-modal .payment-gateway-btn').forEach(b => {
                b.classList.remove('selected');
            });
            btn.classList.add('selected');
            const gatewayName = btn.getAttribute('data-gateway');
            document.getElementById('deposit-gateway').value = gatewayName;
            
            // Update gateway instructions dynamically
            const phoneStr = gatewayName === 'Rocket' ? '+880 1712 345678-9' : '+880 1712 345678';
            document.getElementById('gateway-inst-title').innerHTML = `<strong>${gatewayName}</strong> Personal Wallet detail:`;
            document.querySelector('.gateway-instructions-box').innerHTML = `
                Send Money / Cashout ${USER_CURRENCY} to: <strong>${phoneStr}</strong>.<br>
                After completing the transfer, input the transaction ID and amount below.
            `;
        }

        // Withdraw gateway selection indicators
        // Copy Affiliate Links
        function copyAffiliateLink() {
            const copyText = document.getElementById("affiliate-link-val");
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            navigator.clipboard.writeText(copyText.value);
            showToast("Affiliate Link Copied to Clipboard! 📋");
        }

        // Copy dynamic instructions text
        function copyTextToClipboard(text) {
            navigator.clipboard.writeText(text);
            showToast("Copied to Clipboard! 📋");
        }

        // Show Toast Utility
        function showToast(message) {
            const toast = document.getElementById("dashboard-toast-box");
            document.getElementById("toast-message-val").innerText = message;
            toast.classList.add("show");
            
            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        // Load gateways dynamically from backend
        let activeClientGateways = [];
        function loadGatewaysForClient(method) {
            if (method === 'withdraw') {
                const selectEl = document.getElementById('withdraw-gateway-select');
                selectEl.innerHTML = '<option value="">Loading methods...</option>';
                document.getElementById('withdraw-gateway-instructions').style.display = 'none';
                document.getElementById('withdraw-gateway-id').value = '';

                fetch('{{ route('dashboard.gateways') }}', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        activeClientGateways = data.gateways;
                        const filtered = activeClientGateways.filter(g => g.methods === 'both' || g.methods === 'withdraw');
                        
                        if (filtered.length === 0) {
                            selectEl.innerHTML = '<option value="">No active withdrawal methods found</option>';
                            return;
                        }

                        selectEl.innerHTML = '<option value="">Choose Method...</option>' + 
                            filtered.map(g => `<option value="${g.id}">${escHtml(g.name)}</option>`).join('');
                    }
                })
                .catch(() => {
                    selectEl.innerHTML = '<option value="">Failed to load methods</option>';
                });
                return;
            }

            const grid = document.getElementById('deposit-gateways-list');
            grid.innerHTML = '<div style="font-size:12px; color:var(--text-muted);"><i class="fas fa-spinner fa-spin"></i> Loading payment gateways...</div>';
            document.getElementById('deposit-gateway-instructions').style.display = 'none';
            document.getElementById('deposit-dynamic-fields').innerHTML = '';

            fetch('{{ route('dashboard.gateways') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    activeClientGateways = data.gateways;
                    const filtered = activeClientGateways.filter(g => g.methods === 'both' || g.methods === 'deposit');
                    
                    if (filtered.length === 0) {
                        grid.innerHTML = '<div style="font-size:12px; color:var(--text-muted);">No active gateways found.</div>';
                        return;
                    }

                    grid.innerHTML = filtered.map(g => `
                        <div class="payment-gateway-btn" data-id="${g.id}" onclick="selectClientGateway('deposit', ${g.id}, this)" style="border:2px solid rgba(255,255,255,0.08); border-radius:12px; padding:10px; cursor:pointer; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; width:90px; height:60px; transition:all 0.2s;">
                            ${g.logo ? `<img src="${g.logo}" style="max-width:100%; max-height:100%; object-fit:contain;">` : `<span style="font-weight:700; font-size:12px; color:#fff;">${g.name}</span>`}
                        </div>
                    `).join('');
                }
            })
            .catch(() => {
                grid.innerHTML = '<div style="font-size:12px; color:var(--color-red);">Failed to load payment gateways.</div>';
            });
        }

        // Select client gateway logo (for deposit)
        function selectClientGateway(method, id, btn) {
            document.querySelectorAll(`#${method}-gateways-list .payment-gateway-btn`).forEach(b => {
                b.style.border = '2px solid rgba(255,255,255,0.08)';
                b.style.background = 'rgba(255,255,255,0.02)';
            });
            btn.style.border = '2px solid var(--color-purple)';
            btn.style.background = 'rgba(124, 58, 237, 0.08)';

            document.getElementById(method + '-gateway-id').value = id;

            const gateway = activeClientGateways.find(g => g.id == id);
            if (!gateway) return;

            const instructionsContainer = document.getElementById(method + '-gateway-instructions');
            const instructionsBox = document.getElementById(method + '-instructions-box');
            
            const settings = gateway.settings || [];
            if (settings.length > 0) {
                instructionsBox.innerHTML = settings.map(s => `
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.05); gap:12px;">
                        <span style="font-size:12.5px; color:var(--text-secondary); text-align:left;">
                            ${escHtml(s.label)}: <strong style="color:#fff; font-family:'Roboto Mono',monospace;">${escHtml(s.value)}</strong>
                        </span>
                        <button type="button" onclick="copyTextToClipboard('${escHtml(s.value)}')" style="background:var(--color-purple); color:#fff; border:none; padding:4px 10px; border-radius:6px; font-size:10px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                `).join('');
                instructionsContainer.style.display = 'block';
            } else {
                instructionsContainer.style.display = 'none';
            }

        }

        // Select client withdraw gateway (from dropdown)
        function selectClientWithdrawGateway(id) {
            document.getElementById('withdraw-gateway-id').value = id;
            if (!id) {
                document.getElementById('withdraw-gateway-instructions').style.display = 'none';
                return;
            }

            const gateway = activeClientGateways.find(g => g.id == id);
            if (!gateway) return;

            const instructionsContainer = document.getElementById('withdraw-gateway-instructions');
            const instructionsBox = document.getElementById('withdraw-instructions-box');
            
            const settings = gateway.settings || [];
            if (settings.length > 0) {
                instructionsBox.innerHTML = settings.map(s => `
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.05); gap:12px;">
                        <span style="font-size:12.5px; color:var(--text-secondary); text-align:left;">
                            ${escHtml(s.label)}: <strong style="color:#fff; font-family:'Roboto Mono',monospace;">${escHtml(s.value)}</strong>
                        </span>
                        <button type="button" onclick="copyTextToClipboard('${escHtml(s.value)}')" style="background:var(--color-purple); color:#fff; border:none; padding:4px 10px; border-radius:6px; font-size:10px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                `).join('');
                instructionsContainer.style.display = 'block';
            } else {
                instructionsContainer.style.display = 'none';
            }
        }

        // Render Tables Helper Functions
        function renderTransactions() {
            const tbodyRecent = document.getElementById('tbody-recent-transactions');
            const tbodyAll = document.getElementById('tbody-all-transactions');
            const emptyRecent = document.getElementById('recent-transactions-empty');
            const emptyAll = document.getElementById('all-transactions-empty');

            if (!transactions || transactions.length === 0) {
                if(tbodyRecent) tbodyRecent.innerHTML = '';
                if(tbodyAll) tbodyAll.innerHTML = '';
                if(emptyRecent) emptyRecent.style.display = 'block';
                if(emptyAll) emptyAll.style.display = 'block';
                return;
            }

            if(emptyRecent) emptyRecent.style.display = 'none';
            if(emptyAll) emptyAll.style.display = 'none';

            let allHtml = '';
            transactions.forEach(t => {
                const typeClass = t.type.includes('Deposit') ? 'type-text-deposit' : (t.type.includes('Withdraw') ? 'type-text-withdraw' : 'type-text-transfer');
                const statClass = t.status === 'Completed' ? 'status-completed' : (t.status === 'Pending' ? 'status-pending' : 'status-failed');
                
                allHtml += `
                    <tr>
                        <td>${t.datetime}</td>
                        <td class="${typeClass}">${t.type}</td>
                        <td>${t.gateway}</td>
                        <td class="text-gold">${USER_SYMBOL} ${parseFloat(t.amount).toFixed(2)}</td>
                        <td><span class="status-badge ${statClass}">${t.status}</span></td>
                    </tr>
                `;
            });
            if(tbodyAll) tbodyAll.innerHTML = allHtml;

            let recentHtml = '';
            const recentTrans = transactions.slice(0, 4);
            recentTrans.forEach(t => {
                const typeClass = t.type.includes('Deposit') ? 'type-text-deposit' : (t.type.includes('Withdraw') ? 'type-text-withdraw' : 'type-text-transfer');
                const statClass = t.status === 'Completed' ? 'status-completed' : (t.status === 'Pending' ? 'status-pending' : 'status-failed');
                
                recentHtml += `
                    <tr>
                        <td>${t.datetime}</td>
                        <td class="${typeClass}">${t.type}</td>
                        <td>${t.gateway}</td>
                        <td class="text-gold">${USER_SYMBOL} ${parseFloat(t.amount).toFixed(2)}</td>
                        <td><span class="status-badge ${statClass}">${t.status}</span></td>
                    </tr>
                `;
            });
            if(tbodyRecent) tbodyRecent.innerHTML = recentHtml;
        }

        function loadUserTransactions() {
            fetch('{{ route('dashboard.transactions') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    transactions = data.transactions;
                    renderTransactions();
                }
            })
            .catch(() => {});
        }

        function loadUserReferrals() {
            fetch('{{ route('dashboard.referrals') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Update Referral earnings widget
                    document.getElementById('affiliate-earnings-widget').innerText = USER_SYMBOL + ' ' + parseFloat(data.total_earnings).toLocaleString('en-US', {minimumFractionDigits: 2});
                    document.getElementById('affiliate-count-widget').innerText = data.referrals.length;

                    // Render referred accounts table
                    const tbody = document.querySelector('#tab-referral table tbody');
                    
                    if (data.referrals.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-table-placeholder" style="display:block;"><i class="fas fa-users-slash"></i><p>No referrals found yet. Share your link to start earning!</p></div></td></tr>`;
                        return;
                    }

                    tbody.innerHTML = data.referrals.map(u => `
                        <tr>
                            <td>
                                <div><strong style="color:#fff;">${escHtml(u.name)}</strong></div>
                                <div style="font-size:11px; color:var(--text-muted);">${escHtml(u.email)} / ${escHtml(u.mobile)}</div>
                            </td>
                            <td>${u.joined_date}</td>
                            <td><span class="status-badge status-completed" style="background:rgba(124,58,237,0.15); color:#a78bfa; border:1px solid rgba(124,58,237,0.2);">${u.level}</span></td>
                            <td class="text-gold">${USER_SYMBOL} ${parseFloat(u.commission).toFixed(2)}</td>
                        </tr>
                    `).join('');
                }
            })
            .catch(() => {});
        }

        function renderBetsHistory() {
            const tbody = document.getElementById('tbody-personal-bets');
            const empty = document.getElementById('personal-bets-empty');

            if (betsHistory.length === 0) {
                tbody.innerHTML = '';
                empty.style.display = 'block';
                return;
            }

            empty.style.display = 'none';
            let html = '';
            betsHistory.forEach(b => {
                const isLoss = parseFloat(b.win) === 0;
                const winStyle = isLoss ? 'color: var(--color-red);' : 'color: var(--color-green); font-weight: 700;';
                
                html += `
                    <tr>
                        <td>${b.date}</td>
                        <td>${b.time}</td>
                        <td>#${b.round}</td>
                        <td>${USER_SYMBOL} ${parseFloat(b.bet).toFixed(2)}</td>
                        <td>${b.multiplier}</td>
                        <td style="${winStyle}">${USER_SYMBOL} ${parseFloat(b.win).toFixed(2)}</td>
                        <td class="text-gold">${b.crash}</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        // Format dates into readable string
        function getFormattedDateTime() {
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const now = new Date();
            const day = now.getDate().toString().padStart(2, '0');
            const monthStr = months[now.getMonth()];
            const year = now.getFullYear();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // hour 0 should be 12
            const hoursStr = hours.toString().padStart(2, '0');
            return `${day} ${monthStr} ${year}, ${hoursStr}:${minutes} ${ampm}`;
        }

        // Update balances elements
        function updateBalancesUI(newBalance) {
            document.querySelectorAll('.header-balance-value').forEach(el => {
                el.innerText = newBalance;
            });
            document.querySelectorAll('.widget-balance-val').forEach(el => {
                el.innerText = newBalance;
            });
            // Also update local storage if client-side game uses it
            localStorage.setItem('crash_clone_balance', newBalance);
        }

        // ==============================================
        // AJAX Operations handlers                      
        // ==============================================
        
        // Form Deposit submit
        function handleDepositSubmit(e) {
            e.preventDefault();
            const gatewayId = document.getElementById('deposit-gateway-id').value;
            if (!gatewayId) {
                alert("Please select a payment gateway logo.");
                return;
            }

            const amount = document.getElementById('deposit-amount').value;
            const btn = document.getElementById('btn-deposit-submit');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Request...';

            const formData = new FormData(e.target);
            formData.append('gateway_id', gatewayId);
            formData.append('amount', amount);

            fetch('{{ route('dashboard.deposit') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST';
                
                if (res.status === 200 && res.body.success) {
                    closeModal('deposit-modal');
                    updateBalancesUI(res.body.balance);
                    showToast(res.body.message);
                    
                    // Clear inputs
                    document.getElementById('deposit-form').reset();
                    document.getElementById('deposit-gateway-id').value = '';

                    loadUserTransactions();
                } else {
                    const errors = res.body.errors || ['Deposit failed. Please try again.'];
                    alert(errors.join('\n'));
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST';
                alert('Network connection error. Please try again later.');
            });
        }

        // Form Withdraw submit
        function handleWithdrawSubmit(e) {
            e.preventDefault();
            const gatewayId = document.getElementById('withdraw-gateway-id').value;
            if (!gatewayId) {
                alert("Please select a payment gateway logo.");
                return;
            }

            const amount = document.getElementById('withdraw-amount').value;
            const account = document.getElementById('withdraw-account').value;
            const note = document.getElementById('withdraw-note').value;
            const btn = document.getElementById('btn-withdraw-submit');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Securing Funds...';

            fetch('{{ route('dashboard.withdraw') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ gateway_id: gatewayId, amount: amount, account_number: account, note: note })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL';
                
                if (res.status === 200 && res.body.success) {
                    closeModal('withdraw-modal');
                    updateBalancesUI(res.body.balance);
                    showToast(res.body.message);
                    
                    // Clear inputs
                    document.getElementById('withdraw-amount').value = '';
                    document.getElementById('withdraw-account').value = '';
                    document.getElementById('withdraw-note').value = '';
                    document.getElementById('withdraw-gateway-id').value = '';

                    loadUserTransactions();
                } else {
                    const errors = res.body.errors || ['Withdrawal failed.'];
                    alert(errors.join('\n'));
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL';
                alert('Network connection error.');
            });
        }

        // Form P2P transfer submit
        function handleP2PTransfer(e) {
            e.preventDefault();
            const recipient = document.getElementById('transfer-recipient').value;
            const amount = document.getElementById('transfer-amount').value;
            const password = document.getElementById('transfer-password').value;
            const btn = document.getElementById('btn-transfer-submit');
            const alertBox = document.getElementById('dashboard-global-alert');
            
            alertBox.style.display = 'none';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executing Escrow...';

            fetch('{{ route('dashboard.transfer') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ recipient: recipient, amount: amount, password: password })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM ESCROW TRANSFER';
                
                if (res.status === 200 && res.body.success) {
                    updateBalancesUI(res.body.balance);
                    showToast(res.body.message);
                    
                    // Display success banner
                    alertBox.className = 'dashboard-alert-banner alert-success';
                    alertBox.innerHTML = `<i class="fas fa-circle-check"></i> ${res.body.message}`;
                    alertBox.style.display = 'flex';
                    
                    // Clear inputs
                    document.getElementById('transfer-recipient').value = '';
                    document.getElementById('transfer-amount').value = '';
                    document.getElementById('transfer-password').value = '';

                    loadUserTransactions();
                } else {
                    const errors = res.body.errors || ['Transfer failed.'];
                    alertBox.className = 'dashboard-alert-banner alert-error';
                    alertBox.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${errors.join('<br>')}`;
                    alertBox.style.display = 'flex';
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM ESCROW TRANSFER';
                alert('Transfer error occurred.');
            });
        }

        // Form Profile edit submit
        function handleProfileEdit(e) {
            e.preventDefault();
            const name = document.getElementById('profile-name').value;
            const gender = document.getElementById('profile-gender').value;
            const country = document.getElementById('profile-country').value;
            const btn = document.getElementById('btn-profile-submit');
            const alertBox = document.getElementById('dashboard-global-alert');
            
            alertBox.style.display = 'none';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            fetch('{{ route('dashboard.update-profile') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: name, gender: gender, country: country })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> SAVE PROFILE CHANGES';
                
                if (res.status === 200 && res.body.success) {
                    showToast(res.body.message);
                    
                    // Update frontend displays
                    document.getElementById('overview-profile-name').innerText = name;
                    
                    // Display success banner
                    alertBox.className = 'dashboard-alert-banner alert-success';
                    alertBox.innerHTML = `<i class="fas fa-circle-check"></i> ${res.body.message}`;
                    alertBox.style.display = 'flex';
                } else {
                    const errors = res.body.errors || ['Profile update failed.'];
                    alertBox.className = 'dashboard-alert-banner alert-error';
                    alertBox.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${errors.join('<br>')}`;
                    alertBox.style.display = 'flex';
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> SAVE PROFILE CHANGES';
                alert('Connection error saving profile details.');
            });
        }

        // Form Password change submit
        function handlePasswordChange(e) {
            e.preventDefault();
            const name = document.getElementById('profile-name').value;
            const gender = document.getElementById('profile-gender').value;
            const country = document.getElementById('profile-country').value;
            const oldPass = document.getElementById('pass-current').value;
            const newPass = document.getElementById('pass-new').value;
            const newPassConf = document.getElementById('pass-confirm').value;
            const btn = document.getElementById('btn-password-submit');
            const alertBox = document.getElementById('dashboard-global-alert');
            
            alertBox.style.display = 'none';
            
            if (newPass !== newPassConf) {
                alertBox.className = 'dashboard-alert-banner alert-error';
                alertBox.innerHTML = `<i class="fas fa-circle-exclamation"></i> Password confirmation does not match.`;
                alertBox.style.display = 'flex';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Securing password...';

            fetch('{{ route('dashboard.update-profile') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    name: name, 
                    gender: gender, 
                    country: country, 
                    old_password: oldPass, 
                    new_password: newPass, 
                    new_password_confirmation: newPassConf 
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock"></i> UPDATE PASSWORD';
                
                if (res.status === 200 && res.body.success) {
                    showToast('Security Password updated successfully!');
                    
                    // Display success banner
                    alertBox.className = 'dashboard-alert-banner alert-success';
                    alertBox.innerHTML = `<i class="fas fa-circle-check"></i> Security Password updated successfully!`;
                    alertBox.style.display = 'flex';
                    
                    // Clear passwords inputs
                    document.getElementById('pass-current').value = '';
                    document.getElementById('pass-new').value = '';
                    document.getElementById('pass-confirm').value = '';
                } else {
                    const errors = res.body.errors || ['Password update failed.'];
                    alertBox.className = 'dashboard-alert-banner alert-error';
                    alertBox.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${errors.join('<br>')}`;
                    alertBox.style.display = 'flex';
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock"></i> UPDATE PASSWORD';
                alert('Connection error saving new password.');
            });
        }
    </script>

    <!-- Floating Live Support Chat Widget -->
    <div class="live-chat-widget" id="live-chat-widget">
        <!-- Chat Trigger Floating Button -->
        <button class="chat-trigger-btn" id="chat-trigger-btn" aria-label="Open support chat">
            <i class="fas fa-headset"></i>
            <span class="chat-pulse-ring"></span>
        </button>

        <!-- Chat Chatbox Container -->
        <div class="chat-box-container hidden" id="chat-box-container">
            <!-- Chat Header -->
            <div class="chat-box-header">
                <div class="chat-agent-profile">
                    <div class="chat-agent-avatar">
                        <i class="fas fa-user-astronaut"></i>
                        <span class="agent-online-dot"></span>
                    </div>
                    <div class="chat-agent-info">
                        <h4 class="agent-name">Aviator Support</h4>
                        <span class="agent-status">Online Support Agent</span>
                    </div>
                </div>
                <button class="chat-box-close" id="chat-box-close" aria-label="Close chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Chat Message List Body -->
            <div class="chat-box-body" id="chat-box-body">
                <div class="chat-msg msg-agent">
                    <div class="msg-bubble">
                        Hello! 👋 Welcome back, {{ auth()->user()->name }}! How can we assist you with your dashboard, wallets, or bets today?
                    </div>
                    <span class="msg-time">Just now</span>
                </div>
                <div class="chat-quick-options">
                    <span class="quick-option-title">Suggested Questions:</span>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How do I withdraw BDT?')">How do I withdraw BDT?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('Is P2P transfer safe?')">Is P2P transfer safe?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How do I level up?')">How do I level up?</button>
                </div>
            </div>

            <!-- Chat Input Footer -->
            <form class="chat-box-footer" id="chat-send-form" onsubmit="handleChatSubmit(event)">
                <input type="text" class="chat-input-field" id="chat-input-field" placeholder="Write a message..." autocomplete="off">
                <button type="submit" class="chat-send-btn" aria-label="Send message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Script for chat controller -->
    <script>
    (function() {
        const triggerBtn = document.getElementById('chat-trigger-btn');
        const closeBtn = document.getElementById('chat-box-close');
        const boxContainer = document.getElementById('chat-box-container');
        const chatForm = document.getElementById('chat-send-form');
        const inputField = document.getElementById('chat-input-field');
        const chatBody = document.getElementById('chat-box-body');

        const isAuth = true; // Always authenticated in customer dashboard
        let pollInterval = null;

        function toggleChat() {
            boxContainer.classList.toggle('hidden');
            scrollChatToBottom();
            if (isAuth && !boxContainer.classList.contains('hidden')) {
                loadSupportMessages();
                // Start polling when chat is open
                if (!pollInterval) {
                    pollInterval = setInterval(loadSupportMessages, 3000);
                }
            } else {
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }
            }
        }

        if (triggerBtn) triggerBtn.addEventListener('click', toggleChat);
        if (closeBtn) closeBtn.addEventListener('click', toggleChat);

        function scrollChatToBottom() {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function loadSupportMessages() {
            fetch('{{ route('support.messages') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderSupportMessages(data.messages);
                }
            })
            .catch(err => console.error("Error loading support messages:", err));
        }

        function renderSupportMessages(messages) {
            let html = `
                <div class="chat-msg msg-agent">
                    <div class="msg-bubble">
                        Hello! 👋 Welcome back, {{ auth()->user()->name }}! How can we assist you with your dashboard, wallets, or bets today?
                    </div>
                    <span class="msg-time">Just now</span>
                </div>
            `;

            messages.forEach(msg => {
                const senderClass = msg.sender === 'user' ? 'user' : 'agent';
                html += `
                    <div class="chat-msg msg-${senderClass}">
                        <div class="msg-bubble">${escHtml(msg.message)}</div>
                        <span class="msg-time">${msg.time}</span>
                    </div>
                `;
            });

            if (messages.length === 0) {
                html += `
                    <div class="chat-quick-options">
                        <span class="quick-option-title">Suggested Questions:</span>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How do I withdraw BDT?')">How do I withdraw BDT?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('Is P2P transfer safe?')">Is P2P transfer safe?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How do I level up?')">How do I level up?</button>
                    </div>
                `;
            }

            const currentCount = chatBody.querySelectorAll('.chat-msg').length;
            const newCount = messages.length + 1;

            if (currentCount !== newCount) {
                chatBody.innerHTML = html;
                scrollChatToBottom();
            }
        }

        function escHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;")
                      .replace(/</g, "&lt;")
                      .replace(/>/g, "&gt;")
                      .replace(/"/g, "&quot;")
                      .replace(/'/g, "&#039;");
        }

        window.sendQuickMessage = function(text) {
            if (isAuth) {
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();
                
                setTimeout(() => {
                    typing.remove();
                    let reply = `Thank you for reaching out. An agent will be with you shortly. Your transaction history and balances are processed securely.`;
                    if (text.includes('withdraw')) {
                        reply = `To withdraw, click 'Withdraw' in your balance widget. Input your personal mobile number (bKash/Nagad/Rocket) and submit. It takes 1-5 minutes to complete with zero commission.`;
                    } else if (text.includes('safe')) {
                        reply = `Yes, P2P Escrow transfers are 100% safe. Funds are shifted directly inside the server database and secured using your account password verification.`;
                    } else if (text.includes('level')) {
                        reply = `You level up automatically based on your total betting volume. Check the 'Levels Manage' tab above to see your progression, required volume, and unlocked benefits.`;
                    }
                    appendMessage(reply, 'agent');
                }, 1000);
            }
        };

        window.handleChatSubmit = function(e) {
            e.preventDefault();
            const text = inputField.value.trim();
            if (!text) return;

            inputField.value = '';

            if (isAuth) {
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();

                setTimeout(() => {
                    typing.remove();
                    appendMessage("Thank you for your message! Our support team is online 24/7. An agent will respond to your query right here in a moment.", 'agent');
                }, 1200);
            }
        };

        function sendDatabaseMessage(text) {
            fetch('{{ route('support.messages.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: text })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    loadSupportMessages();
                }
            })
            .catch(err => console.error("Error sending message:", err));
        }

        function appendMessage(text, sender) {
            const msgDiv = document.createElement('div');
            msgDiv.className = `chat-msg msg-${sender}`;
            msgDiv.innerHTML = `
                <div class="msg-bubble">${escHtml(text)}</div>
                <span class="msg-time">Just now</span>
            `;
            const options = chatBody.querySelector('.chat-quick-options');
            if (options && sender === 'user') {
                chatBody.insertBefore(msgDiv, options);
            } else {
                chatBody.appendChild(msgDiv);
            }
            scrollChatToBottom();
        }

        function showTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.className = 'typing-indicator';
            indicator.innerHTML = `
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            `;
            chatBody.appendChild(indicator);
            scrollChatToBottom();
            return indicator;
        }

        if (isAuth && !boxContainer.classList.contains('hidden')) {
            loadSupportMessages();
            pollInterval = setInterval(loadSupportMessages, 3000);
        }
    })();
    </script>

    <!-- Hidden CSRF-safe logout form -->
    <form id="customer-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <script>
        // Customer logout — clears session properly via Laravel POST route
        function handleLogout(e) {
            e.preventDefault();
            // Clear any local state
            localStorage.removeItem('crash_is_logged_in');
            localStorage.removeItem('crash_username');
            localStorage.removeItem('crash_clone_balance');
            // Submit the CSRF-safe logout form
            document.getElementById('customer-logout-form').submit();
        }

        function updateCustomerThemeUI(theme) {
            const btnIcon = document.getElementById('theme-icon');
            if (!btnIcon) return;
            if (theme === 'light') {
                btnIcon.className = 'fas fa-moon';
            } else {
                btnIcon.className = 'fas fa-sun';
            }
        }

        function toggleCustomerTheme() {
            const isLight = document.documentElement.classList.contains('light-theme');
            let newTheme = 'dark';
            if (isLight) {
                document.documentElement.classList.remove('light-theme');
                document.body.classList.remove('light-theme');
                newTheme = 'dark';
            } else {
                document.documentElement.classList.add('light-theme');
                document.body.classList.add('light-theme');
                newTheme = 'light';
            }
            updateCustomerThemeUI(newTheme);

            fetch('{{ route('dashboard.update-theme') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ theme: newTheme })
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = '{{ auth()->user()->theme ?: 'dark' }}';
            updateCustomerThemeUI(currentTheme);
        });
    </script>
</body>
</html>
