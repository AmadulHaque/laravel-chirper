<x-app-layout>
    <div class="py-12" >
        <div  class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" >
                @csrf
                @method('patch')
                <textarea
                    name="description"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('message', $post->description) }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <input type="file" name="image" class="" />
                <img class="w-12/6" src="{{$post->getFirstMediaUrl()}}" />
                <div class="mt-4 space-x-2">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('posts.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>