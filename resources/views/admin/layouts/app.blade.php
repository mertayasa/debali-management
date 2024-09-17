<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href=" {{ asset('plugin/datatable/datatables.min.css') }}">
    <link href="{{ asset('plugin/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

    @stack('styles')
</head>

<body x-data="{}">
    <script src=" {{ asset('dist/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page">
        @include('admin.layouts.includes.navbar')
        <main class="py-2">
            @yield('content')
        </main>
    </div>
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="example-text-input"
                            placeholder="Your report name">
                    </div>
                    <label class="form-label">Report type</label>
                    <div class="form-selectgroup-boxes row mb-3">
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="report-type" value="1" class="form-selectgroup-input"
                                    checked>
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Simple</span>
                                        <span class="d-block text-secondary">Provide only basic data needed for the
                                            report</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Advanced</span>
                                        <span class="d-block text-secondary">Insert charts and additional advanced
                                            analyses to be inserted in the report</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Report url</label>
                                <div class="input-group input-group-flat">
                                    <span class="input-group-text">
                                        https://tabler.io/reports/
                                    </span>
                                    <input type="text" class="form-control ps-0" value="report-01"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Visibility</label>
                                <select class="form-select">
                                    <option value="1" selected>Private</option>
                                    <option value="2">Public</option>
                                    <option value="3">Hidden</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Client name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Reporting period</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Additional information</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Create new report
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('plugin/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js?1692870487') }}" defer></script>
	<script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
    <script defer src="{{ asset('plugin/alpinejs/alpine.min.js') }}"></script>
    <script src="{{ asset('plugin/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
        const baseUrl = "{{ url('/admin') }}"

        function deleteModel(deleteUrl, tableId, model = '', additional_warning = '', additionalMethod = null) {
            Swal.fire({
                title: "Warning",
                text: `Hapus data ${model}? ${additional_warning}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#169b6b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            method: 'DELETE',
                        })
                        .then(function(response) {
                            const data = response.json()
                            if (response.status != 200) {
                                throw new Error()
                            }

                            return data
                        })
                        .then(data => {

                            if (tableId != null) {
                                $('#' + tableId).DataTable().ajax.reload()
                            } else {
                                return Swal.fire({
                                        title: 'Success',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    })
                                    .then((result) => {
                                        if (additionalMethod != null) {
                                            additionalMethod()
                                        }

                                        console.log(result);

                                        if (result.isConfirmed) {
                                            window.location.reload()
                                        }
                                    })
                            }

                            if (additionalMethod != null) {
                                additionalMethod.apply(this, [data.args])
                            }
                            // Swal.fire('Success', data.message, 'success')
							console.log(data.message)
                        })
                        .catch((error) => {
                            // Swal.fire('Error', "{{ trans('flash.failed.delete') }}", 'error')
							console.log(error)
                        })
                }
            })
        }

        function clearFlash() {
            Alpine.store('global').isFlash = false
            Alpine.store('global').flashData = []
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('global', {
                isFlash: false,
                flashClass: 'error',
                flashData: [],
                showFlash: function(message, flashType) {
                    this.isFlash = true
                    switch (flashType) {
                        case 'success':
                            this.flashClass = 'bg-success'
                            break
                        case 'error':
                            this.flashClass = 'bg-danger'
                            break
                        case 'warning':
                            this.flashClass = 'bg-warning'
                            break
                        case 'info':
                            this.flashClass = 'bg-info'
                            break
                        default:
                            this.flashClass = 'bg-danger'
                            break
                    }

                    if (typeof message === 'object') {
                        this.flashData = message
                    } else {
                        this.flashData.push(message)
                    }
                },
            })
        })
    </script>

    @stack('scripts')
</body>

</html>

</script>
@stack('js')
</body>

</html>
