<x-modal name="success" maxWidth="lg" show>
    <div class="w-full block min-h-[40vh] h-auto" style="z-index:150;">
        <button class="block px-3 py-2 dark:text-[--secondary] ml-auto font-bold mr-2" x-on:click="show=false">x</button>
        <img src="{{ Storage::url('assets/images/Success.svg') }}" alt="Success" width="100" height="100" class="mx-auto">
        <h1 class="text-[--success] text-2xl text-center mt-3">SUCCESS</h1>
        
        <div class="flex flex-col justify-center items-center h-full">
            <p class="px-4 text-sm text-center leading-5 tracking-normal dark:text-white mt-5"></p>
            
        </div>
    </div>
</x-modal>