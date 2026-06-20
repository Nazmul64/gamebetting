/**
 * 1xBet Crash Clone - JavaScript Core Game Engine
 * Features:
 * - Canvas flight rendering (grid scroll, backdrop parallax scrolling, vintage yellow plane, trail, explosion particles)
 * - Trajectory filling: Translucent orange gradient shape under the flight curve.
 * - Synthesized Audio Engine (Propeller engine, boom explosion, interface beeps) using Web Audio API
 * - Real-time simulated betting dashboard with active users cashing out (green) or losing (red)
 * - Custom player wallet state with double betting boards (manual cashout, auto cashout, autoplay)
 */

// Sound Engine using Web Audio API
class SoundEngine {
    constructor() {
        this.ctx = null;
        this.propellerNode = null;
        this.propellerGain = null;
        this.isMuted = false;
        this.bgAudio = null;
    }

    init() {
        if (this.ctx) return;
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (AudioContextClass) {
            this.ctx = new AudioContextClass();
        }
    }

    setMuted(muted) {
        this.isMuted = muted;
        if (muted) {
            this.stopPropeller();
            if (this.bgAudio) {
                try { this.bgAudio.pause(); } catch(e) {}
            }
        } else {
            // Resume sound if currently flying
            if (typeof state !== 'undefined' && state === 'FLIGHT') {
                this.playPropeller();
            }
        }
    }

    playPropeller() {
        this.stopPropeller(); // Make sure previous propeller or audio is stopped first
        
        // Handle custom background music if set
        if (window.gameBgMusicUrl) {
            if (!this.bgAudio) {
                this.bgAudio = new Audio(window.gameBgMusicUrl);
                this.bgAudio.loop = true;
            }
            if (this.isMuted) return;
            this.bgAudio.currentTime = 0;
            this.bgAudio.play().catch(e => console.log("BG music play failed:", e));
            return;
        }

        if (this.isMuted) return;
        this.init();
        if (!this.ctx) return;

        if (this.ctx.state === 'suspended') {
            this.ctx.resume();
        }

        // Propeller volume control
        this.propellerGain = this.ctx.createGain();
        this.propellerGain.gain.setValueAtTime(0.0, this.ctx.currentTime);
        this.propellerGain.gain.linearRampToValueAtTime(0.12, this.ctx.currentTime + 0.3);

        // Filter to remove harsh frequencies
        const filter = this.ctx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(220, this.ctx.currentTime);

        // Low frequency carrier for deep engine sound
        const carrier = this.ctx.createOscillator();
        carrier.type = 'sawtooth';
        carrier.frequency.setValueAtTime(55, this.ctx.currentTime);

        // Pitch LFO for vibration
        const pitchLfo = this.ctx.createOscillator();
        pitchLfo.type = 'sine';
        pitchLfo.frequency.setValueAtTime(10, this.ctx.currentTime);

        const pitchLfoGain = this.ctx.createGain();
        pitchLfoGain.gain.setValueAtTime(12, this.ctx.currentTime);

        pitchLfo.connect(pitchLfoGain);
        pitchLfoGain.connect(carrier.frequency);

        // Volume amplitude modulator (propeller chop effect)
        const ampLfo = this.ctx.createOscillator();
        ampLfo.type = 'triangle';
        ampLfo.frequency.setValueAtTime(10, this.ctx.currentTime);

        const ampLfoGain = this.ctx.createGain();
        ampLfoGain.gain.setValueAtTime(0.4, this.ctx.currentTime);

        const ampGain = this.ctx.createGain();
        ampGain.gain.setValueAtTime(0.6, this.ctx.currentTime);

        ampLfo.connect(ampLfoGain);
        ampLfoGain.connect(ampGain.gain);

        // Connection path
        carrier.connect(ampGain);
        ampGain.connect(filter);
        filter.connect(this.propellerGain);
        this.propellerGain.connect(this.ctx.destination);

        carrier.start();
        pitchLfo.start();
        ampLfo.start();

        this.propellerNode = {
            carrier,
            pitchLfo,
            ampLfo,
            filter,
            stop: () => {
                try {
                    carrier.stop();
                    pitchLfo.stop();
                    ampLfo.stop();
                } catch (e) {}
            }
        };
    }

    updatePropellerPitch(multiplier) {
        if (window.gameBgMusicUrl) return; // Custom music doesn't bend pitch
        if (this.isMuted || !this.propellerNode || !this.ctx) return;
        const targetPitch = Math.min(160, 55 + (multiplier - 1) * 30);
        const targetLfo = Math.min(24, 10 + (multiplier - 1) * 2);
        const time = this.ctx.currentTime;

        this.propellerNode.carrier.frequency.setTargetAtTime(targetPitch, time, 0.15);
        this.propellerNode.pitchLfo.frequency.setTargetAtTime(targetLfo, time, 0.15);
        this.propellerNode.ampLfo.frequency.setTargetAtTime(targetLfo, time, 0.15);
    }

    stopPropeller() {
        if (this.bgAudio) {
            try { this.bgAudio.pause(); } catch(e) {}
        }
        if (this.propellerNode) {
            try {
                const node = this.propellerNode;
                const time = this.ctx ? this.ctx.currentTime : 0;
                if (this.ctx && this.propellerGain) {
                    this.propellerGain.gain.setValueAtTime(this.propellerGain.gain.value, time);
                    this.propellerGain.gain.linearRampToValueAtTime(0.0, time + 0.1);
                    setTimeout(() => {
                        node.stop();
                    }, 120);
                } else {
                    node.stop();
                }
            } catch (e) {}
            this.propellerNode = null;
        }
    }

    playCountdownTick(second) {
        // Play custom countdown tick if set
        if (window.gameCountdownSoundUrl) {
            try {
                const tickSound = new Audio(window.gameCountdownSoundUrl);
                tickSound.play().catch(e => console.log("Tick audio play failed:", e));
            } catch (e) {}
            return;
        }

        // Countdown sound always plays and ignores this.isMuted as per user request
        this.init();
        if (!this.ctx) return;

        if (this.ctx.state === 'suspended') {
            this.ctx.resume();
        }

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'sine';
        const frequency = 500 + (5 - second) * 80;
        osc.frequency.setValueAtTime(frequency, now);

        gain.gain.setValueAtTime(0.15, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.12);

        osc.connect(gain);
        gain.connect(this.ctx.destination);

        osc.start(now);
        osc.stop(now + 0.12);
    }

    playExplosion() {
        if (this.bgAudio) {
            try { this.bgAudio.pause(); } catch(e) {}
        }
        if (this.isMuted) return;
        this.init();
        if (!this.ctx) return;

        this.stopPropeller();

        if (this.ctx.state === 'suspended') {
            this.ctx.resume();
        }

        const now = this.ctx.currentTime;
        const duration = 1.8;

        const bufferSize = this.ctx.sampleRate * duration;
        const buffer = this.ctx.createBuffer(1, bufferSize, this.ctx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
            data[i] = Math.random() * 2 - 1;
        }

        const noise = this.ctx.createBufferSource();
        noise.buffer = buffer;

        const filter = this.ctx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(1000, now);
        filter.frequency.exponentialRampToValueAtTime(25, now + 1.2);

        const gain = this.ctx.createGain();
        gain.gain.setValueAtTime(0.4, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + duration);

        const subOsc = this.ctx.createOscillator();
        subOsc.type = 'sine';
        subOsc.frequency.setValueAtTime(80, now);
        subOsc.frequency.exponentialRampToValueAtTime(15, now + 0.9);

        const subGain = this.ctx.createGain();
        subGain.gain.setValueAtTime(0.5, now);
        subGain.gain.exponentialRampToValueAtTime(0.001, now + 0.9);

        noise.connect(filter);
        filter.connect(gain);
        gain.connect(this.ctx.destination);

        subOsc.connect(subGain);
        subGain.connect(this.ctx.destination);

        noise.start(now);
        subOsc.start(now);
        noise.stop(now + duration);
        subOsc.stop(now + 0.9);
    }

    playClick() {
        if (this.isMuted) return;
        this.init();
        if (!this.ctx) return;

        if (this.ctx.state === 'suspended') {
            this.ctx.resume();
        }

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'triangle';
        osc.frequency.setValueAtTime(520, now);
        osc.frequency.exponentialRampToValueAtTime(880, now + 0.08);

        gain.gain.setValueAtTime(0.06, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);

        osc.connect(gain);
        gain.connect(this.ctx.destination);

        osc.start(now);
        osc.stop(now + 0.08);
    }
}

// Particle System for Helicopter Explosion
class Particle {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        const angle = Math.random() * Math.PI * 2;
        const speed = Math.random() * 8 + 2;
        this.vx = Math.cos(angle) * speed;
        this.vy = Math.sin(angle) * speed - 1.5;
        this.size = Math.random() * 12 + 4;
        this.life = 1.0;
        this.decay = Math.random() * 0.03 + 0.015;
        
        this.type = Math.random() < 0.6 ? (Math.random() < 0.5 ? 0 : 2) : 1;
    }

    update() {
        this.x += this.vx;
        this.y += this.vy;
        
        this.vx *= 0.96;
        this.vy *= 0.96;
        
        this.life -= this.decay;
        if (this.size > 0.2) {
            this.size *= 0.98;
        }
    }

    draw(ctx) {
        if (this.life <= 0) return;
        ctx.save();
        ctx.globalAlpha = this.life;
        
        if (this.type === 0) {
            ctx.shadowBlur = 12;
            ctx.shadowColor = 'rgba(241, 99, 34, 0.8)';
            const grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
            grad.addColorStop(0, '#ffffff');
            grad.addColorStop(0.3, '#ffbe1a');
            grad.addColorStop(0.7, '#f16322');
            grad.addColorStop(1, 'rgba(235, 64, 52, 0)');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        } else if (this.type === 1) {
            ctx.fillStyle = `rgba(100, 100, 100, ${this.life * 0.4})`;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size * 1.5, 0, Math.PI * 2);
            ctx.fill();
        } else {
            ctx.fillStyle = '#ffbe1a';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size * 0.3, 0, Math.PI * 2);
            ctx.fill();
        }
        
        ctx.restore();
    }
}

// Game State Engine
const soundEngine = new SoundEngine();

const GameConfig = {
    countdownDuration: (typeof window.gameCountdownTime !== 'undefined' ? window.gameCountdownTime : 10),
    growthRate: 0.06,
    minCrash: 1.01,
    maxCrash: 100.0,
    houseEdge: 0.03
};

// Global App States
let balance = parseFloat(localStorage.getItem('crash_clone_balance') || '0.00');
let gameState = 'COUNTDOWN';
let currentMultiplier = 1.00;
let crashPoint = 1.00;
let currentRoundId = '';
let countdownTimer = null;
let countdownTimeLeft = (typeof window.gameCountdownTime !== 'undefined' ? window.gameCountdownTime : 10);
let lastTickSecond = (typeof window.gameCountdownTime !== 'undefined' ? window.gameCountdownTime + 1 : 11); // Track last tick played
let animationFrameId = null;

let flightStartTime = 0;
let timeInFlight = 0;

let trailPoints = [];
let planePos = { x: 0, y: 350 };
let landscapeOffset = 0;
let gridOffset = { x: 0, y: 0 };
let explosionParticles = [];

let mockUsers = [];
let activeBetsCount = 0;
let totalBetsAmount = 0.00;
let totalWinningsAmount = 0.00;


const playerBets = {
    1: {
        active: false,
        inGame: false,
        cashedOut: false,
        amount: 20.00,
        odds: 0.00,
        win: 0.00,
        autoPlay: false,
        autoCashout: false,
        autoOdds: 2.00
    },
    2: {
        active: false,
        inGame: false,
        cashedOut: false,
        amount: 20.00,
        odds: 0.00,
        win: 0.00,
        autoPlay: false,
        autoCashout: false,
        autoOdds: 2.00
    }
};

let historyList = [];

const DOM = {
    userBalance: document.getElementById('user-balance'),
    soundToggle: document.getElementById('sound-toggle'),
    liveBetsCount: document.getElementById('live-bets-count'),
    liveTotalBetAmount: document.getElementById('live-total-bet-amount'),
    liveTotalWinningsAmount: document.getElementById('live-total-winnings-amount'),
    betsListContainer: document.getElementById('bets-list-container'),
    historyBadgesContainer: document.getElementById('history-badges-container'),
    canvas: document.getElementById('game-canvas'),
    
    countdownOverlay: document.getElementById('countdown-overlay'),
    countdownText: document.getElementById('countdown-text'),
    countdownProgressCircle: document.getElementById('countdown-progress-circle'),
    crashOverlay: document.getElementById('crash-overlay'),
    crashMultiplierDisplay: document.getElementById('crash-multiplier-display'),
    liveMultiplierDisplay: document.getElementById('live-multiplier-display'),
    
    personalHistoryTable: document.getElementById('personal-history-table'),
    personalHistoryTbody: document.getElementById('personal-history-tbody'),
    emptyHistoryPlaceholder: document.getElementById('empty-history-placeholder'),
    
    panel1: document.getElementById('bet-panel-1'),
    betAmount1: document.getElementById('bet-amount-1'),
    clearBet1: document.getElementById('clear-bet-1'),
    autoplayBtn1: document.getElementById('autoplay-btn-1'),
    betBtn1: document.getElementById('bet-btn-1'),
    
    panel2: document.getElementById('bet-panel-2'),
    betAmount2: document.getElementById('bet-amount-2'),
    clearBet2: document.getElementById('clear-bet-2'),
    autoplayBtn2: document.getElementById('autoplay-btn-2'),
    betBtn2: document.getElementById('bet-btn-2')
};

let ctx = null;
if (DOM.canvas) {
    ctx = DOM.canvas.getContext('2d');
}

// Global state for online fake users and real users flag
let onlineMockUsersList = [];
let hasRealUsers = false;

function fetchOnlineMockUsers() {
    // Initialize fallback immediately so we always have data
    initializeLocalFallbackMockUsers();
    
    // Fetch 100 random users from randomuser.me API
    fetch('https://randomuser.me/api/?results=100&inc=name,picture,login')
        .then(response => response.json())
        .then(data => {
            if (data && data.results && data.results.length > 0) {
                onlineMockUsersList = data.results.map(user => {
                    const rawName = user.login.username || (user.name.first + user.name.last);
                    // Mask username (e.g., dav***99)
                    const len = rawName.length;
                    const masked = len > 4 ? rawName.substring(0, 2) + '***' + rawName.substring(len - 2) : rawName + '***';
                    return {
                        username: masked,
                        avatar: user.picture.thumbnail
                    };
                });
                console.log('[MOCK USERS] Successfully loaded 100 fake users from online API.');
            }
        })
        .catch(err => {
            console.warn('[MOCK USERS] Failed to fetch online mock users, using local fallback:', err);
        });
}

const fallbackNames = ['david99', 'sarah_m', 'priya_s', 'rajesh', 'jack_k', 'emma_w', 'alex_p', 'miko99', 'liam_n', 'sophia_l', 'noah_g', 'olivia_d', 'arjun_v', 'sneha_r', 'amit_k', 'jessica_t', 'daniel_c', 'chloe_b', 'ryan_m', 'zoe_f'];
function initializeLocalFallbackMockUsers() {
    onlineMockUsersList = [];
    for (let i = 0; i < 100; i++) {
        const baseName = fallbackNames[i % fallbackNames.length] + Math.floor(Math.random() * 100);
        const len = baseName.length;
        const masked = len > 4 ? baseName.substring(0, 2) + '***' + baseName.substring(len - 2) : baseName + '***';
        // Fallback thumbnail avatar using dicebear online avatars
        const avatar = `https://api.dicebear.com/7.x/identicon/svg?seed=${baseName}`;
        onlineMockUsersList.push({
            username: masked,
            avatar: avatar
        });
    }
}

function syncRealBetsAndStatus(data) {
    if (!data || !data.success) return;
    
    // Check if admin triggered a force crash
    if (data.force_crash || (data.crash_point && data.crash_point < crashPoint)) {
        crashPoint = parseFloat(data.crash_point);
        console.log(`[FORCE CRASH] Syncing crash point to ${crashPoint}`);
    }
    
    // Check if there are other real players' bets
    if (data.real_bets && data.real_bets.length > 0) {
        if (!hasRealUsers) {
            // Switch from fake to real users!
            hasRealUsers = true;
            mockUsers = [];
            
            // Clear current list container
            if (DOM.betsListContainer) {
                // Keep player rows if any
                const playerRow1 = document.getElementById('player-bet-row-1');
                const playerRow2 = document.getElementById('player-bet-row-2');
                
                DOM.betsListContainer.innerHTML = '';
                
                if (playerRow1) DOM.betsListContainer.appendChild(playerRow1);
                if (playerRow2) DOM.betsListContainer.appendChild(playerRow2);
            }
            
            // Populate mockUsers array with the real users data
            data.real_bets.forEach((bet, idx) => {
                const user = {
                    id: 'real_' + idx,
                    username: bet.username,
                    avatar: bet.avatar,
                    betAmount: bet.bet_amount,
                    targetOdds: bet.cashout_odds || 9999.00, // if pending, set a high odds
                    status: bet.result, // 'pending', 'win', 'lose'
                    winAmount: bet.winnings
                };
                mockUsers.push(user);
                
                // Add to DOM
                if (DOM.betsListContainer) {
                    const row = document.createElement('div');
                    row.id = `user-row-${user.id}`;
                    if (user.status === 'win') {
                        row.className = 'bet-row win';
                    } else if (user.status === 'lose') {
                        row.className = 'bet-row lose';
                    } else {
                        row.className = 'bet-row pending';
                    }
                    
                    row.innerHTML = `
                        <div class="user-info-col" style="display: flex; align-items: center; gap: 8px; overflow: hidden; min-width: 0;">
                            <img src="${user.avatar}" alt="Avatar" style="width: 22px; height: 22px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(255,255,255,0.15); flex-shrink: 0;">
                            <span class="user-name" style="margin: 0; color: inherit; font-size: 11px;">${user.username}</span>
                        </div>
                        <span class="user-odds">${user.status === 'win' ? 'x' + user.targetOdds.toFixed(2) : '-'}</span>
                        <span class="user-bet">${user.betAmount.toFixed(2)} BDT</span>
                        <span class="user-win">${user.status === 'win' ? user.winAmount.toFixed(2) + ' BDT' : '-'}</span>
                    `;
                    DOM.betsListContainer.appendChild(row);
                }
            });
            
            // Recalculate stats
            let baseBetsCount = mockUsers.length;
            let baseBetsAmount = mockUsers.reduce((sum, u) => sum + u.betAmount, 0);
            let baseWinningsAmount = mockUsers.reduce((sum, u) => sum + u.winAmount, 0);
            
            // Add player's active bets to the totals
            [1, 2].forEach(panelId => {
                if (playerBets[panelId].inGame) {
                    baseBetsCount++;
                    baseBetsAmount += playerBets[panelId].amount;
                    if (playerBets[panelId].cashedOut) {
                        baseWinningsAmount += playerBets[panelId].win;
                    }
                }
            });
            
            activeBetsCount = baseBetsCount;
            totalBetsAmount = baseBetsAmount;
            totalWinningsAmount = baseWinningsAmount;
            updateLiveStatsHeaderUI();
        } else {
            // Already showing real users, update their cashout status!
            data.real_bets.forEach((bet, idx) => {
                const existingUser = mockUsers.find(u => u.username === bet.username);
                if (existingUser) {
                    if (existingUser.status === 'pending' && bet.result !== 'pending') {
                        existingUser.status = bet.result;
                        existingUser.targetOdds = bet.cashout_odds || 0;
                        existingUser.winAmount = bet.winnings;
                        
                        // Add to total winnings if they won
                        if (bet.result === 'win') {
                            totalWinningsAmount += bet.winnings;
                        }
                        
                        updateMockUserRowUI(existingUser);
                    }
                }
            });
            updateLiveStatsHeaderUI();
        }
    }
}


// ----------------------------------------------------
// UI Initialization
// ----------------------------------------------------
function initApp() {
    // Check authentication state first
    if (localStorage.getItem('crash_is_logged_in') !== 'true') {
        window.location.href = '/?auth=login';
        return;
    }

    // Fetch fake users from online randomuser API on load
    fetchOnlineMockUsers();

    // Set username badge
    const username = localStorage.getItem('crash_username') || 'Player';
    const userHeader = document.getElementById('user-header-name');
    if (userHeader) userHeader.textContent = username;

    // The logout button uses the hidden form in game.blade.php for CSRF-safe logout.
    // This is wired in game.blade.php's inline script. Do nothing here.

    updateBalanceUI();
    renderHistoryBadges();
    setupEventListeners();
    setupBetControls(1);
    setupBetControls(2);
    
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    startCountdownRound();
}

function updateBalanceUI() {
    if (DOM.userBalance) {
        DOM.userBalance.textContent = balance.toFixed(2);
        localStorage.setItem('crash_clone_balance', balance.toString());
        
        // Sync balance to Laravel database
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) {
            fetch('/dashboard/update-balance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ balance: balance })
            })
            .then(response => response.json())
            .then(data => {
                // Done syncing
            })
            .catch(err => console.log('Sync failed:', err));
        }
    }
}

function resizeCanvas() {
    if (!DOM.canvas) return;
    DOM.canvas.width = DOM.canvas.parentElement.clientWidth;
    DOM.canvas.height = DOM.canvas.parentElement.clientHeight;
}

function renderHistoryBadges() {
    if (!DOM.historyBadgesContainer) return;
    DOM.historyBadgesContainer.innerHTML = '';
    const recent = historyList.slice(-18).reverse();
    recent.forEach(odd => {
        const badge = document.createElement('div');
        badge.className = 'badge-odd';
        if (odd < 1.5) {
            badge.classList.add('badge-low');
        } else if (odd < 10) {
            badge.classList.add('badge-medium');
        } else {
            badge.classList.add('badge-high');
        }
        badge.textContent = odd.toFixed(2) + 'x';
        DOM.historyBadgesContainer.appendChild(badge);
    });
}

function setupEventListeners() {
    if (DOM.soundToggle) {
        DOM.soundToggle.addEventListener('click', () => {
            soundEngine.setMuted(!soundEngine.isMuted);
            const icon = DOM.soundToggle.querySelector('i');
            if (soundEngine.isMuted) {
                icon.className = 'fas fa-volume-mute';
                DOM.soundToggle.classList.remove('active');
                DOM.soundToggle.title = 'Unmute Sound';
            } else {
                icon.className = 'fas fa-volume-up';
                DOM.soundToggle.classList.add('active');
                DOM.soundToggle.title = 'Mute Sound';
                soundEngine.playClick();
            }
        });
    }

    document.querySelectorAll('button').forEach(el => {
        el.addEventListener('click', () => {
            soundEngine.playClick();
        });
    });

    // Global gesture unlock for audio context (ensures warning countdown ticking works on first interaction)
    const unlockAudio = () => {
        soundEngine.init();
        if (soundEngine.ctx && soundEngine.ctx.state === 'suspended') {
            soundEngine.ctx.resume();
        }
        document.removeEventListener('click', unlockAudio);
        document.removeEventListener('touchstart', unlockAudio);
    };
    document.addEventListener('click', unlockAudio);
    document.addEventListener('touchstart', unlockAudio);
}

function setupBetControls(panelId) {
    const p = panelId === 1 ? DOM.panel1 : DOM.panel2;
    if (!p) return;
    const betInput = panelId === 1 ? DOM.betAmount1 : DOM.betAmount2;
    const clearBtn = panelId === 1 ? DOM.clearBet1 : DOM.clearBet2;
    const autoplayBtn = panelId === 1 ? DOM.autoplayBtn1 : DOM.autoplayBtn2;
    const betBtn = panelId === 1 ? DOM.betBtn1 : DOM.betBtn2;
    
    clearBtn.addEventListener('click', () => {
        betInput.value = '';
    });
    
    p.querySelectorAll('.quick-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            betInput.value = btn.dataset.value;
        });
    });

    autoplayBtn.addEventListener('click', () => {
        const state = playerBets[panelId];
        state.autoPlay = !state.autoPlay;
        
        if (state.autoPlay) {
            autoplayBtn.classList.add('active');
            autoplayBtn.textContent = 'AUTOPLAY ENABLED';
            
            if (gameState === 'COUNTDOWN' && !state.active) {
                const amount = parseFloat(betInput.value) || 20;
                if (amount > 0 && amount <= balance) {
                    state.amount = amount;
                    state.active = true;
                    balance -= amount;
                    updateBalanceUI();
                    addPlayerBetToLivePanel(panelId, amount);
                    updateBettingButtonUI(panelId);
                }
            }
        } else {
            autoplayBtn.classList.remove('active');
            autoplayBtn.textContent = 'ENABLE AUTOPLAY';
        }
    });

    betBtn.addEventListener('click', () => {
        handleBetAction(panelId);
    });
}

function handleBetAction(panelId) {
    const betInput = panelId === 1 ? DOM.betAmount1 : DOM.betAmount2;
    const amount = parseFloat(betInput.value) || 0;
    
    if (gameState === 'COUNTDOWN') {
        if (!playerBets[panelId].active) {
            if (amount <= 0 || amount > balance) {
                alert('Invalid bet amount or insufficient balance!');
                return;
            }
            playerBets[panelId].amount = amount;
            playerBets[panelId].active = true;
            balance -= amount;
            updateBalanceUI();
            
            addPlayerBetToLivePanel(panelId, amount);
            updateBettingButtonUI(panelId);
        } else {
            playerBets[panelId].active = false;
            balance += playerBets[panelId].amount;
            updateBalanceUI();
            
            removePlayerBetFromLivePanel(panelId);
            updateBettingButtonUI(panelId);
        }
    } else if (gameState === 'FLIGHT') {
        if (playerBets[panelId].inGame && !playerBets[panelId].cashedOut) {
            triggerCashout(panelId);
        }
    }
}

function updateBettingButtonUI(panelId) {
    const betBtn = panelId === 1 ? DOM.betBtn1 : DOM.betBtn2;
    if (!betBtn) return;
    const state = playerBets[panelId];
    
    betBtn.disabled = false;
    betBtn.className = 'place-bet-btn';

    if (gameState === 'COUNTDOWN') {
        if (state.active) {
            betBtn.classList.add('btn-red');
            betBtn.querySelector('.btn-primary-text').textContent = 'CANCEL';
            betBtn.querySelector('.btn-secondary-text').textContent = `(${state.amount.toFixed(2)} BDT placed)`;
        } else {
            betBtn.classList.add('btn-orange');
            betBtn.querySelector('.btn-primary-text').textContent = 'PLACE A BET';
            betBtn.querySelector('.btn-secondary-text').textContent = '(on the next round)';
        }
    } else if (gameState === 'FLIGHT') {
        if (state.inGame) {
            if (state.cashedOut) {
                betBtn.classList.add('btn-red');
                betBtn.disabled = true;
                betBtn.querySelector('.btn-primary-text').textContent = 'CASHED OUT';
                betBtn.querySelector('.btn-secondary-text').textContent = `at ${state.odds.toFixed(2)}x`;
            } else {
                betBtn.classList.add('btn-green');
                const winEst = state.amount * currentMultiplier;
                betBtn.querySelector('.btn-primary-text').textContent = 'CASH OUT';
                betBtn.querySelector('.btn-secondary-text').textContent = `${winEst.toFixed(2)} BDT`;
            }
        } else {
            if (state.active) {
                betBtn.classList.add('btn-red');
                betBtn.disabled = true;
                betBtn.querySelector('.btn-primary-text').textContent = 'WAITING...';
                betBtn.querySelector('.btn-secondary-text').textContent = 'placed for next round';
            } else {
                betBtn.classList.add('btn-orange');
                betBtn.querySelector('.btn-primary-text').textContent = 'PLACE A BET';
                betBtn.querySelector('.btn-secondary-text').textContent = '(on the next round)';
            }
        }
    } else if (gameState === 'CRASHED') {
        betBtn.disabled = true;
        betBtn.classList.add('btn-orange');
        if (state.inGame && !state.cashedOut) {
            betBtn.querySelector('.btn-primary-text').textContent = 'CRASHED';
            betBtn.querySelector('.btn-secondary-text').textContent = 'Flew away!';
        } else {
            betBtn.querySelector('.btn-primary-text').textContent = 'ROUND END';
            betBtn.querySelector('.btn-secondary-text').textContent = 'Preparing next...';
        }
    }
}

