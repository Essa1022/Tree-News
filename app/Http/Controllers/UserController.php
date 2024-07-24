<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->can('see.user'))
        {
            $users = User::all();
            return $this->responseService->success_response($users);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function show(Request $request, string $id)
    {
        if($request->user()->can('see.user') || $request->user()->id == $id)
        {
            $user = User::find($id);
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

public function store(CreateUserRequest $request)
{
    if ($request->user()->can('create.user'))
    {
        $input = $request->except(['is_active']);
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        return $this->responseService->success_response($user);
    }
    else
    {
        return $this->responseService->unauthorized_response();
    }
}

public function update(UpdateUserRequest $request, string $id)
{
    if($request->user()->can('update.user') || $request->user()->id == $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        if (!$request->user()->hasRole(['Admin', 'Super_Admin']))
        {
            unset($input['is_active']);
        }
        $user->update($input);
        return $this->responseService->success_response($user);
    }
    else
    {
        return $this->responseService->unauthorized_response();
    }
    // $user = User::find(Auth::id());
    // $user->update($request->toArray());
    // return response()->json($user);
}

    // Destroy User
    public function destroy(Request $request)
    {
        if($request->user()->can('delete.user'))
        {
            $user_ids = $request->input('user_ids');
            User::destroy($user_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}
