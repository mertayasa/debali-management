@php
    $deleteUrl = "'" . route('admin.customer.destroy', $id) . "', 'datatable'";
@endphp

<div class="btn-group">
    {{-- <a href=" {{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" style="margin-right: 5px" ><b> Edit </b></a> --}}
    <a href="#" onclick="deleteModel({{ $deleteUrl }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus" style="margin-right: 5px"><b> Hapus</b></a>
</div>