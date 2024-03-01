<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\CreateUserRequest;
use App\Http\Requests\V1\User\GetUsersRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UsersController extends Controller
{
     /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetUsersRequest $request)
    {
        $paginate = User::query()
                        ->when($request->input('search'), function(Builder $query, $search) {
                            $query->where(fn(Builder $q) => 
                                $q->where('name', 'LIKE', "%{$search}%"))
                                    ->orWhere('email', 'LIKE', "%{$search}%");
                        })
                        ->when($request->input('sort_by'), fn(Builder $query, $column) => $query->orderBy($column, $request->input('order', 'asc')))
                        ->paginate($request->input('per_page', 15));

        return UserCollection::make($paginate);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        return UserResource::make($user)
                        ->response()
                        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(status: 204);
    }
}
