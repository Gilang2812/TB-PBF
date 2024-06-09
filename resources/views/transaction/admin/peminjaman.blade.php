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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 text-gray-900 py-8">
                    <h1 class="text-center bg-gradient-to-r from-cyan-900 to-cyan-500 text-transparent bg-clip-text text-3xl font-serif font-bold pt-16 pb-8">
                        Konfirmasi Pinjaman
                    </h1>
                    <p>Total Peminjaman: {{ $responseData['user']->count() }}</p>
                    
                    @foreach ($responseData['user'] as $t)
                        <div x-data="{ 
                            open: false, 
                            height: 0, 
                            contentHeight: 0, 
                            delay: 0, 
                            bg: '', 
                            rotate:'', 
                            handleClick() {
                                this.open = !this.open; 
                                this.height = this.open ? this.contentHeight : 0; 
                                this.bg = this.open ? 'bg-slate-100' : ''; 
                                this.rotate = this.open? 'rotate-90' : '';
                            }
                        }" 
                        x-init="contentHeight = $refs.content.scrollHeight; delay = 100 * {{ $loop->index }}">
                             
                            <div @click="setTimeout(() => handleClick(), delay)" :class="`flex items-center border-2 rounded-3xl mt-8 cursor-pointer ${bg}`">
                                <p class="grow px-8">{{ ucwords($t->peminjaman?->user?->name) }}</p>
                                
                                <div class="text-center">
                                    <p>Tanggal Pinjam:</p>
                                    <p class="grow px-8">{{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}</p>
                                </div>
                                
                                <div>
                                    <h1>Batas Pengembalian</h1>
                                    <h1>{{ Carbon::parse($t->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}</h1>
                                </div>
                                
                                <div class="flex h-16 rounded-3xl items-center justify-center pl-8">
                                    <button class="h-full bg-indigo-500 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl" type="submit">
                                        <i :class="`fas fa-list tra ${rotate} transition-transform duration-300`"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div x-ref="content" :style="{ height: `${height}px` }" class="overflow-hidden transition-height duration-300 ease-in-out pr-10">
                                @foreach ($responseData['transaksi'] as $item)
                                    @if ($item->peminjaman->id_user == $t->peminjaman->id_user)
                                        <div class="flex items-center border-2 rounded-3xl cursor-pointer">
                                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm" src="" alt="gambar buku">
                                            <p class="grow px-8">{{ $item->buku?->judul_buku }}</p>
                                            
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
                                                <h1>Batas Pengembalian</h1>
                                                <h1>{{ Carbon::parse($item->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}</h1>
                                            </div>
                                            
                                            <div class="text-center">
                                                <p>Tanggal Pinjam:</p>
                                                <p class="grow px-8">{{ Carbon::parse($item->peminjaman?->tanggal_peminjaman)->translatedFormat('l, d F Y') }}</p>
                                            </div>
                                            
                                            <div class="flex h-16 rounded-3xl items-center justify-center">
                                                <button class="h-full bg-yellow-500 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl" type="submit">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                                <button class="text-center h-full align-middle bg-emerald-500 text-white px-3 py-1 rounded-br-3xl" type="submit">
                                                    <i class="fas fa-check"></i>
                                                </button>
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
 
