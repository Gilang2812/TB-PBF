@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/40 backdrop-blur-sm border border-white shadow-inner- overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 text-gray-900 py-8">
                    <h1
                        class="text-center bg-gradient-to-r from-cyan-800 to-indigo-500 text-transparent bg-clip-text text-3xl font-serif font-bold pt-16 pb-8">
                        Konfirmasi Pinjaman
                    </h1>
                    <p>Total item : {{ $transaksi->count() }} </p>

                    @foreach ($transaksi as $t)
                        <div
                            class="flex items-center text-sm justfy-center  border-2 shadow-[0_2px_6px_-1px_rgba(0,0,0,0.3)] border-none mb-6  bg-white rounded-l-3xl rounded-br-[30px] ">
                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-md" src="" alt="gambar buku">
                            <p class="grow px-8">{{ $t->buku->judul_buku }}</p> 
                            <div class="px-10 ">
                                @switch($t->status)
                                @case(0)
                                    <p
                                        class="bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Pending</p>
                                @break

                                @case(1)
                                    <p
                                        class="bg-gradient-to-r from-green-400 to-green-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Accepted</p>
                                @break

                                @case(2)
                                    <p
                                        class="bg-gradient-to-r from-red-400 to-red-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Rejected</p>
                                @break

                                @case(3)
                                    <p
                                        class="bg-gradient-to-r from-orange-400 to-orange-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Payment Required</p>
                                @break

                                @case(4)
                                    <p
                                        class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Complete</p>
                                @break

                                @default
                                    <p
                                        class="bg-gradient-to-r from-gray-400 to-gray-600 rounded-xl w-fit px-2 py-1 text-white">
                                        Unknown</p>
                            @endswitch
                            </div>
                            <div>
                                <h1>Batas Pengembalian</h1>
                                <h1>{{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                </h1>
                            </div>
                            <div class="text-center">
                                <p>Tanggal Pinjam :</p>
                                <p class="grow px-8">
                                    {{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <form class="flex h-16  items-center justify-center"
                                action="{{ route('pinjaman.cancel.user', ['nomor_buku' => $t->nomor_buku, 'nomor_peminjaman' => $t->nomor_peminjaman]) }}"
                                method="POST" onsubmit="return validateAction()">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="h-full bg-gradient-to-br from-indigo-500 to-cyan-300 text-white hover:from-cyan-500 hover:to-indigo-300 transition ease-out duration-500 px-3 py-1 rounded-tl-3xl flex items-center rounded-br-3xl"
                                    type="submit">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach

                    @if ($transaksi->count() != 0)
                        <form action="{{ route('pinjaman.update', $transaksi?->first()?->nomor_peminjaman ?: '0') }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="px-4 py-1 shadow-sm shadow-blue-400 bg-gradient-to-br from-indigo-500 to-cyan-300 hover:from-cyan-500 hover:to-indigo-300 transition ease-out duration-500 text-white rounded-lg">Submit
                                    Peminjaman</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
