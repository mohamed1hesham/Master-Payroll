<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CiElements;
use App\Models\CiInstances;
use App\Models\InstancesElements;
use App\Models\InstancesPayroll;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getGuzzleRequest($endpoint = '', $query, $bearerToken)
    {
        $client = new \GuzzleHttp\Client();

        $base_url = 'https://dev.payroll.crystal-payroll.site/api/';
        $url = $base_url . $endpoint;

        try {
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
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            dd($e->getMessage());
        }
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

        $endpoint = 'payroll/payrolls';
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
}
