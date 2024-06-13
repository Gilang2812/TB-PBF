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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-sm">
            <div class="bg-white/30 backdrop-blur-md border border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 text-black py-8">
                    <h1
                        class="text-center bg-gradient-to-br from-blue-600 to-cyan-500 text-transparent bg-clip-text text-5xl font-mono font-extrabold pt-16 pb-8">
                        Konfirmasi Pinjaman
                    </h1>
                    <p
                        class="text-lg  bg-gradient-to-br from-sky-800 to-cyan-700 text-transparent bg-clip-text  font-extrabold font-serif">
                        Total Peminjaman: {{ $responseData['user']->count() }}</p>

                    @foreach ($responseData['user']->unique('nomor_peminjaman') as $t)
                        @php
                            $transaksiUser = $responseData['transaksi']
                                ->where('nomor_peminjaman', '=', $t['nomor_peminjaman'])
                                ->count();
                        @endphp
                        <div x-data="{
                            open: false,
                            height: 0,
                            contentHeight: 0,
                            delay: 0,
                            bg: '',
                            rotate: '',
                            handleClick() {
                                this.open = !this.open;
                                this.height = this.open ? this.contentHeight : 0;
                                this.bg = this.open ? 'bg-slate-100' : '';
                                this.rotate = this.open ? 'rotate-90' : '';
                            }
                        }" x-init="contentHeight = $refs.content.scrollHeight;
                        delay = 100 * {{ $loop->index }}">

                            <div @click="setTimeout(() => handleClick(), delay)"
                                :class="`flex bg-white shadow-md items-center shadow-cyan-100 rounded-3xl mt-8 cursor-pointer ${bg}`">
                                <p class="grow px-8">{{ ucwords($t->nomor_peminjaman) }}</p>
                                <p class="grow px-8"> By : {{ ucwords($t->peminjaman?->user?->name) }}</p>

                                <div class="text-center">
                                    <p>Count Item :</p>
                                    <p class="grow px-8">{{ $transaksiUser }}</p>
                                </div>

                                <div class="text-center">
                                    <p>Tanggal Pinjam:</p>
                                    <p class="grow px-8">
                                        {{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>

                                <div>
                                    <h1>Batas Pengembalian</h1>
                                    <h1>{{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                    </h1>
                                </div>

                                <div class="flex h-16 rounded-3xl items-center justify-center pl-8">
                                    <button
                                        class="h-full bg-gradient-to-b from-indigo-500 to-sky-500 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl"
                                        type="submit">
                                        <i :class="`fas fa-list ${rotate} transition-transform duration-300`"></i>
                                    </button>
                                </div>
                            </div>

                            <div x-ref="content" :style="{ height: `${height}px` }"
                                class="overflow-hidden bg-white transition-height duration-300 shadow-md shadow-cyan-200  rounded-l-3xl rounded-br-[30px] ease-in-out mx-10">
                                @foreach ($responseData['transaksi'] as $item)
                                    @if ($item->peminjaman->nomor_peminjaman == $t->peminjaman->nomor_peminjaman)
                                        <div
                                            class="flex items-center border-t border-cyan-200 rounded-3xl cursor-pointer">
                                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm" src=""
                                                alt="gambar buku">
                                            <p class="grow px-8">{{ $item->buku?->judul_buku }}</p>

                                            <div class="px-10 justify-center">
                                                @switch($item->status)
                                                    @case(0)
                                                        <p class="bg-yellow-500 rounded-xl w-fit px-2 py-1 text-white">waiting
                                                        </p>
                                                    @break

                                                    @case(1)
                                                        <p class="bg-green-500 rounded-xl w-fit px-2 py-1 text-white">acc</p>
                                                    @break

                                                    @case(2)
                                                        <p class="bg-blue-500 rounded-xl w-fit px-2 py-1 text-white">Returned
                                                        </p>
                                                    @break

                                                    @default
                                                        <p class="bg-gray-500 rounded-xl w-fit px-2 py-1 text-white">unknown</p>
                                                @endswitch
                                            </div>

                                            <div>
                                                <h1>Batas Pengembalian</h1>
                                                <h1>{{ Carbon::parse($item->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                                </h1>
                                            </div>

                                            <div class="text-center">
                                                <p>Tanggal Pinjam:</p>
                                                <p class="grow px-8">
                                                    {{ Carbon::parse($item->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}
                                                </p>
                                            </div>
                                            <div class="flex h-16 rounded-3xl items-center justify-center">
                                                <form
                                                    action="{{ route('pinjaman.reject', ['nomor_peminjaman' => $item->peminjaman->nomor_peminjaman, 'nomor_buku' => $item->nomor_buku]) }}"
                                                    class="h-full" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="h-full bg-gradient-to-b from-yellow-500 to-red-400 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl"
                                                        type="submit">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('pinjaman.accept', ['nomor_peminjaman' => $item->peminjaman->nomor_peminjaman, 'nomor_buku' => $item->nomor_buku]) }}"
                                                    class="h-full" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="text-center h-full align-middle bg-gradient-to-b flex justify-center items-center from-emerald-400 to-teal-300 text-white px-3 py-1 rounded-br-3xl"
                                                        type="submit">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
