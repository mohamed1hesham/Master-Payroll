@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4>@lang('Edit Role')</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('roles/' . $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">@lang('Roles Name'):</label>
                                <input type="text" name="name" value="{{ $role->name }}" class="form-control"
                                    id="name" />
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">@lang('Update')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
