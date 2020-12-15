@extends('layouts.main')
@section('title') @if (($productItemLink['link']['subCat']['url']!='') AND ($productItemLink['link']['cat']['url']!='')){{ $productItemLink['link']['cat']['name'] }} - {{ $productItemLink['link']['subCat']['name'] }}@elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']!='')) {{ $productItemLink['link']['cat']['name'] }} @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']=='')) Каталог продукции @endif | Страница - {{ $productList->currentPage() }} @endsection
@section('content')
    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList">
        <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a>
        @if (($productItemLink['link']['subCat']['url']!='') AND ($productItemLink['link']['cat']['url']!=''))
            <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/">Каталог</a>
            <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/{{ $productItemLink['link']['cat']['url'] }}/">{{ $productItemLink['link']['cat']['name'] }}</a>
            <div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                {{ $productItemLink['link']['subCat']['name'] }}
            </div>
        @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']!=''))
            <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/">Каталог</a>
            <div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                {{ $productItemLink['link']['cat']['name'] }}
            </div>
        @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']==''))
            <div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                Каталог
            </div>
        @endif

    </div>
    <article>

        <section class="main-catalog__header">
            @if (($productItemLink['link']['subCat']['url']!='') AND ($productItemLink['link']['cat']['url']!=''))
            <h1 class="page-header">{{ $productItemLink['link']['subCat']['name'] }}</h1>
            @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']!=''))
                <h1 class="page-header">{{ $productItemLink['link']['cat']['name'] }}</h1>
            @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']==''))
                <h1 class="page-header">Каталог продукции</h1>
            @endif
                @if ($getAllSubCategories!='')
                @if ($getAllSubCategories->count()>0)
                    <div class="categories-slide">
                    @foreach($getAllSubCategories as $categoryItem)
                        <a href="/katalog/{{Request::segment(2)}}/{{$categoryItem->slug}}/" class="categories-slide__item">
                            <div class="content-item__block categories-slide__item">
                                <div class="tab-block__info categories-slide__info">
                                    <div class="block-info__name categories-slide__name">{{$categoryItem->name}}</div>
                                    <div class="tab-info__goods">
                                        {{$categoryItem->productList->count()}} {{ Lang::choice('товар|товара|товаров', $categoryItem->productList->count(), [], 'ru') }}								</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                @endif
                @endif
        </section>
        <section class="main-catalog">
            <div class="main-catalog-wrap">

                <div class="cat-col cat-col__left">
                    @if ($filterData!=0)
                    <form class="sidebar sidebar-filter" name="_form" action="{{ route('filter.setFilterValues') }}" method="post">
                        @csrf
                        <input type="hidden" name="catalogPage" value="{{Request::segment(2)}}">
                        <input type="hidden" name="catalogSubPage" value="{{Request::segment(3)}}">
                        <input type="hidden" name="allMinPrice" value="{{ $filterData['minPrice'] }}">
                        <input type="hidden" name="allMaxPrice" value="{{ $filterData['maxPrice'] }}">
                        <div class="filter-block filter-range">
                            <div class="filter-header">Цена, руб</div>
                            <span class="tick spin"></span>
                            <div class="filter-hidden range-wrap js-catalog-range filter-visible" data-min-value="{{ $filterData['minPrice'] }}" data-max-value="{{ $filterData['maxPrice'] }}" data-cur-min-value="@if(Session::get('minPrice')){{ Session::get('minPrice') }}@else{{ $filterData['minPrice'] }}@endif" data-cur-max-value="@if(Session::get('maxPrice')){{ Session::get('maxPrice') }}@else{{ $filterData['maxPrice'] }}@endif">
                                <div class="js-catalog-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: {{ Session::get('percentPriceMin') }}%; width: {{ Session::get('percentPriceMinMax') }}%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: {{ Session::get('percentPriceMin') }}%;"></a><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a></div>
                                <div class="double-input">
                                    <input type="text" class="cost-input js-catalog-range-min active-input" name="minPriceFilter" value="@if(Session::get('minPrice')){{ Session::get('minPrice') }}@else{{ $filterData['minPrice'] }}@endif">
                                    <input type="text" class="cost-input js-catalog-range-max active-input" name="maxPriceFilter" value="@if(Session::get('maxPrice')){{ Session::get('maxPrice') }}@else{{ $filterData['maxPrice'] }}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="filter-block">
                            <div class="filter-header">Производитель</div>
                            <span class="tick spin"></span>
                            <div class="filter-hidden range-wrap filter-visible">

                                @foreach($filterData['vendorList'] as $vendorListItem)



                                    <div class="checkbox-item" data-prop-id="{{ $vendorListItem['vendorId'] }}" data-prop-value="{{ $vendorListItem['vendorName'] }}">
                                        <input
                                            @if(Session::get('vendorList'))
                                            @if(in_array($vendorListItem['vendorId'], Session::get('vendorList')))
                                            checked
                                            @endif
                                            @endif
                                            class="custom-checkbox active-input" type="checkbox" value="{{ $vendorListItem['vendorId'] }}" name="vendorName[]">
                                        <label class="checkbox-label" for="arrFilter_8_608837457">{{ $vendorListItem['vendorName'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-block">
                            <button class="item-buy__btn">Применить</button>
                        </div>
                    </form>
                    @endif
                </div>

                <div class="cat-col cat-col__right">
                    <div class="cat-right__inner">
                        @if (Session::get('minPrice')!='' OR Session::get('maxPrice')!='' OR Session::get('vendorList')!='')
                        <div class="filter-tab-row js-product-filters">
                            @if (Session::get('minPrice')!='')
                            <div class="filter-tab">
                                <div class="filter-tab-label">
                                    Цена от {{ number_format(Session::get('minPrice'), 0, '',' ') }}
                                </div>
                                <div class="filter-tab-close">
                                    <a href="{{ route('filter.delFilterValues', ['price_from']) }}"><img src="/templates/img/catalog/close-filter.svg"></a>
                                </div>
                            </div>
                            @endif
                                @if (Session::get('maxPrice')!='')
                                    <div class="filter-tab">
                                        <div class="filter-tab-label">
                                            Цена до {{ number_format(Session::get('maxPrice'), 0, '',' ') }}
                                        </div>
                                        <div class="filter-tab-close">
                                            <a href="{{ route('filter.delFilterValues', ['price_to']) }}"><img src="/templates/img/catalog/close-filter.svg"></a>
                                        </div>
                                    </div>
                                @endif
                                @if($allVendorFiltredList[0]!='')
                                    @foreach($allVendorFiltredList as $allVendorFiltredListItem)
                                    <div class="filter-tab">
                                        <div class="filter-tab-label">
                                            {{ $allVendorFiltredListItem['name'] }}
                                        </div>
                                        <div class="filter-tab-close">
                                            <a href="{{ route('filter.delFilterValues', ['vendor','id'=>$allVendorFiltredListItem['id']]) }}"><img src="/templates/img/catalog/close-filter.svg"></a>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                <a href="{{ route('filter.delFilterValues', ['all']) }}"><div class="filter-tab close-filter-tabs" id="del_all_filters">
                                Очистить все фильтры
                            </div></a>
                        </div>
                        @endif
                        <div class="goods-tab__content tabs-in-col js-products-in-col goods-active__content">
                            @forelse($productList as $item)
                                <div class="item item-in-catalog">
                                    <div class="item-img">
                                        <div class="item-img__more">
                                            <div class="item-more__tools">
                                                <div class="item-number">
                                                    Арт: {{ $item->article }}
                                                </div>
                                            </div>
                                        </div>
                                        <a class="img-link" href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/">
                                            @if ($item->images)
                                                <img src="{{ $item->images }}" alt="{{ $item->name }}" style="max-height:290px;max-width:290px;">
                                            @else
                                                <img src="/templates/img/foto_not_found.jpg" alt="{{ $item->name }}" style="max-height:290px;max-width:290px;">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="item-price">
                                        <div class="item-price__current">{{ number_format($item->price, 0, '',' ') }} руб.</div>
                                    </div>
                                    <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-description">{{ $item->name }}</a>
                                    <div class="item-buy" >
                                        <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-buy__btn js_product_list">Перейти</a>
                                    </div>
                                    @if (Helper::variable($item->parentArticle) > 0)
                                        <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-variants">Еще {!! Helper::variable($item->parentArticle) !!} {{ Lang::choice('вариант|варианта|вариантов', Helper::variable($item->parentArticle), [], 'ru') }}</a>
                                    @else
                                    @endif
                                </div>
                            @empty
                                <h1>Нет товаров в категории -
                                @if (($productItemLink['link']['subCat']['url']!='') AND ($productItemLink['link']['cat']['url']!=''))
                                    {{ $productItemLink['link']['subCat']['name'] }}
                                @elseif (($productItemLink['link']['subCat']['url']=='') AND ($productItemLink['link']['cat']['url']!=''))
                                    {{ $productItemLink['link']['cat']['name'] }}
                                @endif
                                     </h1>
                            @endforelse

                        </div>
                    </div>
                    <section>
                        {{ $productList->links() }}
                    </section>
                </div>
            </div>
        </section>
    </article>
@endsection
