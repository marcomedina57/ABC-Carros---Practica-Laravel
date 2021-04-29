<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class ProductCarController extends Controller
{

    public $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        //
        $cart = $this->cartService->getFromCookieOrCreate();


        $quantity = $cart->products()
        ->find($product->id)
        ->pivot
        ->quantity ?? 0;

    if($product->stock < $quantity + 1){
        throw ValidationException
        ::withMessages([
            'product' => "No hay suficiente stock"
        ]);
    }        

        $cart->products()->syncWithoutDetaching([
            $product->id => ['quantity' => $quantity + 1],

        ]);

        $cart->touch();

        $cookie = $this->cartService->makeCookie($cart);
            
        return redirect()->back()->cookie($cookie);
    }

    
    public function destroy(Product $product, Cart $cart)
    {
        //
        $cart->products()->detach($product->id);

        $cart->touch();

        $this->cartService->makeCookie($cart);

        return redirect()->back();
    }

   
}
