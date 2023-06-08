@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<script>
    function encodeForAjax(data) {
        if (data == null) return null;
        return Object.keys(data).map(function(k){
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        }).join('&');
    }

    function sendAjaxRequest(method, url, data, handler) {
        let request = new XMLHttpRequest();

        request.open(method, url, true);
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.addEventListener('load', handler);
        request.send(encodeForAjax(data));
    }

    var deletedProducts = 0; // global variable  
    function deleteProduct(id, numProducts) {
        deletedProducts++;
        sendAjaxRequest("POST", "adminManageProducts/delete", {id : id}); // request sent to adminManageProducts/delete with out id {parameter : myVariable}
        document.querySelector("#productForm" + id).remove();
        document.querySelector("#paragraph_num_products_found").innerHTML = "(" + (numProducts - deletedProducts).toString() + " product(s) found)";
    }
</script>

<nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="margin: 0px 100px">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active"><a href="/adminManageProducts">SearchProducts</a></li>
        <li class="breadcrumb-item active">search({{ $searchStr }})</li>
    </ol>
</nav>

<script src="extensions/editable/bootstrap-table-editable.js"></script>

<div class="mainDiv" style="margin: 0px 100px">
    @if($searchProducts->total() == 0)
        <h3>Sorry, we could not find any product with name <i>{{ $searchStr }}</i></h3>
    @else

    <h1>We have found the following products:</h1>
    <p id="paragraph_num_products_found">({{ $searchProducts->total() }} product(s) found) </p>
    <div class="data_div">
        @foreach($searchProducts as $product)
            <div class="card userCard" style="margin-top: 30px; display: flex;" id="productForm{{ $product->id }}">
                <div class="card-header">
                    <strong>{{ $product->prodname }}</strong>
                </div>
                <div class="card_body" style="padding: 20px">
                    <div class="card_body" style="display: inline-block;">
                        <p class="card-text productPrice">Price: {{ $product->price }}</p>
                        <p class="card-text productLaunchdate">Launch date: {{ $product->launchdate }}</p>    
                    </div>
                    <div class="div_buttons" style="display: inline-block; float: right; align-items: center;">
                        <a class="btn" onClick="" style="text-align: center; justify-content: center;">
                            <svg fill="none" height="40" width="40" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 13V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V13" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15V3M12 3L8.5 6.5M12 3L15.5 6.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <a class="btn" id="productSearch" onClick="deleteProduct({{ $product->id }}, {{ $searchProducts->total() }})" style="text-align: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        {!! $searchProducts->appends(request()->input())->links(); !!}
    </span>
</div>
@endif

@endsection
