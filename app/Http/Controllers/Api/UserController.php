<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Api\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'id');
        $sortDirection = request('sort_direction', 'desc');

        $query = User::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return UserResource::collection($query);
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $user = User::create($data);

        return new UserResource($user);
    }
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
        } catch (\Exception $e) {
            return response($e, 400);
        }
        if($request->password) {
            $data['password'] = $request->password;
        }
        $data['updated_by'] = $request->user()->id;

        $user->update($data);

        return new UserResource($user);
    }
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
