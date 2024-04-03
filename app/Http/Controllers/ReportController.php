<?php

namespace App\Http\Controllers;

use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $elements = InstancesElements::all();
        $payrolls = InstancesPayroll::all();
        $mergedData = $elements->merge($payrolls);
        return view('admin.pages.Instances.instancesReports', ['mergedData' => $mergedData]);
    }
}