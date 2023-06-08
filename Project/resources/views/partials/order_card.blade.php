<div class="d-flex justify-content-between align-items-center order_card mb-4">
    <div class="col-md-3">
        <h4 class="m-0">Order <span style="color: red">#{{ $order->id }}</span></h4>
    </div>
    <div class="col-md-3" style="font-size: 1.1em">
        <span><strong>Date: </strong>{{ $order->orderdate }}</span>
    </div>
    <div class="col-md-3" style="font-size: 1.1em">
        <span><strong>State: </strong>{{ $order->orderstate }}</span>
    </div>
    <div class="col-md-3" style="text-align: end;">
        <a href="{{ route('order', ['order_id'=> $order->id]) }}" class="btn btn-warning">More Info</a>
    </div>
</div>