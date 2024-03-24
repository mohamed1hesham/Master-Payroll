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
                            <th scope="col">id</th>
                            <th scope="col">instance_name</th>
                            <th scope="col">base_url</th>
                            <th scope="col">username</th>
                            <th scope="col">password</th>
                            <th scope="col">token</th>
                            <th scope="col">Actions</th>
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
                url: "{{ route('dashboard.instanceCreation') }}",
                method: 'GET',
                success: function() {
                    window.location.href = '/dashboard/instanceCreation';
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
                    url: "{{ route('dashboard.instancesData') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.date = $('#date').val();
                    }
                },
                columns: [{
                        name: "id",
                        orderable: true
                    }, {

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
                    }, {
                        name: "Actions",
                        orderable: true
                    }


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
                autoFill: true,
                columnDefs: [{
                    targets: -1,
                    data: null,
                    defaultContent: '<button class="btn btn-sm btn-primary edit-instance">Edit</button><br> <button class="btn btn-sm btn-danger delete-instance">Delete</button>'
                }]
            });
        });
        $(document).on('click', '.edit-instance', function() {
            var data = $(this).closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            window.location.href = '/dashboard/editInstance/' + data[0];
        });

        $(document).on('click', '.delete-instance', function() {
            var data = $(this).closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            var instanceId = data[0];
            $.ajax({
                url: "/dashboard/deleteInstance/" + instanceId,
                method: 'DELETE',
                data: {
                    id: instanceId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#table').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });

        });
    </script>
@endsection
<style>
    .edit-instance {
        margin-bottom: 5px;
        width: 100px;
    }

    .delete-instance {
        margin-bottom: 5px;
        width: 100px;
    }
</style>
