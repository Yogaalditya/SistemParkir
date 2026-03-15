<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Parkir</title>
    <meta http-equiv="refresh" content="30">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f3f4f6; }
        .wrap { max-width: 680px; margin: 30px auto; background: #fff; border-radius: 14px; box-shadow: 0 10px 32px rgba(0,0,0,0.08); padding: 22px; }
        .row { margin: 8px 0; font-size: 15px; }
        .label { font-weight: 700; color: #374151; }
        .status { display: inline-block; border-radius: 999px; padding: 6px 10px; font-size: 12px; }
        .paid { background: #d1fae5; color: #065f46; }
        .wait { background: #fef3c7; color: #92400e; }
        button { margin-top: 18px; width: 100%; border: 0; border-radius: 10px; padding: 11px; font-weight: 700; background: #ef4444; color: #fff; cursor: pointer; }
        .info { margin-top: 10px; font-size: 13px; color: #4b5563; }
        .flash { background: #dcfce7; color: #166534; border-radius: 8px; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="wrap">
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        <h2>Status Parkir Aktif</h2>
        <div class="row"><span class="label">Nama:</span> {{ $session->user->name }}</div>
        <div class="row"><span class="label">Kelas:</span> {{ $session->user->kelas }}</div>
        <div class="row"><span class="label">Jurusan:</span> {{ $session->user->jurusan }}</div>
        <div class="row"><span class="label">Nomor Kendaraan:</span> {{ $session->user->nomor_kendaraan }}</div>
        <div class="row"><span class="label">Metode Bayar:</span> {{ strtoupper($session->payment_method ?? '-') }}</div>

        <div class="row">
            <span class="label">Status Pembayaran:</span>
            @if ($session->payment_status === 'paid')
                <span class="status paid">Lunas</span>
            @else
                <span class="status wait">Menunggu Konfirmasi Admin</span>
            @endif
        </div>

        <div class="row"><span class="label">Durasi Parkir:</span> {{ floor($durationMinutes / 60) }} jam {{ $durationMinutes % 60 }} menit</div>
        <div class="row"><span class="label">Tagihan Saat Ini:</span> Rp {{ number_format($currentFee, 0, ',', '.') }}</div>
        <div class="info">Tarif awal Rp2.000. Tagihan bertambah setelah jam 16:30 selama belum checkout.</div>

        @if (!$session->checked_out_at)
            <form method="POST" action="{{ route('parking.checkout', ['session' => $session->public_token]) }}">
                @csrf
                <button type="submit">Keluar dari Parkir Sekolah</button>
            </form>
        @else
            <div class="info">Sesi parkir sudah selesai pada {{ $session->checked_out_at->format('d-m-Y H:i') }}.</div>
        @endif
    </div>
</body>
</html>
