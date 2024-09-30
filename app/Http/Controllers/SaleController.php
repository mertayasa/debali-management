<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SaleDataTable $saleDataTable)
    {
        return $saleDataTable->render('admin.sale.index');
    }

    function datatable() {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all('id', 'name');
        $products = Product::all('id', 'name');
        // dd($products);
        return view('admin.sale.create', [
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Sale::create($request->all());
        }catch(Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['message' => ''], 500);
        }

        return response()->json(['message' => 'Data stored']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        return response()->json($sale, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        try{
            $sale->update($request->all());
        }catch(Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['message' => ''], 500);            
        }
        return response()->json(['message' => 'Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        try{
            $sale->delete();
        }catch(Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['message' => ''], 500);
        }

        return response()->json(['message' => 'Data deleted']);
    }
}
