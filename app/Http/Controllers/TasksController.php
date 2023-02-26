<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Models\Task;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Tasks::all();
        return response()->json($tasks, 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
            'start_date' => '',
            'end_estimate_date' => 'required',
            'end_date' => '',
            'owner' => 'required|numeric',
            'delegated_user' => 'required|numeric',
        ]);
        $tasks = Tasks::create($request->all());
        if( $tasks->save() ){
            return response()->json([
                'status' => true,
                'message' => "Tarefa Criada com sucesso!",
                'task' => $tasks
            ], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTasksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = Tasks::create($request->all());
        if( $tasks->save() ){
            return response()->json([
                'status' => true,
                'message' => "Tarefa Criada com sucesso!",
                'task' => $tasks
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Tasks::findOrFail( $id );
        return  ($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTasksRequest  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTasksRequest $request, Tasks $tasks)
    {
        $tasks->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Task Updated successfully!",
            'task' => $tasks
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = Tasks::findOrFail( $id );
        if( $tasks->delete() ){
            return response()->json([
                'status' => true,
                'message' => "Task Deleted successfully!",
            ], 200);
        }
    }
}
