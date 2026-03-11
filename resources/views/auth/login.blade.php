<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish &mdash; Qizil Kitob Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #A0332D;
            --primary-dark: #7a2520;
            --secondary: #D4AF37;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #1c1008;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(160,51,45,0.3) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(212,175,55,0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(45,106,79,0.2) 0%, transparent 50%);
            z-index: 0;
        }

        /* Decorative botanical elements */
        body::after {
            content: '🌿';
            position: fixed;
            font-size: 200px;
            opacity: 0.03;
            bottom: -40px;
            right: -40px;
            z-index: 0;
            transform: rotate(-15deg);
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* Logo area */
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary), #c44741);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 16px;
            box-shadow: 0 8px 32px rgba(160,51,45,0.4);
        }

        .login-logo-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .login-logo-subtitle {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Card */
        .login-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(212,175,55,0.15);
            border-radius: 20px;
            padding: 36px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 20px 60px rgba(0,0,0,0.4),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .login-card-title {
            font-size: 18px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            margin-bottom: 4px;
            font-family: 'Playfair Display', serif;
        }

        .login-card-subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 28px;
        }

        /* Form */
        .form-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 8px;
        }

        .form-control {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 12px 16px;
            color: #fff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.09);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(160,51,45,0.2);
            color: #fff;
            outline: none;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.25); }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 16px;
        }

        .input-with-icon .form-control {
            padding-left: 44px;
        }

        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--primary), #c44741);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            box-shadow: 0 4px 16px rgba(160,51,45,0.5);
            transform: translateY(-1px);
        }

        .btn-login:active { transform: translateY(0); }

        /* Error */
        .error-msg {
            background: rgba(160,51,45,0.15);
            border: 1px solid rgba(160,51,45,0.3);
            border-radius: 8px;
            padding: 12px 16px;
            color: #ff8a85;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 24px 0;
        }

        /* Footer text */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: rgba(255,255,255,0.2);
        }

        /* Decorative dots */
        .dots {
            position: fixed;
            width: 300px;
            height: 300px;
            opacity: 0.04;
            pointer-events: none;
        }

        .dots-tl { top: -100px; left: -100px; }
        .dots-br { bottom: -100px; right: -100px; }
    </style>
</head>
<body>

    <div class="login-wrapper">

        <!-- Logo -->
        <div class="login-logo">
            <div class="login-logo-icon">🌿</div>
            <h1 class="login-logo-title">Qizil Kitob</h1>
            <p class="login-logo-subtitle">O'zbekiston Qizil Kitobi</p>
        </div>

        <!-- Card -->
        <div class="login-card">
            <h2 class="login-card-title">Tizimga kirish</h2>
            <p class="login-card-subtitle">Admin paneliga kirish uchun ma'lumotlaringizni kiriting</p>

            <!-- Errors -->
            @if($errors->any())
                <div class="error-msg">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- Email -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label">Email manzil</label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope icon"></i>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="admin@example.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password -->
                <div style="margin-bottom: 20px;">
                    <label class="form-label">Parol</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock icon"></i>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <!-- Remember -->
                <div style="margin-bottom: 24px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Meni eslab qol
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Kirish
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            &copy; {{ date('Y') }} Qizil Kitob Admin Panel. Barcha huquqlar himoyalangan.
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
