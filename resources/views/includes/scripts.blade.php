<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('vendor/datatable/datatable.js')}}"></script>

<script>
    $(document).ready( function () {
        $('table').DataTable({
            paging      :   false,
            info        :   false,
            autoWidth   :   true,
            searching      :   false
        });
    } );
</script>
