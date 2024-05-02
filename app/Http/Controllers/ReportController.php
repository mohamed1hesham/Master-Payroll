<?php

namespace App\Http\Controllers;

use App\Models\CiInstances;
use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use App\Models\InstancesPeriod;
use App\Models\InstancesRunValue;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $instances = CiInstances::all();


        return view('admin.pages.Instances.Reports.instancesReports', ['instances' => $instances]);
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
    public function showRunValuesReport()
    {
        return view('admin.pages.Instances.Reports.instancesRunValuesReport');
    }

    private function fetchReportData($query, $searchValue, $start, $length, $instanceIds)
    {
        if ($searchValue) {
            $query->whereHas('instanceData', function ($query) use ($searchValue) {
                $query->where('instance_name', 'LIKE', '%' . $searchValue . '%');
            });
        }
        if (!empty($instanceIds)) {
            $query->whereIn('instance_id', $instanceIds);
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
        $instanceIds = array_merge((array) $request->input('instance_id'), (array) $request->input('instance_id2'));
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');

        $query = InstancesPayroll::select('name', 'payroll_id', 'period_end_date', 'start_effective_date', 'end_effective_date', 'instance_id')
            ->with('instanceData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length, $instanceIds);

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
        $instanceIds = array_merge((array) $request->input('instance_id'), (array) $request->input('instance_id2'));

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];
        $query = InstancesElements::select('name', 'priority', 'type', 'is_recurring', 'is_payroll_transferred', 'sequence', 'currency_id', 'instance_id', 'element_id')->with('instanceData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length, $instanceIds);

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
        $instanceIds = array_merge((array) $request->input('instance_id'), (array) $request->input('instance_id2'));

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = InstancesPeriod::select('period_id', 'name', 'from', 'to', 'closed', 'soft_closed', 'status', 'instance_id',  'payroll_id')->with('instanceData', 'payrollData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length, $instanceIds);

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
    public function instancesRunValuesReport(Request $request)
    {
        $instanceIds = array_merge((array) $request->input('instance_id'), (array) $request->input('instance_id2'));

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = InstancesRunValue::select('name', 'person_number', 'HireDate', 'payroll_id', 'period_id', 'instance_id', 'Basic_Salary', 'Basic_Salary_worked_days', 'Worked_Days_diff', 'Accommodation_allowance_fixed', 'Nature_of_Work', 'Car_Allowance_fixed', 'Transportation_allowance_Fix', 'Transport_Fix_Non_Taxable', 'Transport_Fix_Taxable', 'Transportation_Allowance_non_tax_VAR', 'Car_allowance_non_taxable', 'Fuel_Allowance_non_taxable', 'Nature_of_Work_Allow_NTF', 'Representation_Allowance_NTF', 'Pay_Review_Bulk_Payment', 'Overtime', 'Amount_OverTime', 'Bonus_Tax_Applicable', 'Bonus_Non_Tax_Applicable', 'Diff_Salaries', 'Incentives', 'Vacation_encashment', 'Notice_period_compensation', 'Transport_allowance_Non_Tax', 'Vacation_Encashment_Non_Tax', 'other_plus', 'Travel_to_Sokhna', 'Travel_to_Sahel', 'Working_days_Additions', 'Food_Allowance_Non_Taxable', 'Incentives_Non_Taxable', 'COLA', 'Finance_Statement_Bonus', 'Traffic_Violation', 'Mobile_Deduction', 'Loan', 'Deduction_fixed', 'Other_Deduction', 'social_insurance', 'Taxes', 'Misconduct', 'Non_Working_days', 'Misconduct_Days', 'half_Gross_salary', 'Sick_Leave_Social_Insurance', 'Social_insurance_ER_share', 'Medical_Insurance', 'Life_Insurance', 'Unpaid_Leave', 'Unpaid_leave_half_Days', 'Penalties', 'Absence', 'Unauthorized_Absence', 'Lateness_between_1_and_60_minutes', 'Lateness_between_60_and_120_minutes', 'Lateness_between_120_and_beyond', 'Missing_sign_in_out', 'Early_out', 'Misconduct_OTL', 'CP_Penalties', 'penalty_transfer', 'Over_Time_Request', 'Business_Trip_Overtime', 'Business_Trip_Overtime_Holiday', 'Holiday_Overtime', 'Overtime_OTL', 'loan_installment', 'loan_capital_amount', 'Loan_Value', 'loan_comment', 'Traffic_violations_installment', 'Traffic_violations_capital_amount', 'Traffic_violations_comment', 'Martyrs_fund', 'Diff_Start_Plus', 'Diff_Start_minus', 'Gross_Salary', 'Insurance_salary', 'Taxable_salary', 'Total_Earnings', 'Total_Deductions', 'Net_Salary')->with('instanceData');

        list($totalRecords, $instances) = $this->fetchReportData($query, $searchValue, $start, $length, $instanceIds);

        $data_arr = $instances->map(function ($item) {
            return [
                $item->name ?? '',
                $item->person_number ?? '',
                $item->HireDate ?? '',
                $item->payroll_id ?? '',

                $item->period_id ?? '',
                $item->instance_id ?? '',
                $item->instanceData->instance_name ?? '',
                $item->Basic_Salary ?? '',
                $item->Basic_Salary_worked_days ?? '',
                $item->Worked_Days_diff ?? '',
                $item->Accommodation_allowance_fixed ?? '',
                $item->Nature_of_Work ?? '',

                $item->Car_Allowance_fixed ?? '',
                $item->Transportation_allowance_Fix ?? '',
                $item->Transport_Fix_Non_Taxable ?? '',
                $item->Transport_Fix_Taxable ?? '',
                $item->Transportation_Allowance_non_tax_VAR ?? '',
                $item->Car_allowance_non_taxable ?? '',
                $item->Fuel_Allowance_non_taxable ?? '',
                $item->Nature_of_Work_Allow_NTF ?? '',

                $item->Representation_Allowance_NTF ?? '',
                $item->Pay_Review_Bulk_Payment ?? '',
                $item->Overtime ?? '',
                $item->Amount_OverTime ?? '',
                $item->Bonus_Tax_Applicable ?? '',
                $item->Bonus_Non_Tax_Applicable ?? '',
                $item->Diff_Salaries ?? '',
                $item->Incentives ?? '',

                $item->Vacation_encashment ?? '',
                $item->Notice_period_compensation ?? '',
                $item->Transport_allowance_Non_Tax ?? '',
                $item->Vacation_Encashment_Non_Tax ?? '',
                $item->other_plus ?? '',
                $item->Travel_to_Sokhna ?? '',
                $item->Travel_to_Sahel ?? '',
                $item->Working_days_Additions ?? '',

                $item->Food_Allowance_Non_Taxable ?? '',
                $item->Incentives_Non_Taxable ?? '',
                $item->COLA ?? '',
                $item->Finance_Statement_Bonus ?? '',
                $item->Traffic_Violation ?? '',
                $item->Mobile_Deduction ?? '',
                $item->Loan ?? '',
                $item->Deduction_fixed ?? '',

                $item->Other_Deduction ?? '',
                $item->social_insurance ?? '',
                $item->Taxes ?? '',
                $item->Misconduct ?? '',
                $item->Non_Working_days ?? '',
                $item->Misconduct_Days ?? '',
                $item->half_Gross_salary ?? '',
                $item->Sick_Leave_Social_Insurance ?? '',
                $item->Social_insurance_ER_share ?? '',
                $item->Medical_Insurance ?? '',
                $item->Life_Insurance ?? '',

                $item->Unpaid_Leave ?? '',
                $item->Unpaid_leave_half_Days ?? '',
                $item->Penalties ?? '',
                $item->Absence ?? '',
                $item->Unauthorized_Absence ?? '',
                $item->Lateness_between_1_and_60_minutes ?? '',
                $item->Lateness_between_60_and_120_minutes ?? '',
                $item->Lateness_between_120_and_beyond ?? '',
                $item->Missing_sign_in_out ?? '',
                $item->Early_out ?? '',
                $item->Misconduct_OTL ?? '',


                $item->CP_Penalties ?? '',
                $item->penalty_transfer ?? '',
                $item->Over_Time_Request ?? '',
                $item->Business_Trip_Overtime ?? '',
                $item->Business_Trip_Overtime_Holiday ?? '',
                $item->Holiday_Overtime ?? '',
                $item->Overtime_OTL ?? '',
                $item->loan_installment ?? '',
                $item->loan_capital_amount ?? '',
                $item->Loan_Value ?? '',
                $item->loan_comment ?? '',

                $item->Traffic_violations_installment ?? '',
                $item->Traffic_violations_capital_amount ?? '',
                $item->Traffic_violations_comment ?? '',
                $item->Martyrs_fund ?? '',
                $item->Diff_Start_Plus ?? '',
                $item->Diff_Start_minus ?? '',
                $item->Gross_Salary ?? '',
                $item->Insurance_salary ?? '',
                $item->Taxable_salary ?? '',
                $item->Total_Earnings ?? '',
                $item->Total_Deductions ?? '',
                $item->Net_Salary ?? '',
            ];
        })->toArray();
        return response()->json($this->prepareResponse($draw, $totalRecords, $data_arr));
    }
}