// Phase 1: Countdown
async function startCountdownRound() {
    gameState = 'COUNTDOWN';
    currentMultiplier = 1.00;
    countdownTimeLeft = GameConfig.countdownDuration;
    lastTickSecond = GameConfig.countdownDuration + 1; // Reset last tick played
    
    resetBettingRoundStates();
    
    if (DOM.countdownOverlay) DOM.countdownOverlay.classList.remove('hidden');
    if (DOM.crashOverlay) DOM.crashOverlay.classList.add('hidden');
    if (DOM.liveMultiplierDisplay) DOM.liveMultiplierDisplay.classList.add('hidden');
    
    // Fetch the next crash point from server (admin-defined sequence ONLY).
    // If admin has not configured crash points, game will WAIT and retry.
    const gotPoint = await calculateRoundCrashPoint();

    if (!gotPoint) {
        // No crash points configured by admin — pause and retry in 3 seconds
        gameState = 'WAITING';
        console.warn('[ROUND] Waiting for admin to configure crash points. Retrying in 3s...');
        setTimeout(() => {
            startCountdownRound();
        }, 3000);
        return; // Do NOT start countdown
    }

    // Hide waiting message if it was showing
    const waitEl = document.getElementById('admin-wait-msg');
    if (waitEl) waitEl.style.display = 'none';

    generateMockUsersBets();
    
    checkAutoPlayBetsPlacement(1);
    checkAutoPlayBetsPlacement(2);
    
    if (countdownTimer) clearInterval(countdownTimer);
    updateCountdownProgress();
    
    countdownTimer = setInterval(() => {
        countdownTimeLeft -= 0.1;
        if (countdownTimeLeft <= 0.05) {
            clearInterval(countdownTimer);
            startFlightRound();
        } else {
            updateCountdownProgress();
        }
    }, 100);
}


function calculateRoundCrashPoint() {
    // Fetch crash point from server (admin-defined sequence ONLY).
    // No random fallback — game waits and retries if no points are configured.
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    return fetch('/game/next-crash-point', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token || ''
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.crash_point) {
            crashPoint = parseFloat(data.crash_point);
            crashPoint = Math.max(1.01, crashPoint);
            currentRoundId = data.round_id || ('RC-' + Math.floor(100000 + Math.random() * 900000));

            // Sync recent history from server
            if (data.recent_history && Array.isArray(data.recent_history)) {
                historyList = data.recent_history.map(x => parseFloat(x));
                renderHistoryBadges();
            }

            // Sync platform active settings in real-time
            if (data.active_helicopter_design) {
                window.activeHelicopterDesign = parseInt(data.active_helicopter_design);
            }
            if (data.game_countdown_time) {
                window.gameCountdownTime = parseInt(data.game_countdown_time);
                GameConfig.countdownDuration = window.gameCountdownTime;
            }
            if (typeof data.game_bg_music !== 'undefined') {
                window.gameBgMusicUrl = data.game_bg_music;
            }
            if (typeof data.game_countdown_sound !== 'undefined') {
                window.gameCountdownSoundUrl = data.game_countdown_sound;
            }
            console.log(`[ROUND] Crash Point: ${crashPoint.toFixed(2)}x (source: ${data.source}), Design: ${window.activeHelicopterDesign}`);
            // Valid crash point received — return true to signal success
            return true;
        } else {
            // Sync recent history from server if returned even on failure
            if (data && data.recent_history && Array.isArray(data.recent_history)) {
                historyList = data.recent_history.map(x => parseFloat(x));
                renderHistoryBadges();
            }
            // Admin has not configured crash points — DO NOT use random.
            // Show waiting message and signal the caller to retry.
            console.warn('[ROUND] No admin crash points configured. Game will wait and retry...');
            showWaitingForAdmin(data.message || 'Waiting for server configuration...');
            return false; // signal: retry needed
        }
    })
    .catch(err => {
        // Network error — DO NOT use random. Retry.
        console.error('[ROUND] Network error fetching crash point, will retry:', err);
        showWaitingForAdmin('Connecting to server...');
        return false; // signal: retry needed
    });
}

function showWaitingForAdmin(msg) {
    // Show an overlay on the game canvas so the player knows the game is paused
    if (DOM.countdownOverlay) {
        DOM.countdownOverlay.classList.remove('hidden');
    }
    if (DOM.countdownText) {
        DOM.countdownText.textContent = '⏳';
    }
    const waitEl = document.getElementById('admin-wait-msg');
    if (waitEl) {
        waitEl.textContent = msg;
        waitEl.style.display = 'block';
    }
}

function updateCountdownProgress() {
    const sec = Math.ceil(countdownTimeLeft);
    if (DOM.countdownText) DOM.countdownText.textContent = sec;
    
    // Play ticking beeps as it approaches launch
    if (sec < lastTickSecond && sec > 0) {
        soundEngine.playCountdownTick(sec);
        lastTickSecond = sec;
    }
    
    const pct = countdownTimeLeft / GameConfig.countdownDuration;
    const perimeter = 2 * Math.PI * 45;
    const dashoffset = perimeter * (1 - pct);
    if (DOM.countdownProgressCircle) DOM.countdownProgressCircle.style.strokeDashoffset = dashoffset;
    
    renderCanvasLoop();
}

function resetBettingRoundStates() {
    if (playerBets[1].active) {
        playerBets[1].inGame = true;
        playerBets[1].cashedOut = false;
    } else {
        playerBets[1].inGame = false;
        playerBets[1].cashedOut = false;
    }
    
    if (playerBets[2].active) {
        playerBets[2].inGame = true;
        playerBets[2].cashedOut = false;
    } else {
        playerBets[2].inGame = false;
        playerBets[2].cashedOut = false;
    }
    
    updateBettingButtonUI(1);
    updateBettingButtonUI(2);
}

function checkAutoPlayBetsPlacement(panelId) {
    const state = playerBets[panelId];
    if (state.autoPlay && !state.active) {
        const betInput = panelId === 1 ? DOM.betAmount1 : DOM.betAmount2;
        const amount = parseFloat(betInput.value) || 20;
        
        if (amount > 0 && amount <= balance) {
            state.amount = amount;
            state.active = true;
            balance -= amount;
            updateBalanceUI();
            
            addPlayerBetToLivePanel(panelId, amount);
            updateBettingButtonUI(panelId);
        }
    }
}

// Phase 2: Flight
function startFlightRound() {
    gameState = 'FLIGHT';
    
    if (DOM.countdownOverlay) DOM.countdownOverlay.classList.add('hidden');
    if (DOM.liveMultiplierDisplay) DOM.liveMultiplierDisplay.classList.remove('hidden');
    
    flightStartTime = Date.now();
    soundEngine.playPropeller();
    
    trailPoints = [];
    planePos = { x: 0, y: DOM.canvas ? DOM.canvas.height : 350 };
    explosionParticles = [];
    
    if (playerBets[1].active) {
        playerBets[1].inGame = true;
        playerBets[1].active = false;
        syncBetToDatabase(playerBets[1].amount);
    }
    if (playerBets[2].active) {
        playerBets[2].inGame = true;
        playerBets[2].active = false;
        syncBetToDatabase(playerBets[2].amount);
    }
    
    updateBettingButtonUI(1);
    updateBettingButtonUI(2);
    
    // Status polling for admin force-crash
    if (window.statusPollInterval) clearInterval(window.statusPollInterval);
    window.statusPollInterval = setInterval(() => {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch('/game/check-status', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token || ''
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (data.force_crash || (data.crash_point && data.crash_point < crashPoint)) {
                    crashPoint = parseFloat(data.crash_point);
                    console.log(`[FORCE CRASH] Syncing crash point to ${crashPoint}`);
                }
            }
        })
        .catch(err => console.error("Status sync failed:", err));
    }, 1500);
    
    animationFrameId = requestAnimationFrame(flightExecutionLoop);
}

function flightExecutionLoop() {
    if (gameState !== 'FLIGHT') return;
    
    const now = Date.now();
    timeInFlight = (now - flightStartTime) / 1000;
    
    currentMultiplier = Math.exp(GameConfig.growthRate * timeInFlight);
    
    if (DOM.liveMultiplierDisplay) DOM.liveMultiplierDisplay.textContent = currentMultiplier.toFixed(2) + 'x';
    
    soundEngine.updatePropellerPitch(currentMultiplier);
    processBetsDuringFlight();
    
    renderCanvasLoop();
    
    if (currentMultiplier >= crashPoint) {
        triggerCrashRound();
    } else {
        animationFrameId = requestAnimationFrame(flightExecutionLoop);
    }
}

