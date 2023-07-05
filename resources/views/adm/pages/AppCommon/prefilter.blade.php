@extends('adm.layout.app')
@section('content')
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
                                                Filtro
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="{{ $action }}" method="GET">
                                                    <label><b>Escolha uma opção para continuar:</b></label>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <select name="f" class="form-control"
                                                                onchange="{{ isset($filter_2) && $filter_2 ? '' : 'this.form.submit()' }}">
                                                                <option value="">&nbsp;</option>
                                                                @foreach ($filters as $filter)
                                                                    <option value="{{ $filter->id }}">{{ $filter->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if (isset($filter_2) && $filter_2)
                                                            <div class="col-sm-6">
                                                                <select name="f2" class="form-control">
                                                                </select>
                                                            </div>
                                                        @endif
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                if ($('select[name="f2"]').length > 0) {
                    $('select[name="f"]').change(function(event) {
                        var sel = $(this);
                        var form = sel.parents('form');
                        if (sel.val()) {
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                dataType: 'html',
                                data: {
                                    f: sel.val(),
                                    '_token': $('meta[name="csrf-token"]').attr('content')
                                },
                                error: function() {
                                    $('select[name="f2"]').html('');
                                },
                                success: function(html) {
                                    $('select[name="f2"]').html(html);
                                }
                            });
                        } else {
                            $('select[name="f2"]').html('');
                        }
                    });

                    $('select[name="f2"]').change(function(event) {
                        if ($(this).val().length > 0) {
                            $(this).parents('form').submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection
