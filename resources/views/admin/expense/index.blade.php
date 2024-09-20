@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header mt-1 d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            {{-- <div class="page-pretitle">
              Expense
            </div> --}}
            <h2 class="page-title">
              Expense List
            </h2>
            @include('admin.layouts.flash')
          </div>
          {{-- <div class="col-auto ms-auto d-print-none">
              <a href="#" class="btn btn-primary btn-sm p-2 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                Create new Expense
              </a>
          </div> --}}
        </div>
      </div>
    </div>

    <div class="container-xl">
      @include('admin.expense.form')
    </div>

    <div class="container-xl">
      <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class=" ">
                        {!! $dataTable->table(['width' => '100%']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>

@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush