<x-guest-layout>
    <div class="flex justify-center items-center">
        <div class="mt-10 mx-auto p-10 md:w-1/3 w-full bg-white md:shadow-lg shadow-none">
            <img src="{{ Storage::url('assets/images/logo_200x89.png') }}" alt="Logo" class="mx-auto" width="200" height="89">
            <h1 class="text-[--primary] text-2xl font-[600] leading-normal text-center mt-4">
            Create account
            </h1>
            <h2 class="text-[--secondary] text-sm font-[300] leading-normal text-center">
            Input the required details to create an account
            </h2>
            <form method="POST" action="{{ route('register') }}" class="mt-10">
                @csrf

                <!-- Name -->
                <div>
                    <x-text-input id="name" placeholder="Name" aria-placeholder="Name" class="block mt-1 w-full text-[--input-color] text-sm border-[--primary] py-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-text-input id="email" placeholder="Email" aria-placeholder="Email" class="block mt-1 w-full  text-[--input-color] text-sm border-[--primary] py-3" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-text-input id="password" placeholder="Password" aria-placeholder="Password" class="block mt-1 w-full  text-[--input-color] text-sm border-[--primary] py-3"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-text-input id="password_confirmation" placeholder="Confirm Password" aria-placeholder="Confirm Password" class="block mt-1 w-full  text-[--input-color] text-sm border-[--primary] py-3"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button class="w-full justify-center rounded-[5px] py-3 backdrop-blur-[100px] bg-gradient-to-b from-[--primary] via-[#F2AA85] to-[#F6A780] hover:from-white hover:via-white hover:to-white hover:text-[--secondary] hover:border-2 hover:border-[--primary]"  >
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <a class="no-underline text-sm text-gray-600 dark:text-gray-400 hover:text-[--primary] hover:font-bold dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
