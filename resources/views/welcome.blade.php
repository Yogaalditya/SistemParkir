<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir Sekolah</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-car"></i> Parkir Sekolah</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item active" data-page="dashboard">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="menu-item" data-page="add-data">
                    <a href="#"><i class="fas fa-plus-circle"></i> Tambah Data Parkir</a>
                </li>
                <li class="menu-item" data-page="parking-list">
                    <a href="#"><i class="fas fa-list"></i> Daftar Kendaraan</a>
                </li>
                <li class="menu-item" data-page="class-report">
                    <a href="#"><i class="fas fa-chart-bar"></i> Laporan Per Kelas</a>
                </li>
                <li class="menu-item" data-page="daily-report">
                    <a href="#"><i class="fas fa-calendar-day"></i> Laporan Harian</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>SISTEM PENDATAAN PARKIR SEKOLAH</h1>
                </div>
            </header>

            <div class="content">
                <div id="dashboard-page" class="page active">
                    <div class="dashboard-cards">
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="card-content">
                                <h3>Total Kendaraan</h3>
                                <p class="card-number" id="totalKendaraan">0</p>
                            </div>
                        </div>
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div class="card-content">
                                <h3>Motor Parkir</h3>
                                <p class="card-number" id="totalMotor">0</p>
                            </div>
                        </div>
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <div class="card-content">
                                <h3>Mobil Parkir</h3>
                                <p class="card-number" id="totalMobil">0</p>
                            </div>
                        </div>
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-bicycle"></i>
                            </div>
                            <div class="card-content">
                                <h3>Sepeda Parkir</h3>
                                <p class="card-number" id="totalSepeda">0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-section">
                        <h2>Kendaraan Masuk Terbaru</h2>
                        <div class="table-wrapper">
                            <table id="recentTable">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis</th>
                                        <th>Jam Masuk</th>
                                    </tr>
                                </thead>
                                <tbody id="recentTableBody">
                                    <tr><td colspan="6" style="text-align: center;">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="recent-section">
                        <h2>Kendaraan Keluar Terbaru</h2>
                        <div class="table-wrapper">
                            <table id="recentExitTable">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis</th>
                                        <th>Jam Keluar</th>
                                    </tr>
                                </thead>
                                <tbody id="recentExitTableBody">
                                    <tr><td colspan="6" style="text-align: center;">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="add-data-page" class="page">
                    <div class="form-section">
                        <h2>Form Input Data Parkir</h2>
                        <form id="formParkir">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa:</label>
                                <input type="text" id="nama_siswa" name="nama_siswa" required>
                            </div>

                            <div class="form-group">
                                <label for="kelas">Kelas:</label>
                                <select id="kelas" name="kelas" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jurusan">Jurusan:</label>
                                <select id="jurusan" name="jurusan" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                    <option value="Kecantikan">Kecantikan</option>
                                    <option value="Tata Boga">Tata Boga</option>
                                    <option value="Seni Musik">Seni Musik</option>
                                    <option value="Usaha Layanan Wisata">Usaha Layanan Wisata</option>
                                    <option value="Busana">Busana</option>
                                    <option value="Perhotelan">Perhotelan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nomor_kendaraan">Nomor Kendaraan:</label>
                                <input type="text" id="nomor_kendaraan" name="nomor_kendaraan" placeholder="Contoh: B 1234 XYZ" required>
                            </div>

                            <div class="form-group">
                                <label for="jenis_kendaraan">Jenis Kendaraan:</label>
                                <select id="jenis_kendaraan" name="jenis_kendaraan" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Sepeda">Sepeda</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jam_masuk">Jam Masuk:</label>
                                <input type="datetime-local" id="jam_masuk" name="jam_masuk" required>
                            </div>

                            <div class="button-group">
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="parking-list-page" class="page">
                    <div class="table-section">
                        <div class="table-header">
                            <h2>Daftar Kendaraan Parkir</h2>
                            <div class="sort-controls">
                                <label>Urutkan:</label>
                                <button class="btn-sort" onclick="loadData('kelas')">Kelas</button>
                                <button class="btn-sort" onclick="loadData('jenis_kendaraan')">Jenis Kendaraan</button>
                                <button class="btn-sort" onclick="loadData('jam_masuk')">Jam Masuk</button>
                            </div>
                        </div>
                        
                        <div class="table-wrapper">
                            <table id="tableParkir">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr>
                                        <td colspan="9" style="text-align: center;">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="class-report-page" class="page">
                    <div class="report-section">
                        <div class="report-card">
                            <h2>Laporan Per Kelas</h2>
                            <button class="btn btn-info" id="btnLaporanKelas" onclick="toggleLaporanKelas()">Tampilkan Laporan</button>
                            <div id="laporanKelas" class="report-content"></div>
                        </div>
                    </div>
                </div>

                <div id="daily-report-page" class="page">
                    <div class="report-section">
                        <div class="report-card">
                            <h2>Laporan Harian</h2>
                            <div class="form-group">
                                <input type="date" id="tanggalLaporan" value="">
                                <button class="btn btn-info" id="btnLaporanHari" onclick="toggleLaporanHari()">Tampilkan Laporan</button>
                            </div>
                            <div id="laporanHari" class="report-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
