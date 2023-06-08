@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Manage FAQs</li>
            </ol>
        </nav>
        <div class="row mb-5" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><div style="display: flex; justify-content: space-between"><h2>Manage FAQs</h2><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addFaq">Add FAQ</button></div></div>
        <div class="modal fade" id="addFaq" tabindex="-1" aria-labelledby="addFaqLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addFaqHeader">Add FAQ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">  
                        <div class="mb-3">
                            <label for="faq_question" class="form-label">Name</label>
                            <input type="text" class="form-control" id="faq_question">
                        </div>
                        <div class="mb-3">
                            <label for="faq_answer" class="form-label">Answer</label>
                            <textarea class="form-control" id="faq_answer" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="addFAQ()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion accordion-flush" id="accordionFlushExample">
        @foreach($allFAQs as $faq)
            <div class="accordion-item mb-5" style="position: relative" id="faqForm{{ $faq->id }}">
                <h2 class="accordion-header" id="flush-heading{{ $faq->id}}">
                    <button style="font-size: 1.2rem;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $faq->id}}" aria-expanded="false" aria-controls="flush-collapse{{ $faq->id}}">
                        <span><strong>#{{ $faq->id }} </strong> {{ $faq->question }}</span>
                    </button>
                </h2>
                <div class="edit_del_btn">
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editFaq{{$faq->id}}"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeFaq{{$faq->id}}"><i class="fas fa-trash"></i></button>
                </div>
                <div id="flush-collapse{{ $faq->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $faq->id}}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="font-size: 1.1em">{{ $faq->answer }}</div>
                </div>
            </div>
            <div class="modal fade" id="editFaq{{$faq->id}}" tabindex="-1" aria-labelledby="editFaqLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editFaq{{$faq->id}}Header">Edit FAQ #{{$faq->id}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">  
                            <div class="mb-3">
                                <label for="faq_question{{ $faq->id }}" class="form-label">Question</label>
                                <input type="text" class="form-control" id="faq_question{{ $faq->id }}" value="{{ $faq->question }}">
                            </div>
                            <div class="mb-3">
                                <label for="faq_answer{{ $faq->id }}" class="form-label">Answer</label>
                                <textarea class="form-control" id="faq_answer{{ $faq->id }}" rows="3">{{ $faq->answer }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="updateFAQ({{ $faq->id }})"">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="removeFaq{{$faq->id}}" tabindex="-1" aria-labelledby="removeFaqLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="removeFaq{{$faq->id}}Header">Remove FAQ #{{$faq->id}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">  
                            After this action this FAQ will be removed.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="deleteFAQ({{ $faq->id }})">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</main>
@endsection