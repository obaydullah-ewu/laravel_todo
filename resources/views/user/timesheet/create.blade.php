@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Timesheet</h2>
    <hr>
    <form action="{{ route('timesheet.store') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="user_id">User Name</label>
            <div class='input-group' >
                <select name="user_id" class="form-control" required>
                    <option value="">--Select User--</option>
                    @foreach(@$users as $user)
                        <option value="{{ @$user->id }}">{{ @$user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="">Starting Time</label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control" name="start_date" required/>
                <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </span>
            </div>
        </div>
        <div class="form-group">
            <label for="">Ending Time</label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" name="end_date" required/>
                <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </span>
            </div>
        </div>
        <div class="form-group">
            <label for="">Pay Per Hour </label>
            <div class='input-group'>
                <input type='number' class="form-control" name="pay" min="0" required/>
                <span class="input-group-addon">
                <i class="fas fa-dollar-sign"></i>
            </span>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

</div>
@endsection
