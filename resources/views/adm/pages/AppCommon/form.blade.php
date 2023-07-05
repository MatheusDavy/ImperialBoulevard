@extends('adm.layout.app')
@section('content')
<section id="pageDetail">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{route('adm.dash')}}">Dashboard</a>
    </li>
    @php
        $lang = '';
    @endphp
    @if(isset($back) && $back)
    <li class="breadcrumb-item">
      <a href="{{ $back }}">{{ $titlePlural }}</a>
    </li>
    @endif
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <i class="fa fa-pencil-alt"></i>
                  {{ $title }}
                </div>
                <div class="col-md-6 text-end">
                  {{-- crop config --}}
                  <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-change-cropConfig"
                    data-bs-toggle="tooltip" style="color: #fff" data-placement="top" title="Configurações">
                    <i class="fas fa-cog"></i>
                  </a>
                  @if (isset($allowSave) && $allowSave)
                      <button class="btn btn-primary main-form-button" href="#" data-bs-toggle="tooltip" data-placement="top" title="Salvar" form="main-form">
                          <i class="far fa-save"></i>
                      </button>
                  @endif
                  @if(isset($back) && $back)
                  <a class="btn btn-light" href="{{ $back }}" data-bs-toggle="tooltip" data-placement="top" title="Voltar">
                    <i class="fas fa-reply"></i>
                  </a>
                  @endif
                  @if(isset($page) && $page && $user->id == '1')
                  <div class="btn btn-light" title="Adicionar campo" data-bs-toggle="modal" data-bs-target="#modal-field"><i class="fas fa-plus"></i></div>
                  <div class="btn btn-light" title="Ver campos" data-bs-toggle="modal" data-bs-target="#modal-control-fields"><i class="fas fa-table"></i></div>
                  <a class="btn btn-light" title="Gerar SQL" href="{{ $sql }}" target="_blank"><i class="fas fa-file-download"></i></a>
                  @endif
                </div>
              </div>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab1" role="tablist">
                @php $i = 1 @endphp
                @foreach ($fields as $k => $tab)
                  <li class="nav-item">
                    <div class="nav-link {{ $i==1 ? 'active show' : '' }}" data-bs-toggle="tab" href="#tab-{{ $i }}" role="tab">{{ $k }}</div>
                  </li>
                  @php $i++ @endphp
                @endforeach
              </ul>
              <form action="{{ $action }}" id="main-form" class="main-form common-form-send no-reset">
                {{ csrf_field() }}
                <div class="tab-content">
                  @php $i = 1 @endphp
                  @foreach ($fields as $tab)
                    @php $langs = false @endphp
                    <div class="tab-pane fade {{ $i==1 ? 'active show' : '' }}" id="tab-{{ $i }}" role="tabpanel">
                      <div class="card-body">
                        <div class="row">
                          @foreach ($tab as $input)
                            @if (!isset($input['multilanguage']) || !$input['multilanguage'])
                              @if (isset($input['type']) && $input['type'] !== 'slug')
                                @include('adm.pages.AppCommon.inputs.'.$input['type'])
                              @endif
                            @else
                              @php $langs = true @endphp
                            @endif
                          @endforeach
                        </div>
                        @if ($langs)
                          <div class="row">
                          <div class="col-md-2">
                            <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                              @foreach ($languages as $k => $lang)
                                <div class="nav-link text-center {{ $k == 1 ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-{{ $i }}-language-{{ $k }}" role="tab" aria-controls="v-pills-home" aria-selected="true"><img src="{{ asset('adm/img/lang-'.$lang.'.png') }}" alt=""></div>
                              @endforeach
                            </div>
                          </div>
                          <div class="col-md-10">
                            <div class="tab-content">
                              @foreach ($languages as $k => $lang)
                                <div class="tab-pane fade {{ $k == 1 ? 'show active' : '' }}" id="tab-{{ $i }}-language-{{ $k }}" role="tabpanel">
                                  <div class="row">
                                    @foreach ($tab as $input)
                                      @if ($input['type'] != 'slug' && isset($input['multilanguage']) && $input['multilanguage'])
                                        @include('adm.pages.AppCommon.inputs.'.$input['type'])
                                      @endif
                                    @endforeach
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>
                          </div>
                        @endif
                      </div>
                    </div>
                    @php $i++ @endphp
                  @endforeach
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- modal crop config --}}
<div class="modal fade" id="modal-change-cropConfig" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Configurações Crop</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pt-4 pb-2">
            <div class="row text-center">
              <div class="col-6">
                  <p>Crop nas Imagens</p>
              </div>
              <div class="col-6">
                  <div class="form-check form-switch">
                      <input type="checkbox" class="form-check-input" id="cropConfig">
                      <label class="custom-control-label" for="cropConfig">Desativar / Ativar</label>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
      </div>
  </div>
</div>
<div class="modal modal-image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imagem</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      </div>
    </div>
  </div>
</div>
<div class="modal modal-crop" crop-modal-url="{{route("adm.cropModal")}}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imagem Crop</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      </div>
    </div>
  </div>
</div>
@if(isset($page) && $page)
<div class="modal modal-control-fields" tabindex="-1" role="dialog" id="modal-control-fields">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Campos</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Título</th>
              <th>Nome</th>
              <th style="width: 50px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($page->fields as $f)
              <tr>
                <td>{{ $f->title }}</td>
                <td>{{ $f->name }}</td>
                <td><a href="{{ $f->remove }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-field" tabindex="-1" role="dialog" id="modal-field">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar campo</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ $field }}" class="common-form-send">
        {{ csrf_field() }}
        <input type="hidden" name="page" value="{{ $page->slug }}">
        <div class="modal-body text-left">
          <div class="row">
            <div class="form-group col-sm-6">
              <div class="row column">
                <div class="col-sm-12">
                  <label class="col-form-label text-left required d-inline-block">Título</label>
                </div>
                <div class="col-sm-12">
                  <input type="text" class="form-control required" name="title">
                </div>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="row column">
                <div class="col-sm-12">
                  <label class="col-form-label text-left required d-inline-block">Nome</label>
                </div>
                <div class="col-sm-12">
                  <input type="text" class="form-control required" name="name">
                </div>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="row column">
                <div class="col-sm-12">
                  <label class="col-form-label text-left d-inline-block">Tipo</label>
                </div>
                <div class="col-sm-12">
                  <select name="type" class="form-control">
                    <option value="input">Input</option>
                    <option value="text">Text</option>
                    <option value="ckEditor">CkEditor</option>
                    <option value="image">Imagem</option>
                    <option value="file">Arquivo</option>
                    <option value="color">Cor</option>
                    <option value="date">Data</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="position">Posição</option>
                    <option value="gallery">Galeria</option>
                    <option value="related">Relacionado</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="row column">
                <div class="col-sm-12">
                  <label class="col-form-label text-left d-inline-block">Metade?</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="checkbox_page_half" name="half">
                    <label class="custom-control-label" for="checkbox_page_half"></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection
