@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Leagues</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th>PROMISE_REWARD</th>
                        <th>MAX_POINTS</th>
                        <th>MIN_POINTS</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($leagues as $league)
                <tr>
                    <td>{{$league->id}}</td>
                    <td>{{$league->title}}</td>
                    <td>{{$league->promise_reward}}</td>
                    <td>{{$league->max_points}}</td>
                    <td>{{$league->min_points}}</td>

                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('leagues.show', $league->id) }}">View</a>
                        <a class="btn btn-warning " href="{{ route('leagues.edit', $league->id) }}">Edit</a>
                        <form action="{{ route('leagues.destroy', $league->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>

            <a class="btn btn-success" href="{{ route('leagues.create') }}">Create</a>
        </div>
    </div>


@endsection