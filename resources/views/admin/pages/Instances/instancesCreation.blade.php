@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Setup Instances</h3>
            </div>
            <div class="card-body">
                <form id="instanceForm">

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
                <a href="/dashboard/instances" class="btn btn-lg btn-danger ">Back</a>
                <button id="saveBtn" class="btn btn-lg btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var formData = $('#instanceForm').serialize();
                $.ajax({
                    url: "{{ isset($record) ? route('dashboard.updateInstance', ['id' => $record->id]) : route('dashboard.createInstance') }}",
                    method: 'POST',
                    data: formData, 
                    success: function(response) {
                        console.log(response);
                        toastr.success('Data saved successfully!');
                        $('#instanceForm').find("input[type=text], textarea").val("");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error('Error occurred while saving data.');
                    }
                });
            });
        });
    </script>
@endsection
