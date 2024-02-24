<x-guest-layout>
    <div class="flex justify-center items-center">
        <div class="mt-10 mx-auto p-10 md:w-1/3 w-full bg-white md:shadow-lg shadow-none">
            <img src="{{ Storage::url('assets/images/logo_200x89.png') }}" alt="Logo" class="mx-auto" width="200" height="89">
            <h1 class="text-[--primary] text-2xl font-[600] leading-normal text-center mt-4">
                Log In
            </h1>
            <h2 class="text-[--secondary] text-sm font-[300] leading-normal text-center">
            Input the required details to log in
            </h2>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-10 w-full mx-auto">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" placeholder="Username" aria-placeholder="Username" class="block mt-1 w-full text-[--secondary] text-sm border-[--primary] py-3 hover:outline-offset dark:bg-white dark:border-[--primary]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-text-input id="password" placeholder="Password" aria-placeholder="Password" class="block mt-1 w-full text-[--secondary] text-sm border-[--primary] py-3 hover:outline-offset dark:bg-white dark:border-[--primary]"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                
                <div class="mt-4">
                    <x-primary-button class="w-full justify-center rounded-[5px] py-3 backdrop-blur-[100px] bg-gradient-to-b from-[--primary] via-[#F2AA85] to-[#F6A780] hover:from-white hover:via-white hover:to-white hover:text-[--secondary] hover:border-2 hover:border-[--primary]"  >
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                <div class="flex flex-wrap items-center justify-center mt-4">
                    @if (Route::has('password.request'))
                        <p class="text-[#5C636E] text-sm">
                            {{ __('Don’t have an account yet? ') }}
                        </p>
                        <a class="no-underline text-sm text-[--primary] font-bold dark:text-gray-400 hover:text-[--secondary] dark:hover:text-[--secondary] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 md:ml-2" href="{{ route('register') }}">
                         Create account
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
