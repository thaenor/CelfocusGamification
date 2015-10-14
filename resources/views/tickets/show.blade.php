@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Tickets / Show </h1>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$ticket->id}}</p>
                </div>
                <div class="form-group">
                     <label for="title">TITLE</label>
                     <p class="form-control-static">{{$ticket->title}}</p>
                </div>
                    <div class="form-group">
                     <label for="priority">PRIORITY</label>
                     <p class="form-control-static">{{$ticket->priority}}</p>
                </div>
                    <div class="form-group">
                     <label for="state">STATE</label>
                     <p class="form-control-static">{{$ticket->state}}</p>
                </div>
                    <div class="form-group">
                     <label for="sla">SLA</label>
                     <p class="form-control-static">{{$ticket->sla}}</p>
                </div>
                    <div class="form-group">
                     <label for="timeout">TIMEOUT</label>
                     <p class="form-control-static">{{$ticket->timeout}}</p>
                </div>
            </form>



            <a class="btn btn-default" href="{{ route('tickets.index') }}">Back</a>
            <a class="btn btn-warning" href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>
            <form action="#/$ticket->id" method="DELETE" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };"><button class="btn btn-danger" type="submit">Delete</button></form>
        </div>
    </div>


@endsection