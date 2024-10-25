<x-guest-layout>
  <h1 class="text-center font-bold text-2xl mb-8 text-gray-800">Liste des posts</h1>

  <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mx-auto max-w-screen-lg px-4">
    @foreach ($posts as $post)
      <li class="bg-white rounded-lg shadow-lg overflow-hidden">
        <x-post-card :post="$post" />
      </li>
    @endforeach
  </ul>

  <div class="mt-10 flex justify-center">
    {{ $posts->links('pagination::tailwind') }}
  </div>
</x-guest-layout>
