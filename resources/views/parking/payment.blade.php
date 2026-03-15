<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Parkir</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f3f4f6; }
        .wrap { max-width: 620px; margin: 30px auto; background: #fff; border-radius: 14px; box-shadow: 0 10px 32px rgba(0,0,0,0.08); padding: 22px; }
        .row { margin: 8px 0; font-size: 15px; }
        .label { font-weight: 700; color: #374151; }
        .methods { display: grid; gap: 8px; margin-top: 14px; }
        label.method { border: 1px solid #e5e7eb; border-radius: 10px; padding: 10px; display: flex; align-items: center; gap: 8px; }
        button { margin-top: 16px; width: 100%; border: 0; border-radius: 10px; padding: 11px; font-weight: 700; background: #0f766e; color: #fff; cursor: pointer; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2>Data Siswa Terverifikasi</h2>
        <div class="row"><span class="label">Nama:</span> {{ $user->name }}</div>
        <div class="row"><span class="label">Kelas:</span> {{ $user->kelas }}</div>
        <div class="row"><span class="label">Jurusan:</span> {{ $user->jurusan }}</div>
        <div class="row"><span class="label">Nomor Kendaraan:</span> {{ $user->nomor_kendaraan }}</div>
        <div class="row"><span class="label">Jenis Kendaraan:</span> {{ $user->jenis_kendaraan }}</div>
        <div class="row"><span class="label">Biaya Awal:</span> Rp 2.000</div>

        <form method="POST" action="{{ route('parking.pay', ['token' => $user->qr_token]) }}">
            @csrf
            <div class="methods">
                <label class="method"><input type="radio" name="payment_method" value="dana" required> DANA</label>
                <label class="method"><input type="radio" name="payment_method" value="ovo" required> OVO</label>
                <label class="method"><input type="radio" name="payment_method" value="gopay" required> GoPay</label>
                <label class="method"><input type="radio" name="payment_method" value="shopeepay" required> ShopeePay</label>
                <label class="method"><input type="radio" name="payment_method" value="cash" required> Cash (wajib konfirmasi admin)</label>
            </div>

            <button type="submit">Lanjutkan Pembayaran</button>
        </form>
    </div>
</body>
</html>
