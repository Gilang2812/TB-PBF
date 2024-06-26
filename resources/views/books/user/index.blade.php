<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#FAFBFC]/30 border border-white backdrop-blur-md overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 px-64">
                    <div class="container py-20 space-y-14">
                        <div class="border-2 border-white rounded-lg">
                            <form action="{{ route('book.userIndex') }}" method="GET">
                                <div class="flex justify-between -center rounded-lg w-full bg-[#7c68ee1f]/10 border-none shadow-[0_4px_4px_0px_rgba(0,0,0,0.25)]">
                                    <input
                                        class="border-none bg-transparent w-full h-full p-4  text-white rounded-lg focus:outline-none focus:border-none focus:ring-2 focus:ring-none placeholder:text-white"
                                        type="text" name="search" id="search" placeholder="search" value="{{ request('search') }}">
                                    <button type="submit" class="px-4 text-white">
                                      <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        @if ($book->count() === 0)
                            <p class="text-center">Belum ada buku tersedia</p>
                        @endif
                        @foreach ($book as $buku)
                            <div class="bg-white shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] rounded-lg  p-3 flex space-x-6">
                                <div class="w-44 px-3">
                                    <img src="{{ asset('storage/' . $buku->image) }}" class="size-16"
                                    alt="gambar buku">
                                </div>
                                <div class="w-full space-y-3">
                                    <h1 class="text-2xl">{{ $buku->judul_buku }}</h1>
                                    <h1 class="px-3 py-1 border w-fit rounded-2xl border-slate-300">{{ ucwords($buku->pengarang) }}</h1>
                                    <div class="flex">
                                        <div class="px-4">
                                            <h1>Penerbit</h1>
                                            <h1>Pengarang</h1>
                                        </div>
                                        <div class="px-4">
                                            <h1>: {{ ucwords($buku->penerbit?->nama) }}</h1>
                                            <h1>: {{ ucwords($buku->pengarang) }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="border border-slate-300 mb-2 p-2 px-8 rounded-md">
                                        <h1>ketersediaan</h1>
                                        <h1 class="text-3xl"><strong>{{ $buku->ketersediaan ?: 0 }}</strong></h1>
                                    </div>
                                    <a class="text-blue-500" href="{{ route('book.edit', $buku->nomor_buku) }}">
                                        <div class="py-2 px-8 border rounded-md border-blue-500">
                                            Tampilkan Detail
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
