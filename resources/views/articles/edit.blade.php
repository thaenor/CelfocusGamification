@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Articles / Edit </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('articles.update', $article->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$article->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <input type="text" name="title" class="form-control" value="{{$article->title}}"/>
                </div>
                    <div class="form-group">
                     <label for="body">BODY</label>
                     <input type="text" name="body" class="form-control" value="{{$article->body}}"/>
                </div>
                    <div class="form-group">
                     <label for="author">AUTHOR</label>
                     <input type="text" name="author" class="form-control" value="{{$article->author}}"/>
                </div>



            <a class="btn btn-default" href="{{ route('articles.index') }}">Back</a>
            <button class="btn btn-primary" type="submit" >Save</a>
            </form>
        </div>
    </div>


@endsection