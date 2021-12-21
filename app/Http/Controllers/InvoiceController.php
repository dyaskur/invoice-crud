<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        //
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $companies = Company::all();

        return view('invoices.create', compact('companies'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function json(Request $request): JsonResponse
    {
        $data = Invoice::query()
            ->selectRaw('invoices.*, invoices.sub_total+invoices.tax_amount-invoices.total_payment as amount_due')
            ->with('items:id,name')
            ->with('issuer:id,name')
            ->with('recipient:id,name');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn(
                'action',
                function($data) {
                    return
                        '<a  class="btn btn-xs px-0 py-0"
                        onclick="destroyData('.$data->id
                        .')"  title="Delete"><i  class="bi-trash" style="font-size: 1rem; color: red;"></i></a> ';
                }
            )->make(true);
    }

}
