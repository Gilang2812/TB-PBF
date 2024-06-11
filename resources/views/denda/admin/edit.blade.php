<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book') }} > {{ $buku->judul_buku }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 py-20 text-gray-900">
                    <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST" class="space-y-4"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Untuk menggunakan metode HTTP PUT untuk update -->
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" value="{{ $denda->nama }}" required>
                        <label for="denda">Denda:</label>
                        <input type="text" name="denda" value="{{ $denda->denda }}" required>
                        <button type="submit">Update</button>
                        <!-- Tombol Hapus -->

                        <a href="{{ route('denda.destroy', $denda->id_denda) }}"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out"
                            onclick="event.preventDefault(); 
                            if(confirm('Are you sure you want to delete this book?')) {
                                document.getElementById('delete-book-form-{{ $denda->id_denda }}').submit();
                            }">Hapus</a>
               
                    </form>
                    <form id="delete-book-form-{{ $denda->id_denda }}" method="POST" style="display: none;"
                        action="{{ route('book.destroy', $denda->id_denda) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
