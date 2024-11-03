@props(['width', 'height'])

<label class="flex flex-col hover:bg-[#ffc5a82e] hover:bg-blend-darken h-full w-full">
    <div id="preview_container_{{$id}}" class="flex flex-col items-center justify-center bg-[#F2AA85] hover:bg-white rounded-md border-2 border-sm hover:border-2 border-[#F2AA85] ring-[#F2AA85] border-dashed shadow-md h-full w-full" >
        @if($updateValue != '') 
            <img src="{{ Storage::url($updateValue) }}" alt="Preview Image" class="my-auto"/>
        @else
            <img src="{{Storage::url('assets/images/icons/img_logo.svg')}}" alt="Image logo" class="m-auto my-auto py-1 h-max" />
            <span class="text-center text-[12px] py-1 px-2 leading-tight">File size maximum of 2mb</span>
        @endif
    </div>
    <input type="hidden" id="width_preview" value="{{ $width }}">
    <input type="hidden" id="height_preview" value="{{ $height }}">
    <input type="file" class="opacity-0 hidden" id="{{$id}}" value="{{ old($id) }}" onchange="attachment('{{$id}}')" {{ $attributes->merge(['class' => 'opacity-0 hidden'])}} />
</label>
    <input type="hidden" name="attachment_thumbnail" id="attachment_thumbnail_hidden_{{$id}}" />
    <input type="hidden" name="attachment_banner" id="attachment_banner_hidden_{{$id}}" />
<span class="text-sm text-red-600 space-y-1 mt-2" id="file_error_{{$id}}"></span>

<!-- include this script <script src="{{ Storage::url('assets/js/photo_preview.js') }}"></script>  on html file that calls this component to prevent multiple loading of script -->
