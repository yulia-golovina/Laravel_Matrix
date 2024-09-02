<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmailJob;

class UserController
{

    public function index() {
        $users = User::with('posts')->get();
        return UserResource::collection($users)->response();
    }
    public function show($id) {
        try {
            return Cache::remember('user_' . $id, 900, function() use ($id) {
                $user = User::with('posts.user')->findOrFail($id);
                SendEmailJob::dispatchSync($user);
                return (new UserResource($user))->response()->setStatusCode(200, 'OK');
            });

            // return Cache::get("user_$id");
        }
        catch(ModelNotFoundException $e)
        {
            report($e);
            return response('Not found ID')->setStatusCode(204);
        }
    }
}
