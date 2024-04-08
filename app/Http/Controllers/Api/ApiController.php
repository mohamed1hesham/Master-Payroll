<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CiElements;
use App\Models\CiInstances;
use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use App\Models\InstancesPeriod;
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
            // dd($response);
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

    public function requestApiPeriods($id)
    {
        $payrollIds = InstancesPayroll::select('payroll_id')->get();
        Log::info('step 1');
        foreach ($payrollIds as $payrollid) {

            //echo $payrollId;
            $instance = CiInstances::find($id);
            $token = $instance->token;
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
            $dataToInsert = array_map(function ($response) use ($id) {
                //  dd($response->id);
                //    Log::info('step 2');
                return [
                    'period_id' => $response->id,
                    'name' => $response->name,
                    'from' => $response->from,
                    'to' => $response->to,
                    'closed' => $response->closed,
                    'to' => $response->to,
                    'payroll_id' => $response->payroll_id,
                    'status' => $response->status,
                    'instance_id' => $id,
                ];
            }, $data);

            $dataChunks = array_chunk($dataToInsert, 500);
            foreach ($dataChunks as $chunk) {
                InstancesPeriod::insertOrIgnore($chunk);
            }
        };
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
}
