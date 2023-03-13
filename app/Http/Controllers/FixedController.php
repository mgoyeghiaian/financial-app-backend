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
       $admin_id= $request->input('admin_id');
         $admin= Admin::find($admin_id);
         $title= $request->input('title');
         $type= $request->input('type');
         $isDeleted= $request->input('isDeleted');
         $amount= $request->input('amount');
         $endDate=$request->input('endDate');
       $fixed->title=$title;
       $fixed->endDate=$endDate;
       $fixed->amount=$amount;
       $fixed->isDeleted=$isDeleted;
       $fixed->type=$type;
       $fixed->admin()->associate($admin);
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
        $fixed->delete();

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
    $income = Fixed::where('type', "income")->sum('amount');
    $expenses = Fixed::where('type', "expense")->sum('amount');
    $FixedProfit = $income - $expenses;

    return response()->json([
        "FIncome" => $income,
        "FExpenses" => $expenses,
        'FResults' => $FixedProfit,
          ]);

}


public function getFixedFilter(Request $request){
    $year = $request->input('year'); // add this line to get the year input
    $query = Fixed::where('isdeleted', 0); // add this line to define the query builder
    if ($year) {
        $query->whereYear('created_at', $year);
    }
    $fixed = $query->get();
    $totalIncome = $fixed->where('type', 'income')->sum('amount');
    $totalExpenses = $fixed->where('type', 'expense')->sum('amount');
    $test = $totalIncome - $totalExpenses;
    return response()->json([
        'year' => $year,
     'total_amount'=> $test ]);
}
}



















