@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4>@lang('Edit Role') :{{ $role->name }}</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-2">
                                @error('permission')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="name">@lang('permissions'):</label>

                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-3">
                                            <label for="">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                                {{ $permission->name }}
                                            </label>

                                        </div>
                                    @endforeach
                                </div>
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
