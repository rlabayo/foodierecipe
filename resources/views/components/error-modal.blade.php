<x-modal name="error" maxWidth="lg" show>
    <div class="w-full block min-h-[40vh] h-auto" style="z-index:150;">
        <button type="button" class="block px-3 py-2 ml-auto font-bold mr-2" x-on:click="show=false">x</button>
        <img src="{{ Storage::url('assets/images/Error.svg') }}" alt="Error" width="75" height="75" class="mx-auto">
        <h1 class="text-[--error] text-2xl text-center mt-3">ERROR</h1>
        
        <div class="flex flex-col justify-center items-center h-full">
            <p class="px-4 text-md text-center leading-5 tracking-normal  mt-5">{{ $message }}</p>
        </div>
    </div>
</x-modal>