// Crystal Audio System - Official 1xBet Audio Sprite & Synthesis Fallback

class AudioManager {
  constructor() {
    this.isMuted = false;
    this.initialized = false;
    this.soundSprite = null;
    this.musicSound = null;
  }

  init() {
    if (this.initialized) return;
    this.initialized = true;

    try {
      if (typeof Howl !== 'undefined') {
        this.soundSprite = new Howl({
          src: [
            '/crystal/assets/audio/sounds.60e5c2da1b24.mp3',
            '/crystal/assets/audio/sounds.a73d7db4ca99.webm'
          ],
          sprite: {
            click: [0, 28.8],
            elem_drop: [2000, 957],
            elem_spin: [4000, 1755],
            elem_spin_reel_stop_0: [7000, 75],
            elem_spin_reel_stop_1: [9000, 75],
            elem_spin_reel_stop_2: [11000, 75],
            elem_vanish_0: [13000, 1723],
            elem_vanish_1: [16000, 1733],
            elem_vanish_2: [19000, 1733],
            win: [22000, 3275],
            win_big: [27000, 3275],
            win_mega: [32000, 3275],
            win_ultra: [37000, 3428]
          },
          volume: 0.85
        });

        this.musicSound = new Howl({
          src: [
            '/crystal/assets/audio/music.1e595ddaf4fb.mp3',
            '/crystal/assets/audio/music.8c81a77ce58f.webm'
          ],
          loop: true,
          volume: 0.35
        });
      }
    } catch (e) {
      console.warn('Howler init warning:', e);
    }
  }

  playClick() {
    if (this.isMuted) return;
    if (this.soundSprite) {
      this.soundSprite.play('click');
    }
  }

  playSpin() {
    if (this.isMuted) return;
    if (this.soundSprite) {
      this.soundSprite.play('elem_spin');
    }
  }

  playDrop() {
    if (this.isMuted) return;
    if (this.soundSprite) {
      this.soundSprite.play('elem_drop');
    }
  }

  playGlassShatter() {
    if (this.isMuted) return;
    if (this.soundSprite) {
      const v = ['elem_vanish_0', 'elem_vanish_1', 'elem_vanish_2'];
      const chosen = v[Math.floor(Math.random() * v.length)];
      this.soundSprite.play(chosen);
    }
  }

  playWinChord(multiplier = 1) {
    if (this.isMuted) return;
    if (this.soundSprite) {
      if (multiplier >= 10) {
        this.soundSprite.play('win_ultra');
      } else if (multiplier >= 5) {
        this.soundSprite.play('win_mega');
      } else if (multiplier >= 2) {
        this.soundSprite.play('win_big');
      } else {
        this.soundSprite.play('win');
      }
    }
  }

  playCoinShower() {
    if (this.isMuted) return;
    if (this.soundSprite) {
      this.soundSprite.play('win_big');
    }
  }

  startMusic() {
    if (this.isMuted || !this.musicSound) return;
    if (!this.musicSound.playing()) {
      this.musicSound.play();
    }
  }

  toggleMute() {
    this.isMuted = !this.isMuted;
    if (this.soundSprite) this.soundSprite.mute(this.isMuted);
    if (this.musicSound) this.musicSound.mute(this.isMuted);
    return this.isMuted;
  }
}

window.audio = new AudioManager();
