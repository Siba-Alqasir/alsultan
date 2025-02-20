@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Inquiry Details')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection
@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Name</th>
                            <th>{{$contact->name}}</th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>{{$contact->email}}</th>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <th>{{$contact->phone}}</th>
                        </tr>
                        @if($contact->country != null)
                            <tr>
                                <th>Country</th>
                                <th>{{$contact->country}}</th>
                            </tr>
                        @endif

                        @if($contact->category != null)
                            <tr>
                                <th>Category</th>
                                <th>{{$contact->category}}</th>
                            </tr>
                        @endif

                        @if($contact->company != null)
                            <tr>
                                <th>Company</th>
                                <th>{{$contact->company}}</th>
                            </tr>
                        @endif

                        @if($contact->message != null)
                            <tr>
                                <th>Message</th>
                                <th>{{$contact->message}}</th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
