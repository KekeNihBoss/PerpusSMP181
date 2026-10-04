<x-filament-widgets::widget>
    <div class="fi-wi-stats-overview-stats-ctn gap-6">
        <div class="rounded-2xl bg-gradient-to-r from-primary-600 to-primary-500 p-6 text-white shadow-lg dark:from-primary-700 dark:to-primary-600">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">
                        {{ $this->getGreeting() }}, {{ auth()->user()->name ?? 'Admin' }}
                    </h2>
                    <p class="mt-1 text-primary-100">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:text-right">
                    <p class="text-sm font-medium text-primary-100">Quote Hari Ini</p>
                    <p class="text-lg font-semibold">
                        "{{ $this->getQuotes()[array_rand($this->getQuotes())] }}"
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
