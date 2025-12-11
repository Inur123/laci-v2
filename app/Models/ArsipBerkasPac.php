<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArsipBerkasPac extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'arsip_berkas_pac';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'periode_id',
        'nama',
        'tanggal',
        'catatan',
        'file_path',
    ];

    protected $casts = [
        'nama' => 'encrypted',
        'catatan' => 'encrypted',
    ];

    /**
     * Accessor untuk tanggal (auto decrypt dan return Carbon)
     */
    public function getTanggalAttribute($value)
    {
        try {
            $decrypted = Crypt::decryptString($value);
            return Carbon::parse($decrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mutator untuk tanggal (auto encrypt)
     */
    public function setTanggalAttribute($value)
    {
        if ($value) {
            $date = $value instanceof Carbon ? $value->format('Y-m-d') : $value;
            $this->attributes['tanggal'] = Crypt::encryptString($date);
        }
    }

    /**
     * Enkripsi file dan simpan
     */
    public static function encryptAndStoreFile($file)
    {
        try {
            $content = file_get_contents($file->getRealPath());
            $encrypted = Crypt::encryptString($content);
            $filename = uniqid() . '_' . time() . '.enc';
            Storage::disk('local')->put('arsip_berkas_pac/' . $filename, $encrypted);
            return 'arsip_berkas_pac/' . $filename;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengenkripsi file: ' . $e->getMessage());
        }
    }

    /**
     * Dekripsi file untuk download
     */
    public function getDecryptedFileAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        try {
            $encryptedContent = Storage::disk('local')->get($this->file_path);
            $decrypted = Crypt::decryptString($encryptedContent);
            return $decrypted;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get original filename
     */
    public function getOriginalFilenameAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        $filename = basename($this->file_path, '.enc');
        return 'Berkas_' . $this->nama . '.pdf';
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    /**
     * Scope untuk filter berdasarkan periode user
     */
    public function scopeByPeriodeUser($query)
    {
        $user = Auth::user();
        if ($user && $user->periode_aktif_id) {
            return $query->where('periode_id', $user->periode_aktif_id);
        }
        return $query;
    }
}
