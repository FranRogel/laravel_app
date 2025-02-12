@extends('tags.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Detalles del Tag</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tags.index') }}"> Volver</a>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3>{{ $tag->nombre }}</h3>
        </div>
        <div class="card-body">
            <h2>Tareas</h2>
              @foreach ($tareas as $tarea)
                <p ><strong>Tarea:</strong> <a href="{{route('tareas.show', $tarea->id)}}" class="text-blue-500 hover:text-blue-950">{{$tarea->nombre}}</a> </p>
              @endforeach
        </div>
    </div>
@endsection