<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use App\Models\Product;
use App\Models\SalesOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::all();
        return view('sales-orders.index', compact('salesOrders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales-orders.create', compact('products'));
    }

    public function store(SalesOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $salesOrder = SalesOrder::create([
                'user_id' => auth()->user()->id,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];

                $salesOrder->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price
                ]);

                $total += $product->price * $quantity;
            }

            $salesOrder->update(['total' => $total]);
        });

        return redirect()->route('sales-orders.index');
    }

    public function confirm(SalesOrder $salesOrder)
    {
        try {
            DB::transaction(function () use ($salesOrder) {
                foreach ($salesOrder->items as $item) {
                    $product = $item->product;
                    if ($product->quantity < $item->quantity) {
                        throw new Exception("Insufficient stock for {$product->name}");
                    }
                    $product->decrementStock($item->quantity);
                }
                $salesOrder->update(['status' => 'confirmed']);
            });
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('sales-orders.index');
    }

    public function show(SalesOrder $salesOrder)
    {
        return view('sales-orders.show', compact('salesOrder'));
    }

    public function pdf(SalesOrder $salesOrder)
    {
        $pdf = PDF::loadView('sales-orders.pdf', compact('salesOrder'));
        return $pdf->download("order-{$salesOrder->id}.pdf");
    }
}
