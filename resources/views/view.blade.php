@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2 view_block">
            <div class="advert">
                
                        <div class="advert_image_view"><img src="{{$advert->image_names=='nofoto.jpg'?asset('images/nofoto.jpg'):asset('images/'.substr($advert->image_names,0,strpos($advert->image_names,',')))}}" alt="img"></div>
                        <h3>{{$advert->title}}
                            @auth
                                @if (Auth::user()->role=='admin')
                                <a href="{{route('destroy',[$advert->id,Auth::id()])}}" class="btn btn-danger">Удалить статью</a>
                                @endif
                            @endauth   
                        </h3>
                        <div class="advert_info1"><div><i class="material-icons">call</i> Телефон: {{$advert->phone}}</div><div>{{$advert->price}} грн.</div></div>
                        <div>
                            <hr>
                            <div class="advert_info">
                            <span>Добавлено: {{date('h:m, d M Y',strtotime($advert->updated_at))}} |</span>
                            <span>Местоположение: {{$advert->region}} |</span>
                            <span>Номер обьявления: {{$advert->id}} </span>
                        </div>
                            <hr>
                            <p class="advert_description">Описание: {{$advert->description}} </p>
                        </div>
                        <div >
                                @if ($arr = explode(',',$advert->image_names))
                                    @foreach ($arr as $item)
                                        <img src="{{asset('images/'.$item)}}" alt="img" class="view_img img-thumbnail">
                                    @endforeach
                                @endif
                            </div>
                            @isset($comments)
                            @foreach ($comments as $item)
                            <hr>
                            <div class="comment">
                            <h4>
                                <span>{{$item->user_name}}</span>
                                <span class="comment_date">{{date('d M Y',strtotime($advert->updated_at))}}</span>
                                @auth
                                    @if (Auth::user()->role=='admin' || Auth::id()==$advert->user_id)
                                    <a href="{{route('comment.destroy',['id'=>$item->id,'advert_id'=>$advert->id])}}" class="btn btn-danger">Удалить отзыв</a>
                                    @endif
                                @endauth
                            </h4>
                            
                        <p>{{$item->comment}}</p>
                            </div>
                            @endforeach
                            @endisset
                        </div>
                        @auth
                        @if (Auth::user()->blocked==false)
                        <form action="{{route('comment.create')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="description">Комментарий</label>
                            <textarea name="comment" class="form-control" id="description" cols="30" rows="10">{{old('comment')}}</textarea>
                            </div>
                            <input type="hidden" name="advert_id" value="{{$advert->id}}">
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </form>
                        <h3>Свяжитесь с автором объявления</h3>
                        <form action="{{route('emails.contact-mail')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="description">Текст сообщения</label>
                                <textarea name="message" class="form-control" id="description" cols="30" rows="10">{{old('message')}}</textarea>
                            </div>
                            <input type="hidden" name="advert_title" value="{{$advert->title}}">
                            <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                            <input type="hidden" name="advert_id" value="{{$advert->id}}">
                            <input type="hidden" name="user_id" value="{{$advert->user_id}}">
                            <button type="submit" class="btn btn-success">Отправить</button>
                        </form>
                        @endif
                        @endauth
   
            
        </div>
    </div>
</div>
@endsection