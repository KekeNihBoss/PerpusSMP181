<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan - Preview</title>
    <link rel="shortcut icon" href="(asset('storage/icons/savansa.png'))" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        
        /* Dark Mode Styles - Lebih Pekat */
        .dark {
            background-color: #0a0a0a;
            color: #f3f4f6;
        }
        .dark .bg-white {
            background-color: #1a1a1a;
        }
        .dark .text-gray-900 {
            color: #f3f4f6;
        }
        .dark .text-gray-500 {
            color: #a3a3a3;
        }
        .dark .text-gray-600 {
            color: #a3a3a3;
        }
        .dark .border-gray-200 {
            border-color: #2a2a2a;
        }
        .dark .bg-gray-50 {
            background-color: #0a0a0a;
        }
        .dark .chart-container {
            background-color: #1a1a1a;
            border: 1px solid #2a2a2a;
        }
        .dark .bg-blue-50 {
            background-color: #1a2a3a;
        }
        .dark .border-blue-200 {
            border-color: #2a3a4a;
        }
        .dark .shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }
        .dark select {
            background-color: #2a2a2a;
            color: #f3f4f6;
            border-color: #3a3a3a;
        }
        .dark select:focus {
            border-color: #3b82f6;
            ring-color: #3b82f6;
        }
        .dark option {
            background-color: #2a2a2a;
            color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div id="logoTrigger" class="bg-blue-600 rounded-lg p-2 cursor-pointer hover:bg-blue-700 transition" title="Tap 3x untuk masuk dashboard">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Perpustakaan</h1>
                        <p class="text-sm text-gray-500">Sistem Manajemen Perpustakaan Sekolah</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="toggleDarkMode()" id="themeToggle" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 p-2 rounded-lg transition">
                        <svg id="iconLight" class="w-5 h-5 text-gray-800 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="iconDark" class="w-5 h-5 text-yellow-300 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Absen Hari Ini -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-green-600 text-sm font-medium">+12%</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">📋 Absen Hari Ini</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">42</p>
                <p class="text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Pengunjung hari ini
                </p>
            </div>

            <!-- Card 2: Welcome -->
            <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="bg-white/20 rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-white/90 text-sm font-medium mb-1">👋 Selamat Datang</h3>
                <p class="text-2xl font-bold mb-2">Admin Perpustakaan</p>
                <p class="text-sm text-white/80 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Semangat menjalani hari ini! ✨
                </p>
            </div>

            <!-- Card 3: Buku Dipinjam -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-orange-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-orange-600 text-sm font-medium">78 Total</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">📚 Buku Sedang Dipinjam</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">23</p>
                <p class="text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Buku yang masih dipinjam
                </p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Absensi Chart -->
            <div class="chart-container">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span class="mr-2">📊</span>
                        Grafik Absensi Pengunjung
                    </h2>
                    <select id="absenFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily">Per Hari</option>
                        <option value="monthly">Per Bulan</option>
                    </select>
                </div>
                <canvas id="absenChart"></canvas>
            </div>

            <!-- Pengembalian Chart -->
            <div class="chart-container">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span class="mr-2">📚</span>
                        Grafik Pengembalian Buku
                    </h2>
                    <select id="pengembalianFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily">Per Hari</option>
                        <option value="monthly">Per Bulan</option>
                    </select>
                </div>
                <canvas id="pengembalianChart"></canvas>
            </div>
        </div>

        <!-- Info Banner -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Preview Dashboard dengan Data Dummy</h3>
            <p class="text-gray-600 mb-4">Ini adalah preview dashboard perpustakaan. Data yang ditampilkan adalah contoh dummy untuk keperluan demonstrasi.</p>
            <!-- <button onclick="alert('Hubungi developer untuk implementasi data real!')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                Request Data Real
            </button> -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 text-sm">
                © 2025 Sistem Perpustakaan Sekolah. Dashboard Preview v1.0 · <span class="text-xs text-gray-400">Psst... tap logo 3x 🤫</span>
            </p>
        </div>
    </footer>

    <script>
        // Secret Logo Triple Tap to Dashboard
        let tapCount = 0;
        let tapTimer = null;
        
        document.getElementById('logoTrigger').addEventListener('click', function() {
            tapCount++;
            
            if (tapCount === 1) {
                tapTimer = setTimeout(() => {
                    tapCount = 0;
                }, 800); // Reset setelah 800ms
            }
            
            if (tapCount === 3) {
                clearTimeout(tapTimer);
                tapCount = 0;
                
                // Ganti '/admin' dengan URL dashboard Filament kamu
                window.location.href = '/perpus';
                
                // Atau kalau mau ke login page:
                // window.location.href = '/admin/login';
            }
        });

        // Dark Mode Toggle - Default DARK
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        // Load dark mode preference - DEFAULT DARK
        if (localStorage.getItem('darkMode') === null) {
            // Jika belum ada preferensi, set default dark
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        } else if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Data Dummy untuk Charts
        const dummyDataDaily = {
            labels: ['1 Oct', '2 Oct', '3 Oct', '4 Oct', '5 Oct', '6 Oct', '7 Oct', '8 Oct', '9 Oct', '10 Oct'],
            male: [5, 8, 6, 10, 7, 12, 9, 11, 8, 14],
            female: [4, 6, 8, 7, 9, 8, 11, 9, 12, 10]
        };

        const dummyDataMonthly = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            male: [120, 145, 135, 160, 150, 175, 165, 180, 170, 190],
            female: [110, 130, 125, 145, 140, 155, 150, 165, 160, 175]
        };

        // Chart Configuration
        const chartConfig = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        };

        // Absensi Chart
        let absenChart = new Chart(document.getElementById('absenChart'), {
            ...chartConfig,
            data: {
                labels: dummyDataDaily.labels,
                datasets: [
                    {
                        label: '👨 Laki-Laki',
                        data: dummyDataDaily.male,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: '👩 Perempuan',
                        data: dummyDataDaily.female,
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            }
        });

        // Pengembalian Chart
        let pengembalianChart = new Chart(document.getElementById('pengembalianChart'), {
            ...chartConfig,
            data: {
                labels: dummyDataDaily.labels,
                datasets: [
                    {
                        label: '👨 Laki-Laki',
                        data: dummyDataDaily.male.map(v => v - 2),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: '👩 Perempuan',
                        data: dummyDataDaily.female.map(v => v - 1),
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            }
        });

        // Filter Handlers
        document.getElementById('absenFilter').addEventListener('change', function(e) {
            const data = e.target.value === 'monthly' ? dummyDataMonthly : dummyDataDaily;
            absenChart.data.labels = data.labels;
            absenChart.data.datasets[0].data = data.male;
            absenChart.data.datasets[1].data = data.female;
            absenChart.update();
        });

        document.getElementById('pengembalianFilter').addEventListener('change', function(e) {
            const data = e.target.value === 'monthly' ? dummyDataMonthly : dummyDataDaily;
            pengembalianChart.data.labels = data.labels;
            pengembalianChart.data.datasets[0].data = data.male.map(v => v - 2);
            pengembalianChart.data.datasets[1].data = data.female.map(v => v - 1);
            pengembalianChart.update();
        });

        // ========================================
        // CARA MENGGANTI KE DATA ASLI:
        // ========================================
        // 1. Buat API endpoint di Laravel (routes/api.php):
        //    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        //    Route::get('/dashboard/absen-chart', [DashboardController::class, 'absenChart']);
        //    Route::get('/dashboard/pengembalian-chart', [DashboardController::class, 'pengembalianChart']);
        //
        // 2. Di DashboardController, return data JSON:
        //    public function stats() {
        //        return response()->json([
        //            'absen_today' => Absen::whereDate('tanggal', now())->count(),
        //            'buku_dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
        //        ]);
        //    }
        //
        // 3. Ganti data dummy dengan fetch API:
        //    async function loadRealData() {
        //        const response = await fetch('/api/dashboard/stats');
        //        const data = await response.json();
        //        // Update stats cards dengan data real
        //        document.querySelector('.stat-card:nth-child(1) p.text-3xl').textContent = data.absen_today;
        //        document.querySelector('.stat-card:nth-child(3) p.text-3xl').textContent = data.buku_dipinjam;
        //    }
        //    loadRealData();
        //
        // 4. Untuk chart data:
        //    async function loadChartData() {
        //        const response = await fetch('/api/dashboard/absen-chart?filter=daily');
        //        const data = await response.json();
        //        absenChart.data.labels = data.labels;
        //        absenChart.data.datasets[0].data = data.male;
        //        absenChart.data.datasets[1].data = data.female;
        //        absenChart.update();
        //    }
        //    loadChartData();
    </script>
</body>
</html>