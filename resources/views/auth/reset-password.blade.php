@php
    $siteName = \App\Models\Setting::getVal('site_name', 'NexPlayUK');
    $siteLogo = \App\Models\Setting::getVal('site_logo');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteName }} — Reset Password</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #070e1c;
            --bg-card: rgba(13, 24, 48, 0.95);
            --accent-cyan: #00f2fe;
            --accent-blue: #007bff;
            --accent-green: #2ebd59;
            --accent-gold: #ffbe1a;
            --text-primary: #ffffff;
            --text-secondary: #8ca3c7;
            --border-color: rgba(0, 198, 255, 0.2);
            --input-bg: #091326;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 123, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(0, 242, 254, 0.12) 0%, transparent 40%);
        }

        .auth-topbar {
            height: 64px;
            background: rgba(10, 20, 38, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--accent-cyan);
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .card-box {
            width: 100%;
            max-width: 440px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 36px 30px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.7), 0 0 25px rgba(0, 242, 254, 0.15);
        }

        .card-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(0,242,254,0.15), rgba(0,123,255,0.25));
            border: 1px solid var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--accent-cyan);
        }

        .card-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            height: 46px;
            background: var(--input-bg);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #fff;
            padding: 0 14px 0 42px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-cyan);
            box-shadow: 0 0 10px rgba(0, 242, 254, 0.25);
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 1px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(0, 198, 255, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 198, 255, 0.45);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert-box {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(46, 189, 89, 0.15);
            border: 1px solid #2ebd59;
            color: #86efac;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .back-link:hover {
            color: var(--accent-cyan);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header class="auth-topbar">
        <a href="{{ route('home') }}" class="auth-brand">
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}">
            @else
                <span>{{ $siteName }}</span>
            @endif
        </a>
        <a href="{{ route('login') }}" class="back-link" style="margin-top:0;">Back to Login</a>
    </header>

    <div class="main-container">
        <div class="card-box">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-lock"></i></div>
                <h2 class="card-title">Set New Password</h2>
                <p class="card-desc">Enter your email and create a new secure password for your account.</p>
            </div>

            <div id="alert-box" class="alert-box"></div>

            <form id="reset-password-form" onsubmit="handleResetSubmit(event)">
                <input type="hidden" id="reset-token" value="{{ $token }}">

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="reset-email" class="form-input" value="{{ $email }}" placeholder="your@email.com" required {{ $email ? 'readonly' : '' }}>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-key"></i>
                        <input type="password" id="reset-password" class="form-input" placeholder="Min. 6 characters" minlength="6" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-halved"></i>
                        <input type="password" id="reset-password-confirmation" class="form-input" placeholder="Repeat new password" minlength="6" required>
                    </div>
                </div>

                <button type="submit" id="btn-submit" class="btn-submit">
                    <i class="fas fa-check-circle"></i> <span>RESET PASSWORD</span>
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-link">&larr; Return to Sign In</a>
        </div>
    </div>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showAlert(msg, isError = true) {
            const el = document.getElementById('alert-box');
            el.className = 'alert-box ' + (isError ? 'alert-error' : 'alert-success');
            el.innerHTML = `<i class="fas ${isError ? 'fa-circle-exclamation' : 'fa-circle-check'}"></i> <span>${msg}</span>`;
            el.style.display = 'flex';
        }

        function handleResetSubmit(e) {
            e.preventDefault();
            const token = document.getElementById('reset-token').value;
            const email = document.getElementById('reset-email').value;
            const password = document.getElementById('reset-password').value;
            const password_confirmation = document.getElementById('reset-password-confirmation').value;
            const btn = document.getElementById('btn-submit');

            if (password !== password_confirmation) {
                showAlert('Passwords do not match. Please re-enter.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Resetting...</span>';

            fetch('{{ route('password.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    token,
                    email,
                    password,
                    password_confirmation
                })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle"></i> <span>RESET PASSWORD</span>';

                if (data.success) {
                    showAlert(data.message, false);
                    setTimeout(() => {
                        window.location.href = data.redirect || '{{ route('login') }}';
                    }, 2000);
                } else {
                    showAlert((data.errors || [data.message || 'Error resetting password']).join(' '));
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle"></i> <span>RESET PASSWORD</span>';
                showAlert('Network error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>
