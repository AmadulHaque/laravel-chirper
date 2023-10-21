<x-app-layout>
    <div class="py-12">
        <div  class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" >
                @csrf
                <textarea name="description_en" required placeholder="{{ __('English What\'s on your mind?') }}"class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <textarea name="description_bn" required placeholder="{{ __('Bangla What\'s on your mind?') }}"class="mt-3 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                <input type="file" name="image" class="" />
                <x-primary-button class="mt-4">{{ __('Posts') }}</x-primary-button>
            </form>

            <div class="mt-6  divide-y">

            @foreach ($posts as $post)

                <div class="p-6 bg-white shadow-sm rounded-lg  flex space-x-2" style="margin-bottom: 15px;" >

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $post->user->name }}</span>

                                <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a') }}</small>

                                @unless ($post->created_at->eq($post->updated_at))

                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>

                                @endunless

                            </div>
                            @if ($post->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('posts.edit', $post)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('posts.destroy', $post)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif

                        </div>

                        <p class="mt-4 text-lg text-gray-900">{{ $post->description }}</p>
                        <img class="w-12/6" src="{{$post->ImageThumb}}" />
                    </div>

                </div>

            @endforeach

            </div>
        </div>

    </div>
</x-app-layout>
