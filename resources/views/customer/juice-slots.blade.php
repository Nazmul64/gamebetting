<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Juice Slots - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Montserrat', sans-serif; }
    body { background: #13031a; color: #f8fafc; min-height: 100vh; overflow-x: hidden; }

    .game-wrapper {
      max-width: 1100px;
      margin: 0 auto;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .breadcrumbs {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 700;
      color: #94a3b8;
    }
    .breadcrumbs a { color: #f43f5e; text-decoration: none; }

    .slot-cabinet {
      background: radial-gradient(circle at center, #2e1065 0%, #170326 70%, #08000f 100%);
      border: 4px solid #f43f5e;
      border-radius: 28px;
      padding: 24px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.9), 0 0 30px rgba(244, 63, 94, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
    }

    .juice-title {
      font-size: 28px;
      font-weight: 900;
      color: #fb7185;
      text-shadow: 0 0 20px rgba(251, 113, 133, 0.6);
      margin-bottom: 12px;
      letter-spacing: 2px;
    }

    .reels-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      background: rgba(0, 0, 0, 0.85);
      border: 3px solid #f43f5e;
      border-radius: 20px;
      padding: 12px;
      width: 100%;
      max-width: 800px;
      box-shadow: inset 0 0 30px rgba(0,0,0,0.9);
    }

    .reel-col {
      display: flex;
      flex-direction: column;
      gap: 8px;
      background: rgba(46, 16, 101, 0.5);
      border: 1px solid rgba(244, 63, 94, 0.3);
      border-radius: 14px;
      padding: 6px;
    }
    .reel-col.spinning {
      animation: reelBlur 0.1s linear infinite;
    }
    @keyframes reelBlur {
      0% { transform: translateY(0); opacity: 0.8; }
      50% { transform: translateY(-5px); opacity: 0.6; }
      100% { transform: translateY(0); opacity: 0.8; }
    }

    .symbol-cell {
      height: 90px;
      background: #1e052d;
      border: 1px solid rgba(244, 63, 94, 0.2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px;
      overflow: hidden;
    }
    .symbol-cell img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 4px 6px rgba(0,0,0,0.6));
    }

    .controls-panel {
      background: #170326;
      border: 2px solid #881337;
      border-radius: 24px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    }

    .chips-row {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .chip-btn {
      padding: 8px 14px;
      border-radius: 12px;
      background: #4c0519;
      border: 1px solid #9f1239;
      color: #fda4af;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .chip-btn:hover { background: #881337; }
    .chip-btn.active {
      background: #f43f5e;
      color: #000;
      border-color: #fda4af;
    }

    .bet-action-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 14px;
      align-items: center;
    }
    @media (max-width: 640px) {
      .bet-action-row { grid-template-columns: 1fr; }
      .symbol-cell { height: 60px; }
    }

    .bet-input-wrap {
      display: flex;
      align-items: center;
      background: #000;
      border: 2px solid #881337;
      border-radius: 16px;
      padding: 6px 12px;
      gap: 10px;
    }
    .bet-input-wrap input {
      background: transparent;
      border: none;
      color: #fb7185;
      font-size: 20px;
      font-weight: 800;
      width: 100%;
      outline: none;
    }

    .spin-btn {
      padding: 16px 40px;
      border-radius: 16px;
      background: linear-gradient(135deg, #fb7185 0%, #f43f5e 100%);
      border: 2px solid #fecdd3;
      color: #000;
      font-size: 16px;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      box-shadow: 0 0 25px rgba(244, 63, 94, 0.4);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .spin-btn:hover:not(:disabled) {
      transform: scale(1.02);
      box-shadow: 0 0 35px rgba(244, 63, 94, 0.6);
    }
    .spin-btn:disabled {
      background: #4c0519;
      color: #9f1239;
      border-color: #9f1239;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

  @include('customer.header')

  <div class="game-wrapper">
    <div class="breadcrumbs">
      <a href="{{ route('home') }}">1XGAMES</a>
      <span>/</span>
      <a href="{{ route('dashboard') }}">SLOTS</a>
      <span>/</span>
      <span style="color:#f8fafc;">JUICE SLOTS</span>
    </div>

    <div class="slot-cabinet">
      <div class="juice-title">🍹 JUICE SLOTS 🍓</div>

      <div id="status-banner" style="font-size: 14px; font-weight: 800; color: #fda4af; margin-bottom: 12px;">
        PRESS SPIN TO PLAY
      </div>

      <div class="reels-grid" id="reels-grid">
        @for($col = 0; $col < 5; $col++)
          <div class="reel-col" id="col-{{ $col }}">
            @for($row = 0; $row < 3; $row++)
              <div class="symbol-cell">
                <img src="/juice-slots/images/straw.svg" alt="Juice Symbol">
              </div>
            @endfor
          </div>
        @endfor
      </div>
    </div>

    <div class="controls-panel">
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <div class="chips-row">
          <button class="chip-btn active" onclick="setBet(10, this)">+10</button>
          <button class="chip-btn" onclick="setBet(20, this)">+20</button>
          <button class="chip-btn" onclick="setBet(50, this)">+50</button>
          <button class="chip-btn" onclick="setBet(100, this)">+100</button>
          <button class="chip-btn" onclick="setBet(500, this)">+500</button>
        </div>

        <div style="display:flex; gap:6px;">
          <button id="mode-real" class="chip-btn active" onclick="setDemo(false)">💰 Real</button>
          <button id="mode-demo" class="chip-btn" onclick="setDemo(true)">🎮 Demo</button>
        </div>
      </div>

      <div class="bet-action-row">
        <div class="bet-input-wrap">
          <span style="font-size:13px; font-weight:800; color:#fb7185;">STAKE (৳):</span>
          <input type="number" id="bet-input" value="20" min="1" max="50000">
          <button class="chip-btn" onclick="adjustBet(0.5)">1/2</button>
          <button class="chip-btn" onclick="adjustBet(2)">2X</button>
        </div>

        <button class="spin-btn" id="spin-trigger" onclick="spinJuiceSlot()">
          <i class="fa-solid fa-rotate-right"></i>
          <span>SPIN REELS</span>
        </button>
      </div>
    </div>
  </div>

  <script>
    const SYMBOL_IMAGES = {
      'straw': '/juice-slots/images/straw.svg',
      'juice': '/juice-slots/images/juice.svg',
      'grape': '/juice-slots/images/grape.svg',
      'ban': '/juice-slots/images/ban.svg',
      'org': '/juice-slots/images/org.svg',
      'cup': '/juice-slots/images/cup.svg',
      'egg': '/juice-slots/images/egg.svg'
    };

    const SYMBOL_KEYS = Object.keys(SYMBOL_IMAGES);
    let isSpinning = false;
    let isDemo = false;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function setBet(amt, el) {
      document.getElementById('bet-input').value = amt;
      document.querySelectorAll('.chips-row .chip-btn').forEach(b => b.classList.remove('active'));
      if (el) el.classList.add('active');
    }

    function adjustBet(factor) {
      const input = document.getElementById('bet-input');
      let val = parseFloat(input.value) || 20;
      val = Math.max(1, Math.floor(val * factor));
      input.value = val;
    }

    function setDemo(val) {
      isDemo = val;
      document.getElementById('mode-real').classList.toggle('active', !val);
      document.getElementById('mode-demo').classList.toggle('active', val);
    }

    function getRandomSymbol() {
      return SYMBOL_KEYS[Math.floor(Math.random() * SYMBOL_KEYS.length)];
    }

    async function spinJuiceSlot() {
      if (isSpinning) return;
      const amount = parseFloat(document.getElementById('bet-input').value);
      if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid stake amount.");
        return;
      }

      isSpinning = true;
      const spinBtn = document.getElementById('spin-trigger');
      spinBtn.disabled = true;

      for (let c = 0; c < 5; c++) {
        document.getElementById(`col-${c}`).classList.add('spinning');
      }

      document.getElementById('status-banner').innerText = 'SPINNING JUICE REELS...';

      const animInterval = setInterval(() => {
        for (let c = 0; c < 5; c++) {
          const colEl = document.getElementById(`col-${c}`);
          colEl.querySelectorAll('.symbol-cell img').forEach(img => {
            const sym = getRandomSymbol();
            img.src = SYMBOL_IMAGES[sym];
          });
        }
      }, 80);

      try {
        const res = await fetch("{{ route('juiceslots.spin') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
          },
          body: JSON.stringify({
            bet: amount,
            amount: amount,
            is_demo: isDemo
          })
        });

        const data = await res.json();
        clearInterval(animInterval);

        setTimeout(() => {
          for (let c = 0; c < 5; c++) {
            document.getElementById(`col-${c}`).classList.remove('spinning');
          }

          if (!data.success) {
            alert(data.error || "Spin failed");
            isSpinning = false;
            spinBtn.disabled = false;
            return;
          }

          if (data.grid) {
            for (let r = 0; r < 3; r++) {
              for (let c = 0; c < 5; c++) {
                const symKey = data.grid[r][c];
                const colEl = document.getElementById(`col-${c}`);
                const img = colEl.querySelectorAll('.symbol-cell img')[r];
                if (img) {
                  img.src = SYMBOL_IMAGES[symKey] || SYMBOL_IMAGES['straw'];
                }
              }
            }
          }

          const winAmount = parseFloat(data.win_amount || 0);
          if (winAmount > 0) {
            document.getElementById('status-banner').innerText = `🎉 JUICY WIN! +৳${winAmount.toFixed(2)}`;
            if (typeof window.triggerWinCelebration === 'function') {
              window.triggerWinCelebration({
                amount: winAmount,
                multiplier: bet > 0 ? (winAmount / bet) : 0,
                title: 'JUICY FRESH WIN!'
              });
            }
          } else {
            document.getElementById('status-banner').innerText = 'TRY AGAIN FOR FRESH FRUITS!';
          }

          isSpinning = false;
          spinBtn.disabled = false;
        }, 900);

      } catch (err) {
        clearInterval(animInterval);
        for (let c = 0; c < 5; c++) {
          document.getElementById(`col-${c}`).classList.remove('spinning');
        }
        isSpinning = false;
        spinBtn.disabled = false;
        alert("Network error occurred.");
      }
    }
  </script>
</body>
</html>
