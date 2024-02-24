<input type="file" id="{{$idName}}" onchange="attachment('{{$idName}}')" {{ $attributes->merge(['class' => 'inline-flex items-center bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md text-gray-700 tracking-widest shadow-sm dark:hover:bg-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 w-full'])}}/>
<div id="preview_container_{{$idName}}" class="flex justify-center items-center" style="display:none;">
    <x-input-label for="preview" :value="__('Preview')" class="mt-4"/>
    <img src="" id="preview_{{$idName}}" alt="Preview Image" width="300" height="300" class="my-4"/>
    <span class="text-sm text-red-600 space-y-1 mt-2" id="file_error_{{$idName}}"></span>
</div>

@push('script')
    <script>
        function attachment(idName){
            const [file] = document.getElementById(idName).files
            var filetypes = ['image/png', 'image/jpeg', 'image/jpg'];

            document.getElementById('file_error_' + idName).innerHTML = "";
            
            if(!filetypes.includes(file.type)){
                document.getElementById('file_error_' + idName).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png.";
            }else{
                preview = document.getElementById('preview_container_' + idName);
                preview.style.display = 'block';

                if (file) {
                    document.getElementById('preview_' + idName).src = URL.createObjectURL(file)
                }
            }
        }
    </script>
@endpush