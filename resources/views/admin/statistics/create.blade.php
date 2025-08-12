@extends('layouts.main_layout')

@section('content')
{{-- [DIUBAH] Menghapus class 'max-w-2xl mx-auto' agar tidak terpusat --}}
<div class="container-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Tambah Data Statistik Baru</h1>
    
    <form action="{{ route('admin.statistics.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

            {{-- [DIUBAH] Seluruh field disesuaikan gayanya --}}
            
            {{-- Kabupaten/Kota --}}
            <div>
                <label for="kab_kota_id" class="block text-sm font-medium text-gray-600 mb-2">Kabupaten/Kota</label>
                <div class="relative">
                    <select name="kab_kota_id" id="kab_kota_id" required class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Wilayah</option>
                        @foreach($kabupatenKotas as $kabKota)
                            <option value="{{ $kabKota->id }}" {{ old('kab_kota_id') == $kabKota->id ? 'selected' : '' }}>{{ $kabKota->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('kab_kota_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Tahun --}}
            <div>
                <label for="year" class="block text-sm font-medium text-gray-600 mb-2">Tahun</label>
                <div class="relative">
                    <select name="year" id="year" required class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                     <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori Utama --}}
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-600 mb-2">Kategori Utama</label>
                <div class="relative">
                    <select id="main_category_id" required class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Kategori Utama</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Sub Kategori (Dinamis) --}}
            <div>
                <label for="sub_category_id" class="block text-sm font-medium text-gray-600 mb-2">Sub Kategori</label>
                <div class="relative">
                    <select id="sub_category_id" required class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Kategori Utama dulu</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Indikator (Dinamis) --}}
            <div class="md:col-span-2">
                <label for="indicator_id" class="block text-sm font-medium text-gray-600 mb-2">Indikator</label>
                <div class="relative">
                    <select name="indicator_id" id="indicator_id" required class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Sub Kategori dulu</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('indicator_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Nilai Data --}}
            <div class="md:col-span-2">
                <label for="value" class="block text-sm font-medium text-gray-600 mb-2">Nilai Data <span id="unit-label" class="text-gray-500 font-normal"></span></label>
                <input type="number" step="any" name="value" id="value" value="{{ old('value') }}" required class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('value') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan Data
            </button>
            <a href="{{ route('admin.statistics.index') }}" class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

{{-- Script untuk dependent dropdown tidak perlu diubah --}}
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
                    const selected = "{{ old('sub_category_id') }}" == subCategory.id;
                    subCategorySelect.add(new Option(subCategory.name, subCategory.id, false, selected));
                });
                // Trigger change event if there was an old value to load indicators
                if ("{{ old('sub_category_id') }}") {
                    subCategorySelect.dispatchEvent(new Event('change'));
                }
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
                    const selected = "{{ old('indicator_id') }}" == indicator.id;
                    const option = new Option(indicator.name, indicator.id, false, selected);
                    option.dataset.unit = indicator.unit;
                    indicatorSelect.add(option);
                });
                // Trigger change event if there was an old value to show the unit
                if ("{{ old('indicator_id') }}") {
                    indicatorSelect.dispatchEvent(new Event('change'));
                }
            });
    });

    indicatorSelect.addEventListener('change', function() {
        if (this.selectedIndex > 0) {
            const selectedOption = this.options[this.selectedIndex];
            const unit = selectedOption.dataset.unit;
            unitLabel.textContent = unit ? `(${unit})` : '';
        } else {
            unitLabel.textContent = '';
        }
    });

    // Trigger change on main category if there is an old value, to cascade load the dependent dropdowns
    if ("{{ old('main_category_id') }}") {
        mainCategorySelect.value = "{{ old('main_category_id') }}";
        mainCategorySelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush