@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Instances</h3>
            </div>
            <div class="card-body">
                <table id="table" class="table">
                    <thead class="thead-light ">

                        <tr>
                            <th scope="col">instance_name</th>
                            <th scope="col">base_url</th>
                            <th scope="col">username</th>
                            <th scope="col">password</th>
                            <th scope="col">token</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer">

                <a href="/dashboard" class="btn btn-lg btn-danger ">Back</a>
                <button id="instanceCreationBtn" type="button" class="btn btn-lg btn-primary ">Add
                    Instance</button>

            </div>
        </div>

    </div>

    <script>
        $('#instanceCreationBtn').click(function() {
            $.ajax({
                url: "{{ route('instanceCreation') }}",
                method: 'GET',
                success: function() {
                    window.location.href = '/instanceCreation';
                },
                error: function(error) {
                    console.error(error);
                }

            });
        })
        $(function() {
            $(document).ready(function() {
                $('#table').DataTable();
            });
            $('#table').DataTable({

                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('instancesData') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.date = $('#date').val();
                    }
                },
                columns: [{
                        name: "instance_name",
                        orderable: true
                    },
                    {
                        name: "base_url",
                        orderable: true
                    },
                    {
                        name: "username",
                        orderable: true
                    },
                    {
                        name: "password",
                        orderable: true
                    },
                    {
                        name: "token",
                        orderable: true
                    },

                ],
                order: [
                    [0, 'asc']
                ],
                iDisplayLength: 10,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],
                dom: 'Blfrtip',
                buttons: ['colvis', 'excel', 'csv', 'print', 'copy', 'pdf'],
                autoFill: true
            });
        });
    </script>
@endsection
