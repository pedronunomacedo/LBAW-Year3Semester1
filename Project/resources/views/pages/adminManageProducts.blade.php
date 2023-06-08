@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Manage Products</li>
            </ol>
        </nav>
        <div class="row mb-5" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><div style="display: flex; justify-content: space-between"><h2>Manage Products</h2><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addProduct">Add Product</button></div></div>
        <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addProductHeader">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">  
                        <div class="mb-3">
                            <label for="prod_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="prod_name">
                        </div>
                        <div class="mb-3">
                            <label for="prod_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="prod_price">
                        </div>
                        <div class="mb-3">
                            <label for="prod_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="prod_stock">
                        </div>
                        <div class="mb-3">
                            <label for="prod_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="prod_date">
                        </div>
                        <div class="mb-3">
                            <label for="prod_descp" class="form-label">Description</label>
                            <textarea type="text" class="form-control" row="3" id="prod_descp"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prod_cat" class="form-label">Category</label>
                            <select class="form-select" name="category_selector" id="prod_cat" value="Other">
                                <option style="text-align: center">Select a category</option>
                                @foreach($allCategories as $category)
                                    <option style="text-align: center">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prod_img" class="form-label">Images</label>
                            <input type="file" class="form-control" row="3" id="prod_img">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="addProduct()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between" style="gap: 2rem">
        @foreach($allProducts as $product)
            <div class="product_card mx-1 position-relative" style="width: 18rem; height: 30rem;" id="productCard {{ $product->id }} {{ $product->launchdate }} {{ $product->price }} {{ $product->score }} {{ $product->categoryname }}" style="width: 18rem;">
                <div class="product_card_img"><a style="display: block" href="{{ route('product', ['product_id'=> $product->id]) }}"><img src="{{$product->imgpath}}" alt="Card image cap"></a></div>
                <h5 class="product_card_name mb-4"><a href="{{ route('product', ['product_id'=> $product->id]) }}">{{$product->prodname}}</a></h5>
                <p class="product_card_price1 mb-1"><strong>Price: </strong>{{ $product->price }} €</p>
                <p class="product_card_date mb-1"><strong>Date: </strong>{{ $product->launchdate }}</p>
                <p class="product_card_stock mb-1"><strong>Stock: </strong>{{ $product->stock }}</p>
                <p class="product_card_category mb-1"><strong>Category: </strong>{{ $product->categoryname }}</p>
                <div class="edit_del_btn">
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editProduct{{$product->id}}"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeProduct{{$product->id}}"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="modal fade" id="editProduct{{$product->id}}" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editProduct{{$product->id}}Header">Edit Product #{{$product->id}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">  
                            <div class="mb-3">
                                <label for="prod_name{{$product->id}}" class="form-label">Name</label>
                                <input type="text" class="form-control" id="prod_name{{$product->id}}" value="{{ $product->prodname }}">
                            </div>
                            <div class="mb-3">
                                <label for="prod_price{{$product->id}}" class="form-label">Price</label>
                                <input type="number" class="form-control" id="prod_price{{$product->id}}" value="{{ $product->price }}">
                            </div>
                            <div class="mb-3">
                                <label for="prod_stock{{$product->id}}" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="prod_stock{{$product->id}}" value="{{ $product->stock }}">
                            </div>
                            <div class="mb-3">
                                <label for="prod_date{{$product->id}}" class="form-label">Date</label>
                                <input type="date" class="form-control" id="prod_date{{$product->id}}" value="{{ $product->launchdate }}">
                            </div>
                            <div class="mb-3">
                                <label for="prod_descp{{$product->id}}" class="form-label">Description</label>
                                <textarea class="form-control" rows="5" id="prod_descp{{$product->id}}">{{ $product->proddescription }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="prod_cat{{$product->id}}" class="form-label">Category</label>
                                <select class="form-select" name="category_selector" id="prod_cat{{$product->id}}">
                                    @foreach($allCategories as $category)
                                        @if ($category == $product->categoryname))
                                            <option selected="selected" style="text-align: center">{{ $product->categoryname }}</option>
                                        @else
                                            <option style="text-align: center">{{ $category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="prod_img{{$product->id}}" class="form-label">Images</label>
                                <input type="file" class="form-control" row="3" id="prod_img{{$product->id}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="updateProduct({{ $product->id }})">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="removeProduct{{$product->id}}" tabindex="-1" aria-labelledby="removeProductLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="removeProduct{{$product->id}}Header">Remove Product #{{$product->id}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">  
                            After this action this product will be removed.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <div class="text-center">
            {!! $allProducts->links(); !!}
        </div>
    </div>
</main>
@endsection