function processBetsDuringFlight() {
    let winningsAdded = false;
    mockUsers.forEach(user => {
        if (user.status === 'pending' && currentMultiplier >= user.targetOdds) {
            user.status = 'win';
            user.winAmount = user.betAmount * user.targetOdds;
            totalWinningsAmount += user.winAmount;
            winningsAdded = true;
            updateMockUserRowUI(user);
        }
    });
    
    if (winningsAdded) {
        updateLiveStatsHeaderUI();
    }
    
    [1, 2].forEach(panelId => {
        const state = playerBets[panelId];
        if (state.inGame && !state.cashedOut) {
            updateBettingButtonUI(panelId);
        }
    });
}

function triggerCashout(panelId) {
    const state = playerBets[panelId];
    if (!state.inGame || state.cashedOut) return;
    
    state.cashedOut = true;
    state.odds = currentMultiplier;
    state.win = state.amount * currentMultiplier;
    
    balance += state.win;
    updateBalanceUI();
    
    soundEngine.playClick();
    updatePlayerBetRowGreen(panelId);
    updateBettingButtonUI(panelId);
    syncCashoutToDatabase(state.odds, state.win);
}

// Phase 3: Crash
function triggerCrashRound() {
    gameState = 'CRASHED';
    currentMultiplier = crashPoint;
    
    if (window.statusPollInterval) {
        clearInterval(window.statusPollInterval);
        window.statusPollInterval = null;
    }
    
    soundEngine.playExplosion();
    cancelAnimationFrame(animationFrameId);
    
    // Set text multiplier in the crash overlay to resolve double number overlap
    if (DOM.crashMultiplierDisplay) {
        DOM.crashMultiplierDisplay.textContent = crashPoint.toFixed(2) + 'x';
    }
    
    if (DOM.crashOverlay) DOM.crashOverlay.classList.remove('hidden');
    // Hide the floating bottom-right multiplier on crash to resolve overlapping
    if (DOM.liveMultiplierDisplay) DOM.liveMultiplierDisplay.classList.add('hidden');
    
    processBetsOnCrash();
    
    historyList.push(crashPoint);
    renderHistoryBadges();
    
    triggerCanvasExplosionParticles();
}

function triggerCanvasExplosionParticles() {
    explosionParticles = [];
    for (let i = 0; i < 75; i++) {
        explosionParticles.push(new Particle(planePos.x, planePos.y));
    }
    
    let frames = 0;
    function particleAnimate() {
        if (gameState !== 'CRASHED') return;
        renderCanvasLoop();
        
        frames++;
        if (frames < 180) {
            requestAnimationFrame(particleAnimate);
        } else {
            startCountdownRound();
        }
    }
    requestAnimationFrame(particleAnimate);
}

function processBetsOnCrash() {
    mockUsers.forEach(user => {
        if (user.status === 'pending') {
            user.status = 'lose';
            user.winAmount = 0.00;
            updateMockUserRowUI(user);
        }
    });
    
    [1, 2].forEach(panelId => {
        const state = playerBets[panelId];
        if (state.inGame) {
            if (!state.cashedOut) {
                state.odds = 0.00;
                state.win = 0.00;
                updatePlayerBetRowRed(panelId);
            }
            
            addPersonalHistoryLog(panelId, state.amount, state.odds, state.win, crashPoint);
            state.inGame = false;
        }
        
        updateBettingButtonUI(panelId);
    });
}

// ----------------------------------------------------
// Mock Betting Simulation Systems
// ----------------------------------------------------

function generateMockUsersBets() {
    mockUsers = [];
    
    if (DOM.betsListContainer) {
        DOM.betsListContainer.innerHTML = '';
        
        const numUsers = Math.floor(Math.random() * 21) + 25;
        
        for (let i = 0; i < numUsers; i++) {
            const username = '********' + Math.floor(Math.random() * 90 + 10);
            const betAmount = Math.floor(Math.random() * 80 + 5) * 50;
            
            let targetOdds = 1.01;
            const rand = Math.random();
            
            if (rand < 0.65) {
                targetOdds = 1.01 + Math.random() * (crashPoint - 1.01);
                if (targetOdds >= crashPoint) targetOdds = Math.max(1.01, crashPoint - 0.02);
            } else {
                targetOdds = crashPoint + Math.random() * (crashPoint * 0.8 + 0.5);
            }
            
            if (targetOdds <= 1.0) targetOdds = 1.01;
            
            const user = {
                id: 'mock_' + i,
                username,
                betAmount,
                targetOdds,
                status: 'pending',
                winAmount: 0.00
            };
            
            mockUsers.push(user);
        }
        
        mockUsers.sort((a, b) => a.targetOdds - b.targetOdds);
        
        mockUsers.forEach(user => {
            const row = document.createElement('div');
            row.className = 'bet-row pending';
            row.id = `user-row-${user.id}`;
            row.innerHTML = `
                <span class="user-name">${user.username}</span>
                <span class="user-odds">-</span>
                <span class="user-bet">${user.betAmount.toFixed(2)} BDT</span>
                <span class="user-win">-</span>
            `;
            DOM.betsListContainer.appendChild(row);
        });
    }
    
    // Set dynamic live stats for this round
    activeBetsCount = mockUsers.length;
    totalBetsAmount = mockUsers.reduce((sum, u) => sum + u.betAmount, 0);
    totalWinningsAmount = 0.00;
    
    updateLiveStatsHeaderUI();
}

function updateLiveStatsHeaderUI() {
    if (DOM.liveBetsCount) DOM.liveBetsCount.textContent = activeBetsCount;
    if (DOM.liveTotalBetAmount) DOM.liveTotalBetAmount.textContent = totalBetsAmount.toFixed(2) + ' BDT';
    if (DOM.liveTotalWinningsAmount) DOM.liveTotalWinningsAmount.textContent = totalWinningsAmount.toFixed(2) + ' BDT';
}

function updateMockUserRowUI(user) {
    const row = document.getElementById(`user-row-${user.id}`);
    if (!row) return;
    
    if (user.status === 'win') {
        row.className = 'bet-row win';
        row.querySelector('.user-odds').textContent = 'x' + user.targetOdds.toFixed(2);
        row.querySelector('.user-win').textContent = user.winAmount.toFixed(2) + ' BDT';
    } else if (user.status === 'lose') {
        row.className = 'bet-row lose';
        row.querySelector('.user-odds').textContent = 'x0';
        row.querySelector('.user-win').textContent = '0 BDT';
    }
}

function addPlayerBetToLivePanel(panelId, amount) {
    if (!DOM.betsListContainer) return;
    const row = document.createElement('div');
    row.className = 'bet-row pending';
    row.id = `player-bet-row-${panelId}`;
    row.style.borderLeft = '3px solid var(--color-gold)';
    row.innerHTML = `
        <span class="user-name text-gold">You (P${panelId})</span>
        <span class="user-odds">-</span>
        <span class="user-bet">${amount.toFixed(2)} BDT</span>
        <span class="user-win">-</span>
    `;
    DOM.betsListContainer.insertBefore(row, DOM.betsListContainer.firstChild);
    
    activeBetsCount++;
    totalBetsAmount += amount;
    updateLiveStatsHeaderUI();
}

function removePlayerBetFromLivePanel(panelId) {
    const row = document.getElementById(`player-bet-row-${panelId}`);
    if (row) {
        const betAmt = playerBets[panelId].amount;
        row.remove();
        
        activeBetsCount--;
        totalBetsAmount -= betAmt;
        updateLiveStatsHeaderUI();
    }
}

function updatePlayerBetRowGreen(panelId) {
    const row = document.getElementById(`player-bet-row-${panelId}`);
    if (row) {
        const state = playerBets[panelId];
        row.className = 'bet-row win';
        row.querySelector('.user-odds').textContent = 'x' + state.odds.toFixed(2);
        row.querySelector('.user-win').textContent = state.win.toFixed(2) + ' BDT';
        
        totalWinningsAmount += state.win;
        updateLiveStatsHeaderUI();
    }
}

function updatePlayerBetRowRed(panelId) {
    const row = document.getElementById(`player-bet-row-${panelId}`);
    if (row) {
        row.className = 'bet-row lose';
        row.querySelector('.user-odds').textContent = 'x0';
        row.querySelector('.user-win').textContent = '0 BDT';
    }
}

function addPersonalHistoryLog(panelId, betAmount, cashoutOdds, winnings, crashOdds) {
    if (DOM.emptyHistoryPlaceholder) DOM.emptyHistoryPlaceholder.classList.add('hidden');
    if (DOM.personalHistoryTable) DOM.personalHistoryTable.classList.remove('hidden');
    
    const now = new Date();
    const dateStr = now.toLocaleDateString();
    const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    const roundId = currentRoundId || ('RC-' + Math.floor(100000 + Math.random() * 900000));
    
    const row = document.createElement('tr');
    
    const winClass = winnings > 0 ? 'text-green' : 'text-red';
    const cashoutStr = cashoutOdds > 0 ? `${cashoutOdds.toFixed(2)}x` : '-';
    
    row.innerHTML = `
        <td>${dateStr}</td>
        <td>${timeStr}</td>
        <td>${roundId}</td>
        <td>${betAmount.toFixed(2)} BDT</td>
        <td class="${winClass}">${cashoutStr}</td>
        <td class="${winClass}">${winnings.toFixed(2)} BDT</td>
        <td style="font-weight: 700;">${crashOdds.toFixed(2)}x</td>
    `;
    
    if (DOM.personalHistoryTbody) DOM.personalHistoryTbody.insertBefore(row, DOM.personalHistoryTbody.firstChild);
}

