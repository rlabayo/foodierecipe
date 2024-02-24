<x-guest-layout>
    <div class="flex justify-center items-center">
        <div class="mt-10 mx-auto p-10 md:w-1/3 w-full bg-white">
            <img src="{{ Storage::url('assets/images/logo_200x89.png') }}" alt="Logo" class="mx-auto" width="200" height="89">

            <div class="my-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button class="w-full justify-center rounded-[5px] py-3 backdrop-blur-[100px] bg-gradient-to-b from-[--primary] via-[#F2AA85] to-[#F6A780] hover:from-white hover:via-white hover:to-white hover:text-[--secondary] hover:border-2 hover:border-[--primary]"  >
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
