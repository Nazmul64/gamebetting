<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WinGo Lottery — Admin House Profit Control Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --bg-dark: #091712;
            --panel-bg: #0f2920;
            --panel-border: rgba(16, 185, 129, 0.25);
            --emerald: #10b981;
            --emerald-bright: #34d399;
            --gold: #f59e0b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --success: #10b981;
            --danger: #ef4444;
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
            max-width: 1320px;
            margin: 0 auto;
        }

        .panel-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }

        .form-input, .form-select {
            background: #061510;
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #f8fafc;
            padding: 10px 14px;
            border-radius: 10px;
            outline: none;
            width: 100%;
            transition: border-color 0.2s;
        }
        .form-input:focus, .form-select:focus {
            border-color: #34d399;
            box-shadow: 0 0 0 2px rgba(52, 211, 153, 0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="flex items-center justify-between pb-6 mb-8 border-b border-emerald-500/20">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#10b981] to-[#047857] flex items-center justify-center text-white text-2xl shadow-lg border border-emerald-400/40">
                <i class="fa-solid fa-dice"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white flex items-center gap-2">
                    WinGo Lottery <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">House Profit Engine</span>
                </h1>
                <p class="text-xs text-slate-400 mt-1">Amar Club / Tiranga Style 30s, 1m, 3m, 5m Color & Number Prediction</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('wingo.index') }}" target="_blank" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow">
                <i class="fa-solid fa-play"></i> Launch WinGo
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
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

    <!-- বাংলায় WinGo হাউজ প্রফিট ইঞ্জিন ও পরিচালনানীতির পূর্ণাঙ্গ গাইড -->
    <div class="panel-card mb-8 border-emerald-500/40 bg-gradient-to-r from-[#0d281e] via-[#091f17] to-[#0d281e]">
        <div class="flex items-center justify-between mb-3 pb-3 border-b border-emerald-500/20">
            <h2 class="text-base font-bold text-white flex items-center gap-2.5">
                <i class="fa-solid fa-book-bookmark text-emerald-400"></i> WinGo লটারি পরিচালনানীতি ও হাউজ প্রফিট ইঞ্জিন নির্দেশিকা (Admin Guide)
            </h2>
            <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-semibold border border-emerald-500/30">100% Automated</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-slate-300 leading-relaxed">
            <div class="p-3 rounded-xl bg-[#061510] border border-emerald-500/20">
                <div class="font-bold text-emerald-400 text-sm mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> ১. হাউজ প্রফিট অ্যালগরিদম
                </div>
                <p>
                    <strong>House Profit Mode</strong> সিলেক্ট করা থাকলে প্রতিটি লাইভ রাউন্ডের শেষ ৫ সেকেন্ডে সার্ভার প্লেয়ারদের করা সমস্ত রিয়েল বেট ক্যালকুলেট করে। ০ থেকে ৯ এর মধ্যে যে নম্বরে পে-আউট দিলে প্ল্যাটফর্মের <strong>সর্বনিম্ন খরচ এবং সর্বোচ্চ লাভ</strong> নিশ্চিত হবে, সিস্টেম স্বয়ংক্রিয়ভাবে সেই নম্বর বিজয়ী করে।
                </p>
            </div>
            <div class="p-3 rounded-xl bg-[#061510] border border-emerald-500/20">
                <div class="font-bold text-amber-400 text-sm mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-scale-balanced"></i> ২. পে-আউট ও উইনিং রুলস
                </div>
                <p>
                    • <strong>সরাসরি নম্বর (০-৯):</strong> ৯ গুণ (9.0×) পে-আউট<br>
                    • <strong>ভায়োলেট কালার (০ বা ৫):</strong> ৪.৫ গুণ (4.5×) পে-আউট<br>
                    • <strong>গ্রিন বা রেড:</strong> ২ গুণ (2.0×) (০ বা ৫ হলে ১.৫ গুণ)<br>
                    • <strong>বিগ (৫-৯) বা স্মল (০-৪):</strong> ২ গুণ (2.0×) পে-আউট
                </p>
            </div>
            <div class="p-3 rounded-xl bg-[#061510] border border-emerald-500/20">
                <div class="font-bold text-purple-400 text-sm mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-robot"></i> ৩. বট সিমুলেশন ও ফোর্স ড্র
                </div>
                <p>
                    • <strong>স্মার্ট বট:</strong> চার্ট ও হিস্ট্রি সবসময় সক্রিয় রাখতে স্বয়ংক্রিয় বট বেট যুক্ত হয়।<br>
                    • <strong>ডেমো লিমিট:</strong> ফ্রি প্লেয়ার ৫টি বেট খেললে স্বয়ংক্রিয় ডিপোজিট পপ-আপ আসে।<br>
                    • <strong>Force Settle:</strong> এডমিন যেকোনো লাইভ রাউন্ড ইচ্ছামতো সাথে সাথে ড্র করতে পারবেন।
                </p>
            </div>
        </div>
    </div>

    <!-- Main Grid: Settings & Live Rounds -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- House Profit Control Settings Form -->
        <div class="panel-card lg:col-span-1">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-sliders text-emerald-400"></i> House Profit Configuration
            </h2>
            <form action="{{ route('admin.wingo.settings') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">Game Settlement Algorithm (Control Mode)</label>
                    <select name="control_mode" class="form-select text-xs font-semibold">
                        <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>
                            🛡️ House Profit Mode (Lowest Payout / Guaranteed Max Profit)
                        </option>
                        <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>
                            📊 Fixed Percentage Chance
                        </option>
                        <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>
                            🎲 Pure Random Outcome
                        </option>
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">
                        In House Profit mode, the server evaluates all numbers 0-9 in the final 5s and selects the number causing the lowest payout to maximize platform net revenue.
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">Player Win Chance (%) (For Fixed Mode)</label>
                    <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="100" class="form-input text-xs font-semibold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">Min Bet (৳)</label>
                        <input type="number" step="0.5" name="min_bet" value="{{ $settings->min_bet }}" class="form-input text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">Max Bet (৳)</label>
                        <input type="number" step="10" name="max_bet" value="{{ $settings->max_bet }}" class="form-input text-xs font-semibold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">Demo Bets Limit</label>
                    <input type="number" name="demo_limit" value="{{ $settings->demo_limit }}" class="form-input text-xs font-semibold">
                    <p class="text-[11px] text-slate-400 mt-1">After exceeding this limit, users are prompted with the Deposit popup.</p>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="bot_status" value="1" {{ $settings->bot_status ? 'checked' : '' }} class="w-4 h-4 accent-emerald-500 rounded">
                        <span class="text-xs font-bold text-slate-200">Enable Smart Bot Simulation Bets</span>
                    </label>
                    <p class="text-[11px] text-slate-400 ml-6 mt-0.5">Injects active player bets to keep the live lottery charts bustling.</p>
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs uppercase tracking-wider rounded-xl transition shadow-lg mt-4">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Save WinGo Settings
                </button>
            </form>
        </div>

        <!-- Live Active Periods (30s, 1m, 3m, 5m) -->
        <div class="panel-card lg:col-span-2">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-tower-broadcast text-emerald-400"></i> Active Live Timeframe Rounds
                </span>
                <span class="text-xs text-slate-400">Auto-created by game loops</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($livePeriods as $lp)
                    <div class="bg-[#061510] border border-emerald-500/20 rounded-xl p-4 flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    WinGo {{ $lp->time_type }}
                                </span>
                                <div class="text-sm font-mono font-bold text-white mt-1">{{ $lp->period_number }}</div>
                            </div>
                            <span class="text-xs font-mono font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20">
                                {{ $lp->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-300 my-2 pt-2 border-t border-emerald-500/10">
                            <div>Total Real Bets: <strong class="text-emerald-400">৳ {{ number_format($lp->total_real_bets, 2) }}</strong></div>
                            <div>Active Bets: <strong class="text-white">{{ $lp->bets_count }}</strong></div>
                        </div>

                        <div class="flex justify-between items-center pt-2 mt-2 border-t border-emerald-500/10">
                            <span class="text-[11px] text-slate-400 font-mono">Ends: {{ $lp->ends_at ? $lp->ends_at->format('H:i:s') : '--' }}</span>
                            <form action="{{ route('admin.wingo.settle', $lp->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Force settle this round now?')" class="px-2.5 py-1 bg-amber-500/20 hover:bg-amber-500/40 text-amber-300 border border-amber-500/40 rounded-lg text-[11px] font-bold transition">
                                    <i class="fa-solid fa-gavel"></i> Force Settle
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-8 text-center text-slate-400 text-xs">
                        No active rounds at the moment. Active rounds are created automatically when players connect.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Completed Rounds History -->
    <div class="panel-card">
        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i> Recent Completed Rounds & Profit Audit
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-300">
                <thead>
                    <tr class="bg-[#061510] text-slate-400 uppercase text-[10px] tracking-wider border-b border-emerald-500/20 font-bold">
                        <th class="py-3 px-4">Period Number</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Result</th>
                        <th class="py-3 px-4">Color</th>
                        <th class="py-3 px-4">Size</th>
                        <th class="py-3 px-4">Total Bets</th>
                        <th class="py-3 px-4">Total Payout</th>
                        <th class="py-3 px-4">House Profit</th>
                        <th class="py-3 px-4">Settled At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-500/10">
                    @forelse($recentRounds as $r)
                        <tr class="hover:bg-emerald-500/5 transition font-medium">
                            <td class="py-3 px-4 font-mono font-bold text-white">{{ $r->period_number }}</td>
                            <td class="py-3 px-4 font-bold text-emerald-400">{{ $r->time_type }}</td>
                            <td class="py-3 px-4 font-black text-sm {{ $r->winning_number % 2 === 0 ? 'text-red-400' : 'text-emerald-400' }}">
                                {{ $r->winning_number }}
                            </td>
                            <td class="py-3 px-4 uppercase text-[11px] font-bold">{{ $r->winning_color }}</td>
                            <td class="py-3 px-4 uppercase text-[11px] font-bold">{{ $r->winning_size }}</td>
                            <td class="py-3 px-4 text-slate-200">৳ {{ number_format($r->total_real_bets, 2) }}</td>
                            <td class="py-3 px-4 text-amber-400">৳ {{ number_format($r->total_payout, 2) }}</td>
                            <td class="py-3 px-4 font-bold {{ $r->admin_profit >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                ৳ {{ number_format($r->admin_profit, 2) }}
                            </td>
                            <td class="py-3 px-4 text-slate-400 font-mono">{{ $r->updated_at->format('M d, H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">কোনো সমাপ্ত রাউন্ড হিস্ট্রি পাওয়া যায়নি।</td>
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
