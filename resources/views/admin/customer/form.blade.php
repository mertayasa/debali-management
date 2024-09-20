<div class="card p-3 mt-3">
{{ html()->form('POST', route('admin.customer.store'))->id('customerForm')->open() }}

    <div class="row">
        <div class="col-lg-3">
            <label class="form-label">Name</label>
            {{ html()->text('name')->id('nameForm')->class('form-control')->attribute('x-model', '$store.customer.data.name') }}
        </div>
        <div class="col-lg-3">
            <label class="form-label">Phone</label>
            {{ html()->text('phone')->id('phoneForm')->class('form-control')->attribute('x-model', '$store.customer.data.phone') }}
        </div>
        <div class="col-lg-4">
            <label class="form-label">Desc</label>
            {{ html()->text('desc')->id('descForm')->class('form-control')->attribute('x-model', '$store.customer.data.desc') }}
        </div>
        <div class="col-auto mt-auto">  
            {{ html()->button('Submit')->class('btn btn-sm p-2 mt-auto btn-success')->id('submitFormBtn')->attribute('x-on:click', '$store.customer.submit($event)') }}
            {{ html()->button('Clear')->class('btn btn-sm p-2 mt-auto btn-danger')->type('button')->attribute('x-on:click', '$store.customer.resetForm()') }}
        </div>
    </div>


{{ html()->form()->close() }}
</div>

@push('scripts')
    <script>
        let form = document.getElementById('customerForm')
        const STATECREATE = 'create'
        const STATEEDIT = 'edit'
        let updateUrl = "{{ url('admin/customer/update') }}"

        document.addEventListener('alpine:init', () => {
            Alpine.store('customer', {
                state: STATECREATE,
                data:{
                    id: '',
                    name: '',
                    phone: '',
                    desc: '' 
                },
                resetForm: function(){
                    form.reset()
                    this.data.id = ''
                    this.data.name = ''
                    this.data.phone = ''
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
                        this.data.phone = data.phone
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