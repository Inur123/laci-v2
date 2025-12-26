<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PengumumanMail extends Mailable
{
    public string $judul;
    public string $isi;
    public string $pengirim;

    public function __construct(string $judul, string $isi, string $pengirim)
    {
        $this->judul = $judul;
        $this->isi = $isi;
        $this->pengirim = $pengirim;
    }

    public function build()
    {
        // otomatis pakai MAIL_FROM_NAME & MAIL_FROM_ADDRESS dari .env
        return $this->subject($this->judul)
            ->view('emails.pengumuman');
    }
}
