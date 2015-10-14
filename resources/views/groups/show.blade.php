@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Groups / Show </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$group->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <p class="form-control-static">{{$group->title}}</p>
                </div>
                    <div class="form-group">
                     <label for="variant_name">VARIANT_NAME</label>
                     <p class="form-control-static">{{$group->variant_name}}</p>
                </div>
                    <div class="form-group">
                     <label for="points">POINTS</label>
                     <p class="form-control-static">{{$group->points}}</p>
                </div>
            </form>



            <a class="btn btn-default" href="{{ route('groups.index') }}">Back</a>
            <a class="btn btn-warning" href="{{ route('groups.edit', $group->id) }}">Edit</a>
            <form action="#/$group->id" method="DELETE" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><button class="btn btn-danger" type="submit">Delete</button></form>
        </div>
    </div>


@endsection