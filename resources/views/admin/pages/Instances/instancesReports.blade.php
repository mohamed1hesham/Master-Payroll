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
                            <a href="#" id="payrollsReport">
                                <li><i class="fa fa-file"></i> Payrolls Report</li>
                            </a>
                            <a href="#" id="elementsReport">
                                <li><i class="fa fa-file"></i> Elements Report</li>
                            </a>
                        </ul>
                    </li>
                </ul>
                <br><br>
                <!-- Content section to be loaded dynamically -->
                <div id="contentSection">
                    <!-- Content will be loaded dynamically here -->
                </div>
            </div>
            <div class="card-footer">
                <a href="/dashboard" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("payrollsReport").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default link behavior
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/payrolls-report", true); // Replace with your Laravel route
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("contentSection").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        document.getElementById("elementsReport").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default link behavior
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/elements-report", true); // Replace with your Laravel route
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("contentSection").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        // JavaScript for toggling nested list
        var toggler = document.getElementsByClassName("caret");
        for (var i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }
    </script>
@endsection
