@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="path" class="breadcrumb" style="margin: 0px 100px">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Manage Users</li>
  </ol>
</nav>
  
@elseif (Auth::check())
  <div class="list-group" style="padding-left: 10px; width: 15%; font-size: 120%;">
    <button href="#" class="list-group-item list-group-item-action active">My details</button>
    <button href="#" class="list-group-item list-group-item-action">My Addresses</button>
    <button href="#" class="list-group-item list-group-item-action">My Orders</button>
    <button href="#" class="list-group-item list-group-item-action" data-target="#exampleModal">Delete account</button>
  </div>
@endif

@endsection