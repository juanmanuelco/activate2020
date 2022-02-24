<script>
    let toolbar_module = { theme: 'snow', modules: { toolbar: quill_toolbar } };
    let quill_default = '<p><br></p>';
    @foreach($fields as $field)
        @switch($field['type'])
            @case('TEXTAREA')
            let field_{{$field['id']}} = new Quill('#{{$field['id']}}', toolbar_module);
            field_{{$field['id']}}.on('editor-change', function(eventName, ...args) {
                document.getElementById('desc_{{$field['name']}}').value = document.getElementById('{{$field['id']}}').getElementsByClassName('ql-editor')[0].innerHTML;
                if(document.getElementById('desc_{{$field['name']}}').value === quill_default){
                    document.getElementById('desc_{{$field['name']}}').value = '' ;
                }
            });
            @break
        @endswitch
    @endforeach
</script>
