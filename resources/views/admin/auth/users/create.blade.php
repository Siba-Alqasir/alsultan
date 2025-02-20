@extends('admin.layouts.contentLayoutMaster')

@section('title', "Create User")

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Password:</strong>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Confirm Password:</strong>
                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Select Role:</strong>
                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
                                @error('roles')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" style="float: right">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
