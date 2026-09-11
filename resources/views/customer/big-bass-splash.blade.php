<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Big Bass Splash™ | 1xBet Casino</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,400;0,600;0,700;1,700&family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-bg: #031427;
            --water-surface: #0a4b78;
            --water-deep: #021a36;
            --ocean-blue: #0088cc;
            --gold-glow: #ffd700;
            --gold-gradient: linear-gradient(135deg, #ffe066 0%, #f59e0b 50%, #d97706 100%);
            --coral-orange: #ff5e36;
            --card-glass: rgba(6, 32, 60, 0.75);
            --border-glass: rgba(0, 212, 255, 0.25);
            --neon-blue: #00e5ff;
            --cell-bg: rgba(2, 22, 46, 0.85);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body {
            background-color: var(--primary-bg);
            background-image: radial-gradient(circle at 50% 10%, #0d4b75 0%, #031427 85%);
            font-family: 'Montserrat', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* ── BRANDED GAME PRELOADER ── */
        #game-preloader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #0a3d62 0%, #031427 100%);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #game-preloader.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .preloader-box {
            text-align: center;
            max-width: 420px;
            width: 90%;
            padding: 30px;
            background: rgba(4, 25, 48, 0.85);
            border: 2px solid rgba(0, 229, 255, 0.35);
            border-radius: 20px;
            box-shadow: 0 0 50px rgba(0, 229, 255, 0.2), inset 0 0 20px rgba(0, 229, 255, 0.1);
            backdrop-filter: blur(12px);
        }
        .preloader-logo {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            background: linear-gradient(180deg, #fff 0%, #ffe066 40%, #f59e0b 80%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .preloader-subtitle {
            font-family: 'Chakra Petch', sans-serif;
            color: #38bdf8;
            font-size: 13px;
            letter-spacing: 4px;
            font-weight: 700;
            margin-bottom: 25px;
        }
        .preloader-animation {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .preloader-fish-icon {
            font-size: 44px;
            color: #38bdf8;
            animation: swimUpDown 2s infinite ease-in-out;
            filter: drop-shadow(0 0 15px rgba(56, 189, 248, 0.8));
        }
        .preloader-hook-icon {
            position: absolute;
            top: -10px;
            right: 15px;
            font-size: 26px;
            color: #ffd700;
            animation: hookBob 2s infinite ease-in-out;
        }
        @keyframes swimUpDown {
            0%, 100% { transform: translateY(0) rotate(-4deg); }
            50% { transform: translateY(-12px) rotate(4deg); }
        }
        @keyframes hookBob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }
        .preloader-bar-bg {
            width: 100%;
            height: 10px;
            background: rgba(2, 14, 28, 0.9);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(0, 229, 255, 0.3);
            margin-bottom: 12px;
        }
        .preloader-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #00e5ff, #38bdf8, #f59e0b, #ffd700);
            border-radius: 10px;
            transition: width 0.2s ease;
            box-shadow: 0 0 10px #00e5ff;
        }
        .preloader-status {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
        }

        /* ── 1XBET TOP NAVIGATION ── */
        .header-nav {
            width: 100%;
            background: linear-gradient(180deg, #041933 0%, #031427 100%);
            border-bottom: 1px solid rgba(0, 229, 255, 0.15);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-1xbet {
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -0.5px;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 2px;
        }
        .brand-1xbet .x-badge {
            background: #0088cc;
            color: #fff;
            padding: 0 4px;
            border-radius: 3px;
        }
        .game-badge-title {
            background: rgba(0, 229, 255, 0.12);
            border: 1px solid rgba(0, 229, 255, 0.3);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            color: #38bdf8;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .balance-chip {
            background: rgba(2, 22, 46, 0.9);
            border: 1px solid rgba(255, 215, 0, 0.4);
            border-radius: 8px;
            padding: 5px 12px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .balance-chip .bal-label {
            font-size: 9px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
        }
        .balance-chip .bal-val {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #ffd700;
        }
        .header-btn {
            background: rgba(14, 165, 233, 0.15);
            border: 1px solid rgba(14, 165, 233, 0.3);
            color: #38bdf8;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        .header-btn:hover {
            background: rgba(14, 165, 233, 0.3);
            color: #fff;
            border-color: #38bdf8;
        }
        .btn-deposit-gold {
            background: var(--gold-gradient);
            color: #000;
            font-weight: 800;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
            transition: transform 0.15s ease;
            text-decoration: none;
        }
        .btn-deposit-gold:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.6);
        }

        /* ── MAIN GAME WRAPPER ── */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            position: relative;
        }

        /* Underwater Background bubbles */
        .bubbles-container {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }
        .bubble {
            position: absolute;
            bottom: -30px;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4), rgba(0, 229, 255, 0.1) 60%, rgba(255, 255, 255, 0));
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: riseUp linear infinite;
        }
        @keyframes riseUp {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-110vh) scale(1.3); opacity: 0; }
        }

        /* ── GAME CONSOLE (1XBET STYLE VIEWPORT) ── */
        .game-console {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1080px;
            background: linear-gradient(180deg, rgba(8, 38, 70, 0.9) 0%, rgba(3, 18, 36, 0.95) 100%);
            border: 2px solid rgba(0, 229, 255, 0.35);
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7), 0 0 30px rgba(0, 136, 204, 0.2);
            overflow: hidden;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
        }

        /* Console Banner / Top Ribbon */
        .console-header {
            background: linear-gradient(90deg, rgba(2, 22, 46, 0.9) 0%, rgba(6, 46, 84, 0.9) 50%, rgba(2, 22, 46, 0.9) 100%);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
        }
        .game-branding {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .game-title-text {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            background: linear-gradient(180deg, #ffffff 0%, #ffe066 50%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
        }
        .game-tag-line {
            font-size: 10px;
            color: #38bdf8;
            font-weight: 700;
            background: rgba(56, 189, 248, 0.15);
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }

        /* Mode Switcher Pill */
        .mode-switcher {
            display: flex;
            align-items: center;
            background: rgba(2, 16, 32, 0.85);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 2px;
            gap: 2px;
        }
        .mode-btn {
            border: none;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #94a3b8;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .mode-btn.active.real {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }
        .mode-btn.active.demo {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
        }

        /* ── SLOTS SCREEN AREA (5x3 GRID + BUY BONUS) ── */
        .slot-viewport-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 12px;
            gap: 16px;
            position: relative;
            background: radial-gradient(circle at 50% 30%, rgba(10, 60, 100, 0.5) 0%, rgba(2, 14, 28, 0.8) 100%);
        }

        /* Buy Free Spins Feature Banner on Left */
        .buy-bonus-card {
            width: 130px;
            flex-shrink: 0;
            background: linear-gradient(145deg, #991b1b 0%, #b91c1c 40%, #7f1d1d 100%);
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5), inset 0 0 15px rgba(251, 191, 36, 0.3);
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .buy-bonus-card:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 0 25px rgba(220, 38, 38, 0.8), 0 0 15px #fbbf24;
        }
        .buy-bonus-card:active {
            transform: scale(0.98);
        }
        .bonus-title {
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            font-weight: 900;
            color: #fef08a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .bonus-mult {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            background: rgba(0, 0, 0, 0.35);
            padding: 2px 8px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bonus-cost-val {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #ffd700;
        }

        /* 5x3 Grid Box */
        .slot-grid-frame {
            flex: 1;
            max-width: 780px;
            background: rgba(1, 15, 30, 0.92);
            border: 2px solid rgba(0, 229, 255, 0.4);
            border-radius: 14px;
            padding: 10px;
            box-shadow: inset 0 0 25px rgba(0, 0, 0, 0.9), 0 0 15px rgba(0, 229, 255, 0.15);
            position: relative;
        }

        /* Underwater Grid Background Elements */
        .slot-reels-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            position: relative;
            z-index: 5;
        }

        /* Single Slot Cell (5x3) */
        .slot-cell {
            aspect-ratio: 1 / 0.95;
            background: linear-gradient(180deg, rgba(7, 33, 62, 0.8) 0%, rgba(3, 19, 39, 0.95) 100%);
            border: 1.5px solid rgba(0, 229, 255, 0.2);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .symbol-inner-wrapper {
            width: 78%;
            height: 78%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .symbol-svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.6));
            transition: transform 0.2s ease;
        }

        /* Cash Tag Badge for Fish Money Symbols */
        .fish-cash-tag {
            position: absolute;
            bottom: 4px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            font-family: 'Chakra Petch', sans-serif;
            font-weight: 800;
            font-size: 11px;
            padding: 1px 6px;
            border-radius: 10px;
            border: 1px solid #34d399;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.7);
            z-index: 10;
            display: none;
            letter-spacing: 0.5px;
        }

        /* Reel Blur Animation */
        .reel-spinning-blur {
            filter: blur(5px);
            transform: scale(0.96);
            opacity: 0.85;
        }

        /* Fisherman Hook Animation */
        .fish-hooked {
            animation: hookPullEffect 0.5s ease-in-out infinite alternate !important;
            border-color: #00f2fe !important;
            box-shadow: 0 0 20px #00f2fe, inset 0 0 12px #4facfe !important;
        }
        @keyframes hookPullEffect {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-8px) scale(1.06); }
        }

        /* Winner Symbol Glow */
        .win-glow {
            border-color: #ffd700 !important;
            box-shadow: 0 0 20px #ffd700, inset 0 0 10px rgba(255, 215, 0, 0.3) !important;
            transform: scale(1.03);
            z-index: 12;
            animation: pulseGlow 0.8s infinite alternate;
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 15px #ffd700; }
            100% { box-shadow: 0 0 30px #f59e0b, 0 0 10px #fff; }
        }

        /* Floating Big Win / Splash Banner Overlay */
        .win-overlay-popup {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.5);
            background: linear-gradient(135deg, rgba(4, 25, 48, 0.95) 0%, rgba(2, 14, 28, 0.98) 100%);
            border: 3px solid #ffd700;
            border-radius: 16px;
            padding: 16px 28px;
            text-align: center;
            box-shadow: 0 0 50px rgba(255, 215, 0, 0.6), inset 0 0 25px rgba(255, 215, 0, 0.3);
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .win-overlay-popup.active {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
            pointer-events: auto;
        }
        .win-popup-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 900;
            text-transform: uppercase;
            color: #ffd700;
            letter-spacing: 2px;
            text-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
        }
        .win-popup-amount {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: #fff;
            margin: 4px 0;
            text-shadow: 0 0 20px #00e5ff;
        }
        .win-popup-sub {
            font-size: 11px;
            color: #38bdf8;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* ── BOTTOM DASHBOARD / CONTROLS ── */
        .console-footer {
            background: linear-gradient(180deg, #041b36 0%, #021124 100%);
            border-top: 1px solid rgba(0, 229, 255, 0.2);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Status & Win Display on Footer */
        .info-pill-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .status-badge {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #38bdf8;
            background: rgba(2, 22, 46, 0.8);
            border: 1px solid rgba(0, 229, 255, 0.25);
            padding: 6px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        /* Bet Adjuster & Spin Section */
        .controls-action-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .bet-control-box {
            display: flex;
            align-items: center;
            background: rgba(2, 22, 46, 0.9);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 10px;
            padding: 3px;
        }
        .btn-bet-step {
            background: rgba(14, 165, 233, 0.15);
            border: 1px solid rgba(14, 165, 233, 0.3);
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-bet-step:hover {
            background: rgba(14, 165, 233, 0.35);
            color: #38bdf8;
        }
        .bet-input-display {
            width: 70px;
            text-align: center;
            font-family: 'Chakra Petch', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #ffd700;
            background: transparent;
            border: none;
            outline: none;
        }

        /* Main Spin Button */
        .btn-spin-master {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #00e5ff 0%, #0088cc 60%, #004c80 100%);
            border: 3px solid #fff;
            color: #fff;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 25px rgba(0, 229, 255, 0.6), inset 0 0 10px rgba(255, 255, 255, 0.5);
            transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.15s ease;
        }
        .btn-spin-master:hover:not(:disabled) {
            transform: scale(1.08);
            box-shadow: 0 0 35px rgba(0, 229, 255, 0.9), inset 0 0 15px #fff;
        }
        .btn-spin-master:active:not(:disabled) {
            transform: scale(0.94);
        }
        .btn-spin-master:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(0.8);
        }
        .btn-spin-master.spinning i {
            animation: spinRotate 0.8s linear infinite;
        }
        @keyframes spinRotate {
            100% { transform: rotate(360deg); }
        }

        /* ── DEPOSIT POPUP LOCK MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-backdrop.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-deposit-card {
            max-width: 440px;
            width: 100%;
            background: linear-gradient(180deg, #072242 0%, #021124 100%);
            border: 2px solid #ffd700;
            border-radius: 20px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 0 50px rgba(255, 215, 0, 0.4), inset 0 0 20px rgba(255, 215, 0, 0.2);
            transform: scale(0.85);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-backdrop.show .modal-deposit-card {
            transform: scale(1);
        }
        .modal-gold-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 215, 0, 0.15);
            border: 2px solid #ffd700;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #ffd700;
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.5);
        }
        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 900;
            color: #fff;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .modal-desc {
            font-size: 13px;
            color: #cbd5e1;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .modal-btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .modal-btn-deposit {
            background: var(--gold-gradient);
            color: #000;
            font-weight: 800;
            font-size: 14px;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            display: block;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
            transition: transform 0.15s ease;
        }
        .modal-btn-deposit:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.8);
        }
        .modal-btn-close {
            background: rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-weight: 700;
            font-size: 12px;
            padding: 8px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .modal-btn-close:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
        }

        /* ── RESPONSIVENESS (MOBILE / TABLETS) ── */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 8px;
            }
            .slot-viewport-container {
                flex-direction: column;
                padding: 10px 8px;
                gap: 10px;
            }
            .buy-bonus-card {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                padding: 8px 14px;
            }
            .bonus-title { font-size: 11px; }
            .bonus-mult { font-size: 13px; }
            .bonus-cost-val { font-size: 12px; }
            .slot-reels-grid { gap: 4px; }
            .slot-cell { border-radius: 6px; }
            .fish-cash-tag { font-size: 9px; padding: 1px 4px; bottom: 2px; }
            .console-footer {
                justify-content: center;
                gap: 8px;
            }
            .info-pill-box {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>

    @include('customer.header')

    <!-- ── BRANDED PRELOADER ── -->
    <div id="game-preloader">
        <div class="preloader-box">
            <div class="preloader-animation">
                <i class="fas fa-fish preloader-fish-icon"></i>
                <i class="fas fa-anchor preloader-hook-icon"></i>
            </div>
            <h1 class="preloader-logo">Big Bass Splash</h1>
            <div class="preloader-subtitle">PRAGMATIC PLAY / 1XBET</div>
            <div class="preloader-bar-bg">
                <div class="preloader-bar-fill" id="preloader-fill"></div>
            </div>
            <div class="preloader-status" id="preloader-status-text">লোডিং হচ্ছে... ০%</div>
        </div>
    </div>

    <!-- ── 1XBET HEADER NAVIGATION ── -->
    <header class="header-nav">
        <div class="nav-left">
            <a href="{{ route('home') }}" class="brand-1xbet">
                1<span class="x-badge">X</span>BET
            </a>
            <div class="game-badge-title">
                <i class="fas fa-water"></i> Big Bass Splash™
            </div>
        </div>
        <div class="nav-right">
            <div class="balance-chip">
                <span class="bal-label">Wallet Balance</span>
                <span class="bal-val" id="top-balance-display">৳ {{ number_format(auth()->user()->balance ?? 0.00, 2) }}</span>
            </div>
            <a href="{{ route('dashboard.deposit') }}" class="btn-deposit-gold">
                <i class="fas fa-wallet"></i> DEPOSIT
            </a>
            <button class="header-btn" id="btn-sound-toggle" title="Sound Toggle">
                <i class="fas fa-volume-up" id="sound-icon"></i>
            </button>
            <button class="header-btn" id="btn-fullscreen" title="Fullscreen">
                <i class="fas fa-expand"></i>
            </button>
        </div>
    </header>

    <!-- ── MAIN GAME VIEWPORT ── -->
    <main class="main-wrapper">
        <!-- Floating underwater bubbles -->
        <div class="bubbles-container" id="bubbles-wrapper"></div>

        <div class="game-console">
            <!-- Console Header -->
            <div class="console-header">
                <div class="game-branding">
                    <span class="game-title-text">Big Bass Splash</span>
                    <span class="game-tag-line">5x3 • 10 LINES</span>
                </div>
                
                <!-- Real / Demo Mode Switcher -->
                <div class="mode-switcher">
                    <button class="mode-btn active real" id="btn-mode-real" onclick="switchGameMode(false)">
                        <i class="fas fa-coins"></i> REAL MONEY
                    </button>
                    <button class="mode-btn demo" id="btn-mode-demo" onclick="switchGameMode(true)">
                        <i class="fas fa-gamepad"></i> DEMO (3 FREE)
                    </button>
                </div>
            </div>

            <!-- Slots Grid & Bonus Trigger -->
            <div class="slot-viewport-container">
                <!-- Buy Free Spins Card -->
                <div class="buy-bonus-card" id="btn-buy-bonus" onclick="triggerSpin(true)" title="Buy Free Spins Feature for 100x Bet">
                    <i class="fas fa-bolt" style="font-size:20px; color:#fef08a;"></i>
                    <div class="bonus-title">BUY FREE SPINS</div>
                    <div class="bonus-mult">100X</div>
                    <div class="bonus-cost-val" id="bonus-cost-label">৳ 200.00</div>
                </div>

                <!-- 5x3 Reels Grid Frame -->
                <div class="slot-grid-frame">
                    <!-- Win Celebration Banner Overlay -->
                    <div class="win-overlay-popup" id="win-celebration-box">
                        <div class="win-popup-title" id="win-banner-title">BIG SPLASH WIN!</div>
                        <div class="win-popup-amount" id="win-banner-amount">৳ 0.00</div>
                        <div class="win-popup-sub" id="win-banner-sub">FISHERMAN COLLECTED!</div>
                    </div>

                    <div class="slot-reels-grid" id="slots-matrix-grid">
                        <!-- 5x3 Cells will be rendered here dynamically -->
                    </div>
                </div>
            </div>

            <!-- Console Controls Footer -->
            <div class="console-footer">
                <div class="info-pill-box">
                    <div class="status-badge">
                        <span class="dot"></span>
                        <span id="game-status-label">READY TO CAST</span>
                    </div>
                    <div class="status-badge" style="color:#ffd700; border-color:rgba(255, 215, 0, 0.3);">
                        <span>WIN: </span>
                        <strong id="last-win-label" style="font-family:'Chakra Petch', sans-serif; margin-left:4px;">৳ 0.00</strong>
                    </div>
                </div>

                <div class="controls-action-group">
                    <div class="bet-control-box">
                        <button class="btn-bet-step" onclick="changeBet(-1)">-</button>
                        <input type="text" class="bet-input-display" id="bet-amount-input" value="2.00" readonly>
                        <button class="btn-bet-step" onclick="changeBet(1)">+</button>
                    </div>

                    <button class="btn-spin-master" id="btn-main-spin" onclick="triggerSpin(false)" title="Spin Reel">
                        <i class="fas fa-rotate"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- ── DEPOSIT POPUP LOCK MODAL (DEMO LIMIT OVER) ── -->
    <div class="modal-backdrop" id="deposit-popup-modal">
        <div class="modal-deposit-card">
            <div class="modal-gold-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="modal-title">ডেমো লিমিট শেষ!</h2>
            <p class="modal-desc">
                আপনি আপনার নির্ধারিত ৩টি ফ্রি ডেমো স্পিন শেষ করেছেন। আসল ক্যাশ জিতে Fisherman Hook Collect উপভোগ করতে এখনই ডিপোজিট করুন!
            </p>
            <div class="modal-btn-group">
                <a href="{{ route('dashboard.deposit') }}" class="modal-btn-deposit">
                    <i class="fas fa-money-bill-wave"></i> ডিপোজিট করে আসল টাকা খেলুন
                </a>
                <button class="modal-btn-close" onclick="closeDepositModal()">
                    বন্ধ করুন
                </button>
            </div>
        </div>
    </div>

    <!-- ── AUDIO ASSETS (WITH SYNTHESIS FALLBACK) ── -->
    <audio id="snd-spin" preload="auto" src="{{ $settings->spin_sound ? asset('storage/'.$settings->spin_sound) : '' }}"></audio>
    <audio id="snd-win" preload="auto" src="{{ $settings->win_sound ? asset('storage/'.$settings->win_sound) : '' }}"></audio>
    <audio id="snd-splash" preload="auto" src="{{ $settings->reel_splash_sound ? asset('storage/'.$settings->reel_splash_sound) : '' }}"></audio>
    <audio id="snd-hook" preload="auto" src="{{ $settings->fisherman_hook_sound ? asset('storage/'.$settings->fisherman_hook_sound) : '' }}"></audio>

    <script>
        /* ══════════════════════════════════════════
           GAME STATE & CONFIGURATION
        ══════════════════════════════════════════ */
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const SPIN_ENDPOINT = "{{ route('bigbass.spin') }}";
        
        let isDemoMode = false;
        let demoSpinsCount = 0;
        const DEMO_MAX_SPINS = {{ $settings->demo_spin_limit ?? 3 }};
        let demoBalance = {{ (float)($settings->demo_default_balance ?? 10000.00) }};
        let realBalance = {{ (float)(auth()->user()->balance ?? 0.00) }};
        
        let betAmounts = [2.00, 5.00, 10.00, 20.00, 50.00, 100.00, 250.00, 500.00, 1000.00];
        let currentBetIndex = 0;
        let isSpinning = false;
        let soundEnabled = true;

        /* SVG Symbol Library for Big Bass Splash */
        const SYMBOL_SVGS = {
            'TRUCK': `<svg viewBox="0 0 100 100" class="symbol-svg"><rect x="15" y="40" width="70" height="30" rx="6" fill="#ef4444"/><rect x="45" y="20" width="40" height="25" rx="4" fill="#dc2626"/><circle cx="30" cy="72" r="14" fill="#18181b" stroke="#f59e0b" stroke-width="4"/><circle cx="70" cy="72" r="14" fill="#18181b" stroke="#f59e0b" stroke-width="4"/><rect x="52" y="25" width="16" height="15" rx="2" fill="#67e8f9"/></svg>`,
            'FISHING_ROD': `<svg viewBox="0 0 100 100" class="symbol-svg"><line x1="85" y1="15" x2="20" y2="85" stroke="#f59e0b" stroke-width="6" stroke-linecap="round"/><circle cx="28" cy="75" r="9" fill="#0284c7" stroke="#fff" stroke-width="2"/><path d="M85 15 Q 60 50 45 70" fill="none" stroke="#38bdf8" stroke-width="2" stroke-dasharray="3,3"/></svg>`,
            'DRAGONFLY': `<svg viewBox="0 0 100 100" class="symbol-svg"><ellipse cx="50" cy="50" rx="6" ry="25" fill="#10b981"/><ellipse cx="30" cy="40" rx="20" ry="6" fill="#38bdf8" opacity="0.8"/><ellipse cx="70" cy="40" rx="20" ry="6" fill="#38bdf8" opacity="0.8"/><ellipse cx="32" cy="55" rx="16" ry="5" fill="#38bdf8" opacity="0.7"/><ellipse cx="68" cy="55" rx="16" ry="5" fill="#38bdf8" opacity="0.7"/><circle cx="50" cy="24" r="5" fill="#047857"/></svg>`,
            'TACKLE_BOX': `<svg viewBox="0 0 100 100" class="symbol-svg"><rect x="20" y="35" width="60" height="45" rx="6" fill="#f97316" stroke="#c2410c" stroke-width="3"/><rect x="20" y="35" width="60" height="15" fill="#ea580c"/><rect x="42" y="24" width="16" height="12" rx="3" fill="#fbbf24"/><circle cx="50" cy="58" r="4" fill="#fbbf24"/></svg>`,
            'FISH_MONEY': `<svg viewBox="0 0 100 100" class="symbol-svg"><path d="M20 50 Q 40 25 75 50 Q 40 75 20 50 Z" fill="#0ea5e9" stroke="#38bdf8" stroke-width="3"/><polygon points="75,50 90,32 90,68" fill="#0284c7"/><circle cx="35" cy="45" r="4" fill="#fff"/><circle cx="34" cy="45" r="2" fill="#000"/></svg>`,
            'FISHERMAN_WILD': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="48" r="26" fill="#fbcfe8"/><path d="M20 38 Q 50 15 80 38 Z" fill="#b45309"/><ellipse cx="50" cy="38" rx="34" ry="7" fill="#d97706"/><circle cx="42" cy="46" r="3.5" fill="#0f172a"/><circle cx="58" cy="46" r="3.5" fill="#0f172a"/><path d="M35 55 Q 50 82 65 55 Z" fill="#92400e"/><rect x="30" y="70" width="40" height="24" rx="4" fill="#0369a1"/></svg>`,
            'SCATTER_BASS': `<svg viewBox="0 0 100 100" class="symbol-svg"><path d="M15 55 Q 45 15 80 45 Q 45 85 15 55 Z" fill="#22c55e" stroke="#15803d" stroke-width="3"/><polygon points="80,45 95,25 95,65" fill="#16a34a"/><rect x="10" y="72" width="80" height="18" rx="4" fill="#f59e0b" stroke="#b45309" stroke-width="2"/><text x="50" y="85" fill="#000" font-family="Montserrat" font-weight="900" font-size="11" text-anchor="middle">SCATTER</text></svg>`,
            'A': `<svg viewBox="0 0 100 100" class="symbol-svg"><text x="50" y="70" fill="#ef4444" font-family="Outfit" font-weight="900" font-size="60" text-anchor="middle" stroke="#7f1d1d" stroke-width="2">A</text></svg>`,
            'K': `<svg viewBox="0 0 100 100" class="symbol-svg"><text x="50" y="70" fill="#f59e0b" font-family="Outfit" font-weight="900" font-size="60" text-anchor="middle" stroke="#92400e" stroke-width="2">K</text></svg>`,
            'Q': `<svg viewBox="0 0 100 100" class="symbol-svg"><text x="50" y="70" fill="#eab308" font-family="Outfit" font-weight="900" font-size="60" text-anchor="middle" stroke="#854d0e" stroke-width="2">Q</text></svg>`,
            'J': `<svg viewBox="0 0 100 100" class="symbol-svg"><text x="50" y="70" fill="#3b82f6" font-family="Outfit" font-weight="900" font-size="60" text-anchor="middle" stroke="#1e3a8a" stroke-width="2">J</text></svg>`,
            '10': `<svg viewBox="0 0 100 100" class="symbol-svg"><text x="50" y="70" fill="#8b5cf6" font-family="Outfit" font-weight="900" font-size="54" text-anchor="middle" stroke="#4c1d95" stroke-width="2">10</text></svg>`
        };

        /* ══════════════════════════════════════════
           PRELOADER ANIMATION
        ══════════════════════════════════════════ */
        window.addEventListener('DOMContentLoaded', () => {
            initGrid();
            updateBetUI();
            createBubbles();

            let progress = 0;
            const fill = document.getElementById('preloader-fill');
            const statusText = document.getElementById('preloader-status-text');
            const preloader = document.getElementById('game-preloader');

            const timer = setInterval(() => {
                progress += Math.floor(Math.random() * 18) + 12;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(timer);
                    fill.style.width = '100%';
                    statusText.innerText = 'রেডি! গেম লোড সম্পন্ন ১০০%';
                    setTimeout(() => {
                        preloader.classList.add('fade-out');
                    }, 400);
                } else {
                    fill.style.width = progress + '%';
                    statusText.innerText = 'রিসোর্স লোড হচ্ছে... ' + progress + '%';
                }
            }, 80);
        });

        /* Create ambient bubbles */
        function createBubbles() {
            const container = document.getElementById('bubbles-wrapper');
            if (!container) return;
            for (let i = 0; i < 18; i++) {
                const b = document.createElement('div');
                b.className = 'bubble';
                const size = Math.random() * 20 + 8;
                b.style.width = size + 'px';
                b.style.height = size + 'px';
                b.style.left = Math.random() * 100 + '%';
                b.style.animationDuration = (Math.random() * 8 + 5) + 's';
                b.style.animationDelay = (Math.random() * 5) + 's';
                container.appendChild(b);
            }
        }

        /* Initialize 5x3 Empty Matrix */
        function initGrid() {
            const grid = document.getElementById('slots-matrix-grid');
            grid.innerHTML = '';
            const defaultSymbols = [
                ['A', 'FISH_MONEY', '10', 'TACKLE_BOX', 'K'],
                ['10', 'FISH_MONEY', 'FISH_MONEY', 'K', 'J'],
                ['TACKLE_BOX', 'TACKLE_BOX', 'FISH_MONEY', 'Q', 'FISH_MONEY']
            ];

            for (let r = 0; r < 3; r++) {
                for (let c = 0; c < 5; c++) {
                    const sym = defaultSymbols[r][c];
                    const cell = document.createElement('div');
                    cell.className = 'slot-cell';
                    cell.dataset.row = r;
                    cell.dataset.col = c;
                    
                    cell.innerHTML = `
                        <div class="symbol-inner-wrapper">
                            ${SYMBOL_SVGS[sym] || SYMBOL_SVGS['A']}
                        </div>
                        <span class="fish-cash-tag" style="${sym === 'FISH_MONEY' ? 'display:block;' : ''}">৳ 10.00</span>
                    `;
                    grid.appendChild(cell);
                }
            }
        }

        /* ══════════════════════════════════════════
           BET ADJUSTMENTS & DUAL MODE LOGIC
        ══════════════════════════════════════════ */
        function changeBet(direction) {
            if (isSpinning) return;
            currentBetIndex += direction;
            if (currentBetIndex < 0) currentBetIndex = 0;
            if (currentBetIndex >= betAmounts.length) currentBetIndex = betAmounts.length - 1;
            updateBetUI();
        }

        function updateBetUI() {
            const betVal = betAmounts[currentBetIndex];
            document.getElementById('bet-amount-input').value = betVal.toFixed(2);
            document.getElementById('bonus-cost-label').innerText = '৳ ' + (betVal * 100).toFixed(2);
        }

        function switchGameMode(demo) {
            if (isSpinning) return;
            isDemoMode = demo;
            const btnReal = document.getElementById('btn-mode-real');
            const btnDemo = document.getElementById('btn-mode-demo');
            const topBal = document.getElementById('top-balance-display');

            if (isDemoMode) {
                btnReal.classList.remove('active');
                btnDemo.classList.add('active');
                topBal.innerText = '৳ ' + demoBalance.toFixed(2) + ' (DEMO)';
                topBal.style.color = '#f59e0b';
            } else {
                btnDemo.classList.remove('active');
                btnReal.classList.add('active');
                topBal.innerText = '৳ ' + realBalance.toFixed(2);
                topBal.style.color = '#ffd700';
            }
        }

        function closeDepositModal() {
            document.getElementById('deposit-popup-modal').classList.remove('show');
        }

        /* ══════════════════════════════════════════
           SPIN TRIGGER & REEL ANIMATIONS
        ══════════════════════════════════════════ */
        function triggerSpin(isBuyBonus = false) {
            if (isSpinning) return;

            const betAmount = betAmounts[currentBetIndex];
            const charge = isBuyBonus ? (betAmount * 100) : betAmount;

            // Demo spin limit lock check
            if (isDemoMode && demoSpinsCount >= DEMO_MAX_SPINS) {
                document.getElementById('deposit-popup-modal').classList.add('show');
                return;
            }

            // Real balance check
            if (!isDemoMode && realBalance < charge) {
                alert('পর্যাপ্ত ব্যালেন্স নেই! অনুগ্রহ করে ডিপোজিট করুন।');
                return;
            }

            isSpinning = true;
            document.getElementById('btn-main-spin').classList.add('spinning');
            document.getElementById('btn-main-spin').disabled = true;
            document.getElementById('game-status-label').innerText = 'CASTING LINE...';

            // Hide previous win banner
            document.getElementById('win-celebration-box').classList.remove('active');

            // Play spin audio
            playAudioFX('spin');

            // Apply blur and random symbol shuffle
            const cells = document.querySelectorAll('.slot-cell');
            cells.forEach(c => {
                c.classList.remove('win-glow', 'fish-hooked');
                c.classList.add('reel-spinning-blur');
            });

            const keys = Object.keys(SYMBOL_SVGS);
            const shuffleInterval = setInterval(() => {
                cells.forEach(cell => {
                    const randomKey = keys[Math.floor(Math.random() * keys.length)];
                    const inner = cell.querySelector('.symbol-inner-wrapper');
                    if (inner) inner.innerHTML = SYMBOL_SVGS[randomKey];
                });
            }, 70);

            // Send AJAX spin request to Laravel Backend
            fetch(SPIN_ENDPOINT, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    bet_amount: betAmount,
                    is_demo: isDemoMode,
                    demo_spins_count: demoSpinsCount,
                    is_buy_bonus: isBuyBonus
                })
            })
            .then(res => res.json())
            .then(data => {
                setTimeout(() => {
                    clearInterval(shuffleInterval);
                    cells.forEach(c => c.classList.remove('reel-spinning-blur'));
                    document.getElementById('btn-main-spin').classList.remove('spinning');
                    document.getElementById('btn-main-spin').disabled = false;
                    isSpinning = false;

                    if (data.status === 'deposit_required') {
                        document.getElementById('deposit-popup-modal').classList.add('show');
                        document.getElementById('game-status-label').innerText = 'DEMO LIMIT EXPIRED';
                        return;
                    }

                    if (data.error) {
                        alert(data.error);
                        document.getElementById('game-status-label').innerText = 'ERROR';
                        return;
                    }

                    // Render final matrix from backend
                    renderMatrix(data.grid, data.fish_values);

                    // Hook Collect Feature
                    if (data.has_fisherman) {
                        playAudioFX('hook');
                        document.querySelectorAll('.fish-money-cell').forEach(el => {
                            el.classList.add('fish-hooked');
                        });
                        document.getElementById('game-status-label').innerText = '🎣 FISHERMAN HOOK COLLECT!';
                    }

                    // Win Display & Sound
                    if (data.is_win && data.win_amount > 0) {
                        playAudioFX('win');
                        cells.forEach(c => c.classList.add('win-glow'));
                        document.getElementById('last-win-label').innerText = '৳ ' + parseFloat(data.win_amount).toFixed(2);
                        
                        // Show celebration overlay
                        const banner = document.getElementById('win-celebration-box');
                        document.getElementById('win-banner-amount').innerText = '৳ ' + parseFloat(data.win_amount).toFixed(2);
                        document.getElementById('win-banner-title').innerText = data.has_fisherman ? '🎣 BIG HOOK COLLECT!' : 'SPLASH WIN!';
                        banner.classList.add('active');

                        setTimeout(() => {
                            banner.classList.remove('active');
                        }, 3500);
                    } else {
                        document.getElementById('last-win-label').innerText = '৳ 0.00';
                        document.getElementById('game-status-label').innerText = 'TRY AGAIN';
                    }

                    // Update balances
                    if (isDemoMode) {
                        demoSpinsCount++;
                        demoBalance = demoBalance - charge + data.win_amount;
                        document.getElementById('top-balance-display').innerText = '৳ ' + demoBalance.toFixed(2) + ' (DEMO)';
                    } else if (data.new_balance !== null && data.new_balance !== undefined) {
                        realBalance = parseFloat(data.new_balance);
                        document.getElementById('top-balance-display').innerText = '৳ ' + realBalance.toFixed(2);
                    }
                }, 1400);
            })
            .catch(err => {
                clearInterval(shuffleInterval);
                cells.forEach(c => c.classList.remove('reel-spinning-blur'));
                document.getElementById('btn-main-spin').classList.remove('spinning');
                document.getElementById('btn-main-spin').disabled = false;
                isSpinning = false;
                console.error('Spin error:', err);
                document.getElementById('game-status-label').innerText = 'CONNECTION ERROR';
            });
        }

        /* Render 5x3 Grid from Response */
        function renderMatrix(matrix, fishValues) {
            for (let r = 0; r < 3; r++) {
                for (let c = 0; c < 5; c++) {
                    const cell = document.querySelector(`.slot-cell[data-row="${r}"][data-col="${c}"]`);
                    if (cell) {
                        const sym = matrix[r][c];
                        const inner = cell.querySelector('.symbol-inner-wrapper');
                        const tag = cell.querySelector('.fish-cash-tag');

                        if (inner) inner.innerHTML = SYMBOL_SVGS[sym] || SYMBOL_SVGS['A'];

                        if (sym === 'FISH_MONEY') {
                            cell.classList.add('fish-money-cell');
                            if (tag) {
                                tag.style.display = 'block';
                                const val = fishValues ? (fishValues[`${r}_${c}`] || 0) : 0;
                                tag.innerText = '৳ ' + parseFloat(val).toFixed(2);
                            }
                        } else {
                            cell.classList.remove('fish-money-cell');
                            if (tag) tag.style.display = 'none';
                        }
                    }
                }
            }
        }

        /* ══════════════════════════════════════════
           SOUND EFFECTS (AUDIO FX + SYNTHESIS)
        ══════════════════════════════════════════ */
        function playAudioFX(type) {
            if (!soundEnabled) return;
            try {
                const audioEl = document.getElementById('snd-' + type);
                if (audioEl && audioEl.src && audioEl.src.length > 10 && !audioEl.src.endsWith('/')) {
                    audioEl.currentTime = 0;
                    audioEl.play().catch(() => synthSound(type));
                } else {
                    synthSound(type);
                }
            } catch (e) {
                synthSound(type);
            }
        }

        function synthSound(type) {
            if (!soundEnabled) return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                if (type === 'spin') {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(180, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(320, ctx.currentTime + 0.3);
                    gain.gain.setValueAtTime(0.15, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.3);
                } else if (type === 'win') {
                    [440, 554, 659, 880].forEach((freq, i) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime + i * 0.1);
                        gain.gain.setValueAtTime(0.2, ctx.currentTime + i * 0.1);
                        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + i * 0.1 + 0.4);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start(ctx.currentTime + i * 0.1);
                        osc.stop(ctx.currentTime + i * 0.1 + 0.4);
                    });
                } else if (type === 'hook') {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(600, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(120, ctx.currentTime + 0.4);
                    gain.gain.setValueAtTime(0.25, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.4);
                }
            } catch (e) {}
        }

        /* Sound Button Toggle */
        document.getElementById('btn-sound-toggle').addEventListener('click', () => {
            soundEnabled = !soundEnabled;
            const icon = document.getElementById('sound-icon');
            if (soundEnabled) {
                icon.className = 'fas fa-volume-up';
                playAudioFX('spin');
            } else {
                icon.className = 'fas fa-volume-mute';
            }
        });

        /* Fullscreen Toggle */
        document.getElementById('btn-fullscreen').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(() => {});
            } else {
                document.exitFullscreen().catch(() => {});
            }
        });
    </script>
</body>
</html>
