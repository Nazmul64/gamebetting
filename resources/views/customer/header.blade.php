<!-- Bettingsite Style Header Nav Bar -->
<style>
.dashboard-header-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    padding: 0 24px;
    background: #0c1a30;
    border-bottom: 1.5px solid #1d3354;
    width: 100%;
    position: sticky;
    top: 0;
    z-index: 9999;
    box-sizing: border-box;
    font-family: 'Outfit', 'Inter', sans-serif;
}
.dashboard-header-nav a {
    transition: color 0.2s ease;
}
.dashboard-header-nav a:hover {
    color: #ffffff !important;
}
.dashboard-header-nav button {
    transition: transform 0.2s ease, filter 0.2s ease;
}
.dashboard-header-nav button:hover {
    transform: scale(1.02);
    filter: brightness(1.1);
}
.nav-bd-dropdown:hover .bd-dropdown-menu {
    display: block !important;
}
.bd-dropdown-menu a:hover {
    background: #142847 !important;
}

/* 1xBet Mega Menu Dropdown */
.nav-more-dropdown {
    position: relative;
}
.nav-more-dropdown:hover .mega-menu-container {
    display: grid !important;
    animation: megaMenuFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes megaMenuFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.mega-menu-container {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: -60px;
    width: 820px;
    background: #091424;
    border: 1.5px solid #1d3354;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9), 0 0 30px rgba(26, 118, 210, 0.15);
    z-index: 100000;
    padding: 20px 22px;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    font-family: 'Outfit', 'Inter', sans-serif;
}
.mega-col-title {
    font-size: 11px;
    font-weight: 800;
    color: #637b9f;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid #1d3354;
    display: flex;
    align-items: center;
    gap: 6px;
}
.mega-menu-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.mega-menu-links a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 7px 10px;
    border-radius: 6px;
    color: #cbd5e1;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.18s ease;
}
.mega-menu-links a:hover {
    background: #142847 !important;
    color: #ffffff !important;
    transform: translateX(3px);
}
.mega-menu-links a i {
    width: 16px;
    text-align: center;
    font-size: 13px;
}
.mega-badge {
    font-size: 8.5px;
    font-weight: 900;
    padding: 2px 5px;
    border-radius: 4px;
    margin-left: auto;
    text-transform: uppercase;
}

/* Mobile Toggle Hamburger Button */
.mobile-nav-toggle {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 6px;
    background: #15253e;
    border: 1px solid #1d3354;
    color: #ffffff;
    font-size: 17px;
    cursor: pointer;
    margin-right: 8px;
    transition: all 0.2s ease;
}
.mobile-nav-toggle:hover {
    background: #1d3354;
    color: #1a76d2;
}

@media (max-width: 1100px) {
    .dashboard-nav-links {
        display: none !important;
    }
    .mobile-nav-toggle {
        display: inline-flex !important;
    }
}

@media (max-width: 768px) {
    .dashboard-header-nav {
        position: sticky !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 52px !important;
        padding: 0 8px !important;
        z-index: 99999 !important;
    }
    .mobile-nav-toggle {
        width: 32px !important;
        height: 32px !important;
        font-size: 15px !important;
        margin-right: 6px !important;
        flex-shrink: 0;
    }
    .logo-text {
        font-size: 18px !important;
    }
    .dashboard-nav-actions {
        gap: 5px !important;
        flex-shrink: 0;
    }
    .balance-container {
        padding: 0 6px !important;
        height: 30px !important;
        gap: 3px !important;
    }
    .balance-label {
        display: none !important;
    }
    .balance-value {
        font-size: 12px !important;
    }
    .balance-currency {
        font-size: 9.5px !important;
    }
    .nav-btn-deposit, .nav-btn-withdraw {
        height: 30px !important;
        padding: 0 8px !important;
        font-size: 10px !important;
        font-weight: 800 !important;
        border-radius: 4px !important;
        flex-shrink: 0 !important;
        white-space: nowrap !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .nav-btn-deposit i, .nav-btn-withdraw i {
        margin-right: 3px !important;
        font-size: 10px !important;
    }
    /* Hide cabinet & logout icon from header on mobile to prevent overflow (already in bottom bar and toggle drawer) */
    .nav-btn-cabinet, .nav-btn-logout {
        display: none !important;
    }
    .nav-btn-login, .nav-btn-register {
        height: 30px !important;
        padding: 0 8px !important;
        font-size: 10.5px !important;
        flex-shrink: 0 !important;
    }
}

@media (max-width: 360px) {
    .dashboard-header-nav {
        padding: 0 4px !important;
    }
    .logo-text {
        font-size: 16px !important;
    }
    .dashboard-nav-actions {
        gap: 3px !important;
    }
    .nav-btn-deposit, .nav-btn-withdraw {
        padding: 0 5px !important;
        font-size: 9px !important;
    }
    .balance-container {
        padding: 0 4px !important;
    }
    .balance-value {
        font-size: 11px !important;
    }
}

/* =========================================================
   MOBILE SLIDE-OUT DRAWER / TOGGLE MENU STYLES
   ========================================================= */
.mobile-drawer-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(4, 10, 20, 0.75);
    backdrop-filter: blur(4px);
    z-index: 100000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.mobile-drawer-backdrop.open {
    opacity: 1;
    visibility: visible;
}

.mobile-nav-drawer {
    position: fixed;
    top: 0;
    left: 0;
    width: 310px;
    max-width: 85vw;
    height: 100vh;
    background: #0a1628;
    border-right: 1.5px solid #1d3354;
    z-index: 100001;
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    box-shadow: 10px 0 30px rgba(0, 0, 0, 0.8);
    font-family: 'Outfit', 'Inter', sans-serif;
}
.mobile-nav-drawer.open {
    transform: translateX(0);
}

.drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 18px;
    background: #0d1e38;
    border-bottom: 1px solid #1d3354;
}
.drawer-close-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.drawer-close-btn:hover {
    background: rgba(235, 64, 52, 0.2);
    color: #ff5447;
    border-color: rgba(235, 64, 52, 0.4);
}

.drawer-body {
    flex: 1;
    overflow-y: auto;
    padding: 16px 14px;
    scrollbar-width: thin;
    scrollbar-color: #1d3354 #0a1628;
}
.drawer-body::-webkit-scrollbar {
    width: 4px;
}
.drawer-body::-webkit-scrollbar-thumb {
    background: #1d3354;
    border-radius: 4px;
}

/* User profile card in drawer */
.drawer-user-card {
    background: #11223b;
    border: 1px solid #1d3354;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 16px;
}
.drawer-user-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}
.drawer-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a76d2, #00c6ff);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
}
.drawer-user-name {
    font-size: 14px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.2;
}
.drawer-user-email {
    font-size: 11px;
    color: #8ca3c7;
}
.drawer-balance-badge {
    background: #091322;
    border: 1px solid #1d3354;
    border-radius: 6px;
    padding: 8px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.drawer-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.drawer-action-btn {
    padding: 9px 0;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 800;
    cursor: pointer;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-decoration: none;
    transition: all 0.2s ease;
}

/* Guest login card in drawer */
.drawer-guest-card {
    background: #11223b;
    border: 1px solid #1d3354;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 16px;
    text-align: center;
}

/* Drawer Section Groups */
.drawer-section-title {
    font-size: 10px;
    font-weight: 800;
    color: #637b9f;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 16px 6px 8px 6px;
}
.drawer-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.drawer-nav-item a,
.drawer-nav-item button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 10px 12px;
    background: transparent;
    border: none;
    border-radius: 8px;
    color: #c0d1eb;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    text-align: left;
    cursor: pointer;
    transition: all 0.2s ease;
}
.drawer-nav-item a:hover,
.drawer-nav-item button:hover,
.drawer-nav-item.active a {
    background: #142847;
    color: #ffffff;
}
.drawer-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.drawer-item-icon {
    width: 22px;
    font-size: 14px;
    text-align: center;
    color: #1a76d2;
}
.drawer-item-badge {
    font-size: 8.5px;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 4px;
    text-transform: uppercase;
}

