<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doubloon Flip — a just-for-fun coin game</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500..900&family=Sora:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --abyss:#061325;
    --tide:#0f2c4a;
    --tide-light:#163c63;
    --foam:#bfeee0;
    --parchment:#f1e3bf;
    --parchment-dark:#e3d2a4;
    --doubloon:#e8b23d;
    --doubloon-deep:#9c6a18;
    --ink:#2c1c0c;
    --teal:#2bbfa0;
    --coral:#ff6859;
    --text-light:#eef3f6;
    --text-muted:#80a0b8;
    --radius:14px;
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    background:
      radial-gradient(ellipse at 50% -10%, #15375c 0%, var(--abyss) 55%);
    color:var(--text-light);
    font-family:'Sora', sans-serif;
    min-height:100vh;
    padding:28px 16px 40px;
    display:flex;
    justify-content:center;
  }
  a{color:inherit;}
  :focus-visible{outline:2px solid var(--foam);outline-offset:2px;border-radius:6px;}

  .app{width:100%;max-width:1040px;}

  /* ---------- Header ---------- */
  .app-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:14px;
    margin-bottom:22px;
    padding-bottom:18px;
    border-bottom:1px solid rgba(191,238,224,0.12);
  }
  .title-block h1{
    font-family:'Fraunces', serif;
    font-optical-sizing:auto;
    font-weight:800;
    font-size:clamp(28px,4vw,42px);
    margin:0 0 4px;
    letter-spacing:0.3px;
    color:var(--doubloon);
    text-shadow:0 2px 18px rgba(232,178,61,0.25);
  }
  .title-block h1 span{color:var(--text-light);}
  .title-block p{
    margin:0;
    color:var(--text-muted);
    font-size:13.5px;
    max-width:420px;
  }
  .fun-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:rgba(43,191,160,0.14);
    border:1px solid rgba(43,191,160,0.45);
    color:var(--teal);
    font-family:'IBM Plex Mono', monospace;
    font-size:11px;
    font-weight:600;
    letter-spacing:0.6px;
    padding:7px 12px;
    border-radius:999px;
    white-space:nowrap;
  }

  /* ---------- Layout ---------- */
  .layout{
    display:grid;
    grid-template-columns:240px 1fr;
    gap:18px;
  }
  @media (max-width:760px){
    .layout{grid-template-columns:1fr;}
    .log-panel{order:2;}
  }

  /* ---------- Log panel (ship's log) ---------- */
  .log-panel{
    background:var(--tide-light);
    border:1px solid rgba(191,238,224,0.1);
    border-radius:var(--radius);
    padding:16px;
    display:flex;
    flex-direction:column;
    gap:14px;
    min-height:420px;
  }
  .log-title{
    font-family:'IBM Plex Mono', monospace;
    font-size:11px;
    letter-spacing:1px;
    color:var(--text-muted);
    text-transform:uppercase;
    display:flex;
    align-items:center;
    gap:6px;
  }
  .stat-row{display:flex;flex-direction:column;gap:8px;}
  .stat-card{
    background:rgba(6,19,37,0.4);
    border-radius:10px;
    padding:9px 12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .stat-card .label{font-size:11.5px;color:var(--text-muted);}
  .stat-card .value{font-family:'IBM Plex Mono', monospace;font-weight:700;font-size:13.5px;}
  .value.teal{color:var(--teal);}
  .value.gold{color:var(--doubloon);}

  .log-entries{
    flex:1;
    overflow-y:auto;
    display:flex;
    flex-direction:column;
    gap:7px;
    padding-right:2px;
    max-height:340px;
  }
  .log-empty{
    flex:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:var(--text-muted);
    font-size:11.5px;
    gap:6px;
    padding:30px 10px;
  }
  .log-entry{
    background:var(--parchment);
    color:var(--ink);
    border-radius:4px;
    padding:7px 10px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:12px;
    font-family:'IBM Plex Mono', monospace;
    box-shadow:0 2px 4px rgba(0,0,0,0.25);
    border-left:4px solid var(--coral);
    animation:logIn 0.25s ease;
  }
  .log-entry.win{border-left-color:var(--teal);}
  .log-entry .tag{font-weight:700;letter-spacing:0.4px;}
  .log-entry.win .tag{color:#127a64;}
  .log-entry.lose .tag{color:#a33327;}
  @keyframes logIn{from{opacity:0;transform:translateX(8px);}to{opacity:1;transform:translateX(0);}}

  /* ---------- Stage panel ---------- */
  .stage-panel{display:flex;flex-direction:column;gap:16px;}

  .ocean-stage{
    position:relative;
    background:linear-gradient(180deg, #0b2540 0%, #0a3257 55%, #0c4570 100%);
    border:1px solid rgba(191,238,224,0.12);
    border-radius:var(--radius);
    min-height:340px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }
  .ocean-stage canvas{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:4;}
  .wave{
    position:absolute;
    left:-10%;
    width:120%;
    opacity:0.5;
  }
  .wave svg{display:block;width:100%;height:100%;}
  .wave.w1{bottom:-6px;animation:waveDrift 11s ease-in-out infinite alternate;}
  .wave.w2{bottom:-18px;opacity:0.3;animation:waveDrift 16s ease-in-out infinite alternate-reverse;}
  @keyframes waveDrift{from{transform:translateX(-3%);}to{transform:translateX(3%);}}
  @media (prefers-reduced-motion: reduce){
    .wave{animation:none !important;}
  }

  .banner{
    position:relative;z-index:6;
    font-family:'Sora',sans-serif;
    font-weight:600;
    font-size:14px;
    color:var(--text-muted);
    text-align:center;
    min-height:20px;
    margin-bottom:14px;
    transition:color 0.25s;
  }
  .banner.win{color:var(--teal);}
  .banner.lose{color:var(--coral);}

  .coin{
    position:relative;z-index:6;
    width:108px;height:108px;border-radius:50%;
    background:radial-gradient(circle at 32% 28%, #fff3c4 0%, var(--doubloon) 42%, #c08a22 76%, var(--doubloon-deep) 100%);
    border:5px solid var(--doubloon-deep);
    box-shadow:0 0 0 5px rgba(232,178,61,0.18), 0 14px 32px rgba(0,0,0,0.45), inset 0 -8px 16px rgba(0,0,0,0.28), inset 0 7px 12px rgba(255,250,210,0.35);
    display:flex;align-items:center;justify-content:center;
    font-size:42px;
    color:var(--ink);
    user-select:none;
  }
  .coin.flip-anim{animation:coinFlip 1.3s cubic-bezier(.4,.1,.2,1) forwards;}
  @keyframes coinFlip{
    0%{transform:translateY(0) rotateY(0);}
    25%{transform:translateY(-26px) rotateY(160deg);}
    50%{transform:translateY(-44px) rotateY(360deg);}
    75%{transform:translateY(-20px) rotateY(560deg);}
    100%{transform:translateY(0) rotateY(720deg);}
  }
  @media (prefers-reduced-motion: reduce){
    .coin.flip-anim{animation:coinFadeOnly 0.6s ease forwards;}
  }
  @keyframes coinFadeOnly{0%{opacity:0.5;}100%{opacity:1;}}

  .stamp{
    position:absolute;z-index:7;
    top:38%;left:50%;
    transform:translate(-50%,-50%) rotate(-10deg) scale(0.6);
    font-family:'IBM Plex Mono', monospace;
    font-weight:700;
    font-size:26px;
    letter-spacing:2px;
    padding:6px 18px;
    border:3px double currentColor;
    border-radius:6px;
    opacity:0;
    pointer-events:none;
  }
  .stamp.win{color:var(--teal);}
  .stamp.lose{color:var(--coral);}
  .stamp.show{animation:stampPop 0.5s ease forwards;}
  @keyframes stampPop{
    0%{opacity:0;transform:translate(-50%,-50%) rotate(-10deg) scale(0.4);}
    60%{opacity:1;transform:translate(-50%,-50%) rotate(-10deg) scale(1.08);}
    100%{opacity:1;transform:translate(-50%,-50%) rotate(-10deg) scale(1);}
  }

  /* ---------- Controls ---------- */
  .controls{
    background:var(--tide-light);
    border:1px solid rgba(191,238,224,0.1);
    border-radius:var(--radius);
    padding:16px;
    display:flex;
    flex-direction:column;
    gap:14px;
  }
  .side-select{display:grid;grid-template-columns:1fr 1fr;gap:8px;}
  .side-btn{
    display:flex;align-items:center;justify-content:center;gap:8px;
    padding:11px 0;
    border:2px solid rgba(191,238,224,0.18);
    border-radius:10px;
    background:rgba(6,19,37,0.35);
    color:var(--text-muted);
    font-family:'Sora',sans-serif;
    font-weight:700;
    font-size:13px;
    letter-spacing:0.5px;
    cursor:pointer;
    transition:all .15s ease;
  }
  .side-btn .glyph{font-size:16px;}
  .side-btn:hover{border-color:rgba(191,238,224,0.4);color:var(--text-light);}
  .side-btn.active{background:rgba(232,178,61,0.16);border-color:var(--doubloon);color:var(--doubloon);}

  .ladder-label{font-size:11px;color:var(--text-muted);letter-spacing:0.6px;font-family:'IBM Plex Mono',monospace;}
  .ladder{display:grid;grid-template-columns:repeat(7,1fr);gap:5px;}
  .ladder-btn{
    padding:8px 2px;
    border-radius:8px;
    border:1px solid rgba(191,238,224,0.15);
    background:rgba(6,19,37,0.35);
    color:var(--text-muted);
    font-family:'IBM Plex Mono',monospace;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
    text-align:center;
    transition:all .15s ease;
  }
  .ladder-btn:hover{color:var(--text-light);}
  .ladder-btn.sel{background:var(--doubloon);color:var(--ink);border-color:var(--doubloon);}
  .ladder-btn.reached{color:var(--teal);border-color:rgba(43,191,160,0.4);}
  .ladder-btn:disabled{opacity:0.45;cursor:default;}

  .pot-line{
    display:flex;align-items:center;justify-content:space-between;
    background:rgba(6,19,37,0.4);
    border-radius:10px;
    padding:9px 12px;
    font-family:'IBM Plex Mono',monospace;
  }
  .pot-line .label{font-size:11.5px;color:var(--text-muted);}
  .pot-line .value{font-weight:700;color:var(--doubloon);font-size:15px;}

  .action-row{display:flex;gap:8px;flex-wrap:wrap;}
  .flip-btn, .bank-btn{
    flex:1;
    min-width:140px;
    height:46px;
    border:none;border-radius:10px;
    font-family:'Sora',sans-serif;
    font-weight:700;font-size:13px;letter-spacing:0.4px;
    cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:8px;
    transition:filter .15s ease, transform .1s ease;
  }
  .flip-btn{background:linear-gradient(180deg,#ff8a4c,#e3621f);color:#fff;}
  .flip-btn:disabled{opacity:0.5;cursor:default;}
  .flip-btn:hover:not(:disabled){filter:brightness(1.08);}
  .flip-btn:active:not(:disabled){transform:scale(0.98);}
  .bank-btn{background:var(--doubloon);color:var(--ink);display:none;}
  .bank-btn.show{display:flex;}
  .bank-btn:hover{filter:brightness(1.08);}
  .bank-btn:active{transform:scale(0.98);}
  .sub{font-size:11px;opacity:0.85;font-weight:500;}

  .footnote{
    text-align:center;
    font-size:11px;
    color:var(--text-muted);
    margin-top:6px;
    line-height:1.5;
  }
  .sound-toggle{
    position:absolute;top:10px;right:10px;z-index:8;
    background:rgba(6,19,37,0.5);
    border:1px solid rgba(191,238,224,0.2);
    color:var(--text-light);
    width:30px;height:30px;border-radius:50%;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    font-size:13px;
  }
</style>
</head>
<body>
<div class="app">
  <header class="app-header">
    <div class="title-block">
      <h1>⚓ Doubloon <span>Flip</span></h1>
      <p>Call your side, double the pot, bank it before the tide turns.</p>
    </div>
    <span class="fun-badge">🎮 FOR FUN ONLY · NO REAL MONEY</span>
  </header>

  <div class="layout">
    <aside class="log-panel">
      <div class="log-title">📜 Ship's Log</div>
      <div class="stat-row">
        <div class="stat-card"><span class="label">Rounds played</span><span class="value" id="statRounds">0</span></div>
        <div class="stat-card"><span class="label">Win rate</span><span class="value teal" id="statWinRate">0%</span></div>
        <div class="stat-card"><span class="label">Total banked</span><span class="value gold" id="statBanked">0 pts</span></div>
      </div>
      <div class="log-entries" id="logEntries">
        <div class="log-empty">🗺️<br>No rounds logged yet</div>
      </div>
    </aside>

    <main class="stage-panel">
      <div class="ocean-stage" id="stage">
        <canvas id="fx"></canvas>
        <button class="sound-toggle" id="soundToggle" title="Toggle sound">🔊</button>
        <div class="wave w1"><svg viewBox="0 0 600 60" preserveAspectRatio="none"><path d="M0,30 Q150,0 300,30 T600,30 V60 H0 Z" fill="#bfeee0"/></svg></div>
        <div class="wave w2"><svg viewBox="0 0 600 60" preserveAspectRatio="none"><path d="M0,30 Q150,55 300,30 T600,30 V60 H0 Z" fill="#7fd8c2"/></svg></div>
        <div class="banner" id="banner">Pick a side, then flip the coin!</div>
        <div class="coin" id="coin"><span id="coinFace">☠</span></div>
        <div class="stamp lose" id="stamp"></div>
      </div>

      <div class="controls">
        <div class="side-select">
          <button class="side-btn active" id="skullBtn"><span class="glyph">☠</span> SKULL SIDE</button>
          <button class="side-btn" id="anchorBtn"><span class="glyph">⚓</span> ANCHOR SIDE</button>
        </div>

        <div>
          <div class="ladder-label" style="margin-bottom:6px;">POT LADDER (pts)</div>
          <div class="ladder" id="ladder"></div>
        </div>

        <div class="pot-line">
          <span class="label">Current pot</span>
          <span class="value" id="potVal">10 pts</span>
        </div>

        <div class="action-row">
          <button class="flip-btn" id="flipBtn">FLIP COIN <span class="sub" id="flipSub">(10 pts)</span></button>
          <button class="bank-btn" id="bankBtn"><span id="bankLabel">BANK</span></button>
        </div>
      </div>

      <p class="footnote">Doubloon Flip is a free demo game for entertainment only. No deposits, withdrawals, or real currency are involved — "pts" have no monetary value.</p>
    </main>
  </div>
</div>

<script>
(function(){
  "use strict";
  const POT_LEVELS = [10,20,40,80,160,320,640];
  let potIdx = 0, side = 'skull', flipping = false, pendingBank = null;
  let history = [], totalBanked = 0, lastReachedIdx = 0, muted = false;

  const banner = document.getElementById('banner');
  const coin = document.getElementById('coin');
  const coinFace = document.getElementById('coinFace');
  const skullBtn = document.getElementById('skullBtn');
  const anchorBtn = document.getElementById('anchorBtn');
  const flipBtn = document.getElementById('flipBtn');
  const flipSub = document.getElementById('flipSub');
  const bankBtn = document.getElementById('bankBtn');
  const bankLabel = document.getElementById('bankLabel');
  const stamp = document.getElementById('stamp');
  const ladder = document.getElementById('ladder');
  const potVal = document.getElementById('potVal');
  const logEntries = document.getElementById('logEntries');
  const statRounds = document.getElementById('statRounds');
  const statWinRate = document.getElementById('statWinRate');
  const statBanked = document.getElementById('statBanked');
  const soundToggle = document.getElementById('soundToggle');
  const stage = document.getElementById('stage');
  const fx = document.getElementById('fx');
  const fxCtx = fx.getContext('2d');

  let sceneW=0, sceneH=0;
  function resizeFx(){
    const r = stage.getBoundingClientRect(), dpr = window.devicePixelRatio || 1;
    fx.width = Math.max(1, r.width*dpr); fx.height = Math.max(1, r.height*dpr);
    fxCtx.setTransform(dpr,0,0,dpr,0,0);
    sceneW = r.width; sceneH = r.height;
  }
  window.addEventListener('resize', resizeFx);
  setTimeout(resizeFx, 80);

  let particles = [];
  function burst(x,y){
    const colors = ['#e8b23d','#fff3c4','#c08a22','#f4cf6e','#fff'];
    for(let i=0;i<24;i++){
      const a = Math.random()*Math.PI*2, sp = 2+Math.random()*4.2;
      particles.push({x,y,vx:Math.cos(a)*sp, vy:Math.sin(a)*sp-2.4, sz:4+Math.random()*8, life:0, max:900+Math.random()*600, c:colors[Math.floor(Math.random()*colors.length)]});
    }
  }
  let lastT = performance.now();
  function fxLoop(now){
    const dt = now - lastT; lastT = now;
    fxCtx.clearRect(0,0,sceneW,sceneH);
    particles = particles.filter(p=>p.life<p.max);
    particles.forEach(p=>{
      p.life += dt; p.vy += 0.0009*dt*8; p.x += p.vx; p.y += p.vy;
      const t = p.life/p.max, al = t<0.7 ? 1 : Math.max(0, 1-(t-0.7)/0.3);
      fxCtx.save(); fxCtx.globalAlpha = al;
      fxCtx.beginPath(); fxCtx.arc(p.x,p.y,p.sz,0,Math.PI*2);
      fxCtx.fillStyle = p.c; fxCtx.fill();
      fxCtx.restore();
    });
    requestAnimationFrame(fxLoop);
  }
  requestAnimationFrame(fxLoop);

  let actx = null;
  function getCtx(){ if(!actx) actx = new (window.AudioContext||window.webkitAudioContext)(); return actx; }
  function beep(f,d,type,v){
    if(muted) return;
    try{
      const cx = getCtx(), o = cx.createOscillator(), g = cx.createGain();
      o.type = type||'sine'; o.frequency.value = f; g.gain.value = v||0.06;
      o.connect(g).connect(cx.destination);
      const n = cx.currentTime;
      g.gain.setValueAtTime(g.gain.value, n);
      g.gain.exponentialRampToValueAtTime(0.0001, n+d);
      o.start(n); o.stop(n+d);
    }catch(e){}
  }
  const sfxClick = () => beep(520,0.08,'triangle',0.05);
  const sfxWin = () => [660,880,1100].forEach((f,i)=>setTimeout(()=>beep(f,0.22,'triangle',0.06),i*90));
  const sfxLose = () => beep(140,0.32,'sawtooth',0.05);
  const sfxBank = () => beep(900,0.16,'sine',0.06);

  function getPot(){ return POT_LEVELS[potIdx]; }
  function getCoinCenter(){
    const cr = coin.getBoundingClientRect(), sr = stage.getBoundingClientRect();
    return { x: cr.left - sr.left + cr.width/2, y: cr.top - sr.top + cr.height/2 };
  }

  function renderLadder(){
    ladder.innerHTML = '';
    POT_LEVELS.forEach((v,i)=>{
      const b = document.createElement('button');
      b.className = 'ladder-btn' + (i===potIdx?' sel':'') + (i<lastReachedIdx?' reached':'');
      b.textContent = v;
      b.disabled = flipping || pendingBank !== null;
      b.addEventListener('click', ()=>{
        if(flipping || pendingBank !== null) return;
        potIdx = i; sfxClick(); renderAll();
      });
      ladder.appendChild(b);
    });
  }

  function renderAll(){
    const pv = getPot();
    potVal.textContent = pv + ' pts';
    flipSub.textContent = '(' + pv + ' pts)';
    bankBtn.classList.toggle('show', pendingBank !== null);
    if(pendingBank !== null) bankLabel.textContent = 'BANK ' + pendingBank + ' PTS';
    statRounds.textContent = history.length;
    const wins = history.filter(h=>h.result==='win').length;
    statWinRate.textContent = (history.length ? Math.round(wins/history.length*100) : 0) + '%';
    statBanked.textContent = totalBanked + ' pts';
    renderLadder();
    renderLog();
  }

  function renderLog(){
    if(history.length === 0){
      logEntries.innerHTML = '<div class="log-empty">🗺️<br>No rounds logged yet</div>';
      return;
    }
    logEntries.innerHTML = '';
    history.slice().reverse().forEach(h=>{
      const d = document.createElement('div');
      d.className = 'log-entry ' + h.result;
      const glyph = h.side === 'skull' ? '☠' : '⚓';
      d.innerHTML = '<span class="tag">' + (h.result==='win'?'WIN':'LOSS') + '</span><span>' + glyph + ' ' + h.side.toUpperCase() + '</span><span>' + (h.result==='win' ? '+'+h.amount : '-'+h.amount) + '</span>';
      logEntries.appendChild(d);
    });
  }

  function showStamp(text, cls){
    stamp.textContent = text;
    stamp.className = 'stamp ' + cls;
    void stamp.offsetWidth;
    stamp.classList.add('show');
    setTimeout(()=>{ stamp.classList.remove('show'); }, 1100);
  }

  function doFlip(){
    if(flipping || pendingBank !== null) return;
    const pv = getPot();
    flipping = true;
    sfxClick();
    flipBtn.disabled = true;
    banner.textContent = 'Flipping...';
    banner.className = 'banner';
    coin.classList.remove('flip-anim');
    void coin.offsetWidth;
    coin.classList.add('flip-anim');

    const outcome = Math.random() < 0.5 ? 'skull' : 'anchor';
    setTimeout(()=>{
      coin.classList.remove('flip-anim');
      coinFace.textContent = outcome === 'skull' ? '☠' : '⚓';
      const won = outcome === side;
      if(won){
        const wa = pv * 2;
        pendingBank = wa;
        lastReachedIdx = potIdx + 1;
        sfxWin();
        const c = getCoinCenter();
        burst(c.x, c.y);
        banner.textContent = 'WIN! Bank ' + wa + ' pts or flip again?';
        banner.className = 'banner win';
        showStamp('WIN', 'win');
        history.push({result:'win', side, amount:pv});
        if(potIdx < POT_LEVELS.length - 1) potIdx++;
      } else {
        sfxLose();
        banner.textContent = 'The tide takes it — better luck next flip!';
        banner.className = 'banner lose';
        showStamp('LOSS', 'lose');
        history.push({result:'lose', side, amount:pv});
        potIdx = 0; lastReachedIdx = 0; pendingBank = null;
      }
      flipping = false;
      flipBtn.disabled = false;
      renderAll();
    }, 1350);
  }

  function doBank(){
    if(pendingBank === null) return;
    const amt = pendingBank;
    totalBanked += amt;
    pendingBank = null;
    potIdx = 0; lastReachedIdx = 0;
    sfxBank();
    banner.textContent = 'Banked ' + amt + ' pts. Pot reset to ' + POT_LEVELS[0] + '.';
    banner.className = 'banner win';
    renderAll();
  }

  flipBtn.addEventListener('click', doFlip);
  bankBtn.addEventListener('click', doBank);
  skullBtn.addEventListener('click', ()=>{
    if(flipping || pendingBank !== null) return;
    side = 'skull'; skullBtn.classList.add('active'); anchorBtn.classList.remove('active'); sfxClick();
  });
  anchorBtn.addEventListener('click', ()=>{
    if(flipping || pendingBank !== null) return;
    side = 'anchor'; anchorBtn.classList.add('active'); skullBtn.classList.remove('active'); sfxClick();
  });
  soundToggle.addEventListener('click', ()=>{
    muted = !muted;
    soundToggle.textContent = muted ? '🔇' : '🔊';
  });

  renderAll();
})();
</script>
</body>
</html>
