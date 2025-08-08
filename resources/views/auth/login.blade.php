<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-xl">
            <div class="text-center mb-6">
                {{-- Logo Bakorwil --}}
                <img src="{{ asset('images/bakorwil3malang.png') }}" alt="Logo Bakorwil III Prov. Jatim" class="mx-auto h-16 w-auto rounded-lg mb-2" onerror="this.onerror=null;this.src='https://placehold.co/150x50/cccccc/333333?text=LOGO+BAKORWIL';">
                <h3 class="text-2xl font-bold text-blue-500">LOGIN SI BADAK</h3>
            </div>
            
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Email"
                           class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    @error('email')
                        <span class="text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password"
                           class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('password')
                        <span class="text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-baseline justify-end mt-4">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
