<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Admin Dashboard - Parkir Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-b from-zinc-50 via-cyan-50/30 to-sky-50 text-zinc-900">
    <div x-data="{ sidebarOpen: false, sidebarMinimized: false }" class="relative min-h-screen">
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-zinc-900/40 md:hidden" @click="sidebarOpen = false"></div>

        <aside
            class="fixed left-0 top-0 z-40 h-full border-r border-zinc-200 bg-white/95 shadow-xl backdrop-blur md:shadow-none"
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                sidebarMinimized ? 'md:w-20' : 'md:w-72',
                'w-72 transform transition-all duration-300 ease-out md:translate-x-0'
            ]"
        >
            <div class="flex h-full flex-col p-4">
                <div class="flex items-center justify-between">
                    <div x-show="!sidebarMinimized" class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-700">Admin Parkir</div>
                    <button @click="sidebarMinimized = !sidebarMinimized" class="hidden rounded-xl border border-zinc-200 p-2 text-zinc-500 transition hover:bg-zinc-100 md:inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                </div>

                <nav class="mt-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-sky-600 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12 12 4.5 20.25 12M5.25 10.5V19.5h13.5v-9" />
                        </svg>
                        <span x-show="!sidebarMinimized">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.qr-code') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.qr-code') ? 'bg-sky-600 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.25 2.25 0 0 1 5.25 5.25h2.25A2.25 2.25 0 0 1 9.75 7.5v2.25A2.25 2.25 0 0 1 7.5 12H5.25A2.25 2.25 0 0 1 3 9.75V7.5Zm0 9A2.25 2.25 0 0 1 5.25 14.25h2.25a2.25 2.25 0 0 1 2.25 2.25v2.25A2.25 2.25 0 0 1 7.5 21H5.25A2.25 2.25 0 0 1 3 18.75V16.5Zm11.25-9A2.25 2.25 0 0 1 16.5 5.25h2.25A2.25 2.25 0 0 1 21 7.5v2.25A2.25 2.25 0 0 1 18.75 12H16.5a2.25 2.25 0 0 1-2.25-2.25V7.5Zm3 8.25h.008v.008H17.25v-.008Zm-3 0h.008v.008H14.25v-.008Zm0 3h.008v.008H14.25v-.008Zm3 0h.008v.008H17.25v-.008Zm3-3h.008v.008H20.25v-.008Zm0 3h.008v.008H20.25v-.008Z" />
                        </svg>
                        <span x-show="!sidebarMinimized">QR Code</span>
                    </a>
                </nav>

                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl border border-orange-200 bg-orange-50 px-3 py-2.5 text-sm font-semibold text-orange-700 transition hover:bg-orange-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-7.5A2.25 2.25 0 0 0 3.75 5.25v13.5A2.25 2.25 0 0 0 6 21h7.5a2.25 2.25 0 0 0 2.25-2.25V15m-3 0 3-3m0 0 3 3m-3-3H9" />
                        </svg>
                        <span x-show="!sidebarMinimized">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="min-h-screen transition-all duration-300 md:pl-72" :class="sidebarMinimized ? 'md:pl-20' : 'md:pl-72'">
            <div class="mx-auto w-full max-w-md px-4 pb-24 pt-5 md:max-w-6xl md:px-8">
                <header class="mb-5 flex items-start justify-between gap-4 rounded-2xl border border-zinc-200 bg-white/85 p-4 shadow-sm backdrop-blur">
                    <div class="flex items-start gap-3">
                        <button @click="sidebarOpen = true" class="rounded-xl border border-zinc-200 p-2 text-zinc-700 transition hover:bg-zinc-100 md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">Dashboard Admin</p>
                            <h1 class="mt-1 text-xl font-bold text-zinc-900 md:text-2xl">Kelola Parkir Sekolah</h1>
                        </div>
                    </div>
                </header>

                @if (session('status'))
                    <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <section class="mb-4 rounded-2xl border border-zinc-200 bg-white/90 p-4 shadow-sm">
                    <h2 class="text-base font-semibold text-zinc-900">Konfirmasi Pembayaran Cash</h2>
                    <div class="mt-3 overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-zinc-200 text-zinc-500">
                                    <th class="px-3 py-2 font-medium">Nama</th>
                                    <th class="px-3 py-2 font-medium">Kelas</th>
                                    <th class="px-3 py-2 font-medium">No Kendaraan</th>
                                    <th class="px-3 py-2 font-medium">Jam Masuk</th>
                                    <th class="px-3 py-2 font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingCashSessions as $item)
                                    <tr class="border-b border-zinc-100">
                                        <td class="px-3 py-2">{{ $item->user->name }}</td>
                                        <td class="px-3 py-2">{{ $item->user->kelas }}</td>
                                        <td class="px-3 py-2">{{ $item->user->nomor_kendaraan }}</td>
                                        <td class="px-3 py-2">{{ $item->checked_in_at->format('d-m-Y H:i') }}</td>
                                        <td class="px-3 py-2">
                                            <form method="POST" action="{{ route('admin.confirm-cash', ['session' => $item->id]) }}">
                                                @csrf
                                                <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Konfirmasi</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-3 py-3 text-zinc-500">Tidak ada pembayaran cash menunggu konfirmasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-2xl border border-zinc-200 bg-white/90 p-4 shadow-sm">
                    <h2 class="text-base font-semibold text-zinc-900">Monitoring Parkir Aktif</h2>
                    <div class="mt-3 overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-zinc-200 text-zinc-500">
                                    <th class="px-3 py-2 font-medium">Nama</th>
                                    <th class="px-3 py-2 font-medium">Metode</th>
                                    <th class="px-3 py-2 font-medium">Status</th>
                                    <th class="px-3 py-2 font-medium">Jam Masuk</th>
                                    <th class="px-3 py-2 font-medium">Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activeSessions as $item)
                                    <tr class="border-b border-zinc-100">
                                        <td class="px-3 py-2">{{ $item->user->name }}</td>
                                        <td class="px-3 py-2">{{ strtoupper($item->payment_method ?? '-') }}</td>
                                        <td class="px-3 py-2">{{ $item->payment_status }}</td>
                                        <td class="px-3 py-2">{{ $item->checked_in_at->format('d-m-Y H:i') }}</td>
                                        <td class="px-3 py-2">Rp {{ number_format($item->currentFee(), 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-3 py-3 text-zinc-500">Belum ada sesi parkir aktif.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
