<button {{ $attributes->merge(['class' => 'bg-white border-[--primary] rounded-full px-2 py-2 text-[--primary] font-bold']) }}>
    <!-- <x-tooltip message='Edit recipe' > -->
        <img src="{{ Storage::url('assets/images/icons/edit.svg') }}" alt="View recipe" class="m-auto" width="15" height="15" >
    <!-- </x-tooltip> -->
</button>