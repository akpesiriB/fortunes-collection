@extends('layouts.app')

@section('title', 'COLLECTOR LOGIN | Fortunes Collection')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-[#D4AF37]/40 rounded-2xl p-8 space-y-6 shadow-xl">
        <div class="text-center space-y-2 border-b border-neutral-200 dark:border-neutral-800 pb-4">
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] uppercase tracking-widest font-bold">PRIVATE ATELIER ACCESS</span>
            <h1 class="font-serif text-3xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">SIGN IN</h1>
            <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono">Access your order history and saved delivery addresses.</p>
        </div>

        <form action="{{ route('customer.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Email Address</label>
                <input type="email" name="email" required value="{{ old('email', 'korede@example.com') }}"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Password</label>
                <input type="password" name="password" required value="Password123!"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div class="flex items-center justify-between text-xs font-mono">
                <label class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 cursor-pointer">
                    <input type="checkbox" name="remember" class="text-[#9E7D36] dark:text-[#D4AF37]">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 btn-gold text-xs font-bold tracking-widest uppercase rounded-lg shadow-lg">
                Enter Collector Account
            </button>
        </form>

        <div class="text-center pt-4 border-t border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-600 dark:text-neutral-400">
            <span>New collector?</span>
            <a href="{{ route('customer.register') }}" class="text-[#9E7D36] dark:text-[#D4AF37] hover:underline font-bold ml-1 uppercase">Create account</a>
        </div>
    </div>
</div>
@endsection
