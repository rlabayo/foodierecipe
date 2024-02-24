<div class="flex">
    <label class="flex flex-col">
        <div id="preview_{{$photo_number}}" class="flex flex-col items-center justify-center w-auto h-[9rem] max-h-max hover:bg-gray-200 hover:bg-blend-darken">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd" />
            </svg>
            <p class="pt-1 px-2 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                Select a photo (If any)</p>
        </div>
        <input type="file" class="opacity-0 hidden" id="photo_{{$photo_number}}" onchange="select_photo({{$photo_number}})"/>
    </label>
    <span class="text-sm text-red-600 space-y-1 mt-2" id="file_error_{{$photo_number}}"></span>
</div>


@push('script')
    <script>
        function select_photo(id){
            var attachment = document.getElementById('photo_' + id);

            const [file] = attachment.files
            var filetypes = ['image/png', 'image/jpeg', 'image/jpg'];

            document.getElementById('file_error_' + id).innerHTML = "";

            if(!filetypes.includes(file.type)){
                document.getElementById('file_error_' + id).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
            }else{

                if (file) {
                    console.log('preview_' + id)
                    document.getElementById('preview_' + id).innerHTML = "";
                    document.getElementById('preview_' + id).innerHTML = '<img src="'+ URL.createObjectURL(file) +'" alt="Preview Image" class="max-h-36 my-auto" id="attached_'+id+'" />';
                }
            }
        }
        
    </script>
@endpush