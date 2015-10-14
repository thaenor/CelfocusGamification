@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Rewards / Show </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$reward->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <p class="form-control-static">{{$reward->title}}</p>
                </div>
                    <div class="form-group">
                     <label for="assigned_user">ASSIGNED_USER</label>
                     <p class="form-control-static">{{$reward->assigned_user}}</p>
                </div>
                    <div class="form-group">
                     <label for="winner">WINNER</label>
                     <p class="form-control-static">{{$reward->winner}}</p>
                </div>
            </form>



            <a class="btn btn-default" href="{{ route('rewards.index') }}">Back</a>
            <a class="btn btn-warning" href="{{ route('rewards.edit', $reward->id) }}">Edit</a>
            <form action="#/$reward->id" method="DELETE" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><button class="btn btn-danger" type="submit">Delete</button></form>
        </div>
    </div>


@endsection