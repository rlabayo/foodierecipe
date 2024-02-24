@props(['recipeId'])

<div {{$attributes->merge(['class' => ''])}}>
    <form action="{{ route('comment.add', $recipeId) }}" method="POST" enctype="multipart/form-data" class="w-full">
        @csrf
        <textarea id="comment" name="comment" class="h-[6rem] w-full text-sm border-[--primary] dark:border-primary dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm" placeholder="Add a comment.">{{ old('comment') }}</textarea>
        <x-input-error :messages="$errors->get('comment')" class="mt-1 mb-2" />
        <x-primary-button>{{ __('Submit comment') }}</x-primary-button>
        @if(session('commentStatus') === 201)
            @include('web.recipe.components.success', ['status'=> 201, 'message' => 'You successfully commented to this recipe.', 'routeName' => 'recipe.show', 'recipeId' => $recipeId, 'buttonLabel' => 'Back to Recipe'])
        @elseif(session('commentStatus') === 400)
            @include('web.recipe.components.error', ['status'=> 400, 'message' => 'Unfortunately we have an issue while submitting your comment. Please try again!'])
        @endif
    </form>
</div>