@php
    $files = $input['files'];
    $doBackup = isset($input['doBackup']) ? $input['doBackup'] : null;
    $label = "Arquivos";
    $button = "Download";
    $id = "download";
    $url = route("adm.doBackupDownload");
    if ($doBackup) {
        $label = "Tables";
        $button = "Backup";
        $id = "backup";
        $url = route("adm.doBackup");
    }

    $idSelect = "select-" . $id;

@endphp
<style>
    .section-backup {
        display: flex;
        justify-content: center;
        font-size: 1.2rem;
    }
    .form-group .form-control{
        font-size: 1rem;
    }
    .row.column button {
        font-size: 1rem;
    }
</style>
<section class="section-backup">
    <div class="form-group col-sm-8 form-backup">
        <div class="row column">
            <div class="col-sm-2">
                <label class="col-form-label">{{$label}}</label>
            </div>
            <div class="col-sm-6">
                <select class="form-control" id="{{$idSelect}}">
                    @foreach ($files as $file)
                        <option value="{{ $file }}">{{ $file }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <button url="{{$url}}" type="button" id="{{$id}}" class="btn btn-primary">{{$button}}</button>
            </div>
        </div>
    </div>
</section>
