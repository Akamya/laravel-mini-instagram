<x-guest-layout>
    <h1 class="font-bold text-2xl mb-6 text-center text-gray-800">List of posts</h1>

    <form action="{{ route('feed') }}" method="GET" class="mb-4 mx-4 md:mx-8">
      <div class="flex items-center">
        <input
          type="text"
          name="search"
          id="search"
          placeholder="Search a user or a post"
          class="flex-grow border border-gray-300 rounded shadow px-4 py-2 mr-4"
          value="{{ request()->search }}"
          autofocus
        />
        <button
          type="submit"
          class="bg-white text-gray-600 px-4 py-2 rounded-lg shadow"
        >
          <x-heroicon-o-magnifying-glass class="h-5 w-5" />
        </button>
      </div>
    </form>

    <ul class="grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-8 mx-4 md:mx-8">
      @foreach ($posts as $post)
      <li>
        <x-post-card :post="$post" :followingIds="$followingIds" />
      </li>
      @endforeach
    </ul>

    <div class="mt-8 mx-4 md:mx-8 mb-8">
        <div class="justify-center">
            {{ $posts->links() }}
        </div>
    </div>

</x-guest-layout>
