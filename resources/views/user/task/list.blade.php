@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Task List</h2>
        <div class="row align-items-center d-flex">
            <div class="col-md-8">
                <form method="get" action="{{url()->current()}}">
                    <div class="card-title align-items-center flex-row d-flex">
                        <span>
                    <div>
                        <p class="m-0 d-block text-dark font-weight-bolder">Filter by:</p>
                    </div>
                </span>
                <span class="ml-4">
                    <select name="status" class="form-control form-control-solid form-control-md">
                        <option value="">--select status--</option>
                        <option value="0" @if(app('request')->status == "0") selected @endif>Private</option>
                        <option value="1" @if(app('request')->status == 1) selected @endif>Public</option>
                        @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
                        <option value="2" @if(app('request')->status == 2) selected @endif>Me and Admin</option>
                        @endif
                    </select>
                </span>
                <span class="ml-4">
                    <button type="submit" class="btn btn-primary filter-search-btn"><i class="fas fa-search"></i> Search</button>
                </span>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Task</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Sl No</th>
                @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
                <th>Task Assigned User</th>
                @endif
                <th scope="col">Task Description</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse(@$tasks as $task)
            <tr>
                <th> {{ @$loop->iteration }}</th>
                @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
                <td>
                    @foreach(@$users as $user)
                        @if(@$user->id == @$task->assigned_user_id)
                            {{ @$user->name }}
                        @endif
                    @endforeach
                </td>
                @endif
                <td>{{ @$task->description }}</td>
                <td>
                    <span id="hidden_task_id" style="display: none">{{@$task->id}}</span>
                    <select name="status" class="status label-inline font-weight-bolder mb-1 badge badge-info">
                        <option value="0" @if(@$task->status == 0) selected @endif>Private</option>
                        <option value="1" @if(@$task->status == 1) selected @endif>Public</option>
                        @if(\Illuminate\Support\Facades\Auth::user()->role_as == 1)
                            <option value="2" @if(@$task->status == 2) selected @endif>Admin & Assigned User</option>
                        @endif

                    </select>
                </td>
                <td>
                    <form action="{{route('tasks.destroy', @$task->id)}}" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr
            @empty
            <tr><td colspan="4" class="text-center">NO TASK FOUND</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
@endsection

@section('script')
    <script>
        $(".status").change(function () {
            var id = $(this).closest('tr').find('#hidden_task_id').html();
            var status_value = $(this).closest('tr').find('.status option:selected').val();
            console.log(id, status_value)
            $.ajax({
                url: "{{route('changeTaskStatus')}}",
                type: "POST",
                data: {"status": status_value, "id": id, "_token": "{{ csrf_token() }}",},
                success: function(response){ // What to do if we succeed
                    if(response.data == 'success'){
                        toastr.success("Task status has been changed");
                    } else{
                        toastr.error("Task status can not change")
                    }
                }
            });
        });
    </script>
@endsection
