$(document).ready(function(){
    // if instruction is not empty
    // if($('#instruction').val() != ''){
    //     var instruction_items = jQuery.parseJSON($('#instruction').val())

    //     document.getElementById('count').value = instruction_items.length + 1
    //     if(instruction_items.length > 0){
    //         for(var j = 0; j < instruction_items.length; j++){
                
    //             if(instruction_items[j].attached_photo != undefined && instruction_items[j].attached_photo != ''){
    //                 var items =  add_instruction_item(j+1, instruction_items[ j ].instruction_item, instruction_items[j].attached_photo)
    //             }else{
    //                 var items =  add_instruction_item(j+1, instruction_items[ j ].instruction_item, '')
    //             }

    //             $('#instructions').append(items);
    //         }
    //     }
    // }

    document.getElementById('add_instruction').addEventListener('click', function(){
        var instruction_item_length = parseInt(document.getElementById('count').value)
        document.getElementById('instruction_error').innerHTML = ""
        var instruction = document.getElementById('instruction_item').value;
        var attached_src = $('#attached_photo').attr('src')
        var elem = ''

        // reset preview photo element
        document.getElementById('image_button_container').style.display = '';
        document.getElementById('image_button_container').innerHTML = "";
        document.getElementById('image_button_container').innerHTML = reset_image_container()

        if(instruction != "" && attached_src != undefined ){
            elem = add_instruction_item(instruction_item_length, instruction, attached_src)
        }else{
            if(instruction != ""){
                elem = add_instruction_item(instruction_item_length, instruction, '')
            }else if(attached_src != undefined){
                elem = add_instruction_item(instruction_item_length, instruction, attached_src)
            }else{
                document.getElementById('instruction_error').innerHTML = "Please fill up instruction before clicking the add button.";
            }
        }

        if(elem != ''){
            $('#instructions').append(elem);

            // update instruction json data
            update_instruction_json_data()

            $('#instruction_item').val('')
            $('#attached_hidden').val('')
            $('#attached_photo').attr('src', '')

            document.getElementById('count').value = instruction_item_length + 1
        }
    });

});

// function add_instruction_item(instruction_item_length, instruction, attached_src){
//     var attached_src = (attached_src != '' && attached_src != undefined) ? 
//                         '<button type="button" class="text-md font-bold absolute top-0 right-0 p-1 px-2.5 text-white bg-[#F2AA85] rounded-full shadow-md hover:border-2 hover:bg-white hover:text-[#F2AA85] hover:border-[#F2AA85]" onclick="remove_image('+ instruction_item_length +')">x</button>'+
//                         '<label class="flex flex-col w-full my-auto h-full"> '+
//                             '<div id="preview_photo_'+ instruction_item_length +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem] hover:bg-blend-darken hover:rounded-md">'+
//                                 '<img src="'+ attached_src +'" alt="Image logo" class="m-auto max-h-[15rem] w-full h-full my-auto py-1 rounded-md" />'+
//                             '</div>'+
//                         '</label>'+
//                         '<input type="hidden" name="attached_hidden" id="attached_hidden_'+ instruction_item_length +'" value="'+ attached_src +'" />' 
//                         : 
//                         reset_image_container(instruction_item_length)
               
//     var elem = ''         
//     elem += '<div id="item_instruction_'+ instruction_item_length +'">'+
//                 '<div class="flex shadow-md space-x-2 items-center rounded-md border-sm border-[#F2AA85] ring-[#F2AA85] m-auto my-auto text-sm item_instruction">'+
//                     '<div class="md:w-2/3 w-1/2 ">'+
//                         '<textarea name="instruction_item" id="instruction_item_'+ instruction_item_length +'"  style="max-width:100%;" class="max-h-[14rem] md:h-[14rem] h-[11rem] resize-none mx-1 mt-1.5 ring-0 border-0 outline-none w-full text-sm border-[--input-border] dark:border-[--input-border] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--secondary] focus:ring-[--primary] dark:focus:ring-[--secondary] rounded-md shadow-sm" placeholder="Enter instruction...">'+ instruction +'</textarea>'+
//                     '</div>'+
//                     '<div class="relative items-end justify-center md:w-1/3 w-1/2 bg-transparent rounded-md hover:border-2 border-dashed border-[#F2AA85] ring-[#F2AA85] shadow-md bg-[#F2AA85] hover:bg-white" id="image_button_container_'+ instruction_item_length +'">'
//                     + 
//                     attached_src 
//                     +
//                     '</div>'+
//                     '<div class="">  '+
//                         '<button type="button" style="padding-left:1.2rem;padding-right:1.2rem;" class="rounded-full py-2 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" onclick="remove_instruction('+ instruction_item_length +')">-</button>'+
//                     '</div>'+
//                 '</div>'+
//                 '<span class="w-full inline-flex text-sm text-red-600 space-y-1 text-center" id="instruction_error_'+ instruction_item_length +'"></span>'+
//             '</div>';
//     return elem
// }

// function remove_instruction(id) {
//     document.getElementById('item_instruction_' + id).remove() 
    
//     // update instruction json data
//     update_instruction_json_data()
// }
    
