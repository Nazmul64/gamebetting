@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-shield" style="color:#ef4444; margin-right:8px;"></i>
                Roman Slots™ — Game Control & Payout Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                5x3 Reel Slot, 20 Paylines, Wilds, Free Scatters, 70% House Profit / RTP Engine & Spin Ledger.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('roman-slot') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#dc2626,#991b1b); color:#fff; font-weight:700; border:none; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Roman Slots
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
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Spins</div>
            <div style="font-size:22px; font-weight:800; color:#fbbf24; margin-top:6px;">{{ number_format($totalSpins) }}</div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="panel mb-4" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-sliders-h" style="color:#ef4444; margin-right:8px;"></i> Game Parameters & 70% House Profit Setup</h4>
        </div>
        <div class="panel-body" style="padding:20px;">
            <form action="{{ route('admin.romanslots.settings') }}" method="POST">
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
                    <button type="submit" class="btn-primary" style="padding:10px 24px; font-size:14px; background:linear-gradient(135deg,#dc2626,#991b1b); color:#fff; font-weight:800; border:none; border-radius:8px; cursor:pointer;">
                        <i class="fas fa-save" style="margin-right:6px;"></i> Save Roman Slots Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Spins Ledger -->
    <div class="panel" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-history" style="color:#38bdf8; margin-right:8px;"></i> Recent Slot Spins & Ledger</h4>
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
                        <td colspan="7" style="padding:24px; text-align:center; color:#64748b;">No recent spins recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
