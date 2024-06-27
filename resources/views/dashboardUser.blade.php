@php
    \Carbon\Carbon::setLocale('id');
    use Carbon\Carbon;
    use Illuminate\Support\Collection;

@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 space-y-2 bg-blend-hard-light ">
            <div class="bg-white/40 border border-white backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black h-full">
                    <div class="flex justify-around space-x-4">
                        @foreach ([
                            ['count' => $transaksi->where('status', 0)->count(),'link'=>'pinjaman.history.user' ,'color' => 'from-cyan-500 to-blue-500', 'icon' => 'fas fa-users', 'text' => 'Waiting Request', 'status' => 0], 
                            ['count' => $transaksi->where('status', 2)->count(),'link'=>'pinjaman.index.user' , 'color' => 'from-red-500 to-pink-500', 'icon' => 'fas fa-times-circle', 'text' => 'Rejected Request', 'status' => 2], 
                            ['count' => $transaksi->where('status', 1)->count(),'link'=>'pinjaman.history.user' , 'color' => 'from-green-500 to-teal-500', 'icon' => 'fas fa-check-circle', 'text' => 'Accepted', 'status' => 1], 
                            ['count' => $transaksi->where('status', 4)->count(),'link'=>'pinjaman.history.user' , 'color' => 'from-yellow-500 to-orange-500', 'icon' => 'fas fa-undo', 'text' => 'Returned', 'status' => 4]] as $info)
                            <div
                                class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl shadow-lg rounded-lg bg-gradient-to-r {{ $info['color'] }} text-white">
                                <div class="relative p-8 grow space-y-2">
                                    <strong class="text-4xl">{{ $info['count'] }}</strong>
                                    <i class="absolute right-4 text-white/40 h-16 text-6xl {{ $info['icon'] }}"></i>
                                    <p class="text-lg font-bold font-sans">{{ $info['text'] }}</p>
                                </div>
                                <a href="{{ route($info['link'], ['status' => $info['status']]) }}"
                                    class="text-lg bg-white text-{{ explode('-', $info['color'])[1] }}-600 text-center py-1 w-full rounded-b-lg hover:bg-{{ explode('-', $info['color'])[1] }}-600 hover:text-white transition duration-300">
                                    more info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div
                class="bg-white/40 backdrop-blur-md border text-x border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 h-full">
                    <div class="space-y-2">
                        <div class="pb-4">
                            <strong class="text-4xl font-bold font-mono mb-2">Notifications</strong>
                        </div>
                        <table class="table-auto w-full text-xl font-mono border-b-2">
                            <thead class="border-y-2">
                                <tr class="grid grid-cols-3 py-2">
                                    <th class="col-span-2">Title</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $trans = collect();
                                    foreach ($transaksi->where('peminjaman.status', 1)->where('status', 1) as $t) {
                                        $deadline = Carbon::parse($t->peminjaman->tanggal_peminjaman)
                                            ->addDays($t->peminjaman->durasi?->durasi ?? 7)
                                            ->format('d-m-Y');
                                        if ($deadline == Carbon::now()->format('d-m-Y')) {
                                            $trans->push($t);
                                        }
                                    }
                                @endphp

                                =
                                @if ($trans->count() != 0)
                                    <tr onclick="window.location='{{ url('/history/user?deadline=1') }}'"
                                        class="grid text-sm grid-cols-3 border-b-2 border-white bg-yellow-500/30 text-white py-2 pl-3 cursor-pointer hover:bg-yellow-500/50 transition duration-300">
                                        <td class="col-span-2 flex items-center">
                                            <div class="relative mr-2">
                                                <span
                                                    class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 animate-ping left-0"></span>
                                                <i class="fas fa-exclamation-circle text-rose-600 mr-2"></i>
                                            </div>
                                            Terdapat peminjaman yang harus dikembalikan hari ini
                                        </td>
                                        <td class="text-center">{{ $trans->count() }}</td>
                                    </tr>
                                @endif
                                @if ($transaksi->where('status', 3)->count() != 0)
                                    <tr onclick="window.location='{{ url('/history/user?status=3') }}'"
                                        class="grid text-sm grid-cols-3 bg-yellow-500/30 text-white py-2 pl-3 cursor-pointer hover:bg-yellow-500/50 transition duration-300">
                                        <td class="col-span-2 flex items-center">
                                            <div class="relative">
                                                <i class="fas fa-exclamation-triangle text-rose-600 mr-2"></i>
                                                <span
                                                    class="absolute left-0 inline-flex h-full w-full rounded-full bg-red-400 opacity-75 animate-ping"></span>
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
