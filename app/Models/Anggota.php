<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'periode_id',
        'nik',
        'nia',
        'email',
        'foto',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_lengkap',
        'no_hp',
        'hobi',
        'jabatan',
        'no_rfid',
    ];

    // Fields yang akan dienkripsi (text fields)
    protected $encrypted = [
        'nik',
        'nia',
        'email',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_lengkap',
        'no_hp',
        'hobi',
        'jabatan',
        'no_rfid',
    ];

    // Auto encrypt saat set attribute
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypted) && !empty($value)) {
            $value = Crypt::encryptString($value);
        }

        return parent::setAttribute($key, $value);
    }

    // Auto decrypt saat get attribute
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encrypted) && !empty($value)) {
            try {
                $value = Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }

    // Enkripsi foto (static method agar bisa dipanggil tanpa instance)
    public static function encryptAndStoreFoto($file)
    {
        try {
            // Baca content file
            $content = file_get_contents($file->getRealPath());

            // Enkripsi content
            $encrypted = Crypt::encryptString($content);

            // Generate nama file unik
            $filename = uniqid() . '_' . time() . '.enc';

            // Simpan ke storage/app/anggota (private)
            Storage::disk('local')->put('anggota/' . $filename, $encrypted);

            return 'anggota/' . $filename;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengenkripsi foto: ' . $e->getMessage());
        }
    }

    // Dekripsi foto
    public function getDecryptedFotoAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        try {
            // Ambil file encrypted
            $encryptedContent = Storage::disk('local')->get($this->foto);

            // Dekripsi
            $decrypted = Crypt::decryptString($encryptedContent);

            // Convert ke base64
            $base64 = base64_encode($decrypted);

            // Detect MIME type
            $mimeType = $this->getMimeTypeFromContent($decrypted);

            // Return sebagai data URL
            return "data:{$mimeType};base64,{$base64}";
        } catch (\Exception $e) {
            return null;
        }
    }

    // Helper: detect MIME type dari content
    private function getMimeTypeFromContent($content)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $content);
        finfo_close($finfo);

        return $mimeType ?: 'image/jpeg';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    // Scope untuk filter berdasarkan periode user login
    public function scopeByPeriodeUser($query)
    {
        $user = Auth::user();
        if ($user && $user->periode_aktif_id) {
            return $query->where('periode_id', $user->periode_aktif_id);
        }
        return $query;
    }

    // Helpers
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->nama_lengkap);
        return strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    }

    public function getAvatarUrlAttribute()
    {
        // Gunakan foto yang sudah didekripsi
        if ($this->foto) {
            return $this->decrypted_foto;
        }

        $name = urlencode($this->nama_lengkap);
        $color = $this->jenis_kelamin === 'Laki-laki' ? '3b82f6' : 'ec4899';
        return "https://ui-avatars.com/api/?name={$name}&background={$color}&color=fff";
    }

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) return null;

        return Carbon::parse($this->tanggal_lahir)->age;
    }
    public function getTanggalLahirAttribute($value)
{
    if (empty($value)) return null;

    try {
        $decrypted = Crypt::decryptString($value);
        return Carbon::createFromFormat('Y-m-d', $decrypted)->startOfDay();
    } catch (\Exception $e) {
        return null;
    }
}
}
