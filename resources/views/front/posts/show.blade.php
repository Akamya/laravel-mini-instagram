<x-guest-layout>
    <img src="{{ Storage::url($post->img_path) }}" alt="illustration de l'article">
    <div class="mb-4 text-xs text-gray-500">
        {{ $post->published_at }}
    </div>
    <div>
        {!! \nl2br($post->body) !!}
    </div>
    <a class="font-bold hover:text-emerald-600 transition" href="/">Retour</a>

</x-guest-layout>