.drawer-footer {
    padding: 12px 14px;
    border-top: 1px solid #1d3354;
    background: #091322;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
</style>

<!-- Top Header Navigation -->
<nav class="dashboard-header-nav">
    <div class="dashboard-nav-logo" style="display: flex; align-items: center;">
        <!-- Mobile Toggle Hamburger Menu Button -->
        <button class="mobile-nav-toggle" onclick="toggleMobileDrawer(true)" aria-label="Open navigation menu">
            <i class="fas fa-bars"></i>
        </button>

        @php
            $customSiteLogo = \App\Models\Setting::getVal('site_logo');
            $customSiteName = \App\Models\Setting::getVal('site_name', '1XBET');
        @endphp
        <a href="{{ route('dashboard') }}" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
            @if($customSiteLogo && file_exists(public_path($customSiteLogo)))
                <img src="{{ asset($customSiteLogo) }}" alt="{{ $customSiteName }}" style="max-height: 38px; max-width: 160px; object-fit: contain;">
            @else
                <span class="logo-text" style="font-style: italic; font-weight: 900; font-size: 24px; letter-spacing: -0.5px; color: #1a76d2; text-shadow: 0 0 10px rgba(26, 118, 210, 0.3); text-transform: uppercase;">
                    @if(str_starts_with(strtoupper($customSiteName), '1X'))
                        <span style="color: #ffffff;">1X</span>{{ substr($customSiteName, 2) }}
                    @else
                        <span style="color: #ffffff;">{{ substr($customSiteName, 0, 2) }}</span>{{ substr($customSiteName, 2) }}
                    @endif
                </span>
            @endif
        </a>
    </div>
    
    <!-- Desktop Navigation Links -->
    <ul class="dashboard-nav-links" style="display: flex; list-style: none; gap: 16px; font-size: 13px; font-weight: 700; margin: 0; padding: 0; align-items: center;">
        <!-- BANGLADESH TOP PICKS DROPDOWN -->
        <li class="nav-bd-dropdown" style="position: relative;">
            <a href="javascript:void(0)" class="bd-nav-btn" style="color: #00e676; text-decoration: none; display: flex; align-items: center; gap: 5px; background: rgba(0, 230, 118, 0.1); border: 1px solid rgba(0, 230, 118, 0.3); padding: 5px 10px; border-radius: 6px; transition: all 0.2s;">
                <span style="font-size: 14px;">🇧🇩</span>
                <span style="font-weight: 800; letter-spacing: 0.5px;">BANGLADESH</span>
                <i class="fas fa-chevron-down" style="font-size: 9px; margin-left: 2px;"></i>
            </a>
            <!-- Dropdown Menu -->
            <div class="bd-dropdown-menu" style="display: none; position: absolute; top: calc(100% + 8px); left: 0; min-width: 240px; background: #0c1a30; border: 1.5px solid #1d3354; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.8); z-index: 10000; padding: 8px 0; font-family: 'Outfit', 'Inter', sans-serif;">
                <div style="padding: 6px 14px; font-size: 10px; font-weight: 800; color: #637b9f; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #1d3354;">Top Played In Bangladesh</div>
                <a href="{{ route('boxing-king') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #ff5252; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-fist-raised" style="font-size: 14px; color: #ff5252; width: 18px;"></i>
                    <span>Boxing King™</span>
                    <span style="margin-left: auto; font-size: 9px; background: #ff3d00; color: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 800;">#1 HOT</span>
                </a>
                <a href="{{ route('play') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #ffbe1a; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-plane-departure" style="font-size: 14px; color: #ffbe1a; width: 18px;"></i>
                    <span>Aviator (1xGames)</span>
                    <span style="margin-left: auto; font-size: 9px; background: #ffbe1a; color: #000; padding: 2px 6px; border-radius: 4px; font-weight: 800;">TOP</span>
                </a>
                <a href="{{ route('western-vault') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #d4af37; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-hat-cowboy" style="font-size: 14px; color: #d4af37; width: 18px;"></i>
                    <span>Western Vault</span>
                    <span style="margin-left: auto; font-size: 9px; background: rgba(212, 175, 55, 0.2); color: #d4af37; padding: 2px 6px; border-radius: 4px; font-weight: 800;">POPULAR</span>
                </a>
                <a href="{{ route('gates-of-olympus') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #00d2ff; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-bolt" style="font-size: 14px; color: #00d2ff; width: 18px;"></i>
                    <span>Gates of Olympus</span>
                </a>
                <a href="{{ route('gems-mines') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #ff9800; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-gem" style="font-size: 14px; color: #ff9800; width: 18px;"></i>
                    <span>Gems & Mines</span>
                </a>
                <a href="{{ route('big-bass-splash') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 14px; color: #38ef7d; text-decoration: none; font-size: 12.5px; font-weight: 700; transition: background 0.2s;">
                    <i class="fas fa-fish" style="font-size: 14px; color: #38ef7d; width: 18px;"></i>
                    <span>Big Bass Splash</span>
                </a>
                <div style="border-top: 1px solid #1d3354; margin-top: 4px; padding-top: 4px;">
                    <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; color: #8ca3c7; text-decoration: none; font-size: 11.5px; font-weight: 700; transition: background 0.2s;">
                        <i class="fas fa-th-large" style="font-size: 12px; width: 18px;"></i>
                        <span>View All BD Games</span>
                    </a>
                </div>
            </div>
        </li>
        <li><a href="{{ route('home') }}" style="color: #8ca3c7; text-decoration: none;">TOP-EVENTS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LEAGUE OF WINS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">T20 BLAST</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">CRICKET</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">SPORTS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LIVE</a></li>
        <li><a href="{{ route('play') }}" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-plane-departure" style="font-size:12px; margin-right:4px;"></i> 1XGAMES</a></li>
        
        <!-- 1XBET CASINO DROPDOWN / MEGA MENU -->
        <li class="nav-more-dropdown nav-casino-dropdown">
            <a href="{{ route('dashboard') }}" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 4px; border-bottom: 3px solid #007bff; padding-bottom: 6px;">
                <span>CASINO</span>
                <i class="fas fa-chevron-down" style="font-size: 9px; margin-left: 2px;"></i>
            </a>

            <!-- 1xBet 4-Column Casino Games Mega Menu Box -->
            <div class="mega-menu-container" style="left: -180px; right: auto;">
                <!-- Column 1: Crash & 1xGames -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-gamepad" style="color: #00c6ff;"></i>
                        <span>1xGames & Crash</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('card-games-21') }}" style="color: #ffd76a;">
                                <i class="fas fa-layer-group" style="color: #ffd76a;"></i>
                                <span>Card Games 21™</span>
                                <span class="mega-badge" style="background: #f59e0b; color: #000;">NEW</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('play') }}" style="color: #ffbe1a;">
                                <i class="fas fa-plane-departure" style="color: #ffbe1a;"></i>
                                <span>Aviator Crash</span>
                                <span class="mega-badge" style="background: #ffbe1a; color: #000;">HOT</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('boxing-king') }}" style="color: #ff5252;">
                                <i class="fas fa-fist-raised" style="color: #ff5252;"></i>
                                <span>Boxing King™</span>
                                <span class="mega-badge" style="background: #ff3d00; color: #fff;">#1 TOP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('western-vault') }}" style="color: #f97316;">
                                <i class="fas fa-hat-cowboy" style="color: #f97316;"></i>
                                <span>Western Vault™</span>
                                <span class="mega-badge" style="background: rgba(249,115,22,0.25); color: #f97316;">PVP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gems-mines') }}">
                                <i class="fas fa-bomb" style="color: #ef4444;"></i>
                                <span>Gems & Mines</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('heads-or-tails') }}">
                                <i class="fas fa-coins" style="color: #ffc107;"></i>
                                <span>Heads or Tails</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('under-and-over-7') }}">
                                <i class="fas fa-dice" style="color: #10b981;"></i>
                                <span>Under and Over 7</span>
                                <span class="mega-badge" style="background: rgba(16,185,129,0.25); color: #10b981;">HOT</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('treasure-climb') }}">
                                <i class="fas fa-mountain" style="color: #4caf50;"></i>
                                <span>Treasure Climb</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 2: Popular Video Slots -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-fire" style="color: #ff5722;"></i>
                        <span>Popular Slots</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('gates-of-olympus') }}" style="color: #00d2ff;">
                                <i class="fas fa-bolt" style="color: #00d2ff;"></i>
                                <span>Gates of Olympus</span>
                                <span class="mega-badge" style="background: rgba(0,210,255,0.2); color: #00d2ff;">ZEUS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('big-bass-splash') }}" style="color: #38ef7d;">
                                <i class="fas fa-fish" style="color: #38ef7d;"></i>
                                <span>Big Bass Splash</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('super-ace-deluxe') }}">
                                <i class="fas fa-crown" style="color: #ffbe1a;"></i>
                                <span>Super Ace Deluxe</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fortune-gems-2') }}">
                                <i class="fas fa-gem" style="color: #ff9800;"></i>
                                <span>Fortune Gems 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bonbon-bonanza') }}">
                                <i class="fas fa-candy-cane" style="color: #e040fb;"></i>
                                <span>BonBon Bonanza</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('lucky-joker-100') }}">
                                <i class="fas fa-mask" style="color: #e91e63;"></i>
                                <span>Lucky Joker 100</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Royal & High Roller -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-gem" style="color: #e040fb;"></i>
                        <span>High Roller & Royal</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('royal-emirates') }}">
                                <i class="fas fa-monument" style="color: #e040fb;"></i>
                                <span>Royal Emirates</span>
                                <span class="mega-badge" style="background: rgba(224,64,251,0.2); color: #e040fb;">VIP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('the-emirate') }}">
                                <i class="fas fa-landmark" style="color: #ffb300;"></i>
                                <span>The Emirate</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('elves-kingdom') }}">
                                <i class="fas fa-shield-alt" style="color: #26a69a;"></i>
                                <span>Elves Kingdom</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('temple-of-fortune') }}">
                                <i class="fas fa-archway" style="color: #ff7043;"></i>
                                <span>Temple of Fortune</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-dice" style="color: #007bff;"></i>
                                <span>Casino Lobby (100+)</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Tournaments & Promos -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-trophy" style="color: #ffc107;"></i>
                        <span>Promotions & Events</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('home') }}" style="color: #ff9800;">
                                <i class="fas fa-award" style="color: #ff9800;"></i>
                                <span>League of Wins</span>
                                <span class="mega-badge" style="background: #ff9800; color: #000;">500K</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-bolt" style="color: #00e676;"></i>
                                <span>T20 Blast Sports</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="handleHeaderAction('cabinet')">
                                <i class="fas fa-crown" style="color: #ffbe1a;"></i>
                                <span>VIP Cashback System</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        <!-- 1XBET MORE MEGA MENU -->
        <li class="nav-more-dropdown">
            <a href="javascript:void(0)" style="color: #8ca3c7; text-decoration: none; display: flex; align-items: center; gap: 4px; padding: 6px 8px; border-radius: 6px;">
                <span>MORE</span>
                <i class="fas fa-chevron-down" style="font-size: 9px; transition: transform 0.2s;"></i>
            </a>

            <!-- 1xBet 4-Column Mega Menu Box -->
            <div class="mega-menu-container">
                <!-- Column 1: Crash & 1xGames -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-gamepad" style="color: #00c6ff;"></i>
                        <span>1xGames & Crash</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('card-games-21') }}" style="color: #ffd76a;">
                                <i class="fas fa-layer-group" style="color: #ffd76a;"></i>
                                <span>Card Games 21™</span>
                                <span class="mega-badge" style="background: #f59e0b; color: #000;">NEW</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('play') }}" style="color: #ffbe1a;">
                                <i class="fas fa-plane-departure" style="color: #ffbe1a;"></i>
                                <span>Aviator Crash</span>
                                <span class="mega-badge" style="background: #ffbe1a; color: #000;">HOT</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('boxing-king') }}" style="color: #ff5252;">
                                <i class="fas fa-fist-raised" style="color: #ff5252;"></i>
                                <span>Boxing King™</span>
                                <span class="mega-badge" style="background: #ff3d00; color: #fff;">#1 TOP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('western-vault') }}" style="color: #f97316;">
                                <i class="fas fa-hat-cowboy" style="color: #f97316;"></i>
                                <span>Western Vault™</span>
                                <span class="mega-badge" style="background: rgba(249,115,22,0.25); color: #f97316;">PVP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gems-mines') }}">
                                <i class="fas fa-bomb" style="color: #ef4444;"></i>
                                <span>Gems & Mines</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('heads-or-tails') }}">
                                <i class="fas fa-coins" style="color: #ffc107;"></i>
                                <span>Heads or Tails</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('under-and-over-7') }}">
                                <i class="fas fa-dice" style="color: #10b981;"></i>
                                <span>Under and Over 7</span>
                                <span class="mega-badge" style="background: rgba(16,185,129,0.25); color: #10b981;">HOT</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('treasure-climb') }}">
                                <i class="fas fa-mountain" style="color: #4caf50;"></i>
                                <span>Treasure Climb</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 2: Popular Video Slots -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-fire" style="color: #ff5722;"></i>
                        <span>Popular Slots</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('gates-of-olympus') }}" style="color: #00d2ff;">
                                <i class="fas fa-bolt" style="color: #00d2ff;"></i>
                                <span>Gates of Olympus</span>
                                <span class="mega-badge" style="background: rgba(0,210,255,0.2); color: #00d2ff;">ZEUS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('big-bass-splash') }}" style="color: #38ef7d;">
                                <i class="fas fa-fish" style="color: #38ef7d;"></i>
                                <span>Big Bass Splash</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('super-ace-deluxe') }}">
                                <i class="fas fa-crown" style="color: #ffbe1a;"></i>
                                <span>Super Ace Deluxe</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fortune-gems-2') }}">
                                <i class="fas fa-gem" style="color: #ff9800;"></i>
                                <span>Fortune Gems 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bonbon-bonanza') }}">
                                <i class="fas fa-candy-cane" style="color: #e040fb;"></i>
                                <span>BonBon Bonanza</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('lucky-joker-100') }}">
                                <i class="fas fa-mask" style="color: #e91e63;"></i>
                                <span>Lucky Joker 100</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Royal & High Roller -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-gem" style="color: #e040fb;"></i>
                        <span>High Roller & Royal</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('royal-emirates') }}">
                                <i class="fas fa-monument" style="color: #e040fb;"></i>
                                <span>Royal Emirates</span>
                                <span class="mega-badge" style="background: rgba(224,64,251,0.2); color: #e040fb;">VIP</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('the-emirate') }}">
                                <i class="fas fa-landmark" style="color: #ffb300;"></i>
                                <span>The Emirate</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('elves-kingdom') }}">
                                <i class="fas fa-shield-alt" style="color: #26a69a;"></i>
                                <span>Elves Kingdom</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('temple-of-fortune') }}">
                                <i class="fas fa-archway" style="color: #ff7043;"></i>
                                <span>Temple of Fortune</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-dice" style="color: #007bff;"></i>
                                <span>Casino Lobby (100+)</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Tournaments & Promos -->
                <div>
                    <div class="mega-col-title">
                        <i class="fas fa-trophy" style="color: #ffc107;"></i>
                        <span>Promotions & Events</span>
                    </div>
                    <ul class="mega-menu-links">
                        <li>
                            <a href="{{ route('home') }}" style="color: #ff9800;">
                                <i class="fas fa-award" style="color: #ff9800;"></i>
                                <span>League of Wins</span>
                                <span class="mega-badge" style="background: #ff9800; color: #000;">500K</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-bolt" style="color: #00e676;"></i>
                                <span>T20 Blast Sports</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="handleHeaderAction('cabinet')">
                                <i class="fas fa-crown" style="color: #ffbe1a;"></i>
                                <span>VIP Cashback System</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="handleHeaderAction('cabinet')">
                                <i class="fas fa-users" style="color: #00c6ff;"></i>
                                <span>10% Referral Affiliate</span>
                            </a>
                        </li>
                        <li style="margin-top: 6px; padding-top: 6px; border-top: 1px solid #1d3354;">
                            <a href="{{ route('dashboard') }}" style="color: #1a76d2; font-weight: 800; background: rgba(26,118,210,0.1);">
                                <i class="fas fa-th-large" style="color: #1a76d2;"></i>
                                <span>Explore All 1xGames</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
    
    <!-- Header Actions (Deposit / Withdraw / Balance / Cabinet) -->
    <div class="dashboard-nav-actions" style="display: flex; align-items: center; gap: 10px;">
        @auth
            <!-- 10-Digit Customer User ID Badge -->
            <div class="user-id-badge" style="background: #112038; border: 1.5px solid #1d3354; border-radius: 6px; padding: 0 10px; height: 38px; display: inline-flex; align-items: center; gap: 6px; font-weight: 700; cursor: pointer; transition: all 0.2s;" onclick="copyUserIdToClipboard('{{ auth()->user()->user_code ?? auth()->user()->id }}')" title="Click to copy your 10-digit User ID">
                <span style="font-size: 10px; color: #8ca3c7; letter-spacing: 0.5px;">MY ID:</span>
                <span style="color: #00f2fe; font-family: 'Roboto Mono', monospace; font-size: 13.5px; font-weight: 800; letter-spacing: 0.5px;" id="header-user-id-val">{{ auth()->user()->user_code ?? auth()->user()->id }}</span>
                <i class="fas fa-copy" style="font-size: 11px; color: #8ca3c7;" id="header-copy-icon"></i>
            </div>

            <!-- Header Balance Display -->
            <div class="balance-container" style="background: #112038; border: 1.5px solid #1d3354; border-radius: 6px; padding: 0 14px; height: 38px; display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <span class="balance-label" style="font-size: 10px; color: #8ca3c7; letter-spacing: 0.5px;">BALANCE:</span>
                <span class="balance-value header-balance-value" style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-size: 15px;">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                <span class="balance-currency" style="color: #ffffff; font-size: 11px;">{{ auth()->user()->currency }}</span>
            </div>

            <!-- KYC Status Badge / Button -->
            @php
                $userKycStatus = auth()->user()->kyc_status ?? 'unverified';
            @endphp
            <button onclick="openKycModal()" class="nav-btn-kyc" style="background: {{ $userKycStatus === 'verified' ? 'rgba(16,185,129,0.15)' : ($userKycStatus === 'pending' ? 'rgba(245,158,11,0.15)' : 'rgba(0,198,255,0.12)') }}; color: {{ $userKycStatus === 'verified' ? '#10b981' : ($userKycStatus === 'pending' ? '#fbbf24' : '#00f2fe') }}; border: 1.5px solid {{ $userKycStatus === 'verified' ? '#10b981' : ($userKycStatus === 'pending' ? '#f59e0b' : '#0284c7') }}; padding: 0 12px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 11.5px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" title="KYC Verification Status">
                @if($userKycStatus === 'verified')
                    <i class="fas fa-shield-check" style="color: #10b981;"></i> <span>ভেরিফাইড</span>
                @elseif($userKycStatus === 'pending')
                    <i class="fas fa-clock" style="color: #fbbf24;"></i> <span>পেন্ডিং</span>
                @else
                    <i class="fas fa-id-card"></i> <span>KYC ভেরিফাই</span>
                @endif
            </button>

            <!-- Sellers / Agents Quick Chat & Deposit Button -->
            <button onclick="openSellerAgentsModal()" class="nav-btn-sellers" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: #ffffff; border: none; padding: 0 14px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 11.5px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                <i class="fas fa-user-tie"></i> <span>SELLERS / AGENTS</span>
            </button>

            <!-- Header Action Buttons -->
            <button onclick="handleHeaderAction('modal', 'deposit-modal')" class="nav-btn-deposit" style="background: #2ebd59; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(46, 189, 89, 0.2);">
                <i class="fas fa-plus-circle"></i> DEPOSIT
            </button>
            <button onclick="handleHeaderAction('modal', 'withdraw-modal')" class="nav-btn-withdraw" style="background: #007bff; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);">
                <i class="fas fa-arrow-alt-circle-up"></i> WITHDRAW
            </button>

            <!-- Cabinet & Logout Actions -->
            <div style="position: relative; display: inline-block;">
                <button onclick="handleHeaderAction('cabinet')" class="nav-btn-cabinet" style="background: #15253e; color: #ffffff; border: 1.5px solid #1d3354; padding: 0 14px; height: 38px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;">
                    <i class="fas fa-user-circle" style="font-size:14px; color:#8ca3c7;"></i> <span>CABINET</span>
                </button>
            </div>

            <a href="#" onclick="handleLogout(event)" class="nav-btn-logout" style="width: 38px; height: 38px; border-radius: 6px; background: rgba(235, 64, 52, 0.1); border: 1px solid rgba(235, 64, 52, 0.3); color: #ff5447; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none; transition: all 0.2s;" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        @else
            <!-- Sellers / Agents Button for Guests -->
            <button onclick="openSellerAgentsModal()" class="nav-btn-sellers" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: #ffffff; border: none; padding: 0 14px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 11.5px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                <i class="fas fa-user-tie"></i> <span>SELLERS / AGENTS</span>
            </button>

            <!-- Guest login / signup actions -->
            <button onclick="openAuthModal('login')" class="nav-btn-login" style="background: #007bff; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);">
                <i class="fas fa-sign-in-alt"></i> LOGIN
            </button>
            <button onclick="openAuthModal('signup')" class="nav-btn-register" style="background: #2ebd59; color: #ffffff; border: none; padding: 0 16px; height: 38px; border-radius: 6px; font-weight: 800; font-size: 12px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(46, 189, 89, 0.2);">
                <i class="fas fa-user-plus"></i> REGISTRATION
            </button>
        @endauth
    </div>
