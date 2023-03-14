<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected function respondWithToken($token, $userType){
        $expiration = Auth::guard('admin')->factory()->getTTL() * 60; // TTL in seconds
        $response = response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user_type' => $userType,
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
        $user = Admin::create([
            'name' => $request->name,
            'password' => $request->password,
            'email' => $request->email,
            'type' => $type ? $type : 0,
        ]);
        $token = $user->createToken('authToken-'.$user->id)->plainTextToken;
        $userType = $user->type; // retrieve the user's type from the database
        $response = $this->respondWithToken($token, $userType);
        return $response;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userType = $user->type; // retrieve the user's type from the database
            $token = $user->createToken('authToken-'.$user->id)->plainTextToken;
            // $token = $user->createToken('MyAppToken', ['*'])->accessToken;


            return $this->respondWithToken($token, $userType);
        } else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }

    public function logout(){
        if (auth()->check()) {
            auth()->user()->tokens()->delete();
            Auth::guard('admin')->logout();
        }

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
            $user->tokens()->delete();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        } else if(!$user){
            return response()->json(['error' => 'User not found.'], 404);
        }
        else {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}


    protected function redirect(){
        return "hello world";
    }
}
