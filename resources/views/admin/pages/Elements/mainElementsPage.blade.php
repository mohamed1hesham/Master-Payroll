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
                            <th scope="col">element_name_en</th>
                            <th scope="col">element_name_ar</th>
                            <th scope="col">order</th>
                            <th scope="col">disability</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer">

                <a href="/dashboard" class="btn btn-lg btn-danger ">Back</a>
                <button id="elementCreationBtn" type="button" class="btn btn-lg btn-primary ">Add
                    Element</button>
            </div>
        </div>

    </div>
    <script>
        $('#elementCreationBtn').click(function() {
            $.ajax({
                url: "{{ route('dashboard.elementCreation') }}",
                method: 'GET',
                success: function() {
                    window.location.href = '/dashboard/elementCreation';
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
                    url: "{{ route('dashboard.elementsData') }}",
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

                        name: "element_name_en",
                        orderable: true
                    },
                    {
                        name: "element_name_ar",
                        orderable: true
                    },
                    {
                        name: "order",
                        orderable: true
                    },
                    {
                        name: "disability",
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
                    defaultContent: '<button class="btn btn-sm btn-primary edit-element">Edit</button> <br><button class="btn btn-sm btn-danger delete-element">Delete</button>'
                }]
            });
        });
        $(document).on('click', '.edit-element', function() {
            var data = $(this).closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            window.location.href = '/dashboard/editElement/' + data[0];
        });

        $(document).on('click', '.delete-element', function() {
            var data = $(this).closest('tr').find('td').map(function() {
                return $(this).text();
            }).get();
            var elementId = data[0];
            $.ajax({
                url: "/dashboard/deleteElement/" + elementId,
                method: 'DELETE',
                data: {
                    id: elementId,
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
    .edit-element {
        margin-bottom: 5px;
        width: 100px;
    }

    .delete-element {
        margin-bottom: 5px;
        width: 100px;
    }
</style>
