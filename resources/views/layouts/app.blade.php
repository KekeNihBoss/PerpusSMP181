<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savansa Library — @yield('title', 'Beranda')</title>
    <link rel="shortcut icon" href="{{ asset('storage/icons/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:  {50:'#F0F4F9',100:'#DCE4EF',200:'#B9C7DB',400:'#64809F',600:'#2A4364',700:'#1F3450',800:'#16263D',900:'#0F1B2D',950:'#0A1420'},
                        sky2:  {50:'#F0F9FF',100:'#E0F2FE',300:'#7DD3FC',400:'#38BDF8',500:'#0EA5E9',600:'#0284C7',700:'#0369A1'},
                        cream: {50:'#FAF6EF',100:'#F3EDE0',200:'#E8DFCC'}
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"','ui-sans-serif','system-ui','sans-serif'],
                        display: ['Fraunces','Georgia','serif']
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            padding-top: 4.5rem;
            /* 72px teratas navy senada navbar, sisanya cream — mencegah garis terlihat di bawah navbar */
            background: linear-gradient(to bottom, #0A1420 4.5rem, #FAF6EF 4.5rem);
            background-repeat: no-repeat;
            background-color: #FAF6EF;
        }

        /* ---------- Text truncation ---------- */
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* ---------- Book cover ratio ---------- */
        .book-cover-9-16 { position: relative; padding-bottom: 155%; overflow: hidden; }
        .book-cover-9-16 img,
        .book-cover-9-16 > div { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

        /* ---------- Navbar ---------- */
        #main-nav { transition: box-shadow .3s ease, background-color .3s ease; }
        #main-nav.nav-scrolled { background: rgba(10,20,32,.97); box-shadow: 0 10px 30px rgba(10,20,32,.35); }
        .nav-link { color: rgba(220,228,239,.85); }
        .nav-link:hover, .nav-link.nav-active { color: #38BDF8; }
        .nav-link.nav-active { font-weight: 700; }

        /* ---------- Hero ---------- */
        .hero-slider { height: 100vh; height: 100svh; position: relative; }
        .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
        .hero-overlay {
            position: absolute; inset: 0; z-index: 10;
            display: flex; align-items: center;
            background: linear-gradient(100deg, rgba(10,20,32,.94) 8%, rgba(15,27,45,.78) 45%, rgba(15,27,45,.30) 100%);
        }
        .hero-overlay::after {
            content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 42%;
            background: linear-gradient(to top, rgba(10,20,32,.88), transparent);
        }
        .hero-text { animation: fadeInUp 1s ease-out; position: relative; z-index: 11; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .hero-slider .swiper-pagination-bullet { background: rgba(255,255,255,.5); opacity: 1; }
        .hero-slider .swiper-pagination-bullet-active { background: #38BDF8; }

        /* ---------- Reveal on scroll ---------- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }

        /* ---------- Shelf ---------- */
        .shelf-card { transition: transform .3s ease, box-shadow .3s ease; }
        .shelf-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(10,20,32,.35); }
    </style>
</head>
<body class="font-sans text-navy-900 antialiased">

{{-- ========================= --}}
{{-- NAVBAR --}}
{{-- ========================= --}}
<nav id="main-nav" class="bg-navy-900/90 backdrop-blur text-white fixed top-0 left-0 right-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
            <img src="{{ asset('storage/icons/savansa.png') }}" alt="Logo Savansa Library" class="h-11 w-auto object-contain">
        </a>

        {{-- MENU DESKTOP --}}
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="nav-link transition-colors px-1 py-2 {{ request()->routeIs('home') ? 'nav-active' : '' }}">Beranda</a>

            {{-- DROPDOWN TENTANG --}}
            <div class="relative">
                <button id="dropdown-tentang-btn" class="nav-link flex items-center transition-colors px-1 py-2">
                    Tentang <i class="fa-solid fa-caret-down ml-2 text-xs"></i>
                </button>
                <div id="dropdown-tentang-menu" class="hidden absolute left-1/2 -translate-x-1/2 mt-3 bg-white text-navy-900 rounded-xl shadow-2xl w-56 overflow-hidden z-50 border border-cream-200">
                    <a href="{{ route('visi-misi') }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium">
                        <i class="fas fa-bullseye text-sky2-600"></i>Visi & Misi
                    </a>
                    <a href="{{ route('struktur-pengelola') }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium border-t border-cream-100">
                        <i class="fas fa-users-cog text-sky2-600"></i>Struktur Pengelola
                    </a>
                    <a href="{{ route('tata-tertib') }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium border-t border-cream-100">
                        <i class="fas fa-clipboard-list text-sky2-600"></i>Tata Tertib
                    </a>
                </div>
            </div>

            {{-- DROPDOWN LAINNYA --}}
            <div class="relative">
                <button id="dropdown-lainnya-btn" class="nav-link flex items-center transition-colors px-1 py-2">
                    Koleksi <i class="fa-solid fa-caret-down ml-2 text-xs"></i>
                </button>
                <div id="dropdown-lainnya-menu" class="hidden absolute left-1/2 -translate-x-1/2 mt-3 bg-white text-navy-900 rounded-xl shadow-2xl w-56 overflow-hidden z-50 border border-cream-200">
                    <a href="{{ route('buku.index') }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium">
                        <i class="fas fa-book text-sky2-600"></i>Katalog Buku
                    </a>
                    <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium border-t border-cream-100">
                        <i class="fas fa-calendar text-sky2-600"></i>Event & Berita
                    </a>
                    <div class="border-t border-cream-100">
                        <a href="#" class="flex items-center gap-3 px-5 py-3.5 hover:bg-sky2-50 transition-colors text-sm font-medium text-navy-400">
                            <i class="fas fa-file-pdf text-sky2-600"></i>E-Book <span class="ml-auto text-[10px] uppercase tracking-wider text-navy-200">Segera</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- LOGIN & TOGGLE --}}
        <div class="flex-shrink-0 flex items-center gap-3">
            <a href="/perpus/login" class="hidden md:block bg-sky2-500 text-navy-950 px-5 py-2 rounded-lg font-bold text-sm hover:bg-sky2-400 transition-colors shadow-lg shadow-sky2-500/25">
                Login Admin
            </a>
            <button id="menu-toggle" class="md:hidden text-xl p-2 focus:outline-none hover:bg-white/10 rounded transition">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="hidden md:hidden bg-navy-800 px-4 pb-4 space-y-1">
        <a href="{{ route('home') }}" class="block py-2.5 text-cream-100 hover:text-sky2-400 transition">Beranda</a>

        <div>
            <button id="dropdown-tentang-mobile-btn" class="flex items-center w-full py-2.5 text-cream-100 hover:text-sky2-400 transition">
                Tentang <i class="fa-solid fa-caret-down ml-2 text-xs"></i>
            </button>
            <div id="dropdown-tentang-mobile" class="hidden pl-4 space-y-1 mt-1 pb-2">
                <a href="{{ route('visi-misi') }}" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">Visi & Misi</a>
                <a href="{{ route('struktur-pengelola') }}" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">Struktur Pengelola</a>
                <a href="{{ route('tata-tertib') }}" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">Tata Tertib</a>
            </div>
        </div>

        <div>
            <button id="dropdown-lainnya-mobile-btn" class="flex items-center w-full py-2.5 text-cream-100 hover:text-sky2-400 transition">
                Koleksi <i class="fa-solid fa-caret-down ml-2 text-xs"></i>
            </button>
            <div id="dropdown-lainnya-mobile" class="hidden pl-4 space-y-1 mt-1 pb-2">
                <a href="{{ route('buku.index') }}" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">Katalog Buku</a>
                <a href="{{ route('blog.index') }}" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">Event & Berita</a>
                <a href="#" class="block py-2 text-sm text-cream-100/80 hover:text-sky2-400 transition">E-Book <span class="text-[10px] uppercase tracking-wider text-navy-200">Segera</span></a>
            </div>
        </div>

        <a href="/perpus/login" class="block bg-sky2-500 text-navy-950 text-center py-2.5 rounded-lg font-bold hover:bg-sky2-400 transition mt-3">
            Login Admin
        </a>
    </div>
</nav>

{{-- ==================== CONTENT ==================== --}}
<main>
    @yield('content')
</main>

{{-- ========================= --}}
{{-- FOOTER --}}
{{-- ========================= --}}
<footer class="bg-navy-950 text-white">
    <div class="container mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-3 gap-12">

        {{-- BRAND --}}
        <div>
            <div class="flex items-center gap-3 mb-5">
                <img src="{{ asset('storage/icons/savansa.png') }}" alt="Logo Savansa Library" class="h-12 w-auto object-contain">
            </div>
            <p class="text-cream-100/60 text-sm leading-relaxed mb-5">
                Perpustakaan SMP Negeri 181 Jakarta — melayani siswa dan guru dengan koleksi buku, ruang baca, dan layanan peminjaman digital.
            </p>
            <div class="flex gap-3">
                <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-lg bg-white/5 hover:bg-sky2-500 hover:text-navy-950 flex items-center justify-center transition-colors">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <a href="#" aria-label="YouTube" class="w-10 h-10 rounded-lg bg-white/5 hover:bg-sky2-500 hover:text-navy-950 flex items-center justify-center transition-colors">
                    <i class="fab fa-youtube text-lg"></i>
                </a>
            </div>
        </div>

        {{-- QUICK LINKS --}}
        <div>
            <h3 class="font-display text-lg font-semibold text-sky2-400 mb-5">Jelajahi</h3>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('home') }}" class="text-cream-100/70 hover:text-sky2-400 transition-colors">Beranda</a></li>
                <li><a href="{{ route('buku.index') }}" class="text-cream-100/70 hover:text-sky2-400 transition-colors">Katalog Buku</a></li>
                <li><a href="{{ route('blog.index') }}" class="text-cream-100/70 hover:text-sky2-400 transition-colors">Event & Berita</a></li>
                <li><a href="{{ route('visi-misi') }}" class="text-cream-100/70 hover:text-sky2-400 transition-colors">Visi & Misi</a></li>
                <li><a href="{{ route('tata-tertib') }}" class="text-cream-100/70 hover:text-sky2-400 transition-colors">Tata Tertib</a></li>
            </ul>
        </div>

        {{-- LOKASI --}}
        <div>
            <h3 class="font-display text-lg font-semibold text-sky2-400 mb-5">Lokasi Kami</h3>
            <div class="rounded-xl overflow-hidden border border-white/10">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.402069012175!2d106.81238567521703!3d-6.210583293777253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6ab235c8a05%3A0xe63fa8c5a660dfb9!2sSekolah%20Menengah%20Pertama%20Negeri%20181%20Jakarta%20Pusat!5e0!3m2!1sid!2sid!4v1763730564100!5m2!1sid!2sid"
                        width="100%" height="180" style="border:0;" loading="lazy" title="Peta lokasi SMP Negeri 181 Jakarta"></iframe>
            </div>
            <p class="mt-4 text-cream-100/60 text-sm leading-relaxed">
                Jl. Mesjid I Karet Tengsin No.5, Karet Tengsin, Tanah Abang, Jakarta Pusat<br>
                <span class="text-cream-100/80"><i class="fas fa-phone text-sky2-400 mr-2 text-xs"></i>021-5738060</span>
            </p>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container mx-auto px-4 py-5 text-center text-cream-100/40 text-xs">
            &copy; {{ date('Y') }} Savansa Library — Perpustakaan SMP Negeri 181 Jakarta Pusat.
        </div>
    </div>
