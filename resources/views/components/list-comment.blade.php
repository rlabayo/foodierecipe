@props(['comments, totalComments', 'recipeId'])

<div {{$attributes->merge(['class' => ''])}} id="comments">
    @php $comment_label = $totalComments <= 1 ? 'comment' : 'comments' @endphp 

    <p class="text-[--secondary] mt-10">{{ $totalComments }} {{ $comment_label }}</p>
    @foreach($comments as $comment)
        <div class="my-3 shadow-md shadow-[#d7957926] p-4 text-[--secondary]" x-data={show_{{$comment->id}}:false}>
            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <img src="{{ Storage::url($comment->profile_thumbnail) }}" alt="Profile thumbnail" width="45" height="45" class="rounded-full"/>
                    <div>
                        <h6 class="text-sm font-semibold">{{ $comment->profile_name }}</h6>
                        <p class="text-[12px]">{{ date('F d, Y', strtotime($comment->created_at)) }} at {{date('h:i a', strtotime($comment->created_at))}}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        @if($comment->user_id == auth()->user()->id)
                            <button @click="show_{{$comment->id}} = !show_{{$comment->id}}" class="ml-auto">
                                <img src="{{ Storage::url('assets/images/icons/edit.svg') }}" alt="Edit comment" width="17" height="17">
                            </button>
                        @endif

                        @if($comment->user_id == auth()->user()->id || $recipeCreator == auth()->user()->id)
                            <form action="{{ route('comment.destroy', Crypt::encrypt($comment->id)) }}" method="POST" class="mt-2">
                                @csrf
                                @method('delete')
                                <button class="ml-auto">
                                    <img src="{{ Storage::url('assets/images/icons/trash.svg') }}" alt="Delete comment" width="17" height="17">
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="my-4 px-6">
                <p>{{ $comment->comment }}</p>
                <div id="comment_container_{{$comment->id}}" class="mt-2" x-show="show_{{$comment->id}}">
                    <form method="POST" action="{{ route('comment.update') }}" enctype="multipart/form-data" class="w-full">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="recipe_id" value="{{Crypt::encrypt($comment->id)}}" />
                        <textarea name="comment" class="h-[6rem] w-full text-sm border-[--primary] dark:border-primary dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm">{{ $comment->comment }}</textarea>
                        <x-input-error :messages="$errors->get('comment')" class="mt-1 mb-2" />
                        <x-primary-button>{{ __('Update comment') }}</x-primary-button>
                        @if(session('statusCode') === 200)
                            @include('components.success-modal', ['status'=> session('statusCode'), 'message' => session('message'), 'routeName' => 'recipe.show', 'recipeId' => Crypt::encrypt($recipeId), 'buttonLabel' => 'Back to Recipe'])
                        @elseif(session('errorStatusCode') != "")
                            @include('component.error-modal', ['status'=> session('errorStatusCode'), 'message' => session('message')])
                        @endif
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <div id="paginate" class="my-2 pagination paginate-sm">
        {{ $comments->onEachSide(3)->fragment('comments')->links() }}
    </div>

</div>