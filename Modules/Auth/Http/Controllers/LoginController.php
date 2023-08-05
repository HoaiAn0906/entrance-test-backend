<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login user and create token
     *
     * @return JsonResponse [string] access_token
     */
    protected function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            return responder()->error('auth.failed', trans('auth.failed'))
                ->respond(Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            return responder()->error('auth.failed', trans('auth.failed'))
                ->respond(Response::HTTP_UNAUTHORIZED);
        }

        $tokenResult = $user->createToken($user->email);
        $token = $tokenResult->token;
        $token->save();

        $refreshToken = bin2hex(random_bytes(32));
        if ($request->remember_me) {
            $user->remember_token = $refreshToken;
            $user->save();
        }


        return responder()->success([
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at->timestamp,
            'refresh_token' => $refreshToken,
        ])->respond();
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        $user->token()->revoke();
    }

    public function refreshToken(Request $request)
    {
        $user = User::query()->where('remember_token', $request->refresh_token)->first();

        if (empty($user)) {
            return responder()->error()->respond(500);
        }

        $tokenResult = $user->createToken($user->email);
        $token = $tokenResult->token;
        $token->save();

        $refreshToken = bin2hex(random_bytes(32));
        $user->remember_token = $refreshToken;
        $user->save();

        return responder()->success([
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at->timestamp,
            'refresh_token' => $refreshToken,
        ])->respond();
    }
}
