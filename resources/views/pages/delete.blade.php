@extends('layout.main')
@section('content')

    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Вы уверены что хотите удалить товар: {{$data->name}}</h1>

        <form id="addCategoryForm" method="post" action="{{route('deleteTovar',['id'=>$data->id])}}" class="category-form">
            @csrf


            <input type="submit" class="submit-btn" value="Да"></input>
            <a style="text-align: center" href="{{route('admin')}}" class="submit-btn">Нет</a>
        </form>
    </div>
@endsection
