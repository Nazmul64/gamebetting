<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Emirate™ — Admin Control Module</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-dark: #081225;
            --panel-bg: #0d1e38;
            --panel-border: rgba(255, 215, 0, 0.2);
            --gold: #f59e0b;
            --gold-bright: #fbbf24;
            --accent-blue: #0284c7;
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
            width: 46px;
            height: 46px;
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

        /* Alerts */
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

        /* Guide Card */
        .guide-card {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(13, 30, 56, 0.95) 100%);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .guide-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: var(--gold-bright);
            margin-bottom: 12px;
        }
        .guide-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .guide-list li i {
            color: var(--gold);
            margin-right: 6px;
        }

        /* Financial Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .metric-card {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
        }
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
        }
        .metric-card.blue::before { background: var(--accent-blue); }
        .metric-card.red::before { background: var(--danger); }
        .metric-card.green::before { background: var(--success); }
        .metric-card.gold::before { background: var(--gold); }
        .metric-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .metric-val {
            font-size: 24px;
            font-weight: 800;
            margin-top: 6px;
            color: #fff;
        }

        /* Main Content 2-Column Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
        }

        .panel-card {
            background: var(--panel-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 22px;
        }
        .panel-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--gold);
        }
        .form-control select, select.form-control {
            background: #09172c;
            color: #fff;
        }

        .btn-submit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5);
        }

        /* Audio Upload Row */
        .audio-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .audio-item:last-child {
            border-bottom: none;
        }
        .audio-label {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .audio-upload-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .audio-upload-form input[type="file"] {
            font-size: 11.5px;
            color: var(--text-muted);
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 6px 10px;
            border-radius: 6px;
            flex: 1;
        }
        .btn-upload {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-upload:hover {
            background: var(--gold);
            color: #000;
            border-color: var(--gold);
        }
        .current-audio-tag {
            font-size: 11px;
            color: #34d399;
            margin-top: 4px;
            display: block;
        }

        /* Audit Table */
        .audit-panel {
            background: var(--panel-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 22px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }
        .custom-table th {
            background: rgba(0, 0, 0, 0.3);
            color: var(--text-muted);
            font-weight: 700;
            padding: 10px 12px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-win { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
        .badge-loss { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }
        .badge-demo { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
        .badge-real { background: rgba(14, 165, 233, 0.2); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.4); }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-title-group">
            <div class="header-icon">
                <i class="fas fa-gem"></i>
            </div>
            <div>
                <h1 class="header-title">The Emirate™ (Endorphina) — Control Module</h1>
                <p class="header-subtitle">৫ ফিক্সড পে-লাইন, পাম জুমিরাহ স্ক্যাটার এবং হাউজ প্রফিট অ্যালগরিদম কন্ট্রোল</p>
            </div>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('the-emirate') }}" target="_blank" class="btn-back" style="background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.4); color:var(--gold-bright);">
                <i class="fas fa-play"></i> Launch Game
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Operational Guideline -->
    <div class="guide-card">
        <div class="guide-header">
            <i class="fas fa-book-open"></i>
            <span>গেম পরিচালনা ও হাউজ প্রফিট গাইডলাইন (1xBet মেথডোলজি)</span>
        </div>
        <ul class="guide-list">
            <li><i class="fas fa-check-circle"></i> <strong>৫টি ফিক্সড পে-লাইন মেকানিক্স:</strong> ৫টি রিল ও ৩টি রো-এর এই ক্লাসিক স্লটে ৩টি অনুভূমিক ও ২টি ডায়াগোনাল লাইনে বাম থেকে ডানে শেখ, কার বা দুবাই টাওয়ার মিলে উইন পেআউট দেয়।</li>
            <li><i class="fas fa-check-circle"></i> <strong>পাম জুমিরাহ স্ক্যাটার:</strong> স্ক্রিনের যেকোনো জায়গায় ৩টি পাম ট্রি পড়লে কোনো লাইনের বাধ্যবাধকতা ছাড়াই অতিরিক্ত ক্যাশ বোনাস ($5\times$) ক্রেডিট হয়।</li>
            <li><i class="fas fa-check-circle"></i> <strong>হাউজ প্রফিট ইঞ্জিন:</strong> "House Profit" মোড চালু থাকলে ব্যাকএন্ড বড় বাজিগুলোতে পে-লাইন ব্রেক করে দেয় এবং এডমিন প্রফিট শতভাগ নিরাপদ রাখে।</li>
            <li><i class="fas fa-check-circle"></i> <strong>ডেমো স্পিন লক:</strong> ডেমো মোডে ৩ বার ফ্রি ঘোরানোর পর স্বয়ংক্রিয়ভাবে স্ক্রিন লক করে ডিপোজিট পপ-আপ দেবে।</li>
        </ul>
    </div>

    <!-- Financial Metrics -->
    <div class="metrics-grid">
        <div class="metric-card blue">
            <div class="metric-label">মোট আসল বেট সংগ্রহ</div>
            <div class="metric-val">৳ {{ number_format($totalCollected, 2) }}</div>
        </div>
        <div class="metric-card red">
            <div class="metric-label">মোট পেআউট প্রদান</div>
            <div class="metric-val">৳ {{ number_format($totalPaidOut, 2) }}</div>
        </div>
        <div class="metric-card green">
            <div class="metric-label">এডমিনের নিট লাভ</div>
            <div class="metric-val">৳ {{ number_format($adminProfit, 2) }}</div>
        </div>
        <div class="metric-card gold">
            <div class="metric-label">সর্বমোট স্পিন সংখ্যা</div>
            <div class="metric-val">{{ number_format($totalSpins) }}</div>
        </div>
    </div>

    <!-- Main Grid: Settings & Audio Uploads -->
    <div class="main-grid">
        <!-- Settings Form -->
        <div class="panel-card">
            <div class="panel-title">
                <i class="fas fa-sliders" style="color:var(--gold-bright);"></i>
                <span>The Emirate অ্যালগরিদম ও কন্ট্রোল সেটিংস</span>
            </div>

            <form action="{{ route('admin.emirate.settings') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">গেম ডিসপ্লে নাম:</label>
                    <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">অ্যালগরিদম কন্ট্রোল মোড:</label>
                    <select name="control_mode" class="form-control">
                        <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>
                            House Profit Mode (এডমিন সেফ - রিকমেন্ডেড)
                        </option>
                        <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>
                            Fixed Percentage (উইন % অনুযায়ী পেআউট)
                        </option>
                        <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>
                            100% Random (ন্যাচারাল আরটিপি)
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">ইউজারের জয়ের সম্ভাবনা (%):</label>
                    <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="100" class="form-control" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">মিনিমাম বেট (৳):</label>
                        <input type="number" step="0.01" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ম্যাক্সিমাম বেট (৳):</label>
                        <input type="number" step="0.01" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label">ডেমো স্পিন লিমিট:</label>
                        <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ডিফল্ট ডেমো ব্যালেন্স (৳):</label>
                        <input type="number" step="0.01" name="demo_default_balance" value="{{ $settings->demo_default_balance }}" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> সেটিংস সংরক্ষণ করুন
                </button>
            </form>
        </div>

        <!-- Audio Uploads -->
        <div class="panel-card">
            <div class="panel-title">
                <i class="fas fa-music" style="color:#38bdf8;"></i>
                <span>সাউন্ড ট্র্যাক ও অডিও ফাইল আপলোড</span>
            </div>

            @php
                $audios = [
                    'bg_music' => ['title' => 'ব্যাকগ্রাউন্ড এরাবিক লাউঞ্জ মিউজিক', 'icon' => 'fa-headphones'],
                    'spin_sound' => ['title' => 'মেকানিক্যাল রিল ঘোরার সাউন্ড', 'icon' => 'fa-rotate'],
                    'win_sound' => ['title' => 'দুবাই গোল্ডেন কয়েন জয়ের সাউন্ড', 'icon' => 'fa-coins'],
                    'scatter_sound' => ['title' => 'পাম জুমিরাহ স্ক্যাটার জিংগেল', 'icon' => 'fa-tree']
                ];
            @endphp

            @foreach($audios as $key => $meta)
                <div class="audio-item">
                    <div class="audio-label">
                        <span><i class="fas {{ $meta['icon'] }}" style="color:var(--gold-bright); margin-right:6px;"></i> {{ $meta['title'] }}</span>
                    </div>
                    <form action="{{ route('admin.emirate.audio') }}" method="POST" enctype="multipart/form-data" class="audio-upload-form">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <input type="file" name="audio_file" accept="audio/mp3,audio/wav" required>
                        <button type="submit" class="btn-upload">আপলোড</button>
                    </form>
                    @if($settings->$key)
                        <small class="current-audio-tag">
                            <i class="fas fa-check"></i> ফাইল সংযুক্ত: {{ $settings->$key }}
                        </small>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Audit Logs -->
    <div class="audit-panel">
        <div class="panel-title">
            <i class="fas fa-history" style="color:var(--text-muted);"></i>
            <span>সাম্প্রতিক ১৫টি স্পিন অডিট লগ</span>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Mode</th>
                        <th>Bet (৳)</th>
                        <th>Win (৳)</th>
                        <th>Admin Profit (৳)</th>
                        <th>Type</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $spin)
                        <tr>
                            <td>#{{ $spin->id }}</td>
                            <td>{{ $spin->user ? $spin->user->name : 'Demo Player' }}</td>
                            <td>
                                @if($spin->is_demo)
                                    <span class="badge badge-demo">Demo</span>
                                @else
                                    <span class="badge badge-real">Real</span>
                                @endif
                            </td>
                            <td>৳ {{ number_format($spin->bet_amount, 2) }}</td>
                            <td style="color:{{ $spin->win_amount > 0 ? '#34d399' : '#94a3b8' }}; font-weight:700;">
                                ৳ {{ number_format($spin->win_amount, 2) }}
                            </td>
                            <td style="color:{{ $spin->admin_profit > 0 ? '#38bdf8' : ($spin->admin_profit < 0 ? '#f87171' : '#94a3b8') }}; font-weight:700;">
                                ৳ {{ number_format($spin->admin_profit, 2) }}
                            </td>
                            <td>
                                @if($spin->is_scatter_win)
                                    <span class="badge" style="background:rgba(0,229,255,0.2); color:#00e5ff; border:1px solid #00e5ff;">Palm Scatter</span>
                                @elseif($spin->is_win)
                                    <span class="badge badge-win">Line Win</span>
                                @else
                                    <span class="badge badge-loss">Loss</span>
                                @endif
                            </td>
                            <td>{{ $spin->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:var(--text-muted); padding:20px;">
                                কোনো স্পিন রেকর্ড পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
