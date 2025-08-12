{{-- File: resources/views/admin/indicators/index.blade.php (Baru) --}}
@extends('layouts.main_layout')

@section('content')
<div class="container-card">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Indikator</h1>
        <a href="{{ route('admin.indicators.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Tambah Indikator</a>
    </div>
     @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Indikator</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sub Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori Utama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($indicators as $indicator)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $indicator->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $indicator->subCategory->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $indicator->subCategory->mainCategory->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $indicator->unit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.indicators.edit', $indicator) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.indicators.destroy', $indicator) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus indikator ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data indikator.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $indicators->links() }}
    </div>
</div>
@endsection