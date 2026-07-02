<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Fortune Gems 2 — JILI Slot</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{background:#1a0f05;font-family:'Poppins',sans-serif;min-height:100vh;overflow-x:hidden;}

/* ── GAME WRAPPER ── */
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
  background:rgba(0,0,0,0.3); /* dark overlay to highlight cabinet */
  z-index:0;
}

/* ── CABINET ── */
.cabinet{
  position:relative;z-index:1;
  width:100%;max-width:870px;
  display:flex;flex-direction:column;
  border-radius:8px;
  border:4px solid #3c240a;
  overflow:hidden;
  box-shadow:0 12px 50px rgba(0,0,0,0.85);
}

/* ── TOP ARCH / MARQUEE ── */
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

/* ── MAIN STAGE ── */
.main-stage{
  display:flex;align-items:stretch;
  background:linear-gradient(180deg,#b86e1a 0%,#8a4608 100%);
  border-left:3px solid #4a2e0e;
  border-right:3px solid #4a2e0e;
  height:410px; /* desktop: fixed height for original design */
  position:relative;
}

/* Fortune wheel side — overflows left so wheel hangs outside cabinet */
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
/* Fortune wheel canvas — large, overflows outside to the left */
#fortuneCanvas{
  width:148px;height:148px;
  border-radius:50%;
  border:5px solid #7a5200;
  box-shadow:0 0 24px rgba(0,0,0,0.7),0 0 12px rgba(0,0,0,0.5);
  margin-left:-40px; /* hang it outside the cabinet */
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

/* Multiplier column (right) — seamless spinning strip viewport */
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
  transform:scale(1.22); /* scales image up to touch borders exactly, leaving no left/right gaps */
  display:block;
  transition:filter 0.1s;
}
.mult-strip.blur img{
  filter:blur(3px) contrast(1.15); /* motion blur effect during spin */
}
.mult-active-frame{
  position:absolute;
  top:136.6px; /* perfectly centers middle slot: (410 - 136.6) / 2 */
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

/* ── CONTROL BAR ── */
.control-bar{
  height:78px;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 14px;gap:10px;
  background:linear-gradient(180deg,#7a5228 0%,#5a3610 40%,#7a5228 100%);
  border:3px solid #4a2e0e;
  border-top:3px solid #2a1006;
}

/* Gear */
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

/* Stats */
.cb-stat{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
.cb-label{font-family:'Poppins',sans-serif;font-size:11.5px;font-weight:600;color:rgba(255,255,255,0.85);}
.cb-value{font-family:'Cinzel',serif;font-size:18px;font-weight:700;color:#fff;line-height:1.1;}

/* Bet coin */
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

/* Turbo */
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

/* Auto */
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

/* JILI Spin button */
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

/* WiFi */
.cb-wifi{color:#4cd964;font-size:16px;text-shadow:0 0 10px rgba(76,217,100,0.7);flex-shrink:0;}

/* Bet popup */
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

/* Press turbo label */
.turbo-label{
  font-family:'Poppins',sans-serif;font-size:10px;
  color:rgba(255,255,255,0.6);white-space:nowrap;
  display:none;
}
@media(min-width:700px){.turbo-label{display:block;}}

/* ── SHELL: TOP NAV BAR ── */
.shell-topnav{
  height:40px;
  background:#1a2030;
  display:flex;align-items:center;
  padding:0 14px;
  border-bottom:1px solid rgba(255,255,255,0.07);
  gap:0;
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

/* ── SHELL: PAGE BODY (sidebar + content) ── */
.shell-body{
  display:flex;flex:1;min-height:0;
  background:#141824;
}

/* ── SHELL: LEFT SIDEBAR ── */
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

/* ── SHELL: MAIN CONTENT AREA ── */
.shell-content{
  flex:1;display:flex;flex-direction:column;overflow:hidden;
  min-width:0;
}

/* ── SHELL: IN-GAME HEADER BAR ── */
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
  background:rgba(255,255,255,0.15);
  cursor:pointer;position:relative;
  transition:background 0.2s;
  border:1.5px solid rgba(255,255,255,0.2);
}
.real-money-toggle .switch-track.on{
  background:linear-gradient(90deg,#2a7aff,#1a5acc);
  border-color:#2a7aff;
}
.real-money-toggle .switch-dot{
  width:12px;height:12px;border-radius:50%;
  background:#fff;position:absolute;
  top:2px;left:2px;
  transition:transform 0.2s;
  box-shadow:0 1px 4px rgba(0,0,0,0.4);
}
.real-money-toggle .switch-track.on .switch-dot{
  transform:translateX(16px);
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

/* ── SHELL: BOTTOM BAR ── */
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

/* ── game-wrapper override for shell layout ── */
.game-wrapper{
  flex:1;min-height:0;
  position:relative;
  display:flex;align-items:center;justify-content:center;
  padding:24px 12/* ═══════════════════════════════════════════════
   RESPONSIVE — TABLET  (≤ 840px)
═══════════════════════════════════════════════ */
@media(max-width:840px){
  .cabinet{max-width:100%;}
  .game-wrapper{padding:8px 6px;}
  .topnav-search{display:none;}
  .topnav-breadcrumb{font-size:11px;}
  .main-stage{height:auto;}
  .cb-spin{width:76px;height:76px;}
}

/* ═══════════════════════════════════════════════
   RESPONSIVE — MOBILE  (≤ 600px)
═══════════════════════════════════════════════ */
@media(max-width:600px){

  /* ── SHELL: hide top nav & bottom bar, keep compact sidebar ── */
  .shell-topnav{display:none;}
  .shell-bottombar{display:none;}

  /* Compact sidebar — icon only, 44px wide */
  .shell-sidebar{
    width:44px;
    padding:8px 0;
    gap:4px;
  }
  .sidebar-icon{
    width:34px;height:34px;
    font-size:15px;border-radius:8px;
  }

  /* Shell body fills full screen height */
  .shell-body{
    height:100vh;
    height:100dvh; /* dynamic viewport for iOS Safari */
    overflow:hidden;
  }

  /* Game wrapper — no padding, fill full space */
  .game-wrapper{
    padding:0;
    align-items:stretch;
  }

  /* Cabinet — edge to edge, no rounded corners */
  .cabinet{
    max-width:100%;
    width:100%;
    border-radius:0;
    border-width:0;
    box-shadow:none;
    display:flex;
    flex-direction:column;
    height:100%;
  }

  /* In-game header — compact */
  .ingame-header{
    height:32px;
    padding:0 8px;
    gap:6px;
    flex-shrink:0;
  }
  .ingame-header .game-provider{display:none;}
  .ingame-header .game-name{font-size:11px;}
  .ingame-header .game-fav{font-size:13px;}
  .real-money-toggle .switch-track{width:28px;height:16px;}
  .real-money-toggle{font-size:10px;gap:5px;}

  /* Top arch marquee — compact */
  .top-arch{height:32px;flex-shrink:0;}
  .marquee-inner{font-size:11px;}
  .special-wheel-badge{width:84px;font-size:10px;letter-spacing:0;}

  /* Main stage — fills remaining vertical space */
  .main-stage{
    flex:1;
    height:auto;
    min-height:0;
    overflow:hidden;
  }

  /* Fortune wheel side */
  .fortune-side{
    width:68px;
    padding:4px 2px;
    gap:4px;
  }
  #fortuneCanvas{
    width:90px;height:90px;
    margin-left:-26px;
    border-width:3px;
    box-shadow:0 0 14px rgba(0,0,0,0.7);
  }
  .fortune-ex-badge{
    font-size:9.5px;
    padding:2px 8px;
    border-radius:16px;
  }

  /* Pillars — very thin */
  .pillar{width:18px;}
  .pillar::before{display:none;} /* hide texture on tiny pillars */

  /* Reels canvas fills */
  .reels-area{flex:1;min-width:0;overflow:hidden;}

  /* Multiplier column */
  .mult-col{
    width:62px;
    border-left:2px solid #3c1616;
  }
  .mult-item img{
    transform:scale(1.3);
    display:block;
  }
  .mult-active-frame{
    border-width:3.5px;
    border-radius:6px;
  }

  /* ── CONTROL BAR ── */
  .control-bar{
    height:auto;
    min-height:60px;
    padding:4px 10px;
    gap:6px;
    flex-shrink:0;
    flex-wrap:nowrap; /* single row, no wrapping */
    justify-content:space-between;
    align-items:center;
  }

  /* Stats — hide win on very small phones, keep balance */
  .cb-stat.win-stat{display:none;}

  .cb-stat{flex:0 1 auto;}
  .cb-label{font-size:9.5px;}
  .cb-value{font-size:14px;line-height:1.1;}

  /* Spin button — centered, prominent */
  .cb-spin{
    width:62px;height:62px;
    margin-top:-10px;
    flex-shrink:0;
  }
  .cb-spin .jili-label{font-size:11px;}
  .cb-spin .jili-sub{font-size:8px;}

  /* Smaller controls */
  .cb-gear{width:36px;height:36px;font-size:16px;}
  .cb-auto{width:34px;height:34px;font-size:14px;}
  .cb-turbo{width:40px;height:30px;font-size:14px;}
  .cb-bet-coin{width:36px;height:36px;font-size:14px;}
  .cb-bet-label{font-size:9.5px;margin-top:1px;}
  .cb-wifi{font-size:14px;}
  .turbo-label{display:none !important;}

  /* Win banner */
  .win-txt{font-size:20px;}
  .win-banner{padding:8px 20px;}

  /* Paytable — full width */
  .pt-card{width:calc(100vw - 20px);padding:14px;}

  /* Bet popup */
  .bet-popup{width:calc(100vw - 32px);left:50%;transform:translateX(-50%);}
}

/* ═══════════════════════════════════════════════
   RESPONSIVE — SMALL PHONES  (≤ 390px)
═══════════════════════════════════════════════ */
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

/* ═══════════════════════════════════════════════
   RESPONSIVE — LANDSCAPE MOBILE  (height ≤ 480px)
═══════════════════════════════════════════════ */
@media(max-height:480px) and (orientation:landscape){
  .shell-topnav,.shell-bottombar{display:none;}
  .shell-sidebar{width:40px;}
  .ingame-header{height:28px;}
  .top-arch{height:26px;}
  .game-wrapper{padding:0;}
  .main-stage{flex:1;height:auto;}
  .control-bar{
    min-height:48px;
    padding:3px 8px;
    flex-wrap:nowrap;
    gap:5px;
  }
  #fortuneCanvas{width:72px;height:72px;margin-left:-18px;}
  .fortune-side{width:56px;gap:3px;padding:3px 1px;}
  .fortune-ex-badge{display:none;}
  .pillar{width:14px;}
  .mult-col{width:56px;}
  .cb-spin{width:52px;height:52px;margin-top:-6px;}
  .win-txt{font-size:18px;}
  .cb-stat.win-stat{display:none;}
}��═══════════════════════════════
   RESPONSIVE — LANDSCAPE MOBILE  (height ≤ 500px)
═══════════════════════════════════════════════ */
@media(max-height:500px) and (orientation:landscape){
  .shell-topnav,.shell-bottombar{display:none;}
  .shell-sidebar{display:none;}
  .game-wrapper{padding:4px;}
  .top-arch{height:28px;}
  .main-stage{min-height:unset;}
  .control-bar{
    height:auto;min-height:52px;
    padding:4px 8px;gap:5px;
    flex-wrap:nowrap;
  }
  #fortuneCanvas{width:80px;height:80px;margin-left:-20px;}
  .fortune-side{width:62px;gap:4px;padding:4px 2px;}
  .fortune-ex-badge{display:none;}
  .pillar{width:18px;}
  .mult-col{width:64px;}
  .cb-spin{width:58px;height:58px;margin-top:-8px;}
  .win-txt{font-size:20px;}
}
</style>
</head>
<body>

@include('customer.header')

{{-- ═══ SHELL TOP NAV BAR ═══ --}}
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

{{-- ═══ SHELL BODY (sidebar + content) ═══ --}}
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
        <span>PLAY FOR REAL MONEY</span>
      </div>

      {{-- Action Icons --}}
      <div class="ingame-actions">
        <button class="ingame-icon" title="Fullscreen" id="fullscreenBtn"><i class="fas fa-expand"></i></button>
        <button class="ingame-icon" title="Sound" id="soundBtn"><i class="fas fa-volume-up"></i></button>
        <button class="ingame-icon" title="Refresh" id="refreshBtn"><i class="fas fa-sync-alt"></i></button>
        <button class="ingame-icon" title="Favorite" id="favBtn"><i class="far fa-star"></i></button>
        <button class="ingame-icon close-icon" title="Close" onclick="history.back()"><i class="fas fa-times"></i></button>
      </div>
    </div>

    {{-- GAME WRAPPER --}}
    <div class="game-wrapper">
      <div class="game-bg"></div>

      <div class="cabinet">

        {{-- ── TOP MARQUEE ARCH ── --}}
        <div class="top-arch">
          <div class="marquee-track">
            <span class="marquee-inner">
              Bonus Wheel triggered when you land WHEEL symbol or 3 matching gems in a row! &nbsp;•&nbsp;
              Top multiplier 15×! &nbsp;•&nbsp;
              Win multiplier activated by the Special Wheel column! &nbsp;•&nbsp;
              Auto Spin and Turbo modes available! &nbsp;•&nbsp;
              Match Symbol 1 × 3 for highest payout 50×!
            </span>
          </div>
          <div class="special-wheel-badge">SPECIAL<br>WHEEL</div>
        </div>

        {{-- ── MAIN STAGE ── --}}
        <div class="main-stage">

          {{-- Fortune wheel (left) — canvas drawn, hangs outside cabinet --}}
          <div class="fortune-side">
            <canvas id="fortuneCanvas" width="148" height="148"></canvas>
            <div class="fortune-ex-badge">EX!?</div>
          </div>

          {{-- Left stone pillar --}}
          <div class="pillar left"></div>

          {{-- Reels --}}
          <div class="reels-area">
            <canvas id="reelsCanvas"></canvas>
            <canvas id="fireCanvas" style="position:absolute; inset:0; pointer-events:none; z-index:8;"></canvas>
            <div class="win-banner" id="winBanner">
              <div class="win-txt" id="winTxt">+0</div>
            </div>
            <div class="ribbon" id="ribbon">Bonus wheel — win multiplied!</div>
          </div>

          {{-- Right stone pillar --}}
          <div class="pillar right"></div>

          {{-- Multiplier column (right) — seamless spinning strip --}}
          <div class="mult-col">
            <div class="mult-active-frame" id="multActiveFrame"></div>
            <div class="mult-strip" id="multStrip"></div>
            <div id="wheelStatus" style="display:none;"></div>
          </div>

        </div>{{-- /main-stage --}}


        {{-- ── CONTROL BAR ── --}}
        <div class="control-bar">
          <div class="cb-gear" id="settingsBtn" title="Settings / Paytable">
            <i class="fas fa-cog"></i>
          </div>
          <div class="cb-stat">
            <div class="cb-label">Balance</div>
            <div class="cb-value" id="balanceVal">1,000.00</div>
          </div>
          <div class="cb-bet" id="betTrigger">
            <div class="cb-bet-coin"><i class="fas fa-coins"></i></div>
            <div class="cb-bet-label">Bet <span id="betVal">10</span></div>
            <div class="bet-popup" id="betPopup">
              <div class="bet-popup-title">Select Bet</div>
              <div class="bet-grid">
                <div class="bet-item" data-value="1000">1,000</div>
                <div class="bet-item" data-value="200">200</div>
                <div class="bet-item" data-value="8">8</div>
                <div class="bet-item" data-value="700">700</div>
                <div class="bet-item" data-value="100">100</div>
                <div class="bet-item" data-value="5">5</div>
                <div class="bet-item" data-value="500">500</div>
                <div class="bet-item" data-value="50">50</div>
                <div class="bet-item" data-value="3">3</div>
                <div class="bet-item" data-value="400">400</div>
                <div class="bet-item" data-value="20">20</div>
                <div class="bet-item" data-value="2">2</div>
                <div class="bet-item" data-value="300">300</div>
                <div class="bet-item" data-value="10">10</div>
                <div class="bet-item" data-value="1">1</div>
              </div>
            </div>
          </div>
          <div class="cb-stat">
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
            <div class="jili-sub">||||</div>
          </div>
          <div class="cb-wifi"><i class="fas fa-wifi"></i></div>
        </div>{{-- /control-bar --}}

        <div style="font-size:10px;color:rgba(255,255,255,0.25);text-align:left;padding:3px 8px;background:#0e0804;">v_150_135</div>

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

{{-- Hidden JS compat --}}
<div id="soundToggle" style="display:none;"></div>
<div id="paytableBtn" style="display:none;"></div>
<div id="resetBtn" style="display:none;"></div>
<input type="checkbox" id="realMoneyToggle" style="display:none;">

{{-- Paytable modal --}}
<div class="pt-overlay" id="ptOverlay">
  <div class="pt-card">
    <h3>Paytable</h3>
    <p class="sub">Match 3 symbols across any row (top, mid, bottom) to win.</p>
    <div id="ptRows"></div>
    <p class="sub" style="margin-top:12px;">🎡 Special Wheel: triggered randomly — multiplies total win by 5×, 10× or 15×!</p>
    <button class="pt-close" id="ptClose">Close ✕</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
'use strict';

/* ══════════════════════════════════════════════
   SYMBOLS — images from /assets/image/FORTUNE GEMS 2/
══════════════════════════════════════════════ */
const IMG_BASE = '/assets/image/FORTUNE GEMS 2/';

const SYMBOLS = [
  { id:'sym1', img:'1.png', name:'Fortune Dragon', pay:50, weight:4  },
  { id:'sym2', img:'2.png', name:'Ruby Gem',       pay:40, weight:5  },
  { id:'sym3', img:'3.png', name:'Sapphire Gem',   pay:30, weight:6  },
  { id:'sym4', img:'4.png', name:'Emerald Gem',    pay:22, weight:8  },
  { id:'sym5', img:'5.png', name:'Gold Coin',      pay:16, weight:10 },
  { id:'sym6', img:'6.png', name:'Lucky Bell',     pay:12, weight:12 },
  { id:'sym7', img:'7.png', name:'Seven Star',     pay:9,  weight:14 },
  { id:'sym8', img:'8.png', name:'Wild Card',      pay:6,  weight:18 },
];

/* Preload symbol images */
const symImages = {};
let loadedCount = 0;
function onImgLoad(){
  loadedCount++;
  if(loadedCount >= SYMBOLS.length) sizeCanvas();
}
SYMBOLS.forEach(s => {
  const img = new Image();
  img.src = IMG_BASE + s.img;
  img.onload = img.onerror = onImgLoad;
  symImages[s.id] = img;
});


function weightedRandom(){
  const total = SYMBOLS.reduce((s,x) => s + x.weight, 0);
  let r = Math.random() * total;
  for(const s of SYMBOLS){ if(r < s.weight) return s; r -= s.weight; }
  return SYMBOLS[SYMBOLS.length-1];
}

/* ══════════════════════════════════════════════
   STATE
══════════════════════════════════════════════ */
const ROWS = 3, COLS = 3;
let realBalance = parseFloat("{{ auth()->user()->balance }}") || 0;
let isDemoMode  = (new URLSearchParams(location.search).get('demo') === '1') || realBalance < 10;
let demoBalance = 1000;
let balance     = isDemoMode ? demoBalance : realBalance;
let bet         = 10;
const BET_STEPS = [1,2,3,5,8,10,20,50,100,200,300,400,500,700,1000];
let spinning    = false;
let autoplay    = false;
let turbo       = false;
let soundOn     = true;
let winAmt      = 0;
let grid        = [];

for(let c=0;c<COLS;c++){
  grid.push([]);
  for(let r=0;r<ROWS;r++) grid[c].push(weightedRandom());
}

/* ══════════════════════════════════════════════
   DOM REFS
══════════════════════════════════════════════ */
const $ = id => document.getElementById(id);
const balanceVal  = $('balanceVal');
const winValEl    = $('winVal');
const betValEl    = $('betVal');
const spinBtn     = $('spinBtn');
const autoToggle  = $('autoToggle');
const turboToggle = $('turboToggle');
const settingsBtn = $('settingsBtn');
const ptOverlay   = $('ptOverlay');
const ptClose     = $('ptClose');
const ptRows      = $('ptRows');
const winBanner   = $('winBanner');
const winTxt      = $('winTxt');
const ribbon      = $('ribbon');
const wheelStatus = $('wheelStatus');
const betPopup    = $('betPopup');
const betTrigger  = $('betTrigger');
const betItems    = document.querySelectorAll('.bet-item');
const realMoneyToggle = $('realMoneyToggle');

/* ══════════════════════════════════════════════
   HELPERS
══════════════════════════════════════════════ */
function fmt(n){ return parseFloat(n).toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function sleep(ms){ return new Promise(r => setTimeout(r, ms)); }

function refreshStats(){
  balanceVal.textContent = fmt(balance);
  betValEl.textContent   = bet;
  winValEl.textContent   = fmt(winAmt);
}
refreshStats();

function flashRibbon(text){
  ribbon.textContent = text;
  ribbon.classList.add('show');
  clearTimeout(flashRibbon._t);
  flashRibbon._t = setTimeout(() => ribbon.classList.remove('show'), 1900);
}

/* ══════════════════════════════════════════════
   BALANCE SYNC
══════════════════════════════════════════════ */
function syncBalance(newBal){
  if(isDemoMode) return;
  fetch('{{ route("dashboard.update-balance") }}', {
    method: 'POST',
    headers:{
      'Content-Type':'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept':'application/json'
    },
    body: JSON.stringify({ balance: newBal.toFixed(2) })
  }).then(r=>r.json()).then(d=>{ if(d.success) realBalance=newBal; }).catch(()=>{});
}

/* ══════════════════════════════════════════════
   PAYTABLE
══════════════════════════════════════════════ */
function buildPaytable(){
  ptRows.innerHTML = '';
  SYMBOLS.forEach(s => {
    const row = document.createElement('div');
    row.className = 'pt-row';
    row.innerHTML = `
      <div class="sym">
        <img src="${IMG_BASE+s.img}" style="width:34px;height:34px;object-fit:contain;border-radius:5px;background:#1a0e03;" alt="${s.name}">
        ${s.name} ×3
      </div>
      <div class="payout">${s.pay}×</div>`;
    ptRows.appendChild(row);
  });
}
buildPaytable();

settingsBtn.onclick = () => ptOverlay.classList.add('show');
ptClose.onclick     = () => ptOverlay.classList.remove('show');
ptOverlay.onclick   = e => { if(e.target===ptOverlay) ptOverlay.classList.remove('show'); };

/* ══════════════════════════════════════════════
   SOUND
══════════════════════════════════════════════ */
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

/* ══════════════════════════════════════════════
   BET CONTROLS
══════════════════════════════════════════════ */
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
    bet = parseInt(item.dataset.value);
    refreshStats();
    updateBetGrid();
    betPopup.classList.remove('show');
  };
});
function updateBetGrid(){
  betItems.forEach(item => item.classList.toggle('active', parseInt(item.dataset.value)===bet));
}
updateBetGrid();

/* ══════════════════════════════════════════════
   REELS CANVAS — with golden ornate frame cells
══════════════════════════════════════════════ */
const reelsCanvas = $('reelsCanvas');
const rctx = reelsCanvas.getContext('2d');
let cellW, cellH, canvasW, canvasH;

function sizeCanvas(){
  const frame = reelsCanvas.parentElement;
  const dpr   = window.devicePixelRatio || 1;

  canvasW = frame.clientWidth;

  // On mobile (≤600px): force square cells so symbols don't stretch
  // On desktop: use the actual stage height (original 410px design)
  const isMobile = window.innerWidth <= 600;
  canvasH = isMobile ? canvasW : frame.clientHeight;

  reelsCanvas.width  = canvasW * dpr;
  reelsCanvas.height = canvasH * dpr;
  reelsCanvas.style.width  = canvasW + 'px';
  reelsCanvas.style.height = canvasH + 'px';
  rctx.setTransform(dpr,0,0,dpr,0,0);

  cellW = canvasW / COLS;
  cellH = canvasH / ROWS;

  // Always sync mult-col and active frame to match canvas height
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

  // Re-position multiplier strip to match new cellH (safe to call after first init)
  if(typeof initMultiplierStrip === 'function' && document.getElementById('multStrip')){
    initMultiplierStrip();
  }
}

/* Draw one cell: warm amber background + thick golden ornate frame */
function drawCell(ctx, x, y, w, h, glow){
  // Warm amber/gold background
  const bg = ctx.createLinearGradient(x, y, x, y+h);
  bg.addColorStop(0,   '#f0c868');
  bg.addColorStop(0.45,'#e09828');
  bg.addColorStop(1,   '#b06010');
  ctx.fillStyle = bg;
  ctx.fillRect(x, y, w, h);

  const fw = 10; // frame width

  // ── Outer shadow line ──
  ctx.strokeStyle = 'rgba(0,0,0,0.55)';
  ctx.lineWidth = 1;
  ctx.strokeRect(x+0.5, y+0.5, w-1, h-1);

  // ── Gold frame (outer) ──
  const g1 = ctx.createLinearGradient(x, y, x+w, y+h);
  g1.addColorStop(0,    '#f8eaaa');
  g1.addColorStop(0.25, '#c89030');
  g1.addColorStop(0.5,  '#f8eaaa');
  g1.addColorStop(0.75, '#a07020');
  g1.addColorStop(1,    '#f8eaaa');
  ctx.strokeStyle = g1;
  ctx.lineWidth   = fw;
  ctx.strokeRect(x+fw/2, y+fw/2, w-fw, h-fw);

  // ── Dark inner border ──
  ctx.strokeStyle = 'rgba(40,12,0,0.6)';
  ctx.lineWidth   = 1.5;
  ctx.strokeRect(x+fw+0.75, y+fw+0.75, w-fw*2-1.5, h-fw*2-1.5);

  // ── Bright inner line ──
  ctx.strokeStyle = 'rgba(255,240,160,0.65)';
  ctx.lineWidth   = 1;
  ctx.strokeRect(x+fw+2.5, y+fw+2.5, w-fw*2-5, h-fw*2-5);

  // ── Corner squares (decorative) ──
  const cs = 11;
  const corners = [
    [x+fw/2-cs/2,   y+fw/2-cs/2  ],
    [x+w-fw/2-cs/2, y+fw/2-cs/2  ],
    [x+fw/2-cs/2,   y+h-fw/2-cs/2],
    [x+w-fw/2-cs/2, y+h-fw/2-cs/2],
  ];
  corners.forEach(([cx2,cy2]) => {
    const cg = ctx.createRadialGradient(cx2+cs/2,cy2+cs/2,1,cx2+cs/2,cy2+cs/2,cs);
    cg.addColorStop(0,'#fffbe0');
    cg.addColorStop(1,'#c08020');
    ctx.fillStyle = cg;
    ctx.fillRect(cx2, cy2, cs, cs);
    ctx.strokeStyle = 'rgba(40,12,0,0.5)';
    ctx.lineWidth = 1;
    ctx.strokeRect(cx2, cy2, cs, cs);
  });

  // ── Glow on winning cells ──
  if(glow){
    ctx.save();
    ctx.shadowColor = 'rgba(255,215,0,0.95)';
    ctx.shadowBlur  = 24;
    ctx.strokeStyle = '#ffe040';
    ctx.lineWidth   = 4;
    ctx.strokeRect(x+3, y+3, w-6, h-6);
    ctx.shadowBlur  = 0;
    ctx.restore();
  }
}

/* Draw symbol image inside the cell (over the frame) */
function drawSymbolImg(ctx, sym, x, y, w, h){
  const pad = 12; // inset from frame edges
  const img = symImages[sym.id];
  if(img && img.complete && img.naturalWidth > 0){
    ctx.drawImage(img, x+pad, y+pad, w-pad*2, h-pad*2);
  } else {
    ctx.fillStyle = '#ffd700';
    ctx.font = `bold ${Math.min(w,h)*0.32}px Cinzel,serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(sym.id, x+w/2, y+h/2);
  }
}

/* Draw symbol image with custom scale/rotation (used for winning animations) */
function drawSymbolImgWithScale(ctx, sym, x, y, w, h, scale, rotation){
  const pad = 12;
  const img = symImages[sym.id];
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
    ctx.font = `bold ${Math.min(w,h)*0.32}px Cinzel,serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(sym.id, 0, 0);
  }
  ctx.restore();
}

/* Draw all 9 cells + symbols, with scroll offsets and optional win animation elapsed time */
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
        if(gw && elapsed !== undefined){
          // Rich pulsation + slight wiggling animation
          const scale = 1.0 + 0.16 * Math.sin(elapsed * 0.013);
          const rotate = 0.07 * Math.sin(elapsed * 0.009);
          drawSymbolImgWithScale(rctx, g[c][r], x, y, cellW, cellH, scale, rotate);
        } else {
          drawSymbolImg(rctx, g[c][r], x, y, cellW, cellH);
        }
      }
    }
    // Wrap-around symbol above
    if(off > 0){
      const sym  = g[c][ROWS-1];
      const wrapY = off - cellH * ROWS;
      const cy    = wrapY + cellH/2;
      if(cy > -cellH*0.7 && cy < canvasH+cellH*0.7){
        drawCell(rctx, c*cellW, wrapY, cellW, cellH, false);
        drawSymbolImg(rctx, sym, c*cellW, wrapY, cellW, cellH);
      }
    }
  }
}

/* ══════════════════════════════════════════════
   MULTIPLIER COLUMN — DYNAMIC SCROLLING STRIP
══════════════════════════════════════════════ */
const WHEEL_VALUES = ['1x', '2x', '3x', '5x', '10x', 'wheelx'];
const multStrip = $('multStrip');
const multActiveFrame = $('multActiveFrame');

// Dynamic item height — always matches the actual rendered cell height
function getItemH() { return cellH || 136.6; }

// Consistent ordering of a real mechanical slot multiplier reel
const MULT_REEL_STRIP = [
  '1x', '2x', '3x', '5x', '10x', 'wheelx',
  '2x', '3x', '1x', '5x', '10x', 'wheelx',
  '1x', '3x', '2x', '5x', '10x', 'wheelx'
];

let stripList = [];

function buildMultiplierStrip(centerVal) {
  // Find indices of centerVal in our reel strip
  const indices = [];
  MULT_REEL_STRIP.forEach((val, idx) => {
    if (val === centerVal) indices.push(idx);
  });
  
  // Pick a random stop index from the occurrences
  const stopIdx = indices[Math.floor(Math.random() * indices.length)];
  
  multStrip.innerHTML = '';
  stripList = [];

  // Generate 25 symbols in the strip following the exact sequential order
  for (let i = 0; i < 25; i++) {
    const offsetFromMiddle = i - 18; // Index 18 is the center target position
    let stripIdx = (stopIdx + offsetFromMiddle) % MULT_REEL_STRIP.length;
    if (stripIdx < 0) stripIdx += MULT_REEL_STRIP.length;
    
    const val = MULT_REEL_STRIP[stripIdx];
    stripList.push(val);

    const div = document.createElement('div');
    div.className = 'mult-item';
    div.innerHTML = `<img src="${IMG_BASE}${val}.png" alt="${val}">`;
    multStrip.appendChild(div);
  }

  // Apply dynamic height to each item so strip matches canvas cell size
  const h = getItemH();
  document.querySelectorAll('.mult-item').forEach(el => { el.style.height = h + 'px'; });
}

// Initial setup (static stop showing 3x in middle, 10x on top, 5x on bottom)
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
  multStrip.offsetHeight; // trigger reflow

  multStrip.classList.add('blur');

  // Align index 18 exactly inside active frame: translate strip up by 17 items
  const targetOffset = -17 * getItemH();
  const duration = turbo ? 350 : 900;

  multStrip.style.transition = `transform ${duration}ms cubic-bezier(0.1, 0.45, 0.15, 1)`;
  multStrip.style.transform = `translateY(${targetOffset}px)`;

  const soundTicks = Math.floor(duration / 65);
  for (let i = 0; i < soundTicks; i++) {
    beep(400 - (i * 5), 0.02, 'sine', 0.02);
    await sleep(65);
  }

  await sleep(duration - (soundTicks * 65));
  multStrip.classList.remove('blur');
  beep(650, 0.08, 'sine', 0.04);
}

