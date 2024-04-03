@extends('admin.layouts.app')
@section('content')
    <style>
        ul,
        #myUL {
            list-style-type: none;
        }

        #myUL {
            margin: 0;
            padding: 0;
        }

        .caret {
            cursor: pointer;
            user-select: none;
        }

        .caret::before {
            content: "\25B6";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }

        .caret-down::before {
            transform: rotate(90deg);
        }

        .nested {
            display: none;
        }

        .active {
            display: block;
        }

        #myUL li a {
            text-decoration: none;
            color: inherit;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Report</h3>
            </div>
            <div class="card-body">
                <ul id="myUL">
                    <li><span class="caret">Instances Report</span>
                        <ul class="nested">
                            <a href="">
                                <li><i class="fa fa-file"></i> Report</li>
                            </a>
                    </li>
                </ul>
                </li>
                </ul>

                <table>
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>payroll_id</th>
                            <th>period_end_date</th>
                            <th>start_effective_date</th>
                            <th>end_effective_date</th>
                            <th>priority</th>
                            <th>type</th>
                            <th>is_recurring</th>
                            <th>instance_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mergedData as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->payroll_id }}</td>
                                <td>{{ $item->period_end_date }}</td>
                                <td>{{ $item->start_effective_date }}</td>
                                <td>{{ $item->end_effective_date }}</td>
                                <td>{{ $item->priority }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->is_recurring }}</td>
                                <td>{{ $item->instance_id }}</td>
                                <!-- Add more columns as needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="/dashboard" class="btn btn-sm btn-danger ">Back</a>

            </div>
        </div>

    </div>
    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }
    </script>
@endsection
