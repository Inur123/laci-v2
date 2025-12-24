# Unit Testing Documentation

## Overview
Dokumentasi ini menjelaskan struktur dan cara menjalankan unit testing untuk project LACI (Layanan Arsip Cabang IPNU/IPPNU).

## Struktur Testing

```
tests/
├── Feature/
│   ├── AuthTest.php                          # Testing autentikasi
│   ├── Api/
│   │   └── KegiatanApiTest.php              # Testing API Kegiatan
│   ├── SekretarisCabang/
│   │   ├── PeriodeTest.php                  # Testing Periode Cabang
│   │   ├── AnggotaTest.php                  # Testing Data Anggota Cabang
│   │   ├── ArsipSuratTest.php               # Testing Arsip Surat Cabang
│   │   ├── ArsipBerkasCabangTest.php        # Testing Berkas Cabang
│   │   ├── ArsipBerkasPacTest.php           # Testing Berkas PAC (Cabang)
│   │   ├── KegiatanTest.php                 # Testing Kalender Kegiatan
│   │   └── PengajuanPacTest.php             # Testing Pengajuan PAC
│   └── SekretarisPac/
│       ├── PeriodeTest.php                  # Testing Periode PAC
│       ├── AnggotaTest.php                  # Testing Data Anggota PAC
│       ├── ArsipSuratTest.php               # Testing Arsip Surat PAC
│       ├── ArsipBerkasPacTest.php           # Testing Berkas PAC
│       ├── PengajuanSuratTest.php           # Testing Pengajuan Surat
│       └── ReferensiSuratTest.php           # Testing Referensi Surat
└── Unit/
    └── (Reserved for unit tests)
```

## Setup Testing Environment

### 1. Konfigurasi Database Testing
Edit file `.env.testing` atau tambahkan di `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Atau gunakan database MySQL terpisah:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laci_testing
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Install Dependencies
```bash
composer install
```

## Menjalankan Testing

### Menjalankan Semua Test
```bash
php artisan test
```

### Menjalankan Test Specific
```bash
# Test Authentication
php artisan test --filter=AuthTest

# Test Sekretaris Cabang
php artisan test tests/Feature/SekretarisCabang

# Test Sekretaris PAC  
php artisan test tests/Feature/SekretarisPac

# Test API
php artisan test tests/Feature/Api
```

### Menjalankan Test Dengan Coverage
```bash
php artisan test --coverage
```

### Menjalankan Test dengan Output Verbose
```bash
php artisan test --verbose
```

## Jenis Testing yang Diimplementasikan

### 1. Authentication Tests
- ✅ Login dengan kredensial valid
- ✅ Login dengan kredensial invalid
- ✅ Register user baru
- ✅ Update profile
- ✅ Change password
- ✅ Logout
- ✅ Role-based access control
- ✅ Email verification

### 2. Periode Tests (Cabang & PAC)
- ✅ Create periode baru
- ✅ Edit periode
- ✅ Delete periode
- ✅ Validasi duplicate nama periode
- ✅ Validasi delete periode yang sedang digunakan
- ✅ Pagination dan search
- ✅ Stats periode

### 3. Data Anggota Tests (Cabang & PAC)
- ✅ Create anggota
- ✅ Edit anggota
- ✅ Delete anggota
- ✅ Search dan filter anggota
- ✅ Export Excel
- ✅ Validasi data terenkripsi

### 4. Arsip Surat Tests (Cabang & PAC)
- ✅ Create surat masuk/keluar
- ✅ Edit surat
- ✅ Delete surat
- ✅ Upload file PDF
- ✅ View/Download file terenkripsi
- ✅ Search dan filter surat
- ✅ Export Excel
- ✅ Validasi periode

### 5. Arsip Berkas Tests
- ✅ Create berkas
- ✅ Edit berkas
- ✅ Delete berkas
- ✅ Upload file
- ✅ Download file terenkripsi
- ✅ Search dan filter
- ✅ Export Excel

### 6. Kegiatan Tests (Cabang)
- ✅ Create kegiatan
- ✅ Edit kegiatan
- ✅ Delete kegiatan
- ✅ View detail kegiatan
- ✅ Filter by periode
- ✅ Validasi tanggal

### 7. Pengajuan Tests
- ✅ PAC submit pengajuan
- ✅ Cabang approve/reject pengajuan
- ✅ Email notification
- ✅ Status tracking
- ✅ Download file pengajuan

### 8. API Tests
- ✅ GET /api/kegiatan
- ✅ GET /api/kegiatan/{id}
- ✅ GET /api/kegiatan/upcoming
- ✅ GET /api/kegiatan/past
- ✅ GET /api/kegiatan/stats
- ✅ Validasi authentication
- ✅ Decrypted periode data

## Best Practices

### 1. Database Seeding
Setiap test menggunakan `RefreshDatabase` trait untuk memastikan database bersih.

### 2. Factory Pattern
Gunakan factories untuk create test data:
```php
$user = User::factory()->create();
$periode = Periode::factory()->create(['user_id' => $user->id]);
```

### 3. Test Naming Convention
```php
/** @test */
public function user_can_create_periode()
{
    // Test logic
}
```

### 4. Assertions
```php
// Database assertions
$this->assertDatabaseHas('periodes', ['nama' => '2025-2027']);

// Response assertions
$response->assertStatus(200);
$response->assertSee('Dashboard');

// Livewire assertions
Livewire::test(Periode::class)
    ->assertSet('nama', '2025-2027')
    ->assertHasNoErrors();
```

## Continuous Integration

### GitHub Actions
Tambahkan file `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        
    - name: Install Dependencies
      run: composer install
      
    - name: Run Tests
      run: php artisan test
```

## Coverage Target

Target minimal code coverage:
- Overall: 80%
- Authentication: 90%
- CRUD Operations: 85%
- API Endpoints: 85%

## Troubleshooting

### Error: "Class 'Database\Factories\PeriodeFactory' not found"
```bash
composer dump-autoload
```

### Error: "SQLSTATE connection refused"
Pastikan database testing sudah dikonfigurasi di `.env.testing`

### Error: "Too many connections"
Gunakan SQLite in-memory untuk testing:
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## Reporting Issues

Jika menemukan bug saat testing:
1. Catat test yang gagal
2. Catat error message lengkap
3. Catat environment (PHP version, Laravel version)
4. Buat issue di repository

## Maintenance

### Menambah Test Baru
1. Buat test file: `php artisan make:test NamaTest`
2. Tulis test cases
3. Jalankan test: `php artisan test --filter=NamaTest`
4. Commit jika semua pass

### Update Test After Feature Changes
Setiap kali ada perubahan fitur, pastikan:
1. Update test cases yang relevan
2. Tambah test untuk fitur baru
3. Jalankan semua test sebelum commit
4. Update dokumentasi jika perlu

## Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Livewire Testing Documentation](https://livewire.laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