function resetWheel() {
  multActiveFrame.classList.remove('lit');
}


/* ══════════════════════════════════════════════
   FORTUNE WHEEL — canvas-drawn, animates via rAF
══════════════════════════════════════════════ */
const fortuneCanvas = $('fortuneCanvas');
const fctx = fortuneCanvas.getContext('2d');

const F_SEGS = [
  {v:'5',   c:'#2a68c8'}, {v:'300', c:'#e8c000'},
  {v:'60',  c:'#18904e'}, {v:'6',   c:'#8a2ab8'},
  {v:'15',  c:'#2a68c8'}, {v:'90',  c:'#e8c000'},
  {v:'3',   c:'#18904e'}, {v:'0',   c:'#8a2ab8'},
];
let fAngle = 0;

function drawFortuneWheel(){
  const W  = fortuneCanvas.width;
  const H  = fortuneCanvas.height;
  const cx = W/2, cy = H/2;
  const r  = W/2 - 6;
  fctx.clearRect(0,0,W,H);

  /* Outer decorative rim */
  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.fillStyle='#4a3010'; fctx.fill();
  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.strokeStyle='rgba(200,160,60,0.5)'; fctx.lineWidth=2; fctx.stroke();

  /* Tick marks on rim */
  for(let t=0;t<24;t++){
    const ta=fAngle+t*(Math.PI*2/24);
    const x1=cx+Math.cos(ta)*(r+2), y1=cy+Math.sin(ta)*(r+2);
    const x2=cx+Math.cos(ta)*(r+5), y2=cy+Math.sin(ta)*(r+5);
    fctx.beginPath(); fctx.moveTo(x1,y1); fctx.lineTo(x2,y2);
    fctx.strokeStyle='rgba(255,215,0,0.6)'; fctx.lineWidth=1.5; fctx.stroke();
  }

  /* Segments */
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
    /* Segment border */
    fctx.strokeStyle='rgba(0,0,0,0.3)';
    fctx.lineWidth=1.5;
    fctx.stroke();
    /* Label */
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

  /* Inner separator ring */
  fctx.beginPath(); fctx.arc(cx,cy,r*0.24,0,Math.PI*2);
  fctx.fillStyle='#2a1800'; fctx.fill();

  /* Gold centre cap */
  fctx.beginPath(); fctx.arc(cx,cy,r*0.20,0,Math.PI*2);
  const capG = fctx.createRadialGradient(cx-r*0.07,cy-r*0.07,1,cx,cy,r*0.20);
  capG.addColorStop(0,'#fff8d0');
  capG.addColorStop(0.5,'#d4af5a');
  capG.addColorStop(1,'#8a5a00');
  fctx.fillStyle=capG; fctx.fill();
  fctx.strokeStyle='#5a3a00'; fctx.lineWidth=2; fctx.stroke();
}

