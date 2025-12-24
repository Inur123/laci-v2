<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Surat extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'surat';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'periode_id',
        'no_surat',
        'jenis_surat',
        'tanggal',
        'pengirim_penerima',
        'deskripsi',
        'file',
        'perihal',
    ];

    protected $casts = [
        'no_surat' => 'encrypted',
        'jenis_surat' => 'encrypted',
        'pengirim_penerima' => 'encrypted',
        'deskripsi' => 'encrypted',
        'perihal' => 'encrypted',
        // ❌ HAPUS 'tanggal' => 'date' karena kita enkripsi manual
    ];

    /**
     * ✅ Accessor untuk tanggal (auto decrypt)
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
     * ✅ Mutator untuk tanggal (auto encrypt)
     */
    public function setTanggalAttribute($value)
    {
        if ($value) {
            $date = $value instanceof Carbon ? $value->format('Y-m-d') : $value;
            $this->attributes['tanggal'] = Crypt::encryptString($date);
        }
    }

    /**
     * Enkripsi file PDF dan simpan (static method)
     */
    public static function encryptAndStoreFile($file)
    {
        try {
            $content = file_get_contents($file->getRealPath());
            $encrypted = Crypt::encryptString($content);
            $filename = uniqid() . '_' . time() . '.enc';
            Storage::disk('local')->put('surat/' . $filename, $encrypted);
            return 'surat/' . $filename;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengenkripsi file: ' . $e->getMessage());
        }
    }

    /**
     * Dekripsi file untuk download
     */
    public function getDecryptedFileAttribute()
    {
        if (!$this->file) {
            return null;
        }

        try {
            $encryptedContent = Storage::disk('local')->get($this->file);
            $decrypted = Crypt::decryptString($encryptedContent);
            return $decrypted;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get original filename (untuk display)
     */
    public function getOriginalFilenameAttribute()
    {
        if (!$this->file) {
            return null;
        }

        $filename = basename($this->file, '.enc');
        return 'Surat_' . $this->no_surat . '.pdf';
    }

    /**
     * Relasi ke User (pembuat surat)
     */
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

    /**
     * Scope untuk filter jenis surat
     */
    public function scopeMasuk($query)
    {
        return $query->get()->filter(function($surat) {
            return $surat->jenis_surat === 'masuk';
        });
    }

    public function scopeKeluar($query)
    {
        return $query->get()->filter(function($surat) {
            return $surat->jenis_surat === 'keluar';
        });
    }
}
