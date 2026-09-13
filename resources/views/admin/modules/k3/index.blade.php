@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <!-- Page Header -->
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary); display:flex; align-items:center; gap:10px;">
                <span style="width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg, #10b981, #047857); display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px; box-shadow:0 4px 14px rgba(16,185,129,0.35);">
                    <i class="fa-solid fa-dice"></i>
                </span>
                <span>K3 Lottery (Fast 3) — Game Control Center</span>
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                Manage House Profit RTP engine, 3-Dice probabilities, custom MP3 sound FX, game rules, and live period settlement.
            </p>
        </div>
        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('k3.index') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow:0 4px 18px rgba(16,185,129,0.35);">
                <i class="fa-solid fa-gamepad"></i> Launch K3 Game
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="margin-bottom:20px; padding:14px 18px; border-radius:var(--radius-md); background:rgba(16,185,129,0.12); border:1px solid rgba(16,185,129,0.3); color:#34d399; font-size:13px; font-weight:700; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check" style="font-size:16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. Stats Grid -->
    <div class="stats-grid mb-4">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fa-solid fa-cubes"></i></div>
                <span class="stat-card-change change-up">Settled</span>
            </div>
            <div class="stat-card-val">{{ number_format($stats['total_rounds']) }}</div>
            <div class="stat-card-label">Total Completed Rounds</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fa-solid fa-coins"></i></div>
                <span class="stat-card-change change-up">Real Turnover</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($stats['total_real_bets'], 2) }}</div>
            <div class="stat-card-label">Total Real Bets Volume</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">Payouts</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($stats['total_payout'], 2) }}</div>
            <div class="stat-card-label">Total Player Payouts</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fa-solid fa-vault"></i></div>
                <span class="stat-card-change" style="background:rgba(139,92,246,0.15); color:#c084fc; border:1px solid rgba(139,92,246,0.3);">GGR</span>
            </div>
            <div class="stat-card-val" style="color:{{ $stats['admin_profit'] >= 0 ? '#34d399' : '#f87171' }};">
                ৳ {{ number_format($stats['admin_profit'], 2) }}
            </div>
            <div class="stat-card-label">Net House Profit</div>
        </div>
    </div>

    <!-- 2. Settings & Sound Management 2-Column Grid -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(420px, 1fr)); gap:20px; margin-bottom:24px;">
        
        <!-- Game Algorithm & Rules Settings Panel -->
        <div class="panel" style="background:var(--bg-panel); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); overflow:hidden;">
            <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid var(--border-subtle); background:rgba(255,255,255,0.02);">
                <div class="panel-title" style="font-size:15px; font-weight:800; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-sliders" style="color:var(--accent-green);"></i>
                    <span>House Profit & Game Engine Configuration</span>
                </div>
            </div>
            <div class="panel-body" style="padding:20px;">
                <form action="{{ route('admin.k3.settings') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:block;">
                            Algorithm Control Mode (হাউজ প্রফিট মোড):
                        </label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode === 'house_profit' ? 'selected' : '' }}>
                                House Profit Mode (সবচেয়ে কম পেআউটের ডাইস নির্বাচন — 100% Admin Safe)
                            </option>
                            <option value="fixed_percentage" {{ $settings->control_mode === 'fixed_percentage' ? 'selected' : '' }}>
                                Fixed Win Percentage (নির্দিষ্ট উইন রেট টার্গেট)
                            </option>
                            <option value="random" {{ $settings->control_mode === 'random' ? 'selected' : '' }}>
                                100% Fair Random (সম্পূর্ণ র‍্যান্ডম ন্যাচারাল RNG)
                            </option>
                            <option value="manual" {{ $settings->control_mode === 'manual' ? 'selected' : '' }}>
                                Manual Control (অ্যাডমিন নিচে ম্যানুয়ালি সেট করবেন)
                            </option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:block;">Min Bet (৳):</label>
                            <input type="number" step="0.1" name="min_bet" value="{{ $settings->min_bet }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:block;">Max Bet (৳):</label>
                            <input type="number" step="10" name="max_bet" value="{{ $settings->max_bet }}" class="form-input" required>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:block;">Demo Bet Limit:</label>
                            <input type="number" name="demo_limit" value="{{ $settings->demo_limit }}" class="form-input" required>
                            <small style="color:var(--text-muted); font-size:11px;">Spins before mandatory deposit</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:block;">Target Win Chance (%):</label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-input" required>
                            <small style="color:var(--text-muted); font-size:11px;">For fixed percentage mode</small>
                        </div>
                    </div>

                    <div style="background:rgba(255,255,255,0.02); padding:12px 14px; border-radius:var(--radius-md); border:1px solid var(--border-subtle); margin-bottom:14px; display:flex; flex-direction:column; gap:8px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:12.5px; font-weight:600; color:var(--text-primary);">
                            <input type="checkbox" name="bot_status" value="1" {{ $settings->bot_status ? 'checked' : '' }} style="accent-color:#10b981; width:16px; height:16px;">
                            <span>Enable Live Bot Simulation Bets (লাইভ বট বেট সিমুলেশন)</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:12.5px; font-weight:600; color:var(--text-primary);">
                            <input type="checkbox" name="audio_countdown_enabled" value="1" {{ $settings->audio_countdown_enabled ? 'checked' : '' }} style="accent-color:#10b981; width:16px; height:16px;">
                            <span>Enable 5s Countdown Audio / Voice (৫ সেকেন্ড কাউন্টডাউন সাউন্ড)</span>
                        </label>
                    </div>

                    <!-- Direct Audio URLs inputs -->
                    <div style="background:rgba(16,185,129,0.04); padding:12px 14px; border-radius:var(--radius-md); border:1px solid rgba(16,185,129,0.2); margin-bottom:14px; display:flex; flex-direction:column; gap:10px;">
                        <div style="font-size:11.5px; font-weight:800; color:var(--accent-green); text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fa-solid fa-music"></i> Sound URL Direct Paths
                        </div>
                        <div>
                            <label class="form-label" style="font-size:11px; font-weight:700; color:var(--text-secondary); margin-bottom:4px; display:block;">Countdown Audio URL (.mp3):</label>
                            <input type="text" name="audio_countdown_url" value="{{ $settings->audio_countdown_url }}" class="form-input" placeholder="/assets/audio/k3/countdown.mp3" style="font-size:12px; font-family:'JetBrains Mono',monospace;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:11px; font-weight:700; color:var(--text-secondary); margin-bottom:4px; display:block;">Win Sound FX URL (.mp3):</label>
                            <input type="text" name="audio_win_url" value="{{ $settings->audio_win_url }}" class="form-input" placeholder="/assets/audio/k3/win.mp3" style="font-size:12px; font-family:'JetBrains Mono',monospace;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:11px; font-weight:700; color:var(--text-secondary); margin-bottom:4px; display:block;">Dice Roll / Shaking Audio URL (.mp3):</label>
                            <input type="text" name="audio_roll_url" value="{{ $settings->audio_roll_url }}" class="form-input" placeholder="/assets/audio/k3/dice_roll.mp3" style="font-size:12px; font-family:'JetBrains Mono',monospace;">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" style="font-size:11.5px; font-weight:700; color:var(--text-secondary); margin-bottom:6px; display:flex; align-items:center; justify-content:space-between;">
                            <span><i class="fa-solid fa-book-open" style="color:var(--accent-green); margin-right:4px;"></i> How to Play / Game Rules (কাস্টমারদের নিয়মাবলী):</span>
                            <span style="font-size:10.5px; color:var(--text-muted); font-weight:normal;">Modal dynamically renders this text</span>
                        </label>
                        <textarea name="how_to_play_rules" rows="7" class="form-input" style="font-family:'JetBrains Mono',monospace; font-size:12px; line-height:1.6;" placeholder="Fast 3 / Quick 3 Game Rules...">{{ $settings->how_to_play_rules }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:10px; background:linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fa-solid fa-floppy-disk"></i> Save K3 Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Audio & Sound Effects Upload Management Panel -->
        <div class="panel" style="background:var(--bg-panel); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); overflow:hidden;">
            <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid var(--border-subtle); background:rgba(255,255,255,0.02);">
                <div class="panel-title" style="font-size:15px; font-weight:800; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-file-audio" style="color:var(--accent-cyan);"></i>
                    <span>MP3 Audio & Sound FX File Uploader</span>
                </div>
            </div>
            <div class="panel-body" style="padding:20px;">
                <p style="color:var(--text-secondary); font-size:12.5px; margin-bottom:18px; line-height:1.5;">
                    এখানে আপনি K3 গেমের কাউন্টডাউন, ডাইস রোলিং এবং উইন সাউন্ডের MP3 ফাইল সরাসরি আপলোড করতে পারেন। আপলোড করা অডিও স্বয়ংক্রিয়ভাবে গেমে কানেক্ট হয়ে যাবে।
                </p>

                @php
                    $soundSlots = [
                        'audio_countdown_url' => [
                            'title' => '1. 5s Countdown Audio (কাউন্টডাউন সাউন্ড)',
                            'desc' => 'Plays during last 5-second countdown cards overlay'
                        ],
                        'audio_roll_url' => [
                            'title' => '2. Dice Rolling Audio (ডাইস রোলিং/শেক সাউন্ড)',
                            'desc' => 'Plays at 0s when 3 dice start rolling on settlement'
                        ],
                        'audio_win_url' => [
                            'title' => '3. Big Win Celebration Sound (উইন সাউন্ড)',
                            'desc' => 'Plays when user prediction matches winning dice'
                        ],
                    ];
                @endphp

                @foreach($soundSlots as $fieldKey => $slot)
                    <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:var(--radius-md); padding:14px; margin-bottom:16px;">
                        <div style="font-size:12.5px; font-weight:800; color:var(--text-primary); margin-bottom:2px;">
                            {{ $slot['title'] }}
                        </div>
                        <div style="font-size:11px; color:var(--text-muted); margin-bottom:10px;">
                            {{ $slot['desc'] }}
                        </div>

                        <form action="{{ route('admin.k3.audio') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:8px; align-items:center;">
                            @csrf
                            <input type="hidden" name="audio_type" value="{{ $fieldKey }}">
                            <input type="file" name="audio_file" accept="audio/*" required class="form-input" style="padding:7px 10px; font-size:12px; flex:1;">
                            <button type="submit" class="btn-primary" style="width:auto; padding:8px 14px; font-size:12px; white-space:nowrap;">
                                <i class="fa-solid fa-upload"></i> Upload MP3
                            </button>
                        </form>

                        @if($settings->$fieldKey)
                            <div style="margin-top:10px; padding:8px 12px; background:rgba(16,185,129,0.08); border-radius:8px; border:1px solid rgba(16,185,129,0.2); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                                <div style="font-size:11px; color:#34d399; font-weight:700; display:flex; align-items:center; gap:6px;">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span style="font-family:'JetBrains Mono',monospace;">{{ $settings->$fieldKey }}</span>
                                </div>
                                <audio controls style="height:26px; max-width:180px;">
                                    <source src="{{ $settings->$fieldKey }}" type="audio/mpeg">
                                </audio>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 3. Active / Running K3 Periods Table -->
    <div class="panel mb-4" style="background:var(--bg-panel); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid var(--border-subtle); background:rgba(255,255,255,0.02); display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title" style="font-size:15px; font-weight:800; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-tower-broadcast" style="color:var(--accent-cyan);"></i>
                <span>Active / Running K3 Periods (রানিং পিরিয়ডসমূহ)</span>
            </div>
            <span class="status-badge badge-active" style="font-family:'JetBrains Mono',monospace;">
                {{ $livePeriods->count() }} Live
            </span>
        </div>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Period Number</th>
                        <th>Timeframe</th>
                        <th>Bets Count</th>
                        <th>Real Player Volume</th>
                        <th>Ends At</th>
                        <th style="text-align:right;">Manual Result / Force Settle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($livePeriods as $p)
                        <tr>
                            <td style="font-family:'JetBrains Mono',monospace; font-weight:800; color:var(--text-primary);">
                                {{ $p->period_number }}
                            </td>
                            <td>
                                <span class="status-badge" style="background:rgba(16,185,129,0.12); color:#34d399; border:1px solid rgba(16,185,129,0.28); font-weight:800;">
                                    K3 {{ strtoupper($p->time_type) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight:700; color:var(--text-secondary);">{{ $p->bets_count }} bets</span>
                            </td>
                            <td>
                                <span class="currency-pill">৳ {{ number_format($p->total_real_bets, 2) }}</span>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace; font-size:12px; color:var(--text-muted);">
                                {{ $p->ends_at ? $p->ends_at->format('H:i:s') : '--' }}
                            </td>
                            <td style="text-align:right;">
                                <form action="{{ route('admin.k3.settle', $p->id) }}" method="POST" style="display:inline-flex; align-items:center; gap:6px;">
                                    @csrf
                                    <select name="dice_1" class="form-input" style="width:55px; padding:4px 6px; font-size:11px; height:30px;">
                                        <option value="">D1</option>
                                        @for($d=1;$d<=6;$d++) <option value="{{ $d }}">{{ $d }}</option> @endfor
                                    </select>
                                    <select name="dice_2" class="form-input" style="width:55px; padding:4px 6px; font-size:11px; height:30px;">
                                        <option value="">D2</option>
                                        @for($d=1;$d<=6;$d++) <option value="{{ $d }}">{{ $d }}</option> @endfor
                                    </select>
                                    <select name="dice_3" class="form-input" style="width:55px; padding:4px 6px; font-size:11px; height:30px;">
                                        <option value="">D3</option>
                                        @for($d=1;$d<=6;$d++) <option value="{{ $d }}">{{ $d }}</option> @endfor
                                    </select>
                                    <button type="submit" class="btn-primary" style="width:auto; padding:5px 12px; font-size:11px; height:30px; background:linear-gradient(135deg, #f59e0b, #d97706);">
                                        <i class="fa-solid fa-gavel"></i> Settle
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fa-solid fa-clock"></i>
                                <p>No active betting periods right now.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Settled Rounds History Table -->
    <div class="panel" style="background:var(--bg-panel); border:1px solid var(--border-subtle); border-radius:var(--radius-lg); overflow:hidden;">
        <div class="panel-header" style="padding:16px 20px; border-bottom:1px solid var(--border-subtle); background:rgba(255,255,255,0.02); display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title" style="font-size:15px; font-weight:800; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-clock-rotate-left" style="color:var(--accent-gold);"></i>
                <span>Completed K3 Rounds History (পূর্ববর্তী ফলাফল অডিট লেজার)</span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Period Number</th>
                        <th>Timeframe</th>
                        <th>Winning Dice</th>
                        <th>Sum & Attributes</th>
                        <th>Real Bets</th>
                        <th>Payout</th>
                        <th>House Profit</th>
                        <th>Completed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRounds as $r)
                        <tr>
                            <td style="font-family:'JetBrains Mono',monospace; font-weight:800; color:var(--text-primary);">
                                {{ $r->period_number }}
                            </td>
                            <td>
                                <span class="status-badge" style="background:rgba(255,255,255,0.05); color:var(--text-secondary); border:1px solid var(--border-subtle);">
                                    {{ strtoupper($r->time_type) }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:4px;">
                                    <span style="width:24px; height:24px; border-radius:6px; background:#ef4444; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:11px; box-shadow:0 2px 4px rgba(0,0,0,0.3);">
                                        {{ $r->dice_1 }}
                                    </span>
                                    <span style="width:24px; height:24px; border-radius:6px; background:#ef4444; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:11px; box-shadow:0 2px 4px rgba(0,0,0,0.3);">
                                        {{ $r->dice_2 }}
                                    </span>
                                    <span style="width:24px; height:24px; border-radius:6px; background:#ef4444; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:11px; box-shadow:0 2px 4px rgba(0,0,0,0.3);">
                                        {{ $r->dice_3 }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <strong style="color:var(--text-primary); font-size:13px; font-family:'JetBrains Mono',monospace;">{{ $r->total_sum }}</strong>
                                    <span style="font-size:10px; font-weight:800; padding:2px 6px; border-radius:4px; {{ $r->size === 'big' ? 'background:rgba(245,158,11,0.15); color:#f59e0b;' : 'background:rgba(59,130,246,0.15); color:#3b82f6;' }}">
                                        {{ strtoupper($r->size) }}
                                    </span>
                                    <span style="font-size:10px; font-weight:800; padding:2px 6px; border-radius:4px; {{ $r->parity === 'odd' ? 'background:rgba(239,68,68,0.15); color:#ef4444;' : 'background:rgba(16,185,129,0.15); color:#10b981;' }}">
                                        {{ strtoupper($r->parity) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="currency-pill">৳ {{ number_format($r->total_real_bets, 2) }}</span>
                            </td>
                            <td style="color:#f87171; font-weight:700; font-family:'JetBrains Mono',monospace;">
                                ৳ {{ number_format($r->total_payout, 2) }}
                            </td>
                            <td style="font-weight:800; font-family:'JetBrains Mono',monospace; color:{{ $r->admin_profit >= 0 ? '#34d399' : '#f87171' }};">
                                ৳ {{ number_format($r->admin_profit, 2) }}
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace; font-size:11.5px; color:var(--text-muted);">
                                {{ $r->created_at ? $r->created_at->format('M d, H:i:s') : '--' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <i class="fa-solid fa-file-invoice"></i>
                                <p>No completed rounds history yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentRounds->hasPages())
            <div style="padding:16px 20px; border-top:1px solid var(--border-subtle); display:flex; justify-content:center;">
                {{ $recentRounds->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
