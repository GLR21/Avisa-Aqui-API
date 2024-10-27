<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Http\Resources\Api\V1\UserResource;

class AuthController extends Controller
{
    public function auth( AuthRequest $request)
    {
        $document = $request->document;
        $password = md5($request->password);

        $user = User::where('document', $document)->where('password', $password)->first();
        if($user){
            return new UserResource($user);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
