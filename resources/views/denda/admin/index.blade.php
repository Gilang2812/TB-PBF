<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denda List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mx-8 mt-8 space-y-8">
                        <figure class="flex gap-8">
                            @foreach (['denda', 'durasi'] as $item)
                                @if(!$$item)
                                    <a href="/{{ $item }}/create" class="bg-purple-600 transition-colors ease-in-out duration-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md flex items-center w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H3a1 1 0 1 1 0-2h6V3a1 1 0 0 1 1-1z" />
                                        </svg>
                                        {{ ucfirst($item) }}
                                    </a>
                                @endif
                            @endforeach
                        </figure>
                        <div class="max-md:overflow-auto">
                            @if ($denda || $durasi)
                                <table class="min-w-full divide-y divide-gray-200 mt-4">
                                    <thead>
                                        <tr class="bg-gray-50 text-center">
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Value</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                                        @foreach (['denda', 'durasi'] as $item)
                                            @if ($$item)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-6 py-4">{{ $$item->nama }}</td>
                                                    <td class="px-6 py-4">{{ $$item->{$item} }}</td>
                                                    <td class="px-6 py-4">
                                                        <a href="/{{ $item }}/{{ $$item->{'id_'.$item} }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">Edit</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center p-4 bg-yellow-100 border border-yellow-300 rounded-md">
                                    <p class="font-semibold text-yellow-800">Denda belum ditambahkan!</p>
                                    <p class="font-semibold text-yellow-800">Durasi belum ditambahkan!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
