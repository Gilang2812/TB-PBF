<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Durasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/30 backdrop-blur-sm border border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 py-20 text-gray-900">
                    <form action="{{route('durasi.update',[$durasi->id_durasi])}}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">{{ session('success') }}</strong>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Terjadi kesalahan!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="before:content-['• ']">• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div>
                            <label for="nama" class="text-lg font-semibold">Label Durasi:</label>
                            <input type="text" id="nama" name="nama" value=" {{ $durasi->nama }} "
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>

                        <div>
                            <label for="durasi" class="text-lg font-semibold">Durasi:</label>
                            <input type="number" id="durasi" name="durasi" value="{{ $durasi->durasi }}"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out">Simpan</button>
                        <a href="{{ route('durasi.destroy', $durasi->id_durasi) }}"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out"
                            onclick="event.preventDefault(); 
                                if(confirm('Are you sure you want to delete this book?')) {
                                    document.getElementById('delete-durasi-form-{{ $durasi->id_durasi }}').submit();
                                }">Hapus</a>
                    </form>
                    <form id="delete-durasi-form-{{$durasi->id_durasi}}" action="{{route('durasi.destroy',[$durasi->id_durasi])}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
