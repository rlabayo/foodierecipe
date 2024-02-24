$(document).ready(function(){ 
    // display the list
    if($('#ingredients').val() != ''){
        var ingredients_items = jQuery.parseJSON($('#ingredients').val())
        
        if(ingredients_items.length > 0){
            for(var i = 0; i < ingredients_items.length; i++){
                var items = '<div class="item item'+ i +' flex mt-4 gap-1">'+
                                '<div class="w-2/3 text-center">'+
                                    '<input name="ingredients_item" onchange="change_ingredient_data()" value="'+ ingredients_items[i].item +'" class="w-full text-sm border-[--primary] dark:border-[--primary] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--primary] focus:ring-[--primary] dark:focus:ring-[--primary] rounded-md shadow-sm" type="text" autofocus />'+
                                '</div>'+
                                '<div class="w-1/3 flex justify-center items-center text-center ">'+
                                    '<button type="button"  style="padding-left:1.2rem;padding-right:1.2rem;" class="rounded-full py-2 shadow-sm border-2 bg-[#F2AA85] text-white text-lg font-bold mx-1 hover:bg-white hover:border-[#F2AA85] hover:text-[#F2AA85]" onclick="remove('+ i +')">-</button>'+
                                '</div>'+
                            '</div>';
                
                $('#items').append(items);
            }
        }
    }



});