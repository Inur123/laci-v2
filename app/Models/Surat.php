<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'no_surat',
        'jenis_surat',
        'tanggal',
        'pengirim_penerima',
        'deskripsi',
        'file',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Boot function untuk generate UUID otomatis.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke User (pembuat surat)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter jenis surat
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis_surat', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('jenis_surat', 'keluar');
    }

    /**
     * Accessor untuk nama file
     */
    public function getFileUrlAttribute()
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }
}
