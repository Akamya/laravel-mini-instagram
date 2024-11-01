<x-guest-layout>
    <div class="w-11/12 md:w-3/5 mx-auto px-4 mb-8"> <!-- Marges latérales réduites -->
        <div class="mb-4 text-xs text-gray-500">
            {{ $post->published_at->format('d M Y H:i') }}
        </div>

        <div class="flex items-center justify-center mb-4">
            <img src="{{ asset('storage/' . $post->img_path) }}" alt="illustration of the post"
                class="rounded-lg shadow-lg max-w-full w-full h-auto object-cover object-center" />
        </div>

        <div class="flex mb-4 justify-end w-full"> <!-- Alignement à droite -->
            @if ($hasLiked)
                <form action="{{ route('front.posts.like.delete', $post) }}" method="POST" class="flex items-center">
                    @csrf @method('DELETE')
                    <button type="submit" class="font-bold bg-white text-red-500 hover:text-red-700 px-4 py-2 rounded-lg shadow transition">
                        <x-heroicon-s-heart class="h-5 w-5" />
                    </button>
                </form>
            @else
                <form action="{{ route('front.posts.like.add', $post) }}" method="POST" class="flex items-center">
                    @csrf
                    <button type="submit" class="font-bold bg-white text-gray-500 hover:text-red-500 px-4 py-2 rounded-lg shadow transition">
                        <x-heroicon-o-heart class="h-5 w-5" />
                    </button>
                </form>
            @endif
            <div class="flex items-center space-x-2 ml-4">
                <div class="text-sm text-gray-500">{{ $likesCount }}</div>
            </div>
        </div>

        <div class="mt-4 text-gray-700">{!! \nl2br(e($post->body)) !!}</div>

        <div class="flex mt-8 items-center">
            <a href="{{ route('profile.show', $post->user) }}">
                <x-avatar class="h-20 w-20" :user="$post->user" />
            </a>
            <div class="ml-4 flex flex-col justify-center">
                <a href="{{ route('profile.show', $post->user) }}">
                    <div class="text-gray-700 font-semibold">{{ $post->user->username }}</div>
                </a>
                <div class="text-gray-500">{{ $post->user->email }}</div>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center">
            <a href="{{ route('feed') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition hover:bg-gray-100">
                Back to post list
            </a>
        </div>

        <div class="mt-8">
            <h2 class="font-bold text-xl mb-4">Comments</h2>

            <div class="flex-col space-y-4">
                @forelse ($comments as $comment)
                    <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                        <div class="flex justify-start items-start h-full">
                            <a href="{{ route('profile.show', $comment->user) }}">
                                <x-avatar class="h-10 w-10" :user="$comment->user" />
                            </a>
                        </div>
                        <div class="flex flex-col justify-center w-full space-y-2">
                            <div class="flex justify-between">
                                <div class="flex space-x-4 items-center">
                                    <div class="flex flex-col justify-center">
                                        <a href="{{ route('profile.show', $comment->user) }}">
                                            <div class="text-gray-700 font-semibold">{{ $comment->user->username }}</div>
                                        </a>
                                        <div class="text-gray-500 text-sm">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
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
                        No comments yet
                    </div>
                @endforelse
                @auth
                <form action="{{ route('front.posts.comments.add', $post) }}" method="POST" class="flex bg-white rounded-md shadow p-4 mt-4">
                    @csrf
                    <div class="flex justify-start items-start h-full mr-4">
                        <x-avatar class="h-10 w-10" :user="auth()->user()" />
                    </div>
                    <div class="flex flex-col justify-center w-full">
                        <div class="text-gray-700 font-semibold">{{ auth()->user()->username }}</div>
                        <div class="text-gray-500 text-sm">{{ auth()->user()->email }}</div>
                        <div class="text-gray-700">
                            <textarea name="body" id="body" rows="4" placeholder="Your comment"
                                class="w-full rounded-md shadow-sm border border-gray-300 bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-4"></textarea>
                        </div>
                        <div class="text-gray-700 mt-2 flex justify-end">
                            <button type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition hover:bg-gray-100">
                                Add a comment
                            </button>
                        </div>
                    </div>
                </form>
                @else
                    <div class="flex bg-white rounded-md shadow p-4 text-gray-700 justify-between items-center">
                        <span>You must be logged in to add a comment</span>
                        <a href="{{ route('login') }}" class="font-bold text-gray-700 px-4 py-2 rounded-lg shadow-md">Log in</a>
                    </div>
                @endauth
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
