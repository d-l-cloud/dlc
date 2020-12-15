@if ($getMenu->count()>0)
    @foreach($getMenu as $getMenuItem)
        @if (($loop->first) OR ($loop->iteration==$menuCount+1) OR ($loop->iteration==($menuCount*2)+1))
            <div class="footer-col">
                <div class="footer-col__list">
        @endif
                    <p class="col-list__item">
                        <a class="footer-info__item" href="{{ route('pagesName', ''.$getMenuItem->slug.'?i='.$getMenuItem->id.'') }}">
                            {{ $getMenuItem->name }}
                        </a>
                    </p>
        @if (($loop->last) OR ($loop->iteration==$menuCount) OR ($loop->iteration==($menuCount*2)))
                 </div>
             </div>
        @endif
    @endforeach
@endif
