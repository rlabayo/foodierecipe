function add_instruction_item(instruction_item_length, instruction, attached_src, category = 'create'){
    var attached_src_elem = ''
    if((attached_src != '' && attached_src != undefined)){
        var img_src = (category == 'create') ? attached_src : '/storage/' + attached_src
        
        attached_src_elem = '<button type="button" class="text-md font-bold absolute top-0 right-0 p-1 px-2.5 text-white bg-[#F2AA85] rounded-full shadow-md hover:border-2 hover:bg-white hover:text-[#F2AA85] hover:border-[#F2AA85]" onclick="remove_image('+ instruction_item_length +')">x</button>'+
        '<label class="flex flex-col w-full my-auto h-full"> '+
            '<div id="preview_photo_'+ instruction_item_length +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem] hover:bg-blend-darken hover:rounded-md">'+
                '<img src="'+ img_src + '" alt="Image logo" class="m-auto max-h-[15rem] w-full h-full my-auto py-1 rounded-md" />'+
            '</div>'+
        '</label>'+
        '<input type="hidden" name="attached_hidden" id="attached_hidden_'+ instruction_item_length +'" value="'+ attached_src +'" />' 
    }else{
        attached_src_elem += reset_image_container(instruction_item_length)
    }
    
    var elem = ''         
    elem += '<div id="item_instruction_'+ instruction_item_length +'">'+
                '<div class="flex shadow-md space-x-2 items-center rounded-md border-sm border-[#F2AA85] ring-[#F2AA85] m-auto my-auto text-sm item_instruction">'+
                    '<div class="md:w-2/3 w-1/2 ">'+
                        '<textarea name="instruction_item" id="instruction_item_'+ instruction_item_length +'"  style="max-width:100%;" class="max-h-[14rem] md:h-[14rem] h-[11rem] resize-none mx-1 mt-1.5 ring-0 border-0 outline-none w-full text-sm border-[--input-border] dark:border-[--input-border] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--secondary] focus:ring-[--primary] dark:focus:ring-[--secondary] rounded-md shadow-sm" placeholder="Add Instruction" onchange="update_instruction_json_data()">'+ instruction +'</textarea>'+
                    '</div>'+
                    '<div class="relative items-end justify-center md:w-1/3 w-1/2 bg-transparent rounded-md hover:border-2 border-dashed border-[#F2AA85] ring-[#F2AA85] shadow-md bg-[#F2AA85] hover:bg-white" id="image_button_container_'+ instruction_item_length +'">'
                    + 
                    attached_src_elem 
                    +
                    '</div>'+
                    '<div class="">  '+
                        '<button type="button" style="padding-left:1.2rem;padding-right:1.2rem;" class="rounded-full py-2 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" onclick="remove_instruction('+ instruction_item_length +')">-</button>'+
                    '</div>'+
                '</div>'+
                '<span class="w-full inline-flex text-sm text-red-600 space-y-1 text-center" id="instruction_error_'+ instruction_item_length +'"></span>'+
            '</div>';
    return elem
}