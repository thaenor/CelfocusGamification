@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Leagues / Edit </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('leagues.update', $league->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$league->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value="{{$league->title}}"/>
                </div>
                    <div class="form-group">
                     <label for="promise_reward">PROMISE_REWARD</label>
                     <input type="text" name="promise_reward" class="form-control" value="{{$league->promise_reward}}"/>
                </div>
                    <div class="form-group">
                     <label for="max_points">MAX_POINTS</label>
                     <input type="text" name="max_points" class="form-control" value="{{$league->max_points}}"/>
                </div>
                    <div class="form-group">
                     <label for="min_points">MIN_POINTS</label>
                     <input type="text" name="min_points" class="form-control" value="{{$league->min_points}}"/>
                </div>



            <a class="btn btn-default" href="{{ route('leagues.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Save</a>
            </form>
        </div>
    </div>


@endsection