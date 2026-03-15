@props([
    'step',
    'title',
    'description',
    'icon' => 'camera',
])

<div class="rounded-2xl border border-zinc-200 bg-white/90 p-4 shadow-sm">
    <div class="flex items-start gap-3">
        <div class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-700">
            @if ($icon === 'camera')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 0v8.25A2.25 2.25 0 0 0 6 19.5h12a2.25 2.25 0 0 0 2.25-2.25V9m-16.5 0 1.072-2.143A2.25 2.25 0 0 1 6.836 5.5h10.328a2.25 2.25 0 0 1 2.014 1.357L20.25 9M12 13.5h.008v.008H12V13.5Z" />
                </svg>
            @elseif ($icon === 'check-circle')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 1.664-1.343 3-3 3H6a3 3 0 1 1 0-6h12c1.657 0 3 1.336 3 3Zm0 0v4.125A2.625 2.625 0 0 1 18.375 18.75H5.625A2.625 2.625 0 0 1 3 16.125V12m18 0V7.875A2.625 2.625 0 0 0 18.375 5.25H5.625A2.625 2.625 0 0 0 3 7.875V12m12 0h.008v.008H15V12Z" />
                </svg>
            @endif
        </div>

        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">{{ $step }}</p>
            <h3 class="mt-1 text-base font-semibold text-zinc-900">{{ $title }}</h3>
            <p class="mt-1 text-sm leading-relaxed text-zinc-600">{{ $description }}</p>
        </div>
    </div>
</div>
