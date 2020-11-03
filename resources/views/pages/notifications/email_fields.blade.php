
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            @include('includes.images')
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            @include('includes.receivers')
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
           <div class="form-group">
               <label for="">{{__('subject')}}</label>
               <input type="text" name="subject" class="form-control">
           </div>
            <label for="">{{__('body')}}</label>
            <div id="email" style="max-height: 400px; height:400px"></div>
            <input type="hidden" name="email" id="email_text">
        </div>

    </div>


@section('new_scripts')
    <script src="{{asset('vendor/quill/quill_image_resize.js')}}"></script>
    <script>
        Quill.register('imageResize', ImageResize);
        let quill = new Quill('#email', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar,
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                },
                imageResize: {}
            }
        });
        quill.on('editor-change', function(eventName, ...args) {
            document.getElementById('email_text').value = document.getElementById('email').getElementsByClassName('ql-editor')[0].innerHTML;
        });
    </script>
@endsection
