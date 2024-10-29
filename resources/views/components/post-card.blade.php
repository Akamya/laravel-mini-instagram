<a class="flex flex-col h-full bg-white rounded-lg shadow-md p-5 w-full transition transform hover:shadow-xl hover:scale-105"
    href="{{ route('front.posts.show', $post) }}">

    <div class="flex items-center space-x-3 mb-4">
        <x-avatar class="h-10 w-10 rounded-full shadow border-2 border-gray-200" :user="$post->user" />
        <div class="text-gray-800 text-sm font-semibold">{{ $post->user->username }}</div>
        @if(isset($followingIds) && in_array($post->user_id, $followingIds))
            <x-heroicon-s-user-group class="h-5 w-5 text-gray-500" /> <!-- Ajustement de taille et couleur -->
        @endif
    </div>

    <img class="w-full rounded-lg object-cover mb-4 h-48" src="{{ Storage::url($post->img_path) }}" alt="illustration du post" />

    <div class="flex-grow text-gray-700 text-sm text-justify mb-4">
        {{ Str::limit($post->body, 120) }}
    </div>

    <div class="flex justify-between items-center text-gray-500 text-sm">
        <div class="italic">{{ $post->published_at->diffForHumans() }}</div>

        <div class="flex items-center space-x-2">
            <x-heroicon-s-heart class="h-5 w-5 text-pink-400" />
            <span>{{ $post->likes_count }}</span>
        </div>

        <div class="flex items-center space-x-2">
            <x-heroicon-o-chat-bubble-bottom-center-text class="h-5 w-5 text-blue-400" />
            <span>{{ $post->comments_count }}</span>
        </div>
    </div>
</a>
