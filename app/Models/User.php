<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_password_reset_at',
        'last_status_changed_by_admin_at',
        'periode_aktif_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_password_reset_at' => 'datetime',
        'last_status_changed_by_admin_at' => 'datetime',
    ];

    // Relationships
    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    public function periodeAktif()
    {
        return $this->belongsTo(Periode::class, 'periode_aktif_id');
    }

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }

    // Scope untuk filter data berdasarkan periode aktif
    public function scopeWithPeriodeAktif($query)
    {
        $user = Auth::user();

        if ($user && $user->periode_aktif_id) {
            return $query->where('periode_aktif_id', $user->periode_aktif_id);
        }

        return $query;
    }


    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }
}
