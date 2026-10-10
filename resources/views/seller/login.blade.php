<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller / Agent Portal — 1XGAMES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #070e1c;
            --card-bg: rgba(13, 24, 48, 0.95);
            --accent-cyan: #00f2fe;
            --accent-blue: #2563eb;
            --accent-gold: #f59e0b;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg-dark);
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(0, 242, 254, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(37, 99, 235, 0.1) 0%, transparent 40%);
        }
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(0, 242, 254, 0.1);
            backdrop-filter: blur(20px);
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid rgba(0, 242, 254, 0.3);
            color: var(--accent-cyan);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        h1 { font-size: 26px; font-weight: 800; margin-bottom: 8px; color: #fff; }
        p.subtitle { font-size: 13.5px; color: var(--text-secondary); margin-bottom: 28px; line-height: 1.5; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 12px; font-weight: 700; color: #cbd5e1; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 14px; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 13px 16px 13px 44px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }
        input:focus { border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0, 242, 254, 0.25); background: rgba(255, 255, 255, 0.07); }
        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #00f2fe, #2563eb);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 8px 25px rgba(0, 242, 254, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0, 242, 254, 0.45); }
        .error-box {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-badge">
            <i class="fas fa-handshake"></i> Verified Agent Network
        </div>
        <h1>Seller / Agent Login</h1>
        <p class="subtitle">Access your reseller workstation to manage live customer balances, transfers, and direct support.</p>

        @if($errors->any())
            <div class="error-box">
                <i class="fas fa-triangle-exclamation"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form action="{{ route('seller.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Seller Account Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="agent@1xgames.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:12.5px; color:var(--text-secondary);">
                <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; text-transform:none; font-size:12.5px; margin:0;">
                    <input type="checkbox" name="remember" style="accent-color:var(--accent-cyan);"> Keep me logged in
                </label>
                <a href="{{ route('home') }}" style="color:var(--accent-cyan); text-decoration:none; font-weight:600;">Main Lobby <i class="fas fa-arrow-right"></i></a>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-right-to-bracket"></i> Login to Agent Dashboard
            </button>
        </form>
    </div>
</body>
</html>
