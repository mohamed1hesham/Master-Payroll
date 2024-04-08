@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header" style="background-color: #1f2a3a">
                <h3>Instances</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table">
                        <thead class="thead-light ">

                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">instance_name</th>
                                <th scope="col">base_url</th>
                                <th scope="col">username</th>
                                <th scope="col">password</th>
                                <th scope="col">token</th>
                                <th scope="col">added_by</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-footer">

                <a href="/dashboard" class="btn btn-lg btn-danger ">Back</a>
                <button id="instanceCreationBtn" type="button" class="btn btn-lg "
                    style="background-color: #2d4059;color:white">Add
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
                        name: "added_by",
                        orderable: true
                    },
                    {
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
                buttons: ['colvis',
                    "copy",
                    "csv",
                    "excel",
                    "pdf",
                    "print"
                ],
                autoFill: true,
                columnDefs: [{
                    targets: -1,
                    data: null,
                    defaultContent: '<button id="integration-instance-element-btn" class="btn btn-sm btn-success instance-element-integration"><i class="fa fa-refresh fa-sync"></i> Integration</button><br><button class="btn btn-sm btn-warning element-mapping">Mapping</button><br><button class="btn btn-sm btn-primary edit-instance">Edit</button><br> <button class="btn btn-sm btn-danger delete-instance">Delete</button>'
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


        $(document).on('click', '.element-mapping', function() {
            var data = $(this).closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            var instanceId = data[0];
            $.ajax({
                url: "/dashboard/elementMapping/" + instanceId,
                method: 'GET',
                data: {
                    id: instanceId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = '/dashboard/elementMapping/' + instanceId;
                },
                error: function(error) {
                    console.error(error);
                }
            });

        });
        $(document).on('click', '.instance-element-integration', function() {
            var button = $(this);
            var data = button.closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            var instanceId = data[0];
            button.prop('disabled', true).removeClass("btn-success").addClass("btn-secondary")
                .children("i").addClass("fa-spin");


            $.ajax({

                url: "/dashboard/requestApiElements/" + instanceId,
                method: 'GET',
                data: {
                    id: instanceId,
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    // window.location.href = '/request';
                    button.children("i").removeClass("fa-spin");
                    button.prop('disabled', false).removeClass("btn-secondary").addClass("btn-success");
                    toastr.success('Request Successful');
                },
                error: function(error) {
                    console.error(error);
                    button.prop('disabled', false);
                    toastr.error('Request Failed', {
                        closeButton: true
                    });
                }
            });

        });
    </script>
@endsection
<style>
    .edit-instance,
    .delete-instance,
    .element-mapping,
    .instance-element-integration {
        margin-bottom: 5px;
        width: 120px;
    }
</style>
