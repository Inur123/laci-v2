# Laci Digital PC IPNU IPPNU Magetan

Sistem manajemen arsip surat dan administrasi digital untuk Pimpinan Cabang (PC) IPNU IPPNU Kabupaten Magetan. Aplikasi ini memfasilitasi pengelolaan surat, data anggota, pengajuan surat, dan kegiatan organisasi dengan sistem multi-periode.

## 📋 Deskripsi Sistem

**Laci Digital** adalah platform berbasis web yang dibangun untuk mendigitalisasi proses administrasi organisasi IPNU IPPNU di tingkat Cabang dan PAC (Pimpinan Anak Cabang). Sistem ini menyediakan:

- **Manajemen Arsip Surat** - Penyimpanan dan pencarian arsip surat digital dengan enkripsi
- **Arsip Berkas PAC & Cabang** - Pengelolaan dokumen administratif PAC dan Cabang yang terenkripsi
- **Data Anggota Multi-Periode** - Pengelolaan keanggotaan berdasarkan periode kepengurusan
- **Sistem Pengajuan Surat** - Workflow pengajuan surat dari PAC ke Cabang
- **Kalender Kegiatan** - Penjadwalan dan monitoring kegiatan organisasi
- **Referensi Surat** - Template surat untuk standardisasi dokumen
- **Export Excel** - Laporan data dalam format Excel dengan tanggal Indonesia
- **Email Notification** - Notifikasi otomatis untuk pengajuan surat
- **Peringatan Periode** - Sistem reminder tentang pentingnya pengelolaan periode

## 🎯 Fitur Utama

### 🔐 Role-Based Access Control (RBAC)
Sistem memiliki 2 role utama:

#### 1. **Sekretaris Cabang**
- Dashboard statistik keseluruhan PAC dengan peringatan periode
- Manajemen arsip surat cabang (keluar/masuk) dengan enkripsi
- **Arsip Berkas PAC** - Pengelolaan dokumen PAC dengan tanggal mulai/berakhir
- **Arsip Berkas Cabang** - Pengelolaan dokumen cabang dengan enkripsi
- **Data User PAC** - Monitor dan kelola semua akun PAC
- Monitor semua data PAC di seluruh cabang
- Approve/reject pengajuan surat dari PAC dengan email notification
- Kalender kegiatan tingkat cabang
- Export data anggota, pengajuan, dan berkas per PAC
- Export berkas PAC dan Cabang dengan format tanggal Indonesia
- Manajemen periode kepengurusan

#### 2. **Sekretaris PAC**
- Dashboard statistik PAC sendiri dengan peringatan periode
- Manajemen arsip surat PAC (keluar/masuk) dengan enkripsi
- Input data anggota per periode dengan enkripsi
- Pengajuan surat ke cabang dengan tracking status
- Referensi template surat untuk kemudahan penulisan
- Export data per periode dengan format tanggal Indonesia
- Manajemen periode kepengurusan PAC

### 📊 Sistem Multi-Periode

Fitur unggulan sistem ini adalah **manajemen periode kepengurusan**:

- Setiap user dapat memiliki multiple periode (contoh: 2023-2024, 2024-2025)
- Switch periode aktif melalui dropdown di header
- Data anggota ter-filter otomatis berdasarkan periode aktif
- Auto-set periode terbaru saat pertama kali login
- Statistik dashboard disesuaikan dengan periode aktif

**Data yang ter-filter per periode:**
- Data Anggota
- Arsip Berkas PAC
- Arsip Berkas Cabang
- Statistik Dashboard
- Anggota baru bulan ini

**Data yang bersifat global (tidak ter-filter):**
- Arsip Surat
- Pengajuan Surat
- Referensi Surat
- Kalender Kegiatan

### 📧 Email Notification System

Sistem mengirimkan notifikasi email otomatis untuk:

1. **Pengajuan Surat Baru** - Email ke Sekretaris Cabang
2. **Status Pengajuan Diupdate** - Email ke Sekretaris PAC (diterima/ditolak)
3. **Pengajuan Terkirim** - Konfirmasi pengajuan berhasil dikirim
4. **Email Verification** - Verifikasi akun baru

### ⚠️ Sistem Peringatan Periode

Fitur reminder penting untuk manajemen periode:

