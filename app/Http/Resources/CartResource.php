<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        $itemTotalPrice = $this->quantity * $this->product->price;

        $lang = $request->header('lang', 'ar');

        // Dynamically select the name and description fields based on the language
        $productName = $lang === 'en' ? $this->product->name_en : $this->product->name_ar;
        $productDescription = $lang === 'en' ? $this->product->description_en : $this->product->description_ar;
        return [
            'id' => $this->id,
            'userName' => $this->user??$this->user?->name,
            'Useremail' => $this->user??$this->user?->email,
            'guest_token' => $this->guest_token,
            'productId' => $this->product->id,
            'productName' => $productName,
            'productDesc' => $productDescription,
            'productPrice' => $this->product->price,
            'productImage' => url('storage/' . $this->product->image),
            'quantity' => $this->quantity,
            'item_total_price' => $itemTotalPrice,
        ];
    }
}
