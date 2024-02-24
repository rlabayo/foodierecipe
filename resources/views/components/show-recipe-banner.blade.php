@push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush
<div style="background-image: url('{{ Storage::url($recipe->image)}}');" {{ $attributes->merge(['class' => 'flex flex-col justify-between bg-fixed bg-cover resize-y md:bg-center bg-center bg-[#D99877]/30 px-4 md:h-[550px] h-[450px]']) }} >
    <div class="flex justify-between pt-4">
        <div class="flex justify-start space-x-1">
            @if(URL::previous() != URL::current())
                <a href="{{ URL::previous() }}">
                    <img src="{{ Storage::url('assets/images/Back.png') }}" alt="Back" width="30" height="30" />
                </a>
            @endif
        </div>
        <div class="flex justify-end space-x-1">
            @auth
                @if($recipe->is_favorite == '1' && $recipe->user_id != auth()->user()->id)
                    <div>
                        <a href="{{ route('favorite.remove', $recipe->favorite_id) }}">
                            <img src="{{ Storage::url('assets/images/Remove.png') }}" alt="Add favorite" class="rounded-full" width="25" height="25" >
                        </a>
                    </div>
                    
                @elseif($recipe->is_favorite == '0' && $recipe->user_id != auth()->user()->id)
                    <div>
                        <a href="{{ route('favorite.add', $recipe->id) }}">
                            <x-add-logo></x-add-logo>
                        </a>
                    </div>
                @endif

                @if($recipe->user_id == auth()->user()->id)
                    <div>
                        <a href="{{ route('recipe.edit', $recipe->id) }}">
                            <x-edit-logo></x-edit-logo>
                        </a>
                    </div>
                    <div>
                        <form action="{{ route('recipe.delete', $recipe->id) }}" method="POST" class="delete_form">
                            @csrf
                            @method('delete')
                            <x-trash-icon type="submit" class="block" ></x-trash-icon>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    @if($recipe->video_url != '')
        <div class="flex justify-center">
            <a href="{{ $recipe->video_url }}" rel="noreferrer" target="__blank" class="px-12 py-2 bg-[--primary] rounded shadow-lg text-white font-semibold mb-[-20px]">Watch Video</a>
        </div>
    @endif
</div>
  
@push('script')
    <script>
    $(document).ready(function(){
        $('.delete_form').on('submit', function(){
            if(confirm("Are you sure you want to delete it?"))
            {
                return true;
            }
            else
            {
                return false;
            }
        });
    });
    </script>
@endpush