<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Game Health & Live Central Analytics — 1xBet Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg-deep: #060813;
            --bg-card: #0d1428;
            --bg-card-hover: #121c37;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --accent-cyan: #00f2fe;
            --accent-indigo: #6366f1;
            --accent-gold: #fbbf24;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 30px 24px;
        }
        .container {
            max-width: 1300px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }
        .header-title h1 {
            font-size: 26px;
            font-weight: 900;
            font-family: 'Space Grotesk', sans-serif;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-title p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 4px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border-subtle);
            color: #fff;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.12);
            transform: translateX(-2px);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.blue::before { background: linear-gradient(90deg, #3b82f6, #06b6d4); }
        .stat-card.green::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #ec4899); }
        .stat-card.gold::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

        .stat-card-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-card-value {
            font-size: 28px;
            font-weight: 900;
            font-family: 'JetBrains Mono', monospace;
            color: #fff;
            margin-top: 10px;
        }

        .panel {
            background: var(--bg-card);
            border: 1.5px solid var(--border-subtle);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        }
        .panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .panel-title {
            font-size: 17px;
            font-weight: 800;
            font-family: 'Space Grotesk', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .table-wrap {
            overflow-x: auto;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            min-width: 860px;
        }
        th {
            background: rgba(255,255,255,0.02);
            padding: 14px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid var(--border-subtle);
        }
        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            vertical-align: middle;
        }
        tr:hover td {
            background: rgba(255,255,255,0.025);
        }
        .badge-health {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .badge-healthy {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        .badge-balanced {
            background: rgba(0, 242, 254, 0.15);
            color: #00f2fe;
            border: 1px solid rgba(0, 242, 254, 0.35);
        }
        .badge-critical {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.35);
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(0.98); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <div class="header-title">
                <h1><i class="fas fa-heart-pulse" style="color:var(--accent-red);"></i> গেম হেলথ ও সেন্ট্রাল রিয়েল-টাইম প্লেয়ার অ্যানালিটিক্স</h1>
                <p>এখানে শুধুমাত্র আসল টাকা দিয়ে খেলা প্লেয়ার, ডিপোজিট এবং লাভ প্রদর্শিত হচ্ছে। কোনো ডেমো ডেটা যুক্ত নেই।</p>
            </div>
            <div style="display:flex; gap:10px;">
                <button onclick="location.reload()" class="btn-back" style="cursor:pointer;">
                    <i class="fas fa-sync-alt"></i> রিফ্রেশ করুন
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> অ্যাডমিন ড্যাশবোর্ড
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card gold">
                <div class="stat-card-title">
                    <span>লাইভ রিয়েল প্লেয়ার (অনলাইন)</span>
                    <i class="fas fa-users" style="color:var(--accent-gold);"></i>
                </div>
                <div class="stat-card-value" style="color:var(--accent-gold);">{{ $totalActiveRealUsers }} <span style="font-size:16px;">জন</span></div>
            </div>
            <div class="stat-card blue">
                <div class="stat-card-title">
                    <span>মোট রিয়েল বেট (টার্নওভার)</span>
                    <i class="fas fa-coins" style="color:#60a5fa;"></i>
                </div>
                <div class="stat-card-value">৳ {{ number_format($totalRealBets, 2) }}</div>
            </div>
            <div class="stat-card purple">
                <div class="stat-card-title">
                    <span>মোট রিয়েল পেআউট প্রদান</span>
                    <i class="fas fa-gift" style="color:#c084fc;"></i>
                </div>
                <div class="stat-card-value">৳ {{ number_format($totalRealPayouts, 2) }}</div>
            </div>
            <div class="stat-card green">
                <div class="stat-card-title">
                    <span>এডমিনের নিট প্রফিট</span>
                    <i class="fas fa-shield-halved" style="color:#34d399;"></i>
                </div>
                <div class="stat-card-value" style="color:#34d399;">৳ {{ number_format($totalPlatformProfit, 2) }}</div>
            </div>
        </div>

        <!-- Game Health Table -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-cubes" style="color:var(--accent-cyan);"></i>
                    <span>গেম অনুসারে রিয়েল হেলথ ও ফিন্যান্সিয়াল স্ট্যাটাস</span>
                </div>
                <span style="font-size:12px; color:var(--text-muted); font-weight:700;">
                    <i class="fas fa-shield-check" style="color:var(--accent-green); margin-right:4px;"></i> ১০০% ডেমো আইসোলেটেড লেজার
                </span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>গেমের নাম & আইকন</th>
                            <th style="text-align:center;">বর্তমান অনলাইন প্লেয়ার</th>
                            <th>মোট আসল বেট</th>
                            <th>মোট পেআউট প্রদান</th>
                            <th>হাউজের নিট লাভ</th>
                            <th style="text-align:center;">RTP %</th>
                            <th style="text-align:center;">গেম হেলথ স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $game)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="width:36px; height:36px; border-radius:10px; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.3); display:flex; align-items:center; justify-content:center; color:#818cf8; font-size:15px;">
                                        @if(str_contains($game->game_key, 'boxing'))
                                            <i class="fas fa-fist-raised" style="color:#ef4444;"></i>
                                        @elseif(str_contains($game->game_key, 'aviator'))
                                            <i class="fas fa-plane-departure" style="color:#00f2fe;"></i>
                                        @elseif(str_contains($game->game_key, 'western'))
                                            <i class="fas fa-hat-cowboy" style="color:#f97316;"></i>
                                        @elseif(str_contains($game->game_key, 'olympus'))
                                            <i class="fas fa-bolt" style="color:#fbbf24;"></i>
                                        @elseif(str_contains($game->game_key, 'mines'))
                                            <i class="fas fa-gem" style="color:#a855f7;"></i>
                                        @else
                                            <i class="fas fa-gamepad"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong style="color:#fff; font-size:14px;">{{ $game->name }}</strong>
                                        <div style="font-size:11px; color:var(--text-muted); font-family:'JetBrains Mono',monospace;">{{ $game->game_key }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span style="display:inline-flex; align-items:center; gap:5px; font-family:'JetBrains Mono',monospace; font-weight:800; font-size:13px; color:var(--accent-cyan); background:rgba(0,242,254,0.1); border:1px solid rgba(0,242,254,0.3); padding:4px 10px; border-radius:14px;">
                                    <i class="fas fa-user" style="font-size:10px;"></i> {{ $game->active_real_players_count }} জন
                                </span>
                            </td>
                            <td>
                                <strong style="font-family:'JetBrains Mono',monospace; color:#fff; font-size:13.5px;">৳ {{ number_format($game->total_real_bets, 2) }}</strong>
                            </td>
                            <td>
                                <span style="font-family:'JetBrains Mono',monospace; color:#34d399; font-size:13.5px; font-weight:700;">৳ {{ number_format($game->total_real_payouts, 2) }}</span>
                            </td>
                            <td>
                                <strong style="font-family:'JetBrains Mono',monospace; font-size:14px; color:{{ $game->net_house_profit >= 0 ? '#34d399' : '#f87171' }};">
                                    {{ $game->net_house_profit >= 0 ? '+' : '' }}৳ {{ number_format($game->net_house_profit, 2) }}
                                </strong>
                            </td>
                            <td style="text-align:center;">
                                @php
                                    $rtp = $game->total_real_bets > 0 ? round(($game->total_real_payouts / $game->total_real_bets) * 100, 2) : 96.50;
                                @endphp
                                <span style="font-family:'JetBrains Mono',monospace; font-weight:700; color:var(--accent-gold); font-size:13px;">
                                    {{ number_format($rtp, 2) }}%
                                </span>
                            </td>
                            <td style="text-align:center;">
                                @if($game->health_status === 'healthy')
                                    <span class="badge-health badge-healthy"><i class="fas fa-shield-check"></i> HEALTHY (লাভজনক)</span>
                                @elseif($game->health_status === 'balanced')
                                    <span class="badge-health badge-balanced"><i class="fas fa-scale-balanced"></i> BALANCED (স্থিতিশীল)</span>
                                @else
                                    <span class="badge-health badge-critical"><i class="fas fa-triangle-exclamation"></i> CRITICAL LOSS</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
