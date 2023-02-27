<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTasksRequest;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Jobs\newTaskManager as JobsNewTaskManager;
use stdClass;

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
        $this->validateTask($request);
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

        $this->validateTask($request);
        $task = Tasks::create($request->all());
        if( $task->save() ){
            return response()->json([
                'status' => true,
                'message' => "Tarefa Criada com sucesso!",
                'task' => $task
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
    public function validateTask($request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'date',
            'end_estimate_date' => 'required',
            'end_date' => 'nulable',
            'owner' => 'required|numeric',
            'delegated_user' => 'required|numeric',
        ]);
    }
    public function sendMail($user, $task)  
    {
        $user = new stdClass();
        $task = new stdClass();
        $user->name = "Marcos Camargo";
        $user->email = "marcos.marrize@gmail.com";
        $task->title = 'Primeira Tarefa';
        $task->description= 'Tarefa de criação de Documentação de API';
        $task->start_date= '02-25-2023 09:00:00';
        $task->end_estimate_date= '02-25-2023 09:00:00';
        $task->end_date= '02-25-2023 09:00:00';
        $task->status= 1;
        $task->owner= 1;
        $task->delegated_user= 2;
        JobsNewTaskManager::dispatch($user, $task)->delay(now()->addSeconds(10));
    }
}
