<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Emirate™ | 1xBet Casino</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800;900&family=Chakra+Petch:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-night: #060e1a;
            --gold-primary: #f59e0b;
            --gold-bright: #fbbf24;
            --gold-gradient: linear-gradient(135deg, #fef08a 0%, #f59e0b 50%, #b45309 100%);
            --dubai-blue: #0284c7;
            --emerald: #10b981;
            --card-glass: rgba(10, 25, 48, 0.85);
            --border-gold: rgba(245, 158, 11, 0.35);
            --cell-bg: linear-gradient(180deg, rgba(14, 30, 56, 0.9) 0%, rgba(6, 17, 34, 0.95) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body {
            background-color: var(--bg-night);
            background-image: radial-gradient(circle at 50% 15%, #0f2c4f 0%, #060e1a 80%);
            font-family: 'Outfit', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* ── BRANDED PRELOADER ── */
        #game-preloader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #122b4a 0%, #050d18 100%);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #game-preloader.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .preloader-box {
            text-align: center;
            max-width: 440px;
            width: 90%;
            padding: 32px 24px;
            background: rgba(8, 22, 42, 0.88);
            border: 2px solid rgba(245, 158, 11, 0.4);
            border-radius: 20px;
            box-shadow: 0 0 50px rgba(245, 158, 11, 0.25), inset 0 0 25px rgba(245, 158, 11, 0.1);
            backdrop-filter: blur(14px);
        }
        .preloader-logo {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 25px rgba(245, 158, 11, 0.5);
            margin-bottom: 4px;
        }
        .preloader-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 11.5px;
            color: #38bdf8;
            letter-spacing: 5px;
            font-weight: 700;
            margin-bottom: 24px;
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
        .preloader-gem-icon {
            font-size: 46px;
            color: #fbbf24;
            animation: pulseGold 1.8s infinite ease-in-out;
            filter: drop-shadow(0 0 16px rgba(251, 191, 36, 0.8));
        }
        @keyframes pulseGold {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.12) rotate(6deg); }
        }
        .preloader-bar-bg {
            width: 100%;
            height: 10px;
            background: rgba(2, 10, 20, 0.95);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(245, 158, 11, 0.3);
            margin-bottom: 12px;
        }
        .preloader-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #38bdf8, #f59e0b, #fbbf24, #ffffff);
            border-radius: 10px;
            transition: width 0.2s ease;
            box-shadow: 0 0 12px #f59e0b;
        }
        .preloader-status {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
        }

        /* ── 1XBET HEADER NAVIGATION ── */
        .header-nav {
            width: 100%;
            background: linear-gradient(180deg, #0a192f 0%, #061122 100%);
            border-bottom: 1px solid rgba(245, 158, 11, 0.2);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
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
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.35);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            color: var(--gold-bright);
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
            background: rgba(4, 15, 30, 0.9);
            border: 1px solid rgba(251, 191, 36, 0.4);
            border-radius: 8px;
            padding: 4px 12px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .balance-chip .bal-label {
            font-size: 8.5px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
        }
        .balance-chip .bal-val {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fbbf24;
        }
        .header-btn {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.25);
            color: #fbbf24;
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
            background: rgba(245, 158, 11, 0.25);
            color: #fff;
            border-color: #fbbf24;
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
            padding: 16px;
            position: relative;
        }

        /* Golden shimmer background stars */
        .star-field {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        /* ── LUXURY CONSOLE VIEWPORT ── */
        .game-console {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1060px;
            background: linear-gradient(180deg, rgba(13, 30, 56, 0.95) 0%, rgba(6, 17, 34, 0.98) 100%);
            border: 2px solid rgba(245, 158, 11, 0.4);
            border-radius: 20px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.8), 0 0 30px rgba(245, 158, 11, 0.2);
            overflow: hidden;
            backdrop-filter: blur(12px);
            display: flex;
            flex-direction: column;
        }

        /* Console Header Ribbon */
        .console-header {
            background: linear-gradient(90deg, rgba(8, 22, 42, 0.95) 0%, rgba(18, 44, 80, 0.95) 50%, rgba(8, 22, 42, 0.95) 100%);
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(245, 158, 11, 0.25);
        }
        .game-branding {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .game-title-text {
            font-family: 'Cinzel', serif;
            font-size: 19px;
            font-weight: 900;
            text-transform: uppercase;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1.5px;
            text-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
        }
        .game-tag-line {
            font-size: 10px;
            color: #fbbf24;
            font-weight: 700;
            background: rgba(245, 158, 11, 0.15);
            padding: 2px 7px;
            border-radius: 4px;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        /* Dual Mode Switcher */
        .mode-switcher {
            display: flex;
            align-items: center;
            background: rgba(3, 11, 22, 0.9);
            border: 1px solid rgba(245, 158, 11, 0.35);
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

        /* ── SLOTS VIEWPORT (5x3 GRID + PAYLINE LABELS) ── */
        .slot-viewport-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 14px;
            position: relative;
            background: radial-gradient(circle at 50% 30%, rgba(16, 44, 80, 0.45) 0%, rgba(3, 11, 24, 0.85) 100%);
        }

        /* 5x3 Grid Frame */
        .slot-grid-frame {
            width: 100%;
            max-width: 860px;
            background: rgba(4, 14, 28, 0.94);
            border: 2px solid rgba(245, 158, 11, 0.45);
            border-radius: 16px;
            padding: 12px;
            box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.9), 0 0 20px rgba(245, 158, 11, 0.2);
            position: relative;
        }

        .slot-reels-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            position: relative;
            z-index: 5;
        }

        /* Slot Cell (5x3) */
        .slot-cell {
            aspect-ratio: 1 / 0.95;
            background: var(--cell-bg);
            border: 1.5px solid rgba(245, 158, 11, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .symbol-inner-wrapper {
            width: 82%;
            height: 82%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .symbol-svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.7));
            transition: transform 0.2s ease;
        }

        /* Reel Blur on Spin */
        .reel-spinning-blur {
            filter: blur(5px);
            transform: scale(0.96);
            opacity: 0.85;
        }

        /* Payline Golden Highlight */
        .line-glow {
            border: 2px solid #fbbf24 !important;
            box-shadow: 0 0 22px #fbbf24, inset 0 0 12px #f59e0b !important;
            transform: scale(1.04);
            z-index: 12;
            animation: goldPulse 0.6s infinite alternate;
        }
        @keyframes goldPulse {
            0% { filter: brightness(1.1); }
            100% { filter: brightness(1.4); }
        }

        /* Palm Jumeirah Scatter Pulse */
        .scatter-pulse {
            border: 2px solid #00e5ff !important;
            box-shadow: 0 0 25px #00e5ff, inset 0 0 12px #0284c7 !important;
            animation: palmGlow 0.5s infinite alternate;
            z-index: 14;
        }
        @keyframes palmGlow {
            0% { transform: scale(1); filter: drop-shadow(0 0 10px #00e5ff); }
            100% { transform: scale(1.08); filter: drop-shadow(0 0 22px #38bdf8); }
        }

        /* Big Win Banner Overlay */
        .win-overlay-popup {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.5);
            background: linear-gradient(135deg, rgba(10, 24, 46, 0.96) 0%, rgba(4, 12, 24, 0.98) 100%);
            border: 3px solid #fbbf24;
            border-radius: 18px;
            padding: 20px 32px;
            text-align: center;
            box-shadow: 0 0 50px rgba(245, 158, 11, 0.6), inset 0 0 25px rgba(245, 158, 11, 0.3);
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
            font-family: 'Cinzel', serif;
            font-size: 22px;
            font-weight: 900;
            text-transform: uppercase;
            color: #fbbf24;
            letter-spacing: 2px;
            text-shadow: 0 0 15px rgba(251, 191, 36, 0.8);
        }
        .win-popup-amount {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            margin: 4px 0;
            text-shadow: 0 0 20px #f59e0b;
        }
        .win-popup-sub {
            font-size: 11.5px;
            color: #38bdf8;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* ── CONSOLE CONTROLS FOOTER ── */
        .console-footer {
            background: linear-gradient(180deg, #091a32 0%, #040e1c 100%);
            border-top: 1px solid rgba(245, 158, 11, 0.25);
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

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
            background: rgba(3, 13, 26, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.3);
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

        .controls-action-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .bet-control-box {
            display: flex;
            align-items: center;
            background: rgba(3, 13, 26, 0.9);
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 10px;
            padding: 3px;
        }
        .btn-bet-step {
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fff;
            width: 32px;
            height: 32px;
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
            background: rgba(245, 158, 11, 0.35);
            color: #fbbf24;
        }
        .bet-input-display {
            width: 75px;
            text-align: center;
            font-family: 'Chakra Petch', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fbbf24;
            background: transparent;
            border: none;
            outline: none;
        }

        /* Master Spin Button */
        .btn-spin-master {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #fef08a 0%, #f59e0b 60%, #b45309 100%);
            border: 3px solid #fff;
            color: #000;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.7), inset 0 0 10px rgba(255, 255, 255, 0.6);
            transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.15s ease;
        }
        .btn-spin-master:hover:not(:disabled) {
            transform: scale(1.08);
            box-shadow: 0 0 35px rgba(245, 158, 11, 0.9), inset 0 0 15px #fff;
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
            background: linear-gradient(180deg, #0d223f 0%, #051020 100%);
            border: 2px solid #fbbf24;
            border-radius: 20px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 0 50px rgba(245, 158, 11, 0.4), inset 0 0 20px rgba(245, 158, 11, 0.2);
            transform: scale(0.85);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-backdrop.show .modal-deposit-card {
            transform: scale(1);
        }
        .modal-gold-icon {
            width: 70px;
            height: 70px;
            background: rgba(245, 158, 11, 0.15);
            border: 2px solid #fbbf24;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #fbbf24;
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.5);
        }
        .modal-title {
            font-family: 'Cinzel', serif;
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

        /* ── RESPONSIVE STYLES ── */
        @media (max-width: 768px) {
            .main-wrapper { padding: 8px; }
            .slot-viewport-container { padding: 12px 8px; }
            .slot-reels-grid { gap: 4px; }
            .slot-cell { border-radius: 6px; }
            .console-footer { justify-content: center; gap: 8px; }
            .info-pill-box { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>

    <!-- ── BRANDED PRELOADER ── -->
    <div id="game-preloader">
        <div class="preloader-box">
            <div class="preloader-animation">
                <i class="fas fa-gem preloader-gem-icon"></i>
            </div>
            <h1 class="preloader-logo">The Emirate</h1>
            <div class="preloader-subtitle">ENDORPHINA / 1XBET</div>
            <div class="preloader-bar-bg">
                <div class="preloader-bar-fill" id="preloader-fill"></div>
            </div>
            <div class="preloader-status" id="preloader-status-text">দুবাই লাক্সারি স্লট লোডিং হচ্ছে... ০%</div>
        </div>
    </div>

    <!-- ── 1XBET HEADER NAVIGATION ── -->
    <header class="header-nav">
        <div class="nav-left">
            <a href="{{ route('home') }}" class="brand-1xbet">
                1<span class="x-badge">X</span>BET
            </a>
            <div class="game-badge-title">
                <i class="fas fa-gem"></i> The Emirate™
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
        <div class="game-console">
            <!-- Console Header -->
            <div class="console-header">
                <div class="game-branding">
                    <span class="game-title-text">The Emirate</span>
                    <span class="game-tag-line">5x3 • 5 LINES</span>
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

            <!-- 5x3 Reels Grid -->
            <div class="slot-viewport-container">
                <div class="slot-grid-frame">
                    <!-- Win Banner Overlay -->
                    <div class="win-overlay-popup" id="win-celebration-box">
                        <div class="win-popup-title" id="win-banner-title">EMIRATE BIG WIN!</div>
                        <div class="win-popup-amount" id="win-banner-amount">৳ 0.00</div>
                        <div class="win-popup-sub" id="win-banner-sub">5 PAYLINES MATCH!</div>
                    </div>

                    <div class="slot-reels-grid" id="slots-matrix-grid">
                        <!-- 5x3 Cells Rendered Dynamically -->
                    </div>
                </div>
            </div>

            <!-- Console Controls Footer -->
            <div class="console-footer">
                <div class="info-pill-box">
                    <div class="status-badge">
                        <span class="dot"></span>
                        <span id="game-status-label">PLACE YOUR BET</span>
                    </div>
                    <div class="status-badge" style="color:#fbbf24; border-color:rgba(245, 158, 11, 0.35);">
                        <span>WIN: </span>
                        <strong id="last-win-label" style="font-family:'Chakra Petch', sans-serif; margin-left:4px;">৳ 0.00</strong>
                    </div>
                </div>

                <div class="controls-action-group">
                    <div class="bet-control-box">
                        <button class="btn-bet-step" onclick="changeBet(-1)">-</button>
                        <input type="text" class="bet-input-display" id="bet-amount-input" value="5.00" readonly>
                        <button class="btn-bet-step" onclick="changeBet(1)">+</button>
                    </div>

                    <button class="btn-spin-master" id="btn-main-spin" onclick="triggerEmirateSpin()" title="Spin Reel">
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
                আপনার ৩টি ফ্রি ডেমো স্পিন শেষ হয়েছে। আসল ক্যাশ জিতে শেখ ও পাম জুমিরাহ স্ক্যাটার উপভোগ করতে এখনই ডিপোজিট করুন!
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

    <!-- ── AUDIO ASSETS ── -->
    <audio id="snd-spin" preload="auto" src="{{ $settings->spin_sound ? asset('storage/'.$settings->spin_sound) : '' }}"></audio>
    <audio id="snd-win" preload="auto" src="{{ $settings->win_sound ? asset('storage/'.$settings->win_sound) : '' }}"></audio>
    <audio id="snd-scatter" preload="auto" src="{{ $settings->scatter_sound ? asset('storage/'.$settings->scatter_sound) : '' }}"></audio>
    <audio id="snd-bg" loop preload="auto" src="{{ $settings->bg_music ? asset('storage/'.$settings->bg_music) : '' }}"></audio>

    <script>
        /* ══════════════════════════════════════════
           GAME STATE & CONFIGURATION
        ══════════════════════════════════════════ */
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const SPIN_ENDPOINT = "{{ route('emirate.spin') }}";
        
        let isDemoMode = false;
        let demoSpinsCount = 0;
        const DEMO_MAX_SPINS = {{ $settings->demo_spin_limit ?? 3 }};
        let demoBalance = {{ (float)($settings->demo_default_balance ?? 1000.00) }};
        let realBalance = {{ (float)(auth()->user()->balance ?? 0.00) }};
        
        let betAmounts = [5.00, 10.00, 20.00, 50.00, 100.00, 250.00, 500.00, 1000.00];
        let currentBetIndex = 0;
        let isSpinning = false;
        let soundEnabled = true;

        /* SVG Symbol Library for The Emirate */
        const SYMBOL_SVGS = {
            'SHEIKH': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#0b2144" stroke="#f59e0b" stroke-width="3"/><circle cx="50" cy="46" r="22" fill="#fde68a"/><path d="M22 36 Q 50 14 78 36 L 75 75 Q 50 82 25 75 Z" fill="#ffffff"/><path d="M28 32 Q 50 20 72 32" fill="none" stroke="#dc2626" stroke-width="4"/><circle cx="43" cy="44" r="3" fill="#1e293b"/><circle cx="57" cy="44" r="3" fill="#1e293b"/><path d="M38 54 Q 50 68 62 54" fill="#334155"/><rect x="35" y="70" width="30" height="24" rx="4" fill="#f59e0b"/></svg>`,
            'SHEIKHA': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#1e1b4b" stroke="#eab308" stroke-width="3"/><path d="M25 35 Q 50 10 75 35 L 75 80 Q 50 88 25 80 Z" fill="#0f172a"/><circle cx="50" cy="46" r="18" fill="#fed7aa"/><circle cx="44" cy="45" r="2.5" fill="#0f172a"/><circle cx="56" cy="45" r="2.5" fill="#0f172a"/><path d="M46 54 Q 50 58 54 54" stroke="#ef4444" stroke-width="2" fill="none"/><circle cx="50" cy="30" r="4" fill="#38bdf8"/><path d="M36 75 L 64 75" stroke="#f59e0b" stroke-width="3"/></svg>`,
            'CAR_SUV': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#0c1d36" stroke="#f59e0b" stroke-width="2.5"/><rect x="18" y="40" width="64" height="28" rx="6" fill="#fbbf24"/><rect x="28" y="24" width="44" height="22" rx="4" fill="#f59e0b"/><rect x="34" y="28" width="14" height="14" rx="2" fill="#38bdf8"/><rect x="52" y="28" width="14" height="14" rx="2" fill="#38bdf8"/><circle cx="32" cy="70" r="11" fill="#18181b" stroke="#fff" stroke-width="3"/><circle cx="68" cy="70" r="11" fill="#18181b" stroke="#fff" stroke-width="3"/></svg>`,
            'DUBAI_CITY': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#02142d" stroke="#38bdf8" stroke-width="2.5"/><polygon points="50,15 54,75 46,75" fill="#38bdf8"/><polygon points="32,35 38,75 28,75" fill="#0284c7"/><polygon points="68,35 72,75 62,75" fill="#0284c7"/><rect x="20" y="72" width="60" height="10" fill="#f59e0b"/><circle cx="50" cy="15" r="2.5" fill="#fff"/></svg>`,
            'PALM_SCATTER': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#06324a" stroke="#00e5ff" stroke-width="3"/><path d="M48 45 L 48 78" stroke="#b45309" stroke-width="5" stroke-linecap="round"/><path d="M50 45 Q 30 25 15 35" fill="none" stroke="#22c55e" stroke-width="4"/><path d="M50 45 Q 70 25 85 35" fill="none" stroke="#22c55e" stroke-width="4"/><path d="M50 45 Q 25 45 15 55" fill="none" stroke="#16a34a" stroke-width="4"/><path d="M50 45 Q 75 45 85 55" fill="none" stroke="#16a34a" stroke-width="4"/><path d="M50 45 Q 50 20 50 15" fill="none" stroke="#4ade80" stroke-width="4"/><rect x="15" y="74" width="70" height="16" rx="4" fill="#fbbf24"/><text x="50" y="86" fill="#000" font-family="Montserrat" font-weight="900" font-size="10" text-anchor="middle">SCATTER</text></svg>`,
            'HOOKAH': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#0a192f" stroke="#fbbf24" stroke-width="2"/><ellipse cx="50" cy="65" rx="16" ry="12" fill="#0284c7" stroke="#38bdf8" stroke-width="2"/><rect x="47" y="32" width="6" height="24" fill="#f59e0b"/><rect x="42" y="24" width="16" height="10" rx="3" fill="#fbbf24"/><path d="M55 60 Q 75 50 68 75" fill="none" stroke="#f59e0b" stroke-width="3"/></svg>`,
            'TEAPOT': `<svg viewBox="0 0 100 100" class="symbol-svg"><circle cx="50" cy="50" r="46" fill="#0a192f" stroke="#fbbf24" stroke-width="2"/><path d="M35 70 Q 50 78 65 70 L 60 45 Q 50 40 40 45 Z" fill="#fbbf24"/><polygon points="50,22 55,42 45,42" fill="#f59e0b"/><path d="M62 48 Q 78 40 70 65" fill="none" stroke="#f59e0b" stroke-width="4"/><path d="M38 52 Q 22 45 28 62" fill="none" stroke="#fbbf24" stroke-width="3"/></svg>`
        };

        /* ══════════════════════════════════════════
           PRELOADER ANIMATION
        ══════════════════════════════════════════ */
        window.addEventListener('DOMContentLoaded', () => {
            initGrid();
            updateBetUI();

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
                    statusText.innerText = 'রেডি! The Emirate লোড সম্পন্ন ১০০%';
                    setTimeout(() => {
                        preloader.classList.add('fade-out');
                    }, 400);
                } else {
                    fill.style.width = progress + '%';
                    statusText.innerText = 'রিসোর্স লোড হচ্ছে... ' + progress + '%';
                }
            }, 80);
        });

        /* Initialize 5x3 Grid */
        function initGrid() {
            const grid = document.getElementById('slots-matrix-grid');
            grid.innerHTML = '';
            const defaultSymbols = [
                ['CAR_SUV', 'PALM_SCATTER', 'DUBAI_CITY', 'HOOKAH', 'TEAPOT'],
                ['CAR_SUV', 'CAR_SUV', 'SHEIKH', 'SHEIKH', 'TEAPOT'],
                ['HOOKAH', 'DUBAI_CITY', 'PALM_SCATTER', 'TEAPOT', 'TEAPOT']
            ];

            for (let r = 0; r < 3; r++) {
                for (let c = 0; c < 5; c++) {
                    const sym = defaultSymbols[r][c];
                    const cell = document.createElement('div');
                    cell.className = 'slot-cell';
                    cell.dataset.row = r;
                    cell.dataset.col = c;
                    cell.dataset.symbol = sym;
                    
                    cell.innerHTML = `
                        <div class="symbol-inner-wrapper">
                            ${SYMBOL_SVGS[sym] || SYMBOL_SVGS['SHEIKH']}
                        </div>
                    `;
                    grid.appendChild(cell);
                }
            }
        }

        /* ══════════════════════════════════════════
           BET & MODE LOGIC
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
                topBal.innerText = 'DEMO ৳ ' + demoBalance.toFixed(2);
                topBal.style.color = '#f59e0b';
            } else {
                btnDemo.classList.remove('active');
                btnReal.classList.add('active');
                topBal.innerText = '৳ ' + realBalance.toFixed(2);
                topBal.style.color = '#fbbf24';
            }
        }

        function closeDepositModal() {
            document.getElementById('deposit-popup-modal').classList.remove('show');
        }

        /* ══════════════════════════════════════════
           SPIN TRIGGER & REEL SHUFFLE
        ══════════════════════════════════════════ */
        function triggerEmirateSpin() {
            if (isSpinning) return;

            const betAmount = betAmounts[currentBetIndex];

            // Demo limit guard
            if (isDemoMode && demoSpinsCount >= DEMO_MAX_SPINS) {
                document.getElementById('deposit-popup-modal').classList.add('show');
                return;
            }

            // Real balance check
            if (!isDemoMode && realBalance < betAmount) {
                alert('পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।');
                return;
            }

            isSpinning = true;
            document.getElementById('btn-main-spin').classList.add('spinning');
            document.getElementById('btn-main-spin').disabled = true;
            document.getElementById('game-status-label').innerText = 'SPINNING REELS...';

            document.getElementById('win-celebration-box').classList.remove('active');

            playAudioFX('spin');

            const cells = document.querySelectorAll('.slot-cell');
            cells.forEach(c => {
                c.classList.remove('line-glow', 'scatter-pulse');
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

            // AJAX Request
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
                    demo_spins_count: demoSpinsCount
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
                        document.getElementById('game-status-label').innerText = 'DEMO LIMIT REACHED';
                        return;
                    }

                    if (data.error) {
                        alert(data.error);
                        document.getElementById('game-status-label').innerText = 'ERROR';
                        return;
                    }

                    // Render grid
                    renderEmirateGrid(data.grid);

                    // Scatter win
                    if (data.is_scatter_win) {
                        playAudioFX('scatter');
                        document.querySelectorAll('.slot-cell[data-symbol="PALM_SCATTER"]').forEach(el => {
                            el.classList.add('scatter-pulse');
                        });
                        document.getElementById('game-status-label').innerText = '🌴 PALM JUMEIRAH SCATTER WIN!';
                    } else if (data.is_win) {
                        playAudioFX('win');
                        if (data.winning_lines && data.winning_lines.length > 0) {
                            data.winning_lines.forEach(line => {
                                line.cells.forEach(pos => {
                                    const cell = document.querySelector(`.slot-cell[data-row="${pos[0]}"][data-col="${pos[1]}"]`);
                                    if (cell) cell.classList.add('line-glow');
                                });
                            });
                        }
                        document.getElementById('game-status-label').innerText = '🌟 WINNING PAYLINE!';
                    } else {
                        document.getElementById('game-status-label').innerText = 'TRY AGAIN';
                    }

                    // Win banner
                    if (data.win_amount > 0) {
                        document.getElementById('last-win-label').innerText = '৳ ' + parseFloat(data.win_amount).toFixed(2);
                        const banner = document.getElementById('win-celebration-box');
                        document.getElementById('win-banner-amount').innerText = '৳ ' + parseFloat(data.win_amount).toFixed(2);
                        document.getElementById('win-banner-title').innerText = data.is_scatter_win ? '🌴 PALM SCATTER WIN!' : 'EMIRATE BIG WIN!';
                        banner.classList.add('active');

                        setTimeout(() => {
                            banner.classList.remove('active');
                        }, 3500);
                    } else {
                        document.getElementById('last-win-label').innerText = '৳ 0.00';
                    }

                    // Balances
                    if (isDemoMode) {
                        demoSpinsCount++;
                        demoBalance = demoBalance - betAmount + data.win_amount;
                        document.getElementById('top-balance-display').innerText = 'DEMO ৳ ' + demoBalance.toFixed(2);
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

        function renderEmirateGrid(matrix) {
            for (let r = 0; r < 3; r++) {
                for (let c = 0; c < 5; c++) {
                    const cell = document.querySelector(`.slot-cell[data-row="${r}"][data-col="${c}"]`);
                    if (cell) {
                        const sym = matrix[r][c];
                        cell.dataset.symbol = sym;
                        const inner = cell.querySelector('.symbol-inner-wrapper');
                        if (inner) inner.innerHTML = SYMBOL_SVGS[sym] || SYMBOL_SVGS['SHEIKH'];
                    }
                }
            }
        }

        /* ══════════════════════════════════════════
           SOUND EFFECTS
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
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(220, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(440, ctx.currentTime + 0.3);
                    gain.gain.setValueAtTime(0.15, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.3);
                } else if (type === 'win') {
                    [523, 659, 784, 1046].forEach((freq, i) => {
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
                } else if (type === 'scatter') {
                    [880, 1174, 1480, 1760].forEach((freq, i) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'triangle';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime + i * 0.08);
                        gain.gain.setValueAtTime(0.25, ctx.currentTime + i * 0.08);
                        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + i * 0.08 + 0.3);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start(ctx.currentTime + i * 0.08);
                        osc.stop(ctx.currentTime + i * 0.08 + 0.3);
                    });
                }
            } catch (e) {}
        }

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
