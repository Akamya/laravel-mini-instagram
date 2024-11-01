<x-guest-layout>
    <div class="flex flex-col items-center space-y-6 mt-10">
        <div class="flex flex-col items-center space-y-2">
            @if ($isFollowing)
                <form action="{{ route('profile.show.unfollow', $user) }}" method="POST" class="flex items-center space-x-2 mt-2"> <!-- Form for unfollowing -->
                    @csrf @method('DELETE')
                    <button type="submit" class="flex items-center font-bold bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
                        <x-heroicon-c-user-minus class="h-6 w-6" />
                        <span class="ml-1">Unfollow</span>
                    </button>
                </form>
            @else
                <form action="{{ route('profile.show.follow', $user) }}" method="POST" class="flex items-center space-x-2 mt-2"> <!-- Form for following -->
                    @csrf
                    <button type="submit" class="flex items-center font-bold bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
                        <x-heroicon-c-user-plus class="h-6 w-6" />
                        <span class="ml-1">Follow</span>
                    </button>
                </form>
            @endif
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1">
                    <div class="text-lg text-gray-600 font-semibold">{{ $followersCount }}</div>
                    <p class="text-gray-500">Followers</p>
                </div>

                <div class="flex items-center space-x-1">
                    <x-heroicon-s-user-group class="h-6 w-6 text-gray-600" />
                    <div class="text-lg text-gray-600 font-semibold">{{ $followingCount }}</div>
                    <p class="text-gray-500">Following</p>
                </div>
            </div>
        </div>
        <!-- Profile header -->
        <x-avatar class="h-32 w-32 rounded-full shadow-md border-4 border-gray-200" :user="$user" />
        <div class="text-center">
            <div class="text-gray-800 font-bold text-2xl">{{ $user->username }}</div>
            <div class="text-gray-700 text-lg">{{ $user->email }}</div>
            <div class="text-gray-500 text-sm">
                Member since {{ $user->created_at->format('d M Y ') }}
            </div>
        </div>
    </div>

    <!-- Bio section -->
    <div class="mt-10 mb-24 text-lg text-gray-700 leading-relaxed text-center max-w-2xl mx-auto px-4">
        {!! \nl2br(e($user->bio)) !!}
    </div>

    <!-- Posts Grid -->
    <div class="w-11/12 md:w-3/5 mx-auto px-4 mb-8">
        <h2 class="font-bold text-2xl mb-6 text-gray-800 text-center">Posts</h2>

        <ul class="grid gap-8 mt-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mx-auto max-w-screen-lg px-6">
            @forelse ($posts as $post)
                <li class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl w-full">
                    <x-post-card :post="$post" />
                </li>
            @empty
                <div class="text-gray-700 text-lg text-center">No posts available</div>
            @endforelse
        </ul>


        <div class="mt-8 flex items-center justify-center">
            <a href="{{ route('feed') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition hover:bg-gray-100">
                Back to post list
            </a>
        </div>

        <div class="mt-10 flex justify-center">
            {{ $posts->links('pagination::tailwind') }}
        </div>

        <div class="mt-8">
            <h2 class="font-bold text-xl mb-4">Comments</h2>

            <div class="flex-col space-y-4">
                @forelse ($comments as $comment)
                    <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                        <div class="flex justify-start items-start h-full">
                            <x-avatar class="h-10 w-10" :user="$comment->user" />
                        </div>
                        <div class="flex flex-col justify-center w-full space-y-2">
                            <div class="flex justify-between">
                                <div class="flex space-x-4 items-center justify-between">
                                    <div class="flex flex-col justify-center">
                                        <div class="text-gray-700 font-semibold">{{ $comment->user->username }}</div>
                                        <div class="text-gray-500 text-sm">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <a href="{{ route('front.posts.show', $comment->post_id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200">
                                        <x-heroicon-o-arrow-uturn-left class="h-5 w-5" />
                                    </a>
                                </div>

                                <div class="flex justify-center">
                                    @can('delete', $comment)
                                        <button x-data="{ id: {{ $comment->id }} }"
                                            x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-comment-deletion');"
                                            type="button" class="font-bold text-red-500 hover:text-red-700">
                                            <x-heroicon-o-trash class="h-5 w-5" />
                                        </button>
                                    @endcan
                                </div>
                            </div>
                            <div class="text-gray-700">
                                <p class="border border-gray-300 bg-gray-100 rounded-md p-4">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                        No comments available.
                    </div>
                @endforelse
            </div>
        </div>

        <x-modal name="confirm-comment-deletion" focusable>
            <form method="post"
                onsubmit="event.target.action= '/posts/{{ $post->id }}/comments/' + window.selected"
                class="p-6">
                @csrf @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this comment?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    This action is irreversible. All data will be lost.
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>

                    <x-danger-button class="ml-3" type="submit">
                        Delete
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-guest-layout>
