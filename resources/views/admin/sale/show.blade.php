@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header mt-1 d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
              Sale Detail
            </h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
              <a href="" class="btn btn-primary btn-sm p-2 d-none d-sm-inline-block">
                Print
              </a>
          </div>
        </div>
      </div>
    </div>

    <div class="container-xl">
      <div class="row mt-3">
        <div class="col-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-md" style="box-shadow: none; background-image: url({{ asset('logo.png') }})"></span>
                            <div class="d-none d-xl-block ps-2">
                              <div><b>INVOICE DBLI-{{ $sale->id }}</b></div>
                            </div>
                          </a>
                        <div class="border my-2"></div>
                        <div class="col-6">
                            <h3 class="mb-0"> <b>{{ $sale->customer->name }}</b> <br> </h3>
                            <small class="text-secondary"> {{ $sale->customer->phone }} </small>
                        </div>
                        <div class="col-6 text-end">
                            <h3 class="mb-0"> <b>Debali Printing</b> <br> </h3>
                            <small class="text-secondary"> 081934316124, <br> Jl. Pulau Belitung, Gg Cendrawasih no 12B </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Item</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">QTY</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Amount</th>
                        </tr>
                        @foreach ($sale->sale_products as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-end">{{ currency($item->price) }}</td>
                                <td class="text-end">{{ $item->qty }}</td>
                                <td class="text-end">{{ currency($item->discount) }}</td>
                                <td class="text-end">{{ currency($item->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Subtotal</b></td>
                            <td class="text-end">{{ currency($sale->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>DP</b></td>
                            <td class="text-end" width="300"> {{ currency($sale->dp) }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>Shipping</b></td>
                            <td class="text-end" width="300"> {{ currency($sale->ship_cost) }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Remain</b></td>
                            <td class="text-end"> {{ currency($sale->remain) }} </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection