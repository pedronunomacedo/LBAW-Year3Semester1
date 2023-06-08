<div class="text-center py-3 category_card" style="width: 10rem; height: 12rem">
    <a href="{{ route('category_page', ['category'=> $category]) }}" style="text-decoration: none">
        <div class="mx-auto">
            <img class="rounded-circle" src='/img/{{$category}}.png' alt={{$category}} style="width: 108px; height: 108px">
        </div>
        <h5 class="mt-4">{{$category}}</h5>
    </a>
</div>