</footer>

{{-- ========================= --}}
{{-- SCRIPTS --}}
{{-- ========================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// ========================================
// NAVBAR SCROLL EFFECT
// ========================================
const mainNav = document.getElementById('main-nav');
const onNavScroll = () => mainNav.classList.toggle('nav-scrolled', window.scrollY > 24);
onNavScroll();
window.addEventListener('scroll', onNavScroll, { passive: true });

// ========================================
// NAV ACTIVE STATE
// ========================================
document.querySelectorAll('#main-nav .nav-link[href]').forEach(link => {
    if (link.pathname === window.location.pathname && link.pathname !== '/') {
        link.classList.add('nav-active');
    }
});

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
// MOBILE MENU TOGGLE
// ========================================
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', e => {
        e.stopPropagation();
        mobileMenu.classList.toggle('hidden');
    });
}

// ========================================
// DROPDOWNS (auto-close satu sama lain)
// ========================================
const closeAllDropdowns = () => {
    document.querySelectorAll('#dropdown-tentang-menu, #dropdown-lainnya-menu, #dropdown-tentang-mobile, #dropdown-lainnya-mobile').forEach(el => el.classList.add('hidden'));
};

const bindDropdown = (btnId, menuId) => {
    const btn = document.getElementById(btnId);
    const menu = document.getElementById(menuId);
    if (btn && menu) {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const isOpen = !menu.classList.contains('hidden');
            closeAllDropdowns();
            if (!isOpen) menu.classList.remove('hidden');
        });
    }
};
bindDropdown('dropdown-tentang-btn', 'dropdown-tentang-menu');
bindDropdown('dropdown-lainnya-btn', 'dropdown-lainnya-menu');
bindDropdown('dropdown-tentang-mobile-btn', 'dropdown-tentang-mobile');
bindDropdown('dropdown-lainnya-mobile-btn', 'dropdown-lainnya-mobile');

