@extends('layouts.app')

@section('content')
    <h1>Create a product</h1>

    
    <form 
    enctype = "multipart/form-data"
    action="{{route('products.update', ['product' => $product])}}" 
    method = "POST">
    @csrf
    @method('PATCH')
        <div class="form-row">
            <label for="">Title</label>
            <input type="text" 
            name = "title"
            value = "{{ old('title')  ?? $product->title}}"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Description</label>
            <input type="text"
            value = "{{ old('description') ?? $product->description}}" 
            name = "description"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Price</label>
            <input type="number"
            min = "1.00" 
            step = "0.01"
            value = "{{old('price') ?? $product->price}}"
            name = "price"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Stock</label>
            <input type="number"
            min = "0"
            value = "{{old('stock') ?? $product->stock}}" 
            name = "stock"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="status">Status</label>
            <select name="status" 
            id="" 
            class="custom-elect">
                <option {{ old('status') == 'available' ? 'selected' : 
                ($product->status == 'available' ? 'selected' : '')}}  value="available">Available</option>
                
                <option {{old('status') == 'unavailable' ? 'selected' : 
                ($product->status == 'unavailable' ? 'selected' : '')}} value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="form-row">
            <label>
                {{ __('Images') }}
            </label>

                <div class="custom-file">
                    <input type="file"
                    accept = "image/*"
                    multiple
                    name = "images[]"
                    class = "custom-file-input"
                    >
                    <label class = "custom-file-label"
                    for="">
                        Product image...
                    </label>
                </div>
        </div>

        <div class="form-row">
            <button type = "submit"
            class = "mt-3 btn-lg btn btn-primary"
            >Create product</button>
        </div>
    </form>

@endsection