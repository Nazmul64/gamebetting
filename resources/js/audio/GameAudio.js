/**
 * GameAudio.js - High performance WebAudio synthesizer & HTML5 Audio Engine
 * Supports custom background music tracks, sound effects, volume control, and synthesized fallback audio.
 */

class GameAudioManager {
    constructor() {
        this.bgmAudio = null;
        this.bgmVolume = parseFloat(localStorage.getItem('game_bgm_volume') || '0.5');
        this.sfxVolume = parseFloat(localStorage.getItem('game_sfx_volume') || '0.8');
        this.isMuted = localStorage.getItem('game_muted') === 'true';
        this.audioCtx = null;
        this.currentBgmUrl = null;
    }

    getAudioContext() {
        if (!this.audioCtx) {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (AudioContext) {
                this.audioCtx = new AudioContext();
            }
        }
        if (this.audioCtx && this.audioCtx.state === 'suspended') {
            this.audioCtx.resume();
        }
        return this.audioCtx;
    }

    // Set or play Background Music
    setBGM(url) {
        if (!url) return;
        if (this.currentBgmUrl === url && this.bgmAudio) {
            if (!this.isMuted && this.bgmAudio.paused) {
                this.bgmAudio.play().catch(() => {});
            }
            return;
        }

        this.stopBGM();
        this.currentBgmUrl = url;
        this.bgmAudio = new Audio(url);
        this.bgmAudio.loop = true;
        this.bgmAudio.volume = this.isMuted ? 0 : this.bgmVolume;

        const playPromise = this.bgmAudio.play();
        if (playPromise !== undefined) {
            playPromise.catch(() => {
                // Auto-play was prevented. Resume on first user interaction.
                const resumeHandler = () => {
                    if (this.bgmAudio && !this.isMuted) {
                        this.bgmAudio.play().catch(() => {});
                    }
                    window.removeEventListener('click', resumeHandler);
                    window.removeEventListener('keydown', resumeHandler);
                };
                window.addEventListener('click', resumeHandler, { once: true });
                window.addEventListener('keydown', resumeHandler, { once: true });
            });
        }
    }

    stopBGM() {
        if (this.bgmAudio) {
            this.bgmAudio.pause();
            this.bgmAudio.currentTime = 0;
            this.bgmAudio = null;
            this.currentBgmUrl = null;
        }
    }

    toggleMute() {
        this.isMuted = !this.isMuted;
        localStorage.setItem('game_muted', this.isMuted ? 'true' : 'false');
        if (this.bgmAudio) {
            this.bgmAudio.volume = this.isMuted ? 0 : this.bgmVolume;
            if (!this.isMuted && this.bgmAudio.paused) {
                this.bgmAudio.play().catch(() => {});
            }
        }
        return this.isMuted;
    }

    setBGMVolume(vol) {
        this.bgmVolume = Math.max(0, Math.min(1, vol));
        localStorage.setItem('game_bgm_volume', this.bgmVolume.toString());
        if (this.bgmAudio && !this.isMuted) {
            this.bgmAudio.volume = this.bgmVolume;
        }
    }

    setSFXVolume(vol) {
        this.sfxVolume = Math.max(0, Math.min(1, vol));
        localStorage.setItem('game_sfx_volume', this.sfxVolume.toString());
    }

    // Play specific sound effect (file URL or synthetic)
    playSFX(sfxTypeOrUrl) {
        if (this.isMuted || this.sfxVolume <= 0) return;

        // If it's a URL ending with audio extension
        if (typeof sfxTypeOrUrl === 'string' && (sfxTypeOrUrl.startsWith('http') || sfxTypeOrUrl.startsWith('/') || sfxTypeOrUrl.includes('.'))) {
            const sfx = new Audio(sfxTypeOrUrl);
            sfx.volume = this.sfxVolume;
            sfx.play().catch(() => {
                this.synthesizeSFX(sfxTypeOrUrl);
            });
            return;
        }

        // Fallback or named synth SFX
        this.synthesizeSFX(sfxTypeOrUrl);
    }

    synthesizeSFX(type) {
        const ctx = this.getAudioContext();
        if (!ctx) return;

        const now = ctx.currentTime;
        const masterGain = ctx.createGain();
        masterGain.gain.setValueAtTime(this.sfxVolume * 0.4, now);
        masterGain.connect(ctx.destination);

        switch (type) {
            case 'spin':
            case 'roll':
            case 'shuffle': {
                // Clicking/ticking spin sound
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(440, now);
                osc.frequency.exponentialRampToValueAtTime(150, now + 0.08);
                gain.gain.setValueAtTime(1, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.08);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.08);
                break;
            }

            case 'deal':
            case 'card':
            case 'flip': {
                // Card flip / swipe swoosh sound
                const bufferSize = ctx.sampleRate * 0.06;
                const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
                const data = buffer.getChannelData(0);
                for (let i = 0; i < bufferSize; i++) {
                    data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (bufferSize * 0.3));
                }
                const noise = ctx.createBufferSource();
                noise.buffer = buffer;
                const filter = ctx.createBiquadFilter();
                filter.type = 'bandpass';
                filter.frequency.setValueAtTime(1200, now);
                noise.connect(filter);
                filter.connect(masterGain);
                noise.start(now);
                break;
            }

