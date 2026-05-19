@extends('layouts.app')

@section('title', 'Hasil Analisis | Fulou Kopitiam')
@section('header_title', 'Hasil Analisis W-FP-Growth')

@section('content')
<div class="max-w-7xl mx-auto pb-10">

    <div class="bg-blue-50 p-5 rounded-xl mb-8 border border-blue-100 shadow-sm flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-4 text-blue-600">
            <i class="fa-solid fa-receipt text-xl"></i>
        </div>
        <div>
            <p class="text-blue-900 text-sm font-semibold uppercase tracking-wider mb-1">Total Transaksi Diproses</p>
            <p class="text-blue-900 text-2xl"><strong class="font-bold">{{ $result['total_transaksi'] }}</strong> <span class="text-lg">transaksi</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-lg mb-6 text-gray-800 flex items-center border-b pb-3">
                <i class="fa-solid fa-chart-column text-green-700 mr-2"></i> Top Weighted Frequent Itemset
            </h3>
            <div class="relative h-80 w-full"> 
                <canvas id="itemsetChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-lg mb-6 text-gray-800 flex items-center border-b pb-3">
                <i class="fa-solid fa-chart-pie text-yellow-500 mr-2"></i> Distribusi Kontribusi Menu
            </h3>
            <div class="relative h-80 w-full"> 
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-10 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-lg text-gray-800 flex items-center">
                <i class="fa-solid fa-link text-green-700 mr-2"></i> Aturan Asosiasi Terkuat
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm uppercase tracking-wider">
                        <th class="p-4 border-b font-semibold">Aturan (X &rarr; Y)</th>
                        <th class="p-4 border-b font-semibold">W-Support</th>
                        <th class="p-4 border-b font-semibold">W-Confidence</th>
                        <th class="p-4 border-b font-semibold">W-Lift Ratio</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($result['rules'] as $rule)
                    <tr class="hover:bg-green-50/50 transition duration-150">
                        <td class="p-4 font-semibold text-gray-800">{{ $rule['Aturan'] }}</td>
                        <td class="p-4 text-gray-600">{{ $rule['W-Support'] }}</td>
                        <td class="p-4 text-gray-600">{{ $rule['W-Confidence'] }}</td>
                        <td class="p-4">
                            <span class="{{ $rule['W-Lift Ratio'] > 1 ? 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200' : 'text-gray-600 font-medium' }}">
                                {{ $rule['W-Lift Ratio'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500 italic">Tidak ada aturan asosiasi yang memenuhi nilai minimum Support dan Confidence.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-yellow-200 shadow-sm overflow-hidden">
        <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-200">
            <h3 class="font-bold text-lg text-yellow-800 flex items-center">
                <i class="fa-solid fa-gift text-yellow-600 mr-2"></i> Rekomendasi Menu Bundling Potensial
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm uppercase tracking-wider">
                        <th class="p-4 border-b font-semibold">Saran Paket Bundling</th>
                        <th class="p-4 border-b font-semibold">W-Confidence</th>
                        <th class="p-4 border-b font-semibold">W-Lift Ratio</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($result['bundling'] as $bundle)
                    <tr class="hover:bg-yellow-50/50 transition duration-150">
                        <td class="p-4 font-bold text-yellow-700"><i class="fa-solid fa-box-open mr-2 text-yellow-500"></i> Paket: {{ $bundle['Aturan'] }}</td>
                        <td class="p-4 text-gray-600 font-medium">{{ $bundle['W-Confidence'] }}</td>
                        <td class="p-4 text-gray-600 font-medium">{{ $bundle['W-Lift Ratio'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500 italic">Belum ada kombinasi yang cukup kuat untuk dijadikan paket bundling saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    // Ambil data JSON dari Laravel
    const itemsetData = @json($result['top_itemsets'] ?? []);
    const distData = @json($result['distribution'] ?? []);

    // 1. Setup Bar Chart
    if (itemsetData.length > 0) {
        const ctx1 = document.getElementById('itemsetChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: itemsetData.map(row => row['Kombinasi Menu']),
                datasets: [{
                    label: 'Weighted Support',
                    data: itemsetData.map(row => row['Weighted Support']),
                    backgroundColor: '#1C4033', // Hijau Tua Kopitiam
                    borderRadius: 6
                }]
            },
            options: { 
                indexAxis: 'y', // Bar horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });
    }

    // 2. Setup Doughnut Chart (Diperbarui dengan Persentase)
    if (distData.length > 0) {
        const ctx2 = document.getElementById('distributionChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            plugins: [ChartDataLabels], 
            data: {
                labels: distData.map(row => row['Menu']),
                datasets: [{
                    data: distData.map(row => row['Weighted Support']),
                    backgroundColor: [
                        '#1C4033', '#D4AF37', '#26408d', '#e67e22', '#e74c3c',
                        '#8e44ad', '#2c3e50', '#16a085', '#f39c12', '#7f8c8d'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'right', 
                        labels: { boxWidth: 15 } 
                    },
                    datalabels: {
                        color: '#ffffff', 
                        font: {
                            weight: 'bold',
                            size: 11 
                        },
                        formatter: (value, context) => {
                            let dataArr = context.chart.data.datasets[0].data;
                            let total = dataArr.reduce((a, b) => a + b, 0);
                            let percentage = (value * 100 / total).toFixed(1) + "%";
                            
                            if((value * 100 / total) < 5) {
                                return '';
                            }
                            return percentage;
                        }
                    }
                }
            }
        });
    }
</script>
@endpush