// function select_photo(id = 0){ 
//     // const MAX_FILE_SIZE = 2048
//     const MAX_FILE_SIZE = 2097152 // bytes , 2mb
//     var attachment = (id > 0) ? document.getElementById('photo_attachment_' + id) : document.getElementById('photo_attachment');
//     var error_span = (id > 0) ? 'instruction_error_'+ id : 'instruction_error'

//     const [file] = attachment.files
//     var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    
//     document.getElementById(error_span).innerHTML = "";
    
//     if(!filetypes.includes(file.type)){
//         document.getElementById(error_span).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png, webp.";
//     }else{
//         if(file.size <= MAX_FILE_SIZE){
//             if (file) {
//                 if(id > 0){
//                     document.getElementById('image_button_container_' + id).style.display = '';
//                     document.getElementById('image_button_container_' + id).innerHTML = "";

//                     encodeImageFileAsURL(attachment.files, id, add_new_instruction_image) 

//                 }else{
//                     document.getElementById('image_button_container').style.display = '';
//                     document.getElementById('image_button_container').innerHTML = "";
                    
//                     encodeImageFileAsURL(attachment.files, id, add_new_instruction_image) 

//                 }
                
//             }
//         }else{
//             document.getElementById(error_span).innerHTML = "The attachment exceeded the maximum file size of 2MB. Your image file size is " + (file.size / 1048576).toFixed(2) + ' mb';
//         }
//     }
// }

// function encodeImageFileAsURL(imageData, id, funct_add_image, custom_width=500, custom_height=500){
//     var filesSelected = imageData;

//     if (filesSelected.length > 0) {
//         var fileToLoad = filesSelected[0];

//         var fileReader = new FileReader();

//         fileReader.onload = function(fileLoadedEvent) {
//             var img = document.createElement("img");
//             img.onload = function (event) {
//                 var canvas = document.createElement("canvas");
//                 canvas.width = custom_width;
//                 canvas.height = custom_height;
//                 var ctx = canvas.getContext("2d");
//                 ctx.drawImage(img, 0, 0, custom_width, custom_height);

//                 // Show resized image in preview element
//                 var dataurl = canvas.toDataURL(fileToLoad.type);
                
//                 // call the function to assign the value
//                 funct_add_image(id, dataurl)

//             }
//             img.src = fileLoadedEvent.target.result;
//             // var srcData = fileLoadedEvent.target.result; // <--- data: base64
//         }
//         fileReader.readAsDataURL(fileToLoad);
//         /** end fo banner image */

//     }
// }

// function update_instruction_json_data(){
//     var data = $('.item_instruction').map(function() { 
//         return {
//             instruction_item: $(this).find('[name="instruction_item"]').val(),
//             attached_photo: $(this).find('[name="attached_hidden"]').val(),
//         };
//     }).get();
    
//     $('#instruction').val(JSON.stringify(data));
// }

// function add_new_instruction_image(id, base64){
//     var elem = (id > 0) ? "_" + id : ""
    
//     document.getElementById('image_button_container' + elem).innerHTML = '<button type="button" class="text-md font-bold absolute top-0 right-0 p-1 px-2.5 text-white bg-[#F2AA85] rounded-full shadow-md hover:border-2 hover:bg-white hover:text-[#F2AA85] hover:border-[#F2AA85]" onclick="remove_image('+ id +')">x</button>'+
//         '<label class="flex flex-col w-full my-auto h-full">'+ 
//             '<div id="preview_photo'+ elem +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem]  hover:bg-blend-darken hover:rounded-md">'+ 
//                 '<img src="'+ base64 +'" alt="Preview Image" class="m-auto max-h-[15rem] w-full h-full my-auto py-1 rounded-md" id="attached_photo'+ elem +'" />'+ 
//             '</div>'+
//         '</label>'+ 
//         '<input type="hidden" name="attached_hidden" id="attached_hidden'+ elem +'" value="'+ base64 +'" />';

//     // update json data
//     update_instruction_json_data()

// }

// function remove_image(id = 0){ 
//     var elem = (id > 0) ? "_" + id : ""
//     var elem_display = ''

//     elem_display += reset_image_container(id)

//     document.getElementById('image_button_container'+ elem).innerHTML = elem_display

//     // update instruction json data
//     update_instruction_json_data()
// }

// function reset_image_container(id){
//     var elem_id = (id > 0) ? '_' + id : ''
//     var count = (id > 0) && id

//     var elem = ''
//     elem += '<label class="flex flex-col w-full my-auto h-full"> '+
//                 '<div id="preview_photo'+ elem_id +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem] hover:bg-blend-darken rounded-md bg-[#F2AA85] hover:bg-white">'+
//                     '<img src="/storage/assets/images/icons/img_logo.svg" alt="Image logo" class="m-auto my-auto py-1" />'+
//                     '<span class="text-center text-[12px] py-1 px-2 leading-tight">File size maximum of 2mb</span>'+
//                 '</div>'+
//                 '<input type="file" class="opacity-0 hidden" id="photo_attachment'+ elem_id +'" onchange="select_photo('+ count +')">'+
//                 '</label>'+
//             '<input type="hidden" name="attached_hidden" id="attached_hidden'+ elem_id +'"/>'
    
//     return elem;
// }
