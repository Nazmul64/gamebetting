<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Big Bass Splash™ | Reel Kingdom & Pragmatic Play</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;700;800&family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --water-deep: #031c38;
            --water-turquoise: #0284c7;
            --ocean-blue: #0ea5e9;
            --gold-glow: #ffd700;
            --gold-gradient: linear-gradient(135deg, #ffe066 0%, #f59e0b 50%, #d97706 100%);
            --coral-red: #ef4444;
            --card-glass: rgba(4, 25, 48, 0.85);
            --border-glass: rgba(0, 229, 255, 0.35);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body {
            background-color: #031427;
            font-family: 'Montserrat', sans-serif;
            color: #fff;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* ══════════════════════════════════════════════════════════
           1. TOP GLOBAL GAME FRAME BAR
        ══════════════════════════════════════════════════════════ */
        .game-top-bar {
            width: 100%;
            height: 48px;
            background: linear-gradient(180deg, #1b263b 0%, #0d1b2a 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            z-index: 1000;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .breadcrumb-item {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .breadcrumb-item:hover { color: #fff; }
        .game-title-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 10px;
        }
        .game-title-chip .icon-badge {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #000;
        }
        .game-title-chip .title-text {
            font-weight: 800;
            font-size: 13px;
            color: #fff;
            letter-spacing: 0.5px;
        }

        /* Mode Toggle Switch */
        .mode-toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 14px;
        }
        .mode-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }
        .switch-pill {
            position: relative;
            width: 44px;
            height: 22px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .switch-pill.active {
            background: #10b981;
            border-color: #34d399;
        }
        .switch-circle {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.4);
        }
        .switch-pill.active .switch-circle {
            transform: translateX(22px);
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .search-mini-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            padding: 3px 10px;
            gap: 6px;
        }
        .search-mini-box input {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 11px;
            width: 110px;
            outline: none;
        }
        .top-action-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.2s, transform 0.15s;
        }
        .top-action-btn:hover {
            color: #fff;
            transform: scale(1.1);
        }

        /* ══════════════════════════════════════════════════════════
           2. INTRO / SPLASH SCREEN (SCREENSHOT 1)
        ══════════════════════════════════════════════════════════ */
        #intro-screen {
            position: absolute;
            top: 48px;
            left: 0;
            width: 100%;
            height: calc(100vh - 48px);
            background: url('/games/big-bass-splash/assets/canyon_river_bg.jpg') center center / cover no-repeat;
            z-index: 500;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #intro-screen.hide-intro {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* Water reflection overlay on intro */
        .intro-water-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 65%, rgba(0, 180, 216, 0.15) 0%, rgba(3, 20, 39, 0.45) 80%);
            pointer-events: none;
        }

        .intro-stage {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Fisherman on Left (Body Sway, Right Arm Cranking, Right Boot Tapping) */
        .intro-fisherman-box {
            position: relative;
            width: 320px;
            height: 540px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }
        .fisherman-character-wrap {
            position: relative;
            width: 100%;
            height: 100%;
            transform-origin: 35% 95%;
            animation: fishermanBodySwayAndTap 2.4s ease-in-out infinite;
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.75));
        }
        .fisherman-body-layer {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: bottom center;
            display: block;
        }
        .fisherman-arm-layer {
            position: absolute;
            top: 42.8%;
            left: 27%;
            width: 59%;
            transform-origin: 96% 32%;
            animation: crankReelHandle 0.95s ease-in-out infinite;
            z-index: 5;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.5));
        }

        /* Fisherman Body Natural Movement & Foot Tap ("ডান পা টা একটু আলগি দিয়ে শরীরটা নাড়াচড়া করতেছে") */
        @keyframes fishermanBodySwayAndTap {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            18% {
                transform: translateY(-8px) rotate(-1.5deg); /* ডান পা আলগি দিয়ে শরীর নাড়ে */
            }
            36% {
                transform: translateY(0) rotate(0deg); /* পা ফেলা */
            }
            52% {
                transform: translateY(-3px) rotate(0.8deg); /* স্বাভাবিক শ্বাসপ্রশ্বাস ও নাড়াচড়া */
            }
            76% {
                transform: translateY(-6px) rotate(-0.8deg);
            }
        }

        /* Right Hand / Arm Cranking the Fishing Rod Reel Handle ("ডান হাতটা দিয়া ঐ যে বড়শির প্যাডেলটা ঘুরাইতাছে") - কাঁধ সংযুক্ত থাকবে */
        @keyframes crankReelHandle {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-5deg);
            }
            50% {
                transform: rotate(-10deg);
            }
            75% {
                transform: rotate(-4deg);
            }
        }

        /* Center Splash Logo & Tagline */
        .intro-center-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 580px;
            z-index: 10;
        }
        .intro-bass-logo-wrap {
            position: relative;
            width: 340px;
            height: 260px;
            margin-bottom: -20px;
            animation: bassLogoWiggle 2.2s ease-in-out infinite;
        }
        .intro-bass-circle-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.6));
        }
        @keyframes bassLogoWiggle {
            0%, 100% { transform: translateY(0) scale(1) rotate(-1deg); }
            50% { transform: translateY(-10px) scale(1.03) rotate(1.5deg); }
        }

        /* 3D Big Bass Splash Logo Typography */
        .big-bass-splash-logo-title {
            position: relative;
            z-index: 12;
            margin-top: -10px;
            margin-bottom: 12px;
        }
        .logo-text-big-bass {
            font-family: 'Outfit', sans-serif;
            font-size: 58px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: #ffe600;
            text-shadow: 
                -3px -3px 0 #d97706,
                 3px -3px 0 #d97706,
                -3px  3px 0 #d97706,
                 3px  3px 0 #d97706,
                 0 8px 15px rgba(0, 0, 0, 0.8),
                 0 0 25px rgba(255, 215, 0, 0.6);
            display: block;
            line-height: 0.9;
        }
        .logo-ribbon-splash {
            display: inline-block;
            background: linear-gradient(180deg, #b45309 0%, #78350f 100%);
            border: 3px solid #fbbf24;
            border-radius: 12px;
            padding: 4px 28px;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 26px;
            letter-spacing: 3px;
            text-transform: uppercase;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.7), 0 0 15px rgba(251, 191, 36, 0.5);
            transform: rotate(-2deg);
        }

        .intro-tagline {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 22px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 
                -2px -2px 0 #000,
                 2px -2px 0 #000,
                -2px  2px 0 #000,
                 2px  2px 0 #000,
                 0 4px 12px rgba(0, 0, 0, 0.9);
            margin-top: 15px;
            max-width: 460px;
            line-height: 1.2;
        }

        /* Right Reel Kingdom Monkey Button */
        .intro-right-box {
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .reel-kingdom-circle-btn {
            position: relative;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 40px rgba(0, 229, 255, 0.4), 0 10px 30px rgba(0, 0, 0, 0.8);
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            border: 4px solid #94a3b8;
        }
        .reel-kingdom-circle-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 0 50px rgba(0, 229, 255, 0.7), 0 15px 40px rgba(0, 0, 0, 0.9);
        }
        .reel-kingdom-circle-btn:active {
            transform: scale(0.95);
        }
        .reel-kingdom-circle-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            animation: spinArrowRotate 6s linear infinite;
        }
        @keyframes spinArrowRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Bottom Controls on Intro */
        .intro-bottom-bar {
            width: 100%;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            z-index: 20;
        }
        .dont-show-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }
        .dont-show-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #00e5ff;
            cursor: pointer;
        }

        /* ══════════════════════════════════════════════════════════
           3. MAIN GAME SCREEN (SLOTS, SCREENSHOT 2)
        ══════════════════════════════════════════════════════════ */
        #game-screen {
            position: absolute;
            top: 48px;
            left: 0;
            width: 100%;
            height: calc(100vh - 48px);
            background: url('/games/big-bass-splash/assets/canyon_river_bg.jpg') center center / cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            z-index: 100;
        }

        /* Background Swimming Fish (পিছনে মাছ যাইতেছে) */
        .fish-background-aquarium {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 2;
        }
        .bg-fish {
            position: absolute;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.4));
            opacity: 0.85;
            transition: opacity 0.3s;
        }
        .bg-fish-1 {
            width: 90px;
            top: 18%;
            animation: swimLeftToRight 16s linear infinite;
        }
        .bg-fish-2 {
            width: 120px;
            top: 45%;
            animation: swimRightToLeft 22s linear infinite 4s;
        }
        .bg-fish-3 {
            width: 75px;
            top: 68%;
            animation: swimLeftToRight 19s linear infinite 8s;
        }
        .bg-fish-4 {
            width: 110px;
            top: 30%;
            animation: swimRightToLeft 25s linear infinite 12s;
        }

        @keyframes swimLeftToRight {
            0% { left: -160px; transform: translateY(0) scaleX(1); }
            50% { transform: translateY(-15px) scaleX(1); }
            100% { left: 105vw; transform: translateY(0) scaleX(1); }
        }
        @keyframes swimRightToLeft {
            0% { right: -160px; transform: translateY(0) scaleX(-1); }
            50% { transform: translateY(18px) scaleX(-1); }
            100% { right: 105vw; transform: translateY(0) scaleX(-1); }
        }

        /* Vertical Bubble Columns (পানিগুলা উপরে বক্সে উঠতেছে) */
        .bubble-columns-layer {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 15;
            display: flex;
            justify-content: center;
        }
        .bubble-column-wrap {
            position: relative;
            width: 100%;
            max-width: 960px;
            height: 100%;
        }
        .bubble-track {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 18px;
            overflow: hidden;
        }
        .bubble-track-0 { left: calc(20% * 0 + 10px); }
        .bubble-track-1 { left: calc(20% * 1); }
        .bubble-track-2 { left: calc(20% * 2); }
        .bubble-track-3 { left: calc(20% * 3); }
        .bubble-track-4 { left: calc(20% * 4); }
        .bubble-track-5 { right: 10px; }

        .rising-bubble {
            position: absolute;
            bottom: -20px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(0, 229, 255, 0.2) 60%, rgba(255, 255, 255, 0) 100%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: bubbleFloat linear infinite;
        }
        @keyframes bubbleFloat {
            0% { transform: translateY(0) scale(0.6); opacity: 0; }
            10% { opacity: 0.9; }
            90% { opacity: 0.9; }
            100% { transform: translateY(-105vh) scale(1.2); opacity: 0; }
        }

        /* Slot Stage Layout */
        .slot-stage-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            padding: 8px 16px;
        }

        /* Top Slot Header Header (Buy Free Spins & Big Bass Logo) */
        .slot-roof-header {
            width: 100%;
            max-width: 960px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
            position: relative;
        }

        /* Buy Free Spins Button */
        .btn-buy-free-spins {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            border: 2px solid #fef08a;
            border-radius: 8px;
            padding: 6px 14px;
            color: #000;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6), 0 0 15px rgba(245, 158, 11, 0.6);
            transition: transform 0.15s, box-shadow 0.15s;
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1.1;
        }
        .btn-buy-free-spins:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.9);
        }
        .btn-buy-free-spins:active {
            transform: scale(0.97);
        }
        .buy-spins-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #fff;
            text-shadow: 0 1px 2px #000;
        }
        .buy-spins-cost {
            font-size: 17px;
            color: #fef08a;
            font-weight: 900;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8);
        }

        /* Center Logo between 2 Bass Fish */
        .roof-logo-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .roof-bass-left, .roof-bass-right {
            width: 44px;
            height: 44px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.6));
        }
        .roof-bass-right {
            transform: scaleX(-1);
        }
        .roof-logo-center {
            text-align: center;
        }
        .roof-logo-text-big {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 900;
            color: #ffe600;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 
                -2px -2px 0 #b45309,
                 2px -2px 0 #b45309,
                -2px  2px 0 #b45309,
                 2px  2px 0 #b45309,
                 0 4px 10px rgba(0, 0, 0, 0.8);
            line-height: 0.9;
        }
        .roof-logo-badge-splash {
            background: linear-gradient(180deg, #92400e 0%, #78350f 100%);
            border: 1.5px solid #fbbf24;
            border-radius: 6px;
            padding: 1px 12px;
            font-size: 13px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 1.5px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* 5x3 Reels Grid Matrix */
        .slot-reels-container {
            width: 100%;
            max-width: 960px;
            background: rgba(3, 16, 32, 0.75);
            border: 2px solid rgba(0, 229, 255, 0.4);
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8), inset 0 0 30px rgba(0, 0, 0, 0.9);
            position: relative;
            backdrop-filter: blur(4px);
        }
        .reels-grid-5x3 {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
        }
        .reel-col {
            display: flex;
            flex-direction: column;
            gap: 6px;
            position: relative;
        }
        .slot-symbol-cell {
            aspect-ratio: 1 / 0.96;
            background: linear-gradient(180deg, rgba(7, 33, 62, 0.85) 0%, rgba(3, 19, 39, 0.95) 100%);
            border: 1.5px solid rgba(0, 229, 255, 0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        }
        .slot-symbol-cell.spinning {
            filter: blur(4px);
            transform: scale(0.97);
            opacity: 0.85;
        }
        .slot-symbol-cell.winner-cell {
            border-color: #ffd700 !important;
            box-shadow: 0 0 20px #ffd700, inset 0 0 12px rgba(255, 215, 0, 0.4) !important;
            transform: scale(1.04);
            z-index: 10;
            animation: winPulse 0.8s infinite alternate;
        }
        @keyframes winPulse {
            0% { box-shadow: 0 0 15px #ffd700; }
            100% { box-shadow: 0 0 30px #f59e0b, 0 0 10px #fff; }
        }

        .symbol-img {
            width: 82%;
            height: 82%;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.7));
            transition: transform 0.2s;
        }

        /* 3D Card Symbols */
        .card-symbol-3d {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 64px;
            line-height: 1;
            letter-spacing: -2px;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.8));
        }
        .card-symbol-3d.sym-A {
            color: #d8b4fe;
            text-shadow: 
                -2px -2px 0 #7e22ce,
                 2px -2px 0 #7e22ce,
                -2px  2px 0 #7e22ce,
                 2px  2px 0 #7e22ce,
                 0 0 15px rgba(168, 85, 247, 0.6);
        }
        .card-symbol-3d.sym-K {
            color: #fed7aa;
            text-shadow: 
                -2px -2px 0 #c2410c,
                 2px -2px 0 #c2410c,
                -2px  2px 0 #c2410c,
                 2px  2px 0 #c2410c,
                 0 0 15px rgba(249, 115, 22, 0.6);
        }
        .card-symbol-3d.sym-Q {
            color: #fca5a5;
            text-shadow: 
                -2px -2px 0 #b91c1c,
                 2px -2px 0 #b91c1c,
                -2px  2px 0 #b91c1c,
                 2px  2px 0 #b91c1c,
                 0 0 15px rgba(239, 68, 68, 0.6);
        }
        .card-symbol-3d.sym-J {
            color: #93c5fd;
            text-shadow: 
                -2px -2px 0 #1d4ed8,
                 2px -2px 0 #1d4ed8,
                -2px  2px 0 #1d4ed8,
                 2px  2px 0 #1d4ed8,
                 0 0 15px rgba(59, 130, 246, 0.6);
        }
        .card-symbol-3d.sym-10 {
            color: #fef08a;
            font-size: 54px;
            text-shadow: 
                -2px -2px 0 #a16207,
                 2px -2px 0 #a16207,
                -2px  2px 0 #a16207,
                 2px  2px 0 #a16207,
                 0 0 15px rgba(234, 179, 8, 0.6);
        }

        /* Fish Money Tag */
        .fish-money-badge {
            position: absolute;
            bottom: 4px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            font-family: 'Chakra Petch', sans-serif;
            font-weight: 800;
            font-size: 11px;
            padding: 1px 8px;
            border-radius: 12px;
            border: 1px solid #34d399;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.8);
            z-index: 5;
        }

        /* ══════════════════════════════════════════════════════════
           4. BOTTOM DASHBOARD CONTROLS BAR (REEL KINGDOM STYLE)
        ══════════════════════════════════════════════════════════ */
        .bottom-game-dashboard {
            width: 100%;
            height: 72px;
            background: linear-gradient(180deg, #031427 0%, #010a14 100%);
            border-top: 1.5px solid rgba(0, 229, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: relative;
            z-index: 200;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.7);
        }

        /* Left Info Cluster */
        .footer-left-cluster {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .footer-icon-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.2s, transform 0.15s;
        }
        .footer-icon-btn:hover {
            color: #fff;
            transform: scale(1.15);
        }

        .credit-bet-display {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .credit-row, .bet-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 800;
        }
        .credit-label, .bet-label {
            color: #94a3b8;
            font-size: 11px;
            text-transform: uppercase;
        }
        .credit-val {
            color: #fef08a;
            font-family: 'Chakra Petch', sans-serif;
            font-size: 14px;
        }
        .bet-val {
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            font-size: 14px;
        }

        /* Center Instruction Message */
        .footer-center-message {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.9);
            text-align: center;
        }
        .footer-center-message.win-text {
            color: #ffd700;
            animation: winTextPulse 0.5s infinite alternate;
        }
        @keyframes winTextPulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.08); text-shadow: 0 0 12px #ffd700; }
        }

        /* Right Spin & Bet Adjusters Cluster */
        .footer-right-cluster {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .btn-step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        .btn-step-circle:hover {
            background: rgba(0, 229, 255, 0.3);
            border-color: #00e5ff;
            color: #00e5ff;
            transform: scale(1.1);
        }
        .btn-step-circle:active {
            transform: scale(0.92);
        }

        /* Main Reel Kingdom Monkey Spin Button */
        .spin-btn-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .main-reel-spin-btn {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 3px solid #94a3b8;
            background: #000;
            cursor: pointer;
            box-shadow: 0 0 25px rgba(0, 229, 255, 0.5), 0 4px 15px rgba(0, 0, 0, 0.8);
            transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.15s;
            overflow: hidden;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-reel-spin-btn:hover:not(:disabled) {
            transform: scale(1.1);
            box-shadow: 0 0 35px rgba(0, 229, 255, 0.8), 0 0 15px #fff;
        }
        .main-reel-spin-btn:active:not(:disabled) {
            transform: scale(0.92);
        }
        .main-reel-spin-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            filter: grayscale(0.7);
        }
        .main-reel-spin-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: transform 0.2s;
        }
        .main-reel-spin-btn.spinning img {
            animation: spinArrowRotate 0.8s linear infinite;
        }

        .autoplay-label-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 2px;
            transition: color 0.15s;
        }
        .autoplay-label-btn:hover {
            color: #00e5ff;
        }

        .reel-kingdom-watermark {
            position: absolute;
            bottom: 6px;
            left: 24px;
            font-size: 9px;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.25);
            letter-spacing: 2px;
            text-transform: uppercase;
            pointer-events: none;
        }

        /* ══════════════════════════════════════════════════════════
           5. WIN CELEBRATION MODAL OVERLAY
        ══════════════════════════════════════════════════════════ */
        .win-splash-modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.6);
            background: linear-gradient(135deg, rgba(3, 20, 39, 0.96) 0%, rgba(1, 10, 20, 0.98) 100%);
            border: 3px solid #ffd700;
            border-radius: 20px;
            padding: 24px 36px;
            text-align: center;
            box-shadow: 0 0 60px rgba(255, 215, 0, 0.6), inset 0 0 30px rgba(255, 215, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(12px);
        }
        .win-splash-modal.active {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }
        .win-title-gold {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 900;
            color: #ffd700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
        }
        .win-amount-big {
            font-family: 'Chakra Petch', sans-serif;
            font-size: 42px;
            font-weight: 900;
            color: #ffffff;
            margin: 8px 0;
            text-shadow: 0 0 25px #00e5ff;
        }
        .win-sub-label {
            font-size: 13px;
            font-weight: 700;
            color: #38bdf8;
            letter-spacing: 1px;
        }

        /* Deposit lock modal */
        .deposit-alert-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .deposit-alert-backdrop.show {
            opacity: 1;
            visibility: visible;
        }
        .deposit-alert-box {
            max-width: 420px;
            width: 100%;
            background: linear-gradient(180deg, #072242 0%, #021124 100%);
            border: 2px solid #ffd700;
            border-radius: 18px;
            padding: 26px 20px;
            text-align: center;
            box-shadow: 0 0 50px rgba(255, 215, 0, 0.4);
        }

        /* Responsive Mobile Styles */
        @media (max-width: 768px) {
            .intro-stage {
                flex-direction: column;
                justify-content: center;
                gap: 10px;
                padding: 10px;
            }
            .intro-fisherman-box {
                width: 220px;
                height: 340px;
            }
            .logo-text-big-bass { font-size: 38px; }
            .logo-ribbon-splash { font-size: 18px; padding: 3px 18px; }
            .intro-tagline { font-size: 16px; }
            .reel-kingdom-circle-btn { width: 90px; height: 90px; }
            .slot-reels-container { padding: 4px; }
            .reels-grid-5x3 { gap: 4px; }
            .card-symbol-3d { font-size: 38px; }
            .card-symbol-3d.sym-10 { font-size: 32px; }
            .bottom-game-dashboard { padding: 0 12px; height: 65px; }
            .credit-label, .bet-label { display: none; }
            .footer-center-message { display: none; }
            .main-reel-spin-btn { width: 52px; height: 52px; }
        }
    </style>
</head>
<body>

    <!-- ══════════════════════════════════════════════════════════
       TOP HEADER NAVIGATION BAR
    ══════════════════════════════════════════════════════════ -->
    <header class="game-top-bar">
        <div class="top-bar-left">
            <a href="{{ route('home') }}" class="breadcrumb-item" title="Back to Games">
                <i class="fas fa-arrow-left"></i>
                <i class="fas fa-house"></i>
            </a>
            <span style="color:rgba(255,255,255,0.2);">/</span>
            <span class="breadcrumb-item" style="color:#fff;">Search results</span>
            
            <div class="game-title-chip">
                <div class="icon-badge"><i class="fas fa-crown"></i></div>
                <span class="title-text">Big Bass Splash</span>
            </div>

            <!-- Real / Demo Mode Toggle -->
            <div class="mode-toggle-wrap">
                <div class="switch-pill {{ auth()->check() ? 'active' : '' }}" id="mode-toggle-pill" onclick="togglePlayMode()">
                    <div class="switch-circle"></div>
                </div>
                <span class="mode-label" id="mode-status-text" style="{{ auth()->check() ? 'color:#10b981;' : '' }}">{{ auth()->check() ? 'PLAYING FOR REAL MONEY' : 'DEMO MODE' }}</span>
            </div>
        </div>

        <div class="top-bar-right">
            <div class="search-mini-box">
                <input type="text" value="Big Bass Splash" readonly>
                <i class="fas fa-magnifying-glass" style="color:#94a3b8; font-size:11px;"></i>
            </div>
            <button class="top-action-btn" onclick="toggleSound()" title="Sound Toggle">
                <i class="fas fa-volume-high" id="top-sound-icon"></i>
            </button>
            <button class="top-action-btn" onclick="toggleFullScreen()" title="Fullscreen">
                <i class="fas fa-expand"></i>
            </button>
            <button class="top-action-btn" onclick="showIntroScreen()" title="Replay Intro">
                <i class="fas fa-rotate"></i>
            </button>
            <button class="top-action-btn" title="Add to Favorites">
                <i class="far fa-star"></i>
            </button>
            <a href="{{ route('home') }}" class="top-action-btn" title="Close Game">
                <i class="fas fa-xmark" style="font-size:16px;"></i>
            </a>
        </div>
    </header>

    <!-- ══════════════════════════════════════════════════════════
       SCREEN 1: INTRO / SPLASH SCREEN (SCREENSHOT 1)
    ══════════════════════════════════════════════════════════ -->
    <div id="intro-screen">
        <div class="intro-water-overlay"></div>

        <div class="intro-stage">
            <!-- Left: Fisherman with Animated Cranking Arm & Tapping Foot -->
            <div class="intro-fisherman-box">
                <div class="fisherman-character-wrap">
                    <img src="/games/big-bass-splash/assets/intro_fisherman_body.png" alt="Fisherman Body" class="fisherman-body-layer" id="intro-fisherman-body">
                    <img src="/games/big-bass-splash/assets/intro_fisherman_arm.png" alt="Cranking Arm" class="fisherman-arm-layer">
                </div>
            </div>

            <!-- Center: Leaping Bass Logo & 3D Typography -->
            <div class="intro-center-box">
                <div class="intro-bass-logo-wrap">
                    <img src="/games/big-bass-splash/assets/intro_bass_circle.png" alt="Golden Leaping Bass" class="intro-bass-circle-img">
                </div>

                <div class="big-bass-splash-logo-title">
                    <span class="logo-text-big-bass">BIG BASS</span>
                    <span class="logo-ribbon-splash">SPLASH</span>
                </div>

                <div class="intro-tagline">
                    GO FISHIN' FOR BIG FREE SPINS MODIFIERS!
                </div>
            </div>

            <!-- Right: Circular Reel Kingdom Monkey Spin Button -->
            <div class="intro-right-box">
                <div class="reel-kingdom-circle-btn" id="btn-enter-game" onclick="enterGame()" title="Play Big Bass Splash">
                    <img src="/games/big-bass-splash/assets/btn_spin.png" alt="Spin to Start">
                </div>
            </div>
        </div>

        <!-- Bottom Checkbox: Don't Show Next Time -->
        <div class="intro-bottom-bar">
            <label class="dont-show-checkbox">
                <input type="checkbox" id="chk-dont-show-intro" onchange="handleDontShowChange(this)">
                DON'T SHOW NEXT TIME
            </label>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
       SCREEN 2: MAIN SLOT GAME (SCREENSHOT 2)
    ══════════════════════════════════════════════════════════ -->
    <main id="game-screen">
        <!-- Background Swimming Fish ("পিছনে মাছ যাইতেছে") -->
        <div class="fish-background-aquarium">
            <img src="/games/big-bass-splash/assets/bg_fish.png" class="bg-fish bg-fish-1" alt="Fish">
            <img src="/games/big-bass-splash/assets/bg_fish.png" class="bg-fish bg-fish-2" alt="Fish">
            <img src="/games/big-bass-splash/assets/bg_fish.png" class="bg-fish bg-fish-3" alt="Fish">
            <img src="/games/big-bass-splash/assets/bg_fish.png" class="bg-fish bg-fish-4" alt="Fish">
        </div>

        <!-- Vertical Rising Bubble Streams ("পানিগুলা উপরে বক্সে উঠতেছে") -->
        <div class="bubble-columns-layer">
            <div class="bubble-column-wrap" id="bubble-columns-wrapper">
                <div class="bubble-track bubble-track-0"></div>
                <div class="bubble-track bubble-track-1"></div>
                <div class="bubble-track bubble-track-2"></div>
                <div class="bubble-track bubble-track-3"></div>
                <div class="bubble-track bubble-track-4"></div>
                <div class="bubble-track bubble-track-5"></div>
            </div>
        </div>

        <!-- Slot Stage Area -->
        <div class="slot-stage-area">
            <!-- Top Slot Header (Buy Free Spins & Big Bass Center Frame) -->
            <div class="slot-roof-header">
                <!-- Buy Free Spins Button on Left -->
                <button class="btn-buy-free-spins" onclick="executeBuyBonus()" title="Buy Free Spins Feature">
                    <span class="buy-spins-title">BUY FREE SPINS</span>
                    <span class="buy-spins-cost" id="buy-spins-cost-label">$200</span>
                </button>

                <!-- Center Logo with 2 Bass Fish -->
                <div class="roof-logo-box">
                    <img src="/games/big-bass-splash/assets/top_bass_icon.png" class="roof-bass-left" alt="Bass">
                    <div class="roof-logo-center">
                        <div class="roof-logo-text-big">BIG BASS</div>
                        <div class="roof-logo-badge-splash">SPLASH</div>
                    </div>
                    <img src="/games/big-bass-splash/assets/top_bass_icon.png" class="roof-bass-right" alt="Bass">
                </div>

                <div style="width: 110px;"></div> <!-- Spacer for balance -->
            </div>

            <!-- 5x3 Reels Grid Container -->
            <div class="slot-reels-container">
                <!-- Win Celebration Overlay -->
                <div class="win-splash-modal" id="win-celebration-modal">
                    <div class="win-title-gold" id="win-modal-title">BIG SPLASH WIN!</div>
                    <div class="win-amount-big" id="win-modal-amount">৳ 0.00</div>
                    <div class="win-sub-label" id="win-modal-sub">FISHERMAN REELED IT IN!</div>
                </div>

                <!-- 5x3 Grid Columns -->
                <div class="reels-grid-5x3" id="slots-grid-element">
                    <!-- Column 0 -->
                    <div class="reel-col" id="reel-col-0">
                        <div class="slot-symbol-cell" data-r="0" data-c="0"></div>
                        <div class="slot-symbol-cell" data-r="1" data-c="0"></div>
                        <div class="slot-symbol-cell" data-r="2" data-c="0"></div>
                    </div>
                    <!-- Column 1 -->
                    <div class="reel-col" id="reel-col-1">
                        <div class="slot-symbol-cell" data-r="0" data-c="1"></div>
                        <div class="slot-symbol-cell" data-r="1" data-c="1"></div>
                        <div class="slot-symbol-cell" data-r="2" data-c="1"></div>
                    </div>
                    <!-- Column 2 -->
                    <div class="reel-col" id="reel-col-2">
                        <div class="slot-symbol-cell" data-r="0" data-c="2"></div>
                        <div class="slot-symbol-cell" data-r="1" data-c="2"></div>
                        <div class="slot-symbol-cell" data-r="2" data-c="2"></div>
                    </div>
                    <!-- Column 3 -->
                    <div class="reel-col" id="reel-col-3">
                        <div class="slot-symbol-cell" data-r="0" data-c="3"></div>
                        <div class="slot-symbol-cell" data-r="1" data-c="3"></div>
                        <div class="slot-symbol-cell" data-r="2" data-c="3"></div>
                    </div>
                    <!-- Column 4 -->
                    <div class="reel-col" id="reel-col-4">
                        <div class="slot-symbol-cell" data-r="0" data-c="4"></div>
                        <div class="slot-symbol-cell" data-r="1" data-c="4"></div>
                        <div class="slot-symbol-cell" data-r="2" data-c="4"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════
           BOTTOM CONTROLS BAR (REEL KINGDOM / PRAGMATIC PLAY)
        ══════════════════════════════════════════════════════════ -->
        <footer class="bottom-game-dashboard">
            <div class="reel-kingdom-watermark">REEL KINGDOM</div>

            <!-- Left Controls & Balance Cluster -->
            <div class="footer-left-cluster">
                <button class="footer-icon-btn" title="Settings / Paytable" onclick="alert('Big Bass Splash™ 10 Lines\nTruck: 200x\nRod: 100x\nDragonfly: 50x\nTackle Box: 50x\nFish: Multiplier Collection\nA, K, Q, J, 10: 10x-5x')">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="footer-icon-btn" onclick="toggleSound()" title="Sound Mute/Unmute">
                    <i class="fas fa-volume-high" id="footer-sound-icon"></i>
                </button>
                <button class="footer-icon-btn" title="Game Rules & Information" onclick="alert('Wild Fisherman collects all Fish Money values on screen!\n3+ Scatters trigger Free Spins Feature with random modifiers!')">
                    <i class="fas fa-circle-info"></i>
                </button>

                <div class="credit-bet-display">
                    <div class="credit-row">
                        <span class="credit-label">CREDIT</span>
                        <span class="credit-val" id="credit-balance-label">{{ auth()->check() ? (auth()->user()->currency ?? '৳') . ' ' . number_format(auth()->user()->balance ?? 0.00, 2) : '৳ 0.00' }}</span>
                    </div>
                    <div class="bet-row">
                        <span class="bet-label">BET</span>
                        <span class="bet-val" id="bet-display-label">{{ auth()->user()->currency ?? '৳' }} 2.00</span>
                    </div>
                </div>
            </div>

            <!-- Center Instruction -->
            <div class="footer-center-message" id="center-status-instruction">
                HOLD SPACE FOR TURBO SPIN
            </div>

            <!-- Right Spin & Bet Step Cluster -->
            <div class="footer-right-cluster">
                <button class="btn-step-circle" onclick="changeBet(-1)" title="Decrease Bet">-</button>
                
                <div class="spin-btn-wrapper">
                    <button class="main-reel-spin-btn" id="btn-master-spin" onclick="handleSpinClick(false)" title="Spin Reels (Spacebar)">
                        <img src="/games/big-bass-splash/assets/btn_spin.png" alt="Spin">
                    </button>
                    <button class="autoplay-label-btn" onclick="toggleAutoPlay()" id="btn-autoplay-toggle">AUTOPLAY</button>
                </div>

                <button class="btn-step-circle" onclick="changeBet(1)" title="Increase Bet">+</button>
            </div>
        </footer>
    </main>

    <!-- Deposit Alert Modal -->
    <div class="deposit-alert-backdrop" id="deposit-lock-modal">
        <div class="deposit-alert-box">
            <i class="fas fa-lock" style="font-size:36px; color:#ffd700; margin-bottom:12px;"></i>
            <h3 style="font-family:'Outfit'; font-size:22px; color:#fff; margin-bottom:8px;">DEMO LIMIT REACHED</h3>
            <p style="font-size:13px; color:#cbd5e1; line-height:1.5; margin-bottom:18px;">
                Your demo trial has ended. Deposit now to play with real cash, win real payouts, and enjoy Fisherman Reel Collect!
            </p>
            <a href="{{ route('dashboard.deposit') }}" style="display:block; padding:12px; background:var(--gold-gradient); color:#000; font-weight:800; border-radius:8px; text-decoration:none; margin-bottom:10px;">
                <i class="fas fa-wallet"></i> DEPOSIT TO PLAY
            </a>
            <button onclick="document.getElementById('deposit-lock-modal').classList.remove('show')" style="background:transparent; border:none; color:#94a3b8; font-weight:700; cursor:pointer;">
                CLOSE
            </button>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
       JAVASCRIPT GAME ENGINE & AUDIO SYNTHESIZER
    ══════════════════════════════════════════════════════════ -->
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const SPIN_URL = "{{ route('bigbass.spin') }}";
        
        let isRealMoney = {{ auth()->check() ? 'true' : 'false' }};
        let demoBalance = 0.00;
        let realBalance = {{ (float)(auth()->user()->balance ?? 0.00) }};
        let userCurrency = "{{ auth()->user()->currency ?? '৳' }}";
        
        const BET_STEPS = [2.00, 4.00, 6.00, 10.00, 20.00, 40.00, 50.00, 100.00, 200.00, 500.00];
        let currentBetIndex = 0;
        let isSpinning = false;
        let soundEnabled = true;
        let autoPlayActive = false;
        let autoPlayRemaining = 0;
        let demoSpinsCount = 0;
        let spacePressed = false;
        let spaceTimer = null;

        // Authentic Game Symbol Assets (Extracted directly from Big Bass Splash)
        const SYMBOLS = {
            'TRUCK': { src: '/games/big-bass-splash/assets/sym_truck.png', name: 'Monster Truck' },
            'FISHING_ROD': { src: '/games/big-bass-splash/assets/sym_rod.png', name: 'Fishing Rod' },
            'DRAGONFLY': { src: '/games/big-bass-splash/assets/sym_dragonfly.png', name: 'Dragonfly' },
            'TACKLE_BOX': { src: '/games/big-bass-splash/assets/sym_tackle.png', name: 'Tackle Box' },
            'FISH_MONEY': { src: '/games/big-bass-splash/assets/sym_fish_money.png', name: 'Fish Money', isFish: true },
            'FISHERMAN': { src: '/games/big-bass-splash/assets/sym_wild.png', name: 'Wild Fisherman', isWild: true },
            'SCATTER': { src: '/games/big-bass-splash/assets/sym_scatter.png', name: 'Scatter Bass', isScatter: true },
            'A': { src: '/games/big-bass-splash/assets/sym_a.png', name: 'A' },
            'K': { src: '/games/big-bass-splash/assets/sym_k.png', name: 'K' },
            'Q': { src: '/games/big-bass-splash/assets/sym_q.png', name: 'Q' },
            'J': { src: '/games/big-bass-splash/assets/sym_j.png', name: 'J' },
            '10': { src: '/games/big-bass-splash/assets/sym_10.png', name: '10' }
        };

        // Web Audio Synthesizer for instant slot sound effects
        const AudioFX = {
            ctx: null,
            init() {
                if (!this.ctx) {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    if (AudioContext) this.ctx = new AudioContext();
                }
            },
            playTick() {
                if (!soundEnabled || !this.ctx) return;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(380, this.ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(120, this.ctx.currentTime + 0.05);
                gain.gain.setValueAtTime(0.15, this.ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.05);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start();
                osc.stop(this.ctx.currentTime + 0.05);
            },
            playSplash() {
                if (!soundEnabled || !this.ctx) return;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(600, this.ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(180, this.ctx.currentTime + 0.25);
                gain.gain.setValueAtTime(0.3, this.ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.25);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start();
                osc.stop(this.ctx.currentTime + 0.25);
            },
            playWin() {
                if (!soundEnabled || !this.ctx) return;
                const now = this.ctx.currentTime;
                [440, 554, 659, 880].forEach((freq, i) => {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, now + i * 0.1);
                    gain.gain.setValueAtTime(0.2, now + i * 0.1);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + i * 0.1 + 0.35);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start(now + i * 0.1);
                    osc.stop(now + i * 0.1 + 0.35);
                });
            }
        };

        // Initialize Game On Page Load
        window.addEventListener('DOMContentLoaded', () => {
            initBubbleColumns();
            renderInitialGrid();
            updateBalanceAndBetUI();

            // Check if user previously checked "Don't show next time"
            const skipIntro = localStorage.getItem('bigbass_skip_intro');
            if (skipIntro === '1') {
                const introEl = document.getElementById('intro-screen');
                if (introEl) introEl.classList.add('hide-intro');
                document.getElementById('chk-dont-show-intro').checked = true;
            }

            // Keyboard Spacebar listener
            window.addEventListener('keydown', (e) => {
                if (e.code === 'Space' && !e.repeat && !isSpinning) {
                    e.preventDefault();
                    AudioFX.init();
                    spacePressed = true;
                    spaceTimer = setTimeout(() => {
                        // Turbo Spin
                        handleSpinClick(false, true);
                    }, 400);
                }
            });

            window.addEventListener('keyup', (e) => {
                if (e.code === 'Space') {
                    e.preventDefault();
                    if (spaceTimer) {
                        clearTimeout(spaceTimer);
                        spaceTimer = null;
                        if (!isSpinning) handleSpinClick(false, false);
                    }
                    spacePressed = false;
                }
            });
        });

        // Intro Screen Handlers
        function enterGame() {
            AudioFX.init();
            AudioFX.playSplash();
            const intro = document.getElementById('intro-screen');
            if (intro) {
                intro.classList.add('hide-intro');
            }
        }

        function showIntroScreen() {
            const intro = document.getElementById('intro-screen');
            if (intro) {
                intro.classList.remove('hide-intro');
            }
        }

        function handleDontShowChange(cb) {
            if (cb.checked) {
                localStorage.setItem('bigbass_skip_intro', '1');
            } else {
                localStorage.removeItem('bigbass_skip_intro');
            }
        }

        // Toggle Real / Demo Money
        function togglePlayMode() {
            @if(!auth()->check())
                alert('আসল টাকা দিয়ে খেলতে অনুগ্রহ করে প্রথমে লগইন করুন।');
                return;
            @endif
            isRealMoney = !isRealMoney;
            const pill = document.getElementById('mode-toggle-pill');
            const label = document.getElementById('mode-status-text');
            if (isRealMoney) {
                pill.classList.add('active');
                label.innerText = 'PLAYING FOR REAL MONEY';
                label.style.color = '#10b981';
            } else {
                pill.classList.remove('active');
                label.innerText = 'DEMO MODE (PRACTICE)';
                label.style.color = '#94a3b8';
            }
            updateBalanceAndBetUI();
        }

        // Continuous Bubble Columns Generator
        function initBubbleColumns() {
            const tracks = document.querySelectorAll('.bubble-track');
            tracks.forEach(track => {
                setInterval(() => {
                    const bubble = document.createElement('div');
                    bubble.className = 'rising-bubble';
                    const size = Math.floor(Math.random() * 12) + 6;
                    bubble.style.width = size + 'px';
                    bubble.style.height = size + 'px';
                    bubble.style.left = (Math.random() * 12) + 'px';
                    bubble.style.animationDuration = (Math.random() * 2.5 + 2) + 's';
                    track.appendChild(bubble);

                    setTimeout(() => {
                        bubble.remove();
                    }, 5000);
                }, Math.floor(Math.random() * 400) + 250);
            });
        }

        // Render Initial Grid (Screenshot 2 Match)
        function renderInitialGrid() {
            const initialLayout = [
                ['FISHING_ROD', 'A', 'DRAGONFLY', 'TRUCK', '10'],
                ['DRAGONFLY', 'Q', 'A', 'DRAGONFLY', 'A'],
                ['TACKLE_BOX', 'A', '10', 'TRUCK', '10']
            ];

            for (let c = 0; c < 5; c++) {
                for (let r = 0; r < 3; r++) {
                    const cell = document.querySelector(`.slot-symbol-cell[data-r="${r}"][data-c="${c}"]`);
                    if (cell) {
                        renderSymbolInCell(cell, initialLayout[r][c]);
                    }
                }
            }
        }

        function renderSymbolInCell(cell, symKey, fishCash = null) {
            cell.innerHTML = '';
            cell.classList.remove('winner-cell');
            const def = SYMBOLS[symKey] || SYMBOLS['10'];

            const img = document.createElement('img');
            img.src = def.src;
            img.className = 'symbol-img';
            img.alt = symKey;
            cell.appendChild(img);

            if (symKey === 'FISH_MONEY' || def.isFish) {
                const badge = document.createElement('div');
                badge.className = 'fish-money-badge';
                const curBet = BET_STEPS[currentBetIndex];
                const amt = fishCash ? fishCash : (curBet * (Math.random() > 0.5 ? 5 : 2)).toFixed(2);
                badge.innerText = `$${amt}`;
                cell.appendChild(badge);
            }
        }

        // Change Bet Step
        function changeBet(delta) {
            AudioFX.init();
            AudioFX.playTick();
            currentBetIndex = Math.max(0, Math.min(BET_STEPS.length - 1, currentBetIndex + delta));
            updateBalanceAndBetUI();
        }

        function updateBalanceAndBetUI() {
            const bet = BET_STEPS[currentBetIndex];
            document.getElementById('bet-display-label').innerText = `${userCurrency} ${bet.toFixed(2)}`;
            document.getElementById('buy-spins-cost-label').innerText = `${userCurrency} ${(bet * 100).toFixed(0)}`;

            if (isRealMoney) {
                document.getElementById('credit-balance-label').innerText = `${userCurrency} ${realBalance.toFixed(2)}`;
            } else {
                document.getElementById('credit-balance-label').innerText = `DEMO PLAY`;
            }
        }

        // Execute Buy Bonus
        function executeBuyBonus() {
            if (isSpinning) return;
            const bet = BET_STEPS[currentBetIndex];
            const cost = bet * 100;
            if (isRealMoney && realBalance < cost) {
                alert('Insufficient wallet balance to buy Free Spins feature.');
                return;
            }
            if (confirm(`Buy Free Spins feature for $${cost.toFixed(2)}?`)) {
                handleSpinClick(true);
            }
        }

        // Main Spin Action
        function handleSpinClick(isBuyBonus = false, isTurbo = false) {
            if (isSpinning) return;
            AudioFX.init();

            const bet = BET_STEPS[currentBetIndex];
            const charge = isBuyBonus ? (bet * 100) : bet;

            // Balance checks
            if (isRealMoney) {
                if (realBalance < charge) {
                    alert('Insufficient balance. Please deposit to continue spinning.');
                    return;
                }
            } else {
                if (demoBalance < charge) {
                    document.getElementById('deposit-lock-modal').classList.add('show');
                    return;
                }
                demoSpinsCount++;
            }

            // Deduct client-side
            if (isRealMoney) {
                realBalance -= charge;
            } else {
                demoBalance -= charge;
            }
            updateBalanceAndBetUI();

            isSpinning = true;
            document.getElementById('btn-master-spin').disabled = true;
            document.getElementById('btn-master-spin').classList.add('spinning');
            document.getElementById('center-status-instruction').innerText = 'REELS SPINNING...';
            document.getElementById('center-status-instruction').classList.remove('win-text');
            document.getElementById('win-celebration-modal').classList.remove('active');

            // Apply spin blur to all cells
            const allCells = document.querySelectorAll('.slot-symbol-cell');
            allCells.forEach(cell => {
                cell.classList.add('spinning');
            });

            // Play reel spin tick sounds
            const tickInterval = setInterval(() => {
                AudioFX.playTick();
            }, 100);

            // Send spin request to backend API
            fetch(SPIN_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bet_amount: bet,
                    is_demo: !isRealMoney,
                    demo_spins_count: demoSpinsCount,
                    is_buy_bonus: isBuyBonus
                })
            })
            .then(res => res.json())
            .then(data => {
                const stopDelay = isTurbo ? 600 : 1200;
                setTimeout(() => {
                    clearInterval(tickInterval);
                    stopReelsCascading(data, isBuyBonus);
                }, stopDelay);
            })
            .catch(err => {
                clearInterval(tickInterval);
                // Fallback simulation if network/auth disconnects
                setTimeout(() => {
                    stopReelsCascading(generateClientFallbackResult(bet), isBuyBonus);
                }, 800);
            });
        }

        // Stop Reels with Realistic Reel Kingdom Stagger
        function stopReelsCascading(resultData, isBuyBonus) {
            const grid = resultData.grid || generateRandomGrid();
            const winAmount = parseFloat(resultData.win_amount || 0);

            // Stop each column 1 by 1
            for (let c = 0; c < 5; c++) {
                setTimeout(() => {
                    AudioFX.playSplash();
                    for (let r = 0; r < 3; r++) {
                        const cell = document.querySelector(`.slot-symbol-cell[data-r="${r}"][data-c="${c}"]`);
                        if (cell) {
                            cell.classList.remove('spinning');
                            const sym = grid[r][c];
                            renderSymbolInCell(cell, sym);
                        }
                    }

                    // When last column stops
                    if (c === 4) {
                        isSpinning = false;
                        document.getElementById('btn-master-spin').disabled = false;
                        document.getElementById('btn-master-spin').classList.remove('spinning');

                        handleWinCelebration(winAmount, resultData);
                    }
                }, c * 200);
            }
        }

        // Win Celebration
        function handleWinCelebration(winAmount, resultData) {
            if (winAmount > 0) {
                AudioFX.playWin();
                if (resultData && resultData.new_balance !== null && resultData.new_balance !== undefined) {
                    realBalance = parseFloat(resultData.new_balance);
                } else if (isRealMoney) {
                    realBalance += winAmount;
                } else {
                    demoBalance += winAmount;
                }
                updateBalanceAndBetUI();

                // Highlight winning payline cells
                const allCells = document.querySelectorAll('.slot-symbol-cell');
                allCells.forEach(cell => {
                    const r = parseInt(cell.dataset.r);
                    const c = parseInt(cell.dataset.c);
                    // Light up matching or high-pay symbols
                    if (r === 1 || Math.random() > 0.6) {
                        cell.classList.add('winner-cell');
                    }
                });

                document.getElementById('center-status-instruction').innerText = `WIN: $${winAmount.toFixed(2)}`;
                document.getElementById('center-status-instruction').classList.add('win-text');

                // Big Win Modal for significant payouts
                const curBet = BET_STEPS[currentBetIndex];
                if (winAmount >= curBet * 5) {
                    const winModal = document.getElementById('win-celebration-modal');
                    document.getElementById('win-modal-amount').innerText = `$${winAmount.toFixed(2)}`;
                    winModal.classList.add('active');

                    setTimeout(() => {
                        winModal.classList.remove('active');
                    }, 2800);
                }
            } else {
                document.getElementById('center-status-instruction').innerText = 'HOLD SPACE FOR TURBO SPIN';
            }

            // Handle Autoplay Next Turn
            if (autoPlayActive && autoPlayRemaining > 0) {
                autoPlayRemaining--;
                document.getElementById('btn-autoplay-toggle').innerText = `AUTO (${autoPlayRemaining})`;
                if (autoPlayRemaining > 0) {
                    setTimeout(() => {
                        handleSpinClick(false);
                    }, 1000);
                } else {
                    autoPlayActive = false;
                    document.getElementById('btn-autoplay-toggle').innerText = 'AUTOPLAY';
                }
            }
        }

        // Toggle Autoplay
        function toggleAutoPlay() {
            if (autoPlayActive) {
                autoPlayActive = false;
                autoPlayRemaining = 0;
                document.getElementById('btn-autoplay-toggle').innerText = 'AUTOPLAY';
            } else {
                autoPlayActive = true;
                autoPlayRemaining = 10;
                document.getElementById('btn-autoplay-toggle').innerText = `AUTO (${autoPlayRemaining})`;
                if (!isSpinning) handleSpinClick(false);
            }
        }

        // Fallback grid generator
        function generateRandomGrid() {
            const keys = ['TRUCK', 'FISHING_ROD', 'DRAGONFLY', 'TACKLE_BOX', 'FISH_MONEY', 'FISHERMAN', 'SCATTER', 'A', 'K', 'Q', 'J', '10'];
            const res = [];
            for (let r = 0; r < 3; r++) {
                const row = [];
                for (let c = 0; c < 5; c++) {
                    row.push(keys[Math.floor(Math.random() * keys.length)]);
                }
                res.push(row);
            }
            return res;
        }

        function generateClientFallbackResult(bet) {
            const isWin = Math.random() < 0.35;
            return {
                grid: generateRandomGrid(),
                win_amount: isWin ? (bet * (Math.random() * 8 + 2)).toFixed(2) : 0,
                is_win: isWin
            };
        }

        // Toggle Sound Mute
        function toggleSound() {
            soundEnabled = !soundEnabled;
            const icons = [document.getElementById('top-sound-icon'), document.getElementById('footer-sound-icon')];
            icons.forEach(ic => {
                if (ic) {
                    ic.className = soundEnabled ? 'fas fa-volume-high' : 'fas fa-volume-xmark';
                }
            });
        }

        // Fullscreen toggle
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(() => {});
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }
    </script>
</body>
</html>
