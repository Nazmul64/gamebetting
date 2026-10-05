/**
 * Indian Poker Game Logic
 */
const State = {
  balance: 1000.00,
  bet: 1,
  busy: false,
  deck: [],
  demoMode: true,
  fastPlay: false,
  soundOn: true
};

const HAND_CONFIG = [
  { id: 'pair', name: 'Pair', mult: 1 },
  { id: 'flush', name: 'Flush', mult: 5 },
  { id: 'straight', name: 'Straight', mult: 10 },
  { id: 'three', name: '3 of a Kind', mult: 50 },
  { id: 'sf', name: 'Straight Flush', mult: 75 }
];

const RANKS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
const SUITS = ['S', 'H', 'D', 'C'];

function initDeck() {
  State.deck = [];
  for (const s of SUITS) {
    for (const r of RANKS) {
      State.deck.push(r + s);
    }
  }
  // Fisher-Yates Shuffle
  for (let i = State.deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [State.deck[i], State.deck[j]] = [State.deck[j], State.deck[i]];
  }
}

function getRankVal(card) {
  const r = card.slice(0, -1);
  if (r === 'A') return 14;
  if (r === 'K') return 13;
  if (r === 'Q') return 12;
  if (r === 'J') return 11;
  return parseInt(r, 10);
}

function evaluateHand(cards) {
  const values = cards.map(getRankVal).sort((a, b) => a - b);
  const suits = cards.map(c => c.slice(-1));

  const isFlush = suits[0] === suits[1] && suits[1] === suits[2];
  
  // Straight: e.g. [2,3,4] or [12,13,14] (Q,K,A) or [2,3,14] (A-2-3 low ace)
  const isNormalStraight = (values[1] === values[0] + 1) && (values[2] === values[1] + 1);
  const isLowAceStraight = (values[0] === 2 && values[1] === 3 && values[2] === 14);
  const isStraight = isNormalStraight || isLowAceStraight;

  const isThreeOfAKind = (values[0] === values[1]) && (values[1] === values[2]);
  const isPair = (values[0] === values[1]) || (values[1] === values[2]) || (values[0] === values[2]);

  if (isStraight && isFlush) return 'sf';
  if (isThreeOfAKind) return 'three';
  if (isStraight) return 'straight';
  if (isFlush) return 'flush';
  if (isPair) return 'pair';
  return null;
}

function updateUI() {
  document.getElementById('bal-val').textContent = State.balance.toFixed(2);
  document.getElementById('bet-val').textContent = State.bet;

  // Highlight active bet button
  document.querySelectorAll('.chip-btn').forEach(btn => {
    const val = parseInt(btn.dataset.val, 10);
    btn.classList.toggle('selected', val === State.bet);
  });
}

function setBet(amount) {
  if (State.busy) return;
  AudioFX.chip();
  State.bet = amount;
  updateUI();
}

function showModal(modalId) {
  document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('show');
}

function setMessage(text, type = '') {
  const msgEl = document.getElementById('msg');
  msgEl.className = '';
  if (type) msgEl.classList.add(type);
  msgEl.textContent = text;
}

async function playRound() {
  if (State.busy) return;
  if (State.balance < State.bet) {
    setMessage('Not enough balance!');
    return;
  }

  State.busy = true;
  State.balance -= State.bet;
  updateUI();

  // Disable controls
  document.getElementById('btn-place-bet').disabled = true;
  document.querySelectorAll('.chip-btn').forEach(b => b.disabled = true);
  document.querySelectorAll('.badge-item').forEach(b => b.classList.remove('active-win'));
  document.querySelectorAll('.card-slot').forEach(slot => {
    slot.classList.remove('winning', 'flipped');
  });

  setMessage('Good luck!');

  if (State.deck.length < 6) {
    initDeck();
  }

  const dealtHand = [State.deck.pop(), State.deck.pop(), State.deck.pop()];

  // Update card front images
  dealtHand.forEach((card, i) => {
    const frontImg = document.querySelector(`.card-slot[data-index="${i}"] .card-face.front img`);
    frontImg.src = `assets/images/cards/${card}.svg`;
  });

  const speedMultiplier = State.fastPlay ? 0.5 : 1.0;

  // Step 1: Deal sound
  AudioFX.deal();

  // Step 2: Flip cards one by one
  for (let i = 0; i < 3; i++) {
    await new Promise(res => setTimeout(res, (350 * speedMultiplier)));
    const slot = document.querySelector(`.card-slot[data-index="${i}"]`);
    slot.classList.add('flipped');
    AudioFX.flip();
  }

  // Step 3: Evaluate Hand and payout
  await new Promise(res => setTimeout(res, (500 * speedMultiplier)));
  const winHandId = evaluateHand(dealtHand);

  if (winHandId) {
    const config = HAND_CONFIG.find(h => h.id === winHandId);
    // Payout: Original bet * (multiplier + 1)
    const winAmount = State.bet * (config.mult + 1);
    State.balance += winAmount;

    // Highlight badge
    const badgeEl = document.querySelector(`.badge-item[data-id="${winHandId}"]`);
    if (badgeEl) badgeEl.classList.add('active-win');

    // Highlight winning cards
    document.querySelectorAll('.card-slot').forEach(slot => slot.classList.add('winning'));

    // Sound and message
    AudioFX.win(winHandId);
    if (winHandId === 'three' || winHandId === 'sf') {
      setMessage(`${config.name}! You win ${winAmount.toFixed(2)}`, 'bigwin');
    } else {
      setMessage(`${config.name}! You win ${winAmount.toFixed(2)}`, 'win');
    }
  } else {
    AudioFX.lose();
    setMessage('Try again!');
  }

  updateUI();
  State.busy = false;
  document.getElementById('btn-place-bet').disabled = false;
  document.querySelectorAll('.chip-btn').forEach(b => b.disabled = false);
}

// Event Listeners initialization
document.addEventListener('DOMContentLoaded', () => {
  initDeck();
  Engine.init('fx', 1024, 438);

  // Setup Chips
  document.querySelectorAll('.chip-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      setBet(parseInt(btn.dataset.val, 10));
    });
  });

  // Clear Bet button
  document.getElementById('bet-clr').addEventListener('click', () => {
    setBet(1);
  });

  // Place Bet Button
  document.getElementById('btn-place-bet').addEventListener('click', playRound);

  // Info Button
  document.getElementById('btn-info').addEventListener('click', () => {
    showModal('modal-info');
  });

  // Jackpot Button
  document.getElementById('btn-jackpot').addEventListener('click', () => {
    showModal('modal-jackpot');
  });

  // Close modals
  document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
    el.addEventListener('click', (e) => {
      if (e.target === el || el.classList.contains('modal-close')) {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
      }
    });
  });

  // Right side icons
  document.getElementById('tool-settings')?.addEventListener('click', () => {
    showModal('modal-settings');
  });

  document.getElementById('tool-sound')?.addEventListener('click', () => {
    State.soundOn = !State.soundOn;
    AudioFX.enabled = State.soundOn;
    setMessage(State.soundOn ? 'Sound: ON' : 'Sound: OFF');
  });

  // Demo badge toggle
  document.getElementById('demo-badge')?.addEventListener('click', () => {
    State.balance = 1000.00;
    updateUI();
    setMessage('Balance reset to 1000.00');
  });

  updateUI();
});