// ----------------------------------------------------
// Canvas Flight & Visual Art Rendering
// ----------------------------------------------------
function renderCanvasLoop() {
    if (!ctx) return;
    
    const w = DOM.canvas.width;
    const h = DOM.canvas.height;
    
    ctx.clearRect(0, 0, w, h);
    
    drawGrid(w, h);
    drawParallaxHills(w, h);
    
    if (gameState === 'COUNTDOWN') {
        // Helicopter does not appear during countdown as requested by user
        planePos = { x: 30, y: h - 15 };
    } 
    else if (gameState === 'FLIGHT') {
        const startX = 0;
        const startY = h;
        
        const xStep = timeInFlight * 48; 
        const yStep = Math.pow(timeInFlight, 1.45) * 16; 
        
        let targetX = startX + xStep;
        let targetY = startY - yStep;
        
        const limitX = w * 0.55;
        const limitY = h * 0.32;
        
        if (targetX > limitX) {
            const diffX = targetX - limitX;
            gridOffset.x = (gridOffset.x - diffX * 0.15) % 40;
            landscapeOffset -= diffX * 0.08;
            targetX = limitX;
        }
        
        if (targetY < limitY) {
            const diffY = limitY - targetY;
            gridOffset.y = (gridOffset.y + diffY * 0.15) % 40;
            targetY = limitY;
        }
        
        planePos.x = targetX;
        planePos.y = targetY;
        
        trailPoints.push({ x: planePos.x, y: planePos.y });
        if (trailPoints.length > 200) trailPoints.shift();
        
        drawFlightTrailCurve(startX, startY);
        drawPlaneGlow(planePos.x, planePos.y);
        drawHelicopterPlane(planePos.x, planePos.y, true);
    } 
    else if (gameState === 'CRASHED') {
        const startX = 0;
        const startY = h;
        drawFlightTrailCurve(startX, startY);
        
        // Continuously generate rising fire and smoke particles at the crash coordinates
        if (explosionParticles.length < 200) {
            for (let i = 0; i < 3; i++) {
                const p = new Particle(planePos.x, planePos.y);
                // Custom parameters for continuous combustion: float upward and decay slower
                if (Math.random() < 0.6) {
                    p.type = 1; // grey/black smoke
                    p.vx = (Math.random() - 0.5) * 2;
                    p.vy = -Math.random() * 3 - 1; // float up
                    p.size = Math.random() * 16 + 8;
                    p.decay = Math.random() * 0.01 + 0.005; 
                } else {
                    p.type = Math.random() < 0.5 ? 0 : 2; // flame / glowing sparks
                    p.vx = (Math.random() - 0.5) * 3;
                    p.vy = -Math.random() * 2.5 - 0.5; // rise up
                    p.size = Math.random() * 10 + 4;
                    p.decay = Math.random() * 0.018 + 0.008;
                }
                explosionParticles.push(p);
            }
        }
        
        explosionParticles.forEach(p => {
            p.update();
            p.draw(ctx);
        });

        // Filter out dead particles
        explosionParticles = explosionParticles.filter(p => p.life > 0);
        
        // drawCrashedTextLabel is removed to prevent double overlay text boxes
    }
}

function drawGrid(w, h) {
    const isLight = document.body.classList.contains('light-theme');
    ctx.strokeStyle = isLight ? 'rgba(0, 0, 0, 0.08)' : 'rgba(36, 52, 92, 0.18)';
    ctx.lineWidth = 1;
    const spacing = 40;
    
    let startX = (gridOffset.x % spacing);
    if (startX > 0) startX -= spacing;
    for (let x = startX; x < w; x += spacing) {
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, h);
        ctx.stroke();
    }
    
    let startY = (gridOffset.y % spacing);
    if (startY < 0) startY += spacing;
    for (let y = startY; y < h; y += spacing) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(w, y);
        ctx.stroke();
    }
}

function drawParallaxHills(w, h) {
    const isLight = document.body.classList.contains('light-theme');
    ctx.save();
    
    ctx.fillStyle = isLight ? '#f1f5f9' : '#080d19';
    ctx.beginPath();
    ctx.moveTo(0, h);
    
    const farSpeed = landscapeOffset * 0.15;
    for (let x = 0; x <= w; x += 10) {
        const y = h - 90 + Math.sin((x - farSpeed) * 0.004) * 25 + Math.cos((x - farSpeed) * 0.012) * 10;
        ctx.lineTo(x, y);
    }
    ctx.lineTo(w, h);
    ctx.fill();
    
    ctx.fillStyle = isLight ? '#e2e8f0' : '#0b1426';
    ctx.beginPath();
    ctx.moveTo(0, h);
    
    const midSpeed = landscapeOffset * 0.35;
    for (let x = 0; x <= w; x += 10) {
        const y = h - 50 + Math.sin((x - midSpeed) * 0.007) * 35 + Math.cos((x - midSpeed) * 0.02) * 12;
        ctx.lineTo(x, y);
    }
    ctx.lineTo(w, h);
    ctx.fill();
    
    ctx.restore();
}

function drawFlightTrailCurve(startX, startY) {
    if (trailPoints.length < 2) return;
    
    ctx.save();
    
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    for (let i = 0; i < trailPoints.length; i++) {
        ctx.lineTo(trailPoints[i].x, trailPoints[i].y);
    }
    ctx.lineTo(planePos.x, startY);
    ctx.lineTo(startX, startY);
    ctx.closePath();
    
    const fillGrad = ctx.createLinearGradient(0, planePos.y, 0, startY);
    fillGrad.addColorStop(0, 'rgba(240, 100, 36, 0.45)');
    fillGrad.addColorStop(1, 'rgba(240, 100, 36, 0.0)');
    ctx.fillStyle = fillGrad;
    ctx.fill();
    
    ctx.shadowBlur = 15;
    ctx.shadowColor = 'rgba(241, 99, 34, 0.7)';
    
    const lineGrad = ctx.createLinearGradient(startX, startY, planePos.x, planePos.y);
    lineGrad.addColorStop(0, '#f06424');
    lineGrad.addColorStop(0.5, '#ffbe1a');
    lineGrad.addColorStop(1, '#ffffff');
    
    ctx.strokeStyle = lineGrad;
    ctx.lineWidth = 4.0;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    for (let i = 0; i < trailPoints.length; i++) {
        ctx.lineTo(trailPoints[i].x, trailPoints[i].y);
    }
    ctx.stroke();
    
    ctx.restore();
}

