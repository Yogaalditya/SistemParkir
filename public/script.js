const API_URL = '/api/parkir';
let allData = [];
let laporanKelasVisible = false;
let laporanHariVisible = false;

function getLocalDateTime() {
    const now = new Date();
    const offset = now.getTimezoneOffset();
    const adjustedDate = new Date(now.getTime() - offset * 60000);
    return adjustedDate.toISOString().slice(0, 16);
}

function setDefaultDateTime() {
    document.getElementById('jam_masuk').value = getLocalDateTime();
}

document.addEventListener('DOMContentLoaded', function() {
    setDefaultDateTime();
    document.getElementById('tanggalLaporan').value = new Date().toISOString().slice(0, 10);
    
    loadData();
    loadDashboardData();
    setupNavigation();
    
    document.getElementById('formParkir').addEventListener('submit', function(e) {
        e.preventDefault();
        tambahData();
    });
});

function setupNavigation() {
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            menuItems.forEach(mi => mi.classList.remove('active'));
            this.classList.add('active');
            
            const targetPage = this.getAttribute('data-page');
            showPage(targetPage);
        });
    });
}

function showPage(pageName) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active'));
    
    const targetPage = document.getElementById(pageName + '-page');
    if (targetPage) {
        targetPage.classList.add('active');
        
        if (pageName === 'parking-list') {
            loadData();
        } else if (pageName === 'dashboard') {
            loadDashboardData();
        }
    }
}

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

function loadDashboardData() {
    fetch(API_URL)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                allData = result.data;
                updateDashboardStats();
                displayRecentData();
                displayRecentExitData();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function updateDashboardStats() {
    const parkingVehicles = allData.filter(item => !item.jam_keluar);
    
    const totalKendaraan = parkingVehicles.length;
    const totalMotor = parkingVehicles.filter(item => item.jenis_kendaraan === 'Motor').length;
    const totalMobil = parkingVehicles.filter(item => item.jenis_kendaraan === 'Mobil').length;
    const totalSepeda = parkingVehicles.filter(item => item.jenis_kendaraan === 'Sepeda').length;
    
    document.getElementById('totalKendaraan').textContent = totalKendaraan;
    document.getElementById('totalMotor').textContent = totalMotor;
    document.getElementById('totalMobil').textContent = totalMobil;
    document.getElementById('totalSepeda').textContent = totalSepeda;
}

function displayRecentData() {
    const recentData = allData
        .filter(item => !item.jam_keluar)
        .sort((a, b) => new Date(b.jam_masuk) - new Date(a.jam_masuk))
        .slice(0, 5);
    
    const tbody = document.getElementById('recentTableBody');
    
    if (recentData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada data kendaraan masuk terbaru</td></tr>';
        return;
    }
    
    let html = '';
    recentData.forEach(item => {
        const jamMasuk = new Date(item.jam_masuk).toLocaleString('id-ID');
        html += `
            <tr>
                <td>${item.nama_siswa}</td>
                <td>${item.kelas}</td>
                <td>${item.nomor_kendaraan}</td>
                <td>${item.jenis_kendaraan}</td>
                <td>${jamMasuk}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function displayRecentExitData() {
    const recentExitData = allData
        .filter(item => item.jam_keluar)
        .sort((a, b) => new Date(b.jam_keluar) - new Date(a.jam_keluar))
        .slice(0, 5);
    
    const tbody = document.getElementById('recentExitTableBody');
    
    if (recentExitData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada data kendaraan keluar terbaru</td></tr>';
        return;
    }
    
    let html = '';
    recentExitData.forEach(item => {
        const jamKeluar = new Date(item.jam_keluar).toLocaleString('id-ID');
        html += `
            <tr>
                <td>${item.nama_siswa}</td>
                <td>${item.kelas}</td>
                <td>${item.nomor_kendaraan}</td>
                <td>${item.jenis_kendaraan}</td>
                <td>${jamKeluar}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function loadData(orderBy = 'jam_masuk') {
    const url = orderBy ? `${API_URL}?orderBy=${orderBy}` : API_URL;
    
    fetch(url)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                displayData(result.data);
            } else {
                alert('Gagal memuat data: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data');
        });
}

function displayData(data) {
    const tbody = document.getElementById('tableBody');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">Tidak ada data parkir</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach((item, index) => {
        const jamMasuk = new Date(item.jam_masuk).toLocaleString('id-ID');
        const jamKeluar = item.jam_keluar ? new Date(item.jam_keluar).toLocaleString('id-ID') : '-';
        
        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.nama_siswa}</td>
                <td>${item.kelas}</td>
                <td>${item.jurusan}</td>
                <td>${item.nomor_kendaraan}</td>
                <td>${item.jenis_kendaraan}</td>
                <td>${jamMasuk}</td>
                <td>${jamKeluar}</td>
                <td>
                    ${!item.jam_keluar ? 
                        `<button class="btn-action btn-keluar" onclick="updateStatus(${item.id})">Keluar</button>` : 
                        ''}
                    <button class="btn-action btn-hapus" onclick="hapusData(${item.id})">Hapus</button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function tambahData() {
    const formData = {
        nama_siswa: document.getElementById('nama_siswa').value.trim(),
        kelas: document.getElementById('kelas').value.trim(),
        jurusan: document.getElementById('jurusan').value,
        nomor_kendaraan: document.getElementById('nomor_kendaraan').value.trim(),
        jenis_kendaraan: document.getElementById('jenis_kendaraan').value,
        jam_masuk: document.getElementById('jam_masuk').value
    };
    
    fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Data parkir berhasil ditambahkan!');
            document.getElementById('formParkir').reset();
            setDefaultDateTime();
            
            loadData();
            loadDashboardData();
            
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(mi => mi.classList.remove('active'));
            document.querySelector('.menu-item[data-page="dashboard"]').classList.add('active');
            showPage('dashboard');
        } else {
            alert('Gagal menambahkan data: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan data');
    });
}

