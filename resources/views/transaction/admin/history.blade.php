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
                <div class="p-16 text-gray-900 h-full">
                    <h1
                        class="text-center bg-gradient-to-r from-cyan-900 to-cyan-500 text-transparent bg-clip-text text-3xl font-serif font-bold pb-8">
                        History
                    </h1>

                    @php
                        $allDenda = 0;
                    @endphp

                    @foreach ($transaksi->unique('nomor_peminjaman') as $t)
                        @php
                            $books = $transaksi->where('nomor_peminjaman', $t->nomor_peminjaman);
                            $totalBooks = $books->count();
                            $returnedBooks = $books->where('status', 4)->count();
                            $durasi = $t->peminjaman?->durasi?->durasi ?? 3;
                            $returnedPercentage = ($returnedBooks / $totalBooks) * 100;
                            $totalDenda = 0;

                            $tanggalPeminjaman = Carbon::parse($t->peminjaman?->tanggal_peminjaman);
                            foreach ($books as $item) {
                                $tanggal = $item->tanggal_pengembalian
                                    ? Carbon::parse($item->tanggal_pengembalian)
                                    : now();
                                $dueDate = $tanggalPeminjaman->copy()->addDays($durasi)->startOfDay();
                                $daysDifference = $tanggal->startOfDay()->diffInDays($dueDate, false);
                                $absoluteDaysDifference = abs($daysDifference);
                                $finePerDay = $item->peminjaman?->denda?->denda ?? 3000;
                                $fine = $tanggal->greaterThan($dueDate) ? $absoluteDaysDifference * $finePerDay : 0;
                                $totalDenda += $fine;
                            }
                            $allDenda += $totalDenda;
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
                                this.bg = this.open ? 'bg-slate-400' : '';
                                this.rotate = this.open ? 'rotate-90' : '';
                                this.pd = this.open ? 'mb-4' : '';
                                this.text = this.open ? 'text-white' : '';
                            }
                        }" x-init="contentHeight = $refs.content.scrollHeight;
                        delay = 100 * {{ $loop->index }}">

                            <div @click="setTimeout(() => handleClick(), delay)"
                                :class="` shadow-md border-b rounded-l-3xl bg-white rounded-br-[30px] font-mono flex justify-between ${bg} transition-all duration-300 `">
                                <div class="items-center py-1 flex justify-between grow px-8">
                                    <p> {{ $t->peminjaman->user->name }} </p>
                                    <div class="text-center">
                                        <p>Denda</p>
                                        <p>{{ 'Rp ' . number_format($totalDenda, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p>tanggal pinjam</p>
                                        <p>{{ Carbon::parse($t->peminjaman->tanggal_peminjaman)->format('d-m-y') }} </p>
                                    </div>
                                    <div class="text-center">
                                        <p>Batas Pengembalian</p>
                                        <p>{{ Carbon::parse($t->peminjaman->tanggal_peminjaman)->addDays(3)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="w-20 bg-slate-200 text-white text-center">
                                            <div class="bg-emerald-500 rounded-r-md text-transparent"
                                                style="width: {{ $returnedPercentage }}%;">
                                                i
                                            </div>
                                        </div>
                                        {{ $returnedBooks }}/{{ $totalBooks }}
                                        <p><i>completed</i></p>
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

                                @foreach ($transaksi as $item)
                                    @if ($t->nomor_peminjaman === $item->nomor_peminjaman)
                                        @php
                                            $tanggal = $item->tanggal_pengembalian
                                                ? Carbon::parse($item->tanggal_pengembalian)
                                                : now();
                                            $durasi = $item->peminjaman?->durasi?->durasi ?? 0;
                                            $tanggalPeminjaman = Carbon::parse($item->peminjaman->tanggal_peminjaman);
                                            $dueDate = $tanggalPeminjaman->addDays($durasi)->startOfDay();
                                            $daysDifference = $tanggal->startOfDay()->diffInDays($dueDate, false);
                                            $absoluteDaysDifference = abs($daysDifference);
                                            $finePerDay = $item->peminjaman?->denda?->denda ?? 3000;
                                            $fine = $tanggal->greaterThan($dueDate)
                                                ? $absoluteDaysDifference * $finePerDay
                                                : 0;

                                            $totalDenda += $fine; // Tambahkan denda ke total denda

                                        @endphp
                                        <div class="">
                                            <div
                                                class="bg-slate-200 grid grid-cols-8 items-center gap-8 border-0 font-mono border-cyan-700 border-t shadow-md rounded-l-3xl rounded-br-[30px] cursor-pointer">
                                                <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm" src=""
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
                                                                Pending
                                                            </p>
                                                        @break

                                                        @case(1)
                                                            <p
                                                                class="bg-gradient-to-r from-green-400 to-green-600 rounded-xl w-fit px-2 py-1 text-white">
                                                                Borrowing
                                                            </p>
                                                        @break

                                                        @case(2)
                                                            <p
                                                                class="bg-gradient-to-r from-red-400 to-red-600 rounded-xl w-fit px-2 py-1 text-white">
                                                                Rejected
                                                            </p>
                                                        @break

                                                        @case(3)
                                                            <p
                                                                class="bg-gradient-to-r from-orange-400 to-orange-600 rounded-xl w-fit px-2 py-1 text-white">
                                                                Payment Required
                                                            </p>
                                                        @break

                                                        @case(4)
                                                            <p
                                                                class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl w-fit px-2 py-1 text-white">
                                                                Complete
                                                            </p>
                                                        @break

                                                        @default
                                                            <p
                                                                class="bg-gradient-to-r from-gray-400 to-gray-600 rounded-xl w-fit px-2 py-1 text-white">
                                                                Unknown
                                                            </p>
                                                    @endswitch
                                                </div>
                                                <div class="col-span-2 text-center">
                                                    <h1 class="text-xs text-center">Tanggal Dikembalikan</h1>
                                                    <h1>{{ $item->tanggal_pengembalian? Carbon::parse($item->tanggal_pengembalian)->locale('id')->format('d-m-Y'): 'Belum Dikembalikan' }}
                                                    </h1>
                                                </div>
                                                <div class="text-center">
                                                    <h1 class="text-xs text-center">Denda</h1>
                                                    <h1>{{ 'Rp ' . number_format($fine, 0, ',', '.') }}</h1>
                                                </div>
                                                <div
                                                    class="flex h-16 rounded-3xl items-center justify-center justify-self-end">
                                                    <form
                                                        action="{{ route('pinjaman.finish', ['nomor_peminjaman' => $item->nomor_peminjaman, 'nomor_buku' => $item->nomor_buku]) }}"
                                                        class="h-full" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button
                                                            class="text-center relative h-full align-middle bg-gradient-to-b cursor-pointer disabled:cursor-auto text-white px-3 py-1 rounded-br-3xl disabled:from-gray-400 disabled:to-salte-400"
                                                            type="submit" {{ $item->status !== 3 ? 'disabled' : '' }}>
                                                            <i class="fas fa-thumbs-up"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <h1>Total seluruh denda: {{ 'Rp ' . number_format($allDenda, 0, ',', '.') }}</h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
