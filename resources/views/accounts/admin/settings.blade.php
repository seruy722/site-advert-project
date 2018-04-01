@extends('layouts.app')
@section('userControlMenu')
    @include('layouts.userControlMenu')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="{{ route('accounts.user.update') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Имя</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" placeholder="Имя" value="{{ $user->name }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                        <label for="surname" class="col-md-4 control-label">Фамилия</label>

                        <div class="col-md-6">
                            <input id="surname" type="text" class="form-control" name="surname" placeholder="Фамилия" value="{{ $user->surname }}" required autofocus>

                            @if ($errors->has('surname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('surname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Телефон</label>

                        <div class="col-md-6">
                            <input id="surname" type="text" class="form-control" name="phone" value="{{ $user->phone }}" required autofocus placeholder="0961214565">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" placeholder="post@ya.ru" value="{{ $user->email }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Пароль</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Повторить пароль</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                <input type="hidden" name="id" value="{{Auth::id()}}">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                               Сохранить
                            </button>
                        </div>
                    </div>
                </form>
                {{-- <a href="{{route('accounts.admin.home',Auth::id())}}" class="btn btn-danger">Отменить</a> --}}
        </div>
    </div>
</div>
@endsection