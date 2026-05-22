<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Desa ITCI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-emerald-800 text-white flex-shrink-0">
            <div class="p-6 text-xl font-bold border-b border-emerald-700">DESA ITCI</div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 hover:bg-emerald-700"><i class="fa fa-home mr-3"></i> Dashboard</a>
                <a href="{{ route('citizens.index') }}" class="block py-3 px-6 hover:bg-emerald-700"><i class="fa fa-users mr-3"></i> Data Warga</a>
                <a href="{{ route('families.index') }}" class="block py-3 px-6 hover:bg-emerald-700"><i class="fa fa-address-card mr-3"></i> Kartu Keluarga</a>
                <a href="{{ route('letters.index') }}" class="block py-3 px-6 hover:bg-emerald-700"><i class="fa fa-envelope mr-3"></i> Surat Otomatis</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Admin Desa</span>
                    <img src="https://ui-avatars.com/api/?name=Admin" class="w-8 h-8 rounded-full">
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
