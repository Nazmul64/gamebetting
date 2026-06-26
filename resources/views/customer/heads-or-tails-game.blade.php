<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>1xBet — Heads or Tails Fixed Stake</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('game.css') }}">
    <style>
        .game-screen-container {
            position: relative;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            min-height: 350px;
            flex: 1;
        }
        .game-screen-container canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 5;
        }
        .banner-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            text-align: center;
            min-height: 22px;
            transition: color 0.3s;
            margin-bottom: 16px;
            z-index: 10;
        }
        .banner-text.win { color: var(--color-green); }
        .banner-text.lose { color: var(--color-red); }

        .main-coin {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: radial-gradient(circle at 34% 27%, #fffae0 0%, #f6c520 45%, #d4900a 75%, #a05808 100%);
            border: 5px solid #9a5808;
            box-shadow: 0 0 0 4px rgba(255,200,40,0.3), 0 0 0 8px rgba(200,140,20,0.1), 0 15px 40px rgba(0,0,0,0.5), inset 0 -10px 20px rgba(0,0,0,0.3), inset 0 8px 14px rgba(255,248,180,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-main);
            font-size: 40px;
            font-weight: 800;
            color: #5a2800;
            position: relative;
            user-select: none;
            z-index: 10;
        }
        .main-coin::before {
            content: '';
            position: absolute;
            inset: 9px;
            border-radius: 50%;
            border: 3px dashed rgba(90,40,0,0.2);
        }
        .main-coin::after {
            content: '';
            position: absolute;
            top: 16px; left: 24px;
            width: 34px; height: 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: rotate(-32deg);
        }
        .main-coin.flip-anim {
            animation: coinFlip 1.5s ease-in-out forwards;
        }
        @keyframes coinFlip {
            0% { transform: translateY(0) rotateY(0); }
            20% { transform: translateY(-30px) rotateY(90deg); }
            40% { transform: translateY(-60px) rotateY(180deg); }
            60% { transform: translateY(-40px) rotateY(270deg); }
            80% { transform: translateY(-15px) rotateY(330deg); }
            100% { transform: translateY(0) rotateY(360deg); }
        }

        .side-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        .side-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 0;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background: var(--bg-control);
            color: var(--text-secondary);
            font-family: var(--font-main);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            letter-spacing: 0.5px;
        }
        .side-btn:hover { border-color: var(--border-hover); color: var(--text-primary); }
        .side-btn.active-heads {
            border-color: var(--color-orange);
            background: rgba(240,100,36,0.15);
            color: var(--color-orange);
        }
        .side-btn.active-tails {
            border-color: var(--color-purple);
            background: rgba(89,38,236,0.15);
            color: #713eff;
        }
        .side-btn .coin-small {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: radial-gradient(circle at 34% 27%, #fffae0, #f6c520 45%, #d4900a 75%, #a05808);
            border: 2px solid #9a5808;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 700;
            color: #5a2800;
        }

        .result-badge {
            font-size: 20px;
            font-weight: 800;
            min-height: 28px;
            transition: all 0.3s;
            margin-top: 8px;
            z-index: 10;
        }
        .result-badge.win { color: var(--color-green); }
        .result-badge.lose { color: var(--color-red); }
        .result-badge.hidden { opacity: 0; }

        .collect-btn {
            background: var(--color-gold);
            color: #000000;
            border: none;
            border-radius: var(--border-radius-sm);
            height: 40px;
            font-family: var(--font-main);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: none;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }
        .collect-btn:hover { filter: brightness(1.1); }
        .collect-btn:active { transform: scale(0.98); }
        .collect-btn.show { display: flex; }
    </style>
</head>
<body class="game-body-bg {{ auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
    <div class="game-wrapper">
        <header class="game-header">
            <div class="header-left">
                <span class="logo-text">1XGAMES</span>
                <span class="separator">/</span>
                <span class="sub-logo-text">HEADS OR TAILS</span>
                <span class="separator">/</span>
                <span class="active-page">FIXED STAKE</span>
            </div>
            <div class="header-right">
                <div class="user-info-header" style="margin-right:16px;display:flex;flex-direction:column;align-items:flex-end;justify-content:center;height:36px;line-height:1.2;">
                    <span class="user-header-name" id="user-header-name" style="font-weight:700;color:#fff;font-size:12px;">{{ auth()->user()->name }}</span>
                    <div style="display:flex;gap:8px;margin-top:2px;">
                        <a href="{{ route('dashboard') }}" style="font-size:10px;color:var(--color-gold);text-decoration:none;font-weight:700;letter-spacing:.5px;transition:color .2s;">DASHBOARD</a>
                        <span style="color:var(--text-muted);font-size:10px;">|</span>
                        <a href="{{ route('gems-mines') }}" style="font-size:10px;color:#ffbe1a;text-decoration:none;font-weight:700;letter-spacing:.5px;transition:color .2s;"><i class="fas fa-gem" style="font-size:9px;"></i> GEMS & MINES</a>
                        <span style="color:var(--text-muted);font-size:10px;">|</span>
                        <a href="{{ route('big-bass-splash') }}" style="font-size:10px;color:#38ef7d;text-decoration:none;font-weight:700;letter-spacing:.5px;transition:color .2s;"><i class="fas fa-fish" style="font-size:9px;"></i> BIG BASS SPLASH</a>
                        <span style="color:var(--text-muted);font-size:10px;">|</span>
                        <a href="#" id="game-theme-toggle" onclick="toggleGameTheme(event)" style="font-size:10px;color:var(--accent-blue);text-decoration:none;font-weight:700;letter-spacing:.5px;transition:color .2s;cursor:pointer;">THEME</a>
                        <span style="color:var(--text-muted);font-size:10px;">|</span>
                        <a href="#" id="header-logout-btn" style="font-size:10px;color:var(--color-red);text-decoration:none;font-weight:700;letter-spacing:.5px;transition:color .2s;">LOGOUT</a>
                    </div>
                </div>
                <div class="balance-container">
                    <span class="balance-label">BALANCE:</span>
                    <span class="balance-value" id="user-balance">{{ number_format(auth()->user()->balance, 2, '.', '') }}</span>
                    <span class="balance-currency" id="user-currency">{{ auth()->user()->currency }}</span>
                </div>
                <button class="deposit-btn"><i class="fas fa-plus-circle"></i> DEPOSIT</button>
            </div>
        </header>

        <div class="main-layout-container">
            <div class="main-layout">
                <aside class="live-bets-panel">
                    <div class="stats-summary-box">
                        <div class="stat-item">
                            <span class="stat-title">Number of bets</span>
                            <span class="stat-value"><i class="fas fa-users icon-small"></i> <span id="live-bets-count">0</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-title">Total bets</span>
                            <span class="stat-value"><i class="fas fa-wallet icon-small"></i> <span id="live-total-bet-amount">0.00 {{ auth()->user()->currency }}</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-title">Total winnings</span>
                            <span class="stat-value"><i class="fas fa-trophy icon-small"></i> <span id="live-total-winnings-amount">0.00 {{ auth()->user()->currency }}</span></span>
                        </div>
                    </div>
                    <div class="table-header-row">
                        <span>RESULT</span>
                        <span>SIDE</span>
                        <span>AMOUNT</span>
                    </div>
                    <div class="bets-list" id="bets-list-container">
                        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;padding:40px 20px;text-align:center;color:var(--text-muted);">
                            <i class="fas fa-history" style="font-size:32px;margin-bottom:8px;opacity:0.4;"></i>
                            <span style="font-size:11px;">No rounds played yet</span>
                        </div>
                    </div>
                </aside>

                <div class="center-right-container">
                    <main class="dashboard-area">
                        <div class="history-badges-wrapper">
                            <div class="history-badges-container" id="history-badges-container">
                                <span style="color:var(--text-muted);font-size:11px;">Coin Flip · Fixed Stake</span>
                            </div>
                            <button class="history-arrow-btn" id="history-details-btn">
                                <i class="fas fa-history"></i>
                            </button>
                        </div>

                        <div class="game-screen-container" id="scene">
                            <canvas id="fxCanvas"></canvas>
                            <div class="banner-text" id="bannerText" style="z-index:10;">Choose your side! Heads or Tails?</div>
                            <div class="main-coin" id="mainCoin" style="z-index:10;"><span id="coinVal">10</span></div>
                            <div class="result-badge hidden" id="resultBadge"></div>
                        </div>

                        <section class="personal-history-section">
                            <div class="history-section-header">
                                <div class="header-tab active"><i class="fas fa-history"></i> LAST RESULT</div>
                            </div>
                            <div class="history-table-container">
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 16px;">
                                    <span style="color:var(--text-secondary);font-size:11px;" id="lastResult">Ready to play</span>
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <span style="font-size:10px;color:var(--text-muted);font-weight:600;" id="modeLabel">DEMO MODE</span>
                                        <div id="modeToggle" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                            <span style="font-size:10px;font-weight:700;color:var(--text-secondary);letter-spacing:0.5px;" id="modeLbl">DEMO</span>
                                            <div style="width:36px;height:18px;background:var(--bg-control);border:1px solid var(--border-color);border-radius:10px;position:relative;transition:all 0.2s;">
                                                <div id="modeDot" style="width:12px;height:12px;background:var(--color-gold);border-radius:50%;position:absolute;top:2px;left:2px;transition:left 0.2s;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </main>

                    <aside class="betting-controls-column">
                        <div class="betting-board" id="bet-panel-1">
                            <div class="board-content">
                                <div class="bet-input-row">
                                    <div class="input-wrapper">
                                        <input type="number" class="bet-amount-input" id="bet-amount-1" value="10" min="1" step="1">
                                        <span class="currency-label">{{ auth()->user()->currency }}</span>
                                        <button class="clear-input-btn" id="clear-bet-1"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="quick-bets-grid">
                                    <button class="quick-btn" data-value="5">5</button>
                                    <button class="quick-btn" data-value="10">10</button>
                                    <button class="quick-btn" data-value="25">25</button>
                                    <button class="quick-btn" data-value="50">50</button>
                                    <button class="quick-btn" data-value="100">100</button>
                                    <button class="quick-btn" data-value="500">500</button>
                                </div>
                                <div class="side-selector" style="margin-top:6px;">
                                    <button class="side-btn active-heads" id="headsBtn"><div class="coin-small">✿</div> HEADS</button>
                                    <button class="side-btn" id="tailsBtn">TAILS <div class="coin-small">10</div></button>
                                </div>
                                <button class="place-bet-btn btn-orange" id="bet-btn-1" style="margin-top:6px;">
                                    <span class="btn-primary-text">FLIP COIN</span>
                                    <span class="btn-secondary-text">(10 {{ auth()->user()->currency }})</span>
                                </button>
                                <button class="collect-btn" id="collectBtn">
                                    <i class="fas fa-hand-holding-usd"></i> COLLECT WINNINGS
                                </button>
                            </div>
                        </div>

                        <div class="betting-board" id="bet-panel-2">
                            <div class="board-content">
                                <div class="bet-input-row">
                                    <div class="input-wrapper">
                                        <input type="number" class="bet-amount-input" id="bet-amount-2" value="10" min="1" step="1">
                                        <span class="currency-label">{{ auth()->user()->currency }}</span>
                                        <button class="clear-input-btn" id="clear-bet-2"><i class="fas fa-times"></i></button>
                                    </div>
                                    <button class="enable-autoplay-btn" id="autoplay-btn-2">ENABLE AUTOPLAY</button>
                                </div>
                                <div class="quick-bets-grid">
                                    <button class="quick-btn" data-value="5">5</button>
                                    <button class="quick-btn" data-value="10">10</button>
                                    <button class="quick-btn" data-value="25">25</button>
                                    <button class="quick-btn" data-value="50">50</button>
                                    <button class="quick-btn" data-value="100">100</button>
                                    <button class="quick-btn" data-value="500">500</button>
                                </div>
                                <button class="place-bet-btn btn-orange" id="bet-btn-2">
                                    <span class="btn-primary-text">PLACE A BET</span>
                                    <span class="btn-secondary-text">(on the next round)</span>
                                </button>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <aside class="right-toolbar-sidebar">
                <button class="toolbar-icon-btn" title="Settings"><i class="fas fa-cog"></i></button>
                <button class="toolbar-icon-btn" title="Gifts"><i class="fas fa-gift"></i></button>
                <button class="toolbar-icon-btn active" title="Round History">7</button>
                <button class="toolbar-icon-btn" id="sound-toggle" title="Toggle Sound"><i class="fas fa-volume-up"></i></button>
                <button class="toolbar-icon-btn" title="Deposit / Wallet"><i class="fas fa-dollar-sign"></i></button>
            </aside>
        </div>
    </div>

    <div class="live-chat-widget" id="live-chat-widget">
        <button class="chat-trigger-btn" id="chat-trigger-btn" aria-label="Open support chat">
            <i class="fas fa-headset"></i>
            <span class="chat-pulse-ring"></span>
        </button>
        <div class="chat-box-container hidden" id="chat-box-container">
            <div class="chat-box-header">
                <div class="chat-agent-profile">
                    <div class="chat-agent-avatar">
                        <i class="fas fa-user-astronaut"></i>
                        <span class="agent-online-dot"></span>
                    </div>
                    <div class="chat-agent-info">
                        <h4 class="agent-name">Aviator Support</h4>
                        <span class="agent-status">Online Support Agent</span>
                    </div>
                </div>
                <button class="chat-box-close" id="chat-box-close" aria-label="Close chat"><i class="fas fa-times"></i></button>
            </div>
            <div class="chat-box-body" id="chat-box-body">
                <div class="chat-msg msg-agent">
                    <div class="msg-bubble">Hello! 👋 Welcome to Aviator P2P Sports Support. How can we help you today?</div>
                    <span class="msg-time">Just now</span>
                </div>
                <div class="chat-quick-options">
                    <span class="quick-option-title">Suggested Questions:</span>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How do I deposit BDT?')">How do I deposit BDT?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('Is the multiplier fair?')">Is the multiplier fair?</button>
                    <button class="quick-msg-btn" onclick="sendQuickMessage('How does P2P escrow work?')">How does P2P escrow work?</button>
                </div>
            </div>
            <form class="chat-box-footer" id="chat-send-form" onsubmit="handleChatSubmit(event)">
                <input type="text" class="chat-input-field" id="chat-input-field" placeholder="Write a message..." autocomplete="off">
                <button type="submit" class="chat-send-btn" aria-label="Send message"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
    (function(){
        "use strict";
        const STAKES = [5,10,25,50,100,500];
        let realBal = parseFloat("{{ auth()->user()->balance }}") || 0;
        let userCur = "{{ auth()->user()->currency }}" || 'BDT';
        let isDemo = true, demoBal = 10000, balance = demoBal;
        let stake = 10, side = 'heads', flipping = false, pendWin = null, muted = false;
        let history = [];

        const bannerText = document.getElementById('bannerText');
        const mainCoin = document.getElementById('mainCoin');
        const coinVal = document.getElementById('coinVal');
        const headsBtn = document.getElementById('headsBtn');
        const tailsBtn = document.getElementById('tailsBtn');
        const betBtn1 = document.getElementById('bet-btn-1');
        const betBtn2 = document.getElementById('bet-btn-2');
        const collectBtn = document.getElementById('collectBtn');
        const betAmount1 = document.getElementById('bet-amount-1');
        const betAmount2 = document.getElementById('bet-amount-2');
        const clearBet1 = document.getElementById('clear-bet-1');
        const clearBet2 = document.getElementById('clear-bet-2');
        const resultBadge = document.getElementById('resultBadge');
        const betsContainer = document.getElementById('bets-list-container');
        const balVal = document.getElementById('user-balance');
        const modeToggle = document.getElementById('modeToggle');
        const modeLbl = document.getElementById('modeLbl');
        const modeDot = document.getElementById('modeDot');
        const modeLabel = document.getElementById('modeLabel');
        const lastResult = document.getElementById('lastResult');
        const soundToggle = document.getElementById('sound-toggle');
        const scene = document.getElementById('scene');
        const liveBetsCount = document.getElementById('live-bets-count');
        const liveTotalBet = document.getElementById('live-total-bet-amount');
        const liveTotalWon = document.getElementById('live-total-winnings-amount');

        const fxCanvas = document.getElementById('fxCanvas');
        const fxCtx = fxCanvas ? fxCanvas.getContext('2d') : null;
        let sceneW=0, sceneH=0;
        function resizeFx(){
            if(!fxCanvas || !fxCtx) return;
            const r=scene.getBoundingClientRect(),dpr=window.devicePixelRatio||1;
            fxCanvas.width=Math.max(1,r.width*dpr);fxCanvas.height=Math.max(1,r.height*dpr);
            fxCtx.setTransform(dpr,0,0,dpr,0,0);sceneW=r.width;sceneH=r.height;
        }
        window.addEventListener('resize',resizeFx);setTimeout(resizeFx,100);

        let pts=[];
        function burst(x,y){const clrs=['#f6d060','#ff9030','#fff6a0','#f6c030','#ffd080','#fff'];for(let i=0;i<22;i++){const a=(Math.random()-.5)*Math.PI*2,sp=2+Math.random()*4.5;pts.push({x,y,vx:Math.cos(a)*sp,vy:Math.sin(a)*sp-2.5,sz:5+Math.random()*9,life:0,max:1000+Math.random()*700,c:clrs[Math.floor(Math.random()*clrs.length)]});}}
        let lastT=performance.now();
        function fxLoop(now){
            if(!fxCtx) return;
            const dt=now-lastT;lastT=now;fxCtx.clearRect(0,0,sceneW,sceneH);
            pts=pts.filter(p=>p.life<p.max);
            pts.forEach(p=>{p.life+=dt;p.vy+=.001*dt*.08;p.x+=p.vx;p.y+=p.vy;const t=p.life/p.max,al=t<.7?1:Math.max(0,1-(t-.7)/.3);fxCtx.save();fxCtx.globalAlpha=al;fxCtx.beginPath();fxCtx.arc(p.x,p.y,p.sz,0,Math.PI*2);fxCtx.fillStyle=p.c;fxCtx.fill();fxCtx.strokeStyle='rgba(0,0,0,.25)';fxCtx.lineWidth=1;fxCtx.stroke();fxCtx.restore();});
            requestAnimationFrame(fxLoop);
        }
        requestAnimationFrame(fxLoop);

        let actx=null;
        function getCtx(){if(!actx)actx=new(window.AudioContext||window.webkitAudioContext)();return actx;}
        function beep(f,d,t,v){if(muted)return;try{const cx=getCtx(),o=cx.createOscillator(),g=cx.createGain();o.type=t||'sine';o.frequency.value=f;g.gain.value=v||.06;o.connect(g).connect(cx.destination);const n=cx.currentTime;g.gain.setValueAtTime(g.gain.value,n);g.gain.exponentialRampToValueAtTime(.0001,n+d);o.start(n);o.stop(n+d);}catch(e){}}
        function sfxClick(){beep(520,.08,'triangle',.05);}
        function sfxWin(){[660,880,1100].forEach((f,i)=>setTimeout(()=>beep(f,.25,'triangle',.07),i*90));}
        function sfxLose(){beep(140,.35,'sawtooth',.05);}
        function sfxCollect(){beep(900,.18,'sine',.07);}

        function getCur(){return isDemo?'BDT':userCur;}

        function renderAll(){
            coinVal.textContent=stake;
            balVal.textContent=balance.toFixed(2);
            betBtn1.querySelector('.btn-secondary-text').textContent='('+stake+' '+getCur()+')';
            collectBtn.classList.toggle('show',pendWin!==null);
            if(pendWin!==null)collectBtn.innerHTML='<i class="fas fa-hand-holding-usd"></i> COLLECT '+pendWin.toFixed(2)+' '+getCur();
            modeLbl.textContent=isDemo?'DEMO':'REAL';
            modeDot.style.left=isDemo?'2px':'20px';
            modeLabel.textContent=isDemo?'DEMO MODE':'REAL MODE';
            renderHistory();
        }

        function renderHistory(){
            if(history.length===0){
                betsContainer.innerHTML='<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;padding:40px 20px;text-align:center;color:var(--text-muted);"><i class="fas fa-history" style="font-size:32px;margin-bottom:8px;opacity:0.4;"></i><span style="font-size:11px;">No rounds played yet</span></div>';
                return;
            }
            betsContainer.innerHTML='';
            history.slice().reverse().forEach(h=>{
                const d=document.createElement('div');
                d.className='bet-row '+(h.result==='win'?'win':'lose');
                d.innerHTML='<span style="font-weight:700;">'+(h.result==='win'?'WIN':'LOSS')+'</span><span>'+h.side.toUpperCase()+'</span><span class="user-odds">'+(h.result==='win'?'+'+h.amount*2:'-'+h.amount)+'</span>';
                betsContainer.appendChild(d);
            });
            const total=history.length,wins=history.filter(h=>h.result==='win').length,wonAmt=history.filter(h=>h.result==='win').reduce((s,h)=>s+h.amount*2,0);
            liveBetsCount.textContent=total;
            liveTotalBet.textContent=(total>0?Math.round(wins/total*100):0)+'%';
            liveTotalWon.textContent=wonAmt.toFixed(2)+' '+getCur();
        }

        function syncBal(v){if(isDemo){demoBal=v;return;}realBal=v;fetch('{{ route("dashboard.update-balance") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},body:JSON.stringify({balance:v.toFixed(2)})}).catch(()=>{});}

        function getCoinCenter(){const cr=mainCoin.getBoundingClientRect(),sr=scene.getBoundingClientRect();return{x:cr.left-sr.left+cr.width/2,y:cr.top-sr.top+cr.height/2};}

        function doFlip(){
            if(flipping||pendWin!==null)return;
            if(balance<stake){bannerText.textContent='NOT ENOUGH BALANCE';return;}
            flipping=true;balance-=stake;syncBal(balance);sfxClick();betBtn1.disabled=true;
            bannerText.textContent='Flipping...';bannerText.className='banner-text';
            resultBadge.className='result-badge hidden';
            mainCoin.classList.remove('flip-anim');void mainCoin.offsetWidth;mainCoin.classList.add('flip-anim');
            const outcome=Math.random()<.5?'heads':'tails';
            setTimeout(()=>{
                mainCoin.classList.remove('flip-anim');
                const won=outcome===side;
                if(won){
                    const wa=stake*2;pendWin=wa;sfxWin();
                    const c=getCoinCenter();if(c)burst(c.x,c.y);
                    bannerText.textContent='YOU WIN! +'+wa.toFixed(2)+' '+getCur();bannerText.className='banner-text win';
                    resultBadge.textContent='+'+wa.toFixed(2);resultBadge.className='result-badge win';
                    lastResult.textContent='Won '+wa.toFixed(2)+' '+getCur();lastResult.style.color='var(--color-green)';
                    history.push({result:'win',side:side,amount:stake});
                }else{
                    sfxLose();bannerText.textContent='BETTER LUCK NEXT TIME';bannerText.className='banner-text lose';
                    resultBadge.textContent='LOST';resultBadge.className='result-badge lose';
                    lastResult.textContent='Lost '+stake.toFixed(2)+' '+getCur();lastResult.style.color='var(--color-red)';
                    history.push({result:'lose',side:side,amount:stake});
                }
                flipping=false;betBtn1.disabled=false;renderAll();
            },1550);
        }

        function doCollect(){if(pendWin===null)return;const amt=pendWin;balance+=pendWin;pendWin=null;sfxCollect();syncBal(balance);bannerText.textContent='COLLECTED! +'+amt.toFixed(2)+' '+getCur();bannerText.className='banner-text win';resultBadge.className='result-badge hidden';lastResult.textContent='Collected '+amt.toFixed(2)+' '+getCur();lastResult.style.color='var(--color-gold)';renderAll();}

        function toggleMode(){isDemo=!isDemo;balance=isDemo?demoBal:realBal;renderAll();}

        betBtn1.addEventListener('click',doFlip);
        collectBtn.addEventListener('click',doCollect);
        betBtn2.addEventListener('click',doFlip);
        modeToggle.addEventListener('click',toggleMode);
        headsBtn.addEventListener('click',()=>{if(flipping||pendWin!==null)return;side='heads';headsBtn.className='side-btn active-heads';tailsBtn.className='side-btn';sfxClick();});
        tailsBtn.addEventListener('click',()=>{if(flipping||pendWin!==null)return;side='tails';tailsBtn.className='side-btn active-tails';headsBtn.className='side-btn';sfxClick();});
        betAmount1.addEventListener('change',()=>{const v=parseInt(betAmount1.value)||1;stake=Math.max(1,v);betAmount1.value=stake;betAmount2.value=stake;renderAll();});
        betAmount2.addEventListener('change',()=>{const v=parseInt(betAmount2.value)||1;stake=Math.max(1,v);betAmount2.value=stake;betAmount1.value=stake;renderAll();});
        clearBet1.addEventListener('click',()=>{betAmount1.value=5;betAmount2.value=5;stake=5;renderAll();});
        clearBet2.addEventListener('click',()=>{betAmount1.value=5;betAmount2.value=5;stake=5;renderAll();});
        document.querySelectorAll('.quick-btn').forEach(b=>b.addEventListener('click',()=>{const v=parseInt(b.dataset.value);if(v){stake=v;betAmount1.value=v;betAmount2.value=v;renderAll();sfxClick();}}));
        soundToggle.addEventListener('click',()=>{muted=!muted;soundToggle.innerHTML=muted?'<i class="fas fa-volume-mute"></i>':'<i class="fas fa-volume-up"></i>';});

        bannerText.textContent='Choose your side! Heads or Tails?';
        renderAll();
    })();

    const logoutBtn = document.getElementById('header-logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }
    window.UserCurrency = "{{ auth()->user()->currency }}";

    function toggleGameTheme(e) {
        if (e) e.preventDefault();
        const isLight = document.documentElement.classList.contains('light-theme');
        let newTheme = 'dark';
        if (isLight) {
            document.documentElement.classList.remove('light-theme');
            document.body.classList.remove('light-theme');
            newTheme = 'dark';
        } else {
            document.documentElement.classList.add('light-theme');
            document.body.classList.add('light-theme');
            newTheme = 'light';
        }
        fetch('{{ route("dashboard.update-theme") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ theme: newTheme })
        });
    }

    (function() {
        const triggerBtn = document.getElementById('chat-trigger-btn');
        const closeBtn = document.getElementById('chat-box-close');
        const boxContainer = document.getElementById('chat-box-container');
        const chatForm = document.getElementById('chat-send-form');
        const inputField = document.getElementById('chat-input-field');
        const chatBody = document.getElementById('chat-box-body');
        const isAuth = true;
        let pollInterval = null;

        function toggleChat() {
            boxContainer.classList.toggle('hidden');
            scrollChatToBottom();
            if (isAuth && !boxContainer.classList.contains('hidden')) {
                loadSupportMessages();
                if (!pollInterval) {
                    pollInterval = setInterval(loadSupportMessages, 1500);
                }
            } else {
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }
            }
        }
        if (triggerBtn) triggerBtn.addEventListener('click', toggleChat);
        if (closeBtn) closeBtn.addEventListener('click', toggleChat);

        function scrollChatToBottom() {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function loadSupportMessages(force) {
            fetch('{{ route("support.messages") }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderSupportMessages(data.messages, force);
                }
            })
            .catch(err => console.error("Error loading support messages:", err));
        }

        function renderSupportMessages(messages, force) {
            let html = `
                <div class="chat-msg msg-agent">
                    <div class="msg-bubble">Hello! 👋 Welcome to Aviator P2P Sports Support. How can we help you today?</div>
                    <span class="msg-time">Just now</span>
                </div>
            `;
            messages.forEach(msg => {
                const senderClass = msg.sender === 'user' ? 'user' : 'agent';
                html += `
                    <div class="chat-msg msg-${senderClass}">
                        <div class="msg-bubble">${escHtml(msg.message)}</div>
                        <span class="msg-time">${msg.time}</span>
                    </div>
                `;
            });
            if (messages.length === 0) {
                html += `
                    <div class="chat-quick-options">
                        <span class="quick-option-title">Suggested Questions:</span>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How do I deposit BDT?')">How do I deposit BDT?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('Is the multiplier fair?')">Is the multiplier fair?</button>
                        <button class="quick-msg-btn" onclick="sendQuickMessage('How does P2P escrow work?')">How does P2P escrow work?</button>
                    </div>
                `;
            }
            const currentCount = chatBody.querySelectorAll('.chat-msg').length;
            const newCount = messages.length + 1;
            if (force || currentCount !== newCount) {
                chatBody.innerHTML = html;
                scrollChatToBottom();
            }
        }

        function escHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        window.sendQuickMessage = function(text) {
            if (isAuth) {
                appendMessage(text, 'user');
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();
                setTimeout(() => {
                    typing.remove();
                    let reply = "Thank you for reaching out. A support agent will be with you shortly.";
                    if (text.includes('deposit')) {
                        reply = "To deposit funds, click 'DEPOSIT' on your game dashboard page. Transfer BDT instantly using bKash, Nagad, or Rocket.";
                    } else if (text.includes('fair')) {
                        reply = "Our game is 100% Provably Fair. Multipliers are predetermined before takeoff using SHA-256 hash algorithms.";
                    } else if (text.includes('escrow')) {
                        reply = "The escrow system locks user stakes safely at the beginning of each round. Funds are automatically distributed from escrow to your balance.";
                    }
                    appendMessage(reply, 'agent');
                }, 1000);
            }
        };

        window.handleChatSubmit = function(e) {
            e.preventDefault();
            const text = inputField.value.trim();
            if (!text) return;
            inputField.value = '';
            if (isAuth) {
                appendMessage(text, 'user');
                sendDatabaseMessage(text);
            } else {
                appendMessage(text, 'user');
                const typing = showTypingIndicator();
                setTimeout(() => {
                    typing.remove();
                    appendMessage("Thank you for your message! Our support team is online 24/7.", 'agent');
                }, 1200);
            }
        };

        function sendDatabaseMessage(text) {
            fetch('{{ route("support.messages.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: text })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    loadSupportMessages(true);
                }
            })
            .catch(err => console.error("Error sending message:", err));
        }

        function appendMessage(text, sender) {
            const msgDiv = document.createElement('div');
            msgDiv.className = `chat-msg msg-${sender}`;
            msgDiv.innerHTML = `<div class="msg-bubble">${escHtml(text)}</div><span class="msg-time">Just now</span>`;
            const options = chatBody.querySelector('.chat-quick-options');
            if (options && sender === 'user') {
                chatBody.insertBefore(msgDiv, options);
            } else {
                chatBody.appendChild(msgDiv);
            }
            scrollChatToBottom();
        }

        function showTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.className = 'typing-indicator';
            indicator.innerHTML = `<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>`;
            chatBody.appendChild(indicator);
            scrollChatToBottom();
            return indicator;
        }

        if (isAuth && !boxContainer.classList.contains('hidden')) {
            loadSupportMessages();
            pollInterval = setInterval(loadSupportMessages, 1500);
        }
    })();
    </script>
</body>
</html>
