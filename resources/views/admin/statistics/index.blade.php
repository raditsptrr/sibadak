
@extends('layouts.main_layout')

@section('content')
<div class="container-card">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Nilai Statistik</h1>
        <a href="{{ route('admin.statistics.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Tambah Nilai Baru</a>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Indikator</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wilayah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($statisticValues as $value)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $value->indicator->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $value->kabupatenKota->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $value->year }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $value->value }} {{ $value->indicator->unit ?? '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.statistics.edit', $value) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.statistics.destroy', $value) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data statistik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $statisticValues->links() }}
    </div>
</div>
@endsection