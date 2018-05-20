<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Todo::query()
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function todos(): JsonResponse
    {
        $loggedUser = Auth::user();

        $friendsTodo = $loggedUser->friends()
            ->join('todos', 'todos.user_id', '=', 'users.id')
            ->orderBy('todos.created_at', 'desc')
            ->get(['todos.*']);

        $ownAndPublicTodo = Todo::query()
            ->where('visibility', '=', Todo::PUBLIC_VISIBILITY)
            ->orWhere('user_id', '=', $loggedUser->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $result = $friendsTodo->merge($ownAndPublicTodo)->sortByDesc('created_at')->values()->all();

        return response()->json($result);
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
        $todo = new Todo($request->all());

        Auth::user()->todo()->save($todo);

        return response()->json($todo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
