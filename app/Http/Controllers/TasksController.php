<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTasksRequest;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Jobs\newTaskManager as JobsNewTaskManager;
use App\Models\User;
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
        $user = User::findOrFail($tasks->delegated_user);
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
        $user = User::findOrFail($task->delegated_user);
        $this->sendMail($user, $task);
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
        $user_task = new stdClass();
        $task_user = new stdClass();
        $user_task->name = $user->name;
        $user_task->email =  $user->email;
        $task_user->title =  $task->title;
        $task_user->description =  $task->description;
        $task_user->start_date =  $task->start_date;
        $task_user->end_estimate_date = $task->end_estimate_date;
        $task_user->end_date =  $task->end_date;
        $task_user->status=  $task->status;
        $task_user->owner= $task->owner;
        $task_user->delegated_user= $task->delegated_user;
        JobsNewTaskManager::dispatch($user_task, $task_user)->delay(now()->addSeconds(10));
    }
}
