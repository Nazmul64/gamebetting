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

    <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
    <div class="panel mb-4" style="background:#0f172a; border:1px solid #f59e0b; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(245,158,11,0.12);">
        <div class="panel-header" style="padding:16px 20px; background:linear-gradient(90deg, #78350f 0%, #0f172a 100%); border-bottom:1px solid #f59e0b; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16.5px; font-weight:800; color:#fbbf24;">
                <i class="fas fa-book-open" style="margin-right:8px; color:#fde68a;"></i>
                Western Vault — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
            </h4>
            <span style="background:rgba(251,191,36,0.2); color:#fde68a; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                <i class="fas fa-shield-alt"></i> ১০০% সার্ভার কন্ট্রোলড
            </span>
        </div>
        <div class="panel-body" style="padding:22px; color:#e2e8f0; font-size:13.8px; line-height:1.75;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                <!-- বক্স ১: গেমটি কিভাবে কাজ করে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#fbbf24; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hat-cowboy"></i> ১. গেমটি কিভাবে কাজ করে (Game Mechanics)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        ওয়েস্টার্ন থিমযুক্ত ভল্ট খোলার রোমাঞ্চকর গেম। প্লেয়ারকে বিভিন্ন ভল্ট ডোর সিলেক্ট করতে হয়:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>ভল্ট সঠিকভাবে খুললে ভেতরে গোল্ড বা ক্যাশ রিওয়ার্ড মাল্টিপ্লায়ার পাওয়া যায়।</li>
                        <li>যদি ভল্টে ট্র্যাপ বা খালি ড্রপ হয়, তবে বাজি হেরে যায়।</li>
                    </ul>
                </div>

                <!-- বক্স ২: এডমিন কিভাবে লাভ করবে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#34d399; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল (House Profit Engine)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        এডমিন প্রফিট মোড চালু থাকলে সিস্টেম পুল ব্যালেন্স চেক করে ফলাফল তৈরি করে:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>House Profit Mode:</strong> সবচেয়ে কম পেআউট সাইড বিজয়ী হবে। বড় অঙ্কের বাজির সময় সিস্টেম স্বয়ংক্রিয়ভাবে এডমিনের ফান্ড রক্ষা করে।</li>
                        <li><strong>Custom Win Percentage:</strong> আপনি যদি ৩০% উইন চান, তবে প্লেয়ার গড়ে ৩০ বার জিতবে এবং বাকি ৭০ বার এডমিন লাভ করবে।</li>
                    </ul>
                </div>

                <!-- বক্স ৩: ইউজাররা কিভাবে প্রফিট পায় -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#38bdf8; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজাররা কিভাবে প্রফিট ও পেআউট পায়
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        সফল ভল্ট ক্র্যাক করার সাথে সাথে প্লেয়ার নির্ধারিত মাল্টিপ্লায়ার অনুযায়ী রিওয়ার্ড পায়:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>উইন পেআউট:</strong> বেট অ্যামাউন্ট × ভল্ট মাল্টিপ্লায়ার।</li>
                        <li>প্লেয়ার তৎক্ষণাৎ ক্যাশ আউট করে ওয়ালেটে টাকা ট্রান্সফার করতে পারে।</li>
                    </ul>
                </div>

                <!-- বক্স ৪: এডমিন সেটিংস পরিবর্তন নির্দেশিকা -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#a855f7; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cogs"></i> ৪. সেটিংস পরিবর্তনের দ্রুত নির্দেশিকা
                    </div>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>এডমিন ফান্ড সর্বোচ্চ রাখতে <strong>House Profit Mode</strong> সিলেক্ট করে রাখুন।</li>
                        <li>বট অ্যাক্টিভ রাখলে লাইভ বেটিং পুল জীবন্ত থাকবে।</li>
                        <li>পরিবর্তন শেষে নিচে <strong>"Save Algorithm Settings"</strong> বাটনে ক্লিক করুন।</li>
                    </ul>
                </div>
            </div>
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
