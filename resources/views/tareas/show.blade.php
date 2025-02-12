@extends('tareas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Detalles de la Tarea</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tareas.index') }}"> Volver</a>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3>{{ $tarea->nombre }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Descripcion:</strong> {{ $tarea->descripcion }}</p>
            <p><strong>Fecha de Comienzo:</strong> {{ $tarea->fecha_comienzo }}</p>
            <p><strong>Fecha de Finalizacion:</strong> {{ $tarea->fecha_final }}</p>
            <p><strong>Etiqueta (Tag):</strong> {{ $tag->nombre }}</p>
            <p><strong>Creado por:</strong> {{ $creador->name }}</p>
        </div>
    </div>
@endsection
