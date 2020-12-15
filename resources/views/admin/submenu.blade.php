@if ((count($menu->children) > 0) AND ($menu->parent_id > 0))
    <li>
        <a class="menu-item" href="{{ route('admin.'.$menu->slug) }}">
            <span data-i18n="">{{ $menu->name }}</span></a>
            @if(count($menu->children) > 0)

            @endif
        </a>
    </li>
@else
    <li class="@if(Route::current()->getName() == 'admin.'.$menu->slug) active @else nav-item @endif" @if($menu->parent_id === 0 && count($menu->children) > 0)@endif">
    <a href="@if($menu->parent_id === 0 && count($menu->children) === 0) {{ route('admin.'.$menu->slug) }} @endif @if($menu->parent_id != 0 && count($menu->children) === 0) {{ route('admin.'.$menu->slug) }} @endif">
            @if($menu->icon != '')
                <i class="{{ $menu->icon }}"></i>
            @endif
            <span class="menu-title" data-i18n="">
                {{ $menu->name }}
            </span></a>
            @if(count($menu->children) > 0)
            @endif
        </a>
        @endif
        @if (count($menu->children) > 0)
            <ul class="@if($menu->parent_id !== 0 && (count($menu->children) > 0)) menu-content @endif">
                @foreach($menu->children as $menu)
                    @include('admin.submenu', ['some' => 'data'])
                @endforeach
            </ul>
        @endif
    </li>

