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

class PengajuanTerkirimMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(PengajuanSuratPac $pengajuan)
    {
        $this->pengajuan = $pengajuan->load('user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Surat Berhasil - ' . $this->pengajuan->no_surat,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan-terkirim',
            with: ['pengajuan' => $this->pengajuan]
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

        $decryptedContent = decrypt(file_get_contents($filePath));
        $fileName = $this->pengajuan->no_surat . '.pdf';

        return [
            Attachment::fromData(fn() => $decryptedContent, $fileName)
                ->withMime('application/pdf')
        ];
    }
}
