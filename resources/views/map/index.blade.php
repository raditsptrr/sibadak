@extends('layouts.main_layout')

@section('sidebar')
    {{-- Memuat partial sidebar dan mengirimkan variabel $kabKotas --}}
    @include('partials.sidebar', ['kabKotas' => $kabKotas])
@endsection

@section('navbar')
    {{-- Memuat partial navbar --}}
    @include('partials.navbar')
@endsection

@section('content')
    <div class="container-card">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Data Statistik <span id="currentDataTypeTitle">Demografi</span> Tahun <span id="currentDisplayedYear">2023</span>
        </h1>
        
        {{-- Card-card Informasi Data --}}
        <div id="dataInfoCards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- Cards akan di-render di sini oleh JavaScript berdasarkan jenis data (Demografi/Ekonomi) --}}
            {{-- Ini adalah placeholder awal, JavaScript akan mengisinya --}}
        </div>

        <h2 class="text-xl font-bold text-gray-800 mb-4">Peta Area Bakorwil III Malang Jawa Timur</h2>
        <div id="map"></div>

        {{-- Bagian untuk Visualisasi Chart --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="container-card">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualisasi Data Demografi</h3>
                {{-- Bungkus canvas dalam div untuk kontrol tinggi yang lebih baik --}}
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="mainDemographicChart"></canvas>
                </div>
            </div>
            <div class="container-card">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualisasi Data Ekonomi</h3>
                {{-- Bungkus canvas dalam div untuk kontrol tinggi yang lebih baik --}}
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="mainEconomicChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Inisialisasi peta Leaflet
            var map = L.map('map').setView([-7.95, 112.63], 9); // Koordinat tengah Bakorwil 3 Malang

            // Tambahkan base layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var geojsonLayer; // Variabel untuk menyimpan layer GeoJSON
            var bakorwil3_malang_geojson_data; // Variabel untuk menyimpan data GeoJSON yang dimuat

            // Objek mapping untuk menerjemahkan nama dari GeoJSON (NAMOBJ) ke nama di database (KabupatenKota)
            const kabKotaNameMapping = {
                "Blitar": "Kabupaten Blitar",
                "Kota Blitar": "Kota Blitar",
                "Malang": "Kabupaten Malang",
                "Kota Malang": "Kota Malang",
                "Kota Batu": "Kota Batu",
                "Pasuruan": "Kabupaten Pasuruan",
                "Kota Pasuruan": "Kota Pasuruan",
                "Sidoarjo": "Kabupaten Sidoarjo",
                "Kota Surabaya": "Kota Surabaya"
            };

            // Cache untuk menyimpan semua data statistik per tahun, untuk pewarnaan peta
            var allStatisticsCache = {}; // Format: { year: { kabKotaName: { demographic_data: {}, economic_data: {} } } }

            // Ambil nilai awal dari filter di navbar
            var currentYear = document.getElementById('yearFilter').value;
            var currentDataType = document.getElementById('dataTypeFilter').value;
            var selectedKabKota = null; // Menyimpan nama kab/kota yang sedang aktif/dipilih

            // Instance Chart.js agar bisa dihancurkan dan dibuat ulang
            let demographicChartInstance = null;
            let economicChartInstance = null;

            // Fungsi untuk mengambil data statistik dari API Laravel untuk satu kab/kota
            async function fetchStatisticData(kabKotaName, year) {
                try {
                    const encodedKabKotaName = encodeURIComponent(kabKotaName);
                    const response = await fetch(`/api/statistics/${encodedKabKotaName}?year=${year}`);
                    if (!response.ok) {
                        if (response.status === 404) {
                            console.warn(`Data untuk ${kabKotaName} tahun ${year} tidak ditemukan.`);
                            return null;
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error("Gagal mengambil data statistik:", error);
                    return null; // Kembalikan null jika ada error
                }
            }

            // Fungsi untuk mengambil semua data statistik untuk pewarnaan peta
            async function fetchAllStatisticsForYear(year) {
                if (allStatisticsCache[year]) {
                    return allStatisticsCache[year]; // Gunakan cache jika sudah ada
                }
                try {
                    const response = await fetch(`/api/statistics?year=${year}`);
                    if (!response.ok) {
                        throw new Error(`Gagal memuat semua statistik: ${response.statusText}`);
                    }
                    const data = await response.json();
                    const processedData = {};
                    // Restrukturisasi data agar mudah diakses berdasarkan nama kab/kota
                    data.demographics.forEach(d => {
                        const mappedName = d.kabupaten_kota.name; // Nama dari relasi
                        if (!processedData[mappedName]) processedData[mappedName] = {};
                        processedData[mappedName].demographic_data = d;
                    });
                    data.economics.forEach(e => {
                        const mappedName = e.kabupaten_kota.name; // Nama dari relasi
                        if (!processedData[mappedName]) processedData[mappedName] = {};
                        processedData[mappedName].economic_data = e;
                    });
                    allStatisticsCache[year] = processedData;
                    return processedData;
                } catch (error) {
                    console.error("Error memuat semua statistik:", error);
                    return {};
                }
            }

            // Palet warna yang lebih bervariasi untuk setiap wilayah
            const regionColorPalette = [
                '#FF6384', // Merah muda
                '#36A2EB', // Biru terang
                '#FFCE56', // Kuning
                '#4BC0C0', // Teal
                '#9966FF', // Ungu
                '#FF9F40', // Oranye
                '#2ECC40', // Hijau
                '#FF4136', // Merah
                '#0074D9'  // Biru gelap
            ];

            // Fungsi untuk mendapatkan warna unik berdasarkan nama wilayah (untuk variasi)
            function getRegionSpecificColor(regionName) {
                let hash = 0;
                for (let i = 0; i < regionName.length; i++) {
                    hash = regionName.charCodeAt(i) + ((hash << 5) - hash);
                }
                const index = Math.abs(hash) % regionColorPalette.length;
                return regionColorPalette[index];
            }

            // Fungsi untuk menentukan gaya poligon peta
            function styleFeature(feature) {
                const rawKabKotaName = feature.properties.NAMOBJ;
                const kabKotaName = kabKotaNameMapping[rawKabKotaName] || rawKabKotaName;
                
                return {
                    fillColor: getRegionSpecificColor(kabKotaName), // Warna unik per wilayah
                    weight: 2,
                    opacity: 1,
                    color: 'white', // Warna garis batas
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }

            // Fungsi untuk membuat popup saat hover dan menangani klik
            async function onEachFeature(feature, layer) {
                if (feature.properties && feature.properties.NAMOBJ) {
                    let rawKabKotaName = feature.properties.NAMOBJ;
                    const kabKotaName = kabKotaNameMapping[rawKabKotaName] || rawKabKotaName;

                    // Ambil data statistik untuk wilayah ini dari cache (sudah dimuat oleh fetchAllStatisticsForYear)
                    const statsForYear = allStatisticsCache[currentYear] || {};
                    const kabKotaStats = statsForYear[kabKotaName];
                    let demographicData = null;
                    if (kabKotaStats) {
                        demographicData = kabKotaStats.demographic_data;
                    }

                    // Konten popup saat HOVER
                    let hoverPopupContent = `<h3><strong>${kabKotaName}</strong></h3><p>Tahun: ${currentYear}</p>`;
                    if (demographicData) {
                        hoverPopupContent += `<p>Luas Wilayah: ${demographicData.area_sqkm ? demographicData.area_sqkm.toLocaleString() + " km²" : "N/A"}</p>` +
                                             `<p>Jumlah Penduduk: ${demographicData.population ? demographicData.population.toLocaleString() + " jiwa" : "N/A"}</p>` +
                                             `<p>Tingkat Kemiskinan: <strong>${demographicData.poverty_rate ? demographicData.poverty_rate + "%" : "N/A"}</strong></p>`;
                    } else {
                        hoverPopupContent += `<p>Data tidak tersedia.</p>`;
                    }
                    
                    // Bind tooltip (pop-up kecil saat hover)
                    layer.bindTooltip(hoverPopupContent, {
                        sticky: true, // Tetap muncul saat mouse bergerak di atas poligon
                        direction: 'auto'
                    });

                    // Event saat mouse OVER wilayah
                    layer.on('mouseover', function (e) {
                        layer.setStyle({
                            weight: 3, // Tebalkan garis batas
                            color: '#666', // Ubah warna garis batas
                            dashArray: '',
                            fillOpacity: 0.9 // Lebih terang
                        });
                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                            layer.bringToFront(); // Bawa layer ke depan agar terlihat jelas
                        }
                    });

                    // Event saat mouse OUT wilayah
                    layer.on('mouseout', function (e) {
                        geojsonLayer.resetStyle(layer); // Kembalikan gaya default
                    });

                    // Event saat CLICK wilayah
                    layer.on('click', async function (e) {
                        // Ambil tahun dan jenis data terbaru dari filter navbar
                        currentYear = document.getElementById('yearFilter').value;
                        currentDataType = document.getElementById('dataTypeFilter').value;

                        selectedKabKota = kabKotaName; // Simpan kab/kota yang dipilih

                        // Panggil fungsi utama untuk memuat dan menampilkan data di cards dan charts utama
                        // TIDAK ADA POPUP DI SINI, HANYA UPDATE DATA DI BAWAH PETA
                        await loadAndDisplayData(kabKotaName, currentYear, currentDataType);
                    });
                }
            }

            // Fungsi untuk memuat ulang GeoJSON dan styling
            async function loadMapGeoJSON() {
                if (geojsonLayer) {
                    map.removeLayer(geojsonLayer); // Hapus layer GeoJSON lama
                }
                // regionLabels.clearLayers(); // Hapus label lama (karena kita pakai hover popup)

                try {
                    // Muat semua statistik untuk tahun saat ini sebelum menggambar peta
                    // Ini penting agar styleFeature punya data untuk pewarnaan
                    await fetchAllStatisticsForYear(currentYear);

                    const response = await fetch("{{ asset('geojson/bakorwil3_malang.geojson') }}");
                    if (!response.ok) {
                        throw new Error(`Gagal memuat GeoJSON: ${response.statusText}`);
                    }
                    bakorwil3_malang_geojson_data = await response.json(); // Simpan data GeoJSON ke variabel
                    
                    geojsonLayer = L.geoJSON(bakorwil3_malang_geojson_data, {
                        onEachFeature: onEachFeature,
                        style: styleFeature // Gunakan fungsi style yang baru
                    }).addTo(map);

                    map.fitBounds(geojsonLayer.getBounds());
                } catch (error) {
                    console.error("Error memuat atau memproses GeoJSON:", error);
                }
            }

            // Fungsi untuk memperbarui tampilan card informasi
            function updateInfoCards(demographicData, economicData) {
                const dataInfoCardsContainer = document.getElementById('dataInfoCards');
                dataInfoCardsContainer.innerHTML = ''; // Kosongkan container cards terlebih dahulu

                if (currentDataType === 'demography') {
                    document.getElementById('currentDataTypeTitle').innerText = 'Demografi';
                    if (demographicData) {
                        dataInfoCardsContainer.innerHTML = `
                            <div class="bg-blue-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-blue-700">Luas Wilayah</p>
                                <p class="text-xl font-bold text-blue-900">${demographicData.area_sqkm ? demographicData.area_sqkm.toLocaleString() + " km²" : "N/A"}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-green-700">Jumlah Penduduk</p>
                                <p class="text-xl font-bold text-green-900">${demographicData.population ? demographicData.population.toLocaleString() + " jiwa" : "N/A"}</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-red-700">Tingkat Kemiskinan</p>
                                <p class="text-xl font-bold text-red-900">${demographicData.poverty_rate ? demographicData.poverty_rate + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-yellow-700">Tingkat Pengangguran Terbuka</p>
                                <p class="text-xl font-bold text-yellow-900">${demographicData.open_unemployment_rate ? demographicData.open_unemployment_rate + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-purple-700">Pendidikan (Rata-rata Tahun Sekolah)</p>
                                <p class="text-xl font-bold text-purple-900">${demographicData.avg_years_schooling ? demographicData.avg_years_schooling + " tahun" : "N/A"}</p>
                            </div>
                            <div class="bg-indigo-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-indigo-700">Angka Harapan Hidup</p>
                                <p class="text-xl font-bold text-indigo-900">${demographicData.life_expectancy ? demographicData.life_expectancy + " tahun" : "N/A"}</p>
                            </div>
                            <div class="bg-pink-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-pink-700">Cakupan Perlindungan Sosial</p>
                                <p class="text-xl font-bold text-pink-900">${demographicData.social_protection_coverage ? demographicData.social_protection_coverage + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-teal-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-teal-700">Tingkat Kecukupan Perumahan</p>
                                <p class="text-xl font-bold text-teal-900">${demographicData.housing_adequacy_rate ? demographicData.housing_adequacy_rate + "%" : "N/A"}</p>
                            </div>
                        `;
                    } else {
                        dataInfoCardsContainer.innerHTML = '<p class="text-gray-600">Data demografi tidak tersedia untuk tahun ini.</p>';
                    }
                } else if (currentDataType === 'economy') {
                    document.getElementById('currentDataTypeTitle').innerText = 'Ekonomi';
                    if (economicData) {
                        dataInfoCardsContainer.innerHTML = `
                            <div class="bg-orange-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-orange-700">Pertumbuhan Ekonomi</p>
                                <p class="text-xl font-bold text-orange-900">${economicData.economic_growth_rate ? economicData.economic_growth_rate + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-purple-700">Inflasi</p>
                                <p class="text-xl font-bold text-purple-900">${economicData.inflation_rate ? economicData.inflation_rate + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-cyan-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-cyan-700">PDRB</p>
                                <p class="text-xl font-bold text-cyan-900">${economicData.grdp ? "Rp " + economicData.grdp.toLocaleString() + " Miliar" : "N/A"}</p>
                            </div>
                            <div class="bg-lime-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-lime-700">Jumlah UMKM</p>
                                <p class="text-xl font-bold text-lime-900">${economicData.num_umkm ? economicData.num_umkm.toLocaleString() : "N/A"}</p>
                            </div>
                            <div class="bg-fuchsia-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-fuchsia-700">Jumlah Koperasi</p>
                                <p class="text-xl font-bold text-fuchsia-900">${economicData.num_cooperatives ? economicData.num_cooperatives.toLocaleString() : "N/A"}</p>
                            </div>
                            <div class="bg-teal-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-teal-700">Kontribusi Pertanian</p>
                                <p class="text-xl font-bold text-teal-900">${economicData.agriculture_contribution ? economicData.agriculture_contribution + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-blue-700">Kontribusi Kehutanan</p>
                                <p class="text-xl font-bold text-blue-900">${economicData.forestry_contribution ? economicData.forestry_contribution + "%" : "N/A"}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-green-700">Kontribusi Perikanan</p>
                                <p class="text-xl font-bold text-green-900">${economicData.fisheries_contribution ? economicData.fisheries_contribution + "%" : "N/A"}</p>
                            </div>
                        `;
                    } else {
                        dataInfoCardsContainer.innerHTML = '<p class="text-gray-600">Data ekonomi tidak tersedia untuk tahun ini.</p>';
                    }
                }
            }

            // Fungsi untuk memperbarui chart utama di halaman
            function updateCharts(demographicData, economicData) {
                // Hancurkan instance chart yang sudah ada sebelum membuat yang baru
                if (demographicChartInstance) demographicChartInstance.destroy();
                if (economicChartInstance) economicChartInstance.destroy();

                // Chart Demografi
                if (demographicData) {
                    var demoCtx = document.getElementById('mainDemographicChart');
                    demographicChartInstance = new Chart(demoCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Kemiskinan (%)', 'Pengangguran Terbuka (%)', 'Pendidikan (Tahun)', 'Angka Harapan Hidup (Tahun)'],
                            datasets: [{
                                label: 'Nilai',
                                data: [
                                    demographicData.poverty_rate,
                                    demographicData.open_unemployment_rate,
                                    demographicData.avg_years_schooling,
                                    demographicData.life_expectancy
                                ],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)', // Kemiskinan
                                    'rgba(54, 162, 235, 0.6)', // Pengangguran
                                    'rgba(75, 192, 192, 0.6)', // Pendidikan
                                    'rgba(153, 102, 255, 0.6)' // Harapan Hidup
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                title: { display: true, text: 'Statistik Demografi Utama' }
                            }
                        }
                    });
                } else {
                    // Kosongkan canvas jika data tidak tersedia
                    var demoCtx = document.getElementById('mainDemographicChart');
                    if (demoCtx) demoCtx.getContext('2d').clearRect(0, 0, demoCtx.width, demoCtx.height);
                }

                // Chart Ekonomi
                if (economicData) {
                    var ecoCtx = document.getElementById('mainEconomicChart');
                    economicChartInstance = new Chart(ecoCtx.getContext('2d'), {
                        type: 'line', // Menggunakan line chart sebagai contoh
                        data: {
                            labels: ['Pertumbuhan Ekonomi (%)', 'Inflasi (%)', 'Kontribusi Pertanian (%)', 'PDRB (Miliar)'], // Label PDRB kembali ke Miliar
                            datasets: [{
                                label: 'Nilai',
                                data: [
                                    economicData.economic_growth_rate,
                                    economicData.inflation_rate,
                                    economicData.agriculture_contribution,
                                    economicData.grdp // PDRB tidak dibagi, Chart.js akan menyesuaikan skala visual
                                ],
                                backgroundColor: [
                                    'rgba(255, 159, 64, 0.6)',
                                    'rgba(255, 205, 86, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(201, 203, 207, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 205, 86, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(201, 203, 207, 1)'
                                ],
                                borderWidth: 1,
                                fill: false,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                title: { display: true, text: 'Statistik Ekonomi Utama' }
                            }
                        }
                    });
                } else {
                    var ecoCtx = document.getElementById('mainEconomicChart');
                    if (ecoCtx) ecoCtx.getContext('2d').clearRect(0, 0, ecoCtx.width, ecoCtx.height);
                }
            }

            // Fungsi utama untuk memuat data dan memperbarui UI
            async function loadAndDisplayData(kabKotaName, year, dataType) {
                // Update judul utama dan tampilan kab/kota yang dipilih
                document.getElementById('currentDisplayedYear').innerText = year;
                document.getElementById('selectedKabKotaDisplay').innerText = kabKotaName ? `( ${kabKotaName} )` : '';
                document.getElementById('mainTitle').innerText = `Data Statistik ${dataType === 'demography' ? 'Demografi' : 'Ekonomi'} Tahun ${year}`;


                const statisticData = await fetchStatisticData(kabKotaName, year);

                let demographicData = null;
                let economicData = null;

                if (statisticData) {
                    demographicData = statisticData.demographic_data;
                    economicData = statisticData.economic_data;
                }

                // Perbarui info cards dan charts
                updateInfoCards(demographicData, economicData);
                updateCharts(demographicData, economicData);
            }

            // Fungsi untuk memuat ulang GeoJSON dan styling
            async function loadMapGeoJSON() {
                if (geojsonLayer) {
                    map.removeLayer(geojsonLayer); // Hapus layer GeoJSON lama
                }
                // regionLabels.clearLayers(); // Hapus label lama (karena kita pakai hover popup)

                try {
                    // Muat semua statistik untuk tahun saat ini sebelum menggambar peta
                    // Ini penting agar styleFeature punya data untuk pewarnaan
                    await fetchAllStatisticsForYear(currentYear);

                    const response = await fetch("{{ asset('geojson/bakorwil3_malang.geojson') }}");
                    if (!response.ok) {
                        throw new Error(`Gagal memuat GeoJSON: ${response.statusText}`);
                    }
                    bakorwil3_malang_geojson_data = await response.json(); // Simpan data GeoJSON ke variabel
                    
                    geojsonLayer = L.geoJSON(bakorwil3_malang_geojson_data, {
                        onEachFeature: onEachFeature,
                        style: styleFeature // Gunakan fungsi style yang baru
                    }).addTo(map);

                    map.fitBounds(geojsonLayer.getBounds());
                } catch (error) {
                    console.error("Error memuat atau memproses GeoJSON:", error);
                }
            }

            // Event Listeners untuk filter di navbar
            document.getElementById('yearFilter').addEventListener('change', function() {
                currentYear = this.value;
                // Saat tahun berubah, muat ulang GeoJSON agar warna peta diperbarui
                loadMapGeoJSON();
                if (selectedKabKota) { // Hanya update jika ada kab/kota yang sudah dipilih
                    loadAndDisplayData(selectedKabKota, currentYear, currentDataType);
                } else {
                    // Jika belum ada kab/kota yang dipilih, ambil yang pertama sebagai default
                    const defaultKabKota = document.querySelector('.kab-kota-link')?.dataset.kabKotaName || 'Kabupaten Malang';
                    selectedKabKota = defaultKabKota;
                    loadAndDisplayData(defaultKabKota, currentYear, currentDataType);
                }
            });

            document.getElementById('dataTypeFilter').addEventListener('change', function() {
                currentDataType = this.value;
                // Saat jenis data berubah, muat ulang GeoJSON agar warna peta diperbarui (jika styling berdasarkan jenis data)
                loadMapGeoJSON();
                if (selectedKabKota) { // Hanya update jika ada kab/kota yang sudah dipilih
                    loadAndDisplayData(selectedKabKota, currentYear, currentDataType);
                } else {
                    // Jika belum ada kab/kota yang dipilih, ambil yang pertama sebagai default
                    const defaultKabKota = document.querySelector('.kab-kota-link')?.dataset.kabKotaName || 'Kabupaten Malang';
                    selectedKabKota = defaultKabKota;
                    loadAndDisplayData(defaultKabKota, currentYear, currentDataType);
                }
            });

            // Event listener untuk link di sidebar
            document.querySelectorAll('.kab-kota-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah link berpindah halaman
                    const kabKotaName = this.dataset.kabKotaName;
                    selectedKabKota = kabKotaName; // Simpan kab/kota yang dipilih
                    loadAndDisplayData(kabKotaName, currentYear, currentDataType);
                });
            });

            // Muat GeoJSON saat halaman pertama kali dimuat
            loadMapGeoJSON();

            // Muat data awal untuk default kab/kota atau yang pertama di daftar
            // Ambil nama kab/kota pertama dari sidebar atau set default
            const defaultKabKota = document.querySelector('.kab-kota-link')?.dataset.kabKotaName || 'Kabupaten Malang'; // Default ke Malang jika tidak ada
            selectedKabKota = defaultKabKota;
            loadAndDisplayData(defaultKabKota, currentYear, currentDataType);


            
        </script>
    @endpush
@endsection