let wheelSpinning = false;

function drawFortuneWheel(){
  const W  = fortuneCanvas.width;
  const H  = fortuneCanvas.height;
  const cx = W/2, cy = H/2;
  const r  = W/2 - 6;
  fctx.clearRect(0,0,W,H);

  /* Outer decorative rim */
  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.fillStyle='#4a3010'; fctx.fill();
  fctx.beginPath(); fctx.arc(cx,cy,r+6,0,Math.PI*2);
  fctx.strokeStyle='rgba(200,160,60,0.5)'; fctx.lineWidth=2; fctx.stroke();

  /* Tick marks on rim */
  for(let t=0;t<24;t++){
    const ta=fAngle+t*(Math.PI*2/24);
    const x1=cx+Math.cos(ta)*(r+2), y1=cy+Math.sin(ta)*(r+2);
    const x2=cx+Math.cos(ta)*(r+5), y2=cy+Math.sin(ta)*(r+5);
    fctx.beginPath(); fctx.moveTo(x1,y1); fctx.lineTo(x2,y2);
    fctx.strokeStyle='rgba(255,215,0,0.6)'; fctx.lineWidth=1.5; fctx.stroke();
  }

  /* Segments */
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
    /* Segment border */
    fctx.strokeStyle='rgba(0,0,0,0.3)';
    fctx.lineWidth=1.5;
    fctx.stroke();
    /* Label */
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

  /* Inner separator ring */
  fctx.beginPath(); fctx.arc(cx,cy,r*0.24,0,Math.PI*2);
  fctx.fillStyle='#2a1800'; fctx.fill();

  /* Gold centre cap */
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
    fAngle -= 0.010; /* slow decorative spin */
  }
  drawFortuneWheel();
  requestAnimationFrame(animateFortune);
})();

