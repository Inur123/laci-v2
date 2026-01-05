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

class PengajuanStatusMail extends Mailable implements ShouldQueue // <-- tambah
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(PengajuanSuratPac $pengajuan)
    {
        $this->pengajuan = $pengajuan->load('user');

        // opsional: taruh di queue khusus 'emails' (samakan)
        $this->onQueue('emails');
    }

    public function envelope(): Envelope
    {
        $label = $this->pengajuan->status === 'diterima' ? 'Diterima' : 'Ditolak';

        return new Envelope(
            subject: "Status Pengajuan Anda: {$label} - " . $this->pengajuan->no_surat,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan-status',
            with: ['pengajuan' => $this->pengajuan]
        );
    }

    public function attachments(): array
    {
        if (!$this->pengajuan->file) {
            return [];
        }

        $filePath = Storage::disk('local')->path($this->pengajuan->file);
        if (!file_exists($filePath)) return [];

        try {
            $decrypted = decrypt(file_get_contents($filePath));
        } catch (\Throwable $e) {
            return [];
        }

        $fileName = ($this->pengajuan->no_surat ?: 'lampiran') . '.pdf';

        return [
            Attachment::fromData(fn() => $decrypted, $fileName)
                ->withMime('application/pdf')
        ];
    }
}
