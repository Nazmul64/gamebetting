<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easter Slots™ Management — Admin Control Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #061006; color: #f8fafc; }
        .card { background: #0c200c; border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 16px; }
        .input-dark { background: #040c04; border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; padding: 8px 12px; color: #fff; width: 100%; outline: none; }
        .input-dark:focus { border-color: #22c55e; }
    </style>
</head>
<body class="p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="p-2 bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-800 rounded-lg text-emerald-400">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-emerald-400 flex items-center gap-2">
                        <i class="fas fa-egg"></i> Easter Slots™ Engine Control
                    </h1>
                    <p class="text-sm text-emerald-300/70">5x3 Reels, 20 Fixed Paylines, Easter Bunny Wilds & Scatters</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('easter-slot') }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 rounded-lg font-bold text-sm">
                    <i class="fas fa-play mr-1"></i> Launch Game
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-900/60 border border-emerald-500 rounded-xl text-emerald-300 font-semibold">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="card p-5">
                <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Total Spins</div>
                <div class="text-2xl font-black mt-1">{{ number_format($totalSpins) }}</div>
            </div>
            <div class="card p-5">
                <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Total Wagered</div>
                <div class="text-2xl font-black mt-1 text-emerald-300">৳{{ number_format($totalWagered, 2) }}</div>
            </div>
            <div class="card p-5">
                <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Total Paid Out</div>
                <div class="text-2xl font-black mt-1 text-yellow-400">৳{{ number_format($totalWon, 2) }}</div>
            </div>
            <div class="card p-5">
                <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider">House Profit (Net)</div>
                <div class="text-2xl font-black mt-1 {{ $houseProfit >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                    ৳{{ number_format($houseProfit, 2) }}
                </div>
            </div>
        </div>

        <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
        <div class="card p-6 border-emerald-500/40 bg-gradient-to-r from-[#061a06] via-[#041204] to-[#061a06]">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-emerald-500/20">
                <h2 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fas fa-book-open text-emerald-400"></i> Easter Slots™ — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
                </h2>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-semibold border border-emerald-500/30">১০০% সার্ভার কন্ট্রোলড</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-slate-300 leading-relaxed">
                <div class="p-3.5 rounded-xl bg-[#040c04] border border-emerald-500/20">
                    <div class="font-bold text-emerald-400 text-sm mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-egg"></i> ১. গেম মেকানিক্স
                    </div>
                    <p>
                        ৫x৩ রিলের ২০টি ফিক্সড পে-লাইনের স্লট গেম। রঙিন ইস্টার এগ ও সিম্বল মিললে পেআউট হয়। বানি ওয়াইল্ড যেকোনো সিম্বলের বিকল্প হিসেবে কাজ করে এবং বাস্কেট স্ক্যাটার সরাসরি ফ্রি স্পিন দেয়।
                    </p>
                </div>
                <div class="p-3.5 rounded-xl bg-[#040c04] border border-emerald-500/20">
                    <div class="font-bold text-emerald-300 text-sm mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল
                    </div>
                    <p>
                        <strong>House Profit Target (%):</strong> ডিফল্ট ৭০% এডমিন প্রফিট সেট করা। এডমিন চাইলে উইন চান্স ৩০% এ রেখে ক্যাসিনোর ফান্ড সবসময় সুরক্ষিত ও লাভজনক রাখতে পারেন।
                    </p>
                </div>
                <div class="p-3.5 rounded-xl bg-[#040c04] border border-emerald-500/20">
                    <div class="font-bold text-yellow-400 text-sm mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজার প্রফিট ও পেআউট
                    </div>
                    <p>
                        ২০টি পে-লাইনের যেকোনোটিতে সিম্বল মিললে পে-টেবিল মাল্টিপ্লায়ার অনুযায়ী তাৎক্ষণিক পেআউট প্লেয়ারের ওয়ালেটে ক্রেডিট হয়ে যায়।
                    </p>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="card p-6">
            <h2 class="text-lg font-bold text-emerald-400 mb-4 flex items-center gap-2">
                <i class="fas fa-sliders-h"></i> House Profit & RTP Settings
            </h2>
            <form action="{{ route('admin.easterslots.settings') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">Control Mode</label>
                    <select name="control_mode" class="input-dark">
                        <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>House Profit Target (Auto Balance)</option>
                        <option value="manual" {{ $settings->control_mode === 'manual' ? 'selected' : '' }}>Strict Win Chance %</option>
                        <option value="rtp" {{ $settings->control_mode === 'rtp' ? 'selected' : '' }}>Standard RTP %</option>
                        <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>Pure Random RNG</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">House Profit Target (%)</label>
                    <input type="number" step="0.01" name="house_profit_percentage" value="{{ $settings->house_profit_percentage }}" class="input-dark">
                    <p class="text-[11px] text-emerald-400/60 mt-1">Default: 70% House Retained</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">User Win Chance (%)</label>
                    <input type="number" step="0.01" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" class="input-dark">
                    <p class="text-[11px] text-emerald-400/60 mt-1">Default: 30% User Win Rate</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">Min Bet Amount (৳)</label>
                    <input type="number" step="0.01" name="min_bet" value="{{ $settings->min_bet }}" class="input-dark">
                </div>

                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">Max Bet Amount (৳)</label>
                    <input type="number" step="0.01" name="max_bet" value="{{ $settings->max_bet }}" class="input-dark">
                </div>

                <div>
                    <label class="block text-xs font-bold text-emerald-300/80 mb-2">Max Payout Per Spin (৳)</label>
                    <input type="number" step="0.01" name="max_payout_per_spin" value="{{ $settings->max_payout_per_spin }}" class="input-dark">
                </div>

                <div class="md:col-span-3 flex items-center justify-between pt-4 border-t border-emerald-950">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $settings->is_active ? 'checked' : '' }} class="w-5 h-5 accent-emerald-500 rounded">
                        <span class="text-sm font-bold">Enable Easter Slots for Players</span>
                    </label>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-lg shadow-lg">
                        Save Configurations
                    </button>
                </div>
            </form>
        </div>

        <!-- Recent Spins History -->
        <div class="card p-6">
            <h2 class="text-lg font-bold text-emerald-400 mb-4 flex items-center gap-2">
                <i class="fas fa-history"></i> Recent Game Spins
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-emerald-900/50 text-xs text-emerald-400/80">
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">User</th>
                            <th class="py-3 px-4">Bet</th>
                            <th class="py-3 px-4">Multiplier</th>
                            <th class="py-3 px-4">Win Amount</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-950">
                        @forelse($recentSpins as $spin)
                            <tr class="hover:bg-emerald-950/30">
                                <td class="py-3 px-4 font-mono text-xs">#{{ $spin->id }}</td>
                                <td class="py-3 px-4 font-bold">{{ $spin->user ? $spin->user->name : 'Demo Player' }}</td>
                                <td class="py-3 px-4 font-mono">৳{{ number_format($spin->bet_amount, 2) }}</td>
                                <td class="py-3 px-4 font-bold {{ $spin->multiplier > 0 ? 'text-yellow-400' : 'text-slate-500' }}">
                                    {{ $spin->multiplier }}x
                                </td>
                                <td class="py-3 px-4 font-mono font-bold {{ $spin->win_amount > 0 ? 'text-emerald-400' : 'text-slate-500' }}">
                                    ৳{{ number_format($spin->win_amount, 2) }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-bold {{ $spin->is_demo ? 'bg-slate-800 text-slate-400' : 'bg-emerald-950 text-emerald-400 border border-emerald-800' }}">
                                        {{ $spin->is_demo ? 'DEMO' : 'REAL' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-xs text-slate-400">{{ $spin->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-slate-500">No spins recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
