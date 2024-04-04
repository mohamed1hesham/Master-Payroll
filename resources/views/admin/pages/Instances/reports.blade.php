<!-- Your HTML content for the payroll report goes here -->
<table>
    <thead>
        @isset($payrolls)
            <tr>
                <th>name</th>
                <th>payroll_id</th>
                <th>period_end_date</th>
                <th>start_effective_date</th>
                <th>end_effective_date</th>
                <th>instance_id</th>
                <th>instance_name</th>
            </tr>
        @endisset
        @isset($elements)
            <tr>
                <th>name</th>
                <th>priority</th>
                <th>type</th>
                <th>is_recurring</th>
                <th>instance_id</th>
                <th>instance_name</th>
            </tr>
        @endisset
    </thead>
    <tbody>
        @isset($payrolls)
            @foreach ($payrolls as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->payroll_id }}</td>
                    <td>{{ $item->period_end_date }}</td>
                    <td>{{ $item->start_effective_date }}</td>
                    <td>{{ $item->end_effective_date }}</td>
                    <td>{{ $item->instance_id }}</td>
                    <td>{{ $item->instanceData->instance_name ?? '' }}</td>
                </tr>
            @endforeach

        @endisset

        @isset($elements)
            @foreach ($elements as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->priority }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->is_recurring }}</td>
                    <td>{{ $item->instance_id }}</td>
                    <td>{{ $item->instanceData->instance_name ?? '' }}</td>
                </tr>
            @endforeach

        @endisset
    </tbody>
</table>
