@extends('layout.main')
@section('content')
    <div class="wrap categorycreate">
        <h1 style="margin-bottom: 50px">Добавить товар</h1>

        <form id="addCategoryForm" method="post" action="{{ route('createTovar') }}" enctype="multipart/form-data"
            class="category-form">
            @csrf
            <div class="form-group" style="display: flex; flex-direction: column; gap: 15px;">
                <label for="">Название товара:</label>
                <input type="text" id="name" name="name" placeholder="Название товара"
                    value="{{ old('name') }}">
                @error('name')
                    <p style="color: red">{{ $message }}</p>
                @enderror

                <label for="">Цена товара:</label>
                <input type="text" id="name" name="price" value="{{ old('price') }}" placeholder="Цена товара">
                @error('price')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <label for="">Категория товара:</label>
                <select name="category">
                    @foreach ($category as $cat)
                        <option class="" value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <label for="">Описание товара:</label>
                <textarea id="description" name="description" placeholder="Введите подробное описание товара...">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <div class="form-group file-upload">
                    <label for="image-upload" class="file-upload-label">
                        <span class="file-upload-icon">📁</span>
                        <span class="file-upload-text">Нажмите для загрузки основного изображения</span>
                        <input type="file" id="image-upload" class="file-upload-input" name="main_image" required>
                    </label>
                    <img id="image-preview" class="file-upload-preview" src="#" alt="Предпросмотр">
                </div>

                <div class="form-group file-upload">
                    <label for="additional-images" class="file-upload-label">
                        <span class="file-upload-icon">📁</span>
                        <span class="file-upload-text">Нажмите для загрузки дополнительных изображений (до 4)</span>
                        <input type="file" id="additional-images" class="file-upload-input" name="images[]" multiple>
                    </label>
                    <div id="additional-previews" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                    </div>
                </div>

                <input type="submit" class="submit-btn" value="Добавить">
            </div>
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

        document.getElementById('additional-images').addEventListener('change', function(e) {
            const previewsContainer = document.getElementById('additional-previews');
            previewsContainer.innerHTML = '';

            const files = e.target.files;
            const filesToShow = files.length > 4 ? Array.from(files).slice(0, 4) : files;

            Array.from(filesToShow).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const previewDiv = document.createElement('div');
                    previewDiv.style.position = 'relative';
                    previewDiv.style.width = '80px';
                    previewDiv.style.height = '80px';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '4px';
                    img.style.border = '1px solid #eee';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '×';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-5px';
                    removeBtn.style.right = '-5px';
                    removeBtn.style.background = '#ff4444';
                    removeBtn.style.color = 'white';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.width = '20px';
                    removeBtn.style.height = '20px';
                    removeBtn.style.cursor = 'pointer';

                    removeBtn.onclick = function() {
                        previewDiv.remove();
                    };

                    previewDiv.appendChild(img);
                    previewDiv.appendChild(removeBtn);
                    previewsContainer.appendChild(previewDiv);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
