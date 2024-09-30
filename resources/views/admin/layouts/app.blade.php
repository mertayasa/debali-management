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
