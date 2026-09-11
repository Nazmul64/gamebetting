@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-fish" style="color:#34d399; margin-right:8px;"></i>
                Big Bass Splash™ (Pragmatic Play) — Control Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                ৫x৩ গ্রিড, ১০ পে-লাইন, ফিশ মানি ক্যাশ ট্যাগ ($2\times - 50\times$), জেলে (Fisherman Wild) হুক কালেক্ট ও হাউজ প্রফিট ইঞ্জিন।
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('big-bass-splash') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#10b981,#059669); border:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.3); color:#34d399; padding:12px 16px; border-radius:10px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:13.5px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#f87171; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13.5px;">
        <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
    </div>
    @endif

    <!-- অপারেশন গাইডলাইন ও হাউস প্রফিট মেকানিজম (বাংলা নির্দেশিকা) -->
    <div class="panel mb-4" style="border-left: 4px solid #34d399; background: rgba(52, 211, 153, 0.05);">
        <div class="panel-header" style="background: rgba(52, 211, 153, 0.1);">
            <div class="panel-title" style="color: #6ee7b7; font-size: 14px; font-weight:700;">
                <i class="fas fa-shield-halved"></i> গেম পরিচালনা ও হাউজ প্রফিট গাইডলাইন (1xBet Methodology - ১০০% এডমিন সেফ)
            </div>
        </div>
        <div class="panel-body" style="font-size: 13.5px; color: #cbd5e1; line-height: 1.7;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                <div>
                    <h5 style="color:#a7f3d0; font-size:14px; margin-bottom:6px;"><i class="fas fa-water"></i> ১. ফিশ মানি ও ক্যাশ ট্যাগ ভ্যালু:</h5>
                    <p style="margin:0; font-size:13px;">
                        ৫x৩ গ্রিডের এই খেলায় মাছের সিম্বলগুলোতে ইনস্ট্যান্ট টাকার ভ্যালু থাকে ($2\times, 5\times, 10\times, 20\times, 50\times$ ইত্যাদি)। সাধারণ স্পিনে এগুলো পে-লাইনে ক্যাশ ভ্যালু দেয়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#a7f3d0; font-size:14px; margin-bottom:6px;"><i class="fas fa-user-ninja"></i> ২. জেলে (Fisherman Wild) ও হুক কালেক্ট:</h5>
                    <p style="margin:0; font-size:13px;">
                        যখনই স্ক্রিনে Fisherman Wild সিম্বল ড্রপ করে, সে বড়শি দিয়ে স্ক্রিনে থাকা সমস্ত মাছের টাকার ভ্যালু টেনে তুলে প্লেয়ারের মোট উইনে যোগ করে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#a7f3d0; font-size:14px; margin-bottom:6px;"><i class="fas fa-cart-shopping"></i> ৩. Buy Free Spins (১০০ গুণ বাজি):</h5>
                    <p style="margin:0; font-size:13px;">
                        প্লেয়ার বামপাশের Buy Free Spins বাটন দিয়ে মূল বেটের ১০০ গুণ দিয়ে সরাসরি বোনাস রাউন্ড কিনতে পারে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#a7f3d0; font-size:14px; margin-bottom:6px;"><i class="fas fa-shield-alt"></i> ৪. হাউজ প্রফিট ও ডেমো লিমিট:</h5>
                    <p style="margin:0; font-size:13px;">
                        <strong>House Profit Mode</strong> সিলেক্ট রাখলে সিস্টেম বড় বেটে কোনো জেলে ড্রপ করায় না বা কম টাকার মাছ ফেলে। ডেমোতে ৩ বার খেলার পরেই স্ক্রিন লক হয়ে ডিপোজিট পপ-আপ প্রদর্শিত হয়।
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
            <div class="stat-card-label">এডমিনের নিট লাভ</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-rotate"></i></div>
                <span class="stat-card-change" style="background:rgba(52,211,153,0.15); color:#6ee7b7; border:1px solid rgba(52,211,153,0.3);">Spins</span>
            </div>
            <div class="stat-card-val">{{ number_format($totalSpins) }}</div>
            <div class="stat-card-label">সর্বমোট খেলা স্পিন</div>
        </div>
    </div>

    <!-- গেম কনফিগারেশন সেটিংস ও অডিও ট্র্যাক -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(420px, 1fr)); gap:20px;" class="mb-4">
        <!-- গেম সেটিংস ফর্ম -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:#34d399;"></i> Big Bass Splash অ্যালগরিদম ও কন্ট্রোল</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.bigbass.settings') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">গেমের নাম:</label>
                        <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                    </div>

                    <div class="form-group mb-3">
                        <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">অ্যালগরিদম কন্ট্রোল মোড:</label>
                        <select name="control_mode" class="form-control" style="background:rgba(0,0,0,0.4); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                            <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>House Profit Mode (এডমিন সেফ - রিকমেন্ডেড)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (নির্ধারিত উইন % অনুযায়ী)</option>
                            <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>100% Random (ন্যাচারাল আরটিপি)</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="mb-3">
                        <div class="form-group">
                            <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">ইউজারের জয়ের সম্ভাবনা (%):</label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="5" max="95" class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                        </div>
                        <div class="form-group">
                            <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">ডেমো ফ্রি স্পিন লিমিট:</label>
                            <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" min="1" max="20" class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="mb-3">
                        <div class="form-group">
                            <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">সর্বনিম্ন বাজি (৳):</label>
                            <input type="number" step="0.50" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                        </div>
                        <div class="form-group">
                            <label style="color:var(--text-secondary); font-size:12px; font-weight:700; margin-bottom:6px; display:block;">সর্বোচ্চ বাজি (৳):</label>
                            <input type="number" step="100" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px; width:100%;">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; padding:11px; font-size:14px; background:linear-gradient(135deg,#10b981,#059669); border:none; border-radius:8px; cursor:pointer;">
                        <i class="fas fa-floppy-disk"></i> সেটিংস সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- অডিও ও সাউন্ড ট্র্যাক সেটিংস -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-volume-high" style="color:#34d399;"></i> সাউন্ড ও অডিও আপলোড</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_music' => ['title' => 'ব্যাকগ্রাউন্ড আন্ডারওয়াটার মিউজিক', 'icon' => 'fa-music'],
                        'spin_sound' => ['title' => 'রিল ঘোরার সাউন্ড', 'icon' => 'fa-rotate'],
                        'win_sound' => ['title' => 'জয়ের সাউন্ড', 'icon' => 'fa-award'],
                        'reel_splash_sound' => ['title' => 'ওয়াটার স্প্ল্যাশ সাউন্ড', 'icon' => 'fa-water'],
                        'fisherman_hook_sound' => ['title' => 'জেলে বড়শি ফেলার সাউন্ড', 'icon' => 'fa-anchor'],
                    ];
                @endphp

                @foreach($audios as $key => $audio)
                    <form action="{{ route('admin.bigbass.audio') }}" method="POST" enctype="multipart/form-data" class="mb-3" style="padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.08);">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <label style="font-size:12px; font-weight:700; color:var(--text-secondary); margin:0;">
                                <i class="fas {{ $audio['icon'] }}" style="color:#34d399; margin-right:4px;"></i> {{ $audio['title'] }} (.mp3/.wav):
                            </label>
                            @if($settings->$key)
                                <span style="font-size:11px; color:#34d399; font-weight:700;"><i class="fas fa-circle-check"></i> ফাইল সেট করা আছে</span>
                            @else
                                <span style="font-size:11px; color:#f59e0b;"><i class="fas fa-circle-info"></i> ডিফল্ট সিন্থ সাউন্ড</span>
                            @endif
                        </div>
                        <div style="display:flex; gap:8px;">
                            <input type="file" name="audio_file" accept="audio/*" required class="form-control" style="background:rgba(0,0,0,0.25); border:1px solid var(--border-color); color:#fff; border-radius:6px; padding:6px; font-size:12px; flex:1;">
                            <button type="submit" class="btn-secondary" style="padding:6px 14px; font-size:12px; border-radius:6px; background:#1e293b; color:#fff; border:1px solid rgba(255,255,255,0.15); cursor:pointer;">আপলোড</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    <!-- সাম্প্রতিক স্পিন অডিট লগ -->
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-list-check" style="color:#34d399;"></i> সাম্প্রতিক স্পিন ও ফিশ মানি অডিট লগ (সর্বশেষ ১৫টি)</div>
        </div>
        <div class="panel-body p-0">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:12.5px; text-align:left;">
                    <thead>
                        <tr style="background:rgba(0,0,0,0.2); border-bottom:1px solid var(--border-color); color:var(--text-secondary);">
                            <th style="padding:10px 14px;">ID</th>
                            <th style="padding:10px 14px;">ইউজার</th>
                            <th style="padding:10px 14px;">মোড</th>
                            <th style="padding:10px 14px;">বাজির পরিমাণ</th>
                            <th style="padding:10px 14px;">জেলে ওয়াইল্ড</th>
                            <th style="padding:10px 14px;">উইন পরিমাণ</th>
                            <th style="padding:10px 14px;">এডমিন লাভ</th>
                            <th style="padding:10px 14px;">তারিখ ও সময়</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSpins as $spin)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:10px 14px; font-family:monospace; color:var(--text-secondary);">#{{ $spin->id }}</td>
                            <td style="padding:10px 14px; font-weight:700;">{{ $spin->user ? $spin->user->name : 'Demo Player' }}</td>
                            <td style="padding:10px 14px;">
                                @if($spin->is_demo)
                                    <span style="background:rgba(245,158,11,0.15); color:#fbbf24; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700;">DEMO</span>
                                @elseif($spin->is_buy_bonus)
                                    <span style="background:rgba(236,72,153,0.15); color:#f472b6; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700;">BUY BONUS</span>
                                @else
                                    <span style="background:rgba(16,185,129,0.15); color:#34d399; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700;">REAL</span>
                                @endif
                            </td>
                            <td style="padding:10px 14px; font-family:monospace; font-weight:700;">৳ {{ number_format($spin->bet_amount, 2) }}</td>
                            <td style="padding:10px 14px;">
                                @if($spin->has_fisherman)
                                    <span style="color:#34d399; font-weight:700;"><i class="fas fa-check"></i> YES (Hook Cast)</span>
                                @else
                                    <span style="color:var(--text-secondary);">NO</span>
                                @endif
                            </td>
                            <td style="padding:10px 14px; font-family:monospace; font-weight:700; color:{{ $spin->win_amount > 0 ? '#34d399' : '#f87171' }};">
                                ৳ {{ number_format($spin->win_amount, 2) }}
                            </td>
                            <td style="padding:10px 14px; font-family:monospace; font-weight:700; color:{{ $spin->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                                ৳ {{ number_format($spin->admin_profit, 2) }}
                            </td>
                            <td style="padding:10px 14px; color:var(--text-secondary); font-size:11.5px;">
                                {{ $spin->created_at->format('d M, h:i A') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding:20px; text-align:center; color:var(--text-secondary);">এখনও কোনো স্পিন খেলা হয়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
