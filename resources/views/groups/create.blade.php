@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Groups / Create </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('groups.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="variant_name">VARIANT_NAME</label>
                     <input type="text" name="variant_name" class="form-control" value=""/>
                </div>
                    <div class="form-group">
                     <label for="points">POINTS</label>
                     <input type="text" name="points" class="form-control" value=""/>
                </div>



            <a class="btn btn-default" href="{{ route('groups.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Create</a>
            </form>
        </div>
    </div>


@endsection