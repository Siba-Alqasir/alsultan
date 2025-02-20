@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Projects Gallery')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                    <form method="POST" action="{{route('gallery')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="repeater">
                        <div class="entry">
                            <div class="row mt-1">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Upload Image</label>
                                        <input type="file" name="gallery[]"
                                            class="form-control" id="gallery_url" accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button class="btn btn-danger btn-remove mt-2" type="button">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-add mt-1" type="button">Add More</button>
                    <button type="submit" class="btn btn-primary mt-2" style="float: right">Save</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @forelse ($page->getMedia('gallery') as $image)
                        <div class="col-lg-2 position-relative">
                            <div class="mb-1 position-relative">
                                <img class="img-fluid rounded" style="height: 30%"
                                        src="{{$image->getUrl()}}">
                                <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="delete_slider(event, {{$image->id}})">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>
                        </div>

                    @empty
                        <p class="text-center">Gallery is empty.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script type="text/javascript">
    $(document).ready(function() {
        var entry = $('.entry').clone();

        $('.btn-add').click(function() {
            var newEntry = entry.clone();
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
                    url: "{{ url('/admin/delete-image') }}/" + id,
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
