@extends('layouts.app')

@section('title', 'Cetak Menu Bundling | Fulou Kopitiam')
@section('header_title', 'Rekomendasi Menu Bundling')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-[#26408d]">Daftar Paket Bundling Tersedia</h2>
        <button onclick="window.print()" class="px-5 py-2.5 bg-[#26408d] text-white font-medium rounded-lg flex items-center shadow hover:bg-blue-900 transition">
            <i class="fa-solid fa-print mr-2"></i> Cetak Menu
        </button>
    </div>

    <div class="bg-[#faf9f6] p-10 rounded-xl shadow-sm border border-gray-200 relative print:shadow-none print:border-none print:p-0">
        
        <div class="absolute inset-0 border-[3px] border-[#26408d] m-3 rounded-lg pointer-events-none print:m-1"></div>
        <div class="absolute inset-0 border border-[#26408d] m-4 rounded pointer-events-none opacity-50 print:m-2"></div>

        <div class="relative z-10 text-center mb-12 mt-4">
            <h1 class="text-4xl font-bold text-[#26408d] tracking-widest uppercase mb-2">Fulou Specials</h1>
            <p class="text-gray-500 italic font-medium">Paket kombinasi menu terfavorit pilihan pelanggan kami</p>
            <div class="flex justify-center mt-4 text-[#26408d]">
                <i class="fa-solid fa-fan text-xl"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10 px-4 pb-8">
            
            @forelse($result['bundling'] as $bundle)
                @php
                    // Memecah string algoritma "Menu A -> Menu B" menjadi array
                    $menus = explode(' -> ', $bundle['Aturan']);
                    $menu1 = trim($menus[0] ?? 'Menu Utama');
                    $menu2 = trim($menus[1] ?? 'Menu Pelengkap');
                @endphp

                <div class="flex flex-col border-b-2 border-dashed border-[#26408d]/30 pb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-[#26408d]">Paket {{ $menu1 }}</h3>
                        
                        <span class="text-lg font-bold text-[#26408d] ml-4">
                            <i class="fa-solid fa-tag text-sm opacity-50 mr-1"></i> Promo
                        </span>
                    </div>
                    
                    <p class="text-gray-700 font-medium">
                        <i class="fa-solid fa-circle-check text-green-600 mr-2 text-sm"></i> 1x {{ $menu1 }}
                    </p>
                    <p class="text-gray-700 font-medium mt-1">
                        <i class="fa-solid fa-circle-check text-green-600 mr-2 text-sm"></i> 1x {{ $menu2 }}
                    </p>
                </div>

            @empty
                <div class="col-span-full text-center py-10">
                    <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Belum ada rekomendasi paket bundling yang memenuhi kriteria minimum saat ini.</p>
                </div>
            @endforelse

        </div>

        <div class="relative z-10 text-center mt-8 text-xs text-[#26408d] font-bold tracking-widest border-t border-[#26408d]/20 pt-6 mx-10">
            &copy; {{ date('Y') }} FULOU KOPITIAM
        </div>

    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        aside, header {
            display: none !important;
        }
    }
</style>
@endsection