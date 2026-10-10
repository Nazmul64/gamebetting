<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agent & Seller Workstation — 1XGAMES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #060b17;
            --bg-panel: #0d1830;
            --bg-card: rgba(18, 30, 58, 0.85);
            --accent-cyan: #00f2fe;
            --accent-blue: #2563eb;
            --accent-green: #10b981;
            --accent-gold: #f59e0b;
            --accent-red: #ef4444;
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(0, 242, 254, 0.25);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg-body);
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header.seller-header {
            background: rgba(13, 24, 48, 0.95);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(15px);
        }
        .header-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .header-brand .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #00f2fe, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.35);
        }
        .header-brand h1 { font-size: 18px; font-weight: 800; color: #fff; }
        .header-brand span { font-size: 11px; color: var(--accent-cyan); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }

        .header-seller-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .wallet-pill {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .wallet-pill span.label { font-size: 11px; color: #6ee7b7; font-weight: 700; text-transform: uppercase; }
        .wallet-pill span.val { font-size: 18px; font-weight: 800; color: #34d399; font-family: 'Roboto Mono', monospace; }

        .seller-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-subtle);
            padding: 6px 14px 6px 6px;
            border-radius: 30px;
        }
        .seller-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid var(--accent-cyan);
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
        }
        .seller-details { line-height: 1.2; }
        .seller-details .name { font-weight: 700; font-size: 13px; color: #fff; }
        .seller-details .id-code { font-size: 11px; color: var(--accent-gold); font-family: 'Roboto Mono', monospace; }

        .btn-logout {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 8px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-logout:hover { background: var(--accent-red); color: #fff; }

        .container {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 24px;
            flex: 1;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: var(--accent-cyan);
        }
        .stat-card.green::before { background: var(--accent-green); }
        .stat-card.gold::before { background: var(--accent-gold); }
        .stat-card.purple::before { background: #8b5cf6; }
        .stat-card .label { font-size: 12px; color: var(--text-sub); font-weight: 700; text-transform: uppercase; margin-bottom: 6px; }
        .stat-card .value { font-size: 24px; font-weight: 800; color: #fff; font-family: 'Roboto Mono', monospace; }

        /* Main Workspace Grid: Transfer + Live Chat */
        .workspace-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        @media(max-width: 1024px) {
            .workspace-grid { grid-template-columns: 1fr; }
        }

        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(12px);
        }
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-subtle);
        }
        .panel-title {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Transfer Form */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-box {
            position: relative;
        }
        .input-box input {
            width: 100%;
            padding: 13px 16px;
            background: rgba(0, 0, 0, 0.35);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }
        .input-box input:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 15px rgba(0, 242, 254, 0.2);
            background: rgba(0, 0, 0, 0.5);
        }
        .customer-preview-box {
            margin-top: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            background: rgba(0, 242, 254, 0.05);
            border: 1px dashed rgba(0, 242, 254, 0.3);
            display: none;
            align-items: center;
            justify-content: space-between;
        }
        .preset-amounts {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .preset-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: #cbd5e1;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .preset-btn:hover { background: rgba(0, 242, 254, 0.15); border-color: var(--accent-cyan); color: var(--accent-cyan); }

        .btn-transfer {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-transfer:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(16, 185, 129, 0.45); }
        .btn-transfer:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* Chat System */
        .chat-container {
            display: flex;
            height: 440px;
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.3);
        }
        .chat-user-list {
            width: 38%;
            border-right: 1px solid var(--border-subtle);
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.2);
        }
        .chat-user-item {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chat-user-item:hover, .chat-user-item.active { background: rgba(0, 242, 254, 0.08); }
        .chat-user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: #334155; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; color: #fff; flex-shrink: 0;
        }
        .chat-user-info { flex: 1; min-width: 0; line-height: 1.3; }
        .chat-user-info .c-name { font-size: 13px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .chat-user-info .c-code { font-size: 11px; color: var(--accent-gold); font-family: 'Roboto Mono', monospace; }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(6, 11, 23, 0.5);
        }
        .chat-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.2);
        }
        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chat-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.4;
            position: relative;
        }
        .chat-bubble.seller {
            align-self: flex-end;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border-bottom-right-radius: 2px;
        }
        .chat-bubble.customer {
            align-self: flex-start;
            background: rgba(255, 255, 255, 0.08);
            color: #f1f5f9;
            border: 1px solid var(--border-subtle);
            border-bottom-left-radius: 2px;
        }
        .chat-bubble .time {
            font-size: 9.5px;
            opacity: 0.7;
            margin-top: 4px;
            text-align: right;
            display: block;
        }
        .chat-input-row {
            padding: 12px;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            gap: 8px;
            background: rgba(0, 0, 0, 0.2);
        }
        .chat-input-row input {
            flex: 1;
            padding: 10px 14px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            outline: none;
            font-size: 13px;
        }
        .chat-input-row button {
            background: var(--accent-blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0 16px;
            font-weight: 700;
            cursor: pointer;
        }

        /* History Table */
        .table-wrap { overflow-x: auto; }
        table.history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }
        table.history-table th {
            padding: 12px 16px;
            background: rgba(0, 0, 0, 0.25);
            color: var(--text-sub);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-subtle);
        }
        table.history-table td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: #cbd5e1;
        }
        table.history-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

        /* Toast notifications */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            border: 1px solid var(--border-subtle);
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            gap: 10px;
        }
        .toast.success { border-color: var(--accent-green); background: #064e3b; color: #a7f3d0; }
        .toast.error { border-color: var(--accent-red); background: #7f1d1d; color: #fecaca; }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="seller-header">
        <div class="header-brand">
            <div class="logo-icon"><i class="fas fa-handshake"></i></div>
            <div>
                <h1>1XGAMES Agent Station</h1>
                <span>Verified Reseller Workstation</span>
            </div>
        </div>

        <div class="header-seller-info">
            <div class="wallet-pill">
                <span class="label">Agent Balance:</span>
                <span class="val" id="seller-balance-val">৳ {{ number_format($seller->balance, 2) }}</span>
            </div>

            <div class="seller-profile-badge">
                @if($seller->seller_photo && file_exists(public_path($seller->seller_photo)))
                    <img src="{{ asset($seller->seller_photo) }}" alt="Avatar" class="seller-avatar">
                @else
                    <div class="seller-avatar">{{ strtoupper(substr($seller->name, 0, 2)) }}</div>
                @endif
                <div class="seller-details">
                    <div class="name">{{ $seller->name }}</div>
                    <div class="id-code">ID: #{{ $seller->user_code }}</div>
                </div>
            </div>

            <form action="{{ route('seller.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <div class="container">
        <!-- 4 Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card green">
                <div class="label"><i class="fas fa-wallet"></i> Available Balance</div>
                <div class="value" id="stat-balance">৳ {{ number_format($seller->balance, 2) }}</div>
            </div>
            <div class="stat-card cyan">
                <div class="label"><i class="fas fa-paper-plane"></i> Total Transferred</div>
                <div class="value">৳ {{ number_format($totalTransferred, 2) }}</div>
            </div>
            <div class="stat-card gold">
                <div class="label"><i class="fas fa-receipt"></i> Completed Transfers</div>
                <div class="value">{{ $transfersCount }} Orders</div>
            </div>
            <div class="stat-card purple">
                <div class="label"><i class="fas fa-comments"></i> Active Customers</div>
                <div class="value">{{ count($activeChatUsers) }} Players</div>
            </div>
        </div>

        <!-- Main Workspace: Instant Transfer + Live Chat -->
        <div class="workspace-grid">
            <!-- ⚡ Quick Customer Balance Transfer Panel -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="fas fa-bolt" style="color:var(--accent-green);"></i>
                        <span>Instant Customer Deposit / Balance Transfer</span>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:var(--accent-cyan); background:rgba(0,242,254,0.1); padding:4px 10px; border-radius:6px;">0% Fee Instant</span>
                </div>

                <form id="transfer-form" onsubmit="executeTransfer(event)">
                    <div class="form-group">
                        <label>Customer 10-Digit User ID</label>
                        <div class="input-box">
                            <input type="text" id="target-user-code" placeholder="e.g. 1029384756" maxlength="15" autocomplete="off" oninput="debounceLookupCustomer(this.value)" required>
                        </div>
                        
                        <div id="customer-preview" class="customer-preview-box">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <i class="fas fa-circle-check" style="color:var(--accent-green); font-size:18px;"></i>
                                <div>
                                    <strong id="preview-name" style="color:#fff; font-size:13.5px; display:block;">—</strong>
                                    <span id="preview-email" style="font-size:11px; color:var(--text-sub);">—</span>
                                </div>
                            </div>
                            <span id="preview-curr-bal" style="font-size:12px; color:var(--accent-gold); font-weight:700; font-family:'Roboto Mono',monospace;">—</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Transfer Amount (BDT)</label>
                        <div class="input-box">
                            <input type="number" id="transfer-amount" min="10" step="1" placeholder="Enter amount to credit" required>
                        </div>
                        <div class="preset-amounts">
                            <button type="button" class="preset-btn" onclick="setTransferAmount(100)">+100</button>
                            <button type="button" class="preset-btn" onclick="setTransferAmount(500)">+500</button>
                            <button type="button" class="preset-btn" onclick="setTransferAmount(1000)">+1,000</button>
                            <button type="button" class="preset-btn" onclick="setTransferAmount(2000)">+2,000</button>
                            <button type="button" class="preset-btn" onclick="setTransferAmount(5000)">+5,000</button>
                            <button type="button" class="preset-btn" onclick="setTransferAmount(10000)">+10,000</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes / Reference (Optional)</label>
                        <div class="input-box">
                            <input type="text" id="transfer-notes" placeholder="e.g. Bkash cash paid, Telegram ref, etc.">
                        </div>
                    </div>

                    <button type="submit" id="btn-submit-transfer" class="btn-transfer">
                        <i class="fas fa-bolt"></i> Transfer Balance to Customer
                    </button>
                </form>
            </div>

            <!-- 💬 Live Customer Chat Support Panel -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="fas fa-comments" style="color:var(--accent-cyan);"></i>
                        <span>Customer Live Chat</span>
                    </div>
                    <span style="font-size:11px; color:var(--text-sub);"><i class="fas fa-circle" style="color:#10b981; font-size:8px;"></i> Live Polling</span>
                </div>

                <div class="chat-container">
                    <!-- User list -->
                    <div class="chat-user-list" id="chat-user-list">
                        @if(count($activeChatUsers) > 0)
                            @foreach($activeChatUsers as $chatUser)
                                @if($chatUser->customer)
                                    <div class="chat-user-item" onclick="openChatWithCustomer({{ $chatUser->customer->id }}, '{{ addslashes($chatUser->customer->name) }}', '{{ $chatUser->customer->user_code }}')">
                                        <div class="chat-user-avatar">{{ strtoupper(substr($chatUser->customer->name, 0, 2)) }}</div>
                                        <div class="chat-user-info">
                                            <div class="c-name">{{ $chatUser->customer->name }}</div>
                                            <div class="c-code">#{{ $chatUser->customer->user_code }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div style="padding:20px; text-align:center; color:var(--text-sub); font-size:12px;">
                                No customer messages yet.
                            </div>
                        @endif
                    </div>

                    <!-- Chat conversation area -->
                    <div class="chat-main">
                        <div class="chat-header">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <strong id="active-chat-name" style="color:#fff; font-size:13.5px;">Select a customer to chat</strong>
                                <span id="active-chat-code" style="font-size:11px; color:var(--accent-gold); font-family:'Roboto Mono',monospace;"></span>
                            </div>
                            <button type="button" id="btn-chat-quick-fill" onclick="quickFillCustomerFromChat()" style="display:none; background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.4); color:#34d399; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-bolt"></i> Fill Transfer
                            </button>
                        </div>

                        <div class="chat-messages" id="chat-messages-box">
                            <div style="margin:auto; text-align:center; color:var(--text-sub); font-size:13px;">
                                <i class="fas fa-comment-dots" style="font-size:32px; margin-bottom:8px; opacity:0.4;"></i>
                                <p>Select a customer conversation from the left to start replying in real-time.</p>
                            </div>
                        </div>

                        <form class="chat-input-row" onsubmit="sendChatMessage(event)">
                            <input type="text" id="chat-input-field" placeholder="Type your message to customer..." autocomplete="off">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📜 Recent Transfers Ledger -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-receipt" style="color:var(--accent-gold);"></i>
                    <span>Recent Customer Transfers Ledger</span>
                </div>
            </div>

            <div class="table-wrap">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>ORDER #</th>
                            <th>CUSTOMER NAME</th>
                            <th>CUSTOMER 10-DIGIT ID</th>
                            <th>AMOUNT</th>
                            <th>BALANCE AFTER</th>
                            <th>NOTES / REF</th>
                            <th>DATE & TIME</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="transfers-tbody">
                        @forelse($recentTransfers as $t)
                            <tr>
                                <td><span style="font-family:'Roboto Mono',monospace; color:var(--text-sub);">#{{ $t->id }}</span></td>
                                <td><strong style="color:#fff;">{{ $t->customer ? $t->customer->name : 'N/A' }}</strong></td>
                                <td><span style="font-family:'Roboto Mono',monospace; color:var(--accent-gold); font-weight:700;">#{{ $t->customer_user_code }}</span></td>
                                <td><span style="color:#34d399; font-weight:800; font-family:'Roboto Mono',monospace;">৳ {{ number_format($t->amount, 2) }}</span></td>
                                <td><span style="font-family:'Roboto Mono',monospace; color:var(--text-sub);">৳ {{ number_format($t->seller_balance_after, 2) }}</span></td>
                                <td><span style="font-size:12px; color:var(--text-sub);">{{ $t->notes ?: '—' }}</span></td>
                                <td><span style="font-size:12px; color:var(--text-sub);">{{ $t->created_at->format('d M Y, h:i A') }}</span></td>
                                <td><span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); padding:3px 8px; border-radius:6px; font-size:10.5px; font-weight:800;">SUCCESS</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center; padding:30px; color:var(--text-sub);">
                                    No transfers made yet. Use the transfer panel above to credit your first customer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toast Component -->
    <div id="toast" class="toast">
        <i class="fas fa-info-circle"></i>
        <span id="toast-msg">Message</span>
    </div>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentChatCustomerId = null;
        let currentChatCustomerCode = null;
        let chatPollingTimer = null;
        let lookupTimer = null;

        function showToast(msg, isError = false) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-msg');
            toast.className = 'toast ' + (isError ? 'error' : 'success');
            toastMsg.textContent = msg;
            toast.style.display = 'flex';
            setTimeout(() => { toast.style.display = 'none'; }, 4000);
        }

        function setTransferAmount(amt) {
            document.getElementById('transfer-amount').value = amt;
        }

        function debounceLookupCustomer(code) {
            clearTimeout(lookupTimer);
            const previewBox = document.getElementById('customer-preview');
            if (code.length < 4) {
                previewBox.style.display = 'none';
                return;
            }

            lookupTimer = setTimeout(() => {
                fetch(`/seller/lookup-customer?user_code=${encodeURIComponent(code)}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('preview-name').textContent = data.customer.name;
                        document.getElementById('preview-email').textContent = data.customer.email;
                        document.getElementById('preview-curr-bal').textContent = `Current Bal: ৳ ${data.customer.balance}`;
                        previewBox.style.display = 'flex';
                    } else {
                        previewBox.style.display = 'none';
                    }
                })
                .catch(() => { previewBox.style.display = 'none'; });
            }, 300);
        }

        function executeTransfer(e) {
            e.preventDefault();
            const userCode = document.getElementById('target-user-code').value.trim();
            const amount = parseFloat(document.getElementById('transfer-amount').value);
            const notes = document.getElementById('transfer-notes').value;
            const btn = document.getElementById('btn-submit-transfer');

            if (!userCode || !amount || amount <= 0) {
                showToast('Please enter a valid customer ID and transfer amount.', true);
                return;
            }

            const confirmed = confirm(`Are you sure you want to transfer ৳ ${amount.toLocaleString()} to Customer ID #${userCode}?`);
            if (!confirmed) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Instant Transfer...';

            fetch('{{ route('seller.transfer') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_code: userCode, amount, notes })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-bolt"></i> Transfer Balance to Customer';
                if (data.success) {
                    showToast(data.message);
                    document.getElementById('seller-balance-val').textContent = `৳ ${parseFloat(data.seller_balance).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                    document.getElementById('stat-balance').textContent = `৳ ${parseFloat(data.seller_balance).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                    document.getElementById('transfer-form').reset();
                    document.getElementById('customer-preview').style.display = 'none';
                    reloadTransfersLedger();
                } else {
                    showToast((data.errors || [data.message || 'Transfer failed']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-bolt"></i> Transfer Balance to Customer';
                showToast('Connection error.', true);
            });
        }

        function reloadTransfersLedger() {
            fetch('{{ route('seller.transfers-history') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('transfers-tbody');
                    if (data.transfers.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--text-sub);">No transfers yet.</td></tr>`;
                        return;
                    }
                    tbody.innerHTML = data.transfers.map(t => `
                        <tr>
                            <td><span style="font-family:'Roboto Mono',monospace; color:var(--text-sub);">#${t.id}</span></td>
                            <td><strong style="color:#fff;">${t.customer_name}</strong></td>
                            <td><span style="font-family:'Roboto Mono',monospace; color:var(--accent-gold); font-weight:700;">#${t.user_code}</span></td>
                            <td><span style="color:#34d399; font-weight:800; font-family:'Roboto Mono',monospace;">৳ ${t.amount}</span></td>
                            <td><span style="font-family:'Roboto Mono',monospace; color:var(--text-sub);">৳ ${t.seller_bal}</span></td>
                            <td><span style="font-size:12px; color:var(--text-sub);">${t.notes || '—'}</span></td>
                            <td><span style="font-size:12px; color:var(--text-sub);">${t.created_at}</span></td>
                            <td><span style="background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); padding:3px 8px; border-radius:6px; font-size:10.5px; font-weight:800;">SUCCESS</span></td>
                        </tr>
                    `).join('');
                }
            });
        }

        // Live Chat with Customers
        function openChatWithCustomer(id, name, code) {
            currentChatCustomerId = id;
            currentChatCustomerCode = code;
            document.getElementById('active-chat-name').textContent = name;
            document.getElementById('active-chat-code').textContent = `(ID: #${code})`;
            document.getElementById('btn-chat-quick-fill').style.display = 'inline-block';

            loadChatMessages();
            clearInterval(chatPollingTimer);
            chatPollingTimer = setInterval(loadChatMessages, 3000);
        }

        function quickFillCustomerFromChat() {
            if (currentChatCustomerCode) {
                document.getElementById('target-user-code').value = currentChatCustomerCode;
                debounceLookupCustomer(currentChatCustomerCode);
                window.scrollTo({ top: 180, behavior: 'smooth' });
            }
        }

        function loadChatMessages() {
            if (!currentChatCustomerId) return;
            fetch(`/seller/chat/${currentChatCustomerId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const box = document.getElementById('chat-messages-box');
                    if (data.messages.length === 0) {
                        box.innerHTML = `<div style="margin:auto; text-align:center; color:var(--text-sub); font-size:12px;">No messages in this chat yet. Type below to greet the customer!</div>`;
                        return;
                    }
                    box.innerHTML = data.messages.map(m => `
                        <div class="chat-bubble ${m.sender_type}">
                            <div>${escapeHtml(m.message)}</div>
                            <span class="time">${m.time}</span>
                        </div>
                    `).join('');
                    box.scrollTop = box.scrollHeight;
                }
            });
        }

        function sendChatMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input-field');
            const msg = input.value.trim();
            if (!msg || !currentChatCustomerId) return;

            input.value = '';
            fetch('{{ route('seller.chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ customer_id: currentChatCustomerId, message: msg })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    loadChatMessages();
                }
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
