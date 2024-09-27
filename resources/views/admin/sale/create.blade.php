@extends('admin.layouts.app')

@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header mt-1 d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Create Sale
                        </h2>
                        @include('admin.layouts.flash')
                    </div>
                </div>
            </div>
        </div>

        <div class="container-xl">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class=" ">
                                {{ html()->form('POST', route('admin.product.store'))->id('productForm')->open() }}
                                <div class="row">
									<div class="col-12 col-md-6">
										<div class="row g-2">
											{{ html()->hidden('id')->id('custIdForm')->attribute('x-model', '$store.product.data.name') }}
											<div class="col">
												{{ html()->text('name')->id('nameForm')->class('form-control')->placeholder('Search existing customer')->attribute('x-model', '$store.product.data.name') }}
											</div>
											<div class="col-auto">
											  <a href="#" class="btn btn-icon px-2 btn-primary" aria-label="Button" data-bs-toggle="modal" data-bs-target="#modal-report">
												+ Add New Customer
											  </a>
											</div>
										  </div>
									</div>
                                <div>


                                {{ html()->form()->close() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
