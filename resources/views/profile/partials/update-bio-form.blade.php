<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Biography') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Share something about yourself. This will appear on your public profile.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.bio.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="bio" :value="__('Biography')" />
            <textarea
                id="bio"
                name="bio"
                class="mt-1 block w-full h-32 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Write something about yourself..."
                required
            >{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'bio-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
