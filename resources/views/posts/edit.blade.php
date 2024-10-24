<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between mt-8">
                <div class=" text-2xl">
                    Modifier un post
                </div>
            </div>

            <div class="text-gray-500">
                <form method="POST" action="{{ route('posts.update', $post) }}" class="flex flex-col space-y-4"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="img_path" :value="__('Image')" />

                        @if ($post->img_path)
                            <!-- Image actuellement stockée -->
                            <img id="preview-image" src="{{ asset('storage/' . $post->img_path) }}" alt="Image du post"
                                class="aspect-auto h-64 rounded shadow mt-2 mb-4 object-cover object-center">
                        @else
                            <!-- Si aucune image n'est encore associée -->
                            <img id="preview-image" src="#" alt="Aperçu de l'image" class="aspect-auto h-64 rounded shadow mt-2 mb-4 object-cover object-center" style="display:none;">
                        @endif

                        <!-- Input file pour uploader l'image -->
                        <x-text-input id="img_path" class="block mt-1 w-full" type="file" name="img_path" />

                        <x-input-error :messages="$errors->get('img_path')" class="mt-2" />
                    </div>

                    {{-- Script pour mettre à jour l'image dès qu'on en sélectionne une --}}
                    <script>
                        document.getElementById('img_path').addEventListener('change', function(event) {
                            const file = event.target.files[0]; // Récupère le fichier sélectionné

                            if (file) {
                                const reader = new FileReader();

                                reader.onload = function(e) {
                                    const previewImage = document.getElementById('preview-image');
                                    previewImage.src = e.target.result; // Met à jour l'image
                                    previewImage.style.display = 'block'; // Affiche l'image
                                }

                                reader.readAsDataURL(file); // Lit le fichier sélectionné
                            }
                        });
                    </script>


                    <div>
                        <x-input-label for="body" :value="__('Texte du post')" />
                        <textarea id="body"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            name="body" rows="10">{{ old('body', $post) }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    {{-- <div>
                        <x-input-label for="published_at" :value="__('Date de publication')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="date" name="published_at"
                            :value="old('published_at', $post->published_at?->toDateString())" />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div> --}}

                    <div class="flex justify-end">
                        <x-primary-button type="submit">
                            {{ __('Modifier') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
