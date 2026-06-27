<!-- 1xBet Style Header Nav Bar -->
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
</style>

<nav class="dashboard-header-nav">
    <div class="dashboard-nav-logo" style="display: flex; align-items: center; gap: 8px;">
        <a href="{{ route('dashboard') }}" style="text-decoration: none;">
            <span class="logo-text" style="font-style: italic; font-weight: 900; font-size: 24px; letter-spacing: -0.5px; color: #1a76d2; text-shadow: 0 0 10px rgba(26, 118, 210, 0.3);">
                <span style="color: #ffffff;">1X</span>BET
            </span>
        </a>
    </div>
    
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
                    <i class="fas fa-user-circle" style="font-size:14px; color:#8ca3c7;"></i> CABINET
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

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
function handleHeaderAction(action, modalId) {
    if (window.location.pathname.endsWith('/dashboard')) {
        if (action === 'modal') {
            openModal(modalId);
        } else if (action === 'cabinet') {
            toggleCabinet(true);
        }
    } else {
        if (action === 'modal') {
            window.location.href = "{{ route('dashboard') }}?modal=" + (modalId === 'deposit-modal' ? 'deposit' : 'withdraw');
        } else if (action === 'cabinet') {
            window.location.href = "{{ route('dashboard') }}?tab=cabinet";
        }
    }
}

function handleLogout(e) {
    if (e) e.preventDefault();
    document.getElementById('logout-form').submit();
}
</script>
