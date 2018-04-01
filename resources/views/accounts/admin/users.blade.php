@extends('layouts.app')
@section('userControlMenu')
    @include('layouts.userControlMenu')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <a href="{{route('accounts.admin.create')}}" class="btn btn-success">Новый пользователь</a>
            @isset($users)
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                    </tr>
                     @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->surname}}</td>
                    <td> <a href="{{route('accounts.admin.edit',[$user->id,Auth::id()])}}" class="btn btn-warning">Редактировать</a> </td>
                    <td><a href="{{route('accounts.admin.blocked',$user->id)}}" class="btn btn-info">В черный список</a></td>
                    <td><a href="{{route('accounts.admin.deleteUser',$user->id)}}" class="btn btn-danger">Удалить</a></td>
                    </tr>
                    @endforeach
                </table>
                <div class="paging">{{$users->links()}}</div>
            @endisset
            
        </div>
    </div>
</div>
@endsection
