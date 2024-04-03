<?php

namespace App\Http\Controllers;

use App\Models\CiElements;
use App\Requests\ElementValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElementsController extends Controller
{
    public function indexMain()
    {
        return view('admin.pages.Elements.mainElementsPage');
    }
    public function indexCreation()
    {
        return view('admin.pages.Elements.elementsCreation');
    }


    public function create(ElementValidator $request)
    {
        $validatedData = $request->validated();
        if (!$request->has('disability')) {
            $validatedData['disability'] = false;
        }
        $validatedData['added_by'] = Auth::user()->id;
        CiElements::create($validatedData);
        return redirect()->back();
    }
    public function deleteElement($id)
    {
        CiElements::find($id)->delete();
        return response()->json(['success' => true]);
    }
    public function editElement($id)
    {
        $record = CiElements::find($id);
        return view('admin.pages.Elements.elementsCreation', ['record' => $record]);
    }
    public function updateElement(ElementValidator $request, $id)
    {
        $validatedData = $request->validated();
        if (!$request->has('disability')) {
            $validatedData['disability'] = false;
        }
        CiElements::find($id)->update($validatedData);
        return redirect()->back();
    }
    public function elementsData(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];
        $query = CiElements::query();
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
                $item->element_name_en ?? '',
                $item->element_name_ar ?? '',
                $item->order ?? '',
                $item->disability ?? '',
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
