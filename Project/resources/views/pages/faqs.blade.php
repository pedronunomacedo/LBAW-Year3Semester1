@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">FAQs</li>
            </ol>
        </nav>
        <div class="row mb-5" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>FAQs</h2></div>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach($allFAQs as $faq)
            <div class="accordion-item mb-5" style="position: relative" id="faqForm{{ $faq->id }}">
                <h2 class="accordion-header" id="flush-heading{{ $faq->id}}">
                    <button style="font-size: 1.2rem;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $faq->id}}" aria-expanded="false" aria-controls="flush-collapse{{ $faq->id}}">
                        <span>{{ $faq->question }}</span>
                    </button>
                </h2>
                <div id="flush-collapse{{ $faq->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $faq->id}}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="font-size: 1.1em">{{ $faq->answer }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection