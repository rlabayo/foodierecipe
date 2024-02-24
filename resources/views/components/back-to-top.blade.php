<a href="{{ URL::current() }}" class="fixed bottom-0 right-0 pr-2 pb-2 hidden" id="back_to_top">
    <img src="{{ Storage::url('/assets/images/icons/arrow_up.svg') }}" alt="Back to top" width="30" />
</a>

@push('script')
<script>
    window.addEventListener("scroll", function(){
        let viewHeight = window.innerHeight
        let scrollHeight = window.scrollY
        
        if(viewHeight > scrollHeight){
            document.getElementById('back_to_top').classList.add('hidden')
            document.getElementById('back_to_top').classList.remove('visible')
        }else{
            document.getElementById('back_to_top').classList.remove('hidden')
            document.getElementById('back_to_top').classList.add('visible')
        }
    });
</script>
@endpush