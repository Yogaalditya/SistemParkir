<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Parkir Sekolah</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f5f7fb; }
        .wrap { max-width: 420px; margin: 80px auto; background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 12px 36px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; font-size: 24px; }
        label { display: block; margin: 12px 0 6px; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #d2d6dc; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; margin-top: 18px; padding: 11px; border: 0; border-radius: 8px; background: #0f766e; color: #fff; font-weight: 600; cursor: pointer; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-size: 14px; }
        .link { margin-top: 14px; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Login Parkir Sekolah</h1>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>

        <div class="link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar user baru</a>
        </div>
    </div>
</body>
</html>
