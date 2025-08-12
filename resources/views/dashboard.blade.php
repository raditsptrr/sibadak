@extends('layouts.main_layout')

@section('sidebar')
    {{-- Memuat sidebar dengan data yang dibutuhkan --}}
    @include('partials.sidebar', ['mainCategoriesWithSubs' => $mainCategoriesWithSubs, 'kabupatenKotas' => $kabupatenKotas])
@endsection

@section('navbar')
    {{-- Memuat navbar dengan data yang dibutuhkan --}}
    @include('partials.navbar', ['mainCategories' => $mainCategories, 'years' => $years])
@endsection

@section('content')
    {{-- Card-card Informasi Data (Akan di-render oleh JS) --}}
    <div id="dataInfoCards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="col-span-4 bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600">Pilih kabupaten/kota pada peta atau dari menu sidebar untuk menampilkan data.</p>
        </div>
    </div>

    {{-- Peta dibungkus dalam card putih --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Peta Area Bakorwil III Malang Jawa Timur</h2>
        <div id="map" style="height: 500px; width: 100%;" class="rounded-lg bg-gray-200"></div>
    </div>

    {{-- Visualisasi dibungkus dalam card putih --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h3 id="chartTitle" class="text-lg font-semibold text-gray-800">Visualisasi Data</h3>
            {{-- Dropdown untuk filter visualisasi --}}
            <div class="flex items-center gap-2">
                <label for="subCategoryChartFilter" class="text-sm font-medium text-gray-700">Tampilkan Sub Kategori:</label>
                <select id="subCategoryChartFilter" class="px-3 py-1.5 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm"></select>
            </div>
        </div>
        <div id="chartContainer" style="position: relative; height:400px; width:100%">
            <canvas id="mainChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([-7.95, 112.63], 9);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                let geojsonLayer;
                let mainChartInstance = null;
                let currentChartData = {};
                
                let selectedKabKotaId = null;
                let selectedKabKotaName = '';
                
                const yearFilter = document.getElementById('yearFilter');
                const categoryButtons = document.querySelectorAll('.category-filter-btn');
                const subCategoryChartFilter = document.getElementById('subCategoryChartFilter');
                const getActiveCategoryId = () => document.querySelector('.category-filter-btn.bg-blue-700')?.dataset.categoryId || '1';

                async function fetchAndDisplayData() {
                    if (!selectedKabKotaId) return;

                    const params = new URLSearchParams({
                        year: yearFilter.value,
                        kab_kota_id: selectedKabKotaId,
                        main_category_id: getActiveCategoryId(),
                    });

                    document.getElementById('dataInfoCards').innerHTML = `<p class="text-gray-500 col-span-4 text-center p-4">Memuat data...</p>`;
                    if (mainChartInstance) mainChartInstance.destroy();

                    try {
                        const response = await fetch(`/api/dashboard-data?${params.toString()}`);
                        if (!response.ok) throw new Error(`Data tidak ditemukan untuk filter yang dipilih.`);
                        const data = await response.json();
                        updateDashboardUI(data);
                    } catch (error) {
                        console.error("Gagal mengambil data:", error);
                        document.getElementById('dataInfoCards').innerHTML = `<div class="col-span-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert"><p class="font-bold">Informasi</p><p>${error.message}</p></div>`;
                        document.getElementById('chartContainer').innerHTML = '<canvas id="mainChart"></canvas><div class="absolute inset-0 flex items-center justify-center"><p class="text-gray-500">Data untuk visualisasi tidak tersedia.</p></div>';
                        subCategoryChartFilter.innerHTML = '';
                    }
                }

                function updateDashboardUI(data) {
                    const cardsContainer = document.getElementById('dataInfoCards');
                    cardsContainer.innerHTML = '';
                    data.all_data.forEach(item => {
                        const card = `<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200"><p class="text-sm text-gray-600 truncate" title="${item.indicator_name}">${item.indicator_name}</p><p class="text-xl font-bold text-gray-800">${item.value.toLocaleString('id-ID')} <span class="text-base font-normal text-gray-500">${item.unit}</span></p></div>`;
                        cardsContainer.innerHTML += card;
                    });
                    currentChartData = data.chart_data || {};
                    populateSubCategoryFilter();
                    updateMainChart();
                    updateTitles();
                }

                function populateSubCategoryFilter() {
                    subCategoryChartFilter.innerHTML = '';
                    const subCategories = Object.keys(currentChartData);
                    if (subCategories.length > 0) {
                        subCategories.forEach(subCat => subCategoryChartFilter.add(new Option(subCat, subCat)));
                        subCategoryChartFilter.parentElement.style.display = 'flex';
                    } else {
                        subCategoryChartFilter.parentElement.style.display = 'none';
                    }
                }

                function updateMainChart() {
                    if (mainChartInstance) mainChartInstance.destroy();
                    const chartContainer = document.getElementById('chartContainer');
                    chartContainer.innerHTML = '<canvas id="mainChart"></canvas>';
                    const ctx = document.getElementById('mainChart').getContext('2d');
                    const selectedSubCategory = subCategoryChartFilter.value;
                    const chartData = currentChartData[selectedSubCategory];

                    if (!chartData || chartData.length === 0) {
                        chartContainer.innerHTML = '<canvas id="mainChart"></canvas><div class="absolute inset-0 flex items-center justify-center"><p class="text-gray-500">Pilih sub kategori untuk melihat visualisasi.</p></div>';
                        return;
                    }

                    const labels = chartData.map(ind => ind.indicator_name);
                    const values = chartData.map(ind => ind.value);

                    mainChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: selectedSubCategory,
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            scales: { y: { beginAtZero: true } },
                            plugins: { title: { display: true, text: `Visualisasi ${selectedSubCategory} di ${selectedKabKotaName}` } }
                        }
                    });
                }
                
                function updateTitles() {
                    const kabKotaDisplay = document.getElementById('selectedKabKotaDisplay');
                    if(kabKotaDisplay) kabKotaDisplay.innerText = `(${selectedKabKotaName})`;
                    const mainTitle = document.getElementById('mainTitle');
                    const activeCategoryBtn = document.querySelector('.category-filter-btn.bg-blue-700');
                    const categoryText = activeCategoryBtn ? activeCategoryBtn.textContent.trim() : 'Data';
                    if (mainTitle) mainTitle.innerText = `Data Statistik ${categoryText}`;
                }

                const kabKotaNameMapping = { "Blitar": "Kabupaten Blitar", "Kota Blitar": "Kota Blitar", "Malang": "Kabupaten Malang", "Kota Malang": "Kota Malang", "Kota Batu": "Kota Batu", "Pasuruan": "Kabupaten Pasuruan", "Kota Pasuruan": "Kota Pasuruan", "Sidoarjo": "Kabupaten Sidoarjo", "Kota Surabaya": "Kota Surabaya" };
                const regionColorPalette = ['#B4E50D', '#2EC4B6', '#FF4E4E', '#4EFC6B', '#FF7B00', '#B84FFC', '#4FFFF0', '#FF66C4', '#A3FF4F', '#FFC54F', '#00C2FF', '#FF9A8B', '#6EFFF3'];
                
                function getRegionColor(regionName) {
                    let hash = 0;
                    for (let i = 0; i < regionName.length; i++) hash = regionName.charCodeAt(i) + ((hash << 5) - hash);
                    return regionColorPalette[Math.abs(hash) % regionColorPalette.length];
                }

                function onEachFeature(feature, layer) {
                    const kabKotaName = kabKotaNameMapping[feature.properties.NAMOBJ];
                    layer.bindTooltip(`<strong>${kabKotaName}</strong>`);
                    layer.on({
                        mouseover: e => e.target.setStyle({ weight: 4, color: '#4a5568' }),
                        mouseout: e => geojsonLayer.resetStyle(e.target),
                        click: e => {
                            const clickedKabKota = [...document.querySelectorAll('.kab-kota-link')].find(link => link.dataset.kabKotaName === kabKotaName);
                            if (clickedKabKota) {
                                selectedKabKotaId = clickedKabKota.dataset.kabKotaId;
                                selectedKabKotaName = kabKotaName;
                                updateTitles(); 
                                fetchAndDisplayData();
                            }
                        }
                    });
                }

                fetch("{{ asset('geojson/bakorwil3_malang.geojson') }}").then(res => res.json()).then(data => {
                    geojsonLayer = L.geoJSON(data, {
                        style: (feature) => ({
                            fillColor: getRegionColor(kabKotaNameMapping[feature.properties.NAMOBJ]),
                            weight: 2, opacity: 1, color: 'white', fillOpacity: 0.7
                        }),
                        onEachFeature: onEachFeature
                    }).addTo(map);
                });

                document.querySelectorAll('.kab-kota-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedKabKotaId = this.dataset.kabKotaId;
                        selectedKabKotaName = this.dataset.kabKotaName;
                        updateTitles();
                        fetchAndDisplayData();
                    });
                });

                yearFilter.addEventListener('change', fetchAndDisplayData);
                categoryButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        categoryButtons.forEach(btn => btn.classList.remove('bg-blue-700', 'shadow'));
                        this.classList.add('bg-blue-700', 'shadow');
                        updateTitles();
                        fetchAndDisplayData();
                    });
                });

                subCategoryChartFilter.addEventListener('change', updateMainChart);

                function initializeDashboard() {
                    if(yearFilter.querySelector('option[value="2024"]')) yearFilter.value = '2024';
                    const kotaMalangLink = [...document.querySelectorAll('.kab-kota-link')].find(link => link.dataset.kabKotaName === 'Kota Malang');
                    if (kotaMalangLink) {
                        selectedKabKotaId = kotaMalangLink.dataset.kabKotaId;
                        selectedKabKotaName = kotaMalangLink.dataset.kabKotaName;
                        updateTitles();
                        fetchAndDisplayData();
                    }
                }
                initializeDashboard();
            });
        </script>
    @endpush
@endsection
