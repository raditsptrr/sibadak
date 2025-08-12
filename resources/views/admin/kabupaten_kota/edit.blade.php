@extends('layouts.main_layout')

@section('content')
{{-- [DIUBAH] Menghapus class 'max-w-lg mx-auto' agar tidak terpusat --}}
<div class="container-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Kabupaten/Kota</h1>
    
    <form action="{{ route('admin.kabupaten-kota.update', $kabupatenKota) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- [DIUBAH] Merapikan struktur div dan label --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600 mb-2">Nama Wilayah</label>
            {{-- [DIUBAH] Menyamakan gaya input dengan form sebelumnya --}}
            <input type="text" name="name" id="name" value="{{ old('name', $kabupatenKota->name) }}" required 
                   class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            @error('name') 
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        {{-- [DIUBAH] Menyamakan gaya tombol dengan form sebelumnya --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.kabupaten-kota.index') }}" class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection