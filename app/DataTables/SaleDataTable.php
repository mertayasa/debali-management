<?php

namespace App\DataTables;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SaleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('customer_id', function() use($query){
                return $query->get()[0]->customer->name;
            })
            ->editColumn('dp', function() use($query){
                return currency($query->get()[0]->dp);
            })
            ->editColumn('ship_cost', function() use($query){
                return currency($query->get()[0]->ship_cost);
            })
            ->addColumn('action', 'admin.sale.datatable_action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Sale $model): QueryBuilder
    {
        return $model->newQuery()->with('customer', 'actor');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('datatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy([0, 'DESC'])
                    ->selectStyleSingle()
                    ->addAction(['title' => 'Aksi', 'width' => '150px', 'printable' => false, 'responsivePriority' => '100', 'id' => 'actionColumn']);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('customer_id'),
            Column::make('status'),
            Column::make('dp'),
            Column::make('ship_cost'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sale_' . date('YmdHis');
    }
}
