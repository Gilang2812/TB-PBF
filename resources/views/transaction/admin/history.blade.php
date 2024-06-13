<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recap') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  ">
                <div class="p-16   text-gray-900 h-full">
                    <h1
                        class="text-center bg-gradient-to-r from-cyan-900 to-cyan-500 text-transparent bg-clip-text text-3xl font-serif font-bold  pb-8">
                        Recap</h1>
                    <div class="border-2 rounded-3xl flex justify-between ">
                        <div class="items-center py-1 flex justify-between grow px-8">

                            <p>user</p>
                            <div class="text-center">
                                <p>Denda</p>
                                <p>Rp 20.000</p>
                            </div>
                            <div class="text-center">
                                <p>Item</p>
                                <p>4</p>
                            </div>
                            @php
                                // Contoh perhitungan persentase
                                $totalBooks = 4;
                                $returnedBooks = 1;
                                $returnedPercentage = ($returnedBooks / $totalBooks) * 100;
                            @endphp
                            <div class="flex gap-2">
                                <div class="w-20 bg-slate-200 text-white text-center   ">
                                    <div class="bg-emerald-500 rounded-r-md text-transparent" style="width: {{ $returnedPercentage }}%;">
                                    i
                                    </div>

                                </div>
                                {{ $returnedBooks }}/{{ $totalBooks }}
                                <p><i>returned</i></p>
                            </div>
                                
                        </div>
                        <div class="flex h-16 rounded-3xl items-center justify-center pl-8">
                            <button class="h-full bg-indigo-500 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl"
                                type="">
                                <i class="fas fa-list transition-transform duration-300"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
