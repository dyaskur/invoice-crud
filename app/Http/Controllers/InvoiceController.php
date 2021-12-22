<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
        $items     = Item::all();

        return view('invoices.create', compact('companies', 'items'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(InvoiceRequest $request): RedirectResponse
    {
        $invoice = Invoice::create($request->data());

        if ($invoice) {
            $items = collect($request->products);

            $items = $items->map(function($item) {
                $item['price'] = Item::find($item['item_id'])?->price ?? 0;

                return $item;
            });
            $invoice->invoiceItems()->createMany($items->toArray());

            $subtotal            = $items->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });
            $invoice->sub_total  = $subtotal;
            $invoice->tax_amount = $subtotal * $invoice->tax_percentage / 100;
            $invoice->save();

            return redirect()->route('invoices.index')->with('message', 'Invoice created successfully');
        } else {
            return back()->withInput();
        }
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
        $invoice = Invoice::find($id);

        $invoice->update($request->only('status'));

        return response()->json(['success' => 'Record is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        //
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->delete();
        }


        return redirect()->route('invoices.index')->with('message', 'Invoice is deleted ');
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
