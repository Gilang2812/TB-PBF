@php
    \Carbon\Carbon::setLocale('id');
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recap') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white/40 text-sm backdrop-blur-md border border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-16 text-black h-full">
                    <h1 class="text-center bg-gradient-to-br from-cyan-500 to-indigo-700 text-transparent bg-clip-text text-5xl font-mono font-extrabold pb-8">
                        Recap
                    </h1>
                    @foreach ($transaksi->unique('nomor_peminjaman') as $t)
                        @php
                            $transaksiPeminjaman = $transaksi->where('nomor_peminjaman', $t->nomor_peminjaman);
                            $totalBooks = $transaksiPeminjaman->count();
                            $returnedBooks = $transaksiPeminjaman->where('status', 3)->count(); // Assuming status 2 means returned
                            $returnedPercentage = $totalBooks ? ($returnedBooks / $totalBooks) * 100 : 0;
                            $durasi = 3; // Durasi peminjaman dalam hari
                            $tanggalPeminjaman = Carbon::parse($t->peminjaman?->tanggal_peminjaman);
                            $deadlinePengembalian = $tanggalPeminjaman->copy()->addDays($durasi);
                        @endphp

                        <div x-data="{
                            open: false, 
                            height: 0, 
                            contentHeight: 0, 
                            delay: 0, 
                            bg: '',
                            rotate: '',
                            pd: '',
                            handleClick() {
                                this.open = !this.open; 
                                this.height = this.open ? this.contentHeight : 0; 
                                this.bg = this.open ? 'bg-slate-200' : ''; 
                                this.rotate = this.open ? 'rotate-90' : '';
                                this.pd = this.open ? 'mb-4' : '';
                            }
                        }" x-init="contentHeight = $refs.content.scrollHeight; delay = 100 * {{ $loop->index }}">
                            <div @click="setTimeout(() => handleClick(), delay)" :class="` shadow-md border-b rounded-l-3xl bg-white rounded-br-[30px] flex justify-between ${bg}`">
                                <div class="items-center py-1 grid grid-cols-6 grow pl-6">
                                    <p>{{ $t->nomor_peminjaman }}</p>

                                    <div class="text-center">
                                        <p class="text-xs">Tanggal Peminjaman</p>
                                        <p>{{ $tanggalPeminjaman->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs">Deadline</p>
                                        <p>{{ $deadlinePengembalian->translatedFormat('d-m-Y') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs">Total Denda</p>
                                        <p>Rp 20.000</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs">Item</p>
                                        <p>{{ $totalBooks }}</p>
                                    </div>

                                    <div class="flex gap-2 items-center">
                                        <div class="w-20 bg-slate-200 text-white text-center rounded-md">
                                            <div class="bg-gradient-to-b from-teal-500 to-emerald-500 text-transparent rounded-r-md" style="width: {{ $returnedPercentage }}%;">
                                                i
                                            </div>
                                        </div>
                                        <small>{{ $returnedBooks }}/{{ $totalBooks }}</small>
                                        <p><small><i>Returned</i></small></p>
                                    </div>
                                </div>
                                <div class="flex h-16 rounded-3xl items-center justify-center pl-8">
                                    <button class="h-full bg-gradient-to-br from-indigo-500 to-sky-400 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl" type="button">
                                        <i :class="`fas fa-list ${rotate} transition-transform duration-300`"></i>
                                    </button>
                                </div>
                            </div>
                            <div x-ref="content" :style="{height: `${height}px`}" :class="`mb-2 overflow-hidden transition-height duration-300 ease-in-out pr-10`">
                                @foreach ($transaksiPeminjaman as $item)
                                    <div class="px-10">
                                        <div class="flex items-center gap-8 border-0 bg-white border-cyan-700 border-t shadow-md rounded-l-3xl rounded-br-[30px] cursor-pointer">
                                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm" src="" alt="gambar buku">
                                            <div class="grow px-8">
                                                <p>Nomor Buku</p>
                                                <p>nama buku</p>
                                            </div>
                                            <div class="px-10 justify-center">
                                                @switch($item->status)
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
                                                <h1 class="text-xs text-center">Tanggal Dikembalikan</h1>
                                                <h1>{{ Carbon::now()->format('l, d-m-Y') }}</h1>
                                            </div>
                                            <div>
                                                <h1 class="text-xs text-center">Denda</h1>
                                                <h1>RP. 2000</h1>
                                            </div>
                                            <div class="flex h-16 rounded-3xl items-center justify-center">
                                                <button class="text-center relative h-full align-middle bg-gradient-to-b from-blue-500 to-violet-500 text-white px-3 py-1 rounded-br-3xl" type="submit">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
