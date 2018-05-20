<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function friends(): JsonResponse
    {
        return response()->json(Auth::user()->friends);
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFriend($userId): JsonResponse
    {
        $friendToAdd = User::query()->find($userId);
        $loggedUser = Auth::user();

        if (!$friendToAdd) {
            return response()->json(['error' => sprintf('User id %s not found to add', $userId)], 400);
        }

        if ($loggedUser->id === $userId) {
            return response()->json(['error' => "You can not add yourself", 400]);
        }

        if ($loggedUser->hasFriendWithId($friendToAdd->id)) {
            return response()->json(['error' => "You are already friends", 400]);
        }

        $loggedUser->addFriendById($friendToAdd->id);

        return response()->json(['success' => true]);
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFriend($userId): JsonResponse
    {
        $friendToRemove = User::query()->find($userId);
        $loggedUser = Auth::user();

        if (!$friendToRemove) {
            return response()->json(['error', sprintf('User id %s not found to remove', $userId)], 400);
        }

        if ($loggedUser->id === $userId) {
            return response()->json(['error', 'You can not remove yourself'], 400);
        }

        if (!$loggedUser->hasFriendWithId($userId)) {
            return response()->json(['error', sprintf('User id %s is not your friend', $userId)], 400);
        }

        $loggedUser->removeFriendById($userId);

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
