<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengumumanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $judul;
    public string $isi;
    public string $pengirim;

    public function __construct(string $judul, string $isi, string $pengirim)
    {
        $this->judul = $judul;
        $this->isi = $isi;
        $this->pengirim = $pengirim;

        // opsional: taruh di queue khusus 'emails'
        $this->onQueue('emails');
    }

    public function build()
    {
        return $this->subject($this->judul)
            ->view('emails.pengumuman');
    }
}
