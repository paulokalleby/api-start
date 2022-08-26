<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Traits\UserAuthTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use UserAuthTrait;
    
    protected $model;
    
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->model->whereEmail($request->email)->firstOrFail();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            throw ValidationException::withMessages([
    
                'email' => ['As credenciais fornecidas estão incorretas.'],
            
            ]);
            
        }

        if (!$user->active) {

            return response()->json([
                'message' => 'Usuário inativo'
            ], 403);

        }

        $user->tokens()->delete();

        return response()->json([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);
    }

    public function me()
    {
        return new UserResource(
            $this->loggedUser()
        );
    }

    public function logout()
    {
        $this->loggedUser()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }

}
