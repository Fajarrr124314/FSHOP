<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Accounts - Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-color: #070913;
            --border-color: rgba(255, 255, 255, 0.1);
            --text-primary: #f1f2f6;
            --text-secondary: #a4b0be;
            --google-blue: #4285F4;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .space-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: radial-gradient(circle at 50% 50%, rgba(66, 133, 244, 0.12) 0%, rgba(7, 9, 19, 0) 80%);
            background-color: #05070e;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(18, 24, 43, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 2.5rem;
            text-align: center;
        }

        .google-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .google-logo span:nth-child(1) { color: #4285F4; }
        .google-logo span:nth-child(2) { color: #EA4335; }
        .google-logo span:nth-child(3) { color: #FBBC05; }
        .google-logo span:nth-child(4) { color: #34A853; }
        .google-logo span:nth-child(5) { color: #4285F4; }
        .google-logo span:nth-child(6) { color: #EA4335; }

        .login-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .account-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-align: left;
        }

        .account-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.85rem 1.2rem;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
        }

        .account-item:hover {
            background: rgba(66, 133, 244, 0.1);
            border-color: var(--google-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.15);
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.1);
        }

        .account-info {
            flex-grow: 1;
        }

        .account-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: #ffffff;
        }

        .account-email {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .badge-role {
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .badge-admin {
            background: rgba(155, 89, 182, 0.2);
            border: 1px solid #9b59b6;
            color: #d6a2e8;
        }

        .badge-customer {
            background: rgba(0, 206, 201, 0.2);
            border: 1px solid #00cec9;
            color: #81ecec;
        }

        .footer-hint {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>

    <div class="space-bg"></div>

    <div class="login-box">
        <div class="google-logo">
            <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
        </div>
        <h2 class="login-title">Pilih Akun Google</h2>
        <p class="login-subtitle">Simulasi login Google Single Sign-On (SSO)</p>

        <div class="account-list">
            
            <a href="{{ route('auth.mock-login', ['profile' => 'admin']) }}" class="account-item">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Admin avatar" class="avatar">
                <div class="account-info">
                    <div class="account-name">FSHOP Admin</div>
                    <div class="account-email">admin@fshop.space</div>
                </div>
                <span class="badge-role badge-admin">ADMIN</span>
            </a>

            <a href="{{ route('auth.mock-login', ['profile' => 'customer']) }}" class="account-item">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Customer avatar" class="avatar">
                <div class="account-info">
                    <div class="account-name">FSHOP Customer</div>
                    <div class="account-email">customer@fshop.space</div>
                </div>
                <span class="badge-role badge-customer">USER</span>
            </a>

        </div>

        <p class="footer-hint">
            <i class="fa-solid fa-circle-info"></i> Tampilan di atas adalah mock login. Masukkan <code>GOOGLE_CLIENT_ID</code> dan <code>GOOGLE_CLIENT_SECRET</code> di file <code>.env</code> untuk mengaktifkan login Google yang asli.
        </p>
    </div>

</body>
</html>
