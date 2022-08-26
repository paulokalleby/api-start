<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    protected $model;
    
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function store(RegisterRequest $request)
    {

        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = $this->model->create($data);

        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);

    }
}
