<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixed;
use App\Models\Admin;

class FixedController extends Controller
{


    //addFixed is not working

     public function addFixed(Request $request){

       $fixed= new Fixed();
    //    $admin_id= $request->input('admin_id');
    //      $admin= Admin::find($admin_id);
    $type= $request->input('type');
    $category= $request->input('category');
         $title= $request->input('title');
         
        //  $isdeleted= $request->input('isdeleted');
         $amount= $request->input('amount');
         $enddate=$request->input('enddate');
       
       $fixed->title=$title;
       $fixed->endDate=$enddate;
       $fixed->amount=$amount;
    //    $fixed->isdeleted=$isdeleted;
       $fixed->type=$type;
       $fixed->category=$category;
    //    $fixed->admin()->associate($admin);
       $fixed->save();

        return response()->json([
            'message'=> 'Fixed transaction added successfully',
            'fixed'=> $fixed,
        ]);

    }


       public function getFixed(Request $request, $id){
        try{
       $fixed= Fixed::where('id',$id)->get()->firstOrFail();
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
       $fixed= Fixed::get();
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
}



















