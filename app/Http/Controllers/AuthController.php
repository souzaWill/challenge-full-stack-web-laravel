<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Autenticação
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * Permite que um usuário faça login na aplicação. somente admins tem acesso a api
     *
     * @bodyParam email string required O endereço de e-mail do usuário. Exemplo: user@example.com
     * @bodyParam password string required A senha do usuário. Exemplo: secret
     *
     * @response 200 {
     *    "success": true,
     *    "data": {
     *        "token": "1|abc1234567...",
     *        "name": "John Doe"
     *    },
     *    "message": "User login successfully."
     * }
     * @response 401 {
     *    "success": false,
     *    "message": "Unauthorized"
     * }
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => RoleEnum::Admin->value, //only admins can login
        ];

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            $user->tokens()->delete();
            $success['token'] = $user->createToken('api')->plainTextToken;
            $success['name'] = $user->name;

            return response()->json([
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => __('auth.failed'),
        ], 401);
    }

    /**
     * Logout do usuário
     *
     * Revoga o token de autenticação atual do usuário, efetuando o logout.
     *
     *
     * @authenticated
     *
     * @response 200 {
     *    "status": "success",
     *    "message": "User logged out successfully"
     * }
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
        ], 200);
    }
}
