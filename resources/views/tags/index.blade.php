@extends('tags.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>Laravel 8 CRUD Example</h2>
            </div>
        </div>
    </div>
    <a class="btn btn-success"  href="{{route('dashboard')}}">Volver</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
  <table class="table table-bordered">
    @foreach ($tags as $tag)
      <tr>
          <th>Nombre</th>
          <th width="280px">Acciones</th>
      </tr>
          <tr>
              <td>{{ $tag->nombre }}</td>
              <td>
                  <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                      <a class="btn btn-info" href="{{ route('tags.show', $tag->id) }}">Mostrar</a>
                      @can('admin_access')
                        @csrf
                      @method('DELETE')
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <a class="btn btn-primary" href="{{ route('tags.edit', $tag->id) }}">Editar</a>
                      @endcan
                  </form>
              </td>
          </tr>
    @endforeach
   </table>
   
  <div class="pull-right">
    <a class="btn btn-success" href="{{ route('tags.create') }}"> Crear Tag</a>
  </div>
    

@endsection