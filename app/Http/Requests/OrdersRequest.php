<?php

namespace App\Http\Requests;

use App\Models\ClientProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class OrdersRequest extends FormRequest
{
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'order_details' => ['required', 'array', 'min:1'],
            'order_details.*.product_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $userId = $this->input('client_id');

                    $exists = ClientProduct::where('client_id', $userId)
                        ->where('product_id', $value)
                        ->exists();

                    if (!$exists) {
                        $fail("Producto No asociado al cliente seleccionado.");
                    }
                }
            ],
            'order_details.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'Campo obligatorio.',
            'client_id.integer' => 'Debe ser número entero.',
            'client_id.exists' => 'Registro No existente.',

            'order_details.required' => 'Campo obligatorio.',
            'order_details.array' => 'Debe ser un arreglo.',
            'order_details.min' => 'Debe haber al menos un producto en la orden.',

            'order_details.*.product_id.required' => 'Campo obligatorio.',
            'order_details.*.product_id.integer' => 'Debe ser número entero.',

            'order_details.*.quantity.required' => 'Campo obligatorio.',
            'order_details.*.quantity.integer' => 'Debe ser número entero.',
            'order_details.*.quantity.min' => 'Mínimo 1.',
        ];
    }
}
