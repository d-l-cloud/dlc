@extends('layouts.admin')
@section('title', '| Список статических страниц сайта ')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Статические страницы</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Статические страницы</a>
                            </li>
                            <li class="breadcrumb-item active">Список страниц
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Configuration option table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" id="success-alert" style="display: none;">
                                        <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>{{ __('SuccessAlert') }}!</strong>
                                        {{ __('SuccessAlertText') }}
                                    </div>
                                    @if(Session::has('success'))
                                        <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                            <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <strong>Отлично!</strong> {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if(Session::has('warning'))
                                        <div class="alert bg-warning alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                            <span class="alert-icon"><i class="ft ft-alert-triangle"></i></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <strong>Внимание!</strong> {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                    @if(Session::has('delete'))
                                        <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                            <span class="alert-icon"><i class="ft ft-alert-octagon"></i></span>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <strong>Отлично!</strong> {{ Session::get('delete') }}
                                        </div>
                                    @endif
                                    <p class="card-text">
                                        <a href="{{ route('admin.list.create') }}" class="btn btn-social btn-block mb-1 btn-vimeo" title="Добавить новость"><span class="la la-plus"></span> Добавить страницу</a>
                                    </p>
                                    <table class="table table-striped table-bordered dataex-res-configuration" id="blockArea">
                                        <thead>
                                        <tr>
                                            <th>Дата редактирования</th>
                                            <th>Название</th>
                                            <th>Меню</th>
                                            <th>Кто добавил</th>
                                            <th>Просмотров</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Дата редактирования</th>
                                            <th>Название</th>
                                            <th>Меню</th>
                                            <th>Кто добавил</th>
                                            <th>Просмотров</th>
                                            <th>Действия</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @forelse($staticPage as $item)
                                            <tr id="sid{{ $item->id }}">
                                                <th scope="row">{{ $item->updated_at }} </th>
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    @forelse($item->siteStaticPagesMenus as $menuIdItem)
                                                        <span class="badge border-info info badge-border">{{ $getAllMenuName->find($menuIdItem->menuId)->name }}</span>
                                                        @empty
                                                    @endforelse
                                                </td>
                                                <td>{{ $item->user->name }} {{ $item->user->surname }}</td>
                                                <td>{{ $item->views }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="First Group">
                                                        <a href="{{ route('admin.list.edit', $item) }}" class="btn btn-icon btn-success text-white" title="Редактировать"><i class="la la-edit"></i></a>
                                                        <button id="fieldHidden" href="javascript:void(0)" onclick="editHidden({{$item->id}})" class="btn btn-icon btn-info text-white" newsId="{{$item->id}}" @if ($item->isHidden) title="Показать" @else title="Скрыть"@endif><span id="eye{{$item->id}}">@if ($item->isHidden) <i  class="la la-eye"></i> @else<i  class="la la-eye-slash"></i>@endif</span></button>
                                                        {!! Form::open(['method' => 'DELETE','route' => ['admin.list.destroy', $item]]) !!}
                                                        {!! Form::submit('Удалить', ['class' => 'btn btn-icon btn-danger text-white', 'onclick'=> 'return confirm(\'Вы действительно хотите удалить Страницу?\')']) !!}
                                                        {!! Form::close() !!}
                                                        <div id="text{{$item->id}}"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="col-md-12">
                                                <p>Страниц нет</p>
                                            </div>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
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
            console.log('click click');
        }
        window.onload = function () {
            let buttons = document.querySelectorAll('#fieldHidden');
            buttons.forEach((elem) => {
                elem.addEventListener('click', () => {
                    let newsId = elem.getAttribute('newsId');
                    let hiddenStatus = elem.getAttribute('hiddenStatus');

                    $.ajax({
                        type: "POST",
                        url: '{{ route('admin.list-hidden-ajax-update') }}',
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
