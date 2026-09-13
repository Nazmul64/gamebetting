<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrxWinGo — Admin House Profit & Tron Hash Control Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Noto+Sans+Bengali:wght@400;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --bg-dark: #070d18;
            --panel-bg: #0d172b;
            --panel-border: rgba(0, 185, 119, 0.25);
            --trx-red: #ff4757;
            --emerald: #00b977;
            --emerald-bright: #10b981;
            --cyan: #00f2fe;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Noto Sans Bengali', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            max-width: 1360px;
            margin: 0 auto;
        }

        .panel-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .form-input, .form-select, .form-textarea {
            background: #060e1d;
            border: 1px solid rgba(0, 185, 119, 0.3);
            color: #f8fafc;
            padding: 10px 14px;
            border-radius: 10px;
            outline: none;
            width: 100%;
            transition: border-color 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #00b977;
            box-shadow: 0 0 0 2px rgba(0, 185, 119, 0.25);
        }

        .num-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-weight: 800;
            font-size: 12px;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-8 border-b border-emerald-500/20 gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00b977] via-[#059669] to-[#ff4757] flex items-center justify-center text-white text-2xl shadow-lg border border-emerald-400/40">
                <i class="fa-solid fa-cube"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white flex items-center gap-2">
                    TrxWinGo Lottery <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">TRON Hash & Profit Control</span>
                </h1>
                <p class="text-xs text-slate-400 mt-1">TRON Public Chain Block Height, Hash Verification, Provably Fair Simulation & Instant Win/Loss Rigging</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('trxwingo.index') }}" target="_blank" class="px-4 py-2 bg-[#00b977] hover:bg-[#009b63] text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow">
                <i class="fa-solid fa-play"></i> Launch TrxWinGo
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold transition flex items-center gap-2 border border-slate-700">
                <i class="fa-solid fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500 text-emerald-300 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base"></i> {{ session('success') }}
        </div>
    @endif

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="panel-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Total Rounds</div>
                <div class="text-2xl font-black text-white">{{ number_format($stats['total_rounds']) }}</div>
            </div>
        </div>
        <div class="panel-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Total Real Bets</div>
                <div class="text-2xl font-black text-purple-300">৳ {{ number_format($stats['total_real_bets'], 2) }}</div>
            </div>
        </div>
        <div class="panel-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Total Payouts</div>
                <div class="text-2xl font-black text-amber-300">৳ {{ number_format($stats['total_payout'], 2) }}</div>
            </div>
        </div>
        <div class="panel-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-vault"></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Platform Net Profit</div>
                <div class="text-2xl font-black text-emerald-400">৳ {{ number_format($stats['admin_profit'], 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Live Active Rounds & Force Win/Loss Rigging Matrix -->
    <div class="panel-card mb-8 border border-emerald-500/40">
        <div class="flex items-center justify-between mb-4 border-b border-slate-700/60 pb-3">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping"></span>
                <h2 class="text-lg font-black text-white">Live Active Rounds & Instant Rigging Matrix</h2>
            </div>
            <span class="text-xs text-slate-400">রিয়েল-টাইম বেট ও প্রতিটি নম্বরের পেআউট অডিট</span>
        </div>

        @if($livePeriods->isEmpty())
            <div class="text-center py-6 text-slate-400 text-xs">কোনো অ্যাক্টিভ পিরিয়ড নেই। প্লেয়ার গেম খুললে স্বয়ংক্রিয়ভাবে শুরু হবে।</div>
        @else
            <div class="space-y-6">
                @foreach($livePeriods as $lp)
                    <div class="bg-[#081222] p-4 rounded-xl border border-slate-700/80">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-lg bg-[#00b977]/20 text-[#00b977] font-bold text-xs">TrxWinGo {{ $lp->time_type }}</span>
                                <span class="font-mono text-sm font-bold text-white">#{{ $lp->period_number }}</span>
                                <span class="text-xs text-slate-400"><i class="fa-solid fa-cubes mr-1 text-cyan-400"></i> Block: {{ $lp->block_height }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs font-bold">
                                <div>Real Bets: <span class="text-purple-400">৳ {{ number_format($lp->total_real_bets, 2) }}</span> ({{ $lp->bets->count() }} tickets)</div>
                                <div>Ends in: <span class="text-amber-400 font-mono text-sm">{{ max(0, Carbon\Carbon::now()->diffInSeconds($lp->ends_at, false)) }}s</span></div>
                            </div>
                        </div>

                        <!-- 0-9 Payout Simulation Table -->
                        <div class="overflow-x-auto mb-3">
                            <div class="text-[11px] font-bold text-slate-400 mb-1.5 flex items-center justify-between">
                                <span>পেআউট সিমুলেশন (কোন নম্বর ড্র হলে হাউজের কত টাকা বের হবে):</span>
                                <span class="text-emerald-400 text-[10px]"><i class="fa-solid fa-lightbulb mr-1"></i>সবুজ চিহ্নিত নম্বর হাউজের জন্য সবচেয়ে লাভজনক</span>
                            </div>
                            <div class="grid grid-cols-10 gap-1.5 min-w-[700px]">
                                @php
                                    $sims = $livePayoutSimulations[$lp->id] ?? [];
                                    $minVal = count($sims) ? min($sims) : 0;
                                @endphp
                                @for($n = 0; $n <= 9; $n++)
                                    @php
                                        $payout = $sims[$n] ?? 0;
                                        $isBest = ($payout == $minVal);
                                        $color = in_array($n, [1,3,7,9]) ? 'bg-emerald-600' : (in_array($n, [2,4,6,8]) ? 'bg-red-600' : 'bg-purple-600');
                                    @endphp
                                    <div class="p-2 rounded-lg text-center border {{ $isBest ? 'border-emerald-400 bg-emerald-950/40 shadow-sm' : 'border-slate-800 bg-[#0c182c]' }}">
                                        <div class="w-6 h-6 mx-auto rounded-full {{ $color }} text-white text-xs font-black flex items-center justify-center mb-1 shadow">{{ $n }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">৳ {{ number_format($payout, 1) }}</div>
                                        <div class="text-[9px] {{ $lp->total_real_bets - $payout >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold">
                                            {{ $lp->total_real_bets - $payout >= 0 ? '+' : '' }}{{ number_format($lp->total_real_bets - $payout, 1) }}
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Instant Rig / Force Settle Action -->
                        <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-800">
                            <span class="text-xs font-bold text-amber-300"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i> ইনস্ট্যান্ট ফোর্স সেটেল (যেকোনো নম্বরে ক্লিক করলেই সেই নম্বর উইন হয়ে রাউন্ড শেষ হবে):</span>
                            <div class="flex items-center gap-1">
                                @for($num = 0; $num <= 9; $num++)
                                    <form action="{{ route('admin.trxwingo.settle', $lp->id) }}" method="POST" class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে নম্বর {{ $num }} দিয়ে এই রাউন্ড এখনই সেটেল করবেন?');">
                                        @csrf
                                        <input type="hidden" name="force_number" value="{{ $num }}">
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-[#00b977] text-white text-xs font-black transition border border-slate-700 hover:border-[#00b977]">
                                            {{ $num }}
                                        </button>
                                    </form>
                                @endfor
                                <form action="{{ route('admin.trxwingo.settle', $lp->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('হাউজ প্রফিট মোডে এখনই সেটেল করবেন?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-[#00b977] hover:bg-[#009b63] text-white text-xs font-bold rounded-lg transition shadow">
                                        <i class="fa-solid fa-bolt mr-1"></i> Auto Settle
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- TrxWinGo Global Settings & How To Play Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Settings Form (2 Cols) -->
        <div class="lg:col-span-2 panel-card">
            <h2 class="text-lg font-black text-white mb-4 flex items-center gap-2 border-b border-slate-700/60 pb-3">
                <i class="fa-solid fa-sliders text-[#00b977]"></i> TrxWinGo গ্লোবাল সেটিংস ও প্রফিট কন্ট্রোল
            </h2>

            <form action="{{ route('admin.trxwingo.settings') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Control Mode -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">কন্ট্রোল মোড (Control Mode)</label>
                        <select name="control_mode" class="form-select text-xs font-bold">
                            <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>হাউজ প্রফিট ইঞ্জিন (সর্বনিম্ন পেআউট / ১০০% লাভ)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>ফিক্সড উইন পার্সেন্টেজ মোড (Win Chance %)</option>
                            <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>সম্পূর্ণ র‍্যান্ডম ড্র (১০০% ফেয়ার)</option>
                            <option value="manual" {{ $settings->control_mode === 'manual' ? 'selected' : '' }}>ম্যানুয়াল সেটেলমেন্ট মোড</option>
                        </select>
                    </div>

                    <!-- Win Chance Percentage -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">প্লেয়ার জেতার সম্ভাবনা (Win Chance %)</label>
                        <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="100" class="form-input text-xs">
                        <span class="text-[10px] text-slate-400">ফিক্সড পার্সেন্টেজ মোডে কার্যকর (ডিফল্ট ৩০%)</span>
                    </div>

                    <!-- Next Force Winning Number -->
                    <div>
                        <label class="block text-xs font-bold text-amber-300 mb-1.5">পরবর্তী রাউন্ডের জন্য নির্দিষ্ট নম্বর সেট (Next Force Draw)</label>
                        <select name="next_force_number" class="form-select text-xs font-bold text-amber-300">
                            <option value="">-- কোনো নির্দিষ্ট নম্বর নেই (অটোমেটিক) --</option>
                            @for($i = 0; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ (string)$settings->next_force_number === (string)$i ? 'selected' : '' }}>
                                    নম্বর {{ $i }} ({{ in_array($i, [1,3,7,9]) ? 'Green' : (in_array($i, [2,4,6,8]) ? 'Red' : 'Violet') }} / {{ $i >= 5 ? 'Big' : 'Small' }})
                                </option>
                            @endfor
                        </select>
                        <span class="text-[10px] text-amber-400/80">সিলেক্ট করলে পরবর্তী ড্র তে নিশ্চিতভাবে এই নম্বরই উঠবে।</span>
                    </div>

                    <!-- Demo Limit -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">ডেমো বেট লিমিট (Demo Limit)</label>
                        <input type="number" name="demo_limit" value="{{ $settings->demo_limit }}" min="0" class="form-input text-xs">
                        <span class="text-[10px] text-slate-400">কতবার ফ্রি খেলার পর ডিপোজিট বাধ্যতামূলক হবে (ডিফল্ট ৩)</span>
                    </div>

                    <!-- Min Bet -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">মিনিমাম বেট (Min Bet ৳)</label>
                        <input type="number" step="0.1" name="min_bet" value="{{ $settings->min_bet }}" class="form-input text-xs">
                    </div>

                    <!-- Max Bet -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">ম্যাক্সিমাম বেট (Max Bet ৳)</label>
                        <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-input text-xs">
                    </div>

                    <!-- Bot Trigger Count -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">বট বেট সংখ্যা (Bot Bets per Round)</label>
                        <input type="number" name="bot_trigger_count" value="{{ $settings->bot_trigger_count }}" min="1" max="20" class="form-input text-xs">
                    </div>

                    <!-- Bot Status Checkbox -->
                    <div class="flex items-center gap-3 pt-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="bot_status" value="1" {{ $settings->bot_status ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00b977]"></div>
                            <span class="ml-3 text-xs font-bold text-slate-300">অটোমেটিক ফেক/বট বেটিং অন রাখুন</span>
                        </label>
                    </div>
                </div>

                <!-- How To Play Editor -->
                <div class="pt-3 border-t border-slate-700/60">
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">
                        <i class="fa-solid fa-book-open text-cyan-400 mr-1"></i> "How to Play" নিয়মাবলী ও নির্দেশিকা (প্লেয়ার মডালে দৃশ্যমান)
                    </label>
                    <textarea name="how_to_play_rules" rows="4" class="form-textarea text-xs font-sans" placeholder="খেলার নিয়মাবলী বাংলায় বা ইংরেজিতে লিখুন...">{{ $settings->how_to_play_rules }}</textarea>
                    <span class="text-[10px] text-slate-400">এই লেখাটি কাস্টমার গেম স্ক্রিনের "How to play" বাটনে ক্লিক করলে পপ-আপে প্রদর্শিত হবে।</span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-[#00b977] hover:bg-[#009b63] text-white rounded-xl text-xs font-black transition flex items-center gap-2 shadow-lg">
                        <i class="fa-solid fa-floppy-disk"></i> Save TrxWinGo Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Information / Guide Card (1 Col) -->
        <div class="panel-card flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black text-white mb-3 flex items-center gap-2 text-cyan-400">
                    <i class="fa-solid fa-circle-info"></i> TrxWinGo প্রভ্যাব্লি ফেয়ার মেকানিজম
                </h3>
                <div class="text-xs text-slate-300 space-y-3 leading-relaxed">
                    <p>
                        <strong class="text-white">১. ব্লকচেইন ট্র্যাকিং:</strong> প্রতিটি রাউন্ডের সাথে ট্রন পাবলিক চেইনের <code>Block Height</code> এবং <code>Block Time</code> অ্যাসাইন হয়।
                    </p>
                    <p>
                        <strong class="text-white">২. হ্যাশ ভ্যালু ও ৫ বল:</strong> ব্লকের হ্যাশের শেষ ৫টি ডিজিট (যেমন: <span class="text-amber-400 font-mono">3, 0, 6, C, B</span>) স্ক্রিনের ওপরের ৫টি বোতামে দেখানো হয়।
                    </p>
                    <p>
                        <strong class="text-white">৩. উইনিং ফলাফল:</strong> হ্যাশের শেষ ক্যারেক্টারটিই নির্ধারিত হয় উইনিং নম্বর হিসেবে।
                    </p>
                    <p>
                        <strong class="text-white">৪. হাউজ প্রফিট অ্যালগরিদম:</strong> বেটিং বন্ধ হওয়ার পর হাউজ প্রফিট ইঞ্জিন ০-৯ পর্যন্ত সবগুলো নম্বরের সম্ভাব্য পেআউট হিসাব করে এবং যে নম্বরে এডমিনের সবচেয়ে বেশি প্রফিট থাকে সেই নম্বর সম্বলিত ব্লক হ্যাশ জেনারেট করে।
                    </p>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-xl bg-slate-900 border border-slate-700 text-[11px] text-slate-400">
                <div class="font-bold text-white mb-1"><i class="fa-solid fa-lock text-emerald-400 mr-1"></i> ৫ সেকেন্ড লক সিস্টেম:</div>
                কাউন্টডাউনের শেষ ৫ সেকেন্ডে স্ক্রিনের ঠিক মাঝখানে ফুল-স্ক্রিন কার্ড ওভারলে চলে আসে যেন কোনো ইউজার আর বাজি ধরতে না পারে।
            </div>
        </div>

    </div>

    <!-- Recent Completed Rounds Table -->
    <div class="panel-card">
        <div class="flex items-center justify-between mb-4 border-b border-slate-700/60 pb-3">
            <h2 class="text-lg font-black text-white flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-purple-400"></i> Recent Completed Rounds & Blockchain Ledger
            </h2>
            <span class="text-xs text-slate-400">বিগত রাউন্ডগুলোর ফলাফল ও প্রফিট রিপোর্ট</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-300">
                <thead>
                    <tr class="bg-[#081222] text-slate-400 border-b border-slate-700">
                        <th class="p-3">Period</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Block Height</th>
                        <th class="p-3">Block Time</th>
                        <th class="p-3">Hash Tail (5 Balls)</th>
                        <th class="p-3 text-center">Winning Num</th>
                        <th class="p-3">Color / Size</th>
                        <th class="p-3 text-right">Real Bets</th>
                        <th class="p-3 text-right">Total Payout</th>
                        <th class="p-3 text-right">Admin Profit</th>
                        <th class="p-3 text-center">Settled At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($recentRounds as $r)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-3 font-mono font-bold text-white">{{ $r->period_number }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded bg-slate-800 text-cyan-300 font-bold text-[10px]">{{ $r->time_type }}</span>
                            </td>
                            <td class="p-3 font-mono text-slate-400">{{ $r->block_height }}</td>
                            <td class="p-3 text-slate-400">{{ $r->block_time }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-1">
                                    @if(is_array($r->hash_tail_chars))
                                        @foreach($r->hash_tail_chars as $char)
                                            <span class="w-5 h-5 rounded-full bg-gradient-to-br from-[#ff6b6b] to-[#ee5253] text-white text-[10px] font-black inline-flex items-center justify-center shadow">
                                                {{ $char }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="font-mono text-slate-500">**{{ substr($r->hash_value, -4) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                @php
                                    $nColor = in_array($r->winning_number, [1,3,7,9]) ? 'bg-emerald-500' : (in_array($r->winning_number, [2,4,6,8]) ? 'bg-red-500' : 'bg-purple-500');
                                @endphp
                                <span class="num-pill {{ $nColor }} shadow">{{ $r->winning_number }}</span>
                            </td>
                            <td class="p-3 font-bold capitalize">
                                <span class="{{ $r->winning_color === 'green' ? 'text-emerald-400' : ($r->winning_color === 'red' ? 'text-red-400' : 'text-purple-400') }}">
                                    {{ $r->winning_color }}
                                </span> / 
                                <span class="{{ $r->winning_size === 'big' ? 'text-amber-400' : 'text-blue-400' }}">
                                    {{ ucfirst($r->winning_size) }}
                                </span>
                            </td>
                            <td class="p-3 text-right font-mono font-bold text-purple-300">৳ {{ number_format($r->total_real_bets, 2) }}</td>
                            <td class="p-3 text-right font-mono font-bold text-amber-300">৳ {{ number_format($r->total_payout, 2) }}</td>
                            <td class="p-3 text-right font-mono font-bold {{ $r->admin_profit >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $r->admin_profit >= 0 ? '+' : '' }}৳ {{ number_format($r->admin_profit, 2) }}
                            </td>
                            <td class="p-3 text-center text-slate-400 font-mono text-[11px]">{{ $r->updated_at->format('H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="p-6 text-center text-slate-500">এখনো কোনো রাউন্ড সম্পন্ন হয়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $recentRounds->links() }}
        </div>
    </div>

</div>

</body>
</html>
