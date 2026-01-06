<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use App\Models\PengajuanSuratPac;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengajuanSuratBaruMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $user;

    public function __construct(PengajuanSuratPac $pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->user = $pengajuan->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Pengajuan Surat Baru - ' . $this->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan-surat-baru', // Ganti ke HTML view
            with: [
                'pengajuan' => $this->pengajuan,
                'user'      => $this->user,
            ],
        );
    }
    public function attachments(): array
    {
        if (!$this->pengajuan->file) {
            return [];
        }

        $filePath = Storage::disk('local')->path($this->pengajuan->file);

        if (!file_exists($filePath)) {
            return [];
        }

        try {
            $decryptedContent = decrypt(file_get_contents($filePath));
        } catch (\Throwable $e) {
            return [];
        }

        $fileName = $this->pengajuan->no_surat . '.pdf';

        return [
            Attachment::fromData(fn() => $decryptedContent, $fileName)
                ->withMime('application/pdf')
        ];
    }
}
