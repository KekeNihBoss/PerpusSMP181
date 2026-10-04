<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savansa Library - @yield('title', 'Beranda')</title>
    <link rel="shortcut icon" href="{{ asset('storage/icons/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Book Cover Ratio */
        .book-cover-9-16 {
            position: relative;
            padding-bottom: 177.78%; /* 16/9 * 100 */
            overflow: hidden;
        }

        .book-cover-9-16 img,
        .book-cover-9-16 > div {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Line clamp for better text truncation */
        .line-clamp-2 { 
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 { 
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
        /* Full Page Hero */
        .hero-slider { 
            height: 100vh;
            position: relative;
        }
        
        .swiper-slide img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }
        
        /* Overlay untuk text */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Text animation */
        .hero-text {
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .line-clamp-3 { 
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 { 
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
<body class="bg-gray-50" style="padding-top: 3rem;">

{{-- ========================= --}}
{{-- NAVBAR --}}
{{-- ========================= --}}
<nav class="bg-blue-700 text-white shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        
        {{-- LOGO (Kiri) --}}
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" onclick="return false;" data-href="{{ route('home') }}" class="block">
                <img 
                    src="{{ asset('storage/icons/savansa.png') }}" 
                    alt="Logo Perpustakaan" 
                    class="h-12 w-auto object-contain transition-transform hover:scale-105"
                >
            </a>
        </div>

        {{-- MENU DESKTOP (Tengah) --}}
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" 
               onclick="return false;" 
               data-href="{{ route('home') }}"
               class="hover:text-blue-200 transition-colors px-3 py-2">
                Beranda
            </a>

            {{-- DROPDOWN TENTANG --}}
            <div class="relative">
                <button 
                    id="dropdown-tentang-btn"
                    class="flex items-center hover:text-blue-200 transition-colors px-3 py-2"
                >
                    Tentang 
                    <i class="fa-solid fa-caret-down ml-2 text-sm"></i>
                </button>

                <div 
                    id="dropdown-tentang-menu"
                    class="hidden absolute left-1/2 -translate-x-1/2 mt-2 
                           bg-white text-gray-900 rounded-lg shadow-xl w-56 overflow-hidden z-50"
                >
                    <a href="{{ route('visi-misi') }}" 
                       onclick="return false;" 
                       data-href="{{ route('visi-misi') }}"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bullseye mr-2 text-blue-600"></i>Visi Misi
                    </a>
                    <a href="{{ route('struktur-pengelola') }}" 
                       onclick="return false;" 
                       data-href="{{ route('struktur-pengelola') }}"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-users-cog mr-2 text-green-600"></i>Struktur Pengelola
                    </a>
                    <a href="{{ route('tata-tertib') }}" 
                       onclick="return false;" 
                       data-href="{{ route('tata-tertib') }}"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-clipboard-list mr-2 text-orange-600"></i>Tata Tertib
                    </a>
                </div>
            </div>

            {{-- DROPDOWN LAINNYA --}}
            <div class="relative">
                <button 
                    id="dropdown-lainnya-btn"
                    class="flex items-center hover:text-blue-200 transition-colors px-3 py-2"
                >
                    Lainnya
                    <i class="fa-solid fa-caret-down ml-2 text-sm"></i>
                </button>

                <div 
                    id="dropdown-lainnya-menu"
                    class="hidden absolute left-1/2 -translate-x-1/2 mt-2 
                           bg-white text-gray-900 rounded-lg shadow-xl w-56 overflow-hidden z-50"
                >
                    <a href="{{ route('buku.index') }}" 
                       onclick="return false;" 
                       data-href="{{ route('buku.index') }}"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-book mr-2 text-yellow-600"></i>Katalog Buku
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       onclick="return false;" 
                       data-href="{{ route('blog.index') }}"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calendar mr-2 text-purple-600"></i>Event & Berita
                    </a>
                    <div class="border-t my-1"></div>
                    <a href="#" 
                       onclick="return false;" 
                       data-href="#"
                       class="block px-4 py-3 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-file-pdf mr-2 text-red-600"></i>E-Book
                    </a>
                </div>
            </div>
        </div>

        {{-- LOGIN & TOGGLE (Kanan) --}}
        <div class="flex-shrink-0 flex items-center gap-3">
            <a 
                href="/perpus/login" 
                onclick="return false;" 
                data-href="/perpus/login"
                class="hidden md:block bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold 
                       hover:bg-blue-100 transition-colors"
            >
                Login
            </a>

            <button 
                id="menu-toggle" 
                class="md:hidden text-2xl p-2 focus:outline-none hover:bg-blue-600 rounded transition"
            >
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div 
        id="mobile-menu"
        class="hidden md:hidden bg-blue-600 px-4 pb-4 space-y-2"
    >
        <a href="{{ route('home') }}" 
           onclick="return false;" 
           data-href="{{ route('home') }}"
           class="block py-2 hover:text-blue-200 transition">
            Beranda
        </a>

        {{-- MOBILE DROPDOWN TENTANG --}}
        <div>
            <button 
                id="dropdown-tentang-mobile-btn"
                class="flex items-center w-full py-2 hover:text-blue-200 transition"
            >
                Tentang 
                <i class="fa-solid fa-caret-down ml-2 text-sm"></i>
            </button>
            <div id="dropdown-tentang-mobile" class="hidden pl-4 space-y-1 mt-2">
                <a href="{{ route('visi-misi') }}" 
                   onclick="return false;" 
                   data-href="{{ route('visi-misi') }}"
                   class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-bullseye mr-2"></i>Visi Misi
                </a>
                <a href="{{ route('struktur-pengelola') }}" 
                   onclick="return false;" 
                   data-href="{{ route('struktur-pengelola') }}"
                   class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-users-cog mr-2"></i>Struktur Pengelola
                </a>
                <a href="{{ route('tata-tertib') }}" 
                   onclick="return false;" 
                   data-href="{{ route('tata-tertib') }}"
                   class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-clipboard-list mr-2"></i>Tata Tertib
                </a>
            </div>
        </div>

        {{-- MOBILE DROPDOWN LAINNYA --}}
        <div>
            <button 
                id="dropdown-lainnya-mobile-btn"
                class="flex items-center w-full py-2 hover:text-blue-200 transition"
            >
                Lainnya
                <i class="fa-solid fa-caret-down ml-2 text-sm"></i>
            </button>
            <div id="dropdown-lainnya-mobile" class="hidden pl-4 space-y-1 mt-2">
                <a href="{{ route('buku.index') }}" 
                   onclick="return false;" 
                   data-href="{{ route('buku.index') }}"
                   class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-book mr-2"></i>Katalog Buku
                </a>
                <a href="{{ route('blog.index') }}" 
                   onclick="return false;" 
                   data-href="{{ route('blog.index') }}"
                   class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-calendar mr-2"></i>Event & Berita
                </a>
                <a href="#" class="block py-2 hover:text-blue-200 transition">
                    <i class="fas fa-file-pdf mr-2"></i>E-Book
                </a>
            </div>
        </div>

        <a href="/perpus/login" 
           onclick="return false;" 
           data-href="/perpus/login"
           class="block bg-white text-blue-700 text-center py-2 rounded-lg font-semibold hover:bg-blue-100 transition mt-3">
            Login
        </a>
    </div>
</nav>

{{-- ==================== CONTENT ==================== --}}
<main class="py-6">
    @yield('content')
</main>

{{-- ========================= --}}
{{-- FOOTER --}}
{{-- ========================= --}}
<footer class="bg-gray-900 text-white py-14">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
            <h3 class="text-xl font-bold mb-4">Lokasi Kami</h3>
            <div class="rounded overflow-hidden shadow-lg">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.402069012175!2d106.81238567521703!3d-6.210583293777253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6ab235c8a05%3A0xe63fa8c5a660dfb9!2sSekolah%20Menengah%20Pertama%20Negeri%20181%20Jakarta%20Pusat!5e0!3m2!1sid!2sid!4v1763730564100!5m2!1sid!2sid" 
                        width="100%" height="250" style="border:0;" loading="lazy"></iframe>
            </div>
            <p class="mt-4 text-gray-400 text-sm">
                Jl. Mesjid I Karet Tengsin No.5, Karet Tengsin, Tanah Abang, Jakarta Pusat<br>
                Telp: 0215738060
            </p>
        </div>

        <div class="flex flex-col justify-start">
            <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
            <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white text-lg transition mb-4">
                <i class="fab fa-instagram text-2xl"></i>
                <span>Instagram</span>
            </a>
            <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white text-lg transition">
                <i class="fab fa-youtube text-2xl"></i>
                <span>YouTube</span>
            </a>
        </div>
    </div>

    <div class="text-center text-gray-500 mt-10 border-t border-gray-800 pt-5">
        &copy; {{ date('Y') }} Savansa Library. All rights reserved.
    </div>
</footer>

{{-- ========================= --}}
{{-- SCRIPTS --}}
{{-- ========================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// ========================================
// ANTI INSPECT ELEMENT
// ========================================
document.addEventListener('contextmenu', e => e.preventDefault());

document.addEventListener('keydown', e => {
    if (
        e.key === 'F12' || 
        (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
        (e.ctrlKey && e.key === 'U')
    ) {
        e.preventDefault();
        alert('Fitur ini dinonaktifkan!');
    }
});

// ========================================
// HIDE LINK PREVIEW + CUSTOM NAVIGATION
// ========================================
document.querySelectorAll('a[data-href]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('data-href');
        if (href && href !== '#') {
            window.location.href = href;
        }
    });
});

// ========================================
// SWIPER
// ========================================
if (document.querySelector('.hero-slider')) {
    new Swiper('.hero-slider', {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        effect: 'fade',
        speed: 1000
    });
}

// ========================================
// MOBILE MENU TOGGLE
// ========================================
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');

if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// ========================================
// DESKTOP DROPDOWN TENTANG
// ========================================
const dropTentangBtn = document.getElementById('dropdown-tentang-btn');
const dropTentangMenu = document.getElementById('dropdown-tentang-menu');

if (dropTentangBtn && dropTentangMenu) {
    dropTentangBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropTentangMenu.classList.toggle('hidden');
        if (dropLainnyaMenu) dropLainnyaMenu.classList.add('hidden');
    });
}

// ========================================
// DESKTOP DROPDOWN LAINNYA
// ========================================
const dropLainnyaBtn = document.getElementById('dropdown-lainnya-btn');
const dropLainnyaMenu = document.getElementById('dropdown-lainnya-menu');

if (dropLainnyaBtn && dropLainnyaMenu) {
    dropLainnyaBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropLainnyaMenu.classList.toggle('hidden');
        if (dropTentangMenu) dropTentangMenu.classList.add('hidden');
    });
}

// ========================================
// MOBILE DROPDOWN TENTANG
// ========================================
const dropTentangMobileBtn = document.getElementById('dropdown-tentang-mobile-btn');
const dropTentangMobile = document.getElementById('dropdown-tentang-mobile');

if (dropTentangMobileBtn && dropTentangMobile) {
    dropTentangMobileBtn.addEventListener('click', () => {
        dropTentangMobile.classList.toggle('hidden');
    });
}

// ========================================
// MOBILE DROPDOWN LAINNYA
// ========================================
const dropLainnyaMobileBtn = document.getElementById('dropdown-lainnya-mobile-btn');
const dropLainnyaMobile = document.getElementById('dropdown-lainnya-mobile');

if (dropLainnyaMobileBtn && dropLainnyaMobile) {
    dropLainnyaMobileBtn.addEventListener('click', () => {
        dropLainnyaMobile.classList.toggle('hidden');
    });
}

// ========================================
// CLOSE DROPDOWN WHEN CLICK OUTSIDE
// ========================================
document.addEventListener('click', () => {
    if (dropTentangMenu) dropTentangMenu.classList.add('hidden');
    if (dropLainnyaMenu) dropLainnyaMenu.classList.add('hidden');
});

// ========================================
// SMOOTH SCROLL
// ========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
});

// ========================================
// CHARTS (Absensi & Pengembalian)
// ========================================
const ctxAbsensi = document.getElementById('absensiChart');
if (ctxAbsensi) {
    new Chart(ctxAbsensi, {
        type: 'line',
        data: {
            labels: @json($absensiLabels ?? []),
            datasets: [{
                label: 'Jumlah Absensi',
                data: @json($absensiValues ?? []),
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(147, 51, 234)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 12 } },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
}

const ctxPengembalian = document.getElementById('pengembalianChart');
if (ctxPengembalian) {
    new Chart(ctxPengembalian, {
        type: 'bar',
        data: {
            labels: @json($pengembalianLabels ?? []),
            datasets: [{
                label: 'Jumlah Pengembalian',
                data: @json($pengembalianValues ?? []),
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(34, 197, 94, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 12 } },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
}
</script>

@stack('scripts')
</body>
</html>