            case 'coin':
            case 'bet':
            case 'click': {
                // Crisp coin metallic ding
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(1800, now);
                osc.frequency.exponentialRampToValueAtTime(900, now + 0.12);
                gain.gain.setValueAtTime(1, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.12);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.12);
                break;
            }

            case 'win':
            case 'cashout': {
                // Ascending melodic victory arpeggio
                const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(freq, now + idx * 0.08);
                    gain.gain.setValueAtTime(0, now + idx * 0.08);
                    gain.gain.linearRampToValueAtTime(0.8, now + idx * 0.08 + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.08 + 0.3);
                    osc.connect(gain);
                    gain.connect(masterGain);
                    osc.start(now + idx * 0.08);
                    osc.stop(now + idx * 0.08 + 0.3);
                });
                break;
            }

            case 'bigwin':
            case 'jackpot': {
                // Major fanfare chord
                const chords = [
                    [523.25, 659.25, 783.99],
                    [587.33, 739.99, 880.00],
                    [659.25, 830.61, 987.77],
                    [1046.50, 1318.51, 1567.98]
                ];
                chords.forEach((chord, cIdx) => {
                    chord.forEach((freq) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sawtooth';
                        osc.frequency.setValueAtTime(freq, now + cIdx * 0.15);
                        gain.gain.setValueAtTime(0.3, now + cIdx * 0.15);
                        gain.gain.exponentialRampToValueAtTime(0.01, now + cIdx * 0.15 + 0.4);
                        osc.connect(gain);
                        gain.connect(masterGain);
                        osc.start(now + cIdx * 0.15);
                        osc.stop(now + cIdx * 0.15 + 0.4);
                    });
                });
                break;
            }

            case 'lose':
            case 'error': {
                // Descending low tone
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(250, now);
                osc.frequency.exponentialRampToValueAtTime(80, now + 0.3);
                gain.gain.setValueAtTime(0.7, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.3);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.3);
                break;
            }

            case 'slice': {
                // Sharp blade slash + squash
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(1200, now);
                osc.frequency.exponentialRampToValueAtTime(100, now + 0.12);
                gain.gain.setValueAtTime(0.8, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.12);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.12);
                break;
            }

            case 'splash': {
                // Fluid droplet splash noise
                const bufferSize = ctx.sampleRate * 0.15;
                const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
                const data = buffer.getChannelData(0);
                for (let i = 0; i < bufferSize; i++) {
                    data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (bufferSize * 0.4));
                }
                const noise = ctx.createBufferSource();
                noise.buffer = buffer;
                const filter = ctx.createBiquadFilter();
                filter.type = 'lowpass';
                filter.frequency.setValueAtTime(2400, now);
                filter.frequency.exponentialRampToValueAtTime(400, now + 0.15);
                noise.connect(filter);
                filter.connect(masterGain);
                noise.start(now);
                break;
            }

            case 'candy_pop':
            case 'pop': {
                // High-pitched bright candy pop
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(900, now);
                osc.frequency.exponentialRampToValueAtTime(1400, now + 0.08);
                gain.gain.setValueAtTime(0.9, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.08);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.08);
                break;
            }

            case 'bomb':
            case 'explosion': {
                // Deep bass bomb burst
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(160, now);
                osc.frequency.exponentialRampToValueAtTime(30, now + 0.4);
                gain.gain.setValueAtTime(1.2, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.4);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.4);
                break;
            }

            case 'multiplier': {
                // Rising celestial chime
                const notes = [440, 660, 880, 1320];
                notes.forEach((f, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(f, now + idx * 0.05);
                    gain.gain.setValueAtTime(0.4, now + idx * 0.05);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.05 + 0.25);
                    osc.connect(gain);
                    gain.connect(masterGain);
                    osc.start(now + idx * 0.05);
                    osc.stop(now + idx * 0.05 + 0.25);
                });
                break;
            }

            case 'frenzy': {
                // Fast double chime
                const notes = [600, 900, 1200];
                notes.forEach((f, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(f, now + idx * 0.06);
                    gain.gain.setValueAtTime(0.6, now + idx * 0.06);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.06 + 0.3);
                    osc.connect(gain);
                    gain.connect(masterGain);
                    osc.start(now + idx * 0.06);
                    osc.stop(now + idx * 0.06 + 0.3);
                });
                break;
            }

            default: {
                // Generic pop
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(600, now);
                osc.frequency.exponentialRampToValueAtTime(200, now + 0.05);
                gain.gain.setValueAtTime(0.8, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.05);
                osc.connect(gain);
                gain.connect(masterGain);
                osc.start(now);
                osc.stop(now + 0.05);
            }
        }
    }
}

export const gameAudio = new GameAudioManager();
export default gameAudio;
