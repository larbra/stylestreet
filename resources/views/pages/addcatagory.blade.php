@extends('layout.main')
@section('content')

    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Добавить категорию</h1>

        <form id="addCategoryForm" method="post" action="{{route('createCategory')}}" class="category-form">
            @csrf
            <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Название категории">
                @error('name')
                <p style="color: red">{{$message}}</p>
                @enderror
            </div>

            <input type="submit" class="submit-btn" value="Добавить"></input>
        </form>
    </div>
@endsection
