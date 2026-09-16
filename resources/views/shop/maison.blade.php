@extends('layouts.app')

@section('title', 'FORTUNES ATELIER | Effurun, Delta State')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">
    
    <!-- Hero Banner -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#D4AF37] uppercase font-bold">THE FLAGSHIP ATELIER</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">
            FORTUNES EFFURUN ATELIER
        </h1>
        <p class="text-sm sm:text-base text-neutral-600 dark:text-neutral-300 font-sans leading-relaxed">
            Located on PTI Road, Effurun, Delta State. A brutalist sanctuary where contemporary Nigerian streetwear converges with bespoke Milanese craftsmanship.
        </p>
    </div>

    <!-- Atelier Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- Left Showcase -->
        <div class="lg:col-span-7 bg-white dark:bg-[#121212] border-2 border-[#9E7D36]/40 dark:border-[#D4AF37]/40 rounded-2xl p-8 flex flex-col justify-between space-y-8 shadow-sm">
            <div class="space-y-4">
                <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] tracking-widest uppercase font-bold">FLAGSHIP SANCTUARY</span>
                <h2 class="font-serif text-3xl font-bold text-neutral-900 dark:text-white uppercase">BESPOKE FITTING & COLLECTOR PRIVATE ROOMS</h2>
                <p class="text-xs text-neutral-600 dark:text-neutral-300 leading-relaxed font-mono">
                    Experience private capsule previews, custom leather tailoring, and one-on-one appointments with our atelier stylists. Every numbered garment in the Fortunes Archive is hand-finished in this sanctuary.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 border-t border-neutral-200 dark:border-neutral-800 pt-6 font-mono text-xs">
                <div>
                    <span class="text-[#9E7D36] dark:text-[#D4AF37] uppercase block mb-1 font-bold">ATELIER HOURS</span>
                    <p class="text-neutral-800 dark:text-neutral-300 font-semibold">Monday – Saturday</p>
                    <p class="text-neutral-600 dark:text-neutral-400">11:00 AM – 8:00 PM WAT</p>
                    <p class="text-neutral-500 text-[10px] mt-1">Sunday: By Private Invitation</p>
                </div>
                <div>
                    <span class="text-[#9E7D36] dark:text-[#D4AF37] uppercase block mb-1 font-bold">LOCATION</span>
                    <p class="text-neutral-800 dark:text-neutral-300 font-semibold">{{ $maisonAddress }}</p>
                    <p class="text-neutral-600 dark:text-neutral-400">Effurun, Delta State</p>
                </div>
            </div>
        </div>

        <!-- Right Appointment Request -->
        <div class="lg:col-span-5 bg-white dark:bg-[#161616] border border-neutral-200 dark:border-neutral-800 rounded-2xl p-8 space-y-6 shadow-sm">
            <div class="border-b border-neutral-200 dark:border-neutral-800 pb-4">
                <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] tracking-widest uppercase font-bold">PRIVATE APPOINTMENT</span>
                <h3 class="font-serif text-2xl font-bold text-neutral-900 dark:text-white uppercase mt-1">RESERVE A SUITE</h3>
            </div>

            <form onsubmit="event.preventDefault(); alert('Your private concierge appointment request has been recorded. Our Effurun team will contact you directly via phone.');" class="space-y-4">
                <div>
                    <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Full Name</label>
                    <input type="text" required placeholder="Korede Adeleke"
                           class="w-full bg-[#FAF8F5] dark:bg-[#1C1C1C] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded">
                </div>
                <div>
                    <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Nigerian Phone Number</label>
                    <input type="tel" required placeholder="+234 800 000 0000"
                           class="w-full bg-[#FAF8F5] dark:bg-[#1C1C1C] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded">
                </div>
                <div>
                    <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Preferred Date</label>
                    <input type="date" required
                           class="w-full bg-[#FAF8F5] dark:bg-[#1C1C1C] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded">
                </div>
                <button type="submit" class="w-full py-3.5 btn-gold text-xs font-bold tracking-widest uppercase rounded">
                    Request Appointment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
