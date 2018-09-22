@extends('app')

@section('title', __('Tasks list'))

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('Date')</th>
                <th>@lang('Statuses')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->created_at }}</td>
                    <td>
                        @foreach ($task->statuses as $status)
                            <p><b>{{ $status->email }}</b>: <i>{{ $status->status }}</i></p>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $tasks->links() }}
    </div>
@endsection