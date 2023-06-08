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


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/adminManageOrders">Manage Orders</a></li>
                <li class="breadcrumb-item active" style="color: black;">Search</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Search Result: <span style="font-style: italic">{{ $searchStr }}</span></h2></div>
        <p id="paragraph_num_products_found">({{ count($searchOrders) }} orders(s) found) </p>
        @if($searchOrders->total() == 0)
            <h3>Sorry, we could not find any Order<i>{{ $searchStr }}</i></h3>
        @else
        <div class="data_div">
            @foreach($searchOrders->values() as $order)
            <div class="d-flex justify-content-between align-items-center order_card mb-4">
                    <div class="col-md-3">
                        <h4 class="m-0">Order <span style="color: red">#{{ $order->id }}</span></h4>
                    </div>
                    <div class="col-md-3" style="font-size: 1.1em">
                        <span><strong>Date: </strong>{{ $order->orderdate }}</span>
                    </div>
                    <div class="col-md-3" style="font-size: 1.1em;">
                        <span><strong>State: </strong>{{ $order->orderstate }}</span>
                        <button class="btn btn-info mx-2" style="border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#changeState{{$order->id}}"><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <div class="col-md-3" style="text-align: end;">
                        <a href="{{ route('order', ['order_id'=> $order->id]) }}" class="btn btn-warning">More Info</a>
                    </div>
                </div>
                <div class="modal fade" id="changeState{{$order->id}}" tabindex="-1" aria-labelledby="changeStateLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="changeState{{$order->id}}Header">Change Order #{{ $order->id }} State</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex align-items-center justify-content-between">  
                                <label for="category_selector"><strong>New State:</strong></label>
                                <select class="form-select" name="category_selector" id="order_state{{ $order->id }}" style="width: 70%">
                                    @foreach($allOrderStates as $orderState)
                                        @if ($orderState == $order->orderstate))
                                            <option selected="selected" style="text-align: center">{{ $order->orderstate }}</option>
                                        @else
                                            <option style="text-align: center">{{ $orderState }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="updateOrder({{$order->id}})">Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="text-center">
                {!! $searchOrders->appends(request()->input())->links(); !!}
            </div>
        </div>
        @endif
    </div>
</main>

@endsection
