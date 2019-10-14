<?php

namespace App\Http\Controllers\Auth;

use Avatar;
use Storage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Su Usuario o contraseña no es correcta verifica y vuelva intentar'], 401);
        }
        $user = User::where('email',  $request->email)->first();
        if ($user->estado_user == 2) {
            return response()->json([
                'message' => 'Usuario deshabilitado pongase en contacto jarboleda@sumimedical.com'
            ], 403);
        }
        $user = $request->user();
        $user->getAllPermissions();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'user'         => $user,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
            ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' =>  'Su Cierre de Sesion fue Exitoso ',
        ], 200);
    }

    public function user(Request $request)
    {
        $request->user()->getAllPermissions();
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }
}
