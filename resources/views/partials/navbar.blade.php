<div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg w-full">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <!-- Kiri: Judul dan Kabupaten -->
        <div class="flex items-baseline flex-wrap gap-x-2">
            <h2 class="text-xl font-semibold text-white" id="mainTitle">
                Data Statistik Demografi Tahun 2023
            </h2>
            <span class="text-xl font-semibold text-orange-300" id="selectedKabKotaDisplay">
                ( Kabupaten Blitar )
            </span>
        </div>

        <!-- Kanan: Filter & Search -->
        <div class="flex flex-wrap items-center gap-4">
            <!-- Filter Jenis Data -->
            <div class="flex items-center gap-2">
                <label for="dataTypeFilter" class="text-white text-sm">
                    Jenis Data Statistik:
                </label>
                <select id="dataTypeFilter"
                    class="px-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white">
                    <option value="demography">Demografi</option>
                    <option value="economy">Ekonomi</option>
                </select>
            </div>

            <!-- Filter Tahun -->
            <div class="flex items-center gap-2">
                <label for="yearFilter" class="text-white text-sm">
                    Tahun:
                </label>
                <select id="yearFilter"
                    class="px-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white">
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
            </div>

            <!-- Search -->
            <div class="relative">
                <input type="text" placeholder="Search"
                    class="pl-8 pr-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white placeholder-blue-200">
                <svg class="w-4 h-4 text-blue-200 absolute left-2 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>
