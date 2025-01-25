<div class="max-w-6xl mx-auto my-16 px-4">
    <h2 class="text-center text-4xl md:text-5xl font-bold mb-8">Users</h2>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($users as $user)
            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-center">
                        <img class="w-24 h-24 rounded-full shadow-lg object-cover"
                            src="{{ $user->avatar ?? 'https://placehold.co/200x200/' }}" alt="{{ $user->name }}'s profile">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="text-xl font-medium text-gray-900">
                            {{ $user->name }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            {{ $user->email }}
                        </span>

                        <div class="flex justify-center gap-3 mt-4">
                            <x-secondary-button>
                                Add Friend
                            </x-secondary-button>

                            <x-primary-button wire:click="message({{ $user->id }})">
                                Message
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>