<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use App\Models\User;
use Illuminate\Http\Request;
use function Composer\Autoload\includeFile;

class TimeSheetController extends Controller
{
    public function index(Request $request)
    {
        $search_id = $request->search_id;
        $data['timesheet'] = TimeSheet::where(function ($q) use ($search_id){
            if ($search_id){
                $q->whereUserId($search_id);
            }
        })->paginate(20);
        $data['users'] = User::all();

        return view('user.timesheet.list')->with($data);
    }

    public function create(Request $request)
    {
        $data['users'] = User::all();
        return view('user.timesheet.create')->with($data);
    }

    public function store(Request $request)
    {
        $time = new TimeSheet();
        $time->user_id = $request->user_id;
        if ($request->start_date) {
            $time->start_date = date('Y-m-d H:i:s', strtotime($request->start_date));
        }

        if ($request->end_date) {
            $time->end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
        };

        if ($request->end_date) {
            $from = strtotime($request->start_date);
            $to = strtotime($request->end_date);


            if ($to < $from) {
                return redirect()->back()->with('info', 'End time must be greater than start time');
            }

            $duration = strtotime($request->end_date) - strtotime($request->start_date);
            $hourdiff = round($duration / 3600, 1);
            $time->duration = $hourdiff;
            $time->total_pay = $request->pay * $hourdiff;
        }

        $time->pay_hour = $request->pay;
        $time->save();

        return redirect()->route('timesheet.index')->with('success', 'Time Card Created Successfully');
    }

    public function edit($id)
    {
        $data['time'] = TimeSheet::find($id);
        $data['users'] = User::all();
        return view('user.timesheet.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $time = TimeSheet::find($id);
        $time->user_id = $request->user_id;
        if ($request->start_date) {
            $time->start_date = date('Y-m-d H:i:s', strtotime($request->start_date));
        }

        if ($request->end_date) {
            $time->end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
        };

        if ($request->end_date) {
            $from = strtotime($request->start_date);
            $to = strtotime($request->end_date);


            if ($to < $from) {
                return redirect()->back()->with('info', 'End time must be greater than start time');
            }

            $duration = strtotime($request->end_date) - strtotime($request->start_date);
            $hourdiff = round($duration / 3600, 1);
            $time->duration = $hourdiff;
            $time->total_pay = $request->pay * $hourdiff;
        }

        $time->pay_hour = $request->pay;
        $time->save();

        return redirect()->route('timesheet.index')->with('success', 'Time Card Updated Successfully');
    }

    public function delete($id)
    {
        $time = TimeSheet::find($id);
        $time->delete();

        return redirect()->back()->with('success', 'Deleted Successful');
    }
}
