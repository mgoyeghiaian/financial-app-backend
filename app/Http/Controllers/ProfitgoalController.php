<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profitgoal;
use App\Models\Admin;


class ProfitgoalController extends Controller
{
    public function addProfitgoal(Request $request){
        $profitgoal = new Profitgoal ;
               $netProfit = $request->input('netprofit');
               $isdeleted = $request->input('isdeleted');
           $profitgoal->netProfit = $netProfit;
           $profitgoal->isdeleted = $isdeleted;
           $profitgoal->save();
           return response()->json([
               'message'=>$profitgoal,
           ]);
}

public function getProfitgoal(Request $request, $id ){
    try{
    $profitgoal = Profitgoal::where('id',$id)->get()->firstOrFail();
     }catch(\Exception $exception){

    return response()->json([
        'message' => 'the profitgoal is not found.',
    ]);
}
return response()->json([
 'message' => $profitgoal,
  ]);

}


public function getProfitgoalAll(Request $request){
    $profitgoal = Profitgoal::get();

    return response()->json([
        'message' => $profitgoal,
    ]);

}



public function editProfitgoal(Request $request, $id ){
    $profitgoal = Profitgoal::find($id);
    $inputs=$request->except('_method');
    if ($profitgoal){
         $profitgoal->update($inputs);
    return  response()->json([
        'message' =>'Profitgoal edited successtully',
        'Profitgoal' =>$profitgoal,
    ]);

    }else{
          return  response()->json([
        'message' =>'The profit goal does not exist.',
      
    ]);

    }
   
    }

    public function deleteProfitgoal(Request $request, $id){
        $profitgoal = Profitgoal::find($id);
        if ($profitgoal){
             $profitgoal->delete();
                 return response()->json([
            'message' =>'Profitgoal deleted successtully',
        ]);

        }else{
              return  response()->json([
        'message' =>'The profit goal does not exist.',
      
    ]);

        }
    }
}

