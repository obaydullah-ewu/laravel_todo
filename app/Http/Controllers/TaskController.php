<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $data['tasks'] = Task::where(function ($q) use ($status){
            if ($status || $status == "0"){
                $q->whereStatus($status);
            }
        })->whereUserId(Auth::user()->id)->paginate(10);

        if (Auth::user()->role_as == 1)
        {
            $data['tasks'] = Task::where(function ($q) use ($status){
                if ($status || $status == "0"){
                    $q->whereStatus($status);
                }
            })->whereNotNull('assigned_user_id')->paginate(10);
        }

        $data['users'] = User::all();
        return view('user.task.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::all();
        return view('user.task.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'description' => 'required',
//            'status' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
        $user = User::find(Auth::user()->id);
        $task = new Task();
        $task->user_id = Auth::user()->id;
        $task->description = $request->description;
        $task->status = $request->status ?? $request->admin_status;
        if ($user->role_as == 0){
            $task->assigned_user_id = Auth::user()->id;
        }else{
            $task->assigned_user_id = $request->assigned_user_id;
        }

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function changeTaskStatus(Request $request): JsonResponse
    {
        $user = Task::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'data' => 'success',
        ]);
    }
}
