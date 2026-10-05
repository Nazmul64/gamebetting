<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Easter Slot - 1xBet Casino</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #071507;
            color: #fff;
            overflow-x: hidden;
            font-family: 'Outfit', sans-serif;
        }
        .game-viewport {
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: radial-gradient(circle at center, #0f2b0f 0%, #061406 70%, #000 100%);
            position: relative;
        }
        .game-top-bar {
            width: 100%;
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 16px;
            margin-bottom: 8px;
            background: rgba(14, 38, 14, 0.85);
            border: 1px solid rgba(94, 209, 90, 0.4);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
        .breadcrumbs {
            font-size: 13px;
            color: #7ef279;
            font-weight: 600;
        }
        .breadcrumbs a {
            color: #7ef279;
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
        .sound-toggle-btn, .info-btn {
            background: linear-gradient(135deg, #1f8a2c, #145e1d);
            border: 1px solid #7ef279;
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
        .sound-toggle-btn:hover, .info-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(126, 242, 121, 0.5);
        }
        #stage-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #stage {
            position: relative;
            width: min(100vw - 20px, calc((100vh - 150px) * 1892 / 849), 1200px);
            aspect-ratio: 1892 / 849;
            container-type: inline-size;
            background: url("{{ asset('easter-slot/easter-slot/assets/background.jpg') }}") center/100% 100% no-repeat;
            user-select: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8), 0 0 25px rgba(94, 209, 90, 0.3);
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid rgba(94, 209, 90, 0.4);
        }
        .cell {
            position: absolute;
            background: #16121a;
            border-radius: 0.5cqw;
            overflow: hidden;
            transition: opacity 0.25s, transform 0.25s;
        }
        .cell img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        .cell.win {
            box-shadow: 0 0 1.6cqw 0.5cqw #ffe14d;
            z-index: 3;
            animation: pEaster 0.5s infinite alternate;
        }
        .cell.dim {
            opacity: 0.3;
        }
        .cell.sc {
            animation: scEaster 0.45s infinite alternate;
            box-shadow: 0 0 2cqw 0.8cqw #fff;
            z-index: 4;
        }
        @keyframes pEaster {
            to { transform: scale(1.06); }
        }
        @keyframes scEaster {
            to { transform: scale(1.12) rotate(-2deg); }
        }
        .val {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font: bold 2.3cqw 'Outfit', Georgia, serif;
            background: linear-gradient(#5ed15a, #1f8a2c);
            border-radius: 2cqw;
            text-shadow: 0 0.1cqw 0.3cqw #063;
            border: 0.15cqw solid rgba(255,255,255,0.4);
        }
        .hit {
            position: absolute;
            cursor: pointer;
            border-radius: 50%;
            transition: transform 0.1s;
        }
        .hit:active {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0.95);
        }
        #msg {
            position: absolute;
            top: 5.2%;
            left: 35%;
            width: 30%;
            height: 4.5%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            font: bold 1.6cqw 'Outfit', Georgia, serif;
            text-shadow: 0 0.1cqw 0.4cqw #000;
        }
        .auto {
            outline: 0.3cqw solid #ffe14d;
            border-radius: 2cqw;
            box-shadow: 0 0 12px #ffe14d;
        }
        /* Paytable Rules Modal */
        .game-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 16px;
        }
        .game-modal.active {
            display: flex;
        }
        .game-modal-content {
            background: linear-gradient(135deg, #133313, #081a08);
            border: 2px solid #5ed15a;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            padding: 24px;
            color: #e5ffe5;
            box-shadow: 0 10px 35px rgba(0,0,0,0.9);
            position: relative;
        }
        .game-modal-close {
            position: absolute;
            top: 14px;
            right: 16px;
            background: #1f8a2c;
            border: 1px solid #7ef279;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rules-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            font-size: 13px;
        }
        .rules-table th, .rules-table td {
            border: 1px solid rgba(94, 209, 90, 0.3);
            padding: 8px;
            text-align: center;
        }
        .rules-table th {
            background: #1a521a;
            color: #ffe14d;
        }
    </style>
</head>
<body>
    @include('customer.header')

    <div class="game-viewport">
        <!-- Top Breadcrumbs & Sound Bar -->
        <div class="game-top-bar">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">HOME</a> / <a href="{{ route('dashboard') }}">SLOTS</a> / <span>EASTER SLOTS</span>
            </div>
            <div class="top-controls">
                <button class="sound-toggle-btn" id="soundBtn" onclick="toggleAudio()">
                    <i class="fas fa-volume-up" id="soundIcon"></i> <span id="soundText">Music: ON</span>
                </button>
                <button class="info-btn" onclick="openRulesModal()">
                    <i class="fas fa-info-circle"></i> Paytable
                </button>
            </div>
        </div>

        <!-- Slot Game Canvas Stage -->
        <div id="stage-container">
            <div id="stage">
                <div id="msg"></div>
                <div class="val" id="tb" style="left:31.2%;top:90.6%;width:5.6%;height:5.6%"></div>
                <div class="val" id="bal" style="left:60.9%;top:90.7%;width:9.6%;height:5.6%"></div>
                <div class="val" id="win" style="left:74.8%;top:90.7%;width:7%;height:5.6%"></div>
                <div class="hit" id="minus" style="left:28.9%;top:91.3%;width:2.1%;height:4.4%" title="Decrease Bet"></div>
                <div class="hit" id="plus" style="left:36.7%;top:91.3%;width:2.1%;height:4.4%" title="Increase Bet"></div>
                <div class="hit" id="max" style="left:41.2%;top:90.5%;width:5.4%;height:6.5%;border-radius:2cqw" title="Max Bet & Spin"></div>
                <div class="hit" id="spin" style="left:46.4%;top:87.5%;width:7.2%;height:12.5%" title="Spin!"></div>
                <div class="hit" id="autob" style="left:53.6%;top:90.5%;width:5.4%;height:6.5%;border-radius:2cqw" title="Auto Play"></div>
            </div>
        </div>
    </div>

    <!-- Paytable Modal -->
    <div class="game-modal" id="rulesModal">
        <div class="game-modal-content">
            <button class="game-modal-close" onclick="closeRulesModal()">&times;</button>
            <h3 style="margin-top:0; color:#ffe14d;"><i class="fas fa-egg"></i> Easter Slots - Paytable & Bonuses</h3>
            <p style="font-size:13px; color:#d2ffd2;">20 Fixed Paylines. Match symbols from left to right. Easter Bunny is Wild!</p>
            <table class="rules-table">
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>3 in a line</th>
                        <th>4 in a line</th>
                        <th>5 in a line</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Easter Bunny (Wild)</td><td>10x</td><td>40x</td><td>200x</td></tr>
                    <tr><td>Golden Egg</td><td>8x</td><td>25x</td><td>100x</td></tr>
                    <tr><td>Purple Egg</td><td>5x</td><td>15x</td><td>50x</td></tr>
                    <tr><td>Blue / Red Egg</td><td>4x</td><td>12x</td><td>40x</td></tr>
                    <tr><td>Queen (Q)</td><td>2x</td><td>5x</td><td>20x</td></tr>
                    <tr><td>Jack (J)</td><td>2x</td><td>5x</td><td>15x</td></tr>
                    <tr><td>Easter Basket (Bonus)</td><td colspan="3">3+ triggers Bonus Reward (5x Total Bet)</td></tr>
                    <tr><td>Easter Chick (Scatter)</td><td colspan="3">3+ Scatters pay up to 50x Total Bet</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.EASTER_BASE = "{{ asset('easter-slot/easter-slot') }}/";
        window.USER_BALANCE = {{ Auth::check() ? (float)Auth::user()->balance : 5000.00 }};

        // --- Easter Whimsical Audio Synthesizer Engine ---
        class EasterAudioEngine {
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
                // Cheerful Spring Major pentatonic arpeggios
                const notes = [261.63, 293.66, 329.63, 392.00, 440.00, 523.25];
                let step = 0;
                this.bgTimer = setInterval(() => {
                    if (this.isMuted || !this.ctx) return;
                    const freq = notes[step % notes.length];
                    step++;
                    try {
                        const osc = this.ctx.createOscillator();
                        const gain = this.ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                        gain.gain.setValueAtTime(0.02, this.ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + 1.2);
                        osc.connect(gain);
                        gain.connect(this.ctx.destination);
                        osc.start();
                        osc.stop(this.ctx.currentTime + 1.2);
                    } catch(e){}
                }, 1200);
            }

            stopBackgroundMusic() {
                if (this.bgTimer) {
                    clearInterval(this.bgTimer);
                    this.bgTimer = null;
                }
            }

            playClick() {
                if (this.isMuted || !this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(750, this.ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(350, this.ctx.currentTime + 0.06);
                    gain.gain.setValueAtTime(0.15, this.ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0, this.ctx.currentTime + 0.06);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    osc.stop(this.ctx.currentTime + 0.06);
                } catch(e){}
            }

            playReelStep() {
                if (this.isMuted || !this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(220, this.ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(90, this.ctx.currentTime + 0.07);
                    gain.gain.setValueAtTime(0.1, this.ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0, this.ctx.currentTime + 0.07);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    osc.stop(this.ctx.currentTime + 0.07);
                } catch(e){}
            }

            playWin(isBig) {
                if (this.isMuted || !this.ctx) return;
                const notes = isBig ? [523, 659, 784, 1047, 1318] : [523, 659, 784, 1047];
                notes.forEach((freq, idx) => {
                    setTimeout(() => {
                        if (this.isMuted || !this.ctx) return;
                        try {
                            const osc = this.ctx.createOscillator();
                            const gain = this.ctx.createGain();
                            osc.type = 'triangle';
                            osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                            gain.gain.setValueAtTime(0.22, this.ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + 0.3);
                            osc.connect(gain);
                            gain.connect(this.ctx.destination);
                            osc.start();
                            osc.stop(this.ctx.currentTime + 0.3);
                        } catch(e){}
                    }, idx * 90);
                });
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

        const easterAudio = new EasterAudioEngine();

        function toggleAudio() {
            easterAudio.init();
            const isOn = easterAudio.toggleMute();
            document.getElementById('soundIcon').className = isOn ? 'fas fa-volume-up' : 'fas fa-volume-mute';
            document.getElementById('soundText').textContent = isOn ? 'Music: ON' : 'Music: OFF';
        }

        function openRulesModal() {
            document.getElementById('rulesModal').classList.add('active');
        }
        function closeRulesModal() {
            document.getElementById('rulesModal').classList.remove('active');
        }

        window.addEventListener('click', function() {
            easterAudio.init();
        }, { once: true });

        // --- Easter Slot Game Logic ---
        const IMG = {
            Q: window.EASTER_BASE + "assets/queen.jpg",
            J: window.EASTER_BASE + "assets/jack.jpg",
            U: window.EASTER_BASE + "assets/egg-blue.jpg",
            R: window.EASTER_BASE + "assets/egg-red.jpg",
            P: window.EASTER_BASE + "assets/egg-purple.jpg",
            G: window.EASTER_BASE + "assets/egg-gold.jpg",
            B: window.EASTER_BASE + "assets/bonus.jpg",
            W: window.EASTER_BASE + "assets/wild.jpg",
            C: window.EASTER_BASE + "assets/scatter.jpg"
        };
        const W0 = 1892, H0 = 849;
        const xs = [491, 677, 863, 1049, 1236], ys = [218, 383, 548], cw = 170, ch = 148;
        const BAG = 'QQQJJJRRRUUUPPGGWBBC'.split('');
        const PAY = {
            Q: [0,0,2,5,20], J: [0,0,2,5,15], R: [0,0,4,12,40],
            U: [0,0,4,12,40], P: [0,0,5,15,50], G: [0,0,8,25,100],
            W: [0,0,10,40,200]
        };
        const LINES = [
            [1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2],
            [0,0,1,2,2],[2,2,1,0,0],[1,0,0,0,1],[1,2,2,2,1],[0,1,1,1,0],
            [2,1,1,1,2],[1,0,1,2,1],[1,2,1,0,1],[0,1,0,1,0],[2,1,2,1,2],
            [1,1,0,1,1],[1,1,2,1,1],[0,0,2,0,0],[2,2,0,2,2],[0,2,2,2,0]
        ];

        const $ = id => document.getElementById(id);
        const st = $('stage');
        let bet = 20, bal = window.USER_BALANCE || 5000, busy = false, auto = false, grid = [], cells = [];
        const rnd = () => BAG[Math.random() * BAG.length | 0];

        for (let r = 0; r < 3; r++) {
            grid.push([]);
            for (let c = 0; c < 5; c++) {
                const d = document.createElement('div');
                d.className = 'cell';
                d.style.cssText = `left:${(xs[c]+3)/W0*100}%;top:${(ys[r]+3)/H0*100}%;width:${(cw-6)/W0*100}%;height:${(ch-6)/H0*100}%`;
                d.innerHTML = '<img>';
                st.appendChild(d);
                cells.push(d);
                grid[r].push(rnd());
            }
        }

        function draw(r,c) { cells[r*5+c].firstChild.src = IMG[grid[r][c]]; }
        function all() { for (let r = 0; r < 3; r++) for (let c = 0; c < 5; c++) draw(r,c); }
        function ui() {
            $('tb').textContent = bet;
            $('bal').textContent = (typeof bal === 'number') ? bal.toFixed(2) : bal;
        }
        all();
        ui();
        $('win').textContent = '0.00';

        function clr() { cells.forEach(d => d.className = 'cell'); }

        function evaluate() {
            let total = 0;
            const hit = new Set(), lb = bet / 20;
            LINES.forEach(L => {
                const line = L.map((r,c) => grid[r][c]);
                const t = line.find(x => x !== 'W') || 'W';
                if (t === 'B' || t === 'C') return;
                let n = 0;
                while (n < 5 && (line[n] === t || line[n] === 'W')) n++;
                if (n >= 3) {
                    total += PAY[t][n-1] * lb;
                    for (let i = 0; i < n; i++) hit.add(L[i]*5 + i);
                }
            });
            const sc = [], bo = [];
            grid.forEach((row,r) => row.forEach((s,c) => {
                if (s === 'C') sc.push(r*5 + c);
                if (s === 'B') bo.push(r*5 + c);
            }));
            let extra = '', scWin = false;
            if (sc.length >= 3) {
                total += bet * [0,0,0,2,10,50][Math.min(sc.length, 5)];
                extra += ' Scatter x' + sc.length + '!';
                scWin = true;
                sc.forEach(i => hit.add(i));
            }
            if (bo.length >= 3) {
                total += bet * 5;
                extra += ' Bonus x' + bo.length + '!';
                bo.forEach(i => hit.add(i));
            }
            return { total, hit, extra, scWin, sc };
        }

        function spin() {
            if (busy) return;
            easterAudio.init();
            if (bal < bet) {
                $('msg').textContent = 'Insufficient Balance';
                auto = false;
                $('autob').classList.remove('auto');
                return;
            }
            busy = true;
            bal -= bet;
            ui();
            $('win').textContent = '0.00';
            $('msg').textContent = '';
            clr();

            const stop = [0,0,0,0,0];
            const iv = setInterval(() => {
                easterAudio.playReelStep();
                for (let c = 0; c < 5; c++) {
                    if (!stop[c]) {
                        for (let r = 0; r < 3; r++) {
                            grid[r][c] = rnd();
                            draw(r, c);
                        }
                    }
                }
            }, 70);

            for (let c = 0; c < 5; c++) {
                setTimeout(() => {
                    stop[c] = 1;
                    easterAudio.playReelStep();
                    for (let r = 0; r < 3; r++) {
                        grid[r][c] = rnd();
                        draw(r, c);
                    }
                    if (c === 4) {
                        clearInterval(iv);
                        const e = evaluate();
                        if (e.total > 0 || e.hit.size) {
                            cells.forEach((d, i) => {
                                if (e.hit.has(i)) d.classList.add(e.scWin && e.sc.includes(i) ? 'sc' : 'win');
                                else d.classList.add('dim');
                            });
                        }
                        bal += e.total;
                        ui();
                        $('win').textContent = e.total.toFixed(2);
                        if (e.total > 0) {
                            easterAudio.playWin(e.total >= bet * 5);
                            $('msg').textContent = 'WIN ' + e.total.toFixed(2) + e.extra;
                        }
                        busy = false;
                        if (auto) setTimeout(spin, e.total ? 2200 : 1200);
                    }
                }, 600 + c * 350);
            }
        }

        const setBet = v => {
            easterAudio.playClick();
            bet = Math.max(1, Math.min(2000, v));
            ui();
        };

        $('spin').onclick = spin;
        $('plus').onclick = () => setBet(bet + 5);
        $('minus').onclick = () => setBet(bet - 5);
        $('max').onclick = () => { setBet(100); spin(); };
        $('autob').onclick = () => {
            easterAudio.playClick();
            auto = !auto;
            $('autob').classList.toggle('auto', auto);
            if (auto) spin();
        };
    </script>
</body>
</html>
