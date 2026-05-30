<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Pembayaran Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .logo {
            display: block;
            margin: 0 auto 15px auto;
            max-height: 60px;
        }
        h2 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 20px;
            text-align: center;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table th,
        .info-table td {
            text-align: left;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-table th {
            width: 40%;
            color: #4a5568;
            font-weight: 600;
        }
        .info-table td {
            color: #2d3748;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
        .highlight {
            color: #2b6cb0;
            font-weight: 600;
        }
        .note {
            background-color: #fffbea;
            border: 1px solid #f6e05e;
            border-radius: 6px;
            padding: 12px 15px;
            margin-top: 20px;
            font-size: 13px;
            color: #744210;
        }
        .button {
            display: inline-block;
            background-color: #2b6cb0;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
        }
        .button:hover {
            background-color: #1a4f82;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Logo --}}
        <img src="{{ asset('assets/frontend/image/logo.png') }}" alt="Logo Mulaicpns" class="logo">

        <h2>🔔 Permintaan Pembayaran Baru</h2>

        <p>Halo Owner,</p>
        <p>Seorang pengguna baru saja <strong>membuat kode pembayaran</strong> pada sistem tryout CPNS. Mohon pantau mutasi rekening — pembayaran kemungkinan akan segera masuk.</p>

        <table class="info-table">
            <tr>
                <th>Nama Pengguna</th>
                <td>{{ $payment->user->name }}</td>
            </tr>
            <tr>
                <th>Email Pengguna</th>
                <td>{{ $payment->user->email }}</td>
            </tr>
            <tr>
                <th>WhatsApp</th>
                <td>{{ $payment->whatsapp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $payment->method?->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nominal yang Harus Ditransfer</th>
                <td class="highlight">Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Tanggal Permintaan</th>
                <td>{{ $payment->created_at->format('d F Y, H:i') }}</td>
            </tr>
        </table>

        <div class="note">
            ⚠️ Ini adalah <strong>permintaan pembayaran</strong>, bukan konfirmasi bahwa dana sudah diterima. Cocokkan nominal di atas (termasuk 3 angka kode unik) dengan mutasi rekening sebelum mengaktifkan akun pengguna.
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/console/payment') }}" class="button">
                🔎 Lihat Detail Pembayaran
            </a>
        </div>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem tryout CPNS.<br>
            Jangan membalas email ini. © {{ date('Y') }} Mulaicpns.
        </div>
    </div>
</body>
</html>