<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Roman Slots - 1xBet Casino</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #080506;
            color: #fff;
            overflow-x: hidden;
            font-family: 'Montserrat', sans-serif;
        }
        .game-viewport {
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: radial-gradient(circle at center, #26110f 0%, #0c0506 70%, #000 100%);
            position: relative;
        }
        .game-top-bar {
            width: 100%;
            max-width: 1170px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 16px;
            margin-bottom: 8px;
            background: rgba(26, 12, 12, 0.85);
            border: 1px solid rgba(218, 165, 32, 0.3);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
        .breadcrumbs {
            font-size: 13px;
            color: #e2b765;
            font-weight: 600;
        }
        .breadcrumbs a {
            color: #e2b765;
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
            background: linear-gradient(135deg, #71150a, #9b1f13);
            border: 1px solid #e2b765;
            color: #ffe9a8;
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
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }
        #stage-container {
            width: 100%;
            max-width: 1170px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #stage {
            position: relative;
            width: min(100vw - 20px, calc((100vh - 150px) * 1170 / 658), 1170px);
            aspect-ratio: 1170 / 658;
            container-type: inline-size;
            background: url("{{ asset('roman-slot/roman-slot/assets/background.jpg') }}") center/100% 100% no-repeat;
            user-select: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8), 0 0 25px rgba(218, 165, 32, 0.25);
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid rgba(218, 165, 32, 0.4);
        }
        .cell {
            position: absolute;
            background: #15121a;
            overflow: hidden;
            transition: filter 0.25s, transform 0.25s;
            border-radius: 4px;
        }
        .cell img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        .cell.win {
            z-index: 3;
            box-shadow: 0 0 1.6cqw 0.4cqw #ffd54a;
            animation: pulseWin 0.5s infinite alternate;
        }
        .cell.dim {
            filter: brightness(0.3);
        }
        .cell.sc {
            z-index: 4;
            box-shadow: 0 0 2.2cqw 0.8cqw #fff;
            animation: scWin 0.45s infinite alternate;
        }
        @keyframes pulseWin {
            to { transform: scale(1.06); }
        }
        @keyframes scWin {
            to { transform: scale(1.1) rotate(-1.5deg); }
        }
        .val {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f3e0b0;
            font: bold 2cqw 'Cinzel', Georgia, serif;
            background: linear-gradient(#71150a, #9b1f13);
            text-shadow: 0 0.1cqw 0.3cqw #000;
            border-radius: 0.4cqw;
            border: 0.15cqw solid rgba(255, 215, 0, 0.4);
        }
        .hit {
            position: absolute;
            cursor: pointer;
            transition: transform 0.1s;
        }
        .hit:active {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0.96);
        }
        #msg {
            position: absolute;
            left: 17.436%;
            top: 82.219%;
            width: 65.214%;
            height: 3.951%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffe9a8;
            font: bold 1.7cqw 'Cinzel', Georgia, serif;
            text-shadow: 0 0.1cqw 0.4cqw #000;
            letter-spacing: 0.05cqw;
        }
        .auto {
            outline: 0.3cqw solid #ffd54a;
            border-radius: 1cqw;
            box-shadow: 0 0 10px #ffd54a;
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
            background: linear-gradient(135deg, #2b110e, #140708);
            border: 2px solid #e2b765;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            padding: 24px;
            color: #ffe9a8;
            box-shadow: 0 10px 35px rgba(0,0,0,0.9);
            position: relative;
        }
        .game-modal-close {
            position: absolute;
            top: 14px;
            right: 16px;
            background: #9b1f13;
            border: 1px solid #e2b765;
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
            border: 1px solid rgba(226, 183, 101, 0.3);
            padding: 8px;
            text-align: center;
        }
        .rules-table th {
            background: #48110b;
            color: #ffd54a;
        }
    </style>
</head>
<body>
    @include('customer.header')

    <div class="game-viewport">
        <!-- Top Breadcrumbs & Sound Bar -->
        <div class="game-top-bar">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}">HOME</a> / <a href="{{ route('dashboard') }}">SLOTS</a> / <span>ROMAN SLOTS</span>
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
                <div class="val" id="tb" style="left:27.179%;top:92.553%;width:6.154%;height:4.103%"></div>
                <div class="val" id="bal" style="left:65.470%;top:92.553%;width:11.453%;height:4.103%"></div>
                <div class="val" id="win" style="left:81.026%;top:92.553%;width:5.983%;height:4.103%"></div>
                <div class="hit" id="minus" style="left:24.274%;top:92.705%;width:1.709%;height:3.647%" title="Decrease Bet"></div>
                <div class="hit" id="plus" style="left:34.188%;top:92.705%;width:1.709%;height:3.647%" title="Increase Bet"></div>
                <div class="hit" id="max" style="left:39.231%;top:91.793%;width:5.641%;height:5.623%" title="Max Bet & Spin"></div>
                <div class="hit" id="spin" style="left:44.701%;top:84.802%;width:10.598%;height:15.198%;border-radius:50%" title="Spin!"></div>
                <div class="hit" id="autob" style="left:55.299%;top:91.793%;width:5.641%;height:5.623%" title="Auto Play"></div>
            </div>
        </div>
    </div>

    <!-- Paytable Modal -->
    <div class="game-modal" id="rulesModal">
        <div class="game-modal-content">
            <button class="game-modal-close" onclick="closeRulesModal()">&times;</button>
            <h3 style="margin-top:0; color:#ffd54a; font-family:'Cinzel',serif;"><i class="fas fa-crown"></i> Roman Slots - Paytable & Multipliers</h3>
            <p style="font-size:13px; color:#e0c9a6;">20 Fixed Paylines. Wins pay from left to right on adjacent reels. Scatter pays anywhere!</p>
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
                    <tr><td>Golden Wild</td><td>15x</td><td>50x</td><td>300x</td></tr>
                    <tr><td>Roman Dagger</td><td>8x</td><td>25x</td><td>100x</td></tr>
                    <tr><td>Imperial Vase</td><td>8x</td><td>25x</td><td>100x</td></tr>
                    <tr><td>Laurel Wreath</td><td>5x</td><td>12x</td><td>50x</td></tr>
                    <tr><td>Gladiator Helmet</td><td>5x</td><td>12x</td><td>50x</td></tr>
                    <tr><td>Lion Coin / Column</td><td>3x</td><td>8x</td><td>30x</td></tr>
                    <tr><td>Altar / Arch Coins</td><td>2x</td><td>5x</td><td>20x</td></tr>
                    <tr><td>Scatter (Eagle/Shield)</td><td>2x Total</td><td>10x Total</td><td>50x Total</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.ROMAN_BASE = "{{ asset('roman-slot/roman-slot') }}/";
        window.USER_BALANCE = {{ Auth::check() ? (float)Auth::user()->balance : 5000.00 }};

        // --- Audio Synthesizer & Sound Engine with Background Music ---
        class RomanAudioEngine {
            constructor() {
                this.ctx = null;
                this.isMuted = false;
                this.bgTimer = null;
                this.bgStep = 0;
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
                // Roman epic ambient harmonic chord progression
                const chords = [
                    [130.81, 164.81, 196.00], // C minor
                    [116.54, 146.83, 174.61], // Bb major
                    [103.83, 130.81, 155.56], // Ab major
                    [123.47, 146.83, 185.00]  // G dominant
                ];
                let chordIdx = 0;
                this.bgTimer = setInterval(() => {
                    if (this.isMuted || !this.ctx) return;
                    const chord = chords[chordIdx % chords.length];
                    chordIdx++;
                    chord.forEach((freq, i) => {
                        try {
                            const osc = this.ctx.createOscillator();
                            const gain = this.ctx.createGain();
                            osc.type = i === 0 ? 'sawtooth' : 'triangle';
                            osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                            gain.gain.setValueAtTime(0.018, this.ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + 3.8);
                            osc.connect(gain);
                            gain.connect(this.ctx.destination);
                            osc.start();
                            osc.stop(this.ctx.currentTime + 3.8);
                        } catch(e){}
                    });
                }, 4000);
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
                    osc.frequency.setValueAtTime(600, this.ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(200, this.ctx.currentTime + 0.05);
                    gain.gain.setValueAtTime(0.15, this.ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0, this.ctx.currentTime + 0.05);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    osc.stop(this.ctx.currentTime + 0.05);
                } catch(e){}
            }

            playReelStep() {
                if (this.isMuted || !this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(180, this.ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(70, this.ctx.currentTime + 0.08);
                    gain.gain.setValueAtTime(0.12, this.ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0, this.ctx.currentTime + 0.08);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    osc.stop(this.ctx.currentTime + 0.08);
                } catch(e){}
            }

            playWin(isBig) {
                if (this.isMuted || !this.ctx) return;
                const notes = isBig ? [440, 554, 659, 880, 1108] : [440, 554, 659, 880];
                notes.forEach((freq, idx) => {
                    setTimeout(() => {
                        if (this.isMuted || !this.ctx) return;
                        try {
                            const osc = this.ctx.createOscillator();
                            const gain = this.ctx.createGain();
                            osc.type = 'sine';
                            osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                            gain.gain.setValueAtTime(0.25, this.ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + 0.35);
                            osc.connect(gain);
                            gain.connect(this.ctx.destination);
                            osc.start();
                            osc.stop(this.ctx.currentTime + 0.35);
                        } catch(e){}
                    }, idx * 100);
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

        const romanAudio = new RomanAudioEngine();

        function toggleAudio() {
            romanAudio.init();
            const isOn = romanAudio.toggleMute();
            document.getElementById('soundIcon').className = isOn ? 'fas fa-volume-up' : 'fas fa-volume-mute';
            document.getElementById('soundText').textContent = isOn ? 'Music: ON' : 'Music: OFF';
        }

        function openRulesModal() {
            document.getElementById('rulesModal').classList.add('active');
        }
        function closeRulesModal() {
            document.getElementById('rulesModal').classList.remove('active');
        }

        // Initialize audio on first click anywhere
        window.addEventListener('click', function() {
            romanAudio.init();
        }, { once: true });

        // --- Game Logic Engine ---
        const IMG = {
            S: window.ROMAN_BASE + "assets/scatter.jpg",
            A: window.ROMAN_BASE + "assets/coin-arch.jpg",
            V: window.ROMAN_BASE + "assets/vase.jpg",
            W: window.ROMAN_BASE + "assets/wild.jpg",
            F: window.ROMAN_BASE + "assets/coin-altar.jpg",
            K: window.ROMAN_BASE + "assets/coin-column.jpg",
            H: window.ROMAN_BASE + "assets/helmet.jpg",
            L: window.ROMAN_BASE + "assets/wreath.jpg",
            N: window.ROMAN_BASE + "assets/coin-lion.jpg",
            D: window.ROMAN_BASE + "assets/dagger.jpg"
        };
        const W0 = 1170, H0 = 658;
        const x0 = 204, y0 = 147, cw = 152.6, ch = 130.0;
        const BAG = 'KKKAAAFFFNNNHHLLVVDDWSS'.split('');
        const PAY = {
            K: [0,0,2,5,20], F: [0,0,2,5,20], A: [0,0,3,8,30],
            N: [0,0,3,8,30], H: [0,0,5,12,50], L: [0,0,5,12,50],
            V: [0,0,8,25,100], D: [0,0,8,25,100], W: [0,0,15,50,300]
        };
        const SCATTER = [0,0,0,2,10,50];
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
                d.style.cssText = `left:${(x0+c*cw+1)/W0*100}%;top:${(y0+r*ch+1)/H0*100}%;width:${(cw-2)/W0*100}%;height:${(ch-2)/H0*100}%`;
                d.innerHTML = '<img>';
                st.appendChild(d);
                cells.push(d);
                grid[r].push(rnd());
            }
        }

        const draw = (r,c) => { cells[r*5+c].firstChild.src = IMG[grid[r][c]]; };
        const all = () => { for (let r = 0; r < 3; r++) for (let c = 0; c < 5; c++) draw(r,c); };
        const ui = () => {
            $('tb').textContent = bet;
            $('bal').textContent = (typeof bal === 'number') ? bal.toFixed(2) : bal;
        };
        all();
        ui();
        $('win').textContent = '0.00';

        const clr = () => cells.forEach(d => d.className = 'cell');

        function evaluate() {
            let total = 0;
            const hit = new Set(), lb = bet / 20;
            LINES.forEach(L => {
                const line = L.map((r,c) => grid[r][c]);
                const t = line.find(x => x !== 'W') || 'W';
                if (t === 'S') return;
                let n = 0;
                while (n < 5 && (line[n] === t || line[n] === 'W')) n++;
                if (n >= 3) {
                    total += PAY[t][n-1] * lb;
                    for (let i = 0; i < n; i++) hit.add(L[i]*5 + i);
                }
            });
            const sc = [];
            grid.forEach((row,r) => row.forEach((s,c) => { if (s === 'S') sc.push(r*5+c); }));
            let extra = '', scWin = false;
            if (sc.length >= 3) {
                total += bet * SCATTER[Math.min(sc.length, 5)];
                extra = ' Scatter x' + sc.length + '!';
                scWin = true;
                sc.forEach(i => hit.add(i));
            }
            return { total, hit, extra, scWin, sc };
        }

        function spin() {
            if (busy) return;
            romanAudio.init();
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
                romanAudio.playReelStep();
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
                    romanAudio.playReelStep();
                    for (let r = 0; r < 3; r++) {
                        grid[r][c] = rnd();
                        draw(r, c);
                    }
                    if (c === 4) {
                        clearInterval(iv);
                        const e = evaluate();
                        if (e.hit.size) {
                            cells.forEach((d, i) => d.classList.add(e.hit.has(i) ? (e.scWin && e.sc.includes(i) ? 'sc' : 'win') : 'dim'));
                        }
                        bal += e.total;
                        ui();
                        $('win').textContent = e.total.toFixed(2);
                        if (e.total > 0) {
                            romanAudio.playWin(e.total >= bet * 5);
                            $('msg').textContent = 'WIN ' + e.total.toFixed(2) + e.extra;
                        }
                        busy = false;
                        if (auto) setTimeout(spin, e.total ? 2200 : 1200);
                    }
                }, 600 + c * 350);
            }
        }

        const setBet = v => {
            romanAudio.playClick();
            bet = Math.max(1, Math.min(5000, v));
            ui();
        };

        $('spin').onclick = spin;
        $('plus').onclick = () => setBet(bet + 5);
        $('minus').onclick = () => setBet(bet - 5);
        $('max').onclick = () => { setBet(100); spin(); };
        $('autob').onclick = () => {
            romanAudio.playClick();
            auto = !auto;
            $('autob').classList.toggle('auto', auto);
            if (auto) spin();
        };
    </script>
</body>
</html>
