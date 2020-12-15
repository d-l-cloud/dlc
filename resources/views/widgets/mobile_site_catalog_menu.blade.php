@if($categories->count())
    <div class="cataloglist-mobile">
            @foreach($categories as $category)
                <div class="cataloglist-item">
                    <a class="cataloglist-item__elem" href="{{ route('katalog.katalogCategory', [$category->slug]) }}">{{ $category->name }}</a>
                </div>
            @endforeach
    </div>
@endif
