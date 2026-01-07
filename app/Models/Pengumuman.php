<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pengumuman extends Model
{
    use HasUuids;

    protected $table = 'pengumuman';

    protected $fillable = [
        'user_id',
        'periode_id',
        'judul',
        'isi',
        'sent_to_count',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    //  Tambahan: relasi log penerima
    public function recipients()
    {
        return $this->hasMany(PengumumanRecipient::class, 'pengumuman_id');
    }
}
