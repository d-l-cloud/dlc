@extends('layouts.admin')
@section('title', '| Настройка меню сайта ')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Настройка меню</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Настройки</a>
                            </li>
                            <li class="breadcrumb-item active">Меню сайта
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
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.settings.menuAdd') }}" class="btn btn-social btn-block mb-1 btn-vimeo" title="Добавить новость"><span class="la la-plus"></span> Добавить пункт меню</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card" id="blockAreaTopMenu">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">Верхнее меню</h4>
                                </div>
                                <ul class="list-group list-group-flush" id="blockAreaTopMenuHtml">
                                    @if($categoriesTop->count())
                                            @foreach($categoriesTop as $categoryTop)
                                            <li class="list-group-item">
                                                {{ $categoryTop->name }} |
                                                <i class="fas fa-sort-numeric-down"></i>
                                                <select id="selectId{{ $categoryTop->id }}" onchange="changeEventHandler({{ $categoryTop->id }});">
                                                    @for ($i = 1; $i <= count($categoriesTop); $i++)
                                                        <option @if($i == $categoryTop->sorting) selected @endif value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <a href="javascript:void(0)" onclick="deleteMenu({{$categoryTop->id}})"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>
                                            </li>
                                                @if($categoryTop->sub->count())
                                                    @foreach($categoryTop->sub as $categoryTopSub)
                                                    <li class="list-group-item" id="menuId{{$categoryTopSub->id}}">
                                                        <i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i> {{ $categoryTopSub->name }} |
                                                       <i class="fas fa-sort-numeric-down"></i>
                                                        <select id="selectId{{ $categoryTopSub->id }}" onchange="changeEventHandler({{ $categoryTopSub->id }});">
                                                            @for ($i = 1; $i <= count($categoryTop->sub); $i++)
                                                                <option @if($i == $categoryTopSub->sorting) selected @endif value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        <a href="javascript:void(0)" onclick="deleteMenu({{$categoryTopSub->id}})"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>
                                                    </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card" id="blockAreaBottomMenu">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">Нижнее меню</h4>
                                </div>
                                <ul class="list-group list-group-flush" id="blockAreaBottomMenuHtml">
                                    @if($categoriesBottom->count())
                                        @foreach($categoriesBottom as $categoryBottom)
                                            <li class="list-group-item">
                                                {{ $categoryBottom->name }} |
                                                <i class="fas fa-sort-numeric-down"></i>
                                                <select id="selectId{{ $categoryBottom->id }}" onchange="changeEventHandler({{ $categoryBottom->id }});">

                                                    @for ($i = 1; $i <= count($categoriesBottom); $i++)
                                                        <option @if($i == $categoryBottom->sorting) selected @endif value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <a href="javascript:void(0)" onclick="deleteMenu({{$categoryBottom->id}})"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>
                                            </li>
                                            @if($categoryBottom->sub->count())
                                                @foreach($categoryBottom->sub as $categoryBottomSub)
                                                    <li class="list-group-item" id="menuId{{$categoryBottomSub->id}}">
                                                        <i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i> {{ $categoryBottomSub->name }} |
                                                        <i class="fas fa-sort-numeric-down"></i>
                                                        <select id="selectId{{ $categoryBottomSub->id }}" onchange="changeEventHandler({{ $categoryBottomSub->id }});">
                                                            @for ($i = 1; $i <= count($categoryBottomSub->sub); $i++)
                                                                <option @if($i == $categoryBottomSub->sorting) selected @endif value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        <a href="javascript:void(0)" onclick="deleteMenu({{$categoryBottomSub->id}})"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                    </optgroup>
                                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection
