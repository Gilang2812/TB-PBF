<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penerbit List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mx-8 mt-8 space-y-8">
                        <a href="{{ route('penerbit.create') }}"
                            class="bg-purple-600 transition-colors ease-in-out duration-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md flex items-center w-fit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H3a1 1 0 1 1 0-2h6V3a1 1 0 0 1 1-1z" />
                            </svg>
                            Tambah Penerbit
                        </a>
                        <div class="max-md:overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead>
                                    <tr class="bg-gray-50 text-center">
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nomor</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">ID Penerbit</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-center">
                                    @foreach ($penerbit as $penerbit)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4">{{ $penerbit->id_penerbit }}</td>
                                            <td class="px-6 py-4">{{ $penerbit->nama }}</td>
                                            <td class="px-6 py-4">
                                                <!-- Edit button -->
                                                <a href="{{ route('penerbit.edit', $penerbit->id_penerbit) }}"
                                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">Edit</a>
                                            </td>
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
