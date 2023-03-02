<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Admin;

class ReportController extends Controller
{
     public function addReport(Request $request){


       $report= new Report;


         $type= $request->input('type');
         $date= $request->input('date');
         $isdeleted= $request->input('isdeleted');
         $netincome= $request->input('netincome');
         $netexpenses= $request->input('netexpenses');


       $report->type=$type;
       $report->isdeleted=$isdeleted;
       $report->date=$date;
       $report->netincome=$netincome;
       $report->netexpenses=$netexpenses;

       $report->save();

        return response()->json([
            'message'=> 'Report is created successfully',
            'Report'=>$report,
        ]);

    }


         public function getReport(Request $request, $id){
       $report= Report::where('id',$id)->get();
        return response()->json([
            'message'=> $report,
        ]);
    }

         public function getReportAll(Request $request){
       $report= Report::get();
        return response()->json([
            'message'=> $report,
        ]);
    }

      public function deleteReport(Request $request, $id){
       $report= Report::find($id);
       $report->delete();
        return response()->json([
            'message'=> 'The report is deleted successfully',
        ]);

}



      public function editReport(Request $request, $id){

        $report= Report::find($id);
        $inputs= $request->except('_method');
        $report->update($inputs);
        return response()->json([
            'message'=> 'Report edited successfully',
            'report'=> $report,
        ]);






    }

}
