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
                                '<div class="w-2/3 text-center">'+
                                    '<input name="ingredients_item" onchange="change_ingredient_data()" value="'+ ingredients_items[i].item +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" autofocus />'+
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
        var ingredients_item = $('#ingredients_item').val();

        if($('#ingredients_item').val() != ""){
            var items = '<div class="item item'+item_length+' flex mt-4 gap-1">'+
                            '<div class="w-2/3 text-center">'+
                                '<input name="ingredients_item" onchange="change_ingredient_data()" value="'+ ingredients_item +'" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" autofocus />'+
                            '</div>'+
                            '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                '<button type="button" class="bg-[--primary] rounded-full px-4 py-2 text-white font-bold" onclick="remove('+ item_length +')">-</button>'+
                            '</div>'+
                        '</div>';

            $('#items').append(items);

            var data = $('.item').map(function() {
                return {
                    item: $(this).find('[name="ingredients_item"]').val(),
                };
            }).get();

            $('#ingredients').val(JSON.stringify(data));

            // clear fields
            $('#ingredients_item').val('');
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
                if(instruction_items[j].attached_photo != 'undefined'){
                    var items = '<div class="item_instruction item_instruction'+  j  +' flex w-full items-center gap-1 my-4">'+
                                '<div class="w-1/2">'+
                                    '<textarea name="instruction_item" onchange="change_instruction_item()" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">' + instruction_items[ j ].instruction_item + '</textarea>'+
                                '</div>'+
                                '<div class="w-1/2 h-[10rem] flex flex-col items-center">'+
                                    '<div class="flex">'+
                                        '<label class="flex flex-col">'+
                                            '<div id="preview_photo_'+ j +'" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">'+
                                                '<img src="'+ instruction_items[j].attached_photo +'" alt="Preview Image" class="max-h-36 my-auto" />'+
                                                '<input type="hidden" name="attached_hidden" id="attached_hidden_'+  j  +'" value="'+ instruction_items[j].attached_photo +'"/>'+
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
                }else{
                    var items = '<div class="item_instruction item_instruction'+  j  +' flex w-full items-center gap-1 my-4">'+
                            '<div class="w-1/2">'+
                                '<textarea name="instruction_item" onchange="change_instruction_item()" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">' + instruction_items[ j ].instruction_item + '</textarea>'+
                            '</div>'+
                            '<div class="w-1/2 h-[10rem] flex flex-col items-center">'+
                                '<div class="flex">'+
                                    '<label class="flex flex-col">'+
                                        '<div id="preview_photo_'+ j +'" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">'+
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20" fill="currentColor">'+
                                                '<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />'+
                                            '</svg>'+
                                            '<p class="pt-1 px-2 text-sm tracking-wider text-gray-400 group-hover:text-gray-600"> Select a photo (If any)</p>'+
                                            '<input type="hidden" name="attached_hidden" id="attached_hidden_'+  j  +'" value="'+ instruction_items[j].attached_photo +'"/>'+
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
                }
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
            if(attached_src != undefined && attached_src != ''){
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
            }else{
                var items = '<div class="item_instruction item_instruction'+ instruction_item_length +' flex w-full items-center gap-1 my-4">'+
                            '<div class="w-1/2">'+
                                '<textarea name="instruction_item" onchange="change_instruction_item()" class="h-[10rem] w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">' + instruction_item + '</textarea>'+
                            '</div>'+
                            '<div class="w-1/2 h-[10rem] flex flex-col items-center">'+
                                '<div class="flex">'+
                                    '<label class="flex flex-col">'+
                                        '<div id="preview_photo_'+instruction_item_length+'" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">'+
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20" fill="currentColor">'+
                                                '<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />'+
                                            '</svg>'+
                                            '<p class="pt-1 px-2 text-sm tracking-wider text-gray-400 group-hover:text-gray-600"> Select a photo (If any)</p>'+
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
            }
            
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
            item: $(this).find('[name="ingredients_item"]').val(),   
        };
    }).get();
    $('#ingredients').val(JSON.stringify(data));
}

function change_ingredient_data(){
    // update json
    var data = $('.item').map(function() {
        return {
            item: $(this).find('[name="ingredients_item"]').val(),
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
        
        var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

        document.getElementById('file_error_' + id).innerHTML = "";

        if(!filetypes.includes(file.type)){
            document.getElementById('file_error_' + id).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
        }else{

            if (file) {
                encodeImageFileAsURL(attachment.files, id)
            }
        }

    }else {
        var attachment = document.getElementById('photo_attachment');

        const [file] = attachment.files
        var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

        document.getElementById('file_error').innerHTML = "";

        if(!filetypes.includes(file.type)){
            document.getElementById('file_error').innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
        }else{

            if (file) {
                encodeImageFileAsURL(attachment.files)
            }
        }
    }
}

function update_photo(id){
    var attachment = document.getElementById('photo_attachment_' + id);

    const [file] = attachment.files

    var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

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
        }
        fileReader.readAsDataURL(fileToLoad);
    }
}