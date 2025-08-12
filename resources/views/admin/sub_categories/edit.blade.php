{{-- File: resources/views/admin/sub_categories/edit.blade.php (Baru) --}}
@extends('layouts.main_layout')

@section('content')
<div class="container-card max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Sub Kategori</h1>
    <form action="{{ route('admin.sub-categories.update', $subCategory) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="main_category_id" class="block text-sm font-medium text-gray-700">Induk Kategori Utama</label>
                <select name="main_category_id" id="main_category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Kategori Utama</option>
                    @foreach($mainCategories as $category)
                        <option value="{{ $category->id }}" {{ old('main_category_id', $subCategory->main_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('main_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Sub Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $subCategory->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.sub-categories.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>
@endsection
