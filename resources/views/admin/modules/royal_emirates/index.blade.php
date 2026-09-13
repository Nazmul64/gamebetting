<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Emirates: Hold and Spin™ — Admin Control Module</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-dark: #070d1e;
            --panel-bg: #0d1a36;
            --panel-border: rgba(234, 179, 8, 0.25);
            --gold: #f59e0b;
            --gold-bright: #fbbf24;
            --accent-cyan: #06b6d4;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
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
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Top Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .header-title-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .header-icon {
            width: 48px;
            height: 48px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.4);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-bright);
            font-size: 22px;
        }
        .header-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .header-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text-main);
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }
        .btn-play {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: #000;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            transition: all 0.2s ease;
        }
        .btn-play:hover {
            filter: brightness(1.1);
        }

        /* Alert notifications */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        /* Guidelines Card */
        .guide-card {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .guide-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--gold-bright);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        .guide-list {
            font-size: 13px;
            color: #cbd5e1;
            line-height: 1.7;
            padding-left: 20px;
        }

        /* Analytics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-box {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        .stat-box::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .stat-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .stat-val {
            font-size: 24px;
            font-weight: 800;
            font-family: 'JetBrains Mono', monospace;
        }
        .val-gold { color: var(--gold-bright); }
        .val-green { color: #34d399; }
        .val-red { color: #f87171; }
        .val-cyan { color: var(--accent-cyan); }

        /* Main Content 2 Columns */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 900px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        .panel-card {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 24px;
        }
        .panel-card-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--gold);
        }
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-save {
            width: 100%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: #000;
            font-weight: 800;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        .btn-save:hover {
            filter: brightness(1.1);
        }

        /* Audio Form Row */
        .audio-item {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 12px;
        }
        .audio-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .audio-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--gold-bright);
        }
        .audio-current {
            font-size: 11px;
            color: var(--text-muted);
            word-break: break-all;
            margin-top: 6px;
        }
        .audio-upload-bar {
            display: flex;
            gap: 8px;
        }
        .audio-upload-bar input[type="file"] {
            font-size: 11.5px;
            padding: 6px 10px;
        }
        .btn-upload {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-upload:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Recent Spins Table */
        .table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            text-align: left;
        }
        th {
            background: rgba(0, 0, 0, 0.4);
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: #e2e8f0;
        }
        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title-group">
            <div class="header-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <h1 class="header-title">Royal Emirates: Hold and Spin™</h1>
                <div class="header-subtitle">5x3 Grid, 25 Paylines & Golden Horse Respins Management Module</div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('royal-emirates') }}" target="_blank" class="btn-play">
                <i class="fas fa-play"></i> Launch Game
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Guidelines -->
    <div class="guide-card">
        <div class="guide-title">
            <i class="fas fa-circle-info"></i> গেম পরিচালনা ও হাউজ প্রফিট গাইডলাইন (1xBet Standards)
        </div>
        <ol class="guide-list">
            <li><strong>Hold & Spin বোনাস মেকানিক্স:</strong> ৫x৩ গ্রিডে ৬টি বা ততোধিক গোল্ডেন হর্স কয়েন পড়লে মূল রিল লক হয়ে ৩টি বিশেষ রেস্পিন ট্রিগার হয়। প্রতিটি নতুন কয়েন পড়লে রেস্পিন সংখ্যা পুনরায় ৩-এ রিসেট হয়। পুরো ১৫টি ঘর কয়েনে ভরলে Grand Jackpot (৫০০০ গুণ) পেআউট হয়।</li>
            <li><strong>হাউজ প্রফিট ইঞ্জিন:</strong> <code>House Profit</code> মোডে ব্যাকএন্ড বড় বাজিগুলোতে ৬টি কয়েন ড্রপ হতে দেবে না (সর্বোচ্চ ৪-৫টি দিয়ে আটকাবে), ফলে এডমিনের প্রফিট ১০০% সুরক্ষিত থাকবে।</li>
            <li><strong>ডেমো প্লে লিমিটেশন:</strong> ইউজার ডেমো মোডে ৩ বা ৪ বারের বেশি ফ্রি স্পিন করতে পারবে না। লিমিট শেষ হলেই ফুল-স্ক্রিন ডিপোজিট পপ-আপ প্রদর্শিত হবে।</li>
        </ol>
    </div>

    <!-- Analytics Stats -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label"><i class="fas fa-hand-holding-dollar"></i> মোট আসল বাজি (Real Stakes)</div>
            <div class="stat-val val-cyan">৳ {{ number_format($totalCollected, 2) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label"><i class="fas fa-money-bill-transfer"></i> মোট পেআউট প্রদান (Payouts)</div>
            <div class="stat-val val-red">৳ {{ number_format($totalPaidOut, 2) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label"><i class="fas fa-sack-dollar"></i> এডমিনের নিট লাভ (House Profit)</div>
            <div class="stat-val {{ $adminProfit >= 0 ? 'val-green' : 'val-red' }}">
                {{ $adminProfit >= 0 ? '+' : '' }}৳ {{ number_format($adminProfit, 2) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label"><i class="fas fa-chart-line"></i> আরটিপি (RTP %)</div>
            <div class="stat-val val-gold">
                {{ $totalCollected > 0 ? number_format(($totalPaidOut / $totalCollected) * 100, 2) : '96.50' }}%
            </div>
        </div>
    </div>

    <!-- 2 Column Settings -->
    <div class="content-grid">
        <!-- Settings Form -->
        <div class="panel-card">
            <div class="panel-card-title">
                <i class="fas fa-sliders" style="color:var(--gold);"></i> গেম অ্যালগরিদম ও জ্যাকপট কন্ট্রোল
            </div>

            <form action="{{ route('admin.royalemirates.settings') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">অ্যালগরিদম কন্ট্রোল মোড</label>
                    <select name="control_mode" class="form-control" style="cursor:pointer;">
                        <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (সর্বোচ্চ এডমিন প্রফিট প্রোটেকশন)</option>
                        <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (নির্ধারিত উইন % অনুযায়ী)</option>
                        <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (ন্যাচারাল আরটিপি)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">ইউজারের জয়ের সম্ভাবনা (Win Chance %)</label>
                    <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="100" class="form-control" required>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">মিনিমাম বেট (৳)</label>
                        <input type="number" step="0.5" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ম্যাক্সিমাম বেট (৳)</label>
                        <input type="number" step="10" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">MINI জ্যাকপট (গুণ)</label>
                        <input type="number" step="0.1" name="mini_multiplier" value="{{ $settings->mini_multiplier }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">MINOR জ্যাকপট (গুণ)</label>
                        <input type="number" step="0.1" name="minor_multiplier" value="{{ $settings->minor_multiplier }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">MEGA জ্যাকপট (গুণ)</label>
                        <input type="number" step="0.1" name="mega_multiplier" value="{{ $settings->mega_multiplier }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">GRAND জ্যাকপট (গুণ)</label>
                        <input type="number" step="1" name="grand_multiplier" value="{{ $settings->grand_multiplier }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">ডেমো স্পিন লিমিট (স্পিন সংখ্যা)</label>
                    <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" min="1" max="10" class="form-control" required>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> সেটিংস সংরক্ষণ করুন
                </button>
            </form>
        </div>

        <!-- Audio Uploads -->
        <div class="panel-card">
            <div class="panel-card-title">
                <i class="fas fa-music" style="color:var(--gold);"></i> সাউন্ড ও মিউজিক কাস্টমাইজেশন
            </div>

            @php
                $audios = [
                    'bg_music' => 'ব্যাকগ্রাউন্ড অ্যারাবিক মিউজিক',
                    'spin_sound' => 'রিল ঘোরার সাউন্ড',
                    'win_sound' => 'জয়ের কয়েন সাউন্ড',
                    'coin_drop_sound' => 'গোল্ডেন কয়েন পড়ার সাউন্ড',
                    'hold_spin_trigger_sound' => 'হোল্ড অ্যান্ড স্পিন বোনাস সাউন্ড'
                ];
            @endphp

            @foreach($audios as $key => $title)
                <div class="audio-item">
                    <div class="audio-header">
                        <span class="audio-title">{{ $title }}</span>
                        @if($settings->$key)
                            <span style="font-size:10px; background:#10b98122; color:#34d399; padding:2px 8px; border-radius:4px; font-weight:700;">ACTIVE</span>
                        @else
                            <span style="font-size:10px; background:rgba(255,255,255,0.06); color:#94a3b8; padding:2px 8px; border-radius:4px;">DEFAULT</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.royalemirates.audio') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <div class="audio-upload-bar">
                            <input type="file" name="audio_file" accept=".mp3,.wav,.ogg" class="form-control" required>
                            <button type="submit" class="btn-upload">আপলোড</button>
                        </div>
                    </form>
                    @if($settings->$key)
                        <div class="audio-current">
                            <i class="fas fa-file-audio"></i> {{ $settings->$key }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Spins Log -->
    <div class="panel-card">
        <div class="panel-card-title">
            <i class="fas fa-clock-rotate-left" style="color:var(--gold);"></i> সাম্প্রতিক স্পিন ইতিহাস (Recent Spins)
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>ইউজার</th>
                        <th>মোড</th>
                        <th>বাজির পরিমাণ</th>
                        <th>উইনিং</th>
                        <th>প্রফিট / লস</th>
                        <th>বোনাস / জ্যাকপট</th>
                        <th>সময়</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $spin)
                    <tr>
                        <td style="font-family:'JetBrains Mono'; font-weight:700;">#{{ $spin->id }}</td>
                        <td>{{ $spin->user ? $spin->user->name : 'Demo User' }}</td>
                        <td>
                            @if($spin->is_demo)
                                <span style="font-size:10px; background:rgba(255,255,255,0.1); color:#94a3b8; padding:2px 6px; border-radius:4px; font-weight:700;">DEMO</span>
                            @else
                                <span style="font-size:10px; background:#10b98122; color:#34d399; padding:2px 6px; border-radius:4px; font-weight:700;">REAL</span>
                            @endif
                        </td>
                        <td style="font-family:'JetBrains Mono';">৳ {{ number_format($spin->bet_amount, 2) }}</td>
                        <td style="font-family:'JetBrains Mono'; color:#34d399; font-weight:700;">৳ {{ number_format($spin->win_amount, 2) }}</td>
                        <td style="font-family:'JetBrains Mono'; font-weight:700; color:{{ $spin->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                            {{ $spin->admin_profit >= 0 ? '+' : '' }}৳ {{ number_format($spin->admin_profit, 2) }}
                        </td>
                        <td>
                            @if($spin->triggered_hold_spin)
                                <span style="font-size:10px; background:#f59e0b22; color:#fbbf24; padding:2px 6px; border-radius:4px; font-weight:700;">HOLD & SPIN</span>
                            @endif
                            @if($spin->jackpot_won)
                                <span style="font-size:10px; background:#ef444422; color:#f87171; padding:2px 6px; border-radius:4px; font-weight:800; margin-left:4px;">{{ $spin->jackpot_won }}</span>
                            @endif
                            @if(!$spin->triggered_hold_spin && !$spin->jackpot_won)
                                <span style="color:var(--text-muted); font-size:11px;">Line Win</span>
                            @endif
                        </td>
                        <td style="color:var(--text-muted); font-size:11px;">{{ $spin->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:20px; color:var(--text-muted);">এখনো কোনো স্পিন রেকর্ড করা হয়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
