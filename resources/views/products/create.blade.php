@extends('layouts.app')

@section('content')
    <h1>Create a product</h1>

    
    <form action="{{route('products.store')}}" 
    method = "POST"
    enctype="multipart/form-data"
    >
    @csrf
        <div class="form-row">
            <label for="">Title</label>
            <input type="text" 
            name = "title"
            value = "{{old('title')}}"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Description</label>
            <input type="text" 
            name = "description"
            value = "{{old('description')}}"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Price</label>
            <input type="number"
            min = "1.00" 
            step = "0.01"
            name = "price"
            value = "{{old('price')}}"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="">Stock</label>
            <input type="number"
            min = "0" 
            name = "stock"
            value = "{{old('stock')}}"
            class = "form-control"
            >
        </div>
        <div class="form-row">
            <label for="status">Status</label>
            <select name="status" 
            id="" 
            class="custom-elect">
                <option value="" selected>Select...</option>
                <option {{old('status') == 'available' ? 'selected' : ''}} 
                value="available" >Available</option>
                <option {{old('status') == 'unavailable' ? 'selected' : ''}}
                value="unavailable">Unavailable</option>
            </select>
        </div>

        {{-- Agregar imagen --}}
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