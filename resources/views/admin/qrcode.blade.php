<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>QR Code Admin - Parkir Sekolah</title>
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
            <div class="mx-auto w-full max-w-md px-4 pb-10 pt-5 md:max-w-4xl md:px-8">
                <header class="mb-5 flex items-start justify-between gap-4 rounded-2xl border border-zinc-200 bg-white/85 p-4 shadow-sm backdrop-blur">
                    <div class="flex items-start gap-3">
                        <button @click="sidebarOpen = true" class="rounded-xl border border-zinc-200 p-2 text-zinc-700 transition hover:bg-zinc-100 md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">QR Code Admin</p>
                            <h1 class="mt-1 text-xl font-bold text-zinc-900 md:text-2xl">Scan untuk Bayar Parkir</h1>
                        </div>
                    </div>
                </header>

                <section class="rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm">
                    <p class="text-sm text-zinc-600">Tampilkan QR ini di pos parkir. User scan QR ini dari HP mereka untuk langsung masuk ke halaman pembayaran parkir.</p>

                    <div class="mt-6 flex justify-center">
                        <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm">
                            {!! QrCode::size(260)->generate(route('parking.scan-user')) !!}
                        </div>
                    </div>

                    <div class="mt-5 rounded-xl border border-zinc-200 bg-zinc-50 p-3 text-xs text-zinc-600">
                        Link scan: {{ route('parking.scan-user') }}
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
