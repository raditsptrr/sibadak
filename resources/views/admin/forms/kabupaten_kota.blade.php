@extends('layouts.main_layout')

@section('sidebar')
    @include('partials.sidebar', ['kabKotas' => $kabKotas])
@endsection

@section('navbar')
    <div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg flex items-center justify-between w-full">
        <h2 class="text-xl font-semibold text-white">Kelola Data Kabupaten/Kota</h2>
    </div>
@endsection

@section('content')
    <div class="container-card">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Form Input Kabupaten/Kota</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('admin.forms.kabupaten_kota.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kabupaten/Kota</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
