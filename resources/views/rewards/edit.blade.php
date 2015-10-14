@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Rewards / Edit </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('rewards.update', $reward->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$reward->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value="{{$reward->title}}"/>
                </div>
                    <div class="form-group">
                     <label for="assigned_user">ASSIGNED_USER</label>
                     <input type="text" name="assigned_user" class="form-control" value="{{$reward->assigned_user}}"/>
                </div>
                    <div class="form-group">
                     <label for="winner">WINNER</label>
                     <input type="text" name="winner" class="form-control" value="{{$reward->winner}}"/>
                </div>



            <a class="btn btn-default" href="{{ route('rewards.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Save</a>
            </form>
        </div>
    </div>


@endsection