@extends('layouts.main_layout')

@section('content')
{{-- [DIUBAH] Menghapus class 'max-w-lg mx-auto' agar tidak terpusat --}}
<div class="container-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Indikator</h1>

    <form action="{{ route('admin.indicators.update', $indicator) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            {{-- [DIUBAH] Dropdown Kategori Utama disesuaikan gayanya --}}
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-600 mb-2">Kategori Utama</label>
                <div class="relative">
                    <select id="main_category_id" required
                            class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Kategori Utama</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id', $indicator->subCategory->main_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- [DIUBAH] Dropdown Sub Kategori disesuaikan gayanya --}}
            <div>
                <label for="sub_category_id" class="block text-sm font-medium text-gray-600 mb-2">Sub Kategori</label>
                <div class="relative">
                    <select name="sub_category_id" id="sub_category_id" required
                            class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Kategori Utama dulu</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- [DIUBAH] Input Nama Indikator disesuaikan gayanya --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-2">Nama Indikator</label>
                <input type="text" name="name" id="name" value="{{ old('name', $indicator->name) }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- [DIUBAH] Input Satuan Unit disesuaikan gayanya --}}
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-600 mb-2">Satuan Unit</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit', $indicator->unit) }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('unit')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- [DIUBAH] Menyamakan gaya tombol --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.indicators.index') }}" class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

{{-- Script untuk dependent dropdown tidak perlu diubah karena sudah menangani kasus 'edit' --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainCategorySelect = document.getElementById('main_category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    const initialSubCategoryId = {{ $indicator->sub_category_id }};

    function fetchSubCategories(mainCategoryId, selectedSubId = null) {
        subCategorySelect.innerHTML = '<option value="">Memuat...</option>';

        if (!mainCategoryId) {
            subCategorySelect.innerHTML = '<option value="">Pilih Kategori Utama dulu</option>';
            return;
        }

        fetch(`{{ route('admin.api.sub_categories') }}?main_category_id=${mainCategoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
                data.forEach(subCategory => {
                    const option = new Option(subCategory.name, subCategory.id);
                    if (selectedSubId && subCategory.id == selectedSubId) {
                        option.selected = true;
                    }
                    subCategorySelect.add(option);
                });
            })
            .catch(error => {
                console.error('Error fetching sub-categories:', error);
                subCategorySelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    }

    // Muat sub-kategori saat halaman pertama kali dibuka
    if (mainCategorySelect.value) {
        fetchSubCategories(mainCategorySelect.value, initialSubCategoryId);
    }

    // Tambahkan event listener untuk perubahan
    mainCategorySelect.addEventListener('change', function () {
        fetchSubCategories(this.value);
    });
});
</script>
@endpush