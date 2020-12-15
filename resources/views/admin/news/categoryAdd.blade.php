@extends('layouts.admin')
@if (!$category->id)
    @section('title', '| Форма добавления категории')
@else
    @section('title', '| Форма редактирования категории')
@endif

@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Список категорий</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Новости</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.news-categories.index') }}">Категории новостей</a>
                            </li>
                            @if (!$category->id)
                                <li class="breadcrumb-item active">Форма добавления категории</li>
                            @else
                                <li class="breadcrumb-item active">Форма редактирования категории</li>
                            @endif
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
                                    @if (!$category->id)
                                        <h2>Форма добавления категории</h2>
                                    @else
                                        <h2>Форма редактирования категории</h2>
                                    @endif
                                    <form method="POST" action="@if (!$category->id){{ route('admin.news-categories.store') }}@else{{ route('admin.news-categories.update', $category ?? '') }}@endif" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @if (!$category->id)
                                            @method('POST')
                                        @else
                                            @method('PUT')
                                        @endif
                                        <div class="row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>Заголовок категории</label>
                                                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $category->title}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <div class="help-block">
                                                                @if($errors->has('title'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('title') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>ЧПУ категории</label>
                                                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $category->slug}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <div class="help-block">
                                                                @if($errors->has('slug'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('slug') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">@if (!$category->id) Добавить категорию @else Сохранить категорию @endif</button>
                                            </div>
                                        </div>
                                    </form>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
@endsection
@section('csstb')
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/css/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/css/plugins/forms/switch.css') }}">
    <script src="https://cdn.tiny.cloud/1/mz7qzfuil56pc60lx3eo8swmbjgodpcj7i913beymjqyoqup/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('javascriptft')
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
@endsection
@section('javascriptfb')
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script>
        $('#title').keyup(function(e) {
            $.get('{{ route('admin.news-category-ajax-slug') }}',
                { 'title': $(this).val() },
                function( data ) {
                    $('#slug').val(data.slug);
                }
            );
        });
    </script>
@endsection