</nav>

<!-- =========================================================
     MOBILE OFF-CANVAS SLIDE-OUT TOGGLE DRAWER
     ========================================================= -->
<div class="mobile-drawer-backdrop" id="mobile-drawer-backdrop" onclick="toggleMobileDrawer(false)"></div>

<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <!-- Drawer Top Header -->
    <div class="drawer-header">
        <a href="{{ route('dashboard') }}" style="text-decoration: none;">
            <span style="font-style: italic; font-weight: 900; font-size: 22px; color: #1a76d2;">
                <span style="color: #ffffff;">1X</span>BET
            </span>
        </a>
        <button class="drawer-close-btn" onclick="toggleMobileDrawer(false)" aria-label="Close drawer">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Drawer Scrollable Content Body -->
    <div class="drawer-body">
        @auth
            <!-- User Profile Card -->
            <div class="drawer-user-card">
                <div class="drawer-user-info">
                    <div class="drawer-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="drawer-user-name">{{ auth()->user()->name }}</div>
                        <div class="drawer-user-email">{{ auth()->user()->email }}</div>
                        <div style="margin-top:4px; font-size:11px; font-weight:800; color:#00f2fe; font-family:'Roboto Mono',monospace; cursor:pointer;" onclick="copyUserIdToClipboard('{{ auth()->user()->user_code ?? auth()->user()->id }}')">
                            ID: {{ auth()->user()->user_code ?? auth()->user()->id }} <i class="fas fa-copy" style="font-size:10px; margin-left:3px;"></i>
                        </div>
                    </div>
                </div>

                <div class="drawer-balance-badge">
                    <span style="font-size: 10px; color: #8ca3c7; font-weight: 700;">MAIN BALANCE</span>
                    <span style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 14px;">
                        {{ number_format(auth()->user()->balance, 2, '.', '') }} {{ auth()->user()->currency }}
                    </span>
                </div>

                <button onclick="toggleMobileDrawer(false); openSellerAgentsModal();" style="width:100%; margin-bottom:8px; padding:9px 0; border-radius:6px; background:linear-gradient(135deg,#0284c7,#0369a1); color:#fff; border:none; font-weight:800; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fas fa-user-tie"></i> <span>SELLERS / AGENTS</span>
                </button>

                <div class="drawer-actions-grid">
                    <button onclick="toggleMobileDrawer(false); handleHeaderAction('modal', 'deposit-modal');" class="drawer-action-btn" style="background: #2ebd59; color: #ffffff;">
                        <i class="fas fa-plus-circle"></i> DEPOSIT
                    </button>
                    <button onclick="toggleMobileDrawer(false); handleHeaderAction('modal', 'withdraw-modal');" class="drawer-action-btn" style="background: #007bff; color: #ffffff;">
                        <i class="fas fa-arrow-alt-circle-up"></i> WITHDRAW
                    </button>
                </div>
            </div>
        @else
            <!-- Guest Prompt -->
            <div class="drawer-guest-card">
                <p style="color: #8ca3c7; font-size: 12px; margin-bottom: 12px;">Join millions of players on Bettingsite today!</p>
                <button onclick="toggleMobileDrawer(false); openSellerAgentsModal();" style="width:100%; margin-bottom:8px; padding:9px 0; border-radius:6px; background:linear-gradient(135deg,#0284c7,#0369a1); color:#fff; border:none; font-weight:800; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fas fa-user-tie"></i> <span>SELLERS / AGENTS</span>
                </button>
                <div class="drawer-actions-grid">
                    <button onclick="toggleMobileDrawer(false); openAuthModal('login');" class="drawer-action-btn" style="background: #007bff; color: #ffffff;">
                        <i class="fas fa-sign-in-alt"></i> LOGIN
                    </button>
                    <button onclick="toggleMobileDrawer(false); openAuthModal('signup');" class="drawer-action-btn" style="background: #2ebd59; color: #ffffff;">
                        <i class="fas fa-user-plus"></i> SIGN UP
                    </button>
                </div>
            </div>
        @endauth

        <!-- Section 1: Dashboard & Account Management (From Left Sidebar) -->
        <div class="drawer-section-title">Player Account & Hub</div>
        <ul class="drawer-nav-list">
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-overview', 0)">
                    <div class="drawer-item-left">
                        <i class="fas fa-gamepad drawer-item-icon" style="color: #00c6ff;"></i>
                        <span>Casino & Slots Lobby</span>
                    </div>
                    <i class="fas fa-chevron-right" style="font-size: 10px; color: #49688f;"></i>
                </button>
            </li>
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-bets', 1)">
                    <div class="drawer-item-left">
                        <i class="fas fa-history drawer-item-icon" style="color: #ffbe1a;"></i>
                        <span>My Bets & History</span>
                    </div>
                    <i class="fas fa-chevron-right" style="font-size: 10px; color: #49688f;"></i>
                </button>
            </li>
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-transfer', 4)">
                    <div class="drawer-item-left">
                        <i class="fas fa-paper-plane drawer-item-icon" style="color: #2ebd59;"></i>
                        <span>Transfer Balance</span>
                    </div>
                    <i class="fas fa-chevron-right" style="font-size: 10px; color: #49688f;"></i>
                </button>
            </li>
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-levels', 3)">
                    <div class="drawer-item-left">
                        <i class="fas fa-trophy drawer-item-icon" style="color: #ff9800;"></i>
                        <span>VIP Level Status</span>
                    </div>
                    <span class="drawer-item-badge" style="background: rgba(255,152,0,0.2); color: #ff9800;">VIP</span>
                </button>
            </li>
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-referral', 5)">
                    <div class="drawer-item-left">
                        <i class="fas fa-users drawer-item-icon" style="color: #9c27b0;"></i>
                        <span>Referral Affiliate</span>
                    </div>
                    <span class="drawer-item-badge" style="background: rgba(156,39,176,0.2); color: #ba68c8;">Earn 10%</span>
                </button>
            </li>
            <li class="drawer-nav-item">
                <button onclick="drawerNavigateCabinet('tab-profile', 6)">
                    <div class="drawer-item-left">
                        <i class="fas fa-user-cog drawer-item-icon" style="color: #00bcd4;"></i>
                        <span>Profile & Security</span>
                    </div>
                    <i class="fas fa-chevron-right" style="font-size: 10px; color: #49688f;"></i>
                </button>
            </li>
        </ul>

        <!-- Section 1.5: Bangladesh Top Picks -->
        <div class="drawer-section-title" style="color: #00e676;"><span style="font-size: 13px;">🇧🇩</span> Top Games in Bangladesh</div>
        <ul class="drawer-nav-list">
            <li class="drawer-nav-item">
                <a href="{{ route('boxing-king') }}" style="background: rgba(255, 68, 68, 0.08); border: 1px solid rgba(255, 68, 68, 0.2);">
                    <div class="drawer-item-left">
                        <i class="fas fa-fist-raised drawer-item-icon" style="color: #ff5252;"></i>
                        <span style="color: #ffffff; font-weight: 800;">Boxing King™</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ff3d00; color: #fff;">#1 TRENDING</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('play') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-plane-departure drawer-item-icon" style="color: #ffbe1a;"></i>
                        <span>Aviator Crash</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ffbe1a; color: #000;">HOT</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('western-vault') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-hat-cowboy drawer-item-icon" style="color: #d4af37;"></i>
                        <span>Western Vault</span>
                    </div>
                    <span class="drawer-item-badge" style="background: rgba(212, 175, 55, 0.2); color: #d4af37;">POPULAR</span>
                </a>
            </li>
        </ul>

        <!-- Section 2: Top Navigation Sports & Events (From Top Header) -->
        <div class="drawer-section-title">Sports & Top Events</div>
        <ul class="drawer-nav-list">
            <li class="drawer-nav-item">
                <a href="{{ route('home') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-fire drawer-item-icon" style="color: #ff5722;"></i>
                        <span>TOP-EVENTS</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ff3d00; color: #fff;">HOT</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="#">
                    <div class="drawer-item-left">
                        <i class="fas fa-award drawer-item-icon" style="color: #ffc107;"></i>
                        <span>League of Wins</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="#">
                    <div class="drawer-item-left">
                        <i class="fas fa-bolt drawer-item-icon" style="color: #00e676;"></i>
                        <span>T20 Blast</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="#">
                    <div class="drawer-item-left">
                        <i class="fas fa-baseball-ball drawer-item-icon" style="color: #03a9f4;"></i>
                        <span>Cricket Betting</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="#">
                    <div class="drawer-item-left">
                        <i class="fas fa-futbol drawer-item-icon" style="color: #8bc34a;"></i>
                        <span>Sportsbook</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="#">
                    <div class="drawer-item-left">
                        <i class="fas fa-broadcast-tower drawer-item-icon" style="color: #e91e63;"></i>
                        <span>Live Matches</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #e91e63; color: #fff;">LIVE</span>
                </a>
            </li>
        </ul>

        <!-- Section 3: Popular Casino & Original Games -->
        <div class="drawer-section-title">Games & Casino</div>
        <ul class="drawer-nav-list">
            <li class="drawer-nav-item">
                <a href="{{ route('play') }}" style="color: #ffbe1a;">
                    <div class="drawer-item-left">
                        <i class="fas fa-plane-departure drawer-item-icon" style="color: #ffbe1a;"></i>
                        <span>1XGAMES (Aviator)</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ffbe1a; color: #000;">FEATURED</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('dashboard') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-dice drawer-item-icon" style="color: #007bff;"></i>
                        <span>Casino Slots</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('fortune-gems-2') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-gem drawer-item-icon" style="color: #ff9800;"></i>
                        <span>Fortune Gems 2</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ff3d00; color: #fff;">HOT</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('super-ace-deluxe') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-crown drawer-item-icon" style="color: #ffbe1a;"></i>
                        <span>Super Ace Deluxe</span>
                    </div>
                    <span class="drawer-item-badge" style="background: #ff3d00; color: #fff;">HOT</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('gems-mines') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-bomb drawer-item-icon" style="color: #ff5722;"></i>
                        <span>Gems & Mines</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('big-bass-splash') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-fish drawer-item-icon" style="color: #38ef7d;"></i>
                        <span>Big Bass Splash</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('gates-of-olympus') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-bolt drawer-item-icon" style="color: #00d2ff;"></i>
                        <span>Gates of Olympus</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('boxing-king') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-fist-raised drawer-item-icon" style="color: #f44336;"></i>
                        <span>Boxing King</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('heads-or-tails') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-coins drawer-item-icon" style="color: #ffc107;"></i>
                        <span>Heads or Tails</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('under-and-over-7') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-dice drawer-item-icon" style="color: #10b981;"></i>
                        <span>Under and Over 7</span>
                    </div>
                    <span class="drawer-badge" style="background: rgba(16,185,129,0.25); color: #10b981;">HOT</span>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('treasure-climb') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-mountain drawer-item-icon" style="color: #4caf50;"></i>
                        <span>Treasure Climb</span>
                    </div>
                </a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('royal-emirates') }}">
                    <div class="drawer-item-left">
                        <i class="fas fa-monument drawer-item-icon" style="color: #e040fb;"></i>
                        <span>Royal Emirates</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="drawer-footer">
        <button onclick="toggleMobileDrawer(false); openLiveSupport();" style="width: 100%; padding: 10px; border-radius: 6px; background: #15253e; border: 1px solid #1d3354; color: #8ca3c7; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fas fa-headset" style="color: #00c6ff;"></i> 24/7 Live Support Desk
        </button>

        @auth
            <button onclick="handleLogout(event)" style="width: 100%; padding: 10px; border-radius: 6px; background: rgba(235, 64, 52, 0.12); border: 1px solid rgba(235, 64, 52, 0.3); color: #ff5447; font-weight: 800; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-sign-out-alt"></i> Logout Account
            </button>
        @endauth
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
// Toggle Mobile Drawer Open / Close
function toggleMobileDrawer(open) {
    const drawer = document.getElementById('mobile-nav-drawer');
    const backdrop = document.getElementById('mobile-drawer-backdrop');
    if (!drawer || !backdrop) return;

    if (open) {
        drawer.classList.add('open');
        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';
    } else {
        drawer.classList.remove('open');
        backdrop.classList.remove('open');
        document.body.style.overflow = '';
    }
}

// Drawer navigation to specific cabinet tab
function drawerNavigateCabinet(tabId, tabIndex) {
    toggleMobileDrawer(false);
    if (window.location.pathname.endsWith('/dashboard')) {
        if (tabId === 'tab-overview') {
            if (typeof toggleCabinet === 'function') toggleCabinet(false);
        } else {
            if (typeof toggleCabinet === 'function') toggleCabinet(true);
            const triggers = document.querySelectorAll('.dashboard-tab-trigger');
            if (triggers && triggers[tabIndex] && typeof switchDashboardTab === 'function') {
                switchDashboardTab(tabId, triggers[tabIndex]);
            }
        }
    } else {
        if (tabId === 'tab-overview') {
            window.location.href = "{{ route('dashboard') }}";
        } else {
            window.location.href = "{{ route('dashboard') }}?tab=cabinet";
        }
    }
}

// Open Support Chat directly
function openLiveSupport() {
    const chatBtn = document.getElementById('chat-trigger-btn');
    if (chatBtn) {
        chatBtn.click();
    } else {
        alert("Support Desk: admin@gmail.com\nPlease email our support desk for instant assistance.");
    }
}
</script>

<!-- ============================================== -->
<!-- UNIVERSAL GLOBAL MODALS: DEPOSIT & WITHDRAW   -->
<!-- ============================================== -->
<div id="global-deposit-modal" class="global-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(4, 10, 24, 0.85); backdrop-filter:blur(6px); z-index:999999; align-items:center; justify-content:center; padding:16px;">
    <div class="global-modal-box" style="max-width:540px; width:100%; background:#0e1c33; border:1.5px solid #1d3354; border-radius:16px; padding:24px; box-shadow:0 20px 50px rgba(0,0,0,0.8); position:relative; max-height:90vh; overflow-y:auto; color:#fff; font-family:'Outfit', 'Inter', sans-serif;">
        <button onclick="closeGlobalModal('deposit-modal')" style="position:absolute; top:16px; right:16px; background:none; border:none; color:#8ca3c7; font-size:18px; cursor:pointer;"><i class="fas fa-times"></i></button>
        <h3 style="font-size:18px; font-weight:800; color:#fff; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-circle-down" style="color:#2ebd59;"></i> Deposit Wallet Balance
        </h3>
        
        <form id="global-deposit-form" onsubmit="handleGlobalDepositSubmit(event)" enctype="multipart/form-data">
            <div style="margin-bottom:14px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Select Deposit Payment Gateway</label>
                <select id="global-deposit-gateway-select" onchange="onDepositGatewayDropdownChange(this.value)" required style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:13.5px; outline:none; cursor:pointer;">
                    <option value="">Choose Method (bKash, Nagad, Binance USDT...)</option>
                </select>
            </div>

            <!-- Visual Gateway Cards List -->
            <div id="global-deposit-gateways-list" style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap;"></div>

            <input type="hidden" id="global-deposit-gateway-id" name="gateway_id">

            <!-- Gateway instructions container -->
            <div id="global-deposit-gateway-instructions" style="margin-bottom:16px; display:none;">
                <label style="font-size:11.5px; font-weight:700; color:#f5c542; text-transform:uppercase; margin-bottom:6px; display:block;"><i class="fas fa-circle-info"></i> পেমেন্ট নির্দেশাবলী (Payment Instructions)</label>
                <div id="global-deposit-instructions-box" style="display:flex; flex-direction:column; gap:8px; background:rgba(255,255,255,0.03); padding:14px; border-radius:10px; border:1px solid #1d3354;"></div>
            </div>

            <div style="margin-bottom:12px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Deposit Amount ({{ auth()->user() ? auth()->user()->currency : 'BDT' }}) <span style="color:#ff5447;">*</span></label>
                <input type="number" id="global-deposit-amount" name="amount" placeholder="টাকার পরিমাণ লিখুন (e.g. 500)" min="10" step="any" required style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>
            
            <div style="margin-bottom:12px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Sender Number / Account (কোন নাম্বার থেকে টাকা পাঠিয়েছেন) <span style="color:#ff5447;">*</span></label>
                <input type="text" name="sender_number" id="global-deposit-sender-number" placeholder="আপনার বিকাশ/নগদ/ওয়ালেট নাম্বার দিন" required autocomplete="off" style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Transaction ID / TrxID <span style="color:#ff5447;">*</span></label>
                <input type="text" name="transaction_id" id="global-deposit-transaction-id" placeholder="Transaction ID (TrxID / Hash) লিখুন" required autocomplete="off" style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Payment Screenshot (স্ক্রিনশট প্রুফ)</label>
                <input type="file" name="screenshot" id="global-deposit-screenshot" accept="image/*" style="width:100%; padding:8px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#8ca3c7; font-size:12px;">
            </div>

            <button type="submit" id="btn-global-deposit-submit" style="width:100%; background:linear-gradient(135deg, #2ebd59, #22a048); color:#fff; border:none; padding:12px; border-radius:8px; font-weight:800; font-size:13.5px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(46, 189, 89, 0.3);">
                <i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST
            </button>
        </form>
    </div>
