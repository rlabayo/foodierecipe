function remove(id){
    $('.item'+id).remove();

    // update json
    var data = $('.item').map(function() {
        return {
            item: $(this).find('[name="ingredients_item"]').val(),   
        };
    }).get();
    
    data_item = (data.length > 0) ? JSON.stringify(data) : ''

    $('#ingredients').val(data_item);
}