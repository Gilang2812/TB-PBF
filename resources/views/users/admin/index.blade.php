<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mx-8 mt-8 space-y-8">
                        
                        <div>
                            <form action="{{ route('users.index') }}" method="GET">
                                <div class="flex justify-between items-center rounded-lg w-full bg-[#7c68ee1f] border-none shadow-[0_4px_4px_0px_rgba(0,0,0,0.25)]">
                                    <input
                                        class="border-none bg-transparent w-full h-full p-4 text-slate-500 rounded-lg focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-400"
                                        type="text" name="search" id="search" placeholder="search" value="{{ request('search') }}">
                                    <button type="submit" class="px-4">
                                        <svg width="36" height="28" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M25.6458 23.0833H24.0329L23.4612 22.5321C25.4621 20.2046 26.6667 17.1829 26.6667 13.8958C26.6667 6.56625 20.7254 0.625 13.3958 0.625C6.06625 0.625 0.125 6.56625 0.125 13.8958C0.125 21.2254 6.06625 27.1667 13.3958 27.1667C16.6829 27.1667 19.7046 25.9621 22.0321 23.9612L22.5833 24.5329V26.1458L32.7917 36.3337L35.8337 33.2917L25.6458 23.0833ZM13.3958 23.0833C8.31208 23.0833 4.20833 18.9796 4.20833 13.8958C4.20833 8.81208 8.31208 4.70833 13.3958 4.70833C18.4796 4.70833 22.5833 8.81208 22.5833 13.8958C22.5833 18.9796 18.4796 23.0833 13.3958 23.0833Z" fill="#6284F9"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="max-md:overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead>
                                    <tr class="bg-gray-50 text-center">
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nomor</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nim</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-center">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4">{{ $user->nim }}</td>
                                            <td class="px-6 py-4">{{ $user->name }}</td>
                                            <td class="px-6 py-4">{{ $user->email }}</td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">Edit</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $users->links() }} <!-- Add pagination links if using Laravel pagination -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
