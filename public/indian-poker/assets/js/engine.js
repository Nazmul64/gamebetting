/* Indian Poker Engine: Sound Synth & Real Audio Player, Rose Petals & Gold Coins Particle System, Auto-Scaler */
const AudioFX = {
  ctx: null,
  enabled: true,
  audioElements: {},

  init() {
    if (!this.ctx) {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      if (AudioContext) {
        this.ctx = new AudioContext();
      }
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
    }

    const basePath = (window.INDIAN_POKER_BASE || '/indian-poker/') + 'assets/audio/';
    const files = {
      chip_place: 'chip_place.mp3',
      card_swoosh: 'card_swoosh.mp3',
      lose_tone: 'lose_tone.mp3',
      win_bell: 'win_bell.mp3',
      coin_drop: 'coin_drop.mp3'
    };

    for (const [key, name] of Object.entries(files)) {
      if (!this.audioElements[key]) {
        try {
          const a = new Audio(basePath + name);
          a.preload = 'auto';
          this.audioElements[key] = a;
        } catch(e) {}
      }
    }
  },

  playFile(key) {
    if (!this.enabled) return false;
    this.init();
    try {
      const a = this.audioElements[key];
      if (a) {
        a.currentTime = 0;
        const p = a.play();
        if (p && p.catch) p.catch(() => {});
        return true;
      }
    } catch(e) {}
    return false;
  },

  playTone(freq, type, duration, delay = 0, gainVal = 0.15) {
    if (!this.enabled || !this.ctx) return;
    try {
      setTimeout(() => {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
        gain.gain.setValueAtTime(gainVal, this.ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + duration);
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start();
        osc.stop(this.ctx.currentTime + duration);
      }, delay * 1000);
    } catch(e) {}
  },

  chip() {
    this.init();
    if (!this.enabled) return;
    this.playFile('chip_place');
    this.playTone(1200, 'triangle', 0.08, 0, 0.2);
    this.playTone(2400, 'sine', 0.05, 0.02, 0.15);
  },

  deal() {
    this.init();
    if (!this.enabled) return;
    this.playFile('card_swoosh');
    try {
      const bufferSize = this.ctx.sampleRate * 0.12;
      const buffer = this.ctx.createBuffer(1, bufferSize, this.ctx.sampleRate);
      const data = buffer.getChannelData(0);
      for (let i = 0; i < bufferSize; i++) {
        data[i] = Math.random() * 2 - 1;
      }
      const noise = this.ctx.createBufferSource();
      noise.buffer = buffer;

      const filter = this.ctx.createBiquadFilter();
      filter.type = 'bandpass';
      filter.frequency.setValueAtTime(900, this.ctx.currentTime);
      filter.frequency.exponentialRampToValueAtTime(300, this.ctx.currentTime + 0.12);

      const gain = this.ctx.createGain();
      gain.gain.setValueAtTime(0.3, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.12);

      noise.connect(filter);
      filter.connect(gain);
      gain.connect(this.ctx.destination);
      noise.start();
    } catch(e) {
      this.playTone(400, 'sine', 0.1, 0, 0.1);
    }
  },

  flip() {
    this.init();
    if (!this.enabled) return;
    this.playTone(600, 'triangle', 0.06, 0, 0.2);
    this.playTone(1800, 'sine', 0.04, 0.01, 0.15);
  },

  win(type) {
    this.init();
    if (!this.enabled) return;
    this.playFile('win_bell');
    setTimeout(() => {
      this.playFile('coin_drop');
    }, 280);

    if (type === 'three' || type === 'sf') {
      const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51, 1567.98];
      notes.forEach((f, i) => {
        this.playTone(f, 'triangle', 0.35, i * 0.09, 0.25);
        this.playTone(f * 1.5, 'sine', 0.4, i * 0.09 + 0.02, 0.12);
      });
    } else {
      const notes = [440, 554.37, 659.25, 880];
      notes.forEach((f, i) => {
        this.playTone(f, 'triangle', 0.25, i * 0.08, 0.2);
      });
    }
  },

  lose() {
    this.init();
    if (!this.enabled) return;
    this.playFile('lose_tone');
    this.playTone(320, 'sine', 0.18, 0, 0.12);
    this.playTone(260, 'sine', 0.22, 0.1, 0.15);
  }
};

/* Rose Petals & Gold Coin Particle System */
class ParticleFX {
  constructor(canvas) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.W = canvas.width;
    this.H = canvas.height;
    this.petals = [];
    this.coins = [];
    this.lanterns = [
      { x: 310, y: 80, color: '#38bdf8' },
      { x: 730, y: 90, color: '#38bdf8' }
    ];

