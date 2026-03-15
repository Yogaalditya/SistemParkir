<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Parkir Sekolah</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f5f7fb; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; background: #0f766e; color: #fff; }
        .container { max-width: 980px; margin: 20px auto; display: grid; gap: 16px; grid-template-columns: 1fr 1fr; }
        .card { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .row { margin-bottom: 8px; font-size: 14px; }
        .label { font-weight: 700; color: #374151; }
        .qr { text-align: center; }
        button { padding: 8px 14px; border: 0; border-radius: 8px; cursor: pointer; }
        .logout { background: #f97316; color: #fff; }
        .status { display: inline-block; margin-top: 8px; padding: 7px 10px; border-radius: 999px; font-size: 12px; }
        .s1 { background: #fef3c7; color: #92400e; }
        .s2 { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <div>Halo, {{ $user->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="card">
            <h2>Data User Parkir</h2>
            <div class="row"><span class="label">Nama:</span> {{ $user->name }}</div>
            <div class="row"><span class="label">Kelas:</span> {{ $user->kelas }}</div>
            <div class="row"><span class="label">Jurusan:</span> {{ $user->jurusan }}</div>
            <div class="row"><span class="label">Nomor Kendaraan:</span> {{ $user->nomor_kendaraan }}</div>
            <div class="row"><span class="label">Jenis Kendaraan:</span> {{ $user->jenis_kendaraan }}</div>
            @if ($activeSession)
                <div class="status s1">Sedang parkir (scan sudah dilakukan)</div>
            @endif
        </div>

        <div class="card qr">
            <h2>QR Code Masuk Parkir</h2>
            <div>{!! QrCode::size(220)->generate(route('parking.scan', ['token' => $user->qr_token])) !!}</div>
            <p>Scan QR ini di pintu masuk agar data otomatis tampil.</p>
            <p><a href="{{ route('parking.scan', ['token' => $user->qr_token]) }}" target="_blank">Buka link scan</a></p>
        </div>
    </div>
</body>
</html>
