<?php

namespace App\Http\Controllers;

use App\Models\CiInstances;
use App\Requests\CreateInstanceValidator;
use Illuminate\Http\Request;
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
    public function delete($id)
    {
        CiInstances::find($id)->delete();
        return response()->json(['success' => true]);
    }


    public function create(CreateInstanceValidator $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        CiInstances::create($validatedData);
        return redirect()->back();
    }
    public function update(CreateInstanceValidator $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        CiInstances::find($id)->update($validatedData);
        return redirect()->back();
    }
    public function edit($id)
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
