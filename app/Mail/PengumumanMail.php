<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    }

    public function build()
    {
        return $this->subject($this->judul)
            ->view('emails.pengumuman');
    }
}
