@extends('layouts.main')
@section('title') | Результаты поиска по запросу - {{ $page['title'] }}@endsection
@section('content')

    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">Поиск</div></div>
    <div hidden style="display:none">
    </div>


    <article>
        <div class="search">
            <h1 class="section-header">Результаты поиска по запросу: "{{ $page['title'] }}"</h1>

            <div class="search-wrap">
                @forelse($query as $item)
                    <div class="item item-in-catalog">
                        <div class="item-img">
                            <div class="item-img__more">
                                <div class="item-more__tools">
                                    <div class="item-number">
                                        Арт: {{ $item->article }}
                                    </div>
                                </div>
                            </div>
                            <a class="img-link" href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/">
                                @if ($item->images)
                                <img src="{{ $item->images }}" alt="{{ $item->name }}" style="max-height:290px;max-width:290px;">
                                @else
                                    <img src="/templates/img/foto_not_found.jpg" alt="{{ $item->name }}" style="max-height:290px;max-width:290px;">
                                @endif
                            </a>
                        </div>
                        <div class="item-price">
                            <div class="item-price__current">{{ number_format($item->price, 0, '',' ') }} руб.</div>
                        </div>
                        <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-description">{{ $item->name }}</a>
                        <div class="item-buy" >
                            <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-buy__btn js_add_to_cart js_product_list">Перейти</a>
                        </div>
                        @if (Helper::variable($item->parentArticle) > 0)
                            <a href="{!! Helper::searchUrl($item->productCategoryId) !!}{{ $item->article }}/" class="item-variants">Еще {!! Helper::variable($item->parentArticle) !!} {{ Lang::choice('вариант|варианта|вариантов', Helper::variable($item->parentArticle), [], 'ru') }}</a>
                        @else
                        @endif
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>Нет результатов по данному запросу</p>
                    </div>
                @endforelse
                        {{ $query->links() }}
                    </div>


            </div>
        </div>
    </article>

    </article>
@endsection
@section('csstt')
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css') }}">
@endsection
@section('javascriptft')
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/tables/datatable/dataTables.fixedHeader.min.js') }}"></script>
@endsection
@section('javascriptfb')
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/tables/datatables-extensions/datatable-responsive.js') }}"></script>

    <script>
        function editHidden(id)
        {
            $.get('/cpa/news/news-hidden-ajax/'+id, function (fieldHidden){

            })
        }
        window.onload = function () {
            let buttons = document.querySelectorAll('#fieldHidden');
            buttons.forEach((elem) => {
                elem.addEventListener('click', () => {
                    let newsId = elem.getAttribute('newsId');
                    let hiddenStatus = elem.getAttribute('hiddenStatus');

                    $.ajax({
                        type: "POST",
                        url: '{{ route('admin.news-hidden-ajax-update') }}',
                        dataType: "json",
                        data: {
                            newsId: newsId,
                            _token: '{{csrf_token()}}'
                        },
                        beforeSend: function() {
                            var block_ele =  $("#blockArea");
                            $(block_ele).block({
                                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                                overlayCSS: {
                                    backgroundColor: "#fff",
                                    opacity: 0.8,
                                    cursor: "wait"
                                },
                                css: {
                                    border: 0,
                                    padding: 0,
                                    backgroundColor: "transparent"
                                }
                            });
                        },
                        success: function (data) {
                            var block_ele =  $("#blockArea");
                            $(block_ele).unblock();
                            $('#eye'+newsId).empty()
                            if (data.isHidden==0) {
                                $('#eye' + newsId).append("<i class=\"la la-eye-slash\"></i>")
                            }else {
                                $('#eye' + newsId).append("<i class=\"la la-eye\"></i>")
                            }
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#success-alert").slideUp(500);
                            });
                        },
                        error: function (data, textStatus, errorThrown) {
                        },
                    });
                })
            });
        }
    </script>
@endsection
