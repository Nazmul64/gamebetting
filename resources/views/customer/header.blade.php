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

        <a href="{{ route('dashboard') }}" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <span class="logo-text" style="font-style: italic; font-weight: 900; font-size: 24px; letter-spacing: -0.5px; color: #1a76d2; text-shadow: 0 0 10px rgba(26, 118, 210, 0.3);">
                <span style="color: #ffffff;">1X</span>BET
            </span>
        </a>
    </div>
    
    <!-- Desktop Navigation Links -->
    <ul class="dashboard-nav-links" style="display: flex; list-style: none; gap: 20px; font-size: 13px; font-weight: 700; margin: 0; padding: 0;">
        <li><a href="{{ route('home') }}" style="color: #8ca3c7; text-decoration: none;">TOP-EVENTS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LEAGUE OF WINS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">T20 BLAST</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">CRICKET</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">SPORTS</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">LIVE</a></li>
        <li><a href="{{ route('play') }}" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-plane-departure" style="font-size:12px; margin-right:4px;"></i> 1XGAMES</a></li>
        <li><a href="{{ route('dashboard') }}" style="color: #ffffff; text-decoration: none; border-bottom: 3px solid #007bff; padding-bottom: 6px;">CASINO</a></li>
        <li><a href="{{ route('gems-mines') }}" style="color: #ffbe1a; text-decoration: none;"><i class="fas fa-gem" style="font-size:12px; margin-right:4px;"></i> Gems & Mines</a></li>
        <li><a href="{{ route('big-bass-splash') }}" style="color: #38ef7d; text-decoration: none;"><i class="fas fa-fish" style="font-size:12px; margin-right:4px;"></i> Big Bass Splash</a></li>
        <li><a href="#" style="color: #8ca3c7; text-decoration: none;">MORE <i class="fas fa-chevron-down" style="font-size: 9px; margin-left: 2px;"></i></a></li>
    </ul>
    
    <!-- Header Actions (Deposit / Withdraw / Balance / Cabinet) -->
    <div class="dashboard-nav-actions" style="display: flex; align-items: center; gap: 12px;">
        @auth
            <!-- Header Balance Display -->
            <div class="balance-container" style="background: #112038; border: 1.5px solid #1d3354; border-radius: 6px; padding: 0 14px; height: 38px; display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <span class="balance-label" style="font-size: 10px; color: #8ca3c7; letter-spacing: 0.5px;">BALANCE:</span>
                <span class="balance-value header-balance-value" style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-size: 15px;">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                <span class="balance-currency" style="color: #ffffff; font-size: 11px;">{{ auth()->user()->currency }}</span>
            </div>

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
                    </div>
                </div>

                <div class="drawer-balance-badge">
                    <span style="font-size: 10px; color: #8ca3c7; font-weight: 700;">MAIN BALANCE</span>
                    <span style="color: #ffbe1a; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 14px;">
                        {{ number_format(auth()->user()->balance, 2, '.', '') }} {{ auth()->user()->currency }}
                    </span>
                </div>

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
</script>

