<!-- resources/views/penerbit/admin/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penerbit') }} > {{ $penerbit->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 py-20 text-gray-900">
                    <form action="{{ route('penerbit.update', $penerbit->id_penerbit) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <!-- Field Nama Penerbit -->
                        <div>
                            <label for="nama" class="text-lg font-semibold">Nama Penerbit:</label>
                            <input type="text" id="nama" name="nama" value="{{ $penerbit->nama }}" required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out">Simpan</button>

                        <!-- Tombol Hapus -->
                        <a href="{{ route('penerbit.destroy', $penerbit->id_penerbit) }}"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out"
                            onclick="event.preventDefault(); 
                            if(confirm('Apakah Anda yakin ingin menghapus penerbit ini?')) {
                                document.getElementById('delete-penerbit-form-{{ $penerbit->id_penerbit }}').submit();
                            }">Hapus</a>
                    </form>
                    <form id="delete-penerbit-form-{{ $penerbit->id_penerbit }}" method="POST" style="display: none;"
                        action="{{ route('penerbit.destroy', $penerbit->id_penerbit) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
