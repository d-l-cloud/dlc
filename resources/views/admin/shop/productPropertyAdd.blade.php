@extends('layouts.admin')
@if (!$property->id)
    @section('title', '| Форма добавления свойства')
@else
    @section('title', '| Форма редактирования свойства')
@endif

@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Список свойств товаров</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Товары</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product-properties.index') }}">Список свойств товаров</a>
                            </li>
                            @if (!$property->id)
                                <li class="breadcrumb-item active">Форма добавления свойства</li>
                            @else
                                <li class="breadcrumb-item active">Форма редактирования свойства</li>
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
                                    @if (!$property->id)
                                        <h2>Форма добавления свойства</h2>
                                    @else
                                        <h2>Форма редактирования свойства</h2>
                                    @endif
                                    <form method="POST" action="@if (!$property->id){{ route('admin.product-properties.store') }}@else{{ route('admin.product-properties.update', $property ?? '') }}@endif" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @if (!$property->id)
                                            @method('POST')
                                            <input type="hidden" name="source" value="noDL">
                                        @else
                                            @method('PUT')
                                            <input type="hidden" name="source" value="@if($property->source=='noDL'){{ 'noDL' }}@else{{ 'DL' }}@endif">
                                        @endif
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>Название свойства</label>
                                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $property->name}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                    <div class="help-block">
                                                        @if($errors->has('name'))
                                                            <div class="alert alert-danger" role="alert">
                                                                @foreach($errors->get('name') as $error)
                                                                    <span class="text-white">{{ $error }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>ЧПУ свойства</label>
                                                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $property->slug}}" data-validation-required-message="{{ __('This field is required') }}" required>
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
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <label>Свойства уже есть на сайте</label>
                                                    <div id="similarProperty"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">@if (!$property->id) Добавить свойство @else Сохранить свойство @endif</button>
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
        $('#name').keyup(function(e) {
            $.get('{{ route('admin.news-category-ajax-slug') }}',
                { 'title': $(this).val() },
                function( data ) {
                    $('#slug').val(data.slug);
                }
            );
        });
        $('#name').keyup(function(e) {
            $.get('{{ route('admin.product-properties-ajax-similar') }}',
                { 'title': $(this).val() },
                function( data ) {
                    document.getElementById("similarProperty").innerHTML = data.similar;
                }
            );
        });
    </script>
@endsection
