document.addEventListener('DOMContentLoaded', function () {
    let tagContainers = document.querySelectorAll('.tareas-container');

    tagContainers.forEach(container => {
        new Sortable(container, {
            group: 'tareas',
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