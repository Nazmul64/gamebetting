@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-gem" style="color:#a855f7; margin-right:8px;"></i>
                Crystal™ — Cascading Slot Control Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                7x7 Cascading Gem Slot: Cluster Wins, Wild Crown Avalanche, 70% House Profit / RTP Engine & Spin Ledger.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('crystal') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#9333ea,#7e22ce); color:#fff; font-weight:700; border:none; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Crystal
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
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Cascades</div>
            <div style="font-size:22px; font-weight:800; color:#fbbf24; margin-top:6px;">{{ number_format($totalSpins) }}</div>
        </div>
    </div>

    <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
    <div class="panel mb-4" style="background:#0f172a; border:1px solid #a855f7; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(168,85,247,0.12);">
        <div class="panel-header" style="padding:16px 20px; background:linear-gradient(90deg, #581c87 0%, #0f172a 100%); border-bottom:1px solid #a855f7; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16.5px; font-weight:800; color:#c084fc;">
                <i class="fas fa-book-open" style="margin-right:8px; color:#e9d5ff;"></i>
                Crystal™ — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
            </h4>
            <span style="background:rgba(168,85,247,0.2); color:#e9d5ff; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                <i class="fas fa-shield-alt"></i> ১০০% সার্ভার কন্ট্রোলড
            </span>
        </div>
        <div class="panel-body" style="padding:22px; color:#e2e8f0; font-size:13.8px; line-height:1.75;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                <!-- বক্স ১: গেমটি কিভাবে কাজ করে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#c084fc; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-gem"></i> ১. গেমটি কিভাবে কাজ করে (Game Mechanics)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        ৭x৭ গ্রিডের ক্রিস্টাল ক্লাস্টার স্লট গেম:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>৫ বা ততোধিক একই রঙের ক্রিস্টাল পাশাপাশি মিললে ক্লাস্টার পেআউট পাওয়া যায়।</li>
                        <li><strong>Avalanche Cascade:</strong> বিজয়ী ক্রিস্টালগুলো ভেঙে নতুন ক্রিস্টাল ড্রপ করে, ফলে এক ক্লিকেই একাধিক জয় সম্ভব।</li>
                    </ul>
                </div>

                <!-- বক্স ২: এডমিন কিভাবে লাভ করবে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#34d399; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল (House Profit Engine)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        এডমিন লাভ নিয়ন্ত্রণ ইঞ্জিন দিয়ে ক্লাস্টারের ড্রপ রেট সরাসরি সেট করা যায়:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>House Profit Target (%):</strong> ডিফল্ট ৭০% এডমিন প্রফিট মার্জিনে সেট করা থাকে।</li>
                        <li><strong>Player Win Chance (%):</strong> আপনি যদি ৩০% দেন, তবে প্লেয়ার ৩০% স্পিনে পেআউট পাবে, বাকি ৭০% স্পিনে এডমিন ফান্ড লাভজনক থাকবে।</li>
                    </ul>
                </div>

                <!-- বক্স ৩: ইউজাররা কিভাবে প্রফিট পায় -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#fbbf24; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজাররা কিভাবে প্রফিট ও পেআউট পায়
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        বড় ক্লাস্টার (১০+ জেমস) মিললে বড় মাল্টিপ্লায়ার পেআউট সরাসরি ইউজারের ব্যালেন্সে যুক্ত হয়।
                    </p>
                </div>

                <!-- বক্স ৪: এডমিন সেটিংস পরিবর্তন নির্দেশিকা -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#38bdf8; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cogs"></i> ৪. সেটিংস পরিবর্তনের নির্দেশিকা
                    </div>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>এডমিনের সর্বোচ্চ সেফটি ও আয়ের জন্য <strong>House Profit Engine</strong> ব্যবহার করুন।</li>
                        <li>পরিবর্তন শেষে <strong>"Save Settings"</strong> বাটনে চাপ দিন।</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="panel mb-4" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-sliders-h" style="color:#a855f7; margin-right:8px;"></i> Game Parameters & 70% House Profit Setup</h4>
        </div>
        <div class="panel-body" style="padding:20px;">
            <form action="{{ route('admin.crystal.settings') }}" method="POST">
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
                    <button type="submit" class="btn-primary" style="padding:10px 24px; font-size:14px; background:linear-gradient(135deg,#9333ea,#7e22ce); color:#fff; font-weight:800; border:none; border-radius:8px; cursor:pointer;">
                        <i class="fas fa-save" style="margin-right:6px;"></i> Save Crystal Slot Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Spins Ledger -->
    <div class="panel" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-history" style="color:#38bdf8; margin-right:8px;"></i> Recent Cascading Spins & Ledger</h4>
        </div>
        <div class="panel-body" style="padding:0; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #1e293b; background:#0b1120; color:#94a3b8;">
                        <th style="padding:12px 16px;">ID</th>
                        <th style="padding:12px 16px;">Player</th>
                        <th style="padding:12px 16px;">Bet (৳)</th>
                        <th style="padding:12px 16px;">Payout (৳)</th>
                        <th style="padding:12px 16px;">Admin Profit (৳)</th>
                        <th style="padding:12px 16px;">Status</th>
                        <th style="padding:12px 16px;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $spin)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05); color:#cbd5e1;">
                        <td style="padding:12px 16px; font-weight:700;">#{{ $spin->id }}</td>
                        <td style="padding:12px 16px;">{{ $spin->user ? $spin->user->name : 'Demo Guest' }}</td>
                        <td style="padding:12px 16px; font-weight:700; color:#38bdf8;">৳{{ number_format($spin->bet_amount, 2) }}</td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $spin->win_amount > 0 ? '#4ade80' : '#94a3b8' }};">
                            ৳{{ number_format($spin->win_amount, 2) }}
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:{{ $spin->admin_profit > 0 ? '#4ade80' : '#f87171' }};">
                            ৳{{ number_format($spin->admin_profit, 2) }}
                        </td>
                        <td style="padding:12px 16px;">
                            <span style="font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700; background:{{ $spin->status === 'won' ? 'rgba(74,222,128,0.15)' : 'rgba(248,113,113,0.15)' }}; color:{{ $spin->status === 'won' ? '#4ade80' : '#f87171' }};">
                                {{ strtoupper($spin->status) }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; color:#64748b; font-size:12px;">{{ $spin->created_at->format('M d, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:24px; text-align:center; color:#64748b;">No recent cascades recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
