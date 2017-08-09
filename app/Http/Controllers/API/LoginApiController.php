<?php

namespace App\Http\Controllers\API;

use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Users;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginApiController extends Controller
{
    public function login(Request $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = JWTAuth::attempt($credentials);
            $currentUser = Auth::user();
            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'username' => $currentUser->username,
                'staff_id' => $currentUser->staff_id,
                'email' => $currentUser->email,
                'token' => $token
            ]);
    }
}
