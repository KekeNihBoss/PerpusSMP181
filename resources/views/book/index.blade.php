@extends('layouts.app')

@section('content')
<section class="py-10">
    <div class="container mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Daftar Buku</h1>

            <div class="flex gap-3">
                {{-- TOGGLE VIEW --}}
                <a href="?view=grid" class="px-3 py-1 rounded 
                    {{ $view=='grid' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Grid</a>

                <a href="?view=list" class="px-3 py-1 rounded 
                    {{ $view=='list' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">List</a>
            </div>
        </div>

        {{-- FILTER + SEARCH --}}
        <form method="GET" class="flex gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari judul..."
                class="border rounded px-3 py-2 w-1/2">

            <select name="kategori" class="border rounded px-3 py-2">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}" 
                        {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>

            <button class="bg-blue-600 text-white px-4 rounded">Filter</button>
        </form>

        {{-- GRID VIEW --}}
        @if ($view == 'grid')
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($buku as $item)
                    <a href="{{ route('buku.show', $item->id) }}" 
                        class="bg-white shadow rounded p-3 hover:shadow-lg transition">

                        @if($item->cover)
                            <img src="{{ Storage::url($item->cover) }}" 
                                 class="w-full h-40 object-cover rounded mb-3">
                        @endif

                        <h3 class="font-semibold">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600">{{ $item->kategori }}</p>
                        <p class="text-xs text-gray-500">Rak: {{ $item->nomorrak }}</p>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- LIST VIEW --}}
        @if ($view == 'list')
            <div class="bg-white shadow rounded divide-y">
                @foreach ($buku as $item)
                    <a href="{{ route('buku.show', $item->id) }}" 
                       class="flex items-center gap-4 p-4 hover:bg-gray-50 transition">

                        @if($item->cover)
                            <img src="{{ Storage::url($item->cover) }}"
                                class="w-16 h-20 object-cover rounded">
                        @endif

                        <div>
                            <h3 class="font-semibold">{{ $item->judul }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->kategori }}</p>
                            <p class="text-xs text-gray-500">Rak: {{ $item->nomorrak }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            {{ $buku->links() }}
        </div>

    </div>
</section>
@endsection
