<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Administrasi Desa ITCI</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-emerald-950 via-emerald-900 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-white/20">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-2xl text-emerald-800 text-3xl font-bold mb-4 shadow">
                🏢
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Administrasi Desa ITCI</h2>
            <p class="text-sm text-slate-500 mt-1">Silakan masuk untuk mengelola data administrasi desa</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 text-sm rounded-r-lg">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Username/Email -->
            <div>
                <label for="username" class="block text-xs uppercase font-bold text-slate-600 tracking-wider mb-2">Username atau Email</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                       placeholder="Masukkan username atau email">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs uppercase font-bold text-slate-600 tracking-wider mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                       placeholder="Masukkan kata sandi">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                    <span class="ml-2 text-sm text-slate-500">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" 
                    class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-emerald-700/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Masuk ke Dashboard
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 pt-6 border-t border-slate-100">
            <span class="text-xs text-slate-400">© 2026 Pemerintah Desa ITCI. Mode Offline Kompatibel.</span>
        </div>
    </div>
</body>
</html>
