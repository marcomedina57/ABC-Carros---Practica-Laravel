<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\PanelProduct;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Scopes\AvailableScope;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    //


    public function __construct(){
        
    }
    public function index(){
        $products = PanelProduct::without('images')->get();
        return view('products.index')->with([
            'products' => $products
        ]);

        return $products;
    }

    public function create(){
        
        return view('products.create');
    }

    public function store(ProductRequest $request){
       
        session()->forget('error');

        $product = PanelProduct::create($request->validated());
        foreach($request->images as $image){
            $product->images()->create([
                'path' => 'images/' . $image->store('products', 'images')

               
            ]);

           
        }

        return redirect()->route('products.index')
        ->with(['success' => 'Todo estará mejor']);
    }

    public function show(PanelProduct $product){
        
        return view('products.show')->with([
            'product' => $product,
            'html' => "<h2>Subtitle</h2>"
        ]);
    }

    public function edit($product){
        $product = PanelProduct::findOrFail($product);
        return view('products.edit')->with([
            'product' => $product,
            'html' => "<h2>Subtitle</h2>"
        ]);

    }

    public function update(PanelProduct $product, ProductRequest $request){

        $product->update($request->validated());
        
        if ($request->hasFile('images')){
            foreach($product->images as $image){
                
                $path = 
                storage_path('app/public/{$image->path}');
                File::delete($path);
                $image->delete();
            }
            foreach($request->images as $image){
          
                $product->images()->create([
                    'path' => 'images/' . $image->store('products', 'images')
                ]);
            }

        } 


        // $product = Product::findOrFail($product);

        $product->update($request->validated());

        return redirect()->route('products.index')
        ->with(['success' => 'Todo estara mejor sii']);
    }

    public function destroy(PanelProduct $product){
        // $product = Product::findOrFail($product);

        $product->delete();
        
        return redirect()->route('products.index')->with(
            ['success' => 'Todo estara mejor siiiu']
        );
    }
}