async function spinFortuneWheelBonus() {
  wheelSpinning = true;
  const targetIdx = Math.floor(Math.random() * F_SEGS.length);
  const targetSeg = F_SEGS[targetIdx];
  
  // speed up
  let speed = 0.05;
  for (let i = 0; i < 30; i++) {
    speed = Math.min(0.35, speed + 0.015);
    fAngle -= speed;
    await sleep(16);
  }
  
  // spin high speed
  for (let i = 0; i < 50; i++) {
    fAngle -= speed;
    if (i % 5 === 0) beep(500, 0.03, 'sine', 0.05);
    await sleep(16);
  }
  
  // slow down and align
  const segA = (Math.PI * 2) / F_SEGS.length;
  const finalAngle = -Math.PI / 2 - (targetIdx + 0.5) * segA;
  
  let currentAngle = fAngle % (Math.PI * 2);
  let destAngle = finalAngle;
  while (destAngle > currentAngle) destAngle -= Math.PI * 2;
  destAngle -= Math.PI * 4; // spin at least 2 more full rotations
  
  const steps = 70;
  for (let i = 0; i <= steps; i++) {
    const t = i / steps;
    const ease = 1 - Math.pow(1 - t, 3);
    fAngle = currentAngle + (destAngle - currentAngle) * ease;
    if (i < steps - 8 && i % Math.max(1, Math.floor(12 * (1 - t))) === 0) {
      beep(420, 0.03, 'sine', 0.03);
    }
    await sleep(16);
  }
  
  fAngle = destAngle; // force exact segment stop
  wheelSpinning = false;
  
  return parseInt(targetSeg.v) || 1;
}

