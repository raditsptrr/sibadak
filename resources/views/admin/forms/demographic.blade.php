@extends('layouts.main_layout')

@section('sidebar')
    @include('partials.sidebar', ['kabKotas' => $kabKotas])
@endsection

@section('navbar')
    <div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg flex items-center justify-between w-full">
        <h2 class="text-xl font-semibold text-white">Kelola Data Demografi</h2>
    </div>
@endsection

@section('content')
    <div class="container-card">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Form Input Data Demografi</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('admin.forms.demographic.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="kab_kota_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <select name="kab_kota_id" id="kab_kota_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Pilih Kabupaten/Kota</option>
                        @foreach($kabKotas as $kabKota)
                            <option value="{{ $kabKota->id }}">{{ $kabKota->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="number" name="year" id="year" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="area_sqkm" class="block text-sm font-medium text-gray-700">Luas Wilayah (km²)</label>
                    <input type="number" step="0.01" name="area_sqkm" id="area_sqkm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="population" class="block text-sm font-medium text-gray-700">Jumlah Penduduk</label>
                    <input type="number" name="population" id="population" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="poverty_rate" class="block text-sm font-medium text-gray-700">Tingkat Kemiskinan (%)</label>
                    <input type="number" step="0.01" name="poverty_rate" id="poverty_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="labor_force" class="block text-sm font-medium text-gray-700">Tenaga Kerja</label>
                    <input type="number" name="labor_force" id="labor_force" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="open_unemployment_rate" class="block text-sm font-medium text-gray-700">Tingkat Pengangguran Terbuka (%)</label>
                    <input type="number" step="0.01" name="open_unemployment_rate" id="open_unemployment_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="avg_years_schooling" class="block text-sm font-medium text-gray-700">Rata-rata Lama Sekolah (tahun)</label>
                    <input type="number" step="0.01" name="avg_years_schooling" id="avg_years_schooling" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="literacy_rate" class="block text-sm font-medium text-gray-700">Tingkat Melek Huruf (%)</label>
                    <input type="number" step="0.01" name="literacy_rate" id="literacy_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="life_expectancy" class="block text-sm font-medium text-gray-700">Angka Harapan Hidup (tahun)</label>
                    <input type="number" step="0.01" name="life_expectancy" id="life_expectancy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="infant_mortality_rate" class="block text-sm font-medium text-gray-700">Angka Kematian Bayi</label>
                    <input type="number" step="0.01" name="infant_mortality_rate" id="infant_mortality_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="avg_consumption_per_capita" class="block text-sm font-medium text-gray-700">Rata-rata Konsumsi per Kapita (IDR)</label>
                    <input type="number" step="0.01" name="avg_consumption_per_capita" id="avg_consumption_per_capita" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="social_protection_coverage" class="block text-sm font-medium text-gray-700">Cakupan Perlindungan Sosial (%)</label>
                    <input type="number" step="0.01" name="social_protection_coverage" id="social_protection_coverage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="housing_adequacy_rate" class="block text-sm font-medium text-gray-700">Tingkat Kecukupan Perumahan (%)</label>
                    <input type="number" step="0.01" name="housing_adequacy_rate" id="housing_adequacy_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
