<x-guest-layout>
    <div class="flex flex-col items-center space-y-4 mt-8">
      <!-- Profile header -->
      <x-avatar class="h-20 w-20 rounded-full shadow-md border-2 border-gray-200" :user="$user" />
      <div class="text-center">
        <div class="text-gray-800 font-bold text-2xl">{{ $user->username }}</div>
        <div class="text-gray-500 text-sm">{{ $user->email }}</div>
      </div>

      <!-- Bio section -->
      <div class="mt-4 text-base text-gray-700 leading-relaxed text-center max-w-2xl mx-auto px-4">
        {!! \nl2br(e($user->bio)) !!}
      </div>
    </div>

    <!-- Posts Grid -->
    <ul class="grid gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mx-auto max-w-screen-lg px-6">
      @foreach ($posts as $post)
        <li class="bg-white rounded-xl shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-lg">
          <x-post-card :post="$post" />
        </li>
      @endforeach
    </ul>

    <!-- Back to feed button -->
    <div class="mt-10 flex justify-center">
        <a
            href="{{ route('feed') }}"
            class="font-medium text-gray-700 hover:text-gray-900 transition-colors hover:underline"
        >
            ← Retour à la liste des posts
        </a>
    </div>

    <div class="mt-10 flex justify-center">
        {{ $posts->links('pagination::tailwind') }}
    </div>

  </x-guest-layout>