- **Warning Box di Dashboard** - Muncul sekali setelah login pertama
- **Closeable & Minimizable** - Bisa di-minimize atau di-close permanent per session
- **Fixed Bottom Right** - Tidak mengganggu workflow, posisi tetap di pojok kanan bawah
- **Responsive Design** - Menyesuaikan tampilan untuk mobile dan desktop
- **Konten Berbeda per Role** - Peringatan disesuaikan dengan fitur masing-masing role
- **LocalStorage Tracking** - Warning tidak muncul lagi setelah di-close hingga logout
- **Reset Per Login** - Warning muncul kembali setelah logout dan login ulang

**Isi Peringatan untuk Sekretaris Cabang:**
- Penghapusan/perubahan periode mempengaruhi: Arsip Surat, Berkas PAC, Berkas Cabang, Data Anggota, Pengajuan PAC, Kalender Kegiatan

**Isi Peringatan untuk Sekretaris PAC:**
- Penghapusan/perubahan periode mempengaruhi: Arsip Surat, Data Anggota, Pengajuan Surat, Referensi Surat

**Peringatan di Modal Ganti Periode:**
- Warning muncul setiap kali membuka modal ganti periode
- Konten disesuaikan berdasarkan role user
- Tidak bisa di-close (selalu muncul di modal)

### 📁 Manajemen File Terenkripsi

- **File surat dan dokumen** disimpan dengan enkripsi
- **Arsip Berkas PAC & Cabang** menggunakan enkripsi penuh (data dan file)
- **Data terenkripsi**: nama berkas, tanggal, catatan
- **File terenkripsi**: disimpan dengan ekstensi .enc
- Akses file melalui controller khusus dengan signed URL
- Automatic file deletion saat data dihapus
- Storage terorganisir per kategori (surat, anggota, pengajuan, berkas_pac, berkas_cabang)
- Download file otomatis decrypt dan stream ke browser

### 📥 Export Excel

Export data ke format Excel (.xlsx) dengan fitur:

- **Arsip Surat** - Export semua surat per periode
- **Arsip Berkas PAC** - Export berkas PAC dengan periode (YYYY - YYYY), tanggal mulai/berakhir
- **Arsip Berkas Cabang** - Export berkas cabang dengan tanggal
- **Data Anggota** - Export data keanggotaan lengkap
- **Pengajuan Surat** - Export riwayat pengajuan
- **Per PAC** - Sekretaris Cabang dapat export data per PAC
- **Format Tanggal Indonesia** - Tanggal ditampilkan dalam format "20 Desember 2025"
- **Tanpa Kolom Created At** - Export hanya menampilkan data relevan
- **Search Filtering** - Export menyertakan hasil pencarian jika ada
- Loading indicator saat proses download
- Filename dinamis dengan timestamp

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Sanctum + Email Verification
- **Queue**: Database Driver
- **Cache**: Database Driver

### Frontend
- **UI Framework**: Livewire 3.x (Full-stack framework)
- **CSS Framework**: Tailwind CSS 4.0
- **Build Tool**: Vite 7.x
- **Icons**: Font Awesome
- **JavaScript**: Vanilla JS + Alpine.js (via Livewire)

### Package Dependencies
- **maatwebsite/excel**: Export Excel functionality
- **livewire/livewire**: Reactive component framework
- **laravel/sanctum**: API authentication
- **laravel/tinker**: Interactive shell
- **laravel/pail**: Real-time log viewer

## 📁 Struktur Database

### Tabel Utama

#### `users`
```sql
- id (uuid, primary)
- name (string)
- email (string, unique)
- role (enum: 'sekretaris_pac', 'sekretaris_cabang')
- periode_aktif_id (uuid, nullable) -> periodes.id
- email_verified_at (timestamp, nullable)
- password (string)
```

#### `periodes`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id
- nama (string) - contoh: "Periode 2024-2025"
- tanggal_mulai (date)
- tanggal_selesai (date)
- keterangan (text, nullable)
```

#### `anggotas`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id
- periode_id (uuid) -> periodes.id
- nama (string)
- jenis_kelamin (enum: 'laki-laki', 'perempuan')
- tempat_lahir (string)
- tanggal_lahir (date)
- alamat (text)
- file_path (string, encrypted)
```

