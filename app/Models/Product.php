<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cart;
use App\Models\Image;
use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'products';
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'price', 
        'stock', 'status'
    ];

    public function carts(){
        return $this->morphedByMany(Cart::class, 'productable')
        ->withPivot('quantity');
    }
    public function orders(){
        return $this->morphedByMany(Order::class, 'productable')
        ->withPivot('quantity');
    }

    public function images(){
        return $this->morphMany(Image::class,
        'imageable');

    }

    protected $with = [
        'images'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AvailableScope);

        static::updated(function($product){
            if($product->stock == 0 && $product->status == 'available'){
                $product->status = 'unavailable';

                $product->save();
            }
        });
    }


    public function scopeAvailable($query){
        
        $query->where('status', 'available');
    }

    public function getTotalAttribute(){
        return $this->pivot->quantity * $this->price;

    }


    
}
