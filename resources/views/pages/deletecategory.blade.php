@extends('layout.main')
@section('content')

    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Вы уверены что хотите удалить категорию: {{$data->name}}</h1>

        <form id="addCategoryForm" method="post" action="{{route('deleteCategory',['id'=>$data->id])}}" class="category-form">
            @csrf


            <input type="submit" class="submit-btn" value="Да"></input>
            <a style="text-align: center" href="{{route('admin')}}" class="submit-btn">Нет</a>
        </form>
    </div>
@endsection
