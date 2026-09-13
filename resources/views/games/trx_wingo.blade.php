<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trx Win Go — AMAR CLUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&family=Noto+Sans+Bengali:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Noto Sans Bengali', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: #091322;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .game-wrapper {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            padding-bottom: 30px;
            overflow-x: hidden;
            margin: 16px 0 40px 0;
            border-radius: 20px;
        }

        /* 3D Glossy Tron Hash Result Balls */
        .ball-tron-hash {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, #ff8c8c 0%, #ff4757 45%, #d63031 90%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25), inset 0 2px 5px rgba(255, 255, 255, 0.7);
            position: relative;
            user-select: none;
            transition: transform 0.2s ease;
        }
        .ball-tron-hash .ball-inner {
            width: 28px;
            height: 28px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff3b44;
            font-weight: 900;
            font-size: 16px;
            box-shadow: inset 0 1.5px 3px rgba(0, 0, 0, 0.25);
        }

        /* 3D Glossy Ball Styles */
        .ball-3d {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #ffffff;
            border-radius: 50%;
            user-select: none;
            box-shadow: 
                inset -3px -3px 8px rgba(0, 0, 0, 0.35),
                inset 3px 3px 8px rgba(255, 255, 255, 0.8),
                0 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.15s ease, filter 0.15s ease;
        }
        .ball-3d:active {
            transform: scale(0.92);
        }

        .ball-green {
            background: radial-gradient(circle at 35% 30%, #34d399 0%, #00b977 45%, #047857 90%);
        }
        .ball-red {
            background: radial-gradient(circle at 35% 30%, #ff7675 0%, #ff4757 45%, #d63031 90%);
        }
        .ball-violet {
            background: radial-gradient(circle at 35% 30%, #d980fa 0%, #b55fe6 45%, #8854d0 90%);
        }
        .ball-orange {
            background: radial-gradient(circle at 35% 30%, #fed330 0%, #ffa502 45%, #fa8231 90%);
        }
        .ball-blue {
            background: radial-gradient(circle at 35% 30%, #70a1ff 0%, #5352ed 45%, #3742fa 90%);
        }

        /* Two-tone split balls for 0 and 5 */
        .ball-split-0 {
            background: linear-gradient(135deg, #ff4757 50%, #b55fe6 50%);
            box-shadow: inset -2px -2px 6px rgba(0,0,0,0.3), inset 2px 2px 6px rgba(255,255,255,0.7), 0 3px 6px rgba(0,0,0,0.15);
        }
        .ball-split-5 {
            background: linear-gradient(135deg, #00b977 50%, #b55fe6 50%);
            box-shadow: inset -2px -2px 6px rgba(0,0,0,0.3), inset 2px 2px 6px rgba(255,255,255,0.7), 0 3px 6px rgba(0,0,0,0.15);
        }

        /* Tear ticket card using exact uploaded background image */
        .ticket-card {
            background-image: url('{{ asset('assets/image/trxwin/ticket-bg.png') }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
            padding: 12px 16px 20px 16px;
            width: 100%;
            min-height: 185px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Multiplier active pill */
        .mult-active {
            background: #ff5252 !important;
            color: #ffffff !important;
            border-color: #ff5252 !important;
        }

        /* Digital Timer Digits */
        .time-box {
            background: #ffffff;
            color: #00b977;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* SVG Chart */
        .chart-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }
    </style>
</head>
<body class="landing-body theme-Bettingsite-active {{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">

    <!-- 1xBet / Platform Top Navigation Header -->
    @include('customer.header')

    <div class="w-full flex justify-center py-4 px-2">
        <div class="game-wrapper shadow-2xl">
            
            <!-- TrxWinGo Mini Header Bar (Back button, Title, Mute audio, Support) -->
            <div class="bg-gradient-to-r from-[#00b977] to-[#009e66] px-4 py-3 text-white flex items-center justify-between shadow-sm">
                <a href="{{ route('dashboard') }}" class="text-white text-base w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 active:scale-95 transition">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <div class="flex items-center gap-2 font-black text-lg tracking-wider">
                    <i class="fa-solid fa-crown text-yellow-300"></i>
                    <span>TrxWinGo</span>
                </div>
                <div class="flex items-center gap-2 text-base">
                    <button onclick="toggleAudio()" id="audio-btn" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 text-white/90">
                        <i class="fa-solid fa-volume-high" id="audio-icon"></i>
                    </button>
                    <a href="{{ route('dashboard') }}?tab=support" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 text-white/90">
                        <i class="fa-solid fa-headphones"></i>
                    </a>
                </div>
            </div>

            <!-- নোটিশ বার -->
            <div class="px-4 mt-2.5">
                <div class="bg-white rounded-xl px-3 py-2 flex items-center justify-between shadow-sm text-xs text-gray-600 border border-gray-100">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <i class="fa-solid fa-volume-high text-[#00b977] shrink-0"></i>
                        <span class="truncate text-[11px] font-medium">1. Welcome to TrxWinGo on AMAR CLUB! 100% Fair TRON public chain lottery.</span>
                    </div>
                    <button onclick="openNoticeModal()" class="bg-[#00b977] hover:bg-[#00a368] text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold shrink-0 shadow-sm flex items-center gap-1">
                        <i class="fa-solid fa-fire"></i> Detail
                    </button>
                </div>
            </div>

            <!-- TrxWinGo টাইম টাইপ ট্যাবস (1m, 3m, 5m) -->
            <div class="px-4 mt-3">
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="changeTimeType('1m')" id="tab-time-1m" class="time-tab-btn bg-[#00b977] text-white p-2.5 rounded-2xl flex flex-col items-center justify-center shadow-md transition">
                        <i class="fa-solid fa-clock text-lg mb-1"></i>
                        <span class="text-xs font-black leading-tight text-center">TrxWinGo<br>1 Min</span>
                    </button>
                    <button onclick="changeTimeType('3m')" id="tab-time-3m" class="time-tab-btn bg-[#f1f3f8] text-gray-600 p-2.5 rounded-2xl flex flex-col items-center justify-center border border-gray-200 transition">
                        <i class="fa-regular fa-clock text-lg mb-1"></i>
                        <span class="text-xs font-bold leading-tight text-center">TrxWinGo<br>3 Min</span>
                    </button>
                    <button onclick="changeTimeType('5m')" id="tab-time-5m" class="time-tab-btn bg-[#f1f3f8] text-gray-600 p-2.5 rounded-2xl flex flex-col items-center justify-center border border-gray-200 transition">
                        <i class="fa-regular fa-clock text-lg mb-1"></i>
                        <span class="text-xs font-bold leading-tight text-center">TrxWinGo<br>5 Min</span>
                    </button>
                </div>
            </div>

            <!-- ট্রন হ্যাশ ও কাউন্টডাউন টিকেট কার্ড (Ticket Tear Effect with Image Background) -->
            <div class="px-4 mt-3">
                <div class="ticket-card text-white">
                    <!-- Top Section -->
                    <div>
                        <!-- Top row buttons -->
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-1.5">
                                <button class="border border-white/70 text-white rounded-full px-2.5 py-0.5 text-[11px] font-bold">Period</button>
                                <button onclick="openHowToPlayModal()" class="border border-white/70 text-white rounded-full px-2.5 py-0.5 text-[11px] font-bold flex items-center gap-1 hover:bg-white/20 transition">
                                    <i class="fa-solid fa-book-open"></i> How to play
                                </button>
                            </div>
                            <button onclick="openPublicChainModal()" class="bg-white text-[#00b977] hover:bg-gray-50 rounded-full px-2.5 py-0.5 text-[11px] font-extrabold flex items-center gap-1 shadow transition">
                                <i class="fa-solid fa-magnifying-glass"></i> Public Chain Query
                            </button>
                        </div>

                        <!-- Period Number & Draw Time -->
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black tracking-wider font-mono text-white/95" id="period-number">20260913103010158</span>
                            <div class="flex items-center gap-1">
                                <span class="text-[11px] font-bold text-white/90 mr-1">Draw time</span>
                                <div class="flex items-center gap-1">
                                    <span class="time-box" id="timer-m1">0</span>
                                    <span class="time-box" id="timer-m2">0</span>
                                    <span class="text-white font-bold text-sm">:</span>
                                    <span class="time-box" id="timer-s1">2</span>
                                    <span class="time-box" id="timer-s2">5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Section: ট্রন ব্লক হ্যাশের শেষ ৫টি বল (Exact 3D Images) -->
                    <div class="flex justify-around items-center px-1 pb-1 pt-4" id="hash-balls-container">
                        <img src="{{ asset('assets/image/trxwin/num2-Bvv5rn-G.png') }}" class="w-11 h-11 object-contain drop-shadow-md">
                        <img src="{{ asset('assets/image/trxwin/num3-DV8hFrzX.png') }}" class="w-11 h-11 object-contain drop-shadow-md">
                        <img src="{{ asset('assets/image/trxwin/ball_1-DBPuytL4.png') }}" class="w-11 h-11 object-contain drop-shadow-md">
                        <img src="{{ asset('assets/image/trxwin/num5-D4gkhTiS.png') }}" class="w-11 h-11 object-contain drop-shadow-md">
                        <img src="{{ asset('assets/image/trxwin/num2-Bvv5rn-G.png') }}" class="w-11 h-11 object-contain drop-shadow-md">
                    </div>
                </div>
            </div>

            <!-- কালার বাটন (Green, Violet, Red) -->
            <div class="grid grid-cols-3 gap-3 px-4 mt-3">
                <button onclick="openBetModal('color', 'green')" class="bg-[#00b977] hover:bg-[#00a368] text-white py-2.5 rounded-xl font-black text-sm shadow-md transition active:scale-95">Green</button>
                <button onclick="openBetModal('color', 'violet')" class="bg-[#b55fe6] hover:bg-[#a24ed3] text-white py-2.5 rounded-xl font-black text-sm shadow-md transition active:scale-95">Violet</button>
                <button onclick="openBetModal('color', 'red')" class="bg-[#ff4757] hover:bg-[#e84118] text-white py-2.5 rounded-xl font-black text-sm shadow-md transition active:scale-95">Red</button>
            </div>

            <!-- ০ থেকে ৯ নম্বর গ্রিড (Exact Amar Club 3D Ball Assets from trxwin/) -->
            <div class="px-4 mt-3">
                <div class="bg-[#f8f9fd] rounded-2xl p-3.5 border border-gray-100 shadow-inner">
                    <div class="grid grid-cols-5 gap-y-3.5 justify-items-center">
                        @php
                            $bettingBallImgs = [
                                0 => 'n0-CZn09L9_.png',
                                1 => 'n1-DQoihf6M.png',
                                2 => 'n2-BQEJsjCG.png',
                                3 => 'n3-CL6BSoCp.png',
                                4 => 'n4-Bcu83fVD.png',
                                5 => 'n5-DcVy1j2M.png',
                                6 => 'n6-Bn7RijZz.png',
                                7 => 'n7-DEr_Nr5_.png',
                                8 => 'n8-CycLBQmW.png',
                                9 => 'n9-BWcCmBZJ.png',
                            ];
                        @endphp
                        @for($i = 0; $i <= 9; $i++)
                            <button onclick="openBetModal('number', '{{ $i }}')" class="transition transform hover:scale-105 active:scale-95 focus:outline-none">
                                <img src="{{ asset('assets/image/trxwin/' . $bettingBallImgs[$i]) }}" alt="{{ $i }}" class="w-12 h-12 object-contain drop-shadow-md">
                            </button>
                        @endfor
                    </div>
                </div>
            </div>

        <!-- মাল্টিপ্লায়ার ও র‍্যান্ডম বাটন -->
        <div class="px-4 mt-3">
            <div class="flex items-center gap-1.5 overflow-x-auto py-1 no-scrollbar">
                <button onclick="selectRandomNumber()" class="px-3 py-1.5 bg-white rounded-lg text-xs font-bold text-red-500 border border-red-300 hover:bg-red-50 transition shrink-0 active:scale-95">
                    Random
                </button>
                <button onclick="setMultiplier(1)" id="m-1" class="mult-btn mult-active px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X1</button>
                <button onclick="setMultiplier(5)" id="m-5" class="mult-btn px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X5</button>
                <button onclick="setMultiplier(10)" id="m-10" class="mult-btn px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X10</button>
                <button onclick="setMultiplier(20)" id="m-20" class="mult-btn px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X20</button>
                <button onclick="setMultiplier(50)" id="m-50" class="mult-btn px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X50</button>
                <button onclick="setMultiplier(100)" id="m-100" class="mult-btn px-3 py-1.5 bg-gray-100 rounded-lg text-xs font-bold text-gray-700 border border-gray-200 transition shrink-0">X100</button>
            </div>
        </div>

        <!-- Big / Small বাটন -->
        <div class="grid grid-cols-2 gap-3 px-4 mt-2">
            <button onclick="openBetModal('size', 'big')" class="bg-[#ffa502] hover:bg-[#e59400] text-white py-2.5 rounded-xl font-black text-sm shadow-md transition active:scale-95">Big</button>
            <button onclick="openBetModal('size', 'small')" class="bg-[#5352ed] hover:bg-[#3742fa] text-white py-2.5 rounded-xl font-black text-sm shadow-md transition active:scale-95">Small</button>
        </div>

        <!-- গেম হিস্ট্রি, চার্ট ও মাই হিস্ট্রি ট্যাব -->
        <div class="px-4 mt-6">
            <div class="grid grid-cols-3 bg-[#f1f3f8] p-1 rounded-xl text-xs font-bold text-gray-500 mb-3">
                <button onclick="switchHistoryTab('history')" id="tab-btn-history" class="py-2 rounded-lg bg-[#00b977] text-white transition shadow-sm">Game history</button>
                <button onclick="switchHistoryTab('chart')" id="tab-btn-chart" class="py-2 rounded-lg transition">Chart</button>
                <button onclick="switchHistoryTab('my')" id="tab-btn-my" class="py-2 rounded-lg transition">My history</button>
            </div>

            <!-- ১. গেম হিস্ট্রি (ব্লকচেইন হ্যাশ টেবিল) -->
            <div id="section-history">
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-center text-xs">
                        <thead>
                            <tr class="bg-[#00b977] text-white font-bold">
                                <th class="py-2.5 px-2">Period</th>
                                <th class="py-2.5 px-2">Block height</th>
                                <th class="py-2.5 px-2">Block time</th>
                                <th class="py-2.5 px-2">Hash value</th>
                                <th class="py-2.5 px-2">Result</th>
                            </tr>
                        </thead>
                        <tbody id="history-tbody" class="divide-y divide-gray-100 text-gray-600 font-medium bg-white">
                            <!-- ডাইনামিক ডেটা লোড হবে -->
                        </tbody>
                    </table>
                </div>

                <!-- পেজিনেশন -->
                <div class="flex items-center justify-center gap-4 mt-3 text-xs text-gray-500">
                    <button onclick="prevPage()" class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition"><i class="fa-solid fa-chevron-left"></i></button>
                    <span id="page-display" class="font-bold">1 / 5</span>
                    <button onclick="nextPage()" class="w-7 h-7 rounded-lg bg-[#00b977] text-white flex items-center justify-center hover:bg-[#00a368] transition"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- ২. চার্ট ও ট্রেন্ড অ্যানালাইসিস (জিগজ্যাগ চার্ট) -->
            <div id="section-chart" class="hidden">
                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm mb-3 text-[11px] space-y-1.5">
                    <div class="font-black text-gray-800 flex items-center justify-between">
                        <span>Statistic (last 100 Periods)</span>
                    </div>
                    
                    <!-- Stats Grid for 0-9 -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-center text-[10px]">
                            <thead>
                                <tr class="text-gray-400 font-semibold border-b">
                                    <th class="text-left py-1">Num</th>
                                    @for($i = 0; $i <= 9; $i++)
                                        <th class="py-1">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-600 font-mono">
                                <tr>
                                    <td class="text-left font-sans font-bold text-gray-400">Missing</td>
                                    @for($i = 0; $i <= 9; $i++)
                                        <td id="stat-missing-{{ $i }}">0</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="text-left font-sans font-bold text-gray-400">Avg missing</td>
                                    @for($i = 0; $i <= 9; $i++)
                                        <td id="stat-avg-{{ $i }}">5</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="text-left font-sans font-bold text-gray-400">Frequency</td>
                                    @for($i = 0; $i <= 9; $i++)
                                        <td id="stat-freq-{{ $i }}">0</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="text-left font-sans font-bold text-gray-400">Max consec</td>
                                    @for($i = 0; $i <= 9; $i++)
                                        <td id="stat-max-{{ $i }}">0</td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- জিগজ্যাগ ট্রেন্ড রো ও SVG লাইন -->
                <div class="relative bg-white rounded-xl border border-gray-100 p-2 shadow-sm overflow-hidden" id="trend-chart-box">
                    <svg id="trend-svg" class="chart-svg"></svg>
                    <div id="trend-rows" class="space-y-1.5 relative z-20">
                        <!-- ট্রেন্ড রোগুলো লোড হবে -->
                    </div>
                </div>
            </div>

            <!-- ৩. মাই হিস্ট্রি -->
            <div id="section-my" class="hidden">
                <div id="my-history-list" class="space-y-2">
                    <!-- লোডিং বা বেট লিস্ট আসবে -->
                </div>
            </div>
        </div>

    </div>

    <!-- শেষ ৫ সেকেন্ডের কাউন্টডাউন ফুল-কার্ড লক ওভারলে (Screenshot 2 Match) -->
    <div id="countdown-overlay" class="fixed inset-0 bg-black/40 z-40 flex items-center justify-center hidden backdrop-blur-[2px]">
        <div class="flex gap-4 animate-pulse">
            <div class="w-32 h-44 bg-white rounded-[32px] shadow-2xl flex items-center justify-center text-[100px] font-black text-[#00b977] leading-none" id="overlay-d1">0</div>
            <div class="w-32 h-44 bg-white rounded-[32px] shadow-2xl flex items-center justify-center text-[100px] font-black text-[#00b977] leading-none" id="overlay-d2">5</div>
        </div>
    </div>

    <!-- বেটিং কনফার্মেশন বটম শিট মডাল -->
    <div id="bet-modal" class="fixed inset-0 bg-black/60 z-50 flex items-end justify-center hidden backdrop-blur-xs">
        <div class="bg-white w-full max-w-[430px] rounded-t-3xl p-5 shadow-2xl animate-in slide-in-from-bottom duration-200">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-black text-base text-gray-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-cube text-[#00b977]"></i> TrxWinGo <span id="modal-time-label">1 Min</span>
                </h3>
                <button onclick="closeBetModal()" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="bg-[#f8f9fd] p-3 rounded-xl mb-3 flex items-center justify-between border border-gray-100">
                <span class="text-xs text-gray-500 font-bold">Selection:</span>
                <span class="text-base font-black uppercase text-[#00b977] tracking-wider" id="modal-selection">GREEN</span>
            </div>

            <!-- Base Bet Selector Chips -->
            <div class="flex justify-between items-center gap-2 mb-3">
                <span class="text-xs font-bold text-gray-500">Balance:</span>
                <div class="flex gap-1.5">
                    <button onclick="setBaseAmount(1)" class="amt-chip bg-[#00b977] text-white px-3 py-1 rounded-lg text-xs font-bold">1</button>
                    <button onclick="setBaseAmount(10)" class="amt-chip bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-bold">10</button>
                    <button onclick="setBaseAmount(100)" class="amt-chip bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-bold">100</button>
                    <button onclick="setBaseAmount(1000)" class="amt-chip bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-bold">1000</button>
                </div>
            </div>

            <!-- Multiplier Selector -->
            <div class="flex justify-between items-center gap-2 mb-4">
                <span class="text-xs font-bold text-gray-500">Multiplier:</span>
                <div class="flex items-center gap-1">
                    <button onclick="changeModalMult(-1)" class="w-7 h-7 bg-gray-100 rounded-lg text-gray-700 font-black text-xs">-</button>
                    <input type="number" id="modal-mult-input" value="1" min="1" max="1000" onchange="onModalMultChange(this.value)" class="w-14 text-center text-xs font-black bg-gray-50 border rounded-lg py-1">
                    <button onclick="changeModalMult(1)" class="w-7 h-7 bg-gray-100 rounded-lg text-gray-700 font-black text-xs">+</button>
                </div>
            </div>

            <!-- Total Calculation & Agree Checkbox -->
            <div class="flex justify-between items-center text-xs font-bold text-gray-600 mb-4 bg-gray-50 p-2.5 rounded-xl">
                <span>Total Amount:</span>
                <span class="text-lg text-red-500 font-black">৳ <span id="total-bet-display">1.00</span></span>
            </div>

            <button onclick="submitTrxBet()" id="confirm-bet-btn" class="w-full bg-[#00b977] hover:bg-[#00a368] active:scale-98 text-white py-3.5 rounded-full font-black text-sm shadow-lg transition">
                Confirm Bet
            </button>
        </div>
    </div>

    <!-- How To Play Modal -->
    <div id="how-to-play-modal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl p-5 max-w-sm w-full shadow-2xl text-gray-800 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-3 border-b pb-2">
                <h4 class="font-black text-base flex items-center gap-2 text-[#00b977]">
                    <i class="fa-solid fa-book-open"></i> How to play TrxWinGo
                </h4>
                <button onclick="document.getElementById('how-to-play-modal').classList.add('hidden')" class="text-gray-400 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="text-xs text-gray-600 space-y-2 leading-relaxed" id="how-to-play-content">
                <!-- Dynamically loaded from settings -->
            </div>
            <button onclick="document.getElementById('how-to-play-modal').classList.add('hidden')" class="w-full mt-4 bg-[#00b977] text-white font-bold py-2 rounded-full text-xs shadow">
                বুঝেছি
            </button>
        </div>
    </div>

    <!-- Public Chain Query Modal -->
    <div id="public-chain-modal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl p-5 max-w-sm w-full shadow-2xl text-gray-800">
            <div class="flex justify-between items-center mb-3 border-b pb-2">
                <h4 class="font-black text-base flex items-center gap-2 text-cyan-600">
                    <i class="fa-solid fa-cubes"></i> TRON Public Chain Query
                </h4>
                <button onclick="document.getElementById('public-chain-modal').classList.add('hidden')" class="text-gray-400 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="text-xs text-gray-600 space-y-3 leading-relaxed">
                <p>
                    <strong class="text-gray-800">Provably Fair Algorithm:</strong>
                    TrxWinGo প্রতিটি রাউন্ডের ফলাফল ট্রন (TRON) পাবলিক ব্লকচেইন নেটওয়ার্কের জেনারেটেড ব্লকের ইউনিক হ্যাশ থেকে গ্রহণ করে।
                </p>
                <div class="bg-gray-50 p-3 rounded-xl border text-[11px] font-mono space-y-1">
                    <div>Latest Block: <span class="text-[#00b977] font-bold" id="chain-block-height">86198252</span></div>
                    <div>Block Time: <span class="text-gray-500" id="chain-block-time">--:--:--</span></div>
                    <div class="truncate">Hash: <span class="text-purple-600 font-bold" id="chain-hash">00000000052345ca23</span></div>
                </div>
                <p class="text-[11px] text-gray-500">
                    হ্যাশের শেষ ৫টি ডিজিট লটারি বল হিসেবে স্ক্রিনে প্রদর্শিত হয় এবং সর্বশেষ সংখ্যাটিই ফলাফল নির্ধারিত করে।
                </p>
            </div>
            <button onclick="document.getElementById('public-chain-modal').classList.add('hidden')" class="w-full mt-4 bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 rounded-full text-xs shadow">
                বন্ধ করুন
            </button>
        </div>
    </div>

    <!-- ডিপোজিট প্রয়োজন পপ-আপ -->
    <div id="deposit-modal" class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-3xl p-6 text-center max-w-xs w-full shadow-2xl">
            <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-500 flex items-center justify-center text-2xl mx-auto mb-3">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h4 class="font-extrabold text-base text-gray-800 mb-2">ডেমো লিমিট শেষ!</h4>
            <p class="text-xs text-gray-500 mb-4">আসল টাকা দিয়ে খেলে উইন ব্যালেন্স তুলতে এখনই ডিপোজিট করুন।</p>
            <a href="{{ route('dashboard') }}?tab=deposit" class="block w-full bg-[#00b977] hover:bg-[#00a368] text-white font-bold py-2.5 rounded-full text-xs mb-2 shadow">ডিপোজিট করুন</a>
            <button onclick="document.getElementById('deposit-modal').classList.add('hidden')" class="text-xs text-gray-400">বন্ধ করুন</button>
        </div>
    </div>

    <!-- গেম ইঞ্জিন স্ক্রিপ্ট -->
    <script>
        let currentTimeType = '1m';
        let currentMultiplier = 1;
        let baseAmount = 1;
        let selectedBetType = null;
        let selectedValue = null;
        let isDemoMode = false;
        let demoBetsCount = 0;
        let lastPeriodNumber = null;
        let cachedHistory = [];
        let currentPage = 1;
        const pageSize = 10;

        // Audio sounds
        const AudioEngine = {
            enabled: true,
            ctx: null,
            init() {
                if (!this.ctx) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) this.ctx = new AudioCtx();
                }
            },
            beep(freq, duration) {
                if (!this.enabled) return;
                try {
                    this.init();
                    if (!this.ctx) return;
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.frequency.value = freq;
                    gain.gain.value = 0.1;
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start();
                    setTimeout(() => osc.stop(), duration);
                } catch(e) {}
            },
            tick() { this.beep(800, 80); },
            lock() { this.beep(400, 150); },
            win() {
                this.beep(523, 100);
                setTimeout(() => this.beep(659, 100), 120);
                setTimeout(() => this.beep(784, 180), 240);
            }
        };

        function toggleAudio() {
            AudioEngine.enabled = !AudioEngine.enabled;
            const icon = document.getElementById('audio-icon');
            if (AudioEngine.enabled) {
                icon.className = 'fa-solid fa-volume-high';
            } else {
                icon.className = 'fa-solid fa-volume-xmark';
            }
        }

        function changeTimeType(type) {
            currentTimeType = type;
            ['1m', '3m', '5m'].forEach(t => {
                const btn = document.getElementById(`tab-time-${t}`);
                if (t === type) {
                    btn.className = 'time-tab-btn bg-[#00b977] text-white p-2.5 rounded-2xl flex flex-col items-center justify-center shadow-md transition';
                    btn.querySelector('i').className = 'fa-solid fa-clock text-lg mb-1';
                    btn.querySelector('span').className = 'text-xs font-black leading-tight text-center';
                } else {
                    btn.className = 'time-tab-btn bg-[#f1f3f8] text-gray-600 p-2.5 rounded-2xl flex flex-col items-center justify-center border border-gray-200 transition';
                    btn.querySelector('i').className = 'fa-regular fa-clock text-lg mb-1';
                    btn.querySelector('span').className = 'text-xs font-bold leading-tight text-center';
                }
            });
            document.getElementById('modal-time-label').innerText = type === '1m' ? '1 Min' : (type === '3m' ? '3 Min' : '5 Min');
            syncState();
        }

        function setMultiplier(val) {
            currentMultiplier = parseInt(val);
            document.querySelectorAll('.mult-btn').forEach(b => b.classList.remove('mult-active'));
            const activeBtn = document.getElementById(`m-${val}`);
            if (activeBtn) activeBtn.classList.add('mult-active');
            document.getElementById('modal-mult-input').value = currentMultiplier;
            updateTotalBet();
        }

        function setBaseAmount(val) {
            baseAmount = parseFloat(val);
            document.querySelectorAll('.amt-chip').forEach(b => {
                b.classList.remove('bg-[#00b977]', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700');
            });
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
            event.target.classList.add('bg-[#00b977]', 'text-white');
            updateTotalBet();
        }

        function changeModalMult(delta) {
            let val = parseInt(document.getElementById('modal-mult-input').value) || 1;
            val = Math.max(1, val + delta);
            document.getElementById('modal-mult-input').value = val;
            currentMultiplier = val;
            updateTotalBet();
        }

        function onModalMultChange(val) {
            let num = parseInt(val) || 1;
            currentMultiplier = Math.max(1, num);
            updateTotalBet();
        }

        function updateTotalBet() {
            const total = (baseAmount * currentMultiplier).toFixed(2);
            document.getElementById('total-bet-display').innerText = total;
        }

        function openBetModal(type, val) {
            selectedBetType = type;
            selectedValue = val;
            document.getElementById('modal-selection').innerText = `${type.toUpperCase()}: ${val.toUpperCase()}`;
            document.getElementById('bet-modal').classList.remove('hidden');
            updateTotalBet();
        }

        function closeBetModal() {
            document.getElementById('bet-modal').classList.add('hidden');
        }

        function selectRandomNumber() {
            const randNum = Math.floor(Math.random() * 10);
            openBetModal('number', String(randNum));
        }

        function switchHistoryTab(tab) {
            ['history', 'chart', 'my'].forEach(t => {
                document.getElementById(`section-${t}`).classList.add('hidden');
                document.getElementById(`tab-btn-${t}`).className = 'py-2 rounded-lg transition';
            });
            document.getElementById(`section-${tab}`).classList.remove('hidden');
            document.getElementById(`tab-btn-${tab}`).className = 'py-2 rounded-lg bg-[#00b977] text-white transition shadow-sm';

            if (tab === 'chart') {
                renderZigZagChart();
            } else if (tab === 'my') {
                fetchMyHistory();
            }
        }

        function openHowToPlayModal() {
            document.getElementById('how-to-play-modal').classList.remove('hidden');
        }

        function openPublicChainModal() {
            document.getElementById('public-chain-modal').classList.remove('hidden');
        }

        function openNoticeModal() {
            alert("Welcome to AMAR CLUB! Enjoy 100% fair and transparent TrxWinGo lottery.");
        }

        function syncState() {
            fetch(`{{ route('trxwingo.state') }}?type=${currentTimeType}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('period-number').innerText = data.period_number;
                    renderTimer(data.time_remaining);

                    if (data.user_balance !== null && !isDemoMode) {
                        document.getElementById('wallet-balance').innerText = '৳ ' + parseFloat(data.user_balance).toFixed(2);
                    }

                    // শেষ ১০ সেকেন্ডে কাউন্টডাউন লক ওভারলে (10, 9, 8, ... 00)
                    const overlay = document.getElementById('countdown-overlay');
                    if (data.time_remaining <= 10 && data.time_remaining >= 0) {
                        overlay.classList.remove('hidden');
                        const sStr = String(data.time_remaining).padStart(2, '0');
                        document.getElementById('overlay-d1').innerText = sStr[0];
                        document.getElementById('overlay-d2').innerText = sStr[1];
                        AudioEngine.lock();
                    } else {
                        overlay.classList.add('hidden');
                    }

                    // টপ ৫টি হ্যাশ বল রেন্ডার
                    if (data.last_completed && data.last_completed.hash_tail_chars) {
                        renderHashBalls(data.last_completed.hash_tail_chars);
                        document.getElementById('chain-block-height').innerText = data.last_completed.block_height || '---';
                        document.getElementById('chain-block-time').innerText = data.last_completed.block_time || '--:--:--';
                        document.getElementById('chain-hash').innerText = data.last_completed.hash_value || '---';
                    }

                    if (data.how_to_play) {
                        document.getElementById('how-to-play-content').innerText = data.how_to_play;
                    }

                    cachedHistory = data.history || [];
                    renderHistoryTable(cachedHistory);
                    renderStats(data.stats);

                    if (!document.getElementById('section-chart').classList.contains('hidden')) {
                        renderZigZagChart();
                    }
                })
                .catch(err => console.error("Sync error:", err));
        }

        function renderTimer(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            const strM = String(mins).padStart(2, '0');
            const strS = String(secs).padStart(2, '0');

            document.getElementById('timer-m1').innerText = strM[0];
            document.getElementById('timer-m2').innerText = strM[1];
            document.getElementById('timer-s1').innerText = strS[0];
            document.getElementById('timer-s2').innerText = strS[1];
        }

        const tronBallMap = {
            '0': '{{ asset('assets/image/trxwin/num0-DIDNb33N.png') }}',
            '1': '{{ asset('assets/image/trxwin/ball_1-DBPuytL4.png') }}',
            '2': '{{ asset('assets/image/trxwin/num2-Bvv5rn-G.png') }}',
            '3': '{{ asset('assets/image/trxwin/num3-DV8hFrzX.png') }}',
            '4': '{{ asset('assets/image/trxwin/num4-Bv6i1rtS.png') }}',
            '5': '{{ asset('assets/image/trxwin/num5-D4gkhTiS.png') }}',
            '6': '{{ asset('assets/image/trxwin/num6-C7DgXQ8W.png') }}',
            '7': '{{ asset('assets/image/trxwin/num7-BtV1JOs8.png') }}',
            '8': '{{ asset('assets/image/trxwin/num8-Bk5W04gi.png') }}',
            '9': '{{ asset('assets/image/trxwin/num9-Bqb7hgWB.png') }}',
            'A': '{{ asset('assets/image/trxwin/numA-BA1gzjEH.png') }}',
            'B': '{{ asset('assets/image/trxwin/numB-C86DFk0W.png') }}',
            'C': '{{ asset('assets/image/trxwin/numC-CFMIBL8C.png') }}',
            'D': '{{ asset('assets/image/trxwin/numD-CxyPDNfa.png') }}',
            'E': '{{ asset('assets/image/trxwin/numE-Jh_F8mIJ.png') }}',
            'F': '{{ asset('assets/image/trxwin/numF-CcJTPBGF.png') }}'
        };

        function renderHashBalls(chars) {
            const container = document.getElementById('hash-balls-container');
            if (!container || !chars || chars.length === 0) return;
            container.innerHTML = '';
            chars.forEach(char => {
                const key = String(char).toUpperCase();
                const src = tronBallMap[key] || tronBallMap['0'];
                const img = document.createElement('img');
                img.src = src;
                img.alt = key;
                img.className = 'w-11 h-11 object-contain drop-shadow-md';
                container.appendChild(img);
            });
        }

        function renderHistoryTable(history) {
            const tbody = document.getElementById('history-tbody');
            if (!tbody || !history) return;
            tbody.innerHTML = '';

            const totalPages = Math.max(1, Math.ceil(history.length / pageSize));
            currentPage = Math.min(currentPage, totalPages);
            document.getElementById('page-display').innerText = `${currentPage} / ${totalPages}`;

            const start = (currentPage - 1) * pageSize;
            const pageItems = history.slice(start, start + pageSize);

            pageItems.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50/80 transition';

                const shortPeriod = '202**' + item.period_number.slice(-4);
                const shortHash = '**' + (item.hash_value ? item.hash_value.slice(-4) : '0000');

                let ballClass = 'ball-red';
                if ([1,3,7,9].includes(item.winning_number)) ballClass = 'ball-green';
                else if (item.winning_number === 0) ballClass = 'ball-split-0';
                else if (item.winning_number === 5) ballClass = 'ball-split-5';

                const isBig = item.winning_size === 'big';

                tr.innerHTML = `
                    <td class="py-3 px-2 font-mono font-bold text-gray-700">${shortPeriod}</td>
                    <td class="py-3 px-2 font-mono text-gray-500 flex items-center justify-center gap-1">
                        <span class="w-3.5 h-3.5 rounded-full bg-red-400 text-white text-[9px] font-black inline-flex items-center justify-center">?</span>
                        <span>${item.block_height}</span>
                    </td>
                    <td class="py-3 px-2 text-gray-400 font-mono">${item.block_time}</td>
                    <td class="py-3 px-2 font-mono font-bold text-gray-800">${shortHash}</td>
                    <td class="py-3 px-2">
                        <div class="flex items-center justify-center gap-1.5">
                            <span class="ball-3d ${ballClass} w-5 h-5 text-[10px] font-black">${item.winning_number}</span>
                            <span class="font-black text-xs ${isBig ? 'text-amber-500' : 'text-blue-500'}">${isBig ? 'B' : 'S'}</span>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderHistoryTable(cachedHistory);
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(cachedHistory.length / pageSize);
            if (currentPage < totalPages) {
                currentPage++;
                renderHistoryTable(cachedHistory);
            }
        }

        function renderStats(stats) {
            if (!stats) return;
            for (let i = 0; i <= 9; i++) {
                const misEl = document.getElementById(`stat-missing-${i}`);
                if (misEl) misEl.innerText = stats.missing ? stats.missing[i] : 0;

                const avgEl = document.getElementById(`stat-avg-${i}`);
                if (avgEl) avgEl.innerText = stats.avg_missing ? stats.avg_missing[i] : 5;

                const freqEl = document.getElementById(`stat-freq-${i}`);
                if (freqEl) freqEl.innerText = stats.frequency ? stats.frequency[i] : 0;

                const maxEl = document.getElementById(`stat-max-${i}`);
                if (maxEl) maxEl.innerText = stats.max_consecutive ? stats.max_consecutive[i] : 0;
            }
        }

        function renderZigZagChart() {
            const container = document.getElementById('trend-rows');
            const svg = document.getElementById('trend-svg');
            if (!container || !cachedHistory || cachedHistory.length === 0) return;

            container.innerHTML = '';
            svg.innerHTML = '';

            const items = cachedHistory.slice(0, 15);
            const ballPositions = [];

            items.forEach((item, rowIdx) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-1 px-1 border-b border-gray-50';

                let numBalls = '';
                for (let i = 0; i <= 9; i++) {
                    if (i === item.winning_number) {
                        let bCls = 'ball-red';
                        if ([1,3,7,9].includes(i)) bCls = 'ball-green';
                        else if (i === 0) bCls = 'ball-split-0';
                        else if (i === 5) bCls = 'ball-split-5';

                        numBalls += `<span id="chart-ball-${rowIdx}" class="ball-3d ${bCls} w-5 h-5 text-[10px] font-black z-20">${i}</span>`;
                    } else {
                        numBalls += `<span class="w-5 h-5 rounded-full border border-gray-200 text-gray-400 font-bold text-[10px] flex items-center justify-center">${i}</span>`;
                    }
                }

                const isBig = item.winning_size === 'big';
                row.innerHTML = `
                    <span class="font-mono text-[10px] text-gray-400 w-24 truncate">${item.period_number}</span>
                    <div class="flex gap-1.5 items-center">${numBalls}</div>
                    <span class="font-black text-xs ${isBig ? 'text-amber-500' : 'text-blue-500'} w-4 text-right">${isBig ? 'B' : 'S'}</span>
                `;
                container.appendChild(row);
            });

            // Draw connecting SVG zigzag lines
            setTimeout(() => {
                const chartBox = document.getElementById('trend-chart-box');
                const boxRect = chartBox.getBoundingClientRect();
                let points = [];

                for (let i = 0; i < items.length; i++) {
                    const ball = document.getElementById(`chart-ball-${i}`);
                    if (ball) {
                        const bRect = ball.getBoundingClientRect();
                        const x = (bRect.left + bRect.width / 2) - boxRect.left;
                        const y = (bRect.top + bRect.height / 2) - boxRect.top;
                        points.push({x, y});
                    }
                }

                for (let i = 0; i < points.length - 1; i++) {
                    const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    line.setAttribute('x1', points[i].x);
                    line.setAttribute('y1', points[i].y);
                    line.setAttribute('x2', points[i+1].x);
                    line.setAttribute('y2', points[i+1].y);
                    line.setAttribute('stroke', '#ff4757');
                    line.setAttribute('stroke-width', '1.5');
                    line.setAttribute('stroke-dasharray', '2,2');
                    svg.appendChild(line);
                }
            }, 50);
        }

        function fetchMyHistory() {
            const list = document.getElementById('my-history-list');
            list.innerHTML = '<div class="text-center py-6 text-gray-400 text-xs">লোড হচ্ছে...</div>';

            fetch(`{{ route('trxwingo.myhistory') }}?is_demo=${isDemoMode ? 1 : 0}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.bets || data.bets.length === 0) {
                        list.innerHTML = `
                            <div class="text-center py-10">
                                <i class="fa-regular fa-file-lines text-gray-300 text-4xl mb-2"></i>
                                <p class="text-xs text-gray-400">কোনো হিস্ট্রি পাওয়া যায়নি</p>
                            </div>
                        `;
                        return;
                    }

                    list.innerHTML = '';
                    data.bets.forEach(bet => {
                        const isWon = bet.status === 'won';
                        const isPending = bet.status === 'pending';

                        const card = document.createElement('div');
                        card.className = 'bg-white p-3 rounded-xl border border-gray-100 shadow-sm text-xs space-y-1';
                        card.innerHTML = `
                            <div class="flex justify-between items-center font-bold">
                                <span class="font-mono text-gray-700">Period: ${bet.period_number}</span>
                                <span class="${isWon ? 'text-[#00b977]' : (isPending ? 'text-amber-500' : 'text-red-500')} uppercase">
                                    ${isWon ? '+৳ ' + bet.win_amount.toFixed(2) : (isPending ? 'Pending' : '-৳ ' + bet.total_amount.toFixed(2))}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-gray-500 text-[11px]">
                                <span>Select: <strong class="text-gray-800 uppercase">${bet.bet_type} (${bet.selected_value})</strong></span>
                                <span>Total: ৳${bet.total_amount.toFixed(2)}</span>
                            </div>
                            <div class="text-[10px] text-gray-400">${bet.date} ${bet.time}</div>
                        `;
                        list.appendChild(card);
                    });
                });
        }

        function submitTrxBet() {
            if (!selectedBetType || selectedValue === null) return;

            const confirmBtn = document.getElementById('confirm-bet-btn');
            confirmBtn.disabled = true;
            confirmBtn.innerText = 'সাবমিট হচ্ছে...';

            fetch("{{ route('trxwingo.bet') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    time_type: currentTimeType,
                    bet_type: selectedBetType,
                    selected_value: selectedValue,
                    amount: baseAmount,
                    multiplier: currentMultiplier,
                    is_demo: isDemoMode,
                    demo_bets_count: demoBetsCount
                })
            })
            .then(res => res.json())
            .then(data => {
                confirmBtn.disabled = false;
                confirmBtn.innerText = 'Confirm Bet';

                if (data.deposit_required) {
                    closeBetModal();
                    document.getElementById('deposit-modal').classList.remove('hidden');
                    return;
                }

                if (data.error) {
                    alert(data.error);
                    return;
                }

                closeBetModal();
                AudioEngine.win();

                if (data.new_balance !== null && data.new_balance !== undefined) {
                    document.getElementById('wallet-balance').innerText = '৳ ' + parseFloat(data.new_balance).toFixed(2);
                }

                // Show mini toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed top-12 left-1/2 -translate-x-1/2 bg-[#00b977] text-white text-xs font-bold px-4 py-2 rounded-full shadow-2xl z-50 animate-bounce';
                toast.innerText = '✓ বাজি সফলভাবে নিশ্চিত হয়েছে!';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2500);

                syncState();
            })
            .catch(err => {
                confirmBtn.disabled = false;
                confirmBtn.innerText = 'Confirm Bet';
                alert('সার্ভার এরর, পুনরায় চেষ্টা করুন');
            });
        }

        setInterval(syncState, 1000);
        syncState();
    </script>
</body>
</html>