</div>

<div id="global-withdraw-modal" class="global-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(4, 10, 24, 0.85); backdrop-filter:blur(6px); z-index:999999; align-items:center; justify-content:center; padding:16px;">
    <div class="global-modal-box" style="max-width:520px; width:100%; background:#0e1c33; border:1.5px solid #1d3354; border-radius:16px; padding:24px; box-shadow:0 20px 50px rgba(0,0,0,0.8); position:relative; max-height:90vh; overflow-y:auto; color:#fff; font-family:'Outfit', 'Inter', sans-serif;">
        <button onclick="closeGlobalModal('withdraw-modal')" style="position:absolute; top:16px; right:16px; background:none; border:none; color:#8ca3c7; font-size:18px; cursor:pointer;"><i class="fas fa-times"></i></button>
        <h3 style="font-size:18px; font-weight:800; color:#fff; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-circle-up" style="color:#007bff;"></i> Withdraw Wallet Balance
        </h3>
        
        <form id="global-withdraw-form" onsubmit="handleGlobalWithdrawSubmit(event)">
            <div style="margin-bottom:14px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Select Withdrawal Payment Method</label>
                <select id="global-withdraw-gateway-select" required style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:13.5px; outline:none; cursor:pointer;">
                    <option value="">Choose Method...</option>
                </select>
            </div>

            <input type="hidden" id="global-withdraw-gateway-id" name="gateway_id">

            <div style="margin-bottom:12px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Withdrawal Amount ({{ auth()->user() ? auth()->user()->currency : 'BDT' }})</label>
                <input type="number" id="global-withdraw-amount" name="amount" placeholder="Enter withdrawal amount" min="50" step="any" required style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>
            
            <div style="margin-bottom:12px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Your Wallet Mobile / Account Number <span style="color:#ff5447;">*</span></label>
                <input type="text" id="global-withdraw-account" name="account_number" placeholder="e.g. 017xxxxxxxx or TRC20 Address" required style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:11.5px; font-weight:700; color:#8ca3c7; text-transform:uppercase; margin-bottom:6px; display:block;">Note / Description (Optional)</label>
                <input type="text" id="global-withdraw-note" name="note" placeholder="Enter note or description" style="width:100%; padding:10px 14px; background:#142542; border:1px solid #1d3354; border-radius:8px; color:#fff; font-size:14px; outline:none;">
            </div>

            <button type="submit" id="btn-global-withdraw-submit" style="width:100%; background:linear-gradient(135deg, #007bff, #0056b3); color:#fff; border:none; padding:12px; border-radius:8px; font-weight:800; font-size:13.5px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 15px rgba(0, 123, 255, 0.3);">
                <i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL
            </button>
        </form>
    </div>
</div>

<script>
let globalActiveGateways = [];

function openGlobalModal(modalType) {
    @guest
        if (typeof openAuthModal === 'function') {
            openAuthModal('login');
        } else {
            window.location.href = "{{ route('login') }}";
        }
        return;
    @endguest

    const modalId = modalType.startsWith('global-') ? modalType : ('global-' + modalType);
    const modalEl = document.getElementById(modalId);
    if (modalEl) {
        modalEl.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        if (modalType.includes('deposit')) {
            loadGlobalGateways('deposit');
        } else if (modalType.includes('withdraw')) {
            loadGlobalGateways('withdraw');
        }
    }
}

