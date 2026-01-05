<?php

namespace App\Mail;

use App\Models\PengajuanSuratPac;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // <-- tambah
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PengajuanTerkirimMail extends Mailable implements ShouldQueue // <-- tambah
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(PengajuanSuratPac $pengajuan)
    {
        $this->pengajuan = $pengajuan->load('user');

        // opsional: kalau mau masuk queue khusus 'emails'
        $this->onQueue('emails');
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
