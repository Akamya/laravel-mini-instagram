<div>
  <a
    class="flex flex-col h-full bg-white rounded-lg shadow-md p-5 w-full transform transition hover:shadow-lg hover:scale-105"
    href="{{ route('front.posts.show', $post) }}"
  >
    <div class="mb-4">
      <img
        src="{{ Storage::url($post->img_path) }}"
        alt="illustration du post"
        class="w-full h-48 object-cover rounded-md"
      />
    </div>

    <div class="flex-grow text-gray-700 text-sm text-justify">
      {{ Str::limit($post->body, 120) }}
    </div>

    <div class="mt-4 text-xs text-gray-500">
      {{ $post->published_at?->format('d M Y') }}
    </div>
  </a>
</div>
