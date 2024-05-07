<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function messages()
    {
        return $messages = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.min' => 'El nombre debe tener al menos 4 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de texto',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password_confirmation.required' => 'La confirmación de la contraseña es requerida',
            'password_confirmation.string' => 'La confirmación de la contraseña debe ser una cadena de texto',
            'password_confirmation.min' => 'La confirmación de la contraseña debe tener al menos 6 caracteres',
            'password_confirmation.same' => 'La confirmación de la contraseña debe coincidir con la contraseña',
        ];
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['err' => $validator->errors()->first()], 206);
        }

        if ($request->password !== $request->password_confirmation) {
            return response()->json([
                'message' => 'Password confirmation does not match',
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['err' => $validator->errors()->first()], 206);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth()->user();

        //si tiene token se elimina
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });

        $token = $user->createToken('token-name')->accessToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    public function show(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
