<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurring;
use App\Models\Admin;

class RecurringController extends Controller
{
    public function addRecurring(Request $request){
        $recurring = new Recurring ;
        $admin_id = $request->input('admin_id');
               $admin = Admin::find($admin_id);
               $title = $request->input('title');
               $amount = $request->input('amount');
               $type = $request->input('type');
               $startdate = $request->input('startdate');
               $enddate = $request->input('enddate');
               $isdeleted = $request->input('isdeleted');
           $recurring->title = $title;
           $recurring->amount = $amount;
           $recurring->type = $type;
           $recurring->startDate = $startdate;
           $recurring->endDate = $enddate;
           $recurring->isdeleted = $isdeleted;
           $recurring->admin()->associate($admin);
           $recurring->save();
           return response()->json([
               'message'=>$recurring,
           ]);
}

public function getRecurring(Request $request, $id ){
    $recurring = Recurring::where('id',$id)->with(['admin'])->get();

    return response()->json([
        'message' => $recurring,
    ]);

}

public function getRecurringAll(Request $request){
    $recurring = Recurring::with(['admin'])->get();

    return response()->json([
        'message' => $recurring,
    ]);

}



public function editRecurring(Request $request, $id ){
    $recurring = Recurring::find($id);
    $inputs=$request->except('startdate','enddate','isdeleted','_method');
    $recurring->startdate = $request->input('startdate');
    $recurring->enddate = $request->input('enddate');
    $recurring->isdeleted = $request->input('isdeleted');
    $recurring->update($inputs);

    return  response()->json([
        'message' =>'recurring edited successtully',
        'recurring' =>$recurring,
    ]);

    }

    public function deleteRecurring(Request $request, $id){
        $recurring = Recurring::find($id);
        $recurring->delete();
        return response()->json([
            'message' =>'recurring deleted successtully',
            'recurring' =>$recurring,
        ]);
    }
}
