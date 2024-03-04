<x-web-layout>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif


                <div class="card mt-3">
                    <div class="card-header">
                        <h4>roles
                            <a href="{{ url('roles/create') }}" class="btn btn-primary float-end">add
                                roles</a>
                        </h4>
                    </div>
                    <div class="card-body ">
                        <table class="table table-borderd-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>name</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ url('roles/' . $role->id . '/edit') }}"
                                                class="btn btn-success">edit</a>
                                            <a href="{{ url('roles/' . $role->id . '/delete') }}"
                                                class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-web-layout>
