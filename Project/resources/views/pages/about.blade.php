@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<main>
    <div class="mt-5 container">
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>About us</h2></div>
        <div class="row p-3">
            <p>
                We are a group of students from the University of Porto of Engeneering Faculty.
                We developed this project during the course of Laboratory Databases and Web Applications (LBAW).
                <br>This project is developed in Laravel.
                <br><strong>We hope you enjoy exploring our site!</strong>
            </p>
        </div>
        <div class="row about">
            <div class="col-md-6 p-5 mt-5" id="administrators">
                <strong>Administrators: </strong>
                <p>Pedro Jorge da Rocha Balazeiro, up202005097</p>
                <p>Pedro Nuno Ferreira Moura de Macedo, up202007531</p>
                <p>Rúben Costa Viana, up202005108</p>
            </div>
            <div class="col-md-6">
                <img src="{{ url('/images/about_us_page.png') }}" id="about_us_image" style="max-width: 30rem" />
            </div>
        </div>
        <div class="row justify-content-center" id="image_container">
        </div>
    </div>
</main>

@endsection