@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-hat-cowboy-side" style="color:#f43f5e; margin-right:8px;"></i>
                Lucky Joker 100™ (100 Lines Slot) — Control Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                Amatic / 1xBet স্টাইলের ১০০ পে-লাইনের ফ্রুট স্লট মেশিন, Expanding Wild Joker, Scatter Multiplier & House Profit Engine.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('lucky-joker-100') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#f43f5e,#be123c); border:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    <!-- অপারেশন গাইডলাইন ও হাউস প্রফিট মেকানিজম (বাংলা নির্দেশিকা) -->
    <div class="panel mb-4" style="border-left: 4px solid #f43f5e; background: rgba(244, 63, 94, 0.05);">
        <div class="panel-header" style="background: rgba(244, 63, 94, 0.1);">
            <div class="panel-title" style="color: #fb7185; font-size: 14px; font-weight:700;">
                <i class="fas fa-shield-halved"></i> গেম পরিচালনা ও হাউস প্রফিট গাইডলাইন (1xBet Methodology - ১০০% এডমিন সেফ)
            </div>
        </div>
        <div class="panel-body" style="font-size: 13.5px; color: #cbd5e1; line-height: 1.7;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                <div>
                    <h5 style="color:#fda4af; font-size:14px; margin-bottom:6px;"><i class="fas fa-dice"></i> ১. ১০০ পে-লাইন ও ৫x৪ গ্রিড মেকানিক্স:</h5>
                    <p style="margin:0; font-size:13px;">
                        গেমটিতে ৫টি রিল এবং ৪টি রো রয়েছে (মোট ২০টি সিম্বল স্লট)। বাম থেকে ডানে ১০০টি নির্দিষ্ট পে-লাইনে ৩ বা ততোধিক একই সিম্বল পড়লে প্লেয়ার উইন পায়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fda4af; font-size:14px; margin-bottom:6px;"><i class="fas fa-wand-magic-sparkles"></i> ২. Expanding Wild (জোকার ফিমেল সিম্বল):</h5>
                    <p style="margin:0; font-size:13px;">
                        জোকার শুধুমাত্র রিল ২, ৩ ও ৪-এ পড়ে। যখন এটি কোনো পে-লাইনে কানেক্ট হয়, তখন তা পুরো কলাম জুড়ে বড় হয়ে যায় (Full Height Expanding Wild) এবং বড় পেআউট প্রদান করে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fda4af; font-size:14px; margin-bottom:6px;"><i class="fas fa-star"></i> ৩. Scatter Symbols (স্টার ও বেল):</h5>
                    <p style="margin:0; font-size:13px;">
                        স্টার এবং বেল সিম্বল পে-লাইনের বাইরে থাকলেও স্ক্রিনে ৩টি বা তার বেশি পড়লে প্লেয়ারকে সরাসরি জ্যাকপট পেআউট মাল্টিপ্লায়ার উপহার দেয়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#fda4af; font-size:14px; margin-bottom:6px;"><i class="fas fa-lock"></i> ৪. হাউজ প্রফিট ও ডেমো লিমিট:</h5>
                    <p style="margin:0; font-size:13px;">
                        <strong>House Profit Mode</strong> চালু থাকলে বড় বেটে সিস্টেম ওয়াইল্ড কানেকশন রেস্ট্রিক্ট করে কমদামী ফ্রুটস পে করে এডমিনের প্রফিট সবসময় প্লাসে রাখে। ডেমোতে ৩ বার স্পিন করার পরই গেম ফ্রিজ হয়ে ডিপোজিট পপ-আপ আসে।
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
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">100 Lines</span>
            </div>
            <div class="stat-card-val">{{ strtoupper(str_replace('_', ' ', $settings->control_mode)) }}</div>
            <div class="stat-card-label">অ্যালগরিদম মোড ({{ $totalSpins }} স্পিন)</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:20px; margin-bottom:24px;">
        <!-- কন্ট্রোল সেটিংস ফরম -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> গেম অ্যালগরিদম ও কন্ট্রোল কনফিগারেশন</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.joker.settings') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">গেম ডিসপ্লে নাম:</label>
                        <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-input" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">অ্যালগরিদম মোড:</label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (এডমিন ১০০% সেফ - নিয়ন্ত্রিত পেআউট)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (উইন রেট % অনুযায়ী)</option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (ন্যাচারাল আরটিপি)</option>
                        </select>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">ইউজার উইন চান্স (%):</label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" class="form-input" min="1" max="100" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">ডেমো স্পিন লিমিট (বার):</label>
                            <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" class="form-input" required>
                        </div>
                    </div>

                    <div class="row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group mb-3">
                            <label class="form-label">মিনিমাম বেট লিমিট (৳):</label>
                            <input type="number" step="1" name="min_bet" value="{{ $settings->min_bet }}" class="form-input" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">ম্যাক্সিমাম বেট লিমিট (৳):</label>
                            <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-input" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; margin-top:10px; background:linear-gradient(135deg,#f43f5e,#be123c); border:none;">
                        <i class="fas fa-save"></i> সেটিংস সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- সাউন্ড ও অডিও কাস্টমাইজেশন -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-volume-high" style="color:var(--accent-cyan);"></i> সাউন্ড ইফেক্ট ও অডিও আপলোড</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_music' => ['title' => 'ক্যাসিনো লাউঞ্জ ব্যাকগ্রাউন্ড মিউজিক', 'icon' => 'fa-music'],
                        'spin_sound' => ['title' => 'রিল স্পিনিং সাউন্ড', 'icon' => 'fa-rotate'],
                        'win_sound' => ['title' => 'কয়েন পেআউট ও উইন সাউন্ড', 'icon' => 'fa-trophy'],
                        'joker_laugh_sound' => ['title' => 'এক্সপান্ডিং জোকার ওয়াইল্ড সাউন্ড', 'icon' => 'fa-face-laugh-wink']
                    ];
                @endphp

                @foreach($audios as $key => $info)
                    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:12px; margin-bottom:12px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:13px; font-weight:600; color:var(--text-primary); display:flex; align-items:center; gap:6px;">
                                <i class="fas {{ $info['icon'] }}" style="color:#f43f5e;"></i> {{ $info['title'] }}
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

                        <form action="{{ route('admin.joker.audio') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:8px;">
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

    <!-- সাম্প্রতিক স্পিন অডিট লগ -->
    <div class="panel">
        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title"><i class="fas fa-list-check" style="color:var(--accent-gold);"></i> সাম্প্রতিক স্পিন ও পেআউট অডিট রেকর্ড</div>
            <span style="font-size:12px; color:var(--text-muted);">সর্বশেষ ১৫টি স্পিনের বিবরণ</span>
        </div>
        <div class="panel-body" style="padding:0; overflow-x:auto;">
            <table class="data-table" style="width:100%; border-collapse:collapse; font-size:12.5px;">
                <thead>
                    <tr style="background:rgba(255,255,255,0.04); text-align:left; border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="padding:12px 14px;">Spin ID</th>
                        <th style="padding:12px 14px;">User</th>
                        <th style="padding:12px 14px;">Mode</th>
                        <th style="padding:12px 14px;">Bet Amount</th>
                        <th style="padding:12px 14px;">Win Amount</th>
                        <th style="padding:12px 14px;">Admin Profit</th>
                        <th style="padding:12px 14px;">Expanding Wild</th>
                        <th style="padding:12px 14px;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $spin)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:12px 14px; font-family:var(--font-mono); font-weight:700; color:var(--text-primary);">
                                #{{ $spin->id }}
                            </td>
                            <td style="padding:12px 14px;">
                                {{ $spin->user ? $spin->user->name : 'Guest' }}
                            </td>
                            <td style="padding:12px 14px;">
                                @if($spin->is_demo)
                                    <span style="background:rgba(234,179,8,0.15); color:#eab308; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">DEMO</span>
                                @else
                                    <span style="background:rgba(16,185,129,0.15); color:#10b981; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">REAL MONEY</span>
                                @endif
                            </td>
                            <td style="padding:12px 14px; font-weight:700;">
                                ৳{{ number_format($spin->bet_amount, 2) }}
                            </td>
                            <td style="padding:12px 14px; color:{{ $spin->win_amount > 0 ? '#4ade80' : 'var(--text-muted)' }}; font-weight:700;">
                                ৳{{ number_format($spin->win_amount, 2) }}
                            </td>
                            <td style="padding:12px 14px; font-weight:800; color:{{ $spin->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                                ৳{{ number_format($spin->admin_profit, 2) }}
                            </td>
                            <td style="padding:12px 14px;">
                                @if($spin->has_expanding_wild)
                                    <span style="background:rgba(244,63,94,0.2); color:#f43f5e; padding:3px 8px; border-radius:4px; font-weight:800; border:1px solid rgba(244,63,94,0.4);">
                                        🃏 EXPANDED
                                    </span>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td style="padding:12px 14px; color:var(--text-muted); font-size:11px;">
                                {{ $spin->created_at ? $spin->created_at->diffForHumans() : 'Just now' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">
                                এখনও পর্যন্ত কোনো Lucky Joker 100 স্পিন রেকর্ড হয়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
