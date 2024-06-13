<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required />
                        </div>
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password (leave blank if not changing)')" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                        </div>
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                        </div>
                        <div class="mt-4">
                            <x-label for="image" :value="__('Image (leave blank if not changing)')" />
                            <x-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="mt-2 w-20 h-20 rounded-full">
                            @endif
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
