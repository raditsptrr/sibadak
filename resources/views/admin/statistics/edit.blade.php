{{-- File: resources/views/admin/statistics/edit.blade.php (Baru) --}}
@extends('layouts.main_layout')

@section('content')
<div class="container-card max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Data Statistik</h1>
    <form action="{{ route('admin.statistics.update', $statisticValue) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Info (Read-only) --}}
            <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="text-sm font-medium text-gray-700">Kabupaten/Kota</p>
                <p class="text-lg text-gray-900">{{ $statisticValue->kabupatenKota->name }}</p>
            </div>
             <div class="p-4 bg-gray-50 rounded-lg border">
                <p class="text-sm font-medium text-gray-700">Tahun</p>
                <p class="text-lg text-gray-900">{{ $statisticValue->year }}</p>
            </div>
            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border">
                <p class="text-sm font-medium text-gray-700">Indikator</p>
                <p class="text-lg text-gray-900">{{ $statisticValue->indicator->name }}</p>
            </div>

            {{-- Nilai Data (Editable) --}}
            <div class="md:col-span-2">
                <label for="value" class="block text-sm font-medium text-gray-700">
                    Nilai Data 
                    <span class="text-gray-500">({{ $statisticValue->indicator->unit }})</span>
                </label>
                <input type="number" step="any" name="value" id="value" value="{{ old('value', $statisticValue->value) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Update Data</button>
            <a href="{{ route('admin.statistics.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>
@endsection
