@extends('admin.layouts.app')

@section('content')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <div class="container-fluid mt-3">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Instance Element Mapping</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="elements" class="form-label">Select an Element:</label>
                    <select id="elements" class="form-select">
                        <option value=""> Select </option>
                        @foreach ($elements as $element)
                            <option class="option" value="{{ $element->id }}">{{ $element->element_name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="instance_elements" class="form-label">Select an Instance Element:</label>
                    <select id="instance_elements" class="form-select">
                        <option value=""> Select </option>
                        @foreach ($instance_elements as $instance_element)
                            <option value="{{ $instance_element->id }}">{{ $instance_element->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <a href="/dashboard/instances" class="btn btn-danger btn-lg">Back</a>
                <button id="submitBtn" type="button" class="btn btn-primary btn-lg">Save</button>
            </div>
        </div>
    </div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>  --}}
    <script>
        $(document).ready(function() {
            // $('#elements, #instance_elements').select2();
            $('#submitBtn').click(function() {
                var instanceElementId = $('#instance_elements').val();
                var elementId = $('#elements').val();

                $.ajax({
                    url: '/dashboard/postMapping',
                    method: 'GET',
                    data: {
                        element_id: elementId,
                        instance_element_id: instanceElementId,

                    },
                    success: function(response) {
                        console.log(response); // Handle response if needed
                        toastr.success('Mapping saved successfully!');
                        $('#instance_elements').val('');
                        $('#elements').val('');
                    },
                    error: function() {
                        toastr.success('Error!');
                    }
                });
            });
        });
    </script>
@endsection
