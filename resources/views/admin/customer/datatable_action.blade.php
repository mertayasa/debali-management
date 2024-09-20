@php
    $deleteUrl = "'" . route('admin.customer.destroy', $id) . "', 'datatable'";
@endphp

<div class="btn-group">
    <button type="button" data-id="{{ $id }}" data-geturl="{{ route('admin.customer.edit', $id) }}" class="btn btn-warning btn-sm me-2" x-on:click="$store.customer.edit($event)">Edit</button>
    {{-- <a href="" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" style="margin-right: 5px" x-on:click="$store.customer.edit()"><b> Edit </b></a> --}}
    <a href="#" onclick="deleteModel({{ $deleteUrl }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus" style="margin-right: 5px"><b> Delete</b></a>
</div>