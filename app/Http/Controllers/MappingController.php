<?php

namespace App\Http\Controllers;

use App\Models\CiElements;
use App\Models\CiInstances;
use App\Models\InstancesElements;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function MappingFunction(Request $request)
    {
        $instanceElementId = $request->input('instance_element_id');
        $elementId = $request->input('element_id');

        $instanceElement = InstancesElements::where('id', $instanceElementId)->firstOrFail();
        $instanceElement->element_id = $elementId;
        $instanceElement->save();
        return response()->json(['message' => 'Element ID updated successfully'], 200);
    }
}
