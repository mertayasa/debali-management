<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Sale;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    function index(SaleDataTable $saleDataTable) {
        $customer_count = Customer::count();
        $total_sale = Sale::count();
        $total_sale_unpaid = Sale::where('status', 'unpaid')->count();
        $total_expense = Expense::count();

        return $saleDataTable->render('admin.home.index', [
            'customer_count' => $customer_count,
            'total_sale' => $total_sale,
            'total_sale_unpaid' => $total_sale_unpaid,
            'total_expense' => $total_expense,
        ]);
    }
}
