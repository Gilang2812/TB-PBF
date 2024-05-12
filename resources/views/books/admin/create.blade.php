<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 py-20 text-gray-900">
                    <form action="/book/create" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Terjadi kesalahan!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="before:content-['• ']">• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <label for="nomor_buku" class="text-lg font-semibold">Nomor Buku:</label>
                            <input type="text" id="nomor_buku" name="nomor_buku" required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <div>
                            <label for="id_posisi" class="text-lg font-semibold">Posisi:</label>
                            <select id="id_posisi" name="id_posisi" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                <option value="" selected disabled> Pilih posisi</option>
                                @foreach ($posisi as $pos)
                                    <option value="{{ $pos->id_posisi }}">{{ $pos->posisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="id_penerbit" class="text-lg font-semibold">Penerbit:</label>
                            <select id="id_penerbit" name="id_penerbit" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                <option value="" selected disabled> Pilih Penerbit</option>
                                @foreach ($penerbit as $pen)
                                    <option value="{{ $pen->id_penerbit }}">{{ $pen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="jenis_buku" class="text-lg font-semibold">Jenis Buku:</label>
                            <input type="text" id="jenis_buku" name="judul_buku" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <div>
                            <label for="pengarang" class="text-lg font-semibold">Pengarang:</label>
                            <input type="text" id="pengarang" name="pengarang" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <div>
                            <label for="ketersediaan" class="text-lg font-semibold">Ketersediaan:</label>
                            <input type="number" id="ketersediaan" name="ketersediaan" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
            
                        <div class="">
                            <p class="text-lg font-semibold py-3">Gambar Buku:</p>
                            <label for="gambar_buku"
                                class="cursor-pointer text-lg font-semibold w-full px-3 py-2 border-2 bg-gradient-to-b from-white via-slate-100 to-zinc-100 rounded-lg  border-slate-200 focus:outline-none focus:ring focus:border-blue-300 hover:from-zinc-200 transition duration-300">pilih gambar</label>
                            <input type="file" id="gambar_buku" name="gambar_buku"  class="hidden">
                        </div>
            
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
