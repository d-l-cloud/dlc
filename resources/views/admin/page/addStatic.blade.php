@extends('layouts.admin')
@if (!$staticPage->id)
    @section('title', '| Форма добавления страницы')
@else
    @section('title', '| Форма редактирования страницы')
@endif

@section('content')
<style>
    option:disabled {
        text-decoration: line-through;
    }
    </style>
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.list.index') }}">Список страниц</a>
                            </li>
                            @if (!$staticPage->id)
                                <li class="breadcrumb-item active">Форма добавления страницы</li>
                            @else
                                <li class="breadcrumb-item active">Форма редактирования страницы</li>
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
                                    @if (!$staticPage->id)
                                        <h2>Форма добавления страницы</h2>
                                    @else
                                        <h2>Форма редактирования страницы</h2>
                                    @endif
                                    <form method="POST" action="@if (!$staticPage->id){{ route('admin.list.store') }}@else{{ route('admin.list.update', $staticPage ?? '') }}@endif" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @if (!$staticPage->id)
                                            @method('POST')
                                        @else
                                            @method('PUT')
                                            <input type="hidden" name="image_old" value="@if(!$staticPage->image){{ 0 }}@else{{ 1 }}@endif">
                                        @endif
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Название страницы</label>
                                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $staticPage->title}}" data-validation-required-message="{{ __('This field is required') }}" required>
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
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $staticPage->description}}">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Keywords</label>
                                                            <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') ?? $staticPage->keywords}}">

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Привязать страницу к меню</label>

                                                            <select multiple size="7" name="menu_id[]" id="pageMenuId" class="form-control" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                <option value="1">Не привязывать к меню</option>
                                                                @if($categoriesTop->count())
                                                                    <optgroup label="Верхнее меню">
                                                                        @foreach($categoriesTop as $categoryTop)
                                                                            <option @if(collect(old('menu_id'))->contains($categoryTop->id) || $categoryTop->id == $staticPage->menu_id) selected @endif value="{{ $categoryTop->id }}" {{in_array($categoryTop->id, $getAllStaticPageMenuIdArray) ? 'disabled':''}}>{{ $categoryTop->name }}</option>
                                                                            @if($categoryTop->sub->count())
                                                                                @foreach($categoryTop->sub as $categoryTopSub)
                                                                                    <option @if(collect(old('menu_id'))->contains($categoryTopSub->id) || in_array($categoryTopSub->id, $getAllStaticPageMenuIdArray)) selected @endif value="{{ $categoryTopSub->id }}" {{in_array($categoryTopSub->id, $getAllStaticPageMenuIdArray) ? 'disabled':''}}>- {{ $categoryTopSub->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                                @if($categoriesBottom->count())
                                                                    <optgroup label="Нижнее меню">
                                                                        @foreach($categoriesBottom as $categoryBottom)
                                                                            <option @if(collect(old('menu_id'))->contains($categoryBottom->id) || $categoryBottom->id == $staticPage->menu_id) selected @endif value="{{ $categoryBottom->id }}" {{in_array($categoryBottom->id, $getAllStaticPageMenuIdArray) ? 'disabled':''}}>{{ $categoryBottom->name }} </option>
                                                                            @if($categoryBottom->sub->count())
                                                                                @foreach($categoryBottom->sub as $categoryBottomSub)
                                                                                    <option @if(collect(old('menu_id'))->contains($categoryBottomSub->id) || $categoryBottomSub->id == $staticPage->menu_id) selected @endif value="{{ $categoryBottomSub->id }}" {{in_array($categoryBottomSub->id, $getAllStaticPageMenuIdArray) ? 'disabled':''}}>- {{ $categoryBottomSub->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                            <p class="text-left"><small class="text-muted">Для выбора нескольких пунктов меню для одной страницы необходимо зажать Ctrl и выбирать левой кнопкой мыши</small></p>
                                                            <div class="help-block">
                                                                @if($errors->has('menu_id'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('menu_id') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="isHidden" value="0">
                                                            <input @if (old('isHidden') == 1 || $staticPage->isHidden == 1) checked @endif type="checkbox" class="form-check-input @error('isHidden') is-invalid @enderror" name="isHidden" value="1">
                                                            <label class="form-check-label" >Скрыть страницу от пользователей?</label>
                                                            <div class="help-block">
                                                                @if($errors->has('isHidden'))
                                                                    <div class="alert alert-danger" role="alert">
                                                                        @foreach($errors->get('isHidden') as $error)
                                                                            <span class="text-white">{{ $error }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">@if (!$staticPage->id) Добавить страницу @else Сохранить страницу @endif</button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="form-group">
                                                    <label>Содержание страницы</label>
                                                    <textarea class="form-control fulltext @error('text') is-invalid @enderror" name="text" rows="8">{{ old('text') ?? $staticPage->text }}</textarea>
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
        var editor_config = {
            image_class_list: [
                {title: 'Responsive', value: 'img-fluid img-thumbnail float-left'}
            ],
            height: 400,
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
@endsection
