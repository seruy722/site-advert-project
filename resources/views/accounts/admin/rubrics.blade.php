@extends('layouts.app')
@section('userControlMenu')
    @include('layouts.userControlMenu')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('accounts.admin.rubrics')}}" method="POST">
                    {{ csrf_field() }}
          <table class="table table-striped add_input">
              <tr>
                  <th>Название</th>
                  <th>Количество статтей</th>
              </tr>
              
               @foreach ($rubrics as $item)
               <tr>
                    <td><input type="text" value="{{$item}}" name="rubrics[]" class="form-control"></td>
                    <td>
                            @isset($adverts)
                            @php $count = 0; @endphp
                            @foreach ($adverts as $elem)
                                @if ($elem->rubric == $item)
                                @php $count++; @endphp
                                @endif
                            @endforeach
                            @endisset
                            {{$count}}
                    </td>
                    
                </tr>
               @endforeach
            </table>
            <input type="submit" value="Сохранить" class="btn btn-success">
        </form>
        <div class="rubrics_btn"><button id="btn">Добавить</button></div>   
        </div>
    </div>
</div>
@endsection
