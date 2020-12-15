@if ($getMenu->count()>0)
    @foreach($getMenu as $getMenuItem)
        <div class="header-menu__item">

            @if ($getMenuItem->sub->count()>0)
                <span class="selection-menu">
                    <a href="{{ route('pagesName', ''.$getMenuItem->slug.'?i='.$getMenuItem->id.'') }}">{{ $getMenuItem->name }}</a>
                </span>
                <div class="menu-item__list">
                @foreach($getMenuItem->sub as $getMenuSubItem)
                        <div class="item-list__select"
                             href="{{ route('pagesName', ''.$getMenuItem->slug.'?i='.$getMenuItem->id.'') }}">
                            <a href="/o-kompanii/sotrudniki-kompanii/">
                                {{ $getMenuSubItem->name }}
                            </a>
                        </div>
                @endforeach
                </div>
            @else
                <a href="{{ route('pagesName', ''.$getMenuItem->slug.'?i='.$getMenuItem->id.'') }}">{{ $getMenuItem->name }}</a>

            @endif
        </div>
        @if ($loop->iteration==2)
            <div class="header-menu__item">
            <a href="/manufacturer/">Производители</a>
            </div>
            <div class="header-menu__item">
                <a href="/news/">Новости</a>
            </div>
        @endif
    @endforeach
@endif


