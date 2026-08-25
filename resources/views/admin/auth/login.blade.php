<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login | Sondhi</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        adminDark: '#0f172a',
                        brand: { 600: '#d27933' }
                    },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-adminDark flex items-center justify-center min-h-screen p-4 font-sans text-gray-200">
    <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-tr from-brand-600 to-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg shadow-brand-600/30">
                <i class="fa-solid fa-shield-halved text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Sondhi Admin Portal</h1>
            <p class="text-xs text-slate-400 mt-1">Secure Back-Office Management</p>
        </div>

        @if($errors->any())
            <div class="p-4 mb-6 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-xs">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Admin Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email', 'admin@sondhi.com') }}" required 
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-500 text-sm"></i>
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" value="password123" required 
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-500 text-sm"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded bg-slate-800 border-slate-700 text-amber-500 mr-2">
                    Remember session
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-brand-600 hover:from-amber-600 hover:to-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-amber-500/20 transition-all">
                Authenticate as Admin
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center">
            <a href="{{ route('shop.index') }}" class="text-xs text-slate-400 hover:text-amber-400 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1"></i> Return to Customer Storefront
            </a>
        </div>
    </div>
</body>
</html>
