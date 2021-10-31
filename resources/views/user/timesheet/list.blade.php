@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Timesheet list</h1>
        <div class="col-md-8">
            <form method="get" action="{{url()->current()}}">

                <div class="card-title align-items-center flex-row d-flex">
                <span>
                    <div>
                        <p class="m-0 d-block text-dark font-weight-bolder">Filter by:</p>
                    </div>
                </span>
                    <span class="ml-4">
                    <select name="search_id"
                            class="form-control form-control-solid form-control-md">
                        <option value="">--Select User--</option>
                        @foreach(@$users as $user)
                        <option value="{{ @$user->id }}" @if(app('request')->search_id == @$user->id) selected @endif>{{ @$user->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span class="ml-4">
                    <button type="submit" class="btn btn-primary filter-search-btn"><i class="fas fa-search"></i> Search</button>
                </span>

                </div>
            </form>
        </div>
        <div class="col-md-4">
            <a href="{{ route('timesheet.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Timesheet</a>
        </div>
        <table class="table table-bordered data-table  table-striped">
            <thead>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                <th>Pay Per Hour</th>
                <th>Total Pay</th>
                <th colspan="2" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($timesheet as $item)
                <tr>
                    <td>{{ @$loop->iteration }}</td>
                    <td>{{ @$item->user->name }}</td>
                    <td>{{ @$item->start_date }}</td>
                    <td>{{ @$item->end_date }}</td>
                    <td>{{ @$item->duration ?? 0 }} Hour</td>
                    <td>$ {{ @$item->pay_hour ?? 0 }}</td>
                    <td>$ {{ @$item->total_pay ?? 0 }}</td>
                    <td><a href="{{ route('timesheet.edit', @$item->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
                    <td>
                        <form action="{{route('timesheet.delete', $item->id)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">NO RECORD FOUND</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $timesheet->links('pagination::bootstrap-4') }}
    </div>
@endsection





