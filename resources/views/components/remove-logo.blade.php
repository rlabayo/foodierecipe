<button {{ $attributes->merge(['class' => 'bg-white border-[--primary] rounded-full px-2 py-3.5 text-[--primary] font-bold']) }}>
    <!-- <x-tooltip message='Remove recipe' > -->
        <img src="{{ Storage::url('assets/images/icons/minus.svg') }}" alt="Remove recipe" class="m-auto" width="15" height="15" >
    <!-- </x-tooltip> -->
</button>
