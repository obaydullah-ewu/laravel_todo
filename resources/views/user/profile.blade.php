@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Profile</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/demo.png') }}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><b>Name</b>: {{ \Illuminate\Support\Facades\Auth::user()->name }}</h5>
                            <p class="card-text"><b>Total Work Duration</b> : {{ @$user_info->total_worked_duration ?? 0 }} Hour</p>
                            <p class="card-text"><b>Total Pay</b>: $ {{ @$user_info->total_pay ?? 0 }}</p>
                            <p class="card-text"><b>Total Task</b>: {{ @$user_info->total_task_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        <hr>
    </div>
@endsection
