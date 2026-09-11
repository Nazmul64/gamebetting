@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-boxing-glove" style="color:#ef4444; margin-right:8px;"></i>
                Boxing King (Ring Champion) — Game Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                Manage RTP engine algorithms, Fire Burst cell animations, sound FX, and live player spin audit ledger.
            </p>
        </div>
        <div>
            <a href="{{ route('boxing-king') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    <!-- Analytics Widget -->
    <div class="stats-grid mb-4">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                <span class="stat-card-change change-up">Real Spins</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalBets, 2) }}</div>
            <div class="stat-card-label">Total Real Bets Volume</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-trophy"></i></div>
                <span class="stat-card-change" style="background:rgba(139,92,246,0.15); color:#c084fc; border:1px solid rgba(139,92,246,0.3);">Payouts</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalPayout, 2) }}</div>
            <div class="stat-card-label">Total Player Payouts</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-sack-dollar"></i></div>
                <span class="stat-card-change change-up">House GGR</span>
            </div>
            <div class="stat-card-val" style="color:{{ $adminProfit >= 0 ? '#34d399' : '#f87171' }};">৳ {{ number_format($adminProfit, 2) }}</div>
            <div class="stat-card-label">Net Admin House Profit</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-fire"></i></div>
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">{{ $settings->win_chance_percentage }}% Win Rate</span>
            </div>
            <div class="stat-card-val">{{ strtoupper(str_replace('_', ' ', $settings->control_mode)) }}</div>
            <div class="stat-card-label">Algorithm Mode</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:20px; margin-bottom:24px;">
        <!-- Game Settings Form -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> Game Algorithm & Win/Loss Control</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.boxing.settings') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Algorithm Control Mode:</label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (Admin 100% Safe & Profitable)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (Target Player Win %)</option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (Natural RNG)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">User Win Chance Target (%):</label>
                        <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-input" required>
                        <small style="color:var(--text-muted); font-size:11.5px;">Percentage chance that a spin hits a 3+ combo match with Fire-Burst animation.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Demo Trial Limit (Spins before mandatory deposit):</label>
                        <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" min="1" max="50" class="form-input" required>
                        <small style="color:var(--text-muted); font-size:11.5px;">Users get locked after this number of demo spins, opening the Cashier Deposit modal.</small>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Minimum Bet (৳):</label>
                            <input type="number" name="min_bet" value="{{ $settings->min_bet }}" step="0.5" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maximum Bet (৳):</label>
                            <input type="number" name="max_bet" value="{{ $settings->max_bet }}" step="1" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:10px;">
                        <i class="fas fa-save"></i> Save Boxing King Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Audio & Sound Effects Management -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-music" style="color:var(--accent-cyan);"></i> Sound & Audio FX Management</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_music' => 'Background Music (Arena Ambient)',
                        'spin_sound' => 'Reel Spin Sound FX',
                        'win_sound' => 'Big Win / Knockout Sound',
                        'fire_burn_sound' => 'Fire-Burst & Combo Flame FX'
                    ];
                @endphp
                @foreach($audios as $key => $label)
                    <form action="{{ route('admin.boxing.audio') }}" method="POST" enctype="multipart/form-data" style="margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid var(--border-subtle);">
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
                                <span>Loaded: {{ $settings->$key }}</span>
                            </div>
                        @endif
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Spins Table -->
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-clock-rotate-left" style="color:var(--accent-indigo);"></i> Recent Spins & Audit History</div>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PLAYER</th>
                        <th>MODE</th>
                        <th>BET AMOUNT</th>
                        <th>WIN AMOUNT</th>
                        <th>ADMIN PROFIT</th>
                        <th>OUTCOME</th>
                        <th>TIMESTAMP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSpins as $s)
                    <tr>
                        <td><strong style="font-family:'JetBrains Mono',monospace; color:var(--text-primary);">#{{ $s->id }}</strong></td>
                        <td>
                            @if($s->user)
                                <div style="display:flex; flex-direction:column;">
                                    <span style="font-weight:600; color:var(--text-primary);">{{ $s->user->name }}</span>
                                    <span style="font-size:11px; color:var(--text-muted);">{{ $s->user->email }}</span>
                                </div>
                            @else
                                <span style="color:var(--text-muted);">Guest / Demo</span>
                            @endif
                        </td>
                        <td>
                            @if($s->is_demo)
                                <span class="status-badge" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">DEMO</span>
                            @else
                                <span class="status-badge" style="background:rgba(16,185,129,0.15); color:#10b981; border:1px solid rgba(16,185,129,0.3);">REAL</span>
                            @endif
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size:12px;">৳ {{ number_format($s->bet_amount, 2) }}</td>
                        <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:{{ $s->win_amount > 0 ? '#34d399' : 'var(--text-muted)' }};">
                            ৳ {{ number_format($s->win_amount, 2) }}
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:{{ $s->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                            ৳ {{ number_format($s->admin_profit, 2) }}
                        </td>
                        <td>
                            @if($s->is_win)
                                <span class="status-badge badge-active"><i class="fas fa-fire mr-1"></i> WIN</span>
                            @else
                                <span class="status-badge" style="background:rgba(239,68,68,0.1); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">LOSS</span>
                            @endif
                        </td>
                        <td style="color:var(--text-muted); font-size:11.5px;">{{ $s->created_at->format('d M, h:i:s A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-boxing-glove"></i>
                                <p>No Boxing King spins recorded yet.</p>
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
