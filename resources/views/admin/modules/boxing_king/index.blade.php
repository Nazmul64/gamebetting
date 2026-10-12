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

    <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
    <div class="panel mb-4" style="background:#0f172a; border:1px solid #ef4444; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(239,68,68,0.12);">
        <div class="panel-header" style="padding:16px 20px; background:linear-gradient(90deg, #7f1d1d 0%, #0f172a 100%); border-bottom:1px solid #ef4444; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16.5px; font-weight:800; color:#f87171;">
                <i class="fas fa-book-open" style="margin-right:8px; color:#fca5a5;"></i>
                Boxing King (Ring Champion) — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
            </h4>
            <span style="background:rgba(239,68,68,0.2); color:#fca5a5; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                <i class="fas fa-shield-alt"></i> ১০০% সার্ভার কন্ট্রোলড
            </span>
        </div>
        <div class="panel-body" style="padding:22px; color:#e2e8f0; font-size:13.8px; line-height:1.75;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                <!-- বক্স ১: গেমটি কিভাবে কাজ করে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#f87171; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-boxing-glove"></i> ১. গেমটি কিভাবে কাজ করে (Game Mechanics)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        বক্সিং রিং চ্যাম্পিয়ন স্লট গেম। প্লেয়ার স্পিন বাটনে চাপ দিলে রিল ঘরে:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>৩ বা ততোধিক মিল পাওয়া সিম্বলে কম্বিনেশন পেআউট তৈরি হয়।</li>
                        <li><strong>Free Spin & Bell Scatter:</strong> ৩টি বেল পেলে ফ্রি স্পিন মোড চালু হয়।</li>
                        <li><strong>Wild Champion:</strong> ওয়াইল্ড সিম্বল যেকোনো সাধারণ সিম্বলের বিকল্প হিসেবে বসে বড় পেআউট তৈরি করে।</li>
                    </ul>
                </div>

                <!-- বক্স ২: এডমিন কিভাবে লাভ করবে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#34d399; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল (House Profit Engine)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        স্পিনের ফলাফল ব্যাকএন্ড অ্যালগরিদম দ্বারা সম্পূর্ণ সুরক্ষিত ও লাভজনক:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>House Profit Mode:</strong> স্লটের স্পিন ফলাফল স্বয়ংক্রিয়ভাবে এডমিনের জন্য সর্বোচ্চ রেভিনিউ নিশ্চিত করে।</li>
                        <li><strong>Target Win %:</strong> আপনি যদি ৩০% উইন সেট করেন, তবে প্লেয়ার গড়ে প্রতি ১০ স্পিনের মধ্যে ৩টি স্পিনে ছোট উইন পাবে, বাকি ৭টি স্পিন এডমিনের ফান্ডে জমা হবে।</li>
                    </ul>
                </div>

                <!-- বক্স ৩: ইউজাররা কিভাবে প্রফিট পায় -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#fbbf24; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজাররা কিভাবে প্রফিট ও পেআউট পায়
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        সিম্বল মিললে পে-টেবিল অনুযায়ী পেআউট ইউজারের একাউন্টে রিয়েল-টাইমে যোগ হয়:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>পেআউট সূত্র:</strong> বেট অ্যামাউন্ট × পেলাইন মাল্টিপ্লায়ার (যেমন: x2, x5, x10, x100)।</li>
                        <li>প্লেয়ার বড় উইন পেলে সাথে সাথে বিগ উইন সেলিব্রেশন আসে এবং ওয়ালেট আপডেট হয়।</li>
                    </ul>
                </div>

                <!-- বক্স ৪: এডমিন সেটিংস পরিবর্তন নির্দেশিকা -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#a855f7; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cogs"></i> ৪. সেটিংস পরিবর্তনের দ্রুত নির্দেশিকা
                    </div>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>এডমিন প্রফিট বাড়াতে <strong>Win Rate Percentage</strong> ২৫% থেকে ৩৫% এর মধ্যে রাখুন।</li>
                        <li>বড় রিস্ক থেকে সেফ থাকতে <strong>Max Bet Limit</strong> সেট করুন।</li>
                        <li>পরিবর্তন শেষে <strong>"Save Algorithm Settings"</strong> এ ক্লিক করলে সাথে সাথে লাইভ গেমে কার্যকর হবে।</li>
                    </ul>
                </div>
            </div>
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
