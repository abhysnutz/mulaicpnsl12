@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran</title>
</head>
<body style="background-color:#f5f7fb;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;margin:0;padding:0;">

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;margin:auto;background-color:#ffffff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);overflow:hidden;">
        <tr>
            <td style="background-color:#2563eb;padding:20px;text-align:center;">
                <img src="{{ asset('assets/frontend/image/logo.png') }}" alt="Mulaicpns Logo" width="120" style="margin-bottom:10px;">
                <h2 style="color:#ffffff;margin:0;font-size:20px;font-weight:600;">Mulaicpns</h2>
            </td>
        </tr>

        <tr>
            <td style="padding:30px 25px;color:#333333;font-size:15px;line-height:1.7;">
                @if($status === 'accepted')
                    <h3 style="color:#16a34a;margin-top:0;">✅ Pembayaran Anda Telah Diterima</h3>
                    <p>Halo <strong>{{ $payment->user->name }}</strong>,</p>
                    <p>Pembayaran Anda telah <strong>dikonfirmasi</strong>. Akun Anda kini memiliki status <strong>Premium</strong>.</p>

                    <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;margin:15px 0;">
                        <tr>
                            <td width="40%" style="background:#f1f5f9;"><strong>Tanggal Pembayaran</strong></td>
                            <td>{{ $payment->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="background:#f1f5f9;"><strong>Metode Pembayaran</strong></td>
                            <td>{{ $payment->method->name }}</td>
                        </tr>
                        @if($subscription)
                        <tr>
                            <td style="background:#f1f5f9;"><strong>Berlaku Hingga</strong></td>
                            <td>{{ Carbon::parse($subscription->end_date)->translatedFormat('d F Y') }}</td>
                        </tr>
                        @endif
                    </table>

                    <p style="margin-top:20px;">Selamat menikmati akses penuh ke semua <strong>Tryout Premium</strong> 🎯</p>
                    <p style="margin:0;">Terima kasih atas kepercayaan Anda,<br><strong>Tim Mulaicpns</strong></p>

                @else
                    <h3 style="color:#dc2626;margin-top:0;">❌ Pembayaran Anda Ditolak</h3>
                    <p>Halo <strong>{{ $payment->user->name }}</strong>,</p>
                    <p>Mohon maaf, pembayaran Anda tidak dapat kami terima.</p>

                    @if(!empty($note))
                        <p><strong>Alasan:</strong> {{ $note }}</p>
                    @endif

                    <p>Silakan kirim ulang bukti pembayaran atau hubungi admin untuk bantuan lebih lanjut.</p>
                    <p style="margin:0;">Terima kasih,<br><strong>Tim Mulaicpns</strong></p>
                @endif
            </td>
        </tr>

        <tr>
            <td style="background-color:#f1f5f9;padding:15px;text-align:center;font-size:13px;color:#6b7280;">
                © {{ now()->year }} Mulaicpns. Seluruh hak cipta dilindungi.
            </td>
        </tr>
    </table>

</body>
</html>
