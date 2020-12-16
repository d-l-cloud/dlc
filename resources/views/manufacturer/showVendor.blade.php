@extends('layouts.main')
@section('title')Производитель - {{ $manufacturerData->name }} | @endsection
@section('content')
    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="{{ route('manufacturerList') }}">Производители</a><div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{{ $manufacturerData->name }}</div></div>
    <article>
        <section class="main-catalog__header">
            <h1 class="page-header">Производитель - {{ $manufacturerData->name }}</h1>
        </section>
        <section class="brand-catalog" style="margin-bottom: 25px;">
            <div class="brand-description" style="margin-bottom: 25px;">
                <div class="brand-img">
                    @if ($manufacturerData->images)
                        <img src="{{ $manufacturerData->images }}" alt="{{ $manufacturerData->title }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                    @else
                        <img src="/templates/img/foto_not_found.jpg" alt="{{ $manufacturerData->title }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                    @endif
                </div>
                @if ($manufacturerData->text)
                <div class="brand-info-wrap">
                    <div class="brand-info">
                        <style>
                            .desc_man {
                                text-align: justify;
                                text-justify: inter-word;
                            }
                            .desc_man ul {
                                list-style-type: disc;
                                padding: 10px;
                            }

                            .desc_man li::first-letter {
                                text-transform: capitalize;
                            }

                        </style>
                        <div class="desc_man">
                            {!! $manufacturerData->text !!}
                        </div>
                        <br>						</div>
                    <div class="brand-info__more">Читать полностью</div>
                    <div class="brand-info__less">Скрыть</div>
                </div>
                @endif
            </div>

                @foreach($getAllCategory as $keyCategory=>$getAllCategoryItem)
                <div class="catalog-slider-row">
                        <h2 class="slider-header">{{ $getAllCategoryItem }}</h2>
                    <div class="additional-slider">
                        @widget('vendorProduct', ['vendorCode'=>$manufacturerData->id,'productCategoryId'=>$keyCategory])
                    </div>
                </div>
                @endforeach
        </section>
    </article>
@endsection
