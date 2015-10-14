@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Articles / Show </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$article->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <p class="form-control-static">{{$article->title}}</p>
                </div>
                    <div class="form-group">
                     <label for="body">BODY</label>
                     <p class="form-control-static">{{$article->body}}</p>
                </div>
                    <div class="form-group">
                     <label for="author">AUTHOR</label>
                     <p class="form-control-static">{{$article->author}}</p>
                </div>
            </form>



            <a class="btn btn-default" href="{{ route('articles.index') }}">Back</a>
            <a class="btn btn-warning" href="{{ route('articles.edit', $article->id) }}">Edit</a>
            <form action="#/$article->id" method="DELETE" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><button class="btn btn-danger" type="submit">Delete</button></form>
        </div>
    </div>


@endsection