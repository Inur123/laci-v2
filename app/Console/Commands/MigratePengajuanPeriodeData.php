<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PengajuanSuratPac;
use Illuminate\Support\Facades\DB;

class MigratePengajuanPeriodeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pengajuan:migrate-periode {--force : Paksa migrasi tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi data pengajuan lama: salin periode_id ke periode_id_pac untuk data existing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai migrasi data pengajuan...');

        // Hitung data yang perlu dimigrasi
        $count = PengajuanSuratPac::whereNull('periode_id_pac')
            ->whereNotNull('periode_id')
            ->count();

        if ($count === 0) {
            $this->info('✓ Tidak ada data yang perlu dimigrasi.');
            return Command::SUCCESS;
        }

        $this->warn("Ditemukan {$count} data pengajuan yang perlu dimigrasi.");

        if (!$this->option('force')) {
            if (!$this->confirm('Lanjutkan migrasi?', true)) {
                $this->info('Migrasi dibatalkan.');
                return Command::SUCCESS;
            }
        }

        DB::beginTransaction();

        try {
            // Update: periode_id_pac = periode_id (untuk data lama yang sudah ada periode_id)
            $updated = DB::table('pengajuan_surat_pac')
                ->whereNull('periode_id_pac')
                ->whereNotNull('periode_id')
                ->update(['periode_id_pac' => DB::raw('periode_id')]);

            DB::commit();

            $this->info("✓ Berhasil migrasi {$updated} data pengajuan.");
            $this->line('');
            $this->info('Penjelasan:');
            $this->line('- periode_id_pac: Periode PAC saat mengirim surat');
            $this->line('- periode_id: Periode Cabang saat menerima/memproses');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('✗ Gagal migrasi data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
