<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class PanelProduct extends Product
{
    use HasFactory;

    
    protected static function booted(){
        // Siii comentado
    }

    public function getForeignKey(){
        $parent = get_parent_class($this);

        return (new $parent)->getForeignKey();
    }

    public function getMorphClass(){
        $parent = get_parent_class($this);

        return (new $parent)->getMorphClass();
    }
}
