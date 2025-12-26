<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PengumumanRecipient extends Model
{
    use HasUuids;

    protected $table = 'pengumuman_recipients';

    protected $fillable = [
        'pengumuman_id',
        'user_id',
        'email',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function pengumuman()
    {
        return $this->belongsTo(Pengumuman::class, 'pengumuman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