@section('csstt')
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTemplate/app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endsection
@section('javascriptft')
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/extensions/polyfill.min.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection
@section('javascriptfb')
    <script>
            function deleteMenu(id) {
                let returnResult = confirm("Вы действительно хотите удалить пункт меню? Операция не возвратная.");
                if (returnResult) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.settings.menu-delete-ajax') }}',
                    dataType: "json",
                    data: {
                        menuId: id,
                        _token: '{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).block({
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
                        $(block_Bottom).block({
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
                    success: function (response) {
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).unblock();
                        $(block_Bottom).unblock();
                        let menuOption;
                        let sortingSet;
                        let arrayCount = 0;
                        let menuHtmlWrapper = $('#blockAreaTopMenuHtml');
                        menuHtmlWrapper.empty();
                        menuHtmlWrapper.append('<ul class="list-group list-group-flush" id="blockAreaTopMenuHtml">');
                        $.each(response.menu, function (key, value) {
                            arrayCount++;
                        });
                        $.each(response.menu, function (key, value) {
                            for (i = 1; i <= arrayCount; i++) {
                                if(value.sorting==i) {
                                    sortingSet = 'selected';
                                }else{
                                    sortingSet = '';
                                }
                                menuOption = menuOption + '<option ' + sortingSet + ' value="' + i + '">' + i + '</option>';
                            }
                            menuHtmlWrapper.append('' +
                                '<li class="list-group-item">' +
                                '' + value.name + ' | <i class="fas fa-sort-numeric-down"></i> ' +
                                '<select id="selectId' + value.id + '" onchange="changeEventHandler(' + value.id + ');">' +
                                '' + menuOption + '' +
                                '</select>' +
                                '' +
                                '<a href="javascript:void(0)" onclick="deleteMenu(' + value.id + ')"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>' +
                                '</li>');
                            menuOption = '';
                            let objectKeys = Object.keys(value.sub)
                            if (objectKeys.length > 0) {
                                $.each(value.sub, function (key, value) {
                                    menuHtmlWrapper.append('' +
                                        '<li class="list-group-item">' +
                                        '- ' + value.name + '' +
                                        '<a href="javascript:void(0)" onclick="deleteMenu(' + value.id + ')"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>' +
                                        '</li>');
                                });
                            }
                        });
                        menuHtmlWrapper.append('</ul>');
                    },
                    error: function (jqXHR, status, error) {
                        var errorObj = jqXHR.responseJSON;
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).unblock();
                        $(block_Bottom).unblock();
                        Swal.fire({
                            title: "Произошла ошибка при удалении пункта меню",
                            text: errorObj.mes,
                            type: "error",
                            confirmButtonText: 'Закрыть',
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    },
                });
            }
            }
            function changeEventHandler(id) {
                let menuID = id;
                let menuSorting = $('#selectId' + id + ' option:selected').text();
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.settings.menu-sorting-ajax') }}',
                    dataType: "json",
                    data: {
                        menuId: id,
                        menuSorting: menuSorting,
                        _token: '{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).block({
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
                        $(block_Bottom).block({
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
                    success: function (response) {
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).unblock();
                        $(block_Bottom).unblock();
                        let menuHtmlWrapper = $('#blockAreaTopMenuHtml');
                        let menuOption;
                        let sortingSet;
                        let arrayCount = 0;
                        menuHtmlWrapper.empty();
                        menuHtmlWrapper.append('<ul class="list-group list-group-flush" id="blockAreaTopMenuHtml">');
                        $.each(response.menuTop, function (key, value) {
                            arrayCount++;
                        });
                        $.each(response.menuTop, function (key, value) {
                            for (i = 1; i <= arrayCount; i++) {
                                if(value.sorting==i) {
                                    sortingSet = 'selected';
                                }else{
                                    sortingSet = '';
                                }
                                menuOption = menuOption + '<option ' + sortingSet + ' value="' + i + '">' + i + '</option>';
                            }
                            menuHtmlWrapper.append('' +
                                '<li class="list-group-item">' +
                                '' + value.name + ' | <i class="fas fa-sort-numeric-down"></i> ' +
                                '<select id="selectId' + value.id + '" onchange="changeEventHandler(' + value.id + ');">' +
                                '' + menuOption + '' +
                                '</select>' +
                                '' +
                                '<a href="javascript:void(0)" onclick="deleteMenu(' + value.id + ')"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>' +
                                '</li>');
                            menuOption = '';

                            /*let objectKeys = Object.keys(value.sub)
                            if (objectKeys.length > 0) {
                                $.each(value.sub, function (key, value) {
                                    for (i = 1; i <= objectKeys.length; i++) {
                                        if(value.sorting==i) {
                                            sortingSet = 'selected';
                                        }else{
                                            sortingSet = '';
                                        }
                                        menuOption = menuOption + '<option ' + sortingSet + ' value="' + i + '">' + i + '</option>';
                                    }
                                    menuHtmlWrapper.append('' +
                                        '<li class="list-group-item">' +
                                        '<i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i> ' + value.name + ' | <i class="fas fa-sort-numeric-down"></i> ' +
                                        '<select id="selectId' + value.id + '" onchange="changeEventHandler(' + value.id + ');">' +
                                        '' + menuOption + '' +
                                        '</select>' +
                                        '' +
                                        '<a href="javascript:void(0)" onclick="deleteMenu(' + value.id + ')"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>' +
                                        '</li>');
                                    menuOption = '';
                                });
                            }*/
                        });
                        menuHtmlWrapper.append('</ul>');

                        let menuHtmlWrapperBottom = $('#blockAreaBottomMenuHtml');
                        let menuOptionBottom;
                        let sortingSetBottom;
                        let arrayCountBottom = 0;
                        menuHtmlWrapperBottom.empty();
                        menuHtmlWrapperBottom.append('<ul class="list-group list-group-flush" id="blockAreaBottomMenuHtml">');
                        $.each(response.menuBottom, function (key, value) {
                            arrayCountBottom++;
                        });
                        $.each(response.menuBottom, function (key, value) {
                                for (i = 1; i <= arrayCountBottom; i++) {
                                    if(value.sorting==i) {
                                        sortingSetBottom = 'selected';
                                    }else{
                                        sortingSetBottom = '';
                                    }
                                    menuOptionBottom = menuOptionBottom + '<option ' + sortingSetBottom + ' value="' + i + '">' + i + '</option>';
                                }
                            menuHtmlWrapperBottom.append('' +
                                    '<li class="list-group-item">' +
                                    '' + value.name + ' | <i class="fas fa-sort-numeric-down"></i> ' +
                                    '<select id="selectId' + value.id + '" onchange="changeEventHandler(' + value.id + ');">' +
                                    '' + menuOptionBottom + '' +
                                    '</select>' +
                                    '' +
                                    '<a href="javascript:void(0)" onclick="deleteMenu(' + value.id + ')"><span class="badge border-danger danger badge-border float-right" title="Удалить пункт меню"><i class="far fa-trash-alt"></i> </span></a>' +
                                    '</li>');
                            menuOptionBottom = '';
                        });
                        menuHtmlWrapperBottom.append('</ul>');
                    },
                    error: function (jqXHR, status, error) {
                        var errorObj = jqXHR.responseJSON;
                        let block_Top = $("#blockAreaTopMenu");
                        let block_Bottom = $("#blockAreaBottomMenu");
                        $(block_Top).unblock();
                        $(block_Bottom).unblock();
                        Swal.fire({
                            title: "Произошла ошибка при удалении пункта меню",
                            text: errorObj.mes,
                            type: "error",
                            confirmButtonText: 'Закрыть',
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    },
                });

            }

    </script>
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <script src="{{ asset('adminTemplate/app-assets/js/scripts/modal/components-modal.js') }}"></script>
@endsection
