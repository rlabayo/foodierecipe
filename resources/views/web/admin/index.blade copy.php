<x-guest-layout>
    @push('script')
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/3rrycfl3chghen0hxa7j0avr48m3yyvhyjzmao15ygpef9cq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
    tinymce.init({
        selector: '#mytextarea',
        // plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        // tinycomments_mode: 'embedded',
        // tinycomments_author: 'Author name',
        // mergetags_list: [
        // { value: 'First.Name', title: 'First Name' },
        // { value: 'Email', title: 'Email' },
        // ],
        // ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
    });
    </script>
    @endpush
    <form method="post" action="{{ route('admin.index') }}">
      <textarea id="mytextarea" name="mytextarea">Hello, World!</textarea>
      <button type="submit">Submit</button>
    </form>
</x-guest-layout>