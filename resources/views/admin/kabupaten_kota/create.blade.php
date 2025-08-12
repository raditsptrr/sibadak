@extends('layouts.main_layout')

@section('content')
<div class="container-card max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Kabupaten/Kota Baru</h1>
    <form action="{{ route('admin.kabupaten-kota.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Wilayah</label>
            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.kabupaten-kota.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>
@endsection