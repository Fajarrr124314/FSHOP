<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSHOP | Pembayaran Berhasil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6c5ce7;
            --accent: #00cec9;
            --success: #2ecc71;
            --bg-color: #070913;
            --border-color: rgba(255, 255, 255, 0.1);
            --text-primary: #f1f2f6;
            --text-secondary: #a4b0be;
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
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

        .space-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: radial-gradient(circle at 50% 50%, rgba(108, 92, 231, 0.15) 0%, rgba(7, 9, 19, 0) 80%);
            background-color: #05070e;
        }

        .success-container {
            width: 100%;
            max-width: 600px;
            padding: 1.5rem;
            box-sizing: border-box;
            z-index: 10;
        }

        .glass-card {
            background: rgba(18, 24, 43, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: var(--glass-shadow);
            padding: 2.5rem;
            text-align: center;
            position: relative;
        }

        .success-icon-box {
            width: 80px;
            height: 80px;
            background: rgba(46, 204, 113, 0.15);
            border: 2px solid var(--success);
            color: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 0 25px rgba(46, 204, 113, 0.4);
            animation: pulseGlow 2s infinite alternate;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1); box-shadow: 0 0 15px rgba(46, 204, 113, 0.3); }
            100% { transform: scale(1.05); box-shadow: 0 0 25px rgba(46, 204, 113, 0.6); }
        }

        .success-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, #ffffff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .success-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .receipt-card {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
        }

        .receipt-header {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.8rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
        }

        .receipt-row:last-child {
            margin-bottom: 0;
        }

        .item-list {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .badge-status {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid var(--success);
            color: var(--success);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.6rem;
            border-radius: 20px;
        }

        .btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn {
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.6);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: #ffffff;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        @media (max-width: 480px) {
            .btn-group {
                grid-template-columns: 1fr;
            }
        }

        /* Print media styling */
        @media print {
            body {
                background: #ffffff;
                color: #000000;
            }
            .space-bg, .btn-group {
                display: none !important;
            }
            .glass-card {
                background: none;
                border: none;
                box-shadow: none;
                padding: 0;
            }
            .receipt-card {
                background: none;
                border: 1px solid #ccc;
                color: #000000;
            }
            .receipt-header, .receipt-row, .item-row {
                color: #000000 !important;
            }
            .badge-status {
                border-color: #000 !important;
                color: #000 !important;
            }
        }

        /* Light Mode Override */
        body.light-mode {
            --bg-color: #f0f3f9;
            --border-color: rgba(0, 0, 0, 0.08);
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
        }
        body.light-mode .glass-card {
            background: rgba(255, 255, 255, 0.85);
        }
        body.light-mode .success-title {
            background: linear-gradient(135deg, #1e293b, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        body.light-mode .receipt-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        body.light-mode .receipt-header {
            border-bottom-color: rgba(0, 0, 0, 0.1);
        }
        body.light-mode .item-list {
            border-top-color: rgba(0, 0, 0, 0.1);
        }
        body.light-mode .receipt-row span[style*="color: #ffffff"], 
        body.light-mode .item-row span[style*="color: #ffffff"],
        body.light-mode .item-list div[style*="color: #ffffff"],
        body.light-mode .receipt-row span[style*="color: rgb(255, 255, 255)"],
        body.light-mode .receipt-row[style*="border-top"] span[style*="color: #ffffff"] {
            color: #1e293b !important;
        }
        body.light-mode .btn-outline {
            background: rgba(0, 0, 0, 0.02);
            color: #1e293b;
            border-color: rgba(0, 0, 0, 0.15);
        }
        body.light-mode .btn-outline:hover {
            background: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('fshop_theme') || 'light';
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
            } else {
                document.body.classList.remove('light-mode');
            }
        })();
    </script>

    <div class="space-bg"></div>

    <div class="success-container">
        <div class="glass-card">
            
            <div class="success-icon-box">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <h1 class="success-title">Pembayaran Berhasil!</h1>
            <p class="success-subtitle">Terima kasih atas pemesanan Anda. Transaksi Anda telah berhasil diproses.</p>

            <div class="receipt-card">
                <div class="receipt-header">
                    <span>FSHOP RECEIPT</span>
                    <span class="badge-status">PAID</span>
                </div>
                
                <div class="receipt-row">
                    <span style="color: var(--text-secondary);">No. Invoice:</span>
                    <span style="font-weight: bold; color: #ffffff;">{{ $order->id }}</span>
                </div>
                <div class="receipt-row">
                    <span style="color: var(--text-secondary);">Waktu Transaksi:</span>
                    <span>{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="receipt-row">
                    <span style="color: var(--text-secondary);">Nama Pelanggan:</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="receipt-row">
                    <span style="color: var(--text-secondary);">No. WhatsApp:</span>
                    <span>{{ $order->customer_phone }}</span>
                </div>
                <div class="receipt-row">
                    <span style="color: var(--text-secondary);">Metode Pembayaran:</span>
                    <span>DOKU Gateway (Otomatis)</span>
                </div>

                <div class="item-list">
                    <div style="font-weight: bold; font-size: 0.85rem; margin-bottom: 0.5rem; color: #ffffff;">Item yang dibeli:</div>
                    @foreach($order->items as $item)
                        <div class="item-row">
                            <span>
                                {{ $item['title'] }} 
                                @if(isset($item['package_name']) && $item['package_name'])
                                    ({{ $item['package_name'] }})
                                @endif
                                @if(isset($item['qty']) && $item['qty'] > 1)
                                    x{{ $item['qty'] }}
                                @endif
                            </span>
                            <span style="color: #ffffff; font-weight: bold;">
                                {{ $item['price'] ?? 'Rp ' . number_format($item['price_raw'], 0, ',', '.') }}
                            </span>
                        </div>
                        @if(isset($item['meta']) && count($item['meta']) > 0)
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.6rem; padding-left: 0.5rem; border-left: 2px solid var(--accent);">
                                @foreach($item['meta'] as $k => $v)
                                    @if($v)
                                        <div><strong>{{ ucfirst(str_replace('_', ' ', $k)) }}:</strong> {{ $v }}</div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="receipt-row" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <span style="font-weight: bold; color: #ffffff;">Total Pembayaran:</span>
                    <span style="font-weight: bold; color: var(--accent); font-size: 1.25rem;">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
                <button onclick="window.print()" class="btn btn-outline">
                    <i class="fa-solid fa-print"></i> Cetak Kwitansi
                </button>
            </div>

        </div>
    </div>

</body>
</html>
