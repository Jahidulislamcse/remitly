<!-- Must needed plugins to the run this Template -->
<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }} "></script>

<script src="{{ asset('admin/js/todo-list.js') }} "></script>
<script src="{{ asset('admin/js/default-assets/top-menu.js') }} "></script>

<!-- These plugins only need for the run this page -->
<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

<script src="{{ asset('admin/js/jszip.min.js') }}"></script>
<script src="{{asset('admin/js/sweetalert2.all.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
    integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!-- Active JS -->
<script src="{{ asset('admin/js/default-assets/active.js') }} "></script>
@livewireScripts
<script>





    Livewire.on('msg', (event) => {
        toastr.success(event)
    });




    loadeditor();
    @if(session()->get('response') === false)
        toastr.error('{{ session()->get('msg') }}')
        @endif
        @if(session()->get('response') === true)
        toastr.success('{{ session()->get('msg') }}')
        @endif

        @if ($errors->any())
        @foreach ($errors->all() as $error)
   toastr.error('{{ $error }}')

   @endforeach

   @endif

             $('.delete-btn').on('click',function(){
            var link = $(this).attr('data');
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        window.location.href = link;

                    }
                })
           })


           function loadeditor(){
                    var allEditors = document.querySelectorAll('.ckeditor');
                    for (var i = 0; i < allEditors.length; ++i) {
                        var isload = $('.ckeditor').eq(i).attr('data');
                        if (isload != 1) {


                          ClassicEditor.create(allEditors[i],{
                              toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'indent', 'outdent', '|',
                    'link', 'imageUpload', '|',
                    'blockQuote', '|',
                    'undo', 'redo'
                ]
            },
                            ckfinder: {
                                uploadUrl: '/upload-image?_token={{ csrf_token() }}',
                            }
                        } )
                        .catch( error => {
                            console.error( error );
                        } );

                          $('.ckeditor').eq(i).attr('data',1);
                        }

                      }
                }
</script>