// Klik di luar: tutup semua dropdown + mobile menu
document.addEventListener('click', e => {
    closeAllDropdowns();
    if (mobileMenu && !mobileMenu.contains(e.target) && e.target !== menuToggle && !menuToggle.contains(e.target)) {
        mobileMenu.classList.add('hidden');
    }
});

// Klik link apa pun di mobile menu: tutup mobile menu
if (mobileMenu) {
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            closeAllDropdowns();
            mobileMenu.classList.add('hidden');
        });
    });
}

// ========================================
// SMOOTH SCROLL
// ========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// ========================================
// REVEAL ON SCROLL
// ========================================
const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ========================================
// HERO SLIDER
// ========================================
if (document.querySelector('.hero-slider')) {
    new Swiper('.hero-slider', {
        loop: true,
        autoplay: { delay: 5500, disableOnInteraction: false },
        pagination: { el: '.hero-slider .swiper-pagination', clickable: true },
        effect: 'fade',
        speed: 1100
    });
}

// ========================================
// BOOK SHELF SLIDER
// ========================================
if (document.querySelector('.book-shelf')) {
    new Swiper('.book-shelf', {
        slidesPerView: 2,
        spaceBetween: 16,
        navigation: { nextEl: '.book-next', prevEl: '.book-prev' },
        breakpoints: {
            640:  { slidesPerView: 3, spaceBetween: 16 },
            1024: { slidesPerView: 5, spaceBetween: 24 }
        }
    });
}

// ========================================
// CHART DEFAULTS
// ========================================
if (window.Chart) {
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#1F3450';
}

const ctxAbsensi = document.getElementById('absensiChart');
let absensiChart = null;
if (ctxAbsensi) {
    absensiChart = new Chart(ctxAbsensi, {
        type: 'line',
        data: {
            labels: @json($absensiLabels ?? []),
            datasets: [{
                label: 'Jumlah Absensi',
                data: @json($absensiValues ?? []),
                borderColor: 'rgb(56, 189, 248)',
                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(56, 189, 248)',
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
                    backgroundColor: 'rgba(10, 20, 32, 0.92)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(56, 189, 248)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 12 } },
                    grid: { color: 'rgba(15, 27, 45, 0.06)' }
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
let pengembalianChart = null;
if (ctxPengembalian) {
    pengembalianChart = new Chart(ctxPengembalian, {
        type: 'bar',
        data: {
            labels: @json($pengembalianLabels ?? []),
            datasets: [{
                label: 'Jumlah Pengembalian',
                data: @json($pengembalianValues ?? []),
                backgroundColor: 'rgba(31, 52, 80, 0.85)',
                borderColor: 'rgb(31, 52, 80)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(31, 52, 80, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(10, 20, 32, 0.92)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(56, 189, 248)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 12 } },
                    grid: { color: 'rgba(15, 27, 45, 0.06)' }
                },
                x: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
}
// ========================================
// FILTER GRAFIK TANPA RELOAD (AJAX)
// ========================================
document.querySelectorAll('[data-chart-filter]').forEach(btn => {
    btn.addEventListener('click', async e => {
        e.preventDefault();
        const filter = btn.dataset.chartFilter;

        document.querySelectorAll('[data-chart-filter]').forEach(b => {
            const active = b === btn;
            b.classList.toggle('bg-navy-900', active);
            b.classList.toggle('text-sky2-400', active);
            b.classList.toggle('border-navy-900', active);
            b.classList.toggle('shadow-lg', active);
            b.classList.toggle('bg-transparent', !active);
            b.classList.toggle('text-navy-600', !active);
            b.classList.toggle('border-cream-200', !active);
            b.classList.toggle('hover:border-sky2-400', !active);
        });

        try {
            const res = await fetch(`{{ url('api/chart-data') }}?filter=${filter}`);
            const data = await res.json();

            if (absensiChart) {
                absensiChart.data.labels = data.absensi.labels;
                absensiChart.data.datasets[0].data = data.absensi.values;
                absensiChart.update();
            }
            if (pengembalianChart) {
                pengembalianChart.data.labels = data.pengembalian.labels;
                pengembalianChart.data.datasets[0].data = data.pengembalian.values;
                pengembalianChart.update();
            }

            history.replaceState(null, '', filter === 'month' ? '?chart_filter=month' : '?chart_filter=7days');
        } catch (err) {
            window.location.href = btn.href;
        }
    });
});
</script>

@stack('scripts')
</body>
</html>
