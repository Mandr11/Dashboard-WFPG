@extends('layouts.app')

@section('title', 'Manajemen Dataset | Fulou Kopitiam')
@section('header_title', 'Manajemen Dataset Transaksi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-sm flex items-center mb-6">
        <i class="fa-solid fa-circle-check text-xl mr-3"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm flex items-center mb-6">
        <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fa-solid fa-cloud-arrow-up mr-2 text-[#1C4033]"></i> Unggah Dataset Baru
        </h3>
        <form action="{{ route('dataset.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Dataset (Format: .csv)</label>
                    <input type="file" name="files[]" multiple required accept=".csv" class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition cursor-pointer">
                </div>
                <button type="submit" class="bg-[#1C4033] hover:bg-green-800 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md w-full md:w-auto">
                    <i class="fa-solid fa-upload mr-2"></i> Unggah File
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fa-solid fa-database mr-2 text-[#1C4033]"></i> Daftar Dataset Tersimpan
        </h3>

        <div class="overflow-x-auto mb-8 border rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="p-4 border-b font-semibold">Nama File CSV</th>
                        <th class="p-4 border-b font-semibold">Waktu Unggah</th>
                        <th class="p-4 border-b font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($datasets as $dataset)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-800 font-medium">
                            <i class="fa-solid fa-file-csv text-green-600 mr-2 text-lg"></i> {{ $dataset->nama_file }}
                        </td>
                        <td class="p-4 text-gray-500 text-sm">
                            {{ $dataset->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('dataset.destroy', $dataset->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dataset ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition" title="Hapus File">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500 italic">
                            <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-300 block"></i>
                            Belum ada dataset yang diunggah. Silakan unggah file CSV Anda terlebih dahulu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($datasets) > 0)
        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
            <h4 class="font-bold text-blue-900 mb-4 flex items-center">
                <i class="fa-solid fa-sliders mr-2"></i> Pengaturan Algoritma W-FP-Growth
            </h4>
            
            <form action="{{ route('dataset.analyze') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Minimum Weighted Support</label>
                        <input type="number" step="0.001" name="min_ws" value="0.003" required class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                        <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Nilai bawaan: 0.003</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Minimum Confidence</label>
                        <input type="number" step="0.01" name="min_conf" value="0.1" required class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                        <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Nilai bawaan: 0.1</p>
                    </div>
                </div>

                <div class="text-right border-t border-blue-200 pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg transition shadow-md w-full md:w-auto">
                        <i class="fa-solid fa-microchip mr-2"></i> Proses Analisis Data Sekarang
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</div>
@endsection