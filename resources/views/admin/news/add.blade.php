@extends('layouts.admin')
@if (!$news->id)
    @section('title', '| Форма добавления новости')
@else
    @section('title', '| Форма редактирования новости')
@endif

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.news-list.index') }}">Список новостей</a>
                            </li>
                            @if (!$news->id)
                                <li class="breadcrumb-item active">Форма добавления новости</li>
                            @else
                                <li class="breadcrumb-item active">Форма редактирования новости</li>
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
                                    @if (!$news->id)
                                        <h2>Форма добавления новости</h2>
                                    @else
                                        <h2>Форма редактирования новости</h2>
                                    @endif
                                    <form method="POST" action="@if (!$news->id){{ route('admin.news-list.store') }}@else{{ route('admin.news-list.update', $news ?? '') }}@endif" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        @if (!$news->id)
                                            @method('POST')
                                        @else
                                            @method('PUT')
                                            <input type="hidden" name="image_old" value="@if(!$news->image){{ 0 }}@else{{ 1 }}@endif">
                                        @endif
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Заголовок новости</label>
                                                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $news->title}}" data-validation-required-message="{{ __('This field is required') }}" required>
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
                                                            <label>Категория новости</label>
                                                            <select name="category_id" id="newsCategory" class="form-control @error('category_id') is-invalid @enderror" data-validation-required-message="{{ __('This field is required') }}" required>
                                                                <option value="">Выберете категорию</option>
                                                                @forelse($categories as $item)
                                                                    <option @if($item->id == old('category_id') || $item->id == $news->category_id) selected @endif value="{{ $item->id }}">{{ $item->title }}</option>
                                                                @empty
                                                                    <option value="0">Нет категорий</option>
                                                                @endforelse
                                                            </select>
                                                                <div class="help-block">
                                                                    @if($errors->has('category_id'))
                                                                        <ul role="alert">
                                                                            @foreach($errors->get('category_id') as $error)
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
                                                    <label>Анонс новости</label>
                                                    <textarea class="form-control @error('preview') is-invalid @enderror" name="preview" rows="6" data-validation-required-message="{{ __('This field is required') }}" required>{{ old('preview') ?? $news->preview }}</textarea>
                                                    <div class="help-block">
                                                        @if($errors->has('preview'))
                                                            <div class="alert alert-danger" role="alert">
                                                                @foreach($errors->get('preview') as $error)
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
                                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $news->description}}">

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Keywords</label>
                                                    <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') ?? $news->keywords}}">

                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>Текст новости</label>
                                                    <textarea class="form-control fulltext @error('text') is-invalid @enderror" name="text" rows="8">{{ old('text') ?? $news->text }}</textarea>
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
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                  <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                                      <i class="la la-image"></i> Выбрать фото для анонса
                                                    </a>
                                                  </span>
                                                            <input id="thumbnail" name="image" class="form-control" type="text" name="filepath" value="{{ old('image') ?? $news->image}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="holder" style="max-height:200px;">
                                                            @if(old('image'))
                                                            <img class="img-thumbnail img-fluid" src="{{ old('image')}}" style="height: 10rem;">
                                                            @endif
                                                                @if ($news->id)
                                                                    @if($news->image)
                                                                    <img class="img-thumbnail img-fluid" src="{{ $news->image }}" style="height: 10rem;">
                                                                    @else
                                                                    @endif
                                                                @else
                                                                @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-check">
                                                    <input type="hidden" name="isHidden" value="0">
                                                    <input @if (old('isHidden') == 1 || $news->isHidden == 1) checked @endif type="checkbox" class="form-check-input @error('isHidden') is-invalid @enderror" name="isHidden" value="1">
                                                    <label class="form-check-label" >Скрыть новость от пользователей?</label>
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
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">@if (!$news->id) Добавить новость @else Сохранить новость @endif</button>
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
@endsection
