<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denda') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto  ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8  text-gray-900">
                    <div class=" mx-8 mt-8 space-y-8">
                    @if ($dendas->count() === 0)
                            <p class="text-center">Belum ada Denda</p>      
                        @endif
                        <div class="max-md:overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead>
                                    <tr class="bg-gray-50 text-center">
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nomor</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nomor Buku</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Judul Buku</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Denda</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-center">
                                    @foreach ($dendas as $denda)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4"></td>
                                            <td class="px-6 py-4"></td>
                                            <td class="px-6 py-4">{{ $denda->denda}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
