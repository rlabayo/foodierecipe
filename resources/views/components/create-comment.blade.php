@props(['recipeId'])

<div {{$attributes->merge(['class' => ''])}}>
    <form action="{{ route('comment.add') }}" method="POST" enctype="multipart/form-data" class="w-full">
        @csrf
        <input type="hidden" name="recipe_id" value="{{Crypt::encrypt($recipeId)}}">
        <textarea id="comment" name="comment" class="h-[6rem] w-full text-sm border-[--primary] dark:border-primary dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm" placeholder="Add a comment.">{{ old('comment') }}</textarea>
        <x-input-error :messages="$errors->get('comment')" class="mt-1 mb-2" />
        <x-primary-button>{{ __('Submit comment') }}</x-primary-button>
        @if(session('statusCode') === 201)
            @include('components.success-modal', ['status'=> session('statusCode'), 'message' => session('message'), 'routeName' => 'recipe.show', 'recipeId' => Crypt::encrypt($recipeId), 'buttonLabel' => 'Back to Recipe'])
        @elseif(session('errorStatusCode') != "")
            @include('component.error-modal', ['status'=> session('errorStatusCode'), 'message' => session('message')])
        @endif
    </form>
</div>