/* ══════════════════════════════════════════════
   SPIN LOGIC
══════════════════════════════════════════════ */
async function doSpin(){
  if(spinning) return;
  if(balance < bet){ flashRibbon('⚠ Insufficient balance'); return; }

  spinning = true;
  spinBtn.classList.add('spinning');
  resetWheel(); // clear highlight from previous spin
  winAmt   = 0;
  balance -= bet;
  refreshStats();
  if(!isDemoMode) syncBalance(balance);

  beep(200, 0.06, 'sawtooth', 0.05);

  // 1. Determine right multiplier column target stop value for this play
  const isWheelTrigger = Math.random() < 0.16; // 16% chance to land bonus wheel symbol
  const targetMultVal = isWheelTrigger ? 'wheelx' : ['1x','2x','3x','5x','10x'][Math.floor(Math.random() * 5)];

  // Start multiplier column dynamic scroll animation immediately
  const multSpinPromise = animateMultiplierColumnSpin(targetMultVal);

  // Build next grid
  const nextGrid = [];
  for(let c=0;c<COLS;c++){
    nextGrid.push([]);
    for(let r=0;r<ROWS;r++) nextGrid[c].push(weightedRandom());
  }

  const spinDur  = turbo ? 320 : 880;
  const colDelay = turbo ? 60  : 155;

  // Animate columns (scroll down, reveal new symbols)
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

  // Wait for both main reels and right multiplier column to stop spinning
  await Promise.all([
    sleep(spinDur + colDelay * (COLS - 1) + 120),
    multSpinPromise
  ]);
  grid = nextGrid;

  // ── Check wins (3 matching symbols in a row) ──
  const winCells = [];
  let totalWin   = 0;
  for(let r=0; r<ROWS; r++){
    const s0 = grid[0][r];
    if(grid[1][r].id===s0.id && grid[2][r].id===s0.id){
      winCells.push([0,r],[1,r],[2,r]);
      totalWin += s0.pay * bet;
    }
  }

  // ── Process Multiplier / Wheel Payout ──
  let finalWin = 0;
  let multiplierApplied = 1;

  if (targetMultVal === 'wheelx') {
    multActiveFrame.classList.add('lit'); // highlight gold active frame
    flashRibbon('🎡 BONUS WHEEL TRIGGERED!');
    await sleep(600);
    
    // Spin the giant fortune wheel on the left
    const wheelMult = await spinFortuneWheelBonus();
    multiplierApplied = wheelMult;
    
    // Win is (totalWin or bet size) multiplied by wheel
    const baseWin = totalWin > 0 ? totalWin : bet;
    finalWin = baseWin * wheelMult;
    await sleep(600);
  } else if (totalWin > 0) {
    multiplierApplied = parseInt(targetMultVal) || 1;
    multActiveFrame.classList.add('lit'); // highlight active multiplier gold frame
    finalWin = totalWin * multiplierApplied;
  }

  if(winCells.length || finalWin > 0){
    startFieryWin(winCells); // Trigger the powerful rising flame particle animations
    drawGrid(grid, [0,0,0], winCells);
    beep(680, 0.12, 'sine', 0.07);
    setTimeout(() => beep(900, 0.14, 'sine', 0.06), 130);
  }

  if(finalWin > 0){
    balance += finalWin;
    winAmt   = finalWin;
    winTxt.textContent = '+' + fmt(finalWin) + (multiplierApplied > 1 ? '  (' + multiplierApplied + '×)' : '');
    winBanner.classList.add('show');
    flashRibbon(multiplierApplied > 1 ? `🎉 Bonus wheel ×${multiplierApplied} — big win!` : '🏆 Winning line!');
    setTimeout(() => winBanner.classList.remove('show'), 1700);
    if(!isDemoMode) syncBalance(balance);
  } else {
    flashRibbon('No win — try again!');
  }

  refreshStats();
  spinBtn.classList.remove('spinning');
  spinning = false;

  if(autoplay){
    if(balance >= bet) setTimeout(doSpin, 650);
    else { autoplay=false; autoToggle.classList.remove('active'); flashRibbon('Autoplay stopped — low balance'); }
  }
}

