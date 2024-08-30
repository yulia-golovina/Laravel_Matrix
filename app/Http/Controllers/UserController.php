<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;

class UserController
{
    public function show($id) {
        try {
            $userData = User::with('posts.user')->findOrFail($id);
            return (new UserResource($userData))->response()->setStatusCode(200, 'OK');
        }
        catch(ModelNotFoundException $e)
        {
            report($e);
            return response('Not found ID')->setStatusCode(204);
        }
    }
}
