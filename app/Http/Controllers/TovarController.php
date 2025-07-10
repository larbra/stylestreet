<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Tovar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TovarController extends Controller
{

    public function showTovar($id)
    {
        $tovar = Tovar::with('images')->findOrFail($id);
        return view('pages.tovar', ['data' => $tovar]);
    }
    public function showCreateCategory()
    {
        $tovar = new Tovar;
        return view('pages.addcatagory');
    }
    public function catalog()
    {
        $tovars = Tovar::all(); // Получаем все товары
        $categories = Category::all(); // Получаем все категории

        return view('pages.catalog', [
            'data' => $tovars,
            'category' => $categories
        ]);
    }
    public function admin()
    {
        $tovars = Tovar::all(); // Получаем все товары
        $categories = Category::all(); // Получаем все категории

        return view('pages.admin', [
            'data' => $tovars,
            'category' => $categories
        ]);
    }

    public function createCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'min:3'],
        ], [
            'name.required' => 'Поле "Название категории" обязательно для заполнения',
            'name.min' => 'Название категории должно содержать минимум :min символа',
        ]);

        $category = Category::create([
            'name' => $validatedData['name']
        ]);

        return redirect()->route('admin');
    }
    public function showCreateTovar()
    {
        $category = Category::all();
        return view('pages.create', compact('category'))->with('success', 'Категория успешно добавлена!');
    }
    public function createTovar(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'min:10'],
            'category' => ['required'],
            'main_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ], [
            'name.required' => 'Поле "Название товара" обязательно для заполнения',
            'name.min' => 'Название должно содержать минимум :min символа',
            'name.max' => 'Название не должно превышать :max символов',

            'price.required' => 'Поле "Цена" обязательно для заполнения',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена должна быть не менее :min',

            'description.required' => 'Поле "Описание" обязательно для заполнения',
            'description.min' => 'Описание должно содержать минимум :min символов',

            'category.required' => 'Поле "Категория" обязательно для заполнения',

            'main_image.required' => 'Основное изображение обязательно для загрузки',
            'main_image.image' => 'Основное изображение должно быть изображением',
            'main_image.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif, svg, webp',
            'main_image.max' => 'Максимальный размер изображения :max КБ',

            'images.*.image' => 'Каждый файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif, svg, webp',
            'images.*.max' => 'Максимальный размер изображения :max КБ',
        ]);
        $mainImage = $request->file('main_image');
        $mainImageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
        $mainImage->storeAs('public/products', $mainImageName);

        $tovar = Tovar::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'category' => $validatedData['category'],
            'image' => $mainImageName,
        ]);

        if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/products', $imageName);

            ProductImage::create([
                'product_id' => $tovar->id,
                'image_path' => $imageName, // Только имя файла
            ]);
        }
    }

        return redirect()->route('admin')->with('success', 'Товар успешно добавлен!');
    }

    public function showDeleteTovar($id)
    {
        $tovar = Tovar::find($id);
        return view('pages.delete', ['data' => $tovar]);
    }
    public function showDeleteCategory($id)
    {
        $tovar = Category::find($id);
        return view('pages.deletecategory', ['data' => $tovar]);
    }

    public function deleteTovar(Request $request, $id)
    {
        Tovar::where('id', $id)->delete();
        return redirect()->route('admin')->with('success', 'Товар успешно удален!');
    }
    public function deleteCategory(Request $request, $id)
    {
        Category::where('id', $id)->delete();
        return redirect()->route('admin')->with('success', 'Категория успешно удалена!');
    }
    public function updateTovar(Request $request, $id)
    {

     $validatedData = $request->validate([
    'name' => ['required', 'string', 'min:3', 'max:255'],
    'price' => ['required', 'numeric', 'min:0'],
    'description' => ['required', 'string', 'min:10'],
    'category' => ['required'],
    'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
], [
    'name.required' => 'Поле "Название товара" обязательно для заполнения',
    'name.min' => 'Название должно содержать минимум :min символа',
    'name.max' => 'Название не должно превышать :max символов',

    'price.required' => 'Поле "Цена" обязательно для заполнения',
    'price.numeric' => 'Цена должна быть числом',
    'price.min' => 'Цена должна быть не менее :min',

    'description.required' => 'Поле "Описание" обязательно для заполнения',
    'description.min' => 'Описание должно содержать минимум :min символов',

    'category.required' => 'Поле "Категория" обязательно для заполнения',

    'image.required' => 'Изображение обязательно для загрузки',
    'image.image' => 'Файл должен быть изображением',
    'image.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif, svg, webp',
    'image.max' => 'Максимальный размер изображения :max КБ',
]);

$tovar = Tovar::findOrFail($id);

if ($request->hasFile('image')) {
    if ($tovar->image && Storage::disk('public')->exists('public/products/' . $tovar->image)) {
        Storage::disk('public')->delete('public/products/' . $tovar->image);
    }

    $filename = $request->file('image')->getClientOriginalName();
    $request->file('image')->storeAs('public/products', $filename, 'public');
    $validatedData['image'] = $filename;
}

$tovar->update([
    'name' => $validatedData['name'],
    'price' => $validatedData['price'],
    'description' => $validatedData['description'],
    'category' => $validatedData['category'],
    'image' => $validatedData['image'] ?? $tovar->image,
]);

return redirect()->route('admin')->with('success', 'Товар успешно обновлен!');
    }
    public function showUpdateTovar($id)
    {
        $date = Tovar::find($id);
        $category = Category::all();

        return view('pages.update', [
            'data' => $date,
            'category' => $category
        ]);
    }
    public function showUpdateCategory($id)
    {
        $date = Category::find($id);
        return view('pages.updatecategory', ['data' => $date]);
    }
    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            'name.required' => 'Поле "Название категории" обязательно для заполнения',
            'name.min' => 'Название категории должно содержать минимум :min символа',
        ]);
        $tovar = Tovar::findOrFail($id);
        $tovar->update([
            'name' => $validatedData['name'],
        ]);
        return redirect()->route('admin')->with('success', 'Категория успешно обновлена!');
    }
}
