<x-guest-layout>
    <div class="mb-4 text-sm text-gray-500 text-center">
      {{ $post->published_at?->diffForHumans() }}
    </div>

    <div class="flex items-center justify-center">
      <img
        src="{{ asset('storage/' . $post->img_path) }}"
        alt="illustration du post"
        class="rounded-lg shadow-md w-full max-w-2xl h-auto object-cover object-center"
      />
    </div>

    <div class="mt-6 text-lg text-gray-700 leading-relaxed text-center">
      {!! \nl2br(e($post->body)) !!}
    </div>

    <div class="flex items-center mt-10 border-t border-gray-300 pt-6">
        {{-- Lien vers la page du profile --}}
        <a href="{{ route('profile.show', $post->user) }}">
            <x-avatar class="h-16 w-16 rounded-full shadow-lg" :user="$post->user" />
            <div class="ml-4">
                <div class="text-gray-800 font-semibold text-lg">{{ $post->user->username }}</div>
                <div class="text-gray-500 text-sm">{{ $post->user->email }}</div>
            </div>
        </a>
    </div>
    <div class="mt-10 flex justify-center">
      <a
        href="{{ route('feed') }}"
        class="font-semibold bg-gray-700 text-white px-6 py-2 rounded-lg shadow-md hover:bg-gray-600 transition"
      >
        Retour à la liste des posts
      </a>
    </div>
  </x-guest-layout>
