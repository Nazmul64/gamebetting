<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Password Reset Request</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #070e1c;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      color: #e2e8f0;
    }
    .wrapper {
      max-width: 580px;
      margin: 30px auto;
      background: #0f1c34;
      border: 1px solid rgba(0, 242, 254, 0.25);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0,0,0,0.6);
    }
    .header {
      background: linear-gradient(135deg, #0a172e 0%, #0d284f 100%);
      padding: 30px;
      text-align: center;
      border-bottom: 2px solid #00f2fe;
    }
    .brand-title {
      font-size: 26px;
      font-weight: 900;
      letter-spacing: 2px;
      color: #00f2fe;
      text-transform: uppercase;
      margin: 0;
    }
    .content {
      padding: 36px 30px;
      line-height: 1.6;
    }
    .greeting {
      font-size: 18px;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 16px;
    }
    p {
      color: #cbd5e1;
      font-size: 15px;
      margin: 0 0 16px 0;
    }
    .btn-container {
      text-align: center;
      margin: 32px 0;
    }
    .btn-reset {
      display: inline-block;
      background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
      color: #ffffff !important;
      text-decoration: none;
      font-weight: 800;
      font-size: 16px;
      letter-spacing: 1px;
      padding: 14px 34px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 198, 255, 0.4);
      text-transform: uppercase;
    }
    .token-box {
      background: #081121;
      border: 1px dashed rgba(255, 190, 26, 0.4);
      border-radius: 8px;
      padding: 14px;
      text-align: center;
      margin: 20px 0;
    }
    .token-code {
      font-family: monospace;
      font-size: 18px;
      font-weight: 700;
      color: #ffbe1a;
      letter-spacing: 2px;
    }
    .footer {
      background: #091325;
      padding: 20px 30px;
      text-align: center;
      font-size: 12px;
      color: #64748b;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
    .link-alt {
      word-break: break-all;
      color: #38bdf8;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h1 class="brand-title">{{ $siteName ?? config('app.name', 'NexPlayUK') }}</h1>
    </div>
    <div class="content">
      <div class="greeting">Hello {{ $user->name ?? 'Valued Player' }},</div>
      <p>We received a request to reset your account password. Click the secure button below to set a new password:</p>
      
      <div class="btn-container">
        <a href="{{ $resetUrl }}" target="_blank" class="btn-reset">Reset My Password</a>
      </div>

      <p style="font-size: 13px; color: #94a3b8;">
        This password reset link is valid for <strong>60 minutes</strong>. If you did not make this request, you can safely ignore this email and your password will remain unchanged.
      </p>

      <div class="token-box">
        <div style="font-size: 11px; text-transform: uppercase; color: #94a3b8; margin-bottom: 6px;">Direct Reset Link</div>
        <a href="{{ $resetUrl }}" class="link-alt">{{ $resetUrl }}</a>
      </div>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} {{ $siteName ?? config('app.name', 'NexPlayUK') }}. All rights reserved. Secure Gaming System.
    </div>
  </div>
</body>
</html>
