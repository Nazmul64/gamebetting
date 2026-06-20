<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Lucky Joker 100</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --navy-1:#16243f;
    --navy-2:#0a1322;
    --gold:#f0c040;
    --gold-light:#ffe9a8;
    --gold-dark:#8a5a06;
    --red:#e0261b;
    --cream:#fbe9c5;
  }
  *{ box-sizing:border-box; }
  html,body{ margin:0; width:100%; min-height:100vh; overflow-x:hidden; }
  body{
    display:flex;
    flex-direction:column;
    background:radial-gradient(ellipse at top, #1b2c4d, #0a1320 75%);
    font-family:'Oswald',sans-serif;
    padding-top: 50px;
    padding-bottom: 40px;
    padding-left: 54px;
  }

  /* ── TOP NAV ── */
  .topnav {
    width: 100%;
    background: rgba(12, 26, 48, 0.85);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    padding: 0 20px;
    gap: 16px;
    border-bottom: 2px solid #1d3354;
    position: fixed;
    top: 0;
    left: 0;
    height: 50px;
    z-index: 100;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    font-family: 'Exo 2', sans-serif;
  }
  .topnav .breadcrumb { color: #8ca3c7; font-size: 13px; font-weight: 500; }
  .topnav .breadcrumb a { color: #1a76d2; text-decoration: none; font-weight: 700; transition: color 0.2s; }
  .topnav .breadcrumb a:hover { color: #fff; }
  .topnav .gametitle {
    margin: 0 auto;
    color: #fff;
    font-family: 'Luckiest Guy', cursive;
    font-size: 18px;
    letter-spacing: 2px;
    background: linear-gradient(180deg, #fff5c8, #ffcf4d, #e0261b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-stroke: 0.5px #6e0f08;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.2);
  }
  .topnav .search-box {
    background: rgba(26, 48, 96, 0.6);
    border: 1px solid #2a5090;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    width: 160px;
    outline: none;
    transition: all 0.3s;
  }
  .topnav .search-box:focus {
    border-color: var(--gold);
    box-shadow: 0 0 8px rgba(240, 192, 64, 0.4);
  }

  /* ── SIDE NAV ── */
  .sidenav {
    position: fixed;
    left: 0;
    top: 50px;
    bottom: 40px;
    width: 54px;
    background: rgba(12, 26, 48, 0.85);
    backdrop-filter: blur(10px);
    border-right: 2px solid #1d3354;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 18px 0;
    gap: 22px;
    z-index: 100;
  }
  .sidenav .icon {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8ca3c7;
    font-size: 18px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s;
  }
  .sidenav .icon:hover, .sidenav .icon.active {
    background: rgba(26, 118, 210, 0.2);
    color: #fff;
    box-shadow: inset 0 0 8px rgba(26, 118, 210, 0.4);
  }

  /* ── BOTTOM BAR ── */
  .bottombar {
    width: 100%;
    background: rgba(12, 26, 48, 0.85);
    backdrop-filter: blur(10px);
    border-top: 2px solid #1d3354;
    display: flex;
    align-items: center;
    padding: 0 20px;
    gap: 24px;
    position: fixed;
    bottom: 0;
    left: 0;
    height: 40px;
    z-index: 100;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.4);
  }
  .bottombar .tab {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #8ca3c7;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: color 0.2s;
    text-transform: uppercase;
  }
  .bottombar .tab:hover { color: #fff; }
  .bottombar .search-box {
    background: rgba(26, 48, 96, 0.6);
    border: 1px solid #2a5090;
    color: #fff;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 11px;
    width: 180px;
    outline: none;
    transition: all 0.3s;
  }
  .bottombar .search-box:focus {
    border-color: var(--gold);
    box-shadow: 0 0 8px rgba(240, 192, 64, 0.4);
  }
  .bottombar .grid-icons {
    display: flex;
    gap: 8px;
  }
  .bottombar .grid-icon {
    width: 28px;
    height: 24px;
    background: rgba(26, 48, 96, 0.6);
    border: 1px solid #2a5090;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8ca3c7;
    font-size: 12px;
    transition: all 0.2s;
  }
  .bottombar .grid-icon:hover, .bottombar .grid-icon.active {
    background: #1a76d2;
    border-color: #1a76d2;
    color: #fff;
  }

  .game-container-wrapper {
    width: 100%;
    display:flex;
    flex: 1;
    align-items:center;
    justify-content:center;
    padding: 10px;
  }

  .machine{
    width:100%;
    max-width:920px;
    border-radius:14px;
    overflow:hidden;
    background:var(--navy-2);
    box-shadow:0 24px 60px rgba(0,0,0,.55), 0 0 0 1px #2a3c5e;
  }

  /* ---------- top bar ---------- */
  .machine-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:9px 16px;
    background:linear-gradient(#1a2c4d,#0c1729);
    border-bottom:2px solid #2a3c5e;
  }
  .timer{
    font-size:13px;
    color:#bcd2ff;
    letter-spacing:1px;
    background:#081120;
    border:1px solid #233456;
    padding:4px 10px;
    border-radius:4px;
    font-weight:600;
    min-width:54px;
    text-align:center;
  }
  .top-right{ display:flex; align-items:center; gap:8px; }
  .badge-free{
    background:linear-gradient(#9a1626,#5e0c16);
    color:#ffd9a0;
    font-weight:700;
    font-size:11px;
    letter-spacing:1.5px;
    padding:5px 10px;
    border-radius:4px;
    border:1px solid #c43a44;
    cursor:pointer;
    user-select:none;
    transition: all 0.2s;
  }
  .icon-btn{
    width:28px;height:28px;
    border-radius:50%;
    background:radial-gradient(circle at 32% 28%, #ff6b58, #aa1209 70%);
    border:2px solid var(--gold-light);
    color:#fff7e6;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;
    font-size:13px;
    font-weight:700;
    line-height:1;
    transition:filter .15s, transform .1s;
    user-select:none;
  }
  .icon-btn:hover{ transform:translateY(-1px); }
  .icon-btn.off{ filter:grayscale(1) brightness(.55); }

  /* ---------- stage ---------- */
  .stage{
    position:relative;
    padding:16px 16px 0;
    background: radial-gradient(circle, #5e0d4c 0%, #2f0724 60%, #14020f 100%),
                url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'><path d='M25 18 C25 13, 15 13, 15 20 C15 27, 25 33, 25 35 C25 33, 35 27, 35 20 C35 13, 25 13, 25 18 Z' fill='%23ff00bf' fill-opacity='0.025'/><path d='M75 12 L85 24 L75 36 L65 24 Z' fill='%23ff00bf' fill-opacity='0.025'/><path d='M25 78 C27 78, 29 74, 27 71 C25 68, 21 68, 19 71 C17 74, 19 78, 21 78 C20 80, 17 80, 17 83 C17 86, 21 86, 23 84 L23 88 L27 88 L27 84 C29 86, 33 86, 33 83 C33 80, 30 80, 29 78 Z' fill='%23ff00bf' fill-opacity='0.025'/><path d='M75 70 C75 65, 65 65, 65 72 C65 76, 71 78, 75 84 L75 88 L79 88 L79 84 C83 78, 89 78, 89 72 C89 65, 79 65, 75 70 Z' fill='%23ff00bf' fill-opacity='0.025'/></svg>");
    background-repeat: repeat;
    overflow:hidden;
  }
  .stage::before{
    content:"";
    position:absolute; inset:0;
    background: transparent;
    pointer-events:none;
  }

  .game-play-area {
    display: flex;
    gap: 12px;
    align-items: stretch;
    position: relative;
    z-index: 1;
    width: 100%;
    margin-bottom: 10px;
  }

  .extra-gifts-panel {
    width: 160px;
    background: linear-gradient(#3a072d, #14020f);
    border: 3px solid var(--gold);
    border-radius: 8px;
    padding: 10px 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5), inset 0 0 10px rgba(0,0,0,0.8);
    transition: all 0.3s ease;
  }
  .extra-gifts-panel.active {
    box-shadow: 0 0 15px var(--gold), inset 0 0 15px rgba(255,215,0,0.3);
    border-color: #ffe9a8;
  }
  .eg-header {
    text-align: center;
  }
  .eg-title {
    font-family: 'Luckiest Guy', cursive;
    font-size: 20px;
    letter-spacing: 0.5px;
    background: linear-gradient(180deg, #fff5c8, #ffcf4d, #e0261b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-stroke: 0.8px #6e0f08;
    line-height: 1.1;
    display: block;
  }
  .eg-bet-box {
    width: 100%;
    background: #000;
    border: 1.5px solid var(--gold);
    border-radius: 6px;
    padding: 4px 6px;
    text-align: center;
    margin: 6px 0;
  }
  .eg-bet-label {
    color: var(--gold-light);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
  }
  .eg-bet-val {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    font-variant-numeric: tabular-nums;
  }
  .eg-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
  }
  .eg-item {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(0,0,0,0.25);
    padding: 4px 6px;
    border-radius: 4px;
    border: 1px solid rgba(255,255,255,0.05);
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .eg-item:hover {
    background: rgba(240, 192, 64, 0.15);
    border-color: rgba(240, 192, 64, 0.4);
    transform: scale(1.02);
  }
  .eg-gift-icon {
    font-size: 16px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
  }
  .eg-item-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
  }
  .eg-mult {
    color: #fff;
    font-size: 11px;
    font-weight: 700;
  }
  .eg-sub {
    color: #ffe9a8;
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 0.5px;
  }
  .eg-controls {
    display: flex;
    gap: 8px;
    width: 100%;
    margin-top: 6px;
  }
  .eg-switch-btn {
    flex: 1;
    height: 28px;
    background: #424242;
    border: 2.5px solid #616161;
    border-radius: 6px;
    position: relative;
    cursor: pointer;
    transition: all 0.2s;
  }
  .eg-switch-btn::before {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 18px;
    height: 18px;
    background: linear-gradient(#9e9e9e, #757575);
    border-radius: 3px;
    transition: all 0.2s;
  }
  .extra-gifts-panel.active .eg-switch-btn {
    background: #ffb300;
    border-color: #ffd54f;
  }
  .extra-gifts-panel.active .eg-switch-btn::before {
    left: calc(100% - 22px);
    background: linear-gradient(#ffd54f, #ff8f00);
  }
  .eg-close-btn {
    width: 28px;
    height: 28px;
    background: linear-gradient(#f44336, #b71c1c);
    border: 2px solid #b71c1c;
    border-radius: 6px;
    color: #fff;
    font-weight: 800;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }
  .eg-close-btn:active {
    transform: scale(0.95);
  }

  .title-wrap{
    position:relative;
    text-align:center;
    margin-bottom:10px;
    z-index:1;
  }
  .title-text{
    font-family:'Luckiest Guy', cursive;
    font-size:clamp(26px,5vw,44px);
    letter-spacing:2px;
    margin:0;
    display:inline-block;
    background:linear-gradient(180deg,#fff5c8 0%, #ffcf4d 38%, #e0261b 78%, #7a1209 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    -webkit-text-stroke:1.4px #6e0f08;
    text-shadow:0 5px 12px rgba(0,0,0,.5);
  }
  .flourish{ color:#ffb142; font-size:1em; margin:0 8px; }

  .reel-frame{
    position:relative;
    z-index:1;
    border:5px solid var(--gold);
    border-radius:6px;
    box-shadow:inset 0 0 0 2px #6e3f0c, 0 12px 28px rgba(0,0,0,.5);
    overflow:hidden;
    line-height:0;
  }
  canvas#reels{
    display:block;
    width:100%;
    background:#1b0712;
  }

  .sparkle{
    position:absolute;
    width:4px;height:4px;
    background:#fff8d8;
    border-radius:50%;
    box-shadow:0 0 6px 2px rgba(255,222,140,0.85);
    opacity:0;
    pointer-events:none;
    z-index:0;
    animation:twinkle 3s ease-in-out infinite;
  }
  @keyframes twinkle{
    0%,100%{ opacity:0; transform:scale(.4); }
    50%{ opacity:1; transform:scale(1); }
  }

  .win-banner{
    position:absolute;
    left:50%;
    top:0;
    display:flex;
    align-items:center;
    gap:10px;
    background:linear-gradient(#9a1626,#5e0c16);
    border:2px solid var(--gold);
    border-radius:6px;
    padding:5px 20px;
    z-index:4;
    opacity:0;
    pointer-events:none;
    transform:translate(-50%,-14px) scale(.85);
    transition:opacity .25s, transform .25s;
    box-shadow:0 6px 18px rgba(0,0,0,.55);
    white-space:nowrap;
  }
  .win-banner.show{
    opacity:1;
    transform:translate(-50%,0) scale(1);
  }
  .win-banner .diamond{ color:var(--gold-light); font-size:16px; }
  .win-banner .amount{
    font-family:'Luckiest Guy',cursive;
    font-size:clamp(18px,3.2vw,26px);
    letter-spacing:1px;
    background:linear-gradient(180deg,#fff5c8 0%, #ffcf4d 45%, #e0261b 100%);
    -webkit-background-clip:text; background-clip:text; color:transparent;
    -webkit-text-stroke:1px #6e0f08;
  }

  .info-bar{
    position:relative;
    z-index:1;
    margin:14px 0 0;
    background:#000;
    border:3px solid var(--gold);
    border-radius:6px;
    padding:10px 14px;
    text-align:center;
    color:#ffd54a;
    font-weight:700;
    font-size:clamp(12px,2.2vw,18px);
    letter-spacing:.3px;
    line-height:1.45;
    min-height:38px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.8);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .stage-bottom-pad{ height:14px; }

  /* ---------- controls ---------- */
  .controls-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 12px 16px;
    background: linear-gradient(#1e0e24, #0d0410);
    border-top: 2px solid #33153f;
    flex-wrap: wrap;
  }
  
  .control-stats {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }
  
  .ctrl-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
  }
  
  .ctrl-label {
    color: #ffd9a0;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
  }
  
  .ctrl-val-box {
    background: #000;
    border: 2px solid var(--gold);
    border-radius: 6px;
    padding: 4px 12px;
    min-width: 100px;
    text-align: center;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: inset 0 0 8px rgba(0,0,0,0.9);
  }
  
  .ctrl-adjuster-box {
    padding: 0;
    min-width: 120px;
    justify-content: space-between;
    overflow: hidden;
  }
  
  .ctrl-adj-btn {
    width: 32px;
    height: 100%;
    background: var(--gold);
    border: none;
    color: #3a1d00;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }
  .ctrl-adj-btn:disabled {
    background: #424242;
    color: #757575;
    cursor: not-allowed;
  }
  
  .ctrl-val {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    font-variant-numeric: tabular-nums;
  }
  
  .control-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }
  
  .action-btn-rect {
    background: linear-gradient(#ffd76a, #c8860a);
    border: 2px solid var(--gold-dark);
    color: #3a1d00;
    font-family: 'Oswald', sans-serif;
    font-weight: 800;
    padding: 0 16px;
    height: 48px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    line-height: 1.2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
    transition: all 0.1s ease;
  }
  .action-btn-rect:active {
    transform: translateY(1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.4);
  }
  .action-btn-rect.active {
    background: linear-gradient(#9beb7f, #3a9a2c);
    color: #0c2906;
    border-color: #1f5e15;
  }
  
  .spin-control-group {
    display: flex;
    align-items: center;
    background: #000;
    border: 2px solid var(--gold);
    border-radius: 30px;
    padding: 2px;
    height: 60px;
    box-shadow: inset 0 0 8px rgba(0,0,0,0.8);
  }
  
  .spin-bet-adj {
    width: 38px;
    height: 100%;
    background: none;
    border: none;
    color: var(--gold);
    font-family: 'Oswald', sans-serif;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    line-height: 1;
    transition: all 0.2s;
  }
  .spin-bet-adj:hover {
    color: #fff;
  }
  .spin-bet-adj:disabled {
    color: #424242;
    cursor: not-allowed;
  }
  
  .spin-btn-main {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 30%, #ffcf66, #c8860a 60%, #7a4a06 100%);
    border: 3.5px solid var(--gold-light);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    transition: transform 0.1s;
  }
  .spin-btn-main svg {
    width: 22px;
    height: 22px;
    fill: #3a1d00;
    transition: transform 0.2s;
  }
  .spin-btn-main:active {
    transform: scale(0.95);
  }
  .spin-btn-main.spinning svg {
    animation: spin 0.6s linear infinite;
  }
  @keyframes spin{ to{ transform:rotate(360deg); } }

  /* ---------- help modal ---------- */
  .help-modal{
    position:absolute; inset:0;
    background:rgba(0,0,0,.72);
    display:none;
    align-items:center; justify-content:center;
    z-index:5;
    padding:20px;
  }
  .help-modal.show{ display:flex; }
  .help-box{
    background:#16243f;
    border:3px solid var(--gold);
    border-radius:10px;
    padding:18px 20px;
    max-width:380px;
    color:#fbe9c5;
    font-size:13px;
    line-height:1.6;
  }
  .help-box h3{ margin:0 0 10px; color:var(--gold-light); font-family:'Luckiest Guy',cursive; letter-spacing:1px; font-size:18px;}
  .help-box button{
    margin-top:12px;
    background:var(--gold); border:none; color:#3a1d00; font-weight:800;
    padding:8px 14px; border-radius:6px; cursor:pointer; font-size:12px;
  }

  @media (max-width:768px){
    .controls-bar {
      justify-content: center;
      gap: 12px;
    }
    .control-stats {
      width: 100%;
      justify-content: center;
    }
    .control-actions {
      width: 100%;
      justify-content: center;
    }
  }
  /* Extra Gifts Modal */
  .eg-modal {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99;
    padding: 20px;
  }
  .eg-modal.show {
    display: flex;
  }
  .eg-modal-content {
    background: linear-gradient(#2f0724, #14020f);
    border: 3px solid var(--gold);
    border-radius: 12px;
    padding: 20px 24px;
    max-width: 540px;
    width: 100%;
    color: #fff;
    text-align: center;
    box-shadow: 0 12px 36px rgba(0,0,0,0.8), 0 0 15px rgba(255, 215, 0, 0.2);
  }
  .eg-modal-header {
    margin-bottom: 16px;
  }
  .eg-modal-title {
    font-family: 'Luckiest Guy', cursive;
    font-size: 28px;
    letter-spacing: 1px;
    background: linear-gradient(180deg, #fff5c8, #ffcf4d, #e0261b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-stroke: 1.2px #6e0f08;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
  }
  .eg-volatility-options {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin: 16px 0;
  }
  .eg-opt-card {
    flex: 1;
    background: radial-gradient(circle, #550742 0%, #21031a 100%);
    border: 2px solid #5e0d4c;
    border-radius: 8px;
    padding: 12px 8px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    min-height: 140px;
    transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), border-color 0.3s, box-shadow 0.3s;
    transform-style: preserve-3d;
    perspective: 600px;
  }
  .eg-opt-card:hover {
    border-color: #ffd54f;
    transform: perspective(600px) rotateX(10deg) rotateY(-4deg) translateY(-8px) scale(1.04);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.65), 0 0 15px rgba(255, 213, 79, 0.25);
  }
  .eg-opt-card.active {
    animation: cardGlowPulse 2.2s ease-in-out infinite;
    transform: scale(1.05) translateZ(12px);
    border-color: var(--gold);
    background: radial-gradient(circle, #8f0d6c 0%, #3a072d 100%);
  }
  @keyframes cardGlowPulse {
    0%, 100% { box-shadow: 0 0 12px rgba(255, 215, 0, 0.4), inset 0 0 15px rgba(255, 215, 0, 0.2); }
    50% { box-shadow: 0 0 28px rgba(255, 215, 0, 0.9), inset 0 0 28px rgba(255, 215, 0, 0.45); }
  }
  .eg-gift-svg {
    transition: transform 0.3s ease;
  }
  .eg-opt-card.active .eg-gift-svg:nth-child(odd) {
    animation: floatGiftOdd 3s ease-in-out infinite;
  }
  .eg-opt-card.active .eg-gift-svg:nth-child(even) {
    animation: floatGiftEven 3s ease-in-out infinite;
  }
  @keyframes floatGiftOdd {
    0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
    50% { transform: translateY(-5px) rotate(4deg) scale(1.06); }
  }
  @keyframes floatGiftEven {
    0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
    50% { transform: translateY(-7px) rotate(-4deg) scale(1.06); }
  }
  .eg-opt-num {
    font-family: 'Luckiest Guy', cursive;
    font-size: 32px;
    color: #ffbe1a;
    -webkit-text-stroke: 0.8px #3a1d00;
  }
  .eg-opt-label {
    font-size: 11px;
    font-weight: 700;
    color: #ffd9a0;
    line-height: 1.2;
    margin: 6px 0;
  }
  .eg-opt-gifts {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
  }
  .eg-opt-gifts .eg-gift-icon {
    font-size: 16px;
  }
  .eg-modal-info {
    font-size: 11px;
    color: #fbe9c5;
    line-height: 1.4;
    margin: 16px 0;
    text-align: center;
    background: rgba(0,0,0,0.3);
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.05);
  }
  .eg-modal-actions {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-top: 14px;
  }
  .eg-action-btn {
    width: 60px;
    height: 38px;
    border-radius: 6px;
    border: 2px solid var(--gold);
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    overflow: hidden;
  }
  .eg-action-btn::after {
    content: '';
    position: absolute;
    top: -50%; left: -150%;
    width: 200%; height: 200%;
    background: linear-gradient(
      to right,
      rgba(255, 255, 255, 0) 0%,
      rgba(255, 255, 255, 0.35) 30%,
      rgba(255, 255, 255, 0) 60%
    );
    transform: rotate(30deg);
    transition: all 0.5s;
    opacity: 0;
    pointer-events: none;
  }
  .eg-action-btn:hover {
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 6px 12px rgba(0,0,0,0.4), 0 0 8px rgba(255, 215, 0, 0.2);
  }
  .eg-action-btn:hover::after {
    animation: sheen 1.5s infinite;
    opacity: 1;
  }
  @keyframes sheen {
    0% { left: -150%; }
    100% { left: 150%; }
  }
  .eg-action-btn:active {
    transform: scale(0.95) translateY(0);
    box-shadow: 0 2px 4px rgba(0,0,0,0.4);
  }
  .eg-action-btn.red-btn {
    background: linear-gradient(#f44336, #b71c1c);
    color: #fff;
    font-weight: 900;
  }
  .eg-action-btn.green-btn {
    background: linear-gradient(#4caf50, #1b5e20);
    color: #fff;
    font-weight: 900;
  }
  </style>
</head>
<body>

<!-- TOP NAV BAR -->
<div class="topnav">
  <span class="breadcrumb"><a href="{{ route('dashboard') }}"><i class="fa-solid fa-house" style="font-size:11px;"></i></a> / <a href="#" onclick="window.location.href='{{ route('dashboard') }}'; return false;">Search results</a></span>
  <span class="gametitle">Lucky Joker 100 Extra Gifts</span>
  
  <!-- PLAY MODE TOGGLE SWITCH -->
  <div class="tgb-toggle" id="modeToggleTop" style="cursor: pointer; display: flex; align-items: center; gap: 8px; margin-left: 20px; user-select: none;">
    <div class="toggle-track" id="modeTrackTop" style="width:36px; height:18px; background:#333; border-radius:9px; position:relative; border:1px solid #555; transition: all 0.2s;">
      <div class="toggle-knob" id="modeKnobTop" style="position:absolute; top:1px; left:2px; width:14px; height:14px; background:#fff; border-radius:50%; transition: left 0.2s;"></div>
    </div>
    <span class="tgb-play" id="modeTextTop" style="color:#4a9eff; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">PLAY FOR REAL MONEY</span>
  </div>

  <!-- WINDOW ACTIONS -->
  <div class="tgb-actions" style="margin-left: auto; display: flex; gap: 12px; align-items: center;">
    <button class="icon-btn" style="border-radius: 4px; font-size: 11px; width: 22px; height: 22px;" title="Minimize"><i class="fa-solid fa-minus" style="font-size: 8px;"></i></button>
    <button class="icon-btn" style="border-radius: 4px; font-size: 11px; width: 22px; height: 22px;" title="Maximize"><i class="fa-solid fa-expand" style="font-size: 8px;"></i></button>
    <button class="icon-btn" onclick="window.location.reload();" style="border-radius: 4px; font-size: 11px; width: 22px; height: 22px;" title="Refresh"><i class="fa-solid fa-rotate-right" style="font-size: 8px;"></i></button>
    <button class="icon-btn" style="border-radius: 4px; font-size: 11px; width: 22px; height: 22px;" title="Favorite"><i class="fa-regular fa-star" style="font-size: 8px;"></i></button>
    <button class="icon-btn" onclick="window.location.href='{{ route('dashboard') }}'" style="border-radius: 4px; font-size: 11px; width: 22px; height: 22px;" title="Close"><i class="fa-solid fa-xmark" style="font-size: 8px;"></i></button>
  </div>
</div>

<!-- SIDEBAR NAV -->
<div class="sidenav">
  <div class="icon active" onclick="window.location.href='{{ route('dashboard') }}'" title="Favorites">
    <i class="fa-solid fa-heart"></i>
  </div>
  <div class="icon" onclick="window.location.href='{{ route('dashboard') }}'" title="Slots">
    <i class="fa-solid fa-table-cells-large"></i>
  </div>
  <div class="icon" onclick="window.location.href='{{ route('dashboard') }}'" title="Promotion">
    <i class="fa-solid fa-arrow-pointer"></i>
  </div>
  <div class="icon" onclick="window.location.href='{{ route('dashboard') }}'" title="Tournaments">
    <i class="fa-solid fa-trophy"></i>
  </div>
  <div class="icon" onclick="window.location.href='{{ route('play') }}'" title="1xGames">
    <i class="fa-solid fa-gamepad"></i>
  </div>
</div>

<!-- BOTTOM BAR -->
<div class="bottombar">
  <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-clock" style="font-size:12px; margin-right:4px;"></i> Recent Games</div>
  <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-bolt" style="font-size:12px; margin-right:4px;"></i> New</div>
  <div class="tab" onclick="window.location.href='{{ route('dashboard') }}'"><i class="fa-solid fa-star" style="font-size:12px; margin-right:4px;"></i> Favorites</div>
  
  <input type="text" class="search-box" placeholder="Search" value="Lucky Joker 100" style="margin-left: auto;">
  
  <div class="grid-icons">
    <div class="grid-icon active"><i class="fa-solid fa-grip"></i></div>
    <div class="grid-icon"><i class="fa-solid fa-list"></i></div>
  </div>
</div>

<div class="game-container-wrapper">
  <div class="machine">

    <div class="machine-top">
      <div class="timer" id="timer">05:00</div>
      <div class="top-right">
        <div class="badge-free" id="modeBadge">FREEPLAY</div>
        <div class="icon-btn" id="helpBtn" title="How to play">?</div>
        <div class="icon-btn" id="soundBtn" title="Mute / unmute">&#128266;</div>
        <div class="icon-btn" id="turboBtn" title="Turbo spin">&#9881;</div>
      </div>
    </div>

    <div class="stage">

      <div class="help-modal" id="helpModal">
        <div class="help-box">
          <h3>How to play</h3>
          <p>Match 3, 4 or 5 of the same symbol on a row, left to right, to win. The <b>Wild</b> symbol appears only on reels 2, 3 and 4 and substitutes for any other symbol on its reel.</p>
          <p>Use the <b>+ / −</b> buttons to set your bet, hit the gold spin button to play, or turn on <b>AUTO</b> to spin automatically.</p>
          <button id="helpClose">Got it</button>
        </div>
      </div>

      <!-- Extra Gifts Volatility Modal -->
      <div class="eg-modal" id="egModal">
        <div class="eg-modal-content">
          <div class="eg-modal-header">
            <span class="eg-modal-title">Extra Gifts</span>
          </div>
          
          <div class="eg-volatility-options">
            <!-- 10 Low Volatility Card -->
            <div class="eg-opt-card" data-val="10" onclick="selectVolatilityCard(10)">
              <span class="eg-opt-num">10</span>
              <span class="eg-opt-label">VOLATILITY:<br>LOW</span>
              <div class="eg-opt-gifts">
                <!-- Gift 1: Green Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="32" height="32" style="filter: drop-shadow(0 3px 5px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#4caf50" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#388e3c" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
                <!-- Gift 2: Purple Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="32" height="32" style="filter: drop-shadow(0 3px 5px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#9c27b0" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#7b1fa2" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
              </div>
            </div>
            
            <!-- 30 Medium Volatility Card -->
            <div class="eg-opt-card" data-val="30" onclick="selectVolatilityCard(30)">
              <span class="eg-opt-num">30</span>
              <span class="eg-opt-label">VOLATILITY:<br>MEDIUM</span>
              <div class="eg-opt-gifts">
                <!-- Gift 1: Green Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="28" height="28" style="filter: drop-shadow(0 3px 5px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#4caf50" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#388e3c" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
                <!-- Gift 2: Red Box, Green Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="28" height="28" style="filter: drop-shadow(0 3px 5px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#e53935" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#c62828" />
                  <rect x="28" y="16" width="8" height="42" fill="#4caf50" />
                  <rect x="8" y="38" width="48" height="6" fill="#4caf50" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#4caf50" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#4caf50" />
                  <circle cx="32" cy="16" r="4" fill="#388e3c" />
                </svg>
                <!-- Gift 3: Purple Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="28" height="28" style="filter: drop-shadow(0 3px 5px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#9c27b0" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#7b1fa2" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
              </div>
            </div>
            
            <!-- 50 High Volatility Card -->
            <div class="eg-opt-card" data-val="50" onclick="selectVolatilityCard(50)">
              <span class="eg-opt-num">50</span>
              <span class="eg-opt-label">VOLATILITY:<br>HIGH</span>
              <div class="eg-opt-gifts">
                <!-- Gift 1: Green Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="24" height="24" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#4caf50" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#388e3c" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
                <!-- Gift 2: Red Box, Green Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="24" height="24" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#e53935" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#c62828" />
                  <rect x="28" y="16" width="8" height="42" fill="#4caf50" />
                  <rect x="8" y="38" width="48" height="6" fill="#4caf50" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#4caf50" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#4caf50" />
                  <circle cx="32" cy="16" r="4" fill="#388e3c" />
                </svg>
                <!-- Gift 3: Blue Box, Magenta Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="24" height="24" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#00bcd4" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#0097a7" />
                  <rect x="28" y="16" width="8" height="42" fill="#e91e63" />
                  <rect x="8" y="38" width="48" height="6" fill="#e91e63" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#e91e63" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#e91e63" />
                  <circle cx="32" cy="16" r="4" fill="#c2185b" />
                </svg>
                <!-- Gift 4: Purple Box, Yellow Ribbon -->
                <svg class="eg-gift-svg" viewBox="0 0 64 64" width="24" height="24" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.45));">
                  <rect x="8" y="24" width="48" height="34" rx="4" fill="#9c27b0" />
                  <rect x="4" y="16" width="56" height="10" rx="2" fill="#7b1fa2" />
                  <rect x="28" y="16" width="8" height="42" fill="#ffeb3b" />
                  <rect x="8" y="38" width="48" height="6" fill="#ffeb3b" />
                  <path d="M 32 16 C 24 6, 12 10, 24 16 Z" fill="#ffeb3b" />
                  <path d="M 32 16 C 40 6, 52 10, 40 16 Z" fill="#ffeb3b" />
                  <circle cx="32" cy="16" r="4" fill="#fdd835" />
                </svg>
              </div>
            </div>
          </div>
          
          <div class="eg-modal-info">
            8 or more GIFT symbols on any position award and trigger GIFT SPIN feature.<br>
            A higher EXTRA BET increases the chances of winning the GIFT SPIN feature and<br>
            more valuable GIFT symbols and MYSTERY GIFT symbols.
          </div>
          
          <div class="eg-modal-actions">
            <!-- Cancel Button -->
            <button class="eg-action-btn red-btn" id="egCancelBtn">
              <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#ffe9a8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
            <!-- Confirm Button -->
            <button class="eg-action-btn green-btn" id="egConfirmBtn">
              <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#ffe9a8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="title-wrap">
        <span class="title-text"><span class="flourish">✿</span>LUCKY JOKER 100<span class="flourish">✿</span></span>
      </div>

      <div class="game-play-area">
        <!-- Left: Extra Gifts Panel -->
        <div class="extra-gifts-panel" id="extraGiftsPanel">
          <div class="eg-header">
            <span class="eg-title">Extra<br>Gifts</span>
          </div>
          
          <div class="eg-bet-box">
            <div class="eg-bet-label">BET</div>
            <div class="eg-bet-val" id="egBetVal">50.00</div>
          </div>
          
          <div class="eg-list">
            <div class="eg-item">
              <span class="eg-gift-icon" style="color: #00bcd4;">🎁</span>
              <div class="eg-item-text">
                <span class="eg-mult">x20-x250</span>
                <span class="eg-sub">MYSTERY</span>
              </div>
            </div>
            <div class="eg-item">
              <span class="eg-gift-icon" style="color: #ff9800;">🎁</span>
              <div class="eg-item-text">
                <span class="eg-mult">x100-x250</span>
              </div>
            </div>
            <div class="eg-item">
              <span class="eg-gift-icon" style="color: #4caf50;">🎁</span>
              <div class="eg-item-text">
                <span class="eg-mult">x30-x75</span>
              </div>
            </div>
            <div class="eg-item">
              <span class="eg-gift-icon" style="color: #f44336;">🎁</span>
              <div class="eg-item-text">
                <span class="eg-mult">x10-x25</span>
              </div>
            </div>
            <div class="eg-item">
              <span class="eg-gift-icon" style="color: #9c27b0;">🎁</span>
              <div class="eg-item-text">
                <span class="eg-mult">x1-x8</span>
              </div>
            </div>
          </div>
          
          <div class="eg-controls">
            <button class="eg-switch-btn" id="egSwitchBtn" title="Toggle Extra Gifts"></button>
            <button class="eg-close-btn" id="egCloseBtn" title="Close Panel">✕</button>
          </div>
        </div>

        <!-- Right: Canvas Reels Frame -->
        <div class="reel-frame" style="flex: 1;">
          <canvas id="reels" width="850" height="438"></canvas>
        </div>
      </div>

      <div class="win-banner" id="winBanner">
        <span class="diamond">&#9670;</span>
        <span class="amount" id="winBannerAmount">0</span>
        <span class="diamond">&#9670;</span>
      </div>

      <div class="info-bar" id="infoBar">THE WILD SYMBOL APPEARS ONLY ON REEL 2, 3, 4 AND REPLACES ANY SYMBOL ON THE SAME REEL</div>
      <div class="stage-bottom-pad"></div>
    </div>

    <!-- Bottom Controls Bar -->
    <div class="controls-bar">
      <!-- Left: stats -->
      <div class="control-stats">
        
        <div class="ctrl-box">
          <span class="ctrl-label" id="balanceLabel">FREEPLAY</span>
          <div class="ctrl-val-box">
            <span class="ctrl-val" id="balanceVal">10,000.00</span>
          </div>
        </div>

        <div class="ctrl-box">
          <span class="ctrl-label">LINES</span>
          <div class="ctrl-val-box ctrl-adjuster-box">
            <button class="ctrl-adj-btn" id="linesMinus" disabled>&minus;</button>
            <span class="ctrl-val">100</span>
            <button class="ctrl-adj-btn" id="linesPlus" disabled>+</button>
          </div>
        </div>

        <div class="ctrl-box">
          <span class="ctrl-label">BET</span>
          <div class="ctrl-val-box">
            <span class="ctrl-val" id="betVal">50.00</span>
          </div>
        </div>

      </div>

      <!-- Right: actions -->
      <div class="control-actions">
        
        <button class="action-btn-rect" id="maxBetBtn">MAX<br>BET</button>
        
        <button class="action-btn-rect" id="autoBtn" style="padding: 0 10px;">
          <span style="font-size: 11px;">AUTO</span>
          <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" style="margin-top: 2px;">
            <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
          </svg>
        </button>

        <div class="spin-control-group">
          <button class="spin-bet-adj" id="betMinusBtn">&minus;<br><span style="font-size: 8px;">BET</span></button>
          <div class="spin-btn-main" id="spinBtn" title="Spin">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74A7.93 7.93 0 0 0 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z" fill="#3a1d00"/>
            </svg>
          </div>
          <button class="spin-bet-adj" id="betPlusBtn">+<br><span style="font-size: 8px;">BET</span></button>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
(function(){
  "use strict";

  /* ============ dynamic state variables ============ */
  const userCurrency = "{{ auth()->user()->currency }}";
  const currencySymbol = userCurrency === 'BDT' ? '৳' : (userCurrency === 'INR' ? '₹' : '$');
  const realBalance = parseFloat("{{ auth()->user()->balance }}");

  const urlParams = new URLSearchParams(window.location.search);
  let isDemoMode = urlParams.get('demo') === '1' || (realBalance < 10);
  
  let demoBalance = 10000.00;
  let balance = isDemoMode ? demoBalance : realBalance;
  let extraGiftsActive = false;
  let selectedVolatility = 30;
  let extraBetPrice = 30;

  // Wild mascot image loading
  const wildImage = new Image();
  let wildImageLoaded = false;
  wildImage.onload = () => {
    wildImageLoaded = true;
  };
  wildImage.src = "{{ asset('assets/image/lucky_joker_wild.png') }}";

  /* ============ canvas & layout ============ */
  const canvas = document.getElementById('reels');
  const ctx = canvas.getContext('2d');
  const COLS = 5, ROWS = 3;
  const LOGICAL_W = 850, LOGICAL_H = 438;
  const cellW = LOGICAL_W / COLS, cellH = LOGICAL_H / ROWS;

  function fitCanvas(){
    const dpr = window.devicePixelRatio || 1;
    const cssWidth = canvas.clientWidth || LOGICAL_W;
    const cssHeight = cssWidth * (LOGICAL_H / LOGICAL_W);
    canvas.style.height = cssHeight + 'px';
    canvas.width = Math.round(cssWidth * dpr);
    canvas.height = Math.round(cssHeight * dpr);
    const scale = (cssWidth * dpr) / LOGICAL_W;
    ctx.setTransform(scale, 0, 0, scale, 0, 0);
  }
  window.addEventListener('resize', fitCanvas);

  /* ============ symbols ============ */
  const WILD = 9;
  const SYMBOLS = [
    { id:0, name:'Cherries',   pay:{3:5,  4:15, 5:50}  },
    { id:1, name:'Plum',       pay:{3:5,  4:15, 5:50}  },
    { id:2, name:'Orange',     pay:{3:8,  4:20, 5:60}  },
    { id:3, name:'Star',       pay:{3:10, 4:25, 5:80}  },
    { id:4, name:'Grapes',     pay:{3:8,  4:20, 5:60}  },
    { id:5, name:'Watermelon', pay:{3:10, 4:25, 5:80}  },
    { id:6, name:'Seven',      pay:{3:20, 4:60, 5:200} },
    { id:7, name:'Horseshoe',  pay:{3:15, 4:40, 5:120} },
    { id:8, name:'Bell',       pay:{3:12, 4:30, 5:100} },
  ];
  const WILD_REELS = [1,2,3];

  function randomSymbolFor(col){
    const wildChance = extraGiftsActive ? 0.20 : 0.10;
    if (WILD_REELS.includes(col) && Math.random() < wildChance) return WILD;
    return Math.floor(Math.random() * SYMBOLS.length);
  }

  /* ---- individual symbol painters, drawn around (0,0), scale s ---- */
  function pCherries(c,s){
    c.save();
    c.strokeStyle = '#2e7d32'; c.lineWidth = s*0.09; c.lineCap='round';
    c.beginPath();
    c.moveTo(0,-s*0.95); c.quadraticCurveTo(-s*0.28,-s*0.55,-s*0.34,-s*0.12);
    c.moveTo(0,-s*0.95); c.quadraticCurveTo(s*0.3,-s*0.5,s*0.36,-s*0.05);
    c.stroke();
    c.fillStyle = '#4caf50';
    c.beginPath(); c.ellipse(s*0.12,-s*0.98,s*0.26,s*0.13,-0.5,0,Math.PI*2); c.fill();
    function ball(cx,cy){
      const g = c.createRadialGradient(cx-s*0.12,cy-s*0.12,s*0.05,cx,cy,s*0.4);
      g.addColorStop(0,'#ff8a80'); g.addColorStop(0.55,'#e53935'); g.addColorStop(1,'#a3121f');
      c.fillStyle = g;
      c.beginPath(); c.arc(cx,cy,s*0.38,0,Math.PI*2); c.fill();
    }
    ball(-s*0.34,s*0.18); ball(s*0.36,s*0.12);
    c.restore();
  }
  function pPlum(c,s){
    c.save();
    c.strokeStyle = '#2e7d32'; c.lineWidth = s*0.08;
    c.beginPath(); c.moveTo(0,-s*0.95); c.quadraticCurveTo(s*0.05,-s*0.55,0,-s*0.42); c.stroke();
    c.fillStyle = '#4caf50';
    c.beginPath(); c.ellipse(s*0.2,-s*0.85,s*0.26,s*0.13,-0.4,0,Math.PI*2); c.fill();
    const g = c.createRadialGradient(-s*0.15,-s*0.1,s*0.08,0,s*0.05,s*0.55);
    g.addColorStop(0,'#c79bff'); g.addColorStop(0.5,'#8b3fd1'); g.addColorStop(1,'#4a1273');
    c.fillStyle = g;
    c.beginPath(); c.ellipse(0,s*0.08,s*0.46,s*0.5,0,0,Math.PI*2); c.fill();
    c.fillStyle = 'rgba(255,255,255,0.35)';
    c.beginPath(); c.ellipse(-s*0.18,-s*0.12,s*0.1,s*0.18,-0.5,0,Math.PI*2); c.fill();
    c.restore();
  }
  function pOrange(c,s){
    c.save();
    c.fillStyle = '#4caf50';
    c.beginPath(); c.ellipse(s*0.05,-s*0.88,s*0.22,s*0.12,-0.3,0,Math.PI*2); c.fill();
    const g = c.createRadialGradient(-s*0.15,-s*0.15,s*0.1,0,0,s*0.6);
    g.addColorStop(0,'#ffd166'); g.addColorStop(0.55,'#f5941f'); g.addColorStop(1,'#c4630a');
    c.fillStyle = g;
    c.beginPath(); c.arc(0,0,s*0.55,0,Math.PI*2); c.fill();
    c.strokeStyle='rgba(255,255,255,0.3)'; c.lineWidth=s*0.04;
    for(let a=0;a<Math.PI*2;a+=Math.PI/4){
      c.beginPath(); c.moveTo(0,0); c.lineTo(Math.cos(a)*s*0.5, Math.sin(a)*s*0.5); c.stroke();
    }
    c.restore();
  }
  function pStar(c,s){
    c.save();
    const g1 = c.createRadialGradient(0,0,s*0.1,0,0,s*0.62);
    g1.addColorStop(0,'#4fa8e0'); g1.addColorStop(1,'#1b4a78');
    c.fillStyle = g1;
    c.beginPath(); c.arc(0,0,s*0.62,0,Math.PI*2); c.fill();
    c.strokeStyle = '#ffe9a8'; c.lineWidth = s*0.05; c.stroke();
    drawStarPath(c, 0,0, s*0.5, s*0.22, 5);
    const g2 = c.createLinearGradient(0,-s*0.5,0,s*0.5);
    g2.addColorStop(0,'#fff3c0'); g2.addColorStop(1,'#e0a312');
    c.fillStyle = g2; c.fill();
    c.restore();
  }
  function drawStarPath(c,cx,cy,rOuter,rInner,points){
    c.beginPath();
    for(let i=0;i<points*2;i++){
      const r = i%2===0 ? rOuter : rInner;
      const a = (Math.PI/points)*i - Math.PI/2;
      const x = cx + Math.cos(a)*r, y = cy + Math.sin(a)*r;
      if(i===0) c.moveTo(x,y); else c.lineTo(x,y);
    }
    c.closePath();
  }
  function pGrapes(c,s){
    c.save();
    c.fillStyle = '#4caf50';
    c.beginPath(); c.ellipse(-s*0.05,-s*0.95,s*0.24,s*0.13,0.3,0,Math.PI*2); c.fill();
    const positions = [
      [0,-s*0.55],[-s*0.28,-s*0.32],[s*0.28,-s*0.32],
      [-s*0.42,-s*0.02],[0,-s*0.05],[s*0.42,-s*0.02],
      [-s*0.24,s*0.28],[s*0.24,s*0.28],[0,s*0.5]
    ];
    for(const [x,y] of positions){
      const g = c.createRadialGradient(x-s*0.06,y-s*0.06,s*0.03,x,y,s*0.2);
      g.addColorStop(0,'#b39ddb'); g.addColorStop(0.6,'#6a3fb0'); g.addColorStop(1,'#3a1d6b');
      c.fillStyle = g;
      c.beginPath(); c.arc(x,y,s*0.19,0,Math.PI*2); c.fill();
    }
    c.restore();
  }
  function pWatermelon(c,s){
    c.save();
    c.save();
    c.beginPath();
    c.moveTo(-s*0.55,s*0.05); c.lineTo(s*0.55,s*0.05);
    c.arc(0,0.05*s,s*0.6,0,Math.PI,false);
    c.closePath();
    c.fillStyle = '#c4202b'; c.fill();
    c.beginPath();
    c.moveTo(-s*0.5,s*0.02); c.lineTo(s*0.5,s*0.02);
    c.arc(0,0.02*s,s*0.5,0,Math.PI,false);
    c.closePath();
    c.fillStyle='#e8453f'; c.fill();
    c.restore();
    c.strokeStyle = '#1e7d32'; c.lineWidth = s*0.1; c.lineCap='round';
    c.beginPath(); c.arc(0,0.05*s,s*0.6,0.05,Math.PI-0.05,false); c.stroke();
    c.strokeStyle = '#eafff0'; c.lineWidth = s*0.04;
    c.beginPath(); c.arc(0,0.05*s,s*0.54,0.08,Math.PI-0.08,false); c.stroke();
    c.fillStyle = '#1b1b1b';
    const seeds = [[-s*0.22,s*0.26],[0,s*0.4],[s*0.22,s*0.26],[-s*0.12,s*0.16],[s*0.12,s*0.16]];
    for(const [x,y] of seeds){
      c.save(); c.translate(x,y); c.rotate(0.3);
      c.beginPath(); c.ellipse(0,0,s*0.05,s*0.08,0,0,Math.PI*2); c.fill();
      c.restore();
    }
    c.restore();
  }
  function pSeven(c,s){
    c.save();
    c.font = `bold ${s*1.3}px Oswald, sans-serif`;
    c.textAlign='center'; c.textBaseline='middle';
    const g = c.createLinearGradient(0,-s*0.6,0,s*0.6);
    g.addColorStop(0,'#ffe9a8'); g.addColorStop(0.45,'#f4c430'); g.addColorStop(0.46,'#e0261b'); g.addColorStop(1,'#7a1209');
    c.fillStyle = g;
    c.strokeStyle = '#5c0d06'; c.lineWidth = s*0.09;
    c.strokeText('7',0,s*0.06);
    c.fillText('7',0,s*0.06);
    c.restore();
  }
  function pHorseshoe(c,s){
    c.save();
    const g = c.createLinearGradient(-s*0.5,0,s*0.5,0);
    g.addColorStop(0,'#a76a0a'); g.addColorStop(0.5,'#ffe9a8'); g.addColorStop(1,'#a76a0a');
    c.strokeStyle = g; c.lineWidth = s*0.34; c.lineCap='round';
    c.beginPath(); c.arc(0,s*0.05,s*0.42,Math.PI*0.12,Math.PI*0.88,false); c.stroke();
    c.fillStyle = '#5c3a06';
    const holes = [-0.85,-0.45,0.45,0.85];
    for(const hh of holes){
      const a = Math.PI*0.5 + hh*Math.PI*0.42;
      const x = Math.cos(a)*s*0.42, y = s*0.05 + Math.sin(a)*s*0.42;
      c.beginPath(); c.arc(x,y,s*0.05,0,Math.PI*2); c.fill();
    }
    c.restore();
  }
  function pBell(c,s){
    c.save();
    const g = c.createLinearGradient(-s*0.3,-s*0.3,s*0.3,s*0.3);
    g.addColorStop(0,'#ffe9a8'); g.addColorStop(0.5,'#ffd76a'); g.addColorStop(1,'#a76a0a');
    c.fillStyle = g;
    c.strokeStyle = '#5c3a06'; c.lineWidth = s*0.06;
    c.beginPath();
    c.arc(0, -s*0.6, s*0.18, 0, Math.PI*2);
    c.stroke();
    c.beginPath();
    c.moveTo(-s*0.1, -s*0.4);
    c.quadraticCurveTo(-s*0.2, -s*0.3, -s*0.22, -s*0.1);
    c.quadraticCurveTo(-s*0.25, s*0.2, -s*0.48, s*0.35);
    c.lineTo(s*0.48, s*0.35);
    c.quadraticCurveTo(s*0.25, s*0.2, s*0.22, -s*0.1);
    c.quadraticCurveTo(s*0.1, -s*0.3, s*0.1, -s*0.4);
    c.closePath();
    c.fill(); c.stroke();
    c.fillStyle = '#ffb142';
    c.beginPath();
    c.arc(0, s*0.42, s*0.12, 0, Math.PI*2);
    c.fill(); c.stroke();
    c.fillStyle = g;
    roundRectPath(c, -s*0.52, s*0.28, s*1.04, s*0.12, s*0.06);
    c.fill(); c.stroke();
    c.restore();
  }
  function pWild(c,s){
    c.save();
    const glow = c.createRadialGradient(0,0,s*0.1,0,0,s*0.95);
    glow.addColorStop(0,'rgba(255,215,120,0.45)'); glow.addColorStop(1,'rgba(255,215,120,0)');
    c.fillStyle = glow; c.beginPath(); c.arc(0,s*0.05,s*0.95,0,Math.PI*2); c.fill();

    function hatPoint(angleDeg, color){
      c.save();
      c.rotate(angleDeg*Math.PI/180);
      c.fillStyle = color;
      c.beginPath();
      c.moveTo(0,-s*0.5);
      c.quadraticCurveTo(s*0.16,-s*0.8,0,-s*0.98);
      c.quadraticCurveTo(-s*0.16,-s*0.8,0,-s*0.5);
      c.closePath();
      c.fill();
      c.beginPath(); c.arc(0,-s*0.98,s*0.09,0,Math.PI*2);
      c.fillStyle = '#ffe9a8'; c.fill();
      c.restore();
    }
    hatPoint(-30,'#d4a017');
    hatPoint(0,'#7a1fbf');
    hatPoint(30,'#1a8a6e');

    /* wavy hair, sides */
    c.fillStyle = '#241409';
    c.beginPath();
    c.moveTo(-s*0.06,-s*0.4);
    c.quadraticCurveTo(-s*0.4,-s*0.36,-s*0.38,s*0.08);
    c.quadraticCurveTo(-s*0.4,s*0.34,-s*0.22,s*0.42);
    c.quadraticCurveTo(-s*0.32,s*0.2,-s*0.28,-s*0.05);
    c.quadraticCurveTo(-s*0.26,-s*0.28,-s*0.06,-s*0.4);
    c.closePath(); c.fill();
    c.beginPath();
    c.moveTo(s*0.06,-s*0.4);
    c.quadraticCurveTo(s*0.4,-s*0.36,s*0.38,s*0.08);
    c.quadraticCurveTo(s*0.4,s*0.34,s*0.22,s*0.42);
    c.quadraticCurveTo(s*0.32,s*0.2,s*0.28,-s*0.05);
    c.quadraticCurveTo(s*0.26,-s*0.28,s*0.06,-s*0.4);
    c.closePath(); c.fill();

    /* scalloped jester collar with bells */
    c.fillStyle = '#f4c430';
    c.fillRect(-s*0.4,s*0.42,s*0.8,s*0.12);
    const collarColors = ['#7a1fbf','#1a8a6e','#d4a017','#1a8a6e','#7a1fbf'];
    for(let i=0;i<5;i++){
      const cx = (i-2)*s*0.16;
      c.fillStyle = collarColors[i];
      c.beginPath();
      c.moveTo(cx-s*0.09,s*0.5); c.lineTo(cx,s*0.66); c.lineTo(cx+s*0.09,s*0.5);
      c.closePath(); c.fill();
      c.beginPath(); c.arc(cx,s*0.66,s*0.04,0,Math.PI*2);
      c.fillStyle = '#ffe9a8'; c.fill();
    }

    /* face */
    const skin = c.createLinearGradient(0,-s*0.4,0,s*0.45);
    skin.addColorStop(0,'#f6cba0'); skin.addColorStop(1,'#eab488');
    c.fillStyle = skin;
    c.beginPath();
    c.moveTo(0,-s*0.42);
    c.bezierCurveTo(s*0.32,-s*0.4, s*0.32,s*0.08, s*0.18,s*0.3);
    c.quadraticCurveTo(s*0.07,s*0.44,0,s*0.46);
    c.quadraticCurveTo(-s*0.07,s*0.44,-s*0.18,s*0.3);
    c.bezierCurveTo(-s*0.32,s*0.08,-s*0.32,-s*0.4,0,-s*0.42);
    c.closePath(); c.fill();

    /* blush */
    c.fillStyle = 'rgba(228,120,128,0.32)';
    c.beginPath(); c.ellipse(-s*0.2,s*0.1,s*0.07,s*0.04,0,0,Math.PI*2); c.fill();
    c.beginPath(); c.ellipse(s*0.2,s*0.1,s*0.07,s*0.04,0,0,Math.PI*2); c.fill();

    /* eyebrows */
    c.strokeStyle = '#1a0f06'; c.lineWidth = s*0.03; c.lineCap = 'round';
    c.beginPath(); c.moveTo(-s*0.23,-s*0.12); c.quadraticCurveTo(-s*0.13,-s*0.18,-s*0.03,-s*0.13); c.stroke();
    c.beginPath(); c.moveTo(s*0.04,-s*0.1); c.quadraticCurveTo(s*0.13,-s*0.15,s*0.22,-s*0.09); c.stroke();

    /* left eye, open */
    c.fillStyle = '#fff8f0';
    c.beginPath(); c.ellipse(-s*0.13,-s*0.02,s*0.09,s*0.05,-0.05,0,Math.PI*2); c.fill();
    c.fillStyle = '#3a2210';
    c.beginPath(); c.arc(-s*0.13,-s*0.01,s*0.04,0,Math.PI*2); c.fill();
    c.fillStyle = '#1a0f06';
    c.beginPath(); c.arc(-s*0.13,-s*0.01,s*0.018,0,Math.PI*2); c.fill();
    c.strokeStyle = '#1a0f06'; c.lineWidth = s*0.02;
    c.beginPath(); c.moveTo(-s*0.21,-s*0.05); c.lineTo(-s*0.25,-s*0.08); c.stroke();

    /* right eye, playful wink */
    c.strokeStyle = '#3a2210'; c.lineWidth = s*0.035; c.lineCap = 'round';
    c.beginPath(); c.moveTo(s*0.06,-s*0.01); c.quadraticCurveTo(s*0.13,s*0.03,s*0.2,-s*0.01); c.stroke();
    c.beginPath(); c.moveTo(s*0.2,-s*0.01); c.lineTo(s*0.24,-s*0.04); c.stroke();

    /* smiling lips */
    c.fillStyle = '#c4214a';
    c.beginPath();
    c.moveTo(-s*0.1,s*0.21);
    c.quadraticCurveTo(0,s*0.29,s*0.1,s*0.21);
    c.quadraticCurveTo(0,s*0.25,-s*0.1,s*0.21);
    c.closePath(); c.fill();

    /* beauty mark */
    c.fillStyle = '#3a2210';
    c.beginPath(); c.arc(s*0.15,s*0.19,s*0.012,0,Math.PI*2); c.fill();

    c.restore();
  }

  function roundRectPath(c,x,y,w,h,r){
    c.beginPath();
    c.moveTo(x+r,y);
    c.arcTo(x+w,y,x+w,y+h,r);
    c.arcTo(x+w,y+h,x,y+h,r);
    c.arcTo(x,y+h,x,y,r);
    c.arcTo(x,y,x+w,y,r);
    c.closePath();
  }

  function drawWildRibbon(x,y,w,h){
    ctx.save();
    ctx.translate(x+w/2, y+h/2);
    ctx.rotate(-0.1);
    const rw = w*0.94, rh = h*0.24;
    ctx.fillStyle = 'rgba(20,8,30,0.6)';
    ctx.fillRect(-rw/2,-rh/2,rw,rh);
    ctx.strokeStyle = '#ffd76a'; ctx.lineWidth = 2;
    ctx.strokeRect(-rw/2,-rh/2,rw,rh);
    ctx.fillStyle = '#ffd76a';
    ctx.font = `bold ${h*0.2}px Oswald, sans-serif`;
    ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
    ctx.fillText('WILD', 0, 1);
    ctx.restore();
  }

  /* ---- celebration particles (coins / sparks on a win) ---- */
  let particles = [];
  function spawnWinParticles(count){
    for(let i=0;i<count;i++){
      particles.push({
        x: Math.random()*LOGICAL_W,
        y: -10 - Math.random()*40,
        vx: (Math.random()-0.5)*60,
        vy: 70 + Math.random()*90,
        size: 3.5 + Math.random()*4,
        rot: Math.random()*Math.PI*2,
        vr: (Math.random()-0.5)*5,
        life: 1,
        color: Math.random() < 0.5 ? '#ffd76a' : '#fff3c0'
      });
    }
  }
  function updateParticles(dt){
    for(let i=particles.length-1;i>=0;i--){
      const p = particles[i];
      p.x += p.vx*dt; p.y += p.vy*dt; p.vy += 110*dt; p.rot += p.vr*dt;
      p.life -= dt*0.55;
      if(p.life <= 0 || p.y > LOGICAL_H+30) particles.splice(i,1);
    }
  }
  function drawParticles(){
    for(const p of particles){
      ctx.save();
      ctx.globalAlpha = Math.max(p.life,0);
      ctx.translate(p.x,p.y); ctx.rotate(p.rot);
      ctx.fillStyle = p.color;
      ctx.beginPath(); ctx.arc(0,0,p.size,0,Math.PI*2); ctx.fill();
      ctx.strokeStyle = 'rgba(255,255,255,0.6)'; ctx.lineWidth = 1; ctx.stroke();
      ctx.restore();
    }
  }

  const PAINTERS = [pCherries,pPlum,pOrange,pStar,pGrapes,pWatermelon,pSeven,pHorseshoe,pBell];

  function drawWinCellBackground(x, y, w, h) {
    ctx.save();
    const cx = x + w/2, cy = y + h/2;
    // Radial magenta background glow behind the symbol
    const bgGlow = ctx.createRadialGradient(cx, cy, 10, cx, cy, w * 0.65);
    bgGlow.addColorStop(0, 'rgba(255, 20, 147, 0.45)');
    bgGlow.addColorStop(1, 'rgba(255, 20, 147, 0)');
    ctx.fillStyle = bgGlow;
    ctx.fillRect(x, y, w, h);

    // Procedural twinkling cross stars
    const time = performance.now() * 0.003;
    const numStars = 8;
    for (let i = 0; i < numStars; i++) {
      const seedX = Math.sin(x * 12.9898 + y * 78.233 + i * 4.312) * 43758.5453;
      const seedY = Math.sin(x * 93.123 + y * 23.456 + i * 9.876) * 43758.5453;
      const rx = 0.15 * w + (seedX - Math.floor(seedX)) * 0.7 * w;
      const ry = 0.15 * h + (seedY - Math.floor(seedY)) * 0.7 * h;

      const scale = 0.45 + 0.55 * Math.sin(time + i * 1.7);
      if (scale > 0.15) {
        ctx.save();
        ctx.translate(x + rx, y + ry);
        ctx.rotate(time * 0.35 + i);
        
        const size = Math.max(0.1, (3.5 + Math.abs(seedX * 10 % 5.5)) * scale);
        const g = ctx.createRadialGradient(0, 0, 1, 0, 0, size * 2.2);
        g.addColorStop(0, '#ffffff');
        g.addColorStop(0.3, '#ffd76a');
        g.addColorStop(1, 'rgba(255, 215, 106, 0)');
        ctx.fillStyle = g;
        
        ctx.beginPath();
        ctx.ellipse(0, 0, size, size * 0.16, 0, 0, Math.PI * 2);
        ctx.ellipse(0, 0, size * 0.16, size, 0, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
      }
    }
    ctx.restore();
  }

  function drawSymbolInCell(symId, col, row, x, y, w, h){
    const cx = x + w/2, cy = y + h/2;
    const s = Math.min(w,h) * 0.42;
    
    // Draw twinkling win star background if this cell is part of active win payline
    const isWinning = winningCells.some(cell => cell[0] === col && cell[1] === row) && (performance.now() < glowPulseUntil);
    if (isWinning) {
      drawWinCellBackground(x, y, w, h);
    }

    ctx.save();
    if(symId === WILD){
      // 1. Draw the gold card background filling the cell (x, y, w, h)
      ctx.save();
      const cardBg = ctx.createLinearGradient(x, y, x, y + h);
      cardBg.addColorStop(0, '#a2137a');
      cardBg.addColorStop(1, '#4a0535');
      ctx.fillStyle = cardBg;
      ctx.fillRect(x + 2, y + 2, w - 4, h - 4);

      ctx.strokeStyle = '#ffd76a';
      ctx.lineWidth = 3;
      ctx.strokeRect(x + 3, y + 3, w - 6, h - 6);
      ctx.restore();

      // 2. Draw the aspect-ratio locked Wild girl centered inside the card
      if (wildImageLoaded && wildImage.complete) {
        const imgH = h * 0.95;
        const imgW = imgH * (wildImage.width / wildImage.height);
        ctx.drawImage(wildImage, x + (w - imgW)/2, y + (h - imgH)/2, imgW, imgH);
      } else {
        ctx.save();
        ctx.translate(cx, cy);
        pWild(ctx, s);
        ctx.restore();
      }
    }
    else {
      ctx.translate(cx, cy);
      PAINTERS[symId](ctx, s);
    }
    ctx.restore();
  }

  /* ============ reel state ============ */
  const reels = Array.from({length:COLS}, () => ({
    strip:[randomSymbolFor(0),randomSymbolFor(0),randomSymbolFor(0)],
    scroll:0, spinning:false, startTime:0, duration:0, maxScroll:0,
    finals:[0,0,0],
    wildExpanded: false,
    wildExpandProgress: 0,
    wildRow: -1
  }));

  let winningCells = [];
  let glowPulseUntil = 0;
  let lastTs = performance.now();

  function renderFrame(ts){
    const dt = Math.min((ts - lastTs) / 1000, 0.05);
    lastTs = ts;

    ctx.clearRect(0,0,LOGICAL_W,LOGICAL_H);
    const bg = ctx.createLinearGradient(0,0,0,LOGICAL_H);
    bg.addColorStop(0,'#451233'); bg.addColorStop(1,'#170614');
    ctx.fillStyle = bg;
    ctx.fillRect(0,0,LOGICAL_W,LOGICAL_H);

    for(let col=0; col<COLS; col++){
      const x0 = col*cellW;
      ctx.save();
      ctx.beginPath(); ctx.rect(x0,0,cellW,LOGICAL_H); ctx.clip();
      const reel = reels[col];
      for(let i=0;i<reel.strip.length;i++){
        const y = i*cellH - reel.scroll;
        if(y > -cellH && y < LOGICAL_H){
          const gridRow = Math.round(y / cellH);
          drawSymbolInCell(reel.strip[i], col, gridRow, x0, y, cellW, cellH);
        }
      }

      if (reel.wildExpanded) {
        reel.wildExpandProgress = Math.min(1, reel.wildExpandProgress + dt * 4);
      }

      if (reel.wildExpandProgress > 0 && reel.wildRow !== -1) {
        const progress = reel.wildExpandProgress;
        const y = (reel.wildRow * cellH) * (1 - progress);
        const h = cellH + (LOGICAL_H - cellH) * progress;

        ctx.save();
        // 1. Draw the gold card background for the expanding column
        const cardBg = ctx.createLinearGradient(x0, y, x0, y + h);
        cardBg.addColorStop(0, '#a2137a');
        cardBg.addColorStop(1, '#4a0535');
        ctx.fillStyle = cardBg;
        ctx.fillRect(x0 + 2, y + 2, cellW - 4, h - 4);

        // Gold border
        ctx.strokeStyle = '#ffd76a';
        ctx.lineWidth = 3;
        ctx.strokeRect(x0 + 3, y + 3, cellW - 6, h - 6);
        ctx.restore();

        // 2. Draw the Wild image stretching to full column width
        if (wildImageLoaded && wildImage.complete) {
          ctx.drawImage(wildImage, x0, y, cellW, h);
        }
      }

      ctx.restore();
      if(col>0){
        ctx.strokeStyle = '#f0c040'; ctx.lineWidth = 3;
        ctx.beginPath(); ctx.moveTo(x0,0); ctx.lineTo(x0,LOGICAL_H); ctx.stroke();
      }
    }

    if(winningCells.length && performance.now() < glowPulseUntil){
      const pulse = 0.55 + 0.35*Math.sin(performance.now()/140);
      for(const [col,row] of winningCells){
        const x = col*cellW, y = row*cellH;
        ctx.save();
        ctx.shadowColor = 'rgba(255,120,200,0.9)';
        ctx.shadowBlur = 18*pulse;
        ctx.strokeStyle = `rgba(255,255,255,${0.7*pulse+0.3})`;
        ctx.lineWidth = 4;
        roundRectPath(ctx, x+4, y+4, cellW-8, cellH-8, 10);
        ctx.stroke();
        ctx.restore();
        if(reels[col].finals[row] === WILD){
          drawWildRibbon(x,y,cellW,cellH);
        }
      }
    } else if(winningCells.length){
      winningCells = [];
    }

    updateParticles(dt);
    drawParticles();

    requestAnimationFrame(renderFrame);
  }

  /* ============ audio ============ */
  let audioCtx = null, muted = false;
  function ensureAudio(){ if(!audioCtx){ try{ audioCtx = new (window.AudioContext||window.webkitAudioContext)(); }catch(e){} } }
  function beep(freq,dur,type,vol){
    if(muted || !audioCtx) return;
    const o = audioCtx.createOscillator(), g = audioCtx.createGain();
    o.type = type; o.frequency.value = freq; g.gain.value = vol;
    o.connect(g); g.connect(audioCtx.destination);
    o.start();
    g.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + dur);
    o.stop(audioCtx.currentTime + dur);
  }
  function sndSpin(){ beep(220,0.15,'square',0.04); }
  function sndTick(){ beep(440,0.06,'square',0.03); }
  function sndWin(){ [523,659,784].forEach((f,i)=>setTimeout(()=>beep(f,0.25,'triangle',0.05), i*110)); }

  function playLineWinSound() {
    ensureAudio();
    if (muted || !audioCtx) return;
    const now = audioCtx.currentTime;
    const freqs = [523.25, 659.25, 783.99, 1046.50];
    freqs.forEach((f, idx) => {
      setTimeout(() => {
        beep(f, 0.28, 'sine', 0.04);
      }, idx * 75);
    });
  }

  let lastCoinSoundTime = 0;
  function playCoinRollupSound() {
    ensureAudio();
    if (muted || !audioCtx) return;
    const now = performance.now();
    if (now - lastCoinSoundTime > 60) {
      beep(880 + Math.random() * 260, 0.04, 'triangle', 0.035);
      lastCoinSoundTime = now;
    }
  }

  /* ============ game state ============ */
  const betSteps = [10,20,30,50,80,100,150,200,300,500];
  let betIndex = 3; // 50
  let bet = betSteps[betIndex];
  let spinningGlobal = false;
  let autoSpin = false;
  let turbo = false;
  const DEFAULT_INFO = 'THE WILD SYMBOL APPEARS ONLY ON REEL 2, 3, 4 AND REPLACES ANY SYMBOL ON THE SAME REEL';
  let infoTimeout = null;

  const balanceVal = document.getElementById('balanceVal');
  const balanceLabel = document.getElementById('balanceLabel');
  const betVal = document.getElementById('betVal');
  const infoBar = document.getElementById('infoBar');
  const spinBtn = document.getElementById('spinBtn');
  const autoBtn = document.getElementById('autoBtn');
  const maxBetBtn = document.getElementById('maxBetBtn');
  const betMinus = document.getElementById('betMinusBtn');
  const betPlus = document.getElementById('betPlusBtn');
  const modeBadge = document.getElementById('modeBadge');
  const winBanner = document.getElementById('winBanner');
  const winBannerAmount = document.getElementById('winBannerAmount');
  
  const egBetVal = document.getElementById('egBetVal');
  const egSwitchBtn = document.getElementById('egSwitchBtn');
  const egCloseBtn = document.getElementById('egCloseBtn');
  const extraGiftsPanel = document.getElementById('extraGiftsPanel');
  
  let nextAutoSpinDelay = 850;

  function fmt(n){
    return currencySymbol + ' ' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function updateUI(){
    const activeBet = extraGiftsActive ? (bet + extraBetPrice) : bet;
    balanceVal.textContent = fmt(balance);
    betVal.textContent = fmt(activeBet);
    if (egBetVal) {
      egBetVal.textContent = activeBet.toFixed(2);
    }
    if (betMinus) betMinus.disabled = spinningGlobal || betIndex===0;
    if (betPlus) betPlus.disabled = spinningGlobal || betIndex===betSteps.length-1;
    maxBetBtn.disabled = spinningGlobal;
    
    const spinBtnMain = document.getElementById('spinBtn');
    if (spinBtnMain) {
      spinBtnMain.classList.toggle('spinning', spinningGlobal);
    }

    // Sync header balance in real-time
    const hBal = document.getElementById('header-user-balance');
    if (hBal) {
      hBal.textContent = (isDemoMode ? realBalance : balance).toFixed(2);
    }
  }

  function setInfo(text, autoRevertMs){
    infoBar.textContent = text;
    if(infoTimeout) clearTimeout(infoTimeout);
    if(autoRevertMs){
      infoTimeout = setTimeout(()=>{ infoBar.textContent = DEFAULT_INFO; }, autoRevertMs);
    }
  }

  // ── SYNC BALANCE WITH Laravel Database ──
  function syncBalance(newBalance) {
    if (isDemoMode) {
      demoBalance = newBalance;
      return;
    }
    realBalance = newBalance;
    
    fetch('{{ route("dashboard.update-balance") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ balance: newBalance.toFixed(2) })
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        console.log('Balance synced to DB successfully:', newBalance);
      }
    })
    .catch(err => console.error('Error syncing balance:', err));
  }

  function updateModeUI() {
    const track = document.getElementById('modeTrackTop');
    const knob = document.getElementById('modeKnobTop');
    const text = document.getElementById('modeTextTop');

    if (isDemoMode) {
      modeBadge.textContent = "DEMO PLAY";
      modeBadge.style.background = "linear-gradient(#9a1626, #5e0c16)";
      modeBadge.style.borderColor = "#c43a44";
      modeBadge.style.color = "#ffd9a0";
      balanceLabel.textContent = "DEMO CREDITS";

      if (track) {
        track.style.background = '#333';
        track.style.borderColor = '#555';
      }
      if (knob) knob.style.left = '2px';
      if (text) {
        text.textContent = 'PLAY FOR REAL MONEY';
        text.style.color = '#4a9eff';
      }
    } else {
      modeBadge.textContent = "REAL PLAY";
      modeBadge.style.background = "linear-gradient(#2ebd59, #1b8a40)";
      modeBadge.style.borderColor = "#2ebd59";
      modeBadge.style.color = "#fff";
      balanceLabel.textContent = "REAL BALANCE";

      if (track) {
        track.style.background = '#2ebd59';
        track.style.borderColor = '#2ebd59';
      }
      if (knob) knob.style.left = '18px';
      if (text) {
        text.textContent = 'REAL PLAY ACTIVE';
        text.style.color = '#2ebd59';
      }
    }
  }

  function startSpin(){
    if(spinningGlobal) return;
    const activeBet = extraGiftsActive ? (bet + extraBetPrice) : bet;
    if(balance < activeBet){
      if (isDemoMode) {
        balance = 10000;
        setInfo('OUT OF CREDITS \u2014 FREEPLAY BALANCE REFILLED!', 3000);
      } else {
        setInfo('INSUFFICIENT BALANCE FOR THIS BET!', 3000);
        autoSpin = false;
        updateAutoBtn();
        return;
      }
      updateUI();
      return;
    }
    ensureAudio();
    balance = Math.round((balance - activeBet) * 100) / 100;
    updateUI();
    syncBalance(balance);
    spinningGlobal = true;
    winningCells = [];
    
    // Reset expanding wild parameters on all reels
    for (let col = 0; col < COLS; col++) {
      reels[col].wildExpanded = false;
      reels[col].wildExpandProgress = 0;
      reels[col].wildRow = -1;
    }

    setInfo('GOOD LUCK!');
    updateUI();
    sndSpin();

    const speed = turbo ? 2800 : 1500; // px/sec
    const baseDur = turbo ? 260 : 650;
    const stagger = turbo ? 110 : 320;

    for(let col=0; col<COLS; col++){
      const duration = baseDur + col*stagger + Math.random()*60;
      const steps = Math.max(8, Math.round(speed*duration/1000/cellH));
      const strip = [];
      for(let i=0;i<steps;i++) strip.push(randomSymbolFor(col));
      const finals = [randomSymbolFor(col), randomSymbolFor(col), randomSymbolFor(col)];
      strip.push(finals[0], finals[1], finals[2]);
      reels[col].strip = strip;
      reels[col].scroll = 0;
      reels[col].spinning = true;
      reels[col].startTime = performance.now();
      reels[col].duration = duration;
      reels[col].maxScroll = (strip.length - ROWS) * cellH;
      reels[col].finals = finals;
    }
  }

  function animateReels(now){
    let anySpinning = false;
    for(let col=0; col<COLS; col++){
      const r = reels[col];
      if(r.spinning){
        anySpinning = true;
        const t = Math.min((now - r.startTime) / r.duration, 1);
        const eased = 1 - Math.pow(1-t, 3);
        r.scroll = eased * r.maxScroll;
        if(t >= 1){
          r.spinning = false;
          r.scroll = r.maxScroll;
          sndTick();
        }
      }
    }
    if(!anySpinning && spinningGlobal){
      spinningGlobal = false;
      evaluateWin();
      updateUI();
      if(autoSpin && balance >= bet){
        setTimeout(()=>startSpin(), turbo?300:nextAutoSpinDelay);
      } else if(autoSpin){
        autoSpin = false; updateAutoBtn();
        setInfo('AUTO-SPIN STOPPED \u2014 NOT ENOUGH CREDITS', 3000);
      }
    }
    requestAnimationFrame(animateReels);
  }

  function evaluateWin(){
    let totalWin = 0;
    winningCells = [];
    const winLines = [];
    const usedLineNumbers = new Set();
    const activeBet = extraGiftsActive ? (bet + extraBetPrice) : bet;

    // 1. Identify columns with Wild
    const columnsWithWild = [];
    for(let col=1; col<=3; col++){
      if(reels[col].finals.includes(WILD)){
        columnsWithWild.push(col);
      }
    }

    // Helper function to evaluate wins on a board representation
    function checkWins(boardState) {
      let tempWin = 0;
      let tempCells = [];
      let tempLines = [];
      
      for(let row=0; row<ROWS; row++){
        const base = boardState[0][row];
        let count = 1;
        const cells = [[0,row]];
        for(let col=1; col<COLS; col++){
          const sym = boardState[col][row];
          if(sym === base || sym === WILD){ 
            count++; 
            cells.push([col,row]); 
          } else {
            break; 
          }
        }
        if(count >= 3){
          const mult = SYMBOLS[base].pay[Math.min(count,5)] || SYMBOLS[base].pay[5];
          const amt = Math.round((activeBet/100) * mult * 100) / 100;
          tempWin += amt;
          tempCells.push(...cells);
          tempLines.push({ row, amt, symbol: SYMBOLS[base].name, count });
        }
      }
      return { tempWin, tempCells, tempLines };
    }

    // First evaluation: check if there are wins with original layout
    const originalBoard = reels.map(r => [...r.finals]);
    let result = checkWins(originalBoard);

    // Identify which Wilds contributed to any winning combination
    const expandingCols = new Set();
    if (result.tempWin > 0) {
      for (const [col, row] of result.tempCells) {
        if (columnsWithWild.includes(col) && originalBoard[col][row] === WILD) {
          expandingCols.add(col);
        }
      }
    }

    // Expand Wilds if they contributed to a win, then re-evaluate wins
    if (expandingCols.size > 0) {
      const expandedBoard = originalBoard.map((colFinals, colIndex) => {
        if (expandingCols.has(colIndex)) {
          return [WILD, WILD, WILD]; // Expand Wild vertically across all rows
        }
        return colFinals;
      });
      
      result = checkWins(expandedBoard);
      
      // Set the expansion flags and record the original row for animation
      expandingCols.forEach(col => {
        reels[col].wildExpanded = true;
        reels[col].wildRow = originalBoard[col].indexOf(WILD);
      });
    }

    if(result.tempWin > 0){
      totalWin = result.tempWin;
      winningCells = result.tempCells;
      
      result.tempLines.forEach(wl => {
        let lineNum;
        do{ lineNum = 1 + Math.floor(Math.random()*100); } while(usedLineNumbers.has(lineNum));
        usedLineNumbers.add(lineNum);
        winLines.push({ line: lineNum, amt: wl.amt, symbol: wl.symbol, count: wl.count });
      });

      balance = Math.round((balance + totalWin) * 100) / 100;
      glowPulseUntil = performance.now() + (winLines.length*1000 + 3600);
      nextAutoSpinDelay = winLines.length*1000 + 1500;
      spawnWinParticles(46);
      sndWin();
      playWinSequence(winLines, totalWin);
      syncBalance(balance);
    } else {
      setInfo(DEFAULT_INFO, 0);
      glowPulseUntil = 0;
      nextAutoSpinDelay = 850;
    }
  }

  const SYMBOL_EMOJIS = {
    'Cherries': '🍒',
    'Plum': '🫐',
    'Orange': '🍊',
    'Star': '⭐',
    'Grapes': '🍇',
    'Watermelon': '🍉',
    'Seven': '7️⃣',
    'Horseshoe': '🧲',
    'Bell': '🔔'
  };

  function playWinSequence(winLines, totalWin){
    let i = 0;
    function showNext(){
      if(i < winLines.length){
        const wl = winLines[i];
        const emoji = SYMBOL_EMOJIS[wl.symbol] || '';
        const symbolDisplay = emoji.repeat(Math.min(wl.count, 5));
        setInfo(`LINE ${wl.line}:  ${symbolDisplay}  WIN: ${fmt(wl.amt)}`);
        playLineWinSound();
        i++;
        setTimeout(showNext, 1000);
      } else {
        showTotalBanner(totalWin);
        setInfo(`TOTAL WIN: ${fmt(totalWin)}`);
      }
    }
    showNext();
  }

  function showTotalBanner(amt){
    const rf = document.querySelector('.reel-frame');
    winBanner.style.top = (rf.offsetTop - 18) + 'px';
    const dur = 600, t0 = performance.now();
    function step(ts){
      const p = Math.min((ts - t0) / dur, 1);
      winBannerAmount.textContent = fmt(Math.round(p*amt));
      if(p < 1) {
        playCoinRollupSound();
        requestAnimationFrame(step);
      }
    }
    requestAnimationFrame(step);
    winBanner.classList.add('show');
    setTimeout(() => winBanner.classList.remove('show'), 3200);
  }

  /* ============ controls wiring ============ */
  document.getElementById('spinBtn').addEventListener('click', startSpin);

  if (betMinus) {
    betMinus.addEventListener('click', () => {
      if(spinningGlobal || betIndex===0) return;
      betIndex--; bet = betSteps[betIndex]; updateUI();
    });
  }
  if (betPlus) {
    betPlus.addEventListener('click', () => {
      if(spinningGlobal || betIndex===betSteps.length-1) return;
      betIndex++; bet = betSteps[betIndex]; updateUI();
    });
  }
  maxBetBtn.addEventListener('click', () => {
    if(spinningGlobal) return;
    betIndex = betSteps.length-1; bet = betSteps[betIndex]; updateUI();
    startSpin();
  });
  
  let tempSelectedVolatility = selectedVolatility;

  function openEgModal() {
    if (spinningGlobal) return;
    tempSelectedVolatility = selectedVolatility;
    updateModalCardsUI();
    document.getElementById('egModal').classList.add('show');
  }

  function closeEgModal() {
    document.getElementById('egModal').classList.remove('show');
  }

  function updateModalCardsUI() {
    document.querySelectorAll('.eg-opt-card').forEach(card => {
      const cardVal = parseInt(card.getAttribute('data-val'));
      if (cardVal === tempSelectedVolatility) {
        card.classList.add('active');
      } else {
        card.classList.remove('active');
      }
    });
  }

  window.selectVolatilityCard = function(val) {
    tempSelectedVolatility = val;
    updateModalCardsUI();
    sndTick();
  };

  document.getElementById('egCancelBtn').addEventListener('click', () => {
    closeEgModal();
    if (!extraGiftsActive) {
      if (extraGiftsPanel) extraGiftsPanel.classList.remove('active');
    }
  });

  document.getElementById('egConfirmBtn').addEventListener('click', () => {
    selectedVolatility = tempSelectedVolatility;
    extraBetPrice = selectedVolatility;
    extraGiftsActive = true;
    if (extraGiftsPanel) {
      extraGiftsPanel.classList.add('active');
    }
    updateUI();
    closeEgModal();
    sndSpin();
  });

  if (egSwitchBtn) {
    egSwitchBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (spinningGlobal) return;
      if (!extraGiftsActive) {
        openEgModal();
      } else {
        extraGiftsActive = false;
        if (extraGiftsPanel) {
          extraGiftsPanel.classList.remove('active');
        }
        updateUI();
      }
    });
  }

  if (egCloseBtn) {
    egCloseBtn.addEventListener('click', () => {
      if (extraGiftsPanel) {
        extraGiftsPanel.style.display = 'none';
      }
    });
  }

  // Bind click event to gift rows in the left panel to open the modal
  document.querySelectorAll('.eg-item').forEach(item => {
    item.addEventListener('click', () => {
      openEgModal();
    });
  });

  function updateAutoBtn(){ 
    if (autoBtn) {
      autoBtn.classList.toggle('active', autoSpin); 
    }
  }
  autoBtn.addEventListener('click', () => {
    autoSpin = !autoSpin; updateAutoBtn();
    if(autoSpin && !spinningGlobal) startSpin();
  });

  const soundBtn = document.getElementById('soundBtn');
  soundBtn.addEventListener('click', () => {
    muted = !muted;
    soundBtn.classList.toggle('off', muted);
    soundBtn.innerHTML = muted ? '&#128263;' : '&#128266;';
  });
  const turboBtn = document.getElementById('turboBtn');
  turboBtn.addEventListener('click', () => {
    turbo = !turbo;
    turboBtn.classList.toggle('off', !turbo);
    setInfo(turbo ? 'TURBO SPIN ENABLED' : 'TURBO SPIN DISABLED', 1800);
  });

  const helpBtn = document.getElementById('helpBtn');
  const helpModal = document.getElementById('helpModal');
  helpBtn.addEventListener('click', () => helpModal.classList.add('show'));
  document.getElementById('helpClose').addEventListener('click', () => helpModal.classList.remove('show'));
  helpModal.addEventListener('click', (e) => { if(e.target === helpModal) helpModal.classList.remove('show'); });

  /* dynamic mode toggle */
  modeBadge.addEventListener('click', () => {
    if (spinningGlobal) {
      setInfo('FINISH YOUR ACTIVE SPIN FIRST!', 2000);
      return;
    }
    isDemoMode = !isDemoMode;
    balance = isDemoMode ? demoBalance : realBalance;
    updateModeUI();
    updateUI();
  });

  const modeToggleTop = document.getElementById('modeToggleTop');
  if (modeToggleTop) {
    modeToggleTop.addEventListener('click', () => {
      if (spinningGlobal) {
        setInfo('FINISH YOUR ACTIVE SPIN FIRST!', 2000);
        return;
      }
      isDemoMode = !isDemoMode;
      balance = isDemoMode ? demoBalance : realBalance;
      updateModeUI();
      updateUI();
    });
  }

  /* decorative countdown timer */
  let timeLeft = 300;
  const timerEl = document.getElementById('timer');
  setInterval(() => {
    timeLeft--; if(timeLeft < 0) timeLeft = 300;
    const m = Math.floor(timeLeft/60), s = timeLeft%60;
    timerEl.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
  }, 1000);

  /* ============ ambient sparkles ============ */
  function createSparkles(count){
    const stage = document.querySelector('.stage');
    for(let i=0;i<count;i++){
      const el = document.createElement('div');
      el.className = 'sparkle';
      el.style.left = (Math.random()*100) + '%';
      el.style.top = (Math.random()*100) + '%';
      const size = 2 + Math.random()*3;
      el.style.width = size + 'px';
      el.style.height = size + 'px';
      el.style.animationDelay = (Math.random()*3) + 's';
      el.style.animationDuration = (2.4 + Math.random()*2.2) + 's';
      stage.appendChild(el);
    }
  }

  /* ============ init ============ */
  createSparkles(22);
  for(let col=0; col<COLS; col++){
    reels[col].strip = [randomSymbolFor(col), randomSymbolFor(col), randomSymbolFor(col)];
    reels[col].finals = reels[col].strip.slice();
  }
  fitCanvas();
  updateModeUI();
  updateUI();
  updateAutoBtn();
  requestAnimationFrame(renderFrame);
  requestAnimationFrame(animateReels);

})();
</script>
</body>
</html>
