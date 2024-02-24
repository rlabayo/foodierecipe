function reset_image_container(id){
    var elem_id = (id > 0) ? '_' + id : ''
    var count = (id > 0) && id

    var elem = ''
    elem += '<label class="flex flex-col w-full my-auto h-full"> '+
                '<div id="preview_photo'+ elem_id +'" class="flex flex-col items-center justify-center w-auto max-h-[14rem] md:h-[14rem] h-[11rem] hover:bg-blend-darken rounded-md bg-[#F2AA85] hover:bg-white">'+
                    '<img src="/storage/assets/images/icons/img_logo.svg" alt="Image logo" class="m-auto my-auto py-1" />'+
                    '<span class="text-center text-[12px] py-1 px-2 leading-tight">File size maximum of 2mb</span>'+
                '</div>'+
                '<input type="file" class="opacity-0 hidden" id="photo_attachment'+ elem_id +'" onchange="select_photo('+ count +')">'+
                '</label>'+
            '<input type="hidden" name="attached_hidden" id="attached_hidden'+ elem_id +'"/>'
    
    return elem;
}