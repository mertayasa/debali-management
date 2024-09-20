<div class="card p-3 mt-3">
{{ html()->form('POST', route('admin.expense.store'))->id('expenseForm')->open() }}

    <div class="row">
        <div class="col-lg-3">
            <label class="form-label">Subject To</label>
            {{ html()->text('subject_to')->id('subject_toForm')->class('form-control')->attribute('x-model', '$store.expense.data.subject_to') }}
        </div>
        <div class="col-lg-3">
            <label class="form-label">Amount</label>
            {{ html()->text('amount')->id('amountForm')->class('form-control')->attribute('x-model', '$store.expense.data.amount') }}
        </div>
        <div class="col-lg-2">
            <label class="form-label">Credited at</label>
            {{ html()->date('credited_at')->id('credited_atForm')->class('form-control')->attribute('x-model', '$store.expense.data.credited_at') }}
        </div>
        <div class="col-lg-4">
            <label class="form-label">Desc</label>
            {{ html()->text('desc')->id('descForm')->class('form-control')->attribute('x-model', '$store.expense.data.desc') }}
        </div>
        <div class="col-auto mt-2">  
            {{ html()->button('Submit')->class('btn btn-sm p-2 mt-auto btn-success')->id('submitFormBtn')->attribute('x-on:click', '$store.expense.submit($event)') }}
            {{ html()->button('Clear')->class('btn btn-sm p-2 mt-auto btn-danger')->type('button')->attribute('x-on:click', '$store.expense.resetForm()') }}
        </div>
    </div>


{{ html()->form()->close() }}
</div>

@push('scripts')
    <script>
        let form = document.getElementById('expenseForm')
        const STATECREATE = 'create'
        const STATEEDIT = 'edit'
        let updateUrl = "{{ url('admin/expense/update') }}"

        document.addEventListener('alpine:init', () => {
            Alpine.store('expense', {
                state: STATECREATE,
                data:{
                    id: '',
                    subject_to: '',
                    amount: '',
                    credited_at: '',
                    desc: '' 
                },
                resetForm: function(){
                    form.reset()
                    this.data.id = ''
                    this.data.subject_to = ''
                    this.data.amount = ''
                    this.data.credited_at = ''
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
                }
            })
        })
    </script>
@endpush