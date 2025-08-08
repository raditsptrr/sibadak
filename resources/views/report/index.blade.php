@extends('layouts.main_layout')

@section('sidebar')
    @include('partials.sidebar', ['kabKotas' => $kabKotas])
@endsection

@section('navbar')
    {{-- Navbar di halaman laporan disesuaikan --}}
    <div class="bg-blue-500 p-4 rounded-xl shadow-lg flex items-center justify-between w-full"> {{-- Latar belakang biru --}}
        <h2 class="text-xl font-semibold text-white"> {{-- Teks putih --}}
            Statistik {{ $type === 'demographic' ? 'Demografi' : 'Ekonomi' }} Tahun {{ $year }}
        </h2>
        <div class="flex items-center space-x-2">
            <label for="reportYearFilter" class="text-white text-sm">Tahun:</label> {{-- Teks putih --}}
            <select id="reportYearFilter" class="p-2 border border-blue-400 rounded-md focus:ring-blue-200 focus:border-blue-200 text-sm bg-blue-600 text-white"> {{-- Gaya select disesuaikan --}}
                {{-- Loop melalui tahun yang tersedia dari controller --}}
                @foreach($availableYears as $yearOption)
                    <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }}>{{ $yearOption }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('content')
    {{-- Card untuk Tabel Data --}}
    <div class="container-card">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Laporan {{ $indicatorLabel }} Tahun {{ $year }}</h1>
        <p class="text-gray-600 mb-4">{{ $description }}</p> {{-- Deskripsi ditambahkan di sini --}}

        {{-- Tabel Data --}}
        <div class="overflow-x-auto"> {{-- Hapus mb-8 karena akan ada margin-bottom dari container-card --}}
            <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kabupaten/Kota
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nilai ({{ $indicatorUnit }})
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reportData as $index => $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item['kab_kota_name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ is_numeric($item['value']) ? number_format($item['value'], 2, ',', '.') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Card terpisah untuk Visualisasi Data Komparasi --}}
    <div class="container-card mt-6"> {{-- Tambahkan margin-top untuk jarak antar card --}}
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Komparasi {{ $indicatorLabel }}</h3>
        <div style="position: relative; height:400px; width:100%">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reportData = @json($reportData); // Data dari controller
                const indicatorLabel = "{{ $indicatorLabel }}";
                const indicatorUnit = "{{ $indicatorUnit }}";
                const currentYear = "{{ $year }}";
                const reportType = "{{ $type }}"; // Tipe laporan (demographic/economic)
                const indicator = "{{ $indicator }}"; // Nama indikator dari URL

                // Siapkan data untuk Chart.js
                const labels = reportData.map(item => item.kab_kota_name);
                const values = reportData.map(item => item.value);

                const ctx = document.getElementById('comparisonChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Menggunakan bar chart untuk komparasi
                    data: {
                        labels: labels,
                        datasets: [{
                            label: indicatorLabel + ' (' + indicatorUnit + ')',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)', // Warna biru
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: indicatorLabel + ' (' + indicatorUnit + ')'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Kabupaten/Kota'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Tidak perlu legend jika hanya 1 dataset
                            },
                            title: {
                                display: true,
                                text: `Komparasi ${indicatorLabel} Tahun ${currentYear}`
                            }
                        }
                    }
                });

                // Event listener untuk filter tahun di halaman laporan
                document.getElementById('reportYearFilter').addEventListener('change', function() {
                    const selectedYear = this.value;
                    // Mengarahkan ke URL baru dengan tahun yang dipilih
                    window.location.href = `{{ url('report') }}/${reportType}/${indicator}?year=${selectedYear}`;
                });
            });
        </script>
    @endpush
@endsection