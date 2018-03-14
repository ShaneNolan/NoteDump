@extends('layouts.app')

@section('content')
<div class="container">
      <div class="jumbotron mt-3">
        <h1><a style="text-decoration: none" href="">{{$title}}</a></h1>
        <p class="lead">Welcome to Dump Note. Anonymous encrypted notes.</p>
        @if(session('r_message'))
          <div class="alert alert-info">{{session('r_message')}}</div>
        @endif
        @if(session('n_message'))
          {!! Form::open(['action' => 'NoteController@destroy', 'method' => 'POST']) !!}
          {{ Form::hidden('id', session('n_id')) }}
          {{ Form::hidden('key', session('n_key')) }}
        @else
          {!! Form::open(['action' => 'NoteController@store', 'method' => 'POST']) !!}
        @endif
        <div class="form-group">
          {{Form::textarea('message', session('n_message'), ['class' => 'form-control', 'placeholder' => 'Enter your message'])}}
        </div>
        @if(session('n_message'))
          {{Form::submit('Destroy Note &raquo;', ['class' => 'btn btn-lg btn-danger'])}}
        @else
          {{Form::submit('Create Note &raquo;', ['class' => 'btn btn-lg btn-primary'])}}
        @endif
        {!! Form::close() !!}
      </div>
    </div>
    <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
      <a class="navbar-brand" href="">{{$title}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </nav>
@endsection