function closeGlobalModal(modalType) {
    const modalId = modalType.startsWith('global-') ? modalType : ('global-' + modalType);
    const modalEl = document.getElementById(modalId);
    if (modalEl) {
        modalEl.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function loadGlobalGateways(method) {
    fetch('{{ route("dashboard.gateways") }}', {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            globalActiveGateways = data.gateways || [];

            if (method === 'deposit') {
                const grid = document.getElementById('global-deposit-gateways-list');
                const selectEl = document.getElementById('global-deposit-gateway-select');
                const filtered = globalActiveGateways.filter(g => g.methods === 'both' || g.methods === 'deposit');

                if (filtered.length === 0) {
                    if (grid) grid.innerHTML = '<div style="font-size:12px; color:#8ca3c7;">No active payment gateways available.</div>';
                    if (selectEl) selectEl.innerHTML = '<option value="">No active payment gateways</option>';
                    return;
                }

                if (selectEl) {
                    selectEl.innerHTML = '<option value="">Choose Method (bKash, Nagad, Binance USDT...)</option>' + 
                        filtered.map(g => `<option value="${g.id}">${g.name}</option>`).join('');
                }

                if (grid) {
                    grid.innerHTML = filtered.map((g, idx) => `
                        <div class="gw-select-card" data-id="${g.id}" onclick="selectGlobalGateway('deposit', ${g.id}, this)" style="border:2px solid #1d3354; border-radius:10px; padding:6px 12px; cursor:pointer; background:#142542; display:flex; align-items:center; justify-content:center; height:50px; min-width:80px; transition:all 0.2s; font-weight:700; font-size:12px; color:#fff;">
                            ${g.logo ? `<img src="${g.logo}" alt="${g.name}" style="max-height:34px; max-width:75px; object-fit:contain;">` : `<span>${g.name}</span>`}
                        </div>
                    `).join('');
                }

                // Auto-select first gateway
                if (filtered.length > 0) {
                    selectGlobalGateway('deposit', filtered[0].id);
                }
            } else if (method === 'withdraw') {
                const selectEl = document.getElementById('global-withdraw-gateway-select');
                const filtered = globalActiveGateways.filter(g => g.methods === 'both' || g.methods === 'withdraw');

                if (filtered.length === 0) {
                    selectEl.innerHTML = '<option value="">No active withdrawal methods</option>';
                    return;
                }

                selectEl.innerHTML = '<option value="">Choose Method...</option>' + 
                    filtered.map(g => `<option value="${g.id}">${g.name}</option>`).join('');

                selectEl.onchange = function() {
                    document.getElementById('global-withdraw-gateway-id').value = this.value;
                };
            }
        }
    })
    .catch(err => console.error('Failed to load gateways:', err));
}

function onDepositGatewayDropdownChange(gatewayId) {
    if (!gatewayId) return;
    selectGlobalGateway('deposit', gatewayId);
}

function selectGlobalGateway(method, id, clickedCardBtn) {
    const gatewayIdInput = document.getElementById('global-deposit-gateway-id');
    if (gatewayIdInput) gatewayIdInput.value = id;

    const selectEl = document.getElementById('global-deposit-gateway-select');
    if (selectEl && selectEl.value != id) selectEl.value = id;

    document.querySelectorAll('#global-deposit-gateways-list .gw-select-card').forEach(b => {
        if (b.getAttribute('data-id') == id) {
            b.style.borderColor = '#2ebd59';
            b.style.background = 'rgba(46, 189, 89, 0.15)';
        } else {
            b.style.borderColor = '#1d3354';
            b.style.background = '#142542';
        }
    });

    const gateway = globalActiveGateways.find(g => g.id == id);
    if (!gateway) return;

    const instContainer = document.getElementById('global-deposit-gateway-instructions');
    const instBox = document.getElementById('global-deposit-instructions-box');

    const settings = gateway.settings || [];
    if (settings.length > 0) {
        instBox.innerHTML = settings.map(s => `
            <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.06); gap:10px;">
                <span style="font-size:12.5px; color:#cbd5e1;">
                    ${s.name || s.label}: <strong style="color:#ffbe1a; font-family:'Roboto Mono',monospace; font-size:13px;">${s.value}</strong>
                </span>
                <button type="button" onclick="navigator.clipboard.writeText('${s.value}'); alert('Copied: ${s.value}');" style="background:#2ebd59; color:#fff; border:none; padding:4px 10px; border-radius:6px; font-size:10.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px; box-shadow:0 2px 6px rgba(46,189,89,0.3);">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        `).join('');
        instContainer.style.display = 'block';
    } else {
        instContainer.style.display = 'none';
    }
}

function handleGlobalDepositSubmit(e) {
    e.preventDefault();
    const gatewayId = document.getElementById('global-deposit-gateway-id').value;
    if (!gatewayId) {
        alert("Please select a payment gateway.");
        return;
    }

    const btn = document.getElementById('btn-global-deposit-submit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    const formData = new FormData(e.target);

    fetch('{{ route("dashboard.deposit") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(r => r.json().then(data => ({ status: r.status, body: data })))
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST';

        if (res.status === 200 && res.body.success) {
            closeGlobalModal('deposit-modal');
            alert("✅ Deposit Request Submitted!\nYour deposit is pending admin approval. Once approved, your balance will be updated automatically.");
            document.getElementById('global-deposit-form').reset();
        } else {
            const errs = res.body.errors || [res.body.message || 'Deposit submission failed.'];
            alert(errs.join('\n'));
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-circle-check"></i> SUBMIT DEPOSIT REQUEST';
        alert('Network connection error. Please try again.');
    });
}

function handleGlobalWithdrawSubmit(e) {
    e.preventDefault();
    const gatewayId = document.getElementById('global-withdraw-gateway-id').value;
    if (!gatewayId) {
        alert("Please select a withdrawal payment method.");
        return;
    }

    const amount = document.getElementById('global-withdraw-amount').value;
    const account = document.getElementById('global-withdraw-account').value;
    const note = document.getElementById('global-withdraw-note').value;
    const btn = document.getElementById('btn-global-withdraw-submit');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    fetch('{{ route("dashboard.withdraw") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            gateway_id: gatewayId,
            amount: amount,
            account_number: account,
            note: note
        })
    })
    .then(r => r.json().then(data => ({ status: r.status, body: data })))
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL';

        if (res.status === 200 && res.body.success) {
            closeGlobalModal('withdraw-modal');
            alert("✅ Withdrawal Request Submitted!\nYour withdrawal has been registered and is pending approval.");
            document.getElementById('global-withdraw-form').reset();
            // Update balance in header if returned
            const headerBal = document.querySelector('.header-balance-value');
            if (headerBal && res.body.balance) headerBal.textContent = res.body.balance;
        } else {
            const errs = res.body.errors || [res.body.message || 'Withdrawal failed.'];
            alert(errs.join('\n'));
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-circle-check"></i> CONFIRM WITHDRAWAL';
        alert('Network connection error.');
    });
}

function handleHeaderAction(action, modalId) {
    if (action === 'modal') {
        openGlobalModal(modalId);
    } else if (action === 'cabinet') {
        if (window.location.pathname.endsWith('/dashboard')) {
            if (typeof toggleCabinet === 'function') toggleCabinet(true);
        } else {
            window.location.href = "{{ route('dashboard') }}?tab=cabinet";
        }
    }
}

function handleLogout(e) {
    if (e) e.preventDefault();
    document.getElementById('logout-form').submit();
}

/* ==========================================================================
   CUSTOMER - SELLER & AGENTS SYSTEM & REALTIME CHAT
   ========================================================================== */
function copyUserIdToClipboard(code) {
    if (!code) return;
    navigator.clipboard.writeText(code).then(() => {
        const copyIcon = document.getElementById('header-copy-icon');
        if (copyIcon) {
            copyIcon.className = 'fas fa-check text-success';
            setTimeout(() => { copyIcon.className = 'fas fa-copy'; }, 2000);
        }
        alert('✅ আপনার ১০ ডিজিট কাস্টমার আইডি কপি হয়েছে: ' + code);
    }).catch(() => {
        prompt('আপনার ১০ ডিজিট আইডি:', code);
    });
}

let activeSellerChatId = null;
let sellerChatPollingTimer = null;
const CUSTOMER_USER_CODE = '{{ auth()->check() ? (auth()->user()->user_code ?? auth()->user()->id) : "" }}';

function openSellerAgentsModal() {
    const modal = document.getElementById('seller-agents-modal');
    if (!modal) return;
    modal.style.display = 'flex';
    loadActiveSellers();
}

function closeSellerAgentsModal() {
    const modal = document.getElementById('seller-agents-modal');
    if (modal) modal.style.display = 'none';
}

function loadActiveSellers() {
    const grid = document.getElementById('seller-agents-list-grid');
    if (!grid) return;
    grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#8ca3c7;"><i class="fas fa-spinner fa-spin"></i> ভেরিফাইড সেলার ও এজেন্ট তালিকা লোড হচ্ছে...</div>';

    fetch('/seller/active-list', {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.sellers && data.sellers.length > 0) {
            grid.innerHTML = data.sellers.map(s => {
                const photo = s.seller_photo || '{{ asset("uploads/agent_profile_pictures/default_agent.png") }}';
                return `
                    <div style="background:#11223b; border:1.5px solid #1d3354; border-radius:12px; padding:16px; display:flex; flex-direction:column; gap:12px; transition:all 0.2s ease;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <img src="${photo}" alt="${s.name}" style="width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid #00f2fe; background:#0c1a30;" onerror="this.src='{{ asset("uploads/agent_profile_pictures/default_agent.png") }}'">
                            <div style="flex:1; min-width:0;">
                                <div style="font-weight:800; color:#ffffff; font-size:14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${s.name}</div>
                                <div style="font-size:11px; color:#34d399; font-weight:700; display:flex; align-items:center; gap:4px; margin-top:2px;">
                                    <i class="fas fa-certificate" style="color:#00f2fe;"></i> ভেরিফাইড এজেন্ট
                                </div>
                                ${s.seller_phone ? `<div style="font-size:11px; color:#8ca3c7; margin-top:2px; font-family:'Roboto Mono',monospace;"><i class="fas fa-phone-alt"></i> ${s.seller_phone}</div>` : ''}
                            </div>
                        </div>

                        <div style="background:rgba(0,242,254,0.06); border:1px solid rgba(0,242,254,0.2); border-radius:8px; padding:8px 10px; font-size:11.5px; color:#cbd5e1; display:flex; justify-content:space-between; align-items:center;">
                            <span>ব্যালেন্স লোড:</span>
                            <span style="color:#38ef7d; font-weight:800;">ইনস্ট্যান্ট ক্যাশ ইন</span>
                        </div>

                        <button type="button" onclick="startChatWithSeller(${s.id}, '${s.name.replace(/'/g, "\\'")}', '${photo}')" style="width:100%; padding:10px; border-radius:8px; background:linear-gradient(135deg, #0284c7, #0369a1); color:#ffffff; font-weight:800; font-size:12.5px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 4px 12px rgba(2,132,199,0.3); transition:all 0.2s;">
                            <i class="fas fa-comments"></i> লাইভ চ্যাট ও ডিপোজিট
                        </button>
                    </div>
                `;
            }).join('');
        } else {
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#8ca3c7;"><i class="fas fa-user-slash" style="font-size:24px; margin-bottom:8px; display:block;"></i> বর্তমানে কোন এজেন্ট একটিভ নেই। অনুগ্রহ করে কিছুক্ষণ পর চেষ্টা করুন।</div>';
        }
    })
    .catch(() => {
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#f87171;">এজেন্টদের তালিকা লোড করতে ব্যর্থ হয়েছে।</div>';
    });
}

