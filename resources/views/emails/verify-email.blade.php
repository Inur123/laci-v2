<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Verifikasi Email</title>
</head>

<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 15px;background:#f3f4f6;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="max-width:600px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="padding:28px 35px;background:#2563eb;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:20px;font-weight:700;">
                                Verifikasi Email Anda
                            </h1>
                            <p style="margin:8px 0 0;color:rgba(255,255,255,0.9);font-size:13px;">
                                Laci Digital • PC IPNU IPPNU Magetan
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:35px;">
                            <h2 style="margin:0 0 12px;color:#111827;font-size:18px;font-weight:700;">
                                Halo, {{ $user->name }} 👋
                            </h2>

                            <p style="margin:0 0 18px;color:#374151;font-size:15px;line-height:1.6;">
                                Terima kasih telah mendaftar di <strong>Laci Digital</strong>.
                                Silakan klik tombol di bawah ini untuk memverifikasi email Anda.
                            </p>

                            <!-- Button -->
                            <div style="text-align:center;margin:28px 0;">
                                <a href="{{ $url }}"
                                    style="background:#2563eb;color:#ffffff;text-decoration:none;padding:14px 26px;border-radius:10px;font-weight:700;font-size:14px;display:inline-block;">
                                    Verifikasi Email
                                </a>
                            </div>

                            <!-- Fallback URL -->
                            <p style="margin:0 0 10px;color:#6b7280;font-size:13px;line-height:1.5;">
                                Jika tombol tidak bisa diklik, salin dan tempel link berikut ke browser:
                            </p>

                            <p
                                style="margin:0 0 20px;background:#f9fafb;padding:12px 14px;border-radius:10px;font-size:12px;color:#1f2937;word-break:break-word;border:1px solid #e5e7eb;">
                                <a href="{{ $url }}" style="color:#2563eb;text-decoration:underline;">
                                    {{ $url }}
                                </a>
                            </p>

                            <!-- Info -->
                            <div style="background:#eff6ff;border:1px solid #bfdbfe;padding:14px;border-radius:10px;">
                                <p style="margin:0;color:#1e3a8a;font-size:13px;line-height:1.5;">
                                    Jika Anda tidak merasa membuat akun ini, silakan abaikan email ini.
                                </p>
                            </div>

                            <p style="margin:22px 0 0;color:#6b7280;font-size:13px;">
                                Terima kasih,<br>
                                <strong style="color:#111827;">Tim Laci Digital</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:20px 35px;background:#f9fafb;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;color:#9ca3af;font-size:12px;">
                                &copy; {{ date('Y') }} Laci Digital. Semua hak dilindungi.
                            </p>
                            <p style="margin:6px 0 0;color:#9ca3af;font-size:11px;">
                                PC IPNU IPPNU Magetan • Jawa Timur, Indonesia
                            </p>
                            <p style="margin:10px 0 0;color:#9ca3af;font-size:10px;font-style:italic;">
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
