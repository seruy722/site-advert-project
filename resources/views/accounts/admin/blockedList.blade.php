@extends('layouts.app')
@section('userControlMenu')
@include('layouts.userControlMenu')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @isset($list)
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                </tr>
                @foreach ($list as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->surname}}</td>
                    <td> <a href="{{route('accounts.admin.edit',[$user->id,Auth::id()])}}" class="btn btn-warning">Редактировать</a> </td>
                    <td><a href="{{route('accounts.admin.unBloked',$user->id)}}" class="btn btn-danger">Удалить из черного списка</a></td>
                </tr>
                @endforeach
            </table>
            <div class="paging">{{$list->links()}}</div>
            @endisset
        </div>
    </div>
</div>
@endsection
