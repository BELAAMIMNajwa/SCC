<?php

namespace App\Modules\Users\Http\Controllers;

use App\Modules\Users\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string",
            "password" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "payload" => $validator->errors(),
                "status" => "406"
            ], 406);
        }

        $user = Users::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "payload" => "Incorrect email or password !",
                "status" => "401"
            ], 401);
        }

        $token = $user->createToken('token_name')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            "payload" => $response,
            "status" => "200"
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => $validator->errors(),
                'status' => '406'
            ], 406);
        }

        $user = Users::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
        ]);

        return response()->json($user, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function get($id)
    {
        return Users::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string',
            'FirstName' => 'string',
            'LastName' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'details' => $validator->errors()
            ], 400);
        }
    
        $user = Users::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json($user, 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => 'The requested row does not exist!',
                'status' => '404'
            ], 404);
        }

        Users::destroy($request->id);

        return response()->json(['message' => 'User deleted'], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => $validator->errors(),
                'status' => '406'
            ], 406);
        }

        $user = Users::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password changed'], 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'payload' => $validator->errors(),
                'status' => '406'
            ], 406);
        }

        $user = Users::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'payload' => 'User not found',
                'status' => '404'
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