    for (let i = 0; i < 35; i++) {
      this.petals.push(this.createPetal(true));
    }
  }

  createPetal(randomY = false) {
    return {
      x: Math.random() * this.W,
      y: randomY ? Math.random() * this.H : -15,
      size: 4 + Math.random() * 6,
      vx: (Math.random() - 0.4) * 15,
      vy: 20 + Math.random() * 30,
      rotation: Math.random() * Math.PI * 2,
      rotSpeed: (Math.random() - 0.5) * 2,
      phase: Math.random() * Math.PI * 2,
      color: Math.random() > 0.3 ? 'rgba(215, 25, 60, 0.75)' : 'rgba(240, 70, 100, 0.85)'
    };
  }

  explodeCoins(originX = 512, originY = 200, count = 50) {
    for (let i = 0; i < count; i++) {
      const angle = Math.random() * Math.PI * 2;
      const speed = 70 + Math.random() * 260;
      this.coins.push({
        x: originX,
        y: originY,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed - 60,
        gravity: 340 + Math.random() * 80,
        size: 5 + Math.random() * 5,
        rotation: Math.random() * Math.PI * 2,
        rotSpeed: (Math.random() - 0.5) * 12,
        scaleX: 1,
        life: 1.0,
        maxLife: 1.2 + Math.random() * 0.8,
        color: Math.random() > 0.4 ? '#ffd700' : '#f59e0b'
      });
    }
  }

  update(dt) {
    // Petals
    this.petals.forEach(p => {
      p.y += p.vy * dt;
      p.phase += dt * 2;
      p.x += Math.sin(p.phase) * 18 * dt + p.vx * dt;
      p.rotation += p.rotSpeed * dt;

      if (p.y > this.H + 20) {
        Object.assign(p, this.createPetal(false));
      }
    });

    // Coins explosion
    for (let i = this.coins.length - 1; i >= 0; i--) {
      const c = this.coins[i];
      c.vy += c.gravity * dt;
      c.x += c.vx * dt;
      c.y += c.vy * dt;
      c.rotation += c.rotSpeed * dt;
      c.scaleX = Math.abs(Math.cos(c.rotation));
      c.life -= dt / c.maxLife;

      if (c.life <= 0 || c.y > this.H + 30) {
        this.coins.splice(i, 1);
      }
    }
  }

  draw(t) {
    this.ctx.clearRect(0, 0, this.W, this.H);

    // Lantern subtle ambient glow pulsing
    this.lanterns.forEach((l, idx) => {
      const pulse = 0.5 + 0.3 * Math.sin(t * 3 + idx * 2);
      const radGrad = this.ctx.createRadialGradient(l.x, l.y, 2, l.x, l.y, 35);
      radGrad.addColorStop(0, `rgba(56, 189, 248, ${0.4 * pulse})`);
      radGrad.addColorStop(1, 'rgba(56, 189, 248, 0)');
      this.ctx.fillStyle = radGrad;
      this.ctx.beginPath();
      this.ctx.arc(l.x, l.y, 35, 0, Math.PI * 2);
      this.ctx.fill();
    });

    // Draw floating rose petals
    this.petals.forEach(p => {
      this.ctx.save();
      this.ctx.translate(p.x, p.y);
      this.ctx.rotate(p.rotation);
      this.ctx.fillStyle = p.color;
      this.ctx.beginPath();
      this.ctx.ellipse(0, 0, p.size, p.size * 0.55, 0, 0, Math.PI * 2);
      this.ctx.fill();
      this.ctx.restore();
    });

    // Draw exploding gold coins & sparkles
    this.coins.forEach(c => {
      this.ctx.save();
      this.ctx.globalAlpha = Math.max(0, Math.min(1, c.life));
      this.ctx.translate(c.x, c.y);
      this.ctx.scale(c.scaleX, 1);
      this.ctx.rotate(c.rotation);

      // Gold coin
      this.ctx.fillStyle = c.color;
      this.ctx.beginPath();
      this.ctx.arc(0, 0, c.size, 0, Math.PI * 2);
      this.ctx.fill();

      // Coin inner rim
      this.ctx.lineWidth = 1.2;
      this.ctx.strokeStyle = '#fff5a0';
      this.ctx.stroke();

      this.ctx.restore();
    });
  }
}

const Engine = {
  canvas: null,
  fx: null,
  lastTime: 0,

  explodeCoins(x = 512, y = 200) {
    if (this.fx) {
      this.fx.explodeCoins(x, y, 60);
    }
  },

  scale() {
    const wrap = document.getElementById('wrap') || document.body;
    const stage = document.getElementById('stage');
    if (!stage || !wrap) return;

    const W = 1024;
    const H = 438;
    const availW = wrap.clientWidth || window.innerWidth;
    const isMobile = window.innerWidth <= 768;
    const headerOffset = isMobile ? 54 : 70;
    const availH = wrap.clientHeight || (window.innerHeight - headerOffset);

    const padX = isMobile ? 6 : 14;
    const padY = isMobile ? 6 : 14;

    const scaleX = (availW - padX) / W;
    const scaleY = (availH - padY) / H;
    const scale = Math.max(0.25, Math.min(1.25, Math.min(scaleX, scaleY)));

    stage.style.transform = `scale(${scale})`;
    stage.style.webkitTransform = `scale(${scale})`;
  },

  loop(timestamp) {
    if (!Engine.lastTime) Engine.lastTime = timestamp;
    const dt = Math.min(0.1, (timestamp - Engine.lastTime) / 1000);
    Engine.lastTime = timestamp;

    if (Engine.fx) {
      Engine.fx.update(dt);
      Engine.fx.draw(timestamp / 1000);
    }

    requestAnimationFrame(Engine.loop);
  },

  init(canvasId = 'fx', width = 1024, height = 438) {
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) return;

    this.canvas.width = width;
    this.canvas.height = height;

    this.fx = new ParticleFX(this.canvas);
    this.scale();

    window.addEventListener('resize', () => this.scale(), { passive: true });
    window.addEventListener('orientationchange', () => this.scale(), { passive: true });

    AudioFX.init();
    requestAnimationFrame(this.loop);
  }
};
