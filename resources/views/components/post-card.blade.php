<a class="flex flex-col h-full space-y-4 bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition"
    href="{{ route('front.posts.show', $post) }}">
    <img src="{{ Storage::url($post->img_path) }}" alt="illustration du post" />
    <div class="flex-grow text-gray-700 text-sm text-justify">
        {{ Str::limit($post->body, 120) }}
    </div>
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-500">
            {{ $post->published_at->diffForHumans() }}
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon-o-chat-bubble-bottom-center-text class="h-5 w-5 text-gray-500" />
            <div class="text-sm text-gray-500">{{ $post->comments_count }}</div>
        </div>
    </div>
</a>
