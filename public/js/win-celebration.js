/**
 * Universal Win Celebration & Fire Motion Graphics System
 * High Performance Canvas Particles + Realistic Flame FX + Golden Coins
 */
(function() {
    'use strict';

    // Inject CSS styles for Win Celebration
    const style = document.createElement('style');
    style.id = 'win-celebration-styles';
    style.textContent = `
        .win-celebration-overlay {
            position: fixed;
            inset: 0;
            z-index: 999999;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            font-family: 'Outfit', 'Inter', system-ui, sans-serif;
        }
        .win-celebration-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .win-fire-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        .win-celebration-card {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px 48px;
            background: radial-gradient(circle at center, rgba(30, 10, 4, 0.95) 0%, rgba(10, 5, 2, 0.98) 100%);
            border: 2.5px solid #ff9900;
            border-radius: 24px;
            box-shadow: 
                0 0 50px rgba(255, 100, 0, 0.8),
                0 0 100px rgba(255, 50, 0, 0.5),
                inset 0 0 30px rgba(255, 150, 0, 0.4);
            transform: scale(0.6) translateY(40px);
            animation: winCardPop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        @keyframes winCardPop {
            0% { transform: scale(0.4) translateY(60px); opacity: 0; filter: brightness(2); }
            60% { transform: scale(1.08) translateY(-10px); opacity: 1; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .win-fire-badge {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #ffd700;
            background: linear-gradient(90deg, #ff4500, #ff8c00);
            padding: 6px 18px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(255, 69, 0, 0.8);
            margin-bottom: 12px;
            animation: pulseBadge 1.2s infinite alternate;
        }
        @keyframes pulseBadge {
            0% { transform: scale(0.95); box-shadow: 0 0 10px rgba(255, 69, 0, 0.6); }
            100% { transform: scale(1.05); box-shadow: 0 0 25px rgba(255, 140, 0, 1); }
        }
        .win-title-flame {
            font-size: 42px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 10px 0;
            background: linear-gradient(180deg, #ffffff 0%, #fff275 30%, #ff8c00 70%, #ff2200 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px rgba(255, 80, 0, 0.9));
            animation: flameFlicker 1.5s infinite alternate;
        }
        @keyframes flameFlicker {
            0% { filter: drop-shadow(0 0 15px rgba(255, 80, 0, 0.8)); transform: scale(0.99); }
            100% { filter: drop-shadow(0 0 30px rgba(255, 200, 0, 1)); transform: scale(1.02); }
        }
        .win-amount-val {
            font-size: 48px;
            font-weight: 900;
            color: #00ff88;
            text-shadow: 0 0 25px rgba(0, 255, 136, 0.8), 0 0 10px rgba(0, 0, 0, 0.9);
            margin: 8px 0 16px 0;
            font-family: 'Roboto Mono', 'Outfit', monospace;
        }
        .win-multiplier-pill {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 4px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .win-dismiss-btn {
            background: linear-gradient(135deg, #ff8c00 0%, #ff2200 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 15px;
            border: none;
            padding: 10px 32px;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 34, 0, 0.6);
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .win-dismiss-btn:hover {
            transform: scale(1.06);
            filter: brightness(1.2);
            box-shadow: 0 6px 30px rgba(255, 100, 0, 0.9);
        }
    `;
    document.head.appendChild(style);

    // Audio synthesizer for victory fanfare & fire whoosh
    function playVictoryChime() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            const ctx = new AudioContext();
            
            // Notes for triumphant brass fanfare
            const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99]; // C4, E4, G4, C5, E5, G5
            notes.forEach((freq, idx) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(freq, ctx.currentTime + idx * 0.08);
                
                gain.gain.setValueAtTime(0, ctx.currentTime + idx * 0.08);
                gain.gain.linearRampToValueAtTime(0.25, ctx.currentTime + idx * 0.08 + 0.03);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + idx * 0.08 + 0.8);
                
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(ctx.currentTime + idx * 0.08);
                osc.stop(ctx.currentTime + idx * 0.08 + 0.85);
            });
        } catch(e) {}
    }

    // Fire & Particle Canvas Animator
    class FireParticleSystem {
        constructor(canvas) {
            this.canvas = canvas;
            this.ctx = canvas.getContext('2d');
            this.particles = [];
            this.active = false;
            this.animId = null;
            this.resize();
            window.addEventListener('resize', () => this.resize());
        }

        resize() {
            this.canvas.width = window.innerWidth;
            this.canvas.height = window.innerHeight;
        }

        start() {
            this.active = true;
            this.particles = [];
            this.resize();
            this.animate();
        }

        stop() {
            this.active = false;
            if (this.animId) cancelAnimationFrame(this.animId);
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }

        animate() {
            if (!this.active) return;
            const ctx = this.ctx;
            const w = this.canvas.width;
            const h = this.canvas.height;

            ctx.clearRect(0, 0, w, h);

            // Spawn fire sparks from bottom and sides
            for (let i = 0; i < 8; i++) {
                this.particles.push({
                    x: Math.random() * w,
                    y: h + 10,
                    vx: (Math.random() - 0.5) * 4,
                    vy: -(Math.random() * 8 + 6),
                    size: Math.random() * 22 + 10,
                    color: Math.random() > 0.4 ? '#ff5500' : (Math.random() > 0.5 ? '#ffcc00' : '#ff0033'),
                    alpha: 1,
                    decay: Math.random() * 0.015 + 0.01,
                    type: 'fire'
                });
            }

            // Spawn golden celebration coins
            if (Math.random() < 0.4) {
                this.particles.push({
                    x: Math.random() * w,
                    y: -20,
                    vx: (Math.random() - 0.5) * 3,
                    vy: Math.random() * 5 + 3,
                    size: Math.random() * 8 + 6,
                    color: '#ffd700',
                    alpha: 1,
                    rot: Math.random() * Math.PI * 2,
                    rotSpeed: (Math.random() - 0.5) * 0.2,
                    decay: 0.003,
                    type: 'coin'
                });
            }

            // Update & Render particles
            for (let i = this.particles.length - 1; i >= 0; i--) {
                const p = this.particles[i];
                p.x += p.vx;
                p.y += p.vy;
                p.alpha -= p.decay;
                p.size *= 0.98;

                if (p.alpha <= 0 || p.size <= 1) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = p.color;
                ctx.shadowBlur = 15;
                ctx.shadowColor = p.color;

                if (p.type === 'coin') {
                    p.rot += p.rotSpeed;
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rot);
                    ctx.beginPath();
                    ctx.ellipse(0, 0, p.size, p.size * 0.6, 0, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.strokeStyle = '#fff8b3';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                } else {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fill();
                }
                ctx.restore();
            }

            this.animId = requestAnimationFrame(() => this.animate());
        }
    }

    let overlayEl = null;
    let fireCanvas = null;
    let fireSystem = null;
    let autoCloseTimer = null;

    function initOverlay() {
        if (overlayEl) return;
        overlayEl = document.createElement('div');
        overlayEl.className = 'win-celebration-overlay';
        overlayEl.id = 'win-celebration-overlay';

        fireCanvas = document.createElement('canvas');
        fireCanvas.className = 'win-fire-canvas';
        overlayEl.appendChild(fireCanvas);

        const card = document.createElement('div');
        card.className = 'win-celebration-card';
        card.id = 'win-celebration-card';
        card.innerHTML = `
            <div class="win-fire-badge" id="win-badge">🔥 VICTORY 🔥</div>
            <h1 class="win-title-flame" id="win-title">BIG WIN!</h1>
            <div class="win-multiplier-pill" id="win-multiplier">x 2.50 MULTIPLIER</div>
            <div class="win-amount-val" id="win-amount">+500.00 BDT</div>
            <button class="win-dismiss-btn" id="win-dismiss-btn" onclick="window.closeWinCelebration()">CONTINUE</button>
        `;
        overlayEl.appendChild(card);
        document.body.appendChild(overlayEl);

        fireSystem = new FireParticleSystem(fireCanvas);
    }

    /**
     * Trigger Fire Motion Graphics Win Celebration
     */
    window.triggerWinCelebration = function(opts) {
        initOverlay();
        if (typeof opts === 'number' || typeof opts === 'string') {
            opts = { amount: opts };
        }
        opts = opts || {};
        const amount = parseFloat(opts.amount || 0);
        const multiplier = parseFloat(opts.multiplier || 0);
        let title = opts.title || '';
        let badge = opts.badge || '🔥 VICTORY 🔥';

        if (!title) {
            if (multiplier >= 20 || amount >= 5000) {
                title = 'JACKPOT WIN!';
                badge = '💥 SUPER MEGA JACKPOT 💥';
            } else if (multiplier >= 10 || amount >= 2000) {
                title = 'MEGA WIN!';
                badge = '⚡ ULTRA PAYOUT ⚡';
            } else if (multiplier >= 3 || amount >= 500) {
                title = 'BIG WIN!';
                badge = '🔥 BIG WINNER 🔥';
            } else {
                title = 'YOU WON!';
                badge = '✨ CONGRATULATIONS ✨';
            }
        }

        const titleEl = document.getElementById('win-title');
        const badgeEl = document.getElementById('win-badge');
        const amountEl = document.getElementById('win-amount');
        const multEl = document.getElementById('win-multiplier');

        if (titleEl) titleEl.innerText = title;
        if (badgeEl) badgeEl.innerText = badge;
        if (amountEl) amountEl.innerText = (amount > 0 ? `+${amount.toFixed(2)}` : 'WINNER!') + ' BDT';
        if (multEl) {
            multEl.style.display = multiplier > 1 ? 'block' : 'none';
            multEl.innerText = `x ${multiplier.toFixed(2)} MULTIPLIER`;
        }

        overlayEl.classList.add('active');
        fireSystem.start();
        playVictoryChime();

        if (autoCloseTimer) clearTimeout(autoCloseTimer);
        const duration = opts.duration || 4500;
        autoCloseTimer = setTimeout(() => {
            window.closeWinCelebration();
        }, duration);
    };

    window.closeWinCelebration = function() {
        if (!overlayEl) return;
        overlayEl.classList.remove('active');
        if (fireSystem) fireSystem.stop();
        if (autoCloseTimer) clearTimeout(autoCloseTimer);
    };

    // Global alias
    window.celebrateWin = window.triggerWinCelebration;

})();
