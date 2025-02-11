@extends('tareas.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Crear Tarea</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('tareas.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('tareas.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <strong>Fecha de Comienzo:</strong>
                <input type="date" name="fecha_comienzo" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <strong>Fecha de Finalizacion:</strong>
                <input type="date" name="fecha_final" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <strong>Etiqueta (Tag):</strong>
                <select name="tag_id" class="form-control" required>
                    <option value="">Selecciona una etiqueta</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Descripcion:</strong>
                <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripcion" required></textarea>
            </div>
        </div>
        <div class="form-group">
        <input type="hidden" id="creador_id" name="creador_id" value="{{ auth()->user()->id }}">
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>


@endsection