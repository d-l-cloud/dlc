@extends('layouts.admin')
@section('title', '| Список категорий')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Список новостей</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Новости</a>
                            </li>
                            <li class="breadcrumb-item active">Категории новостей
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
                                        <a href="{{ route('admin.news-categories.create') }}" class="btn btn-social btn-block mb-1 btn-vimeo" title="Добавить категорию"><span class="la la-plus"></span> Добавить категорию</a>
                                    </p>
                                    <table class="table table-striped table-bordered dataex-res-configuration">
                                        <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Название</th>
                                            <th>ЧПУ</th>
                                            <th>Новостей в категории</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Название</th>
                                            <th>ЧПУ</th>
                                            <th>Новостей в категории</th>
                                            <th>Действия</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @forelse($category as $item)
                                            <tr id="sid{{ $item->id }}">
                                                <th scope="row">{{ $item->created_at }} </th>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->slug }}</td>
                                                <td>{{ count($item->news) }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="First Group">
                                                        <a href="{{ route('admin.news-categories.edit', $item) }}" class="btn btn-icon btn-success text-white" title="Редактировать"><i class="la la-edit"></i></a>
                                                        {!! Form::open(['method' => 'DELETE','route' => ['admin.news-categories.destroy', $item]]) !!}
                                                        {!! Form::submit('Удалить', ['class' => 'btn btn-icon btn-danger text-white', 'onclick'=> 'return confirm(\'Вы действительно хотите удалить категорию? В месте с категорией будут удалены все связанные новости, операция не возвратная.\')']) !!}
                                                        {!! Form::close() !!}
                                                        <div id="text{{$item->id}}"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="col-md-12">
                                                <p>Новостей нет</p>
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
@endsection
