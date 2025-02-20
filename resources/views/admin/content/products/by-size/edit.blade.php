@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Product')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                    @foreach($active_lang as $key=>$locale)
                        <li class="nav-item">
                            <a class="nav-link @if($key === 'en') active @endif" id="{{$key}}-tab-justified"
                               data-bs-toggle="tab" href="#add-{{$key}}" role="tab"
                               aria-controls="add-{{$key}}">{{$locale['name']}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-1">
                    @foreach($active_lang as $key=>$locale)
                        <div class="tab-pane @if($key === 'en') active @endif" id="add-{{$key}}" role="tabpanel"
                             aria-labelledby="{{$key}}-tab-justified">
                            <form method="POST" action="{{route('products-by-size.update',$product->id)}}" enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="lang" value="{{$key}}">
                                
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                                <textarea class="form-control" name="description" id="summernote" >{!! $product->getTranslation('description',$key) !!}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Finishes</label>
                                                <select class="select2 form-control" name="finishes[]" multiple>
                                                    @foreach(\App\Models\Finish::all() as $finish)
                                                        <option value="{{$finish->id}}" @if(collect($product->finishes)->contains('attribute_id', $finish->id)) selected @endif>{{$finish->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Colors</label>
                                                <select class="select2 form-control" name="colors[]" multiple>
                                                    @foreach(\App\Models\Color::all() as $color)
                                                        <option value="{{$color->id}}" @if(collect($product->colors)->contains('attribute_id', $color->id)) selected @endif>{{$color->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Image *</label>
                                                <input type="file" name="image" class="form-control" id="image_url"
                                                       accept="image/*" @if(!$product->getFirstMediaUrl('image')) required @endif />
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$product->getFirstMediaUrl('image')}}" id="image_view">
                                            </div>
                                        </div>
                                    </div>
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2" style="float: right">Save</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')


    <script>
        $("#image_url").change(function () {
            readURL(this);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_view').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image_url_mobile").change(function () {
            readURLMobile(this);
        });
        function readURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#image_view_mobile").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var entryTemplate = $('.entry:first').clone();
    
            $('.btn-add').click(function() {
                var newEntry = entryTemplate.clone();
                newEntry.find('input').val('');
                newEntry.appendTo('.repeater');
            });
    
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.entry').remove();
            });
        });
    </script>
    <script>
        function delete_slider(event, id) {
            event.preventDefault();
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        }
                    });
                    $.ajax({
                        url: "{{ url('/admin/delete-product-image') }}/" + id,
                        type: 'DELETE',
                        success: function (data) {
                            if (data.code === 200 || data.code === "200") {
                                toastr.success(data.message, data.message, {
                                    iconClass: 'custom-checkmark-icon', // Add a custom class for the icon
                                    titleClass: 'toast-title', // Add a custom class for the title
                                    closeButton: true, // Display a close button
                                    progressBar: true, // Display a progress bar
                                    progressBarColor: '#28c76f', // Set the color of the progress bar
                                    positionClass: 'toast-top-right', // Set the position of the toast
                                    timeOut: 5000, // Set the duration for the toast to be displayed (in milliseconds)
                                    extendedTimeOut: 1000, // Set the extended duration for the toast if hovered (in milliseconds)
                                    tapToDismiss: false, // Prevent dismissing the toast on click
                                    onclick: function() {
                                        // Callback function when the toast is clicked
                                        console.log('Toast clicked');
                                    },
                                    onCloseClick: function() {
                                        // Callback function when the close button is clicked
                                        console.log('Close button clicked');
                                    },
                                    showDuration: 300, // Set the show animation duration (in milliseconds)
                                    hideDuration: 1000, // Set the hide animation duration (in milliseconds)
                                    showEasing: 'swing', // Set the show animation easing
                                    hideEasing: 'linear', // Set the hide animation easing
                                    showMethod: 'fadeIn', // Set the show animation method
                                    hideMethod: 'fadeOut' // Set the hide animation method
                                });
                                window.location.reload()
                                
                            } else {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'Error deleting file',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                })
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Your file is safe',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
            })
        }
    </script>
@endsection
