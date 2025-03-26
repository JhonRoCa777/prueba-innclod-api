<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function getByDocument($client_document)
    {
        $client = Client::where('document', $client_document)->first();

        if (!$client)
            return response()->noContent(Response::HTTP_NOT_FOUND);

        return response()->json($client);
    }

    public function create(ClientRequest $request)
    {
        DB::beginTransaction();

        try {
            $client = Client::create($request->all());

            $productsId = Product::where('id', '!=', 1)
                         ->inRandomOrder()
                         ->limit(3)
                         ->pluck('id');

            foreach ($productsId as $productId) {
                ClientProduct::create([
                    'client_id' => $client->id,
                    'product_id' => $productId,
                ]);
            }

            DB::commit();
            return response()->json($client, Response::HTTP_CREATED);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Ocurrió un error al crear el Cliente.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ClientRequest $request, $client_id)
    {
        $client = Client::find($client_id);

        if (!$client)
            return response()->json('Cliente No Encontrado', Response::HTTP_NOT_FOUND);

        $client->update($request->all());
        return response()->json($client, Response::HTTP_CREATED);
    }

    public function getProducts($client_id)
    {
        $client = Client::find($client_id);

        if (!$client)
            return response()->json('Cliente No Encontrado', Response::HTTP_NOT_FOUND);

        return response()->json($client->products);
    }

    public function getOrders($client_id)
    {
        $client = Client::with(['orders.orderDetails.product'])
                        ->find($client_id);

        if (!$client)
            return response()->json('Cliente No Encontrado', Response::HTTP_NOT_FOUND);

        return response()->json($client->orders);
    }
}
