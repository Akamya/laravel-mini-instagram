<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-700">Créer un post</h3>
            </div>

            <form method="POST" action="{{ route('posts.store') }}" class="space-y-6 text-gray-600" enctype="multipart/form-data">
                @csrf

                <!-- Image Preview -->
                <div class="mt-4">
                    <img id="imagePreview" class="w-80 h-80 object-cover rounded-lg shadow-md" src="#" alt="Image preview" style="display: none;" />
                </div>

                <!-- Image Upload -->
                <div>
                    <x-input-label for="img_path" :value="__('Image')" class="text-lg font-semibold text-gray-800" />
                    <x-text-input id="img_path" class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" type="file" name="img_path" accept="image/*" onchange="previewImage(event)" />
                    <x-input-error :messages="$errors->get('img_path')" class="mt-2" />

                </div>

                {{-- Script pour mettre à jour l'image dès qu'on en sélectionne une --}}
                <script>
                    function previewImage(event) {
                        const file = event.target.files[0];
                        const preview = document.getElementById('imagePreview');

                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.style.display = 'none';
                        }
                    }
                </script>


                <!-- Text Area for Post Body -->
                <div>
                    <x-input-label for="body" :value="__('Texte du post')" class="text-lg font-semibold text-gray-800" />
                    <textarea id="body" name="body" rows="6"
                              class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                              placeholder="Écrivez ici le contenu de votre post">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>

                <!-- Optional: Date of Publication -->
                {{--
                <div>
                    <x-input-label for="published_at" :value="__('Date de publication')" class="text-lg font-semibold text-gray-800" />
                    <x-text-input id="published_at" class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                  type="date" name="published_at" :value="old('published_at')" />
                    <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                </div>
                --}}

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <x-primary-button class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        {{ __('Créer') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
