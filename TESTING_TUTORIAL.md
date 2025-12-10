# Tutorial Membuat Unit Testing untuk Project LACI

## Langkah-langkah Setup

### 1. Install Dependencies Testing
Pastikan semua dependencies sudah terinstall:
```bash
composer install
```

### 2. Konfigurasi Environment Testing
Buat file `.env.testing` di root project:
```env
APP_NAME=LACI
APP_ENV=testing
APP_KEY=base64:your-key-here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=:memory:

MAIL_MAILER=array
QUEUE_CONNECTION=sync
```

Atau untuk MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laci_testing
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Factories

#### a. Periode Factory
File sudah dibuat di: `database/factories/PeriodeFactory.php`
```php
public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory(),
        'nama' => fake()->year() . '-' . (fake()->year() + 5),
    ];
}
```

#### b. Anggota Factory
Buat dengan:
```bash
php artisan make:factory AnggotaFactory --model=Anggota
```

Isi dengan:
```php
public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory(),
        'periode_id' => \App\Models\Periode::factory(),
        'nama' => fake()->name(),
        'alamat' => fake()->address(),
        'no_hp' => fake()->phoneNumber(),
    ];
}
```

#### c. Surat Factory
```bash
php artisan make:factory SuratFactory --model=Surat
```

```php
public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory(),
        'periode_id' => \App\Models\Periode::factory(),
        'no_surat' => fake()->unique()->numerify('ST/###/###/'.date('Y')),
        'jenis_surat' => fake()->randomElement(['masuk', 'keluar']),
        'tanggal' => fake()->date(),
        'pengirim_penerima' => fake()->company(),
        'perihal' => fake()->sentence(),
        'deskripsi' => fake()->paragraph(),
    ];
}
```

### 4. Jalankan Test Pertama
```bash
php artisan test --filter=AuthTest
```

## Cara Menulis Test

### Format Dasar Test
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Reset database setiap test

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup yang dijalankan sebelum setiap test
        $this->user = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function test_description()
    {
        // Arrange (Persiapan)
        $data = ['key' => 'value'];

        // Act (Aksi)
        $response = $this->actingAs($this->user)->post('/route', $data);

        // Assert (Verifikasi)
        $response->assertStatus(200);
        $this->assertDatabaseHas('table', $data);
    }
}
```

### Testing Livewire Component
```php
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\Periode;

/** @test */
public function user_can_create_periode()
{
    Livewire::actingAs($this->user)
        ->test(Periode::class)
        ->call('create') // Panggil method create
        ->assertSet('action', 'create') // Assert property
        ->set('nama', '2025-2027') // Set property
        ->call('save') // Panggil method save
        ->assertHasNoErrors() // Assert tidak ada error
        ->assertSet('action', 'index'); // Assert kembali ke index

    // Verify database
    $this->assertDatabaseHas('periodes', [
        'nama' => '2025-2027',
    ]);
}
```

### Testing HTTP Routes
```php
/** @test */
public function dashboard_page_can_be_rendered()
{
    $response = $this->actingAs($this->user)
        ->get(route('cabang.dashboard'));
    
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
}
```

### Testing dengan Factory
```php
/** @test */
public function test_with_factory()
{
    // Create single record
    $periode = Periode::factory()->create([
        'user_id' => $this->user->id,
    ]);

    // Create multiple records
    $periodes = Periode::factory()->count(5)->create([
        'user_id' => $this->user->id,
    ]);

    // Make without saving to database
    $periode = Periode::factory()->make([
        'nama' => '2025-2027',
    ]);
}
```

### Testing File Upload
```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/** @test */
public function user_can_upload_file()
{
    Storage::fake('local');

    $file = UploadedFile::fake()->create('document.pdf', 1000);

    Livewire::actingAs($this->user)
        ->test(ArsipSurat::class)
        ->set('file', $file)
        ->call('save');

    // Assert file was stored
    Storage::disk('local')->assertExists('surat/' . $file->hashName());
}
```

### Testing Validasi
```php
/** @test */
public function nama_is_required()
{
    Livewire::actingAs($this->user)
        ->test(Periode::class)
        ->call('create')
        ->set('nama', '') // Empty nama
        ->call('save')
        ->assertHasErrors(['nama']); // Assert error pada nama
}

