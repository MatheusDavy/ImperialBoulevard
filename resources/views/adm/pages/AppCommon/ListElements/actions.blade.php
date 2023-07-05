@if (!$justView)
    <a class="btn btn-primary" href="{{$update}}" data-bs-toggle="tooltip" data-placement="top" title="Editar">
                <i class="fas fa-pencil-alt"></i></a>
@else 
    <a class="btn btn-primary open-modal-view" href="{{$view}}" data-bs-toggle="tooltip" data-placement="top" title="Ver">
        <i class="fas fa-eye"></i>
    </a>
@endif

<a class="btn btn-danger confirm-delete" href="{{$delete}}" data-bs-toggle="tooltip" data-placement="top" title="Excluir">
    <i class="far fa-trash-alt"></i>
</a>