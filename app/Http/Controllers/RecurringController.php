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
              try{
               $recurring = Recurring::where('id',$id)->with(['admin'])->get()->firstOrFail();
              }catch(\Exception $exception){
                return response()->json([
            'message'=> 'Recurring transaction is not found.',
            ]);

            }

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
    $inputs=$request->except('_method');
    if ($recurring){
    $recurring->update($inputs);
    return  response()->json([
        'message' =>'Recurring transaction is edited successtully.',
        'recurring' =>$recurring,
    ]);

    }else{
         return  response()->json([
        'message' =>'The recurring transaction does not exist.',
      
    ]);
        

    }
}



    public function deleteRecurring(Request $request, $id){
        $recurring = Recurring::find($id);
        if ($recurring){
        $recurring->delete();
        return response()->json([
            'message' =>'Recurring transaction is deleted successtully.',
          
        ]);
    }else{
        return response()->json([
            'message' =>'Recurring transaction does not exist.',
        ]);

    }
    }
}
