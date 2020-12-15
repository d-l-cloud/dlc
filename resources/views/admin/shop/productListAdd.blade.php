@extends('layouts.admin')
@if (!$productList->id)
    @section('title', '| Форма добавления товара')
@else
    @section('title', '| Форма редактирования товара')
@endif

@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Список товаров</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Товары</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product-list.index') }}">Список товаров</a>
                            </li>
                            @if (!$productList->id)
                                <li class="breadcrumb-item active">Форма добавления товара</li>
                            @else
                                <li class="breadcrumb-item active">Форма редактирования товара</li>
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
                                    <ul class="nav nav-tabs nav-underline no-hover-bg">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="base-main" data-toggle="tab" aria-controls="main" href="#main" aria-expanded="true">Основное</a>
                                        </li>
                                        @if ($productList->id)
                                        <li class="nav-item">
                                            <a class="nav-link" id="base-property" data-toggle="tab" aria-controls="property" href="#property" aria-expanded="false">Свойства</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="base-photo" data-toggle="tab" aria-controls="photo" href="#photo" aria-expanded="false">Фото</a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="tab-content px-1 pt-1">
                                    @if (!$productList->id)
                                        <h2>Форма добавления товара</h2>
                                    @else
                                        <h2>Форма редактирования товара</h2>
                                    @endif
                                        <div role="tabpanel" class="tab-pane active" id="main" aria-expanded="true" aria-labelledby="base-main">
                                    <form method="POST" action="@if (!$productList->id){{ route('admin.product-list.store') }}@else{{ route('admin.product-list.update', $productList ?? '') }}@endif" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @if (!$productList->id)
                                            @method('POST')
                                            <input type="hidden" name="source" value="noDL">
                                        @else
                                            @method('PUT')
                                            <input type="hidden" name="image_old" value="@if(!$productList->image){{ 0 }}@else{{ 1 }}@endif">
                                            <input type="hidden" name="source" value="@if($productList->source=='noDL'){{ 'noDL' }}@else{{ 'DL' }}@endif">
                                        @endif
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Артикул</label>
                                                            <input type="text" id="article" onkeypress='validate(event)' name="article" class="form-control @error('article') is-invalid @enderror" value="{{ old('article') ?? $productList->article}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <div class="help-block">
                                                                @if($errors->has('article'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('article') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Родительский артикул для вариативных товаров</label>
                                                            <input type="text" id="parentArticle"  onkeypress='validate(event)' name="parentArticle" class="form-control @error('parentArticle') is-invalid @enderror" value="{{ old('parentArticle') ?? $productList->parentArticle}}">
                                                            <div class="help-block">
                                                                @if($errors->has('parentArticle'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('parentArticle') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Название товара</label>
                                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $productList->name}}" data-validation-required-message="{{ __('This field is required') }}" required>
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
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>ЧПУ товара</label>
                                                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $productList->slug}}" data-validation-required-message="{{ __('This field is required') }}" required>
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
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Производитель</label>
                                                            <select name="vendorCode" id="vendorCode" class="form-control @error('vendorCode') is-invalid @enderror" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                <option value="">Выбрать производителя</option>
                                                                @forelse($vendorList as $vendorList)
                                                                    <option @if($vendorList->id == old('vendorCode') || $vendorList->id == $productList->vendorCode) selected @endif value="{{ $vendorList->id }}">{{ $vendorList->name }}</option>
                                                                @empty
                                                                    <option value="0">Нет производителей</option>
                                                                @endforelse
                                                            </select>
                                                            <div class="help-block">
                                                                @if($errors->has('vendorCode'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('vendorCode') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Категория</label>
                                                            <select name="productCategoryId" id="productCategoryId" class="form-control @error('productCategoryId') is-invalid @enderror" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                <option value="">Выбрать категорию</option>
                                                                @forelse($catList as $catList)
                                                                    <optgroup label="{{ $catList->name }}">
                                                                        @if($catList->sub->count())
                                                                            @foreach($catList->sub as $catListSub)
                                                                                <option @if($catListSub->id == old('productCategoryId') || $catListSub->id == $productList->productCategoryId) selected @endif value="{{ $catListSub->id }}">{{ $catListSub->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </optgroup>
                                                                @empty
                                                                    <option value="0">Нет категорий</option>
                                                                @endforelse
                                                            </select>
                                                            <div class="help-block">
                                                                @if($errors->has('productCategoryId'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('productCategoryId') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Стоимость</label>
                                                            <input type="text" onkeypress='validate(event)' id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') ?? $productList->price}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                            <div class="help-block">
                                                                @if($errors->has('price'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('price') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="new" value="0">
                                                            <input @if (old('new') == 1 || $productList->new == 1) checked @endif type="checkbox" class="form-check-input @error('new') is-invalid @enderror" name="new" value="1">
                                                            <label class="form-check-label" >Новинка</label>
                                                            <div class="help-block">
                                                                @if($errors->has('new'))
                                                                    <ul role="alert">
                                                                        @foreach($errors->get('new') as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                            <input type="hidden" name="sale" value="0">
                                                            <input @if (old('sale') == 1 || $productList->sale == 1) checked @endif type="checkbox" class="form-check-input @error('sale') is-invalid @enderror" name="sale" value="1">
                                                            <label class="form-check-label" >Распродажа</label>
                                                            <div class="help-block">
                                                                @if($errors->has('sale'))
                                                                    <ul role="alert">
                                                                        @foreach($errors->get('sale') as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                            <input type="hidden" name="isHidden" value="0">
                                                            <input @if (old('isHidden') == 1 || $productList->isHidden == 1) checked @endif type="checkbox" class="form-check-input @error('isHidden') is-invalid @enderror" name="isHidden" value="1">
                                                            <label class="form-check-label" >Скрыть товар от пользователей?</label>
                                                            <div class="help-block">
                                                                @if($errors->has('isHidden'))
                                                                    <ul role="alert">
                                                                        @foreach($errors->get('isHidden') as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Описание</label>
                                                    <textarea class="form-control fulltext @error('text') is-invalid @enderror" name="text" rows="8">{{ old('text') ?? $productList->text }}</textarea>
                                                    <div class="help-block">
                                                        @if($errors->has('text'))
                                                            <div class="alert alert-danger" role="alert">
                                                                @foreach($errors->get('text') as $error)
                                                                    <span class="text-white">{{ $error }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $productList->description}}">

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Keywords</label>
                                                    <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') ?? $productList->keywords}}">

                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                  <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                                      <i class="la la-image"></i> Выбрать главное фото товара
                                                    </a>
                                                  </span>
                                                            <input id="thumbnail" name="images" class="form-control" type="text" name="filepath" value="{{ old('images') ?? $productList->images}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="holder" style="max-height:200px;">
                                                            @if(old('images'))
                                                                <img class="img-thumbnail img-fluid" src="{{ old('images')}}" style="height: 10rem;">
                                                            @endif
                                                            @if ($productList->id)
                                                                @if($productList->images)
                                                                    <img class="img-thumbnail img-fluid" src="{{ $productList->images }}" style="height: 10rem;">
                                                                @else
                                                                @endif
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <button type="submit" class="btn btn-primary">@if (!$productList->id) Добавить товар @else Сохранить товар @endif</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                        @if ($productList->id)
                                        <div class="tab-pane" id="property" aria-labelledby="base-property">
                                            <form method="POST" action="/cpa/shop/product-list-prop/{{$productList->id}}" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="source" value="@if($productList->source=='noDL'){{ 'noDL' }}@else{{ 'DL' }}@endif">
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                                    @if($propertyProductList)
                                                        @foreach($propertyProductList as $propertyProductList)
                                                        <div class="row propdiv">
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">

                                                                            <select name="productPropertyId[]" class="select2 form-control" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                                <option value="">Выбрать свойство</option>
                                                                                @forelse($propertyList as $propertyListItem)
                                                                                   <option @if($propertyListItem->id == old('productPropertyId') || $propertyListItem->id == $propertyProductList->propertyId) selected @endif value="{{ $propertyListItem->id }}">{{ $propertyListItem->name }}</option>
                                                                                @empty
                                                                                    <option value="0">Нет свойств</option>
                                                                                @endforelse
                                                                            </select>
                                                                            <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-12">
                                                                <div class="form-group">

                                                                    <input type="text" name="productPropertyValue[]" class="form-control" value="{{ old('productPropertyValue') ?? $propertyProductList->value}}" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <span class="col-lg-1 col-md-12">
                                                                <button class="btn btn-danger btndell" type="button"><i class="ft-x"></i></button>
                                                            </span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                <div class="addrow">

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-1">
                                                        <a href="#" class="btn btn-primary clickable-add">Добавить свойство</a>
                                                    </div>
                                                    <div class="col-md-6 mt-1 text-right">
                                                        <button type="submit" class="btn btn-primary">Сохранить свойства</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="photo" aria-labelledby="base-photo">
                                            <form method="POST" action="/cpa/shop/product-list-photo/{{$productList->id}}" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="source" value="@if($productList->source=='noDL'){{ 'noDL' }}@else{{ 'DL' }}@endif">
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                  <span class="input-group-btn">
                                                    <a id="lfmp" data-input="thumbnailp" data-preview="holderp" class="btn btn-primary text-white">
                                                      <i class="la la-image"></i> Выбрать фотографии для товара
                                                    </a>
                                                  </span>
                                                                <input id="thumbnailp" name="images" class="form-control" type="text" name="filepath" value="@if($findeProductPropId){{$findeProductPropId->value}}@endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div id="holderp" style="max-height:200px;">
                                                                    @if($findeProductPropId)
                                                                        @foreach(explode(', ', $findeProductPropId->value) as $info)
                                                                            <img class="img-thumbnail img-fluid" src="{{ $info }}" style="height: 10rem;">
                                                                        @endforeach
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-1">
                                                            <button type="submit" class="btn btn-primary">Сохранить фото</button>
                                                        </div>
                                                    </div>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/selects/select2.min.css') }}">
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
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection
@section('javascriptfb')
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script>
        var editor_config = {
            image_class_list: [
                {title: 'Responsive', value: 'img-fluid img-thumbnail float-left'}
            ],
            height: 500,
            language: 'ru',
            path_absolute : "/",
            selector: 'textarea.fulltext',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'Менеджер файлов',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };
        tinymce.init(editor_config);
    </script>
    <script>
        var route_prefix = "/filemanager";
    </script>
    <script>
        (function( $ ){

            $.fn.filemanager = function(type, options) {
                type = type || 'file';

                this.on('click', function(e) {
                    var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                    var target_input = $('#' + $(this).data('input'));
                    var target_preview = $('#' + $(this).data('preview'));
                    window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
                    window.SetUrl = function (items) {
                        var file_path = items.map(function (item) {
                            return item.url;
                        }).join(',');

                        // set the value of the desired input to image url
                        target_input.val('').val(file_path).trigger('change');

                        // clear previous preview
                        target_preview.html('');

                        // set or change the preview image src
                        items.forEach(function (item) {
                            target_preview.append(
                                $('<img class="img-thumbnail img-fluid">').css('height', '10rem').attr('src', item.thumb_url)
                            );
                        });

                        // trigger change event
                        target_preview.trigger('change');
                    };
                    return false;
                });
            }

        })(jQuery);

    </script>
    <script>
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>
    <script>
        $('#name').keyup(function(e) {
            $.get('{{ route('admin.news-category-ajax-slug') }}',
                { 'title': $(this).val() },
                function( data ) {
                    $('#slug').val(data.slug);
                }
            );
        });
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>

   <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
    </script>
    <script>
        (function( $ ){

            $.fn.filemanager = function(type, options) {
                type = type || 'file';

                this.on('click', function(e) {
                    var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                    var target_input = $('#' + $(this).data('input'));
                    var target_preview = $('#' + $(this).data('preview'));
                    window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
                    window.SetUrl = function (items) {
                        var file_path = items.map(function (item) {
                            return item.url;
                        }).join(', ');

                        // set the value of the desired input to image url
                        target_input.val('').val(file_path).trigger('change');

                        // clear previous preview
                        target_preview.html('');

                        // set or change the preview image src
                        items.forEach(function (item) {
                            target_preview.append(
                                $('<img class="img-thumbnail img-fluid">').css('height', '10rem').attr('src', item.thumb_url)
                            );
                        });

                        // trigger change event
                        target_preview.trigger('change');
                    };
                    return false;
                });
            }

        })(jQuery);

    </script>
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    @if ($productList->id)
    <script>
        $('#lfmp').filemanager('image', {prefix: route_prefix});
        $(document).on('click touchstart', '.clickable-add', function(e){
            $('.addrow').append('' +
                '<div class="row propdiv">' +
            '                    <div class="col-lg-6 col-md-12">' +
            '                        <div class="form-group">' +
            '                            <select name="productPropertyId[]" class="select2 form-control" data-validation-required-message="{{ __('This field is required') }}" required>' +
            '                                <option value="">Выбрать свойство</option>' +
            '                                @forelse($propertyList as $propertyListItem)' +
                '                                <option value="{{ $propertyListItem->id }}">{{ $propertyListItem->name }}</option>' +
            '                                @empty' +
                '                                <option value="0">Нет свойств</option>' +
            '                                @endforelse' +
                '                            </select>' +
            '                            <div class="help-block"></div>' +
            '                        </div>' +
            '                    </div>' +
            '                    <div class="col-lg-5 col-md-12">' +
            '                        <div class="form-group">' +
            '                            <input type="text" name="productPropertyValue[]" class="form-control" value="" data-validation-required-message="{{ __('This field is required') }}" required>' +
            '                                <div class="help-block"></div>' +
            '                        </div>' +
            '                    </div>' +
            '                    <span class="col-lg-1 col-md-12">' +
            '                                                                <button class="btn btn-danger btndell" type="button"><i class="ft-x"></i></button>' +
            '                                                            </span>' +
            '                </div>');
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();

            // Square Checkbox & Radio
            $('.skin-square input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Touch Spin
            $(".touchspin").TouchSpin();

            // Bootstrap Switch
            $(".switchBootstrap").bootstrapSwitch();

            var i = 0;
            if (Array.prototype.forEach) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));

                elems.forEach(function (html) {
                    var switchery = new Switchery(html);
                });
            } else {
                var elems1 = document.querySelectorAll('.switchery');

                for (i = 0; i < elems1.length; i++) {
                    var switchery = new Switchery(elems1[i]);
                }
            }

        });
        $(document).on('click', '.btndell', function(e){
            $(e.target).closest(".propdiv").remove();
        });
    </script>
    @endif
@endsection
