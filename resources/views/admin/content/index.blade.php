@extends('layouts.admin')

@section('title', 'MAISON CMS | Fortunes Admin')
@section('page_title', 'Maison Content Management')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 font-mono text-xs">
    
    <div class="border-b border-neutral-800 pb-4">
        <h2 class="font-serif text-2xl font-bold uppercase text-white tracking-wide">ATELIER PUBLIC CONTENT</h2>
        <p class="text-neutral-400">Updates here reflect instantly on the public storefront and marquee tickers.</p>
    </div>

    <form action="{{ route('admin.content.update') }}" method="POST" class="bg-[#121212] border border-neutral-800 rounded-2xl p-8 space-y-6 shadow-xl">
        @csrf

        <div class="space-y-4">
            <div>
                <label class="block text-neutral-400 uppercase mb-1">Top Announcement Marquee Ticker *</label>
                <textarea name="announcement_ticker" rows="2" required
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('announcement_ticker', $settings['announcement_ticker']) }}</textarea>
                <span class="text-[10px] text-neutral-500">Separate headlines with the dot separator: ⬝</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Hero Main Title *</label>
                    <input type="text" name="hero_title" required value="{{ old('hero_title', $settings['hero_title']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded font-serif text-base uppercase focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Hero Subtitle / Tagline *</label>
                    <input type="text" name="hero_subtitle" required value="{{ old('hero_subtitle', $settings['hero_subtitle']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Maison Gadget Status Line *</label>
                    <input type="text" name="maison_status" required value="{{ old('maison_status', $settings['maison_status']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37]">
                    <span class="text-[10px] text-neutral-500">Displays on the retro Gameboy screen in hero</span>
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Maison Flagship Address *</label>
                    <input type="text" name="maison_address" required value="{{ old('maison_address', $settings['maison_address']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Concierge VIP Phone</label>
                    <input type="text" name="customer_service_phone" value="{{ old('customer_service_phone', $settings['customer_service_phone']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Concierge VIP Email</label>
                    <input type="email" name="customer_service_email" value="{{ old('customer_service_email', $settings['customer_service_email']) }}"
                           class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex justify-end">
            <button type="submit" class="px-8 py-3.5 btn-gold text-xs font-bold uppercase rounded shadow">
                Save Maison Content
            </button>
        </div>
    </form>
</div>
@endsection
