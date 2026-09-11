@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-coins" style="color:#f59e0b; margin-right:8px;"></i>
                Heads or Tails (Mermaid & Octopus Gold Coin) — Control Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                1xBet অফিশিয়াল মেথডোলজি: House Profit Pool Balancing, Progressive Doubling Multiplier, Smart Bot Injection & Live History Sync.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('heads-or-tails') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#f59e0b,#d97706); border:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    <!-- গেম অপারেশন ও হাউস প্রফিট গাইডলাইন (বাংলা নির্দেশিকা) -->
    <div class="panel mb-4" style="border-left: 4px solid #f59e0b; background: rgba(245, 158, 11, 0.05);">
        <div class="panel-header" style="background: rgba(245, 158, 11, 0.1);">
            <div class="panel-title" style="color: #fbbf24; font-size: 14px; font-weight:700;">
                <i class="fas fa-shield-halved"></i> গেম পরিচালনা ও হাউস প্রফিট গাইডলাইন (1xBet Methodology - এডমিন প্রফিট গ্যারান্টি)
            </div>
        </div>
        <div class="panel-body" style="font-size: 13.5px; color: #cbd5e1; line-height: 1.7;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                <div>
                    <h5 style="color:#fcd34d; font-size:14px; margin-bottom:6px;"><i class="fas fa-scale-balanced"></i> ১. হাউজ প্রফিট ইঞ্জিন (কম টাকার সাইড জেতা):</h5>
                    <p style="margin:0; font-size:13px;">
                        প্লেয়াররা যখন একসাথে বেট ধরে (যেমন: ১০ জন ধরল <strong>Heads</strong>-এ মোট ৫০,০০০ টাকা এবং ৪০ জন ধরল <strong>Tails</strong>-এ মোট ২০,০০০ টাকা), তখন ব্যাকএন্ডের অ্যালগরিদম স্বয়ংক্রিয়ভাবে কম টাকার সাইডকে (Tails) বিজয়ী ঘোষণা করে। এতে মোট ৫০,০০০ টাকার বড় অংশ এডমিনের ১০০% নিট লাভ হিসেবে সুরক্ষিত থাকে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fcd34d; font-size:14px; margin-bottom:6px;"><i class="fas fa-chart-line"></i> ২. প্রোগ্রেসিভ ও সিঙ্গেল মোড (Progressive Multiplier):</h5>
                    <p style="margin:0; font-size:13px;">
                        প্লেয়ার একবার জিতলে <strong>1.96×</strong> পেআউট ক্যাশ আউট (Cash Out) করে নিতে পারে, অথবা সে পরবর্তী রাউন্ডে গিয়ে <strong>3.84×</strong>, <strong>7.50×</strong> গুণ প্রোগ্রেসিভ মোডে আরও বড় লাভের জন্য কন্টিনিউ করতে পারে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fcd34d; font-size:14px; margin-bottom:6px;"><i class="fas fa-robot"></i> ৩. স্মার্ট বট সিস্টেম (Pool Automation):</h5>
                    <p style="margin:0; font-size:13px;">
                        একা রিয়েল প্লেয়ার খেললে ব্যাকএন্ড থেকে ভার্চুয়াল বট এন্ট্রি করানো হয় (যেমন: <em>AquaKing, Kraken_99, SeaWolf</em>), যাতে কয়েন টসের পুল সবসময় জীবন্ত ও লাখপতি প্লেয়ারে ভরা দেখায়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fcd34d; font-size:14px; margin-bottom:6px;"><i class="fas fa-wallet"></i> ৪. বাই-ডিফল্ট রিয়েল মোড ও ডেমো লিমিট:</h5>
                    <p style="margin:0; font-size:13px;">
                        গেম চালু হলে বাই-ডিফল্ট আসল ব্যালেন্স শো করবে। ইউজার নিজে ডেমো বাটনে ক্লিক না করা পর্যন্ত ডেমো চালু হবে না। ডেমো ৩ বার টস করার পর গেম ফ্রিজ হয়ে ডিপোজিট পপ-আপ দেবে যাতে ইউজার ডিপোজিট করতে বাধ্য হয়।
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ফাইন্যান্সিয়াল অ্যানালিটিক্স -->
    <div class="stats-grid mb-4">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                <span class="stat-card-change change-up">Real Bets</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalCollected, 2) }}</div>
            <div class="stat-card-label">মোট আসল বেট সংগ্রহ</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-trophy"></i></div>
                <span class="stat-card-change" style="background:rgba(139,92,246,0.15); color:#c084fc; border:1px solid rgba(139,92,246,0.3);">Payouts</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalPaidOut, 2) }}</div>
            <div class="stat-card-label">মোট পেআউট প্রদান</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-sack-dollar"></i></div>
                <span class="stat-card-change change-up">Net Profit</span>
            </div>
            <div class="stat-card-val" style="color:{{ $adminProfit >= 0 ? '#34d399' : '#f87171' }};">৳ {{ number_format($adminProfit, 2) }}</div>
            <div class="stat-card-label">এডমিনের নিট প্রফিট</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-rotate"></i></div>
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">{{ $settings->base_multiplier }}x Base</span>
            </div>
            <div class="stat-card-val">{{ strtoupper(str_replace('_', ' ', $settings->control_mode)) }}</div>
            <div class="stat-card-label">অ্যালগরিদম মোড ({{ $totalRounds }} রাউন্ড)</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:20px; margin-bottom:24px;">
        <!-- কন্ট্রোল সেটিংস ফরম -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> গেম অ্যালগরিদম ও কন্ট্রোল কনফিগারেশন</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.headstails.settings') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">গেম ডিসপ্লে নাম:</label>
                        <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-input" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">অ্যালগরিদম মোড:</label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (কম টাকার দিক জিতবে - ১০০% এডমিন সেফ)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (উইন রেট % অনুযায়ী)</option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (ন্যাচারাল আরটিপি)</option>
                        </select>
                        <small style="color:var(--text-muted); font-size:11px; margin-top:3px; display:block;">হাউজ প্রফিট মোড চালু থাকলে এডমিনের ক্ষতি হওয়ার সুযোগ থাকে না।</small>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">ইউজার উইন চান্স (%):</label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" class="form-input" min="1" max="100" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">বেস পেআউট মাল্টিপ্লায়ার:</label>
                            <input type="number" step="0.01" name="base_multiplier" value="{{ $settings->base_multiplier }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">স্মার্ট বট সক্রিয় থাকবে:</label>
                            <select name="bot_status" class="form-input">
                                <option value="1" {{ $settings->bot_status ? 'selected' : '' }}>হ্যাঁ (Active)</option>
                                <option value="0" {{ !$settings->bot_status ? 'selected' : '' }}>না (Disabled)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">বট ট্রিগার প্লেয়ার সংখ্যা:</label>
                            <input type="number" name="bot_trigger_count" value="{{ $settings->bot_trigger_count }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">বট মিনিমাম বেট (৳):</label>
                            <input type="number" step="1" name="bot_min_bet" value="{{ $settings->bot_min_bet }}" class="form-input" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">বট ম্যাক্সিমাম বেট (৳):</label>
                            <input type="number" step="1" name="bot_max_bet" value="{{ $settings->bot_max_bet }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">মিনিমাম বেট লিমিট (৳):</label>
                            <input type="number" step="0.5" name="min_bet" value="{{ $settings->min_bet }}" class="form-input" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">ম্যাক্সিমাম বেট লিমিট (৳):</label>
                            <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">ডেমো টস লিমিট (বার):</label>
                            <input type="number" name="demo_toss_limit" value="{{ $settings->demo_toss_limit }}" class="form-input" required>
                            <small style="color:var(--text-muted); font-size:11px;">৩ বার টস করার পর ডিপোজিট করতে বলবে।</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">রাউন্ড সময় (সেকেন্ড):</label>
                            <input type="number" name="round_duration_seconds" value="{{ $settings->round_duration_seconds }}" class="form-input" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; margin-top:10px; background:linear-gradient(135deg,#f59e0b,#d97706); border:none;">
                        <i class="fas fa-save"></i> সেটিংস সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- সাউন্ড ও অডিও কাস্টমাইজেশন -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-volume-high" style="color:var(--accent-cyan);"></i> গেম সাউন্ড ও ব্যাকগ্রাউন্ড ওশান অ্যাম্বিয়েন্স</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_sea_music' => ['title' => 'ওশান অ্যাম্বিয়েন্স / ব্যাকগ্রাউন্ড মিউজিক', 'icon' => 'fa-water'],
                        'coin_flip_sound' => ['title' => 'কয়েন ৩ডি স্পিন / টসিং সাউন্ড', 'icon' => 'fa-coins'],
                        'win_sound' => ['title' => 'মারমেইড চিয়ার / বিগ উইন সাউন্ড', 'icon' => 'fa-champagne-glasses'],
                        'loss_sound' => ['title' => 'ওয়াটার স্প্ল্যাশ / পরাজয়ের সাউন্ড', 'icon' => 'fa-droplet']
                    ];
                @endphp

                @foreach($audios as $key => $info)
                    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:12px; margin-bottom:12px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:13px; font-weight:600; color:var(--text-primary); display:flex; align-items:center; gap:6px;">
                                <i class="fas {{ $info['icon'] }}" style="color:var(--accent-gold);"></i> {{ $info['title'] }}
                            </span>
                            @if($settings->$key)
                                <span style="font-size:11px; background:rgba(16,185,129,0.2); color:#10b981; padding:2px 8px; border-radius:4px; font-weight:700;">
                                    <i class="fas fa-check"></i> লোডেড
                                </span>
                            @else
                                <span style="font-size:11px; background:rgba(239,68,68,0.2); color:#ef4444; padding:2px 8px; border-radius:4px;">
                                    ডিফল্ট
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('admin.headstails.audio') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:8px;">
                            @csrf
                            <input type="hidden" name="audio_type" value="{{ $key }}">
                            <input type="file" name="audio_file" accept="audio/mp3,audio/wav" class="form-input" style="padding:6px; font-size:12px;" required>
                            <button type="submit" class="btn-secondary" style="padding:6px 14px; font-size:12px; white-space:nowrap; background:#2563eb; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                <i class="fas fa-cloud-arrow-up"></i> আপলোড
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- সাম্প্রতিক রাউন্ড ও বেটের রেকর্ড -->
    <div class="panel">
        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title"><i class="fas fa-list-check" style="color:var(--accent-gold);"></i> সাম্প্রতিক রাউন্ড ও বেট হিস্ট্রি (Live House Ledger)</div>
            <span style="font-size:12px; color:var(--text-muted);">সর্বশেষ ১৫টি রাউন্ডের বিবরণ</span>
        </div>
        <div class="panel-body" style="padding:0; overflow-x:auto;">
            <table class="data-table" style="width:100%; border-collapse:collapse; font-size:12.5px;">
                <thead>
                    <tr style="background:rgba(255,255,255,0.04); text-align:left; border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="padding:12px 14px;">Round ID</th>
                        <th style="padding:12px 14px;">Winner Side</th>
                        <th style="padding:12px 14px;">Real Bets (Heads / Tails)</th>
                        <th style="padding:12px 14px;">Bot Pool</th>
                        <th style="padding:12px 14px;">Total Payout</th>
                        <th style="padding:12px 14px;">House Profit</th>
                        <th style="padding:12px 14px;">Status</th>
                        <th style="padding:12px 14px;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRounds as $round)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px 14px; font-family:var(--font-mono); font-weight:700; color:var(--text-primary);">
                                {{ $round->round_id }}
                            </td>
                            <td style="padding:12px 14px;">
                                @if($round->winning_side === 'heads')
                                    <span style="background:rgba(245,158,11,0.2); color:#f59e0b; padding:3px 10px; border-radius:6px; font-weight:800; border:1px solid rgba(245,158,11,0.4); display:inline-flex; align-items:center; gap:4px;">
                                        🪙 HEADS (মারমেইড)
                                    </span>
                                @elseif($round->winning_side === 'tails')
                                    <span style="background:rgba(59,130,246,0.2); color:#60a5fa; padding:3px 10px; border-radius:6px; font-weight:800; border:1px solid rgba(59,130,246,0.4); display:inline-flex; align-items:center; gap:4px;">
                                        🐙 TAILS (অক্টোপাস)
                                    </span>
                                @else
                                    <span style="color:var(--text-muted);">Tossing...</span>
                                @endif
                            </td>
                            <td style="padding:12px 14px;">
                                <span style="color:#f59e0b; font-weight:700;">H: ৳{{ number_format($round->real_bets_heads, 2) }}</span> / 
                                <span style="color:#60a5fa; font-weight:700;">T: ৳{{ number_format($round->real_bets_tails, 2) }}</span>
                            </td>
                            <td style="padding:12px 14px; color:var(--text-muted);">
                                ৳{{ number_format($round->bot_bets_heads + $round->bot_bets_tails, 2) }}
                            </td>
                            <td style="padding:12px 14px; color:#f87171; font-weight:700;">
                                ৳{{ number_format($round->total_payout, 2) }}
                            </td>
                            <td style="padding:12px 14px; font-weight:800; color:{{ $round->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                                ৳{{ number_format($round->admin_profit, 2) }}
                            </td>
                            <td style="padding:12px 14px;">
                                @if($round->status === 'completed')
                                    <span style="background:rgba(16,185,129,0.15); color:#34d399; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">COMPLETED</span>
                                @elseif($round->status === 'betting')
                                    <span style="background:rgba(245,158,11,0.15); color:#fbbf24; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">BETTING</span>
                                @else
                                    <span style="background:rgba(59,130,246,0.15); color:#60a5fa; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">FLIPPING</span>
                                @endif
                            </td>
                            <td style="padding:12px 14px; color:var(--text-muted); font-size:11px;">
                                {{ $round->created_at ? $round->created_at->diffForHumans() : 'Just now' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">
                                এখনও পর্যন্ত কোন Heads or Tails টস রাউন্ড রেকর্ড হয়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
