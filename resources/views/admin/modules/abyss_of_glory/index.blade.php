@extends('admin.dashboard')

@section('module_content')
<div class="container-fluid p-2">
    <div class="page-header mb-4" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div class="page-header-title-group">
            <h2 style="font-size:24px; font-weight:800; font-family:'Space Grotesk',sans-serif; color:var(--text-primary);">
                <i class="fas fa-landmark" style="color:#f59e0b; margin-right:8px;"></i>
                Abyss of Glory (Temple of Fortune) — Game Module
            </h2>
            <p style="color:var(--text-secondary); font-size:13.5px; margin-top:4px;">
                House Profit pool balancing, Poseidon vs Anubis god clash battle engine, smart bot automation & audit ledger.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('temple-of-fortune') }}" target="_blank" class="btn-primary" style="width:auto; padding:9px 18px; font-size:13px; text-decoration:none; background:linear-gradient(135deg,#f59e0b,#d97706); border:none;">
                <i class="fas fa-gamepad"></i> Launch Game
            </a>
        </div>
    </div>

    <!-- Operation Guide Card -->
    <div class="panel mb-4" style="border-left: 4px solid #f59e0b; background: rgba(245, 158, 11, 0.05);">
        <div class="panel-header" style="background: rgba(245, 158, 11, 0.1);">
            <div class="panel-title" style="color: #fbbf24; font-size: 14px;">
                <i class="fas fa-shield-halved"></i> গেম অপারেশন গাইড ও এডমিনের হাউজ প্রফিট মেকানিজম (100% Platform Safety)
            </div>
        </div>
        <div class="panel-body" style="font-size: 13.5px; color: #cbd5e1; line-height: 1.6;">
            <p style="margin-bottom: 8px;">
                <strong>১. হাউজ প্রফিট মেকানিজম (House Profit Logic):</strong> প্লেয়াররা দুই দলে ভাগ হয়ে বেট ধরে (বামে <em>Poseidon</em> বনাম ডানে <em>Anubis</em>)। রাউন্ড শেষ হওয়ার সময় সিস্টেম স্বয়ংক্রিয়ভাবে কম টাকার সাইডকে বিজয়ী করে। ফলে বেশি টাকার সাইডের সমুদয় অর্থ প্ল্যাটফর্মের নিট প্রফিট হিসেবে থাকে।
            </p>
            <p style="margin-bottom: 8px;">
                <strong>২. র্যান্ডমাইজেশন ও ফেয়ারনেস ফাসাদ:</strong> ইউজাররা টাকার পরিমাণ বা পে-আউটের ক্যালকুলেশন দেখে না; তারা শুধু ৫x৩ গ্রিডে বিজয়ী দেবতার উইনিং সিম্বল ও ফায়ার/লাইটনিং বার্স্ট অ্যানিমেশন দেখে।
            </p>
            <p style="margin-bottom: 0;">
                <strong>৩. স্মার্ট বট অটোমেশন:</strong> রিয়েল প্লেয়ার সংখ্যা নির্ধারিত লিমিটের নিচে থাকলে স্বয়ংক্রিয়ভাবে বটরা ডাটাবেজে ফেক বেট ফেলে স্ক্রিনকে প্রাণবন্ত রাখে।
            </p>
        </div>
    </div>

    <!-- Analytics Widget -->
    <div class="stats-grid mb-4">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                <span class="stat-card-change change-up">Real Bets</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalCollected, 2) }}</div>
            <div class="stat-card-label">Total Real Bets Volume</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-trophy"></i></div>
                <span class="stat-card-change" style="background:rgba(139,92,246,0.15); color:#c084fc; border:1px solid rgba(139,92,246,0.3);">Payouts</span>
            </div>
            <div class="stat-card-val">৳ {{ number_format($totalPaidOut, 2) }}</div>
            <div class="stat-card-label">Total Player Payouts</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-sack-dollar"></i></div>
                <span class="stat-card-change change-up">House Profit</span>
            </div>
            <div class="stat-card-val" style="color:{{ $adminProfit >= 0 ? '#34d399' : '#f87171' }};">৳ {{ number_format($adminProfit, 2) }}</div>
            <div class="stat-card-label">Net Admin House Profit</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon"><i class="fas fa-fire"></i></div>
                <span class="stat-card-change" style="background:rgba(251,191,36,0.15); color:var(--accent-gold); border:1px solid rgba(251,191,36,0.3);">{{ $settings->payout_multiplier }}x Payout</span>
            </div>
            <div class="stat-card-val">{{ strtoupper(str_replace('_', ' ', $settings->control_mode)) }}</div>
            <div class="stat-card-label">Algorithm Mode</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:20px; margin-bottom:24px;">
        <!-- Game Settings Form -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> গেম অ্যালগরিদম ও উইন/লস কন্ট্রোল</div>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.abyss.settings') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">গেম ডিসপ্লে নাম:</label>
                        <input type="text" name="game_name" value="{{ $settings->game_name }}" class="form-input" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">অ্যালগরিদম কন্ট্রোল মোড:</label>
                        <select name="control_mode" class="form-input" style="cursor:pointer;">
                            <option value="house_profit" {{ $settings->control_mode == 'house_profit' ? 'selected' : '' }}>House Profit Mode (কম টাকার দল জিতবে - ১০০% এডমিন প্রফিট)</option>
                            <option value="fixed_percentage" {{ $settings->control_mode == 'fixed_percentage' ? 'selected' : '' }}>Fixed Percentage (উইন রেট % অনুযায়ী)</option>
                            <option value="random" {{ $settings->control_mode == 'random' ? 'selected' : '' }}>100% Random (ন্যাচারাল আরটিপি)</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">ইউজারের জয়ের হার (%):</label>
                            <input type="number" name="win_chance_percentage" value="{{ $settings->win_chance_percentage }}" min="1" max="99" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">পেআউট মাল্টিপ্লায়ার (গুণ):</label>
                            <input type="number" step="0.01" name="payout_multiplier" value="{{ $settings->payout_multiplier }}" min="1.0" max="5.0" class="form-input" required>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">বট চালু থাকবে:</label>
                            <select name="bot_status" class="form-input">
                                <option value="1" {{ $settings->bot_status ? 'selected' : '' }}>হ্যাঁ (সক্রিয়)</option>
                                <option value="0" {{ !$settings->bot_status ? 'selected' : '' }}>না (নিষ্ক্রিয়)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">কতজন রিয়েল প্লেয়ারের নিচে বট আসবে:</label>
                            <input type="number" name="bot_trigger_count" value="{{ $settings->bot_trigger_count }}" class="form-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">বট সর্বনিম্ন বেট (৳):</label>
                            <input type="number" name="bot_min_bet" value="{{ $settings->bot_min_bet }}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">বট সর্বোচ্চ বেট (৳):</label>
                            <input type="number" name="bot_max_bet" value="{{ $settings->bot_max_bet }}" class="form-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">প্লেয়ার সর্বনিম্ন বেট (৳):</label>
                            <input type="number" name="min_bet" step="0.1" value="{{ $settings->min_bet }}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">প্লেয়ার সর্বোচ্চ বেট (৳):</label>
                            <input type="number" name="max_bet" value="{{ $settings->max_bet }}" class="form-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" class="mb-3">
                        <div class="form-group">
                            <label class="form-label">ডেমো স্পিন লিমিট:</label>
                            <input type="number" name="demo_spin_limit" value="{{ $settings->demo_spin_limit }}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">রাউন্ড সময়কাল (সেকেন্ড):</label>
                            <input type="number" name="round_duration_seconds" value="{{ $settings->round_duration_seconds }}" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-100" style="padding:11px; margin-top:8px;">
                        <i class="fas fa-check"></i> সেটিংস সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- Audio & Tracks Settings -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-music" style="color:#00f2fe;"></i> সাউন্ড ও মিউজিক ট্র্যাক্স আপলোড</div>
            </div>
            <div class="panel-body">
                @php
                    $audios = [
                        'bg_magic_music' => ['title' => 'ব্যাকগ্রাউন্ড ম্যাজিক মিউজিক', 'icon' => 'fa-headphones'],
                        'spin_sound' => ['title' => 'রিল ঘোরার সাউন্ড', 'icon' => 'fa-rotate'],
                        'win_sound' => ['title' => 'জয়ের সাউন্ড (Victory)', 'icon' => 'fa-trophy'],
                        'god_clash_sound' => ['title' => 'দেবতাদের ক্ল্যাশ সাউন্ড (Thunder)', 'icon' => 'fa-bolt']
                    ];
                @endphp
                @foreach($audios as $key => $item)
                    <form action="{{ route('admin.abyss.audio') }}" method="POST" enctype="multipart/form-data" class="mb-3 p-3" style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:var(--radius-md);">
                        @csrf
                        <input type="hidden" name="audio_type" value="{{ $key }}">
                        <label class="form-label" style="display:flex; align-items:center; gap:6px; color:#fff;">
                            <i class="fas {{ $item['icon'] }}" style="color:var(--accent-gold);"></i>
                            {{ $item['title'] }} (.mp3/.wav):
                        </label>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <input type="file" name="audio_file" accept=".mp3,.wav" class="form-input" style="padding:5px;" required>
                            <button type="submit" class="btn-primary" style="padding:7px 14px; font-size:12px; width:auto; white-space:nowrap;">আপলোড</button>
                        </div>
                        @if($settings->$key)
                            <div style="font-size:11px; color:#34d399; margin-top:5px; font-family:'JetBrains Mono',monospace;">
                                <i class="fas fa-circle-check"></i> {{ $settings->$key }}
                            </div>
                        @endif
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Rounds Audit Ledger -->
    <div class="panel">
        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div class="panel-title"><i class="fas fa-list-check" style="color:#60a5fa;"></i> সাম্প্রতিক রাউন্ড হিস্ট্রি ও অডিট লেজার</div>
            <span style="font-size:12px; color:var(--text-muted);">মোট রাউন্ড: {{ $totalRounds ?? 0 }}</span>
        </div>
        <div class="panel-body p-0">
            <div class="table-responsive">
                <table class="table" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-subtle); text-align:left; font-size:11px; color:var(--text-muted); text-transform:uppercase;">
                            <th style="padding:12px 16px;">Round ID</th>
                            <th style="padding:12px 16px;">Winner</th>
                            <th style="padding:12px 16px;">Poseidon (Real / Bot)</th>
                            <th style="padding:12px 16px;">Anubis (Real / Bot)</th>
                            <th style="padding:12px 16px;">Total Payout</th>
                            <th style="padding:12px 16px;">House Profit</th>
                            <th style="padding:12px 16px;">Status</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:13px; font-family:'JetBrains Mono',monospace;">
                        @forelse($recentRounds as $r)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
                            <td style="padding:12px 16px; color:#cbd5e1;">{{ $r->round_id }}</td>
                            <td style="padding:12px 16px;">
                                @if($r->winning_side === 'poseidon')
                                    <span style="background:rgba(59,130,246,0.15); color:#60a5fa; padding:2px 8px; border-radius:4px; font-weight:800;">POSEIDON</span>
                                @elseif($r->winning_side === 'anubis')
                                    <span style="background:rgba(245,158,11,0.15); color:#fbbf24; padding:2px 8px; border-radius:4px; font-weight:800;">ANUBIS</span>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td style="padding:12px 16px;">৳ {{ number_format($r->real_bets_poseidon, 2) }} <small style="color:var(--text-muted);">/ ৳ {{ number_format($r->bot_bets_poseidon, 2) }}</small></td>
                            <td style="padding:12px 16px;">৳ {{ number_format($r->real_bets_anubis, 2) }} <small style="color:var(--text-muted);">/ ৳ {{ number_format($r->bot_bets_anubis, 2) }}</small></td>
                            <td style="padding:12px 16px; color:#f87171;">৳ {{ number_format($r->total_payout, 2) }}</td>
                            <td style="padding:12px 16px; color:{{ $r->admin_profit >= 0 ? '#34d399' : '#f87171' }}; font-weight:800;">৳ {{ number_format($r->admin_profit, 2) }}</td>
                            <td style="padding:12px 16px;">
                                <span style="font-size:11px; font-weight:700; text-transform:uppercase; color:{{ $r->status === 'completed' ? '#34d399' : '#fbbf24' }};">
                                    {{ $r->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:24px; color:var(--text-muted);">কোনো রাউন্ডের রেকর্ড পাওয়া যায়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
