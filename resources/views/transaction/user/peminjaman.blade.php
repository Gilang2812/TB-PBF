@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp< x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 text-gray-900 py-8">
                    <h1
                        class="text-center bg-gradient-to-r from-cyan-800 to-indigo-500 text-transparent bg-clip-text text-3xl font-serif font-bold pt-16 pb-8">
                        Konfirmasi Pinjaman</h1>
                    <p>Total item : {{ $transaksi->count() }} </p>

                    @foreach ($transaksi as $t)
                        <div class="flex items-center border-2 rounded-3xl  my-4">
                            <img class="mx-6  h-16 w-12 bg-slate-200 rounded-sm" src="" alt="gambar buku">
                            <p class="grow px-8">{{ $t->buku->judul_buku }}</p>
                            <div class="px-10 justify-center">
                                @switch($t->status)
                                    @case(0)
                                        <p class="bg-yellow-500 rounded-xl w-fit px-2 py-1 text-white">waiting</p>
                                    @break

                                    @case(1)
                                        <p class="bg-green-500 rounded-xl w-fit px-2 py-1 text-white">acc</p>
                                    @break

                                    @case(2)
                                        <p class="bg-blue-500 rounded-xl w-fit px-2 py-1 text-white">Returned</p>
                                    @break

                                    @default
                                        <p class="bg-gray-500 rounded-xl w-fit px-2 py-1 text-white">unknown</p>
                                @endswitch
                            </div>
                            <div>
                                <h1>Batas Pengembalian </h1>

                                <h1> {{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                </h1>

                            </div>
                            <div class="text-center">
                                <p>Tanggal Pinjam :</p>
                                <p class="grow px-8">
                                    {{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div class="flex h-16 rounded-3xl items-center justify-center">
                                <a class="h-full bg-yellow-500 text-white px-3 py-1 rounded-tl-3xl flex item-center pt-6 rounded-br-3xl"
                                    type="submit">
                                    <i class="fas fa-trash-alt  "></i>
                                </a>
                            </div>
                        </div>
                    @endforeach

                    @if ($transaksi->count() != 0)
                        <form action="{{ route('pinjaman.update', $transaksi?->first()?->nomor_peminjaman ?: '0') }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex justify-center">
                                <button type="submit" class="px-4 py-1 bg-yellow-500 text-white rounded-lg     ">Submit
                                    Peminjaman</button>
                            </div>
                    @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
    </x-app-layout>
