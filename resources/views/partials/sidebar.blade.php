<div class="flex flex-col h-full">
    <div class="mb-6 text-center">
        {{-- Pastikan file logo ada di public/images/bakorwil3malang.png --}}
        <img src="{{ asset('images/bakorwil3malang.png') }}" alt="Logo Bakorwil III Prov. Jatim" class="mx-auto mb-2 rounded-lg" onerror="this.onerror=null;this.src='https://placehold.co/150x50/cccccc/333333?text=LOGO+BAKORWIL';">
        <p class="text-sm text-gray-500">Sistem Badak</p>
    </div>

    <nav class="flex-grow">
        <ul class="space-y-2">
            {{-- Dashboard --}}
            <li>
                <a href="/" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                    {{-- Ikon Dashboard --}}
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H2z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="ml-3">Dashboard Peta</span>
                </a>
            </li>

            {{-- Statistik Demografi --}}
            <li>
                <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition duration-75 group hover:bg-gray-100" aria-controls="dropdown-demografi" data-collapse-target="#dropdown-demografi">
                    {{-- Ikon untuk Statistik Demografi (Bar Chart) --}}
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 3a1 1 0 011-1h2a1 1 0 011 1v13a1 1 0 01-1 1h-2a1 1 0 01-1-1V3z"></path></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Statistik Demografi</span>
                    <svg class="w-4 h-4 transform transition-transform duration-300 rotate-0" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-demografi" class="collapsible-content py-2 space-y-1 hidden">
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'area_sqkm']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Luas Wilayah</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'population']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Jumlah Penduduk</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'poverty_rate']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kemiskinan</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'labor_force']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Tenaga Kerja</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'open_unemployment_rate']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Tingkat Pengangguran Terbuka</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'avg_years_schooling']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Pendidikan</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'life_expectancy']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kesehatan</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'avg_consumption_per_capita']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Konsumsi dan Pendapatan</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'social_protection_coverage']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Perlindungan Sosial</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'demographic', 'indicator' => 'housing_adequacy_rate']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Pemukiman dan Perumahan</a></li>
                </ul>
            </li>

            {{-- Statistik Ekonomi --}}
            <li>
                <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition duration-75 group hover:bg-gray-100" aria-controls="dropdown-ekonomi" data-collapse-target="#dropdown-ekonomi">
                    {{-- Ikon untuk Statistik Ekonomi (Koin Dolar) --}}
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm3 1a1 1 0 100-2 1 1 0 000 2zm3 1a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Statistik Ekonomi</span>
                    <svg class="w-4 h-4 transform transition-transform duration-300 rotate-0" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-ekonomi" class="collapsible-content py-2 space-y-1 hidden">
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'economic_growth_rate']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Pertumbuhan Ekonomi</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'inflation_rate']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Inflasi</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'investment_value']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Investasi</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'num_umkm']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Jumlah UMKM</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'num_cooperatives']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Jumlah Koperasi</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'grdp']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">PDRB</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'agriculture_contribution']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Pertanian</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'forestry_contribution']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kehutanan</a></li>
                    <li><a href="{{ route('report.show', ['type' => 'economic', 'indicator' => 'fisheries_contribution']) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Perikanan</a></li>
                </ul>
            </li>

            {{-- Pilih Kabupaten/Kota (Peta) --}}
            <li>
                <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition duration-75 group hover:bg-gray-100" aria-controls="dropdown-kabkota" data-collapse-target="#dropdown-kabkota">
                    {{-- Ikon Peta --}}
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Kabupaten/Kota</span>
                    <svg class="w-4 h-4 transform transition-transform duration-300 rotate-0" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-kabkota" class="collapsible-content py-2 space-y-1 hidden">
                    @foreach($kabKotas as $kabKota)
                        <li>
                            <a href="#" data-kab-kota-name="{{ $kabKota->name }}" class="kab-kota-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">
                                <span class="ml-3">{{ $kabKota->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>

    <div class="mt-auto pt-4 border-t border-gray-200">
        @auth
            <a href="{{ url('/dashboard') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                <span class="ml-3">Profil</span>
            </a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ url('/admin/statistics') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                    <span class="ml-3">Kelola Data</span>
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-left p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                <span class="ml-3">Login</span>
            </a>
            <a href="{{ route('register') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                <span class="ml-3">Register</span>
            </a>
        @endauth
    </div>
</div>
