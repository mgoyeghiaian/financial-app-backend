<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Admin;
use App\Http\Controllers\FixedController;
use App\Http\Controllers\RecurringController;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
     public function addReport(Request $request){
 $report= new Report;
 $title= $request->input('title');
 $type= $request->input('type');
 $category= $request->input('category');
 $amount= $request->input('amount');
 $isDeleted = $request->input('isdeleted');
       $report->title =$title;
       $report->amount =$amount;
       $report->type =$type;
       $report->category =$category;
       $report->isDeleted =$isDeleted;
       $report->save();
        return response()->json([
            'message'=> 'Report is created successfully.',
            'Report'=>$report,
        ]);
    }
         public function getReport(Request $request, $id){
            try{
       $report= Report::where('id',$id)->get()->firstOrFail();
            }catch(\Exception $exception){
                return response()->json([
            'message'=> 'Report is not found.',
        ]);

            }
        return response()->json([
            'message'=> $report,
        ]);
    }
    //getReportAll is not working

         public function getReportAll(Request $request){
            try{
       $report= Report::get();
            }catch(\Exception $exception){
                return response()->json([
            'message'=> 'There are no reports.',
        ]);
            }
        return response()->json([
            'message'=> $report,
        ]);
    }

      public function deleteReport(Request $request, $id){
       $report= Report::find($id);

      if ($report){
        $report->delete();

         return response()->json([
            'message'=> 'The report is deleted successfully.',
        ]);
    }else{
        return response()->json([
            'message'=> 'The report does not exist.',
        ]);

    }
}
      public function editReport(Request $request, $id){

        $report= Report::find($id);
        $inputs= $request->except('_method');
        if($report){

        $report->update($inputs);
        return response()->json([
            'message'=> 'Report edited successfully.',
            'report'=> $report,
        ]);
    }else{
         return response()->json([
            'message'=> 'The report does not exist.',
        ]);
    }
    }
}
