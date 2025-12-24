<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/kalender-kegiatan/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kalender Kegiatan</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan lihat jadwal kegiatan</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total Kegiatan</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->totalKegiatan }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Bulan Ini</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->kegiatanBulanIni }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-calendar-check text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Mendatang</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->kegiatanMendatang }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-clock text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Selesai</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->kegiatanSelesai }}</h3>
                </div>
                <div class="bg-gray-100 text-gray-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-check-circle text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <!-- Calendar -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::createFromDate($currentYear, $currentMonth)->format('F Y') }}
                </h3>
                <div class="flex gap-2">
                    <button wire:click="previousMonth"
                        class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 transition text-sm cursor-pointer">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        wire:click="$set('currentMonth', {{ now()->month }}); $set('currentYear', {{ now()->year }})"
                        class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 transition text-sm cursor-pointer">
                        Hari Ini
                    </button>
                    <button wire:click="nextMonth"
                        class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 transition text-sm cursor-pointer">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Calendar Grid -->
            @php
                $firstDayOfMonth = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);
                $daysInMonth = $firstDayOfMonth->daysInMonth;
                $startDay = $firstDayOfMonth->dayOfWeek;
                $today = now();

                // Prepare calendar data structure
                $calendarGrid = [];
                $currentWeek = 0;

                // Fill empty days before month starts
                for ($i = 0; $i < $startDay; $i++) {
                    $calendarGrid[$currentWeek][] = null;
                }

                // Fill month days
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day);
                    $calendarGrid[$currentWeek][] = $currentDate;

                    if (count($calendarGrid[$currentWeek]) == 7) {
                        $currentWeek++;
                    }
                }

                // Fill remaining days
                while (count($calendarGrid[$currentWeek] ?? []) < 7) {
                    $calendarGrid[$currentWeek][] = null;
                }
            @endphp

            <div class="space-y-1">
                <!-- Header Days -->
                <div class="grid grid-cols-7 gap-1">
                    @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                        <div class="text-center text-xs sm:text-sm font-semibold text-gray-700 py-2 bg-gray-50 rounded">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Body -->
                @foreach ($calendarGrid as $weekIndex => $week)
                    <div class="grid grid-cols-7 gap-1 relative" style="min-height: 90px;">
                        @foreach ($week as $dayIndex => $date)
                            <div
                                class="relative border border-gray-100 rounded p-1 min-h-[80px] {{ $date ? 'bg-white' : 'bg-gray-50' }}">
                                @if ($date)
                                    <!-- Date Number -->
                                    <div
                                        class="text-xs sm:text-sm font-medium
                                        {{ $date->isToday() ? 'bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center mx-auto' : 'text-gray-700' }}">
                                        {{ $date->day }}
                                    </div>

                                    <!-- Single Day Events -->
                                    @php
                                        $dayEvents = $calendarEvents->filter(function ($event) use ($date) {
                                            $start = $event->tanggal_mulai->startOfDay();
                                            $end = $event->tanggal_selesai
                                                ? $event->tanggal_selesai->startOfDay()
                                                : $start;

                                            // Only show if event starts on this day or is single-day
                                            return $start->isSameDay($date) && $start->isSameDay($end);
                                        });
                                    @endphp

                                    @foreach ($dayEvents->take(2) as $event)
                                        <div wire:click="detail('{{ $event->id }}')"
                                            class="mt-1 px-1 py-0.5 rounded text-xs cursor-pointer hover:opacity-80 transition truncate"
                                            style="background-color: {{ $event->warna }}; color: white;"
                                            title="{{ $event->judul }} - {{ $event->tanggal_mulai->format('H:i') }}">
                                            <i class="fas fa-circle text-[6px] mr-1"></i>
                                            <span class="font-medium">{{ Str::limit($event->judul, 15) }}</span>
                                        </div>
                                    @endforeach

                                    @if ($dayEvents->count() > 2)
                                        <div class="mt-1 px-1 text-xs text-gray-500">
                                            +{{ $dayEvents->count() - 2 }} lagi
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach

                        <!-- Multi-day Events (Spanning Blocks) -->
                        @php
                            $multiDayEvents = $calendarEvents->filter(function ($event) use ($week) {
                                if (!$event->tanggal_selesai) {
                                    return false;
                                }

                                $start = $event->tanggal_mulai->startOfDay();
                                $end = $event->tanggal_selesai->startOfDay();

                                // Check if event spans multiple days and intersects this week
                                return !$start->isSameDay($end) &&
                                    collect($week)
                                        ->filter()
                                        ->some(function ($date) use ($start, $end) {
                                            return $date && $date->between($start, $end);
                                        });
                            });
                        @endphp

                        @foreach ($multiDayEvents as $eventIndex => $event)
                            @php
                                $start = $event->tanggal_mulai->startOfDay();
                                $end = $event->tanggal_selesai->startOfDay();

                                // Find start and end position in this week
                                $startCol = null;
                                $endCol = null;
                                $isFirstWeek = false;
                                $isLastWeek = false;

                                foreach ($week as $colIndex => $date) {
                                    if ($date) {
                                        if ($date->isSameDay($start)) {
                                            $startCol = $colIndex;
                                            $isFirstWeek = true;
                                        }
                                        if ($date->isSameDay($end)) {
                                            $endCol = $colIndex;
                                            $isLastWeek = true;
                                        }
                                        if ($date->between($start, $end)) {
                                            if ($startCol === null) {
                                                $startCol = $colIndex;
                                            }
                                            $endCol = $colIndex;
                                        }
                                    }
                                }

                                if ($startCol === null || $endCol === null) {
                                    continue;
                                }

                                $spanCols = $endCol - $startCol + 1;
                                $topOffset = 35 + $eventIndex * 22;
                            @endphp

                            <div wire:click="detail('{{ $event->id }}')"
                                class="absolute px-2 py-1 rounded cursor-pointer hover:shadow-lg transition-all z-10 group"
                                style="
                                    left: calc((100% / 7) * {{ $startCol }} + 2px);
                                    width: calc((100% / 7) * {{ $spanCols }} - 4px);
                                    top: {{ $topOffset }}px;
                                    background-color: {{ $event->warna }};
                                    color: white;
                                ">
                                <div class="flex items-center justify-between text-xs font-medium">
                                    <div class="truncate flex items-center gap-1">
                                        @if ($isFirstWeek)
                                            <i class="fas fa-play text-[8px]"></i>
                                        @endif
                                        <span>{{ Str::limit($event->judul, 25) }}</span>
                                        @if ($isLastWeek)
                                            <i class="fas fa-stop text-[8px]"></i>
                                        @endif
                                    </div>
                                    @if ($isFirstWeek)
                                        <span class="text-[10px] opacity-90">
                                            {{ $event->tanggal_mulai->format('H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Tooltip on Hover -->
                                <div
                                    class="hidden group-hover:block absolute left-0 top-full mt-1 bg-gray-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap shadow-lg z-20">
                                    <div class="font-semibold">{{ $event->judul }}</div>
                                    <div class="opacity-90">{{ $event->tanggal_mulai->format('d M') }} -
                                        {{ $event->tanggal_selesai->format('d M Y') }}</div>
                                    @if ($event->lokasi)
                                        <div class="opacity-75"><i
                                                class="fas fa-map-marker-alt mr-1"></i>{{ $event->lokasi }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <!-- Legend -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                            {{ now()->day }}</div>
                        <span class="text-gray-600">Hari Ini</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-4 bg-blue-500 rounded"></div>
                        <span class="text-gray-600">Event 1 Hari</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-16 h-4 bg-green-500 rounded"></div>
                        <span class="text-gray-600">Event Multi-hari</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Kegiatan Mendatang</h3>
            </div>

            <div class="space-y-3 sm:space-y-4 max-h-[600px] overflow-y-auto">
                @forelse($this->upcomingEvents as $event)
                    <div class="border-l-4 p-3 sm:p-4 rounded-r cursor-pointer hover:shadow-md transition"
                        style="border-color: {{ $event->warna }}; background-color: {{ $event->warna }}20;"
                        wire:click="detail('{{ $event->id }}')">
                        <div class="flex items-start justify-between mb-2">
                            @if ($event->tanggal_mulai->isToday())
                                <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-medium">Hari
                                    Ini</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-medium"
                                    style="background-color: {{ $event->warna }}40; color: {{ $event->warna }};">
                                    {{ $event->tanggal_mulai->format('d M') }}
                                </span>
                            @endif
                            <span class="text-xs text-gray-500">{{ $event->tanggal_mulai->format('H:i') }}</span>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1 text-sm">{{ $event->judul }}</h4>

                        @if ($event->tanggal_selesai && !$event->tanggal_mulai->isSameDay($event->tanggal_selesai))
                            <div class="flex items-center text-xs text-gray-600 mb-1">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $event->tanggal_mulai->format('d M') }} -
                                {{ $event->tanggal_selesai->format('d M Y') }}
                            </div>
                        @endif

                        @if ($event->lokasi)
                            <div class="flex items-center text-xs text-gray-600">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ Str::limit($event->lokasi, 25) }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-calendar-times text-3xl mb-2 block"></i>
                        <p class="text-sm">Tidak ada kegiatan mendatang</p>
                    </div>
                @endforelse
            </div>

            <button wire:click="create"
                class="w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm sm:text-base cursor-pointer">
                <i class="fas fa-plus mr-2"></i>Tambah Kegiatan
            </button>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Cari Kegiatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                <input type="text" wire:model.live="search" placeholder="Judul, lokasi, deskripsi..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="upcoming">Mendatang</option>
                    <option value="past">Selesai</option>
                </select>
            </div>

            <!-- Tombol Tambah Kegiatan -->
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg
                hover:bg-blue-700 transition text-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Tambah Kegiatan
                </button>
            </div>

        </div>
    </div>


    <!-- List View -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Semua Kegiatan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Judul Kegiatan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Lokasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kegiatans as $index => $kegiatan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $kegiatans->firstItem() + $index }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full flex-shrink-0"
                                        style="background-color: {{ $kegiatan->warna }};"></div>
                                    <span class="text-sm font-medium text-gray-800">{{ $kegiatan->judul }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                {{ $kegiatan->tanggal_mulai->format('d M Y, H:i') }}
                                @if ($kegiatan->tanggal_selesai)
                                    <br><span class="text-xs text-gray-500">s/d
                                        {{ $kegiatan->tanggal_selesai->format('d M Y, H:i') }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $kegiatan->lokasi ?? '-' }}</td>
                            <td class="py-3 px-4">
                                @if ($kegiatan->isOngoing())
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Berlangsung</span>
                                @elseif($kegiatan->isPast())
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">Selesai</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Mendatang</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $kegiatan->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transitio cursor-pointer" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit('{{ $kegiatan->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition cursor-pointer" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="confirmDeleteKegiatan('{{ $kegiatan->id }}', '{{ $kegiatan->judul }}')"
                                        class="text-red-600 hover:text-red-800 transition cursor-pointer" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-2 block"></i>
                                <p>Belum ada kegiatan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kegiatans->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $kegiatans->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $kegiatans->lastItem() }}</span>
                        dari <span class="font-medium">{{ $kegiatans->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($kegiatans->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="previousPage" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @foreach ($kegiatans->getUrlRange(1, $kegiatans->lastPage()) as $page => $url)
                            @if ($page == $kegiatans->currentPage())
                                <span
                                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        @if ($kegiatans->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDeleteKegiatan(id, judul) {
        Swal.fire({
            title: 'Hapus Kegiatan?',
            html: `Kegiatan <strong>${judul}</strong> akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
            }
        });
    }
</script>
