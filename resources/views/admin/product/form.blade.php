<div class="card p-3 mt-3">
{{ html()->form('POST', route('admin.product.store'))->id('productForm')->open() }}

    <div class="row">
        <div class="col-lg-3">
            <label class="form-label">Name</label>
            {{ html()->text('name')->id('nameForm')->class('form-control')->attribute('x-model', '$store.product.data.name') }}
        </div>
        <div class="col-lg-3">
            <label class="form-label">Price</label>
            {{ html()->text('price')->id('priceForm')->class('form-control')->attribute('x-model', '$store.product.data.price') }}
        </div>
        <div class="col-lg-4">
            <label class="form-label">Desc</label>
            {{ html()->text('desc')->id('descForm')->class('form-control')->attribute('x-model', '$store.product.data.desc') }}
        </div>
        <div class="col-auto mt-auto">  
            {{ html()->button('Submit')->class('btn btn-sm p-2 mt-auto btn-success')->id('submitFormBtn')->attribute('x-on:click', '$store.product.submit($event)') }}
            {{ html()->button('Clear')->class('btn btn-sm p-2 mt-auto btn-danger')->type('button')->attribute('x-on:click', '$store.product.resetForm()') }}
        </div>
    </div>


{{ html()->form()->close() }}
</div>

@push('scripts')
    <script>
        let form = document.getElementById('productForm')
        const STATECREATE = 'create'
        const STATEEDIT = 'edit'
        let updateUrl = "{{ url('admin/product/update') }}"

        document.addEventListener('alpine:init', () => {
            Alpine.store('product', {
                state: STATECREATE,
                data:{
                    id: '',
                    name: '',
                    price: '',
                    desc: '' 
                },
                resetForm: function(){
                    form.reset()
                    this.data.id = ''
                    this.data.name = ''
                    this.data.price = ''
                    this.data.desc = ''

                    this.state = STATECREATE
                },
                submit: function(event){
                    this.state == STATECREATE ? this.store(event) : this.update(event)
                },
                store: function(event){
                    console.log('store');
                    
                    event.preventDefault()
                    let formData = new FormData(form)
                    clearFlash()
                    const submitFormBtn = document.getElementById('submitFormBtn')
                    submitFormBtn.disabled = true
                    submitFormBtn.innerHTML = 'Processing...'

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
                        submitFormBtn.innerHTML = 'Submit'
                        submitFormBtn.disabled = false

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
                        this.resetForm()
                        $('#datatable').DataTable().ajax.reload()
                        Alpine.store('global').showFlash(data.message, 'success')
                    })
                    .catch((error) => {
                        Alpine.store('global').showFlash('Terjadi kesalahan pada sistem', 'error')
                        return
                    })
                },
                edit: function(event){
                    const id = event.currentTarget.dataset.id
                    const url = event.currentTarget.dataset.geturl
                    
                    fetch(url).then(function(response) {
                        const data = response.json()
                        if (response.status != 200) {
                            data.then((res) => {
                                const message = res.message
                                Alpine.store('global').showFlash(res.message, 'error')
                            })
                            throw new Error()
                        }

                        return data
                    }).then(data => {
                        this.data.id = data.id
                        this.data.name = data.name
                        this.data.price = data.price
                        this.data.desc = data.desc

                        document.getElementById('descForm').focus()
                        this.state = STATEEDIT

                        console.log(this.state);
                        
                    })
                },
                update: function(event){
                    event.preventDefault()
                    let formData = new FormData(form)
                    formData.append('_method', 'PATCH')
                    clearFlash()
                    const submitFormBtn = document.getElementById('submitFormBtn')
                    submitFormBtn.disabled = true
                    submitFormBtn.innerHTML = 'Processing...'

                    fetch(updateUrl + '/' + this.data.id, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        method: 'POST',
                        body: formData,
                    })
                    .then(function(response) {
                        const data = response.json()
                        submitFormBtn.innerHTML = 'Submit'
                        submitFormBtn.disabled = false

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
                        console.log(data);
                        
                        this.resetForm()
                        $('#datatable').DataTable().ajax.reload()
                        Alpine.store('global').showFlash(data.message, 'success')
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