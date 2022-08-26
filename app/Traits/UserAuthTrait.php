<?php 

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserAuthTrait 
{
    private function loggedUser(): User
    {
        return Auth::user();
    }
}