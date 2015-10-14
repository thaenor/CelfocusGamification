@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Tickets</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>State</th>
                        <th>SLA name/priority</th>
                        <th>User</th>
                        <th>Points</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($tickets as $ticket)

                <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->title}}</td>
                    <td>{{$ticket->priority}}</td>
                    <td>{{$ticket->state}}</td>
                    <td>{{$ticket->sla}}</td>
                    <td>{{$ticket->user_id}}</td>
                    <td>{{$ticket->points}}</td>

                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('tickets.show', $ticket->id) }}">View</a>
                        <a class="btn btn-warning " href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>

            <a class="btn btn-success" href="{{ route('tickets.create') }}">Create</a>
        </div>
    </div>


@endsection