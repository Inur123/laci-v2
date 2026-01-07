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
    public bool $isHtml;

    public function __construct(string $judul, string $isi, string $pengirim)
    {
        $this->judul = $judul;
        $this->isi = $isi;
        $this->pengirim = $pengirim;

        //  Deteksi apakah isi mengandung HTML
        $this->isHtml = $isi !== strip_tags($isi);

        //  kalau isi full template (ada body), ambil body saja supaya email aman
        if ($this->isHtml) {
            $this->isi = $this->extractBody($this->isi);
        }
    }

    public function build()
    {
        if ($this->isHtml && str_contains($this->isi, '<html')) {

            return $this->subject($this->judul)
                ->html($this->isi);  //  kirim langsung full html
        }

        return $this->subject($this->judul)
            ->view('emails.pengumuman')
            ->with([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'pengirim' => $this->pengirim,
                'isHtml' => $this->isHtml,
            ]);
    }

    private function extractBody(string $html): string
    {
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $match)) {
            return $match[1];
        }
        return $html;
    }
}
