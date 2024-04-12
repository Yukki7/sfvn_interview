<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Category;
use App\Models\Fruit;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Barryvdh\DomPDF\Facade\Pdf;


class InvoiceController extends Controller
{
    public function index() : Response {
        $items = Invoice::latest('updated_at')->paginate();
        return Inertia::render('Invoice/Index', compact('items'));
    }

    public function create() : Response {
        $categories = Category::with('fruits')->get();
        return Inertia::render('Invoice/Create', compact('categories'));
    }

    public function store(InvoiceStoreRequest $request) : RedirectResponse {
        $fruits = Fruit::whereIn('id', array_column($request->fruits, 'fruit_id'))->with('category')->get();
        DB::beginTransaction();
        try {
            $invoice = Invoice::create(['customer_name' => $request->customer_name]);

            $arrInvoiceFruits = [];
            foreach ($request->fruits as $key => $value) {
                $fruit = $fruits->find($value['fruit_id']);
                $arrInvoiceFruits[$fruit->id] = [
                    'quantity' => $value['quantity'],
                    'amount' => $value['quantity'] * $fruit->price,
                ];
            }
            $invoice->fruits()->attach($arrInvoiceFruits);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::debug("InvoiceController@create error: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('invoices.index');
    }

    public function show(Request $request, Invoice $invoice) : Response {
        $invoice->load('fruits.category');
        return Inertia::render('Invoice/Show', compact('invoice'));
    }

    public function edit(Request $request, Invoice $invoice) : Response {
        $invoice->load('fruits');
        $categories = Category::with('fruits')->get();
        return Inertia::render('Invoice/Edit', compact('invoice', 'categories'));
    }

    public function update(InvoiceUpdateRequest $request, Invoice $invoice) : RedirectResponse {
        $fruits = Fruit::whereIn('id', array_column($request->fruits, 'fruit_id'))->with('category')->get();

        DB::beginTransaction();
        try {
            $invoice->update(['customer_name' => $request->customer_name]);

            $arrInvoiceFruits = [];
            foreach ($request->fruits as $key => $value) {
                $fruit = $fruits->find($value['fruit_id']);
                $arrInvoiceFruits[$fruit->id] = [
                    'quantity' => $value['quantity'],
                    'amount' => $value['quantity'] * $fruit->price,
                ];
            }
            $invoice->fruits()->sync($arrInvoiceFruits);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::debug("InvoiceController@update error: ", $e->getMessage());
            return redirect()->back()->with('message', $e->getMessage());
        }

        return redirect()->route('invoices.index');
    }

    public function destroy(Invoice $invoice) : RedirectResponse {
        $invoice->delete();
        return redirect()->route('invoices.index');
    }

    public function printPdf(Invoice $invoice) {
        $invoice->load('fruits.category');
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        return $pdf->stream('invoice.pdf');
    }
}
