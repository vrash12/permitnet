<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PermitNet Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Work Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --blue: #1293ee;
            --blue-dark: #0878c8;
            --blue-soft: #eaf6ff;
            --white: #ffffff;
            --text: #07111f;
            --muted: #667085;
            --border: #d8e8f8;
            --danger-bg: #fee2e2;
            --danger: #dc2626;
            --success-bg: #dcfce7;
            --success: #16a34a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Work Sans', Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 15%, rgba(18, 147, 238, 0.25), transparent 28%),
                radial-gradient(circle at 90% 20%, rgba(120, 183, 233, 0.35), transparent 26%),
                linear-gradient(135deg, #eef8ff 0%, #ffffff 45%, #eaf6ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
            overflow-x: hidden;
        }

        .login-shell {
            width: 100%;
            max-width: 1120px;
            min-height: 650px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(8, 120, 200, 0.22);
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            overflow: hidden;
            backdrop-filter: blur(18px);
        }

        .hero-panel {
            position: relative;
            padding: 48px;
            background:
                linear-gradient(135deg, rgba(18, 147, 238, 0.96), rgba(8, 120, 200, 0.96)),
                radial-gradient(circle at top right, rgba(255,255,255,0.4), transparent 35%);
            color: white;
            overflow: hidden;
        }

        .hero-panel::before,
        .hero-panel::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.13);
        }

        .hero-panel::before {
            width: 280px;
            height: 280px;
            right: -90px;
            top: -80px;
        }

        .hero-panel::after {
            width: 220px;
            height: 220px;
            left: -90px;
            bottom: -70px;
        }

        .brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.32);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.14);
            overflow: hidden;
            padding: 8px;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .brand-text {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            margin-top: 78px;
            max-width: 520px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.32);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .pulse {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #8cffbd;
            box-shadow: 0 0 0 6px rgba(140, 255, 189, 0.18);
        }

        .hero-title {
            font-size: 52px;
            line-height: 1.03;
            letter-spacing: -2px;
            margin: 0 0 18px;
            font-weight: 800;
        }

        .hero-subtitle {
            font-size: 17px;
            line-height: 1.8;
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
        }

        .feature-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 46px;
        }

        .feature-card {
            min-height: 98px;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.24);
        }

        .feature-card svg {
            width: 28px;
            height: 28px;
            margin-bottom: 10px;
            fill: white;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .feature-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.4;
        }

        .login-panel {
            padding: 54px 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
        }

        .mobile-brand {
            display: none;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .mobile-brand .brand-logo {
            width: 58px;
            height: 58px;
            background: #f3faff;
            border: 1px solid var(--border);
            box-shadow: 0 10px 25px rgba(18, 147, 238, 0.16);
        }

        .mobile-brand .brand-text {
            color: var(--text);
            font-size: 28px;
        }

        .login-title {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1px;
            margin: 0 0 8px;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 28px;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .alert-error {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
        }

        .field-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            stroke: var(--blue);
            pointer-events: none;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 54px;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 0 16px 0 48px;
            font-family: 'Work Sans', Arial, sans-serif;
            font-size: 15px;
            color: var(--text);
            outline: none;
            background: #fbfdff;
            transition: 0.2s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--blue);
            background: white;
            box-shadow: 0 0 0 4px rgba(18, 147, 238, 0.13);
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 6px 0 22px;
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-weight: 600;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--blue);
        }

        .forgot {
            color: var(--blue-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .login-button {
            width: 100%;
            height: 56px;
            border: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            font-family: 'Work Sans', Arial, sans-serif;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 18px 35px rgba(18, 147, 238, 0.28);
            transition: 0.2s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 45px rgba(18, 147, 238, 0.36);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .demo-box {
            margin-top: 24px;
            padding: 16px;
            border: 1px dashed #a9d7fb;
            background: var(--blue-soft);
            border-radius: 16px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        .demo-box strong {
            color: var(--text);
        }

        .footer-note {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        @media (max-width: 950px) {
            .login-shell {
                grid-template-columns: 1fr;
                max-width: 520px;
                min-height: auto;
            }

            .hero-panel {
                display: none;
            }

            .login-panel {
                padding: 36px 28px;
            }

            .mobile-brand {
                display: flex;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .login-panel {
                padding: 28px 20px;
            }

            .login-title {
                font-size: 30px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="hero-panel">
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/permitnet-logo.png') }}" alt="PermitNet Logo">
                </div>

                <div class="brand-text">PermitNet</div>
            </div>

            <div class="hero-content">
                <div class="hero-badge">
                    <span class="pulse"></span>
                    Raspberry Pi Gateway Online
                </div>

                <h1 class="hero-title">
                    Secure access before devices enter your network.
                </h1>

                <p class="hero-subtitle">
                    Monitor Wi-Fi connection attempts, approve or deny devices in real time,
                    enforce firewall decisions, and keep every access event logged.
                </p>

                <div class="feature-grid">
                    <div class="feature-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2L4 5v6c0 5 3.4 9.7 8 11c4.6-1.3 8-6 8-11V5l-8-3zm-1 14l-4-4l1.4-1.4L11 13.2l5.6-5.6L18 9l-7 7z"/>
                        </svg>
                        <div class="feature-title">Access Approval</div>
                        <div class="feature-desc">Approve or deny unknown devices instantly.</div>
                    </div>

                    <div class="feature-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16v4H4V4zm0 6h16v4H4v-4zm0 6h16v4H4v-4zm2-11v2h2V5H6zm0 6v2h2v-2H6zm0 6v2h2v-2H6z"/>
                        </svg>
                        <div class="feature-title">Firewall Rules</div>
                        <div class="feature-desc">Control network access through gateway rules.</div>
                    </div>

                    <div class="feature-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 18.5l3.5-3.5a5 5 0 0 0-7 0L12 18.5zm-6.5-6.5l1.8 1.8a7 7 0 0 1 9.9 0L19 12a9.5 9.5 0 0 0-13.5 0zm-3.5-3.5l1.8 1.8a12 12 0 0 1 16.9 0l1.8-1.8a14.5 14.5 0 0 0-20.5 0z"/>
                        </svg>
                        <div class="feature-title">Live Devices</div>
                        <div class="feature-desc">Track connected users, guests, and staff.</div>
                    </div>

                    <div class="feature-card">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 3h14a2 2 0 0 1 2 2v16l-4-2l-4 2l-4-2l-4 2V5a2 2 0 0 1 2-2zm3 5h8V6H8v2zm0 4h8v-2H8v2zm0 4h5v-2H8v2z"/>
                        </svg>
                        <div class="feature-title">Activity Logs</div>
                        <div class="feature-desc">Record access attempts and network events.</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-card">
                <div class="mobile-brand">
                    <div class="brand-logo">
                        <img src="{{ asset('images/permitnet-logo.png') }}" alt="PermitNet Logo">
                    </div>

                    <div class="brand-text">PermitNet</div>
                </div>

                <h2 class="login-title">Welcome back</h2>

                <p class="login-subtitle">
                    Sign in to manage approvals, devices, firewall actions, and connection logs.
                </p>

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="field-group">
                        <label for="email">Email Address</label>

                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M4 6h16v12H4V6z" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M4 7l8 6l8-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="admin@permitnet.local"
                                autocomplete="email"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>

                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke-width="2" stroke-linecap="round"/>
                                <path d="M5 11h14v10H5V11z" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M12 15v2" stroke-width="2" stroke-linecap="round"/>
                            </svg>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                        </div>
                    </div>

                    <div class="login-options">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            Remember session
                        </label>

                        <a href="#" class="forgot">Need help?</a>
                    </div>

                    <button type="submit" class="login-button">
                        Login to Dashboard
                    </button>
                </form>

                <div class="demo-box">
                    <strong>Default account</strong><br>
                    Email: admin@permitnet.local<br>
                    Password: password
                </div>

                <div class="footer-note">
                    PermitNet Network Access Control System
                </div>
            </div>
        </section>
    </main>
</body>
</html>