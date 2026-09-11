@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-candy-cane" style="color:#e879f9; margin-right:8px;"></i>
                BonBon Bonanza™ (Sweet Bonanza) — Control Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                Pragmatic Play স্টাইলের ৬x৫ গ্রিড, Pay Anywhere (৮+ ক্লাস্টার পেআউট), টাম্বলিং/ক্যাসকেডিং ব্লাস্ট ও হাউজ প্রফিট ইঞ্জিন।
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('bonbon-bonanza') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#e879f9,#c026d3); border:none; display:inline-flex; align-items:center; gap:6px;">
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
    <div class="panel mb-4" style="border-left: 4px solid #e879f9; background: rgba(232, 121, 249, 0.05);">
        <div class="panel-header" style="background: rgba(232, 121, 249, 0.1);">
            <div class="panel-title" style="color: #f0abfc; font-size: 14px; font-weight:700;">
                <i class="fas fa-shield-halved"></i> গেম পরিচালনা ও হাউজ প্রফিট গাইডলাইন (1xBet Methodology - ১০০% এডমিন সেফ)
            </div>
        </div>
        <div class="panel-body" style="font-size: 13.5px; color: #cbd5e1; line-height: 1.7;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                <div>
                    <h5 style="color:#f5d0fe; font-size:14px; margin-bottom:6px;"><i class="fas fa-border-all"></i> ১. Pay Anywhere ও ৬x৫ ক্লাস্টার মেকানিক্স:</h5>
                    <p style="margin:0; font-size:13px;">
                        এটি ৬ কলাম এবং ৫ রো-এর খেলা (মোট ৩০টি স্লট)। কোনো নির্দিষ্ট পে-লাইনের প্রয়োজন নেই। স্ক্রিনের যেকোনো স্থানে একই জাতের ক্যান্ডি বা ফল ন্যূনতম ৮টি বা তার বেশি পড়লেই ইউজার পেআউট পায়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#f5d0fe; font-size:14px; margin-bottom:6px;"><i class="fas fa-burst"></i> ২. টাম্বলিং ও ক্যাসকেডিং ব্লাস্ট (Tumble Feature):</h5>
                    <p style="margin:0; font-size:13px;">
                        মিলে যাওয়া ৮+ ক্যান্ডিগুলো ব্লাস্ট হয়ে মুছে যায় এবং ওপরের সিম্বলগুলো নিচে ড্রপ করে নতুন সিম্বল আসে। ফলে এক স্পিনেই প্লেয়ার একাধিক কম্বো পেআউট জিততে পারে।
                    </p>
                </div>
                <div>
                    <h5 style="color:#f5d0fe; font-size:14px; margin-bottom:6px;"><i class="fas fa-bolt"></i> ৩. Scatter Boost (+২৫% বাজি):</h5>
                    <p style="margin:0; font-size:13px;">
                        প্লেয়ার স্ক্রিনের নিচের স্ক্যাটার বুস্ট অন করলে বাজির পরিমাণ ২৫% বৃদ্ধি পায় এবং স্ক্রিনে স্ক্যাটার (ললিপপ) পড়ার সম্ভাবনা দ্বিগুণ হয়ে যায়।
                    </p>
                </div>
                <div>
                    <h5 style="color:#f5d0fe; font-size:14px; margin-bottom:6px;"><i class="fas fa-shield-alt"></i> ৪. হাউজ প্রফিট ও ডেমো লিমিটেশন:</h5>
                    <p style="margin:0; font-size:13px;">
                        <strong>House Profit Mode</strong> সিলেক্ট রাখলে সিস্টেম বড় বেটে কোনো সিম্বল ৮টি মিলতে দেয় না (সর্বোচ্চ ৫-৬টি ড্রপ করে)। ডেমোতে ৩ বার খেলার পরেই স্ক্রিন লক হয়ে ডিপোজিট পপ-আপ প্রদর্শিত হয়।
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
                <span class="stat-card-change" style="background:rgba(232,121,249,0.15); color:#f0abfc; border:1px solid rgba(232,121,249,0.3);">Spins</span>
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
                <div class="panel-title"><i class="fas fa-sliders" style="color:#e879f9;"></i> BonBon Bonanza অ্যালগরিদম ও কন্ট্রোল</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.bonbon.settings') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-size:12.5px; color:#cbd5e1; margin-bottom:6px; display:block;">
                            <i class="fas fa-robot"></i> অ্যালগরিদম মোড (Algorithm Control):
                        </label>
                        <select name="control_mode" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>
                                🛡️ House Profit Mode (কম পেআউট - এডমিন প্রফিট সুরক্ষিত)
                            </option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>
                                🎯 Fixed Percentage (নির্ধারিত উইন % অনুযায়ী পেআউট)
                            </option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>
                                🎲 100% Random (ন্যাচারাল আরটিপি)
                            </option>
                        </select>
                        <small style="color:var(--text-secondary); font-size:11.5px; display:block; margin-top:4px;">
                            House Profit মোডে সিস্টেম ৮টি ক্লাস্টার ড্রপ নিয়ন্ত্রণ করে এডমিন লাভ ধরে রাখবে।
                        </small>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label" style="font-size:12.5px; color:#cbd5e1; margin-bottom:6px; display:block;">
                                <i class="fas fa-percent"></i> ইউজারের জয়ের সম্ভাবনা (%):
                            </label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="100" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px;" required>
                            <small style="color:var(--text-secondary); font-size:11.5px;">ডিফল্ট: ৩৫%</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:12.5px; color:#cbd5e1; margin-bottom:6px; display:block;">
                                <i class="fas fa-hand-holding-dollar"></i> ডেমো স্পিন লিমিট:
                            </label>
                            <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" min="1" max="50" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px;" required>
                            <small style="color:var(--text-secondary); font-size:11.5px;">ডিফল্ট: ৩ বার স্পিনের পর লক</small>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="mb-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size:12.5px; color:#cbd5e1; margin-bottom:6px; display:block;">
                                সর্বনিম্ন বাজি (Min Bet ৳):
                            </label>
                            <input type="number" step="0.5" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px;" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:12.5px; color:#cbd5e1; margin-bottom:6px; display:block;">
                                সর্বোচ্চ বাজি (Max Bet ৳):
                            </label>
                            <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; border-radius:8px; padding:10px;" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; padding:11px; background:linear-gradient(135deg,#e879f9,#c026d3); border:none; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                        <i class="fas fa-floppy-disk"></i> সেটিংস সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- কাস্টম অডিও ও মিউজিক কন্ট্রোল -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-music" style="color:#e879f9;"></i> সাউন্ড ট্র্যাক ও অডিও ফাইল আপলোড</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_music' => ['title' => 'ব্যাকগ্রাউন্ড সুইট ক্যান্ডি মিউজিক', 'icon' => 'fa-headphones'],
                        'spin_sound' => ['title' => 'টাম্বলিং স্পিন সাউন্ড', 'icon' => 'fa-rotate'],
                        'win_sound' => ['title' => 'উইন ও মেগা ক্যান্ডি পেআউট সাউন্ড', 'icon' => 'fa-trophy'],
                        'tumble_blast_sound' => ['title' => 'ক্যান্ডি পপ / ব্লাস্ট সাউন্ড', 'icon' => 'fa-burst']
                    ];
                @endphp

                @foreach($audios as $key => $meta)
                <div style="background:rgba(15,23,42,0.5); border:1px solid var(--border-color); border-radius:8px; padding:12px; margin-bottom:12px;">
                    <form action="{{ route('admin.bonbon.audio') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                            <label style="font-size:12.5px; font-weight:700; color:#cbd5e1; margin:0;">
                                <i class="fas {{ $meta['icon'] }}" style="color:#e879f9; margin-right:4px;"></i> {{ $meta['title'] }} (.mp3/.wav):
                            </label>
                            @if($settings->$key)
                            <span style="font-size:11px; color:#34d399; background:rgba(16,185,129,0.15); padding:2px 8px; border-radius:4px;">
                                <i class="fas fa-check"></i> কাস্টম অডিও লোড করা
                            </span>
                            @else
                            <span style="font-size:11px; color:#94a3b8; background:rgba(148,163,184,0.1); padding:2px 8px; border-radius:4px;">
                                সিন্থেটিক ওয়েব অডিও একটিভ
                            </span>
                            @endif
                        </div>
                        <div style="display:flex; gap:8px;">
                            <input type="file" name="audio_file" accept=".mp3,.wav" class="form-control" style="background:rgba(15,23,42,0.8); border:1px solid var(--border-color); color:#fff; font-size:12px; padding:6px 10px;" required>
                            <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px; background:#1e293b; border:1px solid #334155; white-space:nowrap;">
                                <i class="fas fa-upload"></i> আপলোড
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- লাইভ স্পিন অডিট ও প্লেয়ার হিস্ট্রি -->
    <div class="panel">
        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title"><i class="fas fa-list-check" style="color:#e879f9;"></i> সাম্প্রতিক স্পিন ও প্লেয়ার অডিট লগ (সর্বশেষ ১৫টি)</div>
            <span style="font-size:12px; color:var(--text-secondary);">অটো-লগিং সক্রিয়</span>
        </div>
        <div class="panel-body p-0" style="overflow-x:auto;">
            <table class="table" style="width:100%; border-collapse:collapse; text-align:left; font-size:13px; color:#cbd5e1;">
                <thead>
                    <tr style="background:rgba(15,23,42,0.8); border-bottom:1px solid var(--border-color); color:var(--text-secondary);">
                        <th style="padding:12px 16px;">আইডি</th>
                        <th style="padding:12px 16px;">প্লেয়ার</th>
                        <th style="padding:12px 16px;">মোড</th>
                        <th style="padding:12px 16px;">স্ক্যাটার বুস্ট</th>
                        <th style="padding:12px 16px;">মোট বাজি</th>
                        <th style="padding:12px 16px;">টাম্বল সংখ্যা</th>
                        <th style="padding:12px 16px;">উইন অ্যামাউন্ট</th>
                        <th style="padding:12px 16px;">এডমিন লাভ</th>
                        <th style="padding:12px 16px;">সময়</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $spin)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <td style="padding:12px 16px; font-weight:700; color:#94a3b8;">#{{ $spin->id }}</td>
                        <td style="padding:12px 16px;">
                            @if($spin->user)
                                <div style="font-weight:600; color:#fff;">{{ $spin->user->name }}</div>
                                <small style="color:#64748b;">{{ $spin->user->email }}</small>
                            @else
                                <span style="color:#64748b;">গেস্ট / ডেমো</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px;">
                            @if($spin->is_demo)
                                <span style="background:rgba(234,179,8,0.15); color:#facc15; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:600;">DEMO</span>
                            @else
                                <span style="background:rgba(16,185,129,0.15); color:#34d399; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:600;">REAL MONEY</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px;">
                            @if($spin->scatter_boost_enabled)
                                <span style="background:rgba(168,85,247,0.2); color:#c084fc; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">
                                    <i class="fas fa-bolt"></i> ON (+25%)
                                </span>
                            @else
                                <span style="color:#64748b;">OFF</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:#fff;">৳ {{ number_format($spin->bet_amount, 2) }}</td>
                        <td style="padding:12px 16px; font-weight:700; color:#f0abfc;">
                            {{ $spin->tumble_count }}x Tumbles
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $spin->win_amount > 0 ? '#34d399' : '#94a3b8' }};">
                            ৳ {{ number_format($spin->win_amount, 2) }}
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $spin->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                            ৳ {{ number_format($spin->admin_profit, 2) }}
                        </td>
                        <td style="padding:12px 16px; color:#94a3b8; font-size:12px;">{{ $spin->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="padding:24px; text-align:center; color:#64748b;">
                            <i class="fas fa-inbox" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                            এখনও কোনো স্পিন রেকর্ড হয়নি।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
