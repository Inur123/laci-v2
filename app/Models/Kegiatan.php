<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kegiatan';

    protected $fillable = [
        'user_id',
        'periode_id',
        'judul',
        'deskripsi',
        'lokasi',
        'warna',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    // Scope untuk filter berdasarkan periode user
    public function scopeByPeriodeUser($query)
    {
       $user = Auth::user();
        if ($user && $user->periode_aktif_id) {
            return $query->where('periode_id', $user->periode_aktif_id);
        }
        return $query;
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>=', now())
                     ->orderBy('tanggal_mulai', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('tanggal_mulai', '<', now())
                     ->orderBy('tanggal_mulai', 'desc');
    }

    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('tanggal_mulai', $year)
                     ->whereMonth('tanggal_mulai', $month);
    }

    // Helpers
    public function isOngoing()
    {
        return now()->between($this->tanggal_mulai, $this->tanggal_selesai ?? $this->tanggal_mulai);
    }

    public function isPast()
    {
        return now() > ($this->tanggal_selesai ?? $this->tanggal_mulai);
    }

    public function isUpcoming()
    {
        return now() < $this->tanggal_mulai;
    }
}
