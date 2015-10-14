@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Leagues / Create </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('leagues.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="promise_reward">PROMISE_REWARD</label>
                     <input type="text" name="promise_reward" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="max_points">MAX_POINTS</label>
                     <input type="text" name="max_points" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="min_points">MIN_POINTS</label>
                     <input type="text" name="min_points" class="form-control" value=""/>
                </div>



            <a class="btn btn-default" href="{{ route('leagues.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Create</a>
            </form>
        </div>
    </div>


@endsection