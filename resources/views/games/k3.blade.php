<!DOCTYPE html>
<html lang="bn" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>K3 Lottery - {{ \App\Models\Setting::getVal('site_title', 'Amar Club') }}</title>
    
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

        .k3-time-card {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        .k3-time-card.active { 
            background: #00b977 !important;
            border-color: #00b977 !important;
            color: #ffffff !important; 
            box-shadow: 0 4px 12px rgba(0, 185, 119, 0.35);
        }
        .cat-tab-active {
            background: #00b977 !important;
            color: white !important;
            box-shadow: 0 2px 8px rgba(0, 185, 119, 0.3);
        }
        .mult-active { 
            background: #00b977 !important; 
            color: white !important; 
            border-color: #00b977 !important; 
        }
        
        /* 3D Dice Display Box */
        .K3TL__C-l3 {
            height: 125px;
            margin-top: 12px;
            background: #00b977;
            border-radius: 12px;
            position: relative;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 185, 119, 0.2);
        }
        .K3TL__C-l3 .box {
            background: #003c26;
            border-radius: 8px;
            height: 100%;
            width: 100%;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            gap: 8px;
        }
        /* Left & Right Triangular pointer notches pointing inward */
        .K3TL__C-l3 .box::before {
            content: "";
            position: absolute;
            left: -2px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-left: 16px solid #00b977;
            z-index: 10;
        }
        .K3TL__C-l3 .box::after {
            content: "";
            position: absolute;
            right: -2px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-right: 16px solid #00b977;
            z-index: 10;
        }
        .K3TL__C-l3 .box > div {
            width: calc((100% - 16px) / 3);
            height: 100%;
            background-color: #555555;
            background: linear-gradient(180deg, #606060 0%, #454545 100%);
            border-radius: 8px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);
        }
        .K3TL__C-l3 .box > div img {
            width: 70%;
            height: 70%;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.4));
        }

        /* Dynamic Dice Shuffling Effect */
        .dice-rolling {
            animation: diceShuffle 0.15s infinite alternate ease-in-out;
        }
        @keyframes diceShuffle {
            0% { transform: translateY(-2px) scale(0.98); }
            100% { transform: translateY(2px) scale(1.02); }
        }

        /* Chart styling */
        .chart-cell {
            min-width: 22px;
            height: 24px;
            font-size: 10px;
            font-weight: 700;
        }
        .chart-active {
            background: #ff4d4f;
            color: white;
            border-radius: 9999px;
            box-shadow: 0 2px 4px rgba(255, 77, 79, 0.4);
        }

        .desktop-bg-pattern {
            background-color: #091424;
            background-image: 
                radial-gradient(circle at 20% 15%, rgba(16, 185, 129, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 85%, rgba(14, 165, 233, 0.06) 0%, transparent 40%);
        }
    </style>
</head>
<body class="landing-body theme-Bettingsite-active {{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

    <!-- 1xBet / Platform Style Top Header Navigation -->
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
                <span class="text-emerald-400 font-bold">Amar Club K3 Fast 3 Lottery</span>
            </div>
            <div class="flex items-center gap-4 text-slate-300">
                <span class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-emerald-400"></i> Provably Fair 100% Verified</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-bolt text-yellow-400"></i> Instant 24/7 Payouts</span>
            </div>
        </div>

        <!-- Center Phone Screen Container -->
        <div class="w-full max-w-[430px] bg-white min-h-[90vh] shadow-2xl flex flex-col relative pb-56 lg:rounded-3xl lg:border lg:border-slate-800/80 overflow-hidden">
            
            <!-- Top Green Header Bar -->
            <div class="bg-gradient-to-b from-[#00b977] to-[#009b63] px-4 pt-3.5 pb-3.5 text-white">
                <div class="flex items-center justify-between">
                    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="text-white text-lg p-1 hover:opacity-80 transition flex items-center justify-center">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                    <div class="flex items-center gap-1.5 font-black text-lg tracking-wider drop-shadow-sm uppercase">
                        <i class="fa-solid fa-crown text-yellow-300"></i> {{ \App\Models\Setting::getVal('site_title', 'GAME') }}
                    </div>
                    <div class="flex items-center gap-3.5 text-lg">
                        <button onclick="toggleAudioMute()" id="audio-toggle-btn" class="hover:opacity-80 transition p-1" title="Sound Effects">
                            <i class="fa-solid fa-volume-high" id="audio-icon"></i>
                        </button>
                        <button onclick="switchBottomTab('my_history')" class="hover:opacity-80 transition p-1" title="My Bet History">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Notification Ticker with Detail Button -->
            <div class="px-4 mt-3">
                <div class="bg-white rounded-xl px-3 py-2 flex items-center justify-between shadow-xs text-xs text-gray-600 border border-gray-100">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <i class="fa-solid fa-volume-high text-[#00b977] shrink-0"></i>
                        <span class="truncate text-[11px] font-medium">AMAR CLUB family. We sincerely invite you to join our VIP club.</span>
                    </div>
                    <button type="button" onclick="openMyHistoryDetailModal()" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold shrink-0 shadow-sm ml-2 flex items-center gap-1">
                        <i class="fa-solid fa-fire text-yellow-300"></i> Detail
                    </button>
                </div>
            </div>

            <!-- K3 Timeframe Selector Tabs (1 Min, 3 Min, 5 Min, 10 Min) -->
            <div class="grid grid-cols-4 gap-2 px-4 mt-3">
                <button onclick="switchTimeType('1m')" id="tab-1m" class="k3-time-card active flex flex-col items-center justify-center py-2 px-1 rounded-2xl transition active:scale-95">
                    <div class="w-8 h-8 mb-1 flex items-center justify-center">
                        <img id="tab-icon-1m" src="{{ asset('assets/image/k3/time_a-P16Y1Cxz.png') }}" class="w-7 h-7 object-contain">
                    </div>
                    <span class="text-[11px] font-black leading-tight tab-text">K3 1 Min</span>
                </button>
                <button onclick="switchTimeType('3m')" id="tab-3m" class="k3-time-card flex flex-col items-center justify-center py-2 px-1 rounded-2xl transition active:scale-95">
                    <div class="w-8 h-8 mb-1 flex items-center justify-center">
                        <img id="tab-icon-3m" src="{{ asset('assets/image/k3/time-Dqn5mr54.png') }}" class="w-7 h-7 object-contain">
                    </div>
                    <span class="text-[11px] font-black leading-tight tab-text">K3 3 Min</span>
                </button>
                <button onclick="switchTimeType('5m')" id="tab-5m" class="k3-time-card flex flex-col items-center justify-center py-2 px-1 rounded-2xl transition active:scale-95">
                    <div class="w-8 h-8 mb-1 flex items-center justify-center">
                        <img id="tab-icon-5m" src="{{ asset('assets/image/k3/time-Dqn5mr54.png') }}" class="w-7 h-7 object-contain">
                    </div>
                    <span class="text-[11px] font-black leading-tight tab-text">K3 5 Min</span>
                </button>
                <button onclick="switchTimeType('10m')" id="tab-10m" class="k3-time-card flex flex-col items-center justify-center py-2 px-1 rounded-2xl transition active:scale-95">
                    <div class="w-8 h-8 mb-1 flex items-center justify-center">
                        <img id="tab-icon-10m" src="{{ asset('assets/image/k3/time-Dqn5mr54.png') }}" class="w-7 h-7 object-contain">
                    </div>
                    <span class="text-[11px] font-black leading-tight tab-text">K3 10 Min</span>
                </button>
            </div>

            <!-- Period Info & Countdown Header -->
            <div class="px-4 mt-3 flex justify-between items-center text-xs">
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-500 font-bold">Period</span>
                        <button onclick="openHowToPlay()" class="border border-[#00b977] text-[#00b977] hover:bg-emerald-50 rounded-full px-2 py-0.5 text-[10px] font-bold flex items-center gap-1 transition">
                            <i class="fa-solid fa-book-open"></i> How to play
                        </button>
                    </div>
                    <span class="font-black text-sm text-gray-800 tracking-wider mt-0.5 block font-mono" id="period-number">--</span>
                </div>
                <div class="text-right">
                    <span class="text-gray-500 font-bold block mb-0.5">Time remaining</span>
                    <div class="flex items-center gap-1 text-gray-900 font-mono font-black text-base">
                        <span class="bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-lg shadow-sm text-[#00b977]" id="timer-m1">0</span>
                        <span class="bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-lg shadow-sm text-[#00b977]" id="timer-m2">0</span>
                        <span class="font-black text-gray-600">:</span>
                        <span class="bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-lg shadow-sm text-[#00b977]" id="timer-s1">0</span>
                        <span class="bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-lg shadow-sm text-[#00b977]" id="timer-s2">0</span>
                    </div>
                </div>
            </div>

            <!-- 3D Dice Display Box (Green Casino Felt) -->
            <div class="px-4">
                <div class="K3TL__C-l3">
                    <div class="box">
                        <div id="dice-box-1">
                            <img id="dice-img-1" src="{{ asset('assets/image/k3/num1-Dvmdd51j.png') }}" alt="Dice 1">
                        </div>
                        <div id="dice-box-2">
                            <img id="dice-img-2" src="{{ asset('assets/image/k3/num2-Bjiwouja.png') }}" alt="Dice 2">
                        </div>
                        <div id="dice-box-3">
                            <img id="dice-img-3" src="{{ asset('assets/image/k3/num3-DqB7fR7E.png') }}" alt="Dice 3">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-Category Selection Tabs -->
            <div class="grid grid-cols-4 gap-2 px-4 mt-4">
                <button onclick="switchCategory('total')" id="cat-tab-total" class="cat-tab cat-tab-active bg-gray-100 text-gray-600 py-2 rounded-xl font-bold text-xs transition active:scale-95">Total</button>
                <button onclick="switchCategory('2_same')" id="cat-tab-2_same" class="cat-tab bg-gray-100 text-gray-500 py-2 rounded-xl font-bold text-xs hover:bg-gray-200 transition active:scale-95">2 same</button>
                <button onclick="switchCategory('3_same')" id="cat-tab-3_same" class="cat-tab bg-gray-100 text-gray-500 py-2 rounded-xl font-bold text-xs hover:bg-gray-200 transition active:scale-95">3 same</button>
                <button onclick="switchCategory('different')" id="cat-tab-different" class="cat-tab bg-gray-100 text-gray-500 py-2 rounded-xl font-bold text-xs hover:bg-gray-200 transition active:scale-95">Different</button>
            </div>

            <!-- Betting Panels Wrapper (With Giant Countdown Cards Contained Inside) -->
            <div class="relative mt-2">
                <!-- 1. CATEGORY: TOTAL SUM & QUICK PREDICTIONS -->
                <div id="category-panel-total" class="category-panel px-4">
                    <!-- Total Sum Numbers 3 to 18 (Compact Grid) -->
                    <div class="grid grid-cols-4 gap-x-2 gap-y-1">
                        @php
                            $rates = [
                                3 => '207.36X', 4 => '69.12X', 5 => '34.56X', 6 => '20.74X',
                                7 => '13.83X', 8 => '9.88X', 9 => '8.3X', 10 => '7.68X',
                                11 => '7.68X', 12 => '8.3X', 13 => '9.88X', 14 => '13.83X',
                                15 => '20.74X', 16 => '34.56X', 17 => '69.12X', 18 => '207.36X'
                            ];
                        @endphp
                        @foreach($rates as $num => $mult)
                            @php
                                $isOdd = in_array($num, [3,5,7,9,11,13,15,17]);
                                $ballImg = $isOdd ? asset('assets/image/k3/redBall-C4CD7-Eb.png') : asset('assets/image/k3/greenBall-CThfOlcF.png');
                                $numColor = $isOdd ? 'text-[#e53935]' : 'text-[#00b977]';
                            @endphp
                            <button onclick="toggleBetSelection('total', '{{ $num }}', '{{ $mult }}')" id="bet-item-total-{{ $num }}" class="k3-selectable-item flex flex-col items-center justify-center py-1 px-0 rounded-xl transition active:scale-95">
                                <div class="ball-circle-wrap w-11 h-11 relative flex items-center justify-center drop-shadow-xs transition-transform">
                                    <img src="{{ $ballImg }}" alt="{{ $num }}" class="w-full h-full object-contain pointer-events-none">
                                    <span class="absolute inset-0 flex items-center justify-center {{ $numColor }} font-black text-sm leading-none drop-shadow-xs">
                                        {{ $num }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-extrabold text-gray-500 mt-0.5 leading-none">{{ $mult }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Big, Small, Even, Odd Buttons -->
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        <button onclick="toggleBetSelection('size', 'small', '2X')" id="bet-item-size-small" class="k3-selectable-item bg-gradient-to-b from-[#5c88da] to-[#4169b5] text-white py-2.5 rounded-xl font-black text-xs shadow-sm flex flex-col items-center active:scale-95 transition">
                            Small <span class="text-[9px] font-semibold opacity-90">2X</span>
                        </button>
                        <button onclick="toggleBetSelection('size', 'big', '2X')" id="bet-item-size-big" class="k3-selectable-item bg-gradient-to-b from-[#f0ad4e] to-[#d68a26] text-white py-2.5 rounded-xl font-black text-xs shadow-sm flex flex-col items-center active:scale-95 transition">
                            Big <span class="text-[9px] font-semibold opacity-90">2X</span>
                        </button>
                        <button onclick="toggleBetSelection('parity', 'even', '2X')" id="bet-item-parity-even" class="k3-selectable-item bg-gradient-to-b from-[#00b977] to-[#009b63] text-white py-2.5 rounded-xl font-black text-xs shadow-sm flex flex-col items-center active:scale-95 transition">
                            Even <span class="text-[9px] font-semibold opacity-90">2X</span>
                        </button>
                        <button onclick="toggleBetSelection('parity', 'odd', '2X')" id="bet-item-parity-odd" class="k3-selectable-item bg-gradient-to-b from-[#d9534f] to-[#b83834] text-white py-2.5 rounded-xl font-black text-xs shadow-sm flex flex-col items-center active:scale-95 transition">
                            Odd <span class="text-[9px] font-semibold opacity-90">2X</span>
                        </button>
                    </div>
                </div>

                <!-- 2. CATEGORY: 2 SAME (PAIRS) -->
                <div id="category-panel-2_same" class="category-panel px-4 hidden">
                    <div class="space-y-3">
                        <!-- Section 1: 2 matching numbers -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>2 matching numbers: odds(13.83)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <div class="grid grid-cols-6 gap-1.5">
                                @foreach(['11', '22', '33', '44', '55', '66'] as $pair)
                                    <button onclick="toggleBetSelection('2_same', '{{ $pair }}', '13.83X')" id="bet-item-2_same-{{ $pair }}" class="k3-selectable-item bg-[#e9d5ff] hover:bg-[#d8b4fe] text-[#6b21a8] py-2 rounded-xl font-black text-xs text-center border border-[#d8b4fe]/60 shadow-xs active:scale-95 transition">
                                        {{ $pair }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section 2: A pair of unique numbers -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>A pair of unique numbers: odds(69.12)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <div class="grid grid-cols-6 gap-1.5 mb-1.5">
                                @foreach(['11', '22', '33', '44', '55', '66'] as $pair)
                                    <button onclick="toggleBetSelection('2_same', 'pair_{{ $pair }}', '69.12X')" id="bet-item-2_same-pair_{{ $pair }}" class="k3-selectable-item bg-[#fecaca] hover:bg-[#fca5a5] text-[#b91c1c] py-2 rounded-xl font-black text-xs text-center border border-[#fca5a5] shadow-xs active:scale-95 transition">
                                        {{ $pair }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="grid grid-cols-6 gap-1.5">
                                @foreach([1, 2, 3, 4, 5, 6] as $num)
                                    <button onclick="toggleBetSelection('different', 'single_{{ $num }}', '69.12X')" id="bet-item-different-single_{{ $num }}" class="k3-selectable-item bg-[#bbf7d0] hover:bg-[#86efac] text-[#15803d] py-2 rounded-xl font-black text-xs text-center border border-[#86efac] shadow-xs active:scale-95 transition">
                                        {{ $num }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. CATEGORY: 3 SAME (TRIPLES) -->
                <div id="category-panel-3_same" class="category-panel px-4 hidden">
                    <div class="space-y-3">
                        <!-- Section 1: 3 of the same number -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>3 of the same number: odds(207.36)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <div class="grid grid-cols-6 gap-1.5">
                                @foreach(['111', '222', '333', '444', '555', '666'] as $triple)
                                    <button onclick="toggleBetSelection('3_same', '{{ $triple }}', '207.36X')" id="bet-item-3_same-{{ $triple }}" class="k3-selectable-item bg-[#e9d5ff] hover:bg-[#d8b4fe] text-[#6b21a8] py-2 rounded-xl font-black text-xs text-center border border-[#d8b4fe]/60 shadow-xs active:scale-95 transition">
                                        {{ $triple }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section 2: Any 3 of the same number -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>Any 3 of the same number: odds(34.56)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <button onclick="toggleBetSelection('3_same', 'any', '34.56X')" id="bet-item-3_same-any" class="k3-selectable-item w-full bg-[#fca5a5] hover:bg-[#f87171] text-white py-2.5 rounded-xl font-black text-xs text-center shadow-xs active:scale-95 transition">
                                Any 3 of the same number: odds
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4. CATEGORY: DIFFERENT -->
                <div id="category-panel-different" class="category-panel px-4 hidden">
                    <div class="space-y-3">
                        <!-- Section 1: 3 different numbers -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>3 different numbers: odds(34.56)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <div class="grid grid-cols-6 gap-1.5">
                                @foreach([1, 2, 3, 4, 5, 6] as $n)
                                    <button onclick="toggleBetSelection('different', 'diff3_{{ $n }}', '34.56X')" id="bet-item-different-diff3_{{ $n }}" class="k3-selectable-item bg-[#e9d5ff] hover:bg-[#d8b4fe] text-[#6b21a8] py-2 rounded-xl font-black text-xs text-center border border-[#d8b4fe]/60 shadow-xs active:scale-95 transition">
                                        {{ $n }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section 2: 3 continuous numbers -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>3 continuous numbers: odds(8.64)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <button onclick="toggleBetSelection('different', 'continuous', '8.64X')" id="bet-item-different-continuous" class="k3-selectable-item w-full bg-[#fca5a5] hover:bg-[#f87171] text-white py-2.5 rounded-xl font-black text-xs text-center shadow-xs active:scale-95 transition">
                                3 continuous numbers
                            </button>
                        </div>

                        <!-- Section 3: 2 different numbers -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-700 mb-1.5 flex items-center gap-1">
                                <span>2 different numbers: odds(6.91)</span>
                                <i class="fa-solid fa-circle-question text-red-400 text-xs cursor-pointer" onclick="openHowToPlay()"></i>
                            </div>
                            <div class="grid grid-cols-6 gap-1.5">
                                @foreach([1, 2, 3, 4, 5, 6] as $n)
                                    <button onclick="toggleBetSelection('different', 'diff2_{{ $n }}', '6.91X')" id="bet-item-different-diff2_{{ $n }}" class="k3-selectable-item bg-[#e9d5ff] hover:bg-[#d8b4fe] text-[#6b21a8] py-2 rounded-xl font-black text-xs text-center border border-[#d8b4fe]/60 shadow-xs active:scale-95 transition">
                                        {{ $n }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Giant 5-Second Countdown Cards Overlay (0 5 -> 0 0) -->
                <div id="k3-countdown-overlay" class="absolute inset-0 bg-black/25 backdrop-blur-[0.5px] z-30 flex items-center justify-center gap-4 hidden rounded-2xl select-none pointer-events-none transition-opacity duration-200">
                    <div class="bg-white rounded-3xl shadow-[0_20px_45px_rgba(0,0,0,0.35)] w-28 h-44 flex items-center justify-center border border-gray-100">
                        <span id="big-countdown-d1" class="text-8xl font-black text-[#00b977] leading-none select-none drop-shadow-sm">0</span>
                    </div>
                    <div class="bg-white rounded-3xl shadow-[0_20px_45px_rgba(0,0,0,0.35)] w-28 h-44 flex items-center justify-center border border-gray-100">
                        <span id="big-countdown-d2" class="text-8xl font-black text-[#00b977] leading-none select-none drop-shadow-sm">5</span>
                    </div>
                </div>
            </div>

            <!-- Game History / Chart / My History Section -->
            <div class="px-4 mt-5">
                <!-- 3 Pill Tabs -->
                <div class="grid grid-cols-3 gap-2 text-xs font-bold mb-3">
                    <button onclick="switchBottomTab('history')" id="btab-history" class="py-2.5 px-2 rounded-xl bg-[#00b977] text-white shadow-sm font-bold text-center transition active:scale-95">Game history</button>
                    <button onclick="switchBottomTab('chart')" id="btab-chart" class="py-2.5 px-2 rounded-xl bg-white text-gray-500 border border-gray-100 shadow-xs hover:bg-gray-50 font-bold text-center transition active:scale-95">Chart</button>
                    <button onclick="switchBottomTab('my_history')" id="btab-my_history" class="py-2.5 px-2 rounded-xl bg-white text-gray-500 border border-gray-100 shadow-xs hover:bg-gray-50 font-bold text-center transition active:scale-95">My history</button>
                </div>

                <!-- Tab 1: Game History Table -->
                <div id="pane-history" class="bottom-pane overflow-x-auto">
                    <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-xs">
                        <table class="w-full text-center text-xs">
                            <thead>
                                <tr class="bg-[#00b977] text-white font-bold">
                                    <th class="py-2.5 px-3 text-left">Period</th>
                                    <th class="py-2.5 px-3">Sum</th>
                                    <th class="py-2.5 px-3 text-right">Results</th>
                                </tr>
                            </thead>
                            <tbody id="k3-history-tbody" class="divide-y divide-gray-100 text-gray-700 font-semibold bg-white">
                                <tr>
                                    <td colspan="3" class="py-6 text-gray-400 text-xs">Loading game history...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="flex items-center justify-center gap-3 mt-3 text-xs text-gray-500 font-semibold">
                        <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-400 flex items-center justify-center"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                        <span>1/50</span>
                        <button class="w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Tab 2: Chart Table -->
                <div id="pane-chart" class="bottom-pane hidden overflow-x-auto">
                    <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-xs">
                        <table class="w-full text-center text-xs">
                            <thead>
                                <tr class="bg-[#00b977] text-white font-bold">
                                    <th class="py-2.5 px-3 text-left">Period</th>
                                    <th class="py-2.5 px-3">Results</th>
                                    <th class="py-2.5 px-3 text-right">Number</th>
                                </tr>
                            </thead>
                            <tbody id="k3-chart-tbody" class="divide-y divide-gray-100 text-gray-700 font-semibold bg-white">
                                <tr>
                                    <td colspan="3" class="py-6 text-gray-400 text-xs">Loading chart...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="flex items-center justify-center gap-3 mt-3 text-xs text-gray-500 font-semibold">
                        <button class="w-8 h-8 rounded-lg bg-gray-200 text-gray-400 flex items-center justify-center"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                        <span>1/50</span>
                        <button class="w-8 h-8 rounded-lg bg-[#00b977] text-white flex items-center justify-center"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                    </div>
                </div>

                <!-- Tab 3: My Bet History -->
                <div id="pane-my_history" class="bottom-pane hidden">
                    <div class="flex justify-end mb-2">
                        <button type="button" onclick="openMyHistoryDetailModal()" class="border border-[#00b977] text-[#00b977] hover:bg-emerald-50 rounded-full px-3 py-1 text-xs font-bold flex items-center gap-1 transition">
                            Detail <i class="fa-solid fa-circle-chevron-right text-xs"></i>
                        </button>
                    </div>
                    <div id="my-history-list" class="space-y-2">
                        <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                            <i class="fa-solid fa-file-invoice text-4xl text-gray-300 mb-2"></i>
                            <span class="text-xs font-semibold">No data</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- How To Play Modal (Rules Loaded from Admin Settings) -->
    <div id="how-to-play-modal" class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-5 shadow-2xl max-h-[85vh] flex flex-col">
            <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-3 shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-[#00b977] text-lg"></i>
                    <h4 class="font-extrabold text-gray-800 text-base">How to Play Fast 3 / Quick 3</h4>
                </div>
                <button type="button" onclick="closeHowToPlay()" class="text-gray-400 hover:text-gray-600 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="text-xs text-gray-700 overflow-y-auto pr-1 space-y-3 leading-relaxed flex-1 whitespace-pre-line font-sans">
@if(!empty($settings->how_to_play_rules))
{{ $settings->how_to_play_rules }}
@else
Fast 3 / Quick 3 Game Rules

Fast 3 open with 3 numbers in each period as the opening number, The opening numbers are 111 to 666 Natural number, No zeros in the array, And the opening numbers are in no particular order, Quick 3 is to guess all or part of the 3 winning numbers.

Betting Types

Sum Value
Place a bet on the sum of three numbers

Choose 3 same number all
For all the same three numbers (111, 222, ..., 666) Make an all-inclusive bet

Choose 3 same number single
From all the same three numbers (111, ..., 666) Choose a group of numbers in any of them to place bets

Choose 2 Same Multiple
Place a bet on two designated same numbers and an arbitrary number among the three numbers

Choose 2 Same Single
Place a bet on two designated same numbers and a designated different number among the three numbers

3 numbers different
Place a bet on three different numbers

2 numbers different
Place a bet on two designated different numbers and an arbitrary number among the three numbers

Choose 3 Consecutive number all
For all three consecutive numbers (123, 234, 345, 456) Place a bet

Description of Winning and Odds

Sum Value
A bet with the same opening number and value is the winning

Choose 3 same number all
If the opening numbers are any three of the same number, it is the winning

Choose 3 same number single
A bet that is exactly the same as the opening number is the winning

Choose 2 Same Multiple
The same number as the two same numbers in the opening number (except for the three same numbers) is the winning

Choose 2 Same Single
A bet that is exactly the same as the opening number is the winning

3 numbers different
A bet that is exactly the same as the opening number is the winning

2 numbers different
The same as the two arbitrary numbers in the opening number is the winning

Choose 3 Consecutive number all
If the opening numbers are any three consecutive numbers, it is the winning
@endif
            </div>
            <button type="button" onclick="closeHowToPlay()" class="mt-4 w-full bg-[#00b977] hover:bg-[#009b63] text-white py-2.5 rounded-full font-bold text-xs shadow-md shrink-0 transition">Close</button>
        </div>
    </div>

    <!-- My Bet History Detail Modal (Exact Amar Club K3 Detail Screen) -->
    <div id="my-history-detail-modal" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm flex items-start justify-center p-0 sm:py-6 overflow-y-auto hidden">
        <div class="bg-[#f5f5f5] w-full max-w-[430px] min-h-screen sm:min-h-[85vh] sm:rounded-3xl shadow-2xl flex flex-col relative overflow-hidden my-auto sm:my-0">
            <!-- Top Green Bar (Full visibility with safe padding) -->
            <div class="bg-[#00b977] px-4 py-3.5 text-white flex items-center justify-between shadow-md shrink-0 sticky top-0 z-20">
                <button type="button" onclick="closeMyHistoryDetailModal()" class="text-white text-xl p-1 hover:opacity-80 transition flex items-center justify-center w-8 h-8">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h3 class="font-bold text-lg tracking-wide text-white text-center flex-1">K3</h3>
                <div class="w-8"></div>
            </div>

            <!-- Time Tabs: K3 1 Min, K3 3 Min, K3 5 Min, K3 10 Min with moving Green Indicator Bar -->
            <div class="bg-white border-b border-gray-200 grid grid-cols-4 text-center shrink-0">
                <button type="button" onclick="loadDetailTabHistory('1m')" id="dtab-1m" class="detail-tab-btn relative py-3.5 text-xs font-bold text-[#00b977] transition flex flex-col items-center justify-center">
                    <span>K3 1 Min</span>
                    <div class="tab-indicator absolute bottom-0 w-10 h-[3px] bg-[#00b977] rounded-full"></div>
                </button>
                <button type="button" onclick="loadDetailTabHistory('3m')" id="dtab-3m" class="detail-tab-btn relative py-3.5 text-xs font-semibold text-gray-500 hover:text-gray-800 transition flex flex-col items-center justify-center">
                    <span>K3 3 Min</span>
                    <div class="tab-indicator absolute bottom-0 w-10 h-[3px] bg-[#00b977] rounded-full hidden"></div>
                </button>
                <button type="button" onclick="loadDetailTabHistory('5m')" id="dtab-5m" class="detail-tab-btn relative py-3.5 text-xs font-semibold text-gray-500 hover:text-gray-800 transition flex flex-col items-center justify-center">
                    <span>K3 5 Min</span>
                    <div class="tab-indicator absolute bottom-0 w-10 h-[3px] bg-[#00b977] rounded-full hidden"></div>
                </button>
                <button type="button" onclick="loadDetailTabHistory('10m')" id="dtab-10m" class="detail-tab-btn relative py-3.5 text-xs font-semibold text-gray-500 hover:text-gray-800 transition flex flex-col items-center justify-center">
                    <span>K3 10 Min</span>
                    <div class="tab-indicator absolute bottom-0 w-10 h-[3px] bg-[#00b977] rounded-full hidden"></div>
                </button>
            </div>

            <!-- List or Empty State Content -->
            <div id="detail-history-list" class="flex-1 p-3 overflow-y-auto space-y-2.5">
                <div class="flex flex-col items-center justify-center py-28 text-gray-400">
                    <i class="fa-solid fa-file-invoice text-5xl text-gray-300 mb-3"></i>
                    <span class="text-xs font-semibold text-gray-500">No data</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Betting Confirmation Modal / Sticky Bottom Drawer -->
    <div id="bet-modal" class="fixed bottom-0 left-0 right-0 z-40 flex justify-center pointer-events-none hidden">
        <div class="bg-white w-full max-w-[430px] rounded-t-3xl shadow-[0_-10px_35px_rgba(0,0,0,0.25)] border-t border-gray-100 overflow-hidden pointer-events-auto transition-transform duration-200">
            <div class="p-4 space-y-4">
                <!-- Header: Total: [Small/Big/Even/Odd/Number] -->
                <div>
                    <span class="text-xs font-bold text-gray-700 block mb-1.5">Total:</span>
                    <div id="modal-badges-list" class="flex flex-wrap items-center gap-1.5 min-h-[28px]">
                        <span class="px-3.5 py-1 bg-[#5c88da] text-white rounded-md text-xs font-black inline-block">Small</span>
                    </div>
                </div>

                <!-- Balance Row -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-700">Balance</span>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="setBaseAmount(1)" id="amt-btn-1" class="amt-btn bg-[#00b977] text-white px-3 py-1 rounded text-xs font-black transition">1</button>
                        <button type="button" onclick="setBaseAmount(10)" id="amt-btn-10" class="amt-btn bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold hover:bg-gray-200 transition">10</button>
                        <button type="button" onclick="setBaseAmount(100)" id="amt-btn-100" class="amt-btn bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold hover:bg-gray-200 transition">100</button>
                        <button type="button" onclick="setBaseAmount(1000)" id="amt-btn-1000" class="amt-btn bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold hover:bg-gray-200 transition">1K</button>
                    </div>
                </div>

                <!-- Quantity Row -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-700">Quantity</span>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="changeQuantity(-1)" class="w-7 h-7 rounded bg-[#00b977] text-white font-black text-xs flex items-center justify-center active:scale-95 transition">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" id="bet-quantity-input" value="1" min="1" max="9999" oninput="onQuantityChange(this.value)" class="w-16 h-7 bg-gray-100 text-center font-bold text-xs rounded border border-gray-200 focus:outline-none focus:border-[#00b977]">
                        <button type="button" onclick="changeQuantity(1)" class="w-7 h-7 rounded bg-[#00b977] text-white font-black text-xs flex items-center justify-center active:scale-95 transition">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Multiplier Buttons Row -->
                <div class="flex items-center justify-end gap-1.5 pt-1">
                    @foreach([1, 5, 10, 20, 50, 100] as $m)
                        <button type="button" onclick="setMultiplier({{ $m }})" id="mult-btn-{{ $m }}" class="mult-btn px-2.5 py-1 rounded text-xs font-black transition {{ $m == 1 ? 'bg-[#00b977] text-white' : 'bg-gray-100 text-gray-600' }}">
                            X{{ $m }}
                        </button>
                    @endforeach
                </div>

                <!-- Agreement Row -->
                <div class="flex items-center gap-2 pt-1 text-xs font-medium">
                    <label class="flex items-center gap-1.5 cursor-pointer text-gray-600">
                        <i class="fa-solid fa-circle-check text-[#00b977] text-base"></i>
                        <span>I agree</span>
                    </label>
                    <button type="button" onclick="openHowToPlay()" class="text-[#f56565] font-semibold hover:underline">《Pre-sale rules》</button>
                </div>
            </div>

            <!-- Bottom Action Bar (Cancel & Total Amount Confirm) -->
            <div class="flex items-center border-t border-gray-100">
                <button type="button" onclick="closeBetModal()" class="w-[35%] py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm transition text-center">
                    Cancel
                </button>
                <button type="button" onclick="submitK3Bet()" id="confirm-bet-btn" class="w-[65%] py-3.5 bg-[#00b977] hover:bg-[#00a368] text-white font-black text-sm transition text-center flex items-center justify-center gap-1">
                    Total amount ৳<span id="total-bet-charge">1.00</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Deposit Required Modal (When Demo Limit Hit) -->
    <div id="deposit-modal" class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl p-6 text-center max-w-xs w-full shadow-2xl">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3 text-yellow-600 text-3xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <h4 class="font-black text-base text-gray-800 mb-2">ডেমো লিমিট শেষ!</h4>
            <p class="text-xs text-gray-500 mb-4 leading-relaxed">আসল টাকা দিয়ে খেলে উইন ব্যালেন্স নিরাপদে তুলতে এখনই ডিপোজিট করুন।</p>
            <a href="/customer/deposit" class="block w-full bg-gradient-to-r from-[#00b977] to-[#009b63] text-white font-bold py-3 rounded-full text-xs mb-2.5 shadow-lg active:scale-95 transition">
                ডিপোজিট করুন
            </a>
            <button onclick="document.getElementById('deposit-modal').classList.add('hidden')" class="text-xs text-gray-400 font-semibold hover:text-gray-600">
                পরে করব
            </button>
        </div>
    </div>

    <!-- Win Toast Modal -->
    <div id="win-toast" class="fixed top-20 left-1/2 -translate-x-1/2 bg-gray-900/90 text-white px-5 py-3 rounded-2xl shadow-2xl z-50 hidden flex items-center gap-3 backdrop-blur-md">
        <i class="fa-solid fa-trophy text-yellow-400 text-xl animate-bounce"></i>
        <div>
            <div class="text-[11px] font-semibold text-gray-300">Congratulations!</div>
            <div class="text-sm font-black text-emerald-400" id="win-toast-msg">You Won ৳ 0.00</div>
        </div>
    </div>

    <!-- Frontend Script Engine -->
    <script>
        let currentTimeType = '1m';
        let baseAmount = 1;
        let currentQuantity = 1;
        let currentMultiplier = 1;
        let selectedBets = {}; // Key: "type_val" => { type, val, mult }
        let isDemoMode = false;
        let demoBetsCount = 0;
        let isRolling = false;
        let lastPlayedCountdownSec = -1;
        let lastSettledPeriod = '';
        let audioMuted = false;
        let k3Settings = {
            audio_countdown_enabled: true,
            audio_countdown_url: '',
            audio_win_url: '',
            audio_roll_url: ''
        };

        // Audio Engine with custom MP3 support + Web Audio Synthesizer fallback
        const AudioEngine = {
            ctx: null,
            init() {
                if (!this.ctx) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) this.ctx = new AudioCtx();
                }
                if (this.ctx && this.ctx.state === 'suspended') {
                    this.ctx.resume();
                }
            },
            playAudioUrl(url, fallbackFn) {
                if (audioMuted) return;
                if (url && typeof url === 'string' && url.trim().length > 0) {
                    try {
                        const audio = new Audio(url);
                        audio.play().catch(() => {
                            if (fallbackFn) fallbackFn();
                        });
                        return;
                    } catch(e) {}
                }
                if (fallbackFn) fallbackFn();
            },
            playBeep(freq = 880, duration = 0.12, type = 'sine') {
                if (audioMuted) return;
                try {
                    this.init();
                    if (!this.ctx) return;
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = type;
                    osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
                    gain.gain.setValueAtTime(0.2, this.ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + duration);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    osc.stop(this.ctx.currentTime + duration);
                } catch(e) {}
            },
            speakCountdown(num) {
                if (audioMuted) return;
                if (k3Settings.audio_countdown_enabled === false) return;
                if (k3Settings.audio_countdown_url) {
                    this.playAudioUrl(k3Settings.audio_countdown_url, () => {
                        const freq = (num === 0) ? 1200 : (700 + (5 - num) * 80);
                        this.playBeep(freq, num === 0 ? 0.25 : 0.12, 'sine');
                    });
                } else {
                    const freq = (num === 0) ? 1200 : (700 + (5 - num) * 80);
                    this.playBeep(freq, num === 0 ? 0.25 : 0.12, 'sine');
                }
            },
            playRollSound() {
                if (audioMuted) return;
                if (k3Settings.audio_roll_url) {
                    this.playAudioUrl(k3Settings.audio_roll_url, () => {
                        this.playBeep(420, 0.4, 'triangle');
                    });
                } else {
                    this.playBeep(420, 0.35, 'triangle');
                }
            },
            playWinSound() {
                if (audioMuted) return;
                if (k3Settings.audio_win_url) {
                    this.playAudioUrl(k3Settings.audio_win_url, () => {
                        this.playBeep(1100, 0.35, 'sine');
                    });
                } else {
                    this.playBeep(1100, 0.35, 'sine');
                }
            }
        };

        function toggleAudioMute() {
            audioMuted = !audioMuted;
            const icon = document.getElementById('audio-icon');
            if (audioMuted) {
                icon.className = 'fa-solid fa-volume-xmark text-red-300';
            } else {
                icon.className = 'fa-solid fa-volume-high text-white';
                AudioEngine.playBeep(880, 0.1);
            }
        }

        const DICE_3D_IMAGES = {
            1: "{{ asset('assets/image/k3/num1-Dvmdd51j.png') }}",
            2: "{{ asset('assets/image/k3/num2-Bjiwouja.png') }}",
            3: "{{ asset('assets/image/k3/num3-DqB7fR7E.png') }}",
            4: "{{ asset('assets/image/k3/num4-y7OTelTf.png') }}",
            5: "{{ asset('assets/image/k3/num5-DwdV2vel.png') }}",
            6: "{{ asset('assets/image/k3/num6-Dn342HJq.png') }}"
        };

        const DICE_MINI_IMAGES = {
            1: "{{ asset('assets/image/k3/n1-BwGtHT5h.png') }}",
            2: "{{ asset('assets/image/k3/n2-Cu_RIg4W.png') }}",
            3: "{{ asset('assets/image/k3/n3-meiTgeYx.png') }}",
            4: "{{ asset('assets/image/k3/n4-CKhZln44.png') }}",
            5: "{{ asset('assets/image/k3/n5-DRtuCoBO.png') }}",
            6: "{{ asset('assets/image/k3/n6-DfBPUfaO.png') }}"
        };

        let rollInterval = null;

        function setDiceValues(d1, d2, d3) {
            const el1 = document.getElementById('dice-img-1');
            const el2 = document.getElementById('dice-img-2');
            const el3 = document.getElementById('dice-img-3');
            const v1 = Math.min(6, Math.max(1, parseInt(d1) || 1));
            const v2 = Math.min(6, Math.max(1, parseInt(d2) || 2));
            const v3 = Math.min(6, Math.max(1, parseInt(d3) || 3));

            if (el1 && DICE_3D_IMAGES[v1]) el1.src = DICE_3D_IMAGES[v1];
            if (el2 && DICE_3D_IMAGES[v2]) el2.src = DICE_3D_IMAGES[v2];
            if (el3 && DICE_3D_IMAGES[v3]) el3.src = DICE_3D_IMAGES[v3];
        }

        function switchTimeType(type) {
            currentTimeType = type;
            
            // Stop any running dice rolling & hide countdown overlay immediately
            isRolling = false;
            if (rollInterval) {
                clearInterval(rollInterval);
                rollInterval = null;
            }
            for (let i = 1; i <= 3; i++) {
                const el = document.getElementById(`dice-box-${i}`);
                if (el) el.classList.remove('dice-rolling');
            }
            const bigOverlay = document.getElementById('k3-countdown-overlay');
            if (bigOverlay) bigOverlay.classList.add('hidden');
            lastPlayedCountdownSec = -1;

            document.querySelectorAll('.k3-time-card').forEach(t => {
                t.classList.remove('active');
            });
            const activeBtn = document.getElementById(`tab-${type}`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            // Update icons
            ['1m', '3m', '5m', '10m'].forEach(t => {
                const iconEl = document.getElementById(`tab-icon-${t}`);
                if (iconEl) {
                    iconEl.src = (t === type) 
                        ? "{{ asset('assets/image/k3/time_a-P16Y1Cxz.png') }}"
                        : "{{ asset('assets/image/k3/time-Dqn5mr54.png') }}";
                }
            });
            
            syncState();
            if (currentBottomTab === 'my_history') {
                loadMyHistory();
            }
        }

        function switchCategory(cat) {
            document.querySelectorAll('.cat-tab').forEach(t => {
                t.classList.remove('cat-tab-active', 'bg-[#00b977]', 'text-white');
                t.classList.add('bg-gray-100', 'text-gray-500');
            });
            const activeTab = document.getElementById(`cat-tab-${cat}`);
            if (activeTab) {
                activeTab.classList.add('cat-tab-active', 'bg-[#00b977]', 'text-white');
                activeTab.classList.remove('bg-gray-100', 'text-gray-500');
            }

            document.querySelectorAll('.category-panel').forEach(p => p.classList.add('hidden'));
            const activePanel = document.getElementById(`category-panel-${cat}`);
            if (activePanel) activePanel.classList.remove('hidden');
        }

        let currentBottomTab = 'history';

        function switchBottomTab(tab) {
            currentBottomTab = tab;
            document.querySelectorAll('.bottom-pane').forEach(p => p.classList.add('hidden'));
            ['history', 'chart', 'my_history'].forEach(t => {
                const btn = document.getElementById(`btab-${t}`);
                if (btn) {
                    btn.classList.remove('bg-[#00b977]', 'text-white', 'shadow-sm');
                    btn.classList.add('bg-white', 'text-gray-500', 'border', 'border-gray-100', 'shadow-xs');
                }
            });

            const activeBtn = document.getElementById(`btab-${tab}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-[#00b977]', 'text-white', 'shadow-sm');
                activeBtn.classList.remove('bg-white', 'text-gray-500', 'border', 'border-gray-100', 'shadow-xs');
            }

            const activePane = document.getElementById(`pane-${tab}`);
            if (activePane) activePane.classList.remove('hidden');

            if (tab === 'my_history') {
                loadMyHistory();
            }
        }

        function openMyHistoryDetailModal() {
            const m = document.getElementById('my-history-detail-modal');
            if (m) m.classList.remove('hidden');
            loadDetailTabHistory(currentTimeType);
        }

        function closeMyHistoryDetailModal() {
            const m = document.getElementById('my-history-detail-modal');
            if (m) m.classList.add('hidden');
        }

        function loadDetailTabHistory(type) {
            document.querySelectorAll('.detail-tab-btn').forEach(btn => {
                btn.classList.remove('text-[#00b977]', 'font-bold');
                btn.classList.add('text-gray-500', 'font-semibold');
                const ind = btn.querySelector('.tab-indicator');
                if (ind) ind.classList.add('hidden');
            });
            const activeTab = document.getElementById(`dtab-${type}`);
            if (activeTab) {
                activeTab.classList.add('text-[#00b977]', 'font-bold');
                activeTab.classList.remove('text-gray-500', 'font-semibold');
                const ind = activeTab.querySelector('.tab-indicator');
                if (ind) ind.classList.remove('hidden');
            }

            fetch(`/games/k3/my-history?type=${type}`)
                .then(res => res.json())
                .then(data => {
                    const list = document.getElementById('detail-history-list');
                    if (!list) return;

                    if (!data.history || data.history.length === 0) {
                        list.innerHTML = `
                            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                                <i class="fa-solid fa-file-invoice text-5xl text-gray-300 mb-3"></i>
                                <span class="text-sm font-semibold">No data</span>
                            </div>
                        `;
                        return;
                    }

                    list.innerHTML = '';
                    data.history.forEach(bet => {
                        const isWon = bet.status === 'won';
                        const isPending = bet.status === 'pending';
                        
                        const statusBadge = isPending 
                            ? `<span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Pending</span>`
                            : (isWon 
                                ? `<span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2 py-0.5 rounded-full">+৳ ${parseFloat(bet.win_amount).toFixed(2)}</span>`
                                : `<span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full">Lost</span>`
                              );

                        let diceResultHtml = '';
                        if (bet.period && bet.period.dice_1) {
                            const d1 = DICE_MINI_IMAGES[bet.period.dice_1] || DICE_MINI_IMAGES[1];
                            const d2 = DICE_MINI_IMAGES[bet.period.dice_2] || DICE_MINI_IMAGES[2];
                            const d3 = DICE_MINI_IMAGES[bet.period.dice_3] || DICE_MINI_IMAGES[3];
                            diceResultHtml = `
                                <div class="flex items-center gap-1 mt-1">
                                    <img src="${d1}" class="w-4 h-4 object-contain">
                                    <img src="${d2}" class="w-4 h-4 object-contain">
                                    <img src="${d3}" class="w-4 h-4 object-contain">
                                    <span class="text-[10px] font-bold text-gray-600 ml-1">Sum: ${bet.period.total_sum}</span>
                                </div>
                            `;
                        }

                        const card = document.createElement('div');
                        card.className = 'bg-white p-3 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between text-xs mb-2';
                        card.innerHTML = `
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="font-mono font-bold text-gray-800">${bet.period ? bet.period.period_number.slice(-5) : '--'}</span>
                                    <span class="text-[11px] font-bold uppercase text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">${bet.bet_type}: ${bet.selected_value}</span>
                                </div>
                                <div class="text-[10px] text-gray-400 font-semibold">Bet Amount: ৳ ${parseFloat(bet.total_amount).toFixed(2)}</div>
                                ${diceResultHtml}
                            </div>
                            <div class="text-right">${statusBadge}</div>
                        `;
                        list.appendChild(card);
                    });
                })
                .catch(() => {});
        }

        function openHowToPlay() {
            const m = document.getElementById('how-to-play-modal');
            if (m) m.classList.remove('hidden');
        }

        function closeHowToPlay() {
            const m = document.getElementById('how-to-play-modal');
            if (m) m.classList.add('hidden');
        }

        function setBaseAmount(val) {
            baseAmount = val;
            document.querySelectorAll('.amt-btn').forEach(b => {
                b.classList.remove('bg-[#00b977]', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700');
            });
            const activeBtn = document.getElementById(`amt-btn-${val}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-[#00b977]', 'text-white');
                activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
            }
            updateTotalBetCharge();
        }

        function changeQuantity(delta) {
            currentQuantity = Math.max(1, currentQuantity + delta);
            const input = document.getElementById('bet-quantity-input');
            if (input) input.value = currentQuantity;
            updateTotalBetCharge();
        }

        function onQuantityChange(val) {
            const num = parseInt(val) || 1;
            currentQuantity = Math.max(1, num);
            updateTotalBetCharge();
        }

        function setMultiplier(m) {
            currentMultiplier = m;
            document.querySelectorAll('.mult-btn').forEach(b => {
                b.classList.remove('bg-[#00b977]', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            const activeBtn = document.getElementById(`mult-btn-${m}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-[#00b977]', 'text-white');
                activeBtn.classList.remove('bg-gray-100', 'text-gray-600');
            }
            updateTotalBetCharge();
        }

        function toggleBetSelection(type, val, mult) {
            AudioEngine.init();
            const key = `${type}_${val}`;

            if (selectedBets[key]) {
                delete selectedBets[key];
            } else {
                selectedBets[key] = { type, val, mult };
            }

            const count = Object.keys(selectedBets).length;
            const bModal = document.getElementById('bet-modal');
            if (count > 0) {
                if (bModal) bModal.classList.remove('hidden');
            } else {
                if (bModal) bModal.classList.add('hidden');
            }

            renderSelectionBadges();
            updateGridSelectionStates();
        }

        function updateGridSelectionStates() {
            // Remove previous active selection highlights
            document.querySelectorAll('.k3-selectable-item').forEach(el => {
                el.classList.remove('ring-4', 'ring-[#00b977]', 'ring-[#ff4d4f]', 'ring-white', 'border-2', 'border-[#00b977]', 'scale-105', 'shadow-lg');
                const wrap = el.querySelector('.ball-circle-wrap');
                if (wrap) {
                    wrap.classList.remove('ring-4', 'ring-[#00b977]', 'ring-[#ff4d4f]', 'scale-110');
                }
            });

            // Apply highlight to currently selected items
            Object.keys(selectedBets).forEach(key => {
                const item = selectedBets[key];
                const el = document.getElementById(`bet-item-${item.type}-${item.val}`);
                if (!el) return;

                if (item.type === 'total') {
                    const isOdd = [3,5,7,9,11,13,15,17].includes(parseInt(item.val));
                    const wrap = el.querySelector('.ball-circle-wrap');
                    if (wrap) {
                        wrap.classList.add('ring-4', isOdd ? 'ring-[#ff4d4f]' : 'ring-[#00b977]', 'rounded-full', 'scale-110');
                    }
                } else if (item.type === 'size' || item.type === 'parity') {
                    el.classList.add('ring-4', 'ring-white/90', 'scale-105', 'shadow-lg');
                } else {
                    el.classList.add('ring-2', 'ring-[#00b977]', 'scale-105', 'shadow-md');
                }
            });
        }

        function renderSelectionBadges() {
            const container = document.getElementById('modal-badges-list');
            if (!container) return;

            container.innerHTML = '';
            const items = Object.values(selectedBets);

            items.forEach(item => {
                const badge = document.createElement('div');
                badge.className = 'cursor-pointer hover:opacity-80 transition select-none flex items-center';
                badge.title = 'Click to remove';
                badge.onclick = () => toggleBetSelection(item.type, item.val, item.mult);

                if (item.type === 'total') {
                    const isOdd = [3,5,7,9,11,13,15,17].includes(parseInt(item.val));
                    const bg = isOdd ? 'bg-[#ff4d4f]' : 'bg-[#00b977]';
                    badge.innerHTML = `<span class="w-6 h-6 rounded-full ${bg} text-white font-black text-xs flex items-center justify-center drop-shadow-xs">${item.val}</span>`;
                } else if (item.val === 'small') {
                    badge.innerHTML = `<span class="px-3 py-1 bg-[#5c88da] text-white rounded-md text-xs font-black inline-block">Small</span>`;
                } else if (item.val === 'big') {
                    badge.innerHTML = `<span class="px-3 py-1 bg-[#f0ad4e] text-white rounded-md text-xs font-black inline-block">Big</span>`;
                } else if (item.val === 'even') {
                    badge.innerHTML = `<span class="px-3 py-1 bg-[#00b977] text-white rounded-md text-xs font-black inline-block">Even</span>`;
                } else if (item.val === 'odd') {
                    badge.innerHTML = `<span class="px-3 py-1 bg-[#ff4d4f] text-white rounded-md text-xs font-black inline-block">Odd</span>`;
                } else if (item.val === 'any') {
                    badge.innerHTML = `<span class="px-2.5 py-1 bg-[#fca5a5] text-white rounded-md text-xs font-black inline-block">Any 3 Same</span>`;
                } else if (item.val === 'continuous') {
                    badge.innerHTML = `<span class="px-2.5 py-1 bg-[#fca5a5] text-white rounded-md text-xs font-black inline-block">3 Continuous</span>`;
                } else {
                    let cleanVal = item.val.replace('pair_', '').replace('single_', '').replace('diff3_', '').replace('diff2_', '');
                    let badgeBg = 'bg-[#00b977] text-white';
                    if (item.val.startsWith('pair_')) badgeBg = 'bg-[#fca5a5] text-[#b91c1c]';
                    else if (item.type === '2_same' || item.type === '3_same') badgeBg = 'bg-[#e9d5ff] text-[#6b21a8]';
                    else if (item.val.startsWith('single_') || item.val.startsWith('diff2_')) badgeBg = 'bg-[#bbf7d0] text-[#15803d]';
                    badge.innerHTML = `<span class="px-2.5 py-1 ${badgeBg} rounded-md text-xs font-black inline-block">${cleanVal}</span>`;
                }
                container.appendChild(badge);
            });

            updateTotalBetCharge();
        }

        function updateTotalBetCharge() {
            const count = Object.keys(selectedBets).length;
            const total = (count * baseAmount * currentQuantity * currentMultiplier).toFixed(2);
            const el = document.getElementById('total-bet-charge');
            if (el) el.innerText = total;
        }

        function closeBetModal() {
            const bModal = document.getElementById('bet-modal');
            if (bModal) bModal.classList.add('hidden');
            selectedBets = {};
            updateGridSelectionStates();
            renderSelectionBadges();
        }

        let settlementTimeout = null;

        function startDiceRolling() {
            if (isRolling) return;
            isRolling = true;
            for (let i = 1; i <= 3; i++) {
                const el = document.getElementById(`dice-box-${i}`);
                if (el) el.classList.add('dice-rolling');
            }
            if (!rollInterval) {
                rollInterval = setInterval(() => {
                    const r1 = Math.floor(Math.random() * 6) + 1;
                    const r2 = Math.floor(Math.random() * 6) + 1;
                    const r3 = Math.floor(Math.random() * 6) + 1;
                    setDiceValues(r1, r2, r3);
                }, 90);
            }
        }

        function stopDiceRolling(d1, d2, d3) {
            isRolling = false;
            if (rollInterval) {
                clearInterval(rollInterval);
                rollInterval = null;
            }
            for (let i = 1; i <= 3; i++) {
                const el = document.getElementById(`dice-box-${i}`);
                if (el) el.classList.remove('dice-rolling');
            }
            setDiceValues(d1 || 1, d2 || 2, d3 || 3);
        }

        function renderTimer(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            const strM = String(mins).padStart(2, '0');
            const strS = String(secs).padStart(2, '0');

            const m1 = document.getElementById('timer-m1');
            const m2 = document.getElementById('timer-m2');
            const s1 = document.getElementById('timer-s1');
            const s2 = document.getElementById('timer-s2');

            if (m1) m1.innerText = strM[0];
            if (m2) m2.innerText = strM[1];
            if (s1) s1.innerText = strS[0];
            if (s2) s2.innerText = strS[1];

            // Trigger countdown sound and Giant Cards Overlay in last 5 seconds (5..1..0)
            const bigOverlay = document.getElementById('k3-countdown-overlay');
            const bigD1 = document.getElementById('big-countdown-d1');
            const bigD2 = document.getElementById('big-countdown-d2');

            const secNum = Math.max(0, Math.min(5, parseInt(seconds) || 0));
            if (seconds <= 5 && seconds >= 0) {
                if (bigOverlay) bigOverlay.classList.remove('hidden');
                if (bigD1) bigD1.textContent = '0';
                if (bigD2) bigD2.textContent = String(secNum);

                if (secNum !== lastPlayedCountdownSec) {
                    lastPlayedCountdownSec = secNum;
                    AudioEngine.speakCountdown(secNum);
                }
            } else {
                if (bigOverlay) bigOverlay.classList.add('hidden');
                lastPlayedCountdownSec = -1;
            }
        }

        function renderHistory(history) {
            const tbody = document.getElementById('k3-history-tbody');
            const chartBody = document.getElementById('k3-chart-tbody');
            if (!tbody || !history || history.length === 0) return;

            tbody.innerHTML = '';
            if (chartBody) chartBody.innerHTML = '';

            history.forEach(item => {
                const d1 = parseInt(item.dice_1) || 1;
                const d2 = parseInt(item.dice_2) || 1;
                const d3 = parseInt(item.dice_3) || 1;
                const d1Img = DICE_MINI_IMAGES[d1] || DICE_MINI_IMAGES[1];
                const d2Img = DICE_MINI_IMAGES[d2] || DICE_MINI_IMAGES[2];
                const d3Img = DICE_MINI_IMAGES[d3] || DICE_MINI_IMAGES[3];

                // Table 1 Row: Game History (Period, Sum, Results)
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 transition border-b border-gray-100 text-xs';
                
                const sizeText = item.size === 'big' 
                    ? '<span class="text-[#f0ad4e] font-bold">Big</span>' 
                    : '<span class="text-[#5c88da] font-bold">Small</span>';
                
                const parityText = item.parity === 'odd'
                    ? '<span class="text-[#d9534f] font-bold">Odd</span>'
                    : '<span class="text-[#00b977] font-bold">Even</span>';

                tr.innerHTML = `
                    <td class="py-2.5 px-3 font-mono text-[11px] font-semibold text-gray-800 text-left">${item.period_number}</td>
                    <td class="py-2.5 px-3">
                        <div class="flex items-center justify-center gap-2">
                            <span class="font-black text-gray-900">${item.total_sum}</span>
                            ${sizeText}
                            ${parityText}
                        </div>
                    </td>
                    <td class="py-2.5 px-3 text-right">
                        <div class="flex justify-end items-center gap-1">
                            <img src="${d1Img}" alt="${d1}" class="w-5 h-5 object-contain drop-shadow-xs">
                            <img src="${d2Img}" alt="${d2}" class="w-5 h-5 object-contain drop-shadow-xs">
                            <img src="${d3Img}" alt="${d3}" class="w-5 h-5 object-contain drop-shadow-xs">
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // Table 2 Row: Chart (Period, Results, Number)
                if (chartBody) {
                    const ctr = document.createElement('tr');
                    ctr.className = 'hover:bg-gray-50 transition border-b border-gray-100 text-xs';

                    const diceSorted = [d1, d2, d3].sort((a,b)=>a-b);
                    const isContinuous = (diceSorted[1] === diceSorted[0] + 1 && diceSorted[2] === diceSorted[1] + 1);
                    const isTriple = (d1 === d2 && d2 === d3);
                    const isPair = (d1 === d2 || d2 === d3 || d1 === d3);

                    let patternText = '3 different numbers';
                    if (isTriple) {
                        patternText = '3 same numbers';
                    } else if (isContinuous) {
                        patternText = '3 continuous numbers';
                    } else if (isPair) {
                        patternText = '2 same numbers';
                    }

                    ctr.innerHTML = `
                        <td class="py-2.5 px-3 font-mono text-[11px] font-semibold text-gray-800 text-left">${item.period_number}</td>
                        <td class="py-2.5 px-3">
                            <div class="flex justify-center items-center gap-1">
                                <img src="${d1Img}" alt="${d1}" class="w-5 h-5 object-contain drop-shadow-xs">
                                <img src="${d2Img}" alt="${d2}" class="w-5 h-5 object-contain drop-shadow-xs">
                                <img src="${d3Img}" alt="${d3}" class="w-5 h-5 object-contain drop-shadow-xs">
                            </div>
                        </td>
                        <td class="py-2.5 px-3 text-right text-xs font-semibold text-gray-800">${patternText}</td>
                    `;
                    chartBody.appendChild(ctr);
                }
            });
        }

        function loadMyHistory() {
            fetch(`/games/k3/my-history?type=${currentTimeType}`)
                .then(res => res.json())
                .then(data => {
                    const list = document.getElementById('my-history-list');
                    if (!list) return;

                    if (!data.history || data.history.length === 0) {
                        list.innerHTML = `<div class="text-center py-6 text-gray-400 text-xs">No bets placed in this timeframe yet.</div>`;
                        return;
                    }

                    list.innerHTML = '';
                    data.history.forEach(bet => {
                        const isWon = bet.status === 'won';
                        const isPending = bet.status === 'pending';
                        
                        const statusBadge = isPending 
                            ? `<span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Pending</span>`
                            : (isWon 
                                ? `<span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2 py-0.5 rounded-full">+৳ ${parseFloat(bet.win_amount).toFixed(2)}</span>`
                                : `<span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full">Lost</span>`
                              );

                        let diceResultHtml = '';
                        if (bet.period && bet.period.dice_1) {
                            const d1 = DICE_MINI_IMAGES[bet.period.dice_1] || DICE_MINI_IMAGES[1];
                            const d2 = DICE_MINI_IMAGES[bet.period.dice_2] || DICE_MINI_IMAGES[2];
                            const d3 = DICE_MINI_IMAGES[bet.period.dice_3] || DICE_MINI_IMAGES[3];
                            diceResultHtml = `
                                <div class="flex items-center gap-1 mt-1">
                                    <img src="${d1}" class="w-4 h-4 object-contain">
                                    <img src="${d2}" class="w-4 h-4 object-contain">
                                    <img src="${d3}" class="w-4 h-4 object-contain">
                                    <span class="text-[10px] font-bold text-gray-600 ml-1">Sum: ${bet.period.total_sum}</span>
                                </div>
                            `;
                        }

                        const card = document.createElement('div');
                        card.className = 'bg-white p-3 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between text-xs';
                        card.innerHTML = `
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="font-mono font-bold text-gray-800">${bet.period ? bet.period.period_number.slice(-5) : '--'}</span>
                                    <span class="text-[11px] font-bold uppercase text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">${bet.bet_type}: ${bet.selected_value}</span>
                                </div>
                                <div class="text-[10px] text-gray-400 font-semibold">Bet Amount: ৳ ${parseFloat(bet.total_amount).toFixed(2)}</div>
                                ${diceResultHtml}
                            </div>
                            <div class="text-right">${statusBadge}</div>
                        `;
                        list.appendChild(card);
                    });
                })
                .catch(() => {});
        }

        function syncState() {
            const refreshIcon = document.getElementById('refresh-icon');
            if (refreshIcon) refreshIcon.classList.add('fa-spin');

            fetch(`/games/k3/state?type=${currentTimeType}`)
                .then(res => res.json())
                .then(data => {
                    if (refreshIcon) refreshIcon.classList.remove('fa-spin');
                    if (data.settings) {
                        k3Settings = Object.assign({}, k3Settings, data.settings);
                    }

                    const pNum = document.getElementById('period-number');
                    if (pNum) pNum.innerText = data.period_number;
                    renderTimer(data.time_remaining);

                    if (data.user_balance !== null && !isDemoMode) {
                        document.querySelectorAll('.header-balance-value').forEach(el => {
                            el.innerText = parseFloat(data.user_balance).toFixed(2);
                        });
                    }

                    // On Initial Load
                    if (!lastSettledPeriod) {
                        lastSettledPeriod = data.period_number;
                        setDiceValues(data.last_dice_1, data.last_dice_2, data.last_dice_3);
                    } else if (data.period_number !== lastSettledPeriod || data.time_remaining === 0) {
                        // Round settlement trigger at 0s / new period
                        if (data.period_number !== lastSettledPeriod) {
                            lastSettledPeriod = data.period_number;
                            if (!isRolling) {
                                startDiceRolling();
                                AudioEngine.playRollSound();

                                if (settlementTimeout) clearTimeout(settlementTimeout);
                                settlementTimeout = setTimeout(() => {
                                    stopDiceRolling(data.last_dice_1, data.last_dice_2, data.last_dice_3);
                                    if (currentBottomTab === 'my_history') {
                                        loadMyHistory();
                                    }
                                }, 2200);
                            }
                        }
                    } else {
                        // During normal betting & 5s countdown: DICE REMAIN STILL!
                        if (!isRolling) {
                            setDiceValues(data.last_dice_1, data.last_dice_2, data.last_dice_3);
                        }
                    }

                    renderHistory(data.history);
                })
                .catch(err => {
                    if (refreshIcon) refreshIcon.classList.remove('fa-spin');
                });
        }

        function submitK3Bet() {
            const betsArray = Object.values(selectedBets).map(item => ({
                bet_type: item.type,
                selected_value: item.val
            }));

            if (betsArray.length === 0) return;

            if (isDemoMode && demoBetsCount >= 3) {
                closeBetModal();
                const dModal = document.getElementById('deposit-modal');
                if (dModal) dModal.classList.remove('hidden');
                return;
            }

            const totalChargeEl = document.getElementById('total-bet-charge');
            const totalChargeStr = totalChargeEl ? totalChargeEl.innerText : '0.00';

            const btn = document.getElementById('confirm-bet-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-1"></i> Processing...`;
            }

            fetch("/games/k3/bet", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    time_type: currentTimeType,
                    bets: betsArray,
                    amount: baseAmount * currentQuantity,
                    multiplier: currentMultiplier,
                    is_demo: isDemoMode,
                    demo_bets_count: demoBetsCount
                })
            })
            .then(res => res.json())
            .then(data => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = `Total amount ৳<span id="total-bet-charge">${totalChargeStr}</span>`;
                }

                if (data.deposit_required) {
                    closeBetModal();
                    const dModal = document.getElementById('deposit-modal');
                    if (dModal) dModal.classList.remove('hidden');
                    return;
                }
                if (data.error) {
                    alert(data.error);
                    return;
                }

                closeBetModal();
                AudioEngine.playBeep(950, 0.2);

                if (!isDemoMode && data.new_balance !== null) {
                    document.querySelectorAll('.header-balance-value').forEach(el => {
                        el.innerText = parseFloat(data.new_balance).toFixed(2);
                    });
                }

                // Show toast
                const toast = document.getElementById('win-toast');
                const tMsg = document.getElementById('win-toast-msg');
                if (tMsg) tMsg.innerText = "Bet Confirmed Successfully!";
                if (toast) {
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 2500);
                }

                syncState();
            })
            .catch(err => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = `Total amount ৳<span id="total-bet-charge">${totalChargeStr}</span>`;
                }
                alert("বেট প্রসেসিং ত্রুটি হয়েছে! অনুগ্রহ করে আবার চেষ্টা করুন।");
            });
        }

        // Initialize state
        setDiceValues(1, 2, 3);
        syncState();
        setInterval(syncState, 1000);
    </script>
</body>
</html>
