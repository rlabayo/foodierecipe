function remove_image(id = 0){ 
    var elem = (id > 0) ? "_" + id : ""
    var elem_display = ''

    elem_display += reset_image_container(id)

    document.getElementById('image_button_container'+ elem).innerHTML = elem_display

    // update instruction json data
    update_instruction_json_data()
}