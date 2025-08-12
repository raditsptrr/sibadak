<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Badak - Bakorwil 3 Malang</title>

    {{-- Aset CSS & JS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* CSS untuk transisi buka/tutup menu sidebar yang mulus */
        .collapsible-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        /* Style untuk link sub-menu yang aktif */
        .active-link {
            color: #2563EB; /* a blue color */
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md hidden sm:block flex-shrink-0">
            <div class="p-4 h-full">
                {{-- Memuat sidebar dan mengirimkan data kategori dinamis --}}
                @include('partials.sidebar', ['mainCategoriesWithSubs' => $mainCategoriesWithSubs ?? [], 'kabupatenKotas' => $kabupatenKotas ?? []])
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-100 p-6 pb-0">
                @yield('navbar')
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- SCRIPT BARU YANG LEBIH CERDAS UNTUK SIDEBAR --}}
    {{-- ================================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collapsibleHeaders = document.querySelectorAll('.collapsible-header');
            const currentUrl = window.location.href;

            // Fungsi untuk membuka menu yang aktif saat halaman dimuat
            function setInitialActiveState() {
                collapsibleHeaders.forEach(header => {
                    const content = header.nextElementSibling;
                    if (!content) return;
                    
                    const links = content.querySelectorAll('a');
                    let isActive = false;

                    links.forEach(link => {
                        if (link.href === currentUrl) {
                            isActive = true;
                            link.classList.add('active-link');
                        }
                    });

                    if (isActive) {
                        content.style.maxHeight = content.scrollHeight + "px";
                        const arrow = header.querySelector('svg:last-child');
                        if (arrow) arrow.classList.add('rotate-180');
                    }
                });
            }

            setInitialActiveState();

            // Tambahkan event listener untuk klik
            collapsibleHeaders.forEach(header => {
                header.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    if (!content) return;

                    const arrow = this.querySelector('svg:last-child');
                    const isCurrentlyOpen = content.style.maxHeight;

                    // Tutup semua menu lain
                    document.querySelectorAll('.collapsible-content').forEach(item => {
                        if (item !== content) {
                            item.style.maxHeight = null;
                            const otherArrow = item.previousElementSibling.querySelector('svg:last-child');
                            if (otherArrow) otherArrow.classList.remove('rotate-180');
                        }
                    });

                    if (isCurrentlyOpen) {
                        content.style.maxHeight = null;
                        if (arrow) arrow.classList.remove('rotate-180');
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                        if (arrow) arrow.classList.add('rotate-180');
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
