<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <div class="max-w-5xl mx-auto pt-4 pb-4 px-6 bg-white shadow-lg sm:rounded-lg my-10">
        <h1 class="text-[--secondary] text-2xl font-semibold text-center md:mt-10 mt-2">Edit Recipe</h1>
        <div class="flex flex-wrap mt-4 md:gap-2 gap-[.1rem] justify-center">
            @if (session('message'))
                <div class="text-red-500 font-bold">
                    {{ session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('recipe.update', $recipe->id) }}" class="w-full max-w-2xl" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                <div class="my-4">
                    <x-input-label for="image" :value="__('Image:')" class="font-semibold"/>
                    <x-input-file name="image" id="image" :value="old('image')" :width="1000" :height="559" update_value="{{ $recipe->image }}" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    <p class="text-sm w-full">Recommendation: Compress images before uploading using <a href="https://tinypng.com/" alt="Tinyfy" class="text-red-500 font-bold">Tinyfy</a></p>
                </div>
                <div class="my-4">
                    <x-input-label for="title" :value="__('Title:')"  class="font-semibold"/>
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $recipe->title }}" placeholder="Title" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="summary" :value="__('Summary:')"  class="font-semibold"/>
                    <x-text-input id="summary" class="block mt-1 w-full" type="text" name="summary" value="{{ $recipe->summary }}" placeholder="Summary" autofocus />
                    <x-input-error :messages="$errors->get('summary')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="video_url" :value="__('Video URL:')"  class="font-semibold"/>
                    <x-text-input id="video_url" class="block mt-1 w-full" type="text" name="video_url" value="{{ $recipe->video_url }}" placeholder="Video URL" autofocus />
                    <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="private" :value="__('Is private?')"  class="font-semibold"/>
                    <x-select-option name="private" id="private" field="privacy status" :lists="$boolean" value="{{ $recipe->private }}" class="" />
                    <x-input-error :messages="$errors->get('private')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="is_draft" :value="__('Is draft?')"  class="font-semibold"/>
                    <x-select-option name="is_draft" id="is_draft" field="privacy status" :lists="$boolean" value="{{ $recipe->is_draft }}" class="" />
                    <x-input-error :messages="$errors->get('is_draft')" class="mt-2" />
                </div>
                <div class="flex flex-col my-4">
                    <x-input-label for="Ingredients" :value="__('Ingredients:')"  class="font-semibold"/>
                    <div class="w-full mb-6 md:mb-0">
                        <div id="items">
                            
                        </div>

                        <!-- For ingredients item entry -->
                        <div class="flex mt-4 gap-1">
                            <div class="w-2/3 text-center">
                                <x-text-input id="ingredients_item" class="block mt-1 w-full" type="text" placeholder="Ingredients item" autofocus />
                            </div>
                            <div class="w-1/3 flex justify-center items-center text-center ">
                                <button type="button" class="rounded-full py-2 px-4 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" id="add_item">+</button>
                            </div>
                        </div>
                        <!-- End for ingredients item entry -->
                    </div>
                    <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    <input type="hidden" name="ingredients" id="ingredients" value="{{ $recipe->ingredients }}" />
                </div>
                <div class="flex items-center gap-1 my-4">
                    <x-input-label for="instruction" :value="__('Instructions:')"  class="font-semibold"/>
                </div>
                <!-- <div class="flex flex-col items-center my-4"> -->
                    <!-- For instruction entry -->

                    <!-- <x-input-label for="instruction_item" class="mr-auto" :value="__('Input Step')" /> -->
                    <div class="w-full space-y-1 my-4" id="instructions">
        
                    </div>
                    <div>
                        <div class="flex shadow-md space-x-2 items-center rounded-md border-sm border-[#F2AA85] ring-[#F2AA85] m-auto my-auto text-sm">
                            <div class="md:w-2/3 w-1/2">
                                <textarea name="instruction_item" id="instruction_item" cols="60" rows="10" style="max-width:100%;" class="max-h-[14rem] md:h-[14rem] h-[11rem] resize-none mx-1 mt-1.5 ring-0 border-0 outline-none w-full text-sm border-[--input-border] dark:border-[--input-border] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--secondary] focus:ring-[--primary] dark:focus:ring-[--secondary] rounded-md shadow-sm" placeholder="Add Instruction"></textarea>
                            </div>
                            <div class="relative items-end justify-center md:w-1/3 w-1/2 bg-[#F2AA85] hover:bg-white rounded-md border-2 border-sm hover:border-2 border-[#F2AA85] ring-[#F2AA85] border-dashed shadow-md" id="image_button_container">
                                <label class="flex flex-col w-full my-auto h-full"> 
                                    <div id="preview_photo" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem]  hover:bg-blend-darken hover:rounded-md">
                                        <img src="{{Storage::url('assets/images/icons/img_logo.svg')}}" alt="Image logo" class="m-auto my-auto py-1" />
                                        <span class="text-center text-[12px] py-1 px-2 leading-tight">File size maximum of 2mb</span>
                                    </div>
                                    <input type="file" class="opacity-0 hidden" id="photo_attachment" onchange="select_photo()" />
                                </label>
                            </div>
                            <div class="">  
                                <button type="button" class="rounded-full py-2 px-4 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" id="add_instruction">+</button>
                            </div>
                        </div>
                        <span class="w-full inline-flex text-sm text-red-600 space-y-1 text-center" id="instruction_error"></span>
                        <!-- <input type="hidden" name="instruction" id="instruction" /> -->
                        <input type="hidden" id="count" value="1"/>
                    </div>
        
                    <!-- End for instruction entry -->

                    <x-input-error :messages="$errors->get('instruction')" class="mt-2 mr-auto" />
                    <input type="hidden" name="instruction" id="instruction" value="{{ $recipe->instruction }}" />
                <!-- </div> -->
                <div class="my-6 mx-auto md:w-1/3 w-full"> 
                    <x-primary-button class="w-full">{{ __('Update') }}</x-primary-button>
                    @if(session('status') === 201)
                        @include('web.recipe.components.success', ['status'=> 200, 'message' => 'Recipe was successfully updated!', 'routeName' => 'recipe.show', 'recipeId' => $recipe->id, 'buttonLabel' => 'Back'])
                    @elseif(session('status') === 400)
                        @include('web.recipe.components.error', ['status'=> 200, 'message' => "Unfortunately we have an issue while updating your recipe. Please try again!"])
                    @endif
                </div>
            </form>
        </div>
    </div>
                    
@push('script')
    <!-- Ingredients -->
    <script src="{{ Storage::url('assets/js/ingredients/iterate_ingredients.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/add_ingredient.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/remove_ingredient.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/update_ingredient.js') }}" defer></script>
    
    <!-- Instructions -->
    <script src="{{ Storage::url('assets/js/instructions/iterate_instructions_on_update.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/add_instruction.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/add_instruction_item.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/remove_image.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/remove_instruction.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/reset_image_container.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/select_photo.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/update_instruction_json_data.js') }}" defer></script>

    <!-- Banner -->
    <script src="{{ Storage::url('assets/js/photo_preview.js') }}" defer></script>
@endpush
</x-app-layout>