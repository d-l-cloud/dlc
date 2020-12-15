@if($productList->count()>0)
    <section>
        <div class="hits">
            <h2 class="slider-header">Самые просматриваемые товары</h2>
            <div class="hits-slider additional-slider"
                 data-infinity="1"
                 data-variable-width="1" data-compare="0">
                @foreach($productList as $productListItem)
                    <div class="item item-in-slider">
                        <div class="item-img">
                            <div class="item-img__more">
                                <div class="item-more__tools">
                                    <div class="item-number">
                                        Арт: {{ $productListItem->article }}
                                    </div>
                                </div>
                            </div>
                            <a class="img-link" href="{!! Helper::searchUrl($productListItem->productCategoryId) !!}{{ $productListItem->article }}/">
                                @if ($productListItem->images)
                                    <img src="{{ $productListItem->images }}" alt="{{ $productListItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                @else
                                    <img src="/templates/img/foto_not_found.jpg" alt="{{ $productListItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                @endif
                            </a>
                        </div>
                        <div class="item-price">
                            <div class="item-price__current">{{ number_format($productListItem->price, 0, '',' ') }} руб.</div>
                        </div>
                        <a href="{!! Helper::searchUrl($productListItem->productCategoryId) !!}{{ $productListItem->article }}/" class="item-description">
                            {{ $productListItem->name }}
                        </a>
                        <div class="item-buy">
                            <a href="{!! Helper::searchUrl($productListItem->productCategoryId) !!}{{ $productListItem->article }}/" class="item-buy__btn js_add_to_cart js_product_list">Перейти</a>
                        </div>
                    </div>
                @endforeach
            </div>
    </section>
@endif
