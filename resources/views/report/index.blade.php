@extends('layouts.main_layout')

@section('navbar')
    {{-- Navbar dinamis khusus untuk halaman laporan --}}
    <div class="bg-blue-500 px-6 py-4 rounded-xl shadow-lg w-full">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <!-- Kiri: Judul -->
            <div>
                <h2 class="text-xl font-semibold text-white">
                    Laporan: <span class="text-orange-300">{{ $subCategory->name }}</span>
                </h2>
            </div>

            <!-- Kanan: Filter -->
            <div class="flex flex-wrap items-center gap-x-6 gap-y-4">
                <!-- Filter Indikator -->
                <div class="flex items-center gap-2">
                    <label for="indicatorFilter" class="text-white text-sm">Indikator:</label>
                    <select id="indicatorFilter" class="px-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white">
                        @foreach($indicators as $indicator)
                            <option value="{{ $indicator->id }}">{{ $indicator->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="flex items-center gap-2">
                    <label for="yearFilter" class="text-white text-sm">Tahun:</label>
                    <select id="yearFilter" class="px-3 py-1.5 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white">
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-card">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tabel Data -->
            <div>
                <h3 id="tableTitle" class="text-lg font-semibold text-gray-800 mb-4">Tabel Perbandingan Data</h3>
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kabupaten/Kota</th>
                                <th id="tableHeaderValue" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody" class="divide-y divide-gray-200">
                            {{-- Baris tabel akan diisi oleh JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Visualisasi Chart -->
            <div>
                <h3 id="chartTitle" class="text-lg font-semibold text-gray-800 mb-4">Visualisasi Perbandingan</h3>
                <div id="chartContainer" class="bg-white p-4 rounded-lg shadow" style="position: relative; height:400px; width:100%">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const indicatorFilter = document.getElementById('indicatorFilter');
                const yearFilter = document.getElementById('yearFilter');
                let reportChartInstance = null;

                async function fetchAndDisplayReport() {
                    const params = new URLSearchParams({
                        indicator_id: indicatorFilter.value,
                        year: yearFilter.value,
                    });

                    document.getElementById('reportTableBody').innerHTML = `<tr><td colspan="2" class="text-center p-4 text-gray-500">Memuat data...</td></tr>`;
                    if(reportChartInstance) reportChartInstance.destroy();

                    try {
                        const response = await fetch(`/api/report-data?${params.toString()}`);
                        if (!response.ok) throw new Error('Data tidak ditemukan untuk filter yang dipilih.');
                        const data = await response.json();
                        updateReportUI(data);
                    } catch (error) {
                        console.error("Gagal memuat data laporan:", error);
                        document.getElementById('reportTableBody').innerHTML = `<tr><td colspan="2" class="text-center p-4 text-red-500">${error.message}</td></tr>`;
                    }
                }

                function updateReportUI(data) {
                    // Update Tabel
                    const tableBody = document.getElementById('reportTableBody');
                    tableBody.innerHTML = '';
                    data.report_data.forEach(item => {
                        const row = `
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.kab_kota_name}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.value !== null ? item.value.toLocaleString('id-ID') : 'N/A'}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                    document.getElementById('tableHeaderValue').innerText = `Nilai (${data.indicator.unit})`;

                    // Update Chart
                    if (reportChartInstance) reportChartInstance.destroy();
                    const ctx = document.getElementById('reportChart').getContext('2d');
                    reportChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.report_data.map(item => item.kab_kota_name),
                            datasets: [{
                                label: data.indicator.name,
                                data: data.report_data.map(item => item.value),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            scales: { y: { beginAtZero: true } },
                            plugins: { title: { display: true, text: `${data.indicator.name} Tahun ${yearFilter.value}` } }
                        }
                    });
                }

                [indicatorFilter, yearFilter].forEach(el => el.addEventListener('change', fetchAndDisplayReport));
                
                fetchAndDisplayReport();
            });
        </script>
    @endpush
@endsection
