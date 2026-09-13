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
<body class="landing-body theme-Bettingsite-active {{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

    @include('customer.header')

    <!-- Main Workspace with Bettingsite Style Layout -->
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
                @php
                    $activeSliders = \App\Models\Slider::active()->get();
                    if($activeSliders->isEmpty()) {
                        $activeSliders = collect([
                            (object)[
                                'title' => 'SPINOLEAGUE TOURNAMENT',
                                'subtitle' => '05.03.2026 - 01.03.2027',
                                'badge_text' => '05.03.2026 - 01.03.2027',
                                'prize_text' => 'STAND BY THE CHAMPIONS | PRIZE POOL: <span>€12,000,000</span>',
                                'button_text' => 'PLAY NOW',
                                'button_url' => route('play'),
                                'image' => 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?q=80&w=1200&auto=format&fit=crop',
                                'bg_gradient' => 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)'
                            ]
                        ]);
                    }
                @endphp

                @foreach($activeSliders as $idx => $slide)
                    <div class="banner-slide {{ $idx === 0 ? 'slide-active' : '' }}" id="slide-{{ $idx }}">
                        <div class="banner-slide-bg" style="background-image: {{ $slide->bg_gradient ?? 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)' }}, url('{{ $slide->image }}');"></div>
                        <div class="banner-content">
                            @if(!empty($slide->badge_text ?? $slide->subtitle))
                                <span class="banner-date">{{ $slide->badge_text ?? $slide->subtitle }}</span>
                            @endif
                            <h2 class="banner-title">{{ $slide->title }}</h2>
                            @if(!empty($slide->prize_text))
                                <p class="banner-prize">{!! $slide->prize_text !!}</p>
                            @endif
                            <a href="{{ $slide->button_url ?? route('play') }}" class="banner-play-btn" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">
                                {{ $slide->button_text ?? 'PLAY NOW' }}
                            </a>
                        </div>
                    </div>
                @endforeach

                <!-- Arrows -->
                <button class="slider-arrow arrow-left" onclick="moveSlide(-1)"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-arrow arrow-right" onclick="moveSlide(1)"><i class="fas fa-chevron-right"></i></button>

                <!-- Dots navigation -->
                <div class="slide-dots">
                    @foreach($activeSliders as $idx => $slide)
                        <span class="slide-dot {{ $idx === 0 ? 'active' : '' }}" onclick="setSlide({{ $idx }})"></span>
                    @endforeach
                </div>
            </div>

            <!-- Categories Horizontal Filter Navbar -->
            <div class="lobby-categories-navbar">
                <button class="lobby-category-btn active" onclick="filterCategory('all', this)"><i class="fas fa-fire"></i> Popular</button>
                <button class="lobby-category-btn" onclick="filterCategory('lottery', this)"><i class="fas fa-ticket-alt text-emerald-400"></i> Lottery</button>
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

                <!-- Game 1: TrxWinGo Lottery (TRON Blockchain Provably Fair) -->
                <a href="{{ route('trxwingo.index') }}" class="slot-card" data-category="lottery bangladesh popular new quick exclusive all" data-name="trxwingo trx win go tron lottery amar club color number prediction block hash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#00b977; color:#fff;">TRX</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/trxwingo.webp') }}" class="slot-card-img" alt="TrxWinGo" onerror="this.src='{{ asset('assets/image/trxwingo.png') }}'">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #00b977 0%, #047857 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-cube" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">TrxWinGo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play TrxWinGo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">TRON Public Chain</span>
                        <div class="slot-card-title">TrxWinGo Lottery</div>
                    </div>
                </a>

                <!-- Game 2: WinGo Lottery -->
                <a href="{{ route('wingo.index') }}" class="slot-card" data-category="lottery bangladesh popular new quick exclusive all" data-name="wingo lottery amar club tiranga color number prediction" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#00b977; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/wingo.webp') }}" class="slot-card-img" alt="WinGo" onerror="this.src='{{ asset('assets/image/wingo.png') }}'">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #059669 0%, #10b981 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-dice" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">WinGo Lottery</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play WinGo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amar Club</span>
                        <div class="slot-card-title">WinGo Lottery</div>
                    </div>
                </a>

                <!-- Game 2: Olympus Gold -->
                <a href="{{ route('gates-of-olympus') }}" class="slot-card" data-category="popular exclusive new quick bangladesh bonus all" data-name="olympus gold gates of olympus pragmatic play" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#ff3d00; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/GatesofOlympus.webp') }}" class="slot-card-img" alt="Olympus Gold" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #ff9800 0%, #ff5722 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-bolt" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Olympus Gold</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Olympus Gold™</div>
                    </div>
                </a>

                <!-- Game 3: Western Vault -->
                <a href="{{ route('western-vault') }}" class="slot-card" data-category="popular exclusive new quick bangladesh all" data-name="western vault pvp duel pragmatic play" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#f97316; color:#fff;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/western.webp') }}" class="slot-card-img" alt="Western Vault" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #e53935 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-vault" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Western Vault</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">PVP Vault Duel</span>
                        <div class="slot-card-title">Western Vault™</div>
                    </div>
                </a>

                <!-- Game 4: HelicopterX -->
                <a href="{{ route('play', ['game' => 'helicopterx']) }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="helicopterx 1xgames exclusive crash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/HelicopterX.webp') }}" class="slot-card-img" alt="HelicopterX" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #e65100 0%, #ff9800 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-helicopter" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">HelicopterX</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play HelicopterX</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">HelicopterX</div>
                    </div>
                </a>

                <!-- Game 5: 1xAero -->
                <a href="{{ route('play', ['game' => '1xaero']) }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="1xaero 1xgames exclusive crash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#00f2fe; color:#000;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/1xaero.webp') }}" class="slot-card-img" alt="1xAero" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #00838f 0%, #00e5ff 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-jet-fighter" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">1xAero</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play 1xAero</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">1xAero</div>
                    </div>
                </a>

                <!-- Game 6: Aero -->
                <a href="{{ route('play', ['game' => 'aero']) }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="aero 1xgames exclusive crash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#ef4444; color:#fff;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/Aero.webp') }}" class="slot-card-img" alt="Aero" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b71c1c 0%, #ef4444 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-plane" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Aero</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Aero</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">Aero</div>
                    </div>
                </a>

                <!-- Game 7: CrashX -->
                <a href="{{ route('play', ['game' => 'crashx']) }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="crashx turbo games multiplayer crash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#10b981; color:#000;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/CrashX.webp') }}" class="slot-card-img" alt="CrashX" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-rocket" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">CrashX</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play CrashX</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Multiplayer Crash</span>
                        <div class="slot-card-title">CrashX</div>
                    </div>
                </a>

                <!-- Game 8: Crash (1xGames) -->
                <a href="{{ route('play', ['game' => 'crash']) }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="crash 1xgames exclusive multiplayer crash" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#8b5cf6; color:#fff;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/crash.png') }}" class="slot-card-img" alt="Crash" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #4c1d95 0%, #8b5cf6 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-meteor" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Crash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Crash</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">Crash (1xGames)</div>
                    </div>
                </a>

                <!-- Game 9: Fortune Gems 2 -->
                <a href="{{ route('fortune-gems-2') }}" class="slot-card" data-category="bangladesh popular new chicken all" data-name="fortune gems 2 jili games cascading slot" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#ff3d00; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/fortunegems2.webp') }}" class="slot-card-img" alt="Fortune Gems 2" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #d9a443 0%, #8a5e1f 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gem" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Fortune Gems 2</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili Games</span>
                        <div class="slot-card-title">Fortune Gems 2™</div>
                    </div>
                </a>

                <!-- Game 10: Boxing King -->
                <a href="{{ route('boxing-king') }}" class="slot-card" data-category="bangladesh popular new exclusive all" data-name="boxing king jili games fighting slot" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#ff3d00; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/BoxingKing.webp') }}" class="slot-card-img" alt="Boxing King" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b81f2e 0%, #f5c542 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-crown" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Boxing King</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Jili Games</span>
                        <div class="slot-card-title">Boxing King™</div>
                    </div>
                </a>

                <!-- Game 11: Abyss of Glory -->
                <a href="{{ route('temple-of-fortune') }}" class="slot-card" data-category="popular exclusive new quick bangladesh all" data-name="abyss of glory temple of fortune golden ways original" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background: linear-gradient(135deg, #d9a443, #8a5e1f); color:#fff3cf;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/Abyss of Glory.webp') }}" class="slot-card-img" alt="Abyss of Glory" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #006064 0%, #00acc1 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-landmark" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Abyss of Glory</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Original · 243 Ways</span>
                        <div class="slot-card-title">Abyss of Glory™</div>
                    </div>
                </a>

                <!-- Game 12: Heads or Tails -->
                <a href="{{ route('heads-or-tails') }}" class="slot-card" data-category="exclusive quick bangladesh popular all" data-name="heads or tails 1xgames exclusive coin toss" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#ffbe1a; color:#000;">EXCLUSIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/HeadsorTails.webp') }}" class="slot-card-img" alt="Heads or Tails" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #caa24f 0%, #7a4e12 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Heads or Tails</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">1XGAMES EXCLUSIVE</span>
                        <div class="slot-card-title">Heads or Tails™</div>
                    </div>
                </a>

                <!-- Game 13: Lucky Joker 100 -->
                <a href="{{ route('lucky-joker-100') }}" class="slot-card" data-category="popular quick bangladesh new bonus all" data-name="lucky joker 100 amusnet spinomenal" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#f43f5e; color:#fff;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/Lucky Joker 100.webp') }}" class="slot-card-img" alt="Lucky Joker 100" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #be123c 0%, #fb7185 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-hat-cowboy-side" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Lucky Joker 100</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Spinomenal</span>
                        <div class="slot-card-title">Lucky Joker 100™</div>
                    </div>
                </a>

                <!-- Game 14: BonBon Bonanza -->
                <a href="{{ route('bonbon-bonanza') }}" class="slot-card" data-category="new popular bonus bangladesh all" data-name="bonbon bonanza pragmatic play candy cascade" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-drops" style="background: linear-gradient(135deg,#e91e8c,#f06292); color:#fff;">NEW</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/BonBon Bonanza.webp') }}" class="slot-card-img" alt="BonBon Bonanza" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #880e4f 0%, #e91e8c 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-candy-cane" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">BonBon Bonanza</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">BonBon Bonanza™</div>
                    </div>
                </a>

                <!-- Game 15: Big Bass Splash -->
                <a href="{{ route('big-bass-splash') }}" class="slot-card" data-category="popular chicken new bangladesh all" data-name="big bass splash pragmatic play fishing slot" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#0ea5e9; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/bigbass.webp') }}" class="slot-card-img" alt="Big Bass Splash" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #0369a1 0%, #38bdf8 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-fish" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Big Bass Splash</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Pragmatic Play</span>
                        <div class="slot-card-title">Big Bass Splash™</div>
                    </div>
                </a>

                <!-- Game 16: The Emirate -->
                <a href="{{ route('the-emirate') }}" class="slot-card" data-category="popular exclusive new bangladesh all" data-name="the emirate endorphina fazi luxury slot" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-hot" style="background:#f59e0b; color:#000;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/theemirate.webp') }}" class="slot-card-img" alt="The Emirate" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #b45309 0%, #fbbf24 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-gem" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">The Emirate</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Endorphina</span>
                        <div class="slot-card-title">The Emirate™</div>
                    </div>
                </a>

                <!-- Game 17: Royal Emirates -->
                <a href="{{ route('royal-emirates') }}" class="slot-card" data-category="popular exclusive new quick bangladesh all" data-name="royal emirates hold and spin slot" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#fbbf24; color:#000;">ACTIVE</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/royal&emirates.webp') }}" class="slot-card-img" alt="Royal Emirates" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #d97706 0%, #fcd34d 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-coins" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">Royal Emirates</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play Demo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Hold & Spin</span>
                        <div class="slot-card-title">Royal Emirates™</div>
                    </div>
                </a>

                <!-- Game 18: K3 Lottery -->
                <a href="{{ route('k3.index') }}" class="slot-card" data-category="popular exclusive new quick lottery bangladesh all" data-name="k3 lottery fast 3 dice game" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#10b981; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/k3.webp') }}" class="slot-card-img" alt="K3 Lottery" onerror="this.src='{{ asset('assets/image/k3.png') }}';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #059669 0%, #34d399 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-cubes" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">K3 Lottery</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play K3</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Amar Club / Fast 3</span>
                        <div class="slot-card-title">K3 Lottery™</div>
                    </div>
                </a>

                <!-- Game 19: WinGo Lottery -->
                <a href="{{ route('wingo.index') }}" class="slot-card" data-category="popular exclusive new quick lottery bangladesh all" data-name="wingo lottery color prediction" style="text-decoration:none; display:flex; flex-direction:column; cursor:pointer;">
                    <span class="slot-badge slot-badge-promo" style="background:#00b977; color:#fff;">HOT</span>
                    <div class="slot-card-image-wrapper">
                        <img src="{{ asset('assets/image/wingo.webp') }}" class="slot-card-img" alt="WinGo Lottery" onerror="this.src='{{ asset('assets/image/wingo.png') }}';">
                        <div class="slot-card-fallback-img" style="display:none; background: linear-gradient(135deg, #00b977 0%, #10b981 100%); width:100%; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#fff;">
                            <i class="fas fa-dice" style="font-size:28px; margin-bottom:8px;"></i>
                            <span style="font-size:10px; font-weight:800; text-transform:uppercase;">WinGo</span>
                        </div>
                    </div>
                    <div class="slot-card-overlay">
                        <span class="slot-play-btn"><i class="fas fa-play"></i></span>
                        <span class="slot-demo-link">Play WinGo</span>
                    </div>
                    <div class="slot-card-info">
                        <span class="slot-card-provider">Color & Number</span>
                        <div class="slot-card-title">WinGo Lottery™</div>
                    </div>
                </a>

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
        // Bettingsite CASINO LOBBY JS CONTROLS
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

        // Multi-crash game launcher
        window.launchCrashGame = function(gameKey, e) {
            if (e) e.preventDefault();
            const gameTitles = {
                'helicopterx': 'HelicopterX (1xGames Exclusive)... 🚁',
                '1xaero': '1xAero (Supersonic Flight)... ✈️',
                'aero': 'Aero (Vintage Flight)... 🛩️',
                'crashx': 'CrashX (Cyber Multiplier)... 🚀',
                'crash': 'Crash (1xGames Exclusive)... 💥'
            };
            const title = gameTitles[gameKey] || 'Crash Game... ✈️';
            showToast("Launching " + title);
            setTimeout(() => {
                window.location.href = "/play/" + (gameKey || 'helicopterx');
            }, 600);
        }

        // Drone / Aviator game redirect launcher (backward compatibility)
        window.launchDroneGame = function(e) {
            window.launchCrashGame('helicopterx', e);
        }

        // Demo redirect alert for slots
        window.demoGameRedirect = function(gameName) {
            showToast("Demo Mode for " + gameName + " is loading... 🎰");
            setTimeout(() => {
                if (gameName === 'TrxWinGo' || gameName === 'trxwingo' || gameName === 'TrxWinGo Lottery') {
                    window.location.href = "{{ route('trxwingo.index') }}";
                } else if (gameName === 'WinGo' || gameName === 'wingo' || gameName === 'WinGo Lottery') {
                    window.location.href = "{{ route('wingo.index') }}";
                } else if (gameName === 'Fortune Gems 2') {
                    window.location.href = "{{ route('fortune-gems-2') }}";
                } else if (gameName === 'Super Ace Deluxe') {
                    window.location.href = "{{ route('super-ace-deluxe') }}";
                } else if (gameName === 'Gates of Olympus') {
                    window.location.href = "{{ route('gates-of-olympus') }}";
                } else if (gameName === 'Boxing King') {
                    window.location.href = "{{ route('boxing-king') }}";
                } else if (gameName === 'bonbonbonanza' || gameName === 'BonBon Bonanza') {
                    window.location.href = "{{ route('bonbon-bonanza') }}";
                } else if (gameName === 'bigbass' || gameName === 'Big Bass Splash' || gameName === 'big-bass-splash') {
                    window.location.href = "{{ route('big-bass-splash') }}";
                } else if (gameName === 'Lucky Joker 100') {
                    window.location.href = "{{ route('lucky-joker-100') }}";
                } else if (gameName === 'theemirate') {
                    window.location.href = "{{ route('the-emirate') }}";
                } else if (gameName === 'royal&emirates') {
                    window.location.href = "{{ route('royal-emirates') }}";
                } else if (gameName === 'elveskirgoodr' || gameName === 'Elves\' Kingdom') {
                    window.location.href = "{{ route('elves-kingdom') }}";
                } else if (gameName === 'cashme' || gameName === 'Cash Me If You Can') {
                    window.location.href = "{{ route('treasure-climb') }}";
                } else if (gameName === 'western' || gameName === 'Western Heist') {
                    window.location.href = "{{ route('western') }}";
                } else if (gameName === 'temple-of-fortune' || gameName === 'Temple of Fortune') {
                    window.location.href = "{{ route('temple-of-fortune') }}";
                } else if (gameName === 'heads-or-tails' || gameName === 'Heads or Tails') {
                    window.location.href = "{{ route('heads-or-tails') }}";
                } else if (gameName === 'HelicopterX' || gameName === 'helicopterx') {
                    window.location.href = "{{ route('play', ['game' => 'helicopterx']) }}";
                } else if (gameName === '1xaero' || gameName === '1xAero') {
                    window.location.href = "{{ route('play', ['game' => '1xaero']) }}";
                } else if (gameName === 'Aero' || gameName === 'aero') {
                    window.location.href = "{{ route('play', ['game' => 'aero']) }}";
                } else if (gameName === 'CrashX' || gameName === 'crashx') {
                    window.location.href = "{{ route('play', ['game' => 'crashx']) }}";
                } else if (gameName === 'crash' || gameName === 'Crash') {
                    window.location.href = "{{ route('play', ['game' => 'crash']) }}";
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
            
            // Auto open modal or tab from URL query params
            const urlParams = new URLSearchParams(window.location.search);
            const modal = urlParams.get('modal');
            if (modal === 'deposit') {
                openModal('deposit-modal');
            } else if (modal === 'withdraw') {
                openModal('withdraw-modal');
            }
            const tab = urlParams.get('tab');
            if (tab === 'cabinet') {
                toggleCabinet(true);
            }
        });
    </script>
</body>
</html>