function drawPlaneGlow(x, y) {
    ctx.save();
    const grad = ctx.createRadialGradient(x, y, 2, x, y, 50);
    grad.addColorStop(0, 'rgba(255, 190, 26, 0.38)');
    grad.addColorStop(1, 'rgba(255, 190, 26, 0)');
    ctx.fillStyle = grad;
    ctx.beginPath();
    ctx.arc(x, y, 50, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
}

// Render a large, highly-detailed golden supersonic fighter jet plane with a pilot visible inside the canopy
function drawHelicopterPlane(x, y, isFlying) {
    ctx.save();
    
    ctx.translate(x, y);
    ctx.scale(1.6, 1.6);
    
    ctx.shadowBlur = 10;
    
    const designIndex = window.activeHelicopterDesign || 1;
    const time = Date.now();
    
    let targetTilt = -20 * Math.PI / 180;
    if (isFlying && designIndex !== 4 && designIndex !== 8) { // Skip tilt for UFO and Balloon
        const tiltOsc = Math.sin(time * 0.015) * 0.02;
        ctx.rotate(targetTilt + tiltOsc);
    } else if (designIndex !== 4 && designIndex !== 8) {
        ctx.rotate(targetTilt);
    }
    
    switch(parseInt(designIndex)) {
        case 1: // Gold Fighter Jet
            ctx.shadowColor = 'rgba(255, 190, 26, 0.6)';
            ctx.shadowBlur = 15;
            if (isFlying) {
                ctx.save();
                ctx.shadowColor = '#f06424';
                ctx.shadowBlur = 20;
                const flameLength = 24 + Math.sin(time * 0.055) * 8;
                const fireGrad = ctx.createLinearGradient(-25 - flameLength, 0, -25, 0);
                fireGrad.addColorStop(0, 'rgba(235, 64, 52, 0)');
                fireGrad.addColorStop(0.5, '#f06424');
                fireGrad.addColorStop(1, '#ffbe1a');
                ctx.fillStyle = fireGrad;
                ctx.beginPath();
                ctx.moveTo(-24, -4);
                ctx.lineTo(-24 - flameLength, 0);
                ctx.lineTo(-24, 4);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }
            ctx.fillStyle = '#b28005';
            ctx.beginPath();
            ctx.moveTo(-8, 3);
            ctx.lineTo(-18, 18);
            ctx.lineTo(-5, 18);
            ctx.lineTo(8, 3);
            ctx.closePath();
            ctx.fill();
            
            const goldGrad = ctx.createLinearGradient(-25, 0, 25, 0);
            goldGrad.addColorStop(0, '#e5a910');
            goldGrad.addColorStop(0.5, '#ffd13b');
            goldGrad.addColorStop(1, '#ffffff');
            ctx.fillStyle = goldGrad;
            ctx.beginPath();
            ctx.moveTo(28, -1);
            ctx.bezierCurveTo(20, -5, 0, -7, -20, -5);
            ctx.lineTo(-24, -4);
            ctx.lineTo(-24, 2);
            ctx.lineTo(-20, 3);
            ctx.bezierCurveTo(0, 5, 20, 3, 28, -1);
            ctx.closePath();
            ctx.fill();
            
            ctx.fillStyle = '#3c3c3c';
            ctx.fillRect(-25, -4, 2, 6);
            ctx.fillStyle = '#ef4444';
            ctx.beginPath();
            ctx.arc(10.5, -2.0, 3.2, 0, Math.PI * 2);
            ctx.fill();
            ctx.fillStyle = 'rgba(168, 225, 255, 0.55)';
            ctx.beginPath();
            ctx.moveTo(6, -4);
            ctx.quadraticCurveTo(15, -4, 18, -1);
            ctx.quadraticCurveTo(10, 2, 4, 1);
            ctx.closePath();
            ctx.fill();
            ctx.fillStyle = '#f06424';
            ctx.beginPath();
            ctx.moveTo(-8, -5);
            ctx.lineTo(-21, -19);
            ctx.lineTo(-26, -19);
            ctx.closePath();
            ctx.fill();
            break;

        case 2: // Classic Chopper
            ctx.shadowColor = 'rgba(30, 58, 138, 0.4)';
            ctx.fillStyle = '#1e3a8a';
            ctx.beginPath();
            ctx.ellipse(0, 0, 20, 14, 0, 0, Math.PI * 2);
            ctx.fill();
            
            ctx.strokeStyle = '#1e3a8a';
            ctx.lineWidth = 4;
            ctx.beginPath();
            ctx.moveTo(-15, 0);
            ctx.lineTo(-35, -5);
            ctx.stroke();

            ctx.fillStyle = '#ef4444';
            ctx.fillRect(-37, -12, 4, 10);
            ctx.save();
            ctx.translate(-35, -7);
            ctx.rotate(time * 0.15);
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(-8, 0); ctx.lineTo(8, 0);
            ctx.moveTo(0, -8); ctx.lineTo(0, 8);
            ctx.stroke();
            ctx.restore();

            ctx.strokeStyle = '#64748b';
            ctx.lineWidth = 2.5;
            ctx.beginPath();
            ctx.moveTo(-10, 14); ctx.lineTo(-10, 20);
            ctx.moveTo(10, 14); ctx.lineTo(10, 20);
            ctx.moveTo(-18, 20); ctx.lineTo(18, 20);
            ctx.stroke();

            ctx.fillStyle = 'rgba(147, 197, 253, 0.6)';
            ctx.beginPath();
            ctx.arc(8, -2, 8, -Math.PI/2, Math.PI/2);
            ctx.fill();

            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(0, -14); ctx.lineTo(0, -19);
            ctx.stroke();

            ctx.save();
            ctx.translate(0, -19);
            const bladeScale = Math.cos(time * 0.1);
            ctx.strokeStyle = 'rgba(255,255,255,0.7)';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(-35 * bladeScale, 0);
            ctx.lineTo(35 * bladeScale, 0);
            ctx.stroke();
            ctx.restore();
            break;

        case 3: // Space Rocket
            ctx.rotate(Math.PI / 4);
            ctx.shadowColor = 'rgba(239, 68, 68, 0.4)';
            if (isFlying) {
                ctx.save();
                const plume = 15 + Math.sin(time * 0.08) * 6;
                const fire = ctx.createLinearGradient(0, 15, 0, 15 + plume);
                fire.addColorStop(0, '#ffbe1a');
                fire.addColorStop(0.5, '#f06424');
                fire.addColorStop(1, 'rgba(239, 68, 68, 0)');
                ctx.fillStyle = fire;
                ctx.beginPath();
                ctx.moveTo(-8, 15);
                ctx.lineTo(0, 15 + plume);
                ctx.lineTo(8, 15);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }
            ctx.fillStyle = '#f8fafc';
            ctx.beginPath();
            ctx.moveTo(0, -25);
            ctx.bezierCurveTo(10, -10, 10, 10, 8, 15);
            ctx.lineTo(-8, 15);
            ctx.bezierCurveTo(-10, 10, -10, -10, 0, -25);
            ctx.fill();

            ctx.fillStyle = '#ef4444';
            ctx.beginPath();
            ctx.moveTo(0, -25);
            ctx.bezierCurveTo(7, -15, 7, -10, 7, -8);
            ctx.lineTo(-7, -8);
            ctx.bezierCurveTo(-7, -10, -7, -15, 0, -25);
            ctx.fill();

            ctx.beginPath();
            ctx.moveTo(-8, 5); ctx.lineTo(-16, 17); ctx.lineTo(-8, 15); ctx.fill();
            ctx.beginPath();
            ctx.moveTo(8, 5); ctx.lineTo(16, 17); ctx.lineTo(8, 15); ctx.fill();

            ctx.fillStyle = '#0f172a';
            ctx.beginPath();
            ctx.arc(0, -2, 5, 0, Math.PI * 2);
            ctx.fill();
            ctx.fillStyle = '#93c5fd';
            ctx.beginPath();
            ctx.arc(0, -2, 3.8, 0, Math.PI * 2);
            ctx.fill();
            break;

        case 4: // Alien UFO
            ctx.shadowColor = 'rgba(34, 197, 94, 0.4)';
            if (isFlying) {
                ctx.save();
                const beamGrad = ctx.createLinearGradient(0, 5, 0, 45);
                beamGrad.addColorStop(0, 'rgba(34, 197, 94, 0.4)');
                beamGrad.addColorStop(1, 'rgba(34, 197, 94, 0.0)');
                ctx.fillStyle = beamGrad;
                ctx.beginPath();
                ctx.moveTo(-10, 5);
                ctx.lineTo(-25, 45);
                ctx.lineTo(25, 45);
                ctx.lineTo(10, 5);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }
            ctx.fillStyle = '#64748b';
            ctx.beginPath();
            ctx.ellipse(0, 2, 28, 9, 0, 0, Math.PI * 2);
            ctx.fill();

            const lightColor = Math.floor(time / 200) % 2 === 0 ? '#ffbe1a' : '#22c55e';
            ctx.fillStyle = lightColor;
            for (let angle = -2.5; angle <= 2.5; angle += 0.8) {
                ctx.beginPath();
                ctx.arc(Math.sin(angle) * 23, 2 + Math.cos(angle)*1.2, 2, 0, Math.PI*2);
                ctx.fill();
            }

            ctx.fillStyle = 'rgba(52, 211, 153, 0.7)';
            ctx.beginPath();
            ctx.arc(0, -2, 11, Math.PI, 0);
            ctx.fill();

            ctx.fillStyle = '#064e3b';
            ctx.beginPath();
            ctx.arc(0, -5, 3, 0, Math.PI*2);
            ctx.fill();
            ctx.fillRect(-1.5, -3, 3, 4);
            break;

        case 5: // Stealth Bomber
            ctx.shadowColor = 'rgba(139, 92, 246, 0.4)';
            if (isFlying) {
                ctx.save();
                ctx.strokeStyle = '#8b5cf6';
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.moveTo(-10, 7);
                ctx.lineTo(-25, 7);
                ctx.stroke();
                ctx.restore();
            }
            ctx.fillStyle = '#1e293b';
            ctx.beginPath();
            ctx.moveTo(30, 0);
            ctx.lineTo(-25, 20);
            ctx.lineTo(-12, 0);
            ctx.lineTo(-25, -20);
            ctx.closePath();
            ctx.fill();

            ctx.strokeStyle = 'rgba(255,255,255,0.06)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(30, 0);
            ctx.lineTo(-12, 0);
            ctx.stroke();

            ctx.fillStyle = '#ef4444';
            ctx.beginPath();
            ctx.arc(-22, 18, 1.5, 0, Math.PI*2);
            ctx.arc(-22, -18, 1.5, 0, Math.PI*2);
            ctx.fill();
            break;

        case 6: // Cyber Drone
            ctx.shadowColor = 'rgba(6, 182, 212, 0.4)';
            ctx.fillStyle = '#0f172a';
            ctx.strokeStyle = '#06b6d4';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.arc(0, 0, 8, 0, Math.PI*2);
            ctx.fill();
            ctx.stroke();

            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(-6, -6); ctx.lineTo(-18, -18);
            ctx.moveTo(6, -6); ctx.lineTo(18, -18);
            ctx.moveTo(-6, 6); ctx.lineTo(-18, 18);
            ctx.moveTo(6, 6); ctx.lineTo(18, 18);
            ctx.stroke();

            const rotAngle = time * 0.1;
            const arms = [
                {x: -18, y: -18}, {x: 18, y: -18},
                {x: -18, y: 18}, {x: 18, y: 18}
            ];
            arms.forEach(arm => {
                ctx.fillStyle = '#0f172a';
                ctx.beginPath();
                ctx.arc(arm.x, arm.y, 4, 0, Math.PI*2);
                ctx.fill();

                ctx.save();
                ctx.translate(arm.x, arm.y);
                ctx.rotate(rotAngle);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.6)';
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(-12, 0); ctx.lineTo(12, 0);
                ctx.stroke();
                ctx.restore();
            });

            ctx.fillStyle = '#22d3ee';
            ctx.beginPath();
            ctx.arc(0, 0, 3, 0, Math.PI*2);
            ctx.fill();
            break;

        case 7: // Vintage Biplane
            ctx.shadowColor = 'rgba(185, 28, 28, 0.4)';
            ctx.save();
            ctx.translate(22, 0);
            ctx.fillStyle = '#e2e8f0';
            ctx.beginPath();
            ctx.arc(0, 0, 3, 0, Math.PI*2);
            ctx.fill();
            
            ctx.rotate(time * 0.12);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(0, -22); ctx.lineTo(0, 22);
            ctx.stroke();
            ctx.restore();

            ctx.fillStyle = '#b91c1c';
            ctx.beginPath();
            ctx.moveTo(20, -4);
            ctx.lineTo(-24, -2);
            ctx.lineTo(-24, 2);
            ctx.lineTo(20, 4);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = '#facc15';
            ctx.fillRect(-27, -8, 4, 16);
            ctx.fillRect(-27, -10, 6, 4);

            ctx.fillStyle = '#1e293b';
            ctx.beginPath();
            ctx.arc(8, 10, 4, 0, Math.PI*2);
            ctx.fill();
            ctx.strokeStyle = '#94a3b8';
            ctx.beginPath();
            ctx.moveTo(8, 2); ctx.lineTo(8, 8);
            ctx.stroke();

            ctx.fillStyle = '#facc15';
            ctx.fillRect(-5, -16, 12, 4);
            ctx.fillRect(-5, 12, 12, 4);
            
            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(1, -12); ctx.lineTo(1, 12);
            ctx.moveTo(5, -12); ctx.lineTo(5, 12);
            ctx.stroke();
            break;

        case 8: // Hot Air Balloon
            ctx.shadowColor = 'rgba(249, 115, 22, 0.4)';
            if (isFlying) {
                ctx.fillStyle = '#f97316';
                ctx.beginPath();
                ctx.moveTo(-3, 10);
                ctx.lineTo(0, 10 - (8 + Math.sin(time*0.05)*3));
                ctx.lineTo(3, 10);
                ctx.closePath();
                ctx.fill();
            }
            const stripeColors = ['#ef4444', '#3b82f6', '#f59e0b', '#10b981'];
            ctx.save();
            ctx.translate(0, -12);
            ctx.beginPath();
            ctx.arc(0, 0, 20, 0.15 * Math.PI, 0.85 * Math.PI, true);
            ctx.lineTo(-7, 22);
            ctx.lineTo(7, 22);
            ctx.closePath();
            ctx.clip();

            for (let i = -3; i <= 3; i++) {
                ctx.fillStyle = stripeColors[Math.abs(i) % stripeColors.length];
                ctx.fillRect(i * 7 - 3.5, -25, 7, 50);
            }
            ctx.restore();

            ctx.strokeStyle = '#b45309';
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.moveTo(-6, 10); ctx.lineTo(-4, 18);
            ctx.moveTo(6, 10); ctx.lineTo(4, 18);
            ctx.stroke();

            ctx.fillStyle = '#78350f';
            ctx.fillRect(-5, 18, 10, 8);
            break;

        case 9: // Future Skycar
            ctx.shadowColor = 'rgba(109, 40, 217, 0.4)';
            if (isFlying) {
                ctx.save();
                ctx.shadowColor = '#06b6d4';
                ctx.shadowBlur = 10;
                ctx.fillStyle = 'rgba(6, 182, 212, 0.6)';
                ctx.fillRect(-15, 6, 8, 4);
                ctx.fillRect(7, 6, 8, 4);
                ctx.restore();
            }
            ctx.fillStyle = '#6d28d9';
            ctx.beginPath();
            ctx.moveTo(24, 0);
            ctx.bezierCurveTo(20, -8, -10, -9, -24, -4);
            ctx.lineTo(-24, 4);
            ctx.bezierCurveTo(-10, 9, 20, 8, 24, 0);
            ctx.closePath();
            ctx.fill();

            ctx.strokeStyle = '#a78bfa';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(12, 2);
            ctx.lineTo(-16, 2);
            ctx.stroke();

            ctx.fillStyle = 'rgba(34, 211, 238, 0.6)';
            ctx.beginPath();
            ctx.moveTo(4, -4);
            ctx.quadraticCurveTo(15, -4, 17, 0);
            ctx.quadraticCurveTo(10, 4, 3, 2);
            ctx.closePath();
            ctx.fill();
            break;

        case 10: // Phoenix Firebird
            ctx.shadowColor = 'rgba(239, 68, 68, 0.6)';
            const wingFlap = Math.sin(time * 0.02) * 0.4;
            ctx.save();
            const tailGrad = ctx.createLinearGradient(-12, 0, -32, 0);
            tailGrad.addColorStop(0, '#f97316');
            tailGrad.addColorStop(1, 'rgba(239, 68, 68, 0)');
            ctx.fillStyle = tailGrad;
            ctx.beginPath();
            ctx.moveTo(-10, -3);
            ctx.lineTo(-30, -10);
            ctx.lineTo(-24, 0);
            ctx.lineTo(-30, 10);
            ctx.lineTo(-10, 3);
            ctx.closePath();
            ctx.fill();
            ctx.restore();

            ctx.fillStyle = '#ef4444';
            ctx.beginPath();
            ctx.moveTo(16, 0);
            ctx.quadraticCurveTo(8, -6, -10, -3);
            ctx.lineTo(-8, 3);
            ctx.quadraticCurveTo(8, 6, 16, 0);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = '#facc15';
            ctx.beginPath();
            ctx.moveTo(16, -2);
            ctx.lineTo(22, 0);
            ctx.lineTo(16, 2);
            ctx.closePath();
            ctx.fill();

            ctx.save();
            ctx.translate(0, 0);
            ctx.rotate(wingFlap);
            const wingGrad = ctx.createLinearGradient(0, 0, 0, -25);
            wingGrad.addColorStop(0, '#ef4444');
            wingGrad.addColorStop(0.7, '#f97316');
            wingGrad.addColorStop(1, '#facc15');
            ctx.fillStyle = wingGrad;
            ctx.beginPath();
            ctx.moveTo(-4, 0);
            ctx.quadraticCurveTo(-8, -15, 2, -26);
            ctx.quadraticCurveTo(8, -12, 4, 0);
            ctx.closePath();
            ctx.fill();
            ctx.restore();
            break;
    }

    ctx.restore();
}

