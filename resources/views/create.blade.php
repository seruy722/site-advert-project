
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Auth::user()->blocked==false)
            <form action="{{ route('add') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="exampleFormControlInput0">Заголовок<span class="stars">*</span></label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput0" value="{{ old('title') }}" required autofocus placeholder="Заголовок">
                    @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('rubric') ? ' has-error' : '' }}">
                    <label>Рубрика<span class="stars">*</span></label>
                    <select class="form-control" name="rubric" required>
                        <option value="">Не выбрано</option>
                        @foreach ($rubrics as $item)
                    <option value="{{ $item }}" {{old('rubric')==$item?'selected':''}}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('rubric'))
                    <span class="help-block">
                        <strong>{{ $errors->first('rubric') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                        <label>Цена<span class="stars">*</span></label>
                    <input type="text" name="price" class="form-control" id="exampleFormControlInput5" value="{{ old('price') }}" required autofocus>
                        @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                        @endif
                    </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="exampleFormControlTextarea1">Описание<span class="stars">*</span></label>
                    <textarea name="description" id="exampleFormControlTextarea1" class="form-control" cols="30" rows="10" required autofocus>{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
                <label>Фотографии</label>
                {{-- <div class="form-group {{ $errors->has('image_names') ? ' has-error' : '' }}">
                    <input type="file" name="image_names[]" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="form-group {{ $errors->has('image_names') ? ' has-error' : '' }}">
                    <input type="file" name="image_names[]" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="form-group {{ $errors->has('image_names') ? ' has-error' : '' }}">
                <input type="file" name="image_names[]" class="form-control-file" id="exampleFormControlFile1" value="{{old('image_names')}}">
                </div>
                <div class="form-group {{ $errors->has('image_names') ? ' has-error' : '' }}">
                    <input type="file" name="image_names[]" class="form-control-file" id="exampleFormControlFile1">
                </div> --}}
                <div class="form-group {{ $errors->has('image_names') ? ' has-error' : '' }}">
                    <input type="file" name="image_names[]" class="form-control-file" id="exampleFormControlFile1" multiple>
                    @if ($errors->has('image_names'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image_names') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('region') ? ' has-error' : '' }}">
                    <label for="exampleFormControlInput1">Местоположение<span class="stars">*</span></label>
                    <input type="text" name="region" class="form-control" id="exampleFormControlInput1" value="{{ old('region') }}" required autofocus>
                    @if ($errors->has('region'))
                    <span class="help-block">
                        <strong>{{ $errors->first('region') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="exampleFormControlInput2">Номер телефона</label>
                    <input type="text" name="phone" class="form-control" id="exampleFormControlInput2" value="{{old('phone')?old('phone'):Auth::user()->phone}}" required autofocus>
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput3">Email-адрес</label>
                    <input type="text" name="email" class="form-control" id="exampleFormControlInput3" value="{{Auth::user()->email}}" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput4">Контактное лицо</label>
                    <input type="text" name="name" class="form-control" id="exampleFormControlInput4" value="{{Auth::user()->name}}" disabled>
                </div>
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <input type="submit"  class="btn btn-success" value="Сохранить">
                <a href="{{route('index')}}" class="btn btn-danger">Отменить</a>
            </form>
            @else
                <h4>Вы внесены в черный список</h4>
            @endif
        </div>
    </div>
</div>
@endsection
