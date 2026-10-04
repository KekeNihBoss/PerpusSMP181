<x-filament-widgets::widget>
    <div class="fi-wi-widget-content">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-950 dark:text-white">Aksi Cepat</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Shortcut ke fitur yang sering digunakan</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($actions as $action)
                @if($action['visible'])
                    @php
                        $colorClasses = match ($action['color']) {
                            'success' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                            'warning' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                            'info' => 'bg-sky-100 text-sky-600 dark:bg-sky-900/30 dark:text-sky-400',
                            'danger' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                            'primary' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                            default => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                        };
                    @endphp

                    <a
                        href="{{ $action['url'] }}"
                        class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-900 dark:hover:border-primary-600"
                    >
                        <div class="flex items-start justify-between">
                            <div class="rounded-lg {{ $colorClasses }} p-2.5">
                                <x-dynamic-component :component="$action['icon']" class="h-6 w-6" />
                            </div>
                            <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 text-gray-400 opacity-0 transition group-hover:opacity-100" />
                        </div>
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $action['label'] }}</h4>
                            <p class="mt-1 text-xs leading-relaxed text-gray-500 dark:text-gray-400">{{ $action['description'] }}</p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
