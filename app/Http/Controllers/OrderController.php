<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Services\CartService;

use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public $cartService;
    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
        $this->middleware('auth');
    }
  
    public function create()
    {
        //
        $cart = $this->cartService->getFromCookie();

        if(!isset($cart) || $cart->products->isEmpty()){
            return redirect()
            ->back()
            ->withErrors('Your cart is empty');
        } else {
            return view('orders.create')->with([
                'cart' => $cart
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        return \DB::transaction(function() use($request){
            $user = $request->user();
    
            $order = $user->orders()->create([
                'status' => 'pending'
            ]);
            
            $cart = $this->cartService->getFromCookie();
    
            $cartProductsWithQuantity = 
            $cart->products->mapWithKeys(
                function($product){
                    $element[$product->id] = ['quantity' => $product->pivot->quantity];
                    $quantity = $product->pivot->quantity;

                    if($product->stock < $quantity){
                        throw ValidationException::
                        withMessages([
                            'product' => 'NO hay STOCK'
                        ]);
                    }

                    $product->decrement('stock', $quantity);
                    return $element;
                }
            );
    
           
    
            $order->products()->attach($cartProductsWithQuantity->toArray());
            
            return redirect()->route('orders.payments.create',
            ['order' => $order]);

        });

    }

    
}