/* ══════════════════════════════════════════════
   BUTTON EVENTS
══════════════════════════════════════════════ */
spinBtn.onclick     = () => { if(!spinning) doSpin(); };
autoToggle.onclick  = () => {
  autoplay = !autoplay;
  autoToggle.classList.toggle('active', autoplay);
  if(autoplay && !spinning) doSpin();
};
turboToggle.onclick = () => {
  turbo = !turbo;
  turboToggle.classList.toggle('active', turbo);
};

/* Real/Demo toggle */
if(realMoneyToggle){
  realMoneyToggle.checked = !isDemoMode;
  realMoneyToggle.onchange = function(){
    if(spinning||autoplay){ realMoneyToggle.checked=!isDemoMode; return; }
    isDemoMode = !realMoneyToggle.checked;
    balance    = isDemoMode ? demoBalance : realBalance;
    refreshStats();
    flashRibbon(isDemoMode ? '🎰 Demo Mode' : '💰 Real Play Mode');
  };
}

/* Keyboard: Space = spin */
window.addEventListener('keydown', e => {
  if(e.code==='Space'){ e.preventDefault(); if(!spinning) doSpin(); }
});

/* ══════════════════════════════════════════════
   WINNING FIRE EFFECT SYSTEM
══════════════════════════════════════════════ */
const fireCanvas = $('fireCanvas');
const fireCtx = fireCanvas.getContext('2d');
let particles = [];
let fireAnimationId = null;

