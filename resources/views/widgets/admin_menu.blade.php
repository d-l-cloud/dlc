@if($categoriesTop->count())
    @foreach($categoriesTop as $categoryTop)
        <li class="@if(Route::current()->getName() == 'admin.'.$categoryTop->slug) active @else nav-item @endif">
            <a href="@if($categoryTop->slug){{ route('admin.'.$categoryTop->slug) }}@endif">
                @if($categoryTop->icon != '')
                    <i class="{{ $categoryTop->icon }}"></i>
                @endif
                <span class="menu-title" data-i18n="">
                    {{ $categoryTop->name }}
                </span>
            </a>
            @if($categoryTop->sub->count())
                <ul class="menu-content">
                    @foreach($categoryTop->sub as $categoryTopSub)
                        <li class="@if(Route::current()->getName() == 'admin.'.$categoryTopSub->slug) active @else nav-item @endif">
                            <a href="{{ route('admin.'.$categoryTopSub->slug) }}">
                                @if($categoryTopSub->icon != '')
                                    <i class="{{ $categoryTopSub->icon }}"></i>
                                @endif
                                <span class="menu-title" data-i18n="">
                                    {{ $categoryTopSub->name }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                    </ul>
            @endif
        </li>
    @endforeach
@else
    <li class="active">
        <a href="#">
            Нет пунктов меню
        </a>
    </li>
@endif


