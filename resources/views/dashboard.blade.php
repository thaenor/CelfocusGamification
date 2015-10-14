@extends('layout')

@section('content')

    <div class="page-header">
        <h1>Dashboard Tickets</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ticket id</th>
                    <th>ticket title</th>
                    <th>assigned to</th>
                    <th>sla</th>
                    <th>priority</th>
                    <th>state</th>
                    <th>timeout</th>
                    <th>will reward (in points)</th>

                    <!--<th class="text-right">OPTIONS</th>-->
                </tr>
                </thead>

                <tbody>

                @foreach($jsonData as $ticket)
                    <tr>
                        <td>{{$ticket->id}}</td>
                        <td>{{$ticket->title}}</td>
                        <td>{{$ticket->first_name}}&nbsp;{{$ticket->last_name}}</td>
                        <td>{{$ticket->sla_name}}</td>
                        <td>{{$ticket->priority}}</td>
                        <td>{{$ticket->ticket_state}}</td>
                        <td>{{$ticket->timeout}}</td>
                        <td>{{$ticket->priority_id + ($ticket->timeout/100000000)}}</td>

{{--
                        <td class="text-right">
                            <a class="btn btn-primary" href="{{ route('leagues.show', $league->id) }}">View</a>
                            <a class="btn btn-warning " href="{{ route('leagues.edit', $league->id) }}">Edit</a>
                            <form action="{{ route('leagues.destroy', $league->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                        </td>
--}}
                    </tr>

                @endforeach

                </tbody>
            </table>

            <div class="well">
                <hr/>
                <button class="btn-warning">Raw Json data for debug purpose only</button>
                <hr/>
                <article>{{json_encode($jsonData, true)}}</article>
            </div>

{{--        <a class="btn btn-success" href="{{ route('leagues.create') }}">Create</a> --}}
        </div>
    </div>


@endsection