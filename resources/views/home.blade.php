@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" class="text-center">{{ __('All User Task List') }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse(@$tasks as $task)

            @if(Auth::user()->id == $task->assigned_user_id || @$task->status == 1)
                <div class="col-md-4">
                    <div class="card border-success mb-3" style="max-width: 18rem;">
                        <div class="card-header bg-transparent border-success"><small>Assigend for: </small>{{ @$task->user->name }}</div>
                        <div class="card-body text-success">
                            <p class="card-text">{{ @$task->description }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-success">
                            <p class="card-text"><small class="text-muted">Last updated {{ Carbon\Carbon::parse(@$task->updated_at)->diffForHumans() }}</small></p>
                            @if(@$task->status == 0)
                                <small class="text-muted"><i class="fas fa-eye"></i> Private</small>
                            @elseif(@$task->status == 1)
                                <small class="text-muted"><i class="fas fa-eye"></i> Public</small>
                            @elseif(@$task->status == 2)
                                <small class="text-muted"><i class="fas fa-eye"></i> Admin & Assigned User</small>
                            @endif
                            <p></p>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div>
                <p class="text-justify-center">NO TASK FOUND</p>
            </div>

        @endforelse
    </div>

</div>
@endsection
