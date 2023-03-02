<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected function respondWithToken($token){
        $expiration = Auth::guard('admin')->factory()->getTTL() * 60; // TTL in seconds
        $response = response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
        ]);
        $response->withCookie($this->setTokenCookie($token));
        return $response;
    }
    
    protected function setTokenCookie($token){
        $expiration = Auth::guard('admin')->factory()->getTTL() * 60; // TTL in seconds
        return cookie('token', $token, $expiration, null, null, false, true);
    }
    
    public function register(Request $request){
        $type = $request->type;
        $user=Admin::create([
            'name' =>$request->name,
            'password' =>$request->password,
            'email' =>$request->email,
            'type'=> $type ? $type : 0,
        ]);
        $token = Auth::guard('admin')->login($user);
        $response = $this->respondWithToken($token);
        return $response;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userType = $user->type; // retrieve the user's type from the database
            $token = $user->createToken('authToken')->accessToken;
    
            if($userType == '1') {
                return response()->json(['message' => 'Success! You will be redirected to the clickable link.']);
            } else {
                return response()->json(['access_token' => $token, 'user_type' => $userType]);
            }
        } else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        $response = response()->json(['message' => 'Successfully logged out.']);
        $response->withCookie(cookie('token', null, -1, null, 'localhost:8000'));
        return $response;
    }

    public function allUsers(){
        $users = Admin::all();
        return response()->json($users);
    }

    public function update(Request $request, $id){
        $user = Admin::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->name = $request->input('name');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->type = $request->input('type') ?? $user->type;
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function delete($id){
        $user = Admin::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }
}