@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Leagues / Show </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$league->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <p class="form-control-static">{{$league->title}}</p>
                </div>
                    <div class="form-group">
                     <label for="promise_reward">PROMISE_REWARD</label>
                     <p class="form-control-static">{{$league->promise_reward}}</p>
                </div>
                    <div class="form-group">
                     <label for="max_points">MAX_POINTS</label>
                     <p class="form-control-static">{{$league->max_points}}</p>
                </div>
                    <div class="form-group">
                     <label for="min_points">MIN_POINTS</label>
                     <p class="form-control-static">{{$league->min_points}}</p>
                </div>
            </form>



            <a class="btn btn-default" href="{{ route('leagues.index') }}">Back</a>
            <a class="btn btn-warning" href="{{ route('leagues.edit', $league->id) }}">Edit</a>
            <form action="#/$league->id" method="DELETE" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><button class="btn btn-danger" type="submit">Delete</button></form>
        </div>
    </div>


@endsection