#### `surats`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id
- nomor_surat (string, unique)
- jenis_surat (string)
- perihal (string)
- tanggal_surat (date)
- file_path (string, encrypted)
```

#### `arsip_berkas_pacs`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id
- periode_id (uuid) -> periodes.id
- nama (text, encrypted) - nama berkas
- tanggal_mulai (text, encrypted) - tanggal mulai periode berkas
- tanggal_berakhir (text, encrypted) - tanggal berakhir periode berkas
- catatan (text, encrypted, nullable)
- file_path (string, nullable) - path file terenkripsi
```

#### `arsip_berkas_cabangs`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id
- periode_id (uuid) -> periodes.id
- nama (text, encrypted) - nama berkas
- tanggal (text, encrypted) - tanggal berkas
- catatan (text, encrypted, nullable)
- file_path (string, nullable) - path file terenkripsi
```

#### `pengajuan_surat_pacs`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id (PAC yang mengajukan)
- periode_id_pac (uuid) -> periodes.id
- jenis_surat (string)
- perihal (string)
- tanggal_pengajuan (date)
- status (enum: 'pending', 'diterima', 'ditolak')
- keterangan_cabang (text, nullable)
- file_path (string, encrypted)
```

#### `kegiatans`
```sql
- id (uuid, primary)
- user_id (uuid) -> users.id (Sekretaris Cabang)
- nama_kegiatan (string)
- deskripsi (text)
- tanggal (date)
- waktu (time)
- tempat (string)
```

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- MAMP/XAMPP (development) atau server web (production)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/Inur123/laci-v2.git
cd laci-v2
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

3. **Environment Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Configuration**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laci_v2
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Mail Configuration** (untuk Email Notification)

Edit file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@domain.com
MAIL_FROM_NAME="Laci Digital PC IPNU IPPNU Magetan"
```

6. **Run Migrations**
```bash
php artisan migrate
```

7. **Create Storage Link**
```bash
php artisan storage:link
```

8. **Build Assets**
```bash
npm run build
```

9. **Run Development Server**
```bash
# Option 1: Using composer script (recommended)
composer run dev

# Option 2: Manual
php artisan serve & php artisan queue:listen & npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🔧 Konfigurasi

### Queue Worker
Untuk menjalankan email notification, aktifkan queue worker:
```bash
php artisan queue:listen
```

Atau gunakan Supervisor (production):
```ini
[program:laci-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
```

### Cron Job (Production)
Tambahkan ke crontab untuk scheduled tasks:
```bash
* * * * * cd /path/to/laci-v2 && php artisan schedule:run >> /dev/null 2>&1
```

### File Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📖 Penggunaan

### Register & Login

1. **Register Akun Baru**
   - Akses `/register`
   - Pilih role: Sekretaris PAC atau Sekretaris Cabang
   - Verifikasi email akan dikirimkan

2. **Verifikasi Email**
   - Cek inbox email
   - Klik link verifikasi
   - Login ke sistem

### Setup Periode (Sekretaris PAC)

1. **Buat Periode Pertama**
   - Login sebagai Sekretaris PAC
   - Menu: **Data Anggota** → **Periode**
   - Klik **Tambah Periode**
   - Isi nama periode (contoh: "Periode 2024-2025")
   - Tentukan tanggal mulai dan selesai

2. **Auto-Set Periode Aktif**
   - Sistem otomatis set periode terbaru sebagai aktif
   - Jika belum ada periode, sistem akan memberi peringatan

3. **Ganti Periode**
   - Klik icon kalender di header (pojok kanan atas)
   - Pilih periode yang diinginkan
   - Data akan ter-refresh otomatis

### Manajemen Data Anggota

1. **Tambah Anggota**
   - Menu: **Data Anggota** → **Anggota**
   - Klik **Tambah Anggota**
   - Isi form data lengkap
   - Upload file dokumen (opsional)
   - Data akan tersimpan di periode aktif

2. **Export Data Anggota**
   - Klik tombol **Download Excel**
   - File akan didownload dengan format: `DataAnggota_NamaPeriode_Timestamp.xlsx`

### Pengajuan Surat (PAC ke Cabang)

1. **Buat Pengajuan** (Sekretaris PAC)
   - Menu: **Pengajuan Surat**
   - Klik **Buat Pengajuan**
   - Isi detail surat
   - Upload file surat
   - Submit pengajuan
   - Email notifikasi dikirim ke Sekretaris Cabang

