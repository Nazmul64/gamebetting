/**
 * 1xGames 21 Game Engine & Gameplay Logic
 */

var Game = {
  bal: 1000.00,
  bet: 20,
  state: 'idle', // 'idle', 'dealing', 'play', 'dealer', 'over'
  deck: [],
  dealerHand: [],
  playerHand: [],
  wins: 0,
  losses: 0,
  draws: 0,
  autoPlay: false,
  sound: true,

  jackpot: {
    hourly: 95934,
    daily: 1619598,
    weekly: 4666856,
    monthly: 86925257
  },

  ranks: ['6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'],
  suits: ['D', 'S', 'H', 'C'],

  rankMap: {
    '6': { val: 6, col: 0 },
    '7': { val: 7, col: 1 },
    '8': { val: 8, col: 2 },
    '9': { val: 9, col: 3 },
    '10': { val: 10, col: 4 },
    'J': { val: 2, col: 5 },
    'Q': { val: 3, col: 6 },
    'K': { val: 4, col: 7 },
    'A': { val: 11, col: 8 }
  },

  suitMap: {
    'S': 0,
    'H': 1,
    'C': 2,
    'D': 3
  },

  init: function() {
    Engine.init();
    this.bindEvents();
    this.updateUI();
    this.setMode('bet');
    this.renderJackpotDigits();
    this.initJackpotTimer();
  },

  renderJackpotDigits: function() {
    function renderNum(val, $container) {
      $container.empty();
      var str = val.toString();
      for (var i = 0; i < str.length; i++) {
        var digit = parseInt(str[i], 10);
        var posY = -(digit * 21); // 21px height per digit in 14x210px sprite
        var $box = $('<div class="jp-digit-box"></div>');
        var $num = $('<div class="jp-digit-num"></div>').css('background-position', '0px ' + posY + 'px');
        $box.append($num);
        $container.append($box);
      }
    }

    renderNum(this.jackpot.hourly, $('#jp-hourly-digits'));
    renderNum(this.jackpot.daily, $('#jp-daily-digits'));
    renderNum(this.jackpot.weekly, $('#jp-weekly-digits'));
    renderNum(this.jackpot.monthly, $('#jp-monthly-digits'));
  },

  initJackpotTimer: function() {
    var self = this;
    setInterval(function() {
      self.jackpot.hourly += Math.floor(Math.random() * 3) + 1;
      self.jackpot.daily += Math.floor(Math.random() * 5) + 2;
      self.jackpot.weekly += Math.floor(Math.random() * 12) + 5;
      self.jackpot.monthly += Math.floor(Math.random() * 25) + 10;
      self.renderJackpotDigits();
    }, 3000);
  },

  bindEvents: function() {
    var self = this;

    // Click anywhere to init audio context
    $(document).one('click', function() {
      SoundFX.init();
    });

    // Toggle Jackpot dropdown on click
    $('#jackpot-box').on('click', function(e) {
      e.stopPropagation();
      $('#jackpot-dropdown').toggleClass('active');
    });

    $(document).on('click', function(e) {
      if (!$(e.target).closest('#jackpot-wrapper').length) {
        $('#jackpot-dropdown').removeClass('active');
      }
    });

    // Main action button (PLACE A BET / HIT)
    $('#main-action-btn').on('click', function() {
      if (self.state === 'idle') {
        self.startRound();
      } else if (self.state === 'play') {
        self.hit();
      }
    });

    // Sub action button (AUTOPLAY / STAND)
    $('#sub-action-btn').on('click', function() {
      if (self.state === 'play') {
        self.stand();
      } else if (self.state === 'idle') {
        self.autoPlay = !self.autoPlay;
        if (self.autoPlay) {
          self.startRound();
        }
      }
    });

    // Bet preset chips
    $('.preset-chip-btn').on('click', function() {
      if (self.state === 'idle') {
        var v = parseInt($(this).attr('data-val'), 10);
        self.bet = v;
        SoundFX.playChip();
        self.updateUI();
      }
    });

    // Clear bet button
    $('#bet-clear-btn').on('click', function() {
      if (self.state === 'idle') {
        self.bet = 20;
        SoundFX.playChip();
        self.updateUI();
      }
    });

    // Sound toggle button
    $('#btn-sound').on('click', function() {
      self.sound = !self.sound;
      SoundFX.enabled = self.sound;
      $(this).text(self.sound ? '🔊' : '🔇');
    });

    // Click overlay to skip result delay
    $('#result-banner-overlay').on('click', function() {
      if (self.state === 'over') {
        self.resetToBetMode();
      }
    });
  },

  shuffleDeck: function() {
    this.deck = [];
    var self = this;
    this.suits.forEach(function(s) {
      self.ranks.forEach(function(r) {
        self.deck.push({ rank: r, suit: s, id: r + s });
      });
    });

    // Fisher-Yates shuffle
    for (var i = this.deck.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var temp = this.deck[i];
      this.deck[i] = this.deck[j];
      this.deck[j] = temp;
    }
  },

  calcScore: function(hand) {
    if (!hand || hand.length === 0) return 0;

    // Special rule: Golden Point (Two Aces = 21)
    if (hand.length === 2 && hand[0].rank === 'A' && hand[1].rank === 'A') {
      return 21;
    }

    var total = 0;
    var aces = 0;

    hand.forEach(function(c) {
      if (c.rank === 'A') {
        aces++;
        total += 11;
      } else {
        total += Game.rankMap[c.rank].val;
      }
    });

    while (total > 21 && aces > 0) {
      total -= 10;
      aces--;
    }

    return total;
  },

  updateUI: function() {
    $('#bet-val-text').text(this.bet);
    $('#stat-wins').text(this.wins);
    $('#stat-losses').text(this.losses);
    $('#stat-draws').text(this.draws);

    $('#dealer-score').text(this.calcScore(this.dealerHand));
    $('#player-score').text(this.calcScore(this.playerHand));
  },

  setMode: function(mode) {
    var $main = $('#main-action-btn');
    var $sub = $('#sub-action-btn');

    if (mode === 'bet') {
      $main.removeClass('hit-mode').addClass('bet-mode').prop('disabled', false);
      $main.find('.main-btn-text').text('PLACE A BET');
      $sub.removeClass('stand-mode').addClass('autoplay-mode').prop('disabled', false);
      $sub.find('.sub-btn-text').text(this.autoPlay ? 'STOP AUTO' : 'AUTOPLAY');
      $('.preset-chip-btn, #bet-clear-btn').prop('disabled', false);
      $('#top-banner-pill').text('PLACE A BET');
      $('#result-banner-overlay').addClass('hidden');
    } else if (mode === 'play') {
      $main.removeClass('bet-mode').addClass('hit-mode').prop('disabled', false);
      $main.find('.main-btn-text').text('HIT');
      $sub.removeClass('autoplay-mode').addClass('stand-mode').prop('disabled', false);
      $sub.find('.sub-btn-text').text('STAND');
      $('.preset-chip-btn, #bet-clear-btn').prop('disabled', true);
      $('#top-banner-pill').text('CHOOSE WHAT YOU WANT TO DO');
      $('#result-banner-overlay').addClass('hidden');
    }
  },

  createCardElem: function(card) {
    var col = this.rankMap[card.rank].col;
    var row = this.suitMap[card.suit];

    var posX = -(col * 92);
    var posY = -(row * 137);

    var $card = $('<div class="playing-card"></div>').css({
      'background-position': posX + 'px ' + posY + 'px'
    });

    return $card;
  },

  currentBetId: null,
  remainingDeck: [],

  fetchState: function() {
    var self = this;
    $.getJSON('/games/card-games-21/state', function(res) {
      if (res && res.success) {
        if (res.user_balance !== null && typeof res.user_balance === 'number') {
          self.bal = res.user_balance;
        }
        self.updateUI();
      }
    });
  },

  startRound: function() {
    if (this.state !== 'idle') return;

    var self = this;
    this.state = 'dealing';
    var isDemo = !window.IS_AUTH;

    $('#main-action-btn, #sub-action-btn').prop('disabled', true);
    $('#dealer-cards, #player-cards').empty();
    $('#result-banner-overlay').addClass('hidden');

    $.ajax({
      url: '/games/card-games-21/deal',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.CSRF_TOKEN || $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        amount: self.bet,
        is_demo: isDemo ? 1 : 0
      },
      success: function(res) {
        if (!res || !res.success) {
          alert(res?.error || 'Deal failed. Please try again.');
          self.state = 'idle';
          self.setMode('bet');
          return;
        }

        self.currentBetId = res.bet_id;
        self.remainingDeck = res.remaining_deck || [];
        self.dealerHand = [];
        self.playerHand = [];

        var pCards = (res.player_cards || []).map(function(id) {
          return { rank: id.slice(0, -1), suit: id.slice(-1), id: id };
        });
        var dCards = (res.dealer_cards || []).map(function(id) {
          return { rank: id.slice(0, -1), suit: id.slice(-1), id: id };
        });

        // Animated dealing sequence
        var dealSeq = [
          { target: 'player', card: pCards[0], delay: 100 },
          { target: 'dealer', card: dCards[0], delay: 400 },
          { target: 'player', card: pCards[1], delay: 700 }
        ];

        dealSeq.forEach(function(step) {
          setTimeout(function() {
            if (step.target === 'player' && step.card) {
              self.playerHand.push(step.card);
              var $c = self.createCardElem(step.card);
              $('#player-cards').append($c);
            } else if (step.target === 'dealer' && step.card) {
              self.dealerHand.push(step.card);
              var $c = self.createCardElem(step.card);
              $('#dealer-cards').append($c);
            }
            SoundFX.playCard();
            self.updateUI();
          }, step.delay);
        });

        setTimeout(function() {
          if (res.status === 'won') {
            self.finishRound('win', res.message || 'Golden 21! Instant Win');
          } else {
            self.state = 'play';
            self.setMode('play');
            if (self.autoPlay) {
              self.autoStep();
            }
          }
        }, 1100);
      },
      error: function(xhr) {
        var err = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Error dealing cards.';
        alert(err);
        self.state = 'idle';
        self.setMode('bet');
      }
    });
  },

  hit: function() {
    if (this.state !== 'play') return;

    var self = this;
    var isDemo = !window.IS_AUTH;
    $('#main-action-btn, #sub-action-btn').prop('disabled', true);

    var playerCardIds = this.playerHand.map(function(c) { return c.id; });
    var dealerCardIds = this.dealerHand.map(function(c) { return c.id; });

    $.ajax({
      url: '/games/card-games-21/hit',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.CSRF_TOKEN || $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        bet_id: self.currentBetId,
        is_demo: isDemo ? 1 : 0,
        amount: self.bet,
        player_cards: playerCardIds,
        dealer_cards: dealerCardIds,
        remaining_deck: self.remainingDeck
      },
      success: function(res) {
        if (!res || !res.success) {
          alert(res?.error || 'Hit failed.');
          $('#main-action-btn, #sub-action-btn').prop('disabled', false);
          return;
        }

        var newCardId = res.new_card;
        if (newCardId) {
          var cardObj = { rank: newCardId.slice(0, -1), suit: newCardId.slice(-1), id: newCardId };
          self.playerHand.push(cardObj);
          var $c = self.createCardElem(cardObj);
          $('#player-cards').append($c);
          SoundFX.playCard();
        }
        self.remainingDeck = res.remaining_deck || self.remainingDeck;
        self.updateUI();

        if (res.status === 'busted') {
          self.finishRound('lose', res.message || 'BUST - YOU LOSE');
        } else if (res.status === 'won') {
          self.finishRound('win', res.message || 'YOU WIN!');
        } else {
          $('#main-action-btn, #sub-action-btn').prop('disabled', false);
          if (self.autoPlay) {
            self.autoStep();
          }
        }
      },
      error: function(xhr) {
        var err = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Error on hit.';
        alert(err);
        $('#main-action-btn, #sub-action-btn').prop('disabled', false);
      }
    });
  },

  autoStep: function() {
    var self = this;
    setTimeout(function() {
      if (self.state !== 'play') return;
      var pScore = self.calcScore(self.playerHand);
      if (pScore < 17) {
        self.hit();
      } else {
        self.stand();
      }
    }, 600);
  },

  stand: function() {
    if (this.state !== 'play') return;

    var self = this;
    this.state = 'dealer';
    $('#main-action-btn, #sub-action-btn').prop('disabled', true);
    var isDemo = !window.IS_AUTH;

    var playerCardIds = this.playerHand.map(function(c) { return c.id; });
    var dealerCardIds = this.dealerHand.map(function(c) { return c.id; });

    $.ajax({
      url: '/games/card-games-21/stand',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.CSRF_TOKEN || $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        bet_id: self.currentBetId,
        is_demo: isDemo ? 1 : 0,
        amount: self.bet,
        player_cards: playerCardIds,
        dealer_cards: dealerCardIds,
        remaining_deck: self.remainingDeck
      },
      success: function(res) {
        if (!res || !res.success) {
          alert(res?.error || 'Stand failed.');
          return;
        }

        // Animate dealer cards draw if any new cards were dealt
        var finalDealerCards = (res.dealer_cards || []).map(function(id) {
          return { rank: id.slice(0, -1), suit: id.slice(-1), id: id };
        });

        var startIndex = self.dealerHand.length;
        if (startIndex < finalDealerCards.length) {
          var stepDelay = 0;
          for (var i = startIndex; i < finalDealerCards.length; i++) {
            (function(card, delay) {
              setTimeout(function() {
                self.dealerHand.push(card);
                var $c = self.createCardElem(card);
                $('#dealer-cards').append($c);
                SoundFX.playCard();
                self.updateUI();
              }, delay);
            })(finalDealerCards[i], stepDelay);
            stepDelay += 600;
          }

          setTimeout(function() {
            self.finishRound(res.status, res.message);
          }, stepDelay + 300);
        } else {
          self.finishRound(res.status, res.message);
        }
      },
      error: function(xhr) {
        var err = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Error on stand.';
        alert(err);
      }
    });
  },

  finishRound: function(result, subText) {
    this.state = 'over';
    var $overlay = $('#result-banner-overlay');
    var $bg = $('#result-banner-bg');
    var $title = $('#result-main-title');
    var $sub = $('#result-sub-title');

    $bg.removeClass('lose win draw');

    if (result === 'win' || result === 'won') {
      this.wins++;
      $bg.addClass('win');
      $title.text('YOU WIN!');
      $sub.text(subText || 'Congratulations!');
      SoundFX.playWin();
      if (typeof window.triggerWinCelebration === 'function') {
        window.triggerWinCelebration({
          amount: (this.currentBet || 20) * 2,
          multiplier: 2.0,
          title: '21 BLACKJACK WIN!'
        });
      }
    } else if (result === 'lose' || result === 'lost' || result === 'busted') {
      this.losses++;
      $bg.addClass('lose');
      $title.text('BETTER LUCK NEXT TIME');
      $sub.text(subText || 'Dealer has more points');
      SoundFX.playLose();
    } else {
      this.draws++;
      $bg.addClass('draw');
      $title.text('DRAW');
      $sub.text(subText || 'Stake Returned');
    }

    this.updateUI();
    $overlay.removeClass('hidden');

    $('#top-banner-pill').text('TRY ONE MORE TIME!');

    var self = this;
    setTimeout(function() {
      if (self.state === 'over') {
        self.resetToBetMode();
      }
    }, 2200);
  },

  resetToBetMode: function() {
    this.state = 'idle';
    this.setMode('bet');
    if (this.autoPlay) {
      var self = this;
      setTimeout(function() {
        if (self.autoPlay) self.startRound();
      }, 500);
    }
  }
};

$(function() {
  Game.init();
  Game.fetchState();
});
