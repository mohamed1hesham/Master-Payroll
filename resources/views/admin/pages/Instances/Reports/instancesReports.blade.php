@extends('admin.layouts.app')
@section('content')
    <style>
        ul,
        #myUL {
            list-style-type: none;
            padding: 0;
        }

        #myUL {
            margin: 0;
        }

        .caret {
            cursor: pointer;
            user-select: none;
            padding-left: 15px;
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
            padding-left: 30px;
        }

        .nested.active {
            display: block;
        }

        #myUL li a {
            text-decoration: none;
            color: inherit;
            display: block;
            padding: 5px;
        }

        .hovForLi:hover {
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .card-header {
            background-color: #f2f2f2;
            padding: 15px;
            border-bottom: 1px solid #dddddd;
        }

        .card-body {
            padding: 15px;
        }

        .card-footer {
            background-color: #f2f2f2;
            padding: 15px;
            border-top: 1px solid #dddddd;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header" style="background-color: #1f2a3a">
                <h3>Report</h3>
            </div>
            <div class="card-body">
                <ul id="myUL">
                    <li><span class="caret">Instances Report</span>
                        <ul class="nested">
                            <a href="#" class="hovForLi" id="payrollsReport">
                                <li><i class="fa fa-file"></i> Payrolls Report</li>
                            </a>
                            <a href="#" class="hovForLi" id="elementsReport">
                                <li><i class="fa fa-file"></i> Elements Report</li>
                            </a>
                            <a href="#" class="hovForLi" id="periodsReport">
                                <li><i class="fa fa-file"></i> Periods Report</li>
                            </a>
                        </ul>
                    </li>
                </ul>
                <br>
                <div id="contentSection">
                </div>
            </div>
            <div class="card-footer">
                <a href="/dashboard" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("payrollsReport").addEventListener("click", function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/payrolls-report", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById("contentSection").innerHTML = xhr.responseText;
                        // Initialize DataTables after content is loaded
                        $('#table').DataTable({
                            serverSide: true,
                            processing: true,
                            ajax: {
                                url: "/dashboard/instances-payrolls-report",
                                type: "POST",
                                data: function(d) {
                                    d._token = "{{ csrf_token() }}";
                                    d.date = $('#date').val();
                                },

                            },
                            columns: [{
                                    name: "name",
                                    orderable: true
                                }, {

                                    name: "payroll_id",
                                    orderable: true
                                },
                                {
                                    name: "period_end_date",
                                    orderable: true
                                },
                                {
                                    name: "start_effective_date",
                                    orderable: true
                                },
                                {
                                    name: "end_effective_date",
                                    orderable: true
                                },
                                {
                                    name: "instance_id",
                                    orderable: true
                                }, {
                                    name: "instance_name",
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

                        });
                    } else {
                        console.error("Error fetching data:", xhr.status);
                    }
                }
            };
            xhr.send();
        });



        document.getElementById("elementsReport").addEventListener("click", function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/elements-report", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById("contentSection").innerHTML = xhr.responseText;
                        // Initialize DataTables after content is loaded
                        $('#table').DataTable({
                            serverSide: true,
                            processing: true,
                            ajax: {
                                url: "/dashboard/instances-elements-report",
                                type: "POST",
                                data: function(d) {
                                    d._token = "{{ csrf_token() }}";
                                    d.date = $('#date').val();
                                },

                            },
                            columns: [{
                                    name: "name",
                                    orderable: true
                                }, {

                                    name: "priority",
                                    orderable: true
                                },
                                {
                                    name: "type",
                                    orderable: true
                                },
                                {
                                    name: "is_recurring",
                                    orderable: true
                                },
                                {
                                    name: "is_payroll_transferred",
                                    orderable: true
                                },
                                {
                                    name: "sequence",
                                    orderable: true,
                                }, {
                                    name: "currency_id",
                                    orderable: true
                                }, {
                                    name: "instance_id",
                                    orderable: true
                                }, {
                                    name: "instance_name",
                                    orderable: true
                                }, {
                                    name: "element_id",
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

                        });
                    } else {
                        console.error("Error fetching data:", xhr.status);
                    }
                }
            };

            xhr.send();
        });


        document.getElementById("periodsReport").addEventListener("click", function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/periods-report", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById("contentSection").innerHTML = xhr.responseText;
                        // Initialize DataTables after content is loaded
                        $('#table').DataTable({
                            serverSide: true,
                            processing: true,
                            ajax: {
                                url: "/dashboard/instances-periods-report",
                                type: "POST",
                                data: function(d) {
                                    d._token = "{{ csrf_token() }}";
                                    d.date = $('#date').val();
                                },

                            },
                            columns: [{
                                    name: "period_id",
                                    orderable: true
                                }, {

                                    name: "name",
                                    orderable: true
                                },
                                {
                                    name: "from",
                                    orderable: true
                                },
                                {
                                    name: "to",
                                    orderable: true
                                },
                                {
                                    name: "closed",
                                    orderable: true
                                },
                                {
                                    name: "soft_closed",
                                    orderable: true,
                                }, {
                                    name: "status",
                                    orderable: true
                                }, {
                                    name: "instance_id",
                                    orderable: true
                                }, {
                                    name: "instance_name",
                                    orderable: true
                                }, {
                                    name: "payroll_id",
                                    orderable: true
                                }, {
                                    name: "payroll_name",
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

                        });
                    } else {
                        console.error("Error fetching data:", xhr.status);
                    }
                }
            };

            xhr.send();
        });

        var toggler = document.getElementsByClassName("caret");
        for (var i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }
    </script>
@endsection
