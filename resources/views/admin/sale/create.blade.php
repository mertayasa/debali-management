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
                    <div class="row align-items-center">
                        <div class="col">
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
                        <div class="col-3">
                            Customer : <span x-text="$store.customer.customer.name"></span>
                        </div>
                        <div class="col-3">
                            Phone : <span x-text="$store.customer.customer.phone"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2" x-show="$store.customer.customerDefined == true">
                <div class="card-body">
                    <div class="col-12 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSale">Add Item</button>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Item</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">QTY</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Amount</th>
                        </tr>
                        <template x-for="item in $store.sale.items">
                            <tr>
                                <td x-text="item.name"></td>
                                <td class="text-end" x-text="$store.sale.formatNumber(item.price)"></td>
                                <td class="text-end" x-text="item.qty"></td>
                                <td class="text-end" x-text="$store.sale.formatNumber(item.discount)"></td>
                                <td class="text-end" x-text="$store.sale.formatNumber(item.amount)"></td>
                            </tr>
                        </template>
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Subtotal</b></td>
                            <td class="text-end" x-text="$store.sale.formatNumber($store.sale.summary.subtotal)"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>DP</b></td>
                            <td class="text-end" width="300"> {{ html()->number('dp')->class('form-control')->attribute('x-model', '$store.sale.summary.dp')->attribute('x-on:input', '$store.sale.removeLeadZero($event)') }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>Shipping</b></td>
                            <td class="text-end" width="300"> {{ html()->number('ship_cost')->class('form-control')->attribute('x-model', '$store.sale.summary.ship_cost')->attribute('x-on:input', '$store.sale.removeLeadZero($event)') }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Remain</b></td>
                            <td class="text-end" x-text="$store.sale.formatNumber($store.sale.summary.remain)"></td>
                        </tr>
                    </table>

                    <div class="text-end">
                        <button class="btn btn-primary" id="btnSavePurchase" x-on:click="$store.sale.savePurchase()">Save Purchase</button>
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
            <div class="modal modal-xl modal-blur fade" id="modalSale" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="form-label">Product</label>
                                    <select name="id_product" class="form-control" id="productIdForm">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Price</label>
                                    {{ html()->text('price')->disabled()->id('priceForm')->class('form-control')->attribute('x-model', '$store.sale.product.price') }}
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">QTY</label>
                                    {{ html()->number('qty')->id('qtyForm')->class('form-control') }}
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Discount</label>
                                    {{ html()->number('discount')->id('discountForm')->class('form-control') }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" id="closeModalProduct"
                                data-bs-dismiss="modal">
                                Cancel
                            </a>
                            {{ html()->button('Submit')->class('btn btn-sm p-2 mt-auto ms-auto btn-success')->id('submitItemFormBtn')->attribute('x-on:click', '$store.sale.submitItem($event)') }}
                        </div>
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
                customerDefined : false,
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

                                this.customerDefined = true
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
        document.addEventListener('alpine:init', () => {
            Alpine.store('sale', {
                items: [],
                summary : {
                    subtotal: 0,
                    remain: 0,
                    ship_cost: 0,
                    dp: 0
                },
                product: {
                    id: '',
                    name: '',
                    price: '',
                },
                init: function() {
                    $('#productIdForm').select2({
                        theme: 'bootstrap-5',
                        placeholder: "Select product",
                        dropdownParent: $("#modalSale")
                    })

                    $("#productIdForm").on("change", function() {
                        Alpine.store('sale').fetchProduct($(this).val())
                    })
                },
                clear: function(){
                    this.product = {
                        id: '',
                        name: '',
                        price: '',
                    }

                    $("#productIdForm").val('').trigger('change')
                    let priceForm = document.getElementById('priceForm').value = ''
                    let qtyForm = document.getElementById('qtyForm').value = ''
                    let discountForm = document.getElementById('discountForm').value = ''
                },
                fetchProduct: function(id) {
                    if (id) {
                        fetch("{{ url('admin/product/show') }}" + '/' + id)
                            .then(function(response) {
                                const data = response.json()
                                return data
                            })
                            .then(data => {
                                this.product.id = data.id
                                this.product.name = data.name
                                this.product.price = data.price                                
                            })

                        return
                    }

                    this.product.id = ''
                    this.product.name = ''
                    this.product.price = ''
                },
                formatNumber: function(number){
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(number)
                },
                removeLeadZero: function(event){                    
                    event.target.value = event.target.value.replace(/^0/, "")
                    this.countSummary()
                },
                submitItem: function (event){
                    let priceForm = document.getElementById('priceForm')
                    let qtyForm = document.getElementById('qtyForm')
                    let discountForm = document.getElementById('discountForm')

                    let itemToAdd = {
                        product_id: this.product.id,
                        name: this.product.name,
                        price: parseInt(priceForm.value),
                        qty: parseInt(qtyForm.value),
                        discount: parseInt(discountForm.value || 0),
                        amount: (priceForm.value * qtyForm.value) - discountForm.value
                    }

                    this.items.push(itemToAdd)
                    this.clear()
                    this.countSummary()
                    document.getElementById('closeModalProduct').click()
                },
                countSummary: function(){
                    let subtotal = 0
                    for (let index = 0; index < this.items.length; index++) {
                        const element = this.items[index]
                        subtotal = parseInt(subtotal + element.amount)
                    }

                    this.summary.subtotal = subtotal
                    this.summary.remain = parseInt(this.summary.subtotal - this.summary.dp) + parseInt(this.summary.ship_cost)
                },
                savePurchase: function(){
                    clearFlash()
                    const btnSavePurchase = document.getElementById('btnSavePurchase')
                    btnSavePurchase.disabled = true
                    btnSavePurchase.innerHTML = 'Processing...'

                    let dataToPost = {
                        customer_id: Alpine.store('customer').customer.id,
                        dp: this.summary.dp,
                        ship_cost: this.summary.ship_cost, 
                        remain: this.summary.remain, 
                        items: this.items
                    }

                    fetch("{{ url('admin/sale/store') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        method: 'POST',
                        body: JSON.stringify(dataToPost),
                    })
                    .then(function(response) {
                        const data = response.json()
                        btnSavePurchase.innerHTML = 'Save Purchase'
                        btnSavePurchase.disabled = false

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
                        return window.location.href = data.redirect_url
                    })
                    .catch((error) => {
                        Alpine.store('global').showFlash('Terjadi kesalahan pada sistem', 'error')
                        return
                    })
                }
            })
        })
    </script>
@endpush
