@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Manage Orders</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Manage Orders</h2></div>
        <div id="search_div" style="display: block; text-align: center; width: 100%; margin-bottom: 1rem">
            <form action="{{ url('search/orders') }}" method="GET" role="search">
                <input type="search" name="search" value="" class="form-control form-control-light text-bg-light" placeholder="Search for orders" aria-label="Search">
            </form>
        </div>
        @foreach($allOrders as $order)
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
            {{ $allOrders->links(); }}
        </div>
        <!--<nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg">
                <li class="page-item">
                    <a class="page-link" style="background-color: red; color: white; " href="{{$allOrders->previousPageUrl()}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for($i = 1; $i <= $allOrders->lastPage(); $i++)
                    <li class="page-item"><a class="page-link" style="color:red" href="{{$allOrders->url($i)}}">{{ $i }}</a></li>
                @endfor
                <li class="page-item">
                    <a class="page-link" style="background-color: red; color: white; border: 0;" href="{{$allOrders->nextPageUrl()}}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>-->
    </div>
</main>

@endsection