function startChatWithSeller(sellerId, sellerName, sellerPhoto) {
    @guest
        closeSellerAgentsModal();
        openAuthModal('login');
        return;
    @endguest

    closeSellerAgentsModal();
    activeSellerChatId = sellerId;

    document.getElementById('seller-chat-title-name').textContent = sellerName;
    document.getElementById('seller-chat-title-photo').src = sellerPhoto;
    document.getElementById('seller-chat-modal').style.display = 'flex';

    loadSellerChatMessages();
    if (sellerChatPollingTimer) clearInterval(sellerChatPollingTimer);
    sellerChatPollingTimer = setInterval(loadSellerChatMessages, 3000);
}

function closeSellerChatModal() {
    activeSellerChatId = null;
    if (sellerChatPollingTimer) clearInterval(sellerChatPollingTimer);
    const modal = document.getElementById('seller-chat-modal');
    if (modal) modal.style.display = 'none';
}

function loadSellerChatMessages() {
    if (!activeSellerChatId) return;

    fetch(`/seller/chat/${activeSellerChatId}/messages`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            renderSellerChatMessages(data.messages);
        }
    })
    .catch(err => console.error('Chat sync error', err));
}

function renderSellerChatMessages(messages) {
    const box = document.getElementById('seller-chat-messages-container');
    if (!box) return;

    if (!messages || messages.length === 0) {
        box.innerHTML = `
            <div style="text-align:center; padding:30px 10px; color:#8ca3c7; font-size:12.5px;">
                <i class="fas fa-handshake" style="font-size:28px; color:#00f2fe; margin-bottom:8px; display:block;"></i>
                এজেন্টের সাথে লাইভ কথোপকথন শুরু করুন。<br>টাকা ডিপোজিট করতে আপনার <strong>১০ ডিজিট আইডি</strong> শেয়ার করুন।
            </div>
        `;
        return;
    }

    const currentUserId = {{ auth()->check() ? auth()->id() : 0 }};

    box.innerHTML = messages.map(m => {
        const isMe = m.sender_id == currentUserId;
        return `
            <div style="display:flex; justify-content:${isMe ? 'flex-end' : 'flex-start'}; margin-bottom:10px;">
                <div style="max-width:75%; padding:9px 13px; border-radius:${isMe ? '12px 12px 2px 12px' : '12px 12px 12px 2px'}; background:${isMe ? 'linear-gradient(135deg, #0284c7, #0369a1)' : '#11223b'}; border:1px solid ${isMe ? 'rgba(0,242,254,0.3)' : '#1d3354'}; color:#ffffff; font-size:12.5px; line-height:1.4; word-break:break-word; box-shadow:0 2px 8px rgba(0,0,0,0.3);">
                    ${m.message.replace(/\n/g, '<br>')}
                    <div style="font-size:9.5px; color:${isMe ? 'rgba(255,255,255,0.7)' : '#8ca3c7'}; margin-top:3px; text-align:right;">${m.time || ''}</div>
                </div>
            </div>
        `;
    }).join('');

    box.scrollTop = box.scrollHeight;
}

