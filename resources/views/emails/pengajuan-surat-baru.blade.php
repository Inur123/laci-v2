<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Baru</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width: 600px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="background-color: #2563eb; padding: 40px 30px; text-align: center;">
                            {{-- Logo --}}
                            <img src="https://laci.my.id/images/logo-laci-3.webp" alt="Laci Digital"
                                style="width:100px;height:100px;border-radius:50%;border:4px solid #ffffff;margin-bottom:16px;object-fit:contain;background:#ffffff;padding:6px;">

                            <h1
                                style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">
                                Pengajuan Surat Baru
                            </h1>
                            <p
                                style="margin: 8px 0 0; color: #ffffff; font-size: 14px; font-weight: 500; opacity: 0.95;">
                                Laci Digital - PC IPNU IPPNU Magetan
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 30px 30px 0;">
                            <div
                                style="display: inline-block; background: #fef3c7; padding: 12px 24px; border-radius: 50px; border: 2px solid #f59e0b;">
                                <span
                                    style="color: #f59e0b; font-weight: 700; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    🔔 PERLU TINDAK LANJUT
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 30px 20px;">
                            <h2 style="margin: 0 0 16px; color: #1f2937; font-size: 20px; font-weight: 600;">
                                Halo Sekretaris Cabang! 👋
                            </h2>

                            <p style="margin: 0 0 24px; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Telah ada pengajuan surat baru dari <strong
                                    style="color: #1f2937;">{{ $user->name }}</strong>
                                ({{ $user->email }}) yang memerlukan persetujuan Anda.
                            </p>

                            <div
                                style="background-color: #eff6ff; border: 1px solid #3b82f6; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">📋
                                                    Nomor Surat:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $pengajuan->no_surat }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">👤
                                                    Pengaju:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">📧
                                                    Penerima:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ ucwords(str_replace(['ipnu', 'ippnu', 'bersama'], ['IPNU', 'IPPNU', 'IPNU & IPPNU'], $pengajuan->penerima)) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">🎯
                                                    Keperluan:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ $pengajuan->keperluan ?? '-' }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 16px;">
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">📅
                                                    Tanggal:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500;">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('l, d F Y') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: start;">
                                                <span
                                                    style="color: #1e40af; font-size: 14px; font-weight: 600; display: block; min-width: 120px;">📝
                                                    Deskripsi:</span>
                                                <span
                                                    style="color: #1f2937; font-size: 14px; font-weight: 500; line-height: 1.5;">{{ $pengajuan->deskripsi ?? '-' }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div
                                style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                                    ⚠️ <strong>Tindakan Diperlukan:</strong> Silakan segera tinjau dan proses pengajuan
                                    surat ini melalui dashboard sekretaris Laci Digital.
                                </p>
                            </div>

                            <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                Terima kasih atas perhatian dan kerjasama Anda dalam mengelola sistem <strong
                                    style="color: #1f2937;">Laci Digital</strong>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f9fafb; padding: 24px 30px; border-top: 1px solid #e5e7eb;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 8px; color: #9ca3af; font-size: 13px;">
                                            &copy; {{ date('Y') }} <strong style="color: #6b7280;">Laci
                                                Digital</strong>. Semua hak dilindungi.
                                        </p>
                                        <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                            PC IPNU IPPNU Magetan | Jawa Timur, Indonesia
                                        </p>
                                        <p
                                            style="margin: 8px 0 0; color: #9ca3af; font-size: 11px; font-style: italic;">
                                            Email ini dikirim secara otomatis, mohon tidak membalas.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div style="height: 20px;"></div>
            </td>
        </tr>
    </table>
</body>

</html>
