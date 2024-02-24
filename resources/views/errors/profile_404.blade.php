<x-app-layout>
    <div class="min-h-[85vh] px-4 mx-auto error_404 flex flex-col justify-center items-center">
        <h1 class="text-center font-bold">404</h1>
        <h2 class="text-center font-semibold">Not Found</h2>
        <p class="text-center mt-6 mb-2">{{ $message }}</p>
        <a href="{{ route('profile.index') }}" alt="Return to Profile" class="inline-flex items-center justify-center px-4 py-2 bg-[--primary] dark:bg-[--primary] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:border-[--primary] hover:text-[--secondary] hover:bg-transparent dark:hover:bg-transparent focus:bg-[--primary] dark:focus:bg-white active:bg-[--primary] active:text-white dark:active:bg-[--primary] dark:active:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 md:w-1/3 w-1/2 mt-4">Return to Profile</a>
    </div>
    @push('style')  
    <style>
        .error_404 h1 {
            font-size:10rem;
            line-height: normal;
            color: var(--primary);
        }

        .error_404 h2 {
            font-size:2rem;
            line-height: normal;
            color: var(--secondary);
            margin-top: -20px;
        }

        .error_404 p {
            font-size:1rem;
            line-height: normal;
            color: var(--secondary);
        }

        @media screen and (min-width: 992px){
            .error_404 h1 {
                font-size: 12rem;
            }

            .error_404 h2 {
                font-size:3rem;
            }
            .error_404 p {
                font-size:1rem;
            }
        }
        
    </style>
    @endpush
</x-app-layout>