@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-dice" style="color:#10b981; margin-right:8px;"></i>
                Under and Over 7 — Game Control & Multiplier Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                1xBet Official Dice Game: Over (x2.3), Equal 7 (x5.8), Under (x2.3) Multipliers, Win Rate Control & Ledger.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('under-and-over-7') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#10b981,#059669); border:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-gamepad"></i> Launch Under & Over 7
            </a>
        </div>
    </div>

    <!-- Analytics Stats -->
    <div class="stats-grid mb-4" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Bets Placed</div>
            <div style="font-size:22px; font-weight:800; color:#38bdf8; margin-top:6px;">€{{ number_format($totalRealBets, 2) }}</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Real Payouts</div>
            <div style="font-size:22px; font-weight:800; color:#f87171; margin-top:6px;">€{{ number_format($totalRealPayout, 2) }}</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Net House Profit</div>
            <div style="font-size:22px; font-weight:800; color:#4ade80; margin-top:6px;">€{{ number_format($netProfit, 2) }}</div>
        </div>
        <div class="stat-card" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; padding:18px;">
            <div style="color:#94a3b8; font-size:13px; font-weight:600;">Total Game Rolls</div>
            <div style="font-size:22px; font-weight:800; color:#fbbf24; margin-top:6px;">{{ number_format($totalPlays) }}</div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="panel mb-4" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-sliders-h" style="color:#10b981; margin-right:8px;"></i> Game Parameters & Multipliers</h4>
        </div>
        <div class="panel-body" style="padding:20px;">
            <form action="{{ route('admin.underover.settings') }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">
                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Game Display Name</label>
                        <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">RTP / House Win Rate Mode</label>
                        <select name="control_mode" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                            <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>House Profit Engine (Targeted Win %)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage Rate</option>
                            <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>100% Fair Random RNG</option>
                        </select>
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Player Win Chance (%)</label>
                        <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Over Multiplier (8-12)</label>
                        <input type="number" step="0.1" name="over_multiplier" value="{{ $settings->over_multiplier }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Equal Multiplier (Exact 7)</label>
                        <input type="number" step="0.1" name="equal_multiplier" value="{{ $settings->equal_multiplier }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Under Multiplier (2-6)</label>
                        <input type="number" step="0.1" name="under_multiplier" value="{{ $settings->under_multiplier }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Minimum Bet (€)</label>
                        <input type="number" step="0.1" name="min_bet" value="{{ $settings->min_bet }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Maximum Bet (€)</label>
                        <input type="number" step="1" name="max_bet" value="{{ $settings->max_bet }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>

                    <div>
                        <label style="color:#94a3b8; font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Demo Default Balance (€)</label>
                        <input type="number" step="1" name="demo_default_balance" value="{{ $settings->demo_default_balance }}" class="form-control" style="width:100%; background:#0b1120; border:1px solid #334155; color:#fff; padding:10px 14px; border-radius:8px;">
                    </div>
                </div>

                <div style="margin-top:20px; display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-success" style="background:#10b981; border:none; padding:10px 24px; font-weight:700; border-radius:8px; cursor:pointer;">
                        <i class="fas fa-save" style="margin-right:6px;"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Bets Table -->
    <div class="panel" style="background:#131d2e; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid #1e293b; background:#0f172a;">
            <h4 style="margin:0; font-size:16px; color:#fff;"><i class="fas fa-list" style="color:#38bdf8; margin-right:8px;"></i> Recent Dice Bets Log</h4>
        </div>
        <div class="panel-body p-0" style="overflow-x:auto;">
            <table class="table" style="width:100%; margin:0; border-collapse:collapse; font-size:13.5px; color:#cbd5e1;">
                <thead>
                    <tr style="background:#0b1120; border-bottom:1px solid #1e293b; text-align:left;">
                        <th style="padding:12px 16px;">User</th>
                        <th style="padding:12px 16px;">Choice</th>
                        <th style="padding:12px 16px;">Amount</th>
                        <th style="padding:12px 16px;">Dice (D1 + D2 = Sum)</th>
                        <th style="padding:12px 16px;">Multiplier</th>
                        <th style="padding:12px 16px;">Win Amount</th>
                        <th style="padding:12px 16px;">Status</th>
                        <th style="padding:12px 16px;">Mode</th>
                        <th style="padding:12px 16px;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBets as $bet)
                        <tr style="border-bottom:1px solid #1e293b;">
                            <td style="padding:12px 16px; font-weight:600; color:#fff;">{{ $bet->user->name ?? ($bet->is_demo ? 'Demo Player' : 'Guest') }}</td>
                            <td style="padding:12px 16px;">
                                <span style="text-transform:uppercase; font-weight:700; color:{{ $bet->bet_choice === 'equal' ? '#fbbf24' : ($bet->bet_choice === 'over' ? '#38bdf8' : '#a855f7') }};">
                                    {{ $bet->bet_choice }}
                                </span>
                            </td>
                            <td style="padding:12px 16px; font-weight:700;">€{{ number_format($bet->bet_amount, 2) }}</td>
                            <td style="padding:12px 16px;">
                                <span style="background:#1e293b; padding:3px 8px; border-radius:6px; font-family:'Roboto Mono',monospace; font-weight:700;">
                                    [{{ $bet->die1 }}] + [{{ $bet->die2 }}] = {{ $bet->sum }}
                                </span>
                            </td>
                            <td style="padding:12px 16px; color:#fbbf24; font-weight:700;">x{{ number_format($bet->multiplier, 1) }}</td>
                            <td style="padding:12px 16px; font-weight:700; color:{{ $bet->win_amount > 0 ? '#4ade80' : '#94a3b8' }};">
                                €{{ number_format($bet->win_amount, 2) }}
                            </td>
                            <td style="padding:12px 16px;">
                                <span style="padding:3px 8px; border-radius:4px; font-size:11.5px; font-weight:700; text-transform:uppercase; background:{{ $bet->status === 'won' ? 'rgba(34,197,94,0.15)' : 'rgba(239,68,68,0.15)' }}; color:{{ $bet->status === 'won' ? '#4ade80' : '#f87171' }};">
                                    {{ $bet->status }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;">
                                <span style="font-size:11px; padding:2px 6px; border-radius:3px; background:{{ $bet->is_demo ? '#334155' : '#047857' }}; color:#fff;">
                                    {{ $bet->is_demo ? 'DEMO' : 'REAL' }}
                                </span>
                            </td>
                            <td style="padding:12px 16px; color:#94a3b8; font-size:12px;">{{ $bet->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="padding:30px; text-align:center; color:#64748b;">No bets recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
