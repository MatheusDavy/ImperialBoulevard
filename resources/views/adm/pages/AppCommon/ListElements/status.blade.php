<div class="form-check form-switch">
    <input type="checkbox" class="form-check-input m-auto change-status"
        id="table-item-{{$item->id}}" data-id="{{$item->id}}" {{($item->status == ' 1' ? 'checked' : '' )}}>
    <label class="custom-control-label" for="table-item-{{$item->id}}"></label>
</div>
