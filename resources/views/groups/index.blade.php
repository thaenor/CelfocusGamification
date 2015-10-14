@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Groups</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th>VARIANT_NAME</th>
                        <th>POINTS</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->title}}</td>
                    <td>{{$group->variant_name}}</td>
                    <td>{{$group->points}}</td>

                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('groups.show', $group->id) }}">View</a>
                        <a class="btn btn-warning " href="{{ route('groups.edit', $group->id) }}">Edit</a>
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>

            <a class="btn btn-success" href="{{ route('groups.create') }}">Create</a>
        </div>
    </div>


@endsection