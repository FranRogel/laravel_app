@extends('tags.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Editar Tag</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('tags.index') }}"> Back</a>
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

<form action="{{ route('tags.update', $tag->id) }}" method="POST">
    @csrf
     @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" value="{{ $tag->nombre }}"class="form-control" placeholder="Nombre" required>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>


@endsection