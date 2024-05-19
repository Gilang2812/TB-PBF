<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container space-y-4 flex flex-row-reverse gap-8">
                        <div class="">
                            <form action="" method="POST">
                                @if ($buku->ketersediaan ===0)
                                <input class="px-5 py-2   bg-zinc-300 text-slate-500 rounded-lg " type="submit" value="Pinjam" disabled>
                                @else
                                <input class="px-5 py-2 bg-blue-600 rounded-lg text-white" type="submit" value="Pinjam">
                                @endif
                              
                            </form>
                        </div>
                        <div class="space-y-4 w-full py-2">
                            <div>
                                <strong class="text-3xl">{{$buku->judul_buku}}</strong>
                                <p>- {{ucwords( $buku->pengarang)}}</p>
                            </div>
                            <hr>
                            <div>
                                <h1> Ketersediaan</h1>
                                <table class="w-full border-collapse border-slate-300 border">
                                    <tbody class="border">
                                        <tr>
                                            <td class="border-slate-300 border py-4 px-3">{{$buku->nomor_buku}} </td>
                                            <td class="border-slate-300 border py-4 px-3 w-64">{{$buku->posisi?->posisi}}</td>
                                            <td class="border-slate-300 border py-4 px-3 w-64 "> 
                                                @if ($buku->ketersediaan ===0)
                                                <span    
                                                    class="text-white bg-red-500 p-1 font-serif rounded-sm "> Tidak Tersedia </span></td>
                                                @else
                                                <span    
                                                    class="text-white bg-blue-500 p-1 font-serif rounded-sm "> Tersedia </span></td>
                                                @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h1>Informasi Detail</h1>
                                <div class="flex font-serif">
                                    <div class="pr-28">
                                        <p>No ID</p>
                                        <p>Judul Buku</p>
                                        <p>Penulis</p>
                                        <p>Penerbit</p>
                                        <p>Lokasi</p>
                                    </div>
                                    <div>
                                        <p>: {{$buku->nomor_buku}}</p>
                                        <p>: {{$buku->judul_buku}}</p>
                                        <p>: {{ucwords( $buku->pengarang)}}</p>
                                        <p>: {{ucwords($buku->penerbit?->nama)}}</p>
                                        <p>: {{$buku->posisi->posisi}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
