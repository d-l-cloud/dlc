@extends('layouts.main')
@section('title')Новости | Страница - {{ $NewsList->currentPage() }} | @endsection
@section('content')
    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="{{ route('newsList') }}">Новости</a></div>
    <h1 class="page-header">Новости</h1>
    <div class="news-wrap">
    @foreach($NewsList as $newsListItem)
        <a class="last-news__item news-page-item" href="{{ route('newsItem', $newsListItem->id) }}">
            <div class="news-item__img">
                @if ($newsListItem->image)
                    <img src="{{ $newsListItem->image }}" alt="{{ $newsListItem->title }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                @else
                    <img src="/templates/img/foto_not_found.jpg" alt="{{ $newsListItem->title }}" style="vertical-align: middle;max-height:290px;max-width:290px;">
                @endif
            </div>
            <div class="news-item__header">
                {{ $newsListItem->title }}
            </div>
            <div class="news-item__description">
                {{ $newsListItem->preview }}
            </div>
        </a>
    @endforeach
    </div>
    <section class="news-links">
        {{ $NewsList->links() }}
    </section>

@endsection
