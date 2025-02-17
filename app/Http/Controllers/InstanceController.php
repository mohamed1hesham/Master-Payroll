<?php

namespace App\Http\Controllers;

use App\Models\CiInstances;
use App\Requests\InstanceValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstanceController extends Controller
{
    public function indexMain()
    {
        return view('admin.pages.Instances.mainInstancesPage');
    }


    public function indexCreation()
    {
        return view('admin.pages.Instances.instancesCreation');
    }
    public function deleteInstance($id)
    {
        CiInstances::find($id)->delete();
        return response()->json(['success' => true]);
    }

    public function postGuzzle($base_url, $query)
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post($base_url, [
                'query' => $query
            ]);

            $responses = json_decode($response->getBody()->getContents());
            //dd($responses);
            return $responses;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            dd($e->getMessage());
        }
    }
    public function create(InstanceValidator $request)
    {

        $validatedData = $request->validated();
        $query = ['email' => $validatedData['username'], 'password' => $validatedData['password']];
        $response = $this->postGuzzle($validatedData['base_url'], $query);
        $validatedData['token'] = $response->access_token;
        $validatedData['added_by'] = Auth::user()->id;
        CiInstances::create($validatedData);
        return redirect()->back();
    }
    
    public function update(InstanceValidator $request, $id)
    {
        $validatedData = $request->validated();
        $query = ['email' => $validatedData['username'], 'password' => $validatedData['password']];
        $response = $this->postGuzzle($validatedData['base_url'], $query);
        $validatedData['token'] = $response->access_token;
        // $validatedData['password'] = Hash::make($validatedData['password']);
        CiInstances::find($id)->update($validatedData);
        return redirect()->back();
    }
    
    public function editInstance($id)
    {
        $record = CiInstances::find($id);
        return view('admin.pages.Instances.instancesCreation', ['record' => $record]);
    }

    public function instancesData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];
        $query = CiInstances::query();
        if ($searchValue) {
            $query = $query->where('instance_name', 'LIKE', '%' . $searchValue . '%');
        }
        $totalRecords = $query->count();
        $instances = $query->skip($start)
            ->take($length)
            ->get();
        $data_arr = [];
        foreach ($instances as $item) {
            $data_arr[] = [
                $item->id ?? '',
                $item->instance_name ?? '',
                $item->base_url ?? '',
                $item->username ?? '',
                $item->password ?? '',
                $item->token ?? '',
                $item->user->name ?? '',

            ];
        }
        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data_arr,
        ];
        return response()->json($response);
    }
}