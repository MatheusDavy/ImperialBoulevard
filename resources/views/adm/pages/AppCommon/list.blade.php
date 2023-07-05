@extends('adm.layout.app')
@section('content')
    @if (!$allowSearch)
        <style>
            #DataTables_Table_0_filter {
                display: none;
            }
        </style>
    @endif
    <section id="pages">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('adm.dash') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">{{ $titlePlural }}</li>
        </ol>
        <div class="container-fluid">
            <div id="ui-view">
                <div>
                    <div class="animated fadeIn">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <i class="fa fa-list"></i>
                                                Listagem
                                            </div>
                                            <div class="col-md-6 text-end">
                                                @if (!$justView && !$noInsert)
                                                    <a class="btn btn-primary" onclick="ativaloader()"
                                                        href="{{ $insert }}" data-bs-toggle="tooltip"
                                                        data-placement="top" title="Adicionar">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                @endif
                                                @if ($export)
                                                    <a class="btn btn-primary btn-lg" href="{{ $export }}"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Exportar"
                                                        target="_blank">
                                                        <i class="fas fa-file-csv"></i>
                                                    </a>
                                                @endif
                                                @if ($filter)
                                                    <a href="{{ $ajax }}?filter=1" class="btn btn-primary">
                                                        <i class="fas fa-bars"></i>
                                                        <span><b>FILTRAR</b></span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered main-table data-table"
                                            data-ajax-url="{{ $ajax }}" data-sort-url="{{ $sort }}"
                                            data-status-url="{{ $status }}">
                                            <thead>
                                                <tr>
                                                    @if ($allowOrder)
                                                        <th class="text-center order-column" data-name="sort_order"
                                                            data-searchable="false" data-orderable="true"
                                                            data-classes="align-middle order-column text-center sort-handle disabled">
                                                            <i class="fas fa-arrows-alt"></i>
                                                        </th>
                                                    @endif
                                                    @foreach ($listFields as $field)
                                                        <th data-name="{{ $field['name'] }}"
                                                            data-classes="align-middle {{ isset($field['size']) ? 'size-' . $field['size'] : 'size-medium' }}"
                                                            data-searchable="{{ isset($field['search']) && $field['search'] ? 'true' : 'false' }}"
                                                            data-orderable="{{ isset($field['order']) && $field['order'] ? 'true' : 'false' }}">
                                                            {{ $field['title'] }}</th>
                                                    @endforeach
                                                    @if ($allowStatus)
                                                        <th class="text-center status-column text-center" data-name="status"
                                                            data-searchable="false"
                                                            data-classes="align-middle status-column text-center">Ativo?
                                                        </th>
                                                    @endif
                                                    @if ($allowActions)
                                                        <th class="actions-column text-center" data-orderable="false"
                                                            data-name="actions"
                                                            data-classes="align-middle actions-column text-center">Ações
                                                        </th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal confirm-delete-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Excluir item?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Essa ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger save">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal view-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
