<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-semibold text-gray-700">Liste des posts</h3>

                        <div class="flex items-center space-x-4">
                            <a href="{{ route('posts.create') }}"
                               class="text-white font-bold bg-blue-500 hover:bg-blue-600 transition px-4 py-2 rounded flex items-center">
                                <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Ajouter un post
                            </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Image</th>
                                    <th class="py-3 px-6 text-left">Texte</th>
                                    <th class="py-3 px-6 text-left">Likes</th>
                                    <th class="py-3 px-6 text-left">Commentaires</th>
                                    <th class="py-3 px-6 text-left">Date de publication</th>
                                    <th class="py-3 px-6 text-left">Dernière modification</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @foreach ($posts as $post)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition">
                                        <td class="py-3 px-6 text-left">
                                            <img src="{{ Storage::url($post->img_path) }}" alt="Image du post" class="h-16 w-16 rounded-lg object-cover">
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ Str::limit($post->body, 120) }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $post->likes_count }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $post->comments_count }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $post->published_at?->format('d M Y à H:i') ?? 'Pas de date' }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $post->updated_at->diffForHumans() }}
                                        </td>
                                        <td class="py-3 px-6 flex justify-center space-x-4">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700 transition">
                                                <x-heroicon-o-pencil class="w-5 h-5" /> Éditer
                                            </a>
                                            <button x-data="{ id: {{ $post->id }} }"
                                                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-post-deletion');"
                                                    class="text-red-500 hover:text-red-700 transition">
                                                <x-heroicon-o-trash class="w-5 h-5" /> Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal name="confirm-post-deletion" focusable>
            <form method="post" onsubmit="event.target.action= '/posts/' + window.selected" class="p-6">
                @csrf
                @method('DELETE')
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Êtes-vous sûr de vouloir supprimer ce post ?</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Cette action est irréversible. Toutes les données seront supprimées.</p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
                    <x-danger-button class="ml-3" type="submit">Supprimer</x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
