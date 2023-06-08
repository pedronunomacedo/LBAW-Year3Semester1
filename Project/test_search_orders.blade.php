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

    var deletedUsers = 0;
    function deleteUser(id, numUsers) {
        deletedUsers++;
        sendAjaxRequest("POST", "adminManageUsers/delete", {id : id}); // request sent to adminManageUsers/delete with out id {parameter : myVariable}

        document.querySelector("#userForm" + id).remove();
        document.querySelector("#paragraph_num_users_found").innerHTML = "(" + (numUsers - deletedUsers).toString() + " user(s) found)";
    }
</script>

<script src="extensions/editable/bootstrap-table-editable.js"></script>

<nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb path" style="margin: 0px 100px">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active"><a href="/adminManageOrders">SearchOrders</a></li>
    <li class="breadcrumb-item active">search({{ $searchStr }})</li>
    </ol>
</nav>

<div style="margin: 0px 100px">
    @if(count($searchOrders) == 0)
        <h2>Sorry, we could not find any orders related to user with name <i>{{ $searchStr }}</i></h2>
    @else
        <h2>We have found the following orders:</h2>
        <p id="paragraph_num_users_found">({{ count($searchOrders) }} order(s) found)</p>
        <div class="data_div">
            
            @each('partials.order_card', $searchOrders, 'order')
        </div>
    @endif
</div>


@endsection
