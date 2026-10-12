@php
    $siteName = \App\Models\Setting::getVal('site_name', '1XBET');
    $siteLogo = \App\Models\Setting::getVal('site_logo');
    $referredBy = $referredBy ?? session('referred_by');
    $defaultTab = $activeTab ?? (request()->is('register*') || request()->query('tab') === 'signup' ? 'signup' : 'login');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteName }} — Login &amp; Registration</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
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
            --border-color: rgba(0, 198, 255, 0.15);
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
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 123, 255, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(0, 242, 254, 0.10) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(46, 189, 89, 0.05) 0%, transparent 60%);
        }

        /* Top Brand Header */
        .auth-topbar {
            height: 64px;
            background: rgba(10, 20, 38, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .auth-brand img {
            max-height: 38px;
            max-width: 150px;
            object-fit: contain;
        }

        .auth-brand-text {
            font-style: italic;
            font-weight: 900;
            font-size: 26px;
            letter-spacing: -0.5px;
            color: #1a76d2;
            text-transform: uppercase;
        }

        .auth-topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-country {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 230, 118, 0.1);
            border: 1px solid rgba(0, 230, 118, 0.3);
            color: #00e676;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
        }

        .btn-sellers-header {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
            border: none;
            padding: 0 16px;
            height: 36px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }

        .btn-sellers-header:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.45);
        }

        /* Main Centered Content */
        .auth-main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .auth-card {
            background: var(--bg-card);
            border: 1.5px solid var(--border-color);
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(0, 198, 255, 0.08);
            backdrop-filter: blur(20px);
            overflow: hidden;
            animation: fadeInCard 0.35s ease;
        }

        @keyframes fadeInCard {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card-header {
            padding: 28px 28px 20px 28px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: linear-gradient(180deg, rgba(0, 123, 255, 0.08) 0%, transparent 100%);
        }

        .auth-card-title {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .auth-card-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 400;
        }

        /* Segmented Navigation Tabs */
        .auth-tabs {
            display: flex;
            background: rgba(9, 19, 38, 0.8);
            border-bottom: 1.5px solid rgba(0, 198, 255, 0.15);
            padding: 6px;
            gap: 6px;
        }

        .auth-tab-btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            background: transparent;
            color: #8ca3c7;
            font-weight: 800;
            font-size: 13.5px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .auth-tab-btn.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 123, 255, 0.4);
        }

        .auth-tab-btn.active.tab-signup {
            background: linear-gradient(135deg, #2ebd59 0%, #1e823d 100%);
            box-shadow: 0 4px 14px rgba(46, 189, 89, 0.4);
        }

        /* Form Body */
        .auth-body {
            padding: 28px;
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
            animation: fadeInForm 0.25s ease;
        }

        @keyframes fadeInForm {
            from { opacity: 0; transform: scale(0.98); }
            to { opacity: 1; transform: scale(1); }
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #64748b;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            height: 46px;
            background: var(--input-bg);
            border: 1.5px solid #1a2942;
            border-radius: 10px;
            padding: 0 16px 0 42px;
            color: #ffffff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.25);
            background: #0d1a33;
        }

        .form-input:focus + .input-icon,
        .input-wrap:focus-within .input-icon {
            color: #00f2fe;
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238ca3c7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
            cursor: pointer;
        }

        .toggle-pwd {
            position: absolute;
            right: 14px;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
            padding: 6px;
        }

        .toggle-pwd:hover {
            color: #cbd5e1;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-checkbox-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            accent-color: #007bff;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: #00f2fe;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            text-decoration: underline;
            color: #38bdf8;
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 14.5px;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.35);
        }

        .btn-submit.btn-signup-submit {
            background: linear-gradient(135deg, #2ebd59 0%, #1e823d 100%);
            box-shadow: 0 6px 20px rgba(46, 189, 89, 0.35);
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.5);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .auth-switch-text {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .auth-switch-text span {
            color: #00f2fe;
            font-weight: 700;
            cursor: pointer;
            margin-left: 4px;
        }

        .auth-switch-text span:hover {
            text-decoration: underline;
        }

        /* Alert Banners */
        .alert-banner {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            margin-bottom: 18px;
            display: none;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(46, 189, 89, 0.15);
            border: 1px solid #2ebd59;
            color: #86efac;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            padding: 20px;
            font-size: 11.5px;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .auth-topbar {
                padding: 0 16px;
                height: 58px;
            }
            .auth-card {
                border-radius: 16px;
            }
            .auth-body {
                padding: 20px;
            }
            .form-row-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Top Branding Navbar -->
    <header class="auth-topbar">
        <a href="{{ route('home') }}" class="auth-brand">
            @if($siteLogo && file_exists(public_path($siteLogo)))
                <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}">
            @else
                <span class="auth-brand-text">
                    <span style="color: #ffffff;">1X</span>BET
                </span>
            @endif
        </a>

        <div class="auth-topbar-right">
            <span class="badge-country">🇧🇩 BANGLADESH</span>
            <button onclick="openSellerAgentsModal()" class="btn-sellers-header" type="button">
                <i class="fas fa-user-tie"></i> <span>SELLERS / AGENTS</span>
            </button>
        </div>
    </header>

    <!-- Centered Form Container -->
    <main class="auth-main-container">
        <div class="auth-card">
            
            <div class="auth-card-header">
                <h1 class="auth-card-title">{{ $siteName }} Official Portal</h1>
                <p class="auth-card-subtitle">Login or register to access the Casino &amp; Games Lobby</p>
            </div>

            <!-- Segmented Switcher Tabs -->
            <div class="auth-tabs">
                <button type="button" class="auth-tab-btn {{ $defaultTab === 'login' ? 'active' : '' }}" id="btn-tab-login" onclick="switchAuthTab('login')">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <button type="button" class="auth-tab-btn tab-signup {{ $defaultTab === 'signup' ? 'active' : '' }}" id="btn-tab-signup" onclick="switchAuthTab('signup')">
                    <i class="fas fa-user-plus"></i> Registration
                </button>
            </div>

            <div class="auth-body">
                
                <!-- Shared Error / Success Alerts -->
                <div id="auth-alert-error" class="alert-banner alert-danger">
                    <i class="fas fa-circle-exclamation" style="font-size:16px;"></i>
                    <div id="auth-alert-error-msg"></div>
                </div>
                <div id="auth-alert-success" class="alert-banner alert-success">
                    <i class="fas fa-circle-check" style="font-size:16px;"></i>
                    <div id="auth-alert-success-msg"></div>
                </div>

                <!-- 1. LOGIN FORM -->
                <form id="login-form" class="auth-form {{ $defaultTab === 'login' ? 'active' : '' }}" onsubmit="handleLoginSubmit(event)">
                    <div class="form-group">
                        <label class="form-label" for="login-username">Email or Mobile Number</label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="login-username" class="form-input" placeholder="e.g. 01700000000 or user@example.com" required autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="login-password">Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="login-password" class="form-input" placeholder="Enter your password" required autocomplete="current-password">
                            <button type="button" class="toggle-pwd" onclick="togglePasswordVisibility('login-password', this)">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-checkbox-row">
                        <label class="checkbox-label">
                            <input type="checkbox" id="login-remember" checked>
                            <span>Remember Me</span>
                        </label>
                        <a href="javascript:void(0)" onclick="openForgotModal()" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" id="btn-login-submit" class="btn-submit">
                        <i class="fas fa-right-to-bracket"></i> <span>LOGIN TO PLAY</span>
                    </button>

                    <div class="auth-switch-text">
                        Don't have an account? <span onclick="switchAuthTab('signup')">Register Now</span>
                    </div>
                </form>

                <!-- 2. REGISTRATION FORM -->
                <form id="signup-form" class="auth-form {{ $defaultTab === 'signup' ? 'active' : '' }}" onsubmit="handleSignupSubmit(event)">
                    <div class="form-group">
                        <label class="form-label" for="signup-name">Full Name</label>
                        <div class="input-wrap">
                            <i class="fas fa-user-circle input-icon"></i>
                            <input type="text" id="signup-name" class="form-input" placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label" for="signup-gender">Gender</label>
                            <div class="input-wrap">
                                <i class="fas fa-venus-mars input-icon"></i>
                                <select id="signup-gender" class="form-input">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="signup-mobile">Mobile Number</label>
                            <div class="input-wrap">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" id="signup-mobile" class="form-input" placeholder="01700000000" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="signup-email">Email Address</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="signup-email" class="form-input" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="signup-password">Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="signup-password" class="form-input" placeholder="Minimum 6 characters" required autocomplete="new-password">
                            <button type="button" class="toggle-pwd" onclick="togglePasswordVisibility('signup-password', this)">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label" for="signup-country">Country</label>
                            <div class="input-wrap">
                                <i class="fas fa-globe input-icon"></i>
                                <select id="signup-country" class="form-input">
                                    <option value="Bangladesh" selected>Bangladesh 🇧🇩</option>
                                    <option value="India">India 🇮🇳</option>
                                    <option value="Pakistan">Pakistan 🇵🇰</option>
                                    <option value="United Kingdom">United Kingdom 🇬🇧</option>
                                    <option value="United States">United States 🇺🇸</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="signup-currency">Currency</label>
                            <div class="input-wrap">
                                <i class="fas fa-coins input-icon"></i>
                                <select id="signup-currency" class="form-input">
                                    <option value="BDT" selected>BDT (৳)</option>
                                    <option value="INR">INR (₹)</option>
                                    <option value="USD">USD ($)</option>
                                    <option value="GBP">GBP (£)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="signup-ref">Referral / Promo Code (Optional)</label>
                        <div class="input-wrap">
                            <i class="fas fa-gift input-icon"></i>
                            <input type="text" id="signup-ref" class="form-input" placeholder="Referral Code" value="{{ $referredBy }}">
                        </div>
                    </div>

                    <div class="form-checkbox-row">
                        <label class="checkbox-label">
                            <input type="checkbox" required checked>
                            <span style="font-size: 11.5px;">I am 18+ and accept the Terms &amp; Conditions</span>
                        </label>
                    </div>

                    <button type="submit" id="btn-signup-submit" class="btn-submit btn-signup-submit">
                        <i class="fas fa-user-plus"></i> <span>CREATE ACCOUNT &amp; PLAY</span>
                    </button>

                    <div class="auth-switch-text">
                        Already have an account? <span onclick="switchAuthTab('login')">Login Here</span>
                    </div>
                </form>

            </div>

            <div class="auth-footer">
                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved. 18+ Play Responsibly.
            </div>
        </div>
    </main>

    <!-- Sellers & Agents Modal for Login Page -->
    <div class="modal-overlay" id="seller-agents-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,10,20,0.85); z-index:100000; padding:16px; box-sizing:border-box; backdrop-filter:blur(6px); font-family:'Outfit','Inter',sans-serif;">
        <div class="modal-box" style="max-width:760px; width:100%; max-height:90vh; display:flex; flex-direction:column; position:relative; background:#0a1628; border-radius:16px; border:1.5px solid #1d3354; padding:24px; box-shadow:0 25px 60px rgba(0,0,0,0.9);">
            <button class="modal-close" onclick="closeSellerAgentsModal()" style="position:absolute; top:18px; right:18px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fas fa-times"></i></button>
            
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #1d3354;">
                <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg, #0284c7, #00f2fe); display:flex; align-items:center; justify-content:center; color:#fff; font-size:20px; box-shadow:0 4px 15px rgba(2,132,199,0.4);">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <h3 style="margin:0; font-size:18px; font-weight:800; color:#fff;">ভেরিফাইড সেলার ও এজেন্ট সেন্টার</h3>
                    <p style="margin:2px 0 0; font-size:12px; color:#8ca3c7;">যেকোনো এজেন্টের সাথে যোগাযোগ করে নগদ, বিকাশ বা রকেটে ইনস্ট্যান্ট একাউন্ট রিচার্জ করুন।</p>
                </div>
            </div>

            <div id="seller-agents-list-grid" style="flex:1; overflow-y:auto; display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:14px; padding-right:4px;">
                <!-- Dynamically loaded seller cards -->
            </div>
        </div>
    </div>

    <script>
        function switchAuthTab(tab) {
            const btnLogin = document.getElementById('btn-tab-login');
            const btnSignup = document.getElementById('btn-tab-signup');
            const formLogin = document.getElementById('login-form');
            const formSignup = document.getElementById('signup-form');
            hideAlerts();

            if (tab === 'signup') {
                btnLogin.classList.remove('active');
                btnSignup.classList.add('active');
                formLogin.classList.remove('active');
                formSignup.classList.add('active');
                window.history.replaceState(null, '', '{{ route("register") }}');
            } else {
                btnSignup.classList.remove('active');
                btnLogin.classList.add('active');
                formSignup.classList.remove('active');
                formLogin.classList.add('active');
                window.history.replaceState(null, '', '{{ route("login") }}');
            }
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function hideAlerts() {
            document.getElementById('auth-alert-error').style.display = 'none';
            document.getElementById('auth-alert-success').style.display = 'none';
        }

        function showError(msg) {
            const errBox = document.getElementById('auth-alert-error');
            const errMsg = document.getElementById('auth-alert-error-msg');
            document.getElementById('auth-alert-success').style.display = 'none';
            errMsg.innerHTML = msg;
            errBox.style.display = 'flex';
        }

        function showSuccess(msg) {
            const succBox = document.getElementById('auth-alert-success');
            const succMsg = document.getElementById('auth-alert-success-msg');
            document.getElementById('auth-alert-error').style.display = 'none';
            succMsg.innerHTML = msg;
            succBox.style.display = 'flex';
        }

        // Login Submit Handler
        function handleLoginSubmit(e) {
            e.preventDefault();
            hideAlerts();

            const submitBtn = document.getElementById('btn-login-submit');
            const originalHtml = submitBtn.innerHTML;
            const username = document.getElementById('login-username').value.trim();
            const password = document.getElementById('login-password').value;
            const remember = document.getElementById('login-remember').checked;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';

            fetch('{{ route("login.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password,
                    remember: remember
                })
            })
            .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, body: data })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;

                if (res.body.success) {
                    showSuccess('Login successful! Redirecting to dashboard...');
                    setTimeout(() => {
                        window.location.href = res.body.redirect || '{{ route("dashboard") }}';
                    }, 400);
                } else {
                    const errors = res.body.errors ? res.body.errors.join('<br>') : (res.body.message || 'Login failed.');
                    showError(errors);
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                showError('Network error. Please try again.');
            });
        }

        // Signup Submit Handler
        function handleSignupSubmit(e) {
            e.preventDefault();
            hideAlerts();

            const submitBtn = document.getElementById('btn-signup-submit');
            const originalHtml = submitBtn.innerHTML;

            const name = document.getElementById('signup-name').value.trim();
            const gender = document.getElementById('signup-gender').value;
            const mobile = document.getElementById('signup-mobile').value.trim();
            const email = document.getElementById('signup-email').value.trim();
            const password = document.getElementById('signup-password').value;
            const country = document.getElementById('signup-country').value;
            const currency = document.getElementById('signup-currency').value;
            const ref = document.getElementById('signup-ref').value.trim();

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating account...';

            fetch('{{ route("register.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    gender: gender,
                    mobile: mobile,
                    email: email,
                    password: password,
                    country: country,
                    currency: currency,
                    referred_by: ref
                })
            })
            .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, body: data })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;

                if (res.body.success) {
                    showSuccess('Registration successful! Redirecting to dashboard...');
                    setTimeout(() => {
                        window.location.href = res.body.redirect || '{{ route("dashboard") }}';
                    }, 400);
                } else {
                    const errors = res.body.errors ? res.body.errors.join('<br>') : (res.body.message || 'Registration failed.');
                    showError(errors);
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            });
        }

        function openSellerAgentsModal() {
            const modal = document.getElementById('seller-agents-modal');
            if (!modal) return;
            modal.style.display = 'flex';
            loadActiveSellers();
        }

        function closeSellerAgentsModal() {
            const modal = document.getElementById('seller-agents-modal');
            if (modal) modal.style.display = 'none';
        }

        function loadActiveSellers() {
            const grid = document.getElementById('seller-agents-list-grid');
            if (!grid) return;
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#8ca3c7;"><i class="fas fa-spinner fa-spin"></i> ভেরিফাইড সেলার ও এজেন্ট তালিকা লোড হচ্ছে...</div>';

            fetch('/seller/active-list', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.sellers && data.sellers.length > 0) {
                    grid.innerHTML = data.sellers.map(s => {
                        const photo = s.seller_photo || '{{ asset("uploads/agent_profile_pictures/default_agent.png") }}';
                        return `
                            <div style="background:#11223b; border:1.5px solid #1d3354; border-radius:12px; padding:16px; display:flex; flex-direction:column; gap:12px;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <img src="${photo}" alt="${s.name}" style="width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid #00f2fe; background:#0c1a30;" onerror="this.src='{{ asset("uploads/agent_profile_pictures/default_agent.png") }}'">
                                    <div style="flex:1; min-width:0;">
                                        <div style="font-weight:800; color:#ffffff; font-size:14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${s.name}</div>
                                        <div style="font-size:11px; color:#34d399; font-weight:700; margin-top:2px;">
                                            <i class="fas fa-certificate" style="color:#00f2fe;"></i> ভেরিফাইড এজেন্ট
                                        </div>
                                        ${s.seller_phone ? `<div style="font-size:11px; color:#8ca3c7; margin-top:2px; font-family:'Roboto Mono',monospace;"><i class="fas fa-phone-alt"></i> ${s.seller_phone}</div>` : ''}
                                    </div>
                                </div>
                                <div style="background:rgba(0,242,254,0.06); border:1px solid rgba(0,242,254,0.2); border-radius:8px; padding:8px 10px; font-size:11.5px; color:#cbd5e1; display:flex; justify-content:space-between; align-items:center;">
                                    <span>ব্যালেন্স লোড:</span>
                                    <span style="color:#38ef7d; font-weight:800;">ইনস্ট্যান্ট ক্যাশ ইন</span>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#8ca3c7;"><i class="fas fa-user-slash" style="font-size:24px; margin-bottom:8px; display:block;"></i> বর্তমানে কোন এজেন্ট একটিভ নেই।</div>';
                }
            })
            .catch(() => {
                grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:#f87171;">এজেন্টদের তালিকা লোড করতে ব্যর্থ হয়েছে।</div>';
            });
        }

        function openForgotModal() {
            const modal = document.getElementById('forgot-modal');
            if (!modal) return;
            modal.style.display = 'flex';
            const alertBox = document.getElementById('forgot-alert');
            if (alertBox) alertBox.style.display = 'none';
            const input = document.getElementById('forgot-email');
            if (input) {
                // If login username is an email, prefill it
                const loginUser = document.getElementById('login-username')?.value;
                if (loginUser && loginUser.includes('@')) {
                    input.value = loginUser;
                }
                setTimeout(() => input.focus(), 100);
            }
        }

        function closeForgotModal() {
            const modal = document.getElementById('forgot-modal');
            if (modal) modal.style.display = 'none';
        }

        function handleForgotSubmit(e) {
            e.preventDefault();
            const email = document.getElementById('forgot-email').value;
            const btn = document.getElementById('btn-forgot-submit');
            const alertBox = document.getElementById('forgot-alert');
            const originalBtnHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Sending Email...</span>';
            alertBox.style.display = 'none';

            fetch('{{ route('password.email') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;

                if (data.success) {
                    alertBox.style.background = 'rgba(46, 189, 89, 0.15)';
                    alertBox.style.border = '1px solid #2ebd59';
                    alertBox.style.color = '#86efac';
                    alertBox.innerHTML = '<i class="fas fa-circle-check"></i> ' + data.message;
                    alertBox.style.display = 'block';
                    document.getElementById('forgot-email').value = '';
                } else {
                    alertBox.style.background = 'rgba(239, 68, 68, 0.15)';
                    alertBox.style.border = '1px solid #ef4444';
                    alertBox.style.color = '#fca5a5';
                    alertBox.innerHTML = '<i class="fas fa-circle-exclamation"></i> ' + (data.errors ? data.errors.join(' ') : (data.message || 'Error occurred.'));
                    alertBox.style.display = 'block';
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                alertBox.style.background = 'rgba(239, 68, 68, 0.15)';
                alertBox.style.border = '1px solid #ef4444';
                alertBox.style.color = '#fca5a5';
                alertBox.innerHTML = '<i class="fas fa-circle-exclamation"></i> Network error occurred. Please try again.';
                alertBox.style.display = 'block';
            });
        }
    </script>

    <!-- FORGOT PASSWORD MODAL -->
    <div id="forgot-modal" style="display:none; position:fixed; inset:0; background:rgba(4, 9, 20, 0.85); backdrop-filter:blur(10px); z-index:99999; align-items:center; justify-content:center; padding:16px;">
        <div class="auth-card" style="max-width:440px; width:100%; border:1px solid rgba(0, 242, 254, 0.4); position:relative; box-shadow:0 15px 50px rgba(0,0,0,0.8), 0 0 35px rgba(0,242,254,0.25); background:var(--bg-card); border-radius:18px; padding:32px 28px;">
            <button type="button" onclick="closeForgotModal()" style="position:absolute; top:18px; right:18px; background:none; border:none; color:#8ca3c7; font-size:22px; cursor:pointer; line-height:1;"><i class="fas fa-times"></i></button>
            
            <div style="text-align:center; margin-bottom:22px;">
                <div style="width:56px; height:56px; margin:0 auto 14px; border-radius:50%; background:linear-gradient(135deg, rgba(0,242,254,0.18), rgba(0,123,255,0.25)); border:1.5px solid var(--accent-cyan); display:flex; align-items:center; justify-content:center; color:var(--accent-cyan); font-size:24px; box-shadow:0 0 15px rgba(0,242,254,0.3);">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h3 style="font-size:22px; font-weight:800; color:#fff; margin-bottom:6px; letter-spacing:-0.3px;">Forgot Password?</h3>
                <p style="font-size:13px; color:var(--text-secondary); line-height:1.5;">Enter your registered account email address. We'll send you a secure link to reset your password.</p>
            </div>

            <div id="forgot-alert" style="display:none; padding:12px 14px; border-radius:8px; font-size:13px; margin-bottom:18px; line-height:1.4;"></div>

            <form id="forgot-form" onsubmit="handleForgotSubmit(event)">
                <div class="form-group" style="margin-bottom:20px;">
                    <label class="form-label" for="forgot-email" style="font-size:11.5px; font-weight:700; color:#cbd5e1; text-transform:uppercase; margin-bottom:6px; display:block;">Account Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="forgot-email" class="form-input" placeholder="name@example.com" required autocomplete="email">
                    </div>
                </div>

                <button type="submit" id="btn-forgot-submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> <span>SEND RESET LINK</span>
                </button>
            </form>

            <div style="text-align:center; margin-top:20px;">
                <a href="javascript:void(0)" onclick="closeForgotModal()" style="color:var(--text-secondary); font-size:13px; font-weight:600; text-decoration:none;">
                    &larr; Back to Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
