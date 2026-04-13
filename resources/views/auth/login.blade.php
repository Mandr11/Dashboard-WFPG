<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fulou Kopitiam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center font-sans relative">
    
    <div class="absolute inset-0 z-0 bg-[#26408d] opacity-90"></div>

    <div class="z-10 w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl border-t-8 border-[#D4AF37]">
        <div class="text-center mb-8">
            <i class="fa-solid fa-mug-hot text-4xl text-[#D4AF37] mb-3"></i>
            <h1 class="text-2xl font-bold text-[#26408d] tracking-wider uppercase">Fulou Kopitiam</h1>
            <p class="text-gray-500 text-sm mt-1">Data Mining System Login</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm text-center border border-red-300">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-envelope mr-1"></i> Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#26408d] focus:border-transparent transition" placeholder="admin@fulou.com">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-lock mr-1"></i> Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#26408d] focus:border-transparent transition" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-[#26408d] hover:bg-blue-900 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                Masuk ke Dashboard <i class="fa-solid fa-arrow-right-to-bracket ml-1"></i>
            </button>
        </form>
    </div>
</body>
</html>