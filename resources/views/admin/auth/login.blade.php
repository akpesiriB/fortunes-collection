<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMAND CENTER LOGIN | Fortunes Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/fortunes.css') }}">
</head>
<body class="bg-[#060606] text-white font-sans antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-[#101010] border-2 border-[#D4AF37]/50 rounded-2xl p-8 shadow-2xl space-y-6">
        <div class="text-center space-y-2 border-b border-neutral-800 pb-4">
            <div class="w-10 h-10 border border-[#D4AF37] mx-auto flex items-center justify-center bg-black">
                <span class="font-serif text-base font-bold text-[#D4AF37]">FC</span>
            </div>
            <h1 class="font-serif text-2xl font-bold uppercase text-white tracking-widest mt-2">FORTUNES COMMAND</h1>
            <span class="font-mono text-[10px] uppercase text-[#D4AF37] tracking-[0.25em] block">ADMINISTRATIVE DIRECTORS ONLY</span>
        </div>

        @if($errors->any())
            <div class="p-3 bg-red-950/60 border border-red-800/60 text-red-300 text-xs font-mono rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4 font-mono text-xs">
            @csrf
            <div>
                <label class="block text-neutral-400 uppercase mb-1">Director Email</label>
                <input type="email" name="email" required value="{{ old('email', 'admin@fortunes.ng') }}"
                       class="w-full bg-[#181818] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded focus:outline-none">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Security Passkey</label>
                <input type="password" name="password" required value="Password123!"
                       class="w-full bg-[#181818] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded focus:outline-none">
            </div>

            <label class="flex items-center gap-2 text-neutral-400 cursor-pointer pt-1">
                <input type="checkbox" name="remember" class="text-[#D4AF37]">
                <span>Remember session</span>
            </label>

            <button type="submit" class="w-full py-4 btn-gold text-xs font-bold tracking-widest uppercase rounded shadow-lg">
                Authenticate Command
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('shop.index') }}" class="font-mono text-[11px] text-neutral-500 hover:text-neutral-300 uppercase tracking-wider">
                ← Return to Public Atelier
            </a>
        </div>
    </div>
</body>
</html>
