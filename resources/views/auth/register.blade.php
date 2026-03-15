<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Parkir Sekolah</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f5f7fb; }
        .wrap { max-width: 540px; margin: 40px auto; background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 12px 36px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; font-size: 24px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        label { display: block; margin: 6px 0 6px; font-size: 14px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #d2d6dc; border-radius: 8px; box-sizing: border-box; }
        .full { grid-column: 1 / -1; }
        button { width: 100%; margin-top: 18px; padding: 11px; border: 0; border-radius: 8px; background: #0f766e; color: #fff; font-weight: 600; cursor: pointer; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-size: 14px; }
        .link { margin-top: 14px; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Daftar Akun User Parkir</h1>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.process') }}">
            @csrf
            <div class="grid">
                <div>
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                </div>
                <div>
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label>Kelas</label>
                    <select name="kelas" required>
                        <option value="">Pilih</option>
                        <option value="X" @selected(old('kelas') === 'X')>X</option>
                        <option value="XI" @selected(old('kelas') === 'XI')>XI</option>
                        <option value="XII" @selected(old('kelas') === 'XII')>XII</option>
                    </select>
                </div>
                <div>
                    <label>Jurusan</label>
                    <select name="jurusan" required>
                        <option value="">Pilih</option>
                        <option value="Rekayasa Perangkat Lunak" @selected(old('jurusan') === 'Rekayasa Perangkat Lunak')>Rekayasa Perangkat Lunak</option>
                        <option value="Kecantikan" @selected(old('jurusan') === 'Kecantikan')>Kecantikan</option>
                        <option value="Tata Boga" @selected(old('jurusan') === 'Tata Boga')>Tata Boga</option>
                        <option value="Seni Musik" @selected(old('jurusan') === 'Seni Musik')>Seni Musik</option>
                        <option value="Usaha Layanan Wisata" @selected(old('jurusan') === 'Usaha Layanan Wisata')>Usaha Layanan Wisata</option>
                        <option value="Busana" @selected(old('jurusan') === 'Busana')>Busana</option>
                        <option value="Perhotelan" @selected(old('jurusan') === 'Perhotelan')>Perhotelan</option>
                    </select>
                </div>
                <div>
                    <label>Nomor Kendaraan</label>
                    <input type="text" name="nomor_kendaraan" value="{{ old('nomor_kendaraan') }}" required>
                </div>
                <div>
                    <label>Jenis Kendaraan</label>
                    <select name="jenis_kendaraan" required>
                        <option value="">Pilih</option>
                        <option value="Motor" @selected(old('jenis_kendaraan') === 'Motor')>Motor</option>
                        <option value="Mobil" @selected(old('jenis_kendaraan') === 'Mobil')>Mobil</option>
                        <option value="Sepeda" @selected(old('jenis_kendaraan') === 'Sepeda')>Sepeda</option>
                    </select>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>
