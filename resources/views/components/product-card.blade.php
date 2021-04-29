<div class="card">
{{$product->images->first()}}
    
    <div id = "carousel{{$product->id}}" class="carousel slide carousel-fade">
        <div class="carousel-inner">
            @foreach($product->images as $image)
                <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                    <img height = "200" 
                    src="{{asset($image->path)}}" 
                    alt="" 
                    class="d-block w-100 card-img-top">
                </div>
            @endforeach
        </div>

        <a role = "button"
        data-slide="prev"
        href="#carousel{{$product->id}}" 
        class = "carousel-control-prev">
            <span class = "carousel-control-prev-icon">
            </span>
        </a>
        
        <a role = "button"
        data-slide="next"
        href="#carousel{{$product->id}}" 
        class = "carousel-control-next">
            <span class = "carousel-control-next-icon">
            </span>
        </a>

    </div>
    <div class="card-body">
        <h4 class = "text-right">{{$product->price}}</h4>
        <h5 class = "card-title">{{$product->title}}</h5>
        <p class="card-text">{{$product->description}}</p>
        <p class="card-text">{{$product->stock}} left</p>
        @if(!isset($cart))
        <form class = "d-inline" method = "POST" 
        action="{{route('products.carts.store', ['product' => $product])}}">

            @csrf 
            <button type = "submit" class = "btn btn-success">
                Add To Cart
            </button>

        </form>
        @else
        <p class = "card-text">
            {{$product->pivot->quantity}} In your cart ({{$product->total}})
        </p>
        <form class = "d-inline" method = "POST" 
        action="{{route('products.carts.destroy', ['cart' => $cart->id, 
        'product' => $product->id])}}">

            @csrf 
            @method('DELETE')
            <button type = "submit" class = "btn btn-success">
                Remove From Cart
            </button>

        </form>
        @endif
    </div>
          

</div>