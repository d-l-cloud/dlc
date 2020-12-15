@if($newsList->count()>0)
<section>
    <div class="news">
        <h2 class="slider-header">Последние новости</h2>
        <div class="last-news">
            @foreach($newsList as $newsListItem)
                <a class="last-news__item" href="{{ route('newsItem', $newsListItem->id) }}">
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
</section>
@endif
