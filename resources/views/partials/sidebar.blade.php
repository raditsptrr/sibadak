<div class="flex flex-col h-full">
    <div class="mb-6 text-center">
        <img src="{{ asset('images/bakorwil3malang.png') }}" alt="Logo Bakorwil" class="mx-auto mb-2 rounded-lg">
        <p class="text-sm text-gray-500">Sistem Badak</p>
    </div>

    <nav class="flex-grow">
        <ul class="space-y-2">
            
            {{-- REVISI: Dashboard Peta sekarang menjadi dropdown yang berisi daftar wilayah --}}
            <li>
                <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition duration-75 group hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H2z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Dashboard Peta</span>
                    <svg class="w-4 h-4 transform transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul class="collapsible-content space-y-1">
                    @isset($kabupatenKotas)
                        @foreach($kabupatenKotas as $kabKota)
                            <li>
                                <a href="#" data-kab-kota-id="{{ $kabKota->id }}" data-kab-kota-name="{{ $kabKota->name }}" class="kab-kota-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">
                                    {{ $kabKota->name }}
                                </a>
                            </li>
                        @endforeach
                    @endisset
                </ul>
            </li>

            <!-- Menu Laporan Dinamis dari Database -->
            @isset($mainCategoriesWithSubs)
                @foreach($mainCategoriesWithSubs as $mainCategory)
                    <li>
                        <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition group hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 3a1 1 0 011-1h2a1 1 0 011 1v13a1 1 0 01-1 1h-2a1 1 0 01-1-1V3z"></path></svg>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $mainCategory->name }}</span>
                            <svg class="w-4 h-4 transform transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul class="collapsible-content space-y-1">
                            @foreach($mainCategory->subCategories as $subCategory)
                                <li>
                                    <a href="{{ route('report.show', $subCategory) }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">
                                        {{ $subCategory->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endisset

            <!-- Menu Admin -->
            @auth
                @if(Auth::user()->role === 'admin')
                <li class="mt-4 pt-4 border-t border-gray-200">
                     <button type="button" class="collapsible-header flex items-center p-2 w-full text-gray-700 rounded-lg transition group hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Kelola Data</span>
                        <svg class="w-4 h-4 transform transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul class="collapsible-content space-y-1">
                        <li><a href="{{ route('admin.statistics.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola Nilai Statistik</a></li>
                        <li><a href="{{ route('admin.indicators.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola Indikator</a></li>
                        <li><a href="{{ route('admin.sub-categories.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola Sub Kategori</a></li>
                        <li><a href="{{ route('admin.main-categories.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola Kategori Utama</a></li>
                        <li><a href="{{ route('admin.kabupaten-kota.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola Kabupaten/Kota</a></li>
                        <li><a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group pl-11">Kelola User</a></li>
                    </ul>
                </li>
                @endif
            @endauth
        </ul>
    </nav>

    <!-- Bagian Bawah Sidebar untuk Profil & Logout -->
    <div class="mt-auto pt-4 border-t border-gray-200">
        @auth
            <a href="{{ route('profile.edit') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                <span class="ml-3">Profil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-left flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 group">
                <span class="ml-3">Login</span>
            </a>
        @endauth
    </div>
</div>
