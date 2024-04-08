<div class="card-body">
    <div class="table-responsive">
        <table id="table" class="table">
            <thead class="thead-light">

                {{-- @if ($report == 'payrolls') --}}
                <tr>
                    <th scope="col">period_id</th>
                    <th scope="col">name</th>
                    <th scope="col">from</th>
                    <th scope="col">to</th>
                    <th scope="col">closed</th>
                    <th scope="col">soft_closed</th>
                    <th scope="col">status</th>
                    <th scope="col">instance_id</th>
                    <th scope="col">instance_name</th>
                    <th scope="col">payroll_id</th>
                    <th scope="col">payroll_name</th>
                </tr>
                {{-- @endif --}}
            </thead>
        </table>
    </div>
</div>
