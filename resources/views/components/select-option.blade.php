<select {{ $attributes->merge(['class' => 'inline-flex items-center bg-white text-sm border-[--input-border] dark:border-[--input-border] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--secondary] focus:ring-[--primary] dark:focus:ring-[--secondary] rounded-md shadow-sm'])}}>
    <option value="">Select a {{$field}}</option>
    @foreach($lists as $item)
        @if ($value == $item->value)
            <option value="{{$item->value}}" selected >{{$item->name}}</option>
        @else
            <option value="{{$item->value}}" >{{$item->name}}</option>
        @endif
    @endforeach
</select>