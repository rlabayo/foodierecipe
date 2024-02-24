<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account profile's avatar.") }}
        </p>
    </header>

    <form method="post" action="{{ route('avatar.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <div class="w-1/2">
            <x-input-label for="avatar" :value="__('')" />
            <x-input-file name="avatar" id="avatar" :updateValue="auth()->user()->profile->image" :width="150" :height="150" />
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        @push('script')
            <script src="{{ Storage::url('assets/js/photo_preview.js') }}"></script>
        @endpush

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @elseif (session('status') === 'error')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-red-600 dark:text-red-600"
                >{{ __('Error.') }}</p>
            @endif
        </div>
    </form>
</section>
