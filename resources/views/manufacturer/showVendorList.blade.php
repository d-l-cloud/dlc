@extends('layouts.main')
@section('title')Производители | @endsection
@section('content')
    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="{{ route('manufacturerList') }}">Производители</a></div>
    <article>
    <h1 class="page-header" style="margin-bottom: -75px;">Производители</h1>
        <section class="brands-list container" style="margin-bottom: 115px;">
        @foreach($vendorList as $vendorListItem)
                <a href="{{ route('manufacturerItem', $vendorListItem->id) }}">
                <div class="card card2">
                    <div class="face face1">
                        <div class="content">
                            <h3>{{ $vendorListItem->name }}</h3>
                        </div>
                    </div>
                    <div class="face face2">
                        <div class="content">
                        </div>
                    </div>
                </div>
                </a>
        @endforeach
        </section>
    </article>
@endsection
