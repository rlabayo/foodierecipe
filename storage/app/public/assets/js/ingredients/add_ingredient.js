$(document).ready(function(){
    var list = $('#ingredients').val();
    var item_length = (list != '') ? jQuery.parseJSON(list).length : 0;

    $('#add_item').click(function(){
        var ingredients_item = $('#ingredients_item').val();

        if($('#ingredients_item').val() != ""){
            var items = '<div class="item item'+item_length+' flex mt-4 gap-1">'+
                            '<div class="w-2/3 text-center">'+
                                '<input name="ingredients_item" onchange="change_ingredient_data()" value="'+ ingredients_item +'" class="w-full text-sm border-[--primary] dark:border-[--primary] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm" type="text" autofocus />'+
                            '</div>'+
                            '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                '<button type="button" style="padding-left:1.2rem;padding-right:1.2rem;" class="rounded-full py-2 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" onclick="remove('+ item_length +')">-</button>'+
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

});