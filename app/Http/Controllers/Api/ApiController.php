<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CiElements;
use App\Models\CiInstances;
use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use App\Models\InstancesPeriod;
use App\Models\InstancesRunValue;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getGuzzleRequest($endpoint = '', $query, $bearerToken)
    {

        $client = new \GuzzleHttp\Client();

        $base_url = 'https://dev.payroll.crystal-payroll.site/api/';
        $url = $base_url . $endpoint;
        Log::info($url);
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept' => 'application/json', // optional, adjust as needed
            ],
            'query' => $query
        ]);
        // dd($response);
        $responseData = json_decode($response->getBody()->getContents());
        //  dd($responseData);
        return $responseData;
    }
    public function requestApiElements($id)
    {
        $instance = CiInstances::find($id);
        // dd($instance->token);

        $endpoint = 'payroll/elements';
        $limit = 100;
        $offset = 0;
        $data = [];
        do {
            $query = ['limit' => $limit, 'onlyData' => 'true', 'offset' => $offset];
            $response = $this->getGuzzleRequest($endpoint, $query, $instance->token);
            // dd($response)
            $data = array_merge($data, $response->items);
            $offset += $limit;
        } while ($response->hasMore);
        $dataToInsert = array_map(function ($response) use ($id) {
            //  dd($response->id);
            return [
                'name' => $response->name,
                'priority' => $response->priority,
                'type' => $response->type,
                'is_recurring' => $response->is_recurring,
                'is_payroll_transferred' => $response->is_payroll_transferred,
                'sequence' => $response->sequence,
                'currency_id' => $response->currency_id,
                'instance_id' => $id,
                'instance_element_id' => $response->id,
            ];
        }, $data);
        $dataChunks = array_chunk($dataToInsert, 500);
        foreach ($dataChunks as $chunk) {
            InstancesElements::insertOrIgnore($chunk);
        }
    }

    public function fetchElementsByInstanceId($instanceId)
    {
        $instance_elements = InstancesElements::where('instance_id', $instanceId)->select('id', 'name')->get();
        $elements = CiElements::select('id', 'element_name_en')->get();
        // dd($elements);
        return view('admin.pages.Instances.elementMapping', ['instance_elements' => $instance_elements, 'elements' => $elements]);
    }

    public function requestApiPayroll($id)
    {
        $instance = CiInstances::find($id);
        // dd($instance->token);
        $token = $instance->token;
        $endpoint = 'payroll/payrolls';
        $limit = 100;
        $offset = 0;
        $data = [];
        do {
            $query = ['limit' => $limit, 'onlyData' => 'true', 'offset' => $offset];
            $response = $this->getGuzzleRequest($endpoint, $query, $token);
            // dd($response);
            $data = array_merge($data, $response->items);
            $offset += $limit;
        } while ($response->hasMore);
        $dataToInsert = array_map(function ($response) use ($id) {
            //  dd($response->id);
            return [
                'payroll_id' => $response->id,
                'name' => $response->name,
                'period_end_date' => $response->period_end_date,
                'start_effective_date' => $response->start_effective_date,
                'end_effective_date' => $response->end_effective_date,
                'instance_id' => $id,
            ];
        }, $data);
        $dataChunks = array_chunk($dataToInsert, 500);
        foreach ($dataChunks as $chunk) {
            InstancesPayroll::insertOrIgnore($chunk);
        }
    }

    public function requestApiPeriods($instanceId)
    {
        $instance = CiInstances::find($instanceId);
        $token = $instance->token;

        $payrollIds = InstancesPayroll::where('instance_id', $instanceId)->select('payroll_id')->get();
        Log::info('step 1');
        foreach ($payrollIds as $payrollid) {
            //echo $payrollId;
            $limit = 100;
            $offset = 0;
            $data = [];
            $endpoint = "payroll/periods";
            //   Log::info('step 2');
            //dd($endpoint);
            do {
                $query = ['payroll_id' => $payrollid->payroll_id, 'limit' => $limit, 'onlyData' => 'true', 'offset' => $offset];
                $response = $this->getGuzzleRequest($endpoint, $query, $token);
                // dd($response);
                $data = array_merge($data, $response->items);
                $offset += $limit;
                //  Log::info('step 3');
            } while ($response->hasMore);
            $dataToInsert = array_map(function ($response) use ($instanceId) {
                //  dd($response->id);
                //    Log::info('step 2');
                return [
                    'period_id' => $response->id,
                    'name' => $response->name,
                    'from' => $response->from,
                    'to' => $response->to,
                    'created_at' => $response->created_at,
                    'to' => $response->to,
                    'payroll_id' => $response->payroll_id,
                    'updated_at' => $response->updated_at,
                    'instance_id' => $instanceId,
                ];
            }, $data);

            $dataChunks = array_chunk($dataToInsert, 500);
            foreach ($dataChunks as $chunk) {
                InstancesPeriod::insertOrIgnore($chunk);
            }
        };
    }

    public function requestApiRunValues($instanceId)
    {
        $instance = CiInstances::find($instanceId);
        $token = $instance->token;

        $payrollIds = InstancesPayroll::where('instance_id', $instanceId)->select('payroll_id')->get();

        foreach ($payrollIds as $payrollId) {
            $periodIds = InstancesPeriod::where('instance_id', $instanceId)
                ->where('payroll_id', $payrollId->payroll_id)
                ->select('period_id')->get();

            foreach ($periodIds as $periodId) {
                $limit = 300;
                $offset = 0;
                $data = [];
                $endpoint = "payroll/run-values";

                do {
                    $query = [
                        'payroll_id' => $payrollId->payroll_id,
                        'period_id' => $periodId->period_id,
                        'limit' => $limit,
                        'onlyData' => 'true',
                        'offset' => $offset
                    ];
                    Log::info('step 1');
                    try {
                        $response = $this->getGuzzleRequest($endpoint, $query, $token);
                        $data = array_merge($data, $response->items);
                        $offset += $limit;
                    } catch (\Exception $e) {
                        Log::error('Error fetching data: ' . $e->getMessage());
                        break;
                    }
                } while ($response->hasMore);
                Log::info('step 3');

                $dataToInsert = []; 
                foreach ($data as $response) { 
                    $dataToInsert[] = [
                        'payroll_id' => $payrollId->payroll_id,
                        'period_id' =>  $periodId->period_id,
                        'instance_id' => $instanceId,
                        'name' => $response->name,
                        'person_number' => $response->person_number,
                        'HireDate' => $response->HireDate,
                        'Basic_Salary' => $response->{'Basic Salary'},
                        'Basic_Salary_worked_days' => $response->{'Basic Salary worked days'},
                        'Worked_Days_diff' => $response->{'Worked Days diff'},
                        'Accommodation_allowance_fixed' => $response->{'Accommodation allowance fixed'},
                        'Nature_of_Work' => $response->{'Nature of Work'},
                        'Car_Allowance_fixed' => $response->{'Car Allowance(fixed)'},
                        'Transportation_allowance_Fix' => $response->{'Transportation allowance  Fix'},
                        'Transport_Fix_Non_Taxable' => $response->{'Transport Fix (Non Taxable)'},
                        'Transport_Fix_Taxable' => $response->{'Transport Fix (Taxable)'},
                        'Transportation_Allowance_non_tax_VAR' => $response->{'Transportation Allowance non tax VAR'},
                        'Car_allowance_non_taxable' => $response->{'Car allowance non-taxable'},
                        'Fuel_Allowance_non_taxable' => $response->{'Fuel Allowance non-taxable'},
                        'Nature_of_Work_Allow_NTF' => $response->{'Nature of Work Allow NTF'},
                        'Representation_Allowance_NTF' => $response->{'Representation Allowance NTF'},
                        'Pay_Review_Bulk_Payment' => $response->{'Pay Review Bulk Payment'},
                        'Overtime' => $response->{'Overtime'},
                        'Amount_OverTime' => $response->{'Amount OverTime'},
                        'Bonus_Tax_Applicable' => $response->{'Bonus (Tax Applicable)'},
                        'Bonus_Non_Tax_Applicable' => $response->{'Bonus (Non Tax Applicable)'},
                        'Diff_Salaries' => $response->{'Diff Salaries'},
                        'Incentives' => $response->{'Incentives'},
                        'Vacation_encashment' => $response->{'Vacation encashment'},
                        'Notice_period_compensation' => $response->{'Notice period compensation'},
                        'Transport_allowance_Non_Tax' => $response->{'Transport allowance(Non-Tax)'},
                        'Vacation_Encashment_Non_Tax' => $response->{'Vacation Encashment-Non Tax'},
                        'other_plus' => $response->{'other(plus)'},
                        'Travel_to_Sokhna' => $response->{'Travel to Sokhna'},
                        'Travel_to_Sahel' => $response->{'Travel to Sahel'},
                        'Working_days_Additions' => $response->{'Working days - Additions'},
                        'Food_Allowance_Non_Taxable' => $response->{'Food Allowance-Non Taxable'},
                        'Incentives_Non_Taxable' => $response->{'Incentives (Non Taxable)'},
                        'COLA' => $response->{'COLA'},
                        'Finance_Statement_Bonus' => $response->{'Finance Statement Bonus'},
                        'Traffic_Violation' => $response->{'Traffic Violation'},
                        'Mobile_Deduction' => $response->{'Mobile Deduction'},
                        'Loan' => $response->{'Loan'},
                        'Deduction_fixed' => $response->{'Deduction (fixed)'},
                        'Other_Deduction' => $response->{'Other Deduction'},
                        'social_insurance' => $response->{'social insurance'},
                        'Taxes' => $response->{'Taxes'},
                        'Misconduct' => $response->{'Misconduct'},
                        'Non_Working_days' => $response->{'Non-Working days'},
                        'Misconduct_Days' => $response->{'Misconduct Days'},
                        'half_Gross_salary' => $response->{'half Gross salary'},
                        'Sick_Leave_Social_Insurance' => $response->{'Sick Leave Social Insurance'},
                        'Social_insurance_ER_share' => $response->{'Social insurance ER share'},
                        'Medical_Insurance' => $response->{'Medical Insurance'},
                        'Life_Insurance' => $response->{'Life Insurance'},
                        'Unpaid_Leave' => $response->{'Unpaid Leave'},
                        'Unpaid_leave_half_Days' => $response->{'Unpaid leave half Days'},
                        'Penalties' => $response->{'Penalties'},
                        'Absence' => $response->{'Absence'},
                        'Unauthorized_Absence' => $response->{'Unauthorized Absence'},
                        'Lateness_between_1_and_60_minutes' => $response->{'Lateness between 1 and 60 minutes'},
                        'Lateness_between_60_and_120_minutes' => $response->{'Lateness between 60 and 120 minutes'},
                        'Lateness_between_120_and_beyond' => $response->{'Lateness between 120 and beyond'},
                        'Missing_sign_in_out' => $response->{'Missing sign in out'},
                        'Early_out' => $response->{'Early out'},
                        'Misconduct_OTL' => $response->{'Misconduct OTL'},
                        'CP_Penalties' => $response->{'CP Penalties'},
                        'penalty_transfer' => $response->{'penalty transfer'},
                        'Over_Time_Request' => $response->{'Over Time Request'},
                        'Business_Trip_Overtime' => $response->{'Business Trip Overtime'},
                        'Business_Trip_Overtime_Holiday' => $response->{'Business Trip Overtime (Holiday)'},
                        'Holiday_Overtime' => $response->{'Holiday Overtime'},
                        'Overtime_OTL' => $response->{'Overtime OTL'},
                        'loan_installment' => $response->{'loan installment'},
                        'loan_capital_amount' => $response->{'loan capital amount'},
                        'Loan_Value' => $response->{'Loan Value'},
                        'loan_comment' => $response->{'loan comment'},
                        'Traffic_violations_installment' => $response->{'Traffic violations  installment'},
                        'Traffic_violations_capital_amount' => $response->{'Traffic violations  capital amount'},
                        'Traffic_violations_comment' => $response->{'Traffic violations comment'},
                        'Martyrs_fund' => $response->{'Martyrs fund'},
                        'Diff_Start_Plus' => $response->{'Diff Start Plus'},
                        'Diff_Start_minus' => $response->{'Diff Start minus'},
                        'Gross_Salary' => $response->{'Gross Salary'},
                        'Insurance_salary' => $response->{'Insurance salary'},
                        'Taxable_salary' => $response->{'Taxable salary'},
                        'Total_Earnings' => $response->{'Total Earnings'},
                        'Total_Deductions' => $response->{'Total Deductions'},
                        'Net_Salary' => $response->{'Net Salary'},
                    ];
                }
                Log::info("step 4");
                $dataChunks = array_chunk($dataToInsert, 500);
                foreach ($dataChunks as $chunk) {
                    InstancesRunValue::insertOrIgnore($chunk);
                }
            }
        }
    }

    public function IntegrationFunc($id)
    {
        if (!$this->existsInElements($id)) {
            $this->requestApiElements($id);
        }
        if (!$this->existsInPayroll($id)) {
            $this->requestApiPayroll($id);
        }
        if (!$this->existsInPeriods($id)) {
            $this->requestApiPeriods($id);
        }
        if (!$this->existsInRunValues($id)) {
            $this->requestApiRunValues($id);
        }
    }

    private function existsInElements($id)
    {
        return InstancesElements::where('instance_id', $id)->exists();
    }

    private function existsInPayroll($id)
    {
        return InstancesPayroll::where('instance_id', $id)->exists();
    }

    private function existsInPeriods($id)
    {
        return InstancesPeriod::where('instance_id', $id)->exists();
    }
    private function existsInRunValues($id)
    {
        return InstancesRunValue::where('instance_id', $id)->exists();
    }
}