2. **Review Pengajuan** (Sekretaris Cabang)
   - Menu: **Pengajuan PAC**
   - Lihat detail pengajuan
   - Klik **Terima** atau **Tolak**
   - Isi keterangan (untuk penolakan)
   - Email notifikasi dikirim ke PAC

3. **Cek Status** (Sekretaris PAC)
   - Menu: **Pengajuan Surat**
   - Badge status: Pending (kuning), Diterima (hijau), Ditolak (merah)
   - Lihat keterangan dari cabang

### Arsip Surat

1. **Tambah Surat**
   - Menu: **Arsip Surat**
   - Klik **Tambah Surat**
   - Isi nomor surat (otomatis generated)
   - Upload file surat
   - Simpan

2. **Cari Surat**
   - Gunakan search bar
   - Filter berdasarkan jenis surat
   - Filter berdasarkan tanggal

3. **Export Arsip**
   - Pilih periode (jika PAC)
   - Klik **Download Excel**

### Arsip Berkas PAC & Cabang (Sekretaris Cabang)

1. **Tambah Berkas PAC**
   - Menu: **Arsip Berkas PAC**
   - Klik **Tambah Berkas**
   - Isi nama berkas
   - Pilih tanggal mulai dan tanggal berakhir
   - Isi catatan (opsional)
   - Upload file (PDF, DOC, DOCX, XLS, XLSX, max 10MB)
   - Data tersimpan dengan enkripsi
   - Periode ditampilkan sebagai "2024 - 2025" (dari tanggal mulai/berakhir)

2. **Tambah Berkas Cabang**
   - Menu: **Arsip Berkas Cabang**
   - Klik **Tambah Berkas**
   - Isi nama berkas
   - Pilih tanggal
   - Isi catatan (opsional)
   - Upload file (PDF, DOC, DOCX, XLS, XLSX, max 10MB)
   - Data tersimpan dengan enkripsi

3. **Search & Pagination**
   - Gunakan search bar (live search dengan debounce 500ms)
   - Pencarian berdasarkan nama berkas dan catatan
   - Pagination tanpa mengubah URL (seperti Arsip Surat)
   - 10 data per halaman

4. **Export Berkas**
   - Klik **Download Excel**
   - Export menyertakan hasil search jika ada
   - Format tanggal: "20 Desember 2025"
   - Kolom export:
     - Berkas PAC: No, Nama Berkas, Periode, Tanggal Mulai, Tanggal Berakhir, Catatan, Dibuat Oleh
     - Berkas Cabang: No, Nama Berkas, Tanggal, Catatan, Periode (hidden di tabel), Dibuat Oleh

5. **Edit & Delete**
   - Klik icon edit untuk mengubah data
   - File lama otomatis terhapus saat upload file baru
   - Konfirmasi delete dengan modal
   - Data dan file terenkripsi terhapus permanent

### Kalender Kegiatan (Sekretaris Cabang)

1. **Tambah Kegiatan**
   - Menu: **Kalender Kegiatan**
   - Klik **Tambah Kegiatan**
   - Isi detail kegiatan
   - Tentukan tanggal, waktu, tempat

2. **Lihat Detail**
   - Klik pada card kegiatan
   - Lihat informasi lengkap
   - Edit atau hapus kegiatan

## 🎨 Antarmuka Pengguna

### Dashboard Sekretaris Cabang
- **Peringatan Periode**: Warning box fixed bottom-right yang bisa di-close
- **Statistik PAC**: Total PAC terdaftar, terverifikasi, belum verifikasi, tidak aktif
- **Total Anggota**: Agregat dari semua PAC
- **Pengajuan Pending**: Jumlah pengajuan menunggu review
- **Total Kegiatan**: Kegiatan yang terjadwal
- **Tabel Data PAC**: Daftar semua PAC dengan statistik per periode
- **Quick Actions**: Akses cepat ke fitur utama (Arsip Surat, Berkas PAC, Berkas Cabang)

