<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function addAdmin(Request $request){
$admin = new Admin;
$username = $request->input('username');
$password = $request->input('password');
//$isdeleted= $request->isdeleted=='off' ? 0 : 1;
//$issuper = $request->isSuper=='off' ? 0 : 1;
$admin->username=$username;
$admin->password=$password;
//$admin->isDeleted=$isdeleted;
//$admin->isSuper=$issuper;
$admin->save();
return ; return response()->json([
    'message' => '$username created successfully',
]);
   }
}
