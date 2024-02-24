<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <div class="max-w-7xl mx-auto pt-10 pb-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-[--secondary] text-2xl font-semibold">New Recipe</h1>
        <div class="flex mt-4 flex-wrap md:gap-2 gap-[.1rem] md:justify-center justify-between md:p-4 p-0">
            @if (session('message'))
                <div class="text-red-500 font-bold">
                    {{ session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('recipe.store') }}" class="w-full" enctype="multipart/form-data">
                @csrf
                
                <div class="my-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" placeholder="Title" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="summary" :value="__('Summary')" />
                    <x-text-input id="summary" class="block mt-1 w-full" type="text" name="summary" :value="old('summary')" placeholder="Summary" autofocus />
                    <x-input-error :messages="$errors->get('summary')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="image" :value="__('Image attachment')" />
                    <x-input-file name="image" id="image"/>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="my-4">
                    <x-input-label for="video_url" :value="__('Video URL')" />
                    <x-text-input id="video_url" class="block mt-1 w-full" type="text" name="video_url" :value="old('video_url')" placeholder="Video URL" autofocus />
                    <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="unit" :value="__('Unit')" />
                    <x-select-option name="unit" id="unit" field="unit" :lists="$units" class="" />
                    <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                </div>
                <div class="my-4"> 
                    <x-input-label for="private" :value="__('Is private?')" />
                    <x-select-option name="private" id="private" field="privacy status" :lists="$boolean" class="" />
                    <x-input-error :messages="$errors->get('private')" class="mt-2" />
                </div>
                <div class="flex flex-col my-4">
                    <x-input-label for="Ingredients" :value="__('Ingredients:')" />
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <div class="flex mt-4 gap-1">
                            <div class="w-1/2 text-center">
                                <x-input-label for="amount" :value="__('Amount')" />
                            </div>
                            <div class="w-1/2 text-center">
                                <x-input-label for="ingredient_name" :value="__('Ingredient Name')" />
                            </div>
                            <div class="w-1/2 text-center">
                                <x-input-label for="action" :value="__('Action')" />
                            </div>
                        </div>
                        <div id="items">
                            
                        </div>

                        <!-- For ingredients item entry -->
                        <div class="flex mt-4 gap-1">
                            <div class="w-1/2 text-center">
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" placeholder="Amount" autofocus />
                            </div>
                            <div class="w-1/2 text-center">
                                <x-text-input id="ingredient_name" class="block mt-1 w-full" type="text" placeholder="Name" autofocus />
                            </div>
                            <div class="w-1/2 flex justify-center items-center text-center ">
                                <button type="button" id="add_item" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold">+</button>
                            </div>
                        </div>
                        <!-- End for ingredients item entry -->
                    </div>
                    <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    <input type="hidden" name="ingredients" id="ingredients" value="{{ old('ingredients') }}" />
                </div>
                <div class="flex items-center gap-1 my-4">
                    <x-input-label for="instruction" :value="__('Instruction')" />
                </div>
                <div class="flex flex-col items-center gap-1 my-4">
                    <div id="instruction_items" class="w-full gap-1">

                    </div>

                    <!-- For instruction entry -->
                    <div class="flex w-full items-center gap-1 my-4">
                        <div class="w-1/2">
                            <textarea id="instruction_item" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            <span class="text-sm text-red-600 space-y-1 mt-2" id="instruction_item_error"></span>
                        </div>
                        <div class="w-1/2 h-[10rem] flex flex-col items-center">
                            <div class="flex">
                                <label class="flex flex-col">
                                    <div id="preview_photo" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken" style="display:none">

                                    </div>
                                    <div id="select_photo" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">
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
                    <input type="hidden" name="instruction" id="instruction" value="{{ old('instruction') }}" />
                </div>
                <div class="my-6"> 
                    <button type="submit" class="w-full text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="border-radius: 5px;background: linear-gradient(0deg, rgba(255, 255, 255, 0.20) 0%, rgba(255, 255, 255, 0.20) 100%), linear-gradient(270deg, #FFAF87 9.49%, #F2AA85 50.31%, #F6A780 87.71%);backdrop-filter: blur(100px);">Post</button>
                </div>
            </form>
        </div>
    </div>
@push('script')
    <script >
        $(document).ready(function(){
            // for ingredients
            var list = $('#ingredients').val();
            var item_length = 0;
            
            // if ingredients is not empty
            // display the list
            if(list != ''){
                var ingredients_items = jQuery.parseJSON(list)
                
                if(ingredients_items.length > 0){
                    item_length = ingredients_items.length
                    for(var i = 0; i < ingredients_items.length; i++){
                        var items = '<div class="item item'+ i +' flex mt-4 gap-1">'+
                                    '<div class="w-1/3 text-center">'+
                                        '<input name="amount" onchange="change_ingredient_data()" value="'+ ingredients_items[i].amount +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="number" placeholder="Amount" autofocus />'+
                                    '</div>'+
                                    '<div class="w-1/3 text-center">'+
                                        '<input name="ingredient_name" onchange="change_ingredient_data()" value="'+ ingredients_items[i].ingredient_name +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" placeholder="Name" autofocus />'+
                                    '</div>'+
                                    '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                        '<button type="button" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold" onclick="remove('+ i +')">-</button>'+
                                    '</div>'+
                                '</div>';
                        
                        $('#items').append(items);
                    }
                }
            }
            
            $('#add_item').click(function(){
                var amount = $('#amount').val();
                var ingredient_name = $('#ingredient_name').val();

                if($('#amount').val() != "" && $('#ingredient_name').val() != ""){
                    var items = '<div class="item item'+item_length+' flex mt-4 gap-1">'+
                                    '<div class="w-1/3 text-center">'+
                                        '<input name="amount" onchange="change_ingredient_data()" value="'+ amount +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="number" placeholder="Amount" autofocus />'+
                                    '</div>'+
                                    '<div class="w-1/3 text-center">'+
                                        '<input name="ingredient_name" onchange="change_ingredient_data()" value="'+ ingredient_name +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" placeholder="Name" autofocus />'+
                                    '</div>'+
                                    '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                        '<button type="button" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold" onclick="remove('+ item_length +')">-</button>'+
                                    '</div>'+
                                '</div>';

                    $('#items').append(items);

                    var data = $('.item').map(function() {
                        return {
                            ingredient_name: $(this).find('[name="ingredient_name"]').val(),
                            amount: $(this).find('[name="amount"]').val(),
                        };
                    }).get();

                    $('#ingredients').val(JSON.stringify(data));

                    // clear fields
                    $('#ingredient_name').val('');
                    $('#amount').val('');
                }
                item_length += 1;
            });
            // end for ingredients

            // for instruction items
            var instruction_list = $('#instruction').val();
            var instruction_item_length = 1;
            
            // if instruction is not empty
            if(instruction_list != ''){
                var instruction_items = jQuery.parseJSON(instruction_list)
                
                if(instruction_items.length > 0){
                    instruction_item_length = instruction_items.length + 1;
                    for(var j = 0; j < instruction_items.length; j++){
                        var items = '<div class="item_instruction item_instruction'+  j  +' flex w-full items-center gap-1 my-4">'+
                                    '<div class="w-1/2">'+
                                        '<textarea name="instruction_item" onchange="change_instruction_item()" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">' + instruction_items[ j ].instruction_item + '</textarea>'+
                                    '</div>'+
                                    '<div class="w-1/2 h-[10rem] flex flex-col items-center">'+
                                        '<div class="flex">'+
                                            '<label class="flex flex-col">'+
                                                '<div id="preview_photo_'+ j +'" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">'+
                                                    '<img src="'+ instruction_items[ j ].attached_photo +'" alt="Preview Image" class="max-h-36 my-auto" />'+
                                                    '<input type="hidden" name="attached_hidden" id="attached_hidden_'+  j  +'" value="'+ instruction_items[ j ].attached_photo +'"/>'+
                                                '</div>'+
                                                '<input type="file" class="opacity-0 hidden" id="photo_attachment_'+ j +'" onchange="update_photo('+ j +')"/>'+
                                            '</label>'+
                                            '<span class="text-sm text-red-600 space-y-1 mt-2" id="file_error_'+ j +'"></span>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                        '<button type="button" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold" onclick="remove_item('+  j  +')">-</button>'+
                                    '</div>'+
                                '</div>';
                        $('#instruction_items').append(items);
                    }
                }
            }

            $('#instruction_item').change(function(){
                $('#instruction_item_error').html('');
            });

            $('#add_instruction_item').click(function(){
                // change display mode
                document.getElementById('select_photo').style.display = '';
                document.getElementById('preview_photo').style.display = 'none';
                $('#instruction_item_error').html('');

                var instruction_item = $('#instruction_item').val()
                var attached_src = $('#attached_photo').attr('src')

                if(instruction_item != "") {
                    var items = '<div class="item_instruction item_instruction'+ instruction_item_length +' flex w-full items-center gap-1 my-4">'+
                                    '<div class="w-1/2">'+
                                        '<textarea name="instruction_item" onchange="change_instruction_item()" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">' + instruction_item + '</textarea>'+
                                    '</div>'+
                                    '<div class="w-1/2 h-[10rem] flex flex-col items-center">'+
                                        '<div class="flex">'+
                                            '<label class="flex flex-col">'+
                                                '<div id="preview_photo_'+instruction_item_length+'" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">'+
                                                    '<img src="'+ attached_src +'" alt="Preview Image" class="max-h-36 my-auto" />'+
                                                    '<input type="hidden" name="attached_hidden" id="attached_hidden_'+ instruction_item_length +'" value="'+ attached_src +'"/>'+
                                                '</div>'+
                                                '<input type="file" class="opacity-0 hidden" id="photo_attachment_'+instruction_item_length+'" onchange="select_photo('+instruction_item_length+')"/>'+
                                            '</label>'+
                                            '<span class="text-sm text-red-600 space-y-1 mt-2" id="file_error_'+instruction_item_length+'"></span>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                        '<button type="button" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold" onclick="remove_item('+ instruction_item_length +')">-</button>'+
                                    '</div>'+
                                '</div>';
                    $('#instruction_items').append(items);
                                
                    var data = $('.item_instruction').map(function() {
                        return {
                            instruction_item: $(this).find('[name="instruction_item"]').val(),
                            attached_photo: $(this).find('[name="attached_hidden"]').val(),
                        };
                    }).get();
                    
                    $('#instruction').val(JSON.stringify(data));

                    $('#instruction_item').val('')
                    $('#attached_hidden').val('')
                    $('#attached_photo').attr('src', '')
                }else {
                    $('#instruction_item_error').html('Please enter value of instruction.');
                }
                instruction_item_length += 1;
            });

            // end for instruction items
            
        });

        // for ingredients
        function remove(id){
            $('.item'+id).remove();

            // update json
            var data = $('.item').map(function() {
                return {
                    ingredient_name: $(this).find('[name="ingredient_name"]').val(),
                    amount: $(this).find('[name="amount"]').val(),
                };
            }).get();
            $('#ingredients').val(JSON.stringify(data));
        }

        function change_ingredient_data(){
            // update json
            var data = $('.item').map(function() {
                return {
                    ingredient_name: $(this).find('[name="ingredient_name"]').val(),
                    amount: $(this).find('[name="amount"]').val(),
                };
            }).get();
            $('#ingredients').val(JSON.stringify(data));
        }
        // end for ingredients


        // for instructions
        function remove_item(id){
            $('.item_instruction'+id).remove();

            // update json
            var data = $('.item_instruction').map(function() {
                return {
                    instruction_item: $(this).find('[name="instruction_item"]').val(),
                    attached_photo: $(this).find('[name="attached_hidden"]').val(),
                };
            }).get();

            $('#instruction').val(JSON.stringify(data));
        }
        // end for instructions

        // for instruction items 
        function select_photo(id = 0){
            if(id > 0) {
                var attachment = document.getElementById('photo_attachment_' + id);

                const [file] = attachment.files
                
                var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'images/webp'];

                document.getElementById('file_error_' + id).innerHTML = "";

                if(!filetypes.includes(file.type)){
                    document.getElementById('file_error_' + id).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
                }else{

                    if (file) {
                        encodeImageFileAsURL(attachment.files, id)

                        // document.getElementById('select_photo').style.display = 'none';
                        // document.getElementById('preview_photo').style.display = '';
                        // document.getElementById('preview_photo').innerHTML = "";
                        // document.getElementById('preview_photo').innerHTML = '<img src="'+ URL.createObjectURL(file) +'" alt="Preview Image" class="max-h-36 my-auto" id="attached_photo" />';
                    }
                }

            }else {
                var attachment = document.getElementById('photo_attachment');

                const [file] = attachment.files
                var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'images/webp'];

                document.getElementById('file_error').innerHTML = "";

                if(!filetypes.includes(file.type)){
                    document.getElementById('file_error').innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
                }else{

                    if (file) {
                        encodeImageFileAsURL(attachment.files)

                        // document.getElementById('select_photo').style.display = 'none';
                        // document.getElementById('preview_photo').style.display = '';
                        // document.getElementById('preview_photo').innerHTML = "";
                        // document.getElementById('preview_photo').innerHTML = '<img src="'+ URL.createObjectURL(file) +'" alt="Preview Image" class="max-h-36 my-auto" id="attached_photo" />';
                    }
                }
            }
        }

        function update_photo(id){
            var attachment = document.getElementById('photo_attachment_' + id);

            const [file] = attachment.files

            var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'images/webp'];

            document.getElementById('file_error_' + id).innerHTML = "";

            if(!filetypes.includes(file.type)){
                document.getElementById('file_error_' + id).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
            }else{

                if (file) {
                    encodeImageFileAsURL(attachment.files, id, true)
                }
            }
        }

        function change_instruction_item(){
            // update json data
            var data = $('.item_instruction').map(function() {
                return {
                    instruction_item: $(this).find('[name="instruction_item"]').val(),
                    attached_photo: $(this).find('[name="attached_hidden"]').val(),
                };
            }).get();

            $('#instruction').val(JSON.stringify(data));
        }

        function encodeImageFileAsURL(imageData, id, is_update = false) {
            var filesSelected = imageData;

            if (filesSelected.length > 0) {
                var fileToLoad = filesSelected[0];

                var fileReader = new FileReader();

                fileReader.onload = function(fileLoadedEvent) {
                    var srcData = fileLoadedEvent.target.result; // <--- data: base64

                    var newImage = document.createElement('img');
                    newImage.src = srcData;
 
                    if(id > 0 || is_update == true) {
                        // document.getElementById('select_photo_' + id).style.display = 'none';
                        document.getElementById('preview_photo_' + id).style.display = '';
                        document.getElementById('preview_photo_' + id).innerHTML = "";
                        document.getElementById('preview_photo_' + id).innerHTML = '<img src="'+ newImage.src +'" alt="Preview Image" class="max-h-36 my-auto" id="attached_photo_'+id+'" /><input type="hidden" name="attached_hidden" id="attached_hidden_'+ id +'" value="'+ newImage.src +'"/>';
                        
                        // document.getElementById('attached_hidden_' + id).value = newImage.src;

                        // update json data
                        var data = $('.item_instruction').map(function() {
                            return {
                                instruction_item: $(this).find('[name="instruction_item"]').val(),
                                attached_photo: $(this).find('[name="attached_hidden"]').val(),
                            };
                        }).get();

                        $('#instruction').val(JSON.stringify(data));
                    }else{
                        document.getElementById('select_photo').style.display = 'none';
                        document.getElementById('preview_photo').style.display = '';
                        document.getElementById('preview_photo').innerHTML = "";
                        document.getElementById('preview_photo').innerHTML = '<img src="'+ newImage.src +'" alt="Preview Image" class="max-h-36 my-auto" id="attached_photo" />';
                        
                    }
                    
                    // document.getElementById("preview_photo").innerHTML = newImage.outerHTML;
                    // alert("Converted Base64 version is " + document.getElementById("preview_photo").innerHTML);
                    // console.log("Converted Base64 version is " + document.getElementById("preview_photo").innerHTML);
                }
                fileReader.readAsDataURL(fileToLoad);
                
            }
        }
    </script>
    <script src="{{ Storage::url('assets/js/photo_preview.js') }}"></script>
@endpush
</x-app-layout>