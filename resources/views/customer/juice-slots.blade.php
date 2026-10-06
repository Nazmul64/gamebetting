<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Juice Slots - 1xBet Casino</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        :root {
            --bg1: #ff8a00;
            --bg2: #c94b00;
            --frame: #ffc23d;
            --red: #d62a2a;
            --red2: #ff5a5a;
            --dark: #8a1717;
            --ink: #fff;
        }
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: 'Bebas Neue', Impact, 'Arial Narrow', sans-serif;
            color: var(--ink);
            background: #2b1000;
            overflow-x: hidden;
            user-select: none;
        }
        .game-viewport {
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: radial-gradient(circle at center, #ff8a00 0%, #a73c00 60%, #1a0800 100%);
            position: relative;
        }
        .game-top-bar {
            width: 100%;
            max-width: 1000px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 16px;
            margin-bottom: 8px;
            background: rgba(43, 16, 0, 0.85);
            border: 2px solid rgba(255, 194, 61, 0.5);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            font-family: 'Outfit', sans-serif;
        }
        .breadcrumbs {
            font-size: 13px;
            color: #ffd25a;
            font-weight: 600;
        }
        .breadcrumbs a {
            color: #ffd25a;
            text-decoration: none;
            transition: color 0.2s;
        }
        .breadcrumbs a:hover {
            color: #fff;
        }
        .top-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sound-toggle-btn, .info-btn-top {
            background: linear-gradient(135deg, var(--red2), var(--red));
            border: 1px solid #ffd36b;
            color: #fff;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .sound-toggle-btn:hover, .info-btn-top:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 211, 107, 0.6);
        }
        #stage-wrap {
            position: relative;
            width: 100%;
            max-width: 1000px;
            height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #stage {
            position: relative;
            width: 1000px;
            height: 520px;
            transform-origin: center center;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8);
        }
        .abs { position: absolute; }
        #credit {
            left: 300px;
            top: 6px;
            width: 400px;
            height: 52px;
            background: var(--red);
            border: 5px dotted #ffd36b;
            border-radius: 14px;
            text-align: center;
            font-size: 36px;
            line-height: 44px;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        }
        #machine {
            left: 60px;
            top: 44px;
            width: 880px;
            height: 376px;
            background: linear-gradient(#ffd25a, var(--frame));
            border-radius: 60px 60px 40px 40px;
            box-shadow: 0 8px 0 #b7691a, 0 15px 30px rgba(0,0,0,0.5);
        }
        #well {
            left: 150px;
            top: 24px;
            width: 580px;
            height: 328px;
            background: #b5651d;
            padding: 8px;
            border-radius: 12px;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.7);
        }
        #reels {
            position: relative;
            display: flex;
            height: 100%;
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
        }
        .reel {
            flex: 1;
            border-right: 2px solid #c98;
            background: linear-gradient(90deg, #c9c9c9, #fff 20%, #fff 80%, #c9c9c9);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .reel:last-child { border: 0; }
        .cell {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        .cell img {
            width: 78%;
            height: 78%;
            object-fit: contain;
        }
        .spinning .cell { filter: blur(2px); }
        .cell.win svg, .cell.win img {
            animation: popJuice 0.5s ease-in-out infinite alternate;
        }
        @keyframes popJuice {
            to { transform: scale(1.22); filter: drop-shadow(0 0 8px #ffeb3b); }
        }
        #lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 4;
        }
        .ln {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            top: 36px;
            height: 300px;
        }
        .ln span {
            background: var(--red);
            border-radius: 6px;
            width: 42px;
            height: 30px;
            text-align: center;
            font-size: 24px;
            line-height: 30px;
            box-shadow: 0 3px 0 var(--dark);
            transition: opacity 0.2s;
            color: #fff;
        }
        .off { opacity: 0.3; }
        .lever {
            left: 920px;
            top: 110px;
            width: 14px;
            height: 110px;
            background: #f0a92b;
            border-radius: 8px;
            transform: rotate(8deg);
            cursor: pointer;
            z-index: 10;
        }
        .lever:before {
            content: "";
            position: absolute;
            left: -13px;
            top: -22px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #d62a2a;
            box-shadow: 0 4px 8px rgba(0,0,0,0.4);
        }
        .lever.pull { animation: pull 0.5s; }
        @keyframes pull {
            50% { transform: rotate(8deg) translateY(40px); }
        }
        .box {
            position: absolute;
            bottom: 88px;
            width: 150px;
            height: 36px;
            background: #555;
            border: 3px solid #888;
            border-radius: 6px 6px 0 0;
            text-align: center;
            font-size: 26px;
            line-height: 32px;
            color: #fff;
        }
        .btn {
            position: absolute;
            bottom: 20px;
            width: 170px;
            height: 56px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(var(--red2), var(--red));
            color: #fff;
            font: inherit;
            font-size: 30px;
            box-shadow: 0 6px 0 var(--dark);
            cursor: pointer;
            transition: transform 0.1s;
        }
        .btn:active {
            transform: translateY(4px);
            box-shadow: 0 2px 0 var(--dark);
        }
        .btn:disabled {
            filter: grayscale(0.6);
            cursor: default;
        }
        #gear {
            position: absolute;
            right: 16px;
            top: 10px;
            width: 64px;
            height: 52px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(var(--red2), var(--red));
            box-shadow: 0 5px 0 var(--dark);
            color: #fff;
            font-size: 30px;
            cursor: pointer;
        }
        #msg {
            left: 0;
            right: 0;
            top: 428px;
            text-align: center;
            font-size: 30px;
            color: #fff;
            text-shadow: 0 2px 0 #7a2d00;
            height: 34px;
        }
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(60, 20, 0, 0.8);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 12px;
        }
        .modal.on { display: flex; }
        .card {
            background: #fff3d6;
            color: #5a1d00;
            border: 6px solid var(--frame);
            border-radius: 20px;
            padding: 18px 22px;
            width: min(560px, 100%);
            max-height: 90vh;
            overflow: auto;
            font-family: Arial, sans-serif;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8);
        }
        .card h2 {
            font-family: 'Bebas Neue', Impact, sans-serif;
            font-size: 34px;
            font-weight: 400;
            margin-bottom: 8px;
        }
        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 9px 0;
            font-size: 15px;
        }
        .row select, .row button {
            font: inherit;
            padding: 6px 10px;
            border-radius: 8px;
            border: 2px solid #d9902b;
            background: #fff;
            color: #5a1d00;
            cursor: pointer;
        }
        .row input[type=range] {
            width: 180px;
            accent-color: var(--red);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        td, th {
            padding: 4px;
            text-align: center;
            border-bottom: 1px solid #f0c98a;
        }
        td img {
            width: 34px;
            height: 34px;
        }
        .close {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border: 0;
            border-radius: 10px;
            background: var(--red);
            color: #fff;
            font: 22px 'Bebas Neue', Impact, sans-serif;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @include('customer.header')

    <div class="game-viewport">
        <!-- Top Breadcrumbs Bar -->
        <div class="game-top-bar">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">HOME</a> / <a href="{{ route('dashboard') }}">SLOTS</a> / <span>JUICE SLOTS</span>
            </div>
            <div class="top-controls">
                <button class="sound-toggle-btn" id="soundBtn" onclick="toggleAudio()">
                    <i class="fas fa-volume-up" id="soundIcon"></i> <span id="soundText">Music: ON</span>
                </button>
                <button class="info-btn-top" onclick="$('mInfo').classList.add('on')">
                    <i class="fas fa-info-circle"></i> Paytable
                </button>
            </div>
        </div>

        <div id="stage-wrap">
            <div id="stage">
                <div id="credit" class="abs">BALANCE: <span id="cr">5000.00</span></div>
                <button id="gear" aria-label="Settings">&#9881;</button>
                <div id="machine" class="abs">
                    <div class="ln" id="lnL" style="left:26px"></div>
                    <div class="ln" id="lnR" style="right:26px"></div>
                    <div id="well" class="abs"><div id="reels"></div></div>
                </div>
                <div class="abs lever" id="lever" title="Pull Lever!"></div>
                <div id="msg" class="abs"></div>
                <div class="box" style="left:280px" id="bxL">9</div>
                <div class="box" style="left:475px" id="bxB">0.50</div>
                <div class="box" style="left:670px" id="bxT">BET: 4.50</div>
                <div class="box" style="left:865px;width:110px;display:none"></div>
                <button class="btn" style="left:60px;width:130px" id="bInfo">INFO</button>
                <button class="btn" style="left:255px" id="bLines">LINES</button>
                <button class="btn" style="left:450px" id="bBet">BET</button>
                <button class="btn" style="left:645px" id="bMax">MAX BET</button>
                <button class="btn" style="left:840px;width:150px" id="bSpin">SPIN</button>
            </div>
        </div>
    </div>

    <!-- Paytable Modal -->
    <div class="modal" id="mInfo">
        <div class="card">
            <h2>Pay Table</h2>
            <p style="font-size:14px;margin-bottom:6px">Match 3, 4 or 5 symbols from the left on a line. The juice is wild. Pay = line bet × multiplier.</p>
            <table id="pt"></table>
            <button class="close" data-close>CLOSE</button>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal" id="mSet">
        <div class="card">
            <h2>Settings</h2>
            <div class="row">Game mode<select id="sMode"><option value="9">Multi-line (9 lines)</option><option value="3">Three line</option></select></div>
            <div class="row">Sound<button id="sMute">On</button></div>
            <div class="row">Win chance<span><input type="range" id="sWin" min="0" max="100" value="35"> <b id="vWin">35</b>%</span></div>
            <div class="row">Big win share<span><input type="range" id="sBig" min="0" max="100" value="10"> <b id="vBig">10</b>%</span></div>
            <div class="row">Next spin result<select id="sPre"><option value="random">Random (by chances)</option><option value="lose">Lose</option><option value="win">Small win</option><option value="big">Big win (5 trophies)</option></select></div>
            <button class="close" data-close>CLOSE</button>
        </div>
    </div>

    <script>
        window.JUICE_BASE = "{{ asset('juice-slots/juice-slots') }}/";
        window.USER_BALANCE = {{ Auth::check() ? (float)Auth::user()->balance : 5000.00 }};

        // --- Tropical Synth & Sound Audio Engine with Background Music ---
        class JuiceAudioEngine {
            constructor() {
                this.ctx = null;
                this.isMuted = false;
                this.bgTimer = null;
            }

            init() {
                if (!this.ctx) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) this.ctx = new AudioCtx();
                }
                if (this.ctx && this.ctx.state === 'suspended') {
                    this.ctx.resume();
                }
                this.startBackgroundMusic();
            }

            startBackgroundMusic() {
                if (this.bgTimer || this.isMuted || !this.ctx) return;
                // Calypso / tropical sunshine rhythmic chords
                const chords = [
                    [329.63, 392.00, 523.25], // C major
                    [349.23, 440.00, 523.25], // F major
                    [392.00, 493.88, 587.33], // G major
                    [329.63, 392.00, 523.25]  // C major
                ];
                let idx = 0;
                this.bgTimer = setInterval(() => {
                    if (this.isMuted || !this.ctx) return;
                    const chord = chords[idx % chords.length];
                    idx++;
                    chord.forEach((freq, i) => {
                        try {
                            const osc = this.ctx.createOscillator();
                            const gain = this.ctx.createGain();
                            osc.type = 'triangle';
                            osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                            gain.gain.setValueAtTime(0.015, this.ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + 1.8);
                            osc.connect(gain);
                            gain.connect(this.ctx.destination);
                            osc.start();
                            osc.stop(this.ctx.currentTime + 1.8);
                        } catch(e){}
                    });
                }, 2000);
            }

            stopBackgroundMusic() {
                if (this.bgTimer) {
                    clearInterval(this.bgTimer);
                    this.bgTimer = null;
                }
            }

            beep(f, d, t = 'square', v = 0.05) {
                if (this.isMuted || !this.ctx) return;
                try {
                    const o = this.ctx.createOscillator(), g = this.ctx.createGain();
                    o.type = t;
                    o.frequency.value = f;
                    g.gain.value = v;
                    o.connect(g);
                    g.connect(this.ctx.destination);
                    o.start();
                    g.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + d);
                    o.stop(this.ctx.currentTime + d);
                } catch(e){}
            }

            toggleMute() {
                this.isMuted = !this.isMuted;
                if (this.isMuted) {
                    this.stopBackgroundMusic();
                } else {
                    this.init();
                }
                return !this.isMuted;
            }
        }

        const juiceAudio = new JuiceAudioEngine();

        function toggleAudio() {
            juiceAudio.init();
            const isOn = juiceAudio.toggleMute();
            document.getElementById('soundIcon').className = isOn ? 'fas fa-volume-up' : 'fas fa-volume-mute';
            document.getElementById('soundText').textContent = isOn ? 'Music: ON' : 'Music: OFF';
        }

        window.addEventListener('click', function() {
            juiceAudio.init();
        }, { once: true });

        // --- Juice Slots Game Engine ---
        const IMG_EXT = 'svg';
        const SVG = new Proxy({}, {
            get: (_, k) => `<img src="${window.JUICE_BASE}images/${k}.${IMG_EXT}" alt="${k}" draggable="false">`
        });
        const KEYS = ['straw', 'ban', 'grape', 'juice', 'cup', 'egg', 'org'];
        const PAY = {
            cup: [20, 100, 500], juice: [15, 75, 300], grape: [8, 30, 120],
            straw: [6, 20, 80], org: [5, 15, 60], ban: [4, 12, 40], egg: [3, 10, 30]
        };
        const WILD = 'juice';
        const NAMES = {
            cup: 'Trophy', juice: 'Juice (wild)', grape: 'Grapes',
            straw: 'Strawberry', org: 'Orange', ban: 'Banana', egg: 'Eggplant'
        };
        const LINES = [
            [1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2],
            [0,0,1,2,2],[2,2,1,0,0],[1,0,0,0,1],[1,2,2,2,1]
        ];
        const LCOL = ['#ffe600','#00e5ff','#7cff3a','#ff4da6','#fff','#b388ff','#ff9100','#00ff9d','#3d5afe'];
        const BETS = [0.10, 0.25, 0.50, 1.00, 2.00, 5.00, 10.00];
        const $ = id => document.getElementById(id);
        const st = {
            credit: window.USER_BALANCE || 5000,
            bet: 0.50,
            lines: 9,
            max: 9,
            spinning: false,
            win: 35,
            big: 10
        };
        let grid = [];

        function fit() {
            const container = $('stage-wrap');
            const availW = container.clientWidth || window.innerWidth;
            const s = Math.min(availW / 1000, 1);
            $('stage').style.transform = `scale(${s})`;
        }
        window.addEventListener('resize', fit);
        fit();

        const reelsEl = $('reels');
        for (let c = 0; c < 5; c++) {
            const r = document.createElement('div');
            r.className = 'reel';
            for (let i = 0; i < 3; i++) {
                r.appendChild(Object.assign(document.createElement('div'), { className: 'cell' }));
            }
            reelsEl.appendChild(r);
        }
        reelsEl.insertAdjacentHTML('beforeend', '<svg id="lines" viewBox="0 0 564 312" preserveAspectRatio="none"></svg>');
        const cellEl = (c, r) => reelsEl.children[c].children[r];
        const rnd = n => Math.floor(Math.random() * n);
        const rsym = () => KEYS[rnd(KEYS.length)];
        function setCell(c, r, k) {
            const e = cellEl(c, r);
            e.innerHTML = SVG[k];
            e.dataset.k = k;
        }
        grid = [...Array(5)].map(() => [rsym(), rsym(), rsym()]);
        grid.forEach((col, c) => col.forEach((k, r) => setCell(c, r, k)));

        const NL = [4,2,8,6,1,7,9,3,5], NR = [4,2,9,6,1,7,8,3,5];
        function drawNums() {
            [['lnL', NL], ['lnR', NR]].forEach(([id, a]) => {
                $(id).innerHTML = a.map(n => `<span class="${n > st.lines ? 'off' : ''}">${n}</span>`).join('');
            });
        }

        function ui() {
            const total = st.bet * st.lines;
            $('cr').textContent = st.credit.toFixed(2);
            $('bxL').textContent = st.lines;
            $('bxB').textContent = st.bet.toFixed(2);
            $('bxT').textContent = 'BET: ' + total.toFixed(2);
            drawNums();
        }
        function msg(t) { $('msg').textContent = t; }

        function evalLine(cells) {
            let base = cells.find(k => k !== WILD) || WILD, n = 0;
            for (const k of cells) {
                if (k === base || k === WILD) n++;
                else break;
            }
            return n >= 3 ? { sym: base, n } : null;
        }
        function evaluate(g) {
            const res = [];
            for (let i = 0; i < st.lines; i++) {
                const p = st.max === 3 ? [[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2]][i] : LINES[i];
                const w = evalLine(p.map((r, c) => g[c][r]));
                if (w) res.push({ line: i, path: p, n: w.n, sym: w.sym, mult: PAY[w.sym][w.n - 3] });
            }
            return res;
        }

        function makeGrid(kind) {
            const mk = () => [...Array(5)].map(() => [rsym(), rsym(), rsym()]);
            let g = mk();
            if (kind === 'lose') {
                for (let t = 0; t < 300 && evaluate(g).length; t++) g = mk();
                return g;
            }
            const bigSet = ['cup', 'juice', 'grape'], smallSet = ['straw', 'org', 'ban', 'egg'];
            const sym = kind === 'big' ? 'cup' : (Math.random() < st.big / 100 ? bigSet[rnd(3)] : smallSet[rnd(4)]);
            const n = kind === 'big' ? 5 : 3 + rnd(3);
            const li = rnd(st.lines), p = st.max === 3 ? [[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2]][li] : LINES[li];
            for (let c = 0; c < n; c++) g[c][p[c]] = sym;
            return g;
        }
        function pickKind() {
            const pre = $('sPre').value;
            if (pre !== 'random') {
                $('sPre').value = 'random';
                return pre;
            }
            if (Math.random() * 100 < st.win) return Math.random() * 100 < st.big ? 'big' : 'win';
            return 'lose';
        }

        function clearWin() {
            document.querySelectorAll('.cell.win').forEach(e => e.classList.remove('win'));
            $('lines').innerHTML = '';
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const isAuth = @auth true @else false @endauth;
        st.credit = @auth {{ auth()->user()->balance }} @else 1000.0 @endauth;

        async function spin() {
            if (st.spinning) return;
            juiceAudio.init();
            const total = +(st.bet * st.lines).toFixed(2);
            if (st.credit + 1e-9 < total) {
                msg('Insufficient Credit');
                juiceAudio.beep(120, 0.3, 'sawtooth');
                return;
            }

            st.spinning = true;
            setBtns(true);
            clearWin();
            msg('');

            let backendResult = null;
            try {
                const response = await fetch('/games/juice-slots/spin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        bet_amount: total,
                        is_demo: !isAuth
                    })
                });
                backendResult = await response.json();
                if (!backendResult.success) {
                    msg(backendResult.message || 'Spin failed');
                    st.spinning = false;
                    setBtns(false);
                    return;
                }
            } catch (err) {
                console.warn('API error fallback', err);
            }

            st.credit = +(st.credit - total).toFixed(2);
            ui();

            $('lever').classList.remove('pull');
            void $('lever').offsetWidth;
            $('lever').classList.add('pull');

            const g = makeGrid(pickKind());
            for (let c = 0; c < 5; c++) {
                const reel = reelsEl.children[c];
                reel.classList.add('spinning');
                const iv = setInterval(() => {
                    for (let r = 0; r < 3; r++) setCell(c, r, rsym());
                }, 70);
                setTimeout(() => {
                    clearInterval(iv);
                    reel.classList.remove('spinning');
                    for (let r = 0; r < 3; r++) {
                        let sym = (backendResult && backendResult.grid && backendResult.grid[c]) ? backendResult.grid[c][r] : g[c][r];
                        setCell(c, r, sym);
                        if (backendResult && backendResult.grid) g[c][r] = sym;
                    }
                    grid[c] = g[c];
                    juiceAudio.beep(220 + c * 40, 0.12);
                    if (c === 4) done(g, total, backendResult);
                }, 700 + c * 350);
            }
        }

        function done(g, total, backendResult) {
            let win = 0;
            if (backendResult && backendResult.grid) {
                win = backendResult.win_amount;
                st.credit = backendResult.balance;
            } else {
                const w = evaluate(g);
                w.forEach(x => { win += x.mult * st.bet; });
                win = +win.toFixed(2);
                if (win > 0) st.credit = +(st.credit + win).toFixed(2);
            }

            if (win > 0) {
                msg('YOU WIN ৳' + win.toFixed(2) + '!');
                [523, 659, 784, 1047].forEach((f, i) => setTimeout(() => juiceAudio.beep(f, 0.18, 'triangle', 0.08), i * 110));
                const svg = $('lines');
                const w = evaluate(g);
                w.forEach(x => {
                    x.path.forEach((r, c) => {
                        if (c < x.n) cellEl(c, r).classList.add('win');
                    });
                    const pts = x.path.slice(0, x.n).map((r, c) => `${c * 112.8 + 56.4},${r * 104 + 52}`).join(' ');
                    svg.insertAdjacentHTML('beforeend', `<polyline points="${pts}" fill="none" stroke="${LCOL[x.line]}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" opacity=".85"/>`);
                });
            } else if (st.credit < st.bet) {
                msg('Game over - please add credits');
            }
            ui();
            st.spinning = false;
            setBtns(false);
        }

        function setBtns(b) {
            ['bLines', 'bBet', 'bMax', 'bSpin'].forEach(i => $(i).disabled = b);
        }

        $('bSpin').onclick = spin;
        $('lever').onclick = spin;
        $('bBet').onclick = () => {
            const i = BETS.findIndex(b => Math.abs(b - st.bet) < 1e-9);
            st.bet = BETS[(i + 1) % BETS.length];
            juiceAudio.beep(400, 0.05);
            ui();
        };
        $('bLines').onclick = () => {
            if (st.max === 3) return;
            st.lines = st.lines % st.max + 1;
            juiceAudio.beep(500, 0.05);
            ui();
        };
        $('bMax').onclick = () => {
            st.bet = BETS[BETS.length - 1];
            st.lines = st.max;
            ui();
            spin();
        };

        // Paytable population
        $('pt').innerHTML = '<tr><th></th><th>x3</th><th>x4</th><th>x5</th></tr>' + KEYS.slice().sort((a, b) => PAY[b][2] - PAY[a][2]).map(k => `<tr><td>${SVG[k]}<br>${NAMES[k]}</td>${PAY[k].map(m => `<td>${m}x</td>`).join('')}</tr>`).join('');

        // Modals
        $('bInfo').onclick = () => $('mInfo').classList.add('on');
        $('gear').onclick = () => $('mSet').classList.add('on');
        document.querySelectorAll('[data-close]').forEach(b => b.onclick = () => b.closest('.modal').classList.remove('on'));
        $('sMode').onchange = e => {
            st.max = +e.target.value;
            st.lines = st.max;
            ui();
        };
        $('sMute').onclick = () => {
            const isOn = toggleAudio();
            $('sMute').textContent = isOn ? 'On' : 'Off';
        };
        $('sWin').oninput = e => {
            st.win = +e.target.value;
            $('vWin').textContent = st.win;
        };
        $('sBig').oninput = e => {
            st.big = +e.target.value;
            $('vBig').textContent = st.big;
        };

        ui();
    </script>
</body>
</html>
