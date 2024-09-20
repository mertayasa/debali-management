<div class="card p-3 mt-3">
{{ html()->form('POST', route('admin.customer.store'))->id('customerForm')->open() }}

    <div class="row">
        <div class="col-lg-3">
            <label class="form-label">Name</label>
            {{ html()->text('name')->class('form-control')->attribute('x-model', '$store.customer.data.name') }}
        </div>
        <div class="col-lg-3">
            <label class="form-label">Phone</label>
            {{ html()->text('phone')->class('form-control')->attribute('x-model', '$store.customer.data.phone') }}
        </div>
        <div class="col-lg-4">
            <label class="form-label">Desc</label>
            {{ html()->text('desc')->class('form-control')->attribute('x-model', '$store.customer.data.desc') }}
        </div>
        <div class="col-auto mt-auto">  
            {{ html()->button('Save')->class('btn btn-sm p-2 mt-auto btn-success')->id('submitFormBtn')->attribute('x-on:click', '$store.customer.store($event)') }}
            {{ html()->button('Clear')->class('btn btn-sm p-2 mt-auto btn-danger')->type('button')->attribute('x-on:click', '$store.customer.resetForm()') }}
        </div>
    </div>


{{ html()->form()->close() }}
</div>

@push('scripts')
    <script>
        let form = document.getElementById('customerForm')

        document.addEventListener('alpine:init', () => {
            Alpine.store('customer', {
                state: 'create',
                data:{
                    id:null,
                    name: '',
                    phone: '',
                    desc: '' 
                },
                resetForm: function(){
                    form.reset()
                    this.data.id = null
                    this.data.name = ''
                    this.data.phone = ''
                    this.data.desc = ''
                },
                store: function(event){
                    event.preventDefault()
                    let formData = new FormData(form)
                    clearFlash()
                    const submitFormBtn = document.getElementById('submitFormBtn')
                    submitFormBtn.disabled = true
                    submitFormBtn.innerHTML = 'Processing...'
                    console.log('asdasbdjhasb')

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
                        submitFormBtn.innerHTML = 'Save'
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
                }
            })
        })
    </script>
@endpush