### Dashboard Sekretaris PAC
- **Peringatan Periode**: Warning box fixed bottom-right yang bisa di-close
- **Total Anggota**: Berdasarkan periode aktif
- **Anggota Laki-Laki/Perempuan**: Distribusi gender
- **Pengajuan Surat**: Total pengajuan dengan status
- **Anggota Bulan Ini**: Anggota baru periode aktif
- **Data Terbaru**: Quick view arsip, anggota, pengajuan

### Komponen UI
- **Dropdown Ganti Periode**: Di header, dengan badge "Aktif" dan warning sesuai role
- **Warning Box Fixed**: Peringatan periode di pojok kanan bawah (closeable & minimizable)
- **Loading Indicators**: Spinner dengan teks "Mengunduh..." saat export
- **Flash Messages**: Notifikasi sukses/error dengan auto-dismiss
- **Modal Konfirmasi**: Untuk aksi delete dan approve/reject
- **Responsive Design**: Mobile-friendly dengan sidebar collapsible
- **Search dengan Debounce**: Live search dengan delay 500ms
- **Pagination Custom**: URL tidak berubah saat pindah halaman (seperti Arsip Surat)

### 🔍 Fitur Pencarian & Filter

### Menu Navigasi Sekretaris Cabang
- 🏠 Dashboard
- 📄 Arsip Surat (Dropdown: Keluar, Masuk)
- 📁 Arsip Berkas PAC
- 📁 Arsip Berkas Cabang
- 👥 Data Anggota (Dropdown: Anggota, Periode)
- 👤 Data User PAC
- 📮 Pengajuan PAC
- 📅 Kalender Kegiatan
- 👤 Profile

### Menu Navigasi Sekretaris PAC
- 🏠 Dashboard
- 📄 Arsip Surat (Dropdown: Keluar, Masuk)
- 👥 Data Anggota (Dropdown: Anggota, Periode)
- 📤 Pengajuan Surat
- 📋 Referensi Surat
- 👤 Profile

### Fitur Pencarian & Filter

### Arsip Surat
- Search: Nomor surat, perihal, jenis surat
- Filter: Jenis surat, rentang tanggal
- Sort: Tanggal surat (terbaru/terlama)

### Data Anggota
- Search: Nama, alamat
- Filter: Jenis kelamin, periode
- Sort: Nama A-Z, tanggal lahir

### Pengajuan Surat
- Search: Perihal, jenis surat
- Filter: Status (pending/diterima/ditolak)
- Filter: Periode (untuk Cabang)
- Sort: Tanggal pengajuan

## 🛡 Keamanan

### Authentication
- Laravel built-in authentication
- Email verification required
- Password hashing dengan bcrypt
- Session-based authentication

### Authorization
- Role-based access control (RBAC)
- Middleware protection untuk routes
- Policy-based authorization untuk actions
- User can only access their own data

### File Security
- Encrypted file storage
- Signed URLs dengan expiration
- File access validation
- Automatic file cleanup on deletion

### Input Validation
- Server-side validation untuk semua form
- File upload validation (type, size)
- CSRF protection
- XSS protection
- SQL injection prevention (Eloquent ORM)

## 📊 Command Artisan

### Set Default Periode
```bash
php artisan periode:set-default
```
Otomatis set periode terbaru untuk user yang belum memiliki periode aktif.

### Clear Cache
```bash
php artisan optimize:clear
```
Clear semua cache (config, route, view, dll).

### Queue Worker
```bash
php artisan queue:listen --tries=1
```
Jalankan queue worker untuk email notifications.

### Migration Fresh (Development)
```bash
php artisan migrate:fresh --seed
```
⚠️ Hati-hati: Menghapus semua data dan reset database.

## 🧪 Testing

Sistem dilengkapi dengan **comprehensive unit testing** untuk memastikan kualitas kode dan mencegah regression bugs.

### Test Coverage

**Total: 100 Tests, 179 Assertions** ✅

#### Authentication Tests (15 tests)
- **LoginTest** (5 tests)
  - Login page rendering
  - Valid/invalid credentials
  - Form validation (email & password required)
- **RegisterTest** (4 tests)
  - Registration page rendering
  - User registration flow
  - Form validation (unique email, required fields)
- **EditProfileTest** (6 tests)
  - Profile page rendering
  - Update name & password
  - Password confirmation validation

