@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Articles</h1>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th>BODY</th>
                        <th>AUTHOR</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($articles as $article)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{$article->body}}</td>
                    <td>{{$article->author}}</td>

                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('articles.show', $article->id) }}">View</a>
                        <a class="btn btn-warning " href="{{ route('articles.edit', $article->id) }}">Edit</a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"> <button class="btn btn-danger" type="submit">Delete</button></form>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>

            <a class="btn btn-success" href="{{ route('articles.create') }}">Create</a>
        </div>
    </div>


@endsection