function drawCrashedTextLabel(w, h) {
    ctx.save();
    
    ctx.fillStyle = '#ffffff';
    ctx.font = '800 84px Outfit, sans-serif';
    ctx.textAlign = 'right';
    ctx.fillText(crashPoint.toFixed(2) + 'x', w - 48, h - 48);
    
    ctx.fillStyle = 'rgba(235, 64, 52, 0.1)';
    ctx.strokeStyle = 'rgba(235, 64, 52, 0.6)';
    ctx.lineWidth = 2;
    
    const rectW = 260;
    const rectH = 80;
    const rectX = (w - rectW) / 2;
    const rectY = (h - rectH) / 2;
    
    ctx.fillStyle = 'rgba(11, 16, 33, 0.85)';
    ctx.beginPath();
    ctx.roundRect(rectX, rectY, rectW, rectH, 10);
    ctx.fill();
    ctx.stroke();
    
    ctx.fillStyle = '#eb4034';
    ctx.font = '800 13px Outfit, sans-serif';
    ctx.textAlign = 'center';
    ctx.letterSpacing = '3px';
    ctx.fillText('CRASHED', w/2, h/2 - 10);
    
    ctx.fillStyle = '#ffffff';
    ctx.font = '800 32px Outfit, sans-serif';
    ctx.fillText(crashPoint.toFixed(2) + 'x', w/2, h/2 + 25);
    
    ctx.restore();
}

// Helper functions to sync bets/cashouts to DB
function syncBetToDatabase(amount) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token || !currentRoundId) return;

    fetch('/game/bet/place', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            round_id: currentRoundId,
            bet_amount: amount
        })
    })
    .then(r => r.json())
    .then(data => {
        console.log('[BET] Synced bet to database:', amount);
    })
    .catch(err => console.error('[BET] Failed to sync bet:', err));
}

function syncCashoutToDatabase(odds, winnings) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token || !currentRoundId) return;

    fetch('/game/bet/cashout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            round_id: currentRoundId,
            cashout_odds: odds,
            winnings: winnings
        })
    })
    .then(r => r.json())
    .then(data => {
        console.log('[BET] Synced cashout to database:', winnings);
    })
    .catch(err => console.error('[BET] Failed to sync cashout:', err));
}

// Hook for Admin Force Crash
window.adminForceCrashGame = function() {
    if (gameState === 'FLIGHT') {
        crashPoint = currentMultiplier; // crash immediately at current value
        triggerCrashRound();
    }
};

window.addEventListener('admin-force-crash', () => {
    if (typeof window.adminForceCrashGame === 'function') {
        window.adminForceCrashGame();
    }
});

// Start application
window.onload = initApp;

