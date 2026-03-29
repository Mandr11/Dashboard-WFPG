<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Fulou Kopitiam')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden font-sans">

    <aside id="sidebar" class="w-64 flex-shrink-0 bg-[#435380] text-white flex flex-col shadow-xl z-20 transition-all duration-300 overflow-hidden relative">
        <div class="h-24 flex flex-shrink-0 items-center justify-center border-b border-white/20 px-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Fulou Kopitiam" class="h-16 w-auto object-contain">
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
            <a href="{{ route('dataset.menu_bundling') }}" 
               class="flex items-center px-4 py-3 mt-2 rounded-lg transition-colors whitespace-nowrap border-l-4 {{ request()->routeIs('dataset.menu_bundling') ? 'bg-white/10 border-yellow-400' : 'border-transparent hover:bg-white/5' }}">
                <i class="fa-solid fa-mug-hot w-6 text-white"></i>
                <span class="font-medium ml-3 text-white">Cetak Menu Bundling</span>
            </a>

            <a href="{{ route('dataset.hasil') }}" 
               class="flex items-center px-4 py-3 mt-2 rounded-lg transition-colors whitespace-nowrap border-l-4 {{ request()->routeIs('dataset.hasil') ? 'bg-white/10 border-yellow-400' : 'border-transparent hover:bg-white/5' }}">
                <i class="fa-solid fa-chart-pie w-6 text-white"></i>
                <span class="font-medium ml-3 text-white">Analisis W-FPG</span>
            </a>

            <a href="{{ route('dataset.index') }}" 
               class="flex items-center px-4 py-3 mt-2 rounded-lg transition-colors whitespace-nowrap border-l-4 {{ request()->routeIs('dataset.index') ? 'bg-white/10 border-yellow-400' : 'border-transparent hover:bg-white/5' }}">
                <i class="fa-solid fa-database w-6 text-white"></i>
                <span class="font-medium ml-3 text-white">Manajemen Dataset</span>
            </a>
        </nav>

        <div class="p-4 text-xs text-center text-white/60 border-t border-white/20 whitespace-nowrap">
            &copy; {{ date('Y') }} Data Mining System
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-24 flex-shrink-0 bg-white shadow-sm flex items-center justify-between px-8 z-10 border-b border-gray-200">
            <div class="flex items-center">
                <button id="toggleSidebar" class="text-gray-500 hover:text-[#435380] focus:outline-none mr-6 p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl font-bold text-gray-800">@yield('header_title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-700">Admin</p>
                    <p class="text-xs text-[#26408d]">Administrator</p>
                </div>
                <div class="h-10 w-10 bg-blue-50 border-2 border-[#26408d] rounded-full flex items-center justify-center text-[#26408d] font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            @yield('content')
        </main>
    </div>
    
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            
            // Logika: Jika sidebar lebarnya 64 (tampil), ubah jadi 0 (sembunyi)
            if(sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-0');
            } else {
                sidebar.classList.remove('w-0');
                sidebar.classList.add('w-64');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>