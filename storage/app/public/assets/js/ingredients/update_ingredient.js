function change_ingredient_data(){
    // update json
    var data = $('.item').map(function() {
        return {
            item: $(this).find('[name="ingredients_item"]').val(),
            subtitle: $(this).find('[name="subtitle"]').val()
        };
    }).get();
    $('#ingredients').val(JSON.stringify(data));
}