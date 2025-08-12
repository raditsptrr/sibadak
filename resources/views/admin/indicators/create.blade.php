{{-- File: resources/views/admin/indicators/create.blade.php (Baru) --}}
@extends('layouts.main_layout')

@section('content')
<div class="container-card max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Indikator Baru</h1>
    <form action="{{ route('admin.indicators.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-700">Kategori Utama</label>
                <select id="main_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Kategori Utama</option>
                    @foreach($mainCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sub_category_id" class="block text-sm font-medium text-gray-700">Sub Kategori</label>
                <select name="sub_category_id" id="sub_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Kategori Utama dulu</option>
                </select>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Indikator</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700">Satuan Unit</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: %, jiwa, unit">
                @error('unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.indicators.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainCategorySelect = document.getElementById('main_category_id');
    const subCategorySelect = document.getElementById('sub_category_id');

    mainCategorySelect.addEventListener('change', function () {
        const mainCategoryId = this.value;
        subCategorySelect.innerHTML = '<option value="">Memuat...</option>';

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
});
</script>
@endpush
@endsection