<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Tovar;
use Illuminate\Http\Request;
use App\Models\User;
class CartController extends Controller
{
    public function add(Request $request, Tovar $product)
    {
        $cartItem = CartItem::firstOrNew([
            'user_id' => auth()->id(),
            'tovar_id' => $product->id
        ]);

        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Товар удален из корзины');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('tovar')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->tovar->price * $item->quantity;
        });

        return view('pages.cart', compact('cartItems', 'total'));
    }
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Проверяем, что товар принадлежит пользователю
        if ($cartItem->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        // Пересчитываем общую сумму корзины
        $total = auth()->user()->cartItems()->with('tovar')->get()->sum(function ($item) {
            return $item->tovar->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'cart_total' => $total
        ]);
    }
}
