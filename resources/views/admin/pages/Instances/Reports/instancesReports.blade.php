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
                <h3>Reports</h3>
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
                            <a href="#" class="hovForLi" id="runValuesReport">
                                <li><i class="fa fa-file"></i> RunValues Report</li>
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


        document.getElementById("runValuesReport").addEventListener("click", function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/dashboard/run-values-report", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById("contentSection").innerHTML = xhr.responseText;
                        // Initialize DataTables after content is loaded
                        $('#table').DataTable({
                            serverSide: true,
                            processing: true,
                            ajax: {
                                url: "/dashboard/instances-run-values-report",
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

                                    name: "person_number",
                                    orderable: true
                                }, {

                                    name: "HireDate",
                                    orderable: true
                                }, {

                                    name: "payroll_id",
                                    orderable: true
                                }, {

                                    name: "period_id",
                                    orderable: true
                                }, {

                                    name: "instance_id",
                                    orderable: true
                                }, {

                                    name: "instance_name",
                                    orderable: true
                                }, {

                                    name: "Basic_Salary",
                                    orderable: true
                                }, {

                                    name: "Basic_Salary_worked_days",
                                    orderable: true
                                }, {

                                    name: "Worked_Days_diff",
                                    orderable: true
                                }, {

                                    name: "Accommodation_allowance_fixed",
                                    orderable: true
                                }, {

                                    name: "Nature_of_Work",
                                    orderable: true
                                }, {

                                    name: "Car_Allowance_fixed",
                                    orderable: true
                                }, {

                                    name: "Transportation_allowance_Fix",
                                    orderable: true
                                }, {

                                    name: "Transport_Fix_Non_Taxable",
                                    orderable: true
                                }, {

                                    name: "Transport_Fix_Taxable",
                                    orderable: true
                                }, {

                                    name: "Transportation_Allowance_non_tax_VAR",
                                    orderable: true
                                }, {

                                    name: "Car_allowance_non_taxable",
                                    orderable: true
                                }, {

                                    name: "Fuel_Allowance_non_taxable",
                                    orderable: true
                                }, {

                                    name: "Nature_of_Work_Allow_NTF",
                                    orderable: true
                                }, {

                                    name: "Representation_Allowance_NTF",
                                    orderable: true
                                }, {

                                    name: "Pay_Review_Bulk_Payment",
                                    orderable: true
                                }, {

                                    name: "Overtime",
                                    orderable: true
                                }, {

                                    name: "Amount_OverTime",
                                    orderable: true
                                }, {

                                    name: "Bonus_Tax_Applicable",
                                    orderable: true
                                }, {

                                    name: "Bonus_Non_Tax_Applicable",
                                    orderable: true
                                }, {

                                    name: "Diff_Salaries",
                                    orderable: true
                                }, {

                                    name: "Incentives",
                                    orderable: true
                                }, {

                                    name: "Vacation_encashment",
                                    orderable: true
                                }, {

                                    name: "Notice_period_compensation",
                                    orderable: true
                                }, {

                                    name: "Transport_allowance_Non_Tax",
                                    orderable: true
                                }, {

                                    name: "Vacation_Encashment_Non_Tax",
                                    orderable: true
                                }, {

                                    name: "other_plus",
                                    orderable: true
                                }, {

                                    name: "Travel_to_Sokhna",
                                    orderable: true
                                }, {

                                    name: "Travel_to_Sahel",
                                    orderable: true
                                }, {

                                    name: "Working_days_Additions",
                                    orderable: true
                                }, {

                                    name: "Food_Allowance_Non_Taxable",
                                    orderable: true
                                }, {

                                    name: "Incentives_Non_Taxable",
                                    orderable: true
                                }, {

                                    name: "COLA",
                                    orderable: true
                                }, {

                                    name: "Finance_Statement_Bonus",
                                    orderable: true
                                }, {

                                    name: "Traffic_Violation",
                                    orderable: true
                                }, {

                                    name: "Mobile_Deduction",
                                    orderable: true
                                }, {

                                    name: "Loan",
                                    orderable: true
                                }, {

                                    name: "Deduction_fixed",
                                    orderable: true
                                }, {

                                    name: "Other_Deduction",
                                    orderable: true
                                }, {

                                    name: "social_insurance",
                                    orderable: true
                                }, {

                                    name: "Taxes",
                                    orderable: true
                                }, {

                                    name: "Misconduct",
                                    orderable: true
                                }, {

                                    name: "Non_Working_days",
                                    orderable: true
                                }, {

                                    name: "Misconduct_Days",
                                    orderable: true
                                }, {

                                    name: "half_Gross_salary",
                                    orderable: true
                                }, {

                                    name: "Sick_Leave_Social_Insurance",
                                    orderable: true
                                }, {

                                    name: "Social_insurance_ER_share",
                                    orderable: true
                                }, {

                                    name: "Medical_Insurance",
                                    orderable: true
                                }, {

                                    name: "Life_Insurance",
                                    orderable: true
                                }, {

                                    name: "Unpaid_Leave",
                                    orderable: true
                                }, {

                                    name: "Unpaid_leave_half_Days",
                                    orderable: true
                                }, {

                                    name: "Penalties",
                                    orderable: true
                                }, {

                                    name: "Absence",
                                    orderable: true
                                }, {

                                    name: "Unauthorized_Absence",
                                    orderable: true
                                }, {

                                    name: "Lateness_between_1_and_60_minutes",
                                    orderable: true
                                }, {

                                    name: "Lateness_between_60_and_120_minutes",
                                    orderable: true
                                }, {

                                    name: "Lateness_between_120_and_beyond",
                                    orderable: true
                                }, {

                                    name: "Missing_sign_in_out",
                                    orderable: true
                                }, {

                                    name: "Early_out",
                                    orderable: true
                                }, {

                                    name: "Misconduct_OTL",
                                    orderable: true
                                }, {

                                    name: "CP_Penalties",
                                    orderable: true
                                }, {

                                    name: "penalty_transfer",
                                    orderable: true
                                }, {

                                    name: "Over_Time_Request",
                                    orderable: true
                                }, {

                                    name: "Business_Trip_Overtime",
                                    orderable: true
                                }, {

                                    name: "Business_Trip_Overtime_Holiday",
                                    orderable: true
                                }, {

                                    name: "Holiday_Overtime",
                                    orderable: true
                                }, {

                                    name: "Overtime_OTL",
                                    orderable: true
                                }, {

                                    name: "loan_installment",
                                    orderable: true
                                }, {

                                    name: "loan_capital_amount",
                                    orderable: true
                                }, {

                                    name: "Loan_Value",
                                    orderable: true
                                }, {

                                    name: "loan_comment",
                                    orderable: true
                                }, {

                                    name: "Traffic_violations_installment",
                                    orderable: true
                                }, {

                                    name: "Traffic_violations_capital_amount",
                                    orderable: true
                                }, {

                                    name: "Traffic_violations_comment",
                                    orderable: true
                                }, {

                                    name: "Martyrs_fund",
                                    orderable: true
                                }, {

                                    name: "Diff_Start_Plus",
                                    orderable: true
                                }, {

                                    name: "Diff_Start_minus",
                                    orderable: true
                                }, {

                                    name: "Gross_Salary",
                                    orderable: true
                                }, {

                                    name: "Insurance_salary",
                                    orderable: true
                                }, {

                                    name: "Taxable_salary",
                                    orderable: true
                                }, {

                                    name: "Total_Earnings",
                                    orderable: true
                                }, {

                                    name: "Total_Deductions",
                                    orderable: true
                                }, {

                                    name: "Net_Salary",
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
