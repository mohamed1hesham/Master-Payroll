@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Setup Instances</h3>
            </div>
            <div class="card-body">
                <form
                    action="{{ isset($record) ? route('dashboard.dashboard.updateInstance', ['id' => $record->id]) : route('dashboard.createInstance') }}"
                    method="POST">

                    @csrf
                    <div class="form-group col-12">
                        <label for="base_url">Base Url</label>
                        <input id="base_url" type="text" name="base_url" class="form-control"
                            value="{{ isset($record) ? $record->base_url : '' }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="instance_name">Instance Name</label>
                        <input id="instance_name" type="text" name="instance_name" class="form-control"
                            value="{{ isset($record) ? $record->instance_name : '' }}">

                    </div>
                    <div class="form-group col-12">
                        <label for="username">UserName</label>
                        <input id="username" type="text" name="username" class="form-control"
                            value="{{ isset($record) ? $record->username : '' }}">
                    </div>
                    <div class="form-group col-12">
                        <label for="password">Password</label>
                        <input id="password" type="text" name="password" class="form-control"
                            value="{{ isset($record) ? $record->password : '' }}">
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
            </div>
            <div class="card-footer">

                <a href="/instances" class="btn btn-lg btn-danger ">Back</a>
                <button class="btn btn-lg btn-primary ">Save</button>
                </form>
            </div>
        </div>

    </div>
@endsection
