@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Add Task</h2>
        <form action="{{ route('tasks.store') }}" method="post">
        @csrf
            <label class="task"><b>Task Description</b></label>
            <br>
            <textarea name="description" id="task" cols="30" rows="5" class="form-control" required></textarea>
            <br>
            @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
            <label for=""><b>Task for</b></label>
            <select name="assigned_user_id" id="status" class="form-control form-control-solid form-control-md">
                <option value="">--Select user--</option>
                @foreach(@$users as $user)
                    <option value="{{ @$user->id }}">{{ @$user->name }}</option>
                @endforeach
            </select>
            <br>
            @endif
            <label for="status"><b>Status</b></label>
            <select name="status" id="status"
                    class="form-control form-control-solid form-control-md" required>
                <option value="">--Select Status--</option>
                <option value="0">Private</option>
                <option value="1">Public</option>
                @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
                    <option value="2">Admin & Assigned User</option>
                @endif
            </select>
            <br>
            <input type="submit" class="btn btn-primary"></input>
        </form>
    </div>

@endsection
