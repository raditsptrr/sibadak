@extends('layouts.main_layout')

@section('content')
<div class="container-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Data Statistik</h1>
    
    {{-- [DIUBAH] Variabel dikembalikan menjadi $statisticValue agar konsisten --}}
    <form action="{{ route('admin.statistics.update', $statisticValue) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

            {{-- Info (Read-only) --}}
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Kabupaten/Kota</p>
                <p class="text-base font-semibold text-gray-900">{{ $statisticValue->kabupatenKota->name }}</p>
            </div>
             <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Tahun</p>
                <p class="text-base font-semibold text-gray-900">{{ $statisticValue->year }}</p>
            </div>
            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Indikator</p>
                <p class="text-base font-semibold text-gray-900">{{ $statisticValue->indicator->name }}</p>
            </div>

            {{-- Nilai Data (Editable) --}}
            <div class="md:col-span-2">
                <label for="value" class="block text-sm font-medium text-gray-600 mb-2">
                    Nilai Data 
                    <span class="text-gray-500 font-normal">({{ $statisticValue->indicator->unit }})</span>
                </label>
                <input type="number" step="any" name="value" id="value" value="{{ old('value', $statisticValue->value) }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('value')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.statistics.index') }}" class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
