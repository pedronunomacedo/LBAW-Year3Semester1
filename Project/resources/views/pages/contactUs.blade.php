@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<main>
    <div class="mt-5 container">
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Contact us</h2></div>
        <div class="row section-container about">
            <div class="col-md-6 p-5">
                <p class="mb-5">Here's how to reach us!</p>
                <strong><p><i class="fa fa-phone"></i> 912345678</p></strong>
                <strong><p><i class="fa fa-envelope"></i> admin@tech4you.com</p></strong>
                <strong><p><i class="fa fa-building"></i> Faculdade de Engenharia da Universidade do Porto</p></strong>
            </div>
            <div class="col-md-6">
                <img src="{{ url('/images/contact_us_page.png') }}" id="about_us_image" style="max-width: 30rem" />
            </div>
        </div>
    </div>
</main>

@endsection