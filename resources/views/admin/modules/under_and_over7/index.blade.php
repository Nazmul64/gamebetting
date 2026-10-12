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

    <!-- বাংলা গেম ও প্রফিট কন্ট্রোল নির্দেশিকা (Admin & House Profit Manual in Bengali) -->
    <div class="panel mb-4" style="background:#0f172a; border:1px solid #10b981; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(16,185,129,0.12);">
        <div class="panel-header" style="padding:16px 20px; background:linear-gradient(90deg, #064e3b 0%, #0f172a 100%); border-bottom:1px solid #059669; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; font-size:16.5px; font-weight:800; color:#34d399;">
                <i class="fas fa-book-open" style="margin-right:8px; color:#6ee7b7;"></i>
                Under and Over 7 — গেম অপারেশন ও এডমিনের লাভ (House Profit) নিয়ন্ত্রণ নির্দেশিকা
            </h4>
            <span style="background:rgba(52,211,153,0.2); color:#6ee7b7; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                <i class="fas fa-shield-alt"></i> ১০০% সার্ভার কন্ট্রোলড
            </span>
        </div>
        <div class="panel-body" style="padding:22px; color:#e2e8f0; font-size:13.8px; line-height:1.75;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                <!-- বক্স ১: গেমটি কিভাবে কাজ করে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#38bdf8; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-dice"></i> ১. গেমটি কিভাবে কাজ করে (Game Mechanics)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        গেমটিতে ২টি ৬-পার্শ্বযুক্ত ভার্চুয়াল ছক্কা (Dice) রোল করা হয়। ছক্কা দুটির যোগফল ২ থেকে ১২ এর মধ্যে যেকোনো একটি সংখ্যা আসে:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong style="color:#38bdf8;">UNDER (২, ৩, ৪, ৫, ৬):</strong> মোট ১৫টি সম্ভাব্য কম্বিনেশন। ডিফল্ট পেআউট <strong>x2.3</strong> গুণ।</li>
                        <li><strong style="color:#fbbf24;">EQUAL (ঠিক ৭):</strong> মোট ৬টি সম্ভাব্য কম্বিনেশন। উচ্চ পেআউট <strong>x5.8</strong> গুণ।</li>
                        <li><strong style="color:#34d399;">OVER (৮, ৯, ১০, ১১, ১২):</strong> মোট ১৫টি সম্ভাব্য কম্বিনেশন। ডিফল্ট পেআউট <strong>x2.3</strong> গুণ।</li>
                    </ul>
                </div>

                <!-- বক্স ২: এডমিন কিভাবে লাভ করবে -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#34d399; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-sack-dollar"></i> ২. এডমিনের লাভ ও উইন কন্ট্রোল (House Profit Engine)
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        এডমিন নিচের সেটিংস থেকে সরাসরি গেমের উইন/লস নির্ধারণ করতে পারেন:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>Player Win Chance (%):</strong> আপনি যদি এখানে <span style="color:#fbbf24; font-weight:800;">35%</span> সেট করেন, তবে গড়ে ১০০টি বেটের মধ্যে ইউজার ৩৫ বার জিতবে এবং <strong style="color:#34d399;">বাকি ৬৫ বার এডমিন/হাউস লাভ করবে!</strong></li>
                        <li><strong>House Profit Engine মোড:</strong> এই মোড চালু রাখলে সিস্টেম স্বয়ংক্রিয়ভাবে এডমিনের জন্য সর্বোচ্চ প্রফিট ধরে রেখে ব্যালেন্স পরিচালনা করে।</li>
                        <li><strong>নির্দিষ্ট ইউজার কন্ট্রোল:</strong> ইউজার লিস্ট থেকে নির্দিষ্ট কোনো প্লেয়ারকে <em>Always Win</em> অথবা <em>Always Lose</em> করে দেওয়া যায়।</li>
                    </ul>
                </div>

                <!-- বক্স ৩: ইউজাররা কিভাবে প্রফিট পায় -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#fbbf24; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-hand-holding-dollar"></i> ৩. ইউজাররা কিভাবে প্রফিট ও পেআউট পায়
                    </div>
                    <p style="margin-bottom:8px; color:#cbd5e1;">
                        ইউজারের অ্যাকাউন্টে ব্যালেন্স থাকলে তারা বেট করতে পারে। জয়ের হিসাব:
                    </p>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li><strong>উইন পেআউট সূত্র:</strong> <code style="background:#0b1120; padding:2px 6px; border-radius:4px; color:#38bdf8;">উইন ব্যালেন্স = বেট অ্যামাউন্ট × মাল্টিপ্লায়ার</code></li>
                        <li><strong>উদাহরণ:</strong> ১০০ টাকা বেট করে যদি Over বা Under (x2.3) এ জিতে, তবে প্লেয়ার পায় <strong>২৩০ টাকা</strong> (যার মধ্যে নিট প্রফিট ১৩০ টাকা)।</li>
                        <li><strong>Equal 7 জয়:</strong> ১০০ টাকা বেটে (x5.8) এ জিতলে প্লেয়ার পায় <strong>৫৮০ টাকা</strong> (যার নিট প্রফিট ৪৮০ টাকা)।</li>
                        <li>জয়ের সাথে সাথে টাকা ইউজারের ওয়ালেটে রিয়েল-টাইমে ক্রেডিট হয় এবং ট্রানজেকশন লেজারে সেভ থাকে।</li>
                    </ul>
                </div>

                <!-- বক্স ৪: এডমিন সেটিংস পরিবর্তন নির্দেশিকা -->
                <div style="background:#131d2e; border:1px solid #1e293b; border-radius:10px; padding:16px;">
                    <div style="color:#a855f7; font-weight:800; font-size:15px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-cogs"></i> ৪. সেটিংস পরিবর্তনের দ্রুত নির্দেশিকা
                    </div>
                    <ul style="padding-left:18px; margin:0; color:#cbd5e1;">
                        <li>এডমিন প্রফিট বাড়াতে <strong>Player Win Chance</strong> এর মান কম রাখুন (যেমন: ২৫% থেকে ৪০%)।</li>
                        <li>খেলার গতি ও আকর্ষণ বাড়াতে মাল্টিপ্লায়ার x2.3 এবং x5.8 রাখা আদর্শ।</li>
                        <li>বড় ঝুঁকি এড়াতে <strong>Maximum Bet</strong> সীমা আপনার ক্যাসিনো ক্যাপাসিটি অনুযায়ী সেট করুন (যেমন: ৫,০০০ বা ১০,০০০)।</li>
                        <li>পরিবর্তন শেষে নিচে থাকা <strong>"Save Settings"</strong> বাটনে ক্লিক করলে তা সাথে সাথে কার্যকর হবে।</li>
                    </ul>
                </div>
            </div>
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
