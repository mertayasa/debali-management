@php
    $deleteUrl = "'" . route('admin.sale.destroy', $id) . "', 'datatable'";
@endphp

<div class="btn-group">
    <a href="{{ route('admin.sale.show', $id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus" style="margin-right: 5px"><b> View</b></a>
</div>