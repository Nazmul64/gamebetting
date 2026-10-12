/**
 * Indian Poker Game Logic (1xBet Architecture & Flow)
 */
const State = {
  balance: 1000.00,
  bet: 20,
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
  for (let i = State.deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [State.deck[i], State.deck[j]] = [State.deck[j], State.deck[i]];
  }
}

function normalizeCardCode(c) {
  if (typeof c === 'string') return c;
  if (c && typeof c === 'object') {
    const r = c.rank;
    const rankStr = (r === 14) ? 'A' : ((r === 13) ? 'K' : ((r === 12) ? 'Q' : ((r === 11) ? 'J' : String(r))));
    return rankStr + (c.suit || 'S');
  }
  return '2S';
}

function mapHandToBadgeId(handType) {
  if (!handType) return null;
  const h = String(handType).toLowerCase().replace(/[\s_-]/g, '');
  if (h.includes('straightflush') || h === 'sf') return 'sf';
  if (h.includes('three') || h.includes('3ofakind')) return 'three';
  if (h.includes('straight')) return 'straight';
  if (h.includes('flush')) return 'flush';
  if (h.includes('pair')) return 'pair';
  return null;
}

function animateBalance(startVal, endVal, duration = 600) {
  const balEl = document.getElementById('bal-val');
  if (!balEl) return;
  const start = performance.now();
  function step(now) {
    const elapsed = now - start;
    const progress = Math.min(1, elapsed / duration);
    const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
    const current = startVal + (endVal - startVal) * ease;
    balEl.textContent = Number(current).toFixed(2);
    if (progress < 1) {
      requestAnimationFrame(step);
    } else {
      balEl.textContent = Number(endVal).toFixed(2);
    }
  }
  requestAnimationFrame(step);
}

function updateUI() {
  const balEl = document.getElementById('bal-val');
  if (balEl) balEl.textContent = Number(State.balance).toFixed(2);

  const betEl = document.getElementById('bet-val');
  if (betEl) betEl.textContent = State.bet;

  // Highlight active bet button
  document.querySelectorAll('.chip-btn').forEach(btn => {
    const val = parseInt(btn.dataset.val, 10);
    btn.classList.toggle('selected', val === State.bet);
  });

  // Demo badge state and indicator styling
  const demoBadge = document.getElementById('demo-badge');
  if (demoBadge) {
    if (State.demoMode) {
      demoBadge.innerHTML = '<span class="dot" style="background:#2dd4bf;box-shadow:0 0 6px #2dd4bf;"></span> DEMO MODE &#x2303;';
      demoBadge.title = 'Free Demo Mode. Tap to switch to Real Mode.';
      demoBadge.style.background = '#153a5e';
      demoBadge.style.borderColor = '#1f5487';
      demoBadge.style.color = '#8faec9';
    } else {
      demoBadge.innerHTML = '<span class="dot" style="background:#22c55e;box-shadow:0 0 6px #22c55e;"></span> REAL MONEY &#x2303;';
      demoBadge.title = 'Real Money Mode. Tap to switch to Demo Mode.';
      demoBadge.style.background = 'linear-gradient(90deg, #064e3b 0%, #022c22 100%)';
      demoBadge.style.borderColor = '#059669';
      demoBadge.style.color = '#6ee7b7';
    }
  }
}

function setBet(amount) {
  if (State.busy) return;
  if (typeof AudioFX !== 'undefined' && AudioFX.chip) {
    AudioFX.chip();
  }
  State.bet = amount;
  updateUI();
}

function showModal(modalId) {
  const m = document.getElementById(modalId);
  if (m) m.classList.add('show');
}

function closeModal(modalId) {
  const m = document.getElementById(modalId);
  if (m) m.classList.remove('show');
}

function setMessage(text, type = '') {
  const msgEl = document.getElementById('msg');
  if (!msgEl) return;
  msgEl.className = '';
  if (type) msgEl.classList.add(type);
  msgEl.textContent = text;
}

function toggleDemoMode() {
  if (!window.IS_AUTH) {
    State.demoMode = true;
    State.balance = 1000.00;
    updateUI();
    setMessage('Demo balance: 1,000.00');
    return;
  }

  State.demoMode = !State.demoMode;
  if (State.demoMode) {
    State.balance = 1000.00;
    setMessage('Demo Mode Activated (1,000.00)');
  } else {
    State.balance = typeof window.REAL_BALANCE === 'number' ? window.REAL_BALANCE : 0.00;
    setMessage('Real Money Mode Activated');
    if (State.balance <= 0) {
      setTimeout(() => {
        setMessage('Please deposit or switch to Demo');
      }, 1400);
    }
  }
  updateUI();
}

