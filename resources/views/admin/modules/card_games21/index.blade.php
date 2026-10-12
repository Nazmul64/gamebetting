@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-cards" style="color:#38bdf8; margin-right:8px;"></i>
                Card Games 21™ — Game Control & Multiplier Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                1xGames 21 (Blackjack Variant): Golden 21 / 2 Aces Instant Win, Hit/Stand Dealer Engine, 70% House Profit Target & Live Ledger.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('card-games-21') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#0284c7,#0369a1); color:#fff; font-weight:700; border:none; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Card Games 21
            </a>
        </div>
    </div>

    <!-- Analytics Stats -->
    <div class="stats-grid mb-4" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Bets Placed</div>
            <div style="font-size:22px; font-weight:800; color:#38bdf8; margin-top:6px;">৳{{ number_format($totalTurnover, 2) }}</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Payouts</div>
            <div style="font-size:22px; font-weight:800; color:#f87171; margin-top:6px;">৳{{ number_format($totalPayout, 2) }}</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Net House Profit</div>
            <div style="font-size:22px; font-weight:800; color:#4ade80; margin-top:6px;">৳{{ number_format($netProfit, 2) }} ({{ $profitMargin }}%)</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Games Played</div>
            <div style="font-size:22px; font-weight:800; color:#fbbf24; margin-top:6px;">{{ number_format($totalBets) }}</div>
        </div>
    </div>

    <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
    <div class="panel mb-4" style="background:#0f172a; border:1px solid #0284c7; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(2,132,199,0.12);">
        <div class="panel-header" style="padding:16px 20px; background:linear-gradient(90deg, #075985 0%, #0f172a 100%); border-bottom:1px solid #0284c7; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16.5px; font-weight:800; color:#38bdf8;">
                <i class="fas fa-book-open" style="margin-right:8px; color:#7dd3fc;"></i>
                Card Games 21™ — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
            </h4>
            <span style="background:rgba(56,189,248,0.2); color:#7dd3fc; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                <i class="fas fa-shield-alt"></i> ১০০% সার্ভার কন্ট্রোলড
            </span>
        </div>
        <div class="panel-body" style="padding:22px; color:#e2e8f0; font-size:13.8px; line-height:1.75;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                <!-- বক্স ১: গেমটি কিভাবে কাজ করে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#38bdf8; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cards"></i> ১. গেমটি কিভাবে কাজ করে (Game Mechanics)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        এটি ১xGames এর জনপ্রিয় Blackjack ভ্যারিয়েন্ট: ডিলার বনাম প্লেয়ারের ২১ পয়েন্টের কার্ড গেম:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>প্লেয়ার ও ডিলারকে কার্ড ডিল করা হয়। লক্ষ্য হলো ২১ এর কাছাকাছি থাকা, কিন্তু ২১ পার না হওয়া।</li>
                        <li><strong>Hit:</strong> নতুন কার্ড নেওয়া। <strong>Stand:</strong> বর্তমান পয়েন্ট নিয়ে খেলা শেষ করা।</li>
                        <li><strong>২ Aces বা প্রথম দুই কার্ডে ২১:</strong> ইনস্ট্যান্ট ২ গুণ বা স্পেশাল গোল্ডেন পেআউট।</li>
                        <li>২১ এর বেশি হলে প্লেয়ার Bust (হারবে)। ডিলারের চেয়ে বেশি পয়েন্ট হলে প্লেয়ার জিতবে।</li>
                    </ul>
                </div>

                <!-- বক্স ২: এডমিন কিভাবে লাভ করবে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#34d399; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল (House Profit Engine)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        ডিলারের ডিল করা কার্ড এবং প্লেয়ারের জেতার সুযোগ সরাসরি এডমিন সেটিংস দ্বারা নিয়ন্ত্রিত:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>House Profit Target (%):</strong> ডিফল্ট ৭০% এডমিন প্রফিট টার্গেটে সেট করা। অর্থাৎ গড়ে ৭০% গেমে ডিলার জিতবে এবং এডমিনের ফান্ড লাভজনক থাকবে।</li>
                        <li><strong>ডিলারের অটো ড্র হ্যান্ডেল:</strong> প্লেয়ার যখন ভালো কার্ড পায়, ডিলার ইঞ্জিন স্বয়ংক্রিয়ভাবে এমন কার্ড তোলে যা ২১ এর কাছাকাছি বা প্লেয়ারের চেয়ে বেশি হয়ে এডমিনকে বিজয়ী করে।</li>
                    </ul>
                </div>

                <!-- বক্স ৩: ইউজাররা কিভাবে প্রফিট পায় -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#fbbf24; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজাররা কিভাবে প্রফিট ও পেআউট পায়
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        ইউজাররা সঠিক সিদ্ধান্ত নিয়ে জিতলে তাদের লাভ পাওয়ার নিয়ম:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>সাধারণ জয়:</strong> ১x প্রফিট (যেমন: ১০০ টাকা বেট করলে ২০০ টাকা ফেরত, নিট লাভ ১০০ টাকা)।</li>
                        <li><strong>Golden 21 / 2 Aces:</strong> ২x পেআউট সরাসরি ইউজারের ওয়ালেটে ক্রেডিট হয়।</li>
                        <li>Tie (ড্র) হলে বেটের টাকা রিফান্ড হিসেবে স্বয়ংক্রিয়ভাবে ইউজারের ব্যালেন্সে ফেরত আসে।</li>
                    </ul>
                </div>

                <!-- বক্স ৪: এডমিন সেটিংস পরিবর্তন নির্দেশিকা -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#a855f7; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cogs"></i> ৪. সেটিংস পরিবর্তনের দ্রুত নির্দেশিকা
                    </div>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>এডমিন প্রফিট বাড়াতে <strong>Player Win Chance (%)</strong> কম রাখুন (যেমন: ২৫% থেকে ৩৫%)।</li>
                        <li>বড় বাজি থেকে হাউস ফান্ড নিরাপদ রাখতে <strong>Maximum Bet Limit</strong> সেট করুন।</li>
                        <li>ডেমো ব্যালেন্স দিয়ে নতুন প্লেয়ারদের আকৃষ্ট করার জন্য ডেমো উইন রেট একটু বাড়িয়ে রাখতে পারেন।</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="panel mb-4" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-sliders-h" style="color:#38bdf8; margin-right:8px;"></i> Game Parameters & 70% House Profit Setup</h4>
        </div>
        <div class="panel-body" style="padding:20px;">
            <form action="{{ route('admin.cardgames21.settings') }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">
                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">RTP / House Win Rate Mode</label>
                        <select name="control_mode" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                            <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>House Profit Engine (Target 70% Profit)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage Rate</option>
                            <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>100% Fair Random RNG</option>
                        </select>
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Player Win Chance (%) [Default: 30%]</label>
                        <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Admin Profit Target (%) [Default: 70%]</label>
                        <input type="number" name="admin_profit_percentage" value="{{ $settings->admin_profit_percentage ?? 70 }}" min="0" max="100" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Win Multiplier (x)</label>
                        <input type="number" step="0.1" name="win_multiplier" value="{{ $settings->win_multiplier }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Minimum Bet (৳)</label>
                        <input type="number" step="0.1" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Maximum Bet (৳)</label>
                        <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Demo Default Balance (৳)</label>
                        <input type="number" step="1" name="demo_default_balance" value="{{ $settings->demo_default_balance }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>
                </div>

                <div style="margin-top:20px; display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-primary" style="padding:10px 24px; font-size:14px; background:linear-gradient(135deg,#0284c7,#0369a1); color:#fff; font-weight:800; border:none; border-radius:8px; cursor:pointer;">
                        <i class="fas fa-save" style="margin-right:6px;"></i> Save Card Games 21 Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Bets Ledger -->
    <div class="panel" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-history" style="color:#38bdf8; margin-right:8px;"></i> Recent 21 Games & Ledger</h4>
        </div>
        <div class="panel-body" style="padding:0; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #1e293b; background:#0b1120; color:#94a3b8;">
                        <th style="padding:12px 16px;">ID</th>
                        <th style="padding:12px 16px;">Player</th>
                        <th style="padding:12px 16px;">Bet (৳)</th>
                        <th style="padding:12px 16px;">Player Cards (Score)</th>
                        <th style="padding:12px 16px;">Dealer Cards (Score)</th>
                        <th style="padding:12px 16px;">Payout (৳)</th>
                        <th style="padding:12px 16px;">Admin Profit (৳)</th>
                        <th style="padding:12px 16px;">Status</th>
                        <th style="padding:12px 16px;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBets as $bet)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05); color:#cbd5e1;">
                        <td style="padding:12px 16px; font-weight:700;">#{{ $bet->id }}</td>
                        <td style="padding:12px 16px;">{{ $bet->user ? $bet->user->name : 'Demo Guest' }}</td>
                        <td style="padding:12px 16px; font-weight:700; color:#38bdf8;">৳{{ number_format($bet->bet_amount, 2) }}</td>
                        <td style="padding:12px 16px;">
                            <span style="background:rgba(255,255,255,0.08); padding:2px 6px; border-radius:4px; font-family:monospace;">{{ implode(' ', (array)$bet->player_cards) }}</span>
                            <strong style="color:#fbbf24; margin-left:4px;">({{ $bet->player_score }})</strong>
                        </td>
                        <td style="padding:12px 16px;">
                            <span style="background:rgba(255,255,255,0.08); padding:2px 6px; border-radius:4px; font-family:monospace;">{{ implode(' ', (array)$bet->dealer_cards) }}</span>
                            <strong style="color:#f87171; margin-left:4px;">({{ $bet->dealer_score }})</strong>
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $bet->win_amount > 0 ? '#4ade80' : '#94a3b8' }};">
                            ৳{{ number_format($bet->win_amount, 2) }}
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $bet->admin_profit > 0 ? '#4ade80' : '#f87171' }};">
                            ৳{{ number_format($bet->admin_profit, 2) }}
                        </td>
                        <td style="padding:12px 16px;">
                            <span style="font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700; background:{{ $bet->status === 'won' ? 'rgba(74,222,128,0.15)' : 'rgba(248,113,113,0.15)' }}; color:{{ $bet->status === 'won' ? '#4ade80' : '#f87171' }};">
                                {{ strtoupper($bet->status) }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; color:#64748b; font-size:12px;">{{ $bet->created_at->format('M d, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="padding:24px; text-align:center; color:#64748b;">No recent 21 games recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
