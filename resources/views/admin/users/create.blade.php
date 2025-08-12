{{-- File: resources/views/admin/users/create.blade.php --}}
@extends('layouts.main_layout')

@section('content')

{{-- [PERBAIKAN DITAMBAHKAN DI SINI] --}}
<style>
    /* Kode ini untuk menyembunyikan ikon mata bawaan dari browser (seperti Chrome/Edge)
      yang menyebabkan munculnya ikon ganda. 
    */
    input[type="password"]::-ms-reveal {
        display: none;
    }
</style>
{{-- Akhir dari blok perbaikan --}}

<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Form Input User Baru</h1>
    
    <form action="{{ route('admin.users.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required autocomplete="new-password"
                           class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    {{-- Ikon akan ditambahkan oleh JavaScript secara dinamis --}}
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full bg-white border border-gray-300 rounded-lg p-3 pr-10 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    {{-- Ikon akan ditambahkan oleh JavaScript secara dinamis --}}
                </div>
            </div>

            {{-- Role --}}
            <div class="md:col-span-2">
                <label for="role" class="block text-sm font-medium text-gray-600 mb-2">Role</label>
                <select name="role" id="role" required
                        class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-6 mt-8">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200">
                Simpan
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="text-gray-600 font-semibold hover:text-gray-900 transition-colors duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eyeIcon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
        const eyeSlashIcon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>`;

        function createPasswordToggle(inputId) {
            const inputField = document.getElementById(inputId);
            
            if (inputField && inputField.parentElement.classList.contains('relative')) {
                const wrapper = inputField.parentElement;
                const toggleButton = document.createElement('div');
                toggleButton.className = 'absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500';
                toggleButton.innerHTML = eyeIcon;
                wrapper.appendChild(toggleButton);
                toggleButton.addEventListener('click', function() {
                    const isPassword = inputField.getAttribute('type') === 'password';
                    inputField.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleButton.innerHTML = isPassword ? eyeSlashIcon : eyeIcon;
                });
            }
        }

        createPasswordToggle('password');
        createPasswordToggle('password_confirmation');
    });
</script>
@endpush