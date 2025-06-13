<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class SalesOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ];
    }

     public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            foreach ($items as $index => $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    $validator->errors()->add("items.$index.product_id", 'Product not found');
                    continue;
                }
                
                if ($product->quantity < $item['quantity']) {
                    $validator->errors()->add("items.$index.quantity", 
                        "Insufficient stock for {$product->name}. Available: {$product->quantity}");
                }
            }
        });
    }
}
