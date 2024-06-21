<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/30 backdrop-blur-sm border border-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 py-20 text-gray-900">
                    <form action="{{route('durasi.store')}}" method="POST" class="space-y-4" enctype="multipart/form-data">
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
                            <label for="nama" class="text-lg font-semibold">Label Durasi:</label>
                            <input type="text" id="nama" name="nama" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" >
                        </div>
                        
                        <div>
                            <label for="durasi" class="text-lg font-semibold">Durasi:</label>
                            <input type="number" id="durasi" name="durasi" 
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
