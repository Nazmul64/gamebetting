<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Control Panel — Aviator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:        #05070f;
            --bg-panel:       #0c101e;
            --bg-card:        #111827;
            --accent-primary: #f06424;
            --accent-gold:    #ffbe1a;
            --accent-blue:    #4f8ef7;
            --accent-purple:  #8b5cf6;
            --text-primary:   #f1f5f9;
            --text-muted:     #6b7280;
            --border-subtle:  rgba(255,255,255,0.06);
            --border-active:  rgba(240,100,36,0.5);
            --glass-bg:       rgba(17,24,39,0.85);
            --red:            #ef4444;
            --green:          #22c55e;
        }

        html, body {
            height: 100%;
            font-family: 'Outfit', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            overflow: hidden;
        }

        /* Animated background */
        .admin-bg {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 90% 70% at 30% 20%, rgba(79,142,247,0.12) 0%, transparent 60%),
                        radial-gradient(ellipse 70% 60% at 80% 80%, rgba(139,92,246,0.10) 0%, transparent 60%),
                        radial-gradient(ellipse 50% 50% at 50% 50%, rgba(240,100,36,0.06) 0%, transparent 70%),
                        #05070f;
            z-index: 0;
        }

        /* Animated grid lines */
        .admin-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(79,142,247,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79,142,247,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
            animation: gridScroll 30s linear infinite;
        }

        @keyframes gridScroll {
            0%   { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            z-index: 1;
            animation: orbFloat 12s ease-in-out infinite alternate;
        }
        .orb-1 { width: 400px; height: 400px; background: #4f8ef7; top: -100px; left: -100px; animation-duration: 10s; }
        .orb-2 { width: 300px; height: 300px; background: #8b5cf6; bottom: -80px; right: -80px; animation-duration: 14s; }
        .orb-3 { width: 250px; height: 250px; background: #f06424; top: 50%; right: 15%; animation-duration: 16s; }

        @keyframes orbFloat {
            from { transform: translateY(0) scale(1); }
            to   { transform: translateY(-40px) scale(1.1); }
        }

        /* Main layout */
        .login-page {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Login card */
        .admin-card {
            width: 100%;
            max-width: 440px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 44px 40px 40px;
            position: relative;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.04) inset,
                0 25px 80px rgba(0,0,0,0.5),
                0 0 60px rgba(79,142,247,0.06);
            animation: cardAppear 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Shield badge at top */
        .shield-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: linear-gradient(135deg, #1e3a5f, #0f2040);
            border: 1px solid rgba(79,142,247,0.2);
            margin: 0 auto 24px;
            box-shadow: 0 0 30px rgba(79,142,247,0.2), 0 8px 24px rgba(0,0,0,0.4);
            position: relative;
        }
        .shield-badge i {
            font-size: 30px;
            background: linear-gradient(135deg, #4f8ef7, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .shield-badge::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 19px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(79,142,247,0.4), rgba(139,92,246,0.2), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        /* Heading */
        .admin-card-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }
        .admin-card-subtitle {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }
        .admin-card-subtitle span {
            color: var(--accent-blue);
            font-weight: 600;
        }

        /* Security badge row */
        .security-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 28px;
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }
        .security-row i { color: var(--green); font-size: 10px; }
        .security-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(34,197,94,0.08);
            border: 1px solid rgba(34,197,94,0.15);
            color: var(--green);
            font-size: 10px;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Error banner */
        .error-banner {
            display: none;
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            color: #f87171;
            font-size: 13px;
            line-height: 1.5;
            animation: slideDown 0.3s ease;
        }
        .error-banner i { margin-right: 6px; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Form elements */
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }
        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-input {
            width: 100%;
            padding: 12px 40px 12px 42px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.2); }
        .form-input:focus {
            border-color: var(--accent-blue);
            background: rgba(79,142,247,0.06);
            box-shadow: 0 0 0 3px rgba(79,142,247,0.1);
        }
        .form-input:focus + .input-focus-line {
            width: 100%;
        }
        .input-wrap:focus-within .input-icon { color: var(--accent-blue); }

        /* Password toggle */
        .pass-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 14px;
            transition: color 0.2s;
        }
        .pass-toggle:hover { color: var(--accent-blue); }

        /* Submit button */
        .btn-admin-login {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #4f8ef7);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            box-shadow: 0 4px 20px rgba(79,142,247,0.35);
            position: relative;
            overflow: hidden;
        }
        .btn-admin-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        .btn-admin-login:hover::before { left: 100%; }
        .btn-admin-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 30px rgba(79,142,247,0.5);
        }
        .btn-admin-login:active { transform: translateY(0); }
        .btn-admin-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Footer divider */
        .card-footer-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .card-footer-row a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .card-footer-row a:hover { color: var(--text-primary); }

        /* Logo strip at bottom */
        .logo-strip {
            text-align: center;
            margin-top: 32px;
            font-size: 13px;
            color: rgba(255,255,255,0.25);
            letter-spacing: 0.5px;
        }
        .logo-strip svg { vertical-align: middle; margin-right: 6px; }
        .logo-strip strong { color: rgba(255,255,255,0.4); }

        /* Spin animation */
        @keyframes spin { to { transform: rotate(360deg); } }
        .fa-spin { animation: spin 0.8s linear infinite; }
    </style>
</head>
<body>
    <!-- Animated background -->
    <div class="admin-bg"></div>
    <div class="admin-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-page">
        <div>
            <!-- Login card -->
            <div class="admin-card">
                <!-- Shield icon -->
                <div class="shield-badge">
                    <i class="fas fa-shield-halved"></i>
                </div>

                <h1 class="admin-card-title">Admin Control Panel</h1>
                <p class="admin-card-subtitle">Authorized personnel only &mdash; <span>Aviator Platform</span></p>

                <!-- Security badge -->
                <div class="security-row">
                    <span class="security-pill"><i class="fas fa-lock"></i> SSL ENCRYPTED</span>
                    <span class="security-pill"><i class="fas fa-circle-check"></i> 256-BIT SECURE</span>
                </div>

                <!-- Error banner -->
                <div class="error-banner" id="admin-error-banner">
                    <i class="fas fa-circle-exclamation"></i>
                    <span id="admin-error-text"></span>
                </div>

                <!-- Login Form -->
                <form id="admin-login-form" onsubmit="handleAdminLogin(event)" autocomplete="off">
                    <div class="form-group">
                        <label class="form-label" for="admin-email">Admin Email Address</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="admin-email" class="form-input" placeholder="admin@example.com" required autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="admin-password">Admin Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="admin-password" class="form-input" placeholder="Enter secure password" required autocomplete="current-password">
                            <button type="button" class="pass-toggle" onclick="toggleAdminPass()">
                                <i class="far fa-eye" id="admin-pass-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-admin-login" id="btn-admin-login-submit">
                        <i class="fas fa-unlock-keyhole"></i> ACCESS CONTROL PANEL
                    </button>
                </form>

                <div class="card-footer-row">
                    <i class="fas fa-arrow-left"></i>
                    <a href="{{ route('home') }}">Return to main site</a>
                </div>
            </div>

            <!-- Logo strip -->
            <div class="logo-strip">
                <svg viewBox="0 0 30 30" width="20" height="20" fill="none">
                    <path d="M3 19 L27 11 L19 7 L11 11 Z" fill="#f06424"/>
                    <circle cx="15" cy="14" r="3" fill="#ffbe1a"/>
                </svg>
                <strong>Aviator</strong> Platform &mdash; Admin v2.0
            </div>
        </div>
    </div>

    <script>
        function toggleAdminPass() {
            const input = document.getElementById('admin-password');
            const eye   = document.getElementById('admin-pass-eye');
            if (input.type === 'password') {
                input.type = 'text';
                eye.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                eye.className = 'far fa-eye';
            }
        }

        function handleAdminLogin(e) {
            e.preventDefault();
            const email    = document.getElementById('admin-email').value;
            const password = document.getElementById('admin-password').value;
            const btn      = document.getElementById('btn-admin-login-submit');
            const errBanner = document.getElementById('admin-error-banner');
            const errText   = document.getElementById('admin-error-text');

            errBanner.style.display = 'none';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';

            fetch('{{ route('admin.login.post') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            })
            .then(r => r.json().then(data => ({ status: r.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-unlock-keyhole"></i> ACCESS CONTROL PANEL';

                if ((res.status === 200) && res.body.success) {
                    btn.innerHTML = '<i class="fas fa-check"></i> Access Granted!';
                    btn.style.background = 'linear-gradient(135deg, #16a34a, #22c55e)';
                    window.location.href = res.body.redirect;
                } else {
                    const errors = res.body.errors || ['Authentication failed.'];
                    errText.innerHTML = errors.join('<br>');
                    errBanner.style.display = 'block';
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-unlock-keyhole"></i> ACCESS CONTROL PANEL';
                errText.innerHTML = 'Network connection error. Please try again.';
                errBanner.style.display = 'block';
            });
        }
    </script>
</body>
</html>