#### Sekretaris Cabang Tests (51 tests)
- **AnggotaTest** (7 tests) - CRUD anggota dengan encrypted fields
- **ArsipSuratTest** (7 tests) - Manajemen arsip surat dengan enkripsi
- **PeriodeTest** (6 tests) - Manajemen periode kepengurusan
- **DashboardTest** (2 tests) - Rendering & statistik dashboard
- **ArsipBerkasCabangTest** (5 tests) - CRUD berkas cabang dengan enkripsi
- **ArsipBerkasPacTest** (2 tests) - Viewing berkas PAC
- **KalenderKegiatanTest** (7 tests) - CRUD kegiatan dengan datetime
- **PengajuanPacTest** (2 tests) - Review pengajuan dari PAC
- **DataUserPacTest** (3 tests) - Monitor akun PAC
- **Export Excel** - Tested di setiap module yang ada export

#### Sekretaris PAC Tests (31 tests)
- **AnggotaTest** (8 tests) - CRUD anggota dengan scope per periode
- **ArsipSuratTest** (8 tests) - Arsip surat masuk/keluar
- **PeriodeTest** (7 tests) - Manajemen periode PAC
- **ArsipBerkasPacTest** (5 tests) - CRUD berkas dengan tanggal range (note: uses arsip_berkas_cabang table - bug in component)
- **PengajuanSuratTest** (7 tests) - Submit & track pengajuan
- **DashboardTest** (2 tests) - Statistik PAC

#### API & Example Tests (3 tests)
- ExampleTest - Basic application test
- API endpoint tests

### Test Features

✅ **Factory Pattern** - Consistent test data generation  
✅ **RefreshDatabase** - Clean database per test  
✅ **Livewire Testing** - Component interaction testing  
✅ **File Upload Testing** - Storage::fake() untuk file testing  
✅ **Encrypted Fields** - Testing dengan encrypted data  
✅ **Email Notifications** - Mail::fake() assertions  
✅ **Multi-Periode** - Testing dengan periode aktif  
✅ **Role-Based Testing** - Separate tests per role  

### Run Tests

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/Auth/LoginTest.php

# Run specific test method
php artisan test --filter=can_login_with_correct_credentials

# Stop on first failure
php artisan test --stop-on-failure
```

### Test Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   ├── RegisterTest.php
│   │   └── EditProfileTest.php
│   ├── SekretarisCabang/
│   │   ├── AnggotaTest.php
│   │   ├── ArsipSuratTest.php
│   │   ├── ArsipBerkasCabangTest.php
│   │   ├── ArsipBerkasPacTest.php
│   │   ├── DashboardTest.php
│   │   ├── DataUserPacTest.php
│   │   ├── KalenderKegiatanTest.php
│   │   ├── PengajuanPacTest.php
│   │   └── PeriodeTest.php
│   ├── SekretarisPac/
│   │   ├── AnggotaTest.php
│   │   ├── ArsipSuratTest.php
│   │   ├── ArsipBerkasPacTest.php
│   │   ├── DashboardTest.php
│   │   ├── PengajuanSuratTest.php
│   │   └── PeriodeTest.php
│   └── ExampleTest.php
├── Unit/
└── TestCase.php
```

### Known Issues in Tests

1. **ArsipBerkasPac Component Bug**: Component uses `ArsipBerkasCabang` model instead of `ArsipBerkasPac` model (discovered during testing)
2. **Encrypted Field Assertions**: Cannot use `assertSee()` or `assertDatabaseHas()` with plain text on encrypted fields
3. **Search on Encrypted Data**: Search functionality limited on encrypted fields

### Writing New Tests

Contoh test untuk Livewire component:

```php
<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\YourComponent;

class YourComponentTest extends TestCase
{
    use RefreshDatabase;

    protected $cabang;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cabang = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);

        $this->periode = Periode::factory()->create([
            'user_id' => $this->cabang->id,
        ]);

        $this->cabang->update(['periode_aktif_id' => $this->periode->id]);
    }

    /** @test */
    public function component_can_render()
    {
        $this->actingAs($this->cabang)
            ->get(route('cabang.your-route'))
            ->assertStatus(200);
    }
}
```

## 🐛 Troubleshooting

### Warning periode tidak muncul setelah login
```bash
# Clear browser localStorage
# Buka Console Browser (F12) dan ketik:
localStorage.clear();

# Atau clear cache Laravel
php artisan optimize:clear
```

