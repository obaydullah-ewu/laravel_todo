@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User list</h1>
        <form method="get" action="{{url()->current()}}">

            <div class="card-title align-items-center flex-row d-flex">
                <span>
                    <div>
                        <p class="m-0 d-block text-dark font-weight-bolder">Filter by:</p>
                    </div>
                </span>
                <span class="ml-4">
                    <select name="status"
                            class="form-control form-control-solid form-control-md">
                        <option value="">--select status--</option>
                        <option value="1" @if(app('request')->status == 1) selected @endif>Active</option>
                        <option value="0" @if(app('request')->status == "0") selected @endif>Inactive</option>
                    </select>
                </span>
                <span class="ml-4">
                    <button type="submit" class="btn btn-primary filter-search-btn"><i class="fas fa-search"></i> Search</button>
                </span>

            </div>
        </form>
        <table class="table table-bordered data-table  table-striped">
            <thead>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Seen</th>
{{--                <th>Online/Offline Status</th>--}}
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role_as == 1)
                            Admin
                        @elseif($user->role_as == 0)
                            User
                        @endif
                    </td>
                    <td>
                        @if($user->role_as == 0)
                        <span id="hidden_user_id" style="display: none">{{$user->id}}</span>
                        <select name="status" class="status label-inline font-weight-bolder mb-1 badge badge-info">
                            <option value="1" @if($user->status == 1) selected @endif>Active</option>
                            <option value="0" @if($user->status == 0) selected @endif>Inactive</option>
                        </select>
                        @else
                            Active
                        @endif
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                    </td>
{{--                    <td>--}}
{{--                        @if(Cache::has('user-is-online-' . $user->id))--}}
{{--                            <span class="text-success">Online</span>--}}
{{--                        @else--}}
{{--                            <span class="text-secondary">Offline</span>--}}
{{--                        @endif--}}
{{--                    </td>--}}
                    <td>
                        @if($user->role_as == 0)
                        <form action="{{route('user.delete', $user->id)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @else
                            No needed
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">NO USER FOUND</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
@endsection

@section('script')
    <script>
        $(".status").change(function () {
            var id = $(this).closest('tr').find('#hidden_user_id').html();
            var status_value = $(this).closest('tr').find('.status option:selected').val();
            console.log(id, status_value)
            $.ajax({
                url: "{{route('changeUserStatus')}}",
                type: "POST",
                data: {"status": status_value, "id": id, "_token": "{{ csrf_token() }}",},
                success: function(response){ // What to do if we succeed
                    if(response.data == 'success')
                    {
                        toastr.success("User status has been changed");
                    }
                    else{
                        toastr.error("User status can not change")
                    }

                }
            });
        });
    </script>
@endsection
