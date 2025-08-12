@extends('layouts.main_layout')

@section('content')
{{-- [DIUBAH] Menghapus class 'max-w-lg mx-auto' agar tidak terpusat --}}
<div class="container-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Tambah Sub Kategori Baru</h1>

    <form action="{{ route('admin.sub-categories.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            {{-- [DIUBAH] Dropdown Induk Kategori disesuaikan gayanya --}}
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-600 mb-2">Induk Kategori Utama</label>
                <div class="relative">
                    <select name="main_category_id" id="main_category_id" required
                            class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="">Pilih Kategori Utama</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('main_category_id')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- [DIUBAH] Input Nama Sub Kategori disesuaikan gayanya --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-2">Nama Sub Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- [DIUBAH] Menyamakan gaya tombol --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan
            </button>
            <a href="{{ route('admin.sub-categories.index') }}" class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection