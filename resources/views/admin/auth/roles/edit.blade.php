@extends('admin.layouts.contentLayoutMaster')

@section('title', "Edit Role")

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h2></h2>
            </div>
            <div class="card-body">
                {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-1">
                            <div class="form-group">
                                <strong>Role Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <br/>
                    <strong>Select Permissions:</strong>
                    <br/>
                    <div class="col-lg-12">
                        <div class="mb-1 mt-2">
                            <div class="form-group">
                                <div class="row">
                                    @foreach(array_chunk($permission,4) as $items)
                                        <div class="col-lg-3 mb-2">
                                            @foreach($items as $value)
                                                <label>{{ Form::checkbox('permission[]', $value['id'], in_array($value['id'], $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                    {{  $value['name'] }}</label>
                                                <br/>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2" style="float: right">Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
