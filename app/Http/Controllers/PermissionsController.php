<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    public function delete_user_validate(User $user)
    {
        if(Auth::user()->can('delete', $user)){
            return response()->json(['message' => 'You Have Permission to delete a User'], 200);
        }

        return response()->json(['message' => 'You don\'t Have Permission to delete a User'], 403);
    }
}
