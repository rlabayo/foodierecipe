<button {{ $attributes->merge(['class' => 'bg-transparent px-2 py-2 ']) }}>
    <x-tooltip message='Unfavorite' >
        <img src="{{ Storage::url('assets/images/icons/favorite.svg')}}" alt="Add favorite" width="25" height="25">
    </x-tooltip>
</button>