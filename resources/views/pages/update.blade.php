@extends('layout.main')
@section('content')
    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Редактировать товар</h1>

        <form id="addCategoryForm" method="post" action="{{ route('updateTovar',['id'=>$data->id]) }}" enctype="multipart/form-data"
            class="category-form">
            @csrf
            <div class="form-group" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="text" id="name" name="name" placeholder="Название товара"
                    value="{{ $data->name }}">
                @error('name')
                    <p style="color: red">{{ $message }}</p>
                @enderror


                <input type="text" id="name" name="price" value="{{ $data->price }}" placeholder="Цена товара">
                @error('price')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <select name="category">

                    @foreach ($category as $cat)
                        <option class="" value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach

                </select>
                <textarea id="description" name="description" placeholder="Введите подробное описание товара...">{{ $data->description }}</textarea>
                @error('description')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <div class="form-group file-upload">
                    <label for="image-upload" class="file-upload-label">
                        <span class="file-upload-icon">📁</span>
                        <span class="file-upload-text">Нажмите для загрузки изображения</span>
                        <input type="file" id="image-upload" class="file-upload-input" name="image" ">
                            </label>
                            <img id="image-preview" class="file-upload-preview" src="#" alt="Предпросмотр">
                        </div>
                    </div>

                    <input type="submit" class="submit-btn" value="Добавить"></input>
                </form>
            </div>
            <script>
                document.getElementById('image-upload').addEventListener('change', function(e) {
                    const preview = document.getElementById('image-preview');
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }

                        reader.readAsDataURL(file);
                    } else {
                        preview.style.display = 'none';
                    }
                });
            </script>
@endsection
