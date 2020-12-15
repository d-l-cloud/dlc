@extends('layouts.main')
@section('title'){{ $NewsData->title }} | @endsection
@section('content')
    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="{{ route('newsList') }}">Новости</a><div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{{ $NewsData->title }}</div></div>
    <div class="news-detail">
        <div class="news-detail-wrap">
            <h1 class="page-header">
                {{ $NewsData->title }}</h1>
            <p class="data-news"><i class="far fa-calendar-alt"></i> {{ $NewsData->created_at }} | <i class="far fa-eye"></i> {{ $NewsData->views }}</p>
            <div class="singlepage-textblock">
                {!! $NewsData->text !!}
            </div>
        </div>
    </div>
@endsection
