<?php

namespace App\Http\Controllers;

use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use App\Models\InstancesPeriod;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.pages.Instances.Reports.instancesReports');
    }

    public function showPayrollsReport()
    {
        return view('admin.pages.Instances.Reports.instancesPayrollsReport');
    }

    public function showElementsReport()
    {
        return view('admin.pages.Instances.Reports.instancesElementsReport');
    }

    public function showPeriodsReport()
    {
        return view('admin.pages.Instances.Reports.instancesPeriodsReport');
    }

    private function fetchReportData($query, $searchValue, $start, $length)
    {
        if ($searchValue) {
            $query->whereHas('instanceData', function ($query) use ($searchValue) {
                $query->where('instance_name', 'LIKE', '%' . $searchValue . '%');
            });
        }

        $totalRecords = $query->count();

        if ($start > 0) {
            $query->skip($start);
        }

        $instances = $query->take($length)->get();

        return [$totalRecords, $instances];
    }

    private function prepareResponse($draw, $totalRecords, $data)
    {
        return [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data,
        ];
    }

    public function instancesPayrollsReport(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = InstancesPayroll::select('name', 'payroll_id', 'period_end_date', 'start_effective_date', 'end_effective_date', 'instance_id')->with('instanceData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length);

        $data_arr = $instances->map(function ($item) {
            return [
                $item->name ?? '',
                $item->payroll_id ?? '',
                $item->period_end_date ?? '',
                $item->start_effective_date ?? '',
                $item->end_effective_date ?? '',
                $item->instance_id ?? '',
                $item->instanceData->instance_name ?? '',
            ];
        })->toArray();

        return response()->json($this->prepareResponse($draw, $totalRecords, $data_arr));
    }

    public function instancesElementsReport(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = InstancesElements::select('name', 'priority', 'type', 'is_recurring', 'is_payroll_transferred', 'sequence', 'currency_id', 'instance_id', 'element_id')->with('instanceData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length);

        $data_arr = $instances->map(function ($item) {
            return [
                $item->name ?? '',
                $item->priority ?? '',
                $item->type ?? '',
                $item->is_recurring ?? '',
                $item->is_payroll_transferred ?? '',
                $item->sequence ?? '',
                $item->currency_id ?? '',
                $item->instance_id ?? '',
                $item->instanceData->instance_name ?? '',
                $item->element_id ?? '',
            ];
        })->toArray();

        return response()->json($this->prepareResponse($draw, $totalRecords, $data_arr));
    }

    public function instancesPeriodsReport(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = InstancesPeriod::select('period_id', 'name', 'from', 'to', 'closed', 'soft_closed', 'status', 'instance_id',  'payroll_id')->with('instanceData', 'payrollData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length);

        $data_arr = $instances->map(function ($item) {
            return [
                $item->period_id ?? '',
                $item->name ?? '',
                $item->from ?? '',
                $item->to ?? '',
                $item->closed ?? '',
                $item->soft_closed ?? '',
                $item->status ?? '',
                $item->instance_id ?? '',
                $item->instanceData->instance_name ?? '',
                $item->payroll_id ?? '',
                $item->payrollData->name ?? '',
            ];
        })->toArray();

        return response()->json($this->prepareResponse($draw, $totalRecords, $data_arr));
    }
}
