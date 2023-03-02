<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixed;
use App\Models\Admin;

class FixedController extends Controller
{


     public function addFixed(Request $request){


       $fixed= new Fixed;
       $admin_id= $request->input('admin_id');
         $admin= Admin::find($admin_id);
         $title= $request->input('title');
         $type= $request->input('type');
         $isdeleted= $request->input('isdeleted');
         $amount= $request->input('amount');
         $enddate=$request->input('enddate');

       $fixed->title=$title;
       $fixed->endDate=$enddate;
       $fixed->amount=$amount;
       $fixed->isdeleted=$isdeleted;
       $fixed->type=$type;
       $fixed->admin()->associate($admin);
       $fixed->save();

        return response()->json([
            'message'=> 'Fixed transaction added successfully',
            'fixed'=> $fixed,
        ]);

    }


       public function getFixed(Request $request, $id){
       $fixed= Fixed::where('id',$id)->with(['admin'])->get();
        return response()->json([
            'message'=> $fixed,
        ]);
    }


        public function getFixedAll(Request $request){
       $fixed= Fixed::with(['admin'])->get();
        return response()->json([
            'message'=> $fixed,
        ]);
    }




         public function deleteFixed(Request $request, $id){
       $fixed= Fixed::find($id);
       $fixed->delete();
        return response()->json([
            'message'=> 'the fixed transaction is deleted successfully',
        ]);


    }



      public function editFixed(Request $request, $id){

        $fixed= Fixed::find($id);
        $inputs= $request->except('_method');
        $fixed->update($inputs);
        return response()->json([
            'message'=> 'Fixed transaction edited successfully',
            'fixed'=> $fixed,
        ]);








    }




}
