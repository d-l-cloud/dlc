@extends('layouts.main')
@section('title'){{ $productData->name }} - @endsection
@section('content')

    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList">
        <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a>
        <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/">Каталог</a>
        @if ($productItemLink['link']['subCat']['url']!='')
            <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/{{ $productItemLink['link']['cat']['url'] }}/">{{ $productItemLink['link']['cat']['name'] }}</a>
            <a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/katalog/{{ $productItemLink['link']['cat']['url'] }}/{{ $productItemLink['link']['subCat']['url'] }}/">{{ $productItemLink['link']['subCat']['name'] }}</a>
            <div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                {{ $productData->name }}
            </div>
        @else

        @endif

    </div>
    <article id="product-info-12711" class="product" itemscope itemtype="http://schema.org/Product">
        <meta itemprop="name" content="{{ $productData->name }}">
        <section>
            <div class="product-info">
                <div class="product-info__col product-col__slider">
                        @if (($productItemImages!='') OR ($productData->images!=''))
                        <div class="fotorama" data-nav="thumbs" data-fit="contain" data-allowfullscreen="true">

                                <a data-fancybox="gallery-0" href="{{ $productData->images }}"><img src="{{ $productData->images }}"></a>

                            @foreach($productItemImages as $productItemImagesItem)

                                    <a data-fancybox="gallery-0" href="{{ $productItemImagesItem }}"><img src="{{ $productItemImagesItem }}"></a>

                            @endforeach
                        </div>
                        @endif

                </div>


                <div class="product-info__col product-col__data">
                    <div class="product-header">
                                            						<span itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
					            <meta itemprop="lowPrice" content="{{ $productData->price }}">
					            <meta itemprop="highPrice" content="{{ $productData->price }}">
					            <meta itemprop="priceCurrency" content="RUB">
					            <meta itemprop="offerCount" content="4">

					            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
									<meta itemprop="price" content="{{ $productData->price }}">
									<meta itemprop="priceCurrency" content="RUB">

					                						                <link itemprop="availability" href="http://schema.org/InStock">
                                    								</span>
					        </span>

                        <h1 class="product-header offer_prop_block">{{ $productData->name }}</h1>
                        <div class="product-share">
                            <script src="https://yastatic.net/share2/share.js"></script>
                            <div class="ya-share2" data-curtain data-shape="round" data-limit="0" data-more-button-type="short" data-services="collections,vkontakte,facebook,odnoklassniki,messenger,telegram,twitter,viber,whatsapp,moimir"></div>
                        </div>
                    </div>
                    <div class="product-info__main">
                        <div class="product-rate">
                            <div class="product-rate__rating">
                                <div class="rate-item rate-articul offer_prop_block js-catalog-detail-articul" data-value="{{ $productData->article }}"  prop_art="{{ $productData->article }}">
                                    Артикул {{ $productData->article }}
                                </div>
                                  </div>
                        </div>
                        <div class="product-price offer_prop_variant offer_prop_block">
                            <div class="item-price__current product-price__current">
                                {{ number_format($productData->price, 0, '',' ') }} руб.			                    </div>
                        </div>

                        <div class="product-status offer_prop_block_amount">
                            <a data-fancybox data-type="iframe" data-src="/siteform/{{ $productData->article }}/1" href="javascript:;"><div class="product-status__opt">
                                Получить оптовые цены
                                <span class="status-opt__icon">
                                        <img src="/templates/img/tooltip.svg" alt="">
                                        <span class="tooltip">
                                            Форма запроса на оптовые цены
                                        </span>
                                    </span>
                            </div>
                            </a>
                        </div>
                        <div class="char-doc">
                            <div class="characteristics">
                                <div class="chars-row">
                                    <div class="chars-col">
                                        @if($productData->vendor->name)
                                            <div class="chars-col__row">
                                                <div class="chars-props">Производитель </div>
                                                <div class="chars-value"><a href="{{ route('manufacturerItem', $productData->vendor->id) }}">{{ $productData->vendor->name }}</a></div>
                                            </div>
                                        @endif
                                        @if($productPropertyMainList)
                                            @foreach($productPropertyMainList as $productPropertyMainList)
                                                <div class="chars-col__row">
                                                    <div class="chars-props">{{ $productPropertyMainList->propertyName->name }} </div>
                                                    <div class="chars-value">
                                                        @if($productPropertyMainList->propertyName->name == 'Гарантированное количество циклов открывания/закрывания '){{ number_format($productPropertyMainList->value, 0, '',' ') }}
                                                        @elseif($productPropertyMainList->propertyName->name == 'Надежность')
                                                                <div class="rate-item rate-stars">
                                                                    @for ($i = 0; $i <= 5; $i++)
                                                                        <div class="rating-stars__item @if($i<$productPropertyMainList->value) active-star @endif">
                                                                            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M5.14922 0.569341C5.51145 -0.18978 6.59201 -0.18978 6.95425 0.569341L7.8341 2.41321C7.97988 2.71872 8.27032 2.92974 8.60593 2.97398L10.6314 3.24098C11.4653 3.3509 11.7993 4.37858 11.1892 4.95766L9.70749 6.36424C9.46198 6.59729 9.35104 6.93873 9.41268 7.27157L9.78466 9.28046C9.93781 10.1075 9.06362 10.7427 8.32436 10.3414L6.52875 9.36687C6.23124 9.2054 5.87223 9.2054 5.57472 9.36687L3.77911 10.3414C3.03985 10.7427 2.16566 10.1075 2.31881 9.28046L2.69079 7.27157C2.75242 6.93873 2.64149 6.59729 2.39598 6.36424L0.914243 4.95766C0.304212 4.37858 0.638124 3.3509 1.47203 3.24098L3.49754 2.97398C3.83315 2.92974 4.12359 2.71872 4.26937 2.41321L5.14922 0.569341Z" fill="#D2D7E0"></path>
                                                                            </svg>
                                                                        </div>
                                                                    @endfor
                                                                </div>
                                                        @else
                                                            {{ $productPropertyMainList->value }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            @if ($productVariable->count()>0)
                <h1 class="product-header offer_prop_block">Варианты товара - {{ $productData->name }}</h1>
                <section class="related offer_prop_block">
                    <div class="catalog-slider-row">
                        <div class="additional-slider">
                            @foreach ($productVariable as $productVariableItem)
                                <div class="item item-in-slider">
                                    <div class="item-img">
                                        <div class="item-img__more">
                                            <div class="item-more__tools">
                                                <div class="item-number">
                                                    Арт: {{ $productVariableItem->article }}
                                                </div>
                                            </div>
                                        </div>
                                        <a class="img-link" href="{!! Helper::searchUrl($productVariableItem->productCategoryId) !!}{{ $productVariableItem->article }}/">
                                            @if ($productVariableItem->images)
                                                <img src="{{ $productVariableItem->images }}" alt="{{ $productVariableItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                            @else
                                                <img src="/templates/img/foto_not_found.jpg" alt="{{ $productVariableItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="item-price">
                                        <div class="item-price__current">{{ number_format($productVariableItem->price, 0, '',' ') }} руб.</div>
                                    </div>
                                    <a href="{!! Helper::searchUrl($productVariableItem->productCategoryId) !!}{{ $productVariableItem->article }}/" class="item-description">
                                        {{ $productVariableItem->name }}
                                    </a>
                                    <div class="item-buy">
                                        <a href="{!! Helper::searchUrl($productVariableItem->productCategoryId) !!}{{ $productVariableItem->article }}/" class="item-buy__btn js_add_to_cart js_product_list">Перейти</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </section>
            @endif
            </section>
        <section>
            <div class="char-doc">
                @if($productPropertyAllMainList->count()>0)
                <div class="characteristics">
                    <div class="section-header">
                        Технические характеристики
                    </div>
                    <div class="chars-row">

                    @forelse($productPropertyAllMainList as $productPropertyAllMainItem)
                            @if ($loop->first)
                                <div class="chars-col">
                            @endif
                            @if ($loop->iteration==$productPropertyAllMainListCount+1)
                                </div>
                                <div class="chars-col">
                             @endif
                                <div class="chars-col__row">
                                    @if ($productPropertyAllMainItem->propertyName->name=="Видео")
                                    <div class="chars-props">{{ $productPropertyAllMainItem->propertyName->name }} </div>
                                        <div class="chars-value"><a data-fancybox="gallery-0" href="{{ $productPropertyAllMainItem->value }}"><i class="fas fa-play-circle"></i> Посмотреть</a></div>
                                    @else
                                    <div class="chars-props">{{ $productPropertyAllMainItem->propertyName->name }} </div>
                                    <div class="chars-value">{{ str_replace(',',', ', $productPropertyAllMainItem->value) }}</div>
                                    @endif
                                </div>
                            @if ($loop->last)
                                </div>
                            @endif
                    @empty
                    @endforelse
                    </div>
                </div>
                @endif
                @if($productItemFiles)
                    <div class="documents">
                        <div class="section-header">
                            Документы
                        </div>
                        <div class="docs-col">
                            @foreach($productItemFiles as $productItemFilesItem)
                            <div class="docs-item">
                                <img src="{{ asset('templates/img/pdf-icon.svg') }}">
                                <a href="{{ $productItemFilesItem }}" target="_blank">Документ для {{ $productData->name }} - {{ $loop->iteration }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
            </div>
        </section>

        @if(($prodSopList) AND ($prodSopList->count()>0))
        <section class="related offer_prop_block">

            <div class="catalog-slider-row">
                <h2 class="slider-header">Сопутствующие товары</h2>
                <div class="additional-slider">
                    @foreach ($prodSopList as $prodSopListItem)
                        <div class="item item-in-slider">
                            <div class="item-img">
                                <div class="item-img__more">
                                    <div class="item-more__tools">
                                        <div class="item-number">
                                            Арт: {{ $prodSopListItem->article }}
                                        </div>
                                    </div>
                                </div>
                                <a class="img-link" href="{!! Helper::searchUrl($prodSopListItem->productCategoryId) !!}{{ $prodSopListItem->article }}/">
                                    @if ($prodSopListItem->images)
                                        <img src="{{ $prodSopListItem->images }}" alt="{{ $prodSopListItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                    @else
                                        <img src="/templates/img/foto_not_found.jpg" alt="{{ $prodSopListItem->name }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                                    @endif
                                </a>
                            </div>
                            <div class="item-price">
                                <div class="item-price__current">{{ number_format($prodSopListItem->price, 0, '',' ') }} руб.</div>
                            </div>
                            <a href="{!! Helper::searchUrl($prodSopListItem->productCategoryId) !!}{{ $prodSopListItem->article }}/" class="item-description">
                                {{ $prodSopListItem->name }}
                            </a>
                            <div class="item-buy">
                                <a href="{!! Helper::searchUrl($prodSopListItem->productCategoryId) !!}{{ $prodSopListItem->article }}/" class="item-buy__btn js_add_to_cart js_product_list">Перейти</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif



    </article>
@endsection
@section('javascriptfb')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
@endsection
