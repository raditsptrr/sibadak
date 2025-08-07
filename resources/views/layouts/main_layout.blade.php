<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Badak - Bakorwil 3 Malang</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Pastikan HTML dan Body mengisi seluruh tinggi viewport dan mencegah scroll */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            overflow: hidden; /* Mencegah scroll pada body utama */
        }

        #app-container {
            display: grid; /* Menggunakan Grid untuk layout utama */
            grid-template-columns: 250px 1fr; /* Kolom pertama untuk sidebar (250px), kolom kedua untuk konten utama */
            height: 100%; /* Memastikan container utama mengisi seluruh tinggi */
            width: 100%; /* Memastikan container utama mengisi seluruh lebar */
        }

        #sidebar {
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            padding: 20px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #e2e8f0;
            overflow-y: auto; /* Jika sidebar terlalu panjang, bisa discroll */
            flex-shrink: 0;
        }

        #main-content-area {
            display: flex;
            flex-direction: column;
            height: 100%; /* Memastikan area ini mengisi tinggi grid cell */
            overflow-y: auto; /* Memungkinkan scroll hanya pada area konten utama */
            -webkit-overflow-scrolling: touch; /* Untuk scrolling yang lebih mulus di iOS */
        }

        #navbar {
            padding: 0; /* Hapus padding agar card di partial bisa mengatur sendiri */
            box-shadow: none; /* Hapus shadow bawaan */
            border-bottom: none; /* Hapus border bawaan */
            flex-shrink: 0;
            position: sticky; /* Tetap di atas saat scroll di dalam main-content-area */
            top: 0;
            z-index: 100; /* Ditingkatkan agar selalu di atas peta dan elemen lain */
            margin: 20px; /* Memberikan margin di sekitar navbar card */
        }

        .content-wrapper {
            padding: 20px;
            flex-grow: 1; /* Konten utama mengambil sisa ruang vertikal di dalam main-content-area */
            padding-top: 0; /* Ubah ini menjadi 0 karena margin di navbar sudah ada */
        }
        /* Styling umum untuk elemen di dalam konten */
        .container-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            z-index: 1; /* Pastikan peta memiliki z-index yang lebih rendah dari navbar */
        }
        .popup-section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            color: #555;
        }
        .info {
            padding: 10px 15px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: rgba(255,255,255,0.9);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        .info h4 {
            margin: 0 0 8px;
            color: #333;
            font-size: 16px;
        }
        .chart-container {
            margin-top: 15px;
            width: 100%;
            max-width: 300px; /* Batasi lebar chart di popup */
            height: 150px; /* Batasi tinggi chart di popup */
        }
    </style>
    @stack('styles') {{-- Untuk CSS tambahan dari child views --}}
</head>
<body>
    <div id="app-container">
        <aside id="sidebar">
            @yield('sidebar')
        </aside>

        <main id="main-content-area">
            <nav id="navbar">
                @yield('navbar')
            </nav>

            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts') {{-- Untuk JavaScript tambahan dari child views --}}

    {{-- --- JavaScript untuk Collapsible Sidebar --- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapsibleHeaders = document.querySelectorAll('.collapsible-header');
            const dashboardLink = document.querySelector('a[href="/"]'); // Link Dashboard Peta
            const currentPath = window.location.href; // Gunakan href untuk mencocokkan query params

            // Fungsi untuk menghapus semua kelas aktif dari header dan sub-bab
            function clearAllActiveStates() {
                // Hapus aktif dari Dashboard link
                if (dashboardLink) {
                    dashboardLink.classList.remove('bg-blue-500', 'text-white');
                    dashboardLink.classList.add('text-gray-700');
                }

                collapsibleHeaders.forEach(header => {
                    header.classList.remove('bg-blue-500', 'text-white');
                    header.classList.add('text-gray-700'); // Kembalikan warna default
                    const icon = header.querySelector('svg:last-child');
                    if (icon) icon.classList.remove('rotate-180');

                    const targetContent = document.querySelector(header.dataset.collapseTarget);
                    if (targetContent) {
                        targetContent.classList.add('hidden'); // Tutup semua sub-bab
                    }
                });
                document.querySelectorAll('.collapsible-content a').forEach(link => {
                    link.classList.remove('text-blue-600', 'font-semibold');
                    link.classList.add('text-gray-700'); // Kembalikan warna default
                });
            }

            // Inisialisasi status aktif saat halaman dimuat
            clearAllActiveStates(); // Bersihkan semua dulu

            // Logika untuk mengaktifkan Dashboard Peta jika di halaman utama
            if (currentPath === window.location.origin + '/' || currentPath === window.location.origin + '/index.php') { // Cek root path
                if (dashboardLink) {
                    dashboardLink.classList.add('bg-blue-500', 'text-white', 'rounded-lg'); // Tambahkan rounded-lg
                    dashboardLink.classList.remove('text-gray-700');
                }
            } else {
                // Logika untuk membuka menu yang aktif berdasarkan URL (untuk laporan)
                collapsibleHeaders.forEach(header => {
                    const targetId = header.dataset.collapseTarget;
                    const targetContent = document.querySelector(targetId);
                    const icon = header.querySelector('svg:last-child');

                    if (targetContent) {
                        const linksInContent = targetContent.querySelectorAll('a[href]');
                        let headerShouldBeActive = false;

                        linksInContent.forEach(link => {
                            const decodedLinkHref = decodeURIComponent(link.getAttribute('href'));
                            // Cek apakah URL saat ini dimulai dengan URL link sub-bab
                            if (decodeURIComponent(currentPath).startsWith(decodedLinkHref)) {
                                // Ini adalah sub-bab yang aktif
                                link.classList.add('text-blue-600', 'font-semibold');
                                link.classList.remove('text-gray-700');
                                headerShouldBeActive = true; // Tandai bab induk juga aktif
                            }
                        });

                        if (headerShouldBeActive) {
                            // Buka bab induk dan tandai aktif
                            targetContent.classList.remove('hidden');
                            if (icon) icon.classList.add('rotate-180');
                            header.classList.add('bg-blue-500', 'text-white', 'rounded-lg'); // Tambahkan rounded-lg
                            header.classList.remove('text-gray-700');
                        }
                    }
                });
            }


            // Event listener untuk klik pada header bab
            collapsibleHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.dataset.collapseTarget;
                    const targetContent = document.querySelector(targetId);
                    const icon = this.querySelector('svg:last-child'); // Ikon panah

                    // Periksa apakah collapsible yang diklik sedang terbuka
                    const isCurrentlyOpen = !targetContent.classList.contains('hidden');

                    // Tutup semua collapsible lain yang sedang terbuka
                    collapsibleHeaders.forEach(otherHeader => {
                        const otherTargetId = otherHeader.dataset.collapseTarget;
                        const otherTargetContent = document.querySelector(otherTargetId);
                        const otherIcon = otherHeader.querySelector('svg:last-child');

                        // Jika itu bukan header yang sedang diklik
                        if (otherTargetContent && otherTargetContent !== targetContent) {
                            otherTargetContent.classList.add('hidden'); // Sembunyikan
                            otherIcon.classList.remove('rotate-180'); // Putar ikon kembali
                            otherHeader.classList.remove('bg-blue-500', 'text-white', 'rounded-lg'); // Hapus warna aktif dan rounded
                            otherHeader.classList.add('text-gray-700'); // Kembalikan warna default
                        }
                    });

                    // Toggle collapsible yang diklik (buka jika tertutup, tutup jika terbuka)
                    if (targetContent) { // Pastikan targetContent ada
                        targetContent.classList.toggle('hidden'); // Toggle visibility
                        icon.classList.toggle('rotate-180'); // Toggle ikon panah

                        // Toggle kelas aktif pada header yang diklik
                        this.classList.toggle('bg-blue-500');
                        this.classList.toggle('text-white');
                        this.classList.toggle('text-gray-700'); // Toggle kembali ke default jika ditutup
                        this.classList.toggle('rounded-lg'); // Toggle rounded-lg
                    }
                });
            });
        });
    </script>
</body>
</html>
