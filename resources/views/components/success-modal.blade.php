<x-modal name="success" maxWidth="lg" show>
    <div class="w-full block min-h-[40vh] h-auto items-center" style="z-index:150;">
        <button type="button" class="block px-3 py-2 ml-auto font-bold mr-2" x-on:click="show=false">x</button>
        <img src="{{ Storage::url('assets/images/Success.svg') }}" alt="Success" width="100" height="100" class="mx-auto">
        <h1 class="text-[--success] text-2xl text-center mt-3">SUCCESS</h1>
        
        <div class="flex flex-col justify-center items-center h-full">
            <p class="px-4 text-sm text-center leading-5 tracking-normal  mt-5">{{ $message }}</p>
            @php 
                $route = isset($recipeId) ? route($routeName, $recipeId) : route($routeName);
            @endphp
            <a href="{{ $route }}" class="bg-[--success] text-white text-center py-4 w-full font-bold block absolute bottom-0">{{ $buttonLabel }}</a>
        </div>
    </div>
</x-modal>