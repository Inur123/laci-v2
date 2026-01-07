<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verifikasi Email</title>
</head>

<body
    style="margin:0;padding:0;background:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#2563eb;padding:36px 30px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:700;">
                                Verifikasi Email Akun Anda
                            </h1>
                            <p style="margin:8px 0 0;color:rgba(255,255,255,0.92);font-size:14px;">
                                Laci Digital - PC IPNU IPPNU Magetan
                            </p>
                        </td>
                    </tr>

                    <!-- Badge -->
                    <tr>
                        <td align="center" style="padding:26px 30px 0;">
                            <div
                                style="display:inline-block;background:#dbeafe;padding:12px 28px;border-radius:999px;border:2px solid #2563eb;">
                                <span style="color:#1e40af;font-weight:800;font-size:14px;letter-spacing:0.6px;">
                                    VERIFIKASI EMAIL
                                </span>
                            </div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:26px 40px 22px;">
                            <h2 style="margin:0 0 12px;color:#111827;font-size:20px;font-weight:700;">
                                Halo, {{ $user->name }} 👋
                            </h2>

                            <p style="margin:0 0 18px;color:#374151;font-size:16px;line-height:1.6;">
                                Terima kasih telah mendaftar di <strong>Laci Digital</strong>.
                                Silakan klik tombol di bawah ini untuk memverifikasi email Anda.
                            </p>

                            <div style="text-align:center;margin:30px 0;">
                                <a href="{{ $url }}"
                                    style="background:#2563eb;color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:12px;font-weight:700;display:inline-block;">
                                     Verifikasi Email Sekarang
                                </a>
                            </div>

                            <div
                                style="background:#eef2ff;border-left:6px solid #2563eb;padding:14px;border-radius:8px;margin-bottom:12px;">
                                <p style="margin:0;color:#1e3a8a;font-size:14px;">
                                    Jika Anda tidak merasa membuat akun ini, silakan abaikan email ini.
                                </p>
                            </div>

                            <p style="margin:18px 0 0;color:#6b7280;font-size:13px;">
                                Terima kasih,<br><strong style="color:#111827">Tim Laci Digital</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:26px;text-align:center;border-top:1px solid #eef2f7;">
                            <p style="margin:0;color:#9ca3af;font-size:13px;">
                                &copy; {{ date('Y') }} <strong style="color:#6b7280">Laci Digital</strong>. Semua
                                hak dilindungi.
                            </p>
                            <p style="margin:6px 0 0;color:#9ca3af;font-size:12px;">
                                PC IPNU IPPNU Magetan | Jawa Timur, Indonesia
                            </p>
                            <p style="margin:10px 0 0;color:#9ca3af;font-size:11px;font-style:italic;">
                                Email ini dikirim otomatis • Tidak perlu dibalas
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
