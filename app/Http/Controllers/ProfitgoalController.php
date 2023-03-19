<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profitgoal;
use App\Models\Admin;
use App\Http\Controllers\FixedController;
use App\Http\Controllers\RecurringController;

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
        $profitgoal = Profitgoal::where('id', $id)->where('isdeleted', 0)->firstOrFail();
    } catch(\Exception $exception){
        return response()->json([
            'message' => 'the profitgoal is not found.',
        ]);
    }
    return response()->json([
        'message' => $profitgoal,
    ]);
}
public function getProfitgoalAll(Request $request){
    $start = $request->input('start');
    $end = $request->input('end');
    $query = Profitgoal::where('isdeleted', 0);
    if ($start && $end) {
        $query->whereBetween('created_at', [$start, $end]);
    }
    $profitgoal = $query->get()->map(function ($profitgoal) {
        $date = date_create($profitgoal->created_at);
        $profitgoal->month = date_format($date, "M");
        $profitgoal->year = date_format($date, "Y");
        $profitgoal->day = date_format($date, "D");
        return $profitgoal;
    });

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
    public function deleteProfitgoal($id)
    {
        $profitgoal = Profitgoal::findOrFail($id);
        $profitgoal->isDeleted = 1;
        $profitgoal->save();

        return response()->json(['message' => 'Success']);
    }
    public function calculateProfit(Request $request)
    {
        $fixedController = new FixedController();
        $fixed = $fixedController->calculateProfit();

        $recurringController = new RecurringController();
        $recurring = $recurringController->calculateProfit();

        return response()->json(
    [     $recurring->original,
    $fixed->original,
         ]
    );
    }




}

