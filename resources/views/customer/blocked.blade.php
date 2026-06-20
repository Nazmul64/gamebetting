<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Blocked — 1XGAMES</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-deep: #05070f;
            --bg-card: rgba(13, 18, 37, 0.45);
            --border-glow: rgba(239, 68, 68, 0.2);
            --accent-red: #ef4444;
            --accent-orange: #f97316;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Ambient background glow */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            pointer-events: none;
        }

        .blocked-container {
            max-width: 520px;
            width: 100%;
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1px solid var(--border-glow);
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(239, 68, 68, 0.05);
            z-index: 2;
            position: relative;
            animation: cardIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            position: relative;
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .icon-wrap i {
            font-size: 36px;
            color: var(--accent-red);
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
            background: linear-gradient(135deg, #fff 0%, #f1f5f9 50%, var(--accent-red) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
        }

        .message {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .support-info-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }

        .support-info-card i {
            color: var(--accent-orange);
            font-size: 18px;
        }

        .actions-row {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-red), #b91c1c);
            color: #fff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-1.5px);
        }

        .footer-text {
            margin-top: 32px;
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Profile & Check-In Animation Styles */
        .profile-card-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 28px;
            perspective: 1000px;
            cursor: pointer;
        }

        .profile-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }

        .profile-card-wrapper.flipped .profile-card-inner {
            transform: rotateY(180deg);
        }

        .profile-card-front, .profile-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            border: 3px solid rgba(255, 255, 255, 0.1);
        }

        .profile-card-front {
            background: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            border-color: rgba(239, 68, 68, 0.3);
            transition: border-color 0.3s;
        }

        .profile-card-front:hover {
            border-color: rgba(239, 68, 68, 0.8);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .profile-card-front:hover .profile-avatar-img {
            transform: scale(1.1);
        }

        .profile-card-back {
            background: #000;
            transform: rotateY(180deg);
            border-color: rgba(46, 189, 89, 0.3);
        }

        .checkin-btn-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.2s, filter 0.3s;
        }

        .checkin-btn-img:hover {
            transform: scale(1.05);
            filter: brightness(1.15);
        }

        .checkin-btn-img:active {
            transform: scale(0.95);
        }

        /* Progress Bar Container */
        .checkin-progress-container {
            width: 100%;
            max-width: 380px;
            margin: 20px auto 0;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 14px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            pointer-events: none;
            display: none;
        }

        .checkin-progress-container.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .progress-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .progress-status-text {
            color: #ffbe1a;
        }

        .progress-bar-wrapper {
            position: relative;
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            box-shadow: 0 0 10px rgba(255, 75, 43, 0.5);
            border-radius: 4px;
            transition: width 0.1s linear;
        }
    </style>
</head>
<body>

    <div class="blocked-container">
        <!-- Interactive profile picture & check-in button wrapper -->
        <div class="profile-card-wrapper" id="profile-card" onclick="flipCard()">
            <div class="profile-card-inner">
                <!-- Front Side: User Profile Avatar -->
                <div class="profile-card-front">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&h=150&fit=crop" class="profile-avatar-img" alt="Profile Picture">
                </div>
                <!-- Back Side: Check-in button image -->
                <div class="profile-card-back" onclick="event.stopPropagation(); triggerCheckIn();">
                    <img src="{{ asset('assets/image/checkin-btn.png') }}" class="checkin-btn-img" alt="Check In Button">
                </div>
            </div>
        </div>

        <h1 class="title">Account Suspended</h1>
        <p class="message" id="blocked-message">
            Your account has been temporarily restricted or blocked. Click on your profile picture above to complete the daily verification check-in.
        </p>

        <!-- Progress bar shown when user clicks check-in -->
        <div class="checkin-progress-container" id="checkin-progress-container">
            <div class="progress-label-row">
                <span id="progress-status-text">Verifying security signature...</span>
                <span id="progress-percent">0%</span>
            </div>
            <div class="progress-bar-wrapper">
                <div class="progress-bar-fill" id="progress-bar-fill"></div>
            </div>
        </div>

        <div class="support-info-card">
            <i class="fas fa-headset"></i>
            <span>Please contact support for assistance.</span>
        </div>

        <div class="actions-row">
            <button onclick="openChat()" class="btn btn-primary">
                <i class="fas fa-comments"></i> Live Support Chat
            </button>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <div class="footer-text">
            Aviator Control Panel &copy; 2026
        </div>
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Floating Live Support Chat inside Blocked page -->
    <div id="blocked-chat-wrapper" style="display:none;">
        @include('frontend.welcome')
    </div>

    <script>
        function openChat() {
            // Trigger simple contact alert or custom email link if chat is not present, 
            // or redirect to support page.
            alert("Support Desk: admin@gmail.com\nPlease email our support desk or refresh if resolving verification.");
        }

        let isFlipped = false;
        let isCheckingIn = false;

        function flipCard() {
            if (isFlipped) return;
            const card = document.getElementById('profile-card');
            card.classList.add('flipped');
            isFlipped = true;
            
            // Show check-in instructions or status change
            document.getElementById('blocked-message').innerHTML = 'Verifying session and activating your account...';
        }

        function triggerCheckIn() {
            if (isCheckingIn) return;
            isCheckingIn = true;

            const progressContainer = document.getElementById('checkin-progress-container');
            const progressFill = document.getElementById('progress-bar-fill');
            const progressPercent = document.getElementById('progress-percent');
            const statusText = document.getElementById('progress-status-text');

            progressContainer.classList.add('show');
            
            let width = 0;
            statusText.innerText = 'Initializing Check-In...';
            
            const interval = setInterval(() => {
                // Increased step size and reduced interval for faster load (approx 500-600ms)
                width += Math.floor(Math.random() * 8) + 6;
                if (width >= 100) {
                    width = 100;
                    clearInterval(interval);
                    
                    statusText.innerText = 'Verification Successful!';
                    progressPercent.innerText = '100%';
                    progressFill.style.width = '100%';
                    progressFill.style.background = 'linear-gradient(90deg, #2ebd59, #38ef7d)';
                    progressFill.style.boxShadow = '0 0 10px rgba(56, 239, 125, 0.8)';
                    
                    // Trigger backend AJAX call to unblock
                    setTimeout(() => {
                        fetch('{{ route('blocked.checkin') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Redirect to dashboard
                                window.location.href = '{{ route('dashboard') }}';
                            } else {
                                alert('Error during unblocking. Please contact support.');
                                isCheckingIn = false;
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Network error. Please try again.');
                            isCheckingIn = false;
                        });
                    }, 400);
                } else {
                    progressFill.style.width = width + '%';
                    progressPercent.innerText = width + '%';
                    
                    if (width > 30 && width < 70) {
                        statusText.innerText = 'Syncing session status...';
                    } else if (width >= 70) {
                        statusText.innerText = 'Unlocking privileges...';
                    }
                }
            }, 40);
        }

        // Auto-start verification sequence on load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                flipCard();
                setTimeout(triggerCheckIn, 400);
            }, 300);
        });
    </script>
</body>
</html>
