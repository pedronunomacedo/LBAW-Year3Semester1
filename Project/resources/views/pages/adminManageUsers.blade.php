@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Manage Users</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Manage Users</h2></div>
        <div id="search_div" style="display: block; text-align: center; width: 100%;">
            <form action="{{ url('search') }}" method="GET" role="search">
                <input type="search" name="search" value="" class="form-control form-control-light text-bg-light" placeholder="Search for users" aria-label="Search">
            </form>
        </div>
        <div class="data_div d-flex flex-wrap justify-content-between" style="gap: 2rem">
            @foreach($allUsers as $user)
                <div class="user_card" style="margin-top: 30px; display: flex;" id="userCard{{ $user->id }}">
                    <a href="{{route('profile', $user->id)}}"><span>{{ $user->name }}</span><span>#{{ $user->id }}</span></a>
                    <div class="edit_del_btn">
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeUser{{$user->id}}"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="modal fade" id="removeUser{{$user->id}}" tabindex="-1" aria-labelledby="removeUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="removeUser{{$user->id}}Header">Remove User #{{ $user->id }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                After this action user <strong>{{$user->name}}</strong> will be removed from this website.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="deleteUser({{$user->id}})">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            {!! $allUsers->links(); !!}
        </div>
    </div>
</main>

@endsection