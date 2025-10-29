<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Bergabung di Mulaicpns!</title>
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
                <h3 style="color:#2563eb;margin-top:0;">Selamat Datang, {{ $user->name }} 🎉</h3>
                <p>Terima kasih telah bergabung di <strong>Mulaicpns</strong> — platform latihan terbaik untuk menghadapi seleksi CPNS.</p>

                <p>Dengan akun ini, kamu bisa:</p>
                <ul style="margin-top:10px;">
                    <li>🔹 Mengikuti tryout gratis dan premium</li>
                    <li>🔹 Melihat hasil dan analisis skor</li>
                    <li>🔹 Mengetahui topik mana yang perlu ditingkatkan</li>
                </ul>

                <div style="text-align:center;margin:30px 0;">
                    <a href="{{ url('/tryout') }}" style="background-color:#2563eb;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:6px;font-weight:600;display:inline-block;">
                        Mulai Tryout Pertamamu 🚀
                    </a>
                </div>

                <p>Jika kamu mengalami kendala, jangan ragu untuk menghubungi kami di <a href="mailto:maps.mulaicpns@gmail.com" style="color:#2563eb;">maps.mulaicpns@gmail.com</a>.</p>

                <p style="margin:0;">Semoga sukses menembus CPNS impianmu! 💪<br><strong>Tim Mulaicpns</strong></p>
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
