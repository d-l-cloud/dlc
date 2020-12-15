@extends('layouts.main')
@section('title') {{ $getPagesData['title'] }} | @endsection
@section('content')

    <div class="breadcrumps" itemscope itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" href="/">Главная</a><div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{{ $getPagesData['title'] }}</div></div>
    <article>
        <div class="news-detail">
        <div class="news-detail-wrap">
            <h1 class="section-header">{{ $getPagesData['title'] }}</h1>

            <div class="singlepage-textblock">
                {!! $getPagesData['text'] !!}
            </div>


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
