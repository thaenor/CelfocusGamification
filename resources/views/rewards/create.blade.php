@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Rewards / Create </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('rewards.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="assigned_user">ASSIGNED_USER</label>
                     <input type="text" name="assigned_user" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="winner">WINNER</label>
                     <input type="text" name="winner" class="form-control" value=""/>
                </div>

                <hr/>
                <h2>Reward for:</h2>
                <div class="form-group">
                    <select class="form-control">
                        @foreach($jsonData as $ticket)
                            <option value="{{$ticket->id}}">{{$ticket->title}}</option>
                        @endforeach
                    </select>
                </div>


            <a class="btn btn-default" href="{{ route('rewards.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Create</a>
            </form>
        </div>
    </div>


@endsection