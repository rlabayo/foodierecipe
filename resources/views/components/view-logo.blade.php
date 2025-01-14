<button {{ $attributes->merge(['class' => 'bg-white border-[--primary] rounded-full px-2 py-2.5 text-[--primary] font-bold']) }}>
    <!-- <x-tooltip message='View recipe' > -->
        <img src="{{ Storage::url('assets/images/icons/see.svg') }}" alt="View recipe" class="" width="15" height="15" >
    <!-- </x-tooltip> -->
</button>