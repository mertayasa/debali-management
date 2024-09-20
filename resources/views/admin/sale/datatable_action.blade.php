@php
    $deleteUrl = "'" . route('admin.sale.destroy', $id) . "', 'datatable'";
@endphp

<div class="btn-group">
    <a href="#" onclick="deleteModel({{ $deleteUrl }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus" style="margin-right: 5px"><b> Delete</b></a>
</div>