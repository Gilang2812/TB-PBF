<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-32 text-gray-900 py-8">
                    <h1 class="text-center text-3xl font-serif font-bold pt-16 pb-8">Daftar Pinjaman</h1>
                    <h1>tanggal pengembalian : </h1>
                    <form action="">
                        <div class="flex items-center border-2 rounded-3xl  my-4">
                            <img class="mx-6  h-16 w-12 bg-slate-200 rounded-sm" src="" alt="gambar buku">
                            <p class="grow px-8">Judul</p>
                            <div class="px-10 justify-center">
                                <p class="bg-emerald-500 rounded-xl w-fit px-2 py-1 text-white">Status</p>
                            </div>
                            <div>
                                <p>tanggal pinjam</p>
                                <p class="grow px-8">24-122001</p>
                            </div>
                            <div class="flex h h-16 rounded-3xl items-center justify-center">
                                <button class="h-full bg-yellow-500 text-white px-3 py-1 rounded-tl-3xl rounded-br-3xl" type="submit">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class=" text-center h-full align-middle bg-emerald-500   text-white px-3 py-1 rounded-br-3xl" type="submit">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center border-2 rounded-3xl my-4">
                            <img class="mx-6 h-16 w-12 bg-slate-200 rounded-sm" src="" alt="gambar buku">
                            <p class="grow px-8">Judul</p>
                            <div class="px-10 justify-center">
                                <p class="bg-emerald-500 rounded-xl w-fit px-2 py-1 text-white">Status</p>
                            </div>
                            <div>
                                <p>tanggal pinjam</p>
                                <p class="grow px-8">24-122001</p>
                            </div>
                            <div class="flex h h-16 rounded-3xl">
                                <button class="h-full bg-yellow-500 text-white px-3 py-1 rounded-tl-3xl rounded-br" type="submit">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <a class="h-full bg-emerald-500 text-white px-3 py-1 rounded-br-3xl" type="submit">
                                    <i class="fas fa-check"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
