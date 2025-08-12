{{-- File: resources/views/admin/statistics/create.blade.php (Baru) --}}
@extends('layouts.main_layout')

@section('content')
<div class="container-card max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Data Statistik Baru</h1>
    <form action="{{ route('admin.statistics.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kabupaten/Kota --}}
            <div>
                <label for="kab_kota_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                <select name="kab_kota_id" id="kab_kota_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Wilayah</option>
                    @foreach($kabupatenKotas as $kabKota)
                        <option value="{{ $kabKota->id }}">{{ $kabKota->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select name="year" id="year" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Kategori Utama --}}
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-700">Kategori Utama</label>
                <select id="main_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Kategori Utama</option>
                    @foreach($mainCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sub Kategori (Dinamis) --}}
            <div>
                <label for="sub_category_id" class="block text-sm font-medium text-gray-700">Sub Kategori</label>
                <select id="sub_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Kategori Utama dulu</option>
                </select>
            </div>

            {{-- Indikator (Dinamis) --}}
            <div class="md:col-span-2">
                <label for="indicator_id" class="block text-sm font-medium text-gray-700">Indikator</label>
                <select name="indicator_id" id="indicator_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Sub Kategori dulu</option>
                </select>
            </div>

            {{-- Nilai Data --}}
            <div class="md:col-span-2">
                <label for="value" class="block text-sm font-medium text-gray-700">Nilai Data <span id="unit-label" class="text-gray-500"></span></label>
                <input type="number" step="any" name="value" id="value" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Simpan Data</button>
            <a href="{{ route('admin.statistics.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainCategorySelect = document.getElementById('main_category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    const indicatorSelect = document.getElementById('indicator_id');
    const unitLabel = document.getElementById('unit-label');

    mainCategorySelect.addEventListener('change', function () {
        const mainCategoryId = this.value;
        subCategorySelect.innerHTML = '<option value="">Memuat...</option>';
        indicatorSelect.innerHTML = '<option value="">Pilih Sub Kategori dulu</option>';
        unitLabel.textContent = '';

        if (!mainCategoryId) {
            subCategorySelect.innerHTML = '<option value="">Pilih Kategori Utama dulu</option>';
            return;
        }

        fetch(`{{ route('admin.api.sub_categories') }}?main_category_id=${mainCategoryId}`)
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
                data.forEach(subCategory => {
                    subCategorySelect.add(new Option(subCategory.name, subCategory.id));
                });
            });
    });

    subCategorySelect.addEventListener('change', function () {
        const subCategoryId = this.value;
        indicatorSelect.innerHTML = '<option value="">Memuat...</option>';
        unitLabel.textContent = '';

        if (!subCategoryId) {
            indicatorSelect.innerHTML = '<option value="">Pilih Sub Kategori dulu</option>';
            return;
        }

        fetch(`{{ route('admin.api.indicators') }}?sub_category_id=${subCategoryId}`)
            .then(response => response.json())
            .then(data => {
                indicatorSelect.innerHTML = '<option value="">Pilih Indikator</option>';
                data.forEach(indicator => {
                    const option = new Option(indicator.name, indicator.id);
                    option.dataset.unit = indicator.unit;
                    indicatorSelect.add(option);
                });
            });
    });

    indicatorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const unit = selectedOption.dataset.unit;
        unitLabel.textContent = unit ? `(${unit})` : '';
    });
});
</script>
@endpush
@endsection