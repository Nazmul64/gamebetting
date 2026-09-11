@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-hat-cowboy" style="color:var(--accent-gold); margin-right:8px;"></i>
                Western Vault — Game Engine Control
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                Manage game algorithms, House Profit vs Custom Win %, dynamic bot triggers, sound effects, and transaction audits.
            </p>
        </div>
        <div>
            <a href="{{ route('western') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    <!-- Analytics Widget -->
    <div class="stats-grid mb-4">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                <span class="stat-card-change change-up">Live</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalCollected, 2) }}</div>
            <div class="stat-card-label">Total Real Bets Volume</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-money-bill-transfer"></i></div>
                <span class="stat-card-change" style="background:rgba(139,92,246,0.15); color:#c084fc; border:1px solid rgba(139,92,246,0.3);">Payouts</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalPaidOut, 2) }}</div>
            <div class="stat-card-label">Total Player Payouts</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-sack-dollar"></i></div>
                <span class="stat-card-change change-up">House GGR</span>
            </div>
            <div class="stat-card-val" style="color:{{ $netProfit >= 0 ? '#34d399' : '#f87171' }};">৳ {{ number_format($netProfit, 2) }}</div>
            <div class="stat-card-label">Net Admin House Profit</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-robot"></i></div>
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">{{ $settings->bot_status ? 'Active' : 'Disabled' }}</span>
            </div>
            <div class="stat-card-val">{{ $settings->control_mode === 'house_profit' ? 'House Edge' : ($settings->control_mode === 'fixed_percentage' ? $settings->win_chance_percentage.'%' : 'Random') }}</div>
            <div class="stat-card-label">Active Algorithm</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:20px; margin-bottom:24px;">
        <!-- Game Settings Form -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> Algorithm & Win/Loss Control</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.western.settings') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Algorithm Control Mode:</label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (Least Real Money Side Wins - Guaranteed Admin Profit)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Custom Win Percentage (Based on Player Win %)</option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (Natural RTP)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Player Win Chance Target (%):</label>
                        <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-input" required>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Dynamic Bot Status:</label>
                            <select name="bot_status" class="form-input" style="cursor:pointer;">
                                <option value="1" {{ $settings->bot_status ? 'selected' : '' }}>Active (Auto Fake Bets)</option>
                                <option value="0" {{ !$settings->bot_status ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bot Trigger Under (Players):</label>
                            <input type="number" name="bot_trigger_player_count" value="{{ $settings->bot_trigger_player_count }}" min="1" max="100" class="form-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Minimum Bet (৳):</label>
                            <input type="number" name="min_bet" value="{{ $settings->min_bet }}" step="1" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maximum Bet (৳):</label>
                            <input type="number" name="max_bet" value="{{ $settings->max_bet }}" step="1" class="form-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Round Duration (seconds):</label>
                            <input type="number" name="round_duration" value="{{ $settings->round_duration }}" min="10" max="120" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">House Edge %:</label>
                            <input type="number" name="house_edge_percent" value="{{ $settings->house_edge_percent }}" step="0.1" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:10px;">
                        <i class="fas fa-save"></i> Save Western Vault Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Audio & Media Settings -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-music" style="color:var(--accent-cyan);"></i> Sound & Audio FX Management</div>
            </div>
            <div class="panel-body">
                @foreach(['bg_music' => 'Background Music (Atmosphere)', 'spin_sound' => 'Reel Spin & Vault Sound', 'win_sound' => 'Victory & Payout Sound'] as $key => $label)
                    <form action="{{ route('admin.western.audio') }}" method="POST" enctype="multipart/form-data" style="margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid var(--border-subtle);">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <label class="form-label" style="font-size:12px; font-weight:700; color:var(--text-primary); margin-bottom:6px;">{{ $label }} (.mp3, .wav):</label>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <input type="file" name="audio_file" class="form-input" accept="audio/*" required style="padding:8px 12px;">
                            <button type="submit" class="btn-primary" style="width:auto; padding:10px 18px; font-size:12px;">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </div>
                        @if($settings->$key)
                            <div style="margin-top:6px; font-size:11px; color:#34d399; display:flex; align-items:center; gap:6px;">
                                <i class="fas fa-circle-check"></i> 
                                <span>Attached: {{ $settings->$key }}</span>
                            </div>
                        @endif
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Rounds Table -->
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-clock-rotate-left" style="color:var(--accent-indigo);"></i> Recent Game Rounds & Audit History</div>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ROUND ID</th>
                        <th>WINNING SIDE</th>
                        <th>REAL BETS (A / B)</th>
                        <th>BOT BETS (A / B)</th>
                        <th>TOTAL PAYOUT</th>
                        <th>NET ADMIN PROFIT</th>
                        <th>STATUS</th>
                        <th>TIMESTAMP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRounds as $r)
                    <tr>
                        <td><strong style="font-family:'JetBrains Mono',monospace; color:var(--text-primary);">{{ $r->round_id }}</strong></td>
                        <td>
                            @if($r->winning_side === 'side_a')
                                <span class="status-badge" style="background:rgba(6,182,212,0.15); color:var(--accent-cyan); border:1px solid rgba(6,182,212,0.3);">SIDE A (VAULT)</span>
                            @elseif($r->winning_side === 'side_b')
                                <span class="status-badge" style="background:rgba(249,115,22,0.15); color:var(--accent-orange); border:1px solid rgba(249,115,22,0.3);">SIDE B (OUTLAW)</span>
                            @else
                                <span style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size:12px;">
                            ৳ {{ number_format($r->real_bets_total_a, 2) }} / ৳ {{ number_format($r->real_bets_total_b, 2) }}
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size:12px; color:var(--text-muted);">
                            ৳ {{ number_format($r->bot_bets_total_a, 2) }} / ৳ {{ number_format($r->bot_bets_total_b, 2) }}
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:var(--accent-purple);">
                            ৳ {{ number_format($r->total_payout, 2) }}
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:{{ $r->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                            ৳ {{ number_format($r->admin_profit, 2) }}
                        </td>
                        <td>
                            <span class="status-badge {{ $r->status === 'completed' ? 'badge-active' : '' }}" style="{{ $r->status !== 'completed' ? 'background:rgba(251,191,36,0.15); color:#fbbf24; border:1px solid rgba(251,191,36,0.3);' : '' }}">
                                {{ strtoupper($r->status) }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted); font-size:11.5px;">{{ $r->created_at->format('d M, h:i:s A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-hat-cowboy"></i>
                                <p>No Western Vault rounds recorded yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
