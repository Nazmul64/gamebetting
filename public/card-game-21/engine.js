/**
 * 1xGames 21 Engine - Scale & Audio Utilities
 */

var Engine = {
  stage: null,
  ctx: null,

  init: function() {
    this.stage = $('#stage');
    this.scale();
    var self = this;
    $(window).on('resize orientationchange', function() {
      self.scale();
    });
    setTimeout(function() { self.scale(); }, 50);
    setTimeout(function() { self.scale(); }, 300);
    setTimeout(function() { self.scale(); }, 1000);
  },

  scale: function() {
    var $wrap = $('#wrap');
    var winW = $wrap.length ? $wrap.width() : $(window).width();
    var winH = $wrap.length ? $wrap.height() : ($(window).height() - 70);

    // Ensure 16px vertical and horizontal breathing room so header and chips are 100% visible
    var targetW = Math.max(300, winW - 16);
    var targetH = Math.max(250, winH - 16);

    var scale = Math.min(targetW / 1200, targetH / 675);
    
    // Smooth responsive scale with centered origin
    $('#stage').css({
      'transform': 'scale(' + scale + ')',
      'transform-origin': 'center center'
    });
  }
};

// Web Audio Synthesizer for rich SFX (card, chip, win, lose)
var SoundFX = {
  ctx: null,
  enabled: true,

  init: function() {
    if (!this.ctx) {
      var AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (AudioCtx) this.ctx = new AudioCtx();
    }
  },

  playCard: function() {
    if (!this.enabled || !this.ctx) return;
    try {
      var osc = this.ctx.createOscillator();
      var gain = this.ctx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(300, this.ctx.currentTime);
      osc.frequency.exponentialRampToValueAtTime(120, this.ctx.currentTime + 0.1);
      gain.gain.setValueAtTime(0.3, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.1);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + 0.1);
    } catch(e){}
  },

  playChip: function() {
    if (!this.enabled || !this.ctx) return;
    try {
      var osc = this.ctx.createOscillator();
      var gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(800, this.ctx.currentTime);
      osc.frequency.exponentialRampToValueAtTime(400, this.ctx.currentTime + 0.05);
      gain.gain.setValueAtTime(0.4, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.05);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + 0.05);
    } catch(e){}
  },

  playWin: function() {
    if (!this.enabled || !this.ctx) return;
    try {
      var now = this.ctx.currentTime;
      [523.25, 659.25, 783.99, 1046.50].forEach(function(freq, i) {
        var osc = SoundFX.ctx.createOscillator();
        var gain = SoundFX.ctx.createGain();
        osc.type = 'triangle';
        osc.frequency.value = freq;
        gain.gain.setValueAtTime(0.2, now + i * 0.1);
        gain.gain.exponentialRampToValueAtTime(0.01, now + i * 0.1 + 0.3);
        osc.connect(gain);
        gain.connect(SoundFX.ctx.destination);
        osc.start(now + i * 0.1);
        osc.stop(now + i * 0.1 + 0.3);
      });
    } catch(e){}
  },

  playLose: function() {
    if (!this.enabled || !this.ctx) return;
    try {
      var now = this.ctx.currentTime;
      [300, 260, 220].forEach(function(freq, i) {
        var osc = SoundFX.ctx.createOscillator();
        var gain = SoundFX.ctx.createGain();
        osc.type = 'sawtooth';
        osc.frequency.value = freq;
        gain.gain.setValueAtTime(0.25, now + i * 0.15);
        gain.gain.exponentialRampToValueAtTime(0.01, now + i * 0.15 + 0.2);
        osc.connect(gain);
        gain.connect(SoundFX.ctx.destination);
        osc.start(now + i * 0.15);
        osc.stop(now + i * 0.15 + 0.2);
      });
    } catch(e){}
  }
};
