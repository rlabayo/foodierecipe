<div class="mb-10">
    <ul class="flex space-x-1 "> 
        @foreach($breadcrumbs as $key => $item)
            @if($key == 0)
                <li><a href="{{ url($item['url']) }}" alt="{{$item['title']}}" class="hover:text-black hover:font-bold">{{$item['title']}}</a></li>
            @else
                <li>/</li>
                @if($item['url'] != "")
                    <li><a href="{{ url($item['url']) }}" alt="{{$item['title']}}" class="hover:text-black hover:font-bold">{{$item['title']}}</a></li>
                @else
                    <li> {{$item['title']}}</li>
                @endif
            @endif
        @endforeach
    </ul>
</div>