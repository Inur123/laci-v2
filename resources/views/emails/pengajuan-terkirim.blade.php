<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Berhasil</title>
</head>

<body
    style="margin:0;padding:0;background:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f3f4f6;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,0.1);">

                    <!-- Header Hijau -->
                    <tr>
                        <td style="background:#10b981;padding:40px 30px;text-align:center;">
                            <img src="https://laci.my.id/images/logo-laci-3.webp" alt="Laci Digital"
                                style="width:100px;height:100px;border-radius:50%;border:4px solid #ffffff;margin-bottom:16px;object-fit:contain;background:#ffffff;padding:6px;">
                            <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:700;letter-spacing:-0.5px;">
                                Pengajuan Berhasil Terkirim
                            </h1>
                            <p style="margin:8px 0 0;color:#d1fae5;font-size:15px;opacity:0.95;">
                                Laci Digital - PC IPNU IPPNU Magetan
                            </p>
                        </td>
                    </tr>

                    <!-- Badge SUCCESS -->
                    <tr>
                        <td align="center" style="padding:30px 30px 0;">
                            <div
                                style="display:inline-block;background:#d1fae5;padding:14px 32px;border-radius:50px;border:3px solid #10b981;">
                                <span
                                    style="color:#065f46;font-weight:800;font-size:17px;text-transform:uppercase;letter-spacing:1px;">
                                    BERHASIL TERKIRIM
                                </span>
                            </div>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px 40px 20px;">
                            <h2 style="margin:0 0 16px;color:#1f2937;font-size:22px;font-weight:700;">
                                Halo, {{ $pengajuan->user->name }}!
                            </h2>

                            <p style="margin:0 0 28px;color:#475569;font-size:17px;line-height:1.7;">
                                Pengajuan surat Anda dengan nomor <strong
                                    style="color:#1e293b">{{ $pengajuan->no_surat }}</strong>
                                telah <span style="color:#10b981;font-weight:700;">berhasil dikirim</span> dan sedang
                                menunggu persetujuan sekretaris cabang.
                            </p>

                            <!-- Detail Box -->
                            <div
                                style="background:#f0fdf4;border:2px solid #10b981;border-radius:16px;padding:28px;margin-bottom:28px;">
                                <table width="100%" cellpadding="10" cellspacing="0">
                                    <tr>
                                        <td style="color:#065f46;font-weight:700;font-size:15px;width:140px;">Nomor
                                            Surat</td>
                                        <td style="color:#1e293b;font-weight:600;font-size:16px;">
                                            {{ $pengajuan->no_surat }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#065f46;font-weight:700;">Penerima</td>
                                        <td style="color:#1e293b;">
                                            {{ ucwords(str_replace(['ipnu', 'ippnu', 'bersama'], ['IPNU', 'IPPNU', 'IPNU & IPPNU'], $pengajuan->penerima)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#065f46;font-weight:700;">Keperluan</td>
                                        <td style="color:#1e293b;">{{ $pengajuan->keperluan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#065f46;font-weight:700;">Tanggal Surat</td>
                                        <td style="color:#1e293b;">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('l, d F Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#065f46;font-weight:700;">Status</td>
                                        <td>
                                            <span
                                                style="background:#fef3c7;color:#d97706;padding:8px 16px;border-radius:50px;font-weight:700;font-size:14px;">
                                                Menunggu Persetujuan
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($pengajuan->deskripsi)
                                        <tr>
                                            <td
                                                style="color:#065f46;font-weight:700;vertical-align:top;padding-top:12px;">
                                                Deskripsi</td>
                                            <td style="color:#475569;line-height:1.7;padding-top:12px;">
                                                {{ $pengajuan->deskripsi }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <!-- Info Box -->
                            <div
                                style="background:#dbeafe;border-left:6px solid #3b82f6;padding:20px;border-radius:12px;">
                                <p style="margin:0;color:#1e40af;font-size:15px;line-height:1.7;">
                                    <strong>Informasi:</strong><br>
                                    Anda akan menerima notifikasi email lagi ketika pengajuan ini telah
                                    <strong>diterima</strong> atau <strong>ditolak</strong> oleh sekretaris cabang.
                                </p>
                            </div>

                            <p style="margin:32px 0 0;color:#64748b;font-size:15px;line-height:1.7;">
                                Terima kasih telah menggunakan <strong style="color:#1e293b">Laci Digital</strong>.<br>
                                Kami akan segera memproses pengajuan Anda.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:30px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="margin:0 0 8px;color:#9ca3af;font-size:13px;">
                                &copy; {{ date('Y') }} <strong style="color:#6b7280">Laci Digital</strong>. Semua
                                hak dilindungi.
                            </p>
                            <p style="margin:0;color:#9ca3af;font-size:12px;">
                                PC IPNU IPPNU Magetan | Jawa Timur, Indonesia
                            </p>
                            <p style="margin:12px 0 0;color:#9ca3af;font-size:11px;font-style:italic;">
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
