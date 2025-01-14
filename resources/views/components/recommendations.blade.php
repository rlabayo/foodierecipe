<!-- Display for recommendations-->
<div class="mb-4">
    <ul class="space-y-2">
        <!-- List some of suggested recipe -->
        @foreach($recommendations as $recommendation)
            <li class="px-2">
                @auth
                    <a href="{{ route('recipe.show', Crypt::encrypt($recommendation->id)) }}" alt="{{ $recommendation->title }}" class="text-md  hover:font-semibold">{{ $recommendation->title }}</a>
                @endauth
                @guest
                    <a href="{{ route('guest.show', Crypt::encrypt($recommendation->id)) }}" alt="{{ $recommendation->title }}" class="text-md  hover:font-semibold">{{ $recommendation->title }}</a>
                @endguest
            </li>
        @endforeach
    </ul>
</div>