function select_photo(id = 0){ 
    // const MAX_FILE_SIZE = 2048
    const MAX_FILE_SIZE = 2097152 // bytes , 2mb
    var attachment = (id > 0) ? document.getElementById('photo_attachment_' + id) : document.getElementById('photo_attachment');
    var error_span = (id > 0) ? 'instruction_error_'+ id : 'instruction_error'

    const [file] = attachment.files
    var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    
    document.getElementById(error_span).innerHTML = "";
    
    if(!filetypes.includes(file.type)){
        document.getElementById(error_span).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png, webp.";
    }else{
        if(file.size <= MAX_FILE_SIZE){
            if (file) {
                if(id > 0){
                    document.getElementById('image_button_container_' + id).style.display = '';
                    document.getElementById('image_button_container_' + id).innerHTML = "";

                    encodeImageFileAsURL(attachment.files, id, add_new_instruction_image) 

                }else{
                    document.getElementById('image_button_container').style.display = '';
                    document.getElementById('image_button_container').innerHTML = "";
                    
                    encodeImageFileAsURL(attachment.files, id, add_new_instruction_image) 

                }
                
            }
        }else{
            document.getElementById(error_span).innerHTML = "The attachment exceeded the maximum file size of 2MB. Your image file size is " + (file.size / 1048576).toFixed(2) + ' mb';
        }
    }
}

function encodeImageFileAsURL(imageData, id, funct_add_image, custom_width=500, custom_height=500){
    var filesSelected = imageData;

    if (filesSelected.length > 0) {
        var fileToLoad = filesSelected[0];

        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var img = document.createElement("img");
            img.onload = function (event) {
                var canvas = document.createElement("canvas");
                canvas.width = custom_width;
                canvas.height = custom_height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, custom_width, custom_height);

                // Show resized image in preview element
                var dataurl = canvas.toDataURL(fileToLoad.type);
                
                // call the function to assign the value
                funct_add_image(id, dataurl)

            }
            img.src = fileLoadedEvent.target.result;
            // var srcData = fileLoadedEvent.target.result; // <--- data: base64
        }
        fileReader.readAsDataURL(fileToLoad);
        /** end fo banner image */

    }
}

function add_new_instruction_image(id, base64){
    var elem = (id > 0) ? "_" + id : ""
    
    document.getElementById('image_button_container' + elem).innerHTML = '<button type="button" class="text-md font-bold absolute top-0 right-0 p-1 px-2.5 text-white bg-[#F2AA85] rounded-full shadow-md hover:border-2 hover:bg-white hover:text-[#F2AA85] hover:border-[#F2AA85]" onclick="remove_image('+ id +')">x</button>'+
        '<label class="flex flex-col w-full my-auto h-full">'+ 
            '<div id="preview_photo'+ elem +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem]  hover:bg-blend-darken hover:rounded-md">'+ 
                '<img src="'+ base64 +'" alt="Preview Image" class="m-auto max-h-[15rem] w-full h-full my-auto py-1 rounded-md" id="attached_photo'+ elem +'" />'+ 
            '</div>'+
        '</label>'+ 
        '<input type="hidden" name="attached_hidden" id="attached_hidden'+ elem +'" value="'+ base64 +'" />';

    // update json data
    update_instruction_json_data()

}