class FireParticle {
  constructor(x, y) {
    this.x = x;
    this.y = y;
    // Spreads outwards slightly, rises rapidly
    this.vx = (Math.random() - 0.5) * 5.5;
    this.vy = -Math.random() * 6 - 3;
    this.size = Math.random() * 26 + 12;
    this.alpha = 1.0;
    this.decay = Math.random() * 0.025 + 0.015;
    
    // Rich gradient fire colors: red, orange, gold, yellow, white
    const colors = ['#ff2a00', '#ff7a00', '#ffb300', '#ffd700', '#ffffff'];
    this.color = colors[Math.floor(Math.random() * colors.length)];
  }

  update() {
    this.x += this.vx;
    this.y += this.vy;
    this.size = Math.max(0.1, this.size - 0.35);
    this.alpha -= this.decay;
  }

  draw(ctx) {
    ctx.save();
    ctx.globalAlpha = this.alpha;
    ctx.shadowBlur = this.size * 0.8;
    ctx.shadowColor = this.color;
    ctx.fillStyle = this.color;
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.size / 2, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
  }
}

function startFieryWin(winCells) {
  let spawnCount = 0;
  const interval = setInterval(() => {
    const dpr = window.devicePixelRatio || 1;
    // Match the square reelsCanvas dimensions
    fireCanvas.width  = canvasW * dpr;
    fireCanvas.height = canvasH * dpr;
    fireCtx.setTransform(dpr, 0, 0, dpr, 0, 0);

    winCells.forEach(([col, row]) => {
      const centerX = col * cellW + cellW / 2;
      const centerY = row * cellH + cellH / 2;
      
      // Spawn hot fire particles at cell center
      for (let i = 0; i < 9; i++) {
        particles.push(new FireParticle(centerX, centerY));
      }
    });

    if (!fireAnimationId) {
      animateParticles();
    }

    spawnCount++;
    if (spawnCount > 28) { // Keep spawning for ~560ms
      clearInterval(interval);
    }
  }, 20);
}

function animateParticles() {
  if (particles.length === 0) {
    fireCtx.clearRect(0, 0, fireCanvas.width, fireCanvas.height);
    fireAnimationId = null;
    return;
  }

  const W = fireCanvas.width;
  const H = fireCanvas.height;
  fireCtx.clearRect(0, 0, W, H);

  // Update and draw each particle
  particles.forEach((p, idx) => {
    p.update();
    p.draw(fireCtx);
    if (p.alpha <= 0 || p.size <= 0.6) {
      particles.splice(idx, 1);
    }
  });

  fireAnimationId = requestAnimationFrame(animateParticles);
}

/* ══════════════════════════════════════════════
   INIT / RESIZE
══════════════════════════════════════════════ */
window.addEventListener('resize', () => { sizeCanvas(); });
sizeCanvas();

})();
</script>
</body>
</html>
