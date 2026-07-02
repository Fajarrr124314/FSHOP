<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOKU | Secure Hosted Payment Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --doku-red: #e74c3c;
            --doku-dark: #1e272e;
            --bg-color: #070913;
            --glass-card: rgba(30, 39, 46, 0.45);
            --border-color: rgba(255, 255, 255, 0.1);
            --text-primary: #f1f2f6;
            --text-secondary: #a4b0be;
            --primary-glow: rgba(231, 76, 60, 0.3);
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
            overflow-x: hidden;
        }

        /* Space particle background */
        .space-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: radial-gradient(circle at 50% 50%, rgba(231, 76, 60, 0.1) 0%, rgba(7, 9, 19, 0) 80%);
            background-color: #05070e;
        }

        .checkout-container {
            width: 100%;
            max-width: 500px;
            padding: 1.5rem;
            box-sizing: border-box;
            z-index: 10;
        }

        .doku-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .doku-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .doku-logo span {
            color: var(--doku-red);
        }

        .badge-sandbox {
            background: rgba(243, 156, 18, 0.2);
            border: 1px solid #f39c12;
            color: #f39c12;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .glass-card {
            background: var(--glass-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 2rem;
            position: relative;
        }

        .order-summary {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-bold {
            font-weight: 700;
        }

        .text-large {
            font-size: 1.3rem;
            color: var(--doku-red);
            text-shadow: 0 0 10px rgba(231, 76, 60, 0.4);
        }

        .payment-method-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .method-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 0.8rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }

        .method-btn:hover, .method-btn.active {
            background: rgba(231, 76, 60, 0.15);
            border-color: var(--doku-red);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.2);
        }

        .payment-content {
            display: none;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .payment-content.active {
            display: block;
        }

        /* QRIS Styles */
        .qris-code {
            width: 180px;
            height: 180px;
            background: #ffffff;
            margin: 0.8rem auto;
            border-radius: 12px;
            padding: 8px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qris-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .countdown-timer {
            color: #f39c12;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        /* VA Styles */
        .va-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.3);
            border: 1px dashed var(--border-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.8rem 0;
        }

        .va-num {
            font-family: monospace;
            font-size: 1.15rem;
            color: #ffffff;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .copy-btn {
            background: var(--doku-red);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 0.35rem 0.7rem;
            font-size: 0.75rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .copy-btn:hover {
            opacity: 0.9;
        }

        .btn-pay-now {
            background: linear-gradient(135deg, var(--doku-red), #c0392b);
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 6px 20px var(--primary-glow);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.5);
        }

        /* Spinner */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .payment-processing-overlay {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(7, 9, 19, 0.9);
            border-radius: 20px;
            z-index: 100;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .payment-processing-overlay.show {
            display: flex;
        }

        .secure-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .secure-footer i {
            color: #2ecc71;
        }
    </style>
</head>
<body>

    <div class="space-bg"></div>

    <div class="checkout-container">
        <div class="glass-card">
            
            <!-- Processing Overlay -->
            <div class="payment-processing-overlay" id="processingOverlay">
                <div class="spinner" style="display: block; width: 40px; height: 40px; border-width: 4px;"></div>
                <h3 style="margin: 0; font-family: 'Space Grotesk', sans-serif;">Memproses Pembayaran...</h3>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">Mohon tunggu sebentar, sistem sedang memverifikasi dana Anda.</p>
            </div>

            <!-- Doku Header -->
            <div class="doku-header">
                <div class="doku-logo">
                    <i class="fa-solid fa-credit-card" style="color: var(--doku-red);"></i> DOKU<span>.checkout</span>
                </div>
                <div class="badge-sandbox">DEMO MODE</div>
            </div>

            <h3 style="margin-top: 0; margin-bottom: 0.5rem; font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem;">Rincian Pesanan</h3>
            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-row">
                    <span style="color: var(--text-secondary);">No. Invoice</span>
                    <span class="text-bold">{{ $order->id }}</span>
                </div>
                <div class="summary-row">
                    <span style="color: var(--text-secondary);">Nama Pelanggan</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="summary-row" style="margin-bottom: 0.8rem;">
                    <span style="color: var(--text-secondary);">No. WhatsApp</span>
                    <span>{{ $order->customer_phone }}</span>
                </div>
                <div class="summary-row">
                    <span class="text-bold" style="color: #ffffff;">Total Tagihan</span>
                    <span class="text-bold text-large">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <h3 style="margin-top: 0; margin-bottom: 0.8rem; font-family: 'Space Grotesk', sans-serif; font-size: 1.1rem;">Pilih Metode Pembayaran</h3>
            <div class="payment-method-selector">
                <button class="method-btn active" onclick="switchMethod('qris')">
                    <i class="fa-solid fa-qrcode"></i> QRIS (Instant)
                </button>
                <button class="method-btn" onclick="switchMethod('va')">
                    <i class="fa-solid fa-building-columns"></i> Virtual Account
                </button>
            </div>

            <!-- QRIS Content -->
            <div class="payment-content active" id="content-qris">
                <div class="countdown-timer">
                    <i class="fa-regular fa-clock"></i> Batas Waktu Bayar: <span id="qris-timer">59:59</span>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0 0 0.8rem 0;">Scan Kode QRIS di bawah ini dengan E-Wallet atau M-Banking Anda</p>
                <div class="qris-code">
                    <!-- Standard placeholder QR code -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=FSHOP_ORDER_{{ $order->id }}" alt="QRIS Code">
                </div>
                <p style="font-size: 0.75rem; color: var(--doku-red); font-weight: bold; margin: 0;"><i class="fa-solid fa-bolt"></i> Terverifikasi Otomatis dalam 5-10 detik</p>
            </div>

            <!-- Virtual Account Content -->
            <div class="payment-content" id="content-va">
                <div class="countdown-timer">
                    <i class="fa-regular fa-clock"></i> Batas Waktu Bayar: <span id="va-timer">23:59:59</span>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0 0 0.8rem 0; text-align: left;">Transfer Virtual Account Mandiri</p>
                
                <div class="va-box">
                    <span class="va-num" id="vaNum">88739{{ rand(10000000, 99999999) }}</span>
                    <button class="copy-btn" onclick="copyVA()">Salin</button>
                </div>
                
                <p style="font-size: 0.75rem; color: var(--text-secondary); margin: 0; text-align: left;">
                    Langkah Transfer:<br>
                    1. Pilih M-Banking > Transfer > Virtual Account<br>
                    2. Masukkan nomor VA di atas<br>
                    3. Konfirmasi nominal pembayaran sesuai total tagihan
                </p>
            </div>

            <!-- Pay Now Trigger -->
            <button class="btn-pay-now" onclick="simulatePayment()">
                <div class="spinner" id="btnSpinner"></div>
                <span id="btnText"><i class="fa-solid fa-shield-halved"></i> SIMULASIKAN PEMBAYARAN SUKSES</span>
            </button>

            <!-- Secure Footer Info -->
            <div class="secure-footer">
                <i class="fa-solid fa-circle-check"></i> Pembayaran Terenkripsi &amp; Aman. Powered by DOKU Sandbox.
            </div>

        </div>
    </div>

    <script>
        // Tab Switcher
        function switchMethod(method) {
            document.querySelectorAll('.method-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.payment-content').forEach(c => c.classList.remove('active'));

            if (method === 'qris') {
                event.currentTarget.classList.add('active');
                document.getElementById('content-qris').classList.add('active');
            } else {
                event.currentTarget.classList.add('active');
                document.getElementById('content-va').classList.add('active');
            }
        }

        // Copy VA
        function copyVA() {
            const vaNum = document.getElementById('vaNum').innerText;
            navigator.clipboard.writeText(vaNum).then(() => {
                const btn = event.currentTarget;
                btn.innerText = 'Tersalin!';
                setTimeout(() => { btn.innerText = 'Salin'; }, 2000);
            });
        }

        // Countdown Timer
        let qrisMinutes = 59;
        let qrisSeconds = 59;
        setInterval(() => {
            if (qrisSeconds > 0) {
                qrisSeconds--;
            } else {
                if (qrisMinutes > 0) {
                    qrisMinutes--;
                    qrisSeconds = 59;
                }
            }
            document.getElementById('qris-timer').innerText = 
                (qrisMinutes < 10 ? '0' + qrisMinutes : qrisMinutes) + ':' + 
                (qrisSeconds < 10 ? '0' + qrisSeconds : qrisSeconds);
        }, 1000);

        // Payment Simulation
        function simulatePayment() {
            document.getElementById('btnSpinner').style.display = 'block';
            document.getElementById('btnText').innerText = 'Menghubungkan ke DOKU...';

            setTimeout(() => {
                document.getElementById('processingOverlay').classList.add('show');
                
                // Perform webhook post simulation using fetch
                fetch("{{ route('checkout.webhook') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: json = JSON.stringify({
                        invoice_number: "{{ $order->id }}",
                        status: "SUCCESS"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setTimeout(() => {
                        window.location.href = "{{ route('checkout.success', ['orderId' => $order->id]) }}";
                    }, 1500);
                })
                .catch(error => {
                    console.error('Webhook simulation failed', error);
                    // Force redirect even if webhook has CORS/CSRF issues during testing
                    window.location.href = "{{ route('checkout.success', ['orderId' => $order->id]) }}";
                });
            }, 1000);
        }
    </script>
</body>
</html>
