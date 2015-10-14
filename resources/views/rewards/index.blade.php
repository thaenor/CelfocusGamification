@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Rewards</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th>ASSIGNED_USER</th>
                        <th>WINNER</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($rewards as $reward)
                <tr>
                    <td>{{$reward->id}}</td>
                    <td>{{$reward->title}}</td>
                    <td>{{$reward->assigned_user}}</td>
                    <td>{{$reward->winner}}</td>

                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('rewards.show', $reward->id) }}">View</a>
                        <a class="btn btn-warning " href="{{ route('rewards.edit', $reward->id) }}">Edit</a>
                        <form action="{{ route('rewards.destroy', $reward->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>

            <a class="btn btn-success" href="{{ route('rewards.create') }}">Create</a>
        </div>
    </div>


@endsection