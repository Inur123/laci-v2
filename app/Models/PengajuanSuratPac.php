<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengajuanSuratPac extends Model
{
    use HasUuids;

    protected $table = 'pengajuan_surat_pac';

    protected $fillable = [
        'user_id',
        'no_surat',
        'penerima',
        'tanggal',
        'keperluan',
        'deskripsi',
        'file',
        'status',
    ];

    // No Surat
    public function getNoSuratAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setNoSuratAttribute($value)
    {
        $this->attributes['no_surat'] = Crypt::encryptString($value);
    }

    // Penerima
    public function getPenerimaAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setPenerimaAttribute($value)
    {
        $this->attributes['penerima'] = Crypt::encryptString($value);
    }

    // Tanggal
    public function getTanggalAttribute($value)
    {
        try {
            $decrypted = Crypt::decryptString($value);
            return Carbon::parse($decrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setTanggalAttribute($value)
    {
        if ($value) {
            $date = $value instanceof Carbon ? $value->format('Y-m-d') : $value;
            $this->attributes['tanggal'] = Crypt::encryptString($date);
        }
    }

    // Keperluan
    public function getKeperluanAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setKeperluanAttribute($value)
    {
        $this->attributes['keperluan'] = Crypt::encryptString($value);
    }

    // Deskripsi
    public function getDeskripsiAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setDeskripsiAttribute($value)
    {
        $this->attributes['deskripsi'] = $value ? Crypt::encryptString($value) : null;
    }

    // Status
    public function getStatusAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = Crypt::encryptString($value);
    }

    // File (path terenkripsi)
    public function getFileAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            return null;
        }
    }
    public function setFileAttribute($value)
    {
        $this->attributes['file'] = $value ? Crypt::encryptString($value) : null;
    }

    public static function encryptAndStoreFile($file)
    {
        $content = file_get_contents($file->getRealPath());
        $encrypted = Crypt::encrypt($content); // BUKAN encryptString
        $filename = uniqid() . '_' . time() . '.enc';
        Storage::disk('local')->put('pengajuan_surat_pac/' . $filename, $encrypted);
        return 'pengajuan_surat_pac/' . $filename;
    }

    public function getDecryptedFileAttribute()
    {
        if (!$this->file) return null;
        try {
            $encryptedContent = Storage::disk('local')->get($this->file);
            return Crypt::decrypt($encryptedContent); // Harus decrypt, bukan decryptString
        } catch (\Exception $e) {
            return null;
        }
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
