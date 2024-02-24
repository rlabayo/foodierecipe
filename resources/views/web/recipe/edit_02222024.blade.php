<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <div class="max-w-5xl mx-auto pt-4 pb-4 px-6 bg-white shadow-lg sm:rounded-lg my-10">
        <h1 class="text-[--secondary] text-2xl font-semibold text-center mt-10">Update Recipe</h1>
        <div class="flex flex-wrap mt-4 md:gap-2 gap-[.1rem] justify-center">
            @if (session('message'))
                <div class="text-red-500 font-bold">
                    {{ session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('recipe.update', $recipe->id) }}" class="w-full" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                <div class="my-4">
                    <x-input-label for="image" :value="__('Image Banner:')" class="font-semibold"/>
                    <x-input-file name="image" id="image" :value="old('image')" update_value="{{ $recipe->image }}" :width="1000" :height="559"  />
                    <p class="italic text-[12px] mt-4"> Recommended image dimension: 1435x559px</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="title" :value="__('Title:')" class="font-semibold"/>
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $recipe->title }}" placeholder="Title" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="summary" :value="__('Summary:')" class="font-semibold"/>
                    <x-text-input id="summary" class="block mt-1 w-full" type="text" name="summary" value="{{ $recipe->summary }}" placeholder="Summary" autofocus />
                    <x-input-error :messages="$errors->get('summary')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="video_url" :value="__('Video URL:')" class="font-semibold"/>
                    <x-text-input id="video_url" class="block mt-1 w-full" type="text" name="video_url" value="{{ $recipe->video_url }}" placeholder="Video URL" autofocus />
                    <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="private" :value="__('Is private?')" class="font-semibold"/>
                    <x-select-option name="private" id="private" field="privacy status" :lists="$boolean" value="{{ $recipe->private }}"  class="" />
                    <x-input-error :messages="$errors->get('private')" class="mt-2" />
                </div>
                <div class="flex flex-col my-4">
                    <x-input-label for="Ingredients" :value="__('Ingredients:')" class="font-semibold"/>
                    <div class="w-full mb-6 md:mb-0">
                        <div id="items">
                            
                        </div>

                        <!-- For ingredients item entry -->
                        <div class="flex mt-4 gap-1">
                            <div class="w-2/3 text-center">
                                <x-text-input id="ingredients_item" class="block mt-1 w-full" type="text" placeholder="Ingredients item" autofocus />
                            </div>
                            <div class="w-1/3 flex justify-center items-center text-center ">
                                <button type="button" id="add_item" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold">+</button>
                            </div>
                        </div>
                        <!-- End for ingredients item entry -->
                    </div>
                    <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    <input type="hidden" name="ingredients" id="ingredients" value="{{ $recipe->ingredients }}"/>
                </div>
                <div class="flex items-center gap-1 my-4">
                    <x-input-label for="instruction" :value="__('Instruction:')" class="font-semibold"/>
                </div>
                <div class="flex flex-col items-center gap-1 my-4">
                    <div id="instruction_items" class="w-full gap-1">

                    </div>

                    <!-- For instruction entry -->
                    <div class="flex w-full items-center gap-1 my-4">
                        <div class="w-1/2">
                            <textarea id="instruction_item" class="h-[10rem] w-full border-[--primary] dark:border-primary dark:bg-[--input-dark-bg-color] dark:text-[--primary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm"></textarea>
                            <span class="text-sm text-red-600 space-y-1 mt-2" id="instruction_item_error"></span>
                        </div>
                        <div class="w-1/2 h-[10rem] flex flex-col items-center">
                            <div class="flex items-center h-[9rem] justify-center w-full hover:bg-[#ffc5a82e] hover:bg-blend-darken">
                                <label class="flex flex-col">
                                    <div id="preview_photo" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken" style="display:none">

                                    </div>
                                    <div id="select_photo" class="flex flex-col items-center justify-center w-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <p class="pt-1 px-2 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                            Select a photo (If any)</p>
                                    </div>
                                    <input type="file" class="opacity-0 hidden" id="photo_attachment" onchange="select_photo()"/>
                                </label>
                                <span class="text-sm text-red-600 space-y-1 mt-2" id="file_error"></span>
                            </div>

                            <x-input-error :messages="$errors->get('instruction_attachment')" class="mt-2" />
                        </div>
                        <div class="w-1/3 flex justify-center items-center text-center ">
                            <button type="button" id="add_instruction_item" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold">+</button>
                        </div>
                    </div>
                    <!-- End for instruction entry -->

                    <x-input-error :messages="$errors->get('instruction')" class="mt-2 mr-auto" />
                    <input type="hidden" name="instruction" id="instruction" value="{{ $recipe->instruction }}" />
                </div>
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
    <input type="hidden" id="base_url" value="{{ URL::to('/') }}" />
@push('script')
    <script src="{{ Storage::url('assets/js/ingredients/iterate_ingredients.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/add_ingredient.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/remove_ingredient.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/ingredients/update_ingredient.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/update_iterate_instructions.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/add_instruction.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/update_instruction.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/remove_instruction.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/remove_instruction_image.js') }}" defer></script>
    <!-- Processing of photo -->
    <script src="{{ Storage::url('assets/js/instructions/select_photo.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/update_photo.js') }}" defer></script>
    <script src="{{ Storage::url('assets/js/instructions/encode_image_file.js') }}" defer></script>
    <!-- End for processing of photo -->
    
    <script src="{{ Storage::url('assets/js/photo_preview.js') }}"></script>
@endpush
</x-app-layout>