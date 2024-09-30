@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row g-2">
                                {{ html()->hidden('id')->id('custIdForm') }}
                                <div class="col">
                                    <select name="id_customer" class="form-control" id="selectCustomer">
                                        <option value=""></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-icon px-2 btn-primary" aria-label="Button"
                                        data-bs-toggle="modal" data-bs-target="#modal-report">
                                        + Add New Customer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col">
                            Customer : <span x-text="$store.customer.customer.name"></span>
                        </div>
                        <div class="col">
                            Phone : <span x-text="$store.customer.customer.phone"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        {{ html()->form('POST', route('admin.customer.store'))->id('customerForm')->open() }}
                        <div class="modal-header">
                            <h5 class="modal-title">New Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="form-label">Name</label>
                                    {{ html()->text('name')->id('nameForm')->class('form-control') }}
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Phone</label>
                                    {{ html()->text('phone')->id('phoneForm')->class('form-control') }}
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Desc</label>
                                    {{ html()->text('desc')->id('descForm')->class('form-control') }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" id="closeModalLink"
                                data-bs-dismiss="modal">
                                Cancel
                            </a>
                            {{ html()->button('Submit')->class('btn btn-sm p-2 mt-auto ms-auto btn-success')->id('submitCustomerFormBtn')->attribute('x-on:click', '$store.customer.submitCustomer($event)') }}
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Script for customer related --}}
    <script>
        let form = document.getElementById('customerForm')
        const STATECREATE = 'create'
        let updateUrl = "{{ url('admin/customer/update') }}"

        document.addEventListener('alpine:init', () => {
            Alpine.store('customer', {
                state: STATECREATE,
                customer: {
                    id: '',
                    name: '',
                    phone: '',
                    desc: ''
                },
                init: function() {
                    $('#selectCustomer').select2({
                        theme: 'bootstrap-5',
                        placeholder: "Select customer"
                    })

                    $("#selectCustomer").on("change", function() {
                        Alpine.store('customer').fetchCustomer($(this).val())
                    })

                },
                resetForm: function() {
                    form.reset()
                    this.state = STATECREATE
                },
                submitCustomer: function(event) {
                    this.store(event)
                },
                fetchCustomer: function(id) {
                    if (id) {
                        fetch("{{ url('admin/customer/show') }}" + '/' + id)
                            .then(function(response) {
                                const data = response.json()
                                return data
                            })
                            .then(data => {
                                this.customer.id = data.id
                                this.customer.name = data.name
                                this.customer.phone = data.phone
                                this.customer.desc = data.desc

                                console.log(this.customer);
                            })

                        return
                    }

                    this.customer.id = ''
                    this.customer.name = ''
                    this.customer.phone = ''
                    this.customer.desc = ''
                },
                store: function(event) {
                    event.preventDefault()
                    let formData = new FormData(form)
                    clearFlash()
                    const submitCustomerFormBtn = document.getElementById('submitCustomerFormBtn')
                    submitCustomerFormBtn.disabled = true
                    submitCustomerFormBtn.innerHTML = 'Processing...'

                    fetch(form.getAttribute('action'), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            method: 'POST',
                            body: formData,
                        })
                        .then(function(response) {
                            const data = response.json()
                            submitCustomerFormBtn.innerHTML = 'Submit'
                            submitCustomerFormBtn.disabled = false

                            if (response.status != 200) {
                                data.then((res) => {
                                    const message = res.message
                                    Alpine.store('global').showFlash(res.message, 'error')
                                })
                                throw new Error()
                            }

                            return data
                        })
                        .then(data => {
                            this.fetchCustomer(data.customer.id)
                            this.resetForm()
                            document.getElementById('closeModalLink').click()
                            // Alpine.store('global').showFlash(data.message, 'success')
                        })
                        .catch((error) => {
                            Alpine.store('global').showFlash('Terjadi kesalahan pada sistem',
                                'error')
                            return
                        })
                }
            })
        })
    </script>
    {{-- End script for customer related --}}

    <script>

    </script>
@endpush