async function fetchGameState() {
  try {
    const res = await $.getJSON('/games/indian-poker/state');
    if (res && res.success) {
      if (res.user_balance !== null && typeof res.user_balance === 'number') {
        window.REAL_BALANCE = res.user_balance;
        if (window.REAL_BALANCE > 0) {
          State.balance = window.REAL_BALANCE;
          State.demoMode = false;
        } else {
          State.balance = (res.settings && res.settings.demo_default_balance) || 1000.00;
          State.demoMode = true;
        }
      } else {
        State.demoMode = true;
        State.balance = 1000.00;
      }
      updateUI();
    }
  } catch(e) {
    console.warn('Game state fallback to default');
    updateUI();
  }
}

async function playRound() {
  if (State.busy) return;

  const isDemo = State.demoMode;

  if (!isDemo && !window.IS_AUTH) {
    setMessage('Please log in for Real Mode');
    return;
  }

  if (!isDemo && State.balance < State.bet) {
    setMessage('Not enough balance! Tap DEMO to play free.');
    return;
  }

  if (isDemo && State.balance < State.bet) {
    State.balance = 1000.00;
    updateUI();
  }

  State.busy = true;

  // Disable controls during dealing
  const placeBetBtn = document.getElementById('btn-place-bet');
  if (placeBetBtn) placeBetBtn.disabled = true;
  document.querySelectorAll('.chip-btn').forEach(b => b.disabled = true);
  document.querySelectorAll('.badge-item').forEach(b => b.classList.remove('active-win'));
  
  // Step 1: Start Event Audio
  if (typeof AudioFX !== 'undefined') {
    AudioFX.chip();
    setTimeout(() => {
      AudioFX.deal();
    }, 80);
  }

  // Instant Visual Balance Deduction (e.g. 1000 - 20 => 980)
  const prevBalance = State.balance;
  State.balance = Math.max(0, State.balance - State.bet);
  animateBalance(prevBalance, State.balance, 220);

  // Cards Deal Downward Animation (3 cards slide down from above onto marble pedestal)
  document.querySelectorAll('.card-slot').forEach(slot => {
    slot.classList.remove('winning', 'flipped');
    slot.classList.add('dealing');
  });

  setMessage('Dealing cards...');

  try {
    const response = await $.ajax({
      url: '/games/indian-poker/bet',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.CSRF_TOKEN || $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        amount: State.bet,
        bet_amount: State.bet,
        is_demo: isDemo ? 1 : 0
      }
    });

    if (!response || !response.success) {
      setMessage(response?.error || response?.message || 'Bet failed. Try again.');
      State.busy = false;
      if (placeBetBtn) placeBetBtn.disabled = false;
      document.querySelectorAll('.chip-btn').forEach(b => b.disabled = false);
      // Restore balance on failure
      State.balance = prevBalance;
      updateUI();
      return;
    }

    // Extract cards & normalize
    const rawCards = response.card_codes || response.cards || ['2S', '4H', '8D'];
    const cardCodes = rawCards.map(normalizeCardCode);
    const basePath = window.INDIAN_POKER_BASE || '/indian-poker/';

    // Update card front images
    cardCodes.forEach((code, i) => {
      const frontImg = document.querySelector(`.card-slot[data-index="${i}"] .card-face.front img`);
      if (frontImg) {
        frontImg.src = `${basePath}assets/images/cards/${code}.svg`;
      }
    });

    // Wait for dealing animation settle (~350ms)
    await new Promise(res => setTimeout(res, 350));
    document.querySelectorAll('.card-slot').forEach(slot => slot.classList.remove('dealing'));

    // Step 2: Response & Staggered 3D Flip (0.2s interval left to right: 0s, 0.2s, 0.4s)
    for (let i = 0; i < 3; i++) {
      if (i > 0) {
        await new Promise(res => setTimeout(res, 200)); // 0.2s interval
      }
      const slot = document.querySelector(`.card-slot[data-index="${i}"]`);
      if (slot) slot.classList.add('flipped');
      if (typeof AudioFX !== 'undefined' && AudioFX.flip) {
        AudioFX.flip();
      }
    }

    // Step 3: Result Evaluation State
    await new Promise(res => setTimeout(res, 400));
    const isWin = Boolean(response.is_win);
    const rawHandType = response.hand_type;
    const badgeId = mapHandToBadgeId(rawHandType);
    const payout = Number(response.payout !== undefined ? response.payout : (response.win_amount || 0));
    const handName = response.hand_name || rawHandType || (isWin ? 'Winning Hand' : 'High Card');

    if (isWin) {
      // Golden highlight and glow on winning badge
      if (badgeId) {
        const badgeEl = document.querySelector(`.badge-item[data-id="${badgeId}"]`);
        if (badgeEl) badgeEl.classList.add('active-win');
      }

      // Highlight winning cards with golden border
      document.querySelectorAll('.card-slot').forEach(slot => slot.classList.add('winning'));

      // Particle & Coin explosion across table
      if (typeof Engine !== 'undefined' && Engine.explodeCoins) {
        Engine.explodeCoins(512, 195);
      }
      if (typeof confetti === 'function') {
        confetti({
          particleCount: 75,
          spread: 70,
          origin: { y: 0.58 },
          colors: ['#ffd700', '#f59e0b', '#ffffff', '#eab308']
        });
      }

      // Audio: Win celebration bell & coin drop
      if (typeof AudioFX !== 'undefined' && AudioFX.win) {
        AudioFX.win(badgeId);
      }

      // Balance Roll Up (animated rapid scroll to new balance)
      const targetBalance = (!isDemo && response.new_balance !== undefined) 
        ? Number(response.new_balance)
        : (State.balance + payout);

      animateBalance(State.balance, targetBalance, 800);
      State.balance = targetBalance;

      if (!isDemo) {
        window.REAL_BALANCE = targetBalance;
        const headerBal = document.querySelector('.nav-user-balance, #header-balance');
        if (headerBal) headerBal.textContent = targetBalance.toFixed(2) + ' BDT';
      }

      // Win message
      const msgType = (badgeId === 'three' || badgeId === 'sf') ? 'bigwin' : 'win';
      setMessage(`${handName}! You win ${payout.toFixed(2)}`, msgType);
    } else {
      // Losing state: subtle lose tone & fade-in text
      if (typeof AudioFX !== 'undefined' && AudioFX.lose) {
        AudioFX.lose();
      }
      setMessage('Better luck next time!', 'lose');

      if (!isDemo && response.new_balance !== undefined) {
        State.balance = Number(response.new_balance);
        window.REAL_BALANCE = Number(response.new_balance);
        const headerBal = document.querySelector('.nav-user-balance, #header-balance');
        if (headerBal) headerBal.textContent = Number(response.new_balance).toFixed(2) + ' BDT';
      }
    }

    setTimeout(() => {
      updateUI();
    }, 850);
  } catch (err) {
    const errorMsg = err.responseJSON?.error || err.responseJSON?.message || 'Error communicating with game server.';
    setMessage(errorMsg);
    State.balance = prevBalance;
    updateUI();
  } finally {
    State.busy = false;
    if (placeBetBtn) placeBetBtn.disabled = false;
    document.querySelectorAll('.chip-btn').forEach(b => b.disabled = false);
  }
}

// Event Listeners initialization
function initializeIndianPoker() {
  initDeck();
  
  if (typeof Engine !== 'undefined' && Engine.init) {
    Engine.init('fx', 1024, 438);
  }

  fetchGameState();

  // Setup Chips
  document.querySelectorAll('.chip-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      setBet(parseInt(btn.dataset.val, 10));
    });
  });

  // Clear Bet button
  document.getElementById('bet-clr')?.addEventListener('click', (e) => {
    e.preventDefault();
    setBet(10);
  });

  // Place Bet Button
  document.getElementById('btn-place-bet')?.addEventListener('click', (e) => {
    e.preventDefault();
    playRound();
  });

  // Demo badge toggle
  document.getElementById('demo-badge')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleDemoMode();
  });

  // Info Button
  document.getElementById('btn-info')?.addEventListener('click', (e) => {
    e.preventDefault();
    showModal('modal-info');
  });

  // Jackpot Button
  document.getElementById('btn-jackpot')?.addEventListener('click', (e) => {
    e.preventDefault();
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

  // Right side tool hitboxes
  document.getElementById('tool-settings')?.addEventListener('click', (e) => {
    e.preventDefault();
    showModal('modal-settings');
  });

  document.getElementById('tool-sound')?.addEventListener('click', (e) => {
    e.preventDefault();
    State.soundOn = !State.soundOn;
    if (typeof AudioFX !== 'undefined') {
      AudioFX.enabled = State.soundOn;
    }
    setMessage(State.soundOn ? 'Sound: ON' : 'Sound: OFF');
  });

  updateUI();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeIndianPoker);
} else {
  initializeIndianPoker();
}
