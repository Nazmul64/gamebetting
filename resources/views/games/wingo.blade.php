<!DOCTYPE html>
<html lang="bn" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WinGo Lottery - {{ \App\Models\Setting::getVal('site_title', 'Amar Club') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Roboto+Mono:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Platform Custom CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <style>
        body { 
            background: #091424;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
            min-height: 100vh;
        }

        /* 4 Time Tabs Authentic Styling */
        .wingo-time-tab {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            border: 1.5px solid #eef2f6;
            color: #64748b;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            cursor: pointer;
            border-radius: 14px;
        }
        .wingo-time-tab img {
            width: 26px;
            height: 26px;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .wingo-time-tab:hover:not(.tab-active) {
            background: #f8fafc;
            transform: translateY(-1px);
        }
        .wingo-time-tab.tab-active { 
            background: linear-gradient(180deg, #10b981 0%, #059669 100%) !important; 
            color: #ffffff !important; 
            border-color: #059669 !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4) !important;
            transform: translateY(-1px);
        }
        .wingo-time-tab.tab-active img {
            width: 32px;
            height: 32px;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.25));
        }
        .wingo-time-tab.tab-active span { 
            color: #ffffff !important; 
        }

        /* 3D Glass / Token Number Balls (Amar Club / Tiranga Exact Design) */
        .amar-ball-img-btn {
            position: relative;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            outline: none;
            transition: transform 0.1s ease, opacity 0.1s ease;
            -webkit-user-select: none;
            user-select: none;
        }
        .amar-ball-img-btn img {
            width: 52px;
            height: 52px;
            display: block;
            pointer-events: none;
            user-select: none;
        }
        .amar-ball-img-btn:active {
            transform: scale(0.92);
            opacity: 0.85;
        }

        .amar-ball {
            position: relative;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.15s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15), inset 0 2px 4px rgba(255,255,255,0.7), inset 0 -2px 4px rgba(0,0,0,0.2);
            padding: 3px;
        }
        .amar-ball:hover {
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 6px 14px rgba(0,0,0,0.2);
        }
        .amar-ball:active {
            transform: scale(0.92);
        }
        .amar-ball::before {
            content: '';
            position: absolute;
            top: 1px;
            bottom: 1px;
            left: 50%;
            width: 3px;
            background: rgba(255,255,255,0.45);
            transform: translateX(-50%);
            border-radius: 2px;
            pointer-events: none;
        }
        .amar-ball-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #f1f5f9 90%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 21px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.18), inset 0 1px 2px rgba(0,0,0,0.06);
            z-index: 2;
            position: relative;
        }

        /* Ball Color Variants */
        .ball-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .ball-green .amar-ball-inner {
            color: #059669;
        }

        .ball-red {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        }
        .ball-red .amar-ball-inner {
            color: #e11d48;
        }

        /* 0: Split Red + Violet */
        .ball-split-0 {
            background: linear-gradient(135deg, #f43f5e 50%, #a855f7 50%);
        }
        .ball-split-0 .amar-ball-inner {
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #fdf4ff 90%);
            color: #9333ea;
        }

        /* 5: Split Green + Violet */
        .ball-split-5 {
            background: linear-gradient(135deg, #10b981 50%, #a855f7 50%);
        }
        .ball-split-5 .amar-ball-inner {
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #f0fdf4 90%);
            color: #059669;
        }

        /* Multipliers */
        .mult-active { 
            background: #00b977 !important; 
            color: white !important; 
            border-color: #00b977 !important; 
            box-shadow: 0 2px 8px rgba(0, 185, 119, 0.4);
        }

        /* Ticket cutouts */
        .ticket-cutout {
            position: relative;
        }
        .ticket-cutout::before, .ticket-cutout::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 14px;
            height: 14px;
            background-color: #ffffff;
            border-radius: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .ticket-cutout::before { left: -7px; }
        .ticket-cutout::after { right: -7px; }

        .flip-clock-num {
            background: #ffffff;
            color: #111827;
            font-family: 'Roboto Mono', monospace;
            font-weight: 800;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 30px;
            font-size: 18px;
        }

        /* 5-second countdown overlay */
        .locked-overlay {
            backdrop-filter: blur(6px);
            animation: fadeIn 0.2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes pulseCount {
            0% { transform: scale(0.5); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        .count-pop {
            animation: pulseCount 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Desktop Container & Layout */
        .desktop-bg-pattern {
            background-image: 
                radial-gradient(circle at 20% 15%, rgba(16, 185, 129, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 85%, rgba(14, 165, 233, 0.06) 0%, transparent 40%);
        }
    </style>
</head>
<body class="landing-body theme-Bettingsite-active {{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

    <!-- 1xBet Style Top Navigation Bar (Header) -->
    @include('customer.header')

    <!-- Main Desktop / Large Device Wrapper -->
    <div class="min-h-[calc(100vh-70px)] desktop-bg-pattern py-0 lg:py-6 px-0 lg:px-6 flex flex-col items-center justify-start">
        
        <!-- Breadcrumbs & Quick Header (Visible on Desktop / Large Device) -->
        <div class="w-full max-w-6xl mb-4 hidden lg:flex items-center justify-between text-xs text-slate-400">
            <div class="flex items-center gap-2">
                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="hover:text-emerald-400 transition flex items-center gap-1.5 font-bold">
                    <i class="fas fa-home"></i> Home
                </a>
                <span>/</span>
                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="hover:text-emerald-400 transition">1xGames</a>
                <span>/</span>
                <span class="text-emerald-400 font-bold">Amar Club WinGo Lottery</span>
            </div>
            <div class="flex items-center gap-4 text-slate-300">
                <span class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-emerald-400"></i> Provably Fair 100% Verified</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-bolt text-yellow-400"></i> Instant 24/7 Payouts</span>
            </div>
        </div>

        <!-- Layout Row: [Left Sidebar] [Center Amar Club App] [Right Sidebar] -->
        <div class="w-full max-w-6xl flex justify-center items-start gap-6">

            <!-- LEFT DESKTOP SIDEBAR (Visible on Desktop) -->
            <aside class="hidden lg:flex flex-col gap-4 w-72 shrink-0">
                <!-- Game Info Card -->
                <div class="bg-[#0c1a30] border border-[#1d3354] rounded-2xl p-4 shadow-xl text-slate-200">
                    <div class="flex items-center gap-3 mb-3 pb-3 border-b border-[#1d3354]">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 text-lg shadow-inner">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-sm text-white">Amar Club WinGo</h3>
                            <span class="text-[11px] text-emerald-400 font-semibold">Live Color & Number</span>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between items-center py-1 border-b border-[#1d3354]/50">
                            <span class="text-slate-400">Direct Number</span>
                            <span class="font-bold text-emerald-400">9.0× Payout</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-[#1d3354]/50">
                            <span class="text-slate-400">Violet Color</span>
                            <span class="font-bold text-purple-400">4.5× Payout</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-[#1d3354]/50">
                            <span class="text-slate-400">Green / Red</span>
                            <span class="font-bold text-emerald-400">2.0× Payout</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400">Big (5-9) / Small (0-4)</span>
                            <span class="font-bold text-amber-400">2.0× Payout</span>
                        </div>
                    </div>
                </div>

                <!-- 4 Live Mode Status Card -->
                <div class="bg-[#0c1a30] border border-[#1d3354] rounded-2xl p-4 shadow-xl text-slate-200">
                    <h4 class="text-xs font-black text-white uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-signal text-emerald-400"></i> Active Modes
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div onclick="switchTimeType('30s')" class="cursor-pointer p-2.5 rounded-xl bg-[#142847] hover:bg-[#1a355e] border border-[#1d3354] transition flex items-center justify-between">
                            <span class="font-bold text-white flex items-center gap-2"><i class="fa-solid fa-stopwatch text-emerald-400"></i> WinGo 30sec</span>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">FAST</span>
                        </div>
                        <div onclick="switchTimeType('1m')" class="cursor-pointer p-2.5 rounded-xl bg-[#142847] hover:bg-[#1a355e] border border-[#1d3354] transition flex items-center justify-between">
                            <span class="font-bold text-white flex items-center gap-2"><i class="fa-solid fa-clock text-slate-400"></i> WinGo 1 Min</span>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">POPULAR</span>
                        </div>
                        <div onclick="switchTimeType('3m')" class="cursor-pointer p-2.5 rounded-xl bg-[#142847] hover:bg-[#1a355e] border border-[#1d3354] transition flex items-center justify-between">
                            <span class="font-bold text-white flex items-center gap-2"><i class="fa-solid fa-clock text-slate-400"></i> WinGo 3 Min</span>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30">STANDARD</span>
                        </div>
                        <div onclick="switchTimeType('5m')" class="cursor-pointer p-2.5 rounded-xl bg-[#142847] hover:bg-[#1a355e] border border-[#1d3354] transition flex items-center justify-between">
                            <span class="font-bold text-white flex items-center gap-2"><i class="fa-solid fa-clock text-slate-400"></i> WinGo 5 Min</span>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">CLASSIC</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- CENTER: Pixel-Perfect Amar Club WinGo Mobile-First App Container -->
            <main class="w-full max-w-[430px] bg-white min-h-screen lg:min-h-0 lg:rounded-3xl shadow-2xl flex flex-col relative pb-16 lg:border lg:border-emerald-500/20 overflow-hidden">
                
                <!-- টপ গ্রিন বার ও অমর ক্লাব ব্র্যান্ডিং নেভিগেশন -->
                <div class="bg-gradient-to-b from-[#00b977] to-[#009b64] px-4 pt-3 pb-3 text-white relative">
                    <div class="flex items-center justify-between">
                        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="text-white text-lg p-1 hover:opacity-80 transition" title="Go to Lobby">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                        <div class="flex items-center gap-1.5 font-black text-xl tracking-wider uppercase">
                            @php
                                $customLogo = \App\Models\Setting::getVal('site_logo', '');
                                $siteTitle = \App\Models\Setting::getVal('site_title', 'GAME');
                            @endphp
                            @if(!empty($customLogo))
                                <img src="{{ $customLogo }}" alt="Logo" class="h-6 w-auto object-contain pointer-events-none select-none" draggable="false">
                            @else
                                <i class="fa-solid fa-crown text-yellow-300 text-lg drop-shadow"></i>
                            @endif
                            <span>{{ $siteTitle }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-lg">
                            <button onclick="toggleAudio()" id="audio-toggle-btn" class="hover:text-yellow-200 transition text-white" title="Toggle Sound (Beeps & Fanfares)">
                                <i class="fa-solid fa-volume-high" id="audio-icon"></i>
                            </button>
                            <button onclick="syncState(true)" class="hover:text-yellow-200 transition text-white" title="Refresh Live State">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- নোটিস মার্কার -->
                <div class="px-4 mt-2 z-10">
                    <div class="bg-white rounded-xl px-3 py-2 flex items-center justify-between shadow-sm text-xs text-gray-600 border border-gray-100">
                        <div class="flex items-center gap-2 overflow-hidden">
                            <i class="fa-solid fa-volume-high text-[#00b977] shrink-0"></i>
                            <marquee behavior="scroll" direction="left" scrollamount="4" class="text-[11px] font-semibold text-gray-600">
                                Welcome to {{ $siteTitle }} WinGo Lottery! Win up to 9× on direct number predictions and 4.5× on Violet color!
                            </marquee>
                        </div>
                        <button onclick="openHowToPlay()" class="bg-[#00b977] hover:bg-[#00a167] text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold flex items-center gap-1 shrink-0 ml-1 shadow-sm">
                            <i class="fa-solid fa-fire"></i> Detail
                        </button>
                    </div>
                </div>

                <!-- ৪টি টাইম ফ্রেম ট্যাব (WinGo 30sec, 1 Min, 3 Min, 5 Min) - স্ক্রিনশটের হুবহু ডিজাইন -->
                <div class="grid grid-cols-4 gap-2 px-4 mt-3">
                    <button onclick="switchTimeType('30s')" id="tab-30s" class="wingo-time-tab tab-active flex flex-col items-center justify-center py-2 px-1">
                        <img src="{{ asset('assets/image/wingo/clock-active.png') }}" class="w-8 h-8 object-contain mb-1 drop-shadow-sm pointer-events-none select-none" draggable="false" alt="Clock">
                        <span class="text-[11px] font-extrabold leading-tight text-center">WinGo<br>30sec</span>
                    </button>
                    <button onclick="switchTimeType('1m')" id="tab-1m" class="wingo-time-tab flex flex-col items-center justify-center py-2 px-1">
                        <img src="{{ asset('assets/image/wingo/clock.png') }}" class="w-7 h-7 object-contain mb-1 drop-shadow-sm pointer-events-none select-none" draggable="false" alt="Clock">
                        <span class="text-[11px] font-extrabold leading-tight text-center">WinGo<br>1 Min</span>
                    </button>
                    <button onclick="switchTimeType('3m')" id="tab-3m" class="wingo-time-tab flex flex-col items-center justify-center py-2 px-1">
                        <img src="{{ asset('assets/image/wingo/clock.png') }}" class="w-7 h-7 object-contain mb-1 drop-shadow-sm pointer-events-none select-none" draggable="false" alt="Clock">
                        <span class="text-[11px] font-extrabold leading-tight text-center">WinGo<br>3 Min</span>
                    </button>
                    <button onclick="switchTimeType('5m')" id="tab-5m" class="wingo-time-tab flex flex-col items-center justify-center py-2 px-1">
                        <img src="{{ asset('assets/image/wingo/clock.png') }}" class="w-7 h-7 object-contain mb-1 drop-shadow-sm pointer-events-none select-none" draggable="false" alt="Clock">
                        <span class="text-[11px] font-extrabold leading-tight text-center">WinGo<br>5 Min</span>
                    </button>
                </div>

                <!-- পিরিয়ড ও কাউন্টডাউন টাইমার ডিসপ্লে কার্ড (রিয়েল Amar Club টিকিট ব্যাকগ্রাউন্ড ইমেজ) -->
                <div class="px-4 mt-3">
                    <div class="relative w-full text-white p-3.5 pt-4 pb-3.5 rounded-2xl flex flex-col justify-between shadow-sm" style="background: url('{{ asset('assets/image/wingo/card-bg.png') }}') no-repeat center center / 100% 100%; min-height: 112px;">
                        <div class="flex justify-between items-center mb-2">
                            <button onclick="openHowToPlay()" class="border border-white/70 text-white rounded-full px-2.5 py-0.5 text-[11px] flex items-center gap-1 font-semibold hover:bg-white/10 transition">
                                <i class="fa-solid fa-book-open"></i> How to play
                            </button>
                            <span class="text-xs font-bold text-white/95 flex items-center gap-1">
                                <i class="fa-regular fa-clock"></i> Time remaining
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-xs font-semibold text-white/90 block mb-1" id="current-period-title">WinGo 30sec</span>
                                <!-- বিগত উইনিং বলের ইতিহাস (ডাটাবেস থেকে রিয়েল লাইভ বল লোড হবে) -->
                                <div class="flex gap-1.5 items-center min-h-[24px]" id="mini-balls-history">
                                    <span class="text-[10px] text-white/70 italic">অপেক্ষা করুন...</span>
                                </div>
                            </div>

                            <!-- কাউন্টডাউন টাইমার বক্স -->
                            <div class="text-right">
                                <div class="flex items-center gap-1 text-gray-900 justify-end">
                                    <span class="flip-clock-num" id="timer-m1">0</span>
                                    <span class="flip-clock-num" id="timer-m2">0</span>
                                    <span class="text-white font-black text-base">:</span>
                                    <span class="flip-clock-num" id="timer-s1">0</span>
                                    <span class="flip-clock-num" id="timer-s2">0</span>
                                </div>
                                <span class="text-[11px] font-mono font-bold text-white block mt-1 tracking-wider" id="period-number">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- বেটিং সেকশন র‍্যাপার ও ৫-সেকেন্ড লক কাউন্টডাউন ওভারলে -->
                <div class="relative" id="betting-controls-wrapper">
                    <!-- ৫-সেকেন্ড লক কাউন্টডাউন ওভারলে (Amar Club রিয়েল ডাবল ফ্লিপ কার্ড [ 0 ] [ X ]) -->
                    <div id="locked-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px] rounded-2xl z-30 flex items-center justify-center hidden p-4 transition-opacity duration-200">
                        <div class="flex items-center justify-center gap-3.5 select-none pointer-events-none">
                            <!-- Tens Digit Card (0) -->
                            <div class="w-[110px] h-[155px] bg-white rounded-[22px] shadow-2xl flex items-center justify-center relative overflow-hidden border border-white/70">
                                <span id="lock-count-tens" class="text-8xl font-black text-[#00b977] leading-none tracking-tight font-sans">0</span>
                                <!-- Middle crease line -->
                                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-[2px] bg-slate-200/90 shadow-inner"></div>
                            </div>
                            <!-- Units Digit Card (5..0) -->
                            <div class="w-[110px] h-[155px] bg-white rounded-[22px] shadow-2xl flex items-center justify-center relative overflow-hidden border border-white/70">
                                <span id="lock-count-units" class="text-8xl font-black text-[#00b977] leading-none tracking-tight font-sans">5</span>
                                <!-- Middle crease line -->
                                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-[2px] bg-slate-200/90 shadow-inner"></div>
                            </div>
                        </div>
                    </div>

                    <!-- কালার বেটিং বাটন (Green, Violet, Red) -->
                    <div class="grid grid-cols-3 gap-3 px-4 mt-3">
                        <button onclick="openBetModal('color', 'green')" class="bg-[#00b977] hover:bg-[#00a66b] text-white py-2.5 rounded-xl font-extrabold text-sm shadow-sm active:scale-95 transition text-center">Green</button>
                        <button onclick="openBetModal('color', 'violet')" class="bg-[#b55fe6] hover:bg-[#a24fd3] text-white py-2.5 rounded-xl font-extrabold text-sm shadow-sm active:scale-95 transition text-center">Violet</button>
                        <button onclick="openBetModal('color', 'red')" class="bg-[#ff4757] hover:bg-[#ee3b4c] text-white py-2.5 rounded-xl font-extrabold text-sm shadow-sm active:scale-95 transition text-center">Red</button>
                    </div>

                    <!-- ০ থেকে ৯ নম্বর গ্রিড (স্ক্রিনশটের রিয়েল ৩ডি বল ইমেজ) -->
                    <div class="px-3 mt-2">
                        <div class="bg-[#f8f9fd] rounded-2xl p-2.5 border border-gray-100 shadow-inner">
                            <div class="grid grid-cols-5 gap-x-1 gap-y-1.5 justify-items-center items-center">
                                <!-- ০: স্প্লিট রেড ও ভায়োলেট -->
                                <button onclick="openBetModal('number', '0')" class="amar-ball-img-btn" title="Bet on 0 (Violet & Red - 9× / 4.5×)">
                                    <img src="{{ asset('assets/image/wingo/n0.png') }}" draggable="false" alt="0">
                                </button>

                                <!-- ১: গ্রিন -->
                                <button onclick="openBetModal('number', '1')" class="amar-ball-img-btn" title="Bet on 1 (Green - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n1.png') }}" draggable="false" alt="1">
                                </button>

                                <!-- ২: রেড -->
                                <button onclick="openBetModal('number', '2')" class="amar-ball-img-btn" title="Bet on 2 (Red - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n2.png') }}" draggable="false" alt="2">
                                </button>

                                <!-- ৩: গ্রিন -->
                                <button onclick="openBetModal('number', '3')" class="amar-ball-img-btn" title="Bet on 3 (Green - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n3.png') }}" draggable="false" alt="3">
                                </button>

                                <!-- ৪: রেড -->
                                <button onclick="openBetModal('number', '4')" class="amar-ball-img-btn" title="Bet on 4 (Red - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n4.png') }}" draggable="false" alt="4">
                                </button>

                                <!-- ৫: স্প্লিট গ্রিন ও ভায়োলেট -->
                                <button onclick="openBetModal('number', '5')" class="amar-ball-img-btn" title="Bet on 5 (Violet & Green - 9× / 4.5×)">
                                    <img src="{{ asset('assets/image/wingo/n5.png') }}" draggable="false" alt="5">
                                </button>

                                <!-- ৬: রেড -->
                                <button onclick="openBetModal('number', '6')" class="amar-ball-img-btn" title="Bet on 6 (Red - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n6.png') }}" draggable="false" alt="6">
                                </button>

                                <!-- ৭: গ্রিন -->
                                <button onclick="openBetModal('number', '7')" class="amar-ball-img-btn" title="Bet on 7 (Green - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n7.png') }}" draggable="false" alt="7">
                                </button>

                                <!-- ৮: রেড -->
                                <button onclick="openBetModal('number', '8')" class="amar-ball-img-btn" title="Bet on 8 (Red - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n8.png') }}" draggable="false" alt="8">
                                </button>

                                <!-- ৯: গ্রিন -->
                                <button onclick="openBetModal('number', '9')" class="amar-ball-img-btn" title="Bet on 9 (Green - 9×)">
                                    <img src="{{ asset('assets/image/wingo/n9.png') }}" draggable="false" alt="9">
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- মাল্টিপ্লায়ার বাটন (Random, X1, X5, X10, X20, X50, X100) -->
                    <div class="px-4 mt-3">
                        <div class="flex items-center gap-1.5 overflow-x-auto py-1 scrollbar-none">
                            <button onclick="pickRandomBet()" class="px-3 py-1 bg-white rounded-lg text-xs font-bold text-red-500 border border-red-200 shrink-0 hover:bg-red-50 transition active:scale-95 shadow-sm">Random</button>
                            <button onclick="setMultiplier(1)" id="m-1" class="mult-btn mult-active px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X1</button>
                            <button onclick="setMultiplier(5)" id="m-5" class="mult-btn px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X5</button>
                            <button onclick="setMultiplier(10)" id="m-10" class="mult-btn px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X10</button>
                            <button onclick="setMultiplier(20)" id="m-20" class="mult-btn px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X20</button>
                            <button onclick="setMultiplier(50)" id="m-50" class="mult-btn px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X50</button>
                            <button onclick="setMultiplier(100)" id="m-100" class="mult-btn px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 border border-gray-200 shrink-0">X100</button>
                        </div>
                    </div>

                    <!-- Big / Small বাটন (Amar Club Seamless 50/50 Rounded-Full Bar) -->
                    <div class="px-4 mt-2">
                        <div class="flex rounded-full overflow-hidden shadow-sm">
                            <button onclick="openBetModal('size', 'big')" class="w-1/2 bg-[#ffa502] hover:brightness-105 active:opacity-95 text-white py-2.5 font-black text-sm transition text-center">Big</button>
                            <button onclick="openBetModal('size', 'small')" class="w-1/2 bg-[#6c5ce7] hover:brightness-105 active:opacity-95 text-white py-2.5 font-black text-sm transition text-center">Small</button>
                        </div>
                    </div>
                </div>

                <!-- গেম হিস্ট্রি, চার্ট এবং মাই হিস্ট্রি ট্যাব -->
                <div class="px-4 mt-4 flex-1">
                    <div class="grid grid-cols-3 gap-2 bg-[#f4f5f7] p-1 rounded-xl text-xs font-bold text-gray-500 mb-3">
                        <button onclick="switchHistoryTab('game')" id="tab-btn-game" class="py-2.5 rounded-lg bg-[#00b977] text-white shadow-sm transition font-bold">Game history</button>
                        <button onclick="switchHistoryTab('chart')" id="tab-btn-chart" class="py-2.5 rounded-lg bg-white text-gray-600 hover:text-gray-900 transition font-semibold">Chart</button>
                        <button onclick="switchHistoryTab('my')" id="tab-btn-my" class="py-2.5 rounded-lg bg-white text-gray-600 hover:text-gray-900 transition font-semibold">My history</button>
                    </div>

                    <!-- Game History Table -->
                    <div id="section-game-history">
                        <div class="overflow-hidden rounded-xl border border-gray-100 shadow-sm bg-white">
                            <table class="w-full text-center text-xs">
                                <thead>
                                    <tr class="bg-[#00b977] text-white font-bold tracking-wide">
                                        <th class="py-2.5 px-2">Period</th>
                                        <th class="py-2.5 px-2">Number</th>
                                        <th class="py-2.5 px-2">Big Small</th>
                                        <th class="py-2.5 px-2">Color</th>
                                    </tr>
                                </thead>
                                <tbody id="history-tbody" class="divide-y divide-gray-100 text-gray-700 font-medium bg-white">
                                    <!-- Dynamic history items loaded via JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Dynamic Interactive Pagination -->
                        <div class="flex items-center justify-center gap-4 mt-3 text-xs font-bold text-gray-600">
                            <button onclick="changeHistoryPage(-1)" id="history-prev-btn" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-600 transition active:scale-95"><i class="fa-solid fa-chevron-left text-[11px]"></i></button>
                            <span id="history-page-indicator" class="font-mono text-gray-700 font-bold px-2">1/1</span>
                            <button onclick="changeHistoryPage(1)" id="history-next-btn" class="w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center hover:bg-[#00a66b] transition active:scale-95 shadow-sm"><i class="fa-solid fa-chevron-right text-[11px]"></i></button>
                        </div>
                    </div>

                    <!-- Chart Section (Amar Club Authentic Trend Chart) -->
                    <div id="section-chart" class="hidden">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden text-xs">
                            
                            <!-- Green Table Header -->
                            <div class="bg-[#00b977] text-white font-bold grid grid-cols-12 py-2 px-3 text-center">
                                <div class="col-span-5 text-left pl-1">Period</div>
                                <div class="col-span-7">Number</div>
                            </div>

                            <!-- 100 Periods Statistics Box -->
                            <div class="p-3 bg-gray-50/70 border-b border-gray-100 text-[11px] space-y-1.5 text-gray-600">
                                <div class="text-[11px] font-bold text-gray-500 mb-1">Statistic (last 100 Periods)</div>
                                <div class="grid grid-cols-12 items-center text-center">
                                    <span class="col-span-4 text-left font-bold text-gray-700">Winning Numbers</span>
                                    <div class="col-span-8 grid grid-cols-10 gap-0.5 justify-items-center">
                                        <span class="w-4 h-4 rounded-full border border-purple-400 text-purple-600 flex items-center justify-center text-[9px] font-bold">0</span>
                                        <span class="w-4 h-4 rounded-full border border-emerald-400 text-emerald-600 flex items-center justify-center text-[9px] font-bold">1</span>
                                        <span class="w-4 h-4 rounded-full border border-red-400 text-red-600 flex items-center justify-center text-[9px] font-bold">2</span>
                                        <span class="w-4 h-4 rounded-full border border-emerald-400 text-emerald-600 flex items-center justify-center text-[9px] font-bold">3</span>
                                        <span class="w-4 h-4 rounded-full border border-red-400 text-red-600 flex items-center justify-center text-[9px] font-bold">4</span>
                                        <span class="w-4 h-4 rounded-full border border-purple-400 text-purple-600 flex items-center justify-center text-[9px] font-bold">5</span>
                                        <span class="w-4 h-4 rounded-full border border-red-400 text-red-600 flex items-center justify-center text-[9px] font-bold">6</span>
                                        <span class="w-4 h-4 rounded-full border border-emerald-400 text-emerald-600 flex items-center justify-center text-[9px] font-bold">7</span>
                                        <span class="w-4 h-4 rounded-full border border-red-400 text-red-600 flex items-center justify-center text-[9px] font-bold">8</span>
                                        <span class="w-4 h-4 rounded-full border border-emerald-400 text-emerald-600 flex items-center justify-center text-[9px] font-bold">9</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 items-center text-center">
                                    <span class="col-span-4 text-left font-medium text-gray-500">Missing</span>
                                    <div class="col-span-8 grid grid-cols-10 text-[10px] text-gray-500 font-mono" id="stat-missing"></div>
                                </div>
                                <div class="grid grid-cols-12 items-center text-center">
                                    <span class="col-span-4 text-left font-medium text-gray-500">Avg missing</span>
                                    <div class="col-span-8 grid grid-cols-10 text-[10px] text-gray-500 font-mono" id="stat-avg-missing"></div>
                                </div>
                                <div class="grid grid-cols-12 items-center text-center">
                                    <span class="col-span-4 text-left font-medium text-gray-500">Frequency</span>
                                    <div class="col-span-8 grid grid-cols-10 text-[10px] text-gray-500 font-mono" id="stat-frequency"></div>
                                </div>
                                <div class="grid grid-cols-12 items-center text-center">
                                    <span class="col-span-4 text-left font-medium text-gray-500">Max consecutive</span>
                                    <div class="col-span-8 grid grid-cols-10 text-[10px] text-gray-500 font-mono" id="stat-consecutive"></div>
                                </div>
                            </div>

                            <!-- Trend Chart Rows Container with SVG Polyline overlay -->
                            <div class="relative" id="trend-chart-wrapper">
                                <svg class="absolute inset-0 pointer-events-none z-10 w-full h-full" id="trend-chart-svg"></svg>
                                <div class="divide-y divide-gray-100" id="trend-chart-rows">
                                    <!-- Dynamic rows loaded via JS -->
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="flex items-center justify-center gap-4 py-3 bg-gray-50/50 border-t border-gray-100 text-xs font-bold text-gray-600">
                                <button onclick="changeChartPage(-1)" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-600 transition"><i class="fa-solid fa-chevron-left text-[11px]"></i></button>
                                <span class="font-mono text-gray-700 font-bold px-2" id="chart-page-indicator">1/1</span>
                                <button onclick="changeChartPage(1)" class="w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center hover:bg-[#00a66b] transition shadow-sm"><i class="fa-solid fa-chevron-right text-[11px]"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- মাই হিস্ট্রি সেকশন (Amar Club Authentic Accordion Cards) -->
                    <div id="section-my-history" class="hidden">
                        <div class="space-y-2.5" id="my-history-list">
                            <!-- Dynamic Accordion Cards loaded via JS -->
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex items-center justify-center gap-4 mt-4 text-xs font-bold text-gray-600">
                            <button onclick="changeMyHistoryPage(-1)" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-600 transition"><i class="fa-solid fa-chevron-left text-[11px]"></i></button>
                            <span class="font-mono text-gray-700 font-bold px-2" id="my-page-indicator">1/1</span>
                            <button onclick="changeMyHistoryPage(1)" class="w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center hover:bg-[#00a66b] transition shadow-sm"><i class="fa-solid fa-chevron-right text-[11px]"></i></button>
                        </div>
                    </div>
                </div>

            </main>

            <!-- RIGHT DESKTOP SIDEBAR (Visible on Desktop) -->
            <aside class="hidden lg:flex flex-col gap-4 w-72 shrink-0">
                <!-- Real-time Live Winners Feed -->
                <div class="bg-[#0c1a30] border border-[#1d3354] rounded-2xl p-4 shadow-xl text-slate-200">
                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-[#1d3354]">
                        <h4 class="text-xs font-black text-white uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-trophy text-amber-400"></i> Live Winners
                        </h4>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    </div>
                    <div class="space-y-2.5 text-xs" id="desktop-live-winners">
                        <div class="p-2 rounded-xl bg-[#142847] border border-[#1d3354] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[10px]">U</span>
                                <div>
                                    <div class="font-bold text-white text-[11px]">User***842</div>
                                    <div class="text-[10px] text-slate-400">WinGo 30sec</div>
                                </div>
                            </div>
                            <span class="font-extrabold text-emerald-400 text-xs">+৳ 1,800.00</span>
                        </div>
                        <div class="p-2 rounded-xl bg-[#142847] border border-[#1d3354] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold text-[10px]">K</span>
                                <div>
                                    <div class="font-bold text-white text-[11px]">User***109</div>
                                    <div class="text-[10px] text-slate-400">WinGo 1 Min</div>
                                </div>
                            </div>
                            <span class="font-extrabold text-purple-400 text-xs">+৳ 4,500.00</span>
                        </div>
                        <div class="p-2 rounded-xl bg-[#142847] border border-[#1d3354] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center font-bold text-[10px]">M</span>
                                <div>
                                    <div class="font-bold text-white text-[11px]">User***671</div>
                                    <div class="text-[10px] text-slate-400">WinGo 30sec</div>
                                </div>
                            </div>
                            <span class="font-extrabold text-emerald-400 text-xs">+৳ 900.00</span>
                        </div>
                    </div>
                </div>

                <!-- Live Sound & Controls Info -->
                <div class="bg-[#0c1a30] border border-[#1d3354] rounded-2xl p-4 shadow-xl text-slate-200">
                    <h4 class="text-xs font-black text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-volume-high text-emerald-400"></i> Audio & Beeps
                    </h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed mb-3">
                        শেষ ৫ সেকেন্ডে কাউন্টডাউন টিক বিপিং এবং রাউন্ড শেষে জয়ী নম্বরের সাথে স্বয়ংক্রিয় ভিক্টরি ফ্যানফেয়ার সাউন্ড চালু থাকে।
                    </p>
                    <button onclick="toggleAudio()" class="w-full py-2 bg-[#142847] hover:bg-[#1d375f] text-white rounded-xl text-xs font-bold border border-[#1d3354] transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-sliders"></i> Sound Settings
                    </button>
                </div>
            </aside>

        </div>
    </div>

    <!-- Bet Modal (Amar Club Authentic Pixel-Perfect Modal) -->
    <div id="bet-modal" class="fixed inset-0 bg-black/65 backdrop-blur-[1px] z-50 flex items-end justify-center hidden transition-opacity duration-200" onclick="if(event.target === this) closeBetModal()">
        <div class="bg-white w-full max-w-[430px] rounded-t-3xl overflow-hidden shadow-2xl animate-slide-up select-none">
            
            <!-- Dynamic Colored Header with Triangle Chevron Slope (Image 1 & 2 exact look) -->
            <div id="modal-header-bg" class="text-white pt-4 pb-7 px-4 text-center relative transition-colors duration-200" style="background-color: #6ba5fe; clip-path: polygon(0 0, 100% 0, 100% 75%, 50% 100%, 0 75%);">
                <h3 class="font-bold text-sm text-white/95 mb-2 tracking-wide" id="modal-game-title">WinGo 30sec</h3>
                <div class="bg-white rounded-md py-1.5 px-6 mx-auto inline-block shadow-sm">
                    <span id="modal-selection-text" class="text-xs font-black text-gray-800 tracking-wide">Select Small</span>
                </div>
            </div>

            <!-- Modal Content Body -->
            <div class="p-4 pt-3 space-y-4">
                <!-- Balance Row -->
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-800">Balance</span>
                    <div class="flex gap-2">
                        <button onclick="setBaseAmount(1)" id="b-1" class="amt-pill px-3.5 py-1 rounded-md text-xs font-bold text-white shadow-sm transition" style="background-color: #6ba5fe;">1</button>
                        <button onclick="setBaseAmount(10)" id="b-10" class="amt-pill px-3.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">10</button>
                        <button onclick="setBaseAmount(100)" id="b-100" class="amt-pill px-3.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">100</button>
                        <button onclick="setBaseAmount(1000)" id="b-1000" class="amt-pill px-3.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">1000</button>
                    </div>
                </div>

                <!-- Quantity Row -->
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-800">Quantity</span>
                    <div class="flex items-center">
                        <button onclick="adjustMultiplier(-1)" id="qty-minus-btn" class="w-8 h-8 rounded-md text-white font-black text-lg flex items-center justify-center active:scale-95 transition shadow-sm" style="background-color: #6ba5fe;">-</button>
                        <div class="w-28 h-8 bg-gray-100 mx-1.5 rounded-md flex items-center justify-center">
                            <input type="number" id="multiplier-input" value="1" min="1" max="500" onchange="onManualMultiplierChange(this.value)" class="w-full text-center font-bold text-sm text-gray-800 bg-transparent focus:outline-none">
                        </div>
                        <button onclick="adjustMultiplier(1)" id="qty-plus-btn" class="w-8 h-8 rounded-md text-white font-black text-lg flex items-center justify-center active:scale-95 transition shadow-sm" style="background-color: #6ba5fe;">+</button>
                    </div>
                </div>

                <!-- Multiplier Pills Row -->
                <div class="flex items-center justify-end gap-1.5 pt-1">
                    <button onclick="setMultiplier(1)" id="m-1" class="mult-pill px-2.5 py-1 rounded-md text-xs font-bold text-white shadow-sm transition" style="background-color: #6ba5fe;">X1</button>
                    <button onclick="setMultiplier(5)" id="m-5" class="mult-pill px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">X5</button>
                    <button onclick="setMultiplier(10)" id="m-10" class="mult-pill px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">X10</button>
                    <button onclick="setMultiplier(20)" id="m-20" class="mult-pill px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">X20</button>
                    <button onclick="setMultiplier(50)" id="m-50" class="mult-pill px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">X50</button>
                    <button onclick="setMultiplier(100)" id="m-100" class="mult-pill px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">X100</button>
                </div>

                <!-- I agree check row -->
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="agree-rules" checked class="w-4 h-4 rounded cursor-pointer accent-[#00b977]">
                    <label for="agree-rules" class="text-xs text-gray-600 cursor-pointer flex items-center gap-1">
                        <span class="text-[#00b977] font-bold">✔</span> I agree <span class="text-red-500 font-medium hover:underline cursor-pointer" onclick="openHowToPlay()">《Pre-sale rules》</span>
                    </label>
                </div>
            </div>

            <!-- Bottom Action Buttons: Cancel & Total amount -->
            <div class="flex border-t border-gray-100 mt-2">
                <button onclick="closeBetModal()" class="w-1/3 py-3.5 bg-[#f8f9fa] hover:bg-gray-100 text-gray-600 text-center font-bold text-sm transition">
                    Cancel
                </button>
                <button onclick="submitWingoBet()" id="confirm-bet-btn" class="w-2/3 py-3.5 text-white text-center font-black text-sm tracking-wide transition active:brightness-95" style="background-color: #6ba5fe;">
                    Total amount ৳<span id="btn-total-display">1.00</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ডিপোজিট পপ-আপ (ডেমো লিমিট শেষ হলে) -->
    <div id="deposit-modal" class="fixed inset-0 bg-black/75 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl p-6 text-center max-w-xs w-full shadow-2xl border border-gray-100 transform transition">
            <div class="w-14 h-14 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-3 text-yellow-500 text-2xl border border-yellow-100">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h4 class="font-black text-lg text-gray-800 mb-1">ডেমো লিমিট শেষ!</h4>
            <p class="text-xs text-gray-500 mb-5 leading-relaxed">
                আপনার ফ্রি ট্রায়াল সম্পন্ন হয়েছে। আসল টাকা দিয়ে খেলে লাভজনক পে-আউট ও উইন টাকা সাথে সাথে তুলতে এখনই ডিপোজিট করুন।
            </p>
            <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="block w-full bg-gradient-to-r from-[#00b977] to-[#009b64] text-white font-bold py-3 rounded-full text-sm shadow-lg mb-2 hover:brightness-105 transition">
                ডিপোজিট করুন
            </a>
            <button onclick="closeDepositModal()" class="text-xs text-gray-400 font-semibold py-1 hover:text-gray-600 transition">
                পরে করব
            </button>
        </div>
    </div>

    <!-- How to play Modal (Authentic WinGo Rules) -->
    <div id="howto-modal" class="fixed inset-0 bg-black/75 z-50 flex items-center justify-center hidden p-4 backdrop-blur-sm" onclick="if(event.target === this) closeHowToPlay()">
        <div class="bg-white rounded-3xl max-w-sm w-full shadow-2xl overflow-hidden animate-fade-in flex flex-col max-h-[85vh]">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#00b977] to-[#009b64] text-white px-5 py-4 flex justify-between items-center relative shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-yellow-300 text-base"></i>
                    <h3 class="font-extrabold text-sm text-white tracking-wide uppercase" id="howto-modal-title">WinGo 30s Rules</h3>
                </div>
                <button onclick="closeHowToPlay()" class="w-7 h-7 rounded-full bg-black/20 hover:bg-black/30 text-white flex items-center justify-center transition text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="p-4 overflow-y-auto space-y-3 text-xs text-gray-700 leading-relaxed custom-scrollbar">
                
                <!-- Period & Issue Rules Box -->
                <div class="bg-emerald-50/80 border border-emerald-200/90 rounded-2xl p-3.5 shadow-sm">
                    <p class="font-semibold text-emerald-950 leading-snug text-[11.5px]" id="howto-issue-summary">
                        30 seconds 1 issue, 25 seconds to order, 5 seconds waiting for the draw.. It opens all day. The total number of trade is 2880 issues.
                    </p>
                </div>

                <!-- Contract Amount & Service Fee Explanation -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 shadow-sm">
                    <p class="text-gray-800 font-medium leading-relaxed text-[11.5px]">
                        If you spend <span class="font-bold text-emerald-700">100</span> to trade, after deducting <span class="font-bold text-red-500">2</span> service fee, your contract amount is <span class="font-bold text-gray-900">98</span>:
                    </p>
                </div>

                <!-- Payout Rules List -->
                <div class="space-y-2.5">
                    <!-- Rule 1: Green -->
                    <div class="bg-green-50/80 border border-green-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-green-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>
                            1. Select green:
                        </div>
                        <p class="text-green-950 pl-4 leading-relaxed text-[11px]">
                            if the result shows <span class="font-bold text-green-800">1,3,7,9</span> you will get <span class="font-bold text-green-800">(98*2) 196</span>;<br>
                            If the result shows <span class="font-bold text-green-800">5</span>, you will get <span class="font-bold text-green-800">(98*1.5) 147</span>
                        </p>
                    </div>

                    <!-- Rule 2: Red -->
                    <div class="bg-red-50/80 border border-red-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-red-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                            2. Select red:
                        </div>
                        <p class="text-red-950 pl-4 leading-relaxed text-[11px]">
                            if the result shows <span class="font-bold text-red-800">2,4,6,8</span> you will get <span class="font-bold text-red-800">(98*2) 196</span>;<br>
                            If the result shows <span class="font-bold text-red-800">0</span>, you will get <span class="font-bold text-red-800">(98*1.5) 147</span>
                        </p>
                    </div>

                    <!-- Rule 3: Violet -->
                    <div class="bg-purple-50/80 border border-purple-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-purple-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 inline-block"></span>
                            3. Select violet:
                        </div>
                        <p class="text-purple-950 pl-4 leading-relaxed text-[11px]">
                            if the result shows <span class="font-bold text-purple-800">0 or 5</span>, you will get <span class="font-bold text-purple-800">(98*4.5) 441</span>
                        </p>
                    </div>

                    <!-- Rule 4: Number -->
                    <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-amber-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                            4. Select number:
                        </div>
                        <p class="text-amber-950 pl-4 leading-relaxed text-[11px]">
                            if the result is the same as the number you selected, you will get <span class="font-bold text-amber-800">(98*9) 882</span>
                        </p>
                    </div>

                    <!-- Rule 5: Big -->
                    <div class="bg-orange-50/80 border border-orange-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-orange-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500 inline-block"></span>
                            5. Select big:
                        </div>
                        <p class="text-orange-950 pl-4 leading-relaxed text-[11px]">
                            if the result shows <span class="font-bold text-orange-800">5,6,7,8,9</span> you will get <span class="font-bold text-orange-800">(98 * 2) 196</span>
                        </p>
                    </div>

                    <!-- Rule 6: Small -->
                    <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-3">
                        <div class="flex items-center gap-1.5 font-bold text-blue-800 mb-1 text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                            6. Select small:
                        </div>
                        <p class="text-blue-950 pl-4 leading-relaxed text-[11px]">
                            if the result shows <span class="font-bold text-blue-800">0,1,2,3,4</span> you will get <span class="font-bold text-blue-800">(98 * 2) 196</span>
                        </p>
                    </div>
                </div>

                <!-- Footer Note -->
                <p class="text-[10.5px] text-gray-400 italic text-center pt-1">
                    * The last 5 seconds of every issue will lock orders to prepare for the draw.
                </p>
            </div>

            <!-- Modal Footer Button -->
            <div class="p-3 border-t border-gray-100 bg-gray-50">
                <button onclick="closeHowToPlay()" class="w-full bg-gradient-to-r from-[#00b977] to-[#009b64] hover:brightness-105 text-white font-extrabold py-2.5 rounded-2xl text-xs shadow-md transition active:scale-[0.99]">
                    I Understand
                </button>
            </div>
        </div>
    </div>

    <!-- গেম সাউন্ড সিন্থেসাইজার ও ক্লায়েন্ট ইঞ্জিন -->
    <script>
        // How to play modal open / close
        function openHowToPlay() {
            const timeConfig = {
                '30s': {
                    title: 'WinGo 30s Rules',
                    summary: '30 seconds 1 issue, 25 seconds to order, 5 seconds waiting for the draw.. It opens all day. The total number of trade is 2880 issues.'
                },
                '1m': {
                    title: 'WinGo 1 Min Rules',
                    summary: '1 minute 1 issue, 55 seconds to order, 5 seconds waiting for the draw.. It opens all day. The total number of trade is 1440 issues.'
                },
                '3m': {
                    title: 'WinGo 3 Min Rules',
                    summary: '3 minutes 1 issue, 2 minutes and 55 seconds to order, 5 seconds waiting for the draw.. It opens all day. The total number of trade is 480 issues.'
                },
                '5m': {
                    title: 'WinGo 5 Min Rules',
                    summary: '5 minutes 1 issue, 4 minutes and 55 seconds to order, 5 seconds waiting for the draw.. It opens all day. The total number of trade is 288 issues.'
                }
            };

            const cfg = timeConfig[currentTimeType] || timeConfig['30s'];
            const titleEl = document.getElementById('howto-modal-title');
            const summaryEl = document.getElementById('howto-issue-summary');
            if (titleEl) titleEl.innerText = cfg.title;
            if (summaryEl) summaryEl.innerText = cfg.summary;

            const modal = document.getElementById('howto-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeHowToPlay() {
            const modal = document.getElementById('howto-modal');
            if (modal) modal.classList.add('hidden');
        }

        // Web Audio API Synthesizer (Instant high-fidelity browser audio)
        let audioCtx = null;
        let soundEnabled = true;

        function initAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
        }

        function playTone(freq, type, duration, delay = 0) {
            if (!soundEnabled) return;
            try {
                initAudio();
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = type;
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime + delay);
                gain.gain.setValueAtTime(0.18, audioCtx.currentTime + delay);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + delay + duration);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start(audioCtx.currentTime + delay);
                osc.stop(audioCtx.currentTime + delay + duration);
            } catch (e) {}
        }

        // Escalating countdown sound for 5, 4, 3, 2, 1
        function playCountdownTick(remainingSec) {
            if (!soundEnabled) return;
            const pitchMap = {
                5: 620,
                4: 740,
                3: 880,
                2: 1040,
                1: 1250
            };
            const freq = pitchMap[remainingSec] || 800;
            playTone(freq, 'sine', 0.12);
        }

        function playBetSound() {
            playTone(440, 'triangle', 0.08);
            playTone(660, 'triangle', 0.12, 0.06);
        }

        function playWinSound() {
            playTone(523.25, 'sine', 0.12, 0.0);
            playTone(659.25, 'sine', 0.12, 0.1);
            playTone(783.99, 'sine', 0.20, 0.2);
            playTone(1046.50, 'sine', 0.35, 0.3);
        }

        function toggleAudio() {
            soundEnabled = !soundEnabled;
            const icon = document.getElementById('audio-icon');
            if (soundEnabled) {
                icon.className = 'fa-solid fa-volume-high';
                playTone(880, 'sine', 0.1);
            } else {
                icon.className = 'fa-solid fa-volume-xmark text-gray-300';
            }
        }

        // গেম স্টেট ভেরিয়েবল
        let currentTimeType = '30s';
        let currentMultiplier = 1;
        let baseAmount = 1;
        let selectedBetType = null;
        let selectedValue = null;
        let isDemoMode = false;
        let demoBetsCount = 0;
        let lastPeriodNumber = null;
        let isLocked = false;
        let localRemainingSeconds = 0;
        let timerInterval = null;

        const clockActiveUrl = "{{ asset('assets/image/wingo/clock-active.png') }}";
        const clockInactiveUrl = "{{ asset('assets/image/wingo/clock.png') }}";

        const timeTitles = { 
            '30s': 'WinGo 30sec', 
            '1m': 'WinGo 1 Min', 
            '3m': 'WinGo 3 Min', 
            '5m': 'WinGo 5 Min' 
        };

        function switchTimeType(type) {
            currentTimeType = type;
            document.querySelectorAll('.wingo-time-tab').forEach(t => {
                t.classList.remove('tab-active');
                const img = t.querySelector('img');
                if (img) img.src = clockInactiveUrl;
            });
            const activeTab = document.getElementById(`tab-${type}`);
            if (activeTab) {
                activeTab.classList.add('tab-active');
                const activeImg = activeTab.querySelector('img');
                if (activeImg) activeImg.src = clockActiveUrl;
            }
            
            document.getElementById('current-period-title').innerText = timeTitles[type] || 'WinGo 30sec';
            document.getElementById('modal-title').innerText = timeTitles[type] || 'WinGo 30sec';
            syncState(true);
        }

        function toggleMode() {
            isDemoMode = !isDemoMode;
            const label = document.getElementById('mode-label');
            const btn = document.getElementById('mode-btn');
            if (isDemoMode) {
                label.innerText = 'DEMO MODE';
                btn.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300 hover:bg-amber-200 transition';
                document.getElementById('wallet-balance').innerText = '৳ 1,000.00 (Demo)';
            } else {
                label.innerText = 'REAL MONEY';
                btn.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition';
                syncState(true);
            }
        }

        const themeMap = {
            'red': { bg: '#ff4d4f', title: 'Select Red' },
            'green': { bg: '#00b977', title: 'Select Green' },
            'violet': { bg: '#b55fe6', title: 'Select Violet' },
            'big': { bg: '#ffa502', title: 'Select Big' },
            'small': { bg: '#6ba5fe', title: 'Select Small' },
            '0': { bg: '#b55fe6', title: 'Select 0' },
            '1': { bg: '#00b977', title: 'Select 1' },
            '2': { bg: '#ff4d4f', title: 'Select 2' },
            '3': { bg: '#00b977', title: 'Select 3' },
            '4': { bg: '#ff4d4f', title: 'Select 4' },
            '5': { bg: '#00b977', title: 'Select 5' },
            '6': { bg: '#ff4d4f', title: 'Select 6' },
            '7': { bg: '#00b977', title: 'Select 7' },
            '8': { bg: '#ff4d4f', title: 'Select 8' },
            '9': { bg: '#00b977', title: 'Select 9' }
        };
        let currentModalTheme = '#6ba5fe';

        function setMultiplier(val) {
            currentMultiplier = Math.max(1, parseInt(val) || 1);
            const input = document.getElementById('multiplier-input');
            if (input) input.value = currentMultiplier;
            refreshModalPills();
            updateTotalBet();
        }

        function adjustMultiplier(delta) {
            let nextVal = currentMultiplier + delta;
            if (nextVal < 1) nextVal = 1;
            setMultiplier(nextVal);
        }

        function onManualMultiplierChange(val) {
            setMultiplier(parseInt(val) || 1);
        }

        function setBaseAmount(val) {
            baseAmount = val;
            refreshModalPills();
            updateTotalBet();
        }

        function refreshModalPills() {
            // Balance buttons
            document.querySelectorAll('.amt-pill').forEach(b => {
                b.style.backgroundColor = '#f3f4f6';
                b.style.color = '#4b5563';
                b.classList.remove('font-bold', 'text-white', 'shadow-sm');
                b.classList.add('font-semibold');
            });
            const activeAmt = document.getElementById(`b-${baseAmount}`);
            if (activeAmt) {
                activeAmt.style.backgroundColor = currentModalTheme;
                activeAmt.style.color = '#ffffff';
                activeAmt.classList.add('font-bold', 'text-white', 'shadow-sm');
                activeAmt.classList.remove('font-semibold');
            }

            // Multiplier pills
            document.querySelectorAll('.mult-pill').forEach(b => {
                b.style.backgroundColor = '#f3f4f6';
                b.style.color = '#4b5563';
                b.classList.remove('font-bold', 'text-white', 'shadow-sm');
                b.classList.add('font-semibold');
            });
            const activeMult = document.getElementById(`m-${currentMultiplier}`);
            if (activeMult) {
                activeMult.style.backgroundColor = currentModalTheme;
                activeMult.style.color = '#ffffff';
                activeMult.classList.add('font-bold', 'text-white', 'shadow-sm');
                activeMult.classList.remove('font-semibold');
            }
        }

        function updateTotalBet() {
            const total = (baseAmount * currentMultiplier).toFixed(2);
            const btnTotal = document.getElementById('btn-total-display');
            if (btnTotal) btnTotal.innerText = total;
        }

        function pickRandomBet() {
            const randomNum = Math.floor(Math.random() * 10);
            openBetModal('number', randomNum.toString());
        }

        function openBetModal(type, val) {
            if (isLocked) {
                alert('সময় শেষ! ফলাফল প্রসেস হচ্ছে, পরবর্তী রাউন্ডের জন্য অপেক্ষা করুন।');
                return;
            }
            initAudio();
            playTone(550, 'sine', 0.05);
            selectedBetType = type;
            selectedValue = val;
            
            const theme = themeMap[val] || { bg: '#00b977', title: 'Select ' + String(val).toUpperCase() };
            currentModalTheme = theme.bg;

            const gTitle = document.getElementById('modal-game-title');
            if (gTitle) gTitle.innerText = timeTitles[currentTimeType] || 'WinGo 30sec';
            
            const sText = document.getElementById('modal-selection-text');
            if (sText) sText.innerText = theme.title;
            
            // Header coloring
            const headerBg = document.getElementById('modal-header-bg');
            if (headerBg) headerBg.style.backgroundColor = theme.bg;
            
            // Quantity buttons coloring
            const qMinus = document.getElementById('qty-minus-btn');
            if (qMinus) qMinus.style.backgroundColor = theme.bg;
            
            const qPlus = document.getElementById('qty-plus-btn');
            if (qPlus) qPlus.style.backgroundColor = theme.bg;

            // Submit button coloring
            const confirmBtn = document.getElementById('confirm-bet-btn');
            if (confirmBtn) confirmBtn.style.backgroundColor = theme.bg;

            refreshModalPills();
            updateTotalBet();
            document.getElementById('bet-modal').classList.remove('hidden');
        }

        function closeBetModal() {
            document.getElementById('bet-modal').classList.add('hidden');
        }

        function openHowToPlay() {
            document.getElementById('howto-modal').classList.remove('hidden');
        }

        function closeDepositModal() {
            document.getElementById('deposit-modal').classList.add('hidden');
        }

        function switchHistoryTab(tab) {
            document.getElementById('section-game-history').classList.add('hidden');
            document.getElementById('section-chart').classList.add('hidden');
            document.getElementById('section-my-history').classList.add('hidden');

            ['game', 'chart', 'my'].forEach(t => {
                const btn = document.getElementById(`tab-btn-${t}`);
                if (btn) {
                    btn.className = 'py-2.5 rounded-lg bg-white text-gray-600 hover:text-gray-900 transition font-semibold shadow-none';
                }
            });

            const activeBtn = document.getElementById(`tab-btn-${tab}`);
            if (activeBtn) {
                activeBtn.className = 'py-2.5 rounded-lg bg-[#00b977] text-white shadow-sm transition font-bold';
            }

            if (tab === 'game') {
                document.getElementById('section-game-history').classList.remove('hidden');
            } else if (tab === 'chart') {
                document.getElementById('section-chart').classList.remove('hidden');
            } else if (tab === 'my') {
                document.getElementById('section-my-history').classList.remove('hidden');
                loadMyHistory();
            }
        }

        // Countdown display & Lock Handler
        function handleCountdownDisplay(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            const mStr = String(m).padStart(2, '0');
            const sStr = String(s).padStart(2, '0');

            const tm1 = document.getElementById('timer-m1');
            const tm2 = document.getElementById('timer-m2');
            const ts1 = document.getElementById('timer-s1');
            const ts2 = document.getElementById('timer-s2');
            if (tm1) tm1.innerText = mStr[0];
            if (tm2) tm2.innerText = mStr[1];
            if (ts1) ts1.innerText = sStr[0];
            if (ts2) ts2.innerText = sStr[1];

            const overlay = document.getElementById('locked-overlay');
            const tensEl = document.getElementById('lock-count-tens');
            const unitsEl = document.getElementById('lock-count-units');

            if (seconds <= 5 && seconds > 0) {
                isLocked = true;
                if (overlay) overlay.classList.remove('hidden');
                if (tensEl) tensEl.innerText = '0';
                if (unitsEl) unitsEl.innerText = seconds;
                closeBetModal();
                playCountdownTick(seconds);
            } else if (seconds === 0) {
                isLocked = true;
                if (overlay) overlay.classList.remove('hidden');
                if (tensEl) tensEl.innerText = '0';
                if (unitsEl) unitsEl.innerText = '0';
            } else {
                isLocked = false;
                if (overlay) overlay.classList.add('hidden');
            }
        }

        // Live Server State Synchronization
        function syncState(force = false) {
            fetch(`{{ route('wingo.state') }}?type=${currentTimeType}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                if (!data) return;

                const pNum = document.getElementById('period-number');
                if (pNum) pNum.innerText = data.period_number;

                if (lastPeriodNumber && lastPeriodNumber !== data.period_number) {
                    playWinSound();
                    if (document.getElementById('section-my-history') && !document.getElementById('section-my-history').classList.contains('hidden')) {
                        loadMyHistory();
                    }
                }
                lastPeriodNumber = data.period_number;

                localRemainingSeconds = Math.max(0, parseInt(data.time_remaining) || 0);
                handleCountdownDisplay(localRemainingSeconds);

                if (!isDemoMode && data.user_balance !== null && data.user_balance !== undefined) {
                    const bal = document.getElementById('wallet-balance');
                    if (bal) bal.innerText = '৳ ' + parseFloat(data.user_balance).toFixed(2);
                }

                if (data.history && Array.isArray(data.history)) {
                    renderMiniBalls(data.history);
                    renderHistory(data.history);
                    renderChart(data.history);
                }
            })
            .catch(err => console.error(err));
        }

        // Mini Balls history in ticket card (Only real completed periods)
        function renderMiniBalls(list) {
            const container = document.getElementById('mini-balls-history');
            if (!container) return;
            if (!list || list.length === 0) {
                container.innerHTML = '<span class="text-[10px] text-white/70 italic">নতুন পিরিয়ড চলমান...</span>';
                return;
            }

            let html = '';
            list.slice(0, 5).forEach(item => {
                const num = item.winning_number;
                if (num !== null && num !== undefined && num >= 0 && num <= 9) {
                    html += `<img src="{{ asset('assets/image/wingo') }}/n${num}.png" class="w-6 h-6 object-contain drop-shadow pointer-events-none select-none" draggable="false" alt="${num}">`;
                }
            });
            if (html !== '') {
                container.innerHTML = html;
            } else {
                container.innerHTML = '<span class="text-[10px] text-white/70 italic">নতুন পিরিয়ড চলমান...</span>';
            }
        }

        // ==========================================
        // 1. GAME HISTORY TAB
        // ==========================================
        let currentHistoryList = [];
        let currentHistoryPage = 1;
        const historyPerPage = 10;

        function renderHistory(list) {
            if (list && Array.isArray(list)) currentHistoryList = list;
            const tbody = document.getElementById('history-tbody');
            if (!currentHistoryList || currentHistoryList.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="py-8 text-center text-gray-400 font-medium text-xs">কোনো গেম হিস্ট্রি পাওয়া যায়নি</td></tr>';
                return;
            }

            const totalPages = Math.max(1, Math.ceil(currentHistoryList.length / historyPerPage));
            if (currentHistoryPage > totalPages) currentHistoryPage = totalPages;
            if (currentHistoryPage < 1) currentHistoryPage = 1;

            const pageIndicator = document.getElementById('history-page-indicator');
            if (pageIndicator) pageIndicator.innerText = `${currentHistoryPage}/${totalPages}`;

            const prevBtn = document.getElementById('history-prev-btn');
            if (prevBtn) {
                if (currentHistoryPage <= 1) {
                    prevBtn.className = 'w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 cursor-not-allowed';
                } else {
                    prevBtn.className = 'w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-700 transition active:scale-95 shadow-sm';
                }
            }

            const nextBtn = document.getElementById('history-next-btn');
            if (nextBtn) {
                if (currentHistoryPage >= totalPages) {
                    nextBtn.className = 'w-8 h-8 rounded-lg bg-emerald-300 text-white flex items-center justify-center cursor-not-allowed';
                } else {
                    nextBtn.className = 'w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center hover:bg-[#00a66b] transition active:scale-95 shadow-sm';
                }
            }

            const startIndex = (currentHistoryPage - 1) * historyPerPage;
            const pageItems = currentHistoryList.slice(startIndex, startIndex + historyPerPage);

            let html = '';
            pageItems.forEach(item => {
                const periodNum = String(item.period_number);
                const num = item.winning_number;
                
                let numHtml = '-';
                if (num !== null && num !== undefined) {
                    if (num === 0) {
                        numHtml = `<span class="text-xl font-black" style="background: linear-gradient(135deg, #ef4444 50%, #b55fe6 50%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">0</span>`;
                    } else if (num === 5) {
                        numHtml = `<span class="text-xl font-black" style="background: linear-gradient(135deg, #00b977 50%, #b55fe6 50%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">5</span>`;
                    } else if (num % 2 === 0) {
                        numHtml = `<span class="text-xl font-black text-[#ef4444]">${num}</span>`;
                    } else {
                        numHtml = `<span class="text-xl font-black text-[#00b977]">${num}</span>`;
                    }
                }

                const sizeText = item.winning_size || (num >= 5 ? 'Big' : 'Small');

                let dotHtml = '';
                if (num === 0 || item.winning_color === 'red+violet') {
                    dotHtml = `<div class="flex items-center justify-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-[#ef4444] inline-block shadow-sm"></span><span class="w-3.5 h-3.5 rounded-full bg-[#b55fe6] inline-block shadow-sm"></span></div>`;
                } else if (num === 5 || item.winning_color === 'green+violet') {
                    dotHtml = `<div class="flex items-center justify-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-[#00b977] inline-block shadow-sm"></span><span class="w-3.5 h-3.5 rounded-full bg-[#b55fe6] inline-block shadow-sm"></span></div>`;
                } else if (num % 2 === 0 || item.winning_color === 'red') {
                    dotHtml = `<span class="w-3.5 h-3.5 rounded-full bg-[#ef4444] inline-block shadow-sm"></span>`;
                } else {
                    dotHtml = `<span class="w-3.5 h-3.5 rounded-full bg-[#00b977] inline-block shadow-sm"></span>`;
                }

                html += `
                    <tr class="hover:bg-gray-50/80 transition border-b border-gray-100 last:border-b-0">
                        <td class="py-3 px-2 font-mono font-medium text-xs text-gray-900">${periodNum}</td>
                        <td class="py-3 px-2 text-center">${numHtml}</td>
                        <td class="py-3 px-2 text-xs font-medium text-gray-700">${sizeText}</td>
                        <td class="py-3 px-2 text-center">${dotHtml}</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        function changeHistoryPage(direction) {
            const totalPages = Math.max(1, Math.ceil(currentHistoryList.length / historyPerPage));
            const newPage = currentHistoryPage + direction;
            if (newPage >= 1 && newPage <= totalPages) {
                currentHistoryPage = newPage;
                renderHistory();
            }
        }

        // ==========================================
        // 2. TREND CHART TAB (Amar Club Authentic Matrix & SVG Line)
        // ==========================================
        let currentChartList = [];
        let currentChartPage = 1;
        const chartPerPage = 10;

        function renderChart(list) {
            if (list && Array.isArray(list)) currentChartList = list;

            const fillStatRow = (elId, arr) => {
                const el = document.getElementById(elId);
                if (!el) return;
                el.innerHTML = arr.map(v => `<span class="inline-block">${v}</span>`).join('');
            };

            if (!currentChartList || currentChartList.length === 0) {
                fillStatRow('stat-missing', [0,0,0,0,0,0,0,0,0,0]);
                fillStatRow('stat-avg-missing', [0,0,0,0,0,0,0,0,0,0]);
                fillStatRow('stat-frequency', [0,0,0,0,0,0,0,0,0,0]);
                fillStatRow('stat-consecutive', [0,0,0,0,0,0,0,0,0,0]);
                const container = document.getElementById('trend-chart-rows');
                if (container) container.innerHTML = '<div class="py-10 text-center text-gray-400 font-medium text-xs">কোনো চার্ট হিস্ট্রি পাওয়া যায়নি</div>';
                const svg = document.getElementById('trend-chart-svg');
                if (svg) svg.innerHTML = '';
                return;
            }

            // 100 Periods Statistics Calculation
            const statList = currentChartList.slice(0, 100);
            const missing = [0,0,0,0,0,0,0,0,0,0];
            const avgMissing = [0,0,0,0,0,0,0,0,0,0];
            const frequency = [0,0,0,0,0,0,0,0,0,0];
            const maxConsecutive = [0,0,0,0,0,0,0,0,0,0];

            for (let num = 0; num <= 9; num++) {
                // Missing: index of first occurrence
                let firstIdx = -1;
                for (let i = 0; i < statList.length; i++) {
                    if (statList[i].winning_number === num) {
                        firstIdx = i;
                        break;
                    }
                }
                missing[num] = firstIdx === -1 ? statList.length : firstIdx;

                // Frequency & Consecutive
                let freq = 0;
                let currentConsec = 0;
                let maxConsec = 0;
                let lastSeenIdx = -1;
                let totalGaps = 0;
                let gapCount = 0;

                for (let i = 0; i < statList.length; i++) {
                    if (statList[i].winning_number === num) {
                        freq++;
                        currentConsec++;
                        if (currentConsec > maxConsec) maxConsec = currentConsec;
                        if (lastSeenIdx !== -1) {
                            totalGaps += (i - lastSeenIdx - 1);
                            gapCount++;
                        }
                        lastSeenIdx = i;
                    } else {
                        currentConsec = 0;
                    }
                }
                frequency[num] = freq;
                maxConsecutive[num] = maxConsec;
                avgMissing[num] = freq > 0 ? Math.floor((statList.length - freq) / freq) : statList.length;
            }

            // Fill Statistics Rows
            fillStatRow('stat-missing', missing);
            fillStatRow('stat-avg-missing', avgMissing);
            fillStatRow('stat-frequency', frequency);
            fillStatRow('stat-consecutive', maxConsecutive);

            // Render Chart Grid Rows
            renderChartRows();
        }

        function renderChartRows() {
            const container = document.getElementById('trend-chart-rows');
            if (!container || !currentChartList || currentChartList.length === 0) return;

            const totalPages = Math.max(1, Math.ceil(currentChartList.length / chartPerPage));
            if (currentChartPage > totalPages) currentChartPage = totalPages;
            if (currentChartPage < 1) currentChartPage = 1;

            const pageIndicator = document.getElementById('chart-page-indicator');
            if (pageIndicator) pageIndicator.innerText = `${currentChartPage}/${totalPages}`;

            const startIndex = (currentChartPage - 1) * chartPerPage;
            const pageItems = currentChartList.slice(startIndex, startIndex + chartPerPage);

            let html = '';
            pageItems.forEach((item, rowIdx) => {
                const periodNum = String(item.period_number);
                const winNum = item.winning_number;
                const isBig = winNum >= 5;

                let colsHtml = '';
                for (let col = 0; col <= 9; col++) {
                    if (col === winNum) {
                        // Colored Winning Ball
                        let ballBg = 'bg-[#ff4757] text-white';
                        if (col === 1 || col === 3 || col === 7 || col === 9) {
                            ballBg = 'bg-[#00b977] text-white';
                        } else if (col === 0) {
                            ballBg = 'bg-gradient-to-tr from-[#b55fe6] to-[#ff4757] text-white';
                        } else if (col === 5) {
                            ballBg = 'bg-gradient-to-tr from-[#00b977] to-[#b55fe6] text-white';
                        }
                        colsHtml += `<span class="trend-ball w-4 h-4 rounded-full ${ballBg} font-black flex items-center justify-center text-[10px] shadow-sm" data-row="${rowIdx}" data-num="${col}">${col}</span>`;
                    } else {
                        // Inactive Hollow Number
                        colsHtml += `<span class="w-4 h-4 rounded-full border border-gray-200 text-gray-400 font-medium flex items-center justify-center text-[9px]">${col}</span>`;
                    }
                }

                const sizeBadge = isBig 
                    ? `<span class="w-4 h-4 rounded-full bg-[#ffa502] text-white font-black flex items-center justify-center text-[9px] shadow-sm">B</span>`
                    : `<span class="w-4 h-4 rounded-full bg-[#6ba5fe] text-white font-black flex items-center justify-center text-[9px] shadow-sm">S</span>`;

                html += `
                    <div class="grid grid-cols-12 items-center py-2.5 px-3 text-center border-b border-gray-100 last:border-b-0 hover:bg-gray-50/70 transition">
                        <div class="col-span-5 text-left font-mono font-medium text-[11px] text-gray-800 pl-1">${periodNum}</div>
                        <div class="col-span-7 flex items-center justify-between gap-0.5">
                            <div class="grid grid-cols-10 gap-0.5 flex-1 justify-items-center items-center">
                                ${colsHtml}
                            </div>
                            <div class="ml-2">
                                ${sizeBadge}
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;

            // Draw connecting SVG trend line between winning balls
            setTimeout(drawTrendLine, 50);
        }

        function drawTrendLine() {
            const svg = document.getElementById('trend-chart-svg');
            const wrapper = document.getElementById('trend-chart-wrapper');
            if (!svg || !wrapper) return;

            const balls = wrapper.querySelectorAll('.trend-ball');
            if (!balls || balls.length < 2) {
                svg.innerHTML = '';
                return;
            }

            const wrapperRect = wrapper.getBoundingClientRect();
            const points = [];

            balls.forEach(ball => {
                const rect = ball.getBoundingClientRect();
                const x = (rect.left + rect.width / 2) - wrapperRect.left;
                const y = (rect.top + rect.height / 2) - wrapperRect.top;
                points.push(`${x},${y}`);
            });

            svg.setAttribute('width', wrapperRect.width);
            svg.setAttribute('height', wrapperRect.height);
            svg.setAttribute('viewBox', `0 0 ${wrapperRect.width} ${wrapperRect.height}`);

            let circlesHtml = points.map(p => {
                const [cx, cy] = p.split(',');
                return `<circle cx="${cx}" cy="${cy}" r="2" fill="#ff4757" opacity="0.9" />`;
            }).join('');

            svg.innerHTML = `
                <polyline points="${points.join(' ')}" stroke="#ff4757" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity="0.85"/>
                ${circlesHtml}
            `;
        }

        window.addEventListener('resize', drawTrendLine);

        function changeChartPage(direction) {
            const totalPages = Math.max(1, Math.ceil(currentChartList.length / chartPerPage));
            const newPage = currentChartPage + direction;
            if (newPage >= 1 && newPage <= totalPages) {
                currentChartPage = newPage;
                renderChartRows();
            }
        }

        // ==========================================
        // 3. MY HISTORY TAB (Amar Club Accordion Cards)
        // ==========================================
        let currentMyBetsList = [];
        let currentMyBetsPage = 1;
        const myBetsPerPage = 10;

        function loadMyHistory() {
            fetch(`{{ route('wingo.myhistory') }}?type=${currentTimeType}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                const bets = data.bets || data || [];
                currentMyBetsList = bets;
                renderMyHistory();
            })
            .catch(e => console.error(e));
        }

        function renderMyHistory() {
            const container = document.getElementById('my-history-list');
            if (!container) return;

            if (!currentMyBetsList || currentMyBetsList.length === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-2 text-gray-400 text-xl">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">কোনো বেট রেকর্ড নেই</p>
                    </div>
                `;
                return;
            }

            const totalPages = Math.max(1, Math.ceil(currentMyBetsList.length / myBetsPerPage));
            if (currentMyBetsPage > totalPages) currentMyBetsPage = totalPages;
            if (currentMyBetsPage < 1) currentMyBetsPage = 1;

            const pageIndicator = document.getElementById('my-page-indicator');
            if (pageIndicator) pageIndicator.innerText = `${currentMyBetsPage}/${totalPages}`;

            const startIndex = (currentMyBetsPage - 1) * myBetsPerPage;
            const pageItems = currentMyBetsList.slice(startIndex, startIndex + myBetsPerPage);

            let html = '';
            pageItems.forEach((bet, idx) => {
                const betVal = String(bet.selected_value || bet.bet_value || '').toLowerCase();
                const periodNum = bet.period ? bet.period.period_number : (bet.period_number || bet.period_id);
                const orderNumber = `WG${periodNum}${bet.id}`;
                const amount = parseFloat(bet.total_amount || bet.amount || 0);
                const multiplier = bet.multiplier || 1;
                const tax = (amount * 0.02);
                const afterTax = (amount - tax);
                const isWon = bet.status === 'won';
                const isLost = bet.status === 'lost';
                const isPending = !isWon && !isLost;

                // Color Theme based on bet
                let badgeBg = '#6ba5fe';
                let badgeText = betVal.toUpperCase();
                if (betVal === 'green') { badgeBg = '#00b977'; }
                else if (betVal === 'violet') { badgeBg = '#b55fe6'; }
                else if (betVal === 'red') { badgeBg = '#ff4757'; }
                else if (betVal === 'big') { badgeBg = '#ffa502'; badgeText = 'Big'; }
                else if (betVal === 'small') { badgeBg = '#6ba5fe'; badgeText = 'Small'; }
                else {
                    badgeBg = '#00b977';
                    if (['0','2','4','6','8'].includes(betVal)) badgeBg = '#ff4757';
                    if (['0','5'].includes(betVal)) badgeBg = '#b55fe6';
                    badgeText = betVal;
                }

                // Result display
                let resultText = '-';
                if (bet.period && bet.period.winning_number !== null && bet.period.winning_number !== undefined) {
                    resultText = `${bet.period.winning_number} ${bet.period.winning_color || ''} ${bet.period.winning_size || ''}`;
                }

                // Status badges
                let statusBadge = `<button class="border border-amber-400 text-amber-500 rounded px-2.5 py-0.5 text-[11px] font-bold">Pending</button>`;
                let winLossText = '';
                if (isWon) {
                    statusBadge = `<button class="border border-[#00b977] text-[#00b977] rounded px-2.5 py-0.5 text-[11px] font-bold">Succeed</button>`;
                    winLossText = `<span class="text-[#00b977] font-extrabold text-xs block text-right mt-0.5">+৳${parseFloat(bet.win_amount || amount * 1.96).toFixed(2)}</span>`;
                } else if (isLost) {
                    statusBadge = `<button class="border border-[#ff4757] text-[#ff4757] rounded px-2.5 py-0.5 text-[11px] font-bold">Failed</button>`;
                    winLossText = `<span class="text-[#ff4757] font-extrabold text-xs block text-right mt-0.5">-৳${amount.toFixed(2)}</span>`;
                }

                const cardId = `bet-card-${bet.id || idx}`;

                html += `
                    <div class="bg-white rounded-2xl p-3.5 border border-gray-100 shadow-sm transition">
                        <!-- Top Summary Row -->
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleBetDetails('${cardId}')">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl text-white font-black flex items-center justify-center text-xs shadow-sm capitalize shrink-0" style="background-color: ${badgeBg};">
                                    ${badgeText}
                                </div>
                                <div>
                                    <div class="font-mono font-bold text-xs text-gray-800 flex items-center gap-1">
                                        ${periodNum} <i class="fa-solid fa-caret-down text-gray-400 text-[10px] transition-transform duration-200" id="${cardId}-caret"></i>
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-medium">
                                        ${bet.created_at ? new Date(bet.created_at).toISOString().replace('T', ' ').slice(0, 19) : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                ${statusBadge}
                                ${winLossText}
                            </div>
                        </div>

                        <!-- Collapsible Details Box (Amar Club Exact Spec) -->
                        <div id="${cardId}-details" class="hidden mt-3 pt-3 border-t border-gray-100 text-[11px] space-y-2 text-gray-600 bg-gray-50/60 p-3 rounded-xl">
                            <div class="flex justify-between items-center mb-1">
                                <h5 class="font-black text-gray-800 text-xs">Details</h5>
                                <button onclick="toggleBetDetails('${cardId}')" class="border border-[#00b977] text-[#00b977] rounded-full px-2 py-0.2 text-[10px] font-bold flex items-center gap-1 hover:bg-[#00b977]/10 transition">
                                    Detail <i class="fa-solid fa-chevron-right text-[8px]"></i>
                                </button>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Order number</span>
                                <div class="flex items-center gap-1 font-mono text-gray-800 font-bold text-[10px]">
                                    <span>${orderNumber}</span>
                                    <button onclick="copyToClipboard('${orderNumber}')" class="text-gray-400 hover:text-gray-700 ml-1" title="Copy Order ID">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Period</span>
                                <span class="font-mono font-bold text-gray-800">${periodNum}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Purchase amount</span>
                                <span class="font-bold text-gray-800">৳${amount.toFixed(2)}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Quantity</span>
                                <span class="font-bold text-gray-800">${multiplier}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Amount after tax</span>
                                <span class="font-bold text-[#ff4757]">৳${afterTax.toFixed(2)}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Tax</span>
                                <span class="font-bold text-gray-800">৳${tax.toFixed(2)}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Result</span>
                                <span class="font-bold text-gray-800">${resultText}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Select</span>
                                <span class="font-bold text-gray-800 capitalize">${betVal}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Status</span>
                                <span class="font-bold ${isWon ? 'text-[#00b977]' : (isLost ? 'text-[#ff4757]' : 'text-amber-500')} capitalize">${bet.status || 'Pending'}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Win/lose</span>
                                <span class="font-black ${isWon ? 'text-[#00b977]' : 'text-[#ff4757]'}">${isWon ? '+৳' + parseFloat(bet.win_amount || 0).toFixed(2) : '-৳' + amount.toFixed(2)}</span>
                            </div>

                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-500">Order time</span>
                                <span class="text-gray-700 font-mono text-[10px]">${bet.created_at ? new Date(bet.created_at).toISOString().replace('T', ' ').slice(0, 19) : ''}</span>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function toggleBetDetails(cardId) {
            const details = document.getElementById(`${cardId}-details`);
            const caret = document.getElementById(`${cardId}-caret`);
            if (details) {
                const isHidden = details.classList.contains('hidden');
                if (isHidden) {
                    details.classList.remove('hidden');
                    if (caret) caret.style.transform = 'rotate(180deg)';
                } else {
                    details.classList.add('hidden');
                    if (caret) caret.style.transform = 'rotate(0deg)';
                }
            }
        }

        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Order number copied: ' + text);
                }).catch(() => {
                    alert('Order number: ' + text);
                });
            } else {
                const input = document.createElement('input');
                input.value = text;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                alert('Order number copied: ' + text);
            }
        }

        function changeMyHistoryPage(direction) {
            const totalPages = Math.max(1, Math.ceil(currentMyBetsList.length / myBetsPerPage));
            const newPage = currentMyBetsPage + direction;
            if (newPage >= 1 && newPage <= totalPages) {
                currentMyBetsPage = newPage;
                renderMyHistory();
            }
        }

        // ==========================================
        // 4. BET SUBMISSION
        // ==========================================
        function submitWingoBet() {
            if (isLocked) {
                alert('বেটিং লক হয়ে গেছে! নতুন রাউন্ড শুরু হওয়ার জন্য অপেক্ষা করুন।');
                return;
            }

            if (isDemoMode) {
                demoBetsCount++;
                if (demoBetsCount > 5) {
                    closeBetModal();
                    document.getElementById('deposit-modal').classList.remove('hidden');
                    return;
                }
                playBetSound();
                closeBetModal();
                alert(`ডেমো বেট সফল হয়েছে! (ট্রায়াল ${demoBetsCount}/5)`);
                return;
            }

            const btn = document.getElementById('confirm-bet-btn');
            btn.disabled = true;
            btn.innerText = 'Processing...';

            fetch("{{ route('wingo.bet') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    time_type: currentTimeType,
                    bet_type: selectedBetType,
                    selected_value: selectedValue,
                    amount: (baseAmount * currentMultiplier),
                    multiplier: currentMultiplier
                })
            })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = `Total amount ৳<span id="btn-total-display">${(baseAmount * currentMultiplier).toFixed(2)}</span>`;
                
                if (res.success) {
                    playBetSound();
                    closeBetModal();
                    if (res.new_balance !== undefined) {
                        document.getElementById('wallet-balance').innerText = '৳ ' + parseFloat(res.new_balance).toFixed(2);
                    }
                    alert(res.message || 'বেট সফল হয়েছে!');
                    syncState(true);
                } else {
                    if (res.need_deposit) {
                        closeBetModal();
                        document.getElementById('deposit-modal').classList.remove('hidden');
                    } else {
                        alert(res.message || res.error || 'বেট সম্পন্ন করা যায়নি');
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = `Total amount ৳<span id="btn-total-display">${(baseAmount * currentMultiplier).toFixed(2)}</span>`;
                console.error(err);
                alert('নেটওয়ার্ক সমস্যার কারণে বেট সম্পন্ন করা যায়নি। আবার চেষ্টা করুন।');
            });
        }

        // Countdown second interval
        setInterval(() => {
            if (localRemainingSeconds > 0) {
                localRemainingSeconds--;
                handleCountdownDisplay(localRemainingSeconds);
            }
        }, 1000);

        // Server polling loop
        setInterval(() => {
            syncState();
        }, 2500);

        // Initial fetch on page load
        document.addEventListener('DOMContentLoaded', () => {
            syncState(true);
        });
    </script>
</body>
</html>
