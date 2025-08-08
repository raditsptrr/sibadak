@extends('layouts.main_layout')

@section('sidebar')
    @include('partials.sidebar', ['kabKotas' => $kabKotas])
@endsection

@section('navbar')
    <div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg flex items-center justify-between w-full">
        <h2 class="text-xl font-semibold text-white">Kelola Data Ekonomi</h2>
    </div>
@endsection

@section('content')
    <div class="container-card">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Form Input Data Ekonomi</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('admin.forms.economic.store') }}" method="POST">
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
                    <label for="economic_growth_rate" class="block text-sm font-medium text-gray-700">Pertumbuhan Ekonomi (%)</label>
                    <input type="number" step="0.01" name="economic_growth_rate" id="economic_growth_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="inflation_rate" class="block text-sm font-medium text-gray-700">Inflasi (%)</label>
                    <input type="number" step="0.01" name="inflation_rate" id="inflation_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="investment_value" class="block text-sm font-medium text-gray-700">Nilai Investasi (Miliar IDR)</label>
                    <input type="number" step="0.01" name="investment_value" id="investment_value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="num_umkm" class="block text-sm font-medium text-gray-700">Jumlah UMKM</label>
                    <input type="number" name="num_umkm" id="num_umkm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="num_cooperatives" class="block text-sm font-medium text-gray-700">Jumlah Koperasi</label>
                    <input type="number" name="num_cooperatives" id="num_cooperatives" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="grdp" class="block text-sm font-medium text-gray-700">PDRB (Miliar IDR)</label>
                    <input type="number" step="0.01" name="grdp" id="grdp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="agriculture_contribution" class="block text-sm font-medium text-gray-700">Kontribusi Pertanian (%)</label>
                    <input type="number" step="0.01" name="agriculture_contribution" id="agriculture_contribution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="forestry_contribution" class="block text-sm font-medium text-gray-700">Kontribusi Kehutanan (%)</label>
                    <input type="number" step="0.01" name="forestry_contribution" id="forestry_contribution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="fisheries_contribution" class="block text-sm font-medium text-gray-700">Kontribusi Perikanan (%)</label>
                    <input type="number" step="0.01" name="fisheries_contribution" id="fisheries_contribution" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
