<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function create(OrdersRequest $request) {
        try {
            DB::beginTransaction();

            $clientId = $request->input('client_id');
            $order_details = $request->input('order_details');

            $order = Order::create([
                'client_id' => $clientId
            ]);

            foreach ($order_details as $detail) {
                $productId = $detail['product_id'];
                $quantity = $detail['quantity'];

                $productModel = Product::find($productId);

                if ($productModel->stock < $quantity){
                    DB::rollBack();
                    return response()->json('Stock Insuficiente', Response::HTTP_NOT_FOUND);
                }

                $productModel->decrement('stock', $quantity);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();
            return response()->noContent(Response::HTTP_CREATED);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Ocurrió un error al crear la Órden.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
