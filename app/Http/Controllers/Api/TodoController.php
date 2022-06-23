<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $todos
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Vaidate Todo name
        $data = $request->only('name');
        $validator = Validator::make($data, [
            'name' => 'required'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $newTodo = new Todo;
        $newTodo->name = $request->name;
        $newTodo->save();

        return response()->json([
            'success' => true,
            'data' => $newTodo
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->only('id', 'name'), [
            'id' => 'required',
            'name' => 'required'
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $existTodo = Todo::find($request->id);

        if ($existTodo) {
            $existTodo->name = $request->name;
            $existTodo->save();
            
            return response()->json([
                'success' => true,
                'data' => $existTodo
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Todo not found'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existTodo = Todo::find($id);
        
        if ($existTodo) {
            $existTodo->completed = $request->todo['completed'] ? 1 : 0;
            $existTodo->completed_at = $request->todo['completed'] ? Carbon::now() : null;
            $existTodo->save();
            
            return response()->json([
                'success' => true,
                'data' => $existTodo
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Todo not found'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existTodo = Todo::find($id);

        if ($existTodo) {
            $existTodo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Todo successfully deleted'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Todo not found'
        ]);
    }
}
