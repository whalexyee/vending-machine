<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brick\Math\Internal\Calculator\BcMathCalculator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //Validate Request
        $role_id = [1,2];
        $fields = $request->validate([
            'username' => 'required|unique:users,username|string|min:2',
            'email' => 'string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role_id' => 'required|in:' . implode(',', $role_id).'|numeric',
        ]);

        //Begin Transaction!
        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $fields['username'],
                'email' => $fields['email'] ?? NULL,
                'password' => bcrypt($fields['password']),
                'role_id' => $fields['role_id']
            ]);
            $token = $user->createToken('authtoken')->plainTextToken;
            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token
            ],201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

    }

    public function login(Request $request)
    {

    }

}
