<x-app-layout>
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/3rrycfl3chghen0hxa7j0avr48m3yyvhyjzmao15ygpef9cq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
            selector: 'textarea',
            menubar: '',
            toolbar: 'bullist',
            // menu : {
            //     format: { title : 'Format', items : 'bold italic underline' }
            // },
            toolbar: 'undo redo | bold italic underline bullist numlist',
            plugins: ['lists', 'styles'],
        });
    </script>
    <textarea></textarea>
</x-app-layout>