function sendSellerChatMessage(e) {
    if (e) e.preventDefault();
    if (!activeSellerChatId) return;

    const input = document.getElementById('seller-chat-input-text');
    const msg = (input.value || '').trim();
    if (!msg) return;

    input.value = '';

    fetch(`/seller/chat/${activeSellerChatId}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            loadSellerChatMessages();
        }
    })
    .catch(err => console.error('Message send error', err));
}

function sendMyUserIdToSellerChat() {
    if (!CUSTOMER_USER_CODE) return;
    const input = document.getElementById('seller-chat-input-text');
    if (input) {
        input.value = `আমার কাস্টমার আইডি: ${CUSTOMER_USER_CODE} (অনুগ্রহ করে ব্যালেন্স এড করে দিন)`;
        input.focus();
    }
}
</script>

<!-- ==================== SELLER & AGENTS LIST MODAL ==================== -->
<div class="modal-overlay" id="seller-agents-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,10,20,0.85); z-index:100000; padding:16px; box-sizing:border-box; backdrop-filter:blur(6px); font-family:'Outfit','Inter',sans-serif;">
    <div class="modal-box" style="max-width:760px; width:100%; max-height:90vh; display:flex; flex-direction:column; position:relative; background:#0a1628; border-radius:16px; border:1.5px solid #1d3354; padding:24px; box-shadow:0 25px 60px rgba(0,0,0,0.9);">
        <button class="modal-close" onclick="closeSellerAgentsModal()" style="position:absolute; top:18px; right:18px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fas fa-times"></i></button>
        
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #1d3354;">
            <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg, #0284c7, #00f2fe); display:flex; align-items:center; justify-content:center; color:#fff; font-size:20px; box-shadow:0 4px 15px rgba(2,132,199,0.4);">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <h3 style="margin:0; font-size:18px; font-weight:800; color:#fff;">ভেরিফাইড সেলার ও এজেন্ট সেন্টার</h3>
                <p style="margin:2px 0 0; font-size:12px; color:#8ca3c7;">যেকোনো এজেন্টের সাথে চ্যাট করে নগদ, বিকাশ বা রকেটে ইনস্ট্যান্ট একাউন্ট রিচার্জ করুন।</p>
            </div>
        </div>

        @auth
        <div style="background:#112038; border:1px solid #1d3354; border-radius:10px; padding:10px 14px; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div style="font-size:12px; color:#8ca3c7;">
                আপনার ইউনিক আইডি: <strong style="color:#00f2fe; font-family:'Roboto Mono',monospace; font-size:14px;">{{ auth()->user()->user_code ?? auth()->user()->id }}</strong>
            </div>
            <button type="button" onclick="copyUserIdToClipboard('{{ auth()->user()->user_code ?? auth()->user()->id }}')" style="background:rgba(0,242,254,0.15); border:1px solid rgba(0,242,254,0.3); color:#00f2fe; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;">
                <i class="fas fa-copy"></i> কপি আইডি
            </button>
        </div>
        @endauth

        <div id="seller-agents-list-grid" style="flex:1; overflow-y:auto; display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:14px; padding-right:4px;">
            <!-- Dynamically loaded seller cards -->
        </div>
    </div>
</div>

<!-- ==================== SELLER LIVE CHAT MODAL ==================== -->
<div class="modal-overlay" id="seller-chat-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,10,20,0.85); z-index:100001; padding:16px; box-sizing:border-box; backdrop-filter:blur(6px); font-family:'Outfit','Inter',sans-serif;">
    <div class="modal-box" style="max-width:500px; width:100%; height:560px; max-height:92vh; display:flex; flex-direction:column; position:relative; background:#0a1628; border-radius:16px; border:1.5px solid #1d3354; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.95);">
        
        <!-- Chat Header -->
        <div style="padding:14px 18px; background:#0d1e38; border-bottom:1px solid #1d3354; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <img id="seller-chat-title-photo" src="{{ asset('uploads/agent_profile_pictures/default_agent.png') }}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #00f2fe;" onerror="this.src='{{ asset("uploads/agent_profile_pictures/default_agent.png") }}'">
                <div>
                    <div id="seller-chat-title-name" style="font-weight:800; color:#fff; font-size:14px;">Seller Name</div>
                    <div style="font-size:10.5px; color:#34d399; display:flex; align-items:center; gap:4px;">
                        <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#10b981;"></span> অনলাইন এজেন্ট
                    </div>
                </div>
            </div>
            <button onclick="closeSellerChatModal()" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); color:#fff; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fas fa-times"></i></button>
        </div>

        <!-- ID Share Banner -->
        @auth
        <div style="padding:8px 14px; background:rgba(2,132,199,0.15); border-bottom:1px solid #1d3354; display:flex; align-items:center; justify-content:space-between; font-size:11.5px;">
            <span style="color:#cbd5e1;">আপনার আইডি: <strong style="color:#00f2fe; font-family:'Roboto Mono',monospace;">{{ auth()->user()->user_code ?? auth()->user()->id }}</strong></span>
            <button type="button" onclick="sendMyUserIdToSellerChat()" style="background:#0284c7; color:#fff; border:none; padding:3px 8px; border-radius:4px; font-size:10.5px; font-weight:800; cursor:pointer;">
                <i class="fas fa-paper-plane"></i> চ্যাটে আইডি দিন
            </button>
        </div>
        @endauth

        <!-- Chat Messages Container -->
        <div id="seller-chat-messages-container" style="flex:1; overflow-y:auto; padding:16px; background:#07101d;">
            <!-- Rendered chat messages -->
        </div>

        <!-- Chat Input Form -->
        <form onsubmit="sendSellerChatMessage(event)" style="padding:12px 14px; background:#0d1e38; border-top:1px solid #1d3354; display:flex; gap:8px; align-items:center; margin:0;">
            <input type="text" id="seller-chat-input-text" placeholder="মেসেজ লিখুন..." autocomplete="off" required style="flex:1; height:38px; padding:0 12px; background:#07101d; border:1px solid #1d3354; border-radius:8px; color:#fff; font-family:inherit; font-size:13px; outline:none;">
            <button type="submit" style="height:38px; padding:0 16px; background:#007bff; color:#fff; border:none; border-radius:8px; font-weight:800; font-size:13px; cursor:pointer; display:flex; align-items:center; gap:5px;">
                <span>পাঠান</span> <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- ==========================================================================
     KYC VERIFICATION MODAL & UPLOADER
     ========================================================================== -->
<div id="kyc-verification-modal" style="display:none; position:fixed; inset:0; z-index:1000000; background:rgba(4,9,20,0.85); backdrop-filter:blur(8px); align-items:center; justify-content:center; padding:16px;">
    <div style="background:#0c192c; border:1.5px solid #1e3a5f; border-radius:18px; width:100%; max-width:540px; box-shadow:0 25px 60px rgba(0,0,0,0.8), 0 0 35px rgba(0,242,254,0.15); display:flex; flex-direction:column; max-height:92vh; overflow:hidden; font-family:'Outfit',system-ui,sans-serif;">
        <!-- KYC Modal Header -->
        <div style="padding:16px 20px; background:#0f223d; border-bottom:1px solid #1e3a5f; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:38px; height:38px; border-radius:10px; background:rgba(0,242,254,0.1); border:1px solid rgba(0,242,254,0.3); display:flex; align-items:center; justify-content:center; color:#00f2fe; font-size:18px;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <div style="font-weight:900; font-size:16px; color:#fff; letter-spacing:0.5px;">KYC ভেরিফিকেশন (Identity Verification)</div>
                    <div style="font-size:11.5px; color:#8ca3c7;">জাতীয় পরিচয়পত্র, পাসপোর্ট অথবা জন্ম নিবন্ধন আপলোড করুন</div>
                </div>
            </div>
            <button onclick="closeKycModal()" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- KYC Modal Body -->
        <div style="padding:20px; overflow-y:auto; flex:1;" id="kyc-modal-body-content">
            <!-- KYC Status Banner -->
            <div id="kyc-status-banner-box" style="margin-bottom:18px; padding:14px; border-radius:12px; display:none;"></div>

            <!-- KYC Submission Form -->
            <form id="kyc-submit-form" onsubmit="submitKycForm(event)" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#cbd5e1; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">
                        ডকুমেন্টের ধরণ নির্বাচন করুন <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="document_type" id="kyc-doc-type" required style="width:100%; height:42px; background:#07101d; border:1.5px solid #1d3354; border-radius:8px; color:#fff; padding:0 12px; font-size:13px; font-weight:700; outline:none;">
                        <option value="nid">জাতীয় পরিচয়পত্র (National ID / NID Card)</option>
                        <option value="passport">পাসপোর্ট (International Passport)</option>
                        <option value="birth_certificate">জন্ম নিবন্ধন সনদ (Birth Registration Certificate)</option>
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:800; color:#cbd5e1; margin-bottom:6px;">ডকুমেন্ট নাম্বার</label>
                        <input type="text" name="document_number" id="kyc-doc-number" placeholder="যেমন: 199012345678" style="width:100%; height:40px; background:#07101d; border:1px solid #1d3354; border-radius:8px; color:#fff; padding:0 12px; font-size:13px; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:800; color:#cbd5e1; margin-bottom:6px;">পূর্ণ নাম (ডকুমেন্ট অনুযায়ী)</label>
                        <input type="text" name="full_name" id="kyc-doc-name" value="{{ auth()->user()->name ?? '' }}" placeholder="আপনার নাম" style="width:100%; height:40px; background:#07101d; border:1px solid #1d3354; border-radius:8px; color:#fff; padding:0 12px; font-size:13px; outline:none;">
                    </div>
                </div>

                <!-- Image Uploads Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">
                    <!-- Front Part -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:800; color:#cbd5e1; margin-bottom:6px;">
                            সামনের পাতা (Front Part) <span style="color:#ef4444;">*</span>
                        </label>
                        <div onclick="document.getElementById('kyc-front-file').click()" style="border:2px dashed #0284c7; border-radius:10px; padding:16px 10px; text-align:center; background:#07101d; cursor:pointer; transition:all 0.2s;" id="kyc-front-dropzone">
                            <i class="fas fa-cloud-arrow-up" style="font-size:26px; color:#00f2fe; margin-bottom:6px;"></i>
                            <div style="font-size:11.5px; font-weight:700; color:#cbd5e1;" id="kyc-front-filename">ছবি সিলেক্ট করুন</div>
                            <div style="font-size:10px; color:#64748b;">JPG, PNG, WEBP (সর্বোচ্চ 8MB)</div>
                            <img id="kyc-front-preview" style="display:none; width:100%; height:110px; object-fit:cover; border-radius:6px; margin-top:8px; border:1px solid #00f2fe;">
                        </div>
                        <input type="file" name="front_image" id="kyc-front-file" accept="image/*" required style="display:none;" onchange="previewKycImage(this, 'kyc-front-preview', 'kyc-front-filename')">
                    </div>

                    <!-- Back Part -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:800; color:#cbd5e1; margin-bottom:6px;">
                            পেছনের পাতা (Back Part)
                        </label>
                        <div onclick="document.getElementById('kyc-back-file').click()" style="border:2px dashed #334155; border-radius:10px; padding:16px 10px; text-align:center; background:#07101d; cursor:pointer; transition:all 0.2s;" id="kyc-back-dropzone">
                            <i class="fas fa-cloud-arrow-up" style="font-size:26px; color:#94a3b8; margin-bottom:6px;"></i>
                            <div style="font-size:11.5px; font-weight:700; color:#cbd5e1;" id="kyc-back-filename">ছবি সিলেক্ট করুন</div>
                            <div style="font-size:10px; color:#64748b;">JPG, PNG, WEBP (ঐচ্ছিক)</div>
                            <img id="kyc-back-preview" style="display:none; width:100%; height:110px; object-fit:cover; border-radius:6px; margin-top:8px; border:1px solid #3b82f6;">
                        </div>
                        <input type="file" name="back_image" id="kyc-back-file" accept="image/*" style="display:none;" onchange="previewKycImage(this, 'kyc-back-preview', 'kyc-back-filename')">
                    </div>
                </div>

                <button type="submit" id="kyc-submit-btn" style="width:100%; height:44px; border:none; border-radius:10px; background:linear-gradient(135deg, #0284c7 0%, #00f2fe 100%); color:#040914; font-weight:900; font-size:14px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 6px 20px rgba(0,242,254,0.3); text-transform:uppercase; letter-spacing:0.5px;">
                    <i class="fas fa-paper-plane"></i> <span>কেওয়াইসি সাবমিট করুন</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Include Global Win Celebration Motion Graphics -->
<script src="{{ asset('js/win-celebration.js') }}"></script>

<script>
/* ==========================================================================
   KYC VERIFICATION CLIENT JS
   ========================================================================== */
function openKycModal() {
    const modal = document.getElementById('kyc-verification-modal');
    if (!modal) return;
    modal.style.display = 'flex';
    fetchKycStatus();
}

function closeKycModal() {
    const modal = document.getElementById('kyc-verification-modal');
    if (modal) modal.style.display = 'none';
}

function previewKycImage(input, previewId, labelId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById(labelId).innerText = file.name.length > 18 ? file.name.substring(0, 15) + '...' : file.name;
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function fetchKycStatus() {
    fetch('{{ route("kyc.status") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;
        const banner = document.getElementById('kyc-status-banner-box');
        const form = document.getElementById('kyc-submit-form');
        const status = data.status;
        const kyc = data.kyc;

        if (status === 'verified') {
            banner.style.display = 'block';
            banner.style.background = 'rgba(16,185,129,0.12)';
            banner.style.border = '1.5px solid #10b981';
            banner.innerHTML = `
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-check-circle" style="font-size:28px; color:#10b981;"></i>
                    <div>
                        <div style="font-weight:900; color:#10b981; font-size:15px;">অভিনন্দন! আপনার অ্যাকাউন্ট ভেরিফাইড (Verified)</div>
                        <div style="font-size:12px; color:#cbd5e1; margin-top:2px;">ডকুমেন্ট: ${kyc.document_label} (${kyc.document_number || 'N/A'})</div>
                    </div>
                </div>
            `;
            form.style.display = 'none';
        } else if (status === 'pending') {
            banner.style.display = 'block';
            banner.style.background = 'rgba(245,158,11,0.12)';
            banner.style.border = '1.5px solid #f59e0b';
            banner.innerHTML = `
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-hourglass-half" style="font-size:28px; color:#fbbf24; animation:spin 4s linear infinite;"></i>
                    <div>
                        <div style="font-weight:900; color:#fbbf24; font-size:15px;">কেওয়াইসি পর্যালোচনায় রয়েছে (Under Review / Pending)</div>
                        <div style="font-size:12px; color:#cbd5e1; margin-top:2px;">সাবমিট তারিখ: ${kyc.submitted_at}। অ্যাডমিন দ্রুত এটি যাচাই করে অনুমোদন দেবে।</div>
                    </div>
                </div>
            `;
            form.style.display = 'none';
        } else if (status === 'rejected') {
            banner.style.display = 'block';
            banner.style.background = 'rgba(239,68,68,0.12)';
            banner.style.border = '1.5px solid #ef4444';
            banner.innerHTML = `
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-times-circle" style="font-size:28px; color:#ef4444;"></i>
                    <div>
                        <div style="font-weight:900; color:#ef4444; font-size:15px;">পূর্ববর্তী আবেদনটি বাতিল (Rejected) হয়েছে</div>
                        <div style="font-size:12px; color:#fca5a5; margin-top:2px;">কারণ: ${kyc.rejection_reason || 'তথ্য স্পষ্ট নয়'}</div>
                        <div style="font-size:11px; color:#cbd5e1; margin-top:4px;">নিচে সঠিক ডকুমেন্ট দিয়ে পুনরায় সাবমিট করুন:</div>
                    </div>
                </div>
            `;
            form.style.display = 'block';
        } else {
            banner.style.display = 'none';
            form.style.display = 'block';
        }
    })
    .catch(() => {});
}

function submitKycForm(e) {
    e.preventDefault();
    const form = document.getElementById('kyc-submit-form');
    const formData = new FormData(form);
    const btn = document.getElementById('kyc-submit-btn');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>আপলোড হচ্ছে...</span>';

    fetch('{{ route("kyc.submit") }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>কেওয়াইসি সাবমিট করুন</span>';

        if (data.success) {
            alert(data.message);
            fetchKycStatus();
            // Update header button status
            const kycBtn = document.querySelector('.nav-btn-kyc');
            if (kycBtn) {
                kycBtn.style.color = '#fbbf24';
                kycBtn.style.borderColor = '#f59e0b';
                kycBtn.innerHTML = '<i class="fas fa-clock" style="color:#fbbf24;"></i> <span>পেন্ডিং</span>';
            }
        } else {
            alert(data.message || 'সাবমিট ব্যর্থ হয়েছে।');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>কেওয়াইসি সাবমিট করুন</span>';
        alert('সার্ভার এরর অথবা নেটওয়ার্ক সমস্যা হয়েছে।');
    });
}
</script>



