<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>1xBet - Crash Game Clone</title>
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
<body class="game-body-bg {{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
    <div class="game-wrapper">
        <!-- Top Navigation / Header -->
        <header class="game-header">
            <div class="header-left">
                <span class="logo-text">1XGAMES</span>
                <span class="separator">/</span>
                <span class="sub-logo-text">LOTTERIES</span>
                <span class="separator">/</span>
                <span class="active-page">CRASH</span>
            </div>
            
            <div class="header-right">
                <div class="user-info-header" style="margin-right: 16px; display: flex; flex-direction: column; align-items: flex-end; justify-content: center; height: 36px; line-height: 1.2;">
                    <span class="user-header-name" id="user-header-name" style="font-weight: 700; color: #fff; font-size: 12px;">{{ auth()->user()->name }}</span>
                    <div style="display: flex; gap: 8px; margin-top: 2px;">
                        <a href="{{ route('dashboard') }}" style="font-size: 10px; color: var(--color-gold); text-decoration: none; font-weight: 700; letter-spacing: 0.5px; transition: color 0.2s;">DASHBOARD</a>
                        <span style="color: var(--text-muted); font-size: 10px;">|</span>
                        <a href="{{ route('gems-mines') }}" style="font-size: 10px; color: #ffbe1a; text-decoration: none; font-weight: 700; letter-spacing: 0.5px; transition: color 0.2s;"><i class="fas fa-gem" style="font-size:9px;"></i> GEMS & MINES</a>
                        <span style="color: var(--text-muted); font-size: 10px;">|</span>
                        <a href="{{ route('big-bass-splash') }}" style="font-size: 10px; color: #38ef7d; text-decoration: none; font-weight: 700; letter-spacing: 0.5px; transition: color 0.2s;"><i class="fas fa-fish" style="font-size:9px;"></i> BIG BASS SPLASH</a>
                        <span style="color: var(--text-muted); font-size: 10px;">|</span>
                        <a href="#" id="game-theme-toggle" onclick="toggleGameTheme(event)" style="font-size: 10px; color: var(--accent-blue); text-decoration: none; font-weight: 700; letter-spacing: 0.5px; transition: color 0.2s; cursor:pointer;">THEME</a>
                        <span style="color: var(--text-muted); font-size: 10px;">|</span>
                        <a href="#" id="header-logout-btn" style="font-size: 10px; color: var(--color-red); text-decoration: none; font-weight: 700; letter-spacing: 0.5px; transition: color 0.2s;">LOGOUT</a>
                    </div>
                </div>
                <div class="balance-container">
                    <span class="balance-label">BALANCE:</span>
                    <span class="balance-value" id="user-balance">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                    <span class="balance-currency" id="user-currency">{{ auth()->user()->currency }}</span>
                </div>
                <button class="deposit-btn"><i class="fas fa-plus-circle"></i> DEPOSIT</button>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="main-layout-container">
            <div class="main-layout">
                <!-- Left Side: Live Bets Panel -->
                <aside class="live-bets-panel">
                    <div class="stats-summary-box">
                        <div class="stat-item">
                            <span class="stat-title">Number of bets</span>
                            <span class="stat-value"><i class="fas fa-users icon-small"></i> <span id="live-bets-count">0</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-title">Total bets</span>
                            <span class="stat-value"><i class="fas fa-wallet icon-small"></i> <span id="live-total-bet-amount">0.00 {{ auth()->user()->currency }}</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-title">Total winnings</span>
                            <span class="stat-value"><i class="fas fa-trophy icon-small"></i> <span id="live-total-winnings-amount">0.00 {{ auth()->user()->currency }}</span></span>
                        </div>
                    </div>

                    <div class="table-header-row">
                        <span>USERNAME</span>
                        <span>ODDS</span>
                        <span>BET</span>
                        <span>WIN</span>
                    </div>
                    
                    <div class="bets-list" id="bets-list-container">
                        <!-- Live bet rows will be dynamically populated here -->
                    </div>
                </aside>

                <!-- Center and Right Area -->
                <div class="center-right-container">
                    <!-- Center Dashboard Area -->
                    <main class="dashboard-area">
                        <!-- History Badges Bar -->
                        <div class="history-badges-wrapper">
                            <div class="history-badges-container" id="history-badges-container">
                                <!-- Recent odds will be populated here -->
                            </div>
                            <button class="history-arrow-btn" id="history-details-btn">
                                <i class="fas fa-history"></i>
                            </button>
                        </div>

                        <!-- Main Canvas Flight Screen -->
                        <div class="game-screen-container">
                            <button class="tc-badge">T&C</button>
                            
                            <!-- Canvas for graph, helicopter, and background stars/mountains -->
                            <canvas id="game-canvas"></canvas>

                            <!-- Absolute Overlay: Waiting/Countdown State -->
                            <div class="screen-overlay" id="countdown-overlay">
                                <div class="radial-countdown-container">
                                    <svg class="countdown-svg" viewBox="0 0 100 100">
                                        <circle class="countdown-bg-circle" cx="50" cy="50" r="45"></circle>
                                        <circle class="countdown-progress-circle" id="countdown-progress-circle" cx="50" cy="50" r="45"></circle>
                                    </svg>
                                    <div class="countdown-number" id="countdown-text">5</div>
                                </div>
                                {{-- Admin wait message (hidden by default) --}}
                                <div id="admin-wait-msg" style="display:none; position:absolute; bottom:18%; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.75); color:#f0c040; font-size:13px; font-weight:600; padding:8px 20px; border-radius:20px; border:1px solid rgba(240,192,64,0.4); white-space:nowrap; letter-spacing:0.5px;">
                                    ⏳ Waiting for server...
                                </div>
                            </div>


                            <!-- Absolute Overlay: Crashed State -->
                            <div class="screen-overlay hidden" id="crash-overlay">
                                <div class="crash-alert-box">
                                    <div class="crash-title">CRASHED</div>
                                    <div class="crash-multiplier" id="crash-multiplier-display">1.00x</div>
                                </div>
                            </div>

                            <!-- Real-time Multiplier Text Display -->
                            <div class="multiplier-display-floating hidden" id="live-multiplier-display">
                                1.00x
                            </div>
                        </div>

                        <!-- Bottom Log Panel (History / Bets) -->
                        <section class="personal-history-section">
                            <div class="history-section-header">
                                <div class="header-tab active"><i class="fas fa-history"></i> HISTORY</div>
                            </div>
                            <div class="history-table-container">
                                <table class="history-table" id="personal-history-table">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>ROUND ID</th>
                                            <th>BET AMOUNT</th>
                                            <th>CASH OUT ODDS</th>
                                            <th>WINNINGS</th>
                                            <th>CRASH</th>
                                        </tr>
                                    </thead>
                                    <tbody id="personal-history-tbody">
                                        <!-- Table rows populated dynamically -->
                                    </tbody>
                                </table>
                                <div class="empty-history-placeholder" id="empty-history-placeholder">
                                    <i class="fas fa-file-invoice-dollar placeholder-icon"></i>
                                    <p>You haven't placed any bets yet</p>
                                </div>
                            </div>
                        </section>
                    </main>

                    <!-- Right Side: Double Betting Control Column -->
                    <aside class="betting-controls-column">
                        <!-- Betting Control Board 1 -->
                        <div class="betting-board" id="bet-panel-1">
                            <div class="board-content">
                                <!-- Bet Mode Form -->
                                <div class="bet-input-row">
                                    <div class="input-wrapper">
                                        <input type="number" class="bet-amount-input" id="bet-amount-1" value="20" min="10" step="5">
                                        <span class="currency-label">{{ auth()->user()->currency }}</span>
                                        <button class="clear-input-btn" id="clear-bet-1"><i class="fas fa-times"></i></button>
                                    </div>
                                    <button class="enable-autoplay-btn" id="autoplay-btn-1">ENABLE AUTOPLAY</button>
                                </div>

                                <!-- Quick Bets Grid -->
                                <div class="quick-bets-grid">
                                    <button class="quick-btn" data-value="20">20</button>
                                    <button class="quick-btn" data-value="100">100</button>
                                    <button class="quick-btn" data-value="300">300</button>
                                    <button class="quick-btn" data-value="800">800</button>
                                    <button class="quick-btn" data-value="3000">3000</button>
                                    <button class="quick-btn" data-value="10000">10000</button>
                                </div>

                                <!-- Large CTA Button -->
                                <button class="place-bet-btn btn-orange" id="bet-btn-1">
                                    <span class="btn-primary-text">PLACE A BET</span>
                                    <span class="btn-secondary-text">(on the next round)</span>
                                </button>
                            </div>
                        </div>

                        <!-- Betting Control Board 2 -->
                        <div class="betting-board" id="bet-panel-2">
                            <div class="board-content">
                                <!-- Bet Mode Form -->
                                <div class="bet-input-row">
                                    <div class="input-wrapper">
                                        <input type="number" class="bet-amount-input" id="bet-amount-2" value="20" min="10" step="5">
                                        <span class="currency-label">{{ auth()->user()->currency }}</span>
                                        <button class="clear-input-btn" id="clear-bet-2"><i class="fas fa-times"></i></button>
                                    </div>
                                    <button class="enable-autoplay-btn" id="autoplay-btn-2">ENABLE AUTOPLAY</button>
                                </div>

                                <!-- Quick Bets Grid -->
                                <div class="quick-bets-grid">
                                    <button class="quick-btn" data-value="20">20</button>
                                    <button class="quick-btn" data-value="100">100</button>
                                    <button class="quick-btn" data-value="300">300</button>
                                    <button class="quick-btn" data-value="800">800</button>
                                    <button class="quick-btn" data-value="3000">3000</button>
                                    <button class="quick-btn" data-value="10000">10000</button>
                                </div>

                                <!-- Large CTA Button -->
                                <button class="place-bet-btn btn-orange" id="bet-btn-2">
                                    <span class="btn-primary-text">PLACE A BET</span>
                                    <span class="btn-secondary-text">(on the next round)</span>
                                </button>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!-- Far Right Toolbar Sidebar -->
            <aside class="right-toolbar-sidebar">
                <button class="toolbar-icon-btn" title="Settings"><i class="fas fa-cog"></i></button>
                <button class="toolbar-icon-btn" title="Gifts"><i class="fas fa-gift"></i></button>
                <button class="toolbar-icon-btn active" title="Round History">7</button>
                <button class="toolbar-icon-btn" id="sound-toggle" title="Toggle Sound"><i class="fas fa-volume-up"></i></button>
                <button class="toolbar-icon-btn" title="Deposit / Wallet"><i class="fas fa-dollar-sign"></i></button>
            </aside>
        </div>
    </div>

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

    <!-- Script imports -->
    <script>
        localStorage.setItem('crash_is_logged_in', 'true');
        localStorage.setItem('crash_username', "{{ auth()->user()->name }}");
        localStorage.setItem('crash_clone_balance', "{{ auth()->user()->balance }}");
        window.activeHelicopterDesign = {{ \App\Models\Setting::getVal('active_helicopter_design', '1') }};
        window.gameBgMusicUrl = "{{ \App\Models\Setting::getVal('game_bg_music', '') }}";
        window.gameCountdownSoundUrl = "{{ \App\Models\Setting::getVal('game_countdown_sound', '') }}";
        window.gameCountdownTime = {{ \App\Models\Setting::getVal('game_countdown_time', '10') }};

        // Realtime background sync of helicopter design, timer, background music and ticking beeps
        setInterval(() => {
            fetch('/game/active-settings', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (data.active_helicopter_design) {
                        const newDesign = parseInt(data.active_helicopter_design);
                        if (window.activeHelicopterDesign !== newDesign) {
                            console.log(`[REALTIME] Helicopter design updated: ${window.activeHelicopterDesign} -> ${newDesign}`);
                            window.activeHelicopterDesign = newDesign;
                        }
                    }
                    if (data.game_countdown_time) {
                        const newCountdown = parseInt(data.game_countdown_time);
                        if (window.gameCountdownTime !== newCountdown) {
                            console.log(`[REALTIME] Countdown duration updated: ${window.gameCountdownTime} -> ${newCountdown}`);
                            window.gameCountdownTime = newCountdown;
                            if (typeof GameConfig !== 'undefined') {
                                GameConfig.countdownDuration = newCountdown;
                            }
                        }
                    }
                    if (typeof data.game_bg_music !== 'undefined') {
                        const newBgMusic = data.game_bg_music;
                        if (window.gameBgMusicUrl !== newBgMusic) {
                            console.log(`[REALTIME] BG music updated: ${window.gameBgMusicUrl} -> ${newBgMusic}`);
                            if (typeof soundEngine !== 'undefined') {
                                if (soundEngine.bgAudio) {
                                    soundEngine.bgAudio.pause();
                                    soundEngine.bgAudio = null;
                                }
                                window.gameBgMusicUrl = newBgMusic;
                                if (typeof gameState !== 'undefined' && gameState === 'FLIGHT' && !soundEngine.isMuted) {
                                    soundEngine.playPropeller();
                                }
                            } else {
                                window.gameBgMusicUrl = newBgMusic;
                            }
                        }
                    }
                    if (typeof data.game_countdown_sound !== 'undefined') {
                        window.gameCountdownSoundUrl = data.game_countdown_sound;
                    }
                }
            })
            .catch(err => console.error('[REALTIME] Settings sync error:', err));
        }, 2000);

        // ===================================================
        // FORCE CRASH POLLING — checks every 1 second
        // If admin triggered force crash, crash the game now
        // ===================================================
        setInterval(() => {
            fetch('/game/check-force-crash', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.force_crash === true) {
                    console.warn('[ADMIN] Force crash triggered by admin!');
                    // Trigger the game crash immediately via the global crash function
                    if (typeof window.adminForceCrashGame === 'function') {
                        window.adminForceCrashGame();
                    } else if (typeof window.triggerCrash === 'function') {
                        window.triggerCrash();
                    } else {
                        // Fallback: dispatch a custom event the game JS can listen to
                        window.dispatchEvent(new CustomEvent('admin-force-crash'));
                    }
                }
            })
            .catch(() => {}); // silent fail - don't spam console
        }, 1000);

        function toggleGameTheme(e) {
            if (e) e.preventDefault();
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
    </script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
    // 1. Hook the logout action
    const logoutBtn = document.getElementById('header-logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }

    // 2. Dynamic Currency string update for script calculations if needed
    window.UserCurrency = "{{ auth()->user()->currency }}";

    // 3. Floating Live Support Chat Controller
    (function() {
        const triggerBtn = document.getElementById('chat-trigger-btn');
        const closeBtn = document.getElementById('chat-box-close');
        const boxContainer = document.getElementById('chat-box-container');
        const chatForm = document.getElementById('chat-send-form');
        const inputField = document.getElementById('chat-input-field');
        const chatBody = document.getElementById('chat-box-body');

        const isAuth = true; // Always authenticated in game page
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
                    let reply = `Thank you for reaching out. A support agent will be with you shortly. If you have questions about deposits, they are processed instantly via BDT.`;
                    if (text.includes('deposit')) {
                        reply = `To deposit funds, click 'DEPOSIT' on your game dashboard page. Transfer BDT instantly using bKash, Nagad, or Rocket. The money will credit your account instantly with zero fees!`;
                    } else if (text.includes('fair')) {
                        reply = `Our game is 100% Provably Fair. Multipliers are predetermined before takeoff using SHA-256 hash algorithms, so results cannot be manipulated by anyone.`;
                    } else if (text.includes('escrow')) {
                        reply = `The escrow system locks user stakes safely at the beginning of each round. When you click CASH OUT, funds are automatically distributed directly from escrow to your balance.`;
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
    </script>
</body>
</html>
