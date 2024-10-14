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
                                <td class="text-end">{{ $item->price }}</td>
                                <td class="text-end">{{ $item->qty }}</td>
                                <td class="text-end">{{ $item->discount }}</td>
                                <td class="text-end">{{ $item->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Subtotal</b></td>
                            {{-- <td class="text-end">{{ $sale->subtotal }}</td> --}}
                            <td class="text-end"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>DP</b></td>
                            <td class="text-end" width="300"> {{ $sale->dp }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end align-middle" style="border: none"><b>Shipping</b></td>
                            <td class="text-end" width="300"> {{ $sale->ship_cost }} </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end" style="border: none"><b>Remain</b></td>
                            <td class="text-end"> </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection