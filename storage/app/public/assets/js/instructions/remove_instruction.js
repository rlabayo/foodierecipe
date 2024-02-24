function remove_instruction(id) {
    document.getElementById('item_instruction_' + id).remove() 
    
    // update instruction json data
    update_instruction_json_data()
}