function updateStatus(id) {
    if (!confirm('Keluar dari parkir?')) return;
    
    fetch(API_URL, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Kendaraan berhasil keluar!');
            loadData();
            loadDashboardData();
        } else {
            alert('Gagal mengubah status: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
    });
}

function hapusData(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
    
    fetch(API_URL, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Data berhasil dihapus!');
            loadData();
            loadDashboardData();
        } else {
            alert('Gagal menghapus data: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus data');
    });
}

function toggleLaporanKelas() {
    const btn = document.getElementById('btnLaporanKelas');
    const container = document.getElementById('laporanKelas');
    
    if (laporanKelasVisible) {
        container.innerHTML = '';
        btn.textContent = 'Tampilkan Laporan';
        laporanKelasVisible = false;
    } else {
        loadLaporanKelas();
        btn.textContent = 'Sembunyikan Laporan';
        laporanKelasVisible = true;
    }
}

function loadLaporanKelas() {
    fetch(`${API_URL}?action=laporan_kelas`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                let html = '<table class="report-table">';
                html += '<tr><th>Kelas</th><th>Jumlah Kendaraan</th></tr>';
                
                if (result.data.length === 0) {
                    html += '<tr><td colspan="2" style="text-align: center;">Tidak ada data</td></tr>';
                } else {
                    result.data.forEach(item => {
                        html += `<tr><td>${item.kelas}</td><td>${item.jumlah}</td></tr>`;
                    });
                }
                
                html += '</table>';
                document.getElementById('laporanKelas').innerHTML = html;
            } else {
                alert('Gagal memuat laporan: ' + result.message);
                laporanKelasVisible = false;
                document.getElementById('btnLaporanKelas').textContent = 'Tampilkan Laporan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat laporan');
            laporanKelasVisible = false;
            document.getElementById('btnLaporanKelas').textContent = 'Tampilkan Laporan';
        });
}

function toggleLaporanHari() {
    const btn = document.getElementById('btnLaporanHari');
    const container = document.getElementById('laporanHari');
    
    if (laporanHariVisible) {
        container.innerHTML = '';
        btn.textContent = 'Tampilkan Laporan';
        laporanHariVisible = false;
    } else {
        loadLaporanHari();
        btn.textContent = 'Sembunyikan Laporan';
        laporanHariVisible = true;
    }
}

function loadLaporanHari() {
    const tanggal = document.getElementById('tanggalLaporan').value;
    
    fetch(`${API_URL}?action=laporan_hari&tanggal=${tanggal}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                let html = '<table class="report-table">';
                html += `<tr><th colspan="2">Tanggal: ${new Date(result.tanggal).toLocaleDateString('id-ID')}</th></tr>`;
                html += '<tr><th>Jenis Kendaraan</th><th>Jumlah</th></tr>';
                
                if (result.data.length === 0) {
                    html += '<tr><td colspan="2" style="text-align: center;">Tidak ada data</td></tr>';
                } else {
                    let total = 0;
                    result.data.forEach(item => {
                        html += `<tr><td>${item.jenis_kendaraan}</td><td>${item.jumlah}</td></tr>`;
                        total += parseInt(item.jumlah);
                    });
                    html += `<tr><th>Total</th><th>${total}</th></tr>`;
                }
                
                html += '</table>';
                document.getElementById('laporanHari').innerHTML = html;
            } else {
                alert('Gagal memuat laporan: ' + result.message);
                laporanHariVisible = false;
                document.getElementById('btnLaporanHari').textContent = 'Tampilkan Laporan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat laporan');
            laporanHariVisible = false;
            document.getElementById('btnLaporanHari').textContent = 'Tampilkan Laporan';
        });
}
