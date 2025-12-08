<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Notifikasi Pengajuan</title>
</head>

<body
    style="margin:0;padding:0;background:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    @php
        $accepted = $pengajuan->status === 'diterima';
        $brand = $accepted ? '#10b981' : '#ef4444';
        $badgeBg = $accepted ? '#d1fae5' : '#fee2e2';
        $badgeText = $accepted ? 'DITERIMA' : 'DITOLAK';
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f3f4f6;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:{{ $brand }};padding:36px 30px;text-align:center;">
                            <img src="https://laci.my.id/images/logo-laci-3.webp" alt="Laci Digital"
                                style="width:100px;height:100px;border-radius:50%;border:4px solid #ffffff;margin-bottom:16px;object-fit:contain;background:#ffffff;padding:6px;">

                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:700;">
                                Status Pengajuan Surat
                            </h1>
                            <p style="margin:8px 0 0;color:rgba(255,255,255,0.92);font-size:14px;">
                                Laci Digital - PC IPNU IPPNU Magetan
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:26px 30px 0;">
                            <div
                                style="display:inline-block;background:{{ $badgeBg }};padding:12px 28px;border-radius:999px;border:2px solid {{ $brand }};">
                                <span
                                    style="color:{{ $accepted ? '#065f46' : '#7f1d1d' }};font-weight:800;font-size:14px;letter-spacing:0.6px;">
                                    {{ $badgeText }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 40px 22px;">
                            <h2 style="margin:0 0 12px;color:#111827;font-size:20px;font-weight:700;">
                                Halo, {{ $pengajuan->user->name }}!
                            </h2>

                            @if ($accepted)
                                <p style="margin:0 0 18px;color:#374151;font-size:16px;line-height:1.6;">
                                    Pengajuan surat Anda dengan nomor <strong
                                        style="color:#111827">{{ $pengajuan->no_surat }}</strong> telah <strong
                                        style="color:{{ $brand }}">DITERIMA</strong>.
                                </p>
                            @else
                                <p style="margin:0 0 18px;color:#374151;font-size:16px;line-height:1.6;">
                                    Pengajuan surat Anda dengan nomor <strong
                                        style="color:#111827">{{ $pengajuan->no_surat }}</strong> <strong
                                        style="color:{{ $brand }}">DITOLAK</strong>.
                                </p>
                            @endif

                            <div
                                style="background:#f8fafc;border:1px solid #e6edf3;border-radius:12px;padding:20px;margin-bottom:18px;">
                                <table width="100%" cellpadding="6" cellspacing="0" role="presentation"
                                    style="font-size:14px;color:#374151;">
                                    <tr>
                                        <td style="width:140px;font-weight:700;color:#0f172a;">Nomor Surat</td>
                                        <td style="font-weight:600;color:#0f172a;">{{ $pengajuan->no_surat }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#0f172a;">Penerima</td>
                                        <td>{{ ucwords(str_replace(['ipnu', 'ippnu', 'bersama'], ['IPNU', 'IPPNU', 'IPNU & IPPNU'], $pengajuan->penerima)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#0f172a;">Keperluan</td>
                                        <td>{{ $pengajuan->keperluan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#0f172a;">Tanggal</td>
                                        <td>{{ $pengajuan->tanggal ? \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('l, d F Y') : '-' }}
                                        </td>
                                    </tr>
                                    @if ($pengajuan->deskripsi)
                                        <tr>
                                            <td
                                                style="font-weight:700;color:#0f172a;vertical-align:top;padding-top:6px;">
                                                Deskripsi</td>
                                            <td style="line-height:1.6;">{{ $pengajuan->deskripsi }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            @if (!$accepted)
                                <div
                                    style="background:#fff7ed;border-left:6px solid #fb923c;padding:14px;border-radius:8px;margin-bottom:12px;">
                                    <p style="margin:0;color:#92400e;font-size:14px;">
                                        Mohon diperhatikan: Pengajuan ditolak. Silakan hubungi sekretaris cabang untuk
                                        penjelasan atau perbaikan.
                                    </p>
                                </div>
                            @else
                                <div
                                    style="background:#ecfdf5;border-left:6px solid #10b981;padding:14px;border-radius:8px;margin-bottom:12px;">
                                    <p style="margin:0;color:#065f46;font-size:14px;">
                                        Pengajuan diterima. Silakan cek dashboard untuk langkah selanjutnya atau unduh
                                        surat jika tersedia.
                                    </p>
                                </div>
                            @endif

                            <p style="margin:18px 0 0;color:#6b7280;font-size:13px;">
                                Terima kasih,<br /><strong style="color:#111827">Laci Digital</strong>
                            </p>
                        </td>
                    </tr>

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
