<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-700">Edit Post</h3>
            </div>

            <div class="text-gray-600">
                <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Image Preview and Upload -->
                    <div>
                        <x-input-label for="img_path" :value="__('Image')" class="text-lg font-semibold text-gray-800" />

                        @if ($post->img_path)
                            <!-- Currently stored image -->
                            <img id="preview-image" src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                                class="aspect-auto h-64 rounded shadow mt-3 mb-4 object-cover object-center">
                        @else
                            <!-- If no image is associated yet -->
                            <img id="preview-image" src="#" alt="Image preview" class="aspect-auto h-64 rounded shadow mt-3 mb-4 object-cover object-center" style="display:none;">
                        @endif

                        <!-- Input file for uploading the image -->
                        <x-text-input id="img_path" class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                      type="file" name="img_path" />
                        <x-input-error :messages="$errors->get('img_path')" class="mt-2" />
                    </div>

                    {{-- Script to update the image as soon as one is selected --}}
                    <script>
                        document.getElementById('img_path').addEventListener('change', function(event) {
                            const file = event.target.files[0]; // Get the selected file
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const previewImage = document.getElementById('preview-image');
                                    previewImage.src = e.target.result; // Update the image
                                    previewImage.style.display = 'block'; // Show the image
                                };
                                reader.readAsDataURL(file); // Read the selected file
                            }
                        });
                    </script>

                    <!-- Text Area for Post Body -->
                    <div>
                        <x-input-label for="body" :value="__('Post Text')" class="text-lg font-semibold text-gray-800" />
                        <textarea id="body" name="body" rows="6"
                                  class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                  placeholder="Edit the content of your post here">{{ old('body', $post->body) }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <!-- Optional: Date of Publication -->
                    {{--
                    <div>
                        <x-input-label for="published_at" :value="__('Publication Date')" class="text-lg font-semibold text-gray-800" />
                        <x-text-input id="published_at" class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                      type="date" name="published_at" :value="old('published_at', $post->published_at?->toDateString())" />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>
                    --}}

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <x-primary-button class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
