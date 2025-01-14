<button {{ $attributes->merge(['class' => 'bg-white border-[--primary] rounded-full px-2 py-1 text-[--primary] font-bold']) }}>
    <x-tooltip message='Private recipe' >
        <img src="{{ Storage::url('assets/images/icons/private.svg') }}" alt="Private recipe" class="" width="15" height="15"/>
    </x-tooltip>
</button>