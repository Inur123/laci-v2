<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArsipBerkasSp extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'arsip_berkas_sp';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'periode_id',
        'nama',
        'tanggal_mulai',
        'tanggal_berakhir',
        'catatan',
        'file_path',
    ];

    protected $casts = [
        'nama' => 'encrypted',
        'catatan' => 'encrypted',
    ];

    /**
     * Accessor untuk tanggal_mulai (auto decrypt)
     */
    public function getTanggalMulaiAttribute($value)
    {
        try {
            $decrypted = Crypt::decryptString($value);
            return Carbon::parse($decrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mutator untuk tanggal_mulai (auto encrypt)
     */
    public function setTanggalMulaiAttribute($value)
    {
        if ($value) {
            $date = $value instanceof Carbon ? $value->format('Y-m-d') : $value;
            $this->attributes['tanggal_mulai'] = Crypt::encryptString($date);
        }
    }

    /**
     * Accessor untuk tanggal_berakhir (auto decrypt)
     */
    public function getTanggalBerakhirAttribute($value)
    {
        try {
            $decrypted = Crypt::decryptString($value);
            return Carbon::parse($decrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mutator untuk tanggal_berakhir (auto encrypt)
     */
    public function setTanggalBerakhirAttribute($value)
    {
        if ($value) {
            $date = $value instanceof Carbon ? $value->format('Y-m-d') : $value;
            $this->attributes['tanggal_berakhir'] = Crypt::encryptString($date);
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
            Storage::disk('local')->put('arsip_berkas_sp/' . $filename, $encrypted);
            return 'arsip_berkas_sp/' . $filename;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengenkripsi file: ' . $e->getMessage());
        }
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
