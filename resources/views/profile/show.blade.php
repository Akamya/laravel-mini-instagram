<x-guest-layout>
    <div class="flex flex-col items-center space-y-4 mt-8">
      <!-- Profile header -->
      <x-avatar class="h-20 w-20 rounded-full shadow-md border-2 border-gray-200" :user="$user" />
      <div class="text-center">
        <div class="text-gray-800 font-bold">{{ $user->username }}</div>
        <div class="text-gray-700 text-sm">{{ $user->email }}</div>
        <div class="text-gray-500 text-xs">
            Membre depuis {{ $user->created_at->diffForHumans() }}
        </div>
      </div>

      <div class="flex">
        @if ($isFollowing)
            <form action="{{ route('profile.show.unfollow', $user) }}" method="POST" class="flex p-4">
                @csrf @method('DELETE')
                <button type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                    <x-heroicon-c-user-minus class="h-5 w-5"/>
                </button>
            </form>
        @else
            <form action="{{ route('profile.show.follow', $user) }}" method="POST" class="flex p-4">
                @csrf
                <button type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                    <x-heroicon-c-user-plus class="h-5 w-5" />
                </button>
            </form>
        @endif
        <div class="flex items-center space-x-2">
            <div class="text-sm text-gray-500">{{ $followersCount }}</div>
        </div>
    </div>

      <!-- Bio section -->
      <div class="mt-4 text-base text-gray-700 leading-relaxed text-center max-w-2xl mx-auto px-4">
        {!! \nl2br(e($user->bio)) !!}
      </div>
    </div>

    <!-- Posts Grid -->
    <h2 class="font-bold text-xl mb-4">Posts</h2>
    <ul class="grid gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mx-auto max-w-screen-lg px-6">
      @forelse ($posts as $post)
        <li class="bg-white rounded-xl shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-lg">
          <x-post-card :post="$post" />
        </li>
        @empty
        <div class="text-gray-700">Aucun post</div>
      @endforelse
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

    <div class="mt-8">
        <h2 class="font-bold text-xl mb-4">Commentaires</h2>

        <div class="flex-col space-y-4">
          @forelse ($comments as $comment)
          <div class="flex bg-white rounded-md shadow p-4 space-x-4">
            <div class="flex justify-start items-start h-full">
              <x-avatar class="h-10 w-10" :user="$comment->user" />
            </div>
            <div class="flex flex-col justify-center w-full space-y-4">
              <div class="flex justify-between">
                <div class="flex space-x-4 items-center justify-center">
                  <div class="flex flex-col justify-center">
                    <div class="text-gray-700">{{ $comment->user->username }}</div>
                    <div class="text-gray-500 text-sm">
                      {{ $comment->created_at->diffForHumans() }}
                    </div>
                  </div>
                </div>
                <div class="flex justify-center">
                  @can('delete', $comment)
                  <button
                    x-data="{ id: {{ $comment->id }} }"
                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-comment-deletion');"
                    type="submit"
                    class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow"
                  >
                    <x-heroicon-o-trash class="h-5 w-5" />
                  </button>
                  @endcan
                </div>
              </div>
              <div class="flex flex-col justify-center w-full text-gray-700">
                <p class="border bg-gray-100 rounded-md p-4">
                  {{ $comment->body }}
                </p>
              </div>
            </div>
          </div>
          @empty
          <div class="flex bg-white rounded-md shadow p-4 space-x-4">
            Aucun commentaire pour l'instant
          </div>
          @endforelse
        </div>
        <x-modal name="confirm-comment-deletion" focusable>
          <form
            method="post"
            onsubmit="event.target.action= '/posts/{{ $post->id ?? 1 }}/comments/' + window.selected"
            class="p-6"
          >
            @csrf @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
              Êtes-vous sûr de vouloir supprimer ce commentaire ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
              Cette action est irréversible. Toutes les données seront supprimées.
            </p>

            <div class="mt-6 flex justify-end">
              <x-secondary-button x-on:click="$dispatch('close')">
                Annuler
              </x-secondary-button>

              <x-danger-button class="ml-3" type="submit">
                Supprimer
              </x-danger-button>
            </div>
          </form>
        </x-modal>
      </div>

  </x-guest-layout>
