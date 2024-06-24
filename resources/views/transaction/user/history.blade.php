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
            <div
                class="bg-white/40 text-sm backdrop-blur-sm border border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-16 text-black h-full">
                    <h1
                        class="text-center bg-gradient-to-br from-cyan-500 to-indigo-700 text-transparent bg-clip-text text-5xl font-mono font-extrabold pb-8">
                        Recap
                    </h1>
                    @php
                        $allDenda = 0;
                    @endphp
                    @foreach ($transaksi->unique('nomor_peminjaman') as $t)
                        @php
                            $transaksiPeminjaman = $transaksi->where('nomor_peminjaman', $t->nomor_peminjaman);
                            $totalBooks = $transaksiPeminjaman->count();
                            $returnedBooks = $transaksiPeminjaman->where('status', 4)->count();
                            $returnedPercentage = $totalBooks ? ($returnedBooks / $totalBooks) * 100 : 0;
                            $durasi = $item->peminjaman?->durasi?->durasi ?? 7;
                            $tanggalPeminjaman = Carbon::parse($t->peminjaman?->tanggal_peminjaman);
                            $deadlinePengembalian = $tanggalPeminjaman->copy()->addDays($durasi);
                            
                            $totalDenda = [];
                            foreach ($transaksiPeminjaman as $item) {
                                $tanggal = $item->tanggal_pengembalian
                                    ? Carbon::parse($item->tanggal_pengembalian)
                                    : now();
                                $dueDate = $tanggalPeminjaman->addDays($durasi)->startOfDay();
                                        $daysDifference = $tanggal->startOfDay()->diffInDays($dueDate, false);
                                $absoluteDaysDifference = abs($daysDifference);
                                $finePerDay = $item->peminjaman?->denda?->denda ?? 3000;
                                $fine = $tanggal->greaterThan($dueDate) ? $absoluteDaysDifference * $finePerDay : 0;
                                $totalDenda[] = $fine;
                            }
                            $sumTotalDenda = array_sum($totalDenda);
                        @endphp
  <div x-data="{
                            open: false,
                            height: 0,
                            contentHeight: 0,
                            delay: 0,
                            bg: '',
                            rotate: '',
                            pd: '',
                            text: '',
                            handleClick() {
                                this.open = !this.open;
                                this.height = this.open ? this.contentHeight : 0;
                                this.bg = this.open ? 'bg-slate-200' : '';
                                this.rotate = this.open ? 'rotate-90' : '';
                                this.pd = this.open ? 'mb-4' : '';
                                this.text = this.open ? 'text-white bg-slate-200' : 'bg-blue-500';
                            }
                        }" x-init="contentHeight = $refs.content.scrollHeight;
                        delay = 100 * {{ $loop->index }}">
                            <div @click="setTimeout(() => handleClick(), delay)"
                                :class="` shadow-md border-b rounded-l-3xl  rounded-br-[30px] font-mono flex justify-between  bg-white  transition-all duration-300 `">
                                <div class="items-center py-1 grid grid-cols-5 grow pl-6">
                                    <p>{{ $t->nomor_peminjaman }}</p>

                                    <div class="text-center">
                                        <p class="text-xs ">Tanggal Peminjaman</p>
                                        <p>{{ $tanggalPeminjaman->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs">Deadline</p>
                                        <p>{{ $deadlinePengembalian->translatedFormat('d-m-Y') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs"> Denda</p>
                                        <p>{{ 'Rp ' . number_format($sumTotalDenda, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="w-20 bg-slate-200 text-white text-center rounded-md">
                                            <div class="bg-gradient-to-b from-teal-500 to-emerald-500 text-transparent rounded-r-md"
                                                style="width: {{ $returnedPercentage }}%;">
                                                i
                                            </div>
                                        </div>
                                        <small>{{ $returnedBooks }}/{{ $totalBooks }}</small>
                                        <p><small><i>Returned</i></small></p>
                                    </div>
                                </div>
                                <div class="flex h-16 rounded-3xl items-center justify-center pl-8">
                                    <button
                                        class="h-full bg-gradient-to-br from-indigo-500 to-sky-400 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl"
                                        type="button">
                                        <i :class="`fas fa-list ${rotate} transition-transform `"></i>
                                    </button>
                                </div>
                            </div>
                            <div x-ref="content" :style="{ height: `${height}px` }"
                                :class="`mb-2 overflow-hidden transition-height duration-300 ease-in-out `">
                                @foreach ($transaksiPeminjaman as $item)
                                    @php
                                        $tanggal = $item->tanggal_pengembalian
                                            ? Carbon::parse($item->tanggal_pengembalian)
                                            : now();
                                        $durasi = $item->peminjaman?->durasi?->durasi ?? 7;
                                        $tanggalPeminjaman = Carbon::parse($item->peminjaman->tanggal_peminjaman);
                                        $dueDate = $tanggalPeminjaman->addDays($durasi)->startOfDay();
                                        $daysDifference = $tanggal->startOfDay()->diffInDays($dueDate, false);
                                        $absoluteDaysDifference = abs($daysDifference);
                                        $finePerDay = $item->peminjaman?->denda?->denda ?? 3000;
                                        $fine = $tanggal->greaterThan($dueDate)
                                            ? $absoluteDaysDifference * $finePerDay
                                            : 0;
                                    @endphp
                                    <div class="">
                                        <div
                                            class="bg-slate-200 grid grid-cols-8 items-center gap-8 border-0 font-mono border-cyan-700 border-t shadow-md rounded-l-3xl rounded-br-[30px] cursor-pointer">
                                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm " src=""
                                                alt="gambar buku">
                                            <div class="text-center text-sm px-8 col-span-2">
                                                <p>{{ $item->nomor_buku }} </p>
                                                <p>{{ $item->buku->judul_buku }} </p>
                                            </div>
                                            <div class="px-10 justify-center items-center">
                                                @switch($item->status)
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
                                            <div class="col-span-2 text-center">
                                                <h1 class="text-xs text-center ">Tanggal Dikembalikan</h1>
                                                <h1>{{ $item->tanggal_pengembalian ? Carbon::parse($item->tanggal_pengembalian)->format('l, d-m-Y') : 'Belum Dikembalikan' }}
                                                </h1>
                                            </div>
                                            <div class="text-center">
                                                <h1 class="text-xs text-center">Denda</h1>
                                                <h1 class="text-xs text-center">{{ $absoluteDaysDifference }}</h1>
                                                <h1>{{ 'Rp ' . number_format($fine, 0, ',', '.') }}</h1>
                                            </div>
                                            <div
                                                class="flex h-16 rounded-3xl items-center justify-center justify-self-end">
                                                <form
                                                    action="{{ route('pinjaman.return', ['nomor_peminjaman' => $item->nomor_peminjaman, 'nomor_buku' => $item->nomor_buku]) }}"
                                                    class="h-full" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="text-center relative h-full align-middle bg-gradient-to-b from-blue-500 to-violet-500 text-white px-3 py-1 rounded-br-3xl"
                                                        type="submit">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
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
