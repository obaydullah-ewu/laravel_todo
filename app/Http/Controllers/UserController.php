<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile()
    {
        $data['user'] = User::find(Auth::user()->id);
        $data['user_info'] =  User::withCount([
            'timesheets as total_worked_duration' => function ($query) {
                $query->select(DB::raw("SUM(duration) as total"));
            },
            'timesheets as total_pay' => function ($query) {
                $query->select(DB::raw("SUM(total_pay) as total_pay"));
            },
            'tasks as total_task_count' => function ($query) {
                $query->select(DB::raw("COUNT(id) as total_task_count"));
            }

        ])->whereId(Auth::user()->id)->first();

        return view('user.profile')->with($data);
    }

    public function userLists(Request $request)
    {
        $status = $request->status;
        $data['users'] = User::where(function ($q) use ($status){
            if ($status || $status == "0"){
                $q->whereStatus($status);
            }
        })->paginate(10);

        return view('user.users')->with($data);
    }

    public function userDelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }

    public function resetPasswordForm()
    {
        return view('user.reset-password');
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password'   => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if ($request->new_password === $request->confirm_password) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Updated password');
        } else {
            return back()->with('error', 'Password and confirm password not matched');
        }
    }

    public function changeUserStatus(Request $request): JsonResponse
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

}
