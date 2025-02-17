@extends('tareas.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>Laravel 8 CRUD Example <a class="btn btn-success" href="{{ route('dashboard') }}">Volver</a></h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="d-flex flex-row flex-wrap">
        @foreach ($tags as $tag)
            <div class="card m-2" style="width: 300px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $tag->nombre }}</h5>
                </div>
                <div class="card-body tareas-container" id="tag-{{ $tag->id }}" data-tag-id="{{ $tag->id }}">
                    @foreach ($tag->tareas as $tarea)
                        <div class="card mb-2 tarea-card {{ auth()->user()->can('manage', $tarea) ? '' : 'no-drag' }}" data-id="{{ $tarea->id }}">
                            <div class="card-body">
                                <h6>{{ $tarea->nombre }}</h6>
                                <p class="text-muted">{{ $tarea->descripcion }}</p>
                                <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST">
                                    <a class="btn btn-info btn-sm" href="{{ route('tareas.show', $tarea->id) }}">Mostrar</a>
                                    @can('manage', $tarea)
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                                        <a class="btn btn-primary btn-sm" href="{{ route('tareas.edit', $tarea->id) }}">Editar</a>
                                    @endcan
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <a class="btn btn-success" href="{{ route('tareas.create') }}"> Crear Tarea</a>
    </div>

    <!-- SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let tagContainers = document.querySelectorAll('.tareas-container');

            tagContainers.forEach(container => {
                new Sortable(container, {
                    group: 'tareas',
                    filter: '.no-drag',
                    animation: 150,
                    onEnd: function (evt) {
                        let tareaId = evt.item.dataset.id;
                        let nuevoTagId = evt.to.dataset.tagId;
                        actualizarTagTarea(tareaId, nuevoTagId);
                    }
                });
            });

            function actualizarTagTarea(tareaId, nuevoTagId) {
                fetch(`/tareas/${tareaId}/cambiar-tag`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ tag_id: nuevoTagId })
                }).then(response => response.json())
                  .then(data => console.log(data))
                  .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection

