<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $statusCode = 200;

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $rules = [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $messages = [
            'required' => ':attribute harus di isi.',
            'email' => ':attribute harus email yang valid.',
            'unique' => ':attribute sudah ada.'
        ];

        $customAttributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password'
        ];

        $validator = Validator::make($input, $rules, $messages, $customAttributes);


        if ($validator->fails()) {
            $data = [
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ];

            $statusCode = 400;
        } else {
            $user = User::create($validator->validated());

            $data = [
                'message' => 'User created successfully',
                'user' => $user
            ];
        }


        return response()->json($data, $statusCode);
    }

    public function login(Request $request)
    {
        $statusCode = 200;

        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $messages = [
            'email.required' => 'Email harus di isi.',
            'email.email' => 'Email harus email yang valid.',
            'password.required' => 'Password harus di isi.'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        } else {

            $user = User::where('email', $input['email'])->first();

            if (!$user || !Hash::check($input['password'], $user->password)) {

                $data = [
                    'message' => 'Invalid credentials',
                ];
                $statusCode = 401;
            } else {
                $token = $user->createToken('auth_token')->plainTextToken;

                $data = [
                    'message' => 'User logged in successfully',
                    'user' => $user,
                    'token' => $token
                ];
            }
        }



        return response()->json($data, $statusCode);
    }
}