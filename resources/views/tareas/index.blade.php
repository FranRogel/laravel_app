@extends('tareas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>Laravel 8 CRUD Example</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
  @foreach ($tags as $tag)
  <table class="table table-bordered">
  <h3> {{$tag -> nombre}} </h3>
      <tr>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th width="280px">Acciones</th>
      </tr>
      @foreach ($tag->tareas as $tarea)
          <tr>
              <td>{{ $tarea->nombre }}</td>
              <td>{{ $tarea->descripcion }}</td>
              <td>
                  <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST">
                      <a class="btn btn-info" href="{{ route('tareas.show', $tarea->id) }}">Mostrar</a>
                      @can('manage', $tarea)
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <a class="btn btn-primary" href="{{ route('tareas.edit', $tarea->id) }}">Editar</a>
                      @endcan
                  </form>
              </td>
          </tr>
      @endforeach
  </table>
  @endforeach
  
  <div class="pull-right">
    <a class="btn btn-success" href="{{ route('tareas.create') }}"> Crear Tarea</a>
  </div>
    

@endsection