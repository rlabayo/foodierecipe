<div class="flex flex-col w-full mt-10 md:px-10 px-4 text-[--secondary] mb-10">
    <h1 class="text-[--text-secondary] md:text-[48px] text-[40px] text-center font-semibold md:leading-normal leading-[3rem]">
        {{ $recipe->title }}
    </h1>
    <p class="text-[--text-secondary] text-md text-center font-[300] md:leading-normal leading-[1.2rem]">
        {{ $recipe->summary }}
    </p>
    <div class="mt-4">
        <h2 class="md:text-2xl text-xl font-semibold">Ingredients:</h2>
        <ul class="px-4 mx-4 list-disc">
            @foreach(json_decode($recipe->ingredients,true) as $ingredient)
                <li>
                    {{ $ingredient['item'] }}
                </li>
            @endforeach
        </ul type="disc">
    </div>
    <div class="mt-10">
        <h2 class="md:text-2xl text-xl font-semibold">Directions:</h2>
        <ol class="mx-4 list-decimal space-y-4" id="customlist">
            @foreach(json_decode($recipe->instruction,true) as $instruction)
                <li>
                    <p>{{ $instruction['instruction_item'] }}</p>
                    @if($instruction['attached_photo'] != '')
                        <img src="{{ Storage::url($instruction['attached_photo']) }}" alt="Instruction photo" class="w-[400px] mx-auto rounded-md shadow-md">
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
<style>
    #customlist {
        /* delete default counter */
        list-style-type: none;
        /* create custom counter and set it to 0 */
        counter-reset: elementcounter;
    }

    #customlist>li:before {
        /* print out "Element " followed by the current counter value */
        content: "Step " counter(elementcounter);
        /* increment counter */
        counter-increment: elementcounter;
        font-weight: bold;
        display: block;
        font-size:1.2rem;
    }
</style>