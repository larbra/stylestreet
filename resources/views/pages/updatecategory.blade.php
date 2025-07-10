@extends('layout.main')
@section('content')

    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Редактировать категорию: {{$data->name}}</h1>

        <form id="addCategoryForm" method="post" action="{{route('updateCategory',['id'=>$data->id])}}" class="category-form">
            @csrf
            <div class="form-group">
                <input type="text" id="name" name="name" value="{{$data->name}}" placeholder="Название категории">
                @error('name')
                <p style="color: red">{{$message}}</p>
                @enderror
            </div>

            <input type="submit" class="submit-btn" value="Редактировать"></input>
        </form>
    </div>
@endsection
