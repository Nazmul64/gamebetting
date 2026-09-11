<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Fortune Gems 2 - JILI Slot</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@500;600;700&family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{background:#0c141d;font-family:'Poppins',sans-serif;min-height:100vh;overflow-x:hidden;color:#fff;}

/* -- GAME PRELOADER (1xBet Style) -- */
#game-preloader {
  position: fixed;
  inset: 0;
  background: #0c141d;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition: opacity 0.5s ease;
}
.preloader-box {
  width: 280px;
  text-align: center;
}
.preloader-title {
  color: #fbbf24;
  font-family: 'Cinzel Decorative', serif;
  font-size: 24px;
  font-weight: 900;
  letter-spacing: 0.15em;
  margin-bottom: 16px;
  text-shadow: 0 0 15px rgba(251,191,36,0.6);
  animation: pulse 1.5s infinite;
}
.preloader-bar-bg {
  width: 100%;
  height: 10px;
  background: #1e293b;
  border-radius: 999px;
  overflow: hidden;
  border: 1px solid #d97706;
  box-shadow: 0 0 10px rgba(217,119,6,0.3);
}
.preloader-bar-fill {
  width: 0%;
  height: 100%;
  background: linear-gradient(90deg, #f59e0b, #fbbf24, #d97706);
  transition: width 0.2s ease;
}
.preloader-text {
  font-family: 'JetBrains Mono', monospace;
  font-size: 12px;
  color: #94a3b8;
  margin-top: 10px;
  font-weight: 700;
}

/* -- GAME WRAPPER -- */
.game-wrapper{
  position:relative;
  display:flex;
  align-items:center;
  justify-content:center;
  min-height:calc(100vh - 62px);
  padding:24px 12px;
  overflow:hidden;
  background:url('/assets/image/fortune_gems_bg.jpg') center/cover no-repeat;
}
.game-bg{
  position:absolute;inset:0;
  background:rgba(0,0,0,0.35);
  z-index:0;
}

/* -- CABINET -- */
.cabinet{
  position:relative;z-index:1;
  width:100%;max-width:870px;
  display:flex;flex-direction:column;
  border-radius:8px;
  border:4px solid #3c240a;
  overflow:hidden;
  box-shadow:0 12px 50px rgba(0,0,0,0.85);
  background:#1a0f05;
}

/* -- TOP ARCH / MARQUEE -- */
.top-arch{
  display:flex;align-items:stretch;
  height:44px;
  background:#7a5228;
  border:3px solid #4a2e0e;
  border-bottom:3px solid #3a1e06;
}
.marquee-track{
  flex:1;overflow:hidden;
  background:#110a02;
  display:flex;align-items:center;
  padding:0 12px;
  border-right:3px solid #4a2e0e;
}
.marquee-inner{
  display:inline-block;
  white-space:nowrap;
  padding-left:100%;
  animation:marquee-run 24s linear infinite;
  font-family:'Cinzel',serif;
  font-size:13.5px;font-weight:700;
  color:#ffebad;
  text-shadow:0 1px 4px rgba(0,0,0,0.8);
}
@keyframes marquee-run{
  0%{transform:translateX(0);}
  100%{transform:translateX(-100%);}
}
.special-wheel-badge{
  width:116px;flex-shrink:0;
  background:linear-gradient(160deg,#8a0c0c,#4a0808);
  display:flex;align-items:center;justify-content:center;
  font-family:'Cinzel',serif;font-size:13px;font-weight:900;
  color:#ffd700;text-align:center;line-height:1.2;
  letter-spacing:0.05em;
}

/* -- MAIN STAGE -- */
.main-stage{
  display:flex;align-items:stretch;
  background:linear-gradient(180deg,#b86e1a 0%,#8a4608 100%);
  border-left:3px solid #4a2e0e;
  border-right:3px solid #4a2e0e;
  height:410px;
  position:relative;
}

/* Fortune wheel side */
.fortune-side{
  width:118px;flex-shrink:0;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  gap:10px;padding:8px 4px;
  background:linear-gradient(90deg,rgba(0,0,0,0.18),transparent);
  overflow:visible;
  position:relative;
  z-index:2;
}
#fortuneCanvas{
  width:148px;height:148px;
  border-radius:50%;
  border:5px solid #7a5200;
  box-shadow:0 0 24px rgba(0,0,0,0.7),0 0 12px rgba(0,0,0,0.5);
  margin-left:-40px;
}
.fortune-ex-badge{
  background:linear-gradient(135deg,#f6c244,#c47a00);
  border:2.5px solid #7a4a00;
  border-radius:22px;
  padding:4px 14px;
  font-family:'Cinzel',serif;font-size:12px;font-weight:900;
  color:#2c1600;
  box-shadow:0 2px 8px rgba(0,0,0,0.5);
}

/* Stone pillar */
.pillar{
  width:46px;flex-shrink:0;
  background:linear-gradient(90deg,#6a4820 0%,#b07840 25%,#d0a060 50%,#b07840 75%,#6a4820 100%);
  border-left:3px solid #3a2208;
  border-right:3px solid #3a2208;
  position:relative;overflow:hidden;
}
.pillar::before{
  content:'';position:absolute;inset:0;
  background:repeating-linear-gradient(
    180deg,
    rgba(0,0,0,0.07) 0px,rgba(0,0,0,0) 6px,
    rgba(255,255,255,0.04) 6px,rgba(255,255,255,0) 12px
  );
}
.pillar.left{border-right:4px solid #2a1606;}
.pillar.right{border-left:4px solid #2a1606;}

/* Reels area */
.reels-area{
  flex:1;position:relative;
  background:linear-gradient(180deg,#c07820,#8a4808);
  overflow:hidden;
}
#reelsCanvas{width:100%;height:100%;display:block;}

.win-banner{
  position:absolute;top:50%;left:50%;
  transform:translate(-50%,-50%) scale(0.5);
  background:radial-gradient(ellipse at center,#fffbe0,#ffd700 60%,#b07800);
  border:4px solid #c47a00;border-radius:16px;
  padding:12px 32px;text-align:center;
  opacity:0;pointer-events:none;z-index:10;
  transition:all 0.25s cubic-bezier(.34,1.56,.64,1);
  box-shadow:0 0 50px rgba(255,215,0,0.85);
}
.win-banner.show{opacity:1;transform:translate(-50%,-50%) scale(1);}
.win-txt{
  font-family:'Cinzel Decorative',serif;
  font-size:32px;color:#2c1200;
  text-shadow:0 2px 0 rgba(255,255,255,0.5);
}

.ribbon{
  position:absolute;bottom:10px;left:0;right:0;
  text-align:center;
  font-family:'Cinzel',serif;font-size:12px;
  color:#ffdc78;text-shadow:0 1px 4px rgba(0,0,0,0.9);
  opacity:0;transition:opacity 0.3s;pointer-events:none;z-index:5;
}
.ribbon.show{opacity:1;}

/* Multiplier column (right) */
.mult-col{
  width:96px;flex-shrink:0;
  height:100%;
  position:relative;
  overflow:hidden;
  background: linear-gradient(90deg, #160202 0%, #3a0a0a 25%, #4c0e0e 50%, #3a0a0a 75%, #160202 100%);
  border-left: 3px solid #3c1616;
  box-shadow: inset 10px 0 15px rgba(0,0,0,0.8), inset -10px 0 15px rgba(0,0,0,0.8);
}
.mult-strip{
  position:absolute;
  top:0;left:0;
  width:100%;
  display:flex;
  flex-direction:column;
}
.mult-item{
  height:136.6px;
  width:100%;
  display:flex;align-items:center;justify-content:center;
  overflow:hidden;
}
.mult-item img{
  width:100%;height:100%;
  object-fit:contain;
  transform:scale(1.22);
  display:block;
  transition:filter 0.1s;
}
.mult-strip.blur img{
  filter:blur(3px) contrast(1.15);
}
.mult-active-frame{
  position:absolute;
  top:136.6px;
  left:0;right:0;
  height:136.6px;
  border:4.5px solid #ffd700 !important;
  box-shadow: inset 0 0 12px rgba(0,0,0,0.95), 0 0 25px rgba(255,215,0,0.65);
  border-radius: 8px;
  z-index: 5;
  pointer-events:none;
  background:rgba(0,0,0,0.12);
}
.mult-active-frame.lit{
  animation:frame-pulse 0.35s ease-in-out infinite alternate;
}
@keyframes frame-pulse{
  from{box-shadow: inset 0 0 12px rgba(0,0,0,0.95), 0 0 20px rgba(255,215,0,0.6); border-color: #ffd700 !important;}
  to{box-shadow: inset 0 0 15px rgba(0,0,0,0.95), 0 0 32px rgba(255,215,0,0.95); border-color: #ffffff !important;}
}

/* -- CONTROL BAR -- */
.control-bar{
  height:78px;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 14px;gap:10px;
  background:linear-gradient(180deg,#7a5228 0%,#5a3610 40%,#7a5228 100%);
  border:3px solid #4a2e0e;
  border-top:3px solid #2a1006;
}

.cb-gear{
  width:48px;height:48px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#dcc888,#8a7030 65%,#403010 100%);
  border:3px solid #1a0e02;
  box-shadow:0 4px 10px rgba(0,0,0,0.55),inset 0 1px 4px rgba(255,255,255,0.35);
  display:flex;align-items:center;justify-content:center;
  color:#1a0e02;font-size:21px;cursor:pointer;
  transition:transform 0.1s,filter 0.1s;flex-shrink:0;
}
.cb-gear:hover{filter:brightness(1.15);}
.cb-gear:active{transform:scale(0.9);}

.cb-stat{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
.cb-label{font-family:'Poppins',sans-serif;font-size:11.5px;font-weight:600;color:rgba(255,255,255,0.85);}
.cb-value{font-family:'Cinzel',serif;font-size:18px;font-weight:700;color:#fff;line-height:1.1;}

.cb-bet{
  display:flex;flex-direction:column;align-items:center;
  cursor:pointer;position:relative;flex-shrink:0;
}
.cb-bet-coin{
  width:46px;height:46px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#80e898,#22a046 65%,#0e4820 100%);
  border:3px solid #082810;
  box-shadow:0 3px 10px rgba(0,0,0,0.5),inset 0 1px 4px rgba(255,255,255,0.35);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:18px;
}
.cb-bet-label{
  font-family:'Poppins',sans-serif;font-size:11px;font-weight:700;
  color:#ffd700;margin-top:2px;
}

.cb-turbo{
  width:52px;height:38px;border-radius:22px;
  background:radial-gradient(circle at 35% 30%,#e8cc88,#a07830 65%,#584010 100%);
  border:3px solid #1a0e02;
  box-shadow:0 3px 8px rgba(0,0,0,0.45);
  display:flex;align-items:center;justify-content:center;
  color:#1a0e02;font-size:18px;cursor:pointer;
  transition:all 0.12s;flex-shrink:0;
}
.cb-turbo.active{
  background:radial-gradient(circle at 35% 30%,#fff8b0,#ffd700 65%,#c47800 100%);
  box-shadow:0 0 18px rgba(255,215,0,0.85);border-color:#ffd700;
}
.cb-turbo:hover{filter:brightness(1.12);}
.cb-turbo:active{transform:scale(0.92);}

.cb-auto{
  width:42px;height:42px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#e8cc88,#a07830 65%,#584010 100%);
  border:3px solid #1a0e02;
  box-shadow:0 3px 8px rgba(0,0,0,0.45);
  display:flex;align-items:center;justify-content:center;
  color:#1a0e02;font-size:17px;cursor:pointer;
  transition:all 0.12s;flex-shrink:0;
}
.cb-auto.active{
  background:radial-gradient(circle at 35% 30%,#fff8b0,#ffd700 65%,#c47800 100%);
  box-shadow:0 0 18px rgba(255,215,0,0.85);border-color:#ffd700;
}
.cb-auto:hover{filter:brightness(1.12);}
.cb-auto:active{transform:scale(0.92);}

.cb-spin{
  width:84px;height:84px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#fff4c8,#d4af5a 48%,#8a6820 80%,#3c2808 100%);
  border:4px solid #1a0e02;
  box-shadow:0 7px 0 #3c2808,0 12px 24px rgba(0,0,0,0.65),inset 0 2px 8px rgba(255,255,255,0.55);
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  cursor:pointer;flex-shrink:0;
  margin-top:-20px;
  transition:transform 0.1s,box-shadow 0.1s;
  position:relative;overflow:hidden;
}
.cb-spin:active{
  transform:translateY(5px);
  box-shadow:0 2px 0 #3c2808,0 4px 8px rgba(0,0,0,0.65),inset 0 2px 8px rgba(255,255,255,0.55);
}
.cb-spin .jili-label{
  font-family:'Cinzel',serif;font-size:14px;font-weight:900;
  color:#1a0e02;line-height:1;z-index:1;
}
.cb-spin .jili-sub{
  font-size:9px;color:rgba(26,14,2,0.45);
  letter-spacing:3px;margin-top:2px;
}
.cb-spin.spinning{animation:spin-glow 0.85s linear infinite;}
@keyframes spin-glow{
  0%,100%{box-shadow:0 7px 0 #3c2808,0 12px 24px rgba(0,0,0,0.65),0 0 0 rgba(255,215,0,0);}
  50%{box-shadow:0 7px 0 #3c2808,0 12px 30px rgba(0,0,0,0.65),0 0 30px rgba(255,215,0,0.75);}
}

.cb-wifi{color:#4cd964;font-size:16px;text-shadow:0 0 10px rgba(76,217,100,0.7);flex-shrink:0;}

.bet-popup{
  position:absolute;bottom:calc(100% + 12px);left:50%;
  transform:translateX(-50%);
  background:#140d03;border:2px solid #7a5228;border-radius:12px;
  padding:12px;width:238px;z-index:200;
  display:none;
  box-shadow:0 8px 30px rgba(0,0,0,0.7);
}
.bet-popup.show{display:block;}
.bet-popup-title{
  font-family:'Cinzel',serif;color:#ffd700;
  font-size:13px;font-weight:700;text-align:center;margin-bottom:10px;
}
.bet-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:6px;}
.bet-item{
  background:#2a1a06;border:1.5px solid #5c3a16;border-radius:6px;
  padding:8px 4px;text-align:center;
  font-family:'Cinzel',serif;font-size:12px;font-weight:700;color:#d4af5a;
  cursor:pointer;transition:all 0.15s;
}
.bet-item:hover{background:#3a2a10;color:#fff;border-color:#ffd700;}
.bet-item.active{background:#ffd700;color:#1a0e02;border-color:#fff;box-shadow:0 0 10px rgba(255,215,0,0.5);}

/* Paytable overlay */
.pt-overlay{
  position:fixed;inset:0;background:rgba(0,0,0,0.88);
  z-index:1000;display:flex;align-items:center;justify-content:center;
  opacity:0;pointer-events:none;transition:opacity 0.3s;
}
.pt-overlay.show{opacity:1;pointer-events:all;}
.pt-card{
  background:#140d03;border:2px solid #8a6030;border-radius:16px;
  padding:24px;width:350px;max-height:82vh;overflow-y:auto;
}
.pt-card h3{
  font-family:'Cinzel Decorative',serif;color:#ffd700;
  font-size:20px;margin-bottom:8px;text-align:center;
}
.pt-card .sub{color:#d4af5a;font-size:12px;margin-bottom:12px;text-align:center;}
.pt-row{
  display:flex;align-items:center;justify-content:space-between;
  padding:8px 0;border-bottom:1px solid rgba(212,175,90,0.15);
}
.pt-row .sym{display:flex;align-items:center;gap:10px;color:#d4af5a;font-size:13px;}
.pt-row .payout{color:#ffd700;font-family:'Cinzel',serif;font-weight:700;font-size:16px;}
.pt-close{
  display:block;margin:16px auto 0;
  background:linear-gradient(135deg,#d4af5a,#8a5c1a);
  border:none;border-radius:8px;padding:10px 36px;
  color:#1a0e02;font-family:'Cinzel',serif;font-weight:700;
  cursor:pointer;font-size:15px;
}

.turbo-label{
  font-family:'Poppins',sans-serif;font-size:10px;
  color:rgba(255,255,255,0.6);white-space:nowrap;
  display:none;
}
@media(min-width:700px){.turbo-label{display:block;}}

/* -- SHELL: TOP NAV BAR -- */
.shell-topnav{
  height:40px;
  background:#1a2030;
  display:flex;align-items:center;
  padding:0 14px;
  border-bottom:1px solid rgba(255,255,255,0.07);
  position:sticky;top:0;z-index:50;
}
.topnav-breadcrumb{
  display:flex;align-items:center;gap:6px;
  font-size:12px;color:rgba(255,255,255,0.5);
  flex:1;
}
.topnav-breadcrumb a,.topnav-breadcrumb span{
  color:rgba(255,255,255,0.5);text-decoration:none;
  transition:color 0.15s;
}
.topnav-breadcrumb a:hover{color:#fff;}
.topnav-breadcrumb .sep{opacity:0.35;}
.topnav-breadcrumb .current{color:rgba(255,255,255,0.85);font-weight:600;}
.topnav-title{
  font-family:'Poppins',sans-serif;font-weight:700;
  font-size:13px;color:#fff;
  text-align:center;flex:1;
  letter-spacing:0.06em;text-transform:uppercase;
}
.topnav-search{
  display:flex;align-items:center;gap:8px;flex:1;justify-content:flex-end;
}
.topnav-search input{
  background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);
  border-radius:20px;padding:4px 12px;
  color:#fff;font-size:12px;outline:none;width:130px;
}
.topnav-search input::placeholder{color:rgba(255,255,255,0.35);}
.topnav-search .search-icon{color:rgba(255,255,255,0.5);font-size:13px;cursor:pointer;}

/* -- SHELL: PAGE BODY -- */
.shell-body{
  display:flex;flex:1;min-height:0;
  background:#141824;
}

/* -- SHELL: LEFT SIDEBAR -- */
.shell-sidebar{
  width:52px;flex-shrink:0;
  background:#1a2030;
  border-right:1px solid rgba(255,255,255,0.07);
  display:flex;flex-direction:column;
  align-items:center;
  padding:12px 0;
  gap:6px;
}
.sidebar-icon{
  width:38px;height:38px;border-radius:10px;
  display:flex;align-items:center;justify-content:center;
  font-size:16px;color:rgba(255,255,255,0.45);
  cursor:pointer;border:none;background:transparent;
  transition:all 0.18s;
}
.sidebar-icon:hover,.sidebar-icon.active{
  background:rgba(255,255,255,0.1);color:#fff;
}
.sidebar-icon.active{color:#4a9eff;}

.shell-content{
  flex:1;display:flex;flex-direction:column;overflow:hidden;
  min-width:0;
}

/* -- IN-GAME HEADER BAR -- */
.ingame-header{
  height:38px;
  background:#1e2638;
  border-bottom:1px solid rgba(255,255,255,0.07);
  display:flex;align-items:center;
  padding:0 12px;
  gap:10px;
  flex-shrink:0;
}
.ingame-header .game-fav{
  color:rgba(255,255,255,0.5);font-size:15px;cursor:pointer;
  transition:color 0.15s;
}
.ingame-header .game-fav:hover{color:#ff6b6b;}
.ingame-header .game-name{
  font-family:'Poppins',sans-serif;font-weight:700;
  font-size:12.5px;color:#fff;margin-right:4px;
}
.ingame-header .game-provider{
  font-size:11px;color:rgba(255,255,255,0.4);
  border-left:1px solid rgba(255,255,255,0.15);padding-left:8px;
}
.ingame-header .spacer{flex:1;}
.real-money-toggle{
  display:flex;align-items:center;gap:7px;
  font-family:'Poppins',sans-serif;font-size:11px;
  color:rgba(255,255,255,0.6);font-weight:600;
}
.real-money-toggle .switch-track{
  width:34px;height:18px;border-radius:9px;
  background:linear-gradient(90deg,#2a7aff,#1a5acc);
  cursor:pointer;position:relative;
  transition:background 0.2s;
  border:1.5px solid #2a7aff;
}
.real-money-toggle .switch-track.demo-on{
  background:rgba(255,255,255,0.15);
  border-color:rgba(255,255,255,0.2);
}
.real-money-toggle .switch-dot{
  width:12px;height:12px;border-radius:50%;
  background:#fff;position:absolute;
  top:2px;left:2px;
  transform:translateX(16px);
  transition:transform 0.2s;
  box-shadow:0 1px 4px rgba(0,0,0,0.4);
}
.real-money-toggle .switch-track.demo-on .switch-dot{
  transform:translateX(0px);
}
.ingame-actions{
  display:flex;align-items:center;gap:4px;
}
.ingame-icon{
  width:28px;height:28px;border-radius:7px;
  display:flex;align-items:center;justify-content:center;
  color:rgba(255,255,255,0.5);font-size:13px;
  cursor:pointer;transition:all 0.15s;
  background:transparent;border:none;
}
.ingame-icon:hover{background:rgba(255,255,255,0.1);color:#fff;}
.ingame-icon.close-icon:hover{background:rgba(220,50,50,0.3);color:#ff6b6b;}

/* -- SHELL: BOTTOM BAR -- */
.shell-bottombar{
  height:40px;
  background:#1a2030;
  border-top:1px solid rgba(255,255,255,0.07);
  display:flex;align-items:center;
  padding:0 14px;
  gap:18px;
  flex-shrink:0;
}
.bottom-tab{
  display:flex;align-items:center;gap:6px;
  font-family:'Poppins',sans-serif;font-size:12px;
  color:rgba(255,255,255,0.5);
  cursor:pointer;transition:color 0.15s;
  white-space:nowrap;
}
.bottom-tab:hover,.bottom-tab.active{color:#fff;}
.bottom-tab i{font-size:13px;}
.bottom-tab.active{color:#4a9eff;}
.bottom-search{
  display:flex;align-items:center;
  background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);
  border-radius:16px;padding:3px 10px;
  gap:6px;
}
.bottom-search input{
  background:transparent;border:none;outline:none;
  color:#fff;font-size:11.5px;width:100px;
}
.bottom-search input::placeholder{color:rgba(255,255,255,0.3);}
.bottom-search i{color:rgba(255,255,255,0.35);font-size:11px;}
.bottom-spacer{flex:1;}
.bottom-layout-btns{
  display:flex;align-items:center;gap:4px;
}
.layout-btn{
  width:26px;height:26px;border-radius:5px;
  display:flex;align-items:center;justify-content:center;
  color:rgba(255,255,255,0.4);font-size:12px;
  cursor:pointer;transition:all 0.15s;
  border:1px solid transparent;
}
.layout-btn:hover,.layout-btn.active{
  color:#fff;background:rgba(255,255,255,0.1);
  border-color:rgba(255,255,255,0.15);
}
.bottom-page-nav{
  display:flex;align-items:center;gap:4px;
  font-size:11px;color:rgba(255,255,255,0.4);
}
.bottom-page-nav .page-icon{
  width:22px;height:22px;border-radius:4px;
  background:rgba(255,255,255,0.1);
  display:flex;align-items:center;justify-content:center;
  font-size:10px;color:rgba(255,255,255,0.5);
  cursor:pointer;
}

/* -- RESPONSIVE RULES -- */
@media(max-width:840px){
  .cabinet{max-width:100%;}
  .game-wrapper{padding:8px 6px;}
  .topnav-search{display:none;}
  .topnav-breadcrumb{font-size:11px;}
  .main-stage{height:auto;}
  .cb-spin{width:76px;height:76px;}
}

@media(max-width:600px){
  .shell-topnav{display:none;}
  .shell-bottombar{display:none;}
  .shell-sidebar{width:44px;padding:8px 0;gap:4px;}
  .sidebar-icon{width:34px;height:34px;font-size:15px;border-radius:8px;}
  .shell-body{height:100vh;height:100dvh;overflow:hidden;}
  .game-wrapper{padding:0;align-items:stretch;}
  .cabinet{max-width:100%;width:100%;border-radius:0;border-width:0;box-shadow:none;display:flex;flex-direction:column;height:100%;}
  .ingame-header{height:32px;padding:0 8px;gap:6px;flex-shrink:0;}
  .ingame-header .game-provider{display:none;}
  .ingame-header .game-name{font-size:11px;}
  .ingame-header .game-fav{font-size:13px;}
  .real-money-toggle .switch-track{width:28px;height:16px;}
  .real-money-toggle{font-size:10px;gap:5px;}
  .top-arch{height:32px;flex-shrink:0;}
  .marquee-inner{font-size:11px;}
  .special-wheel-badge{width:84px;font-size:10px;letter-spacing:0;}
  .main-stage{flex:1;height:auto;min-height:0;overflow:hidden;}
  .fortune-side{width:68px;padding:4px 2px;gap:4px;}
  #fortuneCanvas{width:90px;height:90px;margin-left:-26px;border-width:3px;box-shadow:0 0 14px rgba(0,0,0,0.7);}
  .fortune-ex-badge{font-size:9.5px;padding:2px 8px;border-radius:16px;}
  .pillar{width:18px;}
  .pillar::before{display:none;}
  .reels-area{flex:1;min-width:0;overflow:hidden;}
  .mult-col{width:62px;border-left:2px solid #3c1616;}
  .mult-item img{transform:scale(1.3);display:block;}
  .mult-active-frame{border-width:3.5px;border-radius:6px;}
  .control-bar{height:auto;min-height:60px;padding:4px 10px;gap:6px;flex-shrink:0;flex-wrap:nowrap;justify-content:space-between;align-items:center;}
  .cb-stat.win-stat{display:none;}
  .cb-stat{flex:0 1 auto;}
  .cb-label{font-size:9.5px;}
  .cb-value{font-size:14px;line-height:1.1;}
  .cb-spin{width:62px;height:62px;margin-top:-10px;flex-shrink:0;}
  .cb-spin .jili-label{font-size:11px;}
  .cb-spin .jili-sub{font-size:8px;}
  .cb-gear{width:36px;height:36px;font-size:16px;}
  .cb-auto{width:34px;height:34px;font-size:14px;}
  .cb-turbo{width:40px;height:30px;font-size:14px;}
  .cb-bet-coin{width:36px;height:36px;font-size:14px;}
  .cb-bet-label{font-size:9.5px;margin-top:1px;}
  .cb-wifi{font-size:14px;}
  .turbo-label{display:none !important;}
  .win-txt{font-size:20px;}
  .win-banner{padding:8px 20px;}
  .pt-card{width:calc(100vw - 20px);padding:14px;}
  .bet-popup{width:calc(100vw - 32px);left:50%;transform:translateX(-50%);}
}

@media(max-width:390px){
  .fortune-side{width:58px;}
  #fortuneCanvas{width:78px;height:78px;margin-left:-20px;}
  .pillar{width:12px;}
  .mult-col{width:54px;}
  .cb-spin{width:56px;height:56px;}
  .cb-gear,.cb-auto{width:30px;height:30px;font-size:13px;}
  .cb-turbo{width:34px;height:28px;}
  .cb-bet-coin{width:30px;height:30px;}
  .cb-label{font-size:8.5px;}
  .cb-value{font-size:12px;}
}

@media(max-height:480px) and (orientation:landscape){
  .shell-topnav,.shell-bottombar{display:none;}
  .shell-sidebar{width:40px;}
  .ingame-header{height:28px;}
  .top-arch{height:26px;}
  .game-wrapper{padding:0;}
  .main-stage{flex:1;height:auto;}
  .control-bar{min-height:48px;padding:3px 8px;flex-wrap:nowrap;gap:5px;}
  #fortuneCanvas{width:72px;height:72px;margin-left:-18px;}
  .fortune-side{width:56px;gap:3px;padding:3px 1px;}
  .fortune-ex-badge{display:none;}
  .pillar{width:14px;}
  .mult-col{width:56px;}
  .cb-spin{width:52px;height:52px;margin-top:-6px;}
  .win-txt{font-size:18px;}
  .cb-stat.win-stat{display:none;}
}
</style>
</head>
<body>

@include('customer.header')

<!-- 1xBet Style Game Pre-loader -->
<div id="game-preloader">
    <div class="preloader-box">
        <h2 class="preloader-title">FORTUNE GEMS 2</h2>
        <div class="preloader-bar-bg">
            <div id="loader-progress" class="preloader-bar-fill"></div>
        </div>
        <p id="loader-percent" class="preloader-text">LOADING... 0%</p>
    </div>
</div>

<!-- Deposit Required Popup Modal -->
<div id="deposit-popup-modal" style="position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:9998; display:none; align-items:center; justify-content:center; backdrop-filter:blur(6px);">
    <div style="background:linear-gradient(180deg,#1e1b18,#120e0a); border:2px solid #f59e0b; border-radius:18px; padding:28px 24px; width:90%; max-width:380px; text-align:center; box-shadow:0 10px 40px rgba(0,0,0,0.8), 0 0 30px rgba(245,158,11,0.3);">
        <div style="width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:26px; color:#1a0e02; box-shadow:0 0 20px rgba(245,158,11,0.5);">
            <i class="fas fa-lock"></i>
        </div>
        <h3 style="font-family:'Cinzel Decorative',serif; font-size:20px; color:#fbbf24; margin-bottom:8px; font-weight:900;">DEMO LIMIT REACHED</h3>
        <p style="font-size:13px; color:#cbd5e1; line-height:1.6; margin-bottom:20px;">
            আপনার ফ্রি ডেমো স্পিন শেষ হয়েছে! আসল টাকা দিয়ে আনলিমিটেড জিততে এবং লাকি হুইল জ্যাকপট পেতে এখনই ডিপোজিট করুন।
        </p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('dashboard') }}" style="display:block; padding:12px; background:linear-gradient(135deg,#f59e0b,#b45309); color:#1a0e02; text-decoration:none; font-family:'Cinzel',serif; font-weight:800; font-size:14px; border-radius:10px; box-shadow:0 4px 15px rgba(245,158,11,0.4);">
                <i class="fas fa-wallet"></i> ডিপোজিট করুন (DEPOSIT NOW)
            </a>
            <button onclick="document.getElementById('deposit-popup-modal').style.display='none'" style="background:transparent; border:1px solid rgba(255,255,255,0.2); color:#94a3b8; padding:8px; border-radius:8px; font-size:12px; cursor:pointer;">
                বন্ধ করুন (Close)
            </button>
        </div>
    </div>
</div>

{{-- SHELL TOP NAV BAR --}}
<div class="shell-topnav">
  <div class="topnav-breadcrumb">
    <a href="/"><i class="fas fa-home"></i></a>
    <span class="sep">/</span>
    <a href="/slots">Slots</a>
    <span class="sep">/</span>
    <a href="/slots/popular">Popular</a>
    <span class="sep">/</span>
    <span class="current">Fortune Gems 2</span>
  </div>
  <div class="topnav-title">FORTUNE GEMS 2</div>
  <div class="topnav-search">
    <input type="text" placeholder="Search">
    <span class="search-icon"><i class="fas fa-search"></i></span>
  </div>
</div>

{{-- SHELL BODY --}}
<div class="shell-body">

  {{-- LEFT SIDEBAR --}}
  <div class="shell-sidebar">
    <button class="sidebar-icon" title="Favorites"><i class="far fa-heart"></i></button>
    <button class="sidebar-icon active" title="All Games"><i class="fas fa-th-large"></i></button>
    <button class="sidebar-icon" title="Top Games"><i class="fas fa-trophy"></i></button>
    <button class="sidebar-icon" title="Live"><i class="fas fa-users"></i></button>
    <button class="sidebar-icon" title="Promotions"><i class="fas fa-bolt"></i></button>
  </div>

  {{-- MAIN CONTENT --}}
  <div class="shell-content">

    {{-- IN-GAME HEADER BAR --}}
    <div class="ingame-header">
      <span class="game-fav" title="Add to Favorites"><i class="far fa-heart"></i></span>

      <span class="game-name">Fortune Gems 2</span>
      <span class="game-provider">JILI</span>

      <div class="spacer"></div>

      {{-- Real Money Toggle --}}
      <div class="real-money-toggle" id="realMoneyWrap">
        <div class="switch-track" id="rmTrack">
          <div class="switch-dot"></div>
        </div>
        <span id="rmLabel">PLAY FOR REAL MONEY</span>
      </div>

      {{-- Action Icons --}}
      <div class="ingame-actions">
        <button class="ingame-icon" title="Fullscreen" id="fullscreenBtn"><i class="fas fa-expand"></i></button>
        <button class="ingame-icon" title="Sound" id="soundBtn"><i class="fas fa-volume-up"></i></button>
        <button class="ingame-icon" title="Refresh" id="refreshBtn" onclick="location.reload()"><i class="fas fa-sync-alt"></i></button>
        <button class="ingame-icon" title="Favorite" id="favBtn"><i class="far fa-star"></i></button>
        <button class="ingame-icon close-icon" title="Close" onclick="history.back()"><i class="fas fa-times"></i></button>
      </div>
    </div>

    {{-- GAME WRAPPER --}}
    <div class="game-wrapper">
      <div class="game-bg"></div>

      <div class="cabinet">

        {{-- TOP MARQUEE ARCH --}}
        <div class="top-arch">
          <div class="marquee-track">
            <span class="marquee-inner">
              Bonus Wheel triggered when you land WHEEL symbol on 4th Reel! &nbsp;*&nbsp;
              Top multiplier 15X & Lucky Wheel up to 1000X Jackpot! &nbsp;*&nbsp;
              Garuda Wild substitutes for all gems! &nbsp;*&nbsp;
              Match 3 Garuda Wilds for 50X payout! &nbsp;*&nbsp;
              Real Money & Instant Cashouts.
            </span>
          </div>
          <div class="special-wheel-badge">SPECIAL<br>WHEEL</div>
        </div>

        {{-- MAIN STAGE --}}
        <div class="main-stage">

          {{-- Fortune wheel (left) --}}
          <div class="fortune-side">
            <canvas id="fortuneCanvas" width="148" height="148"></canvas>
            <div class="fortune-ex-badge">EX!?</div>
          </div>

          {{-- Left stone pillar --}}
          <div class="pillar left"></div>

          {{-- Reels Area --}}
          <div class="reels-area">
            <canvas id="reelsCanvas"></canvas>
            <canvas id="fireCanvas" style="position:absolute; inset:0; pointer-events:none; z-index:8;"></canvas>
            <div class="win-banner" id="winBanner">
              <div class="win-txt" id="winTxt">+0</div>
            </div>
            <div class="ribbon" id="ribbon">Bonus wheel - win multiplied!</div>
          </div>

          {{-- Right stone pillar --}}
          <div class="pillar right"></div>

          {{-- Multiplier column (right) --}}
          <div class="mult-col">
            <div class="mult-active-frame" id="multActiveFrame"></div>
            <div class="mult-strip" id="multStrip"></div>
            <div id="wheelStatus" style="display:none;"></div>
          </div>

        </div>{{-- /main-stage --}}

        {{-- CONTROL BAR --}}
        <div class="control-bar">
          <div class="cb-gear" id="settingsBtn" title="Settings / Paytable">
            <i class="fas fa-cog"></i>
          </div>
          <div class="cb-stat">
            <div class="cb-label" id="balanceLabel">Balance</div>
            <div class="cb-value" id="balanceVal">1,000.00</div>
          </div>
          <div class="cb-bet" id="betTrigger">
            <div class="cb-bet-coin"><i class="fas fa-coins"></i></div>
            <div class="cb-bet-label">Bet <span id="betVal">10</span></div>
            <div class="bet-popup" id="betPopup">
              <div class="bet-popup-title">Select Bet (Tk)</div>
              <div class="bet-grid">
                <div class="bet-item" data-value="1000">1,000</div>
                <div class="bet-item" data-value="500">500</div>
                <div class="bet-item" data-value="200">200</div>
                <div class="bet-item" data-value="100">100</div>
                <div class="bet-item" data-value="50">50</div>
                <div class="bet-item" data-value="30">30</div>
                <div class="bet-item" data-value="20">20</div>
                <div class="bet-item" data-value="15">15</div>
                <div class="bet-item" data-value="10">10</div>
              </div>
            </div>
          </div>
          <div class="cb-stat win-stat">
            <div class="cb-label">WIN</div>
            <div class="cb-value" id="winVal">0.00</div>
          </div>
          <div class="cb-turbo" id="turboToggle" title="Turbo Spin">
            <i class="fas fa-angle-double-left"></i>
          </div>
          <div class="turbo-label">Press turbo spin</div>
          <div class="cb-auto" id="autoToggle" title="Auto Spin">
            <i class="fas fa-redo-alt"></i>
          </div>
          <div class="cb-spin" id="spinBtn" title="Spin">
            <div class="jili-label">JILI</div>
            <div class="jili-sub">SPIN</div>
          </div>
          <div class="cb-wifi"><i class="fas fa-wifi"></i></div>
        </div>{{-- /control-bar --}}

        <div style="font-size:10px;color:rgba(255,255,255,0.25);text-align:left;padding:3px 8px;background:#0e0804;">v_150_135 - 1xBet Edition</div>

      </div>{{-- /cabinet --}}
    </div>{{-- /game-wrapper --}}

    {{-- BOTTOM BAR --}}
    <div class="shell-bottombar">
      <div class="bottom-tab active"><i class="fas fa-clock"></i> RECENT GAMES</div>
      <div class="bottom-tab"><i class="far fa-star"></i> FAVORITES</div>
      <div class="bottom-search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search">
      </div>
      <div class="bottom-spacer"></div>
      <div class="bottom-layout-btns">
        <div class="layout-btn active" title="Large grid"><i class="fas fa-th-large"></i></div>
        <div class="layout-btn" title="Medium grid"><i class="fas fa-th"></i></div>
        <div class="layout-btn" title="List"><i class="fas fa-th-list"></i></div>
      </div>
      <div class="bottom-page-nav">
        <div class="page-icon"><i class="fas fa-chevron-left"></i></div>
        <div class="page-icon"><i class="fas fa-chevron-right"></i></div>
      </div>
    </div>

  </div>{{-- /shell-content --}}
</div>{{-- /shell-body --}}

{{-- Paytable modal --}}
<div class="pt-overlay" id="ptOverlay">
  <div class="pt-card">
    <h3>Paytable & Multipliers</h3>
    <p class="sub">Match 3 symbols horizontally or diagonally to win.</p>
    <div id="ptRows"></div>
    <p class="sub" style="margin-top:12px;">Special 4th Reel multiplies total win (1x to 15x) or triggers Lucky Wheel up to 1000x!</p>
    <button class="pt-close" id="ptClose">Close</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
'use strict';

/* -- PRELOADER PROGRESS -- */
window.addEventListener('DOMContentLoaded', () => {
    let progress = 0;
    const progressBar = document.getElementById('loader-progress');
    const progressText = document.getElementById('loader-percent');
    const preloader = document.getElementById('game-preloader');

    const interval = setInterval(() => {
        progress += Math.floor(Math.random() * 15) + 12;
        if (progress > 100) progress = 100;

        if (progressBar) progressBar.style.width = progress + '%';
        if (progressText) progressText.innerText = `LOADING... ${progress}%`;

        if (progress >= 100) {
            clearInterval(interval);
            setTimeout(() => {
                if (preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => preloader.style.display = 'none', 500);
                }
            }, 300);
        }
    }, 90);
});

/* -- SYMBOLS & IMAGES -- */
const IMG_BASE = '/assets/image/FORTUNE GEMS 2/';

const SYMBOLS_LIST = [
  { id:'GARUDA_WILD',   symId:'sym1', img:'1.png', name:'Garuda Wild',    pay:50 },
  { id:'RED_RUBY',      symId:'sym2', img:'2.png', name:'Red Ruby',       pay:40 },
  { id:'BLUE_SAPPHIRE', symId:'sym3', img:'3.png', name:'Blue Sapphire',  pay:30 },
  { id:'GREEN_EMERALD', symId:'sym4', img:'4.png', name:'Green Emerald',  pay:20 },
  { id:'A',             symId:'sym5', img:'5.png', name:'Gold A',         pay:15 },
  { id:'K',             symId:'sym6', img:'6.png', name:'Lucky K',        pay:10 },
  { id:'Q',             symId:'sym7', img:'7.png', name:'Seven Q',        pay:8  },
  { id:'J',             symId:'sym8', img:'8.png', name:'Wild J',         pay:5  },
];

const symMap = {};
SYMBOLS_LIST.forEach(s => { symMap[s.id] = s; });

const symImages = {};
let loadedCount = 0;
function onImgLoad(){
  loadedCount++;
  if(loadedCount >= SYMBOLS_LIST.length && typeof sizeCanvas === 'function') sizeCanvas();
}
SYMBOLS_LIST.forEach(s => {
  const img = new Image();
  img.src = IMG_BASE + s.img;
  img.onload = img.onerror = onImgLoad;
  symImages[s.symId] = img;
});

function getSymbolObj(nameOrId) {
  if (symMap[nameOrId]) return symMap[nameOrId];
  const found = SYMBOLS_LIST.find(s => s.symId === nameOrId);
  return found || SYMBOLS_LIST[0];
}

/* -- STATE & WALLET -- */
const ROWS = 3, COLS = 3;
let realBalance = parseFloat("{{ auth()->check() ? auth()->user()->balance : 0 }}") || 0;
let isDemoMode  = false; // Default real money mode priority
let demoSpinsDone = 0;
let demoBalance = 1000.00;
let balance     = isDemoMode ? demoBalance : realBalance;
let bet         = 10.00;
let spinning    = false;
let autoplay    = false;
let turbo       = false;
let soundOn     = true;
let winAmt      = 0.00;
let grid        = [
  [SYMBOLS_LIST[1], SYMBOLS_LIST[4], SYMBOLS_LIST[7]],
  [SYMBOLS_LIST[0], SYMBOLS_LIST[1], SYMBOLS_LIST[2]],
  [SYMBOLS_LIST[3], SYMBOLS_LIST[5], SYMBOLS_LIST[6]]
];

/* -- DOM REFS -- */
const $ = id => document.getElementById(id);
const balanceVal    = $('balanceVal');
const balanceLabel  = $('balanceLabel');
const winValEl      = $('winVal');
const betValEl      = $('betVal');
const spinBtn       = $('spinBtn');
const autoToggle    = $('autoToggle');
const turboToggle   = $('turboToggle');
const settingsBtn   = $('settingsBtn');
const ptOverlay     = $('ptOverlay');
const ptClose       = $('ptClose');
const ptRows        = $('ptRows');
const winBanner     = $('winBanner');
const winTxt        = $('winTxt');
const ribbon        = $('ribbon');
const betPopup      = $('betPopup');
const betTrigger    = $('betTrigger');
const betItems      = document.querySelectorAll('.bet-item');
const rmTrack       = $('rmTrack');
const rmLabel       = $('rmLabel');
const depositModal  = $('deposit-popup-modal');

function fmt(n){ return parseFloat(n).toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function sleep(ms){ return new Promise(r => setTimeout(r, ms)); }

function refreshStats(){
  balanceVal.textContent = fmt(balance);
  balanceLabel.textContent = isDemoMode ? "DEMO Tk" : "BALANCE Tk";
  betValEl.textContent   = bet;
  winValEl.textContent   = fmt(winAmt);
}
refreshStats();

function flashRibbon(text){
  ribbon.textContent = text;
  ribbon.classList.add('show');
  clearTimeout(flashRibbon._t);
  flashRibbon._t = setTimeout(() => ribbon.classList.remove('show'), 2200);
}

/* -- REAL / DEMO TOGGLE -- */
if(rmTrack){
  rmTrack.onclick = function(){
    if(spinning || autoplay) return;
    isDemoMode = !isDemoMode;
    if(isDemoMode){
      rmTrack.classList.add('demo-on');
      rmLabel.textContent = "DEMO ACTIVE";
      balance = demoBalance;
      flashRibbon('Demo Mode Activated (3 Spins Limit)');
    } else {
      rmTrack.classList.remove('demo-on');
      rmLabel.textContent = "PLAY FOR REAL MONEY";
      balance = realBalance;
      flashRibbon('Real Money Mode Activated');
    }
    refreshStats();
  };
}

/* -- PAYTABLE BUILD -- */
function buildPaytable(){
  ptRows.innerHTML = '';
  SYMBOLS_LIST.forEach(s => {
    const row = document.createElement('div');
    row.className = 'pt-row';
    row.innerHTML = `
      <div class="sym">
        <img src="${IMG_BASE+s.img}" style="width:34px;height:34px;object-fit:contain;border-radius:5px;background:#1a0e03;" alt="${s.name}">
        ${s.name} x 3
      </div>
      <div class="payout">${s.pay}x</div>`;
    ptRows.appendChild(row);
  });
}
buildPaytable();

settingsBtn.onclick = () => ptOverlay.classList.add('show');
ptClose.onclick     = () => ptOverlay.classList.remove('show');
ptOverlay.onclick   = e => { if(e.target===ptOverlay) ptOverlay.classList.remove('show'); };

/* -- WEB AUDIO SYNTHESIZER FALLBACK -- */
let actx;
function beep(freq=440,dur=0.08,type='sine',gain=0.05){
  if(!soundOn) return;
  try{
    actx = actx || new (window.AudioContext||window.webkitAudioContext)();
    const o=actx.createOscillator(), g=actx.createGain();
    o.type=type; o.frequency.value=freq; g.gain.value=gain;
    o.connect(g); g.connect(actx.destination); o.start();
    g.gain.exponentialRampToValueAtTime(0.0001,actx.currentTime+dur);
    o.stop(actx.currentTime+dur);
  }catch(e){}
}

const audioSpin = new Audio();
const audioWin = new Audio();
const audioWheel = new Audio();

$('soundBtn').onclick = function(){
  soundOn = !soundOn;
  this.innerHTML = soundOn ? '<i class="fas fa-volume-up"></i>' : '<i class="fas fa-volume-mute"></i>';
  this.style.color = soundOn ? '#fff' : '#ef4444';
};

/* -- BET CONTROLS -- */
betTrigger.onclick = e => {
  e.stopPropagation();
  betPopup.classList.toggle('show');
  updateBetGrid();
};
document.addEventListener('click', e => {
  if(!betPopup.contains(e.target) && e.target!==betTrigger)
    betPopup.classList.remove('show');
});
betItems.forEach(item => {
  item.onclick = e => {
    e.stopPropagation();
    if(spinning) return;
    bet = parseFloat(item.dataset.value);
    refreshStats();
    updateBetGrid();
    betPopup.classList.remove('show');
  };
});
function updateBetGrid(){
  betItems.forEach(item => item.classList.toggle('active', parseFloat(item.dataset.value)===bet));
}
updateBetGrid();

/* -- REELS CANVAS -- */
const reelsCanvas = $('reelsCanvas');
const rctx = reelsCanvas.getContext('2d');
let cellW, cellH, canvasW, canvasH;

function sizeCanvas(){
  const frame = reelsCanvas.parentElement;
  if (!frame) return;
  const dpr   = window.devicePixelRatio || 1;

  canvasW = frame.clientWidth;
  const isMobile = window.innerWidth <= 600;
  canvasH = isMobile ? canvasW : frame.clientHeight;

  reelsCanvas.width  = canvasW * dpr;
  reelsCanvas.height = canvasH * dpr;
  reelsCanvas.style.width  = canvasW + 'px';
  reelsCanvas.style.height = canvasH + 'px';
  rctx.setTransform(dpr,0,0,dpr,0,0);

  cellW = canvasW / COLS;
  cellH = canvasH / ROWS;

  const multCol = document.querySelector('.mult-col');
  const multActiveFrameEl = document.getElementById('multActiveFrame');
  const multItems = document.querySelectorAll('.mult-item');
  if(multCol) multCol.style.height = canvasH + 'px';
  if(multActiveFrameEl){
    multActiveFrameEl.style.top    = cellH + 'px';
    multActiveFrameEl.style.height = cellH + 'px';
  }
  multItems.forEach(el => { el.style.height = cellH + 'px'; });

  drawGrid(grid, [0,0,0], []);

  if(typeof initMultiplierStrip === 'function' && document.getElementById('multStrip')){
    initMultiplierStrip();
  }
}

window.addEventListener('resize', sizeCanvas);

function drawCell(ctx, x, y, w, h, glow){
  const bg = ctx.createLinearGradient(x, y, x, y+h);
  bg.addColorStop(0,   '#f0c868');
  bg.addColorStop(0.45,'#e09828');
  bg.addColorStop(1,   '#b06010');
  ctx.fillStyle = bg;
  ctx.fillRect(x, y, w, h);

  const fw = 8;
  ctx.strokeStyle = 'rgba(0,0,0,0.55)';
  ctx.lineWidth = 1;
  ctx.strokeRect(x+0.5, y+0.5, w-1, h-1);

  const g1 = ctx.createLinearGradient(x, y, x+w, y+h);
  g1.addColorStop(0,    '#f8eaaa');
  g1.addColorStop(0.25, '#c89030');
  g1.addColorStop(0.5,  '#f8eaaa');
  g1.addColorStop(0.75, '#a07020');
  g1.addColorStop(1,    '#f8eaaa');
  ctx.strokeStyle = g1;
  ctx.lineWidth   = fw;
  ctx.strokeRect(x+fw/2, y+fw/2, w-fw, h-fw);

  if(glow){
    ctx.save();
    ctx.shadowColor = 'rgba(255,215,0,0.95)';
    ctx.shadowBlur  = 20;
    ctx.strokeStyle = '#ffe040';
    ctx.lineWidth   = 4;
    ctx.strokeRect(x+3, y+3, w-6, h-6);
    ctx.restore();
  }
}

function drawSymbolImg(ctx, sym, x, y, w, h){
  const pad = 10;
  const img = symImages[sym.symId];
  if(img && img.complete && img.naturalWidth > 0){
    ctx.drawImage(img, x+pad, y+pad, w-pad*2, h-pad*2);
  } else {
    ctx.fillStyle = '#ffd700';
    ctx.font = `bold ${Math.min(w,h)*0.28}px Cinzel,serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(sym.name || sym.id, x+w/2, y+h/2);
  }
}

function drawSymbolImgWithScale(ctx, sym, x, y, w, h, scale, rotation){
  const pad = 10;
  const img = symImages[sym.symId];
  const cx = x + w/2;
  const cy = y + h/2;

  ctx.save();
  ctx.translate(cx, cy);
  ctx.scale(scale, scale);
  if(rotation) ctx.rotate(rotation);

  const targetW = w - pad*2;
  const targetH = h - pad*2;

  if(img && img.complete && img.naturalWidth > 0){
    ctx.drawImage(img, -targetW/2, -targetH/2, targetW, targetH);
  } else {
    ctx.fillStyle = '#ffd700';
    ctx.font = `bold ${Math.min(w,h)*0.28}px Cinzel,serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(sym.name || sym.id, 0, 0);
  }
  ctx.restore();
}

function drawGrid(g, colOffsets, winCells, elapsed){
  rctx.clearRect(0, 0, canvasW, canvasH);

  for(let c=0; c<COLS; c++){
    const off = colOffsets[c] || 0;
    for(let r=0; r<ROWS; r++){
      const x  = c * cellW;
      const y  = r * cellH + off;
      const gw = winCells.some(([wc,wr]) => wc===c && wr===r);
      const cy = y + cellH/2;
      if(cy > -cellH*0.7 && cy < canvasH + cellH*0.7){
        drawCell(rctx, x, y, cellW, cellH, gw);
        const sym = g[c] && g[c][r] ? g[c][r] : SYMBOLS_LIST[0];
        if(gw && elapsed !== undefined){
          const scale = 1.0 + 0.14 * Math.sin(elapsed * 0.012);
          const rotate = 0.05 * Math.sin(elapsed * 0.008);
          drawSymbolImgWithScale(rctx, sym, x, y, cellW, cellH, scale, rotate);
        } else {
          drawSymbolImg(rctx, sym, x, y, cellW, cellH);
        }
      }
    }
    if(off > 0){
      const sym  = g[c] && g[c][ROWS-1] ? g[c][ROWS-1] : SYMBOLS_LIST[0];
      const wrapY = off - cellH * ROWS;
      const cy    = wrapY + cellH/2;
      if(cy > -cellH*0.7 && cy < canvasH+cellH*0.7){
        drawCell(rctx, c*cellW, wrapY, cellW, cellH, false);
        drawSymbolImg(rctx, sym, c*cellW, wrapY, cellW, cellH);
      }
    }
  }
}

/* -- MULTIPLIER COLUMN STRIP -- */
const multStrip = $('multStrip');
const multActiveFrame = $('multActiveFrame');
function getItemH() { return cellH || 136.6; }

const MULT_REEL_STRIP = [
  '1x', '2x', '3x', '5x', '10x', 'wheelx',
  '2x', '3x', '1x', '5x', '10x', 'wheelx',
  '1x', '3x', '2x', '5x', '10x', 'wheelx'
];

function buildMultiplierStrip(centerVal) {
  const normVal = (centerVal || '1x').toLowerCase();
  const indices = [];
  MULT_REEL_STRIP.forEach((val, idx) => {
    if (val === normVal || (normVal.includes('wheel') && val === 'wheelx')) indices.push(idx);
  });
  
  const stopIdx = indices.length ? indices[Math.floor(Math.random() * indices.length)] : 0;
  multStrip.innerHTML = '';

  for (let i = 0; i < 25; i++) {
    const offsetFromMiddle = i - 18;
    let stripIdx = (stopIdx + offsetFromMiddle) % MULT_REEL_STRIP.length;
    if (stripIdx < 0) stripIdx += MULT_REEL_STRIP.length;
    
    const val = MULT_REEL_STRIP[stripIdx];
    const div = document.createElement('div');
    div.className = 'mult-item';
    div.innerHTML = `<img src="${IMG_BASE}${val}.png" alt="${val}">`;
    multStrip.appendChild(div);
  }

  const h = getItemH();
  document.querySelectorAll('.mult-item').forEach(el => { el.style.height = h + 'px'; });
}

function initMultiplierStrip() {
  buildMultiplierStrip('3x');
  multStrip.style.transition = 'none';
  multStrip.style.transform = `translateY(${-17 * getItemH()}px)`;
}
initMultiplierStrip();

async function animateMultiplierColumnSpin(targetVal) {
  buildMultiplierStrip(targetVal);
  multStrip.style.transition = 'none';
  multStrip.style.transform = 'translateY(0px)';
  multStrip.offsetHeight;

  multStrip.classList.add('blur');
  const targetOffset = -17 * getItemH();
  const duration = turbo ? 350 : 900;

  multStrip.style.transition = `transform ${duration}ms cubic-bezier(0.1, 0.45, 0.15, 1)`;
  multStrip.style.transform = `translateY(${targetOffset}px)`;

  const soundTicks = Math.floor(duration / 70);
  for (let i = 0; i < soundTicks; i++) {
    beep(400 - (i * 5), 0.02, 'sine', 0.02);
    await sleep(70);
  }

  await sleep(Math.max(10, duration - (soundTicks * 70)));
  multStrip.classList.remove('blur');
  beep(650, 0.08, 'sine', 0.04);
}

function resetWheelFrame() {
  multActiveFrame.classList.remove('lit');
}

/* -- FORTUNE WHEEL (LUCKY WHEEL CANVAS) -- */
const fortuneCanvas = $('fortuneCanvas');
const fctx = fortuneCanvas.getContext('2d');

const F_SEGS = [
  {v:'20',  c:'#2a68c8'}, {v:'1000', c:'#e8c000'},
  {v:'50',  c:'#18904e'}, {v:'30',   c:'#8a2ab8'},
  {v:'100', c:'#2a68c8'}, {v:'500',  c:'#e8c000'},
  {v:'80',  c:'#18904e'}, {v:'200',  c:'#8a2ab8'},
];
let fAngle = 0;
let wheelSpinning = false;

function drawFortuneWheel(){
  const W  = fortuneCanvas.width;
  const H  = fortuneCanvas.height;
  const cx = W/2, cy = H/2;
  const r  = W/2 - 6;
  fctx.clearRect(0,0,W,H);

  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.fillStyle='#4a3010'; fctx.fill();
  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.strokeStyle='rgba(200,160,60,0.5)'; fctx.lineWidth=2; fctx.stroke();

  for(let t=0;t<24;t++){
    const ta=fAngle+t*(Math.PI*2/24);
    const x1=cx+Math.cos(ta)*(r+2), y1=cy+Math.sin(ta)*(r+2);
    const x2=cx+Math.cos(ta)*(r+5), y2=cy+Math.sin(ta)*(r+5);
    fctx.beginPath(); fctx.moveTo(x1,y1); fctx.lineTo(x2,y2);
    fctx.strokeStyle='rgba(255,215,0,0.6)'; fctx.lineWidth=1.5; fctx.stroke();
  }

  const n   = F_SEGS.length;
  const segA = Math.PI*2/n;
  F_SEGS.forEach((seg,i) => {
    const sa = fAngle + i*segA;
    const ea = sa + segA;
    fctx.beginPath();
    fctx.moveTo(cx,cy);
    fctx.arc(cx,cy,r,sa,ea);
    fctx.closePath();
    fctx.fillStyle = seg.c;
    fctx.fill();
    fctx.strokeStyle='rgba(0,0,0,0.3)';
    fctx.lineWidth=1.5;
    fctx.stroke();

    const midA = sa + segA/2;
    fctx.save();
    fctx.translate(
      cx + Math.cos(midA)*r*0.62,
      cy + Math.sin(midA)*r*0.62
    );
    fctx.rotate(midA + Math.PI/2);
    fctx.fillStyle = '#fff';
    fctx.font = `bold ${r*0.17}px Cinzel,serif`;
    fctx.textAlign='center';
    fctx.textBaseline='middle';
    fctx.shadowColor='rgba(0,0,0,0.6)';
    fctx.shadowBlur=3;
    fctx.fillText(seg.v, 0, 0);
    fctx.shadowBlur=0;
    fctx.restore();
  });

  fctx.beginPath(); fctx.arc(cx,cy,r*0.24,0,Math.PI*2);
  fctx.fillStyle='#2a1800'; fctx.fill();

  fctx.beginPath(); fctx.arc(cx,cy,r*0.20,0,Math.PI*2);
  const capG = fctx.createRadialGradient(cx-r*0.07,cy-r*0.07,1,cx,cy,r*0.20);
  capG.addColorStop(0,'#fff8d0');
  capG.addColorStop(0.5,'#d4af5a');
  capG.addColorStop(1,'#8a5a00');
  fctx.fillStyle=capG; fctx.fill();
  fctx.strokeStyle='#5a3a00'; fctx.lineWidth=2; fctx.stroke();
}

(function animateFortune(){
  if(!wheelSpinning){
    fAngle -= 0.008;
  }
  drawFortuneWheel();
  requestAnimationFrame(animateFortune);
})();

async function spinFortuneWheelBonus(targetMultiplier) {
  wheelSpinning = true;
  let targetIdx = F_SEGS.findIndex(s => parseInt(s.v) === parseInt(targetMultiplier));
  if (targetIdx === -1) targetIdx = 0;

  let speed = 0.05;
  for (let i = 0; i < 25; i++) {
    speed = Math.min(0.35, speed + 0.015);
    fAngle -= speed;
    await sleep(16);
  }
  
  for (let i = 0; i < 40; i++) {
    fAngle -= speed;
    if (i % 5 === 0) beep(500, 0.03, 'sine', 0.05);
    await sleep(16);
  }
  
  const segA = (Math.PI * 2) / F_SEGS.length;
  const finalAngle = -Math.PI / 2 - (targetIdx + 0.5) * segA;
  
  let currentAngle = fAngle % (Math.PI * 2);
  let destAngle = finalAngle;
  while (destAngle > currentAngle) destAngle -= Math.PI * 2;
  destAngle -= Math.PI * 4;
  
  const steps = 60;
  for (let i = 0; i <= steps; i++) {
    const t = i / steps;
    const ease = 1 - Math.pow(1 - t, 3);
    fAngle = currentAngle + (destAngle - currentAngle) * ease;
    if (i < steps - 6 && i % Math.max(1, Math.floor(10 * (1 - t))) === 0) {
      beep(420, 0.03, 'sine', 0.03);
    }
    await sleep(16);
  }
  
  fAngle = destAngle;
  wheelSpinning = false;
  return parseInt(F_SEGS[targetIdx].v) || 20;
}

/* -- CORE SPIN FLOW WITH LARAVEL BACKEND -- */
async function doSpin(){
  if(spinning) return;

  // 1. ডেমো লিমিট গার্ড (৩ স্পিনের পর স্ক্রিন লক)
  if (isDemoMode && demoSpinsDone >= 3) {
    if (depositModal) depositModal.style.display = 'flex';
    return;
  }

  // 2. ব্যালেন্স ভ্যালিডেশন
  if(balance < bet){
    flashRibbon('Insufficient Balance! Please Deposit.');
    if (depositModal) depositModal.style.display = 'flex';
    return;
  }

  spinning = true;
  spinBtn.classList.add('spinning');
  resetWheelFrame();
  winAmt = 0.00;

  balance -= bet;
  refreshStats();
  beep(220, 0.06, 'sawtooth', 0.05);

  try {
    const response = await fetch("{{ route('fortunegems.spin') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        "Accept": "application/json"
      },
      body: JSON.stringify({
        bet_amount: bet,
        is_demo: isDemoMode,
        demo_spins_count: demoSpinsDone
      })
    });

    const data = await response.json();

    if (data.status === 'deposit_required') {
      spinning = false;
      spinBtn.classList.remove('spinning');
      if (depositModal) depositModal.style.display = 'flex';
      return;
    }

    if (data.error) {
      alert(data.error);
      balance += bet;
      refreshStats();
      spinning = false;
      spinBtn.classList.remove('spinning');
      return;
    }

    if (data.audio && data.audio.spin && soundOn) {
      audioSpin.src = data.audio.spin;
      audioSpin.play().catch(()=>{});
    }

    const nextGrid = [[], [], []];
    for (let r = 0; r < 3; r++) {
      for (let c = 0; c < 3; c++) {
        const symName = data.grid[r][c];
        nextGrid[c][r] = getSymbolObj(symName);
      }
    }

    let specialTarget = '1x';
    if (data.triggered_wheel || (data.special_symbol && data.special_symbol.includes('WHEEL'))) {
      specialTarget = 'wheelx';
    } else if (data.special_symbol) {
      specialTarget = data.special_symbol.toLowerCase();
    }

    const multSpinPromise = animateMultiplierColumnSpin(specialTarget);

    const spinDur  = turbo ? 300 : 800;
    const colDelay = turbo ? 50  : 140;

    const colDone = Array(COLS).fill(false);
    const animGrid = grid.map(col => [...col]);

    for(let c=0; c<COLS; c++){
      (async col => {
        await sleep(col * colDelay);
        const start    = performance.now();
        const totalScr = cellH * (ROWS + 2);

        await new Promise(resolve => {
          function step(now){
            const t        = now - start;
            const progress = Math.min(t / spinDur, 1);
            const ease     = 1 - Math.pow(1 - progress, 3);
            const offset   = (totalScr * ease) % cellH;
            const offsets  = Array.from({length:COLS},(_,i)=>i===col?offset:0);
            drawGrid(animGrid, offsets, []);
            if(progress < 1) requestAnimationFrame(step);
            else {
              animGrid[col] = nextGrid[col];
              colDone[col] = true;
              if(colDone.every(Boolean)){
                drawGrid(nextGrid,[0,0,0],[]);
              }
              resolve();
            }
          }
          requestAnimationFrame(step);
        });
      })(c);
    }

    await Promise.all([
      sleep(spinDur + colDelay * (COLS - 1) + 100),
      multSpinPromise
    ]);

    grid = nextGrid;

    if (data.triggered_wheel) {
      multActiveFrame.classList.add('lit');
      flashRibbon('LUCKY WHEEL BONUS TRIGGERED!');
      
      if (data.audio && data.audio.wheel && soundOn) {
        audioWheel.src = data.audio.wheel;
        audioWheel.play().catch(()=>{});
      }

      await sleep(400);
      await spinFortuneWheelBonus(data.wheel_multiplier || 20);
      await sleep(400);
    } else if (data.is_win) {
      multActiveFrame.classList.add('lit');
    }

    const winCells = [];
    if (data.is_win) {
      winCells.push([0,1], [1,1], [2,1]);
      drawGrid(grid, [0,0,0], winCells);

      if (data.audio && data.audio.win && soundOn) {
        audioWin.src = data.audio.win;
        audioWin.play().catch(()=>{});
      }

      beep(680, 0.12, 'sine', 0.07);
      setTimeout(() => beep(920, 0.14, 'sine', 0.06), 140);

      winAmt = parseFloat(data.win_amount);
      winTxt.textContent = '+' + fmt(winAmt) + (data.multiplier > 1 ? ' (' + data.multiplier + 'X)' : '');
      winBanner.classList.add('show');
      flashRibbon(data.triggered_wheel ? `LUCKY WHEEL WIN Tk ${fmt(winAmt)}!` : `WIN Tk ${fmt(winAmt)} (${data.multiplier}X)!`);
      setTimeout(() => winBanner.classList.remove('show'), 2000);
    } else {
      flashRibbon('Try again!');
    }

    if (isDemoMode) {
      demoSpinsDone++;
      demoBalance = demoBalance - bet + data.win_amount;
      balance = demoBalance;
    } else {
      if (data.new_balance !== null && data.new_balance !== undefined) {
        realBalance = parseFloat(data.new_balance);
        balance = realBalance;
      }
    }
    refreshStats();

  } catch(err) {
    console.error('Spin execution error:', err);
    flashRibbon('Connection error. Please retry.');
    balance += bet;
    refreshStats();
  } finally {
    spinBtn.classList.remove('spinning');
    spinning = false;

    if(autoplay){
      if(balance >= bet && (!isDemoMode || demoSpinsDone < 3)) {
        setTimeout(doSpin, 700);
      } else {
        autoplay = false;
        autoToggle.classList.remove('active');
        if (isDemoMode && demoSpinsDone >= 3 && depositModal) {
          depositModal.style.display = 'flex';
        }
      }
    }
  }
}

/* -- BUTTON EVENTS -- */
spinBtn.onclick = () => { if(!spinning) doSpin(); };

autoToggle.onclick = () => {
  autoplay = !autoplay;
  autoToggle.classList.toggle('active', autoplay);
  if(autoplay && !spinning) doSpin();
};

turboToggle.onclick = () => {
  turbo = !turbo;
  turboToggle.classList.toggle('active', turbo);
};

setTimeout(sizeCanvas, 150);

})();
</script>
</body>
</html>
