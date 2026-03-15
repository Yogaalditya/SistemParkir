<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Parkir Sekolah</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f4f5f7; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; background: #1f2937; color: #fff; }
        .container { max-width: 1100px; margin: 24px auto; display: grid; gap: 18px; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); padding: 18px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        th { background: #f9fafb; }
        button { border: 0; border-radius: 8px; padding: 8px 12px; cursor: pointer; }
        .ok { background: #0f766e; color: #fff; }
        .logout { background: #f97316; color: #fff; }
        .flash { background: #dcfce7; color: #166534; border-radius: 8px; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div>Dashboard Admin Parkir Sekolah</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="card">
            <h2>Konfirmasi Pembayaran Cash</h2>
            @if (session('status'))
                <div class="flash">{{ session('status') }}</div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>No Kendaraan</th>
                        <th>Jam Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingCashSessions as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->kelas }}</td>
                            <td>{{ $item->user->nomor_kendaraan }}</td>
                            <td>{{ $item->checked_in_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.confirm-cash', ['session' => $item->id]) }}">
                                    @csrf
                                    <button type="submit" class="ok">Konfirmasi</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Tidak ada pembayaran cash menunggu konfirmasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Monitoring Parkir Aktif</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Jam Masuk</th>
                        <th>Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activeSessions as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ strtoupper($item->payment_method ?? '-') }}</td>
                            <td>{{ $item->payment_status }}</td>
                            <td>{{ $item->checked_in_at->format('d-m-Y H:i') }}</td>
                            <td>Rp {{ number_format($item->currentFee(), 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada sesi parkir aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
