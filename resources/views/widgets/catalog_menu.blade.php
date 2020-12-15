@if($categories->count())
    <div class="catalog">
        <div class="catalog-tabs tabs-switcher">
            @foreach($categories as $category)
            <div class="catalog-tabs__item">{{ $category->name }}</div>
            @endforeach
        </div>
        @if($category->sub->count())
            <div class="catalog-content tabs-content">
                @foreach($categories as $category)
                    @if($category->sub->count())
                        <div class="tab-content__item content-item ">
                        @foreach($category->sub as $categorySub)
                            @if ($loop->first)
                                <div class="content-block__wrap">
                            @endif
                            @if (($loop->odd) AND ($loop->iteration>1))
                                <div class="content-block__wrap">
                            @endif
                                    <a class="content-item__block" href="{{ route('katalog.katalogSubCategory', [$category->slug,$categorySub->slug]) }}">
                                        <div class="tab-block__info">
                                            <div class="block-info__name">{{ $categorySub->name }}</div>
                                            <div class="tab-info__goods">
                                                {{ $categorySub->productList->count() }} {{ Lang::choice('товар|товара|товаров', $categorySub->productList->count(), [], 'ru') }}
                                            </div>
                                        </div>
                                    </a>
                            @if (($loop->even) AND ($loop->iteration!=$category->sub->count()))
                                </div>
                            @endif
                            @if ($loop->last)
                                </div>
                            @endif
                        @endforeach
                        </div>
                    @else
                        <div class="tab-content__item content-item">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif
