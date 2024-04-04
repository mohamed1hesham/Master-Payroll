<?php

namespace App\Http\Controllers;

use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.pages.Instances.instancesReports');
    }
    public function showPayrollsReport()
    {
        $payrolls = InstancesPayroll::all();
        return view('admin.pages.Instances.reports', ['payrolls' => $payrolls]);
    }
    public function showElementsReport()
    {
        $elements = InstancesElements::all();
        return view('admin.pages.Instances.reports', ['elements' => $elements]);
    }
}
