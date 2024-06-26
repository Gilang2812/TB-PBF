<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 space-y-2 bg-blend-hard-light ">
            <div class="bg-white/40 border border-white backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg  ">
                <div class="p-6 text-black h-full">
                    <div class="flex justify-around space-x-4">
                        <div class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl shadow-lg rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                            <div class="relative p-8 grow space-y-2">
                                <strong class="text-4xl">{{ $user->count() }}</strong>
                                <i class="absolute right-4 text-white/40 h-16 text-6xl fas fa-users"></i>
                                <p class="text-lg font-bold font-sans">Members</p>
                            </div>
                            <a href="{{ route('users.index') }}" class="text-lg bg-white text-cyan-600 text-center py-1 w-full rounded-b-lg hover:bg-cyan-600 hover:text-white transition duration-300">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl shadow-lg rounded-lg bg-gradient-to-r from-green-500 to-teal-500 text-white">
                            <div class="relative p-8 grow space-y-2">
                                <strong class="text-4xl">{{ $book->count() }}</strong>
                                <i class="absolute right-4 text-white/40 h-16 text-6xl fas fa-book-reader"></i>
                                <p class="text-lg font-bold font-sans">Books</p>
                            </div>
                            <a href="{{ route('book.index') }}" class="text-lg bg-white text-green-600 text-center py-1 w-full rounded-b-lg hover:bg-green-600 hover:text-white transition duration-300">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl shadow-lg rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 text-white">
                            <div class="relative p-8 grow space-y-2">
                                <i class="absolute right-4 text-white/40 h-16 text-3xl z-0 top-6 fas fa-book"></i>
                                <i class="absolute right-4 text-white/40 h-16 text-5xl z-0 top-6 fas fa-hand-holding"></i>
                                <strong class="text-4xl">{{ $transaksi->where('status', '!=', 0)->where('peminjaman.status', 1)->count() }}</strong>
                                <p class="text-lg font-bold font-sans">Req Confirmed</p>
                            </div>
                            <a href="{{ route('pinjaman.history.admin') }}" class="text-lg bg-white text-yellow-600 text-center py-1 w-full rounded-b-lg hover:bg-yellow-600 hover:text-white transition duration-300">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl shadow-lg rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white">
                            <div class="relative p-8 grow space-y-2">
                                <i class="absolute right-4 text-white/40 h-16 text-sm z-10 top-6 fas fa-undo"></i>
                                <i class="absolute right-4 text-white/40 h-16 text-6xl top-4 z-0 fas fa-book"></i>
                                <strong class="text-4xl">{{ $transaksi->where('status', '4')->count() }}</strong>
                                <p class="text-lg font-bold font-sans">Returned</p>
                            </div>
                            <a href="{{ route('pinjaman.history.admin', ['status' => 4]) }}" class="text-lg bg-white text-red-600 text-center py-1 w-full rounded-b-lg hover:bg-red-600 hover:text-white transition duration-300">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div
                class="bg-white/40 backdrop-blur-md border text-x border-white overflow-hidden shadow-sm sm:rounded-lg  ">
                <div class="p-6   text-gray-900 h-full">
                    <div class=" space-y-2">
                        <div class="pb-4">
                            <Strong class="text-4xl font-bold font-mono mb-2">Notifications</Strong>
                        </div>

                        <table class="table-auto w-full text-xl font-mono border-b-2">
                            <thead class="border-y-2">
                                <tr class="grid grid-cols-3 py-2">
                                    <th class="col-span-2">Title</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transaksi->where('status', 0)->where('peminjaman.status=1')->count() != 0)
                                    <tr onclick="window.location='{{ url('/peminjaman?status=0') }}'" class="grid text-sm grid-cols-3  border-b-2 border-white bg-yellow-500/30 text-white py-2 pl-3 cursor-pointer hover:bg-yellow-500/50 transition duration-300">
                                        <td class="col-span-2 flex items-center">
                                            <div class="relative mr-2">
                                                <span class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 animate-ping left-0"></span>
                                                <i class="fas fa-exclamation-circle text-rose-600  mr-2">
                                                </i>
                                            </div>
                                            Terdapat pengajuan konfirmasi peminjaman
                                        </td>
                                        <td class="text-center">{{ $transaksi->where('status', 0)->where('peminjaman.status=1')->count() }}</td>
                                    </tr>
                                @endif
                                @if ($transaksi->where('status', 3)->count() != 0)
                                    <tr onclick="window.location='{{ url('/history?status=3') }}'" class="grid text-sm grid-cols-3 bg-yellow-500/30 text-white py-2 pl-3 cursor-pointer hover:bg-yellow-500/50 transition duration-300">
                                        <td class="col-span-2 flex items-center">
                                            <div class="relative">
                                                <i class="fas fa-exclamation-triangle text-rose-600 mr-2"></i>
                                                <span class="absolute left-0 inline-flex h-full w-full rounded-full bg-red-400 opacity-75 animate-ping"></span>
                                            </div>
                                            Terdapat transaksi yang belum bayar denda
                                        </td>
                                        <td class="text-center">{{ $transaksi->where('status', 3)->count() }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
