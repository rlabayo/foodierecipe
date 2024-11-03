<x-app-layout>
    <div class="min-h-[85vh] mx-auto max-w-6xl">
        <div class="py-4 px-4">
            <p class="text-[--secondary] text-sm my-4">About {{$total_items}} {{$total_items > 1 ? 'results' : 'result'}} for <span class="italic font-semibold">{{$param}}</span></p>
            <hr class="my-4 font-semibold">
            @if($items->count() > 0)
                <h1 class="text-[--secondary] text-2xl font-semibold">Recipes</h1>
                <div class="flex mt-4 flex-wrap justify-start px-1">
                    @foreach($items as $item)
                        <x-card-recipe class="flex flex-col bg-cover rounded-xl md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:pt-2 pt-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" :item="$item" ></x-card-recipe>
                    @endforeach
                </div>
                <div class="my-4">
                    {{$items->links()}}
                </div>
            @else
                <p class=" text-sm">Your search did not match any recipe or profile.</p>
            @endif
        </div>
    </div>
</x-app-layout>
