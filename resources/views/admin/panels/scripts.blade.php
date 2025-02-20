<script src="{{ asset(mix('admin-assets/vendors/js/vendors.min.js')) }}"></script>
<script src="{{asset(mix('admin-assets/vendors/js/ui/jquery.sticky.js'))}}"></script>
<script src="{{asset(mix('admin-assets/vendors/js/extensions/sweetalert2.all.min.js'))}}"></script>
<script src="{{asset(mix('admin-assets/vendors/js/extensions/toastr.min.js'))}}"></script>
<script src="{{asset(mix('admin-assets/vendors/js/extensions/polyfill.min.js'))}}"></script>
<script src="{{ asset(mix('admin-assets/vendors/js/forms/select/select2.full.min.js')) }}"></script>

@yield('vendor-script')

<script src="{{ asset(mix('admin-assets/js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('admin-assets/js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('admin-assets/js/core/app.js')) }}"></script>
<script src="{{ asset(mix('admin-assets/js/core/scripts.js')) }}"></script>
@if($configData['blankPage'] === false)
    <script src="{{ asset(mix('admin-assets/js/scripts/customizer.js')) }}"></script>
@endif
@yield('page-script')
<script src="{{ asset('admin-assets/summernote/summernote-lite.min.js') }}"></script>
<script>
    $(document).ready(function() {
        if ($('[id^=summernote]').length > 0) {
            $('[id^=summernote]').summernote({
                height: 200,
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if($('#summernote').length > 0){
            document.getElementById('form_en').addEventListener('submit', function(event) {

                if ($('#summernote').summernote('isEmpty')) {
                    event.preventDefault();
                    $('#summernote').after('<span class="text-danger summernote-error">This field is required.</span>');
                    $('html, body').animate(
                        {
                            scrollTop: $('#summernote').offset().top - 100
                        },
                        500
                    );
                    $('#summernote').summernote('focus');
                } else {
                    $('.summernote-error').remove();
                }
            });
        }
    });
</script>
@if(session('success'))
    <script>
        toastr['success'](
            "{{session('success')}}",
            "Success",
            {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
            });
    </script>
@endif

@if(session('error'))
    <script>
        toastr['error'](
            "{{session('error')}}",
            "Error",
            {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
            });
    </script>
@endif

<script>
    function delete_item(elem) {
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
                    url: $(elem).attr('item_url'),
                    type: 'DELETE',
                    success: function (data) {
                        if (data.status === 200 || data.status === "200") {
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

                            $('#' + $(elem).attr("item_id")).remove();
                            // window.location.reload()
                        } else {
                            Swal.fire({
                                title: 'Cancelled',
                                text: data.message,
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