### Warning periode muncul terus meskipun sudah di-close
```bash
# Pastikan session login_time sudah ter-set
# Cek di Login.php apakah ada:
session(['login_time' => time()]);

# Clear cache dan restart server
php artisan optimize:clear
php artisan serve
```

### Search di Berkas PAC/Cabang tidak berfungsi
```bash
# Pastikan tidak ada method resetPage() yang recursive
# Seharusnya hanya: $this->page = 1;

# Clear cache Livewire
php artisan livewire:discover
php artisan optimize:clear
```

### Pagination tidak bisa di-klik
```bash
# Pastikan menggunakan $set() di view, bukan gotoPage()
# Benar: wire:click="$set('page', {{ $page }})"
# Salah: wire:click="gotoPage({{ $page }})"

# Clear view cache
php artisan view:clear
```

### Periode tidak auto-set
```bash
php artisan periode:set-default
php artisan optimize:clear
```

### Email tidak terkirim
- Cek konfigurasi MAIL di `.env`
- Pastikan queue worker berjalan: `php artisan queue:listen`
- Cek log: `storage/logs/laravel.log`

### File download tidak berfungsi
- Cek storage link: `php artisan storage:link`
- Cek permissions: `chmod -R 775 storage`
- Clear cache: `php artisan optimize:clear`

### Data tidak ter-filter berdasarkan periode
- Pastikan user sudah memilih periode aktif
- Cek `periode_aktif_id` di tabel users tidak null
- Refresh browser dengan Ctrl+Shift+R

### Livewire component tidak update
```bash
php artisan livewire:discover
php artisan optimize:clear
npm run build
```

### Database connection error
- Cek MySQL/MariaDB sudah running
- Verifikasi kredensial DB di `.env`
- Test koneksi: `php artisan migrate:status`

## 📝 Dokumentasi Tambahan

### Dokumentasi Sistem Periode
Lihat file `DOKUMENTASI_SISTEM_PERIODE.md` untuk detail lengkap tentang:
- Cara kerja sistem periode
- Struktur database periode
- Penggunaan middleware CheckPeriodeAktif
- Command artisan untuk periode
- Troubleshooting periode

### API Documentation
Sistem ini memiliki API endpoint untuk aplikasi eksternal:
```
# Kegiatan API (Sekretaris Cabang)
GET    /api/kegiatans         - List semua kegiatan
```

Authentication: Bearer token (Laravel Sanctum)

**Middleware yang digunakan:**
- `auth:sanctum` - Autentikasi API
- `RestrictApiAccess` - Hanya Sekretaris Cabang yang bisa akses

**Response Format:**
```json
{
  "success": true,
  "message": "Success message",
  "data": {...}
}
```

## 🤝 Kontribusi

Kontribusi sangat diterima! Untuk berkontribusi:

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards
- Follow PSR-12 untuk PHP
- Gunakan Laravel best practices
- Tambahkan comments untuk logic kompleks
- Write meaningful commit messages

## 📜 License

MIT License

Copyright (c) 2025 PC IPNU IPPNU Kabupaten Magetan

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## 👥 Tim Pengembang

**Developer**: Muhammad Zainur Roziqin  
**Organization**: PC IPNU IPPNU Kabupaten Magetan  
**Year**: 2025

## 📞 Kontak & Support

- **Developer**: Muhammad Zainur Roziqin
- **Organization**: PC IPNU IPPNU Kabupaten Magetan
- **Email Support**: zainurroziqin38@gmail.com (untuk pertanyaan teknis)
- **GitHub Repository**: [Inur123/laci-v2](https://github.com/Inur123/laci-v2)
- **Report Issues**: [GitHub Issues](https://github.com/Inur123/laci-v2/issues)
- **Documentation**: Lihat README.md dan DOKUMENTASI_SISTEM_PERIODE.md

**Untuk bantuan:**
1. Cek troubleshooting guide di README.md
2. Cek dokumentasi lengkap
3. Buka issue di GitHub dengan detail error
4. Sertakan log dari `storage/logs/laravel.log`

## 📚 Referensi

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Laravel Excel Documentation](https://docs.laravel-excel.com)

---

**Built with ❤️ for PC IPNU IPPNU Kabupaten Magetan**

*Last Updated: December 10, 2025*
