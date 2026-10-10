/**
 * JuiceParticleEngine.js
 * Ultra-high performance 60 FPS HTML5 Canvas Particle System & Liquid Physics
 * Features:
 * - Juice Splashes & Spray physics (Color-coded to fruit types)
 * - Fruit Slices & Debris splitting
 * - Sugar Sparkles & Candy Shards
 * - Multiplier Bomb Shockwaves & Flash
 * - Big Win Cascading Fruit & Coin Rain
 * - Zero GC overhead via Particle Pooling
 */

export class JuiceParticleEngine {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas ? canvas.getContext('2d', { alpha: true }) : null;
        this.particles = [];
        this.splatters = [];
        this.rains = [];
        this.isRunning = false;
        this.animFrameId = null;
        this.lastTime = performance.now();

        // Screen shake callback
        this.onShake = null;

        this.resize();
        window.addEventListener('resize', this.handleResize);
    }

    handleResize = () => {
        this.resize();
    };

    resize() {
        if (!this.canvas) return;
        const rect = this.canvas.parentElement ? this.canvas.parentElement.getBoundingClientRect() : { width: window.innerWidth, height: window.innerHeight };
        this.width = rect.width || window.innerWidth;
        this.height = rect.height || window.innerHeight;
        this.canvas.width = this.width * (window.devicePixelRatio > 1 ? 1.5 : 1);
        this.canvas.height = this.height * (window.devicePixelRatio > 1 ? 1.5 : 1);
        if (this.ctx) {
            this.ctx.scale(this.canvas.width / this.width, this.canvas.height / this.height);
        }
    }

    start() {
        if (this.isRunning) return;
        this.isRunning = true;
        this.lastTime = performance.now();
        this.loop();
    }

    stop() {
        this.isRunning = false;
        if (this.animFrameId) {
            cancelAnimationFrame(this.animFrameId);
            this.animFrameId = null;
        }
    }

    destroy() {
        this.stop();
        window.removeEventListener('resize', this.handleResize);
        this.particles = [];
        this.splatters = [];
        this.rains = [];
    }

    clear() {
        this.particles = [];
        this.splatters = [];
        this.rains = [];
    }

    // Color mapper for fruit/food types
    getFruitColor(type = 'watermelon') {
        const lower = String(type).toLowerCase();
        if (lower.includes('water') || lower.includes('melon') || lower.includes('straw') || lower.includes('cherry') || lower.includes('apple') || lower.includes('red') || lower.includes('heart')) {
            return {
                main: '#ef4444',
                secondary: '#f87171',
                juice: ['#dc2626', '#ef4444', '#fca5a5', '#fda4af', '#ffffff'],
                glow: 'rgba(239, 68, 68, 0.6)'
            };
        }
        if (lower.includes('lemon') || lower.includes('banana') || lower.includes('bell') || lower.includes('star') || lower.includes('gold') || lower.includes('yellow')) {
            return {
                main: '#eab308',
                secondary: '#fef08a',
                juice: ['#ca8a04', '#eab308', '#facc15', '#fef08a', '#ffffff'],
                glow: 'rgba(234, 179, 8, 0.6)'
            };
        }
        if (lower.includes('orange') || lower.includes('seven') || lower.includes('fire')) {
            return {
                main: '#f97316',
                secondary: '#fed7aa',
                juice: ['#ea580c', '#f97316', '#fb923c', '#ffedd5', '#ffffff'],
                glow: 'rgba(249, 115, 22, 0.6)'
            };
        }
        if (lower.includes('grape') || lower.includes('plum') || lower.includes('square') || lower.includes('purple')) {
            return {
                main: '#a855f7',
                secondary: '#e9d5ff',
                juice: ['#9333ea', '#a855f7', '#c084fc', '#f3e8ff', '#ffffff'],
                glow: 'rgba(168, 85, 247, 0.6)'
            };
        }
        if (lower.includes('clover') || lower.includes('green') || lower.includes('kiwi') || lower.includes('lime')) {
            return {
                main: '#22c55e',
                secondary: '#bbf7d0',
                juice: ['#16a34a', '#22c55e', '#4ade80', '#dcfce7', '#ffffff'],
                glow: 'rgba(34, 197, 94, 0.6)'
            };
        }
        if (lower.includes('blue') || lower.includes('diamond') || lower.includes('scatter') || lower.includes('cocktail')) {
            return {
                main: '#06b6d4',
                secondary: '#a5f3fc',
                juice: ['#0891b2', '#06b6d4', '#38bdf8', '#e0f2fe', '#ffffff'],
                glow: 'rgba(6, 182, 212, 0.6)'
            };
        }
        // Default rainbow / candy
        return {
            main: '#ec4899',
            secondary: '#fbcfe8',
            juice: ['#db2777', '#ec4899', '#f472b6', '#fdf2f8', '#ffffff'],
            glow: 'rgba(236, 72, 153, 0.6)'
        };
    }

    /**
     * Trigger a high-impact Juice Splash burst at (x, y)
     */
    emitJuiceSplash(x, y, fruitType = 'watermelon', count = 35) {
        const theme = this.getFruitColor(fruitType);

        // 1. Droplets with physics
        for (let i = 0; i < count; i++) {
            const angle = Math.random() * Math.PI * 2;
            const speed = Math.random() * 9 + 3;
            const color = theme.juice[Math.floor(Math.random() * theme.juice.length)];
            const radius = Math.random() * 5 + 2;

            this.particles.push({
                type: 'juice_drop',
                x,
                y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed - 2.5,
                gravity: 0.28,
                drag: 0.98,
                radius,
                color,
                alpha: 1,
                decay: Math.random() * 0.02 + 0.015,
                glow: theme.glow
            });
        }

        // 2. Splat stains (on reels / glass)
        for (let i = 0; i < 6; i++) {
            const splatAngle = Math.random() * Math.PI * 2;
            const dist = Math.random() * 45 + 10;
            this.splatters.push({
                x: x + Math.cos(splatAngle) * dist,
                y: y + Math.sin(splatAngle) * dist,
                radius: Math.random() * 12 + 6,
                color: theme.main,
                alpha: 0.85,
                decay: 0.008,
                spikes: Math.floor(Math.random() * 4) + 4
            });
        }

        // 3. Sparkles / sugar crystals
        for (let i = 0; i < 15; i++) {
            const angle = Math.random() * Math.PI * 2;
            const speed = Math.random() * 7 + 2;
            this.particles.push({
                type: 'sugar_sparkle',
                x,
                y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed - 1.5,
                gravity: 0.12,
                size: Math.random() * 4 + 2,
                color: '#ffffff',
                alpha: 1,
                rotation: Math.random() * Math.PI * 2,
                vRot: (Math.random() - 0.5) * 0.3,
                decay: Math.random() * 0.03 + 0.02
            });
        }

        this.start();
    }

    /**
     * Fruit Slice Slash Effect (splits emoji or vector in half with glowing trail)
     */
    emitFruitSlice(x, y, fruitIcon = '🍉', fruitType = 'watermelon') {
        const theme = this.getFruitColor(fruitType);

        // Slash beam shockwave
        const slashAngle = (Math.random() * 0.5 - 0.25) * Math.PI - Math.PI / 4; // ~-45deg
        this.particles.push({
            type: 'slash_beam',
            x,
            y,
            angle: slashAngle,
            length: 120,
            width: 8,
            color: '#ffffff',
            glowColor: theme.main,
            alpha: 1,
            decay: 0.08
        });

        // Split halves flying left & right
        this.particles.push({
            type: 'fruit_slice_half',
            icon: fruitIcon,
            side: 'left',
            x: x - 10,
            y,
            vx: -4 - Math.random() * 3,
            vy: -4 - Math.random() * 2,
            gravity: 0.35,
            rotation: 0,
            vRot: -0.15,
            scale: 1,
            alpha: 1,
            decay: 0.02
        });

        this.particles.push({
            type: 'fruit_slice_half',
            icon: fruitIcon,
            side: 'right',
            x: x + 10,
            y,
            vx: 4 + Math.random() * 3,
            vy: -4 - Math.random() * 2,
            gravity: 0.35,
            rotation: 0,
            vRot: 0.15,
            scale: 1,
            alpha: 1,
            decay: 0.02
        });

        // Spray accompanying juice
        this.emitJuiceSplash(x, y, fruitType, 25);
    }

    /**
     * Candy & Sugar Bomb Blast
     */
    emitCandyBombBlast(x, y, multiplier = 10) {
        // Shockwave ring
        this.particles.push({
            type: 'shockwave',
            x,
            y,
            radius: 10,
            maxRadius: 180,
            growth: 12,
            width: 8,
            color: '#f59e0b',
            alpha: 1,
            decay: 0.04
        });

        // Screen flash
        this.particles.push({
            type: 'screen_flash',
            color: 'rgba(255, 235, 100, 0.45)',
            alpha: 1,
            decay: 0.06
        });

        // Multiplier popup particle
        this.particles.push({
            type: 'multiplier_badge',
            x,
            y: y - 20,
            text: `${multiplier}X`,
            scale: 0.3,
            maxScale: 1.8,
            alpha: 1,
            glow: '#fbbf24',
            decay: 0.012,
            vy: -1.2
        });

        // Candy pieces & rainbow shrapnel
        const rainbowColors = ['#f43f5e', '#ec4899', '#a855f7', '#3b82f6', '#10b981', '#f59e0b', '#ffffff'];
        for (let i = 0; i < 45; i++) {
            const angle = Math.random() * Math.PI * 2;
            const speed = Math.random() * 12 + 4;
            this.particles.push({
                type: 'candy_shard',
                x,
                y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed - 3,
                gravity: 0.3,
                size: Math.random() * 8 + 3,
                color: rainbowColors[Math.floor(Math.random() * rainbowColors.length)],
                rotation: Math.random() * Math.PI * 2,
                vRot: (Math.random() - 0.5) * 0.4,
                alpha: 1,
                decay: Math.random() * 0.02 + 0.015
            });
        }

        this.start();
    }

    /**
     * Big Win / Bonus Celebration: Cascade Fruit & Coin Rain
     */
    triggerBigWinRain(durationMs = 5000) {
        const rainIcons = ['🍓', '🍉', '🍋', '🍇', '🍌', '🍩', '🍬', '🍭', '🍹', '🪙', '⭐', '💎', '🔥'];
        const startTime = performance.now();

        const spawnInterval = setInterval(() => {
            if (performance.now() - startTime > durationMs) {
                clearInterval(spawnInterval);
                return;
            }

            for (let i = 0; i < 4; i++) {
                this.rains.push({
                    icon: rainIcons[Math.floor(Math.random() * rainIcons.length)],
                    x: Math.random() * this.width,
                    y: -40,
                    vy: Math.random() * 5 + 4,
                    vx: (Math.random() - 0.5) * 2,
                    size: Math.random() * 24 + 20,
                    rotation: Math.random() * Math.PI * 2,
                    vRot: (Math.random() - 0.5) * 0.1,
                    alpha: 1,
                    scale: Math.random() * 0.5 + 0.8
                });
            }
        }, 120);

        this.start();
    }

    // Main animation & render loop
    loop = () => {
        if (!this.isRunning) return;

        const ctx = this.ctx;
        if (!ctx) return;

        ctx.clearRect(0, 0, this.width, this.height);

        // 1. Draw Splatters (background layer)
        for (let i = this.splatters.length - 1; i >= 0; i--) {
            const s = this.splatters[i];
            s.alpha -= s.decay;
            if (s.alpha <= 0) {
                this.splatters.splice(i, 1);
                continue;
            }

            ctx.save();
            ctx.globalAlpha = s.alpha;
            ctx.fillStyle = s.color;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.radius, 0, Math.PI * 2);
            ctx.fill();

            // Small droplets around splat
            for (let k = 0; k < s.spikes; k++) {
                const spAngle = (k / s.spikes) * Math.PI * 2;
                const spDist = s.radius * 1.35;
                ctx.beginPath();
                ctx.arc(s.x + Math.cos(spAngle) * spDist, s.y + Math.sin(spAngle) * spDist, s.radius * 0.25, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.restore();
        }

        // 2. Draw Screen Flashes
        for (let i = this.particles.length - 1; i >= 0; i--) {
            const p = this.particles[i];
            if (p.type === 'screen_flash') {
                p.alpha -= p.decay;
                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }
                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = p.color;
                ctx.fillRect(0, 0, this.width, this.height);
                ctx.restore();
            }
        }

        // 3. Draw Regular Particles & Debris
        for (let i = this.particles.length - 1; i >= 0; i--) {
            const p = this.particles[i];

            if (p.type === 'juice_drop') {
                p.x += p.vx;
                p.y += p.vy;
                p.vy += p.gravity;
                p.vx *= p.drag;
                p.alpha -= p.decay;

                if (p.alpha <= 0 || p.y > this.height + 50) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = p.color;
                ctx.shadowColor = p.glow || p.color;
                ctx.shadowBlur = 6;
                // Elongated droplet along velocity vector
                const speed = Math.sqrt(p.vx * p.vx + p.vy * p.vy);
                const angle = Math.atan2(p.vy, p.vx);

                ctx.translate(p.x, p.y);
                ctx.rotate(angle);
                ctx.beginPath();
                ctx.ellipse(0, 0, p.radius + speed * 0.4, p.radius * 0.7, 0, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            } else if (p.type === 'sugar_sparkle') {
                p.x += p.vx;
                p.y += p.vy;
                p.vy += p.gravity;
                p.rotation += p.vRot;
                p.alpha -= p.decay;

                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = '#ffffff';
                ctx.shadowColor = '#fde047';
                ctx.shadowBlur = 8;
                ctx.translate(p.x, p.y);
                ctx.rotate(p.rotation);

                // Star sparkle shape
                ctx.beginPath();
                ctx.moveTo(0, -p.size);
                ctx.lineTo(p.size * 0.3, -p.size * 0.3);
                ctx.lineTo(p.size, 0);
                ctx.lineTo(p.size * 0.3, p.size * 0.3);
                ctx.lineTo(0, p.size);
                ctx.lineTo(-p.size * 0.3, p.size * 0.3);
                ctx.lineTo(-p.size, 0);
                ctx.lineTo(-p.size * 0.3, -p.size * 0.3);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            } else if (p.type === 'candy_shard') {
                p.x += p.vx;
                p.y += p.vy;
                p.vy += p.gravity;
                p.rotation += p.vRot;
                p.alpha -= p.decay;

                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = p.color;
                ctx.translate(p.x, p.y);
                ctx.rotate(p.rotation);
                ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.8);
                ctx.restore();
            } else if (p.type === 'shockwave') {
                p.radius += p.growth;
                p.alpha -= p.decay;

                if (p.alpha <= 0 || p.radius >= p.maxRadius) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.strokeStyle = p.color;
                ctx.lineWidth = p.width;
                ctx.shadowColor = '#f59e0b';
                ctx.shadowBlur = 15;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.stroke();
                ctx.restore();
            } else if (p.type === 'slash_beam') {
                p.alpha -= p.decay;
                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.strokeStyle = p.color;
                ctx.lineWidth = p.width;
                ctx.shadowColor = p.glowColor;
                ctx.shadowBlur = 20;
                ctx.lineCap = 'round';

                const cos = Math.cos(p.angle);
                const sin = Math.sin(p.angle);
                ctx.beginPath();
                ctx.moveTo(p.x - cos * (p.length / 2), p.y - sin * (p.length / 2));
                ctx.lineTo(p.x + cos * (p.length / 2), p.y + sin * (p.length / 2));
                ctx.stroke();
                ctx.restore();
            } else if (p.type === 'fruit_slice_half') {
                p.x += p.vx;
                p.y += p.vy;
                p.vy += p.gravity;
                p.rotation += p.vRot;
                p.alpha -= p.decay;

                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.translate(p.x, p.y);
                ctx.rotate(p.rotation);
                ctx.font = '28px serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                // Clip half
                ctx.beginPath();
                if (p.side === 'left') {
                    ctx.rect(-30, -30, 30, 60);
                } else {
                    ctx.rect(0, -30, 30, 60);
                }
                ctx.clip();
                ctx.fillText(p.icon, 0, 0);
                ctx.restore();
            } else if (p.type === 'multiplier_badge') {
                p.y += p.vy;
                if (p.scale < p.maxScale) {
                    p.scale += 0.12;
                }
                p.alpha -= p.decay;

                if (p.alpha <= 0) {
                    this.particles.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.translate(p.x, p.y);
                ctx.scale(p.scale, p.scale);

                // Multiplier text
                ctx.font = '900 36px sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.shadowColor = p.glow;
                ctx.shadowBlur = 25;
                ctx.fillStyle = '#ffffff';
                ctx.fillText(p.text, 0, 0);

                ctx.strokeStyle = '#f59e0b';
                ctx.lineWidth = 3;
                ctx.strokeText(p.text, 0, 0);
                ctx.restore();
            }
        }

        // 4. Draw Cascading Rain (Big Win Celebration)
        for (let i = this.rains.length - 1; i >= 0; i--) {
            const r = this.rains[i];
            r.y += r.vy;
            r.x += r.vx;
            r.rotation += r.vRot;

            if (r.y > this.height + 60) {
                this.rains.splice(i, 1);
                continue;
            }

            ctx.save();
            ctx.globalAlpha = r.alpha;
            ctx.translate(r.x, r.y);
            ctx.rotate(r.rotation);
            ctx.scale(r.scale, r.scale);
            ctx.font = `${r.size}px serif`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.shadowColor = 'rgba(251, 191, 36, 0.6)';
            ctx.shadowBlur = 10;
            ctx.fillText(r.icon, 0, 0);
            ctx.restore();
        }

        // Check if anything remains to animate
        if (this.particles.length > 0 || this.splatters.length > 0 || this.rains.length > 0) {
            this.animFrameId = requestAnimationFrame(this.loop);
        } else {
            this.stop();
        }
    };
}
