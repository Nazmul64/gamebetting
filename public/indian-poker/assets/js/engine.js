/* Indian Poker Engine: Sound Synth, Rose Petals Particle System, Auto-Scaler */
const AudioFX = {
  ctx: null,
  enabled: true,

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
    if (!this.enabled || !this.ctx) return;
    this.playTone(1200, 'triangle', 0.08, 0, 0.2);
    this.playTone(2400, 'sine', 0.05, 0.02, 0.15);
  },

  deal() {
    this.init();
    if (!this.enabled || !this.ctx) return;
    try {
      // Noise buffer for card swoosh
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
    if (!this.enabled || !this.ctx) return;
    this.playTone(600, 'triangle', 0.06, 0, 0.2);
    this.playTone(1800, 'sine', 0.04, 0.01, 0.15);
  },

  win(type) {
    this.init();
    if (!this.enabled || !this.ctx) return;
    if (type === 'three' || type === 'sf') {
      // Grand Fanfare
      const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51, 1567.98];
      notes.forEach((f, i) => {
        this.playTone(f, 'triangle', 0.35, i * 0.09, 0.25);
        this.playTone(f * 1.5, 'sine', 0.4, i * 0.09 + 0.02, 0.12);
      });
    } else {
      // Nice Win
      const notes = [440, 554.37, 659.25, 880];
      notes.forEach((f, i) => {
        this.playTone(f, 'triangle', 0.25, i * 0.08, 0.2);
      });
    }
  },

  lose() {
    this.init();
    if (!this.enabled || !this.ctx) return;
    this.playTone(320, 'sine', 0.18, 0, 0.12);
    this.playTone(260, 'sine', 0.22, 0.1, 0.15);
  }
};

/* Rose Petals and Ambient Sparks Particle System */
class ParticleFX {
  constructor(canvas) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.W = canvas.width;
    this.H = canvas.height;
    this.petals = [];
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

  update(dt) {
    this.petals.forEach(p => {
      p.y += p.vy * dt;
      p.phase += dt * 2;
      p.x += Math.sin(p.phase) * 18 * dt + p.vx * dt;
      p.rotation += p.rotSpeed * dt;

      if (p.y > this.H + 20) {
        Object.assign(p, this.createPetal(false));
      }
    });
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
  }
}

const Engine = {
  canvas: null,
  fx: null,
  lastTime: 0,

  init(canvasId, W = 1024, H = 438) {
    this.canvas = document.getElementById(canvasId);
    this.canvas.width = W;
    this.canvas.height = H;
    this.fx = new ParticleFX(this.canvas);

    const resize = () => {
      const wrap = document.getElementById('wrap') || document.body;
      const availW = wrap.clientWidth || window.innerWidth;
      const availH = wrap.clientHeight || (window.innerHeight - 70);
      const scale = Math.min(availW / W, availH / H);
      const stage = document.getElementById('stage');
      if (stage) {
        stage.style.transform = `scale(${scale})`;
        stage.style.transformOrigin = 'center center';
      }
    };
    window.addEventListener('resize', resize);
    window.addEventListener('orientationchange', resize);
    setTimeout(resize, 50);
    resize();

    this.lastTime = performance.now();
    requestAnimationFrame(this.loop.bind(this));
  },

  loop(currentTime) {
    const dt = Math.min(0.05, (currentTime - this.lastTime) / 1000 || 0);
    this.lastTime = currentTime;

    this.fx.update(dt);
    this.fx.draw(currentTime / 1000);

    requestAnimationFrame(this.loop.bind(this));
  }
};
