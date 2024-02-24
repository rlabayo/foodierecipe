function update_instruction_json_data(){
    var data = $('.item_instruction').map(function() { 
        return {
            instruction_item: $(this).find('[name="instruction_item"]').val(),
            attached_photo: $(this).find('[name="attached_hidden"]').val(),
        };
    }).get();
    
    $('#instruction').val(JSON.stringify(data));
}