<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixed;
use App\Models\Admin;
use App\Models\Recurring;

class FixedController extends Controller
{


    //addFixed is not working

     public function addFixed(Request $request){
       $fixed= new Fixed;
         $title= $request->input('title');
         $type= $request->input('type');
         $category= $request->input('category');
         $isDeleted= $request->input('isdeleted');
         $amount= $request->input('amount');
         $endDate=$request->input('enddate');
       $fixed->title=$title;
       $fixed->endDate=$endDate;
       $fixed->amount=$amount;
       $fixed->category=$category;
       $fixed->isDeleted=$isDeleted;
       $fixed->type=$type;
       $fixed->save();
        return response()->json([
            'message'=> 'Fixed transaction added successfully',
            'fixed'=> $fixed,
        ]);

    }

       public function getFixed(Request $request, $id){
        try{
       $fixed= Fixed::where('id',$id)->with(['admin'])->get()->firstOrFail();
        }catch(\Exception $exception){
        return response()->json([
            'message'=> 'The fixed transaction does not exist',
        ]);
          }
        return response()->json([
            'message'=> $fixed,
        ]);
    }

    //getFixedAll is not working


        public function getFixedAll(Request $request){
       $fixed= Fixed::with(['admin'])->get();
         return response()->json([
            'message'=> $fixed,
        ]);

       }
         public function deleteFixed(Request $request, $id){
       $fixed= Fixed::find($id);

       if ($fixed){
        $fixed->isDeleted = 1;
        $fixed->save();
                return response()->json([
            'message'=> 'The fixed transaction is deleted successfully.',
        ]);
    }else{
        return response()->json([
            'message'=> 'The fixed transaction does not exist.',
        ]);

    }


    }
      public function editFixed(Request $request, $id){

        $fixed= Fixed::find($id);
        $inputs= $request->except('_method');
              if ($fixed){
        $fixed->update($inputs);
         return response()->json([
            'message'=> 'Fixed transaction edited successfully',
            'fixed'=> $fixed,
        ]);

    }else{
        return response()->json([
            'message'=> 'The fixed transaction does not exist.',
        ]);
    }

    }

    public function calculateProfit()
{
    $income = Fixed::where('type', "income")->where('isdeleted', 0)->sum('amount');
    $expenses = Fixed::where('type', "expense")->where('isdeleted', 0)->sum('amount');
    $FixedProfit = $income - $expenses;
    return response()->json([
        "FIncome" => $income,
        "FExpenses" => $expenses,
        'FResults' => $FixedProfit,
          ]);

}


public function getFixedFilter(Request $request)
{
    $year = $request->input('year');
    $month = $request->input('month');
    $query = Fixed::where('isdeleted', 0);
    if ($year) {
        $query->whereYear('enddate', $year);
        if ($month) {
            $query->whereMonth('enddate', $month);
        }
    }
    $fixed = $query->get();
    $totalIncome = $fixed->where('type', 'income')->sum('amount');
    $totalExpenses = $fixed->where('type', 'expense')->sum('amount');
    $test = $totalIncome - $totalExpenses;
    return response()->json([
        'year' => $year,
        'month' => $month,
        'total_amount'=> $test
    ]);
}
}
