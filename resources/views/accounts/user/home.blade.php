@extends('layouts.app')
@section('userControlMenu')
@include('layouts.userControlMenu')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(count($adverts)>0)
            <table class="table table-striped"> 
                <tr>
                    <th>Дата</th>
                    <th>Заголовок</th>
                    <th>Цена</th>
                    <th>Комментарии</th>
                </tr>
                @foreach ($adverts as $item)
                <tr>
                    @if (date('d',time())==date('d',strtotime($item->updated_at)))
                    <td>{{date('H:i',strtotime($item->updated_at))}}</td>
                    @else
                    <td>{{date('d M',strtotime($item->updated_at))}}</td>
                    @endif
                    <td>{{$item->title}}</td>
                    <td>{{$item->price}}грн.</td>
                    <td>
                        @isset($comments)
                        @php $count = 0; @endphp
                        @foreach ($comments as $elem)
                        @if ($elem->advert_id == $item->id)
                        @php $count++; @endphp
                        @endif
                        @endforeach
                        @endisset
                        {{$count}}
                    </td>
                    <td> <a href="{{route('edit',$item->id)}}" class="btn btn-warning">Редактировать</a> </td>
                    <td><a href="{{route('view',$item->id)}}" class="btn btn-info">Посмотреть</a></td>
                    <td><a href="{{route('destroy',[$item->id,Auth::id(),Auth::user()->role])}}" class="btn btn-danger">Удалить</a></td>
                </tr>
                @endforeach
            </table>
            @else
            <h3>Нет добавленных обьявлений!</h3>
            <a href="{{route('create')}}" class="btn btn-warning">+ СОЗДАТЬ ОБЬЯВЛЕНИЕ</a>
            @endif
            <div class="paging">{{$adverts->links()}}</div>
        </div>
    </div>
</div>
@endsection
