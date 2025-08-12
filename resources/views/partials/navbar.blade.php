<div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg w-full">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <!-- Kiri: Judul dan Kabupaten -->
        <div class="flex items-baseline flex-wrap gap-x-2">
            <h2 class="text-xl font-semibold text-white">
                Data Statistik 
                <span id="selectedKabKotaDisplay" class="text-orange-300">
                    {{-- Nama Kabupaten/Kota akan diisi oleh JavaScript --}}
                </span>
            </h2>
        </div>

        <!-- Kanan: Filter -->
        <div class="flex flex-wrap items-center gap-x-6 gap-y-4">
            <!-- Filter Jenis Data (Dibuat Dinamis) -->
            <div class="flex items-center gap-2">
                <label class="text-white text-sm">Jenis Data:</label>
                <div class="flex items-center gap-1 bg-blue-600 p-1 rounded-lg">
                    {{-- Looping untuk membuat tombol kategori dari database --}}
                    @foreach($mainCategories as $index => $category)
                        <button 
                            data-category-id="{{ $category->id }}" 
                            class="category-filter-btn px-3 py-1 text-sm rounded-md text-white 
                                   {{ $index == 0 ? 'bg-blue-700 shadow' : 'hover:bg-blue-700' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Filter Tahun (Dibuat Dinamis) -->
            <div class="flex items-center gap-2">
                <label for="yearFilter" class="text-white text-sm">Tahun:</label>
                <select id="yearFilter" class="px-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white">
                    {{-- Looping untuk membuat opsi tahun dari database --}}
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
