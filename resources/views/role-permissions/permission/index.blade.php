<x-web-layout>
    @include('role-permissions.nav-links')


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
                        <h4>permissions
                            <a href="{{ url('permissions/create') }}" class="btn btn-primary float-end">add
                                permissions</a>
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
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ url('permissions/' . $permission->id . '/edit') }}"
                                                class="btn btn-success">edit</a>
                                            <a href="{{ url('permissions/' . $permission->id . '/delete') }}"
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
