<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aviator - Sports Escrow Bets Peer to Peer</title>
    <!-- Google Fonts for premium typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('game.css') }}">
</head>
<body class="landing-body">
    <!-- Background Floating Elements (Coin Silhouettes) -->
    <div class="floating-coins-container">
        <div class="floating-coin coin-btc"><i class="fa-brands fa-bitcoin"></i></div>
        <div class="floating-coin coin-eth"><i class="fa-brands fa-ethereum"></i></div>
        <div class="floating-coin coin-trophy"><i class="fas fa-trophy"></i></div>
        <div class="floating-coin coin-btc-2"><i class="fa-brands fa-bitcoin"></i></div>
    </div>

    <!-- Mobile Drawer Sidebar Menu -->
    <div class="mobile-drawer" id="mobile-drawer">
        <div class="drawer-header">
            <div class="nav-logo">
                <svg class="logo-image-main" viewBox="0 0 40 40" width="30" height="30" fill="none">
                    <path d="M5 25 L35 15 L25 10 L15 15 Z" fill="#f06424" />
                    <circle cx="20" cy="18" r="4" fill="#ffbe1a" />
                </svg>
                <span class="logo-text-accent">Aviator</span>
            </div>
            <button class="close-drawer-btn" id="close-drawer-btn" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="drawer-links">
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#how-to-play">How to Play</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#leaderboard">Leaderboard</a></li>
            <li><a href="#faqs">FAQs</a></li>
            <li><a href="#help">Help Center</a></li>
            <li><a href="https://t.me/example_group" target="_blank">Telegram Group</a></li>
        </ul>
        <div class="drawer-actions" id="landing-drawer-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-btn-purple">Dashboard</a>
                <a href="#" onclick="handleLogout(event)" class="nav-btn-purple transparent" style="border: 1px solid rgba(255,255,255,0.15);">Logout</a>
            @else
                <button onclick="openAuthModal('login')" class="nav-btn-purple transparent" style="border: 1px solid rgba(255,255,255,0.15);">Login</button>
                <button onclick="openAuthModal('signup')" class="nav-btn-purple">Sign Up</button>
            @endauth
        </div>
    </div>
    <!-- Drawer Backdrop Overlay -->
    <div class="drawer-backdrop" id="drawer-backdrop"></div>

    <div class="landing-wrapper">
        <!-- Top Navbar -->
        <nav class="landing-nav">
            <div class="nav-logo">
                <svg class="logo-image-main" viewBox="0 0 40 40" width="30" height="30" fill="none">
                    <path d="M5 25 L35 15 L25 10 L15 15 Z" fill="#f06424" />
                    <circle cx="20" cy="18" r="4" fill="#ffbe1a" />
                </svg>
                <span class="logo-text-accent">Aviator</span>
            </div>
            
            <ul class="nav-links">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#how-to-play">How to Play</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#leaderboard">Leaderboard</a></li>
                <li><a href="#faqs">FAQs</a></li>
                <li><a href="#help">Help Center</a></li>
            </ul>
            
            <div class="nav-actions" id="landing-nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-btn-purple">Dashboard</a>
                    <a href="#" onclick="handleLogout(event)" class="nav-btn-purple transparent" style="border: 1px solid rgba(255,255,255,0.15); margin-left: 6px;">Logout</a>
                @else
                    <button onclick="openAuthModal('login')" class="nav-btn-purple transparent" style="margin-right: 6px; border: 1px solid rgba(255,255,255,0.15);">Login</button>
                    <button onclick="openAuthModal('signup')" class="nav-btn-purple">Sign Up</button>
                @endauth
                <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            </div>
        </nav>

        <!-- Hero Content Section -->
        <main class="hero-section">
            <!-- Left Info Column -->
            <div class="hero-info-column">
                <span class="win-badge">Bet & Win Today!</span>
                <h1 class="hero-title">Sports Escrow<br>Bets Peer 2 Peer</h1>
                <p class="hero-description">
                    The fastest, easiest way to bet on sports. Play the multiplier curve, cash out at the optimal moment, and secure your payouts. 100% automated escrow systems.
                </p>
                <div class="hero-cta-group">
                    <button class="play-now-btn" id="hero-play-btn">Play Crash Game</button>
                    <a href="#how-to-play" class="try-demo-btn">Learn to Play</a>
                </div>
            </div>

            <!-- Right Graphic Column -->
            <div class="hero-visual-column">
                <!-- Stadium Background Glow Silhouette -->
                <div class="stadium-silhouette">
                    <div class="stadium-lights left-lights">
                        <div class="light-dot"></div><div class="light-dot"></div><div class="light-dot"></div>
                        <div class="light-dot"></div><div class="light-dot"></div><div class="light-dot"></div>
                    </div>
                    <div class="stadium-lights right-lights">
                        <div class="light-dot"></div><div class="light-dot"></div><div class="light-dot"></div>
                        <div class="light-dot"></div><div class="light-dot"></div><div class="light-dot"></div>
                    </div>

                    <!-- Interactive Demo Canvas Panel -->
                    <div class="landing-canvas-mockup">
                        <span class="demo-badge"><i class="fas fa-circle-nodes pulse-icon-green"></i> LIVE SIMULATOR</span>
                        <span class="demo-multiplier" id="demo-multiplier-text">1.00x</span>
                        <canvas id="landing-demo-canvas"></canvas>
                        
                        <!-- Crash alert overlay -->
                        <div class="demo-crash-alert hidden" id="demo-crash-alert">
                            <div class="demo-crash-title">FLEW AWAY</div>
                            <div class="demo-crash-multiplier" id="demo-crash-value">1.45x</div>
                        </div>
                    </div>

                    <div class="mockup-logo-overlay">
                        <span class="aviator-red-text">Aviator</span>
                    </div>
                </div>
            </div>
        </main>

        <!-- Live Winners Ticker Bar -->
        <section class="live-winners-ticker">
            <div class="ticker-header"><i class="fas fa-circle-nodes pulse-icon-green"></i> LIVE BIG WINNERS</div>
            <div class="ticker-content-wrapper">
                <div class="ticker-scroll-track">
                    <span class="ticker-item"><span class="text-gold">User: *****35</span> | Bet: 500 BDT | Cashed: <span class="badge-success-light">12.04x</span> | Won: <span class="text-green">6,020 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****88</span> | Bet: 2000 BDT | Cashed: <span class="badge-success-light">4.33x</span> | Won: <span class="text-green">8,660 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****19</span> | Bet: 300 BDT | Cashed: <span class="badge-success-light">18.50x</span> | Won: <span class="text-green">5,550 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****73</span> | Bet: 1000 BDT | Cashed: <span class="badge-success-light">2.15x</span> | Won: <span class="text-green">2,150 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****44</span> | Bet: 800 BDT | Cashed: <span class="badge-success-light">9.50x</span> | Won: <span class="text-green">7,600 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****35</span> | Bet: 500 BDT | Cashed: <span class="badge-success-light">12.04x</span> | Won: <span class="text-green">6,020 BDT</span></span>
                    <span class="ticker-item"><span class="text-gold">User: *****88</span> | Bet: 2000 BDT | Cashed: <span class="badge-success-light">4.33x</span> | Won: <span class="text-green">8,660 BDT</span></span>
                </div>
            </div>
        </section>

        <!-- Section: How to Play -->
        <section class="landing-section" id="how-to-play">
            <h2 class="section-heading">How to Play Crash</h2>
            <p class="section-subheading">Three simple steps to start winning real BDT multipliers instantly.</p>
            
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-card-icon"><i class="fas fa-coins"></i></div>
                    <h3 class="step-card-title">Place Your Bets</h3>
                    <p class="step-card-desc">Enter your bet size and click the orange "PLACE BET" button. You can place two independent bets at the same time for double winning tactics.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-card-icon"><i class="fas fa-plane-departure"></i></div>
                    <h3 class="step-card-title">Watch Jet Takeoff</h3>
                    <p class="step-card-desc">The golden supersonic fighter jet starts flying. Watch the curve rise, multiplier ticking up exponentially from 1.00x.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-card-icon"><i class="fas fa-hand-holding-dollar"></i></div>
                    <h3 class="step-card-title">Cash Out & Win BDT</h3>
                    <p class="step-card-desc">Click the green "CASH OUT" button before the jet crashes to win. Your payouts equal your bet multiplied by the cashout odds!</p>
                </div>
            </div>
        </section>

        <!-- Section: Live Leaderboard Tab panel -->
        <section class="landing-section" id="leaderboard">
            <h2 class="section-heading">Live Betting Statistics</h2>
            <p class="section-subheading">Track live active bets, history crash points, and massive daily payouts.</p>
            
            <div class="leaderboard-tabs-container">
                <div class="tabs-header">
                    <button class="tab-btn active" id="btn-tab-live-bets">
                        <i class="fas fa-gamepad"></i> Live Bets
                    </button>
                    <button class="tab-btn" id="btn-tab-crash-history">
                        <i class="fas fa-history"></i> Crash History
                    </button>
                    <button class="tab-btn" id="btn-tab-top-wins">
                        <i class="fas fa-trophy"></i> Monthly Top Wins
                    </button>
                </div>

                <!-- Tab Panel 1: Live Bets -->
                <div class="tab-panel active" id="tab-live-bets">
                    <div class="leaderboard-table-wrapper">
                        <table class="leaderboard-table">
                            <thead>
                                <tr>
                                    <th>USER</th>
                                    <th>BET AMOUNT</th>
                                    <th>CASHOUT</th>
                                    <th>WINNINGS</th>
                                </tr>
                            </thead>
                            <tbody id="landing-live-bets-tbody">
                                <!-- Populated dynamically by script -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel 2: Crash History -->
                <div class="tab-panel" id="tab-crash-history">
                    <div class="history-grid-landing">
                        <span class="badge-odd badge-high">35.40x</span>
                        <span class="badge-odd badge-medium">4.50x</span>
                        <span class="badge-odd badge-low">1.12x</span>
                        <span class="badge-odd badge-medium">2.84x</span>
                        <span class="badge-odd badge-high">12.04x</span>
                        <span class="badge-odd badge-low">1.03x</span>
                        <span class="badge-odd badge-medium">5.12x</span>
                        <span class="badge-odd badge-medium">1.85x</span>
                        <span class="badge-odd badge-low">1.25x</span>
                        <span class="badge-odd badge-high">94.30x</span>
                        <span class="badge-odd badge-medium">3.22x</span>
                        <span class="badge-odd badge-low">1.01x</span>
                        <span class="badge-odd badge-medium">2.15x</span>
                        <span class="badge-odd badge-medium">8.50x</span>
                        <span class="badge-odd badge-low">1.44x</span>
                    </div>
                </div>

                <!-- Tab Panel 3: Monthly Top Wins -->
                <div class="tab-panel" id="tab-top-wins">
                    <div class="leaderboard-table-wrapper">
                        <table class="leaderboard-table">
                            <thead>
                                <tr>
                                    <th>USER</th>
                                    <th>BET AMOUNT</th>
                                    <th>MULTIPLIER</th>
                                    <th>WINNINGS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="text-gold">********77</span></td>
                                    <td>1,200 BDT</td>
                                    <td><span class="badge-success-light">240.50x</span></td>
                                    <td><span class="text-green">288,600.00 BDT</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text-gold">********15</span></td>
                                    <td>3,000 BDT</td>
                                    <td><span class="badge-success-light">84.10x</span></td>
                                    <td><span class="text-green">252,300.00 BDT</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text-gold">********93</span></td>
                                    <td>800 BDT</td>
                                    <td><span class="badge-success-light">180.20x</span></td>
                                    <td><span class="text-green">144,160.00 BDT</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text-gold">********42</span></td>
                                    <td>2,500 BDT</td>
                                    <td><span class="badge-success-light">52.33x</span></td>
                                    <td><span class="text-green">130,825.00 BDT</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Fairness -->
        <section class="landing-section" id="fairness">
            <h2 class="section-heading"><i class="fas fa-shield-halved text-orange"></i> Provably Fair Gaming</h2>
            <p class="section-subheading">Verify multiplier outcomes and seeds cryptographically.</p>
            
            <div class="fairness-card">
                <div class="fairness-card-left">
                    <h3 class="fairness-title">SHA-256 Predetermined Multipliers</h3>
                    <p class="fairness-desc">
                        Our crash multipliers are determined using a transparent, provably fair cryptographic algorithm before takeoff. This makes it mathematically impossible for the platform to adjust flight outcomes mid-game.
                    </p>
                    <div class="verify-inputs">
                        <div class="verify-input-group">
                            <span class="verify-label">Next Round SHA-256 Server Hash:</span>
                            <code class="verify-code">a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2</code>
                        </div>
                    </div>
                </div>
                <div class="fairness-card-right">
                    <div class="shield-graphic-container">
                        <i class="fas fa-lock shield-lock-icon"></i>
                        <span class="shield-badge">VERIFIED CRYPTO SHIELD</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Features (Why Choose Us) -->
        <section class="landing-section" id="features">
            <h2 class="section-heading">Why Choose Aviator Escrow?</h2>
            <p class="section-subheading">Enjoy state-of-the-art cryptographic fairness, instant transactions, and active gameplay.</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="feature-title">Provably Fair System</h3>
                    <p class="feature-desc">Every flight multiplier outcome is cryptographically verified on-chain, ensuring 100% transparent and unbiased results.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                    <h3 class="feature-title">Instant Cashouts (BDT)</h3>
                    <p class="feature-desc">Cash out your winnings instantly to mobile wallet systems like bKash, Nagad, and Rocket with zero delays.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-layer-group"></i></div>
                    <h3 class="feature-title">Double Betting Boards</h3>
                    <p class="feature-desc">Place two independent bets on the same round. Run one on manual cashout and configure the other on auto-play.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-volume-high"></i></div>
                    <h3 class="feature-title">Web Audio Soundscapes</h3>
                    <p class="feature-desc">Immerse yourself with rich synthesized soundscapes that speed up with the jet and rumble deeply during crashes.</p>
                </div>
            </div>
        </section>

        <!-- Section: FAQs (Accordion) -->
        <section class="landing-section" id="faqs">
            <h2 class="section-heading">Frequently Asked Questions</h2>
            <p class="section-subheading">Get answers to the most common queries about the Aviator game mechanics.</p>
            
            <div class="faqs-container">
                <details class="faq-item" open>
                    <summary class="faq-question">What is Sports Escrow Bets Peer 2 Peer?</summary>
                    <div class="faq-answer">
                        It is a multiplayer peer-to-peer gaming model where players bet on an increasing curve multiplier represented by a flying jet. Winnings are distributed instantly and securely from the escrow pool upon user cashout.
                    </div>
                </details>
                
                <details class="faq-item">
                    <summary class="faq-question">How does the Crash Game multiplier work?</summary>
                    <div class="faq-answer">
                        The multiplier starts growing exponentially from 1.00x upwards. The target crash point is predetermined at the start of each round by an unbiased RNG. If you press "CASH OUT" before the jet crashes, you win your bet amount multiplied by the current odds.
                    </div>
                </details>
                
                <details class="faq-item">
                    <summary class="faq-question">How can I place bets and cash out automatically?</summary>
                    <div class="faq-answer">
                        You can check the "ENABLE AUTOPLAY" button in the betting boards to automatically place the same bet for the next round. You can also specify target cashout odds so that the system secures your winnings automatically.
                    </div>
                </details>
                
                <details class="faq-item">
                    <summary class="faq-question">Are deposits and withdrawals secure?</summary>
                    <div class="faq-answer">
                        Yes, all deposits and withdrawals are processed through secured, end-to-end encrypted gateways. We integrate with leading mobile financial systems in Bangladesh (bKash, Nagad) to ensure safety.
                    </div>
                </details>
            </div>
        </section>

        <!-- Section: Help Center / Support Links -->
        <section class="landing-section" id="help">
            <h2 class="section-heading">Help Center & Support</h2>
            <p class="section-subheading">We are online 24/7. Get in touch with our support crew if you need any assistance.</p>
            
            <div class="help-grid">
                <div class="help-card">
                    <div class="help-card-icon text-orange"><i class="fa-brands fa-telegram"></i></div>
                    <h3 class="help-card-title">Telegram Channel</h3>
                    <p class="help-card-desc">Join our official community group for updates, promo codes, and live player discussions.</p>
                    <a href="https://t.me/example_group" class="help-card-link" target="_blank">JOIN TELEGRAM <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="help-card">
                    <div class="help-card-icon text-green"><i class="fas fa-headset"></i></div>
                    <h3 class="help-card-title">24/7 Email Support</h3>
                    <p class="help-card-desc">Send us a ticket detailing your query and our support team will reply within 15 minutes.</p>
                    <a href="mailto:support@example.com" class="help-card-link">SEND EMAIL <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="help-card">
                    <div class="help-card-icon text-gold"><i class="fas fa-book-open"></i></div>
                    <h3 class="help-card-title">User Guide & Rules</h3>
                    <p class="help-card-desc">Read our detailed gameplay guides, mathematical curves explanation, and terms of service.</p>
                    <a href="#faqs" class="help-card-link">VIEW GUIDE <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="landing-footer">
            <div class="footer-top">
                <div class="footer-brand">
                    <span class="logo-text-accent">Aviator</span>
                    <p class="footer-brand-desc">Escrow sports betting made easy and provably fair.</p>
                </div>
                <div class="footer-partners">
                    <span class="partners-title">ACCEPTED WALLETS</span>
                    <div class="partner-logos">
                        <span class="partner-badge"><i class="fas fa-mobile-screen"></i> bKash</span>
                        <span class="partner-badge"><i class="fas fa-mobile-screen"></i> Nagad</span>
                        <span class="partner-badge"><i class="fas fa-mobile-screen"></i> Rocket</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copyright">&copy; 2026 Aviator P2P Sports. All rights reserved.</span>
                <div class="footer-links">
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Responsible Gaming (18+)</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Auth Modal Container -->
    <div class="auth-modal-overlay hidden" id="auth-modal-overlay">
        <div class="auth-modal-box">
            <button class="auth-close-btn" id="auth-close-btn" aria-label="Close modal"><i class="fas fa-times"></i></button>
            
            <!-- Modal Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab-btn" id="tab-btn-signup"><i class="fas fa-user-plus"></i> SIGN UP</button>
                <button class="auth-tab-btn active" id="tab-btn-login"><i class="fas fa-sign-in-alt"></i> LOGIN</button>
            </div>

            <!-- Error Notification Banner -->
            <div id="auth-error-banner" style="display:none; background-color:rgba(235, 64, 52, 0.2); border:1px solid #eb4034; color:#fff; padding:10px; border-radius:6px; margin: 10px 20px; font-size:12px;"></div>

            <!-- Login Form -->
            <div class="auth-form-content" id="form-login">
                <h3 class="auth-form-title">Login to Your Account</h3>
                <form id="login-form" onsubmit="handleLoginSubmit(event)">
                    <div class="form-group">
                        <label class="form-label">Email / Phone</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="text" class="auth-input" placeholder="Your email or phone number" required id="login-username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-input-wrapper input-icon-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="auth-input" placeholder="Enter your password" required id="login-password" style="padding-left: 42px;">
                            <button type="button" class="toggle-password-visibility" onclick="togglePassword('login-password', this)"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="form-checkbox-row">
                        <label class="checkbox-label">
                            <input type="checkbox" id="login-remember" checked>
                            <span>Remember Me</span>
                        </label>
                        <a href="#" class="forgot-password-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="auth-submit-btn">LOGIN</button>
                </form>
                <div class="auth-footer">
                    Not a member? <span class="auth-link-switch" onclick="switchAuthTab('signup')">Register Now</span>
                </div>
            </div>

            <!-- Signup Form -->
            <div class="auth-form-content hidden" id="form-signup">
                <h3 class="auth-form-title">Create a Free Account</h3>
                <form id="signup-form" onsubmit="handleSignupSubmit(event)">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="auth-input" placeholder="Enter your full name" required id="signup-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select class="auth-select" id="signup-gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" class="auth-input" placeholder="e.g. 01700000000" required id="signup-mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="auth-input" placeholder="e.g. name@example.com" required id="signup-email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-input-wrapper input-icon-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="auth-input" placeholder="Minimum 6 characters" required id="signup-password" style="padding-left: 42px;">
                            <button type="button" class="toggle-password-visibility" onclick="togglePassword('signup-password', this)"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-globe input-icon"></i>
                            <select class="auth-select" id="signup-country" onchange="syncSignupCurrency()">
                                <option value="">Select Country...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Currency</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-coins input-icon"></i>
                            <select class="auth-select" id="signup-currency">
                                <option value="">Select Currency...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Promo Code (Optional)</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-gift input-icon"></i>
                            <input type="text" class="auth-input" placeholder="Enter promo code if any">
                        </div>
                    </div>
                    <div class="form-checkbox-row">
                        <label class="checkbox-label">
                            <input type="checkbox" required checked>
                            <span style="font-size: 11px;">I confirm that I am of legal age and agree with the site rules</span>
                        </label>
                    </div>
                    <button type="submit" class="auth-submit-btn">SIGN UP</button>
                </form>
                <div class="auth-footer">
                    Already have an account? <span class="auth-link-switch" onclick="switchAuthTab('login')">Login Here</span>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Floating Live Chat Support Widget -->
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
                        Hello! 👋 Welcome to Aviator P2P Sports Support. How can we help you today?
                    </div>
                    <span class="msg-time">Just now</span>
                </div>
                <div class="chat-quick-options">
                    <span class="quick-option-title">Suggested Questions:</span>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How do I deposit BDT?')">How do I deposit BDT?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('Is the multiplier fair?')">Is the multiplier fair?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How does P2P escrow work?')">How does P2P escrow work?</button>
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

    <!-- Hidden Form for CSRF-safe Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Script block for mini simulator and mobile drawer operations -->
    <script>
    // 1. Mobile Menu Drawer Controller
    (function() {
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-drawer-btn');
        const drawer = document.getElementById('mobile-drawer');
        const backdrop = document.getElementById('drawer-backdrop');
        const drawerLinks = document.querySelectorAll('.drawer-links a');

        function openMenu() {
            drawer.classList.add('open');
            backdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            drawer.classList.remove('open');
            backdrop.classList.remove('open');
            document.body.style.overflow = '';
        }

        if (menuBtn) menuBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (backdrop) backdrop.addEventListener('click', closeMenu);

        drawerLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    })();

    // 2. Tab switcher for Payouts widget
    (function() {
        const liveBetsBtn = document.getElementById('btn-tab-live-bets');
        const crashHistBtn = document.getElementById('btn-tab-crash-history');
        const topWinsBtn = document.getElementById('btn-tab-top-wins');

        const liveBetsTab = document.getElementById('tab-live-bets');
        const crashHistTab = document.getElementById('tab-crash-history');
        const topWinsTab = document.getElementById('tab-top-wins');

        const buttons = [liveBetsBtn, crashHistBtn, topWinsBtn];
        const panels = [liveBetsTab, crashHistTab, topWinsTab];

        function switchTab(activeIndex) {
            buttons.forEach((btn, idx) => {
                if (idx === activeIndex) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            panels.forEach((pnl, idx) => {
                if (idx === activeIndex) {
                    pnl.classList.add('active');
                } else {
                    pnl.classList.remove('active');
                }
            });
        }

        if (liveBetsBtn) liveBetsBtn.addEventListener('click', () => switchTab(0));
        if (crashHistBtn) crashHistBtn.addEventListener('click', () => switchTab(1));
        if (topWinsBtn) topWinsBtn.addEventListener('click', () => switchTab(2));
    })();

    // 3. Mini Flight Simulation Canvas Widget (Hero section)
    (function() {
        const canvas = document.getElementById('landing-demo-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const multText = document.getElementById('demo-multiplier-text');
        const alertBox = document.getElementById('demo-crash-alert');
        const alertVal = document.getElementById('demo-crash-value');

        let w, h;
        function resizeDemo() {
            if (!canvas.parentElement) return;
            w = canvas.width = canvas.parentElement.clientWidth;
            h = canvas.height = canvas.parentElement.clientHeight || 200;
        }
        resizeDemo();
        setTimeout(resizeDemo, 100);
        window.addEventListener('resize', resizeDemo);

        let state = 'COUNTDOWN';
        let timer = 3.0;
        let startTime = 0;
        let flightTime = 0;
        let multiplier = 1.00;
        let crashPoint = 2.45;
        let trailPoints = [];
        let explosionParticles = [];

        class DemoParticle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                const angle = Math.random() * Math.PI * 2;
                const speed = Math.random() * 4 + 1.5;
                this.vx = Math.cos(angle) * speed;
                this.vy = Math.sin(angle) * speed - 0.5;
                this.life = 1.0;
                this.decay = Math.random() * 0.03 + 0.015;
                this.size = Math.random() * 8 + 3;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.life -= this.decay;
                this.size *= 0.95;
            }
            draw() {
                ctx.save();
                ctx.globalAlpha = this.life;
                ctx.fillStyle = Math.random() < 0.6 ? '#f06424' : '#ffbe1a';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }

        function loop() {
            ctx.clearRect(0, 0, w, h);

            ctx.strokeStyle = 'rgba(36, 52, 92, 0.2)';
            ctx.lineWidth = 1;
            const spacing = 40;
            for (let x = 0; x < w; x += spacing) {
                ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, h); ctx.stroke();
            }
            for (let y = 0; y < h; y += spacing) {
                ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(w, y); ctx.stroke();
            }

            if (state === 'COUNTDOWN') {
                multText.textContent = `Starts in ${Math.ceil(timer)}s`;
                multText.style.color = '#ffbe1a';
                alertBox.classList.add('hidden');
                drawMiniPlane(30, h - 25, -20 * Math.PI / 180);

                timer -= 1/60;
                if (timer <= 0) {
                    state = 'FLIGHT';
                    startTime = Date.now();
                    crashPoint = 1.1 + Math.random() * 4.5;
                    if (Math.random() < 0.15) crashPoint = 1.00;
                    trailPoints = [];
                }
            } 
            else if (state === 'FLIGHT') {
                flightTime = (Date.now() - startTime) / 1000;
                multiplier = Math.exp(0.25 * flightTime);
                multText.textContent = multiplier.toFixed(2) + 'x';
                multText.style.color = '#ffffff';

                const startX = 0;
                const startY = h;
                const xStep = flightTime * 50;
                const yStep = Math.pow(flightTime, 1.4) * 16;
                let targetX = startX + xStep;
                let targetY = startY - yStep;

                if (targetX > w * 0.75) targetX = w * 0.75;
                if (targetY < h * 0.25) targetY = h * 0.25;

                trailPoints.push({ x: targetX, y: targetY });

                if (trailPoints.length > 1) {
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    trailPoints.forEach(pt => ctx.lineTo(pt.x, pt.y));
                    ctx.lineTo(targetX, startY);
                    ctx.closePath();
                    const fillGrad = ctx.createLinearGradient(0, targetY, 0, startY);
                    fillGrad.addColorStop(0, 'rgba(240, 100, 36, 0.35)');
                    fillGrad.addColorStop(1, 'rgba(240, 100, 36, 0)');
                    ctx.fillStyle = fillGrad;
                    ctx.fill();

                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    trailPoints.forEach(pt => ctx.lineTo(pt.x, pt.y));
                    ctx.strokeStyle = '#ffbe1a';
                    ctx.lineWidth = 3;
                    ctx.stroke();
                    ctx.restore();
                }

                drawMiniPlane(targetX, targetY, -20 * Math.PI / 180);

                if (multiplier >= crashPoint) {
                    state = 'CRASHED';
                    timer = 2.0;
                    explosionParticles = [];
                    for (let i = 0; i < 30; i++) {
                        explosionParticles.push(new DemoParticle(targetX, targetY));
                    }
                }
            } 
            else if (state === 'CRASHED') {
                multText.textContent = 'FLEW AWAY';
                multText.style.color = '#eb4034';
                alertBox.classList.remove('hidden');
                alertVal.textContent = crashPoint.toFixed(2) + 'x';

                if (trailPoints.length > 1) {
                    ctx.beginPath();
                    ctx.moveTo(0, h);
                    trailPoints.forEach(pt => ctx.lineTo(pt.x, pt.y));
                    ctx.strokeStyle = 'rgba(235, 64, 52, 0.3)';
                    ctx.lineWidth = 3;
                    ctx.stroke();
                }

                explosionParticles.forEach(p => {
                    p.update();
                    p.draw();
                });

                timer -= 1/60;
                if (timer <= 0) {
                    state = 'COUNTDOWN';
                    timer = 3.0;
                }
            }

            requestAnimationFrame(loop);
        }

        function drawMiniPlane(x, y, rotation) {
            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(rotation);
            ctx.scale(1.2, 1.2);

            const goldGrad = ctx.createLinearGradient(-15, 0, 15, 0);
            goldGrad.addColorStop(0, '#e5a910');
            goldGrad.addColorStop(0.5, '#ffd13b');
            goldGrad.addColorStop(1, '#ffffff');

            ctx.fillStyle = goldGrad;
            ctx.beginPath();
            ctx.moveTo(15, -1);
            ctx.quadraticCurveTo(8, -4, -8, -3);
            ctx.lineTo(-12, 2);
            ctx.quadraticCurveTo(4, 3, 15, -1);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = '#f06424';
            ctx.beginPath();
            ctx.moveTo(-7, -2);
            ctx.lineTo(-14, -10);
            ctx.lineTo(-11, -10);
            ctx.lineTo(-3, -2);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = 'rgba(168, 225, 255, 0.7)';
            ctx.beginPath();
            ctx.moveTo(2, -2);
            ctx.quadraticCurveTo(8, -2, 10, -1);
            ctx.quadraticCurveTo(6, 1, 1, 1);
            ctx.closePath();
            ctx.fill();

            ctx.restore();
        }

        loop();
    })();

    // 4. Live Bets Simulated Tracker for Landing Page tab
    (function() {
        const tbody = document.getElementById('landing-live-bets-tbody');
        if (!tbody) return;

        const mockNames = ['********12', '********48', '********99', '********23', '********75', '********31', '********56', '********88'];
        let users = [];

        function initLiveBets() {
            tbody.innerHTML = '';
            users = [];
            mockNames.forEach((name, i) => {
                const bet = Math.floor(Math.random() * 40 + 2) * 50;
                const target = 1.05 + Math.random() * 5.0;
                users.push({
                    name,
                    bet,
                    target,
                    status: 'flying',
                    multiplier: 1.00
                });

                const tr = document.createElement('tr');
                tr.id = `landing-user-tr-${i}`;
                tr.innerHTML = `
                    <td>${name}</td>
                    <td>${bet.toFixed(2)} BDT</td>
                    <td class="td-odds">-</td>
                    <td class="td-win">-</td>
                `;
                tbody.appendChild(tr);
            });
        }

        let currMult = 1.00;

        function updateLiveStats() {
            if (currMult === 1.00) {
                initLiveBets();
            }

            currMult += 0.05 + (currMult * 0.015);
            if (currMult > 7.00) {
                currMult = 1.00;
                return;
            }

            users.forEach((u, i) => {
                const tr = document.getElementById(`landing-user-tr-${i}`);
                if (!tr) return;

                if (u.status === 'flying') {
                    if (currMult >= u.target) {
                        u.status = 'cashed';
                        const win = u.bet * u.target;
                        tr.classList.add('win-row-active');
                        tr.querySelector('.td-odds').innerHTML = `<span class="badge-success-light">x${u.target.toFixed(2)}</span>`;
                        tr.querySelector('.td-win').innerHTML = `<span class="text-green">${win.toFixed(2)} BDT</span>`;
                    }
                }
            });
        }

        setInterval(updateLiveStats, 200);
    })();

    // 5. Authentication and Modal Controller
    (function() {
        const overlay = document.getElementById('auth-modal-overlay');
        const closeBtn = document.getElementById('auth-close-btn');
        const tabSignup = document.getElementById('tab-btn-signup');
        const tabLogin = document.getElementById('tab-btn-login');
        const formLogin = document.getElementById('form-login');
        const formSignup = document.getElementById('form-signup');
        const errorBanner = document.getElementById('auth-error-banner');
        
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auth') === 'login') {
            openAuthModal('login');
        }

        window.togglePassword = function(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'far fa-eye';
            }
        };

        window.openAuthModal = function(type = 'login') {
            if (!overlay) return;
            errorBanner.style.display = 'none';
            overlay.classList.remove('hidden');
            switchAuthTab(type);
        };

        window.closeAuthModal = function() {
            if (!overlay) return;
            overlay.classList.add('hidden');
        };

        window.switchAuthTab = function(type) {
            errorBanner.style.display = 'none';
            if (type === 'signup') {
                tabSignup.classList.add('active');
                tabLogin.classList.remove('active');
                formSignup.classList.remove('hidden');
                formLogin.classList.add('hidden');
            } else {
                tabLogin.classList.add('active');
                tabSignup.classList.remove('active');
                formLogin.classList.remove('hidden');
                formSignup.classList.add('hidden');
            }
        };

        if (closeBtn) closeBtn.addEventListener('click', closeAuthModal);
        if (tabSignup) tabSignup.addEventListener('click', () => switchAuthTab('signup'));
        if (tabLogin) tabLogin.addEventListener('click', () => switchAuthTab('login'));

        // Form handlers via AJAX calling Laravel endpoints
        window.handleLoginSubmit = function(e) {
            e.preventDefault();
            errorBanner.style.display = 'none';

            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;
            const remember = document.getElementById('login-remember').checked;

            fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username, password, remember })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 && res.body.success) {
                    window.location.href = res.body.redirect;
                } else {
                    const errors = res.body.errors || ['An unexpected error occurred.'];
                    errorBanner.innerHTML = errors.join('<br>');
                    errorBanner.style.display = 'block';
                }
            })
            .catch(err => {
                errorBanner.innerHTML = 'Network connection failed. Please try again.';
                errorBanner.style.display = 'block';
            });
        };

        window.handleSignupSubmit = function(e) {
            e.preventDefault();
            errorBanner.style.display = 'none';

            const name = document.getElementById('signup-name').value;
            const gender = document.getElementById('signup-gender').value;
            const mobile = document.getElementById('signup-mobile').value;
            const email = document.getElementById('signup-email').value;
            const password = document.getElementById('signup-password').value;
            const country = document.getElementById('signup-country').value;
            const currency = document.getElementById('signup-currency').value;

            fetch('{{ route('register') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, gender, mobile, email, password, country, currency })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 && res.body.success) {
                    window.location.href = res.body.redirect;
                } else {
                    const errors = res.body.errors || ['An unexpected error occurred.'];
                    errorBanner.innerHTML = errors.join('<br>');
                    errorBanner.style.display = 'block';
                }
            })
            .catch(err => {
                errorBanner.innerHTML = 'Network connection failed. Please try again.';
                errorBanner.style.display = 'block';
            });
        };

        window.handleLogout = function(e) {
            if (e) e.preventDefault();
            document.getElementById('logout-form').submit();
        };

        const heroPlayBtn = document.getElementById('hero-play-btn');
        if (heroPlayBtn) {
            heroPlayBtn.onclick = function(e) {
                e.preventDefault();
                @auth
                    window.location.href = '{{ route('play') }}';
                @else
                    openAuthModal('login');
                @endauth
            };
        }
    })();

    // 6. Floating Live Support Chat Controller
    (function() {
        const triggerBtn = document.getElementById('chat-trigger-btn');
        const closeBtn = document.getElementById('chat-box-close');
        const boxContainer = document.getElementById('chat-box-container');
        const chatForm = document.getElementById('chat-send-form');
        const inputField = document.getElementById('chat-input-field');
        const chatBody = document.getElementById('chat-box-body');

        const isAuth = @json(auth()->check());
        let pollInterval = null;

        function toggleChat() {
            boxContainer.classList.toggle('hidden');
            scrollChatToBottom();
            if (isAuth && !boxContainer.classList.contains('hidden')) {
                loadSupportMessages();
                // Start polling when chat is open
                if (!pollInterval) {
                    pollInterval = setInterval(loadSupportMessages, 1500);
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

        function loadSupportMessages(force = false) {
            fetch('{{ route('support.messages') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderSupportMessages(data.messages, force);
                }
            })
            .catch(err => console.error("Error loading support messages:", err));
        }

        function renderSupportMessages(messages, force = false) {
            let html = `
                <div class="chat-msg msg-agent">
                    <div class="msg-bubble">
                        Hello! 👋 Welcome to Aviator P2P Sports Support. How can we help you today?
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
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How do I deposit BDT?')">How do I deposit BDT?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('Is the multiplier fair?')">Is the multiplier fair?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How does P2P escrow work?')">How does P2P escrow work?</button>
                    </div>
                `;
            }

            const currentCount = chatBody.querySelectorAll('.chat-msg').length;
            const newCount = messages.length + 1;

            if (force || currentCount !== newCount) {
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
                appendMessage(text, 'user');
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();
                
                setTimeout(() => {
                    typing.remove();
                    let reply = "Thank you for reaching out. A support agent will be with you shortly. If you have questions about deposits, they are processed instantly via bKash/Nagad.";
                    if (text.includes('deposit')) {
                        reply = "To deposit funds, click 'DEPOSIT' on your game dashboard page. Transfer BDT instantly using bKash, Nagad, or Rocket. The money will credit your account instantly with zero fees!";
                    } else if (text.includes('fair')) {
                        reply = "Our game is 100% Provably Fair. Multipliers are predetermined before takeoff using SHA-256 hash algorithms, so results cannot be manipulated by anyone.";
                    } else if (text.includes('escrow')) {
                        reply = "The escrow system locks user stakes safely at the beginning of each round. When you click CASH OUT, funds are automatically distributed directly from escrow to your balance.";
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
                appendMessage(text, 'user');
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();

                setTimeout(() => {
                    typing.remove();
                    appendMessage("Thank you for your message! Our support team is online 24/7 and will reply to your query here shortly. For immediate assistance with balance, check the help cards below.", 'agent');
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
                    loadSupportMessages(true);
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
            pollInterval = setInterval(loadSupportMessages, 1500);
        }
    })();

    // 7. Populate Country & Currency lists for Registration Flow
    (function() {
        const countryData = [
            { name: "Afghanistan", currency: "AFN", symbol: "؋" },
            { name: "Albania", currency: "ALL", symbol: "L" },
            { name: "Algeria", currency: "DZD", symbol: "د.ج" },
            { name: "Andorra", currency: "EUR", symbol: "€" },
            { name: "Angola", currency: "AOA", symbol: "Kz" },
            { name: "Argentina", currency: "ARS", symbol: "$" },
            { name: "Armenia", currency: "AMD", symbol: "֏" },
            { name: "Australia", currency: "AUD", symbol: "$" },
            { name: "Austria", currency: "EUR", symbol: "€" },
            { name: "Azerbaijan", currency: "AZN", symbol: "₼" },
            { name: "Bahamas", currency: "BSD", symbol: "$" },
            { name: "Bahrain", currency: "BHD", symbol: ".د.ب" },
            { name: "Bangladesh", currency: "BDT", symbol: "৳" },
            { name: "Barbados", currency: "BBD", symbol: "$" },
            { name: "Belarus", currency: "BYN", symbol: "Br" },
            { name: "Belgium", currency: "EUR", symbol: "€" },
            { name: "Belize", currency: "BZD", symbol: "$" },
            { name: "Benin", currency: "XOF", symbol: "CFA" },
            { name: "Bhutan", currency: "BTN", symbol: "Nu." },
            { name: "Bolivia", currency: "BOB", symbol: "Bs." },
            { name: "Bosnia and Herzegovina", currency: "BAM", symbol: "KM" },
            { name: "Botswana", currency: "BWP", symbol: "P" },
            { name: "Brazil", currency: "BRL", symbol: "R$" },
            { name: "Brunei", currency: "BND", symbol: "$" },
            { name: "Bulgaria", currency: "BGN", symbol: "лв" },
            { name: "Burkina Faso", currency: "XOF", symbol: "CFA" },
            { name: "Burundi", currency: "BIF", symbol: "FBu" },
            { name: "Cambodia", currency: "KHR", symbol: "៛" },
            { name: "Cameroon", currency: "XAF", symbol: "FCFA" },
            { name: "Canada", currency: "CAD", symbol: "$" },
            { name: "Cape Verde", currency: "CVE", symbol: "Esc" },
            { name: "Central African Republic", currency: "XAF", symbol: "FCFA" },
            { name: "Chad", currency: "XAF", symbol: "FCFA" },
            { name: "Chile", currency: "CLP", symbol: "$" },
            { name: "China", currency: "CNY", symbol: "¥" },
            { name: "Colombia", currency: "COP", symbol: "$" },
            { name: "Comoros", currency: "KMF", symbol: "CF" },
            { name: "Congo (Brazzaville)", currency: "XAF", symbol: "FCFA" },
            { name: "Congo (Kinshasa)", currency: "CDF", symbol: "FC" },
            { name: "Costa Rica", currency: "CRC", symbol: "₡" },
            { name: "Croatia", currency: "EUR", symbol: "€" },
            { name: "Cuba", currency: "CUP", symbol: "$" },
            { name: "Cyprus", currency: "EUR", symbol: "€" },
            { name: "Czech Republic", currency: "CZK", symbol: "Kč" },
            { name: "Denmark", currency: "DKK", symbol: "kr." },
            { name: "Djibouti", currency: "DJF", symbol: "Fdj" },
            { name: "Dominica", currency: "XCD", symbol: "$" },
            { name: "Dominican Republic", currency: "DOP", symbol: "RD$" },
            { name: "Ecuador", currency: "USD", symbol: "$" },
            { name: "Egypt", currency: "EGP", symbol: "E£" },
            { name: "El Salvador", currency: "USD", symbol: "$" },
            { name: "Equatorial Guinea", currency: "XAF", symbol: "FCFA" },
            { name: "Eritrea", currency: "ERN", symbol: "Nfk" },
            { name: "Estonia", currency: "EUR", symbol: "€" },
            { name: "Eswatini", currency: "SZL", symbol: "L" },
            { name: "Ethiopia", currency: "ETB", symbol: "Br" },
            { name: "Fiji", currency: "FJD", symbol: "$" },
            { name: "Finland", currency: "EUR", symbol: "€" },
            { name: "France", currency: "EUR", symbol: "€" },
            { name: "Gabon", currency: "XAF", symbol: "FCFA" },
            { name: "Gambia", currency: "GMD", symbol: "D" },
            { name: "Georgia", currency: "GEL", symbol: "₾" },
            { name: "Germany", currency: "EUR", symbol: "€" },
            { name: "Ghana", currency: "GHS", symbol: "₵" },
            { name: "Greece", currency: "EUR", symbol: "€" },
            { name: "Grenada", currency: "XCD", symbol: "$" },
            { name: "Guatemala", currency: "GTQ", symbol: "Q" },
            { name: "Guinea", currency: "GNF", symbol: "FG" },
            { name: "Guinea-Bissau", currency: "XOF", symbol: "CFA" },
            { name: "Guyana", currency: "GYD", symbol: "$" },
            { name: "Haiti", currency: "HTG", symbol: "G" },
            { name: "Honduras", currency: "HNL", symbol: "L" },
            { name: "Hungary", currency: "HUF", symbol: "Ft" },
            { name: "Iceland", currency: "ISK", symbol: "kr" },
            { name: "India", currency: "INR", symbol: "₹" },
            { name: "Indonesia", currency: "IDR", symbol: "Rp" },
            { name: "Iran", currency: "IRR", symbol: "﷼" },
            { name: "Iraq", currency: "IQD", symbol: "ع.د" },
            { name: "Ireland", currency: "EUR", symbol: "€" },
            { name: "Israel", currency: "ILS", symbol: "₪" },
            { name: "Italy", currency: "EUR", symbol: "€" },
            { name: "Ivory Coast", currency: "XOF", symbol: "CFA" },
            { name: "Jamaica", currency: "JMD", symbol: "$" },
            { name: "Japan", currency: "JPY", symbol: "¥" },
            { name: "Jordan", currency: "JOD", symbol: "د.ا" },
            { name: "Kazakhstan", currency: "KZT", symbol: "₸" },
            { name: "Kenya", currency: "KES", symbol: "KSh" },
            { name: "Kiribati", currency: "AUD", symbol: "$" },
            { name: "Kuwait", currency: "KWD", symbol: "د.ك" },
            { name: "Kyrgyzstan", currency: "KGS", symbol: "сом" },
            { name: "Laos", currency: "LAK", symbol: "₭" },
            { name: "Latvia", currency: "EUR", symbol: "€" },
            { name: "Lebanon", currency: "LBP", symbol: "ل.ل" },
            { name: "Lesotho", currency: "LSL", symbol: "L" },
            { name: "Liberia", currency: "LRD", symbol: "$" },
            { name: "Libya", currency: "LYD", symbol: "ل.د" },
            { name: "Liechtenstein", currency: "CHF", symbol: "CHF" },
            { name: "Lithuania", currency: "EUR", symbol: "€" },
            { name: "Luxembourg", currency: "EUR", symbol: "€" },
            { name: "Madagascar", currency: "MGA", symbol: "Ar" },
            { name: "Malawi", currency: "MWK", symbol: "MK" },
            { name: "Malaysia", currency: "MYR", symbol: "RM" },
            { name: "Maldives", currency: "MVR", symbol: "Rf" },
            { name: "Mali", currency: "XOF", symbol: "CFA" },
            { name: "Malta", currency: "EUR", symbol: "€" },
            { name: "Mauritania", currency: "MRU", symbol: "UM" },
            { name: "Mauritius", currency: "MUR", symbol: "₨" },
            { name: "Mexico", currency: "MXN", symbol: "$" },
            { name: "Moldova", currency: "MDL", symbol: "L" },
            { name: "Monaco", currency: "EUR", symbol: "€" },
            { name: "Mongolia", currency: "MNT", symbol: "₮" },
            { name: "Montenegro", currency: "EUR", symbol: "€" },
            { name: "Morocco", currency: "MAD", symbol: "د.م." },
            { name: "Mozambique", currency: "MZN", symbol: "MT" },
            { name: "Myanmar", currency: "MMK", symbol: "Ks" },
            { name: "Namibia", currency: "NAD", symbol: "$" },
            { name: "Nepal", currency: "NPR", symbol: "₨" },
            { name: "Netherlands", currency: "EUR", symbol: "€" },
            { name: "New Zealand", currency: "NZD", symbol: "$" },
            { name: "Nicaragua", currency: "NIO", symbol: "C$" },
            { name: "Niger", currency: "XOF", symbol: "CFA" },
            { name: "Nigeria", currency: "NGN", symbol: "₦" },
            { name: "North Korea", currency: "KPW", symbol: "₩" },
            { name: "North Macedonia", currency: "MKD", symbol: "ден" },
            { name: "Norway", currency: "NOK", symbol: "kr" },
            { name: "Oman", currency: "OMR", symbol: "ر.ع." },
            { name: "Pakistan", currency: "PKR", symbol: "₨" },
            { name: "Palestine", currency: "ILS", symbol: "₪" },
            { name: "Panama", currency: "PAB", symbol: "B/." },
            { name: "Papua New Guinea", currency: "PGK", symbol: "K" },
            { name: "Paraguay", currency: "PYG", symbol: "₲" },
            { name: "Peru", currency: "PEN", symbol: "S/." },
            { name: "Philippines", currency: "PHP", symbol: "₱" },
            { name: "Poland", currency: "PLN", symbol: "zł" },
            { name: "Portugal", currency: "EUR", symbol: "€" },
            { name: "Qatar", currency: "QAR", symbol: "ر.ق" },
            { name: "Romania", currency: "RON", symbol: "lei" },
            { name: "Russia", currency: "RUB", symbol: "₽" },
            { name: "Rwanda", currency: "RWF", symbol: "FRw" },
            { name: "Samoa", currency: "WST", symbol: "T" },
            { name: "San Marino", currency: "EUR", symbol: "€" },
            { name: "Saudi Arabia", currency: "SAR", symbol: "ر.স" },
            { name: "Senegal", currency: "XOF", symbol: "CFA" },
            { name: "Serbia", currency: "RSD", symbol: "дин." },
            { name: "Seychelles", currency: "SCR", symbol: "₨" },
            { name: "Sierra Leone", currency: "SLE", symbol: "Le" },
            { name: "Singapore", currency: "SGD", symbol: "$" },
            { name: "Slovakia", currency: "EUR", symbol: "€" },
            { name: "Slovenia", currency: "EUR", symbol: "€" },
            { name: "Somalia", currency: "SOS", symbol: "Sh" },
            { name: "South Africa", currency: "ZAR", symbol: "R" },
            { name: "South Korea", currency: "KRW", symbol: "₩" },
            { name: "South Sudan", currency: "SSP", symbol: "SS£" },
            { name: "Spain", currency: "EUR", symbol: "€" },
            { name: "Sri Lanka", currency: "LKR", symbol: "Rs" },
            { name: "Sudan", currency: "SDG", symbol: "ج.স." },
            { name: "Suriname", currency: "SRD", symbol: "$" },
            { name: "Sweden", currency: "SEK", symbol: "kr" },
            { name: "Switzerland", currency: "CHF", symbol: "CHF" },
            { name: "Syria", currency: "SYP", symbol: "£S" },
            { name: "Taiwan", currency: "TWD", symbol: "NT$" },
            { name: "Tajikistan", currency: "TJS", symbol: "ЅМ" },
            { name: "Tanzania", currency: "TZS", symbol: "TSh" },
            { name: "Thailand", currency: "THB", symbol: "฿" },
            { name: "Togo", currency: "XOF", symbol: "CFA" },
            { name: "Tonga", currency: "TOP", symbol: "T$" },
            { name: "Trinidad and Tobago", currency: "TTD", symbol: "$" },
            { name: "Tunisia", currency: "TND", symbol: "د.ত" },
            { name: "Turkey", currency: "TRY", symbol: "₺" },
            { name: "Turkmenistan", currency: "TMT", symbol: "m" },
            { name: "Uganda", currency: "UGX", symbol: "USh" },
            { name: "Ukraine", currency: "UAH", symbol: "₴" },
            { name: "United Arab Emirates", currency: "AED", symbol: "د.إ" },
            { name: "United Kingdom", currency: "GBP", symbol: "£" },
            { name: "United States", currency: "USD", symbol: "$" },
            { name: "Uruguay", currency: "UYU", symbol: "$U" },
            { name: "Uzbekistan", currency: "UZS", symbol: "so'm" },
            { name: "Vatican City", currency: "EUR", symbol: "€" },
            { name: "Venezuela", currency: "VES", symbol: "Bs.S" },
            { name: "Vietnam", currency: "VND", symbol: "₫" },
            { name: "Yemen", currency: "YER", symbol: "﷼" },
            { name: "Zambia", currency: "ZMW", symbol: "ZK" },
            { name: "Zimbabwe", currency: "ZWG", symbol: "ZiG" }
        ];

        const countrySelect = document.getElementById('signup-country');
        const currencySelect = document.getElementById('signup-currency');

        if (countrySelect && currencySelect) {
            countryData.sort((a, b) => a.name.localeCompare(b.name));

            countryData.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.name;
                opt.textContent = c.name;
                countrySelect.appendChild(opt);
            });

            const uniqueCurrencies = [];
            const curKeys = new Set();
            countryData.forEach(c => {
                if (!curKeys.has(c.currency)) {
                    curKeys.add(c.currency);
                    uniqueCurrencies.push({ code: c.currency, symbol: c.symbol });
                }
            });
            uniqueCurrencies.sort((a, b) => a.code.localeCompare(b.code));

            uniqueCurrencies.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.code;
                opt.textContent = `${c.code} (${c.symbol})`;
                currencySelect.appendChild(opt);
            });

            window.syncSignupCurrency = function() {
                const selectedCountryName = countrySelect.value;
                const match = countryData.find(c => c.name === selectedCountryName);
                if (match) {
                    currencySelect.value = match.currency;
                }
            };
        }
    })();
</script>
</body>
</html>
