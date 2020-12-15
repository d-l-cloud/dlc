@extends('layouts.main')

@section('content')
    <div class="breadcrumps" itemscope="" itemtype="http://schema.org/BreadcrumbList"><a class="breadcrumps-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" href="/">Главная</a><div class="breadcrumps-item breadcrumps-current" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">Вход в систему</div></div>
    <article>
    <div class="contacts">
            <div class="contacts-wrap">
                <div class="page-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                   {{-- <a href="{{ route('socLogin', ['provider' => 'vkontakte']) }}">ВК</a>
                                    <a href="{{ route('socLogin', ['provider' => 'odnoklassniki']) }}">ok</a>
                                    <a href="{{ route('socLogin', ['provider' => 'yandex']) }}">yandex</a>
                                    <a href="{{ route('socLogin', ['provider' => 'facebook']) }}">FB</a>
                                    <a href="{{ route('socLogin', ['provider' => 'github']) }}">GitHub</a>
                                    <a href="{{ route('socLogin', ['provider' => 'microsoft']) }}">Microsoft</a>--}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</div>
    </article>
@endsection