/** @test */
public function nama_must_be_unique()
{
    Periode::factory()->create([
        'user_id' => $this->user->id,
        'nama' => '2025-2027',
    ]);

    Livewire::actingAs($this->user)
        ->test(Periode::class)
        ->set('nama', '2025-2027')
        ->call('save')
        ->assertHasErrors(['nama']);
}
```

### Testing Authorization
```php
/** @test */
public function sekretaris_pac_cannot_access_cabang_features()
{
    $pacUser = User::factory()->create([
        'role' => 'sekretaris_pac',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($pacUser)
        ->get(route('cabang.dashboard'));
    
    $response->assertForbidden(); // Assert 403
}
```

### Testing API
```php
/** @test */
public function api_returns_kegiatan_list()
{
    $periode = Periode::factory()->create();
    
    Kegiatan::factory()->count(3)->create([
        'periode_id' => $periode->id,
    ]);

    $response = $this->getJson('/api/kegiatan');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'nama', 'tanggal_mulai', 'periode']
            ],
            'meta' => ['total', 'periode_tersedia']
        ]);
}
```

## Contoh Test Lengkap untuk CRUD

```php
<?php

namespace Tests\Feature\SekretarisCabang;

use Tests\TestCase;
use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\Periode as PeriodeLivewire;

class PeriodeFullTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);

        $this->periode = Periode::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->user->update(['periode_aktif_id' => $this->periode->id]);
    }

    /** @test */
    public function index_page_displays_periodes()
    {
        $response = $this->actingAs($this->user)
            ->get(route('cabang.periode'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(PeriodeLivewire::class);
    }

    /** @test */
    public function can_create_periode()
    {
        Livewire::actingAs($this->user)
            ->test(PeriodeLivewire::class)
            ->call('create')
            ->set('nama', '2025-2027')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('periodes', [
            'user_id' => $this->user->id,
            'nama' => '2025-2027',
        ]);
    }

    /** @test */
    public function can_edit_periode()
    {
        $periode = Periode::factory()->create([
            'user_id' => $this->user->id,
            'nama' => 'Old Name',
        ]);

        Livewire::actingAs($this->user)
            ->test(PeriodeLivewire::class)
            ->call('edit', $periode->id)
            ->set('nama', 'New Name')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('periodes', [
            'id' => $periode->id,
            'nama' => 'New Name',
        ]);
    }

    /** @test */
    public function can_delete_periode()
    {
        $periode = Periode::factory()->create([
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(PeriodeLivewire::class)
            ->call('delete', $periode->id);

        $this->assertDatabaseMissing('periodes', [
            'id' => $periode->id,
        ]);
    }

    /** @test */
    public function search_filters_results()
    {
        Periode::factory()->create([
            'user_id' => $this->user->id,
            'nama' => '2025-2027',
        ]);

        Periode::factory()->create([
            'user_id' => $this->user->id,
            'nama' => '2027-2029',
        ]);

        $component = Livewire::actingAs($this->user)
            ->test(PeriodeLivewire::class)
            ->set('search', '2025');

        $periodes = $component->viewData('periodes');
        $this->assertEquals(1, $periodes->total());
    }
}
```

## Menjalankan Test

```bash
# Jalankan semua test
php artisan test

# Jalankan test tertentu
php artisan test --filter=PeriodeTest

# Jalankan test dengan coverage
php artisan test --coverage

# Jalankan test dengan output detail
php artisan test --verbose

# Jalankan hanya 1 method test
php artisan test --filter=test_user_can_create_periode
```

## Tips Best Practices

1. **Gunakan RefreshDatabase** - Selalu gunakan trait ini untuk clean state
2. **Setup Method** - Gunakan `setUp()` untuk persiapan yang dibutuhkan semua test
3. **Descriptive Names** - Nama test harus jelas mendeskripsikan apa yang ditest
4. **Arrange-Act-Assert** - Ikuti pola AAA untuk struktur test yang jelas
5. **One Assertion Per Test** - Fokus pada satu hal yang ditest
6. **Test Positive & Negative** - Test both happy path dan error cases
7. **Use Factories** - Gunakan factories untuk generate test data
8. **Clean Code** - Test code harus se-clean production code

## Troubleshooting

### Database tidak reset
```bash
php artisan config:clear
php artisan test
```

### Error "Class not found"
```bash
composer dump-autoload
php artisan test
```

### Test timeout
Tambahkan di test:
```php
protected function setUp(): void
{
    parent::setUp();
    $this->withoutExceptionHandling(); // Debug errors
}
```

## Next Steps

1. Buat factories untuk semua models
2. Tulis test untuk setiap fitur
3. Tambahkan CI/CD untuk auto-run tests
4. Aim untuk 80%+ code coverage
5. Update tests saat ada perubahan fitur
