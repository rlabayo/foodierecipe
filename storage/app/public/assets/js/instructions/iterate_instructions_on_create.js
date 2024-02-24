$(document).ready(function(){
    // if instruction is not empty
    if($('#instruction').val() != ''){
        var instruction_items = jQuery.parseJSON($('#instruction').val())

        document.getElementById('count').value = instruction_items.length + 1
        if(instruction_items.length > 0){
            for(var j = 0; j < instruction_items.length; j++){
                
                if(instruction_items[j].attached_photo != undefined && instruction_items[j].attached_photo != ''){
                    var items =  add_instruction_item(j+1, instruction_items[ j ].instruction_item, instruction_items[j].attached_photo)
                }else{
                    var items =  add_instruction_item(j+1, instruction_items[ j ].instruction_item, '')
                }

                $('#instructions').append(items);
            }
        }
    }
});