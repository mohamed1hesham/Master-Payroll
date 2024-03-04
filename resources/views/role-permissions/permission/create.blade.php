@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4>@lang('Create Role')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('roles') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">@lang('Roles Name'):</label>
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-sm">@lang('Save')</button>
                                <a href="{{ url('roles/create') }}" class="btn btn-danger btn-sm float-end">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
