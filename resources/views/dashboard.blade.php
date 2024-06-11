<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 space-y-2 bg-blend-hard-light ">
            <div class="bg-white/40 border border-white backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg  ">
                <div class="p-6   text-black h-full">
                    <div class="flex justify-around">
                        <div
                            class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl hadow-lg rounded-lg bg-white ">
                            <div class="relative p-8 grow space-y-2">
                                <strong class="text-4xl">2</strong>
                                <i class=" absolute right-4 text-cyan-300/40 h-16 text-6xl fas fa-users"></i>
                                <p class="text-lg font-bold font-sans">Members</p>
                            </div>

                            <p class="text-lg bg-cyan-600 text-center py-1 text-white w-full rounded-b-lg ">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </p>
                      

                        </div>
                        <div
                            class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl  rounded-b-lg shadow bg-white">
                            <div class="relative p-8 grow space-y-2">
                                <strong class="text-4xl">2</strong>
                                <i class=" absolute right-4 text-cyan-300/40 h-16 text-6xl fas fa-book-reader"></i>
                                <p class="text-lg font-bold font-sans">Book</p>
                            </div>

                            <p class="text-lg bg-cyan-600 text-center py-1 text-white w-full rounded-b-lg">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </p>

                        </div>
                        <div
                            class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl  rounded-b-lg shadow bg-white">
                            <div class="relative p-8 grow space-y-2">
                                <i class=" absolute right-4 text-cyan-300/40 h-16 text-3xl z-0 top-6 fas fa-book"></i>
                                <i class=" absolute right-4 text-cyan-300/40 h-16 text-5xl z-0 top-6 fas fa-hand-holding"></i>
                                <strong class="text-4xl">2</strong>
                                <p class="text-lg text-wrap font-bold font-sans">Req Confirm</p>
                               
                            </div>

                            <p class="text-lg bg-cyan-600 text-center py-1 text-white w-full rounded-b-lg">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </p>

                        </div>
                        <div
                            class="size-48 flex flex-col justify-between text-4xl rounded-t-3xl  rounded-b-lg bg-white">
                            <div class="relative p-8 grow space-y-2">
                                <i class=" absolute right-4 text-cyan-600/50  h-16 text-sm  z-10 top-6 fas fa-undo"></i>
                                <i class=" absolute right-4 text-cyan-300/40 h-16 text-6xl top-4 z-0 fas fa-book"></i>
                                <strong class="text-4xl">2</strong>
                                <p class="text-lg text-wrap font-bold font-sans z-20">Returned</p>
                               
                            </div>

                            <p class="text-lg bg-cyan-600 text-center py-1 text-white w-full rounded-b-lg">
                                more info <i class="fas fa-arrow-circle-right"></i>
                            </p>

                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="bg-white/40 backdrop-blur-md border text-x border-white overflow-hidden shadow-sm sm:rounded-lg  ">
                <div class="p-6   text-gray-900 h-full">
                    <div class=" space-y-2">
                        <div class="pb-4">
                            <Strong class="text-4xl font-bold font-mono mb-2">Notifications</Strong>
                        </div>
                      
                        <table class="table-auto w-full text-xl font-mono border-b-2">
                            <thead class="border-y-2 ">
                              <tr class="grid grid-cols-3 py-2">
                                <th class="col-span-2">Title</th>
                                <th>Count</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="grid text-sm grid-cols-3 py-2 pl-3">
                                <td class="col-span-2">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                                <td class="text-center">1961</td>
                              </tr>
                       
                            </tbody>
                          </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
