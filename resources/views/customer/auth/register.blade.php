@extends('layouts.app')

@section('title', 'REGISTER COLLECTOR | Fortunes Collection')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-[#D4AF37]/40 rounded-2xl p-8 space-y-6 shadow-xl">
        <div class="text-center space-y-2 border-b border-neutral-200 dark:border-neutral-800 pb-4">
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] uppercase tracking-widest font-bold">BECOME A COLLECTOR</span>
            <h1 class="font-serif text-3xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">REGISTER</h1>
            <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono">Create an account for personalized white-glove service.</p>
        </div>

        <form action="{{ route('customer.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Full Name *</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. Korede Adeleke"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Email Address *</label>
                <input type="email" name="email" required value="{{ old('email') }}" placeholder="korede@example.com"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Nigerian Phone Number</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+234 802 345 6789"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Password *</label>
                <input type="password" name="password" required placeholder="Minimum 8 characters"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Confirm Password *</label>
                <input type="password" name="password_confirmation" required placeholder="Repeat password"
                       class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
            </div>

            <button type="submit" class="w-full py-3.5 btn-gold text-xs font-bold tracking-widest uppercase rounded-lg shadow-lg">
                Create Collector Account
            </button>
        </form>

        <div class="text-center pt-4 border-t border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-600 dark:text-neutral-400">
            <span>Already registered?</span>
            <a href="{{ route('customer.login') }}" class="text-[#9E7D36] dark:text-[#D4AF37] hover:underline font-bold ml-1 uppercase">Sign in</a>
        </div>
    </div>
</div>
@endsection
