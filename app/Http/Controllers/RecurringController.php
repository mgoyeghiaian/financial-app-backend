<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurring;
use App\Models\Admin;

class RecurringController extends Controller
{
    public function addRecurring(Request $request){
        $recurring = new Recurring ;
               $title = $request->input('title');
               $amount = $request->input('amount');
               $type = $request->input('type');
               $category = $request->input('category');
               $startdate = $request->input('startdate');
               $enddate = $request->input('enddate');
               $isdeleted = $request->input('isdeleted');
           $recurring->title = $title;
           $recurring->amount = $amount;
           $recurring->type = $type;
           $recurring->category = $category;
           $recurring->startdate = $startdate;
           $recurring->endDate = $enddate;
           $recurring->isdeleted = $isdeleted;
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
            // $recurring->delete();
        $recurring->isDeleted = 1;
        $recurring->save();
        return response()->json([
            'message' =>'Recurring transaction is deleted successtully.',

        ]);
    }else{
        return response()->json([
            'message' =>'Recurring transaction does not exist.',
        ]);

    }
    }

    public function calculateProfit()
    {
        $income = Recurring::where('type', "income")->where('isdeleted', 0)->sum('amount');
        $expenses = Recurring::where('type', "expense")->where('isdeleted', 0)->sum('amount');
        $RecurringProfit = $income - $expenses;
        return response()->json([
            "RIncome" => $income,
            "RExpenses" => $expenses,
            'RResults' => $RecurringProfit,
              ]);

    }


    public function getRecurringFilter(Request $request){
        $year = $request->input('year');
        $month = $request->input('month');
        $query = Recurring::where('isdeleted', 0);
        if ($year) {
            $query->whereYear('enddate', $year);
            if ($month) {
                $query->whereMonth('enddate', $month);
            }
        }
        $Recurring = $query->get();
        $totalIncome = $Recurring->where('type', 'income')->sum('amount');
        $totalExpenses = $Recurring->where('type', 'expense')->sum('amount');
        $test = $totalIncome - $totalExpenses;
        return response()->json([
            'year' => $year,
            'month' => $month,
            'total_amount'=> $test
        ]);
    }
}
