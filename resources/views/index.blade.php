@extends('layouts.app')

@section('content')
<div class="container container_center">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <nav class="navbar navbar-light bg-light">
            <form class="form-inline" action="{{route('index')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="search_block"> 
                        <div>
                                <input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Поиск" name="search" autofocus>
                                <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Поиск</button>
                        </div>
                    </div>
                </form>
                @isset($rubrics)
                    <ul class="rubrics">
                        @foreach ($rubrics as $item)
                                <li><i class="material-icons md-36">category</i><a href="{{route('search',$item)}}">{{$item}}</a></li>
                        @endforeach
                    </ul>
                @endisset
                
            </nav>
            <div class="sort">
                    <span>Сортировать по цене:</span>
                    <a href="{{route('search','asc')}}">Возрастанию</a> ||
                    <a href="{{route('search','desc')}}">Убыванию</a>
                </div>
            @if (count($all)>0)
            @foreach ($all as $item)
            <div class="row main_row">   
                <div class="col-md-3 foto">
                        <a href="{{route('view',$item->id)}}"><img src="{{$item->image_names=='nofoto.jpg'?asset('images/nofoto.jpg'):asset('images/'.substr($item->image_names,0,strpos($item->image_names,',')))}}" class="main_foto img-thumbnail" alt="mainFoto"></a>    
                </div>
                <div class="col-md-7 middle_block">
                    <div>
                            <h4><a href="{{route('view',$item->id)}}" class="title">{{ $item->title }}</a></h4>
                            <div class="grey">Рубрика: {{$item->rubric}}</div>
                    </div>
                    <div>
                            <div class="region">Местоположение: {{$item->region}}</div>
                            @if (date('d',time())==date('d',strtotime($item->updated_at)))
                            <div class="grey">Сегодня: {{date('H:i',strtotime($item->updated_at))}}</div>
                            @else
                            <div class="grey">{{date('d M',strtotime($item->updated_at))}}</div>
                            @endif
                    </div>
                    
                </div>
                <div class="col-md-2 price">
                    <div>{{$item->price}} грн.</div>
                </div>
            </div>
            @endforeach
            @else
            <h3>Нет добавленных обьявлений!</h3>
            <a href="{{route('create')}}" class="btn btn-warning">+ СОЗДАТЬ ОБЬЯВЛЕНИЕ</a>
            @endif
            <div class="paging">{{$all->links()}}</div>
        </div>
